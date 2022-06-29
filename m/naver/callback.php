<!doctype html>
<html lang="ko">
<head>
<script type="text/javascript" src="//static.nid.naver.com/js/naverLogin_implicit-1.0.2.js" charset="utf-8"></script>
<script type="text/javascript" src="//code.jquery.com/jquery-1.11.3.min.js"></script>
</head>
<body>
<script type="text/javascript">
var naver_id_login = new naver_id_login("FDQ_CLgBTbw8tq5iwsbe", "https://<?=$_SERVER['HTTP_HOST']?>");
naver_id_login.get_naver_userprofile("naverSignInCallback()");

function naverSignInCallback(){
	$.ajax({
		type:"POST"
		,url:"/m/naver/naverprofile.php"
		,data:{'token':naver_id_login.oauthParams.access_token}
		,dataType:"json"
		,success:function(data){
			console.log(data);
			console.log(data.response);
			$.ajax({
				method: "POST",
				url: "/m/html/dh_member/nvjoin",
				data:{"userid": data.response.id, "name": data.response.name},
				dataType:"json",
				success:function(data){
					console.log(data);
					if(data.is_member == "no"){
						$("#sns_userid",opener.document).val(data.userid);
						$("#sns_passwd",opener.document).val(data.passwd);
						$("#sns_name",opener.document).val(data.name);
						$("#sns_info",opener.document).attr("action","/m/html/dh_member/join/?agree=1");
						$("#sns_info",opener.document).submit();
						self.close();
					}else if(data.is_member == "yes"){
						$("#sns_userid",opener.document).val(data.userid);
						$("#sns_passwd",opener.document).val(data.passwd);
						$("#sns_name",opener.document).val(data.name);
						$("#sns_info",opener.document).attr("action","/m/html/dh_member/login");
						$("#sns_info",opener.document).submit();
						self.close();
					}
				},
				error:function(xhr){xhr.responseText}
			});
		}
		,error:function(xhr){xhr.responseText}
	});
}
</script>
</body>
</html>
