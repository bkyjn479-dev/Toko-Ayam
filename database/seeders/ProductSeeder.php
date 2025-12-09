<?php

namespace Database\Seeders;

use App\Models\Product;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $products = [
            [
                'name' => 'Ayam Matang Kampung',
                'description' => 'Ayam kampung matang siap santap, diolah dengan resep tradisional dan bumbu pilihan. Siap disajikan atau dikirimkan untuk langsung disantap.',
                'price' => 65000,
                'stock' => 50,
                'unit' => 'kg',
                'image' => 'products/ayam-kampung.jpg',
            ],
            [
                'name' => 'Paket Ayam Keluarga',
                'description' => 'Paket ayam matang siap santap untuk keluarga. Berisi 2 porsi ayam matang yang dapat langsung dinikmati bersama keluarga.',
                'price' => 190000,
                'stock' => 30,
                'unit' => 'pack',
                'image' => 'products/paket-keluarga.jpg',
            ],
            [
                'name' => 'Ayam Utuh Matang Premium',
                'description' => 'Ayam utuh matang premium, sudah dimasak dan diberi bumbu. Siap disajikan langsung untuk hidangan keluarga atau acara.',
                'price' => 75000,
                'stock' => 40,
                'unit' => 'kg',
                'image' => 'products/ayam-potong.jpg',
            ],
            [
                'name' => 'Fillet Ayam Matang',
                'description' => 'Fillet ayam matang tanpa tulang dan kulit, sudah siap santap. Cocok untuk hidangan siap saji, panggang, atau goreng ulang.',
                'price' => 85000,
                'stock' => 25,
                'unit' => 'kg',
                'image' => 'products/fillet-ayam.jpg',
            ],
            [
                'name' => 'Paket Matang Beku (Frozen)',
                'description' => 'Ayam matang beku siap panaskan, tahan lama hingga 3 bulan di freezer. Praktis dan siap disantap setelah dipanaskan.',
                'price' => 55000,
                'stock' => 100,
                'unit' => 'kg',
                'image' => 'products/ayam-frozen.jpg',
            ],
            [
                'name' => 'Ayam Utuh Matang',
                'description' => 'Ayam utuh matang yang sudah dibumbui dan siap disajikan. Cocok untuk acara atau konsumsi keluarga.',
                'price' => 70000,
                'stock' => 35,
                'unit' => 'kg',
                'image' => 'products/karkas-ayam.jpg',
            ],
        ];

        foreach ($products as $product) {
            Product::firstOrCreate(
                ['name' => $product['name']],
                $product
            );
        }

        $this->command->info('Sample products created successfully!');
    }
}
