<!doctype html>
<html lang="ko" style="overflow-x:hidden;">
<head>
	<title>에코맘 산골이유식 : 식단정보수정</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300" rel="stylesheet" type="text/css">
	<link type="text/css" rel="stylesheet" href="/_dhadm/css/@default.css?t=<?=time()?>" />

	<script type="text/javascript" src="/_dhadm/js/jquery-1.9.1.min.js"></script>
	<script src="/_dhadm/js/jquery.min.js"></script>
	<script type="text/javascript" src="/js/jquery-ui.js"></script>
	<script type="text/javascript" src="/_dhadm/js/cal.js"></script>
	<script type="text/javascript" src="/_dhadm/js/jquery.easing.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/placeholders.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/common.js"></script>
	<script type="text/javascript" src="/_dhadm/js/form.js"></script>
	<link href="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/css/select2.min.css" rel="stylesheet" />
	<script src="https://cdnjs.cloudflare.com/ajax/libs/select2/4.0.3/js/select2.min.js"></script>
	<script type="text/javascript">
	$(document).ready(function() {
		//$('select[name=check]').select2();
		//$('select[name=select_it_id2]').select2();
		//$('select[name=select_it_id3]').select2();
		$(".select_jq").select2();
	});
	</script>
	<style type="text/css">
		.cntzero{
			background:#eee;
		}
	</style>
	<script type="text/javascript">
		function list_del(idx){
			if(confirm('삭제 하시겠습니까?')){
				var frm = document.delfrm;
				frm.idx.value = idx;
				frm.submit();
			}
		}

		function prod_cnt_update(idx){

			if(confirm("수정 하시겠습니까?\n수정된 사항은 다시 되돌릴 수 없습니다.")){

				var prod_cnt = $("#cnt"+idx).val();

				$.ajax({
					url:"/html/order/prod_cnt_update/?ajax=1&idx="+idx+"&prod_cnt="+prod_cnt,
					type:"GET",
					cache:false,
					error:function(xhr){
						console.log(xhr.responseText);
					},
					success:function(data){
						if(data == "ok"){
							opener.location.reload();
							location.reload();
						}
						else{
							alert("수정에 실패 하였습니다.");
						}
					}
				});
			}

		}
	</script>
</head>
<body>

	<form method="post" name="delfrm">
		<input type="hidden" name="mode" value="del">
		<input type="hidden" name="idx">
	</form>

	<div style="padding:10px;">
		<?php
		$deliv_code_arr = deliv_code_arr($this->input->get('dcode'));
		$deliv_time = $deliv_code_arr['deliv_time'];
		echo $trade_stat->recom_week_day_count."일분 ".$trade_stat->recom_week_count."주분 ".$trade_stat->recom_week_type;
		if($trade_stat->recom_delivery_sun_type){
			echo "<br>일요일 추가분 : ".numberToweekname($trade_stat->recom_delivery_sun_type);
		}
		?>
		<h1 style="font-size:14px;font-weight:600;">
			<?=date("Y-m-d",$deliv_time)?> (<?=numberToWeekname(date("w",$deliv_time))?>)<br>
			식단 정보 수정 ( <?=$this->input->get('dcode')?> )
		</h1>
		<div class="mt20"></div>

		<form method="post" name="goods_addfrm" id="goods_addfrm">
		<input type="hidden" name="deliv_code" value="<?=$this->input->get('dcode')?>">

		<table class="adm-table">
			<tr>
				<th>식단추가</th>
				<td>
					<select name="goods_idx" class="select_jq" msg="추가하실 상품을">
						<option value="">상품을 선택하세요.</option>
						<?php
						foreach($goods as $gd){
							?>
						<option value="<?=$gd->idx?>@<?=$gd->cate_no?>">[<?=$cate_name_arr[$gd->cate_no]?>] <?=$gd->name?> [<?=$gd->code?>]</option>
							<?php
						}
						?>
					</select>
					<input type="button" value="추가" onclick="frmChk('goods_addfrm')">
				</td>
			</tr>
		</table>
		</form>

		<div class="mt20"></div>
		<table class="adm-table">
			<tr>
				<th>배송일</th>
				<th colspan="2">주문정보</th>
				<th style="width:10%">삭제</th>
			</tr>
			<?php
			$total_prod_cnt = 0;
			foreach($list as $lt){
				$total_prod_cnt += $lt->prod_cnt;
			?>
			<tr>
				<td><?=$lt->deliv_date?></td>
				<td>
					<img src="/_data/file/goodsImages/<?=$lt->list_img?>" onerror="this.src='/image/default.jpg'" style="width:50px;vertical-align:middle">
					<?=$lt->name?>
				</td>
				<td>
					<input type="text" class="width-xs" name="prod_cnt" id="cnt<?=$lt->idx?>" value="<?=$lt->prod_cnt?>">
					<input type="button" class="btn-sm" value="수정" onclick="prod_cnt_update('<?=$lt->idx?>')">
				</td>
				<td><input type="button" class="btn-cancel" value="삭제" onclick="list_del('<?=$lt->idx?>')"></td>
			</tr>
			<?php
			}
			?>
			<tr>
				<td colspan="2"><strong>합계</strong></td>
				<td style="font-size:16px;"><strong><?=$total_prod_cnt?></strong></td>
				<td></td>
			</tr>
		</table>

		<p class="mt50 align-c">
			<button class="btn_cancel" onclick="self.close();">닫기</button>
		</p>
	</div>
</body>
</html>
