<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Item extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'category_id',
        'brand_id',
        'description',
        'quantity',
        'unit',
        'price',
        'is_visible',
        'sku',
        'barcode',
    ];

    public function reduceStock($quantity)
    {
        $this->quantity += $quantity;
        $this->save();
    }

    public function increaseStock($quantity)
    {
        $this->quantity -= $quantity;
        $this->save();
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function histories()
    {
        return $this->hasMany(History::class);
    }

    public function stocks()
    {
        return $this->hasMany(Stock::class);
    }

    public function brand()
    {
        return $this->belongsTo(Brand::class, 'brand_id');
    }

    public function category()
    {
        return $this->belongsTo(Category::class, 'category_id');
    }
}
