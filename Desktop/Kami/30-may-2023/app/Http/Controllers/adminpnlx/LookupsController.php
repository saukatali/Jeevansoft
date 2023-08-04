<?php

namespace App\Http\Controllers\adminpnlx;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Config;
use App\Models\Lookup;
use Illuminate\Support\Facades\{DB, Session, Validator, Redirect, Auth, Hash};
use Illuminate\Support\Facades\{URL, View, Response, Cookie, File, Mail, Blade, Cache, Http, Str};

class LookupsController extends Controller
{
    public $modelName = 'LookupManager';
    public function __construct(Request $request)
    {
        View()->Share('modelName', $this->modelName);

        $this->request = $request;
    }

    public function index(Request $request, $type='')
    {
        if (empty($type)) {
            return Redirect()->route('dashboard');
        }

        $DB                        = Lookup::query();
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
                    $DB->where("lookups.code", 'LIKE', '%' . $fieldValue . '%');
                }
               
                if ($fieldName == "is_active") {
                    $DB->where("lookups.is_active", 'LIKE', '%' . $fieldValue . '%');
                }
                $searchVariable = array_merge($searchVariable, array($fieldName => $fieldValue));
            }
        }
        // $DB->where('lookups.is_deleted', 0);
        $DB->where('lookup_type', $type);
        $sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'lookups.created_at';
        $order  = ($request->input('order')) ? $request->input('order')   : 'DESC';
        $records_per_page  =   ($request->input('per_page')) ? $request->input('per_page') : Config("Reading.records_per_page");
        $results = $DB->orderBy($sortBy, $order)->paginate($records_per_page);
        $complete_string =  $request->query();
        unset($complete_string["sortBy"]);
        unset($complete_string["order"]);
        $query_string  =   http_build_query($complete_string);
        $results->appends($inputGet)->render();
     return View("adminpnlx.$this->modelName.index", compact('results', 'type', 'searchVariable', 'sortBy', 'order', 'query_string'));
    }


    public function create(Request $request, $type){
        if (empty($type)) {
            return Redirect()->route('dashboard');
        }
        return view('adminpnlx.' . $this->modelName . '.add', compact('type'));
        
    }


    public function store(Request $request, $type)
    {      
        if (empty($type)) {
            return Redirect()->route('dashboard');
        }   
        $formData = $request->all();
        $validator = Validator::make(
        $request->all(),
            array(
                'code'                       =>  'required',
            ),
            array(
                'code.required'              => 'The code field is required',
            )  
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {       

                $obj                         = new Lookup;
                $obj->code                   = $request->input('code'); 
                $obj->lookup_type            = $type;
                $obj->save();
            Session::flash('success', trans(ucfirst($type) . " has been Added successfully"));
            return redirect()->route($this->modelName . '.index', $type);
        }
    }




    public function edit($type='', $id)
    {
        if (empty($type)) {
            return Redirect()->route('dashboard');
        }  
        $modelId = base64_decode($id);
        if ($modelId) {
            $modelDetails = Lookup::where('id', $modelId)->first();
            return view("adminpnlx." . $this->modelName . ".edit", compact('modelDetails', 'type'));
        } else {
            return Redirect::back();
        }
    }


    public function update(Request $request, $type='', $id)
    {
        if (empty($type)) {
            return Redirect()->route('dashboard');
        }  
        $formData               = $request->all();
        $modelId                = base64_decode($id);
        $model                  = Lookup::findorFail($modelId);

        if (empty($model)) {
            return Redirect::back();
        }
        if (!empty($formData)) {           
            $validator = Validator::make(
                $request->all(),
                array(
                    'code'                       =>  'required',
                ),
                array(
                    'code.required'              => 'The code field is required',
                ) 
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
             
                       
                $obj                         = $model;
                $obj->code                   = $request->input('code'); 
                $obj->lookup_type            = $type;
                $obj->save();
                Session::flash('success', trans( ucfirst($type) .  " has been updated successfully"));
                return Redirect::route($this->modelName . ".index", $type);
                
            }
        }

    }
    public function delete($id, $type='')
    {
       
        $modelId = base64_decode($id);
        if ($modelId) {
            Lookup::where('id', $modelId)->delete();
            $statusMessage   =  trans(ucfirst($type)  ." has been deleted successfully");
            Session()->flash('flash_notice', $statusMessage);
        }
        return redirect::back();
    }


    public function changeStatus($modelId = 0, $status, $type='')
    {
        $modelId = base64_decode($modelId);
        if ($status == 1) {
            $statusMessage   =   trans(ucfirst($type) ." has been deactivated successfully");
        } else {
            $statusMessage   =  trans(ucfirst($type) ." has been activated successfully");
        }
        $user = Lookup::findOrfail($modelId);
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