<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class InstitutePreferences extends Model
{
    protected $guarded = array('id');
    protected $table = 'teacher_institute_preferences';
}
