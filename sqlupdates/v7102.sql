ALTER TABLE `carts` ADD `destination` JSON NULL AFTER `address_id`;

COMMIT;