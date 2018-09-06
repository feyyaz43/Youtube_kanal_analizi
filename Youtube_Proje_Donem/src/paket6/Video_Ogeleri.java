package paket6;

import java.io.BufferedReader;
import java.io.IOException;
import java.io.InputStreamReader;
import java.net.URL;
import java.net.URLConnection;
import java.sql.Timestamp;
import java.util.Objects;

public class Video_Ogeleri {

    public String video_id;
    public String adi;
    public String aciklama;
    public int goruntulenme_sayisi;
    public int like_sayisi;
    public int dislike_sayisi;
    public String suresi;
    public int toplam_yorum_sayisi;
    public String license;
    public Timestamp yukleme_tarihi;
    public int kategori;
    public String channel_id;
    int sorgu_sayisi;

    public boolean equals(Object obj) {
        if (obj instanceof Video_Ogeleri) {
            Video_Ogeleri other = (Video_Ogeleri) obj;
            return (video_id.equals(other.getVideo_id()));
        }
        return false;
    }
    
    public int hashCode() {
        int hash = 5;
        hash = 37 * hash + Objects.hashCode(this.video_id);
        return hash;

    }


    public String getVideo_id() {
        return video_id;
    }

    public String getAdi() {
        return adi;
    }

    public String getAciklama() {
        return aciklama;
    }

    public int getGoruntulenme_sayisi() {
        return goruntulenme_sayisi;
    }

    public int getLike_sayisi() {
        return like_sayisi;
    }

    public int getDislike_sayisi() {
        return dislike_sayisi;
    }

    public String getSuresi() {
        return suresi;
    }

    public int getToplam_yorum_sayisi() {
        return toplam_yorum_sayisi;
    }

    public String getLicense() {
        return license;
    }

    public Timestamp getYukleme_tarihi() {
        return yukleme_tarihi;
    }

    public int getKategori() {
        return kategori;
    }

    public String getChannel_id() {
        return channel_id;
    }
    
    public int getSorgu_Sayisi() {
        return sorgu_sayisi;
    }

    public void setVideo_id(String video_id) {
        this.video_id = video_id;
    }

    public void setAdi(String adi) {
        this.adi = adi;
    }

    public void setAciklama(String aciklama) {
        this.aciklama = aciklama;
    }

    public void setGoruntulenme_sayisi(int goruntulenme_sayisi) {
        this.goruntulenme_sayisi = goruntulenme_sayisi;
    }

    public void setLike_sayisi(int like_sayisi) {
        this.like_sayisi = like_sayisi;
    }

    public void setDislike_sayisi(int dislike_sayisi) {
        this.dislike_sayisi = dislike_sayisi;
    }

    public void setSuresi(String suresi) {
        this.suresi = suresi;
    }

    public void setToplam_yorum_sayisi(int toplam_yorum_sayisi) {
        this.toplam_yorum_sayisi = toplam_yorum_sayisi;
    }

    public void setLicense(String license) {
        this.license = license;
    }

    public void setYukleme_tarihi(Timestamp yukleme_tarihi) {
        this.yukleme_tarihi = yukleme_tarihi;
    }

    public void setKategori(int kategori) {
        this.kategori = kategori;
    }

    public void setChannel_id(String channel_id) {
        this.channel_id = channel_id;
    }
    
    public void setSorgu_Sayisi(int sorgu_sayisi) {
        this.sorgu_sayisi = sorgu_sayisi;
    }
    
    public static String getUrl(String url1) {
        String jsonS = "";
        String nextLine;
        URL url = null;
        URLConnection urlConn = null;
        InputStreamReader inStream = null;
        BufferedReader buff = null;
        try {
            // Create the URL obect that points
            // at the default file index.html
            url = new URL(url1);
            urlConn = url.openConnection();
            inStream = new InputStreamReader(urlConn.getInputStream());
            buff = new BufferedReader(inStream);

            // Read and print the lines from index.html
            while (true) {
                nextLine = buff.readLine();
                if (nextLine != null) {
                    //System.out.println(nextLine);
                    jsonS += nextLine;
                } else {
                    break;
                }
            }

        } catch (IOException e1) {
            System.out.println("Can't read  from the Internet: "
                    + e1.toString());
        }

        return jsonS;
    }

}
