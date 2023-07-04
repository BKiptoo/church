<div>

    <div class="container-xxl flex-grow-1 container-p-y" wire:init="loadData">


        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Add/</span> Add Slide</h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">New Slide</h5>
                        <small class="text-muted float-end">New Slide</small>
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
                                    <label class="form-label" for="buttonName">Slide Title</label>
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
{{--                                <div class="mb-3 col-12">--}}
{{--                                    <label class="form-label" for="buttonUrl">Button Link</label>--}}
{{--                                    <div class="input-group input-group-merge">--}}
{{--                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i--}}
{{--                                            class="bx bx-link"></i></span>--}}
{{--                                        <input type="url" id="buttonUrl"--}}
{{--                                               class="form-control @error('buttonUrl') is-invalid @enderror"--}}
{{--                                               required--}}
{{--                                               name="buttonUrl" placeholder="Enter button link address"--}}
{{--                                               wire:model="buttonUrl"--}}
{{--                                               aria-describedby="buttonUrl"/>--}}
{{--                                        @error('buttonUrl')--}}
{{--                                        <span class="invalid-feedback" role="alert">--}}
{{--                                        <strong>{{ $message }}</strong>--}}
{{--                                    </span>--}}
{{--                                        @enderror--}}
{{--                                    </div>--}}
{{--                                </div>--}}
                                <div class="mb-3 col-12" wire:model.debounce.365ms="description" wire:ignore>
                                    <label class="form-label" for="description">Slide Description</label>
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
                                    <label class="form-label" for="photo">Slide Banner</label>
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
                                <div wire:loading wire:target="photo"><span
                                        class="spinner-border spinner-border-sm"></span> Uploading
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary me-2" wire:loading.class="disabled"
                                    wire:offline.attr="disabled"><span wire:target="submit"
                                                                       wire:loading.class="spinner-border text-secondary"></span>
                                Save
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
