<?
	$PageName = "FREE_SELECT";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

<!--Container-->

<div id="container" style="background-color:#F0F0f0">
	<?include("../include/top_menu.php");?>
			<!-- 탭메뉴 -->
			<div class="oe_menu order_opt">
				<div class="selbox">
					<button type="button" onClick="toggleSelBox(this, event);"><span class="week_day_count_span">낱개주문(자유배송)</span></button>
					<ul>
						<li>
							<input type="radio" id="menu01" onclick="location.href='regular01.php'">
							<label for="menu01">영양식단(정기배송)</label>
						</li>
						<li>
							<input type="radio" id="menu02" onclick="location.href='free_list.php'">
							<label for="menu02">낱개주문(자유배송)</label>
						</li>
					</ul>
				</div>

			</div>
			<script type="text/javascript" src="/js/orderPage.js"></script>
			<!-- //탭메뉴  -->

	<!-- inner -->
	<div class="inner pb50">
		<div class="header_img">
			<img src="/_data/file/subinfo/d89263783cd98b851c672175b0e0bace.jpg" alt="" style="width:100%; ">
			<a href="#">준비기 상세보기</a>
			<span><img src="/image/sub/r_circle1.png" alt="당일발송 주문마감 - AM 7:00"></span>
			<button type="button" class="plain" onClick="menuPop();"><img src="/image/sub/r_circle2.png" alt="월별식단표"></button>
		</div>
		<h1 class="tit04">이유식 준비기</h1>
		<p class="gray fz16"><b>생후 5개월 전후: </b> 보미(미음)</p>
		<p class="mt10">태어난 지 이제 대여섯 달 된 아이에게 이유식은 아주 힘든 도전입니다. 아이의 새로운 도전에 정성 어린 솜씨로 따뜻한 응원을 보내주세요.<br><b>하루 한 팩, 10배 미음, 1회 이유식 섭취량 30~50g</b></p>
		<!-- <a href="#" class="btn_gray w100 mt10">더보기+</a> -->

	</div>
	<!-- inner -->

	<!-- 하단 창 -->
	<div class="bottom_bar bottom_bar02">
		<a href="#" class="top_arw">
		<img src="/m/image/sub/bt_arw02.png" alt="" width="80px">
		<img src="/m/image/sub/arw03.jpg" alt="" class="arw">
		</a>
		<h1 class="tit02">
			상품선택보관함
		</h1>
		<div class="bottm_inner fp">
			<div class="tblTy04">
				<table>
					<colgroup>
					<col width="">
					<col width="">
					<col width="">
					<col width="18px">
					</colgroup>
					<tr>
						<th colspan="4">[3월 5일 화요일]</th>
					</tr>
					<tr>
						<th class="al">산골알밤</th>
						<td><span class="cart-vol">
							<button class="vol-down" onClick="goodsCntChange('d')">감소</button>
							<input name="goods_cnt" id="goods_cnt" type="text" readonly value="1">
							<button class="vol-up" onClick="goodsCntChange('u')">추가</button>
							</span></td>
						<td>6,000</td>
						<td><a href="#" class="cart_del"><img src="/m/image/sub/del.png" alt=""></a></td>
					</tr>
					<tr>
						<th class="al">산골알밤</th>
						<td><span class="cart-vol">
							<button class="vol-down" onClick="goodsCntChange('d')">감소</button>
							<input name="goods_cnt" id="goods_cnt" type="text" readonly value="1">
							<button class="vol-up" onClick="goodsCntChange('u')">추가</button>
							</span></td>
						<td>6,000</td>
						<td><a href="#" class="cart_del"><img src="/m/image/sub/del.png" alt=""></a></td>
					</tr>
					<tr>
						<th class="bg al">상품금액</th>
						<td class="orange bg">3개품목(수량 6개)</td>
						<td class="bg" colspan="2"><span class="pp">28,800</span>원</td>
					</tr>
				</table>
			</div>
			<div class="tblTy04 mt10 mb20">
				<table>
					<colgroup>
					<col width="">
					<col width="">
					<col width="">
					<col width="18px">
					</colgroup>
					<tr>
						<th colspan="4">[3월 5일 화요일]</th>
					</tr>
					<tr>
						<th class="al">산골알밤</th>
						<td><span class="cart-vol">
							<button class="vol-down" onClick="goodsCntChange('d')">감소</button>
							<input name="goods_cnt" id="goods_cnt" type="text" readonly value="1">
							<button class="vol-up" onClick="goodsCntChange('u')">추가</button>
							</span></td>
						<td>6,000</td>
						<td><a href="#" class="cart_del"><img src="/m/image/sub/del.png" alt=""></a></td>
					</tr>
					<tr>
						<th class="al">산골알밤</th>
						<td><span class="cart-vol">
							<button class="vol-down" onClick="goodsCntChange('d')">감소</button>
							<input name="goods_cnt" id="goods_cnt" type="text" readonly value="1">
							<button class="vol-up" onClick="goodsCntChange('u')">추가</button>
							</span></td>
						<td>6,000</td>
						<td><a href="#" class="cart_del"><img src="/m/image/sub/del.png" alt=""></a></td>
					</tr>
					<tr>
						<th class="bg al">상품금액</th>
						<td class="orange bg">3개품목(수량 6개)</td>
						<td class="bg" colspan="2"><span class="pp">28,800</span>원</td>
					</tr>
				</table>
			</div>
			<hr>
			<div class="pay clearfix mt20">
				<div class="fl">
					총 상품금액
				</div>
				<div class="fr">
					<em>89,650</em>원
				</div>
			</div>
			<p class="mt20 align-c mb30">
				<button type="button" class="plain"><img src="/image/sub/btn_order2.jpg" alt="주문하기"></button>
			</p>
		</div>
	</div>
	<script>



	/*var flag = null;
		$('.top_arw').on('click',function(e){
            e.preventDefault();
		    if (flag == 1) {
				$(this).find(".arw").css('transform', 'rotate(0deg)');
			  $(this).parent().css('bottom', '0');

                flag = null;
			} else {
				$(this).find(".arw").css('transform', 'rotate(180deg)');
			  $(this).parent().css('bottom', '-342px');
				flag = 1;
			}
        })*/


			var flag = null;
		$('.top_arw').on('click',function(e){
            e.preventDefault();
		    if (flag == 1) {
				$(this).find(".arw").css('transform', 'rotate(0deg)');
			//  $(this).parent().css('top', '285px').css('bottom', '0');
			  $(this).parent().toggleClass('down');
			 

              flag = null;
			} else {
				$(this).find(".arw").css('transform', 'rotate(180deg)');
			//  $(this).parent().css('bottom', '-342px').css('top', 'auto');
			  $(this).parent().toggleClass('down');
				flag = 1;
		}
     })
	</script>




	</script>

	<!-- //하단 창 -->

</div>

<!--END Container-->

<? include('../include/footer.php') ?>
