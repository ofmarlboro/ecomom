<? 
	$PageName = "RCMD";
	$SubName = "";
	$PageTitle = "추천인 정보";
	include('../include/head.php');
	include('../include/header.php');
?>

<!--Container-->

<div id="container">
	<?include("../include/my_top.php");?>
	<div class="inner clearfix">
		<?include("../include/mypage_lnb.php");?>
		<div class="my_cont clearfix">
			<div>
				<a href="javascript:;" onclick="menuView();">
				내용
				</a>
				<!-- href="javascript:;"이거 넣거나 함수 뒤에 리턴 펄스 -->
				<button type="button" onclick="menuView();">가나다</button>
				<!-- 웬만하면 버튼타입=버튼 넣어줄것 -->
				<!-- 제품 상세보기 -->
				<div id="menu_dt_wrap" style="display:none;">
					<div id="menu_dt">
						<h2 class="htit">
							C36. 닭가슴살아욱옹근죽
						</h2>
						<!-- Scroll Contents -->
						<div class="scroll">
							내요요내요요내요요내요요내요요내요요내요요내요요내요요내요요내요요내요요내요요내요요내요요
						</div>
						<!-- END Scroll Contents -->
						<button type="button" class="plain btn_close" title="닫기" onclick='closeMenuView();'><img src="/image/sub/dt_close.png" alt="닫기"></button>
					</div>
				</div>
				<!-- END 제품 상세보기 -->
				
			</div>
		</div>
	</div>
</div>
<!--END Container-->

<script type="text/javascript">
function menuView(){
	$("#menu_dt_wrap").fadeIn('fast');

	return false;
	// href="javascript:;"이거 넣거나 함수 뒤에 리턴 펄스 
}
function closeMenuView(){
	$("#menu_dt_wrap .scroll").scrollTop(0);
	$("#menu_dt_wrap").hide();
}
</script>
<? include('../include/footer.php') ?>
