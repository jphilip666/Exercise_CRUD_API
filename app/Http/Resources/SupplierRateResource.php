<?php

namespace App\Http\Resources;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Http\Resources\Json\JsonResource;

class SupplierRateResource extends JsonResource
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
            'supplier_rate_id' => $this->supplier_rate_id,
            'currency' => $this->currency,
            'rate_start_date' => $this->rate_start_date,
            'rate_end_date' => isset($this->rate_end_date) ? $this->rate_end_date : '',
            'user' => $user->getFullName(),
            'supplier' => $this->supplier,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
        ];
    }
}
