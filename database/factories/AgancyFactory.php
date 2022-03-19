<?php

namespace Database\Factories;

use App\Models\Agancy;
use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Agancy>
 */
class AgancyFactory extends Factory
{

    protected $model = Agancy::class;
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'name'=>$this->faker->title,
            'location'=>$this->faker->text,
        ];
    }
}
