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
            $table->id(); // Khóa chính của bảng posts
            $table->string('title', 200);
            $table->string('slug', 255)->unique();
            $table->text('content');
            $table->string('image', 200);
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            // SỬA ĐỔI: Khóa ngoại tham chiếu đến cột 'userid' trong bảng 'users'
            // Vì bảng users dùng khóa chính là 'userid', ta phải khai báo rõ ràng:
            $table->unsignedBigInteger('user_id');
            $table->foreign('user_id')
                ->references('id') // Trỏ đến đúng tên cột khóa chính
                ->on('users')
                ->restrictOnDelete();
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
