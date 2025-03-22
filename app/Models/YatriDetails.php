<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class YatriDetails extends Model
{
    use HasFactory;

    protected $table = 'yatri_details'; 

    protected $fillable = [
        'yatri_name',
        'mobile_no',
        'whatsapp_no',
        'email',
        'date_of_coming',
        'date_of_going',
        'description',
        'landmark',
        'pincode',
        'city_village',
        'district',
        'state',
        'country',
        'status',
    ];
}
