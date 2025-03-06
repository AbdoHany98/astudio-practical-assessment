<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Project;
use App\Models\Timesheet;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class TimesheetTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('timesheets')->truncate();
        Schema::enableForeignKeyConstraints();

        $users = User::all();
        $projects = Project::all();
        $now = Carbon::now();
        
        for ($i = 0; $i < 50; $i++) {
            $user = $users->random();
            $project = $projects->random();
            
            if (!$user->projects->contains($project)) {
                $user->projects()->attach([$project->id => [
                    'created_at' => $now,
                    'updated_at' => $now
                ]]);
            }
            
            $date = date('Y-m-d', strtotime('-' . rand(0, 30) . ' days'));
            
            $hours = rand(1, 8);
            
            Timesheet::create([
                'user_id' => $user->id,
                'project_id' => $project->id,
                'date' => $date,
                'hours' => $hours,
                'name' => 'Worked on ' . $project->name . ' - ' . $this->getRandomTask(),
                'created_at' => $now,
                'updated_at' => $now,
            ]);
        }
    }
    
    private function getRandomTask(): string
    {
        $tasks = [
            'Design implementation',
            'Frontend development',
            'Backend integration',
            'Bug fixing',
            'Client meeting',
            'Documentation',
            'Code review',
            'Testing',
            'Deployment preparation',
            'Research',
        ];
        
        return $tasks[array_rand($tasks)];
    }
}
