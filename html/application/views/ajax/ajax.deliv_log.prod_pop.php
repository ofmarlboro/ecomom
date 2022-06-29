					<div class="deliv-log">
						<h1>
							<?=date("m월 d일",$deliv_code_arr[1])?> 주문변경내역
						</h1>
						<div class="scroll">
							<ul class="bu_list01">
								<li>
									<table class="tblTy02" width="100%">
										<tr>
											<th>일자</th>
											<th>항목</th>
											<th>내용</th>
											<th>시행자</th>
										</tr>
										<?php
										foreach($list as $lt){
										?>
										<tr>
											<td><?=strDatecut($lt->wdate,3)?></td>
											<td><?=$lt->type?></td>
											<td><?=$lt->msg?></td>
											<td><?=strpos($lt->writer,"본인")!==false?"본인":'관리자';?></td>
										</tr>
										<?php
										}
										?>
										<!-- <tr>
											<td>2018-07-05</td>
											<td>메뉴 변경</td>
											<td>2018-07-11(수)에서 2018-07-06(금)로 배송일을 변경 하였습니다.</td>
											<td>본인</td>
										</tr>
										<tr>
											<td>2018-07-05</td>
											<td>메뉴 변경</td>
											<td>2018-07-11(수)에서 2018-07-06(금)로 배송일을 변경 하였습니다.</td>
											<td>본인</td>
										</tr>
										<tr>
											<td>2018-07-05</td>
											<td>메뉴 변경</td>
											<td>2018-07-11(수)에서 2018-07-06(금)로 배송일을 변경 하였습니다.</td>
											<td>본인</td>
										</tr> -->
									</table>
								</li>
							</ul>
						</div>
						<a href="javascript:;" class="btn_close" onclick='$(this).parents(".layer_pop").hide();'></a>
					</div>