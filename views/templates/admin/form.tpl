<div class="panel">
	<h3><i class="icon-tag"></i> {l s='Ustawienia'}</h3>
	<div class="productTabs">
		<ul class="tab nav nav-tabs">
			<li class="tab-row">
				<a class="tab-page" id="pp_link_settings" href="javascript:displayTab('settings');"> {l s='Moje konto'}</a>
			</li>
			<li class="tab-row">
				<a class="tab-page" id="pp_link_statuses" href="javascript:displayTab('statuses');"> {l s='Statusy'}</a>
			</li>
			<li class="tab-row">
				<a class="tab-page" id="pp_link_delivery" href="javascript:displayTab('delivery');"> {l s='Dostawa'}</a>
			</li>
		</ul>
	</div>
    <form action="" id="cart_rule_form" class="form-horizontal" method="post">
        <input type="hidden" id="currentFormTab" name="currentFormTab" value="informations" />
        <div id="pp_settings" class="panel pp_tab">
            {include file='./settings.tpl'}
        </div>
        <div id="pp_statuses" class="panel pp_tab">
            {include file='./statuses.tpl'}
        </div>
        <div id="pp_delivery" class="panel pp_tab">
            {include file='./delivery.tpl'}
        </div>

    </form>

    <script type="text/javascript">
        {*var currentToken = '{$currentToken|escape:'quotes'}';*}
        var currentFormTab = '{if isset($smarty.post.currentFormTab)}{$smarty.post.currentFormTab|escape:'quotes'}{else}settings{/if}';

    </script>
    <script type="text/javascript" src="{$module_dir|escape:'htmlall':'UTF-8'}/views/templates/admin/js/settings.js"></script>
</div>
