<h5 class="htit"><?=$select_date_ui?> (<?=$select_day_name_ui?>) <span class="desc"><?=$make_date_ui?> <?=$make_day_name_ui?>요일에 조리하여 <?=$select_date_ui?> <?=$select_day_name_ui?>요일에 배송됩니다.</span></h5>
<ul class="sale_menu">
	<?php
	$cnt=0;
	foreach($item_row as $ir){
		$cnt++;
	?>
	<li class="<?=($cnt%2 == 0)?"mr0":"";?>">
		<a class="box" href="javascript:;" onclick="menuView('<?=$ir['goods_idx']?>','N','<?=$deliv_date?>','<?=$ir['price']?>','<?=$ir['name']?>','<?=$ir['origin_price']?>')">
			<span class="img"><img src="/_data/file/goodsImages/<?=$ir['list_img']?>" alt="<?=$ir['name']?>" onerror="this.src='/image/default.jpg'"></span>
			<div class="txt">
				<p class="cate">[둥이상품세트]</p>
				<p class="name"><?=$ir['name']?></p>
				<button type="button" class="plain btn_sel" onclick="add_tmp_cart('<?=$deliv_date?>','<?=$ir['goods_idx']?>','<?=$ir['price']?>','<?=$ir['name']?>','<?=$ir['origin_price']?>')"><img src="/image/sub/btn_select_txt.png" alt="상품선택"></button>
			</div>
		</a>
		<div class="newbox">
			<button type="button" class="plain btn_sel" onclick="add_tmp_cart('<?=$deliv_date?>','<?=$ir['goods_idx']?>','<?=$ir['price']?>','<?=$ir['name']?>','<?=$ir['origin_price']?>')"><img src="/image/sub/btn_select_txt.png" alt="상품선택"></button>
		</div>
	</li>
	<?php
	}
	?>
</ul>