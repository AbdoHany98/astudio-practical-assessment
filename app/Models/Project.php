<?php

namespace App\Models;

use Attribute;
use App\Models\User;
use App\Models\Timesheet;
use App\Models\AttributeValue;
use Illuminate\Database\Eloquent\Model;

class Project extends Model
{
    protected $fillable = [
        'name',
        'status'
    ];

    public function users()
    {
        return $this->belongsToMany(User::class);
    }

    public function timesheets()
    {
        return $this->hasMany(Timesheet::class);
    }

    public function attributeValues()
    {
        return $this->hasMany(AttributeValue::class, 'entity_id');
    }
}
