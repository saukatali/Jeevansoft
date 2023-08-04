<?php

namespace App\Http\Controllers\adminpnlx;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Config;
use App\Models\Language;
use App\Models\LanguageSetting;

use Illuminate\Support\Facades\{DB, Session, Validator, Redirect, Auth, Hash, Str, Notification};
use Illuminate\Support\Facades\{URL, View, Response, Cookie, File, Mail, Blade, Cache, Http};

class LanguageSettingController extends Controller
{
    public $modelName   = 'LanguageSetting';
    public function __construct(Request $request)
    {
        View()->Share('modelName', $this->modelName);
        $this->request = $request;
    }

    public function index(Request $request)
    {
        $DB                        =     LanguageSetting::query();
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
                    $DB->where("language_settings.email", 'LIKE', '%' . $fieldValue . '%');
                }
                if ($fieldName == "phone_number") {
                    $DB->where("language_settings.phone_number", 'LIKE', '%' . $fieldValue . '%');
                }

                if ($fieldName == "is_active") {
                    $DB->where("language_settings.is_active", 'LIKE', '%' . $fieldValue . '%');
                }
                $searchVariable = array_merge($searchVariable, array($fieldName => $fieldValue));
            }
        }
        $sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'language_settings.created_at';
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
    
        $languages = Language::get();
        return view('adminpnlx.' . $this->modelName . '.add', compact('languages'));
        
    }


    public function store(Request $request)
    {        
        $formData = $request->all();
        $validator = Validator::make(
        $request->all(),
        array(
            'default' => 'required|unique:language_settings,msgid'
        ),
        array(
            'default.required'   => 'The default field is required',
        )
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {       
            $msgid					=	$request->input('default');

		    foreach ($formData['language'] as $key => $val) {
			$obj	 			    =  new LanguageSetting;
			$obj->msgid    		    =  trim($msgid);
			$obj->locale   		    =  trim($key);
			$obj->msgstr   		    =  empty($val) ? "" : $val;
			$obj->save();
		}
            $this->settingFileWrite();
            return redirect()->route($this->modelName . '.index');
        }
    }




    public function edit($id)
    {
        $modelId = base64_decode($id);
        if ($modelId) {
            $modelDetails = LanguageSetting::where('id', $modelId)->first();
            return view("adminpnlx." . $this->modelName . ".edit", compact('modelDetails'));
        } else {
            return Redirect::back();
        }
    }





    public function update(Request $request, $id)
    {
        $modelId                = base64_decode($id);
        $model                  = LanguageSetting::findorFail($modelId);

        if (empty($model)) {
            return Redirect::back();
        }
        $formData                =    $request->all();
        if (!empty($formData)) {           
            $validator = Validator::make(
                $request->all(),
                array(
                    'default'     =>  'required',
                ),
                array(
                    'default.required'   => 'The title field is required',
                ) 
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {            
                       
                $msgid					    =	$request->input('default');
                foreach ($formData['language'] as $key => $val) {
                    $obj                    = $model;
                    $obj->msgid    		    =  trim($msgid);
                    $obj->locale   		    =  trim($key);
                    $obj->msgstr   		    =  empty($val) ? "" : $val;
                    $obj->save();
                }
                    $this->settingFileWrite();
                    return redirect()->route($this->modelName . '.index');                
            }
        }
    }





    public function destroy($id)
    {
       
        $modelId = base64_decode($id);
        if ($modelId) {
            LanguageSetting::where('id', $modelId)->delete();
            $statusMessage   =   trans(Config('constants.USERS.USER_TITLE') . " has been deleted successfully");
            Session()->flash('flash_notice', $statusMessage);
        }
        return redirect::back();
    }




    public function settingFileWrite(){ 
		$languages	=	Language::where('is_active', '1')->get(array('folder_code','lang_code'));
		foreach($languages as $key => $val){
			$currLangArray	=	'<?php return array(';
			$list			=	LanguageSetting::where('locale',$val->lang_code)->select("msgid","msgstr")->get()->toArray();
			if(!empty($list)){
				foreach($list as $listDetails){
					$currLangArray	.=  '"'.$listDetails['msgid'].'"=>"'.$listDetails['msgstr'].'",'."\n";
				}
			}
			$currLangArray	.=	');';
			
			$file 			= 	Config('constants.LANGUAGE_PATH')."/".'lang'."/".$val->lang_code."/".'messages.php';
			File::put($file, $currLangArray);
		}
	}

}
