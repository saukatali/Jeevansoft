<?php

namespace App\Http\Controllers\adminpnlx;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Config;
use App\Models\Cart;
use App\Models\User;
use App\Models\ContactEnquiry;
use App\Models\Product;
use App\Models\Category;
use App\Models\EmailLog;
use App\Models\Admin;
use App\Models\Order;
use Illuminate\Support\Facades\{DB, Session, Validator, Redirect, Auth, Hash, Str};
use Illuminate\Support\Facades\{URL, View, Response, Cookie, File, Mail, Blade, Cache};


class DashboardController extends Controller
{
    public $modelName = 'Dashboard';
    public function __construct(Request $request)
    {
        View()->Share('modelName', $this->modelName);

        $this->request = $request;
    }


    public function showdashboard()
   {

      
         $totalCustmorers          =   DB::table("users")->where('is_active', 1)->where('is_deleted', 0)->count();
         $totalCategories         =   DB::table("categories")->where('is_active', 1)->where('is_deleted', 0)->count();
         $totalNewsArticles       =   DB::table("news_articles")->where('is_active', 1)->where('is_deleted', 0)->count();
         $totalCummunitySupport   =   DB::table("community_support")->where('is_active', 1)->where('is_deleted', 0)->count();
         $totalContentLibrary     =   DB::table("content_library_management")->where('is_active', 1)->where('is_deleted', 0)->count();


         $lastThreeCustomers   = User::where('is_active', 1)->where('is_deleted', 0)->orderBy('id', 'DESC')->take(3)->get();


         $month            =   date('m');
         $year             =   date('Y');

         for ($i = 0; $i < 12; $i++) {
            $months[]      =   date("Y-m", strtotime(date('Y-m-01') . " -$i months"));
         }
         $months           =   array_reverse($months);
         $num              =   0;

         $allCustomers     =   array();
         foreach ($months as $month) {

            $month_start_date   =   date('Y-m-01 00:00:00', strtotime($month));
            $month_end_date     =   date('Y-m-t 23:59:59', strtotime($month));
            $allCustomers[$num]['month']  =   strtotime($month_start_date) * 1000;
            $allCustomers[$num]['users']  =   DB::table('users')->where('user_role_id', 2)->where("is_deleted", 0)->where('created_at', '>=', $month_start_date)->where('created_at', '<=', $month_end_date)->count();
            $num++;
         }

      return  View('admin.dashboard.dashboard', compact('totalCustmorers', 'totalCategories', 'totalNewsArticles', 'totalCummunitySupport', 'totalContentLibrary', 'allCustomers', 'lastThreeCustomers'));
   }


    public function index(Request $request)
    {

        // $allCustomers        = User::where('is_active', 1)->where('is_deleted', 0)->get();
        $totalCustmorers           = User::where('is_active', 1)->where('is_deleted', 0)->count();
        $lastThreeCustomers        = User::where('is_active', 1)->where('is_deleted', 0)->orderBy('id', 'desc')->take('3')->get();
        $totalOrders               = Order::count();
        $totalContactEnquiry       = ContactEnquiry::where('is_active', 1)->where('is_deleted', 0)->count();
        $lastThreeContactEnquirys  = ContactEnquiry::where('is_active', 1)->where('is_deleted', 0)->orderBy('id', 'desc')->take('3')->get();
        $totalEmailLogs            = EmailLog::count();
        $month            =   date('m');
         $year             =   date('Y');

         for ($i = 0; $i < 12; $i++) {
            $months[]      =   date("Y-m", strtotime(date('Y-m-01') . " -$i months"));
         }
         $months           =   array_reverse($months);
         $num              =   0;

         $allCustomers     =   array();
         foreach ($months as $month) {
             $month_start_date   =   date('Y-m-01 00:00:00', strtotime($month));
             $month_end_date     =   date('Y-m-t 23:59:59', strtotime($month));
             $allCustomers[$num]['month']  =   strtotime($month_start_date) * 1000;
             $allCustomers[$num]['users']  =   DB::table('users')->where("is_deleted", 0)->where('created_at', '>=', $month_start_date)->where('created_at', '<=', $month_end_date)->count();
             $num++;
         }

        return view('adminpnlx.'. $this->modelName.'.dashboard', compact('allCustomers', 'lastThreeCustomers', 'lastThreeContactEnquirys', 
        'totalCustmorers', 'totalOrders', 'totalContactEnquiry', 'totalEmailLogs'));

    }

    
    public function myAccount(Request $request)
    {
      if ($request->isMethod('POST')) {
         $modelId                = Auth::guard('admins')->user()->id;
        $model                  = Admin::findorFail($modelId);

        if (empty($model)) {
            return Redirect::back();
        }
        $formData                =    $request->all();
        if (!empty($formData)) {
            $validator = Validator::make(
                $request->all(),
                array(
                    'first_name'                       =>  'required',
                    'last_name'                        =>  'required',
                    'email'                            =>  'required',
                    'phone_number'                     =>  'required',
                    'image'                            =>  'nullable|mimes:jpeg,png,jpg',
                ),
                array(
                    'first_name.required'            => 'The first name field must be required',
                    'last_name.required'             => 'The last name field must be required',
                    'email.required'                 => 'The email field must be required',
                    'phone_number.required'          => 'The phone number field must be required',
                    'image.mimes'                    => 'The image field must be type .png .jpeg .jpg',
                )
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {


                $obj                            = $model;
                $obj->first_name                = $request->input('first_name');
                $obj->last_name                 = $request->input('last_name');
                $obj->username                  = $obj->first_name .' '.$obj->last_name; 
                $obj->email                     = $request->input('email');
                $obj->phone_number              = $request->input('phone_number');

                if($request->hasFile('image')){
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = time().'-image.'.$extension;
                    $folderName = strtoupper(date('M'). date('Y'))."/";
                    $folderPath = Config('constants.STAFF_IMAGE_ROOT_PATH').$folderName;
                    if(!File::exists($folderPath)) {
                        File::makeDirectory($folderPath, $mode = 0777,true);
                    }
                    if($request->file('image')->move($folderPath, $fileName)){
                    $image = $folderName.$fileName;
                    }
                    $obj->image = $image;
                }
                $obj->save();
                Session::flash('success', trans("Admin has been updated successfully"));
                return Redirect::route('dashboard');

            }
        }

      }
        return view('adminpnlx.'.$this->modelName.'.myaccount');
    }



    
    public function changePassword(Request $request)
    {
       if ($request->isMethod('POST')) {
          $validated = $request->validate([
             'old_password' => 'required',
             'new_password' => ['required', 'string', 'min:8'],
             'confirm_password' => 'required|same:new_password',
          ]);

          $user = Admin::find(Auth::guard('admins')->user()->id);
          $password = $request->old_password;
          if (Hash::check($password, $user->getAuthPassword())) {
             $user->password = Hash::make($request->new_password);
             $user->save();
             return Redirect()->route('dashboard')
                ->with('success', 'Password changed successfully.');
          } else {
             return Redirect()->route('dashboard')
                ->with('error', 'Your old password is incorrect.');
          }
       }
       return  View("adminpnlx.$this->modelName.change_password");
    }


}