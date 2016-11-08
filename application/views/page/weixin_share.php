	<script type="text/javascript" src="http://res.wx.qq.com/open/js/jweixin-1.0.0.js"></script>
	<script type="text/javascript">
		var Share_Url = setShareUrl("<?=$ShareConfig['url']?>");
		var Share_Image = "<?=$ShareConfig['image']?>";
		var Share_Title = "<?=$ShareConfig['title']?>";
		var Share_Desri = "<?=$ShareConfig['description']?>";
		
		function getShareUrl(){return Share_Url;}
		function getShareImage(){return Share_Image;}
		function getShareTitle(){return Share_Title;}
		function getShareDes(){return Share_Desri;}

		$(function(){
			
			wx.config({
				debug: false, 
				appId: '<?=$ShareConfig["appid"]?>', // 必填，企业号的唯一标识，此处填写企业号corpid
				timestamp: '<?=$ShareConfig["timestamp"]?>', // 必填，生成签名的时间戳
				nonceStr: '<?=$ShareConfig["nonceStr"]?>', // 必填，生成签名的随机串
				signature: '<?=$ShareConfig["signature"]?>',// 必填，签名，见附录1
				jsApiList: [
					'onMenuShareTimeline',
					'onMenuShareAppMessage'
				] // 必填，需要使用的JS接口列表，所有JS接口列表见附录2
			});

			wx.error(function(res){
				//window.location.href=getUrlForReload();
				//alert("wx.error"+res.errMsg);
			});

			wx.ready(function(){
				wx.onMenuShareTimeline({
					title: getShareTitle(), // 分享标题
					link: getShareUrl(), // 分享链接
					imgUrl: getShareImage(), // 分享图标
					success: function () {
						//location.reload();
					},
					cancel: function () {
						//location.reload();
					}
				});

				wx.onMenuShareAppMessage({
					title: getShareTitle(), // 分享标题
					desc: getShareDes(), // 分享描述
					link: getShareUrl(), // 分享链接
					imgUrl: getShareImage(), // 分享图标
					type: '', // 分享类型,music、video或link，不填默认为link
					dataUrl: '', // 如果type是music或video，则要提供数据链接，默认为空
					success: function () {
						//location.reload();
					},
					cancel: function () {
						//location.reload();
					}
				});
			});

		});

	</script>