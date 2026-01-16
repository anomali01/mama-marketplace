# SCOPE PROJECT - MAMA MARKETPLACE

## 1. INFORMASI PROJECT
**Nama Project:** MAMA Marketplace  
**Platform:** Web Application  
**Framework:** Laravel (PHP)  
**Database:** MySQL  
**Frontend:** Blade Templates, Tailwind CSS, Vite  

---

## 2. TUJUAN PROJECT
Membangun platform marketplace khusus untuk lingkungan kampus yang memungkinkan mahasiswa untuk menjual dan membeli produk dengan sistem verifikasi validator kampus.

---

## 3. PROJECT SCOPE

| **Scope** | **In Scope** | **Out Scope** |
|-----------|--------------|---------------|
| **Fitur Utama** | • Sistem autentikasi dan registrasi mahasiswa berbasis program studi<br>• Manajemen produk dengan upload multi-image<br>• Sistem verifikasi produk oleh validator kampus<br>• Keranjang belanja dan checkout<br>• Upload bukti pembayaran manual (transfer bank)<br>• Konfirmasi pembayaran oleh penjual<br>• Sistem chat langsung (real-time) antar pengguna<br>• Notifikasi real-time untuk aktivitas transaksi<br>• Dashboard penjual untuk kelola produk dan pesanan<br>• Dashboard validator untuk approve/reject produk<br>• Sistem balance dan penarikan saldo penjual<br>• Tracking status pesanan (Pending, Paid, Packed, Shipped, Delivered)<br>• Pencarian dan filter produk<br>• Trending products berdasarkan popularitas<br>• Fungsionalitas transaksi antar-kampus | • Integrasi payment gateway pihak ketiga (misalnya: e-wallet, VA, kartu kredit)<br>• Sistem logistik atau integrasi dengan jasa pengiriman otomatis<br>• Sistem rating dan review produk<br>• Sistem promosi/voucher/diskon otomatis<br>• Mobile application (Android/iOS)<br>• Multi-language support<br>• Fitur livestream/video product showcase<br>• Sistem escrow otomatis<br>• Integrasi marketplace eksternal |

---

## 4. FITUR DETAIL

### 4.1 Manajemen Pengguna
- **Registrasi & Login** dengan verifikasi program studi (prodi)
- **Role-based access**: Pembeli, Penjual, Validator
- **Profile Management** dengan pengaturan akun dan password
- **System Notifikasi** real-time untuk aktivitas pengguna

### 4.2 Manajemen Produk
- **CRUD Produk** dengan upload gambar multi-image
- **Kategorisasi Produk** berdasarkan kategori
- **Status Produk**: Pending, Approved, Rejected
- **Verifikasi Produk** oleh validator sebelum tayang
- **Pencarian & Filter** produk
- **Trending Products** untuk produk populer

### 4.3 Sistem Transaksi
- **Keranjang Belanja (Cart)** untuk memilih produk
- **Checkout & Order Management** 
- **Upload Bukti Pembayaran** oleh pembeli
- **Konfirmasi Pembayaran** oleh penjual
- **Status Order**: Pending, Paid, Packed, Shipped, Delivered
- **Upload Bukti Pengiriman** oleh penjual
- **Order History** untuk pembeli dan penjual

### 4.4 Sistem Penjual
- **Registrasi Penjual** dengan data toko
- **Dashboard Penjual** untuk kelola produk dan pesanan
- **Manajemen Toko** (edit profil toko)
- **Balance & Transaction Log** untuk tracking pendapatan
- **Withdrawal Request** untuk penarikan saldo

### 4.5 Sistem Validator
- **Dashboard Validator** dengan overview produk
- **Verifikasi Produk Pending** (Approve/Reject)
- **Riwayat Verifikasi** (Verified & Rejected products)
- **Manajemen Penjual** (monitoring seller activity)
- **Alasan Penolakan** produk yang tidak sesuai

### 4.6 Komunikasi
- **Live Chat/Messaging** antara pembeli dan penjual
- **Unread Message Counter**
- **Notifikasi** untuk pesan baru, order, dan verifikasi produk

---

## 5. TEKNOLOGI YANG DIGUNAKAN

### Backend
- **PHP 8.x** dengan **Laravel Framework**
- **MySQL Database** untuk penyimpanan data
- **Eloquent ORM** untuk database operations
- **Laravel Authentication** untuk sistem login

### Frontend
- **Blade Template Engine** untuk views
- **Tailwind CSS** untuk styling
- **JavaScript/Alpine.js** untuk interaktivity
- **Vite** sebagai build tool

### Deployment
- **InfinityFree** hosting (berdasarkan file database_infinityfree.sql)

---

## 6. AKTOR/PENGGUNA SISTEM

1. **Mahasiswa (Pembeli)**
   - Dapat browse dan beli produk
   - Chat dengan penjual
   - Upload bukti pembayaran
   - Tracking pesanan

2. **Mahasiswa (Penjual)**
   - Registrasi sebagai penjual
   - Kelola produk (menunggu verifikasi)
   - Kelola pesanan masuk
   - Kelola saldo dan penarikan

3. **Validator Kampus**
   - Verifikasi produk yang diajukan penjual
   - Monitoring aktivitas penjual
   - Approve/Reject produk dengan alasan

---

## 7. DATABASE ENTITIES (Models)

- **User** - Data pengguna (mahasiswa)
- **StudyProgram** - Program studi kampus
- **Category** - Kategori produk
- **Product** - Produk yang dijual
- **Order** - Pesanan/transaksi
- **OrderItem** - Detail item dalam pesanan
- **Message** - Pesan chat antar user
- **Notification** - Notifikasi sistem
- **Balance** - Saldo penjual
- **TransactionLog** - Log transaksi
- **WithdrawalRequest** - Pengajuan penarikan saldo

---

## 8. WORKFLOW UTAMA

### 8.1 Alur Penjualan Produk
1. Penjual mendaftar/registrasi toko
2. Penjual upload produk → status **Pending**
3. Validator review produk → **Approve** atau **Reject**
4. Jika Approved → produk tampil di marketplace
5. Pembeli lihat & beli produk
6. Pembeli checkout & upload bukti bayar
7. Penjual konfirmasi pembayaran
8. Penjual pack & kirim produk
9. Saldo masuk ke balance penjual
10. Penjual dapat withdraw saldo

### 8.2 Alur Pembelian
1. Pembeli browse produk
2. Tambah ke cart
3. Checkout
4. Upload bukti transfer
5. Tunggu konfirmasi penjual
6. Produk dikemas & dikirim
7. Pembeli terima produk

---

## 9. KEAMANAN

- **Authentication & Authorization** dengan Laravel Middleware
- **Role-based Access Control** (Buyer, Seller, Validator)
- **CSRF Protection** pada semua form
- **Password Hashing** dengan bcrypt
- **Session Management** untuk keamanan login
- **File Upload Validation** untuk gambar produk

---

## 10. DELIVERABLES

✅ Source Code Aplikasi (Laravel Project)  
✅ Database Migration Files  
✅ Database Seeder untuk sample data  
✅ User Interface (Blade Views)  
✅ Documentation (README)  

---

**Dibuat:** Januari 2026  
**Status:** In Development  
**Target User:** Mahasiswa dalam lingkungan kampus
