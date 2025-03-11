var ppPack = {
  currentToken: '',
  orders: [],
  currentOrder: '',
  formDefaultValues: [],
  msg: '',
  ids: [],
  loading: false,
  package: '',
  types: {'1':['PUNKTY'], '2':['AUTOMATY']},
  format_packs:{'0': ['S', 'M', 'L', 'XL', '2XL'], '1':['S', 'M', 'L', 'XL'], '2':['S','M','L']},
  init: function (currentToken) {
    var $this = this;
    if (typeof (currentToken) !== 'undefined') {
      this.currentToken = currentToken;
    }
    $("#action_pack_modal").click(function () {
      $this.ids = $this.getIds();
      $this.orders = [];
      $this.currentOrder = '';
      ppPack.getOrders();
    });
    $(".pack_modal_next_button").click(function () {
      $this.beforeProcess();
	  setTimeout(function(){
		  $this.next();
		  $this.afterProcess();
	  }, 100);
	  return false;
    });
    $(".pack_inline_action").click(function () {
      var id = $(this).closest('tr').data('id_order');
      $this.ids = [id];
      $this.orders = [];
      $this.currentOrder = '';
      $this.getOrders();
    });
    $(".btn_add_package").click(function () {
      var id = $(this).data('id_order');
      $this.ids = [id];
      $this.orders = [];
      $this.currentOrder = '';
      $this.getOrders();
    });
    $("#pp_pocztex_2021_kurier_odbior_w_punkcie").change(function() {
      $('#pp_pocztex_2021_kurier_format option').each(function() {
          $(this).remove();
      });
      var options = $this.format_packs[$(this).val()];
      var len = options.length;

      for (let i = 0; i < len; i++) {
        $('#pp_pocztex_2021_kurier_format').append('<option value="'+options[i]+'">'+options[i]+'</option>');
      }
    });
    $("#packModal").on('shown.bs.modal', function () {
      $this.currentOrder = $this.getOrder();
      $this.setOrderTitle(ppPack.currentOrder);
      $this.setButtonLabel();
      $this.setPackage();
      $this.setFields();
      $this.setDatePicker();
      //ppSetting.toggleCombo($this.package);
      $('#pp_packages').on('change', function () {
        $this.package = $(this).val();
        $this.setFields();
      });
    });

    $this.formDefaultValues = $('#packModal select,input,textarea').serializeArray();
    $this.setNextButton();
  },
  setNextButton: function (disabled) {
    var disabled = disabled || false;
    $('.pack_modal_next_button').attr('disabled', disabled);
  },
  next: function () {
    var $this = this;
    var errors = $this.validate();
    if (errors.length <= 0) {
      $("#packModal").find('.alert-danger').hide();
      $this.packOrder(function () {
        if ($this.isEmpty()) {
          $("#packModal").modal('hide');
          window.location.reload();
        } else {
          $this.clearErrors();
          $this.restoreDefaultForm();
          var order = $this.getOrder();
          $this.setOrderTitle(order);
          $this.setButtonLabel();
          $this.restoreDefault();
          $this.setPackage();
        }
      });
    } else {
      $this.displayErrors(errors)
    }
  },
  skipOrder: function (callback) {
    callback();
  },
  packOrder: function (callback) {
    var $this = this;
    if (typeof ($this.currentOrder.id_order) != undefined && $this.currentOrder.id_order !== '') {
      var $this = this;
      $.ajax({
        type: 'POST',
        cache: false,
        url: 'index.php',
        async: false,
        dataType: 'json',
        data: $('#packModal select,input,textarea').serialize() + '&controller=AdminPocztaPolskaOrders&action=packOrder&id_order=' + $this.currentOrder.id_order + '&ajax=1&token=' + $this.currentToken,
        beforeSend: function () {
          //$this.beforeProcess();
        },
        error: function () {
          //$this.beforeProcess();
        },
        success: function (res)
        {
          if (res.success) {
            if (typeof (callback) !== 'undefined') {
              callback();
            }
          } else {
            $this.displayErrors(res.errors);
          }
          //$this.afterProcess();
        }
      });
    }
  },
  restoreDefault: function () {
    $("#packModal").find('.alert-danger').hide();
    for (var i in this.formDefaultValues) {
      var el = $('#packModal').find('[name="' + this.formDefaultValues[i].name + '"]');
      if (el.is(':radio')) {
        $('#packModal').find('[name="' + this.formDefaultValues[i].name + '"][value="' + this.formDefaultValues[i].value + '"]').attr('checked', true);
      } else {
        el.val(this.formDefaultValues[i].value);
      }
    }
    $('#packModal').find('#pp_packages').trigger('change');
  },
  replaceDefaultVariables: function(){
      var $this = this;
      var package = $this.getPackage();
      desc = $('#' + package + '_opis_przesylki').val();

      if(typeof(desc) !== 'undefined'){
          $('#' + package + '_opis_przesylki').val(desc.replace('{reference}',$this.currentOrder.reference).replace('{id_order}',$this.currentOrder.id_order).replace('{message}',$this.currentOrder.message));
      }

  },
  setOrderTitle: function(order) {
    var text = '<a href="'+order.url+'" target="_blank">'+order.name+'</a>';
    $('#modal_order_info').html(text);
    var counter = this.getOrdersCount();
    if(counter>1){
      $('#orders_counter').parent().show();
      $('#orders_counter').html(counter);
    }
    else{
      $('#orders_counter').parent().hide();
    }
  },
  setButtonLabel: function(){
    var counter = this.getOrdersCount();
    var label;
    if(counter>1){
      label = $('.pack_modal_next_button').data('label_multi');
    }
    else{
      label = $('.pack_modal_next_button').data('label_one');
    }
    $('.pack_modal_next_button').html(label);
  },
  getOrdersCount: function(){
    var i = 1;
    for (var id in this.orders) {
      i++;
    }
    return i;
  },
  getOrder: function () {
    var $this = this;
    if (!$this.isEmpty()) {
      var i = 0;
      for (var id in $this.orders) {
        if (i === 0) {
          $this.currentOrder = $this.orders[id];
          delete $this.orders[id];
          i++;
          break;
        }
      }
    }
    return $this.currentOrder;
  },
  isEmpty: function () {
    return $.isEmptyObject(ppPack.orders);
  },
  isChecked: function () {
    return $('[name="pocztapolskaen_orderBox[]"]:checked').length;
  },
  beforeProcess: function () {
    $('.loader').show();
    this.setNextButton(true);
  },
  afterProcess: function () {
    var $this = this;
    $this.setNextButton(false);
    $('.loader').hide();
  },
  validate: function () {
    var $this = this;
    var errors = [];
    $.ajax({
      type: 'POST',
      cache: false,
      url: 'index.php',
      async: false,
      dataType: 'json',
      data: $('#packModal select,input,textarea').serialize() + '&controller=AdminPocztaPolskaOrders&action=validatePackage&id_order=' + $this.currentOrder.id_order + '&ajax=1&token=' + $this.currentToken,
      beforeSend: function () {
        //$this.beforeProcess();
      },
      error: function (xhr, textStatus, errorThrown) {
        $this.beforeProcess();
        //window.location.reload();
      },
      success: function (res)
      {
        for (var i in res.errors) {
          errors.push(res.errors[i]);
        }
        //$this.afterProcess();
      }
    });

    return errors;
  },
  getIds: function () {
    var ids = [];
    $('[name="ordersBox[]"]:checked').each(function () {
      var id = $(this).val();
      var shipment_number = $('[data-id_order="' + id + '"]').data('shipment_number');
      if (shipment_number === '' || shipment_number == 0) {
        ids.push(id);
      }
    });
    return ids;
  },
  displayErrors: function (errors) {
    this.clearErrors();
    for (var i in errors) {
      var li = $('<li></li>').html(errors[i]);
      $("#packModal").find('.alert-danger ol').append(li);
    }
    $("#packModal").find('.alert-danger').show();
  },
  clearErrors: function () {
    $("#packModal").find('.alert-danger ol').html('');
  },
  setDatePicker: function(){
      $(".datepicker_modal").datepicker({
          prevText: '',
          nextText: '',
          dateFormat: 'yy-mm-dd',
          beforeShow: function() {
              setTimeout(function(){
                  $('.ui-datepicker').css('z-index', 99999999999999);
              }, 0);
          }
      });
  },
  setFields: function () {
    var $this = this;
    $this.setPni();
    $this.setWeight();
    $this.setAmountNumber();
    $this.setDeclarationValue();
    $this.replaceDefaultVariables();
  },
  setWeight: function () {
    var $this = this;
    var package = $this.getPackage();
    if ($('#' + package + '_masa').val() === ''||$('#' + package + '_masa').val()<=0 || $this.currentOrder.weight >0) {
      $('#' + package + '_masa').val($.trim($this.currentOrder.weight));
    }
  },
  setAmountNumber: function () {
    var $this = this;
    var package = $this.getPackage();
    $('input[name="' + package + '_rodzaj"]').on('click', function () {
      if ($(this).val() === 'pobranie') {
        if ($('#' + package + '_kwota_pobrania_zl').val() === '') {
          $('#' + package + '_kwota_pobrania_zl').val($this.currentOrder.total);
        }
        if ($('#' + package + '_numer_rachunku').val() === '') {
          $('#' + package + '_numer_rachunku').val($this.currentOrder.amount_number);
        }
      }
    });
      if($this.currentOrder.is_cod){
          $('#' + package + '_pobranie_on').trigger('click');
      }

    //if ($('input[name="' + package + '_rodzaj"][value="1"]').is(':checked')) {
      if ($('#' + package + '_kwota_pobrania_zl').val() === '') {
        $('#' + package + '_kwota_pobrania_zl').val($this.currentOrder.total);
      }
      if ($('#' + package + '_numer_rachunku').val() === '') {
        $('#' + package + '_numer_rachunku').val($this.currentOrder.amount_number);
      //}
    }
  },
  setDeclarationValue: function () {
    var $this = this;
    var package = $this.getPackage();
    $('input[name="' + package + '_deklaracja_wartosci"]').on('click', function () {
      if ($(this).val() === '1') {
        if ($('#' + package + '_wartosc_zl').val() === ''||$('#' + package + '_wartosc_zl').val()<=0) {
          $('#' + package + '_wartosc_zl').val($this.currentOrder.total);
        }
        if ($('#' + package + '_wartosc_kg').val() === ''||$('#' + package + '_wartosc_kg').val()<=0 || $this.currentOrder.weight >0) {
          $('#' + package + '_wartosc_kg').val($this.currentOrder.weight);
        }
      }
    });
    //if ($('input[name="' + package + '_deklaracja_wartosci"][value="1"]').is(':checked')) {
      if ($('#' + package + '_wartosc_zl').val() === '' || $('#' + package + '_wartosc_zl').val() <= 0) {
        $('#' + package + '_wartosc_zl').val($this.currentOrder.total);
      //}
      //if ($('#' + package + '_wartosc_kg').val() === ''||$('#' + package + '_wartosc_kg').val() <=0 ) {
      if($this.currentOrder.weight > 0){
        $('#' + package + '_wartosc_kg').val($this.currentOrder.weight);
      }

      //}
    }
  },
  setPni: function () {
    var $this = this;
    var package = $this.getPackage();
    $('input[name="' + package + '_odbior_w_punkcie"]').on('change', function () {
      if ($(this).val() === '1' || $(this).val() == '2') {
        if ($('#' + package + '_pokaz_mape').val() === '') {
          $('#' + package + '_pokaz_mape').val($this.currentOrder.point);
        }
        if ($('#' + package + '_pni').val() === '') {
          $('#' + package + '_pni').val($this.currentOrder.pni);
        }
      }
    });
    if(typeof($this.currentOrder.point) !=='undefined' && $this.currentOrder.point !=''){
      var val = $this.currentOrder.point.includes('AUTOMAT') ? 2 : 1;
      $('#' + package + '_odbior_w_punkcie').val(val).trigger('change');
      $('#' + package + '_pokaz_mape').val($this.currentOrder.point);
      $('#' + package + '_pni').val($this.currentOrder.pni);
    } else {
      $('#' + package + '_odbior_w_punkcie').val(0).trigger('change');
    }
    /*if ($('input[name="' + package + '_odbior_w_punkcie"][value="1"]').is(':checked')) {
      if ($('#' + package + '_pokaz_mape').val() === '') {
        $('#' + package + '_pokaz_mape').val($this.currentOrder.point);
      }
      if ($('#' + package + '_pni').val() === '') {
        $('#' + package + '_pni').val($this.currentOrder.pni);
      }
    }*/
  },
  showPackModal: function () {
    this.restoreDefault();
    $("#packModal").modal('show');
  },
  getPackage: function () {
    if (this.package === '') {
      this.package = $('#pp_packages').val();
    }
    return this.package;
  },
  getOrders: function () {
    var $this = this;
    for (var i in $this.ids) {
      var id = $this.ids[i];
      $this.orders[id] = $('[data-id_order="' + id + '"]').data();
    }
    if ($this.orders.length > 0) {
      $this.showPackModal();
    }
  },
  selectPickup: function(params){
    var point = params.name +', ' + params.street + ', ' + params.zipCode +' ' +params.city;
    var package = ppPack.getPackage();
    $('#' + package + '_pokaz_mape').val(point);
    $('#' + package + '_pni').val(params.pni);
  },
  setPackage: function(){
    $('#pp_packages').val(this.currentOrder.package).trigger('change');
  },
  restoreDefaultForm: function () {
      $( ":checkbox" ).prop('checked',false);
      $( ":radio[value='0']").attr('checked',true).trigger('click');
  }
}
