<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('posts', function (Blueprint $table) {
            $table->id(); // INT, AUTO_INCREMENT, PRIMARY KEY
            $table->string('title', 200); // VARCHAR(200) - Tiêu đề bài viết
            $table->string('slug', 255)->unique(); // VARCHAR(255), UNIQUE
            $table->text('content'); // text - Nội dung bài viết
            $table->string('image', 200); // VARCHAR(200) - Hình ảnh đại diện
            $table->tinyInteger('status')->default(1); // tinyInteger, default(1) (1: hiển thị, 0: ẩn)

            // Khóa ngoại tham chiếu bảng users (Không cho phép xóa User khi vẫn còn bài viết tham chiếu)
            $table->foreignId('user_id')
                ->constrained('users')
                ->restrictOnDelete(); // Ngăn chặn hành động xóa bảng cha

            $table->timestamps(); // Tự động tạo created_at và updated_at (TIMESTAMP)
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('posts');
    }
};
