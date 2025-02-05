
				<!-- 跑馬燈 -->
		        <div class="announcement">
		            <div class="announcementBox container w1400">
		                <div id="announcementCarousel">
		                	@foreach($marquees as $marquee)
		                    <div>
		                    	<a href="/marquee/1/{{$marquee['prod_id']}}.html">
		                    		<span class="news-time">{{mb_substr($marquee['prod_show_s_datetime'], 0, 10)}}</span>
		                            <span>{{$marquee['prod_name']}}</span>
		                        </a>
		                    </div>
		                    @endforeach
		                </div>
		                <a class="more" href="/marquee.html">MORE <i class="fas fa-arrow-right" aria-hidden="true"></i></a>
		            </div>
		        </div>