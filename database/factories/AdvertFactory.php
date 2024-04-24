<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Advert>
 */
class AdvertFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'title' => fake()->text(100),
            'text' => fake()->text(),
            'price' => rand(0, 10000),
            'date' => Carbon::now(),
        ];
    }

    public function withPhotos(int $num): AdvertFactory
    {
        return $this->state(function () use ($num) {
            $string = fake()->url();

            while ($num - 1 > 0) {
                $string .= ' ' . fake()->url();
                $num--;
            }

            return ['photos' => $string];
        });
    }
}
