<?
	$PageName = "K01";
	$SubName = "K0102";
	include("../include/head.php");
	include("../include/header.php");
?>

<!--Container-->

<div id="container">
	<?include("../include/sub_top.php");?>

	<div class="inner">

<div class="gall_wrap">
	<ul class="gall mt50">
		<li>
			<img src="/image/sub/bb.jpg" alt="">
	
		</li>
		<li>		
			<img src="/image/sub/bb01.jpg" alt="">
		</li>
		<li>		
			<img src="/image/sub/bb02.jpg" alt="">
		</li>
		<li>		
			<img src="/image/sub/bb03.jpg" alt="">
		</li>
		<li>		
			<img src="/image/sub/bb04.jpg" alt="">
		</li>
		<li>		
			<img src="/image/sub/bb05.jpg" alt="">
		</li>
		<li>		
			<img src="/image/sub/bb06.jpg" alt="">
		</li>
		<li>		
			<img src="/image/sub/bb07.jpg" alt="">
		</li>
		<li>		
			<img src="/image/sub/bb08.jpg" alt="">
		</li>
		<li>		
			<img src="/image/sub/bb09.jpg" alt="">
		</li>
		<li>		
			<img src="/image/sub/bb10.jpg" alt="">
		</li>
		<li>		
			<img src="/image/sub/bb11.jpg" alt="">
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
			//	autoplay:true,
			prevArrow: $('.prev'),
			nextArrow: $('.next')
			//arrows:false
			//dots:true
		});
	})
</script>
<?include("../include/footer.php");?>
