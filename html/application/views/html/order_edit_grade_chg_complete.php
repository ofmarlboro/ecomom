<!doctype html>
<html lang="ko">
<head>
	<title>단계변경완료 - 에코맘 산골이유식</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=1300">

	<meta name="Author" content="Design hub">
	<meta name="Author" content="Wookju Choi">
	<meta name="Author" content="에코맘의 산골이유식">
	<meta name="designer" content="Miso Choi">

	<link type="text/css" rel="stylesheet" href="//cdn.rawgit.com/hiun/NanumSquare/master/nanumsquare.css" />
	<link type="text/css" rel="stylesheet" href="/css/@default.css?t=<?php echo time(); ?>" />
	<script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="/js/jquery.easing.min.js"></script>
	<script type="text/javascript" src="/js/placeholders.min.js"></script>
	<script type="text/javascript" src="/js/imagesloaded.pkgd.min.js"></script>
	<script type="text/javascript" src="/js/setting.js?t=<?php echo time(); ?>"></script>
	<script type="text/javascript" src="/js/common.js?t=<?php echo time(); ?>"></script>
	<script type="text/javascript" src="/_data/js/form.js"></script>
	<script type="text/javascript">
	<!--
		$(function(){
			$(".layer_pop_inner").css('top','0');
			$('html').css('overflow-x','hidden');
			opener.location.reload();
		});
	//-->
	</script>
</head>
<body>
	<div id="wrap" class="layout_type2 sub_layout">
		<div id="container">
			<div class="layer_pop_inner layer_pop_inner02">

				<h1>
					<span class="btn_yy" style="margin-right:10px">단계변경</span>단계 변경 완료
				</h1>

				<div class="bg">
					<!-- 단계변경 step02 결제완료 후 넘어가는 페이지-->
					<p class="bu03"><?=$reverse_recom_date[$deliv_start_date]?>회차 <?=$deliv_start_date?> <?=$deliv_start_date_week_name?>요일부터 적용됩니다.</p>
					<p class="change02"><span>변경 전</span><input type="text" readonly class='pl15' value="<?=$recom_name?>"></p>
					<p class="ac pd20">
						<img src="/image/sub/arw.png" alt="">
					</p>
					<p class="change02"><span>변경 후</span><input type="text" readonly class='pl15' value="<?=$chg_recom_name?>"></p>
					<p class="gray mt10">※ <?=$reverse_recom_date[$deliv_start_date]?>회차 : <?=$deliv_start_date?> <?=$deliv_start_date_week_name?>요일부터 <span class="blue">"<?=$chg_recom_name?>”</span>(으)로 배송됩니다.</p>
					<p class="ac bd">
						<a href="javascript:;" class="btn_big" onclick='self.close();'>닫기</a>
					</p>
					<!-- //단계변경 step02 -->
				</div>
				<a href="javascript:;" class="btn_close" onclick='self.close();'><span style="display:none;">X</span></a>




			</div>
		</div>
	</div>
</body>
</html>