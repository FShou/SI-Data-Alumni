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
        Schema::create('narahubung', function (Blueprint $table) {
            $table->id();
            $table->string('nama_narahubung', 50);
            // $table->string('email_narahubung', 50)->nullable();
            $table->foreignId('id_angkatan')->nullable();
            $table->foreign('id_angkatan')->references('id')->on('angkatan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('narahubung');
    }
};
