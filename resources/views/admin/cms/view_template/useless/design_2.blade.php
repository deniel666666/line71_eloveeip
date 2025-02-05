<div class="container articleEditorBox w1920">	
	<div class="design-2 w1920">
        <!-- 圖文介紹-1 -->
        <section class="box1 wrap">
        	@if ( !$cms[0]['template']['hide'] && !empty($cms[0]['imageSrc']) )
            <div class="img"><img src="{{$cms[0]['imageSrc']}}" alt="" class="img-fluid" onerror="initial_css_after_img_loaded()"></div>
            @endif

            @if ( !$cms[1]['template']['hide'] )
            <div class="txt-content color-control bg-{{$cms[1]['template']['bg_color'] ?? '' }}">
                <div class="container w1400">
                    <div class="row">
                        <h2 class="title color-control color-{{$cms[1]['template']['tilte_main_color'] ?? '' }}">
                        	{{$cms[1]['template']['tilte_main'] ?? '' }}
                        </h2>
                        <div class="txt">
                            <h2 class="subtitle color-control 
	                    		   bg-{{$cms[1]['template']['title_sub_bg'] ?? '' }} color-{{$cms[1]['template']['title_sub_color'] ?? '' }}">
                            	@if ( isset($cms[1]['template']['title_sub']) )
		                    		{!! $cms[1]['template']['title_sub'] !!}
		                    	@endif
                            </h2>
                            <div class="color-control color-{{$cms[1]['template']['content_color'] ?? '' }}">
                            	{!! $cms[1]['cont']['text'] !!}
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            @endif

            @if ( !$cms[2]['template']['hide'] && !empty($cms[2]['imageSrc']) )
            <div class="img"><img src="{{$cms[2]['imageSrc']}}" alt="" class="img-fluid" onerror="initial_css_after_img_loaded()"></div>
            @endif
        </section>

        <!-- 圖文介紹-2 -->
        @if ( !$cms[3]['template']['hide'] )
        <section class="format wrap color-control bg-{{$cms[3]['template']['bg_color'] ?? '' }}">
            <div class="container w1400">
                <div class="row">
                    <div class="txt-content col-md-6 col-12">
                        <div class="txt">
                            <h2 class="subtitle color-control 
	                    		   bg-{{$cms[3]['template']['tilte_main_bg'] ?? '' }} color-{{$cms[3]['template']['tilte_main_color'] ?? '' }}">
                            	{{ $cms[3]['template']['tilte_main'] ?? '' }}
                            </h2>
                            <div class="color-control color-{{$cms[3]['template']['content_color'] ?? '' }}">
			                    {!! $cms[3]['cont']['text'] !!}
			                </div>
                        </div>
                    </div>
                </div>
            </div>

            <div class="img-content" @if ( !empty($cms[3]['imageSrc']) ) style="background-image: url({{$cms[3]['imageSrc']}});" @endif>
            </div>
        </section>
        @endif

		{{--
	        <section class="format2 wrap color-control bg-#f5f5f5">
	            <div class="container w1400">
	                <div class="img-content">
	                    <img src="http://anuenuemusic.event2007.com/frontEndPackage/images/Piano-pro2.png" alt="">
	                </div>
	                <table class="format-table table table-bordered">
	                    <thead>
	                        <tr class=" color-control bg-#4d4d4d color-#ffffff">
	                            <th></th>
	                            <th>USHC</th>
	                            <th>UCHC</th>
	                            <th>UTHC</th>
	                        </tr>
	                    </thead>
	                    <tbody>
	                        <tr>
	                            <td>总长度</td>
	                            <td>約63±1公分</td>
	                            <td>約67.5±1公分</td>
	                            <td>約75±1公分</td>
	                        </tr>
	                        <tr>
	                            <td>下宽度</td>
	                            <td>約27±1公分</td>
	                            <td>約29.5±1公分</td>
	                            <td>約31.5±1公分</td>
	                        </tr>
	                        <tr>
	                            <td>侧面宽</td>
	                            <td>約12±1公分</td>
	                            <td>約12±1公分</td>
	                            <td>約12.5±1公分</td>
	                        </tr>
	                    </tbody>
	                </table>
	                <!-- <div class="img-content">
	                    <img src="http://anuenuemusic.event2007.com/frontEndPackage/images/Piano-pro3.png" alt="">
	                </div> -->
	            </div>
	        </section>

	        <section class="box2 wrap color-control bg-#fafafa">
	            <div class="item-box">
	                <div class="item-pro">
	                    <div class="item color-control bg-#eaecec">
	                        <div class="txt-content">
	                            <div class="txt">
	                                <h2 class="subtitle"> 顏值擔當 / 居家好收藏 </h2>
	                                <p>全系列為36吋面單吉他，尺寸不只輕巧好攜帶，更能點綴融入生活，就算不彈奏也能成為最佳藝術擺設。</p>
	                            </div>
	                        </div>
	                        <img src="http://anuenuemusic.event2007.com/frontEndPackage/images/design2-3.png" alt="" class="img-fluid">
	                    </div>
	                    <div class="item color-control bg-#eaecec">
	                        <div class="txt-content">
	                            <div class="txt">
	                                <h2 class="subtitle"> 特殊材質 / 防抓耐磨 </h2>
	                                <p>音孔旁的耐抓布料防刮板，挑選家飾布材質，特殊技術緊密黏合琴面，經歷反覆測試，盡情彈奏也不怕。</p>
	                            </div>
	                        </div>

	                        <img src="http://anuenuemusic.event2007.com/frontEndPackage/images/design2-4.png" alt="" class="img-fluid">
	                    </div>
	                </div>
	            </div>
	        </section>
	        <section class="box2 wrap color-control bg-#eaecec">
	            <div class="item-box">
	                <div class="item-pro">
	                    <div class="item color-control bg-#fafafa">
	                        <div class="txt-content">
	                            <div class="txt">
	                                <h2 class="subtitle"> 特殊材質 / 防抓耐磨 </h2>
	                                <p>以鳥的輪廓為造型設計，位於音孔旁的耐抓布料防刮板，挑選家飾布材質，特殊技術緊密黏合琴面，經歷反覆測試，盡情彈奏也不怕。</p>
	                            </div>
	                        </div>
	                        <img src="http://anuenuemusic.event2007.com/frontEndPackage/images/design2-5.png" alt="" class="img-fluid">
	                    </div>

	                </div>
	            </div>
	        </section>

	        <!-- 影片介紹 -->
	        <section class="box3 wrap color-control bg-#fafafa">
	            <div class="txt-content">
	                <div class="txt">
	                    <h2 class="subtitle"> 宣傳曲 </h2>
	                    <p>MC色彩系列 邀請了aNueNue的音樂好朋友 - Gail蓋兒，擔任首位宣傳大使，與大家分享她和MC色彩吉他的音樂生活。由多次入圍金曲獎的專業音樂人 -
	                        Hans陳思翰，與金曲裝幀設計入圍的視覺藝術家 -
	                        楊士慶，共同打造了宣傳主題曲〈Killin' Me〉以及單曲封面設計，聽覺與視覺的結合，讓音樂生活有了新的體驗。</p>
	                </div>
	            </div>
	        </section>
	        <div class="iframe-rwd mov">
	            <iframe width="560" height="315" src="https://www.youtube.com/embed/Xds6rerUIFo"
	                title="YouTube video player" frameborder="0"
	                allow="accelerometer; autoplay; clipboard-write; encrypted-media; gyroscope; picture-in-picture"
	                allowfullscreen>
	            </iframe>
	        </div>

	        <!-- 產品介紹 -->
	        <section class="box4 wrap">
	            <div class="txt-content color-control bg-#f9f9f9 color-#191919">
	                <div class="container w1400">
	                    <div class="row">
	                        <h2 class="title">豐富生活的亮麗色彩</h2>
	                    </div>
	                </div>
	            </div>
	        </section>
	        <section class="box5 wrap">
	            <div class="pro-item">
	                <ul class="items">
	                    <li class="color-control bg-#d2cbba color-#ffffff">
	                        <div>
	                            <img src="http://anuenuemusic.event2007.com/frontEndPackage/images/pro-3.png" alt="" class="img-fluid">
	                        </div>
	                        <div class="txt-box">
	                            <h3>杏奶白/ MC10-AM</h3>
	                            <p>搭配 Pantone 杏奶白調和的開放啞光漆，貼近健康的養生印象，親切而安定，在生活中的空間常使用的色彩，給人俐落、平和的感覺，有充滿療癒心靈、簡潔俐落的哲學意義。</p>
	                        </div>
	                    </li>
	                    <li class="color-control bg-#8298a3 color-#ffffff">
	                        <div>
	                            <img src="http://anuenuemusic.event2007.com/frontEndPackage/images/pro-4.png" alt="" class="img-fluid">
	                        </div>
	                        <div class="txt-box">
	                            <h3>阿羅納藍/ MC10-AB</h3>
	                            <p>搭配 Pantone 阿羅納藍調和的開放啞光漆，取自在馬焦雷湖 (Lago Maggiore)
	                                南邊的古城鎮的阿羅納(Arona)，因天候與自然河岸景觀形成的印象顏色，平靜而穩定，如今為家居服飾中最常見的色彩，有充滿心神寧靜、韜光養晦的心靈意義。</p>
	                        </div>
	                    </li>
	                    <li class="color-control bg-#ff6f61 color-#ffffff">
	                        <div>
	                            <img src="http://anuenuemusic.event2007.com/frontEndPackage/images/pro-5.png" alt="" class="img-fluid">
	                        </div>
	                        <div class="txt-box">
	                            <h3>活珊瑚橘/ MC10-LC</h3>
	                            <p>搭配 Pantone 活珊瑚橘調和的開放啞光漆，作為2019年代表色，隱身在海底堅韌生機蓬勃的顏色，活潑而柔美，充滿活力、肯定生命的價值意義。</p>
	                        </div>
	                    </li>
	                    <li class="color-control bg-#d69638 color-#ffffff">
	                        <div>
	                            <img src="http://anuenuemusic.event2007.com/frontEndPackage/images/pro-6.png" alt="" class="img-fluid">
	                        </div>
	                        <div class="txt-box">
	                            <h3>光輝金/ MC10-GG</h3>
	                            <p>搭配 Pantone 光輝金調和的開放啞光漆，在自然中陽光灑下的顏色，閃耀的光輝與流動的空間，溫暖而激勵，有充滿希望、肯定自己的自信勵志意義。</p>
	                        </div>
	                    </li>
	                    <li class="color-control bg-#6d6e72 color-#ffffff">
	                        <div>
	                            <img src="http://anuenuemusic.event2007.com/frontEndPackage/images/pro-7.png" alt="" class="img-fluid">
	                        </div>
	                        <div class="txt-box container w1400">
	                            <h3>寧靜灰/ MC10-QS</h3>
	                            <p>搭配 Pantone 寧靜灰調和的開放啞光漆，取自影子因光的強弱產生的變化，沈穩而內斂，在生活中有調節視覺感知的顏色，充滿知性、與想像的精神意義。</p>
	                        </div>
	                    </li>
	                </ul>
	            </div>
	        </section>
	        <section class="box4 wrap">
	            <div class="txt-content color-control bg-#f9f9f9 color-#191919">
	                <div class="container w1400">
	                    <div class="row">
	                        <h2 class="title">高顏值與認真的配置</h2>
	                    </div>
	                </div>
	            </div>
	        </section>
	        <section class="box6 wrap color-control bg-#e6e6e6 color-#191919">
	            <div class="container w1400">
	                <div class="material-item">
	                    <ul class="items">
	                        <li class="color-control bg-#ffffff">
	                            <div class="img" style="background-image: url(http://anuenuemusic.event2007.com/frontEndPackage/images/Material1.png);">
	                            </div>
	                            <div class="txt-box">
	                                <h3>面板/云杉木</h3>
	                                <p>音色明亮清脆、甜美細緻，有著圓潤又優雅的聲音特質，在音色的平衡上有相當不錯的表現。適合各種彈唱、演奏。因每年有限定砍伐，因此數量較少。</p>
	                            </div>
	                        </li>
	                        <li class="color-control bg-#ffffff">
	                            <div class="img" style="background-image: url(http://anuenuemusic.event2007.com/frontEndPackage/images/Material2.png);">
	                            </div>
	                            <div class="txt-box">
	                                <h3>側背板/桃花心木</h3>
	                                <p>木質紋路較直，質地堅硬重量輕，聲音傳導較快，音色清脆高亮。彈奏時高頻較有顆粒感，低頻的呈現較溫暖豐富。</p>
	                            </div>
	                        </li>
	                    </ul>
	                </div>
	            </div>
	        </section>
	        <section class="box6 wrap color-control bg-#f9f9f9 color-#191919">
	            <div class="container w1400">
	                <div class="material-item">
	                    <ul class="items">
	                        <li class="color-control bg-#ffffff">
	                            <div class="img" style="background-image: url(http://anuenuemusic.event2007.com/frontEndPackage/images/Material3.png);">
	                            </div>
	                            <div class="txt-box">
	                                <h3>面板/月亮雲杉</h3>
	                                <p>音色明亮清脆、甜美細緻，有著圓潤又優雅的聲音特質，在音色的平衡上有相當不錯的表現。適合各種彈唱、演奏。因每年有限定砍伐，因此數量較少。</p>
	                            </div>
	                        </li>
	                    </ul>
	                </div>
	            </div>
	        </section>

	        <section class="box7 wrap color-control bg-#e6e6e6 color-#323232">
	            <div class="container w1400">
	                <div class="items">
	                    <div class="item-8 item">
	                        <div class="content">
	                            <div class="img"><img src="http://anuenuemusic.event2007.com/frontEndPackage/images/design2-8.png" alt="" class="img-fluid">
	                            </div>
	                            <div class="txt">
	                                <h3>楓木琴頭</h3>
	                                <p>鳥吉他琴頭造型，楓木琴頭貼片搭配 aNueNue LOGO。使用1：16齒輪式弦鈕，轉動順暢，能有效的校正音準。</p>
	                            </div>


	                        </div>
	                    </div>
	                    <div class="item-4 item">
	                        <div class="content">
	                            <div class="img"><img src="http://anuenuemusic.event2007.com/frontEndPackage/images/design2-9.png" alt="" class="img-fluid">
	                            </div>
	                            <div class="txt">
	                                <h3>德榮弦鈕</h3>
	                                <p>1：16齒輪式弦鈕轉動滑順細膩精準校音</p>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </section>
	        <section class="box7 wrap color-control bg-#f5f5f5 color-#323232">
	            <div class="container w1400">
	                <div class="items">
	                    <div class="item-8 item order-1">
	                        <div class="content">
	                            <div class="img"><img src="http://anuenuemusic.event2007.com/frontEndPackage/images/design2-8.png" alt="" class="img-fluid">
	                            </div>
	                            <div class="txt">
	                                <h3>楓木琴頭</h3>
	                                <p>鳥吉他琴頭造型，楓木琴頭貼片搭配 aNueNue LOGO。使用1：16齒輪式弦鈕，轉動順暢，能有效的校正音準。</p>
	                            </div>


	                        </div>
	                    </div>
	                    <div class="item-4 item">
	                        <div class="content">
	                            <div class="img"><img src="http://anuenuemusic.event2007.com/frontEndPackage/images/design2-9.png" alt="" class="img-fluid">
	                            </div>
	                            <div class="txt">
	                                <h3>德榮弦鈕</h3>
	                                <p>1：16齒輪式弦鈕轉動滑順細膩精準校音</p>
	                            </div>
	                        </div>
	                    </div>
	                </div>
	            </div>
	        </section>

	        <section class="box8 wrap">
	            <div class="txt-content color-control bg-#969696 color-#ffffff">
	                <div class="container w1400">
	                    <h2 class="title">高質感彈奏體驗</h2>
	                </div>
	            </div>
	            <div class="txt-content color-control bg-#e6e6e6 color-#191919">
	                <div class="container w1400">
	                    <h2 class="maintitle">指板設計</h2>
	                    <p>琴頸與指板皆經過拋光、打磨、倒角、去毛刺等多種細節程序處理，讓持琴手感更加舒適。上弦枕寬度為44mm，擁有20格琴格讓彈奏音域更廣。</p>
	                </div>
	            </div>
	            <div class="txt-content color-control bg-#f5f5f5 color-#191919">
	                <div class="container w1400">
	                    <div class="row">
	                        <div class="col-md-6">
	                            <div class="txt">
	                                <h4 class="protitle">玫瑰木</h4>
	                                <p>鑲嵌白貝殼指板點<br />
	                                    兩種指板點設計風格<br />
	                                    擁有21格琴格讓彈奏音域更廣</p>
	                            </div>

	                        </div>
	                        <div class="col-md-6">
	                            <div class="txt">
	                                <h4 class="protitle">黑檀木</h4>
	                                <p>鑲嵌白貝殼指板點<br />兩種指板點設計風格<br />擁有21格琴格讓彈奏音域更廣</p>
	                            </div>
	                        </div>

	                    </div>

	                </div>
	            </div>
	            <div class="txt-content pro-box color-control bg-#e6e6e6 color-#191919">
	                <div class="container w1400">
	                    <div class="row">
	                        <div class="col-md-6">
	                            <div class="row">
	                                <div class="img"><img src="http://anuenuemusic.event2007.com/frontEndPackage/images/design2-10.png" alt=""
	                                        class="img-fluid"></div>
	                            </div>

	                        </div>
	                        <div class="col-md-6">
	                            <div class="row">
	                                <div class="protxt">
	                                    <h4 class="protitle">兩種材質搭配</h4>
	                                    <p>使用玫瑰木與楓木材質。依照面板不同顏色，搭配最適合的指板材質</p>
	                                </div>
	                            </div>

	                        </div>
	                    </div>
	                </div>
	            </div>
	            <div class="txt-content pro-box color-control bg-#f5f5f5 color-#191919">
	                <div class="container w1400">
	                    <div class="row">
	                        <div class="col-md-6 order-md-1">
	                            <div class="row">
	                                <div class="img"><img src="http://anuenuemusic.event2007.com/frontEndPackage/images/design2-10.png" alt=""
	                                        class="img-fluid"></div>
	                            </div>

	                        </div>
	                        <div class="col-md-6 ">
	                            <div class="row">
	                                <div class="protxt">
	                                    <h4 class="protitle">兩種材質搭配</h4>
	                                    <p>使用玫瑰木與楓木材質。依照面板不同顏色，搭配最適合的指板材質</p>
	                                </div>
	                            </div>

	                        </div>
	                    </div>
	                </div>
	            </div>
	        </section>
	        <section class="box9 wrap">
	            <div class="gooditem color-control bg-#e6e6e6 color-#191919">
	                <div class="txt-content">
	                    <div class="txt">
	                        <h3>阿羅納藍，光輝金，寧靜灰</h3>
	                        <p>指板使用硬度較高的玫瑰木，氣孔較多、含有豐富油脂的特性，讓玫瑰木指板能適應各種環境，能有效傳導聲音震動。</p>
	                    </div>
	                </div>
	                <div class="img" style="background-image: url(http://anuenuemusic.event2007.com/frontEndPackage/images/design2-11.png);"></div>


	            </div>
	            <div class="gooditem color-control bg-#f5f5f5 color-#191919">
	                <div class="txt-content">
	                    <div class="txt">
	                        <h3>杏奶白，活珊瑚橘</h3>
	                        <p>指板使用楓木，音色清脆明亮、有顆粒感，質地堅硬輕盈，能有效傳導聲音震動。</p>
	                    </div>
	                </div>
	                <div class="img" style="background-image: url(http://anuenuemusic.event2007.com/frontEndPackage/images/design2-12.png);"></div>

	            </div>
	        </section>
	        <section class="box10 wrap">
	            <div class="gooditem item-1  color-control bg-#727272 color-#d5Cbb9">
	                <div class="txt-content">
	                    <div class="txt">
	                        <h3>花圈設計＆材質</h3>
	                        <p>花圈設計使用精心挑選的特殊紋理腐朽楓木，再經專業師傅手工拼製而成。天然的紋路細節增添琴款細節。</p>
	                    </div>
	                </div>
	                <div class="img" style="background-image: url(http://anuenuemusic.event2007.com/frontEndPackage/images/design2-13.png);"></div>

	            </div>
	            <div class="gooditem item-2  color-control bg-#e6e6e6 color-#fb7361">
	                <div class="txt-content">
	                    <div class="txt">
	                        <h3>花圈設計＆材質</h3>
	                        <p>花圈設計使用精心挑選的特殊紋理腐朽楓木，再經專業師傅手工拼製而成。天然的紋路細節增添琴款細節。</p>
	                    </div>
	                </div>
	                <div class="img" style="background-image: url(http://anuenuemusic.event2007.com/frontEndPackage/images/design2-14.png);"></div>

	            </div>
	        </section>
	        <section class="box11 wrap">
	            <div class="txt-content color-control bg-#727272 color-#ffffff">
	                <div class="container w1400">
	                    <div class="row">
	                        <div class="txt">
	                            <h3>琴身鑲邊</h3>
	                            <p>用木質較為堅硬的玫瑰木鑲嵌在琴身外側，由側板延伸至面板的玫瑰木曲線護邊，由細到粗，由粗到細，呈現線條優美的曲線造型。與指板相交處更以弧形取代銳利角度，展現更柔和的線條美感。此概念取自「月有陰晴圓缺」，兼具美觀及保護功能。
	                            </p>
	                        </div>
	                        <div class="img">
	                            <img src="http://anuenuemusic.event2007.com/frontEndPackage/images/design2-15.png" alt="" class="img-fluid">
	                        </div>
	                    </div>

	                </div>
	            </div>
	        </section>

	        <section class="box11 wrap">
	            <div class="txt-content color-control bg-#c6c6c6 ">
	                <div class="container w1400">
	                    <div class="row">
	                        <div class="txt">
	                            <h3>琴身鑲邊</h3>
	                            <p>用木質較為堅硬的玫瑰木鑲嵌在琴身外側，由側板延伸至面板的玫瑰木曲線護邊，由細到粗，由粗到細，呈現線條優美的曲線造型。與指板相交處更以弧形取代銳利角度，展現更柔和的線條美感。此概念取自「月有陰晴圓缺」，兼具美觀及保護功能。
	                            </p>
	                        </div>
	                    </div>
	                </div>
	            </div>
	            <img src="http://anuenuemusic.event2007.com/frontEndPackage/images/design2-16.png" alt="" class="img-fluid">
	            <div class="txt-content color-control bg-#323232 color-#ffffff">
	                <div class="container w1400">
	                    <h2 class="title">多采多姿豐富生活色彩</h2>
	                </div>
	            </div>
	        </section>
        --}}
    </div>

	<script type="text/javascript">
		initial_css_after_img_loaded(); /*初始化樣式*/
	</script>
</div>
