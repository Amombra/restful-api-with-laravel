<?php

namespace Database\Factories;

use App\User;

use App\Models\Product;
use App\Models\User as ModelsUser;
use Faker\Generator as Faker ;
use Illuminate\Database\Eloquent\Factories\Factory;

class ProductFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array
     */

   
    public function definition()
    {
        return [
            'name'=>$this->faker->word,
            'detail'=>$this->faker->paragraph,
            'price'=>$this->faker->numberBetWeen(100, 1000),
            'stock'=>$this->faker->randomDigit,
            'discount'=>$this->faker->numberBetWeen(2, 30),
            'user_id'=> function(){
                return ModelsUser::all()->random();}
        ];
    }
}
