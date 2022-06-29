<?
if(!$this->session->userdata('USERID')){
	alert(cdir()."/dh_member/login?go_url=".$_SERVER['REDIRECT_URL'],"로그인 후 이용 가능합니다.");
}
	$PageName = "K07";
	$SubName = "K0705";
	include("../include/head.php");
	include("../include/header.php");
?>
<!--Container-->
<div id="container">
	<?include("../include/sub_top.php");?>
	<div class="inner ac pt60">
		<div class="coupon__wrap">
			<img src="/image/sub/coupon_img01_mod.jpg" alt="" />
			<p class="para01">
				번호 입력 후 최종 주문까지 완료해야 상품권 등록이 완료됩니다.<br>
				주문을 완료하지 않으면 상품권 번호는 임의저장되지 않으니 지류상품권을<br>
				분실하지 않도록 주의바랍니다.
			</p>
			<form action="/html/dh/event04_order" method="post" name="cpfrm" id="cpfrm">
			<div class="coupon__form">
				<input type="text" placeholder="쿠폰번호 입력" name="coupon_code" msg="쿠폰번호를">
				<button type="button" onclick="frmChk('cpfrm')">등록하기</button>
			</div>
			<img src="/image/sub/coupon_img02_mod.jpg" alt="" />
			</form>
		</div>
	</div>
</div>
<!--END Container-->

<?include("../include/footer.php");?>