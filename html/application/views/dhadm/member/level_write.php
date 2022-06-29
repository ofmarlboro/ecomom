<?
if($this->uri->segment(4)=="edit"){

	if(!$row->idx){
		back("잘못된 접근입니다.");
		exit;
	}

}
$level = "";
?>
			<form name="frm" id="frm" method="post" enctype="multipart/form-data">
				<!-- 제품정보 -->
				<h3 class="icon-pen">등급 <?if($this->uri->segment(4)=="write"){?>추가<?}else{?>수정<?}?>하기</h3>
				<table class="adm-table mb70">
					<caption>User 정보를 입력하는 폼</caption>
					<colgroup>
						<col style="width:15%;">
						<col style="width:35%;">
						<col style="width:15%;">
						<col style="">
					</colgroup>
					<tbody>
						<tr>
							<th>level 선택</th>
							<td>
								<select name="level" id="level" tabindex="1">
								<?
								for($i=1;$i<=10;$i++){
									$j=$i-1;
									if($level_row[$j]->level != $i || ($this->uri->segment(4)=="edit" && $i==$row->level)){
								?>
									<option value="<?=$i?>"><?=$i?></option>
								<?
									}
								}?>
								</select>
							</td>
							<th>포인트적립율</th>
							<td><input type="text" class="width-s" name="reward" msg="포인트적립율을" value="<? echo isset($row->reward) ? $row->reward : "";?>" tabindex="3"> %</td>
						</tr>
						<tr>
							<th>등급이름</th>
							<td><input type="text" class="width-l" name="name" msg="등급이름을" value="<? echo isset($row->name) ? $row->name : "";?>" tabindex="2"></td>
							<th>등급업 구매총액</th>
							<td><input type="text" class="width-l" name="level_up_price" msg="등급업 구매총액을" value="<? echo isset($row->level_up_price) ? $row->level_up_price : "";?>" tabindex="4"> 원
								<?php
								help_info('(숫자만 입력해 주세요.)');
								?>
							</td>
						</tr>
					</tbody>
				</table>
				<p class="align-c mt40">
				<input type="button" value="목록으로" class="btn-m btn-xl" onclick="javascript:history.back(-1);">
				<input type="button" class="btn-ok btn-xl" value="<?if($this->uri->segment(4)=="write"){?>등록<?}else{?>수정<?}?>하기" onclick="frmChk('frm');">
				</p>
			</form>