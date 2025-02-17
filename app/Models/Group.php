<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Group extends Model
{
    use HasFactory;

    protected $table = 'group_master'; 

    protected $fillable = [
        'group_id', 'group_name', 'description', 'status'
    ];

}
