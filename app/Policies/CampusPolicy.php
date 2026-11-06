<?php

namespace App\Policies;

use App\Models\Campus;
use App\Models\User;
use Illuminate\Auth\Access\Response;

class CampusPolicy
{
    public function viewAny(User $user): bool
    {
        return false;
    }
    public function view(User $user, Campus $campus): bool
    {
        return false;
    }
    public function create(User $user): bool
    {
        return false;
    }
    public function update(User $user, Campus $campus): bool
    {
        return false;
    }
    public function delete(User $user, Campus $campus): bool
    {
        return $user->hasAnyRole(['admin', 'owner']);
    }
    public function restore(User $user, Campus $campus): bool
    {
        return false;
    }
    public function forceDelete(User $user, Campus $campus): bool
    {
        return false;
    }
}
