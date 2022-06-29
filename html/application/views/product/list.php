			<ul class="prod_list prod_list01">
				<?php
				if($list){
					$list_cnt = 0;
					foreach($list as $lt){
						$list_cnt++;
						if($lt->cate_no == '10'){	//의기양양 리스트
							?>
							<li class="<?=($list_cnt%3 == 0)?"mr0":"";?>">
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
								<!-- <a href="<?=cdir()?>/dh_product/prod_view/<?=$lt->idx.$query_string.$param?>">
								<a href="<?=cdir()?>/dh_product/apply_view/<?=$lt->idx.$query_string.$param?>"> -->
								*/
								?>
									<span class="img-yky"><img src="/_data/file/goodsImages/<?=$lt->list_img?>" alt="<?=$lt->name?>" onerror="this.src='/image/default.jpg'"></span>
									<p class="name"><?=$lt->name?></p>
								</a>
							</li>
							<?php
						}
						else{
							?>
							<li class="<?=($list_cnt%3 == 0)?"mr0":"";?>">
								<a href="<?=cdir()?>/dh_product/prod_view/<?=$lt->idx.$query_string.$param?>">
									<span class="img"><img src="/_data/file/goodsImages/<?=$lt->list_img?>" alt="<?=$lt->name?>" onerror="this.src='/image/default.jpg'"></span>
									<p class="name"><?=$lt->name?></p>
									<p class="price">
										<?if($lt->old_price){?><del><?=number_format($lt->old_price)?></del> <span class="unit">원</span> <img src="/image/sub/ar.jpg" alt=""><?}?>
										<em><?=number_format($lt->shop_price)?></em>원
									</p>
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