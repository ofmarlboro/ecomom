
	<!-- top_menu -->
	<div class="top_menu">
		<? // if($PageName=="K01"){?>
		<ul class="clearfix">
			<li><a href="<?=$K01->url?>">산골이유식소개</a>
				<div class="nav_top_2dep">
					<ul>
						<li><a href="<?=$K0105->url?>"><?=$K0105->tit?></a></li>
						<li><a href="<?=$K0101->url?>"><?=$K0101->tit?></a></li>
						<li><a href="<?=$K0102->url?>"><?=$K0102->tit?></a></li>
						<li><a href="<?=$K0103->url?>"><?=$K0103->tit?></a></li>
						<li><a href="<?=$K0104->url?>"><?=$K0104->tit?></a></li>
						<li><a href="http://www.ecomommeal.co.kr/m/html/dh_board/views/15558? ">산골식구모집(채용공고)</a></li>
					</ul>
					<div class="close"><a href="#"><span>닫기</span></a></div>
				</div>
			</li>
			<li><a href="<?=$K0201->url?>">이유식</a>
				<div class="nav_top_2dep">
					<ul>
						<li><a href="<?=$K0201->url?>">영양식단(정기배송)</a></li>
						<li><a href="<?=$K0202->url?>">낱개주문(자유배송)</a></li>
						<li><a href="<?=$K0206->url?>"><?=$K0206->tit?></a></li>
						<!-- <li><a href="<?=$K0207->url?>"><?=$K0207->tit?></a></li> -->
						<li><a href="<?=$K0205->url?>"><?=$K0205->tit?></a></li>
						<li><a href="<?=$K0208->url?>"><?=$K0208->tit?></a></li>
						<!-- <li><a href="<?=$K0203->url?>"><?=$K0203->tit?></a></li> -->
						<!-- <li><a href="<?=$K0204->url?>">선착순 샘플신청</a></li> -->
					</ul>
					<div class="close"><a href="#"><span>닫기</span></a></div>
				</div>
			</li>
			<li><a href="<?=$K0301->url?>">반찬/국<!-- 즉석조리 --></a>
				<div class="nav_top_2dep">
					<ul>
						<li><a href="<?=$K0301->url?>">영양식단(정기배송)</a></li>
						<li><a href="<?=$K0302->url?>">낱개주문(자유배송) - 반찬</a></li>
						<li><a href="<?=$K0303->url?>">낱개주문(자유배송) - 국</a></li>
						<li><a href="<?=cdir()?>/dh/preview#set05">산골반찬 맛보기특가</a></li>
						<?php
						$cate11 = $this->common_m->self_q("select * from dh_goods where cate_no = '11' and display = 1 and night_market != 1 order by ranking","result");
						foreach($cate11 as $m){
							?>
							<li><a href="<?=cdir()?>/dh_product/prod_view/<?=$m->idx?>?cate_no=<?=$m->cate_no?>"><?=$m->name?></a></li>
							<?php
						}
						?>
					</ul>
					<div class="close"><a href="#"><span>닫기</span></a></div>
				</div>
			</li>
			<li><a href="<?=$K04->url?>">산골간식</a></li>
			<li><a href="<?=$K06->url?>">오!산골농부</a></li>
			<li><a href="<?=$K05->url?>">건강식품</a></li>
			<li><a href="<?=$K0701->url?>">이벤트</a><div class="nav_top_2dep">
					<ul>
						<li><a href="<?=$K0704->url?>"><?=$K0704->tit?></a></li>
						<li><a href="<?=$K0701->url?>"><?=$K0701->tit?></a></li>
						<!-- <li><a href="<?=$K0702->url?>"><?=$K0702->tit?></a></li> -->
						<li><a href="<?=$K0703->url?>"><?=$K0703->tit?></a></li>
						<li><a href="<?=$K0706->url?>"><?=$K0706->tit?></a></li>
						<li><a href="<?=$K0705->url?>"><?=$K0705->tit?></a></li>
						<!--  <li><a href="http://www.ecomommeal.co.kr/m/html/dh_board/views/20919?">첫인연 이벤트</a></li>
						 -->
					</ul>
					<div class="close"><a href="#"><span>닫기</span></a></div>
				</div>


			</li>
			<li><a href="<?=$K0801->url?>">고객과함께</a>
				<div class="nav_top_2dep">
					<ul>
						<li><a href="<?=$K0801->url?>">산골알림장</a></li>
						<li><a href="<?=$K08052->url?>">[필독] 이용안내</a></li>
						<li><a href="<?=$K0808->url?>">[예치금] 이용안내</a></li>
						<li><a href="<?=$MYPAGE_IDX->url?>">[주문변경]마이페이지</a></li>


						<!-- <li><a href="<?=$K0805->url?>">주문/결제 안내</a></li> -->
						<li><a href="<?=$K0806->url?>">자주묻는질문</a></li>
						<li><a href="<?=$K0804->url?>">회원등급별혜택</a></li>

						<li><a href="<?=$K0807->url?>">1:1문의</a></li>
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