<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class InvoiceHelping 
{
    public static function processInvoice($request, $invoice)
    {
        if ($request->has('items')) {
            $invoice->invoiceItems()->delete(); 

            foreach ($request->input('items') as $item) {
                $invoice->invoiceItems()->create([
                    'amount' => $item['amount'] ?? null,
                    'description' => $item['description'] ?? null,
                ]);
            }
        }
    }
}

