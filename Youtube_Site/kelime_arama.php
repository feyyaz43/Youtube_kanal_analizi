<?php
include './veritabani.php';
mysql_set_charset('utf8mb4');

$donen_satir = 0;

if ('POST' == $_SERVER['REQUEST_METHOD']) {
    $aranan = htmlspecialchars($_POST['arama']);
    if (!empty($aranan)) {
        $q = "%" . $aranan . "%";

        $cekilecek_miktar = 200;

        $sth_t = mysql_query("SELECT video_id,adi,aciklama,goruntulenme_sayisi,like_sayisi,dislike_sayisi,toplam_yorum_sayisi,yukleme_tarihi FROM `ozel_video_depo` WHERE adi LIKE '$q' GROUP BY video_id ORDER BY sorgu_tarihi DESC LIMIT 0,$cekilecek_miktar");
        $donen_satir = mysql_num_rows($sth_t);
        if ($donen_satir > 0) {
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
                $temp_t[] = array('v' => (int) $r_t['goruntulenme_sayisi']);
                $temp_t[] = array('v' => (int) $r_t['like_sayisi']);
                $temp_t[] = array('v' => (int) $r_t['dislike_sayisi']);
                $temp_t[] = array('v' => (int) $r_t['toplam_yorum_sayisi']);
                $temp_t[] = array('v' => (string) $r_t['yukleme_tarihi']);
                $rows_t[] = array('c' => $temp_t);
            }
            $table_t['rows'] = $rows_t;
            $jsonTable_t = json_encode($table_t);
        }
    }
} else {
    $aranan = "";
}
?>


<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf8" />

    <title>Youtube Analiz</title>
    <link href="Css_Klasor/sitil.css" rel="stylesheet" type="text/css" />

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
                <li><a href="kelime_arama.php" style="color: black;">Arama Yap</a></li>
                <li><a href="channel_ekle.php">Kanal Ekle</a></li>
                
            </ul>
        </div>


        <div id="icerikler">

            <div id="liste_sayisi">
                <ul id="menu2" style="padding-left: 20px;">
                    <li><a>aranan kelimeyi yazıp enter layın.&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;aranan kelime : <?php echo " \" " . $aranan . " \" "; ?>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; dönen sonuç : <?php echo $donen_satir; ?></a></li>
                </ul>
            </div>


            <form method="post">
                <p style="padding-left: 30px;"><input style="width: 200px;" type="text" name="arama"/></p>
                <p><input type="submit" name="action" value="None" style="display: none"/></p>
            </form>


            <?php if ($donen_satir != 0) { ?>


                <div id = "liste_sayisi">
                    <ul id = "menu2" style = "padding-left: 400px;">
                        <li><a>video bilgileri için tablodan tıklayınız.</a></li>
                    </ul>
                </div>
            <?php } ?>


            <div id="table_div" style="width: 1000px; height: auto;"></div>

        </div>


    </div>


    <div id="sag_bosluk">.</div>

</div>
</body>
</html>
