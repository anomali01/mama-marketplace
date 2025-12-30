<?php

namespace Database\Seeders;

use App\Models\Category;
use Illuminate\Database\Seeder;

class CategorySeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = [
            [
                'name' => 'Elektronik',
                'description' => 'Laptop, HP, Charger, Earphone, dll',
                'icon' => '💻',
            ],
            [
                'name' => 'Buku & Alat Tulis',
                'description' => 'Buku kuliah, novel, ATK, dll',
                'icon' => '📚',
            ],
            [
                'name' => 'Fashion',
                'description' => 'Pakaian, tas, sepatu, aksesoris',
                'icon' => '👕',
            ],
            [
                'name' => 'Makanan & Minuman',
                'description' => 'Snack, minuman, makanan ringan',
                'icon' => '🍔',
            ],
            [
                'name' => 'Kost & Furniture',
                'description' => 'Perabotan kost, kasur, meja, kursi',
                'icon' => '🛋️',
            ],
            [
                'name' => 'Jasa',
                'description' => 'Jasa ketik, desain, programming, dll',
                'icon' => '🛠️',
            ],
            [
                'name' => 'Olahraga',
                'description' => 'Alat olahraga, jersey, sepatu sport',
                'icon' => '⚽',
            ],
            [
                'name' => 'Kecantikan',
                'description' => 'Skincare, makeup, parfum',
                'icon' => '💄',
            ],
            [
                'name' => 'Kendaraan',
                'description' => 'Motor, sepeda, helm, aksesoris',
                'icon' => '🏍️',
            ],
            [
                'name' => 'Lainnya',
                'description' => 'Barang lain yang tidak masuk kategori',
                'icon' => '📦',
            ],
        ];

        foreach ($categories as $category) {
            Category::updateOrCreate(
                ['name' => $category['name']],
                $category
            );
        }
    }
}
