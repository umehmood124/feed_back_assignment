<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Feedback;

class FeedbackController extends Controller
{
    public function submit_feedback(Request $request)
    {
        try {
            $validatedData = $request->validate([
                'title' => 'required|string',
                'category' => 'required|integer',
                'feedbackContent' => 'required|string',
            ]);

            $feedback = Feedback::create([
                'user_id' => auth()->user()->id,
                'title' => $validatedData['title'],
                'feedback_category_id' => $validatedData['category'],
                'description' => $validatedData['feedbackContent'],
            ]);
            $feedbacks = Feedback::with('user', 'feedbackCategory', 'comments')
                ->orderBy('id', 'desc')
                ->paginate(5);
            return response()->json(['message' => 'success', 'data' => $feedbacks]);
        } catch (\Exception $e) {
            return response()->json(['message' => $e->getMessage()], 500);
        }
    }

    public function get_feedback()
    {
        $feedbacks = Feedback::with('user', 'feedbackCategory', 'comments')
            ->orderBy('id', 'desc')
            ->paginate(5);
        return response()->json($feedbacks);
    }
}
