<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\Car>
 */
class CarFactory extends Factory
{
    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {
        $brands = ['Toyota', 'Honda', 'Ford', 'BMW', 'Mercedes', 'Audi', 'Tesla', 'Volkswagen', 'Nissan', 'Hyundai'];
        $models = [
            'Toyota' => ['Camry', 'Corolla', 'RAV4', 'Highlander'],
            'Honda' => ['Civic', 'Accord', 'CR-V', 'Pilot'],
            'Ford' => ['F-150', 'Mustang', 'Explorer', 'Escape'],
            'BMW' => ['3 Series', '5 Series', 'X3', 'X5'],
            'Mercedes' => ['C-Class', 'E-Class', 'GLC', 'GLE'],
            'Audi' => ['A4', 'A6', 'Q5', 'Q7'],
            'Tesla' => ['Model 3', 'Model Y', 'Model S', 'Model X'],
            'Volkswagen' => ['Golf', 'Jetta', 'Tiguan', 'Atlas'],
            'Nissan' => ['Altima', 'Rogue', 'Sentra', 'Pathfinder'],
            'Hyundai' => ['Elantra', 'Sonata', 'Tucson', 'Santa Fe']
        ];

        $brand = $this->faker->randomElement($brands);
        $model = $this->faker->randomElement($models[$brand] ?? ['Generic Model']);

        $condition = $this->faker->randomElement(['new', 'used']);
        
        return [
            'brand' => $brand,
            'model' => $model,
            'year' => $this->faker->numberBetween(2015, 2025),
            'price' => $this->faker->randomFloat(0, 15000, 150000),
            'image' => 'https://placehold.co/600x400?text=' . urlencode($brand . ' ' . $model),
            'images' => null,
            'description' => $this->faker->paragraph(3),
            'condition' => $condition,
            'mileage' => $condition === 'new' ? 0 : $this->faker->numberBetween(5000, 200000),
            'transmission' => $this->faker->randomElement(['automatic', 'manual']),
            'fuel_type' => $this->faker->randomElement(['petrol', 'diesel', 'electric', 'hybrid']),
            'category' => $this->faker->randomElement(['SUV', 'Sedan', 'Hatchback', 'Coupe', 'Convertible', 'Truck']),
            'performance' => $this->faker->numberBetween(100, 500),
            'consumption' => $this->faker->randomFloat(1, 5, 15),
            'number_of_seats' => $this->faker->randomElement([2, 4, 5, 7]),
            'color' => $this->faker->safeColorName,
        ];
    }
}
