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

<script type="text/javascript">
	function a_view(no){
		//$(".as").hide();
		$("#a"+no).toggle();
	}
</script>

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

<!-- <h3 class="icon-list">문의내역</h3> -->
<div class="tab_title_noborder mt20">
	<p class="tab_inner">
		:: 총 <?=count($list)?> 건의 문의내역이 있습니다.
	</p>
</div>


<table class="adm-table v-line align-c">
	<thead>
		<tr>
			<th>No.</th>
			<th>제목</th>
			<th>작성일</th>
			<th>비고</th>
			<th>게시글로이동</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if($list){
			$no = count($list);
			foreach($list as $lt){
			?>
			<tr id="q<?=$no?>" onclick="a_view('<?=$no?>')" style="cursor:pointer">
				<td><?=$no?></td>
				<!-- <td><a href="<?=cdir()?>/board/bbs/withcons07/m/view/<?=$lt->idx?>"><?=$lt->subject?></a></td> -->
				<td><?=$lt->subject?></td>
				<td><?=strDatecut($lt->reg_date,3)?></td>
				<td>
					<?php
					if($lt->com_cnt > 0){
					?>
					<span class="dh_red">답변완료</span>
					<?php
					}
					else{
					?>
					<span class="dh_blue">답변대기중</span>
					<?php
					}
					?>
				</td>
				<td>
					<input type="button" value="이동하기" onclick="location.href='/html/board/bbs/withcons07/m/view/<?=$lt->idx?>/?'">
				</td>
			</tr>
			<tr id="a<?=$no?>" style="display:none;" class="as">
				<td></td>
				<td colspan="4" class="title" style="background:#eee;">
					<?=$lt->content?>

					<?php
					if($lt->com_cnt > 0){
						echo "<p>---------------------------------------------- 답변 ----------------------------------------------</p>";
						foreach($coment_list as $cl){
							if($cl->link == $lt->idx){
								echo nl2br($cl->coment);
							}
						}
					}
					?>

				</td>
			</tr>
			<?php
				$no--;
			}
		}
		else{
		?>
		<tr>
			<td colspan="5" height="50">등록된 문의 내역이 없습니다.</td>
		</tr>
		<?php
		}
		?>
	</tbody>
</table>