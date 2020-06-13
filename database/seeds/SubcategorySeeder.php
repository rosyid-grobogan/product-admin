<?php

use Illuminate\Database\Seeder;
use Faker\Generator as Faker;
use App\Models\Subcategory;

class SubcategorySeeder extends Seeder
{
    protected $subcategory;
    protected $faker;

    public function __construct(Subcategory $subcategory, Faker $faker)
    {
        $this->subcategory = $subcategory;
        $this->faker = $faker;
    }    
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $i = 1;
        $j = 1;
        foreach(range(1,20) as $x) {
            $this->subcategory->create([
                'name' => 'Subategory '.$i++,
                'parent' => 'Category '.$j++
            ]);
        }
    }
}
