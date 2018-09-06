<?php
include './veritabani.php';
mysql_set_charset('utf8mb4');
$gelen_video_id = (string) @(htmlspecialchars($_GET['video_id']));

$gelen_video_adi = mysql_query("SELECT adi FROM `ozel_video_depo` WHERE video_id ='$gelen_video_id' LIMIT 1");
$r_adi = mysql_fetch_assoc($gelen_video_adi);
$gelen_video_adi = $r_adi['adi'];

//görüntülenme sayisi

$sth = mysql_query("SELECT goruntulenme_sayisi,sorgu_tarihi FROM `ozel_video_depo` WHERE video_id='$gelen_video_id' ORDER BY sorgu_tarihi ASC");

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
    $temp[] = array('v' => (string) $r['sorgu_tarihi']);
    $temp[] = array('v' => (int) $r['goruntulenme_sayisi']);
    $rows[] = array('c' => $temp);
}
$table['rows'] = $rows;
$jsonTable = json_encode($table);


//like ve dislike sayisi

$sth1 = mysql_query("SELECT like_sayisi,dislike_sayisi,sorgu_tarihi FROM `ozel_video_depo` WHERE video_id='$gelen_video_id' ORDER BY sorgu_tarihi ASC");
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
    $temp1[] = array('v' => (string) $r1['sorgu_tarihi']);
    $temp1[] = array('v' => (int) $r1['like_sayisi']);
    $temp1[] = array('v' => (int) $r1['dislike_sayisi']);
    $rows1[] = array('c' => $temp1);
}
$table1['rows'] = $rows1;
$jsonTable1 = json_encode($table1);


//yorum sayisi

$sth3 = mysql_query("SELECT toplam_yorum_sayisi,sorgu_tarihi FROM `ozel_video_depo` WHERE video_id='$gelen_video_id' ORDER BY sorgu_tarihi ASC");
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
    $temp3[] = array('v' => (string) $r3['sorgu_tarihi']);
    $temp3[] = array('v' => (int) $r3['toplam_yorum_sayisi']);
    $rows3[] = array('c' => $temp3);
}
$table3['rows'] = $rows3;
$jsonTable3 = json_encode($table3);


//video bilgileri_t
$sth_t = mysql_query("SELECT video_id,adi,aciklama,goruntulenme_sayisi,like_sayisi,dislike_sayisi,suresi,toplam_yorum_sayisi,license,yukleme_tarihi,channel_id FROM `ozel_video_depo` WHERE video_id = '$gelen_video_id' ORDER BY sorgu_tarihi DESC LIMIT 1");
$flag_t = true;
$table_t = array();
$table_t['cols'] = array(
    array('label' => 'özellik', 'type' => 'string'),
    array('label' => 'bilgi', 'type' => 'string')
);
$rows_t = array();
$sayac_t = 0;
$r_t = mysql_fetch_assoc($sth_t);
$temp_t = array();
$temp_t[] = array('v' => (string) "video_id");
$temp_t[] = array('v' => (string) $r_t['video_id']);
$rows_t[] = array('c' => $temp_t);
$temp_t = array();
$temp_t[] = array('v' => (string) "adı");
$temp_t[] = array('v' => (string) $r_t['adi']);
$rows_t[] = array('c' => $temp_t);
$temp_t = array();
$temp_t[] = array('v' => (string) "açıklama");
$temp_t[] = array('v' => (string) $r_t['aciklama']);
$rows_t[] = array('c' => $temp_t);
$temp_t = array();
$temp_t[] = array('v' => (string) "izlenme sayısı");
$temp_t[] = array('v' => (string) $r_t['goruntulenme_sayisi']);
$rows_t[] = array('c' => $temp_t);
$temp_t = array();
$temp_t[] = array('v' => (string) "beğenme sayısı");
$temp_t[] = array('v' => (string) $r_t['like_sayisi']);
$rows_t[] = array('c' => $temp_t);
$temp_t = array();
$temp_t[] = array('v' => (string) "beğenmeme sayısı");
$temp_t[] = array('v' => (string) $r_t['dislike_sayisi']);
$rows_t[] = array('c' => $temp_t);
$temp_t = array();
$temp_t[] = array('v' => (string) "süresi");
$temp_t[] = array('v' => (string) $r_t['suresi']);
$rows_t[] = array('c' => $temp_t);
$temp_t = array();
$temp_t[] = array('v' => (string) "yorum sayısı");
$temp_t[] = array('v' => (string) $r_t['toplam_yorum_sayisi']);
$rows_t[] = array('c' => $temp_t);
$temp_t = array();
$temp_t[] = array('v' => (string) "license");
$temp_t[] = array('v' => (string) $r_t['license']);
$rows_t[] = array('c' => $temp_t);
$temp_t = array();
$temp_t[] = array('v' => (string) "yükleme tarihi");
$temp_t[] = array('v' => (string) $r_t['yukleme_tarihi']);
$rows_t[] = array('c' => $temp_t);
$temp_t = array();
$temp_t[] = array('v' => (string) "kanal_id");
$temp_t[] = array('v' => (string) $r_t['channel_id']);
$rows_t[] = array('c' => $temp_t);

$table_t['rows'] = $rows_t;
$jsonTable_t = json_encode($table_t);
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
                title: 'izlenme sayısı',
                hAxis: {title: 'sorgu tarihi', titleTextStyle: {color: 'red', fontSize: 20}}
            };
            var chart = new google.visualization.LineChart(document.getElementById('chart_div'));
            chart.draw(data, options);
        }
    </script>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages: ["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = new google.visualization.DataTable(<?= $jsonTable1 ?>);
            var options = {
                title: 'beğenme ve beğenmeme sayısı',
                hAxis: {title: 'sorgu tarihi', titleTextStyle: {color: 'red', fontSize: 20}}
            };
            var chart = new google.visualization.LineChart(document.getElementById('chart_div1'));
            chart.draw(data, options);
        }
    </script>

    <script type="text/javascript" src="https://www.google.com/jsapi"></script>
    <script type="text/javascript">
        google.load("visualization", "1", {packages: ["corechart"]});
        google.setOnLoadCallback(drawChart);
        function drawChart() {
            var data = new google.visualization.DataTable(<?= $jsonTable3 ?>);
            var options = {
                title: 'yorum sayısı',
                hAxis: {title: 'sorgu tarihi', titleTextStyle: {color: 'red', fontSize: 20}}
            };
            var chart = new google.visualization.LineChart(document.getElementById('chart_div3'));
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
                        var str = data.getFormattedValue(item.row, 1);
                        message += '{row:' + item.row + ', column:none}; value (col 0) = ' + str + '\n';

                        if (item.row == 10) {
//                            alert('You selected ' + message);
                            window.open("channel_bilgisi.php?channel_id=" + str);
                        }
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
                    <li style=""><a><?php echo $gelen_video_adi; ?> videosunun bilgileri</a></li>
                </ul>
            </div>
            <div id="bosluk" style='height: 1px;'></div>

            <div id="liste_sayisi">
                <ul id="menu2" style="padding-left: 350px;">
                    <li><a>bu videonun kanal bilgileri için tablodan kanal_id yi tıklayınız.</a></li>
                </ul>
            </div>

            <div id="table_div" style="width: 1000px; height: auto;"></div>    <!--videonun bilgileri-->
            <div id="bosluk"></div>
            <div style='padding-left: 200px;'>
                <iframe width="600" height="400" src="https://www.youtube.com/embed/<?php echo $gelen_video_id; ?>" frameborder="0" allowfullscreen></iframe>
            </div>
            <div id="bosluk"></div>
            <div id="chart_div" style="width: 1000px; height: 450;"></div>    <!--videonun görüntülenme sayıları-->
            <div id="bosluk"></div>
            <div id="chart_div1" style="width: 1000px; height: 450;"></div>    <!--videonun like sayıları-->
            <div id="bosluk"></div>
            <div id="chart_div3" style="width: 1000px; height: 450;"></div>    <!--videonun like sayıları-->

        </div>


    </div>


    <div id="sag_bosluk">.</div>

</div>
</body>
</html>