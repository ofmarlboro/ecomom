<script type="text/javascript">
<!--
	alert("샘플서비스는 2020년 6월 30일 부로 종료 되었습니다.");
	location.href="/html/dh_board/views/50517";
//-->
</script>
<?
	$PageName = "K02";
	$SubName = "K0204";
	include("../include/head.php");
	include("../include/header.php");
?>
	<script type="text/javascript" src="/js/orderPage.js"></script>
	<script type="text/javascript">
	<!--
		function sample_apply(gidx){
			frmChk('sample_frm_'+gidx);
		}
	//-->
	</script>




	<!-- 레이어 팝업 -->

	<script type="text/javascript">
		$(function(){
			$(".popup__layer, .layer__close").on("click", function(){
				$(".popup__wrap").hide();

				return false;
			})
		})
	</script>


	<div class="popup__wrap">
		<a href="https://ecomommeal.co.kr/html/dh_board/views/50517?" class="sample__popup">
			<div class="layer__close"></div>
		</a>
		<div class="popup__layer"></div>
	</div>

	<!-- $레이어 팝업 -->





	<!--Container-->
	<div id="container">
		<?include("../include/sub_top.php");?>
		<?include("../include/cate_info.php");?>

		<div class="inner sample_info">
			<p class="desc">에코맘의 이유식을 부담없이 먼저 체험해보세요! 매일 선착순 20분에게 샘플을 보내드립니다.</p>

			<?php
			if(!$sample_orderable){
			?>
			<div class="box pr0">
				<p><img src="/image/sub/sample_speaker.png" alt="" class="img-mid mr10">
					금일 <em>샘플신청은 없습니다.</em>
				</p>
			</div>
			<?php
			}
			else{
			?>
			<!-- 평일 -->
			<div class="box">
				<p><img src="/image/sub/sample_speaker.png" alt="" class="img-mid mr10">
					금일 신청하신 샘플은 <em><?=$sample_deliv_date_text?></em> <span class="dh_orange">(<?=$sample_deliv_date_week_name?>요일)</span>에 배송됩니다.
				</p>

				<?php
				if($sample_cnt > 0){
				?>
				<p class="status"><?=date("m월 d일")?> 신청가능 <?=$sample_cnt?>건</p>
				<?php
				}
				else{
				?>
				<p class="status off"><?=date("m월 d일")?> 샘플신청 마감</p>
				<?php
				}
				?>
			<?php
			}
			?>
		</div>

		<!-- 주문옵션 WRAP -->
		<div class="inner order_wrap">
			<!-- 식단/메뉴 리스트 영역 -->
			<div class="order_sched_wrap">
				<!-- 메뉴 리스트 -->
				<div class="sched_menu_box mt0">
					<div class="day_group" id="dgroup1">
						<ul class="sale_menu">
							<?php
							if($sample_list){
								$sl_cnt = 0;
								foreach($sample_list as $sl){
									$sl_cnt++;
								?>
							<li class="<?=($sl_cnt%2 == 0)?"mr0":"";?>">
								<form name="sample_frm_<?=$sl->idx?>" id="sample_frm_<?=$sl->idx?>" action="<?=cdir()?>/dh_order/sample_cart" method="post">
									<input type="hidden" name="userid" value="<?=$this->session->userdata('USERID')?>">
									<input type="hidden" name="code" value="<?=$this->session->userdata('CART')?>">
									<input type="hidden" name="goods_name" value="<?=$sl->name?>">
									<input type="hidden" name="deliv_addr" value="home">
									<input type="hidden" name="date_bind" value="<?=$sample_deliv_date?>">
									<input type="hidden" name="goods_idx" value="<?=$sl->idx?>">
									<input type="hidden" name="goods_origin_price" value="0">
									<input type="hidden" name="goods_price" value="0">
									<input type="hidden" name="goods_cnt" value="1">
									<input type="hidden" name="total_price" value="0">
								</form>

								<a class="box sam_box" href="
								<?
								if($sample_orderable and date("H:i") >= "09:00" and date("H:i") <= "11:00" and $sample_call){
									if($this->session->userdata('USERID')){
									?>
									javascript:sample_apply('<?=$sl->idx?>');
									<?
									}
									else{
									?>
									javascript:alert('로그인 후 주문해 주세요.');location.href='/html/dh_member/login';
									<?php
									}
								}
								else{
									if(!$sample_orderable){
									?>
									javascript:alert('주문이 불가능 합니다.');
									<?
									}
									else if(!$sample_call){
										if($user_trade_cnt){
										?>
										javascript:alert('샘플은 한 ID당 1번만 신청 가능합니다.');
										<?
										}
										else{
										?>
										javascript:alert('샘플신청이 마감되었습니다.');
										<?
										}
									}
									else{
									?>
									javascript:alert('오전 9시 부터 신청 가능합니다.');
									<?php
									}
								}
								?>"
								style="height:unset;">
									<span class="img"><img src="/_data/file/goodsImages/<?=$sl->list_img?>" alt="<?=$sl->name?>" onerror="this.src='/image/default.jpg'"></span>
									<div class="txt">
										<p class="name" style="width:110px"><?=$sl->name?></p>
										<?php
										if($sample_orderable){
											?>
											<button type="button" class="plain btn_sel"><img src="/image/sub/btn_select_txt.png" alt="상품선택"></button>
											<?php
										}
										?>
									</div>
								</a>
							</li>
								<?php
								}
							}
							?>

							<?php
							/*
								<li><a class="box" href="#">
										<span class="img"><img src="/image/sub/sale_prod1.jpg" alt="초기 6팩 set"></span>
										<div class="txt">
											<p class="name">이유식 초기</p>
											<button type="button" class="plain btn_sel"><img src="/image/sub/btn_select_txt.png" alt="상품선택"></button>
										</div>
									</a>
								</li>
								<li class="mr0"><a class="box" href="#">
										<span class="img"><img src="/image/sub/sale_prod2.jpg" alt="초기 6팩 set"></span>
										<div class="txt">
											<p class="name">이유식 중기</p>
											<button type="button" class="plain btn_sel"><img src="/image/sub/btn_select_txt.png" alt="상품선택"></button>
										</div>
									</a>
								</li>
								<li><a class="box" href="#">
										<span class="img"><img src="/image/sub/sale_prod1.jpg" alt="초기 6팩 set"></span>
										<div class="txt">
											<p class="name">이유식 후기</p>
											<button type="button" class="plain btn_sel"><img src="/image/sub/btn_select_txt.png" alt="상품선택"></button>
										</div>
									</a>
								</li>
								<li class="mr0"><a class="box" href="#">
										<span class="img"><img src="/image/sub/sale_prod2.jpg" alt="초기 6팩 set"></span>
										<div class="txt">
											<p class="name">이유식 완료기</p>
											<button type="button" class="plain btn_sel"><img src="/image/sub/btn_select_txt.png" alt="상품선택"></button>
										</div>
									</a>
								</li>
							*/
							?>
						</ul>
					</div>
				</div><!-- END 메뉴 리스트 -->
			</div><!-- END 식단/메뉴 리스트 영역 -->

			<!-- 선택 옵션영역 -->
			<div class="order_opt_wrap">
				<div class="order_opt_tint">
					<h4 class="h_tit">샘플 신청 리스트</h4>
					<p class="h_desc">샘플신청은 오전 9시부터 선착순으로진행됩니다.</p>

					<ul class="sample_applier">
						<?php
						if($sample_order_user_list){
							$sl_cnt = 0;
							foreach($sample_order_user_list as $sl){
								$sl_cnt++;
							?>
							<li><?=$sl_cnt?>. <?=preg_replace('/.(?!..)/u','○',$sl->name);?>님 <?=$sl->goods_name?></li>
							<?php
							}
						}
						else{
						?>
						<li class="no_ct">오늘 샘플 신청내역이 없습니다.</li>
						<?php
						}
						?>

						<?php
						/*
						<!-- <li class="no_ct">오늘 샘플 신청내역이 없습니다.</li> -->
						<li>1. 홍*동 이유식 초기</li>
						<li>2. 홍*동 이유식 초기</li>
						<li>3. 홍*동 이유식 초기</li>
						<li>4. 홍*동 이유식 초기</li>
						<li>5. 홍*동 이유식 초기</li>
						<li>6. 홍*동 이유식 초기</li>
						<li>7. 홍*동 이유식 초기</li>
						<li>8. 홍*동 이유식 초기</li>
						*/
						?>
					</ul>
				</div>

				<div class="order_opt_tint">
					<h4 class="h_tit">샘플신청 대기 리스트</h4>
					<p class="h_desc">하단 리스트는 장바구니에 담으신 후, 미결제 고객으로,<br>선착순 20명 안에 빠르게 결제하신 고객만 정상적으로 샘플을 받으실 수 있습니다. 이후 고객은 결제가 되지 않으니 참고부탁드립니다</p>

					<ul class="sample_applier">
						<?php
						if($sample_order_hold_user_list){
							$sl_cnt = 0;
							foreach($sample_order_hold_user_list as $sl){
								$sl_cnt++;
							?>
							<li><?=$sl_cnt?>. <?=preg_replace('/.(?!..)/u','○',$sl->name);?>님 <?=$sl->goods_name?></li>
							<?php
							}
						}
						else{
						?>
						<li class="no_ct">오늘 샘플 신청내역이 없습니다.</li>
						<?php
						}
						?>
					</ul>
				</div>
			</div>
			<!-- END 선택 옵션영역 -->

		</div><!-- END 주문옵션 WRAP -->
	</div><!--END Container-->

<?include("../include/footer.php");?>