<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Dish;
use App\Models\Company;
use Illuminate\Http\Request;

class DishController extends Controller
{
    // Display a list of dishes
    public function index()
    {
        $dishes = Dish::with('category')->get();
        return view('dishes.index', compact('dishes'));
    }

    // Show the form for creating a new dish
    public function create()
    {
        $categories = Category::all();
        return view('dishes.create', compact('categories'));
    }

    // Store a newly created dish in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'calories' => 'required|integer',
            'protein' => 'required|numeric',
            'fat' => 'required|numeric',
            'carbohydrates' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        Dish::create($request->all());

        return redirect()->route('dishes.index')->with('success', 'Dish created successfully.');
    }

    // Show the form for editing a specific dish
    public function edit(Dish $dish)
    {
        $categories = Category::all();
        return view('dishes.edit', compact('dish', 'categories'));
    }

    // Update a specific dish in the database
    public function update(Request $request, Dish $dish)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'nullable|string',
            'price' => 'required|numeric',
            'calories' => 'required|integer',
            'protein' => 'required|numeric',
            'fat' => 'required|numeric',
            'carbohydrates' => 'required|numeric',
            'category_id' => 'required|exists:categories,id',
        ]);

        $dish->update($request->all());

        return redirect()->route('dishes.index')->with('success', 'Dish updated successfully.');
    }

    // Delete a specific dish from the database
    public function destroy(Dish $dish)
    {
        $dish->delete();

        return redirect()->route('dishes.index')->with('success', 'Dish deleted successfully.');
    }

    // List dishes assigned to a specific company
    public function listDishesForCompany(Company $company)
    {
        $dishes = $company->dishes;
        return view('companies.dishes', compact('company', 'dishes'));
    }
}
