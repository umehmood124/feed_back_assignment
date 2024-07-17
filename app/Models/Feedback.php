<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Feedback extends Model
{
    protected $table = 'feedbacks';
    protected $fillable = ['user_id', 'feedback_category_id', 'title', 'description'];

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function feedbackCategory()
    {
        return $this->belongsTo(FeedbackCategory::class, 'feedback_category_id');
    }
    public function comments()
    {
        return $this->hasMany(Comment::class);
    }
}
