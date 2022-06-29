<?
	$PageName = "K01";
	$SubName = "K0102";
	include("../include/head.php");
	include("../include/header.php");
?>

<!--Container-->

<div id="container">
	<?include("../include/top_menu.php");?>

	<div class="">

<div class="gall_wrap">
	<ul class="gall">
		<li>
			<img src="/m/image/sub/bb.jpg" alt="">

		</li>
		<li>
			<img src="/m/image/sub/bb01.jpg" alt="">
		</li>
		<li>
			<img src="/m/image/sub/bb02.jpg" alt="">
		</li>
		<li>
			<img src="/m/image/sub/bb03.jpg" alt="">
		</li>
		<li>
			<img src="/m/image/sub/bb04.jpg" alt="">
		</li>
		<li>
			<img src="/m/image/sub/bb05.jpg" alt="">
		</li>
		<li>
			<img src="/m/image/sub/bb06.jpg" alt="">
		</li>
		<li>
			<img src="/m/image/sub/bb07.jpg" alt="">
		</li>
		<li>
			<img src="/m/image/sub/bb08.jpg" alt="">
		</li>
		<li>
			<img src="/m/image/sub/bb09.jpg" alt="">
		</li>
		<li>
			<img src="/m/image/sub/bb10.jpg" alt="">
		</li>
		<li>
			<img src="/m/image/sub/bb11.jpg" alt="">
		</li>


	</ul>
	<ul class="arw_wrap">
		<li class="prev">
		</li>
		<li class="next">
		</li>
	</ul>

</div>
</div>

</div>
<!--END Container-->



<script>
$(function(){
		$(".gall").slick({
			
			prevArrow: $('.prev'),
			nextArrow: $('.next')
			
		});
	})
</script>
<?include("../include/footer.php");?>
