	<? include('../include/sub_title.php') ?>

	<!--Header-->
	<div id="header">
	<!-- <a href="#" class="toTop" onclick="javascript:goPageTop();"><img src="/m/image/main/t.png" alt=""></a>
	<a href="#" class="toBack"><img src="/m/image/main/b.png" alt=""></a> -->
		<div class="inner">
			<h1 id="logo"><a href="/m/"><img src="/m/image/common/logo.png" alt="에코맘 산골이유식" width="160" ></a></h1>

			<div class="h_left">
				<?php
				if(!$main){
				?>
				<button type="button" class="plain back01" onclick="history.go(-1)"><img src="/m/image/common/btn_back.png" width="15" alt="이전페이지로"></button>
				<?php
				}
				?>
				<button type="button" class="plain" onclick="openGnb();"><img src="/m/image/common/btn_menu.png" width="25" alt="메뉴"></button>
			</div>

			<div class="h_right">
				<a href="<?=$SHOP_CART->url?>" class="btn_cart"><img src="/m/image/common/icon_cart.png" alt="장바구니" alt="마이페이지" width="25"><span><?=$cart_cnt_hd?></span></a>
				<a href="<?=$MYPAGE_IDX->url?>" class="btn_mypage"><img src="/m/image/common/icon_my.png" alt="마이페이지" width="22"></a>
			</div>
		</div><!-- END Inner -->
	</div><!--END Header-->

	<div id="gnb_wrap">
		<span class="blind" onclick="closeGnb();"></span>
		<!-- Nav Box -->
		<div id="nav_box">
			<div class="scroll">
				<p class="top_logo"><img src="/m/image/common/gnb_logo.png" alt="에코맘 산골이유식" width="153" height="25" class="img-mid"></p>
				<?php
				//상단 아이콘,
				// 三,회원, 배송, 검색
				?>
				<ul class="gnb_tab">
					<li class="on"><a href="javascript:;" onclick="gnbMode('#gnb_menu', this);"><span class="i1"></span>메뉴</a></li>
					<li><a href="javascript:;" onclick="gnbMode('#my_menu', this);"><span class="i2"></span>마이페이지</a></li>
					<li><a href="<?=$ORDERLIST->url?>"><span class="i3"></span>배송조회</a></li>
					<li><a href="#" id="srch_button"><span class="i4"></span>검색</a></li>
				</ul>

				<!-- 검색 -->
				<div class="searchForm mSearch" style="display: none;">
				 <form name="schfrm" id="schfrm" class="fsearchbox" action="<?=cdir()?>/dh/srch_view" onsubmit="frmChk('schfrm');return false">
					<p>
						<input id="keyword" name="sch_value" class="inputTypeText" type="text" msg="검색어를">
						<button type="button" onclick="frmChk('schfrm')" class="top_search_submit"><img src="/m/image/sub/mobile_mmenu_icon_search.png" width="22"></button>
					</p>
				</form>
			</div>

			<script>
				$("#srch_button").on('click',function(){
					$('.searchForm.mSearch').slideToggle();
				})

			</script>


			<!-- END 검색 -->

				<!-- 일반 메뉴 -->
				<div class="gnb_mode" id="gnb_menu">
					<ul class="gnb_mem">
						<?php
						if($this->session->userdata('USERID')){
						?>
						<li><a href="<?=cdir()?>/dh_member/mypage">정보수정</a></li>
						<li><a href="<?=cdir()?>/dh_member/logout">로그아웃</a></li>
						<?php
						}
						else{
						?>
						<li><a href="<?=$JOIN->url?>">회원가입</a></li>
						<li><a href="<?=$LOGIN->url?>">로그인</a></li>
						<?php
						}
						?>
					</ul>

					<div class="gnb_sns">
						<span class="tit">SNS친구맺고 혜택받기</span>
						<ul class="icons">
							<li><a target="_blank" href="https://www.instagram.com/sangol.babyfood/"><img src="/m/image/common/icon_insta.png" alt="Instagram"></a></li>
							<li><a target="_blank" href="https://www.facebook.com/%EC%82%B0%EA%B3%A8%EC%95%84%EA%B8%B0%EC%8B%9D%EB%8B%B9-352530641610938/"><img src="/m/image/common/icon_fb.png" alt="Facebook"></a></li>
							<li><a target="_blank" href="https://story.kakao.com/ch/ecomom1005"><img src="/m/image/common/icon_kakao.png" alt="Kakao"></a></li>
						</ul>
					</div>

					<ul class="gnb">
						<li><a href="<?=$K01->url?>">산골이유식 소개<span class="bl"></span></a></li>
						<li class="<?=($this->uri->segment(2) == "regular01")?"on":"";?>"><a href="<?=$K0201->url?>">영양식단 (정기배송)<span class="bl"></span></a></li>
						<li><a href="<?=$K0202->url?>">낱개주문 (자유배송)<span class="bl"></span></a></li>
						<li><a href="<?=$K0206->url?>">산골맛보기 특가세트<span class="bl"></span></a></li>
						<li><a href="<?=$K0205->url?>">신규고객 의기양양픽 맛보기<span class="bl"></span></a></li>
						<li><a href="<?=$K04->url?>">산골간식<span class="bl"></span></a></li>
						<li><a href="<?=$K0701->url?>">이벤트<span class="bl"></span></a></li>
						<li><a href="<?=$K08->url?>">고객과 함께<span class="bl"></span></a></li>
					</ul>
				</div><!-- END 일반 메뉴 -->


				<!-- 회원 메뉴 -->
				<div class="gnb_mode" id="my_menu" style="display:none;">
					<!-- <p class="tit">기존회원이라면 바로 간편구매 해보세요!</p>

					<a href="#" class="quick_buy">이전구매내역 보고 <em>간편구매하기</em><span class="bl"></span></a> -->

					<ul class="gnb mt10">
						<li><a href="<?=$SHOP_CART->url?>">장바구니<span class="bl"></span></a></li>
						<li><a href="<?=$ORDERLIST->url?>">주문내역<span class="bl"></span></a></li>
						<li><a href="<?=$POINT->url?>">보유포인트<span class="bl"></span></a></li>
						<li><a href="<?=$COUPON->url?>">보유쿠폰<span class="bl"></span></a></li>
						<li><a href="<?=$MYPAGE->url?>">정보수정<span class="bl"></span></a></li>
						<?php
						if($this->session->userdata('USERID')){
						?>
						<li><a href="<?=cdir()?>/dh_member/logout">로그아웃<span class="bl"></span></a></li>
						<?php
						}
						else{
						?>
						<li><a href="<?=cdir()?>/dh_member/login">로그인<span class="bl"></span></a></li>
						<?php
						}
						?>
					</ul>
				</div><!-- END 일반 메뉴 -->

				<!-- <div class="gnb_btm">
					<div class="">
						<p class="tit">상담전화 토닥토닥</p>
						<p class="call">055-844-2625</p>
						<p>월~토 08:00 ~ 16:00<br>
						점심 12:00 ~13:00<br>
						일요일 및 공휴일 휴무</p>
						<a class="btn" href="tel:055-844-2625"><img src="/m/image/common/icon_tel.png" alt="" width="11" height="11">전화걸기</a>
					</div>
					<div class="">
						<p class="tit">입금계좌안내</p>
						<p>우리 1005-202-0343634<br>
						신한 100-028-158406<br>
						농협 351-0523-5480-33</p>
						<p class=" mt5">예금주: (주)에코맘산골이유식</p>
						<a class="btn" href="tel:055-844-2625"><img src="/m/image/common/icon_counsel.png" alt="" width="12" height="11">문의하기</a>
					</div>
				</div> -->


				<div class="menu_left_cs">

					<div class="bank_contents">
						<h3>상담전화 토닥토닥</h3>
						<p class="cs_text">
							<a href="tel:<?=$shop_info['shop_tel1']?>" class="tel_num"><span class="tel_number"><?=$shop_info['shop_tel1']?></span></a><br>
							<span class="cs_info">
								월~금 08:00 ~ 16:00<br>
								점심 12:00 ~ 13:00<br>
								주말 및 공휴일 휴무
							</span>
						</p>
						<a href="tel:<?=$shop_info['shop_tel1']?>" class="cs_btn_link"><img src="/m/image/common/icon_tel.png" alt="" width="11" height="11"> 전화걸기</a>

						<a href="<?=$K0807->url?>" class="cs_btn_link type2"><img src="/m/image/common/icon_counsel.png" alt="" width="12" height="11"> 문의하기</a>
					</div>
				</div>



			</div><!-- END Scroll Area -->



			<!-- <button type="button" class="plain close" onclick="closeGnb();"><img src="/m/image/common/btn_close.png" alt="닫기" width="15" height="15" style="vertical-align: super;"></button> -->
		</div><!-- END Nav Box -->



	</div>

