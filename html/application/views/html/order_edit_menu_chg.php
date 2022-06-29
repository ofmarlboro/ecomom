<!doctype html>
<html lang="ko">
<head>
	<title>메뉴변경 - 에코맘 산골이유식</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">
	<meta name="viewport" content="width=1300">

	<meta name="Author" content="Design hub">
	<meta name="Author" content="Wookju Choi">
	<meta name="Author" content="에코맘의 산골이유식">
	<meta name="designer" content="Miso Choi">

	<link type="text/css" rel="stylesheet" href="//cdn.rawgit.com/hiun/NanumSquare/master/nanumsquare.css" />
	<link type="text/css" rel="stylesheet" href="/css/@default.css?t=<?php echo time(); ?>" />
	<script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="/js/jquery.easing.min.js"></script>
	<script type="text/javascript" src="/js/placeholders.min.js"></script>
	<script type="text/javascript" src="/js/imagesloaded.pkgd.min.js"></script>
	<script type="text/javascript" src="/js/setting.js?t=<?php echo time(); ?>"></script>
	<script type="text/javascript" src="/js/common.js?t=<?php echo time(); ?>"></script>
	<script type="text/javascript" src="/_data/js/form.js"></script>
	<script type="text/javascript">
		$(function(){
			$(".layer_pop_inner").css('top','0');
			$('html').css('overflow-x','hidden');

			$(".allergy").click(function(){	//알러지 체크 워메 징한그 징글징글하구먼

				if($(this).prop('checked')){
					$(this).addClass("on");
				}
				else{
					$(this).removeClass("on");
				}

				var alg1 = $("input[name='allergy13']:checked").val() || '';
				var alg2 = $("input[name='allergy12']:checked").val() || '';
				var alg3 = $("input[name='allergy1']:checked").val() || '';
				var alg4 = $("input[name='allergy2']:checked").val() || '';
				var alg5 = $("input[name='allergy6']:checked").val() || '';

				$.ajax({
					url:"<?=cdir()?>/dh_order/ajax_allergy/?alg1="+alg1+"&alg2="+alg2+"&alg3="+alg3+"&alg4="+alg4+"&alg5="+alg5+"&time=<?=time()?>",
					type:"GET",
					dataType:"json",
					cache:false,
					error:function(xhr){
						console.log(xhr.responseText);
					},
					success:function(data){
						console.log(data);
						if(data == ""){
							$(".menuchg").removeClass("on");
							$(".vol-down").css("visibility",'hidden');
							$(".vol-up").css("visibility",'hidden');
						}
						else{
							if($(this).prop('checked')){
								for(d=0;d<data.length;d++){
									$(".menuchg").each(function(){
										var allergy = $(this).data('allergy').split("^");
										for(i=0;i<allergy.length;i++){
											$(".vol-down").css("visibility",'visible');
											$(".vol-up").css("visibility",'visible');
											if(data[d] == allergy[i]){
												$(this).addClass('on');
												break;
											}
										}
									});
								}
							}
							else{
								$(".menuchg").removeClass("on");
								for(d=0;d<data.length;d++){
									$(".menuchg").each(function(){
										var allergy = $(this).data('allergy').split("^");
										for(i=0;i<allergy.length;i++){
											$(".vol-down").css("visibility",'visible');
											$(".vol-up").css("visibility",'visible');
											if(data[d] == allergy[i]){
												$(this).addClass('on');
												break;
											}
										}
									});
								}
							}
						}
					}
					,complete:function(){
						order_confirm = true;

						$(".menuchg").each(function(){
							if($(this).hasClass("on") === false){
								order_confirm = false;
								return false;
							}
						});

						if(order_confirm){
							alert('알레르기 대체메뉴가 더 이상 없습니다<br>낱개주문을 이용하세요');
						}
					}
				});
			});
		});

		function cnt_change(mode, no){	//상품별 갯수 조정
			var cnt = $("input[name='food_cnt"+no+"']").val();
			var max = $("input[name='stand_cnt']").val();
			var cng = $("input[name='chang_cnt']").val();

			$cnt = $("input[name='food_cnt"+no+"']");


			if(mode == 'd'){
				if($cnt.parents(".cart-prod-quick").siblings("h3.menuchg").hasClass("on") === true){
					if(parseInt(cnt) > 0){
						$("input[name='food_cnt"+no+"']").val(parseInt(cnt)-1);
						$("input[name='chang_cnt']").val(parseInt(cng)-1);
					}
					else{
						alert("이미 제외된 식단입니다.");
					}
				}
				else{
					if(cnt > 1){
						$("input[name='food_cnt"+no+"']").val(parseInt(cnt)-1);
						$("input[name='chang_cnt']").val(parseInt(cng)-1);
					}
					else{
						alert("알레르기 해당 제품이 아닌 이유식은 제외하실 수 없습니다.");
					}
				}
			}

			if(mode == 'u'){
				if(parseInt(cng) < parseInt(max)){
					if(cnt < 2){
						$("input[name='food_cnt"+no+"']").val(parseInt(cnt)+1);
						$("input[name='chang_cnt']").val(parseInt(cng)+1);
					}
					else{
						alert("알레르기 대체메뉴 주문수량은 각 메뉴당 최대 2개까지만 주문가능합니다");
					}
				}
				else{
					alert("1회 전체 배송갯수를 초과 할 수 없습니다.");
				}
			}
		}

		function send_form(){	//폼 전송
			var frm = document.menu_cnt_chg;

			if(frm.stand_cnt.value != frm.chang_cnt.value){
				alert("배송일자의 전체 배송갯수가 맞지 않습니다. 갯수를 확인해 주세요.");
				return;
			}

			frm.submit();

		}
	</script>
</head>
<body>
	<div id="wrap">
		<div class="popup01">
			<form method="post" name="menu_cnt_chg" id="menu_cnt_chg">
			<div class="popup_inner">
				<h1>
					<span class="btn_yy" style="margin-right:10px">메뉴변경</span><?=date("m/d",strtotime($row->deliv_date))?>(<?=numberToWeekname($row->deliv_date)?>) 배송 식단 변경

					<input type="text" name="chang_cnt" value="<?=$sum_foods->total?>" style="width:20px;border:none;" readonly> /
					<input type="text" name="stand_cnt" value="<?=$sum_foods->total?>" style="width:20px;border:none;" readonly>
				</h1>
				<div class="bg clearfix">
					<span>알레르기 체크</span>
					<ul class="alrg_list clearfix">
						<li>
							<input type="checkbox" id="alrg13" value="13" class="allergy" name="allergy13">
							<label for="alrg13">소고기</label>
						</li>
						<li>
							<input type="checkbox" id="alrg12" value="12" class="allergy" name="allergy12">
							<label for="alrg12">닭고기</label>
						</li>
						<li>
							<input type="checkbox" id="alrg1" value="1" class="allergy" name="allergy1">
							<label for="alrg1">달걀</label>
						</li>
						<li>
							<input type="checkbox" id="alrg2" value="2" class="allergy" name="allergy2">
							<label for="alrg2">우유</label>
						</li>
						<li>
							<input type="checkbox" id="alrg6" value="6" class="allergy" name="allergy6">
							<label for="alrg6">콩</label>
						</li>
					</ul>
					<div class="bd">
					</div>
					<ul class="cart_menu clearfix">
						<?php
						if($foods_list){
							$list_cnt = 0;
							foreach($foods_list as $fl){
								$list_cnt++;
							?>
							<input type="hidden" name="idxs[]" value="<?=$fl->dp_idx?>">
							<li>
								<h3 class="menuchg" data-allergy="<?=$fl->allergys?>"><?=$fl->name?></h3>
								<div class="cart-prod-quick">
									<div class="cart-vol">
										<button type="button" class="plain vol-down" onclick="cnt_change('d','<?=$fl->dp_idx?>')" style="visibility:hidden;">감소</button>
										<input type="text" class="vol-num" value="<?=$fl->prod_cnt?>" name="food_cnt<?=$fl->dp_idx?>" readonly>
										<button type="button" class="plain vol-up" onclick="cnt_change('u','<?=$fl->dp_idx?>')" style="visibility:hidden;">추가</button>
									</div>
								</div>
							</li>
							<?php
							}
						}
						?>
					</ul>
					<div class="ac bd">
						<a href="javascript:;" class="btn_big" onclick="send_form()">변경</a>
						<a href="javascript:;" class="btn_big" onclick='self.close()'>취소</a>
					</div>
				</div>
				<a href="javascript:;" class="btn_close" onclick='self.close()'><span style="display:none;">X</span></a>
			</div>
			</form>
		</div>
	</div>
</body>
</html>




							<?php
							/*
							<li>
								<h3>
									c62.사과양배추옹근죽
								</h3>
								<div class="cart-prod-quick">
									<div class="cart-vol">
										<button type="button" class="plain vol-down">감소</button>
										<input type="text" class="vol-num" value="1">
										<button type="button" class="plain vol-up">추가</button>
									</div>
								</div>
							</li>
							<li>
								<h3>
									c62.사과양배추옹근죽
								</h3>
								<div class="cart-prod-quick">
									<div class="cart-vol">
										<button type="button" class="plain vol-down">감소</button>
										<input type="text" class="vol-num" value="1">
										<button type="button" class="plain vol-up">추가</button>
									</div>
								</div>
							</li>
							<li>
								<h3>
									c62.사과양배추옹근죽
								</h3>
								<div class="cart-prod-quick">
									<div class="cart-vol">
										<button type="button" class="plain vol-down">감소</button>
										<input type="text" class="vol-num" value="1">
										<button type="button" class="plain vol-up">추가</button>
									</div>
								</div>
							</li>
							<li>
								<h3>
									c62.사과양배추옹근죽
								</h3>
								<div class="cart-prod-quick">
									<div class="cart-vol">
										<button type="button" class="plain vol-down">감소</button>
										<input type="text" class="vol-num" value="1">
										<button type="button" class="plain vol-up">추가</button>
									</div>
								</div>
							</li>
							<li>
								<h3>
									c62.사과양배추옹근죽
								</h3>
								<div class="cart-prod-quick">
									<div class="cart-vol">
										<button type="button" class="plain vol-down">감소</button>
										<input type="text" class="vol-num" value="1">
										<button type="button" class="plain vol-up">추가</button>
									</div>
								</div>
							</li>
							<li>
								<h3>
									c62.사과양배추옹근죽
								</h3>
								<div class="cart-prod-quick">
									<div class="cart-vol">
										<button type="button" class="plain vol-down">감소</button>
										<input type="text" class="vol-num" value="1">
										<button type="button" class="plain vol-up">추가</button>
									</div>
								</div>
							</li>
							<li>
								<h3>
									c62.사과양배추옹근죽
								</h3>
								<div class="cart-prod-quick">
									<div class="cart-vol">
										<button type="button" class="plain vol-down">감소</button>
										<input type="text" class="vol-num" value="1">
										<button type="button" class="plain vol-up">추가</button>
									</div>
								</div>
							</li>
							<li>
								<h3>
									c62.사과양배추옹근죽
								</h3>
								<div class="cart-prod-quick">
									<div class="cart-vol">
										<button type="button" class="plain vol-down">감소</button>
										<input type="text" class="vol-num" value="1">
										<button type="button" class="plain vol-up">추가</button>
									</div>
								</div>
							</li>
							<li>
								<h3>
									c62.사과양배추옹근죽
								</h3>
								<div class="cart-prod-quick">
									<div class="cart-vol">
										<button type="button" class="plain vol-down">감소</button>
										<input type="text" class="vol-num" value="1">
										<button type="button" class="plain vol-up">추가</button>
									</div>
								</div>
							</li>
							<li>
								<h3>
									c62.사과양배추옹근죽
								</h3>
								<div class="cart-prod-quick">
									<div class="cart-vol">
										<button type="button" class="plain vol-down">감소</button>
										<input type="text" class="vol-num" value="1">
										<button type="button" class="plain vol-up">추가</button>
									</div>
								</div>
							</li>
							<li>
								<h3>
									c62.사과양배추옹근죽
								</h3>
								<div class="cart-prod-quick">
									<div class="cart-vol">
										<button type="button" class="plain vol-down">감소</button>
										<input type="text" class="vol-num" value="1">
										<button type="button" class="plain vol-up">추가</button>
									</div>
								</div>
							</li>
							<li>
								<h3>
									c62.사과양배추옹근죽
								</h3>
								<div class="cart-prod-quick">
									<div class="cart-vol">
										<button type="button" class="plain vol-down">감소</button>
										<input type="text" class="vol-num" value="1">
										<button type="button" class="plain vol-up">추가</button>
									</div>
								</div>
							</li>
							*/
							?>