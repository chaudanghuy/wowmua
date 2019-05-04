# WOWMUA

## DATABASE NOTE
- 2018-12-14 11:13PM
 - Create table mailguns
 - ALTER TABLE `orders` ADD `send_mail` tinyint(1) NOT NULL AFTER `modified`;
 - ALTER TABLE `orders` ADD `default_lang` VARCHAR(20) NOT NULL AFTER `send_mail`;
