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

<h1 class="sobigdick"><?=$row->order_name?>, <?=$row->userid?>, <?=$row->order_phone?></h1>

<table class="adm-tab mt20 mb20">
	<tr>
		<th <?if($mode == "view"){?>class="on"<?}?>><a href="<?=cdir()?>/order/delivery/m/view/<?=$deliv_code?>/<?=$query_string.$param?>">배송상품 목록</a></th>
		<th <?if($mode == "order_change"){?>class="on"<?}?>><a href="<?=cdir()?>/order/delivery/m/order_change/<?=$deliv_code?>/<?=$query_string.$param?>">주문 변동내역</a></th>
		<th <?if($mode == "memo"){?>class="on"<?}?>><a href="<?=cdir()?>/order/delivery/m/memo/<?=$deliv_code?>/<?=$query_string.$param?>">회원/주문메모</a></th>
		<th <?if($mode == "send_receive"){?>class="on"<?}?>><a href="<?=cdir()?>/order/delivery/m/send_receive/<?=$deliv_code?>/<?=$query_string.$param?>">주문/받는사람</a></th>
	</tr>
</table>

<!-- 제품리스트 -->
<h3 class="icon-check">회원/주문 메모</h3>

<div class="memo_box">
	<span class="memo_box_title"><em>주문메모</em> : 고객님이 작성한 내용입니다.</span>
	<span class="memo_box_content">
		<?=$trade_info->send_text?>
	</span>
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

<form action="" method="post" id="memo_frm">
<input type="hidden" name="admin_userid" value="<?=$this->session->userdata('ADMIN_USERID')?>">
<input type="hidden" name="admin_name" value="<?=$this->session->userdata('ADMIN_NAME')?>">
<input type="hidden" name="userid" value="<?=$row->userid?>">
<input type="hidden" name="name" value="<?=$row->order_name?>">
<div class='mt20'>
	<textarea name="memo_content" type="text" id="" cols="30" rows="5" msg="메모를"></textarea>
	<input type="button" value="등록" class="btn-xl" onclick="frmChk('memo_frm')">
</div>
</form>

<div class="float-wrap mt40">
	<div class="float-l">
		<a href="<?=cdir()?>/order/delivery/m/<?=$query_string.$param?>" class="btn-clear button btn-l">목록으로</a>
	</div>
</div>

<?
$flag="admin";
include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/order/".$shop_info['pg_company']."_cancel.php";
?>

