
		<!-- Board wrap -->
		<div class="board-wrap">
			<!-- board write -->
			<div class="board-write">
				<h3 class="board-tit shop-inner mb10"><img src="/m/image/board_img/icon_write.png" alt="" width="14" height="14"> 글 작성하기</h3>

				<ul class="board-write-form">
					<li><div class="field-label"><label for="write-name">작성자</label></div>
						<div class="field-form">
							<input type="text" id="write-name" class="field-m">
						</div>
					</li>
					<li><div class="field-label"><label for="write-pw">비밀번호</label></div>
						<div class="field-form">
							<input type="password" id="write-pw" class="field-m">
							<input type="checkbox" id="chk-secret" class="ml10">
							<label for="chk-secret">비밀글</label>
						</div>
					</li>
					<li><div class="field-label"><label for="write-title">제목</label></div>
						<div class="field-form">
							<input type="text" id="write-title" class="field-full">
						</div>
					</li>
					<li>
						<div class="write-editor">
							에디터 혹은 textarea가 들어갑니다.
							<!-- <label for="write-content1" class="label-out">내용</label>
							<textarea name="" id="write-content1" cols="30" rows="15"></textarea> -->
						</div>
					</li>
					<li class="pb5"><div class="field-label">파일첨부</div>
						<div class="field-form">
							<ul class="write-files">
								<li>
									<div class="file-attach-box off"><!-- 파일선택후 : off 클래스 추가 -->
										<div class="file-attach">
											<span class="file-name">C:\filename.jpg</span>
											<input type="file" id="w-file1">
											<label for="w-file1">파일찾기</label>
										</div>
										<button type="button" class="plain btn-file-del"><img src="/m/image/board_img/btn_del.png" alt="삭제" width="16" height="16"></button>
									</div>
								</li>
								<li>
									<div class="file-attach-box">
										<div class="file-attach">
											<span class="file-name">파일을 선택해주세요.</span>
											<input type="file" id="w-file1">
											<label for="w-file1">파일찾기</label>
										</div>
										<button type="button" class="plain btn-file-del"><img src="/m/image/board_img/btn_del.png" alt="삭제" width="16" height="16"></button>
									</div>
								</li>
							</ul>
						</div>
					</li>
				</ul>
				<!-- Buttons -->
				<div class="align-c">
					<input type="button" class="btn-normal" value="등록하기">
				</div><!-- END Buttons -->

			</div><!-- END board write -->
		</div><!-- END Board wrap -->