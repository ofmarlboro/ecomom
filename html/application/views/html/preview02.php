<?
	$PageName = "K03";
	$SubName = "K0303";
	include("../include/head.php");
	include("../include/header.php");
?>

<style>
  .content {
    background-color: #fff5d7;
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
    width: 298px;
    top: 1158px;
    left: 493px;
  }

  .preview_list .preview_btn.btn03 {
    width: 298px;
    top: 1158px;
    left: 815px;
  }

  .preview_list .preview_btn.btn04 {
    width: 298px;
    top: 1792px;
    left: 493px;
  }

  .preview_list .preview_btn.btn05 {
    width: 298px;
    top: 1792px;
    left: 815px;
  }

  .preview_list .preview_btn.btn06 {
    width: 298px;
    top: 2427px;
    left: 493px;
  }

  .preview_list .preview_btn.btn07 {
    width: 298px;
    top: 2427px;
    left: 815px;
  }

  .preview_list .preview_btn.btn08 {
    width: 298px;
    top: 3061px;
    left: 493px;
  }

  .preview_list .preview_btn.btn09 {
    width: 298px;
    top: 3061px;
    left: 815px;
  }

  .preview_list #set05{
    position: absolute;
    width: 100px;
    height: 2px;
    /* background-color: #f00; */
    top: 60%;
    left: 0;
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
      <img src="/image/sub/preview_list.jpg" alt="" class="preview_img">

      <a href="<?=$row->page1?$row->page1:"javascript:alert('준비중 입니다. : page1');";?>" class="preview_btn btn01"></a>
      <a href="<?=$row->page31?$row->page31:"javascript:alert('준비중 입니다. : page31');";?>" class="preview_btn btn02"></a>
      <a href="<?=$row->page32?$row->page32:"javascript:alert('준비중 입니다. : page32');";?>" class="preview_btn btn03"></a>
      <a href="<?=$row->page41?$row->page41:"javascript:alert('준비중 입니다. : page41');";?>" class="preview_btn btn04"></a>
      <a href="<?=$row->page42?$row->page42:"javascript:alert('준비중 입니다. : page42');";?>" class="preview_btn btn05"></a>
      <a href="<?=$row->page51?$row->page51:"javascript:alert('준비중 입니다. : page51');";?>" class="preview_btn btn06"></a>
      <a href="<?=$row->page52?$row->page52:"javascript:alert('준비중 입니다. : page52');";?>" class="preview_btn btn07"></a>
      <a href="<?=$row->page61?$row->page61:"javascript:alert('준비중 입니다. : page61');";?>" class="preview_btn btn08"></a>
	    <a href="<?=$row->page62?$row->page62:"javascript:alert('준비중 입니다. : page62');";?>" class="preview_btn btn09"></a>

      <div id="set05"></div>
    </div>

    <div class="thankyou">
      <img src="/image/sub/preview_list02.jpg" alt="" class="preview_img">
      <a href="/html/dh/thankyou"></a>
    </div>
  </div>
</div>

<?include("../include/footer.php");?>