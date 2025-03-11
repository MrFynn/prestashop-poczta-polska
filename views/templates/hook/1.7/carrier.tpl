<div style="width:100%;border:2px solid #D52B1E;padding:10px;text-align:center;margin-bottom:20px;">
    <div class="pp_pickup_at_point_{if $isCod}cod{else}standard{/if}">
        <button type="button" class="btn btn-default" onclick="PPWidgetApp.toggleMap({literal}{{/literal}callback: {if $isCod}selectPointCod{else}selectPoint{/if}, payOnPickup: {if $isCod}true{else}false{/if}, payOnPickupMax: prestashop.cart.totals.total.amount,address: address, type:{$types}{literal}}{/literal});checkRadioCarrier($(this));">{l s='Wybierz z mapy' mod='pocztapolskaen'}</button>
        <div class="pickup_info{if $isCod}_cod{/if}" style="font-weight:bold;padding:10px 0px">{$deliveryPointInfo}</div>
        <input type="hidden" id="{if $isCod}pp_pni_pickup_cod{else}pp_pni_pickup{/if}" value="{$deliveryPoint}">
    </div>
</div>
