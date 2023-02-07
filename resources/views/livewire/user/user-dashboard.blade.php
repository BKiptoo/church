<div wire:poll.visible>
    <div class="container-xxl flex-grow-1 container-p-y" wire:init="loadData">
        <div class="row">
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <button disabled class="btn btn-primary"><span class="bx bxs-group"></span></button>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                    <a class="dropdown-item" href="{{ route('list.users') }}">View
                                        More</a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Users</span>
                        <h3 class="card-title mb-2">{{ isset($analytics) ? number_format($analytics->data['users']) : 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <button disabled class="btn btn-success"><span class="bx bxl-product-hunt"></span>
                                </button>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                    <a class="dropdown-item" href="{{ route('list.products') }}">View
                                        More</a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Products</span>
                        <h3 class="card-title mb-2">{{ isset($analytics) ? number_format($analytics->data['products']) : 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <button disabled class="btn btn-info"><span class="bx bx-cart-alt"></span>
                                </button>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                    <a class="dropdown-item" href="{{ route('list.orders') }}">View
                                        More</a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Orders</span>
                        <h3 class="card-title mb-2">{{ isset($analytics) ? number_format($analytics->data['orders']) : 0 }}</h3>
                    </div>
                </div>
            </div>
            <div class="col-md-3 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="card-title d-flex align-items-start justify-content-between">
                            <div class="avatar flex-shrink-0">
                                <button disabled class="btn btn-warning"><span class="bx bxs-file-pdf"></span>
                                </button>
                            </div>
                            <div class="dropdown">
                                <button class="btn p-0" type="button" id="cardOpt3" data-bs-toggle="dropdown"
                                        aria-haspopup="true" aria-expanded="false">
                                    <i class="bx bx-dots-vertical-rounded"></i>
                                </button>
                                <div class="dropdown-menu dropdown-menu-end" aria-labelledby="cardOpt3">
                                    <a class="dropdown-item" href="{{ route('list.tenders') }}">View
                                        More</a>
                                </div>
                            </div>
                        </div>
                        <span class="fw-semibold d-block mb-1">Tenders</span>
                        <h3 class="card-title mb-2">{{ isset($analytics) ? number_format($analytics->data['tenders']) : 0 }}</h3>
                    </div>
                </div>
            </div>
        </div>
        <div class="row">
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                <div class="card-title">
                                    <h5 class="text-nowrap mb-2">Orders Insights</h5>
                                    <span class="badge bg-label-warning rounded-pill"><span
                                            class="bx bx-line-chart"></span></span>
                                </div>
                                <div class="mt-sm-auto">
                                    <h3 class="mb-0">{{ isset($analytics) ? number_format($analytics->data['orders']) : 0 }}</h3>
                                </div>
                            </div>
                            <div id="orderChart" wire:ignore>
                                {!! $orderChart->container() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-6 mb-4">
                <div class="card">
                    <div class="card-body">
                        <div class="d-flex justify-content-between flex-sm-row flex-column gap-3">
                            <div class="d-flex flex-sm-column flex-row align-items-start justify-content-between">
                                <div class="card-title">
                                    <h5 class="text-nowrap mb-2">Blogs Insights</h5>
                                    <span class="badge bg-label-warning rounded-pill"><span
                                            class="bx bxl-blogger"></span></span>
                                </div>
                                <div class="mt-sm-auto">
                                    <h3 class="mb-0">{{ isset($analytics) ? number_format($analytics->data['blogs']) : 0 }}</h3>
                                </div>
                            </div>
                            <div id="blogChart" wire:ignore>
                                {!! $blogChart->container() !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="row" wire:ignore>
            <div class="col-sm-8 col-xl-8 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">General Overview</h5>
                        <div id="app" style="height: 300px;">{!! $chart->container() !!}</div>
                    </div>
                </div>
            </div>
            <div class="col-sm-4 col-xl-4 mb-4">
                <div class="card">
                    <div class="card-body">
                        <h5 class="card-title">Leads Overview</h5>
                        <div id="pie" style="height: 300px;">{!! $pieChart->container() !!}</div>
                    </div>
                </div>
            </div>
        </div>
    </div>
    @section('scripts')
        <script src="https://unpkg.com/vue"></script>
        <script>
            var app = new Vue({
                el: '#app',
            });
            var pie = new Vue({
                el: '#pie',
            });
            var pie = new Vue({
                el: '#blogChart',
            });
            var pie = new Vue({
                el: '#orderChart',
            });
        </script>
        <script src="https://cdnjs.cloudflare.com/ajax/libs/Chart.js/2.7.1/Chart.min.js" charset="utf-8"></script>
        {!! $chart->script() !!}
        {!! $orderChart->script() !!}
        {!! $blogChart->script() !!}
        {!! $pieChart->script() !!}
    @endsection
</div>
