<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Dh_Product extends CI_Controller {

 	function __construct()
	{
		parent::__construct();
    $this->load->model('product_m');
		$this->load->helper('form');

		if(!$this->input->get('file_down')){
			@header("Content-Type: text/html; charset=utf-8");
		}
	}


	public function index()
	{
		alert("/html/dh_product/lists/shop");
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

	}


	function prod_list($data='')
	{
		$brand = $this->uri->segment(3,'');


		/* 제품 데이터 start */

		$name = $this->input->get('name');
		$cate_no = $this->input->get('cate_no');
		$type = $this->input->get('type');

		$data['query_string'] = "?";
		$where_query = " where display=1";
		if($type == "nmk"){
			$data['query_string'] .= "&type=".$type;
			$where_query.=" and night_market=1";
		}
		else{
			$where_query.=" and night_market!=1";
		}
		$order_query = " ranking asc, idx desc ";

		if($cate_no){
			$data['query_string'] .= "&cate_no=".$cate_no;
			$where_query .= " and cate_no like '$cate_no%'";
		}

		if($data['brand_no']){
			$data['query_string'] .= "&brand_no=".$data['brand_no'];
			$where_query .= " and brand_flag like '%/".$data['brand_no']."/%'";
		}


		$data['param'] = "";
		if($this->input->get("PageNumber")){
			$data['param'] = "&PageNumber=".$this->input->get("PageNumber");
		}

		$page = $this->uri->segment(2);

		/* 페이징 start */
		$PageNumber = $this->input->get("PageNumber"); //현재 페이지
		if(!$PageNumber){ $PageNumber = 1; }
		$list_num='15'; //페이지 목록개수
		$page_num='5'; //페이징 개수
		$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
		$url = cdir()."/".$this->uri->segment(1)."/".$page."/";
		$data['totalCnt'] = $this->common_m->getPageList('dh_goods','count','','',$where_query,$order_query); //게시판 리스트
		$data['Page'] = Page($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
		/* 페이징 end */

		//카테고리 정보
		$data['cate_info'] = $this->common_m->self_q("select * from dh_subinfo where cate_no like '{$cate_no}%'","row");
		$data['list'] = $this->common_m->getPageList('dh_goods','',$offset,$list_num,$where_query,$order_query,"*,(select data_txt from dh_data where flag_idx=dh_goods.idx order by idx limit 1) as b_name"); //게시판 리스트

		/* 제품 데이터 end */

		//산골간식 리스트상단 배너 추가 / 산골야시장 리스트상단 배너 추가 20190516 : 산골 간식만 한다며~~
		if($this->input->get("type")=="nmk"){
			$code="nmk_top";
		}
		else{
			$code="snack_top";
		}
		$data['list_top_banner'] = $this->common_m->self_q("select * from dh_bannerlist where parent_code='{$code}' order by sort asc","row");

		$dir = $_SERVER['DOCUMENT_ROOT']."/html/application/views/product/";
		$view = "list";
		$data['view'] = $dir.$view;
		$url = $this->common_m->get_page($page);
		$this->load->view($url,$data);
	}


	function apply_view($data='')		//의기양양 신청하기
	{
		if($this->input->get('cate_no')) $data['qst'] = "?cate_no=".$this->input->get('cate_no');
		if($this->input->get('PageNumber')) $data['qst'] .= "&PageNumber=".$this->input->get('PageNumber');
		if($this->input->get('type')) $data['qst'] .= "&type=".$this->input->get('type');

		//의기양양 당첨자 확인
		//$data['succ_cnt'] = $this->common_m->self_q("select * from dh_order_succ where year='".date('Y')."' and userid='".$this->session->userdata('USERID')."' and trade_code != ''","cnt");

		$idx = $this->uri->segment(3);
		$result = $this->product_m->getView($idx); //제품 데이타
		$data['row'] = $result['row']; // 제품상세데이터
		if(empty($result['row']->idx)){ back('존재하지 않는 상품입니다.'); exit; }

		if($this->input->get("ajax")==1 && $this->input->get("option_idx")){
			$data['option_row']=$this->common_m->getRow("dh_goods_option","where idx='".$this->input->get("option_idx")."'");
			$this->load->view("/product/option_sel",$data);
		}else{
			$data['best_row'] = $result['best_row']; //추천상품 리스트
			$data['data_list'] = $result['data_list']; //제품 연관 데이타
			if(count($result['file_list']) > 0){
				$data['file_list'] = $result['file_list']; //추가 제품 이미지
			}else{
				$data['file_list']="";
			}

			$data['row']->icon_flag = explode('/',$data['row']->icon_flag);

			$page = $this->uri->segment(2);

			//회원정보
			if($this->session->userdata('USERID')){
				$data['member_info'] = $this->common_m->self_q("select * from dh_member where userid = '".$this->session->userdata('USERID')."'","row");
			}

			//신청 테이블에서 신청 내역이 있는지 조회
			$userid = $data['member_info']->userid;
			$goods_idx = $idx;
			$sql = "select * from dh_order_apply where userid = '{$userid}' and goods_idx = '{$goods_idx}'";
			$data['apply_cnt'] = $this->common_m->self_q($sql,"cnt");

			//주문 테이블에서 주문 내역이 있는지 조회
			$sql = "
				select count(idx) as cnt
				from dh_trade
				where userid = '".$this->session->userdata('USERID')."'
				and trade_stat in (1,2,3,4)
				and trade_code in (select trade_code from dh_trade_goods where cate_no in (10) and date_format(trade_day,'%Y') = '".date("Y")."')
			";
			$cnt = $this->common_m->self_q($sql,"row");
			$data['buy_cnt'] = $cnt->cnt;

			$dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/product/";

			if($data['shop_info']['shop_use']=="y"){
				$view = "apply_view";
			}else{
				$view = "view";
			}
			$data['view'] = $dir.$view;
			$url = $this->common_m->get_page($page);
			$this->load->view($url,$data);
		}

	}

	function prod_view($data='')
	{
		if($this->input->get('cate_no')) $data['qst'] = "?cate_no=".$this->input->get('cate_no');
		if($this->input->get('PageNumber')) $data['qst'] .= "&PageNumber=".$this->input->get('PageNumber');
		if($this->input->get('type')) $data['qst'] .= "&type=".$this->input->get('type');


		$idx = $this->uri->segment(3);
		$result = $this->product_m->getView($idx); //제품 데이타
		$data['row'] = $result['row']; // 제품상세데이터
		if(empty($result['row']->idx)){ back('존재하지 않는 상품입니다.'); exit; }

		if($this->input->get("ajax")==1 && $this->input->get("option_idx")){
			$data['option_row']=$this->common_m->getRow("dh_goods_option","where idx='".$this->input->get("option_idx")."'");
			$this->load->view("/product/option_sel",$data);
		}else{
			$data['best_row'] = $result['best_row']; //추천상품 리스트
			$data['data_list'] = $result['data_list']; //제품 연관 데이타
			if(count($result['file_list']) > 0){
				$data['file_list'] = $result['file_list']; //추가 제품 이미지
			}else{
				$data['file_list']="";
			}

			//$data['best_prd'] = $this->product_m->getbestPrd($data['row']->best_prd,'bbs'); //게시판 or 추천제품 연동시

			$data['row']->icon_flag = explode('/',$data['row']->icon_flag);

			$data['option_flag_cnt'] = $this->common_m->getCount("dh_goods_option","where level=1 and goods_idx = '$idx' and flag=1");
			$data['option_flag_cnt2'] = $this->common_m->getCount("dh_goods_option","where level=1 and goods_idx = '$idx' and flag=0");

			for($kk=1;$kk<=3;$kk++){

				$data['option_row'.$kk] = $this->common_m->getRow("dh_goods_option","where level=1 and goods_idx = '$idx' and chk_num='".$kk."'");

				if(isset($data['option_row'.$kk]->code)){
					$data['option_list_cnt'.$kk] = $this->common_m->getCount("dh_goods_option","where level=2 and goods_idx = '$idx' and code='".$data['option_row'.$kk]->code."'");
					$data['option_list'.$kk] = $this->common_m->getList("dh_goods_option","where level=2 and goods_idx = '$idx' and code='".$data['option_row'.$kk]->code."'");
				}
			}

			$page = $this->uri->segment(2);

			//단일 상품 예약배송에 추가 기능 개발
			//직접 입력 이외, 장바구니 배송일 기준, DB에 존재하는 배송일 포함
			//우선 장바구니에 있는 정기주문 및 배송일자 가져오기
			$cart_deliv_list = $this->common_m->self_q("select * from dh_cart where userid = '".$this->session->userdata('USERID')."' and code = '".$this->session->userdata('CART')."' and trade_ok != '1' and goods_idx != '484'","result");
			foreach($cart_deliv_list as $cdl){
				$cart_deliv_arr[$cdl->date_bind]['text'][] = $cdl->goods_name;
			}

			$data['cart_deliv_arr'] = $cart_deliv_arr;

			//정기주문일자 가져오기
			//배송스탯 대기인것들 중 날짜가 오늘 +2일 보다 큰것들만
			//			$deliv_aceppt_date = date('Y-m-d',strtotime('+2 day'));
			//			$order_deliv_sql = "select * from dh_trade where trade_stat between '2' and '3' and userid = '".$this->session->userdata('USERID')."' and recom_is = 'Y'";
			//
			//			//echo $order_deliv_sql;
			//
			//			$order_deliv_list = $this->common_m->self_q($order_deliv_sql,"result");
			//			$order_deliv_arr = array();
			//			foreach($order_deliv_list as $odl){
			//				$deliv_code_arr = explode("^",$odl->recom_dates);
			//				if($odl->recom_is == 'Y'){
			//					$add_sql = " and goods_idx = '0' and trade_code = '".$odl->trade_code."'";
			//				}
			//
			//				for($i=0;$i<count($deliv_code_arr);$i++){
			//					$jj=$i+1;
			//					if($deliv_code_arr[$i] >= $deliv_aceppt_date){
			//						$goods_name_row = $this->common_m->self_q("select goods_name from dh_trade_goods where 1 {$add_sql}","row");
			//						$goods_name_arr = explode(":",$goods_name_row->goods_name);
			//						$goods_name_re_arr = explode("]",$goods_name_arr[0]);
			//						$order_deliv_arr[$deliv_code_arr[$i]]['text'][] = $goods_name_re_arr[0]."] ".trim(@$goods_name_arr[1])." ".$jj."회차 ( 주문번호 : ".$odl->trade_code." )";
			//					}
			//				}
			//			}

			//20180529 예약배송추가 부분 개발 수정작업
			//쿼리 변경하고 정기배송 리스트중에 배송대기중인 것만 추출하여 날짜별로 정렬
			if($this->session->userdata('USERID')){
				$deliv_aceppt_date = date('Y-m-d',strtotime('+2 day'));
				//				$order_deliv_sql = "
				//					select distinct b.*, a.recom_dates
				//						from dh_trade a
				//					left join dh_trade_deliv_info b on a.trade_code = b.trade_code
				//					left join dh_trade_deliv_prod c on b.deliv_code = c.deliv_code
				//					where a.userid = '".$this->session->userdata('USERID')."'
				//						and a.trade_stat between 2 and 3
				//						and c.recom_is = 'Y'
				//						and b.deliv_stat = '0'
				//						and b.deliv_date > '{$deliv_aceppt_date}'
				//					order by b.deliv_date asc
				//				";

				$order_deliv_sql = "
					select * from dh_trade_deliv_info
						where userid = '".$this->session->userdata('USERID')."' and deliv_stat = '0' and deliv_date > '{$deliv_aceppt_date}' and recom_idx > 0 and trade_code in (select trade_code from dh_trade where trade_stat between 2 and 3)
				";

				$order_deliv_list = $this->common_m->self_q($order_deliv_sql,"result");
				$order_deliv_arr = array();
				foreach($order_deliv_list as $odlt){
					$deliv_code_arr = explode("-",$odlt->deliv_code);
					${$deliv_code_arr[0]}++;
					$order_deliv_arr[$odlt->deliv_code]['trade_code'] = $odlt->trade_code;
					$order_deliv_arr[$odlt->deliv_code]['deliv_code'] = $odlt->deliv_code;
					$order_deliv_arr[$odlt->deliv_code]['deliv_count'] = ${$deliv_code_arr[0]};
					$order_deliv_arr[$odlt->deliv_code]['prod_name'] = $odlt->prod_name;
					$order_deliv_arr[$odlt->deliv_code]['deliv_date'] = $odlt->deliv_date;
				}

				$data['order_deliv_arr'] = $order_deliv_arr;
			}

			$data['default_select_date'] = date("Y-m-d",$this->start_deliv_date_free());

			// 의기양양 계정당 1회 구매 제한
			// 20201116 - 의기양양 전체 상품 연단위 1회만 구매가능하게 처리
			$sql = "
				select count(idx) as cnt
				from dh_trade
				where userid = '".$this->session->userdata('USERID')."'
				and trade_stat in (1,2,3,4)
				and trade_code in (select trade_code from dh_trade_goods where cate_no in (10) and date_format(trade_day,'%Y') = '".date("Y")."')
			";
			$cnt = $this->common_m->self_q($sql,"row");
			$data['buy_cnt'] = $cnt->cnt;

			// 의기양양 장바구니에 담겨있는지 확인
			$sql = "
				select count(idx) as cnt
				from dh_cart
				where trade_ok <> 1
				and userid = '".$this->session->userdata('USERID')."'
				and goods_idx in (882,883,884,885)
			";
			$c_cnt = $this->common_m->self_q($sql,"row");
			$data['cart_cnt'] = $c_cnt->cnt;

			//당첨자 업로드 DB와 대조하여 주문가능여부 확인

			$data['succ_order'] = false;
			$cnt = $this->common_m->self_q("select * from dh_order_succ where year='".date('Y')."' and month='".date('m')."' and userid = '".$this->session->userdata('USERID')."'","cnt");
			if($cnt){
				$data['succ_order'] = true;
			}


			$dir = $_SERVER['DOCUMENT_ROOT'].cdir()."/application/views/product/";

			if($data['shop_info']['shop_use']=="y"){
				$view = "shop_view";
			}else{
				$view = "view";
			}
			$data['view'] = $dir.$view;
			$url = $this->common_m->get_page($page);
			$this->load->view($url,$data);
		}

	}


	public function getProduct()
	{
		$cate_no = $this->uri->segment(3);
		$goods_idx = $this->input->get("goods_idx");

		if($cate_no && $this->input->get("ajax")==1)
		{
			$data='<option value="">제품을 선택해주세요</option>';
			$result = $this->common_m->getList2("dh_goods","where cate_no='$cate_no'");
			foreach($result as $list){

				$selected = "";

				if($goods_idx && $goods_idx==$list->idx){
					$selected = "selected";
				}

				$data.='<option value="'.$list->idx.'" '.$selected.'>'.$list->name.'</option>';
			}

			echo $data;

		}
	}

	public function start_deliv_date_free(){
		$deliv_date_time = $this->getScheduleStartday();	//timestamp

		$holis = array();
		$holiday = $this->common_m->self_q("select * from dh_deliv_holi where date_format(holiday, '%Y-%m') = '".date("Y-m",$deliv_date_time)."' order by holiday asc","result");
		foreach($holiday as $hl){
			$holis[$hl->holiday] = true;
		}

		$holis['2018-09-17'] = false;
		$holis['2018-09-27'] = false;
		$holis['2018-09-18'] = true;
		$holis['2018-09-19'] = true;
		$holis['2018-09-20'] = true;
		$holis['2018-10-03'] = true;
		$holis['2018-10-08'] = false;

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

	public function getScheduleStartday(){
		$result = '';

		if ((int)date('H') < 7) {
			$result = !$type ? strtotime('+1 days') : 1;
		} else {
			$result = !$type ? strtotime('+2 days') : 2;
		}

		return $result;
	}

	public function exp_apply($data=''){
		$this->load->view($data,"/html/exp_apply");
	}
}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */