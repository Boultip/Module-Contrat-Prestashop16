<?php
if (!defined('_PS_VERSION_')) {
    exit;
}

class Contrats extends Module
{
    public function __construct()
    {
        $this->name = 'contrats';
        $this->tab = 'administration';
        $this->version = '1.5';
        $this->author = 'Marie Diallo';
        $this->need_instance = 0;
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => '1.6');
        $this->bootstrap = true;

        parent::__construct();

        $this->displayName = $this->l('Interface de gestion des contrats client');
        $this->description = $this->l('Ce module permet de gérer les contrats clients (commandes récurrentes)');

        $this->confirmUninstall = $this->l('Are you sure you want to uninstall?');

    }

    public function install()
    {
        // Install SQL
        $sql = array();
        include(dirname(__FILE__).'/sql/install.php');
        foreach ($sql as $s)
            if (!Db::getInstance()->execute($s))
                return false;

        // Install Tabs
        $parent_tab = new Tab();
        // Need a foreach for the language
        $parent_tab->name[$this->context->language->id] = $this->l('Gestion des contrats');
        $parent_tab->class_name = 'AdminMainContrat';
        $parent_tab->id_parent = 0; // Home tab
        $parent_tab->module = $this->name;
        $parent_tab->add();

        $tab = new Tab();
        // Need a foreach for the language
        $tab->name[$this->context->language->id] = $this->l('Contrats');
        $tab->class_name = 'AdminContrat';
        $tab->id_parent = $parent_tab->id;
        $tab->module = $this->name;
        $tab->add();

        if (!parent::install() ||
            !$this->registerHook('displayCustomerAccount') ||
            !$this->registerHook('header') ||
            !$this->registerHook('displayBackOfficeHeader') ) {
            return false;
        }

        return true;
    }

    public function uninstall()
    {
        // Uninstall SQL
        $sql = array();
        include(dirname(__FILE__).'/sql/uninstall.php');
       /* foreach ($sql as $s)
            if (!Db::getInstance()->execute($s))
                return false;*/

        // Uninstall Tabs
        $tab = new Tab((int)Tab::getIdFromClassName('AdminContrat'));
        $tab->delete();

        $tab_main = new Tab((int)Tab::getIdFromClassName('AdminMainContrat'));
        $tab_main->delete();

        if (!parent::uninstall()) {
            return false;
        }

        return true;
    }

    public function hookDisplayBackOfficeHeader()
    {
        $this->context->controller->addCss($this->_path.'views/css/admin.css');
    }

    public function hookHeader()
    {
        $this->context->controller->addJS(_MODULE_DIR_.'contrats/views/js/front.js');
        $this->context->controller->addCSS(_MODULE_DIR_.'contrats/views/css/front.css');

    }

    public function hookDisplayCustomerAccount()
    {

        $id_customer = $this->context->customer->id;
        $sql = 'SELECT * FROM `'._DB_PREFIX_.'contrat` WHERE id_client='.(int)$id_customer;
        $contrats = Db::getInstance()->executeS($sql);
        if (count($contrats) == 0) {
            return false;
        }

        return $this->display(__FILE__, 'views/templates/front/myaccount.tpl');

    }


}