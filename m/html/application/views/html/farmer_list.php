<?
	$PageName = "K06";
	$SubName = "K0600";
	include("../include/head.php");
	include("../include/header.php");
?>

<!--Container-->

<div id="container">
	<?include("../include/top_menu.php");?>

	<!-- <img src="/m/image/sub/Sangol_M_ohsangol_02.jpg" alt="" width="100%"> -->

	<?php
		if($banners){
			foreach($banners as $lt){
				if($lt->m_pageurl){
					echo "<a href='".$lt->m_pageurl."'";
					if($lt->m_target == "blank"){
						echo " target='_blank'";
					}
					echo ">";
				}
				echo "<img src='/_data/file/banner/".$lt->upfile2."' alt='' width='100%' onerror=\"this.src='/_data/file/banner/".$lt->upfile1."'\">";
				if($lt->m_pageurl){
					echo "</a>";
				}
			}
		}
		?>
	<ul class="osan">
		<li class="item">
			<h2>
				봄춘토마토<span>/무농약으로 소중하게 키운 토마토</span>
			</h2>
			<a href="/m/html/dh_product/prod_view/960?&cate_no=5"><img src="/image/sub/oh_hadong_tomato_on.jpg" alt=""></a>
			<span class="desc">최고농업기술명인이 기른 무농약 토마토로 빛깔과 맛이 뛰어난 고급 토마토입니다</span>
		</li>
		<li class="item">
			<h2>
				하동햇배<span>/지리산 햇빛과 섬진강 바람이 기른</span>
			</h2>
			<a href="/m/html/dh_product/prod_view/924?&cate_no=5"><img src="/image/sub/oh_hadong_pear_on.jpg" alt=""></a>
			<span class="desc">40년 베테랑 배농사 산골농부님이 키운 연한육질에 당도와 과즙이 최고인 하동배입니다.</span>
		</li>
		<li class="item">
			<h2>
				악양대봉곶감<span>/지리산 햇빛과 섬진강 바람이 기른</span>
			</h2>
			<a href="/m/html/dh_product/prod_view/858?&cate_no=5"><img src="/image/sub/oh_gam_on.jpg" alt=""></a>
			<span class="desc">임금님진상품으로 올라갈만큼 당도가 뛰어난 지리산자락 악양에서 키우고 말린 대봉곶감입니다.</span>
		</li>
		<!-- <li class="item">
			<h2>
				지리산 하동배<span>/지리산 햇빛과 섬진강 바람이 기른</span>
			</h2>
			<a href="/m/html/dh_product/prod_view/583?&cate_no=5"><img src="/_data/file/addImages/c02f06aa634d9f2e5739d4a18fca4141.jpg" alt=""></a>
			<span class="desc">40년 베테랑 배농사 산골농부님이 키운 연한육질에 당도와 과즙이 최고인 하동배입니다.</span>
		</li> -->
		<li class="item">
			<h2>
				지리산 산초유정란<span>/청정자연에서 산초 먹고 낳은 유정란</span>
			</h2>
			<a href="/m/html/dh_product/prod_view/554?&cate_no=5"><img src="/image/sub/oh_egg_640x640_over.jpg" alt=""></a>
			<span class="desc">지리산 해발 450M에서 스트레스 없이 뛰어노는 닭들이 산초와 들깨, 동물복지사료를 먹고 낳아 오메가3가 풍부한 건강한 유정란입니다.</span>
		</li>
		<li class="item">
			<h2>
				지리산 첫봄미나리<span>/친환경무농약 천연암반수 재배</span>
			</h2>
			<a href="http://www.ecomommeal.co.kr/m/html/dh_product/prod_view/505?&cate_no=5"><img src="/image/sub/oh_minali_640x640_over.jpg" alt=""></a>
			<span class="desc">낮에는 물을 빼고, 밤에는 물을 채워 스스로 자라게 하는 청학동 미나리.
				날마다 새로운 지리산천연암반수로 자라나 더 아삭하고 향긋합니다.</span>
		</li>

		<li class="item">
			<h2>
				평사리 황금들판 햅쌀<span>물고기가 키운 하동햅쌀!</span>
			</h2>
			<a href="<?=$K0601->url?>"><img src="/image/sub/Osangol_02.jpg" alt=""></a>
			<span class="desc">우리 땅을 지키는 일은 우리 아이밥상을 지키는 일과 같습니다.
			둠벙농법으로 지킨 평사리하동들판 햅쌀을 나눔합니다.</span>
		</li>
		<li class="item">
			<h2>
				솔잎한우<span>1+등급 무항생제 솔잎한우</span>
			</h2>
			<a href="<?=$K0602->url?>"><img src="/image/sub/Osangol_1.jpg" alt=""></a>
			<span class="desc">친환경 미생물 솔솔크를 먹고자란 건강한 무항생제 솔잎한우
			1+등급의 솔잎한우를 공정거래가로 만나는 즐거운 기회 </span>
		</li>
		<!-- <li class="item">
			<h2>
				하동햇배<span>정문 농부님의 산지직송 햇배</span>
			</h2>
			<a href="<?=$K0603->url?>"><img src="/image/sub/Osangol_2.jpg" alt=""></a>
			<span class="desc">물빠짐 좋은 1급수 섬진강변의 사질양토에서 재배된 최상급 햇배
			당도도 높고 굵기도 튼실하지요!</span>
		</li> -->
		<li class="item">
			<h2>
				고로쇠물<span>지리산 해발 600미터 직접 채취</span>
			</h2>
			<a href="<?=$K0604->url?>"><img src="/image/sub/Osangol__2.jpg" alt=""></a>
			<span class="desc">엄마와 아기의 뼈를 튼튼하게 하는 천연 이온음료</span>
		</li>

	</ul>
</div>
<!--END Container-->

<?include("../include/footer.php");?>
<script type="text/javascript">
	jQuery(document).ready(function($){


		$(".osan").slick({
			dots:true

		});
	});
</script>
