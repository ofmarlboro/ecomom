<?
	if(strpos($_SERVER['REQUEST_URI'],"dh/wc04")!==false){
		alert(cdir()."/dh_board/lists/wc04");
	}

	$PageName = "K08";
	$SubName = "K080304";
	$PageTitle = "이유식 공부하기";
	include('../include/head.php');
	include('../include/header.php');
?>

<!--Container-->

<div id="container">
	<?include("../include/sub_top.php");?>
	<div class="content inner clearfix">
		<div class="my_lnbWrap">
			<?include("../include/study.php");?>
		</div>
		<div class="my_cont clearfix">
			<?php
			include "{$view}.php";
			?>
		<?php
		/*
			<div class="study_c mt0 clearfix">
				<ul class="tabMenu01">
						<li class="on"><a href="#">전체</a></li>
						<li><a href="#">곡류</a></li>
						<li><a href="#">채소류</a></li>
						<li><a href="#">육류/가금류/난류</a></li>
						<li><a href="#">어패류/해조류</a></li>
				</ul>
				<ul class="tabMenu01">
						<li><a href="#">버섯류/서류</a></li>
						<li><a href="#">과실류/종실/견과류</a></li>
						<li><a href="#">두유/유제품류</a></li>
						<li><a href="#">식용유지류/양념류</a></li>
						<li></li>
				</ul>
				<p class="mt30"></p>
				<img src="/image/sub/ico_bg.jpg" alt="">
				<ul class="study_li">
					<li class="ml0">
						<h1>보리</h1>
						<p>보리에는 칼슘, 인, 철, 나트륨, 칼륨 등이 풍부하게 함유되어 있습니다. <br>특히 이들 중 한국인에게 부족할 수 있는칼슘과 철은 쌀에비해 각각 8배, 5배나 더많습니다.</p>
						<div class="ico_wrap">
							<!-- 클래스명 i01 품목 / i02 원산지정보 / i03 친환경유무 -->
							<span class="i01">보리</span>
							<span class="i02">국내산</span>
							<span class="i03">국내산</span>
						</div>
					</li>
				</ul>
			</div>

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

			<form action="" name="bbs_search_form" method="get" onsubmit="return false;">
				<div class="board-search">
					<select name="search_item" class="board-search-select">
						<option value="all">전체</option>
						<option value="subject">제목</option>
						<option value="name">작성자</option>
						<option value="content">내용</option>
					</select>
					<input type="text" class="board-search-field" value="" name="search_order" onkeydown="SearchInputSendit();">
					<input type="button" value="검색" class="btn-normal-s" onclick="javascript:search();">
				</div>
			</form>
		*/
		?>
		</div>
	</div>
</div>
<!--END Container-->

<? include('../include/footer.php') ?>
