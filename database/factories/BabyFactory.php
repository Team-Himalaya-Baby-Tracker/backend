<?php

namespace Database\Factories;

use App\Models\Baby;
use App\Models\ParentUser;
use Illuminate\Database\Eloquent\Factories\Factory;
use Illuminate\Support\Carbon;

class BabyFactory extends Factory
{
    protected $model = Baby::class;

    public function definition(): array
    {
        return [
            'name' => $this->faker->name(),
            'photo' => $this->faker->word(),
            'gender' => $this->faker->word(),
            'birth_date' => Carbon::now(),
            'created_at' => Carbon::now(),
            'updated_at' => Carbon::now(),
        ];
    }
}
