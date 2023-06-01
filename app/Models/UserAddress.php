<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserAddress extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'region_id',
        'district_id',
        'township_id',
        'address',
        'zip_code',
    ];

    protected $with = ['township', 'district', 'region'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function township()
    {
        return $this->belongsTo(Township::class);
    }

    public function district()
    {
        return $this->belongsTo(District::class);
    }

    public function region()
    {
        return $this->belongsTo(Region::class);
    }
}
