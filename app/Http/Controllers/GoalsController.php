<?php

namespace App\Http\Controllers;

use App\View\Composers\GoalsIndexViewComposer;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;

class GoalsController extends Controller
{
    public function index()
    {
        // Set the view composer manually
        View::composer('goals', GoalsIndexViewComposer::class);

        // Return the view
        return view('goals')
            ->with('goals', Auth::user()->currentTeam->goals);
    }

    public function show($goal)
    {
        // Return the view
        return view('goals.show')
            ->with('goal', $goal);
    }

    public function edit($goal)
    {
        // Return the view
        return view('goals.edit')
            ->with('goal', $goal);
    }
}
