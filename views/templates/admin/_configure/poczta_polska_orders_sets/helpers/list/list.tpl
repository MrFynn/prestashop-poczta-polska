<div class="panel">
    <div class="productTabs">
        <ul class="tab nav nav-tabs">
            <li class="tab-row {if $smarty.get.controller=='AdminPocztaPolskaOrders'} active{/if}">
                <a class="tab-page" id="pp_link_orders" href="{$link->getAdminLink('AdminPocztaPolskaOrders',true)|escape:'html'}"><i class="icon-info"></i> {l s='Zamówienia'}</a>
            </li>
            <li class="tab-row {if $smarty.get.controller=='AdminPocztaPolskaOrdersSets'} active{/if}">
                <a class="tab-page" id="pp_link_sets" href="{$link->getAdminLink('AdminPocztaPolskaOrdersSets',true)|escape:'html'}"><i class="icon-random"></i> {l s='Zbiory'}</a>
            </li>
        </ul>
    </div>
    {$header}
    {$content}
    {$footer}
</div>
