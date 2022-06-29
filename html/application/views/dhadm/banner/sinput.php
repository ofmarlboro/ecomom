<?php
/*

** 추가항목 (addinfo) 추가 **

이미지 2개중 1개는 숨겨놓음

배너관리에 필요한 추가 항목을 자유자재로 추가할수 있도록 C와 M에 addinfo1 부터 addinfo5 까지 5개의 컬럼을 추가함
테이블에서 컬럼 데이터 유형이나 길이값 조절하여 사용가능

*/

$size_info = "파일을 선택해 주세요.";
$m_size_info = "파일을 선택해 주세요.";

$pc_size = "";
$m_size = "";
$mobile_use = false;
if($code == "pc_main"){	//공통-메인배너
	$pc_size = "권장사이즈 666 x 800 px";
	$m_size = "권장사이즈 800 x 525 px";
	$mobile_use = true;
}

if($code == "pc_depart"){	//공통-메인백화점입점
	$pc_size = "권장사이즈 600 x 446 px";
	$m_size = "권장사이즈 800 x 1200 px";
	$mobile_use = true;
}

if($code == "site_logo"){	//PC-메인 로고
	$pc_size = "권장사이즈 335 x 56 px";
}

if($code == "site_logo_left"){	//PC-메인 좌측 로고
	$pc_size = "권장사이즈 335 x 56 px";
}

if($code == "pc_mid_farm"){	//공통-메인 오 ! 산골농부
	$pc_size = "권장사이즈 1200 x free px";
	$m_size = "권장사이즈 800 x free px";
	$mobile_use = true;
}

if($code == "pc_event_top"){	//공통-이벤트페이지 상단
	$pc_size = "권장사이즈 1200 x 270 px";
	$m_size = "권장사이즈 800 x 1199 px";
	$mobile_use = true;
}

if($code=="snack_top"){	//산골간식-상단배너
	$pc_size = "권장사이즈 1150 x 200 px";
	$m_size = "권장사이즈 900 x 188 px";
	$mobile_use = true;
}

if($code=="nmk_top"){	//산골간식-상단배너
	$pc_size = "권장사이즈 1150 x 200 px";
	$m_size = "권장사이즈 900 x 575 px";
	$mobile_use = true;
}

if($code == "pc_event_bottom"){	//공통-이벤트페이지 하단
	$pc_size = "권장사이즈 1200 x free px";
	$m_size = "권장사이즈 800 x free px";
	$mobile_use = true;
}

if($code == "m_main_under"){	//Mob-메인비주얼 하단 슬라이드
	$pc_size = "권장사이즈 500 x 440 px";
}

if($code == "pc_farmlist"){	//공통-메인 오 ! 산골농부
	$pc_size = "권장사이즈 1200 x free px";
	$m_size = "권장사이즈 800 x free px";
	$mobile_use = true;
}

if($code == "pc_deliv" || $code == "pc_news" || $code == "pc_farm" || $code == "pc_event" || $code == "pc_spcdis"){	//공통-메인 오 ! 산골농부
	$pc_size = "권장사이즈 430 x 563 px";
	$m_size = "권장사이즈 730 x free px";
	$mobile_use = true;
}

if($code == "newholi"){
	$pc_size = "권장사이즈 267 x 134 px";
	$m_size = "권장사이즈 1131 x 282 px";
	$mobile_use = true;
}
?>
<form name="frm" id="frm" method="post" enctype="multipart/form-data">
<input type="hidden" name="code" value="<?=$code?>">
<input type="hidden" name="parent_idx" value="<?=$parent_idx?>">
<input type="hidden" name="sidx" value="<?=$s_idx?>">

	<!-- 제품정보 -->
	<h3 class="icon-pen"><?if($mode=="s_input"){?>등록<?}else{?>수정<?}?>하기</h3>
	<table class="adm-table mb70">
		<caption>정보를 입력하는 폼</caption>
		<colgroup>
			<col style="width:15%;">
			<col>
		</colgroup>
		<tbody>
			<tr>
				<th>등록그룹코드</th>
				<td><?=($mode == "s_input")?$code:$s_row->parent_code; ?></td>
			</tr>
			<tr>
				<th>배너명</th>
				<td>
					<input type="text" class="width-xl" name="addinfo1" value="<?=@$s_row->addinfo1?>">
					<?php
					help_info("팝업배너는 제목이 들어갑니다.");
					?>
				</td>
			</tr>
			<?php
			if($code == 'mainy'){
				?>
				<tr>
					<th>서브타이틀</th>
					<td>
						<input type="text" class="width-xl" name="addinfo2" value="<?=@$s_row->addinfo2?>">
					</td>
				</tr>
				<?php
			}
			?>

			<?php
			if($code == "pc_depart"){
			?>
			<tr>
				<th>백화점 지점명(PC)</th>
				<td>
					<?php
					help_info("백화점 지점명으로 사용됩니다. (PC한정)");
					?>
					<input type="text" class="width-xl" name="addinfo3" value="<?=@$s_row->addinfo3?>">
				</td>
			</tr>
			<tr>
				<th>설명</th>
				<td>
					<textarea name="addinfo2" rows="7"><?=$s_row->addinfo2?></textarea>
				</td>
			</tr>
			<?php
			}
			?>
			<tr>
				<th><?=$mobile_use ? "PC-이미지" : "이미지" ;?></th>
				<td>
					<ul class="file w40">
						<li>
							<input type="file" id="file01" name="upfile1"/><label for="file01" class="btn-file">파일찾기</label>
							<span class="file-name01"><? echo (isset($s_row) and $s_row->upfile1_real != "") ? $s_row->upfile1_real : $size_info;?></span>
						</li>
					</ul>
					<p class="float-l">
						<?php
						if($s_row->upfile1){
							?>
							<input type="checkbox" name="upfile1_del" id="upfile1_del" value="1"> <label for="upfile1_del">삭제</label>
							<?php
						}
						?>
						<?=$pc_size?>
					</p>
				</td>
			</tr>
			<tr>
				<th><?=$mobile_use ? "PC-링크" : "링크" ;?></th>
				<td>
					<input type="text" style="width:50%;" name="pageurl" value="<?=(isset($s_row) and $s_row->pageurl != "")?$s_row->pageurl:"";?>">
					<input type="radio" name="pc_target" value="blank" id="blank" <?=($s_row->pc_target == "blank")?"checked":"";?>><label for="blank">새창</label>
					<input type="radio" name="pc_target" value="self" id="self" <?=($s_row->pc_target == "self")?"checked":"checked";?>><label for="self">현재창</label>
					<?php
					help_info("클릭시 이동할 URL경로를 설정합니다. (미입력시 페이지 이동하지 않습니다.)<br>");
					?>
				</td>
			</tr>

			<?php
			if($mobile_use){
			?>
			<tr>
				<th>모바일-이미지</th>
				<td>
					<?php
					help_info('모바일 이미지가 미등록 되어있을 경우 PC 이미지를 대체하여 사용합니다.');
					?>
					<br>
					<ul class="file w40">
						<li>
							<input type="file" id="file02" name="upfile2"/><label for="file02" class="btn-file">파일찾기</label>
							<span class="file-name02"><? echo (isset($s_row) and $s_row->upfile2_real != "") ? $s_row->upfile2_real : $m_size_info;?></span>
						</li>
					</ul>
					<p class="float-l">
						<?php
						if($s_row->upfile2){
							?>
							<input type="checkbox" name="upfile2_del" id="upfile2_del" value="1"> <label for="upfile2_del">삭제</label>
							<?php
						}
						?>
						<?=$m_size?>
					</p>
				</td>
			</tr>
			<tr>
				<th>모바일-링크</th>
				<td>
					<input type="text" style="width:50%;" name="m_pageurl" value="<?=(isset($s_row) and $s_row->m_pageurl != "")?$s_row->m_pageurl:"";?>">
					<input type="radio" name="m_target" value="blank" id="blank" <?=($s_row->m_target == "blank")?"checked":"";?>><label for="blank">새창</label>
					<input type="radio" name="m_target" value="self" id="self" <?=($s_row->m_target == "self")?"checked":"checked";?>><label for="self">현재창</label>
					<?php
					help_info("모바일 웹에서 클릭시 이동할 URL경로를 설정합니다. (미입력시 페이지 이동하지 않습니다.)<br>");
					?>
				</td>
			</tr>
			<?php
			}
			?>

			<tr>
				<th>우선순위</th>
				<td>
					<select name="sort" id="">
						<?php
						for($ii=1;$ii<=10;$ii++){
						?>
						<option value="<?=$ii?>" <?if(@$s_row->sort == $ii || @$max_rank == $ii) echo "selected";?>><?=$ii?></option>
						<?php
						}
						?>
					</select>
					<?php
					help_info("등록된 배너에 따라 자동으로 증가되며 수동 설정 가능");
					?>
				</td>
			</tr>
		</tbody>
	</table>
	<p class="align-c mt40">
		<input type="button" value="목록으로" class="btn-m btn-xl" onclick="javascript:location.href='<?=cdir()?>/banner/group/m/s_add/?code=<?=$code?>&parent_idx=<?=$parent_idx?>';">
		<input type="button" class="btn-ok btn-xl" value="<?if($mode=="s_input"){?>등록<?}else{?>수정<?}?>하기" onclick="frm_send()">
	</p>

</form>

<script type="text/javascript">
<!--
	function frm_send(){
		frm = document.frm;
		<?php
		if ($mode == "s_input"){
		?>
		if (frm.upfile1.value == "")
		{
			alert("이미지를 입력해주세요.");
			return;
		}
		/*
		if (frm.upfile2.value == "")
		{
			alert("내용사진을 입력해주세요.");
			return;
		}
		*/
		<?php
		}
		?>
		frm.submit();
	}

	$(function(){
		$("#file01").change(function(){
			$(".file-name01").text($(this).val());
		});
		$("#file02").change(function(){
			$(".file-name02").text($(this).val());
		});
	});
//-->
</script>