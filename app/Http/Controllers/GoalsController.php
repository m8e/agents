<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\View\Composers\GoalsIndexViewComposer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class GoalsController extends Controller
{
    public function onboarding()
    {
        // Return the view
        return view('goals.onboarding');
    }

    public function index()
    {
        if (Auth::user()->currentTeam->goals->isEmpty()) {
            return redirect(route('goals.onboarding'));
        }

        // Set the view composer manually
        View::composer('goals.index', GoalsIndexViewComposer::class);

        // Return the view
        return view('goals.index')
            ->with('goals', Auth::user()->currentTeam->goals);
    }

    public function show(Goal $goal)
    {
        // Return the view
        return view('goals.show', compact('goal'));
    }

    public function store()
    {
        // Validate the request
        // Create the goal
        Goal::create([
            'title' => request('title'),
            'description' => request('description'),
            'team_id' => Auth::user()->currentTeam->id,
            'user_id' => Auth::id(),
        ]);

        // Redirect to the goals index
        return redirect(route('goals.index'));
    }

    public function edit($goal)
    {
        // Return the view
        return view('goals.edit')
            ->with('goal', $goal);
    }

    public function create()
    {
        // Return the view
        return view('goals.create');
    }
}
