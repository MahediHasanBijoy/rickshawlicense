<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\Area;
use Illuminate\Auth\Access\HandlesAuthorization;

class AreaPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:Area');
    }

    public function view(AuthUser $authUser, Area $area): bool
    {
        return $authUser->can('View:Area');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:Area');
    }

    public function update(AuthUser $authUser, Area $area): bool
    {
        return $authUser->can('Update:Area');
    }

    public function delete(AuthUser $authUser, Area $area): bool
    {
        return $authUser->can('Delete:Area');
    }

}