<?
	$PageName = "LEAVE";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

<!--Container-->
<div id="container">
	<?include("../include/top_menu.php");?>
	<?include("../include/mypage_top02.php");?>

	<?php
	include "{$view}.php";
	?>

	<?php
	/*
		<div class="inner mypage">

			<script type="text/javascript">
			<!--
				function leave(){
					if(checkForm('leave_form')){
						if(confirm('탈퇴 하시겠습니까?')){
							$("#leave_form").submit();
						}
					}
				}
			//-->
			</script>

			<h2 class="mt10">
				회원 탈퇴 안내
			</h2>
			<div class="tblTy05">
				<table>
					<tr>
						<td>
							<ul class="bu_list">
								<li>
									저희 사이트의 부족했던 점과 아쉬웠던 점을<br>
									사유에 기재하여 주시면더 좋은 모습으로 발전하도록<br>
									최선을 다하겠습니다.
								</li>
								<li>
									앞으로 더 나은 모습으로 고객님을<br>
									다시 만날 수 있도록 노력하겠습니다.
								</li>
								<li>
									그동안 이용해주신 것을 진심으로 감사드립니다.
								</li>
							</ul>
						</td>
					</tr>
				</table>
			</div>
			<h2 class="mt30">
				회원탈퇴 주의사항
			</h2>
			<div class="tblTy05">
				<table>
					<tr>
						<td>
							<ul class="bu_list03">
								<li>
									회원탈퇴를 하시면 주문내역 정보를<br>
									홈페이지에서 조회하실 수 없습니다.
								</li>
								<li>
									회원탈퇴를 하시면 해당 아이디는<br>
									즉시 탈퇴 처리가 되며<br>
									이후 영구적으로 사용이 중지됩니다.
								</li>
								<li>
									또한, 포인트(적립금) 및 쿠폰 등은 자동 소멸되어<br>
									재가입하더라도 복구되지 않습니다.
								</li>
							</ul>
						</td>
					</tr>
				</table>
			</div>
			<h2 class="mt30">
				탈퇴 신청
			</h2>
			<div class="tblTy03 join">
				<form name="leave_form" id="leave_form" method="post">
				<input type="hidden" name="del_idx" value="<?=$row->idx?>">
					<table>
						<tr>
							<th>아이디</th>
							<td><input type="test" value="<?=$row->userid?>" disabled></td>
						</tr>
						<tr>
							<th>비밀번호</th>
							<td><input type="password" name="passwd" msg="비밀번호를"></td>
						</tr>
						<tr>
							<th>탈퇴 사유</th>
							<td><textarea name="outmsg" cols="10" rows="10"></textarea></td>
						</tr>
					</table>
				</form>
			</div>
			<div class="ac mt20">
				<a href="javascript: leave();" class="btn_g fz16">회원탈퇴</a>
				<a href="/m" class="btn_g fz16">취소</a>
			</div>
		</div>
	*/
	?>
	<!-- inner -->
</div>
<!--END Container-->
<div class="mg95">
</div>




<? include('../include/footer.php') ?>
