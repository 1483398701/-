/*
 Navicat Premium Data Transfer

 Source Server         : user
 Source Server Type    : MySQL
 Source Server Version : 50724
 Source Host           : localhost:3306
 Source Schema         : bighomework

 Target Server Type    : MySQL
 Target Server Version : 50724
 File Encoding         : 65001

 Date: 31/05/2019 20:48:00
*/

SET NAMES utf8mb4;
SET FOREIGN_KEY_CHECKS = 0;

-- ----------------------------
-- Table structure for build
-- ----------------------------
DROP TABLE IF EXISTS `build`;
CREATE TABLE `build`  (
  `Build_Name` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '宿舍名',
  `Build_Id` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '宿舍楼',
  `Build_Price` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '宿舍单价',
  PRIMARY KEY (`Build_Name`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of build
-- ----------------------------
INSERT INTO `build` VALUES ('C1', '1', '2500');
INSERT INTO `build` VALUES ('C2', '2', '3000');

-- ----------------------------
-- Table structure for dor_visit
-- ----------------------------
DROP TABLE IF EXISTS `dor_visit`;
CREATE TABLE `dor_visit`  (
  `Stu_No` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学号',
  `Apart_No` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '宿舍楼',
  `Dor_No` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '宿舍号',
  `Visit_Reason` varchar(255) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '访问原因',
  `Visit_In` timestamp(0) NOT NULL COMMENT '访问时间',
  `Visit_Out` timestamp(0) NOT NULL COMMENT '离开时间',
  PRIMARY KEY (`Stu_No`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dor_visit
-- ----------------------------
INSERT INTO `dor_visit` VALUES ('2017100', 'C1', '101', 'test1', '2019-05-08 14:05:23', '2019-05-09 00:00:00');
INSERT INTO `dor_visit` VALUES ('2017103', 'C1', '101', 'test2', '2019-05-09 14:05:23', '2019-05-09 15:05:23');

-- ----------------------------
-- Table structure for dormitory
-- ----------------------------
DROP TABLE IF EXISTS `dormitory`;
CREATE TABLE `dormitory`  (
  `Dor_Id` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '宿舍id',
  `Dor_No` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '宿舍编号',
  `Dor_BedNum` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '床位数',
  `Dor_Person` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '已入住人数',
  `Build_Id` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '归属宿舍楼',
  PRIMARY KEY (`Dor_Id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of dormitory
-- ----------------------------
INSERT INTO `dormitory` VALUES ('1', '101', '4', '2', '1');
INSERT INTO `dormitory` VALUES ('2', '102', '4', '1', '2');
INSERT INTO `dormitory` VALUES ('3', '102', '4', '1', '1');

-- ----------------------------
-- Table structure for student
-- ----------------------------
DROP TABLE IF EXISTS `student`;
CREATE TABLE `student`  (
  `Stu_No` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '学号',
  `Stu_Sex` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '性别',
  `Stu_Age` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '年龄',
  `Stu_Grade` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '年级',
  `Stu_Department` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '院系',
  `Stu_Phone` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '电话',
  `Dor_Id` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '宿舍id',
  `Dor_DedNum` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '床号',
  PRIMARY KEY (`Stu_No`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of student
-- ----------------------------
INSERT INTO `student` VALUES ('2017100', '男', '20', '大一', '计算机工程学院', '12344556688', '1', '3');
INSERT INTO `student` VALUES ('2017103', '男', '22', '大二', '电气工程学院', '10086', '1', '2');
INSERT INTO `student` VALUES ('2017104', '男', '20', '大一', '电气工程学院', '10086', '3', '1');
INSERT INTO `student` VALUES ('2017105', '男', '22', '大二', '电气工程学院', '12344556633', '2', '1');

-- ----------------------------
-- Table structure for user
-- ----------------------------
DROP TABLE IF EXISTS `user`;
CREATE TABLE `user`  (
  `user_Num` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户编号',
  `Id` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户编号，如果是学生请输入学号',
  `UserName` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '姓名',
  `Password` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '登陆密码',
  `Power` varchar(16) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT '用户权限',
  PRIMARY KEY (`Id`) USING BTREE
) ENGINE = MyISAM CHARACTER SET = utf8 COLLATE = utf8_general_ci ROW_FORMAT = Dynamic;

-- ----------------------------
-- Records of user
-- ----------------------------
INSERT INTO `user` VALUES ('1', '12345', '超管1', '123', '1');
INSERT INTO `user` VALUES ('2', '2017200', '宿管甲', '111', '2');
INSERT INTO `user` VALUES ('7', '2017100', '小明', '123', '3');
INSERT INTO `user` VALUES ('5', '2017103', '小黑', '123', '3');
INSERT INTO `user` VALUES ('6', '2017104', '小白', '123', '3');
INSERT INTO `user` VALUES ('7', '2017105', '小刚', '123', '3');

SET FOREIGN_KEY_CHECKS = 1;
