{**
* @category Prestashop
* @category Module
* @author Marie Diallo
**}
<div class="content">
	<div class="row">
		<section id="center_column" class="span12">		
			{capture name=path}<a href="{$link->getPageLink('my-account', true)|escape:'htmlall':'UTF-8'}">{l s='Mon compte' mod='contrats'}</a><span class="navigation-pipe">{$navigationPipe|escape:'javascript':'UTF-8'}</span>{l s='Contrats' mod='contrats'}{/capture}
			{include file="$tpl_dir./errors.tpl"}
			
			<h1>{l s='Mes contrats' mod='contrats'}</h1>
			{if isset($deleted) && $deleted=="success"}
				<div class="alert alert-success">{l s='Quote deleted' mod='opartdevis'}</div>
			{/if}
            <p><input id="dateLimite" type="hidden" value="{$dateLimite}"/></p>
			<div class="block-center" id="block-history">
				{if $contrats && count($contrats)}
                    <table id="order-list" class="std">
                        <thead>
                            <tr>
                                <th class="item">ID</th>
                                <th class="item">Libellé</th>
                                <th class="item">Produits</th>
                                <th class="item">Périodicité</th>
                                <th class="item">Date de dernière commande</th>
                                <th class="last_item">Date de prochaine commande</th>
                            </tr>
                        </thead>
                        <tbody>
                        {foreach from=$contrats item=contrat name=myLoop}
                            <ul class="{if $smarty.foreach.myLoop.first}first_item{elseif $smarty.foreach.myLoop.last}last_item{else}item{/if} {if $smarty.foreach.myLoop.index % 2}alternate_item{/if}">
                                <td class="history_method">{$contrat.id_contrat|escape:'htmlall':'UTF-8'}</td>
                                <td class="history_method">{$contrat.libelle|escape:'htmlall':'UTF-8'}</td>
                                <td>
                                    {foreach from=$contrat['lignes'] item=cl}
                                        <ul>
                                            <li>{$cl['id_produit']} - {$cl['name']} [Qté : {$cl['quantite']}]</li>
                                        </ul>
                                    {/foreach}
                                </td>
                                  <td class="history_method">{$contrat.periode|escape:'htmlall':'UTF-8'} semaines</td>
                                <td class="history_method">{dateFormat date=$contrat.date_last_cmd full=0}</td>
                                <td class="history_method">
                                    {if $contrat.editable}
                                        <input type="date" value="{$contrat.date_next_cmd}"  id="update_contrat_next_date_{$contrat.id_contrat|escape:'htmlall':'UTF-8'}" min="{$dateLimite}" style="width:100px" required/><span class="validity"></span>
                                        <a data-id="{$contrat.id_contrat|escape:'htmlall':'UTF-8'}" href="#" class="btn btn-default button button-small update_date_next_cmd">
                                            <span>Modifier la date<i class="icon-chevron-right right"></i></span>
                                        </a><br/>
                                        <span class="load_save" id="load_save_{$contrat.id_contrat|escape:'htmlall':'UTF-8'}" class="text-warning"><i class="icon-spinner icon-spin icon-large"></i> Données en cours d'enregistrement...</span>
                                    {else}
                                        {dateFormat date=$contrat.date_next_cmd full=0}
                                    {/if}
                                </td>
                              </tr>
                        {/foreach}
                        </tbody>
                    </table>
				{else}
					<p class="warning">{l s='Vous n\'avez pas de contrat' mod='contrats'}</p>
				{/if}
			</div>
			<ul class="footer_links clearfix">
				<li>
					<a href="{$link->getPageLink('my-account', true)|escape:'htmlall':'UTF-8'}" class="btn btn-default button button-small">
						<span><i class="icon-chevron-left"></i> {l s='Retour à votre compte' mod='contrats'}</span>
					</a>
				</li>
				<li class="f_right">
					<a href="{$base_dir|escape:'htmlall':'UTF-8'}" class="btn btn-default button button-small">
						<span><i class="icon-chevron-left"></i> {l s='Accueil' mod='contrats'}</span>
					</a>
				</li>
			</ul>
		</section>
	</div>
</div>