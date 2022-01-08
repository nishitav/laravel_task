<?php

namespace App\Http\Controllers;

use App\Products;
use Illuminate\Http\Request;

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
            $product = Products::create($request->post());
            return response()->json([
                'status' => true,
                'message' => 'Product Created Successfully.',
                'product' => $product
            ]);
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
     * @param  \App\Models\Products  $product
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Products $product) {
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
            return response()->json([
                'status' => true,
                'message' => 'Product Updated Successfully.',
                'product' => $product
            ]);
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Products  $product
     * @return \Illuminate\Http\Response
     */
    public function destroy(Products $product) {
        $product->delete();
        return response()->json([
            'status' => true,
            'message' => 'Product Deleted Successfully.'
        ]);
    }

}
