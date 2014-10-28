CREATE TABLE `log_reader` (
  `log_id` varchar(32) COLLATE latin1_german1_ci NOT NULL DEFAULT '',
  `name` varchar(255) COLLATE latin1_german1_ci DEFAULT '',
  `location` varchar(1024) COLLATE latin1_german1_ci DEFAULT '',
  `real_location` varchar(1024) COLLATE latin1_german1_ci DEFAULT NULL,
  PRIMARY KEY (`log_id`)
);