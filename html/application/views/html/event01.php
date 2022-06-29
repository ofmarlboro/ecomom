<?
	$PageName = "K07";
	$SubName = "K0701";
	include("../include/head.php");
	include("../include/header.php");
?>

<script type="text/javascript">
	//해시태그 넘어온값 받아서 클릭 효과 부여함
	var hashtag = location.hash.substring(1, location.hash.length).replace(/ /gi, '%20');
	if(hashtag){
		$(function(){
			adView(hashtag);
		});
	}
</script>

	<!--Container-->
	<div id="container">
		<?include("../include/sub_top.php");?>

		<div class="content inner">
			<?php
			if($banners){
				foreach($banners as $bn1){
					if($bn1->parent_code == "pc_event_top"){
						?>
						<a href="<?=($bn1->pageurl)?$bn1->pageurl:"javascript:;";?>" <?=($bn1->pc_target == "blank")?"target='_blank'":"";?>><img src="/_data/file/banner/<?=$bn1->upfile1?>" alt=""></a>
						<p class="pt10"></p>
						<?php
					}
				}
			}
			?>

			<div class="h1">모든 에코맘 이벤트</div>
			<ul class="event">
				<li class="li01">
					<h2>친구추천
</h2>
					<h3>10%적립</h3>
					<a href="javascript:;" onclick="adView('1');">이벤트 상세보기</a>
				</li>
				<li class="li02">
					<h2>인스타그램 후기 남기면,</h2>
					<h3>간식 5봉 선물</h3>
					<a href="javascript:;" onclick="adView('2');">이벤트 상세보기</a>
				</li>
				<li class="mr0 li03">
					<h2>블로그/유튜브에 후기를 올리면,</h2>
					<h3>간식 5봉 선물</h3>
					<a href="javascript:;" onclick="adView('3');">이벤트 상세보기</a>
				</li>
			</ul>
			<div class="h1">신규고객 이벤트</div>
			<ul class="event">
				<li class="li04">
					<h2>신규정기고객 첫 인연세트</h2>
					<h3>100% 증정</h3>
					<a href="javascript:;" onclick="adView('4');">이벤트 상세보기</a>
				</li>
				<li class="li05">
					<h2>신규회원 가입시</h2>
					<h3>1,000원 적립</h3>
					<a href="javascript:;" onclick="adView('5');">이벤트 상세보기</a>
				</li>
				<li class="mr0 li06">
					<h2>신규 구매고객</h2>
					<h3>미미북 증정</h3>
					<a href="javascript:;" onclick="adView('6');">이벤트 상세보기</a>
				</li>
			</ul>

			<div class="h1">정기구매고객 이벤트</div>
			<ul class="event">
				<li class="li07">
					<h2>정기주문 구매고객</h2>
					<h3>10%~최대 30% 할인</h3>
					<a href="javascript:;" onclick="adView('7');">이벤트 상세보기</a>
				</li>
				<li class="li08">
					<h2>정기배송</h2>
					<h3>땡큐포인트 받아가요!</h3>
					<a href="javascript:;" onclick="adView('8');">이벤트 상세보기</a>
				</li>
				<li class="mr0 li09">
					<h2>정기배송 고객을 위한</h2>
					<h3>야시장이벤트</h3>
					<a href="javascript:;" onclick="adView('9');">이벤트 상세보기</a>
				</li>
			</ul>
			<a href="withcons04.php" class="btn_pp"><span>구매적립금</span> 혜택 챙겨보기<img src="/image/sub/aaaa.png" alt=""></a>
			<div class="o_sangol">
			<h1>
				<img src="/m/image/sub/event_tit.jpg" alt="">
			</h1>
			<div class="contents ">
				<?php
				if($banners){
					foreach($banners as $bn2){
						if($bn2->parent_code == "pc_event_bottom"){
							?>
							<a class="mb40" style="display:block" href="<?=($bn2->pageurl)?$bn2->pageurl:"javascript:;";?>" <?=($bn2->pc_target == "blank")?"target='_blank'":"";?>><img src="/_data/file/banner/<?=$bn2->upfile1?>" alt=""></a>
							<?php
						}
					}
				}
				?>
				<!-- <img src="/m/image/sub/event_ready.jpg" alt=""> -->
			</div>
		</div>
		</div>
	</div><!--END Container-->

<script>

function adView(no){
			$(".layer_pop_ad"+no).fadeIn('fast');
		}
		function closeMenuView(no){
			$(".layer_pop_ad"+no).hide();
		}

</script>
<!--팝업1-->
<div class="layer_pop_ad layer_pop_ad1" style="display:none">
	<div class="layer_pop_inner_ad">
		<h1 class="event_pop">
			친구추천 10%적립 이벤트

		</h1>
			<img src="/image/sub/ev_a101.jpg" alt="">
		<div class="inner clearfix">

			<p class="fz16 pt20"> <b>친구와 함께 적립 받아가세요~</b>
<br>

1. 회원가입 시 고객님의 아이디를 추천인으로 입력하고,<br>
<!--2. 친구분이 첫 주문하면~<br>
3. 첫 주문 금액의 10%를 두 분 모두 적립드려요! -->
2. 친구분이 첫 정기배송으로 주문!<br>
3. 친구분의 첫 정기배송이 모두 완료되면 두 분 모두에게 10% 적립!

</p>
			<p class="fz16 mt10"> * 친구의 첫 주문금액의 10%적립<br>
			* 네이버 및 카카오톡 로그인 제외<br>
			* 꼭 본 공식홈페이지 로그인 이용!<br>
			* 첫 정기 주문 후 중간 취소시 적용 제외</p>

				<p class="ac"><a href="javascript:;" class="close01" title="닫기" onclick="closeMenuView('1');">닫기</a></p>
		</div>


	</div>
</div>
<!--//팝업1-->


<!--팝업2-->
<div class="layer_pop_ad2 layer_pop_ad" style="display:none">
	<div class="layer_pop_inner_ad">
		<h1 class="event_pop">

						인스타그램 후기 남기면, 간식 5봉 선물
		</h1>
			<img src="/image/sub/event01_02.jpg" alt="">
		<div class="inner clearfix">

			<p class="fz16 pt20"> <b>#산골이유식 #산골간식 #산골점빵 해쉬태그를 달고 후기를 남겨주세요</b></p>
			<p class="fz16 mt10"> 5분을 선정하여 산골간식 5봉 랜덤선물을 보내드려요!<br>홈페이지 산골알림장에 사진후기 소개됩니다!</p>

				<p class="ac"><a href="javascript:;" class="close01" title="닫기" onclick="closeMenuView('2');">닫기</a></p>
		</div>


	</div>
</div>
<!--//팝업2-->


<!--팝업3-->
<div class="layer_pop_ad3 layer_pop_ad" style="display:none">
	<div class="layer_pop_inner_ad">
		<h1 class="event_pop">
			블로그/유튜브에 후기를 올리면, 간식 5봉 선물
		</h1>
			<img src="/image/sub/event01_03.jpg" alt="">
		<div class="inner clearfix">

			<p class="fz16 pt20"> <b>#산골이유식 #산골간식 #산골점빵 해쉬태그를 달고<br>블로그/유튜브에 후기를 남겨주세요</b></p>
			<p class="fz16 mt10">베스트후기를 선정하여 산골간식 5봉 랜덤선물을 보내드려요<br />홈페이지 산골알림장에 사진후기 소개됩니다!</p>

				<p class="ac"><a href="javascript:;" class="close01" title="닫기" onclick="closeMenuView('3');">닫기</a></p>
		</div>


	</div>
</div>
<!--//팝업3-->


<!--팝업4-->
<div class="layer_pop_ad4 layer_pop_ad" style="display:none">
	<div class="layer_pop_inner_ad">
		<h1 class="event_pop">
			신규정기고객 첫 인연세트 100% 증정
		</h1>
			<img src="/image/sub/Evnt02_01.png" alt="">
		<div class="inner clearfix">

			<p class="fz16 pt20"> <b>첫 회원가입 후, 이유식을 구매하는 첫 정기배송고객에게 산골간식을 드립니다.</b></p>
			<p class="fz16 mt10">
							* 산골이유식 홈페이지 회원만 해당합니다.<br>
							* 네이버 및 카카오 간편로그인은 제외됩니다.<br>
							* 알밤/과일칩/곶감 등등 산골까까 종류는 매 월 변동 될 수 있습니다.
						</p>

				<p class="ac"><a href="javascript:;" class="close01" title="닫기" onclick="closeMenuView('4');">닫기</a></p>
		</div>


	</div>
</div>
<!--//팝업4-->


<!--팝업5-->
<div class="layer_pop_ad5 layer_pop_ad" style="display:none">
	<div class="layer_pop_inner_ad">
		<h1 class="event_pop">
신규회원 가입시 1,000원 적립
		</h1>
			<img src="/image/sub/ev_a202.jpg" alt="">
		<div class="inner clearfix">

			<p class="fz16 pt20">회원가입시 1,000원 적립해 드립니다.</p>
			<p class="fz16 mt10">
							* 산골이유식 홈페이지 회원만 해당합니다.<br>
							* 네이버 및 카카오 간편로그인은 제외됩니다.<br>
						</p>


				<p class="ac"><a href="javascript:;" class="close01" title="닫기" onclick="closeMenuView('5');">닫기</a></p>
		</div>


	</div>
</div>
<!--//팝업5-->


<!--팝업6-->
<div class="layer_pop_ad6 layer_pop_ad" style="display:none">
	<div class="layer_pop_inner_ad">
		<h1 class="event_pop">
			<!--신규회원 주문금액 2~7% 적립-->
			신규 구매고객 미미북 증정
		</h1>
			<img src="/image/sub/Evnt_b_mimibook.png" alt="">
		<div class="inner clearfix">

			<p class="fz16 pt20"><!--주문금액에 따른 회원등급에 따라 2~7% 적립해드립니다.-->
			첫 회원가입 후, 이유식을 구매하는 첫 정기배송고객에게<br> 이유식 레시피북 ‘미미북’을 드립니다.</p>
			<p class="fz16 mt10">
							*산골이유식 홈페이지 회원만 해당합니다.<br>
							*네이버,카카오 간편로그인은 제외됩니다.<br>
							</p>

				<p class="ac"><a href="javascript:;" class="close01" title="닫기" onclick="closeMenuView('6');">닫기</a></p>
		</div>


	</div>
</div>
<!--//팝업6-->


<!--팝업7-->
<div class="layer_pop_ad7 layer_pop_ad" style="display:none">
	<div class="layer_pop_inner_ad">
		<h1 class="event_pop">
			정기주문 구매고객 10%~최대 30% 할인
		</h1>
			<img src="/image/sub/ev_a301.jpg" alt="">
		<div class="inner clearfix">

			<p class="fz16 pt20"> <b>정기주문 구매고객 시</b> <br>골라담기 주문보다 10~ 최대 30% 할인이 진행되고 있습니다.</p>
			<p class="fz16 mt10"> 꾸준한 애용 부탁드려요</p>

				<p class="ac"><a href="javascript:;" class="close01" title="닫기" onclick="closeMenuView('7');">닫기</a></p>
		</div>


	</div>
</div>
<!--//팝업7-->


<!--팝업8-->
<div class="layer_pop_ad8 layer_pop_ad" style="display:none">
	<div class="layer_pop_inner_ad">
		<h1 class="event_pop">
			선물정기배송 땡큐포인트 받아가요!
		</h1>
			<img src="/image/sub/thankyou_banner.png" alt="">
		<div class="inner clearfix">
			<p class="fz16 pt20"> <b>정기배송 4주 1회 완주 후, <br> 다음 단계 4주 배송 신청(완료)시 <br>특별한 땡큐 포인트 꼭 챙겨가세요.</b></p>
			<p class="fz16 pt20">
				자세한 사항은 꼭 <a href="/html/dh/thankyou">[이벤트 > 땡큐포인트혜택]</a>에서 확인하세요! <br>
			</p>


				<p class="ac"><a href="javascript:;" class="close01" title="닫기" onclick="closeMenuView('8');">닫기</a></p>
		</div>


	</div>
</div>
<!--//팝업8-->


<!--팝업9-->
<div class="layer_pop_ad9 layer_pop_ad" style="display:none">
	<div class="layer_pop_inner_ad">
		<h1 class="event_pop">
			정기배송 고객을 위한 야시장이벤트
		</h1>
			<img src="/image/sub/event01_09.jpg" alt="">
		<div class="inner clearfix">

			<p class="fz16 pt20"> <b>정기배송 고객을 위한 야시장을 열어요!</b></p>
			<p class="fz16 mt10">야시장이벤트에서 다양한 사은품도 받고 <br />
			0원제품, 반값신제품을 누려보세요</p>

				<p class="ac"><a href="javascript:;" class="close01" title="닫기" onclick="closeMenuView('9');">닫기</a></p>
		</div>


	</div>
</div>
<!--//팝업9-->




<?include("../include/footer.php");?>