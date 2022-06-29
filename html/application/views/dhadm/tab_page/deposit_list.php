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

<!-- <h3 class="icon-list">예치금내역</h3> -->
<div class="tab_title_noborder mt20">
	<p class="tab_inner">
		“<span><?=$row->name?></span>”님의 보유 예치금은 <span class="blue"><?=number_format($total_point)?></span>원 입니다.
	</p>
</div>

<table class="adm-table v-line align-c">
	<thead>
		<tr>
			<th>일시</th>
			<th>내용</th>
			<th>예치금획득</th>
			<th>예치금사용</th>
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