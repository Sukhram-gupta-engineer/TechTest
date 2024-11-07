<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Storage;

class UserController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $users = User::with('role')
        ->whereHas('role', function ($query) {
            $query->where('id', '!=', 1); 
        })
        ->get();
        return view('users',['users'=>$users]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
         // Validate the request
         $request->validate([
            'name' => 'required|string|max:255',
            'email' => 'required|email|unique:users,email',
            'phone' => 'nullable|numeric',
            'description' => 'nullable|string',
            'role_id' => 'required|integer|in:1,2', // 1 for Admin, 2 for User
            'profile_image' => 'nullable|image|mimes:jpeg,png,jpg,gif',
        ]);
        $directoryPath = 'images/'; // Define your directory path here

        if (!Storage::disk('public')->exists($directoryPath)) {
            Storage::disk('public')->makeDirectory($directoryPath);
        }
        $image = $request->file('profile_image');
        $fileName = time() . '.' . $image->getClientOriginalExtension();
        $path = $directoryPath.$fileName;

        Storage::disk('public')->put($path, file_get_contents($image));

        // Store the new user
        $country_code = "+91";
        $user = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'phone' => $country_code.$request->phone,
            'discription' => $request->discription,
            'role_id' => $request->role_id,
            'profile_image' => $path,
        ]);

        return response()->json([
            'user' => $user->load('role'),  // Load role for the user
            'message' => 'User created successfully!'
        ]);
    }
    

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
