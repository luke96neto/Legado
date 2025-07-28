<?php

namespace App\Http\Controllers;

use App\Models\Project;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class FavoriteController extends Controller
{
    public function store(Request $request, $id)
    {
        $project = Project::where('id', $id)->firstOrFail();
        $userId = Auth::id();

        if ($project->hasUserFavorited($userId)) {
        
            $project->favoritedBy()->detach($userId);
           
            return response()->json(['success' => true]);
        } 

        $project->favoritedBy()->attach($userId);

        return response()->json(['success' => true]);
    }
}
