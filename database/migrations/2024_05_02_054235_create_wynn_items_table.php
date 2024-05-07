<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('wynn_items', function (Blueprint $table) {
            $table->id();
            $table->string('internal_name');
            $table->string('name');
            $table->integer('level');
            $table->string('type');
            $table->string('tier');
            $table->string('restrictions')->nullable();
            $table->string('image')->nullable();
            $table->double('percent')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wynn_items');
    }
};
