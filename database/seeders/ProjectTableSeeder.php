<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Project;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class ProjectTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('project_user')->truncate();
        DB::table('projects')->truncate();
        Schema::enableForeignKeyConstraints();
        $now = Carbon::now();

        $projects = [
            [
                'name' => 'Website Redesign',
                'status' => 'in_progress',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Mobile App Development',
                'status' => 'planning',
                'created_at' => $now,
                'updated_at' => $now,
            ],
            [
                'name' => 'Database Migration',
                'status' => 'not_started',
                'created_at' => $now,
                'updated_at' => $now,
            ],
        ];

        foreach ($projects as $project) {
            $newProject = Project::create($project);
            $users = User::inRandomOrder()->limit(rand(1, 3))->get();
            $pivotData = [];
            foreach ($users as $user) {
                $pivotData[$user->id] = [
                    'created_at' => $now,
                    'updated_at' => $now
                ];
            }
            $newProject->users()->attach($pivotData);
        }
    }
}
