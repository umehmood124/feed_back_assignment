<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;

class FeedbackCategory extends Model
{
    protected $fillable = ['name'];

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }
}

