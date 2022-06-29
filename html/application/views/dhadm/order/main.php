<div class="dashboard">


	<div class="hj02 clearfix">
		<div class="fl">
			<h1>
				관리자 메모
			</h1>
			<ul class="list01">
				<?php
				if($memo_list){
					foreach($memo_list as $ml){
					?>
				<li>
					<span class="date"><?=date("Y-m-d H:i",strtotime($ml->wdate))?></span> <?=$ml->memo?>
					<a href="javascript:memo_del('<?=$ml->idx?>');" class="btn_del">삭제</a>
				</li>
					<?php
					}
				}
				?>
			</ul>
			<div class="form">
				<form method="post" name="memofrm" id="memofrm" onsubmit="return false">
					<input type="hidden" name="mode" value="input">
					<input type="hidden" name="userid" value="<?=$now_login_admin?>">
					<input type="text" name="memo" onkeyup="press_Enter()">
				</form>
				<button type="button" onclick="memo_write()">쓰기</button>
			</div>
		</div>
		<div class="fr">
			<h1>
				금일배송관리
			</h1>
			<ul class="list03">
				<li>
					생산제품목록 엑셀 저장
					<input type="text" name="deliv_date" id="start_date" value="<?=$tomorrow?>">
					<button type="button" onclick="make_frmchk()">다운로드</button>
				</li>
				<li>
					내일 (<?=$tomorrow?> <?=$tomorrow_day_name?>요일) 배송 예약 : <?=number_format($tomorrow_delivery_cnt)?> 건
					<button type="button" onclick="location.href='<?=cdir()?>/order/delivery/m/?sch_date=delivery_day&sch_sdate=<?=$tomorrow?>&sch_edate=<?=$tomorrow?>'">내역 확인</button>
				</li>
				<li>
					지난 배송 (미 완료처리) : <?=number_format($order_complete_please)?> 건
					<!-- <button type="button" onclick="location.href='<?=cdir()?>/order/delivery/m/'">일괄 변경</button> -->
					<?php
					if($order_complete_please > 0){
						?>
						<button type="button" onclick="deliv_complete()">일괄 변경</button>
						<?php
					}
					else{
						?>
						<button type="button" onclick="alert('변경할 배송이 없습니다.')">일괄 변경</button>
						<?php
					}
					?>
				</li>
			</ul>
		</div>
		<hr>
		<div class="fr">
			<h1>
				CS 요청관리
			</h1>
			<ul class="list02">
				<!-- <li>
					<p>주문취소<br>
						미처리</p>
					<strong><a href="/html/order/lists/m?sch_date=trade_day&sch_item=userid&sch_trade_stat=10"><?=number_format($order_cancel_please)?></a></strong><em>건</em>
				</li> -->
				<li>
					<p>1:1 문의<br>
						미처리</p>
					<strong><a href="/html/board/bbs/withcons07/m"><?=number_format($qna_comment_please)?></a></strong><em>건</em>
				</li>
			</ul>
		</div>
	</div>



	<div class="hj02 mt50">
		<h1>
			주문/취소 현황
		</h1>
		<table class="tblTy01">
			<thead>
				<tr>
					<th rowspan="2">구분</th>
					<?php
					$term = count($info_key);
					foreach($info_key as $date=>$dayname){
					?>
					<th colspan="4"><?=date("m월 d일",strtotime($date))?> (<?=$dayname?>)</th>
					<?php
					}
					?>
				</tr>
				<tr>
					<?php
					for($i=0;$i<$term;$i++){
					?>
					<th>건수</th>
					<th>금액</th>
					<th>포인트사용</th>
					<th>쿠폰사용</th>
					<?php
					}
					?>
				</tr>
			</thead>
			<tbody>
				<?php
				$case = array('1'=>"신용카드",'2'=>"무통장입금",'3'=>"계좌이체",'5'=>"포인트",'7'=>'휴대폰결제');

				foreach($case as $k=>$v){
				?>
				<tr>
					<td><?=$v?></td>
					<?php
					$cnt = 0;
					foreach($info_key as $dates=>$name){
						$cnt++;
					?>
					<td class="cnt<?=$cnt?>" val="<?=$info[$dates][$k]['cnt']?>"><?=number_format($info[$dates][$k]['cnt'])?></td>
					<td class="price<?=$cnt?>" val="<?=$info[$dates][$k]['price']?>"><?=number_format($info[$dates][$k]['price'])?></td>
					<td class="use_point<?=$cnt?>" val="<?=$info[$dates][$k]['use_point']?>"><?=number_format($info[$dates][$k]['use_point'])?></td>
					<td class="use_coupon<?=$cnt?>" val="<?=$info[$dates][$k]['use_coupon']?>"><?=number_format($info[$dates][$k]['use_coupon'])?></td>
					<?php
					}
					?>
				</tr>
				<?php
				}
				?>
			</tbody>
			<tfoot>
				<tr>
					<td>합계</td>
					<?php
					for($i=1;$i<=$cnt;$i++){
					?>
					<td class="result_cnt<?=$i?>">-</td>
					<td class="result_price<?=$i?>">-</td>
					<td class="result_use_point<?=$i?>">-</td>
					<td class="result_use_coupon<?=$i?>">-</td>
					<?php
					}
					?>
				</tr>
				<tr>
					<td>주문취소</td>
					<?php
					foreach($info_key as $d=>$v){
					?>
					<td><?=number_format($ccinfo[$d]['cnt'])?></td>
					<td><?=number_format($ccinfo[$d]['price'])?></td>
					<td><?=number_format($ccinfo[$d]['use_point'])?></td>
					<td><?=number_format($ccinfo[$d]['use_coupon'])?></td>
					<?php
					}
					?>
				</tr>
			</tfoot>
		</table>
	</div>
</div>


<script type="text/javascript">

	function make_frmchk(){
		if($("input[name='deliv_date']").val() == ""){
			alert("생산날짜를 입력해 주세요.");
			frm.deliv_date.focus();
			return false;
		}
		location.href="<?=cdir()?>/order/make_excel/?ajax=1&deliv_date="+$("input[name='deliv_date']").val();
	}

	for(i=1;i<=4;i++){	//주문/취소현황 합계값 산출

		total_cnt = 0;
		total_price = 0;
		total_use_point = 0;
		total_use_coupon = 0;

		$(".cnt"+i).each(function(){
			//console.log($(this).html());
			total_cnt += parseInt($(this).attr('val'));
		});

		$(".price"+i).each(function(){
			//console.log($(this).html());
			total_price += parseInt($(this).attr('val'));
		});

		$(".use_point"+i).each(function(){
			//console.log($(this).html());
			total_use_point += parseInt($(this).attr('val'));
		});

		$(".use_coupon"+i).each(function(){
			//console.log($(this).html());
			total_use_coupon += parseInt($(this).attr('val'));
		});

		$(".result_cnt"+i).html(total_cnt);
		$(".result_price"+i).html(number_format(total_price,0));
		$(".result_use_point"+i).html(number_format(total_use_point,0));
		$(".result_use_coupon"+i).html(number_format(total_use_coupon,0));

	}

	function press_Enter(){
		if(event.keyCode==13) {
			memo_write();
		}
	}
	function memo_write(){
		frm = document.memofrm;

		if(frm.memo.value == ""){
			alert("내용을 입력하세요.");
			frm.memo.focus();
			return false;
		}

		frm.submit();
	}

	function memo_del(idx){
		if(confirm("메모를 삭제 하시겠습니까?")){
			frm = document.memodel;
			frm.idx.value = idx;
			frm.submit();
		}
	}

	function deliv_complete(){
		if(confirm("배송중인 주문내역 중 3일이 지난\n배송건을 배송완료로 변경합니다.")){
			location.href="<?=cdir()?>/order/delivery/m/deliv_complete";
		}
	}
</script>

<form method="post" name="memodel" id="memodel">
	<input type="hidden" name="mode" value="del">
	<input type="hidden" name="idx">
</form>