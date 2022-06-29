<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dh_Member extends CI_Controller {

 	function __construct()
	{
		parent::__construct();
    $this->load->model('member_m');
    $this->load->model('product_m');
		$this->load->helper('form');

		if(!$this->input->get('file_down')){
			@header("Content-Type: text/html; charset=utf-8");
		}
	}


	public function index()
	{
		alert("/");
  }

	public function _remap($method) //모든 페이지에 적용되는 기본 설정.
	{
		$data['cate_data'] = $this->product_m->header_cate(); //헤더에 보여질 모든 카테고리 리스트
		$data['shop_info'] = $this->common_m->shop_info(); //shop 정보
		$data['deliv_extend'] = $this->common_m->not_deliv_arr();

		if($this->session->userdata('USERID')){
			$data['member_info'] = $this->common_m->self_q("select * from dh_member where userid = '".$this->session->userdata('USERID')."'","row");
		}

		if($data['shop_info']['mobile_use']=="y"){
			$this->common_m->defaultChk();
		}

		$this->{"{$method}"}($data);
	}


	public function main()
	{
		$this->count_m->count_add();
		$this->load->view('/html/main');
		$data['popup'] = $this->common_m->popup_list('where'); //팝업 불러오기
		$this->load->view('/common/popup',$data);
	}


	public function login($data='')
	{
		if($this->session->userdata('USERID')){
			result(1,'','/html/dh_member/mypage');
		}else{

			if($this->input->post('userid')) $userid = $this->input->post('userid');
			else if($this->input->post('userid_header')) $userid = $this->input->post('userid_header');
			else	$userid = $this->input->post('sns_userid');

			if($this->input->post('passwd')) $passwd = $this->input->post('passwd');
			else if($this->input->post('passwd_header')) $passwd = $this->input->post('passwd_header');
			else	$passwd = $this->input->post('sns_passwd');

			if($userid && $passwd){ //로그인

				$auth_data = array(
					'userid' => $userid,
					'passwd' => $passwd
				);
				$result = $this->member_m->user_login($auth_data);

				if($result && $result->di == ""){
					alert("/html/dh/identity","회원정책 변경으로 인하여 본인인증 후 이용해주세요.");
					exit;
				}

				if($result)
				{
					$newdata = array(
						'USERID' => $result->userid,
						'PASSWD' => $result->passwd,
						'NAME' => $result->name,
						'LEVEL' => $result->level,
						'NICKNAME' => $result->nick
					);

					//로그인시 보관함 정보 업데이트
					$where['cart_id'] = $this->session->userdata('CART');
					$tmp_cart_update_data['userid'] = $result->userid;
					$this->common_m->update2("dh_freecart_tmp",$tmp_cart_update_data,$where);
					$this->common_m->update2("dh_salescart_tmp",$tmp_cart_update_data,$where);
					//로그인시 보관함 정보 업데이트 종료

					//로그인시 등급업 조건 확인
					$lev_info = $this->common_m->self_q("select * from dh_member_level order by level desc","result");
					$lev_info_arr = array();
					foreach($lev_info as $lv){
						$lev_info_arr[$lv->level]['levup_price'] = $lv->level_up_price;
					}

					$sql = "select sum(total_price) as tp from dh_trade where trade_stat = '4' and userid = '".$result->userid."'";
					$level_up = $this->common_m->self_q($sql,"row");

					if($level_up->tp > 0){	//구매액이 있을경우
						//회원 등업 정보 호출
						$lev = "";
						foreach($lev_info_arr as $key=>$price){
							if($level_up->tp > $price['levup_price']){
								$lev = $key;
								break;
							}
						}

						if($lev > 1){
							$where2['userid'] = $result->userid;

							$update2['level'] = $lev;

							if($result->level < 4 && $result->level != $lev){
								$result = $this->common_m->update2("dh_member",$update2,$where2);
								if($result){
									$level_his['userid'] = $result->userid;
									$level_his['before_level'] = $result->level;
									$level_his['after_level'] = $lev;
									$level_his['info'] = "사용자 로그인시 권한이 변경되었습니다.";
									$level_his['wdate'] = timenow();

									//로그인시 변경된 내용 기록
									$this->common_m->insert2("dh_member_level_change",$level_his);
								}
							}

						}
					}

					//로그인시 등급업 조건 확인 종료

					$this->session->set_userdata($newdata);

					$update_data = array(
						'table' => 'dh_member',
						'userid' => $result->userid,
						'passwd' => $result->passwd
					);
					$this->member_m->update('login_member',$update_data);
					$result = $this->common_m->getRow("dh_member","where userid='".$result->userid."'");
					$go_url="";

					if($this->input->post("save_id")){
						$cookie_id = $userid;
						setcookie('cookie_id',$cookie_id,time()+864000,'/');
					}else{
						setcookie('cookie_id','',0,'/');
					}

					if($this->input->get_post('go_url')){
						$view_page = $this->input->get_post('go_url');
						//$view_page = str_replace("&lg=1&","",$view_page);
						//$go_url = "?".$this->input->get_post('go_url');
					}else{
						$view_page = "/html";
					}

						$date = date("Y-m-d",strtotime("-6 month",strtotime(date("Y-m-d"))));

						$edit_date = substr($result->edit_date,0,10);
						$register = substr($result->register,0,10);

						//if($edit_date == "0000-00-00" && $register < $date){ //회원 가입 후 6개월 간 비밀번호 변경 내역이 있는지검사
						//	$view_page = "/html/dh_member/change_pw".$go_url;
						//}else if($edit_date != "0000-00-00" && $edit_date < $date){ //비밀번호 변경 후 6개월 간 내역이 있는지 검사
						//	$view_page = "/html/dh_member/change_pw".$go_url;
						//}

						alert($view_page);


				}
				else{
					$row = $this->common_m->self_q("select * from dh_member where userid = '{$userid}'","row");
					if($row->outtype=='아이디 통합'){
						back('본인인증 과정에서 탈퇴처리된 아이디입니다.\\n통합된 아이디를 확인해주세요.\\n(산골홈페이지, 네이버, 카카오)\\n확인이 어려울 시 고객센터(1522-3176) 문의하여 주세요.');
					}
					else{
						back('아이디와 패스워드가 올바르지 않습니다.');
					}
				}

			}else{
				$dir = $_SERVER['DOCUMENT_ROOT']."/html/application/views/member/";
				$view="login";
				$data['view'] = $dir.$view;

				if($this->input->get_post("go_url")){
					$data['go_url'] = $this->input->get_post("go_url");
				}

				$this->load->view('/html/'.$view, $data);
			}

		}
	}


	public function logout() //유저 로그아웃
	{
		$array_items = array('USERID' => '', 'PASSWD' => '', 'NAME' => '', 'LEVEL' => '', 'CART' => '');
		$this->session->unset_userdata($array_items);

		alert(cdir());

	}



	public function join($data='')
	{
		$userChk = $this->uri->segment(3);
		if($userChk && $this->input->get("userChkid")){

			$userChkid = $this->input->get("userChkid",true);
			//$cnt = $this->common_m->getCount("dh_member", "where userid='".$this->db->escape_str($userChkid)."' and outmode!=1");
			//20190822 탈퇴 회원의 아이디도 못쓰도록 변경
			$cnt = $this->common_m->getCount("dh_member", "where userid='".$this->db->escape_str($userChkid)."'");
			echo $cnt;

		}
		else if($userChk == "nick_chk" and $this->input->get('nickname')){
			$cnt = $this->common_m->self_q("select * from dh_member where nick = '".$this->input->get('nickname')."'","cnt");
			echo $cnt;
		}
		else if($userChk == "recomid_chk" and $this->input->get('recomid')){
			$row = $this->common_m->self_q("select * from dh_member where userid = '".$this->input->get('recomid')."'","row");
			$json = array();
			$json['cnt'] = count($row);
			$json['name'] = preg_replace('/.(?!.)/u','○',$row->name);
			//echo $cnt;
			echo json_encode($json);
		}
		else{

			$dir = $_SERVER['DOCUMENT_ROOT']."/html/application/views/member/";


				if($this->input->get("agree")==1){
					if($this->input->get("ok")==1){

						if($this->input->post('userid') && $this->input->post('name')){

							$userid = $this->input->get("userid",TRUE);
							$cnt = $this->common_m->getCount("dh_member", "where userid='".$this->db->escape_str($userid)."'");
							if($cnt){
								back('이미 사용중인 아이디 입니다.');
							}else{

								$passwd = $this->member_m->sql_password($this->input->post('passwd'));
								$email = $this->input->post('email1',TRUE)."@".$this->input->post('email2',TRUE);

								//휴대폰 , 이메일로 중복가입 방지 로직 추가 20180918 디자인허브 김기엽
								/*
								$duplicate_pmail = $this->common_m->self_q("select * from dh_member where email = '{$email}' or (phone1 = '".$this->input->post('phone1')."' and phone2 = '".$this->input->post('phone2')."' and phone3 = '".$this->input->post('phone3')."')","cnt");

								if($duplicate_pmail){
									back("이미 가입된 핸드폰번호 또는 이메일이 있습니다.");
								}
								*/

								$birth_month = (strlen($this->input->post('birth_month')) > 1)?$this->input->post('birth_month'):"0".$this->input->post('birth_month');

								$write_data = array(
									'table' => 'dh_member',
									'userid' => $this->input->post('userid',TRUE),
									'passwd' => $passwd,
									'di' => $this->input->post('dupinfo'),
									'regist_type' => $this->input->post('regist_type'),
									'name' => $this->input->post('name',TRUE),
									'nick' => $this->input->post('nick',TRUE),
									'email' => $email,
									'birth_year' => $this->input->post('birth_year',TRUE),
									'birth_month' => $birth_month,
									'birth_date' => $this->input->post('birth_date',TRUE),
									'birth_gubun' => $this->input->post('birth_gubun',TRUE),
									'zip1' => $this->input->post('zip1',TRUE),
									'add1' => $this->input->post('add1',TRUE),
									'add2' => $this->input->post('add2',TRUE),
									'tel1' => $this->input->post('tel1',TRUE),
									'tel2' => $this->input->post('tel2',TRUE),
									'tel3' => $this->input->post('tel3',TRUE),
									'phone1' => $this->input->post('phone1',TRUE),
									'phone2' => $this->input->post('phone2',TRUE),
									'phone3' => $this->input->post('phone3',TRUE),
									'mailing' => $this->input->post('mailing',TRUE),
									'resms' => $this->input->post('resms',TRUE),
									'baby1_name' => $this->input->post('baby1_name'),
									'baby2_name' => $this->input->post('baby2_name'),
									'baby3_name' => $this->input->post('baby3_name'),
									'baby1_birth' => $this->input->post('baby1_birth'),
									'baby2_birth' => $this->input->post('baby2_birth'),
									'baby3_birth' => $this->input->post('baby3_birth'),
									'baby1_gender' => $this->input->post('baby1_gender'),
									'baby2_gender' => $this->input->post('baby2_gender'),
									'baby3_gender' => $this->input->post('baby3_gender'),
									'baby_info' => serialize($baby_info),
									'recomid' => $this->input->post('recomid',TRUE),
									'level' => 1
								);

								if( $this->input->post('chin_use') == "Y" ){
									$write_data['chin_zip'] = $this->input->post('chin_zip');
									$write_data['chin_addr1'] = $this->input->post('chin_add1');
									$write_data['chin_addr2'] = $this->input->post('chin_add2');
									$write_data['chin_name'] = $this->input->post('chin_name');
									$write_data['chin_phone1'] = $this->input->post('chin_phone1');
									$write_data['chin_phone2'] = $this->input->post('chin_phone2');
									$write_data['chin_phone3'] = $this->input->post('chin_phone3');
								}

								if( $this->input->post('sidc_use') == "Y" ){
									$write_data['sidc_zip'] = $this->input->post('sidc_zip');
									$write_data['sidc_addr1'] = $this->input->post('sidc_add1');
									$write_data['sidc_addr2'] = $this->input->post('sidc_add2');
									$write_data['sidc_name'] = $this->input->post('sidc_name');
									$write_data['sidc_phone1'] = $this->input->post('sidc_phone1');
									$write_data['sidc_phone2'] = $this->input->post('sidc_phone2');
									$write_data['sidc_phone3'] = $this->input->post('sidc_phone3');
								}

								if( $this->input->post('bomo_use') == "Y" ){
									$write_data['bomo_zip'] = $this->input->post('bomo_zip');
									$write_data['bomo_addr1'] = $this->input->post('bomo_add1');
									$write_data['bomo_addr2'] = $this->input->post('bomo_add2');
									$write_data['bomo_name'] = $this->input->post('bomo_name');
									$write_data['bomo_phone1'] = $this->input->post('bomo_phone1');
									$write_data['bomo_phone2'] = $this->input->post('bomo_phone2');
									$write_data['bomo_phone3'] = $this->input->post('bomo_phone3');
								}

								$result = $this->member_m->insert('member',$write_data); //회원 추가

								if($result){
									$idx = $result;

									if($data['shop_info']['shop_use']=='y'){ //쇼핑몰사용이면 포인트지급
										$insert_array = array(
											'userid' => $this->input->post('userid',TRUE),
											'point' => $data['shop_info']['point_register'],
											'content' => '신규가입 축하포인트 지급',
											'flag' => 'join'
										);

										if($this->input->post('regist_type') != "sns"){
											$result = $this->member_m->point_insert($insert_array);
										}

									}

									//회원 가입후 로그인을 시켜준다 2018-07-12.
									$sess_data['USERID'] = $write_data['userid'];
									$sess_data['PASSWD'] = $write_data['passwd'];
									$sess_data['NAME'] = $write_data['name'];
									$sess_data['LEVEL'] = "1";

									$this->session->set_userdata($sess_data);

									$update_data = array(
										'table' => 'dh_member',
										'userid' => $sess_data['USERID'],
										'passwd' => $sess_data['PASSWD']
									);
									$result = $this->member_m->update('login_member',$update_data);

									if($result){
										result($result, "", cdir()."/dh_member/join?agree=1&ok=1&idx=".$idx);
									}

								}else{
									back('회원가입에 실패하였습니다. 다시 시도하여 주세요.');
									exit;
								}
							}

						}else{
							$idx = $this->input->get("idx",TRUE);
							$data['row'] = $this->common_m->getRow("dh_member","where idx='".$this->db->escape_str($idx)."'");
							$view = "join_ok";
						}

					}
					else if($this->input->get("agree")==1){		// && $this->input->post('agree02')==1
						if($this->input->post('dupinfo')){
							//본인인증값 기록
							$nice['name'] = urldecode($this->input->post('name'));
							$nice['birthdate'] = $this->input->post('birthdate');
							$nice['gender'] = $this->input->post('gender');
							$nice['dupinfo'] = $this->input->post('dupinfo');
							$nice['mobileno'] = $this->input->post('mobileno');
							$nice['mobileco'] = $this->input->post('mobileco');
							$nice['certifi_type'] = "mem_join - ".$this->input->post('certifi_type');
							$nice['wdate'] = timenow();

							$result = $this->common_m->insert2("dh_nice_chk",$nice);

							//dupinfo 인증값 기준 중복검사
							//$cnt = $this->common_m->self_q("select * from dh_member where di = '".$this->input->post('dupinfo')."' and outmode != 1","cnt");
							$cnt = $this->common_m->self_q("select * from dh_member where di = '".$this->input->post('dupinfo')."'","cnt");
							if($cnt){
								alert(cdir(),"이미 가입된 정보가 있습니다.");
							}
							$view = "join02";
						}
						else{
							$view = "join_certifi";
						}

					}
					else{
						back();
					}

				}else{
					$data['agreement'] = $this->common_m->getRow("dh_page", "where page_index='agreement'");
					$data['safeguard'] = $this->common_m->getRow("dh_page", "where page_index='safeguard'");
					$view = "join01";
				}

				$data['view'] = $dir.$view;

				$this->load->view('/html/'.$view, $data);

				}

	}


	public function mypage($data='')
	{
		if(!$this->session->userdata('USERID')){
			//alert('/html/dh_member/login/?go_url=/html/dh_member/mypage/');
			//exit;
			$this->load->view("/html/please_login",$data);
		}

		$userid = $this->session->userdata('USERID');
		$data['row'] = $this->common_m->getRow("dh_member","where userid='".$this->db->escape_str($userid)."' and outmode!=1");



			if($this->input->post('idx')){

				$passwd = $this->member_m->sql_password($this->input->post('passwd'));

				$pwd_cnt = $this->common_m->getCount("dh_member", "where userid='".$this->db->escape_str($userid)."' and passwd='".$this->db->escape_str($passwd)."'");
				if($pwd_cnt==0){ back('비밀번호가 일치하지 않습니다.'); exit; }

				if($this->input->post('new_passwd',TRUE)){
					$passwd = $this->member_m->sql_password($this->input->post('new_passwd'));
				}else{
					$passwd = $data['row']->passwd;
				}

				$email = $this->input->post('email1',TRUE)."@".$this->input->post('email2',TRUE);

				$birth_month = (strlen($this->input->post('birth_month')) > 1)?$this->input->post('birth_month'):"0".$this->input->post('birth_month');

				$update_data = array(
					'table' => 'dh_member',
					'idx' => $this->input->post('idx'),
					'passwd' => $passwd,
					'birth_year' => $this->input->post('birth_year',TRUE),
					'birth_month' => $birth_month,
					'birth_date' => $this->input->post('birth_date',TRUE),
					'email' => $email,
					'tel1' => $this->input->post('tel1',TRUE),
					'tel2' => $this->input->post('tel2',TRUE),
					'tel3' => $this->input->post('tel3',TRUE),
					'phone1' => $this->input->post('phone1',TRUE),
					'phone2' => $this->input->post('phone2',TRUE),
					'phone3' => $this->input->post('phone3',TRUE),
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
					'resms' => $this->input->post('resms',TRUE),
					'mailing' => $this->input->post('mailing',TRUE)
				);

				$result = $this->member_m->update('member',$update_data);


				if($result)
				{
					$userid = $this->input->post('userid',TRUE);
					if($this->input->post('userid',TRUE)==""){
						$userid = $this->session->userdata('USERID');
					}

					$name = $this->session->userdata('NAME');
					$level = $this->session->userdata('LEVEL');
					$nick = $this->session->userdata('NICKNAME');

					$newdata = array(
					'USERID' => $userid,
					'PASSWD' => $passwd,
					'NAME' => $name,
					'LEVEL' => $level,
					'NICKNAME' => $nick
					);

					$this->session->set_userdata($newdata);

					alert($_SERVER['HTTP_REFERER'],'수정되었습니다');
				}
				else
				{
					back('수정에 실패하였습니다.');
				}

		}else{

			$dir = $_SERVER['DOCUMENT_ROOT']."/html/application/views/member/";
			$view = "mypage";
			$data['view'] = $dir.$view;
			$this->load->view('/html/'.$view, $data);

		}
	}


	public function change_pw($data='') //회원가입 후 6개월간 비밀번호 변경안햇을 시 나오는 페이지
	{
		$data['mem_stat'] = $this->common_m->getRow2("dh_member","where userid='".$this->session->userdata('USERID')."'"); // 유저 정보


				if($this->input->post('idx') && $this->input->post('passwd_old') && $this->input->post('passwd')){

				$go_url = $this->input->post('go_url');

				if(!$go_url){ $go_url = "/html/"; }


					$passwd_old = md5($this->input->post('passwd_old'));

					if($passwd_old != $data['mem_stat']->passwd){
						alert(cdir().'/dh_member/change_pw/?go_url='.$go_url,'현재 비밀번호가 정확하지 않습니다.');
					}else{

						$passwd = md5($this->input->post('passwd',TRUE));

						$update_data = array(
							'table' => 'dh_member',
							'userid' => $this->input->post('userid',TRUE),
							'idx' => $this->input->post('idx'),
							'passwd' => $passwd
						);

						$result = $this->member_m->update('member_pwd',$update_data);


						if($result)
						{

							$newdata = array(
							'USERID' => $data['mem_stat']->userid,
							'PASSWD' => $passwd,
							'NAME' => $data['mem_stat']->name
							);

							$this->session->set_userdata($newdata);

							alert($go_url,'비밀번호가 변경되었습니다.');
						}

					}

				}

		$dir = $_SERVER['DOCUMENT_ROOT']."/html/application/views/member/";
		$view = "change_pw";
		$data['view'] = $dir.$view;
		$this->load->view('/member/'.$view, $data);
	}


	public function leave($data='')
	{
		if(!$this->session->userdata('USERID')){
			//			alert(cdir().'/dh_member/login/?go_url='.cdir().'/dh_member/leave/');
			//			exit;
			$this->load->view("/html/please_login",$data);
		}

		$userid = $this->session->userdata('USERID');
		$data['row'] = $this->common_m->getRow("dh_member","where userid='$userid' and outmode!=1");


		if($this->input->post('del_idx')){
			if($this->input->post('mode') == "sns"){
				$passwd = $this->input->post('passwd');
			}
			else{
				$passwd = $this->member_m->sql_password($this->input->post('passwd',TRUE));
			}
			$cnt = $this->common_m->getCount("dh_member","where userid='$userid' and outmode!=1 and passwd='".$passwd."'");
			if($cnt){

			$del_data = array(
				'table' => 'dh_member',
				'idx' => $this->input->post('del_idx', TRUE),
				'outtype' => $this->input->post('outtype', TRUE),
				'outmsg' => $this->input->post('outmsg'),
			);

			$result = $this->member_m->update('member_del',$del_data);

			result($result, "탈퇴처리", cdir()."/dh_member/logout");

			}else{
				back('비밀번호가 일치하지 않습니다.');
				exit;
			}

		}else{

			$dir = $_SERVER['DOCUMENT_ROOT']."/html/application/views/member/";
			$view = "leave";
			$data['view'] = $dir.$view;
			$this->load->view('/html/'.$view, $data);

		}
	}


	public function find_id($data='')
	{
		if($this->session->userdata('USERID')){
			result(1,'','/html/dh_member/mypage');
			exit;
		}

		$name = $this->db->escape_str($this->input->post('name',true));
		$phone1 = $this->db->escape_str($this->input->post('phone1',true));
		$phone2 = $this->db->escape_str($this->input->post('phone2',true));
		$phone3 = $this->db->escape_str($this->input->post('phone3',true));
		$email = $this->db->escape_str($this->input->post('email',true));
		$data['find_cnt'] = 0;

		if($this->input->post('find_mode') && $name){

			if($this->input->post('find_mode')==1 && $phone1 && $phone2 && $phone3){

				$find_cnt = $this->common_m->getCount("dh_member","where name='$name' and phone1='$phone1' and phone2='$phone2' and phone3='$phone3'");
				//$findRow = $this->common_m->getRow("dh_member","where name='$name' and phone1='$phone1' and phone2='$phone2' and phone3='$phone3'");
				$find_list = $this->common_m->self_q("select * from dh_member where name='$name' and phone1='$phone1' and phone2='$phone2' and phone3='$phone3' and outmode != '1'","result");


			}else if($this->input->post('find_mode')==2 && $email){

				$find_cnt = $this->common_m->getCount("dh_member","where name='$name' and email='$email'");
				//$findRow = $this->common_m->getRow("dh_member","where name='$name' and email='$email'");
				$find_list = $this->common_m->self_q("select * from dh_member where name='$name' and email='$email' and outmode != '1'","result");


			}

			if($find_cnt > 0){

				$data['findRow'] = $find_list;
				$data['find_cnt'] = 1;

			}else{
				back("일치하는 정보가 없습니다.");
				exit;
			}

		}

		$dir = $_SERVER['DOCUMENT_ROOT']."/html/application/views/member/";
		$view = "find_id";
		$data['view'] = $dir.$view;
		$this->load->view('/html/'.$view, $data);


	}

	public function find_pw($data='')
	{
		/*
		if($this->session->userdata('USERID')){
			result(1,'','/html/dh_member/mypage');
			exit;
		}

		$userid = $this->db->escape_str($this->input->post('userid',true));
		$name = $this->db->escape_str($this->input->post('name',true));
		$phone1 = $this->db->escape_str($this->input->post('phone1',true));
		$phone2 = $this->db->escape_str($this->input->post('phone2',true));
		$phone3 = $this->db->escape_str($this->input->post('phone3',true));
		$email = $this->db->escape_str($this->input->post('email',true));
		$data['find_cnt'] = 0;


		if($this->input->post('find_mode') && $userid && $name){

			if($this->input->post('find_mode')==1 && $phone1 && $phone2 && $phone3){

				$find_cnt = $this->common_m->getCount("dh_member","where userid = '$userid' and name='$name' and phone1='$phone1' and phone2='$phone2' and phone3='$phone3'");
				$findRow = $this->common_m->getRow("dh_member","where userid = '$userid' and name='$name' and phone1='$phone1' and phone2='$phone2' and phone3='$phone3'");


			}else if($this->input->post('find_mode')==2 && $email){

				$find_cnt = $this->common_m->getCount("dh_member","where userid = '$userid' and name='$name' and email='$email'");
				$findRow = $this->common_m->getRow("dh_member","where userid = '$userid' and name='$name' and email='$email'");


			}

			if($findRow->regist_type == "sns"){
				back("SNS연동 회원은 비밀번호를 변경할 수 없습니다.");
			}

			if($find_cnt > 0){

				$data['findRow'] = $findRow;
				$result = $this->common_m->mailform("2",$data);
				if($result){
					$data['find_cnt'] = 1;
				}

			}else{
				back("일치하는 정보가 없습니다.");
				exit;
			}

		}



		$dir = $_SERVER['DOCUMENT_ROOT']."/html/application/views/member/";
		$view = "find_pw";
		$data['view'] = $dir.$view;
		$this->load->view('/html/'.$view, $data);
		*/
		if($this->session->userdata('USERID')){
			result(1,'','/html/dh_member/mypage');
			exit;
		}

		$data['find_cnt'] = 0;

		$di = $this->input->post('dupinfo');
		$idx =$this->input->post('mem_idx',true);
		$passchg = $this->input->post('passchg',true);
		$post_pass = $this->input->post('passwd',true);

		$name = $this->input->post("name");
		$uidx = $this->input->post('useridx');
		$userid = $this->input->post('userid');

		if($passchg == "ok"){
			$passwd = $this->member_m->sql_password($post_pass);

			$row = $this->common_m->self_q("select * from dh_member where idx = '{$idx}'","row");
			if($row->passwd == $passwd){
				back("현재 비밀번호와 동일하게 변경 할 수 없습니다.");
			}

			$sql = "update dh_member set passwd = '{$passwd}', edit_date=now() where idx = '{$idx}'";
			$result = $this->common_m->self_q($sql,"update");
			if($result){
				alert(cdir()."/dh_member/login","비밀번호가 변경처리 되었습니다.");
			}
		}
		else{
			if($userid){
				$row = $this->common_m->self_q("select idx from dh_member where userid = '{$userid}' and outmode!=1","row");
				if($row->idx){
					?>
					<form method="post" name="midx">
						<input type="hidden" name="idx" value="<?=$row->idx?>">
					</form>
					<script type="text/javascript">
						document.midx.submit();
					</script>
					<?php
				}
				else{
					alert(cdir()."/dh_member/find_pw","일치하는 정보가 없습니다.");
					exit;
				}
			}
			else if($uidx){

				//본인인증값 기록
				$nice['name'] = urldecode($this->input->post('name'));
				$nice['birthdate'] = $this->input->post('birthdate');
				$nice['gender'] = $this->input->post('gender');
				$nice['dupinfo'] = $this->input->post('dupinfo');
				$nice['mobileno'] = $this->input->post('mobileno');
				$nice['mobileco'] = $this->input->post('mobileco');
				$nice['certifi_type'] = "find_pw - ".$this->input->post('certifi_type');
				$nice['wdate'] = timenow();

				$result = $this->common_m->insert2("dh_nice_chk",$nice);

				$sql = "select * from dh_member where di = '{$di}' and idx = '{$uidx}'";

				$find_cnt = $this->common_m->self_q($sql,"cnt");
				$findRow = $this->common_m->self_q($sql,"row");

				if($find_cnt > 0){

					if($findRow->regist_type == "sns"){
						$sns_name_tmp = explode("_",$findRow->userid);
						$sns_name='';
						switch($sns_name_tmp[0]){
							case "nv": $sns_name = "네이버"; break;
							case "kko": $sns_name = "카카오"; break;
						}
						alert(cdir(),"고객님은 {$sns_name}로 가입하셨습니다.");
					}
					else{

						//본인인증후 인증값과 DB 대조 (dupinfo 동일여부 확인)
						if($di == $findRow->di){
							$data['findRow'] = $findRow;
							$data['find_cnt'] = 1;
						}
						else{
							alert(cdir()."/dh_member/login","본인인증값이 조회되지 않습니다.");
						}

					}

				}else{
					alert(cdir()."/dh_member/find_pw","일치하는 정보가 없습니다.");
					exit;
				}
			}
		}



		$dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/member/";
		$view = "find_pw";
		$data['view'] = $dir.$view;
		$this->load->view('/html/'.$view, $data);
	}

	public function post_search($data='')
	{
		$dir = $_SERVER['DOCUMENT_ROOT']."/html/application/views/member/";
		$view = "post_search";
		$data['view'] = $dir.$view;
		$this->load->view('/member/'.$view, $data);
	}

	public function mypage_idx($data=''){
		if(!$this->session->userdata('USERID')){
			//alert(cdir()."/dh_member/login",'로그인 후 사용 가능합니다.');
			$this->load->view("/html/please_login",$data);
		}
		$view = "mypage_idx";

		$userid = $this->session->userdata('USERID');

		$data['order_cnt'] = $this->common_m->self_q("select * from dh_trade where userid = '".$this->session->userdata('USERID')."' and trade_stat < 5","cnt");
		$data['order_deliv_cnt'] = $this->common_m->self_q("select * from dh_trade where userid = '".$this->session->userdata('USERID')."' and trade_stat between 2 and 3","cnt");
		$data['coupon_cnt'] = $this->common_m->self_q("select * from dh_coupon_use where userid='".$this->session->userdata('USERID')."' and '".date('Y-m-d')."' between start_date and end_date and trade_code = ''","cnt");
		$data['point'] = $this->common_m->self_q("select sum(point) as point from dh_point where userid='".$this->session->userdata('USERID')."'","row");

		$data['list'] = $this->common_m->self_q("select * from dh_trade where userid = '".$this->session->userdata('USERID')."' order by trade_day desc limit 3","result");

		$data['week_name_arr'] = array('일','월','화','수','목','금','토');

		$data['notice'] = $this->common_m->self_q("select * from dh_bbs_data where code = 'withcons01' order by idx desc limit 5","result");
		$data['qna'] = $this->common_m->self_q("select * from dh_bbs_data where code = 'withcons07' and userid = '{$userid}' order by idx desc limit 5","result");

		$deposit = $this->common_m->self_q("select sum(point) as dps from dh_deposit where userid = '".$this->session->userdata('USERID')."'","row");
		$data['total_deposit'] = $deposit->dps;


		$this->load->view('/html/'.$view, $data);
	}

	public function fbjoin($data=''){	//페이스북 로그인
		if($_POST){
			$name = $this->input->post("name",true);
			$userid = "fb_".$this->input->post("userid",true);
			//$pwd = md5($this->input->post("userid",true));

			$sql = "select * from dh_member where userid = '".$userid."'";
			$result = $this->common_m->self_q($sql,"row");
			if($result){
				$arr = array(
					'is_member'=>'yes',
					'userid'=>$userid,
					'passwd'=>$this->input->post("userid",true),
					'name'=>$result->name
				);
			}else{
				$arr = array(
					'is_member'=>'no',
					'userid'=>$userid,
					'passwd'=>$this->input->post("userid",true),
					'name'=>$name
				);
			}
			echo json_encode($arr);
		}
	}

	public function kkojoin($data=''){
		if($_POST){
			$userid = "kko_".$this->input->post("userid",true);

			$sql = "select * from dh_member where userid = '".$userid."'";
			$result = $this->common_m->self_q($sql,"row");
			if($result){
				$arr = array(
					'is_member'=>'yes',
					'userid'=>$userid,
					'passwd'=>$this->input->post("userid",true)
				);
			}else{
				$arr = array(
					'is_member'=>'no',
					'userid'=>$userid,
					'passwd'=>$this->input->post("userid",true)
				);
			}
			echo json_encode($arr);
		}
	}

	public function nvjoin($data=''){
		if($_POST){
			$name = $this->input->post("name",true);
			$userid = "nv_".$this->input->post("userid",true);
			//$pwd = md5($this->input->post("userid",true));

			$sql = "select * from dh_member where userid = '".$userid."'";
			$result = $this->common_m->self_q($sql,"row");
			if($result){
				$arr = array(
					'is_member'=>'yes',
					'userid'=>$userid,
					'passwd'=>$this->input->post("userid",true),
					'name'=>$result->name
				);
			}else{
				$arr = array(
					'is_member'=>'no',
					'userid'=>$userid,
					'passwd'=>$this->input->post("userid",true),
					'name'=>$name
				);
			}
			echo json_encode($arr);
		}
	}

}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */