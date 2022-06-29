<div class="dashboard" <?if($_SERVER['REMOTE_ADDR'] != "112.221.155.109"){?>style="display:none;"<?}?>>
	<!-- Left -->
	<!-- <div class="col-left">
		<h2 class="mt0">주문현황</h2>
		<h2>회원가입현황 (명)</h2>
		<section class="pdbox pl0 pr0">
			<table class="dash-cnt">
				<caption>회원가입 현황 - 전체가입자, 오늘 가입자, 차단회원, 탈퇴회원의 수</caption>
				<tbody>
					<tr>
						<td><em><?=number_format($member_total)?></em> <span>전체 가입자 수</span></td>
						<td><em><?=number_format($member_today)?></em> <span>오늘 가입자 수</span></td>
						<td><em><?=number_format($member_outer)?></em> <span>탈퇴 회원</span></td>
					</tr>
				</tbody>
			</table>
		</section>
		<h2>접속자 통계 (건)</h2>
		<section class="pdbox pl0 pr0">
			<table class="dash-cnt">
				<caption>접속자 현황 - 오늘/어제/이번주/이번달</caption>
				<tbody>
					<tr>
						<td><em><?=number_format($today_connect->uc)?></em> <span>오늘</span></td>
						<td><em><?=number_format($ysday_connect->uc)?></em> <span>어제</span></td>
						<td><em><?=number_format($tweek_connect->uc)?></em> <span>이번주</span></td>
						<td><em><?=number_format($tmont_connect->uc)?></em> <span>이번달</span></td>
					</tr>
				</tbody>
			</table>
		</section>
		<h2>게시판 이용현황</h2>
		<div class="float-wrap">
			<div class="dash-post dash-qna float-l">
				<section class="pdbox">
					<h3 class="htit">문의게시판</h3>
					<p class="cnt"><a href="/bbs/board.php?bo_table=qa">20</a> <span>/</span> 23,480</p>
					<p>확인하지 않은 문의글</p>
				</section>
			</div>
			<div class="dash-post float-r">
				<section class="pdbox">
					<h3 class="htit">산골먹방 후기게시판</h3>
					<ul class="dash-review">
														<li><a href="/bbs/board.php?bo_table=review&amp;wr_id=13112" target="_blank">잘 먹어요~</a>
							<span class="grade"><img src="/_dhadm/image/icon/s_star4.png" alt="별4개"></span>
						</li>
														<li><a href="/bbs/board.php?bo_table=review&amp;wr_id=13094" target="_blank">첫이유식 성공적!</a>
							<span class="grade"><img src="/_dhadm/image/icon/s_star5.png" alt="별5개"></span>
						</li>
														<li><a href="/bbs/board.php?bo_table=review&amp;wr_id=13093" target="_blank">워킹맘 고민 끝</a>
							<span class="grade"><img src="/_dhadm/image/icon/s_star5.png" alt="별5개"></span>
						</li>
														<li><a href="/bbs/board.php?bo_table=review&amp;wr_id=13091" target="_blank">산골밥 마이쪄요~!</a>
							<span class="grade"><img src="/_dhadm/image/icon/s_star5.png" alt="별5개"></span>
						</li>
					</ul>
				</section>
			</div>
		</div>
	</div> --><!-- END Left -->
	
	<!-- Right -->
	<!-- <div class="col-right">
		<h2 class="mt0">주문/매출집계</h2>
		<div class="opt-select">
			<select name="" id="">
				<option value="">어제</option>
				<option value="">오늘</option>
				<option value="">이번달</option>
			</select>
		</div>
		<div class="pdbox pd0">
			<div class="tbl-wrap">
				<table class="dh-tbl">
					<thead>
						<tr>
							<th colspan="2" rowspan="2">구분</th>
							<th colspan="2">골라담기</th>
							<th colspan="2">추천식단</th>
							<th colspan="2">금액</th>
						</tr>
						<tr>
							<th>수량</th>
							<th>금액</th>
							<th>수량</th>
							<th>금액</th>
							<th>수량</th>
							<th>금액</th>
						</tr>
					</thead>
					<tbody>
						<tr>
							<th rowspan="8">이유식</th>
							<th>준비기</th>
							<td class="tint">20</td>
							<td>150,000</td>
							<td class="tint">20</td>
							<td>150,000</td>
							<td class="tint">20</td>
							<td>300,000</td>
						</tr>
						<tr>
							<th>초기</th>
							<td class="tint">20</td>
							<td>150,000</td>
							<td class="tint">20</td>
							<td>150,000</td>
							<td class="tint">20</td>
							<td>300,000</td>
						</tr>
						<tr>
							<th>중기 준비기</th>
							<td class="tint">20</td>
							<td>150,000</td>
							<td class="tint"></td>
							<td>-</td>
							<td class="tint">20</td>
							<td>300,000</td>
						</tr>
						<tr>
							<th>중기</th>
							<td class="tint">20</td>
							<td>150,000</td>
							<td class="tint">20</td>
							<td>150,000</td>
							<td class="tint">20</td>
							<td>300,000</td>
						</tr>
						<tr>
							<th>후기</th>
							<td class="tint">20</td>
							<td>150,000</td>
							<td class="tint">20</td>
							<td>150,000</td>
							<td class="tint">20</td>
							<td>300,000</td>
						</tr>
						<tr>
							<th>후기 2식</th>
							<td class="tint"></td>
							<td>-</td>
							<td class="tint">20</td>
							<td>150,000</td>
							<td class="tint">20</td>
							<td>300,000</td>
						</tr>
						<tr>
							<th>후기 3식</th>
							<td class="tint"></td>
							<td>-</td>
							<td class="tint">20</td>
							<td>150,000</td>
							<td class="tint">20</td>
							<td>300,000</td>
						</tr>
						<tr>
							<th>완료기</th>
							<td class="tint">20</td>
							<td>150,000</td>
							<td class="tint">20</td>
							<td>150,000</td>
							<td class="tint">20</td>
							<td>300,000</td>
						</tr>
						<tr>
							<th rowspan="3">반찬·국</th>
							<th>반찬</th>
							<td class="tint">20</td>
							<td>150,000</td>
							<td class="tint"></td>
							<td>-</td>
							<td class="tint">20</td>
							<td>300,000</td>
						</tr>
						<tr>
							<th>국</th>
							<td class="tint">20</td>
							<td>150,000</td>
							<td class="tint"></td>
							<td>-</td>
							<td class="tint">20</td>
							<td>300,000</td>
						</tr>
						<tr>
							<th>추천식당</th>
							<td class="tint"></td>
							<td>-</td>
							<td class="tint">20</td>
							<td>150,000</td>
							<td class="tint">20</td>
							<td>300,000</td>
						</tr>
						<tr>
							<th colspan="2">특가상품 SET</th>
							<td class="tint">20</td>
							<td>300,000</td>
							<td class="tint"></td>
							<td>-</td>
							<td class="tint">20</td>
							<td>150,000</td>
						</tr>
						<tr>
							<th colspan="2">간식</th>
							<td class="tint">20</td>
							<td>300,000</td>
							<td class="tint"></td>
							<td>-</td>
							<td class="tint">20</td>
							<td>150,000</td>
						</tr>
						<tr>
							<th colspan="2">오!산골농부 이벤트</th>
							<td class="tint">20</td>
							<td>300,000</td>
							<td class="tint"></td>
							<td>-</td>
							<td class="tint">20</td>
							<td>150,000</td>
						</tr>
						<tr>
							<th colspan="2">산골먹거리</th>
							<td class="tint">20</td>
							<td>300,000</td>
							<td class="tint"></td>
							<td>-</td>
							<td class="tint">20</td>
							<td>150,000</td>
						</tr>
						<tr>
							<th colspan="2">샘플신청</th>
							<td class="tint">20</td>
							<td>300,000</td>
							<td class="tint"></td>
							<td>-</td>
							<td class="tint">20</td>
							<td>150,000</td>
						</tr>
						<tr>
							<th class="tint2" colspan="2">합계</th>
							<td class="tint2">260</td>
							<td class="tint2">1,950,000</td>
							<td class="tint2">160</td>
							<td class="tint2">1,200,000</td>
							<td class="tint2">400</td>
							<td class="tint2">3,000,000</td>
						</tr>
					</tbody>
				</table>
			</div>
		</div>
	</div> --><!-- END Right -->
	
	<div class="hj02 clearfix">
		<div class="fl">
			<h1>
				관리자 메모
			</h1>
			<ul class="list01">
				<li>
					<span class="date">2018-08-25 14:00</span> 000고객님께 전화해야함000고객님께 전화해야함000고객님께 전화해야함000고객님께 전화해야함000고객님께 전화해야함000고객님께 전화해야함000고객님께 전화해야함000고객님께 전화해야함000고객님께 전화해야함000고객님께 전화해야함
					<a href="#" class="btn_del">삭제</a>
				</li>
				<li>
					<span class="date">2018-08-25 14:00</span> 000고객님께 전화해야함
					<a href="#" class="btn_del">삭제</a>
				</li>
				<li>
					<span class="date">2018-08-25 14:00</span> 000고객님께 전화해야함
					<a href="#" class="btn_del">삭제</a>
				</li>
				<li>
					<span class="date">2018-08-25 14:00</span> 000고객님께 전화해야함
					<a href="#" class="btn_del">삭제</a>
				</li>
				<li>
					<span class="date">2018-08-25 14:00</span> 000고객님께 전화해야함
					<a href="#" class="btn_del">삭제</a>
				</li>
				<li>
					<span class="date">2018-08-25 14:00</span> 000고객님께 전화해야함
					<a href="#" class="btn_del">삭제</a>
				</li>
				<li>
					<span class="date">2018-08-25 14:00</span> 000고객님께 전화해야함
					<a href="#" class="btn_del">삭제</a>
				</li>
				<li>
					<span class="date">2018-08-25 14:00</span> 000고객님께 전화해야함
					<a href="#" class="btn_del">삭제</a>
				</li>
				<li>
					<span class="date">2018-08-25 14:00</span> 000고객님께 전화해야함
					<a href="#" class="btn_del">삭제</a>
				</li>
				<li>
					<span class="date">2018-08-25 14:00</span> 000고객님께 전화해야함
					<a href="#" class="btn_del">삭제</a>
				</li>
				<li>
					<span class="date">2018-08-25 14:00</span> 000고객님께 전화해야함
					<a href="#" class="btn_del">삭제</a>
				</li>
				<li>
					<span class="date">2018-08-25 14:00</span> 000고객님께 전화해야함
					<a href="#" class="btn_del">삭제</a>
				</li>
				<li>
					<span class="date">2018-08-25 14:00</span> 000고객님께 전화해야함
					<a href="#" class="btn_del">삭제</a>
				</li>
			</ul>
			<div class="form">
				<input type="text">
				<button>쓰기</button>
			</div>
		</div>
		<div class="fr">
			<h1>
				금일배송관리
			</h1>
			<ul class="list03">
				<li>
					생산제품목록 엑셀 저장
					<input type="text">
					<button>다운로드</button>
				</li>
				<li>
					내일 (2018-07-07 토요일) 배송 예약 : 900 건
					<button>내역 확인</button>
				</li>
				<li>
					지난 배송 (미 완료처리) : 900 건
					<button>일괄 변경</button>
				</li>
			</ul>
		</div>
		<hr>
		<div class="fr">
			<h1>
				CS 요청관리
			</h1>
			<ul class="list02">
				<li>
					<p>주문취소<br>
						미처리</p>
					<strong>10</strong><em>건</em>
				</li>
				<li>
					<p>1:1 문의<br>
						미처리</p>
					<strong>10</strong><em>건</em>
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
				<th colspan="2">Today</th>
				<th colspan="2">7월 9일 (월)</th>
				<th colspan="2">7월 9일 (화)</th>
				<th colspan="2">7월 9일 (수)</th>
				<th colspan="2">7월 9일 (목)</th>
				<th colspan="2">7월 9일 (금)</th>
				<th colspan="2">7월 9일 (월)</th>
			</tr>	
			<tr>
				<th>건수</th>
				<th>금액</th>
				<th>건수</th>
				<th>금액</th>
				<th>건수</th>
				<th>금액</th>
				<th>건수</th>
				<th>금액</th>
				<th>건수</th>
				<th>금액</th>
				<th>건수</th>
				<th>금액</th>
				<th>건수</th>
				<th>금액</th>

				
			</tr>
			</thead>
			<tbody>
			 <tr>
			 <td>신용카드</td>
			 <td>51</td>
			 <td>5,442,554</td>
			  <td>51</td>
			 <td>5,442,554</td>
			  <td>51</td>
			 <td>5,442,554</td>
			  <td>51</td>
			 <td>5,442,554</td>
			  <td>51</td>
			 <td>5,442,554</td>
			  <td>51</td>
			 <td>5,442,554</td>
			  <td>51</td>
			 <td>5,442,554</td>
			 </tr>
			</tbody>
			<tfoot>
			<tr>
			<td>합계</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			<td>-</td>
			</tr>
			<tr><td>주문취소</td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td>
			<td></td></tr>
			
			</tfoot>

		</table>
	</div>
</div>
