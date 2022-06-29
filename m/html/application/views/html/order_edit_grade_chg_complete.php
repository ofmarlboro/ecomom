<!doctype html>
<html lang="ko">
<head>
	<title>단계변경완료 - 에코맘 산골이유식</title>
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
		$(function(){
			opener.location.reload();
		});
	</script>
</head>
<body>
	<div class="layer_pop">
		<div class="pt20">

			<h1>
				단계 변경
			</h1>

			<div class="inner">
				<!-- 단계변경 step02 결제완료 후 넘어가는 페이지-->
				<p class="ac fz16 mb10">단계변경이 완료되었습니다.</p>
				<p><span>변경 전</span><input type="text" class="oe_input" readonly value="<?=$recom_name?>" style="padding-left:5px"></p>
				<p class="ac pd20"><img src="/image/sub/arw.png" alt=""></p>
				<p><span>변경 후</span><input type="text" class="oe_input" readonly value="<?=$chg_recom_name?>" style="padding-left:5px"></p>
				<p class="gray mt10">※ <?=$reverse_recom_date[$deliv_start_date]?>회차 : <?=$deliv_start_date?> <?=$deliv_start_date_week_name?>요일부터 <span class="blue">“<?=$chg_recom_name?>”</span>으로 배송됩니다.</p>

				<!-- //단계변경 step02 -->



			</div>
<div class="ac mt20">	<button type="button" class="btn_y" title="취소" onclick='self.close()'>닫기</button></div>

				<!-- <button type="button" class="w50 close" title="변경">변경</button> -->




		</div>
	</div>
</body>
</html>