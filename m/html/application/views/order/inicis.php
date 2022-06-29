<?
	$nowDate = date('Ymd');
	$nextDate = date("Ymd",strtotime("+7 day",strtotime($nowDate)));

	if($this->input->get("nologin")){
		$nolog = "?nologin=1";
	}
?>
				<form method="post" name="trade_form" style="margin:0px;padding:0px;" accept-charset="euc-kr">
					<input type="hidden" name="P_OID" value="<?=$TRADE_CODE?>">
					<input type="hidden" name="P_GOODS" value="<? echo $totalCnt>1 ? $cart_list[0]->goods_name." 외" : $cart_list[0]->goods_name; ?>">
					<input type="hidden" name="P_AMT" value="">
					<input type="hidden" name="P_UNAME" value="">
					<input type="hidden" name="P_EMAIL" value="">

          <select name="paymethod" id="paymethod" style="display:none;">
					<option value="wcard">신용카드
					<option value="bank">계좌이체
					<option value="vbank">가상계좌
					<option value="mobile">휴대폰
            </select>
					<input type="hidden" name="inipaymobile_type" value="web">

					<input type="hidden" name="P_MID" value="<?=$shop_info['pg_id']?>">
					<input type="hidden" name="P_NEXT_URL" value="<?=ssl_check()?>://<?=$_SERVER['HTTP_HOST']?>/pay/INIpay50/m/mx_rnext.php<?=$nolog?>">
					<input type="hidden" name="P_NOTI_URL" value="<?=ssl_check()?>://<?=$_SERVER['HTTP_HOST']?>/m/html/dh_order/vacctinput_m">
					<input type="hidden" name="P_RETURN_URL" value="<?=ssl_check()?>://<?=$_SERVER['HTTP_HOST']?>/m/html/dh_order/inicis_dbank_return/?P_OID=<?=$TRADE_CODE?>&P_NOTI=<?=$this->uri->segment(3)?>">
					<input type="hidden" name="P_HPP_METHOD" value="2">
					<input type="hidden" name="P_NOTI" value="<?=$this->uri->segment(3)?>/<?=$sample_is?>">
					<input type="hidden" name="P_RESERVED" value="">
					<input type="hidden" name="trade_code" value="<?=$TRADE_CODE?>">
					<input type="hidden" name="trade_ok" value="">
					<input type="hidden" name="tmp" value="1">
					<input type="hidden" name="P_VBANK_DT" value="<?=$nextDate?>">
				</form>
				<script type="text/javascript">
				<!--
					window.name = "BTPG_CLIENT";

					function checkPay(){

						var trade_method = $("input[name='trade_method']:checked").val();

						//인앱브라우저에서 아이폰으로 ISP 결제시 되돌아오는 값을 찾지 못하고 사파리로 돌아가면서 서버와 연결이 끊어진다는 메세지 발생에 대한 대체법
						var app_scheme = "";
						var UserAgent = navigator.userAgent;
						if(UserAgent.match(/KAKAOTALK/i) != null){		//카카오톡 인앱브라우저
							app_scheme = "&app_scheme=kakaotalk://";
						}else if(UserAgent.match(/NAVER/i) != null){	//네이버 앱
							app_scheme = "&app_scheme=naversearchapp://";
						}else if(UserAgent.match(/DAUM/i) != null){		//다음 앱
							app_scheme = "&app_scheme=daumapps://";
						}else if(UserAgent.match(/FB/i) != null){			//페북 앱
							app_scheme = "&app_scheme=fb://";
						}
						//아이폰 버그 종료

						if(trade_method==1){	//신용카드
							$("#paymethod option:eq(0)").prop("selected", "selected");
							$("input[name='P_RESERVED']").val("twotrs_isp=Y&block_isp=Y&twotrs_isp_noti=N&apprun_check=Y&extension_enable=Y"+app_scheme);
						}else if(trade_method==3){	//계좌이체
							$("#paymethod option:eq(1)").prop("selected", "selected");
							$("input[name='P_RESERVED']").val("twotrs_bank=Y&apprun_check=Y&bank_receipt=Y&extension_enable=Y"+app_scheme);
						}else if(trade_method==4){	//가상계좌
							$("#paymethod option:eq(2)").prop("selected", "selected");
							$("input[name='P_RESERVED']").val("vbank_receipt=Y&apprun_check=Y&extension_enable=Y"+app_scheme);
						}else if(trade_method==7){	//휴대폰소액
							$("#paymethod option:eq(3)").prop("selected", "selected");
							$("input[name='P_RESERVED']").val("apprun_check=Y&extension_enable=Y"+app_scheme);
						}
						var total_price = $("#total_price").val();

						var frm = document.trade_form;
						var pmd = frm.paymethod.value;

						frm.P_AMT.value=total_price;
						frm.P_UNAME.value=document.order_form.name.value;
						frm.P_EMAIL.value=document.order_form.email.value;

						var oid = "<?=$TRADE_CODE?>";

							//여러 브라우저로 뻘짓하는 모바일 사용자들의 병신짓을 막기위해
							// 금액 검증 ( 브라우져 여러개로 병신짓하는 놈들 색출 )
							// tmp 존재여부 검증 ( 누락시 주문정보 누락 )
							// 장바구니 DB 존재여부 검증 ( 누락시 주문상품 누락 )
							// 배송일 검증
							$.ajax({
								url:"/m/html/dh_order/order_verification",
								type:"GET",
								cache:false,
								data:{'ajax':1,'trade_code':oid,'pg_price':'<?=$totalPrice?>','userid':'<?=$this->session->userdata("USERID")?>'},
								dataType:"json",
								error:function(xhr){
									console.log(xhr.responseText);
								},
								success:function(res){

									if(!res.cart_verific){
										alert("장바구니에 담긴 상품의 총액이 주문하시는 총액과 같지 않습니다.");
										location.reload();
										return;
									}
									else if(!res.deliv_date){
										alert("장바구니에 담긴 상품의 배송일 설정이 잘못되었습니다.");
										location.reload();
										return;
									}
									else if(!res.tmp_cnt){
										alert("주문 정보가 확인되지 않습니다.");
										location.reload();
										return;
									}
									else{
										frm.acceptCharset = "euc-kr";
										frm.action = "https://mobile.inicis.com/smart/" + pmd + "/";
										frm.submit();
									}
								}
							});
					}
				//-->
				</script>

<iframe name="chkFrm" frameborder="0" style="display:none;"></iframe>