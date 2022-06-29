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

<!-- <h3 class="icon-list">주문내역</h3> -->

<div class="tab_title_noborder mt20">
	<p class="tab_inner">
		:: 총 <?=count($list)?> 건의 주문내역이 있습니다.
	</p>
</div>

<table class="adm-table v-line align-c">
	<thead>
		<tr>
			<th>No.</th>
			<th>주문상태<br>첫주문여부</th>
			<th>주문일자<br>주문번호[PC/모바일구분]</th>
			<th>배송구분</th>
			<th>주문내역</th>
			<th>주문금액</th>
			<th>실결제금액</th>
			<th>(-) 쿠폰할인</th>
			<th>(-) 적립금할인</th>
			<th>결제수단</th>
			<th>배송진행</th>
			<th>비고</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if($list){
			$list_cnt = count($list);
			foreach($list as $lt){
			?>
			<tr style="background:<?=($lt->trade_stat == 9)?"#fdebf3":"";?>;">
				<td><?=$list_cnt?></td>
				<td style="text-align:left">
					<?=$shop_info['trade_stat'.$lt->trade_stat]?>
					<?php
					if($lt->first_order == "Y"){
					?>
					<div style="background:#0000ff;color:#fff;width:15px;display:inline-block;text-align:center;">N</div>
					<?php
					}
					?>
				</td>
				<td>
					<?=date("Y-m-d",strtotime($lt->trade_day))?><br>
					<a href="/html/order/lists/m?sch_date=delivery_day&sch_item=trade_code&sch_item_val=<?=$lt->trade_code?>" target="_blank"><?=$lt->trade_code?></a>
					[<?=($lt->mobile)?"M":"P";?>]
				</td>
				<td>
					<?php
					if($lt->recom_is == "Y"){
						echo "<span style='color:blue;font-weight:600;'>정기배송</span>";
					}
					else if($lt->sample_is == "Y"){
						echo "<span style='color:#000;font-weight:600;'>샘플신청</span>";
					}
					else{
						echo "<span style='color:red;font-weight:600;'>일반주문</span>";
					}
					?>
				</td>
				<td>
					<?php
					$goods_row = $this->common_m->self_q("select * from dh_trade_goods where trade_code = '".$lt->trade_code."' order by idx desc","result");
					foreach($goods_row as $key=>$gname){
						$j = $key+1;
						echo $gname->goods_name;
						echo "".($j > 0)?"<br>":"";
					}
					?>
				</td>
				<td><?=number_format($lt->price)?>원</td>
				<td><?=number_format($lt->total_price)?>원</td>
				<td><?=number_format($lt->use_coupon)?></td>
				<td><?=number_format($lt->use_point)?></td>
				<td><?=$shop_info['trade_method'.$lt->trade_method]?></td>
				<td>
					<?php
					$deliv_total_cnt = $this->common_m->self_q("select * from dh_trade_deliv_info where trade_code = '".$lt->trade_code."' group by deliv_code","cnt");
					$deliv_cnt = $this->common_m->self_q("select * from dh_trade_deliv_info where trade_code = '".$lt->trade_code."' and deliv_stat <> 0 group by deliv_code","cnt");

					echo $deliv_cnt."/".$deliv_total_cnt;
					?>
				</td>
				<td><input type="button" value="보기" onclick="location.href='<?=cdir()?>/order/lists/m/view/<?=$lt->idx?>/'"></td>
			</tr>
			<?php
				$list_cnt--;
			}
		}
		?>
	</tbody>
</table>

<p class="align-c mt40">
	<input type="button" class="btn-m btn-xl" onclick="location.href='<?=cdir()?>/member/user/m/<?=$query_string.$param?>'" value="목록으로"></a>
</p>