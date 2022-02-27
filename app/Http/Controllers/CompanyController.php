<?php

namespace App\Http\Controllers;

use App\Http\Requests\CompanyStoreRequest;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Http\Requests\UserStoreRequest;
use App\Models\Company;

class CompanyController extends Controller
{
    //view company info 
    public function company()
    {
        $company = Company::find(auth()->user()->id);
        if ($company) {
            return response()->json([
                'company' => $company
            ]);
        } else {
            return response(['message' => 'no records found'], 422);
        }
    }
    public function editCompany(CompanyStoreRequest $request)
    {
        $company = Company::find(auth()->user()->id);
        if ($company) {
            $company->name = $request->name;
            $company->email = $request->email;
            $company->password = Hash::make($request->password);
            $company->save();
            return response()->json([
                'message' => 'edit was successfull',
                'company' => $company
            ]);
        } else {
            return response(['message' => 'no records found'], 422);
        }
    }
    //create an employee that belongs to the company
    public function createEmployee(UserStoreRequest $request)
    {
        $employee = User::create([
            'name' => $request->name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
            'company_id' => auth()->user()->id
        ]);
        return response()->json([
            'message' => 'employee stored successfully',
            'employee' => $employee
        ]);
    }
    //deleting the companies account 
    public function destroy()
    {
        $company = Company::find(auth()->user()->id);
        $company->delete();
        return response()->json([
            'message' => 'account deleted succesfully'
        ]);
    }
    //listing all of the company's employees
    public function employees()
    {
        $employees = Company::find(auth()->user()->id)->users;
        return response()->json([
            'employees' => $employees,
            'total_employees_count' => count($employees)
        ]);
    }
    //edit employee
    public function editEmployee(UserStoreRequest $request, $id)
    {
        $employee = User::find($id);
        if ($employee) {
            if ($employee->company->id === auth()->user()->id) {
                $employee->name = $request->name;
                $employee->email = $request->email;
                $employee->password = Hash::make($request->password);
                $employee->save();
                return response()->json([
                    'message' => 'editted successfully',
                    'employee' => $employee
                ]);
            } else {
                return response(['message' => 'Oops! something went wrong.'], 422);
            }
        } else {
            return response(['message' => 'no records found'], 422);
        }
    }
    //deleting an existing employee recored 
    public function destroyEmployee($id)
    {
        $employee = User::find($id);
        if ($employee) {
            if ($employee->company->id === auth()->user()->id) {
                $employee->delete();
            } else {
                return response(['message' => 'Oops! something went wrong'], 422);
            }
        } else {
            return response(['message' => 'no records found'], 422);
        }
    }
}
