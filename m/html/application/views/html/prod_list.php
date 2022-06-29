<?
	if(!$this->input->get('cate_no')){
		alert(cdir()."/dh_product/prod_list/?cate_no=3");
	}

	$SubName = "";

	if($this->input->get('cate_no') == 3){
		$PageName = "K04";
	}
	else if($this->input->get('cate_no') == 4){
		$PageName = "K05";
	}
	else if($this->input->get('cate_no') == 5){
		$PageName = "K06";
	}
	else if($this->input->get('cate_no') == 10){
		$PageName = "K02";
		$SubName="K0205";
	}

	if($this->input->get('type')=="nmk"){
		$PageName="K07";
		$SubName="K0704";
	}
	$PageTitle = $$PageName->tit;
	include('../include/head.php');
	include('../include/header.php');
?>

<!--Container-->

<div id="container" style="background-color:#F0F0f0">
	<?include("../include/top_menu.php");?>
	<?include("../include/view_tab.php");?>
	<!-- <h1 class="tit02">
		<?=$$PageName->tit?>
	</h1> -->
	<!-- inner -->
	<div class="pb50">
		<?php
		if($SubName=="K0704"){	//산골야시장
			?>
			<div class="header_img header_img0704">
				<!-- <img src="/_data/file/subinfo/<?=$cate_info->upfile1?>" alt="" style="width:100%; " onerror="this.src='/image/default.jpg'"> -->
				<!-- <span><img src="/m/image/sub/r_circle1-(1).png" alt="당일발송 주문마감 - AM 7:00"></span> -->
				<!-- <button type="button" class="plain" onclick="menuPop();"><img src="/image/sub/r_circle2.png" alt="월별식단표"></button> -->
			</div>
			<?php
		}
		else if($SubName=="K0205"){	//의기양양픽
			?>
			<div class="header_img header_img0205">

			</div>
			<?php
		}
		else{
			?>
			<div class="header_img header_img04">
				<!-- <img src="/_data/file/subinfo/<?=$cate_info->upfile1?>" alt="" style="width:100%; " onerror="this.src='/image/default.jpg'"> -->
				<span><img src="/m/image/sub/r_circle1-(1).png" alt="당일발송 주문마감 - AM 7:00"></span>
				<!-- <button type="button" class="plain" onclick="menuPop();"><img src="/image/sub/r_circle2.png" alt="월별식단표"></button> -->
			</div>
			<?php
		}
		?>
		<!-- 하단 창 -->



		<?include("../include/view_tab03.php");?>

		<div class="bottm_inner">

			<?php
			if($this->input->get('type')!="nmk" && $this->input->get('cate_no') != "10"){
				?>
				<!-- <p class="gray"> ※영양식단(정기배송)을 이용중이면, 무료배송일자를 선택하실 수 있습니다. </p> -->
				<?php
			}
			?>

			<?php
			if($this->input->get('cate_no')=="3"&&$this->input->get('type')!="nmk"){	//산골간식 상단 배너
				if($list_top_banner->upfile1){
					?>
					<div class="pt10">
						<?php
						if($list_top_banner->m_pageurl){
							?>
							<a href="<?=$list_top_banner->m_pageurl?>">
							<?php
						}
						?>

							<img src="/_data/file/banner/<?=$list_top_banner->upfile2?>" onerror="this.src='/_data/file/banner/<?=$list_top_banner->upfile1?>'">

						<?php
						if($list_top_banner->m_pageurl){
							?>
							</a>
							<?php
						}
						?>

					</div>
					<?php
				}
			}

			else if($this->input->get('cate_no')=="3"&&$this->input->get('type')=="nmk"){
				if($list_top_banner->upfile1){
					?>
					<div class="pt10">
						<?php
						if($list_top_banner->m_pageurl){
							?>
							<a href="<?=$list_top_banner->m_pageurl?>">
							<?php
						}
						?>

							<img src="/_data/file/banner/<?=$list_top_banner->upfile2?>" onerror="this.src='/_data/file/banner/<?=$list_top_banner->upfile1?>'">

						<?php
						if($list_top_banner->m_pageurl){
							?>
							</a>
							<?php
						}
						?>

					</div>
					<?php
				}
			}
			?>

			<?php
			include "{$view}.php";
			?>

			<?php
			/*
				<ul class="clearfix des_list">
					<li>
						<a href="<?=cdir()?>/dh/prod_view">
						<img src="/m/image/sub/img01.jpg" alt="">
						<p>산골알밤</p>
						<b>2,300원</b>
						</a>
					</li>
					<li>
						<a href="<?=cdir()?>/dh/prod_view">
						<img src="/m/image/sub/img01.jpg" alt="">
						<p>산골알밤</p>
						<b>2,300원</b>
						</a>
					</li>
					<li class="mr0">
						<a href="">
						<img src="/m/image/sub/img01.jpg" alt="">
						<p>산골알밤</p>
						<b>2,300원</b>
						</a>
					</li>
					<li>
						<a href="<?=cdir()?>/dh/prod_view">
						<img src="/m/image/sub/img01.jpg" alt="">
						<p>산골알밤</p>
						<b>2,300원</b>
						</a>
					</li>
					<li>
						<a href="<?=cdir()?>/dh/prod_view">
						<img src="/m/image/sub/img01.jpg" alt="">
						<p>산골알밤</p>
						<b>2,300원</b>
						</a>
					</li>
					<li class="mr0">
						<a href="<?=cdir()?>/dh/prod_view">
						<img src="/m/image/sub/img01.jpg" alt="">
						<p>산골알밤</p>
						<b>2,300원</b>
						</a>
					</li>
				</ul>

				<!-- 페이징 -->
				<div class="board-pager">
					<button type="button"><img src="/m/image/board_img/arrow_l_end.png" alt="맨 앞으로"></button>
					<button type="button"><img src="/m/image/board_img/arrow_l.png" alt="이전"></button>
					<a href="#" class="on">1</a>
					<a href="#">2</a>
					<a href="#">3</a>
					<button type="button"><img src="/m/image/board_img/arrow_r.png" alt="다음"></button>
					<button type="button"><img src="/m/image/board_img/arrow_r_end.png" alt="맨 뒤로"></button>
				</div>
				<!-- END 페이징 -->
			*/
			?>

		</div>


	</div>
	<!-- inner -->


	<script>

	var flag = null;
		$('.top_arw').on('click',function(e){
            e.preventDefault();
		    if (flag == 1) {
				$(this).find(".arw").css('transform', 'rotate(0deg)');
			  $(this).parent().css('bottom', '0');

                flag = null;
			} else {
				$(this).find(".arw").css('transform', 'rotate(180deg)');
			  $(this).parent().css('bottom', '-342px');
				flag = 1;
			}
        })



	</script>

	<!-- //하단 창 -->

</div>

<!--END Container-->

<? include('../include/footer.php') ?>
