<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Support\Str;

class Author extends Model
{
    use HasFactory;

    protected $fillable = [
        'user_id',
        'slug',
        'name',
    ];

    protected static function boot()
    {
        parent::boot();

        static::creating(function ($author) {
            $author->slug = Str::slug($author->name);
        });

        static::updating(function ($author) {
            $author->slug = Str::slug($author->name);
        });
    }

    public function user()
    {
        return $this->belongsTo(User::class);
    }

    public function projects()
    {
        return $this->belongsToMany(Project::class, 'project_author');
    }
}