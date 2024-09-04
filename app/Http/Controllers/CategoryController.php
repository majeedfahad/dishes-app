<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Dish;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    // Display a list of categories
    public function index()
    {
        $categories = Category::all();
        return view('categories.index', compact('categories'));
    }

    // Show the form for creating a new category
    public function create()
    {
        return view('categories.create');
    }

    // Store a newly created category in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        Category::create($request->all());

        return redirect()->route('categories.index')->with('success', 'Category created successfully.');
    }

    // Show the form for editing a specific category
    public function edit(Category $category)
    {
        return view('categories.edit', compact('category'));
    }

    // Update a specific category in the database
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
        ]);

        $category->update($request->all());

        return redirect()->route('categories.index')->with('success', 'Category updated successfully.');
    }

    // Delete a specific category from the database
    public function destroy(Category $category)
    {
        $category->delete();

        return redirect()->route('categories.index')->with('success', 'Category deleted successfully.');
    }

    // Assign dishes to a category
    public function assignDishes(Request $request, Category $category)
    {
        $request->validate([
            'dish_ids' => 'required|array',
        ]);

        $category->dishes()->sync($request->dish_ids);

        return redirect()->route('categories.index')->with('success', 'Dishes assigned to category successfully.');
    }
}
