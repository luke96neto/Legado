<?php

use Illuminate\Support\Facades\Route;
use App\Http\Controllers\ApiGitHubController;

Route::middleware('auth:sanctum')->prefix('github')->group(function() {
    Route::get('/repos', [ApiGitHubController::class, 'getRepos']);
    Route::get('/repos/{owner}/{repo}/collaborators', [ApiGitHubController::class, 'getRepoCollaborators']);
});