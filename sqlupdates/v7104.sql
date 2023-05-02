ALTER TABLE `orders` ADD COLUMN `courier` VARCHAR (25) DEFAULT '' AFTER `payment_method`;

COMMIT;