<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class ContactDetails extends Model
{
    use HasFactory;

    protected $table = 'contact_details'; 

    protected $fillable = [
        'contact_id', 'name', 'phone','group_status','status'
    ];
    
}
