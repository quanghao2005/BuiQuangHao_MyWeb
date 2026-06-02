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
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->string('productname', 150);
            $table->string('slug', 200)->unique();

            // Giá - giá bán
            $table->decimal('price', 12, 2)->default(0);

            // Giá - giá sau khi được giảm
            $table->decimal('pricediscount', 12, 2)->default(0);

            $table->string('image')->nullable();
            $table->text('description')->nullable();
            $table->tinyInteger('status')->default(1);
            $table->timestamps();

            // =======
            // Khóa ngoại với bảng brands (Khi xóa Brand -> sản phẩm vẫn tồn tại, brandid được gán NULL)
            $table->foreignId('brandid')
                ->nullable()
                ->constrained('brands')
                ->nullOnDelete();

            // Khóa ngoại với bảng categories (Khi xóa Category -> không cho xóa nếu còn sản phẩm tham chiếu)
            $table->unsignedInteger('cateid');
            $table->foreign('cateid')
                ->references('cateid')
                ->on('categories')
                ->restrictOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('products');
    }
};
