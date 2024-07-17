<?php

namespace App\Http\Controllers;

use Illuminate\Database\QueryException;
use Illuminate\Http\Request;
use App\Models\Feedback;
use App\Models\Comment;

class CommentController extends Controller
{
    public function insert_comment(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'comment_text' => 'required|string',
                'feedback_id' => 'required|exists:feedbacks,id',
                // Optionally, you can add validation for the user_id if it's coming from the authenticated user
            ]);

            $comment = new Comment([
                'comment_text' => $validatedData['comment_text'],
                'feedback_id' => $validatedData['feedback_id'],
                'user_id' => auth()->user()->id,
            ]);

            $comment->save();
            $feedbacks = Feedback::with('user', 'feedbackCategory', 'comments')->paginate(5);
            return response()->json(['message' => 'success', 'data' => $feedbacks], 201);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }
}
