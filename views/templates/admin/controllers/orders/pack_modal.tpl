{*
* 2007-2017 PrestaShop
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
*  @author PrestaShop SA <contact@prestashop.com>
*  @copyright  2007-2017 PrestaShop SA
*  @license    http://opensource.org/licenses/afl-3.0.php  Academic Free License (AFL 3.0)
*  International Registered Trademark & Property of PrestaShop SA
*}

<div class="modal fade" id="{$modal_id}" tabindex="-1">
    <div class="modal-dialog {if isset($modal_class)}{$modal_class}{/if}">
        <div class="modal-content">
            {if isset($modal_title)}
                <div class="modal-header">
                    <button type="button" class="close" data-dismiss="modal">&times;</button>
                    <h4 class="modal-title">{$modal_title} <span class="loader" style="display:none;"><i class="icon-refresh icon-spin"></i></span></h4>
                    <div class="row">
                        <div class="col-lg-9">
                            <h4 id="modal_order_info" class="modal-title"></h4>
                        </div>
                        <div class="col-lg-3">
                            <div class="alert alert-info" role="alert"  style="display:none">
                                {l s='Pozostało w kolejce'}: <span id="orders_counter"></span>
                            </div>
                        </div>
                    </div>
                    <div  class="alert alert-danger" style="display:none">
                        <button type="button" class="close" data-dismiss="alert">×</button>
                        <ol></ol>
                    </div>  
                </div>
            {/if}

            {$modal_content}

            {if isset($modal_actions)}
                <div class="modal-footer">
                    <button type="button" class="btn btn-default" data-dismiss="modal">{l s='Close'}</button>
                    {foreach $modal_actions as $action}
                        {if $action.type == 'link'}
                            <a href="{$action.href}" class="btn {$action.class}" data-label_one="{$action.label}"  data-label_multi="{l s='Następne zamówienie'}">{$action.label}</a>
                        {elseif $action.type == 'button'}
                            <button type="button" value="{$action.value}" class="btn {$action.class}">
                                {$action.label}
                            </button>
                        {/if}
                    {/foreach}
                </div>
            {/if}
        </div>
    </div>
</div>
<script type="text/javascript">
    $(document).ready(function () {
      ppPack.init('{$currentToken}');
    });
</script>


