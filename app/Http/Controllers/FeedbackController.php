<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use App\Models\Feedback;
use App\Models\Project;

class FeedbackController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
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

    /**
     * Atualiza uma avaliação existente para um projeto.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Display the specified resource.
     */
    public function show(string $id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */


    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        //
    }
}
