<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Pengajuan>
 */
class PengajuanFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        return [
            'name' => fake()->words(asText:true),
            'description' => fake()->paragraph(),
            'template_doc' => 'template_doc.pdf',
            'pengajuan_doc' => 'pengajuan_doc.pdf',
            'status' => fake()->words(asText:true),
            'artist_id' => 2,
        ];
    }
}
