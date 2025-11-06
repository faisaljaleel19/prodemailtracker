<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class LoginLogs extends Model
{
    use HasFactory;

    protected $table = 'login_logs';

    protected $fillable = [
        'name',
        'email',
        'microsoft_id'
    ];
}
