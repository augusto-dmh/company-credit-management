<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Empresa>
 */
class EmpresaFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $icmsPago = $this->faker->randomFloat(2, 10000, 10000000);
        $creditoPossivel = $this->faker->randomFloat(2, 0, $icmsPago * 0.5);

        return [
            'nome' => $this->faker->company(),
            'cnpj' => $this->faker->numerify('##############'),
            'icms_pago' => $icmsPago,
            'credito_possivel' => $creditoPossivel,
        ];
    }
}
