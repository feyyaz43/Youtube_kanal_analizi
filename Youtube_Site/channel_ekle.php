<?php
include './veritabani.php';
mysql_set_charset('utf8mb4');

//$kanal_idsi = "";

if (@$_POST['kanal_idsi'] || @$_POST['mail_adres'] || @$_POST['textarea']) {
    $kanal_idsi = @htmlspecialchars($_POST['kanal_idsi']);
    $mail_adres = @htmlspecialchars($_POST['mail_adres']);
    $aciklama = @htmlspecialchars($_POST['textarea']);
    if (!empty($kanal_idsi) && !empty($mail_adres) && !empty($aciklama)) {

        if (filter_var($mail_adres, FILTER_VALIDATE_EMAIL)) {

            $alici = 'feyyazfy@gmail.com';
            $konu = 'kanal talebi';
            $iletimiz = 'kanal id : ' . $kanal_idsi . ' mail_adres : ' . $mail_adres . ' açıklama : ' . $aciklama;
            if (mail($alici, $konu, $iletimiz)) {
                ?>
                <script type="text/javascript">
                    alert("mail gönderildi incelendikten sonra mail adresinize bilgilendirme yapılacak...");
                </script>
                <?php
            } else {
                ?>
                <script type="text/javascript">
                    alert("mail gönderilemedi tekrar deneyiniz...");
                </script>
                <?php
            }
        } else {
            ?>
            <script type="text/javascript">
                alert("mail adresini doğru giriniz...");
            </script>
            <?php
        }
    } else {
        ?>
        <script type="text/javascript">
            alert("boş bırakmayınız...");
        </script>
        <?php
    }
}
?>


<html>
    <head>
        <meta http-equiv="Content-Type" content="text/html; charset=utf8" />

    <title>Youtube Analiz</title>
    <link href="Css_Klasor/sitil.css" rel="stylesheet" type="text/css" />

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
                <li><a href="channel_ekle.php" style="color: black;">Kanal Ekle</a></li>
                
            </ul>
        </div>


        <div id="icerikler">

            <div id="liste_sayisi">
                <ul id="menu2" style="padding-left: 20px;">
                    <li><a>eklemek istediğiniz kanalın id sini, mail adresinizi ve açıklama yazıp gönder butonuna tıklayınız. (boş bırakmayınız)</a></li>
                </ul>
            </div>


            <form action="channel_ekle.php" method="POST">
                <p style="padding-left: 30px;">kanal id &nbsp;&nbsp;&nbsp;&nbsp;: <input style="width: 200px;" type="text" name="kanal_idsi"/></p>
                <p style="padding-left: 30px;">mail adres : <input style="width: 200px;" type="text" name="mail_adres"/></p>
                <p style="padding-left: 30px;">açıklama &nbsp;&nbsp;&nbsp;: <textarea name="textarea" rows=4 cols="25"></textarea></p>
                <p style="padding-left: 30px;"><button style="width: 280px;">gönder</button></p>
            </form>

        </div>


    </div>


    <div id="sag_bosluk">.</div>

</div>
</body>
</html>
