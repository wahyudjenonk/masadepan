/*
Navicat MySQL Data Transfer

Source Server         : MysqlLocal
Source Server Version : 50528
Source Host           : localhost:3306
Source Database       : jresto

Target Server Type    : MYSQL
Target Server Version : 50528
File Encoding         : 65001

Date: 2016-03-22 14:00:33
*/

SET FOREIGN_KEY_CHECKS=0;

-- ----------------------------
-- Table structure for `cl_kategori_produk`
-- ----------------------------
DROP TABLE IF EXISTS `cl_kategori_produk`;
CREATE TABLE `cl_kategori_produk` (
  `id_kategori` int(11) NOT NULL AUTO_INCREMENT,
  `nama_kategori` varchar(100) DEFAULT NULL,
  `tgl_buat` date DEFAULT NULL,
  `user_create` varchar(100) DEFAULT NULL,
  `tgl_update` date DEFAULT NULL,
  `user_update` varchar(100) DEFAULT NULL,
  PRIMARY KEY (`id_kategori`)
) ENGINE=InnoDB AUTO_INCREMENT=4 DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of cl_kategori_produk
-- ----------------------------
INSERT INTO `cl_kategori_produk` VALUES ('1', 'Makanan', '2012-07-15', 'Administrator', '2012-07-19', 'Administrator');
INSERT INTO `cl_kategori_produk` VALUES ('2', 'Minuman', '2012-07-15', 'Administrto', null, null);
INSERT INTO `cl_kategori_produk` VALUES ('3', 'Paket', null, null, null, null);

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
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_gerai_outlet
-- ----------------------------

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
-- Table structure for `tbl_produk`
-- ----------------------------
DROP TABLE IF EXISTS `tbl_produk`;
CREATE TABLE `tbl_produk` (
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
  PRIMARY KEY (`kode_produk`)
) ENGINE=InnoDB DEFAULT CHARSET=latin1;

-- ----------------------------
-- Records of tbl_produk
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
