<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class UserOtpCode extends Model
{
    use HasFactory;

    protected $fillable = [
        'otp_code',
        'otp_code_expired_at',
    ];
}
