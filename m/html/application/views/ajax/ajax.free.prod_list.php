<?php
/*
							<!--
								*3n개째 li.mr0
								*알러지 체크에 해당할 때 li.alrg / span.alrg_mark 부분 추가
								*제외됐을 때 li.except
							-->

				<h3><?=$select_date_ui?> (<?=$select_day_name_ui?>)</h3>
				<ul class="clearfix">
					<?php
					$cnt = 0;
					foreach($item_row as $ir){
						$cnt++;
						$prod_allergy_arr = explode("^",substr($ir['allergys'],0,-1));
					?>
					<li class="<?=($cnt%2 == 0)?" mr0":"";?><?=($prod_allergy_arr[0] != "" and array_intersect($allergys,$prod_allergy_arr))?" alrg":"";?>">
						<div class="box">
							<span class="img"><img src="/_data/file/goodsImages/<?=$ir['list_img']?>" alt="<?=$ir['name']?>의 이미지" onerror="this.src='/image/default.jpg'"></span>
							<?php
							if($prod_allergy_arr[0] != "" and array_intersect($allergys,$prod_allergy_arr)){
								?>
								<span class="alrg_mark">[체질에 따라 알러지를 유발할 수 있습니다.]</span>
								<?php
							}
							?>
							<em class="tit"><?=$ir['name']?></em>
							<a href="javascript:;" class="btn_g" onclick="add_tmp_cart('<?=$deliv_date?>','<?=$ir['goods_idx']?>','<?=$ir['price']?>','<?=$ir['name']?>','<?=$ir['origin_price']?>')">상품선택</a>
							<a href="javascript:;" class="btn_y">상세보기</a>
						</div>
					</li>
					<?php
					}
					?>
				</ul>

*/
?>

				<h3><?=$select_date_ui?> (<?=$select_day_name_ui?>)</h3>
				<form method="post" name="list_all" id="list_all">
				<ul class="clearfix">
					<?php
					$cnt = 0;
					foreach($item_row as $ir){
						$cnt++;
						$prod_allergy_arr = explode("^",substr($ir['allergys'],0,-1));
					?>
					<li class="<?=($cnt%2 == 0)?" mr0":"";?>">
						<input type="hidden" name="deliv_date" value="<?=$deliv_date?>">
						<input type="hidden" name="goods_idx[]" value="<?=$ir['goods_idx']?>">
						<input type="hidden" name="price[]" value="<?=$ir['price']?>">
						<input type="hidden" name="name[]" value="<?=$ir['name']?>">
						<input type="hidden" name="origin_price[]" value="<?=$ir['origin_price']?>">
						<img src="/_data/file/goodsImages/<?=$ir['list_img']?>" alt="<?=$ir['name']?>의 이미지" onerror="this.src='/image/default.jpg'">
						<?php
						if($prod_allergy_arr[0] != "" and array_intersect($allergys,$prod_allergy_arr)){
							?>
							<span class="alrg_mark">[체질에 따라 알러지를 유발할 수 있습니다.]</span>
							<?php
						}
						?>
						<p><?=$ir['name']?></p>
						<a href="javascript:;" class="btn_g" onclick="add_tmp_cart('<?=$deliv_date?>','<?=$ir['goods_idx']?>','<?=$ir['price']?>','<?=$ir['name']?>','<?=$ir['origin_price']?>')">상품선택</a>
						<!-- <a href="<?=cdir()?>/dh/pro_view/?idx=<?=$ir['goods_idx']?>" class="btn_y">상세보기</a> -->
						<a href="javascript:;" class="btn_y" onclick="menuView('<?=$ir['goods_idx']?>','N','<?=$deliv_date?>','<?=$ir['price']?>','<?=$ir['name']?>','<?=$ir['origin_price']?>');">상세보기</a>
					</li>
					<?php
					}
					?>
				</ul>
				</form>