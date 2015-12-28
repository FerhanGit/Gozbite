CREATE TABLE `tblUsers` (
  `UserId` int(11) NOT NULL auto_increment,
  `Name` varchar(50) NOT NULL default '',
  `Email` varchar(255) NOT NULL default '',
  `DOB` date NOT NULL default '0000-00-00',
  PRIMARY KEY  (`UserId`)
);

-- 
INSERT INTO `tblUsers` VALUES (1, 'Aman','aman@yahoo.com', '1987-06-22');
INSERT INTO `tblUsers` VALUES (2, 'Russell', 'rwinslow@rediffmail.com', '1976-01-01');
INSERT INTO `tblUsers` VALUES (3, 'mstuart','mstuart@hotmail.com', '1978-08-08');
INSERT INTO `tblUsers` VALUES (4, 'Bhupinder','bfaber@gmail.com', '1979-01-01');
INSERT INTO `tblUsers` VALUES (5, 'Chetan', 'barryfaber@gmail.net', '1986-02-04');
INSERT INTO `tblUsers` VALUES (6, 'Philip', 'webmaster@123greetings.com', '1980-01-01');
INSERT INTO `tblUsers` VALUES (7, 'Ajay', 'webmaster@rediffmail.com', '1979-01-01');
INSERT INTO `tblUsers` VALUES (8, 'Bhawdeep gupta', 'bhawdeep@hotmail.com', '1980-05-06');
INSERT INTO `tblUsers` VALUES (9, 'Neeraj', 'neeraj@yahool.com', '1980-04-04');
