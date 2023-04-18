ALTER TABLE `flash_deal_products` ADD `order` INT( 11 ) NOT NULL DEFAULT '0' AFTER `product_id`;

COMMIT;