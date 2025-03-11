{include file="./modal_content.tpl"}

<div class="checkbox">
    <label class="required" for="pp_process_data_rodo_modal"><input type="checkbox" name="pp_process_data_rodo_modal" id="pp_process_data_rodo_modal" value="1">{l s='Wyrażam zgodę na przetwarzanie moich danych osobowych w zakresie i w sposób określony w pkt II.' mod='pocztapolskaen'}</label>
</div>
<div class="checkbox">
    <label for="pp_process_information_rodo_modal"><input type="checkbox" name="pp_process_information_rodo_modal" id="pp_process_information_rodo_modal" value="1"">{l s='Wyrażam zgodę na otrzymywanie powiadomień o nowych wersjach oprogramowania na mój adres e-mail. ' mod='pocztapolskaen'}</label>
</div>
<div style="margin-left:10px;margin-top: 1px;margin-bottom:1px;">{l s='Pełna informacja na temat przetwarzania danych osobowych przez Pocztę Polską:' mod='pocztapolskaen'} <a href="http://bip.poczta-polska.pl/iinformacja-o-zbieraniu-danych-osobowych/">http://bip.poczta-polska.pl/iinformacja-o-zbieraniu-danych-osobowych/</a></div>

    <div class="row">
        <div class="col-md-3 col-lg-offset-4">
            <div class="form-group">
                <button id="pocztapolskaen_login_button" class="btn btn-primary btn-block btn-sm" type="submit">
                    <i class="icon-unlock"></i> {l s='Przejdź do logowania' mod='pocztapolskaen'}
                </button>
            </div>
        </div>
    </div>

<script type="text/javascript">
var error_continue_msg = '{l s='OK' js=1}';
</script>
