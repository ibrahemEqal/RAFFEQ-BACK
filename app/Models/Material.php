<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Material extends Model
{
    use HasFactory;

    protected $fillable = [
            'user_id',
            'title',
            'subject_name',
            'file_path',
            'is_free',
            'type',              
            'whatsapp_number',  
            'is_available',
            'department',     
        ];
    
}