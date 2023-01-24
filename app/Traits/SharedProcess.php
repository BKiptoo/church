<?php

namespace App\Traits;

use Exception;
use Illuminate\Support\Arr;
use LaravelMultipleGuards\Traits\FindGuard;

trait SharedProcess
{
    use FindGuard;

    /**
     * Get all the countries one is related to here
     * @return array
     * @throws Exception
     */
    public function worldAccess(): array
    {
        return Arr::flatten($this->findGuardType()->user()
            ->load('userCountriesAccess')
            ->userCountriesAccess()->get('country_id')
            ->toArray());
    }

}
