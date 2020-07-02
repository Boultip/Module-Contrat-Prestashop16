<?php
if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_6($module)
{

    if (Db::getInstance()->ExecuteS('SHOW COLUMNS FROM `'._DB_PREFIX_.'contrat` LIKE \'client_can_edit\'') == false)
        Db::getInstance()->Execute('ALTER TABLE `'._DB_PREFIX_.'contrat` ADD `client_can_edit` int(1) DEFAULT 0 AFTER `id_client`');

    return $module;
}