			<!-- 탭메뉴 -->
			<div class="oe_menu order_opt">
				<div class="selbox selbox02">
					<?php
					//if( ($this->input->get('recom_idx') or $this->input->get('cate_no')) and strpos($_SERVER['REQUEST_URI'],"prod_list")===false ){
					if( strpos($_SERVER['REQUEST_URI'],"prod_list")===false and $this->input->get('recom_idx') ){
						?>
						<button type="button" onclick="toggleSelBox(this, event);"><span class="week_day_count_span"><?=$step_arr[$this->input->get('recom_idx')]?></span></button>

						<ul>
							<li class="pe01"><input type="radio" id="pe2" onclick="location.href='/m/html/dh/regular01/?recom_idx=2'"><label for="pe2"><span></span><strong>5개월 전후 </strong> 준비기</label></li>
							<li class="pe04"><input type="radio" id="pe6" onclick="location.href='/m/html/dh/regular01/?recom_idx=6'"><label for="pe6"><span></span><strong>9~12개월 </strong> 후기2식</label></li>
							<li class="pe02"><input type="radio" id="pe4" onclick="location.href='/m/html/dh/regular01/?recom_idx=4'"><label for="pe4"><span></span><strong>5~6개월 </strong> 초기</label></li>
							<li class="pe05"><input type="radio" id="pe1" onclick="location.href='/m/html/dh/regular01/?recom_idx=1'"><label for="pe1"><span></span><strong>9~12개월 </strong> 후기3식</label></li>
							<li class="pe03"><input type="radio" id="pe5" onclick="location.href='/m/html/dh/regular01/?recom_idx=5'"><label for="pe5"><span></span><strong>7~8개월 </strong> 중기</label></li>
							<li class="pe06"><input type="radio" id="pe7" onclick="location.href='/m/html/dh/regular01/?recom_idx=7'"><label for="pe7"><span></span><strong>12개월~ </strong> 완료기</label></li>
							<li><label for="">&nbsp;</label></li>
							<li class="pe07"><input type="radio" id="pe3" onclick="location.href='/m/html/dh/regular01/?recom_idx=3'"><label for="pe3"><span></span><strong>반찬/국</strong></label></li>
						</ul>
						<?php
					}
					else if( strpos($_SERVER['REQUEST_URI'],"prod_list")===false and $this->input->get('cate_no') ){
						?>
						<button type="button" onclick="toggleSelBox(this, event);"><span class="week_day_count_span"><?=$step_arr[$this->input->get('cate_no')]?></span></button>
						<ul>
							<li class="pe01"><input type="radio" id="pe1" onclick="location.href='/m/html/dh/free_list/?cate_no=1-6'"><label for="pe1"><span></span><strong>5개월 전후 </strong> 준비기</label></li>
							<li class="pe04"><input type="radio" id="pe2" onclick="location.href='/m/html/dh/free_list/?cate_no=1-10'"><label for="pe2"><span></span><strong>9~12개월 </strong> 후기</label></li>
							<li class="pe02"><input type="radio" id="pe3" onclick="location.href='/m/html/dh/free_list/?cate_no=1-7'"><label for="pe3"><span></span><strong>5~6개월 </strong> 초기</label></li>
							<li class="pe06"><input type="radio" id="pe4" onclick="location.href='/m/html/dh/free_list/?cate_no=1-11'"><label for="pe4"><span></span><strong>12개월~ </strong> 완료기</label></li>
							<li class="pe03"><input type="radio" id="pe5" onclick="location.href='/m/html/dh/free_list/?cate_no=1-8'"><label for="pe5"><span></span><strong>7~8개월 </strong> 중기준비기</label></li>
							<li class="pe07"><input type="radio" id="pe6" onclick="location.href='/m/html/dh/free_list/?cate_no=2-12'"><label for="pe6"><span></span><strong>반찬 </strong> </label></li>
							<li class="pe03"><input type="radio" id="pe7" onclick="location.href='/m/html/dh/free_list/?cate_no=1-9'"><label for="pe7"><span></span><strong>7~8개월 </strong> 중기</label></li>
							<li class="pe07"><input type="radio" id="pe8" onclick="location.href='/m/html/dh/free_list/?cate_no=2-13'"><label for="pe8"><span></span><strong>국</strong></label></li>
						</ul>
						<?php
					}

					/*
					<button type="button" onClick="toggleSelBox(this, event);"><span class="week_day_count_span"><?=($this->input->get('recom_idx')) ? $step_arr[$this->input->get('recom_idx')] : $step_arr[$this->input->get('cate_no')] ;?></span></button>

					<ul>
						<?php
						foreach($step_arr as $sa_key=>$sa){
							?>
							<li><input type="radio" id="pe<?=$sa_key?>" onclick="location.href='<?=cdir()?>/dh/<?=($this->input->get('recom_idx')) ? "regular01" : "free_list" ;?>/?<?=($this->input->get('recom_idx')) ? "recom_idx" : "cate_no" ;?>=<?=$sa_key?>'"><label for="pe<?=$sa_key?>"><span></span><?=$sa?></label></li>
							<?php
						}
						?>
					</ul>
					*/

					else{
						if($SubName=="K0704"){	//산골야시장
							?>
							<button type="button" style="background:#BCA061;"><span class="week_day_count_span">산골야시장</span></button>
							<?php
						}
						else{
							if($cate_stat1->title){
								?>
								<button type="button" style="background:#BCA061;"><span class="week_day_count_span"><?=$cate_stat1->title?></span></button>
								<?php
							}
							else{
								if($PageName == "SALE_LIST"){
									?>
									<button type="button" style="background:#BCA061;"><span class="week_day_count_span">둥이상품세트</span></button>
									<?php
								}
							}
						}
					}
					?>

				</div>

			</div>
			<script type="text/javascript" src="/js/orderPage.js"></script>
			<!-- //탭메뉴  -->