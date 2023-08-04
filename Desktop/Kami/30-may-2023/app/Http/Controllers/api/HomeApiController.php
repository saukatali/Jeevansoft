<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

use App\Config;
use App\Models\Category;
use App\Models\Product;
use App\Models\Blog;

use App\Models\User;
use Illuminate\Support\Facades\{DB, Session, Validator, Redirect, Auth, Hash};
use Illuminate\Support\Facades\{URL, View, Response, Cookie, File, Mail, Blade, Cache};
use Illuminate\Support\Str;


class HomeApiController extends Controller
{
 
    public function category(){
        $category  = Category::where('is_active', 1)->where('is_deleted', 0)->get();
        return response()->json([
            "status"=>'success',
            'data'  =>$category,
        ]);
    }

    public function blog(){
        $blog  = Blog::where('is_active', 1)->where('is_deleted', 0)->get();
        return response()->json([
            "status"=>'success',
            'data'  =>$blog,
        ]);
    }





}
