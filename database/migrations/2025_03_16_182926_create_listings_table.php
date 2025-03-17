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
        Schema::create('listings', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->text('description');
            $table->enum('category', ['apartment', 'car', 'land']);
            $table->enum('type', ['sale', 'rent']);
            $table->double('price');
            $table->enum('status', ['available', 'sold', 'rented', 'pending'])->default('available');
            $table->unsignedBigInteger('listable_id')->nullable();
            $table->string('listable_type')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('listings');
    }
};
