<?
$total_cnt = $totalCnt;
$write="";

if($bbs->bbs_write==0){
	$write = 1;
}else if($bbs->bbs_write==1 && $this->session->userdata('USERID')){
	if($bbs->write_level==0){ //전체권한
		$write=1;
	}else if($this->session->userdata('LEVEL') >= $bbs->write_level){
		$write=1;
	}

}
?>

			<!-- Board Wrap -->
			<div class="board-wrap">

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
					<li class="<?=($this->input->get('cate_idx'))?"":"on";?>"><a href="<?=$query_string.$param?>">전체</a></li>
					<?php
					foreach($cate_row as $cate){
					?>
					<li class="<?=($this->input->get('cate_idx') == $cate->idx)?"on":"";?>"><a href="<?=$query_string.$param?>&cate_idx=<?=$cate->idx?>"><?=$cate->name?></a></li>
					<?php
					}
					?>
				</ul>
				<?php
				}
				?>


				<? if($bbs->bbs_write < 9  && $bbs->bbs_type!=7){
					if($bbs->bbs_write == 0 || ($bbs->bbs_write==1 && $this->session->userdata('USERID'))){
				?>
				<!-- <p class="align-r board-inner">
					<button class="btn-write">글쓰기</button>
				</p> -->

				<!-- 게시판 제목이 있는 경우 -->
				<div class="float-wrap board-inner">
					<button class="btn-write float-r" onclick="location.href='<?=cdir()?>/<?=$this->uri->segment(1)?>/write/<?=$bbs->code?><?=$query_string?>';">글쓰기</button>
				</div>
				<!-- END 게시판 제목이 있는 경우 -->
				<?}?>
				<?}?>

				<!-- 게시판 리스트 -->
				<ul class="board-list review-board mt15">
					<? foreach ($notice_list as $nl){ ?>
					<li class="list-notice">
						<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/views/<?=$nl->idx?><?=$query_string.$param?>">
							<p class="post-tit"><?=$nl->subject?></p>
						</a>
					</li>
					<? } ?>
					<?
						$listuse=1;
						if($totalCnt == 0){
						$listuse=0;
					?>
					<li class="no-ct">등록된 게시글이 없습니다.</li>
					<?}?>
					<?
					foreach ($list as $lt){
						if($bbs->new_check) {
							$new_img = bbsNewImg( $lt->reg_date, $bbs->new_mark, '<img src="/m/image/board_img/new.png" alt="NEW">' );
						}

						$file_img="";
						if($bbs->bbs_pds && $lt->bbs_file!="none" && $lt->bbs_file){
							$file_img = '<img src="/image/board_img/icon_file.gif" alt="첨부파일">';
						}

						if( ($this->session->userdata('USERID') && $this->session->userdata('USERID') == $lt->userid ) || $lt->secret!="y" ){
							$view_url = cdir()."/".$this->uri->segment(1)."/views/".$lt->idx.$query_string.$param;
						}else if($lt->secret=="y"){
							$view_url = cdir()."/".$this->uri->segment(1)."/passwd/bbs_view/".$lt->idx.$query_string.$param;
						}
					?>
					<li>
						<a href="<?=$view_url?>">
							<div class="list-append-top">
								<?if($bbs->bbs_cate=="Y"){?>
								<span class="inq-type">[<?=$lt->cate_name?>]</span>
								<?}?>
								<? if($bbs->bbs_coment==1) {
									if($lt->coment_cnt){
								?>
								<span class="inq-status inq-ok">답변완료</span>
								<?}else{?>
								<span class="inq-status">답변대기중</span>
								<?
									}
								}
								?>
							</div>
							<p class="post-tit">
								<? if($lt->secret=="y"){ ?><img src="/m/image/board_img/lock.png" alt="비밀글"><?}?> <?=$lt->subject?> <?=$file_img?><?=$new_img?><? if($lt->coment_cnt) {?><span class="list-cmt">[<?=$lt->coment_cnt;?>]</span><?}?></p>
							<p class="post-info"><?=$lt->name?> | <?=strDateCut($lt->reg_date,3)?> | 조회 <?=$lt->read_cnt?></p>
						</a>
					</li>
					<?
						$totalCnt--;
						}
					?>
				</ul>
				<!-- END 게시판 리스트 -->



				<?if($listuse){?>
				<!-- 페이징 -->
				<div class="board-pager">
					<?=$Page2?>
				</div><!-- END 페이징 -->
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
					<button type="button" class="btn-search" onclick="javascript:search();">검색</button>
				</div>
				</form>
				<!-- END 검색 -->

			</div><!-- END Board Wrap -->