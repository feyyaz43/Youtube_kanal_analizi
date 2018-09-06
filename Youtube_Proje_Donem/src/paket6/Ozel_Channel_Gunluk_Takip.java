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
 * @author Feyyaz
 */
public class Ozel_Channel_Gunluk_Takip implements Runnable {

    LinkedBlockingQueue<String> ozel_channel_takip;
    SimpleDateFormat simpleDateFormat = new SimpleDateFormat("yyyy-MM-dd'T'hh:mm:ss.SSS'Z'");

//    DataSource ds = Db_datasource.getDataSource(
//            "com.mysql.jdbc.Driver",
//            "jdbc:mysql://95.211.242.157:3306/?useUnicode=true&characterEncoding=UTF-8&rewriteBatchedStatements=true",
//            "feyyaz", "feyyaz2015");
//    QueryRunner qr = new QueryRunner(ds);
    QueryRunner qr;

    String content;
    JSONObject jSONObject1;
    JSONArray jSONArray1;

    String channel_adi;
    String channel_aciklama;
    int channel_goruntulenme_sayisi;
    int abone_sayisi;
    int toplam_video_sayisi;
    String kurulus_tarihi;
    int channel_yorum_sayisi;

    public Ozel_Channel_Gunluk_Takip(LinkedBlockingQueue<String> ozel_channel_takip, QueryRunner qr) {
        this.ozel_channel_takip = ozel_channel_takip;
        this.qr = qr;
    }

    @Override
    public void run() {
        while (true) {
            String gelen_ozel_channel_takip = null;
            try {
                gelen_ozel_channel_takip = ozel_channel_takip.take();
            } catch (InterruptedException ex) {
                Logger.getLogger(Ozel_Channel_Gunluk_Takip.class.getName()).log(Level.SEVERE, null, ex);
            }

//            PreparedStatement preparedStatement = null;
            content = getUrl("https://www.googleapis.com/youtube/v3/channels"
                    + "?part=snippet,contentDetails,statistics"
                    + "&id=" + gelen_ozel_channel_takip
                    + "&key=AIzaSyDb9bL83r35Og-sJgzkqGch9pT8pdFKUuc");

            try {
                jSONObject1 = new JSONObject(content);

                jSONArray1 = (JSONArray) jSONObject1.get("items");

                channel_adi = (String) jSONArray1.getJSONObject(0).getJSONObject("snippet").get("title");
                channel_aciklama = (String) jSONArray1.getJSONObject(0).getJSONObject("snippet").get("description");
                channel_goruntulenme_sayisi = Integer.parseInt((String) jSONArray1.getJSONObject(0).getJSONObject("statistics").get("viewCount"));
                abone_sayisi = Integer.parseInt((String) jSONArray1.getJSONObject(0).getJSONObject("statistics").get("subscriberCount"));
                toplam_video_sayisi = Integer.parseInt((String) jSONArray1.getJSONObject(0).getJSONObject("statistics").get("videoCount"));
                channel_yorum_sayisi = Integer.parseInt((String) jSONArray1.getJSONObject(0).getJSONObject("statistics").get("commentCount"));
                kurulus_tarihi = (String) jSONArray1.getJSONObject(0).getJSONObject("snippet").get("publishedAt");

            } catch (JSONException ex) {
                Logger.getLogger(Ozel_Channel_Gunluk_Takip.class.getName()).log(Level.SEVERE, null, ex);
            }
            Date date = null;
            try {
                date = simpleDateFormat.parse(kurulus_tarihi);
            } catch (ParseException ex) {
                Logger.getLogger(Ozel_Channel_Gunluk_Takip.class.getName()).log(Level.SEVERE, null, ex);
            }

//            String sql_ozel_channel_takip = "insert into samet_feyyaz.ozel_channel_depo "
//                    + "(channel_id,adi,aciklama,goruntulenme_sayisi,abone_sayisi,toplam_video_sayisi,"
//                    + "kurulus_tarihi,yorum_sayisi,sorgu_tarihi) "
//                    + "VALUES(?,?,?,?,?,?,?,?,?)";

                //            try {
//                preparedStatement = ds.getConnection().prepareStatement(sql_ozel_channel_takip);
//                preparedStatement.setString(1, gelen_ozel_channel_takip);
//                preparedStatement.setString(2, channel_adi);
//                preparedStatement.setString(3, channel_aciklama);
//                preparedStatement.setInt(4, channel_goruntulenme_sayisi);
//                preparedStatement.setInt(5, abone_sayisi);
//                preparedStatement.setInt(6, toplam_video_sayisi);
//                preparedStatement.setTimestamp(7, new Timestamp(date.getTime()));
//                preparedStatement.setInt(8, channel_yorum_sayisi);
//                preparedStatement.setTimestamp(9, new Timestamp(new Date().getTime()));
//                preparedStatement.executeUpdate();
//            } catch (SQLException ex) {
//                Logger.getLogger(Ozel_Channel_Gunluk_Takip.class.getName()).log(Level.SEVERE, null, ex);
//            }
            try {
                qr.update("insert into samet_feyyaz.ozel_channel_depo "
                        + "(channel_id,adi,aciklama,goruntulenme_sayisi,abone_sayisi,toplam_video_sayisi,"
                        + "kurulus_tarihi,yorum_sayisi,sorgu_tarihi) "
                        + "VALUES(?,?,?,?,?,?,?,?,?)",
                        gelen_ozel_channel_takip,
                        channel_adi,
                        channel_aciklama,
                        channel_goruntulenme_sayisi,
                        abone_sayisi,
                        toplam_video_sayisi,
                        new Timestamp(date.getTime()),
                        channel_yorum_sayisi,
                        new Timestamp(new Date().getTime()));
            } catch (SQLException ex) {
                Logger.getLogger(Ozel_Channel_Gunluk_Takip.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }

}

class Ozel_Channel_Gunluk_Takip_Kuyruk_Getir implements Runnable {

    LinkedBlockingQueue<String> ozel_channel_takip;
    
    QueryRunner qr;
    ArrayListHandler alh = Youtube_Thread.alh;

//    DataSource ds = Db_datasource.getDataSource(
//            "com.mysql.jdbc.Driver",
//            "jdbc:mysql://95.211.242.157:3306/?useUnicode=true&characterEncoding=UTF-8&rewriteBatchedStatements=true",
//            "feyyaz", "feyyaz2015");
//    QueryRunner qr = new QueryRunner(ds);
//    ArrayListHandler alh = new ArrayListHandler();

    public Ozel_Channel_Gunluk_Takip_Kuyruk_Getir(LinkedBlockingQueue<String> ozel_channel_takip, QueryRunner qr) {
        this.ozel_channel_takip = ozel_channel_takip;
        this.qr = qr;
    }

    @Override
    public void run() {
        while (true) {
            List<Object[]> query = null;
            try {
                query = qr.query("select channel_id from samet_feyyaz.ozel_channel", alh);
            } catch (SQLException ex) {
                Logger.getLogger(Ozel_Channel_Gunluk_Takip_Kuyruk_Getir.class.getName()).log(Level.SEVERE, null, ex);
            }

            for (Object[] object : query) {
                if (object != null) {
                    try {
                        ozel_channel_takip.put(object[0].toString());
                    } catch (InterruptedException ex) {
                        Logger.getLogger(Ozel_Channel_Gunluk_Takip_Kuyruk_Getir.class.getName()).log(Level.SEVERE, null, ex);
                    }
                }
            }

            try {
                Thread.sleep(3 * 24 * 60 * 60 * 1000);       //3 günde bir channel kontrol
            } catch (InterruptedException ex) {
                Logger.getLogger(Ozel_Channel_Gunluk_Takip_Kuyruk_Getir.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }

}
