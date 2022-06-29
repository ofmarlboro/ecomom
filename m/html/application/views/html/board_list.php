
		<!-- Board Wrap -->
		<div class="board-wrap">
			<!-- <p class="align-r board-inner">
				<button class="btn-write">글쓰기</button>
			</p> -->

			<!-- 게시판 제목이 있는 경우 -->
			<div class="float-wrap board-inner">
				<h2 class="board-tit float-l pt5">자유게시판</h2>
				<button class="btn-write float-r">글쓰기</button>
			</div>
			<!-- END 게시판 제목이 있는 경우 -->

			<!-- 게시판 리스트 -->
			<ul class="board-list mt15">
				<!-- <li class="no-ct">등록된 게시글이 없습니다.</li> -->
				<li class="list-notice">
					<a href="board_view.php">
						<p class="post-tit">공지게시물을 표시합니다.</p>
					</a>
				</li>
				<li class="list-notice">
					<a href="board_view.php">
						<p class="post-tit">공지게시물을 표시합니다.</p>
					</a>
				</li>
				<li>
					<a href="board_view.php">
						<p class="post-tit">첨부파일이 있는 게시물을 표시합니다. <img src="/m/image/board_img/file.png" alt="첨부파일 있음"><img src="/m/image/board_img/new.png" alt="NEW"></p>
						<p class="post-info">홍길동 | 2016-09-12 | 조회 123</p>
					</a>
				</li>
				<li>
					<a href="board_view.php">
						<p class="post-tit">새 게시물입니다.<img src="/m/image/board_img/new.png" alt="NEW"></p>
						<p class="post-info">홍길동 | 2016-09-12 | 조회 123</p>
					</a>
				</li>
				<li>
					<a href="board_view.php">
						<p class="post-tit">코멘트가 있는 게시물입니다. <span class="list-cmt">[2]</span></p>
						<p class="post-info">홍길동 | 2016-09-12 | 조회 123</p>
					</a>
				</li>
				<li>
					<a href="board_view_pw.php">
						<p class="post-tit"><img src="/m/image/board_img/lock.png" alt="비밀글"> 비밀글 입니다.</p>
						<p class="post-info">홍길동 | 2016-09-12 | 조회 123</p>
					</a>
				</li>
				<li>
					<a href="board_view.php">
						<p class="post-tit">일반 게시물입니다.</p>
						<p class="post-info">홍길동 | 2016-09-12 | 조회 123</p>
					</a>
				</li>
				<li class="list-reply">
					<a href="board_view.php">
						<p class="post-tit">RE: 댓글 게시물입니다.</p>
						<p class="post-info">홍길동 | 2016-09-12 | 조회 123</p>
					</a>
				</li>
				<li class="list-reply">
					<a href="board_view_pw.php">
						<p class="post-tit">RE: <img src="/m/image/board_img/lock.png" alt="비밀글"> 댓글 게시물입니다. (비공개)</p>
						<p class="post-info">홍길동 | 2016-09-12 | 조회 123</p>
					</a>
				</li>
				<li class="list-reply">
					<a href="board_view.php">
						<p class="post-tit">RE: RE: 댓글의 댓글 게시물입니다.</p>
						<p class="post-info">홍길동 | 2016-09-12 | 조회 123</p>
					</a>
				</li>
				<li>
					<a href="board_view.php">
						<p class="post-tit">일반 게시물입니다.</p>
						<p class="post-info">홍길동 | 2016-09-12 | 조회 123</p>
					</a>
				</li>
				<li>
					<a href="board_view.php">
						<p class="post-tit">일반 게시물입니다.</p>
						<p class="post-info">홍길동 | 2016-09-12 | 조회 123</p>
					</a>
				</li>
				<li>
					<a href="board_view.php">
						<p class="post-tit">일반 게시물입니다.</p>
						<p class="post-info">홍길동 | 2016-09-12 | 조회 123</p>
					</a>
				</li>
			</ul>
			<!-- END 게시판 리스트 -->

			
				
			<!-- 페이징 -->
			<div class="board-pager">
				<button type="button"><img src="/m/image/board_img/arrow_l_end.png" alt="맨 앞으로"></button>
				<button type="button"><img src="/m/image/board_img/arrow_l.png" alt="이전"></button>
				<a href="#" class="on">1</a>
				<a href="#">2</a>
				<a href="#">3</a>
				<button type="button"><img src="/m/image/board_img/arrow_r.png" alt="다음"></button>
				<button type="button"><img src="/m/image/board_img/arrow_r_end.png" alt="맨 뒤로"></button>
			</div><!-- END 페이징 -->


			<!-- 검색 -->
			<div class="board-search">
				<select class="board-search-select">
					<option value="전체">전체</option>
					<option value="제목">제목</option>
					<option value="작성자">작성자</option>
					<option value="내용">내용</option>
				</select>
				<input type="text" class="board-search-field">
				<button type="button" class="btn-search">검색</button>
			</div>
			<!-- END 검색 -->


		</div><!-- END Board Wrap -->