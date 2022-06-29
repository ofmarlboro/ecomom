				<h3><?=$select_date_ui?> (<?=$select_day_name_ui?>)</h3>
				<ul class="clearfix sam_list">
					<?php
					$cnt = 0;
					foreach($item_row as $ir){
						$cnt++;
					?>
					<li class="<?=($cnt%2 == 0)?" mr0":"";?>">
						<!-- <img src="/_data/file/goodsImages/<?=$ir['list_img']?>" alt="<?=$ir['name']?>의 이미지" onerror="this.src='/image/default.jpg'" onclick="location.href='<?=cdir()?>/dh/pro_view/?idx=<?=$ir['goods_idx']?>'"> -->
						<img src="/_data/file/goodsImages/<?=$ir['list_img']?>" alt="<?=$ir['name']?>의 이미지" onerror="this.src='/image/default.jpg'" onclick="menuView('<?=$ir['goods_idx']?>','N','<?=$deliv_date?>','<?=$ir['price']?>','<?=$ir['name']?>','<?=$ir['origin_price']?>')">
						<p><span>[둥이상품세트]</span><br><?=$ir['name']?></p>
						<a href="javascript:;" class="btn_g" onclick="add_tmp_cart('<?=$deliv_date?>','<?=$ir['goods_idx']?>','<?=$ir['price']?>','<?=$ir['name']?>','<?=$ir['origin_price']?>')">상품선택</a>
					</li>
					<?php
					}
					?>
				</ul>
