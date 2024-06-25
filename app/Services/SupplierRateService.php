<?php

namespace App\Services;

use App\Models\Supplier;
use App\Models\SupplierRate;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SupplierRateService
{
    public function getAllSupplierRatesTableData()
    {
        $all_supplier_rates = SupplierRate::all();

        $supplier_rate_list = [
            'draw' => 1,
            'recordsTotal' => count($all_supplier_rates),
            'data' => [],
        ];

        $count = 1;
        foreach ($all_supplier_rates as $supplier_rate) {
            $user = User::find($supplier_rate->user_id);
            $supplier_rate_list['data'][] = [
                'index' => $count,
                'supplier' => $supplier_rate->supplier,
                'currency' => $supplier_rate->currency,
                'rate_start_date' => $supplier_rate->rate_start_date,
                'rate_end_date' => $supplier_rate->rate_end_date,
                'user' => $user->getFullName(),
                'supplier_rate_id' => $supplier_rate->supplier_rate_id,
            ];
            $count++;
        }

        return $supplier_rate_list;
    }

    public function addSupplierRate($data): string
    {
        $user = Auth::user();
        $supplier_rate = SupplierRate::create([
            'supplier_id' => $data['supplier'],
            'currency' => $data['currency'],
            'rate_start_date' => $data['rate_start_date'],
            'rate_end_date' => $data['rate_end_date'],
            'user_id' => $user->id,
        ]);
        if (isset($supplier_rate)) {
            return 'success';
        } else {
            return 'error';
        }
    }

    public function updateSupplierRate($supplier_rate_id, $data): string
    {
        $supplier_rate = SupplierRate::find($supplier_rate_id);

        if (isset($supplier_rate)) {
            $user = Auth::user();
            $supplier_rate->supplier_id = $data['supplier'];
            $supplier_rate->currency = $data['currency'];
            $supplier_rate->rate_start_date = $data['rate_start_date'];
            $supplier_rate->rate_end_date = $data['rate_end_date'];
            $supplier_rate->user_id = $user->id;
            $supplier_rate->save();

            return 'success';
        } else {
            return 'error';
        }
    }

    public function deleteSupplierRate($supplier_rate_id): string
    {
        $supplier_rate = SupplierRate::find($supplier_rate_id);
        if (isset($supplier_rate)) {
            $supplier_rate->delete();

            return 'success';
        } else {
            return 'error';
        }
    }

    public function getAllSuppliersForSelect()
    {
        $supplier_list = [];

        foreach (Supplier::all() as $supplier) {
            $supplier_list[$supplier->supplier_id] = $supplier->name;
        }

        return $supplier_list;
    }
}
