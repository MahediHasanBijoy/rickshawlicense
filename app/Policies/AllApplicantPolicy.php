<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\AllApplicant;
use Illuminate\Auth\Access\HandlesAuthorization;

class AllApplicantPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:AllApplicant');
    }

    public function view(AuthUser $authUser, AllApplicant $allApplicant): bool
    {
        return $authUser->can('View:AllApplicant');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:AllApplicant');
    }

    public function update(AuthUser $authUser, AllApplicant $allApplicant): bool
    {
        return $authUser->can('Update:AllApplicant');
    }

    public function delete(AuthUser $authUser, AllApplicant $allApplicant): bool
    {
        return $authUser->can('Delete:AllApplicant');
    }

}