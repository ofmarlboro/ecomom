<?
	if($this->input->get('cate_no') == 3){
		$PageName = "K04";
	}
	else if($this->input->get('cate_no') == 4){
		$PageName = "K05";
	}
	else if($this->input->get('cate_no') == 5){
		$PageName = "K06";
	}
	else if($this->input->get('cate_no') == 111){
		$PageName = "K02";
	}
	else if($this->input->get('cate_no') == 10){
		$PageName = "K02";
		$SubName = "K0205";
	}
	else if($row->idx == '819'){
		$PageName = "K02";
		$SubName = "K0206";
	}
	else if($row->idx == '900'){
		$PageName = "K03";
		$SubName = "K0303";
	}
	else if($row->idx == '875'){
		$PageName = "K03";
		$SubName = "K0304";
	}
	else if($row->idx == '451'){
		$PageName = "K03";
		$SubName = "K0305";
	}
	else if($row->idx == '425'){
		$PageName = "K03";
		$SubName = "K0306";
	}
	else if($row->idx == '1312'){
		$PageName = "K02";
		$SubName = "K0208";
	}
	else if($row->idx == '1321'){
		$PageName = "K02";
		$SubName = "K0207";
	}
	else{
		$PageName = "K02";
		$SubName = "K0206";
	}

	$PageTitle = ($row->name) ? $row->name : "" ;

	if($this->input->get('type')=="nmk"){
		$PageName="K07";
		$SubName="K0704";
	}

	include("../include/head.php");
	include("../include/header.php");
?>

<script type="text/javascript">
$(window).bind("pageshow", function(event) {
	console.log(event.originalEvent);
    if (event.originalEvent.PageTransitionEvent) {
        document.location.reload();
    }
});

$(function(){
	$('.anchor').css('cursor','pointer');
});
</script>

	<script type="text/javascript" src="/js/product_view.js"></script>
	<!--Container-->
	<div id="container">
		<?include("../include/sub_top.php");?>

		<div class="content inner">

			<?php
			include "{$view}.php";
			?>

			<?php
			/*
				<!-- Shop wrap -->
				<div class="shop-wrap">

					<script type="text/javascript" src="/js/product_view.js"></script>

					<!-- 제품상단 -->
					<div class="prod-top">

						<!-- 제품이미지 -->
						<div class="prod-img">
							<div class="prod-img-zoom">
								<img src="/image/sub/prod_zoom.jpg" alt="제품 확대이미지">
							</div>
							<div class="prod-img-sm">
								<ul class="prod-thumbs">
									<li><a href="/image/sub/snack2_1.jpg"><img src="/image/sub/snack2_1.jpg" alt="제품상세 이미지 1"></a></li>
									<li><a href="/image/sub/snack2_1.jpg"><img src="/image/sub/snack2_1.jpg" alt="제품상세 이미지 2"></a></li>
									<li><a href="/image/sub/snack2_1.jpg"><img src="/image/sub/snack2_1.jpg" alt="제품상세 이미지 3"></a></li>
									<li><a href="/image/sub/snack2_1.jpg"><img src="/image/sub/snack2_1.jpg" alt="제품상세 이미지 4"></a></li>
									<li><a href="/image/sub/snack2_1.jpg"><img src="/image/sub/snack2_1.jpg" alt="제품상세 이미지 4"></a></li>
								</ul>
							</div>
						</div><!-- END 제품이미지 -->

						<!-- 제품정보 -->
						<div class="prod-info-wrap">
							<h3 class="prod-name">산골알밤</h3>

							<!-- 우측 스티커 -->
							<div class="prod-share">
								<span>SNS 공유하기</span>
								<a href="#"><img src="/image/sub/icon_fb.png" alt="Facebook"></a>
								<a href="#"><img src="/image/sub/icon_twt.png" alt="Twitter"></a>
								<a href="#"><img src="/image/sub/icon_google.png" alt="Google Plus"></a>
							</div><!-- END 우측 스티커 -->

							<!-- 제품설명 -->
							<div class="prod-desc-wrap">
								<div class="prod-desc">
									제품에 대한 간략설명이 표시됩니다.<br>대략 2~3줄 이내의 간단한 문구를 관리자모드에서 입력합니다.
								</div>
							</div>
							<!-- END 제품설명 -->

							<!-- 제품정보 -->
							<div class="prod-view-cnt">
								<p class="name">산골알밤</p>
								<div class="float-r float-wrap">
									<div class="cnt">
										<button type="button" class="plain" title="1개 감소"><img src="/image/sub/btn_minus2.png" alt="1 감소"></button>
										<input type="text" value="1">
										<button type="button" class="plain" title="1개 추가"><img src="/image/sub/btn_plus2.png" alt="1 추가"></button>
									</div>
									<p class="price"><em>6,900</em>원</p>
								</div>
							</div><!-- END 제품정보 -->

							<!-- 총 가격 -->
							<div class="prod-total">
								<div class="deliv">
									배송비 : <em>2,500</em>원<br><em>30,000</em>원 이상 무료배송
								</div>
								<div class="price">
									<span class="label">총 상품금액</span>
									<em>60,000</em> <span class="unit">원</span>
								</div>
							</div><!-- END 총 가격 -->


							<!-- 배송날짜선택 -->
							<div class="prod-deliv-date">
								<div class="tit">
									<em><img src="/image/sub/icon_cal.png" alt="" class="img-mid mr5">예약배송에 추가</em>
									<div class="sel-wrap">
										<button type="button" class="plain btn" onclick="toggleSelBox(this, event);">장바구니 일정에 추가 또는 정기배송에 추가</button>
										<ul>
											<li><input type="radio" name="deliv_date" id="deliv_date0"><label for="deliv_date0">===배송일 직접 선택===</label></li>
											<li><input type="radio" name="deliv_date" id="deliv_date1"><label for="deliv_date1">[장바구니] 2월 22일 중기 추천식단 외</label></li>
											<li><input type="radio" name="deliv_date" id="deliv_date2"><label for="deliv_date2">[장바구니] 2월 12일 간식 외</label></li>
											<li><input type="radio" name="deliv_date" id="deliv_date3"><label for="deliv_date3">[장바구니] 2월 13일</label></li>
											<li><input type="radio" name="deliv_date" id="deliv_date4"><label for="deliv_date4">[골라담기] 2월 15일 중기준비기 외</label></li>
											<li><input type="radio" name="deliv_date" id="deliv_date5"><label for="deliv_date5">[골라담기] 2월 16일 준비기 외</label></li>
											<li><input type="radio" name="deliv_date" id="deliv_date6"><label for="deliv_date6">[정기배송] 2월 22일 후기 3회차</label></li>
											<li><input type="radio" name="deliv_date" id="deliv_date7"><label for="deliv_date7">[정기배송] 2월 22일 후기 4회차</label></li>
											<li><input type="radio" name="deliv_date" id="deliv_date8"><label for="deliv_date8">[정기배송] 2월 22일 후기 5회차</label></li>
											<li><input type="radio" name="deliv_date" id="deliv_date9"><label for="deliv_date9">[정기배송] 2월 22일 후기 6회차</label></li>
											<li><input type="radio" name="deliv_date" id="deliv_date10"><label for="deliv_date10">[정기배송] 2월 22일 후기 7회차</label></li>
											<li><input type="radio" name="deliv_date" id="deliv_date11"><label for="deliv_date11">[정기배송] 2월 22일 후기 8회차</label></li>
											<li><input type="radio" name="deliv_date" id="deliv_date12"><label for="deliv_date12">[정기배송] 3월 22일 반찬/국 1회차</label></li>
											<li><input type="radio" name="deliv_date" id="deliv_date13"><label for="deliv_date13">[정기배송] 3월 22일 반찬/국 2회차</label></li>
											<li><input type="radio" name="deliv_date" id="deliv_date14"><label for="deliv_date14">[정기배송] 3월 22일 반찬/국 3회차</label></li>
											<li><input type="radio" name="deliv_date" id="deliv_date15"><label for="deliv_date15">[정기배송] 3월 22일 반찬/국 4회차</label></li>
											<li><input type="radio" name="deliv_date" id="deliv_date16"><label for="deliv_date16">[정기배송] 3월 22일 반찬/국 5회차</label></li>
										</ul>
									</div>
								</div>
								<div class="date-sel" style="display:none;">
									<strong><a href="#">배송일 선택</a></strong>
									<input type="text">
								</div>
							</div><!-- END 배송날짜선택 -->

							<p class="mt20"><button type="button" class="plain"><img src="/image/sub/btn_order2.jpg" alt="주문하기"></button></p>

						</div><!-- END 제품정보 -->

					</div><!-- END 제품상단 -->


					<!-- 제품상세탭 -->
					<ul class="shop-tab">
						<li class="on"><a href="#detail1">상세정보</a></li>
						<li><a href="#detail2">배송 및 교환/환불</a></li>
					</ul>
					<!-- END 제품상세탭 -->

					<!-- 상세정보 -->
					<div class="shop-tab-ct" id="detail1">
						<div class="u-editor">
							<p class="align-c"><img src="/image/sub/prod_dt_img.jpg" alt=""></p>
						</div>
						<table class="cm_tbl align-c">
							<colgroup>
								<col style="width:20%;">
								<col style="width:30%;">
								<col style="width:20%;">
								<col>
							</colgroup>
							<tbody>
								<tr>
									<th>제품소재</th>
									<td>상품페이지 참고</td>
									<th>세탁방법 및 취급시 주의사항</th>
									<td>상품페이지 참고</td>
								</tr>
								<tr>
									<th>색상</th>
									<td>상품페이지 참고</td>
									<th>제조연월</th>
									<td>상품페이지 참고</td>
								</tr>
								<tr>
									<th>치수</th>
									<td>상품페이지 참고</td>
									<th>품질보증기준</th>
									<td>상품페이지 참고</td>
								</tr>
								<tr>
									<th>제조자</th>
									<td>상품페이지 참고</td>
									<th>A/S책임자와 전화번호</th>
									<td>상품페이지 참고</td>
								</tr>
							</tbody>
						</table>
					</div>
					<!-- END 상세정보 -->


					<!-- 제품상세탭 -->
					<ul class="shop-tab">
						<li><a href="#detail1">상세정보</a></li>
						<li class="on"><a href="#detail2">배송 및 교환/환불</a></li>
					</ul>
					<!-- END 제품상세탭 -->

					<!-- 반품 및 교환 -->
					<div class="shop-tab-ct" id="detail2">
						<div class="u-editor">
							<p class="align-c">3만원이상 구입시 배송료 무료 입니다 (구입비용이 3만원 이하일 경우 3000원 별도)<br>
							제주도 및 도서지역은 익일 배송이 되지 않아 주문을 받지 않습니다.<br>
							양해를 부탁드립니다.</p>
						</div>
					</div>
					<!-- END 반품 및 교환 -->
					<hr>

					<p class="align-c mt50">
						<a href="prod_list.php" class="btn-normal">목록으로</a>
					</p>



				</div><!-- END Shop wrap -->
			*/
			?>

		</div><!-- END Content -->
	</div><!--END Container-->

<?include("../include/footer.php");?>
