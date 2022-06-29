<?
	$PageName = "K01";
	$SubName = "";
	include("../include/head.php");
	include("../include/header.php");
?>

<!--Container-->

<div id="container">
	<?include("../include/top_menu.php");?>
	<div class="store_intro_wrap">
		<div class="store_intro">
			<div class="inner ">
				<h1>
					<strong>산골이유식 매장, <br>
					</strong> 어디어디 있나요?
				</h1>

				<?php
				/*
				<ul class="mt60" style="border-top: 1px solid #9A9A9A;">
					<?php
					$seoul_cnt = 0;
					foreach($banner as $seoul){
						if($seoul->addinfo5 == "서울"){
							$seoul_cnt++;
						?>
						<li><a href="javascript:;"  onclick="openView('<?=$seoul->idx?>');"><div class="brown"><?=($seoul_cnt == 1)?"[서울]":"";?></div><?=str_replace($bb_Arr,$sr_Arr,$seoul->addinfo1)?></a></li>
						<?php
						}
					}
					?>
				</ul>
				<ul>
					<?php
					$kyungki_cnt = 0;
					foreach($banner as $kyungki){
						if($kyungki->addinfo5 == "경기"){
							$kyungki_cnt++;
						?>
						<li><a href="javascript:;"  onclick="openView('<?=$kyungki->idx?>');"><div class="brown"><?=($kyungki_cnt == 1)?"[경기]":"";?></div><?=str_replace($bb_Arr,$sr_Arr,$kyungki->addinfo1)?></a></li>
						<?php
						}
					}
					?>
				</ul>
				<ul>
					<?php
					$incheon_cnt = 0;
					foreach($banner as $incheon){
						if($incheon->addinfo5 == "인천"){
							$incheon_cnt++;
						?>
						<li><a href="javascript:;"  onclick="openView('<?=$incheon->idx?>');"><div class="brown"><?=($incheon_cnt == 1)?"[인천]":"";?></div><?=str_replace($bb_Arr,$sr_Arr,$incheon->addinfo1)?></a></li>
						<?php
						}
					}
					?>
				</ul>
				<ul class="mb50">
					<?php
					$kyungnam_cnt = 0;
					foreach($banner as $kyungnam){
						if($kyungnam->addinfo5 == "경남"){
							$kyungnam_cnt++;
						?>
						<li><a href="javascript:;"  onclick="openView('<?=$kyungnam->idx?>');"><div class="brown"><?=($kyungnam_cnt == 1)?"[경남]":"";?></div><?=str_replace($bb_Arr,$sr_Arr,$kyungnam->addinfo1)?></a></li>
						<?php
						}
					}
					?>
				</ul>
				*/
				?>

				<?php
				if(count($cate) > 0){
					$cate_cnt = 0;
					foreach($cate as $c){
						$cate_cnt++;

						if($cate_cnt == 1){
							?>
							<ul class="mt60" style="border-top: 1px solid #9A9A9A;">
							<?php
						}

						if($cate_cnt > 1){
							if($cate_cnt == count($cate)){
								?>
								<ul class="mb50">
								<?php
							}
							else{
								?>
								<ul>
								<?php
							}

						}

						$banner_cnt = 0;
						foreach($banner as $b){

							if($c->idx == $b->addinfo5){
								$banner_cnt++;

								if($banner_cnt >= 1){
									?>
									<li><a href="javascript:;"  onclick="openView('<?=$b->idx?>');"><div class="brown"><?=($banner_cnt == 1)?"[".$c->name."]":"";?></div><?=str_replace($bb_Arr,$sr_Arr,$b->addinfo1)?></a></li>
									<?php
								}
							}

						}

						?>
						</ul>
						<?php
					}
				}
				?>
			</div>
		</div>

		<?php
		foreach($banner as $lt){
		?>
		<div class="store_intro openView<?=$lt->idx?>">
			<div class="inner">
				<h2>
					[<?=$lt->cate_name?>] <?=str_replace($bb_Arr,$sr_Arr,$lt->addinfo1)?>
				</h2>
				<div class="mt25">
					<?=$lt->addinfo2?> <br>
					<img src="/m/image/sub/te.png" alt=""><?=$lt->addinfo3?>
				</div>
				<div class="mt30">
					<img src="/_data/file/banner2/<?=$lt->upfile2?>" alt="" onerror="/_data/file/banner2/<?=$lt->upfile1?>">
				</div>
			</div>
		</div>
		<?php
		}
		?>
		<?php
		/*
			<div class="store_intro openView1">
				<div class="inner ">
					<h2>
						[서울] 현대백화점 <strong>압구정본점</strong>
					</h2>
					<div class="mt25">
						가공식품 전체매출 5위권 기록 <br>
						<img src="/m/image/sub/te.png" alt="">02-3449-5597
					</div>
					<div class="mt30">
						<img src="/m/image/sub/Sangol_M_store_06.jpg" alt="">
					</div>
				</div>
			</div>
			<div class="store_intro openView2">
				<div class="inner ">
					<h2>
						[서울] 롯데백화점 <strong>명동본점</strong>
					</h2>
					<div class="mt25">
						7층 유아휴게소 바로 옆 산골이유식 카페 <br>
						<img src="/m/image/sub/te.png" alt="">02-772-3766
					</div>
					<div class="mt30">
						<img src="/m/image/sub/Sangol_M_store_09.jpg" alt="">
					</div>
				</div>
			</div>
			<div class="store_intro openView3">
				<div class="inner ">
					<h2>
						[서울] 롯데마트 <strong>청량리점</strong>
					</h2>
					<div class="mt25">
						롯데마트 6층 하이마트 옆 산골이유식 카페 <br>
						<img src="/m/image/sub/te.png" alt="">02-963-3314
					</div>
					<div class="mt30">
						<img src="/image/sub/ch.jpg" alt="">
					</div>
				</div>
			</div>
			<div class="store_intro openView4">
				<div class="inner ">
					<h2>
						[경기] 현대백화점 <strong>판교점</strong>
					</h2>
					<div class="mt25">
						현대식품관 입구 인근 라운지 카페 <br>
						<img src="/m/image/sub/te.png" alt="">031-5170-1067
					</div>
					<div class="mt30">
						<img src="/m/image/sub/Sangol_M_store_12.jpg" alt="">
					</div>
				</div>
			</div>
			<div class="store_intro openView5">
				<div class="inner ">
					<h2>
						[경기] 롯데마트 <strong>김포한강점</strong>
					</h2>
					<div class="mt25">
						지하1층 플레이타임 앞 <br>
						<img src="/m/image/sub/te.png" alt=""> 031-987-0103
					</div>
					<div class="mt30">
						<img src="/m/image/sub/Sangol_M_store_15.jpg" alt="">
					</div>
				</div>
			</div>
			<div class="store_intro openView6">
				<div class="inner ">
					<h2>
						[경기] 롯데백화점 <strong>안산점</strong>
					</h2>
					<div class="mt25">
						신관 2층 하행 에스컬레이트 앞 <br>
						<img src="/m/image/sub/te.png" alt=""> 031-412-2542
					</div>
					<div class="mt30">
						<img src="/m/image/sub/Sangol_M_store_18.jpg" alt="">
					</div>
				</div>
			</div>
			<div class="store_intro openView7">
				<div class="inner ">
					<h2>
						[경기] 롯데프리미엄아울렛 <strong>기흥점</strong>
					</h2>
					<div class="mt25">
						1층 mom&baby 내 <br>
						<img src="/m/image/sub/te.png" alt=""> 031-8036-3130
					</div>
					<div class="mt30">
						<img src="/m/image/sub/Sangol_M_store_22.jpg" alt="">
					</div>
				</div>
			</div>
			<div class="store_intro openView8">
				<div class="inner ">
					<h2>
						[인천] 현대프리미엄아울렛 <strong>송도점</strong>
					</h2>
					<div class="mt25">
						B1 유아휴게실 내 <br>
						<img src="/m/image/sub/te.png" alt="">032-727-2791
					</div>
					<div class="mt30">
						<img src="/m/image/sub/Sangol_M_store_25.jpg" alt="">
					</div>
				</div>
			</div>
			<div class="store_intro openView9">
				<div class="inner ">
					<h2>
						[인천] 롯데백화점 <strong>인천터미널점 </strong>
					</h2>
					<div class="mt25">
					롯데백화점 인천터미널점 3층 행사장 앞 <br>
						<img src="/m/image/sub/te.png" alt="">032-242-2635
					</div>
					<div class="mt30">
						<img src="/image/sub/00021415.jpg" alt="">
					</div>
				</div>
			</div>
			<div class="store_intro openView10">
				<div class="inner ">
					<h2>
						[경남] 갤러리아백화점 <strong>진주점</strong>
					</h2>
					<div class="mt25">
						지하1층 식품관 앞 <br>
						<img src="/m/image/sub/te.png" alt=""> 055-791-1565
					</div>
					<div class="mt30">
						<img src="/m/image/sub/Sangol_M_store_29.jpg" alt="">
					</div>
				</div>
			</div>
		*/
		?>

	</div>
	<div class="pd20"></div>
</div>
<!--END Container-->
<script>
	function openView(no){

		var y = $(".openView"+no).offset().top;
		$("html, body").animate({ scrollTop: y - 50});


	}

	<?if(@$open_view_no != ""){?>
		openView('<?=@$open_view_no?>');
	<?}?>
</script>
<?include("../include/footer.php");?>
