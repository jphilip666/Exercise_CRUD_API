<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * SupplierRate Model
 */
class SupplierRate extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var int
     */
    protected $primaryKey = 'supplier_rate_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'supplier_id',
        'currency',
        'rate_start_date',
        'rate_end_date',
        'user_id',
    ];

    /**
     * Get the supplier for this rate.
     */
    public function supplier(): BelongsTo
    {
        return $this->belongsTo(Supplier::class, 'supplier_id', 'supplier_id');
    }

    /**
     * Get the user who created this rate.
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
