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
	<a href="javascript:;" onclick="window.open('/html/member/point/<?=$row->idx?>/?ajax=1','point_set','width=715, height=615, scroll_bars=yes');" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">포인트내역</a>
	<a href="javascript:;" onclick="window.open('/html/member/coupon/<?=$row->idx?>/?ajax=1','coupon_set','width=715, height=615');" style="border-bottom: 1px solid #fff;display: block;padding: 5px 10px;text-align: center;color: #fff;">쿠폰보내기</a>
</div>