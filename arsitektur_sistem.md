# Panduan Arsitektur & Logika Sistem: BloodLink 🩸

Selamat datang di panduan pembelajaran proyek **BloodLink**! Dokumen ini dirancang untuk membantu Anda memahami bagaimana aplikasi ini dibangun, mulai dari arsitektur dasar hingga algoritma yang menggerakkan fitur-fiturnya.

---

## 1. Arsitektur Dasar: Konsep MVC (Laravel)
Proyek ini dibangun menggunakan *framework* PHP **Laravel** yang menerapkan pola desain **MVC (Model-View-Controller)**:

*   **Model (`app/Models`)**: Bertanggung jawab berinteraksi langsung dengan *database* (seperti `User`, `Donor`, `StokDarah`). Di sini kita mendefinisikan relasi antar tabel (misalnya: *User memiliki satu Profil Pendonor*).
*   **View (`resources/views`)**: Antarmuka pengguna (UI) yang Anda lihat. File berakhiran `.blade.php` seperti `dashboard.blade.php` atau `app.blade.php` yang baru saja kita poles menjadi *Professional White Mode*.
*   **Controller (`app/Http/Controllers`)**: Otak dari aplikasi. Mengambil request dari pengguna, memanggil Model untuk mengambil/menyimpan data, lalu melempar data tersebut ke View.

---

## 2. Struktur Hak Akses (Multi-Role System)
Sistem ini menggunakan algoritma **RBAC (Role-Based Access Control)**. Tabel `users` memiliki satu kolom sakti yaitu `role` bertipe `ENUM`. 

Terdapat 5 pintu masuk (*dashboard*) yang berbeda tergantung *role* saat proses *login*:
1.  🛡️ **Admin**: Pengendali penuh sistem (Manajemen User, Data Master Rumah Sakit, dll).
2.  👨‍⚕️ **Petugas PMI**: Ujung tombak operasional (Mengelola stok, skrining pendonor, memproses permintaan RS).
3.  👤 **Pendonor**: Masyarakat umum (Mendaftar jadwal donor, melihat riwayat donor).
4.  🏥 **Rumah Sakit**: Institusi mitra (Melihat ketersediaan stok darah PMI dan mengajukan permohonan darah).
5.  👑 **Pimpinan PMI**: Pemantau strategis (Hanya melihat laporan analitik dan *monitoring* kinerja).

> [!TIP]
> **Bagaimana Laravel memisahkannya?**
> Biasanya, Laravel menggunakan **Middleware** (misal: `RoleMiddleware`). Ketika ada yang mencoba mengakses URL `/petugas/dashboard`, Middleware akan mengecek: *"Apakah role user ini petugas_pmi?"* Jika bukan, sistem akan melemparnya kembali.

---

## 3. Algoritma Utama (Core Business Logic)

Di bawah ini adalah alur logika (algoritma) dari fitur-fitur krusial dalam aplikasi BloodLink:

### A. Algoritma Proses Donor Darah (Pendonor -> Petugas)
Ini adalah jantung aplikasi. Alurnya tidak serta merta langsung menambah stok.
1.  **Registrasi**: Pendonor memilih `Jadwal Donor` melalui dashboard-nya. Data masuk ke tabel `donor` dengan status awal `terdaftar`. (Algoritma akan mengecek kuota jadwal, jika penuh pendaftaran ditolak).
2.  **Skrining (Oleh Petugas)**: Saat hari H, Petugas PMI mengecek tekanan darah & hemoglobin. Status diupdate menjadi `lolos_skrining` (jika sehat) atau `ditolak` (jika tidak memenuhi syarat).
3.  **Pengambilan Darah**: Proses donor dilakukan.
4.  **Finalisasi**: Petugas mengubah status menjadi `selesai`.
    *   *Trigger Algoritma*: Saat status menjadi `selesai`, sistem otomatis **menambah** +1 kantong di tabel `stok_darah` sesuai golongan darah dan rhesus pendonor tersebut, lalu mencatatnya ke `riwayat_donor`.

### B. Algoritma Permintaan Darah (Rumah Sakit -> Petugas)
1.  **Request**: Rumah Sakit mengajukan kebutuhan darah (Misal: 5 kantong O+). Data masuk ke tabel `permintaan_darah` dengan status `menunggu`.
2.  **Verifikasi (Oleh Petugas)**: Petugas melihat notifikasi. Sistem mengecek apakah `stok_darah` (O+) $\ge$ 5 kantong?
    *   Jika stok cukup, petugas memproses dan mengubah status menjadi `diproses`.
3.  **Distribusi & Finalisasi**: Saat darah dikirim ke RS, status diubah menjadi `dipenuhi`.
    *   *Trigger Algoritma*: Sistem secara otomatis **mengurangi** -5 kantong pada tabel `stok_darah` (O+).

---

## 4. Desain Sistem (UI/UX)
Kita baru saja melakukan migrasi besar-besaran UI ke **Professional White Mode**.
*   **CSS Variables**: Semua warna (seperti `--primary`, `--bg-surface`, `--text-1`) didefinisikan satu kali di `:root` dalam `layouts/app.blade.php`. Jika ke depan Anda ingin mengubah nuansa aplikasi, Anda hanya perlu mengganti kode warna di satu tempat ini!
*   **Komponen Reusable**: Menggunakan *class* seperti `.bl-card`, `.bl-input`, `.bl-table`. Ini adalah implementasi algoritma pemrograman yang *DRY (Don't Repeat Yourself)* ke dalam level CSS.

---

## 5. Hubungan Antar Tabel (Relational Database)
Jika kita melihat file SQL Anda, databasenya sangat terstruktur (*Normalized*):
*   `users` adalah tabel pusat.
*   Tabel `pendonor` dan `rumah_sakit` menempel pada `users` lewat `user_id` (Relasi *One-to-One*). Artinya satu akun (user) hanya mewakili 1 profil RS atau 1 profil pendonor.
*   Tabel `donor` adalah jembatan (transaksi) yang menghubungkan `pendonor`, `jadwal_donor`, dan `users` (petugas).

## Apa Selanjutnya?
Jika Anda ingin mendalami kode lebih lanjut, Anda bisa mulai mengecek struktur file di folder `app/Http/Controllers/`. Apakah ada logika spesifik (seperti cara menambah stok darah di controller) yang ingin kita pelajari kode *backend*-nya secara langsung?
