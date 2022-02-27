<?php

namespace App\Http\Controllers\Auth;

use App\Models\User;
use App\Models\Admin;
use App\Models\Company;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Http\Requests\AdminStoreRequest;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\LoginRequest;

class AuthController extends Controller
{   //storing the admin
    public function storeAdmin(AdminStoreRequest $request)
    {
        $admin = Admin::create([
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $token = $admin->createToken('token')->plainTextToken;
        return response()->json([
            'message' => 'admin created successfully',
            'admin' => $admin,
            'token' => $token
        ]);
    }
    //storing the company
    public function storeCompany(CompanyStoreRequest $request)
    {
        $company = Company::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password)
        ]);
        $token = $company->createToken('token')->plainTextToken;
        return response()->json([
            'message' => 'company created successfully',
            'company' => $company,
            'token' => $token,
        ]);
    }

    //logging in the admin 
    public function loginAdmin(LoginRequest $request)
    {
        $admin = Admin::where('email', $request->email)->first();
        if (!$admin || !Hash::check($request->password, $admin->password)) {
            return response()->json([
                'message' => 'your information does not exist in the records',
                'status' => 401
            ]);
        } else {
            $token = $admin->createToken('token')->plainTextToken;
            return response()->json([
                'message' => 'logged in successfully as admin',
                'admin' => $admin,
                'token' => $token
            ]);
        }
    }
    //logging in the company 
    public function loginCompany(LoginRequest $request)
    {
        $company = Company::where('email', $request->email)->first();
        if (!$company || !Hash::check($request->password, $company->password)) {
            return response()->json([
                'message' => 'your information does not exist in the records'
            ]);
        } else {
            $token = $company->createToken('token')->plainTextToken;
            return response()->json([
                'message' => 'logged in successfully as company',
                'company' => $company,
                'token' => $token
            ]);
        }
    }
    //logging in the user 
    public function loginUser(LoginRequest $request)
    {
        $user = User::where('email', $request->email)->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            return response()->json([
                'message' => 'your information does not exist in the records'
            ]);
        } else {
            $token = $user->createToken('token')->plainTextToken;
            return response()->json([
                'message' => 'logged in successfully as user',
                'user' => $user,
                'token' => $token
            ]);
        }
    }

    //logging out all kinds of users 
    public function logout()
    {
        auth()->user()->tokens()->delete();
        return response()->json([
            'message' => 'logged out successfully'
        ]);
    }
}
