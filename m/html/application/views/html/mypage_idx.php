<?
	$PageName = "MYPAGE_IDX";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

	<!--Container-->
	<div id="container">
		<?include("../include/top_menu.php");?>
		<?include("../include/mypage_top.php");?>
		<div class="inner">
			<!-- lnb -->
			<ul class="m_lnb">
					<li><a href="">나의 쇼핑정보</a>
						<div class="m_slnbWrap">
							<ul class="m_slnb">
								<li><a href="<?=$ORDERLIST->url?>">주문배송조회</a></li>
								<li><a href="<?=$ORDER_EDIT->url?>">메뉴/배송지/배송일 변경</a></li>
								<li><a href="<?=cdir()?>/dh_order/cancel_list">취소/환불 가능내역</a></li>
							</ul>
						</div>
					</li>
					<li><a href="">나의 계정설정</a>
						<div class="m_slnbWrap">
							<ul class="m_slnb">
								<li><a href="<?=$MYPAGE->url?>">회원정보 수정</a></li>
								<li><a href="<?=cdir()?>/dh/deposit">예치금</a></li>
								<li><a href="<?=$POINT->url?>">적립금</a></li>
								<li><a href="<?=$COUPON->url?>">쿠폰</a></li>
								<!-- <li><a href="<?=cdir()?>/dh_order/qna">1:1 상담</a></li> -->
								<li><a href="<?=cdir()?>/dh_board/lists/withcons07/?myqna=Y">1:1 상담</a></li>
								<li><a href="<?=$RCMD->url?>">추천인 정보</a></li>
								<li><a href="<?=$ADRS->url?>">배송지 관리</a></li>
								<li><a href="<?=$LEAVE->url?>">회원 탈퇴</a></li>
							</ul>
						</div>
					</li>
				</ul>
			<!-- END lnb -->
		</div>
		<!-- inner -->
	</div>
	<!--END Container-->
	<div class="mg95"></div>


	<!-- 공지 레이어팝업 -->
	<div class="layer_pop03" style="display:none;">
		<div class="layer_pop_inner03">
			<h1>에코맘 중요공지!</h1>
			<p>에코맘은 경남 하동의 친환경 계란만을 사용하고 있지만, 살충제 계란으로 인해 불안한 고객님들을 위해 000메뉴를 000메뉴로 변경하였습니다.
			에코맘은 경남 하동의 친환경 계란만을 사용하고 있지만, 살충제 계란으로 인해 불안한 고객님들을 위해 000메뉴를 000메뉴로 변경하였습니다.</p>
			<button type="button" class="w100 close" title="닫기" onclick='closeMenuView03();'>
			확인</button>
		</div>
	</div>
	<!-- END 제품 상세보기 -->

	<script type="text/javascript">

		$(document).ready(function() {
			//menuView03();
		});

		function menuView03(){
			$(".layer_pop03").fadeIn('fast');
			return false;
		}
		function closeMenuView03(){
			$(".layer_pop03").hide();
		}
	</script>






<? include('../include/footer.php') ?>


