<?php

namespace App\Services;

use App\Models\Supplier;
use App\Models\SupplierRate;
use App\Models\User;
use Illuminate\Support\Facades\Auth;

/**
 * Service class to handle operations on Suppliers
 */
class SupplierService
{
    /**
     * Get the list of Supplier that will be used to display to the user
     * 
     * @return array
     */
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

    /**
     * Create a new Supplier in the database
     * 
     * @param array $data
     * @return string | status
     */
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

    /**
     * Update an existing Supplier in the database
     * 
     * @param int $supplier_id
     * @param array $data
     * @return string | status
     */    
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

    /**
     * Delete an existing Supplier from the database
     * 
     * @param int $supplier_id
     * @return string | status
     */    
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
