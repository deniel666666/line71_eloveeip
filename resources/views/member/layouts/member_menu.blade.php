				<!-- Desktop -->
                <div class="row membersOnlyBox justify-content-center">
                    <div class="col-md-12 col-sm-12 members">
                        <h3>會員專區</h3>
                    </div>

                    <div class="col-md-2 col-sm-4 members">
					    <a class="member_member" href="/member"><i class="icon-list_triangle"></i>基本資料修改</a>
					</div>
                    <div class="col-md-2 col-sm-4 members">
					    <a class="member_gallery_1" href="/member/member_gallery/1"><i class="icon-list_triangle"></i>最新消息</a>
					</div>
					<div class="col-md-2 col-sm-4 members">
					    <a class="member_gallery_2" href="/member/member_gallery/2"><i class="icon-list_triangle"></i>服務內容</a>
					</div>
                    <div class="col-md-2 col-sm-4 members">
                        <a class="member_gallery_3" href="/member/member_gallery/3"><i class="icon-list_triangle"></i>文章管理</a>
                    </div>
					<div class="col-md-2 col-sm-4 members">
					    <a class="member_contact_1" href="/member/member_contact/1"><i class="icon-list_triangle"></i>回函表</a>
					</div>
					<!-- <div class="col-md-3 col-sm-4 members">
					    <a class="" href="/member/ad"><i class="icon-list_triangle"></i>廣告管理</a>
					</div> -->
					<!-- <div class="col-md-2 col-sm-4 members">
					    <a class="" href="/member/point"><i class="icon-list_triangle"></i>點數紀錄</a>
					</div> -->

					<div class="col-md-2 col-sm-4 members">
						<button ng-click="contCtrl.ck_all()" class="btn" >開通內容</button>
					</div>
                    
                </div>
                <!-- Phone -->
                <div class="accordion membersOnlyBoxPhone" id="accordionExample">
                    <div class="membersAccordionBox">
                        <div class="member" id="headingOne">
                            <h3 class="accordionBtn" data-toggle="collapse" data-target="#collapseOne" aria-expanded="true" aria-controls="collapseOne">
                            會員專區
                            </h3>
                        </div>
                        <div id="collapseOne" class="collapse" aria-labelledby="headingOne" data-parent="#accordionExample">
                            <ul>
                                <li><a class="member_member" href="/member">基本資料修改</a></li>
                                <li><a class="member_gallery_1" href="/member/member_gallery/1">最新消息</a></li>
                                <li><a class="member_gallery_2" href="/member/member_gallery/2">服務內容</a></li>
                                <li><a class="member_gallery_3" href="/member/member_gallery/3">文章管理</a></li>
                                <li><a class="member_contact_1" href="/member/member_contact/1">回函表</a></li>
                            </ul>
                        </div>
                    </div>
                </div>
                <!-- //////////// -->