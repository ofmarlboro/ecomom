<style type="text/css">
	.tlist tr:hover{
		background:#eee;
	}
</style>

<h3 class="icon-search">검색</h3>
<!-- 제품검색 -->
<form name="search_form">
<table class="adm-table mb20">
	<caption>검색</caption>
	<colgroup>
		<col style="width:15%;"><col>
	</colgroup>
	<tbody>

		<tr>
			<th>회원검색</th>
			<td>
				<input type="text" name="search_value" class="width-l" value="<?=$this->input->get('search_value')?>" placeholder="회원 아이디, 이름, 주문번호">
				<input type="button" value="검색" class="btn-ok" onclick="document.search_form.submit()">
			</td>
		</tr>
	</tbody>
</table><!-- END 제품검색 -->
</form>

<h3 class='icon-list'>목록</h3>
<table class="adm-table align-c mb30">
	<tr>
		<th>번호</th>
		<th>신청 회원 아이디</th>
		<th>신청 회원 이름</th>
		<th>신청 주문번호</th>
		<th>신청일자</th>
		<th>삭제</th>
	</tr>
	<tbody class="tlist">
	<?php
	if($totalCnt){
		foreach($list as $lt){
			?>
			<tr>
				<td><?=$listNo--?></td>
				<td><?=$lt->userid?></td>
				<td><?=$lt->name?></td>
				<td><?=$lt->trade_code?></td>
				<td><?=$lt->wdate?></td>
				<td><input type="button" class="btn-sm btn-alert" value="삭제" onclick="if(confirm('삭제 하시겠습니까?')){location.href='<?=$_SERVER['REDIRECT_URL']?>/del/<?=$lt->idx?><?=$_SERVER['QUERY_STRING']?"?".$_SERVER['QUERY_STRING']:""?>'}"></td>
			</tr>
			<?php
		}
	}
	else{
		?>
		<tr>
			<td colspan="5">등록된 신청내역이 없습니다.</td>
		</tr>
		<?php
	}
	?>
	</tbody>
</table>

<?php
if($totalCnt){
	?>
	<p class="list-pager align-c" title="페이지 이동하기">
		<?=$Page2?>
	</p>
	<?php
}
?>