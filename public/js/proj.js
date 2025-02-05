var proj = {
	webUrl : "http://multilang/admin/",


    ///////////////////////
    //     CART
    ///////////////////////
   
	addProduct:function(productId,qty,productPrice){
		var cart = proj.getCart();
		var haveAdd = false;
		var cartItem;
		if (cart){
			cartItem = cart.length;

			for(var prop in cart){
				if (cart[prop]['productId'] == productId){
					cart[prop]['qty'] += qty;
					haveAdd = true;
				}
		    }//for
		    if (!haveAdd){
		    	cart[cartItem] = {productId:productId,qty:qty,productPrice:productPrice}
		    }
		    localStorage.setItem("cart", JSON.stringify(cart));
		}else{
			cart    = [];
			cart[0] = {productId:productId,qty:qty,productPrice:productPrice}
			localStorage.setItem("cart", JSON.stringify(cart));
		}

		return JSON.parse(localStorage.getItem("cart"));

	},//addCart:function()


	delProduct:function(productId,qty){
		// console.log(productId,qty);
		var cart = proj.getCart();
		var haveAdd = false;
		var cartItem;

		var i = 0;
		var cartNew = new Array();

		if (cart){
			cartItem = cart.length;

			for(var prop in cart){
				if (cart[prop]['productId'] == productId){
					cart[prop]['qty'] -= qty;
					if (cart[prop]['qty']<=0) cart[prop]['qty'] = 0;
				}
		    }//for

		    for(var prop in cart){
				if (cart[prop]['qty'] != 0){
					cartNew.push(cart[prop])	
				}
			}//for

		    localStorage.setItem("cart", JSON.stringify(cartNew));
		}else{
			
		}

		return JSON.parse(localStorage.getItem("cart"));
	},//addCart:function()


	clrProduct:function(prodId){
		var cart = proj.getCart();
		for (var prop in cart){
			if (cart[prop]['productId'] == prodId){
				proj.delProduct(prodId,cart[prop]['qty']);
			}
		}
	},

    getCart:function(){
        return cart = JSON.parse(localStorage.getItem("cart"));
    },// getCart:function()


    setCart:function(cart){
    	localStorage.setItem("cart", JSON.stringify(cart));
    },//setCart:function()

    getCartItemCount:function(){
        var cart = proj.getCart();
        var cartItemCount = 0;

        if (cart){
             for(var prop in cart){
                cartItemCount += cart[prop]['qty'];
             }
        }
        return cartItemCount;
    },//getCartItemCount:function()


	clrCart:function(){
		localStorage.removeItem('cart');
	},


	///////////////////////
	// ORDER INFOMATION
	///////////////////////

	setOrderInfo:function(orderInfo){
		localStorage.setItem("orderInfo", JSON.stringify(orderInfo));
	},


	getOrderInfo:function(){
		return JSON.parse(localStorage.getItem("orderInfo"));
	},


	clrOrderInfo:function(){
		localStorage.removeItem('orderInfo');
	},



	////////////////////
	//   TOOLs
	///////////////////
    parseDatetime:function(datetime){
    	// console.log(datetime);
    	var date_time = datetime.split(' ');
    	var pdate = date_time[0].split('-');
    	var ptime = date_time[1].split(':');
    	var format =  {y:pdate[0],m:pdate[1],d:pdate[2],h:ptime[0],i:ptime[1],s:ptime[2]};
    	return format;
    },//parseDatetime

	getParameterByName:function(name, url){
		if (!url) url = window.location.href;
		name = name.replace(/[\[\]]/g, '\\$&');
		var regex = new RegExp('[?&]' + name + '(=([^&#]*)|&|#|$)'),
		    results = regex.exec(url);
		if (!results) return null;
		if (!results[2]) return '';
		return decodeURIComponent(results[2].replace(/\+/g, ' '));
	}//function(name, url)

	
};