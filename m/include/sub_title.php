<!-- 각 메인/서브 메뉴 타이틀명 -->

<?
	class PageInfo {
		function __construct($src='', $name='', $engName=''){
			$this->url = $src;
			$this->tit = $name;
			$this->eng = $engName;
		}
	};

	//메뉴링크, 메뉴명 정의(영문명이 없을 시 적지 않아도 됨)
	$HOME = new PageInfo('/');

	$K01 = new PageInfo(cdir()."/dh/intro", '산골이유식 소개');
		$K0101 = new PageInfo(cdir().'/dh/intro', '산골이유식 소개');
		$K0102 = new PageInfo(cdir().'/dh/intro_receipe', '산골책 소개');
		$K0103 = new PageInfo(cdir().'/dh/intro000', '매장 소개');
		$K0104 = new PageInfo(cdir().'/dh/intro_pop', '산골간식 롯데마트');
		$K0105 = new PageInfo(cdir().'/dh/intro_forest', '숲속공장 영상 소개');

	$K02 = new PageInfo(cdir()."/dh/regular01", '이유식');
		$K0201 = new PageInfo(cdir()."/dh/bfood_order_regular1", '영양식단 <span>정기배송</span>');
		$K0202 = new PageInfo(cdir()."/dh/bfood_order_free1", '낱개주문 <span>자유배송</span>');
		$K0203 = new PageInfo(cdir()."/dh/sale_list", '둥이상품세트');
		$K0204 = new PageInfo(cdir()."/dh_board/views/50517", '선착순 샘플증정');
		$K0205 = new PageInfo(cdir()."/dh_product/prod_list?cate_no=10", '신규고객 의기양양픽');
		$K0206 = new PageInfo(cdir()."/dh/preview", '산골 맛보기 특가세트');
		$K0207 = new PageInfo(cdir().'/dh_product/prod_view/1321', '실온이유식 특가세트 (제주도배송)');
		$K0208 = new PageInfo(cdir().'/dh_product/prod_view/1312', '산골 상품권');

	$K03 = new PageInfo(cdir()."/dh/regular01/?recom_idx=3", '반찬/국');
		$K0301 = new PageInfo(cdir()."/dh/regular01/?recom_idx=3", '영양식단 <span>정기배송</span>');
		$K0302 = new PageInfo(cdir()."/dh/free_list/?cate_no=2-12", '낱개주문 <span>자유배송</span>');
		$K0303 = new PageInfo(cdir()."/dh/free_list/?cate_no=2-13", '낱개주문 <span>자유배송</span>');

	$K04 = new PageInfo(cdir()."/dh_product/prod_list?cate_no=3", '산골간식');
		$K0401 = new PageInfo(cdir().'/dh_product/prod_view/56?&cate_no=3', '산골쌀참');
		$K0402 = new PageInfo(cdir().'/dh_product/prod_view/56?&cate_no=3', '산골과일참');
		$K0403 = new PageInfo(cdir().'/dh_product/prod_view/56?&cate_no=3', '산골알밤');
		$K0404 = new PageInfo(cdir().'/dh_product/prod_view/56?&cate_no=3', '산골곶감');
		$K0405 = new PageInfo(cdir().'/dh_product/prod_view/218?&cate_no=3', '산골도라지배즙');

	$K05 = new PageInfo(cdir()."/dh_product/prod_list?cate_no=4", '건강식품');
		$K0501 = new PageInfo(cdir()."/dh_product/prod_list?cate_no=4", '건강식품');

	$K06 = new PageInfo(cdir()."/dh/farmer_list", '오!산골농부');
		//$K0601 = new PageInfo(cdir().'/dh/farmer_list01', '평사리들판햅쌀');
		$K0601 = new PageInfo(cdir().'/dh_product/prod_view/485?&cate_no=5', '평사리들판햅쌀');
		$K0602 = new PageInfo(cdir().'/dh/farmer_list02', '솔잎한우');
		$K0603 = new PageInfo('http://ecomommeal.co.kr/m/html/dh_product/prod_view/449?&cate_no=5', '하동햇배');
		$K0604 = new PageInfo(cdir().'/dh/farmer_list04', '고로쇠물');
		$K0605 = new PageInfo('http://www.ecomommeal.co.kr/html/dh_product/prod_view/505?&cate_no=5 ', '지리산첫봄미나리');

	$K07 = new PageInfo(cdir()."/dh/event", '이벤트');
		$K0701 = new PageInfo(cdir()."/dh/event", '이벤트 소개');
		$K0702 = new PageInfo(cdir()."/dh/event02", '인스타 리얼후기');
		$K0703 = new PageInfo(cdir()."/dh/event03", '첫인연 이벤트');
		$K0704 = new PageInfo(cdir().'/dh_product/prod_list/?cate_no=3&type=nmk', '산골야시장');
		$K0705 = new PageInfo(cdir().'/dh/event04', '상품권 등록');
		$K0706 = new PageInfo(cdir().'/dh/thankyou', '땡큐포인트 혜택안내');

	$K08 = new PageInfo(cdir()."/dh_member/mypage_idx", '고객과 함께');
		$K0801 = new PageInfo(cdir()."/dh_board/lists/withcons01", '산골알림장');
		$K0802 = new PageInfo(cdir()."/dh/withcons02", '산골먹방 후기');
		$K0803 = new PageInfo(cdir()."/dh/withcons03", '이유식공부하기');
		$K0804 = new PageInfo(cdir()."/dh/withcons04", '회원등급별혜택');
		$K0805 = new PageInfo(cdir()."/dh/withcons05", '주문/결제 안내');
		$K08052 = new PageInfo(cdir()."/dh/withcons052", '[필독]이용안내');
		$K0806 = new PageInfo(cdir()."/dh_board/lists/withcons06", '자주묻는질문');
		$K0807 = new PageInfo(cdir()."/dh_board/lists/withcons07?myqna=Y", '1:1문의');
		$K0808 = new PageInfo(cdir()."/dh/deposit", '예치금 안내');

$K080301 = new PageInfo(cdir().'/dh/wc01', '이유식은 어떻게 시작할까요');
$K080302 = new PageInfo(cdir().'/dh/wc02', '이럴땐 이렇게');
$K080303 = new PageInfo(cdir().'/dh/wc03', '좋은 재료가 기본입니다');
$K080304 = new PageInfo(cdir().'/dh_board/lists/wc04', '에코맘 재료 실명제');
$K080305 = new PageInfo(cdir().'/dh/wc05', '초보엄마 이유식 수업');
$K08030501 = new PageInfo(cdir().'/dh/wc05_01', '초보엄마 이유식 수업');

$K080306 = new PageInfo(cdir().'/dh/wc06', 'SNS 친구맺기');

$K09 = new PageInfo(cdir().'/dh/info01', '이용약관');
		$K0901 = new PageInfo(cdir().'/dh/info01', '이용약관');
		$K0902 = new PageInfo(cdir().'/dh/info02', '개인정보취급방침');

	//shop & member
	//left second layer
	$SHOP_CART = new PageInfo(cdir()."/dh_order/shop_cart","장바구니");
	$ORDERLIST = new PageInfo(cdir().'/dh_order/orderList', '주문내역');	//주문배송조회, mypage_idx, header
	$POINT = new PageInfo(cdir().'/dh_order/point', '보유포인트');
	$DEPOSIT = new PageInfo(cdir().'/dh_order/point', '예치금');
	$COUPON = new PageInfo(cdir().'/dh_order/coupon', '보유쿠폰');
	$MYPAGE = new PageInfo(cdir().'/dh_member/mypage', '회원정보수정');
	$MYPAGE_IDX = new PageInfo(cdir().'/dh_member/mypage_idx', '[주문변경]마이페이지');

	$JOIN = new PageInfo(cdir()."/dh_member/join","회원가입");
	$LOGIN = new PageInfo(cdir()."/dh_member/login","로그인");
	$INTE = new PageInfo(cdir().'/dh/identity","회원 아이디 통합', '회원 아이디 통합 페이지입니다.');

	$ORDER_EDIT = new PageInfo(cdir().'/dh_order/order_edit', '배송지 변경');
	$ORDER_EDIT02 = new PageInfo(cdir().'/dh_order/order_edit02', '메뉴 변경');
	$ORDER_EDIT03 = new PageInfo(cdir().'/dh_order/order_edit03', '배송일 변경');
	$ORDER_EDIT04 = new PageInfo(cdir().'/dh_order/order_edit04', '배송 일시정지/재시작');
	$ORDER_EDIT05 = new PageInfo(cdir().'/dh_order/order_edit05', '배송 몰아받기');

	$RCMD = new PageInfo(cdir().'/dh/rcmd', '추천인 정보');
	$ADRS = new PageInfo(cdir().'/dh/adrs_adm', '배송지 관리');
	$LEAVE = new PageInfo(cdir().'/dh_member/leave', '회원 탈퇴');

	//$EVENT = new PageInfo(cdir().'/dh/event', '이벤트');
	$FOOD_SCH = new PageInfo(cdir().'/dh/food_sch', '식단표');

	$PRO_VIEW = new PageInfo(cdir().'/dh/pro_view', '이유식');
	$FREE_PAY = new PageInfo(cdir().'/dh/free_pay', '낱개주문(자유배송)');
	$REGULAR_PAY = new PageInfo(cdir().'/dh/regular_pay', '영양식단(정기배송)');
	$FREE_DATE = new PageInfo(cdir().'/dh/free_date', '낱개주문(자유배송)');
	$FREE_SELECT = new PageInfo(cdir().'/dh/free_select', '낱개주문(자유배송)');
	$FREE_LIST = new PageInfo(cdir().'/dh/free_list', '낱개주문(자유배송)');
	$SAMPLE_ORDER = new PageInfo(cdir().'/dh/sample_order', '샘플신청');
	$REGULAR01 = new PageInfo(cdir().'/dh/regular01', '영양식단(정기배송)');
	$SALE_LIST = new PageInfo(cdir().'/dh/sale_list', '둥이상품세트');
	$SALE_PAY = new PageInfo(cdir().'/dh/sale_pay', '특가상품(세트상품)');

	$DESSERT_LIST = new PageInfo(cdir().'/dh/dessert_list', '산골간식');
	$DESSERT_VIEW = new PageInfo(cdir().'/dh/dessert_view', '산골간식');











?>