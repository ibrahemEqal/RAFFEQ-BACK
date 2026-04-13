<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class WantedItem extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'title',
        'description',
        'contact_phone',
        'is_fulfilled', 
        'offer_type' ,
        'offer_file_path'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }
}