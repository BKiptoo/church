<div>
    <div wire:poll.visible class="modal fade" id="mp-{{ $model->id }}" aria-labelledby="mp-{{ $model->id }}-label"
         tabindex="-1"
         style="display: none;" aria-hidden="true" wire:ignore.self>
        <div class="modal-dialog modal-dialog-centered modal-lg">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="mp-{{ $model->id }}-label">{{ $model->name }} Map Coverage</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <div class="row">
                        @if($model->media)
                            @foreach($model->media->pathUrls as $url)
                                <iframe width="750" height="500" style="border:0" loading="lazy" allowfullscreen
                                        src="https://maps.google.com/maps?q=7.53744,60.08929&z=15&output=embed">
                                </iframe>
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
