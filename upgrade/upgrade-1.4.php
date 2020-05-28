<?php
if (!defined('_PS_VERSION_'))
	exit;

function upgrade_module_1_4($module)
{

    $id_tab = Tab::getIdFromClassName('AdminMainContrat');
    $tab = new Tab();
    // Need a foreach for the language
    $context = Context::getContext();
    $tab->name[$context->language->id] = 'Produits suggérés';
    $tab->class_name = 'AdminContratProduits';
    $tab->id_parent = $id_tab;
    $tab->module = 'contrats';
    $tab->add();

    return $module;
}