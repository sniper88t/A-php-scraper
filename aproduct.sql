/*
 Navicat Premium Data Transfer

 Source Server         : MySQL
 Source Server Type    : MySQL
 Source Server Version : 100413
 Source Host           : localhost:3306
 Source Schema         : parsermine

 Target Server Type    : MySQL
 Target Server Version : 100413
 File Encoding         : 65001

 Date: 26/08/2020 01:30:01
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for aproduct
-- ----------------------------
DROP TABLE IF EXISTS `aproduct`;
CREATE TABLE `aproduct`  (
  `id` int(200) NOT NULL AUTO_INCREMENT,
  `title` varchar(500) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `price` varchar(20) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `edition` varchar(10) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `age` varchar(100) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `casktype` varchar(200) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `strength` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `size` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `soldon` varchar(50) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `image` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `url` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  `noteinfo` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 1 CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

SET FOREIGN_KEY_CHECKS = 1;
