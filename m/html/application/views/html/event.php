<?
	$PageName = "EVENT";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

<script type="text/javascript">
	//해시태그 넘어온값 받아서 클릭 효과 부여함
	var hashtag = location.hash.substring(1, location.hash.length).replace(/ /gi, '%20');
	if(hashtag){
		$(function(){
			$("h6."+hashtag).trigger('click');
		});
	}
</script>

<!--Container-->

<div id="container">
	<?include("../include/top_menu.php");?>
			<?php
		if($banners){
			foreach($banners as $bn1){
				if($bn1->parent_code == "pc_event_top"){
					?>
					<a href="<?=($bn1->m_pageurl)?$bn1->m_pageurl:"javascript:;";?>" <?if($bn1->m_target == "blank"){?>target="_blank"<?}?>><img src="/_data/file/banner/<?=$bn1->upfile2?>" alt=""></a>
					<?php
				}
			}
		}
		?>
	<div class="inner event">


		<h1>
			모든 에코맘 이벤트
		</h1>
		<div class="faq-list">
			<!-- <p class="no-ct">등록된 게시물이 없습니다.</p> -->

			<h6 class="faq-q i1"><span class="ico"></span>
			<span class="event_pop">
						친구추천 <span class="red">10% 적립</span> 이벤트

					</span>
			</h6>
			<div class="faq-a">
				<div class="layer_pop_inner_ad">

					<img src="/m/image/sub/event_pop01.jpg" alt="">
					<div class="inner clearfix">
						<p class="fz16 pt20">친구와 함께 적립 받아가세요~ <br>
						1. 회원가입 시 고객님의 아이디를 추천인으로 입력하고,<br>
						<!--2. 친구분이 첫 주문하면~<br>
						3. 첫 주문 금액의 10%를 두 분 모두 적립드려요! -->
						2. 친구분이 첫 정기배송으로 주문!<br>
						3. 친구분의 첫 정기배송이 모두 완료되면 두 분 모두에게 10% 적립!
						</p>
						<p class="fz16 mt10">* 친구의 첫 주문금액의 10%적립<br>
						* 네이버 및 카카오톡 로그인 제외<br>
						* 꼭 본 공식홈페이지 로그인 이용!<br>
						* 첫 정기 주문 후 중간 취소시 적용 제외
						</p>

					</div>
				</div>
			</div>
			<h6 class="faq-q i2"><span class="ico"></span>
			<span class="event_pop">
						인스타그램 후기 남기면, <span class="red">간식 5봉 선물</span>
					</span>
			</h6>
			<div class="faq-a">
				<div class="layer_pop_inner_ad">

					<img src="/image/sub/event01_02.jpg" alt="">
					<div class="inner clearfix">
						<p class="fz16 pt20">#산골이유식 #산골간식 #산골점빵 해쉬태그를 달고 <br /> 후기를 남겨주세요</p>
						<p class="fz16 mt10">5분을 선정하여 산골간식 5봉 랜덤선물을 보내드려요!<br />홈페이지 산골알림장에 사진후기 소개됩니다!</p>

					</div>
				</div>
			</div>
			<h6 class="faq-q i3"><span class="ico"></span>
				<span class="event_pop">
						블로그/유튜브에 후기를 올리면,<span class="red">간식 5봉 선물</span>
					</span>
			</h6>
			<div class="faq-a">
				<div class="layer_pop_inner_ad">

					<img src="/image/sub/event01_03.jpg" alt="">
					<div class="inner clearfix">
						<p class="fz16 pt20">#산골이유식 #산골간식 #산골점빵 해쉬태그를 달고<br />블로그/유튜브에 후기를 남겨주세요!</p>
						<p class="fz16 mt10">베스트후기를 선정하여 산골간식 5봉 랜덤선물을 보내드려요!<br />
홈페이지 산골알림장에 사진후기 소개됩니다! </p>

					</div>
				</div>
			</div>
		</div>
		<h1>
			신규고객 이벤트
		</h1>
		<div class="faq-list">
			<!-- <p class="no-ct">등록된 게시물이 없습니다.</p> -->

			<h6 class="faq-q i4"><span class="ico"></span>
				<span class="event_pop">
						신규정기고객 첫 인연세트 <span class="red">100% 증정</span>
					</span>
			</h6>
			<div class="faq-a">
				<div class="layer_pop_inner_ad">

					<img src="/image/sub/Evnt02_01.png" alt="">
					<div class="inner clearfix">
						<p class="fz16 pt20"> 첫 회원가입 후, 이유식을 첫 정기배송고객에게 
							산골간식을 드립니다.</p>
						<p class="fz16 mt10"> * 산골이유식 홈페이지 회원만 해당합니다.<br>
							* 네이버 및 카카오 간편로그인은 제외됩니다.<br>
							* 알밤/과일칩/곶감 등등 산골까까 종류는 매 월 변동 될 수 있습니다. </p>

					</div>
				</div>
			</div>
			<h6 class="faq-q i5"><span class="ico"></span>
				<span class="event_pop">
						신규회원 가입시 <span class="red">1,000원 적립</span>
					</span>
			</h6>
			<div class="faq-a">
				<div class="layer_pop_inner_ad">
					<img src="/image/sub/ev_a202.jpg" alt="">
					<div class="inner clearfix">
						<p class="fz16 pt20">회원가입시 1,000원 적립해 드립니다. </p>
						<p class="fz16 mt10"> * 산골이유식 홈페이지 회원만 해당합니다.<br>
							* 네이버 및 카카오 간편로그인은 제외됩니다.<br></p>
					</div>
				</div>
			</div>
			<h6 class="faq-q i6"><span class="ico"></span>
				<span class="event_pop">
						<!--신규회원 주문금액 <span class="red">2~7% 적립</span>-->
						신규 구매고객 <span class="red">미미북 증정</span>
					</span>
			</h6>
			<div class="faq-a">
				<div class="layer_pop_inner_ad">

					<img src="/image/sub/Evnt_b_mimibook.png" alt="">
					<div class="inner clearfix">
						<!--<p class="fz16 pt20">주문금액에 따른 회원등급에 따라 2~7% 적립해드립니다.</p>-->
						<p class="fz16 pt20">첫 회원가입 후, 이유식을 구매하는 첫 정기배송고객에게 
						이유식 레시피북 ‘미미북’을 드립니다.</p>
						<p class="fz16 mt10"> * 산골이유식 홈페이지 회원만 해당합니다.<br>
							* 네이버, 카카오 간편로그인은 제외됩니다.</p>

					</div>
				</div>
			</div>
		</div>
		<h1>
			정기구매 고객 이벤트
		</h1>
		<div class="faq-list">
			<!-- <p class="no-ct">등록된 게시물이 없습니다.</p> -->

			<h6 class="faq-q i7"><span class="ico"></span>
				<span class="event_pop">
						정기주문 구매고객 <span class="red">10%~최대 30% 할인</span>
					</span>
			</h6>
			<div class="faq-a">
				<div class="layer_pop_inner_ad">

					<img src="/image/sub/ev_a301.jpg" alt="">
					<div class="inner clearfix">
						<p class="fz16 pt20"> 정기주문 구매고객 시 <br> 골라담기 주문보다 10~ 최대 30% 할인이 진행되고 있습니다.</p>
						<p class="fz16 mt10"> 꾸준한 애용 부탁드려요 </p>
					</div>
				</div>
			</div>
			<h6 class="faq-q i8"><span class="ico"></span>
				<span class="event_pop">
					정기배송 <span class="red">땡큐포인트</span> 받아가요!
				</span>
			</h6>
			<div class="faq-a">
				<div class="layer_pop_inner_ad">

					<img src="/image/sub/thankyou_banner.png" alt="">
					<div class="inner clearfix">
						<p class="fz16 pt20"> 정기배송 4주 1회 완주 후, 다음 단계 4주 배송 신청(완료)시 특별한 땡큐 포인트 꼭 챙겨가세요.</p>
						<p class="fz16 pt20"> 자세한 사항은 꼭 <a href="/html/dh/thankyou">[이벤트 > 땡큐포인트혜택]</a>에서 확인하세요!</p>

					</div>
				</div>
			</div>
			<h6 class="faq-q i9"><span class="ico"></span>
				<span class="event_pop">
					정기배송 고객을 위한 <span class="red">야시장이벤트</span>
					</span>
			</h6>
			<div class="faq-a">
				<div class="layer_pop_inner_ad">

					<img src="/image/sub/event01_09.jpg" alt="">
					<div class="inner clearfix">
						<p class="fz16 pt20">정기배송 고객을 위한 야시장을 열어요!</p>
						<p class="fz16 mt10">야시장이벤트에서 다양한 사은품도 받고<br />0원제품, 반값신제품을 누려보세요</p>

					</div>
				</div>
			</div>
		</div>
		<a href="withcons04.php" class="btn_pp"><span>구매적립금</span> 혜택 챙겨보기<img src="/image/sub/aaaa.png" alt=""></a>
		<div class="o_sangol">
			<h1>
				<img src="/m/image/sub/event_tit.jpg" alt="">
			</h1>
			<div class="contents ready">
				<?php
				if($banners){
					foreach($banners as $bn2){
						if($bn2->parent_code == "pc_event_bottom"){
							?>
							<a href="<?=($bn2->m_pageurl)?$bn2->m_pageurl:"javascript:;";?>" <?if($bn2->m_target == "blank"){?>target="_blank"<?}?>><img src="/_data/file/banner/<?=$bn2->upfile2?>" alt=""></a>
							<?php
						}
					}
				}
				?>
			</div>
		</div>
	</div>
	<!-- inner -->
</div>
<!--END Container-->
<div class="mg95">
</div>
<? include('../include/footer.php') ?>
