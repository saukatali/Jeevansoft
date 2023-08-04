<?php

namespace App\Http\Controllers\adminpnlx;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Config;
use App\Models\Size;
use Illuminate\Support\Facades\{DB, Session, Validator, Redirect, Auth, Hash};
use Illuminate\Support\Facades\{URL, View, Response, Cookie, File, Mail, Blade, Cache, Http, Str};

class SizeController extends Controller
{
    public $modelName = 'Size';
    public function __construct(Request $request)
    {
        View()->Share('modelName', $this->modelName);

        $this->request = $request;
    }

    public function index(Request $request)
    {
        $DB                        = Size::query();
        $searchVariable            = array();
        $inputGet                  = $request->all();
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
                    $DB->where("sizes.name", 'LIKE', '%' . $fieldValue . '%');
                }
               
                if ($fieldName == "is_active") {
                    $DB->where("sizes.is_active", 'LIKE', '%' . $fieldValue . '%');
                }
                $searchVariable = array_merge($searchVariable, array($fieldName => $fieldValue));
            }
        }
        $DB->where('sizes.is_deleted', 0);
        $sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'sizes.created_at';
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
                'image'                      =>  'required',
            ),
            array(
                'name.required'              => 'The name field is required',
                'image.required'             => 'The image field is required',
            )  
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {       

                $obj                         = new Size;
                $obj->name                   = $request->input('name'); 
                $obj->description            = $request->input('description');
                
                if ($request->hasFile('image')) {
                $folderName = strtoupper(date('M') . date('Y')) . "/";
                $folderPath = Config('constants.SIZE_IMAGE_ROOT_PATH') . $folderName;
                $image = $folderName . time() . '.' . $request->image->getClientOriginalExtension();
                $uploadImg = $request->file('image')->move($folderPath, $image);
                $obj->image = $image;
            }
          
            $obj->save();
            Session::flash('success', trans(Config('constants.SIZES.SIZE_TITLE') . " has been Added successfully"));
            return redirect()->route($this->modelName . '.index');
        }
    }


    public function show($modelId)
    {  
        $modelId = base64_decode($modelId);
        if ($modelId) {
            $modelDetails = Size::where('id', $modelId)->first();
            return view('adminpnlx.' . $this->modelName . '.view', compact('modelDetails'));
        } else {
            return redirect::back();
        }
    }
    
    public function edit($id)
    {
        $modelId = base64_decode($id);
        if ($modelId) {
            $model = Size::where('id', $modelId)->first();
            return view("adminpnlx." . $this->modelName . ".edit", compact('model'));
        } else {
            return Redirect::back();
        }
    }


    public function update(Request $request, $id)
    {
        $formData               = $request->all();
        $modelId                = base64_decode($id);
        $model                  = Size::findorFail($modelId);

        if (empty($model)) {
            return Redirect::back();
        }
        if (!empty($formData)) {           
            $validator = Validator::make(
                $request->all(),
                array(
                    'name'                       =>  'required',
                    'image'                      =>  'nullable',
                ),
                array(
                    'name.required'              => 'The name field is required',
                    // 'image.required'             => 'The image field is required',
                ) 
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
             
                       
                $obj                         = $model;
                $obj->name                   = $request->input('name'); 
                $obj->description            = $request->input('description');

                if ($request->hasFile('image')) {
                    $folderName = strtoupper(date('M') . date('Y')) . "/";
                    $folderPath = Config('constants.SIZE_IMAGE_ROOT_PATH') . $folderName;
                    $image = $folderName . time() . '.' . $request->image->getClientOriginalExtension();
                    $uploadImg = $request->file('image')->move($folderPath, $image);
                    $obj->image = $image;
                }
                $obj->save();
                Session::flash('success', trans(Config('constants.SIZES.SIZE_TITLE') . " has been updated successfully"));
                return Redirect::route($this->modelName . ".index");
                
            }
        }

    }
    public function delete($id)
    {
       
        $modelId = base64_decode($id);
        if ($modelId) {
            Size::where('id', $modelId)->delete();
            $statusMessage   =  trans(Config('constants.SIZES.SIZE_TITLE') ." has been deleted successfully");
            Session()->flash('flash_notice', $statusMessage);
        }
        return redirect::back();
    }


    public function changeStatus($modelId = 0, $status)
    {
        $modelId = base64_decode($modelId);
        if ($status == 1) {
            $statusMessage   =   trans(Config('constants.SIZES.SIZE_TITLE') ." has been deactivated successfully");
        } else {
            $statusMessage   =  trans(Config('constants.SIZES.SIZE_TITLE') ." has been activated successfully");
        }
        $user = Size::findOrfail($modelId);
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
           $modelImage =  Size::where('id', $modelId)->first();
            $modelImage->image = null;
            $modelImage->save();
            $statusMessage   =  trans(Config('constants.SIZES.SIZE_TITLE') ."image has been deleted successfully");
            Session()->flash('flash_notice', $statusMessage);
        }
        return redirect::back();
    }

 } 