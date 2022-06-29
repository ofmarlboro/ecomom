<?php
$food_config = array();
$food_config['delivery_week_day_count'] = array(7, 6, 4);
$food_config['delivery_week_type'] = array();
$food_config['delivery_week_type'][1] = '1:목';
$food_config['delivery_week_type'][2] = '2:수,토';
$food_config['delivery_week_type'][3] = '2:화,금';
$food_config['delivery_week_type'][4] = '3:화,목,토';
$food_config['delivery_week_count'] = array(1, 2, 3, 4);
$food_config['delivery_sun'] = array(4=>'목',5=>'금',6=>'토');

//$delivery_price = 0;
//$delivery_type_price = 0;
//$delivery_week_price = 0;
//$delivery_dc_price = 0;
//$delivery_total_price = 0;
//$delivery_week = 0;

$arr_delivery_week_day = explode(':', $delivery_week_day_count);
$delivery_week_day = $arr_delivery_week_day[0];
$arr_delivery_week_day_end = explode('@',$arr_delivery_week_day[1]);
$arr_delivery_week_type = explode(":",$delivery_week_type);
//$arr_delivery_week_type_prices = explode(":",$delivery_week_type_prices);
?>

<script type="text/javascript">
	$(function(){
		$(".tooltip > button").mouseover(function(){
			var name = $(this).attr('name');
			console.log(name);
			$(".tooltip ."+name).show();
		})
		.mouseout(function(){
			var name = $(this).attr('name');
			$(".tooltip ."+name).hide();
		});
	});
</script>

<table class="order_opt">
	<tbody>
		<tr>
			<th>1주 이유식수량</th>
			<td>
				<div class="selbox">
					<?php
					if($delivery_week_day and $arr_delivery_week_day[1]){
						?>
						<button type="button"><span class="week_day_count_span"><?=$delivery_week_day?>일분*하루<?=$arr_delivery_week_day_end[1]?>팩(<?=$arr_delivery_week_day_end[0]?>팩)</span></button>
						<?php
					}
					?>
					<ul>
						<li>
							<input type="radio" name="delivery_week_day_count" value="<?php echo $food_info['val']; ?>:<?php echo $food_info['count']; ?>@<?php echo $food_info['pcount']; ?>" checked>
						</li>
					</ul>
				</div>
			</td>
		</tr>
		<tr>
			<th>
				총 배송기간
			</th>
			<td>
				<div class="selbox">
					<?php
					if($delivery_week_count){
						?>
						<button type="button">
							<span>
								<em><?=$delivery_week_count?>주</em>
								<strong> (<?=number_format($arr_delivery_week_day_end[0] * $delivery_week_count)?>팩)</strong>
							</span>
						</button>
						<?php
					}
					?>

					<ul>
						<?php
						foreach($food_info['delivery_week_count'] as $info){
							?>
							<li>
								<input type="radio" name="delivery_week_count" id="deliv_term<?=$i?>" value="<?php echo $info['val']; ?>"
								<?php if (($delivery_week_count && $delivery_week_count==$info['val'])/* || (!$delivery_week_count && $i==$len)*/) { echo "checked"; } ?>>
							</li>
							<?php
						}
						?>
					</ul>
				</div>
			</td>
		</tr>
		<tr>
			<th>
				배송요일
				<div class="tooltip">
					<button type="button" class="plain btn" title="설명보기" name="deliv_adr02"><img src="/image/sub/icon_qmark.png" alt="설명보기"></button>
					<div class="txt deliv_adr02" style="display:none;position:absolute">
						<p class="tit">목요일 주 1회 배송일 변경 안내</p>
						<div class="desc">
							목요일 주 1회 주문 시 배송일은 목요일으로만 변경 가능합니다.
						</div>
					</div>
				</div>
			</th>
			<td>
				<div class="selbox">
					<?php
					if($arr_delivery_week_type[1] and $arr_delivery_week_type[0]){
						?>
						<button type="button" onclick="toggleSelBox(this, event);">
							<span class="week_type_span">
								<?=$arr_delivery_week_type[1]?>(주<?=$arr_delivery_week_type[0]?>회)
								<?php
								$arrno = $arr_delivery_week_type[0] == 3 ? 4 : $arr_delivery_week_type[0];
								?>
							</span>
						</button>
						<?php
					}
					else{
						?>
						<button type="button" onclick="toggleSelBox(this, event);">
							<span class="week_type_span">
								받으실 요일을 선택하세요.
							</span>
						</button>
						<?php
					}
					?>

					<ul>
						<?php
						$search_delivery_week_type = '';
						$i = 0;
						foreach($food_info['delivery_week_type'] as $key => $info){
							if($key == 1) continue;
							if(!isset($info['use'])) continue;
							$arr_delivery_week_type = explode(':', $info['val']);
							//if (($delivery_week_type && $delivery_week_type==$key) || (!$delivery_week_type && $i==0)) $delivery_type_price = $info['price'] ? $info['price'] : 0;
							if (($delivery_week_type && $delivery_week_type==$info['val']) || (!$delivery_week_type && $i==0)) $search_delivery_week_type = $info['val'];
							?>
							<li>
								<input type="radio" name="delivery_week_type" data-delivery_week_type_key="<?=$key?>" id="day_week<?=$i?>" value="<?php echo $info['val']; ?>" msg="받으실 요일을"
								<?php if (($delivery_week_type && $delivery_week_type==$info['val'])/* || (!$delivery_week_type && $i==0)*/) { echo "checked"; } ?>>

								<?php if (($delivery_week_type && $delivery_week_type==$info['val'])/*  || (!$delivery_week_type && $i==0) */) { ?>
								<input type="hidden" name="delivery_week_type_key" value="<?=$key?>">
								<?php } ?>

								<label for="day_week<?=$i?>">
									<?=$arr_delivery_week_type[1]?>(주<?=$arr_delivery_week_type[0]?>회)
								</label>
							</li>
							<?php
							$i++;
						}
						?>
					</ul>
				</div>
			</td>
		</tr>
		<tr <?if($delivery_week_day != 292513){?>style="display:none;"<?}?>>
			<th>일요일분<br>메뉴선택
				<div class="tooltip">
					<button type="button" class="plain btn" title="설명보기" name="deliv_sun"><img src="/image/sub/icon_qmark.png" alt="설명보기"></button>
					<div class="txt deliv_sun" style="display:none;position:absolute">
						<p class="tit">일요일분 배송요일 안내</p>
						<div class="desc">
							일요일에 먹을 이유식 팩를 어느 메뉴로 받을 지 정할 수 있습니다.<br>
							ex) 금요일식단팩 금요일에 받기 : 금요일에 나오는 이유식 메뉴를 받습니다.
						</div>
					</div>
				</div>
			</th>
			<td><div class="selbox">
					<button type="button" onclick="toggleSelBox(this, event);"><span>
						<?php
						if($delivery_sun_type){
						?>
						<em><?=$food_config['delivery_sun'][$delivery_sun_type]?>요일식단</em> 으로 <?=($delivery_week_type_key == 2)?"금":"토";?>요일에 받기
						<?php
						}
						else{
						?>
						일요일에 먹을 이유식을 선택해 주세요.
						<?php
						}
						?>
					</span></button>
					<ul>
						<?php
						$i=0;
						foreach($food_config['delivery_sun'] as $key => $val){
						?>
						<li>
							<input type="radio" name="delivery_sun_type" id="menu_sunday<?=$i?>" disabled value="<?php echo $key; ?>" <?php if($key == $delivery_sun_type || (!$delivery_sun_type && $i==0)) { echo "checked"; }?>>
							<label for="menu_sunday<?=$i?>"><em><?=$val?>요일식단</em> 으로 <?=($delivery_week_type_key == 2)?"금":"토";?>요일에 받기</label>
						</li>
						<?php
							$i++;
						}
						?>
					</ul>
				</div>
			</td>
		</tr>
		<tr>
			<th>배송지
				<div class="tooltip">
					<button type="button" class="plain btn" title="설명보기" name="deliv_adr"><img src="/image/sub/icon_qmark.png" alt="설명보기"></button>
					<div class="txt deliv_adr" style="display:none;position:absolute">
						<p class="tit">배송지 변경 안내</p>
						<div class="desc">
							배송지는 마이페이지 > 배송지관리에서 관리 가능합니다.
						</div>
					</div>
				</div>
			</th>
			<td><div class="selbox">
					<button type="button" <?if($this->session->userdata('USERID')){?> onclick="toggleSelBox(this, event);" <?}?>><span class="d_add_val"><?if($deliv_addr){ echo $member_addr_key_arr[$deliv_addr].$member_addr_arr[$deliv_addr]; }else{ if($this->session->userdata('USERID')){ echo "배송지를 선택하세요."; }else{ echo "로그인 후 주문이 가능합니다."; } }?></span></button>
					<?php
					if($member_addr_arr){
						?>
						<ul>
							<?php
							foreach($member_addr_arr as $key=>$maa){
								if($key != 'self'){
									?>
									<li><input type="radio" name="deliv_addr" id="deliv_addr_<?=$key?>" value="<?=$key?>" <?if($deliv_addr == $key){?>checked<?}?>><label for="deliv_addr_<?=$key?>"><?=$member_addr_key_arr[$key]?><?=$maa?></label></li>
									<?php
								}
							}
							?>
						</ul>
						<?php
					}
					?>
				</div>
			</td>
		</tr>
		<?php
		if($deliv_addr == "self"){
		?>
		<tr>
			<th>배송지 입력</th>
			<td>
				<div class="new_addr">
					<p>
						<label for="address1" class="hidden">신규주소</label>
						<input type="hidden" name="zipcode" id="zipcode1" value="<?=$zipcode?>">
						<input type="text" name="addr1" id="address1" readonly value="<?=$addr1?>" msg="배송지를">
						<button type="button" class="plain" title="새창" onclick="sample6_execDaumPostcode()">우편번호 선택</button>
					</p>
					<p class="mt5"><label for="address2" class="hidden">신규상세주소</label>
						<input type="text" name="addr2" id="address2" class="full" value="<?=$addr2?>" msg="배송지를">
					</p>
				</div>
			</td>
		</tr>
		<?php
		}
		?>
		<tr>
			<th>첫 배송일</th>
			<td><div class="sel_date">
					<em><?=$default_deliv_start_day?></em>
					<button type="button" class="plain" onclick="$('#start_delivery_cal').toggle();">첫배송일 변경</button>
				</div>
			</td>
		</tr>
	</tbody>
</table>