<script type="text/javascript">
<!--
	function memo_del(idx){
		if(confirm('메모를 삭제 하시겠습니까?')){
			location.href='?memo_idx='+idx;
		}
	}
//-->
</script>

<style type="text/css">
	.adm-tab{
		border-bottom:2px solid #000;
	}
	.adm-tab th{
		padding:10px;
	}
	.adm-tab th.on{
		border-top:2px solid #000;
		background:#eee;
	}

	.admin_memo_box{
		background:#eee;
		padding:5px;
	}
	.admin_memo_info{
		color:#3366ff;
		font-weight:700;
	}
	.admin_memo_content{
		display:block;
		padding:5px 0px 5px 10px;
	}
	.sobigdick{
		font-weight:600;
		font-size:30px;
	}
</style>

<?php
include $_SERVER['DOCUMENT_ROOT']."/html/application/views/dhadm/member_info_top.php";
?>

<table class="adm-tab mt20">
	<tr>
		<th <?if($mode == "edit"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/edit/<?=$row->idx?>/<?=$query_string.$param?>">회원 정보 관리</a></th>
		<th <?if($mode == "order"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/order/<?=$row->idx?>/<?=$query_string.$param?>">주문 내역</a></th>
		<th <?if($mode == "qna"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/qna/<?=$row->idx?>/<?=$query_string.$param?>">1:1 문의</a></th>
		<th <?if($mode == "point"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/point/<?=$row->idx?>/<?=$query_string.$param?>">적립금 내역</a></th>
		<th <?if($mode == "coupon"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/coupon/<?=$row->idx?>/<?=$query_string.$param?>">쿠폰 내역</a></th>
		<th <?if($mode == "deliv_place"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/deliv_place/<?=$row->idx?>/<?=$query_string.$param?>">배송지 관리</a></th>
		<th <?if($mode == "admin_memo"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/admin_memo/<?=$row->idx?>/<?=$query_string.$param?>">관리자 메모</a></th>
	</tr>
</table>

<!-- <h3 class="icon-list">관리자 메모</h3> -->

<div class="tab_title">
	<p class="tab_inner">
		“<?=$row->name?>” 님의 CS관리 내역입니다. 메모내용을 고객은 볼 수 없고, 관리자만 확인할 수 있습니다.
	</p>
</div>

<?php
foreach($memo_list as $ml){
?>
<div class="admin_memo_box mt10">
	<div class="float-r">
		<input type="button" value="삭제" class="btn-sm" onclick="memo_del('<?=$ml->idx?>')">
	</div>
	<span class="admin_memo_info"><?=date("Y-m-d",strtotime($ml->wdate))?> <?=$ml->admin_userid?> (<?=$ml->admin_name?>)</span>
	<span class="admin_memo_content">
		<?=nl2br($ml->memo_content)?>
	</span>
</div>
<?php
}
?>

<form method="post" id="memo_frm">
<input type="hidden" name="admin_userid" value="<?=$this->session->userdata('ADMIN_USERID')?>">
<input type="hidden" name="admin_name" value="<?=$this->session->userdata('ADMIN_NAME')?>">
<input type="hidden" name="userid" value="<?=$row->userid?>">
<input type="hidden" name="name" value="<?=$row->name?>">
<div class='mt20'>
	<textarea name="memo_content" type="text" id="" cols="30" rows="5" msg="메모를"></textarea>
	<input type="button" value="등록" class="btn-xl" onclick="frmChk('memo_frm')">
</div>
</form>

<p class="align-c mt40">
	<input type="button" class="btn-m btn-xl" onclick="location.href='<?=cdir()?>/member/user/m/<?=$query_string.$param?>'" value="목록으로"></a>
</p>