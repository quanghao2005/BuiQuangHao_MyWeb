<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Banner extends Model
{
    use HasFactory;
    
    protected $table = 'banners';
    protected $primaryKey = 'bannerid';
    
    protected $fillable = [
        'title',
        'description',
        'image',
        'link',
        'position',
        'order',
        'status'
    ];
}
