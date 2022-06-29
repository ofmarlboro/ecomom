<?
	$PageName = "SHOP";
	$SubName = "";
	include("../include/head.php");
	include("../include/header.php");
?>

	<!--Container-->
	<div id="container">
		<div class="sv <?=$PageName?>"></div>
		<div class="sub_top">
			<div class="inner float-wrap">
				<h2 class="gn_tit"><img src="/image/sub/menu_tit2.jpg" alt="산골이유식"></h2>
				<h3 class="hidden">주문/결제 실패</h3>
			</div>
		</div>

		<!-- Inner -->
		<div class="inner content">

			<!-- Shop Wrap -->
			<div class="shop-wrap">
				<!-- 주문 Wrap -->
				<div class="shop-order-wrap">

					<div class="order-finish-msg error-msg">
						<p><img src="/image/shop/error_txt.png" alt="주문에 실패했습니다."></p>
						<p class="mt15">에러코드 : <?=$this->input->post("ResultCode")?><br><?=$this->input->post("ResultMsg")?></p>
						<p class="mt10">다시 시도 후에도 계속해서 문제가 발생한다면, 고객센터로 연락 바랍니다.</p>
					</div>


					<!-- 하단 버튼 -->
					<div class="align-c mb50">
						<button type="button" class="btn-border" onclick="location.href='/html/dh_order/shop_cart'">장바구니로 돌아가기</button>
					</div><!-- END 하단 버튼 -->


				</div><!-- END 주문 Wrap -->

			</div><!-- END Shop Wrap -->
		</div><!-- END Inner -->
	</div><!--END Container-->

<?include("../include/footer.php");?>
