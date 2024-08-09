<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class MpBook extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'mp_booking';

    protected $casts = [
        'created_on' => 'datetime',
    ];

    public function airport(): BelongsTo
    {
        return $this->belongsTo(MpAirport::class, 'airport_id', 'airport_id');
    }

    public function product(): BelongsTo
    {
        return $this->belongsTo(MpProduct::class, 'product_id', 'product_id');
    }
}
