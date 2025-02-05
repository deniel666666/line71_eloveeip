app.directive('contentItem', function ($compile){

	var getTemplate = function (contentType) {//console.log(contentType);

		var obj = JSON.parse(contentType); //console.log(obj.title.text); // console.log(obj)

		var layoutSpace	= obj.layout.space 	? '' : 'no_mb_spacing';
		var titleSpace  = obj.title.space 	? '' : 'p_mb_spacing';
		var contSpace 	= obj.cont.space 	? '' : 'p_mb_spacing';

		var layoutShow	= obj.layout.show 	? '' : '' /*dp_none*/;
		var titleShow  	= obj.title.show 	? '' : 'dp_none';
		var contShow 	= obj.cont.show 	? '' : 'dp_none';

		title = obj.title.text ? obj.title.text : "";
		content = obj.cont.text ? obj.cont.text : "";
		var textBody = 		'<div>'+
								'<h4 class="'+titleShow+' '+titleSpace+' "> '+title+' </h4>'+
								'<p class=" '+contShow+' '+contSpace+' "> '+content+' </p>'+
							'</div>';
						// '</div>';
		
		// var text1 	= 	'<div class="col-md-12 	articleBox '+layoutSpace+' ">'+ textBody;				
		// var text2 	= 	'<div class="col-md-6 	articleBox '+layoutSpace+' ">'+ textBody;
		// var text3 	= 	'<div class="col-md-4 	articleBox '+layoutSpace+' ">'+ textBody;
		// var text4 	= 	'<div class="col-md-3 	articleBox '+layoutSpace+' ">'+ textBody;
		// var text6 	= 	'<div class="col-md-2 	articleBox '+layoutSpace+' ">'+ textBody;
		// var text12 	= 	'<div class="col-md-1 	articleBox '+layoutSpace+' ">'+ textBody;
					
		var imgBody = 		'<div class="imgBox">'+
								'<img src="'+obj.imgSrc+'" alt="" width="200">'+
								'<div class="textBox '+layoutShow+' ">'+
									'<h4 class="'+titleShow+' '+titleSpace+' ">'+title+'</h4>'+
									'<p class=" '+contShow+' '+contSpace+' ">'+content+'</p>'+
								'</div>'+
							'</div>';
						// '</div>';

		// var img1 	= 	'<div class="col-md-12 	articleBox '+layoutSpace+' ">' + imgBody;
		// var img2 	= 	'<div class="col-md-6 	articleBox '+layoutSpace+' ">' + imgBody
		// var img3 	= 	'<div class="col-md-4 	articleBox '+layoutSpace+' ">' + imgBody;
		// var img4 	= 	'<div class="col-md-3 	articleBox '+layoutSpace+' ">' + imgBody;
		// var img6 	= 	'<div class="col-md-2 	articleBox '+layoutSpace+' ">' + imgBody
		// var img12 	= 	'<div class="col-md-1 	articleBox '+layoutSpace+' ">' + imgBody
						

		switch (obj.tpl) {
			case 'text1':
				template = textBody;
			break;
			case 'text2':
				template = textBody;
			break;
			case 'text3':
				template = textBody;
			break;
			case 'text4':
				template = textBody;
			break;
			case 'text6':
				template = textBody;
			break;
			case 'text12':
				template = textBody;
			break;
			case 'img1':
				template = imgBody;
			break;
			case 'img2':
				template = imgBody;
			break;
			case 'img3':
				template = imgBody;
			break;
			case 'img4':
				template = imgBody;
			break;
			case 'img6':
				template = imgBody;
			break;
			case 'img12':
				template = imgBody;
			break;
		}

	    return template;
	};//var getTemplate = function 

	var linker = function ($scope, $element, $attrs) {//alert($scope.tplcode)

		$element.html(getTemplate($scope.tplcode));

		$compile($element.contents())($scope);
	};

	return {
		restrict: 'A',
		link: linker,
		scope: {
			tplcode:'@'
		}
	};
});//app.directive