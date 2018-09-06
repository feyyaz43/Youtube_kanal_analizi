<?php
include './veritabani.php';
mysql_set_charset('utf8mb4');
$gelen_channel_id = (string) @(htmlspecialchars($_GET['channel_id']));

$gelen_channel_adi = mysql_query("SELECT adi FROM `ozel_channel_depo` WHERE channel_id ='$gelen_channel_id' LIMIT 1");
$r_adi = mysql_fetch_assoc($gelen_channel_adi);
$gelen_channel_adi = $r_adi['adi'];

//görüntülenme sayisi

$sth = mysql_query("SELECT goruntulenme_sayisi,sorgu_tarihi FROM `ozel_channel_depo` WHERE channel_id='$gelen_channel_id' ORDER BY sorgu_tarihi ASC");

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


//abone sayisi

$sth1 = mysql_query("SELECT abone_sayisi,sorgu_tarihi FROM `ozel_channel_depo` WHERE channel_id='$gelen_channel_id' ORDER BY sorgu_tarihi ASC");
$flag1 = true;
$table1 = array();
$table1['cols'] = array(
    array('label' => 'id', 'type' => 'string'),
    array('label' => 'abone sayısı', 'type' => 'number')
);
$rows1 = array();
$sayac1 = 0;
while ($r1 = mysql_fetch_assoc($sth1)) {
    $temp1 = array();
    $temp1[] = array('v' => (string) $r1['sorgu_tarihi']);
    $temp1[] = array('v' => (int) $r1['abone_sayisi']);
    $rows1[] = array('c' => $temp1);
}
$table1['rows'] = $rows1;
$jsonTable1 = json_encode($table1);


//toplam video sayisi

$sth2 = mysql_query("SELECT toplam_video_sayisi,sorgu_tarihi FROM `ozel_channel_depo` WHERE channel_id='$gelen_channel_id' ORDER BY sorgu_tarihi ASC");
$flag2 = true;
$table2 = array();
$table2['cols'] = array(
    array('label' => 'id', 'type' => 'string'),
    array('label' => 'video sayısı', 'type' => 'number')
);
$rows2 = array();
$sayac2 = 0;
while ($r2 = mysql_fetch_assoc($sth2)) {
    $temp2 = array();
    $temp2[] = array('v' => (string) $r2['sorgu_tarihi']);
    $temp2[] = array('v' => (int) $r2['toplam_video_sayisi']);
    $rows2[] = array('c' => $temp2);
}
$table2['rows'] = $rows2;
$jsonTable2 = json_encode($table2);



//yorum sayisi

$sth3 = mysql_query("SELECT yorum_sayisi,sorgu_tarihi FROM `ozel_channel_depo` WHERE channel_id='$gelen_channel_id' ORDER BY sorgu_tarihi ASC");
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
    $temp3[] = array('v' => (int) $r3['yorum_sayisi']);
    $rows3[] = array('c' => $temp3);
}
$table3['rows'] = $rows3;
$jsonTable3 = json_encode($table3);


//channel bilgileri_t
$sth_t = mysql_query("SELECT channel_id,adi,aciklama,goruntulenme_sayisi,abone_sayisi,toplam_video_sayisi,kurulus_tarihi,yorum_sayisi FROM `ozel_channel_depo` WHERE channel_id = '$gelen_channel_id' ORDER BY sorgu_tarihi DESC LIMIT 1");
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
$temp_t[] = array('v' => (string) "channel_id");
$temp_t[] = array('v' => (string) $r_t['channel_id']);
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
$temp_t[] = array('v' => (string) "abone sayısı");
$temp_t[] = array('v' => (string) $r_t['abone_sayisi']);
$rows_t[] = array('c' => $temp_t);
$temp_t = array();
$temp_t[] = array('v' => (string) "video sayısı");
$temp_t[] = array('v' => (string) $r_t['toplam_video_sayisi']);
$rows_t[] = array('c' => $temp_t);
$temp_t = array();
$temp_t[] = array('v' => (string) "kuruluş tarihi");
$temp_t[] = array('v' => (string) $r_t['kurulus_tarihi']);
$rows_t[] = array('c' => $temp_t);
$temp_t = array();
$temp_t[] = array('v' => (string) "yorum sayısı");
$temp_t[] = array('v' => (string) $r_t['yorum_sayisi']);
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
                title: 'abone sayısı',
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
            var data = new google.visualization.DataTable(<?= $jsonTable2 ?>);
            var options = {
                title: 'video sayısı',
                hAxis: {title: 'sorgu tarihi', titleTextStyle: {color: 'red', fontSize: 20}}
            };
            var chart = new google.visualization.LineChart(document.getElementById('chart_div2'));
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

                        if (item.row == 5) {
//                            alert('You selected ' + message);
                            window.open("channel_video.php?channel_id=<?php echo $gelen_channel_id; ?>");
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
                    <li style=""><a><?php echo $gelen_channel_adi; ?> kanalının bilgileri</a></li>
                </ul>
            </div>
            <div id="bosluk" style='height: 1px;'></div>
            
            <div id="liste_sayisi">
                <ul id="menu2" style="padding-left: 350px;">
                    <li><a>bu kanalın video analizleri için tablodan video sayısı nı tıklayınız.</a></li>
                </ul>
            </div>
            <div id="table_div" style="width: 1000px; height: auto;"></div>    <!--channel bilgileri-->
            <div id="bosluk"></div>
            <div id="chart_div" style="width: 1000px; height: 450;"></div>    <!--channel görüntülenme sayısı-->
            <div id="bosluk"></div>
            <div id="chart_div1" style="width: 1000px; height: 450;"></div>    <!--channel abone sayısı-->
            <div id="bosluk"></div>
            <div id="chart_div2" style="width: 1000px; height: 450;"></div>    <!--toplam video sayısı-->
            <div id="bosluk"></div>
            <div id="chart_div3" style="width: 1000px; height: 450;"></div>    <!--toplam yorum sayısı-->



        </div>


    </div>


    <div id="sag_bosluk">.</div>

</div>
</body>
</html>