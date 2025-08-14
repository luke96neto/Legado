<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Tag;
use App\Models\Feedback;
use App\Models\Author;
use App\Models\User;
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
        $filter_by_tags = $request->query('tags') ? explode(',',$request->query('tags')) : [];
        $all_projects = Project::with('authors', 'feedbacks', 'tags')
                            ->withAvg('feedbacks', 'rating')
                            ->withCount('favoritedBy')
                            ->latest()
                            ->get();
        $all_tags = Tag::all();
        
        $filtered_projects = $all_projects->filter(function($project) use ($filter_by_bookmarks, $filter_by_tags, $request){
            $include = true;
            $includeBybookmarks = true;
            $includeByTags = true;
            if(!empty($filter_by_tags)) {
                $includeByTags = $project->tags->pluck('id')->intersect($filter_by_tags)->count() == count($filter_by_tags);
            }
            
            if ($filter_by_bookmarks) {
                $includeBybookmarks = $request->user()->favoriteds->some('id', $project->id);
            }
            if(!$includeBybookmarks || !$includeByTags){
                $include = false;
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
            'countItems' => $paginator->total(),
            'formData' => $data,
            'all_tags' => $all_tags,
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $tags = Tag::all();
        return Inertia::render('Project/Create', ['tags' => $tags]);
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
            'repo_url' => 'nullable|url',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,name',
            'authors' => 'required|array'
        ]);
        
        if ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('project-images', 'public');
        }

        // Criar projeto
        $project = $request->user()->projects()->create($validated);

        // Adicionar tags
        $tagIds = Tag::whereIn('name', $request->tags)->pluck('id')->toArray();
        $project->tags()->sync($tagIds);

        // Adicionar autores
        $author = Author::firstOrCreate([
            'user_id' => $request->user()->id,
        ], [
            'name' => $request->user()->nickname
        ]);
        $project->authors()->attach($author->id);

        foreach ($request->authors as $name) {
            if ($name !== $request->user()->nickname) {
                $addauthor = Author::firstOrCreate(['name' => trim($name)]);
                $project->authors()->attach($addauthor->id);
            }
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
        $tags = Tag::all();
        $project->load('tags');
        $project->load('authors');
        return Inertia::render('Project/Edit', [
            'project' => $project,
            'tags' => $tags
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Project $project)
    {
        $validated = $request->validate([
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'status' => 'required|in:rascunho,em_andamento,concluido',
            'image' => 'nullable|image|max:10240',
            'existing_image' => 'nullable|string', // Adicione este campo
            'repo_url' => 'nullable|url',
            'tags' => 'required|array',
            'tags.*' => 'exists:tags,name',
            'authors' => 'required|array'
        ]);

        // Mantém a imagem existente se não for enviada uma nova
        if (!$request->hasFile('image') && $validated['existing_image']) {
            $validated['image'] = $validated['existing_image'];
        } elseif ($request->hasFile('image')) {
            $validated['image'] = $request->file('image')->store('project-images', 'public');
        }

        // Atualiza o projeto
        $project->update($validated);

        // Sincroniza tags
        $tagIds = Tag::whereIn('name', $request->tags)->pluck('id')->toArray();
        $project->tags()->sync($tagIds);

        // Sincroniza autores
        $authors = [];
        foreach ($request->authors as $name) {
            $author = Author::firstOrCreate(['name' => trim($name)]);
            $authors[] = $author->id;
        }
        $project->authors()->sync($authors);

        return redirect()->route('project.show', $project->slug);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Project $project)
    {
        //
    }
    public function dashboard()
    {
        $user = Auth::user();

        $totalProjects = Project::count();
        $projectsInProgress = Project::where('status', 'em_andamento')->count();
        $completedProjects = Project::where('status', 'concluido')->count();
        $draftProjects = Project::where('status', 'rascunho')->count();

        $examples = Project::where('is_example', true)->get(); // Campo booleano

        $topCreators = User::withCount('projects')
                        ->orderByDesc('projects_count')
                        ->take(3)
                        ->get();

        $myProjects = Project::where('user_id', $user->id)->get();

        return Inertia::render('Dashboard', [
            'totalProjects' => $totalProjects,
            'projectsInProgress' => $projectsInProgress,
            'completedProjects' => $completedProjects,
            'draftProjects' => $draftProjects,
            'examples' => $examples,
            'topCreators' => $topCreators,
            'myProjects' => $myProjects,
        ]);
    }
}