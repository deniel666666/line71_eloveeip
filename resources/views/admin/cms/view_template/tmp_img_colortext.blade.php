
<div class="w-100 position-relative">
    @if($show_order)
        <div class="position-absolute w-100 order_btn" style="opacity: 0.5; z-index: 5"><span class="p-3 d-inline-block bg-dark text-light">排序：{{$cmsItem['order_id']}}</span></div>
    @endif

	<!-- 圖左色塊字右 -->
	<div class="design-1 w-100 w1920">
		<div class="piano-content">
		    <div class="info-item @if($cmsItem['name']=='圖右色塊字左') even @endif
		    			color-control bg-{{$cmsItem['template']['bg_color'] ?? '' }}">
		        <div class="w1400 container">
		            <div class="row">
		                <div class="img">
		                	<img src="{{$cmsItem['imageSrc'] ?? '' }}" onerror="initial_css_after_img_loaded()">
		                </div>
		                <div class="txt-box">
		                    <span class="pro-num color-control color-{{$cmsItem['template']['tilte_main_color'] ?? '' }}">
		                    	{{$cmsItem['template']['tilte_main'] ?? '' }}
		                    </span>
		                    <h2 class="subtitle color-control 
		                    		   bg-{{$cmsItem['template']['tilte_second_bg_color'] ?? '' }} 
		                    		   color-{{$cmsItem['template']['tilte_second_color'] ?? '' }}"
		                   	>
		                   		@if (!empty($cmsItem['template']['tilte_second']) )
				                    {!! $cmsItem['template']['tilte_second'] !!}
				                @endif
		                   	</h2>
		                    <div class="txt">
		                        <p class="color-control color-{{$cmsItem['template']['tilte_sub_color'] ?? '' }}">
		                        	@if (!empty($cmsItem['template']['tilte_sub']) )
					                    {!! $cmsItem['template']['tilte_sub'] !!}
					                @endif
		                        </p>
		                        <span class="note color-control 
		                        			 bg-{{$cmsItem['template']['tilte_sub2_bg_color'] ?? '' }}
		                        			 color-{{$cmsItem['template']['tilte_sub2_color'] ?? '' }}">
		                        	@if (!empty($cmsItem['template']['tilte_sub2']) )
					                    {!! $cmsItem['template']['tilte_sub2'] !!}
					                @endif
		                        </span>
		                    </div>
		                </div>
		            </div>
		        </div>
		    </div>
		</div>
	</div>
</div>