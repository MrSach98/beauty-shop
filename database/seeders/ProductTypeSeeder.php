<?php
namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\ProductType;

class ProductTypeSeeder extends Seeder
{
    public function run()
    {
        $types = [
            [
                'name'       => 'Beauty & Cosmetics',
                'slug'       => 'beauty',
                'icon'       => '💄',
                'tabs'       => ['beauty'],
                'status'     => true,
                'sort_order' => 1,
            ],
            [
                'name'       => 'Clothing & Fashion',
                'slug'       => 'clothing',
                'icon'       => '👗',
                'tabs'       => ['clothing'],
                'status'     => true,
                'sort_order' => 2,
            ],
            [
                'name'       => 'Books & Stationery',
                'slug'       => 'book',
                'icon'       => '📚',
                'tabs'       => ['book'],
                'status'     => true,
                'sort_order' => 3,
            ],
            [
                'name'       => 'Electronics',
                'slug'       => 'electronic',
                'icon'       => '💻',
                'tabs'       => ['electronic'],
                'status'     => true,
                'sort_order' => 4,
            ],
            [
                'name'       => 'Mobile & Accessories',
                'slug'       => 'mobile',
                'icon'       => '📱',
                'tabs'       => ['mobile', 'electronic'],
                'status'     => true,
                'sort_order' => 5,
            ],
            [
                'name'       => 'Jewelry',
                'slug'       => 'jewelry',
                'icon'       => '💍',
                'tabs'       => ['jewelry'],
                'status'     => true,
                'sort_order' => 6,
            ],
            [
                'name'       => 'Grocery & Food',
                'slug'       => 'grocery',
                'icon'       => '🛒',
                'tabs'       => ['grocery'],
                'status'     => true,
                'sort_order' => 7,
            ],
            [
                'name'       => 'Furniture & Home',
                'slug'       => 'furniture',
                'icon'       => '🪑',
                'tabs'       => ['furniture'],
                'status'     => false,
                'sort_order' => 8,
            ],
            [
                'name'       => 'Sports & Fitness',
                'slug'       => 'sports',
                'icon'       => '⚽',
                'tabs'       => ['sports'],
                'status'     => false,
                'sort_order' => 9,
            ],
            [
                'name'       => 'Baby Products',
                'slug'       => 'baby',
                'icon'       => '🍼',
                'tabs'       => ['baby'],
                'status'     => true,
                'sort_order' => 10,
            ],
            [
                'name'       => 'Pet Products',
                'slug'       => 'pet',
                'icon'       => '🐾',
                'tabs'       => ['pet'],
                'status'     => true,
                'sort_order' => 11,
            ],
            [
                'name'       => 'Medical & Pharmacy',
                'slug'       => 'medical',
                'icon'       => '💊',
                'tabs'       => ['medical'],
                'status'     => true,
                'sort_order' => 12,
            ],
        ];

        foreach ($types as $type) {
            ProductType::updateOrCreate(
                ['slug' => $type['slug']],
                $type
            );
        }

        $this->command->info('✅ 12 Product Types seeded!');
    }
}