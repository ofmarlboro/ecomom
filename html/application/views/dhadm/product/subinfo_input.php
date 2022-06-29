<div class="float-wrap">
	<h3 class="icon-list float-l">카테고리별 안내페이지 <?=($mode == "insert")?"등록":"수정";?></h3>
</div>

<form method="post" name="sub_info" id="writefrm" enctype="multipart/form-data">
<table class="adm-table">
	<colgroup>
		<col style="width:15%">
		<col>
	</colgroup>
	<tr>
		<th>사용여부</th>
		<td>
			<input type="radio" name="it_use" id="use" value="1" <?=$row->it_use == 1 ? "checked":"";?>><label for="use">사용</label>
			<input type="radio" name="it_use" id="notuse" value="0" <?=$row->it_use == 1 ? "":"checked";?>><label for="notuse">미사용</label>
		</td>
	</tr>
	<tr>
		<th>골라담기</th>
		<td>
			<?php
			foreach($cate_list as $cl){
				if($cl->title != "이유식" and $cl->title != "반찬국"){
				?>
				<input type="checkbox" class="subinfo_chk" name="cate_no[]" value="<?=$cl->cate_no?>" id="cate_<?=$cl->idx?>" <?if($mode != "update" and @in_array($cl->cate_no,$cate_no_arr)){?>disabled<?}?> <?if($mode == "update"){?>onclick="return false;"<?}?> <?if($mode == "update" and @in_array($cl->cate_no,$update_cate_no_arr)){?>checked<?}?>><label for="cate_<?=$cl->idx?>" <?if($mode != "update" and in_array($cl->cate_no,$cate_no_arr)){?>style="color:#000;background:gray;"<?}?>><?=$cl->title?></label>
				<?php
				}
			}
			?>

			<?php
			/*
			<select name="cate_no" msg="카테고리를">
				<option value="">- 제품카테고리 -</option>
				<?php
				foreach($cate_list as $cl){
					if($cl->title != "이유식" and $cl->title != "반찬국"){
					?>
					<option value="<?=$cl->cate_no?>"><?=$cl->title?></option>
					<?php
					}
				}
				?>
			</select>
			<?php
			//help_info('사용자페이지 서브상단 안내페이지를 구성하기 위한 항목입니다. 2차 카테고리가 있는 1차 카테고리의 경우 페이지가 없으므로 선택 하지 말아주세요');
			?>
			*/
			?>
		</td>
	</tr>
	<tr>
		<th>추천식단</th>
		<td>
			<?php
			if($recom_list){
				foreach($recom_list as $rl){
				?>
				<input type="checkbox" class="subinfo_chk" name="recom_idx[]" value="<?=$rl->idx?>" id="recom_<?=$rl->idx?>"
				<?if($mode != "update" and @in_array($rl->idx,$recom_idx_arr)){?>disabled<?}?>
				<?if($mode == "update"){?>onclick="return false;"<?}?>
				<?if($mode == "update" and @in_array($rl->idx,$update_recom_idx_arr)){?>checked<?}?>><label for="recom_<?=$rl->idx?>"
				<?if($mode != "update" and @in_array($rl->idx,$recom_idx_arr)){?>style="color:#000;background:gray;"<?}?>><?=$rl->recom_name?></label>
				<?php
				}
			}
			?>
		</td>
	</tr>
	<tr>
		<td colspan="2">
		<?php
		help_info(' - 골라담기와 추천식단에 공통으로 들어가는 내용이 있는경우 모두 체크해주세요.<br> - 체크한 골라담기와 추천식단 카테고리 서브 상단에 내용이 들어갑니다.<br> - 선택된 값을 수정할 경우 삭제후 재등록 해주세요. (지정된 값이 틀어질 경우 사이트에 직접적인 영향이 있습니다.)');
		?>
		</td>
	</tr>

	<tr>
		<th>상세소개 사용여부</th>
		<td>
			<input type="checkbox" name="moreview_use" id="moreview" value="Y" <?=(@$row->moreview_use == "Y")?"checked":"";?>><label for="moreview">사용</label>
			<?php
			help_info('카테고리별 설명 상세소개 사용여부를 결정해주세요.');
			?>
		</td>
	</tr>

	<tr>
		<th>식단표 사용여부</th>
		<td>
			<input type="checkbox" name="foodtable_use" id="foodtable" value="Y" <?=(@$row->foodtable_use == "Y")?"checked":"";?>><label for="foodtable">사용</label>
			<?php
			help_info('각 상품페이지 상단 식단표 노출 여부를 설정해 주세요.');
			?>
		</td>
	</tr>

	<tr>
		<th>타이틀(대)</th>
		<td><input type="text" class="width-xl" name="title_b" value="<?=@$row->title_b?>" msg="타이틀(대) 을" placeholder="ex)이유식 준비기"></td>
	</tr>
	<tr>
		<th>타이틀(중)</th>
		<td><input type="text" class="width-xl" name="title_m" value="<?=@$row->title_m?>" msg="타이틀(중) 을" placeholder="ex)생후 5개월 전후"></td>
	</tr>
	<tr>
		<th>타이틀(소)</th>
		<td><input type="text" class="width-xl" name="title_s" value="<?=@$row->title_s?>" placeholder="ex)보미(미음)"></td>
	</tr>
	<tr>
		<th>간단설명</th>
		<td>
			<textarea type="text" name="info" id="" cols="30" rows="3"><?=@$row->info?></textarea>
			<?php
			help_info('<br>간단히 2줄 들어가는 설명글입니다. 설명 끝에 줄바꿈으로 마무리 해주세요. (줄바꿈으로 글이 끝나야 합니다)');
			?>
		</td>
	</tr>
	<tr>
		<th>간단설명 내 강조문구</th>
		<td>
			<input type="text" class="width-xl" name="bold_text" value="<?=@$row->bold_text?>" placeholder="ex)하루 한 팩, 10배 미음, 1회 이유식 섭취량 30~50g">
			<?php
			help_info('<br>간단설명 아래부분 강조문구 한줄');
			?>
		</td>
	</tr>
	<tr>
		<th>상세소개<br>내용</th>
		<td>
			<!-- <textarea type="text" name="detail" id="" cols="30" rows="10" msg="설명을"><?=@$row->detail?></textarea> -->

			<input type="file" name="detail">

			<?php
			if($row->detail){
			?>
				<a href="/_data/file/subinfo/<?=$row->detail?>" target="_blank">[<?=$row->detail_real?>]</a>
				<input type="checkbox" name="detail_del" value="1" id="detail_del"><label for="detail_del">삭제</label>
				<input type="hidden" name="old_detail" value="<?=$row->detail?>">
			<?php
			}
			?>


			<?php
			help_info('<br>레이어 팝업에 들어가는 설명 내용입니다. (이미지첨부)');
			?>
		</td>
	</tr>

	<tr>
		<th>상세소개<br>내용 (모바일용)</th>
		<td>

			<input type="file" name="mobile_detail">

			<?php
			if($row->mobile_detail){
			?>
				<a href="/_data/file/subinfo/<?=$row->mobile_detail?>" target="_blank">[<?=$row->mobile_detail_real?>]</a>
				<input type="checkbox" name="mobile_detail_del" value="1" id="mobile_detail_del"><label for="mobile_detail_del">삭제</label>
				<input type="hidden" name="old_mobile_detail" value="<?=$row->mobile_detail?>">
			<?php
			}
			?>


			<?php
			help_info('<br>레이어 팝업에 들어가는 설명 내용입니다. (이미지첨부)');
			?>
		</td>
	</tr>

	<tr>
		<th colspan="2"></th>
	</tr>

	<tr>
		<th>모바일 전용</th>
		<td>
			<input type="file" name="upfilem">
			<?php
			if($row->upfilem){
				?>
				<a href="/_data/file/subinfo/<?=$row->upfilem?>" target="_blank">[<?=$row->upfilem_real?>]</a>
				<input type="checkbox" name="upfilem_del" value="1" id="upfile_del_m"><label for="upfile_del_m">삭제</label>
				<input type="hidden" name="old_upfilem" value="<?=$row->upfilem?>">
				<?php
			}
			?>
		</td>
	</tr>

	<?php
	for($ii=1;$ii<=7;$ii++){
	?>
	<tr>
		<th>섬네일<?=$ii?></th>
		<td>
			<input type="file" name="upfile<?=$ii?>">
			<?php
			if(@$row->{'upfile'.$ii}){
				?>
				<a href="/_data/file/subinfo/<?=$row->{'upfile'.$ii}?>" target="_blank">[<?=$row->{'upfile_real'.$ii}?>]</a>
				<input type="checkbox" name="upfile_del<?=$ii?>" value="1" id="upfile_del_<?=$ii?>"><label for="upfile_del_<?=$ii?>">삭제</label>
				<input type="hidden" name="old_upfile<?=$ii?>" value="<?=$row->{'upfile'.$ii}?>">
				<?php
			}
			?>
		</td>
	</tr>
	<?php
	}
	?>
</table>
<?php
if($mode == "update"){
?>
<input type="hidden" name="idx" value="<?=$row->idx?>">
<?php
}
?>
</form>

<p class="align-c mt20">
	<input type="button" value="목록" class="btn-cancel btn-l" onclick="location.href='<?=cdir()?>/product/sub_info/m'">
	<input type="button" value="<? echo (@$row->idx) ? "수정" : "등록";?>" name="writeBtn" class="btn-ok btn-l" onclick="frmChk('writefrm')">
</p>