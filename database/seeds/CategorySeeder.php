<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
// use App\Models\Category;

class CategorySeeder extends Seeder
{
    // protected $category;
    // protected $faker;

    // public function __construct(Category $category, Faker $faker)
    // {
    //     $this->category = $category;
    //     $this->faker = $faker;
    // }
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        // $i = 1;
        // foreach(range(1,20) as $x) {
        //     $this->category->create([
        //         'name' => 'Category '.$i++,
        //         'parent_id' => null
        //     ]);
        // }
        factory(App\Models\Category::class, 3)->create();
    }
}
