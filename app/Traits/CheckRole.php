<?php

namespace App\Traits;

use Illuminate\Auth\Access\AuthorizationException;

trait CheckRole
{
    protected function checkRole($roles)
    {
        $user = auth()->user();

        if (!$user || !$user->hasAnyRole($roles) ) {
            throw new AuthorizationException();
        }
    }   

    protected function checkRoleAndUser($roles , $userId = null)
    {
        $user = auth()->user();
        if (!$user || (!$user->hasAnyRole($roles) && (!$userId || $user->id != $userId))) {
            throw new AuthorizationException();
        }
    }   
}
