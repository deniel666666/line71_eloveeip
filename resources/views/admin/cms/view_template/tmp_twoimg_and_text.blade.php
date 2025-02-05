
<div class="w-100 position-relative">
    @if($show_order)
        <div class="position-absolute w-100 order_btn" style="opacity: 0.5; z-index: 5"><span class="p-3 d-inline-block bg-dark text-light">排序：{{$cmsItem['order_id']}}</span></div>
    @endif


	@if($cmsItem['name']=='雙圖中')
		<div class="design-1 w-100 w1920">
			<div class="design-3">
				<section class="box2 color-control 
								bg-{{$cmsItem['template']['bg_color'] ?? '' }} color-{{$cmsItem['template']['tilte_main_color'] ?? '' }}">
					<div class="item-box">
					    <div class="container w1400">
					        <ul class="item">
					            <li class="">
					                <div class="img" style="background-image: url({{$cmsItem['imageSrc'] ?? '' }});">
					                    <div class="txt">
					                        <h5 class="category">
					                        	@if (!empty($cmsItem['template']['tilte_second']) )
			                            			{!! $cmsItem['template']['tilte_second'] !!}
			                            		@endif
					                    	</h5>
					                        <h2 class="title">{{$cmsItem['template']['tilte_main'] ?? '' }}</h2>
					                        @if (!empty($cmsItem['template']['tilte_sub']) )
					                        <p>
					                        	{!! $cmsItem['template']['tilte_sub'] !!}
					                        </p>
					                        @endif
					                        @if (!empty($cmsItem['template']['tilte_sub2']) )
					                        	<p>
				                                	{!! $cmsItem['template']['tilte_sub2'] !!}
				                            	</p>
				                            @endif
					                    </div>
					                </div>
					            </li>
					            <li class="">
					                <div class="img" style="background-image: url({{$cmsItem['template']['pic_1'] ?? '' }});">
					                    <div class="txt">
					                        <h5 class="category">
					                        	@if (!empty($cmsItem['template']['tilte_second2']) )
			                            			{!! $cmsItem['template']['tilte_second2'] !!}
			                            		@endif
					                        </h5>
					                        <h2 class="title">{{$cmsItem['template']['tilte_main2'] ?? '' }}</h2>
					                        @if (!empty($cmsItem['template']['tilte_sub_2']) )
					                        <p>
					                        	{!! $cmsItem['template']['tilte_sub_2'] !!}
					                        </p>
					                        @endif
					                        @if (!empty($cmsItem['template']['tilte_sub2_2']) )
					                        	<p>
				                                	{!! $cmsItem['template']['tilte_sub2_2'] !!}
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

	@if($cmsItem['name']=='雙上圖')
		<div class="design-1 w-100 w1920">
			<section class="piano-box">
				<div class="design-3">
					<section class="box9 wrap">
	                    <div class="itembox color-control
	                    			bg-{{$cmsItem['template']['bg_color'] ?? '' }} color-{{$cmsItem['template']['tilte_main_color'] ?? '' }}">
	                        <div class="container w1400">
	                            <div class="row">
	                                <div class="col-md-6">
	                                    <div class="img">
	                                        <img src="{{$cmsItem['imageSrc'] ?? '' }}" onerror="initial_css_after_img_loaded()">
	                                    </div>
	                                    <div class="txt">
	                                        <h2 class="title">
	                                        	@if (!empty($cmsItem['template']['tilte_second']) )
			                            			{!! $cmsItem['template']['tilte_second'] !!}
			                            		@endif
	                                        </h2>
	                                        <h2 class="protitle">{{$cmsItem['template']['tilte_main'] ?? '' }}</h2>
	                                        @if (!empty($cmsItem['template']['tilte_sub']) )
					                        <p>
					                        	{!! $cmsItem['template']['tilte_sub'] !!}
					                        </p>
					                        @endif
					                        @if (!empty($cmsItem['template']['tilte_sub2']) )
					                        	<p>
				                                	{!! $cmsItem['template']['tilte_sub2'] !!}
				                            	</p>
				                            @endif
	                                    </div>
	                                </div>
	                                <div class="col-md-6">
	                                    <div class="img">
	                                        <img src="{{$cmsItem['template']['pic_1'] ?? '' }}" onerror="initial_css_after_img_loaded()">
	                                    </div>
	                                    <div class="txt">
	                                        <h2 class="title">
	                                        	@if (!empty($cmsItem['template']['tilte_second2']) )
			                            			{!! $cmsItem['template']['tilte_second2'] !!}
			                            		@endif
	                                        </h2>
	                                        <h2 class="protitle">{{$cmsItem['template']['tilte_main2'] ?? '' }}</h2>
	                                        @if (!empty($cmsItem['template']['tilte_sub_2']) )
					                        <p>
					                        	{!! $cmsItem['template']['tilte_sub_2'] !!}
					                        </p>
					                        @endif
					                        @if (!empty($cmsItem['template']['tilte_sub2_2']) )
					                        	<p>
				                                	{!! $cmsItem['template']['tilte_sub2_2'] !!}
				                            	</p>
				                            @endif
	                                    </div>
	                                </div>
	                            </div>
	                        </div>
	                    </div>
	                </section>
				</div>
			</section>
		</div>
	@endif

	@if($cmsItem['name']=='雙圖下文')
		<div class="design-2 w-100 w1920">
			<section class="box5 wrap">
			    <div class="pro-item">
			        <ul class="items m-0">
			            <li class="color-control
			            		   bg-{{$cmsItem['template']['bg_color'] ?? '' }} color-{{$cmsItem['template']['tilte_main_color'] ?? '' }}">
			                <div>
			                    <img src="{{$cmsItem['imageSrc'] ?? '' }}" class="img-fluid" onerror="initial_css_after_img_loaded()">
			                </div>
			                <div class="txt-box container w1400">
			                	<h4 class="category text-center">
			                		@if (!empty($cmsItem['template']['tilte_second']) )
                            			{!! $cmsItem['template']['tilte_second'] !!}
                            		@endif
                            	</h4>
			                    <h3>{{$cmsItem['template']['tilte_main'] ?? '' }}</h3>
			                    @if (!empty($cmsItem['template']['tilte_sub']) )
			                        <p class="text-center">
			                        	{!! $cmsItem['template']['tilte_sub'] !!}
			                        </p>
		                        @endif
			                </div>
			            </li>
			            <li class="color-control
			            		   bg-{{$cmsItem['template']['bg_color2'] ?? '' }} color-{{$cmsItem['template']['tilte_main_color2'] ?? '' }}">
			                <div>
			                    <img src="{{$cmsItem['template']['pic_1'] ?? '' }}" class="img-fluid" onerror="initial_css_after_img_loaded()">
			                </div>
			                <div class="txt-box container w1400">
			                	<h4 class="category text-center">
			                		@if (!empty($cmsItem['template']['tilte_second2']) )
                            			{!! $cmsItem['template']['tilte_second2'] !!}
                            		@endif
			                	</h4>
			                    <h3>{{$cmsItem['template']['tilte_main2'] ?? '' }}</h3>
			                    @if (!empty($cmsItem['template']['tilte_sub_2']) )
			                        <p class="text-center">
			                        	{!! $cmsItem['template']['tilte_sub_2'] !!}
			                        </p>
		                        @endif
			                </div>
			            </li>
			        </ul>
			    </div>
			</section>
		</div>
	@endif

	@if($cmsItem['name']=='雙圖雙背色')
		<div class="design-2 w-100 w1920">
			<section class="box2 wrap color-control bg-{{$cmsItem['template']['bg_color'] ?? '' }}">
	            <div class="item-box">
	                <div class="item-pro">
	                    <div class="item color-control 
	                    			bg-{{$cmsItem['template']['text_area_bg_color'] ?? '' }}
	                    			color-{{$cmsItem['template']['tilte_main_color'] ?? '' }}">
	                        <div class="txt-content">
	                            <div class="txt">
	                            	<h2 class="category text-center">
	                            		@if (!empty($cmsItem['template']['tilte_second']) )
	                            			{!! $cmsItem['template']['tilte_second'] !!}
	                            		@endif
	                            	</h2>
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
	                    <div class="item color-control
	                    			bg-{{$cmsItem['template']['text_area_bg_color'] ?? '' }}
	                    			color-{{$cmsItem['template']['tilte_main_color'] ?? '' }}">
	                        <div class="txt-content">
	                            <div class="txt">
	                            	<h2 class="category text-center">
	                            		@if (!empty($cmsItem['template']['tilte_second2']) )
	                            			{!! $cmsItem['template']['tilte_second2'] !!}
	                            		@endif
	                            	</h2>
	                                <h2 class="subtitle color-control
	                                		   bg-{{$cmsItem['template']['tilte_bg_color'] ?? '' }}">
	                                	{{$cmsItem['template']['tilte_main2'] ?? '' }}
	                                </h2>
	                                @if (!empty($cmsItem['template']['tilte_sub_2']) )
				                        <p>
				                        	{!! $cmsItem['template']['tilte_sub_2'] !!}
				                        </p>
			                        @endif
	                            </div>
	                        </div>
	                        <img src="{{$cmsItem['template']['pic_1'] ?? '' }}" class="img-fluid" onerror="initial_css_after_img_loaded()">
	                    </div>
	                </div>
	            </div>
	        </section>
	    </div>
	@endif
</div>