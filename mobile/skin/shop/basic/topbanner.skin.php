<?php
if (!defined("_GNUBOARD_")) exit; // 개별 페이지 접근 불가

// 커뮤니티 홈 상단 정적 배너 (모바일, 캐러셀 없음, 최대 3개 세로 스택)
?>
<div class="home_top_banner">
    <ul>
    <?php
    $bn_count = 0;
    while ($row = sql_fetch_array($result)) {
        if ($bn_count >= 3) break;

        $bimg = G5_DATA_PATH.'/banner/'.$row['bn_id'];
        if (!file_exists($bimg)) continue;

        $bn_count++;

        // 테두리 있는지
        $bn_border  = ($row['bn_border']) ? ' class="sbn_border"' : '';
        // 새창 띄우기인지
        $bn_new_win = ($row['bn_new_win']) ? ' target="_blank"' : '';

        $banner = '';
        if ($row['bn_url'][0] == '#')
            $banner .= '<a href="'.$row['bn_url'].'">';
        else if ($row['bn_url'] && $row['bn_url'] != 'http://')
            $banner .= '<a href="'.G5_SHOP_URL.'/bannerhit.php?bn_id='.$row['bn_id'].'"'.$bn_new_win.'>';

        echo '<li>'.PHP_EOL;
        echo $banner.'<img src="'.G5_DATA_URL.'/banner/'.$row['bn_id'].'?'.preg_replace('/[^0-9]/i', '', $row['bn_time']).'" alt="'.get_text($row['bn_alt']).'"'.$bn_border.'>';
        if ($banner) echo '</a>'.PHP_EOL;
        echo '</li>'.PHP_EOL;
    }
    ?>
    </ul>
</div>
<style>
.home_top_banner { margin: 0 0 15px; }
.home_top_banner ul { display: flex; flex-direction: column; gap: 10px; margin: 0; padding: 0; list-style: none; }
.home_top_banner li { width: 100%; }
.home_top_banner li img { width: 100%; height: auto; display: block; }
.home_top_banner .sbn_border { border: 1px solid #e5e5e5; box-sizing: border-box; }
</style>