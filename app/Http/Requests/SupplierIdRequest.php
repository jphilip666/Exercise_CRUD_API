<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class SupplierIdRequest extends FormRequest
{
    public function validate()
    {
        $data['id'] = $this->id;

        $validator = Validator::make($data, [
            'id' => 'required|exists:suppliers,supplier_id',
        ]);

        $validated = $validator->validate();

        return $validated;
    }
}
