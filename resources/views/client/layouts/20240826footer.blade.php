
		<footer class="wow fadeInUp" data-wow-delay=".5s">
            <div class="container w1400">
                <ul class="footer-item">
                    <li>
                        <div class="footer-img">
                            <img src="{{$cmsPublic[0]['imageSrc']}}">
                        </div>
                        <div class="address">
                            @if($cmsPublic[0]['template']['logo_slogan'])
                                {{$cmsPublic[0]['template']['logo_slogan']}}
                                <br>
                            @endif
                            <a href="{{$cmsPublic[0]['template']['address_link']}}" target="_blank">
                                {{$cmsPublic[0]['template']['address']}}
                            </a>
                        </div>
                        <div class="phone">
                             @if($cmsPublic[0]['template']['tel1'])
                            <p class='mr-2'>TEL : 
                               
                                    <a href="tel:{{$cmsPublic[0]['template']['tel1']}}">{{$cmsPublic[0]['template']['tel1']}}</a>
                                
                            </p>
                            @endif
                            @if($cmsPublic[0]['template']['tel2'])
                            <p class='mr-2'>
                                
                                    <a href="tel:{{$cmsPublic[0]['template']['tel2']}}">{{$cmsPublic[0]['template']['tel2']}}</a>
                               
                            </p>
                             @endif
                             @if($cmsPublic[0]['template']['tel3'])
                            <p >
                                
                                    <a href="tel:{{$cmsPublic[0]['template']['tel3']}}">{{$cmsPublic[0]['template']['tel3']}}</a>
                               
                            </p>
                             @endif
                        </div>
                        @if($cmsPublic[0]['template']['fax'])
                        <div class="fax">FAX : {{$cmsPublic[0]['template']['fax']}}</div>
                         @endif
                    </li>
                    <li class="footer-apply">
                        @if($cmsPublic[1]['cont']['text'])
                            <h3>其他課程時間</h3>
                            <div class="item">
                                {!! $cmsPublic[1]['cont']['text'] !!}
                            </div>
                        @endif
                        {{--
                            <div class="item">
                                <h5>{{$cmsPublic[0]['template']['reg_name1']}}</h5>
                                <p>
                                    @if($cmsPublic[0]['template']['reg_tel1_1'])
                                        <a href="tel:{{$cmsPublic[0]['template']['reg_tel1_1']}}">{{$cmsPublic[0]['template']['reg_tel1_1']}}</a> /
                                    @endif
                                    @if($cmsPublic[0]['template']['reg_tel1_2'])
                                        <a href="tel:{{$cmsPublic[0]['template']['reg_tel1_2']}}">{{$cmsPublic[0]['template']['reg_tel1_2']}}</a>
                                    @endif
                                </p>
                            </div>
                            <div class="item">
                                <h5>{{$cmsPublic[0]['template']['reg_name2']}}</h5>
                                <p>
                                    @if($cmsPublic[0]['template']['reg_tel2_1'])
                                        <a href="tel:{{$cmsPublic[0]['template']['reg_tel2_1']}}">{{$cmsPublic[0]['template']['reg_tel2_1']}}</a> /
                                    @endif
                                    @if($cmsPublic[0]['template']['reg_tel2_2'])
                                        <a href="tel:{{$cmsPublic[0]['template']['reg_tel2_2']}}">{{$cmsPublic[0]['template']['reg_tel2_2']}}</a>
                                    @endif
                                </p>
                            </div>
                            <div class="item">
                                <h5>{{$cmsPublic[0]['template']['reg_name3']}}</h5>
                                <p>
                                    @if($cmsPublic[0]['template']['reg_tel3_1'])
                                        <a href="tel:{{$cmsPublic[0]['template']['reg_tel3_1']}}">{{$cmsPublic[0]['template']['reg_tel3_1']}}</a> /
                                    @endif
                                    @if($cmsPublic[0]['template']['reg_tel3_2'])
                                        <a href="tel:{{$cmsPublic[0]['template']['reg_tel3_2']}}">{{$cmsPublic[0]['template']['reg_tel3_2']}}</a>
                                    @endif
                                </p>
                            </div>
                            <div class="item">
                                <h5>{{$cmsPublic[0]['template']['reg_name4']}}</h5>
                                <p>
                                    @if($cmsPublic[0]['template']['reg_tel4_1'])
                                        <a href="tel:{{$cmsPublic[0]['template']['reg_tel4_1']}}">{{$cmsPublic[0]['template']['reg_tel4_1']}}</a> /
                                    @endif
                                    @if($cmsPublic[0]['template']['reg_tel4_2'])
                                        <a href="tel:{{$cmsPublic[0]['template']['reg_tel4_2']}}">{{$cmsPublic[0]['template']['reg_tel4_2']}}</a>
                                    @endif
                                </p>
                            </div>
                        --}}
                    </li>
                    <li>
                        <ul class="community">
                            @if($cmsPublic[0]['template']['fb_link'])
                                <li class="fb_link"><a href="{{$cmsPublic[0]['template']['fb_link']}}" target="_blank"><i class="fab fa-facebook-f"></i></a></li>
                            @endif
                            @if($cmsPublic[0]['template']['line_link'])
                                <li class="line_link">
                                    <a href="{{$cmsPublic[0]['template']['line_link']}}" target="_blank">
                                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" fill="currentColor"
                                            class="bi bi-line" viewBox="0 0 16 16">
                                            <path
                                                d="M8 0c4.411 0 8 2.912 8 6.492 0 1.433-.555 2.723-1.715 3.994-1.678 1.932-5.431 4.285-6.285 4.645-.83.35-.734-.197-.696-.413l.003-.018.114-.685c.027-.204.055-.521-.026-.723-.09-.223-.444-.339-.704-.395C2.846 12.39 0 9.701 0 6.492 0 2.912 3.59 0 8 0ZM5.022 7.686H3.497V4.918a.156.156 0 0 0-.155-.156H2.78a.156.156 0 0 0-.156.156v3.486c0 .041.017.08.044.107v.001l.002.002.002.002a.154.154 0 0 0 .108.043h2.242c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157Zm.791-2.924a.156.156 0 0 0-.156.156v3.486c0 .086.07.155.156.155h.562c.086 0 .155-.07.155-.155V4.918a.156.156 0 0 0-.155-.156h-.562Zm3.863 0a.156.156 0 0 0-.156.156v2.07L7.923 4.832a.17.17 0 0 0-.013-.015v-.001a.139.139 0 0 0-.01-.01l-.003-.003a.092.092 0 0 0-.011-.009h-.001L7.88 4.79l-.003-.002a.029.029 0 0 0-.005-.003l-.008-.005h-.002l-.003-.002-.01-.004-.004-.002a.093.093 0 0 0-.01-.003h-.002l-.003-.001-.009-.002h-.006l-.003-.001h-.004l-.002-.001h-.574a.156.156 0 0 0-.156.155v3.486c0 .086.07.155.156.155h.56c.087 0 .157-.07.157-.155v-2.07l1.6 2.16a.154.154 0 0 0 .039.038l.001.001.01.006.004.002a.066.066 0 0 0 .008.004l.007.003.005.002a.168.168 0 0 0 .01.003h.003a.155.155 0 0 0 .04.006h.56c.087 0 .157-.07.157-.155V4.918a.156.156 0 0 0-.156-.156h-.561Zm3.815.717v-.56a.156.156 0 0 0-.155-.157h-2.242a.155.155 0 0 0-.108.044h-.001l-.001.002-.002.003a.155.155 0 0 0-.044.107v3.486c0 .041.017.08.044.107l.002.003.002.002a.155.155 0 0 0 .108.043h2.242c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157H11.81v-.589h1.525c.086 0 .155-.07.155-.156v-.56a.156.156 0 0 0-.155-.157H11.81v-.589h1.525c.086 0 .155-.07.155-.156Z" />
                                        </svg>
                                    </a>
                                </li>
                            @endif
                            @if($cmsPublic[0]['template']['ig_link'])
                                <li class="ig_link"><a href="{{$cmsPublic[0]['template']['ig_link']}}" target="_blank"><i class="bi bi-instagram"></i></a></li>
                            @endif
                            @if($cmsPublic[0]['template']['youtube_link'])
                                <li class="youtube_link"><a href="{{$cmsPublic[0]['template']['youtube_link']}}" target="_blank"><i class="bi bi-youtube"></i></a></li>
                            @endif
                        </ul>
                    </li>
                </ul>
            </div>
            <div class="copy">
                <div class="container w1400">
                    <div class="row justify-content-between">
                        <p>Copyright © {{ date('Y') }} {{$seo['web_title']}} ,Ltd. All rights reserved</p>
                        <ul class="photonic-footer">
                            <div class="mr-2" style="color: #4887c2;">傳訊光科技:</div>
                            <li><a target="_blank" class="text-photonic" href="https://shop.photonic.com.tw/">購物車</a></li>
                            <li><a target="_blank" class="text-photonic" href="https://www.photonic.com.tw/">網頁設計</a></li>
                            <li><a target="_blank" class="text-photonic" href="http://erp2000.com/">CRM</a></li>
                        </ul>
                    </div>
                </div>
            </div>
        </footer>