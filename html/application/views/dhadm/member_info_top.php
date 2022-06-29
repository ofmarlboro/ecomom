<script type="text/javascript">
	function show_layer(idx){
		$(".layer_t"+idx).slideToggle();
	}
	$(function(){
		$("html, body").on("click", function(){
			$(".layer_t").hide();
		});
	});
</script>

<h1 class="sobigdick"><a href="javascript:show_layer('<?=$row->idx?>');"><?=$row->name?></a>, <?=$row->userid?>, <?=$row->phone1?>-<?=$row->phone2?>-<?=$row->phone3?></h1>

<div class="layer_t layer_t<?=$row->idx?>" style="display: none;background: #000;border: 1px solid #ddd;border-bottom: 0;position: absolute;top: 30px;left: 112px;z-index:999">
	<!-- <a href="#" style="border-bottom: 1px solid #ddd;display: block;padding: 5px 10px;text-align: center;">아이디로 검색</a> -->
	<a href="javascript:;" onclick="window.open('/html/member/user/m/edit/<?=$row->idx?>/','','');" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">회원정보변경</a>
	<a href="javascript:;" onclick="window.open('/html/member/user/m/order/<?=$row->idx?>/','','');" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">구매내역보기</a>
	<a href="javascript:;" onclick="window.open('/html/member/point/<?=$row->idx?>/?ajax=1','point_set','width=715, height=615, scroll_bars=yes');" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">적립금내역</a>
	<a href="javascript:;" onclick="window.open('/html/member/deposit/<?=$row->idx?>/?ajax=1','point_set','width=715, height=615, scroll_bars=yes');" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">예치금내역</a>
	<a href="javascript:;" onclick="window.open('/html/member/coupon/<?=$row->idx?>/?ajax=1','coupon_set','width=715, height=615');" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">쿠폰보내기</a>
</div>

<table class="adm-tab mt20">
	<tr>
		<th <?if($mode == "edit"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/edit/<?=$row->idx?>/<?=$query_string.$param?>">회원 정보 관리</a></th>
		<th <?if($mode == "order"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/order/<?=$row->idx?>/<?=$query_string.$param?>">주문 내역</a></th>
		<th <?if($mode == "qna"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/qna/<?=$row->idx?>/<?=$query_string.$param?>">1:1 문의</a></th>
		<th <?if($mode == "point"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/point/<?=$row->idx?>/<?=$query_string.$param?>">적립금 내역</a></th>
		<th <?if($mode == "deposit"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/deposit/<?=$row->idx?>/<?=$query_string.$param?>">예치금 내역</a></th>
		<th <?if($mode == "coupon"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/coupon/<?=$row->idx?>/<?=$query_string.$param?>">쿠폰 내역</a></th>
		<th <?if($mode == "deliv_place"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/deliv_place/<?=$row->idx?>/<?=$query_string.$param?>">배송지 관리</a></th>
		<th <?if($mode == "admin_memo"){?>class="on"<?}?>><a href="<?=cdir()?>/member/user/m/admin_memo/<?=$row->idx?>/<?=$query_string.$param?>">관리자 메모</a></th>
	</tr>
</table>