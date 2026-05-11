<?php
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up()
    {
        Schema::create('product_types', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->string('slug')->unique();
            $table->string('icon')->nullable();
            $table->json('tabs')->nullable();
            // tabs example: ["clothing"] ya ["mobile","electronic"]
            // ye tabs product form me show honge jab ye type select ho
            $table->boolean('status')->default(false);
            // status=1 tab hi product form me dikhega
            $table->integer('sort_order')->default(0);
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('product_types');
    }
};