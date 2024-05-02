<?php

namespace Database\Factories;

use Illuminate\Database\Eloquent\Factories\Factory;

/**
 * @extends \Illuminate\Database\Eloquent\Factories\Factory<\App\Models\WynnItem>
 */
class WynnItemFactory extends Factory
{

    static $tiers = [
        'normal',
        'set',
        'unique',
        'rare',
        'legendary',
        'fabled',
        'mythic'
    ];

    static $types = [
        'helmet',
        'chestplate',
        'leggings',
        'boots',
        'necklace',
        'bracelet',
        'ring',
        'wand',
        'dagger',
        'bow',
        'spear',
        'relik',
    ];

    /**
     * Define the model's default state.
     *
     * @return array<string, mixed>
     */
    public function definition(): array
    {

        return [
            'internal_name' => fake()->word(),
            'name' => fake()->word(),
            'level' => rand(1, 104),
            'type' => self::$types[array_rand(self::$types)],
            'tier' => self::$tiers[array_rand(self::$tiers)],
        ];
    }
}
