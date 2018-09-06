/*
 * To change this license header, choose License Headers in Project Properties.
 * To change this template file, choose Tools | Templates
 * and open the template in the editor.
 */
package paket6;

import com.fatihhalimoglu.java.dbtools.v2.Db_datasource;
import java.util.Date;
import java.util.concurrent.LinkedBlockingQueue;
import java.util.logging.Level;
import java.util.logging.Logger;
import javax.sql.DataSource;
import org.apache.commons.dbutils.QueryRunner;
import org.apache.commons.dbutils.handlers.ArrayListHandler;

public class Youtube_Thread {

    LinkedBlockingQueue<String> ozel_channel_ilk_kuyruk = new LinkedBlockingQueue<>();
    LinkedBlockingQueue<String> ozel_channel_son_video_kuyruk = new LinkedBlockingQueue<>();
    LinkedBlockingQueue<String> islem1_kuyruk = new LinkedBlockingQueue<>();
    LinkedBlockingQueue<String> islem2_kuyruk = new LinkedBlockingQueue<>();
    LinkedBlockingQueue<String> islem3_kuyruk = new LinkedBlockingQueue<>();
    LinkedBlockingQueue<String> islem4_kuyruk = new LinkedBlockingQueue<>();
    LinkedBlockingQueue<String> islem5_kuyruk = new LinkedBlockingQueue<>();
    LinkedBlockingQueue<String> islem6_kuyruk = new LinkedBlockingQueue<>();
    LinkedBlockingQueue<String> islem7_kuyruk = new LinkedBlockingQueue<>();
    LinkedBlockingQueue<String> islem8_kuyruk = new LinkedBlockingQueue<>();
    LinkedBlockingQueue<String> ozel_channel_takip = new LinkedBlockingQueue<>();

    public static ArrayListHandler alh = new ArrayListHandler();

    public Youtube_Thread() {

        DataSource ds = Db_datasource.getDataSource(
                "com.mysql.jdbc.Driver",
                "jdbc:mysql://95.211.242.157:3306/?useUnicode=true&characterEncoding=UTF-8&rewriteBatchedStatements=true",
                "feyyaz", "feyyaz2015");
        QueryRunner qr = new QueryRunner(ds);

        new Thread(new Kamera(ozel_channel_ilk_kuyruk,
                islem1_kuyruk, islem2_kuyruk, islem3_kuyruk, islem4_kuyruk,
                islem5_kuyruk, islem6_kuyruk, islem7_kuyruk, islem8_kuyruk,
                ozel_channel_son_video_kuyruk, ozel_channel_takip)).start();

        new Thread(new Ozel_Channel_Getir_ilk(ozel_channel_ilk_kuyruk, qr)).start();

        new Thread(new Ozel_Channel_ilk_islem(ozel_channel_ilk_kuyruk, qr)).start();
        new Thread(new Ozel_Channel_ilk_islem(ozel_channel_ilk_kuyruk, qr)).start();
//        new Thread(new Ozel_Channel_ilk_islem(ozel_channel_ilk_kuyruk, qr)).start();
//        new Thread(new Ozel_Channel_ilk_islem(ozel_channel_ilk_kuyruk, qr)).start();
//        new Thread(new Ozel_Channel_ilk_islem(ozel_channel_ilk_kuyruk, qr)).start();

        new Thread(new Ozel_Channel_Son_Video_Getir(ozel_channel_son_video_kuyruk, qr)).start();

        new Thread(new Ozel_Channel_Son_Video_islem(ozel_channel_son_video_kuyruk, qr)).start();
        new Thread(new Ozel_Channel_Son_Video_islem(ozel_channel_son_video_kuyruk, qr)).start();

        new Thread(new Ozel_Video_islem1_Kuyruk_Getir(islem1_kuyruk, qr)).start();
        new Thread(new Ozel_Video_islem1(islem1_kuyruk, qr)).start();

        new Thread(new Ozel_Video_islem2_Kuyruk_Getir(islem2_kuyruk, qr)).start();
        new Thread(new Ozel_Video_islem2(islem2_kuyruk, qr)).start();

        new Thread(new Ozel_Video_islem3_Kuyruk_Getir(islem3_kuyruk, qr)).start();
        new Thread(new Ozel_Video_islem3(islem3_kuyruk, qr)).start();

        new Thread(new Ozel_Video_islem4_Kuyruk_Getir(islem4_kuyruk, qr)).start();
        new Thread(new Ozel_Video_islem4(islem4_kuyruk, qr)).start();

        new Thread(new Ozel_Video_islem5_Kuyruk_Getir(islem5_kuyruk, qr)).start();
        new Thread(new Ozel_Video_islem5(islem5_kuyruk, qr)).start();

        new Thread(new Ozel_Video_islem6_Kuyruk_Getir(islem6_kuyruk, qr)).start();
        new Thread(new Ozel_Video_islem6(islem6_kuyruk, qr)).start();

        new Thread(new Ozel_Video_islem7_Kuyruk_Getir(islem7_kuyruk, qr)).start();
        new Thread(new Ozel_Video_islem7(islem7_kuyruk, qr)).start();

        new Thread(new Ozel_Video_islem8_Kuyruk_Getir(islem8_kuyruk, qr)).start();
        new Thread(new Ozel_Video_islem8(islem8_kuyruk, qr)).start();

        new Thread(new Ozel_Channel_Gunluk_Takip_Kuyruk_Getir(ozel_channel_takip, qr)).start();
        new Thread(new Ozel_Channel_Gunluk_Takip(ozel_channel_takip, qr)).start();
    }

    public static void main(String[] args) {
        new Youtube_Thread();
    }

}

class Kamera implements Runnable {

    LinkedBlockingQueue<String> ozel_channel_ilk_kuyruk;
    LinkedBlockingQueue<String> islem1_kuyruk, islem2_kuyruk, islem3_kuyruk, islem4_kuyruk, islem5_kuyruk, islem6_kuyruk, islem7_kuyruk, islem8_kuyruk;
    LinkedBlockingQueue<String> ozel_channel_son_video_kuyruk;
    LinkedBlockingQueue<String> ozel_channel_takip;

    public Kamera(LinkedBlockingQueue<String> ozel_channel_ilk_kuyruk,
            LinkedBlockingQueue<String> islem1_kuyruk, LinkedBlockingQueue<String> islem2_kuyruk,
            LinkedBlockingQueue<String> islem3_kuyruk, LinkedBlockingQueue<String> islem4_kuyruk,
            LinkedBlockingQueue<String> islem5_kuyruk, LinkedBlockingQueue<String> islem6_kuyruk,
            LinkedBlockingQueue<String> islem7_kuyruk, LinkedBlockingQueue<String> islem8_kuyruk,
            LinkedBlockingQueue<String> ozel_channel_son_video_kuyruk,
            LinkedBlockingQueue<String> ozel_channel_takip
    ) {

        this.ozel_channel_ilk_kuyruk = ozel_channel_ilk_kuyruk;
        this.islem1_kuyruk = islem1_kuyruk;
        this.islem2_kuyruk = islem2_kuyruk;
        this.islem3_kuyruk = islem3_kuyruk;
        this.islem4_kuyruk = islem4_kuyruk;
        this.islem5_kuyruk = islem5_kuyruk;
        this.islem6_kuyruk = islem6_kuyruk;
        this.islem7_kuyruk = islem7_kuyruk;
        this.islem8_kuyruk = islem8_kuyruk;
        this.ozel_channel_son_video_kuyruk = ozel_channel_son_video_kuyruk;
        this.ozel_channel_takip = ozel_channel_takip;
    }

    @Override
    public void run() {
        while (true) {

            System.out.println(new Date());
            System.out.println("ozel_channel_ilk_kuyruk: " + ozel_channel_ilk_kuyruk.size());
            System.out.println("islem1_kuyruk: " + islem1_kuyruk.size() + " islem2_kuyruk: " + islem2_kuyruk.size());
            System.out.println("islem3_kuyruk: " + islem3_kuyruk.size() + " islem4_kuyruk: " + islem4_kuyruk.size());
            System.out.println("islem5_kuyruk: " + islem5_kuyruk.size() + " islem6_kuyruk: " + islem6_kuyruk.size());
            System.out.println("islem7_kuyruk: " + islem7_kuyruk.size() + " islem8_kuyruk: " + islem8_kuyruk.size());
            System.out.println("ozel_channel_son_video_kuyruk : " + ozel_channel_son_video_kuyruk.size());
            System.out.println("ozel_channel_takip : " + ozel_channel_takip.size());
            System.out.println("*************************");

            try {
                Thread.sleep(10000);
            } catch (InterruptedException ex) {
                Logger.getLogger(Kamera.class.getName()).log(Level.SEVERE, null, ex);
            }
        }
    }

}
