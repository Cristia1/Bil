<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;
use App\Http\Requests\ValidateCustomer;
class CustomerController extends Controller
{

    public function index()
    {
        $customers = Customer::paginate(15);
        return response()->json($customers);
    }


    public function show(Request $request, $id)
    {
        $customer = Customer::find($id);
        return response()->json($customer);
    }


    public function edit($id)
    {
        $customer = Customer::find($id);
        return response()->json($customer);
    }

    
    public function store(Request $request)
    {
        $user_id = Auth::user()->id;
        
        $rules = ValidateCustomer::rules();
        $validatedData = $request->validate($rules);
        $validatedData['user_id'] = $user_id;
        $customer = Customer::create($validatedData);

        return response()->json(['status' => 200, 'customer' => $customer]);
    }


    public function update(Request $request, Customer $customer)
    {
        $rules = ValidateCustomer::rules();
        $validatedData = $request->validate($rules);
        $customer->update($validatedData);

        return response()->json($customer, 200);
    }


    public function destroy($id)
    {
        $customer = Customer::findOrFail($id);
        $customer->delete();

        return response()->json(null, 204);
    }
}