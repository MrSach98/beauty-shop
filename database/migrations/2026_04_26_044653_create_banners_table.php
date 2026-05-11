<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('banners', function (Blueprint $table) {
            $table->id();
            $table->string('title')->nullable();
            $table->string('subtitle')->nullable();
            $table->string('image');
            $table->string('image_mobile')->nullable();
            $table->string('button_text')->nullable();
            $table->string('link_url')->nullable();
            $table->enum('type', [
                'hero_slider',
                'offer_banner',
                'popup_banner',
                'category_banner'
            ])->default('hero_slider');
            $table->enum('position', [
                'homepage',
                'category_page',
                'checkout_page',
                'all_pages'
            ])->default('homepage');
            $table->integer('sort_order')->default(0);
            $table->date('start_date')->nullable();
            $table->date('end_date')->nullable();
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }
    public function down() { Schema::dropIfExists('banners'); }
};