<?php

namespace App\Traits;

use Exception;
use LaravelMultipleGuards\Traits\FindGuard;

trait SharedProcess
{
    use FindGuard;

    /**
     * Get all the countries one is related to here
     * @return mixed
     * @throws Exception
     */
    public function worldAccess(): mixed
    {
        return $this->findGuardType()->user()
            ->load('userCountriesAccess')
            ->userCountriesAccess()->get('country_id')
            ->toArray();
    }

}
