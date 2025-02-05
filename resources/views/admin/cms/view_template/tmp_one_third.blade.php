
<!-- 三分之一版 tmp_one_third -->
<section class="box-one_third item-home position-relative position-relative
				color-control bg-{{$cmsItem['template']['bg_color'] ?? '' }}">
    @if($show_order)
        <div class="position-absolute w-100 order_btn" style="opacity: 0.5; z-index: 5"><span class="p-3 d-inline-block bg-dark text-light">排序：{{$cmsItem['order_id']}}</span></div>
    @endif
    <div class="bgblock color-control bg-{{$cmsItem['template']['bg_color'] ?? '' }}"></div>
    <div class="w455">
        <div class="txt-content color-control color-{{$cmsItem['template']['tilte_color'] ?? '' }}
                    {{ isset($cmsItem['template']['text_align']) ? $cmsItem['template']['text_align'] : 'text-center'}}">
            <div class="txt mw-100" 
                 style="@if ( isset($cmsItem['template']['text_width']) )width: {{$cmsItem['template']['text_width']}}px;@endif">
                <h2 class="title">{{$cmsItem['template']['tilte_second'] ?? '' }}</h2>
                <h2 class="title">
                    <span class="{{$cmsItem['template']['tilte_main_big'] ?? ''}}">
                        {{$cmsItem['template']['tilte_main'] ?? '' }}
                    </span>
                    @if( isset($cmsItem['template']['tilte_sub']) ) {!! $cmsItem['template']['tilte_sub'] !!} @endif
                </h2>
                <p class="sale"> {{$cmsItem['template']['tilte_small'] ?? '' }}</p>
            
                @if( isset($cmsItem['template']['btn_text']) )
                    @if( $cmsItem['template']['btn_text'] )
                    <div class="btn_area">
                        <a  @if( isset($cmsItem['template']['btn_link']) )
                                @if( $cmsItem['template']['btn_link'] )
                                    href="{{$cmsItem['template']['btn_link']}}" 
                                @endif
                            @endif
                            @if( isset($cmsItem['template']['btn_link_open']) )
                                @if( $cmsItem['template']['btn_link_open'] )
                                    target="_blank" 
                                @endif
                            @endif
                            class="btn btn-buy color-control 
                                   bg-{{$cmsItem['template']['btn_bg_color'] ?? '' }}
                                   color-{{$cmsItem['template']['btn_color'] ?? '' }}"
                        >
                            {{$cmsItem['template']['btn_text'] ?? '' }}
                        </a>
                    </div>
                    @endif
                @endif

                @if( isset($cmsItem['template']['atext_text']) )
                    @if( $cmsItem['template']['atext_text'] )
                    <a  @if( isset($cmsItem['template']['atext_link']) )
                            @if( $cmsItem['template']['atext_link'] )
                                href="{{$cmsItem['template']['atext_link']}}" 
                            @endif
                        @endif
                        @if( isset($cmsItem['template']['atext_link_open']) )
                            @if( $cmsItem['template']['atext_link_open'] )
                                target="_blank" 
                            @endif
                        @endif
                        class="btn-more color-control 
                               color-{{$cmsItem['template']['atext_color'] ?? '' }}"
                    >
                       {{$cmsItem['template']['atext_text'] ?? '' }}
                    </a>
                    @endif
                @endif

                <div class="d-flex justify-content-center mt-3">
                    <div class="intro_img">
                        <a  class="img-content_a" 
                            @if( isset($cmsItem['img_link']) )
                                @if( $cmsItem['img_link'] )
                                    href="{{$cmsItem['img_link']}}" 
                                @endif
                            @endif

                            @if( isset($cmsItem['img_link_open']) )
                                @if( $cmsItem['img_link_open'] )
                                    target="_blank" 
                                @endif
                            @endif
                        >
                            @if( $cmsItem['imageSrc'] )
                                <img src="{{$cmsItem['imageSrc'] ?? '' }}" onerror="initial_css_after_img_loaded()">
                            @endif
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>