<?
	alert("/","잘못된 접근입니다.");

	$PageName = "ORDEREDIT";
	$SubName = "";
	$PageTitle = "";
	include('../include/head.php');
	include('../include/header.php');
?>
<script type="text/javascript" src="/js/orderPage.js"></script>
<script type="text/javascript">
<!--
	function deliv_allin(no){
		var deliv_code = $("select[name='deliv_code"+no+"']").val();

		var deliv_count = $("select[name='deliv_code"+no+"']").find(":selected").data('delivcount');
		var total_count = $("select[name='deliv_code"+no+"']").find(":selected").data('totalcount');
		var deliv_date = $("select[name='deliv_code"+no+"']").find(":selected").data('delivdate');
		var delivdate_name = $("select[name='deliv_code"+no+"']").find(":selected").data('delivdatename');

		var count_between = "";

		for(i=parseInt(deliv_count);i<=parseInt(total_count);i++){
			count_between += i;
			if(i < parseInt(total_count)){
				count_between += ", ";
			}
		}

		if(deliv_code){
			if(confirm(deliv_count+"회차부터 남은식단을 한 번에 몰아받기입니다.\n\n"+count_between+"회차에 받으실 수량을\n"+deliv_date+"("+delivdate_name+")에 모두 보내드립니다.\n\n"+deliv_date+"("+delivdate_name+") 식단으로 남은 수량을 보내드리오니\n이점 꼭 확인해 주세요.")){
				document.allin.deliv_code.value = deliv_code;

				document.allin.deliv_count.value = deliv_count;
				document.allin.count_between.value = count_between;
				document.allin.submit();
			}
		}

		//var popupX = (window.screen.width / 2) - (484/2);
		//var popupY = (window.screen.height / 2) - (640/2);
		//window.open("<?=cdir()?>/dh_order/order_edit05/?mode=deliv_allin&deliv_code="+encodeURIComponent(deliv_code) ,"deliv_date_change" ,'scrollbar=no, width=484, height=640, left='+ popupX + ', top='+ popupY + ', screenX='+ popupX + ', screenY= '+ popupY);
	}

	function deliv_allin_none(no){
		var deliv_code = $("select[name='deliv_code"+no+"']").val();
		$.ajax({
			url:"<?=cdir()?>/dh/dh_ajax/?ajax=1&mode=allin_not&deliv_code="+deliv_code,
			type:"GET",
			cache:false,
			dataType:"json",
			error:function(xhr){
				console.log(xhr.responseText);
			},
			success:function(data){
				$(".layer_pop01").html(data.page);
				$(".layer_pop01").show();
			}
		});
	}

	function closeMenuView(){
		$(".layer_pop01").hide();
	}

	function fkk_none(){
		alert("죄송합니다.\n배송일정에 다른 주문이 포함되어있는 관계로 몰아받기를 바로 변경하실 수 없습니다.\n1대1문의를 통해 접수해 주세요.");
		location.href='/html/dh_board/lists/withcons07/?myqna=Y';
	}
//-->
</script>

<!--Container-->

<div id="container">
	<?include("../include/my_top.php");?>
	<div class="inner clearfix">
		<?include("../include/mypage_lnb.php");?>
		<div class="my_cont clearfix">
			<!-- 탭 -->
			<?php include "../include/order_edit_tabs.php";?>
			<!-- 안내사항 -->
			<p class="orderedit_top">
				변경가능내역만 조회되며, 배송완료/배송준비중은 변경 불가합니다.
			</p>
			<!-- 05 배송 몰아받기 -->
			<div>
				<form name="allin" method="post">
					<input type="hidden" name="deliv_code">

					<input type="hidden" name="deliv_count">
					<input type="hidden" name="count_between">
				</form>
				<div class="my_tit">
					배송 몰아받기
				</div>
				<p class="orderedit_top">
					회차별로 받을 식단을 한번에 받으실 수 있습니다. 몰아받고 싶은 날짜를 선택해 주세요.
				</p>
				<p class="orderedit_top">
					주의 : 몰아받기를 선택한 날짜에 해당하는 식단으로 남은 회차만큼 수량을 더해서 받게 됩니다.
				</p>
				<div class="tblTy01">
					<table>
						<colgroup>
							<col width="15%">
						</colgroup>
						<tr>
							<th>구분</th>
							<th>주문내역</th>
							<th>배송회차</th>
							<th>비고</th>
						</tr>
						<?php
						if($list){
							$list_cnt = 0;
							$old_trade = "";
							foreach($list as $lt){
								if($old_trade != $lt->trade_code){
									$list_cnt++;
									$recom_count_arr = array();
									$deliv_date_arr = explode("^",substr($lt->recom_dates,0,-1));
									$last_date = end($deliv_date_arr);
									foreach($deliv_date_arr as $key=>$val){
										$recom_count_arr[$val] = $key+1;	//배열에 날짜를 넣으면 회차가 나옴
									}

									$last_recom_date = end($deliv_date_arr);
								?>
								<tr>

									<td>정기배송</td>
									<td><?=$lt->prod_name?></td>
									<td>
										<select name="deliv_code<?=$list_cnt?>" class="reg_sel">
											<?php
											$dcnt = 0;
											foreach($list as $deliv_list){
												if($lt->trade_code == $deliv_list->trade_code and $last_recom_date != $deliv_list->deliv_date){
													$prod_name_arr = explode(",",$deliv_list->prod_name);
													$prod_name = $prod_name_arr[0];
													if(count($prod_name_arr) > 1) $prod_name .= " 외 ".(count($prod_name_arr)-1)."건";

													$deliv_count = "";	//정기배송 회차 정보
													if($deliv_list->recom_is == "Y") $deliv_count = $recom_count_arr[$deliv_list->deliv_date]."회차";
													?>
													<!-- <option value="">3/14(수) 영양식단 중기 3회차 [변경가능]</option> -->
													<option value="<?=$deliv_list->deliv_code?>" data-delivcount="<?=$recom_count_arr[$deliv_list->deliv_date]?>" data-totalcount="<?=$recom_count_arr[$last_date]?>" data-delivdate="<?=$deliv_list->deliv_date?>" data-delivdatename="<?=numberToWeekname($deliv_list->deliv_date)?>"><?=date("m/d", strtotime($deliv_list->deliv_date))."(".numberToWeekname($deliv_list->deliv_date).") ".$prod_name." ".$deliv_count?></option>
													<?php
													foreach($info_list as $deliv){
														if($deliv->deliv_date == $deliv_list->deliv_date){
															$dcnt++;
														}
													}
												}
											}
											?>
										</select>
									</td>
									<td>
										<?php
										if($dcnt){
											?>
											<a href="javascript:;" onClick="deliv_allin_none('<?=$list_cnt?>');" class="btn_yy">몰아받기</a>
											<?php
											//alert('죄송합니다.\n배송 일정에 다른 주문/배송건이 존재 하여 몰아받기를 바로 이용하실 수 없습니다.\n1대1 문의를 통해 접수해 주세요.');location.href='/html/dh_board/lists/withcons07/?myqna=Y'
										}
										else{
											?>
											<a href="javascript:;" onClick="deliv_allin('<?=$list_cnt?>')" class="btn_yy">몰아받기</a>
											<?php
										}
										?>
									</td>

								</tr>
								<?php
								}
								$old_trade = $lt->trade_code;
							}
						}
						else{
						?>
						<tr>
							<td colspan="4">변경 가능한 주문 내역이 없습니다.</td>
						</tr>
						<?php
						}
						?>


						<?php
						/*
						<tr>
							<td>정기배송</td>
							<td>이유식 중기 8팩</td>
							<td><select name="" class="reg_sel">
									<option value="">3/14(수) 영양식단 중기 3회차 [변경가능]</option>
									<option value="">3/14(수) 영양식단 중기 3회차 [배송완료]</option>
									<option value="">3/14(수) 영양식단 중기 3회차 [배송준비중]</option>
								</select></td>
							<td><a href="" class="btn_yy">
								몰아받기
								</a></td>
						</tr>
						*/
						?>
					</table>
					<script type="text/javascript">
						$(function(){
							console.log($(".reg_sel option").index());
						});
					</script>
				</div>
			</div>
			<!-- // 05 배송 몰아받기-->
		</div>
	</div>

	<div class="layer_pop01" style="display:none;">
		<!-- <div class="layer_pop_inner">
			<h1>
				배송 몰아받기
			</h1>
			<div class="bg">
				<p class="bu03">
					몇 회차부터 남은 식단을 한 번에 몰아받기 입니다.<br>
					몇 회차에 받으실 수량을 몇일 (뭐)에 모두 보내드립니다.<br>
					몇일 (뭐) 식단으로 남은 수량을 보내드리오니<br>
					이점 꼭 확인해 주세요
				</p>

				<div class="ac bd">
					<a href="javascript:;" class="btn_big" onclick="cancel('')">주문취소</a>
					<a href="javascript:;" class="btn_big" onclick='closeMenuView();'>닫기</a>
				</div>
			</div>
			<a href="javascript:;" class="btn_close" onclick='closeMenuView();'></a>
		</div> -->
	</div>

</div>
<!--END Container-->

<? include('../include/footer.php') ?>
