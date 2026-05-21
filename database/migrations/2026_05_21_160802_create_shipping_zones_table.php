// create_shipping_zones_table
<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('shipping_zones', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->json('states')->nullable();
            $table->decimal('base_charge', 8, 2)->default(0);
            $table->decimal('free_above', 10, 2)->nullable();
            $table->boolean('cod_available')->default(true);
            $table->decimal('cod_charge', 8, 2)->default(0);
            $table->boolean('status')->default(true);
            $table->timestamps();
        });
    }
    public function down() { Schema::dropIfExists('shipping_zones'); }
};