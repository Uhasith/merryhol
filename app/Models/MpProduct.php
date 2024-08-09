<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MpProduct extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'mp_product';

    protected $casts = [
        'created_on' => 'datetime',
    ];

    public function supplier(): BelongsTo
    {
        return $this->belongsTo(MpSupplier::class, 'supplier_id', 'supplier_id');
    }
}
