<?php
include './veritabani.php';
mysql_set_charset('utf8mb4');

$gelen_channel_id = (string) @(htmlspecialchars($_GET['channel_id']));
$gelen_channel_adi = mysql_query("SELECT adi FROM `ozel_channel_depo` WHERE channel_id ='$gelen_channel_id' LIMIT 1");
$r_adi = mysql_fetch_assoc($gelen_channel_adi);
$gelen_channel_adi = $r_adi['adi'];

if ($cekilecek_miktar = @($_GET['cek'])) {
    if (10 == (int) $_GET['cek'] || 20 == (int) $_GET['cek'] || 30 == (int) $_GET['cek'] || 40 == (int) $_GET['cek']) {
        $cekilecek_miktar = $_GET['cek'];
    } else {
        $cekilecek_miktar = 20;
    }
} else {
    $cekilecek_miktar = 20;
}


//görüntülenme sayisi

$sth = mysql_query("SELECT MAX(goruntulenme_sayisi) FROM `ozel_video_depo` WHERE channel_id ='$gelen_channel_id' GROUP BY video_id ORDER BY MAX(goruntulenme_sayisi) DESC LIMIT 0,$cekilecek_miktar");
$flag = true;
$table = array();
$table['cols'] = array(
    array('label' => 'id', 'type' => 'string'),
    array('label' => 'izlenme sayısı', 'type' => 'number')
);
$rows = array();
$sayac = 0;
while ($r = mysql_fetch_assoc($sth)) {
    $temp = array();
//    $degisken = (string) $r['adi'];
//    $degisken = ( ++$sayac) . " - " . substr($degisken, 0, 8) . "...";
//    $temp[] = array('v' => (string) $degisken);
    $temp[] = array('v' => (string) ++$sayac);
    $temp[] = array('v' => (int) $r['MAX(goruntulenme_sayisi)']);
    $rows[] = array('c' => $temp);
}
$table['rows'] = $rows;
$jsonTable = json_encode($table);

//görüntülenme sayisi_t
$sth_t = mysql_query("SELECT video_id,adi,MAX(goruntulenme_sayisi),like_sayisi,dislike_sayisi,toplam_yorum_sayisi,yukleme_tarihi FROM `ozel_video_depo` WHERE channel_id ='$gelen_channel_id' GROUP BY video_id ORDER BY MAX(goruntulenme_sayisi) DESC LIMIT 0,$cekilecek_miktar");
$flag_t = true;
$table_t = array();
$table_t['cols'] = array(
    array('label' => 'video_id', 'type' => 'string'),
    array('label' => 'adı', 'type' => 'string'),
    array('label' => 'izlenme', 'type' => 'number'),
    array('label' => 'beğenme', 'type' => 'number'),
    array('label' => 'beğenmeme', 'type' => 'number'),
    array('label' => 'yorum', 'type' => 'number'),
    array('label' => 'yüklenme', 'type' => 'string')
);
$rows_t = array();
$sayac_t = 0;
while ($r_t = mysql_fetch_assoc($sth_t)) {
    $temp_t = array();
    $temp_t[] = array('v' => (string) $r_t['video_id']);
    $temp_t[] = array('v' => (string) $r_t['adi']);
    $temp_t[] = array('v' => (int) $r_t['MAX(goruntulenme_sayisi)']);
    $temp_t[] = array('v' => (int) $r_t['like_sayisi']);
    $temp_t[] = array('v' => (int) $r_t['dislike_sayisi']);
    $temp_t[] = array('v' => (int) $r_t['toplam_yorum_sayisi']);
    $temp_t[] = array('v' => (string) $r_t['yukleme_tarihi']);
    $rows_t[] = array('c' => $temp_t);
}
$table_t['rows'] = $rows_t;
$jsonTable_t = json_encode($table_t);


//like sayisi

$sth1 = mysql_query("SELECT MAX(like_sayisi),dislike_sayisi FROM `ozel_video_depo` WHERE channel_id ='$gelen_channel_id' GROUP BY video_id ORDER BY MAX(like_sayisi) DESC LIMIT 0,$cekilecek_miktar");
$flag1 = true;
$table1 = array();
$table1['cols'] = array(
    array('label' => 'id', 'type' => 'string'),
    array('label' => 'beğenme sayısı', 'type' => 'number'),
    array('label' => 'beğenmeme sayısı', 'type' => 'number')
);
$rows1 = array();
$sayac1 = 0;
while ($r1 = mysql_fetch_assoc($sth1)) {
    $temp1 = array();
//    $degisken1 = (string) $r1['adi'];
//    $degisken1 = ( ++$sayac1) . " - " . substr($degisken1, 0, 8) . "...";
//    $temp1[] = array('v' => (string) $degisken1);
    $temp1[] = array('v' => (string) ++$sayac1);
    $temp1[] = array('v' => (int) $r1['MAX(like_sayisi)']);
    $temp1[] = array('v' => (int) $r1['dislike_sayisi']);
    $rows1[] = array('c' => $temp1);
}
$table1['rows'] = $rows1;
$jsonTable1 = json_encode($table1);

//like sayisi_t

$sth1_t = mysql_query("SELECT video_id,adi,goruntulenme_sayisi,MAX(like_sayisi),dislike_sayisi,toplam_yorum_sayisi,yukleme_tarihi FROM `ozel_video_depo` WHERE channel_id ='$gelen_channel_id' GROUP BY video_id ORDER BY MAX(like_sayisi) DESC LIMIT 0,$cekilecek_miktar");
$flag1_t = true;
$table1_t = array();
$table1_t['cols'] = array(
    array('label' => 'video_id', 'type' => 'string'),
    array('label' => 'adı', 'type' => 'string'),
    array('label' => 'izlenme', 'type' => 'number'),
    array('label' => 'beğenme', 'type' => 'number'),
    array('label' => 'beğenmeme', 'type' => 'number'),
    array('label' => 'yorum', 'type' => 'number'),
    array('label' => 'yüklenme', 'type' => 'string')
);
$rows1_t = array();
$sayac1_t = 0;
while ($r1_t = mysql_fetch_assoc($sth1_t)) {
    $temp1_t = array();
    $temp1_t[] = array('v' => (string) $r1_t['video_id']);
    $temp1_t[] = array('v' => (string) $r1_t['adi']);
    $temp1_t[] = array('v' => (int) $r1_t['goruntulenme_sayisi']);
    $temp1_t[] = array('v' => (int) $r1_t['MAX(like_sayisi)']);
    $temp1_t[] = array('v' => (int) $r1_t['dislike_sayisi']);
    $temp1_t[] = array('v' => (int) $r1_t['toplam_yorum_sayisi']);
    $temp1_t[] = array('v' => (string) $r1_t['yukleme_tarihi']);
    $rows1_t[] = array('c' => $temp1_t);
}
$table1_t['rows'] = $rows1_t;
$jsonTable1_t = json_encode($table1_t);

//dislike sayisi

$sth2 = mysql_query("SELECT like_sayisi,MAX(dislike_sayisi) FROM `ozel_video_depo` WHERE channel_id ='$gelen_channel_id' GROUP BY video_id ORDER BY MAX(dislike_sayisi) DESC LIMIT 0,$cekilecek_miktar");
$flag2 = true;
$table2 = array();
$table2['cols'] = array(
    array('label' => 'id', 'type' => 'string'),
    array('label' => 'beğenme sayısı', 'type' => 'number'),
    array('label' => 'beğenmeme sayısı', 'type' => 'number')
);
$rows2 = array();
$sayac2 = 0;
while ($r2 = mysql_fetch_assoc($sth2)) {
    $temp2 = array();
//    $degisken2 = (string) $r2['adi'];
//    $degisken2 = ( ++$sayac2) . " - " . substr($degisken2, 0, 8) . "...";
//    $temp2[] = array('v' => (string) $degisken2);
    $temp2[] = array('v' => (string) ++$sayac2);
    $temp2[] = array('v' => (int) $r2['like_sayisi']);
    $temp2[] = array('v' => (int) $r2['MAX(dislike_sayisi)']);
    $rows2[] = array('c' => $temp2);
}
$table2['rows'] = $rows2;
$jsonTable2 = json_encode($table2);

//dislike sayisi_t

$sth2_t = mysql_query("SELECT video_id,adi,goruntulenme_sayisi,like_sayisi,MAX(dislike_sayisi),toplam_yorum_sayisi,yukleme_tarihi FROM `ozel_video_depo` WHERE channel_id ='$gelen_channel_id' GROUP BY video_id ORDER BY MAX(dislike_sayisi) DESC LIMIT 0,$cekilecek_miktar");
$flag2_t = true;
$table2_t = array();
$table2_t['cols'] = array(
    array('label' => 'video_id', 'type' => 'string'),
    array('label' => 'adı', 'type' => 'string'),
    array('label' => 'izlenme', 'type' => 'number'),
    array('label' => 'beğenme', 'type' => 'number'),
    array('label' => 'beğenmeme', 'type' => 'number'),
    array('label' => 'yorum', 'type' => 'number'),
    array('label' => 'yüklenme', 'type' => 'string')
);
$rows2_t = array();
$sayac2_t = 0;
while ($r2_t = mysql_fetch_assoc($sth2_t)) {
    $temp2_t = array();
    $temp2_t[] = array('v' => (string) $r2_t['video_id']);
    $temp2_t[] = array('v' => (string) $r2_t['adi']);
    $temp2_t[] = array('v' => (int) $r2_t['goruntulenme_sayisi']);
    $temp2_t[] = array('v' => (int) $r2_t['like_sayisi']);
    $temp2_t[] = array('v' => (int) $r2_t['MAX(dislike_sayisi)']);
    $temp2_t[] = array('v' => (int) $r2_t['toplam_yorum_sayisi']);
    $temp2_t[] = array('v' => (string) $r2_t['yukleme_tarihi']);
    $rows2_t[] = array('c' => $temp2_t);
}
$table2_t['rows'] = $rows2_t;
$jsonTable2_t = json_encode($table2_t);


//yorum sayisi

$sth3 = mysql_query("SELECT MAX(toplam_yorum_sayisi) FROM `ozel_video_depo` WHERE channel_id ='$gelen_channel_id' GROUP BY video_id ORDER BY MAX(toplam_yorum_sayisi) DESC LIMIT 0,$cekilecek_miktar");
$flag3 = true;
$table3 = array();
$table3['cols'] = array(
    array('label' => 'id', 'type' => 'string'),
    array('label' => 'yorum sayısı', 'type' => 'number')
);
$rows3 = array();
$sayac3 = 0;
while ($r3 = mysql_fetch_assoc($sth3)) {
    $temp3 = array();
//    $degisken3 = (string) $r3['adi'];
//    $degisken3 = ( ++$sayac3) . " - " . substr($degisken3, 0, 3) . "...";
    $temp3[] = array('v' => (string) ++$sayac3);
//    $temp3[] = array('v' => (string) $degisken3);
    $temp3[] = array('v' => (int) $r3['MAX(toplam_yorum_sayisi)']);
    $rows3[] = array('c' => $temp3);
}
$table3['rows'] = $rows3;
$jsonTable3 = json_encode($table3);

//yorum sayisi_t

$sth3_t = mysql_query("SELECT video_id,adi,goruntulenme_sayisi,like_sayisi,dislike_sayisi,MAX(toplam_yorum_sayisi),yukleme_tarihi FROM `ozel_video_depo` WHERE channel_id ='$gelen_channel_id' GROUP BY video_id ORDER BY MAX(toplam_yorum_sayisi) DESC LIMIT 0,$cekilecek_miktar");
$flag3_t = true;
$table3_t = array();
$table3_t['cols'] = array(
    array('label' => 'video_id', 'type' => 'string'),
    array('label' => 'adı', 'type' => 'string'),
    array('label' => 'izlenme', 'type' => 'number'),
    array('label' => 'beğenme', 'type' => 'number'),
    array('label' => 'beğenmeme', 'type' => 'number'),
    array('label' => 'yorum', 'type' => 'number'),
    array('label' => 'yüklenme', 'type' => 'string')
);
$rows3_t = array();
$sayac3_t = 0;
while ($r3_t = mysql_fetch_assoc($sth3_t)) {
    $temp3_t = array();
    $temp3_t[] = array('v' => (string) $r3_t['video_id']);
    $temp3_t[] = array('v' => (string) $r3_t['adi']);
    $temp3_t[] = array('v' => (int) $r3_t['goruntulenme_sayisi']);
    $temp3_t[] = array('v' => (int) $r3_t['like_sayisi']);
    $temp3_t[] = array('v' => (int) $r3_t['dislike_sayisi']);
    $temp3_t[] = array('v' => (int) $r3_t['MAX(toplam_yorum_sayisi)']);
    $temp3_t[] = array('v' => (string) $r3_t['yukleme_tarihi']);
    $rows3_t[] = array('c' => $temp3_t);
}
$table3_t['rows'] = $rows3_t;
$jsonTable3_t = json_encode($table3_t);
?>




<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf8" />

    <title>Youtube Analiz</title>
    <link href="Css_Klasor/sitil.css" rel="stylesheet" type="text/css" />

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages: ["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = new google.visualization.DataTable(<?= $jsonTable ?>);
            var options = {
                title: 'videoların izlenme sayıları',
                hAxis: {title: 'video no', titleTextStyle: {color: 'red', fontSize: 20}}
            };
            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages: ["table"]});
        google.setOnLoadCallback(drawTable);
        function drawTable() {
            var data = new google.visualization.DataTable(<?= $jsonTable_t ?>);
            var table = new google.visualization.Table(document.getElementById('table_div'));

            table.draw(data, {showRowNumber: true});

            google.visualization.events.addListener(table, 'select', selectHandler);

            function selectHandler() {
                var selection = table.getSelection();
                var message = '';
                for (var i = 0; i < selection.length; i++) {
                    var item = selection[i];
                    if (item.row != null && item.column != null) {
                        var str = data.getFormattedValue(item.row, item.column);
                        message += '{row:' + item.row + ',column:' + item.column + '} = ' + str + '\n';
                    } else if (item.row != null) {
                        var str = data.getFormattedValue(item.row, 0);
                        message += '{row:' + item.row + ', column:none}; value (col 0) = ' + str + '\n';

//                        alert('You selected ' + message);
                        window.open("video_bilgisi.php?video_id=" + str);
                    }
                    else if (item.column != null) {
                        var str = data.getFormattedValue(0, item.column);
                        message += '{row:none, column:' + item.column + '}; value (row 0) = ' + str + '\n';
                    }
                }
                if (message == '') {
                    message = 'nothing';
                }


            }
        }
    </script>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages: ["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = new google.visualization.DataTable(<?= $jsonTable1 ?>);
            var options = {
                title: 'videoların beğenme sayıları',
                hAxis: {title: 'video no', titleTextStyle: {color: 'red', fontSize: 20}}
            };
            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div1'));
            chart.draw(data, options);
        }
    </script>


    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages: ["table"]});
        google.setOnLoadCallback(drawTable);
        function drawTable() {
            var data = new google.visualization.DataTable(<?= $jsonTable1_t ?>);
            var table = new google.visualization.Table(document.getElementById('table_div1'));

            table.draw(data, {showRowNumber: true});

            google.visualization.events.addListener(table, 'select', selectHandler);

            function selectHandler() {
                var selection = table.getSelection();
                var message = '';
                for (var i = 0; i < selection.length; i++) {
                    var item = selection[i];
                    if (item.row != null && item.column != null) {
                        var str = data.getFormattedValue(item.row, item.column);
                        message += '{row:' + item.row + ',column:' + item.column + '} = ' + str + '\n';
                    } else if (item.row != null) {
                        var str = data.getFormattedValue(item.row, 0);
                        message += '{row:' + item.row + ', column:none}; value (col 0) = ' + str + '\n';

                        window.open("video_bilgisi.php?video_id=" + str);

                    } else if (item.column != null) {
                        var str = data.getFormattedValue(0, item.column);
                        message += '{row:none, column:' + item.column + '}; value (row 0) = ' + str + '\n';
                    }
                }
                if (message == '') {
                    message = 'nothing';
                }
//                alert('You selected ' + message);

//                window.open(str, '_blank');
//                window.open(url);

            }
        }
    </script>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages: ["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = new google.visualization.DataTable(<?= $jsonTable2 ?>);
            var options = {
                title: 'videoların beğenmeme sayıları',
                hAxis: {title: 'video no', titleTextStyle: {color: 'red', fontSize: 20}}
            };
            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div2'));
            chart.draw(data, options);
        }
    </script>


    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages: ["table"]});
        google.setOnLoadCallback(drawTable);
        function drawTable() {
            var data = new google.visualization.DataTable(<?= $jsonTable2_t ?>);
            var table = new google.visualization.Table(document.getElementById('table_div2'));

            table.draw(data, {showRowNumber: true});

            google.visualization.events.addListener(table, 'select', selectHandler);

            function selectHandler() {
                var selection = table.getSelection();
                var message = '';
                for (var i = 0; i < selection.length; i++) {
                    var item = selection[i];
                    if (item.row != null && item.column != null) {
                        var str = data.getFormattedValue(item.row, item.column);
                        message += '{row:' + item.row + ',column:' + item.column + '} = ' + str + '\n';
                    } else if (item.row != null) {
                        var str = data.getFormattedValue(item.row, 0);
                        message += '{row:' + item.row + ', column:none}; value (col 0) = ' + str + '\n';

                        window.open("video_bilgisi.php?video_id=" + str);

                    } else if (item.column != null) {
                        var str = data.getFormattedValue(0, item.column);
                        message += '{row:none, column:' + item.column + '}; value (row 0) = ' + str + '\n';
                    }
                }
                if (message == '') {
                    message = 'nothing';
                }
//                alert('You selected ' + message);
//
//                window.open(str, '_blank');
////                window.open(url);

            }
        }
    </script>


    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages: ["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = new google.visualization.DataTable(<?= $jsonTable3 ?>);
            var options = {
                title: 'videoların yorum sayıları',
                hAxis: {title: 'video no', titleTextStyle: {color: 'red', fontSize: 20}}
            };
            var chart = new google.visualization.ColumnChart(document.getElementById('chart_div3'));
            chart.draw(data, options);
        }
    </script>


    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages: ["table"]});
        google.setOnLoadCallback(drawTable);
        function drawTable() {
            var data = new google.visualization.DataTable(<?= $jsonTable3_t ?>);
            var table = new google.visualization.Table(document.getElementById('table_div3'));

            table.draw(data, {showRowNumber: true});

            google.visualization.events.addListener(table, 'select', selectHandler);

            function selectHandler() {
                var selection = table.getSelection();
                var message = '';
                for (var i = 0; i < selection.length; i++) {
                    var item = selection[i];
                    if (item.row != null && item.column != null) {
                        var str = data.getFormattedValue(item.row, item.column);
                        message += '{row:' + item.row + ',column:' + item.column + '} = ' + str + '\n';
                    } else if (item.row != null) {
                        var str = data.getFormattedValue(item.row, 0);
                        message += '{row:' + item.row + ', column:none}; value (col 0) = ' + str + '\n';

                        window.open("video_bilgisi.php?video_id=" + str);

                    }
                    else if (item.column != null) {
                        var str = data.getFormattedValue(0, item.column);
                        message += '{row:none, column:' + item.column + '}; value (row 0) = ' + str + '\n';
                    }
                }
                if (message == '') {
                    message = 'nothing';
                }
//                alert('You selected ' + message);
//
//                window.open(str, '_blank');
//                window.open(url);

            }
        }
    </script>

</head>

<body>
<div id="tum_sayfa">

    <div id="sol_bosluk">.</div>


    <div id="orta">


        <div id="orta_ust_resim">
            <a href="https://www.youtube.com" style="height: 150px; width: 150px; margin-top: 25px; float: right">
                <img src="resimler/youtube-3.png"/>
            </a>
        </div>

        <div id="orta_navigasyon">
            <ul id="menu">
                <li><a href="hakkinda.php">Hakkında</a></li>
                <li><a href="videolar.php">Video Analizleri</a></li>
                <li><a href="channellar.php">Kanal Analizleri</a></li>
                <li><a href="kelime_arama.php">Arama Yap</a></li>
                <li><a href="channel_ekle.php">Kanal Ekle</a></li>
                
            </ul>
        </div>


        <div id="icerikler">

            <div id="liste_sayisi" style='height: 37px;'>
                <ul id="menu2" style="height: 37px; font-size: 14px; padding-left: 10px;">
                    <li style=""><a><?php echo $gelen_channel_adi; ?> kanalının video analizleri</a></li>
                </ul>
            </div>
            <div id="bosluk" style='height: 1px;'></div>
            <div id="liste_sayisi">
                <ul id="menu2">
                    <li><a>grafik veri sayısı : </a></li>
                    <li><a href="channel_video.php?cek=10" <?php if ($cekilecek_miktar == 10) echo 'class="tikla"'; ?> >10</a></li>
                    <li><a href="channel_video.php?cek=20" <?php if ($cekilecek_miktar == 20) echo 'class="tikla"'; ?> >20</a></li>
                    <li><a href="channel_video.php?cek=30" <?php if ($cekilecek_miktar == 30) echo 'class="tikla"'; ?> >30</a></li>
                    <li><a href="channel_video.php?cek=40" <?php if ($cekilecek_miktar == 40) echo 'class="tikla"'; ?> >40</a></li>
                </ul>
            </div>

            <div id="chart_div" style="width: 1000px; height: 450;"></div>    <!--videoların görüntülenme sayıları-->

            <div id="liste_sayisi">
                <ul id="menu2" style="padding-left: 400px;">
                    <li><a>video bilgileri için tablodan tıklayınız.</a></li>
                </ul>
            </div>

            <div id="table_div" style="width: 1000px; height: 400;"></div>

            <div id="bosluk"></div>

            <div id="chart_div1" style="width: 1000px; height: 450;"></div>    <!--videoların like sayıları-->

            <div id="liste_sayisi">
                <ul id="menu2" style="padding-left: 400px;">
                    <li><a>video bilgileri için tablodan tıklayınız.</a></li>
                </ul>
            </div>

            <div id="table_div1" style="width: 1000px; height: 400;"></div>

            <div id="bosluk"></div>

            <div id="chart_div2" style="width: 1000px; height: 450;"></div>    <!--videoların dislike sayıları-->

            <div id="liste_sayisi">
                <ul id="menu2" style="padding-left: 400px;">
                    <li><a>video bilgileri için tablodan tıklayınız.</a></li>
                </ul>
            </div>

            <div id="table_div2" style="width: 1000px; height: 400;"></div>

            <div id="bosluk"></div>

            <div id="chart_div3" style="width: 1000px; height: 450;"></div>    <!--videoların yorum sayıları-->

            <div id="liste_sayisi">
                <ul id="menu2" style="padding-left: 400px;">
                    <li><a>video bilgileri için tablodan tıklayınız.</a></li>
                </ul>
            </div>

            <div id="table_div3" style="width: 1000px; height: 400;"></div>

            <div id="bosluk"></div>

        </div>


    </div>


    <div id="sag_bosluk">.</div>

</div>
</body>
</html>
