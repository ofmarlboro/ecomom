<?php if ( ! defined('BASEPATH')) exit('No direct script access allowed');

class Banner2 extends CI_Controller {

 	function __construct()
	{
		parent::__construct();
    $this->load->model('banner_m2');
    $this->load->model('common_m');
    $this->load->model('admin_m');
		$this->load->helper('form');
		$this->m = $this->common_m;

		if(!$this->input->get('file_down')){
			ob_start();
			@header("Content-Type: text/html; charset=utf-8");
		}
	}

	public function index() //첫 화면 로딩시 로그인 화면 출력.
	{
		$this->group();
  }

	public function _remap($method) //모든 페이지에 적용되는 기본 설정.
	{
		$dev_arr = $this->common_m->adm_devel_array(); // 헤더와 풋터가 적용되지 않을 메소드 가져오기
		$arr = in_array($method, $dev_arr);


		if($this->input->get('d')){ //디자인 페이지 보기 - 디자인 페이지 이름 뒤에 ?d=1 넣으면 메소드 접근 안하고 페이지 이름으로 디자인 확인 가능

			$p = $this->uri->segment(2);
			$url = $this->common_m->get_page($p,'admin');
			$this->load->view($url);

		}else{

			if(!$arr && $this->input->get("ajax")!=1){ //해더 & 풋터가 적용되는 경우

				if(!$this->session->userdata('ADMIN_PASSWD') && !$this->session->userdata('ADMIN_USERID')){
					alert(cdir()."/dhadm/","관리자의 아이디와 패스워드가 올바르지 않습니다.");
				}

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

	public function group()
	{
		$data['mode'] = $this->uri->segment(4);
		$mode = $data['mode'];

		$data['idx'] = $this->uri->segment(5);
		$idx = $data['idx'];

		$data['code'] = $this->input->get("code",true);
		$code = $data['code'];
		$data['parent_idx'] = $this->input->get("parent_idx",true);
		$parent_idx = $data['parent_idx'];
		$data['s_idx'] = $this->input->get("s_idx",true);
		$s_idx = $data['s_idx'];

		if($parent_idx){
			$data['parent_info'] = $this->common_m->self_q("select * from dh_banner2 where idx = '".$parent_idx."'","row");
		}

		if($mode == "add"){
			if($this->input->post("code"))
			{
				$datas['name'] = $this->input->post("name",TRUE);
				$datas['code'] = $this->input->post("code",TRUE);
				$datas['pageurl'] = $this->input->post("pageurl",TRUE);
				$datas['used'] = $this->input->post("used",TRUE);
				$datas['sorting'] = $this->input->post("sorting",TRUE);

				$result = $this->banner_m2->insert($datas);
				result($result,"등록","/html/banner2/group/m/");
			}
			else
			{
				$this->load->view("/dhadm/banner2/input",$data);
			}
		}
		else if($mode == "edit"){
			if($this->input->post("code"))
			{
				if($this->input->post("pageurl",TRUE) == "show"){
					$dup = $this->common_m->self_q("select * from dh_banner2 where pageurl = 'show'","cnt");
					if($dup > 0){
						back("이미 노출중인 팝업이 있습니다.");
					}
				}

				$datas['name'] = $this->input->post("name",TRUE);
				$datas['pageurl'] = $this->input->post("pageurl",TRUE);
				$datas['used'] = $this->input->post("used",TRUE);
				$datas['idx'] = $this->input->post("idx",TRUE);
				$datas['sorting'] = $this->input->post("sorting",TRUE);

				$result = $this->banner_m2->update($datas);
				result($result,"수정","/html/banner2/group/m/");
			}
			else
			{
				$data['row'] = $this->banner_m2->getrow($idx);
				$this->load->view("/dhadm/banner2/input",$data);
			}
		}
		else if($mode == "del"){
			$data['del_list'] = $this->banner_m2->delist($idx);
			foreach($data['del_list'] as $dl)
			{
				$data['dlrow'] = $this->banner_m2->dlrow($dl->idx);
				@unlink($_SERVER['DOCUMENT_ROOT']."/_data/file/banner2/".$dl->upfile1);
				@unlink($_SERVER['DOCUMENT_ROOT']."/_data/file/banner2/".$dl->upfile2);
			}

			$result = $this->banner_m2->grpdel($idx);
			result($result,"배너그룹이 삭제","/html/banner2/group/m/");
		}
		else if($mode == "s_add"){

			if($this->input->post('form_cnt')){
				for($ii=1;$ii<=$this->input->post('form_cnt');$ii++){
					if($this->input->post('chk'.$ii)){
						$row = $this->common_m->self_q("select * from dh_bannerlist2 where idx = '".$this->input->post('chk'.$ii)."'","row");
						@unlink($_SERVER['DOCUMENT_ROOT'].'/_data/file/banner2/'.$row->upfile1);
						@unlink($_SERVER['DOCUMENT_ROOT'].'/_data/file/banner2/'.$row->upfile2);
						$result = $this->common_m->self_q("delete from dh_bannerlist2 where idx = '".$this->input->post('chk'.$ii)."'","delete");
					}
				}
				result($result,'삭제',$_SERVER['HTTP_REFERER']);
			}

			$data['parent_info'] = $this->common_m->self_q("select * from dh_banner2 where code = '".$code."'","row");
			$data['s_list'] = $this->banner_m2->s_list($code);

			$cate = $this->m->self_q("select * from dh_banner_cate","result");
			$cate_arr = array();
			foreach($cate as $cc){
				$cate_arr[$cc->idx] = $cc->name;
			}

			$data['cate'] = $cate_arr;

			$this->load->view("/dhadm/banner2/slist",$data);
		}
		else if($mode == "s_input"){
			if($this->input->post("code")){

				$upfile1 = "";
				$upfile2 = "";
				$upfile1_real = "";
				$upfile2_real = "";

				//첨부1
				if(isset($_FILES['upfile1']['name']) && $_FILES['upfile1']['size'] > 0){
					$config = array(
						'upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/banner2/',
						'allowed_types' => '*',
						'encrypt_name' => TRUE,
						'max_size' => '20000'
					);
					$this->load->library('upload',$config);
					if(!$this->upload->do_upload('upfile1')){
						back(strip_tags($this->upload->display_errors()));
					}
					else{
						$write_data = $this->upload->data();
						$upfile1	= $write_data['file_name'];
						$upfile1_real =	$_FILES['upfile1']['name'];
					}
				}
				//첨부2
				if(isset($_FILES['upfile2']['name']) && $_FILES['upfile2']['size'] > 0){
					$config = array(
						'upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/banner2/',
						'allowed_types' => '*',
						'encrypt_name' => TRUE,
						'max_size' => '20000'
					);
					$this->load->library('upload',$config);
					if(!$this->upload->do_upload('upfile2')){
						back(strip_tags($this->upload->display_errors()));
					}
					else{
						$write_data = $this->upload->data();
						$upfile2	= $write_data['file_name'];
						$upfile2_real =	$_FILES['upfile2']['name'];
					}
				}

				$datas['parent_idx'] = $this->input->post("parent_idx",true);
				$datas['parent_code'] = $this->input->post("code",true);
				$datas['upfile1'] = $upfile1;
				$datas['upfile2'] = $upfile2;
				$datas['upfile1_real'] = $upfile1_real;
				$datas['upfile2_real'] = $upfile2_real;
				$datas['pageurl'] = $this->input->post("pageurl",true);
				$datas['m_pageurl'] = $this->input->post("m_pageurl",true);
				$datas['pc_target'] = $this->input->post("pc_target",true);
				$datas['m_target'] = $this->input->post("m_target",true);
				$datas['sort'] = $this->input->post("sort",true);
				$datas['addinfo1'] = $this->input->post("addinfo1",true);
				$datas['addinfo2'] = $this->input->post("addinfo2",true);
				$datas['addinfo3'] = $this->input->post("addinfo3",true);
				$datas['addinfo4'] = $this->input->post("addinfo4",true);
				$datas['addinfo5'] = $this->input->post("addinfo5",true);

				$result = $this->banner_m2->sinsert($datas);

				result($result,"등록","/html/banner2/group/m/s_add/?code=".$this->input->post("code",true)."&parent_idx=".$this->input->post("parent_idx",true));

			}
			else{
				$max_rank = $this->common_m->self_q("select max(sort) as maxim from dh_bannerlist2 where parent_code = '".$code."'","row");
				$data['max_rank'] = $max_rank->maxim+1;

				$data['cate'] = $this->m->self_q("select * from dh_banner_cate order by ranking asc, idx desc","result");

				$this->load->view("/dhadm/banner2/sinput",$data);
			}
		}
		else if($mode == "s_edit"){

			$data['s_row'] = $this->banner_m2->s_row($s_idx);

			if($this->input->post("sidx")){

				$upfile1 = "";
				$upfile2 = "";
				$upfile1_real = "";
				$upfile2_real = "";

				//첨부1
				if(isset($_FILES['upfile1']['name']) && $_FILES['upfile1']['size'] > 0){
					$config = array(
						'upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/banner2/',
						'allowed_types' => '*',
						'encrypt_name' => TRUE,
						'max_size' => '20000'
					);
					$this->load->library('upload',$config);
					if(!$this->upload->do_upload('upfile1')){
						back(strip_tags($this->upload->display_errors()));
					}
					else{
						@unlink($_SERVER['DOCUMENT_ROOT'].'/_data/file/banner2/'.$data['s_row']->upfile1);
						$write_data = $this->upload->data();
						$upfile1	= $write_data['file_name'];
						$upfile1_real =	$_FILES['upfile1']['name'];
					}
				}
				else{
					if($this->input->post('upfile1_del')){
						@unlink($_SERVER['DOCUMENT_ROOT'].'/_data/file/banner2/'.$data['s_row']->upfile1);
						$upfile1	= "";
						$upfile1_real =	"";
					}
					else{
						$upfile1	= $data['s_row']->upfile1;
						$upfile1_real =	$data['s_row']->upfile1_real;
					}
				}

				//첨부2
				if(isset($_FILES['upfile2']['name']) && $_FILES['upfile2']['size'] > 0){
					$config = array(
						'upload_path' => $_SERVER['DOCUMENT_ROOT'].'/_data/file/banner2/',
						'allowed_types' => '*',
						'encrypt_name' => TRUE,
						'max_size' => '20000'
					);
					$this->load->library('upload',$config);
					if(!$this->upload->do_upload('upfile2')){
						back(strip_tags($this->upload->display_errors()));
					}
					else{
						@unlink($_SERVER['DOCUMENT_ROOT'].'/_data/file/banner2/'.$data['s_row']->upfile2);
						$write_data = $this->upload->data();
						$upfile2	= $write_data['file_name'];
						$upfile2_real =	$_FILES['upfile2']['name'];
					}
				}
				else{
					if($this->input->post('upfile2_del')){
						@unlink($_SERVER['DOCUMENT_ROOT'].'/_data/file/banner2/'.$data['s_row']->upfile2);
						$upfile2 = "";
						$upfile2_real = "";
					}
					else{
						$upfile2	= $data['s_row']->upfile2;
						$upfile2_real = $data['s_row']->upfile2_real;
					}
				}

				$datas['upfile1'] = $upfile1;
				$datas['upfile2'] = $upfile2;
				$datas['upfile1_real'] = $upfile1_real;
				$datas['upfile2_real'] = $upfile2_real;
				$datas['pageurl'] = $this->input->post("pageurl",true);
				$datas['m_pageurl'] = $this->input->post("m_pageurl",true);
				$datas['pc_target'] = $this->input->post("pc_target",true);
				$datas['m_target'] = $this->input->post("m_target",true);
				$datas['sort'] = $this->input->post("sort",true);
				$datas['addinfo1'] = $this->input->post("addinfo1",true);
				$datas['addinfo2'] = $this->input->post("addinfo2",true);
				$datas['addinfo3'] = $this->input->post("addinfo3",true);
				$datas['addinfo4'] = $this->input->post("addinfo4",true);
				$datas['addinfo5'] = $this->input->post("addinfo5",true);
				$datas['s_idx'] = $this->input->post("sidx",true);

				$result = $this->banner_m2->supdate($datas);
				result($result,"수정","/html/banner2/group/m/s_add/?code=".$data['s_row']->parent_code."&parent_idx=".$data['s_row']->parent_idx);

			}
			else{
				$data['cate'] = $this->m->self_q("select * from dh_banner_cate order by ranking asc, idx desc","result");
				$this->load->view("/dhadm/banner2/sinput",$data);
			}
		}
		else if($mode == "s_del"){
			$data['s_row'] = $this->banner_m2->s_row($s_idx);
			@unlink($_SERVER['DOCUMENT_ROOT'].'/_data/file/banner2/'.$data['s_row']->upfile1);
			@unlink($_SERVER['DOCUMENT_ROOT'].'/_data/file/banner2/'.$data['s_row']->upfile2);
			$result = $this->banner_m2->sdelete($s_idx);
			result($result,"삭제","/html/banner2/group/m/s_add/?code=".$data['s_row']->parent_code."&parent_idx=".$data['s_row']->parent_idx);
		}
		else{

			$data['list'] = $this->banner_m2->lists();
			$this->load->view("/dhadm/banner2/lists",$data);

		}
	}

	public function sel_pop(){
		$data['mode'] = $mode = $this->uri->segment(3);
		$data['chkval'] = $chkval = $this->input->get('chkval');
		$code = $this->input->get('code');

		if($_POST){

			$act_mode = $this->input->post('mode');
			$act_code_tmp = explode("@@",$this->input->post('act_code'));
			$act_code = $act_code_tmp[0];
			$act_code_idx = $act_code_tmp[1];
			$act_idx = substr($this->input->post('chkval'),0,-1);
			$table = "dh_bannerlist2";

			if($act_mode == "move"){	//이동
				$sql = "update {$table} set parent_code = '{$act_code}' where idx in ({$act_idx})";
				$result = $this->common_m->self_q($sql,"update");
			}
			else{	//복사
				$sql = "select * from {$table} where idx in ({$act_idx})";
				$list = $this->common_m->self_q($sql,"result");
				$insert_arr = "";
				foreach($list as $lt){
					foreach($lt as $k=>$v){
						if($k == "idx" or $k == "wdate" or $k == "udate" or $k == "upfile1" or $k == "upfile2" or $k == "parent_idx" or $k == "parent_code"){

						}
						else{
							$insert_arr[$k] = $v;
						}
					}

					$insert_arr['parent_idx'] = $act_code_idx;
					$insert_arr['parent_code'] = $act_code;

					$upfile1_tmp = explode(".",$lt->upfile1);
					$upfile2_tmp = explode(".",$lt->upfile2);

					$insert_arr['upfile1'] = md5("copy1".$lt->idx).".".$upfile1_tmp[sizeof($upfile1_tmp)-1];
					$insert_arr['upfile2'] = md5("copy2".$lt->idx).".".$upfile2_tmp[sizeof($upfile1_tmp)-1];
					$insert_arr['wdate'] = timenow();

					$file1 = $_SERVER['DOCUMENT_ROOT']."/_data/file/banner2/".$lt->upfile1;
					$file2 = $_SERVER['DOCUMENT_ROOT']."/_data/file/banner2/".$lt->upfile2;

					$new_file1 = $_SERVER['DOCUMENT_ROOT']."/_data/file/banner2/".$insert_arr['upfile1'];
					$new_file2 = $_SERVER['DOCUMENT_ROOT']."/_data/file/banner2/".$insert_arr['upfile2'];

					copy($file1, $new_file1);
					copy($file2, $new_file2);

					$result = $this->common_m->insert2($table,$insert_arr);
				}
			}

			if($result){
				$mode_name = $act_mode == "copy" ? "복사가" : "이동이" ;
				?>
				<script type="text/javascript">
				<!--
				alert('<?=$mode_name?> 완료 되었습니다.');
				opener.location.reload();
				self.close();
				//-->
				</script>
				<?php
			}

		}
		else{
			$data['list'] = $this->common_m->self_q("select * from dh_banner2 where code != '{$code}' order by idx asc","result");
			$this->load->view("/dhadm/banner2/sel_pop",$data);
		}
	}

	public function cate($data=''){

		$code = 'banner';
		$table = "dh_banner_cate";

		if($this->input->post('mm') == "w" && $this->input->post('name')){

			$in['name'] = $this->input->post('name',TRUE);
			$in['ranking'] = $this->input->post('ranking',TRUE);
			$in['register'] = timenow();

			$result = $this->common_m->insert2($table,$in);
			if($result){
				alert($_SERVER['HTTP_REFERER'],"등록 되었습니다.");
			}
		}

		else if($this->input->post('mm') == "e" && $this->input->post('name')){

			$up['name'] = $this->input->post('name',TRUE);
			$up['ranking'] = $this->input->post('ranking',TRUE);

			$where['idx'] = $this->input->post('idx',TRUE);

			$result = $this->common_m->update2($table,$up,$where);
			if($result){
				alert($_SERVER['HTTP_REFERER'],"수정 되었습니다.");
			}
		}

		else if($this->input->get('del') == "1"){

			$del_idx = $this->uri->segment(4);
			$result = $this->common_m->self_q("delete from {$table} where idx = '{$del_idx}'","delete");
			if($result){
				alert($_SERVER['HTTP_REFERER']);
			}

		}
		else{
			$data['list'] = $this->common_m->self_q("select * from {$table} order by ranking asc, idx desc","result");
			$this->load->view("/dhadm/banner2/cate",$data);
		}
	}
}
