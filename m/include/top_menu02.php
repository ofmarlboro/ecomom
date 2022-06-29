
	<!-- top_menu -->
	<div class="top_menu">
		<? // if($PageName=="K01"){?>
		<ul class="clearfix">
			<li><a href="<?=$K01->url?>">산골이유식소개</a>
				<div class="nav_top_2dep nav_top_2dep02">
					<ul>
						<li><a href="<?=$K0101->url?>"><?=$K0101->tit?></a></li>
						<li><a href="<?=$K0102->url?>"><?=$K0102->tit?></a></li>
					</ul>
					<div class="close"><a href="#"><span>닫기</span></a></div>
				</div>
			</li>
			<li><a href="<?=$K0201->url?>">이유식</a>
				<div class="nav_top_2dep nav_top_2dep02">
					<ul>
						<li><a href="<?=$K0201->url?>">영양식단(정기배송)</a></li>
						<li><a href="<?=$K0202->url?>">낱개주문(자유배송)</a></li>
						<li><a href="<?=$K0203->url?>">둥이상품세트</a></li>
						<!-- <li><a href="<?=$K0204->url?>">선착순 샘플신청</a></li> -->
					</ul>
					<div class="close"><a href="#"><span>닫기</span></a></div>
				</div>
			</li>
			<li><a href="<?=$K0301->url?>">반찬/국</a>
				<div class="nav_top_2dep nav_top_2dep02">
					<ul>
						<li><a href="<?=$K0301->url?>">영양식단(정기배송)</a></li>
						<li><a href="<?=$K0302->url?>">낱개주문(자유배송) - 반찬</a></li>
						<li><a href="<?=$K0303->url?>">낱개주문(자유배송) - 국</a></li>
					</ul>
					<div class="close"><a href="#"><span>닫기</span></a></div>
				</div>
			</li>
			<li><a href="<?=$K04->url?>">산골간식</a></li>
			<li><a href="<?=$K06->url?>">오!산골농부</a></li>
			<li><a href="<?=$K05->url?>">건강식품</a></li>
			<li><a href="<?=$K0701->url?>">이벤트</a></li>
			<li><a href="<?=$K0801->url?>">고객과함께</a>
				<div class="nav_top_2dep nav_top_2dep02">
					<ul>
						<li><a href="<?=$K0801->url?>">산골알림장</a></li>
						<li><a href="<?=$MYPAGE_IDX->url?>">마이페이지</a></li>
						<li><a href="<?=$K0807->url?>">1:1문의</a></li>
						<li><a href="<?=$K0805->url?>">주문/결제/취소</a></li>
						<li><a href="<?=$K0804->url?>">회원 등급별 혜택</a></li>
						<li><a href="<?=$K0806->url?>">FAQ</a></li>
						<!-- <li><a href="<?=$K0802->url?>">산골먹방 후기게시판</a></li> -->
						<li><a href="<?=$K080301->url?>">이유식 공부하기</a></li>
					</ul>
					<div class="close"><a href="#"><span>닫기</span></a></div>
				</div>
			</li>
		</ul>
		<? //}?>
	</div><!-- top_menu -->

	<script>

	jQuery(document).ready(function($){
	//gnb
	$(".top_menu > ul > li > a").on("click", function(){
		if ($(this).siblings(".nav_top_2dep").length > 0)
		{
			$(".nav_top_2dep").not($(this).siblings(".nav_top_2dep")).hide();
			$(this).siblings(".nav_top_2dep").stop().slideToggle ('fast');
			$(".top_menu > ul > li").not($(this).closest("li")).removeClass("on");
			$(this).closest("li").toggleClass("on");
			return false;
		}
	});
	$(".nav_top_2dep .close a").on("click", function(){
		$(this).closest("li").removeClass("on");
		$(this).closest(".nav_top_2dep").stop().slideUp('fast');
		return false;
	});


});
	</script>