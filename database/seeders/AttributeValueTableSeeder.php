<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Project;
use App\Models\Attribute;
use App\Models\AttributeValue;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;

class AttributeValueTableSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Schema::disableForeignKeyConstraints();
        DB::table('attribute_values')->truncate();
        Schema::enableForeignKeyConstraints();

        $now = Carbon::now();

        $selectOptions = [
            'Priority' => ['High', 'Medium', 'Low'],
            'Difficulty' => ['Easy', 'Medium', 'Hard']
        ];
        $projects = Project::all();
        $attributes = Attribute::all();

        foreach ($projects as $project) {
            foreach ($attributes as $attribute) {
                $value = null;
                
                switch ($attribute->type) {
                    case 'select':
                        $options = $selectOptions[$attribute->name];
                        $value = $options[array_rand($options)];
                        break;
                    case 'date':
                        $startDate = strtotime('now');
                        $endDate = strtotime('+3 months');
                        $randomTimestamp = mt_rand($startDate, $endDate);
                        $value = date('Y-m-d', $randomTimestamp);
                        break;
                    case 'number':
                        $value = rand(1000, 50000);
                        break;
                    case 'text':
                        $value = 'Sample text for ' . $attribute->name . ' on project ' . $project->name;
                        break;
                }
                
                AttributeValue::create([
                    'attribute_id' => $attribute->id,
                    'entity_id' => $project->id,
                    'value' => $value,
                    'created_at' => $now,
                    'updated_at' => $now,
                ]);
            }
        }
    }
}
