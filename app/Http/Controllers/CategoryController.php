<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Exception;
use Illuminate\Http\Request;
use Inertia\Inertia;

class CategoryController extends Controller
{



   public function categoryPage(Request $request){
    $userId = $request->header('id');
    $categories = Category::where('user_id', '=', $userId)->get();
    return Inertia::render('Category/CategoryPage', ['categories' => $categories]);
    }

    public function categorySavePage(Request $request){
        $id=$request->query('id');
        $userId=$request->header('id');
        $category=Category::where('user_id','=',$userId)->where('id','=',$id)->first();
        return Inertia::render('Category/CategorySavePage',['category'=>$category]);
    }
    public function createCategory(Request $request)
    {
        try {
            $request->validate([
                'name' => 'string|required',
            ]);
            $userId = $request->header('id');
            $name = $request->input('name');
            Category::create(['user_id' => $userId, 'name' => $name]);
            return redirect()->route('categorySavePage')->with(['status' => true, 'message' => 'Category created successfully']);
        } catch (Exception $e) {
            return redirect()->route('categorySavePage')->with(['status' => false, 'message' => 'Category creation failed']);
        }
    }

    public function updateCategory(Request $request)
    {
        try {
            $userId = $request->header('id');
            $categoryId = $request->input('id');
            Category::where('id', '=', $categoryId)->where('user_id', '=', $userId)->update([
                'name' => $request->input('name'),
            ]);

            return redirect()->route('categorySavePage')->with(['status' => true, 'message' => 'Category updated successfully']);
        } catch (Exception $e) {
            return redirect()->route('categorySavePage')->with(['status' => false, 'message' => 'Category update failed']);
        }
    }

    public function deleteCategory(Request $request)
    {
        try {
            $userId = $request->header('id');
            $categoryId = $request->input('id');
            Category::where('user_id', '=', $userId)->where('id', '=', $categoryId)->delete();

            return redirect('/category-page')->with(['status' => true, 'message' => 'Category deleted successfully']);
        } catch (Exception $e) {
            return redirect()->route('categoryPage')->with(['status' => false, 'message' => 'Category deleteion failed']);
        }
    }
}
