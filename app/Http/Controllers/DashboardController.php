<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Invoice;
use App\Models\Customer;
use App\Models\User;

class DashboardController extends Controller
{
    public function dashboard()
    {
        $userData = $this->getChartData(User::class);
        $customerData = $this->getChartData(Customer::class);
        $invoiceData = $this->getChartData(Invoice::class);

        $data = [
            'UserData' => $userData,
            'customerData' => $customerData,
            'invoiceData' => $invoiceData,
        ];

        return response()->json($data, 200);
    }

    private function getChartData($model)
    {
        $chartData = $model::selectRaw('DATE(created_at) as date, COUNT(*) as count')
            ->groupBy('date')
            ->orderBy('date')
            ->get()
            ->map(function ($item) {
                unset($item['data']);
                return $item;
            });

        return $chartData;
    }


}
