{*
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
*  @author     PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2015 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

{extends file="helpers/form/form.tpl"}

{block name="input"}
	{$smarty.block.parent}
{/block}

{block name="other_fieldsets"}
	{if isset($id_contrat) }

	<!-- products -->
	<div class="panel">
		<h3><i class="icon-archive"></i> PRODUITS</h3>

		<div class="form-horizontal">
			<div class="col-lg-1"><span class="pull-right"></span></div>
			<label class="control-label col-lg-2" for="opart_devis_product_autocomplete_input">
				Produit à ajouter :
			</label>
			<div class="col-lg-3">
				<p class="help-block">Commencez à taper les premières lettres du nom du produit, puis sélectionner le produit dans la liste.'</p>

				<div class="input-group">
					<input type="text" id="contrat_product_autocomplete_input" name="contrat_product_autocomplete_input" autocomplete="off" class="ac_input" />
					<span class="input-group-addon"><i class="icon-search"></i></span>
				</div>

			</div>
			<div class="col-lg-1">
				<p class="help-block"> - OU - </p>
			</div>
			<div class="col-lg-3">
				<p class="help-block">Saisissez directement l'id du produit</p>
				<div>
					<span id="contrat_product_name_text"></span>
					Id : <input type="text" id="contrat_product_id_input" name="contrat_product_qte_input" />
					Quantité <input type="text" id="contrat_product_qte_input" name="contrat_product_qte_input" />
				</div>
				<br/>
				<input id="add_new_contrat_ligne_button" type="button" value ="ajouter le produit au contrat">
			</div>
			<div style="clear:both; height:20px;"></div>
			<div id="load" style="display:none;" class="text-danger"><i class="icon-spinner icon-spin icon-large text-danger"></i> Page en cours de chargement... Merci de patienter</div>
			<div class="col-lg-1"><span class="pull-right"></span></div>
			<label class="control-label col-lg-2" for="opart_devis_product_autocomplete_input">
				Produits du contrat :
			</label>
			<div class="col-lg-7">
				<table class="table" id="opartDevisProdList">
					<tr>
						<th style="width:5%">ID</th>
						<th>Nom</th>
						<th style="width:10%">Quantité</th>
						<th style="width:5%">&nbsp;</th>
						<th></th>
					</tr>
					{foreach from=$lignes item=cl}
						<tr id="id_{$cl['id_contrat_ligne']}">
							<td>{$cl['id_produit']}</td>
							<td>{$cl['name']}</td>
							<td><input id="update_contrat_ligne_input_{$cl['id_contrat_ligne']}" type="text" value="{$cl['quantite']}" ></td>
							<td>
								<a href="#" class="update_contrat_ligne_input"  data-id="{$cl['id_contrat_ligne']}" ><i class="icon-save"></i></a>
								&nbsp;
								<a href="#" class="delete_contrat_ligne_input"  data-id="{$cl['id_contrat_ligne']}" ><i class="icon-trash"></i></a></td>
							<td><span id="load_save_{$cl['id_contrat_ligne']}" class="load_save" ><i class="icon-spinner icon-spin icon-large"></i></span></td>
						</tr>
					{/foreach}
				</table>
			</div>
			<div style="clear:both;"></div>
		</div>
	</div>

	{/if}
{/block}

{block name="script"}
	{if isset($id_contrat) }
		var contrat_token = '{$contrat_token|escape:'htmlall':'UTF-8'}';
		var id_contrat = '{$id_contrat|escape:'htmlall':'UTF-8'}';
	{/if}
{/block}