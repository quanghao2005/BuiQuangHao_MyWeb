<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Brand extends Model
{
    use HasFactory;

    protected $table = 'brands'; // Chỉ định tên bảng
    protected $primaryKey = 'brandid'; // Bắt buộc phải có dòng này
    // Khai báo các trường được phép thêm/sửa hàng loạt
    protected $fillable = [
        'brandname',
        'slug',
        'image',
        'status',
        'description'
    ];
}
