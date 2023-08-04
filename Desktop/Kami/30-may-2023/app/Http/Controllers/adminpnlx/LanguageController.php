<?php

namespace App\Http\Controllers\adminpnlx;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Config;
use App\Models\Language;

use Illuminate\Support\Facades\{DB, Session, Validator, Redirect, Auth, Hash, Str, Notification};
use Illuminate\Support\Facades\{URL, View, Response, Cookie, File, Mail, Blade, Cache, Http};

class LanguageController extends Controller
{
    public $modelName   = 'Language';
    public function __construct(Request $request)
    {
        View()->Share('modelName', $this->modelName);
        $this->request = $request;
    }

    public function index(Request $request)
    {
        $DB                        =     Language::query();
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
                if ($fieldName == "title") {
                    $DB->where("languages.title", 'LIKE', '%' . $fieldValue . '%');
                }
               
                if ($fieldName == "is_active") {
                    $DB->where("languages.is_active", 'LIKE', '%' . $fieldValue . '%');
                }
                $searchVariable = array_merge($searchVariable, array($fieldName => $fieldValue));
            }
        }
        $sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'languages.created_at';
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
                'title'                            =>  'required',
                'lang_code'                        =>  'required',
                'folder_code'                      =>  'required',
                'image'                            =>  'required|mimes:jpeg,png,jpg',
            ),
            array(
                'title.required'                 => 'The first name field must be required',
                'lang_code.required'             => 'The last name field must be required',
                'folder_code.required'           => 'The email field must be required',
                'image.required'                 => 'The image field must be required',
                'image.mimes'                    => 'The image field must be type .png .jpeg .jpg',
            )  
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {       

                $obj                            = new Language;
                $obj->title                     = $request->input('title'); 
                $obj->listing_title             = $request->input('title'); 
                $obj->lang_code                 = $request->input('lang_code');
                $obj->folder_code               = $request->input('folder_code');
               
                if($request->hasFile('image')){
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = time().'-image.'.$extension;
                    $folderName = strtoupper(date('M'). date('Y'))."/";
                    $folderPath = Config('constants.LANGUAGES_IMAGE_ROOT_PATH').$folderName;
                    if(!File::exists($folderPath)) {
                        File::makeDirectory($folderPath, $mode = 0777,true);
                    }
                    if($request->file('image')->move($folderPath, $fileName)){
                    $image = $folderName.$fileName;
                    }
                    $obj->image = $image;
                }

            $obj->save();
            Session::flash('success', trans(Config('constants.LANGUAGES.LANGUAGES_TITLE') . " has been Added successfully"));
            return redirect()->route($this->modelName . '.index');
        }
    }


    public function show($modelId)

    {  
        $modelId = base64_decode($modelId);
        if ($modelId) {
            $modelDetails = Language::where('id', $modelId)->first();
            return view('adminpnlx.' . $this->modelName . '.view', compact('modelDetails'));
        } else {
            return redirect::back();
        }
    }
    




    public function edit($id)
    {
        $modelId = base64_decode($id);
        if ($modelId) {
            $modelDetails = Language::where('id', $modelId)->first();
            return view("adminpnlx." . $this->modelName . ".edit", compact('modelDetails'));
        } else {
            return Redirect::back();
        }
    }





    public function update(Request $request, $id)
    {
        $modelId                = base64_decode($id);
        $model                  = Language::findorFail($modelId);

        if (empty($model)) {
            return Redirect::back();
        }
        $formData                =    $request->all();
        if (!empty($formData)) {           
            $validator = Validator::make(
                $request->all(),
                array(
                    'title'                            =>  'required',
                    'lang_code'                        =>  'required',
                    'folder_code'                      =>  'required',
                    'image'                            =>  'nullable|mimes:jpeg,png,jpg',
                ),
                array(
                    'title.required'                 => 'The first name field must be required',
                    'lang_code.required'             => 'The last name field must be required',
                    'folder_code.required'           => 'The email field must be required',
                    'image.mimes'                    => 'The image field must be type .png .jpeg .jpg',
                )   
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
             
                       
                $obj                            = $model;
                $obj->title                     = $request->input('title'); 
                $obj->listing_title             = $request->input('title'); 
                $obj->lang_code                 = $request->input('lang_code');
                $obj->folder_code               = $request->input('folder_code');
               
                if($request->hasFile('image')){
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = time().'-image.'.$extension;
                    $folderName = strtoupper(date('M'). date('Y'))."/";
                    $folderPath = Config('constants.LANGUAGES_IMAGE_ROOT_PATH').$folderName;
                    if(!File::exists($folderPath)) {
                        File::makeDirectory($folderPath, $mode = 0777,true);
                    }
                    if($request->file('image')->move($folderPath, $fileName)){
                    $image = $folderName.$fileName;
                    }
                    $obj->image = $image;
                }
                $obj->save();
                Session::flash('success', trans(Config('constants.LANGUAGES.LANGUAGES_TITLE') . " has been updated successfully"));
                return Redirect::route($this->modelName . ".index");
                
            }
        }

    }





    public function destroy($id)
    {
       
        $modelId = base64_decode($id);
        if ($modelId) {
            Language::where('id', $modelId)->delete();
            $statusMessage   =   trans(Config('constants.LANGUAGES.LANGUAGES_TITLE') . " has been deleted successfully");
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
            $statusMessage   =   trans(Config('constants.LANGUAGES.LANGUAGES_TITLE') . " has been image deleted successfully");
            Session()->flash('flash_notice', $statusMessage);
        }
        return redirect::back();
    }


    public function changeStatus($modelId = 0, $status)
    {
        $modelId = base64_decode($modelId);
        if ($status == 1) {
            $statusMessage   =   trans(Config('constants.LANGUAGES.LANGUAGES_TITLE') ." has been deactivated successfully");
        } else {
            $statusMessage   =   trans(Config('constants.LANGUAGES.LANGUAGES_TITLE') ." has been activated successfully");

        }
        $user = Language::findOrfail($modelId);
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