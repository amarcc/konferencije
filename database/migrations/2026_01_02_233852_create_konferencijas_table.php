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
        Schema::create('konferencija', function (Blueprint $table) {
            $table->id();
            $table->string('ime');
            $table->foreignId('kreator') -> constrained('users') -> cascadeOnDelete();
            $table->integer('br_mjesta');
            $table->foreignId('lokacija') -> constrained('lokacija') -> cascadeOnDelete();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('konferencija');
    }
};
