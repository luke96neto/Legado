<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;

class Rating extends Model
{
    use HasFactory;

    // Define quais colunas podem ser preenchidas massivamente
    protected $fillable = [
        'project_id',
        'user_id',
        'rating',
    ];

    /**
     * Uma avaliação pertence a um post.
     */
    public function post()
    {
        return $this->belongsTo(Post::class);
    }

    /**
     * Uma avaliação pertence a um usuário.
     */
    public function user()
    {
        return $this->belongsTo(User::class);
    }
}