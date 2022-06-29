<?
	$start_day = date("Y-m-d");
	$end_day = date("Y-m-d");

if($this->uri->segment(4)=="edit"){
	
	if(!$row->idx){
		back("잘못된 접근입니다.");
		exit;
	}

	if(isset($row->start_day)){
		$start_day = $row->start_day;
	}
	if(isset($row->end_day)){
		$end_day = $row->end_day;
	}

}
?>
			<form name="frm" id="frm" method="post" enctype="multipart/form-data">
			<input type="hidden" name="popup_add_reg" value="true">

				<!-- 제품정보 -->
				<h3 class="icon-pen"><?if($this->uri->segment(4)=="write"){?>등록<?}else{?>수정<?}?>하기</h3>
				<table class="adm-table mb70">
					<caption>정보를 입력하는 폼</caption>
					<colgroup>
						<col style="width:15%;">
						<col style="width:35%;">
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>
						<tr>
							<th>형태 선택</th>
							<td colspan="3">
							<input type="radio" name="display" id="display0" value="0" <? if( isset($row->display) && $row->display == 0 ) { echo("checked");} ?> <? if( empty($row->display) ){ echo "checked"; } ?> onClick="popupReg()"> <label for="display0">HTML</label><input type="radio" name="display" id="display1" value="1" onClick="popupReg()" <? if( isset($row->display) && $row->display == 1 ) { echo("checked");} ?>> <label for="display1">단일 이미지</label> 
							<input type="radio" name="display" id="display2" value="2" onClick="popupReg()" <? if( isset($row->display) && $row->display == 2 ) { echo("checked");} ?>> <label for="display2">모바일</label>
							</td>
						</tr>
						<tr>
							<th>시작일</th>
							<td><input type="text" class="width-s" name="start_day" id="start_date" readonly msg="시작일을" value="<? echo isset($start_day) ? $start_day : "";?>"></td>
							<th>종료일</th>
							<td><input type="text" class="width-s" name="end_day" id="end_date" readonly msg="종료일을" value="<? echo isset($end_day) ? $end_day : "";?>"></td>
						</tr>
						<tr class="width">
							<th>팝업창 사이즈</th>
							<td>
							가로 : <input type="text" class="width-xs" name="width" id="width" value="<? echo isset($row->width) ? $row->width : "";?>"> px &nbsp;&nbsp;
							세로 : <input type="text" class="width-xs" name="height" id="height" value="<? echo isset($row->height) ? $row->height : "";?>"> px
							</td>
							<td colspan="2">
							새로운 창의 크기를 설정해주세요.
							</td>
						</tr>
						<tr class="tops">
							<th>팝업창 위치</th>
							<td>
							TOP : <input type="text" class="width-xs" name="tops" value="<? echo isset($row->tops) ? $row->tops : "";?>"> px &nbsp;&nbsp;
							LEFT : <input type="text" class="width-xs" name="lefts" value="<? echo isset($row->lefts) ? $row->lefts : "";?>"> px
							</td>
							<td colspan="2">
							미등록시 자동위치선정됩니다.
							</td>
						</tr>
						<tr>
							<th>브라우져 타이틀바</th>
							<td colspan="3"><input type="text" class="width-xl" name="title_bar" msg="브라우져 타이틀바를" value="<? echo isset($row->title_bar) ? $row->title_bar : "";?>">  </td>
						</tr>
						<tr>
							<th>쿠키 설정</th>
							<td colspan="3"><input type="radio" name="live" id="live0" value="0"  <? if( isset($row->live) && $row->live == 0 ) { echo("checked");} ?> <? if( empty($row->live) ){ echo "checked"; } ?>> <label for="live0">※ 오늘은 이창을 다시 띄우지 않음</label><input type="radio" name="live" id="live1" value="1" <? if( isset($row->live) && $row->live == 1 ) { echo("checked");} ?>> <label for="live1">※ 이창은 다시는 띄우지 않음</label></td>
						</tr>

						<tr id="popup_view" style="display:none;">
							<th>출력 이미지</th>
							<td colspan="3">							
								<div class="float-wrap">
									<p class="file">
										<input type="file" id="popup_images" name="popup_images" onchange="file_chg(this.value)"><label for="popup_images" class="btn-file">파일찾기</label>
										<span class="file-name"><? echo isset($row->popup_images) ? $row->popup_images : "선택한 파일이 없습니다.";?></span>
									</p>
								</div>
							</td>
						</tr>
						<tr id="popup_view" style="display:none;">
							<th>링크 url</th>
							<td colspan="3">http://<input type="text" name="link_url" value="<? echo isset($row->link_url) ? $row->link_url : "";?>" style="width:89%;"></td>
						</tr>


						<tr id="popup_view" >
							<td colspan="4">
							<textarea name="tx_content" id="tx_content" style="width:100%; height:412px; display:none;"><? echo isset($row->content) ? $row->content : "";?></textarea>
							</td>
						</tr>


					</tbody>
				</table>
				<p class="align-c mt40">
				<input type="button" value="목록으로" class="btn-m btn-xl" onclick="javascript:location.href='<?=self_url()?>/<?=$query_string?>';">
				<input type="button" class="btn-ok btn-xl" name="writeBtn" value="<?if($this->uri->segment(4)=="write"){?>등록<?}else{?>수정<?}?>하기" onclick="frmChkPopup('frm','editor');">
				</p>

			</form>

<script>

function popupReg()
{


	var form=document.frm;

	if( form.display[0].checked ) {
		document.all.popup_view[0].style.display="none"; 
		document.all.popup_view[1].style.display="none"; 
		document.all.popup_view[2].style.display=""; 
	} else if( form.display[1].checked || form.display[2].checked ) {
		document.all.popup_view[0].style.display=""; 
		document.all.popup_view[1].style.display=""; 
		document.all.popup_view[2].style.display="none";
	}
	
	if(form.display[2].checked){
		$(".width").hide();
		$(".tops").hide();
	}else{
		$(".width").show();
		$(".tops").show();
	}
}
</script>


<script type="text/javascript" src="/_data/smarteditor/js/HuskyEZCreator.js" charset="utf-8"></script>
<script type="text/javascript">

var oEditors = [];

nhn.husky.EZCreator.createInIFrame({
	oAppRef: oEditors,
	elPlaceHolder: "tx_content",
	sSkinURI: "/_data/smarteditor/SmartEditor2Skin.html",	
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


function frmChkPopup(frmName,mode)
{
	var form=document.frm;

		if (checkForm(frmName)) {					
			if(mode=="editor"){
				oEditors.getById["tx_content"].exec("UPDATE_CONTENTS_FIELD", []);
			}

			if ($("#start_date").val() >= $("#end_date").val()) {
				alert("팝업창 시작일과 종료일이 \n\n같은일이나 이전일 경우 등록 되지 않습니다.");
				return;
			}

			if( form.display[1].checked || form.display[0].checked ) {

			if($("#width").val()==""){
				alert("가로 사이즈를 입력해주세요.");
				$("#width").focus();
				return;
			}
			
			if($("#height").val()==""){
				alert("세로 사이즈를 입력해주세요.");
				$("#height").focus();
				return;
			}

			}

			$("#"+frmName).submit();
			document.tx_editor_form.writeBtn.disabled = true;
		}
		return;								
}


popupReg();


</script>