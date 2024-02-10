<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\User;
use Carbon\Carbon;

class DashboardController extends Controller
{
    public function dashboard(Request $request)
    {
        $userData = User::all();
        $customerData = $this->getChartData(Customer::class, $request);
        $invoiceData = $this->getChartData(Invoice::class, $request);

        $data = [
            'UserData' => $userData,
            'customerData' => $customerData,
            'invoiceData' => $invoiceData,
        ];
        return response()->json($data, 200);
    }


    private function getChartData($model, Request $request)
    {
        $startDate = $request->input('start_date', Carbon::now()->startOfMonth());
        $endDate = $request->input('end_date', Carbon::now()->endOfMonth());
        $customerName = $request->input('customer_name');
        $month = $request->input('month');

        $chartDataQuery = $model::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->whereBetween('created_at', [$startDate, $endDate]);

        if ($model === Customer::class && $customerName) {
            $chartDataQuery->where('contact_name', 'like', "%$customerName%");
        }

        if ($model === Invoice::class && $customerName) {
            $chartDataQuery->whereHas('customer', function ($query) use ($customerName) {
                $query->where('contact_name', 'like', "%$customerName%");
            });
        }

        if ($month) {
            $chartDataQuery->whereMonth('created_at', $month);
        }

        $chartData = $chartDataQuery->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                return [
                    'date' => $item->date,
                    'count' => $item->count,
                ];
            });
        
        return $chartData;
    }
}