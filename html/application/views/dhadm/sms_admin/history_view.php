	<h3 class="icon-search">검색</h3>
	<!-- 제품검색 -->
	<form name="bbs_search_form" method="get" >
		<input type="hidden" name="wr_no" value=<?=$this->input->get('wr_no')?>>
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
							<option value="all_view">전체</option>
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
			<table class="adm-table line align-c">
					<thead>
						<tr>
								<th scope="col">번호</th>
								<th scope="col">이름</th>
								<th scope="col">회원ID</th>
								<th scope="col">휴대폰번호</th>
								<th scope="col">전송일시</th>
								<th scope="col">결과</th>
								<th scope="col">비고</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if($list){
							foreach($list as $lt){
								?>
								<tr>
										<td class="td_numsmall"><?=$listNo?></td>
										<td class="td_mbname"><?=$lt->hs_name?></a></td>
										<td class="td_mbid"><?=$lt->mb_id?></td>
										<td class="td_numbig"><?=$lt->hs_hp?></td>
										<td class="td_datetime"><?=$lt->hs_datetime?></td>
										<td class="td_boolean"><?=$lt->hs_flag?'성공':'실패'?></td>
										<td>
												<u>결과코드</u> : <?=$lt->hs_code?><br>
												<!-- <u>로그</u> : <?=$lt->hs_log?><br> -->
												<u>메모</u> : <?=$lt->hs_memo?>
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

		<!-- 제품 액션 버튼 -->
		<div class="float-wrap mt20">
			<div class="float-l">
			</div>
			<div class="float-r">
				<button type="button" onclick="history.go(-1)" class="btn-ok">돌아가기</button>
			</div>
		</div>
		<!-- END 제품 액션 버튼 -->

		<? if($total_cnt > 0){ ?>
		<!-- Pager -->
		<p class="list-pager align-c" title="페이지 이동하기">
			<?=$Page2?>
		</p><!-- END Pager -->
		<?}?>
	</div>

<script>
function re_send()
{
    <?php if (!$write['wr_failure']) { ?>
    alert('실패한 전송이 없습니다.');
    <?php } else { ?>
    if (!confirm('전송에 실패한 SMS 를 재전송 하시겠습니까?'))
        return;

    act = window.open('sms_ing.php', 'act', 'width=300, height=200');
    act.focus();

    location.href = './history_send.php?w=f&page=<?php echo $page?>&st=<?php echo  $st?>&sv=<?php echo $sv?>&wr_no=<?php echo $wr_no?>&wr_renum=<?php echo $wr_renum?>';
    <?php } ?>
}
function all_send()
{
    if (!confirm('전체 SMS 를 재전송 하시겠습니까?\n\n예약전송일 경우 예약일시는 다시 설정하셔야 합니다.'))
        return;
    location.href = './sms_write.php?wr_no=<?php echo $wr_no?>';
}
</script>
