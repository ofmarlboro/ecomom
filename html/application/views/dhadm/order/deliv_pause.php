<!doctype html>
<html lang="ko">
<head>
	<title>에코맘 산골이유식 : 배송 일시정지</title>
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
	<script type="text/javascript">

		$(function(){
			$(".layer_pop_inner").css('top','0');
			$('html').css('overflow-x','hidden');
		});

		function send_pause(){
			var deliv_count = "<?=$arr_deliv_date_to_count[$deliv_date]?>";
			if(confirm(deliv_count+"회차부터 배송이 정지됩니다.\n다시 배송을 받으시려면 배송재시작을 눌러주세요.")){
				document.pause.submit();
			}
		}

		function send_pause_none(){
			alert("죄송합니다.\n배송일정에 다른 주문이 포함되어있는 관계로 배송 일시정지를 바로 하실 수 없습니다.\n1대1문의를 통해 접수해 주세요.");
			opener.document.location.href='/html/dh_board/lists/withcons07/?myqna=Y';
			self.close();
		}

	</script>
</head>
<body>
	<div style="padding:10px;">
		<h1 style="font-size:14px;font-weight:600;">배송 일시정지 ( <?=$this->input->get('deliv_code')?> )</h1>
		<div class="mt20"></div>

		<form method="post" name="pause" id="pause">
			<input type="hidden" name="deliv_code" value="<?=$deliv_code?>">
			<input type="hidden" name="recom_week_type" value="<?=$trade_info->recom_week_type?>">
			<input type="hidden" name="recom_week_count" value="<?=$trade_info->recom_week_count?>">
			<input type="hidden" name="thiscount" value="<?=$arr_deliv_date_to_count[$deliv_date]?>">
			<input type="hidden" name="remain_pack_ea" value="<?=$remain_pack_ea?>">
		</form>
		<div class="layer_pop_inner">
			<h1>
				배송일지정지
			</h1>
			<div class="bg">
				<p class="bu03">
					배송 일시정지는 실시간으로 적용됩니다.
				</p>
				<p class="bu03">
					지금 배송 일시정지를 요청하시면<br><span class="blue mr5"><?=$arr_deliv_date_to_count[$deliv_date]?>회차 : <?=$deliv_date?> <?=numberToWeekname($deliv_date)?>요일</span>부터 일시정지가 됩니다.
				</p>
				<p class="blue fs12 mt10">
					※ 배송 일시정지는 배송일 3일전까지 요청하실 수 있습니다.<br>
					※ 이후 재시작을 원하실 경우 "배송 재시작"을 눌러주세요.
				</p>
			</div>
		</div>
		<p class="mt50 align-c">
			<button class="btn_ok" onclick="send_pause()">배송 일시정지</button>
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
