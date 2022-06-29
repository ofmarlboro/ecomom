<?
	$PageName = "FREE_DATE";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

<!--Container-->

<div id="container">
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
		<?include("../include/view_tab03.php");?>
		<div class="bottm_inner fp">
			<div class="fz22 mt10">
				배송 받을 날짜를 선태하여 주세요
			</div>
			<p class="gray mt10"> ※신선도를 유지하기 위해 배송일자에 따라 조리이유식이 달라집니다.<br>
				※정기배송을 이용중이면 배송받을 날짜에 무료배송이 가능합니다. </p>
			<div class="drawSchedule mt10 mb50">
				<div class="date_view">
					<span class="year">2017</span>년 <span class="month">04</span>월
					<a href="#" class="pre" title="이전">이전</a>
					<a href="#" class="next" title="다음">다음</a>
				</div>
				<div class="inner">
					<table>
						<colgroup>
						<col style="width:15%">
						<col style="width:14%">
						<col style="width:14%">
						<col style="width:14%">
						<col style="width:14%">
						<col style="width:14%">
						<col style="width:15%">
						</colgroup>
						<thead>
							<tr>
								<th scope="col" >일</th>
								<th scope="col">월</th>
								<th scope="col">화</th>
								<th scope="col">수</th>
								<th scope="col">목</th>
								<th scope="col">금</th>
								<th scope="col" >토</th>
							</tr>
						</thead>
						<tbody>
							<tr>
								<td class="gray"><a href="#">29</a></td>
								<td class="gray"><a href="#">30</a></td>
								<td><a href="#" class="check">1</a></td>
								<td><a href="#">2</a></td>
								<td><a href="#">3</a></td>
								<td><a href="#">4</a></td>
								<td ><a href="#">5</a></td>
							</tr>
							<tr>
								<td ><a href="#">6</a></td>
								<td><a href="#">7</a></td>
								<td><a href="#">8</a></td>
								<td><a href="#" class="check">9</a></td>
								<td><a href="#" class="check">10</a></td>
								<td><a href="#">11</a></td>
								<td ><a href="#">12</a></td>
							</tr>
							<tr>
								<td ><a href="#">13</a></td>
								<td><a href="#">14</a></td>
								<td><a href="#">15</a></td>
								<td><a href="#" class="today">16</a></td>
								<td><a href="#">17</a></td>
								<td><a href="#">18</a></td>
								<td ><a href="#">19</a></td>
							</tr>
							<tr>
								<td ><a href="#">20</a></td>
								<td><a href="#">21</a></td>
								<td><a href="#">22</a></td>
								<td><a href="#">23</a></td>
								<td><a href="#">24</a></td>
								<td><a href="#">25</a></td>
								<td ><a href="#">26</a></td>
							</tr>
							<tr>
								<td ><a href="#">27</a></td>
								<td><a href="#">28</a></td>
								<td><a href="#">29</a></td>
								<td><a href="#">30</a></td>
								<td><a href="#">31</a></td>
								<td class="gray"><a href="#">1</a></td>
								<td class="gray"><a href="#">2</a></td>
							</tr>
							<tr>
								<td class="gray"><a href="#">3</a></td>
								<td class="gray"><a href="#">4</a></td>
								<td class="gray"><a href="#">5</a></td>
								<td class="gray"><a href="#">6</a></td>
								<td class="gray"><a href="#">7</a></td>
								<td class="gray"><a href="#">8</a></td>
								<td class="gray"><a href="#">9</a></td>
							</tr>
						</tbody>
					</table>
				</div>
			</div>
		</div>
	</div>
	<script>



/*	var flag = null;
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
	        })


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
     })	*/

$(window).on('load resize', function(){
    ww=$(window).height()


	if (ww > 1300){
		$('.bottom_bar02').css('height', '1000px');
		$('.bottm_inner').css('height', '900px');
		var flag = null;
		$('.top_arw').on('click',function(e){
			e.preventDefault();
			if (flag == 1) {
				$(this).find(".arw").css('transform', 'rotate(0deg)');
				$(this).parent().css('bottom', '0');
				flag = null;
			} else {
				$(this).find(".arw").css('transform', 'rotate(180deg)');
				$(this).parent().css('bottom', '-980px');
				flag = 1;
			}
		});
	}


 else if (ww > 1200){
        $('.bottom_bar02').css('height', '850px');
        $('.bottm_inner').css('height', '840px');
        var flag = null;
        $('.top_arw').on('click',function(e){
            e.preventDefault();
            if (flag == 1) {
                $(this).find(".arw").css('transform', 'rotate(0deg)');
                $(this).parent().css('bottom', '0');
                flag = null;
            } else {
                $(this).find(".arw").css('transform', 'rotate(180deg)');
                $(this).parent().css('bottom', '-830px');
                flag = 1;
            }
        });
    }




		 else if (ww > 1000){
        $('.bottom_bar02').css('height', '700px');
        $('.bottm_inner').css('height', '690px');
        var flag = null;
        $('.top_arw').on('click',function(e){
            e.preventDefault();
            if (flag == 1) {
                $(this).find(".arw").css('transform', 'rotate(0deg)');
                $(this).parent().css('bottom', '0');
                flag = null;
            } else {
                $(this).find(".arw").css('transform', 'rotate(180deg)');
                $(this).parent().css('bottom', '-160px');
                flag = 1;
            }
        });
    }


    else if (ww > 800){
        $('.bottom_bar02').css('height', '500px');
        $('.bottm_inner').css('height', '490px');
        var flag = null;
        $('.top_arw').on('click',function(e){
            e.preventDefault();
            if (flag == 1) {
                $(this).find(".arw").css('transform', 'rotate(0deg)');
                $(this).parent().css('bottom', '0');
                flag = null;
            } else {
                $(this).find(".arw").css('transform', 'rotate(180deg)');
                $(this).parent().css('bottom', '-480px');
                flag = 1;
            }
        });
    }
    else if (ww > 700){
        $('.bottom_bar02').css('height', '380px');
        $('.bottm_inner').css('height', '350px')
        var flag = null;
        $('.top_arw').on('click',function(e){
            e.preventDefault();
            if (flag == 1) {
                $(this).find(".arw").css('transform', 'rotate(0deg)');
                $(this).parent().css('bottom', '0');
                flag = null;
            } else {
				$(this).find(".arw").css('transform', 'rotate(180deg)');
				$(this).parent().css('bottom', '-300px');
				flag = 1;
			 }
		})
	}



    else if (ww > 600){
    $('.bottom_bar02').css('height', '320px');
    $('.bottm_inner').css('height', '310px')

    var flag = null;
    $('.top_arw').on('click',function(e){
    e.preventDefault();
    if (flag == 1) {
    $(this).find(".arw").css('transform', 'rotate(0deg)');
    $(this).parent().css('bottom', '0');
    

    flag = null;
    } else {
    $(this).find(".arw").css('transform', 'rotate(180deg)');
    $(this).parent().css('bottom', '-300px');
    
    flag = 1;
    }
    })


    }


            else if (ww > 500){
    $('.bottom_bar02').css('height', '250px');
    $('.bottm_inner').css('height', '240px')

    var flag = null;
    $('.top_arw').on('click',function(e){
    e.preventDefault();
    if (flag == 1) {
    $(this).find(".arw").css('transform', 'rotate(0deg)');
    $(this).parent().css('bottom', '0');
   

    flag = null;
    } else {
    $(this).find(".arw").css('transform', 'rotate(180deg)');
    $(this).parent().css('bottom', '-230px');
   
    flag = 1;
    }
    })


    }


	  else {
    $('.bottom_bar02').css('height', '150px');
    $('.bottm_inner').css('height', '100px')

    var flag = null;
    $('.top_arw').on('click',function(e){
    e.preventDefault();
    if (flag == 1) {
    $(this).find(".arw").css('transform', 'rotate(0deg)');
    $(this).parent().css('bottom', '0');
    

    flag = null;
    } else {
    $(this).find(".arw").css('transform', 'rotate(180deg)');
    $(this).parent().css('bottom', '-130px');
    
    flag = 1;
    }
    })


    }




});




	</script>

	<!-- //하단 창 -->

</div>

<!--END Container-->

<? include('../include/footer.php') ?>
