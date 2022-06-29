<?
	$PageName = "INTE";
	$SubName = "";
	$PageTitle = "회원 아이디 통합";
	include('../include/head.php');
	include('../include/header.php');
?>

<script type="text/javascript">
	function idmerge(){
		frm = document.idmg;
		var idsel = $("input:radio[name='selectid']:checked").val();
		if(!idsel){
			alert("통합하실 아이디를 선택해주세요.");
			return;
		}

		if(confirm('선택하신 아이디를 제외한 나머지 아이디는 사용하실 수 없습니다.\n선택하신 아이디로 통합과정을 진행하시겠습니까?')){
			frm.submit();
		}
	}
</script>


<!--Container-->
<div id="container">
	<?include("../include/my_top.php");?>
	<div class="inner clearfix">
		<?include("../include/mypage_lnb.php");?>

		<div class="inte02 my_cont">
			<p class="inte02__tit">회원님의 휴대폰번호로 검색된 아이디는 아래와 같습니다.</p>

			<form name="idmg" id="idmg" method="post" action="/html/dh/idmerge_proc/?ajax=1">
				<?php
				foreach($_POST as $k=>$v){
					?>
					<input type="hidden" name="<?=$k?>" value="<?=$v?>">
					<?php
				}
				?>


				<table style="width:1200px;margin-top:50px;margin-bottom: 50px; text-align:center">
					<tr>
						<th>선택</th>
						<th>아이디</th>
						<th>성명</th>
						<th>이메일</th>
					</tr>
					<?php
					foreach($list as $lt){
						?>
						<tr>
							<td>
								<input type="radio" name="selectid" value="<?=$lt->userid?>" id="<?=$lt->userid?>">
								<input type="hidden" name="<?=$lt->userid?>_level" value="<?=$lt->level?>">
							</td>
							<td><label for="<?=$lt->userid?>"><?=$lt->userid?></label></td>
							<td><?=$lt->name?></td>
							<td><?=$lt->email?></td>
						</tr>
						<?php
					}
					?>
				</table>
			</form>

			<ul class="inte02__comment">
				<li>* 아이디를 여러개 사용중이신 고객님께서는 아이디를 통합하여 사용해주시길 바랍니다.</li>
				<li>* 아이디가 하나만 검색되는 고객님께서는 해당 아이디에 본인인증 결과를 추가하게됩니다.</li>
				<li>* 아이디 통합 시 다른아이디의 포인트와 주문내역도 같이 통합 조정됩니다.</li>
			</ul>

			<a class="inte__btn" onclick="idmerge()" href="javascript:;">
				선택한 아이디로 통합
			</a>

		</div>
	</div>
</div>
<!--END Container-->

<? include('../include/footer.php') ?>

