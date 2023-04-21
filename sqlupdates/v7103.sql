ALTER TABLE `orders` ADD COLUMN `discount` INT DEFAULT 0 AFTER `grand_total`;
ALTER TABLE `orders` ADD COLUMN `advanced` INT DEFAULT 0 AFTER `discount`;
ALTER TABLE `orders` ADD COLUMN `payment_method` VARCHAR (25) DEFAULT '' AFTER `advanced`;
ALTER TABLE `orders` ADD COLUMN `booked_at` TIMESTAMP DEFAULT NULL AFTER `updated_at`;

COMMIT;