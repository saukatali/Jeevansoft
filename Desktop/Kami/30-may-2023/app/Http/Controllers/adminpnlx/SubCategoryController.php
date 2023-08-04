<?php

namespace App\Http\Controllers\adminpnlx;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Config;
use App\Models\Category;
use App\Models\SubCategory;

use Illuminate\Support\Facades\{DB, Session, Validator, Redirect, Auth, Hash, Str, Notification};
use Illuminate\Support\Facades\{URL, View, Response, Cookie, File, Mail, Blade, Cache, Http};

class SubCategoryController extends Controller
{
    public $modelName   = 'SubCategory';
    public function __construct(Request $request)
    {
        View()->Share('modelName', $this->modelName);
        $this->request = $request;
    }

    public function index(Request $request, $enmodelid)
    {
        $refModelId = '';
        if(!empty($enmodelid))
        {
            $refModelId = base64_decode($enmodelid);
        }
        $DB                        =     SubCategory::query();
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
                    $DB->where("sub_categories.name", 'LIKE', '%' . $fieldValue . '%');
                }
               
                if ($fieldName == "is_active") {
                    $DB->where("sub_categories.is_active", 'LIKE', '%' . $fieldValue . '%');
                }
                $searchVariable = array_merge($searchVariable, array($fieldName => $fieldValue));
            }
        }
        $DB->where('sub_categories.is_deleted', 0);
        $DB->where('sub_categories.category_id', $refModelId);
        $sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'sub_categories.created_at';
        $order  = ($request->input('order')) ? $request->input('order')   : 'DESC';
        $records_per_page  =   ($request->input('per_page')) ? $request->input('per_page') : Config("Reading.records_per_page");
        $results = $DB->orderBy($sortBy, $order)->paginate($records_per_page);
        $complete_string =  $request->query();
        unset($complete_string["sortBy"]);
        unset($complete_string["order"]);
        $query_string  =   http_build_query($complete_string);
        $results->appends($inputGet)->render();
     return View("adminpnlx.$this->modelName.index", compact('results', 'enmodelid', 'searchVariable', 'sortBy', 'order', 'query_string'));
    }


    public function create(Request $request, $enmodelid)
    {
        $modelId = '';
        if(!empty($enmodelid))
        {
            $modelId = base64_decode($enmodelid);
        }
        $modelDetails = SubCategory::where('is_active', 1)->where('is_deleted', 0)->get();
        return view('adminpnlx.' . $this->modelName . '.add', compact('modelDetails', 'enmodelid'));
        
    }


    public function store(Request $request, $enmodelid)
    {       
        $refModelId = '';
        if(!empty($enmodelid))
        {
            $refModelId = base64_decode($enmodelid);
        } 
        $formData = $request->all();
        $validator = Validator::make(
        $request->all(),
            array(
                'name'                       =>  'required',
                'image'                      =>  'required|mimes:jpeg,png,jpg',
            ),
            array(
                'name.required'              => 'The name field must be required',
                'image.required'             => 'The image field must be required',
                'image.mimes'                => 'The image field must be type .png .jpeg .jpg',
            )  
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {       

                $obj                            = new SubCategory;
                $obj->name                      = $request->input('name'); 
                $obj->category_id               = $refModelId;
                $obj->description               = $request->input('description');
               
                if($request->hasFile('image')){
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = time().'-image.'.$extension;
                    $folderName = strtoupper(date('M'). date('Y'))."/";
                    $folderPath = Config('constants.SUB_CATEGORY_IMAGE_ROOT_PATH').$folderName;
                    if(!File::exists($folderPath)) {
                        File::makeDirectory($folderPath, $mode = 0777,true);
                    }
                    if($request->file('image')->move($folderPath, $fileName)){
                    $image = $folderName.$fileName;
                    }
                    $obj->image = $image;
                }

            $obj->save();
            Session::flash('success', trans(Config('constants.SUB_CATEGORY.SUB_CATEGORY_TITLE') . " has been Added successfully"));
            return redirect()->route($this->modelName . '.index', $enmodelid);
        }
    }


    public function show($modelId, $enmodelid)
    {  
        
        $modelId = base64_decode($modelId);
        if ($modelIds) {
            $modelDetails = SubCategory::where('id', $modelId)->first();
            return view('adminpnlx.' . $this->modelName . '.view,', compact('modelDetails', 'enmodelid'));
        } else {
            return redirect::back();
        }
    }
    




    public function edit($id, $enmodelid)
    {
        $modelId = base64_decode($id);
        if ($modelId) {
            $modelDetails = SubCategory::where('id', $modelId)->first();
            if(!empty($modelDetails)){
                $categoryDetails = Category::all();
            }
            return view("adminpnlx." . $this->modelName . ".edit", compact('modelDetails', 'categoryDetails', 'enmodelid'));
        } else {
            return Redirect::back();
        }
    }





    public function update(Request $request, $id, $enmodelid)
    {
        $refModelId = '';
        if(!empty($refModelId))
        {
            $refModelId = base64_decode($enmodelid);
        } 

        $formData                = $request->all();
        $modelId                 = base64_decode($id);
        if (empty($modelId)) {
            return Redirect::back();
          }
            $model                  = SubCategory::find($modelId);
            $validator = Validator::make(
                $request->all(),
                array(
                    'name'                       =>  'required',
                    'image'                      =>  'nullable|mimes:jpeg,png,jpg',
                ),
                array(
                    'name.required'              => 'The name field must be required',
                    'image.mimes'                => 'The image field must be type .png .jpeg .jpg',
                )   
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {           
                $obj                            = $model;
                $obj->name                      = $request->input('name'); 
                // $obj->category_id               = $refModelId; 
                $obj->description               = $request->input('description');
               
                if($request->hasFile('image')){
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = time().'-image.'.$extension;
                    $folderName = strtoupper(date('M'). date('Y'))."/";
                    $folderPath = Config('constants.SUB_CATEGORY_IMAGE_ROOT_PATH').$folderName;
                    if(!File::exists($folderPath)) {
                        File::makeDirectory($folderPath, $mode = 0777,true);
                    }
                    if($request->file('image')->move($folderPath, $fileName)){
                    $image = $folderName.$fileName;
                    }
                    $obj->image = $image;
                }                
                $obj->save();
                Session::flash('success', trans(Config('constants.SUB_CATEGORY.SUB_CATEGORY_TITLE') . " has been updated successfully"));
                return Redirect::route($this->modelName . ".index", $enmodelid);
                
            }
        }






    public function destroy($id)
    {
       
        $modelId = base64_decode($id);
        if ($modelId) {
            SubCategory::where('id', $modelId)->delete();
            $statusMessage   =   trans(Config('constants.SUB_CATEGORY.SUB_CATEGORY_TITLE') . " has been deleted successfully");
            Session()->flash('flash_notice', $statusMessage);
        }
        return redirect::back();
    }





    public function changeStatus($modelId = 0, $status)
    {
        $modelId = base64_decode($modelId);
        if ($status == 1) {
            $statusMessage   =   trans(Config('constants.SUB_CATEGORY.SUB_CATEGORY_TITLE') ." has been deactivated successfully");
        } else {
            $statusMessage   =   trans(Config('constants.SUB_CATEGORY.SUB_CATEGORY_TITLE') ." has been activated successfully");

        }
        $user = SubCategory::findOrfail($modelId);
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


 } 