<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Product;
use Illuminate\Http\Request;

class TagController extends Controller{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\Response
     */
    public function index(){
        //
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request){

        $validatedData = $request->validate([
            'name' => 'required|unique:posts|max:255',
            'slug' => 'required|unique:posts|max:255',
            'description' => 'required',
            'image' => 'required|image',
            "product_id" => [
                function ($attribute, $value, $fail) {
                    if(!isset($attribute->product_id)){
                        if(!isset($attribute->article_id)){
                            $fail("one of product_id or article_id is required!");
                            return;
                        }
                    }
                },
            ],
            "article_id" => "",
        ]);

        return response()->json("everything is ok!");
        $post = Product::query()->find(1);

        $comment = $post->comments()->create([
            'message' => 'A new comment.',
        ]);


    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function show($id){
        //
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id){
        //
    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id){
        //
    }
}
