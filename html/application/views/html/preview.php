<?
	$PageName = "K02";
	$SubName = "K0207";
	include("../include/head.php");
	include("../include/header.php");
?>

<style>
  .content {
    background-color: #f6eac5;
  }

  .preview_list {
    position: relative;
    width: 1607px;
    margin-left: auto;
    margin-right: auto;
  }

  .preview_list .preview_btn {
    position: absolute;
    cursor: pointer;
    z-index: 1;
    height: 424px;
    /* background-color: #f00; */
  }

  .preview_list .preview_btn.btn01 {
    width: 619px;
    left: 50%;
    transform: translateX(-50%);
    top: 521px;
  }

  .preview_list .preview_btn.btn02 {
    width: 619px;
    left: 50%;
    transform: translateX(-50%);
    top: 1153px;
  }

  .preview_list .preview_btn.btn03 {
    width: 298px;
    top: 1789px;
    left: 493px;
  }

  .preview_list .preview_btn.btn04 {
    width: 298px;
    top: 1789px;
    left: 815px;
  }

  .preview_list .preview_btn.btn05 {
    width: 298px;
    top: 2423px;
    left: 493px;
  }

  .preview_list .preview_btn.btn06 {
    width: 298px;
    top: 2423px;
    left: 815px;
  }

  .preview_list .preview_btn.btn07 {
    width: 298px;
    top: 3058px;
    left: 493px;
  }

  .preview_list .preview_btn.btn08 {
    width: 298px;
    top: 3058px;
    left: 815px;
  }

  .preview_list .preview_btn.btn09 {
    width: 298px;
    top: 3692px;
    left: 493px;
  }

  .preview_list .preview_btn.btn10 {
    width: 298px;
    top: 3692px;
    left: 815px;
  }

  .preview_list .preview_btn.btn11 {
    width: 619px;
    top: 4331px;
	height:890px;
	left: 50%;
    transform: translateX(-50%);
  }

  .thankyou {
    margin-top: -60px;
    position: relative;
    z-index: 2;
  }

  .thankyou>img {
    display: block;
    margin-left: auto;
    margin-right: auto;
  }


  .thankyou>a {
    position: absolute;
    cursor: pointer;
    z-index: 1;
    left: 50%;
    bottom: 184px;
    transform: translateX(-50%);
    height: 90px;
    width: 418px;
  }
</style>
<!--Container-->
<div id="container">
  <?php include("../include/sub_top.php");?>
  <div class="content">
    <div class="preview_list">
      <!-- <img src="/image/sub/preview_list.jpg" alt="" class="preview_img"> -->
      <img src="/image/sub/preview_list_220405.jpg" alt="" class="preview_img">

      <a href="<?=$row->page7?$row->page7:"javascript:alert('준비중 입니다.');";?>" class="preview_btn btn01"></a>
      <a href="<?=$row->page1?$row->page1:"javascript:alert('준비중 입니다.');";?>" class="preview_btn btn02"></a>
      <a href="<?=$row->page31?$row->page31:"javascript:alert('준비중 입니다.');";?>" class="preview_btn btn03"></a>
      <a href="<?=$row->page32?$row->page32:"javascript:alert('준비중 입니다.');";?>" class="preview_btn btn04"></a>
      <a href="<?=$row->page41?$row->page41:"javascript:alert('준비중 입니다.');";?>" class="preview_btn btn05"></a>
      <a href="<?=$row->page42?$row->page42:"javascript:alert('준비중 입니다.');";?>" class="preview_btn btn06"></a>
      <a href="<?=$row->page51?$row->page51:"javascript:alert('준비중 입니다.');";?>" class="preview_btn btn07"></a>
      <a href="<?=$row->page52?$row->page52:"javascript:alert('준비중 입니다.');";?>" class="preview_btn btn08"></a>
      <a href="<?=$row->page61?$row->page61:"javascript:alert('준비중 입니다.');";?>" class="preview_btn btn09"></a>
			<a href="<?=$row->page62?$row->page62:"javascript:alert('준비중 입니다.');";?>" class="preview_btn btn10"></a>
			<a href="/html/dh/thankyou" class="preview_btn btn11"></a>
    </div>
  </div>
</div>

<?include("../include/footer.php");?>