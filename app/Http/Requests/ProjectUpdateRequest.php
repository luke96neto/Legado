<?php

namespace App\Http\Requests;

use Illuminate\Foundation\Http\FormRequest;
use Illuminate\Validation\Rule;

class ProjectUpdateRequest extends FormRequest
{
    public function authorize(): bool
    {
        $project = $this->route('project');
        return $this->user() && $project && $this->user()->projects()->where('id', $project->id)->exists();
    }

    public function rules(): array
    {
        return [
            'title' => ['required', 'string', 'max:255'],
            'description' => ['nullable', 'string'],
            'status' => ['required', Rule::in(['rascunho', 'em_andamento', 'concluido'])],
            'image' => ['nullable', 'image', 'max:10240'],
            'repo_url' => ['nullable', 'url'],
            'tag_id' => ['nullable', 'exists:tags,id'],
        ];
    }
}
