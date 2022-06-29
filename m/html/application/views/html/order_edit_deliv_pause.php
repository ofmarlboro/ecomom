<!doctype html>
<html lang="ko">
<head>
	<title>배송일시정지 - 에코맘 산골이유식</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">

	<meta name="Author" content="Design hub">
	<meta name="Author" content="Wookju Choi">
	<meta name="Author" content="에코맘의 산골이유식">
	<meta name="designer" content="Miso Choi">

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
		function send_pause(){
			var deliv_count = "<?=$arr_deliv_date_to_count[$deliv_date]?>";
			if(confirm(deliv_count+"회차부터 배송이 정지됩니다.\n다시 배송을 받으시려면 배송재시작을 눌러주세요.")){
				document.pause.submit();
			}
		}

		function send_pause_none(){
			alert("주문 시, 배송비 무료로 결제한 주문이\n포함된 경우 배송일시정지 직접변경이 불가합니다\n예: 정기배송+간식주문 했을 시\n\n1:1문의게시판을 이용해주세요");
			opener.document.location.href='/m/html/dh_board/lists/withcons07/?myqna=Y';
			self.close();
		}
	</script>
</head>
<body>
	<div class="layer_pop">
	<?php
	if($dup_cnt){
	?>
		<div class="pt20">
			<h1>
				배송일지정지
			</h1>
			<div class="inner clearfix">

				<p class="blue fs12 mt10">
							※ 배송일이 동일한 다른 주문건이 있습니다.<br>&nbsp;&nbsp;&nbsp;
							   배송비 정책에 의하여 배송일지정지를 바로 변경 하실 수 없습니다.
				</p>

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
			<div class="ac mt20">
			<button type="button" class="btn_y" title="닫기" onclick='self.close()'>취소</button>
				<button type="button" class="btn_y" title="닫기" onclick='send_pause_none()'>배송일시정지</button>
			</div>


		</div>
	<?php
	}
	else{
	?>
		<div class="pt20">

			<form method="post" name="pause" id="pause">
				<input type="hidden" name="deliv_code" value="<?=$deliv_code?>">
				<input type="hidden" name="recom_week_type" value="<?=$trade_info->recom_week_type?>">
				<input type="hidden" name="recom_week_count" value="<?=$trade_info->recom_week_count?>">
				<input type="hidden" name="thiscount" value="<?=$arr_deliv_date_to_count[$deliv_date]?>">
				<input type="hidden" name="remain_pack_ea" value="<?=$remain_pack_ea?>">
				<input type="hidden" name="remain_deliv_count" value="<?=$remain_deliv_count?>">
			</form>

			<h1>
				배송일지정지
			</h1>
			<div class="inner clearfix">

				<p class="bu03">
					배송 일시정지는 실시간으로 적용됩니다.
				</p>

				<p class="bu03">
					지금 배송 일시정지를 요청하시면 <span class="blue mr5"><?=$arr_deliv_date_to_count[$deliv_date]?>회차 : <?=$deliv_date?> <?=numberToWeekname($deliv_date)?>요일</span>부터 일시정지가 됩니다.
				</p>
				<p class="blue fs12 mt10">
					※ 배송 일시정지는 배송일 3일전까지 요청하실 수 있습니다.<br>
					※ 이후 재시작을 원하실 경우 "배송 재시작"을 눌러주세요.
				</p>

			</div>
			<div class="ac mt20">
			<button type="button" class="btn_y" title="닫기" onclick='self.close()'>취소</button>
				<button type="button" class="btn_y" title="닫기" onclick='send_pause()'>배송일시정지</button>
			</div>


		</div>
	<?php
	}
	?>
	</div>
</body>
</html>
