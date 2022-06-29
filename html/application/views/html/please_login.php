<?php
if($go_url == ""){
	$go_url = $_SERVER['REQUEST_URI'];
}
?>
<script type="text/javascript">
<!--
	alert('로그인 후 이용 가능합니다.');
	location.href="/html/dh_member/login/?go_url=<?=$go_url?>";
//-->
</script>