<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Support\Str;

class Project extends Model
{

    use HasFactory;
    protected $fillable = [
        'title',
        'description',
        'status',
        'image',
        'repo_url',
        'user_id',
        'slug',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($project) {
            $project->slug = Str::slug($project->title);
        });

        static::updating(function ($project) {
            $project->slug = Str::slug($project->title);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function authors()
    {
        return $this->belongsToMany(Author::class, 'project_author');
    }

    public function feedbacks()
    {
        return $this->hasMany(Feedback::class);
    }

    public function comments()
    {
        return $this->hasMany(Comment::class);
    }

    public function tags()
    {
        return $this->belongsToMany(Tag::class, 'project_tag')->withTimestamps();
    }

    # TESTE DAQUI PARA BAIXO

    public function ratings()
    {
        return $this->hasMany(Rating::class);
    }

    /**
     * Calcula a média das avaliações para este post.
     * Retorna um float (ex: 3.75).
     */
    public function averageRating()
    {
        return $this->ratings()->avg('rating');
    }

    /**
     * Retorna a contagem total de avaliações para este post.
     */
    public function ratingsCount()
    {
        return $this->ratings()->count();
    }

    /**
     * Verifica se um usuário específico já avaliou este post.
     */
    public function hasUserRated($userId)
    {
        return $this->ratings()->where('user_id', $userId)->exists();
    }

    /**
     * Retorna a avaliação (objeto Rating) de um usuário específico para este post.
     */
    public function userRating($userId)
    {
        return $this->ratings()->where('user_id', $userId)->first();
    }
}
