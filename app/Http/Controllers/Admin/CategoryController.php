<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Category;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    public function index()
    {
        $categories = Category::all();
        return view('admin.categories.index', compact('categories'));
    }
    public function create()
    {
        return view('admin.categories.create');
    }
    public function store(Request $request)
    {
        $request->validate(['nom' => 'required|string|max:100']);
        Category::create(['nom' => $request->nom]);
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie ajoutée.');
    }
    public function edit(Category $category)
    {
        return view('admin.categories.edit', compact('category'));
    }
    public function update(Request $request, Category $category)
    {
        $request->validate(['nom' => 'required|string|max:100']);
        $category->update(['nom' => $request->nom]);
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie modifiée.');
    }
    public function destroy(Category $category)
    {
        $category->delete();
        return redirect()->route('admin.categories.index')->with('success', 'Catégorie supprimée.');
    }
}
