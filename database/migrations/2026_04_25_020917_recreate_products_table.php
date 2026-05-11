<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        // Pehle old table drop karo
        Schema::dropIfExists('products');

        // Naya clean table banao
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            // ── Category ─────────────────────────────────
            $table->foreignId('category_id')
                  ->constrained('categories')
                  ->onDelete('cascade');
            $table->foreignId('subcategory_id')
                  ->nullable()
                  ->constrained('subcategories')
                  ->onDelete('set null');
            $table->foreignId('child_subcategory_id')
                  ->nullable()
                  ->constrained('child_subcategories')
                  ->onDelete('set null');

            // ── Basic Info ────────────────────────────────
            $table->string('product_type');
            // beauty, clothing, book, electronic, mobile etc.
            $table->string('sku')->unique();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('brand')->nullable();
            $table->string('tags')->nullable();

            // ── Pricing & Stock ───────────────────────────
            $table->decimal('mrp_price', 10, 2)->default(0);
            $table->decimal('display_price', 10, 2)->default(0);
            $table->decimal('discount', 5, 2)->default(0);
            $table->integer('stock')->default(0);
            $table->integer('low_stock_alert')->default(5);

            // ── Images ────────────────────────────────────
            $table->string('image')->nullable();
            $table->string('image2')->nullable();
            $table->string('image3')->nullable();
            $table->string('image4')->nullable();
            $table->string('image5')->nullable();
            $table->json('gallery_images')->nullable();

            // ── Description ───────────────────────────────
            $table->longText('description')->nullable();
            $table->text('how_to_use')->nullable();
            $table->json('features')->nullable();

            // ── Shipping ──────────────────────────────────
            $table->enum('shipping_type', ['free', 'paid'])->default('paid');
            $table->decimal('shipping_charge', 8, 2)->default(0);
            $table->boolean('cod_available')->default(true);

            // ── SEO ───────────────────────────────────────
            $table->string('meta_title')->nullable();
            $table->string('meta_description')->nullable();
            $table->string('meta_keywords')->nullable();

            // ── Extra Fields (Type wise JSON) ─────────────
            $table->json('extra_fields')->nullable();
            /*
            Beauty example:
            {
              "skin_type": ["Oily","Dry"],
              "concern": ["Acne","Brightening"],
              "key_ingredients": "Vitamin C, Niacinamide",
              "full_ingredients": "...",
              "is_organic": true,
              "is_vegan": false,
              "is_cruelty_free": true,
              "is_paraben_free": false,
              "net_weight": "50ml",
              "shelf_life": "24 months",
              "gender": "Women"
            }

            Clothing example:
            {
              "sizes": ["S","M","L","XL"],
              "colors": ["Red","Blue","Black"],
              "material": "Cotton",
              "gender": "Men",
              "occasion": "Casual"
            }

            Book example:
            {
              "author": "Chetan Bhagat",
              "publisher": "Penguin Books",
              "isbn": "978-XXXXXXXXXX",
              "language": "Hindi",
              "edition": "3rd Edition",
              "pages": 350,
              "book_type": "Paperback",
              "published_date": "2023-01-15"
            }
            */

            // ── Flags ─────────────────────────────────────
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