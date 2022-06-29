<script type="text/javascript">
<!--
	alert("샘플서비스는 2020년 6월 30일 부로 종료 되었습니다.");
	location.href="/m/html/dh_board/views/50517";
//-->
</script>
<?
	$PageName = "SAMPLE_ORDER";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

<!--Container-->

	<script type="text/javascript">
	<!--
		function sample_apply(gidx){
			frmChk('sample_frm_'+gidx);
		}
	//-->
	</script>


	<!-- 레이어 팝업 -->

	<script type="text/javascript">
		$(function(){
			$(".popup__layer, .layer__close").on("click", function(){
				$(".popup__wrap").hide();

				return false;
			})
		})
	</script>


	<div class="popup__wrap">
		<a href="https://ecomommeal.co.kr/m/html/dh_board/views/50517?" class="sample__popup">
			<div class="layer__close"></div>
		</a>
		<div class="popup__layer"></div>
	</div>

	<!-- $레이어 팝업 -->

<div id="container">
	<?include("../include/top_menu.php");?>
	<?include("../include/view_tab02.php");?>

	<!-- inner -->
	<div class="pb50">
		<div class="header_img">
			<img src="/_data/file/subinfo/<?=$cate_info->upfile1?>" alt="" onerror="this.src='/image/default.jpg'">

			<span><img src="/m/image/sub/r_circle1.png" alt="당일발송 주문마감 - AM 7:00"></span>
			<!-- <button type="button" class="plain" onClick="menuPop();"><img src="/image/sub/r_circle2.png" alt="월별식단표"></button> -->
			<ul class="new_list">
				<?php
				if($cate_info->foodtable_use == "Y"){	//월별 식단표 사용여부
					?>
					<li class="list01"><a href="#" onClick="menuPop_mobile('<?=$recom_idx?>');"></a></li>
					<?php
				}

				if($cate_info->moreview_use == "Y"){	//이유식 상세보기 설명 사용여부
					?>
					<li class="list02"><a href="#" onClick="menuView01();"></a></li>
					<?php
				}
				?>
				<li class="list03"><a href="#" onClick="menuView02();"></a></li>
			</ul>
		</div>

		<!-- <a href="#" class="btn_gray w100 mt10">더보기+</a> -->

		<!-- 하단 창 -->


		<?include("../include/view_tab03.php");?>
		<div class="bottm_inner">

			<?php
			if(!$sample_orderable){
			?>
			<h3 class="tit_orange mt10" style="background-color:#777;">금일 샘플신청은 없습니다.</h3>
			<?php
			}
			else{
				if($sample_cnt > 0){
				?>
				<h3 class="tit_orange mt10"><?=date("m월 d일")?> 신청가능 <?=$sample_cnt?>건</h3>

				<p class="gray mt10"> ※에코맘의 이유식을 부담없이 먼저 체험해보세요. 매일 선착순 20분께 샘플을 보내드립니다.<br>
					※금일 신청하신 샘플은 <span class="orange"><?=$sample_deliv_date_text?>(<?=$sample_deliv_date_week_name?>요일)</span>에 배송됩니다. </p>
				<?php
				}
				else{
					?>
					<h3 class="tit_orange mt10" style="background-color:#777;"><?=date("m월 d일")?> 샘플신청 마감</h3>
					<?php
				}
			}
			?>

			<ul class="clearfix sam_list">

				<?php
				if($sample_list){
					$sl_cnt = 0;
					foreach($sample_list as $sl){
						$sl_cnt++;
					?>
				<li class="<?=($sl_cnt%2 == 0)?"mr0":"";?>">
					<form name="sample_frm_<?=$sl->idx?>" id="sample_frm_<?=$sl->idx?>" action="<?=cdir()?>/dh_order/sample_cart" method="post">
						<input type="hidden" name="userid" value="<?=$this->session->userdata('USERID')?>">
						<input type="hidden" name="code" value="<?=$this->session->userdata('CART')?>">
						<input type="hidden" name="goods_name" value="<?=$sl->name?>">
						<input type="hidden" name="deliv_addr" value="home">
						<input type="hidden" name="date_bind" value="<?=$sample_deliv_date?>">
						<input type="hidden" name="goods_idx" value="<?=$sl->idx?>">
						<input type="hidden" name="goods_origin_price" value="0">
						<input type="hidden" name="goods_price" value="0">
						<input type="hidden" name="goods_cnt" value="1">
						<input type="hidden" name="total_price" value="0">
					</form>

					<img src="/_data/file/goodsImages/<?=$sl->list_img?>" alt="<?=$sl->name?>" onerror="this.src='/image/default.jpg'">
					<p><?=$sl->name?></p>
					<a href="
					<?php
					/*
					if(date("H:i") >= "09:00"){
						if($sample_call){
							if($this->session->userdata('USERID')){
								?>
								javascript:sample_apply('<?=$sl->idx?>');
								<?
							} else{
								?>
								javascript:alert('로그인 후 주문이 가능합니다.');location.href='<?=cdir()?>/dh_member/login';
								<?
							}
						}else{
							if(!$sample_orderable){
								?>
								javascript:alert('주문이 불가능 합니다.');
								<?
							}else{
								?>
								javascript:alert('샘플은 한 ID당 1번만 신청 가능합니다.');
								<?
							}
						}
					}
					else{
						?>
						javascript:alert('오전 9시 부터 신청 가능합니다.');
						<?php
					}
					*/
						if($sample_orderable and date("H:i") >= "09:00" and date("H:i") <= "11:00" and $sample_call){
							if($this->session->userdata('USERID')){
							?>
							javascript:sample_apply('<?=$sl->idx?>');
							<?
							}
							else{
							?>
							javascript:alert('로그인 후 주문해 주세요.');location.href='/html/dh_member/login';
							<?php
							}
						}
						else{
							if(!$sample_orderable){
							?>
							javascript:alert('주문이 불가능 합니다.');
							<?
							}
							else if(!$sample_call){
								if($user_trade_cnt){
								?>
								javascript:alert('샘플은 한 ID당 1번만 신청 가능합니다.');
								<?
								}
								else{
								?>
								javascript:alert('샘플신청이 마감되었습니다.');
								<?
								}
							}
							else{
							?>
							javascript:alert('오전 9시 부터 신청 가능합니다.');
							<?php
							}
						}
					?>
					" class="btn_g">상품선택</a>
				</li>
					<?php
					}
				}
				?>
			</ul>
			<div class="sp_odlist">
				<h1>
					샘플 신청 리스트
				</h1>
				<h2>
					샘플신청은 오전 9시부터<br>
					선착순으로 진행됩니다.
				</h2>
				<ul>
					<?php
					if($sample_order_user_list){
						$sl_cnt = 0;
						foreach($sample_order_user_list as $sl){
							$sl_cnt++;
						?>
						<li><?=$sl_cnt?>. <?=preg_replace('/.(?!..)/u','○',$sl->name);?>님 <?=$sl->goods_name?></li>
						<?php
						}
					}
					else{
					?>

					<?php
					}
					?>
				</ul>
			</div>

			<div class="sp_odlist">
				<h1>
					샘플신청 대기 리스트
				</h1>
				<h2>
					샘플신청은 오전 9시부터<br>
					선착순으로 진행됩니다.
				</h2>
				<ul>
					<?php
					if($sample_order_hold_user_list){
						$sl_cnt = 0;
						foreach($sample_order_hold_user_list as $sl){
							$sl_cnt++;
						?>
						<li><?=$sl_cnt?>. <?=preg_replace('/.(?!..)/u','○',$sl->name);?>님 <?=$sl->goods_name?></li>
						<?php
						}
					}
					else{
					?>

					<?php
					}
					?>
				</ul>
			</div>
		</div>





	</div>
	<!-- inner -->







	<script>
/*	var flag = null;
$('.top_arw').on('click',function(e){
e.preventDefault();
if (flag == 1) {
$(this).find(".arw").css('transform', 'rotate(0deg)');
// $(this).parent().css('top', '285px').css('bottom', '0');
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
		$('.bottom_bar02').css('height', '1000px');
		//$('.bottm_inner').css('height', '900px');
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
      //  $('.bottm_inner').css('height', '840px');
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
     //   $('.bottm_inner').css('height', '690px');
        var flag = null;
        $('.top_arw').on('click',function(e){
            e.preventDefault();
            if (flag == 1) {
                $(this).find(".arw").css('transform', 'rotate(0deg)');
                $(this).parent().css('bottom', '0');
                flag = null;
            } else {
                $(this).find(".arw").css('transform', 'rotate(180deg)');
                $(this).parent().css('bottom', '-680px');
                flag = 1;
            }
        });
    }


    else if (ww > 800){
        $('.bottom_bar02').css('height', '500px');
     //   $('.bottm_inner').css('height', '490px');
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
     //   $('.bottm_inner').css('height', '350px')
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
  //  $('.bottm_inner').css('height', '310px')

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
 //   $('.bottm_inner').css('height', '240px')

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
 //   $('.bottm_inner').css('height', '100px')

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

<!-- 20180524 -->
				<script>
				function menuView01(){
					$("#menu_dt_wrap01").fadeIn('fast');
				}
				function closeMenuView01(){
					$("#menu_dt_wrap01 .scroll").scrollTop(0);
					$("#menu_dt_wrap01").hide();
				}


				function menuView02(){
					$("#menu_dt_wrap02").fadeIn('fast');
				}
				function closeMenuView02(){
					$("#menu_dt_wrap02 .scroll").scrollTop(0);
					$("#menu_dt_wrap02").hide();
				}


				</script>

				<div id="menu_dt_wrap01" style="display: none;">
					<div id="menu_dt01">
						<h2 class="htit"><?=$cate_info->title_b?> <span>(<?=$cate_info->title_m?>)</span></h2>
						<div class="scroll">
							<?php
							if($cate_info->mobile_detail){
							?>
							<img src="/_data/file/subinfo/<?=$cate_info->mobile_detail?>" alt="">
							<?php
							}
							?>
						</div>
						<button type="button" class="plain btn_close02" title="닫기" onclick="closeMenuView01();">닫기</button>
					</div>
				</div>




				<div id="menu_dt_wrap02" style="display: none;">
					<div id="menu_dt02">
						<h2 class="htit">이유식 데우는 법</h2>
						<div class="scroll">
							<img src="/m/image/sub/noti.jpg" alt="">
						</div>
						<button type="button" class="plain btn_close02" title="닫기" onclick="closeMenuView02();">닫기</button>
					</div>
				</div>
<!--//20180524 -->

<? include('../include/footer.php') ?>
