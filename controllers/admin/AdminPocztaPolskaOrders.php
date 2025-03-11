<?php

require_once(__DIR__ . '/AdminPocztaPolskaController.php');

/**
 * Klasa odpowiadajaca za obsulge przesyłek
 */
class AdminPocztaPolskaOrdersController extends AdminPocztaPolskaController {

    public $toolbar_title;
    protected $statuses_array = array();
    protected $actions_available = array('view', 'deleteshipment', 'pack', 'downloadlabel', 'printlabel');
    protected $actions = array('view', 'deleteshipment', 'pack', 'downloadlabel', 'printlabel');

    public function __construct() {
        parent::__construct();

        $this->module = Module::getInstanceByName('pocztapolskaen');
        $this->bootstrap = true;
        $this->table = 'orders';
        $this->className = 'PPOrder';
        $this->identifier = 'id_pp_order';
        $this->lang = false;
        $this->explicitSelect = true;
        $this->allow_export = false;
        $this->multiple_fieldsets = true;
        $this->context = Context::getContext();
        $this->_use_found_rows = true;
        $this->toolbar_title = $this->l('Zamówienia');
        $this->_prepareOrderStatuses();
        $this->_prepareListFields();
        $this->_prepareListQuery();

    }

    /**
     * Metoda odpowiedzialana za generowanie listy jaka ma sie wyswietlic
     */
    public function renderList() {
        $this->_prepareMassActions();
        $this->tpl_list_vars['order_statuses'] = $this->statuses_array;
        if (!($this->fields_list && is_array($this->fields_list))) {
            return false;
        }
        if (!isset($this->context->cookie->pocztapolska_en_reload_data_ts) || time() >= $this->context->cookie->pocztapolska_en_reload_data_ts) {



            if((int)Configuration::get(PPSetting::PP_IS_CONNECTED)){
                PPPostOffice::reloadData();
                PPOrderSet::reloadData();
                PPProfileAddress::reloadData();
            }

            $this->context->cookie->pocztapolska_en_reload_data_ts = time() + PocztaPolskaEn::RELOAD_DATA_INTERVAL;

        }
        $this->getList($this->context->language->id);

        // If list has 'active' field, we automatically create bulk action
        if (isset($this->fields_list) && is_array($this->fields_list) && array_key_exists('active', $this->fields_list) && !empty($this->fields_list['active'])) {
            if (!is_array($this->bulk_actions)) {
                $this->bulk_actions = array();
            }

            $this->bulk_actions = array_merge(array(
                'enableSelection' => array(
                    'text' => $this->l('Enable selection'),
                    'icon' => 'icon-power-off text-success'
                ),
                'disableSelection' => array(
                    'text' => $this->l('Disable selection'),
                    'icon' => 'icon-power-off text-danger'
                ),
                'divider' => array(
                    'text' => 'divider'
                )
                    ), $this->bulk_actions);
        }
        $helper = new HelperList();
        $helper->module = $this->module;
        // Empty list is ok
        if (!is_array($this->_list)) {
            $this->displayWarning($this->l('Bad SQL query', 'Helper') . '<br />' . htmlspecialchars($this->_list_error));
            return false;
        }

        $this->setHelperDisplay($helper);
        $helper->_default_pagination = $this->_default_pagination;
        $helper->_pagination = $this->_pagination;
        $helper->tpl_vars = $this->getTemplateListVars();
        $helper->tpl_delete_link_vars = $this->tpl_delete_link_vars;

        // For compatibility reasons, we have to check standard actions in class attributes
        foreach ($this->actions_available as $action) {
            if (!in_array($action, $this->actions) && isset($this->$action) && $this->$action) {
                $this->actions[] = $action;
            }
        }
        $helper->tpl_vars['fields_hidden'] = $this->_getOrderDetail();
        $helper->is_cms = $this->is_cms;
        $list = $helper->generateList($this->_list, $this->fields_list);

        return $list;
    }

    /**
     * Metoda odpowedzialna za przekazanie dodatkowych informacji do listy dla każdego rekordu
     */
    private function _getOrderDetail() {
        $arr = array();
        $url = Context::getContext()->link->getAdminLink('AdminOrders');

        foreach ($this->_list as $k => $item) {
            $arr[$k]['id_order'] = $item['id_order'];
            $arr[$k]['point'] = $item['point'];
            $arr[$k]['pni'] = $item['pni'];
            $arr[$k]['weight'] = $item['weight'];
            $arr[$k]['amount'] = $item['amount'];
            $arr[$k]['amount_number'] = $item['amount_number'];
            $arr[$k]['total'] = $item['total'];
            $arr[$k]['name'] = $item['name'];
            $arr[$k]['shipment_number'] = $item['number'];
            $arr[$k]['id_envelope'] = $item['id_envelope'];
            $arr[$k]['reference'] = $item['reference'];
            $arr[$k]['package'] = PPSetting::getPackageByOrderDelvery($item['id_carrier']);
            $arr[$k]['is_cod'] = PPSetting::isCarrierIsCod($item['id_carrier']);
            $arr[$k]['url'] = $url . '&vieworder&id_order=' . $arr[$k]['id_order'];
            $arr[$k]['message'] = $item['message'];
            $arr[$k]['address'] = $item['address_pickup'];
        }
        return $arr;
    }

    /**
     * Metoda odpowiedzialna za kontrukcje url do generowania etykiety
     */
    public function displayDownloadlabelLink($token = null, $id) {
        if (!array_key_exists('downloadlabel', self::$cache_lang)) {
            self::$cache_lang['downloadlabel'] = $this->l('Pobierz etykietę');
        }
        if (!isset($this->_shipments[$id])) {
            return '';
        }
        $this->context->smarty->assign(array(
            'href' => self::$currentIndex .
            '&' . $this->identifier . '=' . $id .
            '&action=downloadlabel&token=' . ($token != null ? $token : $this->token),
            'class' => 'downloadlabel',
            'action' => self::$cache_lang['downloadlabel'],
        ));

        return $this->context->smarty->fetch('helpers/list/list_action_default.tpl');
    }

    /**
     * Metoda odpowiedzialna za kontrukcje url do wydruku etykiety
     */
    public function displayPrintlabelLink($token = null, $id) {
        if (!array_key_exists('printlabel', self::$cache_lang)) {
            self::$cache_lang['printlabel'] = $this->l('Drukuj etykietę');
        }
        if (!isset($this->_shipments[$id])) {
            return '';
        }
        $this->context->smarty->assign(array(
            'href' => self::$currentIndex .
            '&' . $this->identifier . '=' . $id .
            '&action=printlabel&token=' . ($token != null ? $token : $this->token),
            'class' => 'printlabel',
            'action' => self::$cache_lang['printlabel'],
        ));
        return $this->context->smarty->fetch(_PS_MODULE_DIR_ . $this->module->name . DIRECTORY_SEPARATOR . 'views/templates/admin/list_action_pack_inline.tpl');
    }

    /**
     * Metoda odpowiedzialna za konstrukcje url do podglądu zamówienia
     */
    public function displayViewLink($token = null, $id) {
        if (!array_key_exists('view', self::$cache_lang)) {
            self::$cache_lang['view'] = $this->l('Zobacz');
        }
        if($this->module->is1770()){
          $href = Context::getContext()->link->getAdminLink('AdminOrders', true, [], ['id_order'=> $id, 'action' => 'vieworder']);
        }
        else{
          $href = Context::getContext()->link->getAdminLink('AdminOrders', true) .
          '&id_order=' . $id .
          '&vieworder';
        }


        $this->context->smarty->assign(array(
            'href' => $href,
            'action' => self::$cache_lang['view'],
        ));

        return $this->context->smarty->fetch('helpers/list/list_action_view.tpl');
    }

    /**
     * Metoda odpowiedzialna za konstrukcje url do akcji pakowania przesyłki
     */
    public function displayPackLink($token = null, $id) {
        if (!array_key_exists('pack', self::$cache_lang)) {
            self::$cache_lang['pack'] = $this->l('Spakuj');
        }
        if (isset($this->_shipments[$id])) {
            return '';
        }
        $this->context->smarty->assign(array(
            'href' => '#',
            'class' => 'pack_inline_action',
            'action' => self::$cache_lang['pack'],
        ));

        return $this->context->smarty->fetch(_PS_MODULE_DIR_ . $this->module->name . DIRECTORY_SEPARATOR . 'views/templates/admin/list_action_default.tpl');
    }

    /**
     * metoda inicjujaca toolbar w adminie dla danego controllera
     *
     * @return mixed
     */
    public function initToolbar() {
        parent::initToolbar();
        unset($this->toolbar_btn['new']);
        $this->toolbar_btn[''] = array('desc' => '');
        return $this->toolbar_btn;
    }

    /**
     * metoda odpowiedziala na obsluge zadan dla danego controllera
     */
    public function initProcess() {
        parent::initProcess();
        if (Tools::isSubmit('submitBulkdownloadLabelsorders')) {
            $this->action = 'bulkDownloadLabels';
        } else if (Tools::isSubmit('submitBulkprintLabelsorders')) {
            $this->action = 'bulkPrintLabels';
        }
    }

    /**
     * metoda odpowiedzialna za obsluge zadania po jego wykonaniu
     * @return mixed
     */
    public function postProcess() {
        if ($this->action == 'view') {
            $href = Context::getContext()->link->getAdminLink('AdminOrders');
            $href .= '&vieworder&id_order=' . Tools::getValue($this->identifier);
            Tools::redirectAdmin($href);
            return;
        }
        return parent::postProcess();
    }

    /**
     * Metoda odpowiedzialna za knstrukcje zapytania sql listy
     */
    protected function _prepareListQuery() {
        $deliveries = PPSetting::getPPDelivery();
        $this->_select = '
                a.id_order,
                a.id_order as id_pp_order,
		o.shipment_number as number,
                o.id_buffor as id_buffor,
                o.id_shipment,
                o.shipment_type,
                o.send_date,
                a.date_add as order_date,
                osl.`name` AS `osname`,
		os.`color`,
                a.date_add as order_date,
		CONCAT(LEFT(c.`firstname`, 1), \'. \', c.`lastname`) AS `customer`,
		osl.`name` AS `osname`,
                CONCAT(address.address1," ",address.address2,",",address.postcode," ",address.city,",",country_lang.name) as address,
                CONCAT(address.address1," ",address.address2,","," ",address.city) as address_pickup,
                o.point,
                o.pni,
                oc.`weight`,
                "10000" as amount,
                "123" as amount_number,
                a.`total_paid_tax_incl` as total,
                oset.`id_envelope`,
                oset.`name` AS `bufor_name`,
                a.`id_customer`,
                a.`reference`,
                oc.id_carrier,
                lm.message
                ';
        $this->_join = '
                LEFT JOIN `' . _DB_PREFIX_ . 'pocztapolskaen_order` o ON (o.`id_order` = a.`id_order`)
                LEFT JOIN `' . _DB_PREFIX_ . 'pocztapolskaen_order_set` oset ON (oset.`id_en` = o.`id_buffor`)
                LEFT JOIN `' . _DB_PREFIX_ . 'customer` c ON (c.`id_customer` = a.`id_customer`)
                LEFT JOIN `' . _DB_PREFIX_ . 'address` address ON address.id_address = a.id_address_delivery
                LEFT JOIN `' . _DB_PREFIX_ . 'order_carrier` oc ON (a.`id_order` = oc.`id_order`)
                LEFT JOIN `' . _DB_PREFIX_ . 'country_lang` country_lang ON (address.`id_country`  = country_lang.`id_country` AND country_lang.`id_lang` = ' . (int) $this->context->language->id . ')
                LEFT JOIN `' . _DB_PREFIX_ . 'order_state` os ON (os.`id_order_state` = a.`current_state`)
                LEFT JOIN `' . _DB_PREFIX_ . 'order_state_lang` osl ON (os.`id_order_state` = osl.`id_order_state` AND osl.`id_lang` = ' . (int) $this->context->language->id . ')
                LEFT JOIN  `'. _DB_PREFIX_ . 'message` lm ON (lm.id_order = a.id_order AND lm.date_add < a.date_add)';
        $this->_orderBy = 'a.id_order';
        $this->_orderWay = 'DESC';
        $this->_where .= !empty($deliveries) ? ' and (a.id_carrier in(' . implode(PPSetting::PP_SEPARATOR, $deliveries) . ') or not o.id_order is null)' : 'and not o.id_order is null ';
    }

    /**
     * Metoda bydująca tabliece statusów zamówień
     */
    protected function _prepareOrderStatuses() {
        $statuses = OrderState::getOrderStates((int) $this->context->language->id);
        foreach ($statuses as $status) {
            $this->statuses_array[$status['id_order_state']] = $status['name'];
        }
    }

    /**
     * Metoda odpowiedzialna za przygotowanie kolumn listy
     */
    protected function _prepareListFields() {
        $this->fields_list = array(
            'id_order' => array(
                'title' => $this->l('ID'),
                'align' => 'text-center',
                'class' => 'fixed-width-xs',
                'filter_key' => 'o!id_order'
            ),
            'shipment_type' => array(
                'title' => $this->l('Rodzaj przesyłki'),
                'havingFilter' => true,
                'filter_key' => 'o!shipment_type',
                'type' => 'select',
                'list' => PocztaPolskaEn::getPPPackages(false),
                'width'=>'80',
                'class' => 'fixed-width-xs',
            ),
            'customer' => array(
                'title' => $this->l('Klient'),
                'havingFilter' => true,
                'type' => 'html',
            ),
            'address' => array(
                'title' => $this->l('Adres dostawy'),
                'havingFilter' => true,
            ),
            'osname' => array(
                'title' => $this->l('Status'),
                'type' => 'select',
                'color' => 'color',
                'list' => $this->statuses_array,
                'filter_key' => 'os!id_order_state',
                'filter_type' => 'int',
                'order_key' => 'osname',
                'width' => '100'
            ),
            'number' => array(
                'title' => $this->l('Numer'),
                'havingFilter' => true,
                'filter_key' => 'o!shipment_number',
            ),
            'order_date' => array(
                'title' => $this->l('Data zamówienia'),
                'type' => 'datetime',
                'filter_key' => 'a!date_add',
                'width' => '100'
            ),
            'send_date' => array(//ad shipment
                'title' => $this->l('Data utworzenia'),
                'type' => 'datetime',
                'filter_key' => 'o!send_date'
            ),
            'post_date' => array(//send envelope
                'title' => $this->l('Data nadania'),
                'type' => 'date',
                'filter_key' => 'o!post_date'
            ),
        );
    }

    /**
     * Metoda odpowiedzialna za przygotowanie akcji grupowych
     */
    protected function _prepareMassActions() {
        $this->bulk_actions = array(
            'pack' => array(
                'text' => $this->l('Spakuj'),
                'html' => '<a href="#" id="action_pack_modal"><i class="icon-send"></i>&nbsp;' . $this->l('Spakuj') . '</a>'
            ),
            'downloadLabels' => array(
                'text' => $this->l('Pobierz etykiety'),
                'icon' => 'icon-send',
            ),
            'printLabels' => array(
                'text' => $this->l('Drukuj etykiety'),
                'icon' => 'icon-send',
            )
        );
    }

    /**
     * Metoda incjująca okna modalne
     */
    public function initModal() {
        $this->_initPackModal();
        parent::initModal();
    }

    /**
     * Metoda odpowiadajaca za przekazanie modal do widoku
     */
    public function renderModal() {
        $modal_render = '';
        if (is_array($this->modals) && count($this->modals)) {
            foreach ($this->modals as $modal) {
                $this->context->smarty->assign($modal);
                if ($modal['modal_id'] == 'packModal') {
                    $modal_render .= $this->context->smarty->fetch(_PS_MODULE_DIR_ . $this->module->name . DIRECTORY_SEPARATOR . 'views/templates/admin/controllers/orders/pack_modal.tpl');
                } else {
                    $modal_render .= $this->context->smarty->fetch('modal.tpl');
                }
            }
        }
        return $modal_render;
    }

    /**
     * Metoda incjująca okno modalne do pakowania przesyłek
     */
    protected function _initPackModal() {
        $this->setMedia();
        require_once(__DIR__ . '/../../helper/AdminPocztaPolskaOrdersHelperForm.php');
        $helper = new AdminPocztaPolskaOrdersHelperForm();
        $content = $helper->generateForm();
        $this->modals[] = array(
            'currentToken' => $this->token,
            'modal_id' => 'packModal',
            'modal_class' => 'modal-lg',
            'modal_title' => $this->l('Dodawanie nowej przesyłki dla zamówienia:'),
            'modal_content' => '<div id="services" class="modal-body" style="max-height: 70vh;overflow-y: auto;">' . $content . '</div>',
            'modal_actions' => array(
                array(
                    'type' => 'link',
                    'label' => $this->l('Utwórz przesyłkę'),
                    'href' => '#',
                    'class' => 'btn btn-primary pack_modal_next_button'
                )
            )
        );
        Context::getContext()->override_controller_name_for_translations = null;
    }

    /**
     * metoda odpowiedzialna za dolaczenie dotatkowych plikow do widoku
     * @param bool $isNewTheme
     */
    public function setMedia($isNewTheme = false) {
        parent::setMedia();
        $this->addJS(__PS_BASE_URI__ . 'modules/' . $this->module->name . '/views/templates/admin/js/settings.js');
        $this->addJS(__PS_BASE_URI__ . 'modules/' . $this->module->name . '/views/templates/admin/js/pack.js');
        $this->addJS('https://mapa.ecommerce.poczta-polska.pl/widget/scripts/ppwidget.js');
        $this->addCSS(__PS_BASE_URI__ . 'modules/' . $this->module->name . '/views/templates/admin/css/orders.css');
        $this->addJS(__PS_BASE_URI__ . 'modules/' . $this->module->name . '/views/templates/admin/js/orders.js');
    }

    /**
     * Metoda odpowidająca za waliadacje paczki
     */
    public function ajaxProcessValidatePackage() {
        $pp_package = Tools::getValue('pp_packages', '');
        $id = Tools::getValue('id_order', '');
        $values = PPPackage::getValues($pp_package, PPSetting::getAllValues());
        $ppOrder = PPOrder::findByOrder($id);
        $package = new PPPackage($pp_package, $ppOrder);
        $package->loadFromArray($values);
        $result['errors'] = $package->validateFields();
        die(json_encode($result));
    }

    /**
     * Metoda odpowidająca za akcje pakowanie paczki.
     */
    public function ajaxProcessPackOrder() {
        $result = array('success' => true, 'errors' => array(), 'id_buffor' => '', 'id_en' => '');
        $id = Tools::getValue('id_order', array());
        $order = new Order($id);
        $pp_package = Tools::getValue('pp_packages', '');
        $ppOrder = PPOrder::findByOrder($id);
        $values = PPPackage::getValues($pp_package, PPSetting::getAllValues());
        $package = new PPPackage($pp_package, $ppOrder);
        $package->loadFromArray($values);
        $packageResult = $package->save();
        if ($packageResult === false) {
            $result['errors'] = $package->errors;
            $result['success'] = false;
        } else {
            if (isset($packageResult[0]['guid'])) {
                $ppOrder->id_shipment = $packageResult[0]['guid'];
                $ppOrder->shipment_number = $packageResult[0]['numerNadania'];
            } else {
                $ppOrder->id_shipment = $packageResult['guid'];
                $ppOrder->shipment_number = $packageResult['numerNadania'];
            }
            $ppOrder->id_buffor = $packageResult['id_buffor'];
            $ppOrder->shipment_type = $pp_package;
            $ppOrder->send_date = date('Y-m-d H:i:s');
            $ppOrder->post_date = null;
            $ppOrder->id_order = $id;
            $ppOrder->id_cart = $order->id_cart;
            $values['address_sent'] = $package->getAddress();
            $ppOrder->attributes = json_encode($values);
            if ($package->isOdbiorWPunkcie()) {
                $ppOrder->pni = $package->pni;
                $ppOrder->point = $package->pokaz_mape;
            }
            if (!$ppOrder->save()) {
                $result['errors'] = Tools::displayError($this->l('Błąd zapisu zamówienia'));
                $result['success'] = true;
            } else {
                $result['id_buffor'] = $ppOrder->getOrderSet()->id;
                $result['id_en'] = $ppOrder->id_buffor;
                $ppOrder->setOrderStatus(PPSetting::PP_STATUS_CREATE);
                $ppOrder->setOrderShipment();
            }
        }
        die(json_encode($result));
    }

    /**
     * Metoda odpowiadajaca ca pobranie grupowe etykiet
     */
    public function processBulkDownloadLabels() {
        $ids = Tools::getValue('ordersBox', array());
        if (empty($ids)) {
            $this->errors = $this->l('Nie można pobrać etykiet');
            return;
        }
        $pporders = PPOrder::getOrders($ids, false, true);
        if ($pporders->count() <= 0) {
            $this->errors = $this->l('Nie można pobrać etykiet');
            return;
        }
        $shipments = array();
        foreach ($pporders as $order) {
            $shipments[] = $order->id_shipment;
        }
        $pdf = ENadawca::PdfContent();
        //$content = $pdf->getAddresLabelByGuidCompact($shipments);
        $content = $pdf->getPrintForParcel($shipments);
        if ($pdf->hasErrors()) {
            $this->errors = $pdf->getErrors();
        } else {
            foreach ($pporders as $pporder) {
                $pporder->setOrderStatus(PPSetting::PP_STATUS_PRINT_LABEL);
            }
            header('Content-type: application/pdf');
            header('Content-Disposition: attachment; filename="Nalepki adresowe.pdf"');
            echo $content;
            exit;
        }
    }

    /**
     * Metoda odpowiadajaca za drukowanie grupowe etykiet
     */
    public function processBulkPrintLabels() {
        $ids = Tools::getValue('ordersBox', array());
        if (empty($ids)) {
            $this->errors = $this->l('Nie można pobrać etykiet');
            return;
        }
        $pporders = PPOrder::getOrders($ids, false, true);
        if ($pporders->count() <= 0) {
            $this->errors = $this->l('Nie można pobrać etykiet');
            return;
        }
        $shipments = array();
        foreach ($pporders as $order) {
            $shipments[] = $order->id_shipment;
        }
        $pdf = ENadawca::PdfContent();
        //$content = $pdf->getAddresLabelByGuidCompact($shipments);
        $content = $pdf->getPrintForParcel($shipments);
        if ($pdf->hasErrors()) {
            $this->errors = $pdf->getErrors();
        } else {
            foreach ($pporders as $pporder) {
                $pporder->setOrderStatus(PPSetting::PP_STATUS_PRINT_LABEL);
            }
            header('Content-type: application/pdf');
            header('Content-Disposition: inline; filename="Nalepki adresowe.pdf"');
            header('Content-Transfer-Encoding: binary');
            header('Accept-Ranges: bytes');
            echo $content;
            exit;
        }
    }

    /**
     * Metoda odpowiadajaca za pobranie danych do wwygenrownia listy
     */
    public function getList($id_lang, $order_by = null, $order_way = null, $start = 0, $limit = null, $id_lang_shop = false) {
        parent::getList($id_lang, $order_by, $order_way, $start, $limit, $id_lang_shop);
        $types = PocztaPolskaEn::getPPPackages(false);
        $sets = array();
        $buffors = new PrestaShopCollection('PPOrderSet');
        $buffors->sqlWhere('(a0.id_envelope is null OR a0.id_envelope=0)');
        foreach ($buffors as $c) {
            $sets[$c->id_en] = $c;
        }
        foreach ($this->_list as &$item) {
            if (!empty($item['id_shipment'])) {
                $this->_shipments[$item['id_order']] = array(
                    'id_shipment' => $item['id_shipment']
                );
            }
            if (!empty($item['id_buffor']) && isset($sets[$item['id_buffor']])) {
                $this->_buffors[$item['id_order']] = $sets[$item['id_buffor']];
            }
            $item['shipment_type'] = isset($types[$item['shipment_type']]) ? $types[$item['shipment_type']] : $item['shipment_type'];
            $item['name'] = $item['reference'] . ',&nbsp;#' . $item['id_order'] . ',&nbsp;' . $item['customer'] . '<br/>' . $item['address'];
            $item['total'] = Tools::ps_round($item['total'], _PS_PRICE_DISPLAY_PRECISION_);
            $item['weight'] = sprintf("%.3f ", $item['weight']);

            if(!$this->module->is16()){
              $customerUrl = $this->context->link->getAdminLink('AdminCustomers', true, [], ['id_customer'=> $item['id_customer'], 'action' => 'viewcustomer']);
            }
            else{
              $customerUrl = $this->context->link->getAdminLink('AdminCustomers') . '&viewcustomer&id_customer=' . $item['id_customer'];
            }


            $item['customer'] = "<a href='{$customerUrl}' traget='_blank' title='{$item['customer']}'>{$item['customer']}</a>";
        }
    }

    /**
     * Metodą odpowiadająca za usuwanie przesyłek
     */
    public function processDeleteshipment() {
        if (Validate::isLoadedObject($object = $this->loadObject())) {
            $envelope = ENadawca::Envelope();
            $envelope->clearByGuids($object->id_shipment, $object->id_buffor);
            if ($envelope->hasErrors()) {
                $this->errors = $envelope->getErrors();
            } else {
                $object->clearShipment();
            }
        }
        if (empty($this->errors)) {
            $this->redirect_after = self::$currentIndex . '&conf=36&token=' . $this->token;
        }
    }

    /**
     * Metoda odpowidająca za konstrukcje linku do usuwanie przesyłek
     */
    public function displayDeleteshipmentLink($token = null, $id) {
        if (!array_key_exists('deleteshipment', self::$cache_lang)) {
            self::$cache_lang['deleteshipment'] = $this->l('Usuń przesyłki');
        }
        if (!isset($this->_shipments[$id])) {
            return '';
        }
        if (!isset($this->_buffors[$id])) {
            return '';
        }
        $this->context->smarty->assign(array(
            'href' => self::$currentIndex .
            '&' . $this->identifier . '=' . $id .
            '&action=deleteshipment&token=' . ($token != null ? $token : $this->token),
            'class' => 'deleteshipment',
            'action' => self::$cache_lang['deleteshipment'],
        ));

        return $this->context->smarty->fetch('helpers/list/list_action_default.tpl');
    }

    /**
     * Metoda odpowidająca za ładowanie pojedyńczego rekordy
     */
    protected function loadObject($opt = false) {
        if (!isset($this->className) || empty($this->className)) {
            return true;
        }

        $id = (int) Tools::getValue($this->identifier);
        if ($id && Validate::isUnsignedId($id)) {
            $order = new Order($id);
            if (!$this->object) {
                $this->object = PPOrder::findByOrder($order->id);
            }
            if (Validate::isLoadedObject($this->object)) {
                return $this->object;
            }
            // throw exception
            $this->errors[] = Tools::displayError($this->l('The object cannot be loaded (or found)'));
            return false;
        } elseif ($opt) {
            if (!$this->object) {
                $this->object = new $this->className();
            }
            return $this->object;
        } else {
            $this->errors[] = Tools::displayError($this->l('The object cannot be loaded (the identifier is missing or invalid)'));
            return false;
        }
    }

    /**
     * Metoda odpowiadajaca za pobranie pojedynczej etykiety
     */
    public function processDownloadlabel() {
        if (Validate::isLoadedObject($object = $this->loadObject())) {
            $pdf = ENadawca::PdfContent();
            $content = $pdf->getPrintForParcel(array($object->id_shipment));
            if ($pdf->hasErrors()) {
                $this->errors = $pdf->getErrors();
            } else {
                $object->setOrderStatus(PPSetting::PP_STATUS_PRINT_LABEL);
                header('Content-type: application/pdf');
                header('Content-Disposition: attachment; filename="Nalepki adresowe.pdf"');
                echo $content;
                exit;
            }
        }
    }

    public function ajaxProcessPocztaPolskaOrderForm(){
      $idOrder = Tools::getValue('id_order', 0);

      require_once($this->module->getLocalPath().'helper/AdminPocztaPolskaOrdersHelperForm.php');
      $helper = new AdminPocztaPolskaOrdersHelperForm();
      $content = $helper->generateForm();

      $modal_conf = array(
          'currentToken' => Tools::getAdminTokenLite('AdminPocztaPolskaOrders'),
          'modal_id' => 'packModal',
          'modal_class' => 'modal-lg',
          'modal_title' => $this->l('Dodawanie nowej przesyłki dla zamówienia:'),
          'modal_content' => '<div id="services" class="modal-body" style="max-height: 70vh;overflow-y: auto;">' . $content . '</div>',
          'modal_actions' => array(
              array(
                  'type' => 'link',
                  'label' => $this->l('Utwórz przesyłkę'),
                  'href' => '#',
                  'class' => 'btn btn-primary pack_modal_next_button'
              )
          )
      );

      $this->context->smarty->assign($modal_conf);
      $modal_render = '';
      $modal_render = $this->context->smarty->fetch(_PS_MODULE_DIR_ . $this->module->name . DIRECTORY_SEPARATOR . 'views/templates/admin/controllers/orders/pack_modal.tpl');

      $module = Module::getInstanceByName('pocztapolskaen');

      $order = new Order((int)$idOrder, (int)Configuration::get('PS_LANG_DEFAULT'));
      $pp_order = PPOrder::findByCart($order->id_cart, false);
      $delivery_address = new Address($order->id_address_delivery);
      $shipping = $order->getShipping();
      $tab_order = array();
      $customer = $order->getCustomer();
      $tab_order['name'] = "#".$order->id." ".$order->reference.' '.$this->l('od'). ' '.$customer->firstname.' '.$customer->lastname;
      $tab_order['id_order'] = $order->id;
      $tab_order['reference'] = $order->reference;
      $tab_order['total'] = Tools::ps_round($order->total_paid, _PS_PRICE_DISPLAY_PRECISION_);
      $tab_order['weight'] = sprintf("%.3f", $shipping[0]['weight']);
      $tab_order['package'] = PPSetting::getPackageByOrderDelvery($order->id_carrier);
      $tab_order['is_cod'] = PPSetting::isCarrierIsCod($order->id_carrier);
      $tab_order['pni'] = !is_null($pp_order)&&!is_null($pp_order->pni)?$pp_order->pni:'';
      $tab_order['point'] = !is_null($pp_order)&&is_string($pp_order->point)?$pp_order->point:'';
      $tab_order['shipment_number'] = !is_null($pp_order)&&!empty($pp_order->shipment_number)?$pp_order->shipment_number:'';
      $tab_order['message'] = $order->getFirstMessage();
      $tab_order['address'] = $delivery_address->address1.' '.$delivery_address->address2.', '.$delivery_address->city;


      $tabs = array();

      if(!is_null($pp_order)){
          if(!empty($pp_order->point)){
              $tabs[0] = $this->l('ODBIÓR W PUNKCIE');
          }
          if(!empty($pp_order->shipment_number)){
              $tabs[1] = $this->l('POCZTA POLSKA PRZESYŁKA');
          }
          if(empty($pp_order->shipment_number) && empty($pp_order->point)){
              $tabs[2] = $this->l('POCZTA POLSKA - NADAJ PRZESYŁKĘ');
          }
      } else {
          $tabs[2] = $this->l('POCZTA POLSKA - NADAJ PRZESYŁKĘ');
      }

      $content = '';
      foreach ($tabs as $k => $v) {
          $helper = new HelperForm();
          $helper->name_controller = 'pocztapolskaen_form';
          $helper->multiple_fieldsets = false;
          $helper->show_toolbar = false;
          $helper->module = $module;
          $helper->fields_value = $this->_getFieldsValue($pp_order);
          $helper->default_form_language = $this->context->language->id;
          $helper->tpl_vars['active_tab'] = '';
          $fields = $this->_getOrderFields($v, $k, $tab_order, $modal_render);
          $content .= $helper->generateForm($fields);
      }
      die($content);
    }

    /**
     * metoda zwracaja dodatkowe informacje na temat przesylki PP
     * @param $pp_order
     * @return array
     */
    private function _getFieldsValue($pp_order) {
        $module = Module::getInstanceByName('pocztapolskaen');

        $tab = array();
        $packages = $module::getPPPackages(false);
        $orderSet = new PPOrderSet();

        if(!is_null($pp_order)){
            $buffor = $orderSet->getByBuffor($pp_order->id_buffor);
            $tab =  array(
                'wybrano_punkt' => $pp_order->point,
                'numer_nadania' => $pp_order->shipment_number,
                'rodzaj' => !empty($pp_order->shipment_type)?$packages[$pp_order->shipment_type]:'',
                'data_nadania' =>$buffor->post_date,
                //'link' => 'http://emonitoring.poczta-polska.pl/?numer='.$pp_order->shipment_number,
            );
        }
        return $tab;
    }

    /**
     * Metoda przygotowujaca dane do formularza wyswietlajacego podglad przesylki PP w zamowieniu
     * @param $title
     * @param $tab
     * @param $order
     * @param $modal
     * @return array
     */
    protected function _getOrderFields($title, $tab, $order, $modal) {
        $fields = array();

        switch ($tab) {
            case 0:
                $fields[]['form'] = array(
                    'legend' => array(
                        'icon' => 'icon-plane',
                        'title' => $this->l($title),
                    ),
                    'input' => array(
                        array(
                            'type' => 'text',
                            'name' => 'wybrano_punkt',
                            'label' => $this->l('Wybrano punkt'),
                            'disabled' => true
                        ),
                        array(
                            'type' => 'html',
                            'name' => 'html_data',
                            'label' => '',
                            'html_content' => (empty($order['shipment_number'])?'<button type="button" data-id_order="'.$order['id_order'].'" data-point="'.$order['point'].'" data-pni="'.$order['pni'].'" data-weight="'.$order['weight'].'" data-total="'.$order['total'].'" data-name="'.$order['name'].'" data-reference="'.$order['reference'].'" data-package="'.$order['package'].'" data-is_cod="'.$order['is_cod'].'" data-message="'.$order['message'].'" data-address="'.$order['address'].'" class="btn btn-primary btn_add_package">' . $this->l('Utwórz przesyłkę') . '</button><div class="bootstrap">'.$modal.'</div>':''),
                        ),
                    ),
                );
                break;
            case 1:
                $fields[]['form'] = array(
                    'legend' => array(
                        'icon' => 'icon-globe',
                        'title' => $this->l($title),
                    ),
                    'input' => array(
                        array(
                            'type' => 'html',
                            'name' => 'html_data',
                            'label' => '<b>' . $this->l('Przesyłki powiązane z tym zamówieniem') . '</b><hr>',
                            'html_content' => '<a class="btn btn-default" href="'.$this->context->link->getAdminLink('AdminPocztaPolskaOrders', true).'&id_pp_order='.$order['id_order'].'&action=downloadlabel" >'.$this->l('Pobierz etykietę').'</a>&nbsp;<a class="btn btn-default"  href="'.$this->context->link->getAdminLink('AdminPocztaPolskaOrders', true).'&id_pp_order='.$order['id_order'].'&action=printlabel" target="_blank">'.$this->l('Drukuj etykietę').'</a>',
                        ),
                        array(
                            'type' => 'text',
                            'name' => 'numer_nadania',
                            'label' => $this->l('Numer nadania'),
                            'disabled' => true
                        ),
                        array(
                            'type' => 'text',
                            'name' => 'rodzaj',
                            'label' => $this->l('Rodzaj'),
                            'disabled' => true
                        ),
                        array(
                            'type' => 'text',
                            'name' => 'data_nadania',
                            'label' => $this->l('Data nadania'),
                            'disabled' => true
                        ),
                        array(
                            'type' => 'html',
                            'name'=>'link',
                            'html_content' =>'<div style="height:30px; margin-top:8px;"><a target="_blank" style="padding-top:5px;" href="http://emonitoring.poczta-polska.pl/?numer='.$order['shipment_number'].'">http://emonitoring.poczta-polska.pl/?numer='.$order['shipment_number'].'</a></div>',
                            'label' => $this->l('Link do śledzenia'),
                        ),
                    ),
                );
                break;
            case 2:
                $fields[]['form'] = array(
                    'legend' => array(
                        'icon' => 'icon-plane',
                        'title' => $this->l($title),
                    ),
                    'input' => array(
                        array(
                            'type' => 'html',
                            'name' => 'html_data',
                            'label' => '',
                            'html_content' => '<button type="button" data-id_order="'.$order['id_order'].'" data-point="'.$order['point'].'" data-pni="'.$order['pni'].'" data-weight="'.$order['weight'].'" data-total="'.$order['total'].'" data-name="'.$order['name'].'" data-reference="'.$order['reference'].'" data-package="'.$order['package'].'" data-is_cod="'.$order['is_cod'].'" data-message="'.$order['message'].'" data-address="'.$order['address'].'" class="btn btn-primary btn_add_package">' . $this->l('Utwórz przesyłkę') . '</button><div class="bootstrap">'.$modal.'</div>',
                        ),
                    ),
                );
                break;
        }

        return $fields;
    }

    /**
     * Metoda odpowiadajaca za drukowanie pojedynczej etykiety
     */
    public function processPrintlabel() {
        if (Validate::isLoadedObject($object = $this->loadObject())) {
            $pdf = ENadawca::PdfContent();
            $content = $pdf->getPrintForParcel(array($object->id_shipment));

            if ($pdf->hasErrors()) {
                $this->errors = $pdf->getErrors();
            } else {
                $object->setOrderStatus(PPSetting::PP_STATUS_PRINT_LABEL);

                header('Content-type: application/pdf');
                header('Content-Disposition: inline; filename="Nalepki adresowe.pdf"');
                header('Content-Transfer-Encoding: binary');
                header('Accept-Ranges: bytes');
                echo $content;
                echo '<script type="text/javascript">alert("ASd");window.print();</script>';
                exit;
            }
        }
    }

}
