<?
	$PageName = "SHOP_ORDER_OK";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

<!--Container-->

<div id="container">
	<?include("../include/top_menu.php");?>
	<?include("../include/mypage_top02.php");?>
	<div class="inner mypage">
		<h1>
			주문실패
		</h1>

				<!-- Shop Wrap -->
				<div class="shop-wrap">



					<!-- 완료 메시지 -->
					<div class="order-finish-msg">
						<p><img src="/m/image/shop/error_txt.png" alt="주문이 성공적으로 완료되었습니다." width="250" height="50"></p>
						<p class="mt10"><?=$this->input->post("ResultMsg")?></p>
					</div>
					<!-- END 완료 메시지 -->

					<!-- 주문버튼 -->
					<div class="shop-inner align-c mb30">
						<button type="button" class="btn-border" onclick="location.href='<?=cdir()?>/dh_order/shop_cart'">다시 시도하기</button>
					</div>
					<!-- END 주문버튼 -->

				</div><!-- END Shop Wrap -->

	</div>
	<!-- inner -->
</div>
<!--END Container-->
<div class="mg95">
</div>
<? include('../include/footer.php') ?>
