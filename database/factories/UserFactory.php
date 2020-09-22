<?php

namespace Database\Factories;

use App\Models\User;
use Illuminate\Database\Eloquent\Factories\Factory;

class UserFactory extends Factory
{
    /**
     * The name of the factory's corresponding model.
     *
     * @var string
     */
    protected $model = User::class;

    /**
     * Define the model's default state.
     *
     * @return array
     */
    public function definition()
    {
        return [
            'title' => 'Mr',
            'name' => 'Al Imran Ahmed',
            'username' => 'imran',
            'email' => $this->faker->email,
            'password' => bcrypt('secret'),
            'token' => null,
        ];
    }
}
