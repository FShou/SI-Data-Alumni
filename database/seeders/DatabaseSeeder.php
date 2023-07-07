<?php

namespace Database\Seeders;

// use Illuminate\Database\Console\Seeds\WithoutModelEvents;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Spatie\Permission\Models\Role;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     */
    public function run(): void
    {
        // \App\Models\User::factory(10)->create();


        $user = \App\Models\User::factory()->create([
            'name' => 'Admin',
            'email' => 'admin@admin.com',
            'password' => '123'
        ]);
        $admin = Role::create(['name'=>'Admin']);
        Role::create(['name'=>'Alumni']);
        $user->assignRole($admin);

        $jurusan = [
            'A' => 'Teknik Sipil dan Kebumian',
            'B' => 'Teknik Mesin',
            'C' => 'Teknik Elektro',
            'D' => 'Akuntansi',
            'E' => 'Administrasi Bisnis',
        ];
        $prodi = [
            'A01' => 'Teknik Sipil',
            'A02' => 'Teknik Pertambangan',
            'A03' => 'Teknik Geodesi',
            'A04' => 'Teknik Bangunan Rawa',
            'A05' => 'Teknologi Rekayasa Konstruksi Jalan dan Jembatan',
            'A06' => 'Teknologi Rekayasa Geomatika & Survei',
            'B01' => 'Teknik Mesin',
            'B02' => 'Teknik Mesin Otomotif',
            'B03' => 'Alat Berat',
            'B04' => 'Teknologi Rekayasa Otomotif',
            'C01' => 'Teknik Listrik',
            'C02' => 'Elektronika',
            'C03' => 'Teknik Informatika',
            'C04' => 'Teknologi Rekayasa Pembangkit Energi',
            'C05' => 'Sistem Informasi Kota Cerdas',
            'C06' => 'Teknologi Rekayasa Otomasi',
            'D01' => 'Akuntansi',
            'D02' => 'Komputerisasi Akuntansi',
            'D03' => 'Akuntansi Lembaga Keuangan Syariah',
            'E01' => 'Administrasi Bisnis',
            'E02' => 'Manajemen Informatika',
            'E03' => 'Bisnis Digital'
        ];
        foreach ($jurusan as $k => $v){
            DB::table('jurusan')->insert([
                'id_jurusan' => $k,
                'nama_jurusan' => $v
            ]);
        }
        foreach ($prodi as $k => $v){
            DB::table('prodi')->insert([
                'id_prodi' => $k,
                'nama_prodi' => $v,
                'id_jurusan' => $k[0]
            ]);
        }
        for($angkatan = 2000; $angkatan < 2024; $angkatan++){
            DB::table('angkatan')->insert([
                'tahun_angkatan' => $angkatan,
            ]);
        }
    }
}
