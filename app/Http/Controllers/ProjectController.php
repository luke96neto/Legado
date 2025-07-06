<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Author;
use Illuminate\Http\Request;
use Inertia\Inertia;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('authors', 'feedbacks', 'tags')
                    ->withAvg('feedbacks', 'rating')
                    ->latest()
                    ->paginate(15);

        return Inertia::render('Project/Index', [
            'projects' => $projects,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        return Inertia::render('Project/Create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:rascunho,em_andamento,concluido',
            'image' => 'nullable|image|max:10240',
            'repo_url' => 'nullable|url'
        ]);
        
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('project-images', 'public');
        }

        $author = Author::firstOrCreate([
            'user_id' => $request->user()->id,
        ], [
            'name' => $request->user()->nickname,
        ]);

        $project = $request->user()->projects()->create($validated);
        $project->authors()->attach($author->id);

        return redirect()->route('project.show', $project['slug']);
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {

        $project = Project::where('slug', $slug)->first();
        $project->load('authors');
        
        return Inertia::render('Project/Show', [
            'project' => $project,
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}
