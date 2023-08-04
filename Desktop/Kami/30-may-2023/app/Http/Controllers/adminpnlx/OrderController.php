<?php

namespace App\Http\Controllers\adminpnlx;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Config;
use App\Mail\Subscribe;
use App\Notifications\NewUserNotification;
use App\Models\User;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use Illuminate\Support\Facades\{DB, Session, Validator, Redirect, Auth, Hash, Notification};
use Illuminate\Support\Facades\{URL, View, Response, Cookie, File, Mail, Blade, Cache, Http, Str};

class OrderController extends Controller
{
    public $modelName = 'Order';
    public function __construct(Request $request)
    {
        View()->Share('modelName', $this->modelName);

        $this->request = $request;
    }

    public function index(Request $request)
    {
        $DB                        = Order::query();
        $DB->leftjoin('users', 'users.id', 'orders.user_id');
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

            if((!empty($searchData['date_from'])) && (!empty($searchData['date_to']))){
				$dateS = $searchData['date_from'];
				$dateE = $searchData['date_to'];
				$DB->whereBetween('email_logs.created_at', [$dateS." 00:00:00", $dateE." 23:59:59"]); 											
			}elseif(!empty($searchData['date_from'])){
				$dateS = $searchData['date_from'];
				$DB->where('email_logs.created_at','>=' ,[$dateS." 00:00:00"]); 
			}elseif(!empty($searchData['date_to'])){
				$dateE = $searchData['date_to'];
				$DB->where('email_logs.created_at','<=' ,[$dateE." 00:00:00"]); 						
			}
            foreach ($searchData as $fieldName => $fieldValue) {
                if ($fieldName == "order_number") {
                    $DB->where("orders.order_number", 'LIKE', '%' . $fieldValue . '%');
                }
                if ($fieldName == "username") {
                    $DB->where("users.username", 'LIKE', '%' . $fieldValue . '%');
                }

                if ($fieldName == "order_status") {
                    $DB->where("orders.order_status", 'LIKE', '%' . $fieldValue . '%');
                }
                $searchVariable = array_merge($searchVariable, array($fieldName => $fieldValue));
            }
        }
        // $DB->where('orders.is_deleted', 0);
        $sortBy = ($request->input('sortBy')) ? $request->input('sortBy') : 'orders.created_at';
        $order  = ($request->input('order')) ? $request->input('order')   : 'DESC';
        $records_per_page  =   ($request->input('per_page')) ? $request->input('per_page') : Config("Reading.records_per_page");
        $results = $DB->orderBy($sortBy, $order)->paginate($records_per_page);
        if(!empty($results)){
            foreach($results as &$result){
                $result->user_name = User::where('id', $result->user_id)->where('is_active', 1)->value('username');
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
        if ($modelId) {
            $modelDetails = Order::with('getUser', 'getOrderItem')->where('id', $modelId)->first();
            if(!empty($modelDetails)){
                    if(!empty($modelDetails->getOrderItem))
                    {
                        foreach($modelDetails->getOrderItem as &$value)
                        {
                            $value->product_name = Product::where('id', $value->product_id)->where('is_active', 1)->value('name');
                            $value->discount     = Product::where('id', $value->product_id)->where('is_active', 1)->value('discount');
                            $value->product_image = Product::where('id', $value->product_id)->where('is_active', 1)->value('image');
                        }
                    }
            }
            return view('adminpnlx.' . $this->modelName . '.view', compact('modelDetails'));
        } else {
            return redirect::back();
        }
    }
    



    public function destroy($id)
    {
       
        $modelId = base64_decode($id);
        if ($modelId) {
            Order::where('id', $modelId)->delete();
            $statusMessage   =  trans(Config('constants.ORDERS.ORDER_TITLE') ." has been deleted successfully");
            Session()->flash('flash_notice', $statusMessage);
        }
        return redirect::back();
    }


    public function changeStatus($modelId = 0, $status)
    {
        $modelId = base64_decode($modelId);
        if ($status == 1) {
            $statusMessage   =   trans(Config('constants.ORDERS.ORDER_TITLE') ." has been deactivated successfully");
        } else {
            $statusMessage   =   trans(Config('constants.ORDERS.ORDER_TITLE') ." has been activated successfully");
        }
        $user = Order::findOrfail($modelId);
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