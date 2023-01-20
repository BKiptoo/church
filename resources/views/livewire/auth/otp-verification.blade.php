<div>
    <h4 class="mb-2 text-center">Verify Otp 🔒</h4>
    <p class="mb-4 text-center">Account two-factor authentication.</p>
    @include('inc.alert')
    <form class="mb-3" wire:submit.prevent="submit">
        <div class="mb-3">
            <label for="otp" class="form-label">OTP</label>
            <input type="number" class="form-control @error('otp') is-invalid @enderror" wire:model="otp" id="otp" required
                   name="otp" placeholder="Enter your otp..." autofocus>
            @error('otp')
            <span class="invalid-feedback text-center" role="alert">
                                        <strong>{{ $message }}</strong>
                                    </span>
            @enderror
        </div>
        <button type="submit" class="btn btn-primary d-grid w-100" wire:loading.class="disabled"
                wire:offline.attr="disabled"><span wire:target="loginUser"
                                                   wire:loading.class="spinner-border text-primary"></span> Verify
        </button>
    </form>
    <div class="text-center">
        <button wire:click="resend" type="button" class="btn btn-warning d-grid w-100" wire:loading.class="disabled"
                wire:offline.attr="disabled"><span wire:target="resend"
                                                   wire:loading.class="spinner-border text-primary"></span> Resend
        </button>
    </div>
</div>
