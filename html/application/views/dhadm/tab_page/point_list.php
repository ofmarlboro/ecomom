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

	.sobigdick{
		font-weight:600;
		font-size:30px;
	}
</style>

<?php
include $_SERVER['DOCUMENT_ROOT']."/html/application/views/dhadm/member_info_top.php";
?>

<!-- <table class="adm-tab mt20">
	<tr>
		<th <?if($mode == "edit"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/edit/<?=$row->idx?>/<?=$query_string.$param?>">회원 정보 관리</a></th>
		<th <?if($mode == "order"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/order/<?=$row->idx?>/<?=$query_string.$param?>">주문 내역</a></th>
		<th <?if($mode == "qna"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/qna/<?=$row->idx?>/<?=$query_string.$param?>">1:1 문의</a></th>
		<th <?if($mode == "point"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/point/<?=$row->idx?>/<?=$query_string.$param?>">적립금 내역</a></th>
		<th <?if($mode == "coupon"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/coupon/<?=$row->idx?>/<?=$query_string.$param?>">쿠폰 내역</a></th>
		<th <?if($mode == "deliv_place"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/deliv_place/<?=$row->idx?>/<?=$query_string.$param?>">배송지 관리</a></th>
		<th <?if($mode == "admin_memo"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/admin_memo/<?=$row->idx?>/<?=$query_string.$param?>">관리자 메모</a></th>
	</tr>
</table> -->

<!-- <h3 class="icon-list">적립금내역</h3> -->
<div class="tab_title_noborder mt20">
	<p class="tab_inner">
		“<span><?=$row->name?></span>”님의 보유 적립금은 <span class="blue"><?=number_format($total_point)?></span>원 입니다.
	</p>
</div>

<table class="adm-table v-line align-c">
	<thead>
		<tr>
			<th>일시</th>
			<th>내용</th>
			<th>적립금획득</th>
			<th>적립금사용</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if($list){
			foreach($list as $lt){
			?>
			<tr>
				<td><?=date("Y년 m월 d일",strtotime($lt->reg_date))?></td>
				<td><?=$lt->content?></td>
				<td><?=($lt->point > 0)?number_format($lt->point)."원":"-";?></td>
				<td><?=($lt->point < 0)?number_format($lt->point)."원":"-";?></td>
			</tr>
			<?php
			}
		}
		?>
	</tbody>
</table>

<p class="align-c mt40">
	<input type="button" class="btn-m btn-xl" onclick="location.href='<?=cdir()?>/member/user/m/<?=$query_string.$param?>'" value="목록으로"></a>
</p>