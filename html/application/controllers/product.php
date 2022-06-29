<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Product extends CI_Controller {

 	function __construct()
	{
		parent::__construct();
    $this->load->model('admin_m');
    $this->load->model('product_m');
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
		//알러지 유발식품 포함여부 배열처리 - 상품등록 / 수정
		$allergy_arr = array(
			'1'=>'계란',
			'2'=>'우유',
			'3'=>'밀',
			'4'=>'메밀',
			'5'=>'땅콩',
			'6'=>'대두',
			'7'=>'토마토',
			'8'=>'돼지고기',
			'9'=>'게',
			'10'=>'새우',
			'11'=>'호두',
			'12'=>'닭고기',
			'13'=>'쇠고기',
			'14'=>'오징어',
			'15'=>'조개류'
		);
		$data['allergy'] = $allergy_arr;

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
					if($menu_row->emp){
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

	public function main($data='')
	{
		$p = $this->uri->segment(2);

		if($data['shop_info']['shop_use']!="y"){
			alert(str_replace("main","lists",$data['return_url']));
		}else{
			$this->load->view('/dhadm/product/'.$p);
		}
	}

	public function lists($data='')
	{

			$name = $this->input->get('name');
			$code = $this->input->get('code');
			$cate_no1 = $this->input->get('cate_no1');
			$cate_no2 = $this->input->get('cate_no2');
			$cate_no3 = $this->input->get('cate_no3');
			$cate_no4 = $this->input->get('cate_no4');
			$order = $this->input->get('order');

			$display = $this->input->get('display');

			$data['query_string'] = "?";
			$where_query = " where 1 ";
			$order_query = " idx desc, ranking asc";

			for($i=4;$i>=1;$i--){
				if(${'cate_no'.$i}){
					$where_query .= " and cate_no like '".${'cate_no'.$i}."%' ";
					break;
				}
			}

			if($cate_no1){ $data['query_string'].= "&cate_no1=".$cate_no1; }
			if($cate_no2){ $data['query_string'].= "&cate_no2=".$cate_no2; }
			if($cate_no3){ $data['query_string'].= "&cate_no3=".$cate_no3; }
			if($cate_no4){ $data['query_string'].= "&cate_no4=".$cate_no4; }
			if($name){ $data['query_string'].= "&name=".$name; $where_query .= " and name like '%".$name."%'"; }
			if($code){ $data['query_string'].= "&code=".$code; $where_query .= " and code like '%".$code."%'"; }
			$data['brand_list'] = $this->common_m->getList2("dh_brand_cate", "where display=1 order by sort, idx");

			if($display){
				$data['query_string'].= "&display=".$display;
				$where_query .= " and display = '".($display=="Y"?1:0)."'";
			}


		if($this->input->get("ajax")==1){
			$depth = $this->input->get("depth");
			$cate_no = $this->input->get("cate_no");
			$data['text'] = $this->product_m->cate_list($depth,$cate_no);
			echo $data['text'];

		}else{

			$data['param']="";
			if($this->input->get("PageNumber")){
				$data['param'] = "&PageNumber=".$this->input->get("PageNumber");
			}

			$url = cdir()."/product/lists/m";

			if($this->input->get("url")){
				$url = cdir()."/product/".$this->input->get("url")."/m";
			}

			$url = $url.$data['query_string'].$data['param'];

			if($this->input->get("edit") && $this->input->get("idx")){ // 제품 수정일경우

				$idx = $this->input->get("idx");

				$data['row'] = $this->common_m->getRow("dh_goods", "where idx='$idx'"); // 제품 데이터 가져오기


				$cate_no = explode("-",$data['row']->cate_no);
				$data['category_name'] = "";

				for($i=0;$i<count($cate_no);$i++){ //카테고리 정보
					$j=$i+1;
					if($cate_no[$i]){
						$data['category'.$i] = $this->common_m->getRow("dh_category", "where no".$j."='".$cate_no[$i]."'");
						if(isset($data['category'.$i]->title) && $data['category'.$i]->title){
						$data['category_name'] .= $data['category'.$i]->title;

							if($i+1 < count($cate_no)){
								$data['category_name'] .= " > ";
							}
						}
					}
				}



				$data['row']->display_flag = explode('/',$data['row']->display_flag);
				$data['row']->icon_flag = explode('/',$data['row']->icon_flag);
				$data['row']->brand_flag = explode('/',$data['row']->brand_flag);
				//영양분석표 배열
				$data['calories'] = explode("^",$data['row']->calories);
				//알러지 유발식품 포함여부 배열
				$data['allergys'] = explode("^",$data['row']->allergys);
				$data['data_row'] = $this->product_m->data_list("goods",$idx);
				$data['data_cnt'] = $this->product_m->data_list("goods",$idx,'count');

				for($kk=1;$kk<=3;$kk++){

					$data['option_row'.$kk] = $this->common_m->getRow("dh_goods_option","where level=1 and goods_idx = '$idx' and chk_num='".$kk."'");

					if(isset($data['option_row'.$kk]->code)){
						$data['option_list_cnt'.$kk] = $this->common_m->getCount("dh_goods_option","where level=2 and goods_idx = '$idx' and code='".$data['option_row'.$kk]->code."'");
						$data['option_list'.$kk] = $this->common_m->getList("dh_goods_option","where level=2 and goods_idx = '$idx' and code='".$data['option_row'.$kk]->code."'");
					}
				}



				//$data['best_prd_name'] = $this->product_m->best_prd($data['row']->best_prd);

				if($this->input->post("cate_no") && $this->input->post("idx")){ // 수정하기


						$list_img = "";
						$list_img_real = "";
						$mobile_img = "";
						$mobile_img_real = "";
						$display_flag_arr = array();
						$display_flag = "";
						$icon_flag_arr = array();
						$icon_flag = "";
						$brand_flag_arr = array();
						$brand_flag = "/";
						$addImgCnt = $this->input->post('img_cnt');

						$calories = "";
						$allergys = "";


						if($_FILES['list_img']['size'] > 0){

							$config = array('upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/goodsImages/','allowed_types' => 'gif|jpg|png','encrypt_name' => TRUE,'max_size' => '10000');

							$this->load->library('upload',$config);

							if(!$this->upload->do_upload('list_img')){
								alert($data['return_url'],strip_tags($this->upload->display_errors()));
							}else{
								$insert_data = $this->upload->data();
								$list_img	= $insert_data['file_name'];
								$list_img_real = $_FILES['list_img']['name'];
							}
						}else{
								$list_img	= $data['row']->list_img;
								$list_img_real = $data['row']->list_img_real;
						}


						if($_FILES['mobile_img']['size'] > 0){

							$config = array('upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/goodsImages/','allowed_types' => 'gif|jpg|png','encrypt_name' => TRUE,'max_size' => '10000');

							$this->load->library('upload',$config);

							if(!$this->upload->do_upload('mobile_img')){
								alert($data['return_url'],strip_tags($this->upload->display_errors()));
							}else{
								$insert_data = $this->upload->data();
								$mobile_img	= $insert_data['file_name'];
								$mobile_img_real = $_FILES['mobile_img']['name'];
							}
						}else{
								$mobile_img	= $data['row']->mobile_img;
								$mobile_img_real = $data['row']->mobile_img_real;
						}



						$display_flag_arr = $this->input->post('display_flag',TRUE);
						if(count($display_flag_arr) > 0){
							for($i=0;$i<count($display_flag_arr);$i++){
								$display_flag.=$display_flag_arr[$i]."/";
							}
						}


						$icon_flag_arr = $this->input->post('icon_flag',TRUE);
						if(count($icon_flag_arr) > 0){
							for($i=0;$i<count($icon_flag_arr);$i++){
								$icon_flag.=$icon_flag_arr[$i]."/";
							}
						}


						$brand_flag_arr = $this->input->post('brand_flag',TRUE);
						if(count($brand_flag_arr) > 0){
							for($i=0;$i<count($brand_flag_arr);$i++){
								$brand_flag.=$brand_flag_arr[$i]."/";
							}
						}

						$calories_arr = $this->input->post('calories',true);
						if(count($calories_arr) > 0){
							for($i=0;$i<count($calories_arr);$i++){
								$calories .= $calories_arr[$i]."^";
							}
						}

						$allergys_arr = $this->input->post('allergys',true);
						if(count($allergys_arr) > 0){
							for($i=0;$i<count($allergys_arr);$i++){
								$allergys .= $allergys_arr[$i]."^";
							}
						}

						$unlimit = $this->input->post('unlimit',TRUE);

						if($this->input->post('unlimit') == "2"){
							$unlimit = 0;
						}

						$number = $this->input->post('number',TRUE);

						if($this->input->post('unlimit') == 0){
							$number=0;
						}


						$update_data = array(
							'mode' => "goods",
							'idx' => $this->input->post('idx',TRUE),
							'cate_no' => $this->input->post('cate_no',TRUE),
							'code' => $this->input->post('code',TRUE),
							'display' => $this->input->post('display',TRUE),
							'night_market' => $this->input->post('night_market',TRUE),
							'night_market_tuto' => $this->input->post('night_market_tuto',TRUE),
							'name' => $this->input->post('name',TRUE),
							'deliv_grp' => $this->input->post('deliv_grp',TRUE),
							'ranking' => $this->input->post('ranking',TRUE),
							'food_type' => $this->input->post('food_type',TRUE),
							'step_name' => $this->input->post('step_name',TRUE),
							'make_com' => $this->input->post('make_com',TRUE),
							'delivery_date_use' => $this->input->post('delivery_date_use',TRUE),
							'deliv_days' => $this->input->post('deliv_days',TRUE),
							'size' => $this->input->post('size',TRUE),
							'expire' => $this->input->post('expire',TRUE),
							'menual' => $this->input->post('menual',TRUE),
							'detail' => $this->input->post('detail',TRUE),
							'list_img' => $list_img,
							'list_img_real' => $list_img_real,
							'mobile_img' => $mobile_img,
							'mobile_img_real' => $mobile_img_real,
							'content1' => $this->input->post('content1'),
							'display_flag' => $display_flag,
							'icon_flag' => $icon_flag,
							'brand_flag' => $brand_flag,
							'all_calorie' => $this->input->post('all_calorie',TRUE),
							'onetime_eat' => $this->input->post('onetime_eat',TRUE),
							'total_wet' => $this->input->post('total_wet',TRUE),
							'calories_info' => $this->input->post('calories_info',TRUE),
							'calories' => $calories,
							'allergys' => $allergys,
							'shop_price' => $this->input->post('shop_price',TRUE),
							'old_price' => $this->input->post('old_price',TRUE),
							'point' => $this->input->post('point',TRUE),
							'unlimit' => $unlimit,
							'number' => $number,
							'express_no_basic' => $this->input->post('express_no_basic',TRUE),
							'express_check' => $this->input->post('express_check',TRUE),
							'express_money' => $this->input->post('express_money',TRUE),
							'express_free' => $this->input->post('express_free',TRUE),
							'option_use' => $this->input->post('option_use',TRUE),
							'best_prd' => $this->input->post('best_prd',TRUE),
							'best_prd2' => $this->input->post('best_prd2',TRUE),
							'apply_sdate' => $this->input->post('apply_sdate',TRUE),
							'apply_edate' => $this->input->post('apply_edate',TRUE),
							'apply_fdate' => $this->input->post('apply_fdate',TRUE),
							'best_prd_name' => $this->input->post('best_prd_name',TRUE),
							'best_prd_name2' => $this->input->post('best_prd_name2',TRUE),
							'option_check1' => $this->input->post('option_check1',TRUE),
							'option_check2' => $this->input->post('option_check2',TRUE),
							'option_check3' => $this->input->post('option_check3',TRUE),
							'content2' => $this->input->post('size_cont'),
							'content3' => $this->input->post('detail_cont'),
							'delivery' => $this->input->post('delivery'),
							'return' => $this->input->post('return')
						);

						$result = $this->product_m->update($update_data);

						if($result){

							for($i=1;$i<=6;$i++){
								$ff=$i-1;
								${'data_name'.$i} = $this->input->post("data_name".$i);
								${'data_txt'.$i} = $this->input->post("data_txt".$i);

									if( ($this->input->post("data_name".$i) && $this->input->post("data_txt".$i)) && isset($data['data_row'][$ff]->data_name)){ // 폼값이 있고, DB에 값이 있으면

										if($this->input->post("data_name".$i) != $data['data_row'][$ff]->data_name || $this->input->post("data_txt".$i) != $data['data_row'][$ff]->data_txt){ //폼값과 DB값이 일치하지 않으면 update

											$update_data = array(
												'idx' => $data['data_row'][$ff]->idx,
												'data_name' => ${'data_name'.$i},
												'data_txt' => ${'data_txt'.$i}
											);

											$this->common_m->update("data",$update_data);
										}


									}else if(($this->input->post("data_name".$i) && $this->input->post("data_txt".$i)) && empty($data['data_row'][$ff]->data_name)){ // 폼값이 있고, DB에 값이 없으면 insert

										$insert_data = array(
											'flag' => "goods",
											'flag_idx' => $this->input->post("idx"),
											'data_name' => ${'data_name'.$i},
											'data_txt' => ${'data_txt'.$i}
										);

										$this->common_m->insert("data",$insert_data);

									}else if(isset($data['data_row'][$ff]->data_name) && !$this->input->post("data_name".$i)){ //DB값은 있는데 폼값이 없으면 삭제

										$this->common_m->del("dh_data","idx", $data['data_row'][$ff]->idx);
									}
							}


							$add_image_idx = $data['row']->idx;
							$add_image_cnt = $this->common_m->getCount("dh_file","where flag='goods' and flag_idx='$add_image_idx'");

							if($add_image_cnt){
								$addImgList = $this->common_m->getList2("dh_file","where flag_idx='$add_image_idx'");
								foreach($addImgList as $ai){
									if($ai->imsi_file_name && $ai->imsi_file_name!=$ai->file_name){
										$this->common_m->update2("dh_file",array("file_name"=>$ai->imsi_file_name,"real_name"=>$ai->imsi_real_name,"imsi_file_name"=>"","imsi_real_name"=>""), array("flag"=>"goods","idx"=>$ai->idx));
									}
								}
							}



						if($data['shop_info']['shop_use']=="y" && $this->input->post('option_use')=="1"){ //옵션수정
							$result="";

							$code_num = time();

							for($k=1;$k<=3;$k++){

								if($this->input->post('option_check'.$k)=="1"){

									$code = $this->input->post('option_code'.$k);
									if(!$code){ $code = "option_".$code_num; }

									$cnt = $this->input->post('op_cnt'.$k,true);

									$insert_data = array(
										'mode' => "goods_option",
										'goods_idx' => $this->input->post("idx"),
										'code' => $code,
										'level' => 1,
										'title' => $this->input->post('option_title'.$k,true),
										'flag' => $this->input->post('option_flag'.$k),
										'chk_num' => $k
									);

									if($this->input->post('option_code'.$k)){

										$result = $this->product_m->update($insert_data);

									}else{

										$result = $this->product_m->insert($insert_data);

									}

									if($result){

											for($i=1;$i<=$cnt;$i++){

												if($this->input->post("option_name".$k."_".$i)){
													$insert_data = array(
														'mode' => "goods_option",
														'code' => $code,
														'goods_idx' => $this->input->post("idx"),
														'level' => 2,
														'title' => $this->input->post('option_title'.$k,true),
														'name' => $this->input->post("option_name".$k."_".$i,true),
														'price' => $this->input->post("option_price".$k."_".$i,true),
														'point' => $this->input->post("option_point".$k."_".$i,true),
														'unlimit' => $this->input->post("option_unlimit".$k."_".$i,true),
														'number' => $this->input->post("option_number".$k."_".$i,true),
														'chk_num' => $k
													);

													$result = $this->product_m->insert($insert_data);
												}
											}
									}
								}else if($this->input->post('option_check'.$k)=="0"){

									$this->product_m->option_del($this->input->post('option_code'.$k));

								}

								$code_num++;
							}

						}else if($data['shop_info']['shop_use']=="y" && $this->input->post('option_use')=="0"){


						}


						result($result, "수정", $url);

						}


				}else{


					//임시파일 다 비우기 start
					$addImgList = $this->common_m->getList2("dh_file","where flag_idx='".$data['row']->idx."'","imsi_file_name");
					foreach($addImgList as $ai){
						if($ai->imsi_file_name){
							@unlink( $_SERVER['DOCUMENT_ROOT']."/_data/file/addImages/".$ai->imsi_file_name );
						}
					}
					$this->common_m->update2("dh_file",array("imsi_file_name"=>"","imsi_real_name"=>""), array("flag"=>"goods","flag_idx"=>$data['row']->idx));
					$this->common_m->del3("dh_file",array("flag"=>"goods","flag_idx"=>$data['row']->idx,"file_name"=>""));

					//임시파일 다 비우기 end

					$data['file_row'] = $this->product_m->file_list("goods",$idx);
					$data['file_cnt'] = $this->product_m->file_list("goods",$idx,'count');

					$this->load->view('/dhadm/product/write',$data);

				}

			}else if($this->input->post('del_idx') && $this->input->post('del_ok')==1){	 //제품 삭제

				$result = $this->product_m->del("idx", $this->input->post("del_idx"));

				result($result, "삭제", $url);

			}else if($this->input->post('mode')){	 //제품 이동/복사/삭제

				$formCnt = $this->input->post('formCnt');
				$new_goods_code=time();

					for($i=1;$i<=$formCnt;$i++){
						if($this->input->post("check".$i)){

							switch($this->input->post('mode'))
							{
								case "move" : //제품 이동
									$result = $this->product_m->move("idx", $this->input->post("check".$i),$this->input->post("sel_cate_no"));
									$name="이동";
								break;

								case "copy" : //제품 복사
									$new_goods_code++;
									$result = $this->product_m->goods_copy("idx", $this->input->post("check".$i),$this->input->post("sel_cate_no"),$new_goods_code);
									$name="복사";
								break;

								case "del" : //제품 삭제
									$result = $this->product_m->del("idx", $this->input->post("check".$i));
									$name="삭제";
								break;

								case "chg":
									$update_display = $this->input->post("chg_display");
									$idxs .= $this->input->post("check".$i).",";
								break;
							}
						}
					}

				if($this->input->post('mode') == 'chg'){
					$idx_in = substr($idxs,0,-1);
					$update_sql = "update dh_goods set display = '{$update_display}' where idx in ({$idx_in})";
					$result = $this->common_m->self_q($update_sql,"update");
					$name = "변경";
				}

				result($result, $name, $url);

			}else{ // 제품 목록일 경우


				if($order){
					switch($order)
					{
						case 1 : //등록일순
							$order_query = " idx desc";
						break;
						case 2 : //높은 가격순
							$order_query = " shop_price desc, idx desc";
						break;
						case 3 : //낮은 가격순
							$order_query = " shop_price asc, idx desc";
						break;
						case 4 : //이름순
							$order_query = " name asc, idx desc";
						break;
						case 5 : //이름순
							$order_query = " name desc, idx desc";
						break;
					}
				}

				/* 페이징 start */
				$PageNumber = $this->input->get("PageNumber"); //현재 페이지
				if(!$PageNumber){ $PageNumber = 1; }
				$list_num='50'; //페이지 목록개수
				$page_num='5'; //페이징 개수
				$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
				$url = $data['return_url'];
				$data['totalCnt'] = $this->common_m->getPageList('dh_goods','count','','',$where_query,$order_query); //게시판 리스트
				$data['Page2'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
				$data['listNo'] = $data['totalCnt'] - $list_num*($PageNumber-1);
				/* 페이징 end */

				$field = "
					*
					,(SELECT title FROM dh_category WHERE cate_no = SubString_Index(dh_goods.cate_no,'-',1)) AS cate1_name
					,(SELECT title FROM dh_category WHERE cate_no = dh_goods.cate_no) AS cate2_name
				";
				$data['list'] = $this->common_m->getPageList('dh_goods','',$offset,$list_num,$where_query,$order_query,$field); //게시판 리스트
				$data['cate_list'] = $this->product_m->cate_list(1); //카테고리 리스트

				$this->load->view('/dhadm/product/list',$data);

			}

		}
	}


	public function write($data='')
	{
		if($this->input->get("ajax")==1){
			$depth = $this->input->get("depth");
			$cate_no = $this->input->get("cate_no");
			$sel_no = $this->input->get("sel_no");
			$de = $this->input->get("de");
			if(!$de){ $de=1; }
			$data['text'] = $this->product_m->cate_list($depth,$cate_no,$sel_no,$de);
			echo $data['text'];

		}else{

			if($this->input->post("cate_no") && $this->input->post("code")){

					$list_img = "";
					$list_img_real = "";
					$mobile_img = "";
					$mobile_img_real = "";
					$display_flag_arr = array();
					$display_flag = "";
					$icon_flag_arr = array();
					$icon_flag = "";
					$brand_flag_arr = array();
					$brand_flag = "/";
					$addImgCnt = $this->input->post('img_cnt');

					$calories = "";
					$allergys = "";


					if($_FILES['list_img']['size'] > 0){

						$config = array('upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/goodsImages/','allowed_types' => 'gif|jpg|png','encrypt_name' => TRUE,'max_size' => '10000');

						$this->load->library('upload',$config);

						if(!$this->upload->do_upload('list_img')){
							alert($data['return_url'],strip_tags($this->upload->display_errors()));
						}else{
							$insert_data = $this->upload->data();
							$list_img	= $insert_data['file_name'];
							$list_img_real = $_FILES['list_img']['name'];
						}
					}

					if($_FILES['mobile_img']['size'] > 0){

						$config = array('upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/goodsImages/','allowed_types' => 'gif|jpg|png','encrypt_name' => TRUE,'max_size' => '10000');

						$this->load->library('upload',$config);

						if(!$this->upload->do_upload('mobile_img')){
							alert($data['return_url'],strip_tags($this->upload->display_errors()));
						}else{
							$insert_data = $this->upload->data();
							$mobile_img	= $insert_data['file_name'];
							$mobile_img_real = $_FILES['mobile_img']['name'];
						}
					}


					$display_flag_arr = $this->input->post('display_flag',TRUE);
					if(count($display_flag_arr) > 0){
						for($i=0;$i<count($display_flag_arr);$i++){
							$display_flag.=$display_flag_arr[$i]."/";
						}
					}


					$icon_flag_arr = $this->input->post('icon_flag',TRUE);
					if(count($icon_flag_arr) > 0){
						for($i=0;$i<count($icon_flag_arr);$i++){
							$icon_flag.=$icon_flag_arr[$i]."/";
						}
					}


					$brand_flag_arr = $this->input->post('brand_flag',TRUE);
					if(count($brand_flag_arr) > 0){
						for($i=0;$i<count($brand_flag_arr);$i++){
							$brand_flag.=$brand_flag_arr[$i]."/";
						}
					}

					$calories_arr = $this->input->post('calories',true);
					if(count($calories_arr) > 0){
						for($i=0;$i<count($calories_arr);$i++){
							$calories .= $calories_arr[$i]."^";
						}
					}

					$allergys_arr = $this->input->post('allergys',true);
					if(count($allergys_arr) > 0){
						for($i=0;$i<count($allergys_arr);$i++){
							$allergys .= $allergys_arr[$i]."^";
						}
					}

					$unlimit = $this->input->post('unlimit',TRUE);

					if($this->input->post('unlimit') == "2"){
						$unlimit = 0;
					}


					$number = $this->input->post('number',TRUE);

					if($this->input->post('unlimit') == 0){
						$number=0;
					}

					$insert_data = array(
						'mode' => "goods",
						'cate_no' => $this->input->post('cate_no',TRUE),
						'code' => $this->input->post('code',TRUE),
						'display' => $this->input->post('display',TRUE),
						'night_market' => $this->input->post('night_market',TRUE),
						'night_market_tuto' => $this->input->post('night_market_tuto',TRUE),
						'name' => $this->input->post('name',TRUE),
						'deliv_grp' => $this->input->post('deliv_grp',TRUE),
						'ranking' => $this->input->post('ranking',TRUE),
						'step_name' => $this->input->post('step_name',TRUE),
						'make_com' => $this->input->post('make_com',TRUE),
						'delivery_date_use' => $this->input->post('delivery_date_use',TRUE),
						'deliv_days' => $this->input->post('deliv_days',TRUE),
						'food_type' => $this->input->post('food_type',TRUE),
						'size' => $this->input->post('size',TRUE),
						'expire' => $this->input->post('expire',TRUE),
						'menual' => $this->input->post('menual',TRUE),
						'detail' => $this->input->post('detail',TRUE),
						'list_img' => $list_img,
						'list_img_real' => $list_img_real,
						'mobile_img' => $mobile_img,
						'mobile_img_real' => $mobile_img_real,
						'content1' => $this->input->post('content1'),
						'display_flag' => $display_flag,
						'icon_flag' => $icon_flag,
						'brand_flag' => $brand_flag,
						'all_calorie' => $this->input->post('all_calorie',TRUE),
						'onetime_eat' => $this->input->post('onetime_eat',TRUE),
						'apply_sdate' => $this->input->post('apply_sdate',TRUE),
						'apply_edate' => $this->input->post('apply_edate',TRUE),
						'apply_fdate' => $this->input->post('apply_fdate',TRUE),
						'total_wet' => $this->input->post('total_wet',TRUE),
						'calories_info' => $this->input->post('calories_info',TRUE),
						'calories' => $calories,
						'allergys' => $allergys,
						'shop_price' => $this->input->post('shop_price',TRUE),
						'old_price' => $this->input->post('old_price',TRUE),
						'point' => $this->input->post('point',TRUE),
						'unlimit' => $unlimit,
						'number' => $number,
						'express_no_basic' => $this->input->post('express_no_basic',TRUE),
						'express_check' => $this->input->post('express_check',TRUE),
						'express_money' => $this->input->post('express_money',TRUE),
						'express_free' => $this->input->post('express_free',TRUE),
						'option_use' => $this->input->post('option_use',TRUE),
						'best_prd' => $this->input->post('best_prd',TRUE),
						'best_prd2' => $this->input->post('best_prd2',TRUE),
						'best_prd_name' => $this->input->post('best_prd_name',TRUE),
						'best_prd_name2' => $this->input->post('best_prd_name2',TRUE),
						'option_check1' => $this->input->post('option_check1',TRUE),
						'option_check2' => $this->input->post('option_check2',TRUE),
						'option_check3' => $this->input->post('option_check3',TRUE),
						'content2' => $this->input->post('size_cont'),
						'content3' => $this->input->post('detail_cont'),
						'delivery' => $this->input->post('delivery'),
						'return' => $this->input->post('return')
					);

					$result = $this->product_m->insert($insert_data);
					$a_idx = mysql_insert_id();

					if($result){

						for($i=1;$i<=6;$i++){
							if($this->input->post("data_name".$i) && $this->input->post("data_txt".$i)){
								${'data_name'.$i} = $this->input->post("data_name".$i);
								${'data_txt'.$i} = $this->input->post("data_txt".$i);


							$insert_data = array(
								'flag' => "goods",
								'flag_idx' => $a_idx,
								'data_name' => ${'data_name'.$i},
								'data_txt' => ${'data_txt'.$i}
							);

								$this->common_m->insert("data",$insert_data);

							}
						}


						$add_image_idx = $this->input->post("a_idx");
						$add_image_cnt = $this->common_m->getCount("dh_file","where flag='goods' and flag_idx='$add_image_idx'");

						if($add_image_cnt){
							$addImgList = $this->common_m->getList2("dh_file","where flag_idx='$add_image_idx'","idx,imsi_file_name,imsi_real_name");
							foreach($addImgList as $ai){
								$this->common_m->update2("dh_file",array("flag_idx"=>$a_idx,"file_name"=>$ai->imsi_file_name,"real_name"=>$ai->imsi_real_name,"imsi_file_name"=>"","imsi_real_name"=>""), array("flag"=>"goods","idx"=>$ai->idx));
							}
						}

					}

					if($data['shop_info']['shop_use']=="y" && $this->input->post('option_use')=="1"){ //옵션등록
						$result="";

						$code_num = time();

						for($k=1;$k<=3;$k++){

							if($this->input->post('option_check'.$k)=="1"){

								$code = $code="option_".$code_num;
								$cnt = $this->input->post('op_cnt'.$k,true);

								$insert_data = array(
									'mode' => "goods_option",
									'goods_idx' => $a_idx,
									'code' => $code,
									'level' => 1,
									'title' => $this->input->post('option_title'.$k,true),
									'flag' => $this->input->post('option_flag'.$k,true),
									'chk_num' => $k
								);

								$result = $this->product_m->insert($insert_data);

								if($result){

										for($i=1;$i<=$cnt;$i++){

											if($this->input->post("option_name".$k."_".$i)){
												$insert_data = array(
													'mode' => "goods_option",
													'code' => $code,
													'goods_idx' => $a_idx,
													'level' => 2,
													'title' => $this->input->post('option_title'.$k,true),
													'name' => $this->input->post("option_name".$k."_".$i,true),
													'price' => $this->input->post("option_price".$k."_".$i,true),
													'point' => $this->input->post("option_point".$k."_".$i,true),
													'unlimit' => $this->input->post("option_unlimit".$k."_".$i,true),
													'number' => $this->input->post("option_number".$k."_".$i,true),
													'chk_num' => $k
												);

												$result = $this->product_m->insert($insert_data);
											}
										}
								}

								$code_num++;
							}
						}

					}

					result($result, "등록", cdir()."/product/lists/m");

			}else{

				$data['cate_list'] = $this->product_m->cate_list(1);
				$data['brand_list'] = $this->common_m->getList2("dh_brand_cate", "where display=1 order by sort, idx");
				$data['prd_info'] = $this->common_m->getRow("dh_page", "where page_index ='prd_info'");
				$data['delivery'] = $this->common_m->getRow("dh_page", "where page_index ='delivery'");
				$data['return'] = $this->common_m->getRow("dh_page", "where page_index ='return'");
				$data['size'] = $this->common_m->getRow("dh_page", "where page_index ='size'");
				$data['detail'] = $this->common_m->getRow("dh_page", "where page_index ='detail'");
				$this->load->view('/dhadm/product/write',$data);

			}
		}
	}

	public function sort($data) //제품 순서변경
	{

			$cate_no1 = $this->input->get('cate_no1');
			$cate_no2 = $this->input->get('cate_no2');
			$cate_no3 = $this->input->get('cate_no3');
			$cate_no4 = $this->input->get('cate_no4');
			$cate_no = $this->input->get('cate_no');

			$data['cate_no1'] = $cate_no1;
			$data['cate_no2'] = $cate_no2;
			$data['cate_no3'] = $cate_no3;
			$data['cate_no4'] = $cate_no4;


			$data['query_string'] = "?";
			$where_query = " where 1 ";
			$order_query = " ranking asc, idx desc ";

			for($i=4;$i>=1;$i--){
				if(${'cate_no'.$i}){
					$where_query .= " and cate_no like '".${'cate_no'.$i}."%' ";
					break;
				}
			}

			if($cate_no){ $data['query_string'].= "&cate_no=".$cate_no; }
			if($cate_no1){ $data['query_string'].= "&cate_no1=".$cate_no1; }
			if($cate_no2){ $data['query_string'].= "&cate_no2=".$cate_no2; }
			if($cate_no3){ $data['query_string'].= "&cate_no3=".$cate_no3; }
			if($cate_no4){ $data['query_string'].= "&cate_no4=".$cate_no4; }

			$data['param']="";
			if($this->input->get("PageNumber")){
				$data['param'] = "&PageNumber=".$this->input->get("PageNumber");
			}

			if($this->input->post("mode") && $this->input->post("num") && $this->input->post("idx"))
			{
				$result = $this->product_m->sortChange($this->input->post("mode"), $this->input->post("num"), $this->input->post("idx"), $cate_no);
				result($result, "",self_url().$data['query_string']);
			}
			else
			{
				/* 페이징 start */
				$PageNumber = $this->input->get("PageNumber"); //현재 페이지
				if(!$PageNumber){ $PageNumber = 1; }

				$list_num='15'; //페이지 목록개수
				$page_num='5'; //페이징 개수
				$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
				$url = $data['return_url'];
				$data['totalCnt'] = $this->common_m->getPageList('dh_goods','count','','',$where_query,$order_query); //게시판 리스트
				$data['Page'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
				/* 페이징 end */

				$data['list'] = $this->common_m->getPageList('dh_goods','',$offset,$list_num,$where_query,$order_query); //게시판 리스트
				$data['cate_list'] = $this->product_m->cate_list(1); //카테고리 리스트
				if( $cate_no ){
					$data['cate_row'] = $this->common_m->getRow("dh_category", "where cate_no = '".$cate_no."'"); //선택된 카테고리
				}

			$this->load->view('/dhadm/product/sort',$data);

		}
	}


	public function option($data)
	{
			$title = $this->input->get('title');
			$name = $this->input->get('name');
			$code = $this->input->get('code');
			$url = $data['return_url'];

			$data['query_string'] = "?";
			$where_query = "";

			if($title){ $data['query_string'].= "&title=".$title; $where_query .= " and title like '%".$title."%'"; }
			if($name){ $data['query_string'].= "&name=".$name; $where_query .= " and name like '%".$name."%'"; }
			if($code){ $data['query_string'].= "&code=".$code; $where_query .= " and code like '%".$code."%'"; }


			$data['param']="";
			if($this->input->get("PageNumber")){
				$data['param'] = "&PageNumber=".$this->input->get("PageNumber");
			}


			if($this->input->post('del_idx') && $this->input->post('del_ok')==1){	 // 삭제


				$code = $this->input->post('del_idx');
				$result = $this->common_m->del2("dh_goods_option", "where code='$code' and goods_idx=0");

				result($result, "삭제", $url);exit;
			}else if($this->input->post('form_cnt')){ //여러글 삭제
				for($i=1;$i<=$this->input->post('form_cnt');$i++){
					if($this->input->post('chk'.$i)){
						$result = $this->common_m->del2("dh_goods_option", "where code='".$this->input->post('chk'.$i,TRUE)."' and goods_idx=0");
					}
				}

				result($result, "삭제", $data['return_url']);

			}


			/* 페이징 start */
			$PageNumber = $this->input->get("PageNumber"); //현재 페이지
			if(!$PageNumber){ $PageNumber = 1; }
			$list_num='15'; //페이지 목록개수
			$page_num='5'; //페이징 개수
			$offset = $list_num*($PageNumber-1); //한 페이지의 시작 글 번호(listnum 수만큼 나누었을 때 시작하는 글의 번호)
			$data['totalCnt'] = $this->product_m->OptionPageList('count','','', $where_query); //총 카운트

			$data['Page2'] = Page2($data['totalCnt'],$PageNumber,$url,$list_num,$page_num,$data['query_string']);
			/* 페이징 end */

			$result = $this->product_m->OptionPageList('',$offset,$list_num, $where_query); // 리스트
			$data['list'] = $result['list'];
			$data['opNameArr'] = $result['opNameArr'];

			$data['cate_list'] = $this->product_m->cate_list(1); //카테고리 리스트
			$this->load->view('/dhadm/product/option',$data);

	}



	public function option_setting()
	{
		$mode = $this->input->post("mode",true);
		$title = $this->input->post("title",true);
		$code = $this->input->post("option_code",true);
		$cnt = $this->input->post("cnt",true);
		$data['shop_info'] = $this->admin_m->shop_info(); //shop 정보

		$option_code = $this->uri->segment(3);

		if($mode=="add" && $title){

			$insert_data = array(
				'mode' => "goods_option",
				'goods_idx' => $this->input->post("goods_idx",true),
				'code' => $code,
				'level' => 1,
				'title' => $title,
				'flag' => $this->input->post("flag",true),
				'chk_num' => 0
			);

			$result = $this->product_m->insert($insert_data);

			if($result){

					for($i=1;$i<=$cnt;$i++){

						if($this->input->post("option_name".$i)){
							$insert_data = array(
								'mode' => "goods_option",
								'code' => $code,
								'goods_idx' => $this->input->post("goods_idx",true),
								'level' => 2,
								'title' => $title,
								'name' => $this->input->post("option_name".$i,true),
								'price' => $this->input->post("option_price".$i,true),
								'point' => $this->input->post("option_point".$i,true),
								'unlimit' => $this->input->post("option_unlimit".$i,true),
								'number' => $this->input->post("option_number".$i,true),
								'chk_num' => 0
							);

							$result2 = $this->product_m->insert($insert_data);
						}
					}

					script_exe("alert('등록 되었습니다.'); opener.window.location.reload(); window.close();");


			}

		}else if($mode=="edit" && $title && $code){


			$result = $this->common_m->del2("dh_goods_option","where level=2 and code='$code'"); //옵션항목 삭제
			if($result){ //다시 등록

					for($i=1;$i<=$cnt;$i++){

						if($this->input->post("option_name".$i)){
							$insert_data = array(
								'mode' => "goods_option",
								'code' => $code,
								'goods_idx' => $this->input->post("goods_idx",true),
								'level' => 2,
								'title' => $title,
								'name' => $this->input->post("option_name".$i,true),
								'price' => $this->input->post("option_price".$i,true),
								'point' => $this->input->post("option_point".$i,true),
								'unlimit' => $this->input->post("option_unlimit".$i,true),
								'number' => $this->input->post("option_number".$i,true),
								'chk_num' => 0
							);

							$result2 = $this->product_m->insert($insert_data);
						}
					}

					script_exe("alert('수정 되었습니다.'); opener.window.location.reload(); window.close();");

			}




		}else if($option_code){

			$data['row'] = $this->common_m->getRow("dh_goods_option","where code='$option_code' and level=1");
			$data['option_list'] = $this->common_m->getList("dh_goods_option","where code='$option_code' and level=2");
			$data['cnt'] = $this->common_m->getCount("dh_goods_option","where code='$option_code' and level=2");

		}else if($this->input->get("load")){


			$data['load'] = $this->input->get("load");
			$data['list'] = $this->common_m->getList("dh_goods_option","where level=1 and goods_idx < 1");

			if($this->input->get("option_code")){
				$data['option_list'] = $this->common_m->getList("dh_goods_option","where level=2 and goods_idx < 1 and code='".$this->input->get("option_code",true)."'");
				$data['row'] = $this->common_m->getRow("dh_goods_option","where code='".$this->input->get("option_code",true)."' and level=1");
			}

			if($this->input->get("option_sel")==1){
				$this->load->view('/dhadm/product/prd_ajax_option_load',$data);
			}else{
				$this->load->view('/dhadm/product/option_load',$data);
			}
			exit;
		}

		$this->load->view('/dhadm/product/option_setting',$data);
	}


	public function cate($data='')
	{
		if($this->input->get("ajax")==1){
			$mode = $this->input->get("mode");
			if($mode=="write"){ $mode = "view"; }

			$data['data'] = $this->product_m->{$mode}($this->input->get("idx"));
			$data['level_row'] = $this->common_m->getList("dh_member_level"); //회원 등급 data

			$this->load->view('/dhadm/product/cate_'.$mode,$data);

		}else{

			if($this->input->post("mode")=="write"){ //새 카테고리 등록

					$img1 = "";
					$img2 = "";
					$img_real1 = "";
					$img_real2 = "";

					if($_FILES['img1']['size'] > 0){

						$config = array('upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/goodsImages/','allowed_types' => 'gif|jpg|png','encrypt_name' => TRUE,'max_size' => '10000');

						$this->load->library('upload',$config);

						if(!$this->upload->do_upload('img1')){
							alert($data['return_url'],strip_tags($this->upload->display_errors()));
						}else{
							$insert_data = $this->upload->data();
							$img1	= $insert_data['file_name'];
							$img_real1 = $_FILES['img1']['name'];
						}
					}

					if($_FILES['img2']['size'] > 0){

						$config = array('upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/goodsImages/','allowed_types' => 'gif|jpg|png','encrypt_name' => TRUE,'max_size' => '10000');

						$this->load->library('upload',$config);

						if(!$this->upload->do_upload('img2')){
							alert($data['return_url'],strip_tags($this->upload->display_errors()));
						}else{
							$insert_data = $this->upload->data();
							$img2	= $insert_data['file_name'];
							$img_real2 = $_FILES['img2']['name'];
						}
					}

					$insert_data = array(
						'mode' => "category",
						'p_idx' => $this->input->post('p_idx',TRUE),
						'depth' => $this->input->post('depth',TRUE),
						'title' => $this->input->post('title',TRUE),
						'display' => $this->input->post('display',TRUE),
						'access_level' => $this->input->post('access_level',TRUE),
						'img1' => $img1,
						'img2' => $img2,
						'img_real1' => $img_real1,
						'img_real2' => $img_real2,
						'content' => $this->input->post('content')
					);

					$result = $this->product_m->insert($insert_data);
					if($result > 1){
						$a_idx = $result;
					}else{
						$a_idx = mysql_insert_id();
					}

					$script = "parent.list('".$a_idx."');";
					parent_result('등록',$script);

			}else if($this->input->post("mode")=="view"){ //새 카테고리 수정


					$data['data'] = $this->product_m->{$this->input->post("mode")}($this->input->post("p_idx"));
					$row = $data['data']['row'];

					$img1 = "";
					$img2 = "";
					$img_real1 = "";
					$img_real2 = "";

					if($_FILES['img1']['size'] > 0){

						$config = array('upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/goodsImages/','allowed_types' => 'gif|jpg|png','encrypt_name' => TRUE,'max_size' => '10000');

						$this->load->library('upload',$config);

						if(!$this->upload->do_upload('img1')){
							alert($data['return_url'],strip_tags($this->upload->display_errors()));
						}else{
							$insert_data = $this->upload->data();
							$img1	= $insert_data['file_name'];
							$img_real1 = $_FILES['img1']['name'];
						}
					}else{
						$img1 = $row->img1;
						$img_real1 = $row->img_real1;
					}

					if($_FILES['img2']['size'] > 0){

						$config = array('upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/goodsImages/','allowed_types' => 'gif|jpg|png','encrypt_name' => TRUE,'max_size' => '10000');

						$this->load->library('upload',$config);

						if(!$this->upload->do_upload('img2')){
							alert($data['return_url'],strip_tags($this->upload->display_errors()));
						}else{
							$insert_data = $this->upload->data();
							$img2	= $insert_data['file_name'];
							$img_real2 = $_FILES['img2']['name'];
						}
					}else{
						$img2 = $row->img2;
						$img_real2 = $row->img_real2;
					}

					$update_data = array(
						'mode' => "category",
						'idx' => $row->idx,
						'title' => $this->input->post('title',TRUE),
						'display' => $this->input->post('display',TRUE),
						'access_level' => $this->input->post('access_level',TRUE),
						'img1' => $img1,
						'img2' => $img2,
						'img_real1' => $img_real1,
						'img_real2' => $img_real2,
						'content' => $this->input->post('content')
					);



					$result = $this->product_m->update($update_data);
					$a_idx = $row->idx;

					$script = "parent.list('".$a_idx."');";
					parent_result('수정',$script);

			}else if($this->input->post("mode")=="del"){ //새 카테고리 삭제

				$result = $this->common_m->del("dh_category","idx", $this->input->post('del_idx')); //해당 유저 삭제
				$script = "parent.location.href='".self_url()."';";
				parent_result('삭제',$script);

			}else{
				$this->load->view('/dhadm/product/cate');
			}
		}
	}


	public function cate_move()
	{

		$update_data = array(
			'mode' => 'move',
			'moveIdx' => $this->input->get('moveIdx',TRUE),
			'action' => $this->input->get('action',TRUE),
			'flag' => $this->input->get('flag',TRUE)
		);

		$result = $this->product_m->update($update_data);

		echo $result;
	}


	public function best_prd()
	{
			$name = $this->input->get('name');
			$code = $this->input->get('code');
			$cate_no1 = $this->input->get('cate_no1');
			$cate_no2 = $this->input->get('cate_no2');
			$cate_no3 = $this->input->get('cate_no3');
			$cate_no4 = $this->input->get('cate_no4');

			$data['query_string'] = "?";
			$where_query = " where 1 ";

			for($i=4;$i>=1;$i--){
				if(${'cate_no'.$i}){
					$where_query .= " and cate_no like '".${'cate_no'.$i}."%' ";
					break;
				}
			}

			if($cate_no1){ $data['query_string'].= "&cate_no1=".$cate_no1; }
			if($cate_no2){ $data['query_string'].= "&cate_no2=".$cate_no2; }
			if($cate_no3){ $data['query_string'].= "&cate_no3=".$cate_no3; }
			if($cate_no4){ $data['query_string'].= "&cate_no4=".$cate_no4; }
			if($name){ $data['query_string'].= "&name=".$name; $where_query .= " and name like '%".$name."%'"; }
			if($code){ $data['query_string'].= "&code=".$code; $where_query .= " and code like '%".$code."%'"; }


			$data['totalCnt'] = $this->common_m->getPageList('dh_goods','count','','',$where_query); //게시판 리스트
			$data['list'] = $this->common_m->getPageList('dh_goods','','','',$where_query); //게시판 리스트
			$data['cate_list'] = $this->product_m->cate_list(1); //카테고리 리스트
			$this->load->view("/dhadm/product/best_prd_pop", $data);
	}


	public function file_del() //제품 이미지 삭제
	{
		$mode = $this->input->get("mode");
		$idx = $this->input->get("idx");
		$num = $this->input->get("num");
		if($mode=="list_img" || $mode=="mobile_img"){
			$result = $this->product_m->file_del($idx,$mode);
		}else if($mode=="brand" || $mode=="cate"){
			$result = $this->product_m->file_del($idx,$mode,$num);
		}else if($mode=="coupon_img"){
			$result = $this->product_m->file_del($idx,$mode);
		}else{
			$result = $this->common_m->file_del('goods',$idx);
		}
	}

	public function product_move()
	{
		$data['mode'] = $this->uri->segment(3);
		$data['cate_list'] = $this->product_m->cate_list(1); //카테고리 리스트
		$this->load->view("/dhadm/product/prd_move_pop",$data);
	}


	public function brand()
	{
		$data['return_url'] = cdir()."/product/brand/m";
		$table = "dh_brand_cate";

		if($this->input->get("ajax")==1){
			$mode = $this->input->get("mode");
			if($mode=="write"){ $mode = "view"; }

			$data['data'] = $this->product_m->{'brand_'.$mode}($this->input->get("idx"));

			$this->load->view('/dhadm/product/brand_'.$mode,$data);

		}else{

			if($this->input->post("mode")=="write"){ //새 카테고리 등록

					for($i=1;$i<=4;$i++){
						${'img'.$i} = "";
						${'img_real'.$i} = "";

						if($_FILES['img'.$i]['size'] > 0){

							$config = array('upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/brandImages/','allowed_types' => 'gif|jpg|png','encrypt_name' => TRUE,'max_size' => '10000');

							$this->load->library('upload',$config);

							if(!$this->upload->do_upload('img'.$i)){
								alert($data['return_url'],strip_tags($this->upload->display_errors()));
							}else{
								$insert_data = $this->upload->data();
								${'img'.$i}	= $insert_data['file_name'];
								${'img_real'.$i} = $_FILES['img'.$i]['name'];
							}
						}
					}

					$max_sort = $this->common_m->getMax($table,"sort");
					$max_sort = $max_sort+1;

					$insert_data = array(
						'title' => $this->input->post('title',TRUE),
						'recom_use' => $this->input->post('recom_use',TRUE),
						'free_use' => $this->input->post('free_use',TRUE),
						'food_table' => $this->input->post('food_table',TRUE),
						'display' => $this->input->post('display',TRUE),
						'level' => $this->input->post('level',TRUE),
						'txt1' => $this->input->post('txt1'),
						'txt2' => $this->input->post('txt2'),
						'sort ' => $max_sort,
						'reg_date' => date('Y-m-d H:i:s')
					);


					for($j=1;$j<=4;$j++){
						$insert_data['img'.$j] = ${'img'.$j};
						$insert_data['img_real'.$j] = ${'img_real'.$j};
					}

					$result = $this->common_m->insert2($table,$insert_data);
					$a_idx = mysql_insert_id();
					$result = $this->common_m->update2($table,array('ref' => $a_idx),array('idx' => $a_idx));


					$script = "parent.list('".$a_idx."');";
					parent_result('등록',$script);

			}else if($this->input->post("mode")=="view"){ //새 카테고리 수정


					$data['data'] = $this->product_m->{'brand_'.$this->input->post("mode")}($this->input->post("p_idx"));
					$row = $data['data']['row'];

					for($i=1;$i<=4;$i++){
						${'img'.$i} = "";
						${'img_real'.$i} = "";

						if($_FILES['img'.$i]['size'] > 0){

							$config = array('upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/brandImages/','allowed_types' => 'gif|jpg|png','encrypt_name' => TRUE,'max_size' => '10000');

							$this->load->library('upload',$config);

							if(!$this->upload->do_upload('img'.$i)){
								alert($data['return_url'],strip_tags($this->upload->display_errors()));
							}else{
								$insert_data = $this->upload->data();
								${'img'.$i}	= $insert_data['file_name'];
								${'img_real'.$i} = $_FILES['img'.$i]['name'];
								@unlink( $_SERVER['DOCUMENT_ROOT']."/_data/file/brandImages/".$row->{'img'.$i} );
							}
						}else{
							${'img'.$i} = $row->{'img'.$i};
							${'img_real'.$i} = $row->{'img_real'.$i};
						}
					}

					$update_data = array(
						'title' => $this->input->post('title',TRUE),
						'recom_use' => $this->input->post('recom_use',TRUE),
						'free_use' => $this->input->post('free_use',TRUE),
						'food_table' => $this->input->post('food_table',TRUE),
						'display' => $this->input->post('display',TRUE),
						'level' => $this->input->post('level',TRUE),
						'txt1' => $this->input->post('txt1'),
						'txt2' => $this->input->post('txt2')
					);


					for($j=1;$j<=4;$j++){
						$update_data['img'.$j] = ${'img'.$j};
						$update_data['img_real'.$j] = ${'img_real'.$j};
					}

					$a_idx = $row->idx;

					$result = $this->common_m->update2($table,$update_data,array('idx' => $a_idx));

					$script = "parent.list('".$a_idx."');";
					parent_result('수정',$script);


			}else if($this->input->post("mode")=="del"){ //새 카테고리 삭제

				$row = $this->common_m->getRow("dh_brand_cate", "where idx='".$this->input->post('del_idx',true)."'");
				$result = $this->common_m->del("dh_brand_cate","idx", $this->input->post('del_idx')); //해당 데이터 삭제
				if($result){

					for($i=1;$i<=4;$i++){
						if($row->{'img'.$i}){
							@unlink( $_SERVER['DOCUMENT_ROOT']."/_data/file/brandImages/".$row->{'img'.$i} ); //이미지삭제
						}
					}
				}
				$script = "parent.location.href='".self_url()."';";
				parent_result('삭제',$script);

			}

			$this->load->view("/dhadm/product/brand",$data);

		}
	}



	public function file_up()
	{

		$gall_cnt = $this->input->get("gall_cnt");
		$a_idx = $this->input->get("a_idx");
		$mode = $this->input->get("mode");
		$del_idx = $this->input->get("del_idx");

		if($mode=="del" && $del_idx){

			$row = $this->common_m->getRow("dh_file","where idx='$del_idx'");
			$this->common_m->del2("dh_file","where idx='$del_idx'");
			@unlink( $_SERVER['DOCUMENT_ROOT']."/_data/file/addImages/".$row->{'file_name'} );


		}else{


					if($_FILES['add_images'.$gall_cnt]['size'] > 0){

						$config = array('upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/addImages/','allowed_types' => 'gif|jpg|png','encrypt_name' => TRUE,'max_size' => '20000');

						$this->load->library('upload',$config);

						if(!$this->upload->do_upload('add_images'.$gall_cnt)){
							alert($data['return_url'],strip_tags($this->upload->display_errors()));
						}else{
							$insert_data = $this->upload->data();
							$list_img	= $insert_data['file_name'];
							$list_img_real = $_FILES['add_images'.$gall_cnt]['name'];
						}
					}

					$t_cnt = $this->common_m->getCount("dh_file","where idx='$del_idx'","idx");


					if($del_idx && $t_cnt > 0){ //수정
						$row = $this->common_m->getRow("dh_file","where idx='$del_idx'");

						$update_data = array(
							'imsi_file_name' => $list_img,
							'imsi_real_name' => $list_img_real
						);

						$result = $this->common_m->update2("dh_file",$update_data,array('idx'=>$del_idx));

						@unlink( $_SERVER['DOCUMENT_ROOT']."/_data/file/addImages/".$row->imsi_file_name );

						$insert_id = $del_idx;

					}else{

						$insert_data = array(
							'flag' => "goods",
							'flag_idx' => $a_idx,
							'imsi_file_name' => $list_img,
							'imsi_real_name' => $list_img_real,
							'num'=>$gall_cnt,
							'reg_date' => date("Y-m-d H:i:s")
						);

						$result = $this->common_m->insert2("dh_file",$insert_data);
						$insert_id = mysql_insert_id();

					}

					echo $insert_id;

		}

	}

	public function recom_pop(){	//추천식단 등록시 제품 선택하는 팝업페이지

		if($_POST){

			$check = $this->input->post('check');
			$recom_food_idx = $this->input->post('recom_food_idx');
			$recom_date = $this->input->post('recom_date');
			$table = "dh_recom_food_table";
			$result = "";

			if($check[0]){
				$cnt = $this->common_m->self_q("select * from {$table} where recom_date = '{$recom_date}' and recom_food_idx = '{$recom_food_idx}'","cnt");

				if($cnt > 0){
					$this->common_m->self_q("delete from {$table} where recom_date = '{$recom_date}' and recom_food_idx = '{$recom_food_idx}'","delete");
				}

				foreach($check as $c){

					$inserts['recom_food_idx'] = $recom_food_idx;
					$inserts['goods_idx'] = $c;
					$inserts['recom_date'] = $recom_date;
					if($c){
						$result = $this->common_m->insert2($table,$inserts);
					}
				}
			}

			if($result){
				echo "ok";
			}
			else{
				echo "no";
			}

		}
		else{

			//삭제
			if($this->input->get('recom_idx')){
				$result = $this->common_m->self_q("delete from dh_recom_food_table where recom_food_idx = '".$this->input->get('recom_idx')."' and recom_date = '".$this->input->get('date')."'","delete");
				alert($_SERVER['HTTP_REFERER']);
			}

			$data['date'] = $this->input->get('date');

			$data['query_string'] = "?";
			$where_query = " where 1 ";
			$in_sql = "";	//in 쿼리 작성용

			$recom_food_idx = $this->uri->segment(3);
			$data['recom_food_info'] = $this->common_m->self_q("select * from dh_recom_food where idx = '{$recom_food_idx}'","row");	//추천식단 기본정보

			$recom_food_cate = "";	//연동할 제품 카테고리
			$recom_food_cate_tmp = explode("^",substr($data['recom_food_info']->recom_cate,0,-1));	//연동할 제품 카테고리 unserialize
			foreach($recom_food_cate_tmp as $val){	//배열 쿼리형으로 변환
				$in_sql .= "'".$val."',";
			}
			$in_sql = substr($in_sql,0,-1);

			if($in_sql){
				$where_query .= " and cate_no in (".$in_sql.")";	//in 형식으로 전환
			}

			$data['totalCnt'] = $this->common_m->getPageList('dh_goods','count','','',$where_query); //total
			$data['list'] = $this->common_m->getPageList('dh_goods','','','',$where_query); //리스트 result

			//카테고리 정보 보여주기
			$data['page_title'] = date("Y년 m월 d일",strtotime($data['date']))." | ".$data['recom_food_info']->recom_name;

			//셀프 수정모드 확인
			$check_edit = array();
			$date_cnt = $this->common_m->self_q("select * from dh_recom_food_table where recom_food_idx = '{$recom_food_idx}' and recom_date = '".$data['date']."'","cnt");
			if($date_cnt > 0){
				$in_data = $this->common_m->self_q("select * from dh_recom_food_table where recom_food_idx = '{$recom_food_idx}' and recom_date = '".$data['date']."'","result");
				$check_cnt = 0;
				foreach($in_data as $id){
					$check_edit[$check_cnt] = $id->goods_idx;
					$check_cnt++;
				}
			}

			$data['edit_data'] = $check_edit;

			$this->load->view("/dhadm/product/recom_pop",$data);
		}

	}

	public function recom($data){	//추천식단 관리

		$data['mode'] = $mode = $this->uri->segment(4);
		$table = "dh_recom_food";

		if($mode == "add"){	//추천식단 등록

			if($_POST){	// insert

				$recom_info = explode("::",$this->input->post('recom_name'));

				$recom_cate_arr = $this->input->post('recom_cate');
				$inserts['recom_cate'] = "";
				foreach($recom_cate_arr as $rca){
					$inserts['recom_cate'] .= $rca."^";
				}

				$inserts['recom_name'] = $recom_info[1];
				$inserts['brand_idx'] = $recom_info[0];
				$inserts['food_info'] = serialize($this->input->post('food_info'));
				//$inserts['recom_cate'] = serialize($this->input->post('recom_cate'));
				$inserts['sort'] = $this->input->post('sort');
				$inserts['wdate'] = timenow();

				$result = $this->common_m->insert2($table,$inserts);
				if($result){
					alert(cdir()."/product/recom/m");
				}

			}

			$data['recom_select'] = $this->common_m->self_q("select * from dh_brand_cate where recom_use = 'Y' and idx not in (select brand_idx from dh_recom_food) order by sort asc","result");
			$data['recom_cate'] = $this->common_m->self_q("select * from dh_category where depth = '2' order by reg_date asc","result");
			$this->load->view("/dhadm/product/recom_input",$data);
		}

		else if($mode == "edit"){

			if($_POST){

				$recom_info = explode("::",$this->input->post('recom_name'));

				$recom_cate_arr = $this->input->post('recom_cate');
				$updates['recom_cate'] = "";
				foreach($recom_cate_arr as $rca){
					$updates['recom_cate'] .= $rca."^";
				}

				$updates['recom_name'] = $recom_info[1];
				$updates['brand_idx'] = $recom_info[0];
				$updates['food_info'] = serialize($this->input->post('food_info'));
				//$updates['recom_cate'] = serialize($this->input->post('recom_cate'));
				$updates['sort'] = $this->input->post('sort');
				$updates['udate'] = timenow();

				$where['idx'] = $this->input->post('idx');

				$result = $this->common_m->update2($table,$updates,$where);
				if($result){
					alert($_SERVER['HTTP_REFERER'],'수정되었습니다.');
				}

			}

			$idx = $this->uri->segment(5);
			$data['recom_select'] = $this->common_m->self_q("select * from dh_brand_cate where recom_use = 'Y' order by sort asc","result");
			$data['recom_cate'] = $this->common_m->self_q("select * from dh_category where depth = '2' order by reg_date asc","result");

			$data['row'] = $this->common_m->self_q("select * from {$table} where idx = '{$idx}'","row");
			$data['food_info'] = unserialize($data['row']->food_info);
			$data['un_recom_cate'] = explode("^",substr($data['row']->recom_cate,0,-1));
			$this->load->view("/dhadm/product/recom_input",$data);

		}

		else if($mode == "food_table"){

			$data['recom_food_idx'] = $recom_food_idx = $this->uri->segment(5);	//추천식단 테이블 dh_recom_food IDX
			$data['recom_food_info'] = $this->common_m->self_q("select * from dh_recom_food where idx = '{$recom_food_idx}'","row");	//추천식단 기본정보

			$year = $this->input->get("year");
			$month = $this->input->get("month");

			if (!$year) {
				$year	= date("Y");
				$month	= date("m");
			}

			$day = "";

			$data['FirstDayPosition']	= date("w",mktime(0,0,0,$month,1,$year)) + 1;
			$data['TotalDay']			= date("t", mktime(0, 0, 0, $month, 1, $year));

			$prev		= date("Y-m",mktime(0,0,0,$month-1,1,$year));
			$prevArray	= explode("-",$prev);
			$data['prevYear']	= $prevArray[0];
			$data['prevMonth']	= $prevArray[1];

			$next		= date("Y-m",mktime(0,0,0,$month+1,1,$year));
			$nextArray	= explode("-",$next);
			$data['nextYear']	= $nextArray[0];
			$data['nextMonth']	= $nextArray[1];

			$data['strDay'] = array("<span style='color:red;'>SUN</span>","MON","TUE","WED","THU","FRI","<span style='color:blue;'>SAT</span>");

			$data['year'] = $year;
			$data['month'] = $month;
			$data['day'] = $day;

			//해당 추천식단에 등록된 데이터가 있는지
			$data['list'] = $this->common_m->self_q("select *,(select name from dh_goods where idx = dh_recom_food_table.goods_idx) as goods_name,(select code from dh_goods where idx = dh_recom_food_table.goods_idx) as code from dh_recom_food_table where DATE_FORMAT(recom_date, '%Y-%m') = '".$year."-".$month."' and recom_food_idx = '{$recom_food_idx}' order by goods_name asc","result");
			$this->load->view('/dhadm/calendar/list',$data);

		}

		else{
			$data['list'] = $this->common_m->self_q("select * from {$table} order by sort asc","result");
			$cate_list = $this->common_m->self_q("select * from dh_category order by sort asc","result");
			$arr_cate = array();
			foreach($cate_list as $cl){
				$arr_cate[$cl->cate_no] = $cl->title;
			}

			$data['arr_cate'] = $arr_cate;

			$this->load->view("/dhadm/product/recom",$data);
		}
	}

	public function sub_info($data){

		$data['mode'] = $mode = $this->uri->segment(4);
		$table = "dh_subinfo";

		if($mode == "insert"){	//등록

			if($_POST){

				$config = array('upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/subinfo/','allowed_types' => '*','encrypt_name' => TRUE,'max_size' => '20000');
				$this->load->library('upload',$config);

				if($_FILES['detail']['size'] > 0){	//pc 상세보기
					if(!$this->upload->do_upload('detail')){
						back(strip_tags($this->upload->display_errors()));
					}
					else{
						$write_data = $this->upload->data();
						$inserts['detail'] = $write_data['file_name'];
						$inserts['detail_real'] = $_FILES['detail']['name'];
					}
				}

				if($_FILES['mobile_detail']['size'] > 0){	//모바일 상세보기
					if(!$this->upload->do_upload('mobile_detail')){
						back(strip_tags($this->upload->display_errors()));
					}
					else{
						$write_data = $this->upload->data();
						$inserts['mobile_detail'] = $write_data['file_name'];
						$inserts['mobile_detail_real'] = $_FILES['mobile_detail']['name'];
					}
				}

				if($_FILES['upfilem']['size'] > 0){	//모바일 상세보기
					if(!$this->upload->do_upload('upfilem')){
						back(strip_tags($this->upload->display_errors()));
					}
					else{
						$write_data = $this->upload->data();
						$inserts['upfilem'] = $write_data['file_name'];
						$inserts['upfilem_real'] = $_FILES['upfilem']['name'];
					}
				}

				for($ii=1;$ii<=7;$ii++){
					if($_FILES['upfile'.$ii]['size'] > 0){
						if(!$this->upload->do_upload('upfile'.$ii)){
							back(strip_tags($this->upload->display_errors()));
						}
						else{
							$write_data = $this->upload->data();
							$inserts['upfile'.$ii] = $write_data['file_name'];
							$inserts['upfile_real'.$ii] = $_FILES['upfile'.$ii]['name'];
						}
					}
				}

				$post_cate_no = $this->input->post("cate_no");
				$post_recom_idx = $this->input->post("recom_idx");

				if($post_cate_no){
					foreach($post_cate_no as $post_cate_no){
						@$inserts['cate_no'] .= $post_cate_no.",";
					}
				}

				if($post_recom_idx){
					foreach($post_recom_idx as $post_recom_idx){
						@$inserts['recom_idx'] .= $post_recom_idx.",";
					}
				}

				//$inserts['cate_no'] = serialize($this->input->post("cate_no", true));
				//$inserts['recom_idx'] = serialize($this->input->post("recom_idx", true));
				$inserts['moreview_use'] = $this->input->post("moreview_use", true);
				$inserts['foodtable_use'] = $this->input->post("foodtable_use", true);
				$inserts['title_b'] = $this->input->post("title_b", true);
				$inserts['title_m'] = $this->input->post("title_m", true);
				$inserts['title_s'] = $this->input->post("title_s", true);
				$inserts['bold_text'] = $this->input->post("bold_text", true);
				$inserts['info'] = $this->input->post("info");
				//$inserts['detail'] = $this->input->post("detail");
				$inserts['wdate'] = timenow();

				$result = $this->common_m->insert2($table,$inserts);
				if($result){
					result($result,"등록",cdir()."/product/sub_info/m");
				}

			}

			$lists = $this->common_m->self_q("select * from dh_subinfo","result");
			$cate_no_arr = array();
			$recom_idx_arr = array();
			foreach($lists as $lt){
				if($lt->cate_no){
					$db_cate_no = substr($lt->cate_no,0,-1);
					$db_cate_no = explode(",",$db_cate_no);
					foreach($db_cate_no as $dcn){
						$cate_no_arr[] = $dcn;
					}
				}

				if($lt->recom_idx){
					$db_recom_idx = substr($lt->recom_idx,0,-1);
					$db_recom_idx = explode(",",$db_recom_idx);
					foreach($db_recom_idx as $dri){
						$recom_idx_arr[] = $dri;
					}
				}
			}

			$data['cate_no_arr'] = $cate_no_arr;
			$data['recom_idx_arr'] = $recom_idx_arr;

			$data['cate_list'] = $this->common_m->self_q("select * from dh_category order by substr(cate_no,1,2) asc, sort asc","result");
			$data['recom_list'] = $this->common_m->self_q("select * from dh_recom_food order by sort asc","result");
			$this->load->view("/dhadm/product/subinfo_input",$data);
		}
		else if($mode == "update"){	//수정
			$idx = $this->uri->segment(5);

			if($_POST){

				$config = array('upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/subinfo/','allowed_types' => '*','encrypt_name' => TRUE,'max_size' => '20000');
				$this->load->library('upload',$config);

				//pc 상세보기
				if($_FILES['detail']['size'] > 0){
					if(!$this->upload->do_upload('detail')){
						back(strip_tags($this->upload->display_errors()));
					}
					else{
						if($this->input->post('old_detail')){
							@unlink($_SERVER['DOCUMENT_ROOT']."/_data/file/subinfo/".$this->input->post('old_detail'));
						}
						$write_data = $this->upload->data();
						$updates['detail'] = $write_data['file_name'];
						$updates['detail_real'] = $_FILES['detail']['name'];
					}
				}
				else{
					if($this->input->post('detail_del')){
						@unlink($_SERVER['DOCUMENT_ROOT']."/_data/file/subinfo/".$this->input->post('old_detail'));
						$updates['detail'] = "";
						$updates['detail_real'] = "";
					}
				}
				//pc 상세보기 종료

				//모바일 상세보기
				if($_FILES['mobile_detail']['size'] > 0){
					if(!$this->upload->do_upload('mobile_detail')){
						back(strip_tags($this->upload->display_errors()));
					}
					else{
						if($this->input->post('old_mobile_detail')){
							@unlink($_SERVER['DOCUMENT_ROOT']."/_data/file/subinfo/".$this->input->post('old_mobile_detail'));
						}
						$write_data = $this->upload->data();
						$updates['mobile_detail'] = $write_data['file_name'];
						$updates['mobile_detail_real'] = $_FILES['mobile_detail']['name'];
					}
				}
				else{
					if($this->input->post('mobile_detail_del')){
						@unlink($_SERVER['DOCUMENT_ROOT']."/_data/file/subinfo/".$this->input->post('old_mobile_detail'));
						$updates['mobile_detail'] = "";
						$updates['mobile_detail_real'] = "";
					}
				}
				//모바일 상세보기 종료

				//모바일전용 각 단계별 상단 이미지
				if($_FILES['upfilem']['size'] > 0){
					if(!$this->upload->do_upload('upfilem')){
						back(strip_tags($this->upload->display_errors()));
					}
					else{
						if($this->input->post('old_upfilem')){
							@unlink($_SERVER['DOCUMENT_ROOT']."/_data/file/subinfo/".$this->input->post('old_upfilem'));
						}
						$write_data = $this->upload->data();
						$updates['upfilem'] = $write_data['file_name'];
						$updates['upfilem_real'] = $_FILES['upfilem']['name'];
					}
				}
				else{
					if($this->input->post('upfilem_del')){
						@unlink($_SERVER['DOCUMENT_ROOT']."/_data/file/subinfo/".$this->input->post('old_upfilem'));
						$updates['upfilem'] = "";
						$updates['upfilem_real'] = "";
					}
				}
				//모바일전용 각 단계별 상단 이미지 종료

				for($ii=1;$ii<=7;$ii++){
					if($_FILES['upfile'.$ii]['size'] > 0){
						if(!$this->upload->do_upload('upfile'.$ii)){
							back(strip_tags($this->upload->display_errors()));
						}
						else{
							@unlink($_SERVER['DOCUMENT_ROOT']."/_data/file/subinfo/".$this->input->post('old_upfile'.$ii));
							$write_data = $this->upload->data();
							$updates['upfile'.$ii] = $write_data['file_name'];
							$updates['upfile_real'.$ii] = $_FILES['upfile'.$ii]['name'];
						}
					}
					else{
						if($this->input->post('upfile_del'.$ii)){
							@unlink($_SERVER['DOCUMENT_ROOT']."/_data/file/subinfo/".$this->input->post('old_upfile'.$ii));
							$updates['upfile'.$ii] = "";
							$updates['upfile_real'.$ii] = "";
						}
					}
				}

				$post_cate_no = $this->input->post("cate_no");
				$post_recom_idx = $this->input->post("recom_idx");

				if($post_cate_no){
					foreach($post_cate_no as $post_cate_no){
						@$updates['cate_no'] .= $post_cate_no.",";
					}
				}

				if($post_recom_idx){
					foreach($post_recom_idx as $post_recom_idx){
						@$updates['recom_idx'] .= $post_recom_idx.",";
					}
				}

				//$inserts['cate_no'] = serialize($this->input->post("cate_no", true));
				//$inserts['recom_idx'] = serialize($this->input->post("recom_idx", true));
				$updates['moreview_use'] = $this->input->post("moreview_use", true);
				$updates['foodtable_use'] = $this->input->post("foodtable_use", true);
				$updates['title_b'] = $this->input->post("title_b", true);
				$updates['title_m'] = $this->input->post("title_m", true);
				$updates['title_s'] = $this->input->post("title_s", true);
				$updates['bold_text'] = $this->input->post("bold_text", true);
				$updates['info'] = $this->input->post("info");
				//$updates['detail'] = $this->input->post("detail");
				$updates['udate'] = timenow();

				$where['idx'] = $this->input->post('idx');

				$result = $this->common_m->update2($table,$updates,$where);
				if($result){
					result($result,'수정',$_SERVER['HTTP_REFERER']);
				}

			}

			$data['row'] = $this->common_m->self_q("select * from dh_subinfo where idx = '{$idx}'","row");
			if($data['row']->cate_no){
				$cate_no = substr($data['row']->cate_no,0,-1);
				$cate_no = explode(",",$cate_no);
				foreach($cate_no as $ucna){
					$data['update_cate_no_arr'][] = $ucna;
				}
			}
			if($data['row']->recom_idx){
				$recom_idx = substr($data['row']->recom_idx,0,-1);
				$recom_idx = explode(",",$recom_idx);
				foreach($recom_idx as $uria){
					$data['update_recom_idx_arr'][] = $uria;
				}
			}

			$data['cate_list'] = $this->common_m->self_q("select * from dh_category order by substr(cate_no,1,2) asc, sort asc","result");
			$data['recom_list'] = $this->common_m->self_q("select * from dh_recom_food order by sort asc","result");
			$this->load->view("/dhadm/product/subinfo_input",$data);
		}
		else if($mode == "delete"){	//삭제
			$idx = $this->uri->segment(5);
			$row = $this->common_m->self_q("select * from {$table} where idx = '{$idx}'","row");
			for($ii=1;$ii<=5;$ii++){
				if($row->{'upfile'.$ii}){
					@unlink($_SERVER['DOCUMENT_ROOT']."/_data/file/subinfo/".$row->{'upfile'.$ii});
				}
			}
			$result = $this->common_m->del($table,'idx',$idx);
			if($result){
				alert($_SERVER['HTTP_REFERER']);
			}
		}
		else{

			//$cate_arr = array();
			//$recom_arr = array();

			$cate_list = $this->common_m->self_q("select * from dh_category","result");
			if($cate_list){
				foreach($cate_list as $lt_c){
					$cate_arr[$lt_c->cate_no] = $lt_c->title;
				}
			}

			$recom_list = $this->common_m->self_q("select * from dh_recom_food","result");
			if($recom_list){
				foreach($recom_list as $lt_r){
					$recom_arr[$lt_r->idx] = $lt_r->recom_name;
				}
			}

			$data['cate_arr'] = $cate_arr;
			$data['recom_arr'] = $recom_arr;
			$data['list'] = $this->common_m->self_q("select * from dh_subinfo order by idx asc","result");
			$this->load->view("/dhadm/product/subinfo",$data);
		}

	}

	public function holipop(){	//전체 배송 휴일 팝업
		$table = "dh_deliv_holi";
		$date = $this->input->get('date');

		if($_POST){

			$cnt = $this->common_m->self_q("select * from {$table} where holiday = '{$date}'","cnt");

			if($cnt){
				$updates['holiday_name'] = $this->input->post('holiday_name');
				$updates['regu'] = $this->input->post('regu');
				$updates['free'] = $this->input->post('free');
				$updates['samp'] = $this->input->post('samp');
				$updates['snhf'] = $this->input->post('snhf');
				$updates['type'] = $this->input->post('type');

				$where['holiday'] = $this->input->post('holiday');
				$result = $this->common_m->update2($table,$updates,$where);
			}
			else{
				$inserts['holiday'] = $this->input->post('holiday');
				$inserts['holiday_name'] = $this->input->post('holiday_name');
				$inserts['regu'] = $this->input->post('regu');
				$inserts['free'] = $this->input->post('free');
				$inserts['samp'] = $this->input->post('samp');
				$inserts['snhf'] = $this->input->post('snhf');
				$inserts['type'] = $this->input->post('type');
				$inserts['wdate'] = timenow();

				if($inserts['holiday_name']){
					$result = $this->common_m->insert2($table,$inserts);
				}
			}

			if($result){
				echo "ok";
			}
			else{
				echo "no";
			}

		}

		else{

			$data['row'] = $this->common_m->self_q("select * from {$table} where holiday = '{$date}'","row");
			$this->load->view('/dhadm/calendar/holi_pop',$data);

		}
	}

	public function holiday($data){

		$data['code'] = $this->uri->segment(2);

		if($this->input->get('date')){
			$this->common_m->self_q("delete from dh_deliv_holi where holiday = '".$this->input->get('date')."'","delete");
			alert($_SERVER['HTTP_REFERER']);
		}

		$year = $this->input->get("year");
		$month = $this->input->get("month");

		if (!$year) {
			$year	= date("Y");
			$month	= date("m");
		}

		$day = "";

		$data['FirstDayPosition']	= date("w",mktime(0,0,0,$month,1,$year)) + 1;
		$data['TotalDay']			= date("t", mktime(0, 0, 0, $month, 1, $year));

		$prev		= date("Y-m",mktime(0,0,0,$month-1,1,$year));
		$prevArray	= explode("-",$prev);
		$data['prevYear']	= $prevArray[0];
		$data['prevMonth']	= $prevArray[1];

		$next		= date("Y-m",mktime(0,0,0,$month+1,1,$year));
		$nextArray	= explode("-",$next);
		$data['nextYear']	= $nextArray[0];
		$data['nextMonth']	= $nextArray[1];

		$data['strDay'] = array("<span style='color:red;'>SUN</span>","MON","TUE","WED","THU","FRI","<span style='color:blue;'>SAT</span>");

		$data['year'] = $year;
		$data['month'] = $month;
		$data['day'] = $day;

		$data['list'] = $this->common_m->self_q("select * from dh_deliv_holi where DATE_FORMAT(holiday, '%Y-%m') = '".$year."-".$month."'","result");
		$this->load->view('/dhadm/calendar/list',$data);
	}

	public function set_page($data){

		if($_POST){
			$update_data['page1'] = $this->input->post('page1');
			$update_data['mpage1'] = $this->input->post('mpage1');
			$update_data['page31'] = $this->input->post('page31');
			$update_data['mpage31'] = $this->input->post('mpage31');
			$update_data['page32'] = $this->input->post('page32');
			$update_data['mpage32'] = $this->input->post('mpage32');
			$update_data['page41'] = $this->input->post('page41');
			$update_data['mpage41'] = $this->input->post('mpage41');
			$update_data['page42'] = $this->input->post('page42');
			$update_data['mpage42'] = $this->input->post('mpage42');
			$update_data['page51'] = $this->input->post('page51');
			$update_data['mpage51'] = $this->input->post('mpage51');
			$update_data['page52'] = $this->input->post('page52');
			$update_data['mpage52'] = $this->input->post('mpage52');
			$update_data['page61'] = $this->input->post('page61');
			$update_data['mpage61'] = $this->input->post('mpage61');
			$update_data['page62'] = $this->input->post('page62');
			$update_data['mpage62'] = $this->input->post('mpage62');
			$update_data['page7'] = $this->input->post('page7');
			$update_data['mpage7'] = $this->input->post('mpage7');
			$update_data['udate'] = timenow();

			$where['idx'] = 1;

			$result = $this->common_m->update2("dh_set_page",$update_data,$where);
			if($result){
				alert($_SERVER['HTTP_REFERER'],"저장 되었습니다.");
			}
		}

		$data['row'] = $this->common_m->self_q("select * from dh_set_page where idx = 1","row");
		$this->load->view("/dhadm/product/set_page",$data);
	}

}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */