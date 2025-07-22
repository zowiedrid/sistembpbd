<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $fillable = [
        'name',
        'district_id',
        'village_id',
        'latitude',
        'longitude',
        'link_maps',
        'status',
    ];

    public function district()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\District::class);
    }

    public function village()
    {
        return $this->belongsTo(\Laravolt\Indonesia\Models\Village::class);
    }

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function orders()
    {
        return $this->hasMany(Order::class, 'destination_id');
    }
}
