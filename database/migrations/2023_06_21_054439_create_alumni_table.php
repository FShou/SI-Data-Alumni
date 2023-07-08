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
            $table->char('nim', 10)->unique();
            $table->char('nisn', 10)->unique();
            $table->string('nama_alumni', 50);
            $table->enum('gender', ['Laki-laki', 'Perempuan'])->nullable();
            $table->enum('perusahaan', ['Negeri', 'Swasta', 'Tidak Bekerja'])->nullable();
            $table->double('ipk', 3, 2)->nullable();
            $table->text('judul_ta')->nullable();
            $table->string('email_alumni', 50)->nullable();
            $table->string('foto')->nullable();
            $table->char('id_prodi', 3)->index();
            $table
                ->foreign('id_prodi')
                ->references('id_prodi')
                ->on('prodi')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->char('id_jurusan', 1);
            $table
                ->foreign('id_jurusan')
                ->references('id_jurusan')
                ->on('jurusan')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('id_angkatan');
            $table
                ->foreign('id_angkatan')
                ->references('id')
                ->on('angkatan')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();
            $table->foreignId('id_user')->nullable();
            $table
                ->foreign('id_user')
                ->references('id')
                ->on('users')
                ->cascadeOnUpdate()
                ->cascadeOnDelete();

            // $table->foreignId("id_narahubung")->nullable();
            // $table->foreign("id_narahubung")->references("id")->on("narahubung");
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
