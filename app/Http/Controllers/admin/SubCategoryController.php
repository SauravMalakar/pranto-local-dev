<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\SubCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class SubCategoryController extends Controller
{
    public function index(Request $request){

        $subcategories = SubCategory::select('sub_categories.*','categories.name as categoryName')->latest('id')
        ->leftJoin('categories','categories.id','sub_categories.category_id');

        if(!empty($request->get('keywords'))){
            $subcategories = $subcategories->where('sub_categories.name','like','%'.$request->get('keywords').'%');
        }

        $subcategories = $subcategories->paginate(10);
        //dd($categories);

        $data['subcategories']=$subcategories;
        return view('sub_category.list', compact('subcategories'));
    }

    public function create(){
        $categories = Category::orderBy('name', 'ASC')->get();
        $data['categories'] = $categories;
        return view('sub_category.create', $data);
    }
    public function store(Request $request){
        $validator = Validator::make($request->all(),
        [
            'name' => 'required',
            'category_id' => 'required',
            'status' => 'required'
        ]);

        if ($validator->passes()) {

            // Save Sub-Category
            $subcategory = new SubCategory();
            $subcategory->name = $request->name;
            $subcategory->category_id = $request->category_id;
            $subcategory->status = $request->status;
            $subcategory->save();

            $request->session()->flash('success','Sub-category added.');

            
            return response()->json(
                ['status' => true,
                'message' => 'Sub-category added']
            );
            return redirect()->route('admin_sub_category');

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }

    }

    public function edit($subcategory_id, Request $request){
        
        // dd($request->all());
        $subcategory = SubCategory::find($subcategory_id);

        if(empty($subcategory)){

            $request->session()->flash('error', 'Sub-category not found!');

            return redirect()->route('admin_sub_category');

        }

        $categories = Category::orderBy('name', 'ASC')->get();

        // dd($categories, $subcategory);
        // exit();

        $data['categories'] = $categories;
        $data['subcategory'] = $subcategory;
        
        return view('sub_category.edit', $data);
    }
    public function update($subcategory_id, Request $request){
        // dd($request->all());
        $subcategory = SubCategory::find($subcategory_id);

        if(empty($subcategory)){
            $request->session()->flash('error', 'Sub-category not found.');
            
            return response()->json([
                'status' => false,
                'notFound' => true,
                'message' => 'Sub-category not found.'
            ]);
        }

        $validator = Validator::make($request->all(),[
            'name' => 'required',
            'category_id' => 'required',
            'status' => 'required'
        ]);

        if($validator->passes()){
            
            $subcategory->name= $request->name;
            $subcategory->category_id= $request->category_id;
            $subcategory->status= $request->status ?? '';
            
            $subcategory->save();

            // dd($subcategory); 
            // exit();

            $request->session()->flash('success','Sub-category Updated.');

            return response()->json([
                'status'=>true,
                'message'=>'Sub-category Updated.'
            ]);
            return redirect()->route('admin_sub_category');

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors()
            ]);
            return view('sub_category.list');
        }
    }

    public function deletesubcategoryitem($subcategory_id, Request $request){
        
        $subcategory = SubCategory::find($subcategory_id);

        if(!$subcategory){
            $request->session()->flash('error', 'Sub-category not found!');
            return response()->json([
                'status' => true,
                'message' => 'Sub-category not found.'
            ]);
            // return redirect()->route('admin_sub_category');
        }

        $subcategory->delete();

        $request->session()->flash('success', 'Sub-category deleted.');

        return response()->json([
            'status' => true,
            'message' => 'Sub-category deleted.'
        ]);
        return redirect()->route('admin_sub_category');

    }
}
