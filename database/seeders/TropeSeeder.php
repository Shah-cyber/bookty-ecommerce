<?php

namespace Database\Seeders;

use App\Models\Trope;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class TropeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            'Enemies to Lovers',
            'Friends to Lovers',
            'Fake Relationship',
            'Forced Proximity',
            'Marriage of Convenience / Arranged Marriage',
            'Grumpy x Sunshine',
            'Second Chance Romance',
            'Love Triangle',
            'Slow Burn',
            'Opposites Attract',
            'Forbidden Love',
            'Secret Relationship',
            'Unrequited Love',
            'Amnesia / Memory Loss',
            'Workplace Romance',
            'Bodyguard x Client',
            'Single Parent Romance',
            'Love at First Sight',
            'Childhood Sweethearts',
            'Dark Romance',
            'Anti-hero',
            'Forbidden Love', // duplicate on purpose; will be de-duplicated by slug
            'Possessive Alpha Male',
            'Arranged Marriage / Marriage of Convenience',
            'Forced Proximity / Kidnapping Romance',
        ];

        $now = now();

        // De-duplicate by slug and prepare upsert payload
        $bySlug = [];
        foreach ($names as $name) {
            $slug = Str::slug($name);
            // If a duplicate slug appears, prefer the first occurrence
            if (!isset($bySlug[$slug])) {
                $bySlug[$slug] = [
                    'name' => $name,
                    'slug' => $slug,
                    'description' => null,
                    'created_at' => $now,
                    'updated_at' => $now,
                ];
            }
        }

        $data = array_values($bySlug);

        // Upsert by unique slug to avoid duplicates
        Trope::upsert(
            $data,
            ['slug'],
            ['name', 'description', 'updated_at']
        );
    }
}


