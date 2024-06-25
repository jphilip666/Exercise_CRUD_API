<?php

namespace App\Http\Controllers;

use App\Http\Requests\SupplierRateIdRequest;
use App\Http\Requests\SupplierRatePostRequest;
use App\Http\Requests\SupplierRateUpdateRequest;
use App\Services\SupplierRateService;
use Illuminate\Http\JsonResponse;
use Illuminate\Http\Request;
use Illuminate\View\View;

class SupplierRateController extends Controller
{
    /**
     * Display the user's profile form.
     */
    public function getSupplierRateListView(Request $request): View
    {
        return view('supplier_rate');
    }

    /**
     * Display the user's profile form.
     */
    public function getSupplierRateTableData(Request $request, SupplierRateService $supplierRateService): JsonResponse
    {
        return response()->json([
            'status' => 'success',
            'supplier_rates' => $supplierRateService->getAllSupplierRatesTableData(),
            'supplier_list' => $supplierRateService->getAllSuppliersForSelect(),
        ], 200);
    }

    /**
     * Display the user's profile form.
     */
    public function addSupplierRate(SupplierRatePostRequest $request, SupplierRateService $supplierRateService): JsonResponse
    {
        $data = $request->validate();

        $status = $supplierRateService->addSupplierRate($data);

        return response()->json([
            'status' => $status,
        ], 200);
    }

    /**
     * Display the user's profile form.
     */
    public function updateSupplierRate(SupplierRateUpdateRequest $request, SupplierRateService $supplierRateService): JsonResponse
    {
        $data = $request->validate();

        $status = $supplierRateService->updateSupplierRate($request->id, $data);

        return response()->json([
            'supplier_rate_id' => $request->id,
            'status' => $status,
        ], 200);
    }

    /**
     * Display the user's profile form.
     */
    public function deleteSupplierRate(SupplierRateIdRequest $request, SupplierRateService $supplierRateService): JsonResponse
    {
        $data = $request->validate();

        $status = $supplierRateService->deleteSupplierRate($data['id']);

        return response()->json([
            'supplier_rate_id' => $request->id,
            'status' => $status,
        ], 200);
    }
}
