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
        Schema::create('borrow_devices', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('borrow_id')->nullable();
            $table->unsignedBigInteger('device_id')->nullable();
            $table->unsignedBigInteger('room_id')->nullable();
            $table->integer('quantity')->nullable();
            $table->date('borrow_date')->nullable();
            $table->date('return_date')->nullable();
            $table->string('lecture_name')->nullable();
            $table->integer('lecture_number')->nullable();
            $table->string('session')->nullable();
            $table->string('lesson_name')->nullable();
            $table->string('image_first')->nullable();
            $table->string('image_last')->nullable();
            $table->integer('status')->default(0)->nullable();
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('borrow_devices');
    }
};