
<div class="w-100 position-relative">
    @if($show_order)
        <div class="position-absolute w-100 order_btn" style="opacity: 0.5; z-index: 5"><span class="p-3 d-inline-block bg-dark text-light">排序：{{$cmsItem['order_id']}}</span></div>
    @endif


	@if($cmsItem['name']=='全版圖中')
		<div class="design-1 w-100 w1920">
			<div class="design-3">
				<section class="box2 color-control 
								bg-{{$cmsItem['template']['bg_color'] ?? '' }} color-{{$cmsItem['template']['text_color'] ?? '' }}">
					<div class="item-box">
					    <div class="container w1400">
					        <ul class="item">
					            <li class="first_child">
					                <div class="img" style="background-image: url({{$cmsItem['imageSrc'] ?? '' }});">
					                    <div class="txt">
					                        <h5 class="category">{{$cmsItem['template']['tilte_second'] ?? '' }}</h5>
					                        <h2 class="title">{{$cmsItem['template']['tilte_main'] ?? '' }}</h2>
					                        @if (!empty($cmsItem['template']['tilte_sub']) )
					                        <p>
					                        	{!! $cmsItem['template']['tilte_sub'] !!}
					                        </p>
					                        @endif
					                    </div>
					                </div>
					            </li>
					        </ul>
					    </div>
					</div>
				</section>
			</div>
		</div>
	@endif

	@if($cmsItem['name']=='全版圖下文')
		<div class="design-2 w-100 w1920">
			<section class="box5 wrap">
			    <div class="pro-item">
			        <ul class="items m-0">
			            <li class="last_child color-control
			            		   bg-{{$cmsItem['template']['bg_color'] ?? '' }} color-{{$cmsItem['template']['text_color'] ?? '' }}">
			                <div>
			                    <img src="{{$cmsItem['imageSrc'] ?? '' }}" class="img-fluid" onerror="initial_css_after_img_loaded()">
			                </div>
			                <div class="txt-box container w1400">
			                	<h4 class="category text-center">{{$cmsItem['template']['tilte_second'] ?? '' }}</h4>
			                    <h3>{{$cmsItem['template']['tilte_main'] ?? '' }}</h3>
			                    @if (!empty($cmsItem['template']['tilte_sub']) )
			                        <p>
			                        	{!! $cmsItem['template']['tilte_sub'] !!}
			                        </p>
		                        @endif
			                </div>
			            </li>
			        </ul>
			    </div>
			</section>
		</div>
	@endif

	@if($cmsItem['name']=='全版圖雙背色')
		<div class="design-2 w-100 w1920">
			<section class="box2 wrap color-control 
							bg-{{$cmsItem['template']['bg_color'] ?? '' }}">
	            <div class="item-box">
	                <div class="item-pro">
	                    <div class="item color-control 
	                    			bg-{{$cmsItem['template']['text_area_bg_color'] ?? '' }}
	                    			color-{{$cmsItem['template']['text_color'] ?? '' }}">
	                        <div class="txt-content">
	                            <div class="txt">
	                            	<h2 class="category text-center">{{$cmsItem['template']['tilte_second'] ?? '' }}</h2>
			                        <h2 class="subtitle color-control
	                                		   bg-{{$cmsItem['template']['tilte_bg_color'] ?? '' }}">
	                        		   {{$cmsItem['template']['tilte_main'] ?? '' }}
	                        		</h2>
	                                @if (!empty($cmsItem['template']['tilte_sub']) )
			                        <p>
			                        	{!! $cmsItem['template']['tilte_sub'] !!}
			                        </p>
			                        @endif
	                            </div>
	                        </div>
	                        <img src="{{$cmsItem['imageSrc'] ?? '' }}" class="img-fluid" onerror="initial_css_after_img_loaded()">
	                    </div>

	                </div>
	            </div>
	        </section>
	    </div>
	@endif

	@if($cmsItem['name']=='全版圖中字')
		<div class="design-2 w-100 w1920">
			<section class="box9 wrap">
	            <div class="gooditem color-control
	            			bg-{{$cmsItem['template']['bg_color'] ?? '' }}
	            			color-{{$cmsItem['template']['text_color'] ?? '' }}">
	                <div class="txt-content color-control bg-{{$cmsItem['template']['text_area_bg_color'] ?? '' }}">
	                	<h2 class="title mt-0 mb-3 p-0"><small>{{ $cmsItem['template']['tilte_second'] ?? '' }}</small></h2>
	                    <div class="txt">
	                        <h3>{{ $cmsItem['template']['tilte_main'] ?? '' }}</h3>
	                        @if (!empty($cmsItem['template']['tilte_sub']) )
	                        	<p>{!! $cmsItem['template']['tilte_sub'] !!}</p>
	                        @endif
	                    </div>
	                </div>
	                <div class="img" style="background-image: url({{$cmsItem['imageSrc']}});"></div>
	            </div>
	        </section>
	    </div>
	@endif

	@if($cmsItem['name']=='全版圖中區塊字')
		<div class="design-1 w-100 w1920">
	        <section class="piano-box">
	            <div class="design-3">
	            	<section class="box10 wrap">
	                    <div class="content color-control bg-{{$cmsItem['template']['bg_color'] ?? '' }}">
	                        <div class="img" style="background-image: url({{$cmsItem['imageSrc']}});">
	                            <div class="txt color-control
	                            			bg-{{$cmsItem['template']['text_area_bg_color'] ?? '' }}
	        								color-{{$cmsItem['template']['text_color'] ?? '' }}">
	                                <h2 class="title">{{ $cmsItem['template']['tilte_second'] ?? '' }}</h2>
	                                <h2 class="protitle">{{ $cmsItem['template']['tilte_main'] ?? '' }}</h2>
	                                @if (!empty($cmsItem['template']['tilte_sub']) )
			                        	<p>{!! $cmsItem['template']['tilte_sub'] !!}</p>
			                        @endif
	                            </div>
	                        </div>
	                    </div>
	                </section>
	            </div>
	        </section>
	    </div>
	@endif
</div>