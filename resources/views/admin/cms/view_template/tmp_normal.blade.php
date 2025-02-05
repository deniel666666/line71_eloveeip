
<div class="articleBox w-100 position-relative
            {{$cmsItem['layout']['space']?'':'no_mb_spacing'}}
            {{$cmsItem['layout']['space_lr']?'':'p-0'}}
            color-control bg-{{$cmsItem['area_bg_color'] ?? '' }}

            col-lg-{{$cmsItem['seg']}} offset-lg-{{$cmsItem['pre_seg']}}
            @if ( $cmsItem['seg'] * 2 >= 12)
                col-md-12
            @elseif ( $cmsItem['seg'] * 3 >= 12)
                col-md-6
            @elseif ( $cmsItem['seg'] * 4 >= 12)
                col-md-3
            @else
                col-md-{{$cmsItem['seg'] * 2}}
            @endif

            @if ( $cmsItem['seg'] * 3 > 12)
                col-12
            @elseif ( $cmsItem['seg'] * 4 >= 12)
                col-6
            @elseif ( $cmsItem['seg'] * 6 >= 12)
                col-6
            @else
                col-4
            @endif

            {{ isset($cmsItem['min_height_pc']) ? 'min_height-pc-px'.$cmsItem['min_height_pc'] : ''}}
            {{ isset($cmsItem['min_height']) ? 'min_height-px'.$cmsItem['min_height'] : ''}}
            "

    style="
            @if ( $cmsItem['type'] === 'text')
                @if ( !empty($cmsItem['imageSrc']) )
                    background-image: url({{$cmsItem['imageSrc']}});
                @endif
            @endif
    "
>  
    @if($show_order)
        <div class="position-absolute w-100 order_btn" style="opacity: 0.5; z-index: 5"><span class="p-3 d-inline-block bg-dark text-light">排序：{{$cmsItem['order_id']}}</span></div>
    @endif
    <div class="h-100 d-flex flex-column 
                {{$cmsItem['area_align_lg'] ?? 'align-items-lg-start'}} 
                {{$cmsItem['area_align_v_lg'] ?? 'justify-content-lg-start'}} 

                {{$cmsItem['area_align'] ?? 'align-items-left'}} 
                {{$cmsItem['area_align_v'] ?? 'justify-content-start'}}">           
        <h4 class="{{$cmsItem['title']['show']?'':'d-none'}} {{$cmsItem['title']['space']?'p_mb_spacing':''}}
                   color-control color-{{$cmsItem['area_color'] ?? '' }} bg-{{$cmsItem['title']['bg_color'] ?? '' }}
                   text-{{$cmsItem['title']['align'] ?? '' }}
                   {{$cmsItem['title']['size'] ?? ''}}
                   {{$cmsItem['title']['indent'] ?? ''}}
                   mw-100"
            style="@if ( isset($cmsItem['title']['width']) )width: {{$cmsItem['title']['width']}}px;@endif"
        >
            <text class="{{$cmsItem['title']['bold'] ?? ''}} bborder-{{$cmsItem['title']['bborder_color'] ?? ''}}">
                @if (!empty($cmsItem['title']['text']) )
                    {!! $cmsItem['title']['text'] !!}
                @endif
            </text>
        </h4>

        @if ( $cmsItem['type'] === 'img')
            <div class="imgBox order-2 mw-100"
                 style="@if ( isset($cmsItem['template']['img_width']) )width: {{$cmsItem['template']['img_width']}}px;@endif">
                @if (!empty($cmsItem['imageSrc'] ) )
                    <a  class="d-flex w-100 
                        {{$cmsItem['img_align_lg'] ?? 'justify-content-lg-center'}}
                        {{$cmsItem['img_align'] ?? 'justify-content-center'}}"
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
                        <img class="mw-100 {{$cmsItem['img_ori_width'] ?? ''}}" 
                             src="{{$cmsItem['imageSrc']}}" onerror="initial_css_after_img_loaded()">
                    </a>
                @endif
            </div>
        @endif

        <div class="text_area mw-100 {{$cmsItem['cont']['indent'] ?? ''}}
                    color-control color-{{$cmsItem['area_color'] ?? '' }}
                    {{$cmsItem['cont']['size'] ?? ''}}
                    {{$cmsItem['cont']['show']?'':'d-none'}} {{$cmsItem['cont']['space']?'p_mb_spacing':''}}
                    {{$cmsItem['cont']['order_class'] ?? 'order-3'}}"
            style="@if ( isset($cmsItem['cont']['width']) )width: {{$cmsItem['cont']['width']}}px;@endif"
        >
            @if (!empty($cmsItem['cont']['text']) )
                {!! $cmsItem['cont']['text'] !!}
            @endif
        </div>
    </div>
</div>