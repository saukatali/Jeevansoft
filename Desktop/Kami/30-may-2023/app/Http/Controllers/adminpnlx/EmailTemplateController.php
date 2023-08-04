<?php

namespace App\Http\Controllers\adminpnlx;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Config;
use App\Models\EmailTemplate;

use Illuminate\Support\Facades\{DB, Session, Validator, Redirect, Auth, Hash, Str, Notification};
use Illuminate\Support\Facades\{URL, View, Response, Cookie, File, Mail, Blade, Cache, Http};

class EmailTemplateController extends Controller
{
    public $modelName   = 'EmailTemplate';
    public function __construct(Request $request)
    {
        View()->Share('modelName', $this->modelName);
        $this->request = $request;
    }

    public function index(Request $request)
    {
        $DB                        =     EmailTemplate::query();
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
                    $DB->where("email_templates.name", 'LIKE', '%' . $fieldValue . '%');
                }
                if ($fieldName == "subject") {
                    $DB->where("email_templates.subject", 'LIKE', '%' . $fieldValue . '%');
                }

                if ($fieldName == "is_active") {
                    $DB->where("email_templates.is_active", 'LIKE', '%' . $fieldValue . '%');
                }
                $searchVariable = array_merge($searchVariable, array($fieldName => $fieldValue));
            }
        }
        $sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'email_templates.created_at';
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
                'name'                            =>  'required',
                'subject'                         =>  'required',
                'action'                          =>  'required',
                'body'                            =>  'required',
            ),
            array(
                'name.required'                    => 'The name field must be required',
                'subject.required'                 => 'The subject field must be required',
                'action.required'                  => 'The action field must be required',
                'body.required'                    => 'The body field must be required',
            )  
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {       

                $obj                            = new EmailTemplate;
                $obj->name                      = $request->input('name'); 
                $obj->subject                   = $request->input('subject');
                $obj->action                    = $request->input('action');
                $obj->body                      = $request->input('body');
               
                $obj->save();
            Session::flash('success', trans(Config('constants.EMAIL_TEMPLATES.EMAIL_TEMPLATE_TITLE') . " has been Added successfully"));
            return redirect()->route($this->modelName . '.index');
        }
    }


    public function show($modelId)

    {  
        $modelId = base64_decode($modelId);
        if ($modelId) {
            $modelDetails = EmailTemplate::where('id', $modelId)->first();
            return view('adminpnlx.' . $this->modelName . '.view', compact('modelDetails'));
        } else {
            return redirect::back();
        }
    }
    




    public function edit($id)
    {
        $modelId = base64_decode($id);
        if ($modelId) {
            $modelDetails = EmailTemplate::where('id', $modelId)->first();
            return view("adminpnlx." . $this->modelName . ".edit", compact('modelDetails'));
        } else {
            return Redirect::back();
        }
    }





    public function update(Request $request, $id)
    {
        $modelId                = base64_decode($id);
        $model                  = EmailTemplate::findorFail($modelId);

        if (empty($model)) {
            return Redirect::back();
        }
        $formData                =    $request->all();
        if (!empty($formData)) {           
            $validator = Validator::make(
                $request->all(),
                array(
                    'name'                            =>  'required',
                    'subject'                         =>  'required',
                    'action'                          =>  'required',
                    'body'                            =>  'required',
                ),
                array(
                    'name.required'                    => 'The name field must be required',
                    'subject.required'                 => 'The subject field must be required',
                    'action.required'                  => 'The constants field must be required',
                    'body.required'                    => 'The body field must be required',
                ) 
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
             
                       
                $obj                            = $model;
                $obj->name                      = $request->input('name'); 
                $obj->subject                   = $request->input('subject');
                $obj->action                    = $request->input('action');
                $obj->body                      = $request->input('body');
                $obj->save();
                Session::flash('success', trans(Config('constants.EmailTemplate.EMAIL_TEMPLATE_TITLE') . " has been updated successfully"));
                return Redirect::route($this->modelName . ".index");
                
            }
        }

    }





    public function destroy($id)
    {
       
        $modelId = base64_decode($id);
        if ($modelId) {
            EmailTemplate::where('id', $modelId)->delete();
            $statusMessage   =   trans(Config('constants.EmailTemplate.EMAIL_TEMPLATE_TITLE') . " has been deleted successfully");
            Session()->flash('flash_notice', $statusMessage);
        }
        return redirect::back();
    }




 } 