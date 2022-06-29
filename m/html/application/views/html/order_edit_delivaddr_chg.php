<!doctype html>
<html lang="ko">
<head>
	<title>배송지변경 - 에코맘 산골이유식</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<!-- <meta name="viewport" content="width=1300"> -->
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="Author" content="Design hub">
	<meta name="Author" content="Wookju Choi">
	<meta name="Author" content="에코맘의 산골이유식">
	<meta name="designer" content="Miso Choi">

	<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
	<script>
    function closeDaumPostcode() {
			var element_layer = document.getElementById('layer_post');
        // iframe을 넣은 element를 안보이게 한다.
        element_layer.style.display = 'none';
    }

    function sample2_execDaumPostcode() {
			var element_layer = document.getElementById('layer_post');
        new daum.Postcode({
            oncomplete: function(data) {
                // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var fullAddr = data.address; // 최종 주소 변수
                var extraAddr = ''; // 조합형 주소 변수

                // 기본 주소가 도로명 타입일때 조합한다.
                if(data.addressType === 'R'){
                    //법정동명이 있을 경우 추가한다.
                    if(data.bname !== ''){
                        extraAddr += data.bname;
                    }
                    // 건물명이 있을 경우 추가한다.
                    if(data.buildingName !== ''){
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                    fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('zipcode').value = data.zonecode; //5자리 새우편번호 사용
                document.getElementById('addr1').value = fullAddr;
                //document.getElementById('sample2_addressEnglish').value = data.addressEnglish;

                // iframe을 넣은 element를 안보이게 한다.
                // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
                element_layer.style.display = 'none';

								document.getElementById('addr2').value="";
								document.getElementById('addr2').focus();
            },
            width : '100%',
            height : '100%',
            maxSuggestItems : 5
        }).embed(element_layer);

        // iframe을 넣은 element를 보이게 한다.
        element_layer.style.display = '';

        // iframe을 넣은 element의 위치를 화면의 가운데로 이동시킨다.
        initLayerPosition();
    }

    // 브라우저의 크기 변경에 따라 레이어를 가운데로 이동시키고자 하실때에는
    // resize이벤트나, orientationchange이벤트를 이용하여 값이 변경될때마다 아래 함수를 실행 시켜 주시거나,
    // 직접 element_layer의 top,left값을 수정해 주시면 됩니다.
    function initLayerPosition(){
			var element_layer = document.getElementById('layer_post');
        var width = 300; //우편번호서비스가 들어갈 element의 width
        var height = 300; //우편번호서비스가 들어갈 element의 height
        var borderWidth = 1; //샘플에서 사용하는 border의 두께

        // 위에서 선언한 값들을 실제 element에 넣는다.
        element_layer.style.width = width + 'px';
        element_layer.style.height = height + 'px';
        element_layer.style.border = borderWidth + 'px solid';
        // 실행되는 순간의 화면 너비와 높이 값을 가져와서 중앙에 뜰 수 있도록 위치를 계산한다.
        element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width)/2 - borderWidth) + 'px';
        element_layer.style.top = (((window.innerHeight || document.documentElement.clientHeight) - height)/2 - borderWidth) + 'px';
    }
	</script>

	<link type="text/css" rel="stylesheet" href="//cdn.rawgit.com/hiun/NanumSquare/master/nanumsquare.css" />
	<link type="text/css" rel="stylesheet" href="/m/css/@default.css?t=<?=time()?>" />
	<script type="text/javascript" src="/m/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="/m/js/jquery.easing.min.js"></script>
	<script type="text/javascript" src="/m/js/placeholders.min.js"></script>
	<script type="text/javascript" src="/m/js/slick.min.js"></script>
	<script type="text/javascript" src="/m/js/setting.js?t=<?=time()?>"></script>
	<script type="text/javascript" src="/m/js/common.js?t=<?=time()?>"></script>
	<script type="text/javascript" src="/_data/js/form.js"></script>
	<script type="text/javascript">
	<!--
		$(function(){
			<?if($row->deliv_addr != "self"){?>
			$(".self_btn").hide();
			<?}?>

			$("input[type='checkbox'][name='check']").click(function(){
				if($(this).prop('checked')){
					$("input[type='checkbox'][name='check']").prop('checked',false);
					$(this).prop('checked',true);
				}
			});
		});

		function call_deliv_addr(val){
			if(val == "self"){
				var userid = "<?=$this->session->userdata('USERID')?>";
				$.ajax({
					url:"<?=cdir()?>/dh_order/call_deliv_addr/?val="+val+"&userid="+userid,
					type:"GET",
					dataType:"json",
					error:function(xhr){
						console.log(xhr.responseText);
					},
					success:function(data){
						//console.log(data);
						$("#recv_name").val(data.name);
						$("#recv_phone").val(data.phone);
						$("#zipcode").val('');
						$("#addr1").val('');
						$("#addr2").val('').attr('type','text');
						$("#addr2").prop('readonly',false);
						$(".self_btn").show();
					}
				});

			}
			else{
				$(".self_btn").hide();
				//$("#addr2").val('').attr('type','hidden');
				$("#addr2").prop('readonly',true);
				var userid = "<?=$this->session->userdata('USERID')?>";
				$.ajax({
					url:"<?=cdir()?>/dh_order/call_deliv_addr/?val="+val+"&userid="+userid,
					type:"GET",
					dataType:"json",
					error:function(xhr){
						console.log(xhr.responseText);
					},
					success:function(data){
						//console.log(data);
						$("#recv_name").val(data.name);
						$("#recv_phone").val(data.phone);
						$("#zipcode").val(data.zipcode);
						$("#addr1").val(data.addr1);
						$("#addr2").val(data.addr2);
					}
				});
			}
		}

		function deliv_addr_manage(){
			if(confirm('현재창을 닫고 페이지를 이동합니다.')){
				opener.location.href='<?=cdir()?>/dh/adrs_adm';
				self.close()
			}
		}
	//-->
	</script>
</head>
<body>
	<div class="layer_pop">
	<?php
	if($dup_cnt){
	?>
		<div class="pt20">
			<form name="addr_chg" id="addr_chg" method="post">
			<input type="hidden" name="trade_code" value="<?=$row->trade_code?>">
			<input type="hidden" name="deliv_code" value="<?=$row->deliv_code?>">
				<h1>
					<span class="pop_bag" style="margin-right:10px"><?=$deliv_type_name?></span>배송지 변경
				</h1>
				<div class="inner">
					<div class="bu03">
						<?=date("m/d",strtotime($row->deliv_date))?>(<?=numberToWeekname($row->deliv_date)?>) <?=$prod_name?>
					</div>

					<div class="blue">
						※ 배송일이 동일한 다른 주문건이 있습니다.<br>&nbsp;&nbsp;&nbsp;
							 배송비 정책에 의하여 배송지를 바로 변경 하실 수 없습니다.<br>
							 1:1문의게시판을 이용해주세요.
					</div>

					<p class="jung">
						배송일이 중복된 주문 내용입니다.
					</p>

					<ul class="jung02">
						<?php
						foreach($dup_list as $dl){
						?>
						<li><?=date("m/d",strtotime($dl->deliv_date))?> (<?=numberToWeekname($dl->deliv_date)?>) <?=$dl->prod_name?> (<?=$dl->trade_code?>)</li>
						<?php
						}
						?>
					</ul>
				</div>


				<div class="ac mt20"><button type="button" class="btn_y" title="닫기" onclick='self.close();'>취소</button>
				<button type="button" class="btn_y" title="닫기" onclick='change_deliv_addr_none();'>변경</button></div>


				<!-- <a href="javascript:;" class="btn_close" onclick='closeMenuView();'></a> -->
			</form>
		</div>
	<?php
	}
	else{
	?>
		<div class="pt20">
			<form name="addr_chg" id="addr_chg" method="post">
			<input type="hidden" name="trade_code" value="<?=$row->trade_code?>">
			<input type="hidden" name="deliv_code" value="<?=$row->deliv_code?>">
				<h1>
					<span class="pop_bag" style="margin-right:10px"><?=$deliv_type_name?></span>배송지 변경
				</h1>
				<div class="inner">
					<div class="bu03">
						<?=date("m/d",strtotime($row->deliv_date))?>(<?=numberToWeekname($row->deliv_date)?>) <?=$prod_name?>
					</div>
					<div>
							<select name="deliv_addr" id="" class="pop_sel mb5" onchange="call_deliv_addr(this.value)" style="vertical-align:top;">
								<option value="home" <?=($row->deliv_addr == "home" or $row->deliv_addr == "")?"selected":"";?>>자택</option>
								<?if($member_info->sidc_zip && $member_info->sidc_addr1 && $member_info->sidc_addr2){?><option value="sidc" <?=($row->deliv_addr == "sidc")?"selected":"";?>>시댁</option><?}?>
								<?if($member_info->chin_zip && $member_info->chin_addr1 && $member_info->chin_addr2){?><option value="chin" <?=($row->deliv_addr == "chin")?"selected":"";?>>친정</option><?}?>
								<?if($member_info->bomo_zip && $member_info->bomo_addr1 && $member_info->bomo_addr2){?><option value="bomo" <?=($row->deliv_addr == "bomo")?"selected":"";?>>보모</option><?}?>
								<?if($member_info->oth1_zip && $member_info->oth1_addr1 && $member_info->oth1_addr2){?><option value="oth1" <?=($row->deliv_addr == "oth1")?"selected":"";?>>기타1</option><?}?>
								<?if($member_info->oth2_zip && $member_info->oth2_addr1 && $member_info->oth2_addr2){?><option value="oth2" <?=($row->deliv_addr == "oth2")?"selected":"";?>>기타2</option><?}?>
								<option value="self" <?=($row->deliv_addr == "self")?"selected":"";?>>새로입력</option>
							</select>
							<button type="button" class="self_btn plain pop_sel adrBtn" onclick="sample2_execDaumPostcode()">주소검색</button>

							<br>
							<input type="text" class="pop_in" style="width:150px" name="name" id="recv_name" value="<?=$row->recv_name?>" placeholder="받는분 성함">
							<br>
							<input type="text" class="pop_in" style="width:200px" name="phone" id="recv_phone" value="<?=$row->recv_phone?>" placeholder="받는분 연락처">
							<br>

							<input type="text" class="pop_in addr1 wid100" name="addr1" id="addr1" readonly value="<?=$row->addr1?>" placeholder="주소">
							<input type="hidden" class="zipcode" name="zipcode" id="zipcode" value="<?=$row->zipcode?>">
							<p style="height:2px;"></p>

							<!-- <input type="<?=($row->deliv_addr == "self")?"text":"hidden";?>" class="pop_in addr2 wid100" name="addr2" id="addr2" value="<?=$row->addr2?>" placeholder="상세주소"> -->
							<input type="text" class="pop_in addr2 wid100" name="addr2" id="addr2" value="<?=$row->addr2?>" placeholder="상세주소" readonly>

							<div id="layer_post" style="display:none;position:fixed;overflow:hidden;z-index:1;-webkit-overflow-scrolling:touch;">
								<img src="//t1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()" alt="닫기 버튼">
							</div>
					</div>


					<div class="gray mt10">
						변경하실 주소를 선택하여 주세요.
					</div>
					<div class="blue">
						※마이페이지>배송지관리에서 주소를 관리하실 수 있습니다.
					</div>
					<div class="ac">
						<a href="javascript:;" class="btn_g mt10" onclick="deliv_addr_manage()">배송지 관리</a>
					</div>

					<?php
				if($deliv_type_name == "정기배송"){
				?>
				<p class="mt20"><input type="checkbox" id="all" name="check" value="all"><label for="all" style="margin-left:5px">이후부터 일괄 적용하기</label></p>
				<p><input type="checkbox" id="once" name="check" value="once"><label for="once" style="margin-left:5px">1회만 적용하기</label></p>
				<?php
				}
				?>

				</div>


				<div class="ac mt20"><button type="button" class="btn_y" title="닫기" onclick='self.close();'>취소</button>
				<button type="button" class="btn_y" title="닫기" onclick='change_deliv_addr();'>변경</button></div>


				<!-- <a href="javascript:;" class="btn_close" onclick='closeMenuView();'></a> -->
			</form>
		</div>
	<?php
	}
	?>

	</div>

	<script type="text/javascript">
		function change_deliv_addr(){

			var d_add_val = $("#addr1").val();

			$.ajax({
				url:"<?=cdir()?>/dh/deliv_addr_check/?ajax=1&d_add_val="+encodeURIComponent(d_add_val),
				type:"GET",
				cache:false,
				error:function(xhr){
					console.log(xhr.responseText);
				},
				success:function(data){
					if(data){
						alert("이유식은 신선유통을 위해\n제주 및 도서산간 지역에는 배송이 어렵습니다.\n\n산골 간식 및 건강식품을 구매를 원하시는 경우\n유선으로 별도 문의 부탁드립니다.");
						return false;
					}
					else{
						var frm = document.addr_chg;

						if(frm.name.value == ""){
							alert("받는분 성함을 입력해주세요.");
							return;
						}

						if(frm.phone.value == ""){
							alert("받는분 연락처를 입력해주세요.");
							return;
						}

						if(frm.addr1.value == ""){
							alert("주소를 입력해 주세요.");
							return;
						}

						if(frm.addr2.value == ""){
							alert("상세주소를 입력해 주세요.");
							return;
						}

						<?if($deliv_type_name == "정기배송"){?>
						if(frm.check[0].checked == false && frm.check[1].checked == false){
							alert("배송지 변경방식을 선택해 주세요.");
							return;
						}
						<?}?>

						frm.submit();
					}
				}
			});

		}

		function change_deliv_addr_none(){
			alert("주문 시, 배송비 무료로 결제한 주문이\n포함된 경우 배송지 직접변경이 불가합니다\n예: 정기배송+간식주문 했을 시\n\n1:1문의게시판을 이용해주세요");
			opener.document.location.href='/m/html/dh_board/lists/withcons07/?myqna=Y';
			self.close();
		}
	</script>
</body>
</html>
