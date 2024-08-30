<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Post>
 */
class PostFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition()
    {
        return [
            'no' => $this->faker->numberBetween(),
            'tanggal' => $this->faker->dateTime(),
            'judul' => $this->faker->sentence(2),
            'asal' => $this->faker->word(),
            'tujuan' => $this->faker->word(),
            'file' => $this->faker->word(),
        ];
    }
}
