<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class TuitionCategories extends Model
{
    protected $guarded = array('id');
    protected $table = 'teacher_tuition_categories';
}
