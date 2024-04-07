<?php

namespace App\Traits;

trait CheckRole
{
    protected function checkRole($roles)
    {
        $user = auth()->user();

        if (!$user || !$user->hasAnyRole($roles) ) {
            abort(403, 'Unauthorized You Dont Have Access');
        }
    }   

    protected function checkRoleAndUser($roles , $userId = null)
    {
        $user = auth()->user();
        if (!$user || (!$user->hasAnyRole($roles) && (!$userId || $user->id != $userId))) {
            abort(403, 'Unauthorized You Dont Have Access');
        }
    }   
}
