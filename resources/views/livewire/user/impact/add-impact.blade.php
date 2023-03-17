<div>

    <div class="container-xxl flex-grow-1 container-p-y" wire:init="loadData">


        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Add/</span> Add Impact</h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">New Impact</h5>
                        <small class="text-muted float-end">New Impact</small>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="submit">
                            <div class="row">
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="impact_type_id">Impact Types</label>
                                    <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bx-world"></i></span>
                                        <select id="impact_type_id" wire:model="impact_type_id"
                                                class="select2 form-select @error('impact_type_id') is-invalid @enderror"
                                                required>
                                            <option value="">Select</option>
                                            @foreach($impactTypes as $impactType)
                                                <option value="{{ $impactType->id }}">{{ $impactType->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('impact_type_id')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="form-label" for="name">Impact Name</label>
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
                                <div class="mb-3 col-12" wire:model.debounce.365ms="description" wire:ignore>
                                    <label class="form-label" for="description">Impact Description</label>
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
                                    <label class="form-label" for="photo">Impact Banner <i
                                            class="text-info"><b>optional</b></i></label>
                                    <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bxs-image-add"></i></span>
                                        <input type="file" id="photo"
                                               class="form-control @error('photo') is-invalid @enderror"
                                               name="photo" placeholder="Impact banner"
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
