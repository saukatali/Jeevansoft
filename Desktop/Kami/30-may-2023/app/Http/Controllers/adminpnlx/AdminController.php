<?php

namespace App\Http\Controllers\adminpnlx;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Config;
use App\Models\Admin;
use App\Models\EmailAction;
use App\Models\EmailTemplate;

use Illuminate\Support\Facades\{DB, Session, Validator, Redirect, Auth, Hash, Str, Notification};
use Illuminate\Support\Facades\{URL, View, Response, Cookie, File, Mail, Blade, Cache, Http};

class AdminController extends Controller
{
    public $modelName = 'Admin';
    public function __construct(Request $request)
    {
        View()->Share('modelName', $this->modelName);

        $this->request = $request;
    }




    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $formData = $request->all();
            $validator = Validator::make(
                $request->all(),
                array(
                    'email'     => 'required|email|exists:admins',
                    'password'  => 'required',
                ),
                array(
                    'email.required'                => 'The email field must be required',
                    'password.required'             => 'The password field must be required',
                    )
                );
                if ($validator->fails()) {
                    return redirect()->back()->withErrors($validator)->withInput();
                } else {
                $email = $request->input('email');
                $password = $request->input('password');
                if (Auth::guard('admins')->attempt(['email' => $email, 'password' => $password])) {
                    if (Auth::guard('admins')->user()->is_active == 0) {
                        Auth::guard('admins')->logout();
                        Session::flash('error', 'Your account is deactivated.Please contact to the admin.');
                        return redirect::route('Admin.login');
                    }
                    if (!Auth::guard('admins')->user()->user_role_id == 1) {
                        Auth::guard('admins')->logout();
                        Session::flash('error', 'Your account is deactivated.Please contact to the admin.');
                        return redirect::route('Admin.login')
                        ->withSuccess('Your account is deactivated.Please contact to the admin.');
                    }

                    $admin_modules	=	$this->buildTree(0);
                    // dd($admin_modules);
					Session()->put('acls',$admin_modules);
                    return redirect::route('dashboard')
                        ->withSuccess('You have Successfully logged in');
                }
                return redirect::route('Admin.login')
                    ->withError('Sorry! You have entered invalid credentials');
            }
        }
        if (Auth::guard('admins')->user()) {
            return redirect::route('dashboard')
                ->withSuccess('You have Already logged in');
        }
        return view('adminpnlx.' . $this->modelName . '.login');
    }





    public function forgetPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $formData = $request->all();
            $validator = Validator::make(
                $request->all(),
                array(
                    'email' => 'required|email|exists:admins',
                ),
                array(
                    'email.required'             => 'The email field must be required',
                )
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                $result = Admin::where('email', $request->email)->first();
                $emailActions		=  EmailAction::where('action','=','verified')->get()->toArray();
				$emailTemplates		=  EmailTemplate::where('action','=','verified')->get()->toArray();
				$cons 				=  explode(',',$emailActions[0]['options']);
				$constants 			=  array();
				foreach($cons as $key => $val){
					$constants[]    = '{'.$val.'}';
				}
				$receiver_email 	=  	$result->email;
                $receiver_full_name	=  	$result->first_name . ' ' . $result->last_name ;
                $receiver_subject   =  	$result->email;
                $receiver_message   =  	$result->description;
				$replyMsg        	=  	$result->description;
				$subject 			=   $emailTemplates[0]['subject'];

				$rep_Array 			=    array($receiver_email, $replyMsg, $receiver_subject, $receiver_message);
				$messageBody		=    str_replace($constants, $rep_Array, $emailTemplates[0]['body']);
				// $settingsEmail      =    Config::get('Site.from_email');
				$settingsEmail      =    'noreply@obdemo.com';
				$this->sendMail($receiver_email, $receiver_full_name, $subject, $messageBody, $settingsEmail);
                return redirect()->back();
            }
        }

        return view('adminpnlx.' . $this->modelName . '.forget_password');
    }






    public function logout()
    {
        Auth::guard('admins')->logout();

        return Redirect::route('Admin.login');
    }
}
