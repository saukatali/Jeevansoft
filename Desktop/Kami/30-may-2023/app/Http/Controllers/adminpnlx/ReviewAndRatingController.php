<?php

namespace App\Http\Controllers\adminpnlx;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Config;
use App\Models\Product;
use App\Models\Rating;
use App\Models\User;
use Illuminate\Support\Facades\{DB, Session, Validator, Redirect, Auth, Hash, Notification};
use Illuminate\Support\Facades\{URL, View, Response, Cookie, File, Mail, Blade, Cache, Http, Str};

class ReviewAndRatingController extends Controller
{
    public $modelName = 'ReviewAndRating';
    public function __construct(Request $request)
    {
        View()->Share('modelName', $this->modelName);

        $this->request = $request;
    }

    public function index(Request $request)
    {
        $DB                        = Rating::query();
        $DB->leftjoin('users', 'users.id', 'ratings.user_id')
        ->select('ratings.*', 'users.first_name', 'users.last_name', 'users.username');
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
                    $DB->where("users.username", 'LIKE', '%' . $fieldValue . '%');
                }
                $searchVariable = array_merge($searchVariable, array($fieldName => $fieldValue));
            }
        }
        $DB->where('ratings.is_deleted', 0);
        $sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'ratings.created_at';
        $order  = ($request->input('order')) ? $request->input('order')   : 'DESC';
        $records_per_page  =   ($request->input('per_page')) ? $request->input('per_page') : Config("Reading.records_per_page");
        $results = $DB->orderBy($sortBy, $order)->paginate($records_per_page);
        if(!empty($results)){
            foreach($results as &$result){
                $result->first_name = User::where('id', $result->user_id)->value('first_name');
                $result->last_name  = User::where('id', $result->user_id)->value('last_name');
                $result->product_name = Product::where('id', $result->product_id)->value('name');
            }
        }
        $complete_string =  $request->query();
        unset($complete_string["sortBy"]);
        unset($complete_string["order"]);
        $query_string  =   http_build_query($complete_string);
        $results->appends($inputGet)->render();
     return View("adminpnlx.$this->modelName.index", compact('results', 'searchVariable', 'sortBy', 'order', 'query_string'));
    }


  

    public function show($modelId)
    {  
        $modelId = base64_decode($modelId);
        if (empty($modelId)) {
            return redirect::back();
        }
            $modelDetails = Rating::where('id', $modelId)->first();
            if(!empty($modelDetails)){
                $modelDetails->username = User::where('id', $modelDetails->user_id)->value('username');
                $modelDetails->product_name = Product::where('id', $modelDetails->product_id)->value('name');
            }
            return view('adminpnlx.' . $this->modelName . '.view', compact('modelDetails'));
       
    }
    

    public function edit($id)
    {
        $modelId = base64_decode($id);
        if ($modelId) {
            $modelDetails = Rating::where('id', $modelId)->first();
            return view("adminpnlx." . $this->modelName . ".edit", compact('modelDetails'));
        } else {
            return Redirect::back();
        }
    }


    public function update(Request $request, $id)
    {
        $formData               = $request->all();
        $modelId                = base64_decode($id);
        $model                  = Rating::findorFail($modelId);

        if (empty($model)) {
            return Redirect::back();
        }
        if (!empty($formData)) {           
            $validator = Validator::make(
                $request->all(),
                array(
                    'rating'                       =>  'required',
                ),
                array(
                    'rating.required'              => 'The rating field is required',
                ) 
            );
            if ($validator->fails()) {
                return redirect()->back()->withErrors($validator)->withInput();
            } else {
             
                       
                $obj                         = $model;
                $obj->rating                 = $request->input('rating'); 
                $obj->review                 = $request->input('review');

                $obj->save();
                Session::flash('success', trans(Config('constants.RATINGS.RATING_TITLE') . " has been updated successfully"));
                return Redirect::route($this->modelName . ".index");
                
            }
        }

    }




    public function destroy($id)
    {
       
        $modelId = base64_decode($id);
        if ($modelId) {
            Rating::where('id', $modelId)->delete();
            $statusMessage   =  trans(Config('constants.RATINGS.RATING_TITLE') ." has been deleted successfully");
            Session()->flash('flash_notice', $statusMessage);
        }
        return redirect::back();
    }


    public function changeStatus($modelId = 0, $status)
    {
        $modelId = base64_decode($modelId);
        if ($status == 1) {
            $statusMessage   =   trans(Config('constants.RATINGS.RATING_TITLE') ." has been deactivated successfully");
        } else {
            $statusMessage   =   trans(Config('constants.RATINGS.RATING_TITLE') ." has been activated successfully");
        }
        $user = Rating::findOrfail($modelId);
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