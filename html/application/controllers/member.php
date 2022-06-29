<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Member extends CI_Controller {

 	function __construct()
	{
		parent::__construct();
    $this->load->model('admin_m');
		$this->load->helper('form');
		if(!$this->input->get('file_down')){
			ob_start();
			@header("Content-Type: text/html; charset=utf-8");
		}
	}


	public function index()
	{
		$this->main();
	}


	public function _remap($method) //모든 페이지에 적용되는 기본 설정.
	{
		$dev_arr = $this->common_m->adm_devel_array(); // 헤더와 풋터가 적용되지 않을 메소드 가져오기
		$arr = in_array($method, $dev_arr);

		if(!$this->session->userdata('ADMIN_PASSWD') && !$this->session->userdata('ADMIN_USERID')){
			alert(cdir()."/dhadm/","관리자의 아이디와 패스워드가 올바르지 않습니다.");
		}

		if($this->input->get('d')){ //디자인 페이지 보기 - 디자인 페이지 이름 뒤에 ?d=1 넣으면 메소드 접근 안하고 페이지 이름으로 디자인 확인 가능

			$p = $this->uri->segment(2);
			$url = $this->common_m->get_page($p,'admin');
			$this->load->view($url);

		}else{

			if(!$arr && $this->input->get("ajax")!=1){ //해더 & 풋터가 적용되는 경우

				$data['admin'] = $this->common_m->getRow("dh_admin_user","where userid='".$this->session->userdata('ADMIN_USERID')."'"); //접속한 user 정보
				$data['menu']  = $this->admin_m->menu(); //메뉴 갖고오기
				$data['shop_info'] = $this->admin_m->shop_info(); //shop 정보
				if($this->input->post('skin',TRUE)){ $data['shop_info']['skin'] = $this->input->post('skin',TRUE);	} //환경 설정 시 스킨 적용

				if(isset($data['menu']['lv2']->url)){
					$data['return_url'] = cdir().$data['menu']['lv2']->url."/m";
				}else{
					$data['return_url'] = cdir().$data['menu']['lv1']->url."/m";
				}

				/* 각 페이지의 header inner 클래스 가져오기 start*/
				if(isset($data['menu']['lv2']->cls)){
					$class = $data['menu']['lv2']->cls;
					$url = $data['menu']['lv2']->url;
				}else{
					$class = $data['menu']['lv1']->cls;
					$url = $data['menu']['lv1']->url;
				}
				if($class==""){	$class="adm-wrap"; } // header 안의 inner 기본 클래스
				$data['inner_class'] = $class;
				/* 각 페이지의 header inner 클래스 가져오기 end*/


				/* 페이지 권한 start */
				if($this->session->userdata('ADMIN_LEVEL') > 1){
					$menu_row = $this->common_m->getRow2("dh_menu_data", "where sgm!=1 and url='$url'");
					$menu_url = "";
					if(isset($menu_row->emp)){
						$emp_row = explode(",",	$menu_row->emp);
						if(in_array($this->session->userdata('ADMIN_IDX'),$emp_row)){
							$menu_url = $menu_row->url;
						}
					}

					if($menu_url==""){
						back('페이지 권한이 없습니다.');
					}
				}
				/* 페이지 권한 설정 end */


				$this->load->view('/dhadm/header',$data); //헤더 삽입

				$this->{"{$method}"}($data);

				$this->load->view('/dhadm/footer'); //풋터 삽입


			}else{ //헤더 & 풋터가 적용되지 않을 메소드

				if( method_exists($this, $method))
				{
					$this->{"{$method}"}();
				}

			}

		}

	}



	public function excel_download() //엑셀 다운 - 모든 컨트롤러에 적용
	{
		$cont = $this->input->get('cont'); //컨트롤러이름
		$id = $this->input->get('id');
		$flag = $this->input->get('flag');
		$this->{$cont}($flag,'1');
	}

	public function main()
	{
		$today = date("Y-m-d");
		$data['total_member'] = $this->common_m->getCount("dh_member","where outmode=0");
		$data['today_member'] = $this->common_m->getCount("dh_member","where register like '$today%' and outmode=0");
		$data['out_member'] = $this->common_m->getCount("dh_member","where outmode=1");
		$data['list'] = $this->common_m->self_q("select * from dh_member where register like '$today%' and outmode=0 order by idx desc","result");
		$this->load->view('/dhadm/member/main', $data);
	}


	public function user($flag='',$excel='') //회원관리 - 리스트
	{

		if(count($flag) > 1){ $flag=""; }

		$data['query_string'] = "?";
		$data['flag'] = $flag;
		$return_url = cdir()."/".$this->uri->segment(1)."/user/m";

		if($flag=="ago"){ //휴먼계정 일 경우
			$ago = date("Y-m-d",strtotime("last year"));
			$where_query = " where last_login < '$ago' and connect < 1 ";
		}else{
			$where_query = " where 1 ";
		}
		$order_query = " idx desc";

		if($this->input->get('birth_search')){
			$data['query_string'] .= "&birth_search=".$this->input->get('birth_search');
			$search_month = date("m");
			$search_day = date("d");
			switch($this->input->get('birth_search')){
				case "member":
					$where_query .= " and birth_month = '{$search_month}' and birth_date = '{$search_day}'";
				break;
				case "baby":
					$where_query .= " and (baby1_birth like '%".$search_month."-".$search_day."' or baby2_birth like '%".$search_month."-".$search_day."' or baby3_birth like '%".$search_month."-".$search_day."')";
				break;
				case "all":
					$where_query .= " and ( (birth_month = '{$search_month}' and birth_date = '{$search_day}') or (baby1_birth like '%".$search_month."-".$search_day."' or baby2_birth like '%".$search_month."-".$search_day."' or baby3_birth like '%".$search_month."-".$search_day."') )";
				break;
			}
		}

		$search_flag = $this->input->get('search_flag');
		$search_level = $this->input->get('search_level');
		$search_mailing = $this->input->get('search_mailing');
		$search_local = $this->input->get('search_local');
		$outmode = $this->input->get('outmode');
		$item = $this->input->get('item');
		$val = $this->input->get('val');
		$order = $this->input->get('order');

		$sdate = $this->input->get('sdate');
		$edate = $this->input->get('edate');

		if($flag=="outmode"){ $outmode="1"; }

		if(!$outmode){ $outmode = 0; }

		$mode = $this->uri->segment(4);
		$data['mode'] = $mode;
		$data['order'] = $order;

		$where_query .= " and outmode=$outmode";
		$data['query_string'].= "outmode=$outmode";
		$data['query_string'].="&order=$order";

		if($search_flag){
			if($search_flag != "local"){
				$where_query .= " and $search_flag = '".${'search_'.$search_flag}."'";
			}else{
				$where_query .= " and add1 like '".${'search_'.$search_flag}."%'";
			}
			$data['query_string'].="&search_flag=$search_flag&search_level=$search_level&search_mailing=$search_mailing&search_local=$search_local";
		}

		if($item && $val){
			if($item == "phone"){
				$val = str_replace("-",'',$val);
				$val = str_replace(" ",'',$val);
				$val = str_replace(".",'',$val);

				$where_query .= " and concat(phone1,phone2,phone3) like '%$val%'";
				$data['query_string'].="&item=$item&val=$val";
			}
			else{
				$where_query .= " and $item like '%$val%'";
				$data['query_string'].="&item=$item&val=$val";
			}
		}

		if($sdate && $edate){
			$data['query_string'].="&sdate=".$sdate."&edate=".$edate;
			$where_query .= " and date_format(register,'%Y-%m-%d') between '{$sdate}' and '{$edate}'";
		}


		$data['param']="";
		if($this->input->get("PageNumber")){
			$data['param'] = "&PageNumber=".$this->input->get("PageNumber");
		}


		switch($order)
		{
			case 2 :
				$order_query = " name asc";
			break;
			case 3 :
				$order_query = " userid asc";
			break;
			case 4 :
				$order_query = " register asc";
			break;
		}


		$data['city_row'] = $this->common_m->getGroup("dh_zip","city"); //지역 data
		$data['level_row'] = $this->common_m->getList("dh_member_level"); //회원 등급 data

		if($mode == "write"){

			if($this->input->get("idCheck")==1 && $this->input->get("userid")){ //중복확인 iframe
				$cnt = $this->common_m->getCount("dh_member", "where userid='".$this->input->get("userid",TRUE)."'");
				if($cnt){
					script_exe('alert("입력하신 아이디는 현재 사용중입니다.\n다른 아이디를 입력하여주세요."); parent.document.frm.userid_chk.value=""; parent.document.frm.userid.value=""; parent.document.frm.userid.focus();');
				}else{
					script_exe('alert("입력하신 아이디는 사용 가능합니다."); parent.document.frm.userid_chk.value="1"; parent.document.frm.passwd.focus();');
				}
			}else if($this->input->post('userid') && $this->input->post('name')){

				$cnt = $this->common_m->getCount("dh_member", "where userid='".$this->input->get("userid",TRUE)."'");
				if($cnt){
					back('이미 사용중인 아이디 입니다.');
				}else{

						$passwd = $this->member_m->sql_password($this->input->post('passwd',TRUE));

						$email = $this->input->post('email1',TRUE)."@".$this->input->post('email2',TRUE);

						$write_data = array(
							'table' => 'dh_member',
							'userid' => $this->input->post('userid',TRUE),
							'passwd' => $passwd,
							'di' => '',
							'name' => $this->input->post('name',TRUE),
							'birth_year' => $this->input->post('birth_year',TRUE),
							'birth_month' => $this->input->post('birth_month',TRUE),
							'birth_date' => $this->input->post('birth_date',TRUE),
							'birth_gubun' => $this->input->post('birth_gubun',TRUE),
							'email' => $email,
							'tel1' => $this->input->post('tel1',TRUE),
							'tel2' => $this->input->post('tel2',TRUE),
							'tel3' => $this->input->post('tel3',TRUE),
							'phone1' => $this->input->post('phone1',TRUE),
							'phone2' => $this->input->post('phone2',TRUE),
							'phone3' => $this->input->post('phone3',TRUE),
							'zip1' => $this->input->post('zip1',TRUE),
							'zip2' => $this->input->post('zip2',TRUE),
							'add1' => $this->input->post('add1',TRUE),
							'add2' => $this->input->post('add2',TRUE),
							'baby1_name' => $this->input->post('baby1_name'),
							'baby2_name' => $this->input->post('baby2_name'),
							'baby3_name' => $this->input->post('baby3_name'),
							'baby1_birth' => $this->input->post('baby1_birth'),
							'baby2_birth' => $this->input->post('baby2_birth'),
							'baby3_birth' => $this->input->post('baby3_birth'),
							'baby1_gender' => $this->input->post('baby1_gender'),
							'baby2_gender' => $this->input->post('baby2_gender'),
							'baby3_gender' => $this->input->post('baby3_gender'),
							'level' => $this->input->post('level'),
							'mailing' => $this->input->post('mailing',TRUE)
						);

						$result = $this->member_m->insert('member',$write_data); //회원 추가


						$data['shop_info'] = $this->admin_m->shop_info(); //shop 정보
						if($result && $data['shop_info']['shop_use']=='y' && $data['shop_info']['point_register'] > 0){ //쇼핑몰사용이면 포인트지급
							$insert_array = array(
								'userid' => $this->input->post('userid',TRUE),
								'point' => $data['shop_info']['point_register'],
								'content' => '신규가입 축하포인트 지급',
								'flag' => 'join'
							);

							$result = $this->member_m->point_insert($insert_array);
						}


						result($result, "등록", $return_url);
					}

			}else{
				$this->load->view('/dhadm/member/write', $data);
			}

		}
		else if($mode=="edit"){

			$idx = $this->uri->segment(5);
			$data['row'] = $this->common_m->getRow("dh_member", "where idx='".$this->db->escape_str($idx)."'");

			if($this->input->post('level') and $data['row']->level != $this->input->post('level')){	//회원 레벨 변경 히스토리
				$level_his['userid'] = $data['row']->userid;
				$level_his['before_level'] = $data['row']->level;
				$level_his['after_level'] = $this->input->post('level');
				$level_his['info'] = "관리자가 직접변경 (".$this->session->userdata('ADMIN_USERID').")";
				$level_his['wdate'] = timenow();

				//관리자가 변경한 내역 기록
				$this->common_m->insert2("dh_member_level_change",$level_his);
			}

			if($this->input->post('userid') && $this->input->post('name')){

					if($this->input->post('passwd',TRUE)){
						$passwd = $this->member_m->sql_password($this->input->post('passwd',TRUE));
					}else{
						$passwd = $data['row']->passwd;
					}

					$email = $this->input->post('email1',TRUE)."@".$this->input->post('email2',TRUE);

					//아이 정보
					$baby_name_arr = $this->input->post('baby_name',TRUE);
					$baby_birth_arr = $this->input->post('baby_birth',TRUE);
					$baby_gender_arr = $this->input->post('baby_gender',TRUE);

					$edit_data = array(
						'table' => 'dh_member',
						'idx' => $idx,
						'passwd' => $passwd,
						'userid' => $this->input->post('userid',TRUE),
						'name' => $this->input->post('name',TRUE),
						'nick' => $this->input->post('nick',TRUE),
						'email' => $email,
						'birth_year' => $this->input->post('birth_year',TRUE),
						'birth_month' => $this->input->post('birth_month',TRUE),
						'birth_date' => $this->input->post('birth_date',TRUE),
						'zip1' => $this->input->post('zip1',TRUE),
						'add1' => $this->input->post('add1',TRUE),
						'add2' => $this->input->post('add2',TRUE),
						'baby1_name' => $this->input->post('baby1_name'),
						'baby2_name' => $this->input->post('baby2_name'),
						'baby3_name' => $this->input->post('baby3_name'),
						'baby1_birth' => $this->input->post('baby1_birth'),
						'baby2_birth' => $this->input->post('baby2_birth'),
						'baby3_birth' => $this->input->post('baby3_birth'),
						'baby1_gender' => $this->input->post('baby1_gender'),
						'baby2_gender' => $this->input->post('baby2_gender'),
						'baby3_gender' => $this->input->post('baby3_gender'),
						'tel1' => $this->input->post('tel1',TRUE),
						'tel2' => $this->input->post('tel2',TRUE),
						'tel3' => $this->input->post('tel3',TRUE),
						'phone1' => $this->input->post('phone1',TRUE),
						'phone2' => $this->input->post('phone2',TRUE),
						'phone3' => $this->input->post('phone3',TRUE),
						'level' => $this->input->post('level'),
						'mailing' => $this->input->post('mailing',TRUE),
						'resms' => $this->input->post('resms',TRUE)
					);

				$result = $this->member_m->update('member',$edit_data);

				result($result, "수정", $return_url.$data['query_string'].$data['param']);

			}else{
				$this->load->view('/dhadm/member/write',$data);
			}

		}
		else if($mode == "order"){	//회원정보 탭 : 주문내역

			$idx = $this->uri->segment(5);
			$data['row'] = $this->common_m->getRow("dh_member", "where idx='".$this->db->escape_str($idx)."'");

			//$data['list'] = $this->common_m->self_q("select * from dh_trade where trade_stat between 1 and 4 and userid = '".$data['row']->userid."' order by trade_day desc","result");
			$data['list'] = $this->common_m->self_q("select * from dh_trade where userid = '".$data['row']->userid."' order by trade_day desc","result");
			//$data['list_cnt'] = $this->common_m->self_q("select * from dh_trade where trade_stat <= 4 and userid = '".$data['row']->userid."'","cnt");

			$this->load->view("/dhadm/tab_page/".$mode."_list",$data);

		}
		else if($mode == "qna"){	//회원정보 : 1대1 문의
			$idx = $this->uri->segment(5);
			$data['row'] = $this->common_m->getRow("dh_member", "where idx='".$this->db->escape_str($idx)."'");

			$data['list'] = $this->common_m->self_q("select *,(select count(idx) from dh_bbs_coment where link = dh_bbs_data.idx) as com_cnt from dh_bbs_data where code = 'withcons07' and userid = '".$data['row']->userid."' order by idx desc","result");

			$data['coment_list'] = $this->common_m->self_q("select * from dh_bbs_coment order by idx desc","result");

			$this->load->view("/dhadm/tab_page/".$mode."_list",$data);
		}
		else if($mode == "point"){	//회원정보 탭 : 적립금내역
			$idx = $this->uri->segment(5);
			$data['row'] = $this->common_m->getRow("dh_member", "where idx='".$this->db->escape_str($idx)."'");

			$data['list'] = $this->common_m->self_q("select * from dh_point where userid = '".$data['row']->userid."'","result");
			$data['total_point'] = $this->common_m->getSum("dh_point","point", "where userid = '".$data['row']->userid."'");

			$this->load->view("/dhadm/tab_page/".$mode."_list",$data);
		}
		else if($mode == "coupon"){	//회원정보 탭 : 쿠폰내역
			$idx = $this->uri->segment(5);
			$data['row'] = $this->common_m->getRow("dh_member", "where idx='".$this->db->escape_str($idx)."'");

			$db_table = "dh_coupon_use";
			$now_date = date("Y-m-d");

			$data['total_cnt'] = $this->common_m->self_q("select * from {$db_table} where userid = '".$data['row']->userid."' and {$now_date} between start_date and end_date and trade_code = ''","cnt");
			$data['list'] = $this->common_m->self_q("select * from {$db_table} where userid = '".$data['row']->userid."' and {$now_date} between start_date and end_date and trade_code = '' order by idx desc","result");

			$this->load->view("/dhadm/tab_page/".$mode."_list",$data);
		}
		else if($mode == "deliv_place"){
			$idx = $this->uri->segment(5);
			$data['row'] = $this->common_m->getRow("dh_member", "where idx='".$this->db->escape_str($idx)."'");

			//배열 만들어요
			$member_deliv_addr_manage = array();

			if($data['row']->name and $data['row']->zip1 and $data['row']->add1 and $data['row']->add2 and $data['row']->phone1 and $data['row']->phone2 and $data['row']->phone3){
				$member_deliv_addr_manage['home']['use'] = true;
				$member_deliv_addr_manage['home']['text'] = "자택";
				$member_deliv_addr_manage['home']['name'] = $data['row']->name;
				$member_deliv_addr_manage['home']['zipcode'] = $data['row']->zip1;
				$member_deliv_addr_manage['home']['addr1'] = $data['row']->add1;
				$member_deliv_addr_manage['home']['addr2'] = $data['row']->add2;
				$member_deliv_addr_manage['home']['phone1'] = $data['row']->phone1;
				$member_deliv_addr_manage['home']['phone2'] = $data['row']->phone2;
				$member_deliv_addr_manage['home']['phone3'] = $data['row']->phone3;
			}
			else{
				$member_deliv_addr_manage['home']['use'] = false;
				$member_deliv_addr_manage['home']['text'] = "자택";
				$member_deliv_addr_manage['home']['name'] = "";
				$member_deliv_addr_manage['home']['zipcode'] = "";
				$member_deliv_addr_manage['home']['addr1'] = "";
				$member_deliv_addr_manage['home']['addr2'] = "";
				$member_deliv_addr_manage['home']['phone1'] = "";
				$member_deliv_addr_manage['home']['phone2'] = "";
				$member_deliv_addr_manage['home']['phone3'] = "";
			}

			if($data['row']->chin_zip and $data['row']->chin_addr1 and $data['row']->chin_addr2 and $data['row']->chin_name and $data['row']->chin_phone1 and $data['row']->chin_phone2 and $data['row']->chin_phone3){
				$member_deliv_addr_manage['chin']['use'] = true;
				$member_deliv_addr_manage['chin']['text'] = "친정";
				$member_deliv_addr_manage['chin']['name'] = $data['row']->chin_name;
				$member_deliv_addr_manage['chin']['zipcode'] = $data['row']->chin_zip;
				$member_deliv_addr_manage['chin']['addr1'] = $data['row']->chin_addr1;
				$member_deliv_addr_manage['chin']['addr2'] = $data['row']->chin_addr2;
				$member_deliv_addr_manage['chin']['phone1'] = $data['row']->chin_phone1;
				$member_deliv_addr_manage['chin']['phone2'] = $data['row']->chin_phone2;
				$member_deliv_addr_manage['chin']['phone3'] = $data['row']->chin_phone3;
			}
			else{
				$member_deliv_addr_manage['chin']['use'] = false;
				$member_deliv_addr_manage['chin']['text'] = "친정";
				$member_deliv_addr_manage['chin']['name'] = "";
				$member_deliv_addr_manage['chin']['zipcode'] = "";
				$member_deliv_addr_manage['chin']['addr1'] = "";
				$member_deliv_addr_manage['chin']['addr2'] = "";
				$member_deliv_addr_manage['chin']['phone1'] = "";
				$member_deliv_addr_manage['chin']['phone2'] = "";
				$member_deliv_addr_manage['chin']['phone3'] = "";
			}

			if($data['row']->sidc_zip and $data['row']->sidc_addr1 and $data['row']->sidc_addr2 and $data['row']->sidc_name and $data['row']->sidc_phone1 and $data['row']->sidc_phone2 and $data['row']->sidc_phone3){
				$member_deliv_addr_manage['sidc']['use'] = true;
				$member_deliv_addr_manage['sidc']['text'] = "시댁";
				$member_deliv_addr_manage['sidc']['name'] = $data['row']->sidc_name;
				$member_deliv_addr_manage['sidc']['zipcode'] = $data['row']->sidc_zip;
				$member_deliv_addr_manage['sidc']['addr1'] = $data['row']->sidc_addr1;
				$member_deliv_addr_manage['sidc']['addr2'] = $data['row']->sidc_addr2;
				$member_deliv_addr_manage['sidc']['phone1'] = $data['row']->sidc_phone1;
				$member_deliv_addr_manage['sidc']['phone2'] = $data['row']->sidc_phone2;
				$member_deliv_addr_manage['sidc']['phone3'] = $data['row']->sidc_phone3;
			}
			else{
				$member_deliv_addr_manage['sidc']['use'] = false;
				$member_deliv_addr_manage['sidc']['text'] = "시댁";
				$member_deliv_addr_manage['sidc']['name'] = "";
				$member_deliv_addr_manage['sidc']['zipcode'] = "";
				$member_deliv_addr_manage['sidc']['addr1'] = "";
				$member_deliv_addr_manage['sidc']['addr2'] = "";
				$member_deliv_addr_manage['sidc']['phone1'] = "";
				$member_deliv_addr_manage['sidc']['phone2'] = "";
				$member_deliv_addr_manage['sidc']['phone3'] = "";
			}

			if($data['row']->bomo_zip and $data['row']->bomo_addr1 and $data['row']->bomo_addr2 and $data['row']->bomo_name and $data['row']->bomo_phone1 and $data['row']->bomo_phone2 and $data['row']->bomo_phone3){
				$member_deliv_addr_manage['bomo']['use'] = true;
				$member_deliv_addr_manage['bomo']['text'] = "보모";
				$member_deliv_addr_manage['bomo']['name'] = $data['row']->bomo_name;
				$member_deliv_addr_manage['bomo']['zipcode'] = $data['row']->bomo_zip;
				$member_deliv_addr_manage['bomo']['addr1'] = $data['row']->bomo_addr1;
				$member_deliv_addr_manage['bomo']['addr2'] = $data['row']->bomo_addr2;
				$member_deliv_addr_manage['bomo']['phone1'] = $data['row']->bomo_phone1;
				$member_deliv_addr_manage['bomo']['phone2'] = $data['row']->bomo_phone2;
				$member_deliv_addr_manage['bomo']['phone3'] = $data['row']->bomo_phone3;
			}
			else{
				$member_deliv_addr_manage['bomo']['use'] = false;
				$member_deliv_addr_manage['bomo']['text'] = "보모";
				$member_deliv_addr_manage['bomo']['name'] = "";
				$member_deliv_addr_manage['bomo']['zipcode'] = "";
				$member_deliv_addr_manage['bomo']['addr1'] = "";
				$member_deliv_addr_manage['bomo']['addr2'] = "";
				$member_deliv_addr_manage['bomo']['phone1'] = "";
				$member_deliv_addr_manage['bomo']['phone2'] = "";
				$member_deliv_addr_manage['bomo']['phone3'] = "";
			}

			if($data['row']->oth1_zip and $data['row']->oth1_addr1 and $data['row']->oth1_addr2 and $data['row']->oth1_name and $data['row']->oth1_phone1 and $data['row']->oth1_phone2 and $data['row']->oth1_phone3){
				$member_deliv_addr_manage['oth1']['use'] = true;
				$member_deliv_addr_manage['oth1']['text'] = "기타1";
				$member_deliv_addr_manage['oth1']['name'] = $data['row']->oth1_name;
				$member_deliv_addr_manage['oth1']['zipcode'] = $data['row']->oth1_zip;
				$member_deliv_addr_manage['oth1']['addr1'] = $data['row']->oth1_addr1;
				$member_deliv_addr_manage['oth1']['addr2'] = $data['row']->oth1_addr2;
				$member_deliv_addr_manage['oth1']['phone1'] = $data['row']->oth1_phone1;
				$member_deliv_addr_manage['oth1']['phone2'] = $data['row']->oth1_phone2;
				$member_deliv_addr_manage['oth1']['phone3'] = $data['row']->oth1_phone3;
			}
			else{
				$member_deliv_addr_manage['oth1']['use'] = false;
				$member_deliv_addr_manage['oth1']['text'] = "기타1";
				$member_deliv_addr_manage['oth1']['name'] = "";
				$member_deliv_addr_manage['oth1']['zipcode'] = "";
				$member_deliv_addr_manage['oth1']['addr1'] = "";
				$member_deliv_addr_manage['oth1']['addr2'] = "";
				$member_deliv_addr_manage['oth1']['phone1'] = "";
				$member_deliv_addr_manage['oth1']['phone2'] = "";
				$member_deliv_addr_manage['oth1']['phone3'] = "";
			}

			if($data['row']->oth2_zip and $data['row']->oth2_addr1 and $data['row']->oth2_addr2 and $data['row']->oth2_name and $data['row']->oth2_phone1 and $data['row']->oth2_phone2 and $data['row']->oth2_phone3){
				$member_deliv_addr_manage['oth2']['use'] = true;
				$member_deliv_addr_manage['oth2']['text'] = "기타2";
				$member_deliv_addr_manage['oth2']['name'] = $data['row']->oth2_name;
				$member_deliv_addr_manage['oth2']['zipcode'] = $data['row']->oth2_zip;
				$member_deliv_addr_manage['oth2']['addr1'] = $data['row']->oth2_addr1;
				$member_deliv_addr_manage['oth2']['addr2'] = $data['row']->oth2_addr2;
				$member_deliv_addr_manage['oth2']['phone1'] = $data['row']->oth2_phone1;
				$member_deliv_addr_manage['oth2']['phone2'] = $data['row']->oth2_phone2;
				$member_deliv_addr_manage['oth2']['phone3'] = $data['row']->oth2_phone3;
			}
			else{
				$member_deliv_addr_manage['oth2']['use'] = false;
				$member_deliv_addr_manage['oth2']['text'] = "기타2";
				$member_deliv_addr_manage['oth2']['name'] = "";
				$member_deliv_addr_manage['oth2']['zipcode'] = "";
				$member_deliv_addr_manage['oth2']['addr1'] = "";
				$member_deliv_addr_manage['oth2']['addr2'] = "";
				$member_deliv_addr_manage['oth2']['phone1'] = "";
				$member_deliv_addr_manage['oth2']['phone2'] = "";
				$member_deliv_addr_manage['oth2']['phone3'] = "";
			}

			$data['addr_arr'] = $member_deliv_addr_manage;

			$this->load->view("/dhadm/tab_page/".$mode."_list",$data);
		}
		else if($mode == "admin_memo"){
			$idx = $this->uri->segment(5);
			$data['row'] = $this->common_m->getRow("dh_member", "where idx='".$this->db->escape_str($idx)."'");

			if($this->input->get('memo_idx')){
				$idx = $this->input->get('memo_idx');
				$result = $this->common_m->self_q("delete from dh_member_memo where idx = '{$idx}'","delete");
				if($result){
					alert($_SERVER['HTTP_REFERER']);
				}
			}

			if($_POST){

				$insert_datas['admin_userid'] = $this->input->post("admin_userid");
				$insert_datas['admin_name'] = $this->input->post("admin_name");
				$insert_datas['userid'] = $this->input->post("userid");
				$insert_datas['name'] = $this->input->post("name");
				$insert_datas['wdate'] = timenow();
				$insert_datas['memo_content'] = $this->input->post("memo_content");

				$db_table = "dh_member_memo";

				$result = $this->common_m->insert2($db_table,$insert_datas);
				if($result){
					alert($_SERVER['HTTP_REFERER'],'메모가 등록 되었습니다.');
				}

			}

			//메모 리스트
			$data['memo_list'] = $this->common_m->self_q("select * from dh_member_memo where userid = '".$data['row']->userid."'","result");

			$this->load->view("/dhadm/tab_page/".$mode."_list",$data);
		}
		else if($this->input->post('del_idx') && $this->input->post('del_ok')==1){

			if($this->input->post('out') == 1){ //완전삭제

				$row = $this->common_m->getRow("dh_member","where idx='".$this->input->post('del_idx')."'");
				$result = $this->common_m->del("dh_point","userid", $row->userid); //포인트삭제
				$result = $this->common_m->del("dh_trade","userid", $row->userid); //거래내역삭제
				$result = $this->common_m->del("dh_bbs_data","userid", $row->userid); //게시판내역삭제
				$result = $this->common_m->del("dh_bbs_coment","userid", $row->userid); //게시판댓글내역삭제
				$result = $this->common_m->del("dh_member","userid", $row->userid); //멤버 완전 삭제
				//쿠폰,wishlist 는 추후에 삭제

				$return_url = cdir()."/".$this->uri->segment(1)."/out/m";
				result($result, "삭제", $return_url);

			}else{

				$del_data = array(
					'table' => 'dh_member',
					'idx' => $this->input->post('del_idx')
				);

				$result = $this->member_m->update('member_del',$del_data);

				result($result, "탈퇴처리", $return_url);

			}

		}
		else if($mode=="admintouser"){

			$row = $this->common_m->self_q("select * from dh_member where idx = '".$this->input->get('idx')."'","row");

			$login=array(
				'USERID' => $row->userid,
				'PASSWD' => $row->passwd,
				'NAME' => $row->name,
				'LEVEL' => $row->level,
				'NICKNAME' => $row->nick
			);

			$this->session->set_userdata($login);
			script_exe("window.open('/','','')");
			alert($_SERVER['HTTP_REFERER']);

		}
		else{

			//chkdel

			$listmode = $this->input->post('listmode');
			$check = $this->input->post('check');

			if($listmode == "chkdel"){

				foreach($check as $del){
					$row = $this->common_m->getRow("dh_member","where idx='".$del."'");
					$result = $this->common_m->del("dh_point","userid", $row->userid); //포인트삭제
					$result = $this->common_m->del("dh_trade","userid", $row->userid); //거래내역삭제
					$result = $this->common_m->del("dh_trade_deliv_info","userid", $row->userid); //거래내역삭제
					$result = $this->common_m->del("dh_bbs_data","userid", $row->userid); //게시판내역삭제
					$result = $this->common_m->del("dh_bbs_coment","userid", $row->userid); //게시판댓글내역삭제
					$result = $this->common_m->del("dh_coupon_use","userid", $row->userid); //게시판댓글내역삭제
					$result = $this->common_m->del("dh_member","userid", $row->userid); //멤버 완전 삭제
				}

			}

			/* 페이징 start */
			$PageNumber = $this->input->get("PageNumber"); //현재 페이지
			if(!$PageNumber){ $PageNumber=1; }
			$list_num='15'; //페이지 목록개수
			$page_num='5'; //페이징 개수
			$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
			//$url = $return_url;
			$url = cdir();
			$url .= ($this->uri->segment(1) and $this->uri->segment(1) != "m") ? "/".$this->uri->segment(1) : "" ;
			$url .= ($this->uri->segment(2) and $this->uri->segment(2) != "m") ? "/".$this->uri->segment(2) : "" ;
			$url .= ($this->uri->segment(3) and $this->uri->segment(3) != "m") ? "/".$this->uri->segment(3) : "" ;
			$url .= ($this->uri->segment(4) and $this->uri->segment(4) != "m") ? "/".$this->uri->segment(4) : "" ;
			$url .= ($this->uri->segment(5) and $this->uri->segment(5) != "m") ? "/".$this->uri->segment(5) : "" ;
			$url .= "/m";

			$data['totalCnt'] = $this->common_m->getPageList('dh_member','count','','',$where_query,$order_query); //게시판 리스트
			$data['Page'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
			/* 페이징 end */

			if($excel=="1"){ //엑셀다운

				$data['list'] = $this->common_m->getPageList('dh_member m','','','',$where_query,$order_query,"m.*,(select name from dh_member_level where level=m.level) as level_name"); //게시판 리스트
				$this->load->view("/dhadm/excel/".$this->input->get('id'),$data); //엑셀다운

			}else{

				$data['list'] = $this->common_m->getPageList('dh_member m','',$offset,$list_num,$where_query,$order_query,"m.*,(select name from dh_member_level where level=m.level) as level_name, (select count(idx) from dh_trade where userid = m.userid) as order_count"); //게시판 리스트
				$this->load->view('/dhadm/member/list', $data);
			}

		}


	}

	public function out() //회원관리 - 휴먼계정 리스트
	{
		$this->user('outmode');
	}


	public function ago() //회원관리 - 휴먼계정 리스트
	{
		$this->user('ago');
	}


	public function level($data) //회원관리 - 회원등급 관리
	{
		$data['query_string'] = "?";
		$where_query = " where 1 ";
		$item = $this->input->get('item');
		$val = $this->input->get('val');
		$mode = $this->uri->segment(4);
		$data['level_row'] = $this->common_m->getList("dh_member_level");
		$return_url = $data['return_url'];

		if($item && $val){ $data['query_string'].="&item=$item&val=$val"; $where_query .= " and $item like '%$val%'";	}


		if($this->uri->segment(4) == "write"){	//등록

			if($this->input->post("level") && $this->input->post("name")){

				$level_cnt = $this->common_m->getCount("dh_member_level","where level='".$this->input->post("level")."'");
				if($level_cnt==0){

						$write_data = array(
							'table' => 'dh_member_level',
							'level' => $this->input->post('level',TRUE),
							'name' => $this->input->post('name',TRUE),
							'reward' => $this->input->post('reward',TRUE),
							'level_up_price' => $this->input->post('level_up_price',TRUE),
							'wdate' => timenow()
						);

						$result = $this->admin_m->insert('member_level',$write_data); //회원 등급 추가

						result($result, "등록", $return_url);
				}else{
					back("입력하신 level은 현재 사용중 입니다.");
				}

			}else{
				$this->load->view('/dhadm/member/level_write', $data);
			}

		}else if($this->uri->segment(4) == "edit"){	//수정

			$idx = $this->uri->segment(5);
			$data['row'] = $this->common_m->getRow("dh_member_level", "where idx='".$this->db->escape_str($idx)."'");

			if($this->input->post("level") && $this->input->post("name")){

				$level_cnt = $this->common_m->getCount("dh_member_level","where level='".$this->input->post("level")."' and level!='".$data['row']->level."'");

				if($level_cnt==0){

						$edit_data = array(
							'table' => 'dh_member_level',
							'idx' => $idx,
							'level' => $this->input->post('level',TRUE),
							'name' => $this->input->post('name',TRUE),
							'reward' => $this->input->post('reward',TRUE),
							'level_up_price' => $this->input->post('level_up_price',TRUE),
							'udate' => timenow()
						);

						$result = $this->admin_m->update('member_level',$edit_data);

						result($result, "수정", $return_url);

				}else{
					back("입력하신 level은 현재 사용중 입니다.");
				}
			}else{
				$this->load->view('/dhadm/member/level_write', $data);
			}

		}else if($this->input->post('del_idx') && $this->input->post('del_ok')==1){	//삭제

			$result = $this->common_m->del("dh_member_level","idx", $this->input->post('del_idx')); //해당 유저 삭제
			result($result, "삭제", $return_url);

		}else{	//리스트

			/* 페이징 start */
			$PageNumber = $this->uri->segment(4,1); //현재 페이지
			$list_num='15'; //페이지 목록개수
			$page_num='5'; //페이징 개수
			$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
			$url = $return_url;
			$data['totalCnt'] = $this->common_m->getPageList('dh_member_level','count','','',$where_query); //게시판 리스트
			$data['Page'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
			/* 페이징 end */

			$data['list'] = $this->common_m->getPageList('dh_member_level','',$offset,$list_num,$where_query); //게시판 리스트


			$this->load->view('/dhadm/member/level', $data);
		}
	}


	public function point()
	{
		$idx = $this->uri->segment(3);
		$data['mem_row']=$this->common_m->getRow("dh_member","where idx='$idx'");
		$data['list'] = $this->common_m->getList2("dh_point","where userid='".$data['mem_row']->userid."' order by idx desc");
		$data['total_point'] = $this->common_m->getSum("dh_point","point", "where userid='".$data['mem_row']->userid."'");

		if($this->input->post("content") && $this->input->post("sum") && $this->input->post("point")){

			$insert_array = array(
				'userid' => $data['mem_row']->userid,
				'point' => $this->input->post("sum").$this->input->post("point",TRUE),
				'content' => $this->input->post("content",TRUE),
				'flag' => 'admin'
			);

			$result = $this->member_m->point_insert($insert_array);
			result($result, "등록", cdir()."/".$this->uri->segment(1)."/point/".$idx."/?ajax=1");

		}else if($this->input->post('del_idx') && $this->input->post('del_ok')==1){

			$result = $this->common_m->del("dh_point","idx", $this->input->post('del_idx')); //해당 유저 삭제
			result($result, "삭제", cdir()."/".$this->uri->segment(1)."/point/".$idx."/?ajax=1");

		}else{

			$this->load->view('/dhadm/member/point', $data);
		}
	}


	public function coupon()
	{
		$idx = $this->uri->segment(3);
		$data['mem_row']=$this->common_m->getRow("dh_member","where idx='$idx'");
		$data['list'] = $this->common_m->getList2("dh_coupon_use","where userid='".$data['mem_row']->userid."' order by idx desc");
		$data['couponCnt'] = $this->common_m->getCount("dh_coupon_use","where userid='".$data['mem_row']->userid."'");
		$data['coupon_list']=$this->common_m->self_q("select * from dh_coupon where type in (0,4) and (date_flag = 1 or date_format(end_date,'%Y-%m-%d') > '".date('Y-m-d')."')","result");

		if($this->input->post("code") && $this->input->post("search")==1){
			$code = $this->input->post("code",true);
			$where_query = "where code like '%".$code."%'";
			$codeCnt = $this->common_m->getCount("dh_coupon",$where_query);
			$data['codeCnt'] = $codeCnt;
			if($codeCnt){
				$data['couponList'] = $this->common_m->getList2("dh_coupon","$where_query order by name","*,(select name from dh_member_level where level=member_level) as level_name");;
			}
		}else if($this->input->post('del_idx') && $this->input->post('del_ok')==1){

			$result = $this->common_m->del("dh_coupon_use","idx", $this->input->post('del_idx')); //해당 유저 삭제
			result($result, "삭제", cdir()."/".$this->uri->segment(1)."/coupon/".$idx."/?ajax=1");

		}


		$this->load->view('/dhadm/member/coupon', $data);
	}

	public function level_change($data=''){	//회원등급 자동조정

		if($_POST){
			if($this->input->post("mode") == "levchg"){	//자동조정

				//pr($_POST);

				//회원 등급정보 호출하여 배열처리
				$lev_info = $this->common_m->self_q("select * from dh_member_level order by level desc","result");
				$lev_info_arr = array();
				foreach($lev_info as $lv){
					$lev_info_arr[$lv->level]['levup_price'] = $lv->level_up_price;
				}
				//회원 등급정보 호출하여 배열처리 종료

				$sql = "select sum(total_price) as tp, userid, (select level from dh_member where userid = dh_trade.userid) as level
								from dh_trade
								where trade_stat = '4'
								and (select level from dh_member where userid = dh_trade.userid) < (select max(level) from dh_member_level)
								group by userid";

				$row = $this->common_m->self_q($sql,"result");
				foreach($row as $r){

					$lev = "";
					foreach($lev_info_arr as $level => $price){
						$levup_price = $price['levup_price'];
						if($r->tp >= $levup_price){
							$lev = $level;
							break;
						}
					}

					$where['userid'] = $r->userid;
					$update['level'] = $lev;

					if($r->level != $lev and $lev > 0){
						$result_level = $this->common_m->update2("dh_member", $update, $where);

						//회원 등업시 쿠폰 자동지급
						if($lev==2){
							$coupon_row = $this->common_m->self_q("select * from dh_coupon where code = '1809UKCTDCX4'","row");
						}
						else if($lev==3){
							$coupon_row = $this->common_m->self_q("select * from dh_coupon where code = '1809ETYLXPW6'","row");
						}

						$coupon_use_cnt = $this->common_m->self_q("select * from dh_coupon_use where code = '".$coupon_row->code."' and userid = '".$r->userid."'","cnt");
						if($coupon_use_cnt <= 0){
							$cpin['userid'] = $r->userid;
							$cpin['code'] = $coupon_row->code;
							$cpin['name'] = $coupon_row->name;
							$cpin['type'] = $coupon_row->type;
							$cpin['discount_flag'] = $coupon_row->discount_flag;
							$cpin['price'] = $coupon_row->price;
							$cpin['min_price'] = $coupon_row->min_price;
							$cpin['max_price'] = $coupon_row->max_price;

							if($coupon_row->date_flag==1){ //기념일쿠폰이거나 이용기한 종류가 발금시점이거나
								$start_date = date("Y-m-d");
								$end_date = date("Y-m-d",strtotime($coupon_row->max_day,strtotime($start_date)));
							}else{
								$start_date = $coupon_row->start_date;
								$end_date = $coupon_row->end_date;
							}

							$cpin['start_date'] = $start_date;
							$cpin['end_date'] = $end_date;
							$cpin['reg_date'] = timenow();

							$result = $this->common_m->insert2("dh_coupon_use",$cpin);
						}
						//회원 등업시 쿠폰 자동지급

					}

					if($result_level){
						$level_his['userid'] = $r->userid;
						$level_his['before_level'] = $r->level;
						$level_his['after_level'] = $lev;
						$level_his['info'] = "관리자가 일괄조정하여 등급을 변경하였습니다.";
						$level_his['wdate'] = timenow();

						//관리자 수동 조정
						$result = $this->common_m->insert2("dh_member_level_change",$level_his);
					}

				}

				if($result_level){
					alert($_SERVER['HTTP_REFERER'],"등급 조정이 완료 되었습니다.");
				}
				else{
					alert($_SERVER['HTTP_REFERER'],"조정된 등급이 없습니다.");
				}

			}
			else{	//기록 삭제

				if($this->input->post('del_ok')){
					$result = $this->common_m->self_q("delete from dh_member_level_change where idx = '".$this->input->post('del_idx')."'","delete");
					if($result){
						alert($_SERVER['HTTP_REFERER']);
					}
				}

			}
		}

		else{

			//echo "회원등급 자동조정 페이지";

			//등급 호출
			$level_list = $this->common_m->self_q("select * from dh_member_level order by level asc","result");

			$level_arr = array();
			foreach($level_list as $lev){
				$level_arr[$lev->level] = $lev->name;
			}

			$data['level_arr'] = $level_arr;

			/* 페이징 start */
			$data['query_string'] = "?";
			$where_sql = "where 1";

			if($this->input->get('level')){
				$data['query_string'] .= "&level=".$this->input->get('level');
				$where_sql .= " and (before_level = '".$this->input->get('level')."' or after_level = '".$this->input->get('level')."')";
			}

			if($this->input->get('wdate')){
				$data['query_string'] .= "&wdate=".$this->input->get('wdate');
				$where_sql .= " and DATE_FORMAT(wdate, '%Y-%m-%d') = '".$this->input->get('wdate')."'";
			}

			if($this->input->get('userid')){
				$data['query_string'] .= "&userid=".$this->input->get('userid');
				$where_sql .= " and userid = '".$this->input->get('userid')."'";
			}


			$PageNumber = $this->input->get("PageNumber"); //현재 페이지

			if($PageNumber) $data['query_string'] .= "&PageNumber=".$PageNumber;

			if(!$PageNumber){ $PageNumber = 1; }
			$list_num = 20; //페이지 목록개수
			$page_num = 5; //페이징 개수
			$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)

			$url = cdir();
			$url .= ($this->uri->segment(1)) ? "/".$this->uri->segment(1) : "" ;
			$url .= ($this->uri->segment(2)) ? "/".$this->uri->segment(2) : "" ;
			$url .= ($this->uri->segment(3)) ? "/".$this->uri->segment(3) : "" ;
			$url .= ($this->uri->segment(4)) ? "/".$this->uri->segment(4) : "" ;

			$data['totalCnt'] = $this->common_m->self_q("select * from dh_member_level_change","cnt");
			$data['Page2'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
			$data['listNo'] = $data['totalCnt'] - $list_num*($PageNumber-1);
			/* 페이징 end */

			$data['list'] = $this->common_m->self_q("select * from dh_member_level_change {$where_sql} order by wdate desc limit {$offset}, {$list_num}","result");

			$this->load->view("/dhadm/member/level_change",$data);

		}

	}

	public function smspop($daata=''){
		$data['phone'] = $this->input->get('phone');

		if($this->input->get('phone')==""){
			?>
			<script type="text/javascript">
			<!--
				alert("문자를 보낼 전화번호가 없습니다.");
				self.close();
			//-->
			</script>
			<?php
		}

		$data['name'] = $this->input->get('name');
		$data['userid'] = $this->input->get('uid');

		$this->load->view('/dhadm/sms/sms_pop',$data);
	}

	public function sms_send($data=''){
		$this->common_m->icode_send();
	}

	public function sms_list($data=''){  // SMS 발송 내역
		$mode = $this->uri->segment(5);
		//$page = $this->uri->segment(5,1); //페이징 할 세그먼트 값
		$search_item = $this->input->get('search_item'); //검색조건
		$search_order = $this->input->get('search_order'); //검색어

		$config['query_string'] = "?";

		$where_query="";

		$data['query_string'] = $config['query_string'];

		if($search_item){
			$config['query_string'] .= "&search_item=".$search_item."&search_order=".$search_order;
		}

		if($mode==""){
			$table="sms5_write";
			$sub_query ="wr_renum=0";
			$ex_query = "wr_no";

		}else if($mode=="history_view"){
			$sub_query = "wr_no=".$this->input->get('wr_no');
			$where_query = "and wr_renum=0";
			$table="sms5_history";
			$ex_query = "hs_no";
		}

		$config['total_rows'] = $this->member_m->get_smslist($table, 'count','','',$search_item,$search_order,$where_query,$sub_query,$ex_query); //게시물의 전체개수

		//$config['total_rows'] = $this->common_m->self_q("select count(*) from sms5_write","result"); //게시물의 전체개수
		$data['total_cnt'] = $config['total_rows'];

		$data['param']="";
		if($this->input->get("PageNumber")){
			$data['param'] = "&PageNumber=".$this->input->get("PageNumber");
		}

		/* 페이징 start */
		$PageNumber = $this->input->get("PageNumber"); //현재 페이지
		if(!$PageNumber){ $PageNumber=1; }
		$list_num=20; //페이지 목록개수
		$page_num=10; //페이징 개수
		$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
		$url = cdir()."/".$this->uri->segment(1)."/sms_list/history_list/m/".$mode."";
		$data['totalCnt'] = $config['total_rows']; //게시판 리스트
		if($mode=="history_view"){
			$data['query_string'] = "?wr_no=".$this->input->get('wr_no');
		}
		$data['Page2'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string'],$sub_query);
		$data['listNo'] = $data['totalCnt'] - $list_num*($PageNumber-1);

		/* 페이징 end */

		$data['start_num'] = $offset;

		if($mode==""){
			$table="sms5_write";
			$data['list'] = $this->member_m->get_smslist($table,'',$offset,$list_num,$search_item,$search_order,$where_query,$sub_query,$ex_query); //게시판 리스트
			$this->load->view('/dhadm/sms_admin/history_list',$data);
		}else if($mode=="history_view"){
			$table="sms5_history";
			$data['list'] = $this->member_m->get_smslist($table,'',$offset,$list_num,$search_item,$search_order,$where_query,$sub_query,$ex_query); //게시판 리스트
			$this->load->view('/dhadm/sms_admin/history_view',$data);
		}
	}

	public function sudong_injueng(){
		$idx = $this->input->get('idx');

		$result = $this->common_m->self_q("update dh_member set di = 'offline' where idx = '{$idx}'","update");
		if($result){
			alert($_SERVER['HTTP_REFERER']);
		}
	}

	public function deposit_ins($data=''){

		$data['qs'] = "?";

		//검색
			$userid = $this->input->get('userid');
			$sch_sdate = $this->input->get('sch_sdate');
			$sch_edate = $this->input->get('sch_edate');

			$where_sql = ' where 1';

			if($userid){
				$data['qs'] .= "&userid={$userid}";
				$where_sql .= " and userid = '{$userid}'";
			}

			if($sch_sdate && $sch_edate){
				$data['qs'] .= "&sch_sdate={$sch_sdate}&sch_edate={$sch_edate}";
				$where_sql .= " and date_format(reg_date,'%Y-%m-%d') between '{$sch_sdate}' and '{$sch_edate}'";
			}
			else if($sch_sdate){
				$sch_edate = date("Y-m-d");
				$data['qs'] .= "&sch_sdate={$sch_sdate}&sch_edate={$sch_edate}";
				$where_sql .= " and date_format(reg_date,'%Y-%m-%d') between '{$sch_sdate}' and '{$sch_edate}'";
			}
		//검색

		$total_rows = $this->common_m->self_q("select count(*) as total_rows from dh_deposit {$where_sql}","row");

		$sql = "select * from dh_deposit {$where_sql}";

		$PageNumber = $this->input->get("PageNumber");
		if(!$PageNumber) $PageNumber = 1;
		$list_num = 50;
		$page_num = 5;
		$offset = $list_num*($PageNumber-1);
		$url = self_url();
		$data['totalCnt'] = $total_rows->total_rows;
		$data['Page'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['qs']);
		//$data['listNo'] = $data['totalCnt']-$list_num*($PageNumber-1);

		$sql .= " order by idx desc limit {$offset},{$list_num}";

		$data['list'] = $this->common_m->self_q($sql,"result");

		$this->load->view("/dhadm/member/deposit_list",$data);
	}

	public function deposit_ret($data=''){
		//환불건 승인
			if($this->input->get('mode') == 'apply'){
				$idx = $this->input->get("idx");

				$update['state'] = "승인완료";
				$update['udate'] = timenow();
				$where['idx'] = $idx;

				$result = $this->common_m->update2("dh_deposit_return",$update,$where);
				if($result){
					alert($_SERVER['HTTP_REFERER']);
				}
			}
			else if($this->input->get('mode') == 'reject'){
				$idx = $this->input->get("idx");
				$row = $this->common_m->self_q("select * from dh_deposit_return where idx = '{$idx}'","row");

				$update['state'] = "승인취소";
				$update['udate'] = timenow();
				$where['idx'] = $idx;
				$result = $this->common_m->update2("dh_deposit_return",$update,$where);
				if($result){
					//환불취소 예치금 복구
						$insert['userid'] = $row->userid;
						$insert['point'] = $row->return_deposit;
						$insert['content'] = "환불신청 승인취소";
						$insert['reg_date'] = timenow();

						$result = $this->common_m->insert2("dh_deposit",$insert);
						if($result){
							alert($_SERVER['HTTP_REFERER']);
						}
					//환불취소 예치금 복구
				}
			}
		//환불건 승인

		$data['qs'] = "?";

		//검색
			$userid = $this->input->get('userid');
			$sch_sdate = $this->input->get('sch_sdate');
			$sch_edate = $this->input->get('sch_edate');

			$where_sql = ' where 1';

			if($userid){
				$data['qs'] .= "&userid={$userid}";
				$where_sql .= " and userid = '{$userid}'";
			}

			if($sch_sdate && $sch_edate){
				$data['qs'] .= "&sch_sdate={$sch_sdate}&sch_edate={$sch_edate}";
				$where_sql .= " and date_format(wdate,'%Y-%m-%d') between '{$sch_sdate}' and '{$sch_edate}'";
			}
			else if($sch_sdate){
				$sch_edate = date("Y-m-d");
				$data['qs'] .= "&sch_sdate={$sch_sdate}&sch_edate={$sch_edate}";
				$where_sql .= " and date_format(wdate,'%Y-%m-%d') between '{$sch_sdate}' and '{$sch_edate}'";
			}
		//검색

		$total_rows = $this->common_m->self_q("select count(*) as total_rows from dh_deposit_return {$where_sql}","row");

		$sql = "select * from dh_deposit_return {$where_sql}";

		$PageNumber = $this->input->get("PageNumber");
		if(!$PageNumber) $PageNumber = 1;
		$list_num = 50;
		$page_num = 5;
		$offset = $list_num*($PageNumber-1);
		$url = self_url();
		$data['totalCnt'] = $total_rows->total_rows;
		$data['Page'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['qs']);
		//$data['listNo'] = $data['totalCnt']-$list_num*($PageNumber-1);

		$sql .= " order by idx desc limit {$offset},{$list_num}";

		$data['list'] = $this->common_m->self_q($sql,"result");
		$this->load->view("/dhadm/member/deposit_return",$data);
	}

	public function deposit()
	{
		$idx = $this->uri->segment(3);
		$data['mem_row']=$this->common_m->getRow("dh_member","where idx='$idx'");
		$data['list'] = $this->common_m->getList2("dh_deposit","where userid='".$data['mem_row']->userid."' order by idx desc");
		$data['total_point'] = $this->common_m->getSum("dh_deposit","point", "where userid='".$data['mem_row']->userid."'");

		if($this->input->post("content") && $this->input->post("sum") && $this->input->post("point")){

			$insert_array = array(
				'userid' => $data['mem_row']->userid,
				'point' => $this->input->post("sum").$this->input->post("point",TRUE),
				'content' => $this->input->post("content",TRUE),
				'reg_date' => timenow()
			);

			$result = $this->common_m->insert2("dh_deposit",$insert_array);
			result($result, "등록", cdir()."/".$this->uri->segment(1)."/deposit/".$idx."/?ajax=1");

		}else if($this->input->post('del_idx') && $this->input->post('del_ok')==1){

			$result = $this->common_m->del("dh_deposit","idx", $this->input->post('del_idx')); //해당 유저 삭제
			result($result, "삭제", cdir()."/".$this->uri->segment(1)."/deposit/".$idx."/?ajax=1");

		}else{

			$this->load->view('/dhadm/member/point', $data);
		}
	}

}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */