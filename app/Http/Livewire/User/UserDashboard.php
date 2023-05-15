<?php

namespace App\Http\Livewire\User;

use App\Charts\BlogReportChart;
use App\Charts\GeneralChart;
use App\Charts\OrderReportChart;
use App\Charts\PieChart;
use App\Jobs\SyncAnalyticDataJob;
use App\Models\Analytic;
use LaravelMultipleGuards\Traits\FindGuard;
use Livewire\Component;

class UserDashboard extends Component
{
    use FindGuard;

    public bool $readyToLoad = false;
    private $chart;
    private $pieChart;
    private $blogChart;
    private $orderChart;
    private $analytics;

    public function loadData()
    {
        $this->readyToLoad = true;
        dispatch(new SyncAnalyticDataJob())->onQueue('default')->delay(now()->addMinute());
    }

    public function charts(): array
    {
        // load the analytics model
        $this->analytics = Analytic::query()->first();

        // Order chart
        $orderSummary = $this->analytics->data['orderSummary'];
        $this->orderChart = new OrderReportChart();
        $this->orderChart->labels(['Day 1', 'Day 2', 'Day 3', 'Day 4', 'Day 5', 'Day 6', 'Day 7']);
        $this->orderChart->dataset('Weekly Orders', 'line', [
            $orderSummary[0],
            $orderSummary[1],
            $orderSummary[2],
            $orderSummary[3],
            $orderSummary[4],
            $orderSummary[5],
            $orderSummary[6]
        ])->backgroundColor(collect(['#7158e2', '#3ae374', '#ff3838', '#ffc107']))
            ->color(collect(['#7d5fff', '#32ff7e', '#ff4d4d', '#0000ff']));

        // pie chart
        $this->pieChart = new PieChart();
        $this->pieChart->labels(['Leads', 'Contacts', 'Customers', 'Failed Conventions']);
        $this->pieChart->dataset('Lead Convention Overview', 'pie', [
            $this->analytics->data['leads'],
            $this->analytics->data['contacts'],
            $this->analytics->data['customers'],
            $this->analytics->data['failed']
        ])->backgroundColor(collect(['#7158e2', '#3ae374', '#ff3838', '#ffc107']))
            ->color(collect(['#7d5fff', '#32ff7e', '#ff4d4d', '#0000ff']));

        // general chart
        $this->chart = new GeneralChart();
        $this->chart->labels(['Tenders', 'Pending Tenders', 'Orders', 'Pending Orders', 'Files']);
        $this->chart->dataset('General Overview', 'bar', [
            $this->analytics->data['tenders'],
            $this->analytics->data['pendingTenders'],
            $this->analytics->data['orders'],
            $this->analytics->data['pendingOrders'],
            $this->analytics->data['media'],
        ])->backgroundColor(collect(['#7158e2', '#3ae374', '#ff3838', '#ffc107', '#189d5a']))
            ->color(collect(['#7d5fff', '#32ff7e', '#ff4d4d', '#0000ff', '#189d5a']));

        // blog chart
        $this->blogChart = new BlogReportChart();
        $this->blogChart->labels(['Views', 'Likes']);
        $this->blogChart->dataset('Blogs Overview', 'doughnut', [
            $this->analytics->data['blogViews'],
            $this->analytics->data['blogLikes']
        ])->backgroundColor(collect(['#7158e2', '#3ae374', '#ff3838', '#ffc107']))
            ->color(collect(['#7d5fff', '#32ff7e', '#ff4d4d', '#0000ff']));


        return [
            $this->chart,
            $this->pieChart,
            $this->orderChart,
            $this->blogChart,
            $this->analytics
        ];
    }

    public function render()
    {
        return view('livewire.user.user-dashboard', [
            'user' => $this->findGuardType()->user(),
            'analytics' => $this->readyToLoad ? $this->charts()[4] : null,
            'chart' => $this->charts()[0],
            'pieChart' => $this->charts()[1],
            'orderChart' => $this->charts()[2],
            'blogChart' => $this->charts()[3]
        ]);
    }
}
