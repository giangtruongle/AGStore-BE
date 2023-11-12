<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ProductCategoryRequest;
use App\Http\Resources\ProductCategoryResource;
use App\Models\ProductCategory;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class ProductCategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = ProductCategory::make()->latest()->get();
        return ProductCategoryResource::collection($datas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductCategoryRequest $request)
    {
        $fileNameCategory = null;

        if ($request->hasFile('image_url_pc')) {
                $originName = $request->file('image_url_pc')->getClientOriginalName();
                $fileNameCategory = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->file('image_url_pc')->getClientOriginalExtension();
                $fileNameCategory = $fileNameCategory . '_' . time() . '.' . $extension;
                $request->file('image_url_pc')->move(public_path('productCategoryImages'), $fileNameCategory);
        }
        
        $product_category = ProductCategory::create([
            'name'=> $request->name,
            'slug'=> Str::slug($request->name),
            'status' => $request->status,
            'image_url_pc' => asset('productCategoryImages/'.$fileNameCategory),
        ]);

        if($product_category){
            return ProductCategoryResource::make($product_category);
        };
        return response()->json(['error' => 'Something is wrong!'], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(ProductCategory::whereId($id)->first());
        // return ProductCategoryResource::make($product_category);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, ProductCategory $product_category)
    {

        $fileNameCategory = $product_category->image_url_pc;
        
        if ($request->hasFile('image_url_pc')) {

            //Remove old images
           if (is_null($product_category->image_url) && file_exists("productCategoryImages/" . $product_category->image_url_pc)) {
                unlink("productCategoryImages/" . $product_category->image_url_pc);
            }

            $originName = $request->file('image_url_pc')->getClientOriginalName();
            $fileNameCategory = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('image_url_pc')->getClientOriginalExtension();
            $fileNameCategory = $fileNameCategory . '_' . time() . '.' . $extension;
            $request->file('image_url_pc')->move(public_path('productCategoryImages'), $fileNameCategory);

            $product_category->update([
                'name'=>$request->name,
                'slug'=> Str::slug($request->name),
                'image_url_pc' => asset('productCategoryImages/'.$fileNameCategory),
                'status'=>$request->status,
            ]);
        }else{
            $product_category->update([
                'name'=>$request->name,
                'slug'=> Str::slug($request->name),
                'image_url_pc' => asset($fileNameCategory),
                'status'=>$request->status,
            ]);
        }
        
        return ProductCategoryResource::make($product_category);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProductCategory $product_category)
    {
        $product_category->delete();
        return response()->json(['message' => 'Delete Success!'], 201);
    }
}
