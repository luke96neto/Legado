<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\Author;
use Illuminate\Http\Request;
use Inertia\Inertia;
use Illuminate\Support\Facades\Auth; // Importe a Facade Auth

class ProjectController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $projects = Project::with('authors', 'feedbacks', 'tags')
                            // Se 'feedbacks' for a tabela de ratings, use ratings em vez de feedbacks
                            ->withAvg('ratings', 'rating') // Assume que 'ratings' é o nome da relação e 'rating' a coluna
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

        // Verifique se 'nickname' existe no seu objeto user
        // Ou ajuste para user()->name se for o caso
        $author = Author::firstOrCreate([
            'user_id' => $request->user()->id,
        ], [
            'name' => $request->user()->name ?? 'Nome do Autor', // Use 'name' ou o campo correto do seu User
            'slug' => \Illuminate\Support\Str::slug($request->user()->name ?? 'Nome do Autor'), // Slug é obrigatório
        ]);

        $project = $request->user()->projects()->create($validated);
        $project->authors()->attach($author->id);

        return redirect()->route('project.show', $project->slug); // Use $project->slug para a rota
    }

    /**
     * Display the specified resource.
     */
    public function show($slug)
    {
        // Encontra o projeto pelo slug
        $project = Project::where('slug', $slug)->firstOrFail(); // Use firstOrFail para 404 se não encontrar

        // Carrega os autores, que você já estava fazendo
        $project->load('authors');

        // Carrega a avaliação do usuário logado para este projeto, se houver
        // 'ratings' deve ser o nome do relacionamento no seu modelo Project
        // Auth::id() pega o ID do usuário atualmente logado
        $project->load(['ratings' => function ($query) {
            $query->where('user_id', Auth::id());
        }]);

        // Calcula a média e a contagem de avaliações para passar ao Vue
        // Estes métodos (averageRating, ratingsCount) devem estar no seu modelo Project
        $averageRating = $project->averageRating();
        $ratingsCount = $project->ratingsCount();

        // Pega a avaliação específica do usuário logado para este projeto
        // 'first()' retornará o objeto Rating ou null se o usuário ainda não avaliou
        $userRating = $project->ratings->first();

        // Renderiza o componente Inertia 'Project/Show' e passa as props
        return Inertia::render('Project/Show', [
            'project' => [
                'id' => $project->id,
                'title' => $project->title,
                'description' => $project->description,
                'image' => $project->image,
                'repo_url' => $project->repo_url,
                'status' => $project->status,
                'authors' => $project->authors, // Já carregado acima
                'slug' => $project->slug,

                // Adicione as props de avaliação aqui
                'average_rating' => $averageRating,
                'ratings_count' => $ratingsCount,
                'user_rating' => $userRating, // O objeto Rating completo ou null
            ],
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