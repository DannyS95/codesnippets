<?php

namespace Database\Factories;

use App\Models\Step;
use App\Models\Snippet;
use Illuminate\Database\Eloquent\Factories\Factory;

class StepFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = Step::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'uuid' => $this->faker->uuid,
            'snippet_id' => Snippet::factory(),
            'title' => $this->faker->sentence,
            'order' => $this->faker->randomDigit,
            'body' => $this->faker->text(100),
        ];
    }
}
