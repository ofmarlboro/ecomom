<?
	$PageName = "K08";
	$SubName = "K08052";
	$PageTitle = "변경/결제 안내";
	include('../include/head.php');
	include('../include/header.php');
?>

	<!--Container-->
	<div id="container">
		<?include("../include/top_menu.php");?>
		<? //include("../include/mypage_top02.php");?>
		<? //include("../include/oe_menu05.php");?>
<script type="text/javascript">
	jQuery(document).ready(function($){

		setScrollIndex();	//스크롤 인덱스 셋팅
	});
	</script>


<h1 style="background: #FAFAFA; font-size: 36px;text-align: center;padding-top: 50px;padding-bottom: 50px;">[필독] 산골이용가이드</h1>




	<div class="scroll_nav_wrap">
		<ul class="scroll_nav clearfix">
			<li class="li01 "><a href="#history01">배송안내</a></li>
			<li class="li02"><a href="#history02">주문변경</a></li>
			<li class="li03"><a href="#history03">결제방법</a></li>
			<li class="li04"><a href="#history04">취소환불</a></li>
			<li class="li05"><a href="#history05">회원관리</a></li>
			<li class="li06"><a href="#history06">이유식관리</a></li>
		</ul>
</div>


		<!-- 1993~4 -->
		<div id="history01" class="outer histr_ct">
			<div class="">
				<img src="/m/image/sub/M_sangol_guide_20200825_01.jpg" alt="">
			</div>
		</div><!-- END 1993~4 -->

		<!-- 1995~6 -->
		<div id="history02" class="outer histr_ct ">
			<div class="">
				<img src="/m/image/sub/M_sangol_guide_201812132_02_01.jpg" alt="">
			</div>
			<img src="/m/image/sub/M_sangol_guide_201812132_02_02.jpg" alt="" style="vertical-align: top;">
			<div class="m_warp" style="width: 100%;margin: 0 auto;background: #F5F5F5;">
			<div class="inner ac pb70">
							<iframe width="310" height="215" src="https://www.youtube.com/embed/1YG35aGz3gY" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe></div>
					</div>

		</div><!-- END 1995~6 -->

		<!-- 1997~2006 -->
		<div id="history03" class="outer histr_ct">
			<div class="">
				<img src="/m/image/sub/M_sangol_guide_20200605_3.jpg" alt="">
			</div>
		</div><!-- END 1997~2006 -->


		<!-- 2007 -->
		<div id="history04" class="outer histr_ct">
			<div class="">
				<!-- <img src="/m/image/sub/M_sangol_guide_201812134_02.jpg" alt=""> -->
				<img src="/m/image/sub/M_sangol_guide_20200605_4.jpg" alt="">

				<img src="/m/image/sub/M_sangol_guide_20190620.jpg" alt="" usemap="#Map" border="0" />
<map name="Map" id="Map">
	<area shape="rect" coords="8,2037,1056,2865" href="http://ecomommeal.co.kr/m/html/dh_board/lists/withcons06?cate_idx=25" />
</map>

<script>
	$(document).ready(function(e) {
	$('img[usemap]').rwdImageMaps();

});
</script>
<script>

;(function(a){a.fn.rwdImageMaps=function(){var c=this;var b=function(){c.each(function(){if(typeof(a(this).attr("usemap"))=="undefined"){return}var e=this,d=a(e);a("<img />").load(function(){var g="width",m="height",n=d.attr(g),j=d.attr(m);if(!n||!j){var o=new Image();o.src=d.attr("src");if(!n){n=o.width}if(!j){j=o.height}}var f=d.width()/100,k=d.height()/100,i=d.attr("usemap").replace("#",""),l="coords";a('map[name="'+i+'"]').find("area").each(function(){var r=a(this);if(!r.data(l)){r.data(l,r.attr(l))}var q=r.data(l).split(","),p=new Array(q.length);for(var h=0;h<p.length;++h){if(h%2===0){p[h]=parseInt(((q[h]/n)*100)*f)}else{p[h]=parseInt(((q[h]/j)*100)*k)}}r.attr(l,p.toString())})}).attr("src",d.attr("src"))})};a(window).resize(b).trigger("resize");return this}})(jQuery);

</script>



			</div>
		</div><!-- END 2007 -->


		<!-- 2008~2014 -->
		<div id="history05" class="outer histr_ct">
			<div class="">
				<img src="/m/image/sub/M_sangol_guide_201812135_02.jpg" alt="">
			</div>
		</div><!-- END 2008~2014 -->


		<!-- 2015~NOW -->
		<div id="history06" class="outer histr_ct">
			<div class="">
				<img src="/m/image/sub/M_sangol_guide_7p.jpg" alt="">
			</div>
		</div><!-- END 2015~NOW -->




<!-- 		<div class="inner pt20 mypage div01">
			<h1><?=$$SubName->tit?></h1>
			<img src="/m/image/sub/return_law_M.jpg" alt="">
			<img src="/m/image/sub/return_law_m1.jpg" alt="">
			<h1 class="ac mt50"><img src="/m/image/sub/h2.jpg" alt="" width="150px"></h1>
			<div class="box">
			<h2>에코맘 계좌정보</h2>
			<p>농협 <b>351-0523-5480-33</b><br>
			신한 <b>100-028-158406</b><br>
			우리 <b>1005-202-034634</b><br>
			(예금주 : ㈜에코맘산골이유식)</p>
		</div>
		</div> -->
		<!-- inner -->

		<?php
		/*
		<div class="div01 mt50" style="background: #F8F8F8;">
			<div class="inner">
				<h1 class="ac pt50"><img src="/m/image/sub/h1.jpg" alt="" width="150px"></h1>
				<div class="box">
					<h2>당일 오전 7시까지의<br>
					주문 건에 한해 당일 조리되어<br>
					 익일 수령하게 됩니다.
					</h2>
					<p>에코맘의 산골이유식은 오전 7시까지의<br>
					주문까지 취합되어 조리실에 오더가<br>
					들어갑니다.<br>
					홈메이드로 생산된 이유식은 당일 오후<br>
					택배 포장이 완료되어 발송된 뒤,<br>
					24시간 내 고객님의 문 앞에 도착하게<br>
					되지요
					</p>
				</div>
				<div class="box">
					<h2>이유식은 1팩부터<br>
					주문이 가능합니다.
					</h2>
					<p>냉장보관이 가능하지만(최대 일주일)<br>
					보관시간이 짧을수록 우리 아이가 좀 더<br>
					신선하게 먹을 수 있겠지요.<br>
					이유식을 주문하시는 어머님과<br>
					저희 에코맘의 목표는 아이가 건강하고<br>
					신선한 이유식을 먹는 것이기에<br>
					가장 좋은 방향을 선택해야<br>
					하는 것이지요.
					</p>
				</div>
				<h1 class="ac mt50"><img src="/m/image/sub/h2.jpg" alt="" width="150px"></h1>
				<div class="box">
					<h2>에코맘 계좌정보</h2>
					<p>농협 <b>351-0523-5480-33</b><br>
					신한 <b>100-028-158406</b><br>
					우리 <b>1005-202-034634</b><br>
					(예금주 : ㈜에코맘산골이유식)</p>
				</div>
				<div class="box">
					<h2>무통장 입금 시 필독</h2>
					<p>입금자명, 금액,은행 등이 주문서와<br>
					정확히 동일해야 하며, 그렇지 않을 경우<br>
					주문 자동취소 및 이유식이 늦어지는<br>
					점은 일절 책임지지 않습니다.<br>
					(무통장 입금은 주문 후 24시간 이내에<br>
					입금하지 않으시면 자동으로 주문이<br>
					취소됩니다.)</p>
				</div>
			</div>
		</div>
		*/
		?>
	</div>
	<!--END Container-->
	<div class="mg95"></div>

<? include('../include/footer.php') ?>