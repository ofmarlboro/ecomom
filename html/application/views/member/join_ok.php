		<div class="my_cont">

			<div class="joinok">
				<p><span class="name"><?=$row->name?></span>님! 에코맘 산골이유식의 회원이 되신 것을 진심으로 환영합니다.<br>신규 회원가입을 하신 분들께는 <span class="red"><?=number_format($shop_info['point_register'])?></span>원을 적립해드립니다.</p>
				<ul>
					<li>이름 : <?=$row->name?></li>
					<li>아이디 :
						<?php
						if($row->regist_type == "sns"){
							$userid_arr = explode("_",$row->userid);
							if($userid_arr[0] == "kko"){
								echo "카카오연동 회원";
							}
							else{
								echo "네이버연동 회원";
							}
						}
						else{
							echo $row->userid;
						}
						?>
					</li>
					<li>이메일 : <?=$row->email?></li>
				</ul>
			</div>

			<div class="ac">
				<a href="/" class="btn_big">홈으로 이동</a>
			</div>
		</div>
<!-- 전환페이지 설정 -->
<script type="text/javascript" src="//wcs.naver.net/wcslog.js"></script> 
<script type="text/javascript"> 
var _nasa={};
_nasa["cnv"] = wcs.cnv("2","1");
</script> 


<script type="text/javascript">
      kakaoPixel('5114912039431747532').completeRegistration();
</script>
