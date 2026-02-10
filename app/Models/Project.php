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
        'is_example'
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

    public function averageRating()
    {
        return $this->feedbacks()->avg('rating');
    }

    public function ratingsCount()
    {
        return $this->feedbacks()->count();
    }

    public function hasUserRated($userId)
    {
        return $this->feedbacks()->where('user_id', $userId)->exists();
    }

    public function userRating($userId)
    {
        return $this->feedbacks()->where('user_id', $userId)->first();
    }

    public function favoritedBy()
    {
        return $this->belongsToMany(User::class, 'favorites', 'project_id', 'user_id');
    }

    public function hasUserFavorited($userId)
    {
        return $this->favoritedBy()->where('user_id', $userId)->exists();
    }
}
