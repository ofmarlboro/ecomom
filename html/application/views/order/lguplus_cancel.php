 <script type="text/javascript">
	// 취소 버튼을 눌렀을 때 호출
		function card_cancel(trade_code,tno)
		{
			var url = "";

			<? if(isset($flag) && $flag=="admin" && $this->session->userdata('ADMIN_USERID')){ ?>
			url = "&a1a1admin";
			<?}?>

			document.ini.go_url.value="<?=cdir()?>/dh_order/shop_order_cancel/"+trade_code+"/cancel_list/<?=$query_string.$param?>"+url;
			document.ini.LGD_TID.value=tno;
			document.ini.submit();

		}
</script>

<form method="post" name=ini id="LGD_PAYINFO" action="/pay/uplus/Cancel.php">
<input type="hidden" name="CST_MID" value="<?=$shop_info['pg_id']?>"/>
<input type="hidden" name="CST_PLATFORM" value="<?=($shop_info['lgu_test'] == "ok")?"test":"service";?>"/>
<input type="hidden" name="LGD_TID">
<input type="hidden" name="go_url">
</form>