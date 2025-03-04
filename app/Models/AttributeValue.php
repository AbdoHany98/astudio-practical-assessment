<?php

namespace App\Models;

use App\Models\Attribute;
use Illuminate\Database\Eloquent\Model;

class AttributeValue extends Model
{
    protected $fillable = [
        'attribute_id',
        'entity_id',
        'value'
    ];

    public function attribute()
    {
        return $this->belongsTo(Attribute::class);
    }
}
