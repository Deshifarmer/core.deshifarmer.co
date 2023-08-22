<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Advisory extends Model
{
    use HasFactory;

    protected $fillable = [
        'subject',
        'time_slot',
        'farmer_group_id',
        'farmer_list',
        'files',
        'note',
        'created_by',
        'updated_by',
        'advised_by',
        'advised_at',
        'advised_note',
        'advised_status',
    ];

    protected $casts = [
        'files' => 'array',
        'farmer_list' => 'array',
    ];
}
