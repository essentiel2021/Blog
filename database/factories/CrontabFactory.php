<?php

namespace Database\Factories;

use App\Models\Crontab;
use Illuminate\Database\Eloquent\Factories\Factory;

class CrontabFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Crontab::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            //
            'nom'=> $this->faker->name(),
            'description'=>$this->faker->sentence(10)
        ];
    }
}
