<?php

declare(strict_types=1);

namespace App\Policies;

use Illuminate\Foundation\Auth\User as AuthUser;
use App\Models\ApplicationSetting;
use Illuminate\Auth\Access\HandlesAuthorization;

class ApplicationSettingPolicy
{
    use HandlesAuthorization;
    
    public function viewAny(AuthUser $authUser): bool
    {
        return $authUser->can('ViewAny:ApplicationSetting');
    }

    public function view(AuthUser $authUser, ApplicationSetting $applicationSetting): bool
    {
        return $authUser->can('View:ApplicationSetting');
    }

    public function create(AuthUser $authUser): bool
    {
        return $authUser->can('Create:ApplicationSetting');
    }

    public function update(AuthUser $authUser, ApplicationSetting $applicationSetting): bool
    {
        return $authUser->can('Update:ApplicationSetting');
    }

    public function delete(AuthUser $authUser, ApplicationSetting $applicationSetting): bool
    {
        return $authUser->can('Delete:ApplicationSetting');
    }

}