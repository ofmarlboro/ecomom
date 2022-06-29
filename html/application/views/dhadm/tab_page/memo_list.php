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

	.memo_box{
		background:#eee;
		min-height:150px;
	}
	.memo_box_title{
		color:#3366ff;
	}
	.memo_box_title em{
		font-weight:600;
	}
	.memo_box_content{
		display:block;
		padding:5px 0px 0px 10px;
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
include $_SERVER['DOCUMENT_ROOT']."/html/application/views/dhadm/od.view.meminfo.top.php";
?>

<table class="adm-tab mt20 mb20">
	<tr>
		<th <?if($mode == "view"){?>class="on"<?}?>><a href="<?=cdir()?>/order/lists/m/view/<?=$trade_idx?>/<?=$query_string.$param?>">주문상품목록</a></th>
		<th <?if($mode == "payment"){?>class="on"<?}?>><a href="<?=cdir()?>/order/lists/m/payment/<?=$trade_idx?>/<?=$query_string.$param?>">주문결제내역</a></th>
		<th <?if($mode == "memo"){?>class="on"<?}?>><a href="<?=cdir()?>/order/lists/m/memo/<?=$trade_idx?>/<?=$query_string.$param?>">회원/주문메모</a></th>
		<th <?if($mode == "send_receive"){?>class="on"<?}?>><a href="<?=cdir()?>/order/lists/m/send_receive/<?=$trade_idx?>/<?=$query_string.$param?>">주문/받는사람</a></th>
	</tr>
</table>

<h3 class="icon-check">회원/주문 메모</h3>

<div class="memo_box">
	<span class="memo_box_title"><em>주문메모</em> : 고객님이 작성한 내용입니다.</span>
	<span class="memo_box_content">
		<?=$trade_stat->send_text?>
	</span>
</div>

<div style="text-align:center;border-top:1px dotted #000;margin-top:20px">
	<span style="position:relative;top:-10px;background:#fff;">관리자메모</span>
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
<input type="hidden" name="userid" value="<?=$trade_stat->userid?>">
<input type="hidden" name="name" value="<?=$trade_stat->name?>">
<div class="mt20">
	<textarea name="memo_content" type="text" id="" cols="30" rows="5" msg="메모를"></textarea>
	<input type="button" value="등록" class="btn-xl" onclick="frmChk('memo_frm')">
</div>
</form>

<div class="float-wrap mt40">
	<div class="float-l">
		<a href="<?=cdir()?>/order/lists/m/<?=$query_string.$param?>" class="btn-clear button btn-l">목록으로</a>
	</div>
	<div class="float-r">

		<!-- <button type="button" class="btn-special btn-xl" onclick="">출력하기</button> -->
		<!-- <input type="button" value="저장하기" class="btn-ok btn-xl" onclick=""> -->
		<!-- <? if($trade_stat->trade_method==1){?><input type="button" value="카드취소" class="btn-special btn-xl" onclick="cancel()"><?}?> -->
	</div>
</div>


