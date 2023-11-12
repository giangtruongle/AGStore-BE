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
        Schema::create('product', function (Blueprint $table) {
            $table->id();
            $table->string('name',255);
            $table->string('slug',255)->nullable();
            $table->float('price')->nullable()->unsigned();
            $table->text('description');
            $table->integer('quantity')->unsigned();
            $table->text('size')->nullable();
            $table->string('image_url',255)->nullable();
            $table->boolean('status')->default(1);
            $table->unsignedBigInteger('product_category_id')->nullable();
            $table->foreign('product_category_id')->references('id')->on('product_category')->onDelete('cascade');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product');
    }
};
