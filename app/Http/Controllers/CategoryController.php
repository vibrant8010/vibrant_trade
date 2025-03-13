<?php
namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;

class CategoryController extends Controller
{
    //to fetch sub category of category
    public function getSubcategories($categoryId)
    {
        $category = Category::with('subcategories')->find($categoryId);
    
        if (!$category) {
            return response()->json(['subcategories' => []]);
        }
    
        return response()->json([
            'subcategories' => $category->subcategories,
        ]);
    }

    // Display a list of categories
    public function index()
    {
        $categories = Category::with('subcategories')->latest()->paginate(10);
        return view('adminpanel.categories.index', compact('categories'));
    }

    // Show the form for creating a new category
    public function create()
    {
    $categories = Category::all(); // Fetch all categories
    $subcategories = collect(); // Empty collection for subcategories (if no category is selected)


        return view('adminpanel.categories.create', compact('categories', 'subcategories'));
    }

    // Store a newly created category
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:categories|max:255',
            'subcategories' => 'nullable|string',
        ]);
    
        // Create the category
        $category = Category::create(['name' => $request->name]);
    
        // Add subcategories (if provided)
        if ($request->subcategories) {
            $subcategories = array_unique(explode(',', $request->subcategories)); // Remove duplicates
            foreach ($subcategories as $subcategoryName) {
                $subcategoryName = trim($subcategoryName);
                if (!empty($subcategoryName)) {
                    // Check if the subcategory already exists for this category
                    $exists = $category->subcategories()
                        ->where('name', $subcategoryName)
                        ->exists();
    
                    if ($exists) {
                        return back()->withErrors([
                            'subcategories' => "The subcategory '$subcategoryName' already exists for this category.",
                        ])->withInput();
                    }
    
                    // Create the subcategory if it doesn't exist
                    $category->subcategories()->create(['name' => $subcategoryName]);
                }
            }
        }
    
        return redirect()->route('categories.index')
            ->with('success', 'Category created successfully.');
    }

    // Show the form for editing a category
    public function edit(Category $category)
    {
        return view('adminpanel.categories.edit', compact('category'));
    }

    // Update the specified category
    public function update(Request $request, Category $category)
    {
        $request->validate([
            'name' => 'required|max:255|unique:categories,name,' . $category->id,
            'subcategories' => 'nullable|string',
        ]);
    
        // Update the category
        $category->update(['name' => $request->name]);
    
        // Update subcategories (if provided)
        if ($request->subcategories) {
            // Delete existing subcategories
            $category->subcategories()->delete();
    
            // Add new subcategories
            $subcategories = array_unique(explode(',', $request->subcategories)); // Remove duplicates
            foreach ($subcategories as $subcategoryName) {
                $subcategoryName = trim($subcategoryName);
                if (!empty($subcategoryName)) {
                    // Check if the subcategory already exists for this category
                    $exists = $category->subcategories()
                        ->where('name', $subcategoryName)
                        ->exists();
    
                    if ($exists) {
                        return back()->withErrors([
                            'subcategories' => "The subcategory '$subcategoryName' already exists for this category.",
                        ])->withInput();
                    }
    
                    // Create the subcategory if it doesn't exist
                    $category->subcategories()->create(['name' => $subcategoryName]);
                }
            }
        }
    
        return redirect()->route('categories.index')
            ->with('success', 'Category updated successfully.');
    }

    // Delete the specified category
    public function destroy(Category $category)
    {
        // Delete associated subcategories
        $category->subcategories()->delete();

        // Delete the category
        $category->delete();

        return redirect()->route('categories.index')
            ->with('success', 'Category deleted successfully.');
    }
}