<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\HasMany;
use Illuminate\Database\Eloquent\Relations\HasOne;

/**
 * Supplier Model
 */
class Supplier extends Model
{
    use HasFactory;

    /**
     * The primary key associated with the table.
     *
     * @var int
     */
    protected $primaryKey = 'supplier_id';

    /**
     * The attributes that are mass assignable.
     *
     * @var array<int, string>
     */
    protected $fillable = [
        'name',
        'address',
        'user_id',
    ];

    /**
     * Get the supplier rates for this supplier.
     * 
     * This is a one to many relationship
     */
    public function rates(): HasMany
    {
        return $this->hasMany(SupplierRate::class, 'supplier_id', 'supplier_id');
    }

    /**
     * Get the user who created this Supplier.
     */
    public function user(): HasOne
    {
        return $this->hasOne(User::class, 'id', 'user_id');
    }
}
