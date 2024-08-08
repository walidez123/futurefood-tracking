<?php

namespace App\Policies;

use App\Models\Company_branche;
use App\Models\User;

class BranchPolicy
{
    /**
     * Create a new policy instance.
     */
    public function __construct()
    {
        //
    }

    public function showBranch(User $user, Company_branche $branch)
    {
        return $user->id === $branch->company_id;
    }
}
