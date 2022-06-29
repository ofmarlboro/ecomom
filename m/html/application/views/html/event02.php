<?
	$PageName = "EVENT";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>
<script type="text/javascript">
	//해시태그 넘어온값 받아서 클릭 효과 부여함
	var hashtag = location.hash.substring(1, location.hash.length).replace(/ /gi, '%20');
	if(hashtag){
		$(function(){
			$("h6."+hashtag).trigger('click');
		});
	}


	jQuery(document).ready(function($){




		$(".cont04").slick({
			dots:true
		});
		});


</script>

<!--Container-->

<div id="container">
	<?include("../include/top_menu.php");?>
	<div class="in_re">
		<div class="ac inner">
			<img src="/m/image/sub/M_site_Review_18_12_03.jpg" alt="" style="width:323.5px">

			<?php
			if($insta1[0]->banner_title){
				?>
				<div class="review_head ac">
					<h1>
						<?=$insta1[0]->banner_title?>
					</h1>
					<img src="/image/main/insta.png" alt="">인스타에
					<div class="blue">
						#산골이유식
					</div>
					태그하고 <br>
					리뷰를 올려준 산골맘님의 ‘리얼후기’를 소개해요!<br>
					매월, 동영상후기5분, 포토후기5분 총 10분을 선정합니다
				</div>
				<ul class="ty01">
					<?php
					foreach($insta1 as $i1){
						?>
						<li>
							<img src="/_data/file/banner2/<?=$i1->upfile2?>" alt="" onerror="/_data/file/banner2/<?=$i1->upfile1?>">
							<div class="txt">
								<h2>
									<?=$i1->addinfo1?>
								</h2>
								<div class="text">
									<?=nl2br($i1->addinfo2)?>
								</div>
								<div class="brown">
									<?=$i1->addinfo3?>
								</div>
							</div>
						</li>
						<?php
					}
					?>
				</ul>
				<?php
			}
			?>

			<?php
			if($insta2[0]->banner_title){
				?>
				<div class="review_head ac">
					<h1 class="mb0">
						<?=$insta2[0]->banner_title?>
					</h1>
				</div>
				<ul class="ty01">
					<?php
					foreach($insta2 as $i2){
						?>
						<li>
							<img src="/_data/file/banner2/<?=$i2->upfile2?>" alt="" onerror="/_data/file/banner2/<?=$i2->upfile1?>">
							<div class="txt">
								<h2>
									<?=$i2->addinfo1?>
								</h2>
								<div class="text">
									<?=nl2br($i2->addinfo2)?>
								</div>
								<div class="brown">
									<?=$i2->addinfo3?>
								</div>
							</div>
						</li>
						<?php
					}
					?>
				</ul>
				<?php
			}
			?>

		</div>
	</div>
	<?php
	if($insta3[0]->banner_title){
		?>
		<div class="in_re02 pt20 pb45">
			<div class="inner">
				<h1>
					<?=$insta3[0]->banner_title?>
				</h1>
				<ul class="ty01 ty02">
					<?php
					foreach($insta3 as $i3){
						?>
						<li>
							<img src="/_data/file/banner2/<?=$i3->upfile2?>" alt="" onerror="/_data/file/banner2/<?=$i3->upfile1?>">
							<div class="txt">
								<div class="text">
									<?=nl2br($i3->addinfo2)?>
								</div>
								<div class="brown">
									<?=$i3->addinfo3?>
								</div>
							</div>
						</li>
						<?php
					}
					?>
				</ul>
				<div class="review_head ac mt0">
					<img src="/image/main/insta.png" alt="">인스타에 후기를 남겨주시면 선정하여 선물을 드려요 <br>
					<div class="blue" style="text-decoration: underline;">
						#산골이유식 태그 필수!
					</div>
					태그하고
				</div>
			</div>
		</div>
		<?php
	}
	?>
<div class="review_head ac mt0" style="border: 0;background: #FAFAFA;">
			<img src="/image/main/insta.png" alt="">인스타에 후기를 남겨주시면 선정하여 선물을 드려요 <br>
			<div class="blue" style="border-bottom:1px solid #009BE0;">#산골이유식 태그 필수!</div>
		</div>
	<div class="inner">

<ul class="cont cont04">

			<!-- <li>

				<img src="/image/main/nsfks.jpg" alt="" class="ico">
				<h1>
					<span>산골과 첫 인연</span>배우 이시영님
				</h1>
				<div class="img">
					<img src="/image/main/img02.jpg" alt="">
				</div>
				<div class="desc">
					건강하게 먹이고 있어요. <br>아이가 먹고 남으면 저도 먹으니까요.<br>잘 먹어서 좋아요!
				</div>
			</li>
			<li>
				<img src="/image/main/fjkskfsd.jpg" alt="" class="ico">
				<h1>

					<span>산골간식도 함께</span>배우 조윤희님
				</h1>
				<div class="img">
					<img src="/image/main/img02.jpg" alt="">
				</div>
				<div class="desc">
					이유식도 잘 먹고, 푸딩이랑 밤이랑 과일칩을 <br>정말 맛있게 잘 먹어요.
				</div>
			</li>
			 -->

<li>

				<img src="/image/main/ico02.jpg" alt="" class="ico">
				<h1>
					<span>산골과 첫 인연</span>배우 이시영님
				</h1>
				<div class="img">
					<img src="/image/main/nsfks.jpg" alt="">
				</div>
				<div class="desc">
					건강하게 먹이고 있어요. <br>아이가 먹고 남으면 저도 먹으니까요.<br>잘 먹어서 좋아요!
				</div>
			</li>
			<li>
				<img src="/image/main/ico01.jpg" alt="" class="ico">
				<h1>

					<span>산골간식도 함께</span>배우 조윤희님
				</h1>
				<div class="img">
					<img src="/image/main/fjkskfsd.jpg" alt="">
				</div>
				<div class="desc">
					이유식도 잘 먹고, 푸딩이랑 밤이랑 과일칩을 <br>정말 맛있게 잘 먹어요.
				</div>
			</li>

			<li>
				<img src="/image/main/ico03.jpg" alt="" class="ico">
				<h1>
					<span>첫째부터 둘째까지</span>배우 강성연님
				</h1>
				<div class="img">
					<img src="/image/main/img02.jpg" alt="">
				</div>
				<div class="desc">
					모두 에코맘 산골이유식 덕분입니다! <br>
					정말 감사해요. 시안이에 이어서, 둘째 해안이까지 -<br>
					평생 잊을 수 없는 감사한 선물을 받았습니다.
				</div>
			</li>

		<!-- <li>
			<img src="/image/main/ico01.jpg" alt="" class="ico">
			<h1>
				<span>첫째부터 둘째까지</span>배우 강성연님
			</h1>
			<div class="img">
				<img src="/image/main/img02.jpg" alt="">
			</div>
			<div class="desc">
				모두 에코맘 산골이유식 덕분입니다! <br>
				정말 감사해요. 시안이에 이어서, 둘째 해안이까지 -<br>
				평생 잊을 수 없는 감사한 선물을 받았습니다.
			</div>
		</li> -->
		<li>
			<img src="/image/main/ico02.jpg" alt="" class="ico">
			<h1>
				<span>처음부터 끝까지</span>인스타셀러브리티 루비맘님
			</h1>
			<div class="img">
				<img src="/image/main/Sangol_PC_main_11.jpg" alt="">
			</div>
			<div class="desc">
				루비는 산골이유식으로 처음부터 끝까지 이유식을 졸업
				했어요!  산골이유식 덕분에 더 많은 사랑을 받을 수 있어서
				감사합니다!
			</div>
		</li>
		<li>
			<img src="/image/main/ico03.jpg" alt="" class="ico">
			<h1>
				<span>16개월 오랜 인연</span>강경희님
			</h1>
			<div class="img">
				<img src="/image/main/Sangol_PC_main_14.jpg" alt="">
			</div>
			<div class="desc">
				저희 아이는 중기때부터 에코맘에 발을 들인 이후로
				23개월인 지금까지 에코맘 반찬을 이용하고 있습니다.
				16개월 동안 이용해 보니, 이제는 좋은 후기를 남겨도
				되겠다 싶어 이렇게 글을 남깁니다.
			</div>
		</li>
	</ul>
<div class="ac" style="font-size: 11px; opacity: .5;">* 실제 산골이유식을 드시며, 어떠한 금전적 지원도 받지 않았습니다.
</div>
	</div>

	<!-- inner -->
</div>
<!--END Container-->
<div class="mg95">
</div>
<? include('../include/footer.php') ?>
<h1>
</h1>
