<script type="text/javascript">
<!--
	function recom_list_view(no){
		$('#recom_list'+no).toggle();
	}

	function view_recom_foods(idx){
		window.open("<?=cdir()?>/order/delivery/m/recom_foods_pop/?ajax=1&idx="+idx,"recom_foods","width=600,height=800");
	}

	function view_foods_list(code){
		window.open("<?=cdir()?>/order/delivery/m/foods_list/?ajax=1&code="+code,"deliv_foods","width=600,height=800");
	}
//-->
</script>

<style type="text/css">
	.adm-tab{
		border-bottom:2px solid #000;
	}
	.adm-tab th{
		padding:10px;
	}
	.adm-tab th.on{
		border-top:2px solid #000;
		background:#eee;
	}

	.sobigdick{
		font-weight:600;
		font-size:30px;
	}
</style>

<h1 class="sobigdick"><?=$row->order_name?>, <?=$row->userid?>, <?=$row->order_phone?></h1>

<table class="adm-tab mt20 mb20">
	<tr>
		<th <?if($mode == "view"){?>class="on"<?}?>><a href="<?=cdir()?>/order/delivery/m/view/<?=$deliv_code?>/<?=$query_string.$param?>">배송상품 목록</a></th>
		<th <?if($mode == "order_change"){?>class="on"<?}?>><a href="<?=cdir()?>/order/delivery/m/order_change/<?=$deliv_code?>/<?=$query_string.$param?>">주문 변동내역</a></th>
		<th <?if($mode == "memo"){?>class="on"<?}?>><a href="<?=cdir()?>/order/delivery/m/memo/<?=$deliv_code?>/<?=$query_string.$param?>">회원/주문메모</a></th>
		<th <?if($mode == "send_receive"){?>class="on"<?}?>><a href="<?=cdir()?>/order/delivery/m/send_receive/<?=$deliv_code?>/<?=$query_string.$param?>">주문/받는사람</a></th>
	</tr>
</table>

<h3 class="icon-check">주문/받는 사람</h3>

<div class="float-wrap">
<form method="post" name="srfrm" id="srfrm">
<input type="hidden" name="deliv_code" value="<?=$deliv_code?>">
	<div class="float-l" style="width:49%;">
		<table class="adm-table">
			<tr>
				<th colspan="2">주문하신분</th>
			</tr>
			<tr>
				<th>이름</th>
				<td><input type="text" name="order_name" value="<?=$row->order_name?>" msg="주문자 성명을"></td>
			</tr>
			<tr>
				<th>핸드폰</th>
				<td><input type="text" name="order_phone" value="<?=$row->order_phone?>" msg="주문자 연락처를"></td>
			</tr>
			<!-- <tr>
				<th>E-mail</th>
				<td><input type="text" name="email" value="<?=$row->email?>"></td>
			</tr> -->
		</table>
	</div>

	<div class="float-r" style="width:49%;">
		<table class="adm-table">
			<tr>
				<th colspan="2">
					받으시는분
									<select name="deliv_addr_set" onchange="addr_change(this.value)">
										<option value="home">자택</option>
										<option value="chin">친정</option>
										<option value="sidc">시댁</option>
										<option value="bomo">보모</option>
										<option value="oth1">기타1</option>
										<option value="oth2">기타2</option>
									</select>
									<script type="text/javascript">
									<!--
										function addr_change(val){
											$.ajax({
												url:"/html/dh_order/addr_change/?type="+val+"&userid=<?=$row->userid?>",
												type:"GET",
												dataType:"json",
												error:function(xhr){
													console.log(xhr.responseText);
												},
												success:function(data){
													//console.log(data);
													$("input[name='recv_name']").val(data.name);
													$("input[name='recv_phone']").val(data.phone1+"-"+data.phone2+"-"+data.phone3);
													$("input[name='zipcode']").val(data.zipcode);
													$("input[name='addr1']").val(data.address1);
													$("input[name='addr2']").val(data.address2);
												}
											});
										}
										deliv_addr_set = document.srfrm.deliv_addr_set;
										for(i=0;i<deliv_addr_set.length;i++){
											if(deliv_addr_set.options[i].value == "<?=$row->deliv_addr?>"){
												deliv_addr_set.options[i].selected = true;
											}
										}
									//-->
									</script>
				</th>
			</tr>
			<tr>
				<th>이름</th>
				<td><input type="text" name="recv_name" value="<?=$row->recv_name?>" msg="받는분 성명을"></td>
			</tr>
			<tr>
				<th>핸드폰</th>
				<td><input type="text" name="recv_phone" value="<?=$row->recv_phone?>" msg="받는분 연락처를"></td>
			</tr>
			<tr>
				<th>주소</th>
				<td>
					<input type="text" name="zipcode" id="zipcode1" value="<?=$row->zipcode?>" readonly msg="받는분 주소를"> <input type="button" value="우편번호검색" onclick="sample6_execDaumPostcode()"><br>
					<input type="text" class="width-l" name="addr1" id="address1" value="<?=$row->addr1?>" readonly msg="받는분 주소를"><br>
					<input type="text" class="width-l" name="addr2" id="address2" value="<?=$row->addr2?>" msg="받는분 주소를">
				</td>
			</tr>
			<!-- <tr>
				<th>비상연락처</th>
				<td><input type="text" name="send_tel" value="<?=$row->send_tel?>"></td>
			</tr> -->
		</table>
	</div>
</form>
</div>

<div class="float-wrap mt40">
	<div class="float-l">
		<a href="<?=cdir()?>/order/delivery/m/<?=$query_string.$param?>" class="btn-clear button btn-l">목록으로</a>
		<a href="javascript:frmChk('srfrm');" class="button btn-l">수정하기</a>
	</div>
	<div class="float-r">

		<!-- <button type="button" class="btn-special btn-xl" onclick="">출력하기</button> -->
		<!-- <input type="button" value="저장하기" class="btn-ok btn-xl" onclick=""> -->
		<!-- <? if($row->trade_method==1){?><input type="button" value="카드취소" class="btn-special btn-xl" onclick="cancel()"><?}?> -->
	</div>
</div>

<?php
if($dup_list){
?>
<div>
	<p class="jung">
		배송일이 중복된 주문 내용입니다.
	</p>

	<ul class="jung02">
		<?php
		foreach($dup_list as $dl){
		?>
		<li><?=date("m/d",strtotime($dl->deliv_date))?> (<?=numberToWeekname($dl->deliv_date)?>) <?=$dl->prod_name?> (<a href="/html/order/lists/m?sch_item=trade_code&sch_item_val=<?=$dl->trade_code?>"><?=$dl->trade_code?></a>)</li>
		<?php
		}
		?>
	</ul>
</div>
<?php
}
?>

<?
$flag="admin";
include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/order/".$shop_info['pg_company']."_cancel.php";
?>

