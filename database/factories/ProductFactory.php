<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;
use App\Traits\FakerCategory;

class ProductFactory extends Factory
{
    use FakerCategory;

    public function definition(): array
    {  
        $this->initFaker();
        $closure = $this->states[3];
        $state = $closure();
        $categoryId = $state['category_id'] ?? null;
        
        if ($categoryId) {
            return [
                'name' => $this->getName(self::CATEGORIES[$categoryId-1]),
                'price' => $this->faker2->randomFloat(2, 1, 1000),
                'in_stock' => $this->faker2->boolean(),
                'rating' => random_int(1, 5)
            ];
        }
    }

    public function getName($categoryProducts) {
        return $this->faker2->$categoryProducts().' model '.random_int(1, 999);
    }
}