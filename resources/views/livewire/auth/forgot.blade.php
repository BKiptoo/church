<div>
    <h4 class="mb-2 text-center">Forgot Password? 🔒</h4>
    <p class="mb-4 text-center">Enter your email and we'll send you instructions to reset your password</p>
    @include('inc.alert')
    <form class="mb-3" wire:submit.prevent="resetPassword">
        <div class="mb-3">
            <label for="email" class="form-label">Email</label>
            <input type="text" class="form-control @error('email') is-invalid @enderror" wire:model="email" id="email"
                   required
                   name="email" placeholder="Enter your email" autofocus>
            @error('email')
            <span class="invalid-feedback" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary d-grid w-100" wire:loading.class="disabled"
                wire:offline.attr="disabled"><span wire:target="loginUser"
                                                   wire:loading.class="spinner-border text-primary"></span>
            Send Reset
            Link
        </button>
    </form>
    <div class="text-center">
        <a href="{{ route('login') }}" class="d-flex align-items-center justify-content-center">
            <i class="bx bx-chevron-left scaleX-n1-rtl bx-sm"></i> Back to login
        </a>
    </div>
</div>
