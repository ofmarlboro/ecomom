<!doctype html>
<html lang="ko">
 <head>
  <title><?if(@$PageTitle!=""){echo $PageTitle . " - ";}?>에코맘의 산골이유식</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="format-detection" content="telephone=no">

	<meta name="Author" content="Design hub">
	<meta name="Author" content="hyejin">
	<meta name="Author" content="에코맘의 산골이유식">

	<meta name="description" content="<?=$shop_info['description']?>">
	<meta property="og:description" content="<?=$shop_info['og_description']?>">
	<meta property="og:type" content="website">
	<meta property="og:title" content="<?if(@$PageTitle!=''){echo $PageTitle . ' - ';}?>에코맘 산골이유식">
	<? if($shop_info['og_image']){?><meta property="og:image" content="https://<?=$shop_info['shop_domain']?>/_data/file/<?=$shop_info['og_image']?>"><?}?>
	<meta property="og:url" content="https://<?=$shop_info['shop_domain']?>">
	<meta name="url" content="https://<?=$shop_info['shop_domain']?>">
	<link rel="canonical" href="https://<?=$shop_info['shop_domain']?>" />
	<?php
	if(file_exists($_SERVER['DOCUMENT_ROOT']."/image/common/eco.ico")){
		?>
		<link rel="shortcut icon" href="/image/common/eco.ico">
		<?php
	}
	?>

	<? if(isset($shop_info['naver_tag']) && $shop_info['naver_tag']!="" ){ ?>
	<meta name="naver-site-verification" content="<?=$shop_info['naver_tag']?>"/>
	<?}?>


	<link type="text/css" rel="stylesheet" href="//cdn.rawgit.com/hiun/NanumSquare/master/nanumsquare.css?times=<?php echo time().rand(); ?>" />
	<link type="text/css" rel="stylesheet" href="/m/css/@default.css?times=<?php echo time().rand(); ?>" />
	<link type="text/css" rel="stylesheet" href="/m/css/sub.css?times=<?php echo time().rand(); ?>" />
	<script type="text/javascript" src="/m/js/jquery-1.9.1.min.js?times=<?php echo time().rand(); ?>"></script>
	<script type="text/javascript" src="/m/js/jquery.easing.min.js?times=<?php echo time().rand(); ?>"></script>
	<script type="text/javascript" src="/m/js/placeholders.min.js?times=<?php echo time().rand(); ?>"></script>
	<script type="text/javascript" src="/m/js/slick.min.js?times=<?php echo time().rand(); ?>"></script>
	<script type="text/javascript" src="/m/js/setting.js?times=<?php echo time().rand(); ?>"></script>




	<script type="text/javascript" src="/m/js/common.js?times=<?php echo time().rand(); ?>"></script>
	<script type="text/javascript" src="/m/js/form.js"></script>
	<? include $_SERVER['DOCUMENT_ROOT']."/_data/lib/m_post_api.php"; ?>

	<link rel="stylesheet" href="/css/jquery-ui.css">
	<script type="text/javascript" src="/js/jquery-ui.js"></script>

	<link rel="stylesheet" href="/css/swiper.css">
	 <script src="/js/swiper.js"></script>

	<script type="text/javascript" charset="UTF-8" src="//t1.daumcdn.net/adfit/static/kp.js"></script>
	<script type="text/javascript">
		  kakaoPixel('5114912039431747532').pageView();
	</script>

<!-- Global site tag (gtag.js) - Google Analytics -->
<script async src="https://www.googletagmanager.com/gtag/js?id=UA-132409382-1"></script>
<script>
  window.dataLayer = window.dataLayer || [];
  function gtag(){dataLayer.push(arguments);}
  gtag('js', new Date());

  gtag('config', 'UA-132409382-1');
</script>

<script type="text/javascript">
	window.onbeforeunload = function () { $('.review_addfile_loading_wrap').show(); }  //현재 페이지에서 다른 페이지로 넘어갈 때 표시해주는 기능
	$(window).load(function () {          //페이지가 로드 되면 로딩 화면을 없애주는 것
			$('.review_addfile_loading_wrap').hide();
	});

	$(window).bind("pageshow", function (event) {
		if (event.originalEvent.persisted) {
			$('.review_addfile_loading_wrap').hide();
		}
	});
</script>
  </head>

 <body>

	<div class="review_addfile_loading_wrap">
		<div class="review_box align-c">
			<img src="/image/loading.gif" alt="">
		</div>
	</div>

 <!--Wrap-->
 <div id="wrap">
