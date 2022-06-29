<?
	if($this->input->get('cate_no') == 3){
		$PageName = "K04";
	}
	else if($this->input->get('cate_no') == 4){
		$PageName = "K05";
	}
	else if($this->input->get('cate_no') == 5){
		$PageName = "K06";
	}
	else if($this->input->get('cate_no') == 111){
		$PageName = "K02";
	}
	else if($this->input->get('cate_no') == 10){
		$PageName = "K02";
		$SubName = "K0205";
	}
	else if($row->idx == '819'){
		$PageName = "K02";
		$SubName = "K0206";
	}

	$PageTitle = ($row->name) ? $row->name : "" ;

	if($this->input->get('type')=="nmk"){
		$PageName="K07";
		$SubName="K0704";
	}

	include("../include/head.php");
	include("../include/header.php");
?>
	<script type="text/javascript" src="/js/product_view.js"></script>
	<!--Container-->
	<div id="container">
		<?include("../include/sub_top.php");?>

		<div class="content inner">

			<?php
			include "{$view}.php";
			?>

		</div><!-- END Content -->
	</div><!--END Container-->

<?include("../include/footer.php");?>
