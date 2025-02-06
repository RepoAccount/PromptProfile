<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('character_world', function (Blueprint $table) {
            $table->foreignId('character_id')->constrained()->onDelete('cascade');
            $table->foreignId('world_id')->constrained()->onDelete('cascade');
            $table->primary(['character_id', 'world_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('character_world');
    }
};
