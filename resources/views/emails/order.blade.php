<!DOCTYPE html>
<html>
	<head>
		<title>{{$seo['web_title']}}</title>
	</head>
	<body>
		<div>
			愛的客戶您好：<br>
			我們已收到您的訂單，內容如下：<br>
			<br>

			【訂單編號】 {{$od_sn}} <br>
			<br>
			------------------------------------------------ <br>
			【訂購人】 	{{$od_info['buyer']}} <br>
			【信箱】 		{{$od_info['email']}} <br>
			【聯絡電話】 	{{$od_info['contactPhone']}} <br>
			【行動電話】 	{{$od_info['mobilePhone']}} <br>
			【地址】 		{{$od_info['address']}} <br>
			<br>
			------------------------------------------------ <br>
			【收件人】 	{{$od_info['recipient']}}<br>
			【聯絡電話】 	{{$od_info['rxContactPhone']}}<br>
			【行動電話】	{{$od_info['rxMobilePhone']}}<br>
			【地址】		{{$od_info['rxAddress']}}<br>
			<br>
			------------------------------------------------ <br>
			【發票寄送對象】 {{$od_info['taxRx']}}<br>
			<br>
			------------------------------------------------ <br>
			【訂購商品】<br>

			<table>
				<tr>
			    	<th>商品</th>
			    	<th>價格</th> 
			    	<th>數量</th>
				</tr>
				@foreach ($od_cont['product'] as $prod)
			  	<tr>
			    	<td>{{$prod['prodName']}}</td>
			    	<td>{{$prod['typeSalesPrice']}}</td>
			    	<td>{{$prod['qty']}}</td>
			  	</tr>
				@endforeach
			</table>

			@if ($od_cont['total'] < $od_cont['freeFare'])
				【{{$od_cont['fare']['fareName']}}】 {{$od_cont['fare']['fareCost']}} <br>
			@endif
			------------------------------------------------ <br>
			【總價】 {{$od_cont['total']}}<br>
			<br>
			<br>
			<br>
			我們會盡快為您處理<br>
			===此為系統訊息 請勿直接回覆===
			<br>
			<br>
		</div>
	</body>
</html>