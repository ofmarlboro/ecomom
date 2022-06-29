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

<?php
include $_SERVER['DOCUMENT_ROOT']."/html/application/views/dhadm/od.view.meminfo.top.php";
?>

<script type="text/javascript">
	function price_update_send(){
		if(confirm('주문 금액을 수정하시겠습니까?')){
			document.price_update.submit();
		}
	}
</script>

<table class="adm-tab mt20 mb20">
	<tr>
		<th <?if($mode == "view"){?>class="on"<?}?>><a href="<?=cdir()?>/order/lists/m/view/<?=$trade_idx?>/<?=$query_string.$param?>">주문상품목록</a></th>
		<th <?if($mode == "payment"){?>class="on"<?}?>><a href="<?=cdir()?>/order/lists/m/payment/<?=$trade_idx?>/<?=$query_string.$param?>">주문결제내역</a></th>
		<th <?if($mode == "memo"){?>class="on"<?}?>><a href="<?=cdir()?>/order/lists/m/memo/<?=$trade_idx?>/<?=$query_string.$param?>">회원/주문메모</a></th>
		<th <?if($mode == "send_receive"){?>class="on"<?}?>><a href="<?=cdir()?>/order/lists/m/send_receive/<?=$trade_idx?>/<?=$query_string.$param?>">주문/받는사람</a></th>
	</tr>
</table>

<h3 class="icon-check">주문 결제내역</h3>

<?php
//pr($trade_stat);
?>


	<div class="tbl_frm01">

			<table class="adm-table">
			<caption>결제상세정보</caption>
			<colgroup>
					<col style="width:15%">
					<col>
			</colgroup>
			<tbody>
			<?php
			if ($trade_stat->trade_method == '2' || $trade_stat->trade_method == '3' || $trade_stat->trade_method == '4') {
				if ($trade_stat->trade_method == '2' || $trade_stat->trade_method == '4') {
				?>
				<tr>
					<th scope="row">계좌번호</th>
					<td><?=$trade_stat->enter_account?> (<?=$trade_stat->enter_bank?>) 입금자 성명: <?=$trade_stat->enter_name?></td>
				</tr>
				<?php
				}
				?>
				<tr>
					<th scope="row"><?=$shop_info['trade_method'.$trade_stat->trade_method]?> 입금액</th>
					<td><?=number_format($trade_stat->total_price)?> 원</td>
				</tr>
				<tr>
					<th colspan="2">---------- 주문총액 수정 (숫자만 입력) ----------</th>
				</tr>
				<tr>
					<th>주문총액</th>
					<td><?=number_format($trade_stat->price)?> 원</td>
				</tr>
				<tr>
					<th>주문총액 수정</th>
					<td>
						<form method="post" name="price_update" id="price_update" style="margin:0px;padding:0px;display:inline">
							<input type="hidden" name="uid" value="<?=$this->session->userdata('ADMIN_USERID')?>">
							<input type="hidden" name="oprice" value="<?=$trade_stat->price?>">
							<input type="hidden" name="tidx" value="<?=$trade_stat->idx?>">

						<input type="text" class="width-xs" name="price" value="<?=$trade_stat->price?>">
						<input type="button" class="btn-sm btn-cancel" value="수정" onclick="price_update_send()">
						</form>
					</td>
				</tr>
				<tr>
					<td colspan="2">
						<table>
							<tr>
								<th>날짜</th>
								<th>처리자</th>
								<th>수정전 금액</th>
								<th>수정후 금액</th>
							</tr>
							<?php
							foreach($price_log as $plog){
								?>
								<tr>
									<td><?=$plog->wdate?></td>
									<td><?=$plog->uid?></td>
									<td><?=number_format($plog->op)?></td>
									<td><?=number_format($plog->up)?></td>
								</tr>
								<?php
							}
							?>
						</table>
					</td>
				</tr>
				<tr>
						<th scope="row">입금자</th>
						<td><?=$trade_stat->enter_name?></td>
				</tr>
				<tr>
						<th scope="row">입금확인일시</th>
						<td>
							<?=$trade_stat->trade_day_ok?>
						</td>
				</tr>
				<?php
			}

			if ($trade_stat->trade_method == '9') {
				?>
				<tr>
					<th scope="row"><?=$shop_info['trade_method'.$trade_stat->trade_method]?> 입금액</th>
					<td><?=number_format($trade_stat->total_price)?> 원</td>
				</tr>
				<?php
			}
			?>

			<!-- <?php if ($od['od_settle_case'] == '휴대폰') { ?>
			<tr>
					<th scope="row">휴대폰번호</th>
					<td><?php echo $od['od_bank_account']; ?></td>
					</tr>
			<tr>
					<th scope="row"><?php echo $od['od_settle_case']; ?> 결제액</th>
					<td><?php echo display_price($od['od_receipt_price']); ?></td>
			</tr>
			<tr>
					<th scope="row">결제 확인일시</th>
					<td>
							<?php if ($od['od_receipt_time'] == 0) { ?>결제 확인일시를 체크해 주세요.
							<?php } else { ?><?php echo $od['od_receipt_time']; ?> (<?php echo get_yoil($od['od_receipt_time']); ?>)
							<?php } ?>
					</td>
			</tr>
			<?php } ?> -->

			<?php if ($trade_stat->trade_method == '1') { ?>
			<tr>
					<th scope="row" class="sodr_sppay">신용카드 결제금액</th>
					<td>
						<?=number_format($trade_stat->total_price)?> 원
					</td>
			</tr>
			<tr>
					<th scope="row" class="sodr_sppay">카드 승인일시</th>
					<td>
							<?=$trade_stat->trade_day_ok?>
					</td>
			</tr>
			<?php } ?>

			<!-- <?php if ($od['od_settle_case'] == 'KAKAOPAY') { ?>
			<tr>
					<th scope="row" class="sodr_sppay">KAKOPAY 결제금액</th>
					<td>
							<?php if ($od['od_receipt_time'] == "0000-00-00 00:00:00") {?>0원
							<?php } else { ?><?php echo display_price($od['od_receipt_price']); ?>
							<?php } ?>
					</td>
			</tr>
			<tr>
					<th scope="row" class="sodr_sppay">KAKAOPAY 승인일시</th>
					<td>
							<?php if ($od['od_receipt_time'] == "0000-00-00 00:00:00") {?>신용카드 결제 일시 정보가 없습니다.
							<?php } else { ?><?php echo substr($od['od_receipt_time'], 0, 20); ?>
							<?php } ?>
					</td>
			</tr>
			<?php } ?> -->

			<!-- <?php if ($od['od_settle_case'] == '간편결제') { ?>
			<tr>
					<th scope="row" class="sodr_sppay"><?php echo $s_receipt_way; ?> 결제금액</th>
					<td>
							<?php if ($od['od_receipt_time'] == "0000-00-00 00:00:00") {?>0원
							<?php } else { ?><?php echo display_price($od['od_receipt_price']); ?>
							<?php } ?>
					</td>
			</tr>
			<tr>
					<th scope="row" class="sodr_sppay"><?php echo $s_receipt_way; ?> 승인일시</th>
					<td>
							<?php if ($od['od_receipt_time'] == "0000-00-00 00:00:00") { echo $s_receipt_way; ?> 결제 일시 정보가 없습니다.
							<?php } else { ?><?php echo substr($od['od_receipt_time'], 0, 20); ?>
							<?php } ?>
					</td>
			</tr>
			<?php } ?> -->

			<?php if ($trade_stat->trade_method != '2' && $trade_stat->trade_method != '9') { ?>
			<tr>
					<th scope="row">결제대행사 링크</th>
					<td>
							<?php
							if ($trade_stat->trade_method != '2') {
									switch($shop_info['pg_company']) {
											case 'lguplus':
													$pg_url  = 'http://pgweb.uplus.co.kr';
													$pg_test = 'LG유플러스';
													if ($default['de_card_test']) {
															$pg_url = 'http://pgweb.uplus.co.kr/tmert';
															$pg_test .= ' 테스트 ';
													}
													break;
											case 'inicis':
													$pg_url  = 'https://iniweb.inicis.com/';
													$pg_test = 'KG이니시스';
													break;
											case 'KAKAOPAY':
													$pg_url  = 'https://mms.cnspay.co.kr';
													$pg_test = 'KAKAOPAY';
													break;
											default:
													$pg_url  = 'http://admin8.kcp.co.kr';
													$pg_test = 'KCP';
													if ($default['de_card_test']) {
															// 로그인 아이디 / 비번
															// 일반 : test1234 / test12345
															// 에스크로 : escrow / escrow913
															$pg_url = 'http://testadmin8.kcp.co.kr';
															$pg_test .= ' 테스트 ';
													}

											}
									echo "<a href=\"{$pg_url}\" target=\"_blank\">{$pg_test}바로가기</a><br>";
							}
							//------------------------------------------------------------------------------
							?>
						<span class="dh_red_st">2020년 05월 26일 13시 34분 이전 결제는 LG유플러스에서 진행되었습니다. <a href="http://pgweb.uplus.co.kr" target="_blank">LG유플러스바로가기</a></span>
					</td>
			</tr>
			<?php } ?>

			<!-- <?php if($od['od_tax_flag']) { ?>
			<tr>
					<th scope="row">과세공급가액</th>
					<td><?php echo display_price($od['od_tax_mny']); ?></td>
			</tr>
			<tr>
					<th scope="row">과세부가세액</th>
					<td><?php echo display_price($od['od_vat_mny']); ?></td>
			</tr>
			<tr>
					<th scope="row">비과세공급가액</th>
					<td><?php echo display_price($od['od_free_mny']); ?></td>
			</tr>
			<?php } ?> -->
			<!-- 2015-12-16 trend9.kr -->
			<?php
			/*
			<tr>
					<th scope="row">회원등급별 주문금액할인</th>
					<td><??></td>
			</tr>
			*/
			?>

			<?php
			if($trade_stat->use_coupon > 0){
				?>
				<tr>
						<th scope="row">쿠폰할인액</th>
						<td>
							<?=number_format($trade_stat->use_coupon)?> 원
						</td>
				</tr>
				<?php
			}
			?>

			<?php
			if($trade_stat->use_point > 0){
				?>
				<tr>
						<th scope="row">포인트 결제</th>
						<td><?=number_format($trade_stat->use_point)?> 원</td>
				</tr>
				<?php
			}
			?>

			<?php
			/*

			<?php if ($cancel_price) { ?>
											<tr>
													<th scope="row">주문취소액</th>
													<td><?php echo display_price($od['od_cancel_price']); ?></td>
											</tr>
			<?php } ?>

			<tr>
					<th scope="row">결제취소/환불액</th>
					<td><?php echo display_price($od['od_refund_price']); ?></td>
			</tr>
			*/
			?>

			<tr>
					<th scope="row"><label for="od_send_cost">배송비</label></th>
					<td>
						<?=number_format($trade_stat->delivery_price)?> 원
					</td>
			</tr>

			<?php
			if ($trade_stat->cash_receipt) {
			?>
			<tr>
					<th scope="row">현금영수증</th>
					<td>
						<?php
						echo ($trade_stat->cash_number)?$trade_stat->cash_number:$trade_stat->cash_authno;
						?>
					</td>
			</tr>
			<?php
			}
			?>
			</tbody>
			</table>
	</div>


<div class="float-wrap mt40">
	<div class="float-l">
		<a href="<?=cdir()?>/order/lists/m/<?=$query_string.$param?>" class="btn-clear button btn-l">목록으로</a>
	</div>
	<div class="float-r">

		<!-- <button type="button" class="btn-special btn-xl" onclick="">출력하기</button> -->
		<!-- <input type="button" value="저장하기" class="btn-ok btn-xl" onclick=""> -->
		<!-- <? if($trade_stat->trade_method==1){?><input type="button" value="카드취소" class="btn-special btn-xl" onclick="cancel()"><?}?> -->
	</div>
</div>