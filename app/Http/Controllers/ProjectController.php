<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Feedback;
use App\Models\Author;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;

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
            'name' => $request->user()->nickname
        ]);
        
        $project = $request->user()->projects()->create($validated);
        $project->authors()->attach($author->id);

        $authorlist = array_map('trim', explode(',', $request['authors']));
        $authorlist = array_diff($authorlist, [$request->user()->nickname]);
        
        foreach ($authorlist as $name) {
            $addauthor = Author::firstOrCreate([
                'name' => $name
            ],[
                'name' => $name
            ]);
            $project->authors()->attach($addauthor->id);
        }

        return redirect()->route('project.show', $project->slug); // Use $project->slug para a rota
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {

        $project = Project::where('slug', $slug)->firstOrFail();

        $project->load('authors');
        $project->load('feedbacks')->where('user_id', Auth::id());

        $averageRating = $project->averageRating();
        $ratingsCount = $project->ratingsCount();
        $userRating = $project->userRating(Auth::id());

        return Inertia::render('Project/Show', [
            'project' => [
                'id' => $project->id,
                'title' => $project->title,
                'description' => $project->description,
                'image' => $project->image,
                'repo_url' => $project->repo_url,
                'status' => $project->status,
                'authors' => $project->authors,
                'slug' => $project->slug,
                
                'average_rating' => $averageRating,
                'ratings_count' => $ratingsCount,
                'user_rating' => $userRating,
            ],
        ]);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Project $project)
    {
        $tags = \App\Models\Tag::all();
        $project->load('tags');
        return Inertia::render('Project/Edit', [
            'project' => $project,
            'tags' => $tags
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(\App\Http\Requests\ProjectUpdateRequest $request, Project $project)
    {
        $validated = $request->validated();

        // Atualiza os dados do projeto
        $project->fill($validated);

        // Atualiza a tag do projeto, se fornecida
        if (isset($validated['tag_id'])) {
            $project->tags()->sync([$validated['tag_id']]);
        }

        // Atualiza imagem se fornecida
        if ($request->hasFile('image')) {
            $project->image = $request->file('image')->store('project-images', 'public');
        }

        $project->save();

        return redirect()->route('project.show', $project->slug)->with('status', 'Projeto atualizado com sucesso!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
}