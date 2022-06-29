<?php
$upfile_path = $_SERVER['DOCUMENT_ROOT'].'/_data/file/comment/';
?>
	<style type="text/css">
		.img_list_de {
				display: flex;
				margin-top: 10px;
				margin-bottom: 10px;
		}
		.img_list_de li:not(:last-child) {
				margin-right: 15px;
		}

		.img_list_de li {
				cursor: pointer;
				width: 100px;
				height: 0;
				overflow: hidden;
				position: relative;
				padding-top: 100px;
		}

		.img_list_de li img {
				width: 100%;
				position: absolute;
				top: 50%;
				left: 50%;
				transform: translate(-50%, -50%);
		}
	</style>
	<script>
		$(function(){
			$(".layer_t_open").on("click",function(){
				$(this).next(".layer_t").slideToggle();
			});
		});

		//		$(document).click(function(e){
		//			if(e.target.className == "layer_t"){return false}
		//			$(".layer_t").hide();
		//		});
	</script>

	<!-- Board Wrap-->
	<div class="board-wrap">
		<!-- Board View : With Comment -->
		<table class="board-view">
			<caption>게시글의 내용을 보여주는 테이블</caption>
			<colgroup>
				<col style="width:15%;"/>
				<col style=""/>
				<col style="width:10%;"/>
				<col style="width:15%;"/>
				<col style="width:10%;"/>
				<col style="width:15%;"/>
			</colgroup>
			<tbody>
				<?if($bbs->bbs_type==7){?>
				<tr>
					<th>구매제품</th>
					<td colspan="3"><img src="/_data/file/goodsImages/<?=$goods_row->list_img?>" width="60" height="60" class="mr10"><?=$goods_row->name?></td>
					<th>별점</th>
					<td><?=$row->grade?>/5</td>
				</tr>
				<?}?>
				<tr>
					<th>제목</th>
					<td colspan="5"><?=$row->subject?></td>
				</tr>
				<?if($bbs->bbs_type==5){?>
				<tr>
					<th>이벤트 기간</th>
					<td colspan="5"><?=$row->start_date?> ~ <?=$row->end_date?></td>
				</tr>
				<?}?>
				<tr>
					<th>작성자</th>
					<!-- <td><a class="layer_t_open" href="<?=cdir()?>/member/user/m/order/<?=$member_info->idx?>/?outmode=0&order=" target="_blank"><?=$row->name?></a> -->
					<td style="position: relative;">
						<a class="layer_t_open" href="#"><?=$row->name?></a>
						<div class="layer_t" style="display: none;background: #000;border: 1px solid #ddd;border-bottom: 0;position: absolute;top:43px;left: 0;">
							<!-- <a href="#" style="border-bottom: 1px solid #ddd;display: block;padding: 5px 10px;text-align: center;">아이디로 검색</a> -->
							<a href="javascript:window.open('/html/member/user/m/edit/<?=$member_info->idx?>/','','')" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">회원정보변경</a>
							<a href="javascript:window.open('/html/member/user/m/order/<?=$member_info->idx?>/','','')" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">구매내역보기</a>
							<a href="javascript:window.open('/html/member/user/m/point/<?=$member_info->idx?>/','','')" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">포인트내역</a>
							<a href="javascript:window.open('/html/member/coupon/<?=$member_info->idx?>/?ajax=1','coupon_set','width=715, height=615');" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">쿠폰보내기</a>
						</div>
					</td>

					<th>등록일</th>
					<td><?=$row->reg_date?></td>

					<th>조회수</th>
					<td><?=$row->read_cnt?></td>
				</tr>
				<tr>
					<td colspan="6">
						<div class="board-content">

							<? if($bbs->bbs_type=='6'){ ?>
								<? if($row->dong_src!="" && $row->dong_flag=='dong_src'){?>
									<iframe width="80%" height="300px;" src="https://www.youtube.com/embed/<?=$row->dong_src?>" frameborder="0" allowfullscreen></iframe>
								<?}?>
								<? if($row->dong_sorce!="" && $row->dong_flag=='dong_sorce'){
								$row->dong_sorce = str_replace("&lt;","<",$row->dong_sorce);
								$row->dong_sorce = str_replace("&gt;",">",$row->dong_sorce);
								?>
									<?=$row->dong_sorce?>
								<?}?>
								<br><br>
							<?}?>

							<?=stripslashes($row->content)?>
						</div>
					</td>
				</tr>
				<? if($row->bbs_file!="none" && $row->bbs_file!=""){ ?>
				<tr>
					<th>첨부파일</th>
					<td colspan="5"><a href="/html/dh/file_down/bbs/?idx=<?=$row->idx?>&file_down=1"><?=$row->real_file?></a><!--/<a href="#">filename.doc</a--></td>
				</tr>
				<?}?>
			</tbody>
		</table><!-- END Board View -->

		<? if($bbs->bbs_coment == 1){ ?>
		<!-- Comment -->
		<ul class="comment-view">
		<? foreach ($coment as $list){ ?>
			<li>
				<?php
				if($this->session->userdata('ADMIN_LEVEL') < 3){
					?>
					<p class="name w100"><?=$list->admin_name?> (<?=$list->userid?>)</p>
					<?php
				}
				else{
					?>
					<p class="name w100"><?=$list->name?></p>
					<?php
				}
				?>
				<div class="cmt w100 pt5 pb5">
					<p><?=nl2br($list->coment)?></p>
					<ul class="img_list_de">
						<?php
						if($list->upfile1){
							$img_size = getimagesize($upfile_path.$list->upfile1);
							?>
							<li><img src="/_data/file/comment/<?=$list->upfile1?>" style="cursor:pointer" onclick="window.open('/_data/file/comment/<?=$list->upfile1?>','','width=<?=$img_size[0]?>,height=<?=$img_size[1]?>')"></li>
							<?php
						}

						if($list->upfile2){
							$img_size = getimagesize($upfile_path.$list->upfile2);
							?>
							<li><img src="/_data/file/comment/<?=$list->upfile2?>" style="cursor:pointer" onclick="window.open('/_data/file/comment/<?=$list->upfile2?>','','width=<?=$img_size[0]?>,height=<?=$img_size[1]?>')"></li>
							<?php
						}

						if($list->upfile3){
							$img_size = getimagesize($upfile_path.$list->upfile3);
							?>
							<li><img src="/_data/file/comment/<?=$list->upfile3?>" style="cursor:pointer" onclick="window.open('/_data/file/comment/<?=$list->upfile3?>','','width=<?=$img_size[0]?>,height=<?=$img_size[1]?>')"></li>
							<?php
						}
						?>
					</ul>
				</div>
				<p class="date w50"><?=$list->reg_date?></p>
				<p class="edit w50 align-r">
					<a href="javascript:coment_update('<?=$list->idx?>');">수정</a>
					<a href="javascript:bbs_del(<?=$list->idx?>,'bbs_coment')">삭제</a>
				</p>
			</li>
			<li class="update_form<?=$list->idx?> coment_update_li" style="display:none;">
				<form name="coment_update_form<?=$list->idx?>" id="coment_update_form<?=$list->idx?>" method="post" enctype="multipart/form-data">
				<input type="hidden" name="mode" value="coment_update">
				<input type="hidden" name="coment_idx" value="<?=$list->idx?>">
					<ul class="comment-write">
						<li class="w90">
							<textarea name="coment<?=$list->idx?>" id="comment<?=$list->idx?>" style="height:200px;"><?=$list->coment?></textarea>
							<p class="w90 mt10">
								<input type="file" name="upfile1">
								<?php
								if($list->upfile1){
									echo $list->upfile1_real;
									?>
									<input type="checkbox" name="upfile1_del" value="Y" id="upfile1_del"><label for="upfile1_del">삭제</label>
									<?php
								}
								?>
							</p>
							<p class="w90 mt10"><input type="file" name="upfile2">
								<?php
								if($list->upfile2){
									echo $list->upfile2_real;
									?>
									<input type="checkbox" name="upfile2_del" value="Y" id="upfile2_del"><label for="upfile2_del">삭제</label>
									<?php
								}
								?>
							</p>
							<p class="w90 mt10"><input type="file" name="upfile3">
								<?php
								if($list->upfile3){
									echo $list->upfile3_real;
									?>
									<input type="checkbox" name="upfile3_del" value="Y" id="upfile3_del"><label for="upfile3_del">삭제</label>
									<?php
								}
								?>
							</p>
						</li>
						<li class="submit w10">
							<a href="javascript:bbs_coment_update('<?=$list->idx?>');"><?=($bbs->code=="withcons07")?"답변":"";?>수정</a>
						</li>
					</ul><!-- END Write comment -->
				</form>
			</li>
		<?
			}
		?>
		</ul>
		<!-- END Comment -->


<?php
//if($_SERVER['HTTP_X_FORWARDED_FOR'] == '58.229.223.174'){
	?>
		<!-- Write comment -->
		<form name="bbs_coment_form" method="post" enctype="multipart/form-data">
			<input type="hidden" name="code" value="<?=$row->code?>">
			<input type="hidden" name="userid" value="<? echo (@$this->session->userdata('ADMIN_USERID')) ? @$this->session->userdata('ADMIN_USERID') : "";?>">
			<input type="hidden" name="pwd" value="<? echo (@$this->session->userdata('ADMIN_PASSWD')) ? @$this->session->userdata('ADMIN_PASSWD') : "";?>"/>

			<ul class="comment-write coment_form">
				<li class="name w25">
					<p class="mb5"><label for="cmt-name" class="w40">이름</label>
						<span class="w60"><input type="text" id="cmt-name" name="name" value="관리자"/></span>
					</p>
					<p><label for="cmt-pw" class="w40">비밀번호</label>
						<span class="w60">********</span>
					</p>
				</li>
				<li class="w65">
					<div id="none_editor">
						<textarea name="coment" id="coment" style="height:200px;"></textarea>
						<p class="mt10"><input type="file" name="upfile1"></p>
						<p class="mt10"><input type="file" name="upfile2"></p>
						<p class="mt10"><input type="file" name="upfile3"></p>
					</div>
				</li>
				<li class="submit w10">
					<a href="javascript: bbs_coment_send();"><?=($bbs->code=="withcons07")?"답변":"";?>등록</a>
				</li>
			</ul><!-- END Write comment -->
		</form>
	<?php
	/*
}
else{
	?>
		<!-- Write comment -->
		<form name="bbs_coment_form" method="post" enctype="multipart/form-data">
			<input type="hidden" name="code" value="<?=$row->code?>">
			<input type="hidden" name="userid" value="<? echo (@$this->session->userdata('ADMIN_USERID')) ? @$this->session->userdata('ADMIN_USERID') : "";?>">
			<input type="hidden" name="pwd" value="<? echo (@$this->session->userdata('ADMIN_PASSWD')) ? @$this->session->userdata('ADMIN_PASSWD') : "";?>"/>

			<ul class="comment-write coment_form">
				<li class="name w25">
					<p class="mb5"><label for="cmt-name" class="w40">이름</label>
						<span class="w60"><input type="text" id="cmt-name" name="name" value="관리자"/></span>
					</p>
					<p><label for="cmt-pw" class="w40">비밀번호</label>
						<span class="w60">********</span>
					</p>
				</li>
				<li class="w65">
					<div id="none_editor">
						<textarea name="coment" id="coment" cols="30" rows="10" style="height:300px;"></textarea>
					</div>
				</li>
				<li class="submit w10">
					<a href="javascript: bbs_coment_send();"><?=($bbs->code=="withcons07")?"답변":"";?>등록</a>
				</li>
			</ul><!-- END Write comment -->
		</form>
	<?php
}
*/
?>



		<?}?>

		<!-- Button -->
		<div class="float-wrap mt20">
			<p class="float-l btn-inline btn-tinted-01"><a href="<?=cdir()?>/board/bbs/<?=$row->code?>/m/<?=$query_string.$param?>">목록</a></p>
			<p class="float-r">
				<? if($bbs->bbs_type==1){ ?>
				<!-- <span class="btn-inline btn-tinted-01"><a href="<?=cdir()?>/board/bbs/<?=$row->code?>/m/write/<?=$row->idx?>/<?=$query_string.$param?>">답변달기</a></span> -->
				<? } ?>

				<span class="btn-inline btn-tinted-01"><a href="<?=cdir()?>/board/bbs/<?=$row->code?>/m/edit/<?=$row->idx?>/<?=$query_string.$param?>">수정하기</a></span>
				<span class="btn-inline btn-tinted-02"><a href="javascript:bbs_del(<?=$row->idx?>,'bbs')">삭제하기</a></span>

			</p>
		</div>
		<!-- END Button -->


		<!-- Prev/Next -->
		<table class="board-nav mt30">
			<caption>이전글과 다음글의 링크</caption>
			<colgroup>
				<col style="width:15%;" />
				<col style="" />
			</colgroup>
			<tbody>
				<tr>
					<th>이전글</th>
					<td>
						<?echo isset($preRow->subject) ? "<a href='/html/board/bbs/".$row->code."/m/view/".$preRow->idx."/'>".$preRow->subject."</a>" : "" ?></a>
					</td>
				</tr>
				<tr>
					<th>다음글</th>
					<td>
						<?echo isset($nextRow->subject) ? "<a href='/html/board/bbs/".$row->code."/m/view/".$nextRow->idx."/'>".$nextRow->subject."</a>" : "" ?></a>
					</td>
				</tr>
			</tbody>
		</table><!-- ENDPrev/Next -->
	</div><!-- END Board Wrap -->


		<form name="del_form" method="post">
			<input type="hidden" name="mode">
			<input type="hidden" name="del_idx">
		</form>


<script type="text/javascript">
	function coment_update(idx){
		$(".coment_update_li").hide();
		$(".coment_form").hide();
		$(".update_form"+idx).show();
	}

	function bbs_coment_update(idx){
		$("#coment_update_form"+idx).submit();
	}

	function bbs_coment_send(){
		var form = document.bbs_coment_form;
		if(form.name.value=="")	{
			alert("이름을 입력해주세요.");
			form.name.focus();
			return;
		}else if(form.pwd.value=="")	{
			alert("비밀번호를 입력해주세요.");
			form.pwd.focus();
			return;
		}

		form.submit();
		return;
	}
</script>