<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class SubjectTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'subject_translations';

    protected $guarded = ['id'];
}
