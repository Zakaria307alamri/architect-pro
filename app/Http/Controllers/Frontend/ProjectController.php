<?php

namespace App\Http\Controllers\Frontend;

use App\Http\Controllers\Controller;
use App\Models\Category;
use App\Models\Project;
use Illuminate\Http\Request;

class ProjectController extends Controller
{
    public function home()
    {
        $featuredProjects = Project::query()
            ->where('featured', true)
            ->latest()
            ->take(3)
            ->get();

        return view('frontend.home', compact('featuredProjects'));
    }

    public function projects(Request $request)
    {
        $selectedCategory = $request->query('category');

        $categories = Category::query()
            ->orderBy('name')
            ->get(['id', 'name', 'slug']);

        $projects = Project::query()
            ->with('category:id,name,slug')
            ->when(
                $selectedCategory,
                fn ($query) => $query->whereHas(
                    'category',
                    fn ($categoryQuery) => $categoryQuery->where('slug', $selectedCategory)
                )
            )
            ->latest()
            ->get();

        return view('frontend.projects.index', compact('projects', 'categories', 'selectedCategory'));
    }

    public function show($slug)
    {
        $project = Project::where('slug', $slug)->firstOrFail();

        $next = Project::where('id', '>', $project->id)->first();
        $previous = Project::where('id', '<', $project->id)
            ->orderBy('id', 'desc')
            ->first();

        return view('frontend.projects.show', compact('project', 'next', 'previous'));
    }
}
