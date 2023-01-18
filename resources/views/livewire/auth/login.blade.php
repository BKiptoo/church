<div>
    <h4 class="mb-2 text-center">Welcome to {{ env('APP_NAME') }}! 👋</h4>
    <p class="mb-4 text-center">Please sign-in to your account and start the adventure</p>
    @include('inc.alert')
    <form class="mb-3" wire:submit.prevent="loginUser">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control @error('email') is-invalid @enderror" wire:model="email" id="email" required
                   name="email-username"
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
                <a href="{{ route('forgot') }}">
                    <small>Forgot Password?</small>
                </a>
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
        <div class="mb-3">
            <div class="form-check">
                <input class="form-check-input" type="checkbox" id="remember-me" wire:model="remember">
                <label class="form-check-label" for="remember-me">
                    Remember Me
                </label>
            </div>
        </div>
        <div class="mb-3">
            <button class="btn btn-primary d-grid w-100" type="submit" wire:loading.class="disabled"
                    wire:offline.attr="disabled"><span wire:target="loginUser"
                                                       wire:loading.class="spinner-border text-primary"></span> Sign in
            </button>
        </div>
    </form>
</div>
