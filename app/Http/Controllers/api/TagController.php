<?php

namespace App\Http\Controllers\api;

use App\Http\Controllers\Controller;
use App\Models\Article;
use App\Models\Image;
use App\Models\Product;
use App\Models\Tag;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Validator;

class TagController extends Controller{
    /**
     * Display a listing of the resource.
     * @return \Illuminate\Http\JsonResponse
     */
    public function index(){
        return response()->json(Tag::paginate(10));
    }

    /**
     * Store a newly created resource in storage.
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\JsonResponse
     */
    public function store(Request $request){

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:tags|max:255',
            'slug' => 'required|unique:tags|max:255',
            'description' => 'required',
            'image' => 'required|image',
        ]);

        if($validator->fails())
            return response()->json($validator->errors(), 400);

        $path = $request->file('image')->store('/images/');

        $image = Image::query()->create([
            "path" => $path,
        ]);

        /*if(isset($request->product_id)){
            $model = Product::query()->find($request->product_id);
        } else {
            $model = Article::query()->find($request->article_id);
        }
        $model->tags()
        */

        $tag = Tag::query()->create([
            'name' => $request->name,
            'slug' => $request->slug,
            'description' => $request->description,
            'image_id' => $image->id,
        ]);

        return response()->json($tag);
    }

    /**
     * Display the specified resource.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function show($id){
        return response()->json(Tag::query()->findOrFail($id));
    }

    /**
     * Update the specified resource in storage.
     * @param \Illuminate\Http\Request $request
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function update(Request $request, $id){

        $validator = Validator::make($request->all(), [
            'name' => 'required|unique:tags|max:255',
            'slug' => 'required|unique:tags|max:255',
            'description' => 'required',
            'image' => 'nullable|image',
        ]);

        if($validator->fails())
            return response()->json($validator->errors(), 400);

        $tag = Tag::query()->findOrFail($id);

        if(isset($request->image)){
            $path = $request->file('image')->store('/images/');

            $image = Image::query()->create([
                "path" => $path,
            ]);
            $tag->image_id = $image->id;
        }

        $tag->name = $request->name;
        $tag->slug = $request->name;
        $tag->description = $request->name;
        $tag->save();

        return response()->json($tag);

    }

    /**
     * Remove the specified resource from storage.
     * @param int $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id){
        $tag = Tag::query()->findOrFail($id);
        $tag->delete();
        return response()->json(["message" => "tag deleted successfully!"]);
    }

    public function search_tags(Request $request){

        if(!isset($request->search))
            return response()->json(["message" => "please enter search word!"] , 400);

        $tags = Tag::query()->where("name" , "LIKE" , "%" . $request->search . "%")->get();

        return response()->json($tags);
    }
}
