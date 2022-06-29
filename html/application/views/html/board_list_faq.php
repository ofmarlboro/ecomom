<? 
	$PageName = "QNA";
	$SubName = "";
	$PageTitle = "1:1상담";
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

			<!-- Board wrap -->
			<div class="board-wrap">
				<!-- 일반 게시판 리스트 -->
				<div class="faq-list">
					<!-- <p class="no-ct">등록된 게시물이 없습니다.</p> -->

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
					<button type="button"><img src="/image/board_img/arrow_l_end.gif" alt="맨 앞으로"></button>
					<button type="button"><img src="/image/board_img/arrow_l.gif" alt="이전"></button>
					<a href="#" class="on">1</a>
					<a href="#">2</a>
					<a href="#">3</a>
					<a href="#">4</a>
					<a href="#">5</a>
					<button type="button"><img src="/image/board_img/arrow_r.gif" alt="다음"></button>
					<button type="button"><img src="/image/board_img/arrow_r_end.gif" alt="맨 뒤로"></button>
				</div>
				<!-- END 페이징 -->

				<!-- 검색 -->
				<div class="board-search">
					<select class="board-search-select">
						<option value="전체">전체</option>
						<option value="제목">제목</option>
						<option value="작성자">작성자</option>
						<option value="내용">내용</option>
					</select>
					<input type="text" class="board-search-field">
					<input type="button" value="검색" class="btn-normal-s">
				</div>
				<!-- END 검색 -->
			</div><!-- END Board wrap -->

			</div>
		</div>
	</div>
</div>