<?php

namespace App\Http\Controllers\adminpnlx;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Config;
use App\Models\User;
use App\Models\EmailAction;
use App\Models\EmailTemplate;

use Illuminate\Support\Facades\{DB, Session, Validator, Redirect, Auth, Hash, Str, Notification};
use Illuminate\Support\Facades\{URL, View, Response, Cookie, File, Mail, Blade, Cache, Http};

class UserController extends Controller
{
    public $modelName   = 'User';
    public function __construct(Request $request)
    {
        View()->Share('modelName', $this->modelName);
        $this->request = $request;
    }

    public function index(Request $request)
    {
        $DB                        =     User::query();
        $searchVariable            =    array();
        $inputGet                  =    $request->all();
        if ($request->all()) {
            $searchData            =    $request->all();
            unset($searchData['display']);
            unset($searchData['_token']);
            if (isset($searchData['order'])) {
                unset($searchData['order']);
            }
            if (isset($searchData['sortBy'])) {
                unset($searchData['sortBy']);
            }

            if (isset($searchData['page'])) {
                unset($searchData['page']);
            }
            if ((!empty($searchData['date_from'])) && (!empty($searchData['date_to']))) {
                $dateS = $searchData['date_from'];
                $dateE = $searchData['date_to'];
                $DB->whereBetween('users.created_at', [$dateS . " 00:00:00", $dateE . " 23:59:59"]);
            } elseif (!empty($searchData['date_from'])) {
                $dateS = $searchData['date_from'];
                $DB->where('users.created_at', '>=', [$dateS . " 00:00:00"]);
            } elseif (!empty($searchData['date_to'])) {
                $dateE = $searchData['date_to'];
                $DB->where('users.created_at', '<=', [$dateE . " 00:00:00"]);
            }
            foreach ($searchData as $fieldName => $fieldValue) {
                if ($fieldName == "name") {
                    $DB->where("users.username", 'LIKE', "%".$fieldValue."%");
                }
                if ($fieldName == "email") {
                    $DB->where("users.email", 'LIKE', '%' . $fieldValue . '%');
                }
                if ($fieldName == "phone_number") {
                    $DB->where("users.phone_number", 'LIKE', '%' . $fieldValue . '%');
                }

                if ($fieldName == "is_active") {
                    $DB->where("users.is_active", 'LIKE', '%' . $fieldValue . '%');
                }
                $searchVariable = array_merge($searchVariable, array($fieldName => $fieldValue));
            }
        }
        $DB->where('users.user_role_id', 1);
        $DB->where('users.is_deleted', 0);
        $sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'users.created_at';
        $order  = ($request->input('order')) ? $request->input('order')   : 'DESC';
        $records_per_page  =   ($request->input('per_page')) ? $request->input('per_page') : Config("Reading.records_per_page");
        $results = $DB->orderBy($sortBy, $order)->paginate($records_per_page);
        Session::put('export_data_user', $results);

        $complete_string =  $request->query();
        unset($complete_string["sortBy"]);
        unset($complete_string["order"]);
        $query_string  =   http_build_query($complete_string);
        $results->appends($inputGet)->render();
        // dd($results);
     return View("adminpnlx.$this->modelName.index", compact('results', 'searchVariable', 'sortBy', 'order', 'query_string'));
    }


    public function create(){

        return view('adminpnlx.' . $this->modelName . '.add');

    }


    public function store(Request $request)
    {
        $formData = $request->all();
        $validator = Validator::make(
        $request->all(),
            array(
                'first_name'                       =>  'required',
                'last_name'                        =>  'required',
                'email'                            =>  'required|email|unique:users',
                'phone_number'                     =>  'required',
                'password'                         =>  'required',
                'confirm_password'                 =>  'same:password',
                'image'                            =>  'required|mimes:jpeg,png,jpg',
            ),
            array(
                'first_name.required'            => 'The first name field must be required',
                'last_name.required'             => 'The last name field must be required',
                'email.required'                 => 'The email field must be required',
                'phone_number.required'          => 'The phone number field must be required',
                'password.required'              => 'The password field must be required',
                'confirm_password.required'      => 'The confirm password field must be required',
                'image.required'                 => 'The image field must be required',
                'image.mimes'                    => 'The image field must be type .png .jpeg .jpg',
            )
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

                $obj                            = new User;
                $obj->first_name                = $request->input('first_name');
                $obj->last_name                 = $request->input('last_name');
                $obj->username                  =  $obj->first_name . $obj->last_name; 
                $obj->email                     = $request->input('email');
                $obj->phone_number              = $request->input('phone_number');
                $obj->gender                    = $request->input('gender');
                $obj->description               = $request->input('description');

                if($request->hasFile('image')){
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = time().'-image.'.$extension;
                    $folderName = strtoupper(date('M'). date('Y'))."/";
                    $folderPath = Config('constants.USER_IMAGE_ROOT_PATH').$folderName;
                    if(!File::exists($folderPath)) {
                        File::makeDirectory($folderPath, $mode = 0777,true);
                    }
                    if($request->file('image')->move($folderPath, $fileName)){
                    $image = $folderName.$fileName;
                    }
                    $obj->image = $image;
                }

            $obj->save();
            // $controller = new Controller();
            $type = 'Admin';
            $data = [
                'title' => trans("school_joining_invitation"),
                'body' => trans("Your_joining_request_school_has_been").' '.$type,
                'link' => 'https://www.google.com/',
                'from' => Auth::guard('admins')->user()->id,
                'to'   => $obj->id,
                ];
                $this->sendNotification($data);
                
            Session::flash('success', trans(Config('constants.USERS.USER_TITLE') . " has been Added successfully"));
            return redirect()->route($this->modelName . '.index');
        }
    }


    public function show($modelId)
    {
        $modelId = base64_decode($modelId);
        if ($modelId) {
            $modelDetails = User::where('id', $modelId)->first();
            return view('adminpnlx.' . $this->modelName . '.view', compact('modelDetails'));
        } else {
            return redirect::back();
        }
    }





    public function edit($id)
    {
        $modelId = base64_decode($id);
        if ($modelId) {
            $modelDetails = User::where('id', $modelId)->first();
            return view("adminpnlx." . $this->modelName . ".edit", compact('modelDetails'));
        } else {
            return Redirect::back();
        }
    }





    public function update(Request $request, $id)
    {
        $modelId                = base64_decode($id);
        $model                  = User::findorFail($modelId);

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
                $obj->gender                    = $request->input('gender');
                $obj->description               = $request->input('description');

                if($request->hasFile('image')){
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = time().'-image.'.$extension;
                    $folderName = strtoupper(date('M'). date('Y'))."/";
                    $folderPath = Config('constants.USER_IMAGE_ROOT_PATH').$folderName;
                    if(!File::exists($folderPath)) {
                        File::makeDirectory($folderPath, $mode = 0777,true);
                    }
                    if($request->file('image')->move($folderPath, $fileName)){
                    $image = $folderName.$fileName;
                    }
                    $obj->image = $image;
                }
                $obj->save();
                Session::flash('success', trans(Config('constants.USERS.USER_TITLE') . " has been updated successfully"));
                return Redirect::route($this->modelName . ".index");

            }
        }

    }





    public function destroy($id)
    {

        $modelId = base64_decode($id);
        if ($modelId) {
            User::where('id', $modelId)->delete();
            $statusMessage   =   trans(Config('constants.USERS.USER_TITLE') . " has been deleted successfully");
            Session()->flash('flash_notice', $statusMessage);
        }
        return redirect::back();
    }


    public function deleteImage($id)
    {
        $modelId = base64_decode($id);
        if ($modelId) {
           $modelImage =  User::where('id', $modelId)->first();
            $modelImage->image = null;
            $modelImage->save();
            $statusMessage   =   trans(Config('constants.USERS.USER_TITLE') . " has been image deleted successfully");
            Session()->flash('flash_notice', $statusMessage);
        }
        return redirect::back();
    }


    public function changeStatus($modelId = 0, $status)
    {
        $modelId = base64_decode($modelId);
        if ($status == 1) {
            $statusMessage   =   trans(Config('constants.USERS.USER_TITLE') ." has been deactivated successfully");
        } else {
            $statusMessage   =   trans(Config('constants.USERS.USER_TITLE') ." has been activated successfully");

        }
        $user = User::findOrfail($modelId);
        if ($user) {
            $currentStatus = $user->is_active;
            if (isset($currentStatus) && $currentStatus == 0) {
                $NewStatus = 1;
            } else {
                $NewStatus = 0;
            }
            $user->is_active = $NewStatus;
            $ResponseStatus = $user->save();
        }
        Session()->flash('flash_notice', $statusMessage);
        return back();
    }

    public function changedPassword(Request $request, $enuserid = null)
    {
        $modelId = '';
        if (!empty($enuserid)) {
            $modelId = base64_decode($enuserid);
        } else {
            return redirect()->route($this->modelName . ".index");
        }

        if ($request->isMethod('POST')) {
            if (!empty($modelId)) {
                $validated = $request->validate([
                    'new_password' => ['required'],
                    'confirm_password' => 'required|same:new_password',
                ]);
                $userDetails   =  User::where('id', $modelId)->first();
                $userDetails->password     =  Hash::make($request->new_password);
                $SavedResponse =  $userDetails->save();
                if (!$SavedResponse) {
                    Session()->flash('error', trans("Something went wrong."));
                    return Redirect()->back();
                }
                Session()->flash('success', trans("Password changed successfully."));
                return Redirect()->route($this->modelName . '.index');
            }

            
        }

        $modelDetails   =  User::where('id', $modelId)->first();
        return View("adminpnlx.$this->modelName.change_password", compact('modelDetails', 'enuserid'));
    }





    public function sendCredential(Request $request, $enuserid = null){
        $modelId = '';
        if (!empty($enuserid)) {
            $modelId = base64_decode($enuserid);
        } else {
            return redirect()->route($this->modelName . ".index");
        }

                $userDetails = User::where('id', $modelId)->first();
                $emailActions		=  EmailAction::where('action','=','verified')->get()->toArray();
				$emailTemplates		=  EmailTemplate::where('action','=','verified')->get()->toArray();

                $cons 				=  explode(',',$emailActions[0]['options']);
				$constants 			=  array();
				foreach($cons as $key => $val){
                    $constants[]    = '{'.$val.'}';
				}
				$receiver_email 	=  	$userDetails->email;
                $receiver_full_name	=  	$userDetails->first_name;
                $receiver_subject   =  	$userDetails->username;
                $receiver_message   =  	$userDetails->username;

				$replyMsg        	=  	$userDetails->username;
				$subject 			=   $emailTemplates[0]['subject'];

				$rep_Array 			=    array($receiver_email, $replyMsg, $receiver_subject, $receiver_message);
				$messageBody		=    str_replace($constants, $rep_Array, $emailTemplates[0]['body']);
				$settingsEmail      =   Config('jeevansoft.jeevansoft_email');
				$this->sendMail($receiver_email, $receiver_full_name, $subject, $messageBody, $settingsEmail);
                Session::flash('success', trans("Login credential send successfully"));
                return redirect()->back();
    }





    public function userExport(Request $request)
    {
        $output = "";
        $output .='
        <table border="1" id="example">
        <thead>
        <th style="width:230px"> First Name </th>
        <th style="width:130px"> Last Name </th>
        <th style="width:300px"> Email </th>
        <th style="width:300px"> Phone Number </th>
        <th style="width:100px"> Status </th>
        <th style="width:100px"> Added On </th>
        </thead>
        <tbody>';

        $customers_export = Session::get('export_data_user');
        if(empty($customers_export)){
            $table      = User::select('users.*')->get();

        }else{
            $table      = $customers_export;
        }

        $statusArr = ['1'=> 'Activated', '0'=>'Deactivated'];
        foreach($table as $key=>$excel_export)
        {
            $output .= '<tr style="height:100px">'.
                    '<td style="text-align:center; vertical-align: middle;">'.$excel_export->first_name.'</td>'.
                    '<td style="text-align:center; vertical-align: middle;">'.$excel_export->last_name.'</td>'.
                    '<td style="text-align:center; vertical-align: middle;">'.$excel_export->email.'</td>'.
                    '<td style="text-align:center; vertical-align: middle;">'.$excel_export->phone_number.'</td>'.
                    '<td style="text-align:center; vertical-align: middle;">'.$statusArr[$excel_export->is_active].'</td>'.
                    '<td style="text-align:center; vertical-align: middle;">'.
                     date(config("Reading.date_format"),strtotime($excel_export->created_at)) . '</td>'.
                  '</tr>';
        }
        $output .= '</tbody></table>';
        header("Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet");
        header("Content-Disposition: attachment; filename=User.xls");
        header("Cache-Control: max-age=0");
        echo $output;
    }



 }
