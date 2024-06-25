<?php

namespace App\Services;

use App\Http\Resources\SupplierRateResource;
use App\Http\Resources\SupplierResource;
use App\Models\Supplier;
use App\Models\SupplierRate;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Resources\Json\AnonymousResourceCollection;
/**
 * Service class for API requests
 */
class SupplierApiService
{
    /**
     * Returns a list of all the suppliers and their rates
     * 
     * @return array 
     */
    public function getAllSuppliersAndTheirRates(): AnonymousResourceCollection
    {
        return SupplierResource::collection(Supplier::all());
    }

    /**
     * Calculate and return all the suppliers where their Rate start and Rate end overlaps
     * 
     * @param Int $supplier_id
     * @return array
     */
    public function getAllOverlappingSuppliersAndTheirRates($supplier_id): array
    {
        if (isset($supplier_id)) {
            $rates = DB::select('SELECT 
                                DISTINCT(s1.supplier_rate_id)
                            FROM suppliers_test.supplier_rates s1, suppliers_test.supplier_rates s2
                            WHERE 
                                s1.supplier_rate_id <> s2.supplier_rate_id 	
                                AND
                                (
                                    (s1.rate_start_date >= s2.rate_start_date AND s1.rate_start_date <= s2.rate_end_date)
                                    OR (s1.rate_start_date <= s2.rate_start_date AND s1.rate_end_date >= s2.rate_start_date)
                                    OR (s1.rate_start_date >= s2.rate_start_date AND s2.rate_end_date IS NULL)
                                    OR (s2.rate_start_date >= s1.rate_start_date AND s1.rate_end_date IS NULL)
                                )	
                                AND	
                                    s1.supplier_id = ? AND s2.supplier_id = ?		
                                ORDER BY s1.supplier_rate_id', [$supplier_id, $supplier_id]);
        } else {
            $rates = DB::select('SELECT 
                                    DISTINCT(s1.supplier_rate_id)
                                FROM suppliers_test.supplier_rates s1, suppliers_test.supplier_rates s2
                                WHERE 
                                    s1.supplier_rate_id <> s2.supplier_rate_id 	
                                    AND
                                    (
                                        (s1.rate_start_date >= s2.rate_start_date AND s1.rate_start_date <= s2.rate_end_date)
                                        OR (s1.rate_start_date <= s2.rate_start_date AND s1.rate_end_date >= s2.rate_start_date)
                                        OR (s1.rate_start_date >= s2.rate_start_date AND s2.rate_end_date IS NULL)
                                        OR (s2.rate_start_date >= s1.rate_start_date AND s1.rate_end_date IS NULL)
                                    )		
                                    ORDER BY s1.supplier_rate_id');

        }

        $supplier_rates = [];
        foreach ($rates as $rate) {
            $supplier_rate = SupplierRate::find($rate->supplier_rate_id);
            $supplier_rates[] = new SupplierRateResource($supplier_rate);
        }

        return $supplier_rates;
    }
}
