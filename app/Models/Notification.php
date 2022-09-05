<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Notification extends Model
{
    use HasFactory;
    protected $table        = 'notifications';
    protected $fillable = [
        'sender_id',
        'sender_name',
        'receiver_id',
        'reciver_name',
        'sender_application_name',
        'title_notification',
        'content_notification',
        'description_notification',
        'path_destination',
        'type',
        'readed_notification',
        'readed_at',
        'created_at',
        'updated_at'
    ];
}
