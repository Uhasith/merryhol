<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class MpSupplier extends Model
{
    use HasFactory;

    protected $guarded = ['id'];

    protected $table = 'mp_supplier';

    protected $casts = [
        'created_on' => 'datetime',
    ];
}
