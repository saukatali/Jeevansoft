<?php

namespace App\Http\Controllers;

use Illuminate\Foundation\Auth\Access\AuthorizesRequests;
use Illuminate\Foundation\Bus\DispatchesJobs;
use Illuminate\Foundation\Validation\ValidatesRequests;
use Illuminate\Routing\Controller as BaseController;
use Mail;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\Notification;

class Controller extends BaseController
{
    use AuthorizesRequests, DispatchesJobs, ValidatesRequests;


    public function __construct() {
		$url	=	Request::fullUrl();
	}
    // end function __construct()

	public function checkPermission($url){
		$segment1	=	Request()->segment(1);
		$segment2	=	Request()->segment(2);
		$segment3	=	Request()->segment(3);
		
		$segment1_1 = explode(' ', $segment1);
		$segment1_1 = end($segment1_1);
		$segment2_2 = explode(' ', $segment2);
		$segment2_2 = end($segment2_2);
		$segment3_3 = explode(' ', $segment3);
		$segment3_3 = end($segment3_3);
		
		if (in_array($segment1_1, $actions_arr) || in_array($segment2_2, $actions_arr) || in_array($segment3_3, $actions_arr)){
			return 1;
		}
		
		$user_id				=	Auth::user()->id;
		$user_role_id			=	Auth::user()->user_role_id;
		$path					=	Request()->path();
		$action					=	Route::current()->getAction();
		
		$function_name	=	explode("\\",$action['controller']);
		$function_name	=	end($function_name);
		$permissionData			=	DB::table("user_permission_actions")
											->select("user_permission_actions.is_active")
											->leftJoin("acl_admin_actions","acl_admin_actions.id","=","user_permission_actions.admin_module_action_id")
											->where('user_permission_actions.user_id',$user_id)
											->where('user_permission_actions.is_active',1)
											->where('acl_admin_actions.function_name',$function_name)
											->first();
		
		$byDefaultPermissionData = DB::table("acl_admin_actions")
		->where('acl_admin_actions.is_show',0)
		->where('acl_admin_actions.function_name',$function_name)
		->first();
		if(!empty($permissionData) || !empty($byDefaultPermissionData)){
			return 1;
		}else{
			return 0;
		}
	}

	public function buildTree($parentId = 0){
        $user_id	    =	Auth::guard('admins')->user()->id;
		$user_role_id	=	Auth::guard('admins')->user()->user_role_id;
		$branch         =   array();
		$elements       =   array();
		$superadmin = Config('constants.ROLE_ID.ADMIN_ROLE_ID');
		if($user_role_id == $superadmin){
			$elements = DB::table("acls")->where("parent_id", $parentId)
							->orderBy('acls.module_order','ASC')->get(); 
		}else {
			if($parentId == 0){
				$elements = DB::table("acls")
							->where("parent_id",$parentId)
							->where("acls.id",DB::raw("(select admin_module_id from user_permissions where user_permissions.admin_module_id = acls.id AND is_active = 1 AND user_id = $user_id LIMIT 1)"))
							->orderBy('acls.module_order','ASC')
							->get();
			}else{ 
				$elements = 	DB::table("acls")
								->where("parent_id",$parentId)
								->where("acls.id",DB::raw("(select admin_sub_module_id from user_permission_actions where user_permission_actions.admin_sub_module_id = acls.id AND is_active = 1 AND user_id = $user_id LIMIT 1)"))
								->orderBy('acls.module_order','ASC')
								->get();  
			}
		}

		foreach($elements as $element){
			if ($element->parent_id == $parentId){
				$children = $this->buildTree($element->id);
				if ($children){
					$element->children = $children;
				}
				$branch[] = $element;
			}
		}
		
		return $branch;
	}


    public function sendNotification($data)
    {
        Notification::create([
            'title'    => $data['title'],
            'body'     => $data['body'],
            'link'     => $data['link'],
            'not_from' => $data['from'],
            'not_to'   => $data['to'],
        ]);
    }



    public function sendMail($to, $fullName, $subject, $messageBody, $from = '', $files = false, $path = '', $attachmentName = '')
    {
        $from = Config('jeevansoft.jeevansoft_email');
        $data = array();
        $data['to'] = $to;
        $data['from'] = (!empty($from) ? $from : Config('jeevansoft.jeevansoft_email'));
        $data['fullName'] = $fullName;
        $data['subject'] = $subject;
        $data['filepath'] = $path;
        $data['attachmentName'] = $attachmentName;

        if ($files === false) {
            Mail::send('emails.template', array('messageBody' => $messageBody), function ($message) use ($data) {
                $message->to($data['to'], $data['fullName'])->from($data['from'])->subject($data['subject']);
            });
        } else {
            if ($attachmentName != '') {
                Mail::send('emails.template', array('messageBody' => $messageBody), function ($message) use ($data) {
                    $message->to($data['to'], $data['fullName'])->from($data['from'])->subject($data['subject'])->attach($data['filepath'], array('as' => $data['attachmentName']));
                });
            } else {
                Mail::send('emails.template', array('messageBody' => $messageBody), function ($message) use ($data) {
                    $message->to($data['to'], $data['fullName'])->from($data['from'])->subject($data['subject'])->attach($data['filepath']);
                });
            }
        }

        DB::table('email_logs')->insert(
            array(
                'email_to'     => $data['to'],
                'email_from'   => $from,
                'subject'      => $data['subject'],
                'message'      => $messageBody,
                'created_at'   => DB::raw('NOW()'),
            )
        );
    }
}
