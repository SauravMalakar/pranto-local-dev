<?php

namespace App\Http\Controllers\admin;

use App\Http\Controllers\Controller;
use App\Models\Uom;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class UomController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index(Request $request)
    {
        $uom = Uom::latest();

        if(!empty($request->get('keywords'))){
            $uom = $uom->where('uom.name','like','%'.$request->get('keywords').'%');
        }

        $uom = $uom->paginate(10);
        //dd($categories);

        $data['uoms']=$uom;
        return view('uom.list', $data);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('uom.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $validator = Validator::make($request->all(),
        [
            'name' => 'required'
        ]);

        if ($validator->passes()) {

            // Save Uom
            $uom = new Uom();
            $uom->name = $request->name;
            $uom->save();

            $request->session()->flash('success','Uom added.');

            
            return response()->json(
                ['status' => true,
                'message' => 'Uom added']
            );
            return redirect()->route('admin_uom');

        }else{
            return response()->json([
                'status' => false,
                'errors' => $validator->errors(),
            ]);
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Uom  $uom
     * @return \Illuminate\Http\Response
     */
    public function show(Uom $uom)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Uom  $uom
     * @return \Illuminate\Http\Response
     */
    public function edit(Uom $uom)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Uom  $uom
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Uom $uom)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Uom  $uom
     * @return \Illuminate\Http\Response
     */

    public function deleteuomitem($uom_id, Request $request){
        
        $uom = Uom::find($uom_id);

        if(!$uom){
            $request->session()->flash('error', 'Uom not found!');
            return response()->json([
                'status' => true,
                'message' => 'Uom not found.'
            ]);
            // return redirect()->route('admin_uom');
        }

        $uom->delete();

        $request->session()->flash('success', 'Uom deleted.');

        return response()->json([
            'status' => true,
            'message' => 'Uom deleted.'
        ]);
        return redirect()->route('admin_uom');

    }
}
