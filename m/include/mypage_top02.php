
<div class="mypage_top clearfix">
	<div class="user">
		<a href="<?=cdir()?>/dh_member/mypage"><img src="/image/sub/set.png" alt="">정보변경</a>
		<p>
			<em>
				<?php
				if($member_info->regist_type == "sns"){
					if(strpos($this->session->userdata('USERID'),"kko")!==false){
						echo "카카오 로그인 회원";
					}
					else{
						echo "네이버 로그인 회원";
					}
				}
				else{
					echo $this->session->userdata('USERID');
				}
				?>
			</em>
			<!-- <img src="/image/sub/bar.gif" alt="" class="bar"><em><?=$this->session->userdata('NAME')?></em><span>님</span> -->
		</p>
		<p class="nick"><?=$this->session->userdata('NAME')?></p>
		<p class="grade">현재 회원님의 등급은 <span>[<?=$member_level[$this->session->userdata('LEVEL')]?>]</span> 입니다.</p>
	</div>


	<!-- 	<h2 class="gn_tit"><img src="/image/sub/<?=$title_img?>" alt="<?=$$PageName->tit?>"></h2>
				<h3 class="hidden"><?=$$SubName->tit?></h3>
				<p class="page_path"><a href="<?=$HOME->url?>">홈</a> &gt; <?=$$PageName->tit?> &gt; <strong><?=$$SubName->tit?></strong></p> -->

</div>

<!-- 공통 LNB -->

<!-- <?if($PageName!="K04" && $PageName!="K05" && $PageName!="K06") {?> -->
<!-- 	<div class="lnb_wrap">

		</div> -->
<!-- END 공통 LNB -->
<!-- <?}?> -->