<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class OptionNameTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'option_name_translations';

    protected $guarded = ['id'];
}
