<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Common_m extends CI_Model
{


    function __construct()
    {
        parent::__construct();
    }


		function devel_array() //개발 메소드
		{
			$array = array("lists","views","write","edit","passwd","file_down","online","mypage","leave","idcheck","login","logout","email","find_id","find_pw","main","join","join_ok","member_out","upload_receive_from_ck","change_pw","facebook_ret");

			return $array;
		}

		function adm_devel_array()
		{

			$array = array("index","logout","category","popup_images","point","excel_download");

			return $array;
		}


    function get_page($page,$mode='')
    {
			if($mode=="admin"){
				if($page=="menu"){ $page = "menu/".$this->uri->segment(3); }
				$url = '/dhadm/design/'.$page;
			}else{
				$url = '/html/'.$page;
			}


    	return $url;
    }

		function getRow($table, $where_query='')
		{

			$sql = "select * from ".$table." $where_query order by idx asc limit 1";
			$query = $this->db->query($sql);
			$result = $query->row();

				return $result;
		}

		function getRow2($table, $where_query='')
		{

			$sql = "select * from ".$table." $where_query";
			$query = $this->db->query($sql);
			$result = $query->row();

				return $result;
		}


		function getRow3($table, $where_query='',$f='*')
		{

			$sql = "select $f from ".$table." $where_query";
			$query = $this->db->query($sql);
			$result = $query->row();

				return $result;
		}


		function getList($table, $where_query='')
		{

			$sql = "select * from ".$table." $where_query order by idx asc";
			$query = $this->db->query($sql);
			$result = $query->result();

			return $result;
		}


		function getList2($table, $where_query='',$f='*')
		{

			$sql = "select ".$f." from ".$table." $where_query";
			$query = $this->db->query($sql);
			$result = $query->result();

			return $result;
		}


		function getPageList($table, $type='',$offset='',$limit='', $where_query='', $order_query='idx desc', $field='*')
		{

			$limit_query = '';

			if($limit != '' or $offset != ''){ $limit_query = 'limit '.$offset.', '.$limit;	}

			$sql = "select $field from ".$table." $where_query order by $order_query ".$limit_query;
			$query = $this->db->query($sql);

			if($type == 'count'){
				$result = $query->num_rows();
			}else{
				$result = $query->result();
			}

			return $result;
		}


		function getCnt($table, $where_query='')
		{

			$sql = "select * from ".$table." $where_query";
			$query = $this->db->query($sql);
			$result = $query->num_rows();

			return $result;
		}


		function getCount($table, $where_query='',$f='*')
		{

			$sql = "select count(".$f.") as cnt from ".$table." $where_query";
			$query = $this->db->query($sql);
			$row = $query->row();
			$result = $row->cnt;

			return $result;
		}



		function getSum($table,$sum, $where_query='')
		{

			$sql = "select sum(".$sum.") as sum from ".$table." $where_query";
			$query = $this->db->query($sql);
			$row = $query->row();
			$result = $row->sum;

			return $result;
		}


		function getMax($table,$max, $where_query='')
		{
			$sql = "select max(".$max.") as ".$max." from $table $where_query";
			$query = $this->db->query($sql);
			$result = $query->row();
			$data = $result->{$max};

			return $data;
		}


		function getMin($table,$min, $where_query='')
		{
			$sql = "select min(".$min.") as ".$min." from $table $where_query";
			$query = $this->db->query($sql);
			$result = $query->row();
			$data = $result->{$min};

			return $data;
		}


		function getGroup($table,$item,$where_query='')
		{
			$sql = "SELECT distinct($item) as item FROM $table $where_query group by $item";
			$query = $this->db->query($sql);
			$result = $query->result();

			return $result;
		}


		function insert($mode,$arrays) //등록하기
		{
			if($mode == "bbs_cate"){ //게시판 카테고리 등록

				$insert_array = array(
					'code' => $arrays['code'],
					'name' => $arrays['name'],
					'register' => date('Y-m-d H:i:s')
				);

			}else if($mode=="data"){

				$arrays['table'] = "dh_data";

				$insert_array = array(
					'flag' => $arrays['flag'],
					'flag_idx' => $arrays['flag_idx'],
					'data_name' => $arrays['data_name'],
					'data_txt' => $arrays['data_txt'],
					'reg_date' => date('Y-m-d H:i:s')
				);
			}

			$result = $this->db->insert($arrays['table'],$insert_array);
			return $result;
		}

		function insert2($table,$insert_array) //등록하기
		{
			$result = $this->db->insert($table,$insert_array);
			return $result;
		}

		function update($mode,$arrays)
		{

			if($mode == "basic_userinfo"){ //관리자 정보 수정

				$update_array = array(
					'userid' => $arrays['userid'],
					'passwd' => $arrays['passwd'],
				);

				$where = array(
					'idx' => $arrays['idx']
				);

			}else if($mode == "member"){ //멤버 수정

				$update_array = array(
					'passwd' => $arrays['passwd'],
					'name' => $arrays['name'],
					'birth_year' => $arrays['birth_year'],
					'birth_month' => $arrays['birth_month'],
					'birth_date' => $arrays['birth_date'],
					'birth_gubun' => $arrays['birth_gubun'],
					'email' => $arrays['email'],
					'tel1' => $arrays['tel1'],
					'tel2' => $arrays['tel2'],
					'tel3' => $arrays['tel3'],
					'phone1' => $arrays['phone1'],
					'phone2' => $arrays['phone2'],
					'phone3' => $arrays['phone3'],
					'zip1' => $arrays['zip1'],
					'zip2' => $arrays['zip2'],
					'add1' => $arrays['add1'],
					'add2' => $arrays['add2'],
					'level' => $arrays['level'],
					'mailing' => $arrays['mailing']
				);


				$where = array(
					'idx' => $arrays['idx']
				);
			}else if($mode == "bbs_cate"){

				$update_array = array(
					'name' => $arrays['name']
				);

				$where = array(
					'idx' => $arrays['idx']
				);

			}else if($mode=="data"){

				$arrays['table'] = "dh_data";

				$update_array = array(
					'data_name' => $arrays['data_name'],
					'data_txt' => $arrays['data_txt']
				);

				$where = array(
					'idx' => $arrays['idx']
				);

			}else if($mode=="file"){

				$arrays['table'] = "dh_file";

				$update_array = array(
					'file_name' => $arrays['file_name'],
					'real_name' => $arrays['real_name']
				);

				$where = array(
					'idx' => $arrays['idx']
				);

			}

			$result = $this->db->update($arrays['table'],$update_array,$where);

			return $result;
		}


		function update2($table,$update_array,$where)
		{
			$result = $this->db->update($table,$update_array,$where);

			return $result;
		}



		function del($table,$field, $val)
		{
			$delete_array = array(
				$field=> $val
			);

			$result = $this->db->delete($table, $delete_array);

			return $result;
		}


		function del2($table,$where_query)
		{
			$sql = "delete from $table $where_query";
			$result = $this->db->query($sql);

			return $result;
		}


		function del3($table,$delete_array)
		{
			$result = $this->db->delete($table, $delete_array);

			return $result;
		}


		function popup_list($type='')
		{
				if($type=="where"){
					$now_time= date("Y-m-d");
					$sql = "select * from dh_popup where start_day <='$now_time' AND end_day >= '$now_time' and display!=2";
				}else{
					$sql = "select * from dh_popup order by idx desc";
				}

				$query = $this->db->query($sql);

				if($type == 'count')
				{
					$result = $query->num_rows();
				}
				else
				{
					$result = $query->result();
				}

				return $result;
		}


		function file_del($mode, $idx)
		{
			$row = $this->common_m->getRow("dh_file", "where flag='$mode' and idx='".$this->db->escape_str($idx)."'"); // 파일 데이터 가져오기

			$delete_array = array(
				'idx'=> $idx
			);

			$result = $this->db->delete("dh_file", $delete_array);

			if($result){ @unlink( $_SERVER['DOCUMENT_ROOT']."/_data/file/addImages/".$row->file_name ); }

			return $result;
		}


		function getDataList($mode,$idx) //dh_data 리스트 가져오기
		{
			$sql = "select * from dh_data where flag='$mode' and flag_idx='".$this->db->escape_str($idx)."' order by idx";
			$query = $this->db->query($sql);
			$result = $query->result();

			return $result;
		}


		function getFileList($mode,$idx) //dh_data 리스트 가져오기
		{
			$sql = "select * from dh_file where flag='$mode' and flag_idx='".$this->db->escape_str($idx)."' order by idx";
			$query = $this->db->query($sql);
			$result = $query->result();

			return $result;
		}


		function file_down_m($mode, $idx, $file_num='') //파일다운로드
		{
			switch($mode)
			{
				case "bbs" :
					$sql = "select bbs_file,real_file,bbs_file2,real_file2 from dh_bbs_data where idx='".$this->db->escape_str($idx)."'";
					$dir = "../_data/file/bbsData/";

					$query = $this->db->query($sql);
					$result = $query->row();

					if($file_num == 1){
						$data['file'] = $dir.$result->bbs_file;
						$data['file2'] = urlencode($result->real_file);
					}else{
						$data['file'] = $dir.$result->bbs_file2;
						$data['file2'] = urlencode($result->real_file2);
					}

				break;
			}

			return $data;
		}

		function shop_info()
		{
			$sql = "select * from dh_shop_info order by idx asc";
			$query = $this->db->query($sql);
			$result = $query->result();

			foreach($result as $row){
				$shop_row[$row->name] = $row->val;
			}

			return $shop_row;

		}

	public function mailform($item, $data='')
	{
		$shop_info = $this->shop_info();
		$mailform_stat = $this->common_m->getRow("dh_mailform", "where item=".$item); //메일폼정보

		/* 공통적용 */
		$to_content = str_replace("[shop_url]", $shop_info['shop_domain'], $mailform_stat->content);
		$to_content = str_replace("[shop_name]",$shop_info['shop_name'], $to_content);
		$to_content = str_replace("[shop_addr]",$shop_info['shop_address'], $to_content);
		$to_content = str_replace("[shop_tel]",$shop_info['shop_tel1'], $to_content);
		$to_content = str_replace("[shop_fax]",$shop_info['shop_fax'], $to_content);
		/* 공통적용 */

		if($item=="1"){ //회원가입

			$idx = $data['idx'];
			$member_stat = $this->common_m->getRow("dh_member","where idx='".$this->db->escape_str($idx)."'");

			$to_content = str_replace("[user_name]", $member_stat->name, $to_content);
			$to_content = str_replace("[userid]", $member_stat->userid, $to_content);

			$title= str_replace("[shop_name]",$shop_info['shop_name'],$mailform_stat->title);

			// 보내는 사람
			$from_email	=	$shop_info['shop_email'];	//보내는 사람 주소(@ 다음에는 반드시 도메인과 일치해야만 합니다.)
			$from_name	=	$shop_info['shop_name'];

			// 받는 사람
			$name       = $member_stat->name;
			$email			= $member_stat->email;		//받는사람 주소

		}else if($item=="2"){ //비밀번호 찾기

			$findRow = $data['findRow'];

			$passwd = $this->common_m->get_random_string('azAZ$');

			$to_content = str_replace("[user_name]", $findRow->userid, $to_content);
			$to_content = str_replace("[password]", $passwd, $to_content);
			$to_content = str_replace("[login_url]", "html/dh_member/login", $to_content);
			$to_content = str_replace("[mypage_url]", "/html/dh_member/mypage", $to_content);

			$title= str_replace("[shop_name]",$shop_info['shop_name'],$mailform_stat->title);

			// 보내는 사람
			$from_email	=	$shop_info['shop_email'];	//보내는 사람 주소(@ 다음에는 반드시 도메인과 일치해야만 합니다.)
			$from_name	=	$shop_info['shop_name'];

			// 받는 사람
			$name       = $findRow->name;
			$email			= $findRow->email;		//받는사람 주소


		}else if($item=="3"){ //주문시

			$trade_idx = $data['trade_idx'];
			$trade_stat = $this->common_m->getRow("dh_trade","where idx='$trade_idx'");
			$trade_code = $trade_stat->trade_code;

			$to_content = str_replace("[user_name]", $trade_stat->name, $to_content);
			$to_content = str_replace("[trade_code]",$trade_code, $to_content);
			$to_content = str_replace("[trade_day]",$trade_stat->trade_day, $to_content);

			$goods_list = $this->common_m->getList("dh_trade_goods","where trade_code='$trade_code'");

			$trade_goods_list="";

			foreach($goods_list as $lt){

				$trade_goods_list .= '<tr>';
				$trade_goods_list .= '<td style="font-size:12px; padding:15px; border-color:#dddddd; border-width:1px; border-style:solid;">';
				$trade_goods_list .= '<p style="text-align:left; padding:0; margin:0;">';
				$trade_goods_list .= '<strong>'.$lt->goods_name.'</strong><br>';
				if($lt->option_cnt > 0){
					$option_list = $this->common_m->getList("dh_trade_goods_option","where trade_code='$trade_code' and level=2 and trade_goods_idx='".$lt->idx."'");
					foreach($option_list as $ot){

						$price = explode("-",$ot->price);
						$plus="";
						if(count($price)<2){ $plus="+"; }
						$price = $ot->price;

						$trade_goods_list .= '['.$ot->title.' : '.$ot->name;
						if($ot->flag!=1){
							if($price != 0){
								$trade_goods_list .= '('.$plus.number_format($price).')';
							}
							$trade_goods_list .= ' x '.$ot->cnt.' = '.number_format( ($lt->goods_price+$price)*$ot->cnt ).'원';
						}
						$trade_goods_list .= ']<br>';
					}
				}
				$trade_goods_list .= '</p>';
				$trade_goods_list .= '</td>';
				if($lt->goods_cnt == 0){ $lt->goods_cnt = ""; }
				$trade_goods_list .= '<td style="font-size:12px; text-align:center; border-color:#dddddd; border-width:1px; border-style:solid;">'.$lt->goods_cnt.'</td>';
				$trade_goods_list .= '<td style="font-size:12px; text-align:center; border-color:#dddddd; border-width:1px; border-style:solid;">'.number_format($lt->goods_price).'원</td>';
				$trade_goods_list .= '<td style="font-size:12px; text-align:center; border-color:#dddddd; border-width:1px; border-style:solid;">'.number_format($lt->total_price).'원</td>';
				$trade_goods_list .= '</tr>';

			}


			$to_content = str_replace("[trade_goods_list]",$trade_goods_list, $to_content);
			$to_content = str_replace("[goods_price]",number_format($trade_stat->goods_price), $to_content);
			$to_content = str_replace("[delivery_price]",number_format($trade_stat->delivery_price), $to_content);
			if(!$trade_stat->use_point){ $trade_stat->use_point = "0"; }
			$to_content = str_replace("[use_point]",number_format($trade_stat->use_point), $to_content);
			$to_content = str_replace("[total_price]",number_format($trade_stat->total_price), $to_content);
			$to_content = str_replace("[price]",number_format($trade_stat->price), $to_content);

			$to_content = str_replace("[trade_method]",$shop_info['trade_method'.$trade_stat->trade_method], $to_content);

			if($trade_stat->trade_method==1 || $trade_stat->trade_method==3){
				$trade_method_txt = "결제상태";
				$trade_method_info = '<span style="color:#0000ff;">결제가 정상적으로 완료되었습니다.</span>';
				$trade_method_detail="";
			}else if($trade_stat->trade_method==2 || $trade_stat->trade_method==4){
				$trade_method_txt = "입금 계좌 안내";
				$trade_method_info = $trade_stat->enter_bank." : ".$trade_stat->enter_account." (예금주 : ".$trade_stat->enter_info.")";
				$trade_method_detail='<p style="font-size:12px; margin:0; padding:0; margin-top:10px; line-height:20px; color:#888888;">입금이 확인된 이후에 주문상품의 배송이 시작됩니다.<br>주문 후 7일안에 입금하지 않으면 주문 자동 취소됩니다.</p>';
			}else if($trade_stat->trade_method==5 || $trade_stat->trade_method==6){
				$trade_method_txt = "결제상태";
				$trade_method_info = '<span style="color:#0000ff;">결제가 정상적으로 완료되었습니다.</span>';
				$trade_method_detail="";
			}
			$to_content = str_replace("[trade_method_txt]",$trade_method_txt, $to_content);
			$to_content = str_replace("[trade_method_info]",$trade_method_info, $to_content);
			$to_content = str_replace("[trade_method_detail]",$trade_method_detail, $to_content);

			$to_content = str_replace("[goods_price]",number_format($trade_stat->goods_price), $to_content);

			$to_content = str_replace("[send_name]",$trade_stat->send_name, $to_content);
			$to_content = str_replace("[zip1]",$trade_stat->zip1, $to_content);
			$to_content = str_replace("[addr1]",$trade_stat->addr1, $to_content);
			$to_content = str_replace("[addr2]",$trade_stat->addr2, $to_content);
			$to_content = str_replace("[send_phone]",$trade_stat->send_phone, $to_content);
			$to_content = str_replace("[send_text]",$trade_stat->send_text, $to_content);


			$title= str_replace("[shop_name]",$shop_info['shop_name'],$mailform_stat->title);

			// 보내는 사람
			$from_email	=	$shop_info['shop_email'];	//보내는 사람 주소(@ 다음에는 반드시 도메인과 일치해야만 합니다.)
			$from_name	=	$shop_info['shop_name'];

			// 받는 사람
			$name       = $trade_stat->name;
			$email			= $trade_stat->email;		//받는사람 주소


		}else if($item=="4"){ //상품배송시 (운송장번호 등록시)

			$trade_idx = $data['trade_idx'];
			$delivery_idx = $data['delivery_idx'];
			$delivery_no = $data['delivery_no'];
			$trade_stat = $this->common_m->getRow("dh_trade","where idx='{$trade_idx}'");
			$trade_code = $trade_stat->trade_code;
			$delivery_day = date("Y-m-d H:i:s");
			$delivery_name = $shop_info['delivery_idx'.$delivery_idx];

			$to_content = str_replace("[user_name]", $trade_stat->name, $to_content);
			$to_content = str_replace("[trade_code]",$trade_code, $to_content);
			$to_content = str_replace("[delivery_day]",$delivery_day, $to_content);
			$to_content = str_replace("[delivery_name]",$delivery_name, $to_content);
			$to_content = str_replace("[delivery_no]",$delivery_no, $to_content);


			$this->common_m->update2("dh_trade",array('delivery_day'=>$delivery_day),array('idx'=>$trade_idx));


			$title= str_replace("[shop_name]",$shop_info['shop_name'],$mailform_stat->title);

			// 보내는 사람
			$from_email	=	$shop_info['shop_email'];	//보내는 사람 주소(@ 다음에는 반드시 도메인과 일치해야만 합니다.)
			$from_name	=	$shop_info['shop_name'];

			// 받는 사람
			$name       = $trade_stat->name;
			$email			= $trade_stat->email;		//받는사람 주소

		}else if($item=="5"){ //온라인폼

			$data_text = '<tr><th height="52" width="200" style="font-size:12px; text-align:center; background-color:#f9f9f9; border-color:#dddddd; border-width:1px; border-style:solid; font-weight:bold;">기업명</th>';
			$data_text .= '<td height="52" style="font-size:12px; text-align:center; border-color:#dddddd; border-width:1px; border-style:solid;">'.$data['data1'].'</td>';
			$data_text .= '<tr><th height="52" width="200" style="font-size:12px; text-align:center; background-color:#f9f9f9; border-color:#dddddd; border-width:1px; border-style:solid; font-weight:bold;">담당자명</th>';
			$data_text .= '<td height="52" style="font-size:12px; text-align:center; border-color:#dddddd; border-width:1px; border-style:solid;">'.$data['name'].'</td>';
			$data_text .= '<tr><th height="52" width="200" style="font-size:12px; text-align:center; background-color:#f9f9f9; border-color:#dddddd; border-width:1px; border-style:solid; font-weight:bold;">연락처</th>';
			$data_text .= '<td height="52" style="font-size:12px; text-align:center; border-color:#dddddd; border-width:1px; border-style:solid;">'.$data['data2'].'</td>';
			$data_text .= '<tr><th height="52" width="200" style="font-size:12px; text-align:center; background-color:#f9f9f9; border-color:#dddddd; border-width:1px; border-style:solid; font-weight:bold;">이메일</th>';
			$data_text .= '<td height="52" style="font-size:12px; text-align:center; border-color:#dddddd; border-width:1px; border-style:solid;">'.$data['email'].'</td>';
			$data_text .= '<tr><th height="52" width="200" style="font-size:12px; text-align:center; background-color:#f9f9f9; border-color:#dddddd; border-width:1px; border-style:solid; font-weight:bold;">제목</th>';
			$data_text .= '<td height="52" style="font-size:12px; text-align:center; border-color:#dddddd; border-width:1px; border-style:solid;">'.$data['subject'].'</td>';
			$data_text .= '<tr><th height="52" width="200" style="font-size:12px; text-align:center; background-color:#f9f9f9; border-color:#dddddd; border-width:1px; border-style:solid; font-weight:bold;">내용</th>';
			$data_text .= '<td height="52" style="font-size:12px; text-align:center; border-color:#dddddd; border-width:1px; border-style:solid;">'.nl2br($data['content']).'</td></tr>';

			if(@$data['bbs_file']!=""){
				$data_text .= '<tr><th height="52" width="200" style="font-size:12px; text-align:center; background-color:#f9f9f9; border-color:#dddddd; border-width:1px; border-style:solid; font-weight:bold;">첨부파일</th>';
				$data_text .= '<td height="52" style="font-size:12px; text-align:center; border-color:#dddddd; border-width:1px; border-style:solid;">관리자 사이트에서 다운 가능합니다.</td>';
			}

			$to_content = str_replace("[name]", $data['name'], $to_content);
			$to_content = str_replace("[data_text]", $data_text, $to_content);


			$title= str_replace("[shop_name]",$shop_info['shop_name'],$mailform_stat->title);


			//문의한사용자
			$from_email	=	$data['email'];	//보내는 사람 주소(@ 다음에는 반드시 도메인과 일치해야만 합니다.)
			$from_name	=	$data['name'];

			//관리자
			$email			= $shop_info['shop_email'];		//받는사람 주소
			$name       = $shop_info['shop_name'];

		}

		if($email){

			/*
			$subject    = "=?utf-8?B?".base64_encode($title)."?=\n";
			$mailTo = "=?UTF-8?B?".base64_encode($name)."?="."<" . $email . ">\n";
			$mailFrom = "=?UTF-8?B?".base64_encode($from_name)."?="."<" . $from_email . ">\n";
			$result = $this->sendEmail($mailTo, $mailFrom, $subject, $to_content);
			*/
			$result = $this->sendEmail($name,$email,$from_name,$from_email,$title,$to_content);

		}else{ $result = 1; }


		if($item=="2" && $result){

			$result = $this->common_m->update2("dh_member",array('passwd'=>$this->member_m->sql_password($passwd)),array('idx'=>$findRow->idx));
		}

		return $result;
	}

	public function sendEmail_cifunc($mtname,$mtmail,$mfname,$mfmail,$subject,$message){
		$result = "";

		$this->load->library('email');

		$config['charset'] = 'utf-8';
		$config['wordwrap'] = TRUE;
		$config['mailtype'] = 'html'; // text or html
		$config['newline'] = '\r\n';
		$config['crlf'] = '\r\n';
		$this->email->initialize($config);

		$this->email->from($mfmail,$mfname);
		$this->email->to($mtmail,$mtname);

		$this->email->subject($subject);
		$this->email->message($message);

		if($this->email->send()){
			$result = 1;
		}else{
			$result = 1;
		}

		return $result;
	}

	/*
	public function sendEmail($mailTo, $mailFrom, $subject, $message) {

		$mailHeader = "from:{$mailFrom} \n";
		$mailHeader .= "Return-Path:{$mailFrom} \n";
		$mailHeader .= "Reply-To:{$mailFrom} \n";
		$mailHeader .= "MIME-Version:1.0 \n";
		$mailHeader .= "Content-Type: text/html;\n \tcharset=utf-8\n";

		$flag = mail($mailTo, $subject, $message, $mailHeader);
		return $flag;
	 }
	*/

	public function sendEmail($toname,$tomail,$fromname,$frommail, $subject, $message) {

		$from_name = "=?UTF-8?B?".base64_encode($fromname)."?=";
		$to_name = "=?UTF-8?B?".base64_encode($toname)."?=";
		$title = "=?UTF-8?B?".base64_encode($subject)."?=";

		$mailHeader = "Content-Type: text/html; charset=utf-8\r\n";
		$mailHeader .= "MIME-Version: 1.0\r\n";

		$mailHeader .= "Return-Path:".$frommail."\r\n";
		$mailHeader .= "from:".$from_name."<".$frommail.">\r\n";
		$mailHeader .= "Reply-To:".$frommail."\r\n";

		$flag = mail($tomail, $title, $message, $mailHeader);
		return $flag;

	}


		public function cart_init()
		{
			$CART=md5(uniqid(rand()));
			$this->session->set_userdata(array('CART'=>$CART));

			return $CART;
		}


		function get_random_string($type = '', $len = 10) {  //문자 랜덤 제조

				$lowercase = 'abcdefghijklmnopqrstuvwxyz';

				$uppercase = 'ABCDEFGHIJKLMNOPQRSTUVWXYZ';

				$numeric = '0123456789';

				$special = '`~!@#$%^&*()-_=+|[{]};:,<.>/?';

				$key = '';

				$token = '';

				if ($type == '') {

						$key = $lowercase.$uppercase.$numeric;

				} else {

						if (strpos($type,'09') > -1) $key .= $numeric;

						if (strpos($type,'az') > -1) $key .= $lowercase;

						if (strpos($type,'AZ') > -1) $key .= $uppercase;

						if (strpos($type,'$') > -1) $key .= $special;

				}

				for ($i = 0; $i < $len; $i++) {

						$token .= $key[mt_rand(0, strlen($key) - 1)];

				}

				return $token;

		}

		public function self_q($sql,$type){
			$q = $this->db->query($sql);
			switch($type){
				case "row": $result = $q->row(); break;
				case "result": $result = $q->result(); break;
				case "fetch_array": $result = $q->result_array(); break;
				case "cnt": $result = $q->num_rows(); break;
				case "delete":
				case "update":
					$result = "1";
				break;
			}
			return $result;
		}


		public function getPageView($page_index)
		{
			$this->db->select("content");
			$this->db->from("dh_page");
			$this->db->where("page_index = '".$page_index."'");

			return $this->db->get()->row()->content;
		}

		public function nospam()
		{
			$data='';
			$end=99999;
			$num=rand(10000,$end);
			$dir = "/_data/image/spam/";

			$num1 = substr($num,0,1);
			$num2 = substr($num,1,1);
			$num3 = substr($num,2,1);
			$num4 = substr($num,3,1);
			$num5 = substr($num,4,1);

			$img1Name = spam_img($num1);
			$img2Name = spam_img($num2);
			$img3Name = spam_img($num3);
			$img4Name = spam_img($num4);
			$img5Name = spam_img($num5);

			$cnum = $num1.$num2.$num3.$num4.$num5;

			$imgData='';

			for($i=1;$i<=strlen($cnum);$i++){

				$imgData.='<img src="'.$dir.${'img'.$i.'Name'}.'.png" alt="">';

			}

			$this->session->unset_userdata(array('cnum' => ''));
			$this->session->set_userdata(array("cnum" => $cnum));

			$data['cnum'] = $cnum;
			$data['imgData'] = $imgData;


			return $data;

		}


		public function smsform($item, $data='')
		{
			$shop_info = $this->shop_info();
			$result = 1;

			if($shop_info['sms']==1){ //sms사용하면
				$result='';

				if($shop_info['sms'.$item]==1){

					$to_content = $shop_info['sms_text'.$item];
					$to_content = str_replace("{shop_name}", "MYEL LOVE", $to_content);

					if($item==1){//회원가입
						$mem_stat = $this->getRow("dh_member","where userid='".$data['userid']."'");
						$to_content = str_replace("{name}", $mem_stat->name, $to_content);

						$data['sendTel'] = $mem_stat->tel1.$mem_stat->tel2.$mem_stat->tel3;

					}else if($item==2){//상품주문
						$trade_stat = $this->getRow("dh_trade","where trade_code='".$data['trade_code']."'");
						$to_content = str_replace("{주문번호}", $trade_stat->trade_code, $to_content);

						$data['sendTel'] = str_replace("-","",$trade_stat->phone);
					}else if($item==3){ //1:1 글 등록시
						$to_content = str_replace("{user_name}", $data['name'], $to_content);
						$data['sendTel'] = str_replace("-","",$shop_info['shop_tel2']);
					}else if($item==4){ //주문제작
						$data['sendTel'] = str_replace("-","",$shop_info['shop_tel2']);
					}else if($item==5){ //무통장입금
						$trade_stat = $this->getRow("dh_trade","where trade_code='".$data['trade_code']."'");
						$data['sendTel'] = str_replace("-","",$trade_stat->phone);
					}

					$sendTel = $data['sendTel'];
					$retTel = "0260134111";

					if($sendTel && $retTel){


						if($shop_info['sms_company']=="pongdang"){

							 $url = "http://www.pongdang.net/client/sendsms.aspx";
							 $postData = 'returnURL=http://'.$shop_info['shop_domain'].cdir().'/dh/smslog&FaildURL=http://'.$shop_info['shop_domain'].cdir().'/dh/smslog&P_ID=myellove&P_CODE=00d27cd4680a6b2cb4a22b56f5ccbbf1&P_SENDTEL='.$sendTel.'&P_RETURNTEL='.$retTel.'&P_MSG='.$to_content.'&P_TYPE=N&P_TIME=';
							 $postData = rtrim($postData, '&');


								$ch = curl_init();

								curl_setopt($ch,CURLOPT_URL,$url);
								curl_setopt($ch,CURLOPT_RETURNTRANSFER,true);
								curl_setopt($ch,CURLOPT_HEADER, false);
								curl_setopt($ch, CURLOPT_POST, count($postData));
								curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

								$output=curl_exec($ch);

								curl_close($ch);

								$result = 1;
						}

					}

				}else{
					$result = 1;
				}
			}

			return $result;
		}


		function getPageList2($table, $type='',$offset='',$limit='', $where_query='', $order_query='idx desc', $field='*')
		{

			$data="";

			$limit_query = '';

			if($limit != '' or $offset != ''){ $limit_query = 'limit '.$offset.', '.$limit;	}

			$sql = "select $field from ".$table." $where_query order by $order_query ".$limit_query;
			$query = $this->db->query($sql);

			if($type == 'count'){
				$result = $query->num_rows();
			}else{
				$result['list'] = $query->result();

				$i=0;
				$goods_arr="";
				foreach($result['list'] as $lt){
					$goods_arr[$i]['cnt'] = $this->common_m->getCount("dh_trade_goods","where trade_code='".$lt->trade_code."'");
					$goods_arr[$i]['goods_name']="";
					$goods_list = $this->common_m->getList2("dh_trade_goods","where trade_code='".$lt->trade_code."' order by idx");
					$cnt=0;
					foreach($goods_list as $goods){
						$cnt++;
						if($cnt!=1){
							$goods_arr[$i]['goods_name'].="<br>";
						}
						$goods_arr[$i]['goods_name'].=$goods->goods_name;
					}
					$i++;
				}

				$result['goods_arr'] = $goods_arr;
			}

			return $result;
		}


		public function defaultChk($Qs='') //pc or 모바일 체크
		{
			if ( (!!(FALSE !== strstr(strtolower($_SERVER['HTTP_USER_AGENT']), 'mobile')) != 1) || $this->session->userdata('MCHK') == "Y") { //관리자에서 모바일 체크 or 'MCHK' 세션이 있는지 여부 조사(모바일에서 pc버전 이동)


			}else{
				$url = $_SERVER['REQUEST_URI'].( $Qs ? "?".$Qs : "" );
				alert('/m'.$url);
				exit;

			}

		}

		public function icode_sms($type,$data){

			$shop_info = $this->shop_info();
			$result = 1;

			switch($type){
				case "sms1":
					$db = $this->self_q("select * from dh_trade where trade_code = '".$data['trade_code']."'","row");
					$to_content = $shop_info['sms_text1'];
					$phone = $db->send_phone.";";
				break;
				case "sms2":
					$db = $this->self_q("select * from dh_trade_deliv_info where deliv_code = '".$data['deliv_code']."'","row");
					$to_content = $shop_info['sms_text2'];
					$phone = $db->recv_phone.";";
				break;
				case "sms3":
					$db = $this->self_q("select * from dh_trade where trade_code = '".$data['trade_code']."'","row");
					$to_content = $shop_info['sms_text3'];
					$phone = $db->send_phone.";";
				break;
				case "sms4":
					$db = $this->self_q("select * from dh_trade where trade_code = '".$data['trade_code']."'","row");
					$to_content = $shop_info['sms_text4'];
					$phone = $db->send_phone.";";
				break;
			}

			$to_content = str_replace("{이름}",$db->name,$to_content);
			$to_content = str_replace("{주문번호}",$db->trade_code,$to_content);
			$to_content = str_replace("{주문금액}",number_format($db->total_price),$to_content);
			$to_content = str_replace("{택배회사}","우체국택배",$to_content);
			$to_content = str_replace("{송장번호}",$db->invoice_no,$to_content);
			$to_content = str_replace("{회사명}","에코맘♥",$to_content);

			/*
			$trade_stat = $this->getRow("dh_trade","where trade_code='".$trade_code."'");
			$trade_stat_goods = $this->getRow("dh_trade_goods","where trade_code='".$trade_code."'");

			$to_content = "{name}님이 {goods_name}을 {trade_method}로 주문하였습니다";
			$to_content = str_replace("{name}", $trade_stat->name, $to_content);
			$to_content = str_replace("{goods_name}", $trade_stat_goods->goods_name, $to_content);
			$to_content = str_replace("{trade_method}", $shop_info['trade_method'.$trade_stat->trade_method], $to_content);
			*/


			$socket_host	= "211.172.232.124";
			$socket_port	= 9201;
			/* 토큰키는 아이코드 사이트인 'http://www.icodekorea.com/'의
			 기업고객페이지의 모듈다운로드의 '토큰키 관리' 화면에서 생성가능합니다. */
			$icode_key	= $shop_info['icode_key'];

			$this->load->library('sms');

			$this->sms->SMS_con($socket_host,$socket_port,$icode_key);		/* 아이코드 서버 접속 */

			/**
			 * 문자발송 Form을 사용하지 않고 자동 발송의 경우 수신번호가 1개일 경우 번호 마지막에 ";"를 붙인다
			 * ex) $strTelList = "0100000001;";
			*/
			$strTelList     = $phone;		/* 수신번호 : 01000000001;0100000002; */
			$strCallBack    = $shop_info['callbackno'];	/* 발신번호 : 0317281281 */
			$strSubject     = "";		/* LMS제목  : LMS발송에 이용되는 제목( component.php 60라인을 참고 바랍니다. */
			$strData        = $to_content;        /* 메세지 : 발송하실 문자 메세지 */

			$chkSendFlag    = 0;	/* 예약 구분자 : 0 즉시전송, 1 예약발송 */
			$R_YEAR         = "";         /* 예약 : 년(4자리) 2016 */
			$R_MONTH        = "";        /* 예약 : 월(2자리) 01 */
			$R_DAY          = "";          /* 예약 : 일(2자리) 31 */
			$R_HOUR         = "";         /* 예약 : 시(2자리) 02 */
			$R_MIN          = "";          /* 예약 : 분(2자리) 59 */

			$strURL = "";
			$strCaller = "";

			$strDest	= explode(";",$strTelList);
			$nCount		= count($strDest)-1;		// 문자 수신번호 갯수

			// 예약설정을 합니다.
			if ($chkSendFlag) $strDate = $R_YEAR.$R_MONTH.$R_DAY.$R_HOUR.$R_MIN;
			else $strDate = "";

			// 문자 발송에 필요한 항목을 배열에 추가
			$result = $this->sms->Add($strDest, $strCallBack, $strCaller, $strSubject, $strURL, $strData, $strDate, $nCount);

			// 패킷 정의의 결과에 따라 발송여부를 결정합니다.
			if ($result) {
			//	echo "일반메시지 입력 성공<BR>";
			//	echo "<HR>";

				// 패킷이 정상적이라면 발송에 시도합니다.
				$result = $this->sms->Send();

				if ($result) {
					//echo "서버에 접속했습니다.<br>";
					$success = $fail = 0;
							$isStop = 0;
					foreach($this->sms->Result as $result) {

						list($phone,$code)=explode(":",$result);

						if (substr($code,0,5)=="Error") {
							//echo $phone.' 발송에러('.substr($code,6,2).'): ';
							switch (substr($code,6,2)) {
								case '17':	 // "07: 발송대기 처리. 지연해소시 발송됨."
									//echo "일시적인 지연으로 인해 발송대기 처리되었습니다.<br>";
									break;
								case '23':	 // "23:데이터오류, 전송날짜오류, 발신번호미등록"
									//echo "데이터를 다시 확인해 주시기바랍니다.<br>";
									break;

								// 아래의 사유들은 발송진행이 중단됨.
								case '85':	 // "85:발송번호 미등록"
								//	echo "등록되지 않는 발송번호 입니다.<br>";
									break;
								case '87':	 // "87:인증실패"
									//echo "(정액제-계약확인)인증 받지 못하였습니다.<br>";
									break;
								case '88':	 // "88:연동모듈 발송불가"
									//echo "연동모듈 사용이 불가능합니다. 아이코드로 문의하세요.<br>";
									break;

								case '96':	 // "96:토큰 검사 실패"
									//echo "사용할 수 없는 토큰키입니다.<br>";
									break;
								case '97':	 // "97:잔여코인부족"
									//echo "잔여코인이 부족합니다.<br>";
									break;
								case '98':	 // "98:사용기간만료"
									//echo "사용기간이 만료되었습니다.<br>";
									break;
								case '99':	 // "99:인증실패"
									//echo "서비스 사용이 불가능합니다. 아이코드로 문의하세요.<br>";
									break;
								default:	 // "미 확인 오류"
									//echo "알 수 없는 오류로 전송이 실패하었습니다.<br>";
									break;
							}
							$fail++;
						} else {
							//echo $phone."로 전송했습니다. (msg seq : ".$code.")<br>";
							$success++;
						}
					}
					//echo '<br>'.$success."건을 전송했으며 ".$fail."건을 보내지 못했습니다.<br>";
					$this->sms->Init(); // 보관하고 있던 결과값을 지웁니다.
				}
				else{
					//echo "에러: SMS 서버와 통신이 불안정합니다.<br>";
				}
			}



			return $result;
		}



		public function icode_send() //주문시 전송이니 필요할땐 수정해야함
		{
			$socket_host	= "211.172.232.124";
			$socket_port	= 9201;
			/* 토큰키는 아이코드 사이트인 'http://www.icodekorea.com/'의
			 기업고객페이지의 모듈다운로드의 '토큰키 관리' 화면에서 생성가능합니다. */
			$icode_key	= "72c32e56eb9cce6175d2bcfdfd72c7d2";

			$this->load->library('sms');
			$this->sms->SMS_con($socket_host,$socket_port,$icode_key);		/* 아이코드 서버 접속 */

			$sql = "select max(wr_no) as wr_no from sms5_write";
			$row = $this->common_m->self_q($sql,"row");

			if($row->wr_no > 0){
				$wr_no = $row->wr_no +1;
			}else{
				$wr_no = 1;
			}

			/**
			 * 문자발송 Form을 사용하지 않고 자동 발송의 경우 수신번호가 1개일 경우 번호 마지막에 ";"를 붙인다
			 * ex) $strTelList = "0100000001;";
			*/

			$tl = str_replace("^^","",$this->input->post('strTelList'));
			list($phone_no,$name,$userid) = explode("@@",$tl);//발송할 번호 : 이름 : 아이디
			$find = array(" ","-","/",".");
			$phone_no = str_replace($find,"",$phone_no);
			$return_no = str_replace($find,"",$this->input->post('strCallBack'));
			$msg = $this->input->post('strData');	//문자 내용

			$strTelList     = "{$phone_no};";		/* 수신번호 : 01000000001;0100000002; */
			$strCallBack    = $return_no;	/* 발신번호 : 0317281281 */
			$strSubject     = $this->input->post('strSubject');		/* LMS제목  : LMS발송에 이용되는 제목( component.php 60라인을 참고 바랍니다. */
			$strData        = $msg;        /* 메세지 : 발송하실 문자 메세지 */

			$chkSendFlag    = 0;	/* 예약 구분자 : 0 즉시전송, 1 예약발송 */
			$R_YEAR         = "";         /* 예약 : 년(4자리) 2016 */
			$R_MONTH        = "";        /* 예약 : 월(2자리) 01 */
			$R_DAY          = "";          /* 예약 : 일(2자리) 31 */
			$R_HOUR         = "";         /* 예약 : 시(2자리) 02 */
			$R_MIN          = "";          /* 예약 : 분(2자리) 59 */

			$strURL = "";
			$strCaller = "";

			$strDest	= explode(";",$strTelList);
			$nCount		= count($strDest)-1;		// 문자 수신번호 갯수

			// 예약설정을 합니다.
			if ($chkSendFlag) $strDate = $R_YEAR.$R_MONTH.$R_DAY.$R_HOUR.$R_MIN;
			else $strDate = "";

			// 문자 발송에 필요한 항목을 배열에 추가
			$result = $this->sms->Add($strDest, $strCallBack, $strCaller, $strSubject, $strURL, $strData, $strDate, $nCount);

			// 패킷 정의의 결과에 따라 발송여부를 결정합니다.
			if ($result) {
			//	echo "일반메시지 입력 성공<BR>";
			//	echo "<HR>";

				// 패킷이 정상적이라면 발송에 시도합니다.
				$result = $this->sms->Send();

				if ($result) {
					//echo "서버에 접속했습니다.<br>";

					$result = $success = $fail = 0;

					foreach($this->sms->Result as $result) {

						list($phone,$code)=explode(":",$result);

						if (substr($code,0,5)=="Error") {
							echo $phone.' 발송에러('.substr($code,6,2).'): ';
							switch (substr($code,6,2)) {
								case '17':	 // "07: 발송대기 처리. 지연해소시 발송됨."
									$hs_memo = "일시적인 지연으로 인해 발송대기 처리되었습니다.<br>";
									break;
								case '23':	 // "23:데이터오류, 전송날짜오류, 발신번호미등록"
									$hs_memo = "데이터를 다시 확인해 주시기바랍니다.<br>";
									break;

								// 아래의 사유들은 발송진행이 중단됨.
								case '85':	 // "85:발송번호 미등록"
									$hs_memo = "등록되지 않는 발송번호 입니다.<br>";
									break;
								case '87':	 // "87:인증실패"
									$hs_memo = "(정액제-계약확인)인증 받지 못하였습니다.<br>";
									break;
								case '88':	 // "88:연동모듈 발송불가"
									$hs_memo = "연동모듈 사용이 불가능합니다. 아이코드로 문의하세요.<br>";
									break;

								case '96':	 // "96:토큰 검사 실패"
									$hs_memo = "사용할 수 없는 토큰키입니다.<br>";
									break;
								case '97':	 // "97:잔여코인부족"
									$hs_memo = "잔여코인이 부족합니다.<br>";
									break;
								case '98':	 // "98:사용기간만료"
									$hs_memo = "사용기간이 만료되었습니다.<br>";
									break;
								case '99':	 // "99:인증실패"
									$hs_memo = "서비스 사용이 불가능합니다. 아이코드로 문의하세요.<br>";
									break;
								default:	 // "미 확인 오류"
									$hs_memo = "알 수 없는 오류로 전송이 실패하었습니다.<br>";
									break;
							}
							$fail++;
							$hs_flag = 0;
						} else {
							$hs_code = $code;
							//echo $phone."로 전송했습니다. (msg seq : ".$code.")<br>";
							$hs_memo = $phone_no."로 전송했습니다.";
							$success++;
							$hs_flag = 1;
						}
					}

					//echo '<br>'.$success."건을 전송했으며 ".$fail."건을 보내지 못했습니다.<br>";
					$this->sms->Init(); // 보관하고 있던 결과값을 지웁니다.
				}
				else{
					//echo "에러: SMS 서버와 통신이 불안정합니다.<br>";
				}

				$table = "sms5_history";

				$insert_data['wr_no'] = $wr_no;
				$insert_data['wr_renum'] = '';
				$insert_data['mb_id'] = $userid;
				$insert_data['hs_name'] = $name;
				$insert_data['hs_hp'] = $phone_no;
				$insert_data['hs_datetime'] = timenow();
				$insert_data['hs_flag'] = $hs_flag;	// 전송 성공여부 추후 피드백 받아서 처리
				$insert_data['hs_code'] = $hs_code;
				$insert_data['hs_memo'] = $hs_memo;
				//$insert_data['hs_log'] = '문자 전송후 피드백받아서 처리';

				$this->common_m->insert2($table,$insert_data);
			}

			$table = "sms5_write";

			$ins_data['wr_no'] = $wr_no;
			$ins_data['wr_reply'] = $return_no;
			$ins_data['wr_message'] = $msg;
			$ins_data['wr_total'] = "1";
			$ins_data['wr_success'] = $success;
			$ins_data['wr_failure'] = $fail;
			$ins_data['wr_datetime'] = timenow();

			$result = $this->common_m->insert2($table,$ins_data);

			if($result){
				echo "<script> alert('발송 되었습니다');	self.close(); </script>";
			}
		}

		public function goods_info(){
			$sql = "select * from dh_goods";
			$q = $this->db->query($sql);
			$result = $q->result();

			foreach($result as $key=>$row){
				$return_arr[$row->idx] = $row;
			}

			return $return_arr;
		}

		public function insert_log($userid,$time,$type,$msg,$deliv_code,$writer){
			$db_table = "dh_trade_deliv_log";

			$insert_data['userid'] = $userid;
			$insert_data['type'] = $type;
			$insert_data['msg'] = $msg;
			$insert_data['deliv_code'] = $deliv_code;
			$insert_data['wdate'] = $time;
			$insert_data['writer'] = $writer;

			$result = $this->insert2($db_table,$insert_data);
			return $result;
		}

		public function not_deliv_arr(){
			$sql = "select * from dh_not_deliv where idx = '1'";
			$row = $this->self_q($sql,"row");
			$tmp = explode("^",$row->not_deliv);
			$res = array();
			foreach($tmp as $t){
				if($t){
					$res[] = $t;
				}
			}
			return $res;
		}

		public function write_log($userid, $type, $msg, $deliv_code, $wdate, $writer){

			//입력쿼리

			$data['userid'] = $userid;
			$data['type'] = $type;
			$data['msg'] = $msg;
			$data['deliv_code'] = $deliv_code;
			$data['wdate'] = $wdate;
			$data['writer'] = $writer;

			$result = $this->insert2("dh_trade_deliv_log",$data);

			return $result;

		}

		public function orange_kakao_send($tmp_no, $name, $phone, $add1, $add2){
			$tmp_number	= $tmp_no;	// 오렌지메세지 사이트에서 템플릿번호를 확인하시고 입력해주세요.
			$kakao_url = "";
			$kakao_sender	= "0558842625" ;	// 오렌지메세지 사이트에서 등록하신 발신번호를 넣어주세요. ( 하이픈까지 일치해야 합니다 )
			$kakao_name	= $name;	// 받으시는 분의 고객명
			$kakao_phone	= $phone;	// 받으시는 분 휴대폰번호

			$kakao_080	= "Y" ;	// 대체문자발송시 080 무료수신거부를 사용하시는 경우에는 Y
			$kakao_res	= "" ;	// 예약발송인 경우에는 Y
			$kakao_res_date	= "" ;	// 예약인 경우에만 필요, 예) 2017-12-24 07:08:09
			$TRAN_REPLACE_TYPE	= "L" ;  // 알림톡 실패시 대체문자 발송 ( 공백:미발송, S : SMS로 발송, L : LMS로 발송 )

			// 추가정보 1~10 에 대한 값이 필요하신 경우 값을 넣어주세요
			$kakao_add1     = $add1;
			$kakao_add2     = $add2;
			$kakao_add3     = "" ;
			$kakao_add4     = "" ;
			$kakao_add5     = "" ;
			$kakao_add6     = "" ;
			$kakao_add7     = "" ;
			$kakao_add8     = "" ;
			$kakao_add9     = "" ;
			$kakao_add10    = "" ;

			$headers = array(
							"Content-Type: application/json; charset=utf-8",
							"Authorization: Vs4oCf8sQhJTKab4JGgTbZjkzJvP8A2TlSkFESDCvEg="
			);

			$parameters = array(
							"tmp_number" => $tmp_number,
							"kakao_url" => $kakao_url,
							"kakao_sender" => $kakao_sender,
							"kakao_name" => $kakao_name,
							"kakao_phone" => $kakao_phone,
							"kakao_add1" => $kakao_add1,
							"kakao_add2" => $kakao_add2,
							"kakao_add3" => $kakao_add3,
							"kakao_add4" => $kakao_add4,
							"kakao_add5" => $kakao_add5,
							"kakao_add6" => $kakao_add6,
							"kakao_add7" => $kakao_add7,
							"kakao_add8" => $kakao_add8,
							"kakao_add9" => $kakao_add9,
							"kakao_add10" => $kakao_add10,

							"kakao_080" => $kakao_080,
							"kakao_res" => $kakao_res,
							"kakao_res_date" => $kakao_res_date,
							"TRAN_REPLACE_TYPE" => $TRAN_REPLACE_TYPE
			);

			//			$curl = curl_init();
			//
			//			curl_setopt($curl, CURLOPT_URL, "http://www.apiorange.com/api/send/notice.do");
			//			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			//			curl_setopt($curl, CURLOPT_POSTFIELDS, json_encode($parameters));
			//			curl_setopt($curl, CURLOPT_POST, true);
			//			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			//			curl_setopt($curl, CURLOPT_NOSIGNAL, true);
			//			curl_setopt($curl, CURLOPT_VERBOSE, false);
			//			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			//			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			//			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);
			//
			//			$response = curl_exec($curl);
			//			$err = curl_error($curl);
			//			if($err){
			//				return $err;
			//			}
			//			else{
			//				return $response;
			//			}
		}

		public function naver_pay(){


			$headers = array(
							"X-Naver-Client-Id:NXVgQOklaNcGW8_Cjm3B",
							"X-Naver-Client-Secret:ag_6AmbGBV"
			);

			$curl = curl_init();

			curl_setopt($curl, CURLOPT_URL, "https://apis.naver.com/naverpay-partner/naverpay/payments/v2.2/apply/payment");
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($curl, CURLOPT_POSTFIELDS, "paymentId=".$this->input->post('paymentId'));
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_NOSIGNAL, true);
			curl_setopt($curl, CURLOPT_VERBOSE, false);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

			$response = curl_exec($curl);
			$err = curl_error($curl);

			$result = json_decode($response);
			if($err){
				return $err;
			}
			else{
				return $result;
			}
		}

		public function naver_pay_ok($paymentId){


			$headers = array(
							"X-Naver-Client-Id:NXVgQOklaNcGW8_Cjm3B",
							"X-Naver-Client-Secret:ag_6AmbGBV"
			);

			$parameters_ok = array(
							"paymentId" => $paymentId,      //네이버페이 결제번호
							"requester" => "2" //요청자
			);

			$curl = curl_init();

			curl_setopt($curl, CURLOPT_URL, "https://apis.naver.com/naverpay-partner/naverpay/payments/v1/purchase-confirm");
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($parameters_ok));
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_NOSIGNAL, true);
			curl_setopt($curl, CURLOPT_VERBOSE, false);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

			$response = curl_exec($curl);
			$err = curl_error($curl);

			$result = json_decode($response);
			if($err){
				return $err;
			}
			else{
				return $result;
			}
		}

		public function naver_pay_point($paymentId){


			$headers = array(
							"X-Naver-Client-Id:NXVgQOklaNcGW8_Cjm3B",
							"X-Naver-Client-Secret:ag_6AmbGBV"
			);

			$parameters_ok = array(
							"paymentId" => $paymentId,      //네이버페이 결제번호
			);

			$curl = curl_init();

			curl_setopt($curl, CURLOPT_URL, "https://apis.naver.com/naverpay-partner/naverpay/payments/v1/naverpoint-save");
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($parameters_ok));
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_NOSIGNAL, true);
			curl_setopt($curl, CURLOPT_VERBOSE, false);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

			$response = curl_exec($curl);
			$err = curl_error($curl);

			$result = json_decode($response);
			if($err){
				return $err;
			}
			else{
				return $result;
			}
		}

		public function naver_pay_cancel($trade_code,$paymentId,$total_price,$cancel_msg=''){


			$headers = array(
							"X-Naver-Client-Id:NXVgQOklaNcGW8_Cjm3B",
							"X-Naver-Client-Secret:ag_6AmbGBV"
			);

			$parameters = array(
							"paymentId" => $paymentId,      //네이버페이 결제번호
							"cancelAmount" => $total_price,    //취소요청금액
							"cancelReason" => $cancel_msg, // 취소사유
							"cancelRequester" => 2, //취소요청자
							"taxScopeAmount" => $total_price,
							"taxExScopeAmount" => 0

			);

			$curl = curl_init();


			/*
			개발(dev-api-server): dev.apis.naver.com
			운영(api-server): apis.naver.com
			*/

			curl_setopt($curl, CURLOPT_URL, "https://apis.naver.com/naverpay-partner/naverpay/payments/v1/cancel");
			curl_setopt($curl, CURLOPT_HTTPHEADER, $headers);
			curl_setopt($curl, CURLOPT_POSTFIELDS, http_build_query($parameters));
			curl_setopt($curl, CURLOPT_POST, true);
			curl_setopt($curl, CURLOPT_RETURNTRANSFER, true);
			curl_setopt($curl, CURLOPT_NOSIGNAL, true);
			curl_setopt($curl, CURLOPT_VERBOSE, false);
			curl_setopt($curl, CURLOPT_FOLLOWLOCATION, true);
			curl_setopt($curl, CURLOPT_SSL_VERIFYHOST, false);
			curl_setopt($curl, CURLOPT_SSL_VERIFYPEER, false);

			$response = curl_exec($curl);
			$err = curl_error($curl);

			$result = json_decode($response);
			if($err){
				return $err;
			}
			else{
				return $result;
			}

		}
}