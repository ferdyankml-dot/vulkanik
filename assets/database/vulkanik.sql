-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 20 Nov 2026 pada 11.16
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.2.12

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `nada_vulkanik`
--
-- Fungsi database: menyimpan data berita, orang hilang, dan akun administrator Vulkanik.
-- Catatan: aplikasi PHP saat ini memakai database `vulkanik`, bukan `nada_vulkanik`.

-- --------------------------------------------------------

-- --------------------------------------------------------

--
-- Struktur dari tabel `berita`
--
-- Fungsi: menampung daftar berita yang ditampilkan pada halaman berita.
-- Kolom utama:
-- id = identifier unik berita
-- judul = judul artikel
-- konten = isi/rangkuman artikel
-- gambar = nama/path gambar artikel
-- created_at = waktu artikel dibuat dan urutan berita terbaru

CREATE TABLE `berita` (
  `id` int(11) NOT NULL,
  `judul` varchar(255) NOT NULL,
  `konten` text NOT NULL,
  `gambar` varchar(255) DEFAULT NULL,
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `orang_hilang`
--
-- Fungsi: sumber data CRUD orang hilang pada admin dan pencarian publik.
-- Kolom utama:
-- id = identifier unik orang hilang
-- nama, umur, alamat = identitas dasar
-- ciri_fisik = ciri pencarian
-- tanggal_hilang = tanggal kejadian
-- lokasi_hilang = lokasi atau kawasan terakhir
-- foto = path foto pada folder uploads
-- status = hilang atau ditemukan
-- created_at = waktu data dimasukkan

CREATE TABLE `orang_hilang` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `umur` int(11) DEFAULT NULL,
  `alamat` text DEFAULT NULL,
  `ciri_fisik` text DEFAULT NULL,
  `tanggal_hilang` date DEFAULT NULL,
  `lokasi_hilang` varchar(255) DEFAULT NULL,
  `foto` varchar(255) DEFAULT NULL,
  `status` enum('hilang','ditemukan') DEFAULT 'hilang',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `orang_hilang`
--

INSERT INTO `orang_hilang` (`id`, `nama`, `umur`, `alamat`, `ciri_fisik`, `tanggal_hilang`, `lokasi_hilang`, `foto`, `status`, `created_at`) VALUES
(1, 'Ismail bin Ahmad', 25, 'Jl. Merapi No. 123, Yogyakarta', 'Tinggi 170cm, rambut hitam lurus, tahi lalat di pipi kiri', '2024-01-15', 'Lereng Gunung Merapi', NULL, 'hilang', '2025-11-24 09:12:14'),
(2, 'Siti Rahayu', 32, 'Ds. Sumberejo, Magelang', 'Berkacamata, kulit sawo matang, badan berisi', '2024-01-10', 'Kawasan Gunung Merbabu', NULL, 'hilang', '2025-11-24 09:12:14'),
(3, 'Budi Santoso', 45, 'Jl. Kaliurang Km 12', 'Postur tinggi, rambut pendek, berkumis', '2024-01-08', 'Gunung Merapi Area', NULL, 'ditemukan', '2025-11-24 09:12:14');

-- --------------------------------------------------------

--
-- Struktur dari tabel `users`
--
-- Fungsi: menyimpan akun administrator yang dapat masuk ke panel admin.
-- Kolom utama:
-- id = identifier unik akun
-- nama = nama/username administrator
-- email = email untuk login
-- password = password akun dalam bentuk teks atau hash MD5
-- role = membatasi akun pada role admin
-- created_at = waktu akun dibuat

CREATE TABLE `users` (
  `id` int(11) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `email` varchar(255) NOT NULL,
  `password` varchar(255) NOT NULL,
  `role` enum('admin') DEFAULT 'admin',
  `created_at` timestamp NOT NULL DEFAULT current_timestamp()
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4 COLLATE=utf8mb4_general_ci;

--
-- Dumping data untuk tabel `users`
--

INSERT INTO `users` (`id`, `nama`, `email`, `password`, `role`, `created_at`) VALUES
(1, 'Administrator', 'admin@nadavulkanik.com', '0192023a7bbd73250516f069df18b500', 'admin', '2025-11-24 08:26:42');

--
-- Indexes for dumped tables
--

-- Indeks untuk tabel `berita`
--
-- Fungsi indeks: mempercepat pencarian dan menjaga id berita tetap unik.
ALTER TABLE `berita`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `orang_hilang`
--
-- Fungsi indeks: mempercepat pencarian record dan menjaga id orang hilang tetap unik.
ALTER TABLE `orang_hilang`
  ADD PRIMARY KEY (`id`);

-- Indeks untuk tabel `users`
--
-- Fungsi indeks: menjaga id dan email administrator tetap unik.
ALTER TABLE `users`
  ADD PRIMARY KEY (`id`),
  ADD UNIQUE KEY `email` (`email`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

-- AUTO_INCREMENT untuk tabel `berita`
--
-- Fungsi: menghasilkan id berita baru secara otomatis.
ALTER TABLE `berita`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT;

--
-- AUTO_INCREMENT untuk tabel `orang_hilang`
--
-- Fungsi: menghasilkan id orang hilang baru secara otomatis.
ALTER TABLE `orang_hilang`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=4;

-- AUTO_INCREMENT untuk tabel `users`
--
-- Fungsi: menghasilkan id akun administrator baru secara otomatis.
ALTER TABLE `users`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=2;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
