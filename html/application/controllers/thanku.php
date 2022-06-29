<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Thanku extends CI_Controller {

 	function __construct()
	{
		parent::__construct();
    $this->load->model('admin_m');
		if(!$this->input->get('file_down')){
			ob_start();
			@header("Content-Type: text/html; charset=utf-8");
		}
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

	public function lists($data){

		$mode=$this->uri->segment(4);

		if($mode == 'del'){
			$idx = $this->uri->segment(5);
			$result = $this->common_m->self_q("delete from dh_thanku where idx = '{$idx}'","delete");
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

			$sql = "select * from dh_thanku {$where_sql}";

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

			$sql .= " order by idx desc limit {$offset},{$list_num}";

			$data['list'] = $this->common_m->self_q($sql,"result");

			$this->load->view("/dhadm/thanku/list",$data);
		}
	}

}


/* End of file welcome.php */
/* Location: ./application/controllers/welcome.php */