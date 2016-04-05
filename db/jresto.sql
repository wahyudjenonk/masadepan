/*
Navicat MySQL Data Transfer

Source Server         : Mysql - Localhost
Source Server Version : 50516
Source Host           : localhost:3306
Source Database       : jingga_cloud

Target Server Type    : MYSQL
Target Server Version : 50516
File Encoding         : 65001

Date: 2016-04-05 21:07:14
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `cl_kategori_produk`
-- ----------------------------
DROP TABLE IF EXISTS `cl_kategori_produk`;
CREATE TABLE `cl_kategori_produk` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) DEFAULT NULL,
  `create_date` date DEFAULT NULL,
  `create_by` varchar(100) DEFAULT NULL,
  `update_date` date DEFAULT NULL,
  `update_by` varchar(100) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cl_kategori_produk
-- ----------------------------
INSERT INTO `cl_kategori_produk` VALUES ('1', 'Makanan', '2012-07-15', 'Administrator', '2012-07-19', 'Administrator', null);
INSERT INTO `cl_kategori_produk` VALUES ('2', 'Minuman', '2012-07-15', 'Administrto', null, null, null);
INSERT INTO `cl_kategori_produk` VALUES ('3', 'Paket', null, null, null, null, null);
INSERT INTO `cl_kategori_produk` VALUES ('4', 'Dessert Makanan', '2016-04-04', 'admin', '2016-04-04', 'admin', '1');

-- ----------------------------
-- Table structure for `cl_meja`
-- ----------------------------
DROP TABLE IF EXISTS `cl_meja`;
CREATE TABLE `cl_meja` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tbl_gerai_outlet_id` int(11) DEFAULT NULL,
  `nama_meja` varchar(10) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `create_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cl_meja
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_d_penjualan_outlet`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_d_penjualan_outlet`;
CREATE TABLE `tbl_d_penjualan_outlet` (
  `no_faktur_penjualan` varchar(50) NOT NULL,
  `tbl_produk_kode` varchar(10) DEFAULT NULL,
  `qty` int(11) DEFAULT NULL,
  `diskon` float DEFAULT NULL,
  `total` float DEFAULT NULL
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_d_penjualan_outlet
-- ----------------------------
INSERT INTO `tbl_d_penjualan_outlet` VALUES ('TJT-20120920-0001', '11003', '10', null, null);
INSERT INTO `tbl_d_penjualan_outlet` VALUES ('TJK-20120920-0001', '21003', '10', null, null);
INSERT INTO `tbl_d_penjualan_outlet` VALUES ('TJT-20120920-0002', '11003', '10', null, null);
INSERT INTO `tbl_d_penjualan_outlet` VALUES ('TJT-20120920-0002', '21004', '5', null, null);
INSERT INTO `tbl_d_penjualan_outlet` VALUES ('TJT-20130217-0001', '21003', '2', null, null);
INSERT INTO `tbl_d_penjualan_outlet` VALUES ('-1', '21003', '10', null, null);

-- ----------------------------
-- Table structure for `tbl_gerai_outlet`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_gerai_outlet`;
CREATE TABLE `tbl_gerai_outlet` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_outlet` varchar(200) DEFAULT NULL,
  `alamat` text,
  `telp` varchar(100) DEFAULT NULL,
  `pic` varchar(100) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `create_by` varchar(100) DEFAULT NULL,
  `update_by` varchar(100) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_gerai_outlet
-- ----------------------------
INSERT INTO `tbl_gerai_outlet` VALUES ('1', 'Gerai Margo', null, null, null, null, null, null, null, null);
INSERT INTO `tbl_gerai_outlet` VALUES ('2', 'Gerai Detos', null, null, null, null, null, null, null, null);

-- ----------------------------
-- Table structure for `tbl_harga_produk_peroutlet`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_harga_produk_peroutlet`;
CREATE TABLE `tbl_harga_produk_peroutlet` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `tbl_produk_kode` varchar(10) DEFAULT NULL,
  `tbl_gerai_outlet_id` int(11) DEFAULT NULL,
  `hpp` float DEFAULT NULL,
  `ppn` float DEFAULT NULL,
  `diskon` int(11) DEFAULT NULL,
  `hpp_ppn_diskon` float DEFAULT NULL,
  `create_by` varchar(100) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `update_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_harga_produk_peroutlet
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_member`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_member`;
CREATE TABLE `tbl_member` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `tbl_gerai_outlet_id` int(11) DEFAULT NULL,
  `kode_member` varchar(10) DEFAULT NULL,
  `nama_member` varchar(100) DEFAULT NULL,
  `alamat` text,
  `telp` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `jenis_kelamin` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_member
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_penjualan_outlet`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_penjualan_outlet`;
CREATE TABLE `tbl_penjualan_outlet` (
  `no_faktur_penjualan` varchar(20) NOT NULL DEFAULT '',
  `tbl_gerai_outlet_id` int(11) DEFAULT NULL,
  `cl_meja_id` int(11) DEFAULT NULL,
  `tgl_faktur` datetime DEFAULT NULL,
  `tbl_member_id` int(100) DEFAULT NULL,
  `pembayaran` varchar(50) DEFAULT NULL,
  `diskon` int(11) DEFAULT NULL,
  `stat` char(2) DEFAULT NULL,
  PRIMARY KEY (`no_faktur_penjualan`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_penjualan_outlet
-- ----------------------------
INSERT INTO `tbl_penjualan_outlet` VALUES ('TJK-20120920-0001', null, null, '2012-09-20 00:00:00', '0', 'Kredit', '0', 'BL');
INSERT INTO `tbl_penjualan_outlet` VALUES ('TJT-20120920-0001', null, null, '2012-09-20 00:00:00', '0', 'Tunai', '5', '');
INSERT INTO `tbl_penjualan_outlet` VALUES ('TJT-20120920-0002', null, null, '2012-09-20 00:00:00', '0', 'Tunai', '0', '');
INSERT INTO `tbl_penjualan_outlet` VALUES ('TJT-20130217-0001', null, null, '2013-02-17 00:00:00', '0', 'Tunai', '0', '');

-- ----------------------------
-- Table structure for `tbl_perangkat_kasir`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_perangkat_kasir`;
CREATE TABLE `tbl_perangkat_kasir` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama_perangkat` varchar(100) DEFAULT NULL,
  `tbl_gerai_outlet_id` int(11) DEFAULT NULL,
  `perangkat_id` varchar(50) DEFAULT NULL,
  `status` int(1) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `create_by` varchar(100) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `update_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_perangkat_kasir
-- ----------------------------
INSERT INTO `tbl_perangkat_kasir` VALUES ('1', 'Kasir 1 Gerai Margo City', '1', '4XKRYKNQVFVBO5PHOKUM', null, '2016-04-05 07:49:00', 'admin', null, null);

-- ----------------------------
-- Table structure for `tbl_produk`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_produk`;
CREATE TABLE `tbl_produk` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `kode_produk` varchar(10) NOT NULL DEFAULT '',
  `cl_kategori_id` int(11) DEFAULT NULL,
  `cl_supplier_id` int(11) DEFAULT NULL,
  `nama_produk` varchar(200) DEFAULT NULL,
  `deskripsi` text,
  `hpp` float DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `create_by` varchar(20) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `update_by` varchar(100) DEFAULT NULL,
  `gambar` varchar(100) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=2 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_produk
-- ----------------------------
INSERT INTO `tbl_produk` VALUES ('1', 'PRD-001', '2', null, 'Pizza Delicious', null, '40000', '2016-04-02 09:43:36', 'admin', '2016-04-02 10:02:15', 'admin', '20160402094336_PizzaDelicious.jpg', '0');

-- ----------------------------
-- Table structure for `tbl_promo`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_promo`;
CREATE TABLE `tbl_promo` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama_promo` varchar(255) DEFAULT NULL,
  `tanggal_mulai` date DEFAULT NULL,
  `tanggal_berakhir` date DEFAULT NULL,
  `deskripsi` text,
  `flag_outlet` int(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_promo
-- ----------------------------

-- ----------------------------
-- Table structure for `tbl_registrasi`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_registrasi`;
CREATE TABLE `tbl_registrasi` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(100) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `cl_user_group_id` smallint(6) DEFAULT NULL,
  `nama_lengkap` varchar(200) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `jenis_kelamin` varchar(1) DEFAULT NULL,
  `tlp` varchar(15) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  `alamat` text,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=7 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_registrasi
-- ----------------------------
INSERT INTO `tbl_registrasi` VALUES ('1', 'admin', 'w8nRgzJ8q9W6/04js1nnJwKOHTideqmajzAcg7qmotOyPsh99akca9HqPPuK9U0A8po69U8txljPE/dGpyPTNg==', '1', 'Goyz Crotz', 'goyz87@gmail.com', 'L', '0251-388716', '1', null);
INSERT INTO `tbl_registrasi` VALUES ('5', 'modeler1', 'M4mVsz5i0hWxnamD5D1Etr9KTQQznHy2UUpi/fdHKr2jH6rfn7lPTCgrqjkNV3jtJEs6/tV24JPL+syRyV0AbA==', '3', 'Modeler ABC 1', 'modeler@abc.com', 'L', '08909928928', '1', null);
INSERT INTO `tbl_registrasi` VALUES ('6', 'viewer1', '5QZetLH9Ut2JPzFrojEHeMQ5XrvDkcvbja7Ca+DkTqwvfXyGWpfZ1L1lGx2O2BfcoezwhVysQEtzR8TBgnfezQ==', '4', 'Viewer 1', 'viewer@gmail.com', 'P', '08909928928', '1', null);

-- ----------------------------
-- Table structure for `tbl_supplier`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_supplier`;
CREATE TABLE `tbl_supplier` (
  `id` bigint(20) NOT NULL AUTO_INCREMENT,
  `nama_supplier` varchar(255) DEFAULT NULL,
  `no_telp` varchar(100) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `kontak` varchar(100) DEFAULT NULL,
  `alamat` text,
  `status` int(1) DEFAULT NULL,
  `create_date` datetime DEFAULT NULL,
  `create_by` varchar(100) DEFAULT NULL,
  `update_date` datetime DEFAULT NULL,
  `update_by` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=3 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_supplier
-- ----------------------------
INSERT INTO `tbl_supplier` VALUES ('1', 'PT. Murah Meriah', '0', 'safdafadsf', '02349324', '<p>asdfsfasdf</p>', null, '2016-04-02 10:26:23', 'admin', null, null);
INSERT INTO `tbl_supplier` VALUES ('2', 'PT. Manis Aja', '9867876387', 'manisaja@gmai.com', 'She Levi', '<p>Jl. Kampret Dua Ratuy Toejoeh</p>', null, '2016-04-02 10:26:39', 'admin', '2016-04-02 10:28:36', 'admin');

-- ----------------------------
-- Table structure for `tbl_user`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_user`;
CREATE TABLE `tbl_user` (
  `id` int(11) NOT NULL AUTO_INCREMENT,
  `nama_user` varchar(100) DEFAULT NULL,
  `password` varchar(200) DEFAULT NULL,
  `cl_user_group_id` smallint(6) DEFAULT NULL,
  `nama_lengkap` varchar(200) DEFAULT NULL,
  `email` varchar(100) DEFAULT NULL,
  `jenis_kelamin` varchar(1) DEFAULT NULL,
  `tlp` varchar(15) DEFAULT NULL,
  `status` varchar(1) DEFAULT NULL,
  PRIMARY KEY (`id`)
) ENGINE=InnoDB AUTO_INCREMENT=5 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_user
-- ----------------------------
INSERT INTO `tbl_user` VALUES ('1', 'admin', 'w8nRgzJ8q9W6/04js1nnJwKOHTideqmajzAcg7qmotOyPsh99akca9HqPPuK9U0A8po69U8txljPE/dGpyPTNg==', '1', 'Goyz Crotz', 'goyz87@gmail.com', 'L', '0251-388716', '1');
INSERT INTO `tbl_user` VALUES ('2', 'kasir_1', 'w8nRgzJ8q9W6/04js1nnJwKOHTideqmajzAcg7qmotOyPsh99akca9HqPPuK9U0A8po69U8txljPE/dGpyPTNg==', '2', 'Lukman Santoso', null, 'L', null, '1');
INSERT INTO `tbl_user` VALUES ('4', 'kasir_2', 'R2s+MzlfaarWwB2lVu9qQX5V1jEjKvkfMuZHnmzayO2kB4Engg9px0X3OtpYlhMx1ADCOlkDcC3pvjo5OvIlMg==', '2', 'Heri Marbot', 'guest@gmail.com', 'L', '021-99889898', '1');
