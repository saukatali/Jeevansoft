<?php

namespace App\Http\Controllers\adminpnlx;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Config;
use App\Models\Service;
use App\Models\ServiceDescription;
use App\Models\Language;
use App\Models\SettingTitle;
use Illuminate\Support\Facades\{DB, Session, Validator, Redirect, Auth, Hash};
use Illuminate\Support\Facades\{URL, View, Response, Cookie, File, Mail, Blade, Cache};
use Illuminate\Support\Str;


class ServiceController extends Controller
{
    public $modelName = 'Service';
    public $sectionName = 'Service';
    public $sectionNameSingular = 'Service';
    public function __construct(Request $request)
    {
        View()->Share('modelName', $this->modelName);
        View()->Share('sectionName', $this->sectionName);
        View()->Share('sectionNameSingular', $this->sectionNameSingular);

        $this->request = $request;
    }



    public function index(Request $request)
    {
        $DB                   = Service::query();
        $searchVariable       = array();
        $searchData            = $request->input();
        foreach ($searchData as $fieldName => $fieldValue) {
            if ($fieldValue != "") {
                if ($fieldName == "title") {
                    $DB->where('title', 'like', "%{$fieldValue}%");
                }
                if ($fieldName == "description") {
                    $DB->where('description', 'like', "%{$fieldValue}%");
                }
            }
            $searchVariable = array_merge($searchVariable, array($fieldName => $fieldValue));
        }
        $results            = $DB->sortable()->paginate(10);
        return view('adminpnlx.' . $this->modelName . '.index', compact('results'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $languages = Language::where('is_active', 1)->get();
        $language_code = Config('constants.DEFAULT_LANGUAGE.LANGUAGE_CODE');
        return view('adminpnlx.' . $this->modelName . '.add', compact('languages', 'language_code'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function store(Request $request)
    {
        $formData                       =  $request->all();
        $default_language               =  Config('constants.DEFAULT_LANGUAGE.FOLDER_CODE');
        $language_code                  =  Config('constants.DEFAULT_LANGUAGE.LANGUAGE_CODE');
        $dafaultLanguageArray           =  $formData['data'][$language_code];
        $validator = Validator::make(
            // $request->all(),
            array(
                'title'     =>  $dafaultLanguageArray['title'],
            ),
            array(
                'title'     =>  'required',
            ),
            array(
                'title.required'   => 'The title field is required',
            )
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $obj                         = new Service;
            $obj->title                  = $dafaultLanguageArray['title'];
            $obj->slug                   = Str::slug($obj->title);
            $obj->sub_title              = $dafaultLanguageArray['sub_title'];
            $obj->description            = $dafaultLanguageArray['description'];

            if ($request->hasFile('image')) {
                $folderName = strtoupper(date('M') . date('Y')) . "/";
                $folderPath = Config('constants.SERVICE_IMAGE_ROOT_PATH') . $folderName;
                $image = $folderName . time() . '.' . $request->image->getClientOriginalExtension();
                $uploadImg = $request->file('image')->move($folderPath, $image);
                $obj->image = $image;
            }
            $obj->save();
            $lastId = $obj->id;
            if ($lastId) {
                foreach ($formData['data'] as $language_id => $value) {
                    $bannerDescription_obj                    =  new ServiceDescription();
                    $bannerDescription_obj->language_id        =    $language_id;
                    $bannerDescription_obj->parent_id        =    $lastId;
                    $bannerDescription_obj->title            =    $value['title'];
                    $bannerDescription_obj->sub_title        =    $value['sub_title'];
                    $bannerDescription_obj->description        =    $value['description'];
                    $bannerDescription_obj->save();
                }
            }
            Session::flash('success', trans($this->sectionNameSingular . " has been Added successfully"));
            return redirect()->route($this->modelName . '.index');
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($modelId)
    {
        $modelId = base64_decode($modelId);
        if ($modelId) {
            $model = Service::where('id', $modelId)->first();
            return view('adminpnlx.' . $this->modelName . '.view', compact('model'));
        } else {
            return redirect::back();
        }
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $modelId = base64_decode($id);
        $multiLanguage  = [];
        if ($modelId) {
            $model                 = Service::where('id', $modelId)->first();
            // $modelDescription      =   [];
            if ($model) {
                $modelDescription  = ServiceDescription::where('parent_id', $model->id)->get();
            }
            if (!empty($modelDescription)) {
                foreach ($modelDescription as $description) {
                    $multiLanguage[$description->language_id]['title'] = $description->title;
                    $multiLanguage[$description->language_id]['sub_title'] = $description->sub_title;
                    $multiLanguage[$description->language_id]['description'] = $description->description;
                }
            }

            $languages = Language::where('is_active', 1)->get();
            $language_code = Config('constants.DEFAULT_LANGUAGE.LANGUAGE_CODE');
            // dd($multiLanguage);
            return view("adminpnlx." . $this->modelName . ".edit", compact('model', 'multiLanguage', 'languages', 'language_code'));
        } else {
            return Redirect::back();
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $modelId = base64_decode($id);
        $model                          =    Service::findorFail($modelId);
        if (empty($model)) {
            return Redirect::back();
        }
        $formData                       =  $request->all();
        // dd($formData);
        $default_language               =  Config('constants.DEFAULT_LANGUAGE.FOLDER_CODE');
        $language_code                  =  Config('constants.DEFAULT_LANGUAGE.LANGUAGE_CODE');
        $dafaultLanguageArray           =  $formData['data'][$language_code];
        if (!empty($formData)) {
            $validator = Validator::make(
                // $request->all(),
                array(
                    'title'     =>  $dafaultLanguageArray['title'],
                ),
                array(
                    'title'     =>  'required',
                ),
                array(
                    'title.required'   => 'The title field is required',
                )
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                $obj                         = $model;
                $obj->title                  = $dafaultLanguageArray['title'];
                $obj->slug                   = Str::slug($obj->title);
                $obj->sub_title              = $dafaultLanguageArray['sub_title'];
                $obj->description            = $dafaultLanguageArray['description'];
                if ($request->hasFile('image')) {
                    $folderName = strtoupper(date('M') . date('Y')) . "/";
                    $folderPath = Config('constants.SERVICE_IMAGE_ROOT_PATH') . $folderName;
                    $image = $folderName . time() . '.' . $request->image->getClientOriginalExtension();
                    $uploadImg = $request->file('image')->move($folderPath, $image);
                    $obj->image = $image;
                }
                $obj->save();
                $lastId = $obj->id;
                ServiceDescription::where('parent_id', $lastId)->delete();
                    foreach ($formData['data'] as $language_id => $value) {
                        $bannerDescription_obj                     = new ServiceDescription;
                        $bannerDescription_obj->language_id        = $language_id;
                        $bannerDescription_obj->parent_id          = $lastId;
                        $bannerDescription_obj->title              = $value['title'];
                        $bannerDescription_obj->sub_title          = $value['sub_title'];
                        $bannerDescription_obj->description        = $value['description'];
                        $bannerDescription_obj->save();
                    }
                
                Session::flash('success', trans($this->sectionNameSingular . " has been updated successfully"));
                return Redirect::route($this->modelName . ".index");
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function delete($id)
    {

        $modelId = base64_decode($id);
        if ($modelId) {
            Service::where('id', $modelId)->delete();
            $statusMessage   =   trans($this->sectionName . " has been deleted successfully");
            Session()->flash('flash_notice', $statusMessage);
        }
        return redirect::back();
    }


    public function deleteImage(Request $request, $id)
    {
        $modelId = base64_decode($id);
        $banner_img    = Service::where('id', $modelId)->first();
        $banner_img->image        = null;
        $banner_img->save();
        Session::flash('success', trans($this->sectionNameSingular . " has been updated successfully"));
        return Redirect::back();
    }





    public function changeStatus($modelId = 0, $status = 0)
    {
        $modelId = base64_decode($modelId);
        if ($status == 1) {
            $statusMessage   =   trans($this->sectionName . " has been deactivated successfully");
        } else {
            $statusMessage   =   trans($this->sectionName . " has been activated successfully");
        }
        $user = Service::findOrfail($modelId);
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


    public function editSetting()
    {
        $model = SettingTitle::where('slug', 'banner')->first();
        if (!empty($model)) {
            return view("adminpnlx." . $this->modelName . ".edit-setting", compact('model'));
        } else {
            return view("adminpnlx." . $this->modelName . ".edit-setting");
        }
    }


    public function updateSetting(Request $request)
    {
        $model                    =    SettingTitle::where('slug', 'banner')->first();
        if (empty($model)) {
            $validator = Validator::make(
                $request->all(),
                array(
                    'title'     =>  'required',
                ),
                array(
                    'title.required'   => 'The title field is required',
                )
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                $obj                         = new SettingTitle;
                $obj->heading                = $request->input('heading');
                $obj->title                  = $request->input('title');
                $obj->slug                     = Str::slug($obj->title);
                $obj->is_enable              = !empty($request->input('is_enable')) ?? '1';
                $obj->description            = $request->input('description');
                $obj->save();
                Session::flash('success', trans($this->sectionNameSingular . " has been Added successfully"));
                return redirect()->route($this->modelName . '.editSetting');
            }
        }
        $formData                        =    $request->all();
        if (!empty($formData)) {
            $validator = Validator::make(
                $request->all(),
                array(
                    'title'     =>  'nullable',
                ),
                array(
                    'title.nullable'   => 'The title field is required',
                )
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
                $obj                         = $model;
                $obj->heading                = $request->input('heading');
                $obj->title                  = $request->input('title');
                $obj->slug                     = Str::slug($obj->title);
                $obj->is_enable              = !empty($request->input('is_enable')) ?? '1';
                $obj->description            = $request->input('description');
                $obj->save();
                Session::flash('success', trans($this->sectionNameSingular . " has been updated successfully"));
                return Redirect::route($this->modelName . ".editSetting");
            }
        }
    }
}
