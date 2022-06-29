<?
	$outmode = $this->input->get('outmode');
	if($flag=="outmode"){ $outmode="1"; }
?>
<script type="text/javascript">
<!--
	$(function(){
		$(".memlist_row").on("mouseover",function(){
			$(this).css({"background-color":'#eee','cursor':'pointer'});
		}).on("mouseout",function(){
			$(this).css("background-color",'#fff');
		});
		/*.on("click",function(){
			location.href="<?=self_url()?>/edit/"+$(this).data('memidx')+"/<?=$query_string.$param?>";
		})*/
	});

	function birthday_search(type){
		if(type == "member"){
			location.href="?birth_search=member";
		}
		else if(type == "baby"){
			location.href="?birth_search=baby";
		}
		else{
			location.href="?birth_search=all";
		}
	}
//-->
</script>



				<h3 class="icon-search">검색</h3>
				<!-- 제품검색 -->
				<form name="search_form">
				<table class="adm-table">
					<caption>검색</caption>
					<colgroup>
						<col style="width:15%;"><col>
					</colgroup>
					<tbody>
						<? /*if($flag!="ago"){?>
						<tr>
							<th>분류</th>
							<td>
								<input type="radio" name="outmode" id="outmode1" value="0" <? if($outmode=="0"){ echo "checked"; }?>> <label for="outmode1">회원</label>
								<input type="radio" name="outmode" id="outmode2" value="1" <? if($outmode=="1"){ echo "checked"; }?>> <label for="outmode2">탈퇴회원</label>
							</td>
						</tr>
						<?}*/?>
						<!-- <tr>
							<th>통합검색</th>
							<td>
								<select name="search_flag" onchange="flag_sel(this.value);">
									<option value="">선택</option>
									<option value="level" <? if($this->input->get('search_flag')=="level"){ echo "selected"; }?>>회원등급</option>
									<option value="mailing" <? if($this->input->get('search_flag')=="mailing"){ echo "selected"; }?>>메일링</option>
									<option value="local" <? if($this->input->get('search_flag')=="local"){ echo "selected"; }?>>지역검색</option>
								</select>
								<select name="search_level" id="search_level" class="search_flag" style="display:none;">
									<? foreach ($level_row as $lv_row){ ?>
									<option value="<?=$lv_row->level?>" <? if($this->input->get('search_flag')=="level" && $this->input->get('search_level')==$lv_row->level){ echo "selected"; }?>><?=$lv_row->name?></option>
									<?}?>
								</select>
								<select name="search_mailing" id="search_mailing" class="search_flag" style="display:none;">
									<option value="0" <? if($this->input->get('search_flag')=="mailing" && $this->input->get('search_mailing')=="0"){ echo "selected"; }?>>메일거부</option>
									<option value="1" <? if($this->input->get('search_flag')=="mailing" && $this->input->get('search_mailing')=="1"){ echo "selected"; }?>>메일수신</option>
								</select>
								<select name="search_local" id="search_local" class="search_flag" style="display:none;">
								<? foreach ($city_row as $city){  ?>
								<option value="<?=$city->item?>" <? if($this->input->get('search_flag')=="local" && $this->input->get('search_local')==$city->item){ echo "selected"; }?>><?=$city->item?></option>
								<? } ?>
								</select>
							</td>
						</tr> -->
						<tr>
							<th>가입일자</th>
							<td>
								<input type="text" class="datepicker" name="sdate" value="<?=$this->input->get('sdate')?>"> ~
								<input type="text" class="datepicker" name="edate" value="<?=$this->input->get('edate')?>">
							</td>
						</tr>
						<tr>
							<th>회원검색</th>
							<td>
								<select name="item">
									<option value="phone" <?if($this->input->get('item')=="phone"){?>selected<?}?>>휴대폰</option>
									<option value="userid" <?if($this->input->get('item')=="userid"){?>selected<?}?>>아이디</option>
									<option value="name" <?if($this->input->get('item')=="name"){?>selected<?}?>>이름</option>
									<option value="email" <?if($this->input->get('item')=="email"){?>selected<?}?>>이메일</option>
									<option value="recomid" <?if($this->input->get('item')=="recomid"){?>selected<?}?>>추천인아이디</option>
								</select>
								<input type="text" name="val" class="width-l" value="<?=$this->input->get('val')?>">
								<input type="button" value="검색" class="btn-ok" onclick="javascript:document.search_form.submit();">
								<span class="ml20">
									<button type="button" onclick="birthday_search('member')" class="<?=($this->input->get('birth_search') == "member")?"":"btn-clear";?>">오늘 생일 회원</button>
									<button type="button" onclick="birthday_search('baby')" class="<?=($this->input->get('birth_search') == "baby")?"":"btn-clear";?>">오늘 아기 생일 회원</button>
									<button type="button" onclick="birthday_search('all')" class="<?=($this->input->get('birth_search') == "all")?"":"btn-clear";?>">오늘 생일 회원 & 아기</button>
								</span>
							</td>
						</tr>
					</tbody>
				</table><!-- END 제품검색 -->
				</form>

				<!-- 제품리스트 -->
				<div class="float-wrap mt70">
					<h3 class="icon-list float-l">총 <strong><?=number_format($totalCnt)?>명</strong>
					&nbsp;<input type="button" value="전체 엑셀저장" class="btn-etc" onclick="<?if($totalCnt>0){?>location.href='/html/<?=$this->uri->segment(1)?>/excel_download/<?=$query_string?>&id=member&cont=user&flag=<?=$flag?>'<?}else{?>javascript:alert('저장할 회원이 없습니다.');<?}?>">
					</h3>
					<p class="list-adding float-r">
						<a href="?outmode=<?=$this->input->get("outmode")?>&order=1"<? if($this->input->get('order')==1 || !$this->input->get('order')){?> class="on"<?}?>>등록일순</a>
						<a href="?outmode=<?=$this->input->get("outmode")?>&order=2"<? if($this->input->get('order')==2){?> class="on"<?}?>>이름순</a>
						<a href="?outmode=<?=$this->input->get("outmode")?>&order=3"<? if($this->input->get('order')==3){?> class="on"<?}?>>아이디순</a>
						<a href="?outmode=<?=$this->input->get("outmode")?>&order=4"<? if($this->input->get('order')==4){?> class="on"<?}?>>가입일순</a>
					</p>
				</div>

				<!-- 제품 액션 버튼 -->
				<div class="float-wrap mb20">
					<div class="float-l">※ 회원자료 삭제 시 다른 회원이 기존 회원아이디를 사용하지 못하도록 회원아이디, 이름, 닉네임은 삭제하지 않고 영구 보관합니다.</div>
					<div class="float-r">
					<? if($flag!="ago" && $flag!="outmode"){?><a href="/html/member/user/m/write/" class="button btn-ok">회원 등록</a></span><?}else{?><br><?}?>
					</div>
				</div>
				<!-- END 제품 액션 버튼 -->

				<table class="adm-table line align-c">
					<caption>유저 목록</caption>
					<thead>
						<tr>
							<th><input type="checkbox" id="allcheck" onclick="allchk()"></th>
							<th>아이디<br>등급</th>
							<th>이름</th>
							<!-- <th>닉네임</th>
							<th>전화번호</th> -->
							<th>휴대폰</th>
							<th>이메일</th>
							<th>포인트관리</th>
							<th>쿠폰관리</th>
							<th>예치금</th>
							<th>가입일</th>
							<?php
							if($flag=="outmode"){
								?>
								<th>탈퇴일</th>
								<?php
							}
							else{
								?>
								<th>최종접속일</th>
								<?php
							}
							?>
							<th>주문횟수</th>
							<th>본인인증</th>
							<th>관리</th>
						</tr>
					</thead>
					<tbody class="ft092">
						<form method="post" name="listfrm" id="listfrm">
						<input type="hidden" name="listmode">
						<?
						$list_result = 0;
						if($totalCnt>0){
							$list_result = 1;
							foreach ($list as $lt){
							?>
							<tr class="memlist_row" data-memidx="<?=$lt->idx?>">
								<td><input type="checkbox" name="check[]" class="chkbox" value="<?=$lt->idx?>"></td>
								<td><?=$lt->userid?><? if($outmode=="1"){ ?> <font color="red">(탈퇴회원)</font><?}?><br>(<?=$lt->level_name?>)</td>
								<td><?=$lt->name?></td>
								<!-- <td><?=$lt->nick?></td>
								<td><?=$lt->tel1?>-<?=$lt->tel2?>-<?=$lt->tel3?></td> -->
								<td><?=$lt->phone1?>-<?=$lt->phone2?>-<?=$lt->phone3?></td>
								<td><?=$lt->email?></td>
								<td><input type="button" class="btn-clear btn-sm" value="포인트관리" onclick="openWinPopup('<?=cdir()?>/<?=$this->uri->segment(1)?>/point/<?=$lt->idx?>/?ajax=1','point_set',565,595);"></td>
								<td><input type="button" class="btn-clear btn-sm" value="쿠폰관리" onclick="openWinPopup('<?=cdir()?>/<?=$this->uri->segment(1)?>/coupon/<?=$lt->idx?>/?ajax=1','coupon_set',715,615);"></td>
								<td><input type="button" class="btn-clear btn-sm" value="예치금관리" onclick="openWinPopup('<?=cdir()?>/<?=$this->uri->segment(1)?>/deposit/<?=$lt->idx?>/?ajax=1','coupon_set',715,615);"></td>
								<td><?=strDatecut($lt->register)?></td>
								<?php
								if($flag=="outmode"){
									?>
									<td><?=strDatecut($lt->out_date)?></td>
									<?php
								}
								else{
									?>
									<td><?=strDatecut($lt->last_login)?></td>
									<?php
								}
								?>
								<td><?=number_format($lt->order_count)?></td>
								<td><?=$lt->di?"O":"X";?></td>
								<td>
									<?php
									if(strpos($_SERVER['REQUEST_URI'],"/out")===false){
									?>
									<input type="button" class='btn-sm btn-cancel' value='본인인증 수동처리' onclick="menual_cirtifi('<?=$lt->idx?>')"><br><br>
									<input type="button" value="접속" class="btn-sm btn-clear" onclick="location.href='<?=self_url();?>/admintouser/?idx=<?=$lt->idx?>'">
									<input type="button" value="수정" class="btn-sm" onclick="javascript:location.href='<?=self_url();?>/edit/<?=$lt->idx?>/<?=$query_string.$param?>';">
									<input type="button" value="삭제" class="btn-sm btn-alert" onclick="delOk2(<?=$lt->idx?>)">
									<?php
									}
									else{
										echo $lt->outtype."<br>".$lt->outmsg;
									}
									?>
								</td>
							</tr>
							<?
							}
						}else{
						?>
						<tr>
							<td colspan="11">등록된 회원이 없습니다.</td>
						</tr>
						<?php
						}
						?>
						</form>
					</tbody>
				</table>

				<!-- 제품 액션 버튼 -->
				<div class="float-wrap mt20">
					<div class="float-l">
						<button type="button" onclick="check_del()">선택삭제</button>
						<button type="button" onclick="location.href='/html/<?=$this->uri->segment(1)?>/excel_download/<?=$query_string?>&id=member&cont=user&flag=<?=$flag?>'">검색결과 엑셀저장</button>
					</div>
					<div class="float-r">
					<? if($flag!="ago" && $flag!="outmode"){?><a href="/html/member/user/m/write/" class="button btn-ok">회원 등록</a></span><?}else{?><br><?}?>
					</div>
				</div>
				<!-- END 제품 액션 버튼 -->


			<? if($list_result==1){ ?>
				<!-- Pager -->
				<p class="list-pager align-c" title="페이지 이동하기">
					<?=$Page?>
				</p><!-- END Pager -->
			<?}?>

				<form name="delFrm" method="post">
				<input type="hidden" name="del_ok" value="1">
				<input type="hidden" name="del_idx">
				<input type="hidden" name="out" value="<?=$outmode?>">
				</form>

					<script>

					<? if($this->input->get('search_flag')){ ?>
					flag_sel("<?=$this->input->get('search_flag')?>");
					<?}?>

					function flag_sel(value)
					{
						$(".search_flag").hide();
						$("#search_"+value).show();
					}


					function delOk2(idx)
					{
						document.delFrm.del_idx.value=idx;

						if(document.delFrm.out.value==1){
							if(!confirm("삭제하시겠습니까?\n삭제된 회원은 다시 복구되지 않습니다.")){
								return;
							}
						}else{
							if(!confirm("탈퇴처리 하시겠습니까?")){
								return;
							}
						}

						document.delFrm.submit();

					}

					function allchk(){
						var ac = document.getElementById('allcheck');
						if(ac.checked == true){
							$(".chkbox").prop('checked',true);
						}
						else{
							$(".chkbox").prop('checked',false);
						}
					}

					function check_del(){
						if(confirm('선택하신 회원을 삭제시 영구적으로 삭제됩니다.\n삭제하시겠습니까?')){
							var frm = document.listfrm;
							frm.listmode.value = 'chkdel';
							frm.submit();
						}
					}


					function menual_cirtifi(idx){
						location.href="/html/member/sudong_injueng?ajax=1&idx="+idx;
					}


					</script>