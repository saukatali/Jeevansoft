<?php

namespace App\Http\Controllers\adminpnlx;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Config;
use App\Models\About;
use App\Models\AboutDescription;
use App\Models\Language;
use App\Models\SettingTitle;
use Illuminate\Support\Facades\{DB, Session, Validator, Redirect, Auth, Hash};
use Illuminate\Support\Facades\{URL, View, Response, Cookie, File, Mail, Blade, Cache};
use Illuminate\Support\Str;

class AboutController extends Controller
{
    public $modelName = 'About';
    public $sectionName = 'About';
    public $sectionNameSingular = 'About';
    public function __construct(Request $request)
    {
        View()->Share('modelName', $this->modelName);
        View()->Share('sectionName', $this->sectionName);
        View()->Share('sectionNameSingular', $this->sectionNameSingular);

        $this->request = $request;
    }



    public function edit()
    {

        $languages = Language::where('is_active', 1)->get();
        $language_code = Config('constants.DEFAULT_LANGUAGE.LANGUAGE_CODE');
        $multiLanguage  = [];

        $model                 = About::first();
        if ($model) {
            $modelDescription  = AboutDescription::where('parent_id', $model->id)->get();
            // dd($modelDescription);            
            if (!empty($modelDescription)) {
                foreach ($modelDescription as $description) {
                    $multiLanguage[$description->language_id]['title'] = $description->title;
                    $multiLanguage[$description->language_id]['sub_title'] = $description->sub_title;
                    $multiLanguage[$description->language_id]['description'] = $description->description;
                }
            }

            // dd($multiLanguage);
            return view("adminpnlx." . $this->modelName . ".edit", compact('model', 'multiLanguage', 'languages', 'language_code'));
        } else {
            return view("adminpnlx." . $this->modelName . ".edit", compact('languages', 'language_code'));
        }
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request)
    {
        $formData                           =  $request->all();
        $model                              =    About::first();
        if (empty($model)) {
            $default_language               =  Config('constants.DEFAULT_LANGUAGE.FOLDER_CODE');
            $language_code                  =  Config('constants.DEFAULT_LANGUAGE.LANGUAGE_CODE');
            $dafaultLanguageArray           =  $formData['data'][$language_code];
            $validator = Validator::make(
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
            }
             else {
                $obj                         = new About;
                $obj->title                  = $dafaultLanguageArray['title'];
                $obj->slug                   = Str::slug($obj->title);
                $obj->sub_title              = $dafaultLanguageArray['sub_title'];
                $obj->description            = $dafaultLanguageArray['description'];
    
                if ($request->hasFile('image')) {
                    $folderName = strtoupper(date('M') . date('Y')) . "/";
                    $folderPath = Config('constants.ABOUT_US_IMAGE_ROOT_PATH') . $folderName;
                    $image = $folderName . time() . '.' . $request->image->getClientOriginalExtension();
                    $uploadImg = $request->file('image')->move($folderPath, $image);
                    $obj->image = $image;
                }
                $obj->save();
                $lastId = $obj->id;
                if ($lastId) {
                    foreach ($formData['data'] as $language_id => $value) {
                        $bannerDescription_obj                     =  new AboutDescription();
                        $bannerDescription_obj->language_id        =    $language_id;
                        $bannerDescription_obj->parent_id          =    $lastId;
                        $bannerDescription_obj->title              =    $value['title'];
                        $bannerDescription_obj->sub_title          =    $value['sub_title'];
                        $bannerDescription_obj->description        =    $value['description'];
                        $bannerDescription_obj->save();
                    }
                }
                Session::flash('success', trans($this->sectionNameSingular . " has been Added successfully"));
                return redirect()->route($this->modelName . '.edit');
            }
        }
        else{

            $default_language               =  Config('constants.DEFAULT_LANGUAGE.FOLDER_CODE');
            $language_code                  =  Config('constants.DEFAULT_LANGUAGE.LANGUAGE_CODE');
            $dafaultLanguageArray           =  $formData['data'][$language_code];
            // dd(24324);
            $validator = Validator::make(
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
                    $folderPath = Config('constants.ABOUT_US_IMAGE_ROOT_PATH') . $folderName;
                    $image = $folderName . time() . '.' . $request->image->getClientOriginalExtension();
                    $uploadImg = $request->file('image')->move($folderPath, $image);
                    $obj->image = $image;
                }
                $obj->save();
                $lastId = $obj->id;
                if ($lastId) {
                    AboutDescription::where('parent_id', $lastId)->delete();
                    foreach ($formData['data'] as $language_id => $value) {
                        $bannerDescription_obj                     =  new AboutDescription();
                        $bannerDescription_obj->language_id        =  $language_id;
                        $bannerDescription_obj->parent_id          =  $lastId;
                        $bannerDescription_obj->title              =  $value['title'];
                        $bannerDescription_obj->sub_title          =  $value['sub_title'];
                        $bannerDescription_obj->description        =  $value['description'];
                        $bannerDescription_obj->save();
                    }
                }
                Session::flash('success', trans($this->sectionNameSingular . " has been updated successfully"));
                return Redirect::route($this->modelName . ".edit");
            }
        }
    
}



    public function deleteImage(Request $request, $id)
    {
        $modelId = base64_decode($id);
        $banner_img    = About::where('id', $modelId)->first();
        $banner_img->image        = null;
        $banner_img->save();
        Session::flash('success', trans($this->sectionNameSingular . " Image has been updated successfully"));
        return Redirect::back();
    }

    public function editSetting()
    {
        $model = SettingTitle::where('slug', 'about')->first();
        if (!empty($model)) {
            return view("adminpnlx." . $this->modelName . ".edit-setting", compact('model'));
        } else {
            return view("adminpnlx." . $this->modelName . ".edit-setting");
        }
    }


    public function updateSetting(Request $request)
    {
        $model                    =    SettingTitle::where('slug', 'about')->first();
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
