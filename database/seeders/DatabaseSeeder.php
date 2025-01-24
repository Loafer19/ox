<?php

namespace Database\Seeders;

use App\Models\Status;
use Illuminate\Database\Seeder;

class DatabaseSeeder extends Seeder
{
    public function run(): void
    {
        Status::query()
            ->insert([
                ['name' => 'Pending'],
                ['name' => 'Approved'],
                ['name' => 'Rejected'],
            ]);
    }
}
