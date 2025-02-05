<!DOCTYPE html>
<html>
	<head>
		<title>{{$seo['web_title']}}</title>
	</head>
	<body>
		<div>		
			親愛的管理員您好：<br>
			後台收到新的回函，內容如下：<br>
			<br>

			@if(!empty($conta_name))
				姓名 : 		{{$conta_name}} <br>
			@endif

			@if(!empty($conta_phone))
				電話 : 		{{$conta_phone}} <br>
			@endif

			@if(!empty($conta_email))
				Email :		{{$conta_email}}<br>
			@endif

			@if(!empty($contact_item_name))
				留言項目 :  	{{$contact_item_name}}<br>
			@endif

			@if(!empty($address))
				地址 :  	{{$address}}<br>
			@endif

			@if(!empty($whisper))
				悄悄話 :  	@if($whisper==1) 是 @else 否 @endif<br>
			@endif


			@if(!empty($online_class))
				班別 :  	{{$online_class}}<br>
			@endif
			@if(!empty($online_type))
				梯別 :  	{{$online_type}}<br>
			@endif
			@if(!empty($qa))
				簡易問答 :<br>
				{!! $qa !!}<br>
			@endif
			@if(!empty($car_type))
				選用車種 :  	{{$car_type}}<br>
			@endif
			@if(!empty($county) && !empty($district) && !empty($zipcode) && !empty($address))
				通訊地址 :  	{{$zipcode}}{{$county}}{{$district}}{{$address}}<br>
			@endif
			@if(!empty($gender))
				性別 :  	{{$gender}}<br>
			@endif
			@if(!empty($id_no))
				西元出生年 :  	{{$id_no}}<br>
			@endif
			@if(!empty($domicile))
				戶籍 :  	{{$domicile}}<br>
			@endif
			@if(!empty($birthday))
				出生日 :  	{{$birthday}}<br>
			@endif


			@if(!empty($conta_cont))
				留言內容 :  	{{$conta_cont}}<br>
			@endif
			<br>
			<br>
			<br>
			再麻煩您至後台處理：
			<a href="http://{{$_SERVER['HTTP_HOST']}}/admin/contact/edit/{{$conta_type_id}}/{{$conta_id}}" target="_blank">
				http://{{$_SERVER['HTTP_HOST']}}/admin/contact/edit/{{$conta_type_id}}/{{$conta_id}}
			</a><br>
			===此為系統訊息 請勿直接回覆===
		</div>
	</body>
</html>