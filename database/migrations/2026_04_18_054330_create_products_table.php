<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();
            $table->foreignId('category_id')->constrained()->onDelete('cascade');
            $table->foreignId('subcategory_id')->nullable()->constrained()->onDelete('set null');
            $table->foreignId('child_subcategory_id')->nullable()->constrained()->onDelete('set null');

            // Basic
            $table->string('sku')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('brand')->nullable();
            $table->string('tags')->nullable();
            $table->string('product_type')->default('beauty');
            // product_type: beauty, mobile, clothing, book, grocery, jewelry etc

            // Pricing
            $table->decimal('mrp_price', 10, 2)->default(0);
            $table->decimal('display_price', 10, 2)->default(0);
            $table->decimal('discount', 5, 2)->default(0);
            $table->integer('stock')->default(0);
            $table->integer('low_stock_alert')->default(5);

            // Beauty specific
            $table->string('skin_type')->nullable();       // JSON array
            $table->string('gender')->nullable();
            $table->string('concern')->nullable();         // JSON array
            $table->string('net_weight')->nullable();
            $table->string('shelf_life')->nullable();

            // Clothing specific
            $table->json('sizes')->nullable();
            $table->json('colors')->nullable();

            // Book specific
            $table->string('author')->nullable();
            $table->string('publisher')->nullable();
            $table->string('isbn')->nullable();
            $table->string('language')->nullable();
            $table->string('edition')->nullable();
            $table->date('published_date')->nullable();

            // Mobile/Electronics specific
            $table->string('model_number')->nullable();
            $table->integer('warranty_months')->nullable();
            $table->string('warranty_type')->nullable();

            // Variants (JSON)
            $table->json('shade_variants')->nullable();
            $table->json('size_variants')->nullable();
            $table->json('extra_attributes')->nullable();
            // extra_attributes me koi bhi product type ka extra data store hoga

            // Ingredients (Beauty)
            $table->json('key_ingredients')->nullable();
            $table->text('full_ingredients')->nullable();
            $table->boolean('is_organic')->default(false);
            $table->boolean('is_vegan')->default(false);
            $table->boolean('is_cruelty_free')->default(false);
            $table->boolean('is_paraben_free')->default(false);

            // Images
            $table->string('image')->nullable();
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
            $table->string('image4')->nullable();
            $table->string('image5')->nullable();
            $table->json('gallery_images')->nullable();

            // Description
            $table->longText('description')->nullable();
            $table->text('how_to_use')->nullable();
            $table->json('features')->nullable();

            // Shipping
            $table->enum('shipping_type', ['free', 'paid'])->default('paid');
            $table->decimal('shipping_charge', 8, 2)->default(0);
            $table->boolean('cod_available')->default(true);

            // SEO
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            // Flags
            $table->boolean('product_on_sale')->default(false);
            $table->boolean('new_arrivals')->default(false);
            $table->boolean('featured')->default(false);
            $table->boolean('is_active')->default(true);

            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
};