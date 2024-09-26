<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class BookSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $authors = \App\Models\Author::all();

        foreach ($authors as $author) {
            $author->books()->createMany([
                [
                    'title' => 'Book 1' . $author->name,
                    'description' => 'Book 1 description' . $author->name,
                    'publish_date' => \Carbon\Carbon::now(),
                ],
                [
                    'title' => 'Book 2' . $author->name,
                    'description' => 'Book 2 description' . $author->name,
                    'publish_date' => \Carbon\Carbon::now(),
                ],
                [
                    'title' => 'Book 3' . $author->name,
                    'description' => 'Book 3 description' . $author->name,
                    'publish_date' => \Carbon\Carbon::now(),
                ],
                [
                    'title' => 'Book 4' . $author->name,
                    'description' => 'Book 4 description' . $author->name,
                    'publish_date' => \Carbon\Carbon::now(),
                ],
            ]);
        }
    }
}
