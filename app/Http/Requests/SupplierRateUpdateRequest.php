<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class SupplierRateUpdateRequest extends FormRequest
{
    public function validate()
    {
        $data = json_decode($this->getContent(), true);
        $data['id'] = $this->id;

        $validator = Validator::make($data, [
            'id' => 'required|exists:supplier_rates,supplier_rate_id',
            'supplier' => 'required|max:255|exists:suppliers,supplier_id',
            'currency' => 'required|max:255|decimal:0,2',
            'rate_start_date' => 'required|max:555|date_format:Y-m-d',
            'rate_end_date' => 'required|max:555|date_format:Y-m-d',
        ]);

        $validated = $validator->validate();

        return $validated;
    }
}
