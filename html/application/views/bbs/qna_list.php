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




			<!-- Board wrap -->
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
				<div class="hj_add clearfix">
					<ul class="new_list">
						<li class="list01">
							<a href="javascript:;">월별식단표</a>
							<div class="category">
								<ul>
									<li><a href="javascript:menuPop('2');">준비기</a></li>
									<li><a href="javascript:menuPop('4');">초기</a></li>
									<li><a href="javascript:menuPop('5');">중기</a></li>
									<li><a href="javascript:menuPop('6');">후기2식</a></li>
									<li><a href="javascript:menuPop('1');">후기3식</a></li>
									<li><a href="javascript:menuPop('7');">완료기</a></li>
									<li><a href="javascript:menuPop('3');">반찬/국</a></li>
								</ul>
							</div>
						</li>
						<!-- <li class="list02"><a href="javascript:;">상세보기</a></li> -->
						<li class="list03"><a href="javascript:;" onclick="menuView02();">데우는법</a></li>
						<li class="list02"><a href="javascript:;" onclick="menuView03();">냉장/냉동보관</a></li>
					</ul>
					<script>
						$(function(){
							$(".new_list .list01").on("mouseover",function(){
								$(this).find('.category').show();
							})
									$(".new_list .list01").on("mouseleave",function(){
							$(this).find('.category').hide();
							})
						})
					</script>
					<p class="orderedit_top mt0 pb0">배송일/배송지 변경은 마이페이지에서 직접변경 가능하시며, 더욱 신속하게 처리됩니다. <br>
					연휴에 몰아받기 원하시는 고객님도 배송일변경을 이용해주세요.</p>
					<p class="orderedit_top mt5 pb0">1:1 문의게시판 수기마감은 <strong class="red">“배송일 받는 기준, D-2일 오후4시까지”</strong>만 접수가능합니다.<br>
					오후4시 이후에도 꼭 변경이 필요하시면, 마이페이지 > 메뉴/배송지/배송일변경에서 직접 변경하시면<br>
					<strong class="red">D-2일 밤 12시(24:00)까지는 시스템에서 자동반영</strong>됩니다.</p>
					<p class="orderedit_top mt5 pb0">이 후 변경은 고객센터로 문의를 주셔도 조리준비시기로 변경불가한점 양해말씀드립니다.</p>
				</div>
				<!-- 일반 게시판 리스트 -->
				<table class="board-list mt20">
					<thead>
						<tr>
							<th class="col-num">No.</th>
							<?if($bbs->bbs_cate=="Y"){?>
							<th class="col-df">문의유형</th>
							<?}?>
							<th>제목</th>
							<th class="col-writer">작성자</th>
							<th class="col-date">날짜</th>
							<th class="col-re">답변여부</th>
						</tr>
					</thead>
					<tbody>
						<? foreach ($notice_list as $nl){ ?>
						<tr class="list-notice">
							<td colspan="<?=($bbs->bbs_cate=="Y")?"2":"1";?>"><img src="/image/board_img/speaker.png" alt="NOTICE"></td>
							<!-- <?if($bbs->bbs_cate=="Y"){?>
							<td class="qna-list-type">-</td>
							<?}?> -->
							<td class="list-tit"><a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/views/<?=$nl->idx?><?=$query_string.$param?>"><?=$nl->subject?></a></td>
							<td><?=$nl->name?></td>
							<td><?=strDateCut($nl->reg_date,3)?></td>
							<td></td>
						</tr>
						<? } ?>
						<?
						$listuse=1;
						if($totalCnt == 0){
						$listuse=0;
						?>
						<tr>
							<td colspan="6" class="no-ct">
								<p>등록된 게시물이 없습니다.</p>
							</td>
						</tr>
						<?}?>
						<?
						foreach ($list as $lt){
							if($bbs->new_check) {
								$new_img = bbsNewImg( $lt->reg_date, $bbs->new_mark, '<img src="/image/board_img/icon_new.gif" alt="NEW">' );
							}
							$file_img="";
							if($bbs->bbs_pds && $lt->bbs_file!="none" && $lt->bbs_file){
								$file_img = '<img src="/image/board_img/icon_file.gif" alt="첨부파일">';
							}
						?>
						<tr>
							<td><?=$totalCnt?></td>
							<?if($bbs->bbs_cate=="Y"){?>
							<td class="qna-list-type">[<?=$lt->cate_name?>]</td>
							<?}?>
							<td class="list-tit">
								<? if( ($this->session->userdata('USERID') && $this->session->userdata('USERID') == $lt->userid ) || $lt->secret!="y" ){?>
								<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/views/<?=$lt->idx?><?=$query_string.$param?>">
								<? }else if($lt->secret=="y"){ ?>
								<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/passwd/bbs_view/<?=$lt->idx?><?=$query_string.$param?>">
								<?}?>
								<? if($lt->secret=="y"){ ?><img src="/image/board_img/icon_lock.gif" alt="비밀글"><? } ?>
								<?=$lt->subject?></a> <?=$file_img?><?=$new_img?>
								<? if($lt->coment_cnt) {?><span class="cmt-cnt">[<?=$lt->coment_cnt;?>]</span><?}?>
							</td>
							<td><?=$lt->name?></td>
							<td><?=strDateCut($lt->reg_date,3)?></td>
							<td>
								<?php
								if($lt->coment_cnt > 0){
								?>
								<em class="list-re-ok">답변완료</em>
								<?php
								}
								else{
								?>
								<em class="list-re">답변대기중</em>
								<?php
								}
								?>
							</td>
						</tr>
						<?
							$totalCnt--;
							}
						?>
					</tbody>
				</table><!-- END 일반 게시판 리스트 -->

				<?php
				if($bbs->bbs_write < 9  && $bbs->bbs_type!=7){
					if( $bbs->bbs_write == 0 || ($bbs->bbs_write==1 && $this->session->userdata('USERID')) ){
					?>
					<div class="list-btns">
						<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/write/<?=$bbs->code?><?=$query_string?>" class="btn-write">글쓰기</a>
					</div>
					<?php
					}
					else{
					?>
					<div class="list-btns">
						<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/write/<?=$bbs->code?><?=$query_string?>" class="btn-write">글쓰기</a>
					</div>
					<?php
					}
				}
				?>

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
						<option value="subject" <?if($this->input->get('search_item')=="subject"){?>selected<?}?>>제목</option>
						<option value="name" <?if($this->input->get('search_item')=="name"){?>selected<?}?>>작성자</option>
						<option value="content" <?if($this->input->get('search_item')=="content"){?>selected<?}?>>내용</option>
					</select>
					<input type="text" class="board-search-field" value="<?=$this->input->get('search_order')?>" name="search_order" onKeyDown="SearchInputSendit();">
					<input type="button" value="검색" class="btn-normal-s" onclick="javascript:search();">
				</div>
				</form>
				<!-- END 검색 -->
<!-- 20180524 -->
				<div id="menu_dt_wrap02" style="display: none;">
					<div id="menu_dt02">
						<h2 class="htit">이유식 데우는 법</h2>
						<div class="scroll">
							<img src="/image/sub/img01.jpg" alt="">
						</div>
						<button type="button" class="plain btn_close" title="닫기" onclick="closeMenuView02();"><img src="/image/sub/dt_close.png" alt="닫기"></button>
					</div>
				</div>



<!-- 20180524 -->
				<div id="menu_dt_wrap03" style="display: none;">
					<div id="menu_dt02">
						<h2 class="htit">냉장/냉동보관</h2>
						<div class="scroll">
							<img src="/image/sub/icenoti_pc.jpg" alt="">
						</div>
						<button type="button" class="plain btn_close" title="닫기" onclick="closeMenuView03();"><img src="/image/sub/dt_close.png" alt="닫기"></button>
					</div>
				</div>

				<script>
				function menuView02(){
					$("#menu_dt_wrap02").fadeIn('fast');
				}
				function closeMenuView02(){
					$("#menu_dt_wrap02 .scroll").scrollTop(0);
					$("#menu_dt_wrap02").hide();
				}

				function menuView03(){
					$("#menu_dt_wrap03").fadeIn('fast');
				}
				function closeMenuView03(){
					$("#menu_dt_wrap03 .scroll").scrollTop(0);
					$("#menu_dt_wrap03").hide();
				}


				</script>