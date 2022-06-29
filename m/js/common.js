	jQuery(document).ready(function($){







	});


//	function menuPop(){
//		window.open('menu_popup_mobile.php', 'menu', 'width=900, height=800, scrollbars=yes');
//	}

$("#gnb_wrap .blind").on('click',function(){
	$("#gnb_wrap").removeClass("opened").find(".blind").fadeOut('fast', function(){
			$(".gnb_tab li").removeClass("on").eq(0).addClass("on");
			$(".gnb_mode").hide();
			$("#gnb_menu").show();
			$("#nav_box .scroll").scrollTop(0);
		});
})
	//GNB
	function openGnb(){
		$("#gnb_wrap").addClass("opened").find(".blind").fadeIn('fast');
	}
	function closeGnb(){
		$("#gnb_wrap").removeClass("opened").find(".blind").fadeOut('fast', function(){
			$(".gnb_tab li").removeClass("on").eq(0).addClass("on");
			$(".gnb_mode").hide();
			$("#gnb_menu").show();
			$("#nav_box .scroll").scrollTop(0);
		});
	}
	function gnbMode(obj,target){
		$(".gnb_mode").hide();
		$(obj).show();
		$(target).closest("li").addClass("on").siblings("li").removeClass("on");
	}
	//페이지 맨 위로 보내기
	function goPageTop(){
		$("html, body").stop().animate({scrollTop:0}, 1200, 'easeOutQuint');
	}

	function calc_addprod(){
		add_tt_p = 0;
		$("td.total_price").each(function(){
			add_tt_p += parseInt($(this).attr('addprod_totalp'));
		});
		$("input[name='add_prod_update_price']").val(add_tt_p);
		$(".add_prod_total").html(addComma(add_tt_p)+" 원");


		var prod_price = $("input[name='add_recom_price']").val();
		var addp_price = $("input[name='add_prod_update_price']").val();

		console.log(prod_price);
		console.log(addp_price);

		var all_price = parseInt(prod_price) + parseInt(addp_price);

		console.log(all_price);

		$(".all_price").html( addComma(all_price)+" 원" );
	}

	function add_gansik(idx){
		var deliv_start_date = $("input[name='recom_default_deliv_start_day']").val() || '';
		$.ajax({
			type:"GET"
			,url:"/m/html/dh/dh_ajax/?ajax=1&mode=get_add_prod&deliv_start_date="+encodeURIComponent(deliv_start_date)+"&idx="+idx
			,dataType:"json"
			,error:function(xhr){console.log(xhr.responseText);}
			,success:function(data){

				console.log(data);

				var html = "";
				html += '<tr>';
				html += '	<th class="al">'+data.name+'</th>';
				html += '	<td><span class="cart-vol">';
				html += '		<input type="hidden" name="goods_idx[]" class="prd_idx" value="'+data.idx+'">';
				html += '		<input type="hidden" name="goods_price[]" class="prd_price" id="goods_price_'+data.idx+'" value="'+data.shop_price+'">';
				html += '		<input type="hidden" name="goods_origin_price[]" class="prd_origin_price" value="'+data.old_price+'">';
				html += '		<input type="hidden" name="goods_name[]" class="goods_name" value="'+data.name+'">';
				html += '		<button type="button" class="vol-down" onclick="add_goods_minus('+data.idx+')">감소</button>';
				html += '		<input type="text" value="1" name="goods_cnt[]" class="prd_cnt" readonly id="prd_cnt_'+data.idx+'">';
				html += '		<button type="button" class="vol-up" onclick="add_goods_plus('+data.idx+')">추가</button>';
				html += '		</span></td>';
				html += '	<td class="total_price" id="total_price_'+data.idx+'" addprod_totalp="'+data.shop_price+'">'+addComma(data.shop_price)+'</td>';
				html += '	<td><a href="javascript:;" class="cart_del"><img src="/m/image/sub/del.png" alt="" class="del remove_goods"></a></td>';
				html += '</tr>';

				if($(".added_prod tr").index() < 0)
				{
					$(".added_prod").append(html);
				}
				else{

					var it_is = "";

					$(".prd_idx").each(function(index, item){
						if($(item).val() == data.idx){
							it_is = "it";
						}
					});

					if(it_is != "it"){
						$(".added_prod").append(html);
					}
					else{
						alert("이미 등록된 상품입니다. 수량을 조정해 주세요.");
					}

				}

			}
			,complete:function(data){
				$(".remove_goods").click(function(){
					$(this).parents('tr').remove();
					calc_addprod();
				});
				calc_addprod();
			}
		});
	}

	function add_goods_minus(idx){
		var cnt = $('#prd_cnt_'+idx).val();
		var prd_price = $('#goods_price_'+idx).val();

		if(cnt < 2){
			alert("최소 구매수량은 1개 입니다.");
			return;
		}
		else{
			update_cnt = parseInt(cnt)-1;
			update_price = parseInt(prd_price)*update_cnt;
			$('#prd_cnt_'+idx).val(update_cnt);
			$('#total_price_'+idx).text(addComma(update_price));

			$('#total_price_'+idx).attr('addprod_totalp',update_price);

			calc_addprod();
		}
	}

	function add_goods_plus(idx){
		var cnt = $('#prd_cnt_'+idx).val();
		var prd_price = $('#goods_price_'+idx).val();

		update_cnt = parseInt(cnt)+1;
		update_price = parseInt(prd_price)*update_cnt;
		$('#prd_cnt_'+idx).val(update_cnt);
		$('#total_price_'+idx).text(addComma(update_price));

		$('#total_price_'+idx).attr('addprod_totalp',update_price);

		calc_addprod();
	}

	function Get_holidays(url){	//배송휴일 정보 가져오기
		var result = [];

		console.log(url);

		$.ajax({
			type:"GET"
			,url:url
			,dataType:"json"
			,async: false
			,success:function(data){
				result = data;
			}
		});

		return result;
	}

	//모바일 식단표
	function menuPop_mobile(recom_idx){
		window.open('/m/html/dh/menu_popup?recom_idx='+recom_idx, 'menu', '');
	}





// 스크롤인덱스 셋팅
function setScrollIndex() {
	setScrollEvent();
	setScrollNavPos();
	setScrollPos();
	setScrollNavOn($(window).scrollTop());

	$(window).scroll(function(){
		var pos = parseInt($(window).scrollTop());
		var startPos = $($(".scroll_nav li:first-child a").attr("href")).offset().top;

		if (pos >= startPos)
		{
			setScrollNavOn(pos);
		}
	});

	//indicator scroll
	$(".go_arrow a").on("click", function(){
		moveY($(this).attr("href"));
	});
}


sectionPos = []; //스크롤인덱스 위치 저장 배열

//스크롤 인덱스 위치
function setScrollNavPos(){
	var $quick = $(".scroll_nav");
	var $quick_item = $(".scroll_nav li").not(".top_idx");

	var idx_h = 36;
	var idx_margin = 5;

	var total_h = 0;

	for (var i=0;i<$quick_item.length;i++)
	{
		total_h += idx_h+idx_margin;
	}

//	$quick.css({"marginTop":"-"+total_h/2+"px"});

}
//스크롤 이벤트 세팅
function setScrollEvent(){
	$("a[href^='#']").on("click", function(){
		if ($(this).attr("href")!="#" && !$(this).closest("ul").hasClass("sub_tab"))
		{
			moveY($(this).attr("href"));
			return false;
		}
	});
}
//스크롤 계산 및 이동
function moveY(obj){
	$obj = $(obj);
	var pos = $obj.offset().top;

	$("html, body").stop().animate({scrollTop:pos - 50}, 500);
}
//퀵메뉴가 링크하고있는 idx 스크롤 값 저장.
function setScrollPos(){
	var $quick = $(".scroll_nav li").not(".top_idx");

	for (var i=0; i<$quick.length; i++)
	{
		var direction = $quick.eq(i).find("a").attr("href");
		sectionPos[i] = parseInt($(direction).offset().top - 120);
	}
	sectionPos[sectionPos.length] = $(document).height();

}

function  setScrollNavOn(pos){
   //console.log(pos);
   for (var i=0; i<sectionPos.length-1; i++)
   {
      if (pos >= sectionPos[i] && pos < sectionPos[i]+1000)
      {
         $(".scroll_nav li").removeClass("on");
         $(".scroll_nav li").eq(i).addClass("on");
      }
   }
}
$(window).scroll(function(){

	if ($(window).scrollTop() > 100)

	{$(".scroll_nav_wrap").addClass("fix");
		$(".histr_ct").addClass("layout01");
	}
	else {
		 $(".scroll_nav_wrap").removeClass("fix");
		 $(".histr_ct").removeClass("layout01");

	}
});





