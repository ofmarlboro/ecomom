<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dh_order extends CI_Controller {

 	function __construct()
	{
		parent::__construct();
    $this->load->model('product_m');
    $this->load->model('order_m');
    $this->load->model('member_m');
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
		$data['shop_info'] = $this->common_m->shop_info(); //shop 정보
		$data['cate_data'] = $this->product_m->header_cate(); //헤더에 보여질 모든 카테고리 리스트
		$data['deliv_extend'] = $this->common_m->not_deliv_arr();

		if($this->session->userdata('USERID')){
			$data['member_info'] = $this->common_m->self_q("select * from dh_member where userid = '".$this->session->userdata('USERID')."'","row");
		}

		if($data['shop_info']['mobile_use']=="y"){
			$this->common_m->defaultChk();
		}

		/* 카테고리 데이터 start */
		$cate_no = $this->input->get("cate_no");
		if($cate_no){
			$cate_no1 = explode("-",$cate_no);
			$cate_no1 = $cate_no1[0]; //1차카테고리

			$data['cate_list'] = $this->common_m->getList2("dh_category","where display=1 and depth=2 and cate_no like '".$cate_no1."-%'");
			$data['cate_stat1'] = $this->common_m->getRow("dh_category","where cate_no='$cate_no1' and depth=1"); //1차 카테고리 정보
			$data['cate_stat'] = $this->common_m->getRow("dh_category","where cate_no='$cate_no'"); //현재 카테고리 정보
		}
		/* 카테고리 데이터 end */


		/* 브랜드 카테고리 데이터 start */
		$brand_no = $this->input->get("brand_no");
		$data['brand_no'] = $brand_no;
		if($brand_no){
			$data['cate_stat'] = $this->common_m->getRow("dh_brand_cate","where idx='$brand_no'"); //현재 카테고리 정보
			$data['brand_list'] = $this->common_m->getList2("dh_brand_cate","where display=1 and level=1 order by sort");
		}
		/* 브랜드 카테고리 데이터 end */

		$this->{"{$method}"}($data);

		if(!$this->session->userdata('CART')){ //장바구니 카트 no 생성
			$this->common_m->cart_init();
		}
	}


	public function shop_order($data='')
	{
		if(!$this->session->userdata('USERID')){
			alert(cdir()."/dh_member/login","로그인 후 이용 가능합니다.");
		}

		$a_idx=$this->uri->segment(3,'');
		$page = $this->uri->segment(2);
		$goods_idx = $this->input->post("goods_idx");
		$code = $this->session->userdata('CART');
		$data['cart_code'] = $code;
		$data['week_name_arr'] = array('일','월','화','수','목','금','토');

		$sample_is = $this->uri->segment(4);

		$db_table = ($sample_is == "ok") ? "dh_sample_cart" : "dh_cart" ;

		$dir = $_SERVER['DOCUMENT_ROOT']."/html/application/views/order/";
		$USERID = $this->session->userdata('USERID');

		// 대구맘 뒤로가기 후 주문시 제품 추가되는 버그 해소
		$event_cnt = $this->common_m->self_q("select * from dh_cart where userid='{$USERID}' and goods_idx = '543'","cnt");
		if($event_cnt){
			$event_row = $this->common_m->self_q("select * from dh_cart where userid='{$USERID}' and goods_idx = '543' order by idx desc limit 1","row");
			$this->common_m->self_q("delete from dh_cart where userid='{$USERID}' and goods_idx = 543 and idx < ".$event_row->idx."","delete");
		}
		// 대구맘 뒤로가기 후 주문시 제품 추가되는 버그 해소

		$view = "order";
		if($goods_idx){ //바로구매
			//$result = $this->order_m->cart($goods_idx,$code,1);
			$result = $this->order_m->cart();
			$a_idx = $result['a_idx'];

			if(!$this->session->userdata('USERID')){ //비로그인시 로그인/비로그인 선택화면으로
				alert(cdir()."/dh_order/order_login/shop/".$a_idx);
				exit;
			}else{
				alert(cdir()."/dh_order/shop_order/".$a_idx);
			}
		}else if($a_idx){	//샘플신청 < 여기에 포함

			$a_idx_arr = explode("a",$a_idx);
			if(count($a_idx_arr)==1){
				$where_query .= " and c.idx='".$this->db->escape_str($a_idx)."'";
			}else if(count($a_idx_arr) > 1){

				$where_query .= " and (";
				for($i=0;$i<count($a_idx_arr);$i++){
					if($i>0){
						$where_query .= " or ";
					}

					$where_query .= " c.idx='".$a_idx_arr[$i]."' ";
				}
				$where_query .= " )";
			}
		}

		if($this->input->get("nologin",true)=="" && !$this->session->userdata('USERID')){//비로그인시 로그인/비로그인 선택화면으로
			alert(cdir()."/dh_order/order_login/shop/".$a_idx);
			exit;
		}

		$data['query_string']="?";
		if($this->input->get("nologin")){ $data['query_string'].="&nologin=".$this->input->get("nologin"); }

		mt_srand((double)microtime()*1000000);
		$TRADE_CODE=chr(mt_rand(65, 90));
		$TRADE_CODE.=chr(mt_rand(65, 90));
		$TRADE_CODE.=chr(mt_rand(65, 90));
		$TRADE_CODE.=chr(mt_rand(65, 90));
		$TRADE_CODE.=chr(mt_rand(65, 90));
		$TRADE_CODE.=time();
		$data['TRADE_CODE'] = $TRADE_CODE;

		//2022 예치금 개발 추가 예치금 총액 산출
			if($this->session->userdata('USERID')){
				$deposit = $this->common_m->self_q("select sum(point) as dps from dh_deposit where userid = '".$this->session->userdata('USERID')."'","row");
				$data['total_deposit'] = $deposit->dps;
			}
		//2022 예치금 개발 추가 예치금 총액 산출

		$query = str_replace("c.","a.",$where_query);

		$tmp="";

		if($this->input->post("trade_code") && $this->input->post("name") && $this->input->post("tmp")==1 && !$this->input->post("tno") && $this->input->post("cart_code")){
			$tmp = 1;
			$code =  $this->input->post("cart_code",true);
		}

		if($sample_is == "ok"){
			$data['cart_list'] = $this->common_m->self_q("select *, (select list_img from dh_goods where idx = goods_idx) as list_img from dh_sample_cart where userid = '{$USERID}'","result");
		}
		else{

			$result = $this->order_m->getCart($code,$query);
			$data['cart_list'] = $result['list'];

			$limit_day = strtotime(date("Ymd",strtotime('+2 days')));

			//정기배송 일정 추출
			if($this->session->userdata('USERID')){
				$logged_userid = $this->session->userdata('USERID');
				$sql = "
					select * from dh_trade_deliv_info
					where userid = '{$logged_userid}'
					and deliv_stat = 0
					and recom_idx > 0
				";

				$jungki_list = $this->common_m->self_q($sql,"result");
				$jk_deliv_dates = array();
				foreach($jungki_list as $lt){
					$jk_deliv_dates[] = $lt->deliv_date;
				}
			}
			else{
				alert(cdir()."/dh_member/login","로그인 후 이용해 주세요");
			}

			/* 네이버 페이 결제 상품항목*/
			$naver_arr = array();
			$naver_cnt=0;
			foreach($data['cart_list'] as $lt){
				if($lt->option_cnt != 0){
					$data['option_arr'.$lt->idx] = $result['option_arr'.$lt->idx];
					for($ii=0;$ii<$lt->option_cnt;$ii++){
						$naver_arr[$naver_cnt]['uid'] = $lt->goods_idx;
						$naver_arr[$naver_cnt]['name'] = $lt->goods_name."-".$data['option_arr'.$lt->idx][$ii]['name'];
						$naver_arr[$naver_cnt]['count'] = $data['option_arr'.$lt->idx][$ii]['cnt'];
						$naver_cnt++;
					}
				}else{
					$naver_arr[$naver_cnt]['uid'] = $lt->goods_idx;
					$naver_arr[$naver_cnt]['name'] = $lt->goods_name;
					$naver_arr[$naver_cnt]['count'] = $lt->goods_cnt;
					$naver_cnt++;
				}
			}
			$data['naver_info'] = $naver_arr;
			/* 네이버페이END */

			$dp_arr = array();
			$cart_arr = array();

			foreach($data['cart_list'] as $lt){
				$data['option_arr'.$lt->idx] = $result['option_arr'.$lt->idx];

				if($lt->deliv_grp == "이유식"){
					$cart_arr[1]++;
					$dp_arr[$lt->date_bind][1]['deliv_date'] = $lt->date_bind;
					$dp_arr[$lt->date_bind][1]['ttp'] += $lt->total_price;

					if($lt->recom_is == "Y"){
						$dp_arr[$lt->date_bind][1]['dp'] = 0;
						$dp_arr[$lt->date_bind][1]['is_recom'] = "Y";
					}
					else if(in_array($dp_arr[$lt->date_bind][1]['deliv_date'],$jk_deliv_dates)){
						$dp_arr[$lt->date_bind][1]['dp'] = 0;
						$dp_arr[$lt->date_bind][1]['is_recom'] = "excep";
						$dp_arr[$lt->date_bind][1]['add_txt'] = date("Y년 m월 d일",strtotime($lt->date_bind))."<br>정기배송 일정에 포함";
					}
					else{
						if($dp_arr[$lt->date_bind][1]['is_recom'] == "Y" || $dp_arr[$lt->date_bind][1]['is_recom'] == "excep"){
							$dp_arr[$lt->date_bind][1]['dp'] = 0;
						}
						else{
							if($dp_arr[$lt->date_bind][1]['ttp'] >= $data['shop_info']['express_free']){
								$dp_arr[$lt->date_bind][1]['dp'] = 0;
							}
							else{
								$dp_arr[$lt->date_bind][1]['dp'] = $data['shop_info']['express_money'];
							}
						}
					}
				}
				else if($lt->deliv_grp == "간식"){
					$cart_arr[2]++;
					$dp_arr[$lt->date_bind][2]['deliv_date'] = $lt->date_bind;
					$dp_arr[$lt->date_bind][2]['ttp'] += $lt->total_price;
					if($dp_arr[$lt->date_bind][2]['ttp'] >= $data['shop_info']['express_free']){
						$dp_arr[$lt->date_bind][2]['dp'] = 0;
					}
					else{
						$dp_arr[$lt->date_bind][2]['dp'] = $data['shop_info']['express_money'];
					}
				}
				else if($lt->deliv_grp == "프로모션"){
					$cart_arr[3]++;
					$dp_arr[$lt->date_bind][3]['deliv_date'] = $lt->date_bind;
					$dp_arr[$lt->date_bind][3]['ttp'] += $lt->total_price;

					if($dp_arr[$lt->date_bind][3]['ttp'] >= $data['shop_info']['express_free']){
						$dp_arr[$lt->date_bind][3]['dp'] = 0;
					}
					else{
						$dp_arr[$lt->date_bind][3]['dp'] = $data['shop_info']['express_money'];
					}
				}
				else if($lt->deliv_grp == "프로모션2"){
					$cart_arr[4]++;
					$dp_arr[$lt->date_bind][4]['deliv_date'] = $lt->date_bind;
					$dp_arr[$lt->date_bind][4]['ttp'] += $lt->total_price;

					if($dp_arr[$lt->date_bind][4]['ttp'] >= $data['shop_info']['express_free']){
						$dp_arr[$lt->date_bind][4]['dp'] = 0;
					}
					else{
						$dp_arr[$lt->date_bind][4]['dp'] = $data['shop_info']['express_money'];
					}
				}
				else if($lt->deliv_grp == "합배송불가"){
					$cart_arr[5]++;
					$dp_arr[$lt->date_bind][5]['deliv_date'] = $lt->date_bind;
					$dp_arr[$lt->date_bind][5]['ttp'] += $lt->total_price;
					//$dp_arr[$lt->date_bind][5]['dp'] += $data['shop_info']['express_money'];

					if($lt->goods_idx == '878'){
						$dp_arr[$lt->date_bind][5]['dp'] += 0;
					}
					else{
						$dp_arr[$lt->date_bind][5]['dp'] += $data['shop_info']['express_money'];
					}
				}
				else if($lt->deliv_grp == "무료배송"){
					$cart_arr[6]++;
					$dp_arr[$lt->date_bind][6]['deliv_date'] = $lt->date_bind;
					$dp_arr[$lt->date_bind][6]['ttp'] += $lt->total_price;
					$dp_arr[$lt->date_bind][6]['dp'] = 0;
				}
				else if($lt->deliv_grp == "프로모션3"){
					$cart_arr[7]++;
					$dp_arr[$lt->date_bind][7]['deliv_date'] = $lt->date_bind;
					$dp_arr[$lt->date_bind][7]['ttp'] += $lt->total_price;

					if($dp_arr[$lt->date_bind][7]['ttp'] >= $data['shop_info']['express_free']){
						$dp_arr[$lt->date_bind][7]['dp'] = 0;
					}
					else{
						$dp_arr[$lt->date_bind][7]['dp'] = $data['shop_info']['express_money'];
					}
				}
			}

			$data['dp_arr'] = $dp_arr;
			$data['cart_arr'] = $cart_arr;

			if(count($data['cart_list']) <= 0 ){
				alert("/","구매하실 상품이 존재하지 않습니다.");
			}
		}

		$event_order_cnt=0;
		foreach($data['cart_list'] as $cart){
			if($cart->goods_idx == 543){
				//대구맘 중복주문 못하게
				$sql = "
					select count(idx) as cnt
					from dh_trade
					where userid = '".$this->session->userdata('USERID')."'
					and trade_stat in (1,2,3,4)
					and trade_code in (select trade_code from dh_trade_goods where goods_idx = '543')
				";
				$cnt = $this->common_m->self_q($sql,"row");
				if($cnt->cnt){
					alert("/","1회만 구매 가능한 상품입니다.\\n다른 맘님들을 위해 배려해 주세요.");
				}
				//대구맘 중복주문 못하게
			}

			if($cart->goods_idx == '584' || $cart->goods_idx == '585'){
				$event_order_cnt++;
			}
		}

		if($event_order_cnt>1){
			alert(cdir()."/dh_order/shop_cart","1개만 구매 가능한 상품이 있습니다. 장바구니를 초기화 합니다.");
		}

		$data['shop_info'] = $this->common_m->shop_info();
		$data['goods_info'] = $this->common_m->goods_info();

		//선택한 배송지로 자바여키
		$data['member_info'] = $this->common_m->self_q("select * from dh_member where userid = '{$USERID}'","row");

		//회원 등급별 적립금 차등 지급에 대한 로직 추가
		$member_level_info = $this->common_m->self_q("select * from dh_member_level where level = '".$data['member_info']->level."'","row");

		$data['reward_percent'] = $member_level_info->reward;

		if($this->session->userdata('USERID')){
			$data['userid'] = $this->session->userdata('USERID');
			$data['member_stat'] = $this->common_m->getRow("dh_member","where userid='".$this->db->escape_str($data['userid'])."'");
			if($sample_is != "ok"){
				$data['member_total_point'] = $this->common_m->getSum("dh_point","point","where userid='".$this->db->escape_str($data['userid'])."'");
				$nowdate = date("Y-m-d");
				$data['couponCnt'] = $this->common_m->getCount("dh_coupon_use","where userid='".$data['userid']."' and start_date <= '$nowdate' and end_date >= '$nowdate' and trade_code = ''");
				$data['couponList'] = $this->common_m->getList2("dh_coupon_use","where userid='".$data['userid']."' and start_date <= '$nowdate' and end_date >= '$nowdate' and trade_code = '' order by idx desc");
			}
		}

		$data['sample_is'] = $sample_is;	//샘플 신청 여부

		$data['bank_cnt'] = $this->common_m->getCount("dh_shop_info","where name like 'bank_name%'","idx"); //입금은행 총갯수
		$data['a_idx'] = $a_idx;

		$trade_code = $this->input->post("trade_code",true);

		if($tmp==1){ //tmp 넣기
			$result = $this->order_m->trade_tmp_add($trade_code,$data); //tmp에 넣기
			exit;
		}

		if($this->input->post("ordr_idxx") || $this->input->post("trade_code") || $this->input->post("tno") || $this->input->post('LGD_RESPCODE')){ //결제완료 검증 모델 로드 & 데이터 넣기

			$trade_code = $this->input->post("LGD_OID") ? $this->input->post("LGD_OID") : $this->input->post("trade_code") ;
			$trade_cnt = $this->common_m->getCount("dh_trade","where trade_code='{$trade_code}'","idx"); //거래 완료 디비에 값이 없는경우에만 새로 등록

			//결제 완료 시 의기양양 당첨자 DB trade_code변경
			$trade_cart_info = $this->common_m->self_q("select *,(select cate_no from dh_goods where idx=dh_cart.goods_idx) as cate_no from dh_cart where trade_code='".$this->input->post('trade_code')."'","result");
			foreach($trade_cart_info as $trade_cart_inf){
				if($trade_cart_inf->cate_no == "10"){
					$this->common_m->update2("dh_order_succ",array('trade_code'=>$this->input->post('trade_code')),array('userid'=>$this->session->userdata('USERID')));
				}
			}

			if($trade_cnt==0){
				$result = $this->order_m->trade($trade_code,$data); //실제데이터넣기
				if($result){
					result($result, "", cdir()."/dh_order/shop_order_ok/".$trade_code);
				}
			}else{
				alert(cdir()."/dh_order/shop_order_ok/".$trade_code);
			}

		}else{

			$data['payView']=$data['shop_info']['pg_company'];

			$data['view'] = $dir.$view;
			$url = $this->common_m->get_page($page);


			if($this->input->post("pay_ajax")==1){
				$url = "/order/".$data['payView']."_ajax";
			}

			$this->load->view($url,$data);

		}

	}

	public function shop_cart($data=''){

		$sample_is = $this->input->get('sample');
		$data['week_name_arr'] = array('일','월','화','수','목','금','토');

		if($sample_is == "ok"){	//샘플신청시

			$USERID = $this->session->userdata('USERID');

			$mode = $this->input->post('mode');

			$page = $this->uri->segment(2);
			$dir = $_SERVER['DOCUMENT_ROOT']."/html/application/views/order/";
			$view = "cart";

			$db_table = "dh_sample_cart";

			if($mode=="del"){
				$result = $this->common_m->del($db_table,"idx", $this->input->post("cart_idx",true));
				alert(cdir().'/dh_order/shop_cart/?sample=ok');
			}else if($mode=="allDel"){
				$frmCnt = $this->input->post("frmCnt");
				for($i=1;$i<=$frmCnt;$i++){
					if($this->input->post("idx".$i) && $this->input->post("chk".$i)==1){
						$result = $this->common_m->del($db_table,"idx", $this->input->post("idx".$i,true));
					}
				}
				alert(cdir().'/dh_order/shop_cart/?sample=ok');

			}

			$data['list'] = $this->common_m->self_q("select *, (select list_img from dh_goods where idx = goods_idx) as list_img from dh_sample_cart where userid = '{$USERID}'","result");

			$data['totalPrice'] = 0;
			$data['totalCnt'] = 1;
			$data['shop_info'] = $this->common_m->shop_info();
			$data['goods_info'] = $this->common_m->goods_info();
			$data['delivery_price'] = 3000;

		}
		else{	//샘플 신청 이외
			if(!$this->session->userdata('USERID')){
				alert(cdir()."/dh_member/login","로그인 후 이용 가능합니다.");
			}

			$cart_idx=$this->uri->segment(3,'');
			$page = $this->uri->segment(2);

			$dir = $_SERVER['DOCUMENT_ROOT']."/html/application/views/order/";

			$view = "cart";

			$mode = $this->input->post("mode");
			$goods_idx = $this->input->post("goods_idx");
			$code = $this->session->userdata('CART');
			$USERID = $this->session->userdata('USERID');
			$query_where = "";

			if($USERID){
				$query_where = " and userid='$USERID'";
			}else{
				$query_where = " and code='".$this->db->escape_str($code)."'";
			}


			//우선 장바구니의 배송일 만큼의 배송비가 부과되어야함.
			//배송비 정책은 통합으로 하는거 아니면 답 없을듯
			//장바구니에 담긴 배송일중 DB에 배송일이 겹치는 경우 배송비 무료 -
			//$deliv_date_cnt = $this->common_m->self_q("select * from dh_trade_deliv_info where userid = '{$USERID}' and deliv_date = ","cnt");
			//우선 DB 에 있는 배송일자 배열로 처리
			//2018-08-27 배송 스탯 쿼리 조건에 추가
			//			$db_deliv_sql = "
			//				select distinct deliv_date
			//				from dh_trade_deliv_info
			//				where userid = '{$USERID}'
			//				and deliv_date >= '".date("Y-m-d")."'
			//				and deliv_stat = 0
			//				and trade_code in (
			//					select trade_code
			//					from dh_trade
			//					where trade_code = dh_trade_deliv_info.trade_code
			//					and trade_stat between 2 and 3
			//					and trade_code not in (
			//						select trade_code
			//						from dh_trade_goods
			//						where goods_idx in (556,557)
			//					)
			//				)
			//				order by deliv_date asc
			//			";
			//			$db_deliv_date = $this->common_m->self_q($db_deliv_sql,"result");
			//			$db_dv_date_arr = array();
			//			foreach($db_deliv_date as $db){
			//				$db_dv_date_arr[] = $db->deliv_date;
			//			}

			//삭제 이후 카트 전체적으로 한번 돌려서 배송비 업데이트 해봄
			//장바구니 로딩시마다 업데이트 쳐줌
			// 체크박스 아작스에서 업데이트 치는거 땜에 문제됨
			/*
			$uls_sql="
				select userid, date_bind, sum(total_price) as group_sum_price, sum(recom_idx) as recom_is, goods_idx
				from dh_cart
				where trade_ok <> 1 and userid = '{$USERID}'
				group by date_bind
			";

			$cart_deliv_price_update_list = $this->common_m->self_q($uls_sql,"result");
			foreach($cart_deliv_price_update_list as $uls){
				if($uls->group_sum_price >= $data['shop_info']['express_free'] or in_array($uls->date_bind,$db_dv_date_arr) or $uls->recom_is > 0){
					$result = $this->common_m->self_q("update dh_cart set deliv_price = 0 where trade_ok <> 1 and userid = '".$uls->userid."' and date_bind = '".$uls->date_bind."'","update");
				}
				else{
					$result = $this->common_m->self_q("update dh_cart set deliv_price = '".$data['shop_info']['express_money']."' where trade_ok <> 1 and userid = '".$uls->userid."' and date_bind = '".$uls->date_bind."'","update");
				}
			}
			*/

			if($mode=="del"){
				$result = $this->common_m->del("dh_cart","idx", $this->input->post("cart_idx"));
				$result = $this->common_m->del("dh_cart_option","cart_idx", $this->input->post("cart_idx"));
				alert(cdir().'/dh_order/shop_cart');
			}
			else if($mode=="allDel"){
				$frmCnt = count($this->input->post("cart_idx"));
				for($i=1;$i<=$frmCnt;$i++){
					if($this->input->post("idx".$i) && $this->input->post("chk".$i)==1){
						$result = $this->common_m->del("dh_cart","idx", $this->input->post("idx".$i,true));
						$result = $this->common_m->del("dh_cart_option","cart_idx", $this->input->post("idx".$i,true));
					}
				}
				alert(cdir().'/dh_order/shop_cart');
			}
			else if($mode == "cart_cnt_update"){
				$where['idx'] = $this->input->post('cart_idx');

				$update['goods_cnt'] = $this->input->post('goods_cnt');
				$update['total_price'] = $this->input->post('total_price');

				$result = $this->common_m->update2("dh_cart",$update,$where);
				alert(cdir()."/dh_order/shop_cart");
			}

			/*
			else if($cart_idx){
				$result = $this->order_m->cartMove($cart_idx,'wish','cart');
				alert(cdir().'/dh_order/shop_cart');
				exit;
			}
			else	if($goods_idx){
				$result = $this->order_m->cart($goods_idx,$code);
				alert(cdir().'/dh_order/shop_cart');
			}
			*/

			//485 산골농부 계정당 1회 구매제한
			//$cnt = $this->common_m->self_q("select * from dh_cart where goods_idx = '543' and userid = '{$USERID}' and trade_ok != '1'","cnt");
			$cnt = $this->common_m->self_q("select * from dh_trade where trade_stat in (1,2,3,4) and trade_code in (select trade_code from dh_trade_goods where goods_idx = '855') and userid = '{$USERID}'","cnt");
			$data['orderable_485'] = true;
			if($cnt > 1){
				$data['orderable_485'] = false;
			}

			$result = $this->order_m->getCart($code);

			//$cart_deliv_date_arr = array();

			$data['list'] = $result['list'];

			//			//의기양양픽 합배송 불가하게 처리
			//			if(count($data['list']) > 1){
			//				foreach($data['list'] as $hdl){
			//					if($hdl->goods_idx == "584" || $hdl->goods_idx == "585"){
			//						$this->common_m->self_q("delete from dh_cart where trade_ok <> 1 and goods_idx in (584,585) and userid = '{$USERID}'","delete");
			//						alert("/html/dh_order/shop_cart","합배송이 불가한 제품이 있어 장바구니에서 삭제하였습니다.");
			//					}
			//				}
			//			}
			//
			//			//오산골농부 합배송 불가하게 처리
			//			if(count($data['list']) > 1){
			//				foreach($data['list'] as $hdl){
			//					if($hdl->goods_idx == "583"){
			//						$this->common_m->self_q("delete from dh_cart where trade_ok <> 1 and goods_idx = '583' and userid = '{$USERID}'","delete");
			//						alert("/html/dh_order/shop_cart","합배송이 불가한 제품이 있어 장바구니에서 삭제하였습니다.");
			//					}
			//				}
			//			}
			//
			//			if(count($data['list']) > 1){
			//				foreach($data['list'] as $lt){
			//					//2020년 추석이벤트제품 주문시 합배송 불가하게 처리
			//					if($lt->goods_idx == "586"){
			//						$this->common_m->self_q("delete from dh_cart where trade_ok <> 1 and goods_idx = '586' and userid = '{$USERID}'","delete");
			//						alert("/html/dh_order/shop_cart","합배송이 불가한 제품이 있어 장바구니에서 삭제하였습니다.");
			//					}
			//				}
			//			}

			/**************************************************************************************

				2020년 11월 6일 추가 개발 패치후 1일차

				- 정기배송 일정이 있는 사용자가 낱개 주문시 해당 배송일정에 포함된 배송일을 선택한경우
				배송비를 제거하고 주문시 주소를 변경할 수 없도록 변경한다.


			**************************************************************************************/

			//정기배송 일정 추출
			if($this->session->userdata('USERID')){
				$logged_userid = $this->session->userdata('USERID');
				$sql = "
					select * from dh_trade_deliv_info
					where userid = '{$logged_userid}'
					and deliv_stat = 0
					and recom_idx > 0
				";

				$jungki_list = $this->common_m->self_q($sql,"result");
				$jk_deliv_dates = array();
				foreach($jungki_list as $lt){
					$jk_deliv_dates[] = $lt->deliv_date;
				}
			}
			else{
				alert(cdir()."/dh_member/login","로그인 후 이용해 주세요");
			}

			$dp_arr = array();
			$cart_arr = array();

			foreach($data['list'] as $lt){

				if($lt->goods_idx == "855"){
					$cnt++;
				}

				$data['option_arr'.$lt->idx] = $result['option_arr'.$lt->idx];
				//$cart_deliv_date_arr[$lt->date_bind] = $lt->date_bind;

				if($lt->deliv_grp == "이유식"){
					$cart_arr[1]++;
					$dp_arr[$lt->date_bind][1]['deliv_date'] = $lt->date_bind;
					$dp_arr[$lt->date_bind][1]['ttp'] += $lt->total_price;

					if($lt->recom_is == "Y"){
						$dp_arr[$lt->date_bind][1]['dp'] = 0;
						$dp_arr[$lt->date_bind][1]['is_recom'] = "Y";
					}
					else if(in_array($dp_arr[$lt->date_bind][1]['deliv_date'],$jk_deliv_dates)){
						$dp_arr[$lt->date_bind][1]['dp'] = 0;
						$dp_arr[$lt->date_bind][1]['is_recom'] = "excep";
						$dp_arr[$lt->date_bind][1]['add_txt'] = date("Y년 m월 d일",strtotime($lt->date_bind))."<br>정기배송 일정에 포함";
					}
					else{
						if($dp_arr[$lt->date_bind][1]['is_recom'] == "Y" || $dp_arr[$lt->date_bind][1]['is_recom'] == "excep"){
							$dp_arr[$lt->date_bind][1]['dp'] = 0;
						}
						else{
							if($dp_arr[$lt->date_bind][1]['ttp'] >= $data['shop_info']['express_free']){
								$dp_arr[$lt->date_bind][1]['dp'] = 0;
							}
							else{
								$dp_arr[$lt->date_bind][1]['dp'] = $data['shop_info']['express_money'];
							}
						}
					}
				}
				else if($lt->deliv_grp == "간식"){
					$cart_arr[2]++;
					$dp_arr[$lt->date_bind][2]['deliv_date'] = $lt->date_bind;
					$dp_arr[$lt->date_bind][2]['ttp'] += $lt->total_price;
					if($dp_arr[$lt->date_bind][2]['ttp'] >= $data['shop_info']['express_free']){
						$dp_arr[$lt->date_bind][2]['dp'] = 0;
					}
					else{
						$dp_arr[$lt->date_bind][2]['dp'] = $data['shop_info']['express_money'];
					}
				}
				else if($lt->deliv_grp == "프로모션"){
					$cart_arr[3]++;
					$dp_arr[$lt->date_bind][3]['deliv_date'] = $lt->date_bind;
					$dp_arr[$lt->date_bind][3]['ttp'] += $lt->total_price;

					if($dp_arr[$lt->date_bind][3]['ttp'] >= $data['shop_info']['express_free']){
						$dp_arr[$lt->date_bind][3]['dp'] = 0;
					}
					else{
						$dp_arr[$lt->date_bind][3]['dp'] = $data['shop_info']['express_money'];
					}
				}
				else if($lt->deliv_grp == "프로모션2"){
					$cart_arr[4]++;
					$dp_arr[$lt->date_bind][4]['deliv_date'] = $lt->date_bind;
					$dp_arr[$lt->date_bind][4]['ttp'] += $lt->total_price;

					if($dp_arr[$lt->date_bind][4]['ttp'] >= $data['shop_info']['express_free']){
						$dp_arr[$lt->date_bind][4]['dp'] = 0;
					}
					else{
						$dp_arr[$lt->date_bind][4]['dp'] = $data['shop_info']['express_money'];
					}
				}
				else if($lt->deliv_grp == "합배송불가"){
					$cart_arr[5]++;
					$dp_arr[$lt->date_bind][5]['deliv_date'] = $lt->date_bind;
					$dp_arr[$lt->date_bind][5]['ttp'] += $lt->total_price;

					if($lt->goods_idx == '878'){
						$dp_arr[$lt->date_bind][5]['dp'] += 0;
					}
					else{
						$dp_arr[$lt->date_bind][5]['dp'] += $data['shop_info']['express_money'];
					}
				}
				else if($lt->deliv_grp == "무료배송"){
					$cart_arr[6]++;
					$dp_arr[$lt->date_bind][6]['deliv_date'] = $lt->date_bind;
					$dp_arr[$lt->date_bind][6]['ttp'] += $lt->total_price;
					$dp_arr[$lt->date_bind][6]['dp'] = 0;
				}
				else if($lt->deliv_grp == "프로모션3"){
					$cart_arr[7]++;
					$dp_arr[$lt->date_bind][7]['deliv_date'] = $lt->date_bind;
					$dp_arr[$lt->date_bind][7]['ttp'] += $lt->total_price;

					if($dp_arr[$lt->date_bind][7]['ttp'] >= $data['shop_info']['express_free']){
						$dp_arr[$lt->date_bind][7]['dp'] = 0;
					}
					else{
						$dp_arr[$lt->date_bind][7]['dp'] = $data['shop_info']['express_money'];
					}
				}
			}

			if($cnt > 1){
				//alert("");
			}

			if($_SERVER['HTTP_X_FORWARDED_FOR'] == "58.229.223.174"){
				//pr($dp_arr);
			}

			$data['dp_arr'] = $dp_arr;
			$data['cart_arr'] = $cart_arr;

			if($USERID){
				$where_query = " and userid='$USERID'";
			}else{
				$where_query = " and code='".$this->db->escape_str($code)."'";
			}

			/*
			if($USERID){
				$where_query = " and c.userid='$USERID'";
			}else{
				$where_query = " and c.code='".$this->db->escape_str($code)."'";
			}
			$data['totalPrice'] = $this->common_m->getSum("dh_cart c, dh_goods g","c.total_price","where c.goods_idx=g.idx and c.trade_ok!='1' $where_query ");
			$data['totalPoint'] = $this->common_m->getSum("dh_cart c, dh_goods g","c.goods_point","where c.goods_idx=g.idx and c.trade_ok!='1' $where_query ");
			$data['totalCnt'] = $this->common_m->getCount("dh_cart c, dh_goods g","where c.goods_idx=g.idx and c.trade_ok!='1' $where_query ");
			*/

			//$data['totalPrice'] = $this->common_m->getSum("dh_cart","total_price","where trade_ok!='1' $where_query ");
			//$data['totalPoint'] = $this->common_m->getSum("dh_cart","c.goods_point","where c.goods_idx=g.idx and c.trade_ok!='1' $where_query ");
			//$data['totalCnt'] = $this->common_m->getSum("dh_cart","idx","where trade_ok!='1' $where_query ");
			$data['shop_info'] = $this->common_m->shop_info();
			$data['goods_info'] = $this->common_m->goods_info();

			//pr($data['goods_info']);

			/*
			//배송비 구하기
			$basic=0;
			if($data['totalCnt']==1){ //단일상품일때 상품정책

				if($USERID){
					$query_where = " and c.userid='$USERID'";
				}else{
					$query_where = " and c.code='".$this->db->escape_str($code)."'";
				}

				$cart_stat = $this->common_m->getRow3("dh_cart c, dh_goods g","where c.goods_idx=g.idx $query_where","g.express_no_basic,g.express_check,g.express_money,g.express_free");

				if($cart_stat->express_no_basic==1){ //배송 기본정책 미사용
					if($cart_stat->express_check==1){ //일반배송 일때
						if($data['totalPrice'] >= $cart_stat->express_free){ //총 구매액이 지정한도 이상이면 무료배송
							$data['delivery_price'] = 0;
						}else{
							$data['delivery_price'] = $cart_stat->express_money;
						}
					}else{ //무료배송 일때
						$data['delivery_price'] = 0;
					}
				}else{
					$basic=1;
				}
			}

			if($data['totalCnt']>1 || $basic==1){ //한개 이상일때 or 제품 기본정책 사용일때
				if($data['shop_info']['express_check']==1){ //일반배송 일때
					if($data['totalPrice'] >= $data['shop_info']['express_free']){ //총 구매액이 지정한도 이상이면 무료배송
						$data['delivery_price'] = 0;
					}else{
						if(!$data['shop_info']['express_money']){ $data['shop_info']['express_money'] = 0; }
						$data['delivery_price'] = $data['shop_info']['express_money'];
					}
				}else{ //무료배송 일때
					$data['delivery_price'] = 0;
				}
			}


			if($data['totalCnt']==0){ $data['delivery_price'] = 0;}


			$data['db_dv_date_arr'] = $db_dv_date_arr;

			$data['delivery_price'] = 0;

			$deliv_add_yn = $this->common_m->self_q("select date_bind , sum(total_price) as group_sum_price, max(deliv_price) as deliv_price from dh_cart where userid = '{$USERID}' and trade_ok != '1' group by date_bind order by deliv_price desc","result");
			//echo "select date_bind , sum(total_price) as group_sum_price, recom_is, deliv_price from dh_cart where userid = '{$USERID}' and trade_ok != '1' group by date_bind";

			//pr($deliv_add_yn);
			//pr($db_dv_date_arr);

			foreach($deliv_add_yn as $dayn){
				$data['delivery_price'] += $dayn->deliv_price;
			}
			*/

			//장바구니 배송일도 배열로 만들까?
			//이거 나중에 처리 해야겠닼
			//배송일 별 배송비 부과 & 배송일별 금액 카운트해서 8만원 이상이면 무료배송 시켜야됨
			//$cart_deliv_date_arr = array();
			/*
			foreach($data['list'] as $cart){
				//$cart_deliv_date_arr[] = $cart->date_bind;
				if(strpos($db_dv_date_arr,$cart->date_bind)!==false){
					$data['delivery_price'] = 0;
				}
				else{
					$d_bind_tprice = $this->common_m->self_q("select sum(total_price) as total_price from dh_cart where date_bind = '".$cart->date_bind."' and trade_ok != 1","row");

					if($d_bind_tprice->total_price >= $data['shop_info']['express_free'] ){
						$data['delivery_price'] = 0;
					}
					else{
						$data['delivery_price'] = $data['shop_info']['express_money'];
						$data['delivery_price_date'] .= $cart->date_bind."/";
					}
				}
			}
			*/

		}

		$data['view'] = $dir.$view;

		//pr($data);

		$url = $this->common_m->get_page($page);
		$this->load->view($url,$data);
	}

	/*
	public function shop_cart($data=''){
		$cart_idx=$this->uri->segment(3,'');
		$page = $this->uri->segment(2);
		$dir = $_SERVER['DOCUMENT_ROOT']."/html/application/views/order/";
		$view = "cart";

		if($_POST){
			$mode = $this->input->post('mode');
			if($mode == "cnt_update"){
				$db_table = "dh_shop_cart";
				$where['idx'] = $this->input->post('cart_idx');
				$update['goods_cnt'] = $this->input->post('goods_cnt');
				$result = $this->common_m->update2($db_table,$update,$where);
			}

			if($result){
				alert(cdir()."/dh_order/shop_cart");
			}
		}

		//장바구니 호출 정보
		$userid = $this->session->userdata('USERID');
		$data['list'] = $this->common_m->self_q("select * , (select list_img from dh_goods where idx = goods_idx) as list_img from dh_shop_cart where userid = '{$userid}'","result");

		$cart_total_price = 0;
		foreach($data['list'] as $row){
			$cart_total_price += $row->goods_price*$row->cnt;
		}

		$data['express_free'] = $shop_info['express_free'];
		$data['express_money'] = $shop_info['express_money'];

		$data['view'] = $dir.$view;
		$url = $this->common_m->get_page($page);
		$this->load->view($url,$data);
	}
	*/

	public function wishlist($data='')
	{
		$cart_idx=$this->uri->segment(3,'');
		$page = $this->uri->segment(2);


		$dir = $_SERVER['DOCUMENT_ROOT']."/html/application/views/order/";

		$view = "cart";

		$mode = $this->input->post("mode");
		$goods_idx = $this->input->post("goods_idx");


		$userid = $this->session->userdata('USERID');
		if(!$userid){
			alert(cdir().'/dh_order/order_login/wishlist/'.$goods_idx,'로그인이 필요합니다.');
			exit;
		}


		if($mode=="del"){
			$result = $this->common_m->del("dh_wishlist","idx", $this->input->post("wishlist_idx",true));
			$result = $this->common_m->del("dh_wishlist_option","wishlist_idx", $this->input->post("wishlist_idx",true));
			alert(cdir().'/dh_order/wishlist');
		}else if($mode=="allDel"){
			$frmCnt = $this->input->post("frmCnt");
			for($i=1;$i<=$frmCnt;$i++){
				if($this->input->post("idx".$i) && $this->input->post("chk".$i)==1){
					$result = $this->common_m->del("dh_wishlist","idx", $this->input->post("idx".$i,true));
					$result = $this->common_m->del("dh_wishlist_option","wishlist_idx", $this->input->post("idx".$i,true));
				}
			}
			alert(cdir().'/dh_order/wishlist');

		}else	if($goods_idx){
			$result = $this->order_m->cart($goods_idx,'','','wish');
			alert(cdir().'/dh_order/wishlist');
		}else if($cart_idx){
			$result = $this->order_m->cartMove($cart_idx,'cart','wish');
			alert(cdir().'/dh_order/wishlist');
			exit;
		}

		$result = $this->order_m->getCart('','','wish',$userid);

		$data['list'] = $result['list'];
		foreach($data['list'] as $lt){
			$data['option_arr'.$lt->idx] = $result['option_arr'.$lt->idx];
		}


		$view = "wishlist";
		$data['view'] = $dir.$view;
		$url = $this->common_m->get_page($page);
		$this->load->view($url,$data);
	}



	public function order_login($data='')
	{
		$mode=$this->uri->segment(3,'');
		$idx=$this->uri->segment(4,'');
		$idx_arr = explode("a",$idx);

		if($mode=="shop"){
			$data['go_url'] = cdir()."/dh_order/shop_order/".$idx;
			$dir = $_SERVER['DOCUMENT_ROOT']."/html/application/views/member/";
			$view = "login";
		}else if($mode=="wishlist"){
			$data['go_url'] = cdir()."/dh_order/wishlist/".$idx;
			$dir = $_SERVER['DOCUMENT_ROOT']."/html/application/views/member/";
			$view = "login";
		}

		$data['view'] = $dir.$view;
		$this->load->view('/html/login', $data);

	}


	public function shop_order_ok($data='')
	{
		$page=$this->uri->segment(2,'');
		$trade_code=$this->uri->segment(3,'');
		$trade_cnt = $this->common_m->getCount("dh_trade","where trade_code='$trade_code'","idx");
		$data['goods_info'] = $this->common_m->goods_info();
		$data['week_name_arr'] = array('일','월','화','수','목','금','토');

		if($trade_cnt > 0){

			$data['trade_code'] = $trade_code;
			$data['trade_stat'] = $this->common_m->getRow2("dh_trade","where trade_code='".$this->db->escape_str($trade_code)."' order by idx desc limit 1");

			$result = $this->order_m->getTradeOption($trade_code);
			$data['goods_list'] = $result['goods_list'];
			foreach($data['goods_list'] as $lt){
				$data['option_arr'.$lt->idx] = $result['option_arr'.$lt->idx];
			}

			if($data['trade_stat']->userid && $data['trade_stat']->coupon_idx){
				$data['coupon_stat'] = $this->common_m->getRow2("dh_coupon_use","where idx='".$this->db->escape_str($data['trade_stat']->coupon_idx)."'");
			}

			$view="order_ok";

			$dir = $_SERVER['DOCUMENT_ROOT']."/html/application/views/order/";
			$data['view'] = $dir.$view;
			$url = $this->common_m->get_page($page);
			$this->load->view($url,$data);

		}else{
			back("잘못된 접근입니다.");
		}

	}


	public function pay_error($data='')
	{
		$dir = $_SERVER['DOCUMENT_ROOT']."/html/application/views/order/";
		$data['view'] = $dir."order_error";
		$this->load->view("/html/shop_order_error",$data);
	}


	public function orderList($data='')
	{
		if(!$this->session->userdata('USERID')){ //비로그인시 로그인 화면으로
			//alert(cdir().'/dh_member/login/?go_url='.$_SERVER['PHP_SELF']);
			//exit;
			$this->load->view("/html/please_login",$data);
		}

		$page=$this->uri->segment(2,'');
		$return=$this->uri->segment(3,'order');
		$search_day = $this->input->get("search_day");

		$userid = $this->session->userdata('USERID');
		$where_query=" where userid='$userid'";

		$order_query="idx desc";
		$data['query_string']="?";

		$data['param'] = "";
		if($this->input->get("PageNumber")){
			$data['param'] = "&PageNumber=".$this->input->get("PageNumber");
		}

		if($return=="return"){
			$where_query .= " and trade_stat > 4";
		}else{
			$where_query .= " and trade_stat < 5";
		}

		switch($search_day)
		{
			case 1 : $date = date("Y-m-d",strtotime("-15 day",strtotime(date("Y-m-d"))))." 00:00:00"; $where_query.=" and trade_day > '".$date."'"; break;
			case 2 : $date = date("Y-m-d",strtotime("-1 month",strtotime(date("Y-m-d"))))." 00:00:00"; $where_query.=" and trade_day > '".$date."'"; break;
			case 3 : $date = date("Y-m-d",strtotime("-3 month",strtotime(date("Y-m-d"))))." 00:00:00"; $where_query.=" and trade_day > '".$date."'"; break;
			case 4 : $date = date("Y-m-d",strtotime("-3 month",strtotime(date("Y-m-d"))))." 00:00:00"; $where_query.=" and trade_day < '".$date."'"; break;
			default : $date=""; break;
		}

		/* 페이징 start */
		$PageNumber = $this->input->get("PageNumber"); //현재 페이지
		if(!$PageNumber){ $PageNumber = 1; }
		$list_num='10'; //페이지 목록개수
		$page_num='5'; //페이징 개수
		$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
		$url = cdir()."/".$this->uri->segment(1)."/".$page."/".$return;
		$data['totalCnt'] = $this->common_m->getPageList('dh_trade','count','','',$where_query,$order_query); //게시판 리스트
		$data['Page'] = Page($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
		$data['listNo'] = $data['totalCnt'] - $list_num*($PageNumber-1);
		/* 페이징 end */

		//$data['list'] = $this->common_m->getPageList('dh_trade','',$offset,$list_num,$where_query,$order_query,"*,(select count(idx) from dh_trade_goods where trade_code=dh_trade.trade_code) as cnt,(select goods_name from dh_trade_goods where trade_code=dh_trade.trade_code order by idx asc limit 1) as goods_name,(select goods_idx from dh_trade_goods where trade_code=dh_trade.trade_code order by idx asc limit 1) as goods_idx,(select idx from dh_trade_goods where trade_code=dh_trade.trade_code order by idx asc limit 1) as trade_goods_idx,(select review from dh_trade_goods where trade_code=dh_trade.trade_code order by idx asc limit 1) as review"); //게시판 리스트

		$data['list'] = $this->common_m->self_q("select * from dh_trade where userid = '".$this->session->userdata('USERID')."' order by trade_day desc limit {$offset}, {$list_num}","result");
		$data['week_name_arr'] = array('일','월','화','수','목','금','토');

		/* 제품 데이터 end */


		$view=$return."_list";

		$dir = $_SERVER['DOCUMENT_ROOT']."/html/application/views/order/";
		$data['view'] = $dir.$view;
		$url = $this->common_m->get_page($page);
		$this->load->view($url,$data);
	}


	public function shop_order_detail($data='')
	{
		$page=$this->uri->segment(2,'');
		$data['query_string']="?";

		$data['param'] = "";
		if($this->input->get("PageNumber")){
			$data['param'] = "&PageNumber=".$this->input->get("PageNumber");
		}

		$trade_code=$this->uri->segment(3,'');
		$trade_cnt = $this->common_m->getCount("dh_trade","where trade_code='$trade_code'","idx");
		if($trade_cnt > 0){

			if(!$this->session->userdata('USERID')){
				if(!$this->input->post('trade_code') && !$this->input->post('email')){
					back("잘못된 접근입니다.");
					exit;
				}

				$trade_cnt = $this->common_m->getCount("dh_trade","where trade_code='".$this->db->escape_str($this->input->post('trade_code',true))."' and email='".$this->db->escape_str($this->input->post('email',true))."'","idx");
				if($trade_cnt==0){
					back("존재하지 않는 주문코드 또는 이메일 입니다.\\n 다시한번 확인해주세요.");
					exit;
				}
			}

			$data['trade_code'] = $trade_code;
			$data['trade_stat'] = $this->common_m->getRow2("dh_trade","where trade_code='".$this->db->escape_str($trade_code)."' order by idx desc limit 1");

			if($data['trade_stat']->delivery_idx){
				$data['delivery_row'] = $this->common_m->getRow("dh_shop_info","where name = 'delivery_idx".$data['trade_stat']->delivery_idx."' and val!=''");
				$delivery_name_no = str_replace("delivery_idx","",$data['delivery_row']->name);
				$data['delivery_url_row'] = $this->common_m->getRow("dh_shop_info","where name='delivery_url".$delivery_name_no."'");
			}

			$result = $this->order_m->getTradeOption($trade_code);
			$data['goods_list'] = $result['goods_list'];
			foreach($data['goods_list'] as $lt){
				$data['option_arr'.$lt->idx] = $result['option_arr'.$lt->idx];
			}

			if($data['trade_stat']->userid && $data['trade_stat']->coupon_idx){
				$data['coupon_stat'] = $this->common_m->getRow2("dh_coupon_use","where idx='".$this->db->escape_str($data['trade_stat']->coupon_idx)."'");
			}

			$data['day7'] = date("Y-m-d",strtotime("+7 day",strtotime($data['trade_stat']->delivery_day)));

			$data['week_name_arr'] = array('일','월','화','수','목','금','토');

			//회원정보
			$data['member_stat'] = $this->common_m->self_q("select * from dh_member where userid = '".$this->session->userdata('USERID')."'","row");

			//배송정보 리스트
			$deliv_info_sql = "
				select a.*, (select count(idx) from dh_trade_deliv_log where deliv_code = a.deliv_code) as log_count
				from dh_trade_deliv_info a
				where a.trade_code = '{$trade_code}'
				order by a.deliv_date asc
			";
			$data['deliv_info'] = $this->common_m->self_q($deliv_info_sql,"result");

			//785471
			//785472

			$deliv_list_sql = "
				select a.*, b.total_price
				from dh_trade_deliv_prod a left join dh_trade_goods b on a.tg_idx = b.idx
				where a.trade_code = '{$trade_code}'
				order by a.idx desc
			";
			//echo $deliv_list_sql;

			$data['deliv_list'] = $this->common_m->self_q($deliv_list_sql,"result");
			$data['deliv_stat_arr'] = array('0'=>'배송대기','1'=>'배송준비중','2'=>'배송중','3'=>'배송완료','4'=>'중지','5'=>'취소','6'=>'배송휴무','7'=>'조기마감');

			//주문내역에 로그가 있는지 확인
			//$data['log_cnt'] = $this->common_m->self_q("select * from dh_trade_deliv_log where deliv_code like '{$trade_code}%'","cnt");

			$data['goods_info'] = $this->common_m->goods_info();

			$data['option_list'] = $this->common_m->self_q("select * from dh_trade_goods_option where trade_code = '{$trade_code}' and level = '2'","result");

			//배송정보
			$deliv_prod_info = array();
			//		$_deliv_prod = $this->common_m->self_q("select * from dh_trade_deliv_prod where trade_code = '{$trade_code}'","result");
			//		$_deliv_info = $this->common_m->self_q("select * from dh_trade_deliv_info where trade_code = '{$trade_code}'","result");
			//		$_goods = $this->common_m->self_q("select * from dh_trade_goods where trade_code = '{$trade_code}'","result");
			//		$_goods_option = $this->common_m->self_q("select * from dh_trade_goods_option where trade_code = '{$trade_code}' and level = '2'","result");
			//		$_trade = $this->common_m->self_q("select * from dh_trade where trade_code = '{$trade_code}'","result");
			//		$_goods_info = $this->common_m->self_q("select * from dh_goods","result");
			//
			//		//$data['deliv_prod'] = $_deliv_prod;
			//		foreach($_deliv_prod as $dp){
			//
			//			//$deliv_prod_info[$dp->deliv_date]['goods_idx'] = $dp->goods_idx;
			//			$deliv_prod_info[$dp->deliv_date][$dp->goods_idx]['prod_cnt'] = $dp->prod_cnt;
			//
			//
			//
			//			foreach($_goods as $g){
			//				if($g->goods_idx == 0){
			//					foreach($_goods_info as $gi){
			//						if($dp->goods_idx == $gi->idx){
			//							$deliv_prod_info[$dp->deliv_date][$gi->idx]['name'] = $gi->name;
			//							//$deliv_prod_info[$dp->deliv_date][$gi->idx]['recom'] = "[추천식단]";
			//						}
			//					}
			//				}
			//
			//				if($dp->goods_idx == $g->goods_idx){
			//					$deliv_prod_info[$dp->deliv_date][$g->goods_idx]['name'] = $g->goods_name;
			//					$deliv_prod_info[$dp->deliv_date][$g->goods_idx]['goods_cnt'] = $g->goods_cnt;
			//					$deliv_prod_info[$dp->deliv_date][$g->goods_idx]['goods_price'] = $g->goods_price;
			//
			//					if($g->option_cnt > 0){
			//						foreach($_goods_option as $go){
			//							$deliv_prod_info[$dp->deliv_date][$dp->goods_idx]['option_name'] = $go->title." : ".$go->name;
			//							$deliv_prod_info[$dp->deliv_date][$dp->goods_idx]['option_cnt'] = $go->cnt;
			//							$deliv_prod_info[$dp->deliv_date][$dp->goods_idx]['option_price'] = $go->price;
			//						}
			//					}
			//				}
			//			}
			//
			//		}
			//
			//		pr($deliv_prod_info);
			$view="order_view";

			$dir = $_SERVER['DOCUMENT_ROOT']."/html/application/views/order/";
			$data['view'] = $dir.$view;
			$url = $this->common_m->get_page($page);
			$this->load->view($url,$data);

		}else{
			back("존재하지 않는 주문코드입니다.");
			exit;
		}


	}


	public function shop_order_cancel($data='')
	{
		$trade_code=$this->uri->segment(3,'');
		$mode=$this->uri->segment(4,'list');
		$query_string="?";
		$result="";

		$param = "";
		if($this->input->get("PageNumber")){
			$param = "&PageNumber=".$this->input->get("PageNumber");
		}

		$trade_cnt = $this->common_m->getCount("dh_trade","where trade_code='".$this->db->escape_str($trade_code)."'","idx");
		if($trade_cnt > 0){
			$trade_stat = $this->common_m->getRow("dh_trade","where trade_code='".$this->db->escape_str($trade_code)."'");

			$flag = explode("a1a1",$this->input->post("go_url"));

			if(isset($flag[1]) && $flag[1]){
			$flag = $flag[1];
			$adminPage = explode("&PageNumber=",$this->input->post("go_url"));
			if(isset($adminPage[1]) && $adminPage[1]){
				$adminPage = $adminPage[1];
			}else{
				$adminPage = 1;
			}
			}else{
				$flag = "";
			}

			if($trade_stat->userid && ($trade_stat->userid != $this->session->userdata('USERID')) && $flag!="admin"){
				alert('/','잘못된 접근입니다.');
				exit;
			}

			$result = "1";

			if( ($trade_stat->trade_method==1 && $trade_stat->trade_stat==2) || ( $trade_stat->trade_method==4  && $trade_stat->trade_stat==1 ) || ($trade_stat->trade_method==1 && $flag=="admin")){ //카드 결제 or 가상계좌 일때

				//$result = $this->order_m->{$data['shop_info']['pg_company']."_cancel"}($trade_code);

				if($flag=="admin" && $result){
					alert(cdir()."/order/lists/".$trade_stat->trade_stat."/m/?PageNumber=".$adminPage."&change_idx=".$trade_stat->idx."&change_stat=9&admin=1");
					exit;
				}

			}else if($trade_stat->trade_method==2 && $trade_stat->trade_stat==1){
				$result = 1;
			}else if($trade_stat->trade_method == 5 and ($trade_stat->trade_stat == 1 or $trade_stat->trade_stat == 2) ){
				$result = 1;
			}

			if($result){


				$result2 = $this->common_m->update2("dh_trade",array('trade_stat'=>9,'trade_day_cancel'=>timenow()),array("trade_code"=>$trade_code));

				if($result2){

					//					$log_data['userid'] = $this->session->userdata('USERID');
					//					$log_data['type'] = "주문취소";
					//					$log_data['msg'] = "주문번호 : ".$trade_code." 주문 취소";
					//					$log_data['deliv_code'] = $trade_code."-".strtotime();
					//					$log_data['wdate'] = timenow();
					//					$log_data['writer'] = "본인";
					//					$result = $this->common_m->insert2("dh_trade_deliv_log",$log_data);

					if($trade_stat->userid && $trade_stat->use_point > 0){ //포인트 사용했다면 다시 되돌리기
						$content = "상품구매사용 주문취소[".$trade_stat->trade_code."]";
						$arrays = array('userid'=>$trade_stat->userid,'point'=>$trade_stat->use_point,'content'=>$content,'flag'=>'trade','flag_idx'=>$trade_stat->idx,'trade_code'=>$trade_code,'reg_date'=>date("Y-m-d H:i:s"));
						$this->member_m->point_insert($arrays);
					}

					if($trade_stat->trade_stat==4 && $trade_stat->userid && $trade_stat->save_point > 0){ //포인트 적립되었다면 포인트 차감	-
						$content = "상품구매적립 주문취소[".$trade_stat->trade_code."]";
						$arrays = array('userid'=>$trade_stat->userid,'point'=>'-'.$trade_stat->save_point,'content'=>$content,'flag'=>'trade','flag_idx'=>$trade_stat->idx,'trade_code'=>$trade_code,'reg_date'=>date("Y-m-d H:i:s"));
						$this->member_m->point_insert($arrays);
					}


					if($trade_stat->userid && $trade_stat->coupon_idx > 0){ //쿠폰 되돌리기
						$this->common_m->update2("dh_coupon_use",array('trade_code' => '','use_date' => ''),array('idx' => $trade_stat->coupon_idx));
					}

					/* 상품재고 돌리기 start */
					$trade_goods_result = $this->common_m->getList2("dh_trade_goods","where trade_code='".$trade_code."'");

					foreach($trade_goods_result as $goods){
						$goods_stat = $this->common_m->getRow("dh_goods","where idx='".$goods->goods_idx."'");
						$this->common_m->update2("dh_goods",array('number'=>$goods_stat->number+1),array('idx'=>$goods->goods_idx,'unlimit'=>0));

						$trade_goods_option_result = $this->common_m->getList2("dh_trade_goods_option","where goods_idx='".$goods->goods_idx."' and trade_code='".$trade_code."' and level=2");
						foreach($trade_goods_option_result as $option){

							$goods_option_row = $this->common_m->getRow2("dh_goods_option","where idx='".$option->option_idx."'");
							$this->common_m->update2("dh_goods_option",array('number'=>$goods_option_row->number+1),array('idx'=>$option->option_idx));
						}
					}
					/* 상품재고 돌리기 end */

					//정기주문 내역 / 로그 / 정기주문 상품내역 삭제하기
					//2018-09-04 정기주문내역 남겨달라는 요청
					//$this->common_m->self_q("delete from dh_trade_deliv_info where trade_code = '".$trade_stat->trade_code."'","delete");	//정기주문내역 삭제
					$this->common_m->self_q("update dh_trade_deliv_info set deliv_stat = '5' where trade_code = '".$trade_stat->trade_code."' and invoice_no = ''","update");	//정기주문내역 삭제
					//$this->common_m->self_q("delete from dh_trade_deliv_log where deliv_code like '".$trade_stat->trade_code."%'","delete");	//주문변경로그 삭제
					//$this->common_m->self_q("delete from dh_trade_deliv_prod where trade_code = '".$trade_stat->trade_code."'","delete");	//정기주문제품목록 삭제

				}


				if($mode=="list"){
					result($result2, "주문이 취소", cdir()."/dh_order/orderList/".$query_string.$param);
				}else if($mode=="detail"){
					result($result2, "주문이 취소", cdir()."/dh_order/shop_order_detail/".$trade_code."/".$query_string.$param);
				}else if($flag=="admin"){
					result($result2, "주문이 취소", cdir()."/dh_order/orderList/".$query_string.$param);
				}else if($mode == "cancel_list"){
					result($result2, "주문이 취소", cdir()."/dh_order/cancel_list/".$query_string.$param);
				}

			}else{
				if($mode=="list"){
					alert(cdir()."/dh_order/orderList/".$query_string.$param,"잘못된 접근입니다.");
				}else if($mode=="detail"){
					alert(cdir()."/dh_order/shop_order_detail/".$trade_code."/".$query_string.$param,"잘못된 접근입니다.");
				}
				exit;
			}

		}else{
			back("존재하지 않는 주문코드입니다.");
			exit;
		}
	}


	public function shop_order_return($data=''){

		$page=$this->uri->segment(2,'');

		$trade_code=$this->uri->segment(3,'');
		$change_trade_stat=$this->uri->segment(4,5);
		$data['change_trade_stat'] = $change_trade_stat;

		$trade_cnt = $this->common_m->getCount("dh_trade","where trade_code='".$this->db->escape_str($trade_code)."'","idx");
		if($trade_cnt > 0){

		$trade_stat = $this->common_m->getRow("dh_trade","where trade_code='".$this->db->escape_str($trade_code)."'");

		if($trade_stat->userid && $trade_stat->userid != $this->session->userdata('USERID')){
			alert('/','잘못된 접근입니다.');
			exit;
		}

		$data['trade_code'] = $trade_code;
		$data['trade_stat'] = $trade_stat;

		$result = $this->order_m->getTradeOption($trade_code);
		$data['goods_list'] = $result['goods_list'];
		foreach($data['goods_list'] as $lt){
			$data['option_arr'.$lt->idx] = $result['option_arr'.$lt->idx];
		}


		$trade_name = str_replace("신청","",$data['shop_info']['trade_stat'.$change_trade_stat]);
		$data['trade_name'] = $trade_name;
		$day7 = date("Y-m-d",strtotime("+7 day",strtotime($trade_stat->delivery_day)));
		if( ( $change_trade_stat!=10 && $trade_stat->trade_stat==4 && $trade_stat->delivery_day!="0000-00-00 00:00:00" && $day7 >= date("Y-m-d")) || ($change_trade_stat == 10 && $trade_stat->trade_stat < 3 )){

			if($this->input->post("trade_stat") && $this->input->post("return_reason")){

				$result = $this->db->update("dh_trade",array('trade_stat'=>$this->input->post("trade_stat",true),'return_prod'=>$this->input->post("return_prod",true),'return_reason'=>$this->input->post("return_reason",true),'return_etc'=>$this->input->post("return_etc",true),'trade_day_cancel_req'=>date("Y-m-d H:i:s")),array('idx'=>$trade_stat->idx));

				result($result, $trade_name."신청이 완료", cdir()."/dh_order/orderList/return/");
				exit;

			}else{

				if($change_trade_stat=="10"){

					$view="cancel_write";

				}else{

					$view="return_write";

				}

				$dir = $_SERVER['DOCUMENT_ROOT']."/html/application/views/order/";
				$data['view'] = $dir.$view;
				$url = $this->common_m->get_page($page);
				$this->load->view($url,$data);

			}


		}else{
			back("교환/반품/취소 신청을 할수 있는 주문이 아닙니다.");
			exit;
		}

		}else{
			back("존재하지 않는 주문코드입니다.");
			exit;
		}

	}


	public function point($data=''){

		$page=$this->uri->segment(2,'');
		if(!$this->session->userdata('USERID')){ //비로그인시 로그인 화면으로
			//			alert(cdir().'/dh_member/login/?go_url='.$_SERVER['PHP_SELF']);
			//			exit;
			$this->load->view("/html/please_login",$data);
		}
		$userid = $this->session->userdata('USERID');

		$where_query = "where userid='".$this->db->escape_str($userid)."'";

		$data['mem_row']=$this->common_m->getRow("dh_member",$where_query);
		$data['total_point'] = $this->common_m->getSum("dh_point","point", $where_query);
		$data['use_point'] = $this->common_m->getSum("dh_point","point", $where_query." and point < 0");
		$data['sum_point'] = $this->common_m->getSum("dh_point","point", $where_query." and point > 0");

		$order_query="idx desc";
		$data['query_string']="?";

		$data['param'] = "";
		if($this->input->get("PageNumber")){
			$data['param'] = "&PageNumber=".$this->input->get("PageNumber");
		}


		/* 페이징 start */
		$PageNumber = $this->input->get("PageNumber"); //현재 페이지
		if(!$PageNumber){ $PageNumber = 1; }
		$list_num='10'; //페이지 목록개수
		$page_num='5'; //페이징 개수
		$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
		$url = cdir()."/".$this->uri->segment(1)."/".$page;
		$data['totalCnt'] = $this->common_m->getPageList('dh_point','count','','',$where_query,$order_query); //총개수
		$data['Page'] = Page($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
		$data['listNo'] = $data['totalCnt'] - $list_num*($PageNumber-1);
		/* 페이징 end */

		$data['list'] = $this->common_m->getPageList('dh_point','',$offset,$list_num,$where_query,$order_query); //리스트


		$view="point";

		$dir = $_SERVER['DOCUMENT_ROOT']."/html/application/views/order/";
		$data['view'] = $dir.$view;
		$url = $this->common_m->get_page($page);
		$this->load->view($url,$data);

	}

	public function coupon($data=''){

		if($this->input->post('coupon_code')){	//쿠폰 수동으로 등록시	20180503
			$coupon_info = $this->common_m->self_q("select * from dh_coupon where code = '".$this->input->post('coupon_code')."'","row");
			//일반쿠폰과 이벤트 제한적 쿠폰 분리 해야할듯
			//20191210 update 쿠폰 사용기간 제한 및 사용횟수 제한기능
			if($coupon_info){
				if($coupon_info->max_count > 0){

					$today_stamp = strtotime(date("Y-m-d"));
					$use_sdate = strtotime($coupon_info->use_sdate);
					$use_edate = strtotime($coupon_info->use_edate);

					if($today_stamp >= $use_sdate and $today_stamp <= $use_edate){
						$coupon_use = $this->common_m->self_q("select * from dh_coupon_use where code = '".$this->input->post('coupon_code')."'","cnt");
						if($coupon_use >= $coupon_info->max_count){
							echo $coupon_use."<BR>".$coupon_info->max_count;
							alert(cdir()."/dh_order/coupon","선착순으로 마감되었습니다. 다음달에 꼭 다시만나요!");
						}
						else{

							$coupon_use = $this->common_m->self_q("select * from dh_coupon_use where code = '".$this->input->post('coupon_code')."' and userid = '".$this->session->userdata('USERID')."'","cnt");
							if($coupon_use){
								alert(cdir()."/dh_order/coupon","이미 등록된 쿠폰입니다.");
							}
							else{
								$insert['userid'] = $this->session->userdata('USERID');
								$insert['name'] = $coupon_info->name;
								$insert['code'] = $coupon_info->code;
								$insert['type'] = $coupon_info->type;
								$insert['discount_flag'] = $coupon_info->discount_flag;
								$insert['price'] = $coupon_info->price;
								$insert['min_price'] = $coupon_info->min_price;
								$insert['max_price'] = $coupon_info->max_price;
								if($coupon_info->max_day){	//발급일로부터
									$insert['start_date'] = date("Y-m-d");
									$insert['end_date'] = date("Y-m-d",strtotime("".$coupon_info->max_day.""));
								}
								else{
									$insert['start_date'] = $coupon_info->start_date;
									$insert['end_date'] = $coupon_info->end_date;
								}
								$insert['reg_date'] = timenow();

								$result = $this->common_m->insert2("dh_coupon_use",$insert);
								if($result){
									alert(cdir()."/dh_order/coupon","쿠폰이 등록 되었습니다..");
								}

							}

						}
					}
					else{
						alert(cdir()."/dh_order/coupon","쿠폰 사용가능 기간이 아닙니다.");
					}

				}
				else{

					$where_query = "";
					if($coupon_info->type == 4){	//중복되면 안되는 쿠폰 이벤트쿠폰 (1회만 지급)
						$where_query .= " and type = 4";
					}
					else{	//일반 쿠폰
						$where_query .= " and userid = '".$this->session->userdata('USERID')."'";
					}

					$coupon_use = $this->common_m->self_q("select * from dh_coupon_use where code = '".$this->input->post('coupon_code')."' {$where_query}","cnt");
					if($coupon_use){	//쿠폰 조건이 맞지 않는 경우
						alert(cdir()."/dh_order/coupon","이미 등록된 쿠폰입니다.");
					}
					else{	//쿠폰 등록
						$insert['userid'] = $this->session->userdata('USERID');
						$insert['name'] = $coupon_info->name;
						$insert['code'] = $coupon_info->code;
						$insert['type'] = $coupon_info->type;
						$insert['discount_flag'] = $coupon_info->discount_flag;
						$insert['price'] = $coupon_info->price;
						$insert['min_price'] = $coupon_info->min_price;
						$insert['max_price'] = $coupon_info->max_price;
						if($coupon_info->max_day){	//발급일로부터
							$insert['start_date'] = date("Y-m-d");
							$insert['end_date'] = date("Y-m-d",strtotime("".$coupon_info->max_day.""));
						}
						else{
							$insert['start_date'] = $coupon_info->start_date;
							$insert['end_date'] = $coupon_info->end_date;
						}
						$insert['reg_date'] = timenow();
						//$insert['status'] = $coupon_info->status;

						$result = $this->common_m->insert2("dh_coupon_use",$insert);
						if($result){
							alert(cdir()."/dh_order/coupon","쿠폰이 등록 되었습니다..");
						}
					}

				}
			}
			else{
				alert(cdir()."/dh_order/coupon","존재하지 않는 쿠폰입니다.");
			}

			/*
			if($coupon_info){	//쿠폰 정보가 존재하는 경우
				$where_query = "";
				if($coupon_info->max_count > 0){
					$today_stamp = time();
					$use_sdate = strtotime($coupon_info->use_sdate);
					$use_edate = strtotime($coupon_info->use_edate);

					if($today_stamp >= $use_sdate and $today_stamp <= $use_edate){
					}
					else{
						alert(cdir()."/dh_order/coupon","쿠폰 사용가능 기간이 아닙니다.");
					}

				}
				else{
					if($coupon_info->type == 4){	//중복되면 안되는 쿠폰 이벤트쿠폰 (1회만 지급)
						$where_query .= " and type = 4";
					}
					else{	//일반 쿠폰
						$where_query .= " and userid = '".$this->session->userdata('USERID')."'";
					}
				}

				$coupon_use = $this->common_m->self_q("select * from dh_coupon_use where code = '".$this->input->post('coupon_code')."' {$where_query}","cnt");
				if($coupon_use){	//쿠폰 조건이 맞지 않는 경우
					alert(cdir()."/dh_order/coupon","이미 등록된 쿠폰입니다.");
				}
				else{	//쿠폰 등록
					$insert['userid'] = $this->session->userdata('USERID');
					$insert['name'] = $coupon_info->name;
					$insert['code'] = $coupon_info->code;
					$insert['type'] = $coupon_info->type;
					$insert['discount_flag'] = $coupon_info->discount_flag;
					$insert['price'] = $coupon_info->price;
					$insert['min_price'] = $coupon_info->min_price;
					$insert['max_price'] = $coupon_info->max_price;
					if($coupon_info->max_day){	//발급일로부터
						$insert['start_date'] = date("Y-m-d");
						$insert['end_date'] = date("Y-m-d",strtotime("".$coupon_info->max_day.""));
					}
					else{
						$insert['start_date'] = $coupon_info->start_date;
						$insert['end_date'] = $coupon_info->end_date;
					}
					$insert['reg_date'] = timenow();
					//$insert['status'] = $coupon_info->status;

					$result = $this->common_m->insert2("dh_coupon_use",$insert);
					if($result){
						alert(cdir()."/dh_order/coupon","쿠폰이 등록 되었습니다..");
					}
				}
			}
			else{
				alert(cdir()."/dh_order/coupon","존재하지 않는 쿠폰입니다.");
			}
			*/
		}
		//쿠폰 등록 종료

		$page=$this->uri->segment(2,'');

		if($this->input->get("ajax")==1 && $this->input->get("coupon_idx")){
			$couponRow = $this->common_m->getRow("dh_coupon_use","where idx='".$this->input->get("coupon_idx",true)."'");
			echo $couponRow->type."/".$couponRow->discount_flag."/".$couponRow->price;
			exit;
		}


		if(!$this->session->userdata('USERID')){ //비로그인시 로그인 화면으로
			//			alert(cdir().'/dh_member/login/?go_url='.$_SERVER['PHP_SELF']);
			//			exit;
			$this->load->view("/html/please_login",$data);
		}
		$userid = $this->session->userdata('USERID');

		$nowdate = date("Y-m-d");

		$where_query = "where userid='".$this->db->escape_str($userid)."'";
		$where_query.= " and start_date <= '$nowdate' and end_date >= '$nowdate'";
		$where_query.= " and trade_code = ''";
		$order_query="idx desc";
		$data['query_string']="?";

		$data['param'] = "";
		if($this->input->get("PageNumber")){
			$data['param'] = "&PageNumber=".$this->input->get("PageNumber");
		}

		/* 페이징 start */
		$PageNumber = $this->input->get("PageNumber"); //현재 페이지
		if(!$PageNumber){ $PageNumber = 1; }
		$list_num='10'; //페이지 목록개수
		$page_num='5'; //페이징 개수
		$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
		$url = cdir()."/".$this->uri->segment(1)."/".$page;
		$data['totalCnt'] = $this->common_m->getPageList('dh_coupon_use','count','','',$where_query,$order_query); //총개수
		$data['Page'] = Page($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
		/* 페이징 end */

		$data['list'] = $this->common_m->getPageList('dh_coupon_use','',$offset,$list_num,$where_query,$order_query); //리스트


		$view="coupon";

		$dir = $_SERVER['DOCUMENT_ROOT']."/html/application/views/order/";
		$data['view'] = $dir.$view;
		$url = $this->common_m->get_page($page);
		$this->load->view($url,$data);

	}


	public function couponGive($data='')
	{
		$code = $this->uri->segment(3);
		$admin = $this->uri->segment(5,'');
		$row = $this->common_m->getRow("dh_coupon","where code='".$this->db->escape_str($code)."'");

		if($admin==1 && $this->session->userdata('ADMIN_USERID')){
			$row->userid = $this->uri->segment(4);
			$memrow = $this->common_m->getRow("dh_member","where userid='".$row->userid."'");

		}else{
			if(!$this->session->userdata('USERID')){ //비로그인시 로그인 화면으로
				alert(cdir().'/dh_member/login/?go_url='.$_SERVER['PHP_SELF'],'로그인이 필요합니다.');
				//back('로그인이 필요합니다.');
				exit;
			}
		}

		if($code && $row->code){

			$result = $this->order_m->couponGive($row,$admin);

			if($result){
				if($admin==1 && $this->session->userdata('ADMIN_USERID')){
					alert(cdir()."/member/coupon/".$memrow->idx."/?ajax=1","쿠폰이 발급되었습니다.");
				}else{
					back("쿠폰이 발급되었습니다.");
				}
			}else{
				back("쿠폰발급에 실패했습니다.\\n다시 시도하여 주세요.");
			}

		}else{
			back('잘못된 쿠폰번호입니다.');
			exit;
		}

	}


	public function inicis_post($data='')
	{
		$mode = $this->input->post("mode",true);
		$data['mode'] = $mode;

		$return_data = $this->order_m->inicis_post($data);
		echo $return_data;
	}

	public function ini_vbank($data='')
	{
		$mode = $this->input->post("mode",true);
		$data['mode'] = $mode;

		$return_data = $this->order_m->ini_vbank($data);
		echo $return_data;
	}

	public function uplus_paytmp($data=''){
		$db_in = array();
		foreach($_POST as $k=>$v){
			$db_in[$k] = $v;
		}
		$insert['trade_code'] = $this->input->post('LGD_OID');
		$insert['pay_tmp'] = serialize($db_in);
		$insert['wdate'] = timenow();
		$result = $this->common_m->insert2("dh_uplus_pay",$insert);
		if($result){
			echo "ok";
		}
	}

	public function uplus_pay_Gethash($data=''){
			$post_data['mode'] = $this->input->post("mode",true);
			$post_data['LGD_MID'] = $this->input->post("LGD_MID",true);
			$post_data['LGD_OID'] = $this->input->post("LGD_OID",true);
			$post_data['LGD_AMOUNT'] = $this->input->post("LGD_AMOUNT",true);
			$post_data['LGD_TIMESTAMP'] = $this->input->post("LGD_TIMESTAMP",true);
			$post_data['configPath'] = $this->input->post("configPath",true);
			$post_data['CST_PLATFORM'] = $this->input->post("CST_PLATFORM",true);

			$result = $this->order_m->uplus_pay_Gethash($post_data);
			echo $result;
	}

	public function uplus_pay($data=''){
		$this->order_m->uplus_pay($_POST);
	}

	public function uplus_bank($data=''){
		$this->order_m->uplus_bank($_POST);
	}

	public function uplus_pay_ok($data=''){
		$this->order_m->uplus_pay_ok($_POST);
	}

	public function grade_change_pay_ok($data=''){
		$this->order_m->grade_change_pay_ok($_POST);
	}

	public function vacctinput($data='') //이니시스 공통통보 페이지
	{
		$result = $this->order_m->vacctinput();

		echo $result;
	}

	public function common_return($data='') //kcp 공통통보 페이지
	{
		$result = $this->order_m->kcp_result();
		echo '<html><body><form><input type="hidden" name="result" value="'.$result.'"></form></body></html>';
	}

	//장바구니에 담기 process > page view = shop_cart()
	public function recom_cart($data=''){

		$db_table = "dh_cart";	//카트 테이블
		$recom = $this->input->post('recom_idx');	//추천식단 구분값
		$add_goods = $this->input->post('goods_idx');	//간식 추가구매 여부

		//option use YN
		$option_cnt = $this->input->post("option_cnt");

		$UID = $this->session->userdata('USERID');

		//의기양양 장바구니 담을때 유효성검사
		//		$goods_info = $this->common_m->self_q("select * from dh_goods where idx='".$add_goods."'","row");
		//		if($goods_info->cate_no == "10"){ //의기양양일 경우
		//
		//			$succ_list = $this->common_m->self_q("select * from dh_order_succ where year='".date('Y')."' and month='".date('m')."'","result");
		//
		//			if($succ_list){
		//				foreach($succ_list as $lt){
		//
		//					if($this->session->userdata('USERID') != $lt->userid){
		//						alert($_SERVER['HTTP_REFERER'],"당첨자가 아닙니다.");
		//					}else{
		//						if($lt->trade_code){
		//							alert($_SERVER['HTTP_REFERER'],"년간 1인 1회만 주문가능합니다.");
		//							/*
		//							$trade_row = $this->common_m->self_q("select trade_stat from dh_trade where trade_code='".$lt->trade_code."'","result");
		//							if($trade_row->trade_stat != 9){
		//								alert($_SERVER['HTTP_REFERER'],"년간 1인 1회만 주문가능합니다.");
		//							}
		//							*/
		//						}
		//					}
		//				}
		//			}else{
		//				alert($_SERVER['HTTP_REFERER'],"당첨자가 아닙니다.");
		//			}
		//
		//
		//		}
		//////////////////////////////////////


		if($recom){	//추천식단 장바구니 담기

			//추천식단 2개이상 못 담도록
			/*
			$cart_recom_cnt = $this->common_m->self_q("select * from dh_cart where userid = '{$UID}' and trade_ok != '1' and recom_is = 'Y'","cnt");
			if($cart_recom_cnt > 0){
				alert(cdir()."/dh_order/shop_cart/","장바구니에 이미 추천식단이 담겨있습니다. 확인해 주세요.");
			}
			*/

			$deliv_addr = $this->input->post('recom_deliv_addr');
			$zipcode = $this->input->post('recom_zipcode');
			$addr1 = $this->input->post('recom_addr1');
			$addr2 = $this->input->post('recom_addr2');

			$recom_delivery_detail_date_arr = $this->input->post('recom_delivery_detail_date');

			$recom_info = $this->common_m->self_q("select * from dh_recom_food where idx = '{$recom}'","row");

			$insert_data['userid'] = $this->session->userdata('USERID');
			$insert_data['code'] = $this->session->userdata('CART');
			$insert_data['goods_name'] = "[영양식단] ".$recom_info->recom_name;
			$insert_data['date_bind'] = $this->input->post('recom_default_deliv_start_day');
			$insert_data['recom_is'] = "Y";
			$insert_data['recom_idx'] = $this->input->post('recom_idx');
			$insert_data['recom_delivery_sun_type'] = $this->input->post('recom_delivery_week_day_count') == 7 ? $this->input->post('recom_delivery_sun_type') : "" ;
			$insert_data['recom_week_count'] = $this->input->post('recom_delivery_week_count');
			$insert_data['recom_week_day_count'] = $this->input->post('recom_delivery_week_day_count');
			$insert_data['recom_week_type'] = $this->input->post('recom_delivery_week_type');
			$insert_data['goods_origin_price'] = str_replace(",","",$this->input->post('recom_total_origin_price'));
			$insert_data['recom_pack_ea'] = $this->input->post('recom_pack_ea');
			$insert_data['recom_per'] = $this->input->post('recom_per');
			$insert_data['goods_price'] = str_replace(",","",$this->input->post('recom_price'));
			$insert_data['goods_cnt'] = '1';
			$insert_data['total_price'] = $insert_data['goods_price'] * $insert_data['goods_cnt'];

			$recom_food_table = array();
			$recom_date_text = "";	//배송일자 쪼깨서 확인 가능하도록 표기
			foreach($recom_delivery_detail_date_arr as $deliv_date_time){	//식단정보 배열처리
				$recom_date_text .= date("Y-m-d",$deliv_date_time)."^";
				$prod_cnt = $this->input->post($deliv_date_time.'_prod_cnt');
				$goods_idx = $this->input->post($deliv_date_time.'_goods_idx');
				foreach($prod_cnt as $k=>$pc){
					$recom_food_table[$deliv_date_time][$k]['prod_cnt'] = $pc;
					$recom_food_table[$deliv_date_time][$k]['goods_idx'] = $goods_idx[$k];
					$recom_food_table[$deliv_date_time][$k]['allergy'] = $this->input->post("alg_chg_cnt_".$deliv_date_time) > 0 ? $this->input->post("alg_chg_cnt_".$deliv_date_time) : "0" ;//알러지체크후 제품 변경여부 확인
				}
			}

			$insert_data['recom_foods'] = serialize($recom_food_table);
			$insert_data['recom_start_date'] = $recom_delivery_detail_date_arr[0];	//배송시작일
			$insert_data['recom_end_date'] = $recom_delivery_detail_date_arr[sizeof($recom_delivery_detail_date_arr)-1];	//배송종료일
			$insert_data['recom_dates'] = $recom_date_text;	//배송일들
			$insert_data['reg_date'] = timenow();

			$insert_data['deliv_addr'] = $deliv_addr;
			$insert_data['zipcode'] = $zipcode;
			$insert_data['addr1'] = $addr1;
			$insert_data['addr2'] = $addr2;

			$insert_data['deliv_grp'] = "이유식";

			$result = $this->common_m->insert2($db_table,$insert_data);

			if($add_goods){	//추가 구매하는 간식이 있는경우
				$add_goods_name = $this->input->post('goods_name');
				$add_goods_origin_price = $this->input->post('goods_origin_price');
				$add_goods_price = $this->input->post('goods_price');
				$add_goods_cnt = $this->input->post('goods_cnt');
				foreach($add_goods as $ak=>$ad){	//개별로 카트에 날짜만 바인딩하여 입력
					$addgoods_insert_data['userid'] = $this->session->userdata('USERID');
					$addgoods_insert_data['code'] = $this->session->userdata('CART');
					$addgoods_insert_data['goods_idx'] = $ad;
					$addgoods_insert_data['goods_name'] = $add_goods_name[$ak];
					$addgoods_insert_data['date_bind'] = $this->input->post('recom_default_deliv_start_day');
					$addgoods_insert_data['goods_origin_price'] = $add_goods_origin_price[$ak];
					$addgoods_insert_data['goods_price'] = $add_goods_price[$ak];
					$addgoods_insert_data['goods_cnt'] = $add_goods_cnt[$ak];
					$addgoods_insert_data['total_price'] = $addgoods_insert_data['goods_price'] * $addgoods_insert_data['goods_cnt'];
					$addgoods_insert_data['reg_date'] = timenow();

					$addgoods_insert_data['deliv_addr'] = $deliv_addr;
					$addgoods_insert_data['zipcode'] = $zipcode;
					$addgoods_insert_data['addr1'] = $addr1;
					$addgoods_insert_data['addr2'] = $addr2;

					$addgoods_insert_data['deliv_grp'] = '간식';

					//pr($addgoods_insert_data);
					$result = $this->common_m->insert2($db_table,$addgoods_insert_data);
				}
			}

		}
		else{	//추천식단 이외
			$insert_data['relation_trade_code'] = $this->input->post('relation_trade_code');

			$free_cate_no = $this->input->post('free_cate_no');	//골라담기 구분값

			if($free_cate_no){	//골라담기 일 경우

				$deliv_addr = $this->input->post('free_deliv_addr');
				$zipcode = $this->input->post('free_zipcode');
				$addr1 = $this->input->post('free_addr1');
				$addr2 = $this->input->post('free_addr2');

				$insert_data['userid'] = $this->session->userdata('USERID');
				$insert_data['code'] = $this->session->userdata('CART');
				$insert_data['recom_is'] = "F";
				$addgoods_insert_data['code'] = $this->session->userdata('CART');

				$free_deliv_date_arr = $this->input->post('free_deliv_date');
				foreach($free_deliv_date_arr as $fdda){	//개별 카트 테이블에 입력 날짜 바인딩

					$free_goods_cnt_arr = $this->input->post($fdda."_free_goods_cnt");
					$free_goods_name_arr = $this->input->post($fdda."_free_goods_name");
					$free_goods_price_arr = $this->input->post($fdda."_free_goods_price");
					$free_goods_origin_price_arr = $this->input->post($fdda."_free_goods_origin_price");
					$free_goods_idx_arr = $this->input->post($fdda."_free_goods_idx");

					foreach($free_goods_cnt_arr as $ik => $free_goods){

						$insert_data['goods_name'] = $free_goods_name_arr[$ik];
						$insert_data['goods_idx'] = $free_goods_idx_arr[$ik];
						$insert_data['date_bind'] = date("Y-m-d",$fdda);
						//$insert_data['deliv_price'] = (in_array($insert_data['date_bind'],$db_dv_date_arr)) ? "0" : $data['shop_info']['express_money'] ;
						$insert_data['goods_origin_price'] = $free_goods_origin_price_arr[$ik];
						$insert_data['goods_price'] = $free_goods_price_arr[$ik];
						$insert_data['goods_cnt'] = $free_goods_cnt_arr[$ik];
						$insert_data['total_price'] = $insert_data['goods_price'] * $insert_data['goods_cnt'];
						$insert_data['reg_date'] = timenow();

						$insert_data['deliv_addr'] = $deliv_addr;
						$insert_data['zipcode'] = $zipcode;
						$insert_data['addr1'] = $addr1;
						$insert_data['addr2'] = $addr2;

						$insert_data['deliv_grp'] = '이유식';

						//pr($insert_data);
						$result = $this->common_m->insert2($db_table,$insert_data);

					}

				}

				if($add_goods){	//간식 추가 구매
					$add_goods_name = $this->input->post('goods_name');
					$add_goods_origin_price = $this->input->post('goods_origin_price');
					$add_goods_price = $this->input->post('goods_price');
					$add_goods_cnt = $this->input->post('goods_cnt');
					foreach($add_goods as $ak=>$ad){
						$addgoods_insert_data['userid'] = $this->session->userdata('USERID');
						$addgoods_insert_data['code'] = $this->session->userdata('CART');
						$addgoods_insert_data['goods_idx'] = $ad;
						$addgoods_insert_data['goods_name'] = $add_goods_name[$ak];
						$addgoods_insert_data['date_bind'] = date("Y-m-d",$free_deliv_date_arr[0]);
						//$addgoods_insert_data['deliv_price'] = (in_array($addgoods_insert_data['date_bind'],$db_dv_date_arr)) ? "0" : $data['shop_info']['express_money'] ;
						$addgoods_insert_data['goods_origin_price'] = $add_goods_origin_price[$ak];
						$addgoods_insert_data['goods_price'] = $add_goods_price[$ak];
						$addgoods_insert_data['goods_cnt'] = $add_goods_cnt[$ak];
						$addgoods_insert_data['total_price'] = $addgoods_insert_data['goods_price']*$addgoods_insert_data['goods_cnt'];
						$addgoods_insert_data['reg_date'] = timenow();

						$addgoods_insert_data['deliv_addr'] = $deliv_addr;
						$addgoods_insert_data['zipcode'] = $zipcode;
						$addgoods_insert_data['addr1'] = $addr1;
						$addgoods_insert_data['addr2'] = $addr2;

						$addgoods_insert_data['deliv_grp'] = '간식';

						//pr($addgoods_insert_data);
						$result = $this->common_m->insert2($db_table,$addgoods_insert_data);
					}
				}

				if($result){
					$result = $this->common_m->self_q("delete from dh_freecart_tmp where userid = '".$this->session->userdata('USERID')."'","delete");
				}

			}
			else if($this->input->post('sales_deliv_date')){	//특가상품

				$deliv_addr = $this->input->post('sales_deliv_addr');
				$zipcode = $this->input->post('sales_zipcode');
				$addr1 = $this->input->post('sales_addr1');
				$addr2 = $this->input->post('sales_addr2');

				$insert_data['userid'] = $this->session->userdata('USERID');
				$insert_data['code'] = $this->session->userdata('CART');
				$insert_data['recom_is'] = "S";
				$addgoods_insert_data['code'] = $this->session->userdata('CART');

				$sales_deliv_date_arr = $this->input->post('sales_deliv_date');
				foreach($sales_deliv_date_arr as $fdda){	//개별 카트 테이블에 입력 날짜 바인딩

					$sales_goods_cnt_arr = $this->input->post($fdda."_sales_goods_cnt");
					$sales_goods_name_arr = $this->input->post($fdda."_sales_goods_name");
					$sales_goods_price_arr = $this->input->post($fdda."_sales_goods_price");
					$sales_goods_origin_price_arr = $this->input->post($fdda."_sales_goods_origin_price");
					$sales_goods_idx_arr = $this->input->post($fdda."_sales_goods_idx");

					foreach($sales_goods_cnt_arr as $ik => $sales_goods){

						$insert_data['goods_name'] = $sales_goods_name_arr[$ik];
						$insert_data['goods_idx'] = $sales_goods_idx_arr[$ik];
						$insert_data['date_bind'] = date("Y-m-d",$fdda);
						//$insert_data['deliv_price'] = (in_array($insert_data['date_bind'],$db_dv_date_arr)) ? "0" : $data['shop_info']['express_money'] ;
						$insert_data['goods_origin_price'] = $sales_goods_origin_price_arr[$ik];
						$insert_data['goods_price'] = $sales_goods_price_arr[$ik];
						$insert_data['goods_cnt'] = $sales_goods_cnt_arr[$ik];
						$insert_data['total_price'] = $insert_data['goods_price'] * $insert_data['goods_cnt'];
						$insert_data['reg_date'] = timenow();

						$insert_data['deliv_addr'] = $deliv_addr;
						$insert_data['zipcode'] = $zipcode;
						$insert_data['addr1'] = $addr1;
						$insert_data['addr2'] = $addr2;

						$insert_data['deliv_grp'] = '이유식';

						//pr($insert_data);
						$result = $this->common_m->insert2($db_table,$insert_data);

					}

				}

				if($add_goods){	//간식 추가 구매
					$add_goods_name = $this->input->post('goods_name');
					$add_goods_origin_price = $this->input->post('goods_origin_price');
					$add_goods_price = $this->input->post('goods_price');
					$add_goods_cnt = $this->input->post('goods_cnt');
					foreach($add_goods as $ak=>$ad){
						$addgoods_insert_data['userid'] = $this->session->userdata('USERID');
						$addgoods_insert_data['goods_idx'] = $ad;
						$addgoods_insert_data['goods_name'] = $add_goods_name[$ak];
						$addgoods_insert_data['date_bind'] = date("Y-m-d",$sales_deliv_date_arr[0]);
						//$addgoods_insert_data['deliv_price'] = (in_array($addgoods_insert_data['date_bind'],$db_dv_date_arr)) ? "0" : $data['shop_info']['express_money'] ;
						$addgoods_insert_data['goods_origin_price'] = $add_goods_origin_price[$ak];
						$addgoods_insert_data['goods_price'] = $add_goods_price[$ak];
						$addgoods_insert_data['goods_cnt'] = $add_goods_cnt[$ak];
						$addgoods_insert_data['total_price'] = $addgoods_insert_data['goods_price']*$addgoods_insert_data['goods_cnt'];
						$addgoods_insert_data['reg_date'] = timenow();

						$addgoods_insert_data['deliv_addr'] = $deliv_addr;
						$addgoods_insert_data['zipcode'] = $zipcode;
						$addgoods_insert_data['addr1'] = $addr1;
						$addgoods_insert_data['addr2'] = $addr2;

						$addgoods_insert_data['deliv_grp'] = '간식';

						//pr($addgoods_insert_data);
						$result = $this->common_m->insert2($db_table,$addgoods_insert_data);
					}
				}

				if($result){
					$result = $this->common_m->self_q("delete from dh_salescart_tmp where userid = '".$this->session->userdata('USERID')."'","delete");
				}

			}
			else{	//일반제품

				if($this->input->post('goods_idx') == 469 or $this->input->post('goods_idx') == 470){
					alert("/","주문할수 없는 상품입니다.");
				}

				//노 옵션 중복검색
				if($option_cnt <= 0){
					$cnt = $this->common_m->self_q("select * from dh_cart where goods_idx = '".$this->input->post('goods_idx')."' and userid = '{$UID}' and code = '".$this->session->userdata('CART')."' and date_bind = '".$this->input->post('date_bind')."'","cnt");

					if($this->input->post('cate_no') == "10"){	//의기양양은 장바구니에서 제거한다. 2021-10-26
						$sql = "
							delete
							from dh_cart
							where userid = '".$this->session->userdata('USERID')."'
							and goods_idx in (select idx from dh_goods where cate_no = 10)
						";
						$this->common_m->self_q($sql,"delete");
					}

					if($cnt > 0){
						if($this->input->post('goods_idx') == "485"){
						}
						else{
							$dupli_row = $this->common_m->self_q("select * from dh_cart where goods_idx = '".$this->input->post('goods_idx')."' and userid = '{$UID}' and code = '".$this->session->userdata('CART')."' and date_bind = '".$this->input->post('date_bind')."'","row");
							$where['idx'] = $dupli_row->idx;
							$update['goods_cnt'] = $dupli_row->goods_cnt;
							$update['total_price'] = $dupli_row->goods_price*($update['goods_cnt']);
							$result = $this->common_m->update2($db_table,$update,$where);
						}
					}
					else{
						$insert_data['userid'] = $this->session->userdata('USERID');
						$insert_data['code'] = $this->session->userdata('CART');
						$insert_data['goods_idx'] = $this->input->post('goods_idx');
						$insert_data['goods_name'] = $this->input->post('goods_name');
						$insert_data['date_bind'] = $this->input->post('date_bind');
						//$insert_data['deliv_price'] = (in_array($insert_data['date_bind'],$db_dv_date_arr)) ? "0" : $data['shop_info']['express_money'] ;
						$insert_data['goods_origin_price'] = $this->input->post('goods_origin_price');
						$insert_data['goods_price'] = $this->input->post('goods_price');
						$insert_data['goods_cnt'] = $this->input->post('goods_cnt');
						$insert_data['total_price'] = $insert_data['goods_price']*$insert_data['goods_cnt'];
						$insert_data['reg_date'] = timenow();

						$insert_data['deliv_addr'] = $this->input->post('deliv_addr');
						$insert_data['zipcode'] = $zipcode;
						$insert_data['addr1'] = $addr1;
						$insert_data['addr2'] = $addr2;

						$insert_data['deliv_grp'] = $this->input->post('deliv_grp');

						$result = $this->common_m->insert2($db_table,$insert_data);
					}
				}

				//옵션이 있을경우
				else{

					//중복체크
					//$cnt = $this->common_m->self_q("select * from dh_cart where goods_idx = '".$this->input->post('goods_idx')."' and userid = '{$UID}' and code = '".$this->session->userdata('CART')."' and date_bind = '".$this->input->post('date_bind')."'","cnt");
					//카운트 있을경우 옵션 검색해서 중복체크 < 옵션도 중복될 경우 갯수 1증가 및 가격 조정
					//if($cnt > 0){
					//	$option_db_cnt = $this->common_m->self_q("select * from dh_cart_option where level = '2' and code = '".$this->session->userdata('CART')."' and ","cnt");
					//}
					//else{

						$insert_data['userid'] = $this->session->userdata('USERID');
						$insert_data['code'] = $this->session->userdata('CART');
						$insert_data['goods_idx'] = $this->input->post('goods_idx');
						$insert_data['goods_name'] = $this->input->post('goods_name');
						$insert_data['date_bind'] = $this->input->post('date_bind');
						//$insert_data['deliv_price'] = (in_array($insert_data['date_bind'],$db_dv_date_arr)) ? "0" : $data['shop_info']['express_money'] ;
						$insert_data['goods_origin_price'] = $this->input->post('goods_origin_price');
						$insert_data['goods_price'] = $this->input->post('goods_price');
						$insert_data['goods_cnt'] = $this->input->post('goods_cnt');
						$insert_data['total_price'] = $this->input->post('total_price');
						$insert_data['option_cnt'] = $option_cnt;
						$insert_data['reg_date'] = timenow();

						$insert_data['deliv_addr'] = $this->input->post('deliv_addr');
						$insert_data['zipcode'] = $zipcode;
						$insert_data['addr1'] = $addr1;
						$insert_data['addr2'] = $addr2;

						$insert_data['deliv_grp'] = $this->input->post('deliv_grp');

						$result = $this->common_m->insert2($db_table,$insert_data);
						$a_idx = $this->db->insert_id();

						if($result){	//장바구니 입력 성공시
							$option_sel = $this->input->post("option_sel",true);
							$option_sel = explode("/",$option_sel);
							$option_sel_cnt = $this->input->post("option_sel_cnt",true);
							$option_sel_cnt = explode("/",$option_sel_cnt);

							if($option_sel[1]){
								for($i=1;$i<count($option_sel);$i++){
									if($option_sel[$i]){
										$option_row = $this->common_m->getRow("dh_goods_option","where idx='".$option_sel[$i]."'");

										if($i == 1){
											$option_level1_row = $this->common_m->getRow("dh_goods_option","where code='".$option_row->code."' and level=1");
											$insert_cart_array1['code'] = $this->session->userdata('CART');
											$insert_cart_array1['cart_idx'] = $a_idx;
											$insert_cart_array1['goods_idx'] = $this->input->post('goods_idx');
											$insert_cart_array1['option_idx'] = $option_level1_row->idx;
											$insert_cart_array1['option_code'] = $option_level1_row->code;
											$insert_cart_array1['level'] = 1;
											$insert_cart_array1['title'] = $option_level1_row->title;
											$insert_cart_array1['chk_num'] = $option_level1_row->chk_num;
											$insert_cart_array1['flag'] = $option_level1_row->flag;
											$insert_cart_array1['trade_day'] = timenow();
											$this->common_m->insert2("dh_cart_option",$insert_cart_array1);
										}

										$insert_cart_array2['code'] = $this->session->userdata('CART');
										$insert_cart_array2['cart_idx'] = $a_idx;
										$insert_cart_array2['goods_idx'] = $this->input->post('goods_idx');
										$insert_cart_array2['option_idx'] = $option_row->idx;
										$insert_cart_array2['option_code'] = $option_row->code;
										$insert_cart_array2['level'] = 2;
										$insert_cart_array2['title'] = $option_row->title;
										$insert_cart_array2['name'] = $option_row->name;
										$insert_cart_array2['price'] = $option_row->price;
										$insert_cart_array2['cnt'] = $option_sel_cnt[$i];
										$insert_cart_array2['chk_num'] = $option_row->chk_num;
										$insert_cart_array2['flag'] = $option_level1_row->flag;
										$insert_cart_array2['trade_day'] = timenow();

										$result = $this->common_m->insert2("dh_cart_option",$insert_cart_array2);
									}
								}
							}
						}

					//}
				}
			}
		}

		alert(cdir()."/dh_order/shop_cart");

	}

	public function recom_food_list($data=''){	//장바구니 식단보기 팝업
		//echo "식단정보 노출";
		$cart_idx = $this->input->get('cart');
		$row = $this->common_m->self_q("select * from dh_cart where idx = '{$cart_idx}'","row");
		$recom_foods_list = unserialize($row->recom_foods);

		$goods = $this->common_m->self_q("select * from dh_goods","result");
		$goods_info = array();
		foreach($goods as $gd){
			$goods_info[$gd->idx]['name'] = $gd->name;
			$goods_info[$gd->idx]['list_img'] = $gd->list_img;
		}
		//pr($goods_info);
		//pr($recom_foods_list);

		$data['goods_info'] = $goods_info;
		$data['recom_foods_list'] = $recom_foods_list;

		$this->load->view("/order/recom_foods",$data);

	}

	public function sample_cart($data=''){

		if($_POST){

			$insert['userid'] = $this->input->post('userid');
			$insert['code'] = $this->input->post('code');
			$insert['goods_name'] = $this->input->post('goods_name');
			$insert['deliv_addr'] = $this->input->post('deliv_addr');
			$insert['date_bind'] = $this->input->post('date_bind');
			$insert['goods_idx'] = $this->input->post('goods_idx');
			$insert['goods_origin_price'] = $this->input->post('goods_origin_price');
			$insert['goods_price'] = $this->input->post('goods_price');
			$insert['goods_cnt'] = $this->input->post('goods_cnt');
			$insert['total_price'] = $this->input->post('total_price');
			$insert['reg_date'] = timenow();

			$cnt = $this->common_m->self_q("select * from dh_sample_cart where userid = '".$this->session->userdata('USERID')."'","cnt");

			if($cnt > 0){
				alert(cdir()."/dh_order/shop_cart/?sample=ok","이미 선택하신 샘플이 있습니다.");
			}
			else{
				$result = $this->common_m->insert2("dh_sample_cart",$insert);
				if($result){
					alert(cdir()."/dh_order/shop_cart/?sample=ok");
				}
			}

		}

	}

	public function order_prod($data=''){
		$deliv_code = urldecode($this->input->get('deliv_code'));

		$json = array();
		$json['get_pop'] = $this->get_Deliv_prod_pop($deliv_code);

		echo json_encode($json);
	}

	public function get_Deliv_prod_pop($deliv_code){

		$list = $this->common_m->self_q("select a.*, b.name from dh_trade_deliv_prod a, dh_goods b where a.goods_idx = b.idx and deliv_code = '{$deliv_code}' order by recom_idx desc, b.name asc","result");

		$deliv_code_arr = explode("-",$deliv_code);

		ob_start();
		include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.order_detail.prod_pop.php";
		$content = ob_get_contents();
		ob_end_clean();

		return $content;

	}

	public function deliv_log(){
		$deliv_code = urldecode($this->input->get('deliv_code'));

		$json = array();
		$json['get_pop'] = $this->GetDelivLog($deliv_code);

		echo json_encode($json);
	}

	public function GetDelivLog($deliv_code){
		$list = $this->common_m->self_q("select * from dh_trade_deliv_log where deliv_code = '{$deliv_code}' order by idx desc","result");

		$deliv_code_arr = explode("-",$deliv_code);

		ob_start();
		include $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/ajax/ajax.deliv_log.prod_pop.php";
		$content = ob_get_contents();
		ob_end_clean();

		return $content;
	}

	public function cart_deliv_calc($data=''){

		$USERID = $this->session->userdata('USERID');
		$db_deliv_date = $this->common_m->self_q("select distinct deliv_date from dh_trade_deliv_info where userid = '{$USERID}' and deliv_date >= '".date("Y-m-d")."' and deliv_stat = 0 order by deliv_date asc ","result");
		$db_dv_date_arr = array();
		foreach($db_deliv_date as $db){	//해당 고객 정기배송 리스트에서 날짜 추출하여 배열로 변환
			$db_dv_date_arr[] = $db->deliv_date;
		}

		echo $this->order_m->cart_deliv_calc($db_dv_date_arr,$data['shop_info']['express_free'],$data['shop_info']['express_money']);	//배송비 출력
		//return $result;

	}

	public function order_edit($data=''){	//배송지 변경
		$userid = $this->session->userdata('USERID');
		$mode = $this->input->get('mode');

		if($userid || $this->session->userdata('ADMIN_USERID')){

			if($mode == "deliv_addr_chg"){	//팝업+

				if($_POST){	//폼값이 전달 되었을때

					$where = "";

					$writer = $userid ? "본인" : "관리자 (".$this->session->userdata('ADMIN_USERID').")";

					if($this->input->post('check') == 'all'){	//이후부터 일괄
						$list = $this->common_m->self_q("select * from dh_trade_deliv_info where trade_code = '".$this->input->post('trade_code')."' and deliv_stat in (0,6) and deliv_code >= '".$this->input->post('deliv_code')."'","result");
						foreach($list as $lt){
							$result = $this->common_m->insert_log($userid,timenow(),'배송지 변경','배송지를 변경하였습니다.',$lt->deliv_code,$writer);
						}

						$where = "where trade_code = '".$this->input->post('trade_code')."' and deliv_stat in (0,6) and deliv_code >= '".$this->input->post('deliv_code')."'";

					}
					else{	//이번만
						$result = $this->common_m->insert_log($userid,timenow(),'배송지 변경','배송지를 변경하였습니다.',$this->input->post('deliv_code'),$writer);

						$where = "where deliv_code = '".$this->input->post('deliv_code')."'";

					}
					//로그 기록 완료

					//업데이트
					$update_sql = "update dh_trade_deliv_info set";
					$update_sql.= " deliv_addr = '".$this->input->post('deliv_addr')."'";
					$update_sql.= " ,zipcode = '".$this->input->post('zipcode')."'";
					$update_sql.= " ,addr1 = '".$this->db->escape_str($this->input->post('addr1'))."'";
					$update_sql.= " ,addr2 = '".$this->input->post('addr2')."'";
					$update_sql.= " ,recv_name = '".$this->input->post('name')."'";
					$update_sql.= " ,recv_phone = '".$this->input->post('phone')."'";
					//$update_sql.= " ,order_type = '999999'";
					$update_sql.= " {$where}";
					$result = $this->common_m->self_q($update_sql,"update");

					if($result){	//업데이트 성공시
						?>
						<script type="text/javascript">
						<!--
							alert('베송지 변경이 완료되었습니다.\n변경내용은 [배송지변경]을 요청주신 페이지를 통해서만 확인 가능합니다.');
							opener.location.reload();
							self.close();
						//-->
						</script>
						<?php
					}

				}
				else{	//view
					$deliv_code = urldecode($this->input->get('deliv_code'));
					$od_type = $this->input->get('od_type');

					if($od_type == "recom"){
						$data['deliv_type_name'] = "정기배송";
					}
					else if($od_type == "sample"){
						$data['deliv_type_name'] = "샘플신청";
					}
					else{
						$data['deliv_type_name'] = "일반배송";
					}

					$data['row'] = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '{$deliv_code}'","row");
					$data['member_info'] = $this->common_m->self_q("select * from dh_member where userid = '".$data['row']->userid."'","row");
					$prod_name_arr = explode(",",$data['row']->prod_name);
					$data['prod_name'] = $prod_name_arr[0];
					if(count($prod_name_arr) > 1){
						$data['prod_name'] .= "외 ".(count($prod_name_arr)-1)."건";
					}

					$trade_info = deliv_code_arr($deliv_code);

					$sql = "
						select *
						from dh_trade_deliv_info
						where userid = '".$data['row']->userid."'
						and deliv_date = '".$data['row']->deliv_date."'
						and deliv_stat = 0
						and recom_idx = 0
						and trade_code != '".$trade_info['trade_code']."'
						and ct_subgroup = '이유식'
					";

					$data['dup_cnt'] = $dup_cnt = $this->common_m->self_q($sql,"cnt");

					if($dup_cnt){
						$data['dup_list'] = $this->common_m->self_q("select * from dh_trade_deliv_info where userid = '".$data['row']->userid."' and deliv_date = '".$data['row']->deliv_date."' and deliv_stat = 0 and recom_idx = 0","result");
					}

					$this->load->view(cdir()."/order_edit_delivaddr_chg",$data);
				}

			}
			else{	//리스트
				$data['limit_date'] = $limit_date = date("Y-m-d",strtotime('+2 day'));

				//if($_SERVER['HTTP_X_FORWARDED_FOR']=='58.229.223.174'){
					$sql = "
						select
							*
							,(select goods_name from dh_trade_goods where trade_code = dh_trade_deliv_info.trade_code and cate_no = 'recom') as recom_name
						from dh_trade_deliv_info
						where userid = '{$userid}'
						and (select trade_stat from dh_trade where trade_code = dh_trade_deliv_info.trade_code) in (2,3)
						order by deliv_date asc
					";
				/*
				}
				else{
					$sql = "select distinct b.*, a.recom_dates, a.recom_is, a.sample_is
									from dh_trade a
										left join dh_trade_deliv_info b on a.trade_code = b.trade_code
									where a.userid = '{$userid}'
										and a.trade_stat between 2 and 4
										and b.deliv_date between
											(select min(deliv_date) from dh_trade_deliv_info where trade_code = b.trade_code and deliv_stat in (0,6) and deliv_date >= '{$limit_date}')
											and
											(select max(deliv_date) from dh_trade_deliv_info where trade_code = b.trade_code and deliv_stat in (0,6) and deliv_date >= '{$limit_date}')
									order by a.idx desc, b.deliv_date asc
									";
				}
				*/

				$data['list'] = $this->common_m->self_q($sql,"result");

				$deliv_list = $this->common_m->self_q("select * from dh_trade_deliv_info where userid = '{$userid}' order by deliv_code asc","result");
				$deliv_info_arr = array();
				foreach($deliv_list as $dl){
					$dcode_arr = explode("-",$dl->deliv_code);
					${'dcount_'.$dcode_arr[0]}++;
					$deliv_info_arr[$dl->trade_code][$dcode_arr[0]][$dl->deliv_date] = ${'dcount_'.$dcode_arr[0]};
				}

				$data['deliv_info_arr'] = $deliv_info_arr;


				$view = $this->uri->segment(2);
				$this->load->view("/html/".$view,$data);
			}

		}
		else{
			$this->load->view("/html/please_login",$data);
		}
	}

	public function order_edit02($data=''){	//메뉴/단계변경
		//메뉴 / 단계변경 구분
		$userid = $this->session->userdata('USERID');
		$mode = $this->input->get('mode');

		if($userid){	//세션체크

			if($mode == "menu_change"){	//메뉴변경
				//로그 기록, 메뉴 갯수 업데이트, 단순 메뉴 갯수 업데이트
				$deliv_code = urldecode($this->input->get('deliv_code'));

				if($_POST){	//변경 폼 전달받은뒤

					//로그 기록
					$this->common_m->insert_log($userid,timenow(),'메뉴 변경','식단을 변경하였습니다.',$deliv_code,'본인');

					//알러지로 메뉴 변경시 오더타입 변경 및 알러지체크 표기	//오더지개선
					//$this->common_m->self_q("update dh_trade_deliv_info set order_type = '999999', allergy = '1' where deliv_code = '{$deliv_code}'","update");
					$this->common_m->self_q("update dh_trade_deliv_info set allergy = '1' where deliv_code = '{$deliv_code}'","update");

					$update_idx_arr = $this->input->post('idxs');
					foreach($update_idx_arr as $uai){
						$result = $this->common_m->self_q("update dh_trade_deliv_prod set prod_cnt = '".$this->input->post('food_cnt'.$uai)."' where idx = '{$uai}'","update");
					}

					if($result){
					?>
					<script type="text/javascript">
						alert('식단 변경이 완료 되었습니다.\n변경내용은 마이페이지 > 주문배송조회를\n통해 확인하실 수 있습니다.');
						opener.location.reload();
						self.close()
					</script>
					<?php
					}

				}
				else{	//메뉴 변경 배송정보, 배송일자별 총 갯수, 배송식단 리스트

					$data['row'] = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '{$deliv_code}'","row");
					$data['sum_foods'] = $this->common_m->self_q("select sum(prod_cnt) as total from dh_trade_deliv_prod where deliv_code = '{$deliv_code}'","row");

					$sql = "select b.*, a.deliv_code, a.prod_cnt, a.idx as dp_idx
									from dh_trade_deliv_prod a
										left join dh_goods b on a.goods_idx = b.idx
									where deliv_code = '{$deliv_code}' and recom_is = 'Y'";

					$data['foods_list'] = $this->common_m->self_q($sql,"result");
					$this->load->view("/html/order_edit_menu_chg",$data);
				}

			}
			else if($mode == "grade_change"){	//단계변경

				if($_POST){

					$db_table = "dh_trade";
					$where['trade_code'] = $this->input->post('trade_code');
					$update['grade_change'] = 1;
					$update['grade_change_pack_ea'] = $this->input->post('chg_recom_pack_ea');
					$update['grade_change_recom_idx'] = $this->input->post('chg_recom_idx');

					$result = $this->common_m->update2($db_table,$update,$where);
					if($result){
						$db_table = "dh_trade_goods";
						$where['trade_code'] = $this->input->post('trade_code');
						$where['cate_no'] = "recom";
						$update['grade_change'] = 1;
						$update['grade_change_pack_ea'] = $this->input->post('chg_recom_pack_ea');
						$update['grade_change_recom_idx'] = $this->input->post('chg_recom_idx');
						$update['grade_change_price'] = $this->input->post('price');
						$update['grade_change_recom_name'] = "[영양식단] ".$this->input->post('chg_recom_name');

						$result = $this->common_m->update2($db_table,$update,$where);
						if($result){
							$update_deliv_info = "update dh_trade_deliv_info set
																		prod_name = '"."[영양식단] ".$this->input->post('chg_recom_name')."'
																		,recom_idx = '".$this->input->post('chg_recom_idx')."'
																		where trade_code = '".$this->input->post('trade_code')."'
																					and deliv_code >= '".$this->input->post('deliv_code')."'";

							$result = $this->common_m->self_q($update_deliv_info,"update");

							//deliv_code 업데이트 될때 로그 부분 deliv_code 도 함께 없데이트 해줘야 합니다. 아직 작업 전 !

							//$this->common_m->self_q("update dh_trade_deliv_log set deliv_code = '".$this->input->post('deliv_code')."' where deliv_code = '".$this->input->post('deliv_code')."'","update");

							if($result){

								$sql = "select * from dh_trade_deliv_info where trade_code = '".$this->input->post('trade_code')."' and deliv_code >= '".$this->input->post('deliv_code')."'";
								$deliv_info_list = $this->common_m->self_q($sql,"result");

								$week_day_count = $this->input->post('week_day_count');
								$week_type = $this->input->post('week_type');
								list($week_deliv_count, $deliv_date_name) = explode(":",$week_type);
								$sun_type = $this->input->post('deliv_sun_type');

								foreach($deliv_info_list as $dil){

									$insert_table = "dh_trade_deliv_prod";

									$insert_data['trade_code'] = $dil->trade_code;
									$insert_data['deliv_code'] = $dil->deliv_code;
									$insert_data['prod_cnt'] = '1';
									$insert_data['recom_is'] = 'Y';
									$insert_data['recom_idx'] = $this->input->post('chg_recom_idx');
									$insert_data['deliv_date'] = $dil->deliv_date;
									$insert_data['wdate'] = timenow();

									$deliv_date_time = strtotime($dil->deliv_date);

									$monday = date("Y-m-d", strtotime('monday this week',$deliv_date_time));
									$wednesday = date("Y-m-d", strtotime('wednesday this week',$deliv_date_time));
									$thursday = date("Y-m-d", strtotime('thursday this week',$deliv_date_time));
									$saturday = date("Y-m-d", strtotime('saturday this week',$deliv_date_time));
									$sunday = date("Y-m-d", strtotime('sunday this week',$deliv_date_time));
									$yesterday = date("Y-m-d", strtotime('yesterday',$deliv_date_time));
									$today = date("Y-m-d", $deliv_date_time);

									if($week_day_count >= 6 and $week_deliv_count == 2){
										$_week = date("w",$deliv_date_time);
										if($_week < 4){
											$start_date = $monday;
											$end_date = $wednesday;
										}
										else{
											$start_date = $thursday;
											$end_date = $saturday;
										}
									}
									else{
										$start_date = $yesterday;
										$end_date = $today;
									}

									$sql = "select a.*, b.cate_no
													from dh_recom_food_table a
														left join dh_goods b on a.goods_idx = b.idx
													where a.recom_food_idx = '".$this->input->post('chg_recom_idx')."'
																and a.recom_date between '{$start_date}' and '{$end_date}'
													order by recom_date desc";

									$_row = $this->common_m->self_q($sql,"fetch_array");

									foreach($_row as $r){

										$insert_data['goods_idx'] = $r['goods_idx'];
										$insert_data['cate_no'] = $r['cate_no'];

										$this->common_m->insert2($insert_table,$insert_data);

										if($sun_type and $week_day_count == 7 and $sun_type == date("w",strtotime($r['recom_date']))){

											$insert_data['goods_idx'] = $r['goods_idx'];
											$insert_data['cate_no'] = $r['cate_no'];
											$this->common_m->insert2($insert_table,$insert_data);
										}

									}

									$result = $this->common_m->self_q("delete from dh_trade_deliv_prod where deliv_code = '".$dil->deliv_code."' and recom_idx = '".$this->input->post('recom_idx')."'","delete");

									if($result){

										//로그기록
										$log_text = $this->input->post('recom_name')."에서 ".$this->input->post('chg_recom_name')." (으)로 단계를 변경 하였습니다.";
										$this->common_m->insert_log($userid,timenow(),'단계 변경',$log_text,$dil->deliv_code,'본인');

									}
								}

								if($result){

									mt_srand((double)microtime()*1000000);
									$GRADE_CODE=chr(mt_rand(65, 90));
									$GRADE_CODE.=chr(mt_rand(65, 90));
									$GRADE_CODE.=chr(mt_rand(65, 90));
									$GRADE_CODE.=chr(mt_rand(65, 90));
									$GRADE_CODE.=chr(mt_rand(65, 90));
									$GRADE_CODE.=time();

									//단계변경 정보 테이블에 기록
									$chg_table = "dh_trade_grade";
									$chg_data['grade_code'] = $GRADE_CODE;
									$chg_data['trade_code'] = $this->input->post('trade_code');
									$chg_data['recom_idx'] = $this->input->post('recom_idx');
									$chg_data['recom_name'] = $this->input->post('recom_name');
									$chg_data['chg_recom_idx'] = $this->input->post('chg_recom_idx');
									$chg_data['chg_recom_name'] = $this->input->post('chg_recom_name');
									$chg_data['price'] = $this->input->post('price');
									$chg_data['pay_method'] = $this->input->post('pay_method');
									$chg_data['remain_deliv_count'] = $this->input->post('remain_deliv_count');
									$chg_data['wdate'] = timenow();

									$result = $this->common_m->insert2($chg_table,$chg_data);
									if($result){
										alert(cdir()."/dh_order/order_edit02/?mode=grade_change_complete&deliv_code=".urlencode($this->input->post('deliv_code'))."&recom_name=".urlencode($this->input->post('recom_name'))."&chg_recom_name=".urlencode($this->input->post('chg_recom_name')));
									}

								}

							}
						}
					}

				}
				else{
					$deliv_code = urldecode($this->input->get('deliv_code'));

					$deliv_code_arr = deliv_code_arr($deliv_code);

					$trade_code = $deliv_code_arr['trade_code'];
					$order_cont = $deliv_code_arr['recom_order_cnt'];

					//$deliv_code_arr = explode("-",$deliv_code);
					$data['trade_code'] = $trade_code;
					$trade_info = $this->common_m->self_q("select * from dh_trade where trade_code = '".$trade_code."'","row");
					$recom_dates_arr = explode("^",$trade_info->recom_dates);
					$recom_date = array();
					foreach($recom_dates_arr as $key=>$rda){
						$recom_date[$rda] = $key+1;	//정기배송일자를 입력하면 회차를 토함
					}

					$data['reverse_recom_date'] = $recom_date;

					//로그 기록, 단계 변경 후 업데이트 할 항목
					//식단 정보 업데이트, 식단 정보 끌어와서 업데이트 해야함

					//식단 정보 (추천식단만 해당)
					$deliv_info = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '{$deliv_code}'","row");
					$data['row'] = $deliv_info;

					$recom_row = $this->common_m->self_q("select * from dh_recom_food where idx = '".$deliv_info->recom_idx."'","row");
					$data['upgrade_recom_list'] = $this->common_m->self_q("select * from dh_recom_food where sort > '".$recom_row->sort."' and brand_idx not in (3,8) order by sort asc","result");

					//카드결제 연동 필수값 회원정보
					$data['member_info'] = $this->common_m->self_q("select * from dh_member where userid = '".$this->session->userdata('USERID')."'","row");

					$this->load->view("/html/order_edit_grade_chg",$data);
				}
			}
			else if($mode == "grade_change_complete"){

				$deliv_code = urldecode($this->input->get('deliv_code'));
				$recom_name = urldecode($this->input->get('recom_name'));
				$chg_recom_name = urldecode($this->input->get('chg_recom_name'));

				//$deliv_code_arr = explode("-",$deliv_code);
				$deliv_code_arr = deliv_code_arr($deliv_code);

				$trade_code = $deliv_code_arr['trade_code'];
				$order_cont = $deliv_code_arr['recom_order_cnt'];
				$deliv_time = $deliv_code_arr['deliv_time'];

				$trade_info = $this->common_m->self_q("select * from dh_trade where trade_code = '".$trade_code."'","row");
				$recom_dates_arr = explode("^",$trade_info->recom_dates);
				$recom_date = array();
				foreach($recom_dates_arr as $key=>$rda){
					$recom_date[$rda] = $key+1;	//정기배송일자를 입력하면 회차를 토함
				}

				$data['reverse_recom_date'] = $recom_date;
				$data['deliv_start_date'] = date("Y-m-d",$deliv_time);
				$data['deliv_start_date_week_name'] = numberToWeekname($data['deliv_start_date']);
				$data['recom_name'] = $recom_name;
				$data['chg_recom_name'] = $chg_recom_name;

				$this->load->view("/html/order_edit_grade_chg_complete",$data);
			}
			else{
				$limit_date = date("Y-m-d",strtotime('+2 day'));

				$sql = "select distinct b.*, a.recom_dates, a.recom_is, a.sample_is
								from dh_trade a
									left join dh_trade_deliv_info b on a.trade_code = b.trade_code
								where a.userid = '{$userid}'
									and a.recom_is = 'Y'
									and a.trade_stat between 2 and 4
									and b.deliv_date between
										(select min(deliv_date) from dh_trade_deliv_info where trade_code = b.trade_code and deliv_stat in (0,6) and deliv_date >= '{$limit_date}')
										and
										(select max(deliv_date) from dh_trade_deliv_info where trade_code = b.trade_code and deliv_stat in (0,6) and deliv_date >= '{$limit_date}')
								order by a.idx desc, b.deliv_date asc
								";

				$data['list'] = $this->common_m->self_q($sql,"result");

				$deliv_list = $this->common_m->self_q("select * from dh_trade_deliv_info where userid = '{$userid}' order by deliv_code asc","result");
				$deliv_info_arr = array();
				foreach($deliv_list as $dl){
					$dcode_arr = explode("-",$dl->deliv_code);
					${'dcount_'.$dcode_arr[0]}++;
					$deliv_info_arr[$dl->trade_code][$dcode_arr[0]][$dl->deliv_date] = ${'dcount_'.$dcode_arr[0]};
				}
				$data['deliv_info_arr'] = $deliv_info_arr;

				$view = $this->uri->segment(2);
				$this->load->view("/html/".$view,$data);
			}
		}
		else{
			$this->load->view("/html/please_login",$data);
		}
	}

	public function order_edit03($data=''){	//배송일 변경
		$userid = $this->session->userdata('USERID');
		$mode = $this->input->get('mode');

		if($userid){
			if($mode == "deliv_date_chg"){	//배송일 변경
				if($_POST){
					//포스트값 정리
					$trade_code = $this->input->post('trade_code');
					$deliv_code = $this->input->post('deliv_code');
					$sel_date = $this->input->post('sel_date');
					$chg_date = $this->input->post('chg_date');

					$recom_idx = $this->input->post('recom_idx');
					$recom_week_day_count = $this->input->post('recom_week_day_count');
					$recom_delivery_sun_type = $this->input->post('recom_delivery_sun_type');
					$recom_week_type = $this->input->post('recom_week_type');
					$trade_goods_idx = $this->input->post('trade_goods_idx');
					$arr_week_type = explode(":",$recom_week_type);	//배송횟수 짜름

					$deliv_code_arr = deliv_code_arr($deliv_code);	//배송코드 집어넣고 주문코드랑 정기배송 중복 여부 체크

					$trade_code = $deliv_code_arr['trade_code'];
					$order_cont = $deliv_code_arr['recom_order_cnt'];
					$deliv_type = $deliv_code_arr['deliv_type']?$deliv_code_arr['deliv_type']:'1';

					$chg_date_time = strtotime($chg_date);	//변경되는 날짜 datetime

					//해당 날짜에 식단이 없는경우 브레이크
					$chg_food_cnt = $this->common_m->self_q("select * from dh_recom_food_table where recom_food_idx = '{$recom_idx}' and recom_date = '{$chg_date}'","cnt");
					if($chg_food_cnt == 0){
						back("선택하신 날짜는 아직 식단 구성이 되지 않았습니다. 다른날짜를 선택해주세요.");
					}
					//해당 날짜에 식단이 없는경우 브레이크

					$update_deliv_code = $trade_code."_".$order_cont."-".$chg_date_time."-".$deliv_type;	//변경되는 날짜에 대한 배송코드
					$update_deliv_date = $chg_date;	//변경되는 날짜에 대한 배송일

					//거래정보에 담긴 정기배송일자 수정 trade and trade_goods
					$trade_row = $this->common_m->self_q("select * from dh_trade_goods where idx = '{$trade_goods_idx}'","row");
					$tmp_recom_dates_arr = explode("^",substr($trade_row->recom_dates,0,-1));	//기존 배송일 항목 배열로 전환
					$tmp_recom_dates_arr = array_diff($tmp_recom_dates_arr,array($sel_date));	//변경되는 날짜 배열에서 삭제
					array_push($tmp_recom_dates_arr, $chg_date);	//추가되는 날짜 배열에 추가
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
					$monday = date("Y-m-d", strtotime('monday this week',$chg_date_time));
					$wednesday = date("Y-m-d", strtotime('wednesday this week',$chg_date_time));
					$thursday = date("Y-m-d", strtotime('thursday this week',$chg_date_time));
					$friday = date("Y-m-d", strtotime('friday this week',$chg_date_time));
					$saturday = date("Y-m-d", strtotime('saturday this week',$chg_date_time));
					$sunday = date("Y-m-d", strtotime('sunday this week',$chg_date_time));
					$yesterday = date("Y-m-d", strtotime('yesterday',$chg_date_time));
					$today = date("Y-m-d", $chg_date_time);
					//식단부터 정리해바
					//원래 받을 날짜 언제여?
					$bf_date_name = date('w',strtotime($sel_date));
					//echo $bf_date_name."<BR>";

					//원래 받을거 갯수
					$bf_cnt_row = $this->common_m->self_q("select sum(prod_cnt) as prod_cnt from dh_trade_deliv_prod where deliv_code = '{$deliv_code}' and recom_is = 'Y'","row");
					$bf_cnt = $bf_cnt_row->prod_cnt;

					//변경할 받을 날짜
					$af_date_name = date("w",$chg_date_time);

					//if($recom_week_day_count >= 6 and ( $arr_week_type[0] == 2 || $arr_week_type[0] == 1 )){
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
					//else if($recom_week_day_count == 4 && $arr_week_type[0] == 1){
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

					if($arr_week_type[0] == 1){	//주1회 목요일 배송분
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
					}

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
					$insert_data['tg_idx'] = $trade_row->idx;
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
					$delivinfo_row = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '{$deliv_code}'","row");
					$delivinfo_row_prodname = $delivinfo_row->prod_name;

					//같은 deliv_code 가 있는경우는 삭제 아니면 업데이트
					$drowcnt = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '{$update_deliv_code}'","cnt");

					if($drowcnt){	//같은 날짜 다른 배송건이 있는경우 제품명 합치고 정기배송인경우 정기여부 확인
						$result = $this->common_m->self_q(" update dh_trade_deliv_info set prod_name = CONCAT('".$delivinfo_row_prodname.", ',prod_name), recom_idx = '{$recom_idx}' where deliv_code = '{$update_deliv_code}' ","update");
						if($result){
							$result = $this->common_m->self_q("delete from dh_trade_deliv_info where deliv_code = '{$deliv_code}'","delete");
						}
					}
					else{
						$result = $this->common_m->self_q("update dh_trade_deliv_info set deliv_code = '{$update_deliv_code}', deliv_date = '{$update_deliv_date}', deliv_stat = 0 where deliv_code = '{$deliv_code}'","update");
					}

					//배송일 변경시 배송코드 기타로 변경
					//$this->common_m->self_q("update dh_trade_deliv_info set order_type = '999999' where deliv_code = '{$update_deliv_code}'","update");

					if($result){
						//로그 기록
						$log_text = "기존 배송일".$sel_date."(".numberToWeekname($sel_date).")에서 ".$chg_date."(".numberToWeekname($chg_date).")로 배송일을 변경 하였습니다.";
						$result6 = $this->common_m->insert_log($userid,timenow(),'배송일 변경',$log_text,$update_deliv_code,'본인');
						if($result6){
							//배송일이 변경된경우 기존에 물려있던 로그들의 배송코드를 업데이트 해준다.
							$results = $this->common_m->self_q("update dh_trade_deliv_log set deliv_code = '{$update_deliv_code}' where deliv_code = '{$deliv_code}'","update");
							if($results){
							?>
							<script type="text/javascript">
							alert("배송일 변경이 완료 되었습니다.\n변경내용은 마이페이지 > 주문배송조회를 통해 확인하실 수 있습니다.");
							opener.location.reload();
							self.close();
							</script>
							<?php
							}
						}
					}
				}
				else{
					$deliv_code = urldecode($this->input->get('deliv_code'));

					$deliv_code_arr = deliv_code_arr($deliv_code);

					$trade_code = $deliv_code_arr['trade_code'];
					$order_cont = $deliv_code_arr['recom_order_cnt'];

					//list($trade_code,$deliv_time) = explode("-",$deliv_code);

					$trade_info_sql = "select a.*, b.* from dh_trade_deliv_info a left join dh_trade_goods b on a.tg_idx = b.idx where a.deliv_code = '{$deliv_code}'";
					$data['trade_info'] = $this->common_m->self_q($trade_info_sql,"row");
					$arr_deliv_date = array();
					$arr_deliv_date_to_count = array();
					//$recom_dates = explode("^",substr($data['trade_info']->recom_dates,0,-1));

					$deliv_dates_list = $this->common_m->self_q("select * from dh_trade_deliv_info where trade_code = '{$trade_code}' and recom_idx > 0 order by deliv_date asc","result");
					$key = 0;
					foreach($deliv_dates_list as $lt){
						$key++;
						$arr_deliv_date[] = $lt->deliv_date;
						$arr_deliv_date_to_count[$lt->deliv_date] = $key;
					}

					//목요일 배송은 목요일로만 변경가능하도록 처리해야함.
					$row = $this->common_m->self_q("select * from dh_trade where trade_code = '{$trade_code}'","row");
					$data['is_thursday'] = false;

					if($row->recom_week_type == "1:목"){
						$data['is_thursday'] = true;
					}

					$data['arr_deliv_date'] = $arr_deliv_date;
					$data['arr_deliv_date_to_count'] = $arr_deliv_date_to_count;
					$data['deliv_info'] = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '{$deliv_code}'","row");

					//달력 이동시 파라미터 유지 설정
					$data['deliv_code'] = $deliv_code;
					$data['mode'] = $mode;

					//달력관련 /달 설정
					$this_mon = $data['this_mon'] = $this->input->get('this_mon');
					if(!$this_mon) $this_mon = $data['this_mon'] = date("Y-m",strtotime($data['deliv_info']->deliv_date));

					//배송휴일 데이터
					$arr_holi = array();
					$holiday = $this->common_m->self_q("select * from dh_deliv_holi where regu = 1","result");
					foreach($holiday as $hl){
						$arr_holi[] = $hl->holiday;
					}
					$data['arr_holi'] = $arr_holi;

					//금일 기준으로 이틀
					$limit_date = $data['limit_date'] = date("Y-m-d",strtotime('+2 day'));

					$sql = "
						select *
						from dh_trade_deliv_info
						where trade_code != '{$trade_code}'
						and userid = '".$data['deliv_info']->userid."'
						and deliv_date = '".$data['deliv_info']->deliv_date."'
						and deliv_stat = 0
						and recom_idx = 0
						and ct_subgroup = '이유식'
					";
					$data['dup_cnt'] = $dup_cnt = $this->common_m->self_q($sql,"cnt");

					if($dup_cnt){
						$data['dup_list'] = $this->common_m->self_q("select * from dh_trade_deliv_info where userid = '".$data['deliv_info']->userid."' and deliv_date = '".$data['deliv_info']->deliv_date."' and deliv_stat = 0 and recom_idx = 0","result");
					}

					$this->load->view("/html/order_edit_deliv_date",$data);
				}
			}
			else{	//리스트
				$limit_date = date("Y-m-d",strtotime('+2 day'));

				$sql = "select distinct b.*, a.recom_dates, a.recom_is, a.sample_is
								from dh_trade a
									left join dh_trade_deliv_info b on a.trade_code = b.trade_code
								where a.userid = '{$userid}'
									and a.recom_is = 'Y'
									and a.trade_stat between 2 and 4
									and b.deliv_date between
										(select min(deliv_date) from dh_trade_deliv_info where trade_code = b.trade_code and deliv_stat in (0,6) and deliv_date >= '{$limit_date}')
										and
										(select max(deliv_date) from dh_trade_deliv_info where trade_code = b.trade_code and deliv_stat in (0,6) and deliv_date >= '{$limit_date}')
								order by a.idx desc, b.deliv_date asc
								";

								//echo $sql;

				$data['list'] = $this->common_m->self_q($sql,"result");

				//정기배송 중복 주문으로 로직 변경에 의한 회차 정보 리뉴얼
				$deliv_list = $this->common_m->self_q("select * from dh_trade_deliv_info where userid = '{$userid}' order by deliv_code asc","result");
				$deliv_info_arr = array();
				foreach($deliv_list as $dl){
					$dcode_arr = explode("-",$dl->deliv_code);
					${'dcount_'.$dcode_arr[0]}++;
					$deliv_info_arr[$dl->trade_code][$dcode_arr[0]][$dl->deliv_date] = ${'dcount_'.$dcode_arr[0]};
				}
				$data['deliv_info_arr'] = $deliv_info_arr;

				$view = $this->uri->segment(2);
				$this->load->view("/html/".$view,$data);
			}
		}
		else{
			$this->load->view("/html/please_login",$data);
		}
	}

	public function order_edit04($data=''){	//배송일시정지

		$userid = $this->session->userdata('USERID');
		$mode = $this->input->get('mode');

		if($userid){
			if($mode == "deliv_pause"){	//일시정지 팝업

				if($_POST){
					$deliv_code = $this->input->post('deliv_code');
					$recom_week_type = $this->input->post('recom_week_type');
					$recom_week_count = $this->input->post('recom_week_count');
					$thiscount = $this->input->post('thiscount');
					$remain_pack_ea = $this->input->post('remain_pack_ea');
					$remain_deliv_count = $this->input->post('remain_deliv_count');

					list($trade_code_tmp,$deliv_time) = explode("-",$deliv_code);
					list($trade_code,$order_cnt) = explode("_",$trade_code_tmp);

					/*
					$arr_week_type = explode(":",$recom_week_type);
					$total_deliv_count = $arr_week_type[0] * $recom_week_count;
					$remain_deliv_count = $total_deliv_count - ($thiscount-1);
					*/

					$where['trade_code'] = $trade_code;

					$update['trade_stat'] = "31";
					$update['remain_deliv_count'] = $remain_deliv_count;
					$update['remain_pack_ea'] = $remain_pack_ea;
					$update['pause_date'] = timenow();

					$result = $this->common_m->update2("dh_trade",$update,$where);
					if($result){
						//$result = $this->common_m->self_q("update dh_trade_deliv_info set deliv_stat = '31' where trade_code = '{$trade_code}' and deliv_code >= '{$deliv_code}'","update");
						$result = $this->common_m->self_q("delete from dh_trade_deliv_prod where trade_code = '{$trade_code}' and deliv_code >= '{$deliv_code}' and deliv_code in (select deliv_stat from dh_trade_deliv_info where deliv_code = dh_trade_deliv_prod.deliv_code and deliv_stat in (0,6))","delete");
						if($result){
							$result = $this->common_m->self_q("delete from dh_trade_deliv_info where trade_code = '{$trade_code}' and deliv_code >= '{$deliv_code}' and deliv_stat in (0,6)","delete");
							if($result){
								//로그 기록
								$now_date = date("Y-m-d");
								$log_text = $now_date."(".numberToWeekname($now_date).") 배송 일시정지 되었습니다.";
								$result6 = $this->common_m->insert_log($userid,timenow(),'배송일시정지',$log_text,$deliv_code,'본인');
								if($result6){
								?>
								<script type="text/javascript">
								opener.location.reload();
								self.close();
								</script>
								<?php
								}
							}
						}
					}

					//echo $remain_deliv_count;



				}
				else{
					$deliv_code = urldecode($this->input->get('deliv_code'));

					list($trade_code_tmp,$deliv_time) = explode("-",$deliv_code);
					list($trade_code,$order_cnt) = explode("_",$trade_code_tmp);

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
					$remain_pack_sql = "
						select sum(prod_cnt) as remain_pack from dh_trade_deliv_prod
						where deliv_code >= '{$deliv_code}' and trade_code = '{$trade_code}'
						and (select deliv_stat from dh_trade_deliv_info where deliv_code = dh_trade_deliv_prod.deliv_code) not in (3,4,5)
					";
					$remain_pack = $this->common_m->self_q($remain_pack_sql,"row");
					$data['remain_pack_ea'] = $remain_pack->remain_pack;

					//유효한 배송건 카운팅
					$deliv_count_sql = "select count(idx) as cnt from dh_trade_deliv_info where deliv_stat in (0,6) and deliv_code >= '{$deliv_code}' and trade_code = '{$trade_code}'";
					$deliv_count_res = $this->common_m->self_q($deliv_count_sql, "row");

					$data['remain_deliv_count'] = $deliv_count_res->cnt;

					//배송일에 다른 배송건 있는지 확인
					$data['dup_cnt'] = $dup_cnt = $this->common_m->self_q("select * from dh_trade_deliv_info where userid='".$data['trade_info']->userid."' and deliv_stat=0 and deliv_date='".$data['deliv_date']."' and recom_idx=0","cnt");
					if($dup_cnt){
						$data['dup_list'] = $this->common_m->self_q("select * from dh_trade_deliv_info where userid='".$data['trade_info']->userid."' and deliv_stat=0 and deliv_date='".$data['deliv_date']."' and recom_idx=0","result");
					}

					$this->load->view("/html/order_edit_deliv_pause",$data);
				}

			}
			else if($mode == "restart_deliv"){	//배송 재시작

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
						$result = $this->common_m->insert_log($userid,timenow(),'배송 재시작',$log_text,$info_insert['deliv_code'],'본인');
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
			else{	// 기본리스트
				$limit_date = date("Y-m-d",strtotime('+2 day'));
				$data['limit_date'] = $limit_date;

				$sql = "
					select
						distinct a.deliv_stat, a.deliv_date, a.deliv_code, a.prod_name,
						c.recom_dates, c.recom_is, c.sample_is, c.trade_stat, c.grade_change, c.grade_change_recom_idx, c.recom_week_type, c.remain_deliv_count, c.recom_week_count, c.trade_code,
						b.goods_name

					from dh_trade_deliv_info a
						left join dh_trade_goods b on a.tg_idx = b.idx
						left join dh_trade c on a.trade_code = c.trade_code

					where a.userid = '{$userid}'
						and c.recom_is = 'y'
						and c.trade_stat in (2,3)
						and a.deliv_date >= '{$limit_date}'
						and a.deliv_stat in (0,6)
					order by c.idx desc, a.deliv_date asc
				";

				$data['list'] = $this->common_m->self_q($sql,"result");

				$usql = "select * from dh_trade_deliv_info where userid = '{$userid}' and deliv_stat = 0 and recom_idx = 0";
				$data['info_list'] = $this->common_m->self_q($usql,"result");

				$pause_list_sql = "select *,(SELECT goods_name FROM dh_trade_goods WHERE cate_no = 'recom' AND trade_code = dh_trade.trade_code) AS prod_name from dh_trade where userid = '{$userid}' and trade_stat = '31'";
				$data['pause_list'] = $this->common_m->self_q($pause_list_sql,"result");

				//휴일 안씀
				//$holis = $this->common_m->self_q("select * from dh_deliv_holi","result");
				//$arr_holi = array();
				//foreach($holis as $hl){
				//	$arr_holi[] = $hl->holiday;
				//}

				foreach($data['pause_list'] as $palt){
					$delivs = $this->common_m->self_q("select deliv_date from dh_trade_deliv_info where trade_code = '".$palt->trade_code."'","result");
					$arr_delivs = array();
					foreach($delivs as $dlv){
						$arr_delivs[] = $dlv->deliv_date;
					}

					$arr_delivs_grp_tcode = array();

					$arr_delivs_grp_tcode[$palt->trade_code] = $arr_delivs;
				}

				$data['arr_holi'] = $arr_delivs_grp_tcode;

				$deliv_list = $this->common_m->self_q("select * from dh_trade_deliv_info where userid = '{$userid}' order by deliv_code asc","result");
				$deliv_info_arr = array();
				foreach($deliv_list as $dl){
					$dcode_arr = explode("-",$dl->deliv_code);
					${'dcount_'.$dcode_arr[0]}++;
					$deliv_info_arr[$dl->trade_code][$dcode_arr[0]][$dl->deliv_date] = ${'dcount_'.$dcode_arr[0]};
				}
				$data['deliv_info_arr'] = $deliv_info_arr;

				$view = $this->uri->segment(2);
				$this->load->view("/html/".$view,$data);
			}
		}
		else{
			$this->load->view("/html/please_login",$data);
		}

	}

	/*
	사용안하기로 함
	public function order_edit05($data=''){	//배송 몰아받기

		$userid = $this->session->userdata('USERID');

		if($userid){

			if($_POST){

				//pr($_POST);
				$deliv_code = $this->input->post('deliv_code');
				$deliv_count = $this->input->post('deliv_count');
				$count_between = $this->input->post('count_between');

				list($trade_code,$deliv_time) = explode("-",$deliv_code);

				$trade_info = $this->common_m->self_q("select * from dh_trade where trade_code = '{$trade_code}'","row");

				$sun_type = $trade_info->recom_delivery_sun_type;
				$week_type = $trade_info->recom_week_type;
				$arr_week_type = explode(":",$week_type);
				$day_count = $trade_info->recom_week_day_count;

				$update_recom_dates = explode("^",substr($trade_info->recom_dates,0,-1));

				$deliv_info = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '{$deliv_code}'","row");

				$s_date = $deliv_info->deliv_date;
				$sdatetime = strtotime($s_date);

				$mon = date("Y-m-d",strtotime('monday this week',$sdatetime));
				$wed = date("Y-m-d",strtotime('wednesday this week',$sdatetime));
				$thu = date("Y-m-d",strtotime('thursday this week',$sdatetime));
				$sat = date("Y-m-d",strtotime('saturday this week',$sdatetime));
				$yes = date("Y-m-d",strtotime('yesterday',$sdatetime));

				if($day_count >= 6 and $arr_week_type[0] == 2){
					$_wk = date("w",$sdatetime);
					if($_wk < 4){
						$start_date = $mon;
						$end_date = $wed;
					}
					else{
						$start_date = $thu;
						$end_date = $sat;
					}
				}
				else{
					$start_date = $yes;
					$end_date = $s_date;
				}

				$sql = "select a.*, b.cate_no
								from dh_recom_food_table a
									left join dh_goods b on a.goods_idx = b.idx
								where a.recom_food_idx = '".$deliv_info->recom_idx."'
											and a.recom_date between '{$start_date}' and '{$end_date}'
								order by recom_date desc";

				$_row = $this->common_m->self_q($sql,"fetch_array");

				$info_list = $this->common_m->self_q("select * from dh_trade_deliv_info where trade_code = '{$trade_code}' and deliv_code > '{$deliv_code}' order by deliv_code asc","result");
				$info_sum = $this->common_m->self_q("select sum(prod_cnt) as remain from dh_trade_deliv_prod where trade_code = '{$trade_code}' and deliv_code > '{$deliv_code}'","row");
				//$remain_cnt = $info_sum->remain;
				//$add_cnt = 0;

				$isnert_prod_data['trade_code'] = $deliv_info->trade_code;
				$isnert_prod_data['deliv_code'] = $deliv_info->deliv_code;
				$isnert_prod_data['deliv_date'] = $deliv_info->deliv_date;
				$isnert_prod_data['recom_idx'] = $deliv_info->recom_idx;
				$isnert_prod_data['recom_is'] = "Y";
				$isnert_prod_data['prod_cnt'] = '1';

				foreach($info_list as $row){
					$update_recom_dates = array_diff($update_recom_dates,array($row->deliv_date));
					foreach($_row as $r){
						$isnert_prod_data['goods_idx'] = $r['goods_idx'];
						$isnert_prod_data['cate_no'] = $r['cate_no'];
						$isnert_prod_data['wdate'] = timenow();

						$this->common_m->insert2("dh_trade_deliv_prod",$isnert_prod_data);

						if($sun_type && $day_count == 7 ){
							if( date('w',strtotime($row->deliv_date)) > 4 ){
								if(date('w',strtotime($r['recom_date'])) == $sun_type){
									$isnert_prod_data['goods_idx'] = $r['goods_idx'];
									$isnert_prod_data['cate_no'] = $r['cate_no'];
									$isnert_prod_data['wdate'] = timenow();

									$this->common_m->insert2("dh_trade_deliv_prod",$isnert_prod_data);
								}
							}
						}
					}
					$result = $this->common_m->self_q("delete from dh_trade_deliv_prod where deliv_code = '".$row->deliv_code."'","delete");
				}

				if($result){
					$result = $this->common_m->self_q("delete from dh_trade_deliv_info where trade_code = '{$trade_code}' and deliv_code > '".$deliv_info->deliv_code."'","delete");

					if($result){

						$recom_dates_new = "";
						foreach($update_recom_dates as $urd){
							$recom_dates_new .= $urd."^";
						}

						$this->common_m->self_q("update dh_trade set recom_dates = '{$recom_dates_new}' where trade_code = '{$trade_code}'","update");

						$this->common_m->self_q("update dh_trade_goods set recom_dates = '{$recom_dates_new}' where trade_code = '{$trade_code}' and cate_no = 'recom'","update");

						//로그기록
						$log_text = date("Y-m-d",$sdatetime)."(".numberToWeekname(date("Y-m-d",$sdatetime)).") ".$deliv_count."회차에 몰아받기가 요청되어 ".$count_between." 회차분 식단과 배송일 변경";
						$result6 = $this->common_m->insert_log($userid,timenow(),'배송 몰아받기',$log_text,$deliv_info->deliv_code,'본인');
						if($result6){
							alert($_SERVER['HTTP_REFERER']);
						}
					}
				}

			}
			else{
				$limit_date = date("Y-m-d",strtotime('+2 day'));

				$sql = "select distinct b.*, a.recom_dates, a.recom_is, a.sample_is
								from dh_trade a
									left join dh_trade_deliv_info b on a.trade_code = b.trade_code
								where a.userid = '{$userid}'
									and a.recom_is = 'Y'
									and a.trade_stat between 2 and 3
									and b.deliv_date between
										(select min(deliv_date) from dh_trade_deliv_info where trade_code = b.trade_code and deliv_stat = 0 and deliv_date > '{$limit_date}')
										and
										(select max(deliv_date) from dh_trade_deliv_info where trade_code = b.trade_code and deliv_stat = 0 and deliv_date > '{$limit_date}')
									and (
									select count(idx) from dh_trade_deliv_info where trade_code = a.trade_code and deliv_date between
										(select min(deliv_date) from dh_trade_deliv_info where trade_code = b.trade_code and deliv_stat = 0 and deliv_date > '{$limit_date}')
										and
										(select max(deliv_date) from dh_trade_deliv_info where trade_code = b.trade_code and deliv_stat = 0 and deliv_date > '{$limit_date}')
									) > 1
								order by a.idx desc, b.deliv_date asc
								";

								//echo $sql;

				$data['list'] = $this->common_m->self_q($sql,"result");

				$usql = "select * from dh_trade_deliv_info where userid = '{$userid}' and deliv_stat = 0 and recom_idx = 0";
				$data['info_list'] = $this->common_m->self_q($usql,"result");

				$view = $this->uri->segment(2);
				$this->load->view("/html/".$view,$data);
			}

		}
		else{
			$this->load->view("/html/please_login",$data);
		}

	}
	*/

	public function call_deliv_addr(){	//주소값 자동 불러오기

		$userid = $this->input->get('userid');
		$addr_type = $this->input->get('val');

		$json = array();
		$row = $this->common_m->self_q("select * from dh_member where userid = '".$this->input->get('userid')."'","row");

		if($addr_type == "home"){
			$json['name'] = $row->name;
			$json['phone'] = $row->phone1."-".$row->phone2."-".$row->phone3;
			$json['zipcode'] = $row->zip1;
			$json['addr1'] = $row->add1;
			$json['addr2'] = $row->add2;
		}
		else if($addr_type == "self"){
			$json['name'] = $row->name;
			$json['phone'] = $row->phone1."-".$row->phone2."-".$row->phone3;
			$json['zipcode'] = '';
			$json['addr1'] = '';
			$json['addr2'] = '';
		}
		else{
			$json['name'] = $row->{$addr_type."_name"};
			$json['phone'] = $row->{$addr_type."_phone1"}."-".$row->{$addr_type."_phone2"}."-".$row->{$addr_type."_phone3"};
			$json['zipcode'] = $row->{$addr_type."_zip"};
			$json['addr1'] = $row->{$addr_type."_addr1"};
			$json['addr2'] = $row->{$addr_type."_addr2"};
		}

		echo json_encode($json);

	}

	public function deliv_addr_list_change(){	//배송지변경 리스트에서 셀렉트값 변경시 주소값도 같이 변경
		$deliv_code = $this->input->get('deliv_code');

		$row = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '{$deliv_code}'","row");

		echo '<span class="blue"> #'.DelivAddrName($row->deliv_addr).': </span>'.$row->addr1;

	}

	public function ajax_allergy(){	//메뉴변경 알러지 체크 흐미 징한그
		$alg1 = $this->input->get('alg1');
		$alg2 = $this->input->get('alg2');
		$alg3 = $this->input->get('alg3');
		$alg4 = $this->input->get('alg4');
		$alg5 = $this->input->get('alg5');

		$json = array();

		if($alg1) $json[] = $alg1;
		if($alg2) $json[] = $alg2;
		if($alg3) $json[] = $alg3;
		if($alg4) $json[] = $alg4;
		if($alg5) $json[] = $alg5;

		echo json_encode($json);
	}

	public function change_grade(){	//단계변경 단계선택시 차액 계산

		/*
		* ..
		할인을 적용한 금액에 대한 차액을 뽑아야되나?
		할인을 적용하지 않은 금액에 대한 차액을 뽑아야 하냐?
		근데 어차피 할인 적용해서 구매한걸 바꾸는거니까 할인 적용해서 차액을 뽑아주는게 맞겠지.
		*/

		$deliv_code = urldecode($this->input->get('deliv_code'));	//배송코드
		list($trade_code_tmp,$deliv_date_time) = explode("-",$deliv_code);	//배송코드를 주문코드와 날짜타임으로 반환
		list($trade_code,$recom_order_cnt) = explode("_",$trade_code_tmp);
		$change_recom_idx = $this->input->get('change_recom_idx');	//변경할 단계 idx
		$recom_idx = $this->input->get('recom_idx');	//현재단계 idx
		$deliv_count = $this->input->get('deliv_count');	//배송회차

		//추천식단의 정보 가져오기
		$trade_info = $this->common_m->self_q("select * from dh_trade where trade_code = '{$trade_code}'","row");	//주문정보

		//회원 포인트 총합
		$member_point = $this->common_m->self_q("select sum(point) as total_point from dh_point where userid = '".$trade_info->userid."'","row");

		$week_count = $trade_info->recom_week_count;	//주차 정보 ( 1주 ~ 4주 )
		$sun_type = $trade_info->recom_delivery_sun_type;	//일요일꺼 받는날짜 ( 4 ~ 6 목 ~ 금 )
		$week_day_count = $trade_info->recom_week_day_count;	//몇일분인지 ( 7, 6, 4 )
		$week_type = $trade_info->recom_week_type;	//배송요일 ( 수토, 화금, 화목토 )
		$week_type_arr = explode(":",$week_type);	//1주 배송횟수 [0] 배송요일[1]
		$recom_date = $trade_info->recom_dates;	//배송일자들

		//현재단계 정보 추출 및 금액 산출
		$now_grade_info = $this->common_m->self_q("select * from dh_recom_food where idx = '{$recom_idx}'","row");	//추천식단 정보 DB
		$now_grade_foods_info = unserialize($now_grade_info->food_info);	//추천식단 가격정책 배열
		$now_grade_price = ($now_grade_foods_info[$week_day_count]['price_origin'] * $week_count) - ($now_grade_foods_info[$week_day_count]['delivery_week_count'][$week_count]['price']);	//1주가격 * 주차 - 주차에따른 할인액

		foreach($now_grade_foods_info as $fst_key=>$val){	//추가할인 (배송요일에 따른) 추출
			if($fst_key == $week_day_count){	//key값 대조 (몇일분)
				foreach($val['delivery_week_type'] as $key=>$delivery_week_type){	//키값에 맞는 배열 추출
					if($delivery_week_type['val'] == $week_type){	//요일정보가 맞는경우
						$delivery_week_type_key = $key;	//배송요일 키값 담고 종료
						break;
					}
				}
			}
		}

		$add_discount_price = $now_grade_foods_info[$week_day_count]['delivery_week_type'][$delivery_week_type_key]['price'];	//추가할인액 산출 (배송요일에 따른)

		if($add_discount_price > 0){	//추가 할인액 값이 있을경우
			$now_grade_price -= ($add_discount_price * $week_count);	//추가 할인 적용
		}

		$deliv_total_count = $week_type_arr[0] * $week_count;	//총 배송 카운트 추출 (1주 배송횟수 * 주차수)
		$now_grade_once_deliv_price = $now_grade_price / $deliv_total_count;		// 1회배송 비용 산출
		$remain_deliv_count = $deliv_total_count - ($deliv_count-1);	//남은 배송횟수 ( 총 배송횟수 - GET으로 받은 배송회차 -1) 해당회차가 발송 전이므로
		$remain_now_grade_price = $now_grade_once_deliv_price * $remain_deliv_count;	//남은 금액 ( 1회 배송금액 * 남은 배송횟수 )

		//변경할 단계에 대한 정보
		$chg_grade_info = $this->common_m->self_q("select * from dh_recom_food where idx = '{$change_recom_idx}'","row");	// 변경할 단계의 추천식단 정보 DB
		$chg_grade_foods_info = unserialize($chg_grade_info->food_info);	//변경할 단계의 추천식단 가격정책 배열
		// 변경할 추천식단의 총액 (조건은 기존 추천식단 조건과 동일하게 ex] 7일분 4주치 수토 ) = 1주가격 * 주차 - 주차에따른 할인액
		$chg_grade_price = ($chg_grade_foods_info[$week_day_count]['price_origin'] * $week_count) - ($chg_grade_foods_info[$week_day_count]['delivery_week_count'][$week_count]['price']);
		$chg_add_discount_price = $chg_grade_foods_info[$week_day_count]['delivery_week_type'][$delivery_week_type_key]['price'];	// 변경할 단계의 요일에 따른 추가 할인액 추출
		if($chg_add_discount_price > 0){
			$chg_grade_price -= $chg_add_discount_price * $week_count;	//추가할인 적용
		}

		//변경할 단계의 이유식 총 팩수
		$chg_recom_pack_ea = $chg_grade_foods_info[$week_day_count]['count'] * $week_count;

		$chg_grade_once_deliv_price = $chg_grade_price / $deliv_total_count;	//전체 배송횟수는 동일하게 잡고 총액에서 배송횟수만큼 나눈다 (1회 배송금액 추출)
		$remain_chg_grade_price = $chg_grade_once_deliv_price * $remain_deliv_count;	//남은 배송횟수 동일하게 잡아주고 변경할 단계의 1회배송액에 곱해준다

		$deff_price = $remain_chg_grade_price - $remain_now_grade_price; // 변경할 단계의 최종 산출액에서 현재 단계의 최종 산출액을 빼고 차액을 얻는다.

		$json = array();	//이제 배열에 담자.. 후.. 끝났다.
		$json['price'] = $deff_price;	//차액	(동일조건[?일분 ?주]으로 변경할 단계 금액 - 현재 단계 금액) 할인 포함
		$before_name_arr = explode(":",$now_grade_info->recom_name);	//현재 단계 명칭 개월수 포함
		$json['before_grade_name'] = $before_name_arr[1];	//개월수 잘라낸 단계명
		$after_name_arr = explode(":",$chg_grade_info->recom_name);	//변경할 단꼐 명칭 개월수 포함
		$json['after_grade_name'] = $after_name_arr[1];	//개월수 잘라낸 단계명

		$json['remain_deliv_count'] = $remain_deliv_count;	//남은 배송 횟수
		$json['before_recom_idx'] = $recom_idx;	//현재단계 추천식단 idx
		$json['after_recom_idx'] = $change_recom_idx;	//변경할 단계 추천식단 idx

		//스마트하게 미리 포인트 산출해서 포인트 안되면 포인트결제버튼 제거하자
		$json['total_point'] = $member_point->total_point;
		$json['before_name'] = $now_grade_info->recom_name;
		$json['after_name'] = $chg_grade_info->recom_name;
		$json['chg_recom_pack_ea'] = $chg_recom_pack_ea;

		//주문번호
		$json['trade_code'] = $trade_code;

		//일요일 식단 언제 받기?
		$json['deliv_sun_type'] = $sun_type;

		//추천식단 몇일분?
		$json['week_day_count'] = $week_day_count;

		//배송요일
		$json['week_type'] = $week_type;

		echo json_encode($json);
	}

	public function cancel_list($data=''){
		$userid = $this->session->userdata('USERID');
		if($userid){
			$limit_date = date("Y-m-d",strtotime('+2 day'));
			$sql = "
				select distinct b.*, a.recom_dates, a.recom_is, a.sample_is, a.grade_change, a.trade_stat, a.trade_method, a.tno
				, (select grade_change_recom_name from dh_trade_goods where trade_code = a.trade_code and idx = b.tg_idx and cate_no = 'recom') as grade_change_recom_name
				from dh_trade a
					left join dh_trade_deliv_info b on a.trade_code = b.trade_code
				where a.userid = '{$userid}'
					and a.trade_stat between 1 and 3
					and b.deliv_date > '{$limit_date}'
				order by a.idx desc, b.deliv_date asc
			";

			if($_SERVER['REMOTE_ADDR'] == "112.221.155.109"){

			}

			$data['list'] = $this->common_m->self_q($sql,"result");

			$deliv_list = $this->common_m->self_q("select * from dh_trade_deliv_info where userid = '{$userid}' order by deliv_code asc","result");
			$deliv_info_arr = array();
			foreach($deliv_list as $dl){
				if($dl->recom_idx){
					$dcode_arr = explode("-",$dl->deliv_code);
					${'dcount_'.$dcode_arr[0]}++;
					$deliv_info_arr[$dl->trade_code][$dcode_arr[0]][$dl->deliv_date] = ${'dcount_'.$dcode_arr[0]};
				}
			}
			$data['deliv_info_arr'] = $deliv_info_arr;

			$this->load->view("/html/cancel_list",$data);
		}
		else{
			$this->load->view("/html/please_login",$data);
		}
	}

	public function addr_change(){

		$type = $this->input->get('type');
		$userid = $this->input->get('userid');

		$mem = $this->common_m->self_q("select * from dh_member where userid = '{$userid}'","row");

		$json = array();

		if($type == "home"){
			$json['name'] = $mem->name;
			$json['zipcode'] = $mem->zip1;
			$json['address1'] = $mem->add1;
			$json['address2'] = $mem->add2;
			$json['phone1'] = $mem->phone1;
			$json['phone2'] = $mem->phone2;
			$json['phone3'] = $mem->phone3;
		}
		else{
			$json['name'] = $mem->{$type."_name"};
			$json['zipcode'] = $mem->{$type."_zip"};
			$json['address1'] = $mem->{$type."_addr1"};
			$json['address2'] = $mem->{$type."_addr2"};
			$json['phone1'] = $mem->{$type."_phone1"};
			$json['phone2'] = $mem->{$type."_phone2"};
			$json['phone3'] = $mem->{$type."_phone3"};
		}

		echo json_encode($json);

	}

	public function order_cancel(){
		$deliv_code = $this->input->get('deliv_code');
		$cancel_msg = urldecode($this->input->get('ccmsg'));
		$rp = $this->input->get('rp');
		$dcode = urldecode($this->input->get('dcode'));

		//$tmpcode = explode("-",$deliv_code);
		//$trade_code = $tmpcode[0];

		$deliv_code_tmp = deliv_code_arr($deliv_code);
		$trade_code = $deliv_code_tmp['trade_code'];

		$trade_update = $this->common_m->self_q("update dh_trade set trade_stat = '10', trade_day_cancel = now(), cancel_msg = '{$cancel_msg}', return_price = '{$rp}', cancel_deliv_codes = '{$dcode}' where trade_code = '{$trade_code}'","update");
		if($trade_update){
			$deliv_info_update = $this->common_m->self_q("update dh_trade_deliv_info set deliv_stat = '5' where trade_code = '{$trade_code}' and deliv_code >= '{$deliv_code}' and deliv_stat = 0","update");
			if($deliv_info_update){
				//echo "ok";
				$log_data['userid'] = $this->session->userdata('USERID');
				$log_data['type'] = "주문취소 요청";
				$log_data['msg'] = "주문번호 : ".$trade_code." 주문 취소 요청 접수";
				$log_data['deliv_code'] = $deliv_code;
				$log_data['wdate'] = timenow();
				$log_data['writer'] = "본인";
				$result = $this->common_m->insert2("dh_trade_deliv_log",$log_data);
				if($result){
					echo "ok";
				}
			}
		}

	}

	public function apibox_noti(){	//apibox 연동

		$r_arrow_ip = array(
			gethostbyname('apibox.kr'),		/* APIBOX 실서버 */
			gethostbyname('whenji.com'),	/* APIBOX 백업서버 */
			'112.221.155.109',								/* 이곳에 개발PC IP주소등 접속허용IP를 기록하세요 */
			gethostbyname('ecomommeal.co.kr')
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
				exit;
			}
		}

	}

	public function pg_pay_validation(){
		$trade_code = $this->input->get('trade_code');
		$sql = "select * from dh_trade_tmp where trade_code = '".$trade_code."'";
		$json['sql'] = $sql;
		$list = $this->common_m->self_q($sql,"cnt");
		$json['cnt'] = $list;
		echo json_encode($json);
	}

	public function naver_pay(){ //네이버결제
		$trade_code = $this->input->post('trade_code');

		$data['goods_info'] = $this->common_m->goods_info();
		$result = $this->order_m->getCart($code,$query);
		$data['cart_list'] = $result['list'];

		foreach($data['cart_list'] as $lt){
			$data['option_arr'.$lt->idx] = $result['option_arr'.$lt->idx];
		}


		$trade_result = $this->common_m->naver_pay($this->input->post('paymentId')); //결제 승인

		if($trade_result){

			if($trade_result->code == "Success"){ //결제 성공 시
				$this->order_m->trade($trade_code,$data); // 주문 담기

				$update_data['paymentId'] = $trade_result->body->detail->paymentId;  //네이버페이 결제번호
				$update_data['payHistId'] = $trade_result->body->detail->payHistId;  //네이버페이 결제 이력 번호
				$update_data['admissionTypeCode'] = $trade_result->body->detail->admissionTypeCode;  //결제승인 유형 01:원결제 승인건, 03:전체취소 건, 04:부분취소 건
				$update_data['trade_day_ok'] = $trade_result->body->detail->tradeConfirmYmdt;  //거래완료 일시(정산기준날짜, YYYYMMDDHH24MMSS) 비에스크로 가맹점은 결제일/취소일시와 같은 값을 가지고, 에스크로 가맹점은 거래완료 API를 호출하여야 값이 반환됩니다
				$update_data['primaryPayMeans'] = $trade_result->body->detail->primaryPayMeans;  //주 결제 수단 CARD:신용카드, BANK:계좌이체
				$update_data['cardInstCount'] = $trade_result->body->detail->cardInstCount;  //할부 개월 수 (일시불은 0)
				$update_data['cardAuthNo'] = $trade_result->body->detail->cardAuthNo;  //카드승인번호 , 취소 시에는 승인 번호 개념이 없으므로 원결제 승인 건에 대해서만 이 값이 반환됩니다
				$update_data['cardCorpCode'] = $trade_result->body->detail->cardCorpCode;  //주 결제 수단 카드사
				/*카드사 C0-신한 C1-비씨	C2-광주	C3-KB국민	C4-NH	C5-롯데	C6-산업	C7-삼성	C8-수협	C9-씨티	CA-외환	CB-우리	CC-전북	CD-제주	CF-하나-외환	CH-현대*/
				$update_data['npointPayAmount'] = $trade_result->body->detail->npointPayAmount;  //네이버페이 포인트 사용
				$update_data['total_price'] = $trade_result->body->detail->primaryPayAmount;  //최종 결제 금액

				if($trade_result->code == "Success"){
					$update_data['trade_stat'] = "2";
				}
				$this->common_m->update2("dh_trade",$update_data,array('trade_code'=>$trade_result->body->detail->merchantPayKey));
			}else{ // 결제 실패 시 로그기록
				$insert['trade_code'] = $trade_code;
				$insert['msg'] = $trade_result->message;
				$insert['regDate'] = date('Y-m-d H:i:s');

				$this->common_m->insert2("dh_naver_pay",$insert);
			}
		}
		echo json_encode($trade_result);
	}

	public function order_apply(){	//의기양양 신청페이지
		$json = array();

		$goods_info = $this->common_m->self_q("select * from dh_goods where idx= '".$this->input->post('goods_idx')."'","row");

		$add1 = date("Y년 m월 d일",strtotime($goods_info->apply_fdate));

		$insert_datas['userid'] = $this->input->post("userid", true);
		$insert_datas['name'] = $this->input->post("name", true);
		$insert_datas['phone'] = $this->input->post("phone", true);
		$insert_datas['goods_idx'] = $this->input->post("goods_idx", true);
		$insert_datas['goods_name'] = $this->input->post("goods_name", true);
		$insert_datas['cate'] = $this->input->post("cate", true);
		$insert_datas['wdate'] = timenow();

		$result = $this->common_m->insert2("dh_order_apply",$insert_datas);
		if($result){
			$token = $this->kkoat_m->token_generation();

			$phone = $insert_datas['phone'];
			$name = $insert_datas['name'];
			$add2 = '';

			$msg = "{$name}님,\n의기양양픽 이유식 나눔에 신청완료 되었습니다.\n당첨유무는 {$add1} {$add2}에 받아보실 수 있습니다.\n(수신거부의 경우 안내를 받을 수 없으니, 유의하시기 바랍니다.)\n\n에코맘의 산골이유식";
			$tmpcode = "M_01459_220";
			$this->kkoat_m->ent_prise_kakao_send($token,$phone,$msg,$tmpcode);

			$json['res'] = "ok";
		}
		else{
			$json['res'] = "err";
		}

		echo json_encode($json);
	}

	public function order_verification(){
		$trade_code = $this->input->get('trade_code');
		$pg_price = $this->input->get('pg_price');
		$userid = $this->input->get('userid');

		$json = array();

		// 금액 검증
		// 장바구니 토탈 금액
		// SELECT SUM(total_price) AS cart_total FROM dh_cart WHERE userid = '{$userid}' AND trade_ok != 1
		$cart_total = $this->common_m->self_q("SELECT SUM(total_price) AS cart_total FROM dh_cart WHERE userid = '{$userid}' AND trade_ok != 1","row");
		$json['cart_verific'] = ($pg_price == $cart_total->cart_total);

		// tmp 존재여부 검증
		$tmp_cnt = $this->common_m->self_q("select * from dh_trade_tmp where trade_code = '{$trade_code}'","cnt");
		$json['tmp_cnt'] = $tmp_cnt;

		// 배송일 검증
		$cart_list = $this->common_m->self_q("select * from dh_cart where trade_code = '{$trade_code}'","result");
		$json['deliv_date'] = true;

		if((int)date("H") < 7){
			$ok_date = strtotime(date("Y-m-d",strtotime('+1 day')));
		}
		else{
			$ok_date = strtotime(date("Y-m-d",strtotime('+2 day')));
		}

		foreach($cart_list as $lt){
			if(strtotime($lt->date_bind) >= $ok_date){
			}
			else{
				$json['deliv_date'] = false;
			}
		}


		echo json_encode($json);
	}

	public function deposit_ok($data=''){
		$trade_code=$this->uri->segment(3);
		$trade_cnt = $this->common_m->getCount("dh_trade","where trade_code='$trade_code'","idx");
		$data['goods_info'] = $this->common_m->goods_info();
		$data['week_name_arr'] = array('일','월','화','수','목','금','토');

		if($trade_cnt > 0){

			$data['trade_code'] = $trade_code;
			$data['trade_stat'] = $this->common_m->getRow2("dh_trade","where trade_code='".$this->db->escape_str($trade_code)."' order by idx desc limit 1");

			$result = $this->order_m->getTradeOption($trade_code);
			$data['goods_list'] = $result['goods_list'];
			foreach($data['goods_list'] as $lt){
				$data['option_arr'.$lt->idx] = $result['option_arr'.$lt->idx];
			}

			if($data['trade_stat']->userid && $data['trade_stat']->coupon_idx){
				$data['coupon_stat'] = $this->common_m->getRow2("dh_coupon_use","where idx='".$this->db->escape_str($data['trade_stat']->coupon_idx)."'");
			}

			$this->load->view("/html/deposit_ok",$data);

		}else{
			back("잘못된 접근입니다.");
		}
	}

}
