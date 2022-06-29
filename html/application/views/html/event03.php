<?
	$PageName = "K07";
	$SubName = "K0703";
	include("../include/head.php");
	include("../include/header.php");
?>
<script type="text/javascript">
	//해시태그 넘어온값 받아서 클릭 효과 부여함
	var hashtag = location.hash.substring(1, location.hash.length).replace(/ /gi, '%20');
	if(hashtag){
		$(function(){
			adView(hashtag);
		});
	}
</script>

<!--Container-->

<div id="container">
	<?include("../include/sub_top.php");?>
	<div class="inner ac pt60">
		<!--<a href="/html/dh_board/views/64164?">
			<img src="/image/sub/sangol_FirstGift_details_10.jpg" alt="">
		</a>-->
		<a href="http://www.ecomommeal.co.kr/html/dh/bfood_order_regular1/?recom_idx=1" style="display: block;">
			<img src="/image/sub/sangol_FirstGift_details_01.jpg" alt="">
			<iframe width="860" height="490" src="https://www.youtube.com/embed/Cel_cuCu210" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
			<img src="/image/sub/event_0303_01.jpg" alt="">
			<img src="/image/sub/event_0303_02.jpg" alt="">
			<img src="/image/sub/event_0303_03_220607.jpg" alt="">

			<img src="/image/sub/event_thankyou_img01.jpg" alt="">
			<a href="/html/dh/thankyou">
				<img src="/image/sub/event_thankyou_img02.jpg" alt="">
			</a>
			<img src="/image/sub/event_thankyou_img03.jpg" alt="">

			<img src="/image/sub/event_0303_04.jpg" alt="">
			<img src="/image/sub/event_0303_04-2.jpg" alt="">
			<img src="/image/sub/event_0303_05.jpg" alt="">
			<!--<img src="/image/sub/event_0303_06.jpg" alt="">
			<a href="/html/dh_product/prod_list/?cate_no=3"><img src="/image/sub/event_0303_07.jpg" alt=""></a>-->


			<img src="/image/sub/sangol_FirstGift_details_07.jpg" alt="">
			<img src="/image/sub/sangol_FirstGift_details_08.jpg" alt="">
			<a href="/html/dh/bfood_order_regular1/?recom_idx=1"><img src="/image/sub/sangol_FirstGift_details_09.jpg" alt=""></a>
			</a>
	</div>
</div>
<!--END Container-->



<?include("../include/footer.php");?>
