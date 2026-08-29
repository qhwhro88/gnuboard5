<?php
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/tail.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/shop.tail.php');
    return;
}
?>

    </div>
    <div id="aside">
        <?php echo outlogin('theme/basic'); // 외부 로그인 ?>
        <div class="aside_box">
            <h3>공지사항</h3>
            <?php echo latest('theme/basic', 'notice', 5, 20); ?>
        </div>
        <div class="aside_box">
            <h3>바로가기</h3>
            <ul class="aside_qlink">
                <li><a href="<?php echo G5_BBS_URL ?>/faq.php">자주 묻는 질문(FAQ)</a></li>
                <li><a href="<?php echo get_pretty_url('content', 'company'); ?>">회사소개</a></li>
                <li><a href="<?php echo G5_BBS_URL ?>/qalist.php">1:1 문의</a></li>
            </ul>
        </div>
    </div>
</div>

</div>
<!-- } 콘텐츠 끝 -->

<hr>

<!-- 하단 시작 { -->
<div id="ft">

    <div id="ft_wr">
        <div id="ft_link" class="ft_cnt">
            <a href="<?php echo get_pretty_url('content', 'company'); ?>">회사소개</a>
            <a href="<?php echo get_pretty_url('content', 'privacy'); ?>">개인정보처리방침</a>
            <a href="<?php echo get_pretty_url('content', 'provision'); ?>">서비스이용약관</a>
            <a href="<?php echo get_device_change_url(); ?>">모바일버전</a>
        </div>
        <div id="ft_company" class="ft_cnt">
        	<h2>사이트 정보</h2>
	        <p class="ft_info">
	        	운영자 : 이우페이지 운영자<br>
				이메일 : admin@yiwupage.com<br>
				현재는 별도 법인(사업자) 등록이 이루어지지 않은 상태이며,<br>
				추후 등록이 완료되면 사업자 정보를 공지합니다.<br>
			</p>
	    </div>
        <?php
        //공지사항
        // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
        // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
        // 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
        echo latest('theme/notice', 'notice', 4, 13);
        ?>
        
		<?php echo visit('theme/basic'); // 접속자집계, 테마의 스킨을 사용하려면 스킨을 theme/basic 과 같이 지정 ?>
	</div>      
        <!-- <div id="ft_catch"><img src="<?php echo G5_IMG_URL; ?>/ft_logo.png" alt="<?php echo G5_VERSION ?>"></div> -->
        <div id="ft_copy">Copyright &copy; <b><?php echo $config['cf_title']; ?>.</b> All rights reserved.</div>
    
    
    <button type="button" id="top_btn">
    	<i class="fa fa-arrow-up" aria-hidden="true"></i><span class="sound_only">상단으로</span>
    </button>
    <script>
    $(function() {
        $("#top_btn").on("click", function() {
            $("html, body").animate({scrollTop:0}, '500');
            return false;
        });
    });
    </script>
</div>

<?php
if(G5_DEVICE_BUTTON_DISPLAY && !G5_IS_MOBILE) { ?>
<?php
}

if ($config['cf_analytics']) {
    echo $config['cf_analytics'];
}
?>

<!-- } 하단 끝 -->

<script>
$(function() {
    // 폰트 리사이즈 쿠키있으면 실행
    font_resize("container", get_cookie("ck_font_resize_rmv_class"), get_cookie("ck_font_resize_add_class"));
});
</script>

<?php
include_once(G5_THEME_PATH."/tail.sub.php");