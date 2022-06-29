<?php
include "menu_detail.php";
?>

	<script type="text/javascript">
	jQuery(document).ready(function($){
		//footer info
		$(".foot_logo").on("click", function(){
			$(this).toggleClass("on");
			$(".foot_fold").stop().slideToggle(200);
			$("html, body").stop().animate({scrollTop:document.body.clientHeight},200);
		});
	});
	</script>
	<!--Footer-->
	<div id="footer">
		<ul class="fnb">
			<?php
			if($this->session->userdata('USERID')){
			?>
			<li><a href="<?=cdir()?>/dh_member/logout">로그아웃</a></li>
			<li><a href="<?=$MYPAGE->url?>">정보수정</a></li>
			<?php
			}
			else{
			?>
			<li><a href="<?=$LOGIN->url?>">로그인</a></li>
			<li><a href="<?=$JOIN->url?>">회원가입</a></li>
			<?php
			}
			?>
			<li><a href="<?=$K0901->url?>">이용약관</a></li>
			<li><a href="<?=$K0902->url?>">개인정보 취급방침</a></li>
			<li><a href="/html/dh/main/?pcv=Y">PC버전</a></li>
		</ul>

		<div class="f_cs" style="border-bottom: 0; padding-bottom: 0;">
			<div class="col">
				<p class="tit">상담전화 토닥토닥</p>
				<div class="cs_text">
					<a href="tel:055-884-2625" class="tel"><?=$shop_info['shop_tel1']?></a>
				</div>
				<!-- DH수정:이미지명 변경 -->
			</div>
			<div class="col">
				<p class="tit">상담시간 안내</p>
				<div class="cs_text">
					<p class="cs_info">
						월 ~ 금 <span>|</span>08:00 ~ 16:00<br>
						점심 <span>|</span>12:00 ~ 13:00<br>
						토요일, 일요일 및 공휴일 휴무
					</p>
				</div>
			</div>
		</div>

		<div class="f_cs" style="padding-top: 0;">
			<div class="col">
				<a href="tel:<?=$shop_info['shop_tel1']?>" class="btn"><img src="/m/image/common/f_call.png" width="16" height="16"/> 전화걸기</a>
			</div>
			<div class="col">
				<a href="<?=$K0807->url?>" class="btn"><img src="/m/image/common/f_qna.png" width="17" height="16"/> 문의하기</a>
			</div>
		</div>

		<button type="button" class="plain f_logo">
			<img src="/m/image/common/f_logo.png" alt="에코맘 산골이유식" width="129" height="20"/>
		</button>

		<div class="f_fold">
			<div class="inner">
				<div class="addr">
					<p><strong><?=$shop_info['shop_name']?></strong></p>
					<p class="mt5">대표자 : <?=$shop_info['shop_ceo']?>   |   주소 : <?=$shop_info['shop_address']?><br>
					사업자등록번호 : <?=$shop_info['shop_num']?> <a href="http://www.ftc.go.kr/bizCommPop.do?wrkr_no=6138164930&apv_perm_no=" target="_blank" class="underl">사업자 정보확인 &gt;</a><br>
					통신판매업 신고 : <?=$shop_info['shop_license']?> <br>
					전화 : <a href="tel:<?=$shop_info['shop_tel1']?>"><?=$shop_info['shop_tel1']?></a>   |   팩스 : <?=$shop_info['shop_fax']?><br>
					이메일 : <a href="mailto:<?=$shop_info['shop_email']?>"><?=$shop_info['shop_email']?></a><br>
					(주)이니페이 구매안전 서비스   <a href="https://mark.inicis.com/mark/popup_v1.php?no=67157&st=1411374082" target="_blank" class="underl">서비스 가입사실확인 &gt;</a></p>
				</div>
				<p class="cpright">© 2012-2017 <?=$shop_info['shop_name']?> All Rights Reserved.</p>
			</div>
		</div>

	</div><!--END Footer-->

 </div><!--END Wrap-->

<!-- Mirae Log Analysis Script Ver 1.0   -->
<script TYPE="text/javascript">
var mi_adkey = "rlxh";
var mi_is_defender = "";
var mi_dt=new Date(),mi_y=mi_dt.getFullYear(),mi_m=mi_dt.getMonth()+1,mi_d=mi_dt.getDate(),mi_h=mi_dt.getHours();
var mi_date=""+mi_y+(mi_m<=9?"0":"")+mi_m+(mi_d<=9?"0":"")+mi_d+(mi_h<=9?"0":"")+mi_h;
var mi_script = "<scr"+"ipt "+"type='text/javascr"+"ipt' src='//log1.toup.net/mirae_log.js?t="+mi_date+"' charset='utf-8' async='true'></scr"+"ipt>";
document.writeln(mi_script);
</script>
<!-- Mirae Log Analysis Script END  -->

 <!-- NAVER SCRIPT -->
<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script>
<script type="text/javascript">
if (!wcs_add) var wcs_add={};
wcs_add["wa"] = "s_3885f53e2d13";
if (!_nasa) var _nasa={};
wcs.inflow("ecomommeal.co.kr");
wcs_do(_nasa);
</script>

 </body>
</html>
