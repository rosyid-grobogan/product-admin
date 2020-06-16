<?php

namespace App\Http\Controllers\API;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Product;
use App\Models\Category;

class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $products = Product::with('category.parent')->latest()->paginate(50);

        $data = [
            'products'=> $products
        ];
        return $data;
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return ['message' => 'Success'];
        // validation
        $this->validate($request,[
            'title' => 'required|string|max:255',
            'brand' => 'required|string|max:255|',
            'category_id' => 'required|integer',
            'description' => ''
        ]);

//return $request;
        return Product::create([
            'title' => $request['title'],
            'brand' => $request['brand'],
            'category_id' => $request['category'],
            'description' => $request['description'],
        ]);        
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        $this->validate($request,[
            'title' => 'required|string|max:255',
            'brand' => 'required|string|max:255|',
            'category_id' => 'required|integer',
            'description' => ''
        ]);   
        
        $product->update($request->all());
        return ['message' => 'Updated is successfully'];
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $product = Product::findOrFail($id);

        $product->delete();
        return ['message' => 'Product deleted'];
    }

}
