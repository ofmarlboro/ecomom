<?
  $PageName = "K01";
  $SubName = "K0101";
  $PageTitle = "";
  include('../include/head.php');

?>

<!--Container-->

<script>
//우측 주문 항목 선택버튼 이벤트
function toggleSelBox(btn, ev){
	$(".selbox").not($(btn).closest(".selbox")).removeClass("open");
	$(btn).closest(".selbox").toggleClass("open");
	
	$("body").on("click.offSel", function(e){
		if (!$(e.target).closest(".selbox").length)
		{
			$(".selbox").removeClass("open");
			$("body").off("click.offSel");
		}
	});
}


</script>

	
	
					<div class="order_opt">
						
									<div class="selbox">
										<button type="button" onClick="toggleSelBox(this, event);"><span class="week_day_count_span">ffff</span></button>
										
										<ul>
											<li>
												<input type="radio" id="cnt_week0">
												<label for="cnt_week0">ddd</label>
											</li>
											<li>
												<input type="radio" id="cnt_week1">
												<label for="cnt_week1">sss</label>
											</li>
											<li>
												<input type="radio" id="cnt_week2">
												<label for="cnt_week2">sss</label>
											</li>
										</ul>
									</div>
								
					</div>
				
				
				
			
		
	

<? include('../include/footer.php') ?>
