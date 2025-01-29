<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index($categoryName=null)
    {
        $getProducts=Product::where('status', 1);
        $getProducts=$getProducts->orderBy('title','ASC');
        $getProducts = $getProducts->get();

        if (!empty($categoryName)) {
            $category=Category::where('name', strtolower($categoryName))->first();
            $getProducts=$getProducts->where('category_id', $category->id);
        }
        $data=array();
        //$getProducts=Product::orderBy('title','ASC')->get();
        $data['getProducts'] = $getProducts;
        // dd($data);
        // exit();
        return view('index', $data);

        // return view('index');
        
    }

    public function shop($categoryName=null)
    {
        $getProducts=Product::where('status', 1);
        $getProducts=$getProducts->orderBy('title','ASC');
        $getProducts = $getProducts->get();

        if (!empty($categoryName)) {
            $category=Category::where('name', strtolower($categoryName))->first();
            $getProducts=$getProducts->where('category_id', $category->id);
        }
        $data=array();
        //$getProducts=Product::orderBy('title','ASC')->get();
        $data['getProducts'] = $getProducts;
        // dd($data);
        // exit();
        return view('shop', $data);

        // return view('index');
        
    }

    public function authenticator()
    {
        return view('authuser');
    }
    public function cart()
    {
        return view('cart');
    }

}
