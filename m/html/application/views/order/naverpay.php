<input type="button" id="naverPayBtn" value="네이버페이 결제 버튼" style="display:none;">
<script src="https://nsp.pay.naver.com/sdk/js/naverpay.min.js"></script>


<script>

    var oPay = Naver.Pay.create({
          "mode" : "production", // development or production
          "clientId": "NXVgQOklaNcGW8_Cjm3B", // clientId
					"openType": "popup",
					"useNaverAppLogin" : true,
					"onAuthorize" : function(oData) {
						/*
						팝업 타입을 설정하고, onAuthorize callback function 을 설정하여 결과를 callback function 으로 전달 받을 수 있도록 지원합니다.
						onAuthorize callback function 을 설정하지 않은 경우는 returnUrl 로 참조 정보와 함께 redirect 됩니다.
						oData 객체에는 결제 인증 결과와 전달한 returnUrl 정보가 함께 전달되며,
						이 정보는 이후 승인 요청 처리를 위한 정보 (resultCode, resultMessage, returnUrl, paymentId, reserveId 등) 입니다.
						전달되는 값은 https://developer.pay.naver.com/docs/v2/api#payments-payments_window 의 성공 & 실패 응답 값을 참조해주세요.
						*/
						if(oData.resultCode === "Success") {
							$(".review_addfile_loading_wrap").show();
							setTimeout(function(){
								$(".review_addfile_loading_wrap").hide(),
								callback_naver(oData.paymentId) // 네이버페이 결제 승인 요청 처리
							},1000);
							//callback_naver(oData.paymentId) // 네이버페이 결제 승인 요청 처리

						} else {
							if(oData.resultMessage == "userCancel"){
								var txt = "결제를 취소하셨습니다.주문 내용 확인 후 다시 결제해주세요.";
							}else if(oData.resultMessage == "OwnerAuthFail"){
								var txt = "타인 명의 카드는 결제가 불가능합니다.회원 본인 명의의 카드로 결제해주세요.";
							}else if(oData.resultMessage == "paymentTimeExpire"){
								var txt = "결제 가능한 시간이 지났습니다.주문 내용 확인 후 다시 결제해주세요.";
							}
							alert(txt);
							// 필요 시 oData.resultMessage 에 따라 적절한 사용자 안내 처리
						}
				}
    });

    //직접 만드신 네이버페이 결제버튼에 click Event를 할당하세요
    var elNaverPayBtn = document.getElementById("naverPayBtn");

    elNaverPayBtn.addEventListener("click", function() {
				var total_price = parseInt($("#total_price").val()); // 가격
				var list_array = <?php echo json_encode($naver_info)?>; // 결제 상품 항목
				var prd_arr = [];
				var total_cnt = 0;

				$.each(list_array, function(i,v){
					var prd = {};
					prd["categoryType"] = "PRODUCT";
				  prd["categoryId"] = "GENERAL";
					prd['uid'] = v.uid;
					prd['name'] = v.name;
					prd['count'] = parseInt(v.count);

					prd_arr.push(prd);

					total_cnt = total_cnt+parseInt(v.count);
				});

				setTimeout(function(){
					$(".review_addfile_loading_wrap").hide(),
					oPay.open({ // 네이버페이 결제 모듈
						"merchantPayKey": "<?=$TRADE_CODE?>",
						"productName": "<?=$cart_list[0]->goods_name?>",
						"totalPayAmount": total_price,
						"taxScopeAmount": total_price,
						"taxExScopeAmount": 0,
						"returnUrl": "/html/dh_order/shop_order",
						"productCount": parseInt(total_cnt),
						"productItems": prd_arr
					});
				},1000);
    });

		//callback function
		function callback_naver(paymentId){

			$.ajax({
				url:"<?=cdir()?>/dh_order/naver_pay",
				type:"POST",
				dataType:"json",
				cache:false,
				data: {paymentId:paymentId,trade_code:"<?=$TRADE_CODE?>"},
				error:function(xhr){
					console.log(xhr.responseText);
				},
				success:function(data){
					if(data.code=="Success"){
						//alert("결제완료되었습니다.")
						//location.href='<?=cdir()?>/dh_order/shop_order_ok/'+data.body.detail.merchantPayKey;

						$(".review_addfile_loading_wrap").show();
						setTimeout(function(){
							$(".review_addfile_loading_wrap").hide(),
								alert("결제완료되었습니다.")
								location.href='<?=cdir()?>/dh_order/shop_order_ok/'+data.body.detail.merchantPayKey;
						},1000);


					}else{
						alert(data.message);
					}
				}
			});
		}

</script>

