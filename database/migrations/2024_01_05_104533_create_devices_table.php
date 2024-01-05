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
        Schema::create('devices', function (Blueprint $table) {
            $table->id();
            $table->string('name', 255)->nullable();
            $table->unsignedBigInteger('device_type_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->string('country_name', 50)->nullable();
            $table->string('year', 50)->nullable();
            $table->string('unit', 50)->nullable();
            $table->string('price', 50)->nullable();
            $table->text('note')->nullable();
            $table->string('image')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->timestamps();
            $table->softDeletes();
            $table->bigInteger('classify_id')->default(0)->nullable();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('devices');
    }
};