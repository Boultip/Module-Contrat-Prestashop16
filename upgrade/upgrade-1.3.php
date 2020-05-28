<?php
if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_3($module)
{

    Configuration::deleteByName('MOD_CONTRATs_PRODUITS');
    Configuration::updateValue('MOD_CONTRATS_PRODUITS', '0|0|0|0|0');

    return $module;
}