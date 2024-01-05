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
        Schema::create('assets', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100)->nullable();
            $table->string('country', 255)->nullable();
            $table->string('year', 255)->nullable();
            $table->integer('quantity')->nullable();
            $table->string('unit', 255)->nullable();
            $table->string('price', 255)->nullable();
            $table->string('note', 255)->nullable();
            $table->string('image', 255)->nullable();
            $table->unsignedBigInteger('device_type_id')->nullable();
            $table->unsignedBigInteger('department_id')->nullable();
            $table->softDeletes();
            $table->timestamps();
            $table->unsignedBigInteger('classify_id')->default(0)->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('assets');
    }
};