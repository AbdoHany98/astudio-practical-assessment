<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Attribute;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AttributeTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('attributes')->truncate();
        Schema::enableForeignKeyConstraints();

        $now = Carbon::now();

        $attributes = [
            [
                'name' => 'Priority',
                'type' => 'select',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Difficulty',
                'type' => 'select',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Due Date',
                'type' => 'date',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Budget',
                'type' => 'number',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Client Notes',
                'type' => 'text',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($attributes as $attribute) {
            Attribute::create($attribute);
        }
    }
}
