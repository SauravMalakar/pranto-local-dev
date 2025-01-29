<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\TempImage;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;
use Illuminate\Support\Facades\File;
use Intervention\Image\Laravel\Facades\Image;
// use Intervention\Image\Facades\Image;

class CategoryController extends Controller
{
    public function index(Request $request){

        $categories = Category::latest();

        if(!empty($request->get('keywords'))){
            $categories = $categories->where('name','like','%'.$request->get('keywords').'%');
        }

        $categories = $categories->paginate(10);
        //dd($categories);

        $data['categories']=$categories;
        return view('category.category', compact('categories'));
    }

    public function addcategory(){
        return view('category.addcategory');
    }
    public function addcategoryitem(Request $request){
        // dd($request->all());


        $validator = Validator::make($request->all(),[
            'category_name' => 'required'
        ]);

        if($validator->passes()){
            $category = new Category();
            $category->name= $request->category_name;
            $category->status= $request->status ?? '';
            
            $category->save();

            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);

                $newImageName = $category->id.'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/category/'.$newImageName;
                File::copy($sPath, $dPath);

                $dThumbPath = public_path().'/uploads/category/thumbs/'.$newImageName;
                $image= Image::read($dPath);
                $image->resize(212, 212);
                // $image->fit(212, 212, function($constraint){
                //     $constraint->upsize();
                // });
                $image->save($dThumbPath);

                $category->image= $newImageName;
                $category->save();
            }

            $request->session()->flash('success','Category added.');

            return response()->json([
                'status'=>true,
                'message'=>'Category added.'
            ]);
            return redirect()->route('admin_category');

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
            return view('category.addcategory');
        }
    }
    public function addcategoryimage(Request $request){
        $image = $request->image;

        if (!empty($image)) {

            $ext = $image->getClientOriginalExtension();
            $newName = time().'.'.$ext;

            $tempImage=new TempImage();
            $tempImage->name =$newName;
            $tempImage->save();

            $image->move(public_path().'/temp',$newName);

            return response()->json(
                [
                    'status'=>true, 
                    'image_id'=>$tempImage->id,
                    'message'=> 'Image Uploaded'
                ]
            );
        }
    }

    public function editcategory($category_id, Request $request){
        
        // dd($request->all());
        $category = Category::find($category_id);
        if(empty($category)){
            return redirect()->route('admin_category');
        }

        return view('category.editcategory', compact('category'));
    }
    public function editcategoryitem($category_id, Request $request){
        // dd($request->all());
        $category = Category::find($category_id);

        if(empty($category)){
            $request->session()->flash('error', 'Category not found.');
            
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Category not found.'
            ]);
        }

        $validator = Validator::make($request->all(),[
            'category_name' => 'required'
        ]);

        if($validator->passes()){
            
            $category->name= $request->category_name;
            $category->status= $request->status ?? '';
            
            $category->save();

            // dd($category);
            $oldImage = $category->image;

            if (!empty($request->image_id)) {
                $tempImage = TempImage::find($request->image_id);
                $extArray = explode('.', $tempImage->name);
                $ext = last($extArray);

                $newImageName = $category->id.'-'.time().'.'.$ext;
                $sPath = public_path().'/temp/'.$tempImage->name;
                $dPath = public_path().'/uploads/category/'.$newImageName;
                File::copy($sPath, $dPath);

                $dThumbPath = public_path().'/uploads/category/thumbs/'.$newImageName;
                
                $image= Image::read($dPath);
                $image->resize(212, 212);
                // $image->fit(212, 212, function($constraint){
                //     $constraint->upsize();
                // });
                $image->save($dThumbPath);

                $category->image= $newImageName;
                $category->save();

                File::delete(public_path().'uploads/category/thumbs/'.$oldImage);
                File::delete(public_path().'uploads/category/'.$oldImage);
            }

            $request->session()->flash('success','Category Updated.');

            return response()->json([
                'status'=>true,
                'message'=>'Category Updated.'
            ]);
            return redirect()->route('admin_category');

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
            return view('category.category');
        }
    }

    public function deletecategoryitem($category_id, Request $request){
        
        $category = Category::find($category_id);

        if(!$category){
            $request->session()->flash('error', 'Category not found.');
            return response()->json([
                'status' => true,
                'message' => 'Category not found.'
            ]);
            // return redirect()->route('admin_category');
        }

        // Check if files exist before attempting to delete them
        $imagePaths = [
            public_path('uploads/category/thumbs/'.$category->image),
            public_path('uploads/category/'.$category->image),
        ];

        foreach ($imagePaths as $imagePath) {
            // Only attempt to delete the file if it exists
            if (File::exists($imagePath)) {
                File::delete($imagePath);
            }
        }

        $category->delete();

        $request->session()->flash('success', 'Category Deleted.');

        return response()->json([
            'status' => true,
            'message' => 'Category Deleted.'
        ]);

    }

}
