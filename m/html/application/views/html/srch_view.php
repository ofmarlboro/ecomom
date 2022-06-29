<?
	$PageName = "SRCH";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

<!--Container-->

<div id="container">
	<?include("../include/top_menu.php");?>
	<div id="ssch">

		<!-- 상세검색 항목 시작 { -->
		<div id="ssch_frm">
			<form name="pagesch" id="pagesch" onsubmit="frmChk('pagesch');return false;">
				<div>
					<label for="ssch_q" class="ssch_lbl">검색어</label>
					<input type="text" name="sch_value" value="<?=$this->input->get('sch_value')?>" id="ssch_q" class="frm_input" maxlength="30" msg="검색어를">
					<input type="submit" value="검색" class="btn_submit">
				</div>
			</form>

		</div>
		<!-- } 상세검색 항목 끝 -->


		<div class="ac">
				"<strong><?=$this->input->get('sch_value')?></strong>"(으)로 <strong><?=count($list)?></strong>건이 검색되었습니다.
			</div>


		<!-- 검색된 분류 시작 { -->
		<div id="ssch_cate">
			<!-- <ul>
				<li>
					<a href="#" onClick="set_ca_id('10'); return false;">이유식 (58)</a>
				</li>
				<li>
					<a href="#" onClick="set_ca_id(''); return false;">전체분류 <span>(58)</span></a>
				</li>
			</ul> -->
		</div>
		<!-- } 검색된 분류 끝 -->

		<!-- 검색결과 시작 { -->
		<div>
			<div class="mPrdList typeThumb">
				<ul class="grid2">
					<?php
					if($list){
						foreach($list as $lt){
							$cate_no_arr = explode("-",$lt->cate_no);
							$first_cate = $cate_no_arr[0];
						?>
						<li class="item">
							<div class="thumbnail">
								<?php
								if($first_cate < 3){
								?>
								<a href="javascript:menuView('<?=$lt->idx?>');" class="prdImg" data-cate1="<?=$first_cate?>">
								<?php
								}
								else{
								?>
								<a href="<?=cdir()?>/dh_product/prod_view/<?=$lt->idx?>" class="prdImg" data-cate1="<?=$first_cate?>">
								<?php
								}
								?>
								<img src="/_data/file/goodsImages/<?=$lt->list_img?>" width="230" height="230" alt="<?=$lt->name?>" class="thumb zoom_thumb" data-it_id="<?=$lt->code?>" title="">
								</a>
							</div>
							<!--/.thumbnail-->
							<div class="information">
								<p class="name"><a href="#"> <?=$lt->name?> </a></p>
								<p class="price"><?=number_format($lt->shop_price)?>원</p>
							</div>
							<!--/.information-->
						</li>
						<?php
						}
					}
					else{
					?>
					<li class="no-ct">검색 결과가 없습니다.</li>
					<?php
					}
					?>

					<?php
					/*
						<li class="item">
							<div class="thumbnail">
								<a href="#" class="prdImg">
								<img src="http://ecomommeal.co.kr/data/item/1477541789/thumb-15_230x230.png" width="230" height="230" alt="D35. 모듬버섯밀쌀진밥" class="thumb zoom_thumb" data-it_id="1477541789" title="">
								</a>
							</div>
							<!--/.thumbnail-->
							<div class="information">
								<p class="name">
									<a href="#"> D35. 모듬버섯밀쌀진밥 </a>
								</p>
								<p class="price">4,300원</p>


							</div>
							<!--/.information-->
						</li>
						<li class="item">
							<div class="thumbnail">
								<a href="#" class="prdImg">
								<img src="http://ecomommeal.co.kr/data/item/1477541793/thumb-16_230x230.png" width="230" height="230" alt="D36. 발아현미된장마파두부진밥" class="thumb zoom_thumb" data-it_id="1477541793" title="">
								</a>
							</div>
							<!--/.thumbnail-->
							<div class="information">
								<p class="name">
									<a href="#"> D36. 발아현미된장마파두부진밥 </a>
								</p>
								<p class="price">4,300원</p>


							</div>
							<!--/.information-->
						</li>


						<li class="item">
							<div class="thumbnail">
								<a href="#" class="prdImg">
								<img src="http://ecomommeal.co.kr/data/item/1477541789/thumb-15_230x230.png" width="230" height="230" alt="D35. 모듬버섯밀쌀진밥" class="thumb zoom_thumb" data-it_id="1477541789" title="">
								</a>
							</div>
							<!--/.thumbnail-->
							<div class="information">
								<p class="name">
									<a href="#"> D35. 모듬버섯밀쌀진밥 </a>
								</p>
								<p class="price">4,300원</p>


							</div>
							<!--/.information-->
						</li>
						<li class="item">
							<div class="thumbnail">
								<a href="#" class="prdImg">
								<img src="http://ecomommeal.co.kr/data/item/1477541793/thumb-16_230x230.png" width="230" height="230" alt="D36. 발아현미된장마파두부진밥" class="thumb zoom_thumb" data-it_id="1477541793" title="">
								</a>
							</div>
							<!--/.thumbnail-->
							<div class="information">
								<p class="name">
									<a href="#"> D36. 발아현미된장마파두부진밥 </a>
								</p>
								<p class="price">4,300원</p>


							</div>
							<!--/.information-->
						</li>
					*/
					?>
				</ul>
			</div>
			<!-- <div class="board-pager mt20 mb50">
				<button type="button"><img src="/image/board_img/arrow_l_end.gif" alt="맨 앞으로"></button>
				<button type="button"><img src="/image/board_img/arrow_l.gif" alt="이전"></button>
				<a href="#" class="on">1</a>
				<button type="button"><img src="/image/board_img/arrow_r.gif" alt="다음"></button>
				<button type="button"><img src="/image/board_img/arrow_r_end.gif" alt="맨 뒤로"></button>
			</div> -->
		</div>
		<!-- } 검색결과 끝 -->

	</div>
</div>
<!--END Container-->

<? include('../include/footer.php') ?>
