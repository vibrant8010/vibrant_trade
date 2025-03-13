<?php

namespace App\Http\Controllers;
use Log;
use Carbon\Carbon;
use App\Models\Blog;
use App\Models\Product;
use App\Models\Category;
use App\Models\Subcategory;
use Illuminate\Http\Request;
use App\Models\CompanyDetail;
use App\Events\ProductClicked;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{


    public function create(Request $request)
    {
        $companies = CompanyDetail::select('id', 'name')->get(); // Only fetch id and name
        $subcategories = Subcategory::select('id', 'name')->get(); // Only fetch id and name
        $categories = Category::select('id', 'name')->get(); // Only fetch id and name

        // Pass the data to the view
        return view('adminpanel.products.create', compact('subcategories', 'categories', 'companies'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|string|max:255',
            'company_id' => 'required|exists:company_details,id', // Validate company_id exists in company_details table
            'description' => 'required|string',
            'subcategory_id' => 'required|exists:subcategories,id',
            'category_type' => 'required|in:Top,Trending,New Arrival',
            'image_url' => 'required|file|image|max:10240',
            'material' => 'nullable|string',
            'size' => 'nullable|string',
        ]);

        $imagePath = null;

        // Handle `image_url` upload
        if ($request->hasFile('image_url')) {
            $image = $request->file('image_url');
            $imageName = time() . '_' . $image->getClientOriginalName(); // Unique filename
            $imagePath = $image->move(public_path('images'), $imageName); // Store in public/images
            $imagePath = 'images/' . $imageName; // Save the relative path in the database
        }

        // Create the product with the company_id
        Product::create(array_merge($request->only([
            'name',
            'company_id', // Include company_id in the product creation
            'description',
            'subcategory_id',
            'category_type',
            'material',
            'size',
        ]), [
            'image_url' => $imagePath,
        ]));

        return redirect()->route('admin.products.index')->with('success', 'Product created successfully');
    }

    public function index()
    {
        $products = Product::all();

        return view('adminpanel.products.index', compact('products'));
    }


    public function edit($id)
    {
        $subcategories = Subcategory::all();
        $product = Product::findOrFail($id);
        $categories = Category::all(); // Retrieve all categories

        return view('adminpanel.products.edit', compact('product', 'categories', 'subcategories'));
    }
    public function update(Request $request, $id)
    {
        $product = Product::findOrFail($id);

        // Validate incoming request data
        $request->validate([
            'name' => 'required|string|max:255',
            'description' => 'required|string',
            'subcategory_id' => 'required|exists:subcategories,id',
            'category_type' => 'required|in:Top,Trending,New Arrival',
            'material' => 'nullable|string',
            'size' => 'nullable|string',
            'companyname' => 'string|max:255', // Add validation for company name
            'logo_url' => 'nullable|file|image|max:10240', // Add validation for logo
            'image_url' => 'nullable|file|image|max:10240', // Image is optional during update
        ]);

        $updateData = $request->except(['image_url', 'logo_url']); // Exclude file fields from the data array

        // Handle image_url update
        if ($request->hasFile('image_url')) {
            // Delete old image if it exists
            if ($product->image_url && file_exists(public_path($product->image_url))) {
                unlink(public_path($product->image_url));
            }

            // Store new image
            $image = $request->file('image_url');
            $imageName = time() . '_' . $image->getClientOriginalName(); // Unique filename
            $image->move(public_path('images'), $imageName); // Save to public/images
            $updateData['image_url'] = 'images/' . $imageName; // Save relative path in the database
        }

        // Handle logo_url update
        if ($request->hasFile('logo_url')) {
            // Delete old logo if it exists
            if ($product->logo_url && file_exists(public_path($product->logo_url))) {
                unlink(public_path($product->logo_url));
            }

            // Store new logo
            $logo = $request->file('logo_url');
            $logoName = time() . '_' . $logo->getClientOriginalName(); // Unique filename for logo
            $logo->move(public_path('logos'), $logoName); // Save to public/logos
            $updateData['logo_url'] = 'logos/' . $logoName; // Save relative path in the database
        }

        // Update the product with the new data
        $product->update($updateData);

        return redirect()->route('admin.products.index')->with('success', 'Product updated successfully');
    }


    // Delete a product
    public function destroy($id)
    {
        $product = Product::findOrFail($id);
        $product->delete();

        return redirect()->route('admin.products.index')->with('success', 'Product deleted successfully');
    }

    public function userHomePage()
    {
        $topCategoryProducts = Product::where('category_type', 'Top')->take(4)->get();
        $trendingCategoryProducts = Product::where('category_type', 'Trending')->take(4)->get();
        $newArrivalCategoryProducts = Product::where('category_type', 'New Arrival')
            ->orderBy('id', 'desc')
            ->take(8)->get();
        $blogs = Blog::all();
        return view('layouts.welcome', compact('topCategoryProducts', 'trendingCategoryProducts', 'newArrivalCategoryProducts', 'blogs'));
    }
    public function topCategoryPage()
    {
        $topCategoryProducts = Product::where('category_type', 'Top')->get();

        return view('innertopcategory', compact('topCategoryProducts'));
    }

    public function trendingCategoryPage()
    {
        $trendingCategoryProducts = Product::where('category_type', 'Trending')->get();

        return view('alltrendingcategory', compact('trendingCategoryProducts'));
    }

    public function newArrivalCategoryPage()
    {
        $newArrivalCategoryProducts = Product::where('category_type', 'New Arrival')->get();

        return view('allnewarrival', compact('newArrivalCategoryProducts'));
    }

    public function show($id)
    {
        // Retrieve the product by its ID
        $product = Product::with(['company', 'category', 'subcategory'])->findOrFail($id);
        $user = auth()->user();
        if (Auth::check()) {
            $clickedProducts = session()->get('clicked_products', []);
            $clickedCompany = session()->get('clicked_company', []);

            $productCompanyid = $product->company->id;
            if (!in_array($id, $clickedProducts)) {
                if (!in_array($productCompanyid, $clickedCompany)) {
                    $clickedProducts[] = $id;
                    $clickedCompany[] = $productCompanyid;
                    session()->put('clicked_products', $clickedProducts);
                    session()->put('clicked_company', $clickedCompany);
                    event(new ProductClicked($product, $user));
                }
            }
        }

        return view('productdetails', compact('product'));
    }
    // Pass the product details to the view
    //  return redirect()->route('user.home')->with('alert', 'Please log in to view product details.');
    //  }

 public function categoryDetails($name){
        $category = Category::with(['products', 'category'])
        ->where('name', $name)
        ->pluck('id');

        $subcatrgory = Subcategory::with(['products', 'category'])
        ->wherein('category_id', $category) // Filter by category ID
        ->get();

        $subcatrgoryid = Subcategory::with(['products', 'category'])
        ->wherein('category_id', $category) // Filter by category ID
        ->pluck('id');

        $products = Product::with(['company', 'category', 'subcategory'])
        ->whereIn('subcategory_id', $subcatrgoryid) // Filter by category ID
        ->get();

        return view('innercategory',['products' => $products,'subcatrgory'=>$subcatrgory]);
    } 

    public function productDetail($id)
    {

        $product = Product::with('company')->findOrFail($id);
        return view('product.detail', ['product' => $product]);
    }
    public function companyProducts(Request $request, $id)
    {
        // Fetch the company using the provided id
        $company = CompanyDetail::findOrFail($id);

        // Fetch all companies for the filter
        $companies = CompanyDetail::select('id', 'name')->get();

        // Get selected company IDs from checkbox filters (if any)
        $selectedCompanyIds = $request->has('company_ids') ? $request->company_ids : [$id]; // Default to the current company if no filter is selected

        // Fetch products for the selected companies
        $products = Product::whereIn('company_id', $selectedCompanyIds)->get();

        // Pass the company, selected company IDs, companies, and products to the view
        return view('company.products', compact('company', 'companies', 'products', 'selectedCompanyIds'));
    }
    //  public function search(Request $request)
//     {
//         $searchTerm = $request->input('query');

    //         // Searching in Products, Categories, Companies, Sub-categories
//         // $products = Product::where('name', 'like', "%{$searchTerm}%")
//         //                    ->orWhere('description', 'like', "%{$searchTerm}%")
//         //                    ->get();


    //         $categories = Category::where('name', 'like', "%{$searchTerm}%")
//                              ->get();


    //         $companies = CompanyDetail::where('name', 'like', "%{$searchTerm}%")
//                             ->orWhere('description', 'like', "%{$searchTerm}%")
//                             ->get();

    //         $subCategories = SubCategory::where('name', 'like', "%{$searchTerm}%")
//                                      ->get();
//         $products = Product::with(['company', 'category', 'subcategory'])
//     ->where(function ($query) use ($searchTerm) {
//         $query->where('name', 'like', "%{$searchTerm}%")
//               ->orWhere('description', 'like', "%{$searchTerm}%");
//     })
//     ->when($companies->id->isNotEmpty(), function ($query) use ($companyIds) {
//         $query->whereIn('company_id', $companyIds);
//     })
//     ->when($categories->id->isNotEmpty(), function ($query) use ($categoryIds) {
//         $query->whereIn('category_id', $categoryIds);
//     })
//     ->when($$subCategories->id->isNotEmpty(), function ($query) use ($subCategoryIds) {
//         $query->whereIn('sub_category_id', $subCategoryIds);
//     })
//     ->get();

    //         // Combine results into one collection (or you can return them separately)
//         $results = collect([
//             'products' => $products,
//             'categories' => $categories,
//             'companies' => $companies,
//             'subCategories' => $subCategories,
//         ]);

    //         return view('searchresult', compact('results', 'searchTerm'));
//         // return view('company.products', compact('company', 'companies', 'products', 'selectedCompanyIds'));
//     }
    public function filterProducts(Request $request)
    {
        $companyIds = $request->input('company_ids', []);
        $categoryIds = $request->input('category_ids', []);
        $subCategoryIds = $request->input('subcategory_ids', []);

        // Query products based on the selected filters
        $products = Product::with(['company', 'category', 'subcategory'])
            ->when(!empty($companyIds), function ($query) use ($companyIds) {
                $query->whereIn('company_id', $companyIds);
            })
            ->when(!empty($categoryIds), function ($query) use ($categoryIds) {
                $query->whereIn('category_id', $categoryIds);
            })
            ->when(!empty($subCategoryIds), function ($query) use ($subCategoryIds) {
                $query->whereIn('sub_category_id', $subCategoryIds);
            })
            ->get();
        // return view('searchresult', compact('results', 'searchTerm'));
        // Return the filtered products as JSON
        return response()->json(['products' => $products]);
    }

    // public function search(Request $request)
    // {
    //     $searchTerm = $request->input('query');
    //     $location = $request->input('location'); // Get location from the form

    //     // Initialize query builders
    //     $categories = Category::where('name', 'like', "%{$searchTerm}%");
    //     $companies = CompanyDetail::query();
    //     $subCategories = SubCategory::where('name', 'like', "%{$searchTerm}%");

    //     // Filter companies by name or description and location
    //     $companies->where(function ($query) use ($searchTerm) {
    //         $query->where('name', 'like', "%{$searchTerm}%")
    //               ->orWhere('description', 'like', "%{$searchTerm}%");
    //     });

    //     // Add location filter if location is provided
    //     if (!empty($location)) {
    //         $companies->where(function ($query) use ($location) {
    //             $query->where('city', 'like', "%{$location}%")
    //                   ->orWhere('state', 'like', "%{$location}%")
    //                   ->orWhere('pincode', 'like', "%{$location}%");
    //         });
    //     }

    //     $companies = $companies->get();
    //     // dd($companies);
    //     // Extract the IDs of companies, categories, and subcategories
    //     $companyIds = $companies->pluck('id');
    //     $categoryIds = $categories->pluck('id');
    //     $categorieswith = SubCategory::whereIn('category_id', $categoryIds)->get();

    //     $subCategoryIdswith = $categorieswith->pluck('id');
    //     $subCategoryIds = $subCategories->pluck('id');

    //     // Prepare the query builder for products
    //     $query = Product::with(['company', 'category', 'subcategory']);

    //     // Apply filters for company, category, and subcategory if IDs are not empty
    //     if ($companyIds->isNotEmpty()) {
    //         $query->whereIn('company_id', $companyIds);
    //     } elseif ($categoryIds->isNotEmpty()) {
    //         $query->whereIn('subcategory_id', $subCategoryIdswith);
    //     } elseif ($subCategoryIds->isNotEmpty()) {
    //         $query->whereIn('subcategory_id', $subCategoryIds);
    //     }
    //     else {
    //         // Apply search filters
    //         $query->where(function ($query) use ($searchTerm) {
    //             $query->where('name', 'like', "%{$searchTerm}%")
    //                   ->orWhere('description', 'like', "%{$searchTerm}%")
    //                   ->orWhere('material', 'like', "%{$searchTerm}%")
    //                   ->orWhere('size', 'like', "%{$searchTerm}%");
    //         });
    //     }

    //     // Retrieve the products
    //     $products = $query->get();
    //     // $subCategories2 = $products->pluck('subcategory_id');
    //     // $subCategories = SubCategory::Where('category_id', $subCategories2)
    //     //     ->get();
    //     // $companies2 = $products->pluck('company_id');
    //     // $companies = CompanyDetail::where('name', 'like', "%{$searchTerm}%")
    //     //     // ->orWhereIn('category_id', $categoryIds)
    //     //     ->orWhereIn('id', $companies2)
    //     //     ->get();
    //     // echo '<pre>';
    //     // print_r($products);die();
    //     // print_r($subCategories);die();
    //     // Combining results
    //     $results = [
    //         'products' => $products,
    //         'categories' => $categories,
    //         'companies' => $companies,
    //         'subCategories' => $subCategories,
    //     ];
    //     // print_r($subCategories);die();
    //     return view('searchresult2', compact('results', 'searchTerm'));

    // }
    public function search(Request $request)
    {
        $searchTerm = $request->input('query');
        $location = $request->input('location');

        // Fetch categories & subcategories matching search term
        $categories = Category::where('name', 'like', "%{$searchTerm}%")->get();
        $subCategories = SubCategory::where('name', 'like', "%{$searchTerm}%")->get();

        // Fetch companies based on name, description, and location
        $companies = CompanyDetail::query()
            ->where(function ($query) use ($searchTerm) {
                $query->where('name', 'like', "%{$searchTerm}%")
                    ->orWhere('description', 'like', "%{$searchTerm}%");
            });

        // Apply location filter to companies (optional)
        if (!empty($location)) {
            $companies->where(function ($query) use ($location) {
                $query->where('city', 'like', "%{$location}%")
                    ->orWhere('state', 'like', "%{$location}%")
                    ->orWhere('pincode', 'like', "%{$location}%");
            });
        }

        $companies = $companies->get(); // Get filtered companies

        // Get company & category IDs
        $companyIds = $companies->pluck('id');
        $categoryIds = $categories->pluck('id');

        // Get subcategories belonging to matched categories
        $categorieswith = SubCategory::whereIn('category_id', $categoryIds)->get();
        $subCategoryIds = $subCategories->pluck('id')->merge($categorieswith->pluck('id'));

        // Fetch products
        $query = Product::with(['company', 'category', 'subcategory']);

        // Filter by company, category, or subcategory
        if ($companyIds->isNotEmpty()) {
            $query->whereIn('company_id', $companyIds);
        }

        if ($subCategoryIds->isNotEmpty()) {
            $query->whereIn('subcategory_id', $subCategoryIds);
        }

        // Apply a global search on product name, description, material, size
        $query->orWhere(function ($query) use ($searchTerm) {
            $query->where('name', 'like', "%{$searchTerm}%")
                ->orWhere('description', 'like', "%{$searchTerm}%")
                ->orWhere('material', 'like', "%{$searchTerm}%")
                ->orWhere('size', 'like', "%{$searchTerm}%");
        });

        // Apply location filter if required
        if (!empty($location)) {
            $query->WhereHas('company', function ($companyQuery) use ($location) {
                $companyQuery->where('city', 'like', "%{$location}%")
                    ->orWhere('state', 'like', "%{$location}%")
                    ->orWhere('pincode', 'like', "%{$location}%");
            });
        }
        // Fetch products
        $products = $query->get();

        if ($products->isEmpty()) {
            $products = Product::with(['company', 'category', 'subcategory'])
                ->where(function ($query) use ($searchTerm) {
                    $query->where('name', 'like', "%{$searchTerm}%")
                        ->orWhere('description', 'like', "%{$searchTerm}%")
                        ->orWhere('material', 'like', "%{$searchTerm}%")
                        ->orWhere('size', 'like', "%{$searchTerm}%");
                })
                ->get();

            $message = "The searched product is not available in {$location}, but here are results from other locations.";
        } else {
            $message = null;
        }
        // Prepare results
        $results = [
            'products' => $products,
            'categories' => $categories,
            'companies' => $companies,
            'subCategories' => $subCategories,
            'message' => $message,
        ];

        return view('searchresult2', compact('results', 'searchTerm'));
    }
    public function suggestions(Request $request)
    {
        $searchTerm = $request->input('query');

        // Search in Products
        $products = Product::select('id', 'name', 'description')
            ->where('name', 'like', "%{$searchTerm}%")
            ->orWhere('description', 'like', "%{$searchTerm}%")
            ->orWhere('material', 'like', "%{$searchTerm}%")
            ->orWhere('size', 'like', "%{$searchTerm}%")
            ->limit(5)
            ->get();

        // Search in Categories
        $categories = Category::select('id', 'name')
            ->where('name', 'like', "%{$searchTerm}%")
            ->limit(5)
            ->get();

        // Search in Subcategories
        $subcategories = SubCategory::select('id', 'name')
            ->where('name', 'like', "%{$searchTerm}%")
            ->limit(5)
            ->get();

        // Search in Company Details
        $companies = CompanyDetail::select('id', 'name', 'description')
            ->where('name', 'like', "%{$searchTerm}%")
            ->orWhere('description', 'like', "%{$searchTerm}%")
            ->orWhere('alternate_names', 'like', "%{$searchTerm}%")
            ->limit(5)
            ->get();

        // Combine Results
        $results = [
            'products' => $products,
            'categories' => $categories,
            'subcategories' => $subcategories,
            'companies' => $companies,
        ];

        return response()->json($results);
    }

    public function getSuggestions(Request $request)
    {
        $query = $request->input('query');
        $category = $request->input('category');

        $productSuggestions = [];
        $companySuggestions = [];

        if ($category === 'All' || $category === 'Companies') {
            // Fetch company suggestions if category is "All" or "Companies"
            $companySuggestions = CompanyDetail::where('name', 'LIKE', "%{$query}%")
                ->orWhereRaw("FIND_IN_SET(?, alternate_names)", [$query])
                ->limit(10)
                ->get(['id', 'name']);
        }
        if ($category === 'All' || $category === 'Products') {
            // Fetch product suggestions if category is "All" or "Products"
            $productSuggestions = Product::where('name', 'LIKE', "%{$query}%")
                ->limit(10)
                ->get(['id', 'name']);
        }



        // Response handling for each category
        if ($category === 'Products') {
            return response()->json(['suggestions' => $productSuggestions]);
        } elseif ($category === 'Companies') {
            return response()->json(['suggestions' => $companySuggestions]);
        }

        // If "All" is selected, return both products and companies
        return response()->json([
            'products' => $productSuggestions,
            'companies' => $companySuggestions,
        ]);
    }




}
