<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\Snippet;

class SnippetSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Snippet::factory()
            ->count(10)
            ->create();
    }
}
