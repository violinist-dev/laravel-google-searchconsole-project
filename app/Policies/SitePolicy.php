<?php

namespace App\Policies;

use App\Model\User;
use App\Model\Site;
use Illuminate\Auth\Access\HandlesAuthorization;

class SitePolicy
{
    use HandlesAuthorization;

    /**
     * Determine whether the user can view the site.
     *
     * @param  \App\Model\User $user
     * @param  \App\Model\Site $site
     *
     * @return mixed
     */
    public function view(User $user, Site $site)
    {
        return $user->id === $site->user->id;
    }

    /**
     * Determine whether the user can create sites.
     *
     * @param  \App\Model\User $user
     *
     * @return mixed
     */
    public function create(User $user)
    {
        //
    }

    /**
     * Determine whether the user can update the site.
     *
     * @param  \App\Model\User $user
     * @param  \App\Model\Site $site
     *
     * @return mixed
     */
    public function update(User $user, Site $site)
    {
        return $user->id === $site->user->id;
    }

    /**
     * Determine whether the user can delete the site.
     *
     * @param  \App\Model\User $user
     * @param  \App\Model\Site $site
     *
     * @return mixed
     */
    public function delete(User $user, Site $site)
    {
        return $user->id === $site->user->id;
    }
}
