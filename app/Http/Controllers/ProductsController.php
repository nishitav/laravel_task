<?php

namespace App\Http\Controllers;

use App\Products;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ProductsController extends Controller {

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index() {
        $products = Products::all();
        return response()->json($products);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request) {
        $data = $request->post();
        $validation = Products::validationRules();
        $validator = Validator::make($data, $validation);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(), 
                'status' => 'error', 
                'errors' => $validator->messages()
            ], 422);
        } else {
            return Products::create($data);
        }
        
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Products  $product
     * @return \Illuminate\Http\Response
     */
    public function show(Products $product) {
        return response()->json($product);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request) {
        $data = $request->post();
        $validation = Products::validationRules();
        $validation['upc'] = 'required|unique:products,upc,'.$request->id;
        $validator = Validator::make($data, $validation);
        if ($validator->fails()) {
            return response()->json([
                'message' => $validator->messages()->first(), 
                'status' => 'error', 
                'errors' => $validator->messages()
            ], 422);
        } else {
            return Products::where('id', $request->id)->update([
                'name' => $request->name,
                'upc' => $request->upc,
                'price' => $request->price,
                'status' => $request->status,
                'image' => $request->image,
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroy(Request $request) {
        // validate request
        $this->validate($request, [
            'id' => 'required',
        ]);
        return Products::where('id', $request->id)->delete();
    }
    
    /**
     * Remove multiple records
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function destroyMany(Request $request) {
        $data = $request->post(); 
        if (empty($data) || (count($data) < 1)) {
            return response()->json([
                'message' => "Something went wrong. Please try again later.", 
                'status' => 'error', 
                'errors' => "Something went wrong. Please try again later."
            ], 422);
        } else {
            return Products::whereIn('id', $data)->delete();
        }
    }

}
