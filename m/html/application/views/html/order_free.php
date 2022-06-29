<? 
	$PageName = "ORDER_FREE";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>

<!--Container-->

<div id="container">
	<?include("../include/top_menu.php");?>
	<?include("../include/mypage_top.php");?>
	<div class="inner mypage">
		<h1>주문배송조회</h1>
		<h2>주문 정보</h2>
		<div class="tblTy02">
			<table>
				<tr>
					<th>주문상품</th>
					<th>주문일자</th>
				</tr>
				<tr>
					<td>골라담기 [완료기] 외 8건</td>
					<td>2018. 01. 01 (월)</td>
				</tr>
				<tr>
					<th>주문코드</th>
					<th>결제방법</th>
				</tr>
				<tr>
					<td>UXURO1517655385</td>
					<td>무통장 입금 / 신용카드 / 카카오페이 등</td>
				</tr>
			</table>
		</div>
		<h2 class="mt30">상품 확인 / 배송 목록</h2>
		<div class="tblTy02">
			<table>
				<colgroup>
					<col width="25%">
					<col width="25%">
					<col width="25%">
					<col width="25%">
				</colgroup>
				<tr>
					<th>배송일정</th>
					<th>주문 상품 정보</th>
					<th>상품금액</th>
					<th>배송비</th>
				</tr>
				<tr>
					<td rowspan="4"><p>2018-01-01 (월)</p>
						<a href="" class="alarm"></a>
					</td>
					<td>[완료기] D06. 한우모듬채소진밥듬채소진밥듬채소진밥</td>
					<td>8,000원</td>
					<td>3,000원</td>	
				</tr>
				<tr>
					<td>[완료기] D06. 한우모듬채소진밥듬채소진밥듬채소진밥</td>
					<td>8,000원</td>
					<td></td>
				</tr>
				<tr>
					<td>[완료기] D06. 한우모듬채소진밥듬채소진밥듬채소진밥</td>
					<td>8,000원</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="3">배송중
						<span class="blue mb10">
							우체국: 123456-7890
						</span>
						<a href="" class="btn_y ml10">배송조회</a>		
								<!--버튼들
								<a href="" class="btn_g">배송완료</a>
								<a href="" class="btn_g">교환완료</a>
								<a href="" class="btn_g">반품완료</a>
								<a href="" class="btn_r">교환/반품요청</a> 
								-->
					</td>					
				</tr>

								<tr>
					<td rowspan="4"><p>2018-01-01 (월)</p>
						<a href="" class="a_noti"></a>
					</td>
					<td>[완료기] D06. 한우모듬채소진밥듬채소진밥듬채소진밥</td>
					<td>8,000원</td>
					<td>3,000원</td>	
				</tr>
				<tr>
					<td>[완료기] D06. 한우모듬채소진밥듬채소진밥듬채소진밥</td>
					<td>8,000원</td>
					<td></td>
				</tr>
				<tr>
					<td>[완료기] D06. 한우모듬채소진밥듬채소진밥듬채소진밥</td>
					<td>8,000원</td>
					<td></td>
				</tr>
				<tr>
					<td colspan="3">대기(입금대기)<a href="" class="btn_r ml10">교환/반품요청</a> 
					</td>					
				</tr>

			
						

			</table>
		</div>
	</div>
	<!-- inner -->
</div>
<!--END Container-->
<div class="mg95">
</div>
<? include('../include/footer.php') ?>
