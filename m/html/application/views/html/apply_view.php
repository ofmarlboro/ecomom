<?
	$PageName = "DESSERT_VIEW";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

<script type="text/javascript">
$(window).bind("pageshow", function(event) {
	console.log(event.originalEvent);
    if (event.originalEvent.PageTransitionEvent) {
        //document.location.reload();
    }
});
</script>

<!--Container-->

<div id="container">
	<?include("../include/top_menu.php");?>
	<?include("../include/view_tab.php");?>
	<div class="inner">
			<?php
			include "{$view}.php";
			?>
</div>
<!--END Container-->
<div class="mg95">
</div>
<? include('../include/footer.php') ?>
