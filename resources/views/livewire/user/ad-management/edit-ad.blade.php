<div>

    <div class="container-xxl flex-grow-1 container-p-y" wire:init="loadData">


        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Edit/</span> Update Ad</h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><a href="{{ route('list.ads') }}"
                                            class="btn btn-link"><span
                                    class="bx bx-left-arrow"></span></a> Edit {{ $model->name }}</h5>
                        <small class="text-muted float-end">Edit Ad</small>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="submit">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="country_id">Country</label>
                                    <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bx-world"></i></span>
                                        <select id="country_id" wire:model="country_id"
                                                class="select2 form-select @error('country_id') is-invalid @enderror"
                                                required>
                                            <option value="">Select</option>
                                            @foreach($countries as $country)
                                                <option value="{{ $country->id }}">{{ $country->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('country_id')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="form-label" for="name">Ad Title</label>
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
                                <div class="mb-3 col-6">
                                    <label class="form-label" for="linkUrl">Ad Link</label>
                                    <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bx-link"></i></span>
                                        <input type="url" id="linkUrl"
                                               class="form-control @error('linkUrl') is-invalid @enderror"
                                               required
                                               name="linkUrl" placeholder="Enter link address"
                                               wire:model="linkUrl"
                                               aria-describedby="linkUrl"/>
                                        @error('linkUrl')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="form-label" for="buttonName">Ad Button Name</label>
                                    <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bxs-mouse-alt"></i></span>
                                        <input type="text" id="buttonName"
                                               class="form-control @error('buttonName') is-invalid @enderror"
                                               required
                                               name="buttonName" placeholder="Enter button name"
                                               wire:model="buttonName"
                                               aria-describedby="buttonName"/>
                                        @error('buttonName')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-12" wire:model.debounce.365ms="description" wire:ignore>
                                    <label class="form-label" for="description">Ad Description</label>
                                    <input id="description"
                                           value="{{ $description }}"
                                           type="hidden"
                                           name="description">
                                    <trix-editor
                                        input="description"></trix-editor>
                                    @error('description')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-12">
                                    <label class="form-label" for="photo">Ad Banner <i class="text-info"><b>optional</b></i></label>
                                    <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bxs-image-add"></i></span>
                                        <input type="file" id="photo"
                                               class="form-control @error('photo') is-invalid @enderror"
                                               name="photo" placeholder="Ad banner"
                                               wire:model="photo"
                                               accept="image/png, image/jpeg, image/gif"
                                               aria-describedby="photo"/>
                                        @error('photo')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div wire:loading wire:target="photo"><span
                                    class="spinner-border spinner-border-sm"></span> Uploading
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
