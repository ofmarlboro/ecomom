<!doctype html>
<html lang="ko">
 <head>
	<title>나의 배송지 관리</title>
	<meta charset="UTF-8">
	<meta name="viewport" content="width=device-width, initial-scale=1, user-scalable=no">
	<meta name="Author" content="Designhub">
	<meta name="Author" content="Wookju Choi">
	<meta name="Author" content="Minee Choi">
	<meta name="robots" content="noindex">

	<link type="text/css" rel="stylesheet" href="//cdn.rawgit.com/hiun/NanumSquare/master/nanumsquare.css" />
	<link type="text/css" rel="stylesheet" href="/css/@default.css?t=<?=time()?>" />
	<script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="/js/jquery.easing.min.js"></script>
	<script type="text/javascript" src="/js/placeholders.min.js"></script>
	<script type="text/javascript" src="/js/imagesloaded.pkgd.min.js"></script>
	<script type="text/javascript" src="/js/slick.min.js"></script>
	<script type="text/javascript" src="/js/setting.js?t=<?=time()?>"></script>
	<script type="text/javascript" src="/js/common.js?t=<?=time()?>"></script>

	<script src="https://t1.daumcdn.net/mapjsapi/bundle/postcode/prod/postcode.v2.js"></script>
	<script>
    function closeDaumPostcode() {
			var element_layer = document.getElementById('layer_post');
        // iframe을 넣은 element를 안보이게 한다.
        element_layer.style.display = 'none';
    }

    function sample2_execDaumPostcode() {
			var element_layer = document.getElementById('layer_post');
        new daum.Postcode({
            oncomplete: function(data) {
                // 검색결과 항목을 클릭했을때 실행할 코드를 작성하는 부분.

                // 각 주소의 노출 규칙에 따라 주소를 조합한다.
                // 내려오는 변수가 값이 없는 경우엔 공백('')값을 가지므로, 이를 참고하여 분기 한다.
                var fullAddr = data.address; // 최종 주소 변수
                var extraAddr = ''; // 조합형 주소 변수

                // 기본 주소가 도로명 타입일때 조합한다.
                if(data.addressType === 'R'){
                    //법정동명이 있을 경우 추가한다.
                    if(data.bname !== ''){
                        extraAddr += data.bname;
                    }
                    // 건물명이 있을 경우 추가한다.
                    if(data.buildingName !== ''){
                        extraAddr += (extraAddr !== '' ? ', ' + data.buildingName : data.buildingName);
                    }
                    // 조합형주소의 유무에 따라 양쪽에 괄호를 추가하여 최종 주소를 만든다.
                    fullAddr += (extraAddr !== '' ? ' ('+ extraAddr +')' : '');
                }

                // 우편번호와 주소 정보를 해당 필드에 넣는다.
                document.getElementById('receiv-post').value = data.zonecode; //5자리 새우편번호 사용
                document.getElementById('addr1').value = fullAddr;
                //document.getElementById('sample2_addressEnglish').value = data.addressEnglish;

                // iframe을 넣은 element를 안보이게 한다.
                // (autoClose:false 기능을 이용한다면, 아래 코드를 제거해야 화면에서 사라지지 않는다.)
                element_layer.style.display = 'none';

								document.getElementById('receiv-addr-dt').value="";
								document.getElementById('receiv-addr-dt').focus();
            },
            width : '100%',
            height : '100%',
            maxSuggestItems : 5
        }).embed(element_layer);

        // iframe을 넣은 element를 보이게 한다.
        element_layer.style.display = '';

        // iframe을 넣은 element의 위치를 화면의 가운데로 이동시킨다.
        initLayerPosition();
    }

    // 브라우저의 크기 변경에 따라 레이어를 가운데로 이동시키고자 하실때에는
    // resize이벤트나, orientationchange이벤트를 이용하여 값이 변경될때마다 아래 함수를 실행 시켜 주시거나,
    // 직접 element_layer의 top,left값을 수정해 주시면 됩니다.
    function initLayerPosition(){
			var element_layer = document.getElementById('layer_post');
        var width = 300; //우편번호서비스가 들어갈 element의 width
        var height = 300; //우편번호서비스가 들어갈 element의 height
        var borderWidth = 1; //샘플에서 사용하는 border의 두께

        // 위에서 선언한 값들을 실제 element에 넣는다.
        element_layer.style.width = width + 'px';
        element_layer.style.height = height + 'px';
        element_layer.style.border = borderWidth + 'px solid';
        // 실행되는 순간의 화면 너비와 높이 값을 가져와서 중앙에 뜰 수 있도록 위치를 계산한다.
        element_layer.style.left = (((window.innerWidth || document.documentElement.clientWidth) - width)/2 - borderWidth) + 'px';
        element_layer.style.top = (((window.innerHeight || document.documentElement.clientHeight) - height)/2 - borderWidth) + 'px';
    }

		function maxLengthCheck(object){
			if (object.value.length > object.maxLength){
				object.value = object.value.slice(0, object.maxLength);
			}
		}
	</script>

	<script type="text/javascript" src="/_data/js/form.js?t=<?=time()?>"></script>

 </head>
 <body>
 <div id="address-wrap">
	<h1>나의 배송지 관리</h1>
	<div class="pd15">
		<h2>배송지 추가/수정</h2>

		<form id="addrfrm" method="post">
		<table class="address-list write-mode">
			<caption>나의 배송지 목록 추가 - 이름, 주소, 받는사람, 연락처</caption>
			<colgroup>
				<col style="width:120px;">
			</colgroup>
			<tbody>
				<tr>
					<th>배송지이름</th>
					<td>
						#<?=$type_to_name[$type]?>
						<input type="hidden" name="type" value="<?=$type?>">
					</td>
				</tr>
				<tr>
					<th>받으시는분</th>
					<td><input type="text" id="receiv-name" name="name" value="<?=($type=="home")?$member->name:$member->{$type._name};?>" msg="받으시는분을"></td>
				</tr>
				<tr>
					<th>연락처</th>
					<td>
						<input type="number" pattern="\d*" id="receiv-call1" style="width:60px" name="phone1" value="<?=($type=="home")?$member->phone1:$member->{$type._phone1};?>" msg="연락처를" maxlength="3" oninput="maxLengthCheck(this)"> -
						<input type="number" pattern="\d*" id="receiv-call2" style="width:60px" name="phone2" value="<?=($type=="home")?$member->phone2:$member->{$type._phone2};?>" msg="연락처를" maxlength="4" oninput="maxLengthCheck(this)"> -
						<input type="number" pattern="\d*" id="receiv-call3" style="width:60px" name="phone3" value="<?=($type=="home")?$member->phone3:$member->{$type._phone3};?>" msg="연락처를" maxlength="4" oninput="maxLengthCheck(this)">
					</td>
				</tr>
				<tr>
					<th>배송지주소</th>
					<td>
						<div id="layer_post" style="display:none;position:fixed;overflow:hidden;z-index:1;-webkit-overflow-scrolling:touch;">
							<img src="//t1.daumcdn.net/localimg/localimages/07/postcode/320/close.png" id="btnCloseLayer" style="cursor:pointer;position:absolute;right:-3px;top:-3px;z-index:1" onclick="closeDaumPostcode()" alt="닫기 버튼">
						</div>
						<p><label for="receiv-post" class="label-out">우편번호</label><input type="text" class="field-s mr5" id="receiv-post" name="zipcode" value="<?=($type=="home")?$member->zip1:$member->{$type._zip};?>" readonly msg="우편번호를"><button type="button" class="plain btn" onclick="sample2_execDaumPostcode()">우편번호찾기</button></p>
						<p class="mt5"><input type="text" style="width:95%;" id="addr1" name="address1" value="<?=($type=="home")?$member->add1:$member->{$type._addr1};?>" readonly msg="주소를"></p>
						<p class="mt5">
							<label for="receiv-addr-dt" class="label-out">상세주소</label>
							<input type="text"  style="width:200px;"id="receiv-addr-dt" name="address2" value="<?=($type=="home")?$member->add2:$member->{$type._addr2};?>" msg="상세주소를">
						</p>
					</td>
				</tr>
			</tbody>
		</table>
		</form>

		<div class="align-c">
			<button type="button" class="btn-emp-s" onclick="frmChk('addrfrm')">확인</button>
			<button type="button" class="btn-normal-s" onclick="self.close()">취소</button>
		</div>
	</div>

 </div>
 </body>
</html>
