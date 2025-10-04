<?php

namespace Database\Seeders;

use App\Models\Genre;
use Illuminate\Database\Seeder;
use Illuminate\Support\Str;

class GenreSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $names = [
            'Romance',
            'Horror',
            'Mystery',
            'Thriller',
            'Suspense',
            'Fantasy',
            'Action',
            'Motivation',
        ];

        $now = now();

        $payload = [];
        foreach ($names as $name) {
            $payload[] = [
                'name' => $name,
                'slug' => Str::slug($name),
                'description' => null,
                'created_at' => $now,
                'updated_at' => $now,
            ];
        }

        // Upsert on slug to avoid duplicates
        Genre::upsert(
            $payload,
            ['slug'],
            ['name', 'description', 'updated_at']
        );
    }
}


