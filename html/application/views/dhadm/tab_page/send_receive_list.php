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

<?php
include $_SERVER['DOCUMENT_ROOT']."/html/application/views/dhadm/od.view.meminfo.top.php";
?>

<table class="adm-tab mt20 mb20">
	<tr>
		<th <?if($mode == "view"){?>class="on"<?}?>><a href="<?=cdir()?>/order/lists/m/view/<?=$trade_idx?>/<?=$query_string.$param?>">주문상품목록</a></th>
		<th <?if($mode == "payment"){?>class="on"<?}?>><a href="<?=cdir()?>/order/lists/m/payment/<?=$trade_idx?>/<?=$query_string.$param?>">주문결제내역</a></th>
		<th <?if($mode == "memo"){?>class="on"<?}?>><a href="<?=cdir()?>/order/lists/m/memo/<?=$trade_idx?>/<?=$query_string.$param?>">회원/주문메모</a></th>
		<th <?if($mode == "send_receive"){?>class="on"<?}?>><a href="<?=cdir()?>/order/lists/m/send_receive/<?=$trade_idx?>/<?=$query_string.$param?>">주문/받는사람</a></th>
	</tr>
</table>

<h3 class="icon-check">주문/받는 사람</h3>

<div class="float-wrap">
<form method="post" name="srfrm" id="srfrm">
<input type="hidden" name="idx" value="<?=$trade_idx?>">
	<div class="float-l" style="width:49%;">
		<table class="adm-table">
			<tr>
				<th colspan="2">주문하신분</th>
			</tr>
			<tr>
				<th>이름</th>
				<td><input type="text" name="name" value="<?=$trade_stat->name?>" msg="주문자 성명을"></td>
			</tr>
			<tr>
				<th>핸드폰</th>
				<td><input type="text" name="phone" value="<?=$trade_stat->phone?>" msg="주문자 연락처를"></td>
			</tr>
			<tr>
				<th>E-mail</th>
				<td><input type="text" name="email" value="<?=$trade_stat->email?>" msg="주문자 이메일을"></td>
			</tr>
		</table>
	</div>

	<div class="float-r" style="width:49%;">
		<table class="adm-table">
			<tr>
				<th colspan="2">받으시는분</th>
			</tr>
			<tr>
				<th>이름</th>
				<td><input type="text" name="send_name" value="<?=$trade_stat->send_name?>" msg="받는분 성명을"></td>
			</tr>
			<tr>
				<th>핸드폰</th>
				<td><input type="text" name="send_phone" value="<?=$trade_stat->send_phone?>" msg="받는분 연락처를"></td>
			</tr>
			<tr>
				<th>주소</th>
				<td>
					<input type="text" name="zip1" id="zipcode1" value="<?=$trade_stat->zip1?>" readonly msg="받는분 주소를"> <input type="button" value="우편번호검색" onclick="sample6_execDaumPostcode()"><br>
					<input type="text" class="width-l" name="addr1" id="address1" value="<?=$trade_stat->addr1?>" readonly msg="받는분 주소를"><br>
					<input type="text" class="width-l" name="addr2" id="address2" value="<?=$trade_stat->addr2?>" msg="받는분 주소를">
				</td>
			</tr>
			<tr>
				<th>비상연락처</th>
				<td><input type="text" name="send_tel" value="<?=$trade_stat->send_tel?>" msg="비상연락처를"></td>
			</tr>
		</table>
	</div>
</form>
</div>

<div class="float-wrap mt40">
	<div class="float-l">
		<a href="<?=cdir()?>/order/lists/m/<?=$query_string.$param?>" class="btn-clear button btn-l">목록으로</a>
		<!-- <a href="javascript:frmChk('srfrm');" class="button btn-l">수정하기</a> -->
	</div>
	<div class="float-r">

		<!-- <button type="button" class="btn-special btn-xl" onclick="">출력하기</button> -->
		<!-- <input type="button" value="저장하기" class="btn-ok btn-xl" onclick=""> -->
		<!-- <? if($trade_stat->trade_method==1){?><input type="button" value="카드취소" class="btn-special btn-xl" onclick="cancel()"><?}?> -->
	</div>
</div>