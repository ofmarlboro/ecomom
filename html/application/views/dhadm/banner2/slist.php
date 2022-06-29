<?
	$param="";
	if($this->input->get("PageNumber")){ $param .="&PageNumber=".$this->input->get("PageNumber"); }

	$mobile_use = false;
	if(strpos($code,"insta") !== false){	//인스타 후기들
		$mobile_use = true;
	}

	if($code == "depart"){	//매장소개
		$mobile_use = true;
	}

	if($code == "a_circle"){	//웹&모바일 메인 동그라미 배너
		$mobile_use = true;
	}

	/*
	if($code == "pc_mid_farm"){	//공통-메인 오 ! 산골농부
		$mobile_use = true;
	}

	if($code == "pc_event_top"){	//공통-이벤트페이지 상단
		$mobile_use = true;
	}

	if($code == "pc_event_bottom"){	//공통-이벤트페이지 하단
		$mobile_use = true;
	}

	if($code == "pc_farmlist"){	//공통-메인 오 ! 산골농부
		$mobile_use = true;
	}

	if($code == "pc_deliv" || $code == "pc_news" || $code == "pc_farm" || $code == "pc_event" || $code == "pc_spcdis"){	//공통-메인 오 ! 산골농부
		$mobile_use = true;
	}
	*/
?>

<div class="float-wrap">
	<h3 class="icon-list float-l"><?=$parent_info->name?></h3>
	<p class="float-r">배너등록/수정/삭제</p>
</div>

<style type="text/css">
	.lists_tr{
		background:#fff;
	}
	.lists_tr:hover{
		background:#eee;
	}
</style>

<?php
if($code == "insta_no"){
	helps("이곳에 등록된 게시물은 사이트 어느곳에도 노출되지 않습니다.");
}
else{
	helps("1개만 등록되는 배너의 경우 삭제 또는 수정을 통하여 관리 해 주시거나 숨김처리 바랍니다.<br>여러개 등록시 최근 등록기준 1개만 노출합니다.");
}
?>

<div class="float-wrap mt20 mb20">
	<div class="float-l">
		<a href="/html/banner2/group/m/" class="button">배너그룹 목록</a></span>
		<?php
		if($code == "depart"){
			?>
			<a href="javascript: window.open('<?=cdir()?>/banner2/cate/?ajax=1','cate_page','width=500,height=700,top=200,left=100');" class="button">지역분류 관리</a>
			<?php
		}
		?>
	</div>
	<div class="float-r">
		<a href="/html/banner2/group/m/s_input/?code=<?=$code?>&parent_idx=<?=$parent_idx?>" class="button btn-ok">배너등록</a></span>
	</div>
</div>

<table class="adm-table line align-c">
	<caption>배너 목록</caption>
	<thead>
		<tr>
			<th><input type="checkbox" name="all_chk" id="all_chk" class="all_chk"></th>
			<th>사용여부</th>
			<?php
			if($code == "depart"){
			?>
			<th>분류</th>
			<th>매장명</th>
			<th>링크코드</th>
			<?php
			}
			else if(strpos($code,"insta") !== false){
			?>
			<th>제목</th>
			<?php
			}
			else{
			?>
			<th>배너명</th>
			<?php
			}
			?>
			<th><?=($mobile_use)?"PC ":"";?>이미지</th>
			<?php
			if($mobile_use){
				?>
				<th>Mobile 이미지</th>
				<?php
			}
			?>
			<th>우선순위</th>
			<th>관리</th>
		</tr>
	</thead>
	<tbody class="ft092">
		<form name="order_form" method="post">
		<?php
		$list_cnt = 0;
		foreach($s_list as $row)
		{
			$list_cnt++;
		?>
		<tr class="lists_tr">
			<td><input type="checkbox" id="chkNum<?=$list_cnt?>" name="chk<?=$list_cnt?>" value="<?=$row->idx?>" class="chkNum"></td>
			<td><?=$row->addinfo4 == "used" ? "사용" : "숨김" ;?></td>
			<?php
			if($code == "depart"){
			?>
			<td><?=$cate[$row->addinfo5]?></td>
			<td><?=$row->addinfo1?></td>
			<td><?=$row->idx?></td>
			<?php
			}
			else if(strpos($code,"insta") !== false){
			?>
			<td><?=$row->addinfo1?></td>
			<?php
			}
			else{
			?>
			<td><?=$row->addinfo1?></td>
			<?php
			}
			?>

			<td>
				<input type="button" value="view" onclick="window.open('/_data/file/banner2/<?=$row->upfile1?>','','width=560,height=315,scrollbars=yes,resizeable=yes')">
				<!-- <img src="/_data/file/banner2/<?=$row->upfile1?>" width="100" onclick="window.open('/_data/file/banner2/<?=$row->upfile1?>','','width=560,height=315,scrollbars=yes,resizeable=yes')" onerror="this.src='/image/default.jpg'"> -->
			</td>
			<?php
			if($mobile_use){
				?>
				<td><!-- <img src="/_data/file/banner2/<?=$row->upfile2?>" width="100" onclick="window.open('/_data/file/banner2/<?=$row->upfile2?>','','width=560,height=315,scrollbars=yes,resizeable=yes')" onerror="this.src='/image/default.jpg'"> -->
					<input type="button" value="view" onclick="window.open('/_data/file/banner2/<?=$row->upfile2?>','','width=560,height=315,scrollbars=yes,resizeable=yes')">
				</td>
				<?php
			}
			?>
			<td><?=$row->sort?></td>
			<td>
				<input type="button" value="수정" class="btn-sm" onclick="javascript:location.href='/html/banner2/group/m/s_edit/?code=<?=$code?>&s_idx=<?=$row->idx?>';">
				<input type="button" value="삭제" class="btn-sm btn-alert" onclick="delok('<?=$row->idx?>')">
			</td>
		</tr>
		<?php
		}

		if(count($s_list) <= 0)
		{
		?>
		<tr>
			<td colspan="10">등록된 내용이 없습니다.</td>
		</tr>
		<?php
		}
		?>
		<input type="hidden" name="form_cnt" id="form_cnt" value="<?=$list_cnt?>">
		</form>
	</tbody>
</table>

<div class="float-wrap mt20">
	<div class="float-l">
		<p>
			<a href="javascript: sel_del();" class="button">선택삭제</a></span>
			<a href="javascript: sel_move();" class="button">선택이동</a></span>
			<a href="javascript: sel_copy();" class="button">선택복사</a></span>
		</p>
		<p class="mt10">
			<a href="/html/banner2/group/m/" class="button">배너그룹 목록</a></span>
		</p>
	</div>
	<div class="float-r">
		<a href="/html/banner2/group/m/s_input/?code=<?=$code?>&parent_idx=<?=$parent_idx?>" class="button btn-ok">배너등록</a></span>
	</div>
</div>

<script type="text/javascript">
<!--
	function delok(idx){
		if(confirm("정말 삭제하시겠습니까?")){
			location.href = "/html/banner2/group/m/s_del/?s_idx="+idx;
		}
	}

	function sel_del(){
		if(confirm('삭제하신 데이터는 복구 할 수 없습니다.\n정말 삭제하시겠습니까?')){
			document.order_form.submit();
		}
	}

	function sel_move(){
		var chk_val = "";
		$(".chkNum").each(function(){
			if($(this).prop('checked')){
				chk_val += $(this).val()+",";
			}
		});

		window.open("/html/banner2/sel_pop/move/?ajax=1&code=<?=$code?>&chkval="+chk_val,"sel_pop","width=500,height=300,top=200,left=200");
	}

	function sel_copy(){
		var chk_val = "";
		$(".chkNum").each(function(){
			if($(this).prop('checked')){
				chk_val += $(this).val()+",";
			}
		});

		window.open("/html/banner2/sel_pop/copy/?ajax=1&code=<?=$code?>&chkval="+chk_val,"sel_pop","width=500,height=300,top=200,left=200");
	}
//-->
</script>