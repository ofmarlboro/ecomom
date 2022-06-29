<!doctype html>
<html lang="ko">
<head>
	<title>에코맘 산골이유식 : 식단정보수정</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300" rel="stylesheet" type="text/css">
	<link type="text/css" rel="stylesheet" href="/_dhadm/css/@default.css?t=<?=time()?>" />
	<link rel="stylesheet" href="/css/jquery-ui.css">

	<script type="text/javascript" src="/_dhadm/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/jquery.min.js"></script>
	<script type="text/javascript" src="/js/jquery-ui.js"></script>
	<script type="text/javascript" src="/_dhadm/js/cal.js"></script>
	<script type="text/javascript" src="/_dhadm/js/jquery.easing.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/placeholders.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/common.js"></script>
	<script type="text/javascript" src="/_dhadm/js/form.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		//$('select[name=check]').select2();
		//$('select[name=select_it_id2]').select2();
		//$('select[name=select_it_id3]').select2();
		$(".select_jq").select2();
	});
	</script>
	<style type="text/css">
		.cntzero{
			background:#eee;
		}
	</style>
	<script type="text/javascript">
		function list_del(idx){
			if(confirm('삭제 하시겠습니까?')){
				var frm = document.delfrm;
				frm.idx.value = idx;
				frm.submit();
			}
		}
	</script>
</head>
<body style="overflow-x:hidden;">
	<div style="padding:10px;">
		<h1 style="font-size:14px;font-weight:600;">배송일 변경 ( <?=$this->input->get('deliv_code')?> )</h1>
		<div class="mt20"></div>

		<form method="post" name="goods_addfrm" id="goods_addfrm">
		<input type="hidden" name="idx" value="<?=$row->idx?>">
		<input type="hidden" name="deliv_code" value="<?=$this->input->get('deliv_code')?>">
		<input type="hidden" name="sel_date" value="<?=$row->deliv_date?>">
		<input type="hidden" name="recom_idx" value="<?=$row->recom_idx?>">

		<table class="adm-table">
			<tr>
				<th>주문번호</th>
				<td><?=$row->trade_code?></td>
			</tr>
			<tr>
				<th>배송코드</th>
				<td><?=$row->deliv_code?></td>
			</tr>
			<tr>
				<th>주문상품명</th>
				<td><?=str_replace(",","<br>",$row->prod_name)?></td>
			</tr>
			<tr>
				<th>주문자명 / 연락처</th>
				<td><?=$row->order_name?> / <?=$row->order_phone?></td>
			</tr>
			<tr>
				<th>받는분 / 연락처</th>
				<td><?=$row->recv_name?> / <?=$row->recv_phone?></td>
			</tr>
			<tr>
				<th>받는주소</th>
				<td>(<?=$row->zipcode?>)<br><?=$row->addr1?><br><?=$row->addr2?></td>
			</tr>
			<tr>
				<th>배송일자</th>
				<td>
					<input type="text" name="deliv_date" value="<?=$row->deliv_date?>" id="start_date">
				</td>
			</tr>
			<tr>
				<th colspan="2">배송이 예정된 날짜로 변경하시면,<br>배송회차가 합쳐지게 됩니다.한번 합쳐진 배송회차는 다신 분리할 수 없으니,<br>신중하게 선택하여 주시기 바랍니다.</th>
			</tr>
		</table>
		</form>
		<p class="mt50 align-c">
			<button class="btn_ok" onclick="frmChk('goods_addfrm')">수정</button>
			<button class="btn_cancel" onclick="self.close();">닫기</button>
		</p>

		<?php
		if($dup_list){
		?>
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
		<?php
		}
		?>

	</div>
</body>
</html>
