<div>

    <div class="container-xxl flex-grow-1 container-p-y" wire:init="loadData">


        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Edit/</span> Update Impact Type</h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><a href="{{ route('list.impact.types') }}"
                                            class="btn btn-link"><span
                                    class="bx bx-left-arrow"></span></a> Edit {{ $model->name }}</h5>
                        <small class="text-muted float-end">Update Impact Type</small>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="submit">
                            <div class="row">
                                <div class="mb-3 col-12">
                                    <label class="form-label" for="name">Impact Type Name</label>
                                    <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bxl-blogger"></i></span>
                                        <input type="text" id="name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               required
                                               name="name" placeholder="Enter title..."
                                               wire:model="name"
                                               aria-describedby="name"/>
                                        @error('name')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary me-2" wire:loading.class="disabled"
                                    wire:offline.attr="disabled"><span wire:target="submit"
                                                                       wire:loading.class="spinner-border text-secondary"></span>
                                Update
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
