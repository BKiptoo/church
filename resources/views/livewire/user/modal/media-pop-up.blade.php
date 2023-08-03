<div>
    <div wire:poll.visible class="modal fade" id="cs-{{ $model->id }}" aria-labelledby="cs-{{ $model->id }}-label"
         tabindex="-1"
         style="display: none;" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title"
                        id="cs-{{ $model->id }}-label">{{ \Illuminate\Support\Str::limit($model->name,150) }}
                        Images/Files</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @if($model->media)
                            @foreach($model->media->pathUrls as $url)
                                <div class="col-md-3"><img
                                        class="d-block w-100 zoom_img" alt=""
                                        src="{{ $url }}"/>
                                </div>
                            @endforeach
                        @else
                            <img src="{{ asset('assets/img/no-items.gif') }}" alt="">
                        @endif
                    </div>
                </div>
                <div class="modal-footer">
                    <button class="btn btn-danger" data-bs-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</div>
