<?php if (!defined('BASEPATH')) exit('No direct script access allowed');

class Order_m extends CI_Model
{


    function __construct()
    {
        parent::__construct();
    }



	//function cart($goods_idx,$code='',$buy='',$flag='') //장바구니 입력
		//{
		//	$data="";
		//
		//	if(!$code && $flag!="wish"){ //장바구니 카트 no 생성
		//		$code = $this->common_m->cart_init();
		//	}
		//
		//	$table = "dh_cart";
		//	$option_table = "dh_cart_option";
		//	$basic_query = "code='$code'";
		//	$basic_f = 'code';
		//	$basic_f2 = 'cart_idx';
		//	$userid = $this->session->userdata('USERID');
		//
		//	if($flag=="wish"){
		//		$table = "dh_wishlist";
		//		$option_table = "dh_wishlist_option";
		//		$basic_query = "userid='$userid'";
		//		$basic_f = 'userid';
		//		$basic_f2 = 'wishlist_idx';
		//		$code = $userid;
		//	}
		//
		//	$goods_stat = $this->common_m->getRow("dh_goods","where idx='".$this->db->escape_str($goods_idx)."'");
		//
		//	if($this->input->post("goods_cnt_chagne")==1){ //옵션 수량만 변경
		//
		//		$goods_point = $goods_stat->point;
		//		$total_price = $this->input->post("total_price");
		//		$cart_idx = $this->input->post("cart_idx");
		//		$data['a_idx'] = $cart_idx;
		//
		//		if($goods_point==0){
		//			$shop_info = $this->common_m->shop_info(); //shop 정보
		//			$goods_point = $total_price*$shop_info['point']*0.01;
		//		}
		//
		//		$this->db->update($table,array('goods_cnt'=>$this->input->post("goods_cnt"),'total_price'=>$total_price,'goods_point'=>$goods_point),array('idx'=>$cart_idx));
		//
		//	}else{
		//
		//
		//		$where_query = "";
		//		$cnt=0;
		//
		//		if($this->input->post("option_cnt") == 0){ //옵션이 없는경우
		//			$cnt = $this->common_m->getCount($table,"where $basic_query and cate_no='$goods_stat->cate_no' and goods_idx='$goods_stat->idx' and goods_code = '$goods_stat->code' and option_cnt=0 and trade_ok=0");
		//			$getRow = $this->common_m->getRow($table,"where $basic_query and cate_no='$goods_stat->cate_no' and goods_idx='$goods_stat->idx' and goods_code = '$goods_stat->code' and option_cnt=0 and trade_ok=0");
		//		}
		//
		//		if($cnt==0){
		//
		//		$goods_point = $goods_stat->point;
		//
		//		if($goods_point==0){
		//			$shop_info = $this->common_m->shop_info(); //shop 정보
		//			$goods_point = $this->input->post("total_price")*$shop_info['point']*0.01;
		//		}
		//
		//		$option_cnt = $this->input->post("option_cnt",true);
		//
		//		if($this->input->post("optionCnt") > 0){
		//			$option_cnt = $option_cnt+$this->input->post("optionCnt");
		//		}
		//
		//		$insert_array[$basic_f] = $code;
		//		$insert_array['cate_no'] = $goods_stat->cate_no;
		//		$insert_array['goods_idx'] = $goods_stat->idx;
		//		$insert_array['goods_code'] = $goods_stat->code;
		//		$insert_array['goods_name'] = $goods_stat->name;
		//		$insert_array['goods_price'] = $goods_stat->shop_price;
		//		$insert_array['goods_cnt'] = $this->input->post("goods_cnt",true);
		//		$insert_array['goods_point'] = $goods_point;
		//		$insert_array['goods_real_point'] = $goods_stat->point;
		//		$insert_array['total_price'] = $this->input->post("total_price",true);
		//		$insert_array['option_cnt'] = $option_cnt;
		//		$insert_array['userid'] = $userid;
		//		$insert_array['reg_date'] = date("Y-m-d H:i:s");
		//
		//		$result = $this->db->insert($table,$insert_array);
		//		$a_idx = mysql_insert_id();
		//		$data['a_idx'] = $a_idx;
		//
		//
		//			if($insert_array['option_cnt'] > 0){ //옵션이 있는경우 옵션등록 (제품옵션)
		//				$option_sel = $this->input->post("option_sel",true);
		//				$option_sel = explode("/",$option_sel);
		//				$option_sel_cnt = $this->input->post("option_sel_cnt",true);
		//				$option_sel_cnt = explode("/",$option_sel_cnt);
		//
		//
		//				if($option_sel[1]){ //제품옵션
		//
		//					for($i=1;$i<count($option_sel);$i++){
		//						if($option_sel[$i]){
		//							$option_row = $this->common_m->getRow("dh_goods_option","where idx='".$option_sel[$i]."'");
		//
		//							if($i==1){
		//
		//								$option_level1_row = $this->common_m->getRow("dh_goods_option","where code='".$option_row->code."' and level=1");
		//
		//								$insert_cart_array1 = array(
		//									$basic_f => $code,
		//									$basic_f2 => $a_idx,
		//									'goods_idx' => $goods_stat->idx,
		//									'option_idx' => $option_level1_row->idx,
		//									'option_code' => $option_level1_row->code,
		//									'level' => 1,
		//									'title' => $option_level1_row->title,
		//									'chk_num' => $option_level1_row->chk_num,
		//									'flag' => $option_level1_row->flag,
		//									'trade_day' => date('Y-m-d H:i:s')
		//								);
		//								$result = $this->db->insert($option_table,$insert_cart_array1);
		//							}
		//
		//							$insert_cart_array2 = array(
		//								$basic_f => $code,
		//								$basic_f2 => $a_idx,
		//								'goods_idx' => $goods_stat->idx,
		//								'option_idx' => $option_row->idx,
		//								'option_code' => $option_row->code,
		//								'level' => 2,
		//								'title' => $option_row->title,
		//								'name' => $option_row->name,
		//								'price' => $option_row->price,
		//								'point' => $option_row->point,
		//								'cnt' => $option_sel_cnt[$i],
		//								'chk_num' => $option_row->chk_num,
		//								'flag' => $option_level1_row->flag,
		//								'trade_day' => date('Y-m-d H:i:s')
		//							);
		//
		//							$result = $this->db->insert($option_table,$insert_cart_array2);
		//
		//						}
		//					}
		//
		//
		//					if($this->input->post("optionCnt") > 0){
		//						for($i=1;$i<=$this->input->post("optionCnt");$i++){
		//							if($this->input->post("option".$i)){
		//
		//								$option_row = $this->common_m->getRow("dh_goods_option","where idx='".$this->input->post("option".$i)."'");
		//								$option_level1_row = $this->common_m->getRow("dh_goods_option","where code='".$option_row->code."' and level=1");
		//
		//									$insert_cart_array2 = array(
		//										$basic_f => $code,
		//										$basic_f2 => $a_idx,
		//										'goods_idx' => $goods_stat->idx,
		//										'option_idx' => $option_row->idx,
		//										'option_code' => $option_row->code,
		//										'level' => 2,
		//										'title' => $option_row->title,
		//										'name' => $option_row->name,
		//										'price' => $option_row->price,
		//										'point' => $option_row->point,
		//										'cnt' => 1,
		//										'chk_num' => $option_row->chk_num,
		//										'flag' => $option_level1_row->flag,
		//										'trade_day' => date('Y-m-d H:i:s')
		//									);
		//
		//									$result = $this->db->insert($option_table,$insert_cart_array2);
		//							}
		//						}
		//					}
		//
		//				}else if($this->input->post("optionCnt") > 0){ //가격동일옵션
		//
		//					for($i=1;$i<=$this->input->post("optionCnt");$i++){
		//						if($this->input->post("option".$i)){
		//							$option_row = $this->common_m->getRow("dh_goods_option","where idx='".$this->input->post("option".$i)."'");
		//
		//							if($i==1){
		//								$option_level1_row = $this->common_m->getRow("dh_goods_option","where code='".$option_row->code."' and level=1");
		//
		//								$insert_cart_array1 = array(
		//									$basic_f => $code,
		//									$basic_f2 => $a_idx,
		//									'goods_idx' => $goods_stat->idx,
		//									'option_idx' => $option_level1_row->idx,
		//									'option_code' => $option_level1_row->code,
		//									'level' => 1,
		//									'title' => $option_level1_row->title,
		//									'chk_num' => $option_level1_row->chk_num,
		//									'flag' => $option_level1_row->flag,
		//									'trade_day' => date('Y-m-d H:i:s')
		//								);
		//								$result = $this->db->insert($option_table,$insert_cart_array1);
		//
		//							}
		//
		//
		//							$insert_cart_array2 = array(
		//								$basic_f => $code,
		//								$basic_f2 => $a_idx,
		//								'goods_idx' => $goods_stat->idx,
		//								'option_idx' => $option_row->idx,
		//								'option_code' => $option_row->code,
		//								'level' => 2,
		//								'title' => $option_row->title,
		//								'name' => $option_row->name,
		//								'price' => $option_row->price,
		//								'point' => $option_row->point,
		//								'cnt' => 1,
		//								'chk_num' => $option_row->chk_num,
		//								'flag' => $option_level1_row->flag,
		//								'trade_day' => date('Y-m-d H:i:s')
		//							);
		//
		//							$result = $this->db->insert($option_table,$insert_cart_array2);
		//
		//						}
		//					}
		//
		//				}
		//			}
		//
		//		}else{
		//
		//			$total_price = $getRow->total_price;
		//			$goods_cnt = $getRow->goods_cnt+$this->input->post("goods_cnt");
		//			$goods_price = $getRow->goods_price;
		//
		//
		//			if($buy==1){
		//				$goods_cnt = $this->input->post("goods_cnt");
		//				$total_price = $getRow->goods_price * $this->input->post("goods_cnt");
		//			}
		//
		//			$goods_point = $goods_stat->point;
		//
		//			if($goods_point==0){
		//				$shop_info = $this->common_m->shop_info(); //shop 정보
		//				$goods_point = $total_price*$shop_info['point']*0.01;
		//			}
		//			$data['a_idx'] = $getRow->idx;
		//
		//			if($goods_stat->unlimit==0 && $goods_cnt > $goods_stat->number){
		//				$goods_cnt = $goods_stat->number;
		//			}
		//			$total_price = $goods_price*$goods_cnt;
		//
		//			$this->db->update($table,array('goods_cnt'=>$goods_cnt,'total_price'=>$total_price,'goods_point'=>$goods_point,'trade_ok'=>0),array('idx'=>$getRow->idx));
		//
		//		}
		//
		//	}
		//
		//	return $data;
		//
	//}

	public function cart(){

		$db_table = "dh_cart";	//카트 테이블
		$recom = $this->input->post('recom_idx');	//추천식단 구분값
		$add_goods = $this->input->post('goods_idx');	//간식 추가구매 여부

		//option use YN
		$option_cnt = $this->input->post("option_cnt");

		$UID = $this->session->userdata('USERID');

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

						$insert_data['deliv_grp'] = "이유식";

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

				//노 옵션 중복검색
				if($option_cnt <= 0){
					$cnt = $this->common_m->self_q("select * from dh_cart where goods_idx = '".$this->input->post('goods_idx')."' and userid = '{$UID}' and code = '".$this->session->userdata('CART')."' and date_bind = '".$this->input->post('date_bind')."'","cnt");

					if($cnt > 0){
						$dupli_row = $this->common_m->self_q("select * from dh_cart where goods_idx = '".$this->input->post('goods_idx')."' and userid = '{$UID}' and code = '".$this->session->userdata('CART')."' and date_bind = '".$this->input->post('date_bind')."'","row");
						$where['idx'] = $dupli_row->idx;
						$update['goods_cnt'] = $dupli_row->goods_cnt+1;
						$update['total_price'] = $dupli_row->goods_price*($update['goods_cnt']);
						$result = $this->common_m->update2($db_table,$update,$where);
						$a_idx = $this->db->insert_id();
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
						$a_idx = $this->db->insert_id();
					}
				}

				//옵션이 있을경우
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

				}

				return $a_idx;
			}


	}

		public function cartMove($idx,$to,$from)
		{
			$where_query = "and idx='$idx'";
			$userid = $this->session->userdata('USERID');
			$code = $this->session->userdata('CART');

			if($to=="cart") //cart -> wish
			{
				$data = $this->getCart($code,$where_query);
				$insert_table = "wishlist";
				$basic_f = "userid";
				$basic_f2 = "wishlist_idx";
				$code = $this->session->userdata('USERID');
			}else
			{
				$data = $this->getCart('',$where_query,'wish',$userid);
				$insert_table = "cart";
				$basic_f = "code";
				$basic_f2 = "cart_idx";
				$code = $this->session->userdata('CART');
			}

			$list = $data['list'];

			foreach($list as $lt){

				$cart_cnt = $this->common_m->getCount("dh_".$insert_table,"where ".$basic_f."='".$code."' and cate_no='".$lt->cate_no."' and goods_idx='".$lt->goods_idx."' and goods_price='".$lt->goods_price."' and total_price='".$lt->total_price."' and option_cnt='".$lt->option_cnt."'","idx");

				if($cart_cnt==0){

					if($to=="cart") //cart -> wish
					{
						$insert_array = array($basic_f=>$code,'cate_no'=>$lt->cate_no,'goods_idx'=>$lt->goods_idx,'goods_code'=>$lt->goods_code,'goods_name'=>$lt->goods_name,'goods_price'=>$lt->goods_price,'total_price'=>$lt->total_price,'goods_cnt'=>$lt->goods_cnt,'goods_point'=>$lt->goods_point,'cate_no'=>$lt->cate_no,'goods_real_point'=>$lt->goods_real_point,'option_cnt'=>$lt->option_cnt,'cate_no'=>$lt->cate_no,'reg_date'=>date("Y-m-d H:i:s"));
					}else{
						$insert_array = array($basic_f=>$code,'userid'=>$userid,'cate_no'=>$lt->cate_no,'goods_idx'=>$lt->goods_idx,'goods_code'=>$lt->goods_code,'goods_name'=>$lt->goods_name,'goods_price'=>$lt->goods_price,'total_price'=>$lt->total_price,'goods_cnt'=>$lt->goods_cnt,'goods_point'=>$lt->goods_point,'cate_no'=>$lt->cate_no,'goods_real_point'=>$lt->goods_real_point,'option_cnt'=>$lt->option_cnt,'cate_no'=>$lt->cate_no,'reg_date'=>date("Y-m-d H:i:s"));
					}

					$result = $this->db->insert("dh_".$insert_table,$insert_array);
					$a_idx = mysql_insert_id();

					${'option_arr'.$lt->idx} = $data['option_arr'.$lt->idx];

					if($lt->option_cnt > 0){

						if($to=="cart") //cart -> wish
						{
							$option_first_row = $this->common_m->getRow("dh_cart_option","where cart_idx='".$lt->idx."' and option_code='".${'option_arr'.$lt->idx}[0]['option_code']."' and level=1");
						}else{
							$option_first_row = $this->common_m->getRow("dh_wishlist_option","where userid='".$this->session->userdata('USERID')."' and option_code='".${'option_arr'.$lt->idx}[0]['option_code']."' and level=1");
						}

						$option_insert_array = array($basic_f=>$code,$basic_f2=>$a_idx,'goods_idx'=>$lt->goods_idx,'option_idx'=>$option_first_row->option_idx,'option_code'=>$option_first_row->option_code,'level'=>1,'title'=>$option_first_row->title,'name'=>$option_first_row->name,'price'=>$option_first_row->price,'point'=>$option_first_row->point,'cnt'=>$option_first_row->cnt,'chk_num'=>$option_first_row->chk_num,'flag'=>$option_first_row->flag);

						$result = $this->db->insert("dh_".$insert_table."_option",$option_insert_array);

						for($i=0;$i<count(${'option_arr'.$lt->idx});$i++){

							$option_insert_array2 = array($basic_f=>$code,$basic_f2=>$a_idx,'goods_idx'=>$lt->goods_idx,'option_idx'=>${'option_arr'.$lt->idx}[$i]['option_idx'],'option_code'=>${'option_arr'.$lt->idx}[$i]['option_code'],'level'=>${'option_arr'.$lt->idx}[$i]['level'],'title'=>${'option_arr'.$lt->idx}[$i]['title'],'name'=>${'option_arr'.$lt->idx}[$i]['name'],'price'=>${'option_arr'.$lt->idx}[$i]['price'],'point'=>${'option_arr'.$lt->idx}[$i]['point'],'cnt'=>${'option_arr'.$lt->idx}[$i]['cnt'],'chk_num'=>${'option_arr'.$lt->idx}[$i]['chk_num'],'flag'=>${'option_arr'.$lt->idx}[$i]['flag']);

							$result = $this->db->insert("dh_".$insert_table."_option",$option_insert_array2);

						}
					}
				}else{
					$result = 1;

				}

			}


			return $result;
		}


		public function getCart($code='',$where_query='',$flagMode='',$userid='')
		{
			if(!$code && !$flagMode){ //장바구니 카트 no 생성
				$code = $this->common_m->cart_init();
			}
			$table = "dh_cart";
			$basic_f = "code";
			$basic_f2 = "cart_idx";

			if($flagMode=="wish" && $userid){
				$table = "dh_wishlist";
				$basic_f = "userid";
				$basic_f2 = "wishlist_idx";
				$code = $userid;
			}

			if($where_query){
				//$where_query = str_ireplace("idx","c.idx",$where_query);
			}

			//$where_query.=" and trade_ok != 1";

			$USERID = $this->session->userdata('USERID');

			if($USERID){
				$where_query .= " and userid='{$USERID}'";
			}else{
				$where_query .= " and a.".$basic_f."='$code'";
			}

			$db_deliv_date_sql = "select distinct deliv_date from dh_trade_deliv_info where userid = '{$USERID}' and deliv_date >= '".date("Y-m-d")."' order by deliv_date asc";
			$db_deliv_date_query = $this->db->query($db_deliv_date_sql);
			$db_deliv_date_result = $db_deliv_date_query->result();
			$db_dv_date_arr = array();
			foreach($db_deliv_date_result as $db){
				$db_dv_date_arr[] = $db->deliv_date;
			}

			//$sql = "select c.*,g.list_img,g.old_price,g.unlimit,g.number,g.express_check,g.express_money,g.express_free,g.express_no_basic from $table c,dh_goods g where g.idx=c.goods_idx $where_query order by c.idx desc";
			//$sql = "select *,(select list_img from dh_goods where idx = goods_idx) as list_img, (select cate_no from dh_goods where idx = goods_idx) as cate_no from dh_cart where 1 {$where_query} order by date_bind desc, idx desc";
			$sql = "
				select a.*
					, b.list_img, b.cate_no, b.number, b.unlimit
				from dh_cart a left join dh_goods b on a.goods_idx = b.idx
				where trade_ok <> '1' {$where_query}
				order by date_bind desc, goods_idx asc";
			$query = $this->db->query($sql);
			$result = $query->result();

			/*
			$cart_arr = array();

			//pr($result);
			foreach($result as $row){
				$ack = array_keys($row);
				foreach($ack as $arr_key){
					if(in_array($row[date_bind], $db_dv_date_arr)){
						$cart_arr[$row[date_bind]]['deliv_price'] = "N";
					}
					else{
						$cart_arr[$row[date_bind]]['deliv_price'] = "Y";
					}
					$cart_arr[$row[date_bind]]['goods_info'][$row[idx]][$arr_key] = $row[$arr_key];
				}

				if($row[option_cnt] > 0){
					$idx = $row[idx];
					$option_sql = "select * from ".$table."_option where ".$basic_f2."='$idx' and level=2 order by idx";
					$option_query = $this->db->query($option_sql);
					$option_list = $option_query->result();

					foreach($option_list as $ol){
						$cart_arr[$row[date_bind]]['goods_info'][$row[idx]]['option_info'][$ol->idx]['option_title'] = $ol->title;
						$cart_arr[$row[date_bind]]['goods_info'][$row[idx]]['option_info'][$ol->idx]['option_name'] = $ol->name;
						$cart_arr[$row[date_bind]]['goods_info'][$row[idx]]['option_info'][$ol->idx]['option_cnt'] = $ol->cnt;
						$cart_arr[$row[date_bind]]['goods_info'][$row[idx]]['option_info'][$ol->idx]['option_price'] = $ol->price;
					}
				}

			}
			pr($cart_arr);
			exit;
			*/



			foreach($result as $lt){
				//$cart_arr[$lt->date_bind][$lt] = $lt;

				$idx = $lt->idx;
				$sql = "select * from ".$table."_option where ".$basic_f2."='$idx' and level=2 order by idx";
				$query = $this->db->query($sql);

				$option_db_cnt = $query->num_rows();
				if($lt->option_cnt > 0 and $option_db_cnt <= 0){
					$res = $this->common_m->self_q("delete from dh_cart_option where cart_idx = '{$idx}'","delete");
					if($res){
						$res = $this->common_m->self_q("delete from dh_cart where idx = '{$idx}'","delete");
						if($res){
							alert(cdir().'/dh_order/shop_cart','상품 옵션중 품절이 존재하여 장바구니에서 자동으로 삭제 하였습니다.');
							exit;
						}
					}
				}
				else{
					$sql = "select * from dh_goods where idx = '".$lt->goods_idx."'";
					$q = $this->db->query($sql);
					$grow = $q->row();
					if($grow->unlimit < 1 and $grow->number < $lt->goods_cnt and $lt->recom_idx <= 0){
						$res = $this->common_m->self_q("delete from dh_cart where idx = '{$idx}'","delete");
						alert(cdir().'/dh_order/shop_cart','상품 중 품절이 존재하여 장바구니에서 자동으로 삭제 하였습니다.');
						exit;
					}
				}

				$option_list = $query->result();
				${'option_arr'.$idx}="";

				if( $lt->unlimit==0 && $lt->number==0 && $lt->recom_idx<=0 ){
					$ret = $this->common_m->del($table,'idx', $lt->idx);
					if($ret){
						alert(cdir().'/dh_order/shop_cart','품절상품이 존재하여 해당상품은 장바구니에서 삭제됩니다.'); exit;
					}
				}

				//$getRow = $this->common_m->getRow("$table_option","where ".$basic_f."='$code' and ".$basic_f2."='$idx' and level=1");

				$cnt=0;
				foreach($option_list as $option){
					${'option_arr'.$idx}[$cnt]['idx'] = $option->idx;
					${'option_arr'.$idx}[$cnt]['option_idx'] = $option->option_idx;
					${'option_arr'.$idx}[$cnt]['option_code'] = $option->option_code;
					${'option_arr'.$idx}[$cnt]['title'] = $option->title;
					${'option_arr'.$idx}[$cnt]['name'] = $option->name;
					${'option_arr'.$idx}[$cnt]['price'] = $option->price;
					${'option_arr'.$idx}[$cnt]['cnt'] = $option->cnt;
					${'option_arr'.$idx}[$cnt]['flag'] = $option->flag;
					${'option_arr'.$idx}[$cnt]['level'] = $option->level;
					${'option_arr'.$idx}[$cnt]['point'] = $option->point;
					${'option_arr'.$idx}[$cnt]['chk_num'] = $option->chk_num;

					$option_row = $this->common_m->getRow("dh_goods_option","where idx='".$option->option_idx."'");
					if( (isset($option_row->idx) && $option_row->code == $option->option_code && $option_row->unlimit==0 && $option_row->number==0) ){
						$ret = $this->common_m->del($table."_option",'idx', $option->idx);
						if($ret){
							alert(cdir().'/dh_order/shop_cart','품절되거나 삭제된 제품옵션이 존재하여 장바구니에서 삭제됩니다.'); exit;
						}
					}

					$cnt++;
				}

				$data['option_arr'.$idx] = ${'option_arr'.$idx};
			}

			$data['list'] = $result;

			return $data;

		}


		public function trade_tmp_add($trade_code,$data='')
		{
			$tmp_cnt = $this->common_m->getCount("dh_trade_tmp","where trade_code='".$this->db->escape_str($trade_code)."'","idx");
			if($tmp_cnt){ $this->common_m->del("dh_trade_tmp","trade_code", $trade_code); }

			$trade_method = $this->input->post("trade_method",true);
			$trade_day = date("Y-m-d H:i:s");
			$userid = $this->input->post("userid",true);
			$name = $this->input->post("name",true);
			$phone = $this->input->post("phone1",true)."-".$this->input->post("phone2",true)."-".$this->input->post("phone3",true);
			$email = "";
			if($this->input->post("email1",true) && $this->input->post("email2",true)){
				$email = $this->input->post("email1",true)."@".$this->input->post("email2",true);
			}
			else{
				$email = $this->input->post("email",true);
			}

			$send_name = $this->input->post("send_name",true);
			$send_phone = $this->input->post("send_phone1",true)."-".$this->input->post("send_phone2",true)."-".$this->input->post("send_phone3",true);
			$send_tel = $this->input->post("send_tel1",true)."-".$this->input->post("send_tel2",true)."-".$this->input->post("send_tel3",true);
			$send_text = $this->input->post("send_text",true);
			$zip1 = $this->input->post("zip1",true);
			$addr1 = $this->input->post("addr1",true);
			$addr2 = $this->input->post("addr2",true);
			$save_point = $this->input->post("save_point",true);
			$use_point = $this->input->post("point",true);
			$use_coupon = $this->input->post("use_coupon",true);
			$coupon_idx = $this->input->post("coupon_idx",true);
			$total_price = $this->input->post("total_price",true);
			$price = $this->input->post("price",true);
			$goods_price = $this->input->post("goods_price",true);
			$delivery_price = $this->input->post("delivery_price",true);
			$enter_name = $this->input->post("enter_name",true);
			$enter_bank = $this->input->post("enter_bank",true);
			$enter_account = $this->input->post("enter_account",true);
			$enter_info = $this->input->post("enter_info",true);

			$local_far = $this->input->post("local_far",true);
			$point_pay = $this->input->post("point_pay",true);
			$cash_receipt=$this->input->post("cash_receipt2", true);
			$cash_number=$this->input->post("cash_number2", true);

			$txt = "";

			//			foreach($_POST as $k=>$v){
			//				$txt .= $k."=".$v."@@";
			//			}

			if($point_pay==1){
				if($use_point){
					$trade_method=5;
				}else if($use_coupon){
					$trade_method=6;
				}
			}

			//			if($trade_method==2){ //현금영수증을 발급받아야 할때
			//				$cash_receipt = $this->input->post("cash_receipt".$trade_method, true); //현금영수증 종류
			//				if($cash_receipt > 0){
			//					$cash_number = $this->input->post("cash_number".$trade_method, true); //현금영수증 등록 번호
			//				}
			//			}
			$a_idx=$this->uri->segment(3,'');

			$txt = "trade_stat=1@@trade_method=".$trade_method."@@trade_day=".$trade_day."@@userid=".$userid."@@name=".$name."@@phone=".$phone."@@email=".$email."@@send_name=".$send_name."@@send_phone=".$send_phone;
			$txt .= "@@send_tel=".$send_tel."@@zip1=".$zip1."@@addr1=".$addr1."@@addr2=".$addr2."@@send_text=".$send_text."@@save_point=".$save_point."@@use_point=".$use_point."@@use_coupon=".$use_coupon."@@coupon_idx=".$coupon_idx;
			$txt .= "@@total_price=".$total_price."@@price=".$price."@@enter_name=".$enter_name."@@enter_bank=".$enter_bank."@@enter_account=".$enter_account."@@enter_info=".$enter_info."@@point_pay=".$point_pay;
			$txt .= "@@cash_receipt=".$cash_receipt."@@cash_number=".$cash_number."@@delivery_price=".$delivery_price."@@local_far=".$local_far."@@cate_idx=".$a_idx."@@cart_cnt=".$data['totalCnt']."@@goods_price=".$goods_price;

			$useragent = $_SERVER['HTTP_USER_AGENT'];
			if(preg_match('/(android|bb\d+|meego).+mobile|avantgo|bada\/|blackberry|blazer|compal|elaine|fennec|hiptop|iemobile|ip(hone|od)|iris|kindle|lge |maemo|midp|mmp|netfront|opera m(ob|in)i|palm( os)?|phone|p(ixi|re)\/|plucker|pocket|psp|series(4|6)0|symbian|treo|up\.(browser|link)|vodafone|wap|windows (ce|phone)|xda|xiino/i',$useragent)||preg_match('/1207|6310|6590|3gso|4thp|50[1-6]i|770s|802s|a wa|abac|ac(er|oo|s\-)|ai(ko|rn)|al(av|ca|co)|amoi|an(ex|ny|yw)|aptu|ar(ch|go)|as(te|us)|attw|au(di|\-m|r |s )|avan|be(ck|ll|nq)|bi(lb|rd)|bl(ac|az)|br(e|v)w|bumb|bw\-(n|u)|c55\/|capi|ccwa|cdm\-|cell|chtm|cldc|cmd\-|co(mp|nd)|craw|da(it|ll|ng)|dbte|dc\-s|devi|dica|dmob|do(c|p)o|ds(12|\-d)|el(49|ai)|em(l2|ul)|er(ic|k0)|esl8|ez([4-7]0|os|wa|ze)|fetc|fly(\-|_)|g1 u|g560|gene|gf\-5|g\-mo|go(\.w|od)|gr(ad|un)|haie|hcit|hd\-(m|p|t)|hei\-|hi(pt|ta)|hp( i|ip)|hs\-c|ht(c(\-| |_|a|g|p|s|t)|tp)|hu(aw|tc)|i\-(20|go|ma)|i230|iac( |\-|\/)|ibro|idea|ig01|ikom|im1k|inno|ipaq|iris|ja(t|v)a|jbro|jemu|jigs|kddi|keji|kgt( |\/)|klon|kpt |kwc\-|kyo(c|k)|le(no|xi)|lg( g|\/(k|l|u)|50|54|\-[a-w])|libw|lynx|m1\-w|m3ga|m50\/|ma(te|ui|xo)|mc(01|21|ca)|m\-cr|me(rc|ri)|mi(o8|oa|ts)|mmef|mo(01|02|bi|de|do|t(\-| |o|v)|zz)|mt(50|p1|v )|mwbp|mywa|n10[0-2]|n20[2-3]|n30(0|2)|n50(0|2|5)|n7(0(0|1)|10)|ne((c|m)\-|on|tf|wf|wg|wt)|nok(6|i)|nzph|o2im|op(ti|wv)|oran|owg1|p800|pan(a|d|t)|pdxg|pg(13|\-([1-8]|c))|phil|pire|pl(ay|uc)|pn\-2|po(ck|rt|se)|prox|psio|pt\-g|qa\-a|qc(07|12|21|32|60|\-[2-7]|i\-)|qtek|r380|r600|raks|rim9|ro(ve|zo)|s55\/|sa(ge|ma|mm|ms|ny|va)|sc(01|h\-|oo|p\-)|sdk\/|se(c(\-|0|1)|47|mc|nd|ri)|sgh\-|shar|sie(\-|m)|sk\-0|sl(45|id)|sm(al|ar|b3|it|t5)|so(ft|ny)|sp(01|h\-|v\-|v )|sy(01|mb)|t2(18|50)|t6(00|10|18)|ta(gt|lk)|tcl\-|tdg\-|tel(i|m)|tim\-|t\-mo|to(pl|sh)|ts(70|m\-|m3|m5)|tx\-9|up(\.b|g1|si)|utst|v400|v750|veri|vi(rg|te)|vk(40|5[0-3]|\-v)|vm40|voda|vulc|vx(52|53|60|61|70|80|81|83|85|98)|w3c(\-| )|webc|whit|wi(g |nc|nw)|wmlb|wonu|x700|yas\-|your|zeto|zte\-/i',substr($useragent,0,4))){
				$txt .= "@@mobile=1";
			}
			$trade_data = encode($txt);

			$result = $this->db->insert("dh_trade_tmp",array("trade_code"=>$trade_code,"data"=>$trade_data,"trade_day"=>date("Y-m-d H:i:s")));

			//if($data['totalCnt'] > 0 && $data['sample_is'] != "ok"){
				foreach($data['cart_list'] as $lt){
					$result = $this->common_m->update2("dh_cart",array("trade_code"=>$trade_code,"trade_day"=>date("Y-m-d H:i:s")),array("idx"=>$lt->idx));
				}
			//}

			//$trade_data = decode($trade_data);

			if($result && ( $trade_method==2 || $trade_method==5 || $trade_method==6 || $trade_method==99 || $trade_method==9) ){ //무통장입금 or 포인트결제 or 쿠폰결제 일경우
				script_exe('parent.form_submit();');
				exit;
			}

			return $result;
		}


		public function trade($trade_code,$data='',$tmpOk='',$change_trade_code='')	//오더지개선
		{

			$order_result = array();

			$tmp_cnt = $this->common_m->getCount("dh_trade_tmp","where trade_code='".$this->db->escape_str($trade_code)."'","idx");
			$data['shop_info'] = $this->common_m->shop_info();
			$result="";
			$trade_stat = 1;

			if($tmp_cnt){
				$tmpRow = $this->common_m->getRow2("dh_trade_tmp","where trade_code='".$this->db->escape_str($trade_code)."' order by idx limit 1");
				$trade_data = decode($tmpRow->data);

				$trade_day_ok="";

				if($trade_data['trade_method']!=2 && $trade_data['trade_method']!=99 && $trade_data['trade_method']!=5 && $trade_data['trade_method']!=6 && $tmpOk!=1){  //!무통장, !샘플, !포인트, !쿠폰, !tmp
					//$data['trade_data'] = $trade_data;
					//$this->{$data['shop_info']['pg_company']}($data); //결제로그

					if($trade_data['trade_method']==1 || $trade_data['trade_method']==3 || $trade_data['trade_method']==7){	// 신용카드, 계좌이체, 휴대폰
						$trade_stat = 2;
						$trade_day_ok = date("Y-m-d H:i:s");
					}
				}

				if($trade_data['trade_method']==5 || $trade_data['trade_method']==6 || $trade_data['trade_method']==99 || $trade_data['trade_method']==9){	//포인트, 쿠폰, 샘플, 예치금
					$trade_stat=2;
				}

				//trade 등록 start

					$tno = $this->input->post("tno");

					//$tno = $this->input->post("tno");
					//$tno = $this->input->post("LGD_TID");
					//$cash_yn = $this->input->post("cash_yn");

					$insert_trade['trade_code'] = $trade_code;
					$insert_trade['trade_stat'] = $trade_stat;
					$insert_trade['trade_method'] = $trade_data['trade_method'];
					$insert_trade['trade_day'] = $trade_data['trade_day'] ? $trade_data['trade_day'] : timenow() ;
					$insert_trade['trade_day_ok'] = $trade_day_ok;
					$insert_trade['userid'] = $trade_data['userid'];
					$insert_trade['name'] = $trade_data['name'];
					$insert_trade['phone'] = $trade_data['phone'];
					$insert_trade['email'] = $trade_data['email'];
					$insert_trade['send_name'] = $trade_data['send_name'];
					$insert_trade['send_phone'] = $trade_data['send_phone'];

					if($trade_data['send_tel']){
						$insert_trade['send_tel'] = $trade_data['send_tel'];
					}

					$insert_trade['save_point'] = $trade_data['save_point'];

					$insert_trade['zip1'] = $trade_data['zip1'];
					$insert_trade['addr1'] = $trade_data['addr1'];
					$insert_trade['addr2'] = $trade_data['addr2'];
					$insert_trade['send_text'] = $trade_data['send_text'];
					$insert_trade['use_point'] = $trade_data['use_point'] ? $trade_data['use_point'] : "0" ;
					$insert_trade['coupon_idx'] = $trade_data['coupon_idx'];
					$insert_trade['use_coupon'] = $trade_data['use_coupon'];
					$insert_trade['mobile'] = $trade_data['mobile'] ? $trade_data['mobile'] : "0" ;
					$insert_trade['price'] = $trade_data['price'];
					$insert_trade['goods_price'] = $trade_data['goods_price'];
					$insert_trade['delivery_price'] = $trade_data['delivery_price'];
					$insert_trade['total_price'] = $trade_data['total_price'];
					$insert_trade['tno'] = $tno;
					$insert_trade['point_pay'] = $trade_data['point_pay'] ? $trade_data['point_pay'] : "0" ;

					if($trade_data['trade_method'] == "2"){
						//입금은행 정보
						$insert_trade['enter_name'] = $trade_data['enter_name'];
						$insert_trade['enter_bank'] = $trade_data['enter_bank'];
						$insert_trade['enter_account'] = $trade_data['enter_account'];
						$insert_trade['enter_info'] = $trade_data['enter_info'];

						$insert_trade['cash_receipt'] = $trade_data['cash_receipt'];
						$insert_trade['cash_number'] = $trade_data['cash_number'];

					}
					else if($trade_data['trade_method'] == "4"){
						$insert_trade['enter_bank'] = inicis_bank_array($this->input->post("VACT_BankCode"));
						$insert_trade['enter_account'] = $this->input->post("VACT_Num");
						$insert_trade['enter_info'] = "(주)에코맘의산골이유식농업회사법인";
						$insert_trade['enter_name'] = $trade_data['name'];
					}

					//첫주문 겁색후 입력
					//$userid = $trade_data['userid'];
					$order_cnt_sql = "
						SELECT * FROM dh_trade
						WHERE trade_stat BETWEEN 1 AND 4
							AND (sample_is IS NULL OR sample_is != 'Y')
							AND userid = '".$insert_trade['userid']."'
							AND trade_code IN (SELECT trade_code FROM dh_trade_deliv_prod WHERE recom_idx != '')
					";
					$order_cnt = $this->common_m->self_q($order_cnt_sql,"cnt");

					$userinfo = $this->common_m->self_q("select * from dh_member where userid = '".$insert_trade['userid']."'","row");

					$insert_trade['first_order'] = "";

					//주문기록 확인은 정상인 부분인거 확인했으나, 들어오는 주문이 간식인지 이유식인지 구분 못함
					// 장바구니 한번 돌려서 검증 루틴을 만들어야겠음

					$is_mesi = false;
					$mesi_arr = array('1-6','1-7','1-8','1-9','1-10','1-11','2-12','2-13','6');

					//장바구니 검증루틴 생성
					foreach($data['cart_list'] as $lt){
						//if(@in_array($data['goods_info'][$lt->goods_idx]->cate_no, $mesi_arr) || $lt->recom_idx){
						// 20190321 정기배송 주문만 첫구매로 변경
						if($lt->recom_idx){
							$is_mesi = true;
						}
					}

					if($order_cnt <= 0 && $data['sample_is'] != "ok" && $userinfo->regist_type != 'sns' && $is_mesi){
						$insert_trade['first_order'] = "Y";
					}

					//정기배송 휴일 전단에서 처리 안하고 후단에서 처리하는 방식으로 변경
					//휴일배송이라는 새로운 스탯을 만들어 배송휴일인 경우 해당 스탯을 물고 디비에 들어가도록 처리함

					$holiday_arr = array();	//배송휴일 배열
					$holiday_type = array();	//배송휴일 배열
					$holi = $this->common_m->self_q("select * from dh_deliv_holi where holiday >= '".date("Y-m-d")."' and regu=1 order by holiday asc","result");
					foreach($holi as $h){
						$holiday_arr[$h->holiday] = true;
						$holiday_type[$h->holiday]['type'] = $h->type;
					}

					if($data['sample_is'] == "ok"){
						$insert_trade['sample_is'] = "Y";
					}

					$result = $this->common_m->insert2("dh_trade",$insert_trade);
					//$result = 1;
					$trade_idx = mysql_insert_id();

					if($result){ //제품 데이타 넣기

						/*
						$cart_cnt = 1;

						$cart_cnt_arr = array();

						foreach($data['cart_list'] as $lt){
							if($lt->recom_is == "Y"){	//추천식단일 경우
								$cart_cnt++;
								$cart_cnt_arr[$lt->date_bind] = $cart_cnt;
							}
						}

						if(count($cart_cnt_arr) <= 0){

							$cart_cnt = "1";

						}
						*/

						$cart_cnt = "1";

						$trade_db_result = false;

						//장바구니 루프 시작
						foreach($data['cart_list'] as $lt){

							$order_print_code = "";
							$dup_cnt = '';

							if($lt->recom_is == "Y"){	//추천식단일 경우

								$where['idx'] = $trade_idx;

								//추천식단정보 주문테이블 update
									$trade_row_update['recom_is'] = $lt->recom_is;
									$trade_row_update['recom_idx'] = $lt->recom_idx;
									$trade_row_update['recom_delivery_sun_type'] = $lt->recom_delivery_sun_type;
									$trade_row_update['recom_week_count'] = $lt->recom_week_count;
									$trade_row_update['recom_week_day_count'] = $lt->recom_week_day_count;
									$trade_row_update['recom_week_type'] = $lt->recom_week_type;
									$trade_row_update['recom_pack_ea'] = $lt->recom_pack_ea;
									$trade_row_update['recom_dates'] = $lt->recom_dates;

									$this->common_m->update2("dh_trade",$trade_row_update,$where);
								//추천식단정보 주문테이블 update

								//추천식단 상품정보 입력
								$insert_trade_goods['trade_code'] = $trade_code;
								$insert_trade_goods['cate_no'] = "recom";
								$insert_trade_goods['goods_name'] = $lt->goods_name;
								$insert_trade_goods['date_bind'] = $lt->date_bind;
								$insert_trade_goods['total_price'] = $lt->total_price;
								$insert_trade_goods['goods_price'] = $lt->goods_price;
								$insert_trade_goods['goods_cnt'] = $lt->goods_cnt;
								$insert_trade_goods['trade_day'] = timenow();
								$insert_trade_goods['recom_idx'] = $lt->recom_idx;
								$insert_trade_goods['recom_week_count'] = $lt->recom_week_count;
								$insert_trade_goods['recom_delivery_sun_type'] = $lt->recom_delivery_sun_type;
								$insert_trade_goods['recom_week_day_count'] = $lt->recom_week_day_count;
								$insert_trade_goods['recom_week_type'] = $lt->recom_week_type;
								$insert_trade_goods['recom_pack_ea'] = $lt->recom_pack_ea;
								$insert_trade_goods['recom_per'] = $lt->recom_per;
								$insert_trade_goods['recom_foods'] = $lt->recom_foods;
								$insert_trade_goods['recom_start_date'] = $lt->recom_start_date;
								$insert_trade_goods['recom_end_date'] = $lt->recom_end_date;
								$insert_trade_goods['recom_dates'] = $lt->recom_dates;

								$trade_db_result = $this->common_m->insert2("dh_trade_goods",$insert_trade_goods);
								$tg_idx = $this->db->insert_id();

								$recom_foods = unserialize($lt->recom_foods);
								foreach($recom_foods as $date=>$food){	//추천식단 배송정보 입력
									$recom_insert_data['trade_code'] = $trade_code;
									$recom_insert_data['deliv_code'] = $trade_code."_1-".$date."-1";
									$recom_insert_data['userid'] = $trade_data['userid'];
									$recom_insert_data['order_name'] = $trade_data['name'];
									$recom_insert_data['order_phone'] = $insert_trade['phone'];
									$recom_insert_data['recv_name'] = $trade_data['send_name'];
									$recom_insert_data['recv_phone'] = $insert_trade['send_phone'];
									$recom_insert_data['prod_name'] = $lt->goods_name;
									$recom_insert_data['recom_idx'] = $lt->recom_idx;
									$recom_insert_data['tg_idx'] = $tg_idx;
									$recom_insert_data['deliv_date'] = date("Y-m-d",$date);
									//$recom_insert_data['deliv_addr'] = ($lt->deliv_addr) ? $lt->deliv_addr : "home" ;
									$recom_insert_data['deliv_addr'] = $this->input->post('deliv_addr_set');
									$recom_insert_data['zipcode'] = $trade_data['zip1'];
									$recom_insert_data['addr1'] = $trade_data['addr1'];
									$recom_insert_data['addr2'] = $trade_data['addr2'];
									$recom_insert_data['ct_subgroup'] = "이유식";
									if($holiday_arr[$recom_insert_data['deliv_date']]){
										if($holiday_type[$recom_insert_data['deliv_date']]['type']=="조기마감"){
											$recom_insert_data['deliv_stat']=7;
										}
										else if($holiday_type[$recom_insert_data['deliv_date']]['type']=="배송휴무"){
											$recom_insert_data['deliv_stat']=6;
										}
									}
									else{
										$recom_insert_data['deliv_stat']=0;
									}
									$recom_insert_data['wdate'] = timenow();

									//배송비 부과안된 이유식 낱개 주문건
									$recom_insert_data['delivPoNm'] = $this->input->post('delivPoNm');

									$allergy = false;
									foreach($food as $alchk){
										if($alchk['allergy']) $allergy = true;
									}

									$dup_cnt = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '".$recom_insert_data['deliv_code']."'","cnt");
									if($dup_cnt <= 0){

											//										if($allergy){
											//											$order_print_code = "999999";
											//										}
											//										else{

											switch($lt->recom_idx){
												case "2": $order_print_code = "1000"; break;
												case "4": $order_print_code = "2000"; break;
												case "5": $order_print_code = "5000"; break;
												case "6": $order_print_code = "4100"; break;
												case "1": $order_print_code = "4200"; break;
												case "7": $order_print_code = "3000"; break;
												case "3": $order_print_code = "7000"; break;
											}

											//										}

										$recom_insert_data['order_type'] = $order_print_code;
										$recom_insert_data['allergy'] = $allergy ? 1 : 0 ;

										$this->common_m->insert2("dh_trade_deliv_info",$recom_insert_data);
									}
									else{

										$d_info_row = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '".$recom_insert_data['deliv_code']."'","row");

										$add_update_sql = "";

										/***************************

										2020년 6월 4일 디자인허브 김기엽

										단계 분류 과정에서 불필요한 변수초기화

										////간식인 경우
										//$snack = 0;
										////다른단계 낱개 이유식인 경우
										//$other_pack = 0;

										주석처리

										****************************/

										////간식인 경우
										//$snack = 0;
										////다른단계 낱개 이유식인 경우
										//$other_pack = 0;

										//우선 배송할 상품을 불러온다 , 정기배송 빼고 (어차피 지금 돌아가는게 정기배송이니까 의미 없다 중복 주문이 안되므로), 샘플 빼고 (샘플은 뭐가되든 별도로 배송이 잡히도록 한다)
										$dplist = $this->common_m->self_q("select * from dh_trade_deliv_prod where deliv_code = '".$recom_insert_data['deliv_code']."' and recom_is != 'Y' and cate_no != '7'","result");
										if(count($dplist) > 0){

											$snack = 0;
											$other_pack = 0;
											$tk = 0;

											foreach($dplist as $dirs){
												/***************************

												2020년 6월 4일 디자인허브 김기엽

												합배송여부 갯수 카운팅시 break 추가로 바로바로 카운팅하도록 개선

												****************************/
												if($dirs->cate_no == 3 || $dirs->cate_no == 4 || $dirs->cate_no == 8){
													$snack++;
												}
												else if($dirs->cate_no == '6'){
													$tk++;
												}
												else{
													$other_pack++;
												}
											}

											if($other_pack > 0 && $snack > 0){	//다른이유식도 있고, 간식도 있는경우
												//$order_print_code = "999999";
												switch($lt->recom_idx){
													case "2": $order_print_code = "1010"; break;	//준비기
													case "4": $order_print_code = "2010"; break;	//초기
													case "7": $order_print_code = "3010"; break;	//완료기
													case "6": $order_print_code = "4110"; break;	//후기2식
													case "1": $order_print_code = "4210"; break;	//후기3식
													case "5": $order_print_code = "5010"; break;	//중기
													case "3": $order_print_code = "7010"; break;	//반찬/국
												}
											}
											else if($other_pack > 0 && $snack <= 0){	// 다른이유식만 있는경우
												//다른 이유식이 섞여 들어오는 경우도 경우의 수 추가 해줘야함 "2018-12-18 왜 이걸 이제 깨달았을까 날짜가 내 기분을 말해주는구나
												switch($lt->recom_idx){
													case "2": $order_print_code = "1011"; break;	//준비기
													case "4": $order_print_code = "2011"; break;	//초기
													case "7": $order_print_code = "3011"; break;	//완료기
													case "6": $order_print_code = "4111"; break;	//후기2식
													case "1": $order_print_code = "4211"; break;	//후기3식
													case "5": $order_print_code = "5011"; break;	//중기
													case "3": $order_print_code = "7011"; break;	//반찬/국
												}
											}
											else if($other_pack <= 0 && $snack > 0){	//간식만 있는경우
												switch($lt->recom_idx){
													case "2": $order_print_code = "1010"; break;	//준비기
													case "4": $order_print_code = "2010"; break;	//초기
													case "7": $order_print_code = "3010"; break;	//완료기
													case "6": $order_print_code = "4110"; break;	//후기2식
													case "1": $order_print_code = "4210"; break;	//후기3식
													case "5": $order_print_code = "5010"; break;	//중기
													case "3": $order_print_code = "7010"; break;	//반찬/국
												}
											}
											else if($tk){
												$order_print_code = '902000';
											}
										}

										if($allergy){
											//$order_print_code = "999999";
											$add_update_sql .= ", allergy = 1";
										}

										if($order_print_code){
											$add_update_sql .= ", order_type = {$order_print_code}";
										}

										$this->common_m->self_q("update dh_trade_deliv_info set prod_name = CONCAT(prod_name,',".$lt->goods_name."'), recom_idx = '".$recom_insert_data['recom_idx']."' {$add_update_sql} where deliv_code = '".$recom_insert_data['deliv_code']."'","update");

									}

									foreach($food as $fd){	//추천식단 상품 정보 입력
										$fd_insert['trade_code'] = $trade_code;
										$fd_insert['deliv_code'] = $recom_insert_data['deliv_code'];
										$fd_insert['deliv_date'] = date("Y-m-d",$date);
										$fd_insert['goods_idx'] = $fd['goods_idx'];
										$fd_insert['recom_idx'] = $lt->recom_idx;
										$fd_insert['prod_cnt'] = $fd['prod_cnt'];
										$fd_insert['cate_no'] = $data['goods_info'][$fd['goods_idx']]->cate_no;
										$fd_insert['recom_is'] = 'Y';
										$fd_insert['tg_idx'] = $tg_idx;
										$fd_insert['wdate'] = timenow();

										$trade_db_result = $this->common_m->insert2("dh_trade_deliv_prod",$fd_insert);
									}

								}

								//if($trade_db_result){
								//	if($data['sample_is'] == "ok"){
								//	}
								//	else{
								//		$where['idx'] = $lt->idx;
								//		$update['trade_ok'] = '1';
								//		$update['trade_code'] = $trade_code;
								//		$trade_db_result = $this->common_m->update2("dh_cart",$update,$where);
								//	}
								//}

							}
							else{	// 추천식단 이외

								$goods_stat = $this->common_m->getRow("dh_goods","where idx='".$lt->goods_idx."'");

								$insert_array = array('trade_code'=>$trade_code,'date_bind'=>$lt->date_bind,'cate_no'=>$goods_stat->cate_no,'goods_idx'=>$lt->goods_idx,'goods_code'=>$goods_stat->goods_code,'goods_name'=>$lt->goods_name,'total_price'=>$lt->total_price,'goods_price'=>$lt->goods_price,'goods_cnt'=>$lt->goods_cnt,'goods_point'=>$lt->goods_point,'option_cnt'=>$lt->option_cnt,'trade_day'=>date("Y-m-d H:i:s"));
								$goods_result = $this->common_m->insert2("dh_trade_goods",$insert_array);
								$trade_goods_idx = $this->db->insert_id();

								switch($lt->deliv_grp){
									case "이유식":
										$add_deliv_code = "-1";
									break;
									case "간식":
										$add_deliv_code = "-2";
									break;
									case "프로모션":
										$add_deliv_code = "-3";
									break;
									case "프로모션2":
										$add_deliv_code = "-4";
									break;
									case "합배송불가":
										$add_5_no++;
										$add_deliv_code = "-5".$add_5_no;
									break;
									case "무료배송":
										$add_deliv_code = "-6";
									break;
									case "프로모션3":
										$add_deliv_code = "-7";
									break;
								}

								$insert_data['trade_code'] = $trade_code;
								$insert_data['deliv_code'] = $trade_code."_1-".strtotime($lt->date_bind).$add_deliv_code;
								$insert_data['userid'] = $trade_data['userid'];
								$insert_data['order_name'] = $trade_data['name'];
								$insert_data['order_phone'] = $insert_trade['phone'];
								$insert_data['recv_name'] = $trade_data['send_name'];
								$insert_data['recv_phone'] = $insert_trade['send_phone'];
								$insert_data['prod_name'] = $lt->goods_name;
								$insert_data['tg_idx'] = $trade_goods_idx;
								$insert_data['deliv_date'] = $lt->date_bind;
								$insert_data['deliv_price'] = $trade_data['delivery_price'];
								$insert_data['deliv_addr'] = $this->input->post('deliv_addr_set');
								$insert_data['zipcode'] = $trade_data['zip1'];
								$insert_data['addr1'] = $trade_data['addr1'];
								$insert_data['addr2'] = $trade_data['addr2'];
								$insert_data['ct_subgroup'] = $lt->deliv_grp;
								$insert_data['deliv_stat'] = 0;
								$insert_data['wdate'] = timenow();

								//배송비 부과안된 이유식 낱개 주문건
								$insert_data['delivPoNm'] = $this->input->post('delivPoNm');

								$insert_data['allergy'] = 0;

								$dup_cnt = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '".$insert_data['deliv_code']."'","cnt");
								if($dup_cnt <= 0){

									switch($goods_stat->cate_no){
										case "1-6": $order_print_code = "100000"; break;	//준비기
										case "1-7": $order_print_code = "200000"; break;	//초기
										case "1-11": $order_print_code = "300000"; break;	//완료기
										case "1-10": $order_print_code = "400000"; break;	//후기
										case "1-9": $order_print_code = "500000"; break;	//중기
										case "1-8": $order_print_code = "600000"; break;	//중기준비기
										case "2-12": $order_print_code = "700000"; break;	//반찬
										case "2-13": $order_print_code = "800000"; break;	//국
										case "3": $order_print_code = "9100"; break;	//간식
										case "4": $order_print_code = "9100"; break;	//건강식품
										case "5": $order_print_code = "9200"; break;	//오산골농부
										case "6": $order_print_code = "902000"; break;	//특가셋
										case "7": $order_print_code = "9010"; break;	//샘플신청
										case "8": $order_print_code = "9100"; break;	//간식추가용
									}

									if($order_print_code == "9010"){
										switch($lt->goods_idx){
											case "50": $order_print_code = "9011"; break;	//초기 샘플
											case "383": $order_print_code = "9012"; break;	//중기 샘플
											case "384": $order_print_code = "9013"; break;	//후기 샘플
											case "385": $order_print_code = "9014"; break;	//완료기 샘플
										}
									}

									if($order_print_code == "902000"){
										switch($lt->goods_idx){
											case "119": $order_print_code = "902100"; break;	//초기셋
											case "127": $order_print_code = "902200"; break;	//중기셋
											case "136": $order_print_code = "902300"; break;	//후기셋
											case "145": $order_print_code = "902400"; break;	//완료기셋
										}
									}

									$insert_data['order_type'] = $order_print_code;

									$this->common_m->insert2("dh_trade_deliv_info",$insert_data);

								}
								else{

									$d_info_row = $this->common_m->self_q("select * from dh_trade_deliv_info where deliv_code = '".$insert_data['deliv_code']."'","row");

									$add_update_sql = "";

									/***************************

									2020년 6월 4일 디자인허브 김기엽

									단계 분류 과정에서 불필요한 변수초기화

									////간식인 경우
									//$snack = 0;
									////다른단계 낱개 이유식인 경우
									//$other_pack = 0;

									주석처리

									****************************/

									////간식인 경우
									//$snack = 0;
									////다른단계 낱개 이유식인 경우
									//$other_pack = 0;

									//배송이 정기배송인 경우와 아닌경우 구분 필요
									$is_recom_that = $d_info_row->recom_idx?true:false;	//정기배송건인경우 true 아니면 false
									$max_recom_idx = $d_info_row->recom_idx;

									//배송할 상품을 불러온다.
									$dplist = $this->common_m->self_q("select * from dh_trade_deliv_prod where deliv_code = '".$insert_data['deliv_code']."' and cate_no != '7'","result");
									//echo "deliv_date : ".$lt->date_bind."<BR>";
									//echo "샘플제외 deliv_code 가 동일상품수 : ".count($dplist)." @ ";
									if(count($dplist) > 0){

										$snack = 0;
										$other_pack = 0;
										$tk = 0;

										foreach($dplist as $dirs){	//배송할 상품 검색하여 간식, 특가셋트, 다른 종류의 이유식 존재 여부 확인

											/***************************

											2020년 6월 4일 디자인허브 김기엽

											 합배송여부 갯수 카운팅시 break 추가로 바로바로 카운팅하도록 개선

											 1. 동일한 카테고리일경우 스킵
											 2. 간식만 있는경우
											 3. 다른낱개만 있는경우
											 4. 간식과 다른 낱개 다 포함된경우
											 $goods_stat : 현재 돌고있는 장바구니 반복내에 제품정보
											 $dirs : 이미 배송테이블에 들어간 제품정보

											****************************/

											if($dirs->cate_no == $goods_stat->cate_no){
												continue;
											}
											else{
												if(
													$dirs->cate_no == '3' ||	//간식
													$dirs->cate_no == '4' ||	//건강식품
													$dirs->cate_no == '8' ||	//간식추가
													$goods_stat->cate_no == '3' ||		//간식
													$goods_stat->cate_no == '4' || 		//건강식품
													$goods_stat->cate_no == '8'				//간식추가
												){
													$snack++;
													$dpl_cateno = $dirs->cate_no;
												}
												else if($goods_stat->cate_no == '6'){
													$tk++;
												}
												else{
													$other_pack++;
													$dpl_cateno = $dirs->cate_no;
												}
											}
										}


										if($dirs->cate_no == 5 || $goods_stat->cate_no == 5){
											//20190305 update
											// 산골농부는 뭐가 같이 배송되던 산골농부로 가자는 에코맘의 의견으로 인하여 추가로 처리함
											$order_print_code = "1999999";
										}
										else{
											if($other_pack > 0 and $snack > 0){	//다른이유식, 간식 모두 있음
												//$order_print_code = "999999";
												if($is_recom_that){	//정기배송
													switch($max_recom_idx){
														case "2": $order_print_code = "1010"; break;	//준비기
														case "4": $order_print_code = "2010"; break;	//초기
														case "7": $order_print_code = "3010"; break;	//완료기
														case "6": $order_print_code = "4110"; break;	//후기2식
														case "1": $order_print_code = "4210"; break;	//후기3식
														case "5": $order_print_code = "5010"; break;	//중기
														case "3": $order_print_code = "7010"; break;	//반찬/국
													}
												}
												else{
													switch($goods_stat->cate_no){	//현재 장바구니의 제품 정보중 카테고리 cate_no
														case "1-6": $order_print_code = "100010"; break;	//준비기
														case "1-7": $order_print_code = "200010"; break;	//초기
														case "1-11": $order_print_code = "300010"; break;	//완료기
														case "1-10": $order_print_code = "400010"; break;	//후기
														case "1-9": $order_print_code = "500010"; break;	//중기
														case "1-8": $order_print_code = "600010"; break;	//중기준비기
														case "2-12": $order_print_code = "700010"; break;	//반찬
														case "2-13": $order_print_code = "800010"; break;	//국
														case "6": $order_print_code = "902000"; break;	//특가셋
														case "5": $order_print_code = "1999999"; break;	//오산골농부
													}
												}
											}
											else{
												if($other_pack > 0){	//다른이유식만 있음
													if($is_recom_that){	//정기배송임
														switch($max_recom_idx->recom_idx){
															case "2": $order_print_code = "1011"; break;	//준비기
															case "4": $order_print_code = "2011"; break;	//초기
															case "7": $order_print_code = "3011"; break;	//완료기
															case "6": $order_print_code = "4111"; break;	//후기2식
															case "1": $order_print_code = "4211"; break;	//후기3식
															case "5": $order_print_code = "5011"; break;	//중기
															case "3": $order_print_code = "7011"; break;	//반찬/국
														}
													}
													else{
														switch($goods_stat->cate_no){	//현재 배송테이블에 잡힌 상품의 카테고리 값
															case "1-6": $order_print_code = "100011"; break;	//준비기
															case "1-7": $order_print_code = "200011"; break;	//초기
															case "1-11": $order_print_code = "300011"; break;	//완료기
															case "1-10": $order_print_code = "400011"; break;	//후기
															case "1-9": $order_print_code = "500011"; break;	//중기
															case "1-8": $order_print_code = "600011"; break;	//중기준비기
															case "2-12": $order_print_code = "700011"; break;	//반찬
															case "2-13": $order_print_code = "800011"; break;	//국
															case "6": $order_print_code = "902000"; break;	//특가셋
															case "5": $order_print_code = "1999999"; break;	//오산골농부
														}
													}

													if($order_print_code == "902000"){	//특가에 간식 더해지거나 간식에 특가 더해진경우
														switch($lt->goods_idx){
															case "119": $order_print_code = "902100"; break;	//초기셋
															case "127": $order_print_code = "902200"; break;	//중기셋
															case "136": $order_print_code = "902300"; break;	//후기셋
															case "145": $order_print_code = "902400"; break;	//완료기셋
														}
													}
												}
												else if($snack > 0){	//간식만 있음
													if($is_recom_that){	//정기배송
														switch($max_recom_idx->recom_idx){
															case "2": $order_print_code = "1010"; break;	//준비기
															case "4": $order_print_code = "2010"; break;	//초기
															case "7": $order_print_code = "3010"; break;	//완료기
															case "6": $order_print_code = "4110"; break;	//후기2식
															case "1": $order_print_code = "4210"; break;	//후기3식
															case "5": $order_print_code = "5010"; break;	//중기
															case "3": $order_print_code = "7010"; break;	//반찬/국
														}
													}
													else{
														switch($goods_stat->cate_no){	//현재 배송테이블에 잡힌 상품의 카테고리 값
															case "1-6": $order_print_code = "100010"; break;	//준비기
															case "1-7": $order_print_code = "200010"; break;	//초기
															case "1-11": $order_print_code = "300010"; break;	//완료기
															case "1-10": $order_print_code = "400010"; break;	//후기
															case "1-9": $order_print_code = "500010"; break;	//중기
															case "1-8": $order_print_code = "600010"; break;	//중기준비기
															case "2-12": $order_print_code = "700010"; break;	//반찬
															case "2-13": $order_print_code = "800010"; break;	//국
															case "6": $order_print_code = "902000"; break;	//특가셋
															case "5": $order_print_code = "1999999"; break;	//오산골농부
														}
													}
												}
												else if($tk){
													$order_print_code = "902000";
												}
											}

											if($order_print_code == "9020" || $order_print_code == "902000"){	//특가에 간식 더해지거나 간식에 특가 더해진경우
												switch($lt->goods_idx){
													case "119": $order_print_code = "902100"; break;	//초기셋
													case "127": $order_print_code = "902200"; break;	//중기셋
													case "136": $order_print_code = "902300"; break;	//후기셋
													case "145": $order_print_code = "902400"; break;	//완료기셋
												}
											}
										}

										$order_db_code = $d_info_row->order_type;

										if($order_db_code != $order_print_code){
											if(!$is_recom_that and $order_db_code > (int)$order_print_code){
												//}
												//if(){	//기존 DB의 코드가 현재 나온 코드보다 더 큰경우

												$order_print_code = $order_db_code;

											}
										}
									}

									if($order_print_code == "1999999") $order_print_code = "9200";		//산골농부

									if($d_info_row->allergy){	//알러지면 닥치고 기타
										//$order_print_code = "999999";
									}

									if($order_print_code){	//바뀌는게 있으면
										$add_update_sql .= ", order_type = {$order_print_code}";
									}

									$usql99 = "update dh_trade_deliv_info set prod_name = CONCAT(prod_name,',".$lt->goods_name."') {$add_update_sql} where deliv_code = '".$insert_data['deliv_code']."'";

									$this->common_m->self_q($usql99,"update");

								}

								$fd_insert_normal['trade_code'] = $insert_data['trade_code'];
								$fd_insert_normal['deliv_code'] = $insert_data['deliv_code'];
								$fd_insert_normal['deliv_date'] = $lt->date_bind;
								$fd_insert_normal['goods_idx'] = $lt->goods_idx;
								$fd_insert_normal['prod_cnt'] = $lt->goods_cnt;
								$fd_insert_normal['cate_no'] = $goods_stat->cate_no;
								$fd_insert_normal['option_cnt'] = $lt->option_cnt;
								$fd_insert_normal['tg_idx'] = $trade_goods_idx;
								$fd_insert_normal['wdate'] = timenow();

								$trade_db_result = $this->common_m->insert2("dh_trade_deliv_prod",$fd_insert_normal);

								if($goods_result){

									if($lt->option_cnt > 0){

										$option_level1_row = $this->common_m->getRow2("dh_cart_option","where code='".$lt->code."' and cart_idx='".$lt->idx."' and option_code='".$data['option_arr'.$lt->idx][0]['option_code']."' and level=1 ");
										$insert_array_option1 = array('trade_code'=>$trade_code,'trade_goods_idx'=>$trade_goods_idx,'goods_idx'=>$lt->goods_idx,'option_idx'=>$option_level1_row->option_idx,'option_code'=>$option_level1_row->option_code,'level'=>1,'title'=>$option_level1_row->title,'name'=>$option_level1_row->name,'price'=>$option_level1_row->price,'point'=>$option_level1_row->point,'cnt'=>$option_level1_row->cnt,'chk_num'=>$option_level1_row->chk_num,'flag'=>$option_level1_row->flag,'trade_day'=>date("Y-m-d H:i:s"));
										$trade_db_result = $this->common_m->insert2("dh_trade_goods_option",$insert_array_option1); //레벨1옵션 등록

										for($i=0;$i<count($data['option_arr'.$lt->idx]);$i++){

											$option_stat = $this->common_m->getRow("dh_goods_option","where idx='".$data['option_arr'.$lt->idx][$i]['option_idx']."'");

											$insert_array_option2 = array(
												'trade_code'=>$trade_code,
												'trade_goods_idx'=>$trade_goods_idx,
												'goods_idx'=>$lt->goods_idx,
												'option_idx'=>$data['option_arr'.$lt->idx][$i]['option_idx'],
												'option_code'=>$data['option_arr'.$lt->idx][$i]['option_code'],
												'level'=>2,
												'title'=>$data['option_arr'.$lt->idx][$i]['title'],
												'name'=>$data['option_arr'.$lt->idx][$i]['name'],
												'price'=>$data['option_arr'.$lt->idx][$i]['price'],
												'point'=>$data['option_arr'.$lt->idx][$i]['point'],
												'cnt'=>$data['option_arr'.$lt->idx][$i]['cnt'],
												'chk_num'=>$data['option_arr'.$lt->idx][$i]['chk_num'],
												'flag'=>$data['option_arr'.$lt->idx][$i]['flag'],
												'trade_day'=>date("Y-m-d H:i:s")
											);
											$trade_db_result = $this->common_m->insert2("dh_trade_goods_option",$insert_array_option2); //레벨2옵션 등록

											//옵션 수량 변경
											$unlimit = $option_stat->unlimit;
											$number = $option_stat->number;

											if($unlimit!=1 && $number > 0){
												$number = $number - $data['option_arr'.$lt->idx][$i]['cnt'];
												$trade_db_result = $this->common_m->update2("dh_goods_option",array("number"=>$number),array("idx"=>$data['option_arr'.$lt->idx][$i]['option_idx']));
											}
										}
									}

									/*************************************************************************************************************************************************************
									20190326 김기엽
									여기다가 변경로직을 재구성 해봐야겠다.
									오더타입 입력을 디비 입력 이후에
									배송건 반복돌리면서 배송상품 조회해서 배송코드 잡는 식으로 다시 작업해봐야겠다.
									오류가 나는 원인을 찾기보단 로직을 변경하는게 더 빠를거 같다.
									수정 들어오면 그때 작업하자.
									*************************************************************************************************************************************************************/

									//if($tmpOk==1 && $change_trade_code){
									//	$trade_code = $basic_trade_code;
									//}

									//결제가 완료되면 장바구니 지우기
									//if($data['sample_is'] == "ok"){
									//	$trade_db_result = $this->common_m->del("dh_sample_cart","idx",$lt->idx);
									//}
									//else{
									//	$trade_db_result = $this->common_m->update2("dh_cart",array("trade_code"=>$trade_code,"trade_ok"=>1,"trade_day"=>date("Y-m-d H:i:s")),array("idx"=>$lt->idx));
									//}

									// 주문한 상품에서 수량을 삭제
									if($goods_stat->unlimit!=1 && $goods_stat->number>0 ){ //무제한이 아닐때에만
										$number = $goods_stat->number - $lt->goods_cnt;
										$trade_db_result = $this->common_m->update2("dh_goods",array("number"=>$number),array("idx"=>$lt->goods_idx)); //수량 변경
									}

								}
							}

							//$order_result['snack'] = $snack;
							//$order_result['other_pack'] = $other_pack;
							//$order_result['order_print_code'] = $order_print_code;

						}
						//장바구니 루프 종료

						if($tmpOk==1 && $change_trade_code){
							$trade_code = $change_trade_code;
						}

						//결제가 완료되면 장바구니 지우기
						$result = $this->common_m->update2("dh_cart",array("trade_ok"=>1,"trade_day"=>date("Y-m-d H:i:s")),array("trade_code"=>$trade_code));

						//예치금 삭감 로직
							if($trade_data['trade_method']==9){
								$content = "상품 구매시 사용 [{$trade_code}]";
								$deposit_arr = array(
									'userid'=>$trade_data['userid'],
									'point'=>"-".$trade_data['total_price'],
									'content'=>$content,
									'trade_code'=>$trade_code,
									'reg_date'=>date("Y-m-d H:i:s")
								);
								$this->common_m->insert2("dh_deposit",$deposit_arr);
							}
						//예치금 삭감 로직

						//포인트 사용했을 때 포인트 차감
						if($trade_data['userid'] && $trade_data['use_point'] > 0){
							$content = "상품구매사용[{$trade_code}]";
							$arrays = array('userid'=>$trade_data['userid'],'point'=>$trade_data['use_point'],'sum'=>'-','content'=>$content,'flag'=>'trade','flag_idx'=>$trade_idx,'trade_code'=>$trade_code,'reg_date'=>date("Y-m-d H:i:s"));
							$this->member_m->point_insert($arrays);
						}

						//쿠폰 사용했을 때 쿠폰 사용처리
						if($trade_data['userid'] && $trade_data['coupon_idx'] && $trade_data['use_coupon'] > 0){
							$this->common_m->update2("dh_coupon_use",array('trade_code'=>$trade_code,'use_date'=>date("Y-m-d H:i:s")),array('idx'=>$trade_data['coupon_idx']));
						}

						if($tmpOk!=1){
							//메일보내기
							$data['trade_idx'] = $trade_idx;
							$result = $this->common_m->mailform(3,$data);

							//알림톡 발송
							$bank = $insert_trade['enter_account'].PHP_EOL;
							$bank .= "은행명 : ".$insert_trade['enter_bank'].PHP_EOL;
							$bank .= "예금주 : ".$insert_trade['enter_info'].PHP_EOL;
							$bank .= "입금하시는분 성함 : ".$insert_trade['enter_name'];

							if($trade_data['trade_method'] == "2" || $trade_data['trade_method'] == "4"){	//무통장 주문시
								$token = $this->kkoat_m->token_generation();
								$phone = $trade_data['phone'];
								$name = $trade_data['name'];
								$add1 = number_format($trade_data['total_price']);
								$add2 = $bank;

								$msg = "{$name}님의\r\n입금계좌 안내입니다.\r\n\r\n배송일 D-1일 오전7시까지\r\n입금 시 주문 완료가 되며\r\n\r\n그 이후 입금 시\r\n해당 주문건은 자동으로\r\n취소됩니다.\r\n\r\n금액 : {$add1}원\r\n계좌 : {$add2}\r\n\r\n에코맘의 산골이유식";
								$tmpcode = "M_01459_130";
								$this->kkoat_m->ent_prise_kakao_send($token,$phone,$msg,$tmpcode);
							}
							else{
								$token = $this->kkoat_m->token_generation();

								$phone = $trade_data['phone'];
								$name = $trade_data['name'];
								$add1 = $trade_code;
								$add2 = '';

								$msg = "{$name}님,\r\n고맙습니다 :)\r\n\r\n주문번호 : {$add1}는\r\n주문완료 처리 되었습니다.\r\n\r\n주문변경 필요 시,\r\n마이페이지를 이용하시면\r\n더욱 빠르고 편리합니다.\r\n\r\n에코맘의 산골이유식";
								$tmpcode = "M_01459_90";
								$this->kkoat_m->ent_prise_kakao_send($token,$phone,$msg,$tmpcode);
							}
						}

					}


			}else{
				alert($this->input->post("go_url"),"잘못된 접근입니다.");
			}

			//$order_result['trade_db_result'] = $trade_db_result;

			return $result;
		}

		public function trade_complete($trade_code,$data=''){

			$tmpRow = $this->common_m->getRow2("dh_trade_tmp","where trade_code='".$this->db->escape_str($trade_code)."' order by idx limit 1");
			$trade_data = decode($tmpRow->data);

			//결제가 완료되면 장바구니 지우기
			if($data['sample_is'] == "ok"){

			}
			else{
				$this->common_m->update2("dh_cart",array("trade_ok"=>1,"trade_day"=>date("Y-m-d H:i:s")),array("trade_code"=>$trade_code));
			}

			//포인트 사용했을 때 포인트 차감
			if($trade_data['userid'] && $trade_data['use_point'] > 0){
				$content = "상품구매사용[{$trade_code}]";
				$arrays = array('userid'=>$trade_data['userid'],'point'=>$trade_data['use_point'],'sum'=>'-','content'=>$content,'flag'=>'trade','flag_idx'=>$trade_idx,'trade_code'=>$trade_code,'reg_date'=>date("Y-m-d H:i:s"));
				$result = $this->member_m->point_insert($arrays);
			}

			//쿠폰 사용했을 때 쿠폰 사용처리
			if($trade_data['userid'] && $trade_data['coupon_idx'] && $trade_data['use_coupon'] > 0){
				$result = $this->common_m->update2("dh_coupon_use",array('trade_code'=>$trade_code,'use_date'=>date("Y-m-d H:i:s")),array('idx'=>$trade_data['coupon_idx']));
			}

			$row = $this->common_m->self_q("select * from dh_trade where trade_code = '{$trade_code}'","row");

			//메일보내기
			$data['trade_idx'] = $row->idx;
			$result = $this->common_m->mailform(3,$data);

			//알림톡 발송
			$tok_sendno = $trade_data['phone'];
			$name = $trade_data['name'];

			$bank = $row->enter_account.PHP_EOL;
			$bank .= "은행명 : ".$row->enter_bank.PHP_EOL;
			$bank .= "예금주 : ".$row->enter_info.PHP_EOL;
			$bank .= "입금하시는분 성함 : ".$row->enter_name;

			if($trade_data['trade_method'] == "2" || $trade_data['trade_method'] == "4"){	//무통장 OR 가상계좌 주문시
				$token = $this->kkoat_m->token_generation();
				$phone = $tok_sendno;
				$add1 = number_format($trade_data['total_price']);
				$add2 = $bank;

				$msg = "{$name}님의\r\n입금계좌 안내입니다.\r\n\r\n배송일 D-1일 오전7시까지\r\n입금 시 주문 완료가 되며\r\n\r\n그 이후 입금 시\r\n해당 주문건은 자동으로\r\n취소됩니다.\r\n\r\n금액 : {$add1}원\r\n계좌 : {$add2}\r\n\r\n에코맘의 산골이유식";
				$tmpcode = "M_01459_130";
				$this->kkoat_m->ent_prise_kakao_send($token,$phone,$msg,$tmpcode);
			}
			else{
				$token = $this->kkoat_m->token_generation();

				$phone = $trade_data['phone'];
				$name = $trade_data['name'];
				$add1 = $trade_code;
				$add2 = '';

				$msg = "{$name}님,\r\n고맙습니다 :)\r\n\r\n주문번호 : {$add1}는\r\n주문완료 처리 되었습니다.\r\n\r\n주문변경 필요 시,\r\n마이페이지를 이용하시면\r\n더욱 빠르고 편리합니다.\r\n\r\n에코맘의 산골이유식";
				$tmpcode = "M_01459_90";
				$this->kkoat_m->ent_prise_kakao_send($token,$phone,$msg,$tmpcode);
			}

			return $result;
		}


		public function kcp($data='')
		{
			$trade_data = $data['trade_data'];

			$res_cd = $this->input->post("res_cd");
			$res_msg = $this->input->post("res_msg");
			$trade_code = $this->input->post("trade_code",true);

			if($res_cd=="0000"){
				$tno = $this->input->post("tno");
				$good_name = $this->input->post("good_name");
				$buyr_name = $this->input->post("buyr_name");

				$insert_array = array('site_cd'=>$this->input->post("site_cd"),'req_tx'=>$this->input->post("req_tx"),'use_pay_method'=>$this->input->post("use_pay_method"),'res_cd'=>$this->input->post("res_cd"),'res_msg'=>$res_msg,'amount'=>$this->input->post("amount"),'ordr_idxx'=>$this->input->post("ordr_idxx"),'tno'=>$tno,'good_mny'=>$this->input->post("good_mny"),'good_name'=>$good_name,'buyr_name'=>$buyr_name,'buyr_tel1'=>$this->input->post("buyr_tel1"),'buyr_tel2'=>$this->input->post("buyr_tel2"),'buyr_mail'=>$this->input->post("buyr_mail"),'app_time'=>$this->input->post("app_time"),'card_cd'=>$this->input->post("card_cd"),'card_name'=>$this->input->post("card_name"),'noinf'=>$this->input->post("noinf"),'quota'=>$this->input->post("quota"),'app_no'=>$this->input->post("app_no"),'bank_name'=>$this->input->post("bank_name"),'bank_code'=>$this->input->post("bank_code"),'bankname'=>$this->input->post("bankname"),'depositor'=>$this->input->post("depositor"),'account'=>$this->input->post("account"),'va_date'=>$this->input->post("va_date"),'cash_yn'=>$this->input->post("cash_yn"),'cash_authno'=>$this->input->post("cash_authno"),'cash_tr_code'=>$this->input->post("cash_tr_code"),'cash_id_info'=>$this->input->post("cash_id_info"));

				$result = $this->common_m->insert2("dh_kcp_pay",$insert_array);

			}else{
				alert(cdir()."/dh_order/pay_error/".$res_cd."/?go_url=".$this->input->post("go_url"));
				exit;
			}

			return $result;
		}


		public function inicis($data='')
		{
			$trade_data = $data['trade_data'];

			$ResultCode = $this->input->post("ResultCode",true);
			$PayMethod = $this->input->post("PayMethod",true);
			$ResultMsg = $this->input->post("ResultMsg",true);
			$MOID = $this->input->post("trade_code",true);
			$TotPrice = $trade_data['total_price'];
			$ApplNum = $this->input->post("ApplNum",true);
			$CARD_Quota = $this->input->post("CARD_Quota",true);
			$CARD_Interest = $this->input->post("CARD_Interest",true);
			$CARD_Code = $this->input->post("CARD_Code",true);
			$ACCT_BankCode = $this->input->post("ACCT_BankCode",true);
			$CSHR_ResultCode = $this->input->post("CSHR_ResultCode",true);
			$CSHR_Type = $this->input->post("CSHR_Type",true);
			$VACT_Num = $this->input->post("VACT_Num",true);
			$VACT_BankCode = $this->input->post("VACT_BankCode",true);
			$VACT_Date = $this->input->post("VACT_Date",true);
			$VACT_InputName = $this->input->post("VACT_InputName",true);
			$VACT_Name = $this->input->post("VACT_Name",true);
			$regDate = date("Y-m-d H:i:s");

			if($ResultCode=="0000"){
				$TID = $this->input->post("tno");

				$insert_array = array('TID'=>$TID,'ResultCode'=>$ResultCode,'ResultMsg'=>$ResultMsg,'PayMethod'=>$PayMethod,'MOID'=>$MOID,'TotPrice'=>$TotPrice,'ApplNum'=>$ApplNum,'CARD_Quota'=>$CARD_Quota,'CARD_Interest'=>$CARD_Interest,'CARD_Code'=>$CARD_Code,'ACCT_BankCode'=>$ACCT_BankCode,'CSHR_ResultCode'=>$CSHR_ResultCode,'CSHR_Type'=>$CSHR_Type,'VACT_Num'=>$VACT_Num,'VACT_BankCode'=>$VACT_BankCode,'VACT_Date'=>$VACT_Date,'VACT_InputName'=>$VACT_InputName,'VACT_Name'=>$VACT_Name,'regDate'=>$regDate);

				$result = $this->common_m->insert2("dh_inicis_pay",$insert_array);

			}else{
				alert(cdir()."/dh_order/pay_error/".$ResultCode."/?go_url=".$this->input->post("go_url"));
				exit;
			}

			return $result;
		}


		public function getTradeOption($trade_code)
		{
			//$sql = "select t.*,g.list_img,g.old_price from dh_trade_goods t,dh_goods g where g.idx=t.goods_idx and t.trade_code='".$this->db->escape_str($trade_code)."' order by t.idx desc";
			$sql = "select * from dh_trade_goods where trade_code = '".$this->db->escape_str($trade_code)."' order by date_bind desc";
			$query = $this->db->query($sql);
			$goods_list = $query->result();

			foreach($goods_list as $lt){
				$idx = $lt->idx;
				$sql = "select * from dh_trade_goods_option where trade_goods_idx='".$this->db->escape_str($lt->idx)."' and level=2 order by idx";
				$query = $this->db->query($sql);
				$option_list = $query->result();
				${'option_arr'.$idx}="";

				$cnt=0;
				foreach($option_list as $option){
					${'option_arr'.$idx}[$cnt]['idx'] = $option->idx;
					${'option_arr'.$idx}[$cnt]['option_idx'] = $option->option_idx;
					${'option_arr'.$idx}[$cnt]['option_code'] = $option->option_code;
					${'option_arr'.$idx}[$cnt]['title'] = $option->title;
					${'option_arr'.$idx}[$cnt]['name'] = $option->name;
					${'option_arr'.$idx}[$cnt]['price'] = $option->price;
					${'option_arr'.$idx}[$cnt]['cnt'] = $option->cnt;
					${'option_arr'.$idx}[$cnt]['flag'] = $option->flag;
					${'option_arr'.$idx}[$cnt]['level'] = $option->level;
					${'option_arr'.$idx}[$cnt]['point'] = $option->point;
					${'option_arr'.$idx}[$cnt]['chk_num'] = $option->chk_num;
					$cnt++;
				}

				$data['option_arr'.$idx] = ${'option_arr'.$idx};
			}

			$data['goods_list'] = $goods_list;

			return $data;
		}


		public function getTradeOptionList($goods_list)
		{
			$data="";
			foreach($goods_list as $lt){
				$idx = $lt->g_idx;
				$sql = "select * from dh_trade_goods_option where trade_goods_idx='".$this->db->escape_str($idx)."' and level=2 order by idx";
				$query = $this->db->query($sql);
				$option_list = $query->result();

				$cnt=0;
				foreach($option_list as $option){
					$data['option_arr'.$idx][$cnt]['idx'] = $option->idx;
					$data['option_arr'.$idx][$cnt]['option_idx'] = $option->option_idx;
					$data['option_arr'.$idx][$cnt]['option_code'] = $option->option_code;
					$data['option_arr'.$idx][$cnt]['title'] = $option->title;
					$data['option_arr'.$idx][$cnt]['name'] = $option->name;
					$data['option_arr'.$idx][$cnt]['price'] = $option->price;
					$data['option_arr'.$idx][$cnt]['cnt'] = $option->cnt;
					$data['option_arr'.$idx][$cnt]['flag'] = $option->flag;
					$data['option_arr'.$idx][$cnt]['level'] = $option->level;
					$data['option_arr'.$idx][$cnt]['point'] = $option->point;
					$data['option_arr'.$idx][$cnt]['chk_num'] = $option->chk_num;

					$cnt++;
				}
			}

			return $data;
		}


		public function kcp_cancel($trade_code)
		{
			$ordr_idxx = $this->input->post("ordr_idxx");
			$req_tx = $this->input->post("req_tx");
			$bSucc = $this->input->post("bSucc");
			$res_cd = $this->input->post("res_cd");
			$res_msg = $this->input->post("res_msg");
			$ordr_idxx = $this->input->post("ordr_idxx");
			$go_url = $this->input->post("go_url");
			$res_msg_bsucc = "";
			$result = "";
			$mode = $this->uri->segment(4,'list');

			if(!$go_url){
				$go_url = cdir()."/dh_order/shop_order_".$mode."/".$trade_code;
			}
			if($trade_code){

				if($req_tx == "pay")
				{
					//업체 DB 처리 실패
					if($bSucc == "false")
					{
						if ($res_cd == "0000")
						{
							$res_msg_bsucc = "결제는 정상적으로 이루어졌지만 업체에서 결제 결과를 처리하는 중 오류가 발생하여 시스템에서 자동으로 취소 요청을 하였습니다. <br> 업체로 문의하여 확인하시기 바랍니다.";
						}
						else
						{
							$res_msg_bsucc = "결제는 정상적으로 이루어졌지만 업체에서 결제 결과를 처리하는 중 오류가 발생하여 시스템에서 자동으로 취소 요청을 하였으나, <br> <b>취소가 실패 되었습니다.</b><br> 업체로 문의하여 확인하시기 바랍니다.";
						}
					}

				}else if($req_tx=="mod"){
					if($res_cd=="0000"){ //성공처리
						$result=1;

					}else{
						$res_msg_bsucc = "주문 취소 실패";
					}
				}

			}

			if($res_msg_bsucc){
				alert($go_url,$res_msg_bsucc);
				exit;
			}

			return $result;
		}


		public function inicis_cancel($trade_code)
		{
			$ResultCode = $this->input->post("ResultCode");
			$ResultMsg = $this->input->post("ResultMsg");
			$go_url = $this->input->post("go_url");
			$res_msg_bsucc = "";
			$result = "";
			$mode = $this->uri->segment(4,'list');

			if(!$go_url){
				$go_url = cdir()."/dh_order/shop_order_".$mode."/".$trade_code;
			}

			if($ResultCode=="00"){
				$result=1;
			}else{
				$res_msg_bsucc = $ResultMsg;
			}

			if($res_msg_bsucc){
				alert($go_url,$res_msg_bsucc);
				exit;
			}

			return $result;
		}


		public function change_stat($change_idx,$change_stat,$all='')
		{
			if($all==1){
				$trade_stat = $this->common_m->getRow("dh_trade","where trade_code='".$this->db->escape_str($change_idx)."'");
				$change_idx = $trade_stat->idx;
			}else{
				$trade_stat = $this->common_m->getRow("dh_trade","where idx='".$this->db->escape_str($change_idx)."'");
			}

			$shop_info = $this->common_m->shop_info();
			$trade_code = $trade_stat->trade_code;

			if($trade_stat->trade_stat!=$change_stat){ //변경할 거래상태가 다를때에만 실행

				$log['trade_code'] = $trade_stat->trade_code;
				$log['prev'] = $trade_stat->trade_stat;
				$log['next'] = $change_stat;
				$log['act'] = $this->session->userdata('ADMIN_USERID');
				$log['name'] = $this->session->userdata('ADMIN_NAME');
				$log['wdate'] = timenow();

				$this->common_m->insert2("dh_trade_statuschg_log",$log);

				if($trade_stat->trade_stat == 9){
					back('주문취소건은 다시 복구할 수 없습니다.');
					exit;
				}
				/*
				else if($trade_stat->trade_stat == 4 && $change_stat < 4){
					back('판매완료건은 교환/반품/주문취소만 변경 가능합니다.');
					exit;
				}
				*/
				else{
					$result = $this->common_m->update2("dh_trade",array('trade_stat'=>$change_stat),array('idx'=>$change_idx));
					if($result){

						if($change_stat==2){ //결제완료

							$result = $this->common_m->update2("dh_trade",array('trade_day_ok'=>date("Y-m-d H:i:s")),array('idx'=>$change_idx));

							$token = $this->kkoat_m->token_generation();

							$phone = $trade_stat->phone;
							$name = $trade_stat->name;
							$add1 = number_format($trade_stat->total_price);
							$add2 = $trade_stat->trade_code;

							$msg = "{$name}님,\r\n입금 감사합니다 :)\r\n\r\n입금액 : {$add1}원\r\n주문번호 : {$add2}\r\n\r\n주문변경 필요 시,\r\n마이페이지를 이용하시면\r\n더욱 빠르고 편리합니다.\r\n\r\n에코맘의 산골이유식";
							$tmpcode = "M_01459_80";
							$this->kkoat_m->ent_prise_kakao_send($token,$phone,$msg,$tmpcode);

						}if($change_stat==4){ //판매완료

							if($trade_stat->trade_method=="22"){ //네이버페이 판매 완료시 거래완료 연동

								$result = $this->common_m->naver_pay_ok($trade_stat->paymentId); //거래완료

								$result = $this->common_m->naver_pay_point($trade_stat->paymentId); //네이버포인트 적립

							}

							if($trade_stat->userid && $trade_stat->save_point > 0){ //포인트적립 +
									$content = "상품구매적립";
									$arrays = array('userid'=>$trade_stat->userid,'point'=>$trade_stat->save_point,'content'=>$content,'flag'=>'trade','flag_idx'=>$trade_stat->idx,'trade_code'=>$trade_code,'reg_date'=>date("Y-m-d H:i:s"));
									$this->member_m->point_insert($arrays);
							}

							$result = $this->common_m->update2("dh_trade",array('trade_day_end'=>date("Y-m-d H:i:s")),array('idx'=>$change_idx)); //판매완료일 등록

						}else if($change_stat==9){ //주문취소

							$result = $this->common_m->update2("dh_trade",array('trade_day_cancel'=>date("Y-m-d H:i:s")),array('idx'=>$change_idx));

							//$sms_data['trade_code'] = $trade_stat->trade_code;
							//$result = $this->common_m->icode_sms("sms3",$sms_data);

							//알림톡 발송 주문취소 템플릿 5362
							$tok_sendno = $trade_stat->phone;
							$name = $trade_stat->name;
							$add1 = $trade_stat->trade_code;
							$this->common_m->orange_kakao_send('5362',$name,$tok_sendno,$add1,'');

							$token = $this->kkoat_m->token_generation();

							$phone = $trade_stat->phone;
							$name = $trade_stat->name;
							$add1 = $trade_stat->trade_code;

							$msg = "{$name}님,\r\n고마웠습니다 (__)\r\n\r\n주문번호 : {$add1}는\r\n주문취소 처리 되었습니다.\r\n\r\n에코맘의 산골이유식";
							$tmpcode = "M_01459_30";
							$this->kkoat_m->ent_prise_kakao_send($token,$phone,$msg,$tmpcode);

							if($trade_stat->userid && $trade_stat->use_point > 0){ //포인트 사용했다면 다시 되돌리기 +
								$result="";
								$content = "상품구매사용 주문취소";
								$arrays = array('userid'=>$trade_stat->userid,'point'=>$trade_stat->use_point,'content'=>$content,'flag'=>'trade','flag_idx'=>$trade_stat->idx,'trade_code'=>$trade_code,'reg_date'=>date("Y-m-d H:i:s"));
								$result = $this->member_m->point_insert($arrays);
							}

							if($trade_stat->trade_stat==4 && $trade_stat->userid && $trade_stat->save_point > 0){ //포인트 적립되었다면 포인트 차감	-
								$result="";
								$content = "상품구매적립 주문취소";
								$arrays = array('userid'=>$trade_stat->userid,'point'=>'-'.$trade_stat->save_point,'content'=>$content,'flag'=>'trade','flag_idx'=>$trade_stat->idx,'trade_code'=>$trade_code,'reg_date'=>date("Y-m-d H:i:s"));
								$result = $this->member_m->point_insert($arrays);
							}

							/* 상품재고 돌리기 start */

							$trade_stat = $this->common_m->getRow("dh_trade","where idx='$change_idx'");

							$trade_goods_result = $this->common_m->getList2("dh_trade_goods","where trade_code='".$trade_stat->trade_code."'");

							foreach($trade_goods_result as $goods){
								$goods_stat = $this->common_m->getRow("dh_goods","where idx='".$goods->goods_idx."'");
								$this->common_m->update2("dh_goods",array('number'=>$goods_stat->number+1),array('idx'=>$goods->goods_idx,'unlimit'=>0));

								$trade_goods_option_result = $this->common_m->getList2("dh_trade_goods_option","where goods_idx='".$goods->goods_idx."' and trade_code='".$trade_stat->trade_code."' and level=2");
								foreach($trade_goods_option_result as $option){

									$goods_option_row = $this->common_m->getRow2("dh_goods_option","where idx='".$option->option_idx."'");
									$this->common_m->update2("dh_goods_option",array('number'=>$goods_option_row->number+1),array('idx'=>$option->option_idx));
								}
							}
							/* 상품재고 돌리기 end */

							if($trade_stat->userid && $trade_stat->coupon_idx > 0){ //쿠폰 되돌리기
								$this->common_m->update2("dh_coupon_use",array('trade_code' => '','use_date' => ''),array('idx' => $trade_stat->coupon_idx));
							}

							//정기주문내역 삭제하기 였는데 취소로 돌리기
							//$this->common_m->self_q("delete from dh_trade_deliv_info where trade_code = '".$trade_stat->trade_code."'","delete");
							//정기주문내역 업데이트 ( 주문코드 동일한 송장번호가 없는 배송내역만 취소로 전환 )
							$this->common_m->self_q("update dh_trade_deliv_info set deliv_stat = '5' where trade_code = '".$trade_stat->trade_code."' and invoice_no = ''","update");

							//정기주문 상품내역 삭제하기 였는데 삭제하지말기
							//$this->common_m->self_q("delete from dh_trade_deliv_prod where trade_code = '".$trade_stat->trade_code."'","delete");


							if($all==''){
								//result($result,'주문이 취소','/html/order/lists/'.$change_stat.'/m');
								result($result,'주문이 취소',$_SERVER['HTTP_REFERER']);
								exit;
							}

						}

						if($all==''){
							//alert('/html/order/lists/'.$change_stat.'/m');
							alert($_SERVER['HTTP_REFERER']);
						}

					}

				}

			}else{
				if($all==''){
					//alert('/html/order/lists/'.$change_stat.'/m');
					alert($_SERVER['HTTP_REFERER']);
				}
			}

			return $result;

		}


		public function delivery_ok($trade_idx)
		{
			$trade_stat = $this->common_m->getRow("dh_trade","where idx='".$this->db->escape_str($trade_idx)."'");
			$delivery_idx = $this->input->post("delivery_idx".$trade_idx,true);
			$delivery_no = $this->input->post("delivery_no".$trade_idx,true);

			$result = $this->common_m->update2("dh_trade",array('delivery_idx'=>$delivery_idx,'delivery_no'=>$delivery_no),array('idx'=>$trade_idx));

			if($result && $delivery_idx && $delivery_no){

				if( $trade_stat->delivery_idx == $delivery_idx && $trade_stat->delivery_no == $delivery_no){

				}else if( $trade_stat->delivery_idx != $delivery_idx || $trade_stat->delivery_no != $delivery_no){
					//메일보내기
					$data['trade_idx'] = $trade_idx;
					$data['delivery_idx'] = $delivery_idx;
					$data['delivery_no'] = $delivery_no;
					$result = $this->common_m->mailform(4,$data);
				}

			}

		return $result;

		}


		public function getTmpList($tc)
		{
			$sql = "select *
			,(select goods_name from dh_cart where trade_code=dh_trade_tmp.trade_code order by idx limit 1) as goods_name
			,(select count(idx) from dh_cart where trade_code=dh_trade_tmp.trade_code) as cnt
			from dh_trade_tmp
			where trade_code like '%{$tc}%'";
			echo $sql;
			$query = $this->db->query($sql);
			$result = $query->result();
			return $result;

		}


		public function codeInput($mode='input')
		{
			$code = $this->db->escape_str($this->input->post("code",true));
			$name = $this->db->escape_str($this->input->post("name",true));
			$use_sdate = $this->db->escape_str($this->input->post("use_sdate",true));
			$use_edate = $this->db->escape_str($this->input->post("use_edate",true));
			$max_count = $this->db->escape_str($this->input->post("max_count",true));
			$type = $this->db->escape_str($this->input->post("type",true));
			$date_flag = $this->db->escape_str($this->input->post("date_flag",true));
			$discount_flag = $this->db->escape_str($this->input->post("discount_flag",true));
			$price = $this->db->escape_str($this->input->post("price",true));
			$min_price = $this->db->escape_str($this->input->post("min_price",true));
			$max_price = $this->db->escape_str($this->input->post("max_price",true));
			$member_use = $this->db->escape_str($this->input->post("member_use",true));
			$member_level = $this->db->escape_str($this->input->post("member_level",true));

			$img_file = "";
			$real_file = "";

			if(isset($_FILES['img_file']['name']) && $_FILES['img_file']['size'] > 0)
			{
				$config = array('upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/upload/','allowed_types' => '*','encrypt_name' => TRUE,'max_size' => '20000');
				$this->load->library('upload',$config);

				if(!$this->upload->do_upload('img_file')){ back(strip_tags($this->upload->display_errors())); }
				else{
					$write_data = $this->upload->data();
					$img_file	= $write_data['file_name'];
					$real_file	=	$_FILES['img_file']['name'];
				}
			}else if($mode=="edit"){
				$idx = $this->db->escape_str($this->input->post("idx",true));
				$editRow = $this->common_m->getRow("dh_coupon","where idx='$idx'");
				$img_file = $editRow->img_file;
				$real_file = $editRow->real_file;
			}

			$insert_array['name'] = $name;
			$insert_array['use_sdate'] = $use_sdate;
			$insert_array['use_edate'] = $use_edate;
			$insert_array['max_count'] = $max_count;
			$insert_array['type'] = $type;
			$insert_array['date_flag'] = $date_flag;
			$insert_array['discount_flag'] = $discount_flag;
			$insert_array['price'] = $price;
			$insert_array['min_price'] = $min_price;
			$insert_array['max_price'] = $max_price;
			$insert_array['member_use'] = $member_use;
			$insert_array['member_level'] = $member_level;
			$insert_array['status'] = "1";
			$insert_array['img_file'] = $img_file;
			$insert_array['real_file'] = $real_file;

			if($date_flag==0){
				$start_date = $this->db->escape_str($this->input->post("start_date",true));
				$end_date = $this->db->escape_str($this->input->post("end_date",true));
				$insert_array['start_date'] = $start_date;
				$insert_array['end_date'] = $end_date;
			}else if($date_flag==1){
				$max_day = $this->db->escape_str($this->input->post("max_day",true));
				$insert_array['max_day'] = $max_day;
			}

			if($mode=="input"){
				$insert_array['code'] = $code;
				$insert_array['reg_date'] = date("Y-m-d H:i:s");
				$result = $this->common_m->insert2("dh_coupon",$insert_array);
			}else if($mode=="edit"){
				$result = $this->common_m->update2("dh_coupon",$insert_array,array('idx'=>$idx));
			}

			return $result;

		}


		public function couponGive($row,$admin='')
		{
			$userid = $this->session->userdata('USERID');
			if( ($admin==1 && $this->session->userdata('ADMIN_USERID')) || $userid==""){
				$userid = $row->userid;
			}

			$member_row = $this->common_m->getRow("dh_member","where outmode!=1 and userid='$userid'");
			$where_query = "";
			$nowdate = date("Y-m-d");
			$nowyear = date("Y");

			if($row->type=="1"){ //기념일 쿠폰이면 이번년도에 발급한적이 있는지 검사
				$where_query.= "and userid='$userid' and reg_date >= '".$nowyear."-01-01 00:00:00' and reg_date <= '".$nowyear."-12-31 23:59:59'";
			}
			else if($row->type == '4'){
				$where_query.= "and type=4";
			}

			$cnt = $this->common_m->getCount("dh_coupon_use","where code='".$row->code."' $where_query");

			if($cnt){ back("이미 발급받은 쿠폰입니다."); exit; }
			if($row->member_use==1 && $row->member_level && $row->member_level != $member_row->level){
				if($admin=="" || !$this->session->userdata('ADMIN_USERID')){ //관리자가 아니면
					back("쿠폰 발급 대상이 아닙니다.\\n관리자에게 문의하여 주세요."); exit;
				}else{
					back("쿠폰 발급 가능한 등급과 회원등급이 일치하지 않습니다."); exit;
				}
			}

			$insert_array['userid'] = $this->db->escape_str($userid);
			$insert_array['code'] = $this->db->escape_str($row->code);
			$insert_array['name'] = $this->db->escape_str($row->name);
			$insert_array['type'] = $this->db->escape_str($row->type);
			$insert_array['discount_flag'] = $this->db->escape_str($row->discount_flag);
			$insert_array['price'] = $this->db->escape_str($row->price);
			$insert_array['min_price'] = $this->db->escape_str($row->min_price);
			$insert_array['max_price'] = $this->db->escape_str($row->max_price);


			if($row->date_flag==1){ //기념일쿠폰이거나 이용기한 종류가 발금시점이거나
				$start_date = $nowdate;
				$end_date = date("Y-m-d",strtotime($row->max_day,strtotime($start_date)));
			}else{
				$start_date = $row->start_date;
				$end_date = $row->end_date;
			}

			$insert_array['start_date'] = $this->db->escape_str($start_date);
			$insert_array['end_date'] = $this->db->escape_str($end_date);
			$insert_array['reg_date'] = date("Y-m-d H:i:s");

			$result = $this->common_m->insert2("dh_coupon_use",$insert_array);

		 return 1;
		}

		public function inicis_post($data='')
		{

			require_once($_SERVER['DOCUMENT_ROOT'].'/pay/stdpay/libs/INIStdPayUtil.php');

			if($data['mode'] == "request"){

				$SignatureUtil = new INIStdPayUtil();
				/*
					//*** 위변조 방지체크를 signature 생성 ***

					oid, price, timestamp 3개의 키와 값을

					key=value 형식으로 하여 '&'로 연결한 하여 SHA-256 Hash로 생성 된값

					ex) oid=INIpayTest_1432813606995&price=819000&timestamp=2012-02-01 09:19:04.004


				 * key기준 알파벳 정렬

				 * timestamp는 반드시 signature생성에 사용한 timestamp 값을 timestamp input에 그대로 사용하여야함
				 */

				//############################################
				// 1.전문 필드 값 설정(***가맹점 개발수정***)
				//############################################
				// 여기에 설정된 값은 Form 필드에 동일한 값으로 설정
				$mid = $_SERVER['HTTP_X_FORWARDED_FOR'] == "58.229.223.174"?"INIpayTest":$data['shop_info']['pg_id'];  // 가맹점 ID(가맹점 수정후 고정)
				//인증

				if($mid=="INIpayTest"){
					$signKey = "SU5JTElURV9UUklQTEVERVNfS0VZU1RS"; // 가맹점에 제공된 웹 표준 사인키(가맹점 수정후 고정)
				}else{
					$signKey = $data['shop_info']['pg_pw']; // 가맹점에 제공된 웹 표준 사인키(가맹점 수정후 고정)
				}

				$timestamp = $SignatureUtil->getTimestamp();   // util에 의해서 자동생성

				$orderNumber = $_REQUEST['TRADE_CODE']; // 가맹점 주문번호(가맹점에서 직접 설정)
				$price = $_REQUEST['total_price'];        // 상품가격(특수기호 제외, 가맹점에서 직접 설정)

				$cardNoInterestQuota = "";  // 카드 무이자 여부 설정(가맹점에서 직접 설정)
				$cardQuotaBase = "2:3:4:5:6:11:12:24:36";  // 가맹점에서 사용할 할부 개월수 설정
				//###################################
				// 2. 가맹점 확인을 위한 signKey를 해시값으로 변경 (SHA-256방식 사용)
				//###################################
				$mKey = $SignatureUtil->makeHash($signKey, "sha256");

				$params = array(
						"oid" => $orderNumber,
						"price" => $price,
						"timestamp" => $timestamp
				);
				$sign = $SignatureUtil->makeSignature($params, "sha256");

				/* 기타 */
				$siteDomain = "http://".$_SERVER['HTTP_HOST']."/pay/stdpay/INIStdPaySample"; //가맹점 도메인 입력
				// 페이지 URL에서 고정된 부분을 적는다.
				// Ex) returnURL이 http://localhost:8082/demo/INIpayStdSample/INIStdPayReturn.jsp 라면
				//                 http://localhost:8082/demo/INIpayStdSample 까지만 기입한다.

				$data=$mid."@@".$price."@@".$sign."@@".$mKey."@@".$timestamp."@@".$cardNoInterestQuota."@@".$cardQuotaBase;
				return $data;

			}else{

        require_once($_SERVER['DOCUMENT_ROOT'].'/pay/stdpay/libs/HttpClient.php');


        $util = new INIStdPayUtil();

        try {

            //#############################
            // 인증결과 파라미터 일괄 수신
            //#############################
            //		$var = $_REQUEST["data"];

            //#####################
            // 인증이 성공일 경우만
            //#####################
            if (strcmp("0000", $_REQUEST["resultCode"]) == 0) {

                //############################################
                // 1.전문 필드 값 설정(***가맹점 개발수정***)
                //############################################;

                $mid 			= $_REQUEST["mid"];     					// 가맹점 ID 수신 받은 데이터로 설정

								if($mid=="INIpayTest"){
									$signKey = "SU5JTElURV9UUklQTEVERVNfS0VZU1RS"; // 가맹점에 제공된 웹 표준 사인키(가맹점 수정후 고정)
								}else{
									$signKey = $data['shop_info']['pg_pw']; // 가맹점에 제공된 웹 표준 사인키(가맹점 수정후 고정)
								}

                $timestamp 		= $util->getTimestamp();   					// util에 의해서 자동생성
                $charset 		= "UTF-8";        							// 리턴형식[UTF-8,EUC-KR](가맹점 수정후 고정)
                $format 		= "JSON";        							// 리턴형식[XML,JSON,NVP](가맹점 수정후 고정)

                $authToken 		= $_REQUEST["authToken"];   				// 취소 요청 tid에 따라서 유동적(가맹점 수정후 고정)
                $authUrl 		= $_REQUEST["authUrl"];    					// 승인요청 API url(수신 받은 값으로 설정, 임의 세팅 금지)
                $netCancel 		= $_REQUEST["netCancelUrl"];   				// 망취소 API url(수신 받은f값으로 설정, 임의 세팅 금지)

                $mKey 			= hash("sha256", $signKey);					// 가맹점 확인을 위한 signKey를 해시값으로 변경 (SHA-256방식 사용)

                //#####################
                // 2.signature 생성
                //#####################
                $signParam["authToken"] 	= $authToken;  	// 필수
                $signParam["timestamp"] 	= $timestamp;  	// 필수
                // signature 데이터 생성 (모듈에서 자동으로 signParam을 알파벳 순으로 정렬후 NVP 방식으로 나열해 hash)
                $signature = $util->makeSignature($signParam);


                //#####################
                // 3.API 요청 전문 생성
                //#####################
                $authMap["mid"] 			= $mid;   		// 필수
                $authMap["authToken"] 		= $authToken; 	// 필수
                $authMap["signature"] 		= $signature; 	// 필수
                $authMap["timestamp"] 		= $timestamp; 	// 필수
                $authMap["charset"] 		= $charset;  	// default=UTF-8
                $authMap["format"] 			= $format;  	// default=XML


                try {

                    $httpUtil = new HttpClient();

                    //#####################
                    // 4.API 통신 시작
                    //#####################

                    $authResultString = "";

                    if ($httpUtil->processHTTP($authUrl, $authMap)) {
                        $authResultString = $httpUtil->body;
                       // echo "<p><b>RESULT DATA :</b> $authResultString</p>";			//PRINT DATA
                    } else {
                        //echo "Http Connect Error\n";
                       // echo $httpUtil->errormsg;

                        throw new Exception("Http Connect Error");
                    }

                    //############################################################
                    //5.API 통신결과 처리(***가맹점 개발수정***)
                    //############################################################
                    //echo "## 승인 API 결과 ##";

                    $resultMap = json_decode($authResultString, true);


                    /*************************  결제보안 추가 2016-05-18 START ****************************/
                    $secureMap["mid"]		= $mid;							//mid
                    $secureMap["tstamp"]	= $timestamp;					//timestemp
                    $secureMap["MOID"]		= $resultMap["MOID"];			//MOID
                    $secureMap["TotPrice"]	= $resultMap["TotPrice"];		//TotPrice

                    // signature 데이터 생성
                    $secureSignature = $util->makeSignatureAuth($secureMap);
                    /*************************  결제보안 추가 2016-05-18 END ****************************/

										?>
										<div style="display:none;"><?=$secureSignature."/".$resultMap["authSignature"]?></div>
										<?

									if ( strcmp("0000", $resultMap["resultCode"]) == 0 ){	//결제보안 추가 2016-05-18
										 /*****************************************************************************
											 * 여기에 가맹점 내부 DB에 결제 결과를 반영하는 관련 프로그램 코드를 구현한다.

										 [중요!] 승인내용에 이상이 없음을 확인한 뒤 가맹점 DB에 해당건이 정상처리 되었음을 반영함
												처리중 에러 발생시 망취소를 한다.
											 ******************************************************************************/

										$TID = $resultMap["tid"];
										$ResultCode = $resultMap["resultCode"];
										$PayMethod = $resultMap["payMethod"];
										$ResultMsg = $resultMap["resultMsg"];
										$MOID = $resultMap["MOID"];
										$TotPrice = isset($resultMap['TotPrice']) ? $resultMap['TotPrice'] : "" ;
										$ApplNum = isset($resultMap["applNum"]) ? $resultMap["applNum"] : "" ;
										$CARD_Quota = isset($resultMap["CARD_Quota"]) ? $resultMap["CARD_Quota"] : "" ;
										$CARD_Interest = isset($resultMap["CARD_Interest"]) ? $resultMap["CARD_Interest"] : "" ;
										$CARD_Code = isset($resultMap["CARD_Code"]) ? $resultMap["CARD_Code"] : "" ;
										$ACCT_BankCode = isset($resultMap["ACCT_BankCode"]) ? $resultMap["ACCT_BankCode"] : "";
										$CSHR_ResultCode = isset($resultMap["CSHRResultCode"]) ? $resultMap["CSHRResultCode"] : "";
										$CSHR_Type = isset($resultMap["CSHR_Type"]) ? $resultMap["CSHR_Type"] : "";
										$VACT_Num = isset($resultMap["VACT_Num"]) ? $resultMap["VACT_Num"] : "" ;
										$VACT_BankCode = isset($resultMap["VACT_BankCode"]) ? $resultMap["VACT_BankCode"] : "" ;
										$VACT_Date = isset($resultMap["VACT_Date"]) ? $resultMap["VACT_Date"] : "" ;
										$VACT_InputName = isset($resultMap["VACT_InputName"]) ? $resultMap["VACT_InputName"] : "" ;
										$VACT_Name = isset($resultMap["VACT_Name"]) ? $resultMap["VACT_Name"] : "" ;
										$regDate = date("Y-m-d H:i:s");

										$insert_array = array(
											'TID'=>$TID,
											'ResultCode'=>$ResultCode,
											'ResultMsg'=>$ResultMsg,
											'PayMethod'=>$PayMethod,
											'MOID'=>$MOID,
											'TotPrice'=>$TotPrice,
											'ApplNum'=>$ApplNum,
											'CARD_Quota'=>$CARD_Quota,
											'CARD_Interest'=>$CARD_Interest,
											'CARD_Code'=>$CARD_Code,
											'ACCT_BankCode'=>$ACCT_BankCode,
											'CSHR_ResultCode'=>$CSHR_ResultCode,
											'CSHR_Type'=>$CSHR_Type,
											'VACT_Num'=>$VACT_Num,
											'VACT_BankCode'=>$VACT_BankCode,
											'VACT_Date'=>$VACT_Date,
											'VACT_InputName'=>$VACT_InputName,
											'VACT_Name'=>$VACT_Name,
											'regDate'=>$regDate
										);
										$result = $this->common_m->insert2("dh_inicis_pay",$insert_array);
										if($result){
											$table = "dh_trade";

											if($insert_array['PayMethod'] == "VBank"){
												$update_data['trade_stat'] = 1;
												$update_data['trade_day_ok'] = $regDate;
												$update_data['tno'] = $TID;
												$update_data['enter_name'] = $VACT_InputName;
												$update_data['enter_bank'] = inicis_bank_array($VACT_BankCode);
												$update_data['enter_account'] = $VACT_Num;
												$update_data['enter_info'] = $VACT_Name;
											}
											else{
												$update_data['trade_stat'] = 2;
												$update_data['trade_day_ok'] = $regDate;
												$update_data['tno'] = $TID;
											}

											$update_where['trade_code'] = $MOID;

											$result = $this->common_m->update2($table,$update_data,$update_where);
										}

										//$no_login="";

										//if(!$this->session->userdata('USERID')){
										//	$no_login="?nologin=1";
										//}
									?>
									<form name="order_form" id="order_form" method="post" action="<?=cdir()?>/dh_order/shop_order/<?=$this->uri->segment(3,'')?>/<?=$this->uri->segment(4,'')?>/">
									<input type="hidden" name="trade_code" value="<?=$resultMap["MOID"]?>">
									<input type="hidden" name="tno" value="<?=$resultMap["tid"]?>">
									<input type="hidden" name="cash_yn" value="<? if(isset($resultMap["CSHRResultCode"]) && $resultMap["CSHRResultCode"]){?>Y<?}else{?>N<?}?>">
									<input type="hidden" name="cash_tr_code" value="<? echo isset($resultMap["CSHR_Type"]) ? $resultMap["CSHR_Type"] : "";?>">
									<input type="hidden" name="cash_id_info" value="<? echo isset($resultMap["CSHRResultCode"]) ? $resultMap["CSHRResultCode"] : "";?>">
									<input type="hidden" name="ACCT_BankCode" value="<? echo isset($resultMap["ACCT_BankCode"]) ? $resultMap["ACCT_BankCode"] : "";?>">
									<input type="hidden" name="VACT_BankCode" value="<? echo isset($resultMap["VACT_BankCode"]) ? $resultMap["VACT_BankCode"] : "";?>">
									<input type="hidden" name="VACT_Num" value="<? echo isset($resultMap["VACT_Num"]) ? $resultMap["VACT_Num"] : "";?>">
									<input type="hidden" name="VACT_Name" value=""<? echo isset($resultMap["VACT_Name"]) ? $resultMap["VACT_Name"] : "";?>>

									<input type="hidden" name="ResultCode" value="0000">
									<input type="hidden" name="ResultMsg" value="<? echo isset($resultMap["resultMsg"]) ? $resultMap["resultMsg"] : "";?>">
									<input type="hidden" name="PayMethod" value="<? echo isset($resultMap["payMethod"]) ? $resultMap["payMethod"] : "";?>">
									<input type="hidden" name="ApplNum" value="<? echo isset($resultMap["applNum"]) ? $resultMap["applNum"] : "";?>">
									<input type="hidden" name="CARD_Quota" value="<? echo isset($resultMap["CARD_Quota"]) ? $resultMap["CARD_Quota"] : "";?>">
									<input type="hidden" name="CARD_Interest" value="<? echo isset($resultMap["CARD_Interest"]) ? $resultMap["CARD_Interest"] : "";?>">
									<input type="hidden" name="CARD_Code" value="<? echo isset($resultMap["CARD_Code"]) ? $resultMap["CARD_Code"] : "";?>">
									<input type="hidden" name="CSHR_ResultCode" value="<? echo isset($resultMap["CSHRResultCode"]) ? $resultMap["CSHRResultCode"] : "";?>">
									<input type="hidden" name="CSHR_Type" value="<? echo isset($resultMap["CSHR_Type"]) ? $resultMap["CSHR_Type"] : "";?>">
									<input type="hidden" name="VACT_Date" value="<? echo isset($resultMap["VACT_Date"]) ? $resultMap["VACT_Date"] : "";?>">
									<input type="hidden" name="VACT_InputName" value="<? echo isset($resultMap["VACT_InputName"]) ? $resultMap["VACT_InputName"] : "";?>">
									</form>
									<?
									script_exe("document.order_form.submit();");

									} else {
											echo "거래 성공 여부<br>";
											echo "실패<br>";
											echo "결과 코드 " . @(in_array($resultMap["resultCode"] , $resultMap) ? $resultMap["resultCode"] : "null" ) . "<br>";

											//결제보안키가 다른 경우.
											if (strcmp($secureSignature, $resultMap["authSignature"]) != 0) {
												echo "결과 내용 <p>" . "* 데이터 위변조 체크 실패" . "<br>";

												//망취소
												if(strcmp("0000", $resultMap["resultCode"]) == 0) {
													throw new Exception("데이터 위변조 체크 실패");
												}
											} else {
												echo "결과 내용 <p>" . @(in_array($resultMap["resultMsg"] , $resultMap) ? $resultMap["resultMsg"] : "null" ) . "<br>";
											}

                    }


									}catch (Exception $e) {
                    // $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
                    //####################################
                    // 실패시 처리(***가맹점 개발수정***)
                    //####################################
                    //---- db 저장 실패시 등 예외처리----//
                    $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
                    echo $s;

                    //#####################
                    // 망취소 API
                    //#####################

                    $netcancelResultString = ""; // 망취소 요청 API url(고정, 임의 세팅 금지)

                    if ($httpUtil->processHTTP($netCancel, $authMap)) {
                        $netcancelResultString = $httpUtil->body;
                    } else {
                        echo "Http Connect Error\n";
                        echo $httpUtil->errormsg;

                        throw new Exception("Http Connect Error");
                    }
									}



            } else {

                //#############
                // 인증 실패시
                //#############
                echo "<br/>";
                echo "####인증실패####";

                echo "<pre>" . var_dump($_REQUEST) . "</pre>";
            }

        } catch (Exception $e) {
            $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
            echo $s;
        }

			}
		}




	public function orderCnt($name)
	{
		$this->db->select("count(distinct g.trade_code) as cnt");
		$this->db->from("dh_trade t");
		$this->db->join('dh_trade_goods g', 't.trade_code = g.trade_code');
		$this->db->where("t.trade_stat = '".$name."'");

		return $this->db->get()->row();
	}




	public function admTradeList($type='',$offset='',$limit='',$excel='')
	{
		$this->db->select("t.idx,t.trade_code,t.delivery_idx,t.delivery_no,t.name,t.mobile,t.userid,t.trade_day,t.trade_method,t.tno,t.trade_stat,t.email,t.phone,t.send_name,t.send_phone,t.send_tel,t.zip1,t.addr1,t.addr2,t.send_text,t.price,t.total_price,t.use_point,g.goods_name,g.goods_cnt,g.goods_price,g.total_price as goods_total_price,g.option_cnt,g.idx as g_idx");
		$this->db->from("dh_trade t");

		$data['query_string'] = "?";
		$trade_stat = $this->uri->segment(3,1);
		$order = $this->input->get('order');
		$start_date = $this->input->get("start_date");
		$end_date = $this->input->get("end_date");
		$trade_info = $this->input->get("trade_info");
		$trade_method = $this->input->get("trade_method");
		$search_order = $this->input->get("search_order");
		$cate_no1 = $this->input->get('cate_no1');
		$cate_no2 = $this->input->get('cate_no2');
		$cate_no3 = $this->input->get('cate_no3');
		$cate_no4 = $this->input->get('cate_no4');
		$goods_name = $this->input->get('goods_name');


		if($cate_no1){ $data['query_string'].= "&cate_no1=".$cate_no1; }
		if($cate_no2){ $data['query_string'].= "&cate_no2=".$cate_no2; }
		if($cate_no3){ $data['query_string'].= "&cate_no3=".$cate_no3; }
		if($cate_no4){ $data['query_string'].= "&cate_no4=".$cate_no4; }

		$this->db->join('dh_trade_goods g', 't.trade_code = g.trade_code');
		//$this->db->where("t.trade_code = g.trade_code");

		if($trade_stat && $trade_stat!="all"){
			$this->db->where("t.trade_stat = '$trade_stat'");
		}

		for($i=4;$i>=1;$i--){
			if(${'cate_no'.$i}){
				$this->db->like('g.cate_no', ${'cate_no'.$i}, 'after');
				break;
			}
		}

		if($goods_name){
			$data['query_string'].= "&goods_name=".$goods_name;
			$this->db->like('g.goods_name', $goods_name);
		}

		if($start_date){
			$data['query_string'].= "&start_date=".$start_date;
			$this->db->where("t.trade_day >= '".$start_date." 00:00:00'");
		}

		if($end_date){
			$data['query_string'].= "&end_date=".$end_date;
			$this->db->where("t.trade_day <= '".$end_date." 23:59:59'");
		}

		if($trade_info && $search_order){
			$data['query_string'].= "&trade_info=".$trade_info;
			if($trade_info=="addr"){
				$this->db->like('t.addr1', $search_order);
				$this->db->or_like('t.addr2', $search_order);
			}else{
				$this->db->like('t.'.$trade_info, $search_order);
			}
		}

		if($trade_method){
			$this->db->where("t.trade_method = '$trade_method'");
		}


		switch($order){
			case 1 : $order_query = " t.idx asc "; break;
			case 2 : $order_query = " t.price desc "; break;
			case 3 : $order_query = " t.price asc "; break;
			default : $order_query = " t.idx desc "; break;
		}


		if($excel!="1"){
			$this->db->group_by("t.trade_code");
		}



		$this->db->order_by('t.idx', "desc");

		if($type=="count"){
			$data['totalCnt'] = $this->db->get()->num_rows();
		}else{
			if($excel!="1"){
				$this->db->limit($limit, $offset);
			}
			$data['list'] = $this->db->get()->result();
		}

		return $data;
	}

	public function E_admTradeList($type='',$offset='',$limit='',$excel='')
	{
		$this->db->select("t.idx,t.trade_code,t.delivery_idx,t.delivery_no,t.name,t.mobile,t.userid,t.trade_day,t.trade_method,t.tno,t.trade_stat,t.email,t.phone,t.send_name,t.send_phone,t.send_tel,t.zip1,t.addr1,t.addr2,t.send_text,t.price,t.total_price,t.use_point,g.goods_name,g.goods_cnt,g.goods_price,g.total_price as goods_total_price,g.option_cnt,g.idx as g_idx");
		$this->db->from("e_trade t");

		$data['query_string'] = "?";
		$trade_stat = $this->uri->segment(3,1);
		$order = $this->input->get('order');
		$start_date = $this->input->get("start_date");
		$end_date = $this->input->get("end_date");
		$trade_info = $this->input->get("trade_info");
		$trade_method = $this->input->get("trade_method");
		$search_order = $this->input->get("search_order");
		$cate_no1 = $this->input->get('cate_no1');
		$cate_no2 = $this->input->get('cate_no2');
		$cate_no3 = $this->input->get('cate_no3');
		$cate_no4 = $this->input->get('cate_no4');
		$goods_name = $this->input->get('goods_name');


		if($cate_no1){ $data['query_string'].= "&cate_no1=".$cate_no1; }
		if($cate_no2){ $data['query_string'].= "&cate_no2=".$cate_no2; }
		if($cate_no3){ $data['query_string'].= "&cate_no3=".$cate_no3; }
		if($cate_no4){ $data['query_string'].= "&cate_no4=".$cate_no4; }

		$this->db->join('e_trade_goods g', 't.trade_code = g.trade_code');
		//$this->db->where("t.trade_code = g.trade_code");

		if($trade_stat && $trade_stat!="all"){
			$this->db->where("t.trade_stat = '$trade_stat'");
		}

		for($i=4;$i>=1;$i--){
			if(${'cate_no'.$i}){
				$this->db->like('g.cate_no', ${'cate_no'.$i}, 'after');
				break;
			}
		}

		if($goods_name){
			$data['query_string'].= "&goods_name=".$goods_name;
			$this->db->like('g.goods_name', $goods_name);
		}

		if($start_date){
			$data['query_string'].= "&start_date=".$start_date;
			$this->db->where("t.trade_day >= '".$start_date." 00:00:00'");
		}

		if($end_date){
			$data['query_string'].= "&end_date=".$end_date;
			$this->db->where("t.trade_day <= '".$end_date." 23:59:59'");
		}

		if($trade_info && $search_order){
			$data['query_string'].= "&trade_info=".$trade_info;
			if($trade_info=="addr"){
				$this->db->like('t.addr1', $search_order);
				$this->db->or_like('t.addr2', $search_order);
			}else{
				$this->db->like('t.'.$trade_info, $search_order);
			}
		}

		if($trade_method){
			$this->db->where("t.trade_method = '$trade_method'");
		}


		switch($order){
			case 1 : $order_query = " t.idx asc "; break;
			case 2 : $order_query = " t.price desc "; break;
			case 3 : $order_query = " t.price asc "; break;
			default : $order_query = " t.idx desc "; break;
		}


		if($excel!="1"){
			$this->db->group_by("t.trade_code");
		}



		$this->db->order_by('t.idx', "desc");

		if($type=="count"){
			$data['totalCnt'] = $this->db->get()->num_rows();
		}else{
			if($excel!="1"){
				$this->db->limit($limit, $offset);
			}
			$data['list'] = $this->db->get()->result();
		}

		return $data;
	}

	public function vacctinput()
	{

		@extract($_GET);
		@extract($_POST);
		@extract($_SERVER);

		//**********************************************************************************
		//  이부분에 로그파일 경로를 수정해주세요.

		$INIpayHome = $_SERVER['DOCUMENT_ROOT'].'/pay/INIpay50';      // 이니페이 홈디렉터리
		//**********************************************************************************


		$TEMP_IP = getenv("HTTP_X_FORWARDED_FOR");
		//$PG_IP = substr($TEMP_IP, 0, 10);
		$PG_IP = array('203.238.37.3','203.238.37.15','203.238.37.16','203.238.37.25','39.115.212.9','183.109.71.153');
		$ym=date("Ym");

		if (in_array($TEMP_IP,$PG_IP)) {  //PG에서 보냈는지 IP로 체크
				$msg_id = $msg_id;             //메세지 타입
				$no_tid = $no_tid;             //거래번호
				$no_oid = $no_oid;             //상점 주문번호
				$id_merchant = $id_merchant;   //상점 아이디
				$cd_bank = $cd_bank;           //거래 발생 기관 코드
				$cd_deal = $cd_deal;           //취급 기관 코드
				$dt_trans = $dt_trans;         //거래 일자
				$tm_trans = $tm_trans;         //거래 시간
				$no_msgseq = $no_msgseq;       //전문 일련 번호
				$cd_joinorg = $cd_joinorg;     //제휴 기관 코드

				$dt_transbase = $dt_transbase; //거래 기준 일자
				$no_transeq = $no_transeq;     //거래 일련 번호
				$type_msg = $type_msg;         //거래 구분 코드
				$cl_close = $cl_close;         //마감 구분코드
				$cl_kor = $cl_kor;             //한글 구분 코드
				$no_msgmanage = $no_msgmanage; //전문 관리 번호
				$no_vacct = $no_vacct;         //가상계좌번호
				$amt_input = $amt_input;       //입금금액
				$amt_check = $amt_check;       //미결제 타점권 금액
				$nm_inputbank = $nm_inputbank; //입금 금융기관명
				$nm_input = $nm_input;         //입금 의뢰인
				$dt_inputstd = $dt_inputstd;   //입금 기준 일자
				$dt_calculstd = $dt_calculstd; //정산 기준 일자
				$flg_close = $flg_close;       //마감 전화
				//가상계좌채번시 현금영수증 자동발급신청시에만 전달
				$dt_cshr = $dt_cshr;       //현금영수증 발급일자
				$tm_cshr = $tm_cshr;       //현금영수증 발급시간
				$no_cshr_appl = $no_cshr_appl;  //현금영수증 발급번호
				$no_cshr_tid = $no_cshr_tid;   //현금영수증 발급TID

				$logfile = fopen($INIpayHome . "/log/result_".$ym.".log", "a+");

				fwrite($logfile, "************************************************ \r\n");
				fwrite($logfile, "ID_MERCHANT : " . $id_merchant . "\r\n");
				fwrite($logfile, "MSG_ID : " . $msg_id . "\r\n");
				fwrite($logfile, "NO_TID : " . $no_tid . "\r\n");
				fwrite($logfile, "NO_OID : " . $no_oid . "\r\n");
				fwrite($logfile, "NO_VACCT : " . $no_vacct . "\r\n");
				fwrite($logfile, "AMT_INPUT : " . $amt_input . "\r\n");
				fwrite($logfile, "NM_INPUTBANK : " . $nm_inputbank . "\r\n");
				fwrite($logfile, "NM_INPUT : " . $nm_input . "\r\n");
				fwrite($logfile, "************************************************");
				/*
				fwrite( $logfile,"전체 결과값"."\r\n");
				fwrite( $logfile, $msg_id."\r\n");
				fwrite( $logfile, $no_tid."\r\n");
				fwrite( $logfile, $no_oid."\r\n");
				fwrite( $logfile, $id_merchant."\r\n");
				fwrite( $logfile, $cd_bank."\r\n");
				fwrite( $logfile, $dt_trans."\r\n");
				fwrite( $logfile, $tm_trans."\r\n");
				fwrite( $logfile, $no_msgseq."\r\n");
				fwrite( $logfile, $type_msg."\r\n");
				fwrite( $logfile, $cl_close."\r\n");
				fwrite( $logfile, $cl_kor."\r\n");
				fwrite( $logfile, $no_msgmanage."\r\n");
				fwrite( $logfile, $no_vacct."\r\n");
				fwrite( $logfile, $amt_input."\r\n");
				fwrite( $logfile, $amt_check."\r\n");
				fwrite( $logfile, $nm_inputbank."\r\n");
				fwrite( $logfile, $nm_input."\r\n");
				fwrite( $logfile, $dt_inputstd."\r\n");
				fwrite( $logfile, $dt_calculstd."\r\n");
				fwrite( $logfile, $flg_close."\r\n");
				fwrite( $logfile, "\r\n");
				*/

				fclose($logfile);

				//입금통보 로그
				$log['trade_code'] = $no_oid;
				$log['bank_acc'] = $no_vacct;
				$log['wdate'] = timenow();
				$this->common_m->insert2("dh_inicis_vacct_log",$log);
				//입금통보 로그

				$trade_stat = $this->common_m->getRow("dh_trade","where trade_code='$no_oid'");
				$trade_goods = $this->common_m->getRow("dh_trade_goods","where trade_code='$no_oid'");

				if($trade_goods->cate_no == 'deposit'){
					$table = "dh_deposit";

					$ins['userid'] = $trade_stat->userid;
					$ins['point'] = $trade_stat->total_price;
					$ins['content'] = "예치금 충전";
					$ins['trade_code'] = $trade_stat->trade_code;
					$ins['reg_date'] = date('Ymdhis');

					$cnt = $this->common_m->self_q("select * from dh_deposit where trade_code = '".$trade_stat->trade_code."'","cnt");
					if(!$cnt){
						$this->common_m->insert2($table,$ins);
					}
				}

				if($trade_stat->trade_stat==1 && $trade_stat->trade_method==4){ //입금대기 && 가상계좌일경우
					$dbOk = $this->common_m->update2("dh_trade",array('trade_stat'=>2,'trade_day_ok'=>date("Y-m-d H:i:s")),array('idx'=>$trade_stat->idx)); //결제완료로 변경

					//알림톡 발송 입금완료 템플릿 5365
					//$tok_sendno = $trade_stat->phone;
					//$name = $trade_stat->name;
					//$add1 = number_format($trade_stat->total_price)."원";
					//$add2 = $trade_stat->trade_code;
					//$this->common_m->orange_kakao_send('5682',$name,$tok_sendno,$add1,$add2);
				}

		//************************************************************************************
				//위에서 상점 데이터베이스에 등록 성공유무에 따라서 성공시에는 "OK"를 이니시스로
				//리턴하셔야합니다. 아래 조건에 데이터베이스 성공시 받는 FLAG 변수를 넣으세요
				//(주의) OK를 리턴하지 않으시면 이니시스 지불 서버는 "OK"를 수신할때까지 계속 재전송을 시도합니다
				//기타 다른 형태의 PRINT( echo )는 하지 않으시기 바랍니다
		  if($dbOk){
				$result="OK";                        // 절대로 지우지마세요
		  }else{
				$result="FAIL : db input error";
			}
		//*************************************************************************************
		}else{
			$result="FAIL : connect ip error";
		}

		return $result;
	}


	public function kcp_result()
	{
    /* ============================================================================== */
    /* =   PAGE : 공통 통보 PAGE                                                    = */
    /* = -------------------------------------------------------------------------- = */
    /* =   연동시 오류가 발생하는 경우 아래의 주소로 접속하셔서 확인하시기 바랍니다.= */
    /* =   접속 주소 : http://kcp.co.kr/technique.requestcode.do			        = */
    /* = -------------------------------------------------------------------------- = */
    /* =   Copyright (c)  2013   KCP Inc.   All Rights Reserverd.                   = */
    /* ============================================================================== */

		if($_SERVER['REMOTE_ADDR']=="210.122.73.58" || $_SERVER['REMOTE_ADDR']=="203.238.36.173" || $_SERVER['REMOTE_ADDR']=="203.238.36.178"){
    /* ============================================================================== */
    /* =   01. 공통 통보 페이지 설명(필독!!)                                        = */
    /* = -------------------------------------------------------------------------- = */
    /* =   공통 통보 페이지에서는,                                                  = */
    /* =   가상계좌 입금 통보 데이터를 KCP를 통해 실시간으로 통보 받을 수 있습니다. = */
    /* =                                                                            = */
    /* =   common_return 페이지는 이러한 통보 데이터를 받기 위한 샘플 페이지        = */
    /* =   입니다. 현재의 페이지를 업체에 맞게 수정하신 후, 아래 사항을 참고하셔서  = */
    /* =   KCP 관리자 페이지에 등록해 주시기 바랍니다.                              = */
    /* =                                                                            = */
    /* =   등록 방법은 다음과 같습니다.                                             = */
    /* =  - KCP 관리자페이지(admin.kcp.co.kr)에 로그인 합니다.                      = */
    /* =  - [쇼핑몰 관리] -> [정보변경] -> [공통 URL 정보] -> [공통 URL 변경 후]에  = */
    /* =    결과값은 전송받을 가맹점 URL을 입력합니다.                              = */
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   02. 공통 통보 데이터 받기                                                = */
    /* = -------------------------------------------------------------------------- = */
    $site_cd      = $this->input->post("site_cd");                 // 사이트 코드
    $tno          = $this->input->post("tno");                 // KCP 거래번호
    $order_no     = $this->input->post("order_no");                 // 주문번호
    $tx_cd        = $this->input->post("tx_cd");                 // 업무처리 구분 코드
    $tx_tm        = $this->input->post("tx_tm");                 // 업무처리 완료 시간
    /* = -------------------------------------------------------------------------- = */
    $ipgm_name    = "";                                    // 주문자명
    $remitter     = "";                                    // 입금자명
    $ipgm_mnyx    = "";                                    // 입금 금액
    $bank_code    = "";                                    // 은행코드
    $account      = "";                                    // 가상계좌 입금계좌번호
    $op_cd        = "";                                    // 처리구분 코드
    $noti_id      = "";                                    // 통보 아이디
		$cash_a_no    = "";                                    // 현금영수증 승인번호
    /* = -------------------------------------------------------------------------- = */

    /* = -------------------------------------------------------------------------- = */
    /* =   02-1. 가상계좌 입금 통보 데이터 받기                                     = */
    /* = -------------------------------------------------------------------------- = */
    if ( $tx_cd == "TX00" )
    {
        $ipgm_name = $this->input->post("ipgm_name");                // 주문자명
        $remitter  = $this->input->post("remitter");                // 입금자명
        $ipgm_mnyx = $this->input->post("ipgm_mnyx");                // 입금 금액
        $bank_code = $this->input->post("bank_code");                // 은행코드
        $account   = $this->input->post("account");                // 가상계좌 입금계좌번호
        $op_cd     = $this->input->post("op_cd");                // 처리구분 코드
        $noti_id   = $this->input->post("noti_id");                // 통보 아이디
        $cash_a_no = $this->input->post("cash_a_no");                // 현금영수증 승인번호
    }


    /* ============================================================================== */
    /* =   03. 공통 통보 결과를 업체 자체적으로 DB 처리 작업하시는 부분입니다.      = */
    /* = -------------------------------------------------------------------------- = */
    /* =   통보 결과를 DB 작업 하는 과정에서 정상적으로 통보된 건에 대해 DB 작업에  = */
    /* =   실패하여 DB update 가 완료되지 않은 경우, 결과를 재통보 받을 수 있는     = */
    /* =   프로세스가 구성되어 있습니다.                                            = */
    /* =                                                                            = */
    /* =   * DB update가 정상적으로 완료된 경우                                     = */
    /* =   하단의 [04. result 값 세팅 하기] 에서 result 값의 value값을 0000으로     = */
    /* =   설정해 주시기 바랍니다.                                                  = */
    /* =                                                                            = */
    /* =   * DB update가 실패한 경우                                                = */
    /* =   하단의 [04. result 값 세팅 하기] 에서 result 값의 value값을 0000이외의   = */
    /* =   값으로 설정해 주시기 바랍니다.                                           = */
    /* = -------------------------------------------------------------------------- = */

    /* = -------------------------------------------------------------------------- = */
    /* =   03-1. 가상계좌 입금 통보 데이터 DB 처리 작업 부분                        = */
    /* = -------------------------------------------------------------------------- = */
    if ( $tx_cd == "TX00" )
    {
				$trade_stat = $this->common_m->getRow("dh_trade","where trade_code='$order_no'");

				if(isset($trade_stat->idx) && $trade_stat->trade_stat==1 && $trade_stat->trade_method==4){ //입금대기 && 가상계좌일경우
					$result = $this->common_m->update2("dh_trade",array('trade_stat'=>2,'trade_day_ok'=>date("Y-m-d H:i:s")),array('idx'=>$trade_stat->idx)); //결제완료로 변경

					if($result){ $result = "0000"; }else{ $result = "1111"; }

				}else{
					$result="0001";
				}

    }else{
			$result=$tx_cd;
		}
    /* ============================================================================== */


    /* ============================================================================== */
    /* =   04. result 값 세팅 하기                                                  = */
    /* ============================================================================== */
		}else{
			$result="1100";
		}

		return $result;
	}

	public function cart_deliv_calc($db_dv_date_arr,$exp_free,$exp_money){
		$cart_idx_arr = $this->input->post('cart_idx');
		foreach($cart_idx_arr as $key=>$cart_idx){
			if($this->input->post('chk'.$key)){
				$db_where_cart_idx .= $cart_idx.",";
			}
		}

		$db_where_cart_idx = substr($db_where_cart_idx,0,-1);

		$where_sql = "where userid = '".$this->session->userdata('USERID')."' and trade_ok = '0'";
		if(strlen($db_where_cart_idx) > 0){
			if(count($cart_idx_arr) > 1){
				$where_sql .= " and idx in ({$db_where_cart_idx})";
			}
			else{
				$where_sql .= " and idx = '{$db_where_cart_idx}'";
			}
		}

		$sql = "select userid, date_bind , sum(total_price) as group_sum_price, sum(recom_idx) as recom_is from dh_cart {$where_sql} group by date_bind";
		$q = $this->db->query($sql);
		$list = $q->result();

		$deliv_price = 0;

		//날짜에 따른 배송비 및 날짜별 합계금액 동시 처리
		foreach($list as $lt){
			if($lt->group_sum_price >= $exp_free || in_array($lt->date_bind,$db_dv_date_arr) or $lt->recom_is > 0){	//0원 조건
				$usql = "update dh_cart set deliv_price = '0' where trade_ok <> 1 and userid = '".$lt->userid."' and date_bind = '".$lt->date_bind."'";
				$this->db->query($usql);
			}
			else{
				$deliv_price += $exp_money;
				$usql = "update dh_cart set deliv_price = '{$exp_money}' where trade_ok <> 1 and userid = '".$lt->userid."' and date_bind = '".$lt->date_bind."'";
				$this->db->query($usql);
			}
		}

		return $deliv_price;
	}

	public function Epost_deliv_Api($deliv_code, $reqType=1){	//송장번호 자동업데이트

		$epost_sql = "select distinct d.order_name, m.zip1, m.add1, m.add2, m.phone1, m.phone2, m.phone3, m.tel1, m.tel2, m.tel3,
										d.recv_name, d.recv_phone, d.zipcode, d.addr1, d.addr2,
										d.prod_name, d.trade_code, t.send_text, if(sum(p.prod_cnt) <= 0 , sum(p.option_cnt), sum(p.prod_cnt)) as qty
									from dh_trade_deliv_info d
										left join dh_trade_deliv_prod p on d.deliv_code = p.deliv_code
										left join dh_member m on d.userid = m.userid
										left join dh_trade t on d.trade_code = t.trade_code
									where d.deliv_code = '{$deliv_code}'";

		$epost = $this->db->query($epost_sql);
		$epost_result = $epost->row();

		$shop_info_sql = "select * from dh_shop_info where name = 'shop_name'";
		$shop_info = $this->db->query($shop_info_sql);
		$shop_info_result = $shop_info->row();

		// 우체국 고객번호
		$custNo = '0004537587';
		// 우체국 승인번호
		$apprNo = '6033780145';
		// 우체국 인증키
		$skey = '2d157546d8f127fd61475641853917';
		$ssubkey = '841581b2a1d627f8114302';
		// 공급지코드
		$officeSer = '160809109';
		// 요금납부구분
		$payType = '1';
		// 초소형택배구분
		$microYn = 'N';
		// 주요내용품코드
		$contCd = '018';

		// 무게
		$weight = 5;
		// 부피
		$volume = '';

		// 접수(픽업요청)
		$url = 'http://ship.epost.go.kr/api.InsertOrder.jparcel';

		$prd_name_arr = explode(",",$epost_result->prod_name);
		if(count($prd_name_arr) > 1) $goods_name = $prd_name_arr[0]."외 ".(count($prd_name_arr)-1)."건";
		else $goods_name = $prd_name_arr[0];

		$data = array();

		$data['custNo'] = $custNo;
		$data['reqType'] = $reqType;
		$data['officeSer'] = $officeSer;
		$data['weight'] = $weight;
		$data['volume'] = $volume;
		$data['ordCompNm'] = $shop_info_result->val;

		$data['ordNm'] = $epost_result->order_name;
		//$data['ordZip'] = $epost_result->zip1;

		//주소가 길어서 안되는 오류가 있음
		$ordaddr1_arr = explode("(",$epost_result->add1);
		//$data['ordAddr1'] = $ordaddr1_arr[0];

		//$data['ordAddr2'] = $epost_result->add2;
		//$data['ordTel'] = $epost_result->phone1.$epost_result->phone2.$epost_result->phone3;
		//$data['ordMob'] = $epost_result->phone1.$epost_result->phone2.$epost_result->phone3;

		$data['recNm'] = $epost_result->recv_name;
		$data['recZip'] = $epost_result->zipcode;

		//주소가 길어서 안되는 오류가 있음
		$recaddr1_arr = explode("(",$epost_result->addr1);
		$data['recAddr1'] = $recaddr1_arr[0];

		$data['recAddr2'] = $epost_result->addr2 ? $epost_result->addr2 : ' _ '; // 상세주소가 없을 경우 오류처리가 됨.
		$data['recMob'] = str_replace('-', '', $epost_result->recv_phone);
		$data['recTel'] = $data['recMob'];

		$data['apprNo'] = $apprNo;
		$data['payType'] = $payType;
		$data['microYn'] = $microYn;
		$data['contCd'] = $contCd;

		$data['goodsNm'] = $goods_name;
		$data['qty'] = $epost_result->qty;
		$data['orderNo'] = $epost_result->trade_code;
		$data['delivMsg'] = $epost_result->send_text;

		//테스트설정
		//$data['testYn'] = "Y";


		$reqData = '';
		foreach ($data as $k => $v) $reqData .= $k . '='.$v.'&';
		$req_data = rtrim($reqData, '&');

		$params = array();
		$params['key'] = $skey;

		$this->load->library('Seed128');
		$params['regData'] = $this->seed128->getEncryptData($ssubkey, $req_data);

		$postData = '';
		foreach ($params as $k => $v) $postData .= $k . '='.$v.'&';
		$postData = rtrim($postData, '&');

		$ch = curl_init();
		curl_setopt($ch,CURLOPT_URL, $url);
		curl_setopt($ch,CURLOPT_RETURNTRANSFER, true);
		curl_setopt($ch,CURLOPT_HEADER, false);
		curl_setopt($ch, CURLOPT_POST, count($postData));
		curl_setopt($ch, CURLOPT_POSTFIELDS, $postData);

		$api_result = curl_exec($ch);
		curl_close($ch);

		$xml = simplexml_load_string($api_result);
		$result = array();

		$result['error_code'] = (string)$xml->error->error_code;
		$result['error_message'] = (string)$xml->error->message;

		// 우체국택배신청번호
		$result['req_no'] = '';
		// 예약번호
		$result['res_no'] = '';
		// 운송장번호
		$result['regi_no'] = '';
		// 예약일시
		$result['res_date'] = '';
		// 접수우체국
		$result['regi_ponm'] = '';
		// 가상전화 번호
		$result['v_telno'] = '';
		// 도착집중국명
		$result['arr_cnponm'] = '';
		// 배달우체국명
		$result['deliv_ponm'] = '';
		// 배달구구분코드
		$result['deliv_areacd'] = '';


		if (!$error_code) {
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
		}

		return $result;


	}

	public function uplus_pay_Gethash($post){

			require_once $_SERVER['DOCUMENT_ROOT']."/pay/uplus/lgdacom/XPayClient.php";
			$xpay = new XPayClient($post['configPath'], $post['CST_PLATFORM']);
			$xpay->Init_TX($post['LGD_MID']);
			$LGD_HASHDATA = md5($post['LGD_MID'].$post['LGD_OID'].$post['LGD_AMOUNT'].$post['LGD_TIMESTAMP'].$xpay->config[$post['LGD_MID']]);
			return $LGD_HASHDATA;

	}

	public function uplus_pay($post){

		$sql = $this->db->query("select * from dh_uplus_pay where trade_code = '".$post['LGD_OID']."'");
		$res = $sql->row();
		$payReqMap = unserialize($res->pay_tmp);

		if($payReqMap['LGD_OID'] == $post['LGD_OID']){
		?>
		<script type="text/javascript">

			function setLGDResult() {
				parent.payment_return();
				try {
				} catch (e) {
					alert(e.message);
				}
			}

		</script>
		<?php
			$LGD_RESPCODE = $post['LGD_RESPCODE'];
			$LGD_RESPMSG 	= $post['LGD_RESPMSG'];
			$LGD_PAYKEY	  = "";

			$payReqMap['LGD_RESPCODE'] = $LGD_RESPCODE;
			$payReqMap['LGD_RESPMSG']	=	$LGD_RESPMSG;

			if($LGD_RESPCODE == "0000"){
				$LGD_PAYKEY = $post['LGD_PAYKEY'];
				$payReqMap['LGD_PAYKEY'] = $LGD_PAYKEY;
			}
			else{
				echo "LGD_RESPCODE:" + $LGD_RESPCODE + " ,LGD_RESPMSG:" + $LGD_RESPMSG; //인증 실패에 대한 처리 로직 추가
			}
		?>
		<form method="post" name="LGD_RETURNINFO" id="LGD_RETURNINFO">
		<?php
				foreach ($payReqMap as $key => $value) {
					echo "<input type='hidden' name='$key' id='$key' value='$value'>";
				}
		?>
		</form>
		<script type="text/javascript">
			setLGDResult();
		</script>
		<?php
		}

		else{
			echo "거래번호 틀림";
			return;
		}

	}

	public function uplus_bank($post){
		/*
		* [상점 결제결과처리(DB) 페이지]
		*
		* 1) 위변조 방지를 위한 hashdata값 검증은 반드시 적용하셔야 합니다.
		*
		*/
		$LGD_RESPCODE            = $_POST["LGD_RESPCODE"];				// 응답코드: 0000(성공) 그외 실패
		$LGD_RESPMSG             = $_POST["LGD_RESPMSG"];				// 응답메세지
		$LGD_MID                 = $_POST["LGD_MID"];					// 상점아이디
		$LGD_OID                 = $_POST["LGD_OID"];					// 주문번호
		$LGD_AMOUNT              = $_POST["LGD_AMOUNT"];				// 거래금액
		$LGD_TID                 = $_POST["LGD_TID"];					// LG유플러스에서 부여한 거래번호
		$LGD_PAYTYPE             = $_POST["LGD_PAYTYPE"];				// 결제수단코드
		$LGD_PAYDATE             = $_POST["LGD_PAYDATE"];				// 거래일시(승인일시/이체일시)
		$LGD_HASHDATA            = $_POST["LGD_HASHDATA"];				// 해쉬값
		$LGD_FINANCECODE         = $_POST["LGD_FINANCECODE"];			// 결제기관코드(은행코드)
		$LGD_FINANCENAME         = $_POST["LGD_FINANCENAME"];			// 결제기관이름(은행이름)
		$LGD_ESCROWYN            = $_POST["LGD_ESCROWYN"];				// 에스크로 적용여부
		$LGD_TIMESTAMP           = $_POST["LGD_TIMESTAMP"];				// 타임스탬프
		$LGD_ACCOUNTNUM          = $_POST["LGD_ACCOUNTNUM"];			// 계좌번호(무통장입금)
		$LGD_CASTAMOUNT          = $_POST["LGD_CASTAMOUNT"];			// 입금총액(무통장입금)
		$LGD_CASCAMOUNT          = $_POST["LGD_CASCAMOUNT"];			// 현입금액(무통장입금)
		$LGD_CASFLAG             = $_POST["LGD_CASFLAG"];				// 무통장입금 플래그(무통장입금) - 'R':계좌할당, 'I':입금, 'C':입금취소
		$LGD_CASSEQNO            = $_POST["LGD_CASSEQNO"];				// 입금순서(무통장입금)
		$LGD_CASHRECEIPTNUM      = $_POST["LGD_CASHRECEIPTNUM"];		// 현금영수증 승인번호
		$LGD_CASHRECEIPTSELFYN   = $_POST["LGD_CASHRECEIPTSELFYN"];		// 현금영수증자진발급제유무 Y: 자진발급제 적용, 그외 : 미적용
		$LGD_CASHRECEIPTKIND     = $_POST["LGD_CASHRECEIPTKIND"];		// 현금영수증 종류 0: 소득공제용 , 1: 지출증빙용
		$LGD_PAYER     			 = $_POST["LGD_PAYER"];      			// 입금자명

		/*
		* 구매정보
		*/
		$LGD_BUYER               = $_POST["LGD_BUYER"];					// 구매자
		$LGD_PRODUCTINFO         = $_POST["LGD_PRODUCTINFO"];			// 상품명
		$LGD_BUYERID             = $_POST["LGD_BUYERID"];				// 구매자 ID
		$LGD_BUYERADDRESS        = $_POST["LGD_BUYERADDRESS"];			// 구매자 주소
		$LGD_BUYERPHONE          = $_POST["LGD_BUYERPHONE"];			// 구매자 전화번호
		$LGD_BUYEREMAIL          = $_POST["LGD_BUYEREMAIL"];			// 구매자 이메일
		$LGD_BUYERSSN            = $_POST["LGD_BUYERSSN"];				// 구매자 주민번호
		$LGD_PRODUCTCODE         = $_POST["LGD_PRODUCTCODE"];			// 상품코드
		$LGD_RECEIVER            = $_POST["LGD_RECEIVER"];				// 수취인
		$LGD_RECEIVERPHONE       = $_POST["LGD_RECEIVERPHONE"];			// 수취인 전화번호
		$LGD_DELIVERYINFO        = $_POST["LGD_DELIVERYINFO"];			// 배송지

		$LGD_MERTKEY = "95160cce09854ef44d2edb2bfb05f9f3";				//LG유플러스에서 발급한 상점키로 변경해 주시기 바랍니다.

		$LGD_HASHDATA2 = md5($LGD_MID.$LGD_OID.$LGD_AMOUNT.$LGD_RESPCODE.$LGD_TIMESTAMP.$LGD_MERTKEY);

		/*
		* 상점 처리결과 리턴메세지
		*
		* OK  : 상점 처리결과 성공
		* 그외 : 상점 처리결과 실패
		*
		* ※ 주의사항 : 성공시 'OK' 문자이외의 다른문자열이 포함되면 실패처리 되오니 주의하시기 바랍니다.
		*/
		$resultMSG = "결제결과 상점 DB처리(LGD_CASNOTEURL) 결과값을 입력해 주시기 바랍니다.";


		if ( $LGD_HASHDATA2 == $LGD_HASHDATA ) { //해쉬값 검증이 성공이면
			if ( "0000" == $LGD_RESPCODE ){ //결제가 성공이면
				if( "R" == $LGD_CASFLAG ) {
					/*
					* 무통장 할당 성공 결과 상점 처리(DB) 부분
					* 상점 결과 처리가 정상이면 "OK"
					*/
					//if( 무통장 할당 성공 상점처리결과 성공 )
					$resultMSG = "OK";
				}else if( "I" == $LGD_CASFLAG ) {
					/*
					* 무통장 입금 성공 결과 상점 처리(DB) 부분
					* 상점 결과 처리가 정상이면 "OK"
					*/
						//if( 무통장 입금 성공 상점처리결과 성공 )
					$resultMSG = "OK";
				}else if( "C" == $LGD_CASFLAG ) {
					/*
					* 무통장 입금취소 성공 결과 상점 처리(DB) 부분
					* 상점 결과 처리가 정상이면 "OK"
					*/
						//if( 무통장 입금취소 성공 상점처리결과 성공 )
					$resultMSG = "OK";
				}
			} else { //결제가 실패이면
				/*
				* 거래실패 결과 상점 처리(DB) 부분
				* 상점결과 처리가 정상이면 "OK"
				*/
					//if( 결제실패 상점처리결과 성공 )
				$resultMSG = "OK";
			}
		} else { //해쉬값이 검증이 실패이면
			/*
			* hashdata검증 실패 로그를 처리하시기 바랍니다.
			*/
				$resultMSG = "결제결과 상점 DB처리(LGD_CASNOTEURL) 해쉬값 검증이 실패하였습니다.";
		}

		echo $resultMSG;
	}

	public function uplus_pay_ok($post){

		$configPath = $_SERVER['DOCUMENT_ROOT']."/pay/uplus/lgdacom";
		$CST_PLATFORM               = $post["CST_PLATFORM"];
		$CST_MID                    = $post["CST_MID"];
		$LGD_MID                    = (("test" == $CST_PLATFORM)?"t":"").$CST_MID;
		$LGD_PAYKEY                 = $post["LGD_PAYKEY"];

		require_once $_SERVER['DOCUMENT_ROOT']."/pay/uplus/lgdacom/XPayClient.php";

		$xpay = new XPayClient($configPath, $CST_PLATFORM);
		if (!$xpay->Init_TX($LGD_MID)) {
			echo "TX Response_code = " . $xpay->Response_Code() . "<br/>";
			echo "TX Response_msg = " . $xpay->Response_Msg() . "<br/>";
			echo "결제요청을 초기화 하는데 실패하였습니다.<br/>";
			echo "LG유플러스에서 제공한 환경파일이 정상적으로 설치 되었는지 확인하시기 바랍니다.<br/>";
			echo "mall.conf에는 Mert Id = Mert Key 가 반드시 등록되어 있어야 합니다.<br/><br/>";
			echo "문의전화 LG유플러스 1544-7772<br/>";
			exit;
		}
		$xpay->Set("LGD_TXNAME", "PaymentByKey");
		$xpay->Set("LGD_PAYKEY", $LGD_PAYKEY);

		if($xpay->TX()){
			//			echo "결제요청이 완료되었습니다.  <br/>";
			//			echo "TX 통신 응답코드 = " . $xpay->Response_Code() . "<br/>";		//통신 응답코드("0000" 일 때 통신 성공)
			//			echo "TX 통신 응답메시지 = " . $xpay->Response_Msg() . "<p>";
			//
			//			echo "거래번호 : " . $xpay->Response("LGD_TID",0) . "<br/>";
			//			echo "상점아이디 : " . $xpay->Response("LGD_MID",0) . "<br/>";
			//			echo "상점주문번호 : " . $xpay->Response("LGD_OID",0) . "<br/>";
			//			echo "결제금액 : " . $xpay->Response("LGD_AMOUNT",0) . "<br/>";
			//			echo "결과코드 : " . $xpay->Response("LGD_RESPCODE",0) . "<br/>";	//LGD_RESPCODE 가 반드시 "0000" 일때만 결제 성공, 그 외는 모두 실패
			//			echo "결과메세지 : " . $xpay->Response("LGD_RESPMSG",0) . "<p>";

			$keys = $xpay->Response_Names();

			$succ_arr = array();

			foreach($keys as $name) {
					//echo $name . " = " . $xpay->Response($name, 0) . "<br/>";
				$succ_arr[$name] = $xpay->Response($name, 0);
			}

			//echo "<p>";

			if( "0000" == $xpay->Response_Code() ) {

				//echo "최종결제요청 결과 성공 DB처리하시기 바랍니다.<br/>";
				$result = $this->common_m->self_q("update dh_uplus_pay set result_arr = '".serialize($succ_arr)."' where trade_code = '".$xpay->Response("LGD_OID",0)."'","update");
				if($result){
					$isDBOK = true;
				}

				if( !$isDBOK ) {
					//echo "<p>";
					$xpay->Rollback("상점 DB처리 실패로 인하여 Rollback 처리 [TID:" . $xpay->Response("LGD_TID",0) . ",MID:" . $xpay->Response("LGD_MID",0) . ",OID:" . $xpay->Response("LGD_OID",0) . "]");

						echo "TX Rollback Response_code = " . $xpay->Response_Code() . "<br/>";
						echo "TX Rollback Response_msg = " . $xpay->Response_Msg() . "<p>";

						if( "0000" == $xpay->Response_Code() ) {
							echo "자동취소가 정상적으로 완료 되었습니다.<br/>";
						}else{
							echo "자동취소가 정상적으로 처리되지 않았습니다.<br/>";
						}
				}

				else{
					$action_url = cdir();
					$action_url .= "/dh_order/shop_order";
					$action_url .= $post['seg3'] ? "/".$post['seg3'] : "" ;
					$action_url .= $post['seg4'] ? "/".$post['seg4'] : "" ;
					?>
					<form action="<?=$action_url?>" method="post" name="pay_comp" id="pay_comp">
						<!-- <input type="hidden" name="" value=""> -->
						<?php
						foreach($succ_arr as $k=>$v){
						?>
						<input type="hidden" name="<?=$k?>" value="<?=$v?>">
						<?php
						}
						?>
					</form>
					<?php
					script_exe("document.pay_comp.submit();");
				}

			}

			else{
					//통신상의 문제 발생(최종결제요청 결과 실패 DB처리)
				//echo "최종결제요청 결과 실패 DB처리하시기 바랍니다.<br/>";
				alert("/","통신상의 문제로 인하여 결제요청이 실패하였습니다.");
			}

		}

		else{
			//2)API 요청실패 화면처리
			alert("/","API 요청실패로 인하여 결제요청이 실패하였습니다.");
			//			echo "결제요청이 실패하였습니다.  <br/>";
			//			echo "TX Response_code = " . $xpay->Response_Code() . "<br/>";
			//			echo "TX Response_msg = " . $xpay->Response_Msg() . "<p>";
			//
			//			//최종결제요청 결과 실패 DB처리
			//			echo "최종결제요청 결과 실패 DB처리하시기 바랍니다.<br/>";
		}

	}

	public function grade_change_pay_ok($post){

		$configPath = $_SERVER['DOCUMENT_ROOT']."/pay/uplus/lgdacom";
		$CST_PLATFORM               = $post["CST_PLATFORM"];
		$CST_MID                    = $post["CST_MID"];
		$LGD_MID                    = (("test" == $CST_PLATFORM)?"t":"").$CST_MID;
		$LGD_PAYKEY                 = $post["LGD_PAYKEY"];

		require_once $_SERVER['DOCUMENT_ROOT']."/pay/uplus/lgdacom/XPayClient.php";

		$xpay = new XPayClient($configPath, $CST_PLATFORM);
		if (!$xpay->Init_TX($LGD_MID)) {
			echo "TX Response_code = " . $xpay->Response_Code() . "<br/>";
			echo "TX Response_msg = " . $xpay->Response_Msg() . "<br/>";
			echo "결제요청을 초기화 하는데 실패하였습니다.<br/>";
			echo "LG유플러스에서 제공한 환경파일이 정상적으로 설치 되었는지 확인하시기 바랍니다.<br/>";
			echo "mall.conf에는 Mert Id = Mert Key 가 반드시 등록되어 있어야 합니다.<br/><br/>";
			echo "문의전화 LG유플러스 1544-7772<br/>";
			exit;
		}
		$xpay->Set("LGD_TXNAME", "PaymentByKey");
		$xpay->Set("LGD_PAYKEY", $LGD_PAYKEY);

		if($xpay->TX()){
			//			echo "결제요청이 완료되었습니다.  <br/>";
			//			echo "TX 통신 응답코드 = " . $xpay->Response_Code() . "<br/>";		//통신 응답코드("0000" 일 때 통신 성공)
			//			echo "TX 통신 응답메시지 = " . $xpay->Response_Msg() . "<p>";
			//
			//			echo "거래번호 : " . $xpay->Response("LGD_TID",0) . "<br/>";
			//			echo "상점아이디 : " . $xpay->Response("LGD_MID",0) . "<br/>";
			//			echo "상점주문번호 : " . $xpay->Response("LGD_OID",0) . "<br/>";
			//			echo "결제금액 : " . $xpay->Response("LGD_AMOUNT",0) . "<br/>";
			//			echo "결과코드 : " . $xpay->Response("LGD_RESPCODE",0) . "<br/>";	//LGD_RESPCODE 가 반드시 "0000" 일때만 결제 성공, 그 외는 모두 실패
			//			echo "결과메세지 : " . $xpay->Response("LGD_RESPMSG",0) . "<p>";

			$keys = $xpay->Response_Names();

			$succ_arr = array();

			foreach($keys as $name) {
					//echo $name . " = " . $xpay->Response($name, 0) . "<br/>";
				$succ_arr[$name] = $xpay->Response($name, 0);
			}

			//echo "<p>";

			if( "0000" == $xpay->Response_Code() ) {

				//echo "최종결제요청 결과 성공 DB처리하시기 바랍니다.<br/>";
				$result = $this->common_m->self_q("update dh_uplus_pay set result_arr = '".serialize($succ_arr)."' where trade_code = '".$xpay->Response("LGD_OID",0)."'","update");
				if($result){
					$isDBOK = true;
				}

				if( !$isDBOK ) {
					//echo "<p>";
					$xpay->Rollback("상점 DB처리 실패로 인하여 Rollback 처리 [TID:" . $xpay->Response("LGD_TID",0) . ",MID:" . $xpay->Response("LGD_MID",0) . ",OID:" . $xpay->Response("LGD_OID",0) . "]");

						echo "TX Rollback Response_code = " . $xpay->Response_Code() . "<br/>";
						echo "TX Rollback Response_msg = " . $xpay->Response_Msg() . "<p>";

						if( "0000" == $xpay->Response_Code() ) {
							echo "자동취소가 정상적으로 완료 되었습니다.<br/>";
						}else{
							echo "자동취소가 정상적으로 처리되지 않았습니다.<br/>";
						}
				}

				else{
					?>
					<form action="<?=cdir()?>/dh_order/shop_order/" method="post" name="pay_comp" id="pay_comp">
						<!-- <input type="hidden" name="" value=""> -->
						<?php
						foreach($succ_arr as $k=>$v){
						?>
						<input type="hidden" name="<?=$k?>" value="<?=$v?>">
						<?php
						}
						?>
					</form>
					<?php
					script_exe("parent.document.grade_frm.submit();");
				}

			}

			else{
				//통신상의 문제 발생(최종결제요청 결과 실패 DB처리)
				echo "통신상의 문제로 인하여 결제요청이 실패하였습니다.";
				echo "<button onclick='self.close()'>돌아가기</button>";
				//alert("/","통신상의 문제로 인하여 결제요청이 실패하였습니다.");
			}

		}

		else{
			//2)API 요청실패 화면처리
			//alert("/","API 요청실패로 인하여 결제요청이 실패하였습니다.");
						echo "결제요청이 실패하였습니다.  <br/>";
						echo "TX Response_code = " . $xpay->Response_Code() . "<br/>";
						echo "TX Response_msg = " . $xpay->Response_Msg() . "<p>";
						echo "<button onclick='self.close()'>돌아가기</button>";
			//
			//			//최종결제요청 결과 실패 DB처리
			//			echo "최종결제요청 결과 실패 DB처리하시기 바랍니다.<br/>";
		}

	}

	function get_order_settle_sum($date){
		$case = array('1'=>"신용카드",'2'=>"무통장입금",'3'=>"계좌이체",'5'=>"포인트",'7'=>'휴대폰결제');
		$info = array();

		foreach($case as $k=>$v){
			$sql = "
				select sum(total_price) as price, sum(use_point) as use_point, sum(use_coupon) as use_coupon, count(trade_code) as cnt
				from dh_trade
				where DATE_FORMAT(trade_day_ok,'%Y-%m-%d') = '{$date}' and trade_method = '{$k}' and trade_stat between 1 and 3
			";
			// and trade_stat between '1' and '3'
			$result = $this->db->query($sql);
			$row = $result->row_array();

			$info[$k]['price'] = (int)$row['price'];
			$info[$k]['use_point'] = (int)$row['use_point'];
			$info[$k]['use_coupon'] = (int)$row['use_coupon'];
			$info[$k]['cnt'] = (int)$row['cnt'];
		}

		return $info;
	}

	function get_order_settle_cc_sum($date){
		$info = array();

		$sql = "
			select sum(total_price) as price, sum(use_point) as use_point, sum(use_coupon) as use_coupon, count(trade_code) as cnt
			from dh_trade
			where DATE_FORMAT(trade_day,'%Y-%m-%d') = '{$date}' and trade_stat between '9' and '10'
		";
		$result = $this->db->query($sql);
		$row = $result->row_array();

		$info['price'] = (int)$row['price'];
		$info['use_point'] = (int)$row['use_point'];
		$info['use_coupon'] = (int)$row['use_coupon'];
		$info['cnt'] = (int)$row['cnt'];

		return $info;
	}

	public function sales($sql){
		$q=$this->db->query($sql);
		$result=$q->result();
		return $result;
	}

	public function coupon_order(){
		mt_srand((double)microtime()*1000000);
		$TRADE_CODE=chr(mt_rand(65, 90));
		$TRADE_CODE.=chr(mt_rand(65, 90));
		$TRADE_CODE.=chr(mt_rand(65, 90));
		$TRADE_CODE.=chr(mt_rand(65, 90));
		$TRADE_CODE.=chr(mt_rand(65, 90));
		$TRADE_CODE.=time();

		//가격표 배열
			//			$price_arr = array(
			//				'4'=>array(
			//					'2'=>'76000',
			//					'4'=>'141000'
			//				),
			//				'5'=>array(
			//					'2'=>'85000',
			//					'4'=>'159000'
			//				),
			//				'1'=>array(
			//					'2'=>'131000',
			//					'4'=>'245000'
			//				),
			//				'7'=>array(
			//					'2'=>'131000',
			//					'4'=>'245000'
			//				),
			//				'3'=>array(
			//					'2'=>'140000',
			//					'4'=>'280000'
			//				),
			//			);

			$price_arr = array(
				'4'=>array(
					'2'=>'78000',
					'4'=>'153000'
				),
				'5'=>array(
					'2'=>'90000',
					'4'=>'172000'
				),
				'1'=>array(
					'2'=>'141000',
					'4'=>'269000'
				),
				'7'=>array(
					'2'=>'144000',
					'4'=>'275000'
				),
				'3'=>array(
					'2'=>'155000',
					'4'=>'296000'
				),
			);
		//가격표 배열

		//회원 정보 산출하여 주문자 정보 및 수령자 정보 채워야됨
		$member_info = $this->common_m->self_q("select * from dh_member where userid = '".$this->session->userdata('USERID')."' and outmode != 1","row");

		//주소설정
		if($this->input->post('recom_deliv_addr') == 'home'){
			$name = $member_info->name;
			$phone = $member_info->phone1."-".$member_info->phone2."-".$member_info->phone3;
			$email = $member_info->email;

			$send_name = $member_info->name;
			$send_phone = $member_info->phone1."-".$member_info->phone2."-".$member_info->phone3;

			$zip1 = $member_info->zip1;
			$addr1 = $member_info->add1;
			$addr2 = $member_info->add2;
		}
		else{
			$name = $member_info->name;
			$phone = $member_info->phone1."-".$member_info->phone2."-".$member_info->phone3;
			$email = $member_info->email;

			$send_name = $member_info->{$this->input->post('recom_deliv_addr')."_name"};
			$send_phone = $member_info->{$this->input->post('recom_deliv_addr')."_phone1"}."-".$member_info->{$this->input->post('recom_deliv_addr')."_phone2"}."-".$member_info->{$this->input->post('recom_deliv_addr')."_phone3"};

			$zip1 = $member_info->{$this->input->post('recom_deliv_addr')."_zip"};
			$addr1 = $member_info->{$this->input->post('recom_deliv_addr')."_addr1"};
			$addr2 = $member_info->{$this->input->post('recom_deliv_addr')."_addr2"};
		}
		//주소설정

		$recom_delivery_detail_date_arr = $this->input->post('recom_delivery_detail_date');

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

		$holiday_arr = array();	//배송휴일 배열
		$holiday_type = array();	//배송휴일 배열
		$holi = $this->common_m->self_q("select * from dh_deliv_holi where holiday >= '".date("Y-m-d")."' and regu=1 order by holiday asc","result");
		foreach($holi as $h){
			$holiday_arr[$h->holiday] = true;
			$holiday_type[$h->holiday]['type'] = $h->type;
		}

		//dh_trade insert data
			$insert_trade['trade_code'] = $TRADE_CODE;
			$insert_trade['trade_stat'] = 2;
			$insert_trade['trade_method'] = 8;	//상품권 결제
			$insert_trade['trade_day'] = timenow();
			$insert_trade['trade_day_ok'] = timenow();
			$insert_trade['userid'] = $member_info->userid;
			$insert_trade['name'] = $name;
			$insert_trade['phone'] = $phone;
			$insert_trade['email'] = $email;
			$insert_trade['send_name'] = $send_name;
			$insert_trade['send_phone'] = $send_phone;
			$insert_trade['send_tel'] = '';
			$insert_trade['zip1'] = $zip1;
			$insert_trade['addr1'] = $addr1;
			$insert_trade['addr2'] = $addr2;
			$insert_trade['send_text'] = '';

			$insert_trade['save_point'] = 0;
			$insert_trade['use_point'] = 0;
			$insert_trade['coupon_idx'] = 0;
			$insert_trade['use_coupon'] = $price_arr[$this->input->post('recom_idx')][$this->input->post('recom_delivery_week_count')];
			$insert_trade['total_price'] = 0;
			$insert_trade['price'] = $price_arr[$this->input->post('recom_idx')][$this->input->post('recom_delivery_week_count')];
			$insert_trade['goods_price'] = $price_arr[$this->input->post('recom_idx')][$this->input->post('recom_delivery_week_count')];
			$insert_trade['delivery_price'] = 0;
			$insert_trade['point_pay'] = 0;

			$insert_trade['memo'] = $this->input->post('coupon_code');

			$insert_trade['recom_is'] = "Y";
			$insert_trade['recom_idx'] = $recom = $this->input->post('recom_idx');
			$insert_trade['recom_delivery_sun_type'] = $this->input->post('recom_delivery_sun_type');
			$insert_trade['recom_week_count'] = $this->input->post('recom_delivery_week_count');
			$insert_trade['recom_week_day_count'] = $this->input->post('recom_delivery_week_day_count');
			$insert_trade['recom_week_type'] = $this->input->post('recom_delivery_week_type');
			$insert_trade['recom_pack_ea'] = $this->input->post('recom_pack_ea');
			$insert_trade['recom_dates'] = $recom_date_text;

			$this->common_m->insert2("dh_trade",$insert_trade);
		//dh_trade insert data

		//dh_trade_goods insert data
			$insert_trade_goods['trade_code'] = $TRADE_CODE;
			$insert_trade_goods['cate_no'] = "recom";
			$insert_trade_goods['goods_name'] = $this->input->post('goods_name');
			$insert_trade_goods['date_bind'] = $this->input->post('recom_default_deliv_start_day');
			$insert_trade_goods['total_price'] = $insert_trade['total_price'];
			$insert_trade_goods['goods_price'] = $insert_trade['goods_price'];
			$insert_trade_goods['goods_cnt'] = 1;
			$insert_trade_goods['trade_day'] = timenow();
			$insert_trade_goods['recom_idx'] = $insert_trade['recom_idx'];
			$insert_trade_goods['recom_week_count'] = $insert_trade['recom_week_count'];
			$insert_trade_goods['recom_delivery_sun_type'] = $insert_trade['recom_delivery_sun_type'];
			$insert_trade_goods['recom_week_day_count'] = $insert_trade['recom_week_day_count'];
			$insert_trade_goods['recom_week_type'] = $insert_trade['recom_week_type'];
			$insert_trade_goods['recom_pack_ea'] = $insert_trade['recom_pack_ea'];
			$insert_trade_goods['recom_per'] = $this->input->post('recom_per');
			$insert_trade_goods['recom_foods'] = serialize($recom_food_table);
			$insert_trade_goods['recom_start_date'] = $recom_delivery_detail_date_arr[0];
			$insert_trade_goods['recom_end_date'] = $recom_delivery_detail_date_arr[sizeof($recom_delivery_detail_date_arr)-1];
			$insert_trade_goods['recom_dates'] = $recom_date_text;

			$this->common_m->insert2("dh_trade_goods",$insert_trade_goods);
			$tg_idx = $this->db->insert_id();
		//dh_trade_goods insert data

		//dh_trade_deliv_info
			foreach($recom_food_table as $date=>$food){
				$recom_insert_data['trade_code'] = $TRADE_CODE;
				$recom_insert_data['deliv_code'] = $TRADE_CODE."_1-".$date."-1";
				$recom_insert_data['userid'] = $member_info->userid;
				$recom_insert_data['order_name'] = $name;
				$recom_insert_data['order_phone'] = $phone;
				$recom_insert_data['recv_name'] = $send_name;
				$recom_insert_data['recv_phone'] = $send_phone;
				$recom_insert_data['prod_name'] = $this->input->post('goods_name');
				$recom_insert_data['recom_idx'] = $recom;
				$recom_insert_data['tg_idx'] = $tg_idx;
				$recom_insert_data['deliv_date'] = date("Y-m-d",$date);
				$recom_insert_data['deliv_addr'] = $this->input->post('recom_deliv_addr');
				$recom_insert_data['zipcode'] = $zip1;
				$recom_insert_data['addr1'] = $addr1;
				$recom_insert_data['addr2'] = $addr2;
				$recom_insert_data['ct_subgroup'] = "이유식";
				if($holiday_arr[$recom_insert_data['deliv_date']]){
					if($holiday_type[$recom_insert_data['deliv_date']]['type']=="조기마감"){
						$recom_insert_data['deliv_stat']=7;
					}
					else if($holiday_type[$recom_insert_data['deliv_date']]['type']=="배송휴무"){
						$recom_insert_data['deliv_stat']=6;
					}
				}
				else{
					$recom_insert_data['deliv_stat']=0;
				}
				$recom_insert_data['wdate'] = timenow();

				$allergy = false;
				foreach($food as $alchk){
					if($alchk['allergy']) $allergy = true;
				}

				$recom_insert_data['allergy'] = $allergy ? 1 : 0 ;

				$data['goods_info'] = $this->common_m->goods_info();

				//dh_trade_deliv_prod
				foreach($food as $fd){	//추천식단 상품 정보 입력
					$fd_insert['trade_code'] = $TRADE_CODE;
					$fd_insert['deliv_code'] = $recom_insert_data['deliv_code'];
					$fd_insert['deliv_date'] = date("Y-m-d",$date);
					$fd_insert['goods_idx'] = $fd['goods_idx'];
					$fd_insert['recom_idx'] = $recom;
					$fd_insert['prod_cnt'] = $fd['prod_cnt'];
					$fd_insert['cate_no'] = $data['goods_info'][$fd['goods_idx']]->cate_no;
					$fd_insert['recom_is'] = 'Y';
					$fd_insert['tg_idx'] = $tg_idx;
					$fd_insert['wdate'] = timenow();

					$trade_db_result = $this->common_m->insert2("dh_trade_deliv_prod",$fd_insert);
				}
				//dh_trade_deliv_prod

				switch($this->input->post('step_code')){
					case "CHO": $recom_insert_data['order_type'] = "2000"; break;
					case "JUN": $recom_insert_data['order_type'] = "5000"; break;
					case "HUG": $recom_insert_data['order_type'] = "4200"; break;
					case "YOA": $recom_insert_data['order_type'] = "3000"; break;
					case "BAN": $recom_insert_data['order_type'] = "7000"; break;
				}

				$result = $this->common_m->insert2("dh_trade_deliv_info",$recom_insert_data);

			}
		//dh_trade_deliv_info

		$this->common_m->self_q("update dh_coupon_two set status = 1 where code = '".$this->input->post('coupon_code')."'","update");

		return $TRADE_CODE;
	}

		public function ini_vbank($data='')
		{

			require_once($_SERVER['DOCUMENT_ROOT'].'/pay/stdpay/libs/INIStdPayUtil.php');

			if($data['mode'] == "request"){

				$SignatureUtil = new INIStdPayUtil();
				/*
					//*** 위변조 방지체크를 signature 생성 ***

					oid, price, timestamp 3개의 키와 값을

					key=value 형식으로 하여 '&'로 연결한 하여 SHA-256 Hash로 생성 된값

					ex) oid=INIpayTest_1432813606995&price=819000&timestamp=2012-02-01 09:19:04.004


				 * key기준 알파벳 정렬

				 * timestamp는 반드시 signature생성에 사용한 timestamp 값을 timestamp input에 그대로 사용하여야함
				 */

				//############################################
				// 1.전문 필드 값 설정(***가맹점 개발수정***)
				//############################################
				// 여기에 설정된 값은 Form 필드에 동일한 값으로 설정
				$mid = $data['shop_info']['pg_id'];  // 가맹점 ID(가맹점 수정후 고정)
				//인증

				if($mid=="INIpayTest"){
					$signKey = "SU5JTElURV9UUklQTEVERVNfS0VZU1RS"; // 가맹점에 제공된 웹 표준 사인키(가맹점 수정후 고정)
				}else{
					$signKey = $data['shop_info']['pg_pw']; // 가맹점에 제공된 웹 표준 사인키(가맹점 수정후 고정)
				}

				$timestamp = $SignatureUtil->getTimestamp();   // util에 의해서 자동생성

				$orderNumber = $_REQUEST['TRADE_CODE']; // 가맹점 주문번호(가맹점에서 직접 설정)
				$price = $_REQUEST['total_price'];        // 상품가격(특수기호 제외, 가맹점에서 직접 설정)

				$cardNoInterestQuota = "";  // 카드 무이자 여부 설정(가맹점에서 직접 설정)
				$cardQuotaBase = "2:3:4:5:6:11:12:24:36";  // 가맹점에서 사용할 할부 개월수 설정
				//###################################
				// 2. 가맹점 확인을 위한 signKey를 해시값으로 변경 (SHA-256방식 사용)
				//###################################
				$mKey = $SignatureUtil->makeHash($signKey, "sha256");

				$params = array(
						"oid" => $orderNumber,
						"price" => $price,
						"timestamp" => $timestamp
				);
				$sign = $SignatureUtil->makeSignature($params, "sha256");

				/* 기타 */
				$siteDomain = "http://".$_SERVER['HTTP_HOST']."/pay/stdpay/INIStdPaySample"; //가맹점 도메인 입력
				// 페이지 URL에서 고정된 부분을 적는다.
				// Ex) returnURL이 http://localhost:8082/demo/INIpayStdSample/INIStdPayReturn.jsp 라면
				//                 http://localhost:8082/demo/INIpayStdSample 까지만 기입한다.

				$data=$mid."@@".$price."@@".$sign."@@".$mKey."@@".$timestamp."@@".$cardNoInterestQuota."@@".$cardQuotaBase;
				return $data;

			}else{

        require_once($_SERVER['DOCUMENT_ROOT'].'/pay/stdpay/libs/HttpClient.php');


        $util = new INIStdPayUtil();

        try {

            //#############################
            // 인증결과 파라미터 일괄 수신
            //#############################
            //		$var = $_REQUEST["data"];

            //#####################
            // 인증이 성공일 경우만
            //#####################
            if (strcmp("0000", $_REQUEST["resultCode"]) == 0) {

                //############################################
                // 1.전문 필드 값 설정(***가맹점 개발수정***)
                //############################################;

                $mid 			= $_REQUEST["mid"];     					// 가맹점 ID 수신 받은 데이터로 설정

								if($mid=="INIpayTest"){
									$signKey = "SU5JTElURV9UUklQTEVERVNfS0VZU1RS"; // 가맹점에 제공된 웹 표준 사인키(가맹점 수정후 고정)
								}else{
									$signKey = $data['shop_info']['pg_pw']; // 가맹점에 제공된 웹 표준 사인키(가맹점 수정후 고정)
								}

                $timestamp 		= $util->getTimestamp();   					// util에 의해서 자동생성
                $charset 		= "UTF-8";        							// 리턴형식[UTF-8,EUC-KR](가맹점 수정후 고정)
                $format 		= "JSON";        							// 리턴형식[XML,JSON,NVP](가맹점 수정후 고정)

                $authToken 		= $_REQUEST["authToken"];   				// 취소 요청 tid에 따라서 유동적(가맹점 수정후 고정)
                $authUrl 		= $_REQUEST["authUrl"];    					// 승인요청 API url(수신 받은 값으로 설정, 임의 세팅 금지)
                $netCancel 		= $_REQUEST["netCancelUrl"];   				// 망취소 API url(수신 받은f값으로 설정, 임의 세팅 금지)

                $mKey 			= hash("sha256", $signKey);					// 가맹점 확인을 위한 signKey를 해시값으로 변경 (SHA-256방식 사용)

                //#####################
                // 2.signature 생성
                //#####################
                $signParam["authToken"] 	= $authToken;  	// 필수
                $signParam["timestamp"] 	= $timestamp;  	// 필수
                // signature 데이터 생성 (모듈에서 자동으로 signParam을 알파벳 순으로 정렬후 NVP 방식으로 나열해 hash)
                $signature = $util->makeSignature($signParam);


                //#####################
                // 3.API 요청 전문 생성
                //#####################
                $authMap["mid"] 			= $mid;   		// 필수
                $authMap["authToken"] 		= $authToken; 	// 필수
                $authMap["signature"] 		= $signature; 	// 필수
                $authMap["timestamp"] 		= $timestamp; 	// 필수
                $authMap["charset"] 		= $charset;  	// default=UTF-8
                $authMap["format"] 			= $format;  	// default=XML


                try {

                    $httpUtil = new HttpClient();

                    //#####################
                    // 4.API 통신 시작
                    //#####################

                    $authResultString = "";

                    if ($httpUtil->processHTTP($authUrl, $authMap)) {
                        $authResultString = $httpUtil->body;
                       // echo "<p><b>RESULT DATA :</b> $authResultString</p>";			//PRINT DATA
                    } else {
                        //echo "Http Connect Error\n";
                       // echo $httpUtil->errormsg;

                        throw new Exception("Http Connect Error");
                    }

                    //############################################################
                    //5.API 통신결과 처리(***가맹점 개발수정***)
                    //############################################################
                    //echo "## 승인 API 결과 ##";

                    $resultMap = json_decode($authResultString, true);


                    /*************************  결제보안 추가 2016-05-18 START ****************************/
                    $secureMap["mid"]		= $mid;							//mid
                    $secureMap["tstamp"]	= $timestamp;					//timestemp
                    $secureMap["MOID"]		= $resultMap["MOID"];			//MOID
                    $secureMap["TotPrice"]	= $resultMap["TotPrice"];		//TotPrice

                    // signature 데이터 생성
                    $secureSignature = $util->makeSignatureAuth($secureMap);
                    /*************************  결제보안 추가 2016-05-18 END ****************************/

										?>
										<div style="display:none;"><?=$secureSignature."/".$resultMap["authSignature"]?></div>
										<?

									if ( strcmp("0000", $resultMap["resultCode"]) == 0 ){	//결제보안 추가 2016-05-18
										 /*****************************************************************************
											 * 여기에 가맹점 내부 DB에 결제 결과를 반영하는 관련 프로그램 코드를 구현한다.

										 [중요!] 승인내용에 이상이 없음을 확인한 뒤 가맹점 DB에 해당건이 정상처리 되었음을 반영함
												처리중 에러 발생시 망취소를 한다.
											 ******************************************************************************/

										$TID = $resultMap["tid"];
										$ResultCode = $resultMap["resultCode"];
										$PayMethod = $resultMap["payMethod"];
										$ResultMsg = $resultMap["resultMsg"];
										$MOID = $resultMap["MOID"];
										$TotPrice = isset($resultMap['TotPrice']) ? $resultMap['TotPrice'] : "" ;
										$ApplNum = isset($resultMap["applNum"]) ? $resultMap["applNum"] : "" ;
										$CARD_Quota = isset($resultMap["CARD_Quota"]) ? $resultMap["CARD_Quota"] : "" ;
										$CARD_Interest = isset($resultMap["CARD_Interest"]) ? $resultMap["CARD_Interest"] : "" ;
										$CARD_Code = isset($resultMap["CARD_Code"]) ? $resultMap["CARD_Code"] : "" ;
										$ACCT_BankCode = isset($resultMap["ACCT_BankCode"]) ? $resultMap["ACCT_BankCode"] : "";
										$CSHR_ResultCode = isset($resultMap["CSHRResultCode"]) ? $resultMap["CSHRResultCode"] : "";
										$CSHR_Type = isset($resultMap["CSHR_Type"]) ? $resultMap["CSHR_Type"] : "";
										$VACT_Num = isset($resultMap["VACT_Num"]) ? $resultMap["VACT_Num"] : "" ;
										$VACT_BankCode = isset($resultMap["VACT_BankCode"]) ? $resultMap["VACT_BankCode"] : "" ;
										$VACT_Date = isset($resultMap["VACT_Date"]) ? $resultMap["VACT_Date"] : "" ;
										$VACT_InputName = isset($resultMap["VACT_InputName"]) ? $resultMap["VACT_InputName"] : "" ;
										$VACT_Name = isset($resultMap["VACT_Name"]) ? $resultMap["VACT_Name"] : "" ;
										$merchantData = isset($resultMap["VACT_Name"]) ? $resultMap["VACT_Name"] : "" ;
										$regDate = date("Y-m-d H:i:s");

										$insert_array = array(
											'TID'=>$TID,
											'ResultCode'=>$ResultCode,
											'ResultMsg'=>$ResultMsg,
											'PayMethod'=>$PayMethod,
											'MOID'=>$MOID,
											'TotPrice'=>$TotPrice,
											'ApplNum'=>$ApplNum,
											'CARD_Quota'=>$CARD_Quota,
											'CARD_Interest'=>$CARD_Interest,
											'CARD_Code'=>$CARD_Code,
											'ACCT_BankCode'=>$ACCT_BankCode,
											'CSHR_ResultCode'=>$CSHR_ResultCode,
											'CSHR_Type'=>$CSHR_Type,
											'VACT_Num'=>$VACT_Num,
											'VACT_BankCode'=>$VACT_BankCode,
											'VACT_Date'=>$VACT_Date,
											'VACT_InputName'=>$VACT_InputName,
											'VACT_Name'=>$VACT_Name,
											'regDate'=>$regDate
										);
										$result = $this->common_m->insert2("dh_inicis_pay",$insert_array);
										if($result){
											$table = "dh_trade";

											$update_data['trade_code'] = $MOID;
											$update_data['trade_stat'] = 1;
											$update_data['trade_method'] = 4;
											$update_data['trade_day'] = $regDate;
											$update_data['userid'] = $_REQUEST['merchantData'];
											$update_data['name'] = $resultMap["buyerName"];
											$update_data['phone'] = $resultMap["buyerTel"];
											$update_data['email'] = $resultMap["buyerEmail"];
											$update_data['send_name'] = $resultMap["buyerName"];
											$update_data['send_phone'] = $resultMap["buyerTel"];
											$update_data['total_price'] = $resultMap["TotPrice"];
											$update_data['price'] = $resultMap["TotPrice"];
											$update_data['goods_price'] = $resultMap["TotPrice"];

											$update_data['newzip'] = 'deposit';

											$update_data['enter_name'] = $VACT_InputName;
											$update_data['enter_bank'] = inicis_bank_array($VACT_BankCode);
											$update_data['enter_account'] = $VACT_Num;
											$update_data['enter_info'] = $VACT_Name;

											$update_data['tno'] = $TID;


											$result = $this->common_m->insert2($table,$update_data);
											if($result){
												$table = "dh_trade_goods";

												$insert_data['trade_code'] = $MOID;
												$insert_data['cate_no'] = "deposit";
												$insert_data['goods_name'] = $resultMap["goodName"];
												$insert_data['total_price'] = $resultMap["TotPrice"];
												$insert_data['goods_price'] = $resultMap["TotPrice"];
												$insert_data['goods_cnt'] = 1;
												$insert_data['trade_day'] = $regDate;

												$result = $this->common_m->insert2($table,$insert_data);
												if($result){
													alert(cdir()."/dh_order/deposit_ok/".$MOID);
												}
											}
										}

										//$no_login="";

										//if(!$this->session->userdata('USERID')){
										//	$no_login="?nologin=1";
										//}
											?>
											<!-- <form name="order_form" id="order_form" method="post" action="<?=cdir()?>/dh_order/shop_order/<?=$this->uri->segment(3,'')?>/<?=$this->uri->segment(4,'')?>/">
											<input type="hidden" name="trade_code" value="<?=$resultMap["MOID"]?>">
											<input type="hidden" name="tno" value="<?=$resultMap["tid"]?>">
											<input type="hidden" name="cash_yn" value="<? if(isset($resultMap["CSHRResultCode"]) && $resultMap["CSHRResultCode"]){?>Y<?}else{?>N<?}?>">
											<input type="hidden" name="cash_tr_code" value="<? echo isset($resultMap["CSHR_Type"]) ? $resultMap["CSHR_Type"] : "";?>">
											<input type="hidden" name="cash_id_info" value="<? echo isset($resultMap["CSHRResultCode"]) ? $resultMap["CSHRResultCode"] : "";?>">
											<input type="hidden" name="ACCT_BankCode" value="<? echo isset($resultMap["ACCT_BankCode"]) ? $resultMap["ACCT_BankCode"] : "";?>">
											<input type="hidden" name="VACT_BankCode" value="<? echo isset($resultMap["VACT_BankCode"]) ? $resultMap["VACT_BankCode"] : "";?>">
											<input type="hidden" name="VACT_Num" value="<? echo isset($resultMap["VACT_Num"]) ? $resultMap["VACT_Num"] : "";?>">
											<input type="hidden" name="VACT_Name" value=""<? echo isset($resultMap["VACT_Name"]) ? $resultMap["VACT_Name"] : "";?>>

											<input type="hidden" name="ResultCode" value="0000">
											<input type="hidden" name="ResultMsg" value="<? echo isset($resultMap["resultMsg"]) ? $resultMap["resultMsg"] : "";?>">
											<input type="hidden" name="PayMethod" value="<? echo isset($resultMap["payMethod"]) ? $resultMap["payMethod"] : "";?>">
											<input type="hidden" name="ApplNum" value="<? echo isset($resultMap["applNum"]) ? $resultMap["applNum"] : "";?>">
											<input type="hidden" name="CARD_Quota" value="<? echo isset($resultMap["CARD_Quota"]) ? $resultMap["CARD_Quota"] : "";?>">
											<input type="hidden" name="CARD_Interest" value="<? echo isset($resultMap["CARD_Interest"]) ? $resultMap["CARD_Interest"] : "";?>">
											<input type="hidden" name="CARD_Code" value="<? echo isset($resultMap["CARD_Code"]) ? $resultMap["CARD_Code"] : "";?>">
											<input type="hidden" name="CSHR_ResultCode" value="<? echo isset($resultMap["CSHRResultCode"]) ? $resultMap["CSHRResultCode"] : "";?>">
											<input type="hidden" name="CSHR_Type" value="<? echo isset($resultMap["CSHR_Type"]) ? $resultMap["CSHR_Type"] : "";?>">
											<input type="hidden" name="VACT_Date" value="<? echo isset($resultMap["VACT_Date"]) ? $resultMap["VACT_Date"] : "";?>">
											<input type="hidden" name="VACT_InputName" value="<? echo isset($resultMap["VACT_InputName"]) ? $resultMap["VACT_InputName"] : "";?>">
											</form> -->
											<?
									//script_exe("document.order_form.submit();");

									} else {
											echo "거래 성공 여부<br>";
											echo "실패<br>";
											echo "결과 코드 " . @(in_array($resultMap["resultCode"] , $resultMap) ? $resultMap["resultCode"] : "null" ) . "<br>";

											//결제보안키가 다른 경우.
											if (strcmp($secureSignature, $resultMap["authSignature"]) != 0) {
												echo "결과 내용 <p>" . "* 데이터 위변조 체크 실패" . "<br>";

												//망취소
												if(strcmp("0000", $resultMap["resultCode"]) == 0) {
													throw new Exception("데이터 위변조 체크 실패");
												}
											} else {
												echo "결과 내용 <p>" . @(in_array($resultMap["resultMsg"] , $resultMap) ? $resultMap["resultMsg"] : "null" ) . "<br>";
											}

                    }


									}catch (Exception $e) {
                    // $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
                    //####################################
                    // 실패시 처리(***가맹점 개발수정***)
                    //####################################
                    //---- db 저장 실패시 등 예외처리----//
                    $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
                    echo $s;

                    //#####################
                    // 망취소 API
                    //#####################

                    $netcancelResultString = ""; // 망취소 요청 API url(고정, 임의 세팅 금지)

                    if ($httpUtil->processHTTP($netCancel, $authMap)) {
                        $netcancelResultString = $httpUtil->body;
                    } else {
                        echo "Http Connect Error\n";
                        echo $httpUtil->errormsg;

                        throw new Exception("Http Connect Error");
                    }
									}



            } else {

                //#############
                // 인증 실패시
                //#############
                echo "<br/>";
                echo "####인증실패####";

                echo "<pre>" . var_dump($_REQUEST) . "</pre>";
            }

        } catch (Exception $e) {
            $s = $e->getMessage() . ' (오류코드:' . $e->getCode() . ')';
            echo $s;
        }

			}
		}
}