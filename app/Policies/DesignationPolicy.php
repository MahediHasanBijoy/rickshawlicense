<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Designation;
use Illuminate\Auth\Access\HandlesAuthorization;

class DesignationPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Designation');
    }

    public function view(AuthUser $authUser, Designation $designation): bool
    {
        return $authUser->can('View:Designation');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Designation');
    }

    public function update(AuthUser $authUser, Designation $designation): bool
    {
        return $authUser->can('Update:Designation');
    }

    public function delete(AuthUser $authUser, Designation $designation): bool
    {
        return $authUser->can('Delete:Designation');
    }

}