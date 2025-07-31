<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tag;
use App\Models\Feedback;
use App\Models\Author;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth;
use Illuminate\Pagination\LengthAwarePaginator;

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $PAGE_SIZE = 15;
        $data = $request->query();

        $page = $request->query('page');
        $filter_by_bookmarks = $request->query('isFavorite');

        $all_projects = Project::with('authors', 'feedbacks', 'tags')
                            ->withAvg('feedbacks', 'rating')
                            ->latest()
                            ->get();
        
        $filtered_projects = $all_projects->filter(function($project) use ($filter_by_bookmarks, $request){
            $include = true;
            if ($filter_by_bookmarks) {
                $include = $request->user()->favoriteds->some('id', $project->id);
            }

            return $include;
        });

        $projects = $filtered_projects->forPage($page, $PAGE_SIZE);
        $paginator = new LengthAwarePaginator(
            $projects, 
            $filtered_projects->count(), 
            $PAGE_SIZE,
            $page,
            [
                'path' => url()->full()
            ] 
        );

        return Inertia::render('Project/Index', [
            'projects' => $paginator,
            'formData' => $data,
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

        return redirect()->route('project.show', $project->slug);
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
        
        $userFavorited = $project->hasUserFavorited(Auth::id());

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
                'user_favorited' => $userFavorited,
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

        $project->fill($validated);

        if (isset($validated['tag_id'])) {
            $project->tags()->sync([$validated['tag_id']]);
        }

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