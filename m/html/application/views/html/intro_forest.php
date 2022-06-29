<?
	$PageName = "K01";
	$SubName = "";
	include("../include/head.php");
	include("../include/header.php");
?>

<style>
    .img--style01 {
        display: block;
        margin: auto;
    }

    .intro__forest .forest__img {
        position: relative;
    }

    .intro__forest .scene04 .scene04__left {
        width: 50%;
        height: 32%;
        position: absolute;
        top: 34%;
        left: 0%;
    }

    .intro__forest .scene04 .scene04__right {
        width: 50%;
        height: 32%;
        position: absolute;
        top: 34%;
        right: 0%;
    }

    .intro__forest .btn__wrap {
        position: relative;
    }

    .intro__forest .forest__product .btn__wrap01 .btn01 {
        position: absolute;
        /* border: 1px solid #f00; */
        width: 13%;
        height: 6%;
        top: 5.5%;
        left: 5%;
    }

    .intro__forest .forest__product .btn__wrap02 .btn01 {
        position: absolute;
        /* border: 1px solid #f00; */
        width: 41%;
        height: 4%;
        bottom: 1%;
        right: 6%;
    }

    .intro__forest .forest__ingredient .btn__wrap01 .btn01 {
        position: absolute;
        /* border: 1px solid #f00; */
        width: 41%;
        height: 29%;
        top: 67%;
        right: 6%;
    }

    .intro__forest .forest__ingredient .btn__wrap02 .btn01 {
        position: absolute;
        /* border: 1px solid #f00; */
        width: 100%;
        height: 4.5%;
        left: 0;
        top: 21.2%;
    }

    .intro__forest .forest__ingredient .btn__wrap02 .btn02 {
        position: absolute;
        /* border: 1px solid #f00; */
        width: 100%;
        height: 4.5%;
        left: 0;
        top: 26.5%;
    }

    .intro__forest .forest__ingredient .btn__wrap02 .btn03 {
        position: absolute;
        /* border: 1px solid #f00; */
        width: 100%;
        height: 4.5%;
        left: 0;
        top: 31.8%;
    }

    .intro__forest .forest__ingredient .btn__wrap02 .btn04 {
        position: absolute;
        /* border: 1px solid #f00; */
        width: 100%;
        height: 4.5%;
        left: 0;
        top: 37.2%;
    }

    .intro__forest .forest__ingredient .btn__wrap02 .btn05 {
        position: absolute;
        /* border: 1px solid #f00; */
        width: 100%;
        height: 4.5%;
        left: 0;
        top: 42.6%;
    }

    .intro__forest .forest__ingredient .btn__wrap02 .btn06 {
        position: absolute;
        /* border: 1px solid #f00; */
        width: 100%;
        height: 4.5%;
        left: 0;
        top: 48%;
    }

    .intro__forest .forest__ingredient .btn__wrap02 .btn07 {
        position: absolute;
        /* border: 1px solid #f00; */
        width: 100%;
        height: 4.5%;
        left: 0;
        top: 53.4%;
    }

    .intro__forest .forest__ingredient #marker{
        position: absolute;
        width: 1px;
        left: 0;
        top: 85%;
    }


    .intro__forest .forest__ingredient .btn__wrap03 .btn01 {
        position: absolute;
        /* border: 1px solid #f00; */
        width: 41%;
        height: 6%;
        bottom: 2%;
        right: 9%;
    }

    .intro__forest .forest__ingredient .btn__wrap04 .btn01 {
        position: absolute;
        /* border: 1px solid #f00; */
        width: 14%;
        height: 7%;
        left: 5%;
        top: 5.5%;
    }

    .intro__forest .forest__ingredient,
    .intro__forest .forest__product {
        display: none;
    }

    .forest__popup {
        position: fixed;
        top: 35%;
        width: 90%;
        left: 50%;
        margin-left: -45%;
        height: 0;
        padding-top: 50%;
        overflow: hidden;
        z-index: 999999999;
        display: none;
        opacity: 0;
    }

    .forest__popup iframe {
        width: 100%;
        height: 100%;
        position: absolute;
        top: 0;
        left: 0;
    }

    .forest__popup--mask {
        position: fixed;
        top: 0;
        left: 0;
        width: 100%;
        height: 100vh;
        background-color: rgba(0, 0, 0, .7);
        z-index: 999999998;
        display: none;
        opacity: 0;
    }
</style>

<script>
    $(function () {
        var forest = $(".forest__img");
        var forestIMG = forest.find("img");

        forest.on("click", function () {

            if ($(this).hasClass("scene01")) {
                forestIMG.attr("src", "/m/image/sub/forest_img02.jpg");
                $(this).addClass("scene02");
                $(this).removeClass("scene01");
                $(window).scrollTop(0);
            } else if ($(this).hasClass("scene02")) {
                forestIMG.attr("src", "/m/image/sub/forest_img03.jpg");
                $(this).addClass("scene03");
                $(this).removeClass("scene02");
                $(window).scrollTop(0);
            } else if ($(this).hasClass("scene03")) {
                forestIMG.attr("src", "/m/image/sub/forest_img04.jpg");
                $(this).addClass("scene04");
                $(this).removeClass("scene03");
                $(window).scrollTop(0);
            }
        })

        $(".scene04__left").on("click", function () {
            forestIMG.attr("src", "/m/image/sub/forest_img04_1.jpg");
            setTimeout(function () {
                $(".forest__img").hide();
                $(".forest__product").show();
                $(window).scrollTop(0);
            }, 500)
        })

        $(".scene04__right").on("click", function () {
            forestIMG.attr("src", "/m/image/sub/forest_img04_2.jpg");

            setTimeout(function () {
                $(".forest__img").hide();
                $(".forest__ingredient").show();
                $(window).scrollTop(0);
            }, 500)
        })

        $(".forest__product .btn__wrap01 .btn01, .forest__ingredient .btn__wrap04 .btn01").on("click",
            function () {
                $(".forest__product").hide();
                $(".forest__ingredient").hide();
                $(".forest__img").show();
                forestIMG.attr("src", "/m/image/sub/forest_img04.jpg");
                $(window).scrollTop(0);
            })


        $(".forest__product .btn__wrap02 .btn01").on("click", function () {
            $(".forest__product").hide();
            $(".forest__ingredient").show();
            $(window).scrollTop(0);
        })

        $(".forest__ingredient .btn__wrap03 .btn01").on("click", function () {
            $(".forest__ingredient").hide();
            $(".forest__product").show();
            $(window).scrollTop(0);
        })

        var iframe = $(".forest__popup").find("iframe");
        var youtubeStr = "https://www.youtube.com/embed/";
        var close = $(".forest__popup--mask");

        $(".open__popup").on("click", function () {
            $(".forest__popup--mask, .forest__popup").show().stop().animate({
                opacity: 1
            }, 250);

            iframe.attr("src", youtubeStr + $(this).attr("data-link"));
        })

        close.on("click", function () {
            $(".forest__popup--mask, .forest__popup").stop().animate({
                opacity: 0
            }, {
                duration: 250,
                complete: function () {
                    $(this).hide();
                }
            });
        })
    })
</script>

<!--Container-->
<div id="container">
    <?include("../include/top_menu.php");?>

    <div class="intro__forest">
        <div class="forest__img scene01">
            <img src="/m/image/sub/forest_img01.jpg" alt="" class="img--style01">
            <div class="scene04__left"></div>
            <div class="scene04__right"></div>
        </div>

        <!-- 제조 -->
        <div class="forest__product">
            <div class="btn__wrap btn__wrap01">
                <img src="/m/image/sub/forest_img05_01.jpg" alt="" class="img--style01">
                <div class="btn01"></div>
            </div>
            <iframe width="100%" height="215" src="https://www.youtube.com/embed/Cel_cuCu210" frameborder="0"
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>

            <div class="btn__wrap btn__wrap02">
                <img src="/m/image/sub/forest_img05_02.jpg" alt="" class="img--style01">
                <div class="btn01"></div>
            </div>
        </div>
        <!-- $제조 -->

        <!-- 재료 -->
        <div class="forest__ingredient">
            <div class="btn__wrap btn__wrap04">
                <img src="/m/image/sub/forest_img06_01.jpg" alt="" class="img--style01">
                <div class="btn01"></div>
            </div>
            <div class="btn__wrap btn__wrap01">
                <img src="/m/image/sub/forest_img06_02.jpg" alt="" class="img--style01">
                <a class="btn01" href="#marker"></a>
            </div>

            <img src="/m/image/sub/forest_img06_03.jpg" alt="" class="img--style01">

            <div class="btn__wrap btn__wrap02">
                <img src="/m/image/sub/forest_img06_04_01.jpg" alt="" class="img--style01">
                <!-- 쌀눈 -->
                <div class="btn01 open__popup" data-link="hZlTWEIEYeE"></div>
                <!-- 용기 -->
                <div class="btn02 open__popup" data-link="M0MEjGQ9uJ0"></div>
                <!-- 이유식 -->
                <div class="btn03 open__popup" data-link="JbG_doGxofE"></div>
                <!-- 달고기 -->
                <div class="btn04 open__popup" data-link="OSoS9zgOofc"></div>
                <!-- 이유식회사 -->
                <div class="btn05 open__popup" data-link="_RC45HAI2rg"></div>
                <!-- 무항생제 한우 -->
                <div class="btn06 open__popup" data-link="-Id3zBwa6dQ"></div>
                <!-- 스티로폼 박스 -->
                <div class="btn07 open__popup" data-link="jTM7cPKcy7Q"></div>

                <div id="marker"></div>
            </div>
            <!-- 솔잎한우 -->
            <iframe width="100%" height="215" src="https://www.youtube.com/embed/xBErPuhCSvI" frameborder="0"
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>

            <!-- 남해달고기 -->
            <img src="/m/image/sub/forest_img06_04_02.jpg" alt="" class="img--style01">
            <iframe width="100%" height="215" src="https://www.youtube.com/embed/9s6SdgCU9fA" frameborder="0"
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>


            <!-- 유기농쌀 -->
            <img src="/m/image/sub/forest_img06_04_03.jpg" alt="" class="img--style01">
            <iframe width="100%" height="215" src="https://www.youtube.com/embed/127EuDbNkkQ" frameborder="0"
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>

            <!-- 산골텃밭 -->
            <img src="/m/image/sub/forest_img06_04_04.jpg" alt="" class="img--style01">
            <iframe width="100%" height="215" src="https://www.youtube.com/embed/bnKXmOxPMY8" frameborder="0"
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>

            <!-- 유정란 -->
            <img src="/m/image/sub/forest_img06_04_05.jpg" alt="" class="img--style01">
            <iframe width="100%" height="215" src="https://www.youtube.com/embed/69mwjst3gF4" frameborder="0"
                allow="accelerometer; autoplay; encrypted-media; gyroscope; picture-in-picture"
                allowfullscreen></iframe>


            <img src="/m/image/sub/forest_img06_05.jpg" alt="" class="img--style01">


            <div class="btn__wrap btn__wrap03">
                <img src="/m/image/sub/forest_img06_06.jpg" alt="" class="img--style01">
                <div class="btn01"></div>
            </div>
        </div>
        <!-- $재료 -->

        <!-- 유튜브 팝업 -->
        <div class="forest__popup">
            <iframe src="" frameborder="0"></iframe>
        </div>
        <div class="forest__popup--mask"></div>
        <!-- $유튜브 팝업 -->

    </div>
</div>
<?include("../include/footer.php");?>