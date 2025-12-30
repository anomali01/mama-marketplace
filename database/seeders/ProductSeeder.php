<?php

namespace Database\Seeders;

use App\Models\Product;
use App\Models\User;
use App\Models\Category;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $categories = Category::all()->keyBy('name');
        
        // Ambil penjual
        $budi = User::where('email', 'budi@mama.com')->first();
        $ani = User::where('email', 'ani@mama.com')->first();
        $citra = User::where('email', 'citra@mama.com')->first();
        $deni = User::where('email', 'deni@mama.com')->first();

        $products = [
            // Produk Elektronik - Budi
            [
                'name' => 'Laptop ASUS VivoBook 14 Bekas',
                'description' => 'Laptop ASUS VivoBook 14 inch, RAM 8GB, SSD 256GB. Kondisi 90%, baterai masih awet 5-6 jam. Bonus tas laptop dan mouse wireless.',
                'price' => 4500000,
                'stock' => 1,
                'status' => 'verified',
                'seller_id' => $budi->id ?? 1,
                'category_id' => $categories['Elektronik']->id ?? 1,
                'condition' => 'used',
                'location' => 'Gedung A Lt.2',
            ],
            [
                'name' => 'Charger iPhone 20W Original',
                'description' => 'Charger iPhone 20W fast charging original Apple. Baru beli 2 bulan, dijual karena sudah punya 2.',
                'price' => 250000,
                'stock' => 2,
                'status' => 'verified',
                'seller_id' => $budi->id ?? 1,
                'category_id' => $categories['Elektronik']->id ?? 1,
                'condition' => 'used',
                'location' => 'Kantin Pusat',
            ],
            [
                'name' => 'Earphone Samsung AKG Original',
                'description' => 'Earphone Samsung AKG bawaan HP. Masih segel, tidak terpakai. Suara jernih, bass mantap.',
                'price' => 75000,
                'stock' => 5,
                'status' => 'verified',
                'seller_id' => $budi->id ?? 1,
                'category_id' => $categories['Elektronik']->id ?? 1,
                'condition' => 'new',
                'location' => 'Perpustakaan',
            ],
            [
                'name' => 'Keyboard Mechanical Rexus',
                'description' => 'Keyboard mechanical Rexus Daxa M61, switch blue. RGB lighting, kondisi like new. Cocok untuk gaming dan ngetik.',
                'price' => 350000,
                'stock' => 1,
                'status' => 'verified',
                'seller_id' => $budi->id ?? 1,
                'category_id' => $categories['Elektronik']->id ?? 1,
                'condition' => 'used',
                'location' => 'Gedung B Lt.3',
            ],

            // Produk Buku - Ani
            [
                'name' => 'Buku Algoritma dan Pemrograman',
                'description' => 'Buku Algoritma dan Pemrograman karya Rinaldi Munir. Edisi terbaru, kondisi 95%, tidak ada coretan.',
                'price' => 85000,
                'stock' => 3,
                'status' => 'verified',
                'seller_id' => $ani->id ?? 2,
                'category_id' => $categories['Buku & Alat Tulis']->id ?? 2,
                'condition' => 'used',
                'location' => 'Perpustakaan',
            ],
            [
                'name' => 'Kalkulator Scientific Casio fx-991ID',
                'description' => 'Kalkulator Casio fx-991ID PLUS, fungsi lengkap untuk matematika dan statistik. Baterai baru.',
                'price' => 180000,
                'stock' => 2,
                'status' => 'verified',
                'seller_id' => $ani->id ?? 2,
                'category_id' => $categories['Buku & Alat Tulis']->id ?? 2,
                'condition' => 'used',
                'location' => 'Gedung C Lt.1',
            ],
            [
                'name' => 'Novel Laut Bercerita - Leila S Chudori',
                'description' => 'Novel Laut Bercerita karya Leila S. Chudori. Kondisi bagus, sampul masih mulus. Best seller!',
                'price' => 65000,
                'stock' => 1,
                'status' => 'verified',
                'seller_id' => $ani->id ?? 2,
                'category_id' => $categories['Buku & Alat Tulis']->id ?? 2,
                'condition' => 'used',
                'location' => 'Kantin Pusat',
            ],
            [
                'name' => 'Paket Alat Tulis Lengkap',
                'description' => 'Paket ATK: 5 pulpen, 2 pensil mekanik, 1 penghapus, 1 tipex, 1 penggaris. Cocok untuk mahasiswa baru!',
                'price' => 45000,
                'stock' => 10,
                'status' => 'verified',
                'seller_id' => $ani->id ?? 2,
                'category_id' => $categories['Buku & Alat Tulis']->id ?? 2,
                'condition' => 'new',
                'location' => 'Gedung A Lt.1',
            ],

            // Produk Fashion - Citra
            [
                'name' => 'Jaket Hoodie Uniqlo Size L',
                'description' => 'Hoodie Uniqlo warna navy, size L. Bahan tebal dan nyaman. Dicuci 3x saja, kondisi 90%.',
                'price' => 200000,
                'stock' => 1,
                'status' => 'verified',
                'seller_id' => $citra->id ?? 3,
                'category_id' => $categories['Fashion']->id ?? 3,
                'condition' => 'used',
                'location' => 'Gedung D Lt.2',
            ],
            [
                'name' => 'Tas Ransel Bodypack',
                'description' => 'Tas ransel Bodypack 25L, warna hitam. Banyak compartment, cocok untuk kuliah. Ada slot laptop 15 inch.',
                'price' => 280000,
                'stock' => 1,
                'status' => 'verified',
                'seller_id' => $citra->id ?? 3,
                'category_id' => $categories['Fashion']->id ?? 3,
                'condition' => 'used',
                'location' => 'Parkiran Motor',
            ],
            [
                'name' => 'Sepatu Sneakers Ventela Size 42',
                'description' => 'Sepatu Ventela Public Low warna putih, size 42. Baru pakai beberapa kali, kondisi 95%.',
                'price' => 250000,
                'stock' => 1,
                'status' => 'verified',
                'seller_id' => $citra->id ?? 3,
                'category_id' => $categories['Fashion']->id ?? 3,
                'condition' => 'used',
                'location' => 'Gedung E Lt.1',
            ],
            [
                'name' => 'Kemeja Flannel Kotak-kotak',
                'description' => 'Kemeja flannel motif kotak merah-hitam, size M. Bahan lembut, cocok untuk hangout.',
                'price' => 120000,
                'stock' => 2,
                'status' => 'verified',
                'seller_id' => $citra->id ?? 3,
                'category_id' => $categories['Fashion']->id ?? 3,
                'condition' => 'used',
                'location' => 'Kantin Pusat',
            ],

            // Produk Makanan - Deni
            [
                'name' => 'Paket Snack Mahasiswa',
                'description' => 'Paket snack hemat: 5 mie instan, 3 wafer, 2 coklat, 1 kopi sachet. Cocok untuk begadang!',
                'price' => 35000,
                'stock' => 20,
                'status' => 'verified',
                'seller_id' => $deni->id ?? 4,
                'category_id' => $categories['Makanan & Minuman']->id ?? 4,
                'condition' => 'new',
                'location' => 'Kost Blok A',
            ],
            [
                'name' => 'Kopi Arabica Toraja 250gr',
                'description' => 'Kopi Arabica Toraja premium, roasting medium. Fresh roasted minggu ini. Grind sesuai request.',
                'price' => 75000,
                'stock' => 8,
                'status' => 'verified',
                'seller_id' => $deni->id ?? 4,
                'category_id' => $categories['Makanan & Minuman']->id ?? 4,
                'condition' => 'new',
                'location' => 'Kantin Pusat',
            ],
            [
                'name' => 'Brownies Panggang Homemade',
                'description' => 'Brownies panggang homemade, fudgy dan lembut. Toping keju/almond/original. Order H-1.',
                'price' => 45000,
                'stock' => 5,
                'status' => 'verified',
                'seller_id' => $deni->id ?? 4,
                'category_id' => $categories['Makanan & Minuman']->id ?? 4,
                'condition' => 'new',
                'location' => 'Kost Blok B',
            ],
            [
                'name' => 'Air Mineral 600ml Satu Dus',
                'description' => 'Air mineral 600ml isi 24 botol. Harga lebih murah dari minimarket. Antar ke kost!',
                'price' => 48000,
                'stock' => 15,
                'status' => 'verified',
                'seller_id' => $deni->id ?? 4,
                'category_id' => $categories['Makanan & Minuman']->id ?? 4,
                'condition' => 'new',
                'location' => 'Kost Blok A',
            ],

            // Produk tambahan lainnya
            [
                'name' => 'Kipas Angin Portable USB',
                'description' => 'Kipas angin mini portable, charge via USB. 3 speed, baterai tahan 8 jam. Cocok untuk di kost!',
                'price' => 55000,
                'stock' => 7,
                'status' => 'verified',
                'seller_id' => $budi->id ?? 1,
                'category_id' => $categories['Elektronik']->id ?? 1,
                'condition' => 'new',
                'location' => 'Gedung A Lt.1',
            ],
            [
                'name' => 'Kasur Lipat Portable',
                'description' => 'Kasur lipat single bed, praktis untuk kost. Ukuran 80x180cm, tebal 5cm. Mudah dilipat.',
                'price' => 350000,
                'stock' => 2,
                'status' => 'verified',
                'seller_id' => $citra->id ?? 3,
                'category_id' => $categories['Kost & Furniture']->id ?? 5,
                'condition' => 'used',
                'location' => 'Kost Blok C',
            ],
            [
                'name' => 'Jasa Desain Logo dan Banner',
                'description' => 'Jasa desain logo, banner, poster untuk tugas atau event kampus. Include revisi 2x. Pengerjaan 1-3 hari.',
                'price' => 50000,
                'stock' => 99,
                'status' => 'verified',
                'seller_id' => $citra->id ?? 3,
                'category_id' => $categories['Jasa']->id ?? 6,
                'condition' => 'new',
                'location' => 'Online',
            ],
            [
                'name' => 'Raket Badminton Yonex Bekas',
                'description' => 'Raket badminton Yonex Astrox 88D, kondisi 85%. Senar baru ganti. Bonus grip dan tas.',
                'price' => 450000,
                'stock' => 1,
                'status' => 'verified',
                'seller_id' => $deni->id ?? 4,
                'category_id' => $categories['Olahraga']->id ?? 7,
                'condition' => 'used',
                'location' => 'GOR Kampus',
            ],
            
            // ========================================
            // PRODUK PENDING VERIFICATION (untuk testing validator)
            // ========================================
            [
                'name' => 'iPhone 13 Pro Second',
                'description' => 'iPhone 13 Pro 256GB warna Pacific Blue. Kondisi mulus 95%, baterai health 89%. Fullset box lengkap. Garansi iBox masih 3 bulan.',
                'price' => 11500000,
                'stock' => 1,
                'status' => 'pending_verif',
                'seller_id' => $budi->id ?? 1,
                'category_id' => $categories['Elektronik']->id ?? 1,
                'condition' => 'used',
                'location' => 'Gedung C Lt.3',
            ],
            [
                'name' => 'PS5 Digital Edition + 2 Controller',
                'description' => 'PlayStation 5 Digital Edition. Dibeli Januari 2024. Bonus 2 controller DualSense (hitam dan putih). Include kabel HDMI dan power cable original.',
                'price' => 6500000,
                'stock' => 1,
                'status' => 'pending_verif',
                'seller_id' => $deni->id ?? 4,
                'category_id' => $categories['Elektronik']->id ?? 1,
                'condition' => 'used',
                'location' => 'Kost Blok D',
            ],
            [
                'name' => 'Buku Struktur Data dan Algoritma',
                'description' => 'Buku Struktur Data dan Algoritma dalam C++ karya Rinaldi Munir. Kondisi bagus, tidak ada coretan. Cocok untuk mahasiswa TI/SI.',
                'price' => 75000,
                'stock' => 1,
                'status' => 'pending_verif',
                'seller_id' => $ani->id ?? 2,
                'category_id' => $categories['Buku']->id ?? 2,
                'condition' => 'used',
                'location' => 'Perpustakaan',
            ],
            [
                'name' => 'Jaket Kulit Asli Domba',
                'description' => 'Jaket kulit domba asli, warna hitam. Size L. Baru dipakai 3x. Dijual karena kebesaran.',
                'price' => 850000,
                'stock' => 1,
                'status' => 'pending_verif',
                'seller_id' => $citra->id ?? 3,
                'category_id' => $categories['Fashion']->id ?? 3,
                'condition' => 'used',
                'location' => 'Gedung B',
            ],
            [
                'name' => 'Sepatu Nike Air Force 1 Original',
                'description' => 'Nike Air Force 1 Low White Original. Size 42. Baru dipakai beberapa kali, kondisi 95%. Box masih ada.',
                'price' => 950000,
                'stock' => 1,
                'status' => 'pending_verif',
                'seller_id' => $deni->id ?? 4,
                'category_id' => $categories['Fashion']->id ?? 3,
                'condition' => 'used',
                'location' => 'GOR Kampus',
            ],
        ];

        foreach ($products as $product) {
            Product::updateOrCreate(
                [
                    'name' => $product['name'],
                    'seller_id' => $product['seller_id']
                ],
                $product
            );
        }
    }
}
