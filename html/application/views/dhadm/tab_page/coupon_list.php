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

<!-- <h3 class="icon-list">쿠폰내역</h3> -->
<div class="tab_title_noborder">
	<p class="tab_inner">
		“<span><?=$row->name?></span>”님이 사용하실 수 있는 쿠폰은 <span class="blue"><?=number_format($total_cnt)?></span>개 입니다.
	</p>
</div>

<table class="adm-table v-line align-c">
	<thead>
		<tr>
			<th>쿠폰명</th>
			<th>쿠폰코드</th>
			<th>할인혜택</th>
			<!-- <th>사용조건</th> -->
			<th>발급일자</th>
			<th>유효기간</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if($list){
			foreach($list as $lt){
			?>
			<tr>
				<td><?=$lt->name?></td>
				<td><?=$lt->code?></td>
				<td><?if($lt->type==3){?>배송비 전액<?}else{?><?=number_format($lt->price)?><? if($lt->discount_flag==0){?>원<?}else if($lt->discount_flag==1){?>%<?}?><?}?></td>
				<!-- <td>100,000원 이상 결제시 사용</td> -->
				<td><?=date("Y년 m월 d일",strtotime($lt->reg_date))?></td>
				<td><?=date("Y년 m월 d일",strtotime($lt->end_date))?></td>
			</tr>
			<?php
			}
		}
		else{
		?>
		<tr>
			<td colspan="5">등록된 쿠폰이 없습니다.</td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>

<p class="align-c mt40">
	<input type="button" class="btn-m btn-xl" onclick="location.href='<?=cdir()?>/member/user/m/<?=$query_string.$param?>'" value="목록으로"></a>
</p>