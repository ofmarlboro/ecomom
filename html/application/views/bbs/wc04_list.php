			<div class="study_c mt0 clearfix">
				<ul class="tabMenu01">
						<li class="<?=(!$this->input->get('cate_idx'))?"on":"";?>"><a href="<?=cdir()?>/dh_board/lists/wc04">전체</a></li>
						<?php
						$cate_cnt = 0;
						foreach($cate_row as $cr){
							$cate_cnt++;
							?>
							<li class="<?=($this->input->get('cate_idx') == $cr->idx)?"on":"";?>"><a href="<?=cdir()?>/dh_board/lists/wc04?cate_idx=<?=$cr->idx?>"><?=$cr->name?></a></li>
							<?php
							if($cate_cnt == 4){
								?>
								</ul>
								<ul class="tabMenu01">
								<?php
							}
						}
						?>
						<li></li>

						<?php
						/*
							<li><a href="#">곡류</a></li>
							<li><a href="#">채소류</a></li>
							<li><a href="#">육류/가금류/난류</a></li>
							<li><a href="#">어패류/해조류</a></li>
							</ul>
							<ul class="tabMenu01">
							<li><a href="#">버섯류/서류</a></li>
							<li><a href="#">과실류/종실/견과류</a></li>
							<li><a href="#">두유/유제품류</a></li>
							<li><a href="#">식용유지류/양념류</a></li>
							<li></li>
						*/
						?>
				</ul>
				<p class="mt30"></p>
				<img src="/image/sub/ico_bg.jpg" alt="">
				<ul class="study_li">
					<?php
					if($list){
						$cnt = 0;
						foreach($list as $lt){
							$cnt++;
							?>
							<li class="<?=($cnt == 1 or ($cnt%3 == 1))?"ml0":"";?>">
								<h1><?=$lt->subject?></h1>
								<p><?=$lt->content?></p>
								<div class="ico_wrap">
									<!-- 클래스명 i01 품목 / i02 원산지정보 / i03 친환경유무 -->
									<?if($lt->addinfo1){?><span class="i01"><?=$lt->addinfo1?></span><?}?>
									<?if($lt->addinfo2){?><span class="i02"><?=$lt->addinfo2?></span><?}?>
									<?if($lt->addinfo3){?><span class="i03"><?=$lt->addinfo3?></span><?}?>
								</div>
							</li>
							<?php
						}
					}
					?>
				</ul>
			</div>

			<?php
			if(count($list) > 0){
				?>
				<div class="board-pager">
					<?=$Page2?>
				</div>
				<?php
			}
			?>

			<form name="bbs_search_form" action="<?=cdir()?>/<?=$this->uri->segment(1)?>/lists/<?=$bbs->code?>/" onSubmit="return false;">
				<div class="board-search">
					<select name="search_item" class="board-search-select">
						<option value="all">전체</option>
						<option value="subject" <?if($this->input->get('search_item')=="subject"){?>selected<?}?>>제목</option>
						<option value="content" <?if($this->input->get('search_item')=="content"){?>selected<?}?>>내용</option>
					</select>
					<input type="text" class="board-search-field" value="<?=$this->input->get('search_order')?>" name="search_order" onKeyDown="SearchInputSendit();">
					<input type="button" value="검색" class="btn-normal-s" onclick="javascript:search();">
				</div>
			</form>