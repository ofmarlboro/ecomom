<? 
	$PageName = "FOOD_SCH";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

<!--Container-->

<div id="container">
	<?include("../include/top_menu.php");?>
	
	<!-- 배송수정 탭메뉴 -->
	<div class="oe_menu order_opt">
		<div class="selbox">
			<button type="button" onClick="toggleSelBox(this, event);"><span class="week_day_count_span">12개월 완료기</span></button>
			<ul>
				<li>
					<input type="radio" id="p01" checked="" onclick="location.href='food_sch.php'">
					<label for="p01">12개월 완료기</label>
				</li>
				<li>
					<input type="radio" id="p02"
												onclick="location.href='food_sch.php'">
					<label for="p02">12개월 완료기</label>
				</li>
				<li>
					<input type="radio" id="p03"
												onclick="location.href='food_sch.php'">
					<label for="p03">12개월 완료기</label>
				</li>
				<li>
					<input type="radio" id="p04"
												onclick="location.href='food_sch.php'">
					<label for="p04">12개월 완료기</label>
				</li>
				<li>
					<input type="radio" id="p05" onclick="location.href='food_sch.php'">
					<label for="p05">12개월 완료기</label>
				</li>
			</ul>
		</div>
	</div>
	<script type="text/javascript" src="/js/orderPage.js"></script>
	<div class="inner">
		<div class="drawSchedule">
			<div class="date_view">
				<span class="year">2018</span>년 <span class="month">08</span>월 식단표
				<a href="#" class="pre" title="이전">이전</a>
				<a href="#" class="next" title="다음">다음</a>
			</div>
		</div>
		<div class="s-list">
			<h6 class="faq-q on">
				<span class="red">3월 1일 목요일</span>
			</h6>
			<div class="faq-a" style="display:block">
				<ul class="bu_list01">
					<li>
						d52.발아현미소고기무아욱진밥
					</li>
					<li>
						d11.근대두부진밥
					</li>
					<li>
						d11.근대두부진밥
					</li>
				</ul>
				<span class="red">배송휴일</span>
			</div>
			<h6 class="faq-q">
				3월 1일 목요일
			</h6>
			<div class="faq-a">
				<ul class="bu_list01">
					<li>
						d52.발아현미소고기무아욱진밥
					</li>
					<li>
						d11.근대두부진밥
					</li>
					<li>
						d11.근대두부진밥
					</li>
				</ul>
			</div>
			<h6 class="faq-q">
				3월 1일 목요일
			</h6>
			<div class="faq-a">
				<ul class="bu_list01">
					<li>
						d52.발아현미소고기무아욱진밥
					</li>
					<li>
						d11.근대두부진밥
					</li>
					<li>
						d11.근대두부진밥
					</li>
				</ul>
			</div>
		</div>
	</div>
	<!-- inner -->
	
</div>
<!--END Container-->
<div class="mg95">
</div>
<? include('../include/footer.php') ?>
