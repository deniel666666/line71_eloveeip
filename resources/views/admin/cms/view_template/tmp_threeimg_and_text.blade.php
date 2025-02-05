
<div class="w-100 position-relative">
    @if($show_order)
        <div class="position-absolute w-100 order_btn" style="opacity: 0.5; z-index: 5"><span class="p-3 d-inline-block bg-dark text-light">排序：{{$cmsItem['order_id']}}</span></div>
    @endif


	@if($cmsItem['name']=='3圖文')
		<div class="design-1 w-100 w1920">
			<div class="design-3">
				<section class="box8 wrap">
			        <div class="txt-content color-control bg-{{$cmsItem['template']['bg_color'] ?? '' }}">
			            <div class="container w1400">
			                <div class="row">
			                    <div class="item color-control
			                    			bg-{{$cmsItem['template']['bg_color1'] ?? '' }}">
			                    	@if (!empty($cmsItem['template']['pic_1']) )
			                        	<div class="img" style="background-image: url({{$cmsItem['template']['pic_1']}});"></div>
			                        @endif

			                        @if ( !empty($cmsItem['template']['tilte_main']) || !empty($cmsItem['template']['content_1']) )
				                        <div class="txt">
			                            	@if (!empty($cmsItem['template']['tilte_main']) )
				                            <h2 class="protitle 
				                            		   color-control color-{{$cmsItem['template']['text_color1'] ?? '' }}
				                            		   text-{{$cmsItem['template']['tilte_main_align'] || 'left' }}">
			                            		{!! $cmsItem['template']['tilte_main'] !!}
				                            </h2>

				                            @endif
				                            @if (!empty($cmsItem['template']['content_1']) )
						                        <p>
						                        	{!! $cmsItem['template']['content_1'] !!}
						                        </p>
					                        @endif
				                        </div>
			                        @endif
			                    </div>
			                    <div class="item color-control
			                    			bg-{{$cmsItem['template']['bg_color2'] ?? '' }}">
			                        @if (!empty($cmsItem['template']['pic_2']) )
			                        	<div class="img" style="background-image: url({{$cmsItem['template']['pic_2']}});"></div>
			                        @endif

			                        @if ( !empty($cmsItem['template']['tilte_main2']) || !empty($cmsItem['template']['content_2']) )
				                        <div class="txt">
			                            	@if (!empty($cmsItem['template']['tilte_main2']) )
				                            <h2 class="protitle 
				                            		   color-control color-{{$cmsItem['template']['text_color2'] ?? '' }}
				                            		   text-{{$cmsItem['template']['tilte_main_align2'] || 'left' }}">
				                            		{!! $cmsItem['template']['tilte_main2'] !!}
				                            </h2>
				                            @endif
				                            @if (!empty($cmsItem['template']['content_2']) )
						                        <p>
						                        	{!! $cmsItem['template']['content_2'] !!}
						                        </p>
					                        @endif
				                        </div>
				                    @endif
			                    </div>
			                    <div class="item color-control
			                    			bg-{{$cmsItem['template']['bg_color3'] ?? '' }}">
			                        @if (!empty($cmsItem['template']['pic_3']) )
			                        	<div class="img" style="background-image: url({{$cmsItem['template']['pic_3']}});"></div>
			                        @endif

			                        @if ( !empty($cmsItem['template']['tilte_main3']) || !empty($cmsItem['template']['content_3']) )
				                        <div class="txt">
			                            	@if (!empty($cmsItem['template']['tilte_main3']) )
				                            <h2 class="protitle 
				                            		   color-control color-{{$cmsItem['template']['text_color3'] ?? '' }}
				                            		   text-{{$cmsItem['template']['tilte_main_align3'] || 'left' }}">
				                            		{!! $cmsItem['template']['tilte_main3'] !!}
				                            </h2>
				                            @endif
				                            @if (!empty($cmsItem['template']['content_3']) )
						                        <p>
						                        	{!! $cmsItem['template']['content_3'] !!}
						                        </p>
					                        @endif
				                        </div>
			                        @endif
			                    </div>
			                </div>
			            </div>
			        </div>
			    </section>
			</div>
		</div>
	@endif

	@if($cmsItem['name']=='1左2右' || $cmsItem['name']=='2左1右')
		<div class="design-1 w-100 w1920">
			<div class="design-3">
				<section class="box5 wrap">
					<div class="color-control color-control bg-{{$cmsItem['template']['bg_color'] ?? '' }}">
					    <div class="container w1400">
					        <div class="itembox txt-content @if($cmsItem['name']=='2左1右') reverse @endif">
					            <div class="item color-control
					            			bg-{{$cmsItem['template']['bg_color1'] ?? '' }}">
					            	@if (!empty($cmsItem['template']['pic_1']) )
					                	<div class="img">
					                		<img src="{{$cmsItem['template']['pic_1']}}" class="img-fluid" onerror="initial_css_after_img_loaded()">
					                	</div>
				                	@endif

				                	@if ( !empty($cmsItem['template']['tilte_main']) || !empty($cmsItem['template']['content_1']) )
						                <div class="txt">
						                	@if (!empty($cmsItem['template']['tilte_main']) )
						                    <h2 class="protitle
						                    		   color-control color-{{$cmsItem['template']['text_color1'] ?? '' }}
						                    		   text-{{$cmsItem['template']['tilte_main_align'] || 'left' }}">
						                    	{!! $cmsItem['template']['tilte_main'] !!}
						                    </h2>
						                    @endif
						                    @if (!empty($cmsItem['template']['content_1']) )
						                        <p>
						                        	{!! $cmsItem['template']['content_1'] !!}
						                        </p>
					                        @endif
						                </div>
			                        @endif
					            </div>
					            <div class="item color-control
					            			bg-{{$cmsItem['template']['bg_color2'] ?? '' }}">
					                <div class="w-100 m-0 row align-items-center">
					                	@if (!empty($cmsItem['template']['pic_2']) )
					                		<div class="col-md-6 order-md-1">
							                	<div class="img">
							                		<img src="{{$cmsItem['template']['pic_2']}}" class="img-fluid" onerror="initial_css_after_img_loaded()">
							                	</div>
							                </div>
					                	@endif
				                    	
				                    	@if ( !empty($cmsItem['template']['tilte_main2']) || !empty($cmsItem['template']['content_2']) )
						                    <div class="col-md-6">
						                        <div class="txt">
						                        	@if (!empty($cmsItem['template']['tilte_main2']) )
						                            <h2 class="protitle 
						                            	       color-control color-{{$cmsItem['template']['text_color2'] ?? '' }}
						                            	       text-{{$cmsItem['template']['tilte_main_align2'] || 'left' }}">
					                            		{!! $cmsItem['template']['tilte_main2'] !!}
						                            </h2>
						                            @endif
						                            @if (!empty($cmsItem['template']['content_2']) )
								                        <p>
								                        	{!! $cmsItem['template']['content_2'] !!}
								                        </p>
							                        @endif
						                        </div>
						                    </div>
				                        @endif
					                </div>
					            </div>
					        </div>
					    </div>
					</div>
				</section>
			</div>
		</div>
	@endif


	@if($cmsItem['name']=='1左1右')
		<div class="design-1 w-100 w1920">
			<div class="design-3">
				<section class="box5 wrap">
					<div class="color-control bg-{{$cmsItem['template']['bg_color'] ?? '' }}">
					    <div class="container w1400">
					        <div class="itembox2 txt-content">
					            <div class="item color-control
					            			bg-{{$cmsItem['template']['bg_color1'] ?? '' }}">
					                @if (!empty($cmsItem['template']['pic_1']) )
					                	<div class="img">
					                		<img src="{{$cmsItem['template']['pic_1']}}" class="img-fluid" onerror="initial_css_after_img_loaded()">
					                	</div>
				                	@endif

				                	@if ( !empty($cmsItem['template']['tilte_main']) || !empty($cmsItem['template']['content_1']) )
					                <div class="txt">
					                	@if (!empty($cmsItem['template']['tilte_main']) )
					                    <h2 class="protitle 
					                    		   color-control color-{{$cmsItem['template']['text_color1'] ?? '' }}
					                    		   text-{{$cmsItem['template']['tilte_main_align'] || 'left' }}">
					                    	{!! $cmsItem['template']['tilte_main'] !!}
					                    </h2>
					                    @endif
					                    
					                    @if (!empty($cmsItem['template']['content_1']) )
					                        <p>
					                        	{!! $cmsItem['template']['content_1'] !!}
					                        </p>
				                        @endif
					                </div>
					                @endif
					            </div>
					            <div class="item color-control
					            			bg-{{$cmsItem['template']['bg_color2'] ?? '' }}">
					            	@if (!empty($cmsItem['template']['pic_2']) )
						                <div class="img">
						                	<img src="{{$cmsItem['template']['pic_2']}}" class="img-fluid" onerror="initial_css_after_img_loaded()">
					                	</div>
					                @endif

					                @if ( !empty($cmsItem['template']['tilte_main2']) || !empty($cmsItem['template']['content_2']) )
					                <div class="txt">
					                	@if (!empty($cmsItem['template']['tilte_main2']) )
			                            <h2 class="protitle 
			                            		   color-control color-{{$cmsItem['template']['text_color2'] ?? '' }}
			                            		   text-{{$cmsItem['template']['tilte_main_align2'] || 'left' }}">
		                            		{!! $cmsItem['template']['tilte_main2'] !!}
			                            </h2>
			                            @endif
					                    @if (!empty($cmsItem['template']['content_2']) )
					                        <p>
					                        	{!! $cmsItem['template']['content_2'] !!}
					                        </p>
				                        @endif
					                </div>
					                 @endif
					            </div>
					        </div>
					    </div>
					</div>
				</section>
			</div>
		</div>
	@endif


	@if($cmsItem['name']=='滿圖文')
		<div class="design-1 w-100 w1920">
			<div class="design-3">
				<section class="box5 wrap">
					<div class="color-control bg-{{$cmsItem['template']['bg_color'] ?? '' }}">
					    <div class="container w1400">
					        <div class="itembox txt-content">
					            <div class="item color-control
					            			bg-{{$cmsItem['template']['bg_color1'] ?? '' }}">
					                @if (!empty($cmsItem['template']['pic_1']) )
					                	<div class="img">
					                		<img src="{{$cmsItem['template']['pic_1']}}" class="img-fluid" onerror="initial_css_after_img_loaded()">
					                	</div>
				                	@endif

				                	@if ( !empty($cmsItem['template']['tilte_main']) || !empty($cmsItem['template']['content_1']) )
					                <div class="txt">
					                	@if (!empty($cmsItem['template']['tilte_main']) )
					                    <h2 class="protitle 
					                    		   color-control color-{{$cmsItem['template']['text_color1'] ?? '' }}
					                    		   text-{{$cmsItem['template']['tilte_main_align'] || 'left' }}">
					                    	{!! $cmsItem['template']['tilte_main'] !!}
					                    </h2>
					                    @endif
					                    
					                    @if (!empty($cmsItem['template']['content_1']) )
					                        <p>
					                        	{!! $cmsItem['template']['content_1'] !!}
					                        </p>
				                        @endif
					                </div>
					                @endif
					            </div>
					        </div>
					    </div>
					</div>
				</section>
			</div>
		</div>
	@endif
</div>