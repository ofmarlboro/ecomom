<?
//	if(isset($go_url)){
//		$go_url_arr = explode("?",$go_url);
//		$qs_tmp = explode("&",$_SERVER['QUERY_STRING']);
//		$qs = $qs_tmp[1];
//		$cnt = count($go_url_arr);
//		if($cnt){ $go_url = $go_url."&lg=1&".$qs; }else{ $go_url = $go_url."?lg=1&".$qs; }
//	}

	//저장된 아이디 쿠키가 있는경우
	if($this->input->cookie("cookie_id")){
		$checked = "checked";
	}else{
		$checked = "";
	}
?>

<form name="sns_info" id="sns_info" method="post">
	<input type="hidden" name="sns_userid" id="sns_userid">
	<input type="hidden" name="sns_passwd" id="sns_passwd">
	<input type="hidden" name="sns_name" id="sns_name">
</form>

		<div class="my_cont clearfix">
			<div class="fl join">
				<div class="my_tit">
					로그인
				</div>
				<div class="shop-login-box">
					<!-- 로그인 필드 -->
					<form method="post" name="login_form" onSubmit="mainLoginInputSendit();event.returnValue = false;" action="<?=cdir()?>/dh_member/login">
					<input type="hidden" name="go_url" value="<? echo isset($go_url) ? $go_url : ""; ?>">
					<ul class="login-field clearfix">
						<li class="fl">
						<p>	<label for="mem-id">아이디</label>
							<input type="text" id="mem-id" name="userid" onKeyDown="mainLoginInputSendit();" value="<?=$this->input->cookie("cookie_id")?>"></p>
						<p><label for="mem-pw">비밀번호</label>
							<input type="password" id="mem-pw" name="passwd" onKeyDown="mainLoginInputSendit();"></p>

						</li>
						<li class="fr">
							<a href="javascript:go_login();" class="btn_login"><img src="/image/sub/lock.jpg" alt="">로그인</a>
						</li>
						<li class="w100 ac">
							<p class="lg-msg">
								<input type="checkbox" id="save_id" name="save_id" value="1" <?=$checked?>> <label for="save_id">아이디 저장</label>
								<!-- <span class="ml10"></span><input type="checkbox" id="login-auto"> <label for="login-auto">자동로그인</label> -->
							</p>
							<a href="<?=cdir()?>/dh_member/find_id">아이디 찾기</a><a href="<?=cdir()?>/dh_member/find_pw">비밀번호 찾기</a><a href="<?=cdir()?>/dh_member/join">회원가입</a>
						</li>

					</ul>
					<span class="line"></span>
					<ul class="gray">
						<li>※ 아이디와 비밀번호를 입력하세요.</li>
						<li>※ 비밀번호는 대소문자를 구별합니다.</li>
					</ul>
					</form>
					<!-- END 로그인 필드 -->
				</div>
			</div>

			<div class="fr join02">
				<div class="my_tit">
					SNS 로그인
				</div>
				<ul class="sns_login">
					<!-- <li><a href="javascript: facebooklogin();"><img src="/image/sub/sns01.jpg" alt="">페이스북으로 시작하기</a></li> -->
					<!-- <li><div id="naver_id_login" style="display:inline;"></div><a href="javascript: naver_login();">네이버로 시작하기</a></li> -->
					<li><div id="naver_id_login" style="display:none;"></div><a href="javascript: naver_login();"><img src="/image/sub/sns02.jpg" alt="">네이버로 시작하기</a></li>
					<li><a href="javascript: loginWithKakao();"><img src="/image/sub/sns03.jpg" alt="">카카오톡 시작하기</a></li>
				</ul>
			</div>
		</div>


<script>

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


			<?php
			//naver
			//$client_id = "LjVMKV6VElblPxYvJoGu";
			//$redirectURI = urlencode("http://".$_SERVER['HTTP_HOST']."/naver/callback.php");
			//$state = md5(rand());
			//$apiURL = "https://nid.naver.com/oauth2.0/authorize?response_type=code&client_id=".$client_id."&redirect_uri=".$redirectURI."&state=".$state;
			?>

			<script type="text/javascript" src="https://static.nid.naver.com/js/naverLogin_implicit-1.0.3.js" charset="utf-8"></script>
			<script type="text/javascript">

				function naver_login(){
					$('#naver_id_login_anchor').click();
				}

				var naver_id_login = new naver_id_login("FDQ_CLgBTbw8tq5iwsbe", "https://<?=$_SERVER['HTTP_HOST']?>/naver/callback.php");
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
								url: "/html/dh_member/kkojoin",
								data:{"userid":res.id},
								dataType:"json",
								cache:false,
								success: function(data){
									console.log(data);
									if(data.is_member == "no"){
										$("#sns_userid").val(data.userid);
										$("#sns_passwd").val(data.passwd);
										$("#sns_info").attr("action","/html/dh_member/join/?agree=1");
										$("#sns_info").submit();
									}else if(data.is_member == "yes"){
										$("#sns_userid").val(data.userid);
										$("#sns_passwd").val(data.passwd);
										$("#sns_info").attr("action","/html/dh_member/login");
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