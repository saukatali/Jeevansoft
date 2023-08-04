<?php

namespace App\Http\Controllers\fashi;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Config;

use Customhelper;
use App\Models\{Blog, Product, Category, Service, BlogSeo, Cart, SettingTitle, Contact, Order, OrderItem, ProductItem, ProductOrder};
use App\Models\ContactEnquiry;
use Illuminate\Support\Facades\{DB, Session, Validator, Redirect, Auth, Hash, Lang};
use Illuminate\Support\Facades\{URL, View, Response, Cookie, File, Mail, Blade, Cache};
use Illuminate\Support\Str;
use PhpOffice\PhpSpreadsheet\Calculation\MathTrig\Random;
use App;
class UsersController extends Controller
{

    public $modelName = 'User';
    public function __construct(Request $request)
    {
        View()->Share('modelName', $this->modelName);
        View()->Share('languageName', app()->getLocale());
        $this->request = $request;
    }

    public function LangChange(Request $request)
    {
        
        $lang_code = App::setLocale($request->lang);
        session()->put('locale', $request->lang);  
        return redirect()->back();
    }


    public function index(Request $request)
    {
        if ($request->wantsJson()) {
            $user = Auth::guard("api")->user();
        } else {
            $user = Auth::user();
        }

        $products       = Product::where('is_active', '1')->where('is_deleted', 0)->get();
        if (!empty($products)) {
            foreach ($products as &$product) {
                $product->product_image = Config('constants.PRODUCT_IMAGE_ROOT_URL') . $product->image;
            }
        }
        $categories     = Category::where('is_active', '1')->where('is_deleted', 0)->get();
        if (!empty($categories)) {
            foreach ($categories as &$category) {
                $category->category_image = Config('constants.CATEGORY_IMAGE_ROOT_URL') . $category->image;
            }
        }

        $blogs       = Blog::where('is_active', '1')->where('is_deleted', 0)->get();
        if (!empty($blogs)) {
            foreach ($blogs as &$blog) {
                $blog->blog_image = Config('constants.BLOG_IMAGE_ROOT_URL') . $blog->image;
            }
        }

        $compArr = array(
            'products'   => $products,
            'categories' => $categories,
            'blogs'      => $blogs,
        );
        if ($request->wantsJson()) {
            $response["status"] = "success";
            $response["msg"] = trans("fashi Details.");
            $response["data"] = $compArr;
            return $response;
        } else {
            return View::make('fashi.users.index', compact(array_keys($compArr)));
        }
    }


    public function addToCart(Request $request, $modelId = '')
    {
        if ($request->wantsJson()) {
            $user = Auth::guard('api')->user();
            $product_id =   $modelId;
        } else {
            $user = Auth::guard("users")->user();
            $product_id =    base64_decode($modelId);
        }
        if (empty($user)) {
            return redirect()->back();
        }
        $model = Cart::where('user_id', $user->id)->where('product_id', $product_id)->first();
        if (empty($model)) {
            $obj                     =  new Cart();
            $obj->user_id            =  Auth::guard('users')->user()->id;
            $obj->product_id         =  $product_id;
            $obj->quantity           =  !empty($request->input('quantity')) ? $request->input('quantity') : '1';
            $obj->save();
            if ($request->wantsJson()) {
                $response["status"] = "success";
                $response["msg"]    = trans("cart has been Added successfully.");
                return $response;
            } else {
                Session::flash('success', trans("Cart has been Added successfully"));
                return redirect()->route('Jeevan.index');
            }
        } else {
            $obj                     = $model;
            $qty                     = $model->quantity;
            $newQty                  = !empty($request->input('quantity')) ? $request->input('quantity') : '1';
            $obj->quantity           = $qty + $newQty;
            $obj->save();
            if ($request->wantsJson()) {
                $response["status"] = "success";
                $response["msg"]    = trans("cart has been Updated successfully.");
                return $response;
            } else {
                Session::flash('success', trans("Cart has been Update successfully"));
                return redirect()->route('Jeevan.index');
            }
        }
    }


    // start shopping cart
    public function shoppingCart(Request $request)
    {
        if ($request->wantsJson()) {
            $user = Auth::guard("api")->user();
        } else {
            $user = Auth::guard("users")->user();
        }
        if ($user) {
            $cartData = Cart::where('carts.user_id', $user->id)->where('products.is_active', 1)
                ->leftjoin('products', 'products.id', '=', 'carts.product_id')
                ->select('carts.*', 'products.name', 'products.price', 'products.discount', 'products.image')
                ->get();
            $compArr = array(
                'carts' => $cartData,
            );
            if ($request->wantsJson()) {
                $response["status"] = "success";
                $response["msg"] = trans("cart Details.");
                $response["data"] = $compArr;
                return $response;
            } else {
                return View::make('fashi.users.shopping-cart', compact('cartData'));
            }
        }
        return View::make('fashi.users.shopping-cart');
    }

    public function removeCartItem($id)
    {
        $cartItem = Cart::where('id', $id)->first();
        if (empty($cartItem)) {
            return redirect()->back();
        }
        $cartItem->delete();
        return redirect()->back();
    }


    // start checkout order
    public function checkout(Request $request)
    {
        if ($request->wantsJson()) {
            $user = Auth::guard("api")->user();
        } else {
            $user = Auth::guard("users")->user();
        }
        if (empty($user)) {
            return redirect()->back();
        }

        $carts = Cart::leftjoin('products', 'products.id', '=', 'carts.product_id')
            ->where('products.is_active', '1')->where('carts.user_id', $user->id)
            ->select('carts.*', 'products.name', 'products.price', 'products.discount', 'products.image')
            ->get();
        return View::make('fashi.users.check-out', compact('carts'));
    }


    // start order my product
    public function order(Request $request)
    {
        if ($request->wantsJson()) {
            $user = Auth::guard("api")->user();
        } else {
            $user = Auth::guard("users")->user();
        }
        if (empty($user)) {
            return redirect()->back();
        }
        $validator = Validator::make(
            $request->all(),
            array(
                'first_name'                   => 'required',
                'last_name'                    => 'required',
                'email'                        => 'required|email',
                'phone'                        => 'required',
                'country'                      => 'required',
                'street'                       => 'required',
                'town'                         => 'required',
            ),
            array(
                "first_name.required"              => trans("The first name field is required."),
                "last_name.required"               => trans("The last name field is required."),
                "email.required"                   => trans("The email field is required."),
                "phone.required"                   => trans("The phone field is required."),
                "country.required"                 => trans("The country field is required."),
                "street.required"                  => trans("The street field is required."),
                "town.required"                    => trans("The town field is required."),
            )
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $carts = Cart::leftjoin('products', 'products.id', '=', 'carts.product_id')
                ->where('products.is_active', '1')->where('carts.user_id', $user->id)
                ->select('carts.*', 'products.name', 'products.price', 'products.discount', 'products.image')
                ->get();
            $total_amount = 0;
            $total_discount = 0;
            if (!empty($carts)) {
                foreach ($carts as $cart) {
                    $total_amount += $cart->price * $cart->quantity;
                    $total_discount += $cart->discount * $cart->quantity;
                }
            }
            $obj                          = new Order();
            $obj->user_id                 = $user->id;
            $obj->order_number            = 'ORD'.random_int(100000, 999999);
            $obj->order_amount            = $total_amount - $total_discount;
            $obj->total_discount          = $total_discount;
            $obj->save();
            $lastId = $obj->id;

            foreach ($carts as $cartList) {
                $obj                      = new OrderItem();
                $obj->order_id            = $lastId;
                $obj->user_id             = $cartList->user_id;
                $obj->product_id          = $cartList->product_id;
                $obj->quantity            = $cartList->quantity;
                $obj->price               = $cartList->price;

                $total_price                   = $cartList->price * $cartList->quantity;
                $total_discount                = $cartList->discount * $cartList->quantity;
                $total                         = $total_price - $total_discount;

                $obj->total_price              = $total;
                $obj->save();
            }
            Cart::where('user_id', $user->id)->delete();
            Session::flash('success', trans("Order has been Order successfully"));
            return redirect()->route('Jeevan.index');
        }
    }

    public function shop(Request $request)
    {
        $products       = Product::where('is_active', '1')->where('is_deleted', 0)->get();
        if (!empty($products)) {
            foreach ($products as &$product) {
                $product->product_image = Config('constants.PROJECT_IMAGE_ROOT_URL') . $product->image;
            }
        }
        $categories     = Category::where('is_active', '1')->where('is_deleted', 0)->get();
        if (!empty($categories)) {
            foreach ($categories as &$category) {
                $category->category_image = Config('constants.CATEGORY_IMAGE_ROOT_URL') . $category->image;
            }
        }

        $compArr = array(
            'products' => $products,
            'categories' => $categories
        );
        if ($request->wantsJson()) {
            $response["status"] = "success";
            $response["msg"] = trans("shop Details.");
            $response["data"] = $compArr;
            return $response;
        } else {
            return View::make('fashi.users.shop', compact(array_keys($compArr)));
        }
    }

    public function contact(Request $request)
    {
        $compArr = array(
            'products' => '123',
            'categories' => '1234'
        );
        if ($request->wantsJson()) {
            $response["status"] = "success";
            $response["msg"] = trans("contact Details.");
            $response["data"] = $compArr;
            return $response;
        } else {
            return View::make('fashi.users.contact');
        }
    }



    public function contactEnquiry(Request $request)
    {
        $formData = $request->all();
        $validator = Validator::make(
            $request->all(),
            array(
                'name'                    => 'required',
                'email'                   => 'required|email|unique:contact_enquiries',
                'phone'                   => 'required',
                'subject'                 => 'required',
                // 'g-recaptcha-response'    => 'required'
            ),
            array(
                "name.required"                    => trans("The Name field is required."),
                "email.required"                   => trans("The Email field is required."),
                "phone.required"                   => trans("The Phone field is required."),
                "subject.required"                 => trans("The Subject field is required."),
                // "g-recaptcha-response.required" =>    trans("The google captcha is required"),
            )
        );
        if ($validator->fails()) {
            return redirect()->back()->withErrors($validator)->withInput();
        } else {
            $obj                               = new ContactEnquiry;
            $obj->name                         = $request->input('name');
            $obj->phone_number                 = $request->input('phone');
            $obj->email                        = $request->input('email');
            $obj->subject                      = $request->input('subject');
            $obj->message                      = $request->input('message');

            if ($request->hasFile('file')) {
                $extension                     =  $request->file('file')->getClientOriginalExtension();
                $fileName                      =  time() . '-file.' . $extension;
                $folderName                    =  strtoupper(date('M') . date('Y')) . "/";
                $folderPath                    =  config('constants.CONTACT_IMAGE_ROOT_PATH') . $folderName;
                if (!File::exists($folderPath)) {
                    File::makeDirectory($folderPath, $mode = 0777, true);
                }
                if ($request->file('file')->move($folderPath, $fileName)) {
                    $obj->file    =    $folderName . $fileName;
                }
            }
            $obj->save();
            Session::flash('success', trans(Config('constants.CONTACT_ENQUIRY.CONTACT_ENQUIRY_TITLE') . " has been added successfully"));
            return redirect()->back();
        }
    }



    public function aboutUs()
    {
        $defaul_code  =  Lang::getLocale();
        $languages    = Language::where('is_active', 1)->get();
        $language_id  = Language::where('languages.lang_code', $defaul_code)->value('id');
        $cmsData = AboutDescription::join('about_us', 'about_us.id', '=', 'about_descriptions.parent_id')
            ->where('about_us.is_active', '1')
            ->where('about_descriptions.language_id', $language_id)
            ->select('about_descriptions.*', 'about_us.image', 'about_us.created_at as about_us_created_at')
            ->first();
        return View::make('jeevansoft.users.about_us', compact('cmsData'));
    }




    public function serviceListing(Request $request)
    {
        $defaul_code  =  Lang::getLocale();
        $languages    = Language::where('is_active', 1)->get();
        $language_id  = Language::where('languages.lang_code', $defaul_code)->value('id');
        $services = ServiceDescription::join('services', 'services.id', '=', 'service_descriptions.parent_id')
            ->where('services.is_active', '1')
            ->where('service_descriptions.language_id', $language_id)
            ->select('service_descriptions.*', 'services.image', 'services.created_at as services_created_at')
            ->get();
        return View::make('jeevansoft.users.service_listing', compact('services'));
    }


    public function serviceDetail(Request $request, $id)
    {
        $services        = Service::where('id', $id)->where('is_active', 1)->where('is_deleted', 0)->first();
        // $other_images            = ServiceItemImage::where('parent_id', $services_sub_item->id)->get();
        // $related_item            = ServiceSubItem::where('parent_id', $services_sub_item->parent_id)->where('id', '!=', $services_sub_item->id)->get();
        return View::make('jeevansoft.users.service_detail', compact('services'));
    }

    public function productListing()
    {
        $portfolio_count    = Project::where('is_active', 1)->where('is_deleted', 0)->count();
        $defaul_code  =  Lang::getLocale();
        $languages    = Language::where('is_active', 1)->get();
        $language_id  = Language::where('languages.lang_code', $defaul_code)->value('id');

        $portfolio = ProjectDescription::join('projects', 'projects.id', '=', 'project_descriptions.parent_id')
            ->where('projects.is_active', '1')
            ->where('project_descriptions.language_id', $language_id)
            ->select('project_descriptions.*', 'projects.image', 'projects.created_at as projects_created_at')
            ->limit(4)->orderBy('id', 'Desc')->get();
        return View::make('jeevansoft.users.project_listing', compact('portfolio', 'portfolio_count'));
    }



    public function productDetail(Request $request, $id)
    {
        $portfolio_detail    = Project::where('id', $id)->where('is_active', 1)->where('is_deleted', 0)->first();

        $portfolios    = Project::where('is_active', 1)->where('is_deleted', 0)->get();

        return View::make('jeevansoft.users.project_detail', compact('portfolio_detail', 'portfolios'));
    }





    public function blogListing(Request $request)
    {
        $blog_title = Customhelper::getJeevanBlog();
        if (!empty($blog_title) && $blog_title->is_enable == 0) {
            return redirect()->back();
        } else {
            $blogs_count    = Blog::where('is_active', 1)->where('is_deleted', 0)->count();

            if (!empty($request->cat_id)) {
                $blogs    = Blog::where('category_id', $request->cat_id)->where('is_active', 1)->where('is_deleted', 0)->orderBy('created_at', 'asc')->paginate(10);
            } elseif (!empty($request->search)) {
                $blogs    = Blog::where('title', 'like', '%' . $request->search . '%')->where('is_active', 1)->where('is_deleted', 0)->orderBy('created_at', 'asc')->paginate(10);
            } else {
                $blogs    = Blog::where('is_active', 1)->where('is_deleted', 0)->orderBy('created_at', 'asc')->paginate(10);
            }
            $latesblogs    = Blog::where('is_active', 1)->where('is_deleted', 0)->orderBy('created_at', 'asc')->take(4)->get();


            return View::make('jeevansoft.users.blog_listing', compact('blogs', 'blogs_count', 'latesblogs'));
        }
    }

    public function blogDetail(Request $request, $id = 1)
    {
        $blogs_detail    = Blog::where('is_active', $id)->first();
        $latesblogs    = Blog::where('is_active', 1)->where('is_deleted', 0)->orderBy('created_at', 'asc')->take(4)->get();
        $seo        = '';
        $seo        = BlogSeo::where('parent_id', $request->id)->first();

        return View::make('jeevansoft.users.blog_detail', compact('blogs_detail', 'latesblogs', 'seo'));
    }
}
