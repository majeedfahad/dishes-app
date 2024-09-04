<?php

namespace App\Http\Controllers;

use App\Models\Company;
use App\Models\Dish;
use Illuminate\Http\Request;

class CompanyController extends Controller
{
    // Display a list of companies
    public function index()
    {
        $companies = Company::all();
        return view('companies.index', compact('companies'));
    }

    // Show the form for creating a new company
    public function create()
    {
        return view('companies.create');
    }

    // Store a newly created company in the database
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email',
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'subscription_start_date' => 'required|date',
            'subscription_end_date' => 'nullable|date|after:subscription_start_date',
        ]);

        Company::create($request->all());

        return redirect()->route('companies.index')->with('success', 'Company created successfully.');
    }

    // Show the form for editing a specific company
    public function edit(Company $company)
    {
        return view('companies.edit', compact('company'));
    }

    // Update a specific company in the database
    public function update(Request $request, Company $company)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:companies,email,' . $company->id,
            'phone' => 'nullable|string|max:20',
            'address' => 'nullable|string',
            'subscription_start_date' => 'required|date',
            'subscription_end_date' => 'nullable|date|after:subscription_start_date',
        ]);

        $company->update($request->all());

        return redirect()->route('companies.index')->with('success', 'Company updated successfully.');
    }

    // Delete a specific company from the database
    public function destroy(Company $company)
    {
        $company->delete();

        return redirect()->route('companies.index')->with('success', 'Company deleted successfully.');
    }

    // Assign dishes to a company
    public function assignDishes(Request $request, Company $company)
    {
        $request->validate([
            'dish_ids' => 'required|array',
        ]);

        $company->dishes()->sync($request->dish_ids);

        return redirect()->route('companies.index')->with('success', 'Dishes assigned to company successfully.');
    }
}
