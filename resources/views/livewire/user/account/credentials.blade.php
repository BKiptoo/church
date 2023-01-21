<div>

    <div class="container-xxl flex-grow-1 container-p-y">


        <h4 class="fw-bold py-3 mb-4"><span class="text-muted fw-light">Credentials/</span> Update Password</h4>

        <!-- Basic Layout -->
        <div class="row">
            <div class="col-xl-12">
                <div class="card mb-4">
                    <div class="card-header d-flex justify-content-between align-items-center">
                        <h5 class="mb-0">Password Change</h5>
                        <small class="text-muted float-end">Update password</small>
                    </div>
                    <div class="card-body">
                        <form wire:submit.prevent="submit">
                            <div class="mb-3">
                                <label class="form-label" for="password">New Password</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bx-lock-open"></i></span>
                                    <input type="password" id="password"
                                           class="form-control @error('password') is-invalid @enderror"
                                           required
                                           name="password"
                                           placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                           wire:model="password"
                                           aria-describedby="password"/>
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                    @error('password')
                                    <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
                                    @enderror
                                </div>
                            </div>
                            <div class="mb-3">
                                <label class="form-label" for="password_confirmation">Confirm Password</label>
                                <div class="input-group input-group-merge">
                                    <span id="basic-icon-default-fullname2" class="input-group-text"><i
                                            class="bx bx-lock"></i></span>
                                    <input type="password" id="password_confirmation" required
                                           class="form-control"
                                           name="password_confirmation"
                                           placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                                           wire:model="password_confirmation"
                                           aria-describedby="password_confirmation"/>
                                    <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
                                </div>
                            </div>
                            <button type="submit" class="btn btn-primary" wire:loading.class="disabled"
                                    wire:offline.attr="disabled"><span wire:target="loginUser"
                                                                       wire:loading.class="spinner-border text-secondary"></span>
                                Change
                            </button>
                        </form>
                    </div>
                </div>
            </div>
        </div>


    </div>
</div>
