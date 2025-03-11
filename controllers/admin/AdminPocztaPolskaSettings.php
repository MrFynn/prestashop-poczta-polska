<?php

class AdminPocztaPolskaSettingsController extends ModuleAdminController {
    public $tabConfigValues = [];
    public $servicesTab = [];

    public function __construct() {
        $this->module = 'pocztapolskaen';
        $this->context = Context::getContext();
        $this->bootstrap = true;
        $this->user_info = array();
        $this->tab_carriers = array();

        parent::__construct();

        $this->tabConfigValues = [
            PPPackage::PP_POCZTEX_48_DELIVERY,
            PPPackage::PP_POCZTEX_48_DELIVERY_COD,
            PPPackage::PP_POCZTEX_DELIVERY,
            PPPackage::PP_POCZTEX_DELIVERY_COD,
            PPPackage::PP_PACZKA_POCZTOWA_DELIVERY,
            PPPackage::PP_GLOBAL_EXPRESS_DELIVERY,
            PPPackage::PP_PRZESYLKA_POLECONA_DELIVERY,
            PPPackage::PP_PRZESYLKA_FIRMOWA_DELIVERY,
            PPPackage::PP_PACZKA_UE_DELIVERY,
            PPPackage::PP_ZAGRANICZNA_PRZESYLKA_DELIVERY,
            PPPackage::PP_EMS_UE_DELIVERY,
            PPPackage::PP_POCZTEX_48_PICKUP_AT_POINT_STANDARD,
            PPPackage::PP_POCZTEX_48_PICKUP_AT_POINT_COD,
            PPPackage::PP_POCZTEX_48_PICKUP_AT_AUTOMAT_STANDARD,
            PPPackage::PP_POCZTEX_48_PICKUP_AT_AUTOMAT_COD,
            PPPackage::PP_POCZTEX_PICKUP_AT_POINT_STANDARD,
            PPPackage::PP_POCZTEX_PICKUP_AT_POINT_COD,
            PPPackage::PP_POCZTEX_PICKUP_AT_AUTOMAT_STANDARD,
            PPPackage::PP_POCZTEX_PICKUP_AT_AUTOMAT_COD,
            PPPackage::PP_POCZTEX_2021_KURIER_DELIVERY,
            PPPackage::PP_POCZTEX_2021_KURIER_DELIVERY_COD,
            PPPackage::PP_POCZTEX_2021_KURIER_PICKUP_AT_POINT_STANDARD,
            PPPackage::PP_POCZTEX_2021_KURIER_PICKUP_AT_POINT_COD,
            PPPackage::PP_POCZTEX_2021_KURIER_PICKUP_AT_AUTOMAT_STANDARD,
            PPPackage::PP_POCZTEX_2021_KURIER_PICKUP_AT_AUTOMAT_COD,

            PPPackage::PP_POCZTEX_2021_DZIS_DELIVERY,
            PPPackage::PP_POCZTEX_2021_DZIS_DELIVERY_COD,
        ];

        $this->servicesTab = [
            PPPackage::PP_POCZTEX_2021_KURIER_OPIS_PRZESYLKI,
            PPPackage::PP_POCZTEX_2021_KURIER_NADANIE_U_KURIERA,
            PPPackage::PP_POCZTEX_2021_KURIER_FORMAT,
            PPPackage::PP_POCZTEX_2021_KURIER_POBRANIE,
            PPPackage::PP_POCZTEX_2021_KURIER_NUMER_RACHUNKU,
            PPPackage::PP_POCZTEX_2021_KURIER_TYTUL_POBRANIA,
            PPPackage::PP_POCZTEX_2021_KURIER_PONADGABARYT,
            PPPackage::PP_POCZTEX_2021_KURIER_KOPERTA_POCZTEX,
            PPPackage::PP_POCZTEX_2021_KURIER_GODZINA_DORECZENIA,
            PPPackage::PP_POCZTEX_2021_KURIER_ODBIOR_SOBOTA,
            PPPackage::PP_POCZTEX_2021_KURIER_POTWIERDZENIE_DORECZENIA,
            PPPackage::PP_POCZTEX_2021_KURIER_POTWIERDZENIE_DORECZENIA_TYPE,
            PPPackage::PP_POCZTEX_2021_KURIER_POTWIERDZENIE_DORECZENIA_KONTAKT,
            PPPackage::PP_POCZTEX_2021_KURIER_TYP_ZAWARTOSCI,
            PPPackage::PP_POCZTEX_2021_KURIER_TYP_ZAWARTOSCI_INNE,
            PPPackage::PP_POCZTEX_2021_KURIER_DEKLARACJA_WARTOSCI,
            PPPackage::PP_POCZTEX_2021_KURIER_WARTOSC_ZL,
            PPPackage::PP_POCZTEX_2021_KURIER_MASA,
            PPPackage::PP_POCZTEX_2021_KURIER_UBEZPIECZENIE,
            PPPackage::PP_POCZTEX_2021_KURIER_WARTOSC_UBEZPIECZENIA,
            PPPackage::PP_POCZTEX_2021_KURIER_OKRESLONA_WARTOSC,
            PPPackage::PP_POCZTEX_2021_KURIER_OSTROZNIE,
            PPPackage::PP_POCZTEX_2021_KURIER_ODBIORCA,

            PPPackage::PP_POCZTEX_2021_DZIS_OPIS_PRZESYLKI,
            PPPackage::PP_POCZTEX_2021_DZIS_FORMAT,
            PPPackage::PP_POCZTEX_2021_DZIS_POBRANIE,
            PPPackage::PP_POCZTEX_2021_DZIS_NUMER_RACHUNKU,
            PPPackage::PP_POCZTEX_2021_DZIS_TYTUL_POBRANIA,
            PPPackage::PP_POCZTEX_2021_DZIS_PONADGABARYT,
            PPPackage::PP_POCZTEX_2021_DZIS_ODBIOR_SOBOTA,
            PPPackage::PP_POCZTEX_2021_DZIS_POTWIERDZENIE_DORECZENIA,
            PPPackage::PP_POCZTEX_2021_DZIS_POTWIERDZENIE_DORECZENIA_TYPE,
            PPPackage::PP_POCZTEX_2021_DZIS_POTWIERDZENIE_DORECZENIA_KONTAKT,
            PPPackage::PP_POCZTEX_2021_DZIS_TYP_ZAWARTOSCI,
            PPPackage::PP_POCZTEX_2021_DZIS_TYP_ZAWARTOSCI_INNE,
            PPPackage::PP_POCZTEX_2021_DZIS_DEKLARACJA_WARTOSCI,
            PPPackage::PP_POCZTEX_2021_DZIS_WARTOSC_ZL,
            PPPackage::PP_POCZTEX_2021_DZIS_MASA,
            PPPackage::PP_POCZTEX_2021_DZIS_UBEZPIECZENIE,
            PPPackage::PP_POCZTEX_2021_DZIS_WARTOSC_UBEZPIECZENIA,
            PPPackage::PP_POCZTEX_2021_DZIS_OKRESLONA_WARTOSC,
            PPPackage::PP_POCZTEX_2021_DZIS_OSTROZNIE,
            PPPackage::PP_POCZTEX_2021_DZIS_ODBIORCA,
            PPPackage::PP_POCZTEX_2021_DZIS_OBSZAR,
        ];

        $tabCarriers = Carrier::getCarriers($this->context->language->id, false, false, false, null, Carrier::ALL_CARRIERS);
        if(count($tabCarriers)){
            foreach($tabCarriers as $carrier){
                if($carrier['is_module'] == 0 || $carrier['external_module_name'] == $this->module->name){
                    $this->tab_carriers[] = $carrier;
                }
            }
        }
    }

    /**
     * metoda generujaca content dla widoku controllera
     *
     * @return string - html
     */
    public function initContent() {
       /* $tab = ENadawca::Profil()->getReturnDocumentsProfileList();
        var_dump($tab['profile'][]);
        exit;*/
        $fields_form = $this->getFormFields();

        $helper = new HelperForm();

        $helper->show_toolbar = false;
        $helper->module = $this->module;
        $helper->submit_action = 'action';
        $helper->default_form_language = $this->context->language->id;

        $helper->tpl_vars = array(
            'fields_value' => $this->getValues(),
            'languages' => $this->context->controller->getLanguages(),
            'id_language' => $this->context->language->id,
            'active_tab' => Tools::getIsset('action') ? Tools::getValue('action') : 'settings'
        );

        $form = $helper->generateForm($fields_form);
        $this->content .= $form;
        return parent::initContent();
    }
    /**
     * metoda przygotowujaca dane do wygenerowania tabeli z zakladkami
     * @return array
     */
    public function getFormFields() {
        $fields_form = array();
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => $this->l('Ustawienia'),
                'icon' => 'icon-settings'
            ),
            'tabs' => array(
                'settings' => $this->l('Moje konto'),
                'statuses' => $this->l('Statusy'),
                'delivery' => $this->l('Dostawa'),
                'services' => $this->l('Usługi'),
                'help' => $this->l('Pomoc'),
            ),
            'input' => array_merge($this->getMyAccountTab(), $this->getStatusesTab(), $this->getDeliveryTab(), $this->getServicesTab(), $this->getHelpTab()),
        );

        return $fields_form;
    }
    /**
     * metoda przygotowujaca dane do formularza w zakladce Moje konto
     * @return array
     */
    private function getMyAccountTab() {

        $user_info = false;
        $offices = array();
        $carts = array();
        if (!Tools::isEmpty(Configuration::get(PPSetting::PP_USER)) &&
                !Tools::isEmpty(Configuration::get(PPSetting::PP_PASSWORD))) {


            if((int)Configuration::get(PPSetting::PP_IS_CONNECTED)&& (ENadawca::Account()->hello())!== false){
                $account = ENadawca::Account();
                $this->user_info = $account->getMyAccount();

                $office = ENadawca::UrzedyNadania();
                $offices = PPPostOffice::getCollection(true);
                if (empty($offices)) {
                    PPPostOffice::reloadData();
                    PPPostOffice::clearCollection();
                    PPProfileAddress::reloadData();
                    $offices = PPPostOffice::getCollection(true);
                }
                $carts = PPSetting::getCarts();
            } else {
                $this->errors[] = $this->l('Podaj poprawny login i hasło');
                $this->confirmations = array();
            }

        }


        if (count($carts) > 0 && !Configuration::get(PPSetting::PP_DEFAULT_KARTA_ID)) {
            Configuration::updateValue(PPSetting::PP_DEFAULT_KARTA_ID, $carts[0]['id']);
            Configuration::updateValue(PPSetting::PP_DEFAULT_KARTA_NAME, $carts[0]['name']);
        }
        if (count($offices) > 0 && !Configuration::get(PPSetting::PP_DEFAULT_URZAD_ID)) {
            Configuration::updateValue(PPSetting::PP_DEFAULT_URZAD_ID, $offices[0]['id']);
        }
        $myAccount = array(
            array(
                'type' => 'text',
                'prefix' => '<i class="icon icon-envelope"></i>',
                'name' => PPSetting::PP_USER,
                'label' => $this->l('Użytkownik'),
                'class' => 'fixed-width-xxl',
                'tab' => 'settings',
                'desc' => $this->l('Dane dostępowe uzyskasz rejestrując sie w serwisie ') . '<a href="https://e-nadawca.poczta-polska.pl/" target="_blank">'.$this->l('Poczta Polska').'</a>',
            ),
            array(
                'type' => 'password',
                'name' => PPSetting::PP_PASSWORD,
                'prefix' => '<i class="icon icon-key"></i>',
                'label' => $this->l('Hasło'),
                'class' => 'fixed-width-xxl',
                'tab' => 'settings',
                'desc' => $this->l('Zaloguj sie używając danych do Elektronicznego Nadawcy'),
            ),
            array(
                'type' => 'text',
                'name' => PPSetting::PP_PASSWORD_NEW,
                'prefix' => '<i class="icon icon-key"></i>',
                'label' => $this->l('Nowe hasło'),
                'tab' => 'settings',
                'class' => 'fixed-width-xxl',
                'hint' => $this->l('Hasło powinno posiadać przynajmniej 8 znaków, jedną cyfrę, jedną dużą literę, jedną małą literę'),
                'form_group_class' => 'new_pass'
            ),
            array(
                'type' => 'text',
                'name' => PPSetting::PP_PASSWORD_NEW_REPEAT,
                'prefix' => '<i class="icon icon-key"></i>',
                'label' => $this->l('Powtórz hasło'),
                'tab' => 'settings',
                'class' => 'fixed-width-xxl',
                'form_group_class' => 'new_pass'
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Konto testowe'),
                'name' => PPSetting::PP_TEST_URL,
                'values' => array(
                    array(
                        'id' => PPSetting::PP_TEST_URL . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPSetting::PP_TEST_URL . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'settings',
            ),

            array(
                'type' => 'select',
                'label' => $this->l('Karta Umowy'),
                'name' => PPSetting::PP_DEFAULT_KARTA_ID,
                'options' => array(
                    'query' => $carts,
                    'id' => 'id',
                    'name' => 'name'
                ),
                'tab' => 'settings',
                'form_group_class' => 'default_karta'
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Urząd nadania'),
                'name' => PPSetting::PP_DEFAULT_URZAD_ID,
                'options' => array(
                    'query' => $offices,
                    'id' => 'id',
                    'name' => 'name'
                ),
                'tab' => 'settings',
                'form_group_class' => 'default_karta'
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'hide_label'=>true,
                'col'=>12,
                'tab' => 'settings',
                'html_content' => '<a href="#modal_rodo_content" data-toggle="modal">'.$this->l('Informacja o przetwarzanych danych osobowych w ramach oprogramowania').'</a>',
            ),
            array(
                'type' => 'checkbox',
                'col'=>12,
                'hide_label'=>true,
                'name' => PPPackage::PP_POCZTEX_OSTROZNIE,
                'values' => array(
                    'query' => array(
                        array('id' => PPSetting::PP_PROCESS_DATA_RODO, 'name' => $this->l('Wyrażam zgodę na przetwarzanie moich danych osobowych w zakresie i w sposób określony w pkt II.'), 'val' => '1','label_class'=>'required'),
                        array('id' => PPSetting::PP_PROCESS_INFORMATION_RODO, 'name' => $this->l('Wyrażam zgodę na otrzymywanie powiadomień o nowych wersjach oprogramowania na mój adres e-mail.'), 'val' => '1'),
                    ),
                    'id' => 'id',
                    'name' => 'name'
                ),
                'tab' => 'settings',
            ),
            array(
                'type' => 'text',
                'name' => 'profil_first_name',
                'disabled' => true,
                'label' => $this->l('Imię'),
                'tab' => 'settings',
                'form_group_class' => 'my_account_info'
            ),
            array(
                'type' => 'text',
                'name' => 'profil_last_name',
                'disabled' => true,
                'label' => $this->l('Nazwisko'),
                'tab' => 'settings',
                'form_group_class' => 'my_account_info'
            ),
            array(
                'type' => 'text',
                'name' => 'profil_email',
                'disabled' => true,
                'label' => $this->l('Email'),
                'tab' => 'settings',
                'form_group_class' => 'my_account_info'
            ),
            array(
                'type' => 'text',
                'name' => 'profil_name',
                'disabled' => true,
                'label' => $this->l('Firma'),
                'tab' => 'settings',
                'form_group_class' => 'my_account_info'
            ),
            array(
                'type' => 'text',
                'name' => 'profil_ulica',
                'disabled' => true,
                'label' => $this->l('Ulica'),
                'tab' => 'settings',
                'form_group_class' => 'my_account_info'
            ),
            array(
                'type' => 'text',
                'name' => 'profil_miejscowosc',
                'disabled' => true,
                'label' => $this->l('Miejscowość'),
                'tab' => 'settings',
                'form_group_class' => 'my_account_info'
            ),
            array(
                'type' => 'text',
                'name' => 'profil_kraj',
                'disabled' => true,
                'label' => $this->l('Kraj'),
                'tab' => 'settings',
                'form_group_class' => 'my_account_info2'
            ),
            array(
                'type' => 'text',
                'name' => 'profil_telefon',
                'disabled' => true,
                'label' => $this->l('Telefon'),
                'tab' => 'settings',
                'form_group_class' => 'my_account_info2'
            ),
            array(
                'type' => 'text',
                'name' => 'profil_mobile',
                'disabled' => true,
                'label' => $this->l('Telefon kom.'),
                'tab' => 'settings',
                'form_group_class' => 'my_account_info2'
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Urzędy nadania'),
                'name' => 'profil_offices[]',
                'tab' => 'settings',
                'multiple' => true,
                'disabled' => true,
                'options' => array(
                    'query' => $offices,
                    'id' => 'id',
                    'name' => 'name'
                ),
                'form_group_class' => 'my_account_info2'
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'html_content' => '<button type="button" data-name="settings" class="btn btn-default btn-settings">' . $this->l('Zapisz ustawienia') . '</button> <button type="button" class="btn btn-default show-password" >' . $this->l('Zmień hasło') . '</button>',
                'tab' => 'settings',
            ),
        );
        return $myAccount;
    }
    /**
     * metoda przygotowujaca dane do formularza w zakladce Statusy
     * @return array
     */
    private function getStatusesTab() {
        $statusesTab = array(
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '',
                'html_content' => '<div class="alert alert-info">' . $this->l('Włączenie poniższych opcji spowoduje automatyczną zmianę statusu zamówienia') . '</div>',
                'tab' => 'statuses',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Czy status zamówienia ma sie zmieniać po utworzeniu przesyłki?'),
                'name' => PPSetting::PP_IS_STATUS_CREATE,
                'values' => array(
                    array(
                        'id' => PPSetting::PP_IS_STATUS_CREATE . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPSetting::PP_IS_STATUS_CREATE . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'statuses',
                'form_group_class' => 'statuses toggle_rows'
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Status zamówienia dla utworzonych przesyłek'),
                'name' => PPSetting::PP_STATUS_CREATE,
                'options' => array(
                    'query' => OrderState::getOrderStates($this->context->language->id),
                    'id' => 'id_order_state',
                    'name' => 'name'
                ),
                'tab' => 'statuses',
                'form_group_class' => 'statuses ' . PPSetting::PP_IS_STATUS_CREATE . ' 1'
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Czy status zamówienia ma sie zmieniać po wygenerowaniu etykiety?'),
                'name' => PPSetting::PP_IS_STATUS_PRINT_LABEL,
                'values' => array(
                    array(
                        'id' => PPSetting::PP_IS_STATUS_PRINT_LABEL . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPSetting::PP_IS_STATUS_PRINT_LABEL . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'statuses',
                'form_group_class' => 'statuses toggle_rows'
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Status zamówienia dla przygotowanych przesyłek'),
                'name' => PPSetting::PP_STATUS_PRINT_LABEL,
                'options' => array(
                    'query' => OrderState::getOrderStates($this->context->language->id),
                    'id' => 'id_order_state',
                    'name' => 'name'
                ),
                'tab' => 'statuses',
                'form_group_class' => 'statuses ' . PPSetting::PP_IS_STATUS_PRINT_LABEL . ' 1'
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Czy status zamówienia ma się zmieniać po przesłaniu zbioru do urzędu? '),
                'name' => PPSetting::PP_IS_STATUS_OFFICE_SEND,
                'values' => array(
                    array(
                        'id' => PPSetting::PP_IS_STATUS_OFFICE_SEND . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPSetting::PP_IS_STATUS_OFFICE_SEND . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'statuses',
                'form_group_class' => 'statuses toggle_rows'
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Status zamówienia dla wysłanych przesyłek'),
                'name' => PPSetting::PP_STATUS_OFFICE_SEND,
                'options' => array(
                    'query' => OrderState::getOrderStates($this->context->language->id),
                    'id' => 'id_order_state',
                    'name' => 'name'
                ),
                'tab' => 'statuses',
                'form_group_class' => 'statuses ' . PPSetting::PP_IS_STATUS_OFFICE_SEND . ' 1'
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'html_content' => '<button type="button" data-name="statuses" class="btn btn-default btn-settings">' . $this->l('Zapisz ustawienia') . '</button>',
                'tab' => 'statuses',
            ),
        );
        return $statusesTab;
    }
    /**
     * metoda przygotowujaca dane do formularza w zakladce Dostawwa
     * @return array
     */
    private function getDeliveryTab() {
        $delivery = array(
            array(
                'type' => 'select',
                'label' => $this->l('Wybierz usługę Poczty Polskiej'),
                'name' => PPPackage::PP_PACKAGES_CON,
                'tab' => 'delivery',
                'class' => 'fixed-width-xxl',
                'form_group_class' => 'delivery packages toggle_rows',
                'options' => array(
                    'query' => PocztaPolskaEn::getPPPackages(true, 'delivery_'),
                    'id' => 'id',
                    'name' => 'name',
                ),
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('Powiąż z wysyłkami Twojego Sklepu') . '</b><hr>',
                'html_content' => '',
                'tab' => 'delivery',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Powiąż z metodą dostawy w Twoim sklepie - Standard'),
                'name' => PPPackage::PP_POCZTEX_48_DELIVERY.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX_48
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Powiąż z metodą dostawy w Twoim sklepie - Pobranie'),
                'name' => PPPackage::PP_POCZTEX_48_DELIVERY_COD.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX_48
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Powiąż z metodą dostawy w Twoim sklepie - Standard'),
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_DELIVERY.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX_2021_KURIER
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Powiąż z metodą dostawy w Twoim sklepie - Pobranie'),
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_DELIVERY_COD.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX_2021_KURIER
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Odbiór w punkcie'),
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_IS_PICKUP_AT_POINT,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_KURIER_IS_PICKUP_AT_POINT . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_KURIER_IS_PICKUP_AT_POINT . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX_2021_KURIER.' toggle_combo '
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '',
                'html_content' => '<div class="alert alert-info">' . $this->l('Włączenie tej opcji spowoduje uruchomienie mapy Odbioru w punkcie przy wyborze konkretnej metody dostawy Poczty Polskiej') . '</div>',
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX_2021_KURIER.' toggle_rows '
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Odbiór w punkcie dla przesyłek opłaconych'),
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_PICKUP_AT_POINT_STANDARD.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX_2021_KURIER . ' 1 ' . PPPackage::PP_POCZTEX_2021_KURIER_IS_PICKUP_AT_POINT . ' 1'
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Odbiór w punkcie dla przesyłek pobraniowych'),
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_PICKUP_AT_POINT_COD.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX_2021_KURIER . ' 1 ' . PPPackage::PP_POCZTEX_2021_KURIER_IS_PICKUP_AT_POINT . ' 1',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Odbiór w automacie'),
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_IS_PICKUP_AT_AUTOMAT,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_KURIER_IS_PICKUP_AT_AUTOMAT . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_KURIER_IS_PICKUP_AT_AUTOMAT . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX_2021_KURIER.' toggle_combo '
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '',
                'html_content' => '<div class="alert alert-info">' . $this->l('Włączenie tej opcji spowoduje uruchomienie mapy Odbioru w automacie przy wyborze konkretnej metody dostawy Poczty Polskiej') . '</div>',
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX_2021_KURIER.' toggle_rows '
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Odbiór w automacie dla przesyłek opłaconych'),
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_PICKUP_AT_AUTOMAT_STANDARD.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX_2021_KURIER . ' 1 ' . PPPackage::PP_POCZTEX_2021_KURIER_IS_PICKUP_AT_AUTOMAT . ' 1'
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Odbiór w automacie dla przesyłek pobraniowych'),
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_PICKUP_AT_AUTOMAT_COD.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX_2021_KURIER . ' 1 ' . PPPackage::PP_POCZTEX_2021_KURIER_IS_PICKUP_AT_AUTOMAT . ' 1',
            ),

            array(
                'type' => 'select',
                'label' => $this->l('Powiąż z metodą dostawy w Twoim sklepie - Standard'),
                'name' => PPPackage::PP_POCZTEX_2021_DZIS_DELIVERY.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX_2021_DZIS
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Powiąż z metodą dostawy w Twoim sklepie - Pobranie'),
                'name' => PPPackage::PP_POCZTEX_2021_DZIS_DELIVERY_COD.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX_2021_DZIS
            ),


            array(
                'type' => 'select',
                'label' => $this->l('Powiąż z metodą dostawy w Twoim sklepie - Standard'),
                'name' => PPPackage::PP_POCZTEX_DELIVERY.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Powiąż z metodą dostawy w Twoim sklepie - Pobranie'),
                'name' => PPPackage::PP_POCZTEX_DELIVERY_COD.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Powiąż z metodą dostawy w Twoim sklepie'),
                'name' => PPPackage::PP_GLOBAL_EXPRESS_DELIVERY.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_GLOBAL_EXPRESS
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Powiąż z metodą dostawy w Twoim sklepie'),
                'name' => PPPackage::PP_PACZKA_POCZTOWA_DELIVERY.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_PACZKA_POCZTOWA
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Powiąż z metodą dostawy w Twoim sklepie'),
                'name' => PPPackage::PP_PRZESYLKA_POLECONA_DELIVERY.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_PRZESYLKA_POLECONA
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Powiąż z metodą dostawy w Twoim sklepie'),
                'name' => PPPackage::PP_PRZESYLKA_FIRMOWA_DELIVERY.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_PRZESYLKA_FIRMOWA
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Powiąż z metodą dostawy w Twoim sklepie'),
                'name' => PPPackage::PP_PACZKA_UE_DELIVERY.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_PACZKA_UE
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Powiąż z metodą dostawy w Twoim sklepie'),
                'name' => PPPackage::PP_ZAGRANICZNA_PRZESYLKA_DELIVERY.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_ZAGRANICZNA_PRZESYLKA
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Powiąż z metodą dostawy w Twoim sklepie'),
                'name' => PPPackage::PP_EMS_UE_DELIVERY.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_EMS_UE
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Odbiór w punkcie'),
                'name' => PPPackage::PP_POCZTEX_48_IS_PICKUP_AT_POINT,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_48_IS_PICKUP_AT_POINT . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_48_IS_PICKUP_AT_POINT . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX_48.' toggle_combo '
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '',
                'html_content' => '<div class="alert alert-info">' . $this->l('Włączenie tej opcji spowoduje uruchomienie mapy Odbioru w punkcie przy wyborze konkretnej metody dostawy Poczty Polskiej') . '</div>',
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX_48.' toggle_rows '
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Odbiór w punkcie dla przesyłek opłaconych'),
                'name' => PPPackage::PP_POCZTEX_48_PICKUP_AT_POINT_STANDARD.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX_48 . ' 1 ' . PPPackage::PP_POCZTEX_48_IS_PICKUP_AT_POINT . ' 1'
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Odbiór w punkcie dla przesyłek pobraniowych'),
                'name' => PPPackage::PP_POCZTEX_48_PICKUP_AT_POINT_COD.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX_48 . ' 1 ' . PPPackage::PP_POCZTEX_48_IS_PICKUP_AT_POINT . ' 1',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Odbiór w automacie'),
                'name' => PPPackage::PP_POCZTEX_48_IS_PICKUP_AT_AUTOMAT,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_48_IS_PICKUP_AT_AUTOMAT . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_48_IS_PICKUP_AT_AUTOMAT . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX_48.' toggle_combo '
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '',
                'html_content' => '<div class="alert alert-info">' . $this->l('Włączenie tej opcji spowoduje uruchomienie mapy Odbioru w automacie przy wyborze konkretnej metody dostawy Poczty Polskiej') . '</div>',
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX_48.' toggle_rows '
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Odbiór w automacie dla przesyłek opłaconych'),
                'name' => PPPackage::PP_POCZTEX_48_PICKUP_AT_AUTOMAT_STANDARD.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX_48 . ' 1 ' . PPPackage::PP_POCZTEX_48_IS_PICKUP_AT_AUTOMAT . ' 1'
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Odbiór w automacie dla przesyłek pobraniowych'),
                'name' => PPPackage::PP_POCZTEX_48_PICKUP_AT_AUTOMAT_COD.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX_48 . ' 1 ' . PPPackage::PP_POCZTEX_48_IS_PICKUP_AT_AUTOMAT . ' 1',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Odbiór w punkcie'),
                'name' => PPPackage::PP_POCZTEX_IS_PICKUP_AT_POINT,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_IS_PICKUP_AT_POINT . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_IS_PICKUP_AT_POINT . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX.' toggle_combo '
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '',
                'html_content' => '<div class="alert alert-info">' . $this->l('Włączenie tej opcji spowoduje uruchomienie mapy Odbioru w punkcie przy wyborze konkretnej metody dostawy Poczty Polskiej') . '</div>',
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX.' toggle_rows '
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Odbiór w punkcie dla przesyłek opłaconych'),
                'name' => PPPackage::PP_POCZTEX_PICKUP_AT_POINT_STANDARD.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX . ' 1 ' . PPPackage::PP_POCZTEX_IS_PICKUP_AT_POINT . ' 1'
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Odbiór w punkcie dla przesyłek pobraniowych'),
                'name' => PPPackage::PP_POCZTEX_PICKUP_AT_POINT_COD.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX . ' 1 ' . PPPackage::PP_POCZTEX_IS_PICKUP_AT_POINT . ' 1',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Odbiór w automacie'),
                'name' => PPPackage::PP_POCZTEX_IS_PICKUP_AT_AUTOMAT,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_IS_PICKUP_AT_AUTOMAT . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_IS_PICKUP_AT_AUTOMAT . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX.' toggle_combo '
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '',
                'html_content' => '<div class="alert alert-info">' . $this->l('Włączenie tej opcji spowoduje uruchomienie mapy Odbioru w automacie przy wyborze konkretnej metody dostawy Poczty Polskiej') . '</div>',
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX.' toggle_rows '
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Odbiór w automacie dla przesyłek opłaconych'),
                'name' => PPPackage::PP_POCZTEX_PICKUP_AT_AUTOMAT_STANDARD.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX . ' 1 ' . PPPackage::PP_POCZTEX_IS_PICKUP_AT_AUTOMAT . ' 1'
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Odbiór w automacie dla przesyłek pobraniowych'),
                'name' => PPPackage::PP_POCZTEX_PICKUP_AT_AUTOMAT_COD.'[]',
                'multiple' => true,
                'class' => 'fixed-width-xxxl',
                'options' => array(
                    'query' => $this->tab_carriers,
                    'id' => 'id_carrier',
                    'name' => 'name',
                ),
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con delivery_' . PPPackage::PP_POCZTEX . ' 1 ' . PPPackage::PP_POCZTEX_IS_PICKUP_AT_AUTOMAT . ' 1',
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'html_content' => '<button type="button" data-name="delivery" class="btn btn-default btn-settings">' . $this->l('Zapisz ustawienia') . '</button>',
                'tab' => 'delivery',
                'form_group_class' => 'delivery pp_packages_con btn-delivery',
            ),
        );
        return $delivery;
    }
    /**
     * metoda przygotowujaca dane do formularza w zakladce Uslugi
     * @return array
     */
    public function getServicesTab() {
        $services = array(
            array(
                'type' => 'select',
                'label' => $this->l('Wybierz usługę'),
                'name' => PPPackage::PP_PACKAGES,
                'class' => 'fixed-width-xxl',
                'options' => array(
                    'query' => PocztaPolskaEn::getPPPackages(),
                    'id' => 'id',
                    'name' => 'name',
                    'default' => array(
                        'label' => $this->l('Wybierz przesyłkę'),
                        'value' => '',
                    ),
                ),
                'tab' => 'services',
                'form_group_class' => 'packages'
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('Atrybuty') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_48',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Gabaryt'),
                'name' => PPPackage::PP_POCZTEX_48_GABARYT,
                'options' => array(
                    'query' => PocztaPolskaEn::getSizes(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_pocztex_48',
                'tab' => 'services'
            ),
            array(
                'type' => 'textarea',
                'name' => PPPackage::PP_POCZTEX_48_OPIS_PRZESYLKI,
                'label' => $this->l('Opis przesyłki'),
                'form_group_class' => 'pp_pocztex_48',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
                'maxlength' => 500,
                'desc'=> $this->l('W opisie można użyć zmiennych <br>- {id_order} - numer zamóweniaw bazie  danych (np 1,2,3...)<br>- {reference} - zamaskowany numer zamówienia (np:ABCBVWEZ)<br>- {message} - wiadomość przekazana przez kupującego w komentarzu do zamówienia'),
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('Rodzaj') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_48',
            ),
            array(
                'type' => 'switch',
                'tab' => 'services',
                'label' => $this->l('Pobranie'),
                'name' => PPPackage::PP_POCZTEX_48_POBRANIE,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_48_POBRANIE . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_48_POBRANIE . '_off',
                        'value' => 0
                    )
                ),
                'form_group_class' => 'pp_pocztex_48 toggle_rows',
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_POCZTEX_48_NUMER_RACHUNKU,
                'label' => $this->l('Numer rachunku pobrania'),
                'form_group_class' => 'pp_pocztex_48 '.PPPackage::PP_POCZTEX_48_POBRANIE.' 1',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
                'desc' => $this->l('Numer rachunku pobrania bez spacji')
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_POCZTEX_48_TYTUL_POBRANIA,
                'label' => $this->l('Tytuł pobrania'),
                'form_group_class' => 'pp_pocztex_48 '.PPPackage::PP_POCZTEX_48_POBRANIE.' 1',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
                'maxlength' => 30,
                'desc' => $this->l('W tytule można użyć zmiennych <br>- {id_order} - numer zamóweniaw bazie  danych (np 1,2,3...)<br>- {reference} - zamaskowany numer zamówienia (np:ABCBVWEZ)'),
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('USŁUGI DODATKOWE / NIESTANDARDOWE') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_48',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Przesyłka niestandardowa'),
                'name' => PPPackage::PP_POCZTEX_48_PRZESYLKA_NIESTANDARDOWA,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_48_PRZESYLKA_NIESTANDARDOWA . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_48_PRZESYLKA_NIESTANDARDOWA . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_48',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Deklaracja wartości'),
                'name' => PPPackage::PP_POCZTEX_48_DEKLARACJA_WARTOSCI,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_48_DEKLARACJA_WARTOSCI . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_48_DEKLARACJA_WARTOSCI . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_48 toggle_rows',
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_POCZTEX_48_WARTOSC_ZL,
                'label' => $this->l('Wartość'),
                'form_group_class' => 'pp_pocztex_48 ' . PPPackage::PP_POCZTEX_48_DEKLARACJA_WARTOSCI . ' 1',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
                'suffix' => 'zł',
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_POCZTEX_48_WARTOSC_KG,
                'form_group_class' => 'pp_pocztex_48 ' . PPPackage::PP_POCZTEX_48_DEKLARACJA_WARTOSCI . ' 1',
                'tab' => 'services',
                'suffix' => 'kg',
                'class' => 'fixed-width-xxl',
                'desc' => $this->l('W przypadku wartości pustej wartość zostanie pobrana z zamówienia')
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Ostrożnie'),
                'name' => PPPackage::PP_POCZTEX_48_OSTROZNIE,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_48_OSTROZNIE . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_48_OSTROZNIE . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_48',
            ),
            /*array(
                'type' => 'switch',
                'label' => $this->l('Do rąk własnych'),
                'name' => PPPackage::PP_POCZTEX_48_DORECZENIE_DO_RAK_WLASNYCH,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_48_DORECZENIE_DO_RAK_WLASNYCH . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_48_DORECZENIE_DO_RAK_WLASNYCH . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_48',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Potwierdź odbiór'),
                'name' => PPPackage::PP_POCZTEX_48_POTWIERDZENIE_ODBIORU,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_48_POTWIERDZENIE_ODBIORU . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_48_POTWIERDZENIE_ODBIORU . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_48 toggle_rows',
            ),
            array(
                'type' => 'select',
                'name' => PPPackage::PP_POCZTEX_48_RODZAJ_POTWIERDZENIA,
                'options' => array(
                    'query' => PocztaPolskaEn::getRodzajPotwierdzeniaBiznes(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_48 ' . PPPackage::PP_POCZTEX_48_POTWIERDZENIE_ODBIORU . ' 1',
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_POCZTEX_48_POTWIERDZENIE_ILE,
                'class' => 'fixed-width-xxl',
                'form_group_class' => 'pp_pocztex_48 ' . PPPackage::PP_POCZTEX_48_POTWIERDZENIE_ODBIORU . ' 1',
                'suffix' => $this->l('szt.'),
                'tab' => 'services',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Dokumenty zwrotne'),
                'name' => PPPackage::PP_POCZTEX_48_DOKUMENTY_ZWROTNE,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_48_DOKUMENTY_ZWROTNE . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_48_DOKUMENTY_ZWROTNE . '_off',
                        'value' => 0
                    )
                ),
                'form_group_class' => 'pp_pocztex_48 toggle_rows',
                'tab' => 'services',
            ),
            array(
                'type' => 'select',
                'name' => PPPackage::PP_POCZTEX_48_DOKUMENTY_RODZAJ_POTWIERDZENIA,
                'options' => array(
                    'query' => PocztaPolskaEn::getDokumentyRodzajPotwierdzeniaBiznes(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_pocztex_48 ' . PPPackage::PP_POCZTEX_48_DOKUMENTY_ZWROTNE . ' 1',
                'tab' => 'services',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Wysłane do'),
                'name' => PPPackage::PP_POCZTEX_48_WYSLANE_DO,
                'options' => array(
                    'query' => PocztaPolskaEn::getWyslaneDoBiznes(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_pocztex_48 ' . PPPackage::PP_POCZTEX_48_DOKUMENTY_ZWROTNE . ' 1',
                'tab' => 'services',
            ),*/

            array(
                'type' => 'switch',
                'label' => $this->l('Sprawdzenie zawartości przez odbiorcę'),
                'name' => PPPackage::PP_POCZTEX_48_ODBIORCA,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_48_ODBIORCA . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_48_ODBIORCA . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_48',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Ubezpieczenie'),
                'name' => PPPackage::PP_POCZTEX_48_UBEZPIECZENIE,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_48_UBEZPIECZENIE . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_48_UBEZPIECZENIE . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_48 toggle_rows',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Wartosć ubezpieczenia'),
                'name' => PPPackage::PP_POCZTEX_48_WARTOSC_UBEZPIECZENIA,
                'options' => array(
                    'query' => PocztaPolskaEn::getWartoscUbezpieczenia(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_pocztex_48 toggle_combo ' . PPPackage::PP_POCZTEX_48_UBEZPIECZENIE . ' 1',
                'tab' => 'services'
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_POCZTEX_48_OKRESLONA_WARTOSC,
                'label' => $this->l('określona wartość'),
                'form_group_class' => 'pp_pocztex_48 '.PPPackage::PP_POCZTEX_48_UBEZPIECZENIE . ' 1 '.PPPackage::PP_POCZTEX_48_WARTOSC_UBEZPIECZENIA . ' okreslona_wartosc',
                'tab' => 'services',
                'suffix' => 'zł',
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'html_content' => '<button type="button" data-name="services" class="btn btn-default btn-settings">' . $this->l('Zapisz ustawienia') . '</button>',
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_48',
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('ATRYBUTY') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Serwis'),
                'name' => PPPackage::PP_POCZTEX_SERWIS,
                'options' => array(
                    'query' => PocztaPolskaEn::getSerwis(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_pocztex toggle_combo',
                'class' => PPPackage::PP_POCZTEX_SERWIS,
                'tab' => 'services'
            ),
            array(
                'type' => 'textarea',
                'name' => PPPackage::PP_POCZTEX_OPIS_PRZESYLKI,
                'label' => $this->l('Opis przesyłki'),
                'form_group_class' => 'pp_pocztex',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
                'maxlength' => 500,
                'desc'=> $this->l('W opisie można użyć zmiennych <br>- {id_order} - numer zamóweniaw bazie  danych (np 1,2,3...)<br>- {reference} - zamaskowany numer zamówienia (np:ABCBVWEZ)<br>- {message} - wiadomość przekazana przez kupującego w komentarzu do zamówienia'),
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Zawartość przesyłki'),
                'name' => PPPackage::PP_POCZTEX_ZAWARTOSC,
                'options' => array(
                    'query' => PocztaPolskaEn::getZawartoscPrzesylki(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_pocztex',
                'tab' => 'services'
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Uiszcza opłatę'),
                'name' => PPPackage::PP_POCZTEX_UISZCZA_OPLATE,
                'options' => array(
                    'query' => PocztaPolskaEn::getUiszczaOplate(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_pocztex',
                'tab' => 'services'
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Godzina doręczenia'),
                'name' => PPPackage::PP_POCZTEX_GODZINA_DORECZENIA,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_GODZINA_DORECZENIA . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_GODZINA_DORECZENIA . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex toggle_combo '.PPPackage::PP_POCZTEX_SERWIS.' EKSPRES24',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Godzina'),
                'name' => PPPackage::PP_POCZTEX_GODZINA,
                'options' => array(
                    'query' => PocztaPolskaEn::getGodzina(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_pocztex ' . PPPackage::PP_POCZTEX_GODZINA_DORECZENIA . ' 1 '.PPPackage::PP_POCZTEX_SERWIS.'',
                'tab' => 'services'
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('POBRANIE') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Pobranie'),
                'name' => PPPackage::PP_POCZTEX_POBRANIE,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_POBRANIE . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_POBRANIE . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex  toggle_rows',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Sposób pobrania'),
                'name' => PPPackage::PP_POCZTEX_SPOSOB_POBRANIA,
                'options' => array(
                    'query' => PocztaPolskaEn::getSposobPobrania(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_pocztex ' . PPPackage::PP_POCZTEX_POBRANIE . ' 1',
                'tab' => 'services'
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_POCZTEX_NUMER_RACHUNKU,
                'label' => $this->l('Numer rachunku pobrania'),
                'form_group_class' => 'pp_pocztex pp_pocztex_pobranie 1',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
                'desc' => $this->l('Numer rachunku pobrania bez spacji')
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_POCZTEX_TYTUL_POBRANIA,
                'label' => $this->l('Tytuł pobrania'),
                'form_group_class' => 'pp_pocztex pp_pocztex_pobranie 1',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
                'maxlength' => 30,
                'desc' => $this->l('W tytule można użyć zmiennych <br>- {id_order} - numer zamóweniaw bazie  danych (np 1,2,3...)<br>- {reference} - zamaskowany numer zamówienia (np:ABCBVWEZ)'),
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('USŁUGI DODATKOWE / NIESTANDARDOWE') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex',
            ),
            array(
                'type' => 'text',
                'label'=>$this->l('Masa'),
                'name' => PPPackage::PP_POCZTEX_MASA,
                'form_group_class' => 'pp_pocztex',
                'tab' => 'services',
                'suffix' => 'kg',
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Deklaracja wartości'),
                'name' => PPPackage::PP_POCZTEX_DEKLARACJA_WARTOSCI,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_DEKLARACJA_WARTOSCI . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_DEKLARACJA_WARTOSCI . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex toggle_rows',
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_POCZTEX_WARTOSC_ZAMOWIENIA,
                'label' => $this->l('Wartość'),
                'form_group_class' => 'pp_pocztex ' . PPPackage::PP_POCZTEX_DEKLARACJA_WARTOSCI . ' 1',
                'tab' => 'services',
                'suffix' => 'zł',
                'class' => 'fixed-width-xxl',
                'desc' => $this->l('W przypadku wartości pustej wartość zostanie pobrana z zamówienia'),
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Potwierdzenie odbioru'),
                'name' => PPPackage::PP_POCZTEX_POTWIERDZENIE_ODBIORU,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_POTWIERDZENIE_ODBIORU . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_POTWIERDZENIE_ODBIORU . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex toggle_rows',
            ),
            array(
                'type' => 'select',
                'name' => PPPackage::PP_POCZTEX_RODZAJ_POTWIERDZENIA,
                'options' => array(
                    'query' => PocztaPolskaEn::getRodzajPotwierdzenia(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_pocztex ' . PPPackage::PP_POCZTEX_POTWIERDZENIE_ODBIORU . ' 1',
                'tab' => 'services'
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_POCZTEX_POTWIERDZENIE_ILE,
                'form_group_class' => 'pp_pocztex ' . PPPackage::PP_POCZTEX_POTWIERDZENIE_ODBIORU . ' 1',
                'tab' => 'services',
                'suffix' => $this->l('szt.'),
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Potwierdzenie doręczenia'),
                'name' => PPPackage::PP_POCZTEX_POTWIERDZENIE_DORECZENIA,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_POTWIERDZENIE_DORECZENIA . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_POTWIERDZENIE_DORECZENIA . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex toggle_rows',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Typ potwierdzenia doręczenia'),
                'name' => PPPackage::PP_POCZTEX_TYP_POTWIERDZENIA,
                'options' => array(
                    'query' => PocztaPolskaEn::getTypPotwierdzenia(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_pocztex ' . PPPackage::PP_POCZTEX_POTWIERDZENIE_DORECZENIA . ' 1',
                'tab' => 'services'
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_POCZTEX_NR_TEL_POTWIERDZENIA,
                'label' => $this->l('Nr. telefonu do potwierdzenia doręczenia'),
                'form_group_class' => 'pp_pocztex ' . PPPackage::PP_POCZTEX_POTWIERDZENIE_DORECZENIA . ' 1',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_POCZTEX_EMAIL_POTWIERDZENIA,
                'label' => $this->l('Email do potwierdzenia doręczenia'),
                'form_group_class' => 'pp_pocztex ' . PPPackage::PP_POCZTEX_POTWIERDZENIE_DORECZENIA . ' 1',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Ostrożnie'),
                'name' => PPPackage::PP_POCZTEX_OSTROZNIE,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_OSTROZNIE . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_OSTROZNIE . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Przesyłka niestandardowa'),
                'name' => PPPackage::PP_POCZTEX_PRZESYLKA_NIESTANDARDOWA,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_PRZESYLKA_NIESTANDARDOWA . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_PRZESYLKA_NIESTANDARDOWA . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex '.PPPackage::PP_POCZTEX_SERWIS.' EKSPRES24 MIEJSKI_DO_3H_DO_5KM
                                    MIEJSKI_DO_3H_DO_10KM MIEJSKI_DO_3H_DO_15KM
                                    MIEJSKI_DO_3H_POWYZEJ_15KM
                                    MIEJSKI_DO_4H_DO_10KM
                                    MIEJSKI_DO_4H_DO_15KM
                                    MIEJSKI_DO_4H_DO_20KM
                                    MIEJSKI_DO_4H_DO_30KM MIEJSKI_DO_4H_DO_40KM',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Sprawdzenie zawartości przez odbiorcę'),
                'name' => PPPackage::PP_POCZTEX_SPRAWDZENIE_ZAWARTOSCI,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_SPRAWDZENIE_ZAWARTOSCI . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_SPRAWDZENIE_ZAWARTOSCI . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Doręczenie do rąk własnych'),
                'name' => PPPackage::PP_POCZTEX_DORECZENIE_DO_RAK_WLASNYCH,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_DORECZENIE_DO_RAK_WLASNYCH . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_DORECZENIE_DO_RAK_WLASNYCH . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Doręczenie w sobotę'),
                'name' => PPPackage::PP_POCZTEX_DORECZENIE_W_SOBOTE,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_DORECZENIE_W_SOBOTE . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_DORECZENIE_W_SOBOTE . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Doręczenie w 90 minut'),
                'name' => PPPackage::PP_POCZTEX_DORECZENIE_W_90_MINUT,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_DORECZENIE_W_90_MINUT . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_DORECZENIE_W_90_MINUT . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex '.PPPackage::PP_POCZTEX_SERWIS.' MIEJSKI_DO_3H_DO_5KM MIEJSKI_DO_3H_DO_10KM MIEJSKI_DO_3H_DO_15KM MIEJSKI_DO_3H_POWYZEJ_15KM',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Doręczenie w niedzielę/święto'),
                'name' => PPPackage::PP_POCZTEX_DORECZENIE_W_NIEDZIELE_SWIETO,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_DORECZENIE_W_NIEDZIELE_SWIETO . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_DORECZENIE_W_NIEDZIELE_SWIETO . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex '.PPPackage::PP_POCZTEX_SERWIS.' BEZPOSREDNI_DO_20KG BEZPOSREDNI_OD_20KG_DO_30KG BEZPOSREDNI_OD_30KG_DO_100KG',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Doręczenie 20:00 - 07:00'),
                'name' => PPPackage::PP_POCZTEX_DORECZENIE_W_20_7,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_DORECZENIE_W_20_7 . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_DORECZENIE_W_20_7 . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex '.PPPackage::PP_POCZTEX_SERWIS.' BEZPOSREDNI_DO_20KG BEZPOSREDNI_OD_20KG_DO_30KG BEZPOSREDNI_OD_30KG_DO_100KG',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Odbiór przesylki w sobotę'),
                'name' => PPPackage::PP_POCZTEX_ODBIOR_PRZESYLKI_W_SOBOTE,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_ODBIOR_PRZESYLKI_W_SOBOTE . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_ODBIOR_PRZESYLKI_W_SOBOTE . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex',
            ),


            array(
                'type' => 'switch',
                'label' => $this->l('Odbiór w niedzielę/święto'),
                'name' => PPPackage::PP_POCZTEX_ODBIOR_W_NIEDZIELE_SWIETO,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_ODBIOR_W_NIEDZIELE_SWIETO . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_ODBIOR_W_NIEDZIELE_SWIETO . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex '.PPPackage::PP_POCZTEX_SERWIS.' BEZPOSREDNI_DO_20KG BEZPOSREDNI_OD_20KG_DO_30KG BEZPOSREDNI_OD_30KG_DO_100KG',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Odbiór 20:00 - 07:00'),
                'name' => PPPackage::PP_POCZTEX_ODBIOR_W_20_7,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_ODBIOR_W_20_7 . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_ODBIOR_W_20_7 . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex '.PPPackage::PP_POCZTEX_SERWIS.' BEZPOSREDNI_DO_20KG BEZPOSREDNI_OD_20KG_DO_30KG BEZPOSREDNI_OD_30KG_DO_100KG',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Ubezpieczenie'),
                'name' => PPPackage::PP_POCZTEX_UBEZPIECZENIE,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_UBEZPIECZENIE . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_UBEZPIECZENIE . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex toggle_rows',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Wartosć ubezpieczenia'),
                'name' => PPPackage::PP_POCZTEX_WARTOSC_UBEZPIECZENIA,
                'options' => array(
                    'query' => PocztaPolskaEn::getWartoscPocztexUbezpieczenia(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_pocztex toggle_combo ' . PPPackage::PP_POCZTEX_UBEZPIECZENIE . ' 1',
                'tab' => 'services'
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_POCZTEX_OKRESLONA_WARTOSC,
                'label' => $this->l('określona wartość'),
                'form_group_class' => 'pp_pocztex ' . PPPackage::PP_POCZTEX_UBEZPIECZENIE . ' 1 ' . PPPackage::PP_POCZTEX_WARTOSC_UBEZPIECZENIA . ' okreslona_wartosc',
                'tab' => 'services',
                'suffix' => 'zł',
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Dokumenty zwrotne'),
                'name' => PPPackage::PP_POCZTEX_DOKUMENTY_ZWROTNE,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_DOKUMENTY_ZWROTNE . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_DOKUMENTY_ZWROTNE . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex toggle_rows',
            ),
            array(
                'type' => 'select',
                'name' => PPPackage::PP_POCZTEX_DOKUMENTY_RODZAJ_POTWIERDZENIA,
                'options' => array(
                    'query' => PocztaPolskaEn::getDokumentyRodzajPotwierdzenia(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_pocztex ' . PPPackage::PP_POCZTEX_DOKUMENTY_ZWROTNE . ' 1',
                'tab' => 'services'
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Wysłane do'),
                'name' => PPPackage::PP_POCZTEX_WYSLANE_DO,
                'options' => array(
                    'query' => PocztaPolskaEn::getWyslaneDo(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_pocztex ' . PPPackage::PP_POCZTEX_DOKUMENTY_ZWROTNE . ' 1',
                'tab' => 'services'
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'html_content' => '<button type="button" data-name="services" class="btn btn-default btn-settings">' . $this->l('Zapisz ustawienia') . '</button>',
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex',
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('ATRYBUTY') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_paczka_pocztowa',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Kategoria'),
                'name' => PPPackage::PP_PACZKA_POCZTOWA_KATEGORIA,
                'options' => array(
                    'query' => PocztaPolskaEn::getPaczka(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_paczka_pocztowa',
                'tab' => 'services'
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Gabaryt'),
                'name' => PPPackage::PP_PACZKA_POCZTOWA_GABARYT,
                'options' => array(
                    'query' => PocztaPolskaEn::getGabaryt(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_paczka_pocztowa',
                'tab' => 'services'
            ),
            array(
                'type' => 'textarea',
                'name' => PPPackage::PP_PACZKA_POCZTOWA_OPIS_PRZESYLKI,
                'label' => $this->l('Opis przesyłki'),
                'form_group_class' => 'pp_paczka_pocztowa',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
                'maxlength' => 500,
                'desc'=> $this->l('W opisie można użyć zmiennych <br>- {id_order} - numer zamóweniaw bazie  danych (np 1,2,3...)<br>- {reference} - zamaskowany numer zamówienia (np:ABCBVWEZ)<br>- {message} - wiadomość przekazana przez kupującego w komentarzu do zamówienia'),
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('USŁUGI DODATKOWE') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_paczka_pocztowa',
            ),
            array(
                'type' => 'text',
                'label'=>$this->l('Masa'),
                'name' => PPPackage::PP_PACZKA_POCZTOWA_MASA,
                'form_group_class' => 'pp_paczka_pocztowa',
                'tab' => 'services',
                'suffix' => 'kg',
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Deklaracja wartości'),
                'name' => PPPackage::PP_PACZKA_POCZTOWA_DEKLARACJA_WARTOSCI,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_PACZKA_POCZTOWA_DEKLARACJA_WARTOSCI . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_PACZKA_POCZTOWA_DEKLARACJA_WARTOSCI . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_paczka_pocztowa toggle_rows',
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_PACZKA_POCZTOWA_DEKLARACJA_WARTOSCI_ZL,
                'label' => $this->l('Wartość'),
                'form_group_class' => 'pp_paczka_pocztowa ' . PPPackage::PP_PACZKA_POCZTOWA_DEKLARACJA_WARTOSCI . ' 1',
                'desc' => $this->l('W przypadku wartości pustej wartość zostanie pobrana z zamówienia'),
                'tab' => 'services',
                'suffix' => 'zł',
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_PACZKA_POCZTOWA_POTWIERDZENIE_ILE,
                'label' => $this->l('Ilość potwierdzeń'),
                'form_group_class' => 'pp_paczka_pocztowa',
                'tab' => 'services',
                'suffix' => $this->l('szt.'),
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('SPECJALNE USŁUGI DODATKOWE') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_paczka_pocztowa',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Egzemplarz biblioteczny'),
                'name' => PPPackage::PP_PACZKA_POCZTOWA_EGZEMPLARZ_BIBLIOTECZNY,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_PACZKA_POCZTOWA_EGZEMPLARZ_BIBLIOTECZNY . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_PACZKA_POCZTOWA_EGZEMPLARZ_BIBLIOTECZNY . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_paczka_pocztowa',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Dla ociemniałych'),
                'name' => PPPackage::PP_PACZKA_POCZTOWA_DLA_OCIEMNIALYCH,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_PACZKA_POCZTOWA_DLA_OCIEMNIALYCH . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_PACZKA_POCZTOWA_DLA_OCIEMNIALYCH . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_paczka_pocztowa',
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'html_content' => '<button type="button" data-name="services" class="btn btn-default btn-settings">' . $this->l('Zapisz ustawienia') . '</button>',
                'tab' => 'services',
                'form_group_class' => 'pp_paczka_pocztowa',
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('ATRYBUTY') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_global_express',
            ),
            array(
                'type' => 'text',
                'label'=>$this->l('Masa'),
                'name' => PPPackage::PP_GLOBAL_EXPRESS_MASA,
                'form_group_class' => 'pp_global_express',
                'tab' => 'services',
                'suffix' => 'kg',
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Zawartość przesyłki'),
                'name' => PPPackage::PP_GLOBAL_EXPRESS_ZAWARTOSC,
                'options' => array(
                    'query' => PocztaPolskaEn::getZawartoscGlobalPrzesylki(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_global_express',
                'tab' => 'services'
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Potwierdzenie doręczenia'),
                'name' => PPPackage::PP_GLOBAL_EXPRESS_POTWIERDZENIE_DORECZENIA,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_GLOBAL_EXPRESS_POTWIERDZENIE_DORECZENIA . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_GLOBAL_EXPRESS_POTWIERDZENIE_DORECZENIA . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_global_express toggle_rows',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Typ potwierdzenia doręczenia'),
                'name' => PPPackage::PP_GLOBAL_EXPRESS_TYP_POTWIERDZENIA,
                'options' => array(
                    'query' => PocztaPolskaEn::getTypPotwierdzenia(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_global_express ' . PPPackage::PP_GLOBAL_EXPRESS_POTWIERDZENIE_DORECZENIA . ' 1',
                'tab' => 'services'
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_GLOBAL_EXPRESS_NR_TEL_POTWIERDZENIA,
                'label' => $this->l('Nr. telefonu do potwierdzenia doręczenia'),
                'form_group_class' => 'pp_global_express ' . PPPackage::PP_GLOBAL_EXPRESS_POTWIERDZENIE_DORECZENIA . ' 1',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_GLOBAL_EXPRESS_EMAIL_POTWIERDZENIA,
                'label' => $this->l('Email do potwierdzenia doręczenia'),
                'form_group_class' => 'pp_global_express ' . PPPackage::PP_GLOBAL_EXPRESS_POTWIERDZENIE_DORECZENIA . ' 1',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'textarea',
                'name' => PPPackage::PP_GLOBAL_EXPRESS_OPIS_PRZESYLKI,
                'label' => $this->l('Opis przesyłki'),
                'form_group_class' => 'pp_global_express',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
                'maxlength' => 500,
                'desc'=> $this->l('W opisie można użyć zmiennych <br>- {id_order} - numer zamóweniaw bazie  danych (np 1,2,3...)<br>- {reference} - zamaskowany numer zamówienia (np:ABCBVWEZ)<br>- {message} - wiadomość przekazana przez kupującego w komentarzu do zamówienia'),
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'html_content' => '<button type="button" data-name="services" class="btn btn-default btn-settings">' . $this->l('Zapisz ustawienia') . '</button>',
                'tab' => 'services',
                'form_group_class' => 'pp_global_express',
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('ATRYBUTY') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_przesylka_polecona',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Kategoria'),
                'name' => PPPackage::PP_PRZESYLKA_POLECONA_KATEGORIA,
                'options' => array(
                    'query' => PocztaPolskaEn::getPaczka(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_przesylka_polecona',
                'tab' => 'services'
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Format'),
                'name' => PPPackage::PP_PRZESYLKA_POLECONA_FORMAT,
                'options' => array(
                    'query' => PocztaPolskaEn::getFormat(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_przesylka_polecona',
                'tab' => 'services'
            ),
            array(
                'type' => 'textarea',
                'name' => PPPackage::PP_PRZESYLKA_POLECONA_OPIS_PRZESYLKI,
                'label' => $this->l('Opis przesyłki'),
                'form_group_class' => 'pp_przesylka_polecona',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
                'maxlength' => 500,
                'desc'=> $this->l('W opisie można użyć zmiennych <br>- {id_order} - numer zamóweniaw bazie  danych (np 1,2,3...)<br>- {reference} - zamaskowany numer zamówienia (np:ABCBVWEZ)<br>- {message} - wiadomość przekazana przez kupującego w komentarzu do zamówienia'),
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('USŁUGI DODATKOWE') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_przesylka_polecona',
            ),
            array(
                'type' => 'text',
                'label'=>$this->l('Masa'),
                'name' => PPPackage::PP_PRZESYLKA_POLECONA_MASA,
                'form_group_class' => 'pp_przesylka_polecona',
                'tab' => 'services',
                'suffix' => 'kg',
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_PRZESYLKA_POLECONA_ILOSC,
                'label' => $this->l('Ilość potwierdzeń'),
                'form_group_class' => 'pp_przesylka_polecona',
                'tab' => 'services',
                'suffix' => $this->l('szt.'),
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('SPECJALNE USŁUGI DODATKOWE') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_przesylka_polecona',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Egzemplarz biblioteczny'),
                'name' => PPPackage::PP_PRZESYLKA_POLECONA_EGZEMPLARZ_BIBLIOTECZNY,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_PRZESYLKA_POLECONA_EGZEMPLARZ_BIBLIOTECZNY . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_PRZESYLKA_POLECONA_EGZEMPLARZ_BIBLIOTECZNY . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_przesylka_polecona',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Dla ociemniałych'),
                'name' => PPPackage::PP_PRZESYLKA_POLECONA_DLA_OCIEMNIALYCH,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_PRZESYLKA_POLECONA_DLA_OCIEMNIALYCH . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_PRZESYLKA_POLECONA_DLA_OCIEMNIALYCH . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_przesylka_polecona',
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'html_content' => '<button type="button" data-name="services" class="btn btn-default btn-settings">' . $this->l('Zapisz ustawienia') . '</button>',
                'tab' => 'services',
                'form_group_class' => 'pp_przesylka_polecona',
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('ATRYBUTY') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_przesylka_firmowa',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Kategoria'),
                'name' => PPPackage::PP_PRZESYLKA_FIRMOWA_KATEGORIA,
                'options' => array(
                    'query' => PocztaPolskaEn::getPaczka(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_przesylka_firmowa',
                'tab' => 'services'
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Miejscowa/Zamiejscowa'),
                'name' => PPPackage::PP_PRZESYLKA_FIRMOWA_MIEJSCOWA_ZAMIEJSCOWA,
                'options' => array(
                    'query' => PocztaPolskaEn::getMiejscowaZamiejscowa(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_przesylka_firmowa',
                'tab' => 'services'
            ),
            array(
                'type' => 'textarea',
                'name' => PPPackage::PP_PRZESYLKA_FIRMOWA_OPIS_PRZESYLKI,
                'label' => $this->l('Opis przesyłki'),
                'form_group_class' => 'pp_przesylka_firmowa',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
                'maxlength' => 500,
                'desc'=> $this->l('W opisie można użyć zmiennych <br>- {id_order} - numer zamóweniaw bazie  danych (np 1,2,3...)<br>- {reference} - zamaskowany numer zamówienia (np:ABCBVWEZ)<br>- {message} - wiadomość przekazana przez kupującego w komentarzu do zamówienia'),
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('USŁUGI DODATKOWE') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_przesylka_firmowa',
            ),
            array(
                'type' => 'text',
                'label'=>$this->l('Masa'),
                'name' => PPPackage::PP_PRZESYLKA_FIRMOWA_MASA,
                'form_group_class' => 'pp_przesylka_firmowa',
                'tab' => 'services',
                'suffix' => 'kg',
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_PRZESYLKA_FIRMOWA_ILOSC,
                'label' => $this->l('Ilość potwierdzeń'),
                'form_group_class' => 'pp_przesylka_firmowa',
                'tab' => 'services',
                'suffix' => $this->l('szt.'),
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'html_content' => '<button type="button" data-name="services" class="btn btn-default btn-settings">' . $this->l('Zapisz ustawienia') . '</button>',
                'tab' => 'services',
                'form_group_class' => 'pp_przesylka_firmowa',
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('ATRYBUTY') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_paczka_ue',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Kategoria'),
                'name' => PPPackage::PP_PACZKA_UE_KATEGORIA,
                'options' => array(
                    'query' => PocztaPolskaEn::getPaczka(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_paczka_ue',
                'tab' => 'services'
            ),
            array(
                'type' => 'textarea',
                'name' => PPPackage::PP_PACZKA_UE_OPIS_PRZESYLKI,
                'label' => $this->l('Opis przesyłki'),
                'form_group_class' => 'pp_paczka_ue',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
                'maxlength' => 500,
                'desc'=> $this->l('W opisie można użyć zmiennych <br>- {id_order} - numer zamóweniaw bazie  danych (np 1,2,3...)<br>- {reference} - zamaskowany numer zamówienia (np:ABCBVWEZ)<br>- {message} - wiadomość przekazana przez kupującego w komentarzu do zamówienia'),
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('USŁUGI DODATKOWE') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_paczka_ue',
            ),
            array(
                'type' => 'text',
                'label'=>$this->l('Masa'),
                'name' => PPPackage::PP_PACZKA_UE_MASA,
                'form_group_class' => 'pp_paczka_ue',
                'tab' => 'services',
                'suffix' => 'kg',
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Deklaracja wartości'),
                'name' => PPPackage::PP_PACZKA_UE_DEKLARACJA_WARTOSCI,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_PACZKA_UE_DEKLARACJA_WARTOSCI . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_PACZKA_UE_DEKLARACJA_WARTOSCI . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_paczka_ue toggle_rows',
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_PACZKA_UE_DEKLARACJA_WARTOSCI_ZL,
                'label' => $this->l('Wartość'),
                'form_group_class' => 'pp_paczka_ue ' . PPPackage::PP_PACZKA_UE_DEKLARACJA_WARTOSCI . ' 1',
                'tab' => 'services',
                'suffix' => 'zł',
                'class' => 'fixed-width-xxl',
                'desc' => $this->l('W przypadku wartości pustej wartość zostanie pobrana z zamówienia'),
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_PACZKA_UE_ILOSC,
                'label' => $this->l('Ilość potwierdzeń'),
                'form_group_class' => 'pp_paczka_ue',
                'tab' => 'services',
                'suffix' => $this->l('szt.'),
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('SPECJALNE USŁUGI DODATKOWE') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_paczka_ue',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Zwrot'),
                'name' => PPPackage::PP_PACZKA_UE_ZWROT,
                'options' => array(
                    'query' => PocztaPolskaEn::getZwrot(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_paczka_ue toggle_combo',
                'tab' => 'services'
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Sposób zwrotu'),
                'name' => PPPackage::PP_PACZKA_UE_SPOSOB_ZWROTU,
                'options' => array(
                    'query' => PocztaPolskaEn::getSposobZwrot(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_paczka_ue '.PPPackage::PP_PACZKA_UE_ZWROT.' zwrot_po_liczbie_dni zwrot_natychmiast',
                'tab' => 'services'
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_PACZKA_UE_ILOSC_DNI,
                'label' => $this->l('Liczba dni'),
                'form_group_class' => 'pp_paczka_ue '.PPPackage::PP_PACZKA_UE_ZWROT.' zwrot_po_liczbie_dni',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'html_content' => '<button type="button" data-name="services" class="btn btn-default btn-settings">' . $this->l('Zapisz ustawienia') . '</button>',
                'tab' => 'services',
                'form_group_class' => 'pp_paczka_ue',
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('ATRYBUTY') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_zagraniczna_przesylka',
            ),
            array(
                'type' => 'textarea',
                'name' => PPPackage::PP_ZAGRANICZNA_PRZESYLKA_OPIS_PRZESYLKI,
                'label' => $this->l('Opis przesyłki'),
                'form_group_class' => 'pp_zagraniczna_przesylka',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
                'maxlength' => 500,
                'desc'=> $this->l('W opisie można użyć zmiennych <br>- {id_order} - numer zamóweniaw bazie  danych (np 1,2,3...)<br>- {reference} - zamaskowany numer zamówienia (np:ABCBVWEZ)<br>- {message} - wiadomość przekazana przez kupującego w komentarzu do zamówienia'),
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('USŁUGI DODATKOWE') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_zagraniczna_przesylka',
            ),
            array(
                'type' => 'text',
                'label'=>$this->l('Masa'),
                'name' => PPPackage::PP_ZAGRANICZNA_PRZESYLKA_MASA,
                'form_group_class' => 'pp_zagraniczna_przesylka',
                'tab' => 'services',
                'suffix' => 'kg',
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_ZAGRANICZNA_PRZESYLKA_ILOSC,
                'label' => $this->l('Ilość potwierdzeń'),
                'form_group_class' => 'pp_zagraniczna_przesylka',
                'tab' => 'services',
                'suffix' => $this->l('szt.'),
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'html_content' => '<button type="button" data-name="services" class="btn btn-default btn-settings">' . $this->l('Zapisz ustawienia') . '</button>',
                'tab' => 'services',
                'form_group_class' => 'pp_zagraniczna_przesylka',
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('ATRYBUTY') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_ems_ue',
            ),
            array(
                'type' => 'text',
                'label'=>$this->l('Masa'),
                'name' => PPPackage::PP_EMS_UE_MASA,
                'form_group_class' => 'pp_ems_ue',
                'tab' => 'services',
                'suffix' => 'kg',
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Typ opakowania'),
                'name' => PPPackage::PP_EMS_UE_TYP_OPAKOWANIA,
                'options' => array(
                    'query' => PocztaPolskaEn::getTypOpakowania(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_ems_ue',
                'tab' => 'services'
            ),
            array(
                'type' => 'textarea',
                'name' => PPPackage::PP_EMS_UE_OPIS_PRZESYLKI,
                'label' => $this->l('Opis przesyłki'),
                'form_group_class' => 'pp_ems_ue',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
                'maxlength' => 500,
                'desc'=> $this->l('W opisie można użyć zmiennych <br>- {id_order} - numer zamóweniaw bazie  danych (np 1,2,3...)<br>- {reference} - zamaskowany numer zamówienia (np:ABCBVWEZ)<br>- {message} - wiadomość przekazana przez kupującego w komentarzu do zamówienia'),
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Potwierdzenie doręczenia'),
                'name' => PPPackage::PP_EMS_UE_POTWIERDZENIE_DORECZENIA,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_EMS_UE_POTWIERDZENIE_DORECZENIA . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_EMS_UE_POTWIERDZENIE_DORECZENIA . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_ems_ue toggle_rows',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Typ potwierdzenia doręczenia'),
                'name' => PPPackage::PP_EMS_UE_TYP_POTWIERDZENIA,
                'options' => array(
                    'query' => PocztaPolskaEn::getTypPotwierdzenia(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_ems_ue ' . PPPackage::PP_EMS_UE_POTWIERDZENIE_DORECZENIA . ' 1',
                'tab' => 'services'
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_EMS_UE_NR_TEL_POTWIERDZENIA,
                'label' => $this->l('Nr. telefonu do potwierdzenia doręczenia'),
                'form_group_class' => 'pp_ems_ue ' . PPPackage::PP_EMS_UE_POTWIERDZENIE_DORECZENIA . ' 1',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_EMS_UE_EMAIL_POTWIERDZENIA,
                'label' => $this->l('Email do potwierdzenia doręczenia'),
                'form_group_class' => 'pp_ems_ue ' . PPPackage::PP_EMS_UE_POTWIERDZENIE_DORECZENIA . ' 1',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Ubezpieczenie'),
                'name' => PPPackage::PP_EMS_UE_UBEZPIECZENIE,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_EMS_UE_UBEZPIECZENIE . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_EMS_UE_UBEZPIECZENIE . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_ems_ue toggle_rows',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Wartosć ubezpieczenia'),
                'name' => PPPackage::PP_EMS_UE_WARTOSC_UBEZPIECZENIA,
                'options' => array(
                    'query' => PocztaPolskaEn::getWartoscEmsUbezpieczenia(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_ems_ue toggle_combo ' . PPPackage::PP_EMS_UE_UBEZPIECZENIE . ' 1',
                'tab' => 'services'
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_EMS_UE_OKRESLONA_WARTOSC,
                'label' => $this->l('określona wartość'),
                'form_group_class' => 'pp_ems_ue ' . PPPackage::PP_EMS_UE_UBEZPIECZENIE . ' 1 ' . PPPackage::PP_EMS_UE_WARTOSC_UBEZPIECZENIA . ' okreslona_wartosc',
                'tab' => 'services',
                'suffix' => 'zł',
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'html_content' => '<button type="button" data-name="services" class="btn btn-default btn-settings">' . $this->l('Zapisz ustawienia') . '</button>',
                'tab' => 'services',
                'form_group_class' => 'pp_ems_ue',
            ),

            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('Atrybuty') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_2021_kurier',
            ),
            array(
                'type' => 'switch',
                'tab' => 'services',
                'label' => $this->l('Nadanie przesyłki u kuriera'),
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_NADANIE_U_KURIERA,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_KURIER_NADANIE_U_KURIERA . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_KURIER_NADANIE_U_KURIERA . '_off',
                        'value' => 0
                    )
                ),
                'form_group_class' => 'pp_pocztex_2021_kurier toggle_rows',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Format'),
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_FORMAT,
                'options' => array(
                    'query' => PocztaPolskaEn::getFormats(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_pocztex_2021_kurier',
                'tab' => 'services'
            ),
            array(
                'type' => 'textarea',
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_OPIS_PRZESYLKI,
                'label' => $this->l('Opis przesyłki'),
                'form_group_class' => 'pp_pocztex_2021_kurier',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
                'maxlength' => 500,
                'desc'=> $this->l('W opisie można użyć zmiennych <br>- {id_order} - numer zamóweniaw bazie  danych (np 1,2,3...)<br>- {reference} - zamaskowany numer zamówienia (np:ABCBVWEZ)<br>- {message} - wiadomość przekazana przez kupującego w komentarzu do zamówienia'),
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('Rodzaj') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_2021_kurier',
            ),
            array(
                'type' => 'switch',
                'tab' => 'services',
                'label' => $this->l('Pobranie'),
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_POBRANIE,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_KURIER_POBRANIE . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_KURIER_POBRANIE . '_off',
                        'value' => 0
                    )
                ),
                'form_group_class' => 'pp_pocztex_2021_kurier toggle_rows',
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_NUMER_RACHUNKU,
                'label' => $this->l('Numer rachunku pobrania'),
                'form_group_class' => 'pp_pocztex_2021_kurier '.PPPackage::PP_POCZTEX_2021_KURIER_POBRANIE.' 1',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
                'desc' => $this->l('Numer rachunku pobrania bez spacji')
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_TYTUL_POBRANIA,
                'label' => $this->l('Tytuł pobrania'),
                'form_group_class' => 'pp_pocztex_2021_kurier '.PPPackage::PP_POCZTEX_2021_KURIER_POBRANIE.' 1',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
                'maxlength' => 30,
                'desc' => $this->l('W tytule można użyć zmiennych <br>- {id_order} - numer zamóweniaw bazie  danych (np 1,2,3...)<br>- {reference} - zamaskowany numer zamówienia (np:ABCBVWEZ)'),
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('USŁUGI DODATKOWE / NIESTANDARDOWE') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_2021_kurier',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Przesyłka niestandardowa'),
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_PONADGABARYT,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_KURIER_PONADGABARYT . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_KURIER_PONADGABARYT . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_2021_kurier',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Koperta Pocztex'),
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_KOPERTA_POCZTEX,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_KURIER_KOPERTA_POCZTEX . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_KURIER_KOPERTA_POCZTEX . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_2021_kurier',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Odbiór w sobotę'),
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_ODBIOR_SOBOTA,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_KURIER_ODBIOR_SOBOTA . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_KURIER_ODBIOR_SOBOTA . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_2021_kurier',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Godzina doręczenia'),
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_GODZINA_DORECZENIA,
                'options' => array(
                    'query' => PocztaPolskaEn::getGodzinaDoreczenia(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_pocztex_2021_kurier',
                'tab' => 'services'
            ),
            array(
                'type' => 'switch',
                'tab' => 'services',
                'label' => $this->l('Potwierdzenie doręczenia'),
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_POTWIERDZENIE_DORECZENIA,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_KURIER_POTWIERDZENIE_DORECZENIA . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_KURIER_POTWIERDZENIE_DORECZENIA . '_off',
                        'value' => 0
                    )
                ),
                'form_group_class' => 'pp_pocztex_2021_kurier toggle_rows',
            ),
            array(
                'type' => 'select',
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_POTWIERDZENIE_DORECZENIA_TYPE,
                'label' => $this->l('Typ potwierdzenia doręczenia'),
                'options' => array(
                    'query' => PocztaPolskaEn::getTypPotwierdzenia(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_pocztex_2021_kurier '.PPPackage::PP_POCZTEX_2021_KURIER_POTWIERDZENIE_DORECZENIA.' 1',
                'tab' => 'services',
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_POTWIERDZENIE_DORECZENIA_KONTAKT,
                'label' => $this->l('Dane do potwierdzenia doręczenia'),
                'form_group_class' => 'pp_pocztex_2021_kurier '.PPPackage::PP_POCZTEX_2021_KURIER_POTWIERDZENIE_DORECZENIA.' 1',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
                'maxlength' => 50,
                'desc' => $this->l('Określenie dodatkowych informacji związanych ze sposobem przekazania potwierdzenia doręczenia, np. numer telefonu, na który zostanie wysłany SMS, lub adres email'),
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Zawartość przesyłki'),
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_TYP_ZAWARTOSCI,
                'options' => array(
                    'query' => PocztaPolskaEn::getTypZawartosci(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_pocztex_2021_kurier toggle_combo',
                'tab' => 'services'
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_TYP_ZAWARTOSCI_INNE,
                'label' => $this->l('Zawartość szczegóły'),
                'form_group_class' => 'pp_pocztex_2021_kurier '.PPPackage::PP_POCZTEX_2021_KURIER_TYP_ZAWARTOSCI . ' INNE',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
            ),


            array(
                'type' => 'switch',
                'label' => $this->l('Deklaracja wartości'),
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_DEKLARACJA_WARTOSCI,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_KURIER_DEKLARACJA_WARTOSCI . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_KURIER_DEKLARACJA_WARTOSCI . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_2021_kurier toggle_rows',
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_WARTOSC_ZL,
                'label' => $this->l('Wartość'),
                'form_group_class' => 'pp_pocztex_2021_kurier ' . PPPackage::PP_POCZTEX_2021_KURIER_DEKLARACJA_WARTOSCI . ' 1',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
                'suffix' => 'zł',
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Waga'),
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_MASA,
                'form_group_class' => 'pp_pocztex_2021_kurier',
                'tab' => 'services',
                'suffix' => 'kg',
                'class' => 'fixed-width-xxl',
                'desc' => $this->l('W przypadku wartości pustej wartość zostanie pobrana z zamówienia')
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Ostrożnie'),
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_OSTROZNIE,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_KURIER_OSTROZNIE . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_KURIER_OSTROZNIE . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_2021_kurier',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Sprawdzenie zawartości przez odbiorcę'),
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_ODBIORCA,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_KURIER_ODBIORCA . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_KURIER_ODBIORCA . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_2021_kurier',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Ubezpieczenie'),
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_UBEZPIECZENIE,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_KURIER_UBEZPIECZENIE . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_KURIER_UBEZPIECZENIE . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_2021_kurier toggle_rows',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Wartosć ubezpieczenia'),
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_WARTOSC_UBEZPIECZENIA,
                'options' => array(
                    'query' => PocztaPolskaEn::getWartoscUbezpieczenia(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_pocztex_2021_kurier toggle_combo ' . PPPackage::PP_POCZTEX_2021_KURIER_UBEZPIECZENIE . ' 1',
                'tab' => 'services'
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_POCZTEX_2021_KURIER_OKRESLONA_WARTOSC,
                'label' => $this->l('określona wartość'),
                'form_group_class' => 'pp_pocztex_2021_kurier '.PPPackage::PP_POCZTEX_2021_KURIER_UBEZPIECZENIE . ' 1 '.PPPackage::PP_POCZTEX_2021_KURIER_WARTOSC_UBEZPIECZENIA . ' okreslona_wartosc',
                'tab' => 'services',
                'suffix' => 'zł',
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'html_content' => '<button type="button" data-name="services" class="btn btn-default btn-settings">' . $this->l('Zapisz ustawienia') . '</button>',
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_2021_kurier',
            ),


            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('Atrybuty') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_2021_dzis',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Format'),
                'name' => PPPackage::PP_POCZTEX_2021_DZIS_FORMAT,
                'options' => array(
                    'query' => PocztaPolskaEn::getFormats(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_pocztex_2021_dzis',
                'tab' => 'services'
            ),
            array(
                'type' => 'textarea',
                'name' => PPPackage::PP_POCZTEX_2021_DZIS_OPIS_PRZESYLKI,
                'label' => $this->l('Opis przesyłki'),
                'form_group_class' => 'pp_pocztex_2021_dzis',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
                'maxlength' => 500,
                'desc' => $this->l('W opisie można użyć zmiennych <br>- {id_order} - numer zamóweniaw bazie  danych (np 1,2,3...)<br>- {reference} - zamaskowany numer zamówienia (np:ABCBVWEZ)<br>- {message} - wiadomość przekazana przez kupującego w komentarzu do zamówienia'),
            ),
            array(
                'type' => 'select',
                'tab' => 'services',
                'label' => $this->l('Obszar doręczenia'),
                'name' => PPPackage::PP_POCZTEX_2021_DZIS_OBSZAR,
                'options' => array(
                    'query' => PocztaPolskaEn::getTypObszaru(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_pocztex_2021_dzis',
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('Rodzaj') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_2021_dzis',
            ),
            array(
                'type' => 'switch',
                'tab' => 'services',
                'label' => $this->l('Pobranie'),
                'name' => PPPackage::PP_POCZTEX_2021_DZIS_POBRANIE,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_DZIS_POBRANIE . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_DZIS_POBRANIE . '_off',
                        'value' => 0
                    )
                ),
                'form_group_class' => 'pp_pocztex_2021_dzis toggle_rows',
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_POCZTEX_2021_DZIS_NUMER_RACHUNKU,
                'label' => $this->l('Numer rachunku pobrania'),
                'form_group_class' => 'pp_pocztex_2021_dzis ' . PPPackage::PP_POCZTEX_2021_DZIS_POBRANIE . ' 1',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
                'desc' => $this->l('Numer rachunku pobrania bez spacji')
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_POCZTEX_2021_DZIS_TYTUL_POBRANIA,
                'label' => $this->l('Tytuł pobrania'),
                'form_group_class' => 'pp_pocztex_2021_dzis ' . PPPackage::PP_POCZTEX_2021_DZIS_POBRANIE . ' 1',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
                'maxlength' => 30,
                'desc' => $this->l('W tytule można użyć zmiennych <br>- {id_order} - numer zamóweniaw bazie  danych (np 1,2,3...)<br>- {reference} - zamaskowany numer zamówienia (np:ABCBVWEZ)'),
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('USŁUGI DODATKOWE / NIESTANDARDOWE') . '</b><hr>',
                'html_content' => '',
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_2021_dzis',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Odbiór w sobotę'),
                'name' => PPPackage::PP_POCZTEX_2021_DZIS_ODBIOR_SOBOTA,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_DZIS_ODBIOR_SOBOTA . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_DZIS_ODBIOR_SOBOTA . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_2021_dzis',
            ),
            array(
                'type' => 'switch',
                'tab' => 'services',
                'label' => $this->l('Potwierdzenie doręczenia'),
                'name' => PPPackage::PP_POCZTEX_2021_DZIS_POTWIERDZENIE_DORECZENIA,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_DZIS_POTWIERDZENIE_DORECZENIA . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_DZIS_POTWIERDZENIE_DORECZENIA . '_off',
                        'value' => 0
                    )
                ),
                'form_group_class' => 'pp_pocztex_2021_dzis toggle_rows',
            ),
            array(
                'type' => 'select',
                'name' => PPPackage::PP_POCZTEX_2021_DZIS_POTWIERDZENIE_DORECZENIA_TYPE,
                'label' => $this->l('Typ potwierdzenia doręczenia'),
                'options' => array(
                    'query' => PocztaPolskaEn::getTypPotwierdzenia(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_pocztex_2021_dzis ' . PPPackage::PP_POCZTEX_2021_DZIS_POTWIERDZENIE_DORECZENIA . ' 1',
                'tab' => 'services',
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_POCZTEX_2021_DZIS_POTWIERDZENIE_DORECZENIA_KONTAKT,
                'label' => $this->l('Dane do potwierdzenia doręczenia'),
                'form_group_class' => 'pp_pocztex_2021_dzis ' . PPPackage::PP_POCZTEX_2021_DZIS_POTWIERDZENIE_DORECZENIA . ' 1',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
                'maxlength' => 50,
                'desc' => $this->l('Określenie dodatkowych informacji związanych ze sposobem przekazania potwierdzenia doręczenia, np. numer telefonu, na który zostanie wysłany SMS, lub adres email'),
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Zawartość przesyłki'),
                'name' => PPPackage::PP_POCZTEX_2021_DZIS_TYP_ZAWARTOSCI,
                'options' => array(
                    'query' => PocztaPolskaEn::getTypZawartosci(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_pocztex_2021_dzis toggle_combo',
                'tab' => 'services'
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_POCZTEX_2021_DZIS_TYP_ZAWARTOSCI_INNE,
                'label' => $this->l('Zawartość szczegóły'),
                'form_group_class' => 'pp_pocztex_2021_dzis ' . PPPackage::PP_POCZTEX_2021_DZIS_TYP_ZAWARTOSCI . ' INNE',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
            ),


            array(
                'type' => 'switch',
                'label' => $this->l('Deklaracja wartości'),
                'name' => PPPackage::PP_POCZTEX_2021_DZIS_DEKLARACJA_WARTOSCI,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_DZIS_DEKLARACJA_WARTOSCI . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_DZIS_DEKLARACJA_WARTOSCI . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_2021_dzis toggle_rows',
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_POCZTEX_2021_DZIS_WARTOSC_ZL,
                'label' => $this->l('Wartość'),
                'form_group_class' => 'pp_pocztex_2021_dzis ' . PPPackage::PP_POCZTEX_2021_DZIS_DEKLARACJA_WARTOSCI . ' 1',
                'tab' => 'services',
                'class' => 'fixed-width-xxl',
                'suffix' => 'zł',
            ),
            array(
                'type' => 'text',
                'label' => $this->l('Waga'),
                'name' => PPPackage::PP_POCZTEX_2021_DZIS_MASA,
                'form_group_class' => 'pp_pocztex_2021_dzis',
                'tab' => 'services',
                'suffix' => 'kg',
                'class' => 'fixed-width-xxl',
                'desc' => $this->l('W przypadku wartości pustej wartość zostanie pobrana z zamówienia')
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Ostrożnie'),
                'name' => PPPackage::PP_POCZTEX_2021_DZIS_OSTROZNIE,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_DZIS_OSTROZNIE . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_DZIS_OSTROZNIE . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_2021_dzis',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Sprawdzenie zawartości przez odbiorcę'),
                'name' => PPPackage::PP_POCZTEX_2021_DZIS_ODBIORCA,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_DZIS_ODBIORCA . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_DZIS_ODBIORCA . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_2021_dzis',
            ),
            array(
                'type' => 'switch',
                'label' => $this->l('Ubezpieczenie'),
                'name' => PPPackage::PP_POCZTEX_2021_DZIS_UBEZPIECZENIE,
                'values' => array(
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_DZIS_UBEZPIECZENIE . '_on',
                        'value' => 1
                    ),
                    array(
                        'id' => PPPackage::PP_POCZTEX_2021_DZIS_UBEZPIECZENIE . '_off',
                        'value' => 0
                    )
                ),
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_2021_dzis toggle_rows',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Wartosć ubezpieczenia'),
                'name' => PPPackage::PP_POCZTEX_2021_DZIS_WARTOSC_UBEZPIECZENIA,
                'options' => array(
                    'query' => PocztaPolskaEn::getWartoscUbezpieczenia(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'form_group_class' => 'pp_pocztex_2021_dzis toggle_combo ' . PPPackage::PP_POCZTEX_2021_DZIS_UBEZPIECZENIE . ' 1',
                'tab' => 'services'
            ),
            array(
                'type' => 'text',
                'name' => PPPackage::PP_POCZTEX_2021_DZIS_OKRESLONA_WARTOSC,
                'label' => $this->l('określona wartość'),
                'form_group_class' => 'pp_pocztex_2021_dzis ' . PPPackage::PP_POCZTEX_2021_DZIS_UBEZPIECZENIE . ' 1 ' . PPPackage::PP_POCZTEX_2021_DZIS_WARTOSC_UBEZPIECZENIA . ' okreslona_wartosc',
                'tab' => 'services',
                'suffix' => 'zł',
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'html_content' => '<button type="button" data-name="services" class="btn btn-default btn-settings">' . $this->l('Zapisz ustawienia') . '</button>',
                'tab' => 'services',
                'form_group_class' => 'pp_pocztex_2021_dzis',
            ),
        );

        return $services;
    }

    /**
     * metoda przygotowujaca dane do formularza w zakladce Pomoc
     * @return array
     */
    public function getHelpTab() {
        $help = array(
            array(
                'type' => 'html',
                'name' => 'html_data',
                'label' => '<b>' . $this->l('Wersja wtyczki:') . '</b>  v. ' . $this->module->version . '<br> <b>' . $this->l('Data wtyczki:') . '</b>' . $this->module->date_version.'<br>',
                'html_content' => '<div class="alert alert-info">' . $this->l('Masz sugestię odnośnie funkcjonowania modułu Poczta Polska? Chcesz zadać pytanie? Skorzystaj z poniższego formularza') . '</div>',
                'tab' => 'help',
            ),
            array(
                'type' => 'select',
                'label' => $this->l('Temat'),
                'name' => PPSetting::PP_HELP_SUBJECT,
                'options' => array(
                    'query' => PocztaPolskaEn::getHelpThemes(),
                    'id' => 'id',
                    'name' => 'name',
                ),
                'tab' => 'help'
            ),
            array(
                'type' => 'text',
                'name' => PPSetting::PP_HELP_NAME_SURNAME,
                'label' => $this->l('Imię i nazwisko'),
                'tab' => 'help',
                'required' => true,
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'text',
                'name' => PPSetting::PP_HELP_EMAIL,
                'label' => $this->l('Adres e-mail'),
                'tab' => 'help',
                'readonly' => true,
                'required' => true,
                'class' => 'fixed-width-xxl',
            ),
            array(
                'type' => 'textarea',
                'label' => $this->l('Wiadomość'),
                'name' => PPSetting::PP_HELP_TEXT,
                'tab' => 'help',
                'class' => 'fixed-width-xxl',
                'required' => true,
            ),
            array(
                'type' => 'html',
                'name' => 'html_data',
                'html_content' => '<button type="button" data-name="help" class="btn btn-default btn-settings">' . $this->l('Wyślij wiadomość') . '</button>',
                'tab' => 'help',
            ),
        );
        return $help;
    }
    /**
     * metoda zapisujaca dane z zakladki moje konto
     * @return array
     */
    public function processSettings() {

        if (!Tools::isEmpty(Tools::getValue(PPSetting::PP_USER)) && Tools::isEmpty(Tools::getValue(PPSetting::PP_PASSWORD))) {
            return $this->errors[] = $this->l('Wprowadź hasło');
        }
        if (Tools::isEmpty(Tools::getValue(PPSetting::PP_USER)) && !Tools::isEmpty(Tools::getValue(PPSetting::PP_PASSWORD))) {
            return $this->errors[] = $this->l('Wprowadź użytkownika');
        }
        //w przypadku zmiany uzytkownika badz konta czyścimy zmienne dla default_karta i dla default urzad i czyścimy urzedy nadania
        if(Tools::getValue(PPSetting::PP_USER) != Configuration::get(PPSetting::PP_USER) || Tools::getValue(PPSetting::PP_TEST_URL) != Configuration::get(PPSetting::PP_TEST_URL)){
           $_POST[PPSetting::PP_DEFAULT_KARTA_ID] = '';
           $_POST[PPSetting::PP_DEFAULT_URZAD_ID] = '';
        }

        if(Tools::getValue(PPSetting::PP_PROCESS_DATA_RODO) != Configuration::get(PPSetting::PP_PROCESS_DATA_RODO)){
            $this->module->sendRodoInformation(true,Tools::getValue(PPSetting::PP_PROCESS_DATA_RODO));
        }

        if(Tools::getValue(PPSetting::PP_PROCESS_INFORMATION_RODO) != Configuration::get(PPSetting::PP_PROCESS_INFORMATION_RODO)){
            $this->module->sendRodoInformation(false,Tools::getValue(PPSetting::PP_PROCESS_INFORMATION_RODO));
        }

        if(!Tools::getValue(PPSetting::PP_PROCESS_DATA_RODO)){
            $_POST[PPSetting::PP_USER] = '';
            $_POST[PPSetting::PP_PASSWORD] = '';
        }

        Configuration::updateValue(PPSetting::PP_USER, Tools::getValue(PPSetting::PP_USER));
        Configuration::updateValue(PPSetting::PP_PASSWORD, Tools::getValue(PPSetting::PP_PASSWORD));
        Configuration::updateValue(PPSetting::PP_TEST_URL, Tools::getValue(PPSetting::PP_TEST_URL));
        Configuration::updateValue(PPSetting::PP_PROCESS_DATA_RODO, Tools::getValue(PPSetting::PP_PROCESS_DATA_RODO));
        Configuration::updateValue(PPSetting::PP_PROCESS_INFORMATION_RODO, Tools::getValue(PPSetting::PP_PROCESS_INFORMATION_RODO));


            $account = ENadawca::Account();
            $hello = $account->hello();
            if(!$hello){
                Configuration::updateValue(PPSetting::PP_IS_CONNECTED, 0);
                return;
            } else {
                if(!Tools::isEmpty(Tools::getValue(PPSetting::PP_DEFAULT_KARTA_ID))){
                    $cart = ENadawca::Karta();
                    $cart->setDefault(Tools::getValue(PPSetting::PP_DEFAULT_KARTA_ID));
                    Configuration::updateValue(PPSetting::PP_DEFAULT_KARTA_ID, Tools::getValue(PPSetting::PP_DEFAULT_KARTA_ID));
                }

                Configuration::updateValue(PPSetting::PP_IS_CONNECTED, 1);
            }
        //przy zmianie urzedu generujemy aktywny zbiór na wybrany urząd
        if(Configuration::get(PPSetting::PP_DEFAULT_URZAD_ID) !='' && Tools::getValue(PPSetting::PP_DEFAULT_URZAD_ID) != Configuration::get(PPSetting::PP_DEFAULT_URZAD_ID)){

            $buffors = PPOrderSet::getActiveCollection();
            $buffor = $buffors->getFirst();


            if (is_object($buffor) && $buffor->id_post_office != Tools::getValue(PPSetting::PP_DEFAULT_URZAD_ID)) {
                $buffor->active = 0;
                $buffor->save();
                $defaultOffice = new PPPostOffice(Tools::getValue(PPSetting::PP_DEFAULT_URZAD_ID));
                PPOrderSet::createDefault($defaultOffice);
            }
        }

        Configuration::updateValue(PPSetting::PP_DEFAULT_URZAD_ID, Tools::getValue(PPSetting::PP_DEFAULT_URZAD_ID));

        if (!Tools::isEmpty(Tools::getValue(PPSetting::PP_PASSWORD_NEW))) {
            if (!preg_match('/^(?=.*?[A-Z])(?=(.*[a-z]){1,})(?=(.*[\d]){1,})(?!.*\s).{8,}$/', Tools::getValue(PPSetting::PP_PASSWORD_NEW))) {
                return $this->errors[] = $this->l('Hasło powinno posiadać przynajmniej 8 znaków, jedną cyfrę, jedną dużą literę, jedną małą literę');
            }
            if (Tools::getValue(PPSetting::PP_PASSWORD_NEW) !== Tools::getValue(PPSetting::PP_PASSWORD_NEW_REPEAT)) {
                return $this->errors[] = $this->l('Powtórzone hasło powinno być takie samo jako nowe');
            }
            $password = ENadawca::Password();
            if ($password->change(Tools::getValue(PPSetting::PP_PASSWORD_NEW)) !== false) {
                Configuration::updateValue(PPSetting::PP_PASSWORD, Tools::getValue(PPSetting::PP_PASSWORD_NEW));
                $password::resetWebservice();
                unset($_POST[PPSetting::PP_PASSWORD]);
                unset($_POST[PPSetting::PP_PASSWORD_NEW]);
                unset($_POST[PPSetting::PP_PASSWORD_NEW_REPEAT]);
                $this->confirmations[] = $this->l('Zmiana hasła przebiegła pomyślnie');
            } else {
                $this->errors[] = implode(',', $password->getErrors());
            }
        } else {
            PPPostOffice::reloadData();
            PPProfileAddress::reloadData();
            PPPostOffice::clearCollection();
            PPProfileAddress::clearCollection();
            $this->confirmations[] = $this->l('Dane zapisane poprawnie');
        }

    }
    /**
     * metoda zapisujaca dane z zakladki Statusy
     * @return array
     */
    public function processStatuses() {
        Configuration::updateValue(PPSetting::PP_IS_STATUS_CREATE, Tools::getValue(PPSetting::PP_IS_STATUS_CREATE));
        Configuration::updateValue(PPSetting::PP_STATUS_CREATE, Tools::getValue(PPSetting::PP_STATUS_CREATE));
        Configuration::updateValue(PPSetting::PP_IS_STATUS_PRINT_LABEL, Tools::getValue(PPSetting::PP_IS_STATUS_PRINT_LABEL));
        Configuration::updateValue(PPSetting::PP_STATUS_PRINT_LABEL, Tools::getValue(PPSetting::PP_STATUS_PRINT_LABEL));
        Configuration::updateValue(PPSetting::PP_IS_STATUS_OFFICE_SEND, Tools::getValue(PPSetting::PP_IS_STATUS_OFFICE_SEND));
        Configuration::updateValue(PPSetting::PP_STATUS_OFFICE_SEND, Tools::getValue(PPSetting::PP_STATUS_OFFICE_SEND));

        $this->confirmations[] = $this->l('Dane zapisane poprawnie');
    }

    /**
     * metoda zapisujaca dane z zakladki dostawa
     * @return array
     */
    public function processDelivery() {

        $pickup_at_point_cod = array();
        $pickup_at_point_standard = array();

        if (Tools::getValue(PPPackage::PP_POCZTEX_IS_PICKUP_AT_POINT)) {
            if (Tools::getValue(PPPackage::PP_POCZTEX_PICKUP_AT_POINT_STANDARD) == false &&
                    Tools::getValue(PPPackage::PP_POCZTEX_PICKUP_AT_POINT_COD) == false) {
                $this->errors[] = $this->l('Pocztex: W przypadku zaznaczenia odbioru w punkcie wybierz przynajmniej jedną przesyłkę: standardową lub pobraniową');
            }
        } else {
            $_POST[PPPackage::PP_POCZTEX_PICKUP_AT_POINT_STANDARD] = '';
            $_POST[PPPackage::PP_POCZTEX_PICKUP_AT_POINT_COD] = '';
        }
        if (Tools::getValue(PPPackage::PP_POCZTEX_48_IS_PICKUP_AT_POINT)) {
            if (Tools::getValue(PPPackage::PP_POCZTEX_48_PICKUP_AT_POINT_STANDARD) == false &&
                    Tools::getValue(PPPackage::PP_POCZTEX_48_PICKUP_AT_POINT_COD) == false) {
                $this->errors[] = $this->l('Kurier Pocztex 48 : W przypadku zaznaczenia odbioru w punkcie wybierz przynajmniej jedną przesyłkę: standardową lub pobraniową');
            }
        }  else {
            $_POST[PPPackage::PP_POCZTEX_48_PICKUP_AT_POINT_STANDARD] = '';
            $_POST[PPPackage::PP_POCZTEX_48_PICKUP_AT_POINT_COD] = '';
        }

        if (Tools::getValue(PPPackage::PP_POCZTEX_2021_KURIER_IS_PICKUP_AT_POINT)) {
            if (Tools::getValue(PPPackage::PP_POCZTEX_2021_KURIER_PICKUP_AT_POINT_STANDARD) == false &&
                Tools::getValue(PPPackage::PP_POCZTEX_2021_KURIER_PICKUP_AT_POINT_COD) == false) {
                $this->errors[] = $this->l('Kurier Pocztex PP_POCZTEX_2021_KURIER_PICKUP_AT_POINT_COD : W przypadku zaznaczenia odbioru w punkcie wybierz przynajmniej jedną przesyłkę: standardową lub pobraniową');
            }
        }  else {
            $_POST[PPPackage::PP_POCZTEX_2021_KURIER_PICKUP_AT_POINT_STANDARD] = '';
            $_POST[PPPackage::PP_POCZTEX_2021_KURIER_PICKUP_AT_POINT_COD] = '';
        }

        $values = PPSetting::getAllValues();
        $tabCarriers = array();
        foreach($values as $key=>$value){
            if(strpos($key,'delivery')!== false){
                if(is_array($value)){
                    foreach($value as $carrierId){
                        $key = str_replace('automat', 'point', $key);
                        $tabCarriers[$carrierId][$key] = $key;
                    }
                }

            }
        }

        


        $ppServices = PocztaPolskaEn::getAllPPServices();

        foreach($tabCarriers as $key =>$services){
            if(count($services) > 1){
                $carrier = new Carrier($key);
                $error = sprintf($this->l('Przewoźnik %s -  nie może być obsługiwany przez kilka usług pocztowych: '), $carrier->name);
                foreach($services as $service){
                    $error.= $ppServices[str_replace('_delivery','',$service)].',';
                }
                $this->errors[] = trim($error,',');
            }
        }

        if (count($this->errors) > 0) {
            return $this->errors;
        }

        foreach($this->tabConfigValues as $key){
            Configuration::updateValue(
                $key,
                implode(
                    PPSetting::PP_SEPARATOR,
                    is_array(Tools::getValue($key))?Tools::getValue($key):array()
                )
            );
        }



        Configuration::updateValue(PPPackage::PP_POCZTEX_48_IS_PICKUP_AT_POINT, Tools::getValue(PPPackage::PP_POCZTEX_48_IS_PICKUP_AT_POINT));
        Configuration::updateValue(PPPackage::PP_POCZTEX_IS_PICKUP_AT_POINT, Tools::getValue(PPPackage::PP_POCZTEX_IS_PICKUP_AT_POINT));
        Configuration::updateValue(PPPackage::PP_POCZTEX_2021_KURIER_IS_PICKUP_AT_POINT, Tools::getValue(PPPackage::PP_POCZTEX_2021_KURIER_IS_PICKUP_AT_POINT));
        Configuration::updateValue(PPPackage::PP_POCZTEX_48_IS_PICKUP_AT_AUTOMAT, Tools::getValue(PPPackage::PP_POCZTEX_48_IS_PICKUP_AT_AUTOMAT));
        Configuration::updateValue(PPPackage::PP_POCZTEX_IS_PICKUP_AT_AUTOMAT, Tools::getValue(PPPackage::PP_POCZTEX_IS_PICKUP_AT_AUTOMAT));
        Configuration::updateValue(PPPackage::PP_POCZTEX_2021_KURIER_IS_PICKUP_AT_AUTOMAT, Tools::getValue(PPPackage::PP_POCZTEX_2021_KURIER_IS_PICKUP_AT_AUTOMAT));

        $this->module->reloadSelectedCarrierConfig();
        $this->confirmations[] = $this->l('Dane zapisane poprawnie');
    }

    /**
     * metoda zapisuajaca dane dotyczace zakladki uslugi
     * @return array
     */
    public function processServices() {

        if (!Tools::isEmpty(Tools::getValue(PPPackage::PP_POCZTEX_48_NUMER_RACHUNKU)) &&
                (!preg_match('/^[0-9]{26}$/', Tools::getValue(PPPackage::PP_POCZTEX_48_NUMER_RACHUNKU)))) {
            $this->errors[] = $this->l('Rachunek bankowy powinien posiadać 26 znaków i być bez spacji');
        }

        if (!Tools::isEmpty(Tools::getValue(PPPackage::PP_POCZTEX_NUMER_RACHUNKU)) &&
                (!preg_match('/^[0-9]{26}$/', Tools::getValue(PPPackage::PP_POCZTEX_NUMER_RACHUNKU)))) {
            $this->errors[] = $this->l('Rachunek bankowy powinien posiadać 26 znaków i być bez spacji');
        }

        if (Tools::getValue(PPPackage::PP_POCZTEX_48_UBEZPIECZENIE) &&
                Tools::getValue(PPPackage::PP_POCZTEX_48_WARTOSC_UBEZPIECZENIA) == 'okreslona_wartosc'
        ) {
            if (Tools::isEmpty(Tools::getValue(PPPackage::PP_POCZTEX_48_OKRESLONA_WARTOSC))) {
                $this->errors[] = $this->l('Określona wartość nie może być pusta');
            } elseif (!Validate::isInt(Tools::getValue(PPPackage::PP_POCZTEX_48_OKRESLONA_WARTOSC))) {
                $this->errors[] = $this->l('Określona wartość powinna być liczbą całkowtią');
            }
        }

        if (Tools::getValue(PPPackage::PP_POCZTEX_UBEZPIECZENIE) &&
                Tools::getValue(PPPackage::PP_POCZTEX_WARTOSC_UBEZPIECZENIA) == 'okreslona_wartosc'
        ) {
            if (Tools::isEmpty(Tools::getValue(PPPackage::PP_POCZTEX_OKRESLONA_WARTOSC))) {
                $this->errors[] = $this->l('Określona wartość nie może być pusta');
            } elseif (!Validate::isInt(Tools::getValue(PPPackage::PP_POCZTEX_OKRESLONA_WARTOSC))) {
                $this->errors[] = $this->l('Określona wartość powinna być liczbą całkowtią');
            }
        }


        if (!Tools::isEmpty(Tools::getValue(PPPackage::PP_POCZTEX_POTWIERDZENIE_ILE)) &&
                !Validate::isInt(Tools::getValue(PPPackage::PP_POCZTEX_POTWIERDZENIE_ILE))) {
            $this->errors[] = $this->l('Liczba potwierdzeń powinna być liczbą całkowtią');
        }


        if (!Tools::isEmpty(Tools::getValue(PPPackage::PP_PACZKA_POCZTOWA_POTWIERDZENIE_ILE)) &&
                !Validate::isInt(Tools::getValue(PPPackage::PP_PACZKA_POCZTOWA_POTWIERDZENIE_ILE))) {
            $this->errors[] = $this->l('Liczba potwierdzeń powinna być liczbą całkowtią');
        }


        if (Tools::getValue(PPPackage::PP_GLOBAL_EXPRESS_POTWIERDZENIE_DORECZENIA) &&
                !Tools::isEmpty(PPPackage::PP_GLOBAL_EXPRESS_NR_TEL_POTWIERDZENIA) &&
                !preg_match('/^[0-9]{9}$/', Tools::getValue(PPPackage::PP_GLOBAL_EXPRESS_NR_TEL_POTWIERDZENIA))) {
            $this->errors[] = $this->l('Nieprawidłowy numer tel. do doreczenia');
        }

        if (Tools::getValue(PPPackage::PP_GLOBAL_EXPRESS_POTWIERDZENIE_DORECZENIA) &&
                !Tools::isEmpty(PPPackage::PP_GLOBAL_EXPRESS_EMAIL_POTWIERDZENIA) &&
                !Validate::isEmail(Tools::getValue(PPPackage::PP_GLOBAL_EXPRESS_EMAIL_POTWIERDZENIA))) {
            $this->errors[] = $this->l('Wprowadź poprawny adres email');
        }

        if (!Tools::isEmpty(Tools::getValue(PPPackage::PP_PRZESYLKA_POLECONA_ILOSC)) &&
                !Validate::isInt(Tools::getValue(PPPackage::PP_PRZESYLKA_POLECONA_ILOSC))) {
            $this->errors[] = $this->l('Liczba potwierdzeń powinna być liczbą całkowtią');
        }


        if (!Tools::isEmpty(Tools::getValue(PPPackage::PP_PRZESYLKA_FIRMOWA_ILOSC)) &&
                !Validate::isInt(Tools::getValue(PPPackage::PP_PRZESYLKA_FIRMOWA_ILOSC))) {
            $this->errors[] = $this->l('Liczba potwierdzeń powinna być liczbą całkowtią');
        }


        if (!Tools::isEmpty(Tools::getValue(PPPackage::PP_PRZESYLKA_FIRMOWA_ILOSC)) &&
                !Validate::isInt(Tools::getValue(PPPackage::PP_PRZESYLKA_FIRMOWA_ILOSC))) {
            $this->errors[] = $this->l('Liczba potwierdzeń powinna być liczbą całkowtią');
        }


        if (!Tools::isEmpty(Tools::getValue(PPPackage::PP_PACZKA_UE_ILOSC)) &&
                !Validate::isInt(Tools::getValue(PPPackage::PP_PACZKA_UE_ILOSC))) {
            $this->errors[] = $this->l('Liczba potwierdzeń powinna być liczbą całkowtią');
        }


        if (Tools::getValue(PPPackage::PP_PACZKA_UE_DEKLARACJA_WARTOSCI) &&
                !preg_match("/^-?[0-9]+(?:\.[0-9]{1,2})?$/", Tools::getValue(PPPackage::PP_PACZKA_UE_DEKLARACJA_WARTOSCI_ZL))) {
            $this->errors[] = $this->l('Wartość powinna być kwotą');
        }

        if (Tools::getValue(PPPackage::PP_PACZKA_UE_ZWROT) == 'zwrot_po_liczbie_dni' &&
                !Validate::isInt(Tools::getValue(PPPackage::PP_PACZKA_UE_ILOSC_DNI))
        ) {

            $this->errors[] = $this->l('Ilość dni powinna być liczbą całkowitą');
        }

        if (!Tools::isEmpty(Tools::getValue(PPPackage::PP_ZAGRANICZNA_PRZESYLKA_ILOSC)) &&
                !Validate::isInt(Tools::getValue(PPPackage::PP_ZAGRANICZNA_PRZESYLKA_ILOSC))) {
            $this->errors[] = $this->l('Liczba potwierdzeń powinna być liczbą całkowtią');
        }

        if (Tools::getValue(PPPackage::PP_EMS_UE_POTWIERDZENIE_DORECZENIA) &&
                !Tools::isEmpty(PPPackage::PP_EMS_UE_NR_TEL_POTWIERDZENIA) &&
                !preg_match('/^[0-9]{9}$/', Tools::getValue(PPPackage::PP_EMS_UE_NR_TEL_POTWIERDZENIA))) {
            $this->errors[] = $this->l('Nieprawidłowy numer tel. do doreczenia');
        }

        if (Tools::getValue(PPPackage::PP_EMS_UE_POTWIERDZENIE_DORECZENIA) &&
                !Tools::isEmpty(PPPackage::PP_EMS_UE_EMAIL_POTWIERDZENIA) &&
                !Validate::isEmail(Tools::getValue(PPPackage::PP_EMS_UE_EMAIL_POTWIERDZENIA))) {
            $this->errors[] = $this->l('Wprowadź poprawny adres email');
        }


        if (Tools::getValue(PPPackage::PP_EMS_UE_UBEZPIECZENIE) &&
                Tools::getValue(PPPackage::PP_EMS_UE_WARTOSC_UBEZPIECZENIA) == 'okreslona_wartosc' &&
                !Validate::isInt(Tools::getValue(PPPackage::PP_EMS_UE_OKRESLONA_WARTOSC))
        ) {
            $this->errors[] = $this->l('Określona wartość powinna być liczbą całkowtią');
        }

        $allFormValues = PPSetting::getAllValues();
        $goodPattern = array('{reference}','{id_order}','{message}');
        foreach($allFormValues as $key=>$value){
            if(strpos($key,'opis_przesylki')){
                if(preg_match_all('/({.*?})/',$value,$matches)){
                    foreach($matches[0] as $text){
                        if(!in_array($text,$goodPattern)){
                            $this->errors[] = $this->l('W opisie przesyłki mogą być wykorzystywane tylko zmienne {id_order},{reference},{message}');
                            break;
                        }
                    }

                }
            }
        }

        if (count($this->errors) > 0) {
            return $this->errors;
        }
        //pocztex 48
        Configuration::updateValue(PPPackage::PP_POCZTEX_48_GABARYT, Tools::getValue(PPPackage::PP_POCZTEX_48_GABARYT));
        Configuration::updateValue(PPPackage::PP_POCZTEX_48_OPIS_PRZESYLKI, Tools::getValue(PPPackage::PP_POCZTEX_48_OPIS_PRZESYLKI));
        Configuration::updateValue(PPPackage::PP_POCZTEX_48_POBRANIE, Tools::getValue(PPPackage::PP_POCZTEX_48_POBRANIE));
        Configuration::updateValue(PPPackage::PP_POCZTEX_48_NUMER_RACHUNKU, Tools::getValue(PPPackage::PP_POCZTEX_48_NUMER_RACHUNKU));
        Configuration::updateValue(PPPackage::PP_POCZTEX_48_TYTUL_POBRANIA, Tools::getValue(PPPackage::PP_POCZTEX_48_TYTUL_POBRANIA));
        Configuration::updateValue(PPPackage::PP_POCZTEX_48_PRZESYLKA_NIESTANDARDOWA, Tools::getValue(PPPackage::PP_POCZTEX_48_PRZESYLKA_NIESTANDARDOWA));
        Configuration::updateValue(PPPackage::PP_POCZTEX_48_DEKLARACJA_WARTOSCI, Tools::getValue(PPPackage::PP_POCZTEX_48_DEKLARACJA_WARTOSCI));
        Configuration::updateValue(PPPackage::PP_POCZTEX_48_WARTOSC_ZL, Tools::getValue(PPPackage::PP_POCZTEX_48_WARTOSC_ZL));
        Configuration::updateValue(PPPackage::PP_POCZTEX_48_WARTOSC_KG, ObjectModel::formatValue(Tools::getValue(PPPackage::PP_POCZTEX_48_WARTOSC_KG), ObjectModel::TYPE_FLOAT));
        Configuration::updateValue(PPPackage::PP_POCZTEX_48_OSTROZNIE, Tools::getValue(PPPackage::PP_POCZTEX_48_OSTROZNIE));
        /*Configuration::updateValue(PPPackage::PP_POCZTEX_48_DORECZENIE_DO_RAK_WLASNYCH, Tools::getValue(PPPackage::PP_POCZTEX_48_DORECZENIE_DO_RAK_WLASNYCH));
        Configuration::updateValue(PPPackage::PP_POCZTEX_48_RODZAJ_POTWIERDZENIA, Tools::getValue(PPPackage::PP_POCZTEX_48_RODZAJ_POTWIERDZENIA));
        Configuration::updateValue(PPPackage::PP_POCZTEX_48_POTWIERDZENIE_ILE, Tools::getValue(PPPackage::PP_POCZTEX_48_POTWIERDZENIE_ILE));
        Configuration::updateValue(PPPackage::PP_POCZTEX_48_POTWIERDZENIE_ODBIORU, Tools::getValue(PPPackage::PP_POCZTEX_48_POTWIERDZENIE_ODBIORU));
        Configuration::updateValue(PPPackage::PP_POCZTEX_48_DOKUMENTY_ZWROTNE, Tools::getValue(PPPackage::PP_POCZTEX_48_DOKUMENTY_ZWROTNE));
        Configuration::updateValue(PPPackage::PP_POCZTEX_48_DOKUMENTY_RODZAJ_POTWIERDZENIA, Tools::getValue(PPPackage::PP_POCZTEX_48_DOKUMENTY_RODZAJ_POTWIERDZENIA));
        Configuration::updateValue(PPPackage::PP_POCZTEX_48_WYSLANE_DO, Tools::getValue(PPPackage::PP_POCZTEX_48_WYSLANE_DO));*/
        Configuration::updateValue(PPPackage::PP_POCZTEX_48_ODBIORCA, Tools::getValue(PPPackage::PP_POCZTEX_48_ODBIORCA));
        Configuration::updateValue(PPPackage::PP_POCZTEX_48_UBEZPIECZENIE, Tools::getValue(PPPackage::PP_POCZTEX_48_UBEZPIECZENIE));
        Configuration::updateValue(PPPackage::PP_POCZTEX_48_WARTOSC_UBEZPIECZENIA, Tools::getValue(PPPackage::PP_POCZTEX_48_WARTOSC_UBEZPIECZENIA));
        Configuration::updateValue(PPPackage::PP_POCZTEX_48_OKRESLONA_WARTOSC, Tools::getValue(PPPackage::PP_POCZTEX_48_OKRESLONA_WARTOSC));
        Configuration::updateValue(PPPackage::PP_POCZTEX_48_NALEPKA_ZWROTNA_POCZTEX, Tools::getValue(PPPackage::PP_POCZTEX_48_NALEPKA_ZWROTNA_POCZTEX));
        Configuration::updateValue(PPPackage::PP_POCZTEX_48_NUMER_WEWNETRZNY, Tools::getValue(PPPackage::PP_POCZTEX_48_NUMER_WEWNETRZNY));
        Configuration::updateValue(PPPackage::PP_POCZTEX_48_NUMER_WEWNETRZNY_TEXT, Tools::getValue(PPPackage::PP_POCZTEX_48_NUMER_WEWNETRZNY_TEXT));

        //pocztex
        Configuration::updateValue(PPPackage::PP_POCZTEX_SERWIS, Tools::getValue(PPPackage::PP_POCZTEX_SERWIS));
        Configuration::updateValue(PPPackage::PP_POCZTEX_OPIS_PRZESYLKI, Tools::getValue(PPPackage::PP_POCZTEX_OPIS_PRZESYLKI));
        Configuration::updateValue(PPPackage::PP_POCZTEX_ZAWARTOSC, Tools::getValue(PPPackage::PP_POCZTEX_ZAWARTOSC));
        Configuration::updateValue(PPPackage::PP_POCZTEX_KOPERTA, Tools::getValue(PPPackage::PP_POCZTEX_KOPERTA));
        Configuration::updateValue(PPPackage::PP_POCZTEX_UISZCZA_OPLATE, Tools::getValue(PPPackage::PP_POCZTEX_UISZCZA_OPLATE));
        Configuration::updateValue(PPPackage::PP_POCZTEX_GODZINA_DORECZENIA, Tools::getValue(PPPackage::PP_POCZTEX_GODZINA_DORECZENIA));
        Configuration::updateValue(PPPackage::PP_POCZTEX_GODZINA, Tools::getValue(PPPackage::PP_POCZTEX_GODZINA));
        Configuration::updateValue(PPPackage::PP_POCZTEX_POBRANIE, Tools::getValue(PPPackage::PP_POCZTEX_POBRANIE));
        Configuration::updateValue(PPPackage::PP_POCZTEX_SPOSOB_POBRANIA, Tools::getValue(PPPackage::PP_POCZTEX_SPOSOB_POBRANIA));
        Configuration::updateValue(PPPackage::PP_POCZTEX_NUMER_RACHUNKU, Tools::getValue(PPPackage::PP_POCZTEX_NUMER_RACHUNKU));
        Configuration::updateValue(PPPackage::PP_POCZTEX_TYTUL_POBRANIA, Tools::getValue(PPPackage::PP_POCZTEX_TYTUL_POBRANIA));
        Configuration::updateValue(PPPackage::PP_POCZTEX_WARTOSC_ZAMOWIENIA, Tools::getValue(PPPackage::PP_POCZTEX_WARTOSC_ZAMOWIENIA));
        Configuration::updateValue(PPPackage::PP_POCZTEX_DEKLARACJA_WARTOSCI, Tools::getValue(PPPackage::PP_POCZTEX_DEKLARACJA_WARTOSCI));
        Configuration::updateValue(PPPackage::PP_POCZTEX_POTWIERDZENIE_ODBIORU, Tools::getValue(PPPackage::PP_POCZTEX_POTWIERDZENIE_ODBIORU));
        Configuration::updateValue(PPPackage::PP_POCZTEX_RODZAJ_POTWIERDZENIA, Tools::getValue(PPPackage::PP_POCZTEX_RODZAJ_POTWIERDZENIA));
        Configuration::updateValue(PPPackage::PP_POCZTEX_POTWIERDZENIE_ILE, Tools::getValue(PPPackage::PP_POCZTEX_POTWIERDZENIE_ILE));
        Configuration::updateValue(PPPackage::PP_POCZTEX_POTWIERDZENIE_DORECZENIA, Tools::getValue(PPPackage::PP_POCZTEX_POTWIERDZENIE_DORECZENIA));
        Configuration::updateValue(PPPackage::PP_POCZTEX_TYP_POTWIERDZENIA, Tools::getValue(PPPackage::PP_POCZTEX_TYP_POTWIERDZENIA));
        Configuration::updateValue(PPPackage::PP_POCZTEX_NR_TEL_POTWIERDZENIA, Tools::getValue(PPPackage::PP_POCZTEX_NR_TEL_POTWIERDZENIA));
        Configuration::updateValue(PPPackage::PP_POCZTEX_EMAIL_POTWIERDZENIA, Tools::getValue(PPPackage::PP_POCZTEX_EMAIL_POTWIERDZENIA));
        Configuration::updateValue(PPPackage::PP_POCZTEX_OSTROZNIE, Tools::getValue(PPPackage::PP_POCZTEX_OSTROZNIE));
        Configuration::updateValue(PPPackage::PP_POCZTEX_PRZESYLKA_NIESTANDARDOWA, Tools::getValue(PPPackage::PP_POCZTEX_PRZESYLKA_NIESTANDARDOWA));
        Configuration::updateValue(PPPackage::PP_POCZTEX_SPRAWDZENIE_ZAWARTOSCI, Tools::getValue(PPPackage::PP_POCZTEX_SPRAWDZENIE_ZAWARTOSCI));
        Configuration::updateValue(PPPackage::PP_POCZTEX_DORECZENIE_DO_RAK_WLASNYCH, Tools::getValue(PPPackage::PP_POCZTEX_DORECZENIE_DO_RAK_WLASNYCH));
        Configuration::updateValue(PPPackage::PP_POCZTEX_DORECZENIE_W_SOBOTE, Tools::getValue(PPPackage::PP_POCZTEX_DORECZENIE_W_SOBOTE));
        Configuration::updateValue(PPPackage::PP_POCZTEX_ODBIOR_PRZESYLKI_W_SOBOTE, Tools::getValue(PPPackage::PP_POCZTEX_ODBIOR_PRZESYLKI_W_SOBOTE));
        Configuration::updateValue(PPPackage::PP_POCZTEX_DORECZENIE_W_90_MINUT, Tools::getValue(PPPackage::PP_POCZTEX_DORECZENIE_W_90_MINUT));
        Configuration::updateValue(PPPackage::PP_POCZTEX_DORECZENIE_W_NIEDZIELE_SWIETO, Tools::getValue(PPPackage::PP_POCZTEX_DORECZENIE_W_NIEDZIELE_SWIETO));
        Configuration::updateValue(PPPackage::PP_POCZTEX_DORECZENIE_W_20_7, Tools::getValue(PPPackage::PP_POCZTEX_DORECZENIE_W_20_7));
        Configuration::updateValue(PPPackage::PP_POCZTEX_ODBIOR_W_NIEDZIELE_SWIETO, Tools::getValue(PPPackage::PP_POCZTEX_ODBIOR_W_NIEDZIELE_SWIETO));
        Configuration::updateValue(PPPackage::PP_POCZTEX_ODBIOR_W_20_7, Tools::getValue(PPPackage::PP_POCZTEX_ODBIOR_W_20_7));
        Configuration::updateValue(PPPackage::PP_POCZTEX_UBEZPIECZENIE, Tools::getValue(PPPackage::PP_POCZTEX_UBEZPIECZENIE));
        Configuration::updateValue(PPPackage::PP_POCZTEX_WARTOSC_UBEZPIECZENIA, Tools::getValue(PPPackage::PP_POCZTEX_WARTOSC_UBEZPIECZENIA));
        Configuration::updateValue(PPPackage::PP_POCZTEX_OKRESLONA_WARTOSC, Tools::getValue(PPPackage::PP_POCZTEX_OKRESLONA_WARTOSC));
        Configuration::updateValue(PPPackage::PP_POCZTEX_DOKUMENTY_ZWROTNE, Tools::getValue(PPPackage::PP_POCZTEX_DOKUMENTY_ZWROTNE));
        Configuration::updateValue(PPPackage::PP_POCZTEX_DOKUMENTY_RODZAJ_POTWIERDZENIA, Tools::getValue(PPPackage::PP_POCZTEX_DOKUMENTY_RODZAJ_POTWIERDZENIA));
        Configuration::updateValue(PPPackage::PP_POCZTEX_WYSLANE_DO, Tools::getValue(PPPackage::PP_POCZTEX_WYSLANE_DO));
        Configuration::updateValue(PPPackage::PP_POCZTEX_NUMER_WEWNETRZNY, Tools::getValue(PPPackage::PP_POCZTEX_NUMER_WEWNETRZNY));
        Configuration::updateValue(PPPackage::PP_POCZTEX_NUMER_WEWNETRZNY_TEXT, Tools::getValue(PPPackage::PP_POCZTEX_NUMER_WEWNETRZNY_TEXT));
        Configuration::updateValue(PPPackage::PP_POCZTEX_MASA, ObjectModel::formatValue(Tools::getValue(PPPackage::PP_POCZTEX_MASA),ObjectModel::TYPE_FLOAT));
        //Configuration::updateValue(PPPackage::PP_POCZTEX_NA_SPECJALNYCH_ZASADACH, Tools::getValue(PPPackage::PP_POCZTEX_NA_SPECJALNYCH_ZASADACH));
        //Configuration::updateValue(PPPackage::PP_POCZTEX_NA_SPECJALNYCH_ZASADACH_WARTOSCI, Tools::getValue(PPPackage::PP_POCZTEX_NA_SPECJALNYCH_ZASADACH_WARTOSCI));
        //paczka pocztowa
        Configuration::updateValue(PPPackage::PP_PACZKA_POCZTOWA_KATEGORIA, Tools::getValue(PPPackage::PP_PACZKA_POCZTOWA_KATEGORIA));
        Configuration::updateValue(PPPackage::PP_PACZKA_POCZTOWA_GABARYT, Tools::getValue(PPPackage::PP_PACZKA_POCZTOWA_GABARYT));
        Configuration::updateValue(PPPackage::PP_PACZKA_POCZTOWA_OPIS_PRZESYLKI, Tools::getValue(PPPackage::PP_PACZKA_POCZTOWA_OPIS_PRZESYLKI));
        Configuration::updateValue(PPPackage::PP_PACZKA_POCZTOWA_DEKLARACJA_WARTOSCI, Tools::getValue(PPPackage::PP_PACZKA_POCZTOWA_DEKLARACJA_WARTOSCI));
        Configuration::updateValue(PPPackage::PP_PACZKA_POCZTOWA_DEKLARACJA_WARTOSCI_ZL, Tools::getValue(PPPackage::PP_PACZKA_POCZTOWA_DEKLARACJA_WARTOSCI_ZL));
        Configuration::updateValue(PPPackage::PP_PACZKA_POCZTOWA_POTWIERDZENIE_ILE, Tools::getValue(PPPackage::PP_PACZKA_POCZTOWA_POTWIERDZENIE_ILE));
        Configuration::updateValue(PPPackage::PP_PACZKA_POCZTOWA_NUMER_WEWNETRZNY, Tools::getValue(PPPackage::PP_PACZKA_POCZTOWA_NUMER_WEWNETRZNY));
        Configuration::updateValue(PPPackage::PP_PACZKA_POCZTOWA_NUMER_WEWNETRZNY_TEXT, Tools::getValue(PPPackage::PP_PACZKA_POCZTOWA_NUMER_WEWNETRZNY_TEXT));
        Configuration::updateValue(PPPackage::PP_PACZKA_POCZTOWA_EGZEMPLARZ_BIBLIOTECZNY, Tools::getValue(PPPackage::PP_PACZKA_POCZTOWA_EGZEMPLARZ_BIBLIOTECZNY));
        Configuration::updateValue(PPPackage::PP_PACZKA_POCZTOWA_DLA_OCIEMNIALYCH, Tools::getValue(PPPackage::PP_PACZKA_POCZTOWA_DLA_OCIEMNIALYCH));
        Configuration::updateValue(PPPackage::PP_PACZKA_POCZTOWA_MASA, ObjectModel::formatValue(Tools::getValue(PPPackage::PP_PACZKA_POCZTOWA_MASA),ObjectModel::TYPE_FLOAT));
        //global express
        Configuration::updateValue(PPPackage::PP_GLOBAL_EXPRESS_POTWIERDZENIE_DORECZENIA, Tools::getValue(PPPackage::PP_GLOBAL_EXPRESS_POTWIERDZENIE_DORECZENIA));
        Configuration::updateValue(PPPackage::PP_GLOBAL_EXPRESS_TYP_POTWIERDZENIA, Tools::getValue(PPPackage::PP_GLOBAL_EXPRESS_TYP_POTWIERDZENIA));
        Configuration::updateValue(PPPackage::PP_GLOBAL_EXPRESS_NR_TEL_POTWIERDZENIA, Tools::getValue(PPPackage::PP_GLOBAL_EXPRESS_NR_TEL_POTWIERDZENIA));
        Configuration::updateValue(PPPackage::PP_GLOBAL_EXPRESS_EMAIL_POTWIERDZENIA, Tools::getValue(PPPackage::PP_GLOBAL_EXPRESS_EMAIL_POTWIERDZENIA));
        Configuration::updateValue(PPPackage::PP_GLOBAL_EXPRESS_NUMER_WEWNETRZNY, Tools::getValue(PPPackage::PP_GLOBAL_EXPRESS_NUMER_WEWNETRZNY));
        Configuration::updateValue(PPPackage::PP_GLOBAL_EXPRESS_NUMER_WEWNETRZNY_TEXT, Tools::getValue(PPPackage::PP_GLOBAL_EXPRESS_NUMER_WEWNETRZNY_TEXT));
        Configuration::updateValue(PPPackage::PP_GLOBAL_EXPRESS_OPIS_PRZESYLKI, Tools::getValue(PPPackage::PP_GLOBAL_EXPRESS_OPIS_PRZESYLKI));
        Configuration::updateValue(PPPackage::PP_GLOBAL_EXPRESS_ZAWARTOSC, Tools::getValue(PPPackage::PP_GLOBAL_EXPRESS_ZAWARTOSC));
        Configuration::updateValue(PPPackage::PP_GLOBAL_EXPRESS_MASA, ObjectModel::formatValue(Tools::getValue(PPPackage::PP_GLOBAL_EXPRESS_MASA),ObjectModel::TYPE_FLOAT));
        //przesylka polecona
        Configuration::updateValue(PPPackage::PP_PRZESYLKA_POLECONA_KATEGORIA, Tools::getValue(PPPackage::PP_PRZESYLKA_POLECONA_KATEGORIA));
        Configuration::updateValue(PPPackage::PP_PRZESYLKA_POLECONA_FORMAT, Tools::getValue(PPPackage::PP_PRZESYLKA_POLECONA_FORMAT));
        Configuration::updateValue(PPPackage::PP_PRZESYLKA_POLECONA_OPIS_PRZESYLKI, Tools::getValue(PPPackage::PP_PRZESYLKA_POLECONA_OPIS_PRZESYLKI));
        Configuration::updateValue(PPPackage::PP_PRZESYLKA_POLECONA_ILOSC, Tools::getValue(PPPackage::PP_PRZESYLKA_POLECONA_ILOSC));
        Configuration::updateValue(PPPackage::PP_PRZESYLKA_POLECONA_NUMER_WEWNETRZNY, Tools::getValue(PPPackage::PP_PRZESYLKA_POLECONA_NUMER_WEWNETRZNY));
        Configuration::updateValue(PPPackage::PP_PRZESYLKA_POLECONA_NUMER_WEWNETRZNY_TEXT, Tools::getValue(PPPackage::PP_PRZESYLKA_POLECONA_NUMER_WEWNETRZNY_TEXT));
        Configuration::updateValue(PPPackage::PP_PRZESYLKA_POLECONA_EGZEMPLARZ_BIBLIOTECZNY, Tools::getValue(PPPackage::PP_PRZESYLKA_POLECONA_EGZEMPLARZ_BIBLIOTECZNY));
        Configuration::updateValue(PPPackage::PP_PRZESYLKA_POLECONA_DLA_OCIEMNIALYCH, Tools::getValue(PPPackage::PP_PRZESYLKA_POLECONA_DLA_OCIEMNIALYCH));
        Configuration::updateValue(PPPackage::PP_PRZESYLKA_POLECONA_MASA, ObjectModel::formatValue(Tools::getValue(PPPackage::PP_PRZESYLKA_POLECONA_MASA),ObjectModel::TYPE_FLOAT));
        //przesylka firmowa
        Configuration::updateValue(PPPackage::PP_PRZESYLKA_FIRMOWA_KATEGORIA, Tools::getValue(PPPackage::PP_PRZESYLKA_FIRMOWA_KATEGORIA));
        Configuration::updateValue(PPPackage::PP_PRZESYLKA_FIRMOWA_MIEJSCOWA_ZAMIEJSCOWA, Tools::getValue(PPPackage::PP_PRZESYLKA_FIRMOWA_MIEJSCOWA_ZAMIEJSCOWA));
        //Configuration::updateValue(PPPackage::PP_PRZESYLKA_FIRMOWA_MIASTO_WIES, Tools::getValue(PPPackage::PP_PRZESYLKA_FIRMOWA_MIASTO_WIES));
        Configuration::updateValue(PPPackage::PP_PRZESYLKA_POLECONA_ILOSC, Tools::getValue(PPPackage::PP_PRZESYLKA_POLECONA_ILOSC));
        Configuration::updateValue(PPPackage::PP_PRZESYLKA_FIRMOWA_OPIS_PRZESYLKI, Tools::getValue(PPPackage::PP_PRZESYLKA_FIRMOWA_OPIS_PRZESYLKI));
        Configuration::updateValue(PPPackage::PP_PRZESYLKA_FIRMOWA_ILOSC, Tools::getValue(PPPackage::PP_PRZESYLKA_FIRMOWA_ILOSC));
        Configuration::updateValue(PPPackage::PP_PRZESYLKA_FIRMOWA_NUMER_WEWNETRZNY, Tools::getValue(PPPackage::PP_PRZESYLKA_FIRMOWA_NUMER_WEWNETRZNY));
        Configuration::updateValue(PPPackage::PP_PRZESYLKA_FIRMOWA_NUMER_WEWNETRZNY_TEXT, Tools::getValue(PPPackage::PP_PRZESYLKA_FIRMOWA_NUMER_WEWNETRZNY_TEXT));
        Configuration::updateValue(PPPackage::PP_PRZESYLKA_FIRMOWA_MASA, ObjectModel::formatValue(Tools::getValue(PPPackage::PP_PRZESYLKA_FIRMOWA_MASA),ObjectModel::TYPE_FLOAT));

        //paczka ue
        Configuration::updateValue(PPPackage::PP_PACZKA_UE_KATEGORIA, Tools::getValue(PPPackage::PP_PACZKA_UE_KATEGORIA));
        Configuration::updateValue(PPPackage::PP_PACZKA_UE_OPIS_PRZESYLKI, Tools::getValue(PPPackage::PP_PACZKA_UE_OPIS_PRZESYLKI));
        Configuration::updateValue(PPPackage::PP_PACZKA_UE_DEKLARACJA_WARTOSCI, Tools::getValue(PPPackage::PP_PACZKA_UE_DEKLARACJA_WARTOSCI));
        Configuration::updateValue(PPPackage::PP_PACZKA_UE_DEKLARACJA_WARTOSCI_ZL, Tools::getValue(PPPackage::PP_PACZKA_UE_DEKLARACJA_WARTOSCI_ZL));
        Configuration::updateValue(PPPackage::PP_PACZKA_UE_ILOSC, Tools::getValue(PPPackage::PP_PACZKA_UE_ILOSC));
        Configuration::updateValue(PPPackage::PP_PACZKA_UE_NUMER_WEWNETRZNY, Tools::getValue(PPPackage::PP_PACZKA_UE_NUMER_WEWNETRZNY));
        Configuration::updateValue(PPPackage::PP_PACZKA_UE_NUMER_WEWNETRZNY_TEXT, Tools::getValue(PPPackage::PP_PACZKA_UE_NUMER_WEWNETRZNY_TEXT));
        Configuration::updateValue(PPPackage::PP_PACZKA_UE_ZWROT, Tools::getValue(PPPackage::PP_PACZKA_UE_ZWROT));
        Configuration::updateValue(PPPackage::PP_PACZKA_UE_SPOSOB_ZWROTU, Tools::getValue(PPPackage::PP_PACZKA_UE_SPOSOB_ZWROTU));
        Configuration::updateValue(PPPackage::PP_PACZKA_UE_ILOSC_DNI, Tools::getValue(PPPackage::PP_PACZKA_UE_ILOSC_DNI));
        Configuration::updateValue(PPPackage::PP_PACZKA_UE_MASA, ObjectModel::formatValue(Tools::getValue(PPPackage::PP_PACZKA_UE_MASA),ObjectModel::TYPE_FLOAT));
        //zagraniczna przesylka
        Configuration::updateValue(PPPackage::PP_ZAGRANICZNA_PRZESYLKA_OPIS_PRZESYLKI, Tools::getValue(PPPackage::PP_ZAGRANICZNA_PRZESYLKA_OPIS_PRZESYLKI));
        Configuration::updateValue(PPPackage::PP_ZAGRANICZNA_PRZESYLKA_OPIS_PRZESYLKI, Tools::getValue(PPPackage::PP_ZAGRANICZNA_PRZESYLKA_OPIS_PRZESYLKI));
        Configuration::updateValue(PPPackage::PP_ZAGRANICZNA_PRZESYLKA_ILOSC, Tools::getValue(PPPackage::PP_ZAGRANICZNA_PRZESYLKA_ILOSC));
        Configuration::updateValue(PPPackage::PP_ZAGRANICZNA_PRZESYLKA_NUMER_WEWNETRZNY, Tools::getValue(PPPackage::PP_ZAGRANICZNA_PRZESYLKA_NUMER_WEWNETRZNY));
        Configuration::updateValue(PPPackage::PP_ZAGRANICZNA_PRZESYLKA_NUMER_WEWNETRZNY_TEXT, Tools::getValue(PPPackage::PP_ZAGRANICZNA_PRZESYLKA_NUMER_WEWNETRZNY_TEXT));
        Configuration::updateValue(PPPackage::PP_ZAGRANICZNA_PRZESYLKA_MASA, ObjectModel::formatValue(Tools::getValue(PPPackage::PP_ZAGRANICZNA_PRZESYLKA_MASA),ObjectModel::TYPE_FLOAT));
        //ems ue
        Configuration::updateValue(PPPackage::PP_EMS_UE_TYP_OPAKOWANIA, Tools::getValue(PPPackage::PP_EMS_UE_TYP_OPAKOWANIA));
        Configuration::updateValue(PPPackage::PP_EMS_UE_OPIS_PRZESYLKI, Tools::getValue(PPPackage::PP_EMS_UE_OPIS_PRZESYLKI));
        Configuration::updateValue(PPPackage::PP_EMS_UE_POTWIERDZENIE_DORECZENIA, Tools::getValue(PPPackage::PP_EMS_UE_POTWIERDZENIE_DORECZENIA));
        Configuration::updateValue(PPPackage::PP_EMS_UE_TYP_POTWIERDZENIA, Tools::getValue(PPPackage::PP_EMS_UE_TYP_POTWIERDZENIA));
        Configuration::updateValue(PPPackage::PP_EMS_UE_NR_TEL_POTWIERDZENIA, Tools::getValue(PPPackage::PP_EMS_UE_NR_TEL_POTWIERDZENIA));
        Configuration::updateValue(PPPackage::PP_EMS_UE_EMAIL_POTWIERDZENIA, Tools::getValue(PPPackage::PP_EMS_UE_EMAIL_POTWIERDZENIA));
        Configuration::updateValue(PPPackage::PP_EMS_UE_NUMER_WEWNETRZNY, Tools::getValue(PPPackage::PP_EMS_UE_NUMER_WEWNETRZNY));
        Configuration::updateValue(PPPackage::PP_EMS_UE_NUMER_WEWNETRZNY_TEXT, Tools::getValue(PPPackage::PP_EMS_UE_NUMER_WEWNETRZNY_TEXT));
        Configuration::updateValue(PPPackage::PP_EMS_UE_UBEZPIECZENIE, Tools::getValue(PPPackage::PP_EMS_UE_UBEZPIECZENIE));
        Configuration::updateValue(PPPackage::PP_EMS_UE_WARTOSC_UBEZPIECZENIA, Tools::getValue(PPPackage::PP_EMS_UE_WARTOSC_UBEZPIECZENIA));
        Configuration::updateValue(PPPackage::PP_EMS_UE_OKRESLONA_WARTOSC, Tools::getValue(PPPackage::PP_EMS_UE_OKRESLONA_WARTOSC));
        Configuration::updateValue(PPPackage::PP_EMS_UE_MASA, ObjectModel::formatValue(Tools::getValue(PPPackage::PP_EMS_UE_MASA),ObjectModel::TYPE_FLOAT));

        #POCZTEX 2021 KURIER


        foreach($this->servicesTab as $key){
            Configuration::updateValue($key, Tools::getValue($key));
        }

        $this->confirmations[] = $this->l('Dane zapisane poprawnie');
    }

    function processHelp() {

        if (Tools::isEmpty(Tools::getValue(PPSetting::PP_HELP_NAME_SURNAME))
        ) {
            $this->errors[] = $this->l('Imię i nazwisko jest wymagane');
        }

        if (!Validate::isEmail(Tools::getValue(PPSetting::PP_HELP_EMAIL))
        ) {
            $this->errors[] = $this->l('Prawidłowy adres wiadomości jest wymagany');
        }
        if (Tools::isEmpty(Tools::getValue(PPSetting::PP_HELP_TEXT))
        ) {
            $this->errors[] = $this->l('Treść wiadomości jest wymagana');
        }
        $id_lang = (int) Configuration::get('PS_LANG_DEFAULT');
        $template_vars = array();
        if (count($this->errors) > 0) {
            return $this->errors;
        }
        $template_vars = array(
            '{www}' => $_SERVER['SERVER_NAME'],
            '{shop_name}' => Configuration::get('PS_SHOP_NAME'),
            '{date_time}' => date("Y-m-d H:i:s"),
            '{version}' => $this->module->version,
            '{date_version}' => $this->module->date_version,
            '{prestashop_version}' => _PS_VERSION_,
            '{php_version}' => phpversion(),
            '{content}' => nl2br(Tools::getValue(PPSetting::PP_HELP_TEXT)),
            '{email}' => Tools::getValue(PPSetting::PP_HELP_EMAIL),
            '{name_surname}' => Tools::getValue(PPSetting::PP_HELP_NAME_SURNAME),
            '{subject}' => Tools::getValue(PPSetting::PP_HELP_SUBJECT),
            '{karta}' => Configuration::get(PPSetting::PP_DEFAULT_KARTA_ID),
        );
        if (Mail::Send($id_lang, 'help', 'EN Plugin v. ' . $this->module->version . ' ' . Tools::getValue(PPSetting::PP_HELP_SUBJECT) . ' ' .
                        Tools::getValue(PPSetting::PP_HELP_NAME_SURNAME), $template_vars, PPSetting::PP_SUPPORT_EMAIL, null, null, null, null, null, dirname(__FILE__) . '/../../mails/')) {
            $this->confirmations[] = $this->l('Wiadomość email została wysłana');
        } else {
            $this->errors[] = $this->l('Wiadomość email nie została wysłana');
        }
    }

    /**
     * metoda ustawiajaca dane do formularzy
     * @return array
     */
    public function getValues() {
        $offices = array();
        $value = array(
            PPSetting::PP_USER => PPSetting::getSettingsValue(PPSetting::PP_USER),
            PPSetting::PP_PASSWORD => PPSetting::getSettingsValue(PPSetting::PP_PASSWORD),
            PPSetting::PP_TEST_URL => PPSetting::getSettingsValue(PPSetting::PP_TEST_URL),
            PPSetting::PP_PROCESS_DATA_RODO => PPSetting::getSettingsValue(PPSetting::PP_PROCESS_DATA_RODO),
            PPSetting::PP_PROCESS_INFORMATION_RODO => PPSetting::getSettingsValue(PPSetting::PP_PROCESS_INFORMATION_RODO),
            PPSetting::PP_PASSWORD_NEW => PPSetting::getSettingsValue(PPSetting::PP_PASSWORD_NEW),
            PPSetting::PP_PASSWORD_NEW_REPEAT => PPSetting::getSettingsValue(PPSetting::PP_PASSWORD_NEW_REPEAT),
            PPSetting::PP_IS_STATUS_CREATE => PPSetting::getSettingsValue(PPSetting::PP_IS_STATUS_CREATE),
            PPSetting::PP_STATUS_CREATE => PPSetting::getSettingsValue(PPSetting::PP_STATUS_CREATE),
            PPSetting::PP_IS_STATUS_PRINT_LABEL => PPSetting::getSettingsValue(PPSetting::PP_IS_STATUS_PRINT_LABEL),
            PPSetting::PP_STATUS_PRINT_LABEL => PPSetting::getSettingsValue(PPSetting::PP_STATUS_PRINT_LABEL),
            PPSetting::PP_IS_STATUS_OFFICE_SEND => PPSetting::getSettingsValue(PPSetting::PP_IS_STATUS_OFFICE_SEND),
            PPSetting::PP_STATUS_OFFICE_SEND => PPSetting::getSettingsValue(PPSetting::PP_STATUS_OFFICE_SEND),
            PPPackage::PP_PACKAGES => PPSetting::getSettingsValue(PPPackage::PP_PACKAGES),
            PPPackage::PP_PACKAGES_CON => PPSetting::getSettingsValue(PPPackage::PP_PACKAGES_CON),

            //POCZEX 2021
            PPPackage::PP_POCZTEX_2021_KURIER_IS_PICKUP_AT_POINT => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_2021_KURIER_IS_PICKUP_AT_POINT),
            PPPackage::PP_POCZTEX_2021_KURIER_IS_PICKUP_AT_AUTOMAT => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_2021_KURIER_IS_PICKUP_AT_AUTOMAT),

            //pocztex 48
            PPPackage::PP_POCZTEX_48_IS_PICKUP_AT_POINT => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_IS_PICKUP_AT_POINT),
            PPPackage::PP_POCZTEX_48_IS_PICKUP_AT_AUTOMAT => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_IS_PICKUP_AT_AUTOMAT),
            PPPackage::PP_POCZTEX_IS_PICKUP_AT_POINT => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_IS_PICKUP_AT_POINT),
            PPPackage::PP_POCZTEX_IS_PICKUP_AT_AUTOMAT => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_IS_PICKUP_AT_AUTOMAT),
            PPPackage::PP_POCZTEX_48_GABARYT => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_GABARYT),
            PPPackage::PP_POCZTEX_48_OPIS_PRZESYLKI => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_OPIS_PRZESYLKI),
            PPPackage::PP_POCZTEX_48_NUMER_RACHUNKU => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_NUMER_RACHUNKU),
            PPPackage::PP_POCZTEX_48_TYTUL_POBRANIA => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_TYTUL_POBRANIA),
            PPPackage::PP_POCZTEX_48_PRZESYLKA_NIESTANDARDOWA => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_PRZESYLKA_NIESTANDARDOWA),
            PPPackage::PP_POCZTEX_48_DEKLARACJA_WARTOSCI => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_DEKLARACJA_WARTOSCI),
            PPPackage::PP_POCZTEX_48_WARTOSC_ZL => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_WARTOSC_ZL),
            PPPackage::PP_POCZTEX_48_WARTOSC_KG => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_WARTOSC_KG),
            PPPackage::PP_POCZTEX_48_OSTROZNIE => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_OSTROZNIE),
            /*PPPackage::PP_POCZTEX_48_DORECZENIE_DO_RAK_WLASNYCH => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_DORECZENIE_DO_RAK_WLASNYCH),
            PPPackage::PP_POCZTEX_48_RODZAJ_POTWIERDZENIA => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_RODZAJ_POTWIERDZENIA),
            PPPackage::PP_POCZTEX_48_POTWIERDZENIE_ILE => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_POTWIERDZENIE_ILE),
            PPPackage::PP_POCZTEX_48_POTWIERDZENIE_ODBIORU => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_POTWIERDZENIE_ODBIORU),
            PPPackage::PP_POCZTEX_48_DOKUMENTY_ZWROTNE => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_DOKUMENTY_ZWROTNE),
            PPPackage::PP_POCZTEX_48_DOKUMENTY_RODZAJ_POTWIERDZENIA => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_DOKUMENTY_RODZAJ_POTWIERDZENIA),
            PPPackage::PP_POCZTEX_48_WYSLANE_DO => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_WYSLANE_DO),*/
            PPPackage::PP_POCZTEX_48_ODBIORCA => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_ODBIORCA),
            PPPackage::PP_POCZTEX_48_UBEZPIECZENIE => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_UBEZPIECZENIE),
            PPPackage::PP_POCZTEX_48_WARTOSC_UBEZPIECZENIA => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_WARTOSC_UBEZPIECZENIA),
            PPPackage::PP_POCZTEX_48_OKRESLONA_WARTOSC => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_OKRESLONA_WARTOSC),
            PPPackage::PP_POCZTEX_48_NALEPKA_ZWROTNA_POCZTEX => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_NALEPKA_ZWROTNA_POCZTEX),
            PPPackage::PP_POCZTEX_48_NUMER_WEWNETRZNY => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_NUMER_WEWNETRZNY),
            PPPackage::PP_POCZTEX_48_NUMER_WEWNETRZNY_TEXT => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_NUMER_WEWNETRZNY_TEXT),
            PPPackage::PP_POCZTEX_48_POBRANIE => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_48_POBRANIE),
            //pocztex
            PPPackage::PP_POCZTEX_SERWIS => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_SERWIS),
            PPPackage::PP_POCZTEX_OPIS_PRZESYLKI => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_OPIS_PRZESYLKI),
            PPPackage::PP_POCZTEX_ZAWARTOSC => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_ZAWARTOSC),
            PPPackage::PP_POCZTEX_KOPERTA => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_KOPERTA),
            PPPackage::PP_POCZTEX_UISZCZA_OPLATE => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_UISZCZA_OPLATE),
            PPPackage::PP_POCZTEX_GODZINA_DORECZENIA => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_GODZINA_DORECZENIA),
            PPPackage::PP_POCZTEX_GODZINA => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_GODZINA),
            PPPackage::PP_POCZTEX_POBRANIE => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_POBRANIE),
            PPPackage::PP_POCZTEX_SPOSOB_POBRANIA => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_SPOSOB_POBRANIA),
            PPPackage::PP_POCZTEX_NUMER_RACHUNKU => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_NUMER_RACHUNKU),
            PPPackage::PP_POCZTEX_TYTUL_POBRANIA => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_TYTUL_POBRANIA),
            PPPackage::PP_POCZTEX_WARTOSC_ZAMOWIENIA => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_WARTOSC_ZAMOWIENIA),
            PPPackage::PP_POCZTEX_DEKLARACJA_WARTOSCI => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_DEKLARACJA_WARTOSCI),
            PPPackage::PP_POCZTEX_POTWIERDZENIE_ODBIORU => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_POTWIERDZENIE_ODBIORU),
            PPPackage::PP_POCZTEX_RODZAJ_POTWIERDZENIA => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_RODZAJ_POTWIERDZENIA),
            PPPackage::PP_POCZTEX_POTWIERDZENIE_ILE => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_POTWIERDZENIE_ILE),
            PPPackage::PP_POCZTEX_POTWIERDZENIE_DORECZENIA => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_POTWIERDZENIE_DORECZENIA),
            PPPackage::PP_POCZTEX_TYP_POTWIERDZENIA => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_TYP_POTWIERDZENIA),
            PPPackage::PP_POCZTEX_NR_TEL_POTWIERDZENIA => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_NR_TEL_POTWIERDZENIA),
            PPPackage::PP_POCZTEX_EMAIL_POTWIERDZENIA => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_EMAIL_POTWIERDZENIA),
            PPPackage::PP_POCZTEX_OSTROZNIE => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_OSTROZNIE),
            PPPackage::PP_POCZTEX_PRZESYLKA_NIESTANDARDOWA => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_PRZESYLKA_NIESTANDARDOWA),
            PPPackage::PP_POCZTEX_SPRAWDZENIE_ZAWARTOSCI => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_SPRAWDZENIE_ZAWARTOSCI),
            PPPackage::PP_POCZTEX_DORECZENIE_DO_RAK_WLASNYCH => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_DORECZENIE_DO_RAK_WLASNYCH),
            PPPackage::PP_POCZTEX_DORECZENIE_W_SOBOTE => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_DORECZENIE_W_SOBOTE),
            PPPackage::PP_POCZTEX_ODBIOR_PRZESYLKI_W_SOBOTE => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_ODBIOR_PRZESYLKI_W_SOBOTE),
            PPPackage::PP_POCZTEX_DORECZENIE_W_90_MINUT => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_DORECZENIE_W_90_MINUT),
            PPPackage::PP_POCZTEX_DORECZENIE_W_20_7 => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_DORECZENIE_W_20_7),
            PPPackage::PP_POCZTEX_DORECZENIE_W_NIEDZIELE_SWIETO => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_DORECZENIE_W_NIEDZIELE_SWIETO),
            PPPackage::PP_POCZTEX_ODBIOR_W_20_7 => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_ODBIOR_W_20_7),
            PPPackage::PP_POCZTEX_ODBIOR_W_NIEDZIELE_SWIETO => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_ODBIOR_W_NIEDZIELE_SWIETO),
            PPPackage::PP_POCZTEX_UBEZPIECZENIE => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_UBEZPIECZENIE),
            PPPackage::PP_POCZTEX_WARTOSC_UBEZPIECZENIA => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_WARTOSC_UBEZPIECZENIA),
            PPPackage::PP_POCZTEX_OKRESLONA_WARTOSC => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_OKRESLONA_WARTOSC),
            PPPackage::PP_POCZTEX_DOKUMENTY_ZWROTNE => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_DOKUMENTY_ZWROTNE),
            PPPackage::PP_POCZTEX_DOKUMENTY_RODZAJ_POTWIERDZENIA => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_DOKUMENTY_RODZAJ_POTWIERDZENIA),
            PPPackage::PP_POCZTEX_WYSLANE_DO => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_WYSLANE_DO),
            PPPackage::PP_POCZTEX_NUMER_WEWNETRZNY => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_NUMER_WEWNETRZNY),
            PPPackage::PP_POCZTEX_NUMER_WEWNETRZNY_TEXT => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_NUMER_WEWNETRZNY_TEXT),
            PPPackage::PP_POCZTEX_MASA => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_MASA),
            //PPPackage::PP_POCZTEX_NA_SPECJALNYCH_ZASADACH => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_NA_SPECJALNYCH_ZASADACH),
            //PPPackage::PP_POCZTEX_NA_SPECJALNYCH_ZASADACH_WARTOSCI => PPSetting::getSettingsValue(PPPackage::PP_POCZTEX_NA_SPECJALNYCH_ZASADACH_WARTOSCI),
            //paczka pocztowa
            PPPackage::PP_PACZKA_POCZTOWA_KATEGORIA => PPSetting::getSettingsValue(PPPackage::PP_PACZKA_POCZTOWA_KATEGORIA),
            PPPackage::PP_PACZKA_POCZTOWA_GABARYT => PPSetting::getSettingsValue(PPPackage::PP_PACZKA_POCZTOWA_GABARYT),
            PPPackage::PP_PACZKA_POCZTOWA_OPIS_PRZESYLKI => PPSetting::getSettingsValue(PPPackage::PP_PACZKA_POCZTOWA_OPIS_PRZESYLKI),
            PPPackage::PP_PACZKA_POCZTOWA_DEKLARACJA_WARTOSCI => PPSetting::getSettingsValue(PPPackage::PP_PACZKA_POCZTOWA_DEKLARACJA_WARTOSCI),
            PPPackage::PP_PACZKA_POCZTOWA_DEKLARACJA_WARTOSCI_ZL => PPSetting::getSettingsValue(PPPackage::PP_PACZKA_POCZTOWA_DEKLARACJA_WARTOSCI_ZL),
            PPPackage::PP_PACZKA_POCZTOWA_POTWIERDZENIE_ILE => PPSetting::getSettingsValue(PPPackage::PP_PACZKA_POCZTOWA_POTWIERDZENIE_ILE),
            PPPackage::PP_PACZKA_POCZTOWA_NUMER_WEWNETRZNY => PPSetting::getSettingsValue(PPPackage::PP_PACZKA_POCZTOWA_NUMER_WEWNETRZNY),
            PPPackage::PP_PACZKA_POCZTOWA_NUMER_WEWNETRZNY_TEXT => PPSetting::getSettingsValue(PPPackage::PP_PACZKA_POCZTOWA_NUMER_WEWNETRZNY_TEXT),
            PPPackage::PP_PACZKA_POCZTOWA_EGZEMPLARZ_BIBLIOTECZNY => PPSetting::getSettingsValue(PPPackage::PP_PACZKA_POCZTOWA_EGZEMPLARZ_BIBLIOTECZNY),
            PPPackage::PP_PACZKA_POCZTOWA_DLA_OCIEMNIALYCH => PPSetting::getSettingsValue(PPPackage::PP_PACZKA_POCZTOWA_DLA_OCIEMNIALYCH),
            PPPackage::PP_PACZKA_POCZTOWA_MASA => PPSetting::getSettingsValue(PPPackage::PP_PACZKA_POCZTOWA_MASA),
            //global express
            PPPackage::PP_GLOBAL_EXPRESS_POTWIERDZENIE_DORECZENIA => PPSetting::getSettingsValue(PPPackage::PP_GLOBAL_EXPRESS_POTWIERDZENIE_DORECZENIA),
            PPPackage::PP_GLOBAL_EXPRESS_TYP_POTWIERDZENIA => PPSetting::getSettingsValue(PPPackage::PP_GLOBAL_EXPRESS_TYP_POTWIERDZENIA),
            PPPackage::PP_GLOBAL_EXPRESS_NR_TEL_POTWIERDZENIA => PPSetting::getSettingsValue(PPPackage::PP_GLOBAL_EXPRESS_NR_TEL_POTWIERDZENIA),
            PPPackage::PP_GLOBAL_EXPRESS_EMAIL_POTWIERDZENIA => PPSetting::getSettingsValue(PPPackage::PP_GLOBAL_EXPRESS_EMAIL_POTWIERDZENIA),
            PPPackage::PP_GLOBAL_EXPRESS_OPIS_PRZESYLKI => PPSetting::getSettingsValue(PPPackage::PP_GLOBAL_EXPRESS_OPIS_PRZESYLKI),
            PPPackage::PP_GLOBAL_EXPRESS_NUMER_WEWNETRZNY => PPSetting::getSettingsValue(PPPackage::PP_GLOBAL_EXPRESS_NUMER_WEWNETRZNY),
            PPPackage::PP_GLOBAL_EXPRESS_NUMER_WEWNETRZNY_TEXT => PPSetting::getSettingsValue(PPPackage::PP_GLOBAL_EXPRESS_NUMER_WEWNETRZNY_TEXT),
            PPPackage::PP_GLOBAL_EXPRESS_ZAWARTOSC => PPSetting::getSettingsValue(PPPackage::PP_GLOBAL_EXPRESS_ZAWARTOSC),
            PPPackage::PP_GLOBAL_EXPRESS_MASA => PPSetting::getSettingsValue(PPPackage::PP_GLOBAL_EXPRESS_MASA),
            //przesylka polecona
            PPPackage::PP_PRZESYLKA_POLECONA_KATEGORIA => PPSetting::getSettingsValue(PPPackage::PP_PRZESYLKA_POLECONA_KATEGORIA),
            PPPackage::PP_PRZESYLKA_POLECONA_FORMAT => PPSetting::getSettingsValue(PPPackage::PP_PRZESYLKA_POLECONA_FORMAT),
            PPPackage::PP_PRZESYLKA_POLECONA_OPIS_PRZESYLKI => PPSetting::getSettingsValue(PPPackage::PP_PRZESYLKA_POLECONA_OPIS_PRZESYLKI),
            PPPackage::PP_PRZESYLKA_POLECONA_ILOSC => PPSetting::getSettingsValue(PPPackage::PP_PRZESYLKA_POLECONA_ILOSC),
            PPPackage::PP_PRZESYLKA_POLECONA_NUMER_WEWNETRZNY => PPSetting::getSettingsValue(PPPackage::PP_PRZESYLKA_POLECONA_NUMER_WEWNETRZNY),
            PPPackage::PP_PRZESYLKA_POLECONA_NUMER_WEWNETRZNY_TEXT => PPSetting::getSettingsValue(PPPackage::PP_PRZESYLKA_POLECONA_NUMER_WEWNETRZNY_TEXT),
            PPPackage::PP_PRZESYLKA_POLECONA_EGZEMPLARZ_BIBLIOTECZNY => PPSetting::getSettingsValue(PPPackage::PP_PRZESYLKA_POLECONA_EGZEMPLARZ_BIBLIOTECZNY),
            PPPackage::PP_PRZESYLKA_POLECONA_DLA_OCIEMNIALYCH => PPSetting::getSettingsValue(PPPackage::PP_PRZESYLKA_POLECONA_DLA_OCIEMNIALYCH),
            PPPackage::PP_PRZESYLKA_POLECONA_MASA => PPSetting::getSettingsValue(PPPackage::PP_PRZESYLKA_POLECONA_MASA),
            //przesylka firmowa
            PPPackage::PP_PRZESYLKA_FIRMOWA_KATEGORIA => PPSetting::getSettingsValue(PPPackage::PP_PRZESYLKA_FIRMOWA_KATEGORIA),
            PPPackage::PP_PRZESYLKA_FIRMOWA_MIEJSCOWA_ZAMIEJSCOWA => PPSetting::getSettingsValue(PPPackage::PP_PRZESYLKA_FIRMOWA_MIEJSCOWA_ZAMIEJSCOWA),
            //PPPackage::PP_PRZESYLKA_FIRMOWA_MIASTO_WIES => PPSetting::getSettingsValue(PPPackage::PP_PRZESYLKA_FIRMOWA_MIASTO_WIES),
            PPPackage::PP_PRZESYLKA_FIRMOWA_OPIS_PRZESYLKI => PPSetting::getSettingsValue(PPPackage::PP_PRZESYLKA_FIRMOWA_OPIS_PRZESYLKI),
            PPPackage::PP_PRZESYLKA_FIRMOWA_ILOSC => PPSetting::getSettingsValue(PPPackage::PP_PRZESYLKA_FIRMOWA_ILOSC),
            PPPackage::PP_PRZESYLKA_FIRMOWA_NUMER_WEWNETRZNY => PPSetting::getSettingsValue(PPPackage::PP_PRZESYLKA_FIRMOWA_NUMER_WEWNETRZNY),
            PPPackage::PP_PRZESYLKA_FIRMOWA_NUMER_WEWNETRZNY_TEXT => PPSetting::getSettingsValue(PPPackage::PP_PRZESYLKA_FIRMOWA_NUMER_WEWNETRZNY_TEXT),
            PPPackage::PP_PRZESYLKA_FIRMOWA_MASA => PPSetting::getSettingsValue(PPPackage::PP_PRZESYLKA_FIRMOWA_MASA),
            //paczka ue
            PPPackage::PP_PACZKA_UE_KATEGORIA => PPSetting::getSettingsValue(PPPackage::PP_PACZKA_UE_KATEGORIA),
            PPPackage::PP_PACZKA_UE_OPIS_PRZESYLKI => PPSetting::getSettingsValue(PPPackage::PP_PACZKA_UE_OPIS_PRZESYLKI),
            PPPackage::PP_PACZKA_UE_DEKLARACJA_WARTOSCI => PPSetting::getSettingsValue(PPPackage::PP_PACZKA_UE_DEKLARACJA_WARTOSCI),
            PPPackage::PP_PACZKA_UE_DEKLARACJA_WARTOSCI_ZL => PPSetting::getSettingsValue(PPPackage::PP_PACZKA_UE_DEKLARACJA_WARTOSCI_ZL),
            PPPackage::PP_PACZKA_UE_ILOSC => PPSetting::getSettingsValue(PPPackage::PP_PACZKA_UE_ILOSC),
            PPPackage::PP_PACZKA_UE_NUMER_WEWNETRZNY => PPSetting::getSettingsValue(PPPackage::PP_PACZKA_UE_NUMER_WEWNETRZNY),
            PPPackage::PP_PACZKA_UE_NUMER_WEWNETRZNY_TEXT => PPSetting::getSettingsValue(PPPackage::PP_PACZKA_UE_NUMER_WEWNETRZNY_TEXT),
            PPPackage::PP_PACZKA_UE_ZWROT => PPSetting::getSettingsValue(PPPackage::PP_PACZKA_UE_ZWROT),
            PPPackage::PP_PACZKA_UE_SPOSOB_ZWROTU => PPSetting::getSettingsValue(PPPackage::PP_PACZKA_UE_SPOSOB_ZWROTU),
            PPPackage::PP_PACZKA_UE_ILOSC_DNI => PPSetting::getSettingsValue(PPPackage::PP_PACZKA_UE_ILOSC_DNI),
            PPPackage::PP_PACZKA_UE_MASA => PPSetting::getSettingsValue(PPPackage::PP_PACZKA_UE_MASA),
            //zagraniczna przesylka
            PPPackage::PP_ZAGRANICZNA_PRZESYLKA_OPIS_PRZESYLKI => PPSetting::getSettingsValue(PPPackage::PP_ZAGRANICZNA_PRZESYLKA_OPIS_PRZESYLKI),
            PPPackage::PP_ZAGRANICZNA_PRZESYLKA_ILOSC => PPSetting::getSettingsValue(PPPackage::PP_ZAGRANICZNA_PRZESYLKA_ILOSC),
            PPPackage::PP_ZAGRANICZNA_PRZESYLKA_NUMER_WEWNETRZNY => PPSetting::getSettingsValue(PPPackage::PP_ZAGRANICZNA_PRZESYLKA_NUMER_WEWNETRZNY),
            PPPackage::PP_ZAGRANICZNA_PRZESYLKA_NUMER_WEWNETRZNY_TEXT => PPSetting::getSettingsValue(PPPackage::PP_ZAGRANICZNA_PRZESYLKA_NUMER_WEWNETRZNY_TEXT),
            PPPackage::PP_ZAGRANICZNA_PRZESYLKA_MASA => PPSetting::getSettingsValue(PPPackage::PP_ZAGRANICZNA_PRZESYLKA_MASA),
            //ems ue
            PPPackage::PP_EMS_UE_TYP_OPAKOWANIA => PPSetting::getSettingsValue(PPPackage::PP_EMS_UE_TYP_OPAKOWANIA),
            PPPackage::PP_EMS_UE_OPIS_PRZESYLKI => PPSetting::getSettingsValue(PPPackage::PP_EMS_UE_OPIS_PRZESYLKI),
            PPPackage::PP_EMS_UE_POTWIERDZENIE_DORECZENIA => PPSetting::getSettingsValue(PPPackage::PP_EMS_UE_POTWIERDZENIE_DORECZENIA),
            PPPackage::PP_EMS_UE_TYP_POTWIERDZENIA => PPSetting::getSettingsValue(PPPackage::PP_EMS_UE_TYP_POTWIERDZENIA),
            PPPackage::PP_EMS_UE_NR_TEL_POTWIERDZENIA => PPSetting::getSettingsValue(PPPackage::PP_EMS_UE_NR_TEL_POTWIERDZENIA),
            PPPackage::PP_EMS_UE_EMAIL_POTWIERDZENIA => PPSetting::getSettingsValue(PPPackage::PP_EMS_UE_EMAIL_POTWIERDZENIA),
            PPPackage::PP_EMS_UE_NUMER_WEWNETRZNY => PPSetting::getSettingsValue(PPPackage::PP_EMS_UE_NUMER_WEWNETRZNY),
            PPPackage::PP_EMS_UE_NUMER_WEWNETRZNY_TEXT => PPSetting::getSettingsValue(PPPackage::PP_EMS_UE_NUMER_WEWNETRZNY_TEXT),
            PPPackage::PP_EMS_UE_UBEZPIECZENIE => PPSetting::getSettingsValue(PPPackage::PP_EMS_UE_UBEZPIECZENIE),
            PPPackage::PP_EMS_UE_WARTOSC_UBEZPIECZENIA => PPSetting::getSettingsValue(PPPackage::PP_EMS_UE_WARTOSC_UBEZPIECZENIA),
            PPPackage::PP_EMS_UE_OKRESLONA_WARTOSC => PPSetting::getSettingsValue(PPPackage::PP_EMS_UE_OKRESLONA_WARTOSC),
            PPPackage::PP_EMS_UE_MASA => PPSetting::getSettingsValue(PPPackage::PP_EMS_UE_MASA),
            //help
            PPSetting::PP_HELP_SUBJECT => PPSetting::getSettingsValue(PPSetting::PP_HELP_SUBJECT),
            PPSetting::PP_HELP_EMAIL => Configuration::get('PS_SHOP_EMAIL'),
            PPSetting::PP_HELP_NAME_SURNAME => PPSetting::getSettingsValue(PPSetting::PP_HELP_NAME_SURNAME),
            PPSetting::PP_HELP_NAME_SURNAME => PPSetting::getSettingsValue(PPSetting::PP_HELP_NAME_SURNAME),
            PPSetting::PP_HELP_TEXT => PPSetting::getSettingsValue(PPSetting::PP_HELP_TEXT),
            PPSetting::PP_DEFAULT_KARTA_ID => PPSetting::getSettingsValue(PPSetting::PP_DEFAULT_KARTA_ID),
            PPSetting::PP_DEFAULT_URZAD_ID => PPSetting::getSettingsValue(PPSetting::PP_DEFAULT_URZAD_ID),
        );




        foreach($this->tabConfigValues as $key){
            $value[$key.'[]'] = is_array(PPSetting::getSettingsValue($key)) ? PPSetting::getSettingsValue($key) : explode(PPSetting::PP_SEPARATOR, PPSetting::getSettingsValue($key));
        }

        foreach($this->servicesTab as $key){
            $value[$key] = PPSetting::getSettingsValue($key);
        }


        if ($this->user_info !== false) {
            $ulica = (isset($this->user_info['domyslnyProfil']['ulica'])?$this->user_info['domyslnyProfil']['ulica']:'');
            $nrDomu = (isset($this->user_info['domyslnyProfil']['numerDomu'])?$this->user_info['domyslnyProfil']['numerDomu']:'');
            $nrLokalu = (isset($this->user_info['domyslnyProfil']['numerLokalu'])?$this->user_info['domyslnyProfil']['numerLokalu']:'');
            $value = array_merge($value, array(
                'profil_first_name' => isset($this->user_info['firstName'])?$this->user_info['firstName']:'',
                'profil_last_name' => isset($this->user_info['lastName'])?$this->user_info['lastName']:'',
                'profil_email' => isset($this->user_info['email'])?$this->user_info['email']:'',
                'profil_name' => isset($this->user_info['domyslnyProfil']['nazwa'])?$this->user_info['domyslnyProfil']['nazwa']:'',
                'profil_ulica' => $ulica.' '.$nrDomu.(!empty($nrLokalu)?'/'.$nrLokalu:''),
                'profil_miejscowosc' => isset($this->user_info['domyslnyProfil']['miejscowosc'])?$this->user_info['domyslnyProfil']['miejscowosc']:'',
                'profil_kraj' => isset($this->user_info['domyslnyProfil']['kraj'])?$this->user_info['domyslnyProfil']['kraj']:'',
                'profil_telefon' => isset($this->user_info['domyslnyProfil']['telefon'])?$this->user_info['domyslnyProfil']['telefon']:'',
                'profil_mobile' => isset($this->user_info['domyslnyProfil']['mobile'])?$this->user_info['domyslnyProfil']['mobile']:'',
                'profil_offices[]' => $offices
                    )
            );
        } else {
                $value = array_merge($value, array(
                        'profil_first_name' => '',
                        'profil_last_name' => '',
                        'profil_email' => '',
                        'profil_name' => '',
                        'profil_ulica' =>'',
                        'profil_miejscowosc' => '',
                        'profil_kraj' => '',
                        'profil_telefon' => '',
                        'profil_mobile' => '',
                        'profil_offices[]' => ''
                    )
                );
        }
        return $value;
    }

    public function setMedia($isNewTheme = false) {
        parent::setMedia($isNewTheme);

        $this->addCSS(__PS_BASE_URI__ . 'modules/' . $this->module->name . '/views/templates/admin/css/settings.css');
        $this->addJS(__PS_BASE_URI__ . 'modules/' . $this->module->name . '/views/templates/admin/js/settings.js');
    }


    public function initModal() {
        $this->modals[] = array(
            'modal_id' => 'modal_rodo_information',
            'modal_class' => 'modal-lg',
            'modal_content' => $this->context->smarty->fetch(_PS_MODULE_DIR_ . $this->module->name . DIRECTORY_SEPARATOR . 'views/templates/admin/controllers/settings/modal.tpl'),
        );
        $this->modals[] = array(
            'modal_id' => 'modal_rodo_content',
            'modal_class' => 'modal-lg',
            'modal_title'=>$this->l('RODO'),
            'modal_content' => $this->context->smarty->fetch(_PS_MODULE_DIR_ . $this->module->name . DIRECTORY_SEPARATOR . 'views/templates/admin/controllers/settings/modal_content.tpl'),
        );
        parent::initModal();
    }

    public function ajaxProcessSaveRodo() {
        $result = array('success' => true);
        Configuration::updateValue(PPSetting::PP_PROCESS_DATA_RODO, Tools::getValue(PPSetting::PP_PROCESS_DATA_RODO));
        Configuration::updateValue(PPSetting::PP_PROCESS_INFORMATION_RODO, Tools::getValue(PPSetting::PP_PROCESS_INFORMATION_RODO));

        if(Tools::getValue(PPSetting::PP_PROCESS_DATA_RODO)){
            $this->module->sendRodoInformation(true,true);
        }
        if(Tools::getValue(PPSetting::PP_PROCESS_INFORMATION_RODO)){
            $this->module->sendRodoInformation(false,true);
        }
        die(json_encode($result));
    }

}
