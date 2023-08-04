<?php

use App\Models\Acl;
use  App\Models\Department;
use  App\Models\Designation;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use App\Model\User;
use App\Models\Language;
use App\Models\HomeUpdate;
use App\Models\HomeUpdateDescription;
use App\Models\AboutUpdate;
use App\Models\Review;
use App\Models\AboutUpdateDescription;
use App\Models\Lookup;
use GuzzleHttp\Psr7\MimeType;


if (!function_exists('lookbycode')) {
  function lookbycode($id = Null)
  {
    $lookVal = '';
    if (!empty($id)) {
      $lookVal = '';
      $lookVal = Lookup::where('id', '=', $id)->value('code');
    }
    return $lookVal;
  }
}

if (!function_exists('AclParnentByName')) {
  function AclparentByName($parentid = Null)
  {
    $parentidname = '';
    if (!empty($parentid)) {

      $parentidname = Acl::where('id', $parentid)->value('title');
      return $parentidname;
    }
  }
}

if (!function_exists('DepartmentbyName')) {
  function DepartmentbyName($Departid = Null)
  {
    $Departmentname = '';
    if (!empty($Departid)) {

      $Departmentname = Department::where('id', $Departid)->value('name');
      return $Departmentname;
    }
  }
}

if (!function_exists('DesignationbyName')) {
  function DesignationbyName($Desid = Null)
  {
    if (!empty($Desid)) {
      $Desginationname = '';
      $Desginationname = Designation::where('id', $Desid)->value('name');
      return $Desginationname;
    }
  }
}

function  addhttp($url = "")
{
  if ($url == "") {
    return "";
  }
  if (!preg_match("~^(?:f|ht)tps?://~i", $url)) {
    $url = "http://" . $url;
  }
  return $url;
}

function getUserPermission()
{
  $user_id        =  Auth::user()->id;
  $path          =  Request()->path();
  $admin_module_id    =  DB::table("acls")->where('path', $path)->pluck("id");

  $permissionData      =  DB::table("user_permission_actions")->leftJoin("acl_admin_actions", "acl_admin_actions.id", "=", "user_permission_actions.admin_module_action_id")->where('user_permission_actions.user_id', $user_id)->where('user_permission_actions.admin_sub_module_id', $admin_module_id)->where('user_permission_actions.is_active', 1)->where('acl_admin_actions.name', '!=', 'List')->select("user_permission_actions.is_active", "acl_admin_actions.type")->lists('acl_admin_actions.type', 'acl_admin_actions.type');

  return $permissionData;
  die;
}

function sideBarNavigation($menus)
{
  $website_url  = Config('constants.WEBSITE_URL');
  $treeView  =  "";
  $segment3  =  Request()->segment(2);
  $segment4  =  Request()->segment(2);
  $segment5  =  Request()->segment(3);
  $segment6  =  Request()->segment(4);

  if (!empty($menus)) {

    // dd($menus);
    $treeView  .=  "<ul class='menu-nav'>";
    foreach ($menus as $record) {
      // dd($menus);
      $currentSection  =  "";
      $currentPlugin  =  "";
      $plugin      =  explode('/', $record->path);
      $pluginSlug3  =  isset($plugin[1]) ? $plugin[1] : '';
      $myArray    =  [];
      $myArray1    =  [];
      if (!empty($record->children)) {
        $plugin_array  =  "";
        $plugin_array1  =  "";
        foreach ($record->children as $li_record) {
          $plugin      =  explode('/', $li_record->path);
          $slug      =  isset($plugin[0]) ? $plugin[0] : '';
          $slug1      =  isset($plugin[1]) ? $plugin[1] : '';
          $plugin_array   .=   "" . $slug . ",";
          $plugin_array1   .=   "" . $slug1 . ",";
        }
        $myArray = explode(',', $plugin_array);
        $myArray1 = explode(',', $plugin_array1);
      }
      $class = (in_array($segment3, $myArray1) && ($segment3 != '')) ? 'menu-item-open' : ''; #* 

      $classActive    =  ($pluginSlug3 == $segment3) ? "menu-item-active" : '';
      $style = (in_array($segment3, $myArray1) && ($segment3 != '')) ? 'display:block;' : 'display:none;';
      $classActive1 = "";


      $path  =  ((!empty($record->path) && ($record->path != 'javascript::void()') && ($record->path != 'javascript::void(0)') && ($record->path != 'javascript:void()') && ($record->path != 'javascript::void();') && ($record->path != 'javascript:void(0);')) ? URL($record->path) : 'javascript:void(0)');

      $second_icon  =  ((!empty($record->path) && ($record->path == 'javascript::void()') || ($record->path == 'javascript::void(0)') || ($record->path == 'javascript:void()') || ($record->path == 'javascript::void();') || ($record->path == 'javascript:void(0);')) ? 'menu-arrow' : '');


      if ((!empty($record->path) && ($record->path != 'javascript::void()') && ($record->path != 'javascript::void(0)'))) {
        $pluginData      =  explode('/', $record->path);
        $plugin        =  isset($pluginData[0]) ? $pluginData[0] : '';
        $plugin1      =  isset($pluginData[1]) ? $pluginData[1] : '';
        $classActive1    =  ((($plugin == $segment3 && ($plugin1 == "")) || ($plugin1 == $segment3) || ($plugin == $segment3 && ($plugin1 == "user-chat"))) ? 'menu-item-active' : '');
      }
      $treeView .= "<li class='menu-item menu-item-submenu  " . (!empty($record->children) ? 'menu-item-submenu ' . $class : ' ') . ' ' . $classActive1 . "' aria-haspopup='true' data-menu-toggle='hover'><a href='" . $path . "' class='menu-link menu-toggle'>" . "<span class='svg-icon menu-icon'>" . $record->icon . "</span><span class='menu-text'>$record->title</span><i class='" . $second_icon . "'></i></a>";

      if (!empty($record->children)) {
        $treeView  .= "<div class='menu-submenu'><i class='menu-arrow'></i><ul class='menu-subnav'><li class='menu-item menu-item-parent' aria-haspopup='true'>
          <span class='menu-link'>
            <span class='menu-text'>" . $record->title . "</span>
          </span>
          </li>";

        foreach ($record->children as $li_record) {

          $path  =  ((!empty($li_record->path) && ($li_record->path != 'javascript::void()') && ($li_record->path != 'javascript::void(0)') && ($li_record->path != 'javascript:void()') && ($li_record->path != 'javascript:void(0);')) ? URL($li_record->path) : 'javascript:void(0)');
          $second_icon  =  ((!empty($li_record->path) && ($li_record->path == 'javascript::void()') || ($li_record->path == 'javascript::void(0)') || ($li_record->path == 'javascript:void()') || ($li_record->path == 'javascript::void();') || ($li_record->path == 'javascript:void(0);')) ? 'fa fa-angle-left pull-right' : '');
          $plugin      =  explode('/', $li_record->path);
          $currentPlugin  =  isset($plugin[1]) ? $plugin[1] : '';

          $currentPlugin1  =  isset($plugin[2]) ? $plugin[2] : '';

          $currentPlugin2  =  isset($plugin[3]) ? $plugin[3] : '';

          $activeClass = "";

          if ((!empty($segment5) && $segment5 == $currentPlugin1 && $segment5 == 'Speaker') || (!empty($segment6) && $segment6 == $currentPlugin1 && $segment6 == 'Speaker')) {

            $activeClass =  "menu-item-active";
          } elseif ((!empty($segment5) && $segment5 == $currentPlugin1  && $segment5 == 'Assistant') ||  (!empty($segment6) && $segment6 == $currentPlugin1 && $segment6 == 'Assistant')) {
            $activeClass =  "menu-item-active";
          } elseif ($segment4 == 'lookups-manager') {
            if (!empty($segment5) && $segment4 == 'lookups-manager') {
            }
          } elseif ($segment4 == 'settings') {

            if ($currentPlugin2 == $segment6) {
              $activeClass =  "menu-item-active";
            } elseif ($currentPlugin2 == $segment6) {
              $activeClass =  "menu-item-active";
            } elseif ($currentPlugin2 == $segment6) {
              $activeClass =  "menu-item-active";
            }
          } else {
            if ($currentPlugin == $segment4 && $segment4 != 'settings' && $segment4 != 'lookups-manager' && $segment5 != 'Speaker' && $segment6 != 'Speaker' && $segment5 != 'Assistant' && $segment6 != 'Assistant')
              $activeClass =  "menu-item-active";
          }


          $treeView .= "<li class='menu-item " . $activeClass . "'  aria-haspopup='true'>
                <a href='" . $path . "' class='menu-link'>
                  <i class='menu-bullet menu-bullet-line'>
                    <span></span>
                  </i>
                  <span class='menu-text'>" . $li_record->title . "</span>
                </a>";
          if (!empty($li_record->children)) {
            $treeView  .= sideBarNavigation($li_record->children);
          }
          $treeView  .= "</li>";
        }
        $treeView  .= "</ul></div>";
      }
      $treeView  .= "</li>";
    }
    $treeView  .= "</ul>";
  }

  return $treeView;
}

function functionCheckPermission($function_name = "")
{
  if (Auth::guard('admin')->user()->id != 1) {


    $user_id          =  Auth::guard('admin')->user()->id;

    $permissionData      =  DB::table("user_permission_actions")
      ->select("user_permission_actions.is_active")
      ->leftJoin("acl_admin_actions", "acl_admin_actions.id", "=", "user_permission_actions.admin_module_action_id")
      ->where('user_permission_actions.user_id', $user_id)
      ->where('user_permission_actions.is_active', 1)
      ->where('acl_admin_actions.function_name', $function_name)
      ->first();

    if (!empty($permissionData)) {
      return 1;
    } else {
      return 0;
    }
  } else {
    return 1;
  }
}


function  getActiveLanguages()
{
  return DB::table("languages")->where('is_active', 1)->get();
}



function getDefaultLangCode()
{
  return session('default_language') ?? config('constants.DEFAULT_LANGUAGE.LANGUAGE_CODE') ?? config('app.fallback_locale') ?? app()->getLocale();
}

function getDefaultLangId()
{
  return DB::table('languages')->where('lang_code', getDefaultLangCode())->value('id');
}

function getRoleId($role)
{
  $role = ucwords($role);
  return config('constants.ROLE_ID.' . $role);
}

function getOtp()
{
  $key = random_int(0, 999999);
  return str_pad($key, 6, 0, STR_PAD_LEFT);
}

function contactReplyStatus()
{
  return [
    'Pending',
    'Opened',
    'Replied'
  ];
}

function genders()
{
  return [
    1 => 'Male',
    2 => 'Female',
    3 => 'Other'
  ];
}

function getApiDefaultLangId()
{
  $lang_code = app()->getLocale();
  return DB::table('languages')->where('lang_code', $lang_code)->value('id');
}


function getPropertyStatus()
{
  return ['Pending', 'Listed', 'Unlisted', 'Rejected'];
}

function getPropertyStatusAdmin()
{
  return [0 => 'Pending', 1 => 'Approve', 3 => 'Reject'];
}



function imageMimeTypes()
{
  return ['png', 'jpg', 'jpeg', 'webp'];
}

function videoMimeTypes()
{
  return ['mp4', 'mov', 'avi', 'webm', 'mkv'];
}

function getMimeType($file)
{
  $mime_type = MimeType::fromFilename($file);
  return  explode('/', $mime_type)[0] ?? false;
}



function feeTypes()
{
  return [
    '%',
    '$'
  ];
}

function currencies()
{
  return [
    1 => 'Dollar',
    2 => 'Euro',
    3 => 'Pound'
  ];
}

function encryptId($id)
{
  return base64_encode($id);
}

function decryptId($id)
{
  return base64_decode($id);
}



function reservationTypes()
{
  return [
    'airbnb'    => config('app.url').'public/img/homeaway.png',
    'jgvaction' => config('app.url').'public/img/jgvaction.png',
    'vrbo'      => config('app.url').'public/img/vrbo.png',
    'booking_com'=> config('app.url').'public/img/booking_com',
    'ical'      => config('app.url').'public/img/ical.png',
    'homeway'   => config('app.url').'public/img/homeaway.png',
    'trip-advisor'=> config('app.url').'public/img/trip-advisor.png',
  ];
}

function checkAuthJobs()
{     
    return DB::table('jobs')->where('user_id',Auth::user()->id)->where('is_open',1)->count();
}


function image_size_Get($bytes='')
{
  $size = filesize($bytes);
  $units = array( 'B', 'KB', 'MB', 'GB', 'TB', 'PB', 'EB', 'ZB', 'YB');
  $power = $size > 0 ? floor(log($size, 1024)) : 0;
  return number_format($size / pow(1024, $power), 2, '.', ',') . ' ' . $units[$power];
}

function isDate14DaysFromTodayGreaterThanToday($date, $time) {
  $dateTime = new DateTime($date . ' ' . $time);
  $today = new DateTime('today');
  $diff = $today->diff($dateTime)->days;
  return ($diff <= 14 && $diff >= 0) ? true : false;
}



function get_message_notification(){

  if(auth()->user()){
    if(DB::table('chats')->where("receiver_id",auth()->user()->id)->where("is_read",0)->exists()){
      $result = 1;
    }else{
      $result = 0;
    }
  }else{
    $result = 0;
  }
  return $result;
}




function get_notification(){

  if(auth()->user()){
    if(DB::table('notifications')->where("user_id",auth()->user()->id)->where("is_read",0)->exists()){
      $result = 1;
    }else{
      $result = 0;
    }
  }else{
    $result = 0;
  }
  return $result;
}



function getUserRating($booking_id,$property_id){
  $user_rating  = Review::where('reviews.is_active',1)->where('reviews.is_deleted',0)->where('review_by','user')->where('booking_id',$booking_id)
                    ->where('is_show',1)->where('property_id',$property_id)->sum('overall_rating');
    return $user_rating;              
}




function getcleanerRating($id = 0){
  $user_rating  = Review::where('reviews.is_active',1)->where("review_to",$id)->where('reviews.is_deleted',0)->where('review_by','host')->where('is_show',1)->avg('overall_rating');
  return $user_rating;         
}


function getcleanerRatingCount($id = 0){
  $user_rating  = Review::where('reviews.is_active',1)->where("review_to",$id)->where('reviews.is_deleted',0)->where('review_by','host')->where('is_show',1)->count();
  return $user_rating;         
}



 function setSettingTitle($slug)
  {
	  $setting_titles = DB::table('setting_titles')->where('slug', $slug)->first();
	  return $setting_titles;
  }

  function getSettingTitle($slug)
  {
	  $setting_titles = DB::table('setting_titles')->where('setting_titles.is_enable', 1)->where('slug', $slug)->first();
	  return $setting_titles;
  }
