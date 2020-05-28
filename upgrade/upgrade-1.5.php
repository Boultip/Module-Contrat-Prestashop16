<?php
if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_5($module)
{

    Configuration::deleteByName('MOD_CONTRATS_PRODUITS');
    Configuration::updateValue('MOD_CONTRAT_PRODUIT_1', '0');
    Configuration::updateValue('MOD_CONTRAT_PRODUIT_2', '0');
    Configuration::updateValue('MOD_CONTRAT_PRODUIT_3', '0');
    Configuration::updateValue('MOD_CONTRAT_PRODUIT_4', '0');
    Configuration::updateValue('MOD_CONTRAT_PRODUIT_5', '0');

    return $module;
}