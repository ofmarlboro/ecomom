
	<?
		$send= "";
		if(isset($query_string) && isset($param)){
			$send.=$query_string.$param;
		}
	?>

	<style>
	.spam_div { border:0px solid #ddd; padding:0px 5px; float:left; margin-right:15px; }
	.spam_div > img { margin-top:2px; margin-bottom:-7px; }
	</style>

		<form name="tx_editor_form" id="tx_editor_form" method="post" enctype="multipart/form-data" action="<?=$send?>">
			<input type="hidden" name="userid" value="<? echo (@$this->session->userdata('USERID')) ? @$this->session->userdata('USERID') : "";?>" />
			<input type="hidden" name="ref" value="<? echo isset($row->ref) ? $row->ref : "0";?>">
			<input type="hidden" name="re_step" value="<? echo isset($row->re_step) ? $row->re_step : "0";?>">
			<input type="hidden" name="re_level" value="<? echo isset($row->re_level) ? $row->re_level : "0";?>">
			<!-- <input type="hidden" name="cate_idx" value="<? echo isset($row->cate_idx) ? $row->cate_idx : $this->input->get("cate_idx");?>"> -->
			<input type="hidden" name="goods_idx" value="<? echo isset($goods_row->idx) ? $goods_row->idx : "0";?>">
			<input type="hidden" name="cate_no" value="<? echo isset($goods_row->cate_no) ? $goods_row->cate_no : "0";?>">

			<!-- Board wrap -->
			<div class="board-wrap">
				<!-- board write -->
				<div class="board-write">
					<ul class="board-write-form">
						<? if($bbs->bbs_cate=="Y"){?>
						<li><div class="field-label"><label for="qna-type"><?if($bbs->bbs_type==2){?>문의유형<?}else{?>카테고리<?}?></label></div>
							<div class="field-form">
								<select id="qna-type" name="cate_idx" onchange="parseHTML(this.value)">
									<option value=""><?if($bbs->bbs_type==2){?>문의유형을<?}else{?>카테고리를<?}?> 선택하세요.</option>
									<? foreach($cate_list as $c_list){ ?>
									<option value="<?=$c_list->idx?>" <? if(isset($row->cate_idx) && $row->cate_idx == $c_list->idx){?>selected<?}?>><?=$c_list->name?></option>
									<?}?>
								</select>
							</div>
						</li>
						<?}?>
						<li><div class="field-label"><label for="write-name">작성자</label></div>
							<div class="field-form">
								<input type="text" id="write-name" value="<? echo isset($row->name) ? $row->name : $this->session->userdata('NAME');?>" name="name" readonly>
							</div>
						</li>
						<? if($bbs->bbs_secret=="1"){ ?>
						<input type="hidden" name="secret" value="y">
						<?}?>
						<li <? if(@$this->session->userdata('USERID')){ ?>style="display:none;"<?}?>><div class="field-label"><label for="write-pw">비밀번호</label></div>
							<div class="field-form">
								<input type="password" id="write-pw" value="<? echo (@$this->session->userdata('PASSWD')) ? @$this->session->userdata('PASSWD') : "";?>" name="pwd">
							</div>
						</li>
						<li><div class="field-label"><label for="write-title">제목</label></div>
							<div class="field-form">
								<input type="text" id="write-title" class="field-full" name="subject" value="<? echo isset($row->subject) ? $row->subject : "";?>">
							</div>
						</li>
						<li>
							<div class="write-editor">
								<? if($bbs->editor!=1){ //네이버 에디터 미사용?>
								<label for="write-content1" class="label-out">내용</label>
								<textarea name="tx_content" id="write-content1" cols="30" rows="15"><? echo isset($row->content) ? $row->content : "";?></textarea>

								<? }else{ //네이버 에디터 사용??>
								<textarea name="tx_content" id="tx_content" rows="10" cols="100" style="-webkit-overflow-scrolling:touch; height: auto; -webkit-box-sizing: content-box; position: static; width:100%"><? echo isset($row->content) ? $row->content : "";?></textarea>
								<?	 }	?>
							</div>
						</li>
						<li class="pb5" style="display:<? if( $bbs->bbs_pds ) { //자료실 사용 ?><?}else{?>none<?}?>;"><div class="field-label">파일첨부</div>
							<div class="field-form">
								<ul class="write-files">
									<li>
										<div class="file-attach-box "><!-- 파일선택후 : off 클래스 추가 -->
											<div class="file-attach">
												<span class="file-name"><? echo (@$row->real_file) ? $row->real_file : "파일을 선택해주세요.";?></span>
												<input type="file" id="w-file1" name="bbs_file">
												<label for="w-file1">파일찾기</label>
											</div>
											<? if(isset($row->bbs_file) && $row->bbs_file){?>
											<button type="button" class="plain btn-file-del"><img src="/image/board_img/btn_del.gif" alt="삭제"></button>
											<?}?>
										</div>
									</li>
								</ul>
							</div>
						</li>
						<? if($bbs->nospam==1){?>
						<li><div class="field-label"><label for="write-title">보안문자</label></div>
							<div class="field-form">
								<div class="spam_div">
									<?=$imgData?>
								</div>
								<input type="text" id="write-name" value="" name="spam_code" maxlength="5" style="width:70px;">
								<small class="ml5">왼쪽의 보안문자를 입력해주세요.</small>
							</div>
						</li>
						<?}?>
					</ul>
					<!-- Buttons -->
					<div class="board-view-btns align-c">
						<input type="button" class="btn-normal w100" name="writeBtn" value="<? if($this->uri->segment(2)=="write"){?>등록<?}else{?>수정<?}?>하기" onclick="javascript:validForm();">
					</div><!-- END Buttons -->


				</div><!-- END board write -->
			</div><!-- END Board wrap -->

</form>




<script type="text/javascript">

	$(function(){
		$("#w-file1").change(function(){
			var file_txt = $(this).val().split("\\");
			$(".file-name").html(file_txt[2]);
			$(".file-attach-box").addClass("off");

		});

	});


		function validForm() {

			<? if($bbs->editor==1){ ?>
				oEditors.getById["tx_content"].exec("UPDATE_CONTENTS_FIELD", []);
			<?}?>

			<? if($bbs->bbs_cate=="Y"){ ?>

			if (document.tx_editor_form.cate_idx.value == '') {
				alert("<?if($bbs->bbs_type==2){?>문의유형<?}else{?>카테고리<?}?>을 선택해 주십시오.");
				document.tx_editor_form.cate_idx.focus();
				return;
			}

			<?}?>

			if (document.tx_editor_form.name.value == '') {
				alert("이름을 입력해 주십시오.");
				document.tx_editor_form.name.focus();
				return;
			}
			if (document.tx_editor_form.pwd.value == '') {
				alert("비밀번호를 입력해 주세요.");
				document.tx_editor_form.pwd.focus();
				return;
			}
			if (document.tx_editor_form.subject.value == '') {
				alert("제목을 입력해 주십시오.");
				document.tx_editor_form.subject.focus();
				return;
			}


			<? if($bbs->nospam==1){ ?>
			if (document.tx_editor_form.spam_code.value == '') {
				alert("스팸방지 숫자를 입력해 주세요.");
				document.tx_editor_form.spam_code.focus();
				return;
			}
			if (document.tx_editor_form.spam_code.value != "<?=$cnum?>") {
				alert("스팸방지 숫자가 일치하지 않습니다.");
				document.tx_editor_form.spam_code.focus();
				return;
			}

			<?	 }	?>

			document.tx_editor_form.submit();
			document.tx_editor_form.writeBtn.disabled = true;
			return;
		}


</script>





<? if($bbs->editor == "1"){ ?>

<script type="text/javascript" src="/_data/smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript">

var oEditors = [];

nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "tx_content",
	sSkinURI: "/_data/smarteditor/SmartEditor2Skin2.html",
	htParams : {
		bUseToolbar : true,				// 툴바 사용 여부 (true:사용/ false:사용하지 않음)
		bUseVerticalResizer : true,		// 입력창 크기 조절바 사용 여부 (true:사용/ false:사용하지 않음)
		bUseModeChanger : true,			// 모드 탭(Editor | HTML | TEXT) 사용 여부 (true:사용/ false:사용하지 않음)
		//aAdditionalFontList : aAdditionalFontSet,		// 추가 글꼴 목록
		fOnBeforeUnload : function(){
			//alert("완료!");
		}
	}, //boolean
	fOnAppLoad : function(){
		//예제 코드
		//oEditors.getById["tx_content"].exec("PASTE_HTML", ["로딩이 완료된 후에 본문에 삽입되는 text입니다."]);
	},
	fCreator: "createSEditor2"
});


	//에디터에 양식 추가
	function parseHTML(val){

		var title = "";
		var html = "";

		if(val == "20"){
			title = "연휴 몰아받기 요청합니다";
			html = '<p style="font-size:15px;margin:5px 0"><b>&lt;하기 양식에 맞춰 기입을 부탁드립니다 &gt;</b></p><p style="font-size:15px;margin:5px 0">&nbsp;</p><p style="font-size:15px;margin:5px 0"><b>※ 배송일 변경 주의사항※ </b>  </p><p style="font-size:15px;margin:5px 0"> <b>* 기존배송일 :</b></p><p style="font-size:15px;margin:5px 0"> <b>* 변경배송일 :</b></p><p style="font-size:15px;margin:5px 0"><b>* 기타요청사항 :</b>  </p><p style="font-size:15px;margin:5px 0">&nbsp;</p><p style="font-size:12px;margin:5px 0">연휴 배송이 밀려, 이유식 도착시간이 많이 늦을 수 있습니다(__) </p><p style="font-size:12px;margin:5px 0">우체국이 아닌 CJ택배로 받을 수 있습니다 </p><p style="font-size:12px;margin:5px 0">연휴기간동안 오배송의 경우 당일 재배송이 불가한 상황으로 혹여나 우리아기가 굶지않도록, 간단한 이유식재료(쌀+녹황색채소)를 일부 </p><p style="font-size:12px;margin:5px 0">준비해두셔도 도움이 될 듯하여 당부드립니다(__) </p>';
		}
		else if(val == "21"){
			title = "배송일변경 요청합니다";
			html = '<p style="font-size:15px;margin:5px 0"><b>&lt;하기 양식에 맞춰 기입을 부탁드립니다 &gt;</b></p><p style="font-size:15px;margin:5px 0">&nbsp;</p><p style="font-size:15px;margin:5px 0"><b>* 기존배송일 :</b></p><p style="font-size:15px;margin:5px 0"><b>* 변경배송일 :</b></p><p style="font-size:15px;margin:5px 0"><b>* 기타요청사항 :</b></p><p style="padding-top:50px;"></p><div><p><strong>- 주말에 변경문의 주신 건은 배송일 [수요일]부터 적용가능합니다.</strong><br>&nbsp <span style="font-size:12px;">( 월요일 – 주말휴무로 새벽부터 조리/ 화요일 – 재료준비 마감예정)</span></p><table style="border-collapse: collapse;border-spacing: 0;vertical-align: top;width: 400px;margin-top: 10px;"><tr><th style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;background: #ddd;width: 100px;">배송일</th><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">화</td><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">수</td><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">목</td><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">금</td><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">토</td></tr><tr><th style="border: 1px solid #666;text-align: centebr;font-size: 12px;padding: 5px 0;background: #ddd;width: 100px;">변경가능일</th><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">금</td><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">월</td><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">화</td><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">수</td><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">목</td></tr></table></div>';
		}
		else if(val == "22"){
			title = "배송지변경 요청합니다";
			html = '<p style="font-size:15px;margin:5px 0"><b>&lt;하기 양식에 맞춰 기입을 부탁드립니다 &gt;</b></p><p style="font-size:15px;margin:5px 0">&nbsp;</p><p style="font-size:15px;margin:5px 0"><b>* 배송을 바꾸고 싶은 날짜 :</b></p><p style="font-size:15px;margin:5px 0"><b>* 변경하고 싶은 주소지 :</b></p><p style="font-size:15px;margin:5px 0"><b>* 기타요청사항 :</b></p><p style="padding-top:50px;"></p><div><p><strong>- 주말에 변경문의 주신 건은 배송일 [수요일]부터 적용가능합니다.</strong><br>&nbsp <span style="font-size:12px;">( 월요일 – 주말휴무로 새벽부터 조리/ 화요일 – 재료준비 마감예정)</span></p><table style="border-collapse: collapse;border-spacing: 0;vertical-align: top;width: 400px;margin-top: 10px;"><tr><th style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;background: #ddd;width: 100px;">배송일</th><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">화</td><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">수</td><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">목</td><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">금</td><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">토</td></tr><tr><th style="border: 1px solid #666;text-align: centebr;font-size: 12px;padding: 5px 0;background: #ddd;width: 100px;">변경가능일</th><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">금</td><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">월</td><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">화</td><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">수</td><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">목</td></tr></table></div>';
		}
		else if(val == "23"){
			title = "메뉴변경 요청합니다";
			html = '<p style="font-size:15px;margin:5px 0"><b>&lt;하기 양식에 맞춰 기입을 부탁드립니다 &gt;</b></p><p style="font-size:15px;margin:5px 0">&nbsp;</p><p style="font-size:15px;margin:5px 0"><span style="color:#FF0000">*정기배송 중 알레르기 메뉴가 있을 경우, 대체메뉴로 변경을 도와드립니다</span></p><p style="font-size:15px;margin:5px 0">&nbsp;</p><p style="font-size:15px;margin:5px 0"><b>* 배송 예정일 :</b></p><p style="font-size:15px;margin:5px 0"><b>* 변경 전 알레르기 메뉴 :</b></p><p style="font-size:15px;margin:5px 0"><b>* 변경 후 원하는 대체 메뉴:  </b></p><p style="font-size:15px;margin:5px 0"><b>* 기타요청사항 :  </b></p><p style="font-size:15px;margin:5px 0">· 산골이유식 메뉴는 이유식 주문하기에서 [월별식단표]를 참고하여 기입 부탁드립니다</p><p style="font-size:15px;margin:5px 0">· 다음 회차배송 1회에 한해 변경메뉴로 가며, 마지막배송까지 알레르기메뉴를 제외하고 싶은 경우 기타요청사항에 꼭 기입해주세요</p><p style="font-size:15px;margin:5px 0">· 마이페이지에서 특정 알레르기제품에 한에 대체메뉴 선택/변경가능합니다</p><p style="font-size:15px;margin:5px 0">· 낱개배송 이용고객은 메뉴변경이 불가하며, 취소 후 재주문을 부탁드립니다</p><p style="padding-top:50px;"></p><div><p><strong>- 주말에 변경문의 주신 건은 배송일 [수요일]부터 적용가능합니다.</strong><br>&nbsp <span style="font-size:12px;">( 월요일 – 주말휴무로 새벽부터 조리/ 화요일 – 재료준비 마감예정)</span></p><table style="border-collapse: collapse;border-spacing: 0;vertical-align: top;width: 400px;margin-top: 10px;"><tr><th style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;background: #ddd;width: 100px;">배송일</th><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">화</td><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">수</td><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">목</td><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">금</td><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">토</td></tr><tr><th style="border: 1px solid #666;text-align: centebr;font-size: 12px;padding: 5px 0;background: #ddd;width: 100px;">변경가능일</th><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">금</td><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">월</td><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">화</td><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">수</td><td style="border: 1px solid #666;text-align: center;font-size: 12px;padding: 5px 0;">목</td></tr></table></div>';
		}
		else if(val == "5"){
			title = "취소환불 요청합니다";
			html = '<p style="font-size:15px;margin:5px 0"><b>&lt;하기 양식에 맞춰 기입을 부탁드립니다 &gt;</b></p><p style="font-size:15px;margin:5px 0">&nbsp;</p><p style="font-size:15px;margin:5px 0"><b>* 취소 원하는 배송일 : </b></p><p style="font-size:15px;margin:5px 0"><b>* 취소/환불 요청 사유 : </b></p><p style="font-size:15px;margin:5px 0">* 취소/환불 진행 후, 카드사 최종반영은 1주일 이내 소요될 수 있습니다</p><p style="font-size:15px;margin:5px 0"><span style="color:#ff0000">* 가상계좌,휴대폰,계좌이체 결제 하신 경우 하기 양식에 맞춰 추가 기입을 부탁드립니다.</span></p><p style="font-size:15px;margin:5px 0"><span style="color:#ff0000">* 계좌번호 : </span></p><p style="font-size:15px;margin:5px 0"><span style="color:#ff0000">* 예금주 : </span></p><p style="font-size:15px;margin:5px 0"><span style="color:#ff0000">* 은행명 : </span></p><p style="padding-top:50px;"></p><div><p><strong>- 주말에 변경문의 주신 건은 배송일 [수요일]부터 적용가능합니다.</strong><br>&nbsp <span style="font-size:12px;">( 월요일 – 주말휴무로 새벽부터 조리/ 화요일 – 재료준비 마감예정)</span></p><table style="border-collapse: collapse;border-spacing: 0;vertical-align: top;width: 400px;margin-top: 10px;"><tr><th style="border: 1px solid #666;text-align: center;font-size: 14px;padding: 5px 0;background: #ddd;width: 100px;">배송일</th><td style="border: 1px solid #666;text-align: center;font-size: 14px;padding: 5px 0;">화</td><td style="border: 1px solid #666;text-align: center;font-size: 14px;padding: 5px 0;">수</td><td style="border: 1px solid #666;text-align: center;font-size: 14px;padding: 5px 0;">목</td><td style="border: 1px solid #666;text-align: center;font-size: 14px;padding: 5px 0;">금</td><td style="border: 1px solid #666;text-align: center;font-size: 14px;padding: 5px 0;">토</td></tr><tr><th style="border: 1px solid #666;text-align: centebr;font-size: 14px;padding: 5px 0;background: #ddd;width: 100px;">변경가능일</th><td style="border: 1px solid #666;text-align: center;font-size: 14px;padding: 5px 0;">금</td><td style="border: 1px solid #666;text-align: center;font-size: 14px;padding: 5px 0;">월</td><td style="border: 1px solid #666;text-align: center;font-size: 14px;padding: 5px 0;">화</td><td style="border: 1px solid #666;text-align: center;font-size: 14px;padding: 5px 0;">수</td><td style="border: 1px solid #666;text-align: center;font-size: 14px;padding: 5px 0;">목</td></tr></table></div>';
		}
		else if(val == "4"){
			title = "포인트 적립 요청합니다";
			html = '<p style="font-size:15px;margin:5px 0"> * 포인트 적립은 <b style="text-decoration:underline;">배송완료 후 7일 ~ 최대10일 이내</b> 적립됩니다</p><p style="font-size:15px;margin:5px 0"> * 빠른 적립을 원하시면 1:1 문의게시판에 남겨주시면   </p><p style="font-size:15px;margin:5px 0">최대한 빠르게 도와드리고 회신드리겠습니다 </p>';
		}
		else if(val == "3"){
			title = "";
			html = '';
		}
		else if(val == "2"){
			title = "";
			html = '';
		}
		else if(val == "24"){
			title = "네이버 회원 이전요청 드립니다.";
			html = '<p style="font-size:15px;margin:5px 0"> ※ [네이버회원 카테고리]는 홈페이지 <b style="color:#d30000;">리뉴얼 이전</b>, [기존 네이버회원고객님]의<br>주문내역/포인트를 최대한 수기로 도와드리고자 개설된 카테고리입니다.<br>회원 관련 다른 문의는 [회원]폴더를 이용해주세요. </p><p style="font-size:15px;margin:5px 0">&nbsp;</p><p style="font-size:15px;margin:5px 0"> 새로운 아이디로 가입 (네이버 or 에코맘홈페이지 신규가입) 하신 후<br>하기와 같이 내용을 남겨주시면 정보를 매칭하여 주문내역이전을 최대한 도와드리겠습니다. </p><p style="font-size:15px;margin:5px 0">&nbsp;</p><p style="font-size:15px;margin:5px 0"> <b>* 이름 :</b> </p><p style="font-size:15px;margin:5px 0"> <b>* 휴대폰번호 :</b> </p><p style="font-size:15px;margin:5px 0"> <b>* 홈페이지 신규아이디 : (신규가입고객의 경우만 입력해 주세요.)</b> </p><p style="font-size:15px;margin:5px 0"> 이메일 주소도 남겨주시면 도움이 됩니다. </p><p style="font-size:15px;margin:5px 0">&nbsp;</p><p style="font-size:12px;margin:5px 0">1:1 문의게시판 신청일로 부터 최소 1주 – 최대 2주 소요될 수 있는점 미리 양해말씀드립니다.</p><p style="font-size:12px;margin:5px 0;display:@none;">1000포인트 지급시점은 이전 완료시점의 <span style="color:red">월말/월초</span>에 일괄지급될 예정이니 조금만 더 기다려주세요.</p>';
		}

		$("#write-title").val(title);
		oEditors.getById["tx_content"].exec("SET_IR", [""]);
		oEditors.getById["tx_content"].exec("PASTE_HTML", [html]);
	}

</script>



<? } ?>