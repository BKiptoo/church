<?php

namespace App\Traits;

trait SysPermissions
{
    public string $viewDashBoardAnalytics = 'VIEW DASHBOARD ANALYTICS';


    public function permissions(): array
    {
        return [
            $this->viewDashBoardAnalytics
        ];
    }
}
