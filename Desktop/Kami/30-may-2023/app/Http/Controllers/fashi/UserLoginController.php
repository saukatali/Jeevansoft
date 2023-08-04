<?php

namespace App\Http\Controllers\fashi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Config;
use App\Models\User;
use App\Models\EmailAction;
use App\Models\EmailTemplate;

use Illuminate\Support\Facades\{DB, Session, Validator, Redirect, Auth, Hash, Str, Notification};
use Illuminate\Support\Facades\{URL, View, Response, Cookie, File, Mail, Blade, Cache, Http};

class UserLoginController extends Controller
{
    public $modelName = 'UserLogin';
    public function __construct(Request $request)
    {
        View()->Share('modelName', $this->modelName);

        $this->request = $request;
    }

    public function signup(Request $request)
    {
        if ($request->isMethod('post')) {
            $formData = $request->all();
            $validator = Validator::make(
                $request->all(),
                array(
                    'fname'               => 'required',
                    'lname'               => 'required',
                    'email'               => 'required|email',
                    'phone_number'        =>  'required',
                    'password'            => 'required',
                    'cpassword'           => 'required|same:password',
                    'image'               =>  'nullable',
                ),
                array(
                    'fname.required'      => 'The first name field is required',
                    'lname.required'      => 'The last name field is required',
                    'email.required'      => 'The email field is required',
                    'password.required'   => 'The password field is required',
                    'image.nullable'      => 'The image field is required',
                )
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                $obj                         = new User();
                $obj->fname                  = $request->input('fname');
                $obj->lname                  = $request->input('lname');
                $obj->name                   = ($obj->fname . ' ' . $obj->lname);
                $obj->email                  = $request->input('email');
                $obj->phone_number           = $request->input('phone_number');
                $obj->password               =  Hash::make($request->input('password'));
                if ($request->hasFile('image')) {
                    $folderName = strtoupper(date('M') . date('Y')) . "/";
                    $folderPath = Config('constants.USER_IMAGE_ROOT_PATH') . $folderName;
                    $image = $folderName . time() . '.' . $request->image->getClientOriginalExtension();
                    $uploadImg = $request->file('image')->move($folderPath, $image);
                    $obj->image = $image;
                }

                try {
                    $emailActions        =  EmailAction::where('action', '=', 'verified')->get()->toArray();
                    $emailTemplates        =  EmailTemplate::where('action', '=', 'verified')->get()->toArray();
                    $cons                 =  explode(',', $emailActions[0]['options']);
                    $constants             =  array();
                    foreach ($cons as $key => $val) {
                        $constants[]    = '{' . $val . '}';
                    }
                    $receiver_email        =      $obj->email;
                    $receiver_full_name    =      $obj->first_name;
                    $receiver_subject      =      $obj->description;
                    $receiver_message      =      $obj->description;

                    $replyMsg              =   $obj->description;
                    $subject               =   $emailTemplates[0]['subject'];

                    $rep_Array             =   array($receiver_email, $replyMsg, $receiver_subject, $receiver_message);
                    $messageBody           =   str_replace($constants, $rep_Array, $emailTemplates[0]['body']);
                    $settingsEmail         =   Config('jeevansoft.jeevansoft_email');
                    $this->sendMail($receiver_email, $receiver_full_name, $subject, $messageBody, $settingsEmail);
                    $obj->verification_code = '000000';
                    $obj->verification_code_sent_time = now();
                } catch (\Throwable $th) {
                    $obj->verification_code = '000000';
                    $obj->verification_code_sent_time = now();
                }

                $obj->save();
                $user = User::where('id', $obj->id)->first();
                $token = $user->createToken('fashi')->accessToken;
                Session::flash('success', trans(" User has been Register successfully"));
                return response()->json([
                    'status' => 'success',
                    'user_id' => base64_encode($obj->id),
                    'email' => $obj->email,
                    'page_redirect' => url('/'),
                    'message' => 'User has been Register successfully',
                    'token' => $token,
                ]);
            }
        }
        if (Auth::guard('users')->user()) {
            return redirect::route('Jeevan.index')
                ->withSuccess('You have Allready logged in');
        }
        return view('fashi.' . $this->modelName . '.signup');
    }



    public function verifyOtp(Request $request)
    {
        $formData = $request->all();
        $validator = Validator::make(
            $request->all(),
            array(
                // 'email'               => 'required|email',
                // 'password'            => 'required',
            ),
            array(
                // 'email.required'      => 'The email field is required',
                // 'password.required'   => 'The password field is required',

            )
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $user = User::where('id', base64_decode($request->user_id))->where('is_deleted', 0)->first();

            if ($user) {
                if ($user->verification_code == $request->user_otp) {
                    $user->is_verified = 1;
                    $user->is_approved = 1;
                    $user->save();
                    if ($request->type != 'forget_password') {
                        auth()->loginUsingId($user->id);
                        return response()->json([
                            'success' => true,
                            'message' => trans('messages.OTP has been verified successfully, you are logged in now'),
                            'data'      => 'true',
                        ]);
                    } else {
                        return response()->json(['success' => true, 'data' => 'modal', 'message' => trans('Otp has been verified successfully you can create your new password')]);
                    }
                } else {
                    return response()->json(['success' => false, 'message' => trans('Incorrect code please try again')]);
                }
            } else {
                return response()->json([
                    'success' => false,
                    'message' => trans('Something went wrong please try again')
                ]);
            }
        }
    }


    // public function login(Request $request)
    // {
    //     if ($request->isMethod('post')) {
    //         $formData = $request->all();
    //         $validator = Validator::make(
    //             $request->all(),
    //             array(
    //                 'email'            => 'required|exists:users',
    //                 'password'         => 'required',
    //             ),
    //             array(
    //                 'email.required'                => 'The email field must be required',
    //                 'password.required'             => 'The password field must be required',
    //             )
    //         );
    //         if ($validator->fails()) {
    //             $response["status"] = "error";
    //             $response["msg"] = trans("Email Or Password fields is required");
    //             return $response;
    //         } else {
    //             $email = $request->input('email');
    //             $password = $request->input('password');
    //             $userDetails = User::where('email', $email)->where('is_active', 1)->where('is_deleted', 0)->first();
    //             if (Auth::guard('users')->attempt(['email' => $email, 'password' => $password])) {
    //                 if (Auth::guard('users')->user()->is_active == 0) {
    //                     Auth::guard('users')->logout();
    //                     Session::flash('error', 'Your account is deactivated.Please contact to the admin.');
    //                     return redirect::route('UserLogin');
    //                 }
    //                 if (Auth::guard('users')->user()->is_verified == 0) {
    //                     Auth::guard('users')->logout();
    //                     try {
    //                         // $code = getOtp();
    //                         $emailActions        =  EmailAction::where('action', '=', 'verified')->get()->toArray();
    //                         $emailTemplates        =  EmailTemplate::where('action', '=', 'verified')->get()->toArray();
    //                         $cons                 =  explode(',', $emailActions[0]['options']);
    //                         $constants             =  array();
    //                         foreach ($cons as $key => $val) {
    //                             $constants[]    = '{' . $val . '}';
    //                         }
    //                         $receiver_email        =      $userDetails->email;
    //                         $receiver_full_name    =      $userDetails->first_name;
    //                         $receiver_subject      =      $userDetails->description;
    //                         $receiver_message      =      $userDetails->description;

    //                         $replyMsg              =   $userDetails->description;
    //                         $subject               =   $emailTemplates[0]['subject'];

    //                         $rep_Array             =   array($receiver_email, $replyMsg, $receiver_subject, $receiver_message);
    //                         $messageBody           =   str_replace($constants, $rep_Array, $emailTemplates[0]['body']);
    //                         $settingsEmail         =   Config('jeevansoft.jeevansoft_email');
    //                         $this->sendMail($receiver_email, $receiver_full_name, $subject, $messageBody, $settingsEmail);
    //                         $userDetails->verification_code = '000000';
    //                         $userDetails->verification_code_sent_time = now();
    //                         $userDetails->save();
    //                     } catch (\Throwable $th) {
    //                         $userDetails->verification_code = '000000';
    //                         $userDetails->verification_code_sent_time = now();
    //                         $userDetails->save();
    //                     }

                      
    //                     return response()->json([
    //                         'success'     => false,
    //                         'show_verify' => true,
    //                         'user_id'     => base64_encode($userDetails->id),
    //                         'user_email'  => $userDetails->email,
    //                         'message'     => 'Enter the code we have send via email to',
    //                     ]);
    //                 }
    //             Session::flash('success', trans("You have Successfully logged in"));
    //             return redirect::route('Jeevan.index');
    //             }else{
    //                 Session::flash('error', trans("You have password wrong"));
    //                 return redirect::route('UserLogin');
    //             }
    //         }
    //     }
    //     if (Auth::guard('users')->user()) {
    //         return redirect::route('Jeevan.index')
    //         ->withSuccess('You have Already logged in');
    //     }
    //     return view('fashi.' . $this->modelName . '.login');
    // }



    public function login(Request $request)
    {
        if ($request->isMethod('post')) {
            $formData = $request->all();
            $validator = Validator::make(
                $request->all(),
                array(
                    'email'     => 'required|email|exists:users',
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
                if (Auth::guard('users')->attempt(['email' => $email, 'password' => $password])) {
                    if (Auth::guard('users')->user()->is_active == 0) {
                        Auth::guard('users')->logout();
                        Session::flash('error', 'Your account is deactivated.Please contact to the admin.');
                        return redirect::route('Admin.login');
                    }
                    if (!Auth::guard('users')->user()->user_role_id == 1) {
                        Auth::guard('users')->logout();
                        Session::flash('error', 'Your account is deactivated.Please contact to the admin.');
                        return redirect::route('Admin.login')
                        ->withSuccess('Your account is deactivated.Please contact to the admin.');
                    }

                    return redirect::route('Jeevan.index')
                        ->withSuccess('You have Successfully logged in');
                }
                return redirect::route('UserLogin')
                    ->withError('Sorry! You have entered invalid credentials');
            }
        }
        if (Auth::guard('users')->user()) {
            return redirect::route('Jeevan.index')
                ->withSuccess('You have Already logged in');
        }
        return view('fashi.' . $this->modelName . '.login');
    }




    public function forgetPassword(Request $request)
    {
        if ($request->isMethod('post')) {
            $formData = $request->all();
            $validator = Validator::make(
                $request->all(),
                array(
                    'email'            => 'required|email|exists:users',
                ),
                array(
                    'email.required'   => 'The email field must be required',
                )
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                $result = User::where('email', $request->email)->first();
                $emailActions       =  EmailAction::where('action', '=', 'verified')->get()->toArray();
                $emailTemplates     =  EmailTemplate::where('action', '=', 'verified')->get()->toArray();
                $cons               =  explode(',', $emailActions[0]['options']);
                $constants          =  array();
                foreach ($cons as $key => $val) {
                    $constants[]    = '{' . $val . '}';
                }
                $receiver_email     =   $result->email;
                $receiver_full_name =   $result->first_name . ' ' . $result->last_name;
                $receiver_subject   =   $result->email;
                $receiver_message   =   $result->description;
                $replyMsg           =   $result->description;
                $subject            =   $emailTemplates[0]['subject'];

                $rep_Array          =    array($receiver_email, $replyMsg, $receiver_subject, $receiver_message);
                $messageBody        =    str_replace($constants, $rep_Array, $emailTemplates[0]['body']);
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
        Auth::guard('users')->logout();

        return Redirect::route('UserLogin');
    }
}
