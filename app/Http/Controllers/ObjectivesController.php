<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\View;
use App\View\Composers\ObjectivesIndexViewComposer;

class ObjectivesController extends Controller
{
    public function index()
    {
        // Set the view composer manually
        View::composer('objectives', ObjectivesIndexViewComposer::class);

        // Return the view
        return view('objectives')
            ->with('objectives', auth()->user()->currentTeam->objectives);
    }

    public function show($objective)
    {
        // Return the view
        return view('objectives.show')
            ->with('objective', $objective);
    }

    public function edit($objective)
    {
        // Return the view
        return view('objectives.edit')
            ->with('objective', $objective);
    }
}
