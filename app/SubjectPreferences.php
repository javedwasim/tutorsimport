<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class SubjectPreferences extends Model
{
    protected $guarded = array('id');
    protected $table = 'teacher_subject_preferences';

}
