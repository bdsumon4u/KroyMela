<div class="bg-white mb-4 border p-3 p-sm-4">
    <!-- Tabs -->
    <div class="nav aiz-nav-tabs">
        <a href="#tab_default_1" data-toggle="tab"
            class="mr-5 pb-2 fs-16 fw-700 text-reset active show">{{ translate('Description') }}</a>
        <a href="#tab_dp" data-toggle="tab"
            class="mr-5 pb-2 fs-16 fw-700 text-reset">{{ translate('Delivery & Payment') }}</a>
        @if ($detailedProduct->video_link != null)
            <a href="#tab_default_2" data-toggle="tab"
                class="mr-5 pb-2 fs-16 fw-700 text-reset">{{ translate('Video') }}</a>
        @endif
        @if ($detailedProduct->pdf != null)
            <a href="#tab_default_3" data-toggle="tab"
                class="mr-5 pb-2 fs-16 fw-700 text-reset">{{ translate('Downloads') }}</a>
        @endif
        <a href="#tab_default_review" data-toggle="tab"
            class="mr-5 pb-2 fs-16 fw-700 text-reset">{{ translate('Review') }}</a>
    </div>

    <!-- Description -->
    <div class="tab-content pt-0">
        <!-- Description -->
        <div class="tab-pane fade active show" id="tab_default_1">
            <div class="pt-2">
                <div class="mw-100 overflow-hidden text-left aiz-editor-data">
                    <?php echo $detailedProduct->getTranslation('description'); ?>
                </div>
            </div>
        </div>

        <!-- DP -->
        <div class="tab-pane fade" id="tab_dp">
            <div class="pt-2">
                <div class="mw-100 overflow-hidden text-left aiz-editor-data">
                    {!! nl2br(get_setting('delivery_payment')) !!}
                </div>
            </div>
        </div>

        <!-- Video -->
        <div class="tab-pane fade" id="tab_default_2">
            <div class="pt-2">
                <div class="embed-responsive embed-responsive-16by9">
                    @if ($detailedProduct->video_provider == 'youtube' && isset(explode('=', $detailedProduct->video_link)[1]))
                        <iframe class="embed-responsive-item"
                            src="https://www.youtube.com/embed/{{ get_url_params($detailedProduct->video_link, 'v') }}"></iframe>
                    @elseif ($detailedProduct->video_provider == 'dailymotion' && isset(explode('video/', $detailedProduct->video_link)[1]))
                        <iframe class="embed-responsive-item"
                            src="https://www.dailymotion.com/embed/video/{{ explode('video/', $detailedProduct->video_link)[1] }}"></iframe>
                    @elseif ($detailedProduct->video_provider == 'vimeo' && isset(explode('vimeo.com/', $detailedProduct->video_link)[1]))
                        <iframe
                            src="https://player.vimeo.com/video/{{ explode('vimeo.com/', $detailedProduct->video_link)[1] }}"
                            width="500" height="281" frameborder="0" webkitallowfullscreen
                            mozallowfullscreen allowfullscreen></iframe>
                    @endif
                </div>
            </div>
        </div>
        
        <!-- Download -->
        <div class="tab-pane fade" id="tab_default_3">
            <div class="pt-2 text-center ">
                <a href="{{ uploaded_asset($detailedProduct->pdf) }}"
                    class="btn btn-primary">{{ translate('Download') }}</a>
            </div>
        </div>
        <!-- Review -->
        <div class="tab-pane fade" id="tab_default_review">
            <div class="pt-2 ">
                <!-- Ratting -->
                <div class="border border-warning bg-soft-warning p-3 p-sm-4">
                    <div class="row align-items-center">
                        <div class="col-md-8 mb-3">
                            <div class="d-flex align-items-center justify-content-between justify-content-md-start">
                                <div class="w-100 w-sm-auto">
                                    <span class="fs-36 mr-3">{{ $detailedProduct->rating }}</span>
                                    <span class="fs-14 mr-3">{{ translate('out of 5.0') }}</span>
                                </div>
                                <div class="mt-sm-3 w-100 w-sm-auto d-flex flex-wrap justify-content-end justify-content-md-start">
                                    @php
                                        $total = 0;
                                        $total += $detailedProduct->reviews->count();
                                    @endphp
                                    <span class="rating rating-mr-1">
                                        {{ renderStarRating($detailedProduct->rating) }}
                                    </span>
                                    <span class="ml-1 fs-14">({{ $total }}
                                        {{ translate('reviews') }})</span>
                                </div>
                            </div>
                        </div>
                        <div class="col-md-4 text-right">
                            <a  href="javascript:void(0);" onclick="product_review('{{ $detailedProduct->id }}')" 
                                class="btn btn-warning fw-400 rounded-0 text-white">
                                <span class="d-md-inline-block"> {{ translate('Rate this Product') }}</span>
                            </a>
                        </div>
                    </div>
                </div>
                <!-- Reviews -->
                @include('frontend.product_details.reviews')
            </div>
        </div>
    </div>
</div>