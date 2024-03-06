<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $categories =category::all();
       return view("categories.index",["categories"=>$categories]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        return view("categories.create");
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            "name"=>"required|min:3|unique:categories"

        ]);
        //
        

        $category =new category();
        $category->name =$request->name;

        // $category->user_id =Auth::id();


        $category->save();

        return to_route("categories.index");
    }

    /**
     * Display the specified resource.
     */
    public function show(Category $category)
    {
        //
        return view("categories.show",["category"=>$category]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Category $category)
    {
        //
        return view("categories.edit",["category"=>$category]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Category $category)
    {
        //
        $request->validate([
            "name"=>"required|min:3|".Rule::unique('categories')->ignore
            ($category->id)
        ]);
        $category->update($request->all());
        return to_route("categories.index");
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Category $category)
    {
        //
        $category->delete();
        return to_route("categories.index");
    }
}
