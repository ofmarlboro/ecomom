<?
	$PageName = "";
	$SubName = "";
	include("../include/head.php");
	include("../include/header.php");
?>


<!--Container-->

<script type="text/javascript">
	function frmchk(frm){
		if(frm.name.value == ''){
			alert("성함을 입력해주세요.");
			frm.name.focus();
			return false;
		}
		if(frm.phone.value == ''){
			alert("연락처를 입력해주세요.");
			frm.phone.focus();
			return false;
		}
		if(frm.addr1.value == ''){
			alert("배송지를 입력해주세요.");
			frm.addr1.focus();
			return false;
		}
		if(frm.addr2.value == ''){
			alert("배송지를 입력해주세요.");
			frm.addr2.focus();
			return false;
		}
		if(frm.snsurl.value == ''){
			alert("SNS 운영링크를 입력해주세요.");
			frm.snsurl.focus();
			return false;
		}
	}
</script>

<div id="container">
  <div class="exp-page">
    <div class="inner ac pt60">
      <div class="exp-form">
        <img src="/image/sub/exp_logo.png" alt="">
        <h1><?=$row->name?></h1>

        <form name="frm" id="frm" method="post" onsubmit="return frmchk(this)">
				<input type="hidden" name="goods_idx" value="<?=$row->idx?>">
				<input type="hidden" name="goods_name" value="<?=$row->name?>">
				<input type="hidden" name="userid" value="<?=$this->session->userdata('USERID')?>">
          <ul>
            <li class="exp-form__lnline">
              <p>성함</p>
              <input type="text" name="name">
            </li>
            <li class="exp-form__lnline">
              <p>연락처</p>
              <input type="text" name="phone">
            </li>
            <li>
              <p>체험제품 배송지</p>
							<input type="hidden" id="zipcode1" name="post">
              <input type="text" name="addr1" id="address1" onclick="sample6_execDaumPostcode()" readonly>
              <input type="text" name="addr2" id="address2">
            </li>
            <li>
              <p>SNS 운영링크 </p>
              <input type="text" name="snsurl">
              <p class="exp-from__msg">*본인계정 아닐 시 법적인 책임을 물을 수 있습니다.</p>
            </li>
          </ul>
          <button type="submit">신청하기</button>
        </form>
      </div>
    </div>
  </div>
</div>
<!--END Container-->



<?include("../include/footer.php");?>