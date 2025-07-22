<?php

namespace App\Models;

use App\Enums\OrderStatus;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Relations\BelongsTo;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Relations\BelongsToMany;

class Order extends Model
{
    use HasFactory;

    protected $fillable = [
        'disaster_id',
        'status',
        'user_id',
        'code',
        'post_id',

    ];

    protected $casts = [
        'status' => OrderStatus::class,
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($model) {
            $model->code = 'ORD-' . random_int(100000, 999999);
        });
    }

    public function disaster()
    {
        return $this->belongsTo(Disaster::class);
    }

    public function user()
    {
        return $this->belongsTo(User::class, 'user_id');
    }

    public function users(): BelongsToMany
    {
        return $this->belongsToMany(User::class);
    }

    public function orderItems()
    {
        return $this->hasMany(OrderItem::class);
    }

    public function updateStock()
    {
        foreach ($this->orderItems as $orderItem) {
            $item = $orderItem->item;
            $item->increaseStock($orderItem->quantity);

            // Record history
            History::create([
                'history_code' => 'HIS-' . random_int(100000, 999999),
                'order_code' => $this->code,
                'status' => 'order',
            ]);
        }
    }

    public function post()
    {
        return $this->belongsTo(Post::class);
    }


}
