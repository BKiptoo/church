<div>
    <div class="container-xxl flex-grow-1 container-p-y">
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Account Settings / </span> Profile
        </h4>
        <div class="row">
            <div class="col-md-12">
                <livewire:user.account.inc.settings-nav/>
                <div class="card mb-4" wire:poll.visible>
                    <h5 class="card-header">Profile Details</h5>
                    <form wire:submit.prevent="submit">
                        <hr class="my-0">
                        <div class="card-body">
                            <div class="row">
                                <div class="mb-3 col-md-12 text-center">
                                    <div class="button-wrapper">
                                        <label for="upload" tabindex="0">
                                            @if ($photo)
                                                <img
                                                    src="{{ $photo->temporaryUrl() }}"
                                                    class="d-block rounded" height="100" width="100"/>
                                            @else
                                                <img
                                                    src="{{ $user->media ? $user->media->pathUrls[0] : \App\Http\Controllers\SystemController::generateAvatars($user->slug,100) }}"
                                                    class="d-block rounded" height="100" width="100"/>
                                            @endif
                                            <input type="file" wire:model="photo" id="upload" class="account-file-input"
                                                   hidden
                                                   accept="image/png, image/jpeg, image/gif"/>
                                        </label>
                                        <p class="text-muted mb-0">Allowed JPG, GIF or PNG. Max size of 4MB's</p>
                                    </div>
                                </div>
                                <div wire:loading wire:target="photo"><span
                                        class="spinner-border spinner-border-sm"></span> Uploading
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="name" class="form-label">Full Name</label>
                                    <input class="form-control @error('name') is-invalid @enderror" type="text"
                                           name="name" id="name" wire:model="name" required/>
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="email" class="form-label">E-mail</label>
                                    <input type="email" class="form-control @error('email') is-invalid @enderror"
                                           wire:model="email" id="email"
                                           required
                                           name="email"
                                           placeholder="Enter your email...">
                                    @error('name')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label for="position" class="form-label">Position</label>
                                    <input class="form-control @error('position') is-invalid @enderror" type="text"
                                           name="position" id="position" wire:model="position" required/>
                                    @error('position')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                                <div class="mb-3 col-md-6">
                                    <label class="form-label" for="phoneNumber">Phone Number</label>
                                    <div class="input-group input-group-merge">
                                        <span class="input-group-text">{{ $user->country->data['short2Code'] }} (+{{ $user->country->data['callingCode'] }})</span>
                                        <input class="form-control @error('phoneNumber') is-invalid @enderror"
                                               type="text"
                                               name="phoneNumber" id="phoneNumber" wire:model="phoneNumber" required/>
                                        @error('phoneNumber')
                                        <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                        @enderror
                                    </div>
                                </div>
                            </div>
                            <div class="mt-2">
                                <button type="submit" class="btn btn-primary me-2" wire:loading.class="disabled"
                                        wire:offline.attr="disabled"><span wire:target="submit"
                                                                           wire:loading.class="spinner-border text-secondary"></span>
                                    Save changes
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
