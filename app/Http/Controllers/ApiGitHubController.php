<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Inertia\Inertia;

class ApiGitHubController extends Controller
{
    public function getRepos(Request $request)
    {
        try {
            if (!$request->user()->github_token) {
                return response()->json([
                    'error' => 'GitHub token não configurado'
                ], 401);
            }

            $repos = Cache::remember('github_repos_' . $request->user()->id, now()->addMinutes(30), function() use ($request) {
                $response = Http::withHeaders([
                    'Authorization' => 'token ' . $request->user()->github_token,
                    'Accept' => 'application/vnd.github.v3+json',
                ])->get('https://api.github.com/user/repos', [
                    'sort' => 'updated',
                    'per_page' => 100,
                    'affiliation' => 'owner'
                ]);

                if ($response->failed()) {
                    throw new \Exception('GitHub API error: ' . $response->body(), $response->status());
                }

                return $response->json();
            });
            
            return response()->json($repos);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }

    public function getRepoCollaborators(Request $request, $owner, $repo)
    {
        try {
            if (!$request->user()->github_token) {
                return response()->json(['error' => 'GitHub token não configurado'], 401);
            }

            $cacheKey = "github_collaborators_{$owner}_{$repo}_{$request->user()->id}";

            $collaborators = Cache::remember($cacheKey, now()->addHours(1), function() use ($request, $owner, $repo) {
                $response = Http::withHeaders([
                    'Authorization' => 'Bearer ' . $request->user()->github_token,
                    'Accept' => 'application/vnd.github.v3+json',
                ])->get("https://api.github.com/repos/{$owner}/{$repo}/collaborators", [
                    'per_page' => 100,
                    'affiliation' => 'direct'
                ]);

                if ($response->failed()) {
                    throw new \Exception('GitHub API error: ' . $response->body(), $response->status());
                }

                return $response->json();
            });
            
            return response()->json($collaborators);
            
        } catch (\Exception $e) {
            return response()->json([
                'error' => $e->getMessage()
            ], $e->getCode() ?: 500);
        }
    }

}
