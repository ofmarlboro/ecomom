<?
	$PageName = "DESSERT_LIST";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

<!--Container-->

<div id="container" style="background-color:#F0F0f0">
	<?include("../include/top_menu.php");?>
	<?include("../include/view_tab.php");?>
	<h1 class="tit02">
		주문
	</h1>
	<!-- inner -->
	<div class="inner pb50 pt20">
		<div class="header_img">
			<img src="/_data/file/subinfo/d89263783cd98b851c672175b0e0bace.jpg" alt="" style="width:100%; ">
			<a href="#">준비기 상세보기</a>
			<span><img src="/image/sub/r_circle1.png" alt="당일발송 주문마감 - AM 7:00"></span>
			<button type="button" class="plain" onclick="menuPop();"><img src="/image/sub/r_circle2.png" alt="월별식단표"></button>
		</div>
		<h1 class="tit04">
			이유식 준비기
		</h1>
		<p class="gray fz16"><b>생후 5개월 전후: </b> 보미(미음)</p>
		<p class="mt10">태어난 지 이제 대여섯 달 된 아이에게 이유식은 아주 힘든 도전입니다. 아이의 새로운 도전에 정성 어린 솜씨로 따뜻한 응원을 보내주세요.<br>
			<b>하루 한 팩, 10배 미음, 1회 이유식 섭취량 30~50g</b></p>
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
		<div class="bottm_inner">
			<p class="gray"> ※영양식단(정기배송)을 이용중이면, 무료배송일자를 선택하실 수 있습니다. </p>
			<ul class="clearfix des_list">
				<li>
					<a href="dessert_view.php">
					<img src="/m/image/sub/img01.jpg" alt="">
					<p>산골알밤</p>
					<b>2,300원</b>
					</a>
				</li>
				<li>
					<a href="dessert_view.php">
					<img src="/m/image/sub/img01.jpg" alt="">
					<p>산골알밤</p>
					<b>2,300원</b>
					</a>
				</li>
				<li class="mr0">
					<a href="">
					<img src="/m/image/sub/img01.jpg" alt="">
					<p>산골알밤</p>
					<b>2,300원</b>
					</a>
				</li>
				<li>
					<a href="dessert_view.php">
					<img src="/m/image/sub/img01.jpg" alt="">
					<p>산골알밤</p>
					<b>2,300원</b>
					</a>
				</li>
				<li>
					<a href="dessert_view.php">
					<img src="/m/image/sub/img01.jpg" alt="">
					<p>산골알밤</p>
					<b>2,300원</b>
					</a>
				</li>
				<li class="mr0">
					<a href="dessert_view.php">
					<img src="/m/image/sub/img01.jpg" alt="">
					<p>산골알밤</p>
					<b>2,300원</b>
					</a>
				</li>
			</ul>
			
			<!-- 페이징 -->
			<div class="board-pager mb50">
				<button type="button"><img src="/m/image/board_img/arrow_l_end.png" alt="맨 앞으로"></button>
				<button type="button"><img src="/m/image/board_img/arrow_l.png" alt="이전"></button>
				<a href="#" class="on">1</a>
				<a href="#">2</a>
				<a href="#">3</a>
				<button type="button"><img src="/m/image/board_img/arrow_r.png" alt="다음"></button>
				<button type="button"><img src="/m/image/board_img/arrow_r_end.png" alt="맨 뒤로"></button>
			</div>
			<!-- END 페이징 -->
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

	/* 	var flag = null;
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
     })*/





$(window).on('load resize', function(){
    ww=$(window).height()


	if (ww > 1300){
		$('.bottom_bar02').css('height', '990px');
		$('.bottm_inner').css('height', '940px');
		var flag = null;
		$('.top_arw').on('click',function(e){
			e.preventDefault();
			if (flag == 1) {
				$(this).find(".arw").css('transform', 'rotate(0deg)');
				$(this).parent().css('bottom', '0');
				flag = null;
			} else {
				$(this).find(".arw").css('transform', 'rotate(180deg)');
				$(this).parent().css('bottom', '-970px');
				flag = 1;
			}
		});
	}


 else if (ww > 1200){
        $('.bottom_bar02').css('height', '900px');
        $('.bottm_inner').css('height', '890px');
        var flag = null;
        $('.top_arw').on('click',function(e){
            e.preventDefault();
            if (flag == 1) {
                $(this).find(".arw").css('transform', 'rotate(0deg)');
                $(this).parent().css('bottom', '0');
                flag = null;
            } else {
                $(this).find(".arw").css('transform', 'rotate(180deg)');
                $(this).parent().css('bottom', '-880px');
                flag = 1;
            }
        });
    }




		 else if (ww > 1000){
        $('.bottom_bar02').css('height', '650px');
        $('.bottm_inner').css('height', '640px');
        var flag = null;
        $('.top_arw').on('click',function(e){
            e.preventDefault();
            if (flag == 1) {
                $(this).find(".arw").css('transform', 'rotate(0deg)');
                $(this).parent().css('bottom', '0');
                flag = null;
            } else {
                $(this).find(".arw").css('transform', 'rotate(180deg)');
                $(this).parent().css('bottom', '-630px');
                flag = 1;
            }
        });
    }


    else if (ww > 800){
        $('.bottom_bar02').css('height', '440px');
        $('.bottm_inner').css('height', '430px');
        var flag = null;
        $('.top_arw').on('click',function(e){
            e.preventDefault();
            if (flag == 1) {
                $(this).find(".arw").css('transform', 'rotate(0deg)');
                $(this).parent().css('bottom', '0');
                flag = null;
            } else {
                $(this).find(".arw").css('transform', 'rotate(180deg)');
                $(this).parent().css('bottom', '-420px');
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
    $('.bottom_bar02').css('height', '280px');
    $('.bottm_inner').css('height', '270px')

    var flag = null;
    $('.top_arw').on('click',function(e){
    e.preventDefault();
    if (flag == 1) {
    $(this).find(".arw").css('transform', 'rotate(0deg)');
    $(this).parent().css('bottom', '0');
    

    flag = null;
    } else {
    $(this).find(".arw").css('transform', 'rotate(180deg)');
    $(this).parent().css('bottom', '-260px');
    
    flag = 1;
    }
    })


    }


            else if (ww > 500){
    $('.bottom_bar02').css('height', '210px');
    $('.bottm_inner').css('height', '200px')

    var flag = null;
    $('.top_arw').on('click',function(e){
    e.preventDefault();
    if (flag == 1) {
    $(this).find(".arw").css('transform', 'rotate(0deg)');
    $(this).parent().css('bottom', '0');
   

    flag = null;
    } else {
    $(this).find(".arw").css('transform', 'rotate(180deg)');
    $(this).parent().css('bottom', '-190px');
   
    flag = 1;
    }
    })


    }


	  else {
    $('.bottom_bar02').css('height', '130px');
    $('.bottm_inner').css('height', '110px')

    var flag = null;
    $('.top_arw').on('click',function(e){
    e.preventDefault();
    if (flag == 1) {
    $(this).find(".arw").css('transform', 'rotate(0deg)');
    $(this).parent().css('bottom', '0');
    

    flag = null;
    } else {
    $(this).find(".arw").css('transform', 'rotate(180deg)');
    $(this).parent().css('bottom', '-110px');
    
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
