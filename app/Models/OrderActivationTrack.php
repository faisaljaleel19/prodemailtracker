<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class OrderActivationTrack extends Model
{
    use HasFactory;

    protected $table = 'order_activation_tracks';

    protected $fillable = [
        'order_number',
        'order_punched_date',
        'order_confirmed_date',
        'student_name',
        'primary_email_id',
        'primary_mobile_no',
        'country',
        'oh_number',
        'premium_id',
        'siblings',
        'sales_user',
        'lead_details',
        'category',
        'syllabus',
        'activation_status',
        'delivered_marked',
        'mail_sent',
        'lead_sent_to_india_date',
        'task_creation_sent_to_india',
        'remarks',
        'manually_link_sent_to_india',
        'mail_sent_date',
        'batch_no',
        'created_by'
    ];
}
