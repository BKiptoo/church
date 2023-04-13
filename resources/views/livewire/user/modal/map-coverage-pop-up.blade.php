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
                            <div id="map"></div>
                            <div id="capture"></div>
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

{{--        <script>--}}
{{--            var map;--}}
{{--            var src = '{{ $model->media->pathUrls[0] }}';--}}

{{--            function initMap() {--}}
{{--                map = new google.maps.Map(document.getElementById('map'), {--}}
{{--                    center: new google.maps.LatLng(-19.257753, 146.823688),--}}
{{--                    zoom: 2,--}}
{{--                    mapTypeId: 'terrain'--}}
{{--                });--}}

{{--                var kmlLayer = new google.maps.KmlLayer(src, {--}}
{{--                    suppressInfoWindows: true,--}}
{{--                    preserveViewport: false,--}}
{{--                    map: map--}}
{{--                });--}}
{{--                kmlLayer.addListener('click', function (event) {--}}
{{--                    var content = event.featureData.infoWindowHtml;--}}
{{--                    var testimonial = document.getElementById('capture');--}}
{{--                    testimonial.innerHTML = content;--}}
{{--                });--}}
{{--            }--}}
{{--            initMap();--}}
{{--        </script>--}}
{{--        <script async--}}
{{--                src="https://maps.googleapis.com/maps/api/js?key='.{{ env('GOOGLE_MAP_API') }}.'&callback=initMap">--}}
{{--        </script>--}}
    </div>
</div>
