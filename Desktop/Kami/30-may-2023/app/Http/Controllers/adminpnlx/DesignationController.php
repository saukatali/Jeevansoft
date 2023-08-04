<?php

namespace App\Http\Controllers\adminpnlx;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Config;
use App\Models\Department;
use App\Models\Designation;

use Illuminate\Support\Facades\{DB, Session, Validator, Redirect, Auth, Hash, Str, Notification};
use Illuminate\Support\Facades\{URL, View, Response, Cookie, File, Mail, Blade, Cache, Http};

class DesignationController extends Controller
{
    public $modelName   = 'Designation';
    public function __construct(Request $request)
    {
        View()->Share('modelName', $this->modelName);
        $this->request = $request;
    }

    public function index(Request $request, $enmodelid)
    {
        $modelId = '';
        if(!empty($enmodelid))
        {
            $modelId = base64_decode($enmodelid);
        }
        $DB                        =     Designation::query();
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
                    $DB->where("designations.name", 'LIKE', '%' . $fieldValue . '%');
                }
               
                if ($fieldName == "is_active") {
                    $DB->where("designations.is_active", 'LIKE', '%' . $fieldValue . '%');
                }
                $searchVariable = array_merge($searchVariable, array($fieldName => $fieldValue));
            }
        }
        $DB->where('designations.is_deleted', 0);
        $DB->where('designations.department_id', $modelId);
        $sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'designations.created_at';
        $order  = ($request->input('order')) ? $request->input('order')   : 'DESC';
        $records_per_page  =   ($request->input('per_page')) ? $request->input('per_page') : Config("Reading.records_per_page");
        $results = $DB->orderBy($sortBy, $order)->paginate($records_per_page);
        if($results){
            foreach($results as &$result){
                $result->department_name = Department::where('id', $result->department_id)->value('name');
            }
        }
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
        $modelDetails = Designation::where('is_active', 1)->where('is_deleted', 0)->get();
        return view('adminpnlx.' . $this->modelName . '.add', compact('modelDetails', 'enmodelid'));
        
    }


    public function store(Request $request, $enmodelid)
    {       
        $modelId = '';
        if(!empty($enmodelid))
        {
            $modelId = base64_decode($enmodelid);
        } 
        $formData = $request->all();
        $validator = Validator::make(
        $request->all(),
            array(
                'name'                       =>  'required',
            ),
            array(
                'name.required'              => 'The name field must be required',
            )  
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {       

                $obj                            = new Designation;
                $obj->name                      = $request->input('name'); 
                $obj->department_id             = $modelId;
                $obj->save();
            Session::flash('success', trans(Config('constants.SUB_CATEGORY.SUB_CATEGORY_TITLE') . " has been Added successfully"));
            return redirect()->route($this->modelName . '.index', $enmodelid);
        }
    }


    public function show($modelId, $enmodelid)

    {  
        $refModelId = '';
        if(!empty($refModelId))
        {
            $refModelId = base64_decode($enmodelid);
        } 

        $modelId = base64_decode($modelId);
        if ($modelIds) {
            $modelDetails = Designation::where('id', $modelId)->first();
            return view('adminpnlx.' . $this->modelName . '.view,', compact('modelDetails', 'enmodelid'));
        } else {
            return redirect::back();
        }
    }
    




    public function edit($id, $enmodelid)
    {
        $refModelId = '';
        if(!empty($refModelId))
        {
            $refModelId = base64_decode($enmodelid);
        } 

        $modelId = base64_decode($id);
        if ($modelId) {
            $modelDetails = Designation::where('id', $modelId)->first();
            return view("adminpnlx." . $this->modelName . ".edit", compact('modelDetails', 'enmodelid'));
        } else {
            return Redirect::back();
        }
    }





    public function update(Request $request, $id, $enmodelid)
    {
        $refModelId = '';
        if(!empty($enmodelid))
        {
            $refModelId = base64_decode($enmodelid);
        } 

        $modelId                = base64_decode($id);
        $model                  = Designation::findorFail($modelId);

        if (empty($model)) {
            return Redirect::back();
        }
        $formData                =    $request->all();
        if (!empty($formData)) {           
            $validator = Validator::make(
                $request->all(),
                array(
                    'name'                       =>  'required',
                ),
                array(
                    'name.required'              => 'The name field must be required',
                )   
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
             
                       
                $obj                            = $model;
                $obj->name                      = $request->input('name'); 
                // $obj->department_id             = $modelId; 
                $obj->save();
                Session::flash('success', trans(Config('constants.SUB_CATEGORY.SUB_CATEGORY_TITLE') . " has been updated successfully"));
                return Redirect::route($this->modelName . ".index", $enmodelid);
                
            }
        }

    }





    public function destroy($id)
    {
       
        $modelId = base64_decode($id);
        if ($modelId) {
            Designation::where('id', $modelId)->delete();
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
        $user = Designation::findOrfail($modelId);
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