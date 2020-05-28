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
require_once _PS_MODULE_DIR_ . 'contrats/models/Contrat.php';
require_once _PS_MODULE_DIR_ . 'contrats/models/ContratLigne.php';

class AdminContratController extends ModuleAdminController
{
	public function __construct()
	{
		$this->table = 'contrat';
		$this->className = 'Contrat';
        $this->table = 'contrat';
        $this->identifier = 'id_contrat';
        $this->bootstrap = true;
		$this->lang = false;
		$this->deleted = false;
		$this->colorOnBackground = false;
		$this->bulk_actions = array('delete' => array('text' => $this->l('Delete selected'), 'confirm' => $this->l('Delete selected items?')));
		$this->context = Context::getContext();

        $this->_select = 'a.`id_client`, CONCAT(b.`firstname`, \' \', b.`lastname`) AS `client`';

        $this->_join = 'LEFT JOIN `'._DB_PREFIX_.'customer` b ON (b.`id_customer` = a.`id_client`)';
       // $this->addJS(_MODULE_DIR_ . $this->name . '/views/js/contrat.js');
		parent::__construct();
	}

	/**
	 * Function used to render the list to display for this controller
	 */
	public function renderList()
	{
		$this->addRowAction('edit');
		$this->addRowAction('delete');
	//	$this->addRowAction('details');

		$this->bulk_actions = array(
			'delete' => array(
				'text' => $this->l('Delete selected'),
				'confirm' => $this->l('Delete selected items?')
				)
			);

		$this->fields_list = array(
			'id_contrat' => array(
				'title' => $this->l('Id'),
				'align' => 'center',
				'width' => 25
			),
            'libelle' => array(
                'title' => $this->l('Libellé'),
                'width' => 'auto',
            ),
			'client' => array(
				'title' => $this->l('Client'),
				'width' => 'auto',
			),
            'periode' => array(
                'title' => $this->l('Périodicité (Nb semaines)'),
                'width' => 'auto',
                'suffix' => ' semaines',
            ),
            'date_last_cmd' => array(
                'title' => $this->l('Date dernière commande'),
                'filter_key' => 'a!date_last_cmd',
                'align' => 'text-center',
                'type' => 'date',
            ),
            'date_next_cmd' => array(
                'title' => $this->l('Date prochaine commande'),
                'filter_key' => 'a!date_next_cmd',
                'filter_key' => 'a!date_next_cmd',
                'align' => 'text-center',
                'type' => 'date',
            ),
            'modif_client' => array(
                'title' => $this->l('Date modifiée par client'),
                'align' => 'text-center',
                'type' => 'bool',
                'active' => 'modif_client'

            ),
		);
        $this->toolbar_title = $this->module->l('Liste des contrats');

        $lists = parent::renderList();

		parent::initToolbar();

		return $lists;
	}


    public function initPageHeaderToolbar()
    {
        parent::initPageHeaderToolbar();
        switch ($this->display) {
            case '':
                $this->page_header_toolbar_btn['new_account_manager'] = array(
                    'href' => self::$currentIndex.'&addcontrat&token='.$this->token,
                    'desc' => $this->module->l('Créer un nouveau contrat'),
                    'icon' => 'process-icon-new');
                break;
            case 'add':
                break;
            case 'edit':
                break;
        }
    }

    public function initToolbar()
    {
        switch ($this->display) {
            case '':
                $this->toolbar_btn['new'] = array(
                    'href' => self::$currentIndex.'&addcontrat&token='.$this->token,
                    'desc' => $this->module->l('Add an account manager')
                );

                $this->toolbar_btn['export'] = array(
                    'href' => self::$currentIndex.'&export'.$this->table.'&token='.$this->token,
                    'desc' => $this->module->l('Export')
                );

                break;
            case 'add':
                $back = self::$currentIndex.'&token='.$this->token;
                $this->toolbar_btn['back'] = array(
                    'href' => $back,
                    'desc' => $this->module->l('Back to the list')
                );
                break;
            case 'edit':
                $back = self::$currentIndex.'&token='.$this->token;
                $this->toolbar_btn['back'] = array(
                    'href' => $back,
                    'desc' => $this->module->l('Back to the list')
                );
                break;
        }
    }

    public function initToolbarTitle()
    {
        $bread_extended = $this->breadcrumbs;
        switch ($this->display) {
            case '':
                $bread_extended[] = $this->module->l('Gestion des contrats');
                break;
            case 'add':
                $bread_extended[] = $this->module->l('Nouveau contrat');
                $this->addMetaTitle($bread_extended[count($bread_extended) - 1]);
                break;
            case 'edit':
                $bread_extended[] = $this->module->l('Edition de contrat');
                $this->addMetaTitle($bread_extended[count($bread_extended) - 1]);
                break;
        }
        $this->toolbar_title = $bread_extended;
    }

    public function initContent()
    {
        $this->initPageHeaderToolbar();
        $this->initToolbar();
        if (Tools::isSubmit('submitUpdatecontrat')) {
            $this->display = 'edit';
        }
        switch ($this->display) {
            case '':

                $this->content .= $this->renderList();
                break;
            case 'add':

                $this->content .= $this->renderFormAdd();
                break;
            case 'edit':

                $this->content .= $this->renderFormEdit();
                break;
        }

        $this->context->smarty->assign(array(
            'content' => $this->content,
            'url_post' => self::$currentIndex.'&token='.$this->token,
            'show_page_header_toolbar' => $this->show_page_header_toolbar,
            'page_header_toolbar_title' => $this->page_header_toolbar_title,
            'page_header_toolbar_btn' => $this->page_header_toolbar_btn
        ));
    }

    public function renderFormAdd()
    {
       $this->fields_form = array(
            'legend' => array(
                'title' => $this->module->l('Créer un contrat')
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Libellé'),
                    'name' => 'libelle',
                    'required' => true,
                    'col' => 3
                ),
                array(
                    'type' => 'select',
                    'label' => $this->module->l('Select a customer'),
                    'name' => 'id_client',
                    'required' => true,
                    'options' => array(
                        'query' => $this->availableCustomers(),
                        'id' => 'id_customer',
                        'name' => 'name'
                    )
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Périodicité'),
                    'name' => 'periode',
                    'required' => true,
                    'col' => 1,
                    ['suffix'] => 'semaines'
                ),
                array(
                    'type' => 'date',
                    'label' => $this->l('Date dernière commande'),
                    'name' => 'date_last_cmd',
                    'required' => true,
                    'col' => 3
                ),
                array(
                    'type' => 'date',
                    'label' => $this->l('Date prochaine commande'),
                    'name' => 'date_next_cmd',
                    'required' => true,
                    'col' => 3,
                ),
                array(
                    'type' => 'select',
                    'label' => 'Moyens de paiement',
                    'name' => 'payment_method',
                    'class' => 'col-lg-6',
                    'col' => 5,
                    'options' => array(
                        'query' => $this->availablePaymentMethods(),
                        'id' => 'id',
                        'name' => 'name'
                    )
                ),
            ),
            'submit' => array(
                'title' => $this->module->l('Enregistrer et Quitter'),
                'class' => 'btn btn-default pull-right'
            ),
           'buttons' => array(
               'save-and-stay' => array(
                   'title' => $this->module->l('Enregistrer'),
                   'name' => 'submitAdd'.$this->table.'AndStay',
                   'type' => 'submit',
                   'class' => 'btn btn-default pull-right',
                   'icon' => 'process-icon-save'
               )
           )
        );

        $this->show_form_cancel_button = true;

        return parent::renderForm();
    }

    public function renderFormEdit()
    {
        $id_contrat = (int)Tools::safeOutput(Tools::getValue('id_contrat'));
        $contrat = new Contrat($id_contrat);
        $client = new Customer((int)$contrat->id_client);
        $client_name = $client->firstname.' '.$client->lastname;

            $this->fields_form = array(
                'legend' => array(
                    'title' => sprintf(
                        $this->module->l('Edition du contrat : %s'),
                        $client_name
                    )
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Libellé'),
                        'name' => 'libelle',
                        'required' => true,
                        'col' => '3'
                    ),
                    array(
                        'type' => 'select',
                        'label' => 'Client',
                        'name' => 'id_client',
                        'class' => 'col-lg-6',
                        'col' => '5',
                        'options' => array(
                            'query' => $this->availableCustomers(),
                            'id' => 'id_customer',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'text',
                        'col' => '1',
                        'label' => $this->l('Périodicité (en semaine)'),
                        'name' => 'periode',
                        'required' => true,
                    ),
                    array(
                        'type' => 'date',
                        'label' => $this->l('Date dernière commande'),
                        'name' => 'date_last_cmd',
                        'required' => true,
                        'col' => '3',
                    ),
                    array(
                        'type' => 'date',
                        'label' => $this->l('Date prochaine commande'),
                        'name' => 'date_next_cmd',
                        'required' => true,
                        'col' => '3'
                    ),
                    array(
                        'type' => 'select',
                        'label' => 'Adresse de facturation',
                        'name' => 'id_address_invoice',
                        'col' => '6',
                        'required' => true,
                        'options' => array(
                            'query' => $this->availableAddresses($contrat->id_client),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'label' => 'Adresse de livraison',
                        'name' => 'id_address_delivery',
                        'col' => '6',
                        'class' => 'large_select',
                        'required' => true,
                        'options' => array(
                            'query' => $this->availableAddresses($contrat->id_client),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),
                    array(
                        'type' => 'select',
                        'label' => 'Moyens de paiement',
                        'name' => 'payment_method',
                        'class' => 'col-lg-6',
                        'col' => '5',
                        'options' => array(
                            'query' => $this->availablePaymentMethods(),
                            'id' => 'id',
                            'name' => 'name'
                        )
                    ),

                ),
                'submit' => array(
                    'title' => $this->module->l('Enregistrer et Quitter'),
                    'class' => 'btn btn-default pull-right',
                    'name' => 'submitUpdatecontrat'
                ),
                'buttons' => array(
                    'save-and-stay' => array(
                        'title' => $this->module->l('Enregistrer'),
                        'name' => 'submitAdd'.$this->table.'AndStay',
                        'type' => 'submit',
                        'class' => 'btn btn-default pull-right',
                        'icon' => 'process-icon-save'
                    )
                )
            );

            $this->fields_value = array(
                'libelle'       => $contrat->libelle,
                'id_client'     => (int)$contrat->id_client,
                'id_address_delivery'     => (int)$contrat->id_address_delivery,
                'id_address_invoice'     => (int)$contrat->id_address_invoice,
                'payment_method'=> $contrat->payment_method,
                'periode'       => (int)$contrat->periode,
                'date_last_cmd' => displayDate($contrat->date_last_cmd,false),
                'date_next_cmd' => displayDate($contrat->date_next_cmd,false),
                'id_contrat' => (int)$contrat->id_contrat,
                'modif_client' => (int)$contrat->modif_client

            );

        $this->addJqueryPlugin(array('autocomplete'));
        $this->addJS(_MODULE_DIR_ . '/contrats/views/js/admin.js');
   //     if (!($obj = $this->loadObject(true)))
   //         return;
        $token = Tools::getAdminTokenLite('AdminContrat');
        $this->context->smarty->assign(array(
            'contrat_token' => $this->token,
            'id_contrat' => (int)$contrat->id_contrat,
            'lignes' => $contrat->getLigneContrat(),
            'id_address_delivery'     => (int)$contrat->id_address_delivery,
            'id_address_invoice'     => (int)$contrat->id_address_invoice
           /* 'json_carrier_list' => (isset($cart)) ? $obj->createCarrierList($cart) : '[]',*/
        ));

        return parent::renderForm();
    }



	/*public function postProcess()
	{
		if (Tools::isSubmit('submitAdd'.$this->table)  || Tools::isSubmit('submitUpdate'.$this->table))
		{
            parent::postProcess();
		}
	}*/
    public function postProcess()
    {
        if (Tools::getIsset('ajax_product_list')) {
            $query = Tools::getValue('q', false);
            $context = Context::getContext();
            $sql = 'SELECT p.`id_product`, pl.`link_rewrite`, p.`reference`, p.`price`, pl.`name`
                        FROM `' . _DB_PREFIX_ . 'product` p
                        LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (pl.id_product = p.id_product AND pl.id_lang = ' . (int)Context::getContext()->language->id . ')
                        WHERE (pl.name LIKE \'%' . pSQL($query) . '%\' OR p.reference LIKE \'%' . pSQL($query) . '%\') GROUP BY p.id_product';

            $prod_list = Db::getInstance()->executeS($sql);

            $context = Context::getContext();
            foreach ($prod_list as $prod) {
                $prod['name'] = $prod['name'] . ' [' . $prod['reference'] . ']';
                echo trim($prod['id_product']) . '|' . trim($prod['name']) . "\n";

            }
            die();
        }

        if (Tools::getIsset('ajax_add_contrat_ligne')) {

            $contrat_ligne = new ContratLigne();
            $contrat_ligne->id_contrat = Tools::getValue('id_contrat');
            $contrat_ligne->id_produit = Tools::getValue('id_produit');
            $contrat_ligne->quantite   = Tools::getValue('qte');

            $contrat_ligne->save();

            die();
        }

        if (Tools::getIsset('ajax_update_contrat_ligne')) {

            $contrat_ligne = new ContratLigne(Tools::getValue('id_contrat_ligne'));
            $contrat_ligne->quantite = Tools::getValue('qte');

            $contrat_ligne->update();

            die();
        }

        if (Tools::getIsset('ajax_delete_contrat_ligne')) {

            $contrat_ligne = new ContratLigne(Tools::getValue('id_contrat_ligne'));

            $contrat_ligne->delete();

            die();
        }

        parent::postProcess();
    }

    protected function availableCustomers()
    {
        $sql = 'SELECT `id_customer`, `email`, `firstname`, `lastname`
				FROM `'._DB_PREFIX_.'customer`
				WHERE 1 '.Shop::addSqlRestriction(Shop::SHARE_CUSTOMER).'
				ORDER BY `lastname` ASC';
        $customers = Db::getInstance(_PS_USE_SQL_SLAVE_)->executeS($sql);

        $customer_list = array();
        if (!empty($customers)) {
            foreach ($customers as $customer) {
              /*  if (!in_array($customer['id_customer'], $ids_customer)) {*/
                    $id = (int)$customer['id_customer'];
                    $name = $customer['lastname'].' '.$customer['firstname'].' (Id='.$id.')';
                    $customer_list[] = array(
                        'id_customer' => (int)$id,
                        'name' => $name
                    );
              /*  }*/
            }
        }
        return !empty($customer_list) ? $customer_list : false;
    }

    protected function availablePaymentMethods(){
        $payment_methods = array();
        foreach (PaymentModule::getInstalledPaymentModules() as $payment) {
            $module = Module::getInstanceByName($payment['name']);
            if (Validate::isLoadedObject($module) && $module->active) {
                $payment_methods[] = array('id' => $module->displayName, 'name' =>  $module->displayName);
            }
        }

        return array_reverse($payment_methods);
    }

    protected function availableAddresses($id_customer){

        $context = Context::getContext();

        $sql = 'SELECT  a.`alias`, a.`id_address`, a.`lastname`, a.`firstname`, a.`lastname`, a.`company`, 
			a.`address1`, a.`address2`, a.`postcode`, a.`city`,cl.`name` as `country_name`
			FROM `' . _DB_PREFIX_ . 'address` a 
			LEFT JOIN `' . _DB_PREFIX_ . 'country_lang` cl ON (a.`id_country`=cl.`id_country` AND cl.id_lang = ' . (int) $context->language->id . ')
			WHERE a.id_customer=' . (int) $id_customer;

        $result = array();
        $result[] = array('id' => '', 'name' => '');
        $address_list = Db::getInstance()->executeS($sql);
        if (count($address_list) > 0) {
            foreach ($address_list as $address) {
               // $result[$address['id_address']] = $address;
                $result[] = array('id' => $address['id_address'], 'name' => $address['alias'].' : '.$address['firstname'].' '.$address['lastname'].', '.$address['address1'].' '.$address['address2']. ', '.$address['postcode'].' '.$address['city']);
            }
        }
        return $result;
    }
}
