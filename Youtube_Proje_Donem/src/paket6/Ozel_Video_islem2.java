/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package paket6;

import com.fatihhalimoglu.java.dbtools.v2.Db_datasource;
import java.sql.PreparedStatement;
import java.sql.SQLException;
import java.sql.Timestamp;
import java.text.ParseException;
import java.text.SimpleDateFormat;
import java.util.Date;
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
public class Ozel_Video_islem2 implements Runnable {

    LinkedBlockingQueue<String> islem2_kuyruk;
    SimpleDateFormat simpleDateFormat = new SimpleDateFormat("yyyy-MM-dd'T'hh:mm:ss.SSS'Z'");

//    DataSource ds = Db_datasource.getDataSource(
//            "com.mysql.jdbc.Driver",
//            "jdbc:mysql://95.211.242.157:3306/?useUnicode=true&characterEncoding=UTF-8&rewriteBatchedStatements=true",
//            "feyyaz", "feyyaz2015");
//    QueryRunner qr = new QueryRunner(ds);
    QueryRunner qr;

    JSONObject jSONObject1;
    JSONArray jSONArray1;

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

    public Ozel_Video_islem2(LinkedBlockingQueue<String> islem2_kuyruk, QueryRunner qr) {
        this.islem2_kuyruk = islem2_kuyruk;
        this.qr = qr;
    }

    @Override
    public void run() {
        while (true) {

//            PreparedStatement preparedStatement = null;
            String video_idsi = null;
            try {
                video_idsi = islem2_kuyruk.take();
            } catch (InterruptedException ex) {
                Logger.getLogger(Ozel_Video_islem2.class.getName()).log(Level.SEVERE, null, ex);
            }

            String content = getUrl("https://www.googleapis.com/youtube/v3/videos"
                    + "?id=" + video_idsi
                    + "&key=AIzaSyDb9bL83r35Og-sJgzkqGch9pT8pdFKUuc"
                    + "&part=snippet,contentDetails,statistics,status");

            try {
                jSONObject1 = new JSONObject(content);
                jSONArray1 = (JSONArray) jSONObject1.get("items");

                video_id = (String) jSONArray1.getJSONObject(0).get("id");
                adi = (String) jSONArray1.getJSONObject(0).getJSONObject("snippet").get("title");
                aciklama = (String) jSONArray1.getJSONObject(0).getJSONObject("snippet").get("description");
                goruntulenme_sayisi = Integer.parseInt((String) jSONArray1.getJSONObject(0).getJSONObject("statistics").get("viewCount"));
                like_sayisi = Integer.parseInt((String) jSONArray1.getJSONObject(0).getJSONObject("statistics").get("likeCount"));
                dislike_sayisi = Integer.parseInt((String) jSONArray1.getJSONObject(0).getJSONObject("statistics").get("dislikeCount"));
                suresi = (String) jSONArray1.getJSONObject(0).getJSONObject("contentDetails").get("duration");
                toplam_yorum_sayisi = Integer.parseInt((String) jSONArray1.getJSONObject(0).getJSONObject("statistics").get("commentCount"));
                license = (String) jSONArray1.getJSONObject(0).getJSONObject("status").get("license");
                yukleme_tarihi = (String) jSONArray1.getJSONObject(0).getJSONObject("snippet").get("publishedAt");
                kategori = Integer.parseInt((String) jSONArray1.getJSONObject(0).getJSONObject("snippet").get("categoryId"));
                channel_id = (String) jSONArray1.getJSONObject(0).getJSONObject("snippet").get("channelId");

                Date date = null;
                try {
                    date = simpleDateFormat.parse(yukleme_tarihi);
                } catch (ParseException ex) {
                    Logger.getLogger(Ozel_Video_islem2.class.getName()).log(Level.SEVERE, null, ex);
                }

                String sql_ozel_video_islem2 = "insert into samet_feyyaz.ozel_video_depo"
                        + "(video_id,adi,aciklama,goruntulenme_sayisi,like_sayisi,dislike_sayisi,"
                        + "suresi,toplam_yorum_sayisi,license,yukleme_tarihi,kategori,channel_id,sorgu_tarihi) "
                        + "values(?,?,?,?,?,?,?,?,?,?,?,?,?)";

//                try {
//                    preparedStatement = ds.getConnection().prepareStatement(sql_ozel_video_islem2);
//                    preparedStatement.setString(1, video_id);
//                    preparedStatement.setString(2, adi);
//                    preparedStatement.setString(3, aciklama);
//                    preparedStatement.setInt(4, goruntulenme_sayisi);
//                    preparedStatement.setInt(5, like_sayisi);
//                    preparedStatement.setInt(6, dislike_sayisi);
//                    preparedStatement.setString(7, suresi);
//                    preparedStatement.setInt(8, toplam_yorum_sayisi);
//                    preparedStatement.setString(9, license);
//                    preparedStatement.setTimestamp(10, new Timestamp(date.getTime()));
//                    preparedStatement.setInt(11, kategori);
//                    preparedStatement.setString(12, channel_id);
//                    preparedStatement.setTimestamp(13, new Timestamp(new Date().getTime()));
//                    preparedStatement.executeUpdate();
//                } catch (SQLException ex) {
//                    Logger.getLogger(Ozel_Video_islem2.class.getName()).log(Level.SEVERE, null, ex);
//                }
                try {
                    qr.update("insert into samet_feyyaz.ozel_video_depo"
                            + "(video_id,adi,aciklama,goruntulenme_sayisi,like_sayisi,dislike_sayisi,"
                            + "suresi,toplam_yorum_sayisi,license,yukleme_tarihi,kategori,channel_id,sorgu_tarihi) "
                            + "values(?,?,?,?,?,?,?,?,?,?,?,?,?)",
                            video_id,
                            adi,
                            aciklama,
                            goruntulenme_sayisi,
                            like_sayisi,
                            dislike_sayisi,
                            suresi,
                            toplam_yorum_sayisi,
                            license,
                            new Timestamp(date.getTime()),
                            kategori,
                            channel_id,
                            new Timestamp(new Date().getTime()));
                } catch (SQLException ex) {
                    Logger.getLogger(Ozel_Video_islem2.class.getName()).log(Level.SEVERE, null, ex);
                }

            } catch (JSONException ex) {
//                Logger.getLogger(Ozel_Video_islem2.class.getName()).log(Level.SEVERE, null, ex);
                try {
                    qr.update("update samet_feyyaz.ozel_video set sorgu_sayisi = -1  where video_id = '" + video_idsi + "'");
                } catch (SQLException ex1) {
                    Logger.getLogger(Ozel_Video_islem2.class.getName()).log(Level.SEVERE, null, ex1);
                }

            }

        }
    }
}

class Ozel_Video_islem2_Kuyruk_Getir implements Runnable {

    LinkedBlockingQueue<String> islem2_kuyruk;

    QueryRunner qr;
    ArrayListHandler alh = Youtube_Thread.alh;

//    DataSource ds = Db_datasource.getDataSource(
//            "com.mysql.jdbc.Driver",
//            "jdbc:mysql://95.211.242.157:3306/?useUnicode=true&characterEncoding=UTF-8&rewriteBatchedStatements=true",
//            "feyyaz", "feyyaz2015");
//    QueryRunner qr = new QueryRunner(ds);
//    ArrayListHandler alh = new ArrayListHandler();
    public Ozel_Video_islem2_Kuyruk_Getir(LinkedBlockingQueue<String> islem2_kuyruk, QueryRunner qr) {
        this.islem2_kuyruk = islem2_kuyruk;
        this.qr = qr;
    }

    @Override
    public void run() {
        while (true) {

            List<Object[]> query = null;
            try {
                query = qr.query("select video_id from samet_feyyaz.ozel_video where 12<=sorgu_sayisi and sorgu_sayisi<24", alh);
                qr.update("update samet_feyyaz.ozel_video set sorgu_sayisi = sorgu_sayisi+1  where 12<=sorgu_sayisi and sorgu_sayisi<24");
            } catch (SQLException ex) {
                Logger.getLogger(Ozel_Video_islem2_Kuyruk_Getir.class.getName()).log(Level.SEVERE, null, ex);
            }

            for (Object[] object : query) {
                if (object != null) {
                    try {
                        islem2_kuyruk.put(object[0].toString());
                    } catch (InterruptedException ex) {
                        Logger.getLogger(Ozel_Video_islem2_Kuyruk_Getir.class.getName()).log(Level.SEVERE, null, ex);
                    }
                }
            }

            try {
                Thread.sleep(4 * 60 * 60 * 1000);       //4 saatte bir video kontrol
            } catch (InterruptedException ex) {
                Logger.getLogger(Ozel_Video_islem2_Kuyruk_Getir.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }
}
