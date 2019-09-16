<?php

$days = 365;
$pack_price = 3.5;
$count_ttl = 0;

$time_per_cig = 300;

for ($i = 0; $i < $days; $i++) {

    $present_day = date('N', strtotime("+ $i days"));

    if ($present_day <= 5) {
        $cigs_mon_fri = rand(3, 4);
        $count_ttl += $cigs_mon_fri;
    } elseif ($present_day == 6) {
        $cigs_sat = rand(10, 20);
        $count_ttl += $cigs_sat;
    } else {
        $cigs_sun = rand(1, 5);
        $count_ttl += $cigs_sun;
    }
}


// #5 task part:
$price_ttl = $count_ttl / 20 * $pack_price;
$h2_text = "Per $days dienas, surūkysiu $count_ttl cigarečių už $price_ttl eur.";

// #7 task part
$time_in_seconds = $count_ttl * $time_per_cig;
//$time_total = gmdate("H:i:s", $time_in_seconds);
$seconds = $time_in_seconds;
$hours = floor($seconds / 3600);
$seconds -= $hours * 3600;
$minutes = floor($seconds / 60);
$seconds -= $minutes * 60;
$time_total = "$hours:$minutes:$seconds";

$h3_text = "Is viso traukdamas prastovesiu $time_total valandu";

?>
<html>
    <head>
        <meta charset="utf-8">
    </head>
    <style>
        .img {
            background-image: url(https://fizzynora.com/102/cigarette_png/cigarette_png_97.png);
            background-size: cover;
            height: 40px;
            width: 40px;
        }

        div {
            display: inline-block;
        }
    </style>
    <body>
        <h1>Dumu skaiciuokle</h1>
        <h2><?php print $h2_text; ?></h2>
        <h3><?php print $h3_text; ?></h3> 
        <div class="container">
            <?php for ($x = 0; $x < $count_ttl; $x++): ?>
                <img class="img"/>
            <?php endfor; ?>
        </div>
    </body>
</html>