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
        Schema::create('prodi', function (Blueprint $table) {
            $table->char('id_prodi', 3);
            $table->primary('id_prodi');
            $table->string('nama_prodi', 50);
            $table->char('id_jurusan',1);
            $table
                ->foreign('id_jurusan')
                ->references('id_jurusan')
                ->on('jurusan');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('program_studi');
    }
};
