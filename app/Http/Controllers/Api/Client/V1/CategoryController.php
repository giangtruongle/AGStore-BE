<?php

namespace App\Http\Controllers\Api\Client\V1;

use App\Http\Controllers\Controller;
use App\Http\Resources\ProductCategoryResource;
use App\Models\Product;
use App\Models\ProductCategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
        public function showCategory(){
        $categories = ProductCategory::where('status','1')->latest()->take(10)->get();
        return ProductCategoryResource::collection($categories);
    }

    public function getCategory(){
        $category = ProductCategory::where('status','1')->get();
        return response()->json([
            'status'=>200,
            'category' => $category
        ]);
    }

    public function getProducts($slug){
        $category = ProductCategory::where('slug',$slug)->where('status','1')->first();
        
        if($category){

            $product = Product::where('product_category_id',$category->id)->where('status','1')->get();
            if($product){

                return response()->json([
                'status'=>200,
                'product_data'=>[
                    'product' => $product,
                    'category' => $category
                ]
            ]);

            }else{
                return response()->json([
                'status'=>400,
                'message'=>"No Product Available"
            ]);
            }

        }else{
            return response()->json([
                'status'=>404,
                'message'=>"No Such Category Found"
            ]);
        }
    }
}
