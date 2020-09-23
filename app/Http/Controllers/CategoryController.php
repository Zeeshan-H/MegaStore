<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;
use Session;


class CategoryController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $categories = Category::paginate(5);

        return view('admin.categories.index', compact('categories'));
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $categories = Category::all();

        return view('admin.categories.create', compact('categories'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $request->validate(

            [
                'title' => 'required|min:5',
                'description' => 'required|min:5'
                // 'slug' => 'required|min:5|unique:categories'
            ]
        );
        $categories = Category::create($request->only('title', 'description'));

        $categories->childrens()->attach($request->parent_id);

        Session::flash('success', 'New category has been successfully added!');

        return redirect()->route('admin.category.create', compact('categories'));
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function show(Category $category)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function edit(Category $category)
    {
        $categories = Category::where('id', '!=', $category->id)->get();

        return view('admin.categories.create',['categories' => $categories, 'category' => $category]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, Category $category)
    {
        $request->validate(

            [
                'title' => 'required|min:5',
                'description' => 'required|min:5'
                // 'slug' => 'required|min:5|unique:categories'
            ]
        );

        $category->title = $request->title;

        $category->description = $request->description;


        $category->childrens()->detach();

        $category->childrens()->attach($request->parent_id);

        $saved = $category->save();

        Session::flash('success', 'Category has been successfully updated!');

        return redirect()->route('admin.category.create', compact('category'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Category  $category
     * @return \Illuminate\Http\Response
     */
    public function destroy(Category $category)
    {
        if($category->childrens()->detach() && $category->forceDelete()) {

        $category->delete();
        Session::flash('success', 'Category has been successfully deleted!');
        return redirect()->route('admin.category.index', compact('category'));

        }
        else {
            Session::flash('success', 'Category not deleted!');
            return redirect()->route('admin.category.index', compact('category'));
        }

    }
}
