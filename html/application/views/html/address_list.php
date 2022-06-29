
<!doctype html>
<html lang="ko">
 <head>
	<title>나의 배송지 관리</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=780">
	<meta name="Author" content="Designhub">
	<meta name="Author" content="Wookju Choi">
	<meta name="Author" content="Minee Choi">
	<meta name="robots" content="noindex">

	<link type="text/css" rel="stylesheet" href="//cdn.rawgit.com/hiun/NanumSquare/master/nanumsquare.css" />
	<link type="text/css" rel="stylesheet" href="/css/@default.css?t=1522397623" />
	<script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="/js/jquery.easing.min.js"></script>
	<script type="text/javascript" src="/js/placeholders.min.js"></script>
	<script type="text/javascript" src="/js/imagesloaded.pkgd.min.js"></script>
	<script type="text/javascript" src="/js/slick.min.js"></script>
	<script type="text/javascript" src="/js/setting.js?t=1522397623"></script>
	<script type="text/javascript" src="/js/common.js?t=1522397623"></script>
 </head>
 <body>
 <div id="address-wrap">
	<h1>나의 배송지 관리</h1>
	<div class="pd15">
		<h2>배송지 목록</h2>
		
		<table class="address-list">
			<caption>나의 배송지 목록 - 이름, 주소, 받는사람, 연락처</caption>
			<colgroup>
				<col style="width:40px;">
				<col>
				<col>
				<col>
				<col style="width:120px;">
			</colgroup>
			<thead>
				<tr>
					<th>선택</th>
					<th>배송지이름</th>
					<th>주소</th>
					<th>받는사람</th>
					<th>연락처</th>
				</tr>
			</thead>
			<tbody>
				<!-- <tr>
					<td colspan="5"><p class="pt30 pb30">등록된 배송지가 없습니다.</p></td>
				</tr> -->
				<tr>
					<td><input type="radio" name="chk-deliv" id="chk-deliv1"></td>
					<td><label for="chk-deliv1">기본주소(기본)</label></td>
					<td>서울특별시 강서구 화곡동 1068-23 동인빌딩 302호</td>
					<td>최욱주</td>
					<td>02-6925-2509</td>
				</tr>
			</tbody>
		</table>
		<div class="float-wrap">
			<div class="float-l">
				<button type="button" class="btn-normal-s" onclick="location.href='address_add.php';">배송지 추가</button>
				<button type="button" class="btn-border-s">수정</button>
				<button type="button" class="btn-border-s" onclick="confirm('정말 삭제하시겠습니까?');">삭제</button>
			</div>
			<div class="float-r">
				<button type="button" class="btn-emp-s">배송지로 선택</button>
			</div>
		</div>
	</div>

 </div>
 </body>
</html>
