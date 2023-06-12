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
        Schema::create('alumni', function (Blueprint $table) {
            $table->id();
            $table->char("nim",10)->unique();
            $table->string('nama_alumni',50);
            $table->enum('gender',["L","P"])->nullable();
            $table->enum('pekerjaan',["Negri","Swasta","Tidak Bekerja"])->nullable();
            $table->string("email_alumni",50)->nullable();
            $table->string("foto")->nullable();
            $table->foreignId("id_prodi")->index();
            $table->foreign("id_prodi")->references("id")->on("prodi");
            $table->foreignId("id_jurusan");
            $table->foreign("id_jurusan")->references("id")->on("jurusan");
            $table->foreignId("id_angkatan");
            $table->foreign("id_angkatan")->references("id")->on("angkatan");
            $table->foreignId("id_narahubung")->nullable();
            $table->foreign("id_narahubung")->references("id")->on("narahubung");
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('alumni');
    }
};
