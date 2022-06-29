<?
	$PageName = "MAIN";
	$SubName = "";
	include("../include/head.php");
	include("../include/header.php");
?>

<!--Container-->

<div id="container">
	<!-- <?include("../include/quick.php");?> -->
	<div class="center_ban">
		<img src="/image/main/center_jangjolim.png" alt="" style="cursor:pointer;" onclick="location.href='/html/dh/event01/#4'">
		<a href="#" id="center_close"><img src="/image/main/close02.png" alt=""></a>
	</div>

	<!-- inner -->
	<div class="inner">
		<!--  <img src="/image/main/f.png" usemap="#Map" border="0" class="ban_pop" style="position: fixed;bottom: 10px;left: 50%;margin-left: 400px;z-index: 99999999;" />
		 		<map name="Map" id="Map">
		 			<area shape="rect" coords="175,0,238,44" href="#" onClick="ban_close();"/>
		 			<area shape="rect" coords="0,41,232,237" href="http://www.ecomommeal.co.kr/html/dh_product/prod_view/430?&cate_no=3">
		 		</map>
		 		<script>
		 			function ban_close() {
		 				$(".ban_pop").hide();
		 			}
		 		</script>
		  -->
		<!-- cont01 -->
		<div class="cont cont01">

			<!-- 메인팝업 -->
			<div class="main_pop">
				<div class="side_bar">
					<span></span>
					<ul>
						<?php
						if($main_popups){
							foreach($main_popups as $mps){
							?>
						<li class="<?=($mps->pageurl == "show")?"on":"";?>">
							<a href="#">
							<?=$mps->name?>
							<span>
							<?=$mps->cnt?>
							</span></a>
							<img src="/image/main/arw10.png" alt="" class="arw10">
						</li>
						<?php
							}
						}
						?>
						<?php
						/*
						<li>
							<a href="#">이벤트<span>2</span></a>
						</li>
						<li>
							<a href="#">특가할인<span>2</span></a>
						</li>
						<li>
							<a href="#">신규소식<span>2</span></a>
						</li>
						<li>
							<a href="#">배송안내<span>2</span></a>
						</li>
						<li>
							<a href="#">오 산골농부<span>2</span></a>
						</li>
						*/
						?>
					</ul>
				</div>
				<div class="content_wrap">
					<?php
					$mp_cnt = 0;
					foreach($main_popups as $mp2){
						$mp_cnt++;
						?>
					<div class="slide<?=$mp_cnt?> <?=($mp2->pageurl == "show")?"on":"";?>">
						<a href="#" class="close01"><img src="/image/main/close.png" alt=""></a>
						<ul class="dot01 clearfix">
							<?php
								$mpcnt = 0;
								foreach($main_popups_banner as $mpb){
									if($mp2->code == $mpb->parent_code){
										$mpcnt++;
										?>
							<li class="<?=($mpcnt == 1)?"on":"";?>">
								<a href="#">
								<?=$mpcnt?>
								</a>
							</li>
							<?php
									}
								}
								?>
						</ul>
						<ul class="pop_c">
							<?php
								$mpcnt2 = 0;
								foreach($main_popups_banner as $mpb2){
									if($mp2->code == $mpb2->parent_code){
										$mpcnt2++;
										?>
							<li class="<?=($mpcnt2 == 1)?"on":"";?>">
								<h1>
									<?=$mpb2->addinfo1?>
								</h1>
								<a href="<?=($mpb2->pageurl)?$mpb2->pageurl:"javascript:;";?>" <?if($mpb2->pc_target == "blank"){?>target="_blank"<?}?>><img src="/_data/file/banner/<?=$mpb2->upfile1?>" alt=""></a>
							</li>
							<?php
									}
								}
								?>
						</ul>
						<div class="arw_w<?=$mp_cnt?> arw_wrap10">
							<a href="#" class="prev"><img src="/image/main/a00.png" alt=""></a>
							<a href="#" class="next"><img src="/image/main/a0.png" alt=""></a>
						</div>
					</div>
					<?php
					}
					?>
					<?php
					/*
						<div>
							<a href="#" class="close01"><img src="/image/main/close.png" alt=""></a>
							<ul class="dot01 clearfix">
								<li class="on"><a href="#">1</a></li>
								<li><a href="#">2</a></li>
								<li><a href="#">3</a></li>
							</ul>
							<ul class="pop_c">
								<li class="on"><h1>설 배송안내</h1><a href="#"><img src="/image/main/ii.jpg" alt=""></a></li>
								<li><h1>추석 배송안내</h1><a href="#"><img src="/image/main/ii.jpg" alt=""></a></li>
								<li><h1>연휴 배송안내</h1><a href="#"><img src="/image/main/ii.jpg" alt=""></a></li>
							</ul>
						</div>

						<div><a href="#" class="close01"><img src="/image/main/close.png" alt=""></a>
							<ul class="dot01 clearfix">
								<li class="on"><a href="#">1</a></li>
								<li><a href="#">2</a></li>
								<li><a href="#">3</a></li>
							</ul>
							<ul class="pop_c">
								<li class="on">
								<h1>설 배송안내</h1><a href="#">
								<img src="/image/main/ii.jpg" alt=""></a></li>
								<li>
								<h1>추석 배송안내</h1><a href="#"><img src="/image/main/ii.jpg" alt=""></a></li>

								<li>
								<h1>연휴 배송안내</h1><a href="#"><img src="/image/main/ii.jpg" alt=""></a></li>

							</ul>


						</div>

						<div>
							<a href="#" class="close01"><img src="/image/main/close.png" alt=""></a>
							<ul class="dot01 clearfix">
								<li class="on"><a href="#">1</a></li>
								<li><a href="#">2</a></li>
								<li><a href="#">3</a></li>
							</ul>
							<ul class="pop_c">
								<li class="on">
								<h1>설 배송안내</h1><a href="#">
								<img src="/image/main/ii.jpg" alt=""></a></li>
								<li>
								<h1>추석 배송안내</h1><a href="#"><img src="/image/main/ii.jpg" alt=""></a></li>

								<li>
								<h1>연휴 배송안내</h1><a href="#"><img src="/image/main/ii.jpg" alt=""></a></li>

							</ul>

						</div>


						<div>
							<a href="#" class="close01"><img src="/image/main/close.png" alt=""></a>
							<ul class="dot01 clearfix">
								<li class="on"><a href="#">1</a></li>
								<li><a href="#">2</a></li>
								<li><a href="#">3</a></li>
							</ul>
							<ul class="pop_c">
								<li class="on">
								<h1>설 배송안내</h1><a href="#">
								<img src="/image/main/ii.jpg" alt=""></a></li>
								<li>
								<h1>추석 배송안내</h1><a href="#"><img src="/image/main/ii.jpg" alt=""></a></li>

								<li>
								<h1>연휴 배송안내</h1><a href="#"><img src="/image/main/ii.jpg" alt=""></a></li>

							</ul>


						</div>

						<div>
							<a href="#" class="close01"><img src="/image/main/close.png" alt=""></a>
							<ul class="dot01 clearfix">
								<li class="on"><a href="#">1</a></li>
								<li><a href="#">2</a></li>
								<li><a href="#">3</a></li>
							</ul>
							<ul class="pop_c">
								<li class="on">
								<h1>설 배송안내</h1><a href="#">
								<img src="/image/main/ii.jpg" alt=""></a></li>
								<li>
								<h1>추석 배송안내</h1><a href="#"><img src="/image/main/ii.jpg" alt=""></a></li>

								<li>
								<h1>연휴 배송안내</h1><a href="#"><img src="/image/main/ii.jpg" alt=""></a></li>

							</ul>

						</div>
					*/
					?>
				</div>
				<!-- //content_wrap -->

			</div>
			<!-- //메인팝업 -->

			<!-- 메인비주얼 -->
			<div class="mv">
				<?php
				foreach($main_banner as $mb){
					if($mb->parent_code == "pc_main"){
						?>
				<div class="item">
					<img src="/_data/file/banner/<?=$mb->upfile1?>" alt="" onclick="<?if($mb->pc_target == "blank"){ if($mb->pageurl){?>window.open('<?=$mb->pageurl?>','','')<?} }else{ if($mb->pageurl){?>location.href='<?=$mb->pageurl?>'<?} }?>" style="<?=($mb->pageurl)?"cursor:pointer;":"";?>">
				</div>
				<?php
					}
				}
				?>
				<?php
				/*
					<div class="item"><img src="/image/main/mv01.jpg" alt=""></div>
					<div class="item">
						<img src="/image/main/mv01.jpg" alt="">
					</div>
					<div class="item">
						<img src="/image/main/mv01.jpg" alt="">
					</div>
					<div class="item">
						<img src="/image/main/mv01.jpg" alt="">
					</div>
				*/
				?>
			</div>
			<!-- //메인비주얼 -->

			<!-- 메뉴 -->
			<div class="menu">
				<ul>
					<li class="li01">
						<a href="/html/dh/bfood_order_regular1/?recom_idx=2">
						<span class="desc"><strong>5개월전후</strong>준비기<img class="arw" src="/image/main/arw01.png" alt=""></span>
						<span class="dim">
						<span class="desc"><strong>유기농쌀에 한가지<br>
						재료를 더한 보미</strong></span>
						</span>
						</a>
					</li>
					<li class="li02">
						<a href="/html/dh/bfood_order_regular1/?recom_idx=4">
						<span class="desc"><strong>5-6개월</strong>초기<img class="arw" src="/image/main/arw01.png" alt=""></span>
						<span class="dim">
						<span class="desc"><strong>준비기 적응 후 단백질식품과<br>
						채소를 섞은 보미</strong></span>
						</span>
						</a>
					</li>
					<li class="li03">
						<a href="/html/dh/bfood_order_regular1/?recom_idx=5">
						<span class="desc"><strong>7-8개월</strong>중기<img class="arw" src="/image/main/arw01.png" alt=""></span>
						<span class="dim">
						<span class="desc"><strong>보미보다 되직하고<br>
						밥알 3/1크기기의 부드러운 덩어리죽</strong></span>
						</span>
						</a>
					</li>
					<li class="li04">
						<a href="/html/dh/bfood_order_regular1/?recom_idx=6">
						<span class="desc"><strong>9-12개월</strong>후기<img class="arw" src="/image/main/arw01.png" alt=""></span>
						<span class="dim">
						<span class="desc"><strong>온전한 쌀의 식감을 느끼고<br>
						맛보고 느끼는 5배죽</strong></span>
						</span>
						</a>
					</li>
					<li class="li05">
						<a href="/html/dh/bfood_order_regular1/?recom_idx=7">
						<span class="desc"><strong>12개월-</strong>완료기<img class="arw" src="/image/main/arw01.png" alt=""></span>
						<span class="dim">
						<span class="desc"><strong>본격적으로 밥과 가까운 음식으로<br>
						돌 전후 2배 진밥</strong></span>
						</span>
						</a>
					</li>
					<li class="li06">
						<a href="/html/dh/bfood_order_regular1/?recom_idx=3">
						<span class="desc"><strong>반찬/국</strong><img class="arw" src="/image/main/arw01.png" alt=""></span>
						<span class="dim">
						<span class="desc"><strong>처음 접하는 반찬/국으로<br>
						육류,해물류,야채류로 순하게-</strong></span>
						</span>
						</a>
					</li>
					<li class="li07">
						<a href="/html/dh/bfood_order_sale1">
						<span class="desc"><strong>특가세트</strong><img class="arw" src="/image/main/arw01.png" alt=""></span>
						<span class="dim">
						<span class="desc"><strong>3일-6일분을 한 번에<br>
						배송받아 할인되는 세트</strong></span>
						</span>
						</a>
					</li>
					<li class="li08">
						<a href="/html/dh/bfood_sample">
						<span class="desc"><strong>2팩체험신청</strong><img class="arw" src="/image/main/arw01.png" alt=""></span>
						<span class="dim">
						<span class="desc"><strong>홈페이지 신규가입회원 대상<br>
						1일 20명 선착순 신청가능</strong></span>
						</span>
						</a>
					</li>
				</ul>
			</div>
			<!--// 메뉴 -->
		</div>
		<!-- //cont01 -->

		<!-- 상품 5개 -->
		<ul class="cont cont02">
			<?php
			if($main_goods){
				foreach($main_goods as $mg){
					?>
			<li>
				<!-- <div class="ico">
							<img src="/image/main/best.png" alt="">
						</div> -->
				<a href="/html/dh_product/prod_view/<?=$mg->idx?>?&cate_no=3">
				<span class="img"><img src="/_data/file/goodsImages/<?=$mg->list_img?>" alt=""></span>
				<span class="desc">
				<?=$mg->name?>
				</span>
				<span class="dim">
				<?php
								$detail_arr = preg_split('/\r\n|[\r\n]/', $mg->detail);
								?>
				<span class="p01">
				<?=$detail_arr[0]?>
				</span>
				<span class="p02"></span>
				<span class="p01">
				<?=$detail_arr[1]?>
				<br>
				<?=$detail_arr[2]?>
				<br>
				<?=$detail_arr[3]?>
				</span>
				<span class="desc">
				<?=$mg->name?>
				</span>
				<span class="price">
				<?=number_format($mg->shop_price)?>
				</span>
				</span>
				</a>
			</li>
			<?php
				}
			}
			?>
			<?php
			/*
				<li>
					<div class="ico">
						<img src="/image/main/best.png" alt="">
					</div>
					<a href="#">
					<span class="img"><img src="/image/main/m13.jpg" alt=""></span>
					<span class="desc">산골알밤</span>
					<span class="dim">
					<span class="p01">사과, 딸기, 배 100% 과일 그대로</span>
					<span class="p02"></span>
					<span class="p01">원재료 외에는<br>
					아무것도<br>
					넣지 않아요</span>
					<span class="desc">산골알밤</span>
					<span class="price">9,900</span>
					</span>
					</a>
				</li>
				<li>
					<a href="#">
					<span class="img"><img src="/image/main/m13.jpg" alt=""></span>
					<span class="desc">산골알밤</span>
					<span class="dim">
					<span class="p01">사과, 딸기, 배 100% 과일 그대로</span>
					<span class="p02"></span>
					<span class="p01">원재료 외에는<br>
					아무것도<br>
					넣지 않아요</span>
					<span class="desc">산골알밤</span>
					<span class="price">9,900</span>
					</span>
					</a>
				</li>
				<li>
					<div class="ico">
						<img src="/image/main/new.png" alt="">
					</div>
					<a href="#">
					<span class="img"><img src="/image/main/m13.jpg" alt=""></span>
					<span class="desc">산골알밤</span>
					<span class="dim">
					<span class="p01">사과, 딸기, 배 100% 과일 그대로</span>
					<span class="p02"></span>
					<span class="p01">원재료 외에는<br>
					아무것도<br>
					넣지 않아요</span>
					<span class="desc">산골알밤</span>
					<span class="price">9,900</span>
					</span>
					</a>
				</li>
				<li>
					<a href="#">
					<span class="img"><img src="/image/main/m13.jpg" alt=""></span>
					<span class="desc">산골알밤</span>
					<span class="dim">
					<span class="p01">사과, 딸기, 배 100% 과일 그대로</span>
					<span class="p02"></span>
					<span class="p01">원재료 외에는<br>
					아무것도<br>
					넣지 않아요</span>
					<span class="desc">산골알밤</span>
					<span class="price">9,900</span>
					</span>
					</a>
				</li>
				<li>
					<a href="#">
					<span class="img"><img src="/image/main/m13.jpg" alt=""></span>
					<span class="desc">산골알밤</span>
					<span class="dim">
					<span class="p01">사과, 딸기, 배 100% 과일 그대로</span>
					<span class="p02"></span>
					<span class="p01">원재료 외에는<br>
					아무것도<br>
					넣지 않아요</span>
					<span class="desc">산골알밤</span>
					<span class="price">9,900</span>
					</span>
					</a>
				</li>
			*/
			?>
		</ul>

		<!-- //상품 5개 -->

		<!-- 중간배너 -->
		<div class="banner">
			<div class="img">
				<?php
				foreach($main_banner as $msg){
					if($msg->parent_code == "pc_mid_farm"){
						?>
				<img src="/_data/file/banner/<?=$msg->upfile1?>" onclick="<?if($msg->pc_target == "blank"){ if($msg->pageurl){?>window.open('<?=$msg->pageurl?>','','')<?} }else{ if($msg->pageurl){?>location.href='<?=$msg->pageurl?>'<?} }?>" style="<?=($msg->pageurl)?"cursor:pointer;":"";?>">
				<?php
					}
				}
				?>
			</div>
		</div>
		<!-- // 중간배너 -->

		<!-- 입점안내 / 산골공방 -->
		<ul class="cont cont03">
		

			
		
				<li>
					<div class="inner01">
						<div class="slide01">
							<?php
							foreach($main_banner as $mdp){
								if($mdp->parent_code == "pc_depart"){
									?>
							<div class="item">
								<h2>
									<?=$mdp->addinfo1?>
									<span>
									<?=$mdp->addinfo3?>
									</span>
								</h2>

								<!-- <li style="background-image:url(/_data/file/bbsData/<?=$bgl->bbs_file?>); background-size:cover; background-position:center"> -->
								<!-- <img src="/_data/file/bbsData/<?=$bgl->bbs_file?>" alt=""> -->
								<!-- 이미지 사이즈 870*550 -->
								<!-- <div class="dim">
									<p>
										<?=$bgl->subject?>
									</p>
								</div>
														</li> -->

								<div class="img"
										 style="background-image:url(/_data/file/banner/<?=$mdp->upfile1?>); background-size:cover; background-position:center">
									<!-- <img src="/_data/file/banner/<?=$mdp->upfile1?>" alt="" onclick="<?if($mdp->pc_target == "blank"){ if($mdp->pageurl){?>window.open('<?=$mdp->pageurl?>','','')<?} }else{ if($mdp->pageurl){?>location.href='<?=$mdp->pageurl?>'<?} }?>" style="<?=($mdp->pageurl)?"cursor:pointer;":"";?>"> -->
								</div>
								<div class="dim">
									<p>
										<?php
											echo nl2br($mdp->addinfo2);
											?>
									</p>
								</div>

								<!-- 	<div class="desc">
											<?php
											echo nl2br($mdp->addinfo2);
											?>
										</div> -->

							</div>
							<?php
								}
							}
							?>
							<?php
							/*
								<div class="item">
									<div class="img">
										<img src="/image/main/img.jpg" alt="">
									</div>
									<div class="desc">
										에코맘의 산골이유식이 2017년 부터 현대백화점 압구정 본점 입점하여 <br>
										가공식품 전체 매출에서 5위권을 기록하였습니다.
									</div>
								</div>

								<div class="item">
									<div class="img">
										<img src="/image/main/img.jpg" alt="">
									</div>
									<div class="desc">
										에코맘의 산골이유식이 2017년 부터 현대백화점 압구정 본점 입점하여 <br>
										가공식품 전체 매출에서 5위권을 기록하였습니다.
									</div>
								</div>
							*/
							?>
						</div>
						<ul class="arw_wrap">
							<li class="prev">
							</li>
							<li class="next">
							</li>
						</ul>
					</div>
				</li>
				
			<li>
				<div class="inner02">
					<h2>
						산골공방<span>OPEN KITCHEN</span>
					</h2>
					<div class="insta_avi">
						<div class="main_ucc">
							<iframe width="350" height="350" src="https://www.youtube.com/embed/xQl4TiMcR4M?rel=0&amp;controls=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
						</div>
					</div>
					<div class="desc">
						하동의 오픈키친으로 오세요
					</div>
				</div>
			</li>
		</ul>

		<!-- //뉴스 2개 -->

		<!-- 후기 3개 -->
		<ul class="cont cont04">
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
				<img src="/image/main/ico02.jpg" alt="" class="ico">
				<h1>
					<span>처음부터 끝까지</span>인스타셀러브리티 루비맘님
				</h1>
				<div class="img">
					<img src="/image/main/Sangol_PC_main_11.jpg" alt="">
				</div>
				<div class="desc">
					루비는 산골이유식으로 처음부터 끝까지 이유식을 졸업했어요!  산골이유식 덕분에 더 많은 사랑을 받을 수 있어서 감사합니다!
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
					저희 아이는 중기때부터 에코맘에 발을 들인 이후로 23개월인 지금까지 에코맘 반찬을 이용하고 있습니다. 16개월 동안 이용해 보니, 이제는 좋은 후기를 남겨도 되겠다 싶어 이렇게 글을 남깁니다.
				</div>
			</li> -->
		</ul>
<div class="ar mt5 mb5" style="opacity: .5;font-size: 12px;">* 실제 산골이유식을 드시며, 어떠한 금전적 지원도 받지 않았습니다</div>
		<!-- //후기 3개  -->

		<!-- 산골 책 -->
		<ul class="cont cont05">
			<li>
				<h2 class="ar">
					<span>산골이유식이</span>책이 되어 돌아왔습니다
				</h2>
				<div class="avi">
					<!-- <img src="/image/main/img06.jpg" alt=""> -->
					<iframe width="350" height="350" src="https://www.youtube.com/embed/S1aDVAPlS-U?rel=0&amp;controls=0" frameborder="0" allow="autoplay; encrypted-media" allowfullscreen></iframe>
				</div>
			</li>
			<li>
				<strong>이유식은 어렵지 않습니다<br>
				어렵게 느껴질 뿐입니다</strong>
				<p>내 아이가 아플 때도,<br>
					뭘 먹일지 걱정마세요</p>
				<p>지리산 산골에서<br>
					직접 보고 직접 듣고 직접 만나고<br>
					직접 기르며 만든 6년 동안의 기록.</p>
				<p>봄, 여름, 가을, 겨울<br>
					건강한 레시피 151가지</p>
				<div class="img">
					<img src="/image/main/img05.jpg" alt="">
				</div>
			</li>
		</ul>

		<!-- //산골 책  -->

		<!-- 인스타 -->
		<div class="insta">
			<div class="ac mb30">
				<a href="https://www.instagram.com/sangol.babyfood/" target="_blank"><img src="/image/main/img2.png" alt=""></a>
			</div>

			<!-- <div class="insta_link">
				<a href="#"><img src="/image/main/insta_logo.jpg" alt=""></a>
				<a href="#"><img src="/image/main/follow.jpg" alt=""></a>
			</div> -->
			<ul class="insta_list clearfix">
				<!-- <li>
					<a href="#">
					<img src="/image/main/img07.jpg" alt="">
					</a>
				</li>
				<li>
					<a href="#">
					<img src="/image/main/img07.jpg" alt="">
					</a>
				</li>
				<li class="mr0">
					<a href="#">
					<img src="/image/main/img07.jpg" alt="">
					</a>
				</li> -->
			</ul>
		</div>
		<!-- //인스타 -->

	</div>
	<!-- //inner -->
</div>
<!--END Container-->

<script>
	$('#center_close').on('click',function(e){
		e.preventDefault();
		$('.center_ban').slideToggle();
	});

	$('.close01').on('click',function(e){
		e.preventDefault();
		$(this).parent().removeClass('on');
		$(this).closest('.main_pop').find('.side_bar ul li').removeClass('on');
	});

	$(document).ready(function(){

		aa = $(".slide1").find(".pop_c li:last").index();
		bb = $(".slide2").find(".pop_c li:last").index();
		cc = $(".slide3").find(".pop_c li:last").index();
		dd = $(".slide4").find(".pop_c li:last").index();
		ee = $(".slide5").find(".pop_c li:last").index();

		if ( aa >= 1 ) { }
		else { 	$(".arw_w1").hide();	};

		if ( bb >= 1 ) { }
		else { 	$(".arw_w2").hide();	};

		if ( cc >= 1 ) { }
		else { 	$(".arw_w3").hide();	};

		if ( dd >= 1 ) { }
		else { 	$(".arw_w4").hide();	};

		if ( ee >= 1 ) { }
		else { 	$(".arw_w5").hide();	};

		var n=0;
		//var slideCount =  $(".content_wrap > div:first .pop_c li:last").index();

		//e.preventDefault();
		$('.dot01 li').click(function(e){
			e.preventDefault();
			n=$('.dot01 li').index($(this));
			$('.pop_c li').eq(n).addClass('on').siblings().removeClass('on');
			$('.dot01 li').eq(n).addClass('on').siblings().removeClass('on');
		})

		$('.slide1 .arw_wrap10 .next').click(function(e){
			e.preventDefault();
			var slideCount =  $(this).parent().parent().find(".pop_c li:last").index();
			if(n>=slideCount){ n=0 }
			else{ n++; }
			$('.slide1 .pop_c li').eq(n).addClass('on').siblings().removeClass('on');
			$('.slide1 .dot01 li').eq(n).addClass('on').siblings().removeClass('on');
		})

		$('.slide1 .arw_wrap10 .prev').click(function(e){
			e.preventDefault();
			var slideCount =  $(this).parent().parent().find(".pop_c li:last").index()
		 	if( n < 1 ){ n=slideCount }
			else{ n --; }
			$('.slide1 .pop_c li').eq(n).addClass('on').siblings().removeClass('on');
			$('.slide1 .dot01 li').eq(n).addClass('on').siblings().removeClass('on');
		});


		$('.slide2 .arw_wrap10 .next').click(function(e){
			e.preventDefault();
			var slideCount =  $(this).parent().parent().find(".pop_c li:last").index()
			if(n>=slideCount){ n=0 }
			else{ n++; }
			$('.slide2 .pop_c li').eq(n).addClass('on').siblings().removeClass('on');
			$('.slide2 .dot01 li').eq(n).addClass('on').siblings().removeClass('on');
		});

		$('.slide2 .arw_wrap10 .prev').click(function(e){
			e.preventDefault();
			var slideCount =  $(this).parent().parent().find(".pop_c li:last").index()
		 	if( n < 1 ){ n=slideCount }
			else{ n --; }
			$('.slide2 .pop_c li').eq(n).addClass('on').siblings().removeClass('on');
			$('.slide2 .dot01 li').eq(n).addClass('on').siblings().removeClass('on');
		});

		$('.slide3 .arw_wrap10 .next').click(function(e){
			e.preventDefault();
			var slideCount =  $(this).parent().parent().find(".pop_c li:last").index();
			if(n>=slideCount){ n=0 }
			else{ n++; }
			$('.slide3 .pop_c li').eq(n).addClass('on').siblings().removeClass('on');
			$('.slide3 .dot01 li').eq(n).addClass('on').siblings().removeClass('on');
		});

		$('.slide3 .arw_wrap10 .prev').click(function(e){
			e.preventDefault();
			var slideCount =  $(this).parent().parent().find(".pop_c li:last").index()
		 	if( n < 1 ){ n=slideCount }
			else{ n --; }
			$('.slide3 .pop_c li').eq(n).addClass('on').siblings().removeClass('on');
			$('.slide3 .dot01 li').eq(n).addClass('on').siblings().removeClass('on');
		});

		$('.slide4 .arw_wrap10 .next').click(function(e){
			e.preventDefault();
			var slideCount =  $(this).parent().parent().find(".pop_c li:last").index()
		 if(n>=slideCount){ n=0 }
			else{ n++; }
			$('.slide4 .pop_c li').eq(n).addClass('on').siblings().removeClass('on');
			$('.slide4 .dot01 li').eq(n).addClass('on').siblings().removeClass('on');
		});

		$('.slide4 .arw_wrap10 .prev').click(function(e){
			e.preventDefault();
			var slideCount =  $(this).parent().parent().find(".pop_c li:last").index()
		 	if( n < 1 ){ n=slideCount }
			else{ n --; }
			$('.slide4 .pop_c li').eq(n).addClass('on').siblings().removeClass('on');
			$('.slide4 .dot01 li').eq(n).addClass('on').siblings().removeClass('on');
		});

		$('.slide5 .arw_wrap10 .next').click(function(e){
			e.preventDefault();
			var slideCount =  $(this).parent().parent().find(".pop_c li:last").index()
		 if(n>=slideCount){ n=0 }
			else{ n++; }
			$('.slide5 .pop_c li').eq(n).addClass('on').siblings().removeClass('on');
			$('.slide5 .dot01 li').eq(n).addClass('on').siblings().removeClass('on');
		});

		$('.slide5 .arw_wrap10 .prev').click(function(e){
			e.preventDefault();
			var slideCount =  $(this).parent().parent().find(".pop_c li:last").index()
		 	if( n < 1 ){ n=slideCount }
			else{ n --; }
			$('.slide5 .pop_c li').eq(n).addClass('on').siblings().removeClass('on');
			$('.slide5 .dot01 li').eq(n).addClass('on').siblings().removeClass('on');
		});
	});

	$('.side_bar > ul > li > a').on('click',function(e){
		e.preventDefault();
		$(this).parent().addClass('on').siblings().removeClass('on');
		n=$('.side_bar > ul > li > a').index($(this));
		$('.content_wrap > div').eq(n).addClass('on').siblings().removeClass('on');
	});

	$(function(){
		$(".mv").slick({
			autoplay:true,
			//prevArrow: $('.prev'),
			//nextArrow: $('.next'),
			//arrows:false,
			dots:true
		});
	});

	$(function(){
		$(".slide01").slick({
			autoplay:true,
			prevArrow: $('.prev'),
			nextArrow: $('.next'),
			//arrows:false,
			dots:true
		});
	});

	jQuery(function($) {
		//Access Tocken 입력
		//var tocken = "4032330465.84ae674.313d14e42d52498a8093a283aca56da8";
		var tocken = "4032330465.48d728c.35eb666c66a44f4c88893cc4c30813ed";
		var count = "9";
		$.ajax({
			type: "GET",
			dataType: "jsonp",
			cache: false,
			url: "https://api.instagram.com/v1/users/4032330465/media/recent?access_token=" + tocken + "&count=" + count,
			success: function(response) {
				if ( response.data.length > 0 ) {
					for(var i = 0; i < response.data.length; i++) {
						var j = i+1;
						var class_name = "";

						if(parseInt(j)%3 == 0){
							class_name = "mr0";
						}


						var insta	=		"<li class='"+class_name+"'>";
								insta	+=	"	<a href='" + response.data[i].link + "' target='_blank'>";
								insta	+=	"		<img src='"+ response.data[i].images.standard_resolution.url +"' alt=''>";
								insta	+=	"	</a>";
								insta	+=	"</li>";
						$(".insta_list").append(insta);
					}
				}
			},
			error: function(xhr){alert("error!!");}
		});
	});
</script>
<?include("../include/footer.php");?>
