<?php

namespace App\Policies;

use App\Models\Objective;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class ObjectivePolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Objective $objective): bool {
        return $user->teams()->where('id', $objective->team_id)->exists();
    }

    public function create(User $user): bool {
        // only if you're a team admin

    }

    public function update(User $user, Objective $objective): bool {
        // // only if you're a team admin or you created the objective
    }

    public function delete(User $user, Objective $objective): bool {}

    public function restore(User $user, Objective $objective): bool {}

    public function forceDelete(User $user, Objective $objective): bool {}
}
