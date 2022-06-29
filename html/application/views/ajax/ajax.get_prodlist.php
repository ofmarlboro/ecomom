<?php
/*
<!--
	*3n개째 li.mr0
	*알러지 체크에 해당할 때 li.alrg / span.alrg_mark 부분 추가
	*제외됐을 때 li.except
	*일요일추가분 li.sunday
-->
*/
?>


<?php
foreach($deliv_date_arr as $dda){
?>
<h5 class="htit"><?=date("m월 d일",strtotime($dda))?> (<?=$week_name_arr[date("w",strtotime($dda))]?>)</h5>
<input type="hidden" name="recom_delivery_detail_date[]" value="<?=$dda?>">
<ul class="sched_menu">
	<?php
	$p_cnt = 0;

	$real_dda = $dda;

	if($delivery_week_type == 2){
		$dda = date("Y-m-d",strtotime('+1 day',strtotime($dda)));
	}

	foreach($prod as $p){
		if( $p->recom_date <= $dda and $p->recom_date > $last_dda ){	// and $week_name_arr[date("w",strtotime($limit_date))] == $week_name_arr[date("w",strtotime($dda))]
			$p_cnt++;

			if($delivery_week_day_count_arr[0] == 4 and (date("w",strtotime($p->recom_date)) == 1 or date("w",strtotime($p->recom_date)) == 4)) continue;

			$prod_allergy_arr = explode("^",substr($p->allergys,0,-1));

			$allergy_class = "";

			if(array_intersect($allergys,$prod_allergy_arr)){
				$allergy_class = "alrg";
			}
			?>
			<li class="<?=($p_cnt%3 == 0) ?"mr0":""; ?> <?=$allergy_class?>">

			<input type="hidden" name="recom_delivery_detail_prod[]" value="<?=$p->idx?>:<?=$real_dda?>">

				<div class="box">
					<a href="javascript:;" onclick="menuView('<?=$p->idx?>')" class="link_dt" title="상세보기">
						<span class="img"><img src="/_data/file/goodsImages/<?=$p->list_img?>" alt="한우보미의 이미지"></span>
						<?php
						if($allergy_class == "alrg"){
						?>
						<span class="alrg_mark">[체질에 따라 알러지를 유발할 수 있습니다.]</span>
						<?php
						}
						?>
					</a>
					<em class="tit"><?=$p->name?></em>
				</div>
			</li>
			<?php
			if(date("w",strtotime($p->recom_date)) == 4){
				$thursday = $p;
			}else if( date("w",strtotime($p->recom_date)) == 5 ){
				$friday = $p;
			}else if( date("w",strtotime($p->recom_date)) == 6 ){
				$saturday = $p;
			}
		}
	}

	if(date("w",strtotime($dda)) > 4 and $delivery_week_day_count_arr[0] == 7){

		switch($delivery_sun_type){
			case "4": $sunday = $thursday; break;
			case "5": $sunday = $friday; break;
			case "6": $sunday = $saturday; break;
		}

		$sunday_prd_alrg_arr = explode("^",substr($sunday->allergys,0,-1));

		$sunday_allergy_class = "";

		if(array_intersect($allergys,$sunday_prd_alrg_arr)){
			$sunday_allergy_class = "alrg";
		}
		?>
		<li class="<?=$sunday_allergy_class?> sunday"><div class="box">

		<input type="hidden" name="recom_delivery_detail_sunday_prod[]" value="<?=$sunday->idx?>:<?=$real_dda?>">

				<a href="#" class="link_dt" title="상세보기">
					<span class="img"><img src="/_data/file/goodsImages/<?=$sunday->list_img?>" alt="한우보미의 이미지"></span>
					<?php
					if($sunday_allergy_class == "alrg"){
					?>
					<span class="alrg_mark">[체질에 따라 알러지를 유발할 수 있습니다.]</span>
					<?php
					}
					?>
				</a>
				<em class="tit"><?=$sunday->name?></em>
				<span class="added">일요일 추가분</span>
			</div>
		</li>
		<?php
	}
	?>
</ul>
<?php
	$last_dda = $dda;
}
?>

<?php
/*
		<li class="<?=($p_cnt%3 == 0) ?"mr0":""; ?>">
			<div class="box">
				<a href="#" class="link_dt" title="상세보기">
					<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
				</a>
				<em class="tit">A09. 한우보미</em>
			</div>
		</li>
*/


/*
<h5 class="htit">3월 7일 (수)</h5>
<ul class="sched_menu">
	<li class="alrg sunday"><div class="box">
			<a href="#" class="link_dt" title="상세보기">
				<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
				<span class="alrg_mark">[체질에 따라 알러지를 유발할 수 있습니다.]</span>
			</a>
			<em class="tit">A09. 한우보미</em>

			<input type="text" class="cnt" title="수량" value="1">

			<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
			<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
			<span class="added">일요일 추가분</span>
		</div>
	</li>
	<li class="sunday"><div class="box">
			<a href="#" class="link_dt" title="상세보기">
				<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
			</a>
			<em class="tit">A09. 한우보미</em>

			<input type="text" class="cnt" title="수량" value="1">

			<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
			<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>

			<span class="added">일요일 추가분</span>
		</div>
	</li>
	<li class="mr0"><div class="box">
			<a href="#" class="link_dt" title="상세보기">
				<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
			</a>
			<em class="tit">A09. 한우보미</em>

			<input type="text" class="cnt" title="수량" value="1">

			<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
			<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
		</div>
	</li>
</ul>

<h5 class="htit">3월 8일 (수)</h5>
<ul class="sched_menu">
	<li><div class="box">
			<a href="#" class="link_dt" title="상세보기">
				<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
			</a>
			<em class="tit">A09. 한우보미</em>

			<input type="text" class="cnt" title="수량" value="1">

			<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
			<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
		</div>
	</li>
	<li class="except alrg sunday"><div class="box">
			<a href="#" class="link_dt" title="상세보기">
				<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
				<span class="alrg_mark">[체질에 따라 알러지를 유발할 수 있습니다.]</span>
			</a>
			<em class="tit">A09. 한우보미</em>

			<input type="text" class="cnt" title="수량" value="1">

			<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
			<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>

			<span class="added">일요일 추가분</span>
		</div>
	</li>
	<li class="mr0"><div class="box">
			<a href="#" class="link_dt" title="상세보기">
				<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
			</a>
			<em class="tit">A09. 한우보미</em>

			<input type="text" class="cnt" title="수량" value="1">

			<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
			<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
		</div>
	</li>
</ul>

<h5 class="htit">3월 9일 (목)</h5>
<ul class="sched_menu">
	<li><div class="box">
			<a href="#" class="link_dt" title="상세보기">
				<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
			</a>
			<em class="tit">A09. 한우보미</em>

			<input type="text" class="cnt" title="수량" value="1">

			<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
			<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
		</div>
	</li>
	<li><div class="box">
			<a href="#" class="link_dt" title="상세보기">
				<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
			</a>
			<em class="tit">A09. 한우보미</em>

			<input type="text" class="cnt" title="수량" value="1">

			<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
			<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
		</div>
	</li>
	<li class="mr0"><div class="box">
			<a href="#" class="link_dt" title="상세보기">
				<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
			</a>
			<em class="tit">A09. 한우보미</em>

			<input type="text" class="cnt" title="수량" value="1">

			<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
			<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
		</div>
	</li>
</ul>

<h5 class="htit">3월 10일 (금)</h5>
<ul class="sched_menu">
	<li><div class="box">
			<a href="#" class="link_dt" title="상세보기">
				<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
			</a>
			<em class="tit">A09. 한우보미</em>

			<input type="text" class="cnt" title="수량" value="1">

			<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
			<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
		</div>
	</li>
	<li><div class="box">
			<a href="#" class="link_dt" title="상세보기">
				<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
			</a>
			<em class="tit">A09. 한우보미</em>

			<input type="text" class="cnt" title="수량" value="1">

			<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
			<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
		</div>
	</li>
	<li class="mr0"><div class="box">
			<a href="#" class="link_dt" title="상세보기">
				<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
			</a>
			<em class="tit">A09. 한우보미</em>

			<input type="text" class="cnt" title="수량" value="1">

			<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
			<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
		</div>
	</li>
</ul>

<h5 class="htit">3월 11일 (토)</h5>
<ul class="sched_menu">
	<li><div class="box">
			<a href="#" class="link_dt" title="상세보기">
				<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
			</a>
			<em class="tit">A09. 한우보미</em>

			<input type="text" class="cnt" title="수량" value="1">

			<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
			<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
		</div>
	</li>
	<li><div class="box">
			<a href="#" class="link_dt" title="상세보기">
				<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
			</a>
			<em class="tit">A09. 한우보미</em>

			<input type="text" class="cnt" title="수량" value="1">

			<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
			<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
		</div>
	</li>
	<li class="mr0"><div class="box">
			<a href="#" class="link_dt" title="상세보기">
				<span class="img"><img src="/image/sub/menu_img.jpg" alt="한우보미의 이미지"></span>
			</a>
			<em class="tit">A09. 한우보미</em>

			<input type="text" class="cnt" title="수량" value="1">

			<button type="button" class="plain btn minus" title="1개 빼기"><img src="/image/sub/btn_minus2.png" alt="-"></button>
			<button type="button" class="plain btn plus" title="1개 더하기"><img src="/image/sub/btn_plus2.png" alt="+"></button>
		</div>
	</li>
</ul>
*/
?>