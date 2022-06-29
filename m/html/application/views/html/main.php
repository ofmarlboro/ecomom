<?
	$PageName = "MAIN";
	$SubName = "";
	include("../include/head.php");
	include("../include/header.php");
?>

<!--Wrap-->

<div id="wrap">
<?php
	if($main_O_banner->upfile2){		//동그라미 배너 - 현재 디자인허브만 보이도록 조정중
		?>
<!-- <img src="/_data/file/banner2/<?=$main_O_banner->upfile2?>" onerror="/_data/file/banner2/<?=$main_O_banner->upfile1?>" alt="" usemap="#Map" class="ban_pop" style="width: 150px;position: fixed;bottom: 50px;right: 0;z-index: 9999999;"> -->

<div class="ban_pop" style="width: 150px;position: fixed;bottom: 50px;right: 0;z-index: 9999999;">
	<img src="/_data/file/banner2/<?=$main_O_banner->upfile2?>" alt="" class="" style="position: relative;z-index: 9999999;" onClick="<?if($main_O_banner->m_target == "self"){?>location.href='<?=$main_O_banner->m_pageurl?>'<?}else{?>window.open('<?=$main_O_banner->m_pageurl?>')<?}?>">
	<a href="#" onClick="ban_close();"  style="position: absolute;top: 0;right: 7px;width: 25px;z-index: 999999999;"><img src="/image/sub/e083841e67e64afabd529e378fa6f679_03.png" alt=""></a>
</div>
<script>
	function ban_close() {
		$(".ban_pop").hide();
	}
</script>
<?php
	}
	?>
<div class="center_ban">
	<h1 style="line-height: 1.1;left:33%" onClick="location.href='http://www.ecomommeal.co.kr/m/html/dh/event03 '">
		첫 정기고객 100% 선물<br>
		<span style="font-size: 10px;">*간식램덤/네이버,SNS회원 불가</span>
	</h1>
	<img src="/m/image/main/Mobile_0614.png" alt="" style="cursor:pointer;width: 100px;bottom: 6px;" onClick="">
	<a href="#" id="center_close"><img src="/image/main/close02.png" alt=""></a>
</div>

<!--Container-->
<div id="container">
	<div class="side_bar">
		<ul class="clearfix">
			<?php
			foreach($main_popups as $mpt){
				if($mpt->cnt > 0){
					?>
			<li style="display:none;">
				<a href="#" data-bannercode="<?=$mpt->code?>">
				<?=$mpt->name?>
				<span>
				<?=$mpt->cnt?>
				</span></a>
			</li>
			<?php
				}
			}
			?>
		</ul>
	</div>
	<? include("../include/top_menu.php"); ?>
	<div class="news">
		<h1>NEWS</h1>
		<div class="p">
			<?php
			if($news){
				foreach($news as $lt){
				?>
				<p>
					<a href="<?=cdir()?>/dh_board/views/<?=$lt->idx?>">
					<?=$lt->subject?>
					</a>
				</p>
				<?php
				}
			}
			?>
		</div>
		<a href="<?=cdir()?>/dh_board/lists/withcons01" class="btn_more"><img src="/m/image/main/plus.jpg" alt=""></a>
	</div>
	<?php
	//20191007 배너 추가작업
	foreach($main_banner as $mtop){
		if($mtop->parent_code == "newholi"){
			?>
			<div class="ban_pop02">
				<a href="<?=$mtop->m_pageurl?$mtop->m_pageurl:"javascript:;";?>"><img src="/_data/file/banner/<?=$mtop->upfile2?>" alt=""></a>
			</div>
			<?php
			break;
		}
	}
	//20191007 배너 추가작업
	?>
	<div class="mv_wrap" style="position: relative;">
		<div class="m_pop_wrapper">
			<?php
			//ajax insert contents
			?>
		</div>
		<div class="mv" style="display:none;">
			<?php
			foreach($main_banner as $main1){
				if($main1->parent_code == "pc_main"){
				?>
				<div class="item">
					<img src="/_data/file/banner/<?=$main1->upfile2?>" onerror="this.src='/_data/file/banner/<?=$main1->upfile1?>'" onClick="<?if($main1->m_target == "blank"){ if($main1->m_pageurl){?>window.open('<?=$main1->m_pageurl?>','','')<?} }else{ if($main1->m_pageurl){?>location.href='<?=$main1->m_pageurl?>'<?} }?>">
				</div>
				<?php
				}
			}
			?>
		</div>
	</div>

	<!--

	20190130
	주석처리
	 -->
	<div class="top_pop_Wrp mt20  ">
		<div class="top_pop">
			<?php
		if($main_E_banner->upfile1){
			?>
			<?if($main_E_banner->pageurl){?>
			<a href="<?=$main_E_banner->pageurl?>" <?if($main_E_banner->pc_target != "self"){?>target="_blank"<?}?>>
			<?}?>
			<img src="/_data/file/banner2/<?=$main_E_banner->upfile1?>" alt="">
			<?if($main_E_banner->pageurl){?>
			</a>
			<?}?>
			<?php
		}
		?>
		</div>
	</div>

	<div class="cont4_top">
		<img src="/m/image/main/yangyang_logo.jpg" alt="" />

		<ul class="cont cont04">
			<?php
			foreach($main_banner as $lt){
				if($lt->parent_code == 'mainy'){
					?>
					<li>
						<?php
						if($lt->pageurl){
							?>
							<a href="<?=$lt->pageurl?>">
							<?php
						}
						?>
							<p class="cont4_txt01"><?=$lt->addinfo1?></p>
							<p class="cont4_txt02"><?=$lt->addinfo2?></p>
							<div class="img">
								<img src="/_data/file/banner/<?=$lt->upfile1?>" alt="">
							</div>
						</a>
					</li>
					<?php
				}
			}
			?>
			<!-- <li>
				<a href="/m/html/dh_product/apply_view/870?&cate_no=10">
					<p class="cont4_txt01">제품명이 출력됩니다.</p>
					<p class="cont4_txt02">제품설명이 출력됩니다.</p>
					<div class="img">
						<img src="/m/image/main/cont4_sample.jpg" alt="">
					</div>
				</a>
			</li>
			<li>
				<a href="/m/html/dh_product/apply_view/870?&cate_no=10">
					<p class="cont4_txt01">제품명이 출력됩니다.</p>
					<p class="cont4_txt02">제품설명이 출력됩니다.</p>
					<div class="img">
						<img src="/m/image/main/cont4_sample.jpg" alt="">
					</div>
				</a>
			</li>
			<li>
				<a href="/m/html/dh_product/apply_view/870?&cate_no=10">
					<p class="cont4_txt01">제품명이 출력됩니다.</p>
					<p class="cont4_txt02">제품설명이 출력됩니다.</p>
					<div class="img">
						<img src="/m/image/main/cont4_sample.jpg" alt="">
					</div>
				</a>
			</li>
			<li>
				<a href="/m/html/dh_product/apply_view/870?&cate_no=10">
					<p class="cont4_txt01">제품명이 출력됩니다.</p>
					<p class="cont4_txt02">제품설명이 출력됩니다.</p>
					<div class="img">
						<img src="/m/image/main/cont4_sample.jpg" alt="">
					</div>
				</a>
			</li> -->
		</ul>
	</div>
	<!-- <ul class="cont cont04">
		<li>
			<a href="/m/html/dh_product/apply_view/870?&cate_no=10">
				<div class="img">
					<img src="/m/image/main/bn_m1_1.jpg" alt="">
				</div>
			</a>
		</li>
		<li>
			<a href="/m/html/dh_product/prod_list?cate_no=10">
				<div class="img">
					<img src="/m/image/main/bn_m2.jpg" alt="">
				</div>
			</a>
		</li>
		<li>
			<a href="/m/html/dh_product/prod_view/504">
				<div class="img">
					<img src="/m/image/main/bn_m3.jpg" alt="">
				</div>
			</a>
		</li>
		<li>
			<a href="/m/html/dh_product/apply_view/847?&cate_no=10">
				<div class="img">
					<img src="/m/image/main/bn_m4.jpg" alt="">
				</div>
			</a>
		</li>
		<li>
			<a href="/m/html/dh_product/prod_view/540">
				<div class="img">
					<img src="/m/image/main/bn_m5.jpg" alt="">
				</div>
			</a>
		</li>
		<li>
			<a href="https://ecomommeal.co.kr/html/dh_product/prod_view/504">
				<div class="img">
					<img src="/m/image/main/bn_m6.jpg" alt="">
				</div>
			</a>
		</li>
		20200528 조윤희님 주석처리 요청
		<li>
			<img src="/image/main/ico01.jpg" alt="" class="ico">
			<h1>
				<span>산골간식도 함께</span>배우 조윤희님
			</h1>
			<div class="img">
				<img src="/image/main/fjkskfsd.jpg" alt="">
			</div>
			 <div class="desc">
					이유식도 잘 먹고, 푸딩이랑 밤이랑 과일칩을 <br>정말 맛있게 잘 먹어요.
				</div>
		</li>
		<li>
			<img src="/image/main/ico01.jpg" alt="" class="ico">
			<h1>
				<span>첫째부터 둘째까지</span>배우 강성연님
			</h1>
			<div class="img">
				<img src="/image/main/img02.jpg" alt="">
			</div>
			<div class="desc">
				모두 에코맘 산골이유식 덕분입니다! <br>
				정말 감사해요. 시안이에 이어서, 둘째 해안이까지 -<br>
				평생 잊을 수 없는 감사한 선물을 받았습니다.
			</div>
		</li>
	</ul> -->
	<div class="ac" style="font-size: 11px; opacity: .5;">
		산골이 의기양양하게 소개하는 제철재료와 레시피
	</div>

	<!-- 슬라이드 -->
	<div class="grade01">
		<?php
		foreach($main_banner as $main_under){
			if($main_under->parent_code == "m_main_under"){
			?>
		<div class="item">
			<img src="/_data/file/banner/<?=$main_under->upfile1?>" onerror="this.src='/image/default.jpg'" onClick="<?if($main_under->target == "blank"){ if($main_under->pageurl){?>window.open('<?=$main_under->pageurl?>','','')<?} }else{ if($main_under->pageurl){?>location.href='<?=$main_under->pageurl?>'<?} }?>">
		</div>
		<?php
			}
		}
		?>
	</div>

	<!-- END 슬라이드 -->

	<h1 class="ac">
		<img src="/m/image/main/h01.jpg" alt="산골이유식" width="110px">
	</h1>
	<ul class="meal clearfix">
		<li onClick="location.href='<?=cdir()?>/dh/regular01/?recom_idx=2'">
			<img src="/m/image/main/main_06.jpg" alt="">
			<h3><b>5개월 전후</b>준비기</h3>
		</li>
		<li onClick="location.href='<?=cdir()?>/dh/regular01/?recom_idx=4'">
			<img src="/m/image/main/main_08.jpg" alt="">
			<h3><b>5-6개월</b>초기</h3>
		</li>
		<li onClick="location.href='<?=cdir()?>/dh/regular01/?recom_idx=5'">
			<img src="/m/image/main/main_12.jpg" alt="">
			<h3><b>7-8개월</b>중기</h3>
		</li>
		<li onClick="location.href='<?=cdir()?>/dh/regular01/?recom_idx=6'">
			<img src="/m/image/main/main_14.jpg" alt="">
			<h3><b>9-12개월</b>후기</h3>
		</li>
		<li onClick="location.href='<?=cdir()?>/dh/regular01/?recom_idx=7'">
			<img src="/m/image/main/main_18.jpg" alt="">
			<h3><b>12개월</b>완료기</h3>
		</li>
		<li onClick="location.href='<?=cdir()?>/dh/regular01/?recom_idx=3'">
			<img src="/m/image/main/main_20.jpg" alt="">
			<h3><b>반찬/국</b></h3>
		</li>
		<li onClick="location.href='<?=cdir()?>/dh/preview'">
			<img src="/m/image/main/main_23.jpg" alt="">
			<h3><b>산골맛보기 특가세트</b></h3>
		</li>
		<li onClick="location.href='<?=cdir()?>/dh_product/prod_list/?cate_no=10'">
			<img src="/m/image/main/main_25-n.jpg" alt="">
			<h3><b>의기양양픽</b></h3>
		</li>
	</ul>
	<div class="pd30">
	</div>
	<!-- Swiper -->
	<div class="swiper-container">
		<div class="swiper-wrapper">
			<?php
		if($main_goods){
			foreach($main_goods as $mg){
				?>
			<div class="swiper-slide">
				<a href="<?=cdir()?>/dh_product/prod_view/<?=$mg->idx?>?&cate_no=<?=$mg->cate_no?>">
				<span class="img"><img src="/_data/file/goodsImages/<?=$mg->list_img?>" alt=""></span>
				<span class="desc">
				<?=$mg->name?>
				</span>
				<?php $detail_arr = preg_split('/\r\n|[\r\n]/', $mg->detail); ?>
				<span class="p01 mt10">
				<?=$detail_arr[0]?>
				</span>
				<span class="p02"></span>
				<span class="p01">
				<?=$detail_arr[1]?>
				<?=($detail_arr[2])?"<BR>".$detail_arr[2]:"";?>
				<?=($detail_arr[3])?"<br>".$detail_arr[3]:"";?>
				</span>
				</a>
			</div>
			<?php
			}
		}
		?>
		</div>
	</div>
	<div class="con02 mt20 mb20">
		<?php
		foreach($main_banner2 as $mb2){
			?>
		<div class="item" <?if($mb2->m_pageurl){?>style="cursor:pointer;" onClick="<?if($mb2->m_target == "self"){?>location.href='<?=$mb2->m_pageurl?>'<?}else{?>window.open('<?=$mb2->m_pageurl?>','','')<?}?>"<?}?>>
			<h2>
				<strong>OPEN</strong>
				<span>[
				<?=$cate[$mb2->addinfo5]?>
				]
				<?=str_replace($bb_Arr,$sr_Arr,$mb2->addinfo1)?>
				</span>
			</h2>
			<div class="desc">
				<?=$mb2->addinfo2?>
			</div>
			<img src="/_data/file/banner2/<?=$mb2->upfile2?>" onerror="this.src='/_data/file/banner2/<?=$mb2->upfile1?>'">
		</div>
		<?php
		}
		?>
	</div>
	<?php
	/*
		<div class="con02">
			<?php
			foreach($main_banner as $main_dp){
				if($main_dp->parent_code == "pc_depart"){
					?>
			<div class="item">
				<img src="/_data/file/banner/<?=$main_dp->upfile2?>" onerror="this.src='/_data/file/banner/<?=$main_dp->upfile1?>'" onclick="<?if($main_dp->m_target == "blank"){ if($main_dp->m_pageurl){?>window.open('<?=$main_dp->m_pageurl?>','','')<?} }else{ if($main_dp->m_pageurl){?>location.href='<?=$main_dp->m_pageurl?>'<?} }?>">
			</div>
			<?php
				}
			}
			?>
			<!-- <div class="item">
				<img src="/m/image/main/ss.jpg" alt="">
			</div>
			<div class="item">
				<img src="/m/image/main/ss.jpg" alt="">
			</div>
			<div class="item">
				<img src="/m/image/main/ss.jpg" alt="">
			</div>
			<div class="item">
				<img src="/m/image/main/ss.jpg" alt="">
			</div> -->
		</div>
	*/
	?>
	<div class="pd30">
	</div>
	<!-- <li>
			<a href="#">
			<span class="img"><img src="/_data/file/goodsImages/84f48ba20e809bdcee8ef22652e5c526.jpg" alt=""></span>
			<span class="desc">산골쌀참</span>
			</a>
		</li>
		<li>
			<a href="#">
			<span class="img"><img src="/_data/file/goodsImages/84f48ba20e809bdcee8ef22652e5c526.jpg" alt=""></span>
			<span class="desc">산골쌀참</span>
			</a>
		</li>
		<li>
			<a href="#">
			<span class="img"><img src="/_data/file/goodsImages/84f48ba20e809bdcee8ef22652e5c526.jpg" alt=""></span>
			<span class="desc">산골쌀참</span>
			</a>
		</li> -->
	<div class="osangol">
		<?php
		foreach($main_banner as $msg){
			if($msg->parent_code == "pc_mid_farm"){
				?>
		<img src="/_data/file/banner/<?=$msg->upfile2?>" onerror="this.src='/_data/file/banner/<?=$msg->upfile1?>'" onClick="<?if($msg->m_target == "blank"){ if($msg->m_pageurl){?>window.open('<?=$msg->m_pageurl?>','','')<?} }else{ if($msg->m_pageurl){?>location.href='<?=$msg->m_pageurl?>'<?} }?>">
		<?php
			}
		}
		?>
	</div>
	<div class="con03">
		<img src="/m/image/main/h02.jpg" alt="" width="100%">
		<p class="align-c">
			<iframe width="350" height="350" src="https://www.youtube.com/embed/xQl4TiMcR4M?rel=0&amp;controls=0" frameborder="0" allowfullscreen></iframe>
		</p>
	</div>
	<div class="banner">
		<a href="http://www.ecomommeal.co.kr/m/html/dh_board/views/15558? "><img src="/m/image/main/M_Event_banner_800x200.jpg" alt="" width="100%"></a>
	</div>
	<div class="insta pt50" style="background: #FAFAFA;">
		<h1 class="ac">
			<img src="/m/image/main/insta.jpg" alt="" width="150px">
		</h1>
		<div class="ac mb20">
			<a href="#"><img src="/m/image/main/insta_link.jpg" alt="" width="30px"></a>
			<a href="#" class="ml10"><img src="/m/image/main/follow.jpg" alt="" width="50px"></a>
		</div>
		<ul class="insta_list clearfix">
			<!-- <li>
				<a href="#">
				<img src="/image/main/img07.jpg" alt="">
				</a>
			</li>
			<li>
				<a href="#">
				<img src="/image/main/img07.jpg" alt="">
				</a>
			</li>
			<li class="mr0">
				<a href="#">
				<img src="/image/main/img07.jpg" alt="">
				</a>
			</li>
			<li>
				<a href="#">
				<img src="/image/main/img07.jpg" alt="">
				</a>
			</li>
			<li>
				<a href="#">
				<img src="/image/main/img07.jpg" alt="">
				</a>
			</li>
			<li class="mr0">
				<a href="#">
				<img src="/image/main/img07.jpg" alt="">
				</a>
			</li> -->
		</ul>
	</div>
	<div class="con01" style="background: #FDFBF7;">
		<h1 style="font-size: 14px;">
			<img src="/m/image/main/h03.jpg" alt="" style="width: 30px;vertical-align: -8px;margin-right: 5px;">에코맘 산골이유식 수상내역
		</h1>
		<div class="grade">
			<div class="item">
				<img src="/m/image/common/sangol_award01.png" alt="">
			</div>
			<div class="item">
				<img src="/m/image/common/sangol_award02.png" alt="">
			</div>
			<div class="item">
				<img src="/m/image/common/sangol_award03.png" alt="">
			</div>
			<div class="item">
				<img src="/m/image/common/sangol_award04.png" alt="">
			</div>
			<div class="item">
				<img src="/m/image/common/sangol_award05.png" alt="">
			</div>
			<div class="item">
				<img src="/m/image/common/sangol_award06.png" alt="">
			</div>
		</div>
	</div>
	<div class="last_link">
		<!-- <img src="/m/image/main/last.jpg" alt="" width="100%"> -->
		<ul class="clearfix">
			<li>
				<a href="<?=$K0101->url?>">
				<img src="/m/image/main/Sangol_M_main_15.jpg" alt="" width="25px">
				<h1>
					식품안전관리인증 HACCP
				</h1>
				<p>에코맘은 HACCP의 인증을 받고 있습니다</p>
				</a>
			</li>
			<li>
				<a href="https://www.instagram.com/sangol.babyfood/">
				<img src="/m/image/main/Sangol_M_main_18.jpg" alt="" width="30px">
				<h1>
					에코맘 후기
				</h1>
				<p>매월 후기 퀸을 선정하고 있어요</p>
				</a>
			</li>
			<li>
				<a href="<?=$K0101->url?>">
				<img src="/m/image/main/Sangol_M_main_23.jpg" alt="" width="25px">
				<h1>
					에코맘공방/ 에코맘방앗간
				</h1>
				<p>개인 및 단체 모두 환영합니다!</p>
				</a>
			</li>
			<li>
				<a href="<?=$K0804->url?>">
				<img src="/m/image/main/Sangol_M_main_26.jpg" alt="" width="22px">
				<h1>
					에코맘 회원등급안내
				</h1>
				<p>에코맘의 회원등급 안내입니다</p>
				</a>
			</li>
		</ul>
	</div>
</div>
<!--END Container-->

<? include("../include/footer.php"); ?>
<script type="text/javascript">
	jQuery(document).ready(function($){
		$(".m_vod").slick({
			centerMode:true,
			arrows:false
		});

				$(".m_pop").show();

				$(".m_pop").slick({
					dots:true
				});

		$(".cont04").slick({
			dots:true
		});

		$(".con02").slick({
			dots:true,
			arrows:false
		});

		$(".cont02").slick({
			dots:false,
			centerMode:true,
			arrows:false
		});

		$(".mv").show();
		$(".mv").slick({
			dots:true,
			arrows:false
		});

		$(".grade01").slick({
			dots:false,
			centerMode:true,
			arrows:false,
			slidesToShow: 1,
			autoplay: false
		});

		$(".grade").slick({
			dots:false,
			centerMode:true,
			arrows:false,
			slidesToShow: 2,
			autoplay: true
		});

		$(".news .p").slick({
			dots:false,
			vertical: true,
			arrows:false,
			autoplay: true
		});
	});

	$(window).scroll(function(){
		if ($(window).scrollTop() > 50) $("#header").addClass("h_filled");
		else { $("#header").removeClass("h_filled"); }
	});

//	$('.m_pop_wrap .close03').on('click',function(e){
//		e.preventDefault();
//		$(this).parent('.m_pop_wrap').removeClass('on');
//	});

//	$('.b_arw').on('click',function(e){
//		e.preventDefault();
//		$(this).toggleClass('on');
//		$(this).parent('.m_pop_wrap').toggleClass('open').find('.item').toggleClass('open');
//	});

	$('#center_close').on('click',function(e){
		e.preventDefault();
		$('.center_ban').slideToggle();
	});

	$('.side_bar > ul > li > a').on('click',function(e){
		e.preventDefault();
		$(this).parent().addClass('on').siblings().removeClass('on');
		//n=$('.side_bar > ul > li > a').index($(this));
		//$('.m_pop_wrapper .m_pop_wrap').eq(n).addClass('on').siblings().removeClass('on');
		var banner_code = $(this).data('bannercode');
		$.ajax({
			url:"<?=cdir()?>/dh/main_popup/?ajax=1&code="+banner_code,
			type:"GET",
			cache:false,
			dataType:"json",
			error:function(xhr){
				console.log(xhr.responseText);
			},
			success:function(data){
				$(".m_pop_wrapper").html(data.html);
				$('.m_pop_wrapper .m_pop_wrap').addClass('on');

				$('.m_pop_wrap .close03').on('click',function(e){
					e.preventDefault();
					$(this).parent('.m_pop_wrap').removeClass('on');
					$('.side_bar > ul > li > a').parent().removeClass('on');
				});

				$('.b_arw').on('click',function(e){
					e.preventDefault();
					$(this).toggleClass('on');
					$(this).parent('.m_pop_wrap').toggleClass('open').find('.item').toggleClass('open');
				});

			}
		});
	});

	$('.mainpop .close03').on('click',function(e){
		e.preventDefault();
		$(this).parent().removeClass('on').parent('.mainpop').siblings('.side_bar').find('ul li').removeClass('on');
	});

	$('.dot01 li').click(function(e){
		e.preventDefault();
		n=$('.dot01 li').index($(this));
		$('.pop_c li').eq(n).addClass('on').siblings().removeClass('on');
		$('.dot01 li').eq(n).addClass('on').siblings().removeClass('on');
	});

	var swiper = new Swiper('.swiper-container', {
		slidesPerView: 2,
		spaceBetween: 0,
		loop: true,
		loopFillGroupWithBlank: true,
		centeredSlides: true
	});

	jQuery(function($) {
		//Access Tocken 입력
		//var tocken = "4032330465.84ae674.313d14e42d52498a8093a283aca56da8";
		//var tocken = "4032330465.48d728c.35eb666c66a44f4c88893cc4c30813ed";
		var tocken = "4032330465.48d728c.61e1d1574ae045ec9fb8465998fc06a5";
		var count = "9";
		$.ajax({
			type: "GET",
			dataType: "jsonp",
			cache: false,
			url: "https://api.instagram.com/v1/users/4032330465/media/recent?access_token=" + tocken + "&count=" + count,
			success: function(response) {
				if ( response.data.length > 0 ) {
					for(var i = 0; i < response.data.length; i++) {
						var j = i+1;
						var class_name = "";

						if(parseInt(j)%3 == 0){
							class_name = "mr0";
						}


						var insta	=		"<li class='"+class_name+"'>";
								insta	+=	"	<a href='" + response.data[i].link + "' target='_blank'>";
								insta	+=	"		<img src='"+ response.data[i].images.standard_resolution.url +"' alt=''>";
								insta	+=	"	</a>";
								insta	+=	"</li>";
						$(".insta_list").append(insta);
					}
				}
			},
			error: function(xhr){alert("error!!");}
		});
	});

	$(document).ready(function(){
		$(".side_bar > ul > li > a").eq(0).trigger('click');
	});
</script>
