<?php

namespace App\Models\v1;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Channel extends Model
{
    use HasFactory;
    protected $hidden =['id'];

    public function getRouteKeyName()
    {
        return 'channel_name';
    }
    protected $fillable = [
        'channel_name',
        'upazila_id',
        'under'
    ];
   
}
