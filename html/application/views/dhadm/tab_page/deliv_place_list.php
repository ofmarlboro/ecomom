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

	.adm-table h1{
		font-weight:600;
		color:blue;
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

<!-- <h3 class="icon-list">배송지 관리</h3> -->
<div class="tab_title_noborder">
	<p class="tab_inner">
		“<?=$row->name?>” 님의 배송지 등록관리입니다.
	</p>
</div>

<?php
//pr($addr_arr);
?>

<script type="text/javascript">
	function regi_addr_pop(type){
		window.open("/html/dh/address_add/?idx=<?=$row->idx?>&type="+type,"addr_manage","width=600, height=600");
	}

	function edit_addr_pop(type){
		window.open("/html/dh/address_add/?idx=<?=$row->idx?>&mode=edit&type="+type,"addr_manage_edit","width=600, height=600");
	}
</script>

<table class="adm-table">
	<colgroup>
		<col style="width:33%">
		<col style="width:33%">
		<col style="width:33%">
	</colgroup>
	<tr>
		<?php
		$addr_cnt = 0;
		foreach($addr_arr as $key=>$addr){
			$addr_cnt++;
			if($addr['use']){
				//http://dh486.myelhub.com/html/dh/address_add/?idx=3&mode=edit&type=home
				?>
				<td>
					<h1>#<?=$addr['text']?></h1>
					<p class="pp">받으시는 분 : <?=$addr['name']?></p>
					<p>(<?=$addr['zipcode']?>) <?=$addr['addr1']?> <?=$addr['addr2']?></p>
					<p class="pp">Phone : <?=$addr['phone1']?>-<?=$addr['phone2']?>-<?=$addr['phone3']?></p>
					<a href="javascript:;" class="edit" onclick="edit_addr_pop('<?=$key?>')">수정</a>
				</td>
				<?php
			}
			else{
				//http://dh486.myelhub.com/html/dh/address_add/?idx=3&type=chin
				?>
				<td>
					<h1>#<?=$addr['text']?></h1>
					<p style="text-align:center;cursor:pointer" onclick="regi_addr_pop('<?=$key?>')">
						<img src="/image/sub/adrs_bg.jpg" alt="">
					</p>
				</td>
				<?php
			}

			if($addr_cnt%3 == 0){
				echo "</tr><tr>";
			}
		}
		?>
	</tr>
</table>

<p class="align-c mt40">
	<input type="button" class="btn-m btn-xl" onclick="location.href='<?=cdir()?>/member/user/m/<?=$query_string.$param?>'" value="목록으로"></a>
</p>
