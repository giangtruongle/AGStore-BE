<?php

namespace App\Http\Controllers\Api\V1;

use App\Http\Controllers\Controller;
use App\Http\Requests\Api\V1\ProductStoreRequest;
use App\Http\Resources\ProductResource;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;




class ProductController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $datas = Product::latest()->get();
        return ProductResource::collection($datas);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(ProductStoreRequest $request)
    {
        $fileName = null;

        if ($request->hasFile('image_url')) {
                $originName = $request->file('image_url')->getClientOriginalName();
                $fileName = pathinfo($originName, PATHINFO_FILENAME);
                $extension = $request->file('image_url')->getClientOriginalExtension();
                $fileName = $fileName . '_' . time() . '.' . $extension;
                $request->file('image_url')->move(public_path('images'), $fileName);
        }
        $product = Product::create([
            'name'=>$request->name,
            'slug'=> Str::slug($request->name),
            'price'=>$request->price,
            'original_price'=>$request->original_price,
            'description'=>$request->description,
            'quantity'=>$request->quantity,
            'size'=>$request->size,
            'product_category_id'=>$request->product_category_id,
            'status'=>$request->status,
            'image_url'=>asset('images/'.$fileName)
        ]);

        if($product){
            return ProductResource::make($product);
        }
        return response()->json(['error' => 'Something went wrong!'], 400);
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        return response()->json(Product::whereId($id)->first());
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Product $product)
    {
        $fileName = $product->image_url;

        if ($request->hasFile('image_url')) {
        //Remove old images
            if (!is_null($product->image_url) && file_exists("images/" . $product->image_url)) {
                unlink("images/" . $product->image_url);
            }
            $originName = $request->file('image_url')->getClientOriginalName();
            $fileName = pathinfo($originName, PATHINFO_FILENAME);
            $extension = $request->file('image_url')->getClientOriginalExtension();
            $fileName = $fileName . '_' . time() . '.' . $extension;
            $request->file('image_url')->move(public_path('images'), $fileName);

            $product->update([
                'name'=>$request->name,
                'slug'=> Str::slug($request->name),
                'price'=>$request->price,
                'original_price'=>$request->original_price,
                'description'=>$request->description,
                'quantity'=>$request->quantity,
                'size'=>$request->size,
                'product_category_id'=>$request->product_category_id,
                'status'=>$request->status,
                'image_url'=>asset('images/'.$fileName)
            ]);
        }else{
            $product->update([
                'name'=>$request->name,
                'slug'=> Str::slug($request->name),
                'price'=>$request->price,
                'original_price'=>$request->original_price,
                'description'=>$request->description,
                'quantity'=>$request->quantity,
                'size'=>$request->size,
                'product_category_id'=>$request->product_category_id,
                'status'=>$request->status,
                'image_url'=>asset($fileName)
            ]);
        }

        return ProductResource::make($product);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Product $product)
    {
        $product->delete();
        return response()->json(['message' => 'Delete Success!'], 201);
    }
}
