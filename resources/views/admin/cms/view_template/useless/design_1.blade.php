<div class="container articleEditorBox w1920">	
	<div class="design-1 w1920">
	    <!-- 圖文介紹-1 -->
	    <section class="box1 wrap">
	    	@if ( !$cms[0]['template']['hide'] && !empty($cms[0]['imageSrc']) )
	        <div class="img"><img src="{{$cms[0]['imageSrc']}}" alt="" class="w-100" onerror="initial_css_after_img_loaded()"></div>
	        @endif
	        
	    	@if ( !$cms[1]['template']['hide'] )
	        <div class="txt-content color-control bg-{{$cms[1]['template']['bg_color'] ?? '' }}">
	            <div class="container w1400">
	                <div class="row">
	                    <h2 class="title color-control color-{{$cms[1]['template']['tilte_main_color'] ?? '' }}">
	                    	{{$cms[1]['template']['tilte_main'] ?? '' }}
	                    </h2>
	                    <h4 class="subtitle color-control 
	                    		   bg-{{$cms[1]['template']['title_sub_bg'] ?? '' }} color-{{$cms[1]['template']['title_sub_color'] ?? '' }}">
            		   		@if ( isset($cms[1]['template']['title_sub']) )
	                    		{!! $cms[1]['template']['title_sub'] !!}
	                    	@endif
	                    </h4>
	                    
	                    <div class="txt color-control color-{{$cms[1]['template']['content_color'] ?? '' }}">
	                        {!! $cms[1]['cont']['text'] !!}
	                    </div>
	                </div>   
	            </div>
	        </div>
	        @endif

	        @if ( !$cms[2]['template']['hide'] && !empty($cms[2]['imageSrc']) )
	        <div class="img"><img src="{{$cms[2]['imageSrc']}}" alt="" class="w-100" onerror="initial_css_after_img_loaded()"></div>
	        @endif

	        @if ( !$cms[3]['template']['hide'] && !empty($cms[3]['imageSrc']) )
	        <div class="img"><img src="{{$cms[3]['imageSrc']}}" alt="" class="w-100" onerror="initial_css_after_img_loaded()"></div>
	        @endif

	        @if ( !$cms[4]['template']['hide'] && !empty($cms[4]['imageSrc']) )
	        <div class="img"><img src="{{$cms[4]['imageSrc']}}" alt="" class="w-100" onerror="initial_css_after_img_loaded()"></div>
	        @endif
	    </section>

	    {{-- 
		    <!-- 影片 -->
		    <div class="iframe-rwd mov">
		        <iframe width="560" height="315" src="https://www.youtube.com/embed/0R-urRwGygg" title="YouTube video player"
		            frameborder="0" allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
		            allowfullscreen></iframe>
		    </div>
		    
		    <!-- 圖文介紹-2 -->
		    <section class="box2">
		        <section class="wrap">
		            <div class="txt-content color-control bg-#323333 color-#ffffff">
		                <div class="container w1400">
		                    <div class="row">
		                        <h2 class="title">攜手合作 獨具匠心</h2>
		                    </div>
		                </div>
		            </div>
		            <div class="item-content-1 color-control bg-#0b1216">
		                <div class="txt-content">
		                    <div class="container w1400">
		                        <div class="row">
		                            <h4 class="subtitle color-control bg-#ffffff #191919">杉田健司音色概念</h4>
		                            <div class="txt color-control color-#ffffff">
		                                <p>杉田健司為吉他未來系列「一體共振」空氣的波動，撥弦後釋放出來的波動，首先面板達到共振，可以和周邊琴身，琴柄，琴頭一層一層達到共振，而帶動出美妙的音色。光透面板厚度控制在2.5mm，力木設計要能夠穩定面板，防止變型和支撐弦的張力。
		                                    經過三年來反覆的調校，做出清晰有彈性的音色，消除木頭硬硬的音色。</p>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		                <div class="img">
		                    <img src="http://anuenuemusic.event2007.com/frontEndPackage/images/design1-5.jpg" alt="" class="img-fluid w-100">
		                </div>
		            </div>
		            

		            <div class="item-content-2  color-control bg-#444444">
		                <div class="txt-content">
		                    <div class="container w1400">
		                        <div class="row">
		                            <h4 class="subtitle color-control bg-#ffffff #191919">歷時5年全新改良 / 旅行的好夥伴</h4>
		                            <div class="txt color-control color-#ffffff">
		                                <p>aNueNue自2015設計至今，歷時5年的研究改良，並將從手工製琴大師杉田健司的合作中，所學到的技巧與技術吸收與融合，重新給予旅行吉他新的定義。2020全新大進化。將36吋的旅行吉他重新設計再升級，顛覆大家對小吉他的想像。重新調整過的琴頭大小與琴橋造型，悉心設計的全新比例與力木結構，不僅提升整體的共鳴與音色，對延音也有更細膩的表現，帶來更和諧的美聲。
		                                </p>
		                                <p>讓小小的旅行吉他也能有大大的聲量。讓喜愛音樂的您每趟旅程都想帶著『吉他旅行』去。</p>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		            <div class="item-content-2 color-control bg-#191919">
		                <div class="img">
		                    <img src="http://anuenuemusic.event2007.com/frontEndPackage/images/design1-6.jpg" alt="" class="img-fluid w-100">
		                </div>
		                <div class="txt-content">
		                   
		                    <div class="container w1400">
		                        <div class="row">
		                           
		                            <div class="txt color-control color-#ffffff">
		                                <p>AAAA杉田健司為吉他未來系列「一體共振」空氣的波動，撥弦後釋放出來的波動，首先面板達到共振，可以和周邊琴身，琴柄，琴頭一層一層達到共振，而帶動出美妙的音色。光透面板厚度控制在2.5mm，力木設計要能夠穩定面板，防止變型和支撐弦的張力。
		                                    經過三年來反覆的調校，做出清晰有彈性的音色，消除木頭硬硬的音色。</p>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		               
		            </div>
		        </section>
		    </section>

		    <!-- 產品介紹 -->
		    <section class="piano-box">
		        <section class="box2 wrap">
		            <div class="txt-content color-control bg-#323333 color-#ffffff">
		                <div class="container w1400">
		                    <div class="row">
		                        <h2 class="title">嚴選木材 品質可靠</h2>
		                    </div>
		                </div>
		            </div>
		        </section>
		        <!-- 手工製琴師之路 -->
		        <section class="box3 wrap">
		            <div class="txt-content color-control bg-#191919 color-#ffffff">
		                <div class="container w1400">
		                    <div class="row">
		                        <h2 class="sub-protitle color-control bg-#806c54 color-#ffffff">手工製琴師之路</h2>
		                        <div class="txt color-control color-#ffffff" style="color: rgb(255, 255, 255);">
		                            <p>aNueNue自2015設計至今，歷時5年的研究改良，並將從手工製琴大師杉田健司的合作中，所學到的技巧與技術吸收與融合，重新給予旅行吉他新的定義。2020全新大進化。將36吋的旅行吉他重新設計再升級，顛覆大家對小吉他的想像。重新調整過的琴頭大小與琴橋造型，悉心設計的全新比例與力木結構，不僅提升整體的共鳴與音色，對延音也有更細膩的表現，帶來更和諧的美聲。
		                            </p>
		                        </div>
		                        <div class="txt color-control color-#ffffff" style="color: rgb(255, 255, 255);">
		                            <p>aNueNue自2015設計至今，歷時5年的研究改良，並將從手工製琴大師杉田健司的合作中，所學到的技巧與技術吸收與融合，重新給予旅行吉他新的定義。2020全新大進化。將36吋的旅行吉他重新設計再升級，顛覆大家對小吉他的想像。重新調整過的琴頭大小與琴橋造型，悉心設計的全新比例與力木結構，不僅提升整體的共鳴與音色，對延音也有更細膩的表現，帶來更和諧的美聲。
		                            </p>
		                        </div>
		                    </div>
		                </div>
		            </div>
		            <div class="pro-item">
		                <ul class="items">
		                    <li>
		                        <div>
		                            <img src="http://anuenuemusic.event2007.com/frontEndPackage/images/Piano1.jpg" alt="" class="img-fluid w-100">
		                        </div>
		                    </li>
		                    <li>
		                        <div>
		                            <img src="http://anuenuemusic.event2007.com/frontEndPackage/images/Piano2.jpg" alt="" class="img-fluid w-100">
		                        </div>
		                    </li>
		                </ul>
		            </div>
		        </section>



		        <!-- 琴身材質 -->
		        <section class="wrap info-1">
		            <div class="txt-content color-control bg-#eaeaea">
		                <div class="container w1400">
		                    <div class="row">
		                        <h2 class="sub-protitle color-control bg-#444444 color-#ffffff"><span>琴身材質</span></h2>
		                    </div>
		                </div>
		            </div>
		            <div class="piano-content">
		                <div class="info-item color-control bg-#f5f5f5">
		                    <div class="w1400 container">
		                        <div class="row">
		                            <div class="img"><img src="http://anuenuemusic.event2007.com/frontEndPackage/images/Piano1.jpg" alt=""></div>
		                            <div class="txt-box">
		                                <span class="pro-num color-control color-#888888">M52</span>
		                                <h2 class="subtitle color-control bg-#888888 color-#ffffff">西西加雲杉木+相思木</h2>
		                                <div class="txt">
		                                    <p class="color-control color-#191919">西加雲杉木與相思木的聲音特性結合在聲音的平衡上有不錯的表現，音色甜美且具穿透力。</p>
		                                    <span class="note color-control bg-#f5e45f">微妙的中頻遞減和圓潤的低頻，音色適合各種演奏彈唱，特別適合喜愛刷和弦的朋友</span>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		                <div class="info-item color-control bg-#ebebeb">
		                    <div class="w1400 container">
		                        <div class="row">
		                            <div class="img"><img src="http://anuenuemusic.event2007.com/frontEndPackage/images/Piano2.jpg" alt=""></div>
		                            <div class="txt-box">
		                                <span class="pro-num color-control color-#888888">M60</span>
		                                <h2 class="subtitle color-control bg-#888888 color-#ffffff">紅松木+玫瑰木</h2>
		                                <div class="txt">
		                                    <p class="color-control color-#191919">紅松木的聲音給人溫暖且圓潤柔和的感覺，對聲音的傳導性佳，搭配玫瑰木側背板，有清晰的高低頻。</p>
		                                    <span class="note color-control bg-#f1dea7">清晰的高低頻，和overtone 適合指彈演奏與輕鬆刷和弦音樂風格</span>
		                                </div>
		                            </div>
		                        </div>
		                    </div>      
		                </div>
		                <div class="info-item color-control bg-#f5f5f5">
		                    <div class="w1400 container">
		                        <div class="row">
		                            <div class="img"><img src="http://anuenuemusic.event2007.com/frontEndPackage/images/Piano3.jpg" alt=""></div>
		                            <div class="txt-box">
		                                <span class="pro-num color-control color-#888888">M77</span>
		                                <h2 class="subtitle color-control bg-#888888 color-#ffffff">FFW面板<br />浸黑虎紋楓木紅松+桃花心木</h2>
		                                <div class="txt">
		                                    <p class="color-control color-#191919">黑影紋楓木的數量稀少、質地堅硬韌性佳。搭配桃花心木背側板，彈奏時高頻較有顆粒感，低頻較溫暖豐富。</p>
		                                    <span class="note color-control bg-#f5e45f">甜美中頻，和飽滿的低頻，和甜美高音，音色適合各種音樂曲風從指彈音樂到，鄉村音樂到流行樂都適合。</span>
		                                </div>
		                            </div>
		                        </div>
		                    </div>
		                </div>
		            </div>
		        </section>

		        <!-- 指板材質 -->
		        <div class="wrap info-2">
		            <div class="txt-content color-control bg-#ebebeb">
		                <div class="container w1400">
		                    <div class="row">
		                        <h2 class="sub-protitle color-control bg-#444444 color-#ffffff"><span>指板材質</span></h2>
		                    </div>
		                </div>
		            </div>
		            <div class="piano-content color-control bg-#ebebeb">
		                <div class="container w1400">
		                    <div class="row">
		                        <div class="txt">
		                            <p class="color-control color-#191919">指板使用烏黑色澤的黑檀木，擁有緊密的木紋，硬度更勝玫瑰木。黑檀木的傳導特性，將吉他的高頻更加地顯現出來。琴頸與指板經過拋光、打磨、倒角、去毛刺等多種細節程序處理，講究指板弧度打磨設計，能符合手指弧度，讓持琴手感更加舒適。上弦枕寬度為44mm，，並在3,
		                                5, 7, 9, 12, 15格鑲嵌白貝殼圓點造型設計。擁有21格琴格讓彈奏音域更廣。</p>
		                        </div>
		                        <div class="img">
		                            <img src="http://anuenuemusic.event2007.com/frontEndPackage/images/Piano4.png" alt="">
		                        </div>
		                        
		                    </div>
		                </div> 
		            </div>
		        </div>

		        <!-- 琴頭設計 -->
		        <div class="wrap info-3">
		            <div class="txt-content color-control bg-#f5f5f5">
		                <div class="container w1400">
		                    <div class="row">
		                        <h2 class="sub-protitle color-control bg-#444444 color-#ffffff"><span>琴頭設計</span></h2>
		                        
		                    </div>
		                </div>
		            </div>
		            <div class="piano-content color-control bg-#f5f5f5">
		                <div class="container w1400">
		                    <div class="row">
		                        <div class="txt">
		                            <p class="color-control color-#191919">鳥吉他琴頭造型，玫瑰木琴頭貼片搭配白貝殼鑲嵌aNueNue LOGO。使用德榮1：18齒輪比的封閉式弦鈕，轉動順暢，能有效的校正音準。</p>
		                        </div>

		                        <ul class="piano-item">
		                            <li>
		                                <div class="txt">
		                                    <h2 class="title text-center color-control color-#191919">M52&M60<br />玫瑰木</h2>
		                                </div>
		                                <div class="img"> <img src="http://anuenuemusic.event2007.com/frontEndPackage/images/Piano5.jpg" alt=""></div>
		                            </li>
		                            <li>
		                                <div class="txt">
		                                    <h2 class="title text-center color-control color-#191919">M77<br />黑檀木</h2>
		                                </div>
		                                <div class="img"><img src="http://anuenuemusic.event2007.com/frontEndPackage/images/Piano6.jpg" alt=""></div>
		                            </li>
		                            <li>
		                                <div class="txt">
		                                    <h2 class="title text-center color-control color-#191919">M52&M60<br />玫瑰木</h2>
		                                </div>
		                                
		                                <div class="img"><img src="http://anuenuemusic.event2007.com/frontEndPackage/images/Piano7.jpg" alt=""></div>
		                            </li>
		                        </ul>

		                    </div>
		                </div>
		            </div>
		        </div>

		        <!-- 鑲邊設計 -->
		        <div class="wrap info-4">
		            <div class="txt-content color-control bg-#ebebeb">
		                <div class="container w1400">
		                    <div class="row">
		                        <h2 class="sub-protitle color-control bg-#444444 color-#ffffff"><span>鑲邊設計</span></h2>
		                    </div>
		                </div>
		            </div>
		            <div class="piano-content color-control bg-#ebebeb">
		                <div class="container w1400">
		                    <div class="row">
		                        <div class="col-12 txt">
		                            <p class="color-control color-#191919">琴身外側則以桃花心木與黑白線做鑲嵌，兼具美觀及保護的功能。</p>
		                        </div>
		                    </div>
		                </div> 
		                <div class="img"><img src="http://anuenuemusic.event2007.com/frontEndPackage/images/Piano8.png" alt=""></div>
		            </div>
		        </div>

		        <!-- 花圈與鑲邊 -->
		        <div class="wrap info-5">
		            <div class="txt-content color-control bg-#f5f5f5">
		                <div class="container w1400">
		                    <div class="row">
		                        <h2 class="sub-protitle color-control bg-#444444 color-#ffffff"><span>花圈與鑲邊</span></h2>
		                    </div>
		                </div>
		            </div>
		            <div class="piano-content color-control bg-#f5f5f5">
		                <div class="container w1400">
		                    <div class="row">
		                        <div class="txt">
		                            <p class="color-control color-#191919">改用綠貝殼為主在內外加上木頭細線，讓貝殼花圈更添細節。最內圈的玫瑰木，為音孔做加強作用。綠貝殼的色澤光滑且富有紋理，在光線照射下會閃閃發光，並因角度不同照成不同的紋理。琴身外側則以桃花心木與黑白線做鑲嵌，兼具美觀及保護的功能。</p>
		                        </div>

		                        <ul class="piano-item">
		                            <li>
		                                <div class="img mb-3"><img src="http://anuenuemusic.event2007.com/frontEndPackage/images/Piano9.png" alt=""></div>
		                                <div class="txt color-control color-#7f7f7f">
		                                
		                                    <p>M52的光澤感來自桶身使用的亮光漆。經多次拋光處理，才能展現出的高度光澤感。</p>
		                                
		                                </div>
		                            </li>
		                            <li>
		                                <div class="img mb-3"><img src="http://anuenuemusic.event2007.com/frontEndPackage/images/Piano10.png" alt=""></div>
		                                <div class="txt color-control color-#7f7f7f">
		                                    <p>M60使用的是亮啞光漆，平滑質感展現視覺柔和。</p>
		                                </div>
		                            </li>
		                            <li>
		                                <div class="img mb-3"><img src="http://anuenuemusic.event2007.com/frontEndPackage/images/Piano11.png" alt=""></div>
		                                <div class="txt color-control color-#7f7f7f">
		                                
		                                    <p>改用綠貝殼為主在內外加上木頭細線，讓貝殼花圈更添細節。最內圈的玫瑰木，為音孔做加強作用。綠貝殼的色澤光滑且富有紋理，在光線照射下會閃閃發光，並因角度不同照成不同的紋理。琴身外側則以桃花心木與黑白線做鑲嵌，兼具美觀及保護的功能。
		                                    </p>
		                                
		                                </div>
		                            </li>
		                        </ul>
		                    </div>
		                </div>
		            </div>
		        </div>

		        <!-- 上漆材質 -->
		        <div class="wrap info-6">
		            <div class="txt-content color-control bg-#f5f5f5">
		                <div class="container w1400">
		                    <div class="row">
		                        <h2 class="sub-protitle color-control bg-#444444 color-#ffffff"><span>上漆材質</span></h2>
		                    </div>
		                </div>
		            </div>
		            <div class="piano-content color-control bg-#f5f5f5">
		                <div class="container w1400">
		                    <div class="row">
		                        <ul class="piano-item">
		                            <li>
		                                <div class="txt">
		                                    <h2 class="title text-center color-control color-#191919">M52亮光漆</h2>
		                                    <p class="color-control color-#7f7f7f">M52的光澤感來自桶身使用的亮光漆。經多次拋光處理，才能展現出的高度光澤感。</p>
		                                </div>
		                                <div class="img"><img src="http://anuenuemusic.event2007.com/frontEndPackage/images/Piano12.png" alt=""></div>
		                            </li>
		                            <li>
		                                <div class="txt">
		                                    <h2 class="title text-center color-control color-#191919">M60亮啞光漆</h2>
		                                    <p class="color-control color-#7f7f7f">M60使用的是亮啞光漆，平滑質感展現視覺柔和。</p>
		                                </div>
		                                <div class="img"><img src="http://anuenuemusic.event2007.com/frontEndPackage/images/Piano13.png" alt=""></div>
		                            </li>
		                            <li>
		                                <div class="txt">
		                                    <h2 class="title text-center color-control color-#191919">M77珠光亮光漆</h2>
		                                    <p class="color-control color-#7f7f7f">M77使用的珠光亮光漆，漆面經過反覆的噴漆、打磨、風乾處理，漆面薄而透亮，展現光澤感。含有珠光粉具有極好的立體效果，提高精緻程度。</p>
		                                </div>
		                                <div class="img"><img src="http://anuenuemusic.event2007.com/frontEndPackage/images/Piano14.png" alt=""></div>
		                            </li>
		                        </ul>
		                        
		                    </div>    
		                
		                </div>
		            </div>
		        </div>
		                  
		        <!-- 上漆材質2 -->
		        <div class="wrap info-7">
		            <div class="txt-content color-control bg-#ebebeb">
		                <div class="container w1400">
		                    <div class="row">
		                        <h2 class="sub-protitle color-control bg-#444444 color-#ffffff"><span>上漆材質</span></h2>
		                    </div>
		                </div>
		            </div>
		            <div class="piano-content color-control bg-#ebebeb">
		                <div class="container w1400">
		                    <div class="row">
		                        <ul class="piano-item">
		                            <li>
		                                <div class="txt">
		                                    <h2 class="title text-center color-control color-#191919">M52亮光漆</h2>
		                                </div>
		                                <div class="img"><img src="http://anuenuemusic.event2007.com/frontEndPackage/images/Piano12.png" alt=""></div>
		                                <div class="txt">
		                                    <p class="color-control color-#7f7f7f">M52的光澤感來自桶身使用的亮光漆。經多次拋光處理，才能展現出的高度光澤感。</p>
		                                </div>
		                                
		                            </li>
		                            <li>
		                                <div class="txt">
		                                    <h2 class="title text-center color-control color-#191919">M60亮啞光漆</h2>
		                                </div>
		                                <div class="img"><img src="http://anuenuemusic.event2007.com/frontEndPackage/images/Piano13.png" alt=""></div>
		                                <div class="txt">
		                                    <p class="color-control color-#7f7f7f">M60使用的是亮啞光漆，平滑質感展現視覺柔和。</p>
		                                </div>
		                                
		                            </li>
		                            <li>
		                                <div class="txt">
		                                    <h2 class="title text-center color-control color-#191919">M77珠光亮光漆</h2>
		                                </div>
		                                <div class="img"><img src="http://anuenuemusic.event2007.com/frontEndPackage/images/Piano14.png" alt=""></div>
		                                <div class="txt">
		                                    <p class="color-control color-#7f7f7f">
		                                        M77使用的珠光亮光漆，漆面經過反覆的噴漆、打磨、風乾處理，漆面薄而透亮，展現光澤感。含有珠光粉具有極好的立體效果，提高精緻程度。</p>
		                                </div>
		                                
		                            </li>
		                        </ul>
		        
		                    </div>
		        
		                </div>
		            </div>
		        </div>
		    </section>
	    --}}
	</div>

	<script type="text/javascript">
		initial_css_after_img_loaded(); /*初始化樣式*/
	</script>
</div>
