<?php
if (!defined('_PS_VERSION_'))
    exit;
class PocztaPolskaEn extends CarrierModule {

    const RELOAD_DATA_INTERVAL = 1800;
    const SET_EXPIRED_DAYS = 30;
    private bool $ps16;
    private bool $ps1770;

    /**
     * konstruktor obiektu
     */
    public function __construct() {
        $this->name = 'pocztapolskaen';
        $this->tab = 'shipping_logistics';
        $this->version = '1.2.6';
        $this->date_version = '21.08.2024';
        $this->author = 'Poczta Polska';
        $this->need_instance = 0;
        $this->ps16 = Tools::version_compare(_PS_VERSION_,'1.7' ,'<');
        $this->adminOrderHook = Tools::version_compare(_PS_VERSION_,'1.7.7.0' ,'<')?'displayAdminOrder':'displayAdminOrderSideBottom';
        $this->ps1770 = Tools::version_compare(_PS_VERSION_,'1.7.7.0' ,'>=');
        parent::__construct();

        $this->displayName = $this->l('Poczta Polska Elektroniczny Nadawca');
        $this->description = $this->l('Plugin odpowiedzialny za synchronizację z Poczta Polska Elektroniczny Nadawca.');
        $this->ps_versions_compliancy = array('min' => '1.6', 'max' => '8.2.1');
        $this->_registerAutoLoad();
    }

    public function getOrderShippingCost($params, $shipping_cost){
        return $shipping_cost;
    }

    public function getOrderShippingCostExternal($params){
        return $params;
    }


    public function is1770(){
      return $this->ps1770;
    }

    public function is16(){
      return $this->ps16;
    }

    /**
     * metoda uruchamin podczas instalacji modulu
     * @return bool
     */
    public function install() {
        include(dirname(__FILE__).'/sql/install.php');
        return (parent::install() && $this->tabInstall()  && $this->registerHook($this->adminOrderHook) &&
                $this->registerHook('displayBeforeCarrier') && $this->registerHook('actionCarrierProcess')) &&
                $this->registerHook('actionValidateOrder') && $this->registerHook('displayBackOfficeHeader') &&
                $this->registerHook('actionCarrierUpdate') && $this->registerHook('displayCarrierExtraContent') &&
                $this->registerHook('displayHeader') && $this->registerHook('actionObjectOrderUpdateAfter');
    }

    /**
     * metoda uruchamiana podczas deinstlacji modulu
     * @return bool
     */
    public function uninstall() {
        return parent::uninstall() && $this->sendUninstallInformationEmail() && $this->tabUninstall();
    }

    /**
     * metoda ladujca automatycznie pliki z brakujacymi klasami dla obiektow
     * @param $className
     *
     */
    protected function _autoload($className) {
        $path = $this->_getPath($className);
        if (!file_exists($path)) {
            return;
        }
        require_once $path;
    }

    /**
     * metoda ladujaca dodatkowe pliki podczas uruchamian backend
     */
    public function hookDisplayBackOfficeHeader() {
      $this->context->controller->addCss($this->_path.'css/tab.css');

      if($this->ps1770 && Tools::getValue('controller') == 'AdminOrders' && Tools::getValue('action') == 'vieworder'){
        $this->context->controller->addCSS($this->_path. 'views/templates/admin/css/order1770.css');
        $this->loadPocztaPolskaScripts();
        $this->context->controller->addJqueryUi('ui.datepicker');
      }
      $this->context->controller->addCSS($this->_path. 'views/templates/admin/css/orders.css');
    }

    /**
     * metoda zwracaja sciezke dostepu pliku dla klasy podanej w parametrze
     * @param $className - nazwa klasy
     * @return string
     */
    protected function _getPath($className) {
        $path = __DIR__ . '/classes/' . $className . '.php';
        if ($className == 'ENadawca') {
            $path = __DIR__ . '/classes/enadawca/ENadawca.php';
        }
        return $path;
    }

    /**
     * metoda rejestrujaca wlasny mechanizm autoload wywolywany podczas tworzenia obiektu
     */
    protected function _registerAutoload() {
        spl_autoload_register(function ($className) {
            $path = $this->_getPath($className);
            if (!file_exists($path)) {
                return;
            }
            require_once $path;
        });
    }

    /**
     * metoda wywolywana przez silnik prestashop podczas utworzenia zamowienia
     * @param $params - dane dotyczace zamowienia
     */
    public function hookActionValidateOrder($params){
        $pp_order = PPOrder::findByCart($params['cart']->id, false);
        if(!is_null($pp_order)){
            $pickup_at_point = array_merge(PPSetting::getPickupUpAtPoint(),PPSetting::getPickupUpAtPoint(true), PPSetting::getPickupUpAtAutomat(), PPSetting::getPickupUpAtAutomat(true));

            if(!in_array($params['cart']->id_carrier, $pickup_at_point)) {
                if (!empty($pp_order->point)) {
                    $pp_order->point = null;
                }
            }
            $pp_order->id_order = $params['order']->id;
            $pp_order->save();
        }
    }

    /**
     * metoda wywoloywana przez silnik prestashop podczas aktualizacji zamowienia
     * @param $params
     * @return void
     */
    public function hookActionObjectOrderUpdateAfter($params){
        $pp_order = PPOrder::findByOrder($params['object']->id);
        $cart = new Cart($pp_order->id_cart);

        if (!is_null($pp_order) && !is_null($pp_order->send_date) && is_null($pp_order->post_date)) {

            $ppPackage = new PPPackage($pp_order->shipment_type, $pp_order);
            $attributes_send = json_decode($pp_order->attributes, true);
            $address_send = $attributes_send['address_sent'];
            if (count(array_diff_assoc(json_decode(json_encode($ppPackage->getAddress()),true), $address_send))) {
                unset($address_send['address_sent']);
                $ppPackage->loadFromArray($attributes_send);
                $packageResult = $ppPackage->save();
                if ($packageResult === false) {
                    throw new Exception('Wystapił bład podczas aktualizacji paczki w systemie E-nadawca');
                } else {
                    ENadawca::Envelope()->clearByGuids($pp_order->id_shipment, $pp_order->id_buffor);
                    if (isset($packageResult[0]['guid'])) {
                        $pp_order->id_shipment = $packageResult[0]['guid'];
                        $pp_order->shipment_number = $packageResult[0]['numerNadania'];
                    } else {
                        $pp_order->id_shipment = $packageResult['guid'];
                        $pp_order->shipment_number = $packageResult['numerNadania'];
                    }
                    $attributes_send['address_sent'] = $ppPackage->getAddress();
                    $pp_order->attributes = json_encode($attributes_send);
                    $pp_order->id_buffor = $packageResult['id_buffor'];
                    $pp_order->save();

                }
            }

        }
    }

    public function loadPocztaPolskaScripts(){
      $this->context->controller->addJqueryPlugin('autosize');
      $this->context->controller->addJS(_PS_JS_DIR_ . 'admin/tinymce.inc.js');
      $this->context->controller->addJS($this->_path. 'views/templates/admin/js/settings.js');
      $this->context->controller->addJS($this->_path. 'views/templates/admin/js/pack.js');
      $this->context->controller->addJS('https://mapa.ecommerce.poczta-polska.pl/widget/scripts/ppwidget.js');
    }

    public function hookDisplayAdminOrderSideBottom($params){
      return $this->hookDisplayAdminOrder($params);
    }

    /**
     * metoda wywolywana przez silnik prestashop podczas podgladu zamowienia w adminie
     * @param $params - dane dotyczace zamowienia
     * @return string - dodatkowy content html do zaladownia w szczegolach zamowienia
     */
    public function hookDisplayAdminOrder($params) {
        if(!$this->ps1770){
          $this->loadPocztaPolskaScripts();
        }

        $this->context->smarty->assign([
            'getFormLink' => $this->context->link->getAdminLink('AdminPocztaPolskaOrders').'&id_order='.$params['id_order'].'&ajax=true&action=pocztaPolskaOrderForm',
        ]);

        return $this->display(__FILE__, 'views/templates/admin/hook/admin-order-detail.tpl');
    }

    /**
     * metoda wywolywana automatycznie przez silnik prestashop podczas wyboru dostawcow w procesie zakupowym
     * monitoruj czy został wybrany punktu odbioru dla rodzaju przesylki PP Odbior w punkcie
     *
     * @param $params - dane dotyczace koszyka klienta
     */
    public function hookActionCarrierProcess($params){

        $pickup_at_point = array_merge(PPSetting::getPickupUpAtPoint(),PPSetting::getPickupUpAtPoint(true), PPSetting::getPickupUpAtAutomat(), PPSetting::getPickupUpAtAutomat(true));

        if($this->ps16 && !Tools::getIsset('ajax') && !Tools::getIsset('is_ajax')){
            $ppOrder = PPOrder::findByCart($params['cart']->id, false);

            if(in_array($params['cart']->id_carrier, $pickup_at_point)){

                if(is_null($ppOrder) || $ppOrder->id_carrier != $params['cart']->id_carrier ){
                    $this->context->controller->errors[] = $this->l('Wybierz punkt odbioru');
                }

                $delivery_address = new Address($params['cart']->id_address_delivery);

                if(empty($delivery_address->phone_mobile) && empty($delivery_address->phone)){
                    $this->context->controller->errors[] = $this->l('Wprowadź numer telefonu komórkowego do danych adresowych');
                }

            }
        }

    }

    public function hookDisplayHeader(){
        return $this->display(__FILE__, 'header.tpl');

    }
    /**
     * metoda wywolywana automatycznie przez silnik prestashop podczas ladowania informacji o dostawcach
     *
     * @param $params - dane dotyczące koszyka klienta
     * @return string - html zawierajacy dodatkowe przyciski do wyboru odbioru w punkcie
     */
    public function hookDisplayBeforeCarrier($params)
    {
        $pp_order = PPOrder::findByCart($this->context->cart->id, false);
        $protocol_link = (Configuration::get('PS_SSL_ENABLED')) ? 'https://' : 'http://';
        $delivery_address = new Address($this->context->cart->id_address_delivery);
        if(!is_null($pp_order)){
            if($pp_order->cod){
                $pni_cod = $pp_order->pni;
                $pni = '';
            } else {
                $pni = $pp_order->pni;
                $pni_cod = '';
            }
        } else {
            $pni = '';
            $pni_cod = '';
        }

        $this->smarty->assign(array(
            'pickup_at_point_standard' => json_encode(PPSetting::getPickupUpAtPoint(),JSON_NUMERIC_CHECK),
            'pickup_at_point_cod' => json_encode(PPSetting::getPickupUpAtPoint(true),JSON_NUMERIC_CHECK),
            'pickup_at_automat_standard' => json_encode(PPSetting::getPickupUpAtAutomat(),JSON_NUMERIC_CHECK),
            'pickup_at_automat_cod' => json_encode(PPSetting::getPickupUpAtAutomat(true),JSON_NUMERIC_CHECK),
            'pickup_standard_point' => (!is_null($pp_order)&&!$pp_order->cod?$this->l('Wybrany punkt: ').$pp_order->point:''),
            'pickup_cod_point' =>(!is_null($pp_order)&&$pp_order->cod?$this->l('Wybrany punkt: ').$pp_order->point:''),
            'baseUrl'=>$protocol_link.Tools::getHttpHost().__PS_BASE_URI__,
            'ajaxAddPointLink' => $this->context->link->getModuleLink($this->name, 'addpoint', array('ajax'=>true)),
            'pni'=>$pni,
            'pni_cod'=>$pni_cod,
            'ps16'=>(int)$this->ps16,
            'has_telephone'=>((!empty($delivery_address->phone_mobile) || !empty($delivery_address->phone))?1:0),
            'address' => $this->getDeliveryAddress(),
            'order_total' => $this->context->cart->getOrderTotal()
        ));
        return $this->display(__FILE__, 'carrier.tpl');
    }

    public function hookDisplayCarrierExtraContent($params){
        if(!isset($params['carrier']['id']) || !$params['carrier']['id']){
            return '';
        }
        $types = array();

        $pickupPointCarriers = PPSetting::getPickupUpAtPoint();
        $pickupAutomatCarriers = PPSetting::getPickupUpAtAutomat();

        $pickupPointCODCarriers = PPSetting::getPickupUpAtPoint(true);
        $pickupAutomatCODCarriers = PPSetting::getPickupUpAtAutomat(true);

        $pickupCarriers = array_merge($pickupPointCarriers, $pickupAutomatCarriers);
        $pickupCarriersCOD = array_merge($pickupPointCODCarriers, $pickupAutomatCODCarriers);

        if (in_array($params['carrier']['id'], $pickupPointCarriers) || in_array($params['carrier']['id'], $pickupPointCODCarriers)) {
            $types[] = 'PUNKTY';
        }
        if (in_array($params['carrier']['id'], $pickupAutomatCarriers) || in_array($params['carrier']['id'], $pickupAutomatCODCarriers)) {
            $types[] = 'AUTOMATY';
        }
        if(
            ($pickupCarriers && count($pickupCarriers) && in_array($params['carrier']['id'], $pickupCarriers)) ||
            ($pickupCarriersCOD && count($pickupCarriersCOD) && in_array($params['carrier']['id'], $pickupCarriersCOD))
        ){
            $pp_order = PPOrder::findByCart($this->context->cart->id, false);
            $this->context->smarty->assign([
                'deliveryPoint' => (!is_null($pp_order))?$pp_order->pni:'',
                'deliveryPointInfo' => (!is_null($pp_order) && $pp_order->id_carrier == $params['carrier']['id'])?$this->l('Wybrany punkt: ').$pp_order->point:'',
                'isCod' => ($pickupCarriersCOD && count($pickupCarriersCOD) && in_array($params['carrier']['id'], $pickupCarriersCOD))?true:false,
                'types' => count($types) > 1 ? json_encode(array()) : json_encode($types)
            ]);

            return $this->display(__FILE__, '1.7/carrier.tpl');
        }

        return '';
    }

    private function getDeliveryAddress(){
        $delivery_address = new Address($this->context->cart->id_address_delivery);
        $address = '';
        if(trim($delivery_address->address1) && trim($delivery_address->city)){
            $address = $delivery_address->address1.((trim($delivery_address->address2))?' '.$delivery_address->address2:'').', '.$delivery_address->city;
        }
        elseif(trim($delivery_address->city)){
            $address = $delivery_address->city;
        }

        return $address;
    }

    /**
     *  metoda wywolywana automatycznie przez silnik prestashop podczas zapisywania danych o dostawcach w adminie
     *
     * @param $params - informacja o aktualizowanym rekordzie dostawcy
     */
    public function hookActionCarrierUpdate($params){
        $reflection = new ReflectionClass('PPPackage');
        $staticProperties = $reflection->getConstants();
        $tab = array();
        foreach($staticProperties as $key=>$value){
            if(strpos($value,'delivery') !== false){
                $tabOptions = explode(PPSetting::PP_SEPARATOR,Configuration::get($value));
                if(in_array($params['id_carrier'], $tabOptions)){
                    foreach ($tabOptions as $index=>$id_delivery) {
                        $tabOptions[$index] = str_replace($params['id_carrier'],$params['carrier']->id,$id_delivery);
                    }
                    Configuration::updateValue($value, implode(PPSetting::PP_SEPARATOR,$tabOptions));
                }

            }
        }
    }

    /**
     * Metoda instalujaca dodakowe komponenty z pluginu w menu Presty
     * @return bool
     */
    private function tabInstall() {

        $tabs = array(
            array(
                'class_name' => 'AdminPocztaPolskaSettings',
                'module' => 'pocztapolskaen',
                'name' => 'Ustawienia',
                'active' => 1,
            ),
            array(
                'class_name' => 'AdminPocztaPolskaOrders',
                'module' => 'pocztapolskaen',
                'name' => 'Zamówienia/Zbiory',
                'active' => 1,
            ),
            array(
                'class_name' => 'AdminPocztaPolskaCouriers',
                'module' => 'pocztapolskaen',
                'name' => 'Zamów kuriera',
                'active' => 1,
            ),
            array(
                'class_name' => 'AdminPocztaPolskaOrdersSets',
                'module' => 'pocztapolskaen',
                'name' => 'Zbiory',
                'active' => 0,
            ),
            array(
                'class_name' => 'AdminPocztaPolskaTransferSets',
                'module' => 'pocztapolskaen',
                'name' => 'Przenies przesyłki',
                'active' => 0,
            ),
            array(
                'class_name' => 'AdminPocztaPolskaOrdersSetsView',
                'module' => 'pocztapolskaen',
                'name' => 'Podgląd przesyłek zbioru',
                'active' => 0,
            ),
        );

        $langs = Language::getLanguages();
        $id_lang = (int) Configuration::get('PS_LANG_DEFAULT');
        $tab = new Tab();
        $tab->class_name = ($this->ps16?'AdminPocztaPolskaSettings':"POCZTAPOLSKA");
        $tab->module = "";
        $tab->id_parent = 0;
        foreach ($langs as $l) {
            $tab->name[$l['id_lang']] = $this->l('Poczta Polska');
        }
        $tab->save();
        $tab_id = $tab->id;

        foreach ($tabs as $tab) {
            $newTab = new Tab();
            $newTab->class_name = $tab['class_name'];
            $newTab->id_parent = $tab_id;
            $newTab->module = $tab['module'];
            $newTab->active = $tab['active'];
            foreach ($langs as $l) {
                $newTab->name[$l['id_lang']] = $this->l($tab['name']);
            }
            $newTab->save();
        }
        return true;
    }

    /**
     * metoda usuwajaca z menu presty komponenty dotyczace pluginu
     * @return bool
     */
    public function tabUninstall() {
        $tabs = array('AdminPocztaPolskaSettings', 'AdminPocztaPolskaOrders', 'AdminPocztaPolskaCouriers', 'AdminPocztaPolskaOrdersSets', 'AdminPocztaPolskaTransferSets','POCZTAPOLSKA');
        $parent_id = 0;
        foreach ($tabs as $tab) {
            $tabId = Tab::getIdFromClassName($tab);
            if ($tabId) {
                $tab = new Tab($tabId);
                $parent_id = $tab->id_parent;
                $tab->delete();
            }
        }
        $tab = new Tab($parent_id);
        $tab->delete();
        return true;
    }

    /**
     * meil informujacy o zainstalowaniu pluginu
     * @param bool $install
     * @return bool
     */
    public function sendInformationEmail($install = true){
        $id_lang = (int) Configuration::get('PS_LANG_DEFAULT');
        $employee = new Employee($this->context->cookie->id_employee);
        $template_vars = array(
            '{www}' => $_SERVER['SERVER_NAME'],
            '{version}' => $this->version,
            '{karta}' => Configuration::get(PPSetting::PP_DEFAULT_KARTA_ID),
            '{email}' => Configuration::get('PS_SHOP_EMAIL'),
            '{name_surname}' => $employee->firstname.' '.$employee->lastname,
            '{subject}' => ($install?$this->l('[Presta] Instalacja'):$this->l('[Presta] Upgrade')),
        );
        Mail::Send($id_lang, 'install', $template_vars['{subject}'] , $template_vars, PPSetting::PP_SUPPORT_EMAIL, null, null, null, null, null, dirname(__FILE__) . '/mails/');
        return true;
    }

    /**
     * meil informujacy o odinstalowaniu pluginu
     * @return bool
     */
    public function sendUninstallInformationEmail(){
        $id_lang = (int) Configuration::get('PS_LANG_DEFAULT');
        $employee = new Employee($this->context->cookie->id_employee);
        $template_vars = array(
            '{www}' => $_SERVER['SERVER_NAME'],
            '{version}' => $this->version,
            '{karta}' => Configuration::get(PPSetting::PP_DEFAULT_KARTA_ID),
            '{email}' => Configuration::get('PS_SHOP_EMAIL'),
            '{name_surname}' => $employee->firstname.' '.$employee->lastname,
            '{subject}' => $this->l('[Presta] Odinstalowanie wtyczki'),
        );
        Mail::Send($id_lang, 'uninstall', $template_vars['{subject}'] , $template_vars, PPSetting::PP_SUPPORT_EMAIL, null, null, null, null, null, dirname(__FILE__) . '/mails/');
        return true;
    }

    /**
     * Meil informujacy o wybraniu zgod przy instalacji pluginu
     * @param $data_rodo_process
     * @param $optin
     * @return bool
     */
    public function sendRodoInformation($data_rodo_process,$optin){
        $id_lang = (int) Configuration::get('PS_LANG_DEFAULT');
        $employee = new Employee($this->context->cookie->id_employee);

        if($data_rodo_process){
            if($optin){
                $subject = $this->l('[Presta] Zgoda - przetwarzanie');
                $extra_text_content = $this->l('Zgoda na przetwarzanie danych osobowych');
                $extra_text_footer = '';
            } else {
                $subject = $this->l('[Presta] Wycofanie zgody na przetwarzanie');
                $extra_text_content = $this->l('Wycofanie zgody na przetwarzanie danych osobwych');
                $extra_text_footer = $this->l('Pamiętaj o zaprzestaniu przetwarzania i usunięciu wszystkich danych klienta w ramach wtyczki do Prestashop!');
            }
        } else {
            if($optin){
                $subject = $this->l('[Presta] Zgoda - powiadomienia');
                $extra_text_content = $this->l('Zgoda na otrzymywanie powiadomień');
                $extra_text_footer = '';
            } else {
                $subject = $this->l('[Presta] Wycofanie zgody');
                $extra_text_content = $this->l('Wycofanie zgody na powiadomienia');
                $extra_text_footer = $this->l('Pamiętaj o usunięciu danych klienta z listy odbiorców powiadomień dla wtyczki!');
            }
        }
        $template_vars = array(
            '{www}' => $_SERVER['SERVER_NAME'],
            '{version}' => $this->version,
            '{karta}' => Configuration::get(PPSetting::PP_DEFAULT_KARTA_ID),
            '{email}' => Configuration::get('PS_SHOP_EMAIL'),
            '{name_surname}' => $employee->firstname.' '.$employee->lastname,
            '{subject}' => $subject,
            '{extra_text_content}'=>$extra_text_content,
            '{extra_text_footer}'=>$extra_text_footer
        );
        Mail::Send($id_lang, 'rodo', $template_vars['{subject}'] , $template_vars, PPSetting::PP_SUPPORT_EMAIL, null, null, null, null, null, dirname(__FILE__) . '/mails/');
        return true;
    }

    /**
     * metoda zwracajca przeslki PP
     * @param bool $query
     * @param string $prefix
     * @return array
     */
    public static function getPPPackages($query = true, $prefix = '') {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => $prefix.'pp_pocztex_48', 'name' => $module->l('Pocztex Kurier 48')),
            array('id' => $prefix.'pp_pocztex', 'name' => $module->l('Pocztex')),
            array('id' => $prefix.'pp_pocztex_2021_kurier', 'name' => $module->l('Pocztex 2.0 Kurier')),
            array('id' => $prefix.'pp_pocztex_2021_dzis', 'name' => $module->l('Pocztex 2.0 Na Dziś')),
            array('id' => $prefix.'pp_paczka_pocztowa', 'name' => $module->l('Paczka Pocztowa')),
            array('id' => $prefix.'pp_global_express', 'name' => $module->l('Global Express')),
            array('id' => $prefix.'pp_przesylka_polecona', 'name' => $module->l('Przesyłka polecona krajowa')),
            array('id' => $prefix.'pp_przesylka_firmowa', 'name' => $module->l('Przesyłka firmowa polecona')),
            array('id' => $prefix.'pp_paczka_ue', 'name' => $module->l('Zagraniczna paczka')),
            array('id' => $prefix.'pp_zagraniczna_przesylka', 'name' => $module->l('Zagraniczna przesyłka polecona')),
            array('id' => $prefix.'pp_ems_ue', 'name' => $module->l('EMS')),
        );
        if(!$query){
            $arr = array();
            foreach($packages as $package){
                $arr[$package['id']] = $package['name'];
            }
            $packages = $arr;
        }
        return $packages;
    }

    /**
     * metoda zwracajaca wszystkie uslugi PP
     * @return array
     */
    public static function getAllPPServices(){
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = self::getPPPackages(false);
        $packages['pp_pocztex_48'] = $module->l('Pocztex Kurier 48 - Standard');
        $packages['pp_pocztex_48_cod'] = $module->l('Pocztex Kurier 48 - Pobranie');
        $packages['pp_pocztex_48_pickup_at_point_standard'] = $module->l('Pocztex Kurier 48 - Odbiór w punkcie dla przesyłek opłaconych');
        $packages['pp_pocztex_48_pickup_at_point_cod'] = $module->l('Pocztex Kurier 48 - Odbiór w punkcie dla przesyłek pobraniowych');
        $packages['pp_pocztex_48_pickup_at_automat_standard'] = $module->l('Pocztex Kurier 48 - Odbiór w automacie dla przesyłek opłaconych');
        $packages['pp_pocztex_48_pickup_at_automat_cod'] = $module->l('Pocztex Kurier 48 - Odbiór w automacie dla przesyłek pobraniowych');

        $packages['pp_pocztex'] = $module->l('Pocztex - Standard');
        $packages['pp_pocztex_cod'] = $module->l('Pocztex - Pobranie');
        $packages['pp_pocztex_pickup_at_point_standard'] = $module->l('Pocztex - Odbiór w punkcie dla przesyłek opłaconych');
        $packages['pp_pocztex_pickup_at_point_cod'] = $module->l('Pocztex - Odbiór w punkcie dla przesyłek pobraniowych');
        $packages['pp_pocztex_pickup_at_automat_standard'] = $module->l('Pocztex - Odbiór w automacie dla przesyłek opłaconych');
        $packages['pp_pocztex_pickup_at_automat_cod'] = $module->l('Pocztex - Odbiór w automacie dla przesyłek pobraniowych');

        return $packages;
    }

    /**
     * metoda zwracajaca topic dla Pomocy
     * @return array
     */
    public static function getHelpThemes() {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => 'Sugestie', 'name' => $module->l('Sugestie')),
            array('id' => 'Problemy', 'name' => $module->l('Problemy')),
        );
        return $packages;
    }

    /**
     * metoda zwracajaca dostepne rozmiary dla przesylek
     * @return array
     */
    public static function getSizes() {
        $packages = array(
            array('id' => 'XS', 'name' => 'XS'),
            array('id' => 'S', 'name' => 'S'),
            array('id' => 'M', 'name' => 'M'),
            array('id' => 'L', 'name' => 'L'),
            array('id' => 'XL', 'name' => 'XL'),
            array('id' => 'XXL', 'name' => 'XXL'),
        );
        return $packages;
    }

    /**
     * metoda zwracajaca dostepne godziny doręczenia dla przesylek
     * @return array
     */
    public static function getGodzinaDoreczenia() {
        $packages = array(
            array('id' => '', 'name' => ''),
            array('id' => 'DO_GODZ_9', 'name' => 'Do godziny 9'),
            array('id' => 'DO_GODZ_12', 'name' => 'Do godziny 12'),
            array('id' => 'PO_GODZ_17', 'name' => 'Po godzinie 17'),
        );
        return $packages;
    }

    public static function getTypObszaru(){
        $packages = array(
            array('id' => 'MIASTO', 'name' => 'Miasto'),
            array('id' => 'KRAJ', 'name' => 'Kraj'),
        );
        return $packages;
    }

    /**
     * metoda zwracajaca dostepne typy potwierdzenia dla przesylek
     * @return array
     */
    public static function getTypPotwierdzeniaDoreczenia() {
        $packages = array(
            array('id' => '', 'name' => ''),
            array('id' => 'SMS', 'name' => 'SMS'),
            array('id' => 'EMAIL', 'name' => 'EMAIL'),
        );
        return $packages;
    }

    /**
     * metoda zwracajaca dostepne typy zawartości dla przesylek
     * @return array
     */
    public static function getTypZawartosci() {
        $packages = array(
            array('id' => '', 'name' => ''),
            array('id' => 'OWADY', 'name' => 'Owady'),
            array('id' => 'PLYNY_LUB_GAZY', 'name' => 'Płyny lub gazy'),
            array('id' => 'PRZEDMIOTY_LATWO_TLUKACE_SIE_I_SZKLO', 'name' => 'Przedmioty łatwo tłukące się i szkło'),
            array('id' => 'RZECZY_LAMLIWE_I_KRUCHE', 'name' => 'Rzeczy łamliwe i kruche'),
            array('id' => 'ZYWE_PTAKI', 'name' => 'Żywe ptaki'),
            array('id' => 'ZYWE_ROSLINY', 'name' => 'Żywe rośliny'),
            array('id' => 'INNE', 'name' => 'Inne'),
        );
        return $packages;
    }

    /**
     * metoda zwracajaca dostepne formaty dla przesylek
     * @return array
     */
    public static function getFormats() {
        $packages = array(
            array('id' => 'S', 'name' => 'S'),
            array('id' => 'M', 'name' => 'M'),
            array('id' => 'L', 'name' => 'L'),
            array('id' => 'XL', 'name' => 'XL'),
            array('id' => '2XL', 'name' => '2XL'),
        );
        return $packages;
    }

    public static function getOdbiorType() {
        $odbiorType = array(
            array('id' => '0', 'name' => 'Wybierz'),
            array('id' => '1', 'name' => 'Punkt'),
            array('id' => '2', 'name' => 'Automat'),
        );
        return $odbiorType;
    }

    /**
     * metoda zwracajaca typy uslug
     * @return array
     */
    public static function getKind() {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => 'standard', 'name' => $module->l('Standard')),
            array('id' => 'pobranie', 'name' => $module->l('Pobranie')),
        );
        return $packages;
    }

    /**
     * metoda zwracajaca wartosci ubezpieczen
     * @return array
     */
    public static function getWartoscUbezpieczenia() {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => '1000', 'name' => '1000'),
            array('id' => '5000', 'name' => '5000'),
            array('id' => '10000', 'name' => '10000'),
            array('id' => '20000', 'name' => '20000'),
            array('id' => '50000', 'name' => '50000'),
            array('id' => 'okreslona_wartosc', 'name' => $module->l('określona wartość')),
        );
        return $packages;
    }

    /**
     * metoda zwracajaca wartosci ubezpieczen dla Pocztexu
     * @return array
     */
    public static function getWartoscPocztexUbezpieczenia() {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => '5000', 'name' => '5000'),
            array('id' => '10000', 'name' => '10000'),
            array('id' => '20000', 'name' => '20000'),
            array('id' => '50000', 'name' => '50000'),
            array('id' => 'okreslona_wartosc', 'name' => $module->l('określona wartość')),
        );
        return $packages;
    }
    /**
     * metoda zwracajaca wartosci ubezpieczen dla Pocztexu Kurier 48
     * @return array
     */
    public static function getWartoscPocztex48Ubezpieczenia() {
        $packages = array(
            array('id' => '100', 'name' => '100'),
            array('id' => '200', 'name' => '200'),
        );
        return $packages;
    }
    /**
     * metoda zwracajaca wartosci ubezpieczen dla EMS
     * @return array
     */
    public static function getWartoscEmsUbezpieczenia() {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => '1000', 'name' => '1000'),
            array('id' => '10000', 'name' => '10000'),
            array('id' => '50000', 'name' => '50000'),
            array('id' => 'okreslona_wartosc', 'name' => $module->l('określona wartość')),
        );
        return $packages;
    }
    /**
     * metoda zwracajaca wartosci uslug kurierskich
     * @return array
     */
    public static function getSerwis() {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => 'EKSPRES24', 'name' => $module->l('KURIER EKSPRES 24')),
            array('id' => 'MIEJSKI_DO_3H_DO_5KM', 'name' => $module->l('KURIER MIEJSKI DO 3 GODZIN DO 5KM')),
            array('id' => 'MIEJSKI_DO_3H_DO_10KM', 'name' => $module->l('KURIER MIEJSKI DO 3 GODZIN DO 10KM')),
            array('id' => 'MIEJSKI_DO_3H_DO_15KM', 'name' => $module->l('KURIER MIEJSKI DO 3 GODZIN DO 15KM')),
            array('id' => 'MIEJSKI_DO_3H_POWYZEJ_15KM', 'name' => $module->l('KURIER MIEJSKI DO 3 GODZIN POWYŻEJ 15KM')),
            array('id' => 'MIEJSKI_DO_4H_DO_10KM', 'name' => $module->l('KURIER MIEJSKI DO 4 GODZIN DO 10KM')),
            array('id' => 'MIEJSKI_DO_4H_DO_15KM', 'name' => $module->l('KURIER MIEJSKI DO 4 GODZIN DO 15KM')),
            array('id' => 'MIEJSKI_DO_4H_DO_20KM', 'name' => $module->l('KURIER MIEJSKI DO 4 GODZIN DO 20KM')),
            array('id' => 'MIEJSKI_DO_4H_DO_30KM', 'name' => $module->l('KURIER MIEJSKI DO 4 GODZIN DO 30KM')),
            array('id' => 'MIEJSKI_DO_4H_DO_40KM', 'name' => $module->l('KURIER MIEJSKI DO 4 GODZIN DO 40KM')),
            array('id' => 'KRAJOWY', 'name' => $module->l('KURIER KRAJOWY')),
            array('id' => 'BEZPOSREDNI_DO_20KG', 'name' => $module->l('KURIER BEZPOŚREDNI DO 20KG')),
            array('id' => 'BEZPOSREDNI_OD_20KG_DO_30KG', 'name' => $module->l('KURIER BEZPOŚREDNI OD 20KG DO 30KG')),
            array('id' => 'BEZPOSREDNI_OD_30KG_DO_100KG', 'name' => $module->l('KURIER BEZPOŚREDNI OD 30KG DO 100KG')),
        );
        return $packages;
    }

    /**
     * metoda zwracajaca zawartosc przesylki
     * @return array
     */
    public static function getZawartoscPrzesylki() {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => 'Dokumenty', 'name' => $module->l('Dokumenty')),
            array('id' => 'Kosmetyki', 'name' => $module->l('Kosmetyki')),
            array('id' => 'Elektronika', 'name' => $module->l('Elektronika')),
            array('id' => 'Zabawki', 'name' => $module->l('Zabawki')),
            array('id' => 'Części samochodowe', 'name' => $module->l('Części samochodowe')),
            array('id' => 'Chemia', 'name' => $module->l('Chemia')),
            array('id' => 'Meble', 'name' => $module->l('Meble')),
        );
        return $packages;
    }
    /**
     * metoda zwracajaca zawartosc przesylki dla Globala
     * @return array
     */
    public static function getZawartoscGlobalPrzesylki() {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => 'Korespondencja', 'name' => $module->l('Korespondencja')),
            array('id' => 'Pozostałe', 'name' => $module->l('Pozostałe')),
        );
        return $packages;
    }
    /**
     * metoda zwracajaca dane kto uiszcza oplate
     * @return array
     */
    public static function getUiszczaOplate() {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => 'NADAWCA', 'name' => $module->l('Nadawca')),
            array('id' => 'ADRESAT', 'name' => $module->l('Adresat')),
        );
        return $packages;
    }
    /**
     * metoda zwracajaca godziny dostaw
     * @return array
     */
    public static function getGodzina() {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => 'DO 8:00', 'name' => $module->l('DO 8:00')),
            array('id' => 'DO 9:00', 'name' => $module->l('DO 9:00')),
            array('id' => 'DO 12:00', 'name' => $module->l('DO 12:00')),
            array('id' => 'NA 13:00', 'name' => $module->l('NA 13:00')),
            array('id' => 'NA 14:00', 'name' => $module->l('NA 14:00')),
            array('id' => 'NA 15:00', 'name' => $module->l('NA 15:00')),
            array('id' => 'NA 16:00', 'name' => $module->l('NA 16:00')),
            array('id' => 'NA 17:00', 'name' => $module->l('NA 17:00')),
            array('id' => 'NA 18:00', 'name' => $module->l('NA 18:00')),
            array('id' => 'NA 19:00', 'name' => $module->l('NA 19:00')),
            array('id' => 'NA 20:00', 'name' => $module->l('NA 20:00')),
            array('id' => 'PO 17:00', 'name' => $module->l('PO 17:00')),
        );
        return $packages;
    }
    /**
     * metoda zwracajaca sposob pobrania
     * @return array
     */
    public static function getSposobPobrania() {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => 'RACHUNEK_BANKOWY', 'name' => $module->l('Rachunek bankowy')),
            array('id' => 'PRZEKAZ', 'name' => $module->l('Przekaz pocztowy')),
        );
        return $packages;
    }
    /**
     * metoda zwracajaca typ potwierdzenia
     * @return array
     */
    public static function getTypPotwierdzenia() {
        $packages = array(
            array('id' => 'SMS', 'name' => 'SMS'),
            array('id' => 'EMAIL', 'name' => 'EMAIL'),
        );
        return $packages;
    }
    /**
     * metoda zwracajaca rodzaj potwierdzenia
     * @return array
     */
    public static function getRodzajPotwierdzenia() {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => 'LIST_ZWYKLY_PRIORYTETOWY', 'name' => $module->l('LIST ZWYKŁY PRIORYTETOWY')),
            array('id' => 'EKSPRES24', 'name' => $module->l('KURIER EKSPRESS 24')),
            array('id' => 'MIEJSKI_DO_3H_DO_5KM', 'name' => $module->l('KURIER MIEJSKI DO 3 GODZIN DO 5 KM')),
            array('id' => 'MIEJSKI_DO_3H_DO_10KM', 'name' => $module->l('KURIER MIEJSKI DO 3 GODZIN DO 10 KM')),
            array('id' => 'MIEJSKI_DO_3H_DO_15KM', 'name' => $module->l('KURIER MIEJSKI DO 3 GODZIN DO 15 KM')),
            array('id' => 'MIEJSKI_DO_3H_POWYZEJ_15KM', 'name' => $module->l('KURIER MIEJSKI DO 3 GODZIN POWYŻEJ 15 KM')),
            array('id' => 'BEZPOSREDNI_DO_20KG', 'name' => $module->l('KURIER BEZPOŚREDNI DO 20 GODZIN')),
            array('id' => 'PACZKA_24', 'name' => $module->l('PACZKA 24')),
            array('id' => 'PACZKA_48', 'name' => $module->l('PACZKA 48')),
        );
        return $packages;
    }
    /**
    * metoda zwracajaca rodzaj potwierdzenia dla paczki biznesowej
    * @return array
    */
    public static function getRodzajPotwierdzeniaBiznes() {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => 'LIST_ZWYKLY_PRIORYTETOWY', 'name' => $module->l('LIST ZWYKŁY PRIORYTETOWY')),
            array('id' => 'EKSPRES24', 'name' => $module->l('KURIER EKSPRESS 24')),
        );
        return $packages;
    }
    /**
     * metoda zwracajaca rodzaj potwierdzenia dla dokumentow
     * @return array
     */
    public static function getDokumentyRodzajPotwierdzenia() {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => 'LIST_ZWYKLY_PRIORYTETOWY', 'name' => $module->l('LIST ZWYKŁY PRIORYTETOWY')),
            array('id' => 'LIST_ZWYKLY_EKONOMICZNY', 'name' => $module->l('LIST ZWYKŁY EKONOMICZNY')),
            array('id' => 'LIST_POLECONY_PRIORYTETOWY', 'name' => $module->l('LIST POLECONY PRIORYTETOWY')),
            array('id' => 'LIST_POLECONY_EKONOMICZNY', 'name' => $module->l('LIST POLECONY EKONOMICZNY')),
            array('id' => 'EKSPRES24', 'name' => $module->l('KURIER EKSPRESS 24')),
            array('id' => 'MIEJSKI_DO_3H_DO_5KM', 'name' => $module->l('KURIER MIEJSKI DO 3 GODZIN DO 5 KM')),
            array('id' => 'MIEJSKI_DO_3H_DO_10KM', 'name' => $module->l('KURIER MIEJSKI DO 3 GODZIN DO 10 KM')),
            array('id' => 'MIEJSKI_DO_3H_DO_15KM', 'name' => $module->l('KURIER MIEJSKI DO 3 GODZIN DO 15 KM')),
            array('id' => 'MIEJSKI_DO_3H_POWYZEJ_15KM', 'name' => $module->l('KURIER MIEJSKI DO 3 GODZIN POWYŻEJ 15 KM')),
            array('id' => 'BEZPOSREDNI_DO_20KG', 'name' => $module->l('KURIER BEZPOŚREDNI DO 20 GODZIN')),
            array('id' => 'PACZKA_24', 'name' => $module->l('PACZKA 24')),
            array('id' => 'PACZKA_48', 'name' => $module->l('PACZKA 48')),
        );
        return $packages;
    }
    /**
     * metoda zwracajaca rodzaj potwierdzenia dla dokumentow
     * @return array
     */
    public static function getDokumentyRodzajPotwierdzeniaBiznes() {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => 'LIST_ZWYKLY_PRIORYTETOWY', 'name' => $module->l('LIST ZWYKŁY PRIORYTETOWY')),
            array('id' => 'LIST_ZWYKLY_EKONOMICZNY', 'name' => $module->l('LIST ZWYKŁY EKONOMICZNY')),
            array('id' => 'LIST_POLECONY_PRIORYTETOWY', 'name' => $module->l('LIST POLECONY PRIORYTETOWY')),
            array('id' => 'LIST_POLECONY_EKONOMICZNY', 'name' => $module->l('LIST POLECONY EKONOMICZNY')),
            array('id' => 'EKSPRES24', 'name' => $module->l('KURIER EKSPRESS 24')),
        );
        return $packages;
    }
    /**
     * metoda zwracajaca wyslane do
     * @return array
     */
    public static function getWyslaneDo() {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => 'dane nadawcy', 'name' => $module->l('dane nadawcy')),
        );
        return $packages;
    }
    /**
     * metoda zwracajaca wyslane do
     * @return array
     */
    public static function getWyslaneDoBiznes() {
        $profileAddresses = PPProfileAddress::getCollection(true);
        $packages = array(
            array('id' => 'dane nadawcy', 'name' => 'dane nadawcy'),
        );
        foreach($profileAddresses as $address){
            $packages[] = array('id' => $address['id_en'], 'name' => $address['friendly_name']);
        }

        return $packages;
    }
    /**
     * metoda zwracajaca wartosci dla przesylki
     * @return array
     */
    public static function getWartosci() {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => 'ADMINISTRACYJNA', 'name' => $module->l('Administracyjne')),
            array('id' => 'SADOWA_CYWILNA', 'name' => $module->l('Cywilne')),
            array('id' => 'PODATKOWA', 'name' => $module->l('Podatkowe')),
            array('id' => 'SADOWA_KARNA', 'name' => $module->l('Karne')),
        );
        return $packages;
    }
    /**
     * metoda zwracajaca urzedy nadania
     * @return array
     */
    public static function getPostingOffices($param = '', $val = '') {
        $arr = ENadawca::UrzedyNadania()->get();
        if(isset($arr['urzadNadania'])){
            $arr = array($arr);
        }
        $arrTmp = array();
        if ($param == 'query') {
            if(!empty($arr))
            foreach ($arr as $k => $v) {
                $name = (isset($v['nazwaWydruk'])&&!empty($v['nazwaWydruk']))?$v['nazwaWydruk']:$v['opis'];
                if(empty($name)&&isset($v['urzadNadania'])){
                    $name = $v['urzadNadania'];
                }
                $arrTmp[] = array('id' => $v['urzadNadania'], 'name' => $name);
            }
            $arr = $arrTmp;
        }
        else if ($param === 'list') {
            foreach ($arr as $k => $v) {
                $arrTmp[$v['urzadNadania']]= $v['nazwaWydruk'];
            }
            $arr = $arrTmp;
        }
        if($val!==''){
            return $arr[$val]['name'];
        }
        return $arr;
    }
    /**
     * metoda zwracajaca typy zbiorow
     * @return array
     */
    public static function getSets($query = false) {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => '', 'name' => ''),
            array('id' => 'open', 'name' => '2018-05-21/1'),
            array('id' => 'pobranie', 'name' => '2018-05-21/2'),
        );
        $arr = array(
            'open' => $module->l('Otwarty'),
            'send' => $module->l('Wysłany'),
            'get' => $module->l('Odebrany'),
        );
        $arrTmp = array();
        if ($query) {
            foreach ($arr as $k => $v) {
                $arrTmp[] = array('id' => $k, 'name' => $v);
            }
            $arr = $arrTmp;
        }

        return $arr;
    }
    /**
     * metoda zwracajaca typ przesylki
     * @return array
     */
    public static function getPaczka() {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => 'EKONOMICZNA', 'name' => $module->l('Ekonomiczna')),
            array('id' => 'PRIORYTETOWA', 'name' => $module->l('Priorytet')),
        );
        return $packages;
    }
    /**
     * metoda zwracajaca gabaryt przesylki
     * @return array
     */
    public static function getGabaryt() {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => 'GABARYT_A', 'name' => $module->l('Gabaryt A')),
            array('id' => 'GABARYT_B', 'name' => $module->l('Gabaryt B')),
        );
        return $packages;
    }
    /**
     * metoda zwracajaca format przesylki
     * @return array
     */
    public static function getFormat() {
        $packages = array(
            array('id' => 'S', 'name' => 'S'),
            array('id' => 'M', 'name' => 'M'),
            array('id' => 'L', 'name' => 'L'),
        );
        return $packages;
    }
    /**
     * metoda zwracajaca miejsce dostarczenia
     * @return array
     */
    public static function getMiejscowaZamiejscowa() {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => '1', 'name' => $module->l('Miejscowa')),
            array('id' => '0', 'name' => $module->l('Zamiejscowa')),
        );
        return $packages;
    }
    /**
     * metoda zwracajaca miejsce dostarczenia
     * @return array
     */
    public static function getMiastoWies() {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => '',  'name'=>''),
            array('id' => '1', 'name' => $module->l('Miasto')),
            array('id' => '0', 'name' => $module->l('Wieś')),
        );
        return $packages;
    }
    /**
     * metoda zwracajaca typ zwrotu
     * @return array
     */
    public static function getZwrot() {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => 'zwrot_natychmiast', 'name' => $module->l('zwrot natychmiast')),
            array('id' => 'zwrot_po_liczbie_dni', 'name' => $module->l('zwrot po liczbie dni')),
            array('id' => 'traktowac_jak_porzucona', 'name' => $module->l('Traktować jak porzuconą')),
        );
        return $packages;
    }
    /**
     * metoda zwracajaca sposob zwrotu
     * @return array
     */
    public static function getSposobZwrot() {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => 'LADOWO_MORSKA', 'name' => $module->l('Lądowo morska (S.A.L)')),
            array('id' => 'LOTNICZA', 'name' => $module->l('Lotnicza')),
        );
        return $packages;
    }
    /**
     * metoda zwracajaca typ opakowania
     * @return array
     */
    public static function getTypOpakowania() {
        $module = Module::getInstanceByName('pocztapolskaen');
        $packages = array(
            array('id' => 'ZWYKLY', 'name' => $module->l('Własne')),
            array('id' => 'DOKUMENT_PACK', 'name' => $module->l('Document pack')),
            array('id' => 'KILO_PACK', 'name' => $module->l('Kilo pack')),
        );
        return $packages;
    }

    /**
     * metoda zwracajaca godziny odbioru
     * @param string $val
     * @return array
     */
    public static function getReceptionTime($val = '') {
        $module = Module::getInstanceByName('pocztapolskaen');
        $id = 0;
        $hours = array(
            array('id' => $id, 'name' => $module->l('downlona między 08:00 a 20:00'))
        );
        for ($i = 8; $i <= 20; $i = $i + 2) {
            $id++;
            $hours[$id]['id'] = $id;
            $hours[$id]['name'] = $i . ':00 - ' . ($i + 2) . ':00';
        }
        if($val!==''){
            return $hours[$val]['name'];
        }
        return $hours;
    }

    public function getLocalPath(){
      return $this->local_path;
    }

    public function reloadSelectedCarrierConfig(){
        Db::getInstance()->execute('
			UPDATE
			    `' . _DB_PREFIX_ . 'carrier`
			SET
			    external_module_name = "",
			    is_module = "0",
                shipping_external = "0",
                need_range = "0"
			WHERE
			    external_module_name = "' . $this->name .'"'
        );


        $pickupCarriers = array_merge(PPSetting::getPickupUpAtPoint(), PPSetting::getPickupUpAtAutomat());

        if($pickupCarriers && count($pickupCarriers)){
            $this->setShippingExternal($pickupCarriers);
        }

        $pickupCarriersCOD = array_merge(PPSetting::getPickupUpAtPoint(true), PPSetting::getPickupUpAtAutomat(true));
        if($pickupCarriersCOD && count($pickupCarriersCOD)){
            $this->setShippingExternal($pickupCarriersCOD);
        }
    }

    public function setShippingExternal($tab){
        foreach($tab as $carrierId){
            Db::getInstance()->execute('
			UPDATE
			    `' . _DB_PREFIX_ . 'carrier`
			SET
			    external_module_name = "'.$this->name.'",
			    is_module = "1",
                shipping_external = "1",
                need_range = "1"
			WHERE
			    id_carrier = ' . $carrierId . ' OR
			    id_reference = ' . $carrierId
            );
        }
    }
}
