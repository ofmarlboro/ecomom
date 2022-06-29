<?php
/*
등급 자동조정 타이밍
 - 회원 각 로그인시 개인 주문기록 검색하여 등업조건에 해당될 경우 등업후 로그 기록
 - 관리자 수동으로 등급자동조정 페이지에서 버튼 클릭시
*/
?>

<script type="text/javascript">
	function level_auto_change(){
		if(confirm("회원 등급 자동조정시 사이트가 현저히 느려질수 있습니다.\n진행 하시겠습니까?")){
			document.lev_chg.submit();
		}
	}

	function del_log(idx){
		if(confirm("등급 조정 기록은 삭제시 복구 할 수 없습니다.\n삭제 하시겠습니까?")){
			var frm = document.delFrm;
			frm.del_idx.value = idx;
			frm.submit();
		}
	}
</script>

<form method="post" name="lev_chg">
	<input type="hidden" name="mode" value="levchg">
	<input type="hidden" name="today" value="<?=date("Y-m-d")?>">
</form>

<form name="delFrm" method="post">
	<input type="hidden" name="del_ok" value="1">
	<input type="hidden" name="del_idx">
</form>

				<h3 class="icon-search">검색</h3>
				<!-- 제품검색 -->
				<form name="search_form">
				<table class="adm-table">
					<caption>검색</caption>
					<colgroup>
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>
						<tr>
							<th>검색</th>
							<td>
								등급
								<select name="level">
									<?php
									foreach($level_arr as $key=>$la){
									?>
									<option value="<?=$key?>" <?=($key == $this->input->get('level'))?"selected":"";?>><?=$la?></option>
									<?php
									}
									?>
								</select>
								|
								등록일
								<input type="text" name="wdate" class="width-m" value="<?=$this->input->get('wdate')?>" id="start_date">
								|
								아이디
								<input type="text" name="userid" class="width-l" value="<?=$this->input->get('userid')?>">
								<input type="button" value="검색" class="btn-ok" onclick="javascript:document.search_form.submit();">
							</td>
						</tr>
					</tbody>
				</table><!-- END 제품검색 -->
				</form>

				<div class="mt20"></div>
				<div class="float-wrap">
					<div class="float-r">
						<input type="button" value="회원등급 조정하기" onclick="level_auto_change()">
					</div>
				</div>
				<div class="mb20"></div>

				<table class="adm-table line align-c">
					<caption>유저 목록</caption>
					<colgroup>
						<col>
						<col>
						<col>
						<col>
						<col>
						<col>
					</colgroup>
					<thead>
						<tr>
							<th>회원아이디</th>
							<th>이전등급</th>
							<th>변경등급</th>
							<th>설명</th>
							<th>등록일</th>
							<th>비고</th>
						</tr>
					</thead>
					<tbody class="ft092">
						<?php
						if($list){
							foreach($list as $lt){
							?>
							<tr>
								<td><?=$lt->userid?></td>
								<td><?=$level_arr[$lt->before_level]?></td>
								<td><?=$level_arr[$lt->after_level]?></td>
								<td><?=$lt->info?></td>
								<td><?=strDatecut($lt->wdate,3)?></td>
								<td>
									<input type="button" value="로그삭제" onclick="del_log('<?=$lt->idx?>')">
								</td>
							</tr>
							<?php
							}
						}
						else{
						?>
						<tr>
							<td colspan="6">표시할 내역이 없습니다.</td>
						</tr>
						<?php
						}
						?>

						<?php
						/*
						<tr>
							<td>test</td>
							<td>동</td>
							<td>은</td>
							<td>구매금액 조건에 의해 레벨업!</td>
							<td>2018-05-28</td>
							<td>
								<input type="button" value="로그삭제">
							</td>
						</tr>
						<tr>
							<td>test</td>
							<td>동</td>
							<td>은</td>
							<td>구매금액 조건에 의해 레벨업!</td>
							<td>2018-05-28</td>
							<td>
								<input type="button" value="로그삭제">
							</td>
						</tr>
						<tr>
							<td>test</td>
							<td>동</td>
							<td>은</td>
							<td>구매금액 조건에 의해 레벨업!</td>
							<td>2018-05-28</td>
							<td>
								<input type="button" value="로그삭제">
							</td>
						</tr>
						*/
						?>
					</tbody>
				</table>

				<div class="mt20"></div>

				<?php
				if(count($list) > 0){
				?>
				<!-- Pager -->
				<p class="list-pager align-c" title="페이지 이동하기">
					<?=$Page2?>
				</p>
				<!-- END Pager -->
				<?php
				}
				?>