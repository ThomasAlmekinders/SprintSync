<?php

namespace Database\Seeders;

use App\Models\User;
use App\Models\ContactFormSubmission;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        $this->call([
            UserSeeder::class,
            ContactFormSeeder::class,
        ]);
    }
}
