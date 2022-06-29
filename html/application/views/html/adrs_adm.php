<?
	$PageName = "ADRS";
	$SubName = "";
	$PageTitle = "배송지 관리";
	include('../include/head.php');
	include('../include/header.php');
?>
<script type="text/javascript">
<!--
	function regi_addr_pop(type){
		window.open("/html/dh/address_add/?idx=<?=$member_info->idx?>&type="+type,"addr_manage","width=600, height=600, scrollbars=yes");
	}

	function edit_addr_pop(type){
		window.open("/html/dh/address_add/?idx=<?=$member_info->idx?>&mode=edit&type="+type,"addr_manage_edit","width=600, height=600, scrollbars=yes");
	}
//-->
</script>

	<!--Container-->
	<div id="container">
		<?include("../include/my_top.php");?>
		<div class="inner clearfix">
			<?include("../include/mypage_lnb.php");?>
			<div class="my_cont clearfix">
				<div>
					<p class="myp_top">배송지를 등록해 두시면 주문하실 때 편리하게 이용하실 수 있습니다.</p>

					<ul class="clearfix adrs">
						<?php
						foreach($addr_to_name as $k => $v){
							if($v == "home"){
								$zip = $member_info->zip1;
								$addr1 = $member_info->add1;
								$addr2 = $member_info->add2;
								$phone1 = $member_info->phone1;
								$phone2 = $member_info->phone2;
								$phone3 = $member_info->phone3;
								$name = $member_info->name;
							}
							else{
								$zip = $member_info->{$v._zip};
								$addr1 = $member_info->{$v._addr1};
								$addr2 = $member_info->{$v._addr2};
								$phone1 = $member_info->{$v._phone1};
								$phone2 = $member_info->{$v._phone2};
								$phone3 = $member_info->{$v._phone3};
								$name = $member_info->{$v._name};
							}
						?>
						<li>
							<?php
							if($zip and $addr1 and $addr2 and $phone1 and $phone2 and $phone3 and $name){
								?>
								<h1>#<?=$k?></h1>
								<p class="pp">받으시는 분 : <?=$name?></p>
								<p>(<?=$zip?>) <?=$addr1?> <?=$addr2?></p>
								<p class="cell">Phone : <?=$phone1?>-<?=$phone2?>-<?=$phone3?></p>
								<a href="javascript:;" onclick="edit_addr_pop('<?=$v?>')" class="edit"></a>
								<?php
							}
							else{
								?>
								<h1>#<?=$k?></h1>
								<a href="javascript:;" onclick="regi_addr_pop('<?=$v?>')"><img src="/image/sub/adrs_bg.jpg" alt=""></a>
								<?php
							}
							?>
						</li>
						<?php
						}
						?>

						<?php
						/*
						<li>
							<?php
							if($member_info->zip1 and $member_info->add1 and $member_info->add2 and $member_info->name and $member_info->phone1 and $member_info->phone2 and $member_info->phone3){
								?>
								<h1>#자택</h1>
								<p class="pp">받으시는 분 : <?=$member_info->name?></p>
								<p>(<?=$member_info->zip1?>) <?=$member_info->add1?> <?=$member_info->add2?></p>
								<p class="cell">Phone : <?=$member_info->phone1?>-<?=$member_info->phone2?>-<?=$member_info->phone3?></p>
								<a href="javascript:;" onclick="edit_addr_pop('home')" class="edit"></a>
								<?php
							}
							else{
								?>
								<h1>#자택</h1>
								<a href="javascript:;" onclick="regi_addr_pop('home')"><img src="/image/sub/adrs_bg.jpg" alt=""></a>
								<?php
							}
							?>
						</li>
						<li>
							<?php
							if($member_info->chin_zip and $member_info->chin_addr1 and $member_info->chin_addr2 and $member_info->chin_name and $member_info->chin_phone1 and $member_info->chin_phone2 and $member_info-chin_phone3){
								?>
								<h1>#친정</h1>
								<p class="pp">받으시는 분 : 홍길동</p>
								<p>(12345) 서울 강서구 화곡동 199 동인빌 334호</p>
								<p class="cell">Phone : 010-1234-5255</p>
								<a href="javascript:;" class="edit"></a>
								<?php
							}
							else{
								?>
								<h1>#친정</h1>
								<a href="javascript:;" onclick="regi_addr_pop('chin')"><img src="/image/sub/adrs_bg.jpg" alt=""></a>
								<?php
							}
							?>
						</li>
						<li>
							<?php
							if($member_info->sidc_zip and $member_info->sidc_addr1 and $member_info->sidc_addr2 and $member_info->sidc_name and $member_info->sidc_phone1 and $member_info->sidc_phone2 and $member_info-sidc_phone3){
								?>
								<h1>#시댁</h1>
								<p class="pp">받으시는 분 : 홍길동</p>
								<p>(12345) 서울 강서구 화곡동 199 동인빌 334호</p>
								<p class="cell">Phone : 010-1234-5255</p>
								<a href="javascript:;" class="edit"></a>
								<?php
							}
							else{
								?>
								<h1>#시댁</h1>
								<a href="javascript:;" onclick="regi_addr_pop('sidc')"><img src="/image/sub/adrs_bg.jpg" alt=""></a>
								<?php
							}
							?>
						</li>
						<li>
							<?php
							if($member_info->bomo_zip and $member_info->bomo_addr1 and $member_info->bomo_addr2 and $member_info->bomo_name and $member_info->bomo_phone1 and $member_info->bomo_phone2 and $member_info-bomo_phone3){
								?>
								<h1>#보모</h1>
								<p class="pp">받으시는 분 : 홍길동</p>
								<p>(12345) 서울 강서구 화곡동 199 동인빌 334호</p>
								<p class="cell">Phone : 010-1234-5255</p>
								<a href="javascript:;" class="edit"></a>
								<?php
							}
							else{
								?>
								<h1>#보모</h1>
								<a href="javascript:;" onclick="regi_addr_pop('bomo')"><img src="/image/sub/adrs_bg.jpg" alt=""></a>
								<?php
							}
							?>
						</li>
						<li>
							<?php
							if($member_info->oth1_zip and $member_info->oth1_addr1 and $member_info->oth1_addr2 and $member_info->oth1_name and $member_info->oth1_phone1 and $member_info->oth1_phone2 and $member_info-oth1_phone3){
								?>
								<h1>#기타1</h1>
								<p class="pp">받으시는 분 : 홍길동</p>
								<p>(12345) 서울 강서구 화곡동 199 동인빌 334호</p>
								<p class="cell">Phone : 010-1234-5255</p>
								<a href="javascript:;" class="edit"></a>
								<?php
							}
							else{
								?>
								<h1>#기타1</h1>
								<a href="javascript:;" onclick="regi_addr_pop('oth1')"><img src="/image/sub/adrs_bg.jpg" alt=""></a>
								<?php
							}
							?>
						</li>
						<li>
							<?php
							if($member_info->oth2_zip and $member_info->oth2_addr1 and $member_info->oth2_addr2 and $member_info->oth2_name and $member_info->oth2_phone1 and $member_info->oth2_phone2 and $member_info-oth2_phone3){
								?>
								<h1>#기타2</h1>
								<p class="pp">받으시는 분 : 홍길동</p>
								<p>(12345) 서울 강서구 화곡동 199 동인빌 334호</p>
								<p class="cell">Phone : 010-1234-5255</p>
								<a href="javascript:;" class="edit"></a>
								<?php
							}
							else{
								?>
								<h1>#기타2</h1>
								<a href="javascript:;" onclick="regi_addr_pop('oth2')"><img src="/image/sub/adrs_bg.jpg" alt=""></a>
								<?php
							}
							?>
						</li>
						*/
						?>
					</ul>
				</div>
			</div>
		</div>
	</div><!--END Container-->


<? include('../include/footer.php') ?>

