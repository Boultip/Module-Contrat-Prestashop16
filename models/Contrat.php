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

class Contrat extends ObjectModel
{
	/** @var string Name */
	public $id_contrat;
	public $id_client;
	public $periode;
	public $date_last_cmd;
	public $date_next_cmd;

	/**
	 * @see ObjectModel::$definition
	 */
	public static $definition = array(
		'table' => 'contrat',
		'primary' => 'id_contrat',
		'multilang' => false,
		'fields' => array(
            'id_contrat' => array('type' => self::TYPE_INT,'validate' => 'isNullOrUnsignedId'),
            'id_client' => array('type' => self::TYPE_INT, 'validate' => 'isNullOrUnsignedId'),
            'periode' => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
            'date_last_cmd' => array('type' => self::TYPE_DATE, 'valide' => 'isDate', 'required' => true),
            'date_next_cmd' => array('type' => self::TYPE_DATE, 'valide' => 'isDate', 'required' => false)
        ),
	);

    public function getLigneContrat()
    {
        $sql = 'SELECT cl.*,pl.name FROM `'._DB_PREFIX_.'contrat_ligne` cl ';
        $sql .= 'LEFT JOIN `' . _DB_PREFIX_ . 'product_lang` pl ON (pl.id_product = cl.id_produit AND pl.id_lang = 1)';
        $sql .= ' WHERE `id_contrat` = '.(int)$this->id_contrat;

        $res = Db::getInstance()->executeS($sql);
        return $res;
    }
}
