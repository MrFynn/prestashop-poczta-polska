<?php

class PPSetting {
    const PP_SEPARATOR = ',';
    const PP_USER = 'pp_user';
    const PP_PASSWORD = 'pp_password';
    const PP_TEST_URL = 'pp_test_url';
    const PP_PASSWORD_NEW = 'pp_password_new';
    const PP_PASSWORD_NEW_REPEAT = 'pp_password_new_repeat';
    const PP_HELP_SUBJECT = 'pp_help_subject';
    const PP_HELP_NAME_SURNAME = 'pp_help_name_surname';
    const PP_HELP_EMAIL = 'pp_help_email';
    const PP_HELP_TEXT = 'pp_help_text';
    const PP_IS_STATUS_CREATE = 'pp_is_status_create';
    const PP_STATUS_CREATE = 'pp_status_create';
    const PP_IS_STATUS_PRINT_LABEL = 'pp_is_status_print_label';
    const PP_STATUS_PRINT_LABEL = 'pp_status_print_label';
    const PP_IS_STATUS_OFFICE_SEND = 'pp_is_status_office_send';
    const PP_STATUS_OFFICE_SEND = 'pp_status_office_send';
    const PP_DEFAULT_KARTA_ID ='pp_default_karta_id';
    const PP_DEFAULT_URZAD_ID ='pp_default_urzad_id';
    const PP_DEFAULT_KARTA_NAME = 'pp_default_karta_name';
    const PP_SUPPORT_EMAIL = 'moduly.en@poczta-polska.pl';
    const PP_SAVE_SETTINGS_SEND_EMAIL = 'pp_save_settings_send_email';
    const PP_SAVE_SETTINGS_EMAIL_TEXT = 'pp_save_settings_email_text';
    const PP_COUNT_ORDER_SET = 'pp_count_order_set';
    const PP_COUNT_ORDER_SET_DATE = 'pp_count_order_set_date';
    const PP_IS_CONNECTED = 'pp_is_connected';
    const PP_PROCESS_DATA_RODO = 'pp_process_data_rodo';
    const PP_PROCESS_INFORMATION_RODO = 'pp_process_information_rodo';

    /**
     * metoda zwracajaca status do ustawienia na zamowieniu podczas operacji na zbiorach
     * @param $name
     * @return string
     */
    public static function getStatusValue($name) {
        $isEnable = false;
        switch ($name) {
            case self::PP_STATUS_CREATE:
                $isEnable = Configuration::get(self::PP_IS_STATUS_CREATE);
                break;
            case self::PP_STATUS_PRINT_LABEL:
                $isEnable = Configuration::get(self::PP_IS_STATUS_PRINT_LABEL);
                break;
            case self::PP_STATUS_OFFICE_SEND:
                $isEnable = Configuration::get(self::PP_IS_STATUS_OFFICE_SEND);
                break;
        }

        return ($isEnable) ? Configuration::get($name) : '';
    }

    public static function getSettingsValue($name){
        return Tools::getIsset($name)?Tools::getValue($name):Configuration::get($name);
    }

    /**
     * metoda zwracajaca dostawce dla Odbioru w Punkcie
     *
     * @param bool $cod
     * @return array
     */
    public static function getPickupUpAtPoint($cod = false){
        $pickup = array();

            if(Configuration::get(PPPackage::PP_POCZTEX_48_IS_PICKUP_AT_POINT)){
                if(!$cod){
                    $pickup = explode(self::PP_SEPARATOR, Configuration::get(PPPackage::PP_POCZTEX_48_PICKUP_AT_POINT_STANDARD));
                } else {
                    $pickup = explode(self::PP_SEPARATOR, Configuration::get(PPPackage::PP_POCZTEX_48_PICKUP_AT_POINT_COD));
                }

            }
            if(Configuration::get(PPPackage::PP_POCZTEX_IS_PICKUP_AT_POINT)){
                if(!$cod){
                    $pickup = array_merge($pickup, explode(self::PP_SEPARATOR, Configuration::get(PPPackage::PP_POCZTEX_PICKUP_AT_POINT_STANDARD)));
                } else {
                    $pickup = array_merge($pickup, explode(self::PP_SEPARATOR, Configuration::get(PPPackage::PP_POCZTEX_PICKUP_AT_POINT_COD)));
                }

            }

        if(Configuration::get(PPPackage::PP_POCZTEX_2021_KURIER_IS_PICKUP_AT_POINT)){
            if(!$cod){
                $pickup = array_merge($pickup, explode(self::PP_SEPARATOR, Configuration::get(PPPackage::PP_POCZTEX_2021_KURIER_PICKUP_AT_POINT_STANDARD)));
            } else {
                $pickup = array_merge($pickup, explode(self::PP_SEPARATOR, Configuration::get(PPPackage::PP_POCZTEX_2021_KURIER_PICKUP_AT_POINT_COD)));
            }

        }

        foreach($pickup as $key => $value){
            if($value == ''){
                $pickup[$key] = 0;
            }
        }

        return $pickup;
    }

    public static function getPickupUpAtAutomat($cod = false){
        $pickup = array();

        if(Configuration::get(PPPackage::PP_POCZTEX_48_IS_PICKUP_AT_AUTOMAT)){
            if(!$cod){
                $pickup = explode(self::PP_SEPARATOR, Configuration::get(PPPackage::PP_POCZTEX_48_PICKUP_AT_AUTOMAT_STANDARD));
            } else {
                $pickup = explode(self::PP_SEPARATOR, Configuration::get(PPPackage::PP_POCZTEX_48_PICKUP_AT_AUTOMAT_COD));
            }

        }
        if(Configuration::get(PPPackage::PP_POCZTEX_IS_PICKUP_AT_AUTOMAT)){
            if(!$cod){
                $pickup = array_merge($pickup, explode(self::PP_SEPARATOR, Configuration::get(PPPackage::PP_POCZTEX_PICKUP_AT_AUTOMAT_STANDARD)));
            } else {
                $pickup = array_merge($pickup, explode(self::PP_SEPARATOR, Configuration::get(PPPackage::PP_POCZTEX_PICKUP_AT_AUTOMAT_COD)));
            }

        }

        if(Configuration::get(PPPackage::PP_POCZTEX_2021_KURIER_IS_PICKUP_AT_AUTOMAT)){
            if(!$cod){
                $pickup = array_merge($pickup, explode(self::PP_SEPARATOR, Configuration::get(PPPackage::PP_POCZTEX_2021_KURIER_PICKUP_AT_AUTOMAT_STANDARD)));
            } else {
                $pickup = array_merge($pickup, explode(self::PP_SEPARATOR, Configuration::get(PPPackage::PP_POCZTEX_2021_KURIER_PICKUP_AT_AUTOMAT_COD)));
            }

        }

        foreach($pickup as $key => $value){
            if($value == ''){
                $pickup[$key] = 0;
            }
        }

        return $pickup;
    }

    /**
     * metoda zwracajaca domyslne wartosci dla poszczegolnych przesylek PP
     * @return array
     */
    public static function getDefaultValues(){
        $default_values = array();
        $reflection = new ReflectionClass('PPPackage');
        $staticProperties = $reflection->getConstants();
        foreach($staticProperties as $key=>$value){
            $default_values[$value] = Configuration::get($value);
        }
        return $default_values;
    }

    /**
     * metoda zwracaja Karty dla danego uzytkownika API
     * @return array
     */
    public static function getCarts(){
        $cart = ENadawca::Karta();
        $carts = $cart->get();
        $tab = array();

        if($carts !== false){
            foreach($carts as $value){
                $tab[] = array('id'=>$value['idKarta'], 'name'=>$value['opis'].'('.$value['idKarta'].')');
            }
        }
        return $tab;
    }

    /**
     * metoda zwracaja rodzaje przesylek PP
     * @return array
     */
    public static function getPPDelivery(){
        $reflection = new ReflectionClass('PPPackage');
        $staticProperties = $reflection->getConstants();
        $tab = array();
        foreach($staticProperties as $key=>$value){
            if(strpos($value,'delivery') !== false){
                $con = Configuration::get($value);
                if(!empty($con)){
                    $tab = array_merge($tab,explode(PPSetting::PP_SEPARATOR,Configuration::get($value)));
                }

            }
        }
        return array_unique($tab);

    }

    /**
     * metoda zwracajaca rodzaj przesylki PP dla podanego id dostawcy
     * @param $carrierId
     * @param bool $delivery_cod
     * @return mixed|string
     */
    public static function getPackageByOrderDelvery($carrierId,$delivery_cod = false){
        $reflection = new ReflectionClass('PPPackage');
        $staticProperties = $reflection->getConstants();
        $tab = array();
        foreach($staticProperties as $key=>$value){
            if(strpos($value,'delivery') !== false){
                if(in_array($carrierId,explode(PPSetting::PP_SEPARATOR,Configuration::get($value)))){
                    return str_replace(array('_delivery','_standard','_cod','_pickup_at_point', '_pickup_at_automat'),'',$value);
                }

            }
        }
        return '';
    }


    /**
     * metoda sprawdzajaca czy podany id dostawcy posiada obsluge za pobraniem
     * @param $carierId
     * @return bool
     */
    public static function isCarrierIsCod($carierId){
        return in_array($carierId, array_merge(
            explode(PPSetting::PP_SEPARATOR, Configuration::get(PPPackage::PP_POCZTEX_DELIVERY_COD)),
            explode(PPSetting::PP_SEPARATOR, Configuration::get(PPPackage::PP_POCZTEX_PICKUP_AT_POINT_COD)),
            explode(PPSetting::PP_SEPARATOR, Configuration::get(PPPackage::PP_POCZTEX_48_DELIVERY_COD)),
            explode(PPSetting::PP_SEPARATOR, Configuration::get(PPPackage::PP_POCZTEX_48_PICKUP_AT_POINT_COD)),
            explode(PPSetting::PP_SEPARATOR, Configuration::get(PPPackage::PP_POCZTEX_2021_KURIER_DELIVERY_COD)),
            explode(PPSetting::PP_SEPARATOR, Configuration::get(PPPackage::PP_POCZTEX_2021_KURIER_PICKUP_AT_POINT_COD)),
            explode(PPSetting::PP_SEPARATOR, Configuration::get(PPPackage::PP_POCZTEX_2021_DZIS_DELIVERY_COD))
        ));
    }

    /**
     * metoda zwracajaca roznice pomiedzy 2 datami
     * @param $date1
     * @param $date2
     * @return int
     */
    public static function dateDiff($date1, $date2){
        $dateObj1 = new DateTime($date1);
        $dateObj2 = new DateTime($date2);
        $interval = $dateObj1->diff($dateObj2);

       return (int)$interval->format('%r%a');
    }

    /**
     * metoda zwracajaca table POST i GET
     * @return array
     */
    public static function getAllValues()
    {
        return $_POST + $_GET;
    }

    /**
     * metoda zwracaja bezpieczny string bez zbednych niebezpiecznych elementow
     * @param $text
     * @return string
     */
    public static function safeString($text){
        return trim(preg_replace('/[^(\x20-\x7F)\x0A\x0D]*/','', $text));
    }

    /**
     * metoda zwracajaca z textu tylko cyfry
     * @param $text
     * @return mixed
     */
    public static function onlyNumbers($text){
        return preg_replace("/[^0-9]/", "",$text);
    }

    /**
     * metoda zwracajaca kolejny numer do numeracji zbiorow
     * @return int
     */
    public static function getNextNumberForOrderSet(){
        if(!Configuration::get(PPSetting::PP_COUNT_ORDER_SET) || Configuration::get(PPSetting::PP_COUNT_ORDER_SET_DATE) != date('Y-m-d')){
            return 1;
        }

        return (int)Configuration::get(PPSetting::PP_COUNT_ORDER_SET) + 1;
    }

    /**
     * metoda zapamietujaca w ustawieniach numeracje zbiorow dla danej daty
     * @param $number
     */
    public static function setNumberOrderSet($number){

        Configuration::updateValue(PPSetting::PP_COUNT_ORDER_SET, $number);
        Configuration::updateValue(PPSetting::PP_COUNT_ORDER_SET_DATE, date('Y-m-d'));
    }
}
