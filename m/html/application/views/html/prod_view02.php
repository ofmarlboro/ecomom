<?
	$PageName = "DESSERT_VIEW";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

<!--Container-->

<div id="container">
	<?include("../include/top_menu.php");?>
	<?include("../include/view_tab.php");?>
	<div class="inner">
		
				<h1 class="pro_tit">
					제품이름
				</h1>
				<p class="gray"> 제품에 대한 간략 설명이 표시됩니다.<br>
					대략 2~3줄 이내의 간단한 문구를 관리자 모드에서 입력합니다. </p>
				<div class="prod-top">

					<!-- 제품이미지 -->
					<div class="prod-img">
						<div class="prod-img-zoom">
							<img alt="제품 확대이미지" src="/m/image/sub/img01.jpg">
						</div>
						<div class="prod-img-sm">
							<ul class="prod-thumbs">
								<li>
									<a href="javascript:onView('img01.jpg');"><img alt="제품상세 이미지 2" src="/m/image/sub/img01.jpg"></a>
								</li>
								<li>
									<a href="javascript:onView('img01.jpg');"><img alt="제품상세 이미지 2" src="/m/image/sub/img01.jpg"></a>
								</li>
								<li>
									<a href="javascript:onView('img01.jpg');"><img alt="제품상세 이미지 2" src="/m/image/sub/img01.jpg"></a>
								</li>
								<li>
									<a href="javascript:onView('img01.jpg');"><img alt="제품상세 이미지 2" src="/m/image/sub/img01.jpg"></a>
								</li>
								<li class="mr0">
									<a href="javascript:onView('img01.jpg');"><img alt="제품상세 이미지 2" src="/m/image/sub/img01.jpg"></a>
								</li>
							</ul>
						</div>
					</div>
					<!-- END 제품이미지 -->

					<!-- 제품정보 -->
					<div class="prod-info-wrap">
						<form name="" id="" onsubmit="return false;" method="post">

							<!-- 제품정보 -->
							<ul class="prod-info">
								<li class="ar">
									<span class="label">산골알밤</span>
									<span class="cart-vol mr20">
									<button class="vol-down" onclick="goodsCntChange('d')">감소</button>
									<input name="goods_cnt" id="goods_cnt" type="text" readonly value="1">
									<button class="vol-up" onclick="goodsCntChange('u')">추가</button>
									</span>
									<em>1,200</em>원
								</li>
							</ul>
							<!-- END 제품정보 -->

						</form>

						<!-- 총 가격 -->
						<div class="prod-total">
							<p class="gray">배송비:2,500원<br>
								30,000원 이상<br>
								무료배송</p>
							<span class="label">주문금액</span>
							<span class="total_price">31,200</span>
							<span class="unit">원</span>
						</div>
						<!-- END 총 가격 -->

						<ul class="pro_option">
							<li class="clearfix order_opt date_00">
								<a href="#" class="btn_b01">예약배송에 추가</a>
								<div class="selbox">
									<button type="button" onClick="toggleSelBox(this, event);"><span class="week_day_count_span">배송일 직접 선택</span></button>
									<ul>
										<li>
											<input type="radio" id="date01" checked="">
											<label for="date01">배송일 직접 선택</label>
										</li>
										<li>
											<input type="radio" id="date02">
											<label for="date02">배송일 직접 선택</label>
										</li>
										<li>
											<input type="radio" id="date03">
											<label for="date03">배송일 직접 선택</label>
										</li>
										<li>
											<input type="radio" id="date04">
											<label for="date04">배송일 직접 선택</label>
										</li>
										<li>
											<input type="radio" id="date05">
											<label for="date05">배송일 직접 선택</label>
										</li>
									</ul>
								</div>
							</li>
							<li class="ac">
								배송일 선택
								<input type="text">
							</li>
						</ul>
					</div>
					<!-- END 제품정보 -->

				</div>
				<script>
					function onView(imgName)
					{
						$(".prod-img-zoom img").attr("src","/m/image/sub/"+imgName);
					}
					function goodsCntChange(mode)
					{
						var goods_cnt = $("#goods_cnt").val();
						var shop_price = 1200;
						var number = 0;

						if(mode=="u"){

									goods_cnt = parseInt(goods_cnt)+1;
							shop_price = parseInt(shop_price)*goods_cnt;

						}else if(mode=="d"){
							if(goods_cnt==1){
								alert("수량은 1개 이상부터 가능합니다.");
								return;
							}else{
								goods_cnt = parseInt(goods_cnt)-1;
							}
						}

						$("#goods_cnt").val(goods_cnt);
						$("#total_price").val(shop_price);
						$(".total_price").html(number_format(0,shop_price));
					}
				</script>
				<p class="mt20 align-c">
					<button type="button" class="plain"><img src="/image/sub/btn_order2.jpg" alt="주문하기"></button>
				</p>
				<ul class="tabMenu mt30">
					<li class="on">
						<a href="#">상품상세정보</a>
					</li>
					<li>
						<a href="#">배송 및 교환/환불</a>
					</li>
				</ul>
				<div class="content_wrap mb50">
					<div class="on">
						<img src="/m/image/sub/dessert_view.jpg" alt="" width="100%">
						<p class="ac mt30">
							<b>탄수화물, 단백질, 칼슘, 비타민</b>등이<br>
							풍부하여 발육과 성장에 좋은<br>
							우리나라 최고의 견과류 하동산 밤입니다.</p>
						<p class="ac mt20"> 견과류 가운데 밤은 유일하게 <b class="ud">비타민 C</b>가 들어있으며<br>
							아몬드, 코코넛, 피칸 등 서양 견과류 대비<br>
							열량이 4분의 1남짓으로<br>
							<b class="ud">동의보감에선 밤을 "가장 유익한 과일"</b>로 칭송했답니다.<br>
							<b>기운을 돋우고 '위장'을 튼튼하게</b> 하는 산골알밤 꼭 챙겨주세요. </p>
						<div class="tblTy02 mt50">
							<table>
								<colgroup>
								<col width="130px">
								</colgroup>
								<tr>
									<th>제품소재</th>
									<td>상세페이지 참고</td>
								</tr>
								<tr>
									<th>색상</th>
									<td>상세페이지 참고</td>
								</tr>
								<tr>
									<th>치수</th>
									<td>상세페이지 참고</td>
								</tr>
								<tr>
									<th>제조자</th>
									<td>상세페이지 참고</td>
								</tr>
								<tr>
									<th>취급주의사항</th>
									<td>상세페이지 참고</td>
								</tr>
								<tr>
									<th>제조연월</th>
									<td>상세페이지 참고</td>
								</tr>
								<tr>
									<th>품질보증기준</th>
									<td>상세페이지 참고</td>
								</tr>
								<tr>
									<th>as 전화번호</th>
									<td>상세페이지 참고</td>
								</tr>
							</table>
						</div>
					</div>
					<div>
						<p class="ac">3만원 이상 구입시 배송비 무료입니다<br>
							(구입비용이 3만원 이하일 경우 3000원 별도).<br>
							제주도 및 도서지역은 익일 배송이 되지 않아<br>
							주문을 받지 않습니다.<br>
							양해를 부탁드립니다.</p>
					</div>
				</div>
				<script>
					$('.tabMenu a').on('click',function(e){
						e.preventDefault();
						$(this).parent().addClass('on').siblings().removeClass('on');
						n=$('.tabMenu a').index($(this));
						$('.content_wrap > div').eq(n).addClass('on').siblings().removeClass('on');
					});
				</script>
				<hr>
				<p class="ac mt40">
					<a href="dessert_list.php" class="btn_g fz16">목록으로</a>
				</p>
		*/
		?>
	</div>
	<!-- inner -->

</div>
<!--END Container-->
<div class="mg95">
</div>
<? include('../include/footer.php') ?>
