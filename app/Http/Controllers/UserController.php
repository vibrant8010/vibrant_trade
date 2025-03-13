<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Yajra\DataTables\Facades\DataTables;
use Symfony\Component\HttpKernel\Attribute\Cache;
use Illuminate\Support\Facades\Session;
use App\Models\CompanyDetail;

class UserController extends Controller
{
    public function index(Request $request)
    {
        // Get the search input from the request
        $search = $request->input('search');

        // Query the users based on the search input, if it exists
        $users = User::when($search, function ($query, $search) {
            return $query->where('name', 'like', "%{$search}%")
                         ->orWhere('email', 'like', "%{$search}%")
                         ->orWhere('contact_no', 'like', "%{$search}%");
        })->get();

        // Return the view with the filtered user data
        return view('adminpanel.users.index', compact('users', 'search'));
    }
    public function show(Request $request){
         $user = User::all();
        // //  $users = 'hello';

        // //  return view('businesspanel.Users.show');
        // if ($request->ajax()) {
        //     // Fetch the necessary user data
        //     $users = User::select('id', 'name', 'role', 'email');

        //     // Return a DataTables response
        //     return DataTables::of($users)
        //         ->addColumn('action', function ($user) {
        //             // Add edit and delete buttons with dynamic links (if needed)
        //             return '
        //                 <a href="' . route('users.edit', $user->id) . '" class="btn btn-sm btn-primary">Edit</a>
        //                 <a href="' . route('users.destroy', $user->id) . '" class="btn btn-sm btn-danger" onclick="return confirm(\'Are you sure?\')">Delete</a>
        //             ';
        //         })
        //         ->rawColumns(['action']) // Allow HTML in the action column
        //         ->make(true);
        // }
         return view('businesspanel.Users.show',compact('user'));

    }
    public function create()
    {
        return view('adminpanel.users.create'); // Adjust the view name as necessary
    }

    // public function store(Request $request)
    // {
    //     // Validate the request data
    //     $validatedData = $request->validate([
    //         'username' => 'required|string|max:255|unique:users',
    //         'email' => 'required|string|email|max:255|unique:users',
    //         'password' => 'required|string|min:6',
    //         'contact_no' => 'required|string|max:255',
    //     ]);

    //     // Create the user
    //     User::create([
    //         'username' => $validatedData['username'],
    //         'email' => $validatedData['email'],
    //         'password' => Hash::make($validatedData['password']),
    //         'contact_no' => $validatedData['contact_no'],
    //     ]);

    //     // Redirect back with a success message
    //     return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    // }

    // public function store(Request $request)
    // {
    //     // Debug the request data
    //     // dd($request->all());die();
    
    //     // Validate the request
    //     $request->validate([
    //         'username' => 'required|string|max:255',
    //         'email' => 'required|email|unique:users,email',
    //         'mobileno' => 'required|min:10|max:10',
    //         'role' => 'required|in:user,business',
    //         'name' => 'nullable|string|max:255',
    //         'logo_upload' => 'required|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
    //         'description' => 'nullable|string',
    //         'gst_registration_date' => 'nullable|date',
    //         'gst_no' => 'nullable|string',
    //         'legal_status' => 'nullable|string',
    //         'nature_of_business' => 'nullable|string',
    //         'alternate_names' => 'nullable|string',
    //         'city' => 'nullable|string',
    //         'state' => 'nullable|string',
    //         'pincode' => 'nullable|integer',
    //     ]);
    //     // dd($request->all());die();
    //     // Create the user
    //     $user = User::create([
    //         'name' => $request->input('username'),
    //         'email' => $request->input('email'),
    //         'mobileno' => $request->input('mobileno'),
    //         'password' => bcrypt('password'),   // Set a default password or generate one
    //         'role' => $request->input('role'),
    //     ]);
       
    //     // Create company details if the role is "business"
    //     if ($user->hasRole('business')) {
    //         CompanyDetail::create([
    //             'business_id' => $user->id,
    //             'name' => $request->input('name'),
    //             'logo_url' => $request->input('logo_url'),
    //             'description' => $request->input('description'),
    //             'gst_registration_date' => $request->input('gst_registration_date'),
    //             'gst_no' => $request->input('gst_no'),
    //             'legal_status' => $request->input('legal_status'),
    //             'nature_of_business' => $request->input('nature_of_business'),
    //             'alternate_names' => $request->input('alternate_names'),
    //             'city' => $request->input('city'),
    //             'state' => $request->input('state'),
    //             'pincode' => $request->input('pincode'),
    //         ]);
    //     }
    
    //     return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
    // }

    public function store(Request $request)
{
    $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email',
        'mobileno' => 'required|min:10|max:10',
        'role' => 'required|in:user,business',
        'name' => 'nullable|string|max:255',
        'logo_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'description' => 'nullable|string',
        'gst_registration_date' => 'nullable|date',
        'gst_no' => 'nullable|string',
        'legal_status' => 'nullable|string',
        'nature_of_business' => 'nullable|string',
        'alternate_names' => 'nullable|string',
        'city' => 'nullable|string',
        'state' => 'nullable|string',
        'pincode' => 'nullable|integer',
    ]);

    // Handle file upload for logo
    if ($request->hasFile('logo_upload')) {
        $uploadPath = public_path('images/company_logo');
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        $file = $request->file('logo_upload');
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();
        $file->move($uploadPath, $fileName);

        $logoUrl = 'images/company_logo/' . $fileName;
    } else {
        $logoUrl = null;
    }

    // Create the user
    $user = User::create([
        'name' => $request->input('username'),
        'email' => $request->input('email'),
        'mobileno' => $request->input('mobileno'),
        'password' => bcrypt('password'), // Set a default password or generate one
        'role' => $request->input('role'),
    ]);

    // Create company details if the role is "business"
    if ($user->role === 'business') {
        CompanyDetail::create([
            'business_id' => $user->id,
            'name' => $request->input('name'),
            'logo_url' => $logoUrl,
            'description' => $request->input('description'),
            'gst_registration_date' => $request->input('gst_registration_date'),
            'gst_no' => $request->input('gst_no'),
            'legal_status' => $request->input('legal_status'),
            'nature_of_business' => $request->input('nature_of_business'),
            'alternate_names' => $request->input('alternate_names'),
            'city' => $request->input('city'),
            'state' => $request->input('state'),
            'pincode' => $request->input('pincode'),
        ]);
    }

    return redirect()->route('admin.users.index')->with('success', 'User created successfully.');
}


    public function edit($id)
    {
        $user = User::findOrFail($id);
        return view('adminpanel.users.edit', compact('user')); //here first code for route was buinesspanel.users.edit
    }

    // public function update(Request $request, User $user)
    // {
    //     // Validate the request data
    //     $validatedData = $request->validate([
    //         'username' => 'required|string|max:255',
    //         'email' => 'required|string|email|max:255',
    //         'contact_no' => 'required|string|min:10|max:10',
    //     ]);

    //     // Update the user with new data
    //     $user->update($validatedData);
        
    //     return redirect()->route('admin.users.index')->with('success', 'User updated successfully!');
    // }

//     public function update(Request $request, $id)
// { 
//     $user = User::findOrFail($id);
//     // Debug the request data
    

//     // Update user details
//     $user->update([
//         'name' => $request->input('username'),
//         'email' => $request->input('email'),
//         'mobileno' => $request->input('mobileno'),
//         'role' => $request->input('role'),
//     ]);
//     $user->save();
//     // print_r($user);die();    
//     // Update company details if the user has the "business" role
//     if ($user->hasRole('business')) {
//         $companyDetails = CompanyDetail::where('business_id', $id)->first();
//         //
//        if($companyDetails === null){
//         CompanyDetail::create([
//             'business_id' => $user->id,
//             'name' => $request->input('name'),
//             'logo_url' => $request->input('logo_url'),
//             'description' => $request->input('description'),
//             'gst_registration_date' => $request->input('gst_registration_date'),
//             'gst_no' => $request->input('gst_no'),
//             'legal_status' => $request->input('legal_status'),
//             'nature_of_business' => $request->input('nature_of_business'),
//             'alternate_names' => $request->input('alternate_names'),
//             'city' => $request->input('city'),
//             'state' => $request->input('state'),
//             'pincode' => $request->input('pincode'),
//         ]); 
//        }
//         if ($companyDetails) {
//             // dd($companyDetails );
//             $companyDetails->update([
//                 'name' => $request->input('name'),
//                 'logo_url' => $request->input('logo_url'),
//                 'description' => $request->input('description'),
//                 'gst_registration_date' => $request->input('gst_registration_date'),
//                 'gst_no' => $request->input('gst_no'),
//                 'legal_status' => $request->input('legal_status'),
//                 'nature_of_business' => $request->input('nature_of_business'),
//                 'alternate_names' => $request->input('alternate_names'),
//                 'city' => $request->input('city'),
//                 'state' => $request->input('state'),
//                 'pincode' => $request->input('pincode'),
//             ]);
//         } else {
//             // Handle the case where no company details are found
//             echo "No company details found for business_id: $id";
//         }
//     }

//     return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
// }

public function update(Request $request, $id)
{   
    $request->validate([
        'username' => 'required|string|max:255',
        'email' => 'required|email|unique:users,email,' . $id,
        'mobileno' => 'required|min:10|max:10',
        'role' => 'required|in:user,business',
        'name' => 'nullable|string|max:255',
        'logo_upload' => 'nullable|image|mimes:jpeg,png,jpg,gif,webp|max:2048',
        'description' => 'nullable|string',
        'gst_registration_date' => 'nullable|date',
        'gst_no' => 'nullable|string',
        'legal_status' => 'nullable|string',
        'nature_of_business' => 'nullable|string',
        'alternate_names' => 'nullable|string',
        'city' => 'nullable|string',
        'state' => 'nullable|string',
        'pincode' => 'nullable|integer',
    ]);


    $user = User::findOrFail($id);

    // Update user details
    $user->update([
        'name' => $request->input('username'),
        'email' => $request->input('email'),
        'mobileno' => $request->input('mobileno'),
        'role' => $request->input('role'),
    ]);

    // Handle file upload for logo
    if ($request->hasFile('logo_upload')) {
        // Define the upload directory
        $uploadPath = public_path('images/company_logo');

        // Ensure the directory exists
        if (!file_exists($uploadPath)) {
            mkdir($uploadPath, 0777, true);
        }

        // Delete old logo if it exists
        $companyDetails = CompanyDetail::where('business_id', $id)->first();
        if ($companyDetails && $companyDetails->logo_url) {
            $oldLogoPath = public_path($companyDetails->logo_url);
            if (file_exists($oldLogoPath)) {
                unlink($oldLogoPath);
            }
        }

        // Generate a unique filename
        $file = $request->file('logo_upload');
        $fileName = uniqid() . '.' . $file->getClientOriginalExtension();

        // Move the file to the desired directory
        $file->move($uploadPath, $fileName);

        // Save the file path to the database
        $logoUrl = 'images/company_logo/' . $fileName;
    } else {
        $logoUrl = $request->input('logo_url'); // Use existing logo URL if no new file is uploaded
    }

    // Update company details if the user has the "business" role
    if ($user->role === 'business') {
        $companyDetails = CompanyDetail::where('business_id', $id)->first();

        if ($companyDetails === null) {
            CompanyDetail::create([
                'business_id' => $user->id,
                'name' => $request->input('name'),
                'logo_url' => $logoUrl,
                'description' => $request->input('description'),
                'gst_registration_date' => $request->input('gst_registration_date'),
                'gst_no' => $request->input('gst_no'),
                'legal_status' => $request->input('legal_status'),
                'nature_of_business' => $request->input('nature_of_business'),
                'alternate_names' => $request->input('alternate_names'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'pincode' => $request->input('pincode'),
            ]);
        } else {
            $companyDetails->update([
                'name' => $request->input('name'),
                'logo_url' => $logoUrl,
                'description' => $request->input('description'),
                'gst_registration_date' => $request->input('gst_registration_date'),
                'gst_no' => $request->input('gst_no'),
                'legal_status' => $request->input('legal_status'),
                'nature_of_business' => $request->input('nature_of_business'),
                'alternate_names' => $request->input('alternate_names'),
                'city' => $request->input('city'),
                'state' => $request->input('state'),
                'pincode' => $request->input('pincode'),
            ]);
        }
    }

    return redirect()->route('admin.users.index')->with('success', 'User updated successfully.');
}

    public function destroy($id)
    {
        $user = User::findOrFail($id);
        // Delete the user
        $user->delete();

        // Redirect back with a success message
        return redirect()->route('admin.users.index')->with('success', 'User deleted successfully.');
    }

    public function store_location(Request $request)
    {
        $state = $request['state'];
        $city = $request['city'];
        $postalCode = $request['postalCode'];
        //  print_r($city);die();
        // Store 'city' in the session
        Session::put('city', $city);

        // Retrieve and print 'city' from the session
        // print_r(session('city'));
        // die; 

        return response()->json([
            'message' => 'Location data received successfully.',
            'data' => 'hello',
        ], 200);
    }
    private function getPlaceName($latitude, $longitude)
    {
        // // Construct the Nominatim API URL
        $url = "https://nominatim.openstreetmap.org/reverse?lat={$latitude}&lon={$longitude}&format=json";

        // // Make the HTTP request using Laravel's Http client
        $response = Http::get($url);

       dd($response);
        // if ($response->ok()) {
            $data = $response->json();
            // print_r($response);die;
            // Check if the display_name field is present in the response
            if (isset($data['display_name'])) {
                return $data['display_name'];
            }

            return $data;
        // }

        // return 'Unable to fetch location';
    }
}
