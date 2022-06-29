					<p class="input__tit">시간 선택</p>
					<select name="time" msg="시간을">
						<option value="">시간을 선택해주세요.</option>
						<?php
						foreach($time_table as $tt){
							?>
							<!-- <option value="<?=$tt?>" <?=in_array($tt,$db_time_arr)?"disabled style='background:#ddd;'":"style=''";?>><?=$tt?></option> -->
							<option value="<?=$tt?>" <?=$db_time_arr[$tt] >= 2?"disabled style='background:#ddd;'":"style=''";?>><?=$tt?></option>
							<?php
						}
						?>
					</select>