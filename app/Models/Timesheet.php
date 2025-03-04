<?php

namespace App\Models;

use App\Models\User;
use App\Models\Timesheet;
use Illuminate\Database\Eloquent\Model;

class Timesheet extends Model
{
    protected $fillable = [
        'task_name',
        'date',
        'hours',
        'user_id',
        'project_id'
    ];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function timesheet()
    {
        return $this->belongsTo(Timesheet::class);
    }
}
