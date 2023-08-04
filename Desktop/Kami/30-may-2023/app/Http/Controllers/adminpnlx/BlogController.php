<?php

namespace App\Http\Controllers\adminpnlx;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Config;
use App\Models\Blog;
use App\Models\SettingTitle;

use Illuminate\Support\Facades\{DB, Session, Validator, Redirect, Auth, Hash, Str, Notification};
use Illuminate\Support\Facades\{URL, View, Response, Cookie, File, Mail, Blade, Cache, Http};

class BlogController extends Controller
{
    public $modelName   = 'Blog';
    public function __construct(Request $request)
    {
        View()->Share('modelName', $this->modelName);
        $this->request = $request;
    }

    public function index(Request $request)
    {
        $DB                        =     Blog::query();
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
                    $DB->where("blogs.title", 'LIKE', '%' . $fieldValue . '%');
                }

                if ($fieldName == "is_active") {
                    $DB->where("blogs.is_active", 'LIKE', '%' . $fieldValue . '%');
                }
                $searchVariable = array_merge($searchVariable, array($fieldName => $fieldValue));
            }
        }
        $DB->where('blogs.is_deleted', 0);
        $sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'blogs.created_at';
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

        return view('adminpnlx.' . $this->modelName . '.add');
    }


    public function store(Request $request)
    {
        $formData = $request->all();
        $validator = Validator::make(
            $request->all(),
            array(
                'title'                            =>  'required',
                'sub_title'                        =>  'required',
                'image'                            =>  'required|mimes:jpeg,png,jpg',
                'attachment'			           => 'required|mimes:pdf,csv,xls,xlsx,doc,docx',
            ),
            array(
                'title.required'                 => 'The title field must be required',
                'sub_title.required'             => 'The sub title field must be required',
                'image.required'                 => 'The image field must be required',
                'image.mimes'                    => 'The image field must be type .png .jpeg .jpg',
                "attachment.required"			 =>	trans("The attachment field is required."),
            )
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {

            $obj                            = new Blog;
            $obj->title                     = $request->input('title');
            $obj->sub_title                 = $request->input('sub_title');
            $obj->description               = $request->input('description');

            if ($request->hasFile('image')) {
                $extension = $request->file('image')->getClientOriginalExtension();
                $fileName = time() . '-image.' . $extension;
                $folderName = strtoupper(date('M') . date('Y')) . "/";
                $folderPath = Config('constants.BLOG_IMAGE_ROOT_PATH') . $folderName;
                if (!File::exists($folderPath)) {
                    File::makeDirectory($folderPath, $mode = 0777, true);
                }
                if ($request->file('image')->move($folderPath, $fileName)) {
                    $image = $folderName . $fileName;
                }
                $obj->image = $image;
            }

            if($request->hasFile('attachment')){
                $extension 				=	$request->file('attachment')->getClientOriginalExtension();
                $original_attachment_name 	=	$request->file('attachment')->getClientOriginalName();
                $fileName				=	time().'-attachment.'.$extension;
                
                $folderName     		= 	strtoupper(date('M'). date('Y'))."/";
                $folderPath				=	Config('constants.BLOG_IMAGE_ROOT_PATH').$folderName;
                if(!File::exists($folderPath)) {
                    File::makeDirectory($folderPath, $mode = 0777,true);
                }
                if($request->file('attachment')->move($folderPath, $fileName)){
                    $obj->attachment					=	$folderName.$fileName;                        
                }
            }	

            $obj->save();
            Session::flash('success', trans(Config('constants.BLOGS.BLOG_TITLE') . " has been Added successfully"));
            return redirect()->route($this->modelName . '.index');
        }
    }


    public function show($modelId)

    {
        $modelId = base64_decode($modelId);
        if ($modelId) {
            $modelDetails = Blog::where('id', $modelId)->first();
            return view('adminpnlx.' . $this->modelName . '.view', compact('modelDetails'));
        } else {
            return redirect::back();
        }
    }





    public function edit($id)
    {
        $modelId = base64_decode($id);
        if ($modelId) {
            $modelDetails = Blog::where('id', $modelId)->first();
            return view("adminpnlx." . $this->modelName . ".edit", compact('modelDetails'));
        } else {
            return Redirect::back();
        }
    }





    public function update(Request $request, $id)
    {
        $modelId                = base64_decode($id);
        $model                  = Blog::findorFail($modelId);

        if (empty($model)) {
            return Redirect::back();
        }
        $formData                =    $request->all();
        if (!empty($formData)) {
            $validator = Validator::make(
                $request->all(),
                array(
                    'title'                            =>  'required',
                    'sub_title'                        =>  'required',
                    'image'                            =>  'nullable|mimes:jpeg,png,jpg',
                    'attachment'			           => 'nullable|mimes:pdf,csv,xls,xlsx,doc,docx',
                ),
                array(
                    'title.required'                 => 'The first name field must be required',
                    'sub_title.required'             => 'The phone number field must be required',
                    'image.mimes'                    => 'The image field must be type .png .jpeg .jpg',
                    "attachment.mimes"	             =>	'The attachment must be a file of type: pdf, csv, xls, xlsx, doc, docx.',
                )
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {


                $obj                            = $model;
                $obj->title                     = $request->input('title');
                $obj->sub_title                 = $request->input('sub_title');
                $obj->description               = $request->input('description');

                if ($request->hasFile('image')) {
                    $extension = $request->file('image')->getClientOriginalExtension();
                    $fileName = time() . '-image.' . $extension;
                    $folderName = strtoupper(date('M') . date('Y')) . "/";
                    $folderPath = Config('constants.BLOG_IMAGE_ROOT_PATH') . $folderName;
                    if (!File::exists($folderPath)) {
                        File::makeDirectory($folderPath, $mode = 0777, true);
                    }
                    if ($request->file('image')->move($folderPath, $fileName)) {
                        $image = $folderName . $fileName;
                    }
                    $obj->image = $image;
                }
                if($request->hasFile('attachment')){
                    $extension 				=	$request->file('attachment')->getClientOriginalExtension();
                    $original_attachment_name 	=	$request->file('attachment')->getClientOriginalName();
                    $fileName				=	time().'-attachment.'.$extension;
                    
                    $folderName     		= 	strtoupper(date('M'). date('Y'))."/";
                    $folderPath				=	Config('constants.BLOG_IMAGE_ROOT_PATH').$folderName;
                    if(!File::exists($folderPath)) {
                        File::makeDirectory($folderPath, $mode = 0777,true);
                    }
                    if($request->file('attachment')->move($folderPath, $fileName)){
                        $obj->attachment					=	$folderName.$fileName;                        
                    }
                }	
                $obj->save();
                Session::flash('success', trans(Config('constants.BLOGS.BLOG_TITLE') . " has been updated successfully"));
                return Redirect::route($this->modelName . ".index");
            }
        }
    }





    public function destroy($id)
    {

        $modelId = base64_decode($id);
        if ($modelId) {
            Blog::where('id', $modelId)->delete();
            $statusMessage   =   trans(Config('constants.BLOGS.BLOG_TITLE') . " has been deleted successfully");
            Session()->flash('flash_notice', $statusMessage);
        }
        return redirect::back();
    }


    public function deleteImage($id)
    {
        $modelId = base64_decode($id);
        if ($modelId) {
            $modelImage =  Blog::where('id', $modelId)->first();
            $modelImage->image = null;
            $modelImage->save();
            $statusMessage   =   trans(Config('constants.BLOGS.BLOG_TITLE') . " has been image deleted successfully");
            Session()->flash('flash_notice', $statusMessage);
        }
        return redirect::back();
    }

    public function changeStatus($modelId = 0, $status)
    {
        $modelId = base64_decode($modelId);
        if ($status == 1) {
            $statusMessage   =   trans(Config('constants.BLOGS.BLOG_TITLE') . " has been deactivated successfully");
        } else {
            $statusMessage   =   trans(Config('constants.BLOGS.BLOG_TITLE') . " has been activated successfully");
        }
        $user = Blog::findOrfail($modelId);
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



    public function edit_setting_title(Request $request)
    {
        if ($request->isMethod('POST')) {
            // $model            = SettingTitle::where('slug', 'blog')->first();
            $model               = setSettingTitle('blog');
            $formData                        =    $request->all();
            if (!empty($formData)) {
                $validator                     =    Validator::make(
                    $request->all(),
                    array(
                        'heading'                            => 'required',
                    ),
                    array(
                        "heading.required"                    =>    trans("The heading field is required."),
                    )
                );
                if ($validator->fails()) {
                    return Redirect::back()->withErrors($validator)->withInput();
                } else {
                    if (empty($model)) {
                        $obj                                         = new SettingTitle;
                    } else {
                        $obj                                         =  $model;
                    }

                    $obj->slug                                       = 'blog';
                    $obj->heading                                    = $request->input('heading');
                    $obj->title                                      = $request->input('title');
                    $obj->description                                = $request->input('description');
                    $obj->is_enable                                  = $request->input('is_enable');

                    $obj->save();

                    if (!$obj->save()) {
                        Session::flash('error', trans("Something went wrong."));
                        return Redirect::back()->withInput();
                    }
                    Session::flash('success', trans(Config('constants.BLOGS.BLOG_TITLE') . " Setting has been updated successfully"));
                    return Redirect::route($this->modelName . ".index");
                }
            }
        } else {
            // $modelDetails            = SettingTitle::where('slug', 'blog')->first();
            $modelDetails               = setSettingTitle('blog');
            return  View::make("adminpnlx.$this->modelName.edit_setting_title", compact('modelDetails'));
        }
    }
}
