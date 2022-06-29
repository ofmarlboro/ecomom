<!doctype html>
<html lang="ko">
 <head>
  <title>에코맘 산골이유식 : 추천식단정보</title>
	<meta http-equiv="Content-Type" content="text/html; charset=utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=Edge">

	<link type="text/css" rel="stylesheet" href="//cdn.rawgit.com/hiun/NanumSquare/master/nanumsquare.css" />
	<link type="text/css" rel="stylesheet" href="/css/@default.css?t=<?php echo time(); ?>" />
	<script type="text/javascript" src="/js/jquery-1.9.1.min.js"></script>
	<script type="text/javascript" src="/js/jquery.easing.min.js"></script>
	<script type="text/javascript" src="/js/placeholders.min.js"></script>
	<script type="text/javascript" src="/js/imagesloaded.pkgd.min.js"></script>
	<script type="text/javascript" src="/js/slick.min.js"></script>
	<script type="text/javascript" src="/js/setting.js?t=<?php echo time(); ?>"></script>
	<script type="text/javascript" src="/js/common.js?t=<?php echo time(); ?>"></script>
	<script type="text/javascript" src="/_data/js/form.js?t=<?php echo time(); ?>"></script>
	<style type="text/css">
	
		.cntzero{
			background:#eee;
		}
.tit_hj {padding-top: 20px;background: #105F5F;color: #fff;line-height: 45px;font-size: 30px; padding-left: 20px;margin-bottom: 10px;}
		
.recomcart {border: 0;border-top: 1px solid #000; width: 95%;margin:0 2.5%;background: #fff;}
.recomcart td { text-align: left;    vertical-align: text-bottom;
font-weight: 600;line-height: 20px;
border-right:  1px solid #ddd;border-bottom: 1px solid #ddd;
color: #666; padding: 12px 20px;font-weight: normal; font-size: 14px;}
.recomcart th {background: #FAFAFA; color: #222;border-bottom: 1px solid #ddd;padding: 12px 0;
border-right:  1px solid #ddd; font-weight: normal; font-size: 14px;}
.recomcart tr td:last-child {border-right: 0;text-align: center;}
.recomcart tr th:last-child {border-right: 0;}
.recomcart td img {width: 50px;}

.cclose .btn {position: absolute;top: 30px;right: 20px;background: ;}
	</style>
 </head>
 <body style="background: #105F5F;position: relative;padding-bottom: 20px;">

	<h1 class="tit_hj">식단정보</h1>

	<table width="100%" border="1" cellpadding="3" cellspacing="1" id="recomcart" class="recomcart">
		<tr>
			<th>배송일</th>
			<th>상품정보</th>
			<th>수량</th>
		</tr>
		<?php
		foreach($recom_foods_list as $date=>$rf){
			$rf_cnt = 0;
			$rf_arr_cnt = count($rf);
			foreach($rf as $rfl){
				$rf_cnt++;

				$goods_idx = $rfl['goods_idx'];
				$list_img = $goods_info[$goods_idx]['list_img'];
				$name = $goods_info[$goods_idx]['name'];
			?>
			<tr>
				<td data-value="<?=$date?>"><?=date("Y-m-d",$date)?> (<?=numberToWeekname(date("Y-m-d",$date))?>)</td>
				<td class="<?=($rfl['prod_cnt'] > 0)?"cntitsm":"cntzero";?>">
					<?php
					if($list_img){
					?>
					<img src="/_data/file/goodsImages/<?=$list_img?>" style="max-width:100px;vertical-align:middle">
					<?php
					}

					echo $name;
					?>
				</td>
				<td class="<?=($rfl['prod_cnt'] > 0)?"cntitsm":"cntzero";?>"><?=$rfl['prod_cnt']?> 팩</td>
			</tr>
			<?php
			}
		}
		?>
	</table>

	<p class="cclose">
		
		<a href="#" class="btn" onclick="self.close();"><img src="/image/main/close02.png" alt=""></a>
	</p>
	<script type="text/javascript">
	<!--
		$(function(){
			$("#recomcart").rowspan(0);
		});
	//-->
	</script>
 </body>
</html>
