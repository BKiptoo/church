<div>

    <div class="container-xxl flex-grow-1 container-p-y" wire:init="loadData">


        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Edit/</span> Update Product</h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><a href="{{ route('list.products') }}"
                                            class="btn btn-link"><span
                                    class="bx bx-left-arrow"></span></a> Edit {{ $model->name }}</h5>
                        <small class="text-muted float-end">Update Product</small>
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
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="category_id">Category</label>
                                    <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bx-category"></i></span>
                                        <select id="country_id" wire:model="category_id"
                                                class="select2 form-select @error('category_id') is-invalid @enderror"
                                                required>
                                            <option value="">Select</option>
                                            @foreach($categories as $category)
                                                <option value="{{ $category->id }}">{{ $category->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('category_id')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="sub_category_id">Sub Category</label>
                                    <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bxs-category"></i></span>
                                        <select id="country_id" wire:model="sub_category_id"
                                                class="select2 form-select @error('sub_category_id') is-invalid @enderror"
                                                required>
                                            <option value="">Select</option>
                                            @foreach($subCategories as $subCategory)
                                                <option value="{{ $subCategory->id }}">{{ $subCategory->name }}</option>
                                            @endforeach
                                        </select>
                                        @error('sub_category_id')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="form-label" for="name">Product Name</label>
                                    <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bxl-product-hunt"></i></span>
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
                                <div class="mb-3 col-12">
                                    <label class="form-label" for="cost">Product Cost</label>
                                    <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bxl-product-hunt"></i></span>
                                        <input type="number" id="cost"
                                               class="form-control @error('cost') is-invalid @enderror"
                                               required
                                               name="cost" placeholder="Enter cost..."
                                               wire:model="cost"
                                               aria-describedby="cost"/>
                                        @error('cost')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-12" wire:model.debounce.365ms="description" wire:ignore>
                                    <label class="form-label" for="description">Product Description</label>
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
                                    <label class="form-label" for="photo">Product Image <i class="text-info"><b>optional</b></i></label>
                                    <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bxs-image-add"></i></span>
                                        <input type="file" id="photo"
                                               class="form-control @error('photo') is-invalid @enderror"
                                               name="photo" placeholder="Product Image"
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
                                Update
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
