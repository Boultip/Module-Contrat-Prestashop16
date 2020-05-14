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

/* Init */
$sql = array();

/* Create Table in Database */
$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'contrat` (
	`id_contrat` int(10) NOT NULL AUTO_INCREMENT,
	`id_client` int(10) NOT NULL,
	`periode` int(10) NOT NULL,
	`date_last_cmd` DATE NULL,
	`date_next_cmd` DATE NULL,
	PRIMARY KEY (`id_contrat`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';

$sql[] = 'CREATE TABLE IF NOT EXISTS `'._DB_PREFIX_.'contrat_ligne` (
	`id_contrat_ligne` int(10) NOT NULL AUTO_INCREMENT,
	`id_contrat` int(10) NOT NULL,
	`id_produit` int(10) NOT NULL,
	`quantite` int(10) NOT NULL,
	PRIMARY KEY (`id_contrat_ligne`)
) ENGINE='._MYSQL_ENGINE_.' DEFAULT CHARSET=utf8';