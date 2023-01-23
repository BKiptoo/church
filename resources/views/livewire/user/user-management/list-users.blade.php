<div>
    <div class="container-xxl flex-grow-1 container-p-y">


        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Users /</span> List
        </h4>

        <!-- Basic Bootstrap Table -->
        <div class="card" wire:poll.visible>
            <div class="card-body">
                <div class="row">
                    <div class="col-10">
                        <input type="search" wire:model="search" placeholder="Search..." title="Search..."
                               class="form-control">
                    </div>
                    <div class="col-2">
                        <a href="{{ route('add.user') }}" class="btn btn-outline-primary"><span
                                class="bx bx-plus"></span>Add User</a>
                    </div>
                </div>
            </div>
            <div class="table-responsive text-nowrap" wire:init="loadData">
                @if(count($models))
                    <table class="table table-hover">
                        <thead>
                        <tr>
                            <th scope="col">#</th>
                            <th scope="col">Profile</th>
                            <th scope="col">Country</th>
                            <th scope="col">Full Name</th>
                            <th scope="col">Email</th>
                            <th scope="col">Phone Number</th>
                            <th scope="col">Status</th>
                            <th scope="col">Actions</th>
                        </tr>
                        </thead>
                        @php($count = 1)
                        <tbody class="table-border-bottom-0">
                        @foreach($models as $model)
                            <tr>
                                <th scope="row">{{ $count++ }}</th>
                                <td>
                                    <ul class="list-unstyled users-list m-0 avatar-group d-flex align-items-center">
                                        <li data-bs-toggle="tooltip" data-popup="tooltip-custom"
                                            data-bs-placement="top" class="avatar avatar-xs pull-up"
                                            title="{{ $model->name }}">
                                            <img
                                                src="{{ $model->media ? $model->media->pathUrls[0] : \App\Http\Controllers\SystemController::generateAvatars($model->slug,100) }}"
                                                alt="Avatar"
                                                class="rounded-circle">
                                        </li>
                                    </ul>
                                </td>
                                <td>{{ $model->country->name }}</td>
                                <td>{{ $model->name }}</td>
                                <td>{{ $model->email }}</td>
                                <td>{{ $model->phoneNumber }}</td>
                                <td>
                                    @if($model->isActive)
                                        <span class="badge bg-label-success me-1">Active</span>
                                    @else
                                        <span class="badge bg-label-danger me-1">In-Active</span>
                                    @endif
                                </td>
                                <td>
                                    <div class="dropdown">
                                        <button type="button" class="btn p-0 dropdown-toggle hide-arrow"
                                                data-bs-toggle="dropdown"><i
                                                class="bx bx-dots-vertical-rounded"></i></button>
                                        <div class="dropdown-menu">
                                            <a class="dropdown-item"
                                               href="{{ route('edit.user',['slug'=>$model->slug]) }}"><i
                                                    class="bx bx-edit-alt me-1"></i> Edit</a>
                                            <a class="dropdown-item text-danger" wire:click="delete('{{ $model->id }}')"
                                               href="javascript:void(0);"><i
                                                    class="bx bx-trash me-1"></i> Delete</a>
                                        </div>
                                    </div>
                                </td>
                            </tr>
                        @endforeach
                        </tbody>
                    </table>
                    <div class="row float-end">
                        {{ $models->links() }}
                    </div>
                @else
                    <br>
                    <div class="d-flex justify-content-center">
                        <div wire:loading class="spinner-border text-primary" role="status">
                            <span class="sr-only"></span>
                        </div>
                    </div>
                    <div class="d-flex justify-content-center">
                        @if($search!==null)
                            <img src="{{ asset('assets/img/no-items.gif') }}" alt="">
                        @else
                            <img src="{{ asset('assets/img/loading.gif') }}" alt="">
                        @endif
                    </div>
                @endif
            </div>
        </div>
        <!--/ Basic Bootstrap Table -->

        <hr class="my-5">


    </div>
</div>
