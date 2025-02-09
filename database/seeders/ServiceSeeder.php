<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ServiceSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $services = [
            [
                'name'        => 'Ganti Oli',
                'description' => 'Penggantian oli mesin dengan oli berkualitas tinggi untuk menjaga performa mesin.',
                'price'       => '100000',
                'duration'    => 30, // 30 menit
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Cuci Mobil',
                'description' => 'Pembersihan eksterior dan interior mobil menggunakan peralatan modern.',
                'price'       => '75000',
                'duration'    => 45, // 45 menit
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Tune-Up',
                'description' => 'Penyetelan dan pemeriksaan komprehensif mesin untuk performa optimal.',
                'price'       => '200000',
                'duration'    => 60, // 60 menit
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Perbaikan Rem',
                'description' => 'Pemeriksaan dan perbaikan sistem pengereman untuk keamanan berkendara.',
                'price'       => '150000',
                'duration'    => 60, // 60 menit
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
        ];

        DB::table('services')->insert($services);
    }
}
