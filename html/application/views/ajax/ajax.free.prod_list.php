<?php
/*
							<!--
								*3n개째 li.mr0
								*알러지 체크에 해당할 때 li.alrg / span.alrg_mark 부분 추가
								*제외됐을 때 li.except
							-->
*/
?>
<div class="day_group" id="dgroup1">
	<h5 class="htit"><?=$select_date_ui?> (<?=$select_day_name_ui?>) <span class="desc"><?=$make_date_ui?> <?=$make_day_name_ui?>요일에 조리하여 <?=$select_date_ui?> <?=$select_day_name_ui?>요일에 배송됩니다.</span></h5>
	<ul class="sched_menu">
		<?php
		$cnt = 0;
		foreach($item_row as $ir){
			$cnt++;
			$prod_allergy_arr = explode("^",substr($ir['allergys'],0,-1));
		?>
		<li class="<?=($cnt%3 == 0)?" mr0":"";?><?=($prod_allergy_arr[0] != "" and array_intersect($allergys,$prod_allergy_arr))?" alrg":"";?>">
			<div class="box">
				<span class="img">
					<?php
					if($ir['list_img']){
					?>
					<img src="/_data/file/goodsImages/<?=$ir['list_img']?>" alt="<?=$ir['name']?>의 이미지">
					<?php
					}
					else{
					?>
					<img src="/image/default.jpg" alt="<?=$ir['name']?>의 이미지">
					<?php
					}
					?>
				</span>
				<?php
				if($prod_allergy_arr[0] != "" and array_intersect($allergys,$prod_allergy_arr)){
					?>
					<span class="alrg_mark">[체질에 따라 알러지를 유발할 수 있습니다.]</span>
					<?php
				}
				?>
				<em class="tit"><?=$ir['name']?></em>
				<div class="select">
					<button type="button" class="plain" onclick="add_tmp_cart('<?=$deliv_date?>','<?=$ir['goods_idx']?>','<?=$ir['price']?>','<?=$ir['name']?>','<?=$ir['origin_price']?>')"><img src="/image/sub/btn_select.png" alt="상품선택"></button>
					<button type="button" class="plain" onclick="menuView('<?=$ir['goods_idx']?>','N','<?=$deliv_date?>','<?=$ir['price']?>','<?=$ir['name']?>','<?=$ir['origin_price']?>');"><img src="/image/sub/btn_detail.png" alt="상세보기"></button>
				</div>
			</div>
		</li>
		<?php
		}
		?>
	</ul>
</div>