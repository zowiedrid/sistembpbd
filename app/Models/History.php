<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class History extends Model
{
    use HasFactory;

    protected $fillable = [
        'history_code',
        'adjustment_code',
        'order_code',
        'status', // 'order' atau 'penyesuaian'
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->history_code = 'HIS-' . random_int(100000, 999999);
        });
    }
}
