<!doctype html>
<html lang="ko">
<head>
  <title><?=$shop_info['shop_name']?> 관리자모드</title>
	<meta name="Author" content="Minee_Wookchu / by DESIGN HUB">
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=1200, initial-scale=1">

	<link href="https://fonts.googleapis.com/css?family=Open+Sans:400,600,700,800,300" rel="stylesheet" type="text/css">
	<link type="text/css" rel="stylesheet" href="/_dhadm/css/@default.css?t=<?=time()?>" />

	<script type="text/javascript" src="/_dhadm/js/jquery-1.9.1.min.js"></script>
	<script src="/_dhadm/js/jquery.min.js"></script>
	<script type="text/javascript" src="/js/jquery-ui.js"></script>
	<script type="text/javascript" src="/_dhadm/js/cal.js"></script>
	<script type="text/javascript" src="/_dhadm/js/jquery.easing.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/placeholders.min.js"></script>
	<script type="text/javascript" src="/_dhadm/js/common.js"></script>
	<script type="text/javascript" src="/_dhadm/js/form.js"></script>
	<style type="text/css">
		#sodr_list_print_pop { margin: 10px; }
		#sodr_list_print_pop .title { margin-bottom: 30px; }
		#sodr_list_print_pop h1 { position: relative; margin-bottom: 10px; font-size: 20px; height: auto; }
		#sodr_list_print_pop h1 { position: relative; }
		#sodr_list_print_pop h1 .btn_print { position: absolute; right: 0px; top: 0px; font-size: 12px; font-weight: normal; }

		#sodr_list_print_pop .od_info { margin-top: 0px; margin-bottom: 40px; padding-bottom: 40px; }
		#sodr_list_print_pop .od_info h5 { margin-bottom: 20px; font-size: 16px; }
		#sodr_list_print_pop .od_info p.od_help { padding: 5px; font-size: 14px; color: #000; background: #f9f9f9; }
		#sodr_list_print_pop .od_info table { margin-top: 10px; margin-bottom: 20px; }
		#sodr_list_print_pop .od_info table td { text-align: center; line-height: 18px;  background: #fff; border: 1px solid #ddd; font-size: 15px; }
		#sodr_list_print_pop .od_info table td.it_name { padding: 0 5px; text-align: left; font-size:15px;}
		#sodr_list_print_pop .od_info table thead td { padding: 5px; /* font-weight: bold; */ background: #f9f9f9; border: 1px solid #ddd;}
		#sodr_list_print_pop .od_info table tfoot td { font-weight: normal; border: 1px solid #ddd; }
		#sodr_list_print_pop .od_info table tfoot td.info { padding: 5px; text-align: left; }

		h1{font-weight:bold;}
		h5{font-weight:bold;}

		.duplicated{
			background:#0000ff;
			color:#ffffff;
		}
	</style>
</head>
<body>
	<div id="sodr_list_print_pop" class="new_win">
		<div class="title">
			<h1>에코맘의산골이유식 배송일별 주문내역 (<?=$deliv_date?>)<a href="#" class="btn_print">인쇄하기</a></h1>
		</div>

		<?php
		if($list){
			if($_SERVER['HTTP_X_FORWARDED_FOR'] == "58.229.223.174"){
				//pr($list);
			}
			foreach($list as $key=>$val){
				$uid_cnt = $dup_arr[$val['userid']];
			?>
			<div class="od_info">
				<h5>
					에코맘의산골이유식 - <?=$val['name']?>님 주문 내역서 <?=$val['deliv_code']?>
					<?if($uid_cnt > 1){?><span class="duplicated" style="padding:2px 5px;"><?=$uid_cnt?></span><?}?>
				</h5>

				<table cellpadding="0" cellspacing="1" border="0">
					<colgroup>
						<col width="70px" />
						<col width="140px" />
						<col width="100px" />
						<col width="100px" />
						<col width="70px" />
						<col width="60px" />
						<col>
					</colgroup>
					<thead>
						<tr>
							<td>배송일</td>
							<td>주문번호 / 주문일시</td>
							<td>주문자</td>
							<td>운송장정보</td>
							<td>단계</td>
							<td>수량</td>
							<td>상품명</td>
						</tr>
					</thead>
					<tbody>
						<?php
						$prod_cnt = 0;
						$key_cnt = 0;
						foreach($val as $k=>$v){
							$option_cnt = 0;
							if($k == $key_cnt){
								$key_cnt++;

								if($v['sum_prod_cnt']){
									$prod_cnt += $v['sum_prod_cnt'];
									$goods_cnt = $v['sum_prod_cnt'];
								}
								else{
									foreach($v['option_info'] as $option){
										$prod_cnt += $option['cnt'];
										$option_cnt += $option['cnt'];
									}
									$goods_cnt = $option_cnt;
								}

								//$prod_cnt += ($v['sum_prod_cnt'] ? $v['sum_prod_cnt'] : $val['option_info']['cnt']) ;
								//$goods_cnt = ($v['sum_prod_cnt'] ? $v['sum_prod_cnt'] : $val['option_info']['cnt']) ;
								if($v['recom_is'] == "Y" and $key_cnt == 1){
									?>
									<tr>
										<td data-value="<?=$v['deliv_code']?>-<?=strtotime($v['deliv_date'])?>"><?=$v['deliv_date']?></td>
										<td data-value="<?=$v['deliv_code']?>-<?=$v['trade_code']?>">
											<?=$v['trade_code']?><br />
											<?=$v['trade_day']?><br />
											(<?=($v['mobile'] == 1)?"M":"P"?>)
										</td>
										<td data-value="<?=$v['deliv_code']?>-<?=$v['trade_code']?>">
											<?=$v['order_name']?><br />
											<?=$v['userid']?><br />
											<?=$v['level_name']?>
										</td>
										<td data-value="<?=$v['deliv_code']?>-<?=$v['invoice_no']?>">
											우체국<br />
											<?=$v['invoice_no']?>
										</td>
										<td data-value="<?=$v['deliv_code']?>-<?=($v['recom_is'] == "Y")?"yes":"no";?><?=(strpos($v['cate_no'],"2-")!==false)?"-2-":"";?>">
											<?=(strpos($v['cate_no'],"2-") !== false)?"반찬·국":$v['cate_name'];?>
										</td>
										<td colspan="2" style="text-align:left;padding-left:5px">
											<?php
											$v_prod_name_tmp = explode(",",$v['prod_name']);
											$recom_week_type = explode(":",$v['recom_week_type']);

											echo $v_prod_name_tmp[0];
											if($v['recom_week_day_count'] && $v['recom_week_type']){
												echo " ".$v['recom_week_day_count']."일분 (주 ".$recom_week_type[0]."회 배송 ".$recom_week_type[1].") ".$v['recom_week_count']."주";
											}
											echo (count($v_prod_name_tmp) > 1) ? " 외 " . (count($v_prod_name_tmp)-1) . " 건" : "" ;
											?>
										</td>
									</tr>
									<?php
								}
								?>
								<tr>
									<td data-value="<?=$v['deliv_code']?>-<?=strtotime($v['deliv_date'])?>"><?=$v['deliv_date']?></td>
									<td data-value="<?=$v['deliv_code']?>-<?=$v['trade_code']?>">
										<?=$v['trade_code']?><br />
										<?=$v['trade_day']?><br />
										(<?=($v['mobile'] == 1)?"M":"P"?>)
									</td>
									<td data-value="<?=$v['deliv_code']?>-<?=$v['trade_code']?>">
										<?=$v['order_name']?><br />
										<?=$v['userid']?><br />
										<?=$v['level_name']?>
									</td>
									<td data-value="<?=$v['deliv_code']?>-<?=$v['invoice_no']?>">
										우체국<br />
										<?=$v['invoice_no']?>
									</td>
									<td data-value="<?=$v['deliv_code']?>-<?=($v['recom_is'] == "Y")?"yes":"";?><?=(strpos($v['cate_no'],"2-")!==false ? "-2-" : ($v['recom_is'] == "Y" ? "" : $v['cate_no']) );?>">
										<?=(strpos($v['cate_no'],"2-") !== false)?"반찬·국":$v['cate_name'];?>
									</td>
									<td style="background:#<?if($goods_cnt > 4){ echo "dbdbff"; }else if($goods_cnt > 3){ echo "aaffaa"; }else if($goods_cnt > 2){ echo "FFFFaa"; }else if($goods_cnt > 1){ echo "ffaaaa"; }?>;font-weight:bold;font-size:17px"><?=$goods_cnt?></td>
									<td style="text-align:left;padding-left:5px;padding-top:2px;padding-bottom:2px;font-weight:bold;font-size:17px">
										<?=$v['goods_name']?>
										<?php
										if($v['option_cnt'] > 0){
											echo "<br>";
											foreach($v['option_info'] as $op){
												if($op['goods_idx'] == $v['goods_idx']){
													echo "&nbsp;".$op['name']." x ".$op['cnt']."<BR>";
												}
											}
										}
										?>
									</td>
								</tr>
								<?php
								//$prev_cate_no = (strpos($v['cate_no'],"2-") !== false) ? "2-" : $v['cate_no'];
							}
						}
						?>
					</tbody>
					<tfoot>
						<tr>
							<td rowspan="2" colspan="3">
								<?=($val['first_order'] == "Y")?"<img src='/image/forder.jpg'>":"";?>
							</td>
							<td colspan="2">총수량</td>
							<td><?=$prod_cnt?></td>
							<td></td>
						</tr>
						<tr>
							<td colspan="2" class="name"><span style="font-size: 16px; font-weight: bold;">수령자: <?=$val['recv_name']?></span></td>
							<td colspan="3" class="info">
								수령자 연락처: <?=$val['recv_phone']?><br />
								수령주소: (<?=$val['zipcode']?>) <?=$val['addr1']?> <?=$val['addr2']?><br />
								<?if($val['send_text']){?>
									배송메세지: <?=$val['send_text']?>
								<?}?>
							</td>
						</tr>
					</tfoot>
				</table>
				<div class="page_break" style="page-break-before: always;"></div>
			</div>
			<?php
			}
		}
		else{
			?>
			<script type="text/javascript">
//			alert("Error !!");
//			self.close();
			</script>
			<?php
		}
		?>

		<?php
		/*
		<div class="od_info od_info_2018052508395751">
			<h5>에코맘의산골이유식 - 서수정님 주문 내역서 20180525-08395751</h5>

			<table cellpadding="0" cellspacing="1" border="0">
				<colgroup>
					<col width="70px" />
					<col width="140px" />
					<col width="100px" />
					<col width="100px" />
					<col width="70px" />
					<col width="60px" />
					<col>
				</colgroup>
				<thead>
					<tr>
						<td>배송일</td>
						<td>주문번호 / 주문일시</td>
						<td>주문자</td>
						<td>운송장정보</td>
						<td>단계</td>
						<td>수량</td>
						<td>상품명</td>
					</tr>
				</thead>
				<tbody>
					<tr>
						<td rowspan="4">2018-05-26</td>
						<td rowspan="4">
							20180525-08395751<br />
							2018-05-25 08:40<br />
							(M)<br />
						</td>
						<td rowspan="4">
							서수정<br />
							szo3ov<br />
							아름드리
						</td>
						<td rowspan="4">
							우체국<br />
							6864024352705
						</td>
						<td rowspan="4">반찬/국</td>
						<td style="background:;">1</td>
						<td class="it_name">E34. 양송이일품요리</td>
					</tr>
					<tr>
						<td style="background:;">1</td>
						<td class="it_name">E41. 우엉버섯덮밥요리</td>
					</tr>
					<tr>
						<td style="background:;">1</td>
						<td class="it_name">E47. 잎새버섯한우불고기요리</td>
					</tr>
					<tr>
						<td style="background:#ffaaaa;">2</td>
						<td class="it_name">G23. 닭살두부찌개</td>
					</tr>
				</tbody>
				<tfoot>
					<tr>
						<td rowspan="2" colspan="3"></td>
						<td colspan="2">총수량</td>
						<td>5</td>
						<td></td>
					</tr>
					<tr>
						<td colspan="2" class="name"><span style="font-size: 16px; font-weight: bold;">수령자: 서수정</span></td>
						<td colspan="3" class="info">
							일반전화: 01086195821<br />
							휴대전화: 010-8619-5821<br />
							수령주소: (50146) 경남 거창군 거창읍 강남로 266, 104동903호 (대평리, 거창코아루에듀시티)<br />
							배송메세지: 주문했어요 확인해주세요~~!!!
						</td>
					</tr>
				</tfoot>
			</table>
			<div class="page_break" style="page-break-before: always;"></div>
		</div>
		*/
		?>

		<!-- /.od_info -->

	</div> <!-- /#sodr_list_print_pop -->

	<script type="text/javascript">
	$(document).ready(function() {

		$(".od_info table tbody").rowspan(0);
		$(".od_info table tbody").rowspan(1);
		$(".od_info table tbody").rowspan(2);
		$(".od_info table tbody").rowspan(3);
		$(".od_info table tbody").rowspan(4);

		$('.page_break').each(function() {
			if ($(this).next().hasClass('page_break')) $(this).remove();
		});

		// 프린트
		$('.btn_print').click(function() {
			$('.title').hide();
			window.setTimeout(function() { $('.title').show(); }, 1000);
			window.print();
			return false;
		});
	});
	</script>


</body>
</html>

















