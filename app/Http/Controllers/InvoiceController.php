<?php

namespace App\Http\Controllers;

use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\Customer;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Auth;
use Barryvdh\DomPDF\Facade as PDF;
use App\Http\Requests\PDFService;
use App\Http\Requests\InvoiceHelping;
use App\Http\Requests\ValidateInvoice;


class InvoiceController extends Controller
{
    public function index()
    {
        $invoices = Invoice::paginate(15);  
        return response()->json($invoices);
    }


    public function show($id)
    {
        $invoice = Invoice::with('invoiceItems', 'customer', 'user')->find($id);
        return response()->json($invoice);
    }

    
    public function edit($id)
    {
        $invoice = Invoice::with('invoiceItems', 'customer', 'user')->find($id);
        return response()->json($invoice, 200);
    }
    

    public function store(Request $request, Invoice $invoice)
    {
        $user_id = Auth::user()->id;

        $validator = app('App\Http\Requests\ValidateInvoice');
        $rules = $validator->rules();
        $validatedData = $request->validate($rules);

        $invoice = Invoice::create([
            'user_id' => Auth::user()->id,
            'customer_id' => $request->input('customer_id'),
            'invoice_number' => $request->input('invoice_number'),
            'due_date' => $request->input('due_date'),
            'payment_term' => $request->input('payment_term'),
            'currency' => $request->input('currency'),
            'type' => $request->input('type'),
        ]);

        InvoiceHelping::processInvoice($request, $invoice);

        return response()->json($invoice, 200);
    }


    public function update(Request $request, Invoice $invoice)
    {
        $user_id = Auth::user()->id;
        $validator = app('App\Http\Requests\ValidateInvoice');
        $rules = $validator->rules();
        $validatedData = $request->validate($rules);
    
        if ($invoice->user_id !== $user_id) {
            return response()->json(['message' => 'Unauthorized'], 401);
        }
        
        $invoice->fill([
            'user_id' => $user_id,
            'customer_id' => $validatedData['customer_id'],
            'invoice_number' => $validatedData['invoice_number'],
            'due_date' => $validatedData['due_date'],
            'payment_term' => $validatedData['payment_term'],
            'currency' => $validatedData['currency'],
            'type' => $validatedData['type'],
        ]);
    
        $invoice->save();
        InvoiceHelping::processInvoice($request, $invoice);
    
        return response()->json($invoice, 200);
    }
    

    public function destroy(Invoice $invoice)
    {
        $invoice->delete();

        return response()->json(null, 204);
    }
}