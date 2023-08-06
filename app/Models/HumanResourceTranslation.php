<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class HumanResourceTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'human_resource_translations';

    protected $guarded = ['id'];
}
