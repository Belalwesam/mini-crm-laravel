<?php

namespace App\Http\Controllers;

use App\Models\User;
use App\Models\Company;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\CompanyStoreRequest;
use App\Http\Requests\UserStoreRequest;

class AdminController extends Controller
{
    public function index()
    {
        $companies_count = Company::count();
        $employees_count = User::count();
        return response()->json([
            'companies_count' => $companies_count,
            'employees_count' => $employees_count,
        ]);
    }
    //companies list 
    public function companies()
    {
        $companies = Company::all();
        return response()->json([
            'companies' => $companies
        ]);
    }

    //single company info 
    public function company($id)
    {
        $company = Company::find($id);
        if ($company) {
            return response()->json([
                'company' => $company
            ]);
        } else {
            return response(['message' => 'no records found'], 422);
        }
    }

    //edit an existing company 
    public function editCompany(CompanyStoreRequest $request, $id)
    {
        $company = Company::find($id);
        if ($company) {
            $company->name = $request->name;
            $company->email = $request->email;
            $company->password = Hash::make($request->password);
            $company->save();
            return response()->json([
                'company' => $company
            ]);
        } else {
            return response(['message' => 'no recoreds found'], 422);
        }
    }
    //deleting an existing company recored
    public function destroyCompany($id)
    {
        $company = Company::find($id);
        if ($company) {
            $company->delete();
            return response()->json([
                'message' => 'deleted successfully'
            ]);
        } else {
            return response(['message' => 'no recoreds found'], 422);
        }
    }

    //eomployees
    #get all teh employees
    public function employees()
    {
        $employees = User::all();
        return response()->json([
            'employees' => $employees
        ]);
    }
    //single employee info 
    public function employee($id)
    {
        $employee = User::find($id);
        if ($employee) {
            return response()->json([
                'employee' => $employee
            ]);
        } else {
            return response(['message' => 'no records found'], 422);
        }
    }
    #edit an existing employee info 
    public function editEmployee(UserStoreRequest $request, $id)
    {
        $employee = User::find($id);
        if ($employee) {
            $employee->name = $request->name;
            $employee->email = $request->email;
            $employee->password = Hash::make($request->password);
            $employee->save();
            return response()->json([
                'employee' => $employee
            ]);
        } else {
            return response(['message' => 'no recoreds found'], 422);
        }
    }
    #deleting an existing employee recored
    public function destroyEmployee($id)
    {
        $employee = User::find($id);
        if ($employee) {
            $employee->delete();
            return response()->json([
                'message' => 'deleted successfully'
            ]);
        } else {
            return response(['message' => 'no recoreds found'], 422);
        }
    }
}
