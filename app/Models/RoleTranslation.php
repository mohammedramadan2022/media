<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class RoleTranslation extends Model
{
    public $timestamps = false;

    protected $table = 'role_translations';

    protected $guarded = ['id'];
}
