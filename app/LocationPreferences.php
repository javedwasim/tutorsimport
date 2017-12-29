<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class LocationPreferences extends Model
{
    protected $guarded = array('id');
    protected $table = 'teacher_location_preferences';
}
