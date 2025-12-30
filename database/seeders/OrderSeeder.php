<?php

namespace Database\Seeders;

use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Product;
use App\Models\User;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class OrderSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Ambil pembeli
        $testUser = User::where('email', 'test@mama.com')->first();
        $eka = User::where('email', 'eka@mama.com')->first();
        $fajar = User::where('email', 'fajar@mama.com')->first();

        // Ambil beberapa produk
        $products = Product::all();

        if ($products->isEmpty() || !$testUser) {
            return;
        }

        // Order 1 - Test User beli dari Budi (Elektronik) - Selesai
        $order1 = Order::create([
            'order_code' => 'ORD-' . strtoupper(Str::random(8)),
            'buyer_id' => $testUser->id,
            'total_amount' => 325000,
            'status' => 'delivered',
            'shipping_address' => 'Kost Blok A No. 15, Jl. Kampus Raya',
            'payment_method' => 'transfer',
            'created_at' => now()->subDays(7),
            'updated_at' => now()->subDays(5),
        ]);

        // Item untuk Order 1
        $charger = $products->where('name', 'Charger iPhone 20W Original')->first();
        $earphone = $products->where('name', 'Earphone Samsung AKG Original')->first();
        
        if ($charger) {
            OrderItem::create([
                'order_id' => $order1->id,
                'product_id' => $charger->id,
                'quantity' => 1,
                'price_at_order' => 250000,
            ]);
        }
        if ($earphone) {
            OrderItem::create([
                'order_id' => $order1->id,
                'product_id' => $earphone->id,
                'quantity' => 1,
                'price_at_order' => 75000,
            ]);
        }

        // Order 2 - Test User beli dari Ani (Buku) - Sedang dikirim
        $order2 = Order::create([
            'order_code' => 'ORD-' . strtoupper(Str::random(8)),
            'buyer_id' => $testUser->id,
            'total_amount' => 150000,
            'status' => 'shipped',
            'shipping_address' => 'Kost Blok A No. 15, Jl. Kampus Raya',
            'payment_method' => 'cod',
            'created_at' => now()->subDays(2),
            'updated_at' => now()->subDays(1),
        ]);

        $buku = $products->where('name', 'Buku Algoritma dan Pemrograman')->first();
        $novel = $products->where('name', 'Novel Laut Bercerita - Leila S Chudori')->first();
        
        if ($buku) {
            OrderItem::create([
                'order_id' => $order2->id,
                'product_id' => $buku->id,
                'quantity' => 1,
                'price_at_order' => 85000,
            ]);
        }
        if ($novel) {
            OrderItem::create([
                'order_id' => $order2->id,
                'product_id' => $novel->id,
                'quantity' => 1,
                'price_at_order' => 65000,
            ]);
        }

        // Order 3 - Eka beli dari Citra (Fashion) - Selesai
        if ($eka) {
            $order3 = Order::create([
                'order_code' => 'ORD-' . strtoupper(Str::random(8)),
                'buyer_id' => $eka->id,
                'total_amount' => 480000,
                'status' => 'delivered',
                'shipping_address' => 'Kost Putri Blok C No. 8',
                'payment_method' => 'transfer',
                'created_at' => now()->subDays(10),
                'updated_at' => now()->subDays(8),
            ]);

            $hoodie = $products->where('name', 'Jaket Hoodie Uniqlo Size L')->first();
            $tas = $products->where('name', 'Tas Ransel Bodypack')->first();
            
            if ($hoodie) {
                OrderItem::create([
                    'order_id' => $order3->id,
                    'product_id' => $hoodie->id,
                    'quantity' => 1,
                    'price_at_order' => 200000,
                ]);
            }
            if ($tas) {
                OrderItem::create([
                    'order_id' => $order3->id,
                    'product_id' => $tas->id,
                    'quantity' => 1,
                    'price_at_order' => 280000,
                ]);
            }
        }

        // Order 4 - Fajar beli dari Deni (Makanan) - Sudah bayar
        if ($fajar) {
            $order4 = Order::create([
                'order_code' => 'ORD-' . strtoupper(Str::random(8)),
                'buyer_id' => $fajar->id,
                'total_amount' => 115000,
                'status' => 'paid',
                'shipping_address' => 'Kost Putra Blok B No. 22',
                'payment_method' => 'ewallet',
                'created_at' => now()->subDay(),
                'updated_at' => now(),
            ]);

            $snack = $products->where('name', 'Paket Snack Mahasiswa')->first();
            $brownies = $products->where('name', 'Brownies Panggang Homemade')->first();
            
            if ($snack) {
                OrderItem::create([
                    'order_id' => $order4->id,
                    'product_id' => $snack->id,
                    'quantity' => 2,
                    'price_at_order' => 35000,
                ]);
            }
            if ($brownies) {
                OrderItem::create([
                    'order_id' => $order4->id,
                    'product_id' => $brownies->id,
                    'quantity' => 1,
                    'price_at_order' => 45000,
                ]);
            }
        }

        // Order 5 - Test User beli dari Deni - Pending
        $order5 = Order::create([
            'order_code' => 'ORD-' . strtoupper(Str::random(8)),
            'buyer_id' => $testUser->id,
            'total_amount' => 75000,
            'status' => 'pending',
            'shipping_address' => 'Kost Blok A No. 15, Jl. Kampus Raya',
            'payment_method' => 'transfer',
            'created_at' => now(),
            'updated_at' => now(),
        ]);

        $kopi = $products->where('name', 'Kopi Arabica Toraja 250gr')->first();
        if ($kopi) {
            OrderItem::create([
                'order_id' => $order5->id,
                'product_id' => $kopi->id,
                'quantity' => 1,
                'price_at_order' => 75000,
            ]);
        }
    }
}
