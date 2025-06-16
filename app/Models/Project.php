<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;

class Project extends Model
{

    use HasFactory;
    protected $fillable = [
        'title',
        'description',
    ];

    public function authors()
    {
        return $this->hasMany(Author::class); // Lista todos os autores do projeto
    }
}
