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

{extends file="helpers/options/options.tpl"}

{block name="defaultOptions"}
	<script langauge="text/javascript">
		var contrat_token = '{$contrat_token|escape:'htmlall':'UTF-8'}';
	</script>
	<script type="text/javascript" src="/modules/contrats/views/js/admin_produits.js"></script>

	<div class="panel" >
		<div class="panel-heading">
			<i class="icon-search"></i>
			Trouver un id produit
		</div>
		<div class="well clearfix">

			<div class="col-lg-6">
				<p class="help-block">Commencez à taper les premières lettres du nom du produit, puis sélectionner le produit dans la liste.'</p>
				<div class="input-group">
					<input type="text" id="contrat_product_autocomplete_input" name="contrat_product_autocomplete_input" autocomplete="off" class="ac_input" />
					<span class="input-group-addon"><i class="icon-search"></i></span>
				</div>
			</div>
			<div class="col-lg-12">
				<div><br/><span id="load_search" class="load_search" ><i class="icon-spinner icon-spin icon-large"></i></span>
					Nom : <span id="contrat_product_name_text"></span> <br/>
					Id : <strong><span id="contrat_product_id_input" ></span></strong>
				</div>
			</div>
		</div>
	</div>
	{$smarty.block.parent}
{/block}

{block name="input"}
	{if $field['type'] == 'text'}
		<div class="col-lg-1">
			<input class="form-control {if isset($field['class'])}{$field['class']}{/if}" type="{$field['type']}"{if isset($field['id'])} id="{$field['id']}"{/if} size="{if isset($field['size'])}{$field['size']|intval}{else}5{/if}" name="{$key}" value="{if isset($field['no_escape']) && $field['no_escape']}{$field['value']|escape:'UTF-8'}{else}{$field['value']|escape:'html':'UTF-8'}{/if}" {if isset($field['autocomplete']) && !$field['autocomplete']}autocomplete="off"{/if}/>
		</div>
		<div class="col-lg-6">
			{if isset($field['suffix'])}
				<span>
					{$field['suffix']|strval}
				</span>
			{/if}
		</div>
	{/if}
{/block}