<?php

namespace App\Http\Controllers;

use App\Models\Goal;
use App\View\Composers\GoalsIndexViewComposer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class GoalsController extends Controller
{
    public function index()
    {
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
