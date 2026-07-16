<?php

namespace App\Policies;

use App\Models\User;

class AdminPolicy
{
    public function access(User $user): bool
    {
        return $user->isAdmin();
    }

    public function manageSettings(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function manageUsers(User $user): bool
    {
        return $user->isSuperAdmin();
    }

    public function viewAnalytics(User $user): bool
    {
        return $user->isAdmin();
    }

    public function manageContent(User $user): bool
    {
        return $user->isAdmin();
    }
}
