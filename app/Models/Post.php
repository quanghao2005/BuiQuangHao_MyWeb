<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Post extends Model
{
    use HasFactory;

    protected $table = 'posts';

    protected $fillable = [
        'title',
        'slug',
        'content',
        'image',
        'status',
        'user_id' // content thay vì detail, user_id thay vì userid
    ];

    public function user()
    {
        // Khóa ngoại là 'user_id'
        return $this->belongsTo(User::class, 'user_id', 'id');
    }
}
