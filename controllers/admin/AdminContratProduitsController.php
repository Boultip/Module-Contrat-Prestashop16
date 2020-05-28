<?php
/**
* 2007-2015 PrestaShop
*
* NOTICE OF LICENSE
*
* This source file is subject to the Academic Free License (AFL 3.0)
* that is bundled with this package in the file LICENSE.txt.
* It is also available through the world-wide-web at this URL:
* http://opensource.org/licenses/afl-3.0.php
* If you did not receive a copy of the license and are unable to
* obtain it through the world-wide-web, please send an email
* to license@prestashop.com so we can send you a copy immediately.
*
* DISCLAIMER
*
* Do not edit or add to this file if you wish to upgrade PrestaShop to newer
* versions in the future. If you wish to customize PrestaShop for your
* needs please refer to http://www.prestashop.com for more information.
*
*  @author    PrestaShop SA <contact@prestashop.com>
*  @copyright 2007-2015 PrestaShop SA
*  @license   http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*/

/**
 * Tab Example - Controller Admin Example
 *
 * @category   	Module / checkout
 * @author     	PrestaEdit <j.danse@prestaedit.com>
 * @copyright  	2012 PrestaEdit
 * @version   	1.0
 * @link       	http://www.prestaedit.com/
 * @since      	File available since Release 1.0
*/

class AdminContratProduitsController extends ModuleAdminController
{

    public function __construct()
    {
        $this->bootstrap = true;

        $this->context = Context::getContext();

        $this->fields_options = array(
            'general' => array(
                'title' => $this->l('Produits suggérés'),
                'fields' => array(
                    'MOD_CONTRAT_PRODUIT_1' => array(
                        'title' => $this->l('Produit #1'),
                        'type' => 'text',
                        'size' => '4',
                        'cast' => 'intval',
                        'suffix' => $this->getProduit((int) Configuration::get('MOD_CONTRAT_PRODUIT_1'))
                    ),
                    'MOD_CONTRAT_PRODUIT_2' => array(
                        'title' => $this->l('Produit #2'),
                        'type' => 'text',
                        'size' => '4',
                        'cast' => 'intval',
                        'suffix' => $this->getProduit((int) Configuration::get('MOD_CONTRAT_PRODUIT_2'))
                    ),
                    'MOD_CONTRAT_PRODUIT_3' => array(
                        'title' => $this->l('Produit #3'),
                        'type' => 'text',
                        'size' => '4',
                        'cast' => 'intval',
                        'suffix' => $this->getProduit((int) Configuration::get('MOD_CONTRAT_PRODUIT_3'))
                    ),
                    'MOD_CONTRAT_PRODUIT_4' => array(
                        'title' => $this->l('Produit #4'),
                        'type' => 'text',
                        'size' => '4',
                        'cast' => 'intval',
                        'suffix' => $this->getProduit((int) Configuration::get('MOD_CONTRAT_PRODUIT_4'))
                    ),
                    'MOD_CONTRAT_PRODUIT_5' => array(
                        'title' => $this->l('Produit #5'),
                        'type' => 'text',
                        'size' => '4',
                        'cast' => 'intval',
                        'suffix' => $this->getProduit((int) Configuration::get('MOD_CONTRAT_PRODUIT_5'))
                    )
                ),
                'submit' => array('title' => $this->l('Save'))
            )
        );


        $token = Tools::getAdminTokenLite('AdminContrat');
        $this->context->smarty->assign(array(
            'contrat_token' => $token));
        parent::__construct();

    /*   $this->context->controller->registerJavascript('contrat', 'modules/contrat/views/js/admin_produits.js', array(
            'position' => 'bottom',
            'priority' => 150
        ));*/


    }

    public function setMedia()
    {
        parent::setMedia();

        $this->addJqueryPlugin(array('autocomplete'));
        // $this->addJS(_MODULE_DIR_ . '/contrats/views/js/admin_produits.js');

    }

    protected function getProduit($id_produit){

        if($id_produit == 0){
            return '';
        }else{
            $sql = 'SELECT pl.name FROM `' . _DB_PREFIX_ . 'product_lang` pl ';
            $sql .= ' WHERE pl.id_lang = 1 AND `id_product` = '.(int)$id_produit;

            $res = Db::getInstance()->executeS($sql);

            if(isset($res[0]['name'])){
                return $res[0]['name'];
            }else{
                return "Ce produit n'existe pas";
            }

        }


    }




}
