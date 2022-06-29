<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Order extends CI_Controller {

 	function __construct()
	{
		parent::__construct();
    $this->load->model('admin_m');
    $this->load->model('product_m');
    $this->load->model('order_m');
		$this->load->helper('form');
		if(!$this->input->get('file_down')){
			ob_start();
			@header("Content-Type: text/html; charset=utf-8");
		}
	}

	public function index() //첫 화면 로딩시 로그인 화면 출력.
	{
			$this->login();
  }

	public function _remap($method) //모든 페이지에 적용되는 기본 설정.
	{
		$dev_arr = $this->common_m->adm_devel_array(); // 헤더와 풋터가 적용되지 않을 메소드 가져오기
		$arr = in_array($method, $dev_arr);

		if(!$this->session->userdata('ADMIN_PASSWD') && !$this->session->userdata('ADMIN_USERID') and $method != "apibox_noti" ){
			alert(cdir()."/dhadm/","관리자의 아이디와 패스워드가 올바르지 않습니다.");
		}

		if($this->input->get('d')){ //디자인 페이지 보기 - 디자인 페이지 이름 뒤에 ?d=1 넣으면 메소드 접근 안하고 페이지 이름으로 디자인 확인 가능

			$p = $this->uri->segment(2);
			$url = $this->common_m->get_page($p,'admin');
			$this->load->view($url);

		}else{

			if(!$arr && $this->input->get("ajax")!=1 and $method != "apibox_noti" and $method != "coupon_upload"){ //해더 & 풋터가 적용되는 경우

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
		$flag = $this->input->get('flag');
		$this->{$cont}($flag,'1');
	}

	public function lists($excel='')
	{
		$data['mode'] = $mode = $this->uri->segment(4,'');

		if($mode == "view"){	//뷰
			$data['trade_idx'] = $trade_idx = $this->uri->segment(5);

			$data['trade_stat'] = $this->common_m->getRow2("dh_trade","where idx='".$this->db->escape_str($trade_idx)."' order by idx desc limit 1");

			$data['member_info'] = $this->common_m->self_q("select * from dh_member where userid = '".$data['trade_stat']->userid."'","row");

			if($data['trade_stat']->userid && $data['trade_stat']->coupon_idx){
				$data['coupon_stat'] = $this->common_m->getRow2("dh_coupon_use","where idx='".$this->db->escape_str($data['trade_stat']->coupon_idx)."'");
			}

			$trade_code = $data['trade_stat']->trade_code;

			$result = $this->order_m->getTradeOption($trade_code);
			$data['goods_list'] = $result['goods_list'];
			foreach($data['goods_list'] as $lt){
				$data['option_arr'.$lt->idx] = $result['option_arr'.$lt->idx];
			}

			//$recom_deliv_sql = "select *, (select sum(prod_cnt) from dh_trade_deliv_prod where deliv_code = dh_trade_deliv_info.deliv_code) as total_prod_cnt from dh_trade_deliv_info where trade_code = '".$data['trade_stat']->trade_code."' and recom_idx > 0 order by deliv_code asc";
			$recom_deliv_sql = "select *,(select count(idx) from dh_trade_deliv_log where deliv_code = dh_trade_deliv_info.deliv_code) as log_count from dh_trade_deliv_info where trade_code = '".$data['trade_stat']->trade_code."' and recom_idx > 0 order by deliv_code asc";

			if($_SERVER['REMOTE_ADDR'] == "112.221.155.109"){
				//echo "[디자인허브만 보이도록 IP 제한]<br>";
				//echo $recom_deliv_sql;
			}

			$data['recom_deliv'] = $this->common_m->self_q($recom_deliv_sql,"result");
			$data['deliv_stat_arr'] = array('0'=>'배송대기','1'=>'배송준비중','2'=>'배송중','3'=>'배송완료','4'=>'배송중지','5'=>'배송취소','6'=>'휴일정지','7'=>'조기마감');

			$data['deliv_log'] = $this->common_m->self_q("select * from dh_trade_deliv_log where deliv_code like '%".$data['trade_stat']->trade_code."%' order by idx desc","result");

			$this->load->view('/dhadm/order/view',$data);
		}
		else if($mode == "payment"){	//주문결제내역

			if($_POST){
				$logwrite['uid'] = $this->input->post('uid');
				$logwrite['tidx'] = $this->input->post('tidx');
				$logwrite['op'] = $this->input->post('oprice');
				$logwrite['up'] = $this->input->post('price');
				$logwrite['wdate'] = timenow();

				$result = $this->common_m->insert2("dh_price_update_log",$logwrite);

				if($result){
					$updat['price'] = $this->input->post('price');
					$where['idx'] = $this->input->post('tidx');

					$result = $this->common_m->update2("dh_trade",$updat,$where);
					if($result){
						alert($_SERVER['HTTP_REFERER'],"주문총액이 수정되었습니다.");
					}
				}
				else{
					alert($_SERVER['HTTP_REFERER'],"로그 기록에 실패 하여 되돌아갑니다.");
				}
			}

			$data['trade_idx'] = $trade_idx = $this->uri->segment(5);
			$data['trade_stat'] = $this->common_m->getRow2("dh_trade","where idx='".$this->db->escape_str($trade_idx)."'");
			$data['member_info'] = $this->common_m->self_q("select * from dh_member where userid = '".$data['trade_stat']->userid."'","row");

			$data['price_log'] = $this->common_m->self_q("select * from dh_price_update_log where tidx = '{$trade_idx}'","result");

			$this->load->view("/dhadm/tab_page/".$mode."_list",$data);

		}
		else if($mode == "memo"){	//메모
			$data['trade_idx'] = $trade_idx = $this->uri->segment(5);
			$data['trade_stat'] = $this->common_m->getRow2("dh_trade","where idx='".$this->db->escape_str($trade_idx)."'");
			$data['member_info'] = $this->common_m->self_q("select * from dh_member where userid = '".$data['trade_stat']->userid."'","row");

			if($this->input->get('memo_idx')){
				$idx = $this->input->get('memo_idx');
				$result = $this->common_m->self_q("delete from dh_member_memo where idx = '{$idx}'","delete");
				if($result){
					alert($_SERVER['HTTP_REFERER']);
				}
			}

			if($_POST){

				//메모 기록
				//필요항목
				//관리자아이디, 관리자 이름, 작성일자, 고객아이디, 고객이름(?), 메모내용,

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
			$data['memo_list'] = $this->common_m->self_q("select * from dh_member_memo where userid = '".$data['trade_stat']->userid."'","result");

			$this->load->view("/dhadm/tab_page/".$mode."_list",$data);
		}
		else if($mode == "send_receive"){	//주문 받는사람
			$data['trade_idx'] = $trade_idx = $this->uri->segment(5);

			if($_POST){
				$db_table = "dh_trade";

				$where['idx'] = $this->input->post("idx");

				$update['name'] = $this->input->post("name");
				$update['phone'] = $this->input->post("phone");
				$update['email'] = $this->input->post("email");
				$update['send_name'] = $this->input->post("send_name");
				$update['send_phone'] = $this->input->post("send_phone");
				$update['zip1'] = $this->input->post("zip1");
				$update['addr1'] = $this->input->post("addr1");
				$update['addr2'] = $this->input->post("addr2");
				$update['send_tel'] = $this->input->post("send_tel");

				$result = $this->common_m->update2($db_table,$update,$where);
				if($result){
					alert($_SERVER['HTTP_REFERER'],'수정 되었습니다.');
				}

			}

			$data['trade_stat'] = $this->common_m->getRow2("dh_trade","where idx='".$this->db->escape_str($trade_idx)."'");
			$data['member_info'] = $this->common_m->self_q("select * from dh_member where userid = '".$data['trade_stat']->userid."'","row");
			$this->load->view("/dhadm/tab_page/".$mode."_list",$data);
		}
		else if($mode == "recom_foods_pop"){	//식단정보 팝업 - 전체식단

			$idx = $this->input->get('idx');
			$dcodef = $this->input->get('dcodef');

			$trade_goods_info = $this->common_m->self_q("select * from dh_trade_goods where idx = '{$idx}'","row");
			//$recom_foods_list = unserialize($row->recom_foods);
			//$goods = $this->common_m->self_q("select * from dh_goods","result");
			//$goods_info = array();
			//foreach($goods as $gd){
				//$goods_info[$gd->idx]['name'] = $gd->name;
				//$goods_info[$gd->idx]['list_img'] = $gd->list_img;
			//}
			//pr($goods_info);
			//pr($recom_foods_list);

			//$data['goods_info'] = $goods_info;
			//$data['recom_foods_list'] = $recom_foods_list;

			$sql = "select d.deliv_date, g.list_img, g.name, d.prod_cnt
							from dh_trade_deliv_prod d left join dh_goods g
								on	d.goods_idx = g.idx
							where d.trade_code = '{$trade_goods_info->trade_code}'
								and deliv_code like '%{$dcodef}%'
							order by deliv_date asc, g.name asc";

			$data['recom_foods_list'] = $this->common_m->self_q($sql,"result");
			$this->load->view("/dhadm/order/recom_foods",$data);
		}
		else if($mode == "foods_list"){	//식단 리스트 - 배송일자별

			$code = $this->input->get('code');

			//$list = $this->common_m->self_q("select * from dh_trade_deliv_prod where deliv_code = '{$code}' and recom_is = 'Y'","result");
			//$recom_foods_list = unserialize($row->recom_foods);

			//$goods = $this->common_m->self_q("select * from dh_goods","result");
			//$goods_info = array();
			//foreach($goods as $gd){
			//	$goods_info[$gd->idx]['name'] = $gd->name;
			//	$goods_info[$gd->idx]['list_img'] = $gd->list_img;
			//}
			//pr($goods_info);
			//pr($recom_foods_list);

			//$data['goods_info'] = $goods_info;
			//$data['list'] = $list;

			$sql = "
				select d.deliv_date, g.list_img, g.name, d.prod_cnt
				from dh_trade_deliv_prod d left join dh_goods g on	d.goods_idx = g.idx
				where d.deliv_code = '{$code}'
					and d.recom_is = 'Y'
				order by deliv_date asc, g.name asc
			";

			$data['list'] = $this->common_m->self_q($sql,"result");
			$this->load->view("/dhadm/order/deliv_foods",$data);

		}
		else{	//리스트

			if($this->input->get('mode') == "restart_deliv"){	//배송 재시작 (관리자)
				$trade_code = $this->input->get('trade_code');
				$restart_date = $this->input->get('restart_date');
				$restart_count = $this->input->get('restart_count');

				$trade_info = $this->common_m->self_q("select * from dh_trade where trade_code = '{$trade_code}'","row");
				$member_info = $this->common_m->self_q("select * from dh_member where userid = '".$trade_info->userid."'","row");
				$trade_goods_info = $this->common_m->self_q("select * from dh_trade_goods where trade_code = '{$trade_code}' and cate_no = 'recom'","row");

				if($trade_goods_info->grade_change){
					$prod_name = $trade_goods_info->grade_change_recom_name;
					$recom_idx = $trade_goods_info->grade_change_recom_idx;
				}
				else{
					$prod_name = $trade_goods_info->goods_name;
					$recom_idx = $trade_goods_info->recom_idx;
				}

				$arr_week_type = explode(":",$trade_info->recom_week_type);
				$arr_week_day = explode(",",$arr_week_type[1]);
				$week_last_day = end($arr_week_day);
				$day_name_to_number = array('일'=>0,'월'=>1,'화'=>2,'수'=>3,'목'=>4,'금'=>5,'토'=>6);
				$arr_week = array('일', '월', '화', '수', '목', '금', '토');
				$deliv_last_day = $day_name_to_number[$week_last_day];

				//원래 추천식단에서 일자별 받을 팩수와 현재 남은 팩수와의 상호 비교가 필요함

				$recom_row = $this->common_m->self_q("select * from dh_recom_food where idx = '{$recom_idx}'","row");
				$food_info = unserialize($recom_row->food_info);
				$arr_recom_week_type = array('2:수,토'=>'1','2:화,금'=>'2','3:화,목,토'=>'3');

				$recv_day_pack_count = $food_info[$trade_info->recom_week_day_count]['delivery_week_type'][$arr_recom_week_type[$trade_info->recom_week_type]]['count'];

				$holis = $this->common_m->self_q("select * from dh_deliv_holi order by holiday asc","result");
				$arr_holi = array();
				foreach($holis as $hl){
					$arr_holi[$hl->holiday] = true;
				}

				$delivs = $this->common_m->self_q("select deliv_date from dh_trade_deliv_info where trade_code = '{$trade_code}'","result");
				$arr_delivs = array();
				foreach($delivs as $dlv){
					$arr_delivs[$dlv->deliv_date] = true;
				}

				$re_deliv_date = array();
				$remain_count = $trade_info->remain_deliv_count;

				$addnew = "";

				$i = (int)$remain_count;

				while(true){

					$search_date_time = strtotime($restart_date);
					$search_date = date('Y-m-d', $search_date_time);
					$week = date('w', $search_date_time);
					$w = $arr_week[$week];
					if (in_array($w, $arr_week_day)) {
						if (!$arr_delivs[$search_date]) {
							array_push($re_deliv_date, $search_date);
							$i --;
						}
					}
					$restart_date = date('Y-m-d', strtotime('+1 day', $search_date_time));
					if ($i == 0) break;
				}

				$cnt = 0;

				$total_prod_cnt = $trade_info->remain_pack_ea;
				$total_deliv_date_count = count($re_deliv_date);	//최종 배송일

				foreach($re_deliv_date as $rd){
					$cnt++;
					$info_insert['trade_code'] = $trade_code;
					$info_insert['deliv_code'] = $trade_code."_1-".strtotime($rd);
					$info_insert['prod_name'] = $prod_name;
					$info_insert['recom_idx'] = $recom_idx;
					$info_insert['tg_idx'] = $trade_goods_info->idx;
					$info_insert['userid'] = $trade_info->userid;
					$info_insert['order_name'] = $trade_info->name;
					$info_insert['order_phone'] = $trade_info->phone;
					$info_insert['recv_name'] = $trade_info->send_name;
					$info_insert['recv_phone'] = $trade_info->send_phone;
					$info_insert['deliv_date'] = $rd;
					$info_insert['deliv_addr'] = "home";
					$info_insert['zipcode'] = $member_info->zip1;
					$info_insert['addr1'] = $member_info->add1;
					$info_insert['addr2'] = $member_info->add2;
					$info_insert['wdate'] = timenow();
					$info_insert['deliv_stat'] = $arr_holi[$rd] ? "6" : "0" ;

					$result = $this->common_m->insert2("dh_trade_deliv_info",$info_insert);

					if($result){
						$rd_time = strtotime($rd);
						$mon = date("Y-m-d",strtotime('monday this week',$rd_time));
						$wed = date("Y-m-d",strtotime('wednesday this week',$rd_time));
						$thu = date("Y-m-d",strtotime('thursday this week',$rd_time));
						$fri = date("Y-m-d",strtotime('friday this week',$rd_time));
						$sat = date("Y-m-d",strtotime('saturday this week',$rd_time));
						$yesterday = date("Y-m-d",strtotime('yesterday',$rd_time));
						$today = $rd;

						$week_end_add[4] = $thu;
						$week_end_add[5] = $fri;
						$week_end_add[6] = $sat;

						$_week = date('w',$rd_time);	//배송일 요일숫자로 치환됨
						$deliv_pack_count = $recv_day_pack_count[$arr_week[$_week]];

						if($trade_info->recom_week_day_count >= 6 and $arr_week_type[0] == 2){

							if($_week < 4){
								$start_date = $mon;
								$end_date = $wed;
							}
							else{
								$start_date = $thu;
								$end_date = $sat;
							}

						}
						else{
							$start_date = $yesterday;
							$end_date = $today;
						}

						$sql = "select a.*, b.cate_no
										from dh_recom_food_table a
											left join dh_goods b on a.goods_idx = b.idx
										where a.recom_food_idx = '".$info_insert['recom_idx']."'
													and a.recom_date between '{$start_date}' and '{$end_date}'
										order by recom_date desc";

						$prod_insert['trade_code'] = $info_insert['trade_code'];
						$prod_insert['deliv_code'] = $info_insert['deliv_code'];
						$prod_insert['deliv_date'] = $info_insert['deliv_date'];
						$prod_insert['recom_idx'] = $info_insert['recom_idx'];
						$prod_insert['prod_cnt'] = '1';
						$prod_insert['recom_is'] = 'Y';
						$prod_insert['tg_idx'] = $trade_goods_info->idx;

						$_row = $this->common_m->self_q($sql,"fetch_array");

						$add_prod_cnt = 0;
						foreach($_row as $r){
							$prod_insert['goods_idx'] = $r['goods_idx'];
							$prod_insert['cate_no'] = $r['cate_no'];
							$prod_insert['wdate'] = timenow();

							if($deliv_pack_count > $add_prod_cnt){
								$total_prod_cnt--;
								$res = $this->common_m->insert2("dh_trade_deliv_prod",$prod_insert);
								if($res){
									$add_prod_cnt++;
								}
							}
						}

						if($trade_info->recom_week_day_count == 7 and $trade_info->recom_delivery_sun_type and date("w",strtotime($r['recom_date'])) > 4 ){	//주말분 추가
							//echo "주말이다<BR>";

							$start_date = $week_end_add[$trade_info->recom_delivery_sun_type];
							$end_date = $start_date;

							$sql = "
								select a.*, b.cate_no
								from dh_recom_food_table a
									left join dh_goods b on a.goods_idx = b.idx
								where a.recom_food_idx = '".$info_insert['recom_idx']."'
											and a.recom_date between '{$start_date}' and '{$end_date}'
								order by recom_date desc
							";

							$_row = $this->common_m->self_q($sql,"fetch_array");

							foreach($_row as $r){

								$prod_insert['goods_idx'] = $r['goods_idx'];
								$prod_insert['cate_no'] = $r['cate_no'];
								$prod_insert['wdate'] = timenow();

								$total_prod_cnt--;
								$res = $this->common_m->insert2("dh_trade_deliv_prod",$prod_insert);
								if($res){
									$add_prod_cnt++;
								}

							}

						}
					}

					//로그 기록
					if($cnt == 1){
						$log_text = date("Y-m-d")."(".numberToWeekname(date("Y-m-d")).") 배송 재시작 요청";
						$result = $this->common_m->insert_log($trade_info->userid,timenow(),'배송 재시작',$log_text,$info_insert['deliv_code'],'관리자('.$this->session->userdata("ADMIN_USERID").')');
					}
				}

				$pause_msg = "";
				if($total_prod_cnt > 0){
					$pause_msg = " 배송일변경등으로 인해 받을 갯수와 설정된 갯수가 틀림 [남은팩수 : ".$total_prod_cnt."]";
					$this->common_m->self_q("update dh_trade_deliv_log set msg = concat(msg,'".$pause_msg."') where deliv_code = '".$trade_code."_1-".strtotime($re_deliv_date[0])."'","update");
				}

				if($result){

					$deliv_list = $this->common_m->self_q("select * from dh_trade_deliv_info where trade_code = '{$trade_code}' order by deliv_code asc","result");
					$update_recom_dates = "";
					foreach($deliv_list as $dl){
						$update_recom_dates .= $dl->deliv_date."^";
					}

					$result = $this->common_m->self_q("update dh_trade set trade_stat = '3', restart_date = now(), remain_deliv_count = '0', recom_dates = '{$update_recom_dates}' where trade_code = '{$trade_code}'","update");
					$result = $this->common_m->self_q("update dh_trade_goods set recom_dates = '{$update_recom_dates}' where trade_code = '{$trade_code}' and cate_no = 'recom'","update");
					if($result){
						alert($_SERVER['HTTP_REFERER']);
					}

				}
			}

			$url = cdir()."/";
			$url .= ($this->uri->segment(1))?$this->uri->segment(1)."/":"";
			$url .= ($this->uri->segment(2))?$this->uri->segment(2)."/":"";
			$url .= ($this->uri->segment(3) and $this->uri->segment(3) != "m")?$this->uri->segment(3)."/":"";
			$url .= ($this->uri->segment(4) and $this->uri->segment(4) != "m")?$this->uri->segment(4)."/":"";
			$url .= "m";

			$change_idx = $this->input->get("change_idx");
			$change_stat = $this->input->get("change_stat");

			if($change_idx && $change_stat){
				$result = $this->order_m->change_stat($change_idx,$change_stat);
				exit;
			}

			if($_POST){
				$mode = $this->input->post('mode');
				if($mode == "change_stat"){
					$change_stat_value = $this->input->post('change_stat_value');
					$check = $this->input->post('check');

					foreach($check as $ck){
						$result = $this->order_m->change_stat($ck,$change_stat_value,'1');
					}
				}
				else if($mode == "order_del"){
					$check = $this->input->post('check');
					foreach($check as $ck){
						$this->common_m->self_q("delete from dh_cart where trade_code = '{$ck}'","delete");
						$this->common_m->self_q("delete from dh_trade where trade_code = '{$ck}'","delete");
						$this->common_m->self_q("delete from dh_trade_deliv_info where trade_code = '{$ck}'","delete");
						$this->common_m->self_q("delete from dh_trade_deliv_prod where trade_code = '{$ck}'","delete");
						$this->common_m->self_q("delete from dh_trade_goods where trade_code = '{$ck}'","delete");
						$this->common_m->self_q("delete from dh_trade_goods_option where trade_code = '{$ck}'","delete");
					}
				}
			}

			$data['param'] = "";
			if($this->input->get("PageNumber")){
				$data['param'] = "&PageNumber=".$this->input->get("PageNumber");
			}

			$data['query_string'] = "?";
			$table_join = "dh_trade";
			$where_query = "where 1";

			//검색 조건에 따른 프로세스 시작
				if($this->input->get('sch_sdate') && $this->input->get('sch_edate')){	//일자 검색 추후 변동 가능할지도.
					$data['query_string'] .= "&sch_sdate=".$this->input->get('sch_sdate');
					$data['query_string'] .= "&sch_edate=".$this->input->get('sch_edate');
					$data['query_string'] .= "&sch_date=".$this->input->get('sch_date');

					if($this->input->get('sch_date') == "delivery_day"){
						$where_query .= " and trade_code in (select trade_code from dh_trade_deliv_info where trade_code = dh_trade.trade_code and deliv_date between '".$this->input->get('sch_sdate')."' and '".$this->input->get('sch_edate')."')";
					}
					else{
						if($this->input->get('order_type') == "free"){
						}
						else{
							$where_query .= " and date_format(".$this->input->get('sch_date').",'%Y-%m-%d') between '".$this->input->get('sch_sdate')."' and '".$this->input->get('sch_edate')."'";
						}
					}
				}

				if($this->input->get('sch_item_val')){	//필드 검색
					$data['query_string'] .= "&sch_item_val=".$this->input->get('sch_item_val');
					$data['query_string'] .= "&sch_item=".$this->input->get('sch_item');

					if(strpos($this->input->get('sch_item'),"phone") !== false){
						$sch_item_db = "replace(".$this->input->get('sch_item').",'-','')";
						$sch_item_val_db = str_replace("-","",$this->input->get('sch_item_val'));
					}
					else{
						$sch_item_db = $this->input->get('sch_item');
						$sch_item_val_db = $this->input->get('sch_item_val');
					}


					$where_query .= " and {$sch_item_db} like '%{$sch_item_val_db}%'";
				}

				if($this->input->get('sch_trade_method')){	//결제방식 검색
					$data['query_string'] .= "&sch_trade_method=".$this->input->get('sch_trade_method');
					$where_query .= " and trade_method = '".$this->input->get('sch_trade_method')."'";
				}

				if($this->input->get('sch_trade_stat')){	//결제상태 검색
					$data['query_string'] .= "&sch_trade_stat=".$this->input->get('sch_trade_stat');
					$where_query .= " and trade_stat = '".$this->input->get('sch_trade_stat')."'";
				}

				if($this->input->get('sch_other')){		//기타 검색
					$data['query_string'] .= "&sch_other=".$this->input->get('sch_other');
					switch($this->input->get('sch_other')){
						case "first_order": $where_query .= " and first_order = 'Y'"; break;
						case "pc_order": $where_query .= " and mobile = 0"; break;
						case "mobile_order": $where_query .= " and mobile = 1"; break;
					}
				}

				/*
				<select name="order_type">										<select name="order_type21">--recom		<select name="order_type22">--free				<select name="order_type23">--discount		<select name="order_type24">--sample
					<option value="recom">정기배송</option>				<option value="1">준비기</option>			<option value="1">준비기</option>					<option value="1">초기 6팩</option>				<option value="1">초기</option>
					<option value="free">자유배송</option>				<option value="2">초기</option>				<option value="2">초기</option>						<option value="2">중기 12팩</option>			<option value="2">중기</option>
					<option value="gansik">산골간식</option>			<option value="3">중기</option>				<option value="3">중기 준비기</option>		<option value="3">후기 18팩</option>  		<option value="3">후기</option>
					<option value="health">건강식품</option>			<option value="4">후기2식</option>		<option value="4">중기</option>						<option value="4">완료기 18팩</option>		<option value="4">완료기</option>
					<option value="farm">오!산골농부</option>			<option value="5">후기3식</option>		<option value="5">후기</option>					</select>                               	</select>
					<option value="discount">특가상품</option>		<option value="6">완료기</option>			<option value="6">완료기</option>
					<option value="sample">샘플신청</option>			<option value="7">반찬/국</option>		<option value="7">반찬</option>
				</select>																			</select>																<option value="8">국</option>
																																														</select>
				*/

				//주문 타입별 검색
				$recom_arr = array('1'=>'2','2'=>'4','3'=>'5','4'=>'6','5'=>'1','6'=>'7','7'=>'3');	//추천식단 2차 카테고리 검색값 => DB 값 배열
				$free_arr = array('1'=>'1-6','2'=>'1-7','3'=>'1-8','4'=>'1-9','5'=>'1-10','6'=>'1-11','7'=>'2-12','8'=>'2-13');	//골라담기 2차 카테고리 검색값 => DB 값 배열
				$dis_sam_arr = array('1'=>'초기','2'=>'중기','3'=>'후기','4'=>'완료기');

				if($this->input->get('order_type')) $data['query_string'] .= "&order_type=".$this->input->get('order_type');	//주문선택 값이 있을경우 파라미터 추가

				if($this->input->get('order_type') == "recom"){	//정기배송
					if($this->input->get('order_type21')){	//2차 카테고리 값이 있을경우
						$data['query_string'] .= "&order_type21=".$this->input->get('order_type21');
						$where_query .= " and (select recom_idx from dh_trade_deliv_prod where trade_code = dh_trade.trade_code order by deliv_code asc limit 1) = '".$recom_arr[$this->input->get('order_type21')]."'";
					}
					else{
						$where_query .= " and recom_is = 'Y'";
					}
				}
				else if($this->input->get('order_type') == "free"){	//자유배송
					if($this->input->get('order_type22')){	//2차 카테고리 값이 있을경우
						$data['query_string'] .= "&order_type22=".$this->input->get('order_type22');
						$where_query .= " and recom_is is null and ('".$free_arr[$this->input->get('order_type22')]."') in (select cate_no from dh_trade_deliv_prod where trade_code = dh_trade.trade_code and deliv_date = '".$this->input->get('sch_sdate')."')";
					}
					else{
						$where_query .= " and recom_is is null and trade_code in (select distinct trade_code from dh_trade_deliv_prod where trade_code = dh_trade.trade_code and cate_no in ('1-6','1-7','1-8','1-9','1-10','1-11','2-12','2-13') and deliv_date between '".$this->input->get('sch_sdate')."' and '".$this->input->get('sch_edate')."')";
					}
				}
				else if($this->input->get('order_type') == "gansik"){	//간식
					$where_query .= " and (select cate_no from dh_trade_deliv_prod where trade_code = dh_trade.trade_code and recom_is != 'Y' order by deliv_code asc limit 1) = '3'";
				}
				else if($this->input->get('order_type') == "health"){	//건강식품
					$where_query .= " and (select cate_no from dh_trade_deliv_prod where trade_code = dh_trade.trade_code and recom_is != 'Y' order by deliv_code asc limit 1) = '4'";
				}
				else if($this->input->get('order_type') == "farm"){	//산골농부
					$where_query .= " and (select cate_no from dh_trade_deliv_prod where trade_code = dh_trade.trade_code and recom_is != 'Y' order by deliv_code asc limit 1) = '5'";
				}
				else if($this->input->get('order_type') == "discount"){	//특가상품
					if($this->input->get('order_type23')){
						$data['query_string'] .= "&order_type23=".$this->input->get('order_type23');
						$where_query .= " and (select goods_name from dh_trade_goods where trade_code = dh_trade.trade_code and cate_no = '6' limit 1) like '%".$dis_sam_arr[$this->input->get('order_type23')]."%'";
					}
					else{
						$where_query .= " and (select cate_no from dh_trade_deliv_prod where trade_code = dh_trade.trade_code and recom_is != 'Y' order by deliv_code asc limit 1) = '6'";
					}
				}
				else if($this->input->get('order_type') == "sample"){	//샘플
					if($this->input->get('order_type24')){
						$data['query_string'] .= "&order_type24=".$this->input->get('order_type24');
						$where_query .= " and (select goods_name from dh_trade_goods where trade_code = dh_trade.trade_code and cate_no = '7' limit 1) like '%".$dis_sam_arr[$this->input->get('order_type24')]."%'";
					}
					else{
						$where_query .= " and sample_is = 'Y'";
					}
				}


			//검색 조건에 따른 프로세스 종료

			/* 페이징 start */
			$PageNumber = $this->input->get("PageNumber"); //현재 페이지
			if(!$PageNumber){ $PageNumber = 1; }
			$list_num='40'; //페이지 목록개수
			$page_num='5'; //페이징 개수
			$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)

			$sql = "select *,(select idx from dh_member where userid = dh_trade.userid) as useridx from {$table_join} {$where_query}";
			//			if($_SERVER['HTTP_X_FORWARDED_FOR'] == "58.229.223.174"){
			//				echo "[[[[ip lock on]]]]<br>";
			//				echo $sql;
			//			}

			if($_GET){

				if($this->input->get('excel') == "ok"){
					//$sql .= " order by trade_day asc";
					$list = $this->common_m->self_q($sql,"result");
				}

				else{
					$data['totalCnt'] = $this->common_m->self_q("select * from {$table_join} {$where_query}","cnt");
					$data['Page2'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
					/* 페이징 end */

					//주문내역
					$sql .= " order by idx desc limit {$offset}, {$list_num}";
					//select * from dh_trade where 1 order by trade_day desc limit 0, 15

					$data['list'] = $this->common_m->self_q($sql,"result");
				}
			}

			$holis = $this->common_m->self_q("select * from dh_deliv_holi","result");
			$arr_holi = array();
			foreach($holis as $hl){
				$arr_holi[] = $hl->holiday;
			}

			$data['arr_holi'] = $arr_holi;

			if($this->input->get('excel') == "ok"){

				# URL를 파일명으로 지정.....
				$domain = str_replace( ".", "_", $_SERVER['HTTP_HOST'] );
				# 엑셀 생성되는 디비명
				$path = "order";

				Header("Content-type: application/vnd.ms-excel");
				Header("Content-Disposition: attachment; filename=" . $domain . "_" . $path . "_".date("Y-m-d").".xls");
				Header("Content-Description: PHP5 Generated Data");
				Header("Pragma: no-cache");
				Header("Expires: 0");
				header("Cache-Control: must-revalidate, post-check=0, pre-check=0");
				print("<meta http-equiv=\"Content-Type\" content=\"application/vnd.ms-excel; charset=utf-8\">");

				?>
				<style>
				.xTxt{mso-number-format:"\@";}
				td{font-size:11px;}
				.xTxtF{color:red;}
				</style>
				<table cellpadding=3 cellspacing=0 border=1 bordercolor='#BDBEBD' style='border-collapse: collapse'>
					<Tr align=center height=30 bgcolor="#EFEFEF">
						<td width=50>No</td>
						<td width=120>주문번호</td>
						<td width=100>주문일자</td>
						<td>주문상품</td>
						<td width=50>수량</td>
						<td width=110>상품금액</td>
						<td width=110>총결제금액</td>
						<td width=110>할인금액</td>
						<td width=110>실결제금액</td>
						<td width=100>결제방법</td>
						<td width=120>주문자 아이디</td>
						<td width=120>주문자 이름</td>
						<td width=150>주문자 이메일</td>
						<td width=120>주문자 핸드폰</td>
						<td width=120>배송 받는 이름</td>
						<td width=120>배송 휴대폰</td>
						<td width=120>배송 전화번호</td>
						<td width=300>배송주소</td>
						<td width=200>배송시 요청사항</td>
						<td width=100>운송장번호</td>
						<td width=100>거래상태</td>
					</tr>
					<?
					$cnt=0;
					foreach($list as $lt){
						$cnt++;
					?>
					<tr height=25 valign=middle bgcolor='#FFFFFF' align=center>
						<td class='xTxt'><?=$cnt?></td>
						<td><?=$lt->trade_code?></td>
						<td><?=substr($lt->trade_day,0,10)?></td>
						<td align=left class='xTxt' style="min-width:350px;"><?=$lt->goods_name?>
						<? if($lt->option_cnt > 0){
							for($i=0;$i<$lt->option_cnt;$i++){
							if(isset($option['option_arr'.$lt->g_idx][$i]['title'])){
							?>
							<br>- [<?=$option['option_arr'.$lt->g_idx][$i]['title']?> : <?=$option['option_arr'.$lt->g_idx][$i]['name']?> <? if($option['option_arr'.$lt->g_idx][$i]['flag']!=1){ echo " (".$option['option_arr'.$lt->g_idx][$i]['price']."원) * ".$option['option_arr'.$lt->g_idx][$i]['cnt']; }?>]
							<?
							}
							}
						}?>
						</td>
						<td><? if($lt->goods_cnt){ echo $lt->goods_cnt; }?></td>
						<td><?=number_format($lt->goods_total_price)?></td>
						<td><?=number_format($lt->price)?></td>
						<td><?=number_format($lt->use_point)?></td>
						<td><?=number_format($lt->total_price)?></td>
						<td><?=$shop_info['trade_method'.$lt->trade_method]?></td>
						<td><? echo $lt->userid ? $lt->userid : "비회원";?></td>
						<td><?=$lt->name?></td>
						<td><?=$lt->email?></td>
						<td><?=$lt->phone?></td>
						<td><?=$lt->send_name?></td>
						<td><?=$lt->send_phone?></td>
						<td><?=str_replace("--","",$lt->send_tel)?></td>
						<td>(<?=$lt->zip1?>) <?=$lt->addr1?> <?=$lt->addr2?></td>
						<td><?=$lt->send_text?></td>
						<td class='xTxt'><?=$lt->delivery_no?></td>
						<td><?=$shop_info['trade_stat'.$lt->trade_stat]?></td>
					</tr>
					<?
					}
					?>
				</table>

				<?php
			}
			else{
				$this->load->view('/dhadm/order/list',$data);
			}
		}
	}

	/*
	public function lists($excel='')
	{

		$url = cdir()."/".$this->uri->segment(1)."/".$this->uri->segment(2)."/".$this->uri->segment(3)."/m";
		$trade_stat = $this->uri->segment(3,1);
		$today = date("Y-m-d");

		$change_idx = $this->input->get("change_idx");
		$change_stat = $this->input->get("change_stat");


		if($change_idx && $change_stat){
			$result = $this->order_m->change_stat($change_idx,$change_stat);
			exit;
		}


		$data['start_date'] = $this->input->get("start_date");
		$data['end_date'] = $this->input->get("end_date");
		$data['trade_stat'] = $trade_stat; //trade_stat->all 이면 전체
		$data['cate_list'] = $this->product_m->cate_list(1); //카테고리 리스트

		$data['trade_method_cnt'] = $this->common_m->getCount("dh_shop_info","where name like 'trade_method%'","idx");
		$data['trade_stat_cnt'] = $this->common_m->getCount("dh_shop_info","where name like 'trade_stat%'","idx");

		$data['param'] = "";
		if($this->input->get("PageNumber")){
			$data['param'] = "&PageNumber=".$this->input->get("PageNumber");
		}


		// 페이징 start
		$PageNumber = $this->input->get("PageNumber"); //현재 페이지
		if(!$PageNumber){ $PageNumber = 1; }
		$list_num='15'; //페이지 목록개수
		$page_num='5'; //페이징 개수
		$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)

		$arr = $this->order_m->admTradeList('',$offset,$list_num,$excel);

		$totalArr = $this->order_m->admTradeList('count');
		$data['totalCnt'] = $totalArr['totalCnt'];
		$data['list'] = $arr['list'];

		$data['query_string'] = $arr['query_string'];

		$data['Page2'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
		// 페이징 end

		$formCnt = $this->input->post('formCnt');

		// 일괄 변경 start
		if($this->input->post('del_ok')==1 && $formCnt > 0){	 //선택삭제
			for($i=1;$i<=$formCnt;$i++){
					if($this->input->post("check".$i)){
						$result = $this->common_m->del("dh_trade","trade_code", $this->input->post("check".$i,true));
						$result = $this->common_m->del("dh_trade_goods","trade_code", $this->input->post("check".$i,true));
						$result = $this->common_m->del("dh_trade_goods_option","trade_code", $this->input->post("check".$i,true));
					}
				}
			result($result, "삭제", $url);
		}else if($this->input->post('del_ok')==2 && $formCnt > 0 && $this->input->post('change_stat')){	//선택 거래상태 변경
			for($i=1;$i<=$formCnt;$i++){
				if($this->input->post("check".$i)){
					$result = $this->order_m->change_stat($this->input->post("check".$i),$this->input->post('change_stat'),1);
				}
			}
			result($result,'','/html/order/lists/'.$this->input->post('change_stat').'/m');

		}else if($this->input->post('del_ok')==3){ //전체 운송장번호 저장
			for($i=1;$i<=$formCnt;$i++){
				$result = $this->order_m->delivery_ok($this->input->post("trade_idx".$i));
			}
			alert($_SERVER['PHP_SELF'].$data['query_string'].$data['param']);
		}
		// 일괄 변경 end

		$data['trade_stat_list'] = $this->common_m->getList2("dh_shop_info","WHERE name like 'trade_stat%' order by idx");

		$data['shop_info'] = $this->admin_m->shop_info(); //shop 정보
		$data['delivery_row'] = $this->common_m->getList("dh_shop_info","where name like 'delivery_idx%' and val!='' group by name");


		if($this->input->get("view") && $this->input->get("idx")){ //상세보기

			$trade_idx = $this->input->get("idx");

			if($this->input->post("edit")==1){
				$result = $this->db->update("dh_trade",array('send_name'=>$this->input->post("send_name",true),'zip1'=>$this->input->post("zip1",true),'addr1'=>$this->input->post("addr1",true),'addr2'=>$this->input->post("addr2",true),'send_phone'=>$this->input->post("send_phone",true),'send_tel'=>$this->input->post("send_tel",true),'send_text'=>$this->input->post("send_text",true),'memo'=>$this->input->post("memo",true)),array('idx'=>$trade_idx));
				result($result, "수정", cdir()."/order/lists/all/m/?view=1&idx=".$trade_idx);
				exit;
			}


			$data['trade_stat'] = $this->common_m->getRow2("dh_trade","where idx='".$this->db->escape_str($trade_idx)."' order by idx desc limit 1");
			if($data['trade_stat']->userid && $data['trade_stat']->coupon_idx){
				$data['coupon_stat'] = $this->common_m->getRow2("dh_coupon_use","where idx='".$this->db->escape_str($data['trade_stat']->coupon_idx)."'");
			}

			$trade_code = $data['trade_stat']->trade_code;

			$result = $this->order_m->getTradeOption($trade_code);
			$data['goods_list'] = $result['goods_list'];
			foreach($data['goods_list'] as $lt){
				$data['option_arr'.$lt->idx] = $result['option_arr'.$lt->idx];
			}

			$this->load->view('/dhadm/order/view',$data);
			exit;

		}else{
			if($excel=="1"){ //엑셀다운
				$data['option'] = $this->order_m->getTradeOptionList($data['list']);
				$this->load->view("/dhadm/excel/order",$data); //엑셀다운
			}else{
				$this->load->view('/dhadm/order/list',$data);
			}
		}
	}
	*/



	public function tmp($data='')
	{

		if($this->input->post("trade_code") && $this->input->post("change_trade_code")){

			$tradeCnt = $this->common_m->getcount("dh_trade","where trade_code='".$this->input->post("change_trade_code",true)."'");
			$trade_code = $this->input->post("trade_code",true);
			if($tradeCnt == 0){

				$result = $this->common_m->update2("dh_cart",array('trade_ok'=>0,'trade_day '=>'0000-00-00 00:00:00'),array('trade_code'=>$trade_code));
				$cartRow = $this->common_m->getRow("dh_cart","where trade_code='".$trade_code."'");

				$result = $this->order_m->getCart($cartRow->code);

				$data['cart_list'] = $result['list'];
				foreach($data['cart_list'] as $lt){
					$data['option_arr'.$lt->idx] = $result['option_arr'.$lt->idx];
				}

				$data['totalCnt'] = $this->common_m->getCount("dh_cart","where code='".$trade_code."'","idx");

				if($this->input->post("change_trade_code") == $this->input->post("trade_code")){

					$result = $this->order_m->trade($trade_code,$data,"1");

				}else{

					$result = $this->order_m->trade($trade_code,$data,"1",$this->input->post("change_trade_code",true));

				}

				result($result, "주문이 등록", cdir()."/order/tmp/m");

			}else{
				back('[복구실패 안내]\\n현재 등록되어있는 주문번호입니다.\\n주문관리에서 정보를 변경하시거나, 주문번호를 변경후 다시 복구하기를 눌러주세요.');
			}
			exit;

		}else{

			$tc = $this->input->get('trade_code');

			if($tc){
				$data['list'] = $this->order_m->getTmpList($tc);
				foreach($data['list'] as $lt){
					$data['cart_list'][$lt->idx] = $this->common_m->getList2("dh_cart","where trade_code='".$lt->trade_code."' order by idx");
				}
			}

			$this->load->view('/dhadm/order/tmp_list',$data);

		}
	}



	public function coupon($data='')
	{
		$mode = $this->uri->segment(4);
		$url = cdir()."/".$this->uri->segment(1)."/".$this->uri->segment(2)."/m";
		$data['query_string'] = "?";
		$where_query = " where 1 ";
		$order_query = "idx desc";
		$item = $this->input->get('item');
		$val = $this->input->get('val');
		$type = $this->input->get('type');
		$param="";

		if($this->input->get("PageNumber")){ $param .="?PageNumber=".$this->input->get("PageNumber"); }

		if($item && $val){ $data['query_string'].="&item=$item&val=$val"; $where_query .= " and $item like '%$val%'";	}
		if($type){ $data['query_string'].="&type={$type}"; $rtype = $type-1; $where_query .= " and type = '{$rtype}'";	}

		$data['param']=$param;
		$data['member_level'] = $this->common_m->getList("dh_member_level"); //회원 등급 data

		if($mode=="write"){

			if($this->input->get("ajax")==1){
				$code = date("ym").substr($this->common_m->get_random_string('AZ'),0,7).mt_rand(1, 10);
				$cnt = $this->common_m->getCount("dh_coupon","where code='$code'");
				if($cnt > 0){ 		//중복값이 있으면 다시 생성
					echo $cnt;
				}else{
					echo $code;
				}
				exit;
			}else if($this->input->post("code") && $this->input->post("name")){

				$result = $this->order_m->codeInput();
				result($result, "쿠폰이 등록", cdir()."/order/coupon/m");

			}

			$this->load->view("/dhadm/order/coupon_write",$data);

		}else if($mode=="edit"){

			$idx = $this->uri->segment(5);
			if(!$idx){
				back("잘못된 접근입니다."); exit;
			}else{
				$data['row'] = $this->common_m->getRow2("dh_coupon","where idx='".$this->db->escape_str($idx)."'");

				if($this->input->post("code") && $this->input->post("idx") && $this->input->post("name")){

					$result = $this->order_m->codeInput('edit');
					result($result, "쿠폰이 수정", cdir()."/order/coupon/m");

				}

				$this->load->view("/dhadm/order/coupon_write",$data);

			}


		}else if($this->input->post('del_idx') && $this->input->post('del_ok')==1){

			$result = $this->common_m->del("dh_coupon","idx", $this->input->post('del_idx')); //해당 유저 삭제
			result($result, "삭제", cdir()."/order/coupon/m");

		}else{


			// 페이징 start */
			$PageNumber = $this->input->get("PageNumber"); //현재 페이지
			if(!$PageNumber){ $PageNumber = 1; }
			$list_num='15'; //페이지 목록개수
			$page_num='5'; //페이징 개수
			$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
			$data['totalCnt'] = $this->common_m->getPageList('dh_coupon','count','','',$where_query,$order_query); //총개수
			$data['Page'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
			// 페이징 end */

			$data['list'] = $this->common_m->getPageList('dh_coupon','',$offset,$list_num,$where_query,$order_query); //리스트
			$this->load->view("/dhadm/order/coupon_list",$data);

		}
	}

	public function coupon_two($data='')
	{
		$mode = $this->uri->segment(4);
		$url = cdir()."/".$this->uri->segment(1)."/".$this->uri->segment(2)."/m";
		$data['query_string'] = "?";
		$where_query = " where 1 ";
		$order_query = "idx desc";
		$code = $this->input->get('code');
		$param="";

		if($this->input->get("PageNumber")){ $param .="?PageNumber=".$this->input->get("PageNumber"); }

		//if($item && $val){ $data['query_string'].="&item=$item&val=$val"; $where_query .= " and $item like '%$val%'";	}
		if($code){ $data['query_string'].="&code={$code}"; $where_query .= " and code = '{$code}'";	}

		$data['param']=$param;
		$data['member_level'] = $this->common_m->getList("dh_member_level"); //회원 등급 data

		if($mode=="write"){

			if($this->input->get("ajax")==1){
				$code = date("ym").substr($this->common_m->get_random_string('AZ'),0,7).mt_rand(1, 10);
				$cnt = $this->common_m->getCount("dh_coupon_two","where code='$code'");
				if($cnt > 0){ 		//중복값이 있으면 다시 생성
					echo $cnt;
				}else{
					echo $code;
				}
				exit;
			}else if($this->input->post("code") && $this->input->post("name")){

				$result = $this->order_m->codeInput();
				result($result, "쿠폰이 등록", cdir()."/order/coupon/m");

			}

			$this->load->view("/dhadm/coupon/coupon_write",$data);

		}else if($mode=="edit"){

			$idx = $this->uri->segment(5);
			if(!$idx){
				back("잘못된 접근입니다."); exit;
			}else{
				$data['row'] = $this->common_m->getRow2("dh_coupon_two","where idx='".$this->db->escape_str($idx)."'");

				if($this->input->post("code") && $this->input->post("idx") && $this->input->post("name")){

					$result = $this->order_m->codeInput('edit');
					result($result, "쿠폰이 수정", cdir()."/order/coupon/m");

				}

				$this->load->view("/dhadm/coupon/coupon_write",$data);

			}


		}else if($this->input->post('del_idx') && $this->input->post('del_ok')==1){

			$result = $this->common_m->del("dh_coupon_two","idx", $this->input->post('del_idx')); //해당 유저 삭제
			result($result, "삭제", cdir()."/order/coupon_two/m");

		}
		else if($mode == "cpret"){
			$idx = $this->input->post('idx');
			$update['status'] = 0;
			$where['idx'] = $idx;
			$result = $this->common_m->update2("dh_coupon_two",$update,$where);
			if($result){
				alert($_SERVER['HTTP_REFERER']);
			}
		}
		else{


			// 페이징 start */
			$PageNumber = $this->input->get("PageNumber"); //현재 페이지
			if(!$PageNumber){ $PageNumber = 1; }
			$list_num='15'; //페이지 목록개수
			$page_num='5'; //페이징 개수
			$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
			$data['totalCnt'] = $this->common_m->getPageList('dh_coupon_two','count','','',$where_query,$order_query); //총개수
			$data['Page'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
			// 페이징 end */

			//$data['list'] = $this->common_m->getPageList('dh_coupon_two','',$offset,$list_num,$where_query,$order_query,'*,(select userid from dh_trade where memo = dh_coupon_two.code) as use_id'); //리스트
			$data['list'] = $this->common_m->getPageList('dh_coupon_two','',$offset,$list_num,$where_query,$order_query); //리스트
			$this->load->view("/dhadm/coupon/coupon_list",$data);

		}
	}

	public function coupon_use_list_excel(){

		$where_query = " where 1 ";
		$item = $this->input->get('item');
		$val = $this->input->get('val');
		$type = $this->input->get('type');

		if($item && $val){ $where_query .= " and $item like '%$val%'";	}
		if($type){ $rtype = $type-1; $where_query .= " and type = '{$rtype}'";	}

		$sql = "
		select
			code,
			name,
			price,
			start_date,
			end_date,
			(select name from dh_member where userid = dh_coupon_use.userid) as mem_name,
			userid,
			(select concat(phone1,'-',phone2,'-',phone3) from dh_member where userid = dh_coupon_use.userid) as mem_phone,
			(select reg_date from dh_coupon where code = dh_coupon_use.code) as coupon_reg_date,
			reg_date,
			if(use_date<>'0000-00-00 00:00:00',use_date,'-') as use_date,
			if(use_date<>'0000-00-00 00:00:00',trade_code,'-') as trade_code
		from dh_coupon_use
		{$where_query}
		";

		$data['list'] = $this->common_m->self_q($sql,"result");
		$this->load->view('/dhadm/excel/coupon_use_list',$data);
	}


	public function couponTrade($data='')
	{
		$idx = $this->uri->segment(3);
		$couponRow = $this->common_m->getRow("dh_coupon","where idx='$idx'");
		$data['list'] = $this->common_m->getList2("dh_coupon_use","where code='".$couponRow->code."' order by idx asc");
		$data['couponCnt'] = $this->common_m->getCount("dh_coupon_use","where code='".$couponRow->code."'");
		$data['row'] = $couponRow;

		$this->load->view('/dhadm/order/couponTrade', $data);
	}

	public function member_point($data=''){

		$userid = $this->input->get('userid');
		$sch_sdate = $this->input->get('sch_sdate');
		$sch_edate = $this->input->get('sch_edate');
		$data['query_string'] = "?";
		$where_query = "where 1";

		if($userid){
			$data['query_string'] .= "&userid=".$userid;
			$where_query .= " and userid = '{$userid}'";
		}

		if($sch_sdate){
			$data['query_string'] .= "&sch_sdate=".$sch_sdate;
			if($sch_edate){
				$data['query_string'] .= "&sch_edate=".$sch_edate;
				$where_query .= " and date_format(reg_date,'%Y-%m-%d') between '{$sch_sdate}' and '{$sch_edate}'";
			}
			else{
				$today_date = date("Y-m-d");
				$where_query .= " and date_format(reg_date,'%Y-%m-%d') between '{$sch_sdate}' and '{$today_date}'";
			}
		}

		// 페이징 start */
		$PageNumber = $this->input->get("PageNumber"); //현재 페이지
		if(!$PageNumber){ $PageNumber = 1; }
		$list_num='20'; //페이지 목록개수
		$page_num='5'; //페이징 개수
		$url = cdir()."/";
		$url .= ($this->uri->segment(1))?$this->uri->segment(1)."/":"";
		$url .= ($this->uri->segment(2) and $this->uri->segment(2)!="m")?$this->uri->segment(2)."/":"";
		$url .= ($this->uri->segment(3) and $this->uri->segment(3)!="m")?$this->uri->segment(3)."/":"";
		$url .= ($this->uri->segment(4) and $this->uri->segment(4)!="m")?$this->uri->segment(4)."/":"";
		$url .= "m";
		$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
		$data['totalCnt'] = $data['total'] = $this->common_m->self_q("select * from dh_point {$where_query}","cnt");
		$data['Page'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
		// 페이징 end */

		if($this->input->get('excel')=='ok'){
			$data['list'] = $this->common_m->self_q("select *,(select name from dh_member where userid = dh_point.userid) as name , (select nick from dh_member where userid = dh_point.userid) as nick from dh_point {$where_query} order by idx desc","result");

			$this->load->view("/dhadm/excel/member_point",$data);
		}
		else{
			$data['list'] = $this->common_m->self_q("select *,(select name from dh_member where userid = dh_point.userid) as name , (select nick from dh_member where userid = dh_point.userid) as nick from dh_point {$where_query} order by idx desc limit {$offset}, {$list_num}","result");
			$data['point'] = $this->common_m->self_q("select sum(point) as sum_point from dh_point {$where_query}","row");

			$this->load->view("/dhadm/order/member_point",$data);
		}

	}

	public function main($data=''){

		if($_POST){
			if($this->input->post('mode') == "input"){
				$ins['userid'] = $this->input->post("userid");
				$ins['memo'] = $this->input->post("memo",true);
				$ins['wdate'] = timenow();

				$result = $this->common_m->insert2("dh_admin_memo",$ins);
				if($result){
					alert($_SERVER['HTTP_REFERER']);
				}
			}
			else if($this->input->post('mode') == "del"){
				if(!$this->input->post('idx')){
					back("잘못된 접근입니다.");
				}

				$result = $this->common_m->self_q("delete from dh_admin_memo where idx = '".$this->input->post('idx')."'","delete");
				if($result){
					alert($_SERVER['HTTP_REFERER']);
				}
			}
		}

		$data['now_login_admin'] = $now_login_admin = $this->session->userdata('ADMIN_USERID');
		$data['memo_list'] = $this->common_m->self_q("select * from dh_admin_memo where userid = '{$now_login_admin}' order by idx desc","result");

		//내일 배송예약건
		//내일 날짜

		$data['tomorrow'] = $tomorrow = date("Y-m-d",strtotime('+1 day',time()));
		$data['tomorrow_day_name'] = numberToWeekname($tomorrow);

		//내일 배송나갈 주문건 카운트
		$tmo_sql = "select distinct a.deliv_code".PHP_EOL;
		//$tmo_sql.= ", a.*, b.trade_stat, b.first_order, b.mobile, b.trade_day, b.total_price, b.trade_method, b.send_text".PHP_EOL;
		//$tmo_sql.= ", (select count(idx) from dh_trade_deliv_log where deliv_code = a.deliv_code) as log_count".PHP_EOL;
		$tmo_sql.= "from dh_trade_deliv_info a, dh_trade b".PHP_EOL;
		$tmo_sql.= "where a.trade_code = b.trade_code".PHP_EOL;
		$tmo_sql.= "and b.trade_stat between 2 and 3".PHP_EOL;
		$tmo_sql.= "and a.deliv_stat < 4".PHP_EOL;	//배송대기 :0, 준비중 :1, 중 :2, 완료 :3 모두다
		$tmo_sql.= "and a.deliv_date = '{$tomorrow}'".PHP_EOL;

		//$data['tomorrow_delivery_cnt'] = $this->common_m->self_q("select distinct deliv_code from dh_trade_deliv_info where deliv_date = '{$tomorrow}'","cnt");
		$data['tomorrow_delivery_cnt'] = $this->common_m->self_q($tmo_sql,"cnt");

		//지난배송 미완료 처리 건수 카운트
		//배송완료후 3일이 지난건을 기준으로
		$deliv_ago_day = date("Y-m-d",strtotime('-3 day',time()));
		//3일전 날짜를 구해서 얘보다 배송일이 더 아래인것들
		$order_comp_ple = "
			select a.idx
			from dh_trade_deliv_info a left join dh_trade b on a.trade_code = b.trade_code
			where a.deliv_stat  = 2
			and a.deliv_date < '{$deliv_ago_day}'
			and b.trade_stat between 2 and 3
		";

		if($_SERVER['REMOTE_ADDR'] == "112.221.155.109"){
			//echo $order_comp_ple;
		}

		$data['order_complete_please'] = $this->common_m->self_q($order_comp_ple,"cnt");

		//주문취소 미처리 갯수 ( 주문취소요청인것들의 카운트 )
		$data['order_cancel_please'] = $this->common_m->self_q("select trade_code from dh_trade where trade_stat = 10","cnt");

		//1대1 문의 미처리 건수 ( 코멘트 안달린 애들 갯수 )
		$data['qna_comment_please'] = $this->common_m->self_q("select b.idx from dh_bbs_data a left join dh_bbs_coment b on a.idx = b.link where code = 'withcons07' and b.idx is null","cnt");

		//주문 / 취소 현황
		//$today = "2018-07-10";
		$today = date("Y-m-d");
		$term = 3;
		$info = array();
		$info_key = array();
		for($i=0;$i<=$term;$i++){
			if($i == 0){
				$date = $today;
			}
			else{
				$date = date("Y-m-d",strtotime('-'.$i.' day',strtotime($today)));
			}

			$info[$date] = $this->order_m->get_order_settle_sum($date);
			$ccinfo[$date] = $this->order_m->get_order_settle_cc_sum($date);
			$day_name = numberToWeekname($date);
			$info_key[$date] = $day_name;
		}

		$data['info'] = $info;
		$data['ccinfo'] = $ccinfo;
		$data['info_key'] = $info_key;
		$data['day_name'] = $day_name;

		$this->load->view("/dhadm/order/main",$data);
	}

	public function delivery($data=''){
		$data['mode'] = $mode = $this->uri->segment(4,'');

		if($mode == "view"){	//통합배송 뷰페이지
			$data['deliv_code'] = $deliv_code = $this->uri->segment(5);
			$data['deliv_info'] = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '{$deliv_code}'","row");

			$deliv_sql = "select a.*, b.recom_name
										from dh_trade_deliv_prod a
										left join dh_recom_food b on a.recom_idx = b.idx
										where deliv_code = '{$deliv_code}'
										order by goods_idx asc";

										//echo $deliv_sql;

			$data['list'] = $this->common_m->self_q($deliv_sql,"result");

			//$data['recom_prod'] = $this->common_m->self_q("select a.*, b.name from dh_trade_deliv_prod a, dh_goods b where a.goods_idx = b.idx and a.recom_is = 'Y' and a.deliv_code = '{$deliv_code}'","result");

			$this->load->view("/dhadm/order/deliv_".$mode,$data);
		}
		else if($mode == "order_change"){	//주문변동내역
			$data['deliv_code'] = $deliv_code = $this->uri->segment(5);
			$data['deliv_info'] = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '{$deliv_code}'","row");

			if($_POST){
				$insert_log['userid'] = $this->input->post("admin_userid");
				$insert_log['type'] = "관리자입력 : ".$this->input->post("admin_name");
				$insert_log['msg'] = $this->input->post("memo_content");
				$insert_log['deliv_code'] = $deliv_code;
				$insert_log['wdate'] = date("Y-m-d H:i:s");
				$insert_log['writer'] = "관리자";

				$result = $this->common_m->insert2("dh_trade_deliv_log",$insert_log);
				if($result){
					alert($_SERVER['HTTP_REFERER'],'등록 되었습니다.');
				}

			}
			else{

				$sql = "
					select *
					from dh_trade_deliv_log
					where deliv_code = '{$deliv_code}'
					order by wdate desc
				";
				$data['list'] = $this->common_m->self_q($sql,"result");

			}

			$this->load->view("/dhadm/order/deliv_".$mode,$data);
		}
		else if($mode == "logdel"){	//로그 삭제
			$idx = $this->uri->segment(5);
			if($idx){
				$result = $this->common_m->self_q("delete from dh_trade_deliv_log where idx = '{$idx}'","delete");
				if($result){
					alert($_SERVER['HTTP_REFERER']);
				}
			}
			else{
				alert($_SERVER['HTTP_REFERER'],"IDX 누락으로 처리할 수 없습니다.");
			}
		}
		else if($mode == "memo"){	//회원주문메모
			$data['deliv_code'] = $deliv_code = $this->uri->segment(5);
			$data['row'] = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '{$deliv_code}'","row");

			if($this->input->get('memo_idx')){
				$idx = $this->input->get('memo_idx');
				$result = $this->common_m->self_q("delete from dh_member_memo where idx = '{$idx}'","delete");
				if($result){
					alert($_SERVER['HTTP_REFERER']);
				}
			}

			if($_POST){

				//메모 기록
				//필요항목
				//관리자아이디, 관리자 이름, 작성일자, 고객아이디, 고객이름(?), 메모내용,

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

			//주문시 요청사항
			if(strpos($deliv_code,"_")!==false){
				$deliv_code_arr = deliv_code_arr($deliv_code);
				$trade_code = $deliv_code_arr['trade_code'];
			}
			else{
				$deliv_code_arr = explode("-",$deliv_code);
				$trade_code = $deliv_code_arr[0];
			}
			$data['trade_info'] = $this->common_m->self_q("select * from dh_trade where trade_code = '{$trade_code}'","row");

			$this->load->view("/dhadm/order/deliv_".$mode,$data);
		}
		else if($mode == "send_receive"){	//주문 / 받는사람
			$data['deliv_code'] = $deliv_code = $this->uri->segment(5);
			$data['row'] = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '{$deliv_code}'","row");

			if($_POST){
				//exc_dbin($_POST);
				$db_table = "dh_trade_deliv_info";

				$where['deliv_code'] = $this->input->post("deliv_code");

				$update['deliv_addr'] = $this->input->post("deliv_addr_set");
				$update['order_name'] = $this->input->post("order_name");
				$update['order_phone'] = $this->input->post("order_phone");
				$update['recv_name'] = $this->input->post("recv_name");
				$update['recv_phone'] = $this->input->post("recv_phone");
				$update['zipcode'] = $this->input->post("zipcode");
				$update['addr1'] = $this->input->post("addr1");
				$update['addr2'] = $this->input->post("addr2");

				$result = $this->common_m->update2($db_table,$update,$where);
				if($result){

					//로그기록	//write_log($userid, $type, $msg, $deliv_code, $wdate, $writer)
					$log_msg = "배송지가 변경되었습니다.";
					$log_msg .= "기존 : (".$data['row']->zipcode.")" . $data['row']->addr1 . " " . $data['row']->addr2;
					$log_msg .= " 받는분 : " . $data['row']->recv_name . " 받는분 연락처 : " . $data['row']->recv_phone;

					$log_writer = "관리자(".$this->session->userdata('ADMIN_USERID').")";
					$result = $this->common_m->write_log($data['row']->userid, "배송지 변경", $log_msg, $deliv_code, timenow(), $log_writer);

					if($result){
						alert($_SERVER['HTTP_REFERER'],'수정 되었습니다.');
					}

				}
			}

			//배송일에 다른 배송건 있는지 확인
			$data['dup_cnt'] = $dup_cnt = $this->common_m->self_q("select * from dh_trade_deliv_info where userid='".$data['row']->userid."' and deliv_stat=0 and deliv_date='".$data['row']->deliv_date."' and recom_idx=0 and trade_code != '".$data['row']->trade_code."'","cnt");
			if($dup_cnt){
				$data['dup_list'] = $this->common_m->self_q("select * from dh_trade_deliv_info where userid='".$data['row']->userid."' and deliv_stat=0 and deliv_date='".$data['row']->deliv_date."' and recom_idx=0","result");
			}

			$this->load->view("/dhadm/order/deliv_".$mode,$data);
		}
		else if($mode == "food_update"){	//식단 수정

			$mode = $this->input->post('mode');
			if($_POST){
				if($mode == "del"){	//로그 기록
					$lsql = "select a.* , b.name
									 from dh_trade_deliv_prod a left join dh_goods b on a.goods_idx = b.idx
									 where a.idx = '".$this->input->post('idx')."'";

					$lrow = $this->common_m->self_q($lsql,"row");

					$ldata['userid'] = $this->session->userdata("ADMIN_USERID");
					$ldata['type'] = "식단수정 : 삭제";
					$ldata['msg'] = "식단 : ".$lrow->name." 을 삭제 하였습니다.";
					$ldata['deliv_code'] = $lrow->deliv_code;
					$ldata['wdate'] = timenow();
					$ldata['writer'] = "관리자";

					$result = $this->common_m->insert2("dh_trade_deliv_log",$ldata);
					if($result){
						$result = $this->common_m->self_q("delete from dh_trade_deliv_prod where idx = '".$this->input->post('idx')."'","delete");
						if($result){

							//식단 변경시 배송코드 기타로 변경
							//$this->common_m->self_q("update dh_trade_deliv_info set order_type = '999999' where deliv_code = '".$lrow->deliv_code."'","update");

							alert($_SERVER['HTTP_REFERER']);
						}
					}

				}
				else{
					$gd_arr = explode("@",$this->input->post('goods_idx'));
					$deliv_info = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '".$this->input->post('deliv_code')."'","row");
					$insert_data['trade_code'] = $deliv_info->trade_code;
					$insert_data['deliv_code'] = $deliv_info->deliv_code;
					$insert_data['deliv_date'] = $deliv_info->deliv_date;
					$insert_data['goods_idx'] = $gd_arr[0];
					$insert_data['recom_idx'] = $deliv_info->recom_idx;
					$insert_data['prod_cnt'] = '1';
					$insert_data['cate_no'] = $gd_arr[1];
					$insert_data['recom_is'] = $deliv_info->recom_idx?"Y":"";
					$insert_data['wdate'] = timenow();

					$result = $this->common_m->insert2("dh_trade_deliv_prod",$insert_data);
					if($result){	//로그 기록

						$lrow = $this->common_m->self_q("select * from dh_goods where idx = '".$gd_arr[0]."'","row");

						$ldata['userid'] = $this->session->userdata("ADMIN_USERID");
						$ldata['type'] = "식단수정 : 추가";
						$ldata['msg'] = "식단 : ".$lrow->name." 을 추가 하였습니다.";
						$ldata['deliv_code'] = $deliv_info->deliv_code;
						$ldata['wdate'] = timenow();
						$ldata['writer'] = "관리자";

						$result = $this->common_m->insert2("dh_trade_deliv_log",$ldata);

						if($result){

							//식단 변경시 배송코드 기타로 변경
							//$this->common_m->self_q("update dh_trade_deliv_info set order_type = '999999' where deliv_code = '".$deliv_info->deliv_code."'","update");

							alert($_SERVER['HTTP_REFERER']);
						}

					}
				}
			}

			$data['goods'] = $this->common_m->self_q("select * from dh_goods where display = 1 order by name asc","result");

			$cate_list = $this->common_m->self_q("select * from dh_category","result");
			$data['cate_name_arr'] = array();
			foreach($cate_list as $cl){
				$data['cate_name_arr'][$cl->cate_no] = $cl->title;
			}

			$ssql = "select a.*,b.name, b.list_img from dh_trade_deliv_prod a left join dh_goods b on a.goods_idx = b.idx where a.deliv_code = '".$this->input->get('dcode')."' and a.prod_cnt > 0 order by name asc";
			$data['list'] = $this->common_m->self_q($ssql,"result");

			$deliv_code_arr = deliv_code_arr($this->input->get('dcode'));
			$trade_code = $deliv_code_arr['trade_code'];

			$data['trade_stat'] = $this->common_m->self_q("select * from dh_trade where trade_code = '{$trade_code}'","row");

			$this->load->view("/dhadm/order/deliv_foods_update",$data);

		}
		else if($mode == "foods_list"){

			$code = $this->input->get('code');

			//$list = $this->common_m->self_q("select * from dh_trade_deliv_prod where deliv_code = '{$code}' and recom_is = 'Y'","result");
			//$recom_foods_list = unserialize($row->recom_foods);

			//$goods = $this->common_m->self_q("select * from dh_goods","result");
			//$goods_info = array();
			//foreach($goods as $gd){
			//	$goods_info[$gd->idx]['name'] = $gd->name;
			//	$goods_info[$gd->idx]['list_img'] = $gd->list_img;
			//}
			//pr($goods_info);
			//pr($recom_foods_list);

			//$data['goods_info'] = $goods_info;
			//$data['list'] = $list;

			$sql = "
				select d.deliv_date, g.list_img, g.name, d.prod_cnt
				from dh_trade_deliv_prod d left join dh_goods g
					on	d.goods_idx = g.idx
				where d.deliv_code = '{$code}'
				and d.recom_is = 'Y'
				order by deliv_date asc, g.name asc
			";

			$data['list'] = $this->common_m->self_q($sql,"result");
			$this->load->view("/dhadm/order/deliv_foods",$data);
		}
		else if($mode == "deliv_complete"){	//배송완료 일괄처리

			//배송중에서 배송완료로 변경하는 방법은 이거밖에 없음
			/*
			배송테이블 (dh_trade_deliv_info) 기준 검색 (조건 : 오늘 날짜 기준 3일전 배송된 항목 모두)
			검색된 값을 토대로 아래 작업을 실행 ( 알고리즘 )
				- 배송 완료 처리 후 전체 배송이 완료인지 확인해야하며, ( 추가 쿼리 발생 디비 서버 부하 증가 예상 )
				- 전체 배송이 완료인 경우 거래 정보 업데이트 (dh_trade) 판매완료로 수정
				- 판매완료된 건에 대한 적립금 지급

				? 적립금 지급시 추천인 여부 확인
				? 추천인이 있을경우 추천인에게도 적립 단, 해당 주문건이 첫 주문인 경우에만(?) 10% 양방향 적립 ( 추천인 , 해당 회원 )

				. 판매 완료된 건에 대한 회원 등급 조정을 추가로 할지에 대한 검토
			*/

			$level_info = $this->common_m->self_q("select * from dh_member_level order by level desc","result");
			$level_up_price = array();
			foreach($level_info as $li){
				$level_up_price[$li->level] = $li->level_up_price;
			}
			//오늘 기준 3일전 추출
			$act_date = date("Y-m-d",strtotime("-3 day"));
			$sql = "select a.trade_code, a.deliv_code, a.userid, a.deliv_stat,a.userid,
							b.first_order, b.total_price, b.sample_is, b.save_point
							from dh_trade_deliv_info a left join dh_trade b on a.trade_code = b.trade_code
							where a.deliv_stat = '2'
							and b.trade_stat between 2 and 3
							and a.deliv_date <= '{$act_date}'
							order by a.deliv_date asc";

			$deliv_list = $this->common_m->self_q($sql,"result");

			foreach($deliv_list as $dl){	//배송중인 거래건들 업데이트 시작

				$result = $this->common_m->self_q("update dh_trade_deliv_info set deliv_stat = '3' where deliv_code = '".$dl->deliv_code."'","update");	//배송 완료로 업데이트

				//로그 기록
				$deliv_stat_arr = array('0'=>'배송대기','1'=>'배송준비중','2'=>'배송중','3'=>'배송완료','4'=>'배송중지','5'=>'배송취소','6'=>'휴일정지','7'=>'조기마감');
				$log_type = "배송상태변경";
				$log_msg = "배송상태 ".$deliv_stat_arr[3]."(으)로 변경";
				$writer = $this->session->userdata('ADMIN_USERID')."(".$this->session->userdata('ADMIN_NAME').")";
				$this->common_m->write_log($dl->userid, $log_type, $log_msg, $this->input->get('deliv_code'), timenow(), $writer);
				//$result = 1;

				//echo $dl->deliv_code.":dh_trade_deliv_info 업데이트:".$result."<BR>";

				//해당 주문건으로 포인트가 적립 되었는지 확인;
				$deliv_code_arr = deliv_code_arr($dl->deliv_code);
				$trade_code = $deliv_code_arr['trade_code'];

				$reward_sql = "select * from dh_point where trade_code = '{$trade_code}' and point > 0";
				$reward_cnt = $this->common_m->self_q($reward_sql,"cnt");

				if($result){
					$complete_cnt = $this->common_m->self_q("select * from dh_trade_deliv_info where trade_code = '".$dl->trade_code."' and deliv_stat != 3","cnt");	//거래번호 포함된 배송건 중 배송완료가 아닌거 찾음
					if($complete_cnt > 0){	//배송중인 거래건이 남아있는경우
						//echo "<p style='border:2px solid red;'></p>";
						//echo $complete_cnt."<BR>";
						continue;
					}
					else{	//해당 거래번호에 해당하는 배송건이 더는 없는 경우

						$result = $this->common_m->self_q("update dh_trade set trade_stat = '4' where trade_code = '".$dl->trade_code."'","update");	//거래건 완료로 처리하고 회원 정보 불러서 추천인 있는지 확인하기 전에 첫주문인지 부터 확인

						//echo $dl->deliv_code.":dh_trade 업데이트:".$result."<BR>";

						if($result and $reward_cnt <= 0){	//거래건 판매완료 처리 성공시

							$member_info = $this->common_m->self_q("select *,(select reward from dh_member_level where level = dh_member.level) as reward from dh_member where userid = '{$dl->userid}'","row");
							$first_and_recom = false;
							//첫주문 여부 분기점
							if($dl->first_order == "Y"){	//첫주문
								if($member_info->recomid){
									$first_and_recom = true;
								}
							}

							//echo ":첫주문 추천인 분기점:".var_dump($first_and_recom)."<BR>";

							//포인트 지급
							if($first_and_recom){	//추천인이 있고 첫주문임

								$point = $dl->total_price * 0.1;

								//추천인과 본인 동시 지급
								$insert1['userid'] = $dl->userid;
								$insert1['point'] = round($point);	//소숫점 버림
								$insert1['content'] = "첫주문 (주문번호:".$dl->trade_code.") 추천인 포함 10% 적립";
								$insert1['flag'] = "trade";
								$insert1['trade_code'] = $dl->trade_code;
								$insert1['reg_date'] = timenow();

								if($point > 0){
									$result = $this->common_m->insert2("dh_point",$insert1);
									//echo "첫주문 추천인 :dh_point ".$point." 입력:".$result."<BR>";
								}

								if($result){	//추천인 포인트 지급	추천인이 회원탈퇴를 했는지 여부는 안따짐

									$insert1['userid'] = $member_info->recomid;
									$insert1['point'] = round($point);	//소숫점 버림
									$insert1['content'] = $member_info->name."님께서 추천후 첫구매 완료 (10% 적립)";
									$insert1['flag'] = "recom";
									$insert1['reg_date'] = timenow();

									if($point > 0){
										$result = $this->common_m->insert2("dh_point",$insert1);
										//echo "첫주문 추천인에게 :dh_point ".$point." 입력:".$result."<BR>";
									}

								}

							}
							else{

								$point = $dl->total_price * $member_info->reward * 0.01;

								$insert1['userid'] = $dl->userid;
								$insert1['point'] = round($point);	//소숫점 버림
								$insert1['content'] = "거래완료 [".$dl->trade_code."]";
								$insert1['flag'] = "trade";
								$insert1['trade_code'] = $dl->trade_code;
								$insert1['reg_date'] = timenow();

								if($point > 0){
									$result = $this->common_m->insert2("dh_point",$insert1);
									//echo "첫주문 아닌거 :dh_point ".$point." 입력:".$result."<BR>";
								}

							}

							if($result){	//회원 거래건 합산하여 등업 여부 결정

								if($member_info->level < 3){
									$total_payment = $this->common_m->self_q("select sum(total_price) as tp from dh_trade where userid = '".$dl->userid."' and trade_stat = '4'","row");

									//echo "거래총액 :  :".$total_payment->tp."<BR>";

									foreach($level_up_price as $level => $levup_price){
										if($total_payment->tp > $levup_price){
											$lev = $level;
											break;
										}
										else{
											$lev = $member_info->level;
										}
									}

									//echo "기존 레벨 :  :".$member_info->level."<BR>";
									//echo "변경될 레벨 :  :".$lev."<BR>";

									if($lev != $member_info->level){

										$result = $this->common_m->self_q("update dh_member set level = '{$lev}' where userid = '".$dl->userid."'","update");

										//echo "레벨업 :업데이트:".$result."<BR>";

										//회원 등업시 쿠폰 자동지급
										if($lev==2){
											$coupon_row = $this->common_m->self_q("select * from dh_coupon where code = '1809UKCTDCX4'","row");
										}
										else if($lev==3){
											$coupon_row = $this->common_m->self_q("select * from dh_coupon where code = '1809ETYLXPW6'","row");
										}

										$userid = $dl->userid;
										$coupon_use_cnt = $this->common_m->self_q("select * from dh_coupon_use where code = '".$coupon_row->code."' and userid = '{$userid}'","cnt");
										if($coupon_use_cnt <= 0){
											$cpin['userid'] = $userid;
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

										if($result){

											$lev_chg['userid'] = $dl->userid;
											$lev_chg['before_level'] = $member_info->level ? $member_info->level : "" ;
											$lev_chg['after_level'] = $lev;
											$lev_chg['info'] = "거래 완료처리시 레벨 업";
											$lev_chg['wdate'] = timenow();

											$result = $this->common_m->insert2("dh_member_level_change",$lev_chg);

											//echo "레벨업 :히스토리 입력:".$result."<BR>";

										}

									}

								}
								else{
									$result = "1";
								}

							}

						}

					}
				}

				//echo "<p style='border:2px solid red;'></p>";

			}

			if($result){
				alert($_SERVER['HTTP_REFERER'],"배송완료 일괄처리가 완료 되었습니다.");
			}

		}
		else if($mode == "deliv_stat_update"){	//배송완료 개별처리

			$deliv_stat_arr = array('0'=>'배송대기','1'=>'배송준비중','2'=>'배송중','3'=>'배송완료','4'=>'배송중지','5'=>'배송취소','6'=>'휴일정지','7'=>'조기마감');
			$row = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '".$this->input->get('deliv_code')."'","row");

			$result = $this->common_m->self_q("update dh_trade_deliv_info set deliv_stat = '".$this->input->get('stat')."' where deliv_code = '".$this->input->get('deliv_code')."'","update");	//받은 값으로 배송정보업데이트

			//로그 기록
			$deliv_stat_arr = array('0'=>'배송대기','1'=>'배송준비중','2'=>'배송중','3'=>'배송완료','4'=>'배송중지','5'=>'배송취소','6'=>'휴일정지','7'=>'조기마감');
			$log_type = "배송상태변경";
			$log_msg = "배송상태 ".$deliv_stat_arr[$this->input->get('stat')]."로 변경";
			$writer = $this->session->userdata('ADMIN_USERID')."(".$this->session->userdata('ADMIN_NAME').")";
			$this->common_m->write_log($row->userid, $log_type, $log_msg, $this->input->get('deliv_code'), timenow(), $writer);

			if($result){
				if($this->input->get('stat') == "3"){	//배송스텟이 배송완료인경우
					$sql = "
						select a.trade_code, a.deliv_code, a.userid, a.deliv_stat,
						b.first_order, b.total_price, b.sample_is, b.save_point
						from dh_trade_deliv_info a left join dh_trade b on a.trade_code = b.trade_code
						where deliv_code = '".$this->input->get('deliv_code')."'
					";
					$row = $this->common_m->self_q($sql,"row");	//배송정보 검색

					$deliv_cnt = $this->common_m->self_q("select * from dh_trade_deliv_info where trade_code = '".$row->trade_code."' and deliv_stat < 3","cnt");	//같은 주문의 배송완료 여부 파악
					if($deliv_cnt > 0){	//같은 주문에 배송이 하나라도 남은경우 빠염
						alert($_SERVER['HTTP_REFERER']);
					}
					else{	//배송이 전부 완료된경우
						$result = $this->common_m->self_q("update dh_trade set trade_stat = 4 where trade_code = '".$row->trade_code."'","update");	//거래정보 판매완료로 업데이트
						if($result){
							$member_info = $this->common_m->self_q("select *,(select reward from dh_member_level where level = dh_member.level) as reward from dh_member where userid = '".$row->userid."'","row");	//회원정보 불러옴
							$first_and_recom = false;
							//첫주문 여부 분기점
							if($row->first_order == "Y"){	//첫주문
								if($member_info->recomid){
									$first_and_recom = true;
								}
							}

							if($first_and_recom){	//추천인이 있는경우
								$point = $row->total_price * 0.1;

								//추천인과 본인 동시 지급
								$insert1['userid'] = $row->userid;
								$insert1['point'] = round($point);	//소숫점 버림
								$insert1['content'] = "첫주문 (주문번호:".$row->trade_code.") 추천인 포함 10% 적립";
								$insert1['flag'] = "trade";
								$insert1['trade_code'] = $row->trade_code;
								$insert1['reg_date'] = timenow();

								if($point > 0){
									$result = $this->common_m->insert2("dh_point",$insert1);
									//echo "첫주문 추천인 :dh_point ".$point." 입력:".$result."<BR>";
								}

								if($result){	//추천인 포인트 지급	추천인이 회원탈퇴를 했는지 여부는 안따짐

									$insert1['userid'] = $member_info->recomid;
									$insert1['point'] = round($point);	//소숫점 버림
									$insert1['content'] = $member_info->name."님께서 추천후 첫구매 완료 (10% 적립)";
									$insert1['flag'] = "recom";
									$insert1['reg_date'] = timenow();

									if($point > 0){
										$result = $this->common_m->insert2("dh_point",$insert1);
										//echo "첫주문 추천인에게 :dh_point ".$point." 입력:".$result."<BR>";
									}

								}
							}
							else{	//추천인이 없는 경우
								$point = $row->total_price * $member_info->reward * 0.01;

								$insert1['userid'] = $row->userid;
								$insert1['point'] = round($point);	//소숫점 버림
								$insert1['content'] = "거래완료 [".$row->trade_code."]";
								$insert1['flag'] = "trade";
								$insert1['trade_code'] = $row->trade_code;
								$insert1['reg_date'] = timenow();

								if($point > 0){
									$result = $this->common_m->insert2("dh_point",$insert1);
									//echo "첫주문 아닌거 :dh_point ".$point." 입력:".$result."<BR>";
								}
							}

							//포인트 입력후 회원 등급 조정
							if($result){

								$level_info = $this->common_m->self_q("select * from dh_member_level order by level desc","result");	//회원레벨 정보
								$level_up_price = array();
								foreach($level_info as $li){
									$level_up_price[$li->level] = $li->level_up_price;
								}

								if($member_info->level < 3){
									$total_payment = $this->common_m->self_q("select sum(total_price) as tp from dh_trade where userid = '".$row->userid."' and trade_stat = '4'","row");

									foreach($level_up_price as $level => $levup_price){
										if($total_payment->tp > $levup_price){
											$lev = $level;
											break;
										}
										else{
											$lev = $member_info->level;
										}
									}

									if($lev != $member_info->level){

										$result = $this->common_m->self_q("update dh_member set level = '{$lev}' where userid = '".$row->userid."'","update");

										//회원 등업시 쿠폰 자동지급
										if($lev==2){
											$coupon_row = $this->common_m->self_q("select * from dh_coupon where code = '1809UKCTDCX4'","row");
										}
										else if($lev==3){
											$coupon_row = $this->common_m->self_q("select * from dh_coupon where code = '1809ETYLXPW6'","row");
										}

										$userid = $row->userid;
										$coupon_use_cnt = $this->common_m->self_q("select * from dh_coupon_use where code = '".$coupon_row->code."' and userid = '{$userid}'","cnt");
										if($coupon_use_cnt <= 0){
											$cpin['userid'] = $userid;
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

										if($result){

											$lev_chg['userid'] = $dl->userid;
											$lev_chg['before_level'] = $member_info->level ? $member_info->level : "" ;
											$lev_chg['after_level'] = $lev;
											$lev_chg['info'] = "거래 완료처리시 레벨 업";
											$lev_chg['wdate'] = timenow();

											$result = $this->common_m->insert2("dh_member_level_change",$lev_chg);

										}

									}

								}
								else{
									$result = "1";
								}
							}
						}

						if($result){
							alert($_SERVER['HTTP_REFERER']);
						}
					}
				}
				else{	//배송스탯이 완료가 아닌 경우 ( 그 외 전부 포함 준비중, 배송중, 중지, 취소, 대기도 ㅋㅋㅋ )	주문상태 배송중으로 업데이트 쳐준다 무조건 뭘하든 어쨋든 저쨋든
					$deliv_code_arr = deliv_code_arr($this->input->get('deliv_code'));
					$trade_code = $deliv_code_arr['trade_code'];

					$row = $this->common_m->self_q("select * from dh_trade where trade_code = '{$trade_code}'","row");
					if($row->trade_stat != 1 and $row->trade_stat < 3){
						$result = $this->common_m->self_q("update dh_trade set trade_stat = 3 where idx = ".$row->idx."","update");
					}
					else{
						if($row->trade_stat == 1){
							back("주문내역은 입금처리가 되지 않아 배송중으로 변경 하지 못했습니다.");
						}
					}

					if($result){
						alert($_SERVER['HTTP_REFERER']);
					}
				}
			}

		}
		else if($mode == "deliv_date_update"){	//배송일 변경

			$row = $data['row'] = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '".$this->input->get('deliv_code')."'","row");

			//배송일 변경시 배송코드 변경 / 정기배송인 경우 배송일 묶음 업데이트 / 배송상품 DB 배송코드 업데이트 / 정기배송인 경우 식단 날짜에 맞게 변경

			if($_POST){

				$idx = $this->input->post('idx');
				$deliv_code = $this->input->post('deliv_code');
				$sel_date = $this->input->post('sel_date');
				$recom_idx = $this->input->post('recom_idx');
				$deliv_date = $this->input->post('deliv_date');

				if($recom_idx){	//정기배송인 경우

					if($sel_date == $deliv_date){
						back("동일한 날짜로는 배송일 변경이 필요 없습니다.");
					}

					list($trade_code_tmp, $deliv_time, $deliv_type) = explode("-",$deliv_code);
					list($trade_code, $order_count) = explode("_",$trade_code_tmp);

					$deliv_date_time = strtotime($deliv_date);

					//해당 날짜에 식단이 없는경우 브레이크
					$chg_food_cnt = $this->common_m->self_q("select * from dh_recom_food_table where recom_food_idx = '{$recom_idx}' and recom_date = '{$deliv_date}'","cnt");
					if($chg_food_cnt == 0){
						back("선택하신 날짜는 아직 식단 구성이 되지 않았습니다. 다른날짜를 선택해주세요.");
					}
					//해당 날짜에 식단이 없는경우 브레이크

					$update_deliv_code = $trade_code . "_" . $order_count . "-" . $deliv_date_time."-".$deliv_type;

					$trade_row = $this->common_m->self_q("select * from dh_trade where trade_code = '{$trade_code}'","row");

					$recom_week_day_count = $trade_row->recom_week_day_count;
					$recom_delivery_sun_type = $trade_row->recom_delivery_sun_type;
					$recom_week_type = $trade_row->recom_week_type;
					$arr_week_type = explode(":",$recom_week_type);	//배송횟수 짜름

					$update_deliv_date = $deliv_date;	//변경되는 날짜에 대한 배송일

					$tmp_recom_dates_arr = explode("^",substr($trade_row->recom_dates,0,-1));	//기존 배송일 항목 배열로 전환
					$tmp_recom_dates_arr = array_diff($tmp_recom_dates_arr,array($sel_date));	//변경되는 날짜 배열에서 삭제
					array_push($tmp_recom_dates_arr, $deliv_date);	//추가되는 날짜 배열에 추가
					sort($tmp_recom_dates_arr);	//배열 정렬
					$update_recom_dates = "";	//업데이트 문구 작성
					foreach($tmp_recom_dates_arr as $tl){	//배열 돌림
						$update_recom_dates .= $tl."^";	//업데이트 배송일
					}

					//주문DB 배송일 묶음 update , 주문상품 DB 배송일 묶음 udpate
					$this->common_m->self_q("update dh_trade_goods set recom_dates = '{$update_recom_dates}' where trade_code = '{$trade_code}' and cate_no = 'recom'","update");
					$this->common_m->self_q("update dh_trade set recom_dates = '{$update_recom_dates}' where trade_code = '{$trade_code}'","update");

					//배송정보 DB 배송코드 , 배송날짜 update , 배송상품정보 DB 상품정보 update

					/**********************************************
					//배송일 변경에 따른 식단 조정 시작
						*/
					//변경할 날짜를 기준으로 식단을 가져와야하므로 변경할 날짜 기준으로 요일 설정
					$monday = date("Y-m-d", strtotime('monday this week',$deliv_date_time));
					$wednesday = date("Y-m-d", strtotime('wednesday this week',$deliv_date_time));
					$thursday = date("Y-m-d", strtotime('thursday this week',$deliv_date_time));
					$friday = date("Y-m-d", strtotime('friday this week',$deliv_date_time));
					$saturday = date("Y-m-d", strtotime('saturday this week',$deliv_date_time));
					$sunday = date("Y-m-d", strtotime('sunday this week',$deliv_date_time));
					$yesterday = date("Y-m-d", strtotime('yesterday',$deliv_date_time));
					$tomorrow = date("Y-m-d", strtotime('tomorrow',$deliv_date_time));
					$today = date("Y-m-d", $deliv_date_time);
					//식단부터 정리해바
					//원래 받을 날짜 언제여?
					$bf_date_name = date('w',strtotime($sel_date));
					//echo $bf_date_name."<BR>";

					//원래 받을거 갯수
					$bf_cnt_row = $this->common_m->self_q("select sum(prod_cnt) as prod_cnt from dh_trade_deliv_prod where deliv_code = '{$deliv_code}' and recom_is = 'Y'","row");
					$bf_cnt = $bf_cnt_row->prod_cnt;

					//변경할 받을 날짜
					$af_date_name = date("w",$deliv_date_time);

					if($recom_week_day_count >= 6){
						if($af_date_name < 4){
							$start_date = $monday;
							$end_date = $wednesday;
						}
						else{
							$start_date = $thursday;
							$end_date = $saturday;
						}
					}
					else if($recom_week_day_count == 4){
						if($af_date_name < 4){
							$start_date = $monday;
							$end_date = $wednesday;
						}
						else{
							$start_date = $thursday;
							$end_date = $friday;
						}
					}
					else{
						//						$start_date = $yesterday;
						//						$end_date = $today;
						//월요일로 변경시 화목토	// 관리자만 해당됨
						if(date("w",strtotime($yesterday))){	//어제 값이 있는경우
							$start_date = $yesterday;
							$end_date = $today;
						}
						else{
							$start_date = $today;
							$end_date = $tomorrow;
						}
					}

					$sql = "select a.*, b.cate_no from dh_recom_food_table a left join dh_goods b on a.goods_idx = b.idx where a.recom_food_idx = '{$recom_idx}' and a.recom_date between '{$start_date}' and '{$end_date}'";
					$food_list = $this->common_m->self_q($sql,"fetch_array");
					$row = array();
					$af_cnt = 0;
					foreach($food_list as $fl){	//주말분 제외
						if($bf_cnt > $af_cnt){
							$row[] = $fl;
							$af_cnt++;
						}
					}

					if(date("w",strtotime($start_date))<4){
						$sunday = $monday;
					}
					else{
						$sunday = $sunday;
					}

					// 주말분 설정 20201116 김기엽
					$sunday_sql = "select a.*, b.cate_no from dh_recom_food_table a left join dh_goods b on a.goods_idx = b.idx where a.recom_food_idx = '{$recom_idx}' and a.recom_date = '{$sunday}'";
					$sunday_food_list = $this->common_m->self_q($sunday_sql,"fetch_array");
					foreach($sunday_food_list as $fl){	//주말분
						if($bf_cnt > $af_cnt){
							if($recom_week_day_count == 7 && $recom_delivery_sun_type){
								//if($recom_delivery_sun_type == date("w",$chg_date_time) or ($recom_delivery_sun_type-($recom_delivery_sun_type - date("w",$chg_date_time)) == date("w",strtotime($fl['recom_date']))) ){
									$row[] = $fl;
									$af_cnt++;
								//}
							}
						}
					}

					//foreach($food_list as $fl){	//주말분이 아니더라도 팩수가 충족이 안된경우 //20181001 김기엽
					//	if($bf_cnt > $af_cnt){
					//		if($recom_week_day_count == 7 && $recom_delivery_sun_type){
					//			if($recom_delivery_sun_type == date("w",$deliv_date_time) or ($recom_delivery_sun_type-($recom_delivery_sun_type - date("w",$deliv_date_time)) == date("w",strtotime($fl['recom_date']))) ){
					//				$row[] = $fl;
					//				$af_cnt++;
					//			}
					//		}
					//	}
					//}

					//그래도 팩수가 넘쳐나는 애들은
					if($bf_cnt > $af_cnt){
						for($ii=$af_cnt;$ii<$bf_cnt;$ii++){
							foreach($food_list as $fl){
								if($bf_cnt > $af_cnt){
									$row[] = $fl;
									$af_cnt++;
								}
							}
						}
					}

					//식단부터 넣어주기
					$insert_data['trade_code'] = $trade_code;
					$insert_data['deliv_code'] = $update_deliv_code;
					$insert_data['deliv_date'] = $update_deliv_date;
					$insert_data['recom_idx'] = $recom_idx;
					$insert_data['prod_cnt'] = '1';
					$insert_data['recom_is'] = 'Y';
					foreach($row as $r){	//배송식단 DB에 우선 잡아여
						$insert_data['goods_idx'] = $r['goods_idx'];
						$insert_data['cate_no'] = $r['cate_no'];
						$insert_data['wdate'] = timenow();

						$this->common_m->insert2("dh_trade_deliv_prod",$insert_data);
					}

					//기존 배송식단 지움
					$this->common_m->self_q("delete from dh_trade_deliv_prod where deliv_code = '{$deliv_code}' and recom_is = 'Y'","delete");
					$this->common_m->self_q("update dh_trade_deliv_prod set deliv_code = '{$update_deliv_code}', deliv_date = '{$update_deliv_date}' where deliv_code = '{$deliv_code}'","update");

					//변경되는 배송건의 정보
					$delivinfo_row_prodname = $row->prod_name;

					//같은 deliv_code 가 있는경우는 삭제 아니면 업데이트
					$drowcnt = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '{$update_deliv_code}'","cnt");

					if($drowcnt){
						$result = $this->common_m->self_q(" update dh_trade_deliv_info set prod_name = CONCAT('".$delivinfo_row_prodname.", ',prod_name), recom_idx = '{$recom_idx}' where deliv_code = '{$update_deliv_code}' ","update");
						if($result){
							$result = $this->common_m->self_q("delete from dh_trade_deliv_info where deliv_code = '{$deliv_code}'","delete");
						}
					}
					else{
						$result = $this->common_m->self_q("update dh_trade_deliv_info set deliv_code = '{$update_deliv_code}', deliv_date = '{$update_deliv_date}' where deliv_code = '{$deliv_code}'","update");
					}

					//배송일 변경시 배송코드 기타로 변경
					//$this->common_m->self_q("update dh_trade_deliv_info set order_type = '999999' where deliv_code = '{$update_deliv_code}'","update");

					//$result = $this->common_m->self_q("update dh_trade_deliv_info set deliv_code = '{$update_deliv_code}', deliv_date = '{$update_deliv_date}' where deliv_code = '{$deliv_code}'","update");
					if($result){
						//로그 기록
						$log_type = "배송일 변경";
						$log_msg = "기존 배송일 {$sel_date} 에서 {$deliv_date}로 배송일 변경";
						$writer = "관리자(".$this->session->userdata('ADMIN_USERID').")";
						$result6 = $this->common_m->write_log($data['row']->userid, $log_type, $log_msg, $update_deliv_code, timenow(), $writer);
						if($result6){
							if($this->input->get('view') == "ok"){
								?>
								<script type="text/javascript">
								alert("배송일 변경이 완료 되었습니다.");
								opener.location.href="/html/order/delivery/m/view/<?=$update_deliv_code?>";
								self.close();
								</script>
								<?php
							}
							else{
								?>
								<script type="text/javascript">
								alert("배송일 변경이 완료 되었습니다.");
								opener.location.reload();
								self.close();
								</script>
								<?php
							}
						}
					}

				}
				else{	//일반 배송인 경우

					if($sel_date != $deliv_date){

						//일반 배송 추천식단 아닌경우 배송코드 변경 / 로그의 배송코드 변경 / 로그 기록 / 배송상품 DB 배송코드 업데이트 / 배송DB 업데이트
						list($trade_code_tmp, $deliv_time) = explode("-",$deliv_code);
						list($trade_code, $nodmlal) = explode("_",$trade_code_tmp);
						$deliv_date_time = strtotime($deliv_date);
						$update_deliv_code = $trade_code . "_" . $nodmlal . "-" . $deliv_date_time;

						//로그가 기록되어있을지도 모르니, 로그 업데이트 먼저
						$result = $this->common_m->self_q("update dh_trade_deliv_log set deliv_code = '{$update_deliv_code}' where deliv_code = '{$deliv_code}'","update");

						if($result){	//로그 업데이트 후 로그 기록
							$log_type = "배송일 변경";
							$log_msg = "기존 배송일 {$sel_date} 에서 {$deliv_date}로 배송일 변경";
							$writer = "관리자(".$this->session->userdata('ADMIN_USERID').")";
							$result = $this->common_m->write_log($row->userid, $log_type, $log_msg, $update_deliv_code, timenow(), $writer);

							if($result){
								$result = $this->common_m->self_q("update dh_trade_deliv_prod set deliv_code = '{$update_deliv_code}' where deliv_code = '{$deliv_code}'","update");
								if($result){
									$result = $this->common_m->self_q("update dh_trade_deliv_info set deliv_code = '{$update_deliv_code}', deliv_date = '{$deliv_date}' where deliv_code = '{$deliv_code}'","update");
									if($result){
										script_exe("alert('배송일이 변경 되었습니다.');opener.location.reload();self.close();");
									}
								}
							}
						}

					}
					else{
						script_exe("alert('배송일자가 동일한 경우 수정을 할 필요가 없습니다.');self.close();");
					}

				}

			}

			//배송일에 다른 배송건 있는지 확인
			$data['dup_cnt'] = $dup_cnt = $this->common_m->self_q("select * from dh_trade_deliv_info where userid='".$row->userid."' and deliv_stat=0 and deliv_date='".$row->deliv_date."' and recom_idx=0 and trade_code != '{$trade_code}'","cnt");
			if($dup_cnt){
				$data['dup_list'] = $this->common_m->self_q("select * from dh_trade_deliv_info where userid='".$row->userid."' and deliv_stat=0 and deliv_date='".$row->deliv_date."' and recom_idx=0","result");
			}

			$this->load->view("/dhadm/order/deliv_date_update",$data);
		}
		else if($mode == "deliv_pause"){	//배송 일시정지

			if($_POST){

				$deliv_code = $this->input->post('deliv_code');
				$recom_week_type = $this->input->post('recom_week_type');
				$recom_week_count = $this->input->post('recom_week_count');
				$thiscount = $this->input->post('thiscount');
				$remain_pack_ea = $this->input->post('remain_pack_ea');

				$info_row = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '{$deliv_code}'","row");

				list($trade_code,$deliv_time) = explode("-",$deliv_code);
				$arr_week_type = explode(":",$recom_week_type);
				$total_deliv_count = $arr_week_type[0] * $recom_week_count;
				$remain_deliv_count = $total_deliv_count - ($thiscount-1);

				$where['trade_code'] = $trade_code;

				$update['trade_stat'] = "31";
				$update['remain_deliv_count'] = $remain_deliv_count;
				$update['remain_pack_ea'] = $remain_pack_ea;
				$update['pause_date'] = timenow();

				$result = $this->common_m->update2("dh_trade",$update,$where);
				if($result){
					//$result = $this->common_m->self_q("update dh_trade_deliv_info set deliv_stat = '31' where trade_code = '{$trade_code}' and deliv_code >= '{$deliv_code}'","update");
					$result = $this->common_m->self_q("delete from dh_trade_deliv_info where trade_code = '{$trade_code}' and deliv_code >= '{$deliv_code}'","delete");
					if($result){
						$result = $this->common_m->self_q("delete from dh_trade_deliv_prod where trade_code = '{$trade_code}' and deliv_code >= '{$deliv_code}'","delete");
						if($result){
							//로그 기록
							$now_date = date("Y-m-d");
							$log_text = $now_date."(".numberToWeekname($now_date).") 배송 일시정지 되었습니다.";
							$result6 = $this->common_m->insert_log($info_row->userid,timenow(),'배송일시정지',$log_text,$deliv_code,'관리자('.$this->session->userdata("ADMIN_USERID").')');
							if($result6){
							?>
							<script type="text/javascript">
							alert("배송 일시정지가 정상 처리 되었습니다.");
							opener.location.reload();
							self.close();
							</script>
							<?php
							}
						}
					}
				}

			}
			else{
				$deliv_code = urldecode($this->input->get('deliv_code'));

				list($trade_code,$deliv_time) = explode("-",$deliv_code);

				$data['trade_info'] = $this->common_m->self_q("select * from dh_trade where trade_code = '{$trade_code}'","row");
				$arr_deliv_date = array();
				$arr_deliv_date_to_count = array();
				$recom_dates = explode("^",substr($data['trade_info']->recom_dates,0,-1));
				foreach($recom_dates as $key=>$rd){
					$arr_deliv_date_to_count[$rd] = $key+1;
				}
				$data['deliv_date'] = date("Y-m-d",$deliv_time);
				$data['arr_deliv_date_to_count'] = $arr_deliv_date_to_count;
				$data['deliv_code'] = $deliv_code;
				$remain_pack = $this->common_m->self_q("select sum(prod_cnt) as remain_pack from dh_trade_deliv_prod where deliv_code >= '{$deliv_code}'","row");
				$data['remain_pack_ea'] = $remain_pack->remain_pack;

				//배송일에 다른 배송건 있는지 확인
				$data['dup_cnt'] = $dup_cnt = $this->common_m->self_q("select * from dh_trade_deliv_info where userid='".$data['trade_info']->userid."' and deliv_stat=0 and deliv_date='".$data['deliv_date']."' and recom_idx=0","cnt");
				if($dup_cnt){
					$data['dup_list'] = $this->common_m->self_q("select * from dh_trade_deliv_info where userid='".$data['trade_info']->userid."' and deliv_stat=0 and deliv_date='".$data['deliv_date']."' and recom_idx=0","result");
				}

				$this->load->view("/dhadm/order/deliv_pause",$data);
			}


		}
		else if($mode == "today_deliv_stat_ready"){	//배송당일 배송대기에서 배송준비로 일괄 변경
			$date = $this->uri->segment(5);

			$sql = "update dh_trade_deliv_info set deliv_stat = 1 where deliv_date = '{$date}' and deliv_stat = '0'";
			$result = $this->common_m->self_q($sql,"update");
			if($result){
				alert($_SERVER['HTTP_REFERER'],"변경 되었습니다.");
			}

		}
		else if($mode == "invoice_reset"){	//운송장정보 삭제

			$idx = $this->uri->segment(5,'');
			if($idx){
				//echo $idx;
				$update['invoice_no'] = "";
				$update['invoice_company'] = "";
				$update['invoice_log'] = "";
				$where['idx'] = $idx;
				$result = $this->common_m->update2("dh_trade_deliv_info",$update,$where);
				if($result){
					alert($_SERVER['HTTP_REFERER']);
				}
			}

		}
		else{	//통합배송 리스트

			if($_POST){

				//pr($_POST);
				//exit;

				$deliv_email = $this->input->post('deliv_email');
				$deliv_sms = $this->input->post('deliv_sms');
				$auto_invoice = $this->input->post('auto_invoice');
				$change_stat = $this->input->post('change_stat');
				$check_arr = $this->input->post('check');

				$epost = array();
				foreach($check_arr as $ca){

					$add_update_sql = "";
					list($trade_code_tmp, $deliv_time) = explode("-",$ca);
					list($trade_code, $order_cnt) = explode("_",$trade_code_tmp);
					//우체국 송장번호 체크시 자동 업데이트 로직 생성
					//송장번호 업데이트 시 stat 값도 같이 update 하도록
					if($auto_invoice == '1'){
						$api_result = $this->order_m->Epost_deliv_Api($ca);
						//pr($api_result);
						//echo $api_result."<BR>";
						//pr($api_result);
						//API 요청일시 : 2018-04-30 15:47:26 201804306071404944 - 2018043050982536 - 6864017497500 - 20180430154725

						$invoice_log = "API 요청일시 : " . date("Y-m-d H:i:s");

						if($api_result['error_code'] and $api_result['error_message']){
							$invoice_log .= " ".$api_result['error_code'] . ":" . $api_result['error_message'];
						}
						else{
							/*
							// 우체국택배신청번호(건당부여)
							$result['req_no'] = trim((string)$xml->reqNo);
							// 예약번호(일자당 부여)
							$result['res_no'] = trim((string)$xml->resNo);
							// 운송장번호
							$result['regi_no'] = trim((string)$xml->regiNo);
							// 예약일시
							$result['res_date'] = trim((string)$xml->resDate);
							// 접수우체국
							$result['regi_ponm'] = trim((string)$xml->regiPoNm);
							// 가상전화 번호
							$result['v_telno'] = trim((string)$xml->vTelNo);
							// 도착집중국명
							$result['arr_cnponm'] = trim((string)$xml->arrCnpoNm);
							// 배달우체국명
							$result['deliv_ponm'] = trim((string)$xml->delivPoNm);
							// 배달구구분코드
							$result['deliv_areacd'] = trim((string)$xml->delivAreaCd);
							*/
							$invoice_log .= " req_no : " . $api_result['req_no'] . "^^res_no : " . $api_result['res_no'] . "^^regi_no : " . $api_result['regi_no'] . "^^res_date : " . $api_result['res_date']."^^regi_ponm : ".$api_result['regi_ponm']."^^v_telno : ".$api_result['v_telno']."^^arr_cnponm : ".$api_result['arr_cnponm']."^^deliv_ponm : ".$api_result['deliv_ponm']."^^deliv_areacd : ".$api_result['deliv_areacd'];
						}


						$add_update_sql .= ", invoice_no = '{$api_result['regi_no']}'
							, invoice_log = '{$invoice_log}'
							, invoice_date = now()
							, regiPoNm = '{$api_result['regi_ponm']}'
							, vTelNo = '{$api_result['v_telno']}'
							, arrCnpoNm = '{$api_result['arr_cnponm']}'
							, delivPoNm = '{$api_result['deliv_ponm']}'
							, delivAreaCd = '{$api_result['deliv_areacd']}'
						";
					}

					//stat update
					$result = $this->common_m->self_q("update dh_trade_deliv_info set deliv_stat = '{$change_stat}', udate = now() {$add_update_sql} where deliv_code = '{$ca}'","update");

					//로그 기록
					$deliv_stat_arr = array('0'=>'배송대기','1'=>'배송준비중','2'=>'배송중','3'=>'배송완료','4'=>'배송중지','5'=>'배송취소','6'=>'휴일정지','7'=>'조기마감');
					$log_type = "배송상태변경";
					$log_msg = "배송상태 ".$deliv_stat_arr[$change_stat]."로 변경";
					$writer = $this->session->userdata('ADMIN_USERID')."(".$this->session->userdata('ADMIN_NAME').")";
					$this->common_m->write_log($this->session->userdata('ADMIN_USERID'), $log_type, $log_msg, $ca, timenow(), $writer);

					if($result){

						//알림톡 발송시 분기 있음 , 일반 배송시, 정기배송 마지막 배송시 //
						$deliv_info = $this->common_m->self_q("select *,(select idx from dh_trade where trade_code = dh_trade_deliv_info.trade_code) as trade_idx from dh_trade_deliv_info where deliv_code = '{$ca}'","row");

						//메일 발송 체크시 메일 발송
						if($this->input->post('deliv_email') == '1'){
							$mail_data['trade_idx'] = $deliv_info->trade_idx;
							$mail_data['delivery_idx'] = 1;
							$mail_data['delivery_no'] = $deliv_info->invoice_no;
							$result = $this->common_m->mailform(4,$mail_data);
						}

						//SMS 발송 체크시 SMS 발송
						//sms 알림톡으로 대체함
						if($this->input->post('deliv_sms') == '1'){
							//$sms_data['deliv_code'] = $ca;
							//$result = $this->common_m->icode_sms("sms2",$sms_data);

							//알림톡 발송 배송시 알림톡 > 5361 | 정기배송 마지막시 알림톡 > 5364

							//정기배송 마지막 알림톡은 추후 작업

							if($deliv_info->recom_idx){	//정기배송시
								$sql = "select * from dh_trade_deliv_info where trade_code = '".$deliv_info->trade_code."' and deliv_stat in (0,4,6)";
								$left_deliv_cnt = $this->common_m->self_q($sql,"cnt");

								$token = $this->kkoat_m->token_generation();

								$phone = $deliv_info->recv_phone;
								$name = $deliv_info->order_name;
								$add1 = $deliv_info->invoice_company;
								$add2 = $deliv_info->invoice_no;

								$msg = "{$name}님,\r\n익일 배송예정 운송장 정보입\r\n니다  :)\r\n\r\n택배 : {$add1}\r\n운송장번호 : {$add2}\r\n\r\n택배기사님도 힘내서\r\n우리아가집에 무사히\r\n잘 도착하길!";
								$tmpcode = "M_01459_170";
								$this->kkoat_m->ent_prise_kakao_send($token,$phone,$msg,$tmpcode);

								if($left_deliv_cnt){	//마지막 배송시 알림톡 2개 보내는걸로 수정

								}
								else{	//마지막 배송
									$token = $this->kkoat_m->token_generation();

									$phone = $deliv_info->recv_phone;
									$name = $deliv_info->order_name;
									$add1 = $deliv_info->trade_code;

									$msg = "{$name}님,\r\n정기배송 마지막 주문이\r\n곧 배송완료예정으로\r\n주문번호 : {$add1}는\r\n주문완료 처리 되었습니다.\r\n\r\n아가의 다음 식사를\r\n미리 준비할 시간입니다.\r\n\r\n산골도, 우리맘님도\r\n모두 아자잣!\r\n\r\n에코맘의 산골이유식";
									$tmpcode = "M_01459_50";
									$this->kkoat_m->ent_prise_kakao_send($token,$phone,$msg,$tmpcode);
								}
							}
							else{
								$token = $this->kkoat_m->token_generation();

								$phone = $deliv_info->recv_phone;
								$name = $deliv_info->order_name;
								$add1 = $deliv_info->invoice_company;
								$add2 = $deliv_info->invoice_no;

								$msg = "{$name}님,\r\n익일 배송예정 운송장 정보입\r\n니다  :)\r\n\r\n택배 : {$add1}\r\n운송장번호 : {$add2}\r\n\r\n택배기사님도 힘내서\r\n우리아가집에 무사히\r\n잘 도착하길!";
								$tmpcode = "M_01459_170";
								$this->kkoat_m->ent_prise_kakao_send($token,$phone,$msg,$tmpcode);
							}

						}
					}

					if($change_stat == "3"){
						$sql = "
							select a.trade_code, a.deliv_code, a.userid, a.deliv_stat,
							b.first_order, b.total_price, b.sample_is, b.save_point
							from dh_trade_deliv_info a left join dh_trade b on a.trade_code = b.trade_code
							where deliv_code = '".$ca."'
						";
						$row = $this->common_m->self_q($sql,"row");	//배송정보 검색

						//해당 주문건으로 포인트가 적립 되었는지 확인;
						$deliv_code_arr = deliv_code_arr($ca);
						$trade_code = $deliv_code_arr['trade_code'];

						$reward_sql = "select * from dh_point where trade_code = '{$trade_code}' and point > 0";
						$reward_cnt = $this->common_m->self_q($reward_sql,"cnt");

						$deliv_cnt = $this->common_m->self_q("select * from dh_trade_deliv_info where trade_code = '".$row->trade_code."' and deliv_stat < 3","cnt");	//같은 주문의 배송완료 여부 파악

						if($deliv_cnt > 0){	//같은 주문에 배송이 하나라도 남은경우 빠염
							continue;
						}
						else{	//배송이 전부 완료된경우
							$result = $this->common_m->self_q("update dh_trade set trade_stat = 4 where trade_code = '".$row->trade_code."'","update");	//거래정보 판매완료로 업데이트
							if($result and $reward_cnt <= 0){
								$member_info = $this->common_m->self_q("select *,(select reward from dh_member_level where level = dh_member.level) as reward from dh_member where userid = '".$row->userid."'","row");	//회원정보 불러옴
								$first_and_recom = false;
								//첫주문 여부 분기점
								if($row->first_order == "Y"){	//첫주문
									if($member_info->recomid){
										$first_and_recom = true;
									}
								}

								if($first_and_recom){	//추천인이 있는경우
									$point = $row->total_price * 0.1;

									//추천인과 본인 동시 지급
									$insert1['userid'] = $row->userid;
									$insert1['point'] = round($point);	//소숫점 버림
									$insert1['content'] = "첫주문 (주문번호:".$row->trade_code.") 추천인 포함 10% 적립";
									$insert1['flag'] = "trade";
									$insert1['trade_code'] = $row->trade_code;
									$insert1['reg_date'] = timenow();

									if($point > 0){
										$result = $this->common_m->insert2("dh_point",$insert1);
										//echo "첫주문 추천인 :dh_point ".$point." 입력:".$result."<BR>";
									}

									if($result){	//추천인 포인트 지급	추천인이 회원탈퇴를 했는지 여부는 안따짐

										$insert1['userid'] = $member_info->recomid;
										$insert1['point'] = round($point);	//소숫점 버림
										$insert1['content'] = $member_info->name."님께서 추천후 첫구매 완료 (10% 적립)";
										$insert1['flag'] = "recom";
										$insert1['reg_date'] = timenow();

										if($point > 0){
											$result = $this->common_m->insert2("dh_point",$insert1);
											//echo "첫주문 추천인에게 :dh_point ".$point." 입력:".$result."<BR>";
										}

									}
								}
								else{	//추천인이 없는 경우
									$point = $row->total_price * $member_info->reward * 0.01;

									$insert1['userid'] = $row->userid;
									$insert1['point'] = round($point);	//소숫점 버림
									$insert1['content'] = "거래완료 [".$row->trade_code."]";
									$insert1['flag'] = "trade";
									$insert1['trade_code'] = $row->trade_code;
									$insert1['reg_date'] = timenow();

									if($point > 0){
										$result = $this->common_m->insert2("dh_point",$insert1);
										//echo "첫주문 아닌거 :dh_point ".$point." 입력:".$result."<BR>";
									}
								}

								//포인트 입력후 회원 등급 조정
								if($result){

									$level_info = $this->common_m->self_q("select * from dh_member_level order by level desc","result");	//회원레벨 정보
									$level_up_price = array();
									foreach($level_info as $li){
										$level_up_price[$li->level] = $li->level_up_price;
									}

									if($member_info->level < 3){
										$total_payment = $this->common_m->self_q("select sum(total_price) as tp from dh_trade where userid = '".$row->userid."' and trade_stat = '4'","row");

										foreach($level_up_price as $level => $levup_price){
											if($total_payment->tp > $levup_price){
												$lev = $level;
												break;
											}
										}

										if($lev != $member_info->level){

											$result = $this->common_m->self_q("update dh_member set level = '{$lev}' where userid = '".$row->userid."'","update");

											//회원 등업시 쿠폰 자동지급
											if($lev==2){
												$coupon_row = $this->common_m->self_q("select * from dh_coupon where code = '1809UKCTDCX4'","row");
											}
											else if($lev==3){
												$coupon_row = $this->common_m->self_q("select * from dh_coupon where code = '1809ETYLXPW6'","row");
											}

											$userid = $row->userid;
											$coupon_use_cnt = $this->common_m->self_q("select * from dh_coupon_use where code = '".$coupon_row->code."' and userid = '{$userid}'","cnt");
											if($coupon_use_cnt <= 0){
												$cpin['userid'] = $userid;
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

											if($result){

												$lev_chg['userid'] = $dl->userid;
												$lev_chg['before_level'] = $member_info->level ? $member_info->level : "" ;
												$lev_chg['after_level'] = $lev;
												$lev_chg['info'] = "거래 완료처리시 레벨 업";
												$lev_chg['wdate'] = timenow();

												$result = $this->common_m->insert2("dh_member_level_change",$lev_chg);

											}

										}

									}
									else{
										$result = "1";
									}
								}
							}
						}


					}
					else{
						//주문내역 배송중이 아니라면 배송중으로 업데이트
						$trade_row = $this->common_m->self_q("select * from dh_trade where trade_code = '{$trade_code}'","row");
						if($trade_row->trade_stat < 3){
							$result = $this->common_m->self_q("update dh_trade set trade_stat = '3' where trade_code = '{$trade_code}'","update");
						}
					}

				}

				if($result){
					alert($_SERVER['HTTP_REFERER']);
				}

			}

			$data['deliv_stat_arr'] = $deliv_stat_arr = array(
				'0'=>'배송대기',
				'1'=>'배송준비중',
				'2'=>'배송중',
				'3'=>'배송완료',
				'4'=>'중지',
				'5'=>'취소',
				'6'=>'휴일정지','7'=>'조기마감'
			);

			$where_query = "";
			$data['query_string'] = "?";

			//검색 시작
				if($this->input->get('sch_sdate') && $this->input->get('sch_edate')){	//배송일자
					$where_query .= " and a.deliv_date between '".$this->input->get('sch_sdate')."' and '".$this->input->get('sch_edate')."'";
					$data['query_string'] .= "&sch_sdate=".$this->input->get('sch_sdate')."&sch_edate=".$this->input->get('sch_edate');
				}

				if($this->input->get('sch_item_val')){	//회원정보 검색
					$data['query_string'] .= "&sch_item_val=".$this->input->get('sch_item_val')."&sch_item=".$this->input->get('sch_item');
					if(strpos($this->input->get('sch_item'),"phone") !== false){
						$sch_item_db = "replace(a.".$this->input->get('sch_item').",'-','')";
						$sch_item_val_db = str_replace("-","",$this->input->get('sch_item_val'));
					}
					else{
						$sch_item_db = "a.".$this->input->get('sch_item');
						$sch_item_val_db = $this->input->get('sch_item_val');
					}

					if($this->input->get('sch_item') == "userid"){
						$where_query .= " and {$sch_item_db} = '{$sch_item_val_db}'";
					}
					else{
						$where_query .= " and {$sch_item_db} like '%{$sch_item_val_db}%'";
					}
				}

				if($this->input->get('sch_deliv_stat') != ""){	//배송상태
					$data['query_string'] .= "&sch_deliv_stat=".$this->input->get('sch_deliv_stat');
					$where_query .= " and a.deliv_stat = '".$this->input->get('sch_deliv_stat')."'";
				}

				if($this->input->get('sch_trade_stat')){	//주문상태
					$data['query_string'] .= "&sch_trade_stat=".$this->input->get('sch_trade_stat');
					$where_query .= " and b.trade_stat = '".$this->input->get('sch_trade_stat')."'";
				}

				if($this->input->get('sch_other')){	//기타검색
					$data['query_string'] .= "&sch_other=".$this->input->get('sch_other');

					if($this->input->get('sch_other') == 'overlap'){	//중복주문확인

					}
					else{
						switch($this->input->get('sch_other')){
							case "invoice":
								$where_query .= " and a.invoice_no <> ''";
							break;
							case "no_invoice":
								$where_query .= " and a.invoice_no = ''";
							break;
						}
					}
				}


				//주문 타입별 검색
				$recom_arr = array('1'=>'2','2'=>'4','3'=>'5','4'=>'6','5'=>'1','6'=>'7','7'=>'3');	//추천식단 2차 카테고리 검색값 => DB 값 배열
				$free_arr = array('1'=>'1-6','2'=>'1-7','3'=>'1-8','4'=>'1-9','5'=>'1-10','6'=>'1-11','7'=>'2-12','8'=>'2-13');	//골라담기 2차 카테고리 검색값 => DB 값 배열
				$dis_sam_arr = array('1'=>'초기','2'=>'중기','3'=>'후기','4'=>'완료기');

				if($this->input->get('order_type')) $data['query_string'] .= "&order_type=".$this->input->get('order_type');	//주문선택 값이 있을경우 파라미터 추가

				if($this->input->get('order_type') == "recom"){	//정기배송
					if($this->input->get('order_type21')){	//2차 카테고리 값이 있을경우
						$data['query_string'] .= "&order_type21=".$this->input->get('order_type21');
						$where_query .= " and '".$recom_arr[$this->input->get('order_type21')]."' in (select recom_idx from dh_trade_deliv_prod where trade_code = a.trade_code and deliv_date = '".$this->input->get('sch_sdate')."')";
					}
					else{
						$where_query .= " and b.recom_is = 'Y'";
					}
				}
				else if($this->input->get('order_type') == "free"){	//자유배송
					if($this->input->get('order_type22')){	//2차 카테고리 값이 있을경우
						$data['query_string'] .= "&order_type22=".$this->input->get('order_type22');
						$where_query .= " and ('".$free_arr[$this->input->get('order_type22')]."') in (select cate_no from dh_trade_deliv_prod where trade_code = a.trade_code and recom_is != 'Y' and deliv_date = '".$this->input->get('sch_sdate')."')";
					}
					else{
						$where_query .= " and a.deliv_code in (select distinct deliv_code from dh_trade_deliv_prod where trade_code = a.trade_code and recom_is != 'Y' and deliv_date = '".$this->input->get('sch_sdate')."' and cate_no < '3')";
					}
				}
				else if($this->input->get('order_type') == "gansik"){	//간식
					$where_query .= " and (select cate_no from dh_trade_deliv_prod where trade_code = a.trade_code and recom_is != 'Y' order by a.deliv_code asc limit 1) = '3'";
				}
				else if($this->input->get('order_type') == "health"){	//건강식품
					$where_query .= " and (select cate_no from dh_trade_deliv_prod where trade_code = a.trade_code and recom_is != 'Y' order by a.deliv_code asc limit 1) = '4'";
				}
				else if($this->input->get('order_type') == "farm"){	//산골농부
					$where_query .= " and (select cate_no from dh_trade_deliv_prod where trade_code = a.trade_code and recom_is != 'Y' order by a.deliv_code asc limit 1) = '5'";
				}
				else if($this->input->get('order_type') == "discount"){	//특가상품
					if($this->input->get('order_type23')){
						$data['query_string'] .= "&order_type23=".$this->input->get('order_type23');
						$where_query .= " and (select goods_name from dh_trade_goods where trade_code = a.trade_code and cate_no = '6' limit 1) like '%".$dis_sam_arr[$this->input->get('order_type23')]."%'";
					}
					else{
						$where_query .= " and (select cate_no from dh_trade_deliv_prod where trade_code = a.trade_code and recom_is != 'Y' order by a.deliv_code asc limit 1) = '6'";
					}
				}
				else if($this->input->get('order_type') == "sample"){	//샘플
					if($this->input->get('order_type24')){
						$data['query_string'] .= "&order_type24=".$this->input->get('order_type24');
						$where_query .= " and (select goods_name from dh_trade_goods where trade_code = a.trade_code and cate_no = '7' limit 1) like '%".$dis_sam_arr[$this->input->get('order_type24')]."%'";
					}
					else{
						$where_query .= " and b.sample_is = 'Y'";
					}
				}

				if($this->input->get('search_goods')){	//상품명을 입력받을경우
					$data['query_string'] .= "&search_goods=".$this->input->get('search_goods');
					$where_query .= " and ".$this->input->get('search_goods')." in (select goods_idx from dh_trade_deliv_prod where deliv_code = a.deliv_code)";
				}
			//검색 종료

			if($this->session->userdata('ADMIN_USERID') == "dhadmin"){
				//echo $where_query;
			}

			if($_GET){

				$main_sql = "select distinct a.deliv_code, a.* ";
				$main_sql.= ", b.trade_stat, b.first_order, b.mobile, b.trade_day, b.total_price, b.trade_method, b.send_text, b.idx as tidx, b.memo ";
				$main_sql.= ", (select count(idx) from dh_trade_deliv_log where deliv_code = a.deliv_code) as log_count ";
				$main_sql.= ", (select idx from dh_member where userid = a.userid) as useridx ";
				//$main_sql.= ", (select distinct recom_idx from dh_trade_deliv_prod where deliv_code = a.deliv_code and recom_is = 'Y' order by recom_idx limit 1) as recom_is ";
				$main_sql.= "from dh_trade_deliv_info a left join dh_trade b on a.trade_code = b.trade_code ";
				$main_sql.= "where b.trade_stat in (2,3,31) ";
				$main_sql.= $where_query;

				/*
				$main_sql.= ", (select count(idx) from dh_trade_deliv_log where deliv_code = a.deliv_code) as log_count"
				$main_sql.= ", (select idx from dh_member where userid = a.userid) as useridx"
				$main_sql.= ", (select distinct recom_idx from dh_trade_deliv_prod where deliv_code = a.deliv_code and recom_is = 'Y' order by recom_idx limit 1) as recom_is"
				$main_sql.= "from dh_trade_deliv_info a, dh_trade b"
				$main_sql.= "where a.trade_code = b.trade_code"
				$main_sql.= "and b.trade_stat between 2 and 3"

				$main_sql.= "{$where_query}";
				*/


				//echo $main_sql;

				//$main_sql = "select a.*,b.total_price, b.trade_method, b.recom_is, b.sample_is, b.first_order from dh_trade_deliv_info where deliv_stat < 3";

				//echo nl2br($main_sql);

				// 페이징 start */
				$url = cdir()."/";
				$url .= ($this->uri->segment(1))?$this->uri->segment(1)."/":"";
				$url .= ($this->uri->segment(2) and $this->uri->segment(2)!="m")?$this->uri->segment(2)."/":"";
				$url .= ($this->uri->segment(3) and $this->uri->segment(3)!="m")?$this->uri->segment(3)."/":"";
				$url .= ($this->uri->segment(4) and $this->uri->segment(4)!="m")?$this->uri->segment(4)."/":"";
				$url .= "m";

				$PageNumber = $this->input->get("PageNumber"); //현재 페이지
				if(!$PageNumber){ $PageNumber = 1; }
				$list_num='50'; //페이지 목록개수
				$page_num='5'; //페이징 개수
				$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)

				$cnt_sql = "select distinct a.deliv_code from dh_trade_deliv_info a left join dh_trade b on a.trade_code = b.trade_code where b.trade_stat in (2,3,31) {$where_query}";

				$data['totalCnt'] = $data['total'] = $this->common_m->self_q($cnt_sql,"cnt");
				$data['Page'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
				// 페이징 end */

				if($this->input->get('excel') == "ok"){
					$main_sql .= " order by b.trade_day desc, a.deliv_date desc";

					$data['shop_info'] = $this->admin_m->shop_info(); //shop 정보

					//엑셀에서 골라담기 제품명 가져오기 너무 힘듬
					/*
					$goods_name_arr = array();

					$goods_name_sql = "select *,(select name from dh_goods where idx = dh_trade_deliv_prod.goods_idx) as gname from dh_trade_deliv_prod where deliv_date between '".$this->input->get('sch_sdate')."' and '".$this->input->get('sch_edate')."'";

					if($_SERVER['REMOTE_ADDR'] == "112.221.155.109"){
						echo "[[[[IP Lock on]]]] <br>";
						echo $main_sql."<BR><BR>";
						echo $goods_name_sql;
						exit;
					}

					$goods_name_list = $this->common_m->self_q($goods_name_sql, "result");
					foreach($goods_name_list as $gnl){
						$goods_name_arr[$gnl->deliv_code][] = $gnl->gname;
					}
					$data['goods_name_arr'] = $goods_name_arr;
					*/

				}
				else{
					$main_sql .= " order by b.trade_day desc, a.deliv_date desc";
					$main_sql .= " limit {$offset}, {$list_num}";
				}

				/*
				if($_SERVER['REMOTE_ADDR'] == "112.221.155.109"){
					echo "[[[[IP Lock on]]]] <br>";
					echo nl2br($main_sql);
					exit;
				}
				*/

				$recom_row = $this->common_m->self_q("select * from dh_recom_food","result");
				$recom_name_arr = array();
				foreach($recom_row as $rr){
					$recom_name_arr[$rr->idx] = $rr->recom_name;
				}

				$data['recom_name_arr'] = $recom_name_arr;
				$data['list'] = $this->common_m->self_q($main_sql,"result");

			}

			$data['search_goods'] = $this->common_m->self_q("select * from dh_goods order by name asc","result");

			if($this->input->get('excel') == "ok"){
				$this->load->view("/dhadm/excel/delivery",$data);
			}
			else{
				$this->load->view("/dhadm/order/delivery",$data);
			}

		}
	}

	public function delivery_print($data=''){

		if(!$this->input->post("check")){
			?>
			<script type="text/javascript">
			alert("출력할 데이터가 없습니다.");
			self.close();
			</script>
			<?php
		}

		//배송코드 post로 전달받음 // 아마 전송 용량 제한때문에 한번에는 힘들듯 한데
		//선택한 이 아닌 검색된으로 한다면 한번에 가능할지도..
		$deliv_code = $this->input->post("check");

		//날짜 추출
		$date_tmp = explode("-",$deliv_code[0]);
		$data['deliv_date'] = date("Y-m-d",$date_tmp[1]);

		//전송된 배송코드를 토대로 데이터 가져와서 배열화
		$print_row = array();
		$dup_arr = array();

		$dcodes = "";
		foreach($deliv_code as $dc){
			$dcodes .= ( ($dcodes) ? "," : "" ) . "'".$dc."'";
		}

		$sql = "
			select distinct
				a.*, sum(a.prod_cnt) as sum_prod_cnt,
				b.name as goods_name, b.cate_no,
				c.prod_name, c.order_name, c.order_phone, c.recv_name, c.recv_phone, c.zipcode, c.addr1, c.addr2, c.userid, c.invoice_no,
				d.regist_type,
				e.name as level_name,
				f.mobile, f.trade_day, f.send_text, f.first_order,
				g.title as cate_name,
				h.recom_week_count, h.recom_week_day_count, h.recom_week_type, h.recom_dates
				,(select count(idx) from dh_trade_goods where trade_code = a.trade_code and cate_no = 'recom') as multi_order_recom
			from dh_trade_deliv_prod a
				left join dh_goods b on a.goods_idx = b.idx
				left join dh_trade_deliv_info c on a.deliv_code = c.deliv_code
				left join dh_member d on c.userid = d.userid
				left join dh_member_level e on d.level = e.level
				left join dh_trade f on a.trade_code = f.trade_code
				left join dh_trade_goods h on c.tg_idx = h.idx
				left join dh_category g on a.cate_no = g.cate_no
			where a.deliv_code in ({$dcodes}) and (a.prod_cnt > 0 or a.option_cnt > 0)
			group by a.deliv_code, a.goods_idx, a.tg_idx
			order by f.trade_day desc, c.deliv_date desc, a.recom_is desc, d.userid, a.cate_no asc, goods_name asc
		";

		if($_SERVER['HTTP_X_FORWARDED_FOR'] == "58.229.223.174"){
			//echo $sql;
		}

		/*
		if($_SERVER['REMOTE_ADDR'] == "112.221.155.109"){
			$dcodes = "'TPBPJ1552227848_1-1552316400','IJBDH1552227495_1-1552316400','HGDRB1552216216_1-1552316400','BWQCF1552216155_1-1552316400','PFVEF1552211212_1-1552316400','NRTBW1552194025_1-1552316400','TUQRC1552177270_1-1552316400','AWBNM1552173412_1-1552316400','HJCZX1552144993_1-1552316400','LEARB1552122363_1-1552316400','DXOVB1552112863_1-1552316400','LGMIF1552109301_1-1552316400','QBYDJ1552088288_1-1552316400','MXKKX1552086050_1-1552316400','APUII1552084424_1-1552316400','EXQIT1552069473_1-1552316400','EEBHU1552057996_1-1552316400','EOCGF1552056054_1-1552316400','CPMID1552054128_1-1552316400','GVXWM1552053602_1-1552316400','PZEPR1552052745_1-1552316400','NYEFJ1552051639_1-1552316400','IMKKI1552050794_1-1552316400','UQSRC1552049985_1-1552316400','PTBUW1552049850_1-1552316400','GHCMF1552049685_1-1552316400','TEYGE1552047672_1-1552316400','QZGBJ1552046734_1-1552316400','LOLFP1552044939_1-1552316400','UZHFL1552044173_1-1552316400','QWMYG1552041975_1-1552316400','HVYTN1552041938_1-1552316400','SZNDZ1552040995_1-1552316400','HNEUI1552037582_1-1552316400','LKTQB1552036594_1-1552316400','MUDKG1552035306_1-1552316400','YWTEI1552034914_1-1552316400','IWARA1552034416_1-1552316400','ETONI1552034355_1-1552316400','FMZFC1552032711_1-1552316400','GREJH1552031915_1-1552316400','ZLMSS1552031678_1-1552316400','XZRVX1552030168_1-1552316400','TUYFQ1552029452_1-1552316400','AFLYB1552029430_1-1552316400','SJJAT1552028696_1-1552316400','KTYKK1552028195_1-1552316400','UUNUT1552026801_1-1552316400','TAJRN1552024682_1-1552316400','HBJBO1552024306_1-1552316400','KWZWH1552023986_1-1552316400','VEBEQ1552023857_1-1552316400','BCXWE1552023065_1-1552316400','PDNFB1552022694_1-1552316400','SYIGY1552021826_1-1552316400','JAZVD1552021145_1-1552316400','QKAMK1552018537_1-1552316400','EQNRW1552018301_1-1552316400','HIXKB1552018023_1-1552316400','CDGAP1552016376_1-1552316400','BLIDV1552015049_1-1552316400','URDSC1552013902_1-1552316400','HNDQM1552011695_1-1552316400','ONHVA1552011620_1-1552316400','VMMBU1552011447_1-1552316400','MCQGH1552010640_1-1552316400','QTDRH1552009979_1-1552316400','DNCII1552009873_1-1552316400','KXDVB1552007795_1-1552316400','FYCNS1552007493_1-1552316400','TYAPW1552007427_1-1552316400','CWYCL1552007098_1-1552316400','NKCJS1552005759_1-1552316400','KTEXH1552003786_1-1552316400','BVNNC1552003121_1-1552316400','IRJGN1552002512_1-1552316400','YTHZZ1552000653_1-1552316400','HBGZQ1551985304_1-1552316400','YUDIB1551985004_1-1552316400','ALLDA1551980386_1-1552316400','IXDAC1551978858_1-1552316400','KQFQE1551974502_1-1552316400','OAJVV1551973861_1-1552316400','CNWVA1551973677_1-1552316400','TWCNJ1551972630_1-1552316400','QQPSL1551972161_1-1552316400','WYMBU1551970161_1-1552316400','GHOBL1551968826_1-1552316400','ANDUN1551968563_1-1552316400','CFKDB1551967896_1-1552316400','BQSDI1551964839_1-1552316400','TJPDL1551962143_1-1552316400','BCTUT1551956666_1-1552316400','ZLNZP1551956640_1-1552316400','CJPBY1551955907_1-1552316400','KTQQD1551955002_1-1552316400','XWWXN1551954905_1-1552316400','NAPKF1551954771_1-1552316400','SQRVN1551954295_1-1552316400','JANLC1551945906_1-1552316400','FIRRB1551942365_1-1552316400','UHRON1551942288_1-1552316400','FMLMN1551941932_1-1552316400','GMUOH1551941896_1-1552316400','EXTTD1551935132_1-1552316400','JUDQS1551933720_1-1552316400','WJKPE1551931351_1-1552316400','GESOD1551927785_1-1552316400','ZLOOA1551924333_1-1552316400','OQPLY1551909656_1-1552316400','TYZSM1551886001_1-1552316400','QSHZW1551885788_1-1552316400','RHELW1551883561_1-1552316400','JHWMI1551882677_1-1552316400','MJJNN1551873455_1-1552316400','RQPFC1551863049_1-1552316400','TRZJN1551862875_1-1552316400','NFWUP1551861606_1-1552316400','CAUTA1551861584_1-1552316400','CPWLS1551860311_1-1552316400','RUTCA1551859537_1-1552316400','FJDPW1551858128_1-1552316400','SEWEL1551857070_1-1552316400','VWKGZ1551854584_1-1552316400','ISIKJ1551850453_1-1552316400','LAAPS1551844793_1-1552316400','JUWGY1551844521_1-1552316400','FVBFO1551826192_1-1552316400','QUNUP1551802579_1-1552316400','FJEXI1551794932_1-1552316400','JZHLF1551792596_1-1552316400','UEEHC1551780786_1-1552316400','COXHT1551773857_1-1552316400','HHGFI1551765897_1-1552316400','BDOFF1551760941_1-1552316400','VZOLU1551759189_1-1552316400','JLBWN1551754899_1-1552316400','UOZYE1551748837_1-1552316400','TNALA1551721151_1-1552316400','GTVPE1551670254_1-1552316400','TLLGT1551625160_1-1552316400','IZKLT1551561588_1-1552316400','ZFDXZ1551540902_1-1552316400','LPUJO1551417930_1-1552316400','XSTDN1551277036_1-1552316400','YOXLI1551269695_1-1552316400','FDBSK1551199319_1-1552316400','NGYPQ1550993407_1-1552316400','VZXNC1550403882_1-1552316400'";
			$sql = "
				select distinct
					a.*, sum(a.prod_cnt) as sum_prod_cnt,
					b.name as goods_name, b.cate_no,
					c.prod_name, c.order_name, c.order_phone, c.recv_name, c.recv_phone, c.zipcode, c.addr1, c.addr2, c.userid, c.invoice_no,
					d.regist_type,
					e.name as level_name,
					f.mobile, f.trade_day, f.send_text, f.first_order,
					g.title as cate_name,
					h.recom_week_count, h.recom_week_day_count, h.recom_week_type, h.recom_dates
					,(select count(idx) from dh_trade_goods where trade_code = a.trade_code and cate_no = 'recom') as multi_order_recom
				from dh_trade_deliv_prod a
					left join dh_goods b on a.goods_idx = b.idx
					left join dh_trade_deliv_info c on a.deliv_code = c.deliv_code
					left join dh_member d on c.userid = d.userid
					left join dh_member_level e on d.level = e.level
					left join dh_trade f on a.trade_code = f.trade_code
					left join dh_trade_goods h on c.tg_idx = h.idx
					left join dh_category g on a.cate_no = g.cate_no
				where a.deliv_code in ({$dcodes}) and (a.prod_cnt > 0 or a.option_cnt > 0)
				group by a.deliv_code, a.goods_idx, a.tg_idx
				order by f.trade_day desc, c.deliv_date desc, a.recom_is desc, d.userid, a.cate_no asc, goods_name asc
			";
			echo "<pre>{$sql}</pre>";
			exit;
		}
		*/


		$deliv_row = $this->common_m->self_q($sql,"fetch_array");

		$dup_sql = "
			select count(*) as dup_cnt, userid
			from dh_trade_deliv_info
			where deliv_date = '".$data['deliv_date']."' and trade_code in (select trade_code from dh_trade where trade_stat between 2 and 3 and trade_code = dh_trade_deliv_info.trade_code)
			group by userid
		";
		$dup_list = $this->common_m->self_q($dup_sql,"result");

		foreach($dup_list as $dl){
			$dup_arr[$dl->userid] = $dl->dup_cnt;
		}

		//pr($dup_arr);


		$bkcnt = 0;
		foreach($deliv_row as $bk){

			if($old_deliv_code != $bk['deliv_code']){
				$bkcnt = 0;
			}

			//첫배송인지 아닌지 확인하여 첫주문이라도 첫배송이 아니면 첫주문 없앨것.
			$recom_dates_arr = explode("^",$bk['recom_dates']);	//정기배송일자 묶음값 가져와서 배열화
			$first_real = array_search($bk['deliv_date'],$recom_dates_arr);		//배열에서 찾기

			$print_row[$bk['deliv_code']][$bkcnt] = $bk;
			$print_row[$bk['deliv_code']]['userid'] = $bk['userid'];
			$print_row[$bk['deliv_code']]['name'] = $bk['order_name'];
			$print_row[$bk['deliv_code']]['trade_code'] = $bk['trade_code'];
			$print_row[$bk['deliv_code']]['deliv_code'] = $bk['deliv_code'];
			$print_row[$bk['deliv_code']]['recv_name'] = $bk['recv_name'];
			$print_row[$bk['deliv_code']]['recv_phone'] = $bk['recv_phone'];
			$print_row[$bk['deliv_code']]['zipcode'] = $bk['zipcode'];
			$print_row[$bk['deliv_code']]['addr1'] = $bk['addr1'];
			$print_row[$bk['deliv_code']]['addr2'] = $bk['addr2'];
			$print_row[$bk['deliv_code']]['send_text'] = $bk['send_text'];
			$print_row[$bk['deliv_code']]['recom_week_count'] = $bk['recom_week_count'];
			$print_row[$bk['deliv_code']]['recom_week_day_count'] = $bk['recom_week_day_count'];
			$print_row[$bk['deliv_code']]['recom_week_type'] = $bk['recom_week_type'];

			//로직 변경 들어감 2019-02-27
			//멀티 주문의 경우 첫주문의 판단이 어려움이 있음
			//조건1 sns 회원은 안줌
			//조건2 멀티 주문의 경우 정기배송에서 내보내는걸로

			if($bk['regist_type'] != sns){	//회원이 sns 연동이 아니고
				if($bk['multi_order_recom'] <= 0){	//멀티 주문이 아닌경우 ( 장바구니에 다 쌔려넣고 주문한게 아닌경우 )
					if($bk['recom_week_day_count'] && $bk['first_order'] == "Y"){	//주문이 정기배송이고 첫주문인경우
						if($recom_dates_arr[0] == $bk['deliv_date']){	//배송일이 정기배송 첫날인 경우
							$print_row[$bk['deliv_code']]['first_order'] = "Y";
						}
					}

					else if($bk['first_order'] == "Y"){

						foreach($deliv_row as $fsd){
							if($old_dd){
								if($old_dd >= $fsd['deliv_date']){
									$first_deliv = $fsd['deliv_date'];
								}
							}
							else{
								$first_deliv = $fsd['deliv_date'];
							}

							$old_dd = $fsd['deliv_date'];
						}

						if($bk['deliv_date'] == $first_deliv){
							$print_row[$bk['deliv_code']]['first_order'] = "Y";
						}

					}
				}
				else{	//멀티 주문의 경우
					if($bk['recom_week_day_count'] && $bk['first_order'] == "Y"){	//주문이 정기배송이고 첫주문인경우
						if($recom_dates_arr[0] == $bk['deliv_date']){	//배송일이 정기배송 첫날인 경우
							$print_row[$bk['deliv_code']]['first_order'] = "Y";
						}
					}
				}
			}

			if($bk['option_cnt'] > 0){
				//echo "select distinct * from dh_trade_goods_option where level = '2' and trade_goods_idx = '".$bk['tg_idx']."'"."<BR>";
				$option_info = $this->common_m->self_q("select distinct * from dh_trade_goods_option where level = '2' and trade_goods_idx = '".$bk['tg_idx']."'","fetch_array");
				$print_row[$bk['deliv_code']][$bkcnt]['option_info'] = $option_info;
			}

			$bkcnt++;

			$old_deliv_code = $bk['deliv_code'];

		}

		/*
		if($_SERVER['REMOTE_ADDR'] == "112.221.155.109"){
			foreach($print_row as $k=>$v){
				foreach($v as $key=>$val){

					if($old_deliv_code == $k){
						continue;
					}

					if($v['first_order'] == "Y"){
						$deliv_code = $k;
						echo $deliv_code."<BR>";
					}

					$old_deliv_code = $deliv_code;
				}
			}
		}
		*/

		if($_SERVER['HTTP_X_FORWARDED_FOR'] == "58.229.223.174"){
			//pr($print_row);
		}

		$data['list'] = $print_row;
		$data['dup_arr'] = $dup_arr;
		$this->load->view("/dhadm/order/deliv_popup",$data);

	}

	public function solopay($data=''){
		$this->load->view("/dhadm/order/solopay",$data);
	}

	public function sales($data=''){
		$date_mode=$this->input->get('date_mode');
		$excel = $this->input->get('excel');
		if($date_mode=="") $date_mode="day";

		//주문일 기준 검색값 파라미터 설정
		$sch_sdate = $this->input->get('sch_sdate') ? $this->input->get('sch_sdate') : date("Y-m-d", strtotime('-6 days')) ;
		$sch_edate = $this->input->get('sch_edate') ? $this->input->get('sch_edate') : date("Y-m-d") ;

		//		//테스트서버용 파라미터 오픈시 삭제
		//		$sch_sdate = $this->input->get('sch_sdate') ? $this->input->get('sch_sdate') : date("Y-m-d", strtotime('2019-04-07')) ;
		//		$sch_edate = $this->input->get('sch_edate') ? $this->input->get('sch_edate') : date("Y-m-d", strtotime('2019-04-13')) ;
		//		//테스트서버용 파라미터 오픈시 삭제

		//월별 검색 데이터 추출용 연도값
		$data['min_year']=$this->common_m->self_q("SELECT DISTINCT DATE_FORMAT(trade_day, '%Y') AS year FROM dh_trade ORDER BY YEAR ASC LIMIT 1","row");

		$roof_top = array();	//상단 결제 요약정보
		$graph = array();	//그래프 도구
		$table = array();	//표 도구

		//분리하지 않고 바로 실행
		/*
		필요한 데이터
		- 총 결제금액, 총 주문건수, 총 결제완료건, 총 주문취소
		- array :
			$roof_top[total_payment]				총 결제금액
			$roof_top[total_order_cnt]			총 주문건수
			$roof_top[total_order_ok_cnt]		총 결제완료건
			$roof_top[total_order_cc_cnt]		총 주문취소

		- 그래프 일자별 - 총 매출액, 총 취소액
		- array :
			$graph[date][total_payment]				[일자별][총 매출액]
			$graph[date][total_paycancel]			[일자별][총 취소액]

		- 표
		주문일자,주문수,주문합계,무통장 건/금액, 계좌이체 건/금액, 카드입금 건/금액, 휴대폰 건/금액, 포인트입금 건/금액, 쿠폰 건/금액, 가상계좌 건/금액, 주문취소 건/금액
		주문합계,이상동일
		취소합계, 빈값 , 제일끝 취소 합계


		//신용카드 1, 무통장 2, 계좌이체 3, 가상계좌 4, 휴대폰 7
		- array :
			$table[date][total_order_cnt]								[일자][총 주문수]
			$table[date][total_order_price]							[일자][주문합계]
			$table[date][m2_cnt]												[일자][무통장 주문합계]
			$table[date][m2_total]											[일자][무통장 주문액 합계]
			$table[date][m3_cnt]												[일자][계좌이체 주문합계]
			$table[date][m3_total]											[일자][계좌이체 주문액 합계]
			$table[date][m1_cnt]												[일자][신용카드 주문합계]
			$table[date][m1_total]											[일자][신용카드 주문액 합계]
			$table[date][m7_cnt]												[일자][휴대폰결제 주문합계]
			$table[date][m7_total]											[일자][휴대폰결제 주문액 합계]
			$table[date][use_point_cnt]									[일자][포인트입금 주문합계]
			$table[date][use_point_price]								[일자][포인트입금 주문액 합계]
			$table[date][use_coupon_cnt]								[일자][쿠폰 주문합계]
			$table[date][use_coupon_price]							[일자][쿠폰 주문액 합계]
			$table[date][m4_cnt]												[일자][가상계좌 주문합계]
			$table[date][m4_total]											[일자][가상계좌 주문액 합계]
			$table[date][total_order_cc_cnt]						[일자][주문취소 주문합계]
			$table[date][total_order_cc_price]					[일자][주문취소 주문액 합계]
		*/

		if($date_mode == "day"){	//일자별 검색시

			$sdate = new datetime($sch_sdate);
			$edate = new datetime($sch_edate);

			$date_gap_arr = $sdate->diff($edate);
			$date_gap = $date_gap_arr->days;

			if($date_gap > 31){
				back("주문일 검색기간은 31일 이상 검색시 그래프를 표현 할 수 없습니다.");
			}

			if($sch_sdate==$sch_edate){	//당일 주문 검색시 시간대별로
				$where_sql = " where date_format(trade_day,'%Y-%m-%d') between '{$sch_sdate}' and '{$sch_edate}' ORDER BY trade_day";
				$sql = "select idx,trade_day,trade_method,trade_stat,price,use_point,use_coupon from dh_trade {$where_sql}";

				ob_start();
				/*
				row :	[idx] => 371932
							[trade_day] => 2019-04-07 00:02:49
							[trade_method] => 2
							[trade_stat] => 4
							[price] => 62200
							[use_point] => 2200
				*/
				foreach($this->order_m->sales($sql) as $row){

					if($row->trade_stat <= 4){	//주문, 입금, 배송, 완료
						$roof_top[total_payment]+=$row->price;
						$roof_top[total_order_cnt]++;
						$roof_top[total_order_ok_cnt]++;

						//그래프
						$graph[date("Y-m-d H",strtotime($row->trade_day))][total_payment]+=$row->price;

						//표
						$table[date("Y-m-d H",strtotime($row->trade_day))][total_order_cnt]++;
						$table[date("Y-m-d H",strtotime($row->trade_day))][total_order_price]+=$row->price;

						if($row->trade_method==1){
							$table[date("Y-m-d H",strtotime($row->trade_day))][m1_cnt]++;
							$table[date("Y-m-d H",strtotime($row->trade_day))][m1_total]+=$row->price;
						}

						if($row->trade_method==2){
							$table[date("Y-m-d H",strtotime($row->trade_day))][m2_cnt]++;
							$table[date("Y-m-d H",strtotime($row->trade_day))][m2_total]+=$row->price;
						}

						if($row->trade_method==3){
							$table[date("Y-m-d H",strtotime($row->trade_day))][m3_cnt]++;
							$table[date("Y-m-d H",strtotime($row->trade_day))][m3_total]+=$row->price;
						}

						if($row->trade_method==4){
							$table[date("Y-m-d H",strtotime($row->trade_day))][m4_cnt]++;
							$table[date("Y-m-d H",strtotime($row->trade_day))][m4_total]+=$row->price;
						}

						if($row->trade_method==5){
							$table[date("Y-m-d H",strtotime($row->trade_day))][use_point_cnt]++;
							$table[date("Y-m-d H",strtotime($row->trade_day))][use_point_price]+=$row->price;
						}

						if($row->trade_method==7){
							$table[date("Y-m-d H",strtotime($row->trade_day))][m7_cnt]++;
							$table[date("Y-m-d H",strtotime($row->trade_day))][m7_total]+=$row->price;
						}

						if($row->use_point>0){
							$table[date("Y-m-d H",strtotime($row->trade_day))][use_point_price]+=$row->use_point;
						}

						if($row->use_coupon>0){
							$table[date("Y-m-d H",strtotime($row->trade_day))][use_coupon_cnt]++;
							$table[date("Y-m-d H",strtotime($row->trade_day))][use_coupon_price]+=$row->use_coupon;
						}
					}
					else if($row->trade_stat >= 9){	//취소신청, 취소완료
						$roof_top[total_order_cnt]++;
						$roof_top[total_order_cc_cnt]++;

						//그래프
						$graph[date("Y-m-d H",strtotime($row->trade_day))][total_paycancel]+=$row->price;

						//표
						$table[date("Y-m-d H",strtotime($row->trade_day))][total_order_cc_cnt]++;
						$table[date("Y-m-d H",strtotime($row->trade_day))][total_order_cc_price]+=$row->price;
					}

					ob_clean();
				}

				$data['roof_top']=$roof_top;
				$data['graph']=$graph;
				$data['table']=$table;

				$view="/dhadm/shop/sales_time";
			}
			else{

				$where_sql = " where date_format(trade_day,'%Y-%m-%d') between '{$sch_sdate}' and '{$sch_edate}' ORDER BY trade_day";
				$sql = "select idx,trade_day,trade_method,trade_stat,price,use_point,use_coupon from dh_trade {$where_sql}";

				ob_start();
				/*
				row :	[idx] => 371932
							[trade_day] => 2019-04-07 00:02:49
							[trade_method] => 2
							[trade_stat] => 4
							[price] => 62200
							[use_point] => 2200
				*/
				foreach($this->order_m->sales($sql) as $row){

					if($row->trade_stat <= 4){	//주문, 입금, 배송, 완료
						$roof_top[total_payment]+=$row->price;
						$roof_top[total_order_cnt]++;
						$roof_top[total_order_ok_cnt]++;

						//그래프
						$graph[date("Y-m-d",strtotime($row->trade_day))][total_payment]+=$row->price;

						//표
						$table[date("Y-m-d",strtotime($row->trade_day))][total_order_cnt]++;
						$table[date("Y-m-d",strtotime($row->trade_day))][total_order_price]+=$row->price;

						if($row->trade_method==1){
							$table[date("Y-m-d",strtotime($row->trade_day))][m1_cnt]++;
							$table[date("Y-m-d",strtotime($row->trade_day))][m1_total]+=$row->price;
						}

						if($row->trade_method==2){
							$table[date("Y-m-d",strtotime($row->trade_day))][m2_cnt]++;
							$table[date("Y-m-d",strtotime($row->trade_day))][m2_total]+=$row->price;
						}

						if($row->trade_method==3){
							$table[date("Y-m-d",strtotime($row->trade_day))][m3_cnt]++;
							$table[date("Y-m-d",strtotime($row->trade_day))][m3_total]+=$row->price;
						}

						if($row->trade_method==4){
							$table[date("Y-m-d",strtotime($row->trade_day))][m4_cnt]++;
							$table[date("Y-m-d",strtotime($row->trade_day))][m4_total]+=$row->price;
						}

						if($row->trade_method==5){
							$table[date("Y-m-d",strtotime($row->trade_day))][use_point_cnt]++;
							$table[date("Y-m-d",strtotime($row->trade_day))][use_point_price]+=$row->price;
						}

						if($row->trade_method==7){
							$table[date("Y-m-d",strtotime($row->trade_day))][m7_cnt]++;
							$table[date("Y-m-d",strtotime($row->trade_day))][m7_total]+=$row->price;
						}

						if($row->use_point>0){
							$table[date("Y-m-d",strtotime($row->trade_day))][use_point_price]+=$row->use_point;
						}

						if($row->use_coupon>0){
							$table[date("Y-m-d",strtotime($row->trade_day))][use_coupon_cnt]++;
							$table[date("Y-m-d",strtotime($row->trade_day))][use_coupon_price]+=$row->use_coupon;
						}
					}
					else if($row->trade_stat >= 9){	//취소신청, 취소완료
						$roof_top[total_order_cnt]++;
						$roof_top[total_order_cc_cnt]++;

						//그래프
						$graph[date("Y-m-d",strtotime($row->trade_day))][total_paycancel]+=$row->price;

						//표
						$table[date("Y-m-d",strtotime($row->trade_day))][total_order_cc_cnt]++;
						$table[date("Y-m-d",strtotime($row->trade_day))][total_order_cc_price]+=$row->price;
					}

					ob_clean();
				}

				$data['roof_top']=$roof_top;
				$data['graph']=$graph;
				$data['table']=$table;

				$view="/dhadm/shop/sales_daily";
			}
		}
		else if($date_mode == "month"){

			$sch_year = $this->input->get("sch_year");

			$where_sql = " where date_format(trade_day,'%Y') = '{$sch_year}' ORDER BY trade_day";
			$sql = "select idx,trade_day,trade_method,trade_stat,price,use_point,use_coupon from dh_trade {$where_sql}";
			ob_start();
			/*
			row :	[idx] => 371932
						[trade_day] => 2019-04-07 00:02:49
						[trade_method] => 2
						[trade_stat] => 4
						[price] => 62200
						[use_point] => 2200
			*/
			foreach($this->order_m->sales($sql) as $row){

				if($row->trade_stat <= 4){	//주문, 입금, 배송, 완료
					$roof_top[total_payment]+=$row->price;
					$roof_top[total_order_cnt]++;
					$roof_top[total_order_ok_cnt]++;

					//그래프
					$graph[date("Y-m",strtotime($row->trade_day))][total_payment]+=$row->price;

					//표
					$table[date("Y-m",strtotime($row->trade_day))][total_order_cnt]++;
					$table[date("Y-m",strtotime($row->trade_day))][total_order_price]+=$row->price;

					if($row->trade_method==1){
						$table[date("Y-m",strtotime($row->trade_day))][m1_cnt]++;
						$table[date("Y-m",strtotime($row->trade_day))][m1_total]+=$row->price;
					}

					if($row->trade_method==2){
						$table[date("Y-m",strtotime($row->trade_day))][m2_cnt]++;
						$table[date("Y-m",strtotime($row->trade_day))][m2_total]+=$row->price;
					}

					if($row->trade_method==3){
						$table[date("Y-m",strtotime($row->trade_day))][m3_cnt]++;
						$table[date("Y-m",strtotime($row->trade_day))][m3_total]+=$row->price;
					}

					if($row->trade_method==4){
						$table[date("Y-m",strtotime($row->trade_day))][m4_cnt]++;
						$table[date("Y-m",strtotime($row->trade_day))][m4_total]+=$row->price;
					}

					if($row->trade_method==5){
						$table[date("Y-m",strtotime($row->trade_day))][use_point_cnt]++;
						$table[date("Y-m",strtotime($row->trade_day))][use_point_price]+=$row->price;
					}

					if($row->trade_method==7){
						$table[date("Y-m",strtotime($row->trade_day))][m7_cnt]++;
						$table[date("Y-m",strtotime($row->trade_day))][m7_total]+=$row->price;
					}

					if($row->use_point>0){
						$table[date("Y-m",strtotime($row->trade_day))][use_point_price]+=$row->use_point;
					}

					if($row->use_coupon>0){
						$table[date("Y-m",strtotime($row->trade_day))][use_coupon_cnt]++;
						$table[date("Y-m",strtotime($row->trade_day))][use_coupon_price]+=$row->use_coupon;
					}
				}
				else if($row->trade_stat >= 9){	//취소신청, 취소완료
					$roof_top[total_order_cnt]++;
					$roof_top[total_order_cc_cnt]++;

					//그래프
					$graph[date("Y-m",strtotime($row->trade_day))][total_paycancel]+=$row->price;

					//표
					$table[date("Y-m",strtotime($row->trade_day))][total_order_cc_cnt]++;
					$table[date("Y-m",strtotime($row->trade_day))][total_order_cc_price]+=$row->price;
				}

				ob_clean();
			}

			$data['roof_top']=$roof_top;
			$data['graph']=$graph;
			$data['table']=$table;

			$view="/dhadm/shop/sales_month";
		}
		else if($date_mode == "year"){

			$where_sql = " ORDER BY trade_day";
			$sql = "select idx,trade_day,trade_method,trade_stat,price,use_point,use_coupon from dh_trade {$where_sql}";
			ob_start();
			/*
			row :	[idx] => 371932
						[trade_day] => 2019-04-07 00:02:49
						[trade_method] => 2
						[trade_stat] => 4
						[price] => 62200
						[use_point] => 2200
			*/
			foreach($this->order_m->sales($sql) as $row){

				if($row->trade_stat <= 4){	//주문, 입금, 배송, 완료
					$roof_top[total_payment]+=$row->price;
					$roof_top[total_order_cnt]++;
					$roof_top[total_order_ok_cnt]++;

					//그래프
					$graph[date("Y",strtotime($row->trade_day))][total_payment]+=$row->price;

					//표
					$table[date("Y",strtotime($row->trade_day))][total_order_cnt]++;
					$table[date("Y",strtotime($row->trade_day))][total_order_price]+=$row->price;

					if($row->trade_method==1){
						$table[date("Y",strtotime($row->trade_day))][m1_cnt]++;
						$table[date("Y",strtotime($row->trade_day))][m1_total]+=$row->price;
					}

					if($row->trade_method==2){
						$table[date("Y",strtotime($row->trade_day))][m2_cnt]++;
						$table[date("Y",strtotime($row->trade_day))][m2_total]+=$row->price;
					}

					if($row->trade_method==3){
						$table[date("Y",strtotime($row->trade_day))][m3_cnt]++;
						$table[date("Y",strtotime($row->trade_day))][m3_total]+=$row->price;
					}

					if($row->trade_method==4){
						$table[date("Y",strtotime($row->trade_day))][m4_cnt]++;
						$table[date("Y",strtotime($row->trade_day))][m4_total]+=$row->price;
					}

					if($row->trade_method==5){
						$table[date("Y",strtotime($row->trade_day))][use_point_cnt]++;
						$table[date("Y",strtotime($row->trade_day))][use_point_price]+=$row->price;
					}

					if($row->trade_method==7){
						$table[date("Y",strtotime($row->trade_day))][m7_cnt]++;
						$table[date("Y",strtotime($row->trade_day))][m7_total]+=$row->price;
					}

					if($row->use_point>0){
						$table[date("Y",strtotime($row->trade_day))][use_point_price]+=$row->use_point;
					}

					if($row->use_coupon>0){
						$table[date("Y",strtotime($row->trade_day))][use_coupon_cnt]++;
						$table[date("Y",strtotime($row->trade_day))][use_coupon_price]+=$row->use_coupon;
					}
				}
				else if($row->trade_stat >= 9){	//취소신청, 취소완료
					$roof_top[total_order_cnt]++;
					$roof_top[total_order_cc_cnt]++;

					//그래프
					$graph[date("Y",strtotime($row->trade_day))][total_paycancel]+=$row->price;

					//표
					$table[date("Y",strtotime($row->trade_day))][total_order_cc_cnt]++;
					$table[date("Y",strtotime($row->trade_day))][total_order_cc_price]+=$row->price;
				}

				ob_clean();
			}

			$data['roof_top']=$roof_top;
			$data['graph']=$graph;
			$data['table']=$table;

			$view="/dhadm/shop/sales_year";
		}

		if($excel == "ok"){
			$this->load->view("/dhadm/excel/sales",$data);
		}
		else{
			$this->load->view($view,$data);
		}

	}

	public function sales_back($data=''){	//매출현황

		$date_mode=$this->input->get('date_mode');
		if($date_mode=="")
			$date_mode="day";

		//주문일 기준 검색값 파라미터 설정
		$sch_sdate = $this->input->get('sch_sdate') ? $this->input->get('sch_sdate') : date("Y-m-d", strtotime('-6 days')) ;
		$sch_edate = $this->input->get('sch_edate') ? $this->input->get('sch_edate') : date("Y-m-d") ;

		$sdate = new datetime($sch_sdate);
		$edate = new datetime($sch_edate);

		$date_gap_arr = $sdate->diff($edate);
		$date_gap = $date_gap_arr->days;

		if($date_gap > 31){
			back("주문일 검색기간은 31일 이상 할 수 없습니다.");
		}

		$sch_year=$this->input->get('sch_year');

		$order_avg = array();

		if($date_mode=="day"){
			$where_sql = " where date_format(trade_day,'%Y-%m-%d') between '{$sch_sdate}' and '{$sch_edate}' ORDER BY trade_day";
			$sql = "select idx,trade_code,trade_day,trade_method,trade_stat,price,use_point from dh_trade {$where_sql}";
			foreach($this->order_m->sales($sql) as $row){
				$order_avg[$row->idx]['trade_day']=date("Y-m-d",strtotime($row->trade_day));
				$order_avg[$row->idx]['trade_method']=$row->trade_method;
				$order_avg[$row->idx]['trade_stat']=$row->trade_stat;
				$order_avg[$row->idx]['total_price']=$row->price;
				$order_avg[$row->idx]['use_point']=$row->use_point;
			}
		}
		else if($date_mode=="month"){
			$where_sql = " where date_format(trade_day,'%Y-%m-%d') between '{$sch_sdate}' and '{$sch_edate}' ORDER BY trade_day";
			$sql = "select idx,trade_code,trade_day,trade_method,trade_stat,price,use_point from dh_trade {$where_sql}";
			foreach($this->order_m->sales($sql) as $row){
				$order_avg[$row->idx]['trade_day']=date("Y-m-d",strtotime($row->trade_day));
				$order_avg[$row->idx]['trade_method']=$row->trade_method;
				$order_avg[$row->idx]['trade_stat']=$row->trade_stat;
				$order_avg[$row->idx]['total_price']=$row->price;
				$order_avg[$row->idx]['use_point']=$row->use_point;
			}
		}
		else if($date_mode=="year"){
			$where_sql = " ORDER BY trade_day";
			$sql = "select idx,trade_code,trade_day,trade_method,trade_stat,price,use_point from dh_trade {$where_sql}";
		}

		$data['orders'] = $order_avg;

		//월별 검색 데이터 추출용 연도값
		$data['min_year']=$this->common_m->self_q("SELECT DISTINCT DATE_FORMAT(trade_day, '%Y') AS year FROM dh_trade ORDER BY YEAR ASC LIMIT 1","row");

		if($this->input->get("excel")=="ok"){
			$this->load->view("/dhadm/excel/sales",$data);
		}
		else{

			if($date_mode=="day"){
				$this->load->view("/dhadm/shop/sales",$data);
			}
			else if($date_mode=="month"){
				$this->load->view("/dhadm/shop/sales_month",$data);
			}

		}
	}

	public function make($data=''){	//생산량내역출력
		//pr($_POST);
		if($_POST){

			$deliv_date = $this->input->post('deliv_date');
			$check = $this->input->post('onlylist');

			if($check){
				//$data['list'] = $this->common_m->self_q("select * from dh_trade_deliv_prod where deliv_date = '{$deliv_date}'","result");

				//$sql = "select a.*,b.name from dh_trade_deliv_prod a left join dh_goods b on a.goods_idx = b.idx where deliv_date = '{$deliv_date}' order by b.name asc";
				$sql = "
					SELECT a.*, c.name, a.tg_idx
					FROM dh_trade_deliv_prod a
						LEFT JOIN dh_trade b ON a.trade_code = b.trade_code
						LEFT JOIN dh_goods c ON a.goods_idx = c.idx
						LEFT JOIN dh_trade_deliv_info d ON a.deliv_code = d.deliv_code
					WHERE a.deliv_date = '{$deliv_date}'
						AND b.trade_stat BETWEEN 2 AND 3
						AND d.deliv_stat BETWEEN 0 AND 2
					ORDER BY name ASC
				";

				$list = $this->common_m->self_q($sql,"result");

				$excel_arr = array();

				foreach($list as $lt){
					$excel_arr[$lt->goods_idx]['name'] = $lt->name;
					$excel_arr[$lt->goods_idx]['prod_cnt'] += $lt->prod_cnt;

					if($lt->option_cnt){
						$options = $this->common_m->self_q("select * from dh_trade_goods_option where trade_code = '".$lt->trade_code."' and trade_goods_idx = '".$lt->tg_idx."' and goods_idx = '".$lt->goods_idx."' and level = '2' order by option_idx asc","result");
						foreach($options as $option_row){
							$excel_arr[$lt->goods_idx]['option_cnts'] += $option_row->cnt;
							$excel_arr[$lt->goods_idx]['option_info'][$option_row->option_idx]['option_name'] = $option_row->name;
							$excel_arr[$lt->goods_idx]['option_info'][$option_row->option_idx]['option_cnt'] += $option_row->cnt;
						}
					}
				}
				$data['excel_arr'] = $excel_arr;
				$this->load->view("/dhadm/excel/make",$data);

			}
			else{
				$this->make_excel($deliv_date);
			}

		}
		else{
			$this->load->view("/dhadm/shop/make",$data);
		}
	}

	public function salerank($data=''){	//상품판매순위
		$this->load->view("/dhadm/shop/salerank",$data);
	}

	public function printorder($data=''){	//주문내역출력
		$this->load->view("/dhadm/shop/printorder",$data);
	}

	public function apibox_noti(){	//apibox 연동

		$r_arrow_ip = array(
			gethostbyname('apibox.kr'),		/* APIBOX 실서버 */
			gethostbyname('whenji.com'),	/* APIBOX 백업서버 */
			'112.221.155.109'								/* 이곳에 개발PC IP주소등 접속허용IP를 기록하세요 */
		);

		if (!in_array($_SERVER['REMOTE_ADDR'],$r_arrow_ip)) exit;

		$sql = "select * from dh_trade
						where trade_stat = '1'
						and replace(enter_account,'-','') = '".$this->input->get('account')."'
						and enter_name = '".$this->input->get('name')."'
						and total_price = '".$this->input->get('price')."'";

		$row = $this->common_m->self_q($sql,"row");

		if($row){
			$where['idx'] = $row->idx;

			$update['apibox_tid'] = $this->input->get('tid');
			$update['apibox_data'] = serialize($_GET);
			$update['trade_stat'] = "2";
			$update['trade_day_ok'] = timenow();

			$update = $this->common_m->update2("dh_trade",$update,$where);
			if($update){
				echo "ok";
			}
		}

	}

	public function duplist($data=''){

		$data['query_string'] = "?";
		$where_query = "where 1";

		if($this->input->get('sch_item') && $this->input->get('sch_item_val')){
			$data['query_string'] .= "&sch_item=".$this->input->get('sch_item')."&sch_item_val=".$this->input->get('sch_item_val');
			$where_query .= " and b.userid like '%".$this->input->get('sch_item_val')."%'";
		}

		// 페이징 start */
		$url = cdir()."/";
		$url .= ($this->uri->segment(1))?$this->uri->segment(1)."/":"";
		$url .= ($this->uri->segment(2)!="m")?$this->uri->segment(2)."/":"";
		$url .= ($this->uri->segment(3)!="m")?$this->uri->segment(3)."/":"";
		$url .= ($this->uri->segment(4)!="m")?$this->uri->segment(4)."/":"";
		$url .= "m";

		$sql = "select a.*, b.userid, b.name, b.phone, b.send_phone from dh_trade_grade a left join dh_trade b on a.trade_code = b.trade_code {$where_query}";

		$PageNumber = $this->input->get("PageNumber"); //현재 페이지
		if(!$PageNumber){ $PageNumber = 1; }
		$list_num='20'; //페이지 목록개수
		$page_num='5'; //페이징 개수
		$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
		$data['totalCnt'] = $this->common_m->self_q($sql,"cnt");
		$data['Page'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
		$data['listNo'] = $data['totalCnt'] - $list_num*($PageNumber-1);
		// 페이징 end */

		$sql .= " order by a.idx desc limit {$offset}, {$list_num}";

		$data['list'] = $this->common_m->self_q($sql,"result");
		$this->load->view("/dhadm/order/duplist",$data);

	}

	public function cclist($data=''){

		$mode = $this->uri->segment(4);
		$tcode = $this->uri->segment(5);

		if($mode == "ccview"){

			if($_POST){
				$cidx = $this->input->post('change_idx');
				$cstat = $this->input->post('change_stat');
				$result = $this->common_m->self_q("update dh_trade set trade_stat = '{$cstat}' where idx = '{$cidx}'","update");
				if($result){
					alert($_SERVER['HTTP_REFERER']);
				}
			}

			//주문 취소 사유
			$data['trade_info'] = $this->common_m->self_q("select * from dh_trade where trade_code = '{$tcode}'","row");

			//배송일 연계된 주문건
			$cdcode = explode("^",$data['trade_info']->cancel_deliv_codes);
			$cancel_deliv_info = array();
			foreach($cdcode as $cc){
				if($cc){
					$_rows = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '{$cc}'","fetch_array");
					$cancel_deliv_info[] = $_rows[0];
				}
			}
			$data['deliv_relations'] = $cancel_deliv_info;

			$this->load->view("/dhadm/order/ccview",$data);
		}
		else{
			$data['query_string'] = "?";
			$where_query = "where trade_stat between 9 and 10";

			if($this->input->get('sch_item') && $this->input->get('sch_item_val')){
				$data['query_string'] .= "&sch_item=".$this->input->get('sch_item')."&sch_item_val=".$this->input->get('sch_item_val');
				$where_query .= " and b.userid like '%".$this->input->get('sch_item_val')."%'";
			}

			// 페이징 start */
			$url = cdir()."/";
			$url .= ($this->uri->segment(1))?$this->uri->segment(1)."/":"";
			$url .= ($this->uri->segment(2)!="m")?$this->uri->segment(2)."/":"";
			$url .= ($this->uri->segment(3)!="m")?$this->uri->segment(3)."/":"";
			$url .= ($this->uri->segment(4)!="m")?$this->uri->segment(4)."/":"";
			$url .= "m";

			$sql = "select * from dh_trade {$where_query}";

			$PageNumber = $this->input->get("PageNumber"); //현재 페이지
			if(!$PageNumber){ $PageNumber = 1; }
			$list_num='20'; //페이지 목록개수
			$page_num='5'; //페이징 개수
			$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
			$data['totalCnt'] = $this->common_m->self_q($sql,"cnt");
			$data['Page'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
			$data['listNo'] = $data['totalCnt'] - $list_num*($PageNumber-1);
			// 페이징 end */

			$sql .= " order by trade_day_cancel desc, idx desc limit {$offset}, {$list_num}";

			$data['list'] = $this->common_m->self_q($sql,"result");
			$this->load->view("/dhadm/order/cclist",$data);
		}

	}

	public function make_excel($deliv_date=''){
		if(!$deliv_date){
			$deliv_date = $this->input->get('deliv_date');
		}

		$sql = "
			SELECT a.*, c.name, a.tg_idx
			FROM dh_trade_deliv_prod a
				LEFT JOIN dh_trade b ON a.trade_code = b.trade_code
				LEFT JOIN dh_goods c ON a.goods_idx = c.idx
				LEFT JOIN dh_trade_deliv_info d ON a.deliv_code = d.deliv_code
			WHERE a.deliv_date = '{$deliv_date}'
				AND b.trade_stat BETWEEN 2 AND 3
				AND d.deliv_stat BETWEEN 0 AND 2
			ORDER BY name ASC
		";

		$list = $this->common_m->self_q($sql,"result");

			//		$sql = "select * from dh_category where display = 1 and cate_no not in ('1','2') order by depth asc";
			//		$cates = $this->common_m->self_q($sql,"result");
			//		foreach($cates as $cate){
			//			$case_arr[$cate->cate_no] = $cate->title;
			//		}
			//
			//		pr($case_arr);
			//		exit;

		$case = array(
			'1-6'=>'준비기',
			'1-7'=>'초기',
			'1-8'=>'중기준비기',
			'1-9'=>'중기',
			'1-10'=>'후기',
			'1-11'=>'완료기',
			'2-12'=>'반찬',
			'2-13'=>'국',
			'3'=>'산골간식',
			'4'=>'건강식품',
			'5'=>'오!산골농부',
			'6'=>'특가상품셋트',
			'7'=>'맛보기세트',
			'8'=>'간식추가용제품',
			'9'=>'마이크로사이트',
			'10'=>'의기양양픽',
			'11' => '산골반찬',
			'12' => '야시장'
		);
		$make_arr = array();

			//foreach($list as $lt){
			//	$excel_arr[$lt->goods_idx]['name'] = $lt->name;
			//	$excel_arr[$lt->goods_idx]['prod_cnt'] += $lt->prod_cnt;
			//
			//	if($lt->option_cnt){
			//		$options = $this->common_m->self_q("select * from dh_trade_goods_option where trade_code = '".$lt->trade_code."' and goods_idx = '".$lt->goods_idx."' and level = '2'","result");
			//		foreach($options as $option_row){
			//			$excel_arr[$lt->goods_idx]['option_cnts'] += $option_row->cnt;
			//			$excel_arr[$lt->goods_idx]['option_info'][$option_row->option_idx]['option_name'] = $option_row->name;
			//			$excel_arr[$lt->goods_idx]['option_info'][$option_row->option_idx]['option_cnt'] += $option_row->cnt;
			//		}
			//	}
			//}

		foreach($list as $lt){
			$make_arr[$lt->cate_no][$lt->goods_idx]['name'] = $lt->name;
			$make_arr[$lt->cate_no][$lt->goods_idx]['prod_cnt'] += $lt->prod_cnt;

			if($lt->option_cnt){
				$options = $this->common_m->self_q("select * from dh_trade_goods_option where trade_code = '".$lt->trade_code."' and trade_goods_idx = '".$lt->tg_idx."' and goods_idx = '".$lt->goods_idx."' and level = '2' order by option_idx asc","result");
				foreach($options as $option_row){
					$make_arr[$lt->cate_no][$lt->goods_idx]['option_cnts'] += $option_row->cnt;
					$make_arr[$lt->cate_no][$lt->goods_idx]['option_info'][$option_row->option_idx]['option_name'] = $option_row->name;
					$make_arr[$lt->cate_no][$lt->goods_idx]['option_info'][$option_row->option_idx]['option_cnt'] += $option_row->cnt;
				}
			}
		}

		$data['case'] = $case;
		$data['list'] = $make_arr;

		$this->load->view("/dhadm/excel/makelist",$data);
	}

	public function prod_cnt_update(){
		$idx = $this->input->get("idx");
		$prod_cnt = $this->input->get("prod_cnt");

		$row = $this->common_m->self_q("select *,(select name from dh_goods where idx = dh_trade_deliv_prod.goods_idx) as goods_name from dh_trade_deliv_prod where idx = '{$idx}'","row");

		$ldata['userid'] = $this->session->userdata("ADMIN_USERID");
		$ldata['type'] = "식단 수량수정 : ";
		$ldata['msg'] = "식단 : ".$row->goods_name."의 수량을 ".$row->prod_cnt."에서 ".$prod_cnt."로 수정 하였습니다.";
		$ldata['deliv_code'] = $row->deliv_code;
		$ldata['wdate'] = timenow();
		$ldata['writer'] = "관리자";

		$result = $this->common_m->insert2("dh_trade_deliv_log",$ldata);
		if($result){
			$result = $this->common_m->self_q("update dh_trade_deliv_prod set prod_cnt = '{$prod_cnt}' where idx = '{$idx}'","update");
			if($result){
				//식단 변경시 배송코드 기타로 변경
				//$this->common_m->self_q("update dh_trade_deliv_info set order_type = '999999' where deliv_code = '".$row->deliv_code."'","update");
				echo "ok";
			}
		}
	}

	/*************************************************************************************************************************
	*
	*				주문서 출력 재 작업 2018-08-27 디자인허브 김기엽 (정말 힘들다는거 하나말고는 기억에 남는게 없는 사이트)
	*
	**************************************************************************************************************************/

	public function order_print($data=''){

		$data['mode'] = $mode = $this->uri->segment(4,'');

		if($mode == "view"){
			$data['deliv_code'] = $deliv_code = $this->uri->segment(5);
			$data['deliv_info'] = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '{$deliv_code}'","row");

			$deliv_sql = "select a.*, b.recom_name
										from dh_trade_deliv_prod a
										left join dh_recom_food b on a.recom_idx = b.idx
										where deliv_code = '{$deliv_code}'
										order by goods_idx asc";

										//echo $deliv_sql;

			$data['list'] = $this->common_m->self_q($deliv_sql,"result");

			$this->load->view("/dhadm/order_print/deliv_".$mode,$data);
		}
		else if($mode == "order_change"){	//주문변동내역
			$data['deliv_code'] = $deliv_code = $this->uri->segment(5);
			$data['deliv_info'] = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '{$deliv_code}'","row");

			if($_POST){
				$insert_log['userid'] = $this->input->post("admin_userid");
				$insert_log['type'] = "관리자입력 : ".$this->input->post("admin_name");
				$insert_log['msg'] = $this->input->post("memo_content");
				$insert_log['deliv_code'] = $deliv_code;
				$insert_log['wdate'] = date("Y-m-d H:i:s");
				$insert_log['writer'] = "관리자";

				$result = $this->common_m->insert2("dh_trade_deliv_log",$insert_log);
				if($result){
					alert($_SERVER['HTTP_REFERER'],'등록 되었습니다.');
				}

			}
			else{

				$sql = "
					select *
					from dh_trade_deliv_log
					where deliv_code = '{$deliv_code}'
					order by wdate desc
				";

				$data['list'] = $this->common_m->self_q($sql,"result");

			}

			$this->load->view("/dhadm/order/deliv_".$mode,$data);
		}
		else{

			//송장번호 자동발급 및 업데이트 , 회원등급 자동조정 , 알림톡 발송, 배송안내메일 발송, 자동 주문완료처리,
			if($_POST){

				$deliv_email = $this->input->post('deliv_email');
				$deliv_sms = $this->input->post('deliv_sms');
				$auto_invoice = $this->input->post('auto_invoice');
				$change_stat = $this->input->post('change_stat');
				$check_arr = $this->input->post('check');

				$epost = array();
				foreach($check_arr as $ca){

					$add_update_sql = "";
					list($trade_code_tmp, $deliv_time) = explode("-",$ca);
					list($trade_code, $order_cnt) = explode("_",$trade_code_tmp);
					//우체국 송장번호 체크시 자동 업데이트 로직 생성
					//송장번호 업데이트 시 stat 값도 같이 update 하도록
					if($auto_invoice == '1'){
						$api_result = $this->order_m->Epost_deliv_Api($ca);
						//pr($api_result);
						//echo $api_result."<BR>";
						//pr($api_result);
						//API 요청일시 : 2018-04-30 15:47:26 201804306071404944 - 2018043050982536 - 6864017497500 - 20180430154725

						$invoice_log = "API 요청일시 : " . date("Y-m-d H:i:s");

						if($api_result['error_code'] and $api_result['error_message']){
							$invoice_log .= " ".$api_result['error_code'] . ":" . $api_result['error_message'];
						}
						else{
							/*
							// 우체국택배신청번호(건당부여)
							$result['req_no'] = trim((string)$xml->reqNo);
							// 예약번호(일자당 부여)
							$result['res_no'] = trim((string)$xml->resNo);
							// 운송장번호
							$result['regi_no'] = trim((string)$xml->regiNo);
							// 예약일시
							$result['res_date'] = trim((string)$xml->resDate);
							*/
							$invoice_log .= " req_no : " . $api_result['req_no'] . "^^res_no : " . $api_result['res_no'] . "^^regi_no : " . $api_result['regi_no'] . "^^res_date : " . $api_result['res_date'];
						}


						$add_update_sql .= ", invoice_no = '{$api_result['regi_no']}', invoice_log = '{$invoice_log}', invoice_date = now()";
					}

					//stat update
					$result = $this->common_m->self_q("update dh_trade_deliv_info set deliv_stat = '{$change_stat}', udate = now() {$add_update_sql} where deliv_code = '{$ca}'","update");

					//로그 기록
					$deliv_stat_arr = array('0'=>'배송대기','1'=>'배송준비중','2'=>'배송중','3'=>'배송완료','4'=>'배송중지','5'=>'배송취소','6'=>'휴일정지','7'=>'조기마감');
					$log_type = "배송상태변경";
					$log_msg = "배송상태 ".$deliv_stat_arr[$change_stat]."로 변경";
					$writer = $this->session->userdata('ADMIN_USERID')."(".$this->session->userdata('ADMIN_NAME').")";
					$this->common_m->write_log($this->session->userdata('ADMIN_USERID'), $log_type, $log_msg, $ca, timenow(), $writer);

					if($result){

						//알림톡 발송시 분기 있음 , 일반 배송시, 정기배송 마지막 배송시 //
						$deliv_info = $this->common_m->self_q("select *,(select idx from dh_trade where trade_code = dh_trade_deliv_info.trade_code) as trade_idx from dh_trade_deliv_info where deliv_code = '{$ca}'","row");

						//메일 발송 체크시 메일 발송
						if($this->input->post('deliv_email') == '1'){
							$mail_data['trade_idx'] = $deliv_info->trade_idx;
							$mail_data['delivery_idx'] = 1;
							$mail_data['delivery_no'] = $deliv_info->invoice_no;
							$result = $this->common_m->mailform(4,$mail_data);
						}

						//SMS 발송 체크시 SMS 발송
						//sms 알림톡으로 대체함
						if($this->input->post('deliv_sms') == '1'){
							$token = $this->kkoat_m->token_generation();

							$phone = $deliv_info->recv_phone;
							$name = $deliv_info->order_name;
							$add1 = $deliv_info->invoice_company;
							$add2 = $deliv_info->invoice_no;

							$msg = "{$name}님,\r\n익일 배송예정 운송장 정보입\r\n니다  :)\r\n\r\n택배 : {$add1}\r\n운송장번호 : {$add2}\r\n\r\n택배기사님도 힘내서\r\n우리아가집에 무사히\r\n잘 도착하길!";
							$tmpcode = "M_01459_170";
							$this->kkoat_m->ent_prise_kakao_send($token,$phone,$msg,$tmpcode);
						}
					}

					if($change_stat == "3"){
						$sql = "
							select a.trade_code, a.deliv_code, a.userid, a.deliv_stat,
							b.first_order, b.total_price, b.sample_is, b.save_point
							from dh_trade_deliv_info a left join dh_trade b on a.trade_code = b.trade_code
							where deliv_code = '".$ca."'
						";
						$row = $this->common_m->self_q($sql,"row");	//배송정보 검색

						//해당 주문건으로 포인트가 적립 되었는지 확인;
						$deliv_code_arr = deliv_code_arr($ca);
						$trade_code = $deliv_code_arr['trade_code'];

						$reward_sql = "select * from dh_point where trade_code = '{$trade_code}' and point > 0";
						$reward_cnt = $this->common_m->self_q($reward_sql,"cnt");

						$deliv_cnt = $this->common_m->self_q("select * from dh_trade_deliv_info where trade_code = '".$row->trade_code."' and deliv_stat < 3","cnt");	//같은 주문의 배송완료 여부 파악

						if($deliv_cnt > 0){	//같은 주문에 배송이 하나라도 남은경우 빠염
							continue;
						}
						else{	//배송이 전부 완료된경우
							$result = $this->common_m->self_q("update dh_trade set trade_stat = 4 where trade_code = '".$row->trade_code."'","update");	//거래정보 판매완료로 업데이트
							if($result and $reward_cnt <= 0){
								$member_info = $this->common_m->self_q("select *,(select reward from dh_member_level where level = dh_member.level) as reward from dh_member where userid = '".$row->userid."'","row");	//회원정보 불러옴
								$first_and_recom = false;
								//첫주문 여부 분기점
								if($row->first_order == "Y"){	//첫주문
									if($member_info->recomid){
										$first_and_recom = true;
									}
								}

								if($first_and_recom){	//추천인이 있는경우
									$point = $row->total_price * 0.1;

									//추천인과 본인 동시 지급
									$insert1['userid'] = $row->userid;
									$insert1['point'] = round($point);	//소숫점 버림
									$insert1['content'] = "첫주문 (주문번호:".$row->trade_code.") 추천인 포함 10% 적립";
									$insert1['flag'] = "trade";
									$insert1['trade_code'] = $row->trade_code;
									$insert1['reg_date'] = timenow();

									if($point > 0){
										$result = $this->common_m->insert2("dh_point",$insert1);
										//echo "첫주문 추천인 :dh_point ".$point." 입력:".$result."<BR>";
									}

									if($result){	//추천인 포인트 지급	추천인이 회원탈퇴를 했는지 여부는 안따짐

										$insert1['userid'] = $member_info->recomid;
										$insert1['point'] = round($point);	//소숫점 버림
										$insert1['content'] = $member_info->name."님께서 추천후 첫구매 완료 (10% 적립)";
										$insert1['flag'] = "recom";
										$insert1['reg_date'] = timenow();

										if($point > 0){
											$result = $this->common_m->insert2("dh_point",$insert1);
											//echo "첫주문 추천인에게 :dh_point ".$point." 입력:".$result."<BR>";
										}

									}
								}
								else{	//추천인이 없는 경우
									$point = $row->total_price * $member_info->reward * 0.01;

									$insert1['userid'] = $row->userid;
									$insert1['point'] = round($point);	//소숫점 버림
									$insert1['content'] = "거래완료 [".$row->trade_code."]";
									$insert1['flag'] = "trade";
									$insert1['trade_code'] = $row->trade_code;
									$insert1['reg_date'] = timenow();

									if($point > 0){
										$result = $this->common_m->insert2("dh_point",$insert1);
										//echo "첫주문 아닌거 :dh_point ".$point." 입력:".$result."<BR>";
									}
								}

								//포인트 입력후 회원 등급 조정
								if($result){

									$level_info = $this->common_m->self_q("select * from dh_member_level order by level desc","result");	//회원레벨 정보
									$level_up_price = array();
									foreach($level_info as $li){
										$level_up_price[$li->level] = $li->level_up_price;
									}

									if($member_info->level < 3){
										$total_payment = $this->common_m->self_q("select sum(total_price) as tp from dh_trade where userid = '".$row->userid."' and trade_stat = '4'","row");

										foreach($level_up_price as $level => $levup_price){
											if($total_payment->tp > $levup_price){
												$lev = $level;
												break;
											}
										}

										if($lev != $member_info->level){

											$result = $this->common_m->self_q("update dh_member set level = '{$lev}' where userid = '".$row->userid."'","update");

											//회원 등업시 쿠폰 자동지급
											if($lev==2){
												$coupon_row = $this->common_m->self_q("select * from dh_coupon where code = '1809UKCTDCX4'","row");
											}
											else if($lev==3){
												$coupon_row = $this->common_m->self_q("select * from dh_coupon where code = '1809ETYLXPW6'","row");
											}

											$userid = $row->userid;
											$coupon_use_cnt = $this->common_m->self_q("select * from dh_coupon_use where code = '".$coupon_row->code."' and userid = '{$userid}'","cnt");
											if($coupon_use_cnt <= 0){
												$cpin['userid'] = $userid;
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

											if($result){

												$lev_chg['userid'] = $dl->userid;
												$lev_chg['before_level'] = $member_info->level ? $member_info->level : "" ;
												$lev_chg['after_level'] = $lev;
												$lev_chg['info'] = "거래 완료처리시 레벨 업";
												$lev_chg['wdate'] = timenow();

												$result = $this->common_m->insert2("dh_member_level_change",$lev_chg);

											}

										}

									}
									else{
										$result = "1";
									}
								}
							}
						}
					}
					else{
						//주문내역 배송중이 아니라면 배송중으로 업데이트
						$trade_row = $this->common_m->self_q("select * from dh_trade where trade_code = '{$trade_code}'","row");
						if($trade_row->trade_stat < 3){
							$result = $this->common_m->self_q("update dh_trade set trade_stat = '3' where trade_code = '{$trade_code}'","update");
						}
					}

				}

				if($result){
					alert($_SERVER['HTTP_REFERER']);
				}

			}

			$data['deliv_stat_arr'] = $deliv_stat_arr = array(	//배송 스탯 배열
				'0'=>'배송대기',
				'1'=>'배송준비중',
				'2'=>'배송중',
				'3'=>'배송완료',
				'4'=>'중지',
				'5'=>'취소',
				'6'=>'휴일정지','7'=>'조기마감'
			);

			//검색조건 설정
				$data['qs'] = "?all_check_btn=".$this->input->get('all_check_btn')."&order_types=".$this->input->get('order_types');	//파라미터
				$add_sql = "";	//추가 쿼리

				//$deliv_date = ($this->input->get("deliv_date"))?$this->input->get("deliv_date"):date("Y-m-d",strtotime("+1 day"));	//배송일자
				$ds_date = $this->input->get('sch_sdate');	//배송 시작일자
				$de_date = $this->input->get('sch_edate');	//배송 종료일자

				$last_order_type = substr($this->input->get('order_types'),-1);
				if($last_order_type == ","){
					$order_types = substr($this->input->get('order_types'),0,-1);
				}
				else{
					$order_types = $this->input->get('order_types');
				}

				if($order_types == "9010"){
					$order_types = "9010,9011,9012,9013,9014";
				}

				if($order_types == "9020" || $order_types == "902000"){
					$order_types = "90210,902100,902110,90211,90220,902200,902210,90221,90230,902300,902310,90231,90240,902400,902410,90241,902000,9020";
				}

				if($order_types == '999999'){
					$order_types = "999999,0";
				}

				//$order_types = substr($this->input->get('order_types'),0,-1);

				$sch_deliv_stat = $this->input->get('sch_deliv_stat');	//배송상태
				$sch_trade_stat = $this->input->get('sch_trade_stat');	//주문상태
				$sch_other = $this->input->get('sch_other');	//기타검색

				if($ds_date){
					$add_sql .= " and a.deliv_date between '{$ds_date}' and '{$de_date}'";
					$data['qs'] .= "&sch_sdate={$ds_date}&sch_edate={$de_date}";
				}
				/*
				else{
					$add_sql .= " and a.deliv_date between '".date("Y-m-d", strtotime('+1 day'))."' and '".date("Y-m-d", strtotime('+1 day'))."'";
				}
				*/

				if($order_types){
					$add_sql .= " and a.order_type in (".$order_types.")";
				}
				/*
				else{
					$add_sql .= " and a.order_type <> 0";
				}
				*/

				if($sch_deliv_stat){	//배송상태
					$add_sql .= " and a.deliv_stat = '".$sch_deliv_stat."'";
					$data['qs'] .= "&sch_deliv_stat={$sch_deliv_stat}";
				}

				if($sch_trade_stat){	//주문상태
					$add_sql .= " and b.trade_stat = '".$sch_trade_stat."'";
					$data['qs'] .= "&sch_trade_stat={$sch_trade_stat}";
				}

				if($sch_other){	//기타검색
					$data['qs'] .= "&sch_other=".$sch_other;

					if($sch_other == 'overlap'){	//중복주문확인

					}
					else{
						switch($sch_other){
							case "invoice":
								$add_sql .= " and a.invoice_no <> ''";
							break;
							case "no_invoice":
								$add_sql .= " and a.invoice_no = ''";
							break;
						}
					}
				}
			//검색조건 설정

			$sql = "select distinct a.deliv_code, a.* ";
			$sql.= ",b.trade_stat, b.first_order, b.mobile, b.trade_day, b.total_price, b.trade_method, b.send_text, b.idx as tidx, b.recom_idx ";
			$sql.= ",(select count(idx) from dh_trade_deliv_log where deliv_code = a.deliv_code) as log_count ";
			$sql.= ",(select idx from dh_member where userid = a.userid) as useridx ";
			//$sql.= ',c.name AS option_name ';
			$sql.= "from dh_trade_deliv_info a left join dh_trade b on a.trade_code = b.trade_code ";
			//$sql.= "LEFT JOIN dh_trade_goods_option AS c ON a.trade_code = c.trade_code ";
			$sql.= "where b.trade_stat in (2,3,31) ";
			$sql.= $add_sql;
			//$sql.= ' AND c.`level` = 2';

			//토탈 갯수 쿼리
			$stat_sql = "select a.* from dh_trade_deliv_info a left join dh_trade b on a.trade_code = b.trade_code where b.trade_stat in (2,3,31) and a.deliv_date = '".date('Y-m-d',strtotime('+1 day'))."' group by trade_code";
			$stat_result = $this->common_m->self_q($stat_sql,"result");
			$stat0 = 0; $stat1 = 0; $stat2 = 0; $stat3 = 0; $stat4 = 0; $stat5 = 0; $stat6 = 0;
			foreach($stat_result as $order_cnt){
				switch($order_cnt->deliv_stat){
					case 0: $stat0++; break;
					case 1: $stat1++; break;
					case 2: $stat2++; break;
					case 3: $stat3++; break;
					case 4: $stat4++; break;
					case 5: $stat5++; break;
					case 6: $stat6++; break;
				}
			}

			$data['order_cnts'] = array($stat0,$stat1,$stat2,$stat3,$stat4,$stat5,$stat6);

			if($_GET){

				//$data['qs'] .= $_SERVER['QUERY_STRING'];

				$url = cdir()."/";
				$url .= ($this->uri->segment(1))?$this->uri->segment(1)."/":"";
				$url .= ($this->uri->segment(2) and $this->uri->segment(2)!="m")?$this->uri->segment(2)."/":"";
				$url .= ($this->uri->segment(3) and $this->uri->segment(3)!="m")?$this->uri->segment(3)."/":"";
				$url .= ($this->uri->segment(4) and $this->uri->segment(4)!="m")?$this->uri->segment(4)."/":"";
				$url .= "m";

				$PageNumber = $this->input->get("PageNumber"); //현재 페이지
				if(!$PageNumber){ $PageNumber = 1; }
				$list_num='50'; //페이지 목록개수
				$page_num='5'; //페이징 개수
				$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)

				$cnt_sql = "select distinct a.deliv_code from dh_trade_deliv_info a left join dh_trade b on a.trade_code = b.trade_code where b.trade_stat in (2,3,31) {$add_sql}";

				$data['totalCnt'] = $data['total'] = $this->common_m->self_q($cnt_sql,"cnt");
				$data['Page'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['qs']);

				//정렬 방식 공통 사용
				$order_sql = " order by
												a.order_type,
												b.recom_week_type desc,
												b.recom_week_day_count,
												b.recom_delivery_sun_type,
												b.trade_day desc,
												a.deliv_date desc";

				if($this->input->get('excel') == "ok"){
					$sql .= $order_sql;
					$data['shop_info'] = $this->admin_m->shop_info(); //shop 정보
				}
				else{
					$sql .= $order_sql;
					$sql .= " limit {$offset}, {$list_num}";
				}

				//echo $sql."<BR><BR>";

				//정기배송 상품명 끌어오기
				$recom_row = $this->common_m->self_q("select * from dh_recom_food","result");
				$recom_name_arr = array();
				foreach($recom_row as $rr){
					$recom_name_arr[$rr->idx] = $rr->recom_name;
				}

				$data['recom_name_arr'] = $recom_name_arr;
				//정기배송 상품명 끌어오기

				if($_SERVER['HTTP_X_FORWARDED_FOR'] == "58.229.223.174"){
					//echo $sql;
					//exit;
				}

				$data['list'] = $this->common_m->self_q($sql,"result");
			}

			if($this->input->get('excel') == "ok"){
				$this->load->view("/dhadm/excel/delivery",$data);
			}
			else{
				$this->load->view("/dhadm/order_print/list",$data);
			}
		}
	}

	public function delivery_print_new($data=''){

		if(!$this->input->post("check")){
			?>
			<script type="text/javascript">
			alert("출력할 데이터가 없습니다.");
			self.close();
			</script>
			<?php
		}

		//pr($_POST);
		//배송코드 post로 전달받음 // 아마 전송 용량 제한때문에 한번에는 힘들듯 한데
		//선택한 이 아닌 검색된으로 한다면 한번에 가능할지도..
		$deliv_code = $this->input->post("check");
		//날짜 추출
		$date_tmp = explode("-",$deliv_code[0]);
		$data['deliv_date'] = date("Y-m-d",$date_tmp[1]);

		//전송된 배송코드를 토대로 데이터 가져와서 배열화
		$print_row = array();
		$dup_arr = array();

		//pr($deliv_code);
		$dcodes = "";
		foreach($deliv_code as $dc){
			$dcodes .= ( ($dcodes) ? "," : "" ) . "'".$dc."'";
		}

		//echo $dcodes;


		//(select count(*) from dh_trade_deliv_info where trade_code = a.trade_code and recom_idx > 0 and deliv_stat > 0) as deliv_cnt,
		$sql = "
			select distinct
				a.*, sum(a.prod_cnt) as sum_prod_cnt,
				b.name as goods_name,
				c.prod_name, c.order_name, c.order_phone, c.recv_name, c.recv_phone, c.zipcode, c.addr1, c.addr2, c.userid, c.invoice_no,
				d.regist_type,
				e.name as level_name,
				f.mobile, f.trade_day, f.send_text, f.first_order,
				g.title as cate_name,
				h.recom_week_count, h.recom_week_day_count, h.recom_delivery_sun_type, h.recom_week_type, h.recom_dates
				,(select count(idx) from dh_trade_goods where trade_code = a.trade_code and cate_no = 'recom') as multi_order_recom
			from dh_trade_deliv_prod a
				left join dh_goods b on a.goods_idx = b.idx
				left join dh_trade_deliv_info c on a.deliv_code = c.deliv_code
				left join dh_member d on c.userid = d.userid
				left join dh_member_level e on d.level = e.level
				left join dh_trade f on a.trade_code = f.trade_code
				left join dh_trade_goods h on c.tg_idx = h.idx
				left join dh_category g on a.cate_no = g.cate_no
			where a.deliv_code in ({$dcodes})
				/*and (a.prod_cnt > 0 or a.option_cnt > 0)*/
			group by a.deliv_code, a.goods_idx, a.tg_idx
			order by
				c.order_type,
				f.recom_week_type desc,
				f.recom_week_day_count,
				f.recom_delivery_sun_type,
				f.trade_day desc,
				c.deliv_date desc,
				a.recom_is desc,
				a.cate_no asc,
				goods_name asc,
				a.prod_cnt desc
		";

		//echo "<pre>{$sql}</pre>";

		$deliv_row = $this->common_m->self_q($sql,"fetch_array");

		//pr($deliv_row);

		$dup_sql = "
			select count(*) as dup_cnt, userid
			from dh_trade_deliv_info
			where deliv_date = '".$data['deliv_date']."' and trade_code in (select trade_code from dh_trade where trade_stat between 2 and 3 and trade_code = dh_trade_deliv_info.trade_code)
			group by userid
		";
		$dup_list = $this->common_m->self_q($dup_sql,"result");

		foreach($dup_list as $dl){
			$dup_arr[$dl->userid] = $dl->dup_cnt;
		}

		//pr($dup_arr);


		$bkcnt = 0;
		foreach($deliv_row as $bk){

			if($old_deliv_code != $bk['deliv_code']){
				$bkcnt = 0;
			}

			//첫배송인지 아닌지 확인하여 첫주문이라도 첫배송이 아니면 첫주문 없앨것.

			$recom_dates_arr = explode("^",$bk['recom_dates']);	//정기배송일자 묶음값 가져와서 배열화
			$first_real = array_search($bk['deliv_date'],$recom_dates_arr);		//배열에서 찾기

			//pr($recom_dates_arr);

			//첫배송인지 아닌지 확인하여 첫주문이라도 첫배송이 아니면 첫주문 없앨것.

			//동일제품 카운트 잡아줄것

			//$dup_arr[$bk['deliv_code']][$bk['trade_code']] = true;

			$print_row[$bk['deliv_code']][$bkcnt] = $bk;
			$print_row[$bk['deliv_code']]['userid'] = $bk['userid'];
			$print_row[$bk['deliv_code']]['name'] = $bk['order_name'];
			$print_row[$bk['deliv_code']]['trade_code'] = $bk['trade_code'];
			$print_row[$bk['deliv_code']]['deliv_code'] = $bk['deliv_code'];
			$print_row[$bk['deliv_code']]['recv_name'] = $bk['recv_name'];
			$print_row[$bk['deliv_code']]['recv_phone'] = $bk['recv_phone'];
			$print_row[$bk['deliv_code']]['zipcode'] = $bk['zipcode'];
			$print_row[$bk['deliv_code']]['addr1'] = $bk['addr1'];
			$print_row[$bk['deliv_code']]['addr2'] = $bk['addr2'];
			$print_row[$bk['deliv_code']]['send_text'] = $bk['send_text'];
			$print_row[$bk['deliv_code']]['recom_week_count'] = $bk['recom_week_count'];
			$print_row[$bk['deliv_code']]['recom_week_day_count'] = $bk['recom_week_day_count'];
			$print_row[$bk['deliv_code']]['recom_week_type'] = $bk['recom_week_type'];
			$print_row[$bk['deliv_code']]['recom_delivery_sun_type'] = $bk['recom_delivery_sun_type'];
			//if($bk['deliv_cnt'] == 1){

			//로직 변경 들어감 2019-02-27
			//멀티 주문의 경우 첫주문의 판단이 어려움이 있음
			//조건1 sns 회원은 안줌
			//조건2 멀티 주문의 경우 정기배송에서 내보내는걸로

			if($bk['regist_type'] != sns){	//회원이 sns 연동이 아니고
				if($bk['multi_order_recom'] <= 0){	//멀티 주문이 아닌경우 ( 장바구니에 다 쌔려넣고 주문한게 아닌경우 )
					if($bk['recom_week_day_count'] && $bk['first_order'] == "Y"){	//주문이 정기배송이고 첫주문인경우
						if($recom_dates_arr[0] == $bk['deliv_date']){	//배송일이 정기배송 첫날인 경우
							$print_row[$bk['deliv_code']]['first_order'] = "Y";
						}
					}
					else if($bk['first_order'] == "Y"){
						foreach($deliv_row as $fsd){
							if($old_dd){
								if($old_dd > $fsd['deliv_date']){
									$first_deliv = $fsd['deliv_date'];
								}
							}
							else{
								$first_deliv = $fsd['deliv_date'];
							}

							$old_dd = $fsd['deliv_date'];
						}

						if($bk['deliv_date'] == $first_deliv){
							$print_row[$bk['deliv_code']]['first_order'] = "Y";
						}
					}
				}
				else{	//멀티 주문의 경우
					if($bk['recom_week_day_count'] && $bk['first_order'] == "Y"){	//주문이 정기배송이고 첫주문인경우
						if($recom_dates_arr[0] == $bk['deliv_date']){	//배송일이 정기배송 첫날인 경우
							$print_row[$bk['deliv_code']]['first_order'] = "Y";
						}
					}
				}
			}

			if($bk['option_cnt'] > 0){
				//echo "select distinct * from dh_trade_goods_option where level = '2' and trade_goods_idx = '".$bk['tg_idx']."'"."<BR>";
				$option_info = $this->common_m->self_q("select distinct * from dh_trade_goods_option where level = '2' and trade_goods_idx = '".$bk['tg_idx']."'","fetch_array");
				$print_row[$bk['deliv_code']][$bkcnt]['option_info'] = $option_info;
			}

			$bkcnt++;

			$old_deliv_code = $bk['deliv_code'];

		}

		$data['list'] = $print_row;
		$data['dup_arr'] = $dup_arr;
		$this->load->view("/dhadm/order/deliv_popup",$data);

	}

	public function order_del($data=''){

		$mode = $this->uri->segment(3);

		if($mode == "del_all"){

			//주문내역 , 배송내역 , 배송상품 일괄 삭제
			$sdate = $this->input->get('sdate');
			$edate = $this->input->get('edate');

			$sql = "select trade_code from dh_trade where date_format(trade_day,'%Y-%m-%d') between '{$sdate}' and '{$edate}'";
			$delist = $this->common_m->self_q($sql,"result");

			foreach($delist as $del){
				$result = $this->common_m->self_q("delete from dh_trade_goods where trade_code = '".$del->trade_code."'","delete");
				$result = $this->common_m->self_q("delete from dh_trade_goods_option where trade_code = '".$del->trade_code."'","delete");
				$result = $this->common_m->self_q("delete from dh_trade_deliv_info where trade_code = '".$del->trade_code."'","delete");
				$result = $this->common_m->self_q("delete from dh_trade_deliv_prod where trade_code = '".$del->trade_code."'","delete");
				//마지막에 주문내역 비움
				$result = $this->common_m->self_q("delete from dh_trade where trade_code = '".$del->trade_code."'","delete");
			}

			$result = "1";

			if($result){
				alert($_SERVER['HTTP_REFERER'],"주문삭제가 완료 되었습니다.(개발부분 미적용중입니다.)");
			}

		}
		else{
			$sdate = $this->input->get('sch_sdate');
			$edate = $this->input->get('sch_edate');

			if($sdate and $edate){
				$sql = "select * from dh_trade where date_format(trade_day,'%Y-%m-%d') between '{$sdate}' and '{$edate}'";
				$data['list'] = $this->common_m->self_q($sql,"cnt");
			}

			$this->load->view("/dhadm/order/order_del",$data);
		}

	}

	public function coupon_upload(){
		$this->load->library("PHPExcel");
		$obj_excel = new PHPExcel();
		$file_name = $_FILES['upload_excel']['tmp_name'];
		$obj_excel = PHPExcel_IOFactory::load($file_name);
		$sheet = $obj_excel->getActiveSheet();
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();

		$data = array();
		$continew = true;

		$arr = array();
		$arr_cnt = 0;
    for ($row = 2; $row <= $highestRow; $row++)
    {
			/* $rowData가 한줄의 데이터를 셀별로 배열처리 됩니다. */
			$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
			$arr[$arr_cnt] = $rowData[0];
			$arr_cnt++;
    }

		for($ii=0;$ii < count($arr);$ii++){

			$cnt = $this->common_m->self_q("select * from dh_coupon where code = '".$arr[$ii][0]."'","cnt");
			if($cnt > 0){
				back("중복되는 쿠폰코드가 있습니다.");
				$continew = false;
				exit;
			}
			else{
				$data[$ii]['name'] = $arr[$ii][1];
				$data[$ii]['code'] = $arr[$ii][0];
				$data[$ii]['type'] = "0";
				$data[$ii]['discount_flag'] = $arr[$ii][2];
				$data[$ii]['price'] = $arr[$ii][3];
				$data[$ii]['date_flag'] = "0";
				$data[$ii]['status'] = "2";
				$data[$ii]['start_date'] = PHPExcel_Style_NumberFormat::toFormattedString($arr[$ii][4], PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
				$data[$ii]['end_date'] = PHPExcel_Style_NumberFormat::toFormattedString($arr[$ii][5], PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
				$data[$ii]['reg_date'] = date("Y-m-d H:i:s");
				$data[$ii]['max_count'] = $arr[$ii][6];
				$data[$ii]['min_price'] = $arr[$ii][7];
				$data[$ii]['use_sdate'] = PHPExcel_Style_NumberFormat::toFormattedString($arr[$ii][8], PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
				$data[$ii]['use_edate'] = PHPExcel_Style_NumberFormat::toFormattedString($arr[$ii][9], PHPExcel_Style_NumberFormat::FORMAT_DATE_YYYYMMDD2);
			}
		}

		if($continew == true){
			for($in=0;$in<count($data);$in++){
				$result = $this->common_m->insert2("dh_coupon",$data[$in]);
			}
			result($result,"업로드",cdir()."/order/coupon/m");
		}


	}

	public function coupon_two_up(){
		$this->load->library("PHPExcel");
		$obj_excel = new PHPExcel();
		$file_name = $_FILES['upload_excel']['tmp_name'];
		$obj_excel = PHPExcel_IOFactory::load($file_name);
		$sheet = $obj_excel->getActiveSheet();
		$highestRow = $sheet->getHighestRow();
		$highestColumn = $sheet->getHighestColumn();

		$data = array();
		$continew = true;

		$arr = array();
		$arr_cnt = 0;
    for ($row = 2; $row <= $highestRow; $row++)
    {
			/* $rowData가 한줄의 데이터를 셀별로 배열처리 됩니다. */
			$rowData = $sheet->rangeToArray('A' . $row . ':' . $highestColumn . $row, NULL, TRUE, FALSE);
			$arr[$arr_cnt] = $rowData[0];
			$arr_cnt++;
    }

		for($ii=0;$ii < count($arr);$ii++){

			$cnt = $this->common_m->self_q("select * from dh_coupon_two where code = '".$arr[$ii][0]."'","cnt");
			if($cnt > 0){
				back("중복되는 쿠폰코드가 있습니다.");
				$continew = false;
				exit;
			}
			else{
				$data[$ii]['name'] = $arr[$ii][1];
				$data[$ii]['code'] = $arr[$ii][0];
				$data[$ii]['reg_date'] = date("Y-m-d H:i:s");
			}
		}

		if($continew == true){
			for($in=0;$in<count($data);$in++){
				$result = $this->common_m->insert2("dh_coupon_two",$data[$in]);
			}
			result($result,"업로드",cdir()."/order/coupon_two/m");
		}
	}

	public function dsp_excel($data=''){

		$data['deliv_stat_arr'] = $deliv_stat_arr = array(	//배송 스탯 배열
			'0'=>'배송대기',
			'1'=>'배송준비중',
			'2'=>'배송중',
			'3'=>'배송완료',
			'4'=>'중지',
			'5'=>'취소',
			'6'=>'휴일정지','7'=>'조기마감'
		);

		//검색조건 설정
			$data['qs'] = "?all_check_btn=".$this->input->get('all_check_btn')."&order_types=".$this->input->get('order_types');	//파라미터
			$add_sql = " and a.deliv_stat in (0,1,2)";	//추가 쿼리

			//$deliv_date = ($this->input->get("deliv_date"))?$this->input->get("deliv_date"):date("Y-m-d",strtotime("+1 day"));	//배송일자
			$ds_date = $this->input->get('sch_sdate');	//배송 시작일자
			$de_date = $this->input->get('sch_edate');	//배송 종료일자

			$last_order_type = substr($this->input->get('order_types'),-1);
			if($last_order_type == ","){
				$order_types = substr($this->input->get('order_types'),0,-1);
			}
			else{
				$order_types = $this->input->get('order_types');
			}

			if($order_types == "9010"){
				$order_types = "9010,9011,9012,9013,9014";
			}

			if($order_types == "9020" || $order_types == "902000"){
				$order_types = "90210,902100,902110,90211,90220,902200,902210,90221,90230,902300,902310,90231,90240,902400,902410,90241,902000,9020";
			}

			if($order_types == '999999'){
				$order_types = "0,999999";
			}

			//$order_types = substr($this->input->get('order_types'),0,-1);

			$sch_deliv_stat = $this->input->get('sch_deliv_stat');	//배송상태
			$sch_trade_stat = $this->input->get('sch_trade_stat');	//주문상태
			$sch_other = $this->input->get('sch_other');	//기타검색

			if($ds_date){
				$add_sql .= " and a.deliv_date between '{$ds_date}' and '{$de_date}'";
				$data['qs'] .= "&sch_sdate={$ds_date}&sch_edate={$de_date}";
			}
			/*
			else{
				$add_sql .= " and a.deliv_date between '".date("Y-m-d", strtotime('+1 day'))."' and '".date("Y-m-d", strtotime('+1 day'))."'";
			}
			*/

			if($order_types){
				$add_sql .= " and a.order_type in (".$order_types.")";
			}
			/*
			else{
				$add_sql .= " and a.order_type <> 0";
			}
			*/

			if($sch_deliv_stat){	//배송상태
				$add_sql .= " and a.deliv_stat = '".$sch_deliv_stat."'";
				$data['qs'] .= "&sch_deliv_stat={$sch_deliv_stat}";
			}

			if($sch_trade_stat){	//주문상태
				$add_sql .= " and b.trade_stat = '".$sch_trade_stat."'";
				$data['qs'] .= "&sch_trade_stat={$sch_trade_stat}";
			}

			if($sch_other){	//기타검색
				$data['qs'] .= "&sch_other=".$sch_other;

				if($sch_other == 'overlap'){	//중복주문확인

				}
				else{
					switch($sch_other){
						case "invoice":
							$add_sql .= " and a.invoice_no <> ''";
						break;
						case "no_invoice":
							$add_sql .= " and a.invoice_no = ''";
						break;
					}
				}
			}
		//검색조건 설정
		//		$sql = "select distinct a.deliv_code, a.* ";
		//		$sql.= ", b.trade_stat, b.first_order, b.mobile, b.trade_day, b.total_price, b.trade_method, b.send_text, b.idx as tidx, b.recom_idx ";
		//		$sql.= ", (select count(idx) from dh_trade_deliv_log where deliv_code = a.deliv_code) as log_count ";
		//		$sql.= ", (select idx from dh_member where userid = a.userid) as useridx ";
		//		$sql.= "from dh_trade_deliv_info a left join dh_trade b on a.trade_code = b.trade_code ";
		//		$sql.= "where b.trade_stat in (2,3,31) ";
		//		$sql.= $add_sql;

		//토탈 갯수 쿼리
		$stat_sql = "select a.* from dh_trade_deliv_info a left join dh_trade b on a.trade_code = b.trade_code where b.trade_stat in (2,3,31) and a.deliv_date = '".date('Y-m-d',strtotime('+1 day'))."' group by trade_code";
		$stat_result = $this->common_m->self_q($stat_sql,"result");
		$stat0 = 0; $stat1 = 0; $stat2 = 0; $stat3 = 0; $stat4 = 0; $stat5 = 0; $stat6 = 0;
		foreach($stat_result as $order_cnt){
			switch($order_cnt->deliv_stat){
				case 0: $stat0++; break;
				case 1: $stat1++; break;
				case 2: $stat2++; break;
				case 3: $stat3++; break;
				case 4: $stat4++; break;
				case 5: $stat5++; break;
				case 6: $stat6++; break;
			}
		}

		$data['order_cnts'] = array($stat0,$stat1,$stat2,$stat3,$stat4,$stat5,$stat6);

		if($_GET){

			//$data['qs'] .= $_SERVER['QUERY_STRING'];

//			$url = cdir()."/";
//			$url .= ($this->uri->segment(1))?$this->uri->segment(1)."/":"";
//			$url .= ($this->uri->segment(2) and $this->uri->segment(2)!="m")?$this->uri->segment(2)."/":"";
//			$url .= ($this->uri->segment(3) and $this->uri->segment(3)!="m")?$this->uri->segment(3)."/":"";
//			$url .= ($this->uri->segment(4) and $this->uri->segment(4)!="m")?$this->uri->segment(4)."/":"";
//			$url .= "m";
//
//			$PageNumber = $this->input->get("PageNumber"); //현재 페이지
//			if(!$PageNumber){ $PageNumber = 1; }
//			$list_num='50'; //페이지 목록개수
//			$page_num='5'; //페이징 개수
//			$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)

			$cnt_sql = "select distinct a.deliv_code from dh_trade_deliv_info a left join dh_trade b on a.trade_code = b.trade_code where b.trade_stat in (2,3,31) {$add_sql}";

			$data['totalCnt'] = $data['total'] = $this->common_m->self_q($cnt_sql,"cnt");
//			$data['Page'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['qs']);

			if($this->input->get('excel') == "ok"){
				//$sql .= $order_sql;
				$data['shop_info'] = $this->admin_m->shop_info(); //shop 정보

				//				$sql = "
				//					select
				//						tdp.*,d.idx as memidx, a.order_name, a.recv_name, a.recv_phone, a.zipcode, a.addr1, a.addr2, e.title,c.code, b.send_text, c.name as goods_name, a.invoice_no
				//						, a.regiPoNm, a.vTelNo, a.arrCnpoNm, a.delivPoNm, a.delivAreaCd
				//						, a.deliv_stat
				//						, b.recom_dates
				//						, d.regist_type
				//						, b.mobile, b.trade_day, b.first_order, b.recom_week_day_count
				//					from dh_trade_deliv_prod tdp
				//						left join dh_trade b on tdp.trade_code = b.trade_code
				//						left join dh_goods c on tdp.goods_idx = c.idx
				//						left join dh_member d on b.userid = d.userid
				//						left join dh_category e on c.cate_no = e.cate_no
				//						left join dh_trade_deliv_info a on tdp.deliv_code = a.deliv_code
				//					where b.trade_stat in (2,3,31) {$add_sql}
				//					order by a.trade_code asc
				//				";

				//				$sql = "
				//					select distinct
				//						tdp.*,
				//						a.order_name, a.recv_name, a.recv_phone, a.zipcode, a.addr1, a.addr2, a.userid, a.invoice_no,a.deliv_stat,
				//						b.mobile, b.trade_day, b.send_text, b.first_order, b.recom_dates,
				//						c.code, c.name as goods_name,
				//						d.regist_type, d.idx as memidx,
				//						e.title,
				//						h.recom_week_count, h.recom_week_day_count, h.recom_week_type
				//					from dh_trade_deliv_prod tdp
				//						left join dh_goods c on tdp.goods_idx = c.idx
				//						left join dh_trade_deliv_info a on tdp.deliv_code = a.deliv_code
				//						left join dh_member d on d.userid = a.userid
				//						left join dh_trade b on tdp.trade_code = b.trade_code
				//						left join dh_trade_goods h on tdp.tg_idx = h.idx
				//						left join dh_category e on tdp.cate_no = e.cate_no
				//					where b.trade_stat in (2,3,31) {$add_sql}
				//					order by a.trade_code asc
				//				";

				$sql = "
					select distinct
						tdp.*,
						a.order_name, a.recv_name, a.recv_phone, a.zipcode, a.addr1, a.addr2, a.userid, a.invoice_no,a.deliv_stat,
						b.mobile, b.trade_day, b.send_text, b.first_order, b.recom_dates,b.recom_week_count, b.recom_week_day_count, b.recom_week_type,
						c.code, c.name as goods_name,
						d.regist_type, d.idx as memidx,
						e.title
					from dh_trade_deliv_prod tdp
						left join dh_goods c on tdp.goods_idx = c.idx
						left join dh_trade_deliv_info a on tdp.deliv_code = a.deliv_code
						left join dh_member d on d.userid = a.userid
						left join dh_trade b on tdp.trade_code = b.trade_code
						left join dh_category e on tdp.cate_no = e.cate_no
					where b.trade_stat in (2,3,31) {$add_sql}
					order by a.trade_code asc
				";

				$deliv_row = $this->common_m->self_q($sql,"fetch_array");

				foreach($deliv_row as $bk){

					//첫배송인지 아닌지 확인하여 첫주문이라도 첫배송이 아니면 첫주문 없앨것.
					//로직 변경 들어감 2019-02-27
					//멀티 주문의 경우 첫주문의 판단이 어려움이 있음
					//조건1 sns 회원은 안줌
					//조건2 멀티 주문의 경우 정기배송에서 내보내는걸로
					$recom_dates_arr = explode("^",$bk['recom_dates']);	//정기배송일자 묶음값 가져와서 배열화



					$print_row[$bk['deliv_code']][$bk['idx']]['deliv_date'] = $bk['deliv_date'];
					$print_row[$bk['deliv_code']][$bk['idx']]['memidx'] = $bk['memidx'];
					$print_row[$bk['deliv_code']][$bk['idx']]['order_name'] = $bk['order_name'];
					$print_row[$bk['deliv_code']][$bk['idx']]['trade_code'] = $bk['trade_code'];
					$print_row[$bk['deliv_code']][$bk['idx']]['recv_name'] = $bk['recv_name'];
					$print_row[$bk['deliv_code']][$bk['idx']]['recv_phone'] = $bk['recv_phone'];
					$print_row[$bk['deliv_code']][$bk['idx']]['zipcode'] = $bk['zipcode'];
					$print_row[$bk['deliv_code']][$bk['idx']]['addr1'] = $bk['addr1'];
					$print_row[$bk['deliv_code']][$bk['idx']]['addr2'] = $bk['addr2'];
					$print_row[$bk['deliv_code']][$bk['idx']]['title'] = $bk['title'];
					$print_row[$bk['deliv_code']][$bk['idx']]['code'] = $bk['code'];
					$print_row[$bk['deliv_code']][$bk['idx']]['recom_is'] = $bk['recom_is'];
					$print_row[$bk['deliv_code']][$bk['idx']]['prod_cnt'] = $bk['prod_cnt'];
					$print_row[$bk['deliv_code']][$bk['idx']]['send_text'] = $bk['send_text'];
					$print_row[$bk['deliv_code']][$bk['idx']]['goods_name'] = $bk['goods_name'];
					$print_row[$bk['deliv_code']][$bk['idx']]['deliv_code'] = $bk['deliv_code'];
					$print_row[$bk['deliv_code']][$bk['idx']]['recom_week_count'] = $bk['recom_week_count'];
					$print_row[$bk['deliv_code']][$bk['idx']]['first_order'] = '';

					if($bk['regist_type'] != sns){	//회원이 sns 연동이 아니고
						if($bk['recom_week_day_count'] && $bk['first_order'] == "Y"){	//주문이 정기배송이고 첫주문인경우
							if($recom_dates_arr[0] == $bk['deliv_date']){	//배송일이 정기배송 첫날인 경우
								$print_row[$bk['deliv_code']][$bk['idx']]['first_order'] = "Y";
							}
						}
					}

					if($bk['option_cnt'] > 0){
						//echo "select distinct * from dh_trade_goods_option where level = '2' and trade_goods_idx = '".$bk['tg_idx']."'"."<BR>";
						$option_info = $this->common_m->self_q("select distinct * from dh_trade_goods_option where level = '2' and trade_goods_idx = '".$bk['tg_idx']."'","fetch_array");
						$print_row[$bk['deliv_code']][$bk['idx']]['option_info'] = $option_info;
					}

				}

				$excel['list'] = $print_row;
			}
			else{
				//$sql .= $order_sql;
				//$sql .= " limit {$offset}, {$list_num}";
			}
		}

		if($this->input->get('excel') == "ok"){
			$this->load->view("/dhadm/excel/dsp_excel",$excel);
		}
		else{
			$this->load->view("/dhadm/order/dsp_excel",$data);
		}

		/*
		$sql = "
			select
				tdp.*,d.idx as memidx, a.order_name, a.recv_name, a.recv_phone, a.zipcode, a.addr1, a.addr2, e.title,c.code, b.first_order, b.send_text, c.name as goods_name
			from dh_trade_deliv_prod tdp
				left join dh_trade b on tdp.trade_code = b.trade_code
				left join dh_goods c on tdp.goods_idx = c.idx
				left join dh_member d on b.userid = d.userid
				left join dh_category e on c.cate_no = e.cate_no
				left join dh_trade_deliv_info a on tdp.deliv_code = a.deliv_code
			where b.trade_stat in (2,3,31) {$add_sql}
		";

		if($this->input->post('deliv_date')){
			$sql = "
				select
					a.*, d.idx as memidx, f.order_name, f.recv_name, f.recv_phone, f.zipcode, f.addr1, f.addr2
					, e.title,c.code, b.first_order, b.send_text, c.name as goods_name
				from dh_trade_deliv_prod a
					left join dh_trade b on a.trade_code = b.trade_code
					left join dh_goods c on a.goods_idx = c.idx
					left join dh_member d on b.userid = d.userid
					left join dh_category e on c.cate_no = e.cate_no
					left join dh_trade_deliv_info f on a.deliv_code = f.deliv_code
				where a.deliv_date = '".$this->input->post('deliv_date')."'
				order by idx desc
				limit 50
			";
			$deliv_row = $this->common_m->self_q($sql,"fetch_array");

			foreach($deliv_row as $bk){

				//첫배송인지 아닌지 확인하여 첫주문이라도 첫배송이 아니면 첫주문 없앨것.

				$recom_dates_arr = explode("^",$bk['recom_dates']);	//정기배송일자 묶음값 가져와서 배열화
				$first_real = array_search($bk['deliv_date'],$recom_dates_arr);		//배열에서 찾기

				//pr($recom_dates_arr);

				//첫배송인지 아닌지 확인하여 첫주문이라도 첫배송이 아니면 첫주문 없앨것.

				//동일제품 카운트 잡아줄것

				//$dup_arr[$bk['deliv_code']][$bk['trade_code']] = true;

				$print_row[$bk['idx']] = $bk;
				//if($bk['deliv_cnt'] == 1){

				//로직 변경 들어감 2019-02-27
				//멀티 주문의 경우 첫주문의 판단이 어려움이 있음
				//조건1 sns 회원은 안줌
				//조건2 멀티 주문의 경우 정기배송에서 내보내는걸로

				if($bk['regist_type'] != sns){	//회원이 sns 연동이 아니고
					if($bk['multi_order_recom'] <= 0){	//멀티 주문이 아닌경우 ( 장바구니에 다 쌔려넣고 주문한게 아닌경우 )
						if($bk['recom_week_day_count'] && $bk['first_order'] == "Y"){	//주문이 정기배송이고 첫주문인경우
							if($recom_dates_arr[0] == $bk['deliv_date']){	//배송일이 정기배송 첫날인 경우
								$print_row[$bk['idx']]['first_order'] = "Y";
							}
						}
						else if($bk['first_order'] == "Y"){
							foreach($deliv_row as $fsd){
								if($old_dd){
									if($old_dd > $fsd['deliv_date']){
										$first_deliv = $fsd['deliv_date'];
									}
								}
								else{
									$first_deliv = $fsd['deliv_date'];
								}

								$old_dd = $fsd['deliv_date'];
							}

							if($bk['deliv_date'] == $first_deliv){
								$print_row[$bk['idx']]['first_order'] = "Y";
							}
						}
					}
					else{	//멀티 주문의 경우
						if($bk['recom_week_day_count'] && $bk['first_order'] == "Y"){	//주문이 정기배송이고 첫주문인경우
							if($recom_dates_arr[0] == $bk['deliv_date']){	//배송일이 정기배송 첫날인 경우
								$print_row[$bk['idx']]['first_order'] = "Y";
							}
						}
					}
				}

				if($bk['option_cnt'] > 0){
					//echo "select distinct * from dh_trade_goods_option where level = '2' and trade_goods_idx = '".$bk['tg_idx']."'"."<BR>";
					$option_info = $this->common_m->self_q("select distinct * from dh_trade_goods_option where level = '2' and trade_goods_idx = '".$bk['tg_idx']."'","fetch_array");
					$print_row[$bk['idx']]['option_info'] = $option_info;
				}
			}

			$excel['list'] = $print_row;

			$this->load->view("/dhadm/excel/dsp_excel",$excel);
		}
		else{
			$this->load->view("/dhadm/order/dsp_excel",$data);
		}
		*/
	}

	public function invoice_no($data=''){	//운송장 엑셀 업로드

		$mode = $this->input->post('mode',TRUE);

		if($mode == "inv_exc_up"){
			if($_FILES['upfile']['size'] > 0){
				$excel_upload_conf = array('upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/excel/','allowed_types' => '*','encrypt_name' => TRUE,'max_size' => '20000');
				$this->load->library('upload',$excel_upload_conf);
				if(!$this->upload->do_upload('upfile')){
					back(strip_tags($this->upload->display_errors()));
				}
				else{	//엑셀 업로드 시작

					$upfile_data = $this->upload->data();
					$excel_upload_file = $upfile_data['file_name'];

					$this->load->library('excel'); //엑셀 파일 읽기
					$objPHPExcel = PHPExcel_IOFactory::load($_SERVER['DOCUMENT_ROOT'].'/_data/file/excel/'.$excel_upload_file);
					$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

					$succ=0;
					$fail=0;
					for($ii=2;$ii<=count($sheetData);$ii++){

						$where['deliv_code'] = $deliv_code = $sheetData[$ii]['A'];

						$deliv_date = strtotime('tomorrow');
						$deliv_code_exp = explode("-",$deliv_code);

						$update_data['invoice_company'] = $sheetData[$ii]['B'];
						$update_data['invoice_no'] = $sheetData[$ii]['C'];
						$update_data['deliv_stat'] = '2';

						if($deliv_date == $deliv_code_exp[1]){
						//if($deliv_code){

							$succ++;

							$result = $this->common_m->update2('dh_trade_deliv_info',$update_data,$where);
							if($result){
								$deliv_info = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '".$where['deliv_code']."'","row");
								if($deliv_info->recom_idx){	//정기배송시
									$sql = "select * from dh_trade_deliv_info where trade_code = '".$deliv_info->trade_code."' and deliv_stat in (0,4,6)";
									$left_deliv_cnt = $this->common_m->self_q($sql,"cnt");

									$token = $this->kkoat_m->token_generation();

									$phone = $deliv_info->recv_phone;
									$name = $deliv_info->order_name;
									$add1 = $deliv_info->invoice_company;
									$add2 = $deliv_info->invoice_no;

									$msg = "{$name}님,\r\n익일 배송예정 운송장 정보입\r\n니다  :)\r\n\r\n택배 : {$add1}\r\n운송장번호 : {$add2}\r\n\r\n택배기사님도 힘내서\r\n우리아가집에 무사히\r\n잘 도착하길!";
									$tmpcode = "M_01459_170";
									$this->kkoat_m->ent_prise_kakao_send($token,$phone,$msg,$tmpcode);

									if($left_deliv_cnt){	//마지막 배송시 알림톡 2개 보내는걸로 수정

									}
									else{	//마지막 배송
										$token = $this->kkoat_m->token_generation();

										$phone = $deliv_info->recv_phone;
										$name = $deliv_info->order_name;
										$add1 = $deliv_info->trade_code;

										$msg = "{$name}님,\r\n정기배송 마지막 주문이\r\n곧 배송완료예정으로\r\n주문번호 : {$add1}는\r\n주문완료 처리 되었습니다.\r\n\r\n아가의 다음 식사를\r\n미리 준비할 시간입니다.\r\n\r\n산골도, 우리맘님도\r\n모두 아자잣!\r\n\r\n에코맘의 산골이유식";
										$tmpcode = "M_01459_50";
										$this->kkoat_m->ent_prise_kakao_send($token,$phone,$msg,$tmpcode);
									}
								}
								else{
									$token = $this->kkoat_m->token_generation();

									$phone = $deliv_info->recv_phone;
									$name = $deliv_info->order_name;
									$add1 = $deliv_info->invoice_company;
									$add2 = $deliv_info->invoice_no;

									$msg = "{$name}님,\r\n익일 배송예정 운송장 정보입\r\n니다  :)\r\n\r\n택배 : {$add1}\r\n운송장번호 : {$add2}\r\n\r\n택배기사님도 힘내서\r\n우리아가집에 무사히\r\n잘 도착하길!";
									$tmpcode = "M_01459_170";
									$this->kkoat_m->ent_prise_kakao_send($token,$phone,$msg,$tmpcode);
								}
							}

						}
						else{
							$fail++;
						}
					}

					if($result){
						@unlink($_SERVER['DOCUMENT_ROOT'].'/_data/file/excel/'.$excel_upload_file);
						alert($_SERVER['HTTP_REFERER'],'운송장번호 업데이트가 완료 되었습니다. 성공 '.$succ.' 건, 실패 '.$fail.' 건');
					}
					else{
						@unlink($_SERVER['DOCUMENT_ROOT'].'/_data/file/excel/'.$excel_upload_file);
						alert($_SERVER['HTTP_REFERER'],'운송장번호 업데이트가 정상 처리 되지 않았습니다 !! 성공 '.$succ.' 건, 실패 '.$fail.' 건');
					}
				}
			}
		}

		if($mode == "yester_inv_exc_up"){
			if($_FILES['upfile']['size'] > 0){
				$excel_upload_conf = array('upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/excel/','allowed_types' => '*','encrypt_name' => TRUE,'max_size' => '20000');
				$this->load->library('upload',$excel_upload_conf);
				if(!$this->upload->do_upload('upfile')){
					back(strip_tags($this->upload->display_errors()));
				}
				else{	//엑셀 업로드 시작

					$upfile_data = $this->upload->data();
					$excel_upload_file = $upfile_data['file_name'];

					$this->load->library('excel'); //엑셀 파일 읽기
					$objPHPExcel = PHPExcel_IOFactory::load($_SERVER['DOCUMENT_ROOT'].'/_data/file/excel/'.$excel_upload_file);
					$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

					$succ=0;
					$fail=0;
					for($ii=2;$ii<=count($sheetData);$ii++){

						$where['deliv_code'] = $deliv_code = $sheetData[$ii]['A'];

						$deliv_date = strtotime('tomorrow');
						$deliv_code_exp = explode("-",$deliv_code);

						$update_data['invoice_company'] = $sheetData[$ii]['B'];
						$update_data['invoice_no'] = $sheetData[$ii]['C'];
						$update_data['deliv_stat'] = '2';

						if($deliv_code){
							$succ++;
							$result = $this->common_m->update2('dh_trade_deliv_info',$update_data,$where);

							if($result){
								$deliv_info = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '".$where['deliv_code']."'","row");
								if($deliv_info->recom_idx){	//정기배송시
									$sql = "select * from dh_trade_deliv_info where trade_code = '".$deliv_info->trade_code."' and deliv_stat in (0,4,6)";
									$left_deliv_cnt = $this->common_m->self_q($sql,"cnt");

									$token = $this->kkoat_m->token_generation();

									$phone = $deliv_info->recv_phone;
									$name = $deliv_info->order_name;
									$add1 = $deliv_info->invoice_company;
									$add2 = $deliv_info->invoice_no;

									$msg = "{$name}님,\r\n익일 배송예정 운송장 정보입\r\n니다  :)\r\n\r\n택배 : {$add1}\r\n운송장번호 : {$add2}\r\n\r\n택배기사님도 힘내서\r\n우리아가집에 무사히\r\n잘 도착하길!";
									$tmpcode = "M_01459_170";
									$this->kkoat_m->ent_prise_kakao_send($token,$phone,$msg,$tmpcode);

									if($left_deliv_cnt){	//마지막 배송시 알림톡 2개 보내는걸로 수정

									}
									else{	//마지막 배송
										$token = $this->kkoat_m->token_generation();

										$phone = $deliv_info->recv_phone;
										$name = $deliv_info->order_name;
										$add1 = $deliv_info->trade_code;

										$msg = "{$name}님,\r\n정기배송 마지막 주문이\r\n곧 배송완료예정으로\r\n주문번호 : {$add1}는\r\n주문완료 처리 되었습니다.\r\n\r\n아가의 다음 식사를\r\n미리 준비할 시간입니다.\r\n\r\n산골도, 우리맘님도\r\n모두 아자잣!\r\n\r\n에코맘의 산골이유식";
										$tmpcode = "M_01459_50";
										$this->kkoat_m->ent_prise_kakao_send($token,$phone,$msg,$tmpcode);
									}
								}
								else{
									$token = $this->kkoat_m->token_generation();

									$phone = $deliv_info->recv_phone;
									$name = $deliv_info->order_name;
									$add1 = $deliv_info->invoice_company;
									$add2 = $deliv_info->invoice_no;

									$msg = "{$name}님,\r\n익일 배송예정 운송장 정보입\r\n니다  :)\r\n\r\n택배 : {$add1}\r\n운송장번호 : {$add2}\r\n\r\n택배기사님도 힘내서\r\n우리아가집에 무사히\r\n잘 도착하길!";
									$tmpcode = "M_01459_170";
									$this->kkoat_m->ent_prise_kakao_send($token,$phone,$msg,$tmpcode);
								}
							}
						}
						else{
							$fail++;
						}
					}

					if($result){
						@unlink($_SERVER['DOCUMENT_ROOT'].'/_data/file/excel/'.$excel_upload_file);
						alert($_SERVER['HTTP_REFERER'],'운송장번호 업데이트가 완료 되었습니다. 성공 '.$succ.' 건, 실패 '.$fail.' 건');
					}
					else{
						@unlink($_SERVER['DOCUMENT_ROOT'].'/_data/file/excel/'.$excel_upload_file);
						alert($_SERVER['HTTP_REFERER'],'운송장번호 업데이트가 정상 처리 되지 않았습니다 !! 성공 '.$succ.' 건, 실패 '.$fail.' 건');
					}
				}
			}
		}

		$data['query_string'] = "?";
		$where_query = "";

		if($this->input->get('sch_sdate') && $this->input->get('sch_edate')){	//배송일자
			$where_query .= " and deliv_date between '".$this->input->get('sch_sdate')."' and '".$this->input->get('sch_edate')."'";
			$data['query_string'] .= "&sch_sdate=".$this->input->get('sch_sdate')."&sch_edate=".$this->input->get('sch_edate');
		}
		else{
			$where_query .= " and deliv_date between '".date("Y-m-d",strtotime('+1 day'))."' and '".date("Y-m-d",strtotime('+1 day'))."'";
		}

		if($this->input->get('sch_item_val')){	//회원정보 검색
			$data['query_string'] .= "&sch_item_val=".$this->input->get('sch_item_val')."&sch_item=".$this->input->get('sch_item');
			if(strpos($this->input->get('sch_item'),"phone") !== false){
				$sch_item_db = "replace(".$this->input->get('sch_item').",'-','')";
				$sch_item_val_db = str_replace("-","",$this->input->get('sch_item_val'));
			}
			else{
				$sch_item_db = $this->input->get('sch_item');
				$sch_item_val_db = $this->input->get('sch_item_val');
			}

			if($this->input->get('sch_item') == "userid"){
				$where_query .= " and {$sch_item_db} = '{$sch_item_val_db}'";
			}
			else{
				$where_query .= " and {$sch_item_db} like '%{$sch_item_val_db}%'";
			}
		}

		// 페이징 start */
		$url = cdir()."/";
		$url .= ($this->uri->segment(1))?$this->uri->segment(1)."/":"";
		$url .= ($this->uri->segment(2) and $this->uri->segment(2)!="m")?$this->uri->segment(2)."/":"";
		$url .= ($this->uri->segment(3) and $this->uri->segment(3)!="m")?$this->uri->segment(3)."/":"";
		$url .= ($this->uri->segment(4) and $this->uri->segment(4)!="m")?$this->uri->segment(4)."/":"";
		$url .= "m";

		$PageNumber = $this->input->get("PageNumber"); //현재 페이지
		if(!$PageNumber){ $PageNumber = 1; }
		$list_num='100'; //페이지 목록개수
		$page_num='5'; //페이징 개수
		$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
		$sql = "select * from dh_trade_deliv_info where deliv_stat < 3 {$where_query}";
		$data['totalCnt'] = $data['total'] = $this->common_m->self_q($sql,"cnt");
		$data['Page'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
		// 페이징 end */

		$sql .= " order by order_type asc limit {$offset},{$list_num}";
		$data['list'] = $this->common_m->self_q($sql,"result");

		$this->load->view("/dhadm/order/inv",$data);
	}


	public function menu_allchange($data=''){

		$data['goods_list'] = $this->common_m->self_q("select * from dh_goods where cate_no in ('1-6','1-7','1-8','1-9','1-10','1-11','2-12','2-13') and display = 1 order by idx desc","result");

		if($_POST){
			$goods_info = array();
			foreach($data['goods_list'] as $gd){
				$goods_info[$gd->idx] = $gd->name;
			}

			$deliv_date = $this->input->post('deliv_date');
			$goods_idx = $this->input->post('goods_idx');
			$chg_goods_idx = $this->input->post('chg_goods_idx');

			$chg_goods_info = $this->common_m->self_q("select name,cate_no from dh_goods where idx = '{$chg_goods_idx}'","row");
			$sql = "
				select *
				,(select userid from dh_trade_deliv_info where deliv_code = dh_trade_deliv_prod.deliv_code) as userid
				from dh_trade_deliv_prod
				where deliv_date = '{$deliv_date}'
				and goods_idx = '{$goods_idx}'
			";
			$list = $this->common_m->self_q($sql,"result");
			foreach($list as $lt){
				$log['userid'] = $lt->userid;
				$log['type'] = "메뉴 일괄 변경";
				$log['msg'] = "식단 : [".$goods_info[$goods_idx]."] > [".$goods_info[$chg_goods_idx]."] 일괄 변경 하였습니다.";
				$log['deliv_code'] = $lt->deliv_code;
				$log['wdate'] = timenow();
				$log['writer'] = $this->session->userdata('ADMIN_NAME')."(".$this->session->userdata('ADMIN_USERID').")";

				$log_arr[] = $log;

				$update_idx[] = $lt->idx;

				$this->common_m->insert2("dh_trade_deliv_log",$log);

				//$this->common_m->self_q("update dh_trade_deliv_info set order_type = '999999' where deliv_code = '".$lt->deliv_code."' ","update");
			}

			$up_idx = "";
			foreach($update_idx as $k=>$v){
				if($k > 0){
					$up_idx .= ",";
				}

				$up_idx .= "{$v}";
			}

			$usql = "update dh_trade_deliv_prod set goods_idx = '{$chg_goods_idx}' where idx in ({$up_idx})";
			$this->common_m->self_q($usql,"update");

			$data['log_arr'] = $log_arr;
			$this->load->view("/dhadm/order/menu_allchg",$data);

		}

		else{
			$this->load->view("/dhadm/order/menu_allchg",$data);
		}

	}

	public function zerocnts($data=''){

		$sql = "
			select
				dh_trade_deliv_info.*,
				(select count(*) from dh_trade_deliv_prod where deliv_code = dh_trade_deliv_info.deliv_code) as cnt
			from dh_trade_deliv_info
			where deliv_date > '".date('Y-m-d')."'
			and (select count(*) from dh_trade_deliv_prod where deliv_code = dh_trade_deliv_info.deliv_code) <= 0
			and (select trade_stat from dh_trade where trade_code = dh_trade_deliv_info.trade_code) in (1,2,3)
			order by deliv_date asc
		";

		$data['list'] = $this->common_m->self_q($sql,"result");
		$data['totalCnt'] = count($data['list']);
		$data['deliv_stat_arr'] = array('0'=>'배송대기','1'=>'배송준비중','2'=>'배송중','3'=>'배송완료','4'=>'배송중지','5'=>'배송취소','6'=>'휴일정지','7'=>'조기마감');

		$this->load->view("/dhadm/order/zrcnts",$data);
	}

	public function apply_order($data=''){

		if($this->input->get('del')=='ok'){
			$idx = $this->input->get('idx');
			$result = $this->common_m->self_q("delete from dh_order_apply where idx = '{$idx}'","delete");
			if($result){
				alert($_SERVER['HTTP_REFERER']);
			}
		}

		$sdate = $this->input->get('sdate');
		$edate = $this->input->get('edate');
		$sch_item = $this->input->get('sch_item');
		$sch_item_val = $this->input->get('sch_item_val');

		$data['qs'] = "?";
		$where_query = "where 1";

		if($sdate){
			$data['qs'] .="&sdate=".$sdate;
			$where_query .= " and date_format(wdate,'%Y-%m-%d') >= '{$sdate}'";
			if($edate){
				$data['qs'] .="&edate=".$edate;
				$where_query .= " and date_format(wdate,'%Y-%m-%d') between '{$sdate}' and '{$edate}'";
			}
		}

		if($sch_item && $sch_item_val){
			$data['qs'] .="&sch_item=".$sch_item;
			$data['qs'] .="&sch_item_val=".$sch_item_val;

			if($sch_item == 'phone'){
				$where_query .= " and replace({$sch_item},'-','') like '%{$sch_item_val}%'";
			}
			else{
				$where_query .= " and {$sch_item} like '%{$sch_item_val}%'";
			}
		}

		$sql = "select *,
		(select zip1 from dh_member where userid = dh_order_apply.userid) as zip1,
		(select add1 from dh_member where userid = dh_order_apply.userid) as add1,
		(select add2 from dh_member where userid = dh_order_apply.userid) as add2,
		(select count(idx) from dh_trade where trade_stat in (1,2,3,4) and userid = dh_order_apply.userid) as order_cnt from dh_order_apply {$where_query} order by idx desc";

		if($this->input->get('excel')){
			$data['list'] = $this->common_m->self_q($sql,"result");
			$this->load->view("/dhadm/yang/excel",$data);
		}
		else{
			//페이징 start
			$PageNumber = $this->input->get("PageNumber"); //현재 페이지
			if(!$PageNumber){ $PageNumber = 1; }

			if($PageNumber){
				$data['param'] .= "&PageNumber={$PageNumber}";
			}

			$list_num='100'; //페이지 목록개수
			$page_num='5'; //페이징 개수
			$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)

			$url = cdir();
			$url .= $this->uri->segment(1)?"/".$this->uri->segment(1):"";
			$url .= $this->uri->segment(2)?"/".$this->uri->segment(2):"";
			$url .= $this->uri->segment(3)?"/".$this->uri->segment(3):"";
			$url .= $this->uri->segment(4)?"/".$this->uri->segment(4):"";
			$url .= $this->uri->segment(5)?"/".$this->uri->segment(5):"";

			$data['totalCnt'] = $this->common_m->self_q($sql,"cnt"); //게시판 리스트
			$data['Page2'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['qs']);
			$data['listNo'] = $data['totalCnt'] - $list_num*($PageNumber-1);
			//페이징 end

			$sql .= " limit {$offset},{$list_num}";

			$data['list'] = $this->common_m->self_q($sql,"result");


			$this->load->view("/dhadm/yang/list",$data);
		}

	}


	public function succ($data=''){
		$mode = $this->input->post('mode',TRUE);

		$where_query = "where 1";
		$data['qs'] = "?";

		$sch_item = $this->input->get('sch_item');
		$sch_item_val = $this->input->get('sch_item_val');

		if($sch_item){
			$where_query .=  " and ".$sch_item." like '%".$sch_item_val."%'";
			$data['qs'] .= "sch_item=".$sch_item."&sch_item_val=".$sch_item_val;
		}

		if($mode == "succ_exc_up"){
			if($_FILES['upfile']['size'] > 0){
				$excel_upload_conf = array('upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/excel/','allowed_types' => '*','encrypt_name' => TRUE,'max_size' => '20000');
				$this->load->library('upload',$excel_upload_conf);
				if(!$this->upload->do_upload('upfile')){
					back(strip_tags($this->upload->display_errors()));
				}
				else{	//엑셀 업로드 시작

					$upfile_data = $this->upload->data();
					$excel_upload_file = $upfile_data['file_name'];

					$this->load->library('excel'); //엑셀 파일 읽기
					$objPHPExcel = PHPExcel_IOFactory::load($_SERVER['DOCUMENT_ROOT'].'/_data/file/excel/'.$excel_upload_file);
					$sheetData = $objPHPExcel->getActiveSheet()->toArray(null,true,true,true);

					for($ii=2;$ii<=count($sheetData);$ii++){
						if($sheetData[$ii]['A'] && $sheetData[$ii]['B'] && $sheetData[$ii]['C'] && $sheetData[$ii]['D'] && $sheetData[$ii]['E'] && $sheetData[$ii]['E']){
							$insert_data[$ii]['year'] = date('Y');
							$insert_data[$ii]['month'] = $sheetData[$ii]['A'];
							$insert_data[$ii]['prod'] = $sheetData[$ii]['B'];
							$insert_data[$ii]['userid'] = $sheetData[$ii]['C'];
							$insert_data[$ii]['name'] = $sheetData[$ii]['D'];
							$insert_data[$ii]['phone'] = $sheetData[$ii]['E'];
							$insert_data[$ii]['cate'] = $sheetData[$ii]['F'];
							$insert_data[$ii]['wdate'] = timenow();
						}
						else{
							if($sheetData[$ii]['A'] == ""){
								@unlink($_SERVER['DOCUMENT_ROOT'].'/_data/file/excel/'.$excel_upload_file);
								back("{$ii} 행 월 입력값이 누락되었습니다.");
							}
							else if($sheetData[$ii]['B'] == ""){
								@unlink($_SERVER['DOCUMENT_ROOT'].'/_data/file/excel/'.$excel_upload_file);
								back("{$ii} 행 의기양양 명칭이 누락되었습니다.");
							}
							else if($sheetData[$ii]['C'] == ""){
								@unlink($_SERVER['DOCUMENT_ROOT'].'/_data/file/excel/'.$excel_upload_file);
								back("{$ii} 행 당첨자 아이디가 누락되었습니다.");
							}
							else if($sheetData[$ii]['D'] == ""){
								@unlink($_SERVER['DOCUMENT_ROOT'].'/_data/file/excel/'.$excel_upload_file);
								back("{$ii} 행 당첨자 성명이 누락되었습니다.");
							}
							else if($sheetData[$ii]['E'] == ""){
								@unlink($_SERVER['DOCUMENT_ROOT'].'/_data/file/excel/'.$excel_upload_file);
								back("{$ii} 행 당첨자 연락처가 누락되었습니다.");
							}
							else if($sheetData[$ii]['F'] == ""){
								@unlink($_SERVER['DOCUMENT_ROOT'].'/_data/file/excel/'.$excel_upload_file);
								back("{$ii} 행 신청단계가 누락되었습니다.");
							}
						}
					}

					//엑셀 업로드 데이터 검수 완료
					foreach($insert_data as $k=>$v){
						$result = $this->common_m->insert2("dh_order_succ",$v);
					}

					if($result){
						@unlink($_SERVER['DOCUMENT_ROOT'].'/_data/file/excel/'.$excel_upload_file);
						alert($_SERVER['HTTP_REFERER'],'당첨자 업로드가 완료 되었습니다.');
					}
				}
			}
		}else{

			if($this->input->post('form_cnt')){ //여러글 삭제
				for($i=1;$i<=$this->input->post('form_cnt');$i++){
					if($this->input->post('chk'.$i)){

						$row = $this->common_m->getRow("dh_order_succ","where idx='".$this->input->post('chk'.$i,TRUE)."'");


						$result = $this->common_m->del('dh_order_succ',"idx",$this->input->post('chk'.$i,TRUE));
					}
				}

				result($result, "삭제", $data['return_url']);

			}

			if($this->input->get('excel')){
				$data['list'] = $this->common_m->self_q("select * from dh_order_succ {$where_query} order by idx desc","result");
				$this->load->view("/dhadm/succ/excel",$data);
				exit;
			}

			//페이징 start
			$PageNumber = $this->input->get("PageNumber"); //현재 페이지
			if(!$PageNumber){ $PageNumber = 1; }

			if($PageNumber){
				$data['param'] .= "&PageNumber={$PageNumber}";
			}

			$list_num='100'; //페이지 목록개수
			$page_num='5'; //페이징 개수
			$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)

			$url = cdir();
			$url .= $this->uri->segment(1)?"/".$this->uri->segment(1):"";
			$url .= $this->uri->segment(2)?"/".$this->uri->segment(2):"";
			$url .= $this->uri->segment(3)?"/".$this->uri->segment(3):"";
			$url .= $this->uri->segment(4)?"/".$this->uri->segment(4):"";
			$url .= $this->uri->segment(5)?"/".$this->uri->segment(5):"";

			$data['totalCnt'] = $this->common_m->self_q("select * from dh_order_succ {$where_query} order by idx desc","cnt"); //게시판 리스트
			$data['Page'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['qs']);
			$data['listNo'] = $data['totalCnt'] - $list_num*($PageNumber-1);
			//페이징 end

			$data['list'] = $this->common_m->self_q("select * from dh_order_succ {$where_query} order by idx desc limit {$offset},{$list_num}","result");
		}

		$this->load->view("/dhadm/succ/list",$data);
	}

	public function night_tuto($data=''){
		$mode=$this->uri->segment(4);

		if($mode == 'del'){
			$idx = $this->uri->segment(5);
			$result = $this->common_m->self_q("delete from dh_exp_apply where idx = '{$idx}'","delete");
			if($result){
				$url = str_replace("/del/{$idx}","",$_SERVER['REDIRECT_URL']);
				if($_SERVER['QUERY_STRING']){
					$url .= "?".$_SERVER['QUERY_STRING'];
				}
				alert($url);
			}
		}
		else{
			$data['query_string'] = "?";

			$sval = $this->input->get('search_value');
			if($sval){
				$data['query_string'].="search_value={$sval}";
				$where_sql = "where userid like '%{$sval}%' or name like '%{$sval}%' or trade_code like '%{$sval}%'";
			}

			$sql = "select * from dh_exp_apply {$where_sql}";

			/* 페이징 start */
			$PageNumber = $this->input->get("PageNumber"); //현재 페이지
			if(!$PageNumber){ $PageNumber=1; }
			$list_num=50; //페이지 목록개수
			$page_num=10; //페이징 개수
			$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
			$url = $_SERVER['REDIRECT_URL'];
			$data['totalCnt'] = $this->common_m->self_q($sql,"cnt");
			$data['Page'] = Page($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
			$data['Page2'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
			$data['listNo'] = $data['totalCnt'] - $list_num*($PageNumber-1);
			/* 페이징 end */

			$excel = $this->input->get('excel');

			if($excel == 'ok'){
				$data['list'] = $this->common_m->self_q($sql,"result");
				$this->load->view("/dhadm/order/exp_apply_excel",$data);
			}
			else{
				$sql .= " order by idx desc limit {$offset},{$list_num}";
				$data['list'] = $this->common_m->self_q($sql,"result");
				$this->load->view("/dhadm/order/exp_apply",$data);
			}
		}


	}

//	public function member_point_opration_policy($data){
//		$limit_date = date("Y-m-d",strtotime('-5 month'));
//		$limit_date = date("Y-m-d",strtotime('-6 month'));
//		$list = $this->common_m->self_q("select * from dh_point where reg_date < '{$limit_date}'","result");
//		foreach($list as $lt){
//			$insert['userid'] = $lt->userid;
//			$insert['point'] = "-".$lt->point;
//			$insert['content'] = "-".$lt->point;
//			$insert['content'] = "-".$lt->point;
//		}
//	}

}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */