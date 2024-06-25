<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierResource extends JsonResource
{
    /**
     * Transform the resource into an array.
     *
     * @return array<string, mixed>
     */
    public function toArray(Request $request): array
    {
        $user = User::find($this->user_id);

        return [
            'supplier_id' => $this->supplier_id,
            'name' => $this->name,
            'address' => $this->address,
            'user' => $user->getFullName(),
            'rates' => SupplierRateResource::collection($this->rates),
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
