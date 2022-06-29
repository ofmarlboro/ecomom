				<!-- Board wrap -->
				<div class="board-wrap ctbox">
					<?php
					if($bbs->bbs_cate == "Y"){
					?>
					<style type="text/css">
						ul.tabs {
							margin: 0;
							padding: 0;
							list-style: none;
							line-height: 30px;
							height: 50px;
							width: 100%;
							font-family:"dotum";
							font-size:12px;
						}
						ul.tabs li {
							float:left;
							text-align:center;
							cursor: pointer;
							height: 31px;
							line-height: 31px;
							border: 1px solid #eee;
							border-left: none;
							background: #fafafa;
							padding: 0px 20px 0px 20px;
						}
						ul.tabs li a:hover{
							text-decoration: none;
							color: #000;
						}
						ul.tabs li.on {
							font-weight: bold;
							background: #ddd;
							border: 1px solid #ddd;
							color: #000;
						}
					</style>
					<ul class="tabs">
						<li class="<?=($this->input->get('cate_idx'))?"":"on";?>"><a href="?">전체</a></li>
						<?php
						foreach($cate_row as $cate){
						?>
						<li class="<?=($this->input->get('cate_idx') == $cate->idx)?"on":"";?>"><a href="?cate_idx=<?=$cate->idx?>"><?=$cate->name?></a></li>
						<?php
						}
						?>
					</ul>
					<?php
					}
					?>

					<!-- 일반 게시판 리스트 -->
					<div class="faq-list">
						<?
						$listuse=1;
						if($totalCnt == 0){
						$listuse=0;
						?>
						<p class="no-ct">등록된 게시물이 없습니다.</p>
						<?}?>
						<?
						foreach ($list as $lt){
						?>
						<h6 class="faq-q"><?=$lt->subject?></h6>
						<div class="faq-a">
							<?=$lt->content?>
						</div>
						<? } ?>
					</div>
					<!-- END 일반 게시판 리스트 -->

					<?if($listuse){?>
					<!-- Pager -->
					<div class="board-pager">
						<?=$Page2?>
					</div><!-- END Pager -->
					<?}?>


				<!-- 검색 -->
				<form action="" name="bbs_search_form" method="get" action="<?cdir()?>/<?=$this->uri->segment(1)?>/lists/<?=$bbs->code?>/"  onSubmit="return false;">
				<div class="board-search">
					<select name="search_item" class="board-search-select">
						<option value="all">전체</option>
						<option value="subject">제목</option>
						<option value="name">작성자</option>
						<option value="content">내용</option>
					</select>
					<input type="text" class="board-search-field" value="<?=$this->input->get('search_order')?>" name="search_order" onKeyDown="SearchInputSendit();">
					<input type="button" value="검색" class="btn-normal-s" onclick="javascript:search();">
				</div>
				</form>
				<!-- END 검색 -->

				</div><!-- END Board wrap -->