<?php

namespace App\Http\Controllers\adminpnlx;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Config;
use App\Models\Product;

use Illuminate\Support\Facades\{DB, Session, Validator, Redirect, Auth, Hash, Str, Notification};
use Illuminate\Support\Facades\{URL, View, Response, Cookie, File, Mail, Blade, Cache, Http};
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\UserExport;
use App\Imports\UserImport;


class ProductController extends Controller
{
    public $modelName   = 'Product';
    public function __construct(Request $request)
    {
        View()->Share('modelName', $this->modelName);
        $this->request = $request;
    }

    public function index(Request $request)
    {
        $DB                        =     Product::query();
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
            foreach ($searchData as $fieldName => $fieldValue) {
                if ($fieldName == "name") {
                    $DB->where("products.name", 'LIKE', '%' . $fieldValue . '%');
                }
                if ($fieldName == "price") {
                    $DB->where("products.price", 'LIKE', '%' . $fieldValue . '%');
                }

                if ($fieldName == "is_active") {
                    $DB->where("products.is_active", 'LIKE', '%' . $fieldValue . '%');
                }
                $searchVariable = array_merge($searchVariable, array($fieldName => $fieldValue));
            }
        }
        $DB->where('products.is_deleted', 0);
        $sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'products.created_at';
        $order  = ($request->input('order')) ? $request->input('order')   : 'DESC';
        $records_per_page  =   ($request->input('per_page')) ? $request->input('per_page') : Config("Reading.records_per_page");
        $results = $DB->orderBy($sortBy, $order)->paginate($records_per_page);
        $complete_string =  $request->query();
        unset($complete_string["sortBy"]);
        unset($complete_string["order"]);
        $query_string  =   http_build_query($complete_string);
        $results->appends($inputGet)->render();
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
                'name'                       =>  'required',
                'price'                      =>  'required',
                'discount'                   =>  'required',
                'description'                =>  'required',
                'image'                      =>  'required|mimes:jpeg,png,jpg',
            ),
            array(
                'name.required'              => 'The name field must be required',
                'price.required'             => 'The email field must be required',
                'discount.required'          => 'The gender field must be required',
                'description.required'       => 'The description field must be required',
                'image.required'             => 'The image field must be required',
                'image.mimes'                => 'The image field must be type .png .jpeg .jpg',
            )  
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {       

                $obj                            = new Product;
                $obj->name                      = $request->input('name'); 
                $obj->price                     = $request->input('price');
                $obj->discount                  = $request->input('discount');
                $obj->quantity                  = $request->input('quantity');
                $obj->description               = $request->input('description');
               
                if($request->hasFile('image')){
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = time().'-image.'.$extension;
                    $folderName = strtoupper(date('M'). date('Y'))."/";
                    $folderPath = Config('constants.PRODUCT_IMAGE_ROOT_PATH').$folderName;
                    if(!File::exists($folderPath)) {
                        File::makeDirectory($folderPath, $mode = 0777,true);
                    }
                    if($request->file('image')->move($folderPath, $fileName)){
                    $image = $folderName.$fileName;
                    }
                    $obj->image = $image;
                }

            $obj->save();
            Session::flash('success', trans(Config('constants.PRODUCTS.PRODUCT_TITLE') . " has been Added successfully"));
            return redirect()->route($this->modelName . '.index');
        }
    }


    public function show($modelId)

    {  
        $modelId = base64_decode($modelId);
        if ($modelId) {
            $modelDetails = Product::where('id', $modelId)->first();
            return view('adminpnlx.' . $this->modelName . '.view', compact('modelDetails'));
        } else {
            return redirect::back();
        }
    }
    




    public function edit($id)
    {
        $modelId = base64_decode($id);
        if ($modelId) {
            $modelDetails = Product::where('id', $modelId)->first();
            return view("adminpnlx." . $this->modelName . ".edit", compact('modelDetails'));
        } else {
            return Redirect::back();
        }
    }





    public function update(Request $request, $id)
    {
        $modelId                = base64_decode($id);
        $model                  = Product::findorFail($modelId);

        if (empty($model)) {
            return Redirect::back();
        }
        $formData                =    $request->all();
        if (!empty($formData)) {           
            $validator = Validator::make(
                $request->all(),
                array(
                    'name'                       =>  'required',
                    'price'                      =>  'required',
                    'discount'                   =>  'required',
                    'description'                =>  'required',
                    'image'                      =>  'nullable|mimes:jpeg,png,jpg',
                ),
                array(
                    'name.required'              => 'The name field must be required',
                    'price.required'             => 'The email field must be required',
                    'discount.required'          => 'The gender field must be required',
                    'description.required'       => 'The description field must be required',
                    'image.mimes'                => 'The image field must be type .png .jpeg .jpg',
                )   
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
             
                       
                $obj                            = $model;
                $obj->name                      = $request->input('name'); 
                $obj->price                     = $request->input('price');
                $obj->discount                  = $request->input('discount');
                $obj->quantity                  = $request->input('quantity');
                $obj->description               = $request->input('description');
               
                if($request->hasFile('image')){
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = time().'-image.'.$extension;
                    $folderName = strtoupper(date('M'). date('Y'))."/";
                    $folderPath = Config('constants.PRODUCT_IMAGE_ROOT_PATH').$folderName;
                    if(!File::exists($folderPath)) {
                        File::makeDirectory($folderPath, $mode = 0777,true);
                    }
                    if($request->file('image')->move($folderPath, $fileName)){
                    $image = $folderName.$fileName;
                    }
                    $obj->image = $image;
                }

                $obj->save();
                Session::flash('success', trans(Config('constants.PRODUCTS.PRODUCT_TITLE') . " has been updated successfully"));
                return Redirect::route($this->modelName . ".index");
                
            }
        }

    }





    public function destroy($id)
    {
       
        $modelId = base64_decode($id);
        if ($modelId) {
            Product::where('id', $modelId)->delete();
            $statusMessage   =   trans(Config('constants.PRODUCTS.PRODUCT_TITLE') . " has been deleted successfully");
            Session()->flash('flash_notice', $statusMessage);
        }
        return redirect::back();
    }


    public function changeStatus($modelId = 0, $status)
    {
        $modelId = base64_decode($modelId);
        if ($status == 1) {
            $statusMessage   =   trans(Config('constants.PRODUCTS.PRODUCT_TITLE') ." has been deactivated successfully");
        } else {
            $statusMessage   =   trans(Config('constants.PRODUCTS.PRODUCT_TITLE') ." has been activated successfully");

        }
        $user = Product::findOrfail($modelId);
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

    public function deleteImage($enmodelid)
    {       
        $modelId = base64_decode($enmodelid);
        if ($modelId) {
           $modelImage =  Product::where('id', $modelId)->first();
            $modelImage->image = null;
            $modelImage->save();
            $statusMessage   =  trans(Config('constants.PRODUCTS.PRODUCT_TITLE') ."image has been deleted successfully");
            Session()->flash('flash_notice', $statusMessage);
        }
        return redirect::back();
    }






public function import(Request $request)
{
	return  View::make('adminpnlx.'.$this->modelName.'.import');
}




public function export(Request $request ,$id)
{		
	if($id == 'category'){
		       $data	=  DB::table('categories')->where("is_active",1)->pluck('name','id')->toArray();

	}elseif($id == 'sample'){
		$data  = [];
    }

	return Excel::download(new UserExport($data), $id.'.xlsx');
	
}




public function importList(Request $request,$slug){
	// dd($slug);
	$formData = $request->all();
	$validator   = Validator::make(
		$request->all(),
		[
			'file'           => 'required',
		],
		[
			'file.required'  => 'The file must be required',
		]
		);
	if($validator->fails()){
		return redirect()->back()->withErrors($validator, 'validator')->withInput();
	}
	$errors = [];
	$validated_data = [];
	$data = Excel::toArray(new UserImport, $request->file->store('temp'));
	foreach ($data as $info) {
		foreach ($info as $key => $value) {
		  
            Validator::extend('check_phone_number', function ($attribute, $value, $parameters,$validator) {
			    $getinfo        =   DB::table("users")->where("phone_number",$value)->where("is_active", 1)->first();
                if (empty($getinfo)) {
					$validator->addReplacer(
						'check_phone_number',
						function ($message, $attribute, $rule, $parameters) use ($value) {
							return str_replace('validation.check_phone_number', "incorrect Phone Number", $message);
						}
					);
					
                    return false;
                } else {
                    return true;
                }
            });


			Validator::extend('check_country', function ($attribute, $value, $parameters,$validator) {
				$getinfo        =   DB::table("countries")->where("name",$value)->where("status", 1)->first();
				// dd($getinfo);		
					if (empty($getinfo)) {
						$validator->addReplacer(
							'check_country',
							function ($message, $attribute, $rule, $parameters) use ($value) {
								return str_replace('validation.check_country', "incorrect country name", $message);
							}
						);
						
						return false;
					} else {
						return true;
					}
				});

				
			Validator::extend('check_state', function ($attribute, $value, $parameters,$validator) {
                $getinfo        =   DB::table("states")->where("name",$value)->where("status", 1)->first();
	
                if (empty($getinfo)) {
					$validator->addReplacer(
						'check_state',
						function ($message, $attribute, $rule, $parameters) use ($value) {
							return str_replace('validation.check_state', "incorrect state name", $message);
						}
					);
					
                    return false;
                } else {
                    return true;
                }
            });



		
			Validator::extend('school_dbn_no_check', function ($attribute, $value, $parameters,$validator) {

				$getinfo        = DB::table("schools")->where("is_active",1)->where("is_deleted",0)->where("school_code",$value)->first();

                if (empty($getinfo)) {
					$validator->addReplacer(
						'school_dbn_no_check',
						function ($message, $attribute, $rule, $parameters) use ($value) {
							if(empty($value)){
								return str_replace('validation.school_dbn_no_check', " The school dbn no field is required.", $message);
							}else{
								return str_replace('validation.school_dbn_no_check', "incorrect school dbn no", $message);
							}
						}
					);
					
                    return false;
                } else {
                    return true;
                }
            });

			$validator = Validator::make($value, [
				'name'             	=> 'required',
				'price'          	=> 'required',
				'discount'          => 'required',
				'quantity'          => 'required',
				'last_name'         => 'required',
				'email'            	=> 'required',
				'phone_number'      => 'nullable|check_phone_number',
			]);
			
			$validated_data[] = $value;
			if ($validator->fails()) {
				$errors[$key] = $validator->messages();
			}
		}
	}

	return view('admin.'.$this->modelName.'.import-data', [
		'errors'        => $errors,
		'import_data'   => $validated_data,
		'slug'   		=> $slug
	]);
	
}



    public function importListdata(Request $request,$id)
    {	
        $request->validate([
            'keys'   => 'required',
            'values' => 'required'
        ]);
        $data = [];
        $childs = [];
        if (count($request->keys) == count($request->values)) {
            foreach ($request->keys as $key => $value) {
                foreach ($value as $k => $v) {
                    if (in_array($v, ['country', 'state', 'subject', 'grade','school_plan','user_plan','school_dbn_no'])) {
                      
                        if ($v == 'subject') {
                            $child = explode(',', $request->values[$key][$k]);
							if ($child && count($child) > 0) {
								$relation        =   DB::table('dropdown_managers')->where('dropdown_type','subject-area')->where('is_active','1')->whereIn("name",$child)->pluck('id')->toArray();

								$data[$key][$v] = $relation;
							}
                        }
                        
						if ($v == 'country') {
							$relation        =   DB::table("countries")->where("name",$request->values[$key][$k])->where("status", 1)->value('id');
							$data[$key][$v] = $relation;
                        }

						if ($v == 'school_plan') {
							$relation        =   DB::table("subscription_plan")->where("title",$request->values[$key][$k])->where("is_active",1)->where("is_deleted",0)->where("type",3)->value('id');
							$data[$key][$v] = $relation;
                        }

						if ($v == 'user_plan') {
							$relation        =   DB::table("subscription_plan")->where("title",$request->values[$key][$k])->where("is_active",1)->where("is_deleted",0)->where("type",2)->value('id');
							$data[$key][$v] = $relation;
                        }


						if ($v == 'school_dbn_no') {
							$relation        =   DB::table("schools")->where("is_active",1)->where("is_deleted",0)->where("school_code",$request->values[$key][$k])->value('id');
							$data[$key][$v] = $relation;
                        }

						if ($v == 'state') {
							$relation        =    DB::table("states")->where("name",$request->values[$key][$k])->where("status", 1)->value('id');
							$data[$key][$v] = $relation;
                        }

						if ($v == 'grade') {
							$relation        =  DB::table('dropdown_managers')->where('dropdown_type','grade')->where('is_active','1')->where("name",$request->values[$key][$k])->value('id');
							$data[$key][$v] = $relation;
                        }
                    }else{

						if ($v == 'school_name') {
							$data[$key][$v] = $request->values[$key][$k];
                        }
						if ($v == 'school_codedbn') {
							$data[$key][$v] = $request->values[$key][$k];
                        }
						if ($v == 'first_name') {
							$data[$key][$v] = $request->values[$key][$k];
                        }
						if ($v == 'last_name') {
							$data[$key][$v] = $request->values[$key][$k];
                        }
						if ($v == 'email') {
							$data[$key][$v] = $request->values[$key][$k];
                        }
						if ($v == 'phone_number') {
							$data[$key][$v] = $request->values[$key][$k];
                        }
						if ($v == 'zip_code') {
							$data[$key][$v] = $request->values[$key][$k];
                        }
						if ($v == 'city') {
							$data[$key][$v] = $request->values[$key][$k];
                        }


					}
                }
            }
        }

			
        foreach ($data as $key => $info) {


            $school = School::create([
					'title'				=> $info['school_name'],
					'country'    		=> isset($info['country']) ? $info['country'] :'',
					'state'             => isset($info['state']) ? $info['state'] :'',
					'zip'              	=> isset($info['zip_code']) ? $info['zip_code'] :'',
					'school_code'       => $info['school_codedbn'],
					'city'              => isset($info['city']) ? $info['city'] :'',
					'is_active'         => 1,
				   
				]);
	
				$school_admin = User::create([
					'first_name'				=> $info['first_name'],
					'last_name'					=> $info['last_name'],
					'full_name'					=> $info['first_name'].' '.$info['last_name'],
					'validateString'			=> md5(time().$info['school_name']),
					'user_role_id'				=> 3,
					'email'						=> $info['email'],
					'phone_number'				=> isset($info['phone_number']) ? $info['phone_number'] :'',
					'country'    				=> isset($info['country']) ? $info['country'] :'',
					'state'             		=> isset($info['state']) ? $info['state'] :'',
					'zip'              			=> isset($info['zip_code']) ? $info['zip_code'] :'',
					'school_code'       		=> $info['school_codedbn'],
					'city'              		=> isset($info['city']) ? $info['city'] :'',
					'grade'         			=> isset($info['grade']) ? $info['grade'] :'',
					'school_id'         		=> $school->id,
				   
				]);	
			
            
        }
		Session::flash('flash_notice',  trans('Data imported successfully'));
		return Redirect::route($this->model.'.index',$id);
      
     
    }


 } 