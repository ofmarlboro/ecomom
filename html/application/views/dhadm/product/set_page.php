<style type="text/css">
	.adm-table tr:hover{
		background:#eee;
	}
</style>
<h3 class="icon-pen">맛보기세트 페이지 제품 링크 연결</h3>

<div class="float-wrap">
	<p class="float-l">제품을 등록하신 후 제품 상세보기 페이지 링크를 입력해주세요.</p>
	<p class="float-r">최종 수정일자 : <?=$row->udate?></p>
</div>


<form method="post" name="frm" id="frm">
	<table class="adm-table v-line mb20">
		<colgroup>
			<col style="width:10%;">
			<col style="width:10%;">
			<col>
		</colgroup>
		<tr>
			<th rowspan="2" class="title pl10">추천특선</th>
			<th>PC</th>
			<td><input type="text" class="width-xl" placeholder="제품 뷰페이지 URL을 입력해주세요." name="page7" value="<?=$row->page7?>"></td>
		</tr>
		<tr>
			<th>mobile</th>
			<td><input type="text" class="width-xl" placeholder="제품 뷰페이지 URL을 입력해주세요." name="mpage7" value="<?=$row->mpage7?>"></td>
		</tr>
		<tr>
			<th rowspan="2" class="title pl10">올인원 무배세트</th>
			<th>PC</th>
			<td><input type="text" class="width-xl" placeholder="제품 뷰페이지 URL을 입력해주세요." name="page1" value="<?=$row->page1?>"></td>
		</tr>
		<tr>
			<th>mobile</th>
			<td><input type="text" class="width-xl" placeholder="제품 뷰페이지 URL을 입력해주세요." name="mpage1" value="<?=$row->mpage1?>"></td>
		</tr>

		<tr>
			<th rowspan="2" class="title pl10">솔잎한우세트</th>
			<th>PC</th>
			<td><input type="text" class="width-xl" placeholder="제품 뷰페이지 URL을 입력해주세요." name="page31" value="<?=$row->page31?>"></td>
		</tr>
		<tr>
			<th>mobile</th>
			<td><input type="text" class="width-xl" placeholder="제품 뷰페이지 URL을 입력해주세요." name="mpage31" value="<?=$row->mpage31?>"></td>
		</tr>

		<tr>
			<th rowspan="2" class="title pl10">남해달고기세트</th>
			<th>PC</th>
			<td><input type="text" class="width-xl" placeholder="제품 뷰페이지 URL을 입력해주세요." name="page32" value="<?=$row->page32?>"></td>
		</tr>
		<tr>
			<th>mobile</th>
			<td><input type="text" class="width-xl" placeholder="제품 뷰페이지 URL을 입력해주세요." name="mpage32" value="<?=$row->mpage32?>"></td>
		</tr>

		<tr>
			<th rowspan="2" class="title pl10">딱 2일분</th>
			<th>PC</th>
			<td><input type="text" class="width-xl" placeholder="제품 뷰페이지 URL을 입력해주세요." name="page41" value="<?=$row->page41?>"></td>
		</tr>
		<tr>
			<th>mobile</th>
			<td><input type="text" class="width-xl" placeholder="제품 뷰페이지 URL을 입력해주세요." name="mpage41" value="<?=$row->mpage41?>"></td>
		</tr>

		<tr>
			<th rowspan="2" class="title pl10">딱 6일분</th>
			<th>PC</th>
			<td><input type="text" class="width-xl" placeholder="제품 뷰페이지 URL을 입력해주세요." name="page42" value="<?=$row->page42?>"></td>
		</tr>
		<tr>
			<th>mobile</th>
			<td><input type="text" class="width-xl" placeholder="제품 뷰페이지 URL을 입력해주세요." name="mpage42" value="<?=$row->mpage42?>"></td>
		</tr>

		<tr>
			<th rowspan="2" class="title pl10">반찬 6팩</th>
			<th>PC</th>
			<td><input type="text" class="width-xl" placeholder="제품 뷰페이지 URL을 입력해주세요." name="page51" value="<?=$row->page51?>"></td>
		</tr>
		<tr>
			<th>mobile</th>
			<td><input type="text" class="width-xl" placeholder="제품 뷰페이지 URL을 입력해주세요." name="mpage51" value="<?=$row->mpage51?>"></td>
		</tr>

		<tr>
			<th rowspan="2" class="title pl10">국 6팩</th>
			<th>PC</th>
			<td><input type="text" class="width-xl" placeholder="제품 뷰페이지 URL을 입력해주세요." name="page52" value="<?=$row->page52?>"></td>
		</tr>
		<tr>
			<th>mobile</th>
			<td><input type="text" class="width-xl" placeholder="제품 뷰페이지 URL을 입력해주세요." name="mpage52" value="<?=$row->mpage52?>"></td>
		</tr>

		<tr>
			<th rowspan="2" class="title pl10">쌍둥이세트</th>
			<th>PC</th>
			<td><input type="text" class="width-xl" placeholder="제품 뷰페이지 URL을 입력해주세요." name="page61" value="<?=$row->page61?>"></td>
		</tr>
		<tr>
			<th>mobile</th>
			<td><input type="text" class="width-xl" placeholder="제품 뷰페이지 URL을 입력해주세요." name="mpage61" value="<?=$row->mpage61?>"></td>
		</tr>

		<tr>
			<th rowspan="2" class="title pl10">다둥이세트</th>
			<th>PC</th>
			<td><input type="text" class="width-xl" placeholder="제품 뷰페이지 URL을 입력해주세요." name="page62" value="<?=$row->page62?>"></td>
		</tr>
		<tr>
			<th>mobile</th>
			<td><input type="text" class="width-xl" placeholder="제품 뷰페이지 URL을 입력해주세요." name="mpage62" value="<?=$row->mpage62?>"></td>
		</tr>
	</table>
</form>

<div class="align-c">
	<input type="button" class="btn-xl btn-ok" value="확인" onclick="frmChk('frm')">
</div>