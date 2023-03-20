<div>
    <div wire:poll.visible class="modal fade" id="cs-{{ $model->id }}" aria-labelledby="cs-{{ $model->id }}-label"
         tabindex="-1"
         style="display: none;" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="cs-{{ $model->id }}-label">{{ $model->firstName }} {{ $model->lastName }}
                        , {{ $model->career->name }} Application</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        <div class="col-6">
                            <div class="form-group">
                                <label for="email">Email Address</label>
                                <input type="email" id="email" class="form-control" value="{{ $model->email }}"
                                       readonly>
                            </div>
                            <div class="form-group">
                                <label for="phoneNumber">Phone Number</label>
                                <input type="text" id="phoneNumber" class="form-control"
                                       value="{{ $model->phoneNumber }}" readonly>
                            </div>
                        </div>
                        <div class="col-6">
                            <div class="form-group">
                                <label for="email">LinkedIn</label>
                                <input type="url" id="linkedInUrl" class="form-control"
                                       value="{{ $model->linkedInUrl }}" readonly>
                            </div>
                            <div class="form-group">
                                <label for="cv">CV</label>
                                <div class="input-group mb-2">
                                    <input type="text" class="form-control" id="cv" placeholder="{{ $model->media->pathNames[0] }}" readonly>
                                    <div class="input-group-prepend">
                                        <div class="input-group-text"><a href="{{ $model->media->pathUrls[0] }}"
                                                                         target="_blank"><i
                                                    class="bx bx-download me-1"></i></a></div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
