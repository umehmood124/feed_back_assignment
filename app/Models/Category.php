<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class Category extends Model
{
    protected $table = 'feedback_categories';

    protected $fillable = [
        'name',
    ];

}
