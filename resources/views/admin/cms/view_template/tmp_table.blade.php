
<div class="w-100 position-relative">
    @if($show_order)
        <div class="position-absolute w-100 order_btn" style="opacity: 0.5; z-index: 5"><span class="p-3 d-inline-block bg-dark text-light">排序：{{$cmsItem['order_id']}}</span></div>
    @endif

	<div class="design-2 w-100 w1920">
		<section class="format2 wrap color-control bg-{{$cmsItem['template']['bg_color'] ?? '' }}">
            <div class="container w1400">
                <table class="format-table table">
                    <thead class="color-control"
                    	   data="bg-{{$cmsItem['template']['thead_bg_color'] ?? '' }}
                    			 color-{{$cmsItem['template']['thead_color'] ?? '' }}">
                        <tr>
                            @if( !empty($cmsItem['template']['thead1']) )
                                <th></th>
                            @endif
                            @if( !empty($cmsItem['template']['thead2']) )
                                <th>{{$cmsItem['template']['thead2'] ?? '' }}</th>
                            @endif
                            @if( !empty($cmsItem['template']['thead3']) )
                                <th>{{$cmsItem['template']['thead3'] ?? '' }}</th>
                            @endif
                            @if( !empty($cmsItem['template']['thead4']) )
                                <th>{{$cmsItem['template']['thead4'] ?? '' }}</th>
                            @endif
                        </tr>
                    </thead>
                    <tbody class="color-control"
                    	   data="color-{{$cmsItem['template']['tbody_color'] ?? '' }}">
                    	@if( !empty($cmsItem['template']['data1_1']) ||
                    		 !empty($cmsItem['template']['data1_2']) ||
                    		 !empty($cmsItem['template']['data1_3']) ||
                    		 !empty($cmsItem['template']['data1_4'])
                    	)
                        <tr>
                            @if( !empty($cmsItem['template']['thead1']) )
                                <td data-th="{{$cmsItem['template']['thead1'] ?? '' }}">
                                	{{$cmsItem['template']['data1_1'] ?? '' }}
                                </td>
                            @endif
                            @if( !empty($cmsItem['template']['thead2']) )
                                <td data-th="{{$cmsItem['template']['thead2'] ?? '' }}">
                            	   {{$cmsItem['template']['data1_2'] ?? '' }}
                                </td>
                            @endif
                            @if( !empty($cmsItem['template']['thead3']) )
                                <td data-th="{{$cmsItem['template']['thead3'] ?? '' }}">
                            	   {{$cmsItem['template']['data1_3'] ?? '' }}
                                </td>
                            @endif
                            @if( !empty($cmsItem['template']['thead4']) )
                                <td data-th="{{$cmsItem['template']['thead4'] ?? '' }}">
                            	   {{$cmsItem['template']['data1_4'] ?? '' }}
                                </td>
                            @endif
                        </tr>
                        @endif

                        @if( !empty($cmsItem['template']['data2_1']) ||
                    		 !empty($cmsItem['template']['data2_2']) ||
                    		 !empty($cmsItem['template']['data2_3']) ||
                    		 !empty($cmsItem['template']['data2_4'])
                    	)
                        <tr>
                            @if( !empty($cmsItem['template']['thead1']) )
                                <td data-th="{{$cmsItem['template']['thead1'] ?? '' }}">
                                	{{$cmsItem['template']['data2_1'] ?? '' }}
                                </td>
                            @endif
                            @if( !empty($cmsItem['template']['thead2']) )
                                <td data-th="{{$cmsItem['template']['thead2'] ?? '' }}">
                            	   {{$cmsItem['template']['data2_2'] ?? '' }}
                                </td>
                            @endif
                            @if( !empty($cmsItem['template']['thead3']) )
                                <td data-th="{{$cmsItem['template']['thead3'] ?? '' }}">
                            	   {{$cmsItem['template']['data2_3'] ?? '' }}
                                </td>
                            @endif
                            @if( !empty($cmsItem['template']['thead4']) )
                                <td data-th="{{$cmsItem['template']['thead4'] ?? '' }}">
                            	   {{$cmsItem['template']['data2_4'] ?? '' }}
                                </td>
                            @endif
                        </tr>
                        @endif

                        @if( !empty($cmsItem['template']['data3_1']) ||
                    		 !empty($cmsItem['template']['data3_2']) ||
                    		 !empty($cmsItem['template']['data3_3']) ||
                    		 !empty($cmsItem['template']['data3_4'])
                    	)
                        <tr>
                            @if( !empty($cmsItem['template']['thead1']) )
                                <td data-th="{{$cmsItem['template']['thead1'] ?? '' }}">
                                	{{$cmsItem['template']['data3_1'] ?? '' }}
                                </td>
                            @endif
                            @if( !empty($cmsItem['template']['thead2']) )
                                <td data-th="{{$cmsItem['template']['thead2'] ?? '' }}">
                            	   {{$cmsItem['template']['data3_2'] ?? '' }}
                                </td>
                            @endif
                            @if( !empty($cmsItem['template']['thead3']) )
                                <td data-th="{{$cmsItem['template']['thead3'] ?? '' }}">
                            	   {{$cmsItem['template']['data3_3'] ?? '' }}
                                </td>
                            @endif
                            @if( !empty($cmsItem['template']['thead4']) )
                                <td data-th="{{$cmsItem['template']['thead4'] ?? '' }}">
                            	   {{$cmsItem['template']['data3_4'] ?? '' }}
                                </td>
                            @endif
                        </tr>
                        @endif

                        @if( !empty($cmsItem['template']['data4_1']) ||
                    		 !empty($cmsItem['template']['data4_2']) ||
                    		 !empty($cmsItem['template']['data4_3']) ||
                    		 !empty($cmsItem['template']['data4_4'])
                    	)
                        <tr>
                            @if( !empty($cmsItem['template']['thead1']) )
                                <td data-th="{{$cmsItem['template']['thead1'] ?? '' }}">
                                	{{$cmsItem['template']['data4_1'] ?? '' }}
                                </td>
                            @endif
                            @if( !empty($cmsItem['template']['thead2']) )
                                <td data-th="{{$cmsItem['template']['thead2'] ?? '' }}">
                            	   {{$cmsItem['template']['data4_2'] ?? '' }}
                                </td>
                            @endif
                            @if( !empty($cmsItem['template']['thead3']) )
                                <td data-th="{{$cmsItem['template']['thead3'] ?? '' }}">
                            	   {{$cmsItem['template']['data4_3'] ?? '' }}
                                </td>
                            @endif
                            @if( !empty($cmsItem['template']['thead4']) )
                                <td data-th="{{$cmsItem['template']['thead4'] ?? '' }}">
                            	   {{$cmsItem['template']['data4_4'] ?? '' }}
                                </td>
                            @endif
                        </tr>
                        @endif

                        @if( !empty($cmsItem['template']['data5_1']) ||
                    		 !empty($cmsItem['template']['data5_2']) ||
                    		 !empty($cmsItem['template']['data5_3']) ||
                    		 !empty($cmsItem['template']['data5_4'])
                    	)
                        <tr>
                            @if( !empty($cmsItem['template']['thead1']) )
                                <td data-th="{{$cmsItem['template']['thead1'] ?? '' }}">
                                	{{$cmsItem['template']['data5_1'] ?? '' }}
                                </td>
                            @endif
                            @if( !empty($cmsItem['template']['thead2']) )
                                <td data-th="{{$cmsItem['template']['thead2'] ?? '' }}">
                            	   {{$cmsItem['template']['data5_2'] ?? '' }}
                                </td>
                            @endif
                            @if( !empty($cmsItem['template']['thead3']) )
                                <td data-th="{{$cmsItem['template']['thead3'] ?? '' }}">
                            	   {{$cmsItem['template']['data5_3'] ?? '' }}
                                </td>
                            @endif
                            @if( !empty($cmsItem['template']['thead4']) )
                                <td data-th="{{$cmsItem['template']['thead4'] ?? '' }}">
                            	   {{$cmsItem['template']['data5_4'] ?? '' }}
                                </td>
                            @endif
                        </tr>
                        @endif

                         @if( !empty($cmsItem['template']['data6_1']) ||
                    		 !empty($cmsItem['template']['data6_2']) ||
                    		 !empty($cmsItem['template']['data6_3']) ||
                    		 !empty($cmsItem['template']['data6_4'])
                    	)
                        <tr>
                            @if( !empty($cmsItem['template']['thead1']) )
                                <td data-th="{{$cmsItem['template']['thead1'] ?? '' }}">
                                	{{$cmsItem['template']['data6_1'] ?? '' }}
                                </td>
                            @endif
                            @if( !empty($cmsItem['template']['thead2']) )
                                <td data-th="{{$cmsItem['template']['thead2'] ?? '' }}">
                            	   {{$cmsItem['template']['data6_2'] ?? '' }}
                                </td>
                            @endif
                            @if( !empty($cmsItem['template']['thead3']) )
                                <td data-th="{{$cmsItem['template']['thead3'] ?? '' }}">
                            	   {{$cmsItem['template']['data6_3'] ?? '' }}
                                </td>
                            @endif
                            @if( !empty($cmsItem['template']['thead4']) )
                                <td data-th="{{$cmsItem['template']['thead4'] ?? '' }}">
                            	   {{$cmsItem['template']['data6_4'] ?? '' }}
                                </td>
                            @endif
                        </tr>
                        @endif
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</div>