					<!-- 퍼블리싱 시작 -->
					<script type="text/javascript">
						jQuery(document).ready(function($){
							setScrollIndex();	//스크롤 인덱스 셋팅
						});
						$(window).scroll(function(){
							if ($(window).scrollTop() > 1000){
								$(".scroll_nav").addClass("fix");
							}
							else {
								$(".scroll_nav").removeClass("fix");
							}
						});
					</script>

					<div class="ac">
						<ul class="scroll_nav scroll_nav3 clearfix ">
							<li class="on"><a href="#cts01">의기양양픽</a></li>
							<li class=""><a href="#cts02">농사 픽</a></li>
							<li class=""><a href="#cts03">레시피 픽</a></li>
                        </ul>


                        <!-- 1번 섹션 -->
                        <div class="cts01 ac" id="cts01">
                            <img src="/_data/attach/plupload/yangyangpick12_01_2.jpg" alt="">

                            <!-- 낱개주문 이동 -->
                            <a href="/html/dh/bfood_order_free1/?cate_no=1-10">
                                <img src="/_data/attach/plupload/yangyangpick12_02.jpg" alt="">
                            </a>
                            <!-- 인스타그램 이동 -->
                            <a href="https://www.instagram.com/sangol.kitchen/" target="_blank">
                                <img src="/_data/attach/plupload/yangyangpick12_03.jpg" alt="">
                            </a>
                            <img src="/_data/attach/plupload/yangyangpick12_04_01.jpg" alt="">
                        </div>

                        <!-- 2번 섹션 -->
                        <div class="cts02 ac" id="cts02">
                            <img src="/_data/attach/plupload/yangyangpick12_05_1.jpg" alt=""><br style="clear:both;">
                            <img src="/_data/attach/plupload/yangyangpick12_05.jpg" alt=""><br style="clear:both;">
                            <iframe width="100%" height="215" src="https://www.youtube.com/embed/HddxyNPuy7Q" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <img src="/_data/attach/plupload/yangyangpick12_07_2.jpg" alt=""><br style="clear:both;">
                            <img src="/_data/attach/plupload/yangyangpick12_08.jpg" alt=""><br style="clear:both;">
							<iframe width="100%" height="215" src="https://www.youtube.com/embed/xBErPuhCSvI" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                        </div>


                        <!-- 3번 섹션 -->
                        <div class="cts03 ac" id="cts03">
                            <img src="/_data/attach/plupload/yangyangpick12-2_01.jpg" alt=""><br style="clear:both;">
                            <iframe width="100%" height="215" src="https://www.youtube.com/embed/BN8fCanVHgE" frameborder="0" allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture" allowfullscreen></iframe>
                            <img src="/_data/attach/plupload/yangyangpick12-2_03.jpg" alt=""><br style="clear:both;">
                        </div>
					</div>

					<!-- 퍼블리싱 종료 -->