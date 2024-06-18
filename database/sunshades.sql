-- phpMyAdmin SQL Dump
-- version 5.2.1
-- https://www.phpmyadmin.net/
--
-- Host: 127.0.0.1
-- Waktu pembuatan: 16 Jun 2024 pada 18.06
-- Versi server: 10.4.32-MariaDB
-- Versi PHP: 8.1.25

SET SQL_MODE = "NO_AUTO_VALUE_ON_ZERO";
START TRANSACTION;
SET time_zone = "+00:00";


/*!40101 SET @OLD_CHARACTER_SET_CLIENT=@@CHARACTER_SET_CLIENT */;
/*!40101 SET @OLD_CHARACTER_SET_RESULTS=@@CHARACTER_SET_RESULTS */;
/*!40101 SET @OLD_COLLATION_CONNECTION=@@COLLATION_CONNECTION */;
/*!40101 SET NAMES utf8mb4 */;

--
-- Database: `sunshades`
--

-- --------------------------------------------------------

--
-- Struktur dari tabel `detail_pesanan`
--

CREATE TABLE `detail_pesanan` (
  `id` int(11) NOT NULL,
  `produk_id` int(11) NOT NULL,
  `qty` int(11) NOT NULL,
  `pesanan_id` int(11) NOT NULL,
  `total_harga` double NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `info_faq`
--

CREATE TABLE `info_faq` (
  `id` int(11) NOT NULL,
  `info` longtext NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `info_faq`
--

INSERT INTO `info_faq` (`id`, `info`) VALUES
(1, 'P: Bagaimana cara memesan kacamata di website ini?\r\nJ: Untuk memesan kacamata, Anda perlu mengikuti langkah-langkah berikut: \r\n1) Pilihlah kacamata yang Anda inginkan dari katalog kami. \r\n2) Masukkan informasi preskripsi mata Anda jika Anda memesan kacamata resep. \r\n3) Tambahkan kacamata ke keranjang belanja Anda dan lanjutkan ke proses pembayaran. \r\n4) Isi informasi pengiriman dan pembayaran yang diminta. \r\n5) Konfirmasikan pesanan Anda dan tunggu konfirmasi pengiriman dari kami.\r\n\r\nP: Apakah saya bisa memesan kacamata dengan resep mata?\r\nJ: Ya, kami menerima pesanan kacamata dengan resep mata. Anda dapat memasukkan informasi preskripsi mata Anda saat memesan dan kami akan membuat kacamata sesuai dengan resep Anda.\r\n\r\nP: Bagaimana cara memasukkan informasi preskripsi mata saat memesan?\r\nJ: Ketika Anda memilih kacamata dengan resep mata, Anda akan melihat opsi untuk memasukkan informasi preskripsi mata. Anda perlu mengisi parameter seperti sph (spherical), cyl (cylinder), axis (sumbu), dan PD (jarak pupil). Anda juga dapat mengunggah salinan resep mata Anda jika diminta.\r\n\r\nP: Berapa lama waktu pemrosesan pesanan?\r\nJ: Waktu pemrosesan pesanan biasanya memakan waktu 1-3 hari kerja setelah kami menerima pembayaran. Setelah itu, kacamata Anda akan dikirimkan sesuai metode pengiriman yang Anda pilih. Anda juga akan menerima nomor pelacakan pengiriman untuk melacak status pesanan Anda.\r\n\r\nP: Apa kebijakan pengembalian barang?\r\nJ: Kami memiliki kebijakan pengembalian barang selama 30 hari setelah tanggal pembelian. Jika Anda tidak puas dengan kacamata yang Anda terima, Anda dapat mengembalikannya dalam kondisi asli dan kami akan mengembalikan pembayaran Anda sesuai kebijakan pengembalian kami.');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kategori_produk`
--

CREATE TABLE `kategori_produk` (
  `id` int(3) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kategori_produk`
--

INSERT INTO `kategori_produk` (`id`, `nama`, `deskripsi`) VALUES
(6, 'NEW ARRIVAL', ''),
(7, 'KACAMATA PRIA', ''),
(8, 'KACAMATA WANITA', ''),
(9, 'KACAMATA ANAK-ANAK', ''),
(10, 'KACAMATA LANSIA', ''),
(11, 'BEST SELLER', '');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kontak`
--

CREATE TABLE `kontak` (
  `id` int(11) NOT NULL,
  `email` varchar(100) NOT NULL,
  `review` text NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kontak`
--

INSERT INTO `kontak` (`id`, `email`, `review`) VALUES
(31, 'andikeren@gmail.com', 'Bagus sekali websitenya dan barangnya'),
(38, 'andikeren@gmail.com', 'woww saya sangat sukaa'),
(41, 'fadli@gmail.com', 'kerennn'),
(42, 'fadli@gmail.com', 'yeayy berhasil bjirr');

-- --------------------------------------------------------

--
-- Struktur dari tabel `kota`
--

CREATE TABLE `kota` (
  `kota_id` int(11) NOT NULL,
  `nama_kota` varchar(255) NOT NULL,
  `ongkir` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `kota`
--

INSERT INTO `kota` (`kota_id`, `nama_kota`, `ongkir`) VALUES
(3, 'Yogyakarta', 0),
(4, 'Jakarta', 5000),
(5, 'Surabaya', 6000),
(6, 'Bandung', 7000),
(7, 'Solo', 2000),
(8, 'Semarang', 3000),
(9, 'Palembang', 11000),
(10, 'Aceh', 14000),
(11, 'Medan', 12500),
(12, 'Makassar', 16500),
(13, 'Manado', 16000),
(14, 'Samarinda', 17500),
(15, 'Balikpapan', 18500),
(16, 'Bali', 8000),
(17, 'NTT', 18000),
(18, 'NTB', 18500),
(19, 'Papua', 24500);

-- --------------------------------------------------------

--
-- Struktur dari tabel `pembayaran`
--

CREATE TABLE `pembayaran` (
  `id` int(11) NOT NULL,
  `id_pesanan` int(11) NOT NULL,
  `id_user` int(11) NOT NULL,
  `bukti_pembayaran` varchar(255) NOT NULL,
  `total` int(11) NOT NULL,
  `status` enum('pending','verified','','') NOT NULL,
  `keterangan` varchar(255) NOT NULL,
  `created_at` datetime NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `pesanan`
--

CREATE TABLE `pesanan` (
  `id` int(5) NOT NULL,
  `tanggal_pesan` datetime NOT NULL,
  `tanggal_digunakan` datetime NOT NULL,
  `user_id` int(5) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `alamat` text NOT NULL,
  `kota_id` varchar(255) NOT NULL,
  `ongkir` int(11) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `read` enum('0','1') NOT NULL,
  `status` enum('lunas','belum lunas','','') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

-- --------------------------------------------------------

--
-- Struktur dari tabel `produk`
--

CREATE TABLE `produk` (
  `id` int(4) NOT NULL,
  `nama` varchar(100) NOT NULL,
  `deskripsi` text NOT NULL,
  `gambar` varchar(200) NOT NULL,
  `harga` decimal(10,0) NOT NULL,
  `kategori_produk_id` int(11) NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `produk`
--

INSERT INTO `produk` (`id`, `nama`, `deskripsi`, `gambar`, `harga`, `kategori_produk_id`) VALUES
(1, 'HSF Hideki Blue', 'HSF Hideki kacamata frame yang di buat menggunakan material Acetate. Model ini dapat digunakan untuk Pria dan Wanita.\r\n\r\nDetail:\r\n\r\nMaterial : Acetate\r\nLensa : Normal\r\nSize : 50-20-148\r\nModel : Unisex', 'HSF Eyewear Hideki Blue.png', 150000, 7),
(2, 'Kacamata Metal Wanita', 'Kacamata ini memiliki tampilan yang elegan, minimalis, dan sering kali ramping. Bingkai logam memberikan tampilan yang ringan dan kuat sehingga cocok untuk penggunaan sehari-hari.\r\n\r\nKacamata metal wanita datang dalam berbagai bentuk dan desain, seperti bulat, persegi, atau cat-eye. ', 'Metal Frame.jpg', 215000, 8),
(3, 'Kacamata Cat Eye Wanita', 'Kacamata Cat Eye Wanita adalah jenis kacamata yang memiliki desain yang khas dengan bentuk yang menyerupai mata kucing. Kacamata ini umumnya memiliki sudut yang tajam di ujung atasnya, memberikan tampilan yang elegan dan feminin. Desain kacamata ini terinspirasi oleh tren fashion dari era 1950-an dan 1960-an, tetapi tetap populer dan digunakan hingga saat ini.', 'Eye Cat.jpg', 165250, 8),
(4, 'Kacamata Round Rose Gold', 'Kacamata Round Rose Gold adalah jenis kacamata yang memiliki warna atau tampilan dominan berupa nuansa merah muda atau keemasan. Deskripsi kacamata Rose Gold dapat mencakup berbagai aspek, termasuk bingkai, lensa, dan desain keseluruhan. ', 'Round Frame.jpg', 155500, 8),
(5, 'Kacamata Metal Kotak Pria', 'Kacamata Metal Kotak Pria adalah jenis kacamata yang memiliki bingkai atau rangka terbuat dari logam dan memiliki bentuk kotak atau persegi panjang. Kacamata ini didesain khusus untuk pria dan menawarkan tampilan yang elegan dan maskulin.', 'Polygon Frame.jpg', 126750, 6),
(6, 'Kalle Rakka', 'Trendy dan eksklusif, seratnya tidak akan sama satu dengan lainnya. Bisa digunakan untuk lensa resep dokter dan nyaman.\r\nBerbeda dengan frame handmade lainnya, kacamata kami ERGONOMIS dan RINGAN. Dibuat oleh craftmaster yang berpengalaman dan dibantu oleh optician.\r\n\r\nDetail Produk\r\n* Nama Kacamata : Kalle Rakka\r\n* Cocok untuk : Pria & Wanita\r\n* Bahan : Bambu\r\n* Lebar Lensa : 45 mm\r\n* Bridge : 17 mm\r\n* Panjang Total Frame : 142 mm\r\n* Tinggi Frame : 50 mm\r\n* Tangkai : 140 mm', 'Kalle Rakka.png', 1750000, 7),
(7, 'Saturdays Fitzroy', 'These aviator-esque frames feature a straight browline for that ultra cool look. Fitzroy is a frame that makes reading look dangerous.', 'Saturdays Fitzroy.png', 1495000, 7),
(8, 'Kacamata Kotak Klasik', 'Kacamata ini memiliki bingkai yang kokoh dan terbuat dari bahan berkualitas tinggi seperti logam atau plastik yang tahan lama. Desainnya sederhana dan elegan, dengan garis-garis lurus yang mencirikan bentuk kotak pada lensa.', 'Kacamata Kotak Klasik.jpeg', 162000, 10),
(9, 'Love Frame', 'Kacamata Love Frame adalah sebuah jenis kacamata dengan desain yang unik dan menarik. Mereka terkenal dengan bingkai yang menampilkan motif atau aksen yang terinspirasi oleh tema cinta dan romantis. Biasanya, kacamata Love Frame memiliki bingkai yang elegan, dengan bentuk dan warna yang berbeda-beda, termasuk nuansa emas, perak, atau warna-warna cerah lainnya.', 'Love Frame.jpg', 95625, 9),
(10, 'Kids Circle Frame', 'Kacamata Kids Circle Frame adalah jenis kacamata yang dirancang khusus untuk anak-anak dengan bingkai berbentuk lingkaran. Kacamata ini memiliki ukuran yang disesuaikan untuk anak-anak agar pas dan nyaman dipakai.\r\n\r\nBingkai kacamata Kids Circle Frame biasanya terbuat dari bahan yang ringan dan tahan lama, seperti plastik atau logam yang aman bagi anak-anak. Bingkai lingkaran memberikan tampilan yang klasik dan stylish, cocok untuk berbagai gaya dan kegiatan anak-anak.', 'Cirle Frame.png', 105025, 9),
(11, 'Oval Frame', 'Kacamata dengan oval frame adalah jenis kacamata yang memiliki bingkai atau frame dengan bentuk oval. Bentuk oval ini dapat memberikan tampilan yang klasik dan elegan pada kacamata. Karakteristik utama dari kacamata dengan oval frame adalah lekukan melengkung yang lebih besar di bagian atas dan bawah frame, sementara sisi-sisinya lebih lurus.', 'Oval Frame.jpeg', 235000, 6),
(12, 'Kacamata Vintage', 'Bingkai kacamata ini terbuat dari berbagai jenis bahan, termasuk plastik, logam, atau bahkan kayu. Bentuk bingkainya juga bervariasi, mulai dari bulat, persegi, hingga bentuk cat-eye yang khas bagi kacamata vintage wanita.', 'Vintage Frame.jpeg', 225000, 6),
(13, 'Star Frame for kids', 'dirancang khusus untuk anak-anak dengan desain yang menarik dan menggemaskan. Frame kacamata anak-anak dengan motif bintang biasanya terbuat dari bahan plastik yang ringan dan tahan lama. Frame ini seringkali memiliki warna-warna cerah dan pilihan desain yang lucu, termasuk gambar-gambar bintang yang menarik perhatian anak-anak. Lensa yang digunakan pada kacamata anak-anak biasanya terbuat dari polikarbonat, yang ringan dan tahan goresan. Lensa ini juga seringkali dilengkapi dengan perlindungan UV untuk melindungi mata anak-anak dari sinar', 'Star Frame.jpg', 95750, 9),
(14, 'Elegan Frame', 'Kategori produk: kacamata untuk membaca\r\nBahan: bingkai logam\r\nGaya: bingkai penuh\r\nModel: 7710\r\nWarna bingkai: bingkai merah\r\nGaya: uniseks\r\nGaya: elegan\r\nDerajat: kacamata untuk membaca + 100 derajat, + 150 derajat, + 200 derajat, + 250 derajat, + 300 derajat, + 350 derajat, + 400 derajat\r\nCocok untuk bentuk wajah: wajah bulat;\r\nLebar Total kacamata: 140mm\r\nTinggi lensa: 34mm\r\nLebar lensa: 53mm\r\nJarak hidung: 16mm\r\nPanjang kaki kacamata: 135mm\r\nBahan: bingkai logam\r\nGaya: bingkai penuh\r\nWarna bingkai: bingkai merah\r\nFungsi: cahaya biru\r\nCocok untuk bentuk wajah: wajah bulat', 'Elegan Frame.jpeg', 356750, 10),
(15, 'YJ760Lens KESMALL', 'Width: 5.1cmLens \r\nHeight: 3.0cm\r\nPelapisan: HMC\r\nBahan Bingkai: ALLOY\r\nBahan Lensa: Akrilik\r\nWarna Lensa: Terang\r\nGender: MENAtribut \r\nOptik Lensa: MIRROR\r\nTipe Barang: Eyewear\r\nTipe Kacamata: Kacamata Baca\r\ncolor: gold gray', 'Kotak Logam.jpg', 452750, 10),
(16, 'Kacamata Cat Eye Wanita ', 'Kacamata Cat Eye Wanita adalah jenis kacamata yang memiliki desain yang khas dengan bentuk yang menyerupai mata kucing. Kacamata ini umumnya memiliki sudut yang tajam di ujung atasnya, memberikan tampilan yang elegan dan feminin. Desain kacamata ini terinspirasi oleh tren fashion dari era 1950-an dan 1960-an, tetapi tetap populer dan digunakan hingga saat ini.', 'Eye Cat.jpg', 165250, 11),
(17, 'Oval Frame', 'Kacamata dengan oval frame adalah jenis kacamata yang memiliki bingkai atau frame dengan bentuk oval. Bentuk oval ini dapat memberikan tampilan yang klasik dan elegan pada kacamata. Karakteristik utama dari kacamata dengan oval frame adalah lekukan melengkung yang lebih besar di bagian atas dan bawah frame, sementara sisi-sisinya lebih lurus.', 'Oval Frame.jpeg', 235000, 11),
(18, 'Round Frame for Woman', 'Kacamata dengan bingkai bulat memiliki desain yang klasik dan retro, yang memberikan sentuhan gaya yang unik dan feminin.\r\nBingkai kacamata bulat untuk wanita terbuat dari berbagai bahan, seperti plastik atau logam. Mereka sering hadir dalam berbagai warna dan pola, yang memungkinkan Anda untuk menyesuaikannya dengan gaya pribadi Anda.\r\n\r\nBingkai kacamata bulat memberikan tampilan yang lembut dan mengelilingi wajah dengan lekuk yang halus. Mereka juga dapat memberikan kesan wajah yang lebih bulat dan berwarna-warni. Pilihan lensa yang tepat juga dapat mempengaruhi tampilan kacamata bulat Anda.', 'Round Frame.jpg', 635000, 11);

-- --------------------------------------------------------

--
-- Struktur dari tabel `user`
--

CREATE TABLE `user` (
  `id` int(5) NOT NULL,
  `username` varchar(50) NOT NULL,
  `email` varchar(75) NOT NULL,
  `telephone` varchar(20) NOT NULL,
  `alamat` text NOT NULL,
  `password` varchar(100) NOT NULL,
  `status` enum('user','admin') NOT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1 COLLATE=latin1_swedish_ci;

--
-- Dumping data untuk tabel `user`
--

INSERT INTO `user` (`id`, `username`, `email`, `telephone`, `alamat`, `password`, `status`) VALUES
(1, 'Administrator', 'admin@gmail.com', '08985432330', 'Semarang Ajah', '21232f297a57a5a743894a0e4a801fc3', 'admin'),
(18, 'fadli', 'fadli@gmail.com', '0812323189', 'yogya', '$2y$10$GV7VqRdscrEhF1nb0x2WnuxnBWPvGHgQOlVpIu2YT1XjTKW9GWkA.', 'user'),
(19, 'andi', 'andikeren@gmail.com', '0812323189', 'jakarta', '$2y$10$R5ywr3fB.Y2jru4kjAFBU.N97OJcAFtRbeDcZNaAp/H3LMMqoUg/K', 'user');

--
-- Indexes for dumped tables
--

--
-- Indeks untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD PRIMARY KEY (`id`,`produk_id`,`pesanan_id`),
  ADD KEY `pesanan_id` (`pesanan_id`),
  ADD KEY `produk_id` (`produk_id`);

--
-- Indeks untuk tabel `info_faq`
--
ALTER TABLE `info_faq`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kategori_produk`
--
ALTER TABLE `kategori_produk`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kontak`
--
ALTER TABLE `kontak`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `kota`
--
ALTER TABLE `kota`
  ADD PRIMARY KEY (`kota_id`);

--
-- Indeks untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  ADD PRIMARY KEY (`id`);

--
-- Indeks untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD PRIMARY KEY (`id`,`user_id`),
  ADD KEY `user_id` (`user_id`);

--
-- Indeks untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD PRIMARY KEY (`id`,`kategori_produk_id`),
  ADD KEY `kategori_produk_id` (`kategori_produk_id`);

--
-- Indeks untuk tabel `user`
--
ALTER TABLE `user`
  ADD PRIMARY KEY (`id`);

--
-- AUTO_INCREMENT untuk tabel yang dibuang
--

--
-- AUTO_INCREMENT untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=52;

--
-- AUTO_INCREMENT untuk tabel `info_faq`
--
ALTER TABLE `info_faq`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=6;

--
-- AUTO_INCREMENT untuk tabel `kategori_produk`
--
ALTER TABLE `kategori_produk`
  MODIFY `id` int(3) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `kontak`
--
ALTER TABLE `kontak`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=43;

--
-- AUTO_INCREMENT untuk tabel `kota`
--
ALTER TABLE `kota`
  MODIFY `kota_id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- AUTO_INCREMENT untuk tabel `pembayaran`
--
ALTER TABLE `pembayaran`
  MODIFY `id` int(11) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=12;

--
-- AUTO_INCREMENT untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=118;

--
-- AUTO_INCREMENT untuk tabel `produk`
--
ALTER TABLE `produk`
  MODIFY `id` int(4) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=19;

--
-- AUTO_INCREMENT untuk tabel `user`
--
ALTER TABLE `user`
  MODIFY `id` int(5) NOT NULL AUTO_INCREMENT, AUTO_INCREMENT=20;

--
-- Ketidakleluasaan untuk tabel pelimpahan (Dumped Tables)
--

--
-- Ketidakleluasaan untuk tabel `detail_pesanan`
--
ALTER TABLE `detail_pesanan`
  ADD CONSTRAINT `detail_pesanan_ibfk_2` FOREIGN KEY (`pesanan_id`) REFERENCES `pesanan` (`id`) ON DELETE CASCADE ON UPDATE CASCADE,
  ADD CONSTRAINT `detail_pesanan_ibfk_3` FOREIGN KEY (`produk_id`) REFERENCES `produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `pesanan`
--
ALTER TABLE `pesanan`
  ADD CONSTRAINT `pesanan_ibfk_1` FOREIGN KEY (`user_id`) REFERENCES `user` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;

--
-- Ketidakleluasaan untuk tabel `produk`
--
ALTER TABLE `produk`
  ADD CONSTRAINT `produk_ibfk_1` FOREIGN KEY (`kategori_produk_id`) REFERENCES `kategori_produk` (`id`) ON DELETE CASCADE ON UPDATE CASCADE;
COMMIT;

/*!40101 SET CHARACTER_SET_CLIENT=@OLD_CHARACTER_SET_CLIENT */;
/*!40101 SET CHARACTER_SET_RESULTS=@OLD_CHARACTER_SET_RESULTS */;
/*!40101 SET COLLATION_CONNECTION=@OLD_COLLATION_CONNECTION */;
