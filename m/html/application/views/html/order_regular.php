<? 
	$PageName = "ORDER_REGULAR";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

	<!--Container-->
	<div id="container">
		<?include("../include/top_menu.php");?>
		<?include("../include/mypage_top.php");?>
		<div class="inner mypage">
			<h1>주문배송조회</h1>
			<h2>주문 정보</h2>
			<div class="tblTy02">
				<table>
				<colgroup>
					<col width="50%">
					<col width="50%">
				</colgroup>
					<tr>
						<th>주문상품</th>
						<th>주문일자</th>
					</tr>
					<tr>
						<td>정기배송 [완료기] 외 8건
						<p class="ac"><a href="" class="a_noti"></a>
							<a href="" class="alarm"></a></p>
							
						</td>
						<td>2018. 01. 01 (월)</td>
					</tr>
					<tr>
						<th>주문코드</th>
						<th>결제방법</th>
					</tr>
					<tr>
						<td>UXURO1517655385</td>
						<td>무통장 입금 / 신용카드 / 카카오페이 등</td>
					</tr>
				</table>
			</div>
			<h2 class="mt30">배송일정/식단</h2>
			<div class="tblTy01 mt10">
				<table>
					<tr>
						<th>※일자를 선택하시면 배송 식단을 확인하실 수 있습니다.<br>※주문하신 메뉴, 배송일, 배송장소를 변경하시려면 하단의 변경 버튼을 클릭하세요.
						<p class="mt10 ac"><a class="btn_green" href="#">메뉴/배송지/배송일 변경</a></p></th>	
					</tr>
				</table>
			</div>
			<p class="ar mt20">
				<a href="javascript:;" class="btn_b" onclick="menuView();">배송 일정표 보기</a>
			</p>


			<div class="s-list">
					<h6 class="faq-q on">
						<span class="red">3월 1일 목요일</span> <span class="g8">&nbsp;배송완료</span>
					</h6>
					<div class="faq-a" style="display:block">
						<ul class="bu_list01">
							<li>d52.발아현미소고기무아욱진밥</li>
							<li>d11.근대두부진밥</li>
							<li>d11.근대두부진밥</li>
						</ul>
						<span class="red">배송휴일</span>
					</div>
					<h6 class="faq-q">
						3월 1일 목요일
					</h6>
					<div class="faq-a">
						<ul class="bu_list01">
							<li>d52.발아현미소고기무아욱진밥</li>
							<li>d11.근대두부진밥</li>
							<li>d11.근대두부진밥</li>
						</ul>
					</div>
					<h6 class="faq-q">
						3월 1일 목요일 <span class="blue">&nbsp;배송중</span>
					</h6>
					<div class="faq-a">
						<ul class="bu_list01">
							<li>d52.발아현미소고기무아욱진밥</li>
							<li>d11.근대두부진밥</li>
							<li>d11.근대두부진밥</li>
						</ul>
					</div>
			</div>
		</div>
		<!-- inner -->



	</div>
	<!--END Container-->
	<div class="mg95"></div>


	<!-- 공지 레이어팝업 -->
	<div class="layer_pop" style="display:none;">
		<div class="layer_pop_inner02">
			<h1>배송일정표</h1>
			<div class="scroll">
				<div class="tblTy04">
					<table>
						<tr><th>1회차</th><td>2018-28-55</td><td>배송완료</td></tr>
						<tr><th>1회차</th><td>2018-28-55</td><td>배송완료</td></tr>
						<tr><th>1회차</th><td>2018-28-55</td><td>배송완료</td></tr>
						<tr><th>1회차</th><td>2018-28-55</td><td>배송완료</td></tr>
						<tr><th>1회차</th><td>2018-28-55</td><td>배송완료</td></tr>
						<tr><th>1회차</th><td>2018-28-55</td><td>배송완료</td></tr>
						<tr><th>1회차</th><td>2018-28-55</td><td>배송완료</td></tr>
						<tr><th>1회차</th><td>2018-28-55</td><td>배송완료</td></tr>
						<tr><th>1회차</th><td>2018-28-55</td><td>배송완료</td></tr>
					</table>
				</div>
			</div>
			<button type="button" class="w100 close" title="닫기" onclick='closeMenuView();'>
			확인</button>
		</div>
	</div>
	<!-- END 제품 상세보기 -->

	<script type="text/javascript">
		function menuView(){
			$(".layer_pop").fadeIn('fast');
			return false;
		}
		function closeMenuView(){
			$(".layer_pop .scroll").scrollTop(0);
			$(".layer_pop").hide();
		}
	</script>





<? include('../include/footer.php') ?>


