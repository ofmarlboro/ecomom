			<ul class="clearfix des_list">
				<?php
				if($list){
					$list_cnt = 0;
					foreach($list as $lt){
						$list_cnt++;
						if($lt->cate_no == '10'){
							?>
							<li class="<?=($list_cnt%2 == 0)?"mr0":"";?>">
								<a href="<?=cdir()?>/dh_product/apply_view/<?=$lt->idx.$query_string.$param?>">
								<?php
								/*
								if($_SERVER['HTTP_X_FORWARDED_FOR'] == "58.229.223.174"){
									?>
									<a href="<?=cdir()?>/dh_product/apply_view/<?=$lt->idx.$query_string.$param?>">
									<?php
								}
								else{
									?>
									<a href="<?=cdir()?>/dh_product/prod_view/<?=$lt->idx.$query_string.$param?>">
									<?php
								}
								*/
								?>
									<img src="/_data/file/goodsImages/<?=$lt->list_img?>" onerror="this.src='/image/default.jpg'">
									<p><?=$lt->name?></p>
								</a>
							</li>
							<?php
						}
						else{
							?>
							<li class="<?=($list_cnt%2 == 0)?"mr0":"";?>">
								<a href="<?=cdir()?>/dh_product/prod_view/<?=$lt->idx.$query_string.$param?>">
									<img src="/_data/file/goodsImages/<?=$lt->list_img?>" onerror="this.src='/image/default.jpg'">
									<p style="height:22px; overflow-y:hidden"><?=$lt->name?></p>
									<b>
										<?if($lt->old_price){?><del><?=number_format($lt->old_price)?><span class="unit">원</span></del>  <?}?>
										<?=number_format($lt->shop_price)?> <span class="unit">원</span>
									</b>
								</a>
							</li>
							<?php
						}
					}
				}
				else{
				?>
				<li class="no_ct">등록된 제품이 없습니다.</li>
				<?php
				}
				?>
			</ul>

			<!-- 페이징 -->
			<?php
			if(count($list) > 0){
			?>
			<div class="board-pager">
				<?=$Page?>
			</div>
			<?php
			}
			?>
			<!-- END 페이징 -->