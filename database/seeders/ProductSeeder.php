<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Product;


class ProductSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $products = Product::all();

        // Loop through each product
        foreach ($products as $product) {
            // Check if price_a is available and greater than 0
            if ($product->new_price != null) {
                $product->product_category_type = 'new_sale_price';
            } elseif($product->refurnished_price != null) {
                $product->product_category_type = 'refurbished_sale_price';
            }

            // Save the updated product
            $product->save();
        }
    }
}
