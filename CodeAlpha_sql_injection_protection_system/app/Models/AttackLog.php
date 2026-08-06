<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class AttackLog extends Model
{
    protected $fillable = [
    'ip_address',
    'request_method',
    'route',
    'user_agent',
    'attempted_input',
    'attack_type',
    'status',
];
}