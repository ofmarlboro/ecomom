<?
	$PageName = "K01";
	$SubName = "K0104";
	include("../include/head.php");
	include("../include/header.php");
?>

<!--Container-->

<div id="container">
	<?include("../include/sub_top.php");?>
	<!-- <div class="store_intro_wrap store_intro_wrap00 store_intro_wrap001">
		<div class="store_intro">
			<div class="inner clearfix">
				<h1>
					롯데마트 유아간식코너에서 산골간식을 만나세요.
				</h1>
				<ul style="border-top: 1px solid #CECECE;margin-top: 57px;border-bottom: 0;">
					<li>
						<a href="javascript:;">
						<div class="brown">
							[서울]
						</div>
						<strong>청량리점</strong></a>
					</li>
					<li>
						<a href="javascript:;">
						<div class="brown">
						</div>
						<strong>송파점</strong></a>
					</li>
					<li>
						<a href="javascript:;">
						<div class="brown">
						</div>
						<strong>서초점</strong></a>
					</li>
					<li>
						<a href="javascript:;">
						<div class="brown">
						</div>
						<strong>은평점</strong></a>
					</li>
				</ul>
				<ul style="border-top: 1px solid #CECECE;margin-top: 57px;border-bottom: 0;">
					<li>
						<a href="javascript:;">
						<div class="brown">
							[경기]
						</div>
						<strong>광교점 </strong></a>
					</li>
					
					<li>
						<a href="javascript:;">
						<div class="brown">
						</div>
						<strong>시흥배곧점</strong></a>
					</li>
					<li>
						<a href="javascript:;">
						<div class="brown">
						</div>
						<strong>김포한강점</strong></a>
					</li>
				</ul>
				<ul style="border-top: 1px solid #CECECE;margin-top: 57px;border-bottom: 0;">
					<li>
						<a href="javascript:;">
						<div class="brown">
							[인천]
						</div>
						<strong>송도점 </strong></a>
					</li>
					<li>
						<a href="javascript:;">
						<div class="brown">
						</div>
						<strong>계양점</strong></a>
					</li>
					<li>
						<a href="javascript:;">
						<div class="brown">
						</div>
						<strong>삼산점</strong></a>
					</li>
				</ul>
				<ul style="border-top: 1px solid #CECECE;margin-top: 30px;border-bottom: 0;">
					<li>
						<a href="javascript:;">
						<div class="brown">
							[충남]
						</div>
						<strong>성전점 </strong></a>
					</li>
				</ul>
				<ul style="border-top: 1px solid #CECECE;margin-top: 30px;border-bottom: 0;">
					<li>
						<a href="javascript:;">
						<div class="brown">
							[강원]
						</div>
						<strong>춘천점 </strong></a>
					</li>
				</ul>
				<ul style="border-top: 1px solid #CECECE;margin-top: 30px;border-bottom: 0;">
					<li>
						<a href="javascript:;">
						<div class="brown">
							[경북]
						</div>
						<strong>구미점 </strong></a>
					</li>
					
				</ul>
				<ul style="border-top: 1px solid #CECECE;margin-top: 30px;border-bottom: 0;">
					<li>
						<a href="javascript:;">
						<div class="brown">
							[경남]
						</div>
						<strong>장유점 </strong></a>
					</li>
					
					<li>
						<a href="javascript:;">
						<div class="brown">
						</div>
						<strong>양덕점</strong></a>
					</li>
					<li>
						<a href="javascript:;">
						<div class="brown">
						</div>
						<strong>진주점</strong></a>
					</li>
				</ul>
				<ul style="border-top: 1px solid #CECECE;margin-top: 30px;border-bottom: 0;">
					<li>
						<a href="javascript:;">
						<div class="brown">
							[전북]
						</div>
						<strong>익산점 </strong></a>
					</li>
				</ul>
				<ul style="border-top: 1px solid #CECECE;margin-top: 30px;border-bottom: 0;">
					<li>
						<a href="javascript:;">
						<div class="brown">
							[전남]
						</div>
						<strong>월드컵점 </strong></a>
					</li>
					<li>
						<a href="javascript:;">
						<div class="brown">
						</div>
						<strong>남악점</strong></a>
					</li>
				</ul>
			</div>
		</div>
	</div> -->

	<!-- <div class="ac mt95">
	<img src="/image/sub/lottemart.jpg" alt="">
	</div> -->
	
	<div class="store_intro_wrap store_intro_wrap00 store_intro_wrap001">
		<div class="inner clearfix">

			<div>
				<img src="/image/sub/lottermart02.jpg" alt="" />
			</div>
		</div>
	</div>
</div>
<!--END Container-->
<script>
	function openView(no){

		var y = $(".openView"+no).offset().top;
		$("html, body").animate({ scrollTop: y - 100});


	}

	<?if(@$open_view_no != ""){?>
		openView('<?=@$open_view_no?>');
	<?}?>
</script>
<?include("../include/footer.php");?>
