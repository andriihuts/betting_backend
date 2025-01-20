/*
 Navicat Premium Data Transfer

 Source Server         : localhost
 Source Server Type    : MySQL
 Source Server Version : 100428
 Source Host           : localhost:3306
 Source Schema         : stepper_betting

 Target Server Type    : MySQL
 Target Server Version : 100428
 File Encoding         : 65001

 Date: 12/12/2024 06:08:41
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for currencies
-- ----------------------------
DROP TABLE IF EXISTS `currencies`;
CREATE TABLE `currencies`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `m_rate` double(8, 3) NOT NULL,
  `r_rate` double(8, 3) NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 2 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of currencies
-- ----------------------------
INSERT INTO `currencies` VALUES (1, 0.235, 0.324, 'It can be set the m value and RS3 value here', '2024-10-23 17:48:14', '2024-12-09 20:16:42');

-- ----------------------------
-- Table structure for customers
-- ----------------------------
DROP TABLE IF EXISTS `customers`;
CREATE TABLE `customers`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `name` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'customer id',
  `a_apply_pay` double(8, 2) NOT NULL DEFAULT 0 COMMENT 'currency type is apply pay',
  `b_bitcoin` double(8, 2) NULL DEFAULT 0,
  `e_ethereum` double(8, 2) NULL DEFAULT 0 COMMENT 'currency type is ethereum\r\n',
  `c_card` double(8, 2) NULL DEFAULT 0 COMMENT 'currency type is CAD',
  `u_usdt` double(8, 2) NULL DEFAULT 0 COMMENT 'currency type is usdt',
  `m_game_currency` double(8, 2) NULL DEFAULT 0 COMMENT 'currency type is game currency',
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  `flag` tinyint(4) NULL DEFAULT NULL COMMENT '1:customer, 0: hosts',
  `r_rs3` double(8, 2) NULL DEFAULT 0 COMMENT 'currency type is rs3',
  PRIMARY KEY (`id`, `a_apply_pay`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 168 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of customers
-- ----------------------------
INSERT INTO `customers` VALUES (106, 'Kluch', 1285.25, 1346.27, 0.00, 0.00, 0.00, -4329.93, NULL, '2023-06-25 03:39:53', '2024-05-17 20:23:03', 0, 0.00);
INSERT INTO `customers` VALUES (109, 'Gold', 569.76, -504.68, 0.00, 0.00, 0.00, -82.29, NULL, '2023-06-25 03:40:08', '2024-11-10 09:44:21', 0, 15.00);
INSERT INTO `customers` VALUES (110, 'Dorin', 570.00, 0.00, 0.00, 574.23, 0.00, 549.18, NULL, '2023-06-25 03:40:14', '2024-12-11 09:22:04', 0, 0.00);
INSERT INTO `customers` VALUES (111, 'Jam', 43.50, -275.30, 150.00, 0.00, 80.00, 71.57, NULL, '2023-06-25 03:40:18', '2024-11-10 09:44:34', 0, 0.00);
INSERT INTO `customers` VALUES (112, 'Guard', -200.00, 0.00, 100.00, 0.00, 0.00, -200.00, NULL, '2023-06-25 03:40:25', '2024-11-10 09:22:49', 0, 100.00);
INSERT INTO `customers` VALUES (113, 'Sens', 0.00, 0.00, 0.00, 0.00, 0.00, 150.00, NULL, '2023-06-25 03:40:29', '2024-11-10 09:45:56', 0, -1000.00);
INSERT INTO `customers` VALUES (115, 'JayA', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2023-06-25 03:41:00', '2024-12-10 20:22:22', 1, 0.00);
INSERT INTO `customers` VALUES (116, 'Tony', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2023-06-25 03:41:07', '2023-06-25 03:41:07', 1, 0.00);
INSERT INTO `customers` VALUES (119, 'Mookie', 21.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2023-06-25 03:41:34', '2024-12-10 18:48:53', 1, 0.00);
INSERT INTO `customers` VALUES (120, 'Sooma', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2023-06-25 03:41:54', '2023-06-25 03:41:54', 1, 0.00);
INSERT INTO `customers` VALUES (122, 'Meggel', 789.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2023-06-25 03:42:03', '2024-12-10 20:25:09', 1, 0.00);
INSERT INTO `customers` VALUES (123, 'Ting', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2023-06-25 03:42:08', '2023-06-25 03:42:08', 1, 0.00);
INSERT INTO `customers` VALUES (124, 'Neonz', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2023-06-25 03:42:16', '2023-06-25 03:42:16', 1, 0.00);
INSERT INTO `customers` VALUES (125, 'Xero', 0.00, 0.00, 0.00, 0.00, 0.00, 20.00, NULL, '2023-06-25 03:42:30', '2024-11-08 14:49:10', 1, 0.00);
INSERT INTO `customers` VALUES (126, 'Harvey', -118.32, 0.00, 0.00, 0.00, 0.00, -30.00, NULL, '2023-06-25 03:42:41', '2024-12-10 18:49:20', 1, 0.00);
INSERT INTO `customers` VALUES (127, 'Bot', 0.00, 0.00, 0.00, 0.00, 0.00, 20.00, NULL, '2023-06-25 03:52:09', '2024-11-10 09:31:11', 1, 0.00);
INSERT INTO `customers` VALUES (128, 'Simlich', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2023-06-25 07:56:56', '2023-06-25 07:56:56', 1, 0.00);
INSERT INTO `customers` VALUES (129, 'KillaCal', 890.00, -341.50, -125.00, 0.00, 0.00, 65.00, NULL, '2023-06-27 06:44:20', '2024-11-10 02:43:00', 0, -1000.00);
INSERT INTO `customers` VALUES (130, 'Cryalics', 40.00, 0.00, 0.00, 0.00, 20.00, 10.00, NULL, '2023-06-28 03:58:38', '2024-11-10 09:45:56', 1, 15.00);
INSERT INTO `customers` VALUES (133, 'Papi', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2023-07-02 21:20:21', '2023-07-02 21:20:21', 1, 0.00);
INSERT INTO `customers` VALUES (136, 'Cash', 0.00, 0.00, 0.00, 0.00, 0.00, 180.00, NULL, '2023-07-05 23:16:37', '2024-11-08 15:00:14', 1, 0.00);
INSERT INTO `customers` VALUES (139, 'Wazy', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2023-07-09 18:22:32', '2023-07-09 18:22:32', 1, 0.00);
INSERT INTO `customers` VALUES (140, 'Simao', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2023-07-10 03:53:39', '2023-07-10 03:53:39', 1, 0.00);
INSERT INTO `customers` VALUES (141, 'Shoe', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2023-07-15 00:02:00', '2023-07-15 00:02:00', 1, 0.00);
INSERT INTO `customers` VALUES (142, 'TBR', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2023-07-15 02:53:00', '2023-07-15 02:53:00', 1, 0.00);
INSERT INTO `customers` VALUES (143, 'Dex', 0.00, 0.00, 0.00, 97.50, 200.00, 76.60, NULL, '2023-07-16 01:55:19', '2024-11-10 09:32:35', 1, 30.00);
INSERT INTO `customers` VALUES (148, 'wwb', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2024-08-21 02:48:34', '2024-08-21 02:48:34', 1, 0.00);
INSERT INTO `customers` VALUES (158, 'test3', 200.00, 0.00, -100.00, 0.00, 0.00, 0.00, NULL, '2024-11-10 01:58:04', '2024-11-21 05:04:52', 0, 0.00);
INSERT INTO `customers` VALUES (161, 'vvv', 0.00, 0.00, 0.00, 0.00, 0.00, 600.00, NULL, '2024-11-21 05:17:08', '2024-11-21 05:17:43', 0, 0.00);
INSERT INTO `customers` VALUES (162, 'qqq', 0.00, 0.00, 0.00, 0.00, 0.00, 300.00, NULL, '2024-11-21 05:18:29', '2024-11-21 05:19:19', 0, 0.00);
INSERT INTO `customers` VALUES (163, 'ccc', 90.00, 0.00, 0.00, 20.00, 0.00, 0.00, NULL, '2024-11-21 05:20:15', '2024-12-11 09:22:47', 0, 0.00);
INSERT INTO `customers` VALUES (164, 'AAAA', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2024-12-10 05:26:15', '2024-12-10 05:26:15', 1, 0.00);
INSERT INTO `customers` VALUES (165, 'BBEBE', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2024-12-10 05:31:46', '2024-12-10 05:31:46', 1, 0.00);
INSERT INTO `customers` VALUES (166, 'abaaa', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2024-12-10 05:54:29', '2024-12-10 05:54:29', 0, 0.00);
INSERT INTO `customers` VALUES (167, 'opop', 0.00, 0.00, 0.00, 0.00, 0.00, 0.00, NULL, '2024-12-11 09:23:01', '2024-12-11 09:23:01', 0, 0.00);

-- ----------------------------
-- Table structure for migrations
-- ----------------------------
DROP TABLE IF EXISTS `migrations`;
CREATE TABLE `migrations`  (
  `id` int(10) UNSIGNED NOT NULL AUTO_INCREMENT,
  `migration` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `batch` int(11) NOT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 6 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of migrations
-- ----------------------------
INSERT INTO `migrations` VALUES (4, '2024_10_22_194230_add_r_rs3_to_customers_table', 1);
INSERT INTO `migrations` VALUES (5, '2024_10_23_094622_create_currencies_table', 2);

-- ----------------------------
-- Table structure for net_i_r_c_s
-- ----------------------------
DROP TABLE IF EXISTS `net_i_r_c_s`;
CREATE TABLE `net_i_r_c_s`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `net` float NOT NULL,
  `irc` float NOT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 766 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of net_i_r_c_s
-- ----------------------------
INSERT INTO `net_i_r_c_s` VALUES (714, 0, 0, '2024-11-08 14:40:20', '2024-11-08 14:40:20');
INSERT INTO `net_i_r_c_s` VALUES (715, 20, 0, '2024-11-08 14:49:11', '2024-11-08 14:49:11');
INSERT INTO `net_i_r_c_s` VALUES (716, -10, 0, '2024-11-08 14:51:14', '2024-11-08 14:51:14');
INSERT INTO `net_i_r_c_s` VALUES (717, 8, 0, '2024-11-08 14:53:59', '2024-11-08 14:53:59');
INSERT INTO `net_i_r_c_s` VALUES (718, 44, 0, '2024-11-08 14:56:51', '2024-11-08 14:56:51');
INSERT INTO `net_i_r_c_s` VALUES (719, 9, 0, '2024-11-08 14:58:16', '2024-11-08 14:58:16');
INSERT INTO `net_i_r_c_s` VALUES (720, 27, 0, '2024-11-08 14:59:54', '2024-11-08 14:59:54');
INSERT INTO `net_i_r_c_s` VALUES (721, 207, 0, '2024-11-08 15:00:14', '2024-11-08 15:00:14');
INSERT INTO `net_i_r_c_s` VALUES (722, 217, 0, '2024-11-08 15:02:24', '2024-11-08 15:02:24');
INSERT INTO `net_i_r_c_s` VALUES (723, 317, 0, '2024-11-09 20:22:11', '2024-11-09 20:22:11');
INSERT INTO `net_i_r_c_s` VALUES (724, 414.5, 0, '2024-11-10 01:40:09', '2024-11-10 01:40:09');
INSERT INTO `net_i_r_c_s` VALUES (725, 434.5, 0, '2024-11-10 01:41:41', '2024-11-10 01:41:41');
INSERT INTO `net_i_r_c_s` VALUES (726, 534.5, 0, '2024-11-10 01:42:37', '2024-11-10 01:42:37');
INSERT INTO `net_i_r_c_s` VALUES (727, 734.5, 0, '2024-11-10 01:49:52', '2024-11-10 01:49:52');
INSERT INTO `net_i_r_c_s` VALUES (728, 934.5, 0, '2024-11-10 01:51:56', '2024-11-10 01:51:56');
INSERT INTO `net_i_r_c_s` VALUES (729, 1234.5, 0, '2024-11-10 01:53:45', '2024-11-10 01:53:45');
INSERT INTO `net_i_r_c_s` VALUES (730, 1274.5, 0, '2024-11-10 01:57:20', '2024-11-10 01:57:20');
INSERT INTO `net_i_r_c_s` VALUES (731, 1374.5, 0, '2024-11-10 01:58:54', '2024-11-10 01:58:54');
INSERT INTO `net_i_r_c_s` VALUES (732, 1404.5, 0, '2024-11-10 02:43:00', '2024-11-10 02:43:00');
INSERT INTO `net_i_r_c_s` VALUES (733, 1424.5, 0, '2024-11-10 09:16:03', '2024-11-10 09:16:03');
INSERT INTO `net_i_r_c_s` VALUES (734, 1464.5, 0, '2024-11-10 09:20:11', '2024-11-10 09:20:11');
INSERT INTO `net_i_r_c_s` VALUES (735, 1544.5, 0, '2024-11-10 09:22:49', '2024-11-10 09:22:49');
INSERT INTO `net_i_r_c_s` VALUES (736, 1554.5, 0, '2024-11-10 09:29:53', '2024-11-10 09:29:53');
INSERT INTO `net_i_r_c_s` VALUES (737, 1564.5, 0, '2024-11-10 09:31:11', '2024-11-10 09:31:11');
INSERT INTO `net_i_r_c_s` VALUES (738, 1544.5, 0, '2024-11-10 09:32:35', '2024-11-10 09:32:35');
INSERT INTO `net_i_r_c_s` VALUES (739, 1514.5, 0, '2024-11-10 09:41:45', '2024-11-10 09:41:45');
INSERT INTO `net_i_r_c_s` VALUES (740, 1534.5, 0, '2024-11-10 09:44:22', '2024-11-10 09:44:22');
INSERT INTO `net_i_r_c_s` VALUES (741, 1550.5, 0, '2024-11-10 09:44:34', '2024-11-10 09:44:34');
INSERT INTO `net_i_r_c_s` VALUES (742, 1565.5, 0, '2024-11-10 09:45:56', '2024-11-10 09:45:56');
INSERT INTO `net_i_r_c_s` VALUES (743, 1535.5, 0, '2024-11-10 09:47:47', '2024-11-10 09:47:47');
INSERT INTO `net_i_r_c_s` VALUES (744, 1551.5, 16, '2024-11-10 09:48:18', '2024-11-10 09:48:18');
INSERT INTO `net_i_r_c_s` VALUES (745, 1566.5, 31, '2024-11-10 09:49:01', '2024-11-10 09:49:01');
INSERT INTO `net_i_r_c_s` VALUES (746, 1581.5, 31, '2024-11-10 09:49:44', '2024-11-10 09:49:44');
INSERT INTO `net_i_r_c_s` VALUES (747, 1781.5, 31, '2024-11-21 05:03:53', '2024-11-21 05:03:53');
INSERT INTO `net_i_r_c_s` VALUES (748, 1981.5, 31, '2024-11-21 05:04:52', '2024-11-21 05:04:52');
INSERT INTO `net_i_r_c_s` VALUES (749, 2081.5, 31, '2024-11-21 05:06:10', '2024-11-21 05:06:10');
INSERT INTO `net_i_r_c_s` VALUES (750, 2381.5, 31, '2024-11-21 05:11:25', '2024-11-21 05:11:25');
INSERT INTO `net_i_r_c_s` VALUES (751, 2501.5, 31, '2024-11-21 05:17:43', '2024-11-21 05:17:43');
INSERT INTO `net_i_r_c_s` VALUES (752, 2561.5, 31, '2024-11-21 05:19:20', '2024-11-21 05:19:20');
INSERT INTO `net_i_r_c_s` VALUES (753, 2681.5, 31, '2024-11-21 05:21:47', '2024-11-21 05:21:47');
INSERT INTO `net_i_r_c_s` VALUES (754, 2759.5, 31, '2024-11-24 20:40:36', '2024-11-24 20:40:36');
INSERT INTO `net_i_r_c_s` VALUES (755, 2771.5, 31, '2024-12-09 20:36:41', '2024-12-09 20:36:41');
INSERT INTO `net_i_r_c_s` VALUES (756, 2843.43, 31, '2024-12-09 20:38:44', '2024-12-09 20:38:44');
INSERT INTO `net_i_r_c_s` VALUES (757, 2890.43, 31, '2024-12-09 20:38:52', '2024-12-09 20:38:52');
INSERT INTO `net_i_r_c_s` VALUES (758, 2937.43, 31, '2024-12-09 20:50:34', '2024-12-09 20:50:34');
INSERT INTO `net_i_r_c_s` VALUES (759, 3043.18, 31, '2024-12-09 22:05:03', '2024-12-09 22:05:03');
INSERT INTO `net_i_r_c_s` VALUES (760, 3151.07, 31, '2024-12-09 22:05:50', '2024-12-09 22:05:50');
INSERT INTO `net_i_r_c_s` VALUES (761, 3156.24, 31, '2024-12-09 22:05:58', '2024-12-09 22:05:58');
INSERT INTO `net_i_r_c_s` VALUES (762, 3177.24, 31, '2024-12-10 18:48:54', '2024-12-10 18:48:54');
INSERT INTO `net_i_r_c_s` VALUES (763, 3058.92, 31, '2024-12-10 18:49:20', '2024-12-10 18:49:20');
INSERT INTO `net_i_r_c_s` VALUES (764, 3058.92, 31, '2024-12-10 20:22:22', '2024-12-10 20:22:22');
INSERT INTO `net_i_r_c_s` VALUES (765, 3847.92, 31, '2024-12-10 20:25:10', '2024-12-10 20:25:10');

-- ----------------------------
-- Table structure for new_bets
-- ----------------------------
DROP TABLE IF EXISTS `new_bets`;
CREATE TABLE `new_bets`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NULL DEFAULT NULL,
  `slip` tinytext CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL COMMENT 'bet description',
  `odds` double(8, 2) NOT NULL COMMENT 'bet odds',
  `live` tinyint(4) NULL DEFAULT NULL COMMENT 'game is live or not',
  `amount` double(8, 2) NOT NULL COMMENT 'betting amount',
  `currency` varchar(50) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'currency type',
  `splitters` varchar(200) CHARACTER SET utf8mb4 COLLATE utf8mb4_bin NULL DEFAULT NULL COMMENT 'splitter user group',
  `rate` float(255, 5) UNSIGNED NOT NULL DEFAULT 1,
  `status` tinyint(4) NULL DEFAULT NULL COMMENT 'status 1:win, 0:lose, 2:void',
  `bsplitter` tinyint(4) NULL DEFAULT NULL COMMENT 'user is splitter or not',
  `notes` varchar(100) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NULL DEFAULT NULL COMMENT 'note',
  `deleted_at` timestamp(0) NULL DEFAULT NULL,
  `created_at` timestamp(0) NULL DEFAULT NULL,
  `updated_at` timestamp(0) NULL DEFAULT NULL,
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 902 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of new_bets
-- ----------------------------
INSERT INTO `new_bets` VALUES (649, 125, 'testttt', 2.00, 1, 200.00, 'm-(OSRS)', NULL, 1.00000, 1, 1, NULL, NULL, '2024-11-08 14:47:44', '2024-11-08 14:49:10');
INSERT INTO `new_bets` VALUES (650, 126, 'test2', 2.50, 1, 200.00, 'm-(OSRS)', NULL, 1.00000, 0, 1, NULL, NULL, '2024-11-08 14:50:56', '2024-11-08 14:51:14');
INSERT INTO `new_bets` VALUES (651, 109, 'test3', 2.00, 1, 100.00, 'm-(OSRS)', NULL, 1.00000, 1, 1, NULL, NULL, '2024-11-08 14:53:08', '2024-11-08 14:53:59');
INSERT INTO `new_bets` VALUES (652, 111, 'uyguyg', 2.00, 1, 100.00, 'm-(OSRS)', NULL, 1.00000, 1, 1, NULL, NULL, '2024-11-08 14:58:56', '2024-11-08 14:59:54');
INSERT INTO `new_bets` VALUES (653, 136, 'bhb', 2.00, 1, 1000.00, 'm-(OSRS)', NULL, 1.00000, 1, 1, NULL, NULL, '2024-11-08 14:59:32', '2024-11-08 15:00:14');
INSERT INTO `new_bets` VALUES (654, 143, 'uiyghui', 2.00, 1, 100.00, 'm-(OSRS)', NULL, 1.00000, 1, 1, NULL, NULL, '2024-11-08 15:01:25', '2024-11-08 15:02:24');
INSERT INTO `new_bets` VALUES (656, 143, 'test3', 2.10, 1, 200.00, 'c-(CAD)', NULL, 1.00000, 1, 1, NULL, NULL, '2024-11-10 01:39:33', '2024-11-10 01:40:09');
INSERT INTO `new_bets` VALUES (657, 130, 'tet34', 2.10, 1, 120.00, 'u-(usdt)', NULL, 1.00000, 1, 1, NULL, NULL, '2024-11-10 01:41:16', '2024-11-10 01:41:41');
INSERT INTO `new_bets` VALUES (659, 143, 'test33', 2.10, 1, 300.00, 'u-(usdt)', NULL, 1.00000, 1, 1, NULL, NULL, '2024-11-10 01:49:34', '2024-11-10 01:49:52');
INSERT INTO `new_bets` VALUES (660, 109, 'test33', 2.30, 1, 300.00, 'a-(applepay)', NULL, 1.00000, 1, 1, NULL, NULL, '2024-11-10 01:51:49', '2024-11-10 01:51:56');
INSERT INTO `new_bets` VALUES (661, 110, 'tets33', 2.30, 1, 400.00, 'a-(applepay)', NULL, 1.00000, 1, 1, NULL, NULL, '2024-11-10 01:53:39', '2024-11-10 01:53:45');
INSERT INTO `new_bets` VALUES (662, 130, 'test34', 3.20, 1, 240.00, 'a-(applepay)', NULL, 1.00000, 1, 1, NULL, NULL, '2024-11-10 01:56:58', '2024-11-10 01:57:20');
INSERT INTO `new_bets` VALUES (663, 112, 'test33', 2.50, 1, 200.00, 'e-(ethereum)', NULL, 1.00000, 1, 1, NULL, NULL, '2024-11-10 01:58:32', '2024-11-10 01:58:53');
INSERT INTO `new_bets` VALUES (664, 143, 'test44', 2.30, 1, 3000.00, 'r-(RS3)', NULL, 1.00000, 1, 1, NULL, NULL, '2024-11-10 02:42:32', '2024-11-10 02:43:00');
INSERT INTO `new_bets` VALUES (665, 136, 'test44', 2.30, 1, 300.00, 'm-(OSRS)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-10 03:11:17', '2024-11-10 03:11:17');
INSERT INTO `new_bets` VALUES (666, 126, 'tes33', 2.30, 1, 400.00, 'm-(OSRS)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-10 03:12:22', '2024-11-10 03:12:22');
INSERT INTO `new_bets` VALUES (667, 143, 'test', 2.30, 1, 500.00, 'm-(OSRS)', NULL, 0.10000, 1, 1, NULL, NULL, '2024-11-10 03:13:26', '2024-11-10 09:22:49');
INSERT INTO `new_bets` VALUES (668, 130, 'test333', 2.10, 1, 600.00, 'm-(OSRS)', NULL, 0.20000, 3, 1, NULL, NULL, '2024-11-10 03:14:05', '2024-11-10 03:14:05');
INSERT INTO `new_bets` VALUES (669, 111, 'test', 2.60, 1, 500.00, 'r-(RS3)', NULL, 0.01500, 3, 1, NULL, NULL, '2024-11-10 03:14:30', '2024-11-10 03:14:30');
INSERT INTO `new_bets` VALUES (670, 110, 'test1', 2.00, 1, 200.00, 'm-(OSRS)', NULL, 0.20000, 1, 1, NULL, NULL, '2024-11-10 09:15:14', '2024-11-10 09:16:03');
INSERT INTO `new_bets` VALUES (671, 130, 'test2', 2.00, 1, 200.00, 'm-(OSRS)', NULL, 0.20000, 1, 1, NULL, NULL, '2024-11-10 09:19:00', '2024-11-10 09:20:11');
INSERT INTO `new_bets` VALUES (672, 127, 'test3', 2.00, 1, 100.00, 'm-(OSRS)', NULL, 0.20000, 1, 1, NULL, NULL, '2024-11-10 09:27:36', '2024-11-10 09:29:53');
INSERT INTO `new_bets` VALUES (673, 127, 'test4', 2.00, 1, 100.00, 'm-(OSRS)', NULL, 0.10000, 1, 1, NULL, NULL, '2024-11-10 09:29:34', '2024-11-10 09:31:11');
INSERT INTO `new_bets` VALUES (674, 143, 'test5', 2.00, 1, 100.00, 'm-(OSRS)', NULL, 0.10000, 0, 1, NULL, NULL, '2024-11-10 09:31:44', '2024-11-10 09:32:35');
INSERT INTO `new_bets` VALUES (675, 130, 'test6', 2.50, 1, 200.00, 'm-(OSRS)', NULL, 0.20000, 0, 1, NULL, NULL, '2024-11-10 09:40:39', '2024-11-10 09:41:45');
INSERT INTO `new_bets` VALUES (676, 109, 'last test for M', 2.00, 1, 100.00, 'm-(OSRS)', NULL, 0.20000, 1, 1, NULL, NULL, '2024-11-10 09:42:45', '2024-11-10 09:44:21');
INSERT INTO `new_bets` VALUES (677, 111, 'awdadw', 2.00, 1, 100.00, 'm-(OSRS)', NULL, 0.16000, 1, 1, NULL, NULL, '2024-11-10 09:43:43', '2024-11-10 09:44:34');
INSERT INTO `new_bets` VALUES (678, 130, 'test', 2.00, 1, 2000.00, 'r-(RS3)', NULL, 0.01500, 1, 1, NULL, NULL, '2024-11-10 09:45:30', '2024-11-10 09:45:56');
INSERT INTO `new_bets` VALUES (679, 110, 'tead', 3.00, 1, 1000.00, 'r-(RS3)', NULL, 0.01500, 0, 1, NULL, NULL, '2024-11-10 09:46:51', '2024-11-10 09:47:47');
INSERT INTO `new_bets` VALUES (682, 136, 'aaa', 2.30, 1, 120.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-13 22:08:51', '2024-11-13 22:08:51');
INSERT INTO `new_bets` VALUES (683, 112, 'test', 3.00, 1, 333.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-13 22:09:12', '2024-11-13 22:09:12');
INSERT INTO `new_bets` VALUES (684, 112, 'test', 3.00, 1, 333.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-13 22:09:14', '2024-11-13 22:09:14');
INSERT INTO `new_bets` VALUES (686, 109, 'test', 2.30, 1, 600.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-13 22:13:16', '2024-11-13 22:13:16');
INSERT INTO `new_bets` VALUES (687, 143, 'test2', 2.30, 1, 300.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-15 19:10:58', '2024-11-15 19:10:58');
INSERT INTO `new_bets` VALUES (688, 143, 'test2', 2.30, 1, 300.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-15 19:11:02', '2024-11-15 19:11:02');
INSERT INTO `new_bets` VALUES (689, 136, 'test', 2.30, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-15 19:29:31', '2024-11-15 19:29:31');
INSERT INTO `new_bets` VALUES (690, 110, 'test', 2.50, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-15 19:37:24', '2024-11-15 19:37:24');
INSERT INTO `new_bets` VALUES (691, 109, 'test33', 2.60, 1, 566.00, 'u-(usdt)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-15 19:38:00', '2024-11-15 19:38:00');
INSERT INTO `new_bets` VALUES (693, 143, 'test', 2.30, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-17 01:04:05', '2024-11-17 01:04:05');
INSERT INTO `new_bets` VALUES (694, 143, 'test3344', 2.36, 1, 500.00, 'u-(usdt)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-17 01:06:00', '2024-11-17 01:06:00');
INSERT INTO `new_bets` VALUES (696, 109, 'test55', 2.50, 1, 360.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-17 01:20:07', '2024-11-17 01:20:07');
INSERT INTO `new_bets` VALUES (697, 157, 'test34', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 18:27:36', '2024-11-19 18:27:36');
INSERT INTO `new_bets` VALUES (698, 157, 'test34', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 18:27:38', '2024-11-19 18:27:38');
INSERT INTO `new_bets` VALUES (699, 157, 'test34', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 18:27:48', '2024-11-19 18:27:48');
INSERT INTO `new_bets` VALUES (700, 157, 'test34', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 18:27:50', '2024-11-19 18:27:50');
INSERT INTO `new_bets` VALUES (701, 157, 'test34', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 18:27:51', '2024-11-19 18:27:51');
INSERT INTO `new_bets` VALUES (702, 157, 'check11', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 18:28:16', '2024-11-19 18:28:16');
INSERT INTO `new_bets` VALUES (703, 157, 'check11', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 18:28:18', '2024-11-19 18:28:18');
INSERT INTO `new_bets` VALUES (704, 157, 'check11', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 18:28:19', '2024-11-19 18:28:19');
INSERT INTO `new_bets` VALUES (705, 143, 'd', 2.30, 1, 560.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 19:00:12', '2024-11-19 19:00:12');
INSERT INTO `new_bets` VALUES (706, 143, 'dss', 2.60, 1, 82.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 19:00:23', '2024-11-19 19:00:23');
INSERT INTO `new_bets` VALUES (707, 157, 'check11', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 19:28:16', '2024-11-19 19:28:16');
INSERT INTO `new_bets` VALUES (708, 157, 'check11', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 19:35:51', '2024-11-19 19:35:51');
INSERT INTO `new_bets` VALUES (709, 157, 'check11', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 19:36:31', '2024-11-19 19:36:31');
INSERT INTO `new_bets` VALUES (710, 157, 'check11', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 19:36:33', '2024-11-19 19:36:33');
INSERT INTO `new_bets` VALUES (711, 157, 'check11', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 19:36:34', '2024-11-19 19:36:34');
INSERT INTO `new_bets` VALUES (712, 157, 'check11', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 19:36:36', '2024-11-19 19:36:36');
INSERT INTO `new_bets` VALUES (713, 157, 'check11', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 19:36:37', '2024-11-19 19:36:37');
INSERT INTO `new_bets` VALUES (714, 157, 'check11', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 19:36:39', '2024-11-19 19:36:39');
INSERT INTO `new_bets` VALUES (715, 157, 'check11', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 19:37:16', '2024-11-19 19:37:16');
INSERT INTO `new_bets` VALUES (716, 157, 'check11', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 19:44:13', '2024-11-19 19:44:13');
INSERT INTO `new_bets` VALUES (717, 157, 'check11', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 19:45:23', '2024-11-19 19:45:23');
INSERT INTO `new_bets` VALUES (718, 157, 'check11', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 19:46:20', '2024-11-19 19:46:20');
INSERT INTO `new_bets` VALUES (719, 157, 'check11', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 19:47:49', '2024-11-19 19:47:49');
INSERT INTO `new_bets` VALUES (720, 110, 'aaa', 2.30, 1, 8.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 21:11:02', '2024-11-19 21:11:02');
INSERT INTO `new_bets` VALUES (722, 143, 'aaa1', 2.30, 1, 855.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 21:12:37', '2024-11-19 21:12:37');
INSERT INTO `new_bets` VALUES (723, 109, 'iii', 2.30, 1, 7897.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 21:12:49', '2024-11-19 21:12:49');
INSERT INTO `new_bets` VALUES (724, 109, 'aaa', 2.36, 1, 5698.00, 'u-(usdt)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 21:14:34', '2024-11-19 21:14:34');
INSERT INTO `new_bets` VALUES (725, 143, 'vvvv', 2.36, 1, 125.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 21:14:51', '2024-11-19 21:14:51');
INSERT INTO `new_bets` VALUES (726, 112, 'aaaa', 2.37, 1, 895.00, 'e-(ethereum)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 21:17:07', '2024-11-19 21:17:07');
INSERT INTO `new_bets` VALUES (727, 110, 'aaa', 2.36, 1, 56.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 21:17:29', '2024-11-19 21:17:29');
INSERT INTO `new_bets` VALUES (728, 112, 'aadfds', 2.36, 1, 5698.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 21:17:45', '2024-11-19 21:17:45');
INSERT INTO `new_bets` VALUES (729, 109, 'adfadsf', 2.37, 1, 5695.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 21:18:37', '2024-11-19 21:18:37');
INSERT INTO `new_bets` VALUES (748, 143, 'dfsafa', 2.35, 1, 254.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 21:22:22', '2024-11-19 21:22:22');
INSERT INTO `new_bets` VALUES (749, 109, 'fdsafa', 2.35, 1, 7895.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 21:28:24', '2024-11-19 21:28:24');
INSERT INTO `new_bets` VALUES (750, 110, 'aa', 2.35, 1, 456.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 21:30:48', '2024-11-19 21:30:48');
INSERT INTO `new_bets` VALUES (751, 110, 'aaaa', 2.36, 1, 456.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 21:30:59', '2024-11-19 21:30:59');
INSERT INTO `new_bets` VALUES (752, 110, 'awe', 2.35, 1, 598.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 21:31:12', '2024-11-19 21:31:12');
INSERT INTO `new_bets` VALUES (753, 112, 'dfa', 1235.00, 1, 4568.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 21:36:04', '2024-11-19 21:36:04');
INSERT INTO `new_bets` VALUES (754, 110, 'aaa', 2.26, 1, 2650.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 21:36:16', '2024-11-19 21:36:16');
INSERT INTO `new_bets` VALUES (755, 109, 'aaa', 2.36, 1, 897.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 21:36:52', '2024-11-19 21:36:52');
INSERT INTO `new_bets` VALUES (756, 110, 'aa', 2.36, 1, 56.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 21:37:32', '2024-11-19 21:37:32');
INSERT INTO `new_bets` VALUES (757, 130, 'avd', 546.00, 1, 123.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 21:37:48', '2024-11-19 21:37:48');
INSERT INTO `new_bets` VALUES (758, 110, 'avd', 2.21, 1, 1250.00, 'u-(usdt)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 21:38:07', '2024-11-19 21:38:07');
INSERT INTO `new_bets` VALUES (759, 126, 'abab', 2.37, 1, 897.00, 'r-(RS3)', NULL, 0.01500, 3, 1, NULL, NULL, '2024-11-19 21:38:25', '2024-11-19 21:38:25');
INSERT INTO `new_bets` VALUES (760, 126, 'aaa', 2.36, 1, 564.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 21:55:09', '2024-11-19 21:55:09');
INSERT INTO `new_bets` VALUES (761, 130, 'aaa', 3.60, 1, 789.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 21:55:20', '2024-11-19 21:55:20');
INSERT INTO `new_bets` VALUES (777, 110, 'aaa', 2.37, 1, 789.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:02:39', '2024-11-19 23:02:39');
INSERT INTO `new_bets` VALUES (778, 143, 'aaa', 2.37, 1, 265.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:02:48', '2024-11-19 23:02:48');
INSERT INTO `new_bets` VALUES (779, 109, 'adfas', 2.37, 1, 897.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:02:59', '2024-11-19 23:02:59');
INSERT INTO `new_bets` VALUES (780, 109, 'aa', 2.35, 1, 8979.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:05:16', '2024-11-19 23:05:16');
INSERT INTO `new_bets` VALUES (781, 143, 'afa', 2.35, 1, 78.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:10:29', '2024-11-19 23:10:29');
INSERT INTO `new_bets` VALUES (782, 112, 'uyiy', 2.36, 1, 78.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:10:40', '2024-11-19 23:10:40');
INSERT INTO `new_bets` VALUES (783, 112, 'uiyiyu', 2.37, 1, 789.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:11:20', '2024-11-19 23:11:20');
INSERT INTO `new_bets` VALUES (784, 130, 'aa', 2.50, 1, 89.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:16:34', '2024-11-19 23:16:34');
INSERT INTO `new_bets` VALUES (785, 110, 'test43', 23.00, 1, 2365.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:16:48', '2024-11-19 23:16:48');
INSERT INTO `new_bets` VALUES (786, 130, 'last', 2.35, 1, 89.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:17:05', '2024-11-19 23:17:05');
INSERT INTO `new_bets` VALUES (787, 136, 'test3', 2.35, 1, 897.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:18:02', '2024-11-19 23:18:02');
INSERT INTO `new_bets` VALUES (788, 126, 'ava', 2.69, 1, 784.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:18:18', '2024-11-19 23:18:18');
INSERT INTO `new_bets` VALUES (789, 110, 'last3', 2.65, 1, 785.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:19:07', '2024-11-19 23:19:07');
INSERT INTO `new_bets` VALUES (790, 112, 'test', 2.34, 1, 1561.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:20:11', '2024-11-19 23:20:11');
INSERT INTO `new_bets` VALUES (791, 112, 'as', 2.35, 1, 652.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:20:24', '2024-11-19 23:20:24');
INSERT INTO `new_bets` VALUES (792, 126, 'tste', 2.37, 1, 952.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:21:07', '2024-11-19 23:21:07');
INSERT INTO `new_bets` VALUES (793, 109, 'aaa', 2.31, 1, 555.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:21:30', '2024-11-19 23:21:30');
INSERT INTO `new_bets` VALUES (794, 126, 'aaa', 2.35, 1, 89.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:21:40', '2024-11-19 23:21:40');
INSERT INTO `new_bets` VALUES (795, 126, 'saaf', 2.35, 1, 897.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:28:46', '2024-11-19 23:28:46');
INSERT INTO `new_bets` VALUES (796, 112, 'test', 2.35, 1, 522.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:28:59', '2024-11-19 23:28:59');
INSERT INTO `new_bets` VALUES (797, 109, 'ffa', 2.35, 1, 255.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:29:11', '2024-11-19 23:29:11');
INSERT INTO `new_bets` VALUES (798, 111, 'afd', 2.35, 1, 788.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:31:23', '2024-11-19 23:31:23');
INSERT INTO `new_bets` VALUES (799, 126, 'test', 2.15, 1, 899.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:31:36', '2024-11-19 23:31:36');
INSERT INTO `new_bets` VALUES (800, 111, 'aaa', 2.35, 1, 955.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:31:48', '2024-11-19 23:31:48');
INSERT INTO `new_bets` VALUES (801, 111, 'aaa', 2.35, 1, 99.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:31:59', '2024-11-19 23:31:59');
INSERT INTO `new_bets` VALUES (802, 111, 'aaa', 2.34, 1, 89.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:32:11', '2024-11-19 23:32:11');
INSERT INTO `new_bets` VALUES (803, 126, 'aaa', 5.25, 1, 98.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:33:01', '2024-11-19 23:33:01');
INSERT INTO `new_bets` VALUES (804, 126, 'yrdh', 2.35, 1, 987.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:33:14', '2024-11-19 23:33:14');
INSERT INTO `new_bets` VALUES (805, 126, 'avda', 2.34, 1, 985.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:34:41', '2024-11-19 23:34:41');
INSERT INTO `new_bets` VALUES (806, 126, 'afds', 9.35, 1, 1234.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:34:57', '2024-11-19 23:34:57');
INSERT INTO `new_bets` VALUES (807, 111, 'aaa', 3.30, 1, 9556.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:35:14', '2024-11-19 23:35:14');
INSERT INTO `new_bets` VALUES (808, 126, 'afs', 2.37, 1, 965.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:35:33', '2024-11-19 23:35:33');
INSERT INTO `new_bets` VALUES (809, 109, 'av', 2.37, 1, 564.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:36:10', '2024-11-19 23:36:10');
INSERT INTO `new_bets` VALUES (810, 126, 'afas', 2.30, 1, 65.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:38:43', '2024-11-19 23:38:43');
INSERT INTO `new_bets` VALUES (811, 111, 'afsa', 2.31, 1, 65.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:38:59', '2024-11-19 23:38:59');
INSERT INTO `new_bets` VALUES (812, 136, 'fdsafas', 25.00, 1, 35.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:39:31', '2024-11-19 23:39:31');
INSERT INTO `new_bets` VALUES (813, 126, 'aa', 2.30, 1, 569.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:40:16', '2024-11-19 23:40:16');
INSERT INTO `new_bets` VALUES (814, 126, 'vdf', 2.34, 1, 896.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:40:33', '2024-11-19 23:40:33');
INSERT INTO `new_bets` VALUES (815, 126, 'avs', 2.34, 1, 895.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:40:55', '2024-11-19 23:40:55');
INSERT INTO `new_bets` VALUES (818, 112, 'test', 2.34, 1, 98.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:45:26', '2024-11-19 23:45:26');
INSERT INTO `new_bets` VALUES (819, 112, 'avd', 2.34, 1, 88.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:45:38', '2024-11-19 23:45:38');
INSERT INTO `new_bets` VALUES (820, 112, 'aaa', 2.31, 1, 45.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:46:22', '2024-11-19 23:46:22');
INSERT INTO `new_bets` VALUES (830, 157, 'check11', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:47:55', '2024-11-19 23:47:55');
INSERT INTO `new_bets` VALUES (831, 157, 'check11', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:47:56', '2024-11-19 23:47:56');
INSERT INTO `new_bets` VALUES (832, 157, 'check11', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:47:57', '2024-11-19 23:47:57');
INSERT INTO `new_bets` VALUES (833, 112, 'aaa', 2.54, 1, 65.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:49:37', '2024-11-19 23:49:37');
INSERT INTO `new_bets` VALUES (834, 112, 'avd', 2.37, 1, 965.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-19 23:49:50', '2024-11-19 23:49:50');
INSERT INTO `new_bets` VALUES (835, 110, 'test333', 0.20, 1, 200.00, 'a-(applepay)', NULL, 1.00000, 1, 1, NULL, NULL, '2024-11-21 05:03:46', '2024-11-21 05:03:53');
INSERT INTO `new_bets` VALUES (836, 158, 'aaa', 0.32, 1, 200.00, 'a-(applepay)', NULL, 1.00000, 1, 1, NULL, NULL, '2024-11-21 05:04:44', '2024-11-21 05:04:52');
INSERT INTO `new_bets` VALUES (839, 161, 'aaa', 2.37, 1, 600.00, 'm-(OSRS)', NULL, 0.20000, 1, 1, NULL, NULL, '2024-11-21 05:17:32', '2024-11-21 05:17:43');
INSERT INTO `new_bets` VALUES (840, 162, 'agg', 2.35, 1, 300.00, 'm-(OSRS)', NULL, 0.20000, 1, 1, NULL, NULL, '2024-11-21 05:19:06', '2024-11-21 05:19:19');
INSERT INTO `new_bets` VALUES (841, 163, 'aaa', 2.54, 1, 8000.00, 'r-(RS3)', NULL, 0.01500, 1, 1, NULL, NULL, '2024-11-21 05:21:29', '2024-11-21 05:21:47');
INSERT INTO `new_bets` VALUES (842, 157, 'check11', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-21 17:29:29', '2024-11-21 17:29:29');
INSERT INTO `new_bets` VALUES (843, 157, 'check11', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-21 17:29:31', '2024-11-21 17:29:31');
INSERT INTO `new_bets` VALUES (844, 157, 'check11', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-21 17:29:33', '2024-11-21 17:29:33');
INSERT INTO `new_bets` VALUES (845, 157, 'check11', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-21 17:29:34', '2024-11-21 17:29:34');
INSERT INTO `new_bets` VALUES (846, 157, 'check11', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-21 17:29:36', '2024-11-21 17:29:36');
INSERT INTO `new_bets` VALUES (847, 157, 'check11', 2.40, 1, 500.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-21 17:29:37', '2024-11-21 17:29:37');
INSERT INTO `new_bets` VALUES (848, 136, 'afda', 2.15, 1, 23.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-21 17:30:17', '2024-11-21 17:30:17');
INSERT INTO `new_bets` VALUES (850, 143, 'afdas', 2.36, 1, 2342.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-21 17:30:40', '2024-11-21 17:30:40');
INSERT INTO `new_bets` VALUES (851, 130, 'afdsa', 2.37, 1, 2342.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-21 17:30:50', '2024-11-21 17:30:50');
INSERT INTO `new_bets` VALUES (852, 136, 'teste', 2.36, 1, 789.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-21 17:32:39', '2024-11-21 17:32:39');
INSERT INTO `new_bets` VALUES (853, 143, 'fadsfdsa', 2.66, 1, 89.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-21 17:32:50', '2024-11-21 17:32:50');
INSERT INTO `new_bets` VALUES (854, 110, 'test', 2.37, 1, 2342.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-21 17:33:01', '2024-11-21 17:33:01');
INSERT INTO `new_bets` VALUES (855, 110, 'stew', 2.37, 1, 2342.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-21 17:33:12', '2024-11-21 17:33:12');
INSERT INTO `new_bets` VALUES (856, 109, 'fasdfsa', 2.36, 1, 2342.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-21 17:33:23', '2024-11-21 17:33:23');
INSERT INTO `new_bets` VALUES (857, 127, 'afa', 2.25, 1, 369.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-22 06:23:31', '2024-11-22 06:23:31');
INSERT INTO `new_bets` VALUES (858, 163, 'aaa', 2.37, 1, 265.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-22 06:23:44', '2024-11-22 06:23:44');
INSERT INTO `new_bets` VALUES (859, 110, 'aaa', 2.37, 1, 8979.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-22 06:23:56', '2024-11-22 06:23:56');
INSERT INTO `new_bets` VALUES (860, 143, 'aaa', 2.36, 1, 89.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-22 06:24:08', '2024-11-22 06:24:08');
INSERT INTO `new_bets` VALUES (861, 109, 'avav', 2.37, 1, 789.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-22 06:24:19', '2024-11-22 06:24:19');
INSERT INTO `new_bets` VALUES (862, 136, 'aaa', 2.36, 1, 300.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-22 19:46:55', '2024-11-22 19:46:55');
INSERT INTO `new_bets` VALUES (863, 143, 'aa', 2.31, 1, 89.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-22 19:47:06', '2024-11-22 19:47:06');
INSERT INTO `new_bets` VALUES (864, 127, 'aa', 2.35, 1, 560.00, 'a-(applepay)', NULL, 1.00000, 3, 1, NULL, NULL, '2024-11-24 01:01:51', '2024-11-24 01:01:51');
INSERT INTO `new_bets` VALUES (870, 122, 'ab', 2.30, 1, 789.00, 'a-(applepay)', NULL, 1.00000, 1, 1, NULL, NULL, '2024-11-24 02:35:07', '2024-12-10 20:25:09');
INSERT INTO `new_bets` VALUES (871, 115, 'fdsa', 2.36, 1, 78.00, 'a-(applepay)', NULL, 1.00000, 2, 1, NULL, NULL, '2024-11-24 02:35:18', '2024-12-10 20:22:22');
INSERT INTO `new_bets` VALUES (885, 126, 've', 2.36, 1, 87.00, 'a-(applepay)', NULL, 1.00000, 0, 1, NULL, NULL, '2024-11-24 19:44:45', '2024-12-10 18:49:20');
INSERT INTO `new_bets` VALUES (888, 119, 'a', 2.31, 1, 21.00, 'a-(applepay)', NULL, 1.00000, 1, 1, NULL, NULL, '2024-11-24 19:45:22', '2024-12-10 18:48:53');
INSERT INTO `new_bets` VALUES (889, 163, 'aa', 2.36, 1, 78.00, 'a-(applepay)', NULL, 1.00000, 1, 1, NULL, NULL, '2024-11-24 20:40:26', '2024-11-24 20:40:36');
INSERT INTO `new_bets` VALUES (890, NULL, 'fgdsg', 2.35, 1, 43.00, 'e-(ethereum)', NULL, 1.00000, NULL, NULL, NULL, NULL, '2024-12-10 20:40:55', '2024-12-10 20:40:55');
INSERT INTO `new_bets` VALUES (892, NULL, '33', 2.35, 1, 333.00, 'b-(bitcoin)', NULL, 1.00000, NULL, NULL, NULL, NULL, '2024-12-10 20:43:39', '2024-12-10 20:43:39');
INSERT INTO `new_bets` VALUES (894, 1, 'fgdsg', 2.35, 1, 23.00, 'e-(ethereum)', NULL, 1.00000, NULL, NULL, NULL, NULL, '2024-12-11 00:06:10', '2024-12-11 00:06:10');
INSERT INTO `new_bets` VALUES (895, 143, 'test333', 2.35, 1, 900.00, 'e-(ethereum)', NULL, 1.00000, NULL, NULL, NULL, NULL, '2024-12-11 01:12:49', '2024-12-11 01:12:49');
INSERT INTO `new_bets` VALUES (896, 136, 'slip-test222', 2.35, 1, 43.00, 'm-(OSRS)', NULL, 0.23500, NULL, NULL, NULL, NULL, '2024-12-11 01:15:00', '2024-12-11 01:15:00');
INSERT INTO `new_bets` VALUES (897, 130, 'slip-tttt22', 2.35, 1, 430.00, 'c-(CAD)', NULL, 0.75000, 0, NULL, NULL, NULL, '2024-12-11 01:17:38', '2024-12-11 01:17:38');

-- ----------------------------
-- Table structure for splitters
-- ----------------------------
DROP TABLE IF EXISTS `splitters`;
CREATE TABLE `splitters`  (
  `id` bigint(20) UNSIGNED NOT NULL AUTO_INCREMENT,
  `customer_id` int(11) NOT NULL COMMENT 'customer id',
  `amount` double(8, 2) NOT NULL COMMENT 'bet amount',
  `new_bets_id` int(11) NOT NULL COMMENT 'new bet id',
  PRIMARY KEY (`id`) USING BTREE
) ENGINE = InnoDB AUTO_INCREMENT = 440 CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of splitters
-- ----------------------------
INSERT INTO `splitters` VALUES (365, 106, 100.00, 650);
INSERT INTO `splitters` VALUES (366, 112, 20.00, 655);
INSERT INTO `splitters` VALUES (367, 113, 20.00, 656);
INSERT INTO `splitters` VALUES (368, 112, 50.00, 656);
INSERT INTO `splitters` VALUES (369, 113, 100.00, 657);
INSERT INTO `splitters` VALUES (370, 129, 100.00, 658);
INSERT INTO `splitters` VALUES (371, 113, 100.00, 659);
INSERT INTO `splitters` VALUES (372, 129, 100.00, 660);
INSERT INTO `splitters` VALUES (373, 129, 100.00, 661);
INSERT INTO `splitters` VALUES (374, 112, 200.00, 662);
INSERT INTO `splitters` VALUES (375, 158, 100.00, 663);
INSERT INTO `splitters` VALUES (376, 129, 1000.00, 664);
INSERT INTO `splitters` VALUES (377, 129, 100.00, 665);
INSERT INTO `splitters` VALUES (378, 129, 22.00, 666);
INSERT INTO `splitters` VALUES (379, 113, 200.00, 669);
INSERT INTO `splitters` VALUES (380, 112, 100.00, 670);
INSERT INTO `splitters` VALUES (381, 112, 100.00, 667);
INSERT INTO `splitters` VALUES (382, 113, 100.00, 675);
INSERT INTO `splitters` VALUES (383, 113, 1000.00, 678);
INSERT INTO `splitters` VALUES (384, 129, 100.00, 683);
INSERT INTO `splitters` VALUES (385, 129, 100.00, 684);
INSERT INTO `splitters` VALUES (386, 129, 200.00, 686);
INSERT INTO `splitters` VALUES (387, 129, 50.00, 686);
INSERT INTO `splitters` VALUES (388, 113, 45.00, 691);
INSERT INTO `splitters` VALUES (389, 113, 50.00, 692);
INSERT INTO `splitters` VALUES (390, 129, 100.00, 694);
INSERT INTO `splitters` VALUES (391, 112, 522.00, 695);
INSERT INTO `splitters` VALUES (392, 129, 100.00, 696);
INSERT INTO `splitters` VALUES (393, 229, 70.00, 697);
INSERT INTO `splitters` VALUES (394, 229, 70.00, 698);
INSERT INTO `splitters` VALUES (395, 229, 70.00, 699);
INSERT INTO `splitters` VALUES (396, 229, 70.00, 700);
INSERT INTO `splitters` VALUES (397, 229, 70.00, 701);
INSERT INTO `splitters` VALUES (398, 229, 70.00, 702);
INSERT INTO `splitters` VALUES (399, 229, 70.00, 703);
INSERT INTO `splitters` VALUES (400, 229, 70.00, 704);
INSERT INTO `splitters` VALUES (401, 229, 70.00, 707);
INSERT INTO `splitters` VALUES (402, 229, 70.00, 708);
INSERT INTO `splitters` VALUES (403, 229, 70.00, 709);
INSERT INTO `splitters` VALUES (404, 229, 70.00, 710);
INSERT INTO `splitters` VALUES (405, 229, 70.00, 711);
INSERT INTO `splitters` VALUES (406, 229, 70.00, 712);
INSERT INTO `splitters` VALUES (407, 229, 70.00, 713);
INSERT INTO `splitters` VALUES (408, 229, 70.00, 714);
INSERT INTO `splitters` VALUES (409, 229, 70.00, 715);
INSERT INTO `splitters` VALUES (410, 229, 70.00, 716);
INSERT INTO `splitters` VALUES (411, 229, 70.00, 717);
INSERT INTO `splitters` VALUES (412, 229, 70.00, 718);
INSERT INTO `splitters` VALUES (413, 229, 70.00, 719);
INSERT INTO `splitters` VALUES (414, 229, 70.00, 821);
INSERT INTO `splitters` VALUES (415, 229, 70.00, 822);
INSERT INTO `splitters` VALUES (416, 229, 70.00, 823);
INSERT INTO `splitters` VALUES (417, 229, 70.00, 824);
INSERT INTO `splitters` VALUES (418, 229, 70.00, 825);
INSERT INTO `splitters` VALUES (419, 229, 70.00, 826);
INSERT INTO `splitters` VALUES (420, 229, 70.00, 827);
INSERT INTO `splitters` VALUES (421, 229, 70.00, 828);
INSERT INTO `splitters` VALUES (422, 229, 70.00, 829);
INSERT INTO `splitters` VALUES (423, 229, 70.00, 830);
INSERT INTO `splitters` VALUES (424, 229, 70.00, 831);
INSERT INTO `splitters` VALUES (425, 229, 70.00, 832);
INSERT INTO `splitters` VALUES (426, 229, 70.00, 842);
INSERT INTO `splitters` VALUES (427, 229, 70.00, 843);
INSERT INTO `splitters` VALUES (428, 229, 70.00, 844);
INSERT INTO `splitters` VALUES (429, 229, 70.00, 845);
INSERT INTO `splitters` VALUES (430, 229, 70.00, 846);
INSERT INTO `splitters` VALUES (431, 229, 70.00, 847);
INSERT INTO `splitters` VALUES (438, 110, 12.00, 901);
INSERT INTO `splitters` VALUES (439, 106, 154.00, 901);

-- ----------------------------
-- Table structure for transactions
-- ----------------------------
DROP TABLE IF EXISTS `transactions`;
CREATE TABLE `transactions`  (
  `amount` double NOT NULL,
  `type_money` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `customer_name` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `type_net` tinyint(4) NOT NULL,
  `description` varchar(255) CHARACTER SET utf8mb4 COLLATE utf8mb4_unicode_ci NOT NULL,
  `created_at` timestamp(0) NOT NULL DEFAULT current_timestamp(0) ON UPDATE CURRENT_TIMESTAMP(0),
  `updated_at` datetime(0) NOT NULL
) ENGINE = InnoDB CHARACTER SET = utf8mb4 COLLATE = utf8mb4_unicode_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of transactions
-- ----------------------------
INSERT INTO `transactions` VALUES (200, '0', 'empty', 1, '200m added to NET', '2024-11-08 14:56:51', '2024-11-08 14:56:51');
INSERT INTO `transactions` VALUES (-35, '0', 'empty', 1, '35$ subtracted from NET', '2024-11-08 14:58:17', '2024-11-08 14:58:17');
INSERT INTO `transactions` VALUES (100, 'm_game_currency_history', 'Guard', 2, '100m has been added to Guard\'s tab', '2024-11-10 09:13:59', '2024-11-10 09:13:59');
INSERT INTO `transactions` VALUES (100, 'r_rs3_history', 'Guard', 2, '100RS3 has been added to Guard\'s tab', '2024-11-10 09:13:59', '2024-11-10 09:13:59');
INSERT INTO `transactions` VALUES (100, '0', 'empty', 0, '100m added to NET and IRC', '2024-11-10 09:48:19', '2024-11-10 09:48:19');
INSERT INTO `transactions` VALUES (1000, '0', 'empty', 0, '1000r added to NET and IRC', '2024-11-10 09:49:01', '2024-11-10 09:49:01');
INSERT INTO `transactions` VALUES (1000, '0', 'empty', 1, '1000r added to NET', '2024-11-10 09:49:44', '2024-11-10 09:49:44');
INSERT INTO `transactions` VALUES (12, '0', 'empty', 1, '12$ added to NET', '2024-12-09 20:36:42', '2024-12-09 20:36:42');
INSERT INTO `transactions` VALUES (222, '0', 'empty', 1, '222r added to NET', '2024-12-09 20:38:44', '2024-12-09 20:38:44');
INSERT INTO `transactions` VALUES (200, '0', 'empty', 1, '200m added to NET', '2024-12-09 20:38:52', '2024-12-09 20:38:52');
INSERT INTO `transactions` VALUES (200, '0', 'empty', 1, '200m added to NET', '2024-12-09 20:50:34', '2024-12-09 20:50:34');
INSERT INTO `transactions` VALUES (450, '0', 'empty', 1, '450m added to NET', '2024-12-09 22:05:03', '2024-12-09 22:05:03');
INSERT INTO `transactions` VALUES (333, '0', 'empty', 1, '333r added to NET', '2024-12-09 22:05:50', '2024-12-09 22:05:50');
INSERT INTO `transactions` VALUES (22, '0', 'empty', 1, '22m added to NET', '2024-12-09 22:05:58', '2024-12-09 22:05:58');
INSERT INTO `transactions` VALUES (50, 'a_apply_pay_history', 'Dorin', 2, '50$ ApplePay has been added to Dorin\'s tab', '2024-12-11 09:19:19', '2024-12-11 09:19:19');
INSERT INTO `transactions` VALUES (10, 'b(b_bitcoin)', 'ccc', 2, '10$  has been added to ccc\'s tab', '2024-12-11 09:21:43', '2024-12-11 09:21:43');
INSERT INTO `transactions` VALUES (10, 'b(b_bitcoin)_history', 'ccc', 2, '10$  has been added to ccc\'s tab', '2024-12-11 09:21:43', '2024-12-11 09:21:43');
INSERT INTO `transactions` VALUES (20, 'a_apply_pay_history', 'Dorin', 2, '20$ ApplePay has been added to Dorin\'s tab', '2024-12-11 09:22:04', '2024-12-11 09:22:04');
INSERT INTO `transactions` VALUES (12, 'a_apply_pay_history', 'ccc', 2, '12$ ApplePay has been added to ccc\'s tab', '2024-12-11 09:22:33', '2024-12-11 09:22:33');
INSERT INTO `transactions` VALUES (20, 'c_card_history', 'ccc', 2, '20$ CAD has been added to ccc\'s tab', '2024-12-11 09:22:47', '2024-12-11 09:22:47');

SET FOREIGN_KEY_CHECKS = 1;
