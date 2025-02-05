var proj = {
	webUrl : "http://multilang/",
	// webUrl: "http://localhost/"

	getNavPageIndex : function(currentPage,totalPage){
		// console.log(currentPage,totalPage);
		var prevIndex;
		var nextIndex;

		var currentPage = parseInt(currentPage);
		var totalPage 	= parseInt(totalPage);

		if (currentPage == 1){
			prevIndex = 1;
		}else{
			prevIndex = currentPage - 1;
		}

		if (totalPage == 0){
			nextIndex = 1;
		}else{
			if (currentPage == totalPage){
				nextIndex = totalPage;
			}else{
				nextIndex = currentPage + 1; 
			}
		}
		

		return {prevIndex:prevIndex,nextIndex:nextIndex};
	}//getNavPageIndex = function
};

$(function () {

	// let url  = proj.webUrl+"admin/api/contact/new/check";
	// $.ajax({
	// 	url: url,
	// 	cache: false,
	// 	dataType: 'json',
	// 	type: 'GET',
	// 	error: function(jqXHR, textStatus, errorThrown) {
	// 		console.log('HTTP status code: ' + jqXHR.status + '\n' +
	// 		'textStatus: ' + textStatus + '\n' +
	// 		'errorThrown: ' + errorThrown);
	// 		console.log('HTTP message body (jqXHR.responseText): ' + '\n' + jqXHR.responseText);
	// 	},
	// 	success: function(response) {
	// 		response.contactType.forEach(function(element) {
	// 			if(element.getNew){
	// 				$("#conta"+element.id).html(element.name+'(n)');
	// 			}
	// 		});
	// 	}
	// });//$.ajax({

	// let url1  = proj.webUrl+"admin/api/hire/new/check";
	// $.ajax({
	// 	url: url1,
	// 	cache: false,
	// 	dataType: 'json',
	// 	type: 'GET',
	// 	error: function(jqXHR, textStatus, errorThrown) {
	// 		console.log('HTTP status code: ' + jqXHR.status + '\n' +
	// 		'textStatus: ' + textStatus + '\n' +
	// 		'errorThrown: ' + errorThrown);
	// 		console.log('HTTP message body (jqXHR.responseText): ' + '\n' + jqXHR.responseText);
	// 	},
	// 	success: function(response) {
	// 		if(response.hireNew){
	// 			$("#hire1").html('應徵信件(n)');
	// 		}
	// 	}
	// });//$.ajax({

});//$(function () {


