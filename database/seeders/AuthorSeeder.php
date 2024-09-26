<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AuthorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        collect([
            [
                'name' => 'John Doe',
                'bio' => 'John Doe is a writer who has written many books.',
                'birth_date' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'Jane Doe',
                'bio' => 'Jane Doe is a writer who has written many books.',
                'birth_date' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'John Smith',
                'bio' => 'John Smith is a writer who has written many books.',
                'birth_date' => \Carbon\Carbon::now(),
            ],
            [
                'name' => 'Jane Smith',
                'bio' => 'Jane Smith is a writer who has written many books.',
                'birth_date' => \Carbon\Carbon::now(),
            ]
        ])->each(function ($author) {
            \App\Models\Author::create($author);
        });
    }
}
