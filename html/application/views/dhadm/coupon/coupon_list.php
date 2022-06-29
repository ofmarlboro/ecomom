<style type="text/css">
	.ft092 tr:hover{
		background:#eee;
	}
</style>


<h3 class="icon-search">검색</h3>
<form name="search_form">
	<table class="adm-table mb30">
		<caption>검색</caption>
		<colgroup>
			<col style="width:15%;"><col>
		</colgroup>
		<tbody>
			<tr>
				<th>검색</th>
				<td>
					<input type="text" name="code" class="width-l" value="<?=$this->input->get('code')?>" placeholder="쿠폰코드">
					<input type="button" value="검색" class="btn-ok" onclick="javascript:document.search_form.submit();">
				</td>
			</tr>
		</tbody>
	</table>
</form>

				<?php
				if($_SERVER['HTTP_X_FORWARDED_FOR'] == '58.229.223.174'){
					?>
					<h3 class="icon-cate mt20 mb30">쿠폰 업로드 (디자인허브 IP만 보임)</h3>
					<div class="float-wrap">
						<div class="float-l" style="color:#000;font-weight:600">
							DB에 등록된 쿠폰과 코드가 중복되는경우는 중복됨을 알립니다.<br>
							하지만 <span style="color:red">엑셀로 업로드 하는 쿠폰코드</span>는 <span style="color:red">중복여부를 판단</span>할수 <span style="color:red">없으므로</span><br>
							반드시 <span style="color:red">코드 중복확인</span>을 하시고 <span style="color:red">업로드</span>하시기 바랍니다.
						</div>
						<div class="float-r">
							<a href="/_data/file/ppcp_sample.xlsx" type="application/vnd.openxmlformats-officedocument.spreadsheetml.sheet" download class='button'>샘플 다운로드</a>
						</div>
					</div>

					<form method="post" id="efrm" action="<?=cdir()?>/order/coupon_two_up" enctype="multipart/form-data">
					<table class="adm-table mt20 mb30">
						<tr>
							<th>엑셀파일 업로드</th>
							<td>
								<input type="file" name="upload_excel" msg="파일을">
							</td>
							<td>
								<input type="button" value="업로드" onclick="frmChk('efrm')">
							</td>
						</tr>
					</table>
					</form>
					<?php
				}
				?>

				<!-- 제품리스트 -->
				<div class="float-wrap">
					<h3 class="icon-list float-l">등록된 쿠폰 <strong><?=$totalCnt?>개</strong></h3>
					<div class="float-r">
						<!-- <input type="button" value="사용내역 엑셀저장" onclick="use_coupon_list()">
						<script type="text/javascript">
							function use_coupon_list(){
								location.href="/html/order/coupon_use_list_excel/<?=$query_string?>&ajax=1";
							}
						</script> -->
					</div>
				</div>

				<table class="adm-table v-line align-c">
					<caption>유저 목록</caption>
					<!-- <colgroup>
						<col style="width:40px;"><col style="width:135px;"><col><col style="width:105px;"><col><col style="width:210px;">
					</colgroup> -->
					<thead>
						<tr>
							<!-- <th><input type="checkbox" id="allcheck1"><label for="allcheck1" class="hidden">모두선택</label></th> -->
							<th>쿠폰코드</th>
							<th>쿠폰명</th>
							<!-- <th>할인</th>
							<th>유효기간</th> -->
							<th>사용여부</th>
							<th>변경</th>
							<th>관리</th>
						</tr>
					</thead>
					<tbody class="ft092">
						<?
							$list_result = 0;
							if($totalCnt>0){
							$list_result = 1;
							foreach ($list as $lt){
								if($lt->date_flag==1){
									$max_day = explode(" ",$lt->max_day);
									$max_day_text = explode("+",$max_day[0]);
								}
						?>
						<tr>
							<!-- <td><input type="checkbox" name="check" value="" class="sel"></td> -->
							<td><?=$lt->code?></td>
							<td><?=$lt->name?></td>
							<!-- <td><?if($lt->type==3){?>배송비 전액<?}else{?><?=number_format($lt->price)?><? if($lt->discount_flag==0){?>원<?}else if($lt->discount_flag==1){?>%<?}?><?}?></td>
							<td>
							<? if($lt->date_flag==0){?>
								<?=$lt->start_date?>~<?=$lt->end_date?>
							<?}else if($lt->date_flag==1){?>
								발급일자로부터 <?=$max_day_text[1]?><?if($max_day[1]=="day"){?>일<?}else if($max_day[1]=="month"){?>개월<?}?>
							<?}?>
							</td> -->
							<td><?=$lt->status?"사용":"미사용";?></td>
							<td>
								<!-- <input type="button" value="쿠폰이용내역" class="btn-sm2" onclick="openWinPopup('<?=cdir()?>/order/couponTrade/<?=$lt->idx?>/?ajax=1','point_set',565,595);"> -->
								<!-- <input type="button" value="수정" class="btn-sm" onclick="javascript:location.href='<?=cdir()?>/order/coupon/m/edit/<?=$lt->idx?>/<?=$query_string.$param?>';"> -->
								<?php
								if($lt->status){
									?>
									<input type="button" value="미사용으로 변경" class="btn-sm btn-ok" onclick="return_status('<?=$lt->idx?>')">
									<?php
								}
								?>
							</td>
							<td>
								<input type="button" value="삭제" class="btn-sm btn-alert" onclick="delOk(<?=$lt->idx?>)">
							</td>
						</tr>
						<?
							$totalCnt--;
							}
							}else{
						?>
						<tr>
							<td colspan="6">등록된 쿠폰이 없습니다.</td>
						</tr>
						<?}?>
					</tbody>
				</table>

				<!-- 제품 액션 버튼 -->
				<div class="float-wrap mt20">
					<!-- <div class="float-l">
						<input type="button" value="선택삭제" class="btn-alert" onclick="goods_select('del')" >
					</div>
					<div class="float-r">
						<a href="<?=self_url()?>/write/" class="button btn-ok">새 쿠폰 등록</a></span>
					</div> -->
				</div><!-- END 제품 액션 버튼 -->

			<? if($list_result==1){ ?>
				<!-- Pager -->
				<p class="list-pager align-c" title="페이지 이동하기">
					<?=$Page?>
				</p><!-- END Pager -->
			<?}?>
			<!-- END 제품리스트 -->

				<form name="delFrm" method="post">
				<input type="hidden" name="del_ok" value="1">
				<input type="hidden" name="del_idx">
				</form>

<form name="retfrm" method="post" action="<?=$_SERVER['REDIRECT_URL']?>/cpret">
	<input type="hidden" name="idx">
</form>
<script type="text/javascript">
	function return_status(idx){
		frm = document.retfrm;
		frm.idx.value = idx;
		if(confirm("해당 쿠폰코드를 미사용으로 변경 하시겠습니까?")){
			frm.submit();
		}
	}
</script>