<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Stock extends Model
{
    use HasFactory;

    protected $fillable = [
        'adjustment_code',
        'title',
        'note',
        'status',
    ];

    protected $attributes = [
        'status' => 'pending', // Default status value
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            if (empty($model->adjustment_code)) {
                $model->adjustment_code = 'ADJ-' . random_int(100000, 999999);
            }
        });
    }

    public function items()
    {
        return $this->hasMany(StockItem::class);
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }

    public function createAdjustmentHistory()
    {
        History::create([
            'history_code' => 'HIS-' . random_int(100000, 999999),
            'adjustment_code' => $this->adjustment_code,
            'status' => 'penyesuaian',
        ]);
    }
}
