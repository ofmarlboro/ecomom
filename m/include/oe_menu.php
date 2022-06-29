
			<!-- 배송수정 탭메뉴 -->
			<div class="oe_menu order_opt mt10">
				<!-- <h6 class="faq-q">
					<p class="pageName"><?=$$PageName->tit?></p>
				</h6>
				<div class="faq-a">
					<ul class="bu_list01">
							<li><a href="order_edit.php">배송지 변경</a></li>
							<li><a href="order_edit02.php">메뉴/단계 변경</a></li>
							<li><a href="order_edit03.php">배송일 변경</a></li>
							<li><a href="order_edit04.php">배송 일시정지/재시작</a></li>
							<li><a href="order_edit05.php">배송 몰아받기</a></li>
					</ul>
				</div> -->
									<div class="selbox selbox01 open">
										<!-- <button type="button" onClick="toggleSelBox(this, event);"><span class="week_day_count_span"><?=$$PageName->tit?></span></button> -->
										<ul style="position:relative">
											<li class="<?=$PageName == "ORDER_EDIT"?"on":"";?>">
												<input type="radio" id="order_edit" checked="" onclick="location.href='<?=$ORDER_EDIT->url?>'">
												<label for="order_edit">배송지 변경</label>
											</li>
											<li class="<?=$PageName == "ORDER_EDIT02"?"on":"";?>">
												<input type="radio" id="order_edit02" checked="" onclick="location.href='<?=$ORDER_EDIT02->url?>'">
												<label for="order_edit02">메뉴 변경</label>
											</li>
											<li class="<?=$PageName == "ORDER_EDIT03"?"on":"";?>">
												<input type="radio" id="order_edit03" onclick="location.href='<?=$ORDER_EDIT03->url?>'">
												<label for="order_edit03">배송일 변경</label>
											</li>
											<!-- <li>
												<input type="radio" id="order_edit04" onclick="location.href='<?=$ORDER_EDIT04->url?>'">
												<label for="order_edit04">배송 일시정지/재시작</label>
											</li> -->
											<!-- <li>
												<input type="radio" id="order_edit05" onclick="location.href='<?=$ORDER_EDIT05->url?>'">
												<label for="order_edit05">배송 몰아받기</label>
											</li> -->
										</ul>
									</div>

			</div>
			<!-- //배송수정 탭메뉴  -->
			<script type="text/javascript" src="/js/orderPage.js"></script>