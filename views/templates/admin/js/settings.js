var ppSetting = {
  toggleRows: function (package_name) {
    if (package_name !== '') {
      $('.' + package_name + '.toggle_rows').find('*').change(function () {
        var val = $(this).val();
        var name = $(this).attr('name');
        var is_checked = $(this).attr('type') == 'radio' ? $(this).is(':checked') : 0;

        if (typeof (name) !== 'undefined' && val !== '') {
          if(is_checked){
            $('.' + package_name + '.' + name).hide();
            $('.' + package_name + '.' + name + '.' + val).trigger('change').show();
            $('.' + package_name + '.' + name + '.' + val).find('*').trigger('change',package_name);
          }
        }
      }).trigger('change');

      $('.toggle_panel.' + package_name).show();
    }
  },
  toggleCombo: function (package_name) {
      if(package_name !== ''){
          $('.' + package_name + '.toggle_combo').find('input,select').change(function(event){
              val = $(this).val();
              name = $(this).attr('name');
              var is_checked = $(this).attr('type') == 'radio' ? $(this).is(':checked') : 1;
              if(is_checked){
                  $('.' + package_name +'.' + name).hide();
                  if(val != '' ) {
                      $('.' + package_name +'.' + name + '.' + val).trigger('change').show();
                  }

                  if(typeof (event.isTrigger) == 'undefined'){
                      $('.' + package_name +'.' + name).find('input[type="text"]').val('');
                      $('.' + package_name +'.' + name).find('[id$="off"]').trigger('click').attr('checked',true);
                  }

              }

          }).trigger('change');
      }
  },
  packageChnage: function () {
    $('#pp_packages,#pp_packages_con').change(function () {
      var val = $(this).val();
      $('.toggle_panel').hide();
      $(this).closest('.tab-pane').find('.form-group').hide();
      $('.packages').show();
      if (val !== '') {
        $('.' + val).show();
        ppSetting.toggleRows(val);
        ppSetting.toggleCombo(val);
      }
      $('.btn-delivery').show();
    }).trigger('change');
  },
  myAccountRender: function () {
    var settings = $('#settings').clone(true);
    $('#settings').html('<div id="my_account_settings" class="col-lg-5"></div><div id="my_account_info" class="col-lg-7"></div>');
    $('#my_account_settings').append(settings);
    $('#settings').addClass('clearfix');
    $('.my_account_info').each(function () {
      $('#my_account_info').append($(this));
    });
    $('.my_account_info2').each(function () {
      $('#my_account_info').append($(this));
    });
  },
  showPassword: function(){
      $('.icon-key').parent().click(function(){
          if($('#pp_password').attr('type') == 'password'){
              $('#pp_password').attr('type','text');
          } else {
              $('#pp_password').attr('type','password');
          }
      })
  },
  setRodoButtons: function(){
    $('#pocztapolskaen_login_button').click(function () {
        if($('#pp_process_data_rodo_modal').is(':checked')){
            $.ajax({
                type: 'POST',
                cache: false,
                url: 'index.php',
                async: false,
                dataType: 'json',
                data: 'controller=AdminPocztaPolskaSettings&action=saveRodo&ajax=1&pp_process_data_rodo='+Number($('#pp_process_data_rodo_modal').is(':checked'))+'&pp_process_information_rodo='+Number($('#pp_process_information_rodo_modal').is(':checked'))+'&token='+token,
                success: function (res)
                {
                    if (res.success) {
                        $("#pp_process_data_rodo").prop('checked',$('#pp_process_data_rodo_modal').is(':checked'));
                        $("#pp_process_information_rodo").prop('checked',$('#pp_process_information_rodo_modal').is(':checked'));
                        $('#modal_rodo_information').modal('hide');

                    } else {
                        alert('Błąd zapisu');
                    }
                }
            });
        } else {
            error_modal('Błąd','Zaznacz wymagane zgody');
        }

    });
},
    showRODOForm: function(){
        if(!$('#pp_process_data_rodo').is(':checked')){
            $('#modal_rodo_information').modal({
                backdrop: 'static',
                keyboard: false
            });
        }

    },
    sendSettingForm: function(){
        $('#configuration_form').submit();
    },
    closeConfirmation:function(){
        return true;
    }
}
function change(val) {
  $('.toggle_panel').hide();
  $('#services .form-group').hide();
  $('.services_packages').show();
  if (val !== '') {
    $('.' + val).show();
    ppSetting.toggleRows(val);
  }
}



function setSettingsButtons() {
  $('.btn-settings').click(function () {
    $('form input[name="action"]').val($(this).attr('data-name'));
      if($(this).attr('data-name') == 'settings' && !$('#pp_process_data_rodo').is(':checked')){
          confirm_modal('Czy na pewno?','W przypadku wycofania zgody nastąpi wylogowanie z wtyczki i ' +
              'konieczne będzie ponowne zalogowanie i wyrażenie zgody','OK','Anuluj',ppSetting.sendSettingForm,ppSetting.closeConfirmation);
      } else {
        $(this).parents('form').submit();
      }

  });
}



function setPassword() {
  if ($('form input[name="pp_password_new"]').val() != '') {
    $('.new_pass').show();
  } else {
    $('.new_pass').hide();
  }
  $('.show-password').click(function () {
    $('.new_pass').show();
  });
}

function setKarta() {
  if ($('#pp_default_karta_id').val() == null) {
    $('.default_karta').hide();
  } else {
    $('.default_karta').show();
  }
}
function setUrzad() {
  if ($('#pp_default_urzad_id').val() == null) {
    $('.default_urzad').hide();
  } else {
    $('.default_urzad').show();
  }
}
/*function setKurierSerwis() {
  $('.pp_pocztex_serwis').change(function () {
    if ($(this).val() == 'EKSPRES24') {
      if ($('#pp_pocztex_wartosc_ubezpieczenia').find('option[value="1000"]').attr('selected')) {
        $('#pp_pocztex_wartosc_ubezpieczenia').find('option[value="5000"]').attr('selected', true);
      }
      $('#pp_pocztex_wartosc_ubezpieczenia').find('option[value="1000"]').attr('disabled', true);
    } else {
      $('#pp_pocztex_wartosc_ubezpieczenia').find('option[value="1000"]').attr('disabled', false);
    }
  }).trigger('change');
}*/

function setTabs() {
  if (typeof (active_tab) != undefined && active_tab != '') {
    $('.active').removeClass('active');
    $('a[href="#' + active_tab + '"]').parent().addClass('active');
    $('#' + active_tab).addClass('active');
  }

}

function ppLoadScripts(){
  ppSetting.packageChnage();
  ppSetting.toggleRows('statuses');
  ppSetting.toggleRows('delivery');
  ppSetting.toggleCombo();
  ppSetting.showPassword();
  setSettingsButtons();
  setPassword();
  setKarta();
  setUrzad();
  setTabs();
  ppSetting.setRodoButtons();
  ppSetting.showRODOForm();
  //setKurierSerwis();
  ppSetting.myAccountRender();

    //$('#modal_rodo_information').modal('show');
    //confirm_modal('test','test2','OK','Anuluj');
}

function loadPocztaPolskaOrderForm(link){
  $.ajax({
      type: 'POST',
      cache: false,
      url: link,
      async: false,
      dataType: 'html',
      success: function (res)
      {
          $('#pocztapolskaen_order_detail').html(res);
      }
  });

}

$(document).ready(function () {
  ppLoadScripts();
});
