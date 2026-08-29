<?php
if (!defined('_INDEX_')) define('_INDEX_', true);
if (!defined('_GNUBOARD_')) exit; // 개별 페이지 접근 불가

if (G5_IS_MOBILE) {
    include_once(G5_THEME_MOBILE_PATH.'/index.php');
    return;
}

if(G5_COMMUNITY_USE === false) {
    include_once(G5_THEME_SHOP_PATH.'/index.php');
    return;
}

include_once(G5_THEME_PATH.'/head.php');
?>

<!-- 홈 히어로(웰컴) -->
<section id="home_hero">
    <h2>이우페이지</h2>
    <p class="home_hero_sub">중국 이우 시장 정보와 무역 커뮤니티</p>
    <p class="home_hero_desc">푸텐시장·황웬복장시장 안내, 기업홍보, 재고판매,<br>구인·구직·인재 채용 정보를 제공합니다.</p>
    <div class="home_hero_btn">
        <a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=futian1" class="btn_primary">중국시장</a>
        <a href="<?php echo G5_BBS_URL ?>/board.php?bo_table=stock" class="btn_second">재고판매</a>
    </div>
</section>

<?php
// 커뮤니티 홈 상단 정적 배너 (최대 3개 병렬, 각 390×130)
display_banner('커뮤니티', 'topbanner.skin.php');
?>

<h2 class="sound_only">최신글</h2>

<div class="latest_top_wr">
    <?php
    // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
    // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
    // 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
    echo latest('theme/pic_list', 'promotion', 4, 23);	// 기업홍보
	echo latest('theme/pic_list', 'stock', 4, 23);			// 재고판매
	echo latest('theme/pic_list', 'futian1', 4, 23);		// 푸텐시장 1기
    ?>
</div>
<div class="latest_wr">
    <!-- 사진 최신글2 { -->
    <?php
    // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
    // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
    // 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
    echo latest('theme/pic_block', 'huangyuan', 4, 23);		// 황웬복장시장
    ?>
    <!-- } 사진 최신글2 끝 -->
</div>

<div class="latest_wr">
<!-- 최신글 시작 { -->
    <?php
    //  최신글
    $sql = " select bo_table
                from `{$g5['board_table']}` a left join `{$g5['group_table']}` b on (a.gr_id=b.gr_id)
                where a.bo_device <> 'mobile' ";
    if(!$is_admin)
	$sql .= " and a.bo_use_cert = '' ";
    $sql .= " and a.bo_table not in ('promotion', 'stock', 'futian1', 'huangyuan') ";     //상단 최신글에 노출된 게시판은 제외
    $sql .= " order by b.gr_order, a.bo_order ";
    $result = sql_query($sql);
    for ($i=0; $row=sql_fetch_array($result); $i++) {
		$lt_style = '';
    	if ($i%3 !== 0 ) $lt_style = "margin-left:2%";
    ?>
    <div style="float:left;<?php echo $lt_style ?>" class="lt_wr">
        <?php
        // 이 함수가 바로 최신글을 추출하는 역할을 합니다.
        // 사용방법 : latest(스킨, 게시판아이디, 출력라인, 글자수);
        // 테마의 스킨을 사용하려면 theme/basic 과 같이 지정
        echo latest('theme/basic', $row['bo_table'], 6, 24);
        ?>
    </div>
    <?php
    }
    ?>
    <!-- } 최신글 끝 -->
</div>

<?php
include_once(G5_THEME_PATH.'/tail.php');