<?php

namespace App\View\Composers;

use Illuminate\View\View;

class GoalsIndexViewComposer
{
    public function compose(View $view): void
    {
        $goals = $view->getData()['goals'];

        // Add any additional logic here for composing the goals index view
    }
}
