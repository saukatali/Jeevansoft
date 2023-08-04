<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Config;
use App\Models\User;
use Illuminate\Foundation\Auth\User as Authenticatable;
use Illuminate\Support\Str;
use Illuminate\Contracts\Auth\MustVerifyEmail;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Notifications\Notifiable;
use Laravel\Passport\HasApiTokens;
use Illuminate\Support\Facades\{DB, Session, Validator, Redirect, Auth, Hash};
use Illuminate\Support\Facades\{URL, View, Response, Cookie, File, Mail, Blade, Cache};

class LoginApiController extends Controller
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
            $obj->name                   = ($obj->fname .' '. $obj->lname);
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
            $obj->save();
            $user = User::where('id', $obj->id)->first();
            // $token = $user->createToken('fashi')->accessToken;
            $token = $user->createToken('JEEVANSOFT Personal Access Client')->accessToken;
            Session::flash('success', trans($this->sectionNameSingular . " has been Added successfully"));
            return response()->json(['token' => $token], 200);
        }
    }
    if (Auth::check()) {
        return redirect::route('Jeevan.index')
            ->withSuccess('You have Allready logged in');
    }
   return view('fashi.'.$this->modelName.'.signup');
}




public function login(Request $request)
{
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
                $response["status"] = "error";
                $response["msg"] = trans("Email && password field is required.");
                return $response;
            } else {
                $email = $request->input('email');
                $password = $request->input('password');
                if (Auth::guard('api')->attempt(['email' => $email, 'password' => $password])) {
                    // dd(Auth::guard('api')->user());
                    if (Auth::guard('api')->user()->is_active == 0) {
                        Auth::guard('api')->logout();
                        $response["status"] = "error";
                        $response["msg"] = trans("Your account is deactivated.Please contact to the user.");
                        return $response;
                    }
                    if (!Auth::guard('api')->user()->user_role_id == 1) {
                        Auth::guard('api')->logout();
                        $response["status"] = "error";
                        $response["msg"] = trans("Your account is deactivated.Please valid user role.");
                        return $response;
                    }
                    $login_user = Auth::guard('api')->user();
                    // dd($login_user);
                    $fashi_token = $login_user->createToken('JEEVANSOFT Personal Access Client')->accessToken;
                    $compArr = [
                        'login_data' => $login_user,
                        'token' => $fashi_token,
                    ];

                    $response["status"] = "success";
                    $response["msg"] = trans("You have Successfully logged in.");
                    $response["data"] = $compArr;
                    return $response;
            }
            $response["status"] = "error";
            $response["msg"] = trans("Sorry! You have entered invalid credentials");
            return $response;
        }
    }





public function forgetPassword(Request $request)
{
    if ($request->isMethod('post')) {
        $formData = $request->all();
        $validator = Validator::make(
            $request->all(),
            array(
                'email' => 'required|email|exists:users',
            ),
            array(
                'email.required'             => 'The email field must be required',
            )
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $result = Admin::where('email', $request->email)->first();
            $emailActions       =  EmailAction::where('action','=','verified')->get()->toArray();
            $emailTemplates     =  EmailTemplate::where('action','=','verified')->get()->toArray();
            $cons               =  explode(',',$emailActions[0]['options']);
            $constants          =  array();
            foreach($cons as $key => $val){
                $constants[]    = '{'.$val.'}';
            }
            $receiver_email     =   $result->email;
            $receiver_full_name =   $result->first_name . ' ' . $result->last_name ;
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