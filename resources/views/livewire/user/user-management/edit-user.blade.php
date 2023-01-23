<div>

    <div class="container-xxl flex-grow-1 container-p-y" wire:init="loadData">


        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Edit/</span> Update User</h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0"><a href="{{ route('list.users') }}"
                                            class="btn btn-link"><span
                                    class="bx bx-left-arrow"></span></a> Edit {{ $user->name }}</h5>
                        <small class="text-muted float-end">Edit User</small>
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
                                            @foreach($countriesList as $country)
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
                                    <label class="form-label" for="name">Full Name</label>
                                    <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bx-user"></i></span>
                                        <input type="text" id="name"
                                               class="form-control @error('name') is-invalid @enderror"
                                               required
                                               name="name" placeholder="Enter name..."
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
                                    <label class="form-label" for="phoneNumber">Phone Number</label>
                                    <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bx-mobile"></i></span>
                                        <input type="text" id="phoneNumber"
                                               class="form-control @error('phoneNumber') is-invalid @enderror"
                                               required
                                               name="phoneNumber" placeholder="Enter phone number 0XXXXXXXX"
                                               wire:model="phoneNumber"
                                               aria-describedby="phoneNumber"/>
                                        @error('phoneNumber')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-6">
                                    <label class="form-label" for="email">E-mail Address</label>
                                    <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bx-envelope"></i></span>
                                        <input type="email" id="email"
                                               class="form-control @error('email') is-invalid @enderror"
                                               required
                                               name="email" placeholder="Enter email address"
                                               wire:model="email"
                                               aria-describedby="email"/>
                                        @error('email')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-12">
                                    <label class="form-label" for="position">Position</label>
                                    <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bxs-user-detail"></i></span>
                                        <input type="text" id="position"
                                               class="form-control @error('position') is-invalid @enderror"
                                               required
                                               name="position" placeholder="Enter position"
                                               wire:model="position"
                                               aria-describedby="position"/>
                                        @error('position')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                                <div class="mb-3 col-12">
                                    <input type="checkbox" class="form-check-input" id="exampleCheck1"
                                           {{ $isActive ? 'checked' : '' }}
                                           wire:model="isActive">
                                    <label class="switch pr-5 switch-primary mr-3"
                                           for="exampleCheck1">{{ $isActive ? 'Active' : 'In-Active' }}</label>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary me-2" wire:loading.class="disabled"
                                    wire:offline.attr="disabled"><span wire:target="submit"
                                                                       wire:loading.class="spinner-border text-secondary"></span>
                                Save
                            </button>
                            <hr class="my-5">
                            <div class="row">
                                <div class="col-md-6">
                                    <p class="card-description"><b class="text-decoration-underline">Assign User
                                            Privileges</b> <i class="text-info">selected
                                            <b>{{ count($accessRoles) }}</b></i></p>
                                    <fieldset>
                                        @foreach($permissions as $permission)
                                            <div class="mb-3">
                                                <label
                                                    class="switch pr-5 switch-primary mr-3">
                                                    <input type="checkbox"
                                                           value="{{ \Illuminate\Support\Str::slug($permission) }}"
                                                           wire:click="linkOrRemovePrivilege('{{ \Illuminate\Support\Str::slug($permission) }}')"
                                                           @if(in_array(\Illuminate\Support\Str::slug($permission), $accessRoles)) checked
                                                        @endif/><span
                                                        class="slider"></span> <span>&nbsp;{{ $permission }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </fieldset>
                                </div>
                                <div class="col-md-6">
                                    <p class="card-description"><b class="text-decoration-underline">Assign Countries
                                            Access</b> <i class="text-info">selected
                                            <b>{{ count($accessCountries) }}</b></i>

                                        <input type="search" wire:model="search" placeholder="Search..."
                                               class="form-control"></p>
                                    <fieldset>
                                        @foreach($countries as $country)
                                            <div class="mb-3">
                                                <label
                                                    class="switch pr-5 switch-primary mr-3">
                                                    <input type="checkbox"
                                                           value="{{ \Illuminate\Support\Str::slug($country->name) }}"
                                                           wire:click="linkOrRemoveCountry('{{ \Illuminate\Support\Str::slug($country->id) }}')"
                                                           @if(in_array(\Illuminate\Support\Str::slug($country->id), $accessCountries)) checked
                                                        @endif/><span
                                                        class="slider"></span> <span>&nbsp;{{ $country->name }}</span>
                                                </label>
                                            </div>
                                        @endforeach
                                    </fieldset>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
