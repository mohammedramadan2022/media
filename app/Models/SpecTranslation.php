<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SpecTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'spec_translations';

    protected $guarded = ['id'];
}
