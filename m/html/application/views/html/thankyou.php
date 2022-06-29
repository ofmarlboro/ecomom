<?
	$PageName = "K07";
	$SubName = "K0706";
	include("../include/head.php");
	include("../include/header.php");
?>

<style>
	.thankyou_wrap{
		padding-bottom: 75px;
	}
	.thankyou_wrap img{
		display: block;
	}
  .thankyou_form{
    width: 100%;
    margin-left: auto;
    margin-right: auto;
    background-color: #fafafa;
    display: flex;
    justify-content: space-between;
    align-items: center;
    padding: 0 20px;
    box-sizing: border-box;
  }

  .thankyou_form p{
    font-size: 14px;
    color: #5f5f5f;
    font-weight: 600;
  }
  .thankyou_form input{
    height: 40px;
    line-height: 40px;
    padding: 0 15px;
    font-size: 17px;
    color: #000;
    border: 1px solid #000;
    border-radius: 4px;
    background-color: #fff;
    width: 100%;
	flex: 1;
	margin-right:10px;
    box-sizing: border-box;
  }
  .thankyou_form button{
    width: 75px;
    line-height: 38px;
    height: 40px;
    color: #fff;
    font-weight: 600;
    font-size: 17px;
    background-color: #a37d28;
    border: 1px solid #a37d28;
    border-radius: 4px;
    cursor: pointer;
    letter-spacing: -.1em;
  }
</style>
<!--Container-->
<div id="container">
  <?include("../include/top_menu.php");?>
  <div class="inner ac" style="margin:0px;">
			<img src="/image/sub/thankyou_img01.jpg" alt="">

			<form method="post" name="frm">
			<!-- 회원 로그인 정보 -->
			<input type="hidden" name="user_id" value="<?=$this->session->userdata('USERID')?>">
			<input type="hidden" name="user_name" value="<?=$this->session->userdata('NAME')?>">

      <div class="thankyou_form">
        <input type="text" name="trade_code" <?=$this->session->userdata('USERID') == ""?'onfocus="loginid_chk()"':"";?>>
        <button type="button" onclick="send_form()">신청</button>
      </div>

			</form>

      <img src="/image/sub/thankyou_img02.jpg" alt="">
      <a href="/html/dh/event03">
        <img src="/image/sub/thankyou_img03.jpg" alt="">
      </a>
	</div>
</div>

<script type="text/javascript">
	function loginid_chk(){
		document.frm.trade_code.blur();
		alert("로그인 이후 이용가능합니다.");
		location.href="/m/html/dh_member/login/?go_url=<?=$_SERVER['REDIRECT_URL']?>";
	}

	function send_form(){
		frm = document.frm;
		if(frm.trade_code.value == ''){
			alert("주문번호를 입력해주세요.");
			frm.trade_code.focus();
			return;
		}
		frm.submit();
	}
</script>

<?include("../include/footer.php");?>