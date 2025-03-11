<?php

require_once(__DIR__ . '/AdminPocztaPolskaController.php');

/**
 * Klasa odpowiadajaca za przenoszenie przesyłek pomiedzy zbiorami
 */
class AdminPocztaPolskaTransferSetsController extends AdminPocztaPolskaController {

    public function __construct() {
        parent::__construct();

        $this->module = Module::getInstanceByName('pocztapolskaen');
        $this->bootstrap = true;
        $this->table = 'orders';
        $this->className = 'PPOrder';
        $this->identifier = 'id_order';
        $this->lang = false;
        $this->explicitSelect = true;
        $this->allow_export = false;
        $this->context = Context::getContext();
        $this->force_show_bulk_actions = true;
        $this->_use_found_rows = true;
        $this->_prepareOrderStatuses();
        $this->_prepareListFields();
        $this->_prepareListQuery();
        $this->_prepareFieldsForm();
        $this->_prepareMassActions();

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
                'filter_key' => 'o!id_order',
                'remove_onclick' => true
            ),
            'shipment_type' => array(
                'title' => $this->l('Rodzaj przesyłki'),
                'havingFilter' => true,
                'filter_key' => 'o!shipment_type',
                'type' => 'select',
                'list' => PocztaPolskaEn::getPPPackages(false),
                'remove_onclick' => true
            ),
            'customer' => array(
                'title' => $this->l('Klient'),
                'havingFilter' => true,
                'type' => 'html',
                'remove_onclick' => true
            ),
            'address' => array(
                'title' => $this->l('Adres dostawy'),
                'havingFilter' => true,
                'remove_onclick' => true
            ),
            'osname' => array(
                'title' => $this->l('Status'),
                'type' => 'select',
                'color' => 'color',
                'list' => $this->statuses_array,
                'filter_key' => 'os!id_order_state',
                'filter_type' => 'int',
                'order_key' => 'osname',
                'remove_onclick' => true
            ),
            'number' => array(
                'title' => $this->l('Numer przesyłki'),
                'havingFilter' => true,
                'filter_key' => 'o!shipment_number',
                'remove_onclick' => true
            ),
            'order_date' => array(
                'title' => $this->l('Data zamówienia'),
                'type' => 'datetime',
                'filter_key' => 'a!date_add',
                'remove_onclick' => true
            ),
            'send_date' => array(//ad shipment
                'title' => $this->l('Data utworzenia'),
                'type' => 'datetime',
                'filter_key' => 'o!send_date',
                'remove_onclick' => true
            ),
        );
    }

    /**
     * Metoda odpowiedzialna za knstrukcje zapytania sql listy
     */
    protected function _prepareListQuery() {
        $deliveries = PPSetting::getPPDelivery();
        $this->_select = '
                a.id_order,
                o.id_pp_order,
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
                CONCAT_WS(" ",address.address1,address.address2,address.postcode,address.city,country_lang.name) as address,
                o.point,
                o.pni,
                oc.`weight`,
                "10000" as amount,
                "123" as amount_number,
                a.`total_paid_tax_incl` as total,
                oset.`id_envelope`,
                a.`id_customer`,
                a.`reference`,
                oc.id_carrier
                ';
        $this->_join = '
                LEFT JOIN `' . _DB_PREFIX_ . 'pocztapolskaen_order` o ON (o.`id_order` = a.`id_order`)
                LEFT JOIN `' . _DB_PREFIX_ . 'pocztapolskaen_order_set` oset ON (oset.`id_en` = o.`id_buffor`)
		LEFT JOIN `' . _DB_PREFIX_ . 'customer` c ON (c.`id_customer` = a.`id_customer`)
		LEFT JOIN `' . _DB_PREFIX_ . 'address` address ON address.id_address = a.id_address_delivery
                LEFT JOIN `' . _DB_PREFIX_ . 'order_carrier` oc ON (a.`id_order` = oc.`id_order`)
		LEFT JOIN `' . _DB_PREFIX_ . 'country` country ON address.id_country = country.id_country
		LEFT JOIN `' . _DB_PREFIX_ . 'country_lang` country_lang ON (country.`id_country` = country_lang.`id_country` AND country_lang.`id_lang` = ' . (int) $this->context->language->id . ')
		LEFT JOIN `' . _DB_PREFIX_ . 'order_state` os ON (os.`id_order_state` = a.`current_state`)
		LEFT JOIN `' . _DB_PREFIX_ . 'order_state_lang` osl ON (os.`id_order_state` = osl.`id_order_state` AND osl.`id_lang` = ' . (int) $this->context->language->id . ')';
        $this->_orderBy = 'a.id_order';
        $this->_orderWay = 'DESC';
        $this->_where .= !empty($deliveries) ? ' and (a.id_carrier in(' . implode(PPSetting::PP_SEPARATOR, $deliveries) . ') or not o.id_order is null)' : 'and not o.id_order is null ';
    }

    /**
     * Metoda odpowiedzialna za przygotowanie akcji grupowych
     */
    protected function _prepareMassActions() {
        $this->bulk_actions = array(
            'transferSets' => array(
                'text' => $this->l('Przenieś przesyłki'),
                'icon' => 'icon-send',
                'onclick' => 'ppSet.toggle(\'transfer_sets_action\');'
            )
        );
    }

    public function setMedia($isNewTheme = false) {
        parent::setMedia();
        $this->addJS(__PS_BASE_URI__ . 'modules/' . $this->module->name . '/views/templates/admin/js/sets.js');
    }

    /**
     * Metoda odpowiedzialna za przygotowanie pol formularza
     */
    protected function _prepareFieldsForm() {
        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Zbiór'),
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Nazwa zbioru'),
                    'name' => 'name',
                    'required' => true,
                    'col' => '9',
                ),
                array(
                    'type' => 'date',
                    'label' => $this->l('Planowana data nadania'),
                    'name' => 'date_from',
                    'maxlength' => 10,
                    'required' => true,
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Urząd nadania'),
                    'name' => 'customer_name',
                    'required' => true,
                    'col' => '9',
                    'default_value' => (int) $this->context->country->id,
                    'options' => array(
                        'query' => PPPostOffice::getCollection(true),
                        'id' => 'id_en',
                        'name' => 'name'
                    ),
                ),
            ),
            'submit' => array(
                'title' => $this->l('Zapisz'),
            )
        );
    }

    /**
     * Metoda odpowiedzialana za generowanie listy jaka ma sie wyswietlic
     */
    public function renderList() {
        if (!($this->fields_list && is_array($this->fields_list))) {
            return false;
        }
        $id_order_set = Tools::getValue('id_order_set', '');
        if (empty($id_order_set)) {
            Tools::redirectAdmin(Context::getContext()->link->getAdminLink('AdminPocztaPolskaOrdersSets'));
        }
        $orderSet = new PPOrderSet(Tools::getValue('id_order_set'));
        $this->_where = ' AND o.`id_buffor`=' . $orderSet->id_en;

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
        $helper->force_show_bulk_actions = $this->force_show_bulk_actions;
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

        $helper->is_cms = $this->is_cms;
        $helper->sql = $this->_listsql;
        $helper->simple_header = true;
        $list = $helper->generateList($this->_list, $this->fields_list);

        return $list;
    }

    /**
     * metoda zwracaja dostakowe parametry do zaladowania w Smarty
     *
     * @return array - lista parametrow
     */
    public function getTemplateListVars() {
        $id_order_set = Tools::getValue('id_order_set', '');
        $setsCollection = new PrestaShopCollection('PPOrderSet');
        $setsCollection->sqlWhere('(a0.id_envelope is null OR a0.id_envelope=0) AND a0.post_date>=CURDATE()');
        $setsCollection->where('id_order_set', '<>', $id_order_set);
        $sets = array();
        foreach ($setsCollection as $set) {
            $sets[$set->id_en] = $set->name;
        }
        $this->tpl_list_vars['id_buffors'] = $sets;
        $this->tpl_list_vars['id_order_set'] = $id_order_set;

        return $this->tpl_list_vars;
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
     * Metoda odpowiadająca za przenoszenie zbiorów
     */
    public function processBulktransferSets() {
        $ordersIds = Tools::getValue('ordersBox', array());
        $idBufforTo = Tools::getValue('id_buffor', '');
        $id_order_set = Tools::getValue('id_order_set', '');
        $set = PPOrderSet::getByBuffor($idBufforTo);
        if (!empty($ordersIds)) {
            if (!empty($idBufforTo)) {
                $orders = PPOrder::getGroupedByBuffer($ordersIds);
                $shipment = ENadawca::Shipment();
                if (!empty($orders)) {
                    foreach ($orders as $idBuffor => $v) {
                        $result = $shipment->move($idBuffor, $idBufforTo, $v['guids']);
                        $notMovedGuid = array();
                        if ($result['notMovedGuid']) {
                            $notMovedGuid = (!is_array($result['notMovedGuid'])) ? array($result['notMovedGuid']) : $result['notMovedGuid'];
                        }
                        if (!empty($notMovedGuid)) {

                        }
                        if (!$shipment->hasErrors()) {
                            foreach ($v['orders'] as $order) {
                                if (!in_array($order->id_shipment, $notMovedGuid)) {
                                    $order->id_buffor = $idBufforTo;
                                    $order->post_date = null;
                                    $order->save();
                                } else {
                                    $this->errors[] = sprintf($this->l('Przesyłka nr %s nie została przeniesiona'), $order->shipment_number);
                                }
                            }
                        } else {
                            $errors = $shipment->getErrors();
                            foreach ($errors as $error) {
                                $this->errors[] = $error;
                            }
                        }
                    }
                } else {
                    $this->errors[] = $this->l('Brak przesyłek');
                }
            } else {
                $this->errors[] = $this->l('Nie wybrano bufora docelowego');
            }
        } else {
            $this->errors[] = $this->l('Nie wybrano przesyłek');
        }
        if (!empty($this->errors)) {
            return false;
        }
        Tools::redirectAdmin(Context::getContext()->link->getAdminLink('AdminPocztaPolskaOrdersSets') . '&conf=34&id_buffor=' . $set->id);
    }

    /**
     * Metoda odpowiadajaca za pobranie danych do wwygenrownia listy
     */
    public function getList($id_lang, $order_by = null, $order_way = null, $start = 0, $limit = null, $id_lang_shop = false) {
        parent::getList($id_lang, $order_by, $order_way, $start, $limit, $id_lang_shop);
        $types = PocztaPolskaEn::getPPPackages(false);
        foreach ($this->_list as &$item) {
            $item['shipment_type'] = isset($types[$item['shipment_type']]) ? $types[$item['shipment_type']] : $item['shipment_type'];

        }
    }

}
