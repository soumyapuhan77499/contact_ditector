<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class GroupAssign extends Model
{
    use HasFactory;

    protected $table = 'contact__assign_group'; 

    protected $fillable = [
        'group_id', 'contact_id', 'status'
    ];

    public function contactDetails()
    {
        return $this->belongsTo(ContactDetails::class, 'contact_id', 'contact_id');
    }

    public function group()
{
    return $this->belongsTo(Group::class, 'group_id', 'group_id');
}

}


