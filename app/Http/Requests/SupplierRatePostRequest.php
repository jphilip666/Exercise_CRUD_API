<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class SupplierRatePostRequest extends FormRequest
{
    public function validate()
    {
        $data = json_decode($this->getContent(), true);

        $validated = Validator::make($data, [
            'supplier' => 'required|max:255|exists:suppliers,supplier_id',
            'currency' => 'required|max:255|decimal:0,2',
            'rate_start_date' => 'required|max:555|date_format:Y-m-d',
            'rate_end_date' => 'required|max:555|date_format:Y-m-d',
        ])->validate();

        return $validated;
    }
}
