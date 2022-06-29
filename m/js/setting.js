
jQuery(document).ready(function($){
	//기본클래스 세팅
	$("html").addClass(browser);

	if (browser != "ie")
	{
		$("html").addClass("no-ie");
	} else {
		$("html").addClass("ie").attr("data-ie-ver", ieVer);
	}
	if (isMobile())	{ $("html").addClass("device");}
	else {$("html").addClass("desktop");}


	//게시판
	boardSetting();

	//댓글숨김옵션
	hideCommentSet(false);
});

//게시판 기본세팅
function boardSetting(){
	//faq slider
	$(".faq-q").on("click", function(){
		var $q = $(this);
		var $ct = $(this).next(".faq-a");
		$(".faq-a").not($ct).slideUp('fast', function(){
			$(".faq-q").not($q).removeClass("on");
		});
		$q.toggleClass("on");
		$ct.stop().slideToggle('fast');
	});

	//editor 사용자 등록 강제 스타일링
	$(".u-editor").each(function(){
		$(this).find("img").removeAttr("width height style");
		$(this).find("link").remove();
		$(this).find("iframe").each(function(){
			$(this).wrapAll("<div class='editor-vod'></div>");
		});

		//게시글 텍스트 스타일에 color가 들어갈 경우 없앰. (컨텐츠 배경이 어두운 경우 등 특수한 디자인에서 사용)
		/*$(this).find("*").each(function(){
			var st = $(this).attr("style") || "";
			if (st!="")
			{
				var temp1 = st.split("color:");
				var temp2 = temp1.length > 1 ? temp1[1].split(";") : ["",""];
				var newSt = temp1[0] + temp2[1];
				$(this).attr("style", newSt);
			}
			
		});*/
	});
}
//게시판 댓글 숨길경우
function hideCommentSet(toggle){
	
	if (toggle)
	{
		//댓글 리스트 토글
		$(".cmt-tit").on("click", function(){
			$(".comment-view").toggle();
		});
		//대댓글 작성 토글
		$(".write-cofc").on("click", function(){
			$(this).closest("li").find(".comment-write").toggle();
		});
		//대댓글 리스트 토글
		$(".view-cofc").on("click", function(){
			$(this).closest("li").find(".cmt-of-cmt").toggle();
		});
		
		$(".comment-view").hide();
	}
}

var ieVer = (function (){
 //   if (window.ActiveXObject === undefined) return null;
    if (!document.querySelector) return 7;
    if (!document.addEventListener) return 8;
    if (!window.atob) return 9;
    if (!document.__proto__) return 10;
    return 11;
})();

var browser = (function(){
	if(navigator.userAgent.indexOf("Edge") != -1 ) return 'ie-edge';
	else if(navigator.userAgent.indexOf("Chrome") != -1 ) return 'chrome';
    else if(navigator.userAgent.indexOf("Opera") != -1 ) return 'opera';
    else if(navigator.userAgent.indexOf("Firefox") != -1 ) return 'firefox';
    else if((navigator.userAgent.indexOf("MSIE") != -1 ) || (!!document.documentMode == true )) return 'ie'; /*IF IE > 10*/
    else return 'unknown';
})();

var isResponsiveWeb = (function(){

	if (ieVer < 9) {
		return false;
	} else {
		return true;
	}
})();

function isMobile(){
	if(navigator.userAgent.match(/Android/i) || navigator.userAgent.match(/BlackBerry/i) || navigator.userAgent.match(/iPhone|iPad|iPod/i) || navigator.userAgent.match(/IEMobile/i)) return true;
    return false;
}
