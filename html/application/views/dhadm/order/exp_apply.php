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
				<input type="text" name="search_value" class="width-l" value="<?=$this->input->get('search_value')?>" placeholder="회원 아이디, 이름, 연락처">
				<input type="button" value="검색" class="btn-ok" onclick="document.search_form.submit()">
			</td>
		</tr>
	</tbody>
</table><!-- END 제품검색 -->
</form>



<div class="float-wrap mb10">
	<h3 class='icon-list float-l'>목록</h3>
	<p class="float-r">
		<input type="button" value="엑셀저장" onclick="location.href='?ajax=1&excel=ok'">
	</p>
</div>

<table class="adm-table align-c mb30">
	<tr>
		<th>번호</th>
		<th>아이디</th>
		<th>성함</th>
		<th>연락처</th>
		<th>배송지</th>
		<th>sns링크</th>
		<th>신청일</th>
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
				<td><?=$lt->phone?></td>
				<td><?=$lt->addr1." ".$lt->addr2?></td>
				<td><?=$lt->snsurl?></td>
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