<?php

namespace App\Services;

use App\Models\Supplier;
use App\Models\SupplierRate;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

class SupplierService
{
    public function getAllSuppliersTableData()
    {
        $all_suppliers = Supplier::all();

        $supplier_list = [
            'draw' => 1,
            'recordsTotal' => count($all_suppliers),
            'data' => [],
        ];

        $count = 1;
        foreach ($all_suppliers as $supplier) {
            $user = User::find($supplier->user_id);
            $supplier_list['data'][] = [
                'index' => $count,
                'name' => $supplier->name,
                'address' => $supplier->address,
                'user' => $user->getFullName(),
                'supplier_id' => $supplier->supplier_id,
            ];
            $count++;
        }

        return $supplier_list;
    }

    public function addSupplier($data): string
    {
        $user = Auth::user();
        $supplier = Supplier::create([
            'name' => $data['name'],
            'address' => $data['address'],
            'user_id' => $user->id,
        ]);
        if (isset($supplier)) {
            return 'success';
        } else {
            return 'error';
        }
    }

    public function updateSupplier($supplier_id, $data): string
    {
        $supplier = Supplier::find($supplier_id);

        if (isset($supplier)) {
            $user = Auth::user();
            $supplier->name = $data['name'];
            $supplier->address = $data['address'];
            $supplier->user_id = $user->id;
            $supplier->save();

            return 'success';
        } else {
            return 'error';
        }
    }

    public function deleteSupplier($supplier_id): string
    {
        $supplier = Supplier::find($supplier_id);
        if (isset($supplier)) {
            SupplierRate::where('supplier_id', $supplier->supplier_id)->delete();
            $supplier->delete();

            return 'success';
        } else {
            return 'error';
        }
    }
}
