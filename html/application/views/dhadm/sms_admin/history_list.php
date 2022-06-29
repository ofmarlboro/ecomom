<h3 class="icon-search">검색</h3>
	<!-- 제품검색 -->
	<form name="bbs_search_form" method="get" >
		<table class="adm-table">
			<caption>검색</caption>
			<colgroup>
				<col style="width:15%;"><col>
			</colgroup>
			<tbody>
				<tr>
					<th>검색</th>
					<td>
						<select name="search_item" id="search-scope" style="display:none;">
							<option value="all">전체</option>
							<!-- <option value="subject" <?if($this->input->get("search_item")=="subject"){?>selected<?}?>>제목</option>
							<option value="content" <?if($this->input->get("search_item")=="content"){?>selected<?}?>>내용</option> -->
						</select>
						<input type="text" name="search_order" value="<?=$this->input->get("search_order")?>"/>
						<input type="button" value="검색" class="btn-ok" onclick="javascript:search();">
					</td>
				</tr>
			</tbody>
		</table><!-- END 제품검색 -->
	</form>

	<div class="float-wrap mt50">
	</div>

	<div class="s_inner">
		<div class="board-wrap">

			<!-- 일반 게시판 리스트 -->
			<table  class="adm-table line align-c">
					<thead>
						<tr>
							<th scope="col">번호</th>
							<th scope="col">메세지</th>
							<th scope="col">회신번호</th>
							<th scope="col">전송일시</th>
							<th scope="col">총건수</th>
							<th scope="col">성공</th>
							<th scope="col">실패</th>
							<th scope="col">관리</th>
					 </tr>
					</thead>
					<tbody>
					<?php
					?>
						<?
							if($list){
								$line=0;
								foreach($list as $lt){
									$bg = 'bg'.($line++%2);
									$tmp_wr_memo = @unserialize($lt->wr_memo);
									$dupli_count = $tmp_wr_memo['total'] ? $tmp_wr_memo['total'] : 0;
									?>
									<tr class="<?php echo $bg; ?>">
											<td class="td_numsmall"><?=$listNo?></td>
											<td><span title="<?=$lt->wr_message?>"><?=$lt->wr_message?></span></td>
											<td class="td_numbig"><?=$lt->wr_reply?></td>
											<td class="td_datetime"><?= date('Y-m-d H:i', strtotime($lt->wr_datetime))?></td>
											<td class="td_num"><?= number_format($lt->wr_total)?></td>
											<td class="td_num"><?= number_format($lt->wr_success)?></td>
											<td class="td_num"><?= number_format($lt->wr_failure)?></td>
											<td class="td_mngsmall">
													<button type="button" class="btn-sm btn-alert" onclick="location.href='<?=cdir()?>/<?=$this->uri->segment(1)?>/<?=$this->uri->segment(2)?>/<?=$this->uri->segment(3)?>/m/history_view?wr_no=<?=$lt->wr_no?>'">보기</button>
													<!-- <a href="./history_del.php?page=<?php echo $page;?>&amp;st=<?php echo $st;?>&amp;sv=<?php echo $sv;?>&amp;wr_no=<?php echo $res['wr_no'];?>">삭제</a> -->
											</td>
									</tr>
									<?php
									$listNo--;
								}
							}
							?>
					</tbody>
			</table>
			<!-- END 일반 게시판 리스트 -->
		</div>
		<br>
		<? if($total_cnt > 0){ ?>
		<!-- Pager -->
		<p class="list-pager align-c" title="페이지 이동하기">
			<?=$Page2?>
		</p><!-- END Pager -->
		<?}?>
	</div>