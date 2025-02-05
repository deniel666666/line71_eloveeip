
<div class="w-100 position-relative">
    @if($show_order)
        <div class="position-absolute w-100 order_btn" style="opacity: 0.5; z-index: 5"><span class="p-3 d-inline-block bg-dark text-light">排序：{{$cmsItem['order_id']}}</span></div>
    @endif

	<!-- 右滿圖左字 tmp_right_full_img_left_text -->
    <section class="box-home-1 box-home-1-r item-home color-control bg-{{$cmsItem['template']['bg_color'] ?? '' }}">
        <div class="txt-content color-control 
                    {{$cmsItem['template']['text_area_extend'] ?? 'container w1400 '}}
                    bg-{{$cmsItem['template']['bg_color'] ?? '' }} 
                    bg-pc-#none 
                    color-{{$cmsItem['template']['tilte_color'] ?? '' }} 
                    {{ isset($cmsItem['template']['text_align']) ? $cmsItem['template']['text_align'] : 'text-center'}}">
            <div class="txt">
                <div class="d-flex justify-content-lg-center justify-content-center">
                    <div class="mw-100" style="@if ( isset($cmsItem['template']['text_width']) )width: {{$cmsItem['template']['text_width']}}px;@endif">
                        <h2 class="title">{{$cmsItem['template']['tilte_second'] ?? '' }}</h2>
                        <h2 class="title">
                            <span class="{{$cmsItem['template']['tilte_main_big'] ?? ''}}">
                                {{$cmsItem['template']['tilte_main'] ?? '' }}
                            </span>
                            @if( isset($cmsItem['template']['tilte_sub']) ) {!! $cmsItem['template']['tilte_sub'] !!} @endif
                        </h2>
                        <p class="sale">{{$cmsItem['template']['tilte_small'] ?? '' }}</p>
                        
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
                    </div>
                </div>
            </div>
        </div>
        <div class="img-content"
             style="background-image:url('{{$cmsItem['imageSrc'] ?? '' }}');
                    min-height:{{$cmsItem['template']['img_min_height'] ?? ''}}px;
        ">
            <a  class="img-content_a position-absolute" 
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
            ></a>
        </div>
    </section>
</div>