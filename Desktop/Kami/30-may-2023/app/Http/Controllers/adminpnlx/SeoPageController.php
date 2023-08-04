<?php

namespace App\Http\Controllers\adminpnlx;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Config;
use App\Models\SeoPage;

use Illuminate\Support\Facades\{DB, Session, Validator, Redirect, Auth, Hash, Str, Notification };
use Illuminate\Support\Facades\{URL, View, Response, Cookie, File, Mail, Blade, Cache, Http };

class SeoPageController extends Controller
{
    public $modelName   = 'SeoPage';
    public function __construct(Request $request)
    {
        View()->Share('modelName', $this->modelName);
        $this->request = $request;
    }

    public function index(Request $request)
    {
        $DB                        =     SeoPage::query();
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
                if ($fieldName == "email") {
                    $DB->where("seo_pages.email", 'LIKE', '%' . $fieldValue . '%');
                }
                if ($fieldName == "phone_number") {
                    $DB->where("seo_pages.phone_number", 'LIKE', '%' . $fieldValue . '%');
                }

                if ($fieldName == "is_active") {
                    $DB->where("seo_pages.is_active", 'LIKE', '%' . $fieldValue . '%');
                }
                $searchVariable = array_merge($searchVariable, array($fieldName => $fieldValue));
            }
        }
        $DB->where('seo_pages.is_deleted', 0);
        $sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'seo_pages.created_at';
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
                'page_id'                          =>  'required',
                'page_name'                        =>  'required',
                'meta_title'                       =>  'required',
            ),
            array(
                'page_id.required'                 => 'The page id field must be required',
                'page_name.required'               => 'The page name field must be required',
                'meta_title.required'              => 'The meta title field must be required',
            )  
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {       

                $obj                            = new SeoPage;
                $obj->page_id                   = $request->input('page_id'); 
                $obj->page_name                 = $request->input('page_name');
                $obj->meta_title                = $request->input('meta_title');
                $obj->meta_description          = $request->input('meta_description');
                $obj->meta_keywords              = $request->input('meta_keywords');
                $obj->twitter_card              = $request->input('twitter_card');
                $obj->twitter_site              = $request->input('twitter_site');
                $obj->og_url                    = $request->input('og_url');
                $obj->og_type                   = $request->input('og_type');
                $obj->og_title                  = $request->input('og_title');
                $obj->og_description            = $request->input('og_description');
                $obj->meta_chronicles           = $request->input('meta_chronicles');
               
                if($request->hasFile('image')){
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = time().'-image.'.$extension;
                    $folderName = strtoupper(date('M'). date('Y'))."/";
                    $folderPath = Config('constants.SEO_PAGE_IMAGE_ROOT_PATH').$folderName;
                    if(!File::exists($folderPath)) {
                        File::makeDirectory($folderPath, $mode = 0777,true);
                    }
                    if($request->file('image')->move($folderPath, $fileName)){
                    $image = $folderName.$fileName;
                    }
                    $obj->og_image = $image;
                }

            $obj->save();
            Session::flash('success', trans(Config('constants.SEO_PAGES.SEO_PAGE_TITLE') . " has been Added successfully"));
            return redirect()->route($this->modelName . '.index');
        }
    }


    public function show($modelId)

    {  
        $modelId = base64_decode($modelId);
        if ($modelId) {
            $modelDetails = SeoPage::where('id', $modelId)->first();
            return view('adminpnlx.' . $this->modelName . '.view', compact('modelDetails'));
        } else {
            return redirect::back();
        }
    }
    




    public function edit($id)
    {
        $modelId = base64_decode($id);
        if ($modelId) {
            $modelDetails = SeoPage::where('id', $modelId)->first();
            return view("adminpnlx." . $this->modelName . ".edit", compact('modelDetails'));
        } else {
            return Redirect::back();
        }
    }





    public function update(Request $request, $id)
    {
        $modelId                = base64_decode($id);
        $model                  = SeoPage::findorFail($modelId);

        if (empty($model)) {
            return Redirect::back();
        }
        $formData                =    $request->all();
        if (!empty($formData)) {           
            $validator = Validator::make(
                $request->all(),
                array(
                    'page_id'                          =>  'required',
                    'page_name'                        =>  'required',
                    'meta_title'                       =>  'required',
                ),
                array(
                    'page_id.required'                 => 'The page id field must be required',
                    'page_name.required'               => 'The page name field must be required',
                    'meta_title.required'              => 'The meta title field must be required',
                )  
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
             
                       
                $obj                            = $model;
                $obj->page_id                   = $request->input('page_id'); 
                $obj->page_name                 = $request->input('page_name');
                $obj->meta_title                = $request->input('meta_title');
                $obj->meta_description          = $request->input('meta_description');
                $obj->meta_keywords              = $request->input('meta_keywords');
                $obj->twitter_card              = $request->input('twitter_card');
                $obj->twitter_site              = $request->input('twitter_site');
                $obj->og_url                    = $request->input('og_url');
                $obj->og_type                   = $request->input('og_type');
                $obj->og_title                  = $request->input('og_title');
                $obj->og_description            = $request->input('og_description');
                $obj->meta_chronicles           = $request->input('meta_chronicles');
               
                if($request->hasFile('image')){
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = time().'-image.'.$extension;
                    $folderName = strtoupper(date('M'). date('Y'))."/";
                    $folderPath = Config('constants.SEO_PAGE_IMAGE_ROOT_PATH').$folderName;
                    if(!File::exists($folderPath)) {
                        File::makeDirectory($folderPath, $mode = 0777,true);
                    }
                    if($request->file('image')->move($folderPath, $fileName)){
                    $image = $folderName.$fileName;
                    }
                    $obj->og_image = $image;
                }
                $obj->save();
                Session::flash('success', trans(Config('constants.SEO_PAGES.SEO_PAGE_TITLE') . " has been updated successfully"));
                return Redirect::route($this->modelName . ".index");
                
            }
        }

    }





    public function destroy($id)
    {
       
        $modelId = base64_decode($id);
        if ($modelId) {
            SeoPage::where('id', $modelId)->delete();
            $statusMessage   =   trans(Config('constants.SEO_PAGES.SEO_PAGE_TITLE') . " has been deleted successfully");
            Session()->flash('flash_notice', $statusMessage);
        }
        return redirect::back();
    }


    public function deleteImage($id)
    {       
        $modelId = base64_decode($id);
        if ($modelId) {
           $modelImage =  SeoPage::where('id', $modelId)->first();
            $modelImage->image = null;
            $modelImage->save();
            $statusMessage   =   trans(Config('constants.SEO_PAGES.SEO_PAGE_TITLE') . " has been image deleted successfully");
            Session()->flash('flash_notice', $statusMessage);
        }
        return redirect::back();
    }


    public function changeStatus($modelId = 0, $status)
    {
        $modelId = base64_decode($modelId);
        if ($status == 1) {
            $statusMessage   =   trans(Config('constants.SEO_PAGES.SEO_PAGE_TITLE') ." has been deactivated successfully");
        } else {
            $statusMessage   =   trans(Config('constants.SEO_PAGES.SEO_PAGE_TITLE') ." has been activated successfully");

        }
        $user = SeoPage::findOrfail($modelId);
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