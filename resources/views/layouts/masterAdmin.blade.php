<!DOCTYPE html>
<html ng-app="app">
	<head>
		<meta charset="utf-8" />
		<!-- <meta http-equiv="Content-Security-Policy" content="upgrade-insecure-requests"> -->
		<title>@yield('htmlTitle')</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />

		<link rel="manifest" href="/manifest.json">

		<!-- favicon -->
		<!-- <link rel="shortcut icon" href="/images/logo_sm.png"> -->
		<link href="/css/reset.css" rel="stylesheet" type="text/css" />

		<!--  css -->
		<!-- <link href="/css/proj.css" rel="stylesheet" type="text/css" /> -->
		<link href="/css/bootstrap/bootstrap-4.0.0/bootstrap.css" rel="stylesheet" type="text/css" />
		<link href="/css/fontawesome/fontawesome-free-5.5.0-web/all.css" rel="stylesheet" type="text/css" />

		
		<!-- <script src="/js/vendor/jquery/jquery-1.10.1.js" type="text/javascript"></script> -->
		<script src="https://cdnjs.cloudflare.com/ajax/libs/jquery/3.2.1/jquery.js"></script> 
		<script src="https://cdnjs.cloudflare.com/ajax/libs/popper.js/1.11.0/umd/popper.min.js"></script>
		<script src="/js/vendor/bootstrap/bootstrap-4.0.0/bootstrap.min.js" type="text/javascript"></script>	

		<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/moment.js/2.15.1/moment.min.js"></script>
			<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/css/bootstrap-datetimepicker.min.css"> 
			<link rel="stylesheet" type="text/css" href="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/css/bootstrap-datetimepicker-standalone.css">
	
		
			<script type="text/javascript" src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datetimepicker/4.17.43/js/bootstrap-datetimepicker.min.js"></script>

		<script src="/js/proj_admin.js" type="text/javascript"></script>
		<script src="/js/jquery.toaster.js" type="text/javascript"></script>
		<script src="/js/vendor/twzipcode/jquery.twzipcode.js" type="text/javascript"></script>
		@yield('external_plugin')

		<!-- include summernote css/js -->
		<link href="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/summernote-bs4.css" rel="stylesheet">
		<link href="/summernote/summernote-adjust.css" rel="stylesheet">
		<script src="/summernote/summernote-bs4.js"></script>
		<script src="https://cdnjs.cloudflare.com/ajax/libs/summernote/0.8.11/lang/summernote-zh-TW.min.js"></script>
		<script src="/summernote/summernote-image-attributes.js"></script>
		<script src="/summernote/zh-TW.js"></script>
		
		
		<link href="/css/admin-style.css" rel="stylesheet" type="text/css"/>
		
		<!-- cms模板樣式 -->
		<link href="/frontEndPackage/css/RWD_eidtor_style.css" rel="stylesheet" type="text/css">
		<script src="/frontEndPackage/js/template.js"></script>

		@yield('javascript_header')
		@yield('css_header')
	</head>

	<body>
		<div id="block_area" style="display: none;
																position: fixed;
																width: 100vw;
																height: 100vh;
																z-index: 49999;
																background: #00000033;"></div>
		<nav class="navbar navbar-expand-lg navbar-dark bg-dark d-flex justify-content-between">
			<div>
					<a class="navbar-brand" href="/admin/">網站後臺</a>
					<a class="card-link viewWeb" href='/' target="_blank">前台查看</a>
			</div>
			<div class="signOut">
				<a class="navbar-brand" href='/admin/logout'>登出</a>
			</div>

				<button id="phoneMenuBtn" class="navbar-toggler align-items-center" type="button" onclick="menu_toggle()">
					<span class="menu_icon navbar-toggler-icon"></span>
					<span class="menu_icon navbar-cancel-icon">
						<svg xmlns="http://www.w3.org/2000/svg" width="16" height="16" fill="currentColor" class="bi bi-x-lg" viewBox="0 0 16 16">
							<path d="M1.293 1.293a1 1 0 0 1 1.414 0L8 6.586l5.293-5.293a1 1 0 1 1 1.414 1.414L9.414 8l5.293 5.293a1 1 0 0 1-1.414 1.414L8 9.414l-5.293 5.293a1 1 0 0 1-1.414-1.414L6.586 8 1.293 2.707a1 1 0 0 1 0-1.414z"/>
						</svg>
					</span>
				</button>
		</nav>

		<!-- ///////////////////////////////////////////// -->
		<!-- ///////////////////////////////////////////// -->
		<!-- ///////////////////////////////////////////// -->
		<div>
			@foreach ($cms as $cmsItem)
				<!-- <p> {{$cmsItem}}</p> -->
			@endforeach
		</div>

		<div class="container-fluid" style="padding: 0px;">
			<div id="adminItemBox">
				<!-- ////////////////////////////////////////////////// -->
				<!-- 電腦選單 -->
				<nav id="adminLeftBox" class="" >
					<div class="sidebar-sticky w-100">
						<div class="sidebar-sticky">
							<div id="accordion">

								<!-- 有階層的個的選單 -->
								<!-- <div class="use-card">
									<div class="use-card-header {{$homeCollapse ?? ''}}">
										<a class="card-link" data-toggle="collapse" href="#homeCard">首頁</a>
									</div>

									<div id="homeCard" class="collapse {{$homeCollapse ?? ''}}" data-parent="#accordion">
										<div class="use-card-body">
											<a href='/admin/gallery/1' id="gallery" class="list-group-item {{$Gall1Active ?? ''}}">輪播圖片</a>
											<a href='/admin/cms/1' id="cms1" class="list-group-item {{$cms1Active ?? ''}}">通用設定</a>
										</div>
									</div>
								</div>
								-->
								<!-- 無階層的個的選單 -->
								<!-- <div class="use-card">
									<div class="use-card-header {{$notificationCollapse ?? ''}}">
										<a class="card-link" href='/admin/cms/2' id="cms2">畫廊公告</a>
									</div>
								</div>
								-->
								
								<div class="use-card">
									<div class="use-card-header {{$onlineCollapse ?? ''}}">
										<a class="card-link" data-toggle="collapse" href="#onlineCard">一頁式EDM管理區</a>
									</div>
									<div id="onlineCard" class="collapse {{$onlineCollapse ?? ''}}" data-parent="#accordion">
										<div class="use-card-body">
											<!-- <a href='/admin/gallery/2' id="gallery2" class="list-group-item {{$Gall2Active ?? ''}}">報名項目</a> -->
											<a href='/admin/product/7' id="product7" class="list-group-item {{$productActive7 ?? ''}}">EDM列表</a>
											<a href='/admin/categoryTag/7' id="categoryTag7" class="list-group-item {{$categoryTagActive7 ?? ''}}">EDM類別</a>
											<a href='/admin/product_cms_layout/management/type'	class="list-group-item {{$prodcuCmsLayoutActive ?? ''}}">EDM模版</a>
											{{--
												<!--
												<a href='/admin/propertyTag/7' id="" class="list-group-item {{$propertyTagActive7 ?? ''}}">欄位管理</a>
												<a href='/admin/product/label/7' id="" class="list-group-item {{$prodLabelTagActive7 ?? ''}}">ICON管理</a>
												<a href='/admin/product/seo/7' id="" class="list-group-item {{$prodSeoTagActive7 ?? ''}}">SEO管理</a>
												<a href='/admin/product/tabs/7' id="" class="list-group-item {{$prodTabsActive7 ?? ''}}">介紹管理</a>
												-->
												<a href='/admin/cms/6' id="cms6" class="list-group-item {{$cms6Active ?? ''}}">報名說明</a>
												<a href='/admin/cms/7' id="cms7" class="list-group-item {{$cms7Active ?? ''}}">課程時段</a>
												<a href='/admin/cms/8' id="cms8" class="list-group-item {{$cms8Active ?? ''}}">注意事項</a>
											--}}
										</div>
									</div>
								</div>
								<div class="use-card">
									<div class="use-card-header {{$contact2Active ?? ''}}">
										<a class="card-link" href='/admin/contact/2' id="conta2">報名回函</a>
									</div>
								</div>

								<div class="use-card">
									<div class="use-card-header {{$Caseollapse ?? ''}}">
										<a class="card-link" data-toggle="collapse" href="#Caseollapse">成功案例</a>
									</div>
									<div id="Caseollapse" class="collapse {{$Caseollapse ?? ''}}" data-parent="#accordion">
										<div class="use-card-body">
											<a href='/admin/categoryTag/10' class="list-group-item {{$categoryTagActive10 ?? ''}}">案例類別</a>
											<a href='/admin/product/10' id="product10" class="list-group-item {{$productActive10 ?? ''}}">案例列表</a>
										</div>
									</div>
								</div>
								<div class="use-card">
									<div class="use-card-header {{$FAQCollapse ?? ''}}">
										<a class="card-link" data-toggle="collapse" href="#FAQCollapse">FAQ</a>
									</div>
									<div id="FAQCollapse" class="collapse {{$FAQCollapse ?? ''}}" data-parent="#accordion">
										<div class="use-card-body">
											<a href='/admin/categoryTag/9' id="product9" class="list-group-item {{$categoryTagActive9 ?? ''}}">FAQ類別</a>
											<a href='/admin/product/9' id="product9" class="list-group-item {{$productActive9 ?? ''}}">FAQ列表</a>
										</div>
									</div>
								</div>

								<div class="use-card">
									<div class="use-card-header {{$line_cardCollapse ?? ''}}">
										<a class="card-link" data-toggle="collapse" href="#line_cardCard">LINE電子名片</a>
									</div>
									<div id="line_cardCard" class="collapse {{$line_cardCollapse ?? ''}}" data-parent="#accordion">
										<div class="use-card-body">
											<a href='/admin/product/8' id="product8" class="list-group-item {{$productActive8 ?? ''}}">名片管理</a>
											<a href='/admin/categoryTag/8' id="product8" class="list-group-item {{$categoryTagActive8 ?? ''}}">分區管理</a>
										</div>
									</div>
								</div>
								@if( $LINE_BUSINESS_ID )
								<div class="use-card">
									<div class="use-card-header">
										<a class="card-link" href='https://manager.line.biz/account/{{$LINE_BUSINESS_ID}}' id="lottery" target="_blank">LINE@管理頁面</a>
									</div>
								</div>
								@endif
								<!-- <div class="use-card">
									<div class="use-card-header">
										<a class="card-link" href='https://lottery.bigwell.com.tw/' id="lottery" target="_blank">線上抽獎工具</a>
									</div>
								</div> -->
								<div class="use-card">
									<div class="use-card-header {{$cms1Active ?? ''}}">
										<a class="card-link" href='/admin/cms/1' id="cms1">通用設定</a>
									</div>
								</div>
								{{--
									<div class="use-card">
										<div class="use-card-header {{$homeCollapse ?? ''}}">
											<a class="card-link" data-toggle="collapse" href="#homeCard">首頁</a>
										</div>
										<div id="homeCard" class="collapse {{$homeCollapse ?? ''}}" data-parent="#accordion">
											<div class="use-card-body">
												<a href='/admin/gallery/1' id="gallery" class="list-group-item {{$Gall1Active ?? ''}}">大圖輪播</a>
												<a href='/admin/cms/9' id="cms2" class="list-group-item {{$cms2Active ?? ''}}">自訂介紹內容</a>
												<a href='/admin/cms/3' id="cms3" class="list-group-item {{$cms3Active ?? ''}}">挖空介紹內容</a>
											</div>
										</div>
									</div>
									<div class="use-card">
										<div class="use-card-header {{$productActive1 	 ?? ''}}">
											<a class="card-link" href='/admin/product/1' id="product">關於我們</a>
											<!-- <a href='/admin/categoryTag/1' id="categoryTag" class="list-group-item {{$categoryTagActive1 ?? ''}}">分類管理</a>
											<a href='/admin/propertyTag/1' id="" class="list-group-item {{$propertyTagActive1 ?? ''}}">欄位管理</a>
											<a href='/admin/product/label/1' id="" class="list-group-item {{$prodLabelTagActive1 ?? ''}}">ICON管理</a>
											<a href='/admin/product/seo/1' id="" class="list-group-item {{$prodSeoTagActive1 ?? ''}}">SEO管理</a>
											<a href='/admin/product/tabs/1' id="" class="list-group-item {{$prodTabsActive1 ?? ''}}">介紹管理</a> -->
										</div>
									</div>
									<div class="use-card">
										<div class="use-card-header {{$contact1Active ?? ''}}">
											<a class="card-link" href='/admin/contact/1' id="conta1">聯絡我們回函</a>
										</div>
									</div>

									<div class="use-card">
										<div class="use-card-header {{$productActive2 	 ?? ''}}">
											<a class="card-link" href='/admin/product/2' id="product2">最新消息</a>
											<!-- <a href='/admin/categoryTag/2' id="categoryTag" class="list-group-item {{$categoryTagActive2 ?? ''}}">分類管理</a>
											<a href='/admin/propertyTag/2' id="" class="list-group-item {{$propertyTagActive2 ?? ''}}">欄位管理</a>
											<a href='/admin/product/label/2' id="" class="list-group-item {{$prodLabelTagActive2 ?? ''}}">ICON管理</a>
											<a href='/admin/product/seo/2' id="" class="list-group-item {{$prodSeoTagActive2 ?? ''}}">SEO管理</a>
											<a href='/admin/product/tabs/2' id="" class="list-group-item {{$prodTabsActive2 ?? ''}}">介紹管理</a> -->
										</div>
									</div>
									<div class="use-card">
										<div class="use-card-header {{$productActive3 	 ?? ''}}">
											<a class="card-link" href='/admin/product/3' id="product3">跑馬燈</a>
											<!-- <a href='/admin/categoryTag/3' id="categoryTag" class="list-group-item {{$categoryTagActive3 ?? ''}}">分類管理</a>
											<a href='/admin/propertyTag/3' id="" class="list-group-item {{$propertyTagActive3 ?? ''}}">欄位管理</a>
											<a href='/admin/product/label/3' id="" class="list-group-item {{$prodLabelTagActive3 ?? ''}}">ICON管理</a>
											<a href='/admin/product/seo/3' id="" class="list-group-item {{$prodSeoTagActive3 ?? ''}}">SEO管理</a>
											<a href='/admin/product/tabs/3' id="" class="list-group-item {{$prodTabsActive3 ?? ''}}">介紹管理</a> -->
										</div>
									</div>
									<div class="use-card">
										<div class="use-card-header {{$productActive4 	 ?? ''}}">
											<a class="card-link" href='/admin/product/4' id="product4">課程介紹</a>
											<!-- <a href='/admin/categoryTag/4' id="categoryTag" class="list-group-item {{$categoryTagActive4 ?? ''}}">分類管理</a>
											<a href='/admin/propertyTag/4' id="" class="list-group-item {{$propertyTagActive4 ?? ''}}">欄位管理</a>
											<a href='/admin/product/label/4' id="" class="list-group-item {{$prodLabelTagActive4 ?? ''}}">ICON管理</a>
											<a href='/admin/product/seo/4' id="" class="list-group-item {{$prodSeoTagActive4 ?? ''}}">SEO管理</a>
											<a href='/admin/product/tabs/4' id="" class="list-group-item {{$prodTabsActive4 ?? ''}}">介紹管理</a> -->
										</div>
									</div>
									<div class="use-card">
										<div class="use-card-header {{$productActive5 	 ?? ''}}">
											<a class="card-link" href='/admin/product/5' id="product5">場地介紹</a>
											<!-- <a href='/admin/categoryTag/5' id="categoryTag" class="list-group-item {{$categoryTagActive5 ?? ''}}">分類管理</a>
											<a href='/admin/propertyTag/5' id="" class="list-group-item {{$propertyTagActive5 ?? ''}}">欄位管理</a>
											<a href='/admin/product/label/5' id="" class="list-group-item {{$prodLabelTagActive5 ?? ''}}">ICON管理</a>
											<a href='/admin/product/seo/5' id="" class="list-group-item {{$prodSeoTagActive5 ?? ''}}">SEO管理</a>
											<a href='/admin/product/tabs/5' id="" class="list-group-item {{$prodTabsActive5 ?? ''}}">介紹管理</a> -->
										</div>
									</div>
									<div class="use-card">
										<div class="use-card-header {{$cms4Active ?? ''}}">
											<a class="card-link" href='/admin/cms/4' id="cms4">報名位置</a>
										</div>
									</div>
									<div class="use-card">
										<div class="use-card-header {{$cms5Active ?? ''}}">
											<a class="card-link" href='/admin/cms/5' id="cms5">體檢須知</a>
										</div>
									</div>
									<div class="use-card">
										<div class="use-card-header {{$linkCollapse ?? ''}}">
											<a class="card-link" data-toggle="collapse" href="#linkCard">相關連結</a>
										</div>
										<div id="linkCard" class="collapse {{$linkCollapse ?? ''}}" data-parent="#accordion">
											<div class="use-card-body">
												<a href='/admin/gallery/3' id="gallery3" class="list-group-item {{$Gall3Active ?? ''}}">服務連結</a>
												<a href='/admin/gallery/4' id="gallery4" class="list-group-item {{$Gall4Active ?? ''}}">友站連結</a>
											</div>
										</div>
									</div>
									<!-- 
									<div class="use-card">
										<div class="use-card-header {{$prodCollapse6 ?? ''}}">
											<a class="card-link" data-toggle="collapse"  href="#productMana6">相關連結</a>
										</div>
										<div id="productMana6" class="collapse {{$prodCollapse6 ?? ''}}" data-parent="#accordion">
											<div class="use-card-body">
												<a href='/admin/categoryTag/6' id="categoryTag" class="list-group-item {{$categoryTagActive6 ?? ''}}">分類管理</a>
												<a href='/admin/product/6'   id="product" 	  class="list-group-item {{$productActive6 ?? ''}}">連結列表</a>
											</div>
										</div>
									</div>
									-->
								--}}
								<div class="use-card">
									<div class="use-card-header {{$sysCollapse ?? ''}}">
										<a class="card-link" data-toggle="collapse"  href="#sysMana">系統管理</a>
									</div>

									<div id="sysMana" class="collapse {{$sysCollapse ?? ''}}" data-parent="#accordion">
										<div class="use-card-body">
											<a href='/admin/development/team'	 class="list-group-item {{$devActive ?? ''}}">開發團隊</a>
											@if ( Session::get('user')['account'] === 'photonic')
												<a href='/admin/system/intro'		class="list-group-item {{$sysActive ?? ''}}">系統訊息</a>
											@endif
											<a href='/admin/account' class="list-group-item {{$accountActive ?? ''}}">帳號管理</a>
											<a href='/admin/account_do_log' class="list-group-item {{$account_do_logActive ?? ''}}">帳號操作紀錄</a>
											<a href='/admin/mailbox' class="list-group-item {{$mailboxActive ?? ''}}">通知設定</a>
											<a href='/admin/seo'	 		class="list-group-item {{$seo1Active ?? ''}}">SEO設定</a>
											<a href='/admin/seoMarketing'	class="list-group-item {{$seo2Active ?? ''}}">SEO行銷/發布設定</a>
											<a href='/admin/seoAdvanced'	class="list-group-item {{$seo3Active ?? ''}}">進階SEO設定</a>
											{{--
												<a href='/admin/cms/2' id="cms9" class="list-group-item {{$cms9Active ?? ''}}">各頁SEO設定</a>
												<a href='/admin/member'  class="list-group-item {{$memberActive	?? ''}}">店家管理</a>
												<a href='/admin/customer'  class="list-group-item {{$customerActive	?? ''}}">消費者管理</a>
											--}}
										</div>
									</div>
								</div>

								{{--
									<div class="use-card">
										<div class="use-card-header {{$gallCollapse ?? ''}}">
											<a class="card-link" data-toggle="collapse"  href="#gallMana">大圖管理</a>
										</div>

										<div id="gallMana" class="collapse {{$gallCollapse ?? ''}}" data-parent="#accordion">
											<div class="use-card-body">
												<!--
												<a href='/admin/gallery/1' id="大圖輪播" class="list-group-item {{$Gall1Active ?? ''}}">大圖輪播</a>
												<a href='/admin/gallery/2' id="大圖輪播" class="list-group-item {{$Gall2Active ?? ''}}">關於我們</a>
												-->
												@foreach ($gallery as $galleryItem)
													<a 	href='/admin/gallery/{{$galleryItem->gallery_type_id}}' 
														id="cms{{$galleryItem->gallery_type_id}}" 
														class="list-group-item {{isset($galleryTypeId) ? (($galleryTypeId==$galleryItem->gallery_type_id) ? 'active': '') : ''}}"> {{$galleryItem->gallery_name}}
													</a>
												@endforeach
											</div>
										</div>
									</div>
									<hr>

									<div class="use-card">
										<div class="use-card-header {{$cmsCollapse ?? ''}}">
											<a class="card-link" data-toggle="collapse"  href="#aboutMana">CMS管理</a>
										</div>

										<div id="aboutMana" class="collapse {{$cmsCollapse ?? ''}}"  data-parent="#accordion">
											<div class="use-card-body">

												<a href='/admin/cms_layout/management/type'	class="list-group-item {{$cmsLayoutActive ?? ''}}">模板管理</a>
												<hr>
												@foreach ($cms as $cmsItem)
													<a 	href='/admin/cms/{{$cmsItem->id}}' 
														id="cms{{$cmsItem->id}}" 
														class="list-group-item {{isset($cmsTypeId) ? (($cmsTypeId==$cmsItem->id) ? 'active': '') : ''}}"> {{$cmsItem->cms_type_name}}
													</a>
												@endforeach
												<!-- 
												<a href='/admin/cms/1' id="cms1" class="list-group-item {{$cms1Active ?? ''}}">關於我們</a>
												<a href='/admin/cms/2' id="cms2" class="list-group-item {{$cms2Active ?? ''}}">泳池管理</a>
												<a href='/admin/cms/3' id="cms3" class="list-group-item {{$cms3Active ?? ''}}">運動教學</a> 
												-->
												<hr>
												<a href='/admin/cms/management/type/' id="create" class="list-group-item {{$cmsTypeActive ?? ''}}">類別管理</a>
											</div>
										</div>
									</div>
									<hr>

									<div class="use-card">
										<div class="use-card-header {{$contaCollapse ?? ''}}">
											<a class="card-link" data-toggle="collapse"  href="#contaMana">聯絡我們</a>
										</div>

										<div id="contaMana" class="collapse {{$contaCollapse ?? ''}}" data-parent="#accordion">
											<div class="use-card-body" id="contaType">
												<a href='/admin/contact/1' id="conta1" class="list-group-item {{$contact1Active ?? ''}}">聯絡我們表單A</a>
												<a href='/admin/contact/2' id="conta2" class="list-group-item {{$contact2Active ?? ''}}">聯絡我們表單B</a>
											</div>
										</div>
									</div>
									<hr>

									<!-- /////////////////////////////////////////////////////////////////////////////////////// -->
									<!-- /////////////////////////////////////////////////////////////////////////////////////// -->
									<div class="use-card">
										<div class="use-card-header {{$prodcutCmaLayoutCollapse ?? ''}}">
											<a class="card-link" data-toggle="collapse"  href="#pro_template_mgmt">PRODUCT模板管理</a>
										</div>
										<div id="pro_template_mgmt" class="collapse  {{$prodcutCmaLayoutCollapse ?? ''}}" data-parent="#accordion">
											<div class="use-card-body">
												<a href='/admin/product_cms_layout/management/type'	class="list-group-item {{$prodcuCmsLayoutActive ?? ''}}">模板管理</a>
											</div>
										</div>
									</div>
									<hr>

									<div class="use-card">
										<div class="use-card-header {{$prodCollapse1 ?? ''}}">
											<a class="card-link" data-toggle="collapse"  href="#productManaA">產品介紹</a>
										</div>

										<div id="productManaA" class="collapse {{$prodCollapse1 ?? ''}}" data-parent="#accordion">
											<div class="use-card-body">
												<a href='/admin/categoryTag/1' id="categoryTag" class="list-group-item {{$categoryTagActive1 ?? ''}}">分類管理</a>
												<a href='/admin/propertyTag/1' id="" class="list-group-item {{$propertyTagActive1 ?? ''}}">欄位管理</a>
												<a href='/admin/product/label/1' id="" class="list-group-item {{$prodLabelTagActive1 ?? ''}}">ICON管理</a>
												<a href='/admin/product/seo/1' id="" class="list-group-item {{$prodSeoTagActive1 ?? ''}}">SEO管理</a>
												<a href='/admin/product/tabs/1' id="" class="list-group-item {{$prodTabsActive1 ?? ''}}">介紹管理</a>
												<a href='/admin/product/1'   id="product" 	  class="list-group-item {{$productActive1 	 ?? ''}}">商品列表</a>
											</div>
										</div>
									</div>

									<div class="use-card">
										<div class="use-card-header {{$prodCollapse2 ?? ''}}">
											<a class="card-link" data-toggle="collapse"  href="#productManaB">商品管理-2</a>
										</div>

										<div id="productManaB" class="collapse {{$prodCollapse2 ?? ''}}" data-parent="#accordion">
											<div class="use-card-body">
												<a href='/admin/categoryTag/2' id="categoryTag" class="list-group-item {{$categoryTagActive2 ?? ''}}">分類管理</a>
												<a href='/admin/propertyTag/2' id="" class="list-group-item {{$propertyTagActive2 ?? ''}}">欄位管理</a>
												<a href='/admin/product/label/2' id="" class="list-group-item {{$prodLabelTagActive2 ?? ''}}">ICON管理</a>
												<a href='/admin/product/seo/2' id="" class="list-group-item {{$prodSeoTagActive2 ?? ''}}">SEO管理</a>

												<a href='/admin/product/tabs/2' id="" class="list-group-item {{$prodTabsActive2 ?? ''}}">介紹管理</a>

												<a href='/admin/product/2'   id="product" 	  class="list-group-item {{$productActive2 	 ?? ''}}">商品</a>
											</div>
										</div>
									</div>
									<hr>
									<!-- /////////////////////////////////////////////////////////////////////////////////////// -->
									<!-- /////////////////////////////////////////////////////////////////////////////////////// -->

									<div class="use-card">
										<div class="use-card-header {{$fareCollapse ?? ''}}">
											<a class="card-link" data-toggle="collapse"  href="#productMana">運費管理</a>
										</div>
										<div id="productMana" class="collapse {{$fareCollapse ?? ''}}" data-parent="#accordion">
											<div class="use-card-body">
												<a href='/admin/fare' id="fare" class="list-group-item {{$fareActive ?? ''}}">運費管理</a>
											</div>
										</div>
									</div>
									<hr>

									<div class="use-card">
										<div class="use-card-header {{$orderCollapse ?? ''}}">
											<a class="card-link" data-toggle="collapse"  href="#cart">訂單管理</a>
										</div>

										<div id="cart" class="collapse  {{$orderCollapse ?? ''}}" data-parent="#accordion">
											<div class="use-card-body">
												<a href='/admin/product/1/order' id="categoryTag" class="list-group-item {{$prod1OrderActive ?? ''}}">商品訂單</a>
												<a href='/admin/product/2/order' id="categoryTag" class="list-group-item {{$prod2OrderActive ?? ''}}">商品2訂單</a>
												<a href='/admin/journal/order'   id="propertyTag" class="list-group-item {{$journalOrderActive ?? ''}}">期刊訂單</a>
											</div>
										</div>
									</div>
									<hr>

									<div class="use-card">
										<div class="use-card-header {{$langCollapse ?? ''}}">
											<a class="card-link" data-toggle="collapse"  href="#langMana">語系管理</a>
										</div>
										<div id="langMana" class="collapse {{$langCollapse ?? ''}}" data-parent="#accordion">
											<div class="use-card-body">
												<a href='/admin/lang' id="語系選擇" class="list-group-item {{$langActive ?? ''}}">語系選擇</a>
												<a href='/admin/menu' id="選單語系" class="list-group-item {{$menuActive ?? ''}}">選單設定</a>
											</div>
										</div>
									</div>
									<hr>

									<div class="use-card">
										<div class="use-card-header {{$miscellaneousCollapse ?? ''}}">
											<a class="card-link" data-toggle="collapse"  href="#miscellaneous">說明設定</a>
										</div>
										<div id="miscellaneous" class="collapse {{$miscellaneousCollapse ?? ''}}" data-parent="#accordion">
											<div class="use-card-body">
												<a href='/admin/miscellaneous/1' class="list-group-item {{$miscellaneous1Active	?? ''}}">隱私政策</a>
												<a href='/admin/miscellaneous/2' class="list-group-item {{$miscellaneous2Active	?? ''}}">會員同意書</a>
											</div>
										</div>
									</div>
								--}}

								<br>
								<br>
							</div>
						</div>
					</div>
				</nav>
				<!-- ////////////////////////////////////////////////// -->

				<div id="adminRightBox" >
					<div id="ng_contCtrl" ng-controller="ContentController as contCtrl">
						@yield('content')

						@yield('content2')
					</div>
				</div>
			</div>
		</div>

		<!-- JS  -->
		<script src="/js/vendor/angular/angular-1.4.4/angular.js" type="text/javascript"></script>
		<script src="/js/vendor/angular/angular-summernote-master\dist\angular-summernote.js" type="text/javascript"></script>
		<script src="/js/vendor/angular/angular-ui-bootstrap\ui-bootstrap-tpls-2.5.0.js" type="text/javascript"></script>

		<script type="text/javascript">

			$(function () {
				let url  =  "/admin/api/contact/new/check";
				$.ajax({
					url: url,
					cache: false,
					dataType: 'json',
					type: 'GET',
					error: function(jqXHR, textStatus, errorThrown) {
						console.log('HTTP status code: ' + jqXHR.status + '\n' +
						'textStatus: ' + textStatus + '\n' +
						'errorThrown: ' + errorThrown);
						console.log('HTTP message body (jqXHR.responseText): ' + '\n' + jqXHR.responseText);
					},
					success: function(response) {
						response.contactType.forEach(function(element) {
							if(element.getNew){
								$("#conta"+element.id).html(element.name+'('+element.count+')');
							}
						});
					}
				});
			});

		</script>
		<script>
			// Pagination localStorage start -------------------------------------------
			// if(localStorage.getItem("{{$_SERVER['REQUEST_URI']}}") == null ){
			//     localStorage.clear();
			// }
			// -------------------------------------------------------------------------
		</script>
		@yield('javascript')

		<script>
			/*小螢幕選單*/
			var adminLeftBox = $('#adminLeftBox');
			var phoneMenuBtn = $('#phoneMenuBtn');
			function menu_toggle(){
				if(phoneMenuBtn.hasClass('open')){
					phoneMenuBtn.removeClass('open')
					adminLeftBox.animate({'right':'-180px'}, 500)
				}else{
					phoneMenuBtn.addClass('open')
					adminLeftBox.animate({'right':'0px'}, 500)
				}
			}

			/*自動選擇語言版*/
			setTimeout(function(){
				/*取得angular資料*/
				var appElement = document.querySelector('html');
				var $scope = angular.element(appElement).scope();
				$scope = $scope.$$childHead;

					/*記錄語言*/
				$('#lang_select').on('change', function(){
					localStorage.setItem('record_lang', $scope.contCtrl.selectLangItem)
				})
			}, 500);

			/*取得紀錄的語言*/
			function get_record_lang(){
				if(localStorage.getItem("record_lang") != "" && localStorage.getItem("record_lang") != null){
					return  Number(localStorage.getItem("record_lang"));
				}else{
					return 1;
				}
			}


			/* if('serviceWorker' in navigator){
				navigator.serviceWorker
					.register('service-worker.js')
					.then(function(){
						console.log('Service Worker 註冊成功');
					}).catch(function(error) {
						console.log('Service worker 註冊失敗:', error);
					});
			} else {
				console.log('瀏覽器不支援 serviceWorker');
			}

			window.addEventListener('beforeinstallprompt', function(e) {
				e.userChoice.then(function(choiceResult) {
					if(choiceResult.outcome == 'dismissed') {
						console.log('user取消安裝至桌面');
					}
					else {
						console.log('user接受安裝至桌面');
					}
				});
			}); */
		</script>
	</body>
</html>