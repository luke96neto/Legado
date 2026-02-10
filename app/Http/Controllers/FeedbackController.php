<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Feedback;
use App\Models\Project;

class FeedbackController extends Controller
{
    public function store(Request $request, $id)
    {
        $project = Project::where('id', $id)->firstOrFail();

        $request->validate([
            'rating' => ['required', 'integer', 'min:1', 'max:5'],
        ]);

        $userId = Auth::id();

        if ($project->hasUserRated($userId)) {
            return response()->json([
                'success' => false,
                'error' => 'Você já avaliou este projeto.'
            ], 422);
        }

        Feedback::create([
            'project_id' => $project->id,
            'user_id' => $userId,
            'rating' => $request->rating,
        ]);

        return response()->json([
            'success' => true,
            'message' => 'Avaliação registrada com sucesso!'
        ]);
    }

    public function update(Request $request, Project $project)
    {
        //
    }

    public function destroy(string $id)
    {
        //
    }
}
