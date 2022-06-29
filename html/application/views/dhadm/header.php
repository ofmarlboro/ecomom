<!doctype html>
<html lang="ko">
 <head>
  <title><?=$shop_info['shop_name']?> 관리자모드</title>
	<meta name="Author" content="Minee_Wookchu / by DESIGN HUB">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=1200, initial-scale=1">

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300" rel="stylesheet" type="text/css">
	<link type="text/css" rel="stylesheet" href="/_dhadm/css/@default.css?time_param=<?=time()?>" />
	<!-- <link type="text/css" rel="stylesheet" href="/_dhadm/css/admin.css?t=<?=time()?>" /> -->
	<link type="text/css" href="/css/jquery-ui.css" rel="stylesheet" />

	<script type="text/javascript" src="/_dhadm/js/jquery-1.9.1.min.js"></script>
	<script src="/_dhadm/js/jquery.min.js"></script>
	<script type="text/javascript" src="/js/jquery-ui.js"></script>
	<script type="text/javascript" src="/_dhadm/js/cal.js"></script>
	<script type="text/javascript" src="/_dhadm/js/jquery.easing.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/placeholders.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/common.js"></script>
	<script type="text/javascript" src="/_dhadm/js/form.js?t=<?=time()?>"></script>
	<? include $_SERVER['DOCUMENT_ROOT']."/_data/lib/post_api.php"; ?>
 </head>
 <body>
 <!--Wrap-->
 <div id="dh-wrap" class="<? echo isset($shop_info['skin']) ? $shop_info['skin'] : "";?>">

	<!-- header -->
	<div id="dh-header">
		<h1>에코맘 산골이유식</h1>
		<div class="float-wrap">
			<!-- <p class="logo"><a href="./"><img src="../img/logo.png" alt="에코맘 산골이유식"></a></p> -->
			<p class="logo">
				<!-- <a href="<?=cdir()?>/basic/setup"><img src="<? echo isset($shop_info['logo_image']) ? "/_data/file/".$shop_info['logo_image'] : "/_dhadm/image/common/profile.png";?>" alt="<?=$shop_info['shop_name']?>" style="max-width:216px;"></a> -->
				<a href="<?=cdir()?>/basic/intro"><img src="<? echo isset($shop_info['logo_image']) ? "/_data/file/".$shop_info['logo_image'] : "/_dhadm/image/common/profile.png";?>" alt="<?=$shop_info['shop_name']?>" style="max-width:216px;"></a>
			</p>

			<ul class="tnb">
				<? if($this->session->userdata('ADMIN_LEVEL') < 2){ ?>
				<li><a href="<?=cdir()?>/dhadm/menu" title="환경 설정"><img src="/_dhadm/image/common/setting.png" alt="환경 설정"></a></li>
				<?}?>
				<li><em><?=$this->session->userdata('ADMIN_NAME')?></em> (<?=$this->session->userdata('ADMIN_USERID')?>)님 <a href="<?=cdir()?>/dhadm/logout"><em>로그아웃</em></a></li>
				<li><a href="/" target="_blank">홈페이지 바로가기</a></li>
			</ul>
		</div>


	</div>
	<!-- END header -->

	<!-- gnb -->
	<ul id="dh-gnb">
		<?=$menu[1]?>
	</ul><!-- END gnb -->

	<!-- Container -->
	<div id="dh-container">
		<div class="container-tit">
			<?php
			//pr($menu);

			if($menu['lv1']->nm == "주문관리"){
				$menu['lv2']->nm = "전체";
			}
			?>
			<a href="./">HOME</a> &gt; <?=$menu['lv1']->nm ? $menu['lv1']->nm : "" ; ?> <?php if($menu['lv1']->cls == "dashboard"){} else{?>&gt; <strong><?=($menu['lv2']->nm) ? $menu['lv2']->nm : "" ; ?></strong><?php }?>
		</div>

		<!-- Content -->
		<div class="dh-sub">
			<span class="v-shadow"></span>
			<ul class="dh-lnb">
				<?=$menu[2]?>
			</ul>
			<div class="dh-content adm-wrap">