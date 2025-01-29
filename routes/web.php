<?php

use App\Http\Controllers\admin\CategoryController;
use App\Http\Controllers\admin\SubCategoryController;
use App\Http\Controllers\admin\DashboardController;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\UserController;
use App\Http\Controllers\AdminController;
use App\Http\Controllers\admin\ProductController;
use App\Http\Controllers\admin\UomController;

/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/

// Route::get('/', function () {
//     return view('welcome');
// });


Route::get('/', [UserController::class, 'index'])->name('home');
Route::get('/shop/{categoryName?}', [UserController::class, 'shop'])->name('home_shop');
Route::get('/category/{categoryName?}', [UserController::class, 'index'])->name('home_category');


Route::group(['prefix'=>'admin'], function(){

    Route::group(['middleware'=>'admin.guest'], function(){
        Route::get('/login', [AdminController::class, 'index'])->name('admin_login');
        Route::post('/authenticate', [AdminController::class, 'authenticate'])->name('admin_authenticate');
    });
    
    Route::group(['middleware'=>'admin.auth'], function(){
        Route::get('/dashboard', [DashboardController::class, 'index'])->name('admin_dashboard');

        //Route Category
        Route::get('/category', [CategoryController::class, 'index'])->name('admin_category');
        Route::get('/addcategory', [CategoryController::class, 'addcategory'])->name('add_category');
        Route::post('/addcategoryitem', [CategoryController::class, 'addcategoryitem'])->name('add_category_item');
        Route::post('/addcategoryimage', [CategoryController::class, 'addcategoryimage'])->name('add_category_image');
        Route::get('/editcategory/{category}', [CategoryController::class, 'editcategory'])->name('edit_category');
        Route::put('/editcategoryitem/{category}', [CategoryController::class, 'editcategoryitem'])->name('edit_category_item');
        Route::delete('/deletecategory/{category}', [CategoryController::class, 'deletecategoryitem'])->name('delete_category');
        
        //Route Sub-Category
        Route::get('/subcategory', [SubCategoryController::class, 'index'])->name('admin_sub_category');
        Route::get('/addsubcategory', [SubCategoryController::class, 'create'])->name('add_sub_category');
        Route::post('/addsubcategoryitem', [SubCategoryController::class, 'store'])->name('add_sub_category_item');
        Route::get('/editsubcategory/{subcategory}', [SubCategoryController::class, 'edit'])->name('edit_sub_category');
        Route::put('/editsubcategoryitem/{subcategory}', [SubCategoryController::class, 'update'])->name('edit_sub_category_item');
        Route::delete('/deletesubcategory/{subcategory}', [SubCategoryController::class, 'deletesubcategoryitem'])->name('delete_sub_category');
        
        //Route UOM
        Route::get('/uom', [UomController::class, 'index'])->name('admin_uom');
        Route::get('/adduom', [UomController::class, 'create'])->name('add_uom');
        Route::post('/adduomitem', [UomController::class, 'store'])->name('add_uom_item');
        Route::delete('/deleteuom/{uom}', [UomController::class, 'deleteuomitem'])->name('delete_uom');
        
        //Route Product
        Route::get('/product', [ProductController::class, 'index'])->name('admin_product');
        Route::get('/addproduct', [ProductController::class, 'addproduct'])->name('add_product');
        Route::post('/addproductitem', [ProductController::class, 'addproductitem'])->name('add_product_item');
        Route::get('/subcategories', [ProductController::class, 'getSubcategories'])->name('get_product_subcategories');
        Route::post('/addproductimage', [ProductController::class, 'addproductimage'])->name('add_product_image');
        Route::get('/editproduct/{product}', [ProductController::class, 'editproduct'])->name('edit_product');
        Route::put('/editproductitem/{product}', [ProductController::class, 'editproductitem'])->name('edit_product_item');
        Route::post('/editproductimage', [ProductController::class, 'editproductimage'])->name('edit_product_image');
        Route::delete('/deleteproductimage', [ProductController::class, 'deleteproductimage'])->name('delete_product_image');
        Route::delete('/deleteproduct/{product}', [ProductController::class, 'deleteproduct'])->name('delete_product');
        
        //Route logout 
        Route::get('/logout', [DashboardController::class, 'logout'])->name('admin_logout');
    });

});