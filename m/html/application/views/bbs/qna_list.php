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
			<!-- <p class="align-r board-inner">
				<button class="btn-write">글쓰기</button>
			</p> -->

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
		<!-- 	<ul class="tabs mb50">
				<li class="<?=($this->input->get('cate_idx'))?"":"on";?>"><a href="<?=$query_string.$param?>">전체</a></li>
				<?php
				foreach($cate_row as $cate){
				?>
				<li class="<?=($this->input->get('cate_idx') == $cate->idx)?"on":"";?>"><a href="<?=$query_string.$param?>&cate_idx=<?=$cate->idx?>"><?=$cate->name?></a></li>
				<?php
				}
				?>
			</ul> -->
			<?php
			}
			?>
			<a href="#" onClick="menuView03();" style="display: block;color: #fff;background: #F2A82A;height: 30px;line-height: 30px;text-align: center;">[필독] 문의게시판 이용안내 >></a>
			<div class="ac mt10" style="border: 1px solid #ddd;padding: 10px 0;"><strong>1:1 문의게시판 수기마감 완료시간 안내</strong><br><span style="color: #ff0000;font-weight: bold;">배송일 받는 기준, D-2일 오후4시까지</span><br><br>*이후 변경이 꼭 필요한 고객은 <strong>D-2일 오후 24:00까지는<br>마이페이지를 이용</strong> 하시면 시스템에 자동적용됩니다.</div>
			<ul class="hj_tab">
				<li class="li01">
					<a href="javascript:;">월별식단표</a>
					<div class="cate_list">
						<a href="javascript:menuPop_mobile('2');">준비기</a>
						<a href="javascript:menuPop_mobile('4');">초기</a>
						<a href="javascript:menuPop_mobile('5');">중기</a>
						<a href="javascript:menuPop_mobile('6');">후기2식</a>
						<a href="javascript:menuPop_mobile('1');">후기3식</a>
						<a href="javascript:menuPop_mobile('7');">완료기</a>
						<a href="javascript:menuPop_mobile('3');">반찬/국</a>
					</div>

					<script>
					 $(function(){

						 $(".hj_tab .li01").on("click",function(){
							$(".cate_list").slideToggle();
						 })

					 })
					</script>
				</li>
				<li><a href="#" onClick="menuView02();">냉장/냉동보관</a></li>
				<li><a href="#" onClick="menuView01();">데우는 법</a></li>
			</ul>
		<div id="menu_dt_wrap02" style="display: none;">
          <div id="menu_dt02">
            <h2 class="htit">냉장/냉동보관</h2>
            <div class="scroll">
			<img src="/image/sub/icenoti_m.jpg" alt="" style="width: 90%;display: block;margin: 20px auto;">

            </div>
            <button type="button" class="plain btn_close02" title="닫기" onclick="closeMenuView02();">닫기</button>
          </div>
        </div>
		<div id="menu_dt_wrap01" style="display: none;">
          <div id="menu_dt02">
            <h2 class="htit">이유식 이용보관</h2>
            <div class="scroll">

              <img src="/m/image/sub/noti.jpg" alt="">
            </div>
            <button type="button" class="plain btn_close02" title="닫기" onclick="closeMenuView01();">닫기</button>
          </div>
        </div>
			<div id="menu_dt_wrap03" style="display: none;">
          <div id="menu_dt02">
            <h2 class="htit">문의게시판 이용안내</h2>
            <div class="scroll">
			<img src="/image/sub/qnanoti_m.jpg" alt="" style="width: 90%;display: block;margin: 20px auto;">

            </div>
            <button type="button" class="plain btn_close02" title="닫기" onclick="closeMenuView03();">닫기</button>
          </div>
        </div>
 <script>
        function menuView01(){
          $("#menu_dt_wrap01").fadeIn('fast');
        }
        function closeMenuView01(){
          $("#menu_dt_wrap01 .scroll").scrollTop(0);
          $("#menu_dt_wrap01").hide();
        }


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
			<!-- 게시판 제목이 있는 경우 -->
			<div class="float-wrap board-inner">
				<?php
				if($bbs->bbs_write < 9  && $bbs->bbs_type!=7){
					?>
					<button class="btn-write float-r" type="button" onclick="location.href='<?=cdir()?>/<?=$this->uri->segment(1)?>/write/<?=$bbs->code?><?=$query_string?>'">글쓰기</button>
					<?php
				}
				?>
			</div>
			<!-- END 게시판 제목이 있는 경우 -->

			<!-- 게시판 리스트 -->
			<ul class="board-list review-board mt15">
				<?php
				foreach($notice_list as $nl){
				?>
				<li class="list-notice">
					<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/views/<?=$nl->idx?><?=$query_string.$param?>">
						<p class="post-tit"><?=$nl->subject?></p>
					</a>
				</li>
				<?php
				}
				?>

				<?php
				$listuse=1;
				if($totalCnt == 0){
					$listuse=0;
					?>
					<li class="no-ct">등록된 게시물이 없습니다.</li>
					<?php
				}

				foreach($list as $lt){
					if($bbs->new_check) {
						$new_img = bbsNewImg( $lt->reg_date, $bbs->new_mark, '<img src="/m/image/board_img/new.png" alt="NEW">' );
					}
					$file_img="";
					if($bbs->bbs_pds && $lt->bbs_file!="none" && $lt->bbs_file){
						$file_img = '<img src="/m/image/board_img/file.png" alt="첨부파일">';
					}

					$lock_img = '<img src="/m/image/board_img/lock.png" alt="비밀글">';
					?>
					<li>
						<?php
						if( ( $this->session->userdata('USERID') && $this->session->userdata('USERID') == $lt->userid ) || $lt->secret!="y" ){
						?>
						<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/views/<?=$lt->idx?><?=$query_string.$param?>">
						<?php
						}
						else if( $lt->secret=="y" ){
						?>
						<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/passwd/bbs_view/<?=$lt->idx?><?=$query_string.$param?>">
						<?php
						}
						?>
							<div class="list-append-top">
								<?if($bbs->bbs_cate=="Y"){?><span class="inq-type">[<?=$lt->cate_name?>]</span><?}?>
								<?php
								if($lt->coment_cnt > 0){
								?>
								<span class="inq-status inq-ok">답변완료</span>
								<?php
								}
								else{
								?>
								<span class="inq-status">답변대기중</span>
								<?php
								}
								?>
							</div>
							<p class="post-tit">
								<?php
								if($lt->secret == "y"){
									echo $lock_img;
								}
								?>
								<?=$lt->subject?>
								<?php
								if($lt->coment_cnt){
									?>
									<span class="list-cmt">[<?=$lt->coment_cnt;?>]</span>
									<?php
								}
								?>
								<?=$file_img?>
								<?=$new_img?>
							</p>
							<!-- <p class="post-info"><?=$lt->name?> | <?=strDateCut($lt->reg_date,3)?> | 조회 <?=$lt->read_cnt?></p> -->
							<p class="post-info"><?=$lt->name?> | <?=strDateCut($lt->reg_date,3)?></p>
						</a>
					</li>
					<?php
				}
				?>
			</ul>
			<!-- END 게시판 리스트 -->

			<?php
			if($listuse){
			?>
			<!-- 페이징 -->
			<div class="board-pager">
				<?=$Page2?>
			</div>
			<!-- END 페이징 -->
			<?php
			}
			?>

			<!-- 검색 -->
			<form name="bbs_search_form" method="get" onSubmit="return false;">
			<div class="board-search">
				<select class="board-search-select" name="search_item">
					<option value="all">전체</option>
					<option value="subject" <?if($this->input->get('search_item')=="subject"){?>selected<?}?>>제목</option>
					<option value="name" <?if($this->input->get('search_item')=="name"){?>selected<?}?>>작성자</option>
					<option value="content" <?if($this->input->get('search_item')=="content"){?>selected<?}?>>내용</option>
				</select>
				<input type="text" class="board-search-field" value="<?=$this->input->get('search_order')?>" name="search_order">
				<button type="button" class="btn-search" onclick="javascript:search();">검색</button>
			</div>
			</form>
			<!-- END 검색 -->


		</div><!-- END Board Wrap -->