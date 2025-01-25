<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Inertia\Inertia;

class ProductController extends Controller
{


    public function productPage(Request $request){
        $userId=$request->header('id');
        $products=Product::where('user_id','=',$userId)->get();
        return Inertia::render('Product/ProductPage',['products'=>$products]);
    }

    public function productSavePage(Request $request){
        $userId=$request->header('id');
        $productId=$request->query('id');
        $product=Product::where('user_id','=',$userId)->where('id','=',$productId)->first();
        $categories=Category::where('user_id','=',$userId)->get();

        return Inertia::render('Product/ProductSavePage',['product'=>$product,'categories'=>$categories]);
    }
    public function createProduct(Request $request){
         try{

            $userId=$request->header('id');

            $request->validate([
                'name' => 'required|string',
                'img_url' => 'required|image|mimes:jpeg,png,jpg,webp,gif|max:2048',
                'price' => 'required|numeric|min:0',
                'qty' => 'required|integer|min:0'
            ]);

           //file upload

           $file=$request->file('img_url');
           $fileName=$file->getClientOriginalName();
           $t=time();
           $img_url=$userId.'-'.$t.'-'.$fileName;
           $path='images/'.$img_url;
           $file->move(public_path('images'),$img_url);


            $data=[
               'user_id'=>$userId,
               'category_id'=>$request->input('category_id'),
               'name'=>$request->input('name'),
               'price'=>$request->input('price'),
               'unit'=>$request->input('qty'),
               'img_url'=>$path
            ];

            Product::create($data);
            return redirect()->route('productSavePage')->with(['status'=>true,'message'=>'Product created successfully'],200);
         }catch(Exception $e){
            return redirect()->route('productSavePage')->with(['status'=>false,'message'=>$e->getMessage()],200);
         }

    }

    public function updateProduct(Request $request){
       try{
        $userId=$request->header('id');

        $request->validate([
            'name'=>'required|string',
            'price'=>'required|numeric|min:0',
            'qty'=>'required|integer|min:0'
        ]);
        $data=[
            'name'=>$request->input('name'),
            'price'=>$request->input('price'),
            'unit'=>$request->input('qty'),
            'category_id'=>$request->input('category_id')
         ];

         if($request->hasFile('img_url')){
            $file=$request->file('img_url');
            $fileName=$file->getClientOriginalName();
            $t=time();
            $img_url=$userId.'-'.$t.'-'.$fileName;
            $path='images/'.$img_url;
            $file->move(public_path('images'),$img_url);
            $data['img_url']=$path;

            $oldImage=Product::where('user_id','=',$userId)->where('id','=',$request->input('id'))->select('img_url')->first();
            File::delete($oldImage);
            Product::where('user_id','=',$userId)->where('id','=',$request->input('id'))->update($data);

         }else{
            Product::where('user_id','=',$userId)->where('id','=',$request->input('id'))->update($data);
         }
         return redirect()->route('productSavePage')->with(['status'=>true,'message'=>'Product updated successfully']);
       }catch(Exception $e){
           return redirect()->route('productSavePage') ->with(['status'=>false,'message'=>'Something went wrong']);
       }
    }

    public function deleteProduct(Request $request){
        try{
            $userId=$request->header('id');
            $productId=$request->input('id');
            $oldImage=Product::where('user_id','=',$userId)->where('id','=',$productId)->select('img_url')->first();
            File::delete( $oldImage);

            Product::where('user_id','=',$userId)->where('id','=',$productId)->delete();

            return redirect()->route('productPage')->with(['status'=>true,'message'=>'Product deleted successfully']);
        }catch(Exception $e){
            return redirect()->route('productPage')->with(['status'=>false,'message'=>'Something went wrong']);
        }
    }
}
