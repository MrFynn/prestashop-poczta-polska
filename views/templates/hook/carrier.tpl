{if $ps16}
<div class="pp_pickup_at_point_standard" style="display: none;">
    <button type="button" class="btn btn-default" >{l s='Wybierz z mapy' mod='pocztapolskaen'}</button>
    <div class="pickup_info">{$pickup_standard_point}</div>
    <input type="hidden" id="pp_pni_pickup" value="{$pni}">
</div>
<div class="pp_pickup_at_point_cod" style="display: none;">
    <button type="button" class="btn btn-default">{l s='Wybierz z mapy' mod='pocztapolskaen'}</button>
    <div class="pickup_info_cod">{$pickup_cod_point}</div>
    <input type="hidden" id="pp_pni_pickup_cod" value="{$pni_cod}">
</div>
{/if}

<style type="text/css">#overlay{literal}{z-index:1000000}{/literal}</style>

<script>
    var pickup_at_point_standard =  {$pickup_at_point_standard};
    var pickup_at_point_cod = {$pickup_at_point_cod};
    var pickup_at_automat_standard =  {$pickup_at_automat_standard};
    var pickup_at_automat_cod = {$pickup_at_automat_cod};
    var cart_order_total = {$order_total}
    var baseUrl = "{$baseUrl}";
    var ajaxAddPointLink = "{$ajaxAddPointLink nofilter}";
    var address_has_telephone = {$has_telephone};
    var address = "{$address}";
    var ps16 = "{$ps16}";

    var pp_message_point = "{l s='Wybrany punkt: ' mod='pocztapolskaen'}";
    var pp_message_error = "{l s='Wystąpił błąd: ' mod='pocztapolskaen'}";
    var pp_message_choose_point = "{l s='Wybierz punkt odbioru' mod='pocztapolskaen'}";
    var pp_message_add_phone = "{l s='Wprowadź numer telefonu' mod='pocztapolskaen'}";
    var pp_message_add_mobile_phone = "{l s='Wprowadź numer telefonu komórkowego do danych adresowych' mod='pocztapolskaen'}";


    function selectPoint(params, cod){
        var pni= params.pni;
        var point =  params.name +', ' + params.street + ', ' + params.zipCode +' ' +params.city;
        var cod_info = (typeof cod === 'undefined' ? 0: cod);

		$('.pickup_info').html('');
		$('.pickup_info_cod').html('');
        $('.pickup_info'+(cod?'_cod':'')).html('<b>' + pp_message_point + '<b>' + point);
        $('#pp_pni_pickup'+(cod?'_cod':'')).val(pni);
        $.ajax({
            url:  ajaxAddPointLink,
            type: 'POST',
            dataType: "text",
            data: 'ajax=true&pni=' + pni +'&point='+point+'&cod='+cod_info,
            success: function(result){
                if (result.hasError){

                }

            },
            error: function(XMLHttpRequest, textStatus, errorThrown) {
                alert(pp_message_error + XMLHttpRequest + "\n" + 'Status: ' + textStatus);
            }
        });
    }

    function selectPointCod(params){
        selectPoint(params, 1);
    }

    function addPickupAtPoint(){

        if($( ".pickup_at_point_standard").length == 0){
            $.each(pickup_at_point_standard, function(i,val){
                if(val != ''){

                    //target = $("input[data-key='"+val+",']").closest('tr').find('td.delivery_option_logo').next('td');
                    target = $("input[value='"+val+",']").parents('.delivery_option').find('.delivery_option_logo').next();
                    if(target.length == 0){
                        target = $("input[value='"+val+",']").closest('.delivery-option').find('.carrier-name');
                    }

                    obj = $(".pp_pickup_at_point_standard").clone();
                    obj.removeClass('pp_pickup_at_point_standard');
                    var types = [];

                    if ($.inArray(val, pickup_at_automat_standard) != -1) {
                        const index = pickup_at_automat_standard.indexOf(val);
                        pickup_at_automat_standard.splice(index, 1);
                    } else {
                        types = ['PUNKTY']
                    }

                    obj.find('button').on('click',function(){
                        PPWidgetApp.toggleMap({literal}{{/literal}callback: selectPoint, payOnPickup: false, payOnPickupMax: cart_order_total,address: address, type:types{literal}}{/literal});
                        checkRadioCarrier($(this));
                        }
                    );
                    obj.addClass('pickup_at_point_standard');
                    obj.show();
                    obj.appendTo(target);
                }
            });

            $.each(pickup_at_automat_standard, function(i,val){
                if(val != ''){

                    //target = $("input[data-key='"+val+",']").closest('tr').find('td.delivery_option_logo').next('td');
                    target = $("input[value='"+val+",']").parents('.delivery_option').find('.delivery_option_logo').next();
                    if(target.length == 0){
                        target = $("input[value='"+val+",']").closest('.delivery-option').find('.carrier-name');
                    }

                    obj = $(".pp_pickup_at_point_standard").clone();
                    obj.removeClass('pp_pickup_at_point_standard');
                    var types = ['AUTOMATY'];

                    obj.find('button').on('click',function(){
                            PPWidgetApp.toggleMap({literal}{{/literal}callback: selectPoint, payOnPickup: false, payOnPickupMax: cart_order_total,address: address, type:types{literal}}{/literal});
                            checkRadioCarrier($(this));
                        }
                    );
                    obj.addClass('pickup_at_point_standard');
                    obj.show();
                    obj.appendTo(target);
                }
            });
        }
        if($('.pickup_at_point_cod').length == 0){
            $.each(pickup_at_point_cod, function(i,val){
                if(val != ''){
                    //target = $("input[data-key='"+val+",']").closest('tr').find('td.delivery_option_logo').next('td');
                    target = $("input[value='"+val+",']").parents('.delivery_option').find('.delivery_option_logo').next();
                    if(target.length == 0){
                        target = $("input[value='"+val+",']").closest('.delivery-option').find('.carrier-name');
                    }
                    obj = $(".pp_pickup_at_point_cod").clone();
                    obj.removeClass('pp_pickup_at_point_cod');
                    var types = [];

                    if ($.inArray(val, pickup_at_automat_cod) != -1) {
                        const index = pickup_at_automat_cod.indexOf(val);
                        pickup_at_automat_cod.splice(index, 1);
                    } else {
                        types = ['PUNKTY'];
                    }

                    obj.find('button').on('click',function(){
                            PPWidgetApp.toggleMap({literal}{{/literal}callback: selectPointCod, payOnPickup: true, payOnPickupMax: cart_order_total,address: address, type:types{literal}}{/literal});
                            checkRadioCarrier($(this));
                        }
                    );
                    obj.addClass('pickup_at_point_cod');
                    obj.show();
                    obj.appendTo(target);
                }
            });

            $.each(pickup_at_automat_cod, function(i,val){
                if(val != ''){
                    //target = $("input[data-key='"+val+",']").closest('tr').find('td.delivery_option_logo').next('td');
                    target = $("input[value='"+val+",']").parents('.delivery_option').find('.delivery_option_logo').next();
                    if(target.length == 0){
                        target = $("input[value='"+val+",']").closest('.delivery-option').find('.carrier-name');
                    }
                    obj = $(".pp_pickup_at_point_cod").clone();
                    obj.removeClass('pp_pickup_at_point_cod');
                    var types = ['AUTOMATY'];

                    obj.find('button').on('click',function(){
                            PPWidgetApp.toggleMap({literal}{{/literal}callback: selectPointCod, payOnPickup: true, payOnPickupMax: cart_order_total,address: address, type:types{literal}}{/literal});
                            checkRadioCarrier($(this));
                        }
                    );
                    obj.addClass('pickup_at_point_cod');
                    obj.show();
                    obj.appendTo(target);
                }
            });
        }
    }

	function checkRadioCarrier(obj){
		radio = obj.closest('tr').find("input[type='radio']");
        if(radio.length == 0){
            radio = obj.closest('.delivery-option').find("input[type='radio']");
        }
        //console.log(obj.closest("input[type='radio']"));
        if(ps16){
            radio.prop('checked',true).trigger('click').trigger('change');
        } else {
            radio.prop('checked',true);
        }

        $('#overlay').css('z-index','10000000');
	}
    {if $ps16}
        $(document).ready(function () {
            addPickupAtPoint();
    {else}
        document.addEventListener('DOMContentLoaded', function() {
    {/if}

        if($("[name='confirmDeliveryOption']").length > 0){
            $('#js-delivery').append($( "<div class='alert-danger'></div>"));
        }

        $("[name='confirmDeliveryOption']").click(function(){
                   id = parseInt($("input[name*='delivery_option']:checked").val());
                   error = [];
                   if ($.inArray(id, pickup_at_point_standard) != -1){


                       if($('#pp_pni_pickup').val()==''){
                            error.push(pp_message_choose_point);
                       }

                       if(!address_has_telephone){
                           error.push(pp_message_add_phone);
                       }

                    }
                    if ($.inArray(id, pickup_at_automat_standard) != -1){


                        if($('#pp_pni_pickup').val()==''){
                            error.push(pp_message_choose_point);
                        }

                        if(!address_has_telephone){
                            error.push(pp_message_add_phone);
                        }

                    }
                    if ($.inArray(id, pickup_at_point_cod) != -1){
                        if($('#pp_pni_pickup_cod').val()==''){
                            error.push(pp_message_choose_point);
                        }

                        if(!address_has_telephone){
                            error.push(pp_message_add_phone)
                        }
                    }
                    if ($.inArray(id, pickup_at_automat_cod) != -1){
                        if($('#pp_pni_pickup_cod').val()==''){
                            error.push(pp_message_choose_point);
                        }

                        if(!address_has_telephone){
                            error.push(pp_message_add_phone)
                        }
                    }


                   if(error.length > 0){
                       $('.alert-danger').html(error.join('<br>'));
                       $('.alert-danger').fadeIn();
                       setTimeout(function(){
                           $('.alert-danger').fadeOut();
                       }, 3000);
                       return false;
                   }
                   return true;

                }

        );

            $(".payment_module").live("click",function(e){
                    e.preventDefault();

                    id = parseInt($("input[name*='delivery_option']:checked").val());
                    error_data = [];
                    if ($.inArray(id, pickup_at_point_standard) != -1){


                        if($('#pp_pni_pickup').val()==''){
                            error_data.push(pp_message_choose_point);
                        }

                        if(!address_has_telephone){
                            error_data.push(pp_message_add_phone);
                        }

                    }
                    if ($.inArray(id, pickup_at_point_cod) != -1){
                        if($('#pp_pni_pickup_cod').val()==''){
                            error_data.push(pp_message_choose_point);
                        }

                        if(!address_has_telephone){
                            error_data.push(pp_message_add_mobile_phone);
                        }
                    }

                    if(error_data.length > 0){
                        var errors = '';
                        for (error in error_data) {
                            errors += $('<div />').html(error_data[error]).text() + "\n";
                        }

                        alert(errors);

                    } else {
                        window.location = $(this).find('a').attr('href');
                    }
                }
            );
    });

</script>
