<script>
	function show_layer(idx){
		$(".layer_t"+idx).slideToggle();
	}
	$(function(){
		$("html, body").on("click", function(){
			$(".layer_t").hide();
		});
	});
</script>

<?
if($this->input->get('cate_idx')){
	$send = "?cate_idx=".$this->input->get('cate_idx');
}else{
	$send = "";
}
?>

<? if($bbs->bbs_cate=='Y'){ ?>

				<div class="float-wrap mb30" style="margin-top:-5px;">
					<input type="button" class="<? if(!$this->input->get('cate_idx')){?>btn-ok<?}else{?>btn-clear<?}?>" value="전체" onclick="javascript:location.href='?cate_idx=';">
					<? foreach($cate_list as $c_list){ ?>
					<input type="button" class='<? if($this->input->get('cate_idx') == $c_list->idx){?>btn-ok<?}else{?>btn-clear<?}?>' value="<?=$c_list->name?>" onclick="javascript:location.href='?cate_idx=<?=$c_list->idx?>';">
					<?}?>
				</div>

<?}?>

<style type="text/css">
	.qnabbs{ background:#fff; }
	.qnabbs:hover{ background:#eee; }
</style>

<script type="text/javascript">
<!--
	function coment_gubun(val){
		location.href="?coment="+val;
	}

	function bbs_hide(idx){
		if(confirm('게시물을 숨김 처리 하시겠습니까?')){
			location.href="/html/board/tag_chg/?ajax=1&tag=1&idx="+idx;
		}
	}

	function bbs_show(idx){
		if(confirm('게시물을 노출 처리 하시겠습니까?')){
			location.href="/html/board/tag_chg/?ajax=1&tag=0&idx="+idx;
		}
	}
//-->
</script>

				<h3 class="icon-search">검색</h3>
				<!-- 제품검색 -->
				<table class="adm-table">
					<colgroup>
						<col style="width:15%;"><col>
					</colgroup>
					<!-- <tr>
						<th>답변여부</th>
						<td>
							<select name="coment" onchange="coment_gubun(this.value)">
								<option value="">전체</option>
								<option value="1" <?=($this->input->get("coment") == 1)?"selected":"";?>>답변미완료</option>
								<option value="2" <?=($this->input->get("coment") == 2)?"selected":"";?>>답변완료</option>
							</select>
						</td>
					</tr> -->

				<form name="bbs_search_form" method="get" >
				<input type="hidden" name="coment" value="<?=$this->input->get("coment")?>">
					<tr>
						<th>검색</th>
						<td>
							<select name="search_item" id="search-scope">
								<option value="all">전체</option>
								<option value="subject" <?if($this->input->get("search_item")=="subject"){?>selected<?}?>>제목</option>
								<option value="name" <?if($this->input->get("search_item")=="name"){?>selected<?}?>>작성자</option>
								<!-- <option value="content" <?if($this->input->get("search_item")=="content"){?>selected<?}?>>내용</option> -->
							</select>
							<input type="text" name="search_order" value="<?=$this->input->get("search_order")?>"/>
							<input type="button" value="검색" class="btn-ok" onclick="javascript:search();">
						</td>
					</tr>
				</table><!-- END 제품검색 -->
				</form>

				<div class="float-wrap mt50">
				</div>

				<table class="adm-table line align-c">
					<caption>게시판 관리</caption>
					<colgroup>
						<col style="width:7%"><col style="width:5%"><col style=""><? if($bbs->bbs_pds){ ?><col style="width:10%;"><?}?><? if($bbs->code == "withcons07"){ ?><col style="width:10%;"><?}?><? if($bbs->code == "qrbbs"){ ?><col style="width:10%;"><?}?><col style="width:10%;"><col style="width:10%;">
					</colgroup>
					<thead>
					<thead>
						<tr>
							<th><input type="checkbox" name="all_chk" id="all_chk" class="all_chk"></th>
							<th>No</th>
							<th>제목</th>
							<? if($bbs->bbs_pds){ ?>
							<th>첨부</th>
							<?}?>
							<?php
							if($bbs->code == "withcons07"){
							?>
							<th>답변여부</th>
							<?php
							}
							?>

							<?php
							if($bbs->code == "qrbbs"){
								?>
								<th>바로가기</th>
								<?php
							}
							?>
							<th>작성자</th>
							<th>날짜</th>
						</tr>
					</thead>
					<tbody class="ft092">

			<? foreach ($notice_list as $nl){ ?>
				<tr>
					<td colspan="2"><img src="/_data/image/board_img/notice.gif" alt="Notice" /> </td>
					<td class="title">
						<?php
						if($nl->code == "withcons01"){
							if($nl->tag == 1){
								?>
								<input type="button" value="숨김중" class="btn-sm btn-alert" onclick="bbs_show('<?=$nl->idx?>')">
								<?php
							}
							else{
								?>
								<input type="button" value="노출중" class="btn-sm" onclick="bbs_hide('<?=$nl->idx?>')">
								<?php
							}
						}
						?>
					<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$this->uri->segment(3)?>/m/view/<?=$nl->idx?>/<?=$query_string?>"><strong><?=$nl->subject?></strong></a></td>
					<? if($bbs->bbs_pds){ //첨부파일?>
					<td>
						<? if($nl->bbs_file != "none" && $nl->bbs_file != ""){
							echo '<img src="/_dhadm/image/board_img/file_icon.png" alt="">';
						}?>
					</td>
					<?}?>
					<?php
					if($bbs->code == "withcons07"){
					?>
					<td>
						-
					</td>
					<?php
					}
					?>
					<td><?=$nl->name?></td>
					<td><?=substr($nl->reg_date,0,10)?></td>
				</tr>
			<? } ?>

			<form name="order_form" method="post" >
			<?
				$list_cnt=0;
				foreach ($list as $lt){
					$list_cnt++;
			?>
				<tr class="<? if($lt->re_level > 0){?>reply<?}?> <?if($lt->code == "withcons07"){?>qnabbs<?}?>">
					<td><input type="checkbox" id="chkNum" name="chk<?=$list_cnt?>" value="<?=$lt->idx?>" class="chkNum"></td>
					<td><?=$listNo?></td>
					<td class="title">
						<?php
						if($lt->code == "withcons01"){
							if($lt->tag == 1){
								?>
								<input type="button" value="숨김중" class="btn-sm btn-alert" onclick="bbs_show('<?=$lt->idx?>')">
								<?php
							}
							else{
								?>
								<input type="button" value="노출중" class="btn-sm" onclick="bbs_hide('<?=$lt->idx?>')">
								<?php
							}
						}
						?>
						<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$this->uri->segment(3)?>/m/<?=($lt->code == "wc04")?"edit":"view";?>/<?=$lt->idx?>/<?=$query_string.$param?>"><?=$lt->subject?></a>
						<? if($lt->coment_cnt) {?><span class="cmt-cnt">[<?=$lt->coment_cnt;?>]</span><?}?>
						<? if($lt->secret=="y"){ ?> <img src="/_data/image/board_img/icon_lock.gif" align="middle"><? } ?>
					</td>
					<? if($bbs->bbs_pds){ //첨부파일 ?>
					<td>
					<?
						if($lt->bbs_file != "none" && $lt->bbs_file != ""){
							echo '<img src="/_dhadm/image/board_img/file_icon.png" alt="">';
						}
					?>
					</td>
					<?}?>
					<?php
					if($bbs->code == "withcons07"){
					?>
					<td>
						<?php
						if($lt->coment_cnt > 0){
						?>
						<span style="color:blue;font-weight:600;">답변완료</span>
						<?php
						}
						else{
						?>
						<span style="color:red;font-weight:600;">답변미완료</span>
						<?php
						}
						?>
					</td>
					<?php
					}
					?>

					<?php
					if($bbs->code == "qrbbs"){
						?>
						<td>
							<input type="button" class="btn-sm btn-cancel" value="PC" onclick="window.open('/html/dh_board/views/<?=$lt->idx?>','','')">
							<input type="button" class="btn-sm btn-alert" value="모바일" onclick="window.open('/m/html/dh_board/views/<?=$lt->idx?>','','')">
						</td>
						<?php
					}
					?>

					<td style="position: relative;">
						<a href="javascript:show_layer('<?=$lt->idx?>');"><?=$lt->name?></a>
						<div class="layer_t layer_t<?=$lt->idx?>" style="display: none;background: #000;border: 1px solid #ddd;border-bottom: 0;position: absolute;top: 35px;left: 50px;z-index:999">
							<!-- <a href="#" style="border-bottom: 1px solid #ddd;display: block;padding: 5px 10px;text-align: center;">아이디로 검색</a> -->
							<a href="javascript:window.open('/html/member/user/m/edit/<?=$lt->member_idx?>/','','')" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">회원정보변경</a>
							<a href="javascript:window.open('/html/member/user/m/order/<?=$lt->member_idx?>/','','')" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">구매내역보기</a>
							<a href="javascript:window.open('/html/member/user/m/point/<?=$lt->member_idx?>/','','')" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">포인트내역</a>
							<a href="javascript:window.open('/html/member/coupon/<?=$lt->member_idx?>/?ajax=1','coupon_set','width=715, height=615');" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">쿠폰보내기</a>
						</div>
					</td>
					<td><?=$lt->reg_date?></td>
				</tr>
			<?
				$listNo--;
				}
			?>
				<input type="hidden" name="form_cnt" id="form_cnt" value="<?=$list_cnt?>">
				</form>
			</tbody>
			</table>


				<!-- 제품 액션 버튼 -->
				<div class="float-wrap mt20">
					<div class="float-l">
					<span class="btn-inline btn-tinted-02"><a href="javascript:all_del();">삭제</a></span>
					<span class="btn-inline btn-tinted-03" <? if($bbs->bbs_cate=='Y' && !$this->input->get("cate_idx")){?>style="display:none;"<?}?> ><a href='javascript:openWinPopup("<?=cdir()?>/board/bbs_sort/?ajax=1&code=<?=$bbs->code?>&cate_idx=<?=$this->input->get("cate_idx")?>","",340,400);'>순서변경</a></span>
					</div>
					<div class="float-r">
					<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$this->uri->segment(3)?>/m//write/<?=$send?>" class="button btn-ok">글쓰기</a></span>
					</div>
				</div>


					<? if($total_cnt > 0){ ?>
					<!-- Pager -->
					<p class="list-pager align-c" title="페이지 이동하기">
						<?=$Page2?>
					</p><!-- END Pager -->
					<?}?>