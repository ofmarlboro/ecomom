<?php
	$PageName = "K08";
	$SubName = "";
	include("../include/head.php");
	include("../include/header.php");

	//행사 정보 기입 요망
	//행사 시작일자 : start_date
	//행사 종료일자 : end_date

	$start_date = "2022-06-02";
	$end_date = "2022-06-05";

	//행사 정보 기입 요망
?>

<link rel="stylesheet" href="//code.jquery.com/ui/1.12.1/themes/base/jquery-ui.css">
<script src="https://code.jquery.com/jquery-1.12.4.js"></script>
<script src="https://code.jquery.com/ui/1.12.1/jquery-ui.js"></script>
<script type="text/javascript">
	$(function(){
		$(".datepicker").datepicker({
		  dateFormat: "yy-mm-dd",
		  monthNames: ['1월','2월','3월','4월','5월','6월','7월','8월','9월','10월','11월','12월'],
		  dayNamesMin: ['일','월','화','수','목','금','토'],
		  showMonthAfterYear:true,
		  minDate: "<?=$start_date?>",
		  maxDate: "<?=$end_date?>"
		})
	})

	function time_table_check(date){
		$.ajax({
			url:"<?=cdir()?>/dh/time_chk",
			type:"GET",
			cache:false,
			dataType:"json",
			data:{'ajax':1,'date':date},
			error:function(xhr){
				console.log(xhr.responseText);
			},
			success:function(res){
				console.log(res);
				$(".time_table").html(res.html);
			}
		});
	}
</script>

<!--Container-->
<div id="container">
	<div class="sv"></div>


	<div class="inner">
		<div class="counsel__wrap">
			<div class="counsel__logo01" style="width: 120px; margin: auto;">
				<img src="/image/sub/counsel_logo01.png" alt="" class="img--style01">
			</div>
			<div class="counsel__logo02 mt5" style="width: 250px; margin: auto;">
				<img src="/image/sub/cobe20220510.jpg" alt="" class="img--style01">
			</div>
			<div class="counsel__btn mt20" style="width: 140px; margin: auto;">
				<img src="/image/sub/counsel_btn.png" alt="" class="img--style01">
			</div>

			<p class="counsel__param03">
				사람 많은 장소는 조금 꺼려지죠 <br />
				예약시간에 맞춰서 필요한 상담만 받고 <br />
				사회적 거리 지키기 어때요? <br />
				미리 상담 예약 하신 후 상품 구매 시(간식제외)<br>
				산골 간식 추가 5봉을 더 드립니다.
			</p>

			<p class="counsel__param04">상담 사전예약 신청 방법</p>
			<p class="counsel__param05 mt10">
				1. 산골 알림장을 꼼꼼하게 읽어본다. <br />
				2. 하단의 신청하기를 누른다. <br />
				3. 원하는 날짜와 시간을 선택한다. <br />
				4. 개인정보 (이름, 연락처) 입력한다. <br />
				5. 개인정보약관에 동의한다. <br />
				6. 신청하기를 누른다.
			</p>

			<p class="counsel__param01">
				<b>
					2022.06.02(목) ~ 2022.06.05(일)<br>
					서울 코엑스(B Hall)
				</b>
			</p>

			<div class="counsel__msg01">
				실제 상담시간은 약 10분정도 소요되며 예약하신 시간 내에 방문하시면 됩니다.
				예약시간을 넘어 방문하시면 조금 기다리셔야 할 수 도 있는 점 양해 부탁드립니다.
			</div>

			<p class="counsel__param02">시간 예약하기</p>

			<form method="post" name="reser" id="reser">

			<div class="input__wrapper">
				<div class="input__wrap">
					<p class="input__tit">날짜 선택</p>
					<input type="text" class="datepicker" style="background-image: url('/image/sub/counsel_calendar.png')" name="date" msg="날짜를" readonly onchange="time_table_check(this.value)" />
				</div>
				<div class="input__wrap time_table">
					<p class="input__tit">시간 선택</p>
					<select name="time" msg="시간을">
						<option value="">날짜를 선택해주세요.</option>
					</select>
				</div>
			</div>

			<p class="counsel__param02">개인정보입력하기</p>

			<div class="input__wrapper">
				<div class="input__wrap">
					<p class="input__tit">이름</p>
					<input type="text" placeholder="한글만 입력가능합니다." name="name" msg="이름을" />
				</div>
				<div class="input__wrap">
					<p class="input__tit">연락처</p>
					<input type="text" placeholder="숫자만 입력해주세요." name="phone" msg="연락처를" maxlength='13' />
				</div>
			</div>

			<p class="counsel__param02">개인정보처리방침</p>

			<input type="checkbox" class="counsel__agree" id="agree" msg="개인정보 처리방침에 동의해주세요." />
			<label for="agree">동의</label>


			<div class="counsel__terms">
				<?=$agree->content?>
			</div>
			<p class="counsel__msg02">*예약 취소 및 문의사항은 1522-3176 또는 홈페이지 고객게시판에 문의해주세요.</p>

			</form>

			<button class="counsel__submit" type="button" onclick="frmChk('reser')">신청하기</button>
		</div>
	</div>
</div>
<!--END Container-->
<?php include("../include/footer.php");?>