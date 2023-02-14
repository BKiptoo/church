<div>
    <div wire:poll.visible class="modal fade" id="cs-{{ $model->id }}" aria-labelledby="cs-{{ $model->id }}-label"
         tabindex="-1"
         style="display: none;" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="cs-{{ $model->id }}-label">{{ $model->subject }}</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    {!! $model->description !!}
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
