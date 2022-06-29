<?
	$PageName = "K02";
	$SubName = "K0206";
	$PageTitle = "산골 맛보기 특가세트";
	include('../include/head.php');
	include('../include/header.php');
?>

<style>
  .content {
    background-color: #f6eac5;
    margin: 0;
    padding: 0;
    width: 100%;
  }

  .preview_list {
    position: relative;
    width: 100%;
  }

  .preview_list .preview_img {
    width: 100%;
  }

  .preview_list .preview_btn {
    position: absolute;
    cursor: pointer;
    height: 0;
    z-index: 1;
    padding-top: 62.6%;
    /* background-color: #f00; */
  }

  .preview_list .preview_btn.btn01 {
    width: 90%;
    left: 50%;
    transform: translateX(-50%);
    top: 8%;
  }

  .preview_list .preview_btn.btn02 {
    width: 90%;
    left: 50%;
    transform: translateX(-50%);
    top: 20%;
  }


  .preview_list .preview_btn.btn03 {
    width: 43.5%;
    top: 32%;
    left: 5%;
  }

  .preview_list .preview_btn.btn04 {
    width: 43.5%;
    top: 32%;
    right: 5%;
  }

  .preview_list .preview_btn.btn05 {
    width: 43.5%;
    top: 44%;
    left: 5%;
  }

  .preview_list .preview_btn.btn06 {
    width: 43.5%;
    top: 44%;
    right: 5%;
  }

  .preview_list .preview_btn.btn07 {
    width: 43.5%;
    top: 56%;
    left: 5%;
  }

  .preview_list .preview_btn.btn08 {
    width: 43.5%;
    top: 56%;
    right: 5%;
  }

  .preview_list .preview_btn.btn09 {
    width: 43.5%;
    top: 68%;
    left: 5%;
  }

  .preview_list .preview_btn.btn10 {
    width: 43.5%;
    top: 68%;
    right: 5%;
  }

.preview_list .preview_btn.btn11 {
    width: 90%;
    left: 50%;
    transform: translateX(-50%);
  top: 80.2%;
  padding-top: 132% !important;
  }

</style>
<!--Container-->
<div id="container">
	<?include("../include/top_menu.php");?>

  <div class="content">
    <div class="preview_list">
      <!-- <img src="/image/sub/preview_list_m.jpg" alt="" class="preview_img"> -->
      <img src="/image/sub/preview_list_m_220405.jpg" alt="" class="preview_img">

			<a href="<?=$row->mpage7?$row->mpage7:"javascript:alert('준비중 입니다.');";?>" class="preview_btn btn01"></a>
			<a href="<?=$row->mpage1?$row->mpage1:"javascript:alert('준비중 입니다.');";?>" class="preview_btn btn02"></a>
			<a href="<?=$row->mpage31?$row->mpage31:"javascript:alert('준비중 입니다.');";?>" class="preview_btn btn03"></a>
			<a href="<?=$row->mpage32?$row->mpage32:"javascript:alert('준비중 입니다.');";?>" class="preview_btn btn04"></a>
			<a href="<?=$row->mpage41?$row->mpage41:"javascript:alert('준비중 입니다.');";?>" class="preview_btn btn05"></a>
			<a href="<?=$row->mpage42?$row->mpage42:"javascript:alert('준비중 입니다.');";?>" class="preview_btn btn06"></a>
			<a href="<?=$row->mpage51?$row->mpage51:"javascript:alert('준비중 입니다.');";?>" class="preview_btn btn07"></a>
			<a href="<?=$row->mpage52?$row->mpage52:"javascript:alert('준비중 입니다.');";?>" class="preview_btn btn08"></a>
			<a href="<?=$row->mpage61?$row->mpage61:"javascript:alert('준비중 입니다.');";?>" class="preview_btn btn09"></a>
			<a href="<?=$row->mpage62?$row->mpage62:"javascript:alert('준비중 입니다.');";?>" class="preview_btn btn10"></a>
			<a href="/m/html/dh/thankyou" class="preview_btn btn11"></a>


    </div>

  </div>
</div>

<? include('../include/footer.php') ?>