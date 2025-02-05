
<div class="w-100 position-relative">
    @if($show_order)
        <div class="position-absolute w-100 order_btn" style="opacity: 0.5; z-index: 5"><span class="p-3 d-inline-block bg-dark text-light">排序：{{$cmsItem['order_id']}}</span></div>
    @endif

    <div class="design-2 w-100 w1920 tmp_fullimg_colortext">
    	<section class="format wrap @if($cmsItem['name']=='滿圖左色塊字右') reverse @endif
                        color-control bg-{{$cmsItem['template']['bg_color'] ?? '' }}">
            <div class="container w1400">
                <div class="row">
                    <div class="txt-content col-lg-6 col-12">
                        <div class="txt">
                            <h2 class="subtitle color-control 
                            		   bg-{{$cmsItem['template']['tilte_main_bg_color'] ?? '' }} 
                            		   color-{{$cmsItem['template']['tilte_main_color'] ?? '' }}">
                        		{{$cmsItem['template']['tilte_main'] ?? '' }}
                        	</h2>
                            <p>
                            	@if (!empty($cmsItem['template']['tilte_sub']) )
    			                    {!! $cmsItem['template']['tilte_sub'] !!}
    			                @endif
     						</p>
                            <!--
                            <p class="mt-4">
                                @if (!empty($cmsItem['template']['tilte_sub2']) )
    			                    {!! $cmsItem['template']['tilte_sub2'] !!}
    			                @endif
                            </p>
                            -->
                        </div>
                    </div>
                </div>
            </div>
            <div class="img-content" style="background-image: url({{$cmsItem['imageSrc'] ?? '' }});"></div>
        </section>
    </div>
</div>