<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dh extends CI_Controller {

 	function __construct()
	{
		parent::__construct();
    $this->load->model('member_m');
    $this->load->model('product_m');
    $this->load->model('board_m');
    $this->load->model('order_m');
		$this->load->helper('form');

		$this->m = $this->common_m;

		if(!$this->input->get('file_down')){
			@header("Content-Type: text/html; charset=utf-8");
		}
	}


	public function index($data)
	{
		$this->main($data);
  }

	public function _remap($method) //모든 페이지에 적용되는 기본 설정.
	{
		if($_GET['pcv'] == "N"){
			$ss = array('MCHK'=>'');
			$this->session->set_userdata($ss);
			alert("/html/dh/main");
		}

		$data['deliv_extend'] = $this->common_m->not_deliv_arr();

		$data['shop_info'] = $this->common_m->shop_info(); //shop 정보
		$data['cate_data'] = $this->product_m->header_cate(); //헤더에 보여질 모든 카테고리 리스트

		if($this->session->userdata('USERID')){
			$data['member_info'] = $this->common_m->self_q("select * from dh_member where userid = '".$this->session->userdata('USERID')."'","row");
		}

		$Qs = $_SERVER['QUERY_STRING'];

		if($data['shop_info']['mobile_use']=="y"){
			$this->common_m->defaultChk($Qs);
		}

		$dev_arr = $this->common_m->devel_array();
		$arr = in_array($method, $dev_arr);


		if($arr || $this->input->get('ajax') == 1){ //개발 페이지 일때

			$this->{"{$method}"}($data);

		}else{ //기타 디자인페이지 일때 자동 출력

			$p = $this->uri->segment(2);
			if($p){

				if($p == 'exp_apply'){
					$idx = $this->uri->segment(3);
					$data['row'] = $this->common_m->self_q("select * from dh_goods where idx = '{$idx}'","row");

					if($_POST){
						$cnt = $this->common_m->self_q("select * from dh_exp_apply where goods_idx = '".$this->input->post('goods_idx')."' and userid = '".$this->input->post('userid')."'","cnt");
						if($cnt){
							alert("/","이미 신청하신 내역이 있습니다.");
						}

						if(!$this->input->post('userid')){
							alert("/","로그인 후 이용해주세요.");
						}

						$insert['goods_idx'] = $this->input->post('goods_idx');
						$insert['goods_name'] = $this->input->post('goods_name');
						$insert['userid'] = $this->input->post('userid');
						$insert['name'] = $this->input->post('name');
						$insert['phone'] = $this->input->post('phone');
						$insert['post'] = $this->input->post('post');
						$insert['addr1'] = $this->input->post('addr1');
						$insert['addr2'] = $this->input->post('addr2');
						$insert['snsurl'] = $this->input->post('snsurl');
						$insert['wdate'] = timenow();

						$result = $this->common_m->insert2("dh_exp_apply",$insert);
						if($result){
							alert("/","신청이 완료 되었습니다.");
						}
					}
				}

				if($p == 'deposit_return'){

					if($_POST){
						$userid = $this->session->userdata('USERID');

						if(!$userid){
							alert(cdir()."/dh_member/login?go_url=".$_SERVER['REDIRECT_URL'],"로그인 정보를 확인할 수 없습니다. 로그인 후 이용해주세요.");
						}
						else{
							$dps_return['userid'] = $userid;
							$dps_return['return_deposit'] = str_replace(",","",$this->input->post('return_deposit'));
							$dps_return['return_bank'] = $this->input->post('return_bank');
							$dps_return['return_account'] = $this->input->post('return_account');
							$dps_return['return_accname'] = $this->input->post('return_accname');
							$dps_return['state'] = '승인대기';
							$dps_return['wdate'] = timenow();

							$result = $this->common_m->insert2("dh_deposit_return",$dps_return);

							if($result){
								$dps['userid'] = $userid;
								$dps['point'] = "-".str_replace(",","",$this->input->post('return_deposit'));
								$dps['content'] = "예치금 환불 신청";
								$dps['reg_date'] = timenow();

								$result = $this->common_m->insert2("dh_deposit",$dps);

								if($result){
									alert($_SERVER['HTTP_REFERER'],"환불신청이 완료 되었습니다.");
								}
							}
							else{
								alert($_SERVER['HTTP_REFERER'],"처리중 오류가 발생하였습니다.");
							}
						}
					}

					$deposit = $this->common_m->self_q("select sum(point) as dps from dh_deposit where userid = '".$this->session->userdata('USERID')."'","row");
					$data['total_deposit'] = $deposit->dps;

					$where_sql = "where userid = '".$this->session->userdata('USERID')."'";

					$total_rows = $this->common_m->self_q("select count(*) as total_rows from dh_deposit_return {$where_sql}","row");

					$sql = "select * from dh_deposit_return {$where_sql}";

					$PageNumber = $this->input->get("PageNumber");
					if(!$PageNumber) $PageNumber = 1;
					$list_num = 15;
					$page_num = 5;
					$offset = $list_num*($PageNumber-1);
					$url = self_url();
					$data['totalCnt'] = $total_rows->total_rows;
					$data['Page'] = Page($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['qs']);
					$data['listNo'] = $data['totalCnt']-$list_num*($PageNumber-1);
					$sql .= " order by idx desc limit {$offset},{$list_num}";

					$data['list'] = $this->common_m->self_q($sql,"result");
				}

				if($p == 'deposit_list'){
					$deposit = $this->common_m->self_q("select sum(point) as dps from dh_deposit where userid = '".$this->session->userdata('USERID')."'","row");
					$data['total_deposit'] = $deposit->dps;

					//검색
						$sdate = $this->input->get('sdate');
						$edate = $this->input->get('edate');
						$type = $this->input->get('type');

						$data['qs'] = '?';

						$where_sql = "where userid = '".$this->session->userdata('USERID')."'";

						if($sdate && $edate){
							$data['qs'] .= "&sdate={$sdate}&edate={$edate}";
							$where_sql .= " and date_format(reg_date,'%Y-%m-%d') between '{$sdate}' and '{$edate}'";
						}
						else if($sdate){
							$edate = date("Y-m-d");
							$data['qs'] .= "&sdate={$sdate}&edate={$edate}";
							$where_sql .= " and date_format(reg_date,'%Y-%m-%d') between '{$sdate}' and '{$edate}'";
						}

						if($type){
							$data['qs'] .= "&type={$type}";
							if($type == 'all'){
								$where_sql.= '';
							}
							else if($type == 'pl'){
								$where_sql.= " and point > 0";
							}
							else if($type == 'mn'){
								$where_sql.= " and point < 0";
							}
						}
					//검색

					$total_rows = $this->common_m->self_q("select count(*) as total_rows from dh_deposit {$where_sql}","row");

					$sql = "select * from dh_deposit {$where_sql}";
					$PageNumber = $this->input->get("PageNumber");
					if(!$PageNumber) $PageNumber = 1;
					$list_num = 15;
					$page_num = 5;
					$offset = $list_num*($PageNumber-1);
					$url = self_url();
					$data['totalCnt'] = $total_rows->total_rows;
					$data['Page'] = Page($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['qs']);
					$data['listNo'] = $data['totalCnt']-$list_num*($PageNumber-1);
					$sql .= " order by idx desc limit {$offset},{$list_num}";

					$data['list'] = $this->common_m->self_q($sql,"result");
				}

				if($p == 'deposit'){
					$deposit = $this->common_m->self_q("select sum(point) as dps from dh_deposit where userid = '".$this->session->userdata('USERID')."'","row");
					$data['total_deposit'] = $deposit->dps;
					$data['list'] = $this->common_m->self_q("select * from dh_deposit where userid = '".$this->session->userdata('USERID')."' order by idx desc limit 5","result");
					$data['return_list'] = $this->common_m->self_q("select * from dh_deposit_return where userid = '".$this->session->userdata('USERID')."' order by idx desc limit 5","result");
				}

				if($p == 'thankyou'){
					if($_POST){
						$insert_data['userid'] = $this->input->post('user_id');
						$insert_data['name'] = $this->input->post('user_name');
						$insert_data['trade_code'] = strtoupper($this->input->post('trade_code'));
						$insert_data['wdate'] = timenow();

						$result = $this->common_m->insert2("dh_thanku",$insert_data);
						if($result){
							alert($_SERVER['HTTP_REFERER'],"신청감사합니다\\n주문내역 확인 후\\n정기배송 4주 완료 확인 후\\n적립해드립니다.");
						}
					}
				}

				if($p == 'preview02'){
					$data['row'] = $this->common_m->self_q("select * from dh_set_page where idx = 1","row");
				}

				if($p == 'preview'){
					$data['row'] = $this->common_m->self_q("select * from dh_set_page where idx = 1","row");
				}

				if($p == 'event04_order_ok'){
					if($_POST){
						//사용된 쿠폰여부 검증
						$coupon_code = strtoupper($this->input->post('coupon_code'));
						$cnt = $this->common_m->self_q("select * from dh_coupon_two where code = '{$coupon_code}' and status = 1","cnt");
						if($cnt){
							alert("/","이미 사용된 쿠폰입니다.");
						}
						//사용된 쿠폰여부 검증

						$result = $this->order_m->coupon_order();
						if($result){
							alert("/html/dh_order/shop_order_ok/".$result);
						}
					}
				}

				if($p == 'event04_order_ing'){
					$data['week_name_arr'] = array('일','월','화','수','목','금','토');
					$data['recom_info'] = $this->common_m->self_q("select * from dh_recom_food where idx = '".$this->input->post('recom_idx')."'","row");
					$data['food_info'] = unserialize($data['recom_info']->food_info);
					$recom_cate = explode("^",substr($data['recom_info']->recom_cate,0,-1));
					$in_sql = "";
					foreach($recom_cate as $rc){
						$in_sql .= "'".$rc."',";
					}
					$in_sql = substr($in_sql,0,-1);
					$data['goods'] = $this->common_m->self_q("select * from dh_goods where cate_no in (".$in_sql.")","result");
					$data['gansik'] = $this->common_m->self_q("select * from dh_goods where cate_no = '8' and display = '1' order by ranking asc, idx asc","result");

					$holiday_data = $this->common_m->self_q("select * from dh_deliv_holi where date_format(holiday,'%Y') = '".date('Y')."'","result");
					$holiday_arr = array();
					foreach($holiday_data as $holi){
						$holiday_arr[] = $holi->holiday;
					}

					$data['holiday_arr'] = $holiday_arr;

					$member_info = $this->common_m->self_q("select * from dh_member where userid = '".$this->session->userdata('USERID')."'","row");
					$member_addr_key_arr = array("home"=>"자택:","sidc"=>"시댁:","chin"=>"친정:","bomo"=>"보모:");
					$member_addr_arr = array();
					if($member_info->add1) $member_addr_arr["home"] = $member_info->add1." ".$member_info->add2;
					if($member_info->sidc_add1) $member_addr_arr["sidc"] = $member_info->sidc_add1." ".$member_info->sidc_add2;
					if($member_info->chin_add1) $member_addr_arr["chin"] = $member_info->chin_add1." ".$member_info->chin_add2;
					if($member_info->bomo_add1) $member_addr_arr["bomo"] = $member_info->bomo_add1." ".$member_info->bomo_add2;

					$data['member_addr_key_arr'] = $member_addr_key_arr;
					$data['member_addr_arr'] = $this->user_addrs();
				}

				if($p == 'event04_order'){
					if($_POST){	//쿠폰 검증 로직 쿠폰값 $_POST['coupon_code']
						$coupon = strtoupper($this->input->post('coupon_code'));
						$cnt = $this->common_m->self_q("select * from dh_coupon_two where code = '{$coupon}' and status != 1","cnt");
						if($cnt){	//쿠폰이 유효할 경우
							//쿠폰 앞 4자리 잘라서 단계 추출 및 주차 추출
							/*
								CHO : 초기
								JUN : 중기
								HUG : 후기 3식
								YOA : 완료기
								BAN : 반찬국
								2 / 4 : 2 / 4 주
								모든메뉴 6일분 고정 // 주 2회 배송만 노출
							*/
							$stepkey = substr($coupon,0,4);
							$step_code = substr($stepkey,0,3);
							$step_week = substr($stepkey,3,1);

							$recom_arr = array('CHO'=>'4','JUN'=>'5','HUG'=>'1','YOA'=>'7','BAN'=>'3');
							$recom_name_arr = array('CHO'=>'초기','JUN'=>'중기','HUG'=>'후기','YOA'=>'완료기','BAN'=>'반찬국');

							$data['step_code'] = $step_code;
							$data['recom_idx'] = $recom_idx = $recom_arr[$step_code];
							$data['recom_name'] = $recom_name_arr[$step_code];

							$recom_info = $this->common_m->self_q("select * from dh_recom_food where idx like '".$recom_idx."%'","row");
							$fi = unserialize($recom_info->food_info);

							$data['food_info'] = $fi[6];

							$data['delivery_week_day_count'] = $fi[6]['val'].":".$fi[6]['count']."@".$fi[6]['pcount'];
							$data['delivery_week_count'] = $step_week;

							$data['allergy_arr'] = array('13'=>'소고기','12'=>'닭고기','1'=>'달걀','2'=>'우유','6'=>'콩');

						}
						else{
							alert("/html/dh_board/lists/withcons07/?myqna=Y","유효하지 않은 쿠폰번호 입니다. 1:1 문의를 통해 문의해주세요");
						}
					}
				}

				if($p == 'naver_pay_cancel'){

					if($this->input->post('trade_code')){
						$trade = $this->common_m->self_q("select * from dh_trade where trade_code='".$this->input->post('trade_code')."'","row");
						$trade_result = $this->common_m->naver_pay_cancel($this->input->post('trade_code'),$trade->paymentId,$trade->total_price,"테스트중"); //결제 취소
						//$trade_result = $this->common_m->naver_pay_info($this->input->post('trade_code'),$trade->paymentId,$trade->total_price,"테스트중"); //결제 승인

						pr($trade_result);
						exit;
					}
				}

				if($p == 'counsel'){
					$data['agree'] = $this->common_m->self_q("select * from dh_page where page_index = 'safeguard'","row");

					if($_POST){

						$cnt = $this->common_m->self_q("select * from dh_reserv_bp where name = '".$this->input->post("name")."' and phone = '".$this->input->post('phone')."'","cnt");
						if($cnt){
							back("이미 신청하셨습니다. 중복신청은 불가능합니다");
						}

						$dbin['date'] = $this->input->post("date", true);
						$dbin['time'] = $this->input->post("time", true);
						$dbin['name'] = $this->input->post("name", true);
						$dbin['phone'] = $this->input->post("phone", true);
						$dbin['wdate'] = timenow();

						$msg = date("m월 d일",strtotime($dbin['date']))." ".$dbin['time']."시에 예약이 완료되었습니다.\\n변경을 원하시면 고객센터 1522-3176로 문의주세요.";

						$result = $this->common_m->insert2("dh_reserv_bp",$dbin);
						if($result){
							$token = $this->kkoat_m->token_generation();

							$phone = str_replace($find,$chng,$dbin['phone']);
							$name = $dbin['name'];
							$find = array('-',' ','.');
							$chng = array('','','');
							$add1 = date("Y년 m월 d일",strtotime($dbin['date']));
							$add2 = " ".$dbin['time'];

							$msg = "{$name}님,\n{$add1}{$add2}에 \n상담예약이 신청되었습니다.\n\n예약시간 이후 방문하시면\n대기시간이 생길 수 있는점\n양해 부탁드립니다(__)\n\n에코맘의 산골이유식";
							$tmpcode = "M_01459_200";
							$this->kkoat_m->ent_prise_kakao_send($token,$phone,$msg,$tmpcode);


							alert($_SERVER['HTTP_REFERER'],$msg);
						}
					}
				}

				if($p=='identity02'){
					if($_POST){
						$phone = $this->input->post('mobileno');	//휴대폰번호
						//휴대폰 번호 기준 회원 산출

						$cnt = $this->common_m->self_q("select * from dh_member where concat(phone1,phone2,phone3) = '{$phone}' and di != 'offline'","cnt");

						if($cnt){
							$data['list'] = $this->common_m->self_q("select * from dh_member where concat(phone1,phone2,phone3) = '{$phone}' and di != 'offline'","result");
						}
						else{
							alert("/","고객님의 휴대폰 번호로 가입된 회원정보가 없습니다.\n회원가입시 휴대폰번호를 기입하지 않으신경우 1대1 문의를 통해 진행해주세요.");
						}
					}
					else{
						alert("/html/dh/identity","인증값이 전달되지 않았습니다.");
					}
				}

				if($p == "event02"){
					$code = 'insta1';
					$sql = "select *,(select name from dh_banner2 where code = dh_bannerlist2.parent_code) as banner_title from dh_bannerlist2 where parent_code = '{$code}' and addinfo4 = 'used' order by sort asc limit 12";
					$data[$code] = $this->common_m->self_q($sql,"result");

					$code = 'insta2';
					$sql = "select *,(select name from dh_banner2 where code = dh_bannerlist2.parent_code) as banner_title from dh_bannerlist2 where parent_code = '{$code}' and addinfo4 = 'used' order by sort asc limit 12";
					$data[$code] = $this->common_m->self_q($sql,"result");

					$code = 'insta3';
					$sql = "select *,(select name from dh_banner2 where code = dh_bannerlist2.parent_code) as banner_title from dh_bannerlist2 where parent_code = '{$code}' and addinfo4 = 'used' order by sort asc limit 12";
					$data[$code] = $this->common_m->self_q($sql,"result");
				}

				if($p == "intro000"){
					$sql = "select *,(select name from dh_banner_cate where dh_banner_cate.idx = dh_bannerlist2.addinfo5) as cate_name from dh_bannerlist2 where parent_code = 'depart' and addinfo4 = 'used' order by sort asc";
					$data['banner'] = $this->common_m->self_q($sql,"result");
					$data['bb_Arr'] = array("<b>","</b>");
					$data['sr_Arr'] = array("<strong>","</strong>");
					if($this->uri->segment(3) != ""){
						$data['open_view_no'] = $this->uri->segment(3);
					}
					$data['cate'] = $this->m->self_q("select * from dh_banner_cate order by ranking asc, idx desc","result");
				}

				if($p == "rcmd"){
					$sql = "select sum(point) as ttp from dh_point where userid = '".$this->session->userdata('USERID')."' and flag = 'recom'";
					$data['total_point'] = $this->common_m->self_q($sql,"row");

					$data['list'] = $this->common_m->self_q("select a.* , b.*, (select goods_name from dh_trade_goods where trade_code = a.trade_code and cate_no = 'recom') as gname, (select count(idx) from dh_trade_goods where trade_code = a.trade_code) as gt from dh_point a left join dh_trade b on a.trade_code = b.trade_code where a.userid = '".$this->session->userdata('USERID')."' and a.flag = 'recom'","result");
				}

				if($p == "farmer_list"){
					$data['banners'] = $this->common_m->self_q("select * from dh_bannerlist where parent_code = 'pc_farmlist' order by idx desc limit 1","result");
				}

				if($p == "wc02"){
					$sql = "select * from dh_goods order by idx desc";
					$goods = $this->common_m->self_q($sql,"result");
					$idx_to_img = array();
					foreach($goods as $g){
						$idx_to_img[$g->idx] = $g->list_img;
					}
					$data['idx_to_img'] = $idx_to_img;
				}

				if($p == "event01"){
					//배너 통합
					$data['banners'] = $this->common_m->self_q("select * from dh_bannerlist where parent_code in ('pc_event_top','pc_event_bottom') order by sort asc","result");
				}

				if($p == "info02"){
					$data['content'] = $this->common_m->self_q("select * from dh_page where page_index = 'safeguard'","row");
				}

				if($p == "info01"){
					$data['content'] = $this->common_m->self_q("select * from dh_page where page_index = 'agreement'","row");
				}

				if($p == "address_add"){
					$mode = $this->input->get('mode');
					$data['type'] = $type = $this->input->get('type');
					$idx = $this->input->get('idx');
					$data['member'] = $this->common_m->self_q("select * from dh_member where idx = '{$idx}'","row");

					$type_to_name = array();
					$type_to_name['home'] = '자택';
					$type_to_name['chin'] = '친정';
					$type_to_name['sidc'] = '시댁';
					$type_to_name['bomo'] = '보모';
					$type_to_name['oth1'] = '기타1';
					$type_to_name['oth2'] = '기타2';

					$data['type_to_name'] = $type_to_name;

					if($_POST){

						$where['idx'] = $idx;

						if($this->input->post('type') == "home"){
							$update_data['zip1'] = $this->input->post('zipcode');
							$update_data['add1'] = $this->input->post('address1');
							$update_data['add2'] = $this->input->post('address2');
							//$update_data['name'] = $this->input->post('name');
							$update_data['phone1'] = $this->input->post('phone1');
							$update_data['phone2'] = $this->input->post('phone2');
							$update_data['phone3'] = $this->input->post('phone3');
						}
						else{
							$update_data[$this->input->post('type').'_zip'] = $this->input->post('zipcode');
							$update_data[$this->input->post('type').'_addr1'] = $this->input->post('address1');
							$update_data[$this->input->post('type').'_addr2'] = $this->input->post('address2');
							$update_data[$this->input->post('type').'_name'] = $this->input->post('name');
							$update_data[$this->input->post('type').'_phone1'] = $this->input->post('phone1');
							$update_data[$this->input->post('type').'_phone2'] = $this->input->post('phone2');
							$update_data[$this->input->post('type').'_phone3'] = $this->input->post('phone3');
						}

						$result = $this->common_m->update2("dh_member",$update_data,$where);
						if($result){
						?>
						<script type="text/javascript">
						<!--
							opener.location.reload();
							alert("배송지가 입력 되었습니다.");
							self.close();
						//-->
						</script>
						<?php
						}

					}
				}

				if($p == "adrs_adm"){
					$userid = $this->session->userdata('USERID');

					$addr_to_name = array();
					$addr_to_name['자택'] = 'home';
					$addr_to_name['친정'] = 'chin';
					$addr_to_name['시댁'] = 'sidc';
					$addr_to_name['보모'] = 'bomo';
					$addr_to_name['기타1'] = 'oth1';
					$addr_to_name['기타2'] = 'oth2';

					$data['addr_to_name'] = $addr_to_name;

					if($userid){
						$data['member_info'] = $this->common_m->self_q("select * from dh_member where userid = '{$userid}'","row");
					}
					else{
						$this->load->view("/html/please_login",$data);
					}
				}

				if($p == "rcmd"){
					$userid = $this->session->userdata('USERID');
					if($userid){
					}
					else{
						$this->load->view("/html/please_login",$data);
					}
				}

				if($p == "my_qna"){
					$userid = $this->session->userdata('USERID');
					if($userid){
					}
					else{
						$this->load->view("/html/please_login",$data);
					}
				}

				if($p == "menu_popup"){	//월별 식단표
					$idx = $data['recom_idx'] = $this->input->get('recom_idx');	//추천식단 idx
					$this_mon = $data['this_mon'] = $this->input->get('this_mon');
					if(!$this_mon) $this_mon = $data['this_mon'] = date("Y-m");

					$data['recom_info'] = $this->common_m->self_q("select * from dh_recom_food where idx = '{$idx}'","row");	//추천식단정보

					//추천식단 리스트
					$data['recom_foods'] = $this->common_m->self_q("select a.*,b.name from dh_recom_food_table a left join dh_goods b on a.goods_idx = b.idx where date_format(a.recom_date,'%Y-%m') = '{$this_mon}' and a.recom_food_idx = '{$idx}'","result");

					//휴일 리스트
					$arr_holi = array();
					$arr_holi_name = array();
					$holidays = $this->common_m->self_q("select * from dh_deliv_holi where date_format(holiday,'%Y-%m') = '{$this_mon}'","result");
					foreach($holidays as $key=>$hl){
						$arr_holi[] = $hl->holiday;
						$arr_holi_name[$hl->holiday] = $hl->holiday_name;
					}

					$data['arr_holi'] = $arr_holi;
					$data['arr_holi_name'] = $arr_holi_name;

				}

				if($p == "bfood_sample"){	//샘플신청 페이지
					$data['cate_info'] = $this->common_m->self_q("select * from dh_subinfo where cate_no like '7%'","row");
					$data['sample_list'] = $this->common_m->self_q("select * from dh_goods where cate_no = '7'","result");

					//샘플 신청 가능일 월 ~ 목
					//샘플 배송일 수 ~ 토
					$data['week_name_arr'] = array('일','월','화','수','목','금','토');
					$today_week = date('w');

					if($today_week != 0 and $today_week < 5){	//월~목
						$data['sample_call'] = false;
						$data['sample_orderable'] = true;

						//샘플 장바구니 필요
						//주문 로직 정상적으로 타도록

						//샘플 배송일
						$sample_deliv_date = date("Y-m-d",strtotime('+2 day'));

						$holis = array();
						$holiday = $this->common_m->self_q("select * from dh_deliv_holi where samp = '1' and date_format(holiday, '%Y-%m') >= '".date("Y-m",strtotime($sample_deliv_date))."' order by holiday asc","result");
						foreach($holiday as $hl){
							$holis[$hl->holiday] = true;
						}

						while(true){
							if($holis[$sample_deliv_date]){
								$data['sample_orderable'] = false;
								break;
							}
							else{
								break;
							}
						}

						$data['sample_deliv_date'] = $sample_deliv_date;
						$data['sample_deliv_date_text'] = date("Y년 m월 d일",strtotime($sample_deliv_date));
						$data['sample_deliv_date_week_name'] = $data['week_name_arr'][date('w',strtotime($sample_deliv_date))];

						//샘플 신청자 리스트
						$data['sample_order_user_list'] = $this->common_m->self_q("select a.name, b.goods_name from dh_trade a, dh_trade_goods b where a.trade_code = b.trade_code and trade_stat != '9' and b.date_bind = '".$data['sample_deliv_date']."' and a.sample_is = 'Y'","result");
						//샘플 장바구니에 담은 사람들
						$data['sample_order_hold_user_list'] = $this->common_m->self_q("select goods_name, (select name from dh_member where userid = dh_sample_cart.userid) as name from dh_sample_cart where date_bind = '".$data['sample_deliv_date']."'","result");

						//샘플 갯수 설정
						$sample_total_count = 20;

						// 샘플 갯수 차감 < 샘플 장바구니 1시간 리미트 주고 , 당일 주문된 샘플건 갯수 차감 >

						$trade_cnt = $this->common_m->self_q("select a.idx from dh_trade a, dh_trade_deliv_info b where a.trade_code = b.trade_code and b.deliv_date = '".$data['sample_deliv_date']."' and trade_stat != '9' and a.sample_is = 'Y'","cnt");	//거래내역 카운트

						//1시간 리미트
						//$one_hour_limit = date("Y-m-d H:i:s",strtotime('-1 hour'));

						//$cart_cnt = $this->common_m->self_q("select * from dh_sample_cart where reg_date > '{$one_hour_limit}'","cnt");	//장바구니 카운트
						//2018년 9월 12일 김도윤 팀장과 유선상으로 협의후 1시간동안 구매 하지 않은 회원 장바구니 제외하는 부분에 대한 로직 수정함
						// 무조건 장바구니에 담기면 끝 , 주문을 하던 안하던 고객 자유
						$cart_cnt = $this->common_m->self_q("select * from dh_sample_cart where date_bind = '".$data['sample_deliv_date']."'","cnt");	//장바구니 카운트

						$sample_total_count = $sample_total_count - $trade_cnt;
						$sample_total_count = $sample_total_count - $cart_cnt;

						$data['sample_cnt'] = $sample_total_count;

						if($this->session->userdata('USERID')){
							$user_trade_cnt = $this->common_m->self_q("select a.idx from dh_trade a, dh_trade_goods b where a.trade_code = b.trade_code and a.userid = '".$this->session->userdata('USERID')."' and trade_stat != '9' and a.sample_is = 'Y'","cnt");
						}

						if($user_trade_cnt <= 0 and $sample_total_count > 0){
							$data['sample_call'] = true;
						}

					}

				}

				if($p == "bfood_order_sale2"){	//특가상품 주문페이지2

					$data['week_name_arr'] = array('일','월','화','수','목','금','토');
					$data['gansik'] = $this->common_m->self_q("select * from dh_goods where cate_no = '8' and display = 1 order by ranking asc, idx asc","result");

					$member_addr_key_arr = array("home"=>"자택:","sidc"=>"시댁:","chin"=>"친정:","bomo"=>"보모:","oth1"=>"기타1:","oth2"=>"기타2:");
					$data['member_addr_key_arr'] = $member_addr_key_arr;
					$data['member_addr_arr'] = $this->user_addrs();
				}

				if($p == "bfood_order_sale1"){	//특가상품 주문페이지1
					//$data['list'] = $this->common_m->self_q("select * from dh_goods where cate_no = '6'","result");
					$data['cate_info'] = $this->common_m->self_q("select * from dh_subinfo where cate_no like '6%'","row");
					$data['default_select_date'] = date("Y-m-d",$this->start_deliv_date_free());

					//배송 휴일인 경우 기본적으로 선택이 안되도록 로직 구성
					$deliv_end_date = date("Y-m-d",strtotime('+90 day',strtotime($data['default_select_date'])));
					$holis = $this->common_m->self_q("select * from dh_deliv_holi where free = '1' and holiday between '".$data['default_select_date']."' and '{$deliv_end_date}'","result");
					$holiday_arrs = array();
					foreach($holis as $hi){
						$holiday_arrs[] = $hi->holiday;
					}

					while(true){
						$search_date_time = strtotime($data['default_select_date']);
						$search_date = date('Y-m-d', $search_date_time);
						if(!in_array($search_date, $holiday_arrs)){
							$data['default_select_date'] = $search_date;
							break;
						}

						$data['default_select_date'] = date('Y-m-d', strtotime('+1 day', $search_date_time));
					}
				}

				if($p == "bfood_order_free2" || $p == "sidedish_free2"){	//골라담기 or 반찬국 골라담기 주문페이지2

					$data['week_name_arr'] = array('일','월','화','수','목','금','토');
					$data['cate_no'] = $this->input->post('cate_no');
					$data['gansik'] = $this->common_m->self_q("select * from dh_goods where cate_no = '8' and display = 1 order by ranking asc, idx asc","result");

					$member_info = $this->common_m->self_q("select * from dh_member where userid = '".$this->session->userdata('USERID')."'","row");
					$member_addr_key_arr = array("home"=>"자택:","sidc"=>"시댁:","chin"=>"친정:","bomo"=>"보모:");
					$data['member_addr_key_arr'] = $member_addr_key_arr;

					$data['member_addr_arr'] = $this->user_addrs();
				}

				if($p == "bfood_order_free1" || $p == "sidedish_free1"){	//골라담기 or 반찬국 골라담기 주문페이지1

						$data['cate_info'] = $this->common_m->self_q("select * from dh_subinfo where cate_no like '%".$this->input->get('cate_no')."%'","row");

						if(!$this->input->get('recom_idx')){
							$find_recom = $this->common_m->self_q("select * from dh_recom_food where recom_cate like '%".$this->input->get('cate_no')."%'","row");
							$data['recom_idx'] = $find_recom->idx;
						}

						$data['allergy_arr'] = array(
							'13'=>'소고기',
							'12'=>'닭고기',
							'1'=>'달걀',
							'2'=>'우유',
							'6'=>'콩'
						);

						$data['default_select_date'] = date("Y-m-d",$this->start_deliv_date_free());


					/*
					$userid = $this->session->userdata('USERID');
					if($userid){

						$data['cate_info'] = $this->common_m->self_q("select * from dh_subinfo where cate_no like '%".$this->input->get('cate_no')."%'","row");

						if(!$this->input->get('recom_idx')){
							$find_recom = $this->common_m->self_q("select * from dh_recom_food where recom_cate like '%".$this->input->get('cate_no')."%'","row");
							$data['recom_idx'] = $find_recom->idx;
						}

						$data['allergy_arr'] = array(
							'13'=>'소고기',
							'12'=>'닭고기',
							'1'=>'달걀',
							'2'=>'우유',
							'6'=>'콩'
						);

						$data['default_select_date'] = date("Y-m-d",$this->start_deliv_date_free());

					}
					else{

						$this->load->view("/html/please_login",$data);

					}
					*/

				}

				if($p == "bfood_order_regular2" || $p == "sidedish_regular2"){	//추천식단 or 반찬국 추천식단 주문페이지2
					$data['week_name_arr'] = array('일','월','화','수','목','금','토');
					$data['recom_info'] = $this->common_m->self_q("select * from dh_recom_food where idx = '".$this->input->post('recom_idx')."'","row");
					$data['food_info'] = unserialize($data['recom_info']->food_info);
					$recom_cate = explode("^",substr($data['recom_info']->recom_cate,0,-1));
					$in_sql = "";
					foreach($recom_cate as $rc){
						$in_sql .= "'".$rc."',";
					}
					$in_sql = substr($in_sql,0,-1);
					$data['goods'] = $this->common_m->self_q("select * from dh_goods where cate_no in (".$in_sql.")","result");
					$data['gansik'] = $this->common_m->self_q("select * from dh_goods where cate_no = '8' and display = '1' order by ranking asc, idx asc","result");

					$holiday_data = $this->common_m->self_q("select * from dh_deliv_holi where date_format(holiday,'%Y') = '".date('Y')."'","result");
					$holiday_arr = array();
					foreach($holiday_data as $holi){
						$holiday_arr[] = $holi->holiday;
					}

					$data['holiday_arr'] = $holiday_arr;

					$member_info = $this->common_m->self_q("select * from dh_member where userid = '".$this->session->userdata('USERID')."'","row");
					$member_addr_key_arr = array("home"=>"자택:","sidc"=>"시댁:","chin"=>"친정:","bomo"=>"보모:");
					$member_addr_arr = array();
					if($member_info->add1) $member_addr_arr["home"] = $member_info->add1." ".$member_info->add2;
					if($member_info->sidc_add1) $member_addr_arr["sidc"] = $member_info->sidc_add1." ".$member_info->sidc_add2;
					if($member_info->chin_add1) $member_addr_arr["chin"] = $member_info->chin_add1." ".$member_info->chin_add2;
					if($member_info->bomo_add1) $member_addr_arr["bomo"] = $member_info->bomo_add1." ".$member_info->bomo_add2;

					$data['member_addr_key_arr'] = $member_addr_key_arr;
					$data['member_addr_arr'] = $this->user_addrs();
				}

				if($p == "bfood_order_regular1" || $p == "sidedish_regular1"){	//추천식단 or 반찬국 추천식단 주문페이지1


						$data['cate_info'] = $this->common_m->self_q("select * from dh_subinfo where recom_idx like '%".$this->input->get('recom_idx')."%'","row");
						$data['recom_info'] = $this->common_m->self_q("select * from dh_recom_food where idx like '".$this->input->get('recom_idx')."%'","row");
						$data['allergy_arr'] = array(
							'13'=>'소고기',
							'12'=>'닭고기',
							'1'=>'달걀',
							'2'=>'우유',
							'6'=>'콩'
						);

						/*
						장바구니 추천식단 2개 이상 못 받게 막기
						$recom_food_cart_overlap = true;
						$cart_where = "where ( code = '".$this->session->userdata('CART')."' or userid = '".$this->session->userdata('USERID')."' )";
						$cart_list = $this->common_m->self_q("select * from dh_cart {$cart_where} and trade_ok <> 1","result");
						foreach($cart_list as $cl){
							if($cl->recom_is == "Y"){
								$recom_food_cart_overlap = false;
							}
						}

						$data['recom_overlap'] = $recom_food_cart_overlap;
						*/



					$userid = $this->session->userdata('USERID');
					if($userid){

						$data['cate_info'] = $this->common_m->self_q("select * from dh_subinfo where recom_idx like '%".$this->input->get('recom_idx')."%'","row");
						$data['recom_info'] = $this->common_m->self_q("select * from dh_recom_food where idx like '".$this->input->get('recom_idx')."%'","row");
						$data['allergy_arr'] = array(
							'13'=>'소고기',
							'12'=>'닭고기',
							'1'=>'달걀',
							'2'=>'우유',
							'6'=>'콩'
						);

						$recom_food_cart_overlap = true;
						//$cart_where = "where ( code = '".$this->session->userdata('CART')."' or userid = '".$this->session->userdata('USERID')."' )";
						$cart_where = "where userid = '".$this->session->userdata('USERID')."'";
						$cart_list = $this->common_m->self_q("select * from dh_cart {$cart_where} and trade_ok <> 1","result");
						foreach($cart_list as $cl){
							if($cl->recom_is == "Y"){
								$recom_food_cart_overlap = false;
							}
						}

						$data['recom_overlap'] = $recom_food_cart_overlap;

					}
					/*
					else{

						$this->load->view("/html/please_login",$data);

					}
					*/


				}

				$url = $this->common_m->get_page($p);
				$this->load->view($url,$data);
			}else{

				$this->{"{$method}"}($data);
			}

		}

		if(!$this->session->userdata('CART')){ //장바구니 카트 no 생성
			$this->common_m->cart_init();
		}
	}


	public function main($data)
	{
		$this->count_m->count_add();

		//메인 배너 & 메인 팝업 배너
		//$data['main_banner'] = $this->common_m->self_q("select * from dh_bannerlist where parent_code = 'pc_main' order by sort asc","result");
		$data['main_popups'] = $this->common_m->self_q("select *,(select count(*) from dh_bannerlist where parent_code = dh_banner.code) as cnt from dh_banner where used = 'Y' and code != 'm_popup' order by sorting asc","result");
		$in_cnt = 0;
		$in_tot = count($data['main_popups']);
		foreach($data['main_popups'] as $codes){
			$in_cnt++;
			$in_sql .= "'".$codes->code."'";
			if($in_cnt != $in_tot){
				$in_sql .= ", ";
			}
		}
		$data['main_popups_banner'] = $this->common_m->self_q("select * from dh_bannerlist where parent_code in (".$in_sql.") order by sort asc","result");
		//메인 배너 & 메인 팝업 배너 종료

		//메인 상품
		$data['main_goods'] = $this->common_m->self_q("select * from dh_goods where cate_no = '3' and display = '1' and night_market!=1 order by ranking limit 5","result");

		//배너 통합
		$data['main_banner'] = $this->common_m->self_q("select * from dh_bannerlist where parent_code not in (".$in_sql.") order by sort asc","result");
		$data['main_banner2'] = $this->common_m->self_q("select * from dh_bannerlist2 where parent_code = 'depart' and addinfo4 = 'used' order by sort asc","result");
		$data['main_O_banner'] = $this->common_m->self_q("select * from dh_bannerlist2 where parent_code = 'a_circle' and addinfo4 = 'used' order by sort desc, idx desc limit 1","row");
		$data['bb_Arr'] = array("<b>","</b>");
		$data['sr_Arr'] = array("<strong>","</strong>");

		$cate = $this->m->self_q("select * from dh_banner_cate order by ranking asc, idx desc","result");
		$cate_name_Arr = array();
		foreach($cate as $c){
			$cate_name_Arr[$c->idx] = $c->name;
		}
		$data['cate'] = $cate_name_Arr;

		//현대백화점
		//$data['main_depart'] = $this->common_m->self_q("select * from dh_bannerlist where parent_code = 'pc_hyundai' order by sort asc","result");

		//$data['main_list'] = $this->common_m->getList2("dh_bbs_data","where code='main' order by idx desc"); //메인화면리스트 가져오기
		//$data['goods_list1'] = $this->common_m->getList2("dh_goods","where display=1 and display_flag like '%main/%' and cate_no='1-4' order by ranking, idx desc limit 8","*,(select data_txt from dh_data where flag_idx=dh_goods.idx order by idx limit 1) as b_name"); //wear 카테고리의 제품
		//$data['goods_list2'] = $this->common_m->getList2("dh_goods","where display=1 and display_flag like '%main/%' and ( cate_no='2-5' or cate_no='2-6' or cate_no='2-7' ) order by ranking, idx desc limit 8","*,(select data_txt from dh_data where flag_idx=dh_goods.idx order by idx limit 1) as b_name"); //HARNESS & LEAD & COLLAR 카테고리의 제품 가져오기 2-5 / 2-6 /2-7

		//$data['brand_cnt'] = $this->common_m->getCount("dh_brand_cate","where display=1","idx");
		//$data['brand_list'] = $this->common_m->getList2("dh_brand_cate","where display=1 order by sort asc,idx desc");

		$this->load->view('/html/main',$data);
		$data['popup'] = $this->common_m->popup_list('where'); //팝업 불러오기
		$this->load->view('/common/popup',$data);
	}


	function file_down()
	{
		$mode = $this->uri->segment(3);
		$file_num = $this->input->get("file_down");

		$idx = $this->input->get('idx');
		$file = $this->common_m->file_down_m($mode, $idx, $file_num);


		header('Content-Description: File Transfer');
		header('Content-Type: application/octet-stream');
		header('Content-Disposition: attachment; filename='.$file['file2']);
		header('Expires: 0');
		header('Cache-Control: must-revalidate');
		header('Pragma: public');
		flush();
		readfile($file['file']);
	}


	public function facebook_ret()
	{
		$data['shop_info'] = $this->common_m->shop_info();
		$page = $this->uri->segment(2);
		$this->load->view('/common/'.$page,$data);
	}

	public function dh_ajax(){	//Ajax _ Json 통합 프로세스
		$mode = $this->input->get('mode');

		if($mode == "get_schedule_delivery_item"){	// 추천식단 우측 주문 정보 Ajax.

			$recom_idx = $this->input->get('recom_idx');
			$delivery_week_day_count = urldecode($this->input->get('delivery_week_day_count'));
			$delivery_week_type = urldecode($this->input->get('delivery_week_type'));
			$delivery_week_type_key = $this->input->get('delivery_week_type_key');
			$delivery_week_count = urldecode($this->input->get('delivery_week_count'));
			$delivery_sun_type = urldecode($this->input->get('delivery_sun_type'));
			$deliv_addr = urldecode($this->input->get('deliv_addr'));

			$delivery_start_date = urldecode($this->input->get("delivery_date"));
			if(!$delivery_start_date) $delivery_start_date = date('Y-m-d', $this->getScheduleStartday());
			$start_day = date('Y-m-d', $this->getScheduleStartday());

			//			$vals = array();
			//			$vals['inputcnts'] = urldecode($this->input->get('inputcnts'));
			//
			//			$content = '';
			//			ob_start();
			//			print_r($vals);
			//			$content = ob_get_contents();
			//			ob_clean();
			//			$check_file = $_SERVER['DOCUMENT_ROOT'].'/_data/.debug22.php';
			//			$handle = fopen($check_file, 'w');
			//			fwrite($handle, $content);
			//			fclose($handle);

			//배송지 직접입력시 값 유지
			$zipcode = urldecode($this->input->get('zipcode'));
			$addr1 = urldecode($this->input->get('addr1'));
			$addr2 = urldecode($this->input->get('addr2'));
			//$delivery_week_type_prices = urldecode($this->input->get('delivery_week_type_prices'));

			$allergy13 = '';
			$allergy12 = '';
			$allergy1 = '';
			$allergy2 = '';
			$allergy6 = '';

			if(strpos($delivery_week_day_count,"4:") !== false && strpos($delivery_week_type,"3:") !== false){
				$delivery_week_type = "2:수,토";
			}

			$json = array();
			$json = $this->getScheduleDeliveryDay($recom_idx, $start_day, $delivery_start_date, $delivery_week_day_count, $delivery_week_type, $delivery_week_count, $delivery_sun_type);
			$json['default_deliv_start_day'] = $default_deliv_start_day = $json['min_date'];

			if($this->input->get('this_mon')){
				$default_deliv_start_day = strtotime($this->input->get('this_mon'));
				$this_mon = date("Y-m",strtotime($this->input->get('this_mon')));
			}
			else{
				$this_mon = date("Y-m",strtotime($default_deliv_start_day));
			}

			$arr_holiday = $this->Getholiday();
			//배송설정 정보
			$json['delivery_info'] = $this->getsheduledeliveryinfo($recom_idx,$delivery_week_day_count, $delivery_week_type, $delivery_week_count, $delivery_week_type_key, $delivery_sun_type, $deliv_addr, $default_deliv_start_day, $zipcode, $addr1, $addr2);


			//$json['default_deliv_start_day'] = date("Y-m-d",$default_deliv_start_day);
			//$json['default_deliv_start_day'] = $json['min_date'];
			if($delivery_week_day_count and $delivery_week_type and $delivery_week_count and $delivery_week_type_key){	//and $deliv_addr
				$json['calendar_list'] = $this->getcalendar($recom_idx, $this_mon, $delivery_week_day_count, $delivery_week_type, $delivery_week_count, $delivery_sun_type, $deliv_addr, $default_deliv_start_day, $start_day, $zipcode, $addr1, $addr2,$arr_holiday);
				//가격 정보
				$json['price_info'] = $this->getpriceforschedule($recom_idx,$delivery_week_day_count, $delivery_week_type, $delivery_week_count, $delivery_week_type_key);

				//제품 리스트
				$json['prod_list'] = $this->getprodlist($recom_idx,$delivery_week_day_count, $delivery_week_type, $delivery_week_count, $delivery_week_type_key, $delivery_sun_type, $deliv_addr, $allergy13, $allergy12, $allergy1, $allergy2, $allergy6, $zipcode, $addr1, $addr2, $json);
			}



			$delivery_week_day_count_arr = explode(":",$delivery_week_day_count);
			$json['recom_data'] = array(
				'delivery_week_day_count' => $delivery_week_day_count_arr[0],
				'delivery_week_type' => $delivery_week_type,
				'delivery_week_count' => $delivery_week_count,
				'delivery_sun_type' => $delivery_sun_type,
				'deliv_addr' => $deliv_addr,
				'default_deliv_start_day' => $default_deliv_start_day
			);

			echo json_encode($json);

			//			$content = '';
			//			ob_start();
			//			print_r($json);
			//			$content = ob_get_contents();
			//			ob_clean();
			//			$check_file = $_SERVER['DOCUMENT_ROOT'].'/_data/.debug22.php';
			//			$handle = fopen($check_file, 'w');
			//			fwrite($handle, $content);
			//			fclose($handle);



			/*
			$content = '';
			ob_start();
			print_r($ScheduleDeliveryDay);
			$content = ob_get_contents();
			ob_clean();
			$check_file = $_SERVER['DOCUMENT_ROOT'].'/_data/.debug22.php';
			$handle = fopen($check_file, 'w');
			fwrite($handle, $content);
			fclose($handle);
			*/
		}
		else if($mode == "get_calendar"){	//추천식단 달력 가져오기


			$recom_idx = $this->input->get('recom_idx');
			$delivery_week_day_count = urldecode($this->input->get('delivery_week_day_count'));
			$delivery_week_type = urldecode($this->input->get('delivery_week_type'));
			$delivery_week_count = urldecode($this->input->get('delivery_week_count'));
			$delivery_start_date = urldecode($this->input->get('delivery_start_date'));
			$delivery_sun_type = urldecode($this->input->get('delivery_sun_type'));
			$deliv_addr = urldecode($this->input->get('deliv_addr'));

			//배송지 직접입력시 값 유지
			$zipcode = urldecode($this->input->get('zipcode'));
			$addr1 = urldecode($this->input->get('addr1'));
			$addr2 = urldecode($this->input->get('addr2'));

			if(!$delivery_start_date) $delivery_start_date = date('Y-m-d', $this->getScheduleStartday());
			$start_day = date('Y-m-d', $this->getScheduleStartday());

			$arr_holiday = $this->Getholiday();

			//			$holi = $this->common_m->self_q("select * from dh_deliv_holi order by holiday asc","result");
			//			$arr_holiday = array();
			//			foreach($holi as $hl){
			//				$arr_holiday[$hl->holiday] = true;
			//			}

			//배송 휴일 추가 해서 뽑아서 넘기고
			$json = array();

			$json = $this->getScheduleDeliveryDay($recom_idx, $start_day, $delivery_start_date, $delivery_week_day_count, $delivery_week_type, $delivery_week_count, $delivery_sun_type);
			$json['default_deliv_start_day'] = $default_deliv_start_day = $json['min_date'];
			$json['start_day'] = $start_day;

			$this_mon = $this->input->get('this_mon');
			if(!$this_mon) $this_mon = date("Y-m-d",strtotime($default_deliv_start_day));

			$json['calendar_list'] = $this->getcalendar($recom_idx, $this_mon, $delivery_week_day_count, $delivery_week_type, $delivery_week_count, $delivery_sun_type, $deliv_addr, $default_deliv_start_day, $start_day,$zipcode, $addr1, $addr2,$arr_holiday);

			//			$content = '';
			//			ob_start();
			//			print_r($json);
			//			$content = ob_get_contents();
			//			ob_clean();
			//			$check_file = $_SERVER['DOCUMENT_ROOT'].'/_data/.func_data.php';
			//			$handle = fopen($check_file, 'w');
			//			fwrite($handle, $content);
			//			fclose($handle);

			echo json_encode($json);

		}
		else if($mode == "get_prod_view"){	//상품 상세보기 레이어팝업

			$goods_idx = $this->input->get('goods_idx');
			$recom_is = $this->input->get('recom_is');
			$deliv_date = $this->input->get('deliv_date');
			$price = $this->input->get('price');
			$name = urldecode($this->input->get('name'));
			$oprice = $this->input->get('origin_price');

			$json = array();
			$json['info'] = $this->getprodview($goods_idx,$recom_is,$deliv_date,$price,$name,$oprice);

			echo json_encode($json);

		}
		else if($mode == "get_result_calendar"){	//장바구니 담기전 결과 페이지 달력 공통

			$deliv_between_date = unserialize(urldecode($this->input->get('deliv_between_date')));
			$this_mon = urldecode($this->input->get('this_mon'));
			$json = array();
			$json['calnedar'] = $this->getresultcalendar($this_mon, $deliv_between_date);

			echo json_encode($json);

		}
		else if($mode == "get_add_prod"){	// 간식 추가 구매

			$deliv_start_date = urldecode($this->input->get('deliv_start_date'));	//배송날짜
			$idx = $this->input->get('idx');	//제품
			$row = $this->common_m->self_q("select * from dh_goods where idx = '{$idx}'","row");	//제품정보
			$json = array();	//배열시작
			$json['deliv_start_date'] = strtotime($deliv_start_date);	//코드값으로 활용
			foreach($row as $k=>$v){	//배열처리
				$json[$k] = $v;
			}

			//			if($row->option_use){
			//				$option_row = $this->common_m->self_q("select * from dh_goods_option where goods_idx = '{$idx}' and level = '2'","result");
			//				foreach($option_row as $key=>$val){
			//					$json['option'][$key] = $val;
			//				}
			//			}

			echo json_encode($json);

		}
		else if($mode == "get_freefood"){	//골라담기 페이지

			$this_mon = urldecode($this->input->get("this_mon"));		//date(Y-m-d)
			$cate_no = urldecode($this->input->get("cate_no"));
			$deliv_date = urldecode($this->input->get("deliv_date"));		//date(Y-m-d)
			$df_start_date = urldecode($this->input->get("df_st_date"));		//date(Y-m-d)

			if(!$deliv_date)	$deliv_date = date("Y-m-d",$this->getScheduleStartday());		//strtime
			$this_mon = date("Y-m",strtotime($this_mon));

			//배송 휴일인 경우 기본적으로 선택이 안되도록 로직 구성
			$deliv_end_date = date("Y-m-d",strtotime('+90 day',strtotime($deliv_date)));
			$holis = $this->common_m->self_q("select * from dh_deliv_holi where free = '1' and holiday between '{$deliv_date}' and '{$deliv_end_date}'","result");
			$holiday_arrs = array();
			foreach($holis as $hi){
				$holiday_arrs[] = $hi->holiday;
			}

			while(true){
				$search_date_time = strtotime($deliv_date);
				$search_date = date('Y-m-d', $search_date_time);
				if(!in_array($search_date, $holiday_arrs)){
					$deliv_date = $search_date;
					break;
				}

				$deliv_date = date('Y-m-d', strtotime('+1 day', $search_date_time));
			}

			if(!$this_mon) $this_mon = $deliv_date;

			//카테고리 넘버로 맥시멈 배송일 구하기
			$max_date_sql = "select max(b.recom_date) as max_date from dh_recom_food_table b, dh_recom_food a where b.recom_food_idx = a.idx and a.recom_cate like '%{$cate_no}%'";
			$max_date_res = $this->common_m->self_q($max_date_sql,"row");
			$max_date = $max_date_res->max_date;

			$allergy13 = $this->input->get('allergy13');
			$allergy12 = $this->input->get('allergy12');
			$allergy1 = $this->input->get('allergy1');
			$allergy2 = $this->input->get('allergy2');
			$allergy6 = $this->input->get('allergy6');

			$deliv_addr = urldecode($this->input->get('deliv_addr'));

			//배송지 직접입력시 값 유지
			$zipcode = urldecode($this->input->get('zipcode'));
			$addr1 = urldecode($this->input->get('addr1'));
			$addr2 = urldecode($this->input->get('addr2'));

			$json = array();
			$json['deliv_date'] = $deliv_date;
			$json['free_calendar'] = $this->getFreecalendar($deliv_date, $df_start_date, $this_mon, $max_date);
			$json['food_list'] = $this->Getfreefood($deliv_date, $cate_no, $allergy13, $allergy12, $allergy1, $allergy2, $allergy6);
			$json['select_date'] = $deliv_date;
			$json['deliv_addr_set'] = $this->getFreeaddr($deliv_addr, $zipcode, $addr1, $addr2);

			//			$content = '';
			//			ob_start();
			//			print_r($json);
			//			$content = ob_get_contents();
			//			ob_clean();
			//			$check_file = $_SERVER['DOCUMENT_ROOT'].'/_data/.free.data.php';
			//			$handle = fopen($check_file, 'w');
			//			fwrite($handle, $content);
			//			fclose($handle);

			echo json_encode($json);
		}
		else if($mode == "free_cart_tmp"){	//골라담기 상품 보관함

			$deliv_date = urldecode($this->input->get('deliv_date'));
			$goods_idx = $this->input->get('goods_idx');
			$price = $this->input->get('price');
			$origin_price = $this->input->get('origin_price');
			$goods_name = urldecode($this->input->get('goods_name'));
			$cart_id = $this->session->userdata('CART');

			$vals['deliv_date']=$deliv_date;
			$vals['goods_idx']=$goods_idx;
			$vals['price']=$price;
			$vals['origin_price']=$origin_price;
			$vals['goods_name']=$goods_name;
			$vals['cart_id']=$cart_id;
			$vals['cnt'] = "1";
			$vals['wdate'] = timenow();
			if($this->session->userdata('USERID')){
				$vals['userid'] = $this->session->userdata('USERID');
			}

			$tmp_cart_cnt = $this->common_m->self_q("select * from dh_freecart_tmp where cart_id = '{$cart_id}' and deliv_date = '{$deliv_date}' and goods_idx = '{$goods_idx}'","cnt");
			if($tmp_cart_cnt > 0){
				$usql = "update dh_freecart_tmp set cnt = cnt+1, udate=now() where cart_id = '{$cart_id}' and deliv_date = '{$deliv_date}' and goods_idx = '{$goods_idx}'";
				$result = $this->common_m->self_q($usql,"update");
			}
			else{
				$result = $this->common_m->insert2("dh_freecart_tmp",$vals);
			}

			if($result){
				$json = array();
				$json['tmp_list'] = $this->freecart_tmp($vals);
				$json['tmp_total'] = $this->freecart_total_price($vals);
			}

			echo json_encode($json);

		}
		else if($mode == "get_salesfood"){	//특가상품 페이지

			$this_mon = urldecode($this->input->get("this_mon"));		//date(Y-m-d)
			$cate_no = urldecode($this->input->get("cate_no"));	//카테고리 넘버
			$deliv_date = urldecode($this->input->get("deliv_date"));		//date(Y-m-d)
			$df_start_date = urldecode($this->input->get("df_st_date"));		//date(Y-m-d)

			if(!$deliv_date)	$deliv_date = date("Y-m-d",$this->getScheduleStartday());		//date(Y-m-d)
			$this_mon = date("Y-m",strtotime($this_mon));	//달력 월 이동시 필요
			if(!$this_mon) $this_mon = $deliv_date;

			//카테고리 넘버로 맥시멈 배송일 구하기
			$max_date = date("Y-m-d",strtotime('+60 day',strtotime($df_start_date)));	//특가상품은 언제나 판매하므로 맥시멈 데이터 자동 설정

			$deliv_addr = urldecode($this->input->get('deliv_addr'));	//배송지 값

			//배송지 직접입력시 값 유지
			$zipcode = urldecode($this->input->get('zipcode'));
			$addr1 = urldecode($this->input->get('addr1'));
			$addr2 = urldecode($this->input->get('addr2'));

			$json = array();
			$json['sales_calendar'] = $this->getSalescalendar($deliv_date, $df_start_date, $this_mon, $max_date);
			$json['food_list'] = $this->Getsalesfood($deliv_date);
			$json['select_date'] = $deliv_date;
			$json['deliv_addr_set'] = $this->getFreeaddr($deliv_addr, $zipcode, $addr1, $addr2);

			echo json_encode($json);
		}
		else if($mode == "sales_cart_tmp"){	//특가상품 보관함

			$deliv_date = urldecode($this->input->get('deliv_date'));
			$goods_idx = $this->input->get('goods_idx');
			$price = $this->input->get('price');
			$origin_price = $this->input->get('origin_price');
			$goods_name = urldecode($this->input->get('goods_name'));
			$cart_id = $this->session->userdata('CART');

			$vals['deliv_date']=$deliv_date;
			$vals['goods_idx']=$goods_idx;
			$vals['price']=$price;
			$vals['origin_price']=$origin_price;
			$vals['goods_name']=$goods_name;
			$vals['cart_id']=$cart_id;
			$vals['cnt'] = "1";
			$vals['wdate'] = timenow();
			if($this->session->userdata('USERID')){
				$vals['userid'] = $this->session->userdata('USERID');
			}

			$tmp_cart_cnt = $this->common_m->self_q("select * from dh_salescart_tmp where cart_id = '{$cart_id}' and deliv_date = '{$deliv_date}' and goods_idx = '{$goods_idx}'","cnt");
			if($tmp_cart_cnt > 0){
				$usql = "update dh_salescart_tmp set cnt = cnt+1, udate=now() where cart_id = '{$cart_id}' and deliv_date = '{$deliv_date}' and goods_idx = '{$goods_idx}'";
				$result = $this->common_m->self_q($usql,"update");
			}
			else{
				$result = $this->common_m->insert2("dh_salescart_tmp",$vals);
			}

			if($result){
				$json = array();
				$json['tmp_list'] = $this->salescart_tmp($vals);
				$json['tmp_total'] = $this->salescart_total_price($vals);
			}

			echo json_encode($json);

		}
		else if($mode == "call_tmp_cart"){	//골라담기 & 특가상품 보관함 유지하기
			$vals['cart_id'] = $this->input->get('cart_id');
			if($this->session->userdata('USERID')){
				$vals['userid'] = $this->session->userdata('USERID');
			}
			$submode = $this->input->get('submode');

			$json = array();
			$json['tmp_list'] = ($submode == "sales") ? $this->salescart_tmp($vals) : $this->freecart_tmp($vals) ;
			$json['tmp_total'] = ($submode == "sales") ? $this->salescart_total_price($vals) : $this->freecart_total_price($vals) ;

			echo json_encode($json);
		}
		else if($mode == "tmp_cart_clear"){	//골라담기 & 특가상품 보관함 비우기
			$vals['cart_id'] = trim($this->input->get('cart_id'));
			$submode = $this->input->get('submode');

			$table = ($submode == "sales") ? "dh_salescart_tmp" : "dh_freecart_tmp" ;

			$this->common_m->self_q("delete from ".$table." where cart_id = '".$vals['cart_id']."'","delete");

			$json = array();
			$json['tmp_list'] = ($submode == "sales") ? $this->salescart_tmp($vals) : $this->freecart_tmp($vals) ;
			$json['tmp_total'] = ($submode == "sales") ? $this->salescart_total_price($vals) : $this->freecart_total_price($vals) ;

			echo json_encode($json);
		}
		else if($mode == "cart_ea_del"){	//골라담기 & 특가상품 개별 상품 삭제
			$vals['cart_id'] = $this->input->get('cart_id');
			$vals['idx'] = $this->input->get('idx');
			$submode = $this->input->get('submode');
			$table = ($submode == "sales") ? "dh_salescart_tmp" : "dh_freecart_tmp" ;

			$this->common_m->self_q("delete from {$table} where idx = '".$vals['idx']."'","delete");

			$json = array();
			$json['tmp_list'] = ($submode == "sales") ? $this->salescart_tmp($vals) : $this->freecart_tmp($vals) ;
			$json['tmp_total'] = ($submode == "sales") ? $this->salescart_total_price($vals) : $this->freecart_total_price($vals) ;

			echo json_encode($json);
		}
		else if($mode == "cart_ea_update_minus"){	//골라담기 & 특가상품 개별 상품 수량 감소
			$vals['cart_id'] = $this->input->get('cart_id');
			$vals['idx'] = $this->input->get('idx');
			$submode = $this->input->get('submode');
			$table = ($submode == "sales") ? "dh_salescart_tmp" : "dh_freecart_tmp" ;

			$this->common_m->self_q("update {$table} set cnt=cnt-1, udate=now() where idx = '".$vals['idx']."'","update");

			$json = array();
			$json['tmp_list'] = ($submode == "sales") ? $this->salescart_tmp($vals) : $this->freecart_tmp($vals) ;
			$json['tmp_total'] = ($submode == "sales") ? $this->salescart_total_price($vals) : $this->freecart_total_price($vals) ;

			echo json_encode($json);
		}
		else if($mode == "cart_ea_update_plus"){	//골라담기 & 특가상품 개별 상품 수량 증가
			$vals['cart_id'] = $this->input->get('cart_id');
			$vals['idx'] = $this->input->get('idx');
			$submode = $this->input->get('submode');
			$table = ($submode == "sales") ? "dh_salescart_tmp" : "dh_freecart_tmp" ;

			$this->common_m->self_q("update {$table} set cnt=cnt+1, udate=now() where idx = '".$vals['idx']."'","update");

			$json = array();
			$json['tmp_list'] = ($submode == "sales") ? $this->salescart_tmp($vals) : $this->freecart_tmp($vals) ;
			$json['tmp_total'] = ($submode == "sales") ? $this->salescart_total_price($vals) : $this->freecart_total_price($vals) ;

			echo json_encode($json);
		}
		else if($mode == "get_nonerecom_calander"){	//추천식단 이외 달력
			$this_mon = urldecode($this->input->get('this_mon'));
			$deliv_date = urldecode($this->input->get('deliv_date'));
			$start_date = urldecode($this->input->get("df_st_date"));
			$cate_no = urldecode($this->input->get("cate_no"));

			//카테고리 넘버로 맥시멈 배송일 구하기
			$max_date_sql = "select max(b.recom_date) as max_date from dh_recom_food_table b, dh_recom_food a where b.recom_food_idx = a.idx and a.recom_cate like '%{$cate_no}%'";
			$max_date_res = $this->common_m->self_q($max_date_sql,"row");
			$max_date = $max_date_res->max_date;

			$json = array();

			if($cate_no == "6"){
				$max_date = date("Y-m-d",strtotime('+60 day',strtotime($start_date)));
				$json['sales_calendar'] = $this->getSalescalendar($deliv_date, $start_date, $this_mon, $max_date);
			}
			else{
				if($max_date){
					$json['free_calendar'] = $this->getFreecalendar($deliv_date, $start_date, $this_mon, $max_date);
				}
			}

			echo json_encode($json);
		}
		else if($mode == "get_Holiday_for_js"){	//datepicker 에서 사용할 배송휴일 정보

			$start_day = date("Y-m-d",$this->getScheduleStartday());
			$end_day = date("Y-m-d",strtotime('+90 day',strtotime($start_day)));

			$row = $this->common_m->self_q("select holiday from dh_deliv_holi where snhf = '1' and holiday between '{$start_day}' and '{$end_day}' ","result");
			$holi = array();
			foreach($row as $r){
				array_push($holi, date("m/d/Y",strtotime($r->holiday)));
			}

			echo json_encode($holi);

		}
		else if($mode == "get_deliv_date"){	//관리자 지정 배송일 가져오기
			$idx = $this->input->get('goods_idx');
			$row = $this->common_m->self_q("select * from dh_goods where idx = '{$idx}'","row");
			$deliv_date_arr = explode("@",$row->deliv_days);
			$d_day = array();
			foreach($deliv_date_arr as $da){
				array_push($d_day, date("m/d/Y",strtotime($da)));
			}

			echo json_encode($d_day);
		}
		else if($mode == "bomi_call"){	//쌀보미로 변경
			$prod_value = urldecode($this->input->get('prod_value'));
			$prdval_tmp = explode(":",$prod_value);
			$chg_value = "199:".$prdval_tmp[1].":".$prdval_tmp[2];

			$json = array();

			$json['prod_value'] = $chg_value;
			$json['prod_img'] = "99e01bda44f2983ad02e4ec5ed476646.png";

			echo json_encode($json);
		}
		else if($mode == "bomi_return"){	//변경된 쌀보미 이전으로
			$prod_value = urldecode($this->input->get('prod_value'));
			$goods_idx = $this->input->get('goods_idx');
			$time = $this->input->get('time');
			$cnt = $this->input->get('cnt');
			$prdval_tmp = explode(":",$prod_value);
			$row = $this->common_m->self_q("select * from dh_goods where idx = '{$goods_idx}'","row");

			$chg_value = $row->idx.":".$prdval_tmp[1].":".$prdval_tmp[2];

			$json = array();

			$json['prod_value'] = $chg_value;
			$json['prod_img'] = $row->list_img;
			$json['allergy'] = $row->allergys;
			$json['goods_name'] = $row->name;
			$json['chg_btn'] = "<button type=\"button\" onclick=\"change_bomi('".$time."','".$cnt."')\">쌀보미로 변경</button>";
			$json['goods_idx'] = $row->idx;

			echo json_encode($json);
		}

		else if($mode == "cancel_layer"){	//주문취소 레이어

			$json = array();

			$trade_code = $this->input->get('deliv_code');

			$json['trade_code'] = $trade_code;
			$json['page'] = $this->cancel_layer($trade_code);

			echo json_encode($json);

		}

		else if($mode == "allin_not"){	//배송 몰아받기 레이어
			$json = array();

			$deliv_code = $this->input->get('deliv_code');

			$json['page'] = $this->allin_not($deliv_code);

			echo json_encode($json);
		}

	}

	public function getScheduleDeliveryDay($recom_idx, $default_start_date, $delivery_start_date, $delivery_week_day_count, $delivery_week_type, $delivery_week_count, $delivery_sun_type=0, $check_item=0){

		$result = array();

		$min_date = '';
		$min_date_week = '';
		$max_date = '';
		$max_date_week = '';

		$min_default_date = "";
		$min_default_date_week = "";
		$max_default_date = "";
		$max_default_date_week = "";

		$arr_delivery_day = array();
		$arr_delivery_day2 = array();

		$arr_delivery_default_day = array();
		$arr_delivery_default_day2 = array();

		$check_day = 90;

		$delivery_count = 0;

		$arr_week = array('일', '월', '화', '수', '목', '금', '토');

		$arr_delivery_week_day_count = explode(':', $delivery_week_day_count);
		$arr_delivery_week_type = explode(':', $delivery_week_type);
		$arr_type = explode(',', $arr_delivery_week_type[1]);

		// 배송횟수
		$delivery_total_count = $arr_delivery_week_type[0]*$delivery_week_count;

		if ($default_start_date) $search_date = $default_start_date;
		else $search_date = date('Y-m-d', $this->getScheduleStartday());

		$search_end_date = date('Y-m-d', strtotime('+' . $check_day . ' day', strtotime($search_date)));

		//배송휴일 무시함
		$arr_holiday = array();
		$row = $this->common_m->self_q("select * from dh_deliv_holi where holiday between '{$search_date}' and '{$search_end_date}' and regu = 1 and type='조기마감' order by holiday asc","result");
		foreach($row as $holi){
			$arr_holiday[$holi->holiday] = true;
		}

		$i = (int)$delivery_total_count;

		// 정기배송 맥시멈 배송횟수를 정함.
		if ($i > 100) $i = 24;

		$j = $i;
		$search_date = $delivery_start_date;

		while(true){
			$search_date_time = strtotime($search_date);
			$search_date = date('Y-m-d', $search_date_time);
			$week = date('w', $search_date_time);
			$w = $arr_week[$week];
			if (in_array($w, $arr_type)) {
				if (!$arr_holiday[$search_date]) {

					$search_result = true;
					if ($check_item) {
						$check_row = $this->common_m->self_q("select count(*) as cnt from dh_recom_food_table where recom_food_idx = '{$recom_idx}' and recom_date = '{$search_date}'","row");
						if ($check_row->cnt < 1) $search_result = false;
					}

					if ($search_result and strtotime($search_date) > time()) {
						array_push($arr_delivery_day, array($search_date, $w));
						array_push($arr_delivery_day2, date('m/d/Y', $search_date_time));
					}
					$i --;
				}
			}
			$search_date = date('Y-m-d', strtotime('+1 day', $search_date_time));
			if ($i == 0) break;
		}

		$min = current($arr_delivery_day);
		$min_date = $min[0];
		$min_date_week = $min[1];

		$max = end($arr_delivery_day);
		$max_date = $max[0];
		$max_date_week = $max[1];

		$delivery_count = count($arr_delivery_day);

		// 기본 검색 배송일 비교
		if ($default_start_date != $delivery_start_date) {

			$search_date = $default_start_date;

			while (true) {
				$search_date_time = strtotime($search_date);
				$search_date = date('Y-m-d', $search_date_time);
				$week = date('w', $search_date_time);
				$w = $arr_week[$week];
				if (in_array($w, $arr_type)) {
					if (!$arr_holiday[$search_date]) {
						array_push($arr_delivery_default_day, array($search_date, $w));
						array_push($arr_delivery_default_day2, date('m/d/Y', $search_date_time));
						$i --;
					}
				}
				$search_date = date('Y-m-d', strtotime('+1 day', $search_date_time));
				if ($search_date_time > strtotime($search_end_date)) break;
			}

			$min = current($arr_delivery_default_day);
			$min_default_date = $min[0];
			$min_default_date_week = $min[1];

			$max = end($arr_delivery_default_day);
			$max_default_date = $max[0];
			$max_default_date_week = $max[1];

			$count = 0;
			foreach ($arr_delivery_day as $delivery_day) {
				if (strtotime($delivery_day[0])<=strtotime($max_default_date)) $count ++;
				else break;
			}
			$delivery_count = $count;

		}

		$result['error'] = $error;

		$result['min_date'] = $min_date;
		$result['min_date_week'] =  $min_date_week;
		$result['max_date'] = $max_date;
		$result['max_date_week'] =  $max_date_week;

		$result['min_default_date'] = $min_default_date;
		$result['min_default_date_week'] =  $min_default_date_week;
		$result['max_default_date'] = $max_default_date;
		$result['max_default_date_week'] =  $max_default_date_week;

		$result['delivery_day'] = $arr_delivery_day;
		$result['delivery_day2'] = $arr_delivery_day2;

		$result['delivery_default_day'] = $arr_delivery_default_day;
		$result['delivery_default_day2'] = $arr_delivery_default_day2;

		$result['delivery_count'] = $delivery_count;

		return $result;

	}

	public function Getfreefood($deliv_date, $cate_no, $allergy13, $allergy12, $allergy1, $allergy2, $allergy6){

		$item_row = array();

		$current_time = strtotime($deliv_date);	//기본값 or 선택값 날짜의 date to time

		if(date("w",$current_time) == 1)	$start_monday = $current_time;	//오늘이 월요일이면
		else	$start_monday = strtotime("last monday",$current_time);	//아니면

		$start_date = date("Y-m-d",$start_monday);	//시작일
		$end_date = date("Y-m-d",strtotime('this saturday',$start_monday));	//종료일 < 토요일

		$wed_date = date("Y-m-d", strtotime("this wednesday",$start_monday));	//수요일 < 종료일 구분값
		$thu_date = date("Y-m-d", strtotime("this thursday",$start_monday));	//목요일 < 시작일 구분값

		if($cate_no != "1-6"){
			if(date('w',$current_time) < 4)	$end_date = $wed_date;	// 월 ~ 수 < 종료일 조정
			else	$start_date = $thu_date;	// 목 ~ 토	< 시작일 조정
		}

		$allergys = array($allergy13, $allergy12, $allergy1, $allergy2, $allergy6);

		//추천식단 정보
		$recom_info = $this->common_m->self_q("select * from dh_recom_food where recom_cate like '%".$cate_no."%'","row");

		$date_sql = "a.recom_date between '{$start_date}' and '{$end_date}'";

		$sql = "select b.* from dh_recom_food_table a, dh_goods b where a.goods_idx = b.idx and b.cate_no = '".$cate_no."' and {$date_sql} group by b.idx";
		$_row = $this->common_m->self_q($sql,"fetch_array");
		foreach($_row as $r){
			$tmp_arr['list_img'] = $r['list_img'];
			$tmp_arr['price'] = $r['shop_price'];
			$tmp_arr['origin_price'] = $r['old_price'];
			$tmp_arr['goods_idx'] = $r['idx'];
			$tmp_arr['name'] = $r['name'];
			$tmp_arr['allergys'] = $r['allergys'];
			$item_row[] = $tmp_arr;
		}

		if($cate_no == "1-6"){
			$sql = "select * from dh_goods where idx = '199'";	//쌀보미 고정
			$_adrow = $this->common_m->self_q($sql,"row");
				$tmp_adrow['list_img'] = $_adrow->list_img;
				$tmp_adrow['price'] = $_adrow->shop_price;
				$tmp_adrow['origin_price'] = $_adrow->old_price;
				$tmp_adrow['goods_idx'] = $_adrow->idx;
				$tmp_adrow['name'] = $_adrow->name;
				$tmp_adrow['allergys'] = $_adrow->allergys;
				$item_row[] = $tmp_adrow;
		}


		$week_name_arr = array('일','월','화','수','목','금','토');
		$select_date_ui = date("m월 d일",strtotime($deliv_date));
		$select_day_name_ui = $week_name_arr[date("w",strtotime($deliv_date))];
		$make_date_time = strtotime('-1 day',strtotime($deliv_date));
		$make_date_ui = date("m월 d일",$make_date_time);
		$make_day_name_ui = $week_name_arr[date("w",$make_date_time)];

		ob_start();
		include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.free.prod_list.php";
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	public function Getsalesfood($deliv_date){

		$item_row = array();

		$current_time = strtotime($deliv_date);	//기본값 or 선택값 날짜의 date to time

		$sql = "select * from dh_goods where display = '1' and cate_no = '6' order by idx asc";
		$_row = $this->common_m->self_q($sql,"fetch_array");
		foreach($_row as $r){
			$tmp_arr['list_img'] = $r['list_img'];
			$tmp_arr['price'] = $r['shop_price'];
			$tmp_arr['origin_price'] = $r['old_price'];
			$tmp_arr['goods_idx'] = $r['idx'];
			$tmp_arr['name'] = $r['name'];
			$item_row[] = $tmp_arr;
		}

		$week_name_arr = array('일','월','화','수','목','금','토');
		$select_date_ui = date("m월 d일",strtotime($deliv_date));
		$select_day_name_ui = $week_name_arr[date("w",strtotime($deliv_date))];
		$make_date_time = strtotime('-1 day',strtotime($deliv_date));
		$make_date_ui = date("m월 d일",$make_date_time);
		$make_day_name_ui = $week_name_arr[date("w",$make_date_time)];

		ob_start();
		include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.sales.prod_list.php";
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	public function getFreecalendar($deliv_date, $start_date, $this_mon, $max_date){

		$holiday_data = $this->common_m->self_q("select * from dh_deliv_holi where free = '1'","result");
		$holiday_arr = array();
		foreach($holiday_data as $holi){
			$holiday_arr[] = $holi->holiday;
		}

		//로그인 한 회원의 정기배송 리스트가 있는지 여부 확인 후 적용
		if($this->session->userdata('USERID')){
			$sql = "select distinct a.deliv_date
							from dh_trade_deliv_prod a left join dh_trade_deliv_info b on a.deliv_code = b.deliv_code
							left join dh_trade c on a.trade_code = c.trade_code
							where b.userid = '".$this->session->userdata('USERID')."'
							and b.deliv_stat < 3
							and c.trade_stat between 2 and 3
							and c.sample_is is null
							and a.deliv_date > '".date("Y-m-d")."'";
			$deliv_list = $this->common_m->self_q($sql,"result");
			$delivdate_arr = array();
			foreach($deliv_list as $dl){
				$delivdate_arr[] = $dl->deliv_date;
			}
		}

		ob_start();
		include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.free.calnedar.php";
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	public function getSalescalendar($deliv_date, $start_date, $this_mon, $max_date){

		$holiday_data = $this->common_m->self_q("select * from dh_deliv_holi where free = '1'","result");
		$holiday_arr = array();
		foreach($holiday_data as $holi){
			$holiday_arr[] = $holi->holiday;
		}

		//로그인 한 회원의 정기배송 리스트가 있는지 여부 확인 후 적용
		if($this->session->userdata('USERID')){
			$sql = "select distinct a.deliv_date
							from dh_trade_deliv_prod a left join dh_trade_deliv_info b on a.deliv_code = b.deliv_code
							left join dh_trade c on a.trade_code = c.trade_code
							where b.userid = '".$this->session->userdata('USERID')."'
							and b.deliv_stat < 3
							and c.trade_stat between 2 and 3
							and c.sample_is is null
							and a.deliv_date > '".date("Y-m-d")."'";
			$deliv_list = $this->common_m->self_q($sql,"result");
			$delivdate_arr = array();
			foreach($deliv_list as $dl){
				$delivdate_arr[] = $dl->deliv_date;
			}
		}

		ob_start();
		include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.sales.calnedar.php";
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	public function getresultcalendar($this_mon, $deliv_between_date){

		$holiday_data = $this->common_m->self_q("select * from dh_deliv_holi where date_format(holiday,'%Y') = '".date('Y')."'","result");
		$holiday_arr = array();
		foreach($holiday_data as $holi){
			$holiday_arr[] = $holi->holiday;
		}

		ob_start();
		include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.result.calendar.php";
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	public function getprodlist($recom_idx,$delivery_week_day_count, $delivery_week_type, $delivery_week_count, $delivery_week_type_key, $delivery_sun_type=0, $deliv_addr, $allergy13, $allergy12, $allergy1, $allergy2, $allergy6, $zipcode, $addr1, $addr2, $delivery_day){

		//		$vals = array();
		//		$vals['recom_idx']=$recom_idx;
		//		$vals['delivery_week_day_count']=$delivery_week_day_count;
		//		$vals['delivery_week_type']=$delivery_week_type;
		//		$vals['delivery_week_count']=$delivery_week_count;
		//		$vals['delivery_sun_type']=$delivery_sun_type;
		//		$vals['deliv_addr']=$deliv_addr;
		//		$vals['allergy13']=$allergy13;
		//		$vals['allergy12']=$allergy12;
		//		$vals['allergy1']=$allergy1;
		//		$vals['allergy2']=$allergy2;
		//		$vals['allergy6']=$allergy6;
		//		$vals['zipcode']=$zipcode;
		//		$vals['addr1']=$addr1;
		//		$vals['addr2']=$addr2;
		//		$vals['delivery_day']=$delivery_day;
		//
		//		$content = '';
		//		ob_start();
		//		print_r($vals);
		//		$content = ob_get_contents();
		//		ob_clean();
		//		$check_file = $_SERVER['DOCUMENT_ROOT'].'/_data/.debug22.php';
		//		$handle = fopen($check_file, 'w');
		//		fwrite($handle, $content);
		//		fclose($handle);
		//
		//		exit;

		$recom_info = $this->common_m->self_q("select * from dh_recom_food where idx = '".$recom_idx."'","row");	//추천식단 정보
		$food_info = unserialize($recom_info->food_info);	//추천식단 가격정보 배열

		// 배송 휴일 정보
		$arr_holi = array();
		$arr_holitype = array();
		$holi = $this->common_m->self_q("select * from dh_deliv_holi where regu = '1'","result");
		foreach($holi as $h){
			$arr_holi[$h->holiday] = true;
			$arr_holitype[$h->holiday]['type'] = $h->type?$h->type:"배송휴무";
		}

		//알러지 체크 배열처리
		$allergys = array($allergy13, $allergy12, $allergy1, $allergy2, $allergy6);

		ob_start();
		include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.schedule_delivery_item.php";
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	public function getsheduledeliveryinfo($recom_idx,$delivery_week_day_count, $delivery_week_type, $delivery_week_count, $delivery_week_type_key, $delivery_sun_type, $deliv_addr, $default_deliv_start_day, $zipcode, $addr1, $addr2){

		$recom_info = $this->common_m->self_q("select * from dh_recom_food where idx = '".$recom_idx."'","row");

		$member_addr_key_arr = array("home"=>"자택: ","sidc"=>"시댁: ","chin"=>"친정: ","bomo"=>"보모: ","oth1"=>"기타1: ","oth2"=>"기타2: ");
		$member_addr_arr = $this->user_addrs();
		$member_addr_arr["self"] = "직접입력";


		ob_start();
		include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.schedule_delivery_info.php";
		$content = ob_get_contents();
		ob_end_clean();

		return $content;

	}

	public function getcalendar($recom_idx, $this_mon, $delivery_week_day_count, $delivery_week_type, $delivery_week_count, $delivery_sun_type, $deliv_addr, $default_deliv_start_day, $start_day, $zipcode, $addr1, $addr2, $arr_holiday){

		$delivery_week_day_count_arr = explode(":",$delivery_week_day_count);	//7:21
		$yoil_arr_tmp = explode(":",$delivery_week_type);	//2:수,토

		$week_name_arr = array('일','월','화','수','목','금','토');
		$week_select_arr = explode(",",$yoil_arr_tmp[1]);	//수,토

		//배송휴일 추가
		$holiday_data = $this->common_m->self_q("select * from dh_deliv_holi where regu = 1 and date_format(holiday,'%Y') = '".date('Y')."'","result");
		$holiday_arr = array();
		foreach($holiday_data as $holi){
			$holiday_arr[] = $holi->holiday;
		}

		$recom_max_date_row = $this->common_m->self_q("select max(recom_date) as max_date from dh_recom_food_table where recom_food_idx = '".$recom_idx."'","row");
		$recom_max_date = $recom_max_date_row->max_date;	//추천식단이 등록된 마지막 날짜

		ob_start();
		include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.calendar.php";
		$content = ob_get_contents();
		ob_end_clean();

		return $content;

	}

	public function getpriceforschedule($recom_idx,$delivery_week_day_count, $delivery_week_type, $delivery_week_count, $delivery_week_type_key){

		$recom_info = $this->common_m->self_q("select * from dh_recom_food where idx = '".$recom_idx."'","row");
		$food_info = unserialize($recom_info->food_info);

		$pi = array();
		$week_count = explode(":",$delivery_week_day_count);

		//총 가격
		$total_price = $food_info[$week_count[0]]['price_origin'] * $delivery_week_count;

		if($delivery_week_type_key == 4){
			$total_price = $total_price + (3000 * $delivery_week_count);
		}

		//추가할인
		$add_discount = $food_info[$week_count[0]]['delivery_week_type'][$delivery_week_type_key]['price'] * $delivery_week_count;

		//배송기간 할인
		$discount = $food_info[$week_count[0]]['delivery_week_count'][$delivery_week_count]['price'];

		$pi['total'] = number_format($total_price);

		$fl = (($total_price - ($total_price - ($discount + $add_discount))) / $total_price) * 100;
		if(is_float($fl)){
			$number_form = 1;
		}
		else{
			$number_form = 0;
		}

		$pi['per'] = number_format($fl, $number_form);
		$pi['price'] = number_format($total_price - ($discount + $add_discount));
		$pi['pack_ea'] = number_format($food_info[$week_count[0]]['count'] * $delivery_week_count);

		return $pi;

	}

	public function getprodview($goods_idx,$recom_is,$deliv_date,$price,$name,$oprice){

		$goods_info = $this->common_m->self_q("select * from dh_goods where idx = '{$goods_idx}'","row");

		ob_start();
		include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.product_view.php";
		$content = ob_get_contents();
		ob_end_clean();

		return $content;

	}

	public function freecart_tmp($vals){	//골라담기 상품보관함

		$deliv_date = $this->getFreenSales_tmpcart_deliv_date($vals);
		$tmp_list = $this->getFreenSales_tmpcart_tmp_list($vals);

		$week_name_arr = array('일','월','화','수','목','금','토');

		ob_start();
		include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.free.tmp_cart.php";
		$content = ob_get_contents();
		ob_end_clean();

		return $content;

	}

	public function salescart_tmp($vals){	//특가상품 상품보관함

		$deliv_date = $this->getFreenSales_tmpcart_deliv_date($vals,"sales");
		$tmp_list = $this->getFreenSales_tmpcart_tmp_list($vals,"sales");

		$week_name_arr = array('일','월','화','수','목','금','토');

		ob_start();
		include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.free.tmp_cart.php";
		$content = ob_get_contents();
		ob_end_clean();

		return $content;

	}

	public function freecart_total_price($vals){

		$deliv_date = $this->getFreenSales_tmpcart_deliv_date($vals);
		$tmp_list = $this->getFreenSales_tmpcart_tmp_list($vals);

		$list_total_price = 0;
		foreach($deliv_date as $dd){
			$prods = 0;
			$prods_cnt = 0;
			$prods_total_price = 0;
			foreach($tmp_list as $lt){
				if($dd->deliv_date == $lt->deliv_date){
					$prods++;
					$prods_cnt += $lt->cnt;
					$prods_total_price += ($lt->price*$lt->cnt);
				}
			}

			$list_total_price += $prods_total_price;
		}

		return $list_total_price;

	}

	public function salescart_total_price($vals){

		$deliv_date = $this->getFreenSales_tmpcart_deliv_date($vals,"sales");
		$tmp_list = $this->getFreenSales_tmpcart_tmp_list($vals,"sales");

		$list_total_price = 0;
		foreach($deliv_date as $dd){
			$prods = 0;
			$prods_cnt = 0;
			$prods_total_price = 0;
			foreach($tmp_list as $lt){
				if($dd->deliv_date == $lt->deliv_date){
					$prods++;
					$prods_cnt += $lt->cnt;
					$prods_total_price += ($lt->price*$lt->cnt);
				}
			}

			$list_total_price += $prods_total_price;
		}

		return $list_total_price;

	}

	public function getFreeaddr($deliv_addr, $zipcode, $addr1, $addr2){

		$member_info = $this->common_m->self_q("select * from dh_member where userid = '".$this->session->userdata('USERID')."'","row");

		$member_addr_key_arr = array(
			"home"=>"자택:",
			"sidc"=>"시댁:",
			"chin"=>"친정:",
			"bomo"=>"보모:",
			"self"=>""
		);

		$member_addr_arr = array();
		if($member_info->add1) $member_addr_arr["home"] = $member_info->add1;
		if($member_info->sidc_add1) $member_addr_arr["sidc"] = $member_info->sidc_add1;
		if($member_info->chin_add1) $member_addr_arr["chin"] = $member_info->chin_add1;
		if($member_info->bomo_add1) $member_addr_arr["bomo"] = $member_info->bomo_add1;
		$member_addr_arr["self"] = "직접입력";

		ob_start();
		include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.free.deliv_addr.php";
		$content = ob_get_contents();
		ob_end_clean();

		return $content;

	}

	public function getFreenSales_tmpcart_deliv_date($vals,$submode=''){
		if($vals['userid']){
			$add_sql = " and userid = '".$vals['userid']."'";
		}

		if($submode == "sales"){
			$table = "dh_salescart_tmp";
		}
		else{
			$table = "dh_freecart_tmp";
		}

		$deliv_date = $this->common_m->self_q("select distinct deliv_date from {$table} where cart_id = '".$vals['cart_id']."' {$add_sql} order by deliv_date asc","result");

		return $deliv_date;
	}

	public function getFreenSales_tmpcart_tmp_list($vals,$submode=''){
		if($vals['userid']){
			$add_sql = " and userid = '".$vals['userid']."'";
		}

		if($submode == "sales"){
			$table = "dh_salescart_tmp";
		}
		else{
			$table = "dh_freecart_tmp";
		}

		$tmp_list = $this->common_m->self_q("select a.*,b.list_img from {$table} a, dh_goods as b where a.goods_idx = b.idx and cart_id = '".$vals['cart_id']."' {$add_sql} order by idx asc","result");

		return $tmp_list;
	}

	public function getScheduleStartday(){
		$result = '';

		if ((int)date('H') < 7) {
			$result = !$type ? strtotime('+1 days') : 1;
		} else {
			$result = !$type ? strtotime('+2 days') : 2;
		}

		return $result;
	}

	public function Getholiday(){
		$holi = $this->common_m->self_q("select * from dh_deliv_holi order by holiday asc","result");
		$arr_holiday = array();
		foreach($holi as $hl){
			$arr_holiday[$hl->holiday] = true;
		}

		return $arr_holiday;
	}

	public function user_addrs(){
		$member_info = $this->common_m->self_q("select * from dh_member where userid = '".$this->session->userdata('USERID')."'","row");
		$member_addr_arr = array();
		if($member_info->name and $member_info->zip1 and $member_info->add1 and $member_info->add2 and $member_info->phone1 and $member_info->phone2 and $member_info->phone3) $member_addr_arr["home"] = $member_info->add1." ".$member_info->add2;
		if($member_info->sidc_name and $member_info->sidc_zip and $member_info->sidc_addr1 and $member_info->sidc_addr2 and $member_info->sidc_phone1 and $member_info->sidc_phone2 and $member_info->sidc_phone3) $member_addr_arr["sidc"] = $member_info->sidc_addr1." ".$member_info->sidc_addr2;
		if($member_info->chin_name and $member_info->chin_zip and $member_info->chin_addr1 and $member_info->chin_addr2 and $member_info->chin_phone1 and $member_info->chin_phone2 and $member_info->chin_phone3) $member_addr_arr["chin"] = $member_info->chin_addr1." ".$member_info->chin_addr2;
		if($member_info->bomo_name and $member_info->bomo_zip and $member_info->bomo_addr1 and $member_info->bomo_addr2 and $member_info->bomo_phone1 and $member_info->bomo_phone2 and $member_info->bomo_phone3) $member_addr_arr["bomo"] = $member_info->bomo_addr1." ".$member_info->bomo_addr2;
		if($member_info->oth1_name and $member_info->oth1_zip and $member_info->oth1_addr1 and $member_info->oth1_addr2 and $member_info->oth1_phone1 and $member_info->oth1_phone2 and $member_info->oth1_phone3) $member_addr_arr["oth1"] = $member_info->oth1_addr1." ".$member_info->oth1_addr2;
		if($member_info->oth2_name and $member_info->oth2_zip and $member_info->oth2_addr1 and $member_info->oth2_addr2 and $member_info->oth2_phone1 and $member_info->oth2_phone2 and $member_info->oth2_phone3) $member_addr_arr["oth2"] = $member_info->oth2_addr1." ".$member_info->oth2_addr2;

		return $member_addr_arr;
	}

	public function start_deliv_date_free(){
		$deliv_date_time = $this->getScheduleStartday();	//timestamp

		$holis = array();
		$holiday = $this->common_m->self_q("select * from dh_deliv_holi where free = '1' and date_format(holiday, '%Y') = '".date("Y",$deliv_date_time)."' order by holiday asc","result");
		foreach($holiday as $hl){
			$holis[$hl->holiday] = true;
		}

		$default_select_date = $deliv_date_time;

		while(true){
			//if(date('w',$default_select_date) < 2 or $holis[date('Y-m-d',$default_select_date)]){
			if($holis[date('Y-m-d',$default_select_date)]){
				$default_select_date = strtotime('+1 day',$default_select_date);
			}

			//if(date('w',$default_select_date) >= 2 and !$holis[date('Y-m-d',$default_select_date)]){
			if(!$holis[date('Y-m-d',$default_select_date)]){
				break;
			}
		}

		return $default_select_date;
	}

	public function cancel_layer($trade_code){

		if(strpos($trade_code, "-")!==false){
			$deliv_code = $trade_code;
		}
		else{
			$rowtmp = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code like '{$trade_code}%'","row");
			$deliv_code = $rowtmp->deliv_code;
		}

		$deliv_code_tmp = deliv_code_arr($deliv_code);

		$trade_code = $deliv_code_tmp['trade_code'];
		$recom_order_cnt = $deliv_code_tmp['recom_order_cnt'];
		$deliv_time = $deliv_code_tmp['deliv_time'];

		$trade_info = $this->common_m->self_q("select * from dh_trade where trade_code = '".$trade_code."'","row");
		$recom_is = "";
		if($trade_info->recom_is == "Y"){
			$recom_is = "Y";
			//$recom_dates_arr = explode("^",$trade_info->recom_dates);
			//$recom_date = array();
			//foreach($recom_dates_arr as $key=>$rda){
				//$recom_date[$rda] = $key+1;	//정기배송일자를 입력하면 회차를 토함
			//}

			$deliv_list = $this->common_m->self_q("select * from dh_trade_deliv_info where trade_code = '".$trade_info->trade_code."' order by deliv_code asc","result");
			$deliv_list_select = "<select disabled class='reg_sel' style='width:100%;' onFocus='this.initialSelect = this.selectedIndex;' onChange='this.selectedIndex = this.initialSelect;'>";
			foreach($deliv_list as $k=>$dl){

				if($dl->deliv_stat > 0){
					continue;
				}

				$date_text = date("m/d",strtotime($dl->deliv_date))."(".numberToWeekname($dl->deliv_date).")";
				$recom_step_name_tmp = explode("]",$dl->prod_name);
				$date_text .= " 영양식단 ".trim($recom_step_name_tmp[1])." ".($k+1)."회차";

				if($dl->deliv_stat == 0){
					$date_text .= " [취소가능]";
				}
				else{
					$date_text .= " [취소불가]";
				}

				if($dl->deliv_code == $deliv_code){
					$selected = "selected";
				}
				else{
					$selected = "";
				}

				$deliv_list_select .= "<option value='".$dl->deliv_code."' ".$selected.">".$date_text."</option>";
			}
			$deliv_list_select.= "</select>";
		}

		$deliv_info = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '{$deliv_code}'","row");

		$date_day_name = date("Y년 m월 d일",$deliv_time)." ".numberToWeekname(date("w",$deliv_time));
		if(strpos($deliv_info->prod_name, "영양식단")!==false){
			$prod_name_tmp = explode("]",$deliv_info->prod_name);
			$step_name = "'".trim($prod_name_tmp[1])."' 영양식단(정기배송)";//'준비기' 추천식단(정기배송)
		}
		else{
			$prod_name_tmp = explode(",",$deliv_info->prod_name);
			$prod_name_cnt = count($prod_name_tmp);
			$add_prod_text="";
			if($prod_name_cnt > 1){
				$add_prod_text = " 외 ".($prod_name_cnt-1)." 건";
			}
			$step_name = $prod_name_tmp[0].$add_prod_text;
		}

		$direct_cancel = true;	//바로취소 가능한 조건으로 시작

		//환불액 산출
		if($trade_info->recom_is == "Y"){
			//50% 배송여부 판단하여야함
			$psql = "select * from dh_trade_deliv_info where userid = '".$trade_info->userid."' and trade_code = '".$trade_info->trade_code."' and recom_idx > 0";
			$prow = $this->common_m->self_q($psql,"result");
			$dcnt = 0;
			$ndcnt = 0;
			foreach($prow as $pr){
				if($pr->deliv_stat > 0){
					$dcnt++;
				}
				else{
					$ndcnt++;
				}
			}

			$percent = false;
			if($dcnt >= $ndcnt){	//50% 이상 배송됨
				$percent = true;
			}

			//정기배송 정보 가져와야됨 (원가 와 할인가 판단을 위해) --- 여기서부터 반복돌려서

			$trade_goods = $this->common_m->self_q("select * from dh_trade_goods where trade_code = '{$trade_code}' and recom_idx != ''","result");
			foreach($trade_goods as $tg){
				$rsql = "select * from dh_recom_food where idx = '".$tg->recom_idx."'";
				$r_row = $this->common_m->self_q($rsql,"row");
				$food_info = unserialize($r_row->food_info);

				//food_info 배열정보
				//[몇일분?(7,6,4)]
				//[price_origin] 원가
				//[delivery_week_count ( 몇주치 )]
					// 1~4
						//[price] = 해당하는 주에 대한 할인가 (곱셈 없음)
				//[delivery_week_type 뭔요일 (수토, 화금, 화목토)]
					// 1~3
						//[price] = 해당하는 요일설정시 추가 할인가 ( 주차만큼 곱해줘야함)

				//원가와 할인가 산출해야되네 염병..
				$recom_week_type = array(
					'2:수,토'=>1,
					'2:화,금'=>2,
					'3:화,목,토'=>3
				);

				//원가
				$origin_price = $food_info[$tg->recom_week_day_count]['price_origin'] * $tg->recom_week_count;

				//할인가만 사용함.
				$sale_price = $origin_price - ($food_info[$tg->recom_week_day_count]['delivery_week_count'][$tg->recom_week_count]['price']) - ($food_info[$tg->recom_week_day_count]['delivery_week_type'][$recom_week_type[$tg->recom_week_type]]['price'] * $tg->recom_week_count);

				if($percent){	//50%이상 할인가에 대한 N분의 1 가격
					$n_price = ceil($sale_price/$tg->recom_pack_ea);

					$dsql = "select * from dh_trade_deliv_info where trade_code = '".$tg->trade_code."' and deliv_stat > 0";
					$drow = $this->common_m->self_q($dsql,"result");
					foreach($drow as $dr){	//배송 대기가 아닌 배송건 추출
						$dp_row = $this->common_m->self_q("select b.shop_price from dh_trade_deliv_prod a left join dh_goods b on a.goods_idx = b.idx where deliv_code = '".$dr->deliv_code."'","result");
						foreach($dp_row as $dp){	//배송받은 제품의 단가 출력
							$sale_price -= $n_price;
						}
					}
				}
				else{
					$dsql = "select * from dh_trade_deliv_info where trade_code = '".$tg->trade_code."' and deliv_stat > 0";
					$drow = $this->common_m->self_q($dsql,"result");
					foreach($drow as $dr){	//배송 대기가 아닌 배송건 추출
						$dp_row = $this->common_m->self_q("select b.shop_price from dh_trade_deliv_prod a left join dh_goods b on a.goods_idx = b.idx where deliv_code = '".$dr->deliv_code."'","result");
						foreach($dp_row as $dp){	//배송받은 제품의 단가 출력
							$sale_price -= $dp->shop_price;
						}
					}
				}

				$return_price += $sale_price;
			}

			// -- 여기까지 반복돌려서 환불액 산출하고 취소 신청시 주문코드 정상적으로 물고 들어가게 작업해줘야 할것

		}
		else{
			$return_price = $trade_info->total_price;
		}


		//취소들어온 주문이 정기인지 일반인지 / 샘플 제외
		if($trade_info->recom_is == "Y"){	//정기배송
			//정기배송일정에 묶인 배송 여부 확인 (배송비 지불 안된것들)
			$recom_dates_arr = explode("^",$trade_info->recom_dates);
			$dup_deliv_info = array();
			foreach($recom_dates_arr as $rda){
				$sql = "select * from dh_trade_deliv_info where userid = '".$trade_info->userid."' and deliv_price <= 0 and recom_idx = 0 and deliv_date = '".$rda."' and deliv_stat = 0";
				$dup_deliv_cnt = $this->common_m->self_q($sql,"cnt");
				if($dup_deliv_cnt > 0){
					$_row = $this->common_m->self_q($sql,"fetch_array");
					$dup_deliv_info[] = $_row;
				}
			}

			if(count($dup_deliv_info) > 0){
				$direct_cancel = false;
			}

		}
		else{	//일반배송

			$sql = "select * from dh_trade_deliv_info where userid = '".$trade_info->userid."' and deliv_date = '".date("Y-m-d",$deliv_code_tmp[1])."'  and recom_idx = 0 and deliv_price = 0 and deliv_stat = 0 and trade_code != '".$trade_info->trade_code."'";
			$res = $this->common_m->self_q($sql,"fetch_array");
			$dup_deliv_info = $res;

		}

		ob_start();
		include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/cancel_layer.php";
		$content = ob_get_contents();
		ob_end_clean();

		return $content;

	}

	public function deliv_addr_check(){
		$dval = urldecode($this->input->get('d_add_val'));
		$nval = $this->common_m->not_deliv_arr();
		foreach($nval as $n){
			$pos = strpos($dval, $n);
			if($pos !== false){
				echo "1";
				break;
			}
		}
	}

	public function allin_not($deliv_code){

		list($trade_code,$deliv_time) = explode("-",$deliv_code);

		$trade_info = $this->common_m->self_q("select * from dh_trade where trade_code = '{$trade_code}'","row");
		$arr_deliv_date = array();
		$arr_deliv_date_to_count = array();
		$recom_dates = explode("^",substr($trade_info->recom_dates,0,-1));
		foreach($recom_dates as $key=>$rd){
			$arr_deliv_date_to_count[$rd] = $key+1;
		}
		$deliv_date = date("Y-m-d",$deliv_time);
		$arr_deliv_date_to_count = $arr_deliv_date_to_count;
		$deliv_code = $deliv_code;
		$remain_pack = $this->common_m->self_q("select sum(prod_cnt) as remain_pack from dh_trade_deliv_prod where deliv_code >= '{$deliv_code}'","row");
		$remain_pack_ea = $remain_pack->remain_pack;

		//배송일에 다른 배송건 있는지 확인
		$dup_cnt = $dup_cnt = $this->common_m->self_q("select * from dh_trade_deliv_info where userid='".$trade_info->userid."' and deliv_stat=0 and deliv_date='".$deliv_date."' and recom_idx=0","cnt");
		if($dup_cnt){
			$dup_list = $this->common_m->self_q("select * from dh_trade_deliv_info where userid='".$trade_info->userid."' and deliv_stat=0 and deliv_date='".$deliv_date."' and recom_idx=0","result");
		}

		ob_start();
		include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/order_edit05_ajaxlayer.php";
		$content = ob_get_contents();
		ob_end_clean();

		return $content;

	}

	public function idmerge_proc(){

		//회원의 선택한 아이디로 주문 및 포인트 통합
		//해당 아이디 제외하고 나머지 아이디 주문 , 포인트, 게시물 통합
		$sel_id = $this->input->post('selectid');
		$sel_id_lev = $this->input->post($sel_id.'_level');
		$phone = $this->input->post('mobileno');

		//휴대폰번호 기준 아이디 산출 , 선택된 아이디 제외, 기존 탈퇴회원 제외
		$sql = "select * from dh_member where concat(phone1,phone2,phone3) = '{$phone}' and outmode != 1 and userid != '{$sel_id}' and di != 'offline'";
		$list = $this->common_m->self_q($sql,"result");
		foreach($list as $lt){

			//주문내역 통합
			$this->common_m->self_q("update dh_trade set userid = '{$sel_id}' where userid = '".$lt->userid."'","update");
			//배송정보 통합
			$this->common_m->self_q("update dh_trade_deliv_info set userid = '{$sel_id}' where userid = '".$lt->userid."'","update");
			//주문변경기록 통합
			$this->common_m->self_q("update dh_trade_deliv_log set userid = '{$sel_id}' where userid = '".$lt->userid."'","update");
			//포인트 통합
			$this->common_m->self_q("update dh_point set userid = '{$sel_id}' where userid = '".$lt->userid."'","update");
			//게시물 통합
			$this->common_m->self_q("update dh_bbs_data set userid = '{$sel_id}' where userid = '".$lt->userid."'","update");
			//쿠폰 통합
			$this->common_m->self_q("update dh_coupon_use set userid = '{$sel_id}' where userid = '".$lt->userid."'","update");

			//레벨 변경 조건이 합당하면 레벨 변경
			if($sel_id_lev < $lt->level){
				$this->common_m->self_q("update dh_member set level = '".$lt->level."' where userid = '{$sel_id}'","update");
			}

			//탈퇴처리
			$this->common_m->self_q("update dh_member set outmode=1, outtype='아이디 통합', outmsg='회원 아이디 통합과정에서 탈퇴처리됨' where userid = '".$lt->userid."'","update");

		}

		$this->common_m->self_q("update dh_member set di = '".$this->input->post('dupinfo')."' where userid = '{$sel_id}'","update");

		//본인인증값 기록
		$nice['name'] = urldecode($this->input->post('name'));
		$nice['birthdate'] = $this->input->post('birthdate');
		$nice['gender'] = $this->input->post('gender');
		$nice['dupinfo'] = $this->input->post('dupinfo');
		$nice['mobileno'] = $this->input->post('mobileno');
		$nice['mobileco'] = $this->input->post('mobileco');
		$nice['certifi_type'] = "idmerge - ".$this->input->post('certifi_type');
		$nice['wdate'] = timenow();

		$result = $this->common_m->insert2("dh_nice_chk",$nice);
		if($result){
			alert("/html/dh/identity03");
		}

	}

	public function time_chk(){
		$date = $this->input->get('date');

		$json = array();

		$json['html'] = $this->time_table_ajax($date);

		echo json_encode($json);
	}

	public function time_table_ajax($date){

		$list = $this->common_m->self_q("select * from dh_reserv_bp where date = '{$date}'","result");
		$db_time_arr = array();
		foreach($list as $lt){
			//$db_time_arr[] = $lt->time;
			$db_time_arr[$lt->time]++;
		}

		$time_table = array(
			'10:00 ~ 10:30',
			'10:30 ~ 11:00',
			'11:00 ~ 11:30',
			'11:30 ~ 12:00',
			'12:00 ~ 12:30',
			'12:30 ~ 13:00',
			'13:00 ~ 13:30',
			'13:30 ~ 14:00',
			'14:00 ~ 14:30',
			'14:30 ~ 15:00',
			'15:00 ~ 15:30',
			'15:30 ~ 16:00',
			'16:00 ~ 16:30',
			'16:30 ~ 17:00',
			'17:00 ~ 17:30',
			'17:30 ~ 18:00'
		);

		ob_start();
		include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.time_table.php";
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}


	public function paper_coupon_order(){

		$recom_idx = $this->input->get('recom_idx');
		$delivery_week_day_count = urldecode($this->input->get('delivery_week_day_count'));
		$delivery_week_type = urldecode($this->input->get('delivery_week_type'));
		$delivery_week_type_key = $this->input->get('delivery_week_type_key');
		$delivery_week_count = urldecode($this->input->get('delivery_week_count'));
		$delivery_sun_type = urldecode($this->input->get('delivery_sun_type'));
		$deliv_addr = urldecode($this->input->get('deliv_addr'));

		$delivery_start_date = urldecode($this->input->get("delivery_date"));
		if(!$delivery_start_date) $delivery_start_date = date('Y-m-d', $this->getScheduleStartday());
		$start_day = date('Y-m-d', $this->getScheduleStartday());

		//배송지 직접입력시 값 유지
		$zipcode = urldecode($this->input->get('zipcode'));
		$addr1 = urldecode($this->input->get('addr1'));
		$addr2 = urldecode($this->input->get('addr2'));
		//$delivery_week_type_prices = urldecode($this->input->get('delivery_week_type_prices'));

		$allergy13 = '';
		$allergy12 = '';
		$allergy1 = '';
		$allergy2 = '';
		$allergy6 = '';

		if(strpos($delivery_week_day_count,"4:") !== false && strpos($delivery_week_type,"3:") !== false){
			$delivery_week_type = "2:수,토";
		}

		$json = array();
		$json = $this->getScheduleDeliveryDay($recom_idx, $start_day, $delivery_start_date, $delivery_week_day_count, $delivery_week_type, $delivery_week_count, $delivery_sun_type);
		$json['default_deliv_start_day'] = $default_deliv_start_day = $json['min_date'];

		if($this->input->get('this_mon')){
			$default_deliv_start_day = strtotime($this->input->get('this_mon'));
			$this_mon = date("Y-m",strtotime($this->input->get('this_mon')));
		}
		else{
			$this_mon = date("Y-m",strtotime($default_deliv_start_day));
		}

		$arr_holiday = $this->Getholiday();
		//배송설정 정보
		$json['delivery_info'] = $this->get_coupon_scheduleinfo($recom_idx,$delivery_week_day_count, $delivery_week_type, $delivery_week_count, $delivery_week_type_key, $delivery_sun_type, $deliv_addr, $default_deliv_start_day, $zipcode, $addr1, $addr2);

		if($delivery_week_day_count and $delivery_week_type and $delivery_week_count and $delivery_week_type_key){	//and $deliv_addr
			$json['calendar_list'] = $this->getcalendar($recom_idx, $this_mon, $delivery_week_day_count, $delivery_week_type, $delivery_week_count, $delivery_sun_type, $deliv_addr, $default_deliv_start_day, $start_day, $zipcode, $addr1, $addr2,$arr_holiday);
			//가격 정보
			$json['price_info'] = $this->getpriceforschedule($recom_idx,$delivery_week_day_count, $delivery_week_type, $delivery_week_count, $delivery_week_type_key);

			//제품 리스트
			$json['prod_list'] = $this->getprodlist($recom_idx,$delivery_week_day_count, $delivery_week_type, $delivery_week_count, $delivery_week_type_key, $delivery_sun_type, $deliv_addr, $allergy13, $allergy12, $allergy1, $allergy2, $allergy6, $zipcode, $addr1, $addr2, $json);
		}

		$delivery_week_day_count_arr = explode(":",$delivery_week_day_count);
		$json['recom_data'] = array(
			'delivery_week_day_count' => $delivery_week_day_count_arr[0],
			'delivery_week_type' => $delivery_week_type,
			'delivery_week_count' => $delivery_week_count,
			'delivery_sun_type' => $delivery_sun_type,
			'deliv_addr' => $deliv_addr,
			'default_deliv_start_day' => $default_deliv_start_day
		);

		echo json_encode($json);
	}

	public function get_coupon_scheduleinfo($recom_idx,$delivery_week_day_count, $delivery_week_type, $delivery_week_count, $delivery_week_type_key, $delivery_sun_type, $deliv_addr, $default_deliv_start_day, $zipcode, $addr1, $addr2){

		$recom_info = $this->common_m->self_q("select * from dh_recom_food where idx = '".$recom_idx."'","row");
		$fi = unserialize($recom_info->food_info);
		$food_info = $fi[6];

		$member_addr_key_arr = array("home"=>"자택: ","sidc"=>"시댁: ","chin"=>"친정: ","bomo"=>"보모: ","oth1"=>"기타1: ","oth2"=>"기타2: ");
		$member_addr_arr = $this->user_addrs();
		$member_addr_arr["self"] = "직접입력";


		ob_start();
		include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.coupon.deliv.info.php";
		$content = ob_get_contents();
		ob_end_clean();

		return $content;

	}

}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */