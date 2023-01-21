<div>
    <div class="container-xxl flex-grow-1 container-p-y" wire:poll.visible>
        <h4 class="fw-bold py-3 mb-4">
            <span class="text-muted fw-light">Countries Settings / </span> Access
        </h4>
        <div class="row">
            <div class="col-md-12">
                <livewire:user.account.inc.settings-nav/>
                <div class="card">
                    <!-- Notifications -->
                    <h5 class="card-header">Access</h5>
                    <div class="card-body">
                        <span>This list shows what countries you can access.</span>
                        <div class="error"></div>
                    </div>
                    <div class="table-responsive">
                        <table class="table table-striped table-borderless border-bottom">
                            <thead>
                            <tr>
                                <th class="text-nowrap">Country Name</th>
                                <th class="text-nowrap">Status</th>
                            </tr>
                            </thead>
                            <tbody>
                            @foreach($user->userCountriesAccess as $userCountryAccess)
                                <tr>
                                    <td class="text-nowrap">{{ $userCountryAccess->country->name }}</td>
                                    <td>
                                        <input class="form-check-input" type="checkbox" id="defaultCheck1" disabled
                                               checked/>
                                    </td>
                                </tr>
                            @endforeach
                            </tbody>
                        </table>
                    </div>
                    <div class="card-body">
                        &nbsp;
                    </div>
                    <!-- /Notifications -->
                </div>
            </div>
        </div>
    </div>
</div>
