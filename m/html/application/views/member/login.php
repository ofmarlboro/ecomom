<?
//	if(isset($go_url)){
//		$go_url_arr = explode("?",$go_url);
//		$qs_tmp = explode("&",$_SERVER['QUERY_STRING']);
//		$qs = $qs_tmp[1];
//		$cnt = count($go_url_arr);
//		if($cnt){ $go_url = $go_url."&lg=1&".$qs; }else{ $go_url = $go_url."?lg=1&".$qs; }
//	}
?>

<form name="sns_info" id="sns_info" method="post">
	<input type="hidden" name="sns_userid" id="sns_userid">
	<input type="hidden" name="sns_passwd" id="sns_passwd">
	<input type="hidden" name="sns_name" id="sns_name">
</form>


	<div class="inner mypage">
		<h2 class="mt20">
			<!-- 로그인 -->
		</h2>
		<div class="shop-login-box">
			<!-- 로그인 필드 -->
			<div class="login-field">
			<form method="post" name="login_form" onSubmit="mainLoginInputSendit();event.returnValue = false;" action="<?=cdir()?>/dh_member/login">
			<input type="hidden" name="go_url" value="<? echo isset($go_url) ? $go_url : ""; ?>">
				<p>
					<label for="id" class="left">아이디</label>
					<input type="text" id="id" class="right" name="userid" onKeyDown="mainLoginInputSendit();">
				</p>
				<p>
					<label for="password" class="left">비밀번호</label>
					<input type="password" id="password" class="right" name="passwd" onKeyDown="mainLoginInputSendit();">
				</p>
				<p>
					<a href="javascript: go_login();" class="btn_login">로그인</a>
				</p>

				<p class="lg-msg ac">
					<!-- <input type="checkbox" id="save-id">
					<label for="save-id">아이디 저장</label>
					<span class="ml10"></span> -->
					<input type="checkbox" id="login-auto" name="auto_login" value="1">
					<label for="login-auto">자동로그인</label>
				</p>

			</form>
<hr>

				<p class="gray"><a href="<?=cdir()?>/dh_member/find_id">
				아이디찾기
				</a>
				&nbsp;
				<a href="<?=cdir()?>/dh_member/find_pw">
				비밀번호찾기
				</a>
				&nbsp;
				<a href="<?=cdir()?>/dh_member/join">
				회원가입
				</a>

				</p>


				<ul class="gray lh13">
					<!-- <li>
						※ 아이디와 비밀번호를 입력하세요.
					</li> -->
					<li class="mb5" style="">
						※ 비밀번호는 대소문자를 구별합니다.
					</li>
					<li class="mb5">※<strong style="text-decoration: underline;">첫 구매고객 선물은 본홈페이지 회원</strong>만 해당됩니다

</li>
<li class="mb5">SNS회원/네이버회원은 해당되지 않습니다</li>
<li class="mb5">첫고객이 아닌경우, 배송지 중복의 경우 모두 해당되지 않습니다</li>
				</ul>

				<ul class="sns_login ">
			<!-- <li>
				<a href="#">
				<img src="/image/sub/sns01.jpg" alt="">페이스북으로 시작하기
				</a>
			</li> -->
			<li><div id="naver_id_login" style="display:inline;"></div><a href="javascript:;" id="nil">네이버로 시작하기</a></li>
			<li><a href="javascript: loginWithKakao();"><img src="/image/sub/sns03.jpg" alt="">카카오톡 시작하기</a></li>
		</ul>

			</div>

			<!-- END 로그인 필드 -->
		</div>


	</div>


<script>

	$(function(){
		$("#login-auto").click(function(){
			if (this.checked) {
				this.checked = confirm("자동로그인을 사용하시면 다음부터 회원아이디와 비밀번호를 입력하실 필요가 없습니다.\n\n공공장소에서는 개인정보가 유출될 수 있으니 사용을 자제하여 주십시오.\n\n자동로그인을 사용하시겠습니까?");
			}
		});
	});

	function mainLoginInputSendit() {
		if(event.keyCode==13) {
			go_login();
		}
	}

	function go_login()
	{
		var form = document.login_form;

		if(form.userid.value==""){
			alert("아이디를 입력해주세요.");
			form.userid.focus();
			return;
		}else if(form.passwd.value==""){
			alert("비밀번호를 입력해주세요.");
			form.passwd.focus();
			return;
		}else{
	//		alert(form.action);
			form.submit();
		}
	}


	function mainOrderInputSendit() {
		if(event.keyCode==13) {
			go_order();
		}
	}


	function go_order()
	{
		var form = document.nologin_order_form;

		if(form.email.value==""){
			alert("이메일을 입력해주세요.");
			form.email.focus();
			return;
		}else if(form.trade_code.value==""){
			alert("주문코드를 입력해주세요.");
			form.trade_code.focus();
			return;
		}else{
			form.action="<?=cdir()?>/dh_order/shop_order_detail/"+form.trade_code.value;
			form.submit();
		}
	}


</script>


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
	naver_id_login.setDomain("https://<?=$_SERVER['HTTP_HOST']?>");
	naver_id_login.setState(state);
	naver_id_login.setPopup();
	naver_id_login.init_naver_id_login();
</script>

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