<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use App\Models\Invoice;
use App\Models\InvoiceItem;
use App\Models\User;
use App\Models\Customer;
use Illuminate\Http\Request;
use PDF;


class PDFService extends FormRequest
{
    
    public function generateInvoicePDF($id)
    {
        $invoice = Invoice::find($id);
        $user = User::find($invoice->userId);
        $customer = Customer::find($invoice->customerId);

        // Accesează relația invoiceItems pentru a obține articolele asociate facturii
        $invoice_items = $invoice->invoiceItems;

        $totalAmount = 0;
        foreach ($invoice_items as $item) {
            $totalAmount += $item->amount; 
        }

        $data = [
            'invoice' => $invoice,
            'invoice_items' => $invoice_items,
            'user' => $user,
            'customer' => $customer,
            'totalAmount' => $totalAmount,
        ];

        $pdf = PDF::loadView('pdf.ExportInvoices', $data);

        return $pdf;
    }


}