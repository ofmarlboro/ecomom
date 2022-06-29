<?
	$PageName = "K08";
	$SubName = "K0806";
	$PageTitle = "FAQ";
	include('../include/head.php');
	include('../include/header.php');
?>

	<!--Container-->
	<div id="container">
		<?include("../include/top_menu.php");?>
		<? // include("../include/mypage_top02.php");?>
		<? //include("../include/oe_menu05.php");?>

		<div class="inner pt20 mypage">
			<h1><?=$$SubName->tit?></h1>

			<?php
			include "{$view}.php";
			?>

			<?php
			/*
				<div class="board-wrap">
					<!-- 일반 게시판 리스트 -->
					<div class="faq-list">
						<!-- <p class="no-ct">등록된 게시글이 없습니다.</p> -->

						<h6 class="faq-q">질문의 내용이 들어갑니다.</h6>
						<div class="faq-a">
							답변의 내용이 들어갑니다.<br>
							답변의 내용이 들어갑니다.
						</div>

						<h6 class="faq-q">질문의 내용이 들어갑니다.</h6>
						<div class="faq-a">
							답변의 내용이 들어갑니다.<br>
							답변의 내용이 들어갑니다.
						</div>

						<h6 class="faq-q">질문의 내용이 들어갑니다.</h6>
						<div class="faq-a">
							답변의 내용이 들어갑니다.<br>
							답변의 내용이 들어갑니다.
						</div>

						<h6 class="faq-q">질문의 내용이 들어갑니다.</h6>
						<div class="faq-a">
							답변의 내용이 들어갑니다.<br>
							답변의 내용이 들어갑니다.
						</div>

						<h6 class="faq-q">질문의 내용이 들어갑니다.</h6>
						<div class="faq-a">
							답변의 내용이 들어갑니다.<br>
							답변의 내용이 들어갑니다.
						</div>
					</div>
					<!-- END 일반 게시판 리스트 -->


					<!-- 페이징 -->
					<div class="board-pager">
						<button type="button"><img src="/m/image/board_img/arrow_l_end.png" alt="맨 앞으로"></button>
						<button type="button"><img src="/m/image/board_img/arrow_l.png" alt="이전"></button>
						<a href="#" class="on">1</a>
						<a href="#">2</a>
						<a href="#">3</a>
						<button type="button"><img src="/m/image/board_img/arrow_r.png" alt="다음"></button>
						<button type="button"><img src="/m/image/board_img/arrow_r_end.png" alt="맨 뒤로"></button>
					</div>
					<!-- END 페이징 -->


				</div>
			*/
			?>

		</div>
		<!-- inner -->
	</div>
	<!--END Container-->
	<div class="mg95"></div>










<? include('../include/footer.php') ?>


