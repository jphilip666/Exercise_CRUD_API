<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Support\Facades\Validator;

class SupplierPostRequest extends FormRequest
{
    public function validate()
    {
        $data = json_decode($this->getContent(), true);

        $validated = Validator::make($data, [
            'name' => 'required|max:255|string',
            'address' => 'required|max:555',
        ])->validate();

        return $validated;
    }
}
