<!-- <img src="/image/tmp/show2.png" alt=""> -->

<div class="local_sch02 local_sch">

    <div>
        <form method="post" action="?ajax=1">
					<strong>일일 생산량</strong>
					<input type="text" name="deliv_date" value="<?=date("Y-m-d",strtotime("+1 day"))?>" id="start_date" class="frm_input" maxlength="8">
					<label for="date">배송(일) 하루</label>
					<label><input type="checkbox" name="onlylist" value="1" <?=($this->input->post('onlylist') == "1")?"checked":"";?>>병합 출력</label>
					<input type="submit" value="확인" class="btn_submit">
        </form>
    </div>

    <!-- <div>
        <form name="" action="" method="">
        <strong>일간 생산량</strong>
        <input type="text" name="" value="" id="fr_date" required="" class="required frm_input hasDatepicker" size="8" maxlength="8">
        <label for="fr_date">배송(일) ~</label>
        <input type="text" name="to_date" value="" id="to_date" required="" class="required frm_input hasDatepicker" size="8" maxlength="8">
        <label for="to_date">배송(일)</label>
    		<label><input type="checkbox" name="" value="1">병합 출력</label>
        <input type="submit" value="확인" class="btn_submit">
        </form>
    </div>

    <div>
        <form name="" action="" method="">
        <strong>월간 생산량</strong>
        <input type="text" name="" value="" id="fr_month" required="" class="required frm_input" size="6" maxlength="6">
        <label for="fr_month">배송(월) ~</label>
        <input type="text" name="" value="" id="to_month" required="" class="required frm_input" size="6" maxlength="6">
        <label for="to_month">배송(월)</label>
    		<label><input type="checkbox" name="" value="1">병합 출력</label>
        <input type="submit" value="확인" class="btn_submit">
        </form>
    </div>

    <div class="sch_last">
        <form name="" action="" method="">
        <strong>연간 생산량</strong>
        <input type="text" name="" value="" id="fr_year" required="" class="required frm_input" size="4" maxlength="4">
        <label for="fr_year">배송(년) ~</label>
        <input type="text" name="" value="" id="to_year" required="" class="required frm_input" size="4" maxlength="4">
        <label for="to_year">배송(년)</label>
    		<label><input type="checkbox" name="" value="1">병합 출력</label>
        <input type="submit" value="확인" class="btn_submit">
        </form>
    </div> -->

</div>
