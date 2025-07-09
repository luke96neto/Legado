<?php

namespace App\Http\Controllers;

use App\Models\Project; // Importe o modelo Projeto
use App\Models\Rating; // Importe o modelo Rating
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth; // Para pegar o ID do usuário logado

class RatingController extends Controller
{
    /**
     * Armazena uma nova avaliação para um projeto.
     */
    public function store(Request $request, Project $Project)
    {
        // 1. Validação dos dados de entrada
        // Garante que 'rating' é obrigatório, é um número inteiro, e está entre 0 e 5.
        $request->validate([
            'rating' => ['required', 'integer', 'min:0', 'max:5'],
        ]);

        $userId = Auth::id(); // Pega o ID do usuário atualmente logado

        // 2. Verificar se o usuário JÁ avaliou este projeto.
        if ($project->hasUserRated($userId)) {
            // Se sim, redireciona de volta com uma mensagem de erro
            return redirect()->back()->with('error', 'Você já avaliou este item. Por favor, use a opção de "Atualizar Avaliação".');
        }

        // 3. Cria a nova avaliação no banco de dados
        Rating::create([
            'project_id' => $project->id,
            'user_id' => $userId,
            'rating' => $request->rating,
        ]);

        // 4. Redireciona de volta para a página anterior com uma mensagem de sucesso
        return redirect()->back()->with('success', 'Sua avaliação foi registrada com sucesso!');
    }

    /**
     * Atualiza uma avaliação existente para um projeto.
     */
    public function update(Request $request, Project $project)
    {
        // 1. Validação dos dados
        $request->validate([
            'rating' => ['required', 'integer', 'min:0', 'max:5'],
        ]);

        $userId = Auth::id(); // Pega o ID do usuário logado

        // 2. Tenta encontrar a avaliação existente do usuário para este projeto.
        $rating = $project->userRating($userId);

        // Se a avaliação não for encontrada (o que não deveria acontecer se o formulário for bem feito)
        if (!$rating) {
            return redirect()->back()->with('error', 'Avaliação não encontrada para atualização. Você ainda não avaliou este item.');
        }

        // 3. Atualiza a pontuação da avaliação
        $rating->update([
            'rating' => $request->rating,
        ]);

        // 4. Redireciona de volta com mensagem de sucesso
        return redirect()->back()->with('success', 'Sua avaliação foi atualizada com sucesso!');
    }
}