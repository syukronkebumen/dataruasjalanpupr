# 📍 Data Ruas Jalan – Dinas PUPR

Project **Data Ruas Jalan Dinas PUPR** merupakan aplikasi berbasis web yang digunakan untuk menampilkan, mengelola, dan memvisualisasikan data ruas jalan milik Dinas Pekerjaan Umum dan Penataan Ruang (PUPR).

Aplikasi ini dirancang untuk mendukung kebutuhan **perencanaan, monitoring, dan pengambilan keputusan** terkait infrastruktur jalan, dengan penyajian data yang informatif dan mudah dipahami.

---

## ✨ Fitur Utama

* 📊 **Manajemen Data Ruas Jalan**
  Menampilkan informasi ruas jalan seperti nama ruas, nomor ruas, kecamatan, wilayah, panjang jalan, dan kondisi jalan.

* 🗺️ **Peta Interaktif (GIS)**
  Visualisasi ruas jalan menggunakan peta interaktif (Leaflet) berbasis koordinat/polyline.

* 📁 **Import Data dari Excel**
  Data ruas jalan dapat diambil langsung dari file Excel tanpa melalui database.

* 🎨 **Klasifikasi Warna Jalan**
  Warna ruas jalan otomatis menyesuaikan kondisi jalan (baik, sedang, rusak) beserta legend dinamis.

* 🔍 **Detail Informasi Ruas**
  Klik ruas jalan pada peta untuk melihat detail lengkap data.

---

## 🛠️ Teknologi yang Digunakan

* **Backend**: Laravel 11 / 12
* **Frontend**: HTML, CSS, JavaScript
* **Peta**: Leaflet.js
* **Data**: Excel (.xlsx)
* **Web Server**: Apache / Nginx

---

## 📂 Struktur Data Excel

Contoh kolom yang digunakan pada file Excel:

* Nama Ruas
* Nomor Ruas
* Kecamatan
* Wilayah
* Kondisi Jalan
* Koordinat (Latitude, Longitude / Polyline)

---

## 📌 Tujuan Pengembangan

* Mendukung transparansi data infrastruktur jalan
* Mempermudah monitoring kondisi jalan
* Menjadi dasar perencanaan dan evaluasi pembangunan
* Digitalisasi data jalan berbasis GIS

---

## 🤝 Kontribusi

Kontribusi sangat terbuka. Silakan lakukan:

1. Fork repository ini
2. Buat branch fitur (`feature/nama-fitur`)
3. Commit perubahan
4. Ajukan Pull Request

---

## 📄 Lisensi

Project ini dikembangkan untuk kebutuhan internal dan publik Dinas PUPR. Penggunaan dan pengembangan lanjutan menyesuaikan kebijakan instansi terkait.

---

> _"Membangun infrastruktur yang baik dimulai dari data yang akurat."
