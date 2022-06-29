<? if($this->session->userdata('USERID')){ $USERID = $this->session->userdata('USERID'); }else{ $USERID = ""; } ?>


			<!-- Board wrap -->
			<div class="board-wrap">
				<!-- board view -->
				<div class="board-view">

					<p class="board-view-tit"><?=$row->subject?></p>
					<p class="board-view-info"><?=$row->name?> <span>|</span> <?=substr($row->reg_date,0,10)?>
						<?php
						if($row->code != "withcons07"){
							?>
							<span>|</span> 조회 <?=$row->read_cnt?>
							<?php
						}
						?>
					</p>

					<div class="board-view-ct">
						<?=$row->content?>

						<? if($bbs->bbs_pds){ ?>
						<!-- 첨부 -->
						<ul class="board-view-file">
							<? if($row->bbs_file!="none" && $row->bbs_file!=""){ ?><li><a href="<?=cdir()?>/dh/file_down/bbs/?idx=<?=$row->idx?>&file_down=1"><?=$row->real_file?></a></li><?}?>
							<? if($row->bbs_file2!="none" && $row->bbs_file2!=""){ ?><li><a href="<?=cdir()?>/dh/file_down/bbs/?idx=<?=$row->idx?>&file_down=2"><?=$row->real_file2?></a></li><?}?>
						</ul><!-- END 첨부 -->
						<?}?>
					</div>
					<? if(isset($goods_row->idx)){?>

					<!-- 리뷰 게시판일 경우 -->
					<div class="board-view-prod">
						<a href="<?=cdir()?>/dh_product/prod_view/<?=$row->goods_idx?>?cate_no=<?=$goods_row->cate_no?>">
							<div class="rv-prod-img"><img src="/_data/file/goodsImages/<?=$goods_row->list_img?>" alt="@<?=$goods_row->name?> 의 썸네일" width="70" height="70"></div>
							<div class="rv-prod-info">
								<p class="rv-prod-name"><?=$goods_row->name?></p>
								<p class="rv-prod-price">
									<?if($goods_row->old_price){?>
										<ins><?=number_format($goods_row->shop_price)?>원</ins> <del><?=number_format($goods_row->old_price)?>원</del>
									<?}else{?>
										<?=number_format($goods_row->shop_price)?>원
									<?}?>
								</p>
							</div>
						</a>
					</div>
					<!-- END 리뷰 게시판일 경우 -->

					<?}?>

					<!-- Buttons -->
					<div class="board-view-btns board-inner">
						<? if($bbs->bbs_write!=9) {?>
							<div class="float-r">
								<?
								if($coment_cnt >= 1){
									$del_url = "alert('답변이 작성된 글은 삭제 및 수정을 할 수 없습니다.')";
									$edit_url = "alert('답변이 작성된 글은 삭제 및 수정을 할 수 없습니다.')";
								}
								else{
									if($USERID != "" && $USERID == $row->userid){ //작성자와 로그인아이디가 같을때
										$edit_url = "location.href='".cdir()."/".$this->uri->segment(1)."/edit/".$row->idx.$query_string.$param."'";
										$del_url = "document.del_form.del_idx.value='".$row->idx."';document.del_form.mode.value='bbs';document.del_form.submit();";
									}else{ //비밀번호 입력폼
										$edit_url = "location.href='".cdir()."/".$this->uri->segment(1)."/passwd/bbs_edit/".$row->idx.$query_string.$param."'";
										$del_url = "location.href='".cdir()."/".$this->uri->segment(1)."/passwd/bbs_del/".$row->idx.$query_string.$param."'";
									}
								}
								?>
								<button type="button" class="plain" onclick="javascript:<?=$del_url?>;"><img src="/m/image/board_img/icon_del.png" alt="삭제" width="24" height="24"></button>
								<button type="button" class="plain" onclick="javascript:<?=$edit_url?>;"><img src="/m/image/board_img/icon_modify.png" alt="수정" width="24" height="24"></button>
							</div>
							<? if($bbs->bbs_type==1){ ?>
							<div class="float-l">
								<!-- <button type="button" class="plain" onclick="location.href='<?=cdir()?>/<?=$this->uri->segment(1)?>/write/<?=$row->code?>/<?=$row->idx?>';"><img src="/m/image/board_img/icon_reply.png" alt="답변" width="24" height="24"></button> -->
								<!-- <button type="button" class="plain"><img src="/m/image/board_img/icon_share.png" alt="공유" width="24" height="24"></button> -->
							</div>
							<?}?>
						<?}?>
					</div><!-- END Buttons -->

				<? if($bbs->bbs_coment == 1){ ?>

					<!-- Comment View -->
					<div class="comment-wrap">
						<p class="cmt-tit">답변 <span>(<?=$coment_cnt?>)</span></p>

						<!-- <p class="no-ct">작성된 댓글이 없습니다. <br>제일 먼저 댓글을 작성해 보세요!</p> -->

						<!-- 댓글 리스트 -->
						<ul class="comment-view">
						<? foreach ($coment as $list){ ?>
							<li class="my-cmt">
								<div class="cmt-item">
									<p class="cmt-name"><?=$list->name?></p>
									<p class="cmt-content"><?=nl2br($list->coment)?></p>

										<ul class="img_list_de">
											<?php
											if($list->upfile1){
												?>
												<li><img src="/_data/file/comment/<?=$list->upfile1?>" alt=""></li>
												<?php
											}

											if($list->upfile2){
												?>
												<li><img src="/_data/file/comment/<?=$list->upfile2?>" alt=""></li>
												<?php
											}

											if($list->upfile3){
												?>
												<li><img src="/_data/file/comment/<?=$list->upfile3?>" alt=""></li>
												<?php
											}
											?>
										</ul>

										<!-- 모달창 -->
										<div class="eco_layer__dim"></div>
										<div class="eco_product__layer">
											<div class="img__box"></div>
											<div class="layer__close">
												<img src="/image/sub/layer_close.png" alt="">
											</div>
										</div>
										<!-- 모달창 끝 -->

										<script>

											$(function () {
												var imgSlide = $('.eco_product__layer .layer__slide');
												var imgBtn = $('.img_list_de img');
												var layerReview = $('.eco_layer__dim, .eco_product__layer');
												var layerClose = $('.eco_layer__dim, .eco_product__layer .layer__close');

												imgBtn.on('click', function(){
													var src = $(this).attr('src')
													var alt = $(this).attr('alt')
													$('.img__box').prepend(`<img src="${src}" alt="${alt}" class="modal_img">`);

													layerReview.show().stop()
													.animate({
														opacity:1
													}, 300)

												})

												layerClose.on('click', function(){
													$('.modal_img').remove()
													$('.eco_layer__dim, .eco_product__layer').stop()
													.animate({
														opacity:0
													}, 300, function(){
														$(this).hide();
														imgSlide.slick('unslick')
													})
												})

											})

										</script>

									<p class="cmt-date"><?=$list->reg_date?></p>
									<div class="cmt-options">
										<? if($USERID != "" && $USERID == $list->userid){ //작성자와 로그인아이디가 같을때?>
										<button type="button" onclick="javascript:document.del_form.del_idx.value='<?=$list->idx?>';document.del_form.mode.value='bbs_coment';document.del_form.submit();">삭제</button>
										<?}else{?>
										<!-- <button type="button" onclick="javascript:location.href='<?=cdir()?>/<?=$this->uri->segment(1)?>/passwd/bbs_coment_del/<?=$row->idx?>/<?=$list->idx.$query_string.$param?>';">삭제</button> -->
										<?}?>
									</div>
								</div>
							</li>
							<?}?>
						</ul><!-- END 댓글 리스트 -->

						<?php
						/*
						<!-- 댓글 쓰기 -->
						<form name="bbs_coment_form" method="post">
						<input type="hidden" name="code" value="<?=$row->code?>">
						<input type="hidden" name="userid" value="<? echo isset($USERID) ? $USERID : "";?>">
						<div class="comment-write">
							<div class="cmt-writer-info">
								<span class="cmt-writer"><label for="cmt-writer">작성자</label><input type="text" id="cmt-writer" name="name" value="<? echo (@$this->session->userdata('NAME')) ? @$this->session->userdata('NAME') : "";?>"></span>
								<span class="cmt-pw"><label for="cmt-pw">비밀번호</label><input type="password" id="cmt-pw" name="pwd"></span>
							</div>
							<div class="cmt-field">
								<textarea name="coment" id="cmt-cont" cols="30" rows="3" <? if( $bbs->bbs_write == 1 && !$this->session->userdata('USERID') ) {?>placeholder="로그인 후 댓글을 작성해 주세요." readonly<?}?>></textarea>
								<p class="cmt-field-btn">
									<input type="button" class="btn-border-s" value="등록" onclick="<? if( $bbs->bbs_write == 1 && !$this->session->userdata('USERID') ) {?>alert('로그인 후 댓글을 작성해주세요.');location.href='<?=cdir()?>/dh_member/login/?go_url=<?=cdir()?>/<?=$this->uri->segment(1)?>/views/<?=$row->idx?><?=$query_string.$param?>';<?}else{?>bbs_coment()<?}?>">
								</p>
							</div>
						</div><!-- END 댓글 쓰기 -->
						</form>
						*/
						?>

					</div><!-- END Comment View -->

					<?}?>

					<?php
					if($bbs->code != "qrbbs"){
						?>
					<!-- 이전/다음 컨텐츠 -->
					<div class="board-view-nav board-inner">
						<div class="float-r">
						<?
						if(isset($preRow->idx)){
							if($preRow->secret && $preRow->secret=="y"){ //비밀글일때
								if($this->session->userdata('USERID') && $this->session->userdata('USERID') == $preRow->userid){ //본인이 쓴글일때
									$pre_url = cdir()."/".$this->uri->segment(1)."/views/".$preRow->idx;
								}else{
									$pre_url = cdir()."/".$this->uri->segment(1)."/passwd/bbs_view/".$preRow->idx;
								}
							}else{
								$pre_url = cdir()."/".$this->uri->segment(1)."/views/".$preRow->idx;
							}
							?>
							<a href="<?=$pre_url?>" class="mr10"><img src="/m/image/board_img/icon_prev.png" alt="이전글" width="20" height="20"></a>
						<?}?>


						<?
						if(isset($nextRow->subject)){
							if($nextRow->secret && $nextRow->secret=="y"){//비밀글일때
								if($this->session->userdata('USERID') && $this->session->userdata('USERID') == $nextRow->userid){//본인이 쓴글일때
									$next_url = cdir()."/".$this->uri->segment(1)."/views/".$nextRow->idx;
								}else{
									$next_url = cdir()."/".$this->uri->segment(1)."/passwd/bbs_view/".$nextRow->idx;
								}
							}else{
									$next_url = cdir()."/".$this->uri->segment(1)."/views/".$nextRow->idx;
							}
						?>
							<a href="<?=$next_url?>"><img src="/m/image/board_img/icon_next.png" alt="다음글" width="20" height="20"></a>
						<?}?>
						</div>
						<div class="float-l">
							<a href="<?=cdir()?>/<?=$this->uri->segment(1)?>/lists/<?=$row->code?>/<?=$page?><?=$query_string.$param?>"><img src="/m/image/board_img/icon_list.png" alt="목록" width="20" height="20"></a>
						</div>
					</div>
					<!-- END 이전/다음 컨텐츠 -->
						<?php
					}
					?>

				</div><!-- END board view -->


		<form name="del_form" method="post">
			<input type="hidden" name="mode">
			<input type="hidden" name="del_idx">
		</form>
