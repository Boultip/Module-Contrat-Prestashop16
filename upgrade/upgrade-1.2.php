<?php
if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_2($module)
{
	if (Db::getInstance()->ExecuteS('SHOW COLUMNS FROM `'._DB_PREFIX_.'contrat` LIKE \'libelle\'') == false)
		Db::getInstance()->Execute('ALTER TABLE `'._DB_PREFIX_.'contrat` ADD `libelle` varchar(255) NULL AFTER `id_contrat`');

    if (Db::getInstance()->ExecuteS('SHOW COLUMNS FROM `'._DB_PREFIX_.'contrat` LIKE \'id_address_delivery\'') == false)
        Db::getInstance()->Execute('ALTER TABLE `'._DB_PREFIX_.'contrat` ADD `id_address_delivery` int(10) NULL AFTER `id_client`');

    if (Db::getInstance()->ExecuteS('SHOW COLUMNS FROM `'._DB_PREFIX_.'contrat` LIKE \'id_address_invoice\'') == false)
        Db::getInstance()->Execute('ALTER TABLE `'._DB_PREFIX_.'contrat` ADD `id_address_invoice` int(10) NULL AFTER `id_address_delivery`');

    if (Db::getInstance()->ExecuteS('SHOW COLUMNS FROM `'._DB_PREFIX_.'contrat` LIKE \'payment_method\'') == false)
        Db::getInstance()->Execute('ALTER TABLE `'._DB_PREFIX_.'contrat` ADD `payment_method` VARCHAR(255) DEFAULT \'Paiement sur facture\' AFTER `id_address_invoice`');

    if (Db::getInstance()->ExecuteS('SHOW COLUMNS FROM `'._DB_PREFIX_.'contrat` LIKE \'modif_client\'') == false)
        Db::getInstance()->Execute('ALTER TABLE `'._DB_PREFIX_.'contrat` ADD `modif_client` int(1) DEFAULT 0 AFTER `date_next_cmd`');

    Configuration::updateValue('MOD_CONTRATs_PRODUITS', '0|0|0|0|0');

    return $module;
}