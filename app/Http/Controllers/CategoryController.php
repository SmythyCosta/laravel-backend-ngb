<?php

namespace App\Http\Controllers;

//Imports Laravel
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

//Imports Models
use App\Category;
use App\SubCategory;

class CategoryController extends Controller
{

    // ======================= Category =======================

    public function getAllCategory(Request $request)
    {
        $all = Category::where('status',1)->get();

        return response()->json(['status'=>200,'cat'=>$all]);
    }

    public function categorySave(Request $request)
    {

        $category = new Category;
        $category->name = $request->input('category');
        $category->description = $request->input('description');
        $category->status = $request->input('status');
        $category->save();

        return response()->json(['status'=>200,'mesg'=>'Category Save Success']);
    }

    public function getCategory(Request $request)
    {
        $id = $request->input('id');
        $find = Category::where('id',$id)->first();

        return response()->json(['status'=>200,'cat'=>$find]); 
    }

    public function categoryUpdate(Request $request)
    {
        $id = $request->input('id');
        $category = Category::find($id);
        $category->name = $request->input('category');
        $category->description = $request->input('description');
        $category->status = $request->input('status');
        $category->save();
        
        return response()->json(['status'=>200,'mesg'=>'Category Update Success']);
    }

    public function categoryDelete(Request $request)
    {
        $id = $request->input('id');
        $cat= Category::find($id);
        $cat->delete();
        $status = 200;
        
        return response()->json(['status'=>$status]);
    }

    public function getAllCategoryByGrid(Request $request)
    {
        $all = Category::select()->orderBy('id', 'desc')->get();
        return response()->json(['status'=>200,'cat'=>$all]);
    }

    // ======================= Sub_Category =======================

    public function getCatBySubCategory(Request $request)
    {
        $id = $request->input('id');
        $all = SubCategory::where('status',1)->where('category_id',$id)->get();

        return response()->json(['status'=>200,'subCat'=>$all]);
    }

    public function subCategorySave(Request $request)
    {
        $subCategory = new SubCategory;
        $subCategory->name = $request->input('subCategory');
        $subCategory->category_id = $request->input('category');
        $subCategory->description = $request->input('description');
        $subCategory->status = $request->input('status');
        $subCategory->save();

        return response()->json(['status'=>200,'mesg'=>'Sub Category Save Success']);
    }

    public function getSubCategory(Request $request)
    {
        $id = $request->id;
        $find = SubCategory::find($id);

        return response()->json(['status'=>200,'subCat'=>$find]);
    }

    public function subCategoryUpdate(Request $request)
    {
        $id = $request->id;
        $subCategory = SubCategory::find($id);
        $subCategory->name = $request->input('subCategory');
        $subCategory->category_id = $request->input('category');
        $subCategory->description = $request->input('description');
        $subCategory->status = $request->input('status');
        $subCategory->save();

        return response()->json(['status'=>200,'mesg'=>'Category Update Success']);
    }

    public function subCategoryDelete(Request $request)
    {
        $id = $request->input('id');
        $cat= SubCategory::find($id);
        $cat->delete();

        return response()->json(['status'=>200,'mesg'=>'subCategory delete Success']);
    }

    public function subCategoryGridData(Request $request)
    {
        $all =  DB::table('sub_category')
            ->join('category', 'sub_category.category_id', '=', 'category.id')
            ->select('sub_category.id','sub_category.name','sub_category.description','category.name as categoryName','sub_category.status')
            ->orderBy('sub_category.id', 'desc')
            ->get();

        echo json_encode(array('status'=>200,'subCat'=>$all));
    }


}
