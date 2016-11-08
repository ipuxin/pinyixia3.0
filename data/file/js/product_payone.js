function jsApiCall(json){
	WeixinJSBridge.invoke(
		'getBrandWCPayRequest',
		json,
		function(res){
			var orderId = Product.getOrderId();
			WeixinJSBridge.log(res.err_msg);
			if(res.err_msg=='get_brand_wcpay_request:ok'){//支付成功
				//Msg('支付成功');
				pageTurn('/order/orderinfo/'+orderId);
			}else{
				pageTurn('/order/orderinfo/'+orderId);
			}
		}
	);
}

function callpay(jcode){
	//alert(jcode);
	if (typeof WeixinJSBridge == "undefined"){
		if( document.addEventListener ){
			document.addEventListener('WeixinJSBridgeReady', jsApiCall, false);
		}else if (document.attachEvent){
			document.attachEvent('WeixinJSBridgeReady', jsApiCall); 
			document.attachEvent('onWeixinJSBridgeReady', jsApiCall);
		}
	}else{
		jsApiCall(jcode);
	}
}

var Product = {

	btnSub : 0,
	OrderId : '',

	getOrderId:function(){
		return Product.OrderId;
	},

	defaultClick:function(){
		$('orderset span btn').click(function(){
			var isdel = $(this).hasClass('del');
			var price = parseInt($(this).parent().data('price')*100);
			var kuaidi = parseInt($(this).parent().data('kuaidi')*100);
			var num = parseInt($(this).parent().find('num').html());
			if(isdel){num-=1;}else{num+=1;}
			if(num<1){num=1;}
			
			var productPrice = num*price;
			if(FreightFreeAmout && FreightFreeAmout>0){
				if(FreightFreeAmout*100<=productPrice){
					kuaidi = 0;
					$('f.kd').html('满 '+FreightFreeAmout+' 元免邮');
				}else{
					$('f.kd').html('快递 '+kuaidi/100+' 元');
				}
			}

			price = ((productPrice+kuaidi)/100);

			$(this).parent().find('num').html(num);
			$('tongji r').eq(0).html(num);
			$('tongji r').eq(1).html('¥'+price);

			ProductNum = num;
		});

		$('footer btn').click(function(){
			var data = {};
			data.ProductId = ProductId;
			data.ProductNum = ProductNum;
			data.AddressId = $('addbox').data('addid');
			data.Remark = $('#remark').val();
			
			if(!data.AddressId){Msg('请先添加地址');return;}

			if(Product.btnSub==0){
				Product.btnSub = 1;
				ajaxLocal('/order/creatOrder',data,function(json){
					if(!json || json==false){Msg('订单创建失败');Product.btnSub=0;return;}
					if(json.Code>0){Msg(json.Message);Product.btnSub=0;return;}
					if(json.ErrorCode>0){Msg(json.ErrorMessage);Product.btnSub=0;return;}
					if(json.Order && json.Order.OrderId){
						Product.OrderId = json.Order.OrderId;
						Msg('订单创建成功');
						/*setTimeout(function(){
							pageTurn('/order/orderlist/1');
						},1000);*/
						ajaxLocal('/wxpay/orderSubmit',{OrderId:json.Order.OrderId},function(json){
							if(json.ErrorCode==0){
								var JsonCode = eval('('+json.JsonCode+')');
								callpay(JsonCode);
							}else{
								if(json.orderPayed==1){
									pageTurn('/order/orderinfo/'+Product.OrderId);
								}
								Msg(json.ErrorMsg,2);
							}
						});
					}else{
						Msg('未知错误');Product.btnSub=0;return;
					}
				});
			}
		});
	},

	/**
	* @ 页面初始化
	*/		
	init_page:function(){
		Product.defaultClick();
	}
}