<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Member_m extends CI_Model
{


    function __construct()
    {
        parent::__construct();
    }


		function login($auth)
		{
			$sql = "select * from dh_admin_user where userid='".$this->db->escape_str($auth['admin_userid'])."' and passwd='".$this->db->escape_str(md5($auth['admin_passwd']))."'";
			$query = $this->db->query($sql);

			if($query->num_rows() > 0)
			{

				$result = $query->row();

				$update_array = array(
					'connect' => $result->connect+1
				);

				$where = array(
					'userid' => $this->db->escape_str($auth['admin_userid'])
				);

				$result2 = $this->db->update('dh_admin_user',$update_array,$where); //접속수 증가

				return $query->row();
			}
			else
			{
				return FALSE;
			}
		}


		function user_login($auth)
		{
			$passwd = $this->sql_password($auth['passwd']);

			$sql = "select * from dh_member where userid='".$this->db->escape_str($auth['userid'])."' and passwd='".$this->db->escape_str($passwd)."' and outmode!=1";

			$query = $this->db->query($sql);

			if($query->num_rows() > 0)
			{
				$cnt = $this->common_m->getCount("dh_coupon","where type='1'"); //기념일쿠폰 검사
				if($cnt > 0){ //기념일 쿠폰이 있으면
					$row = $query->row();
					$couponList = $this->common_m->getList2("dh_coupon","where type='1' and ((member_use=1 and member_level!='' and member_level='".$row->level."') or member_use=0) order by idx");
					$nowyear = date("Y");
					$nowmonth = date("m");
					$this->load->model('order_m');
					foreach($couponList as $list){
						if($row->birth_month==$nowmonth){ //로그인 한 달이 기념일 달이면
							$couponGivCnt = $this->common_m->getCount("dh_coupon_use","where code='".$list->code."' and type='1' and userid='".$this->db->escape_str($auth['userid'])."' and reg_date like '".$nowyear."-%'"); //올해 기념일 쿠폰을 지급한적 있는지 검사
							if($couponGivCnt==0){ //올해 지급내용 없으면 쿠폰 지급
								$list->userid = $auth['userid'];
								$result = $this->order_m->couponGive($list);
							}
						}
					}
				}

				$cart = $this->session->userdata('CART');
				$cartCnt = $this->common_m->getCount("dh_cart","where code='".$cart."'");

				if($cartCnt>0){
					$this->common_m->update2("dh_cart",array('userid'=>$this->db->escape_str($auth['userid'])),array('code'=>$cart));
				}

				return $query->row();
			}
			else
			{
				return FALSE;
			}
		}


		function insert($mode,$arrays) //등록하기
		{
			if($mode == "member"){
				$insert_array = array(
					'userid' => $this->db->escape_str($arrays['userid']),
					'passwd' => $this->db->escape_str($arrays['passwd']),
					'di' => $arrays['di'],
					'regist_type' => $this->db->escape_str($arrays['regist_type']),
					'name' => $this->db->escape_str($arrays['name']),
					'nick' => $this->db->escape_str($arrays['nick']),
					'email' => $this->db->escape_str($arrays['email']),
					'birth_year' => $this->db->escape_str($arrays['birth_year']),
					'birth_month' => $this->db->escape_str($arrays['birth_month']),
					'birth_date' => $this->db->escape_str($arrays['birth_date']),
					'birth_gubun' => $this->db->escape_str($arrays['birth_gubun']),
					'zip1' => $this->db->escape_str($arrays['zip1']),
					'add1' => $this->db->escape_str($arrays['add1']),
					'add2' => $this->db->escape_str($arrays['add2']),
					'tel1' => $this->db->escape_str($arrays['tel1']),
					'tel2' => $this->db->escape_str($arrays['tel2']),
					'tel3' => $this->db->escape_str($arrays['tel3']),
					'phone1' => $this->db->escape_str($arrays['phone1']),
					'phone2' => $this->db->escape_str($arrays['phone2']),
					'phone3' => $this->db->escape_str($arrays['phone3']),
					'mailing' => $this->db->escape_str($arrays['mailing']),
					'resms' => $this->db->escape_str($arrays['resms']),
					'baby1_name' => $arrays['baby1_name'],
					'baby2_name' => $arrays['baby2_name'],
					'baby3_name' => $arrays['baby3_name'],
					'baby1_birth' => $arrays['baby1_birth'],
					'baby2_birth' => $arrays['baby2_birth'],
					'baby3_birth' => $arrays['baby3_birth'],
					'baby1_gender' => $arrays['baby1_gender'],
					'baby2_gender' => $arrays['baby2_gender'],
					'baby3_gender' => $arrays['baby3_gender'],
					'level' => $this->db->escape_str($arrays['level']),
					'recomid' => $this->db->escape_str($arrays['recomid']),
					'register' => date('Y-m-d H:i:s')
				);

				if($arrays['chin_zip'] and $arrays['chin_addr1'] and $arrays['chin_addr2'] and $arrays['chin_name'] and $arrays['chin_phone1'] and $arrays['chin_phone2'] and $arrays['chin_phone3']){
					$insert_array['chin_zip'] = $arrays['chin_zip'];
					$insert_array['chin_addr1'] = $arrays['chin_addr1'];
					$insert_array['chin_addr2'] = $arrays['chin_addr2'];
					$insert_array['chin_name'] = $arrays['chin_name'];
					$insert_array['chin_phone1'] = $arrays['chin_phone1'];
					$insert_array['chin_phone2'] = $arrays['chin_phone2'];
					$insert_array['chin_phone3'] = $arrays['chin_phone3'];
				}

				if($arrays['sidc_zip'] and $arrays['sidc_addr1'] and $arrays['sidc_addr2'] and $arrays['sidc_name'] and $arrays['sidc_phone1'] and $arrays['sidc_phone2'] and $arrays['sidc_phone3']){
					$insert_array['sidc_zip'] = $arrays['sidc_zip'];
					$insert_array['sidc_addr1'] = $arrays['sidc_addr1'];
					$insert_array['sidc_addr2'] = $arrays['sidc_addr2'];
					$insert_array['sidc_name'] = $arrays['sidc_name'];
					$insert_array['sidc_phone1'] = $arrays['sidc_phone1'];
					$insert_array['sidc_phone2'] = $arrays['sidc_phone2'];
					$insert_array['sidc_phone3'] = $arrays['sidc_phone3'];
				}

				if($arrays['bomo_zip'] and $arrays['bomo_addr1'] and $arrays['bomo_addr2'] and $arrays['bomo_name'] and $arrays['bomo_phone1'] and $arrays['bomo_phone2'] and $arrays['bomo_phone3']){
					$insert_array['bomo_zip'] = $arrays['bomo_zip'];
					$insert_array['bomo_addr1'] = $arrays['bomo_addr1'];
					$insert_array['bomo_addr2'] = $arrays['bomo_addr2'];
					$insert_array['bomo_name'] = $arrays['bomo_name'];
					$insert_array['bomo_phone1'] = $arrays['bomo_phone1'];
					$insert_array['bomo_phone2'] = $arrays['bomo_phone2'];
					$insert_array['bomo_phone3'] = $arrays['bomo_phone3'];
				}

			}

			$result = $this->db->insert(@$arrays['table'],$insert_array);
			$a_idx = mysql_insert_id();

			if($mode=="member" && $result){
				$data['idx'] = $a_idx;

				if($this->session->userdata('ADMIN_USERID')){
				}
				else{
					$result = $this->common_m->mailform(1,$data); //메일보내기
					//알림톡 보내기
					$tok_sendno = $insert_array['phone1'].$insert_array['phone2'].$insert_array['phone3'];
					$userid = $arrays['regist_type'] == "sns" ? "sns 연동회원" : $insert_array['userid'] ;
					$this->common_m->orange_kakao_send('6535',$insert_array['name'],$tok_sendno,$userid,'');

					$token = $this->kkoat_m->token_generation();

					$phone = $insert_array['phone1'].$insert_array['phone2'].$insert_array['phone3'];
					$name = $insert_array['name'];
					$add1 = $arrays['regist_type'] == "sns" ? "sns 연동회원" : $insert_array['userid'] ;

					$msg = "{$name}님.\r\n산골이유식 회원가입을 환영해요!\r\n\r\nID : {$add1}\r\n\r\n<10% 적립 이벤트>\r\n친구와 함께 적립받아가세요~\r\n1. 회원가입 시 고객님의 아이디를 \r\n추천인으로 입력하고,\r\n2. 친구분이 첫 주문하면~\r\n3. 첫 주문 금액의 10%를\r\n두 분 모두 적립드려요!\r\n\r\n* 친구의 첫 주문금액의 10% 적립\r\n* 네이버 및 카카오톡 로그인 제외\r\n* 꼭 본 공식홈페이지 로그인 이용!\r\n\r\n-에코맘의 산골이유식-";
					$tmpcode = "M_01459_120";
					$this->kkoat_m->ent_prise_kakao_send($token,$phone,$msg,$tmpcode);
				}

				$cnt = $this->common_m->getCount("dh_coupon","where type='2'");

				if($cnt > 0){ //회원가입 쿠폰이 있으면 지급
					$couponList = $this->common_m->getList2("dh_coupon","where type='2' order by idx");
					$this->load->model('order_m');
					foreach($couponList as $list){
						$list->userid = $arrays['userid'];
						$result = $this->order_m->couponGive($list);
					}
				}

				if($result){
					$result = $a_idx;
				}
			}

			return $result;
		}


		function update($mode,$arrays)
		{
			if($mode == "member"){ //멤버 수정


				$sql = "select * from dh_member where idx='".$arrays['idx']."'";
				$query = $this->db->query($sql);
				$memstat = $query->row();

				if($arrays['userid']=="") $arrays['userid'] = $memstat->userid;
				if($arrays['name']=="") $arrays['name'] = $memstat->name;
				if($arrays['nick']=="") $arrays['nick'] = $memstat->nick;
				if($arrays['level']=="") $arrays['level'] = $memstat->level;

				if($memstat->passwd!=$arrays['passwd']){
					$edit_date = date('Y-m-d H:i:s');
				}else{
					$edit_date = $memstat->edit_date;
				}

				$update_array = array(
					'userid' => $this->db->escape_str($arrays['userid']),
					'passwd' => $arrays['passwd'],
					'name' => $this->db->escape_str($arrays['name']),
					'nick' => $this->db->escape_str($arrays['nick']),
					'email' => $this->db->escape_str($arrays['email']),
					'birth_year' => $this->db->escape_str($arrays['birth_year']),
					'birth_month' => $this->db->escape_str($arrays['birth_month']),
					'birth_date' => $this->db->escape_str($arrays['birth_date']),
					'zip1' => $this->db->escape_str($arrays['zip1']),
					'add1' => $this->db->escape_str($arrays['add1']),
					'add2' => $this->db->escape_str($arrays['add2']),
					'tel1' => $this->db->escape_str($arrays['tel1']),
					'tel2' => $this->db->escape_str($arrays['tel2']),
					'tel3' => $this->db->escape_str($arrays['tel3']),
					'phone1' => $this->db->escape_str($arrays['phone1']),
					'phone2' => $this->db->escape_str($arrays['phone2']),
					'phone3' => $this->db->escape_str($arrays['phone3']),
					'mailing' => $this->db->escape_str($arrays['mailing']),
					'resms' => $this->db->escape_str($arrays['resms']),
					'baby1_name' => $arrays['baby1_name'],
					'baby2_name' => $arrays['baby2_name'],
					'baby3_name' => $arrays['baby3_name'],
					'baby1_birth' => $arrays['baby1_birth'],
					'baby2_birth' => $arrays['baby2_birth'],
					'baby3_birth' => $arrays['baby3_birth'],
					'baby1_gender' => $arrays['baby1_gender'],
					'baby2_gender' => $arrays['baby2_gender'],
					'baby3_gender' => $arrays['baby3_gender'],
					'level' => $this->db->escape_str($arrays['level']),
					'edit_date' => $edit_date
				);


				$where = array(
					'idx' => $arrays['idx']
				);

			}else if($mode == "member_del"){ //멤버 탈퇴

				if(isset($arrays['outtype']) && $arrays['outtype']!=""){

					$update_array = array(
						'outmode' => 1,
						'outtype' => $this->db->escape_str($arrays['outtype']),
						'outmsg' => $this->db->escape_str($arrays['outmsg']),
						'out_date' => date("YmdHis")
					);

				}else{
					$update_array = array('outmode' => 1,'out_date' => date("YmdHis"));
				}
				$where = array('idx' => $this->db->escape_str($arrays['idx']));

			}else if($mode == "login_member"){

				$sql = "select * from dh_member where userid='".$this->db->escape_str($arrays['userid'])."' and passwd='".$this->db->escape_str($arrays['passwd'])."'";
				$query = $this->db->query($sql);
				$memstat = $query->row();


				$update_array = array(
					'connect' => $memstat->connect + 1,
					'last_login' => date('Y-m-d H:i:s')
				);


				$where = array(
					'userid' => $arrays['userid'],
					'passwd' => $arrays['passwd'],
				);

			}else if($mode == "member_pwd"){

				$update_array = array(
					'passwd' => $arrays['passwd'],
					'edit_date' => date('Y-m-d H:i:s')
				);

				$where = array(
					'idx' => $arrays['idx']
				);

			}else if($mode == "passwd"){

				$update_array = array(
					'passwd' => $this->sql_password($arrays['passwd'])
				);

				$where = array(
					'userid' => $this->db->escape_str($arrays['userid']),
					'name' => $this->db->escape_str($arrays['name'])
				);

			}

			$result = $this->db->update($arrays['table'],$update_array,$where);

			if($result && $mode == "member_del"){ //회원탈퇴면 게시판, 포인트, 쿠폰, 주문내역 등 삭제

				$sql = "select * from dh_member where idx='".$this->db->escape_str($arrays['idx'])."'";
				$query = $this->db->query($sql);
				$memstat = $query->row();

				$result = $this->common_m->del("dh_bbs_data","userid", $memstat->userid);
				$result = $this->common_m->del("dh_point","userid", $memstat->userid);
				$result = $this->common_m->del("dh_coupon_use","userid", $memstat->userid);
				$result = $this->common_m->del("dh_trade","userid", $memstat->userid);
			}

			return $result;
		}



		function point_insert($arrays) //포인트 등록하기
		{
			$flag="";
			$flag_idx="";
			$trade_code="";
			$sum="";

			if(isset($arrays['sum']) && $arrays['sum']=="-"){ $sum=$arrays['sum']; }
			if(isset($arrays['flag']) && $arrays['flag']){ $flag=$arrays['flag']; }
			if(isset($arrays['flag_idx']) && $arrays['flag_idx']){ $flag_idx=$arrays['flag_idx']; }
			if(isset($arrays['trade_code']) && $arrays['trade_code']){ $trade_code=$arrays['trade_code']; }

			$insert_array = array(
				'userid' => $arrays['userid'],
				'point' => $sum.$arrays['point'],
				'content' => $arrays['content'],
				'flag' => $flag,
				'flag_idx' => $flag_idx,
				'trade_code' => $trade_code,
				'reg_date' => date('Y-m-d H:i:s')
			);

			$result = $this->db->insert("dh_point",$insert_array);
			return $result;
		}

		function sql_password($pass){
			$sql = "select password('{$pass}') as pass";
			$q = $this->db->query($sql);
			$r = $q->row();
			return $r->pass;
		}

		function get_smslist($table='',$type='',$offset='',$limit='', $search_item='', $search_order='', $where_query='', $sub_query='',$ex_query='') //SMS 리스트
		{
			$result = "";
			$where = "";
			$order_query = "sort, ref desc, re_step ASC, idx desc";

				$limit_query = '';

				if($limit != '' or $offset != '')
				{
					$limit_query = 'limit '.$offset.', '.$limit;
				}
				if($search_item){
					if($search_item == "all")
					{
						$where .= " and ( wr_message like '%".$this->db->escape_str($search_order)."%' or wr_reply like '%".$this->db->escape_str($search_order)."%')"; //전체검색 - 수정
					}else{
						$where .= " and ( mb_id like '%".$this->db->escape_str($search_order)."%' or hs_name like '%".$this->db->escape_str($search_order)."%' or hs_hp like '%".$this->db->escape_str($search_order)."%')";
					}
				}
				if($where_query){
					$where .= $where_query;
				}

				$sql = "select * from ".$table." where ".$sub_query." $where order by ".$ex_query." desc ".$limit_query;

				if($type == 'count')
				{
					$sql = "select count(*) as cnt from ".$table." where ".$sub_query;
					$query = $this->db->query($sql);
					$row = $query->row();
					$result = $row->cnt;
				}
				else
				{
					$query = $this->db->query($sql);
					$result = $query->result();
				}


				return $result;
		}

}