<div>
    <h4 class="mb-2 text-center">Reset Password 🔒</h4>
    <p class="mb-4 text-center">Update your account credentials</p>
    @include('inc.alert')
    <form class="mb-3" wire:submit.prevent="resetPassword">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="email" class="form-control @error('email') is-invalid @enderror" wire:model="email" id="email" required
                   name="email"
                   placeholder="Enter your email..." autofocus>
            @error('email')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
        <div class="mb-3 form-password-toggle">
            <div class="d-flex justify-content-between">
                <label class="form-label" for="password">Password</label>
            </div>
            <div class="input-group input-group-merge">
                <input type="password" id="password" class="form-control @error('password') is-invalid @enderror" required
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
        <div class="mb-3 form-password-toggle">
            <div class="d-flex justify-content-between">
                <label class="form-label" for="password_confirmation">Confirm Password</label>
            </div>
            <div class="input-group input-group-merge">
                <input type="password" id="password_confirmation" required
                       class="form-control"
                       name="password_confirmation"
                       placeholder="&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;&#xb7;"
                       wire:model="password_confirmation"
                       aria-describedby="password_confirmation"/>
                <span class="input-group-text cursor-pointer"><i class="bx bx-hide"></i></span>
            </div>
        </div>
        <div class="mb-3">
            <button class="btn btn-primary d-grid w-100" type="submit" wire:loading.class="disabled"
                    wire:offline.attr="disabled"><span wire:target="resetPassword"
                                                       wire:loading.class="spinner-border text-primary"></span> Reset
                Password
            </button>
        </div>
    </form>
</div>
