		<div class="inner mypage">
			<h2 class="mt30">회원가입 약관</h2>
			<div class="join01">
			<form name="join_form" id="join_form" action="?agree=1" method="post">
				<div class="ta"><?=$agreement->content?></div>
				<input type="checkbox" id="agree01" name="agree01" msg="약관에 동의해주세요." value="1"><label for="agree01">회원가입약관에 동의합니다.</label>

				<h2 class="mt30">개인정보처리방침</h2>
				<div class="ta"><?=$safeguard->content?></div>
				<input type="checkbox" id="agree02" name="agree02" msg="개인정보취급방침에 동의해주세요." value="1"><label for="agree02">개인정보처리방침에 동의합니다.</label>
				<div class="ac mt20">
					<a href="javascript: frmChk('join_form');" class="btn_g fz16">회원가입</a>
				</div>
			</form>
			</div>

			<form name="sns_info" id="sns_info" method="post">
				<input type="hidden" name="sns_userid" id="sns_userid">
				<input type="hidden" name="sns_passwd" id="sns_passwd">
				<input type="hidden" name="sns_name" id="sns_name">
			</form>

			<h2 class="mt50">SNS 로그인</h2>
				<ul class="sns_login">
					<!-- <li><a href="#"><img src="/image/sub/sns01.jpg" alt="">페이스북으로 시작하기</a></li> -->
					<li><div id="naver_id_login" style="display:inline;"></div><a href="javascript:;" id="nil">네이버로 시작하기</a></li>
					<li><a href="javascript: loginWithKakao();"><img src="/image/sub/sns03.jpg" alt="">카카오톡 시작하기</a></li>
				</ul>

			<?php
			//kakao
			?>
			<script src="https://developers.kakao.com/sdk/js/kakao.min.js"></script>
			<script type="text/javascript">
				Kakao.init('2dcd9e843e4d0e2c2e50352adc1672a4');
				function getKakaotalkUserProfile(){
					Kakao.API.request({
						url: '/v2/user/me',
						success: function(res) {
							//alert('카카오톡에 로그인 되었습니다.');
							$.ajax({
								method: "POST",
								url: "/m/html/dh_member/kkojoin",
								data:{"userid":res.id},
								dataType:"json",
								cache:false,
								success: function(data){
									console.log(data);
									if(data.is_member == "no"){
										$("#sns_userid").val(data.userid);
										$("#sns_passwd").val(data.passwd);
										$("#sns_info").attr("action","/m/html/dh_member/join/?agree=1");
										$("#sns_info").submit();
									}else if(data.is_member == "yes"){
										$("#sns_userid").val(data.userid);
										$("#sns_passwd").val(data.passwd);
										$("#sns_info").attr("action","/m/html/dh_member/login");
										$("#sns_info").submit();
									}
								},
								error:function(xhr){
									xhr.responseText;
								}
							});
						},
						fail: function(error) {
							console.log(error);
						}
					});
				}
				function loginWithKakao() {
					Kakao.Auth.login({
						success: function(authObj) {
							//alert(JSON.stringify(authObj));
							getKakaotalkUserProfile();
						},
						fail: function(err) {
							//alert(JSON.stringify(err));
							alert('카카오 연동 로그인에 실패 하였습니다.');
						}
					});
				};
			</script>

			<?php
			//naver
			?>
			<script type="text/javascript" src="https://static.nid.naver.com/js/naverLogin_implicit-1.0.3.js" charset="utf-8"></script>
			<script type="text/javascript">
				$(function(){
					$("#nil").on('click',function(){
						$("#naver_id_login_anchor").trigger('click');
					});
				});

				var naver_id_login = new naver_id_login("FDQ_CLgBTbw8tq5iwsbe", "https://<?=$_SERVER['HTTP_HOST']?>/m/naver/callback.php");
				var state = naver_id_login.getUniqState();
				naver_id_login.setButton("green", 1,20);
				naver_id_login.setDomain("http://<?=$_SERVER['HTTP_HOST']?>");
				naver_id_login.setState(state);
				naver_id_login.setPopup();
				naver_id_login.init_naver_id_login();
			</script>

		</div>

<?php
/*
		<div class="my_cont clearfix">
			<div class="fl join">
			<form name="join_form" id="join_form" action="?agree=1" method="post">
				<div class="my_tit">
					회원가입 약관
				</div>
				<div class="join-condition">
					<?=$agreement->content?>
				</div>

				<input type="checkbox" id="agree01" name="agree01" msg="약관에 동의해주세요." value="1"><label for="agree01">회원가입약관에 동의합니다.</label>
				<div class="my_tit mt30">
					개인정보처리방침
				</div>
				<div class="join-condition">
					<?=$safeguard->content?>
				</div>
				<input type="checkbox" id="agree02" name="agree02" msg="개인정보취급방침에 동의해주세요." value="1"><label for="agree02">개인정보처리방침에 동의합니다.</label>
				<div class="ac mt20">
					<a href="javascript: frmChk('join_form');" class="btn_big">다음단계</a>
				</div>
			</form>
			</div>


			<div class="fr join02">
				<div class="my_tit">
					SNS 로그인
				</div>
				<ul class="sns_login">
					<li><a href="#"><img src="/image/sub/sns01.jpg" alt="">페이스북으로 시작하기</a></li>
					<li><a href="#"><img src="/image/sub/sns02.jpg" alt="">네이버로 시작하기</a></li>
					<li><a href="#"><img src="/image/sub/sns03.jpg" alt="">카카오톡으로 시작하기</a></li>
				</ul>
			</div>

		</div>
*/
?>