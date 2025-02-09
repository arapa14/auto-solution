<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        DB::table('products')->insert([
            [
                'name'        => 'Sparepart Mesin',
                'description' => 'Sparepart mesin berkualitas tinggi untuk mobil Anda.',
                'price'       => 150000,
                'stock'       => 20,
                'category'    => 'Mesin',
                'image'       => 'mesin.jpg', // Pastikan file gambar tersedia di direktori penyimpanan yang sesuai
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            [
                'name'        => 'Sparepart Body',
                'description' => 'Sparepart body mobil untuk perbaikan dan perawatan.',
                'price'       => 250000,
                'stock'       => 15,
                'category'    => 'Body',
                'image'       => 'body.jpg',
                'created_at'  => now(),
                'updated_at'  => now(),
            ],
            // Tambahkan produk lainnya jika diperlukan
        ]);
    }
}
