<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderTrackBatch extends Model
{
    use HasFactory;

    protected $table = 'order_tracker_batch_table';

    protected $fillable = [
        'batch_no',
        'uploaded_by'
    ];
}
