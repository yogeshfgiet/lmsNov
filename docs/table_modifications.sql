-- Modified DB Query

-- Rajanikant 03Aug
ALTER TABLE  `showings` CHANGE  `start_time`  `start_time` TIMESTAMP NOT NULL DEFAULT  '0000-00-00 00:00:00';
ALTER TABLE  `users` CHANGE  `created_at`  `created_at` TIMESTAMP NOT NULL DEFAULT  '0000-00-00 00:00:00';
ALTER TABLE `showings`  ADD `created_at` TIMESTAMP NOT NULL DEFAULT '0000-00-00 00:00:00' AFTER `search_criteria`,  
ADD `updated_at` TIMESTAMP on update CURRENT_TIMESTAMP NOT NULL DEFAULT CURRENT_TIMESTAMP AFTER `created_at`;

-- Pravasini 03Aug
ALTER TABLE `users` ADD `activation_code` CHAR(105) NULL DEFAULT NULL;

-- Pravasini 04Aug
ALTER TABLE `posting_agent_info` CHANGE `cvv_number` `cvv_number` CHAR(4) NOT NULL;

-- Rajanikant 04Aug
ALTER TABLE  `users` CHANGE  `average_rating`  `average_rating` DECIMAL( 3, 2 ) UNSIGNED NOT NULL DEFAULT  '0';
ALTER TABLE  `showings` ADD INDEX (  `user_id` ) ;
ALTER TABLE  `showings` ADD INDEX (  `showing_user_id` ) ;

-- Pravasini 11Aug
ALTER TABLE `posting_agent_info` CHANGE `expiry_month` `expiry_month` TINYINT(4) NOT NULL COMMENT 'From 1 - 12 i.e. 1 for January, 2 for February and 12 for December';

-- Pravasini 11Aug
ALTER TABLE `showings` CHANGE `showing_progress` `showing_progress` TINYINT(4) NOT NULL DEFAULT '0' COMMENT '1=accepted by showing agent, 2=approved by posting agent, 3=rejected by posting agent, 4=completed, 5=waiting for payment, 6=payment done';

-- Rajanikant 18Aug
ALTER TABLE  `users` DROP  `salt` ;

-- Rajanikant 21 Aug
ALTER TABLE  `posting_agent_info` ADD  `auth_net_card_payment_id` VARCHAR( 45 ) NOT NULL COMMENT  'authorize.net credit card payment profile id' AFTER  `user_id` ;
ALTER TABLE `posting_agent_info` DROP `cvv_number`;
ALTER TABLE  `posting_agent_info` CHANGE  `card_number`  `card_number` VARCHAR( 4 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL COMMENT  'credit card number';
ALTER TABLE  `showing_agent_info` ADD  `auth_net_bank_account_id` VARCHAR( 45 ) NOT NULL COMMENT  'authorize.net bank account id' AFTER `user_id` ;
ALTER TABLE  `users` ADD  `auth_net_customer_id` VARCHAR( 45 ) NOT NULL COMMENT  'Authrize.Net customer id' AFTER  `last_name` ;
ALTER TABLE  `users` CHANGE  `auth_net_customer_id`  `auth_net_customer_id` VARCHAR( 45 ) CHARACTER SET utf8 COLLATE utf8_general_ci NOT NULL DEFAULT  '''''' COMMENT  'Authrize.Net customer id';

-- Rajanikant 24 Aug
ALTER TABLE  `showing_agent_info` DROP  `holder_type` ;
ALTER TABLE  `showing_agent_info` CHANGE  `account_type`  `account_type` TINYINT( 4 ) UNSIGNED NOT NULL DEFAULT  '0' COMMENT '0=savings, 1=checking 2= business checking';

-- Pravasini 26 Aug
ALTER TABLE `showings` ADD `customer_name` VARCHAR(255) NOT NULL AFTER
`expiration_time`;
ALTER TABLE `showings` ADD `customer_email` VARCHAR(45) NOT NULL AFTER
`customer_name`, ADD `customer_phone_number` VARCHAR(20) NOT NULL AFTER
`customer_email`;
ALTER TABLE `showings` ADD `comments` TEXT NOT NULL AFTER `customer_phone_number`;

ALTER TABLE `showing_houses`
  DROP `customer_email`,
  DROP `customer_phoner_number`,
  DROP `comments`;

-- 23 Nov 2015 Rajanikant
ALTER TABLE  `showing_houses` ADD  `lat_long` VARCHAR( 255 ) NOT NULL COMMENT  'latitude and longitude of houses' AFTER  `MLS_number` ;

--25 Nov 2015 Rajanikant
ALTER TABLE  `showings` CHANGE  `search_criteria`  `search_criteria` TINYINT( 4 ) UNSIGNED NOT NULL DEFAULT  '1' COMMENT '0=search by name or everyone, 1=agent rating(1+), 2=agent rating(2+), 3=agent rating(3+), 4=agent rating(4+), 5=agent rating(5)';
-- 21 DEC 2015 Rajanikant
ALTER TABLE  `showings` ADD  `additional_fee` DECIMAL( 7, 2 ) NOT NULL DEFAULT  '0.00' AFTER  `comments` ;