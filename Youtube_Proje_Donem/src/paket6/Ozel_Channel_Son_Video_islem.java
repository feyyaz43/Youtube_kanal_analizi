/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package paket6;

import com.fatihhalimoglu.java.dbtools.v2.Db_datasource;
import java.sql.SQLException;
import java.sql.Timestamp;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;
import java.util.HashSet;
import java.util.List;
import java.util.concurrent.LinkedBlockingQueue;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.sql.DataSource;
import org.apache.commons.dbutils.QueryRunner;
import org.apache.commons.dbutils.handlers.ArrayListHandler;
import org.json.JSONArray;
import org.json.JSONException;
import org.json.JSONObject;
import static paket6.Video_Ogeleri.getUrl;

/**
 *
 * @author PC
 */
public class Ozel_Channel_Son_Video_islem implements Runnable {

    LinkedBlockingQueue<String> ozel_channel_son_video_kuyruk;
    SimpleDateFormat simpleDateFormat = new SimpleDateFormat("yyyy-MM-dd'T'hh:mm:ss.SSS'Z'");

//    DataSource ds = Db_datasource.getDataSource(
//            "com.mysql.jdbc.Driver",
//            "jdbc:mysql://95.211.242.157:3306/?useUnicode=true&characterEncoding=UTF-8&rewriteBatchedStatements=true",
//            "feyyaz", "feyyaz2015");
//    QueryRunner qr = new QueryRunner(ds);

    QueryRunner qr;
    
    String content;
    String content2;
    String content3;

    JSONObject jSONObject1;
    JSONObject jSONObject2;
    JSONObject jSONObject3;
    JSONArray jSONArray1;
    JSONArray jSONArray2;
    JSONArray jSONArray3;

    String video_id;
    String adi;
    String aciklama;
    int goruntulenme_sayisi;
    int like_sayisi;
    int dislike_sayisi;
    String suresi;
    int toplam_yorum_sayisi;
    String license;
    String yukleme_tarihi;
    int kategori;
    String channel_id;

    boolean durum;
    int channel_video_say;
    String page_token;

    public Ozel_Channel_Son_Video_islem(LinkedBlockingQueue<String> ozel_channel_son_video_kuyruk, QueryRunner qr) {
        this.ozel_channel_son_video_kuyruk = ozel_channel_son_video_kuyruk;
        this.qr = qr;
    }

    @Override
    public void run() {
        while (true) {
            try {
                String gelen_ozel_channel;
                gelen_ozel_channel = ozel_channel_son_video_kuyruk.take();

                page_token = "";

                HashSet<Video_Ogeleri> hash_liste2 = new HashSet();

                try {
                    content = getUrl("https://www.googleapis.com/youtube/v3/channels"
                            + "?part=snippet,contentDetails,statistics"
                            + "&id=" + gelen_ozel_channel
                            + "&key=AIzaSyDb9bL83r35Og-sJgzkqGch9pT8pdFKUuc");

                    jSONObject1 = new JSONObject(content);
                    jSONArray1 = (JSONArray) jSONObject1.get("items");

                    String uploads = (String) jSONArray1.getJSONObject(0).getJSONObject("contentDetails").getJSONObject("relatedPlaylists").get("uploads");

                    content2 = getUrl("https://www.googleapis.com/youtube/v3/playlistItems"
                            + "?part=contentDetails,snippet"
                            + "&pageToken=" + page_token
                            + "&maxResults=50"
                            + "&playlistId=" + uploads
                            + "&key=AIzaSyDb9bL83r35Og-sJgzkqGch9pT8pdFKUuc");

                    jSONObject2 = new JSONObject(content2);
                    channel_video_say = (int) jSONObject2.getJSONObject("pageInfo").get("totalResults");
                    jSONArray2 = (JSONArray) jSONObject2.get("items");

                    for (int video_sayac2 = 0; video_sayac2 < 50; video_sayac2++) {

                        try {
                            String gelen_video_id = (String) jSONArray2.getJSONObject(video_sayac2).getJSONObject("contentDetails").get("videoId");
                            String ad = (String) jSONArray2.getJSONObject(video_sayac2).getJSONObject("snippet").get("title");

                            content3 = getUrl("https://www.googleapis.com/youtube/v3/videos"
                                    + "?id=" + gelen_video_id
                                    + "&key=AIzaSyDb9bL83r35Og-sJgzkqGch9pT8pdFKUuc"
                                    + "&part=snippet,contentDetails,statistics,status");

                            jSONObject3 = new JSONObject(content3);
                            jSONArray3 = (JSONArray) jSONObject3.get("items");

                            video_id = (String) jSONArray3.getJSONObject(0).get("id");
                            adi = (String) jSONArray3.getJSONObject(0).getJSONObject("snippet").get("title");
                            aciklama = (String) jSONArray3.getJSONObject(0).getJSONObject("snippet").get("description");
                            goruntulenme_sayisi = Integer.parseInt((String) jSONArray3.getJSONObject(0).getJSONObject("statistics").get("viewCount"));
                            like_sayisi = Integer.parseInt((String) jSONArray3.getJSONObject(0).getJSONObject("statistics").get("likeCount"));
                            dislike_sayisi = Integer.parseInt((String) jSONArray3.getJSONObject(0).getJSONObject("statistics").get("dislikeCount"));
                            suresi = (String) jSONArray3.getJSONObject(0).getJSONObject("contentDetails").get("duration");
                            toplam_yorum_sayisi = Integer.parseInt((String) jSONArray3.getJSONObject(0).getJSONObject("statistics").get("commentCount"));
                            license = (String) jSONArray3.getJSONObject(0).getJSONObject("status").get("license");
                            yukleme_tarihi = (String) jSONArray3.getJSONObject(0).getJSONObject("snippet").get("publishedAt");
                            kategori = Integer.parseInt((String) jSONArray3.getJSONObject(0).getJSONObject("snippet").get("categoryId"));
                            channel_id = (String) jSONArray3.getJSONObject(0).getJSONObject("snippet").get("channelId");

                            Date date2 = null;
                            try {
                                date2 = simpleDateFormat.parse(yukleme_tarihi);
                            } catch (ParseException ex) {
                                Logger.getLogger(Ozel_Channel_Son_Video_islem.class.getName()).log(Level.SEVERE, null, ex);
                            }

                            Video_Ogeleri video_Ogeleri = new Video_Ogeleri();
                            video_Ogeleri.setVideo_id(video_id);
                            video_Ogeleri.setAdi(adi);
                            video_Ogeleri.setAciklama(aciklama);
                            video_Ogeleri.setGoruntulenme_sayisi(goruntulenme_sayisi);
                            video_Ogeleri.setLike_sayisi(like_sayisi);
                            video_Ogeleri.setDislike_sayisi(dislike_sayisi);
                            video_Ogeleri.setSuresi(suresi);
                            video_Ogeleri.setToplam_yorum_sayisi(toplam_yorum_sayisi);
                            video_Ogeleri.setLicense(license);
                            video_Ogeleri.setYukleme_tarihi(new Timestamp(date2.getTime()));
                            video_Ogeleri.setKategori(kategori);
                            video_Ogeleri.setChannel_id(channel_id);
                            video_Ogeleri.setSorgu_Sayisi(0);

                            hash_liste2.add(video_Ogeleri);

                        } catch (JSONException e) {
                            video_sayac2 = 50;
                        }
                    }

                } catch (JSONException ex) {
                    Logger.getLogger(Ozel_Channel_Son_Video_islem.class.getName()).log(Level.SEVERE, null, ex);
                }

                Object[][] parametreler = new Object[hash_liste2.size()][13];

                Video_Ogeleri vo = new Video_Ogeleri();
                Object[] parametreler2 = hash_liste2.toArray();

                for (int i = 0; i < hash_liste2.size(); i++) {
                    vo = (Video_Ogeleri) parametreler2[i];

                    parametreler[i][0] = vo.getVideo_id();
                    parametreler[i][1] = vo.getAdi();
                    parametreler[i][2] = vo.getAciklama();
                    parametreler[i][3] = vo.getGoruntulenme_sayisi();
                    parametreler[i][4] = vo.getLike_sayisi();
                    parametreler[i][5] = vo.getDislike_sayisi();
                    parametreler[i][6] = vo.getSuresi();
                    parametreler[i][7] = vo.getToplam_yorum_sayisi();
                    parametreler[i][8] = vo.getLicense();
                    parametreler[i][9] = vo.getYukleme_tarihi();
                    parametreler[i][10] = vo.getKategori();
                    parametreler[i][11] = vo.getChannel_id();
                    parametreler[i][12] = vo.getSorgu_Sayisi();
                }

                String sql_cumle = "insert ignore into samet_feyyaz.ozel_video"
                        + "(video_id,adi,aciklama,goruntulenme_sayisi,like_sayisi,dislike_sayisi,"
                        + "suresi,toplam_yorum_sayisi,license,yukleme_tarihi,kategori,channel_id,sorgu_sayisi) "
                        + "VALUES(?,?,?,?,?,?,?,?,?,?,?,?,?)";

                try {
                    qr.batch(sql_cumle, parametreler);

                } catch (SQLException ex) {
                    Logger.getLogger(Ozel_Channel_Son_Video_islem.class.getName()).log(Level.SEVERE, null, ex);
                }

            } catch (InterruptedException ex) {
                Logger.getLogger(Ozel_Channel_Son_Video_islem.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }

}

class Ozel_Channel_Son_Video_Getir implements Runnable {

    LinkedBlockingQueue<String> ozel_channel_son_video_kuyruk;
    
    QueryRunner qr;
    ArrayListHandler alh = Youtube_Thread.alh;

//    DataSource ds = Db_datasource.getDataSource(
//            "com.mysql.jdbc.Driver",
//            "jdbc:mysql://95.211.242.157:3306/?useUnicode=true&characterEncoding=UTF-8&rewriteBatchedStatements=true",
//            "feyyaz", "feyyaz2015");
//    QueryRunner qr = new QueryRunner(ds);
//    ArrayListHandler alh = new ArrayListHandler();

    public Ozel_Channel_Son_Video_Getir(LinkedBlockingQueue<String> ozel_channel_son_video_kuyruk, QueryRunner qr) {
        this.ozel_channel_son_video_kuyruk = ozel_channel_son_video_kuyruk;
        this.qr = qr;
    }

    @Override
    public void run() {
        while (true) {

            List<Object[]> query = null;
            try {
                query = qr.query("select channel_id from samet_feyyaz.ozel_channel where video_toplama=0", alh);
            } catch (SQLException ex) {
                Logger.getLogger(Ozel_Channel_Son_Video_Getir.class.getName()).log(Level.SEVERE, null, ex);
            }

            for (Object[] object : query) {
                if (object != null) {
                    ozel_channel_son_video_kuyruk.add(object[0].toString());
                }
            }

            try {
                Thread.sleep(1 * 60 * 60 * 1000);              //saatte bir bak video yüklemiş mi
            } catch (InterruptedException ex) {
                Logger.getLogger(Ozel_Channel_Son_Video_Getir.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }

}
