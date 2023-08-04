<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Config;
use App\Models\User;
use Illuminate\Support\Facades\{DB, Session, Validator, Redirect, Auth, Hash};
use Illuminate\Support\Facades\{URL, View, Response, Cookie, File, Mail, Blade, Cache};
use Illuminate\Support\Str;


class UserApiController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $users = User::where('is_active', 1)->get();
        if ($users) {
            $data['status'] = '200';
            $data['message'] = 'Data found Successfully';
            $data['result'] = $users;
            return response()->json($data);
        } else {
            $data['status'] = '401';
            $data['message'] = 'Sorry ! Record not found!!!';
            return response()->json($data);
        }
    }


    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $formData = $request->all();
        $validator = Validator::make(
            $request->all(),
            array(
                'fname'     =>  'required',
                'lname'     =>  'required',
                'email'     =>  'required',
            ),
            array(
                'fname.required'   => 'The first name field is required',
                'lname.required'   => 'The last name field is required',
                'email.required'   => 'The email field is required',
            )
        );
        if ($validator->fails()) {
            $data['status'] = '401';
            $data['message'] = 'all field must be required';
            $data['result'] = $validator;
            return response()->json($data);
        } else {
            $obj                         = new User;
            $obj->fname                  = $request->input('fname');
            $obj->lname                  = $request->input('lname');
            $obj->name                   = ($obj->fname . ' ' . $obj->lname);
            $obj->email                  = $request->input('email');
            $obj->dial_code              = $request->input('dial_code');
            $obj->country_code           = $request->input('country_code');
            $obj->phone_number           = $request->input('phone_number');
            $obj->password               = Hash::make($request->input('password'));
            if ($request->hasFile('image')) {
                $folderName = strtoupper(date('M') . date('Y')) . "/";
                $folderPath = Config('constants.USER_IMAGE_ROOT_PATH') . $folderName;
                $image = $folderName . time() . '.' . $request->image->getClientOriginalExtension();
                $uploadImg = $request->file('image')->move($folderPath, $image);
                $obj->image = $image;
            }
            $obj->save();
            if ($obj->save()) {
                $data['status'] = '200';
                $data['message'] = 'Data Added Successfully';
                return response()->json($data);
            } else {
                $data['status'] = '401';
                $data['message'] = 'Sorry ! Something Wrong !!!';
                return response()->json($data);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function show(Request $request, $modelId = '')
    {
        $users = User::where('id', $modelId)->where('is_active', 1)->get();
        if ($users) {
            $data['status'] = '200';
            $data['message'] = 'Data found Successfully';
            $data['result'] = $users;
            return response()->json($data);
        } else {
            $data['status'] = '401';
            $data['message'] = 'Sorry ! Record not found!!!';
            return response()->json($data);
        }
    }


    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $modelId)
    {
       $model                    =    User::where('id', $modelId)->first();
        if (empty($model)) {
            $data['status'] = '401';
            $data['message'] = 'Data not found';
            return response()->json($data);
        }
        $formData                        =    $request->all();
        if (!empty($formData)) {
            $validator = Validator::make(
                $request->all(),
                array(
                    'fname'     =>  'required',
                    'lname'     =>  'required',
                    'email'     =>  'required',
                ),
                array(
                    'fname.required'   => 'The first name field is required',
                    'lname.required'   => 'The last name field is required',
                    'email.required'   => 'The email field is required',
                )
            );
            if ($validator->fails()) {
                $data['status'] = '401';
                $data['message'] = 'Data found error';
                $data['result'] = $validator;
                return response()->json($data);
            } 
            else {
                $obj                         = $model;
                $obj->fname                  = $request->input('fname');
                $obj->lname                  = $request->input('lname');
                $obj->name                   = ($obj->fname.' '.$obj->lname);
                $obj->email                  = $request->input('email');
                $obj->dial_code              = $request->input('dial_code');
                $obj->country_code           = $request->input('country_code');
                $obj->phone_number           = $request->input('phone_number');
                if ($request->hasFile('image')) {
                    $folderName = strtoupper(date('M') . date('Y')) . "/";
                    $folderPath = Config('constants.USER_IMAGE_ROOT_PATH') . $folderName;
                    $image = $folderName . time() . '.' . $request->image->getClientOriginalExtension();
                    $uploadImg = $request->file('image')->move($folderPath, $image);
                    $obj->image = $image;
                }
                $obj->save();
                if ($obj->save()) {
                    $data['status'] = '200';
                    $data['message'] = 'Data Update Successfully';
                    return response()->json($data);
                } else {
                    $data['status'] = '401';
                    $data['message'] = 'Sorry ! Something Wrong !!!';
                    return response()->json($data);
                }
                // Session::flash('success', trans($this->sectionNameSingular . " has been updated successfully"));
                // return Redirect::route($this->modelName . ".index");
            }
        }else{
            $data['status'] = '401';
            $data['message'] = 'all field must be required';
            return response()->json($data);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Blog  $blog
     * @return \Illuminate\Http\Response
     */
    public function delete(Request $request, $modelId)
    {   
        $user =  User::where('id', $modelId)->first();
        if (!empty($user)) {
            User::where('id', $modelId)->delete();
            $data['status'] = '200';
            $data['message'] = 'User has been deleted successfully';
            return response()->json($data);
        } else {
            $data['status'] = '401';
            $data['message'] = 'Sorry ! Something wrong Try Again';
            return response()->json($data);
        }
    }


    public function changeStatus($modelId = 0, $status = 0)
    {
        // $modelId = base64_decode($modelId);
        if ($status == 1) {
            $data['status'] = '200';
            $data['message'] = 'User has been deactivated successfully';
            // $statusMessage   =   trans($this->sectionName . " has been deactivated successfully");
        } else {
            $data['status'] = '200';
            $data['message'] = 'User has been activated successfully';
            // $statusMessage   =   trans($this->sectionName . " has been activated successfully");
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
        return response()->json($data);
    }


    public function prefrenceDetailSave(Request $request){
		
		$modelId		= 	Auth::guard('api')->user()->id;
		
		if($request->isMethod('post')){
			$formData	=	$request->all();
			$response	=	array();
			if(!empty($formData)){
				$request->replace($this->arrayStripTags($request->all()));
				$validator = Validator::make(
					$request->all(),
					array(
						'from_place' 					=> 'required',
						'to_place' 						=> 'required',
						'from_currency_type' 			=> 'required',
						'to_currency_type' 				=> 'required',
						'from_latitude' 				=> 'required',
						'from_longitude' 				=> 'required',
						'to_latitude' 					=> 'required',
						'to_longitude' 					=> 'required',
						'from_country_code' 			=> 'required',
						'to_country_code' 				=> 'required',
						'from_city' 					=> 'required',
						'from_country' 					=> 'required',
						'to_city' 						=> 'required',
						'to_country' 					=> 'required',
					),
					array(
						"from_place.required"			=> trans("messages.the_from_place_field_is_required"),
						"to_place.required"				=> trans("messages.the_to_place_field_is_required"),
						"from_currency_type.required"	=> trans("messages.the_from_currency_type_field_is_required"),
						"to_currency_type.required"		=> trans("messages.the_to_currency_type_field_is_required"),
						"from_latitude.required"		=> trans("messages.the_from_latitude_field_is_required"),
						"from_longitude.required"		=> trans("messages.the_from_longitude_field_is_required"),
						"to_latitude.required"			=> trans("messages.the_to_latitude_field_is_required"),
						"to_longitude.required"			=> trans("messages.the_to_longitude_field_is_required"),
						"from_country_code.required"	=> trans("messages.the_from_country_code_field_is_required"),
						"to_country_code.required"		=> trans("messages.the_to_country_code_field_is_required"),
						"from_city.required"			=> trans("messages.the_from_city_field_is_required"),
						"from_country.required"			=> trans("messages.the_from_country_field_is_required"),
						"to_city.required"				=> trans("messages.the_to_city_field_is_required"),
						"to_country.required"			=> trans("messages.the_to_country_field_is_required"),


					)
				);
				if ($validator->fails()){
					$response				=	$this->change_error_msg_layout($validator->errors()->getMessages());
				}else{
	
					$user_post                           	= new Prefrence();
					$user_post->user_id                     = $modelId;
					$user_post->from_place                	= $request->input('from_place');
					$user_post->to_place                	= $request->input('to_place');
					$user_post->from_currency_type          = $request->input('from_currency_type');
					$user_post->to_currency_type          	= $request->input('to_currency_type');
					$user_post->from_latitude          		= $request->input('from_latitude');
					$user_post->from_longitude          	= $request->input('from_longitude');
					$user_post->to_latitude          		= $request->input('to_latitude');
					$user_post->to_longitude          		= $request->input('to_longitude');
					$user_post->from_country_code          	= $request->input('from_country_code');
					$user_post->to_country_code          	= $request->input('to_country_code');
					$user_post->from_city          			= $request->input('from_city');
					$user_post->from_country          		= $request->input('from_country');
					$user_post->to_city          			= $request->input('to_city');
					$user_post->to_country          		= $request->input('to_country');
					$user_post->save();
	

					$recentPrefrence 	= 	Prefrence::where('user_id',$modelId)->where('is_deleted',0)->limit(5)->orderBy('prefrences.id','DESC')->get();
		            $allPrefrence 		= 	Prefrence::where('user_id',$modelId)->where('is_deleted',0)->orderBy('prefrences.id','DESC')->get();

					$response["status"]			    =	"success";
					$response["msg"]			    =	trans("prefrence_created_successfully");
					$response["recentPrefrence"]	=	$recentPrefrence;
					$response["allPrefrence"]		=	$allPrefrence;
				
					return json_encode($response,200);
				}
				$response["status"]				=	"error";
				$response["msg"]				=	trans("invalid_request");
				$response["data"]				=	(object)array();
				return json_encode($response);
			}
		}

		$recentPrefrence 				    	= 	Prefrence::where('user_id',$modelId)->where('is_deleted',0)->limit(5)->orderBy('prefrences.id','DESC')->get();
		$allPrefrence 							= 	Prefrence::where('user_id',$modelId)->where('is_deleted',0)->orderBy('prefrences.id','DESC')->get();

		$response["status"]						=	"success";
		$response["msg"]						=	trans("Prefrence Details");
		$response["recentPrefrence"]			=	$recentPrefrence;
		$response["allPrefrence"]				=	$allPrefrence;
		return json_encode($response,200);
				
		
	}



}
