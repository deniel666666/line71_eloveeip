<!DOCTYPE html>
<html ng-app="app">
	<head>
		<meta charset="utf-8" />
		<title>{{$seo['web_title']}}</title>
		<meta name="viewport" content="width=device-width, initial-scale=1.0, maximum-scale=1.0, user-scalable=no" />
		<link rel="manifest" href="/manifest.json?12">
		<!--  css -->
		<link href="/css/bootstrap/bootstrap-4.0.0/bootstrap.css" rel="stylesheet" type="text/css" />
		<link href="/css/fontawesome/fontawesome-free-5.5.0-web/all.css" rel="stylesheet" type="text/css" />

	  	<script src="/js/vendor/jquery/jquery-1.10.1.js" type="text/javascript"></script>
		<script src="/js/vendor/bootstrap/bootstrap-4.0.0/bootstrap.min.js" type="text/javascript"></script>	
	  	<script src="/js/proj_admin.js" type="text/javascript"></script>

		@yield('javascript_header')
		@yield('css_header')
	</head>



	<body>
		<div class="container-fluid" style="padding: 0px;">	
			<div class="" ng-controller="ContentController as contCtrl">
				@yield('content')
			</div>
		</div>
		<!-- 跳出視窗：加入主畫面 -->
		<div class="modal fade shoppingCart" id="addToHome" tabindex="-1" role="dialog" aria-labelledby="addToHomeTitle" aria-hidden="true">
			<div class="modal-dialog modal-dialog-centered" role="document">
				<div class="modal-content">
					<button type="button" class="close" data-dismiss="modal" aria-label="Close">
						<span aria-hidden="true">&times;</span>
					</button>
					<div class="modal-header">
						<h5 class="modal-title" id="addToHomeTitle">加入主畫面</h5>                           
					</div>
					<div class="modal-body">
						在手機主畫面建立捷徑，快速享受購物樂趣~<br>
						<button id="addToHomeBtn" class="btn btn-success">建立</button>
					</div>
				</div>
			</div>
		</div>
		<span id="addToHome_btn" data-toggle="modal" data-target="#addToHome" style="visibility: hidden;">+</span>
		<script src="/js/vendor/angular/angular-1.4.4/angular.js" type="text/javascript"></script>
		@yield('javascript')
	</body>
	<script type="text/javascript">
		/*初始化PWA*/
        if('serviceWorker' in navigator){
            navigator.serviceWorker
                .register('sw.js')
                .then(function(){
                    console.log('Service Worker 註冊成功');
                }).catch(function(error) {
                    console.log('Service worker 註冊失敗:', error);
                })
                .then(function(){
                    /*詢問訂閱*/
                    //askForNotificationPermission()
                });
        } else {
            console.log('瀏覽器不支援 serviceWorker');
        }

        /*加入主畫面-------------------------------*/
        let deferredPrompt;
        const addToHomeBtn = document.querySelector('#addToHomeBtn');
        if( /Android|webOS|iPhone|iPad|iPod|BlackBerry|IEMobile|Opera Mini/i.test(navigator.userAgent) ) {
            
            window.addEventListener('beforeinstallprompt', (e) => {
                
                // Prevent Chrome 67 and earlier from automatically showing the prompt
                e.preventDefault();
                // Stash the event so it can be triggered later.
                deferredPrompt = e;
                // Update UI to notify the user they can add to home screen
                $('#addToHome_btn').click()

                addToHomeBtn.addEventListener('click', (e) => {
                    // hide our user interface that shows our A2HS button
                    $('#addToHome_btn .close').click();
                    // Show the prompt
                    deferredPrompt.prompt();
                    // Wait for the user to respond to the prompt
                    deferredPrompt.userChoice.then((choiceResult) => {
                        if (choiceResult.outcome === 'accepted') {
                            console.log('User accepted the A2HS prompt');
                        } else {
                            console.log('User dismissed the A2HS prompt');
                        }
                        deferredPrompt = null;
                    });
                });
            });
        }
	</script>
</html>