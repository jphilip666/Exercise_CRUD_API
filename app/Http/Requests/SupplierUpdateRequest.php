<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class SupplierUpdateRequest extends FormRequest
{
    public function validate()
    {
        $data = json_decode($this->getContent(), true);
        $data['id'] = $this->id;

        $validator = Validator::make($data, [
            'id' => 'required|exists:suppliers,supplier_id',
            'name' => 'required|max:255',
            'address' => 'required|max:555',
        ]);

        $validated = $validator->validate();

        return $validated;
    }
}
