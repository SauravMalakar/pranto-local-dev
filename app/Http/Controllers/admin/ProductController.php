<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;

use App\Models\Category;
use App\Models\Product;
use App\Models\SubCategory;
use App\Models\ProductImage;

use App\Models\TempImage;
use App\Models\Uom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Str;

use Intervention\Image\Laravel\Facades\Image;
// use Intervention\Image\Facades\Image;


class ProductController extends Controller
{
    public function index(Request $request){

        // $data =[];

        // $products = Product::latest('id')->with('product_images');
        $products = Product::select('products.*','uoms.name as uomName')->latest('id')
        ->leftJoin('uoms','uoms.id','products.uom_id');

        if($request->get('keyword')!=""){
            $products = $products->where('title','like','%'.$request->keyword.'%');
        }

        $products = $products->paginate();

        // dd($products);
        // exit();

        $data['products'] = $products;
        return view('product.list', $data);
    }

    public function addproduct(){

        $data =[];
        $category = Category::orderBy('name', 'ASC')->get();
        $uoms = Uom::orderBy('name', 'ASC')->get();
        $data['uoms'] = $uoms;
        $data['category'] = $category;
        
        return view('product.create', $data);
    }

    public function addproductitem(Request $request){

        // dd($request->image_array);
        // exit();
        
        $rules =[
            'title' => 'required',
            'price' => 'required',
            'track_qty' => 'required|in:Yes, No',
            'category' => 'required|numeric',
            'sub_category' => 'required|numeric',
        ];

        if(!empty($request->track_qty) && $request->track_qty == 'Yes'){
            $rules['qty'] = 'required|numeric';
        }

        $validator = Validator::make($request->all(), $rules);

        if($validator->passes()){

            $product = new Product();
            $product->title= $request->title;
            $product->description= $request->description;
            $product->price= $request->price;
            $product->compare_price= $request->compare_price;
            $product->sku= $request->sku ?? 'CHEFS-'.Str::upper(Str::random(3).mt_rand(100, 999));
            $product->barcode= $request->barcode;
            $product->track_qty= $request->track_qty;
            $product->qty= $request->qty;
            $product->uom_id= $request->uom;
            $product->category_id= $request->category;
            $product->sub_category_id= $request->sub_category;
            $product->is_featured= $request->is_featured ?? '';
            
            $product->save();

            //save Gallery Images
            if(!empty($request->image_array)){
                foreach($request->image_array as $temp_image_id){

                    $tempImageInfo = TempImage::find($temp_image_id);
                    $extImageArray = explode('.', $tempImageInfo->name);
                    $extImage = last($extImageArray);

                    $productImage = new ProductImage();
                    $productImage->product_id = $product->id;
                    $productImage->image = 'NULL';
                    $productImage->save();

                    $imageName = $product->id.'-'.$productImage->id.'-'.time().'.'.$extImage;
                    $productImage->image = $imageName;
                    $productImage->save();

                    //large resize
                    $sPath = public_path().'/temp/'.$tempImageInfo->name;
                    $dPath = public_path().'/uploads/product/large/'.$imageName;
                    $image = Image::read($sPath);
                    $image->resize(800, 600);
                    $image->save($dPath);

                    //small resize
                    $dPath = public_path().'/uploads/product/small/'.$imageName;
                    $image = Image::read($sPath);
                    $image->resize(69, 52);
                    $image->save($dPath);

                }
            }

            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);

                $newImageName = $product->id.'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/product/'.$newImageName;
                File::copy($sPath, $dPath);

                $dThumbPath = public_path().'/uploads/product/thumbs/'.$newImageName;
                $image= Image::read($sPath);
                $image->resize(336, 252);
                $image->save($dThumbPath);

                $product->image= $newImageName;
                $product->save();
            }

            $request->session()->flash('success','Product added.');

            return response()->json([
                'status'=>true,
                'message'=>'Product added.'
            ]);
            return redirect()->route('admin_product');

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
            return view('addproduct');
        }
    }
    public function addproductimage(Request $request){
        $image = $request->image;

        if (!empty($image)) {

            $ext = $image->getClientOriginalExtension();
            $newName = time().'.'.$ext;

            $tempImage=new TempImage();
            $tempImage->name =$newName;
            $tempImage->save();

            $image->move(public_path().'/temp/',$newName);

            $sPath = public_path().'/temp/'.$tempImage->name;
            $dPath = public_path().'/temp/thumb/'.$newName;
            File::copy($sPath, $dPath);
            
            $dThumbPath = public_path().'/temp/thumb/'.$newName;
            $image= Image::read($dPath);
            $image->resize(336, 252);
            $image->save($dThumbPath);

            // $sourcePath = public_path().'/temp'.$newName;
            // $destPath = public_path().'/temp/thumb/'.$newName;
            // try {
            //     $image = Image::read($sourcePath);
            //     $image->resize(300, 275);
            //     $image->save($destPath);
            // } catch (\Intervention\Image\Exceptions\DecoderException $e) {
            //     return response()->json(['status' => false, 'message' => 'Image decoding failed: ' . $e->getMessage()]);
            // }

            return response()->json(
                [
                    'status'=>true, 
                    'image_id'=>$tempImage->id,
                    'ImagePath'=>asset('public/temp/thumb/'.$newName),
                    'message'=> 'Image Uploaded'
                ]
            );
        }
    }

    public function getSubcategories(Request $request) {
        $subcategories = SubCategory::where('category_id', $request->category_id)->get();
        return response()->json(['subcategories' => $subcategories]);
    }

    public function editproduct($product_id, Request $request){
        
        $product = Product::find($product_id);

        if(empty($product)){

            $request->session()->flash('error', 'Product not found!');
            return redirect()->route('admin_product');

        }

        $productImages = ProductImage::where('product_id', $product->id)->get();
        $subcategories = SubCategory::where('category_id', $product->category_id)->get();
        $category = Category::orderBy('name', 'ASC')->get();
        $uoms = Uom::orderBy('name', 'ASC')->get();
        
        $data =[];
        $data['uoms'] = $uoms;
        $data['category'] = $category;
        $data['subcategory'] = $subcategories;
        $data['product'] = $product;
        $data['productImages'] = $productImages;

        return view('product.edit', $data);
    }
    public function editproductitem($product_id, Request $request){

        $product = Product::find($product_id);
        
        $rules =[
            'title' => 'required',
            'status' => 'required',
            'price' => 'required',
            'track_qty' => 'required|in:Yes,No',
            'category' => 'required|numeric',
            'sub_category' => 'required|numeric',
        ];

        if(!empty($request->track_qty) && $request->track_qty == 'Yes'){
            $rules['qty'] = 'required|numeric';
        }

        $validator = Validator::make($request->all(), $rules);

        if($validator->passes()){

            $product->title= $request->title;
            $product->description= $request->description;
            $product->price= $request->price;
            $product->uom_id= $request->uom;
            $product->compare_price= $request->compare_price;
            $product->track_qty= $request->track_qty;
            $product->qty= $request->qty;
            $product->category_id= $request->category;
            $product->status= $request->status;
            $product->sub_category_id= $request->sub_category;
            $product->is_featured= $request->is_featured ?? '';
            
            $product->save();

            $request->session()->flash('success','Product updated.');

            return response()->json([
                'status'=>true,
                'message'=>'Product updated.'
            ]);
            return redirect()->route('admin_product');

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
            return view('addproduct');
        }
    }
    public function editproductimage(Request $request){

        $image = $request->file('image');
        $extImage = $image->getClientOriginalExtension();
        $sPath = $image->getPathName();

        $productImage = new ProductImage();
        $productImage->product_id = $request->product_id;
        $productImage->image = 'NULL';
        $productImage->save();

        $imageName = $request->product_id.'-'.$productImage->id.'-'.time().'.'.$extImage;
        $productImage->image = $imageName;
        $productImage->save();

        // thumbs
        $dPath = public_path().'/uploads/product/thumbs/'.$imageName;
        $image = Image::read($sPath);
        $image->save($dPath);

        //large resize
        // $sPath = $tempImagePath;
        $dPath = public_path().'/uploads/product/large/'.$imageName;
        $image = Image::read($sPath);
        $image->resize(800, 600);
        $image->save($dPath);

        //small resize
        $dPath = public_path().'/uploads/product/small/'.$imageName;
        $image = Image::read($sPath);
        $image->resize(69, 52);
        $image->save($dPath);

        return response()->json([
            'status' => true,
            'image_id' => $productImage->id,
            'imagePath' => asset('public/uploads/product/small/',$productImage->image),
            'message' => 'Image Uploaded.'
        ]);
    }

    public function deleteproductimage(Request $request){
        $productImage = ProductImage::find($request->id);

        if (empty($productImage)) {
            return response()->json([
                'status' => false,
                'message' => 'Image not found.'
            ]);
        }
        File::delete(public_path('public/uploads/product/thumbs/'.$productImage->image));
        File::delete(public_path('public/uploads/product/large/'.$productImage->image));
        File::delete(public_path('public/uploads/product/small/'.$productImage->image));

        $productImage->delete();

        return response()->json([
            'status' => true,
            'message' => 'Image deleted.'
        ]);
    }

    public function deleteproduct($product_id, Request $request){
        $product = Product::find($product_id);

        if (empty($product)) {

            $request->session()->flash('error','Product not found.');

            return response()->json([
                'status' => false,
                'message' => 'Product not found.'
            ]);
        }

        $productImages = ProductImage::where('product_id', $product_id)->get();

        if (!empty($productImages)) {
            foreach ($productImages as $productImage) {
                File::delete(public_path('public/uploads/product/thumbs/'.$productImage->image));
                File::delete(public_path('public/uploads/product/large/'.$productImage->image));
                File::delete(public_path('public/uploads/product/small/'.$productImage->image));
            }
            ProductImage::where('product_id', $product_id)->delete();
        }
        $product->delete();

        return response()->json([
            'status' => true,
            'message' => 'Product deleted.'
        ]);
        
        $request->session()->flash('success','Product deleted.');
        return redirect()->route('admin_product');
    }
}
