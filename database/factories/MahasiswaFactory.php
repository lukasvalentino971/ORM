<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Mahasiswa>
 */
class MahasiswaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'nim' => fake()->numerify('2141720###'),
            'nama' => fake()->name(),
            'kelas' => fake()->regexify('TI-2[A-I]{1}'),
            'jurusan' => 'Teknologi Informasi',
            'no_hp' => fake()->numerify('62895395000###'),
            'email' => fake()->unique()->safeEmail(),
            'tgl_lahir' => fake()->date(),
        ];
    }
}