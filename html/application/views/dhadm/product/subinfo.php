<div class="float-wrap">
	<h3 class="icon-list float-l">카테고리별 안내페이지 관리</h3>
</div>

<table class="adm-table align-c">
	<thead>
		<tr>
			<th>사용여부</th>
			<th>타이틀</th>
			<th>골라담기</th>
			<th>추천식단</th>
			<th>상세소개 사용여부</th>
			<th>상세소개 (모바일) 등록여부</th>
			<th>월별싱단표 사용여부</th>
			<!-- <th>타이틀(소)</th> -->
			<th>관리</th>
		</tr>
	</thead>
	<tbody>
		<?php
		if($list){
			foreach($list as $lt){
			?>
		<tr>
			<td>
				<?=($lt->it_use)?"사용":"미사용";?>
			</td>
			<td>
				<?=$lt->title_b?>
			</td>
			<td>
				<?php
				if($lt->cate_no){
					$lt_cate = substr($lt->cate_no,0,-1);
					$lt_cate = explode(",",$lt_cate);
					foreach($lt_cate as $le){
						echo $cate_arr[$le]."<br>";
					}
				}
				else{
					echo "-";
				}
				?>
			</td>
			<td>
				<?php
				if($lt->recom_idx){
					$lt_recom = substr($lt->recom_idx,0,-1);
					$lt_recom = explode(",",$lt_recom);
					foreach($lt_recom as $lm){
						echo $recom_arr[$lm]."<br>";
					}
				}
				else{
					echo "-";
				}
				?>
			</td>
			<td>
				<?=($lt->moreview_use == "Y")?"사용":"사용안함";?><br>
				<?if($lt->moreview_use == "Y"){ if($lt->detail){ ?><a href="/_data/file/subinfo/<?=$lt->detail?>" target="_blank"> [보기] </a><? }else{ ?><span class="dh_red">이미지 등록안됨</span><? } }?>
			</td>
			<td>
				<?if($lt->mobile_detail){ ?><a href="/_data/file/subinfo/<?=$lt->mobile_detail?>" target="_blank"> [보기] </a><? }else{ ?><span class="dh_red">이미지 등록안됨</span><? }?>
			</td>
			<td><?=($lt->foodtable_use == "Y")?"사용":"사용안함";?></td>
			<!-- <td><?=$lt->title_s?></td> -->
			<td>
				<input type="button" class="btn-sm" value="수정" onclick="location.href='<?=self_url()?>/update/<?=$lt->idx?>'">
				<input type="button" class="btn-sm btn-alert" value="삭제" onclick="if(confirm('삭제 하시겠습니까?')){location.href='<?=self_url()?>/delete/<?=$lt->idx?>'}">
			</td>
		</tr>
			<?php
			}
		}
		?>
	</tbody>
</table>

<div class="float-wrap mt20">
	<div class="float-r">
		<a href="<?=self_url()?>/insert/" class="button btn-ok">등록</a></span>
	</div>
</div>