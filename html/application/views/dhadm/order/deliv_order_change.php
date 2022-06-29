<script type="text/javascript">
<!--
	function recom_list_view(no){
		$('#recom_list'+no).toggle();
	}

	function view_recom_foods(idx){
		window.open("<?=cdir()?>/order/delivery/m/recom_foods_pop/?ajax=1&idx="+idx,"recom_foods","width=600,height=800");
	}

	function view_foods_list(code){
		window.open("<?=cdir()?>/order/delivery/m/foods_list/?ajax=1&code="+code,"deliv_foods","width=600,height=800");
	}

	function log_del(idx){
		if(confirm('로그를 삭제 하시겠습니까? 삭제된 로그는 복구 할 수 없습니다.')){
			location.href="/html/order/delivery/m/logdel/"+idx;
		}
	}
//-->
</script>

<style type="text/css">
	.adm-tab{
		border-bottom:2px solid #000;
	}
	.adm-tab th{
		padding:10px;
	}
	.adm-tab th.on{
		border-top:2px solid #000;
		background:#eee;
	}
	.sobigdick{
		font-weight:600;
		font-size:30px;
	}
</style>

<h1 class="sobigdick"><?=$deliv_info->order_name?>, <?=$deliv_info->userid?>, <?=$deliv_info->order_phone?></h1>

<table class="adm-tab mt20 mb20">
	<tr>
		<th <?if($mode == "view"){?>class="on"<?}?>><a href="<?=cdir()?>/order/delivery/m/view/<?=$deliv_code?>/<?=$query_string.$param?>">배송상품 목록</a></th>
		<th <?if($mode == "order_change"){?>class="on"<?}?>><a href="<?=cdir()?>/order/delivery/m/order_change/<?=$deliv_code?>/<?=$query_string.$param?>">주문 변동내역</a></th>
		<th <?if($mode == "memo"){?>class="on"<?}?>><a href="<?=cdir()?>/order/delivery/m/memo/<?=$deliv_code?>/<?=$query_string.$param?>">회원/주문메모</a></th>
		<th <?if($mode == "send_receive"){?>class="on"<?}?>><a href="<?=cdir()?>/order/delivery/m/send_receive/<?=$deliv_code?>/<?=$query_string.$param?>">주문/받는사람</a></th>
	</tr>
</table>


				<!-- 제품리스트 -->
				<h3 class="icon-check">주문 변동내역</h3>
				<table class="adm-table">
					<thead>
						<tr>
							<th>일자</th>
							<th>변동 내역</th>
							<th>상세 내용</th>
							<th>비고</th>
						</tr>
					</thead>
					<tbody>
						<?php
						if($list){
							foreach($list as $lt){
							?>
							<tr>
								<td><?=date("Y-m-d",strtotime($lt->wdate))?> </td>
								<td><?=$lt->type?></td>
								<td><?=$lt->msg?> || 변경자 : <?=$lt->writer?></td>
								<td>
									<input type="button" value="삭제" onclick="log_del('<?=$lt->idx?>')">
								</td>
							</tr>
							<?php
							}
						}
						else{
						?>
						<tr>
							<td colspan="3">기록된 변동내역이 없습니다.</td>
						</tr>
						<?php
						}
						?>

						<?php
						/*
							<tr>
								<td>2018-03-01</td>
								<td>메뉴 변경</td>
								<td>메뉴 식단을 변경하였습니다.</td>
							</tr>
							<tr>
								<td>2018-03-01</td>
								<td>단계 변경</td>
								<td>초기에서 중기로 단계를 변경하였습니다.</td>
							</tr>
							<tr>
								<td>2018-03-01</td>
								<td>배송지 변경</td>
								<td>배송지를 변경하였습니다.</td>
							</tr>
							<tr>
								<td>2018-03-01</td>
								<td>배송일 변경</td>
								<td>배송일이 뭐에서 뭐로 변경되었습니다.</td>
							</tr>
							<tr>
								<td>2018-03-11</td>
								<td>배송일시정지</td>
								<td>배송일시정지 되었습니다.</td>
							</tr>
							<tr>
								<td>2018-03-28</td>
								<td>배송 재시작</td>
								<td>배송이 재시작 되었습니다.</td>
							</tr>
							<tr>
								<td>2018-04-04</td>
								<td>배송 몰아받기</td>
								<td>배송 몰아받기가 요청되어 5,6,7,8 회차분 ? 팩을 일괄 배송합니다.</td>
							</tr>
							<tr>
								<td>2018-04-04</td>
								<td>관리자알림</td>
								<td>?월?일 ?메뉴가 ?메뉴로 일괄 변경 되었습니다.</td>
							</tr>
						*/
						?>
					</tbody>
				</table>

				<form method="post" id="memo_frm">
				<input type="hidden" name="admin_userid" value="<?=$this->session->userdata('ADMIN_USERID')?>">
				<input type="hidden" name="admin_name" value="<?=$this->session->userdata('ADMIN_NAME')?>">
				<div class="mt30">
					<table class="adm-table">
						<tr>
							<td>알림글 작성</td>
							<td><textarea name="memo_content" type="text" id="" rows="5" msg="알림글을"></textarea></td>
							<td><input type="button" value="등록" class="btn-xl" onclick="frmChk('memo_frm')"></td>
						</tr>
					</table>
				</div>
				</form>



<div class="float-wrap mt40">
	<div class="float-l">
		<a href="<?=cdir()?>/order/delivery/m/<?=$query_string.$param?>" class="btn-clear button btn-l">목록으로</a>
	</div>
	<div class="float-r">

		<!-- <button type="button" class="btn-special btn-xl" onclick="">출력하기</button> -->
		<!-- <input type="button" value="저장하기" class="btn-ok btn-xl" onclick=""> -->
		<!-- <? if($trade_stat->trade_method==1){?><input type="button" value="카드취소" class="btn-special btn-xl" onclick="cancel()"><?}?> -->
	</div>
</div>

<?
$flag="admin";
include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/order/".$shop_info['pg_company']."_cancel.php";
?>

