<? 
	$PageName = "QNA";
	$SubName = "";
	$PageTitle = "1:1상담";
	include('../include/head.php');
	include('../include/header.php');
?>

<!--Container-->

<div id="container">
	<?include("../include/my_top.php");?>
	<div class="inner clearfix">
		<?include("../include/mypage_lnb.php");?>
		<div class="my_cont clearfix">
			<div>
				<!-- Board wrap -->
			<div class="board-wrap">
				<!-- board view -->
				<div class="board-view">
					
					<p class="board-view-tit">게시글의 제목이 들어갑니다.</p>
					<p class="board-view-info">관리자 <span>|</span> 2016-08-17 <span>|</span> 조회 1029</p>
					
					<div class="board-view-ct">
						<img src="" alt="이미지" width="1023" height="300">
						게시자가 에디터로 작성한 내용이 들어갑니다.

						<!-- 첨부 -->
						<ul class="board-view-file">
							<li><a href="#">filename.jpg</a></li>
							<li><a href="#" target="_blank">filename.pdf</a></li>
						</ul><!-- END 첨부 -->
					</div>

					<!-- Comment View -->
					<div class="comment-wrap">
						<p class="cmt-tit">댓글 <span>(10)</span></p>

						<!-- <p class="no-ct">작성된 댓글이 없습니다. 제일 먼저 댓글을 작성해 보세요!</p> -->

						<!-- 댓글 리스트 -->
						<ul class="comment-view">
							<li>
								<div class="cmt-item">
									<p class="cmt-name">홍길동</p>
									<p class="cmt-content">일반 댓글입니다.</p>
									<p class="cmt-date">2015.08.12 오후 1:02</p>
								</div>
							</li>
							<li class="my-cmt">
								<div class="cmt-item">
									<p class="cmt-name">wookchu</p>
									<p class="cmt-content">일반 댓글 / 내가 쓴 글(삭제 가능) 입니다.</p>
									<p class="cmt-date">2015.08.12 오후 1:02</p>
									<div class="cmt-options">
										<button type="button">삭제</button>
									</div>
								</div>
							</li>
							<li>
								<div class="cmt-item">
									<p class="cmt-name">김아무개</p>
									<p class="cmt-content">대댓글이 가능할 경우입니다.</p>
									<p class="cmt-date">2015.08.12 오후 1:02</p>
									<div class="cmt-options">
										<button type="button" class="view-cofc">댓글(<strong>3</strong>)</button>
										<button type="button" class="write-cofc">댓글쓰기</button>
										<button type="button">삭제</button>
									</div>
								</div>
								<!-- 대댓글 작성 -->
								<div class="comment-write" style="display:none;">
									<div class="cmt-writer-info">
										<span class="cmt-writer"><label for="cmt-writer2">작성자</label><input type="text" id="cmt-writer2"></span>
										<span class="cmt-pw"><label for="cmt-pw2">비밀번호</label><input type="password" id="cmt-pw2"></span>
									</div>
									<div class="cmt-field">
										<textarea name="" id="cmt-cont" cols="30" rows="3" placeholder="로그인 후 댓글을 작성해 주세요."></textarea>
										<p class="cmt-field-btn">
											<input type="button" class="btn-border-s" value="등록">
										</p>
									</div>
								</div><!-- END 대댓글 작성 -->

								<!-- 대댓글 리스트 -->
								<ul class="cmt-of-cmt" style="display:none;">
									<!-- <li class="no-ct">작성된 댓글이 없습니다. 제일 먼저 댓글을 작성해 보세요!</li> -->
									<li>
										<div class="cmt-item">
											<p class="cmt-name">홍길동</p>
											<p class="cmt-content">대댓글의 내용이 들어갑니다.</p>
											<p class="cmt-date">2015.08.12 오후 1:02</p>
											<!-- <div class="cmt-options">
												<button type="button">삭제</button>
											</div> -->
										</div>
									</li>
									<li class="my-cmt">
										<div class="cmt-item">
											<p class="cmt-name">wookchu</p>
											<p class="cmt-content">내가 작성한 대댓글 입니다.</p>
											<p class="cmt-date">2015.08.12 오후 1:02</p>
											<div class="cmt-options">
												<button type="button">삭제</button>
											</div>
										</div>
									</li>
								</ul><!-- END 대댓글 리스트 -->
							</li>
							<li>
								<div class="cmt-item">
									<p class="cmt-name">wookchu</p>
									<p class="cmt-content">대댓글과 좋아요, 싫어요 기능이 있을 경우입니다.</p>
									<p class="cmt-date">2015.08.12 오후 1:02</p>
									<div class="cmt-options">
										<div class="float-l">
											<button type="button" class="view-cofc">댓글(<strong>0</strong>)</button>
											<button type="button" class="write-cofc">댓글쓰기</button>
											<button type="button">삭제</button>
										</div>
										<p class="float-r align-r">
											<button class="like" title="좋아요">99</button>
											<button class="dislike" title="싫어요">2</button>
										</p>
									</div>
								</div>

								<!-- 대댓글 작성 -->
								<div class="comment-write" style="display:none;">
									<div class="cmt-writer-info">
										<span class="cmt-writer"><label for="cmt-writer3">작성자</label><input type="text" id="cmt-writer3"></span>
										<span class="cmt-pw"><label for="cmt-pw3">비밀번호</label><input type="password" id="cmt-pw3"></span>
									</div>
									<div class="cmt-field">
										<textarea name="" id="cmt-cont" cols="30" rows="3" placeholder="로그인 후 댓글을 작성해 주세요."></textarea>
										<p class="cmt-field-btn">
											<input type="button" class="btn-border-s" value="등록">
										</p>
									</div>
								</div><!-- END 대댓글 작성 -->

								<!-- 대댓글 리스트 -->
								<ul class="cmt-of-cmt" style="display:none;">
									<li class="no-ct">작성된 댓글이 없습니다. 제일 먼저 댓글을 작성해 보세요!</li>
								</ul><!-- END 대댓글 리스트 -->
							</li>
						</ul><!-- END 댓글 리스트 -->

						<!-- 댓글 쓰기 -->
						<div class="comment-write">
							<div class="cmt-writer-info">
								<span class="cmt-writer"><label for="cmt-writer">작성자</label><input type="text" id="cmt-writer"></span>
								<span class="cmt-pw"><label for="cmt-pw">비밀번호</label><input type="password" id="cmt-pw"></span>
							</div>
							<div class="cmt-field">
								<textarea name="" id="cmt-cont" cols="30" rows="3" placeholder="로그인 후 댓글을 작성해 주세요."></textarea>
								<p class="cmt-field-btn">
									<input type="button" class="btn-border-s" value="등록">
								</p>
							</div>
						</div><!-- END 댓글 쓰기 -->

					</div><!-- END Comment View -->

					<!-- 이전/다음 컨텐츠 -->
					<ul class="board-view-nav">
						<li><span class="lb">이전글<img src="/image/board_img/icon_prev.gif" alt=""></span><span class="dh_gray">이전글이 없습니다.</span></li>
						<li><span class="lb">다음글<img src="/image/board_img/icon_next.gif" alt=""></span><a href="#">다음글의 제목이 들어갑니다.</a></li>
					</ul>
					<!-- END 이전/다음 컨텐츠 -->
					
					<!-- Buttons -->
					<div class="board-view-btns">
						<!-- <a href="board_list.php" class="btn-normal-s">목록으로</a> -->
						<div class="float-l">
							<a href="board_list.php" class="btn-normal-s">목록으로</a>
						</div>
						<div class="float-r">
							<a href="board_write.php" class="btn-border-s">수정</a>
							<a href="board_write.php" class="btn-border-s">삭제</a>
							<a href="board_write.php" class="btn-normal-s">답글쓰기</a>
						</div>
					</div><!-- END Buttons -->

				</div><!-- END board view -->
			</div><!-- END Board wrap -->
			</div>
		</div>
	</div>
</div>
<!--END Container-->

<? include('../include/footer.php') ?>
