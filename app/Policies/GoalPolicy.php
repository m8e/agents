<?php

namespace App\Policies;

use App\Models\Goal;
use App\Models\User;
use Illuminate\Auth\Access\HandlesAuthorization;

class GoalPolicy
{
    use HandlesAuthorization;

    public function viewAny(User $user): bool
    {
        return true;
    }

    public function view(User $user, Goal $goal): bool
    {
        return $user->teams()->where('id', $goal->team_id)->exists();
    }

    public function create(User $user): bool
    {
        // Implement the logic for team admin check
        return $user->isTeamAdmin();  // Assuming you have this method in your User model
    }

    public function update(User $user, Goal $goal): bool
    {
        // Implement the logic for team admin or goal creator check
        return $user->isTeamAdmin() || $goal->user_id === $user->id;
    }

    public function delete(User $user, Goal $goal): bool
    {
        // Implement deletion logic
        return $user->isTeamAdmin() || $goal->user_id === $user->id;
    }

    public function restore(User $user, Goal $goal): bool
    {
        // Implement restoration logic
        return $user->isTeamAdmin();
    }

    public function forceDelete(User $user, Goal $goal): bool
    {
        // Implement force deletion logic
        return $user->isTeamAdmin();
    }
}
