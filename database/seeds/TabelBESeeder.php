<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Product;

class TabelBESeeder extends Seeder
{
    protected $product;
    protected $faker;

    public function __construct(Product $product, Faker $faker)
    {
        $this->product = $product;
        $this->faker = $faker;
    }

    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $a = 1;
        $b = 1;
        $c = 1;
        $d = 1;
        foreach(range(1,50) as $x) {
            $this->product->create([
                'title_product' => 'Product '.$a++,
                'brands'  => 'Brand '.$b++,
                'category'  => 'Category '.$c++,
                'subcategory' => 'Subcateg '.$d++,
                'keterangan' => $this->faker->sentence(20),
            ]);
        }
    }
}
