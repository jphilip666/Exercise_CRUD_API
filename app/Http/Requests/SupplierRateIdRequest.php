<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class SupplierRateIdRequest extends FormRequest
{
    public function validate()
    {
        $data['id'] = $this->id;

        $validator = Validator::make($data, [
            'id' => 'required|exists:supplier_rates,supplier_rate_id',
        ]);

        $validated = $validator->validate();

        return $validated;
    }
}
