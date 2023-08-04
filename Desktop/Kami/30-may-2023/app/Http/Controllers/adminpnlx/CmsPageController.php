<?php

namespace App\Http\Controllers\adminpnlx;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Config;
use App\Models\CmsPage;
use App\Models\CmsPageDescription;
use App\Models\Language;
use Illuminate\Support\Str;
use Illuminate\Support\Facades\{DB, Session, Validator, Redirect, Auth, Hash, Notification};
use Illuminate\Support\Facades\{URL, View, Response, Cookie, File, Mail, Blade, Cache, Http};
use Illuminate\Database\Events\TransactionBeginning;

class CmsPageController extends Controller
{
    public $modelName   = 'CmsPage';
    public function __construct(Request $request)
    {
        View()->Share('modelName', $this->modelName);
        $this->request = $request;
    }

    public function index(Request $request)
    {
        $DB                        =     CmsPage::query();
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
                if ($fieldName == "page_title") {
                    $DB->where("cms_pages.page_title", 'LIKE', '%' . $fieldValue . '%');
                }

                if ($fieldName == "is_active") {
                    $DB->where("cms_pages.is_active", 'LIKE', '%' . $fieldValue . '%');
                }
                $searchVariable = array_merge($searchVariable, array($fieldName => $fieldValue));
            }
        }
        $DB->where('cms_pages.is_deleted', 0);
        $sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'cms_pages.created_at';
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

    public function create()
    {
        $languages = Language::where('is_active', 1)->get();
        $language_code = Config('constants.DEFAULT_LANGUAGE.LANGUAGE_CODE');
        return view('adminpnlx.' . $this->modelName . '.add', compact('languages', 'language_code'));
    }

  

    public function store(Request $request)
    {
        $formData                       =  $request->all();
        $default_language               =  Config('constants.DEFAULT_LANGUAGE.FOLDER_CODE');
        $language_code                  =  Config('constants.DEFAULT_LANGUAGE.LANGUAGE_CODE');
        $dafaultLanguageArray           =  $formData['data'][$language_code];
        $validator = Validator::make(
            // $request->all(),
            array(
                'page_name'     =>  $request->input('page_name'),
                'page_title'    =>  $dafaultLanguageArray['page_title'],
            ),
            array(
                'page_name'          =>  'required',
                'page_title'         =>  'required',
            ),
            array(
                'page_title.required'   => 'The page title field is required',
            )
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            DB::beginTransaction();
			try {
            $obj                         = new CmsPage;
            $obj->page_name              = $request->input('page_name');
            $obj->page_title             = $dafaultLanguageArray['page_title'];
            $obj->description            = $dafaultLanguageArray['description'];
            $obj->save();
            $lastId = $obj->id;

            foreach ($formData['data'] as $language_id => $value) {
                    $sub_obj                     =  new CmsPageDescription();
                    $sub_obj->language_id        =    $language_id;
                    $sub_obj->parent_id          =    $lastId;
                    $sub_obj->page_title         =    $value['page_title'];
                    $sub_obj->description        =    $value['description'];
                    $sub_obj->save();
                }
            DB::commit();
            Session::flash('success', trans(Config('constants.CMS_PAGES.CMS_PAGE_TITLE') . " has been Added successfully"));
            return redirect()->route($this->modelName . '.index');
        } catch (\Throwable $th) {
            DB::rollback();
            // Session()->flash('error', trans($th));
             Session()->flash('error', trans("Something went wrong."));
            return Redirect()->back()->withInput();
        }
        }
    }

   

    public function show($modelId)
    {
        $modelId = base64_decode($modelId);
        if ($modelId) {
            $model = CmsPage::where('id', $modelId)->first();
            return view('adminpnlx.' . $this->modelName . '.view', compact('model'));
        } else {
            return redirect::back();
        }
    }

   



    public function edit($id)
    {
        $modelId = base64_decode($id);
        $multiLanguage  = [];
        if ($modelId) {
            $modelDetails                 = CmsPage::where('id', $modelId)->first();
            $modelDescription      =   [];
            if ($modelDetails) {
                $modelDescription  = CmsPageDescription::where('parent_id', $modelDetails->id)->get();
            }
            if (!empty($modelDescription)) {
                foreach ($modelDescription as $description) {
                    $multiLanguage[$description->language_id]['page_title'] = $description->page_title;
                    $multiLanguage[$description->language_id]['description'] = $description->description;
                }
            }
            $languages = Language::where('is_active', 1)->get();
            $language_code = Config('constants.DEFAULT_LANGUAGE.LANGUAGE_CODE');
            return view("adminpnlx." . $this->modelName . ".edit", compact('modelDetails', 'multiLanguage', 'languages', 'language_code'));
        } else {
            return Redirect::back();
        }
    }

    


    public function update(Request $request, $id)
    {
        $modelId = base64_decode($id);
        $model                          =    CmsPage::findorFail($modelId);
        if (empty($model)) {
            return Redirect::back();
        }
        $formData                       =  $request->all();
        $default_language               =  Config('constants.DEFAULT_LANGUAGE.FOLDER_CODE');
        $language_code                  =  Config('constants.DEFAULT_LANGUAGE.LANGUAGE_CODE');
        $dafaultLanguageArray           =  $formData['data'][$language_code];
            $validator = Validator::make(
                array(
                    'page_name'          =>  $request->input('page_name'),
                    'page_title'         =>  $dafaultLanguageArray['page_title'],
                ),
                array(
                    'page_name'          =>  'required',
                    'page_title'         =>  'required',
                ),
                array(
                    'page_title.required'   => 'The page title field is required',
                )
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                DB::beginTransaction();
                try {
                $obj                         = $model;
                $obj->page_name              = $request->input('page_name');
                $obj->page_title             = $dafaultLanguageArray['page_title'];
                $obj->description            = $dafaultLanguageArray['description'];               
                $obj->save();

                $lastId = $obj->id;

                CmsPageDescription::where('parent_id', $lastId)->delete();
                    foreach ($formData['data'] as $language_id => $value) {
                        $sub_obj                     =  new CmsPageDescription();
                        $sub_obj->language_id        =  $language_id;
                        $sub_obj->parent_id          =  $lastId;
                        $sub_obj->page_title         =  $value['page_title'];
                        $sub_obj->description        =  $value['description'];
                        $sub_obj->save();
                    }
                DB::commit();
                Session::flash('success', trans(Config('constants.CMS_PAGES.CMS_PAGE_TITLE') . " has been updated successfully"));
                return Redirect::route($this->modelName . ".index");
          } catch (\Throwable $th) {
            DB::rollback();
            Session()->flash('error', trans("Something went wrong."));
            return Redirect()->back()->withInput();
        }
        }
    }

    


  
    public function delete($id)
    {
        $modelId = base64_decode($id);
        if ($modelId) {
            CmsPage::where('id', $modelId)->delete();
            CmsPageDescription::where('parent_id', $modelId)->delete();
            Session::flash('success', trans(Config('constants.CMS_PAGES.CMS_PAGE_TITLE') . " has been deleted successfully"));
        }
        return redirect::back();
    }



    public function changeStatus($modelId = 0, $status = 0)
    {
        $modelId = base64_decode($modelId);
        if ($status == 1) {
            $statusMessage   =   trans(Config('constants.CMS_PAGES.CMS_PAGE_TITLE') . " has been deactivated successfully");
        } else {
            $statusMessage   =  trans(Config('constants.CMS_PAGES.CMS_PAGE_TITLE') . " has been activated successfully");
        }
        $user = CmsPage::findOrfail($modelId);
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
