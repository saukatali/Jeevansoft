<?php
namespace App\Http\Controllers\adminpnlx;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Config;
use App\Models\Acl;
use App\Models\EmailAction;
use App\Models\EmailTemplate;

use Illuminate\Support\Facades\{DB, Session, Validator, Redirect, Auth, Hash, Notification};
use Illuminate\Support\Facades\{URL, View, Response, Cookie, File, Mail, Blade, Cache, Http};
use Str;


class AclController extends Controller
{
     public $modelName   = 'Acl';
    public function __construct(Request $request)
    {
        View()->Share('modelName', $this->modelName);
        $this->request = $request;
    }



    public function index(Request $request)
	{
		$DB 					= 	Acl::query()->with('parent_data');

		$searchVariable			=	array();
		$inputGet				=	$request->all();
		if ($request->all()) {
			$searchData			=	$request->all();
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
					$DB->where("acls.title", 'LIKE', '%' . $fieldValue . '%');
				}
				if ($fieldName == "parent_id") {
					$DB->where("acls.parent_id", 'LIKE', '%' . $fieldValue . '%');
				}
				$searchVariable = array_merge($searchVariable, array($fieldName => $fieldValue));
			}
		}

		$sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'acls.created_at';
		$order  = ($request->input('order')) ? $request->input('order')   : 'DESC';
		$records_per_page  =   ($request->input('per_page')) ? $request->input('per_page') : Config("Reading.records_per_page");
		$results = $DB->orderBy($sortBy, $order)->paginate($records_per_page);
        $complete_string =  $request->query();
		unset($complete_string["sortBy"]);
		unset($complete_string["order"]);
		$query_string  =   http_build_query($complete_string);
		$results->appends($inputGet)->render();
		$resultcount = $results->count();
		return View("adminpnlx.$this->modelName.index", compact('results', 'searchVariable', 'sortBy', 'order', 'query_string'));
	}




	public function create()
	{
		$parent_list =  Acl::get();
		return View("adminpnlx.$this->modelName.add", compact('parent_list'));
	}

	public function store(Request $request)
	{
		$validated = $request->validate([
			'title'         => 'required',
			'path'          => 'required',
			'module_order'  => 'required|numeric',
		]);
		$obj                =  new Acl;
		$obj->parent_id     =  !empty($request->input('parent_id')) ? $request->input('parent_id') : 0;
		$obj->title         =  $request->title;
		$obj->path          =  $request->path;
		$obj->icon          =  $request->icon;
		$obj->module_order  =  $request->module_order;
		$SavedResponse = $obj->save();
		if (!$SavedResponse) {
			Session()->flash('error', trans("Something went wrong."));
			return Redirect()->back()->withInput();
		} else {
			Session()->flash('success', " Module added successfully");
			return Redirect()->route($this->modelName . ".index");
		}
	}

	public function edit($enaclid)
	{
		$acl_id = '';
		if (!empty($enaclid)) {
			$acl_id       = base64_decode($enaclid);
			$aclDetails   =  Acl::find($acl_id);
			// $modelss =	Acl::with('get_admin_module_action')->where('id', $acl_id)->first();
			   $parent_list  = Acl::where('id', '!=', $acl_id)->get();
			// $parent_list =  Acl::get();
			return  View("adminpnlx.$this->modelName.edit", compact('parent_list', 'acl_id', 'aclDetails'));
		} else {
			return redirect()->route($this->modelName . ".index");
		}
	}



	public function update(Request $request, $enaclid)
	{
		$acl_id = '';
		if (!empty($enaclid)) {
			$acl_id = base64_decode($enaclid);
		} else {
			return redirect()->route($this->modelName . ".index");
		}
		$thisData = $request->all();
		$validated = $request->validate([
			'title' => 'required',
			'path' => 'required',
			'module_order'  => 'required|numeric',
		]);
		$obj   =  Acl::find($acl_id);
		$obj->parent_id     =   !empty($request->input('parent_id')) ? $request->input('parent_id') : 0;
		$obj->title         =  $request->title;
		$obj->path          =  $request->path;
		$obj->icon          =  $request->icon;
		$obj->module_order  =  $request->module_order;
		$SavedResponse = $obj->save();
		
		if (isset($thisData['data']) && !empty($thisData['data'])) {
		
			foreach ($thisData['data'] as $record) {
				if (!empty($record['name']) && !empty($record['function_name'])) {
					$AclAdminAction	=	AclAdminAction::where('admin_module_id', $acl_id)->where("function_name",$record['function_name'])->first();
					if(empty($AclAdminAction)){
						$obj1 						=  new AclAdminAction;
						$obj1['admin_module_id']	=  $acl_id;
						$obj1['name']				=  $record['name'];
						$obj1['function_name']		=  $record['function_name'];
						$obj1->save();
					}else {
						$obj1 						=  $AclAdminAction;
						$obj1['admin_module_id']	=  $acl_id;
						$obj1['name']				=  $record['name'];
						$obj1['function_name']		=  $record['function_name'];
						$obj1->save();
					}
				}
			}
		}
		if (!$SavedResponse) {
			Session()->flash('error', trans("Something went wrong."));
			return Redirect()->back()->withInput();
		} else {
			Session()->flash('success', " Module updated successfully");
			return Redirect()->route($this->modelName . ".index");
		}
	}

	public function delete($enaclid)
	{
		$acl_id = '';
		if (!empty($enaclid)) {
			$acl_id = base64_decode($enaclid);
		}
		$aclDetails   =  Acl::find($acl_id);
		if ($aclDetails) {
			$aclDetails->delete();
			Acl::where('parent_id', $acl_id)->delete();
			// AclAdminAction::where('admin_module_id', $acl_id)->delete();
			Session::flash('success', trans(Config('constants.ACLS.ACL_TITLE') . " Module has been removed successfully"));
		}
		return back();
	}





	public function changeStatus($modelId = 0, $status)
    {
        $modelId = base64_decode($modelId);
        if ($status == 1) {
            $statusMessage   =   trans(Config('constants.ACLS.ACL_TITLE') ."Module has been deactivated successfully");
        } else {
            $statusMessage   =   trans(Config('constants.ACLS.ACL_TITLE') ." Module has been activated successfully");

        }
        $user = Acl::findOrfail($modelId);
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



	public function addMoreRow(Request $request)
	{
		$counter	=	$request->input('counter');
		return View("admin.$this->model.add_more", compact('counter'));
	}

	public function delete_function($id,Request $request){
		AclAdminAction::where('function_name', $id)->delete();
       return back();
    }
}
