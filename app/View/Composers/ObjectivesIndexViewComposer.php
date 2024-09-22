<?php

namespace App\View\Composers;

use Illuminate\View\View;

class ObjectivesIndexViewComposer
{
    public function compose(View $view)
    {
        $objectives = $view->getData()['objectives'];

        // do stuff here
    }
}
