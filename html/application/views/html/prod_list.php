<?
	if(!$this->input->get('cate_no')){
		alert(cdir()."/dh_product/prod_list/?cate_no=3");
	}

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
		$SubName = "K0205";
	}

	if($this->input->get('type')=="nmk"){
		$PageName="K07";
		$SubName="K0704";
	}

	include("../include/head.php");
	include("../include/header.php");
?>

	<!--Container-->
	<div id="container">
		<?include("../include/sub_top.php");?>
		<?include("../include/cate_info.php");?>

		<?php
		if($this->input->get('cate_no')=="3"&&$this->input->get('type')!="nmk"){	//산골간식 상단 배너
			if($list_top_banner->upfile1){
				?>
				<div class="inner">
					<div class="align-c mt10 ml25 mr25">
						<?php
						if($list_top_banner->pageurl){
							?>
							<a href="<?=$list_top_banner->pageurl?>">
							<?php
						}
						?>
							<img src="/_data/file/banner/<?=$list_top_banner->upfile1?>" alt="" style="width:1150px; height:200px">
						<?php
						if($list_top_banner->pageurl){
							?>
							</a>
							<?php
						}
						?>
					</div>
				</div>
				<?php
			}
		}

		else if($this->input->get('cate_no')=="3"&&$this->input->get('type')=="nmk"){
			if($list_top_banner->upfile1){
				?>
				<div class="inner">
					<div class="align-c mt10 ml25 mr25">
						<?php
						if($list_top_banner->pageurl){
							?>
							<a href="<?=$list_top_banner->pageurl?>">
							<?php
						}
						?>
							<img src="/_data/file/banner/<?=$list_top_banner->upfile1?>" alt="" style="width:1150px; height:200px">
						<?php
						if($list_top_banner->pageurl){
							?>
							</a>
							<?php
						}
						?>
					</div>
				</div>
				<?php
			}
		}
		?>

		<div class="content inner">

			<?php
			include "{$view}.php";
			?>

			<?php
			/*
				<ul class="prod_list">
					<!-- <li class="no_ct">등록된 제품이 없습니다.</li> -->
					<li><a href="prod_view.php">
							<span class="img"><img src="/image/sub/snack2_1.jpg" alt=""></span>
							<p class="name">산골알밤</p>
							<p class="price"><em>2,300</em>원</p>
						</a>
					</li>
					<li><a href="prod_view.php">
							<span class="img"><img src="/image/sub/snack2_2.jpg" alt=""></span>
							<p class="name">산골알밤</p>
							<p class="price"><em>2,300</em>원</p>
						</a>
					</li>
					<li><a href="prod_view.php">
							<span class="img"><img src="/image/sub/snack2_3.jpg" alt=""></span>
							<p class="name">산골알밤</p>
							<p class="price"><em>2,300</em>원</p>
						</a>
					</li>
					<li><a href="prod_view.php">
							<span class="img"><img src="/image/sub/snack2_2.jpg" alt=""></span>
							<p class="name">산골알밤</p>
							<p class="price"><em>2,300</em>원</p>
						</a>
					</li>
					<li class="mr0"><a href="prod_view.php">
							<span class="img"><img src="/image/sub/snack2_1.jpg" alt=""></span>
							<p class="name">산골알밤</p>
							<p class="price"><em>2,300</em>원</p>
						</a>
					</li>
					<li><a href="prod_view.php">
							<span class="img"><img src="/image/sub/snack2_1.jpg" alt=""></span>
							<p class="name">산골알밤</p>
							<p class="price"><em>2,300</em>원</p>
						</a>
					</li>
					<li><a href="prod_view.php">
							<span class="img"><img src="/image/sub/snack2_2.jpg" alt=""></span>
							<p class="name">산골알밤</p>
							<p class="price"><em>2,300</em>원</p>
						</a>
					</li>
					<li><a href="prod_view.php">
							<span class="img"><img src="/image/sub/snack2_3.jpg" alt=""></span>
							<p class="name">산골알밤</p>
							<p class="price"><em>2,300</em>원</p>
						</a>
					</li>
					<li><a href="prod_view.php">
							<span class="img"><img src="/image/sub/snack2_2.jpg" alt=""></span>
							<p class="name">산골알밤</p>
							<p class="price"><em>2,300</em>원</p>
						</a>
					</li>
					<li class="mr0"><a href="prod_view.php">
							<span class="img"><img src="/image/sub/snack2_1.jpg" alt=""></span>
							<p class="name">산골알밤</p>
							<p class="price"><em>2,300</em>원</p>
						</a>
					</li>
					<li><a href="prod_view.php">
							<span class="img"><img src="/image/sub/snack2_1.jpg" alt=""></span>
							<p class="name">산골알밤</p>
							<p class="price"><em>2,300</em>원</p>
						</a>
					</li>
					<li><a href="prod_view.php">
							<span class="img"><img src="/image/sub/snack2_2.jpg" alt=""></span>
							<p class="name">산골알밤</p>
							<p class="price"><em>2,300</em>원</p>
						</a>
					</li>
					<li><a href="prod_view.php">
							<span class="img"><img src="/image/sub/snack2_3.jpg" alt=""></span>
							<p class="name">산골알밤</p>
							<p class="price"><em>2,300</em>원</p>
						</a>
					</li>
					<li><a href="prod_view.php">
							<span class="img"><img src="/image/sub/snack2_2.jpg" alt=""></span>
							<p class="name">산골알밤</p>
							<p class="price"><em>2,300</em>원</p>
						</a>
					</li>
					<li class="mr0"><a href="prod_view.php">
							<span class="img"><img src="/image/sub/snack2_1.jpg" alt=""></span>
							<p class="name">산골알밤</p>
							<p class="price"><em>2,300</em>원</p>
						</a>
					</li>
					<li><a href="prod_view.php">
							<span class="img"><img src="/image/sub/snack2_1.jpg" alt=""></span>
							<p class="name">산골알밤</p>
							<p class="price"><em>2,300</em>원</p>
						</a>
					</li>
					<li><a href="prod_view.php">
							<span class="img"><img src="/image/sub/snack2_2.jpg" alt=""></span>
							<p class="name">산골알밤</p>
							<p class="price"><em>2,300</em>원</p>
						</a>
					</li>
					<li><a href="prod_view.php">
							<span class="img"><img src="/image/sub/snack2_3.jpg" alt=""></span>
							<p class="name">산골알밤</p>
							<p class="price"><em>2,300</em>원</p>
						</a>
					</li>
					<li><a href="prod_view.php">
							<span class="img"><img src="/image/sub/snack2_2.jpg" alt=""></span>
							<p class="name">산골알밤</p>
							<p class="price"><em>2,300</em>원</p>
						</a>
					</li>
					<li class="mr0"><a href="prod_view.php">
							<span class="img"><img src="/image/sub/snack2_1.jpg" alt=""></span>
							<p class="name">산골알밤</p>
							<p class="price"><em>2,300</em>원</p>
						</a>
					</li>
				</ul>

				<!-- 페이징 -->
				<div class="board-pager">
					<button type="button"><img src="/image/board_img/arrow_l_end.gif" alt="맨 앞으로"></button>
					<button type="button"><img src="/image/board_img/arrow_l.gif" alt="이전"></button>
					<a href="#" class="on">1</a>
					<a href="#">2</a>
					<a href="#">3</a>
					<a href="#">4</a>
					<a href="#">5</a>
					<button type="button"><img src="/image/board_img/arrow_r.gif" alt="다음"></button>
					<button type="button"><img src="/image/board_img/arrow_r_end.gif" alt="맨 뒤로"></button>
				</div>
				<!-- END 페이징 -->
			*/
			?>

		</div>
	</div><!--END Container-->

<?include("../include/footer.php");?>
