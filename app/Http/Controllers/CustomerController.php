<?php
namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Auth;

class CustomerController extends Controller
{
    public function index()
    {
      
        $customers = Customer::paginate(15);
        // dd($customers);
        // dd('test');
        return response()->json($customers);
    }


    public function show(Request $request, $id)
    {
        $customer = Customer::find($id);
        return response()->json($customer);
    }


    public function edit($id)
    {
        // dd($customer);
        $customer = Customer::find($id);

        
        
        return response()->json($customer);
    }

    
    public function store(Request $request)
    {
        
        $user_id = Auth::user()->id;  
           
        $validatedData = $request->validate([
            'contact_name' => 'required|unique:customers,contact_name',
            'company_name' => 'required|unique:customers,company_name',
            'email' => 'required|email|unique:customers,email',
            'vat_number' => 'required|unique:customers,vat_number',
            'type' => 'required',
            'status' => 'required',
            
        ]);
        

        // dd($validatedData);
        $validatedData['user_id'] = $user_id;
        $customer = Customer::create($validatedData);
        
        return response()->json($customer, 201);
    }

    public function update(Request $request, Customer $customer)
    {
        $validatedData = $request->validate([
            'contact_name' => 'required|unique:customers,contact_name,'.$customer->id,
            'company_name' => 'required|unique:customers,company_name,'.$customer->id,
            'email' => 'required|email|unique:customers,email,'.$customer->id,
            'vat_number' => 'required|unique:customers,vat_number,'.$customer->id,
            'type' => 'required',
            'status' => 'required',
        ]);
       
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
