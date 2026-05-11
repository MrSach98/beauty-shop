<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->dropColumn(['shade_variants', 'size_variants']);
        });
    }

    public function down()
    {
        Schema::table('products', function (Blueprint $table) {
            $table->json('shade_variants')->nullable()->after('extra_attributes');
            $table->json('size_variants')->nullable()->after('shade_variants');
        });
    }
};