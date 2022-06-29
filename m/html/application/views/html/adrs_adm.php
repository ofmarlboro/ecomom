<?
	$PageName = "ADRS_ADM";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

<!--Container-->

<script type="text/javascript">
	function regi_addr_pop(type){
		window.open("<?=cdir()?>/dh/address_add/?idx=<?=$member_info->idx?>&type="+type,"addr_manage","");
	}

	function edit_addr_pop(type){
		window.open("<?=cdir()?>/dh/address_add/?idx=<?=$member_info->idx?>&mode=edit&type="+type,"addr_manage_edit","");
	}

</script>

<div id="container">
	<?include("../include/top_menu.php");?>
	<?include("../include/mypage_top02.php");?>
	<div class="inner mypage">
		<h1>
			배송지 관리
		</h1>
		<p class="orderedit_top"> 배송지를 등록해두시면 주문하실 때 편리하게 이용하실 수 있습니다.</p>
		<ul class="adrs">
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
					<h3>#<?=$k?></h3>
					<p class="pp"> 받으시는 분 : <?=$name?> </p>
					<p>(<?=$zip?>) <?=$addr1?> <?=$addr2?> </p>
					<p class="cell"> Phone : <?=$phone1?>-<?=$phone2?>-<?=$phone3?> </p>
					<a href="javascript:;" onclick="edit_addr_pop('<?=$v?>');" class="edit"></a>
					<?php
				}
				else{
					?>
					<h3>#<?=$k?></h3>
					<a href="javascript:;" onclick="regi_addr_pop('<?=$v?>');" class="yet"><img src="/image/sub/adrs_bg.jpg" alt=""></a>
					<?php
				}
				?>
			</li>
			<?php
			}
			?>
		</ul>
	</div>
	<!-- inner -->
</div>
<!--END Container-->
<div class="mg95">
</div>
<? include('../include/footer.php') ?>
