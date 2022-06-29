		<div class="m_pop_wrap">
			<div class="dim">
			</div>
			<a href="#" class="b_arw"></a>
			<a href="#" class="close03"><img src="/image/main/close.png" alt=""></a>
			<div class="m_pop" style="">
				<?php
				foreach($list as $lt){
					?>
					<div class="item">
						<h1>
							<?=$lt->addinfo1?>
						</h1>
						<img src="/_data/file/banner/<?=$lt->upfile2?>" alt="" onclick="<?if($lt->m_target == "blank"){ if($lt->m_pageurl){?>window.open('<?=$lt->m_pageurl?>','','')<?} }else{ if($lt->m_pageurl){?>location.href='<?=$lt->m_pageurl?>'<?} }?>">

					</div>
					<?php
				}
				?>
			</div>
		</div>