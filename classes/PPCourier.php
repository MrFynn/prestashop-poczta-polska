<?php

class PPCourier extends ObjectModel {

    public $sender_name;
    public $sender_street;
    public $sender_home_number;
    public $sender_local_number;
    public $sender_place;
    public $sender_postal_code;
    public $sender_country;
    public $sender_email;
    public $sender_mobile_phone;
    public $customer_name;
    public $customer_street;
    public $customer_home_number;
    public $customer_local_number;
    public $customer_place;
    public $customer_postal_code;
    public $customer_country;
    public $customer_email;
    public $customer_mobile_phone;
    public $receipt_date;
    public $shipment_mass;
    public $shipment_quantity;
    public $receipt_hour;
    public $confirm_email;
    public static $definition = array(
        'table' => '',
        'fields' => array(
            'sender_name' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
            'sender_street' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true),
            'sender_home_number' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'sender_local_number' => array('type' => self::TYPE_STRING, 'validate' => 'isString'),
            'sender_place' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true),
            'sender_postal_code' => array('type' => self::TYPE_INT, 'validate' => 'isString', 'required' => true),
            'sender_country' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true),
            'sender_email' => array('type' => self::TYPE_STRING, 'validate' => 'isEmail'),
            'sender_mobile_phone' => array('type' => self::TYPE_STRING, 'validate' => 'isPhoneNumber', 'size' => 16),
            'customer_name' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
            'customer_street' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true),
            'customer_home_number' => array('type' => self::TYPE_STRING, 'validate' => 'isString',),
            'customer_local_number' => array('type' => self::TYPE_STRING, 'validate' => 'isString',),
            'customer_place' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true),
            'customer_postal_code' => array('type' => self::TYPE_INT, 'validate' => 'isString', 'required' => true),
            'customer_country' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true),
            'customer_email' => array('type' => self::TYPE_STRING, 'validate' => 'isEmail'),
            'customer_mobile_phone' => array('type' => self::TYPE_STRING, 'validate' => 'isPhoneNumber', 'size' => 16),
            'shipment_mass' => array('type' => self::TYPE_FLOAT, 'validate' => 'isFloat', 'required' => true),
            'receipt_date' => array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'required' => true),
            'shipment_quantity' => array('type' => self::TYPE_INT, 'validate' => 'isInt', 'required' => true),
            'receipt_hour' => array('type' => self::TYPE_INT, 'validate' => 'isString', 'required' => true),
            'confirm_email' => array('type' => self::TYPE_STRING, 'validate' => 'isEmail', 'required' => true),
        ),
    );

    public function __construct($id = null, $id_lang = null, $id_shop = null) {
        $class_name = get_class($this);
        if (!isset(ObjectModel::$loaded_classes[$class_name])) {
            $this->def = ObjectModel::getDefinition($class_name);
            $this->setDefinitionRetrocompatibility();

            ObjectModel::$loaded_classes[$class_name] = get_object_vars($this);
        } else {
            foreach (ObjectModel::$loaded_classes[$class_name] as $key => $value) {
                $this->{$key} = $value;
            }
        }

        if ($id_lang !== null) {
            $this->id_lang = (Language::getLanguage($id_lang) !== false) ? $id_lang : Configuration::get('PS_LANG_DEFAULT');
        }
        
        $this->_setFieldsFromProfil();
    }
    
    /**
     * Ustawia pola z profilu ENadawcy
     */
    protected function _setFieldsFromProfil(){
        $account = ENadawca::Account();
        $user_info = $account->getMyAccount();
        if ($account->hasErrors()) {
            $this->errors = $account->getErrors();
        } else {
            if (!empty($user_info)) {
                foreach (array('sender', 'customer') as $v) {
                    $this->{$v . '_name'} = isset($user_info['domyslnyProfil']['nazwa'])?$user_info['domyslnyProfil']['nazwa']:'';
                    $this->{$v . '_street'} = isset($user_info['domyslnyProfil']['ulica'])?$user_info['domyslnyProfil']['ulica']:'';
                    $this->{$v . '_home_number'} = isset($user_info['domyslnyProfil']['numerDomu'])?$user_info['domyslnyProfil']['numerDomu']:'';
                    $this->{$v . '_local_number'} = isset($user_info['domyslnyProfil']['numerLokalu'])?$user_info['domyslnyProfil']['numerLokalu']:'';
                    $this->{$v . '_place'} = isset($user_info['domyslnyProfil']['miejscowosc'])?$user_info['domyslnyProfil']['miejscowosc']:'';
                    $this->{$v . '_postal_code'} = isset($user_info['domyslnyProfil']['kodPocztowy'])?$user_info['domyslnyProfil']['kodPocztowy']:'';
                    $this->{$v . '_country'} = isset($user_info['domyslnyProfil']['kraj'])?$user_info['domyslnyProfil']['kraj']:'';
                    $this->{$v . '_email'} = isset($user_info['email'])?$user_info['email']:'';
                    $this->{$v . '_mobile_phone'} = isset($user_info['domyslnyProfil']['mobile'])?$user_info['domyslnyProfil']['mobile']:'';
                }
            }
        } 
    }

    /**
     * Metoda komunikuje sie ENadawca i wykonuje operacje zamow kuriera
     */
    public function add($auto_date = true, $null_values = false) {
        $courier = ENadawca::Kurier();
        $fields = $this->getFields();
        $courier->zamow(
                $fields['receipt_date'], PocztaPolskaEn::getReceptionTime($fields['receipt_hour']), $fields['shipment_quantity'], $fields['shipment_mass'], $fields['confirm_email'], Adres::get(
                        array(
                            'nazwa' => $fields['customer_name'],
                            'nazwa2' => $fields['customer_name'],
                            'ulica' => $fields['customer_street'],
                            'numerDomu' => $fields['customer_home_number'],
                            'numerLokalu' => $fields['customer_local_number'],
                            'miejscowosc' => $fields['customer_place'],
                            'kodPocztowy' => $fields['customer_postal_code'],
                            'kraj' => $fields['customer_country'],
                            'mobile' => $fields['customer_mobile_phone'],
                            'email' => $fields['customer_email'],
                        )
                ), Adres::get(
                        array(
                            'nazwa' => $fields['sender_name'],
                            'nazwa2' => $fields['sender_name'],
                            'ulica' => $fields['sender_street'],
                            'numerDomu' => $fields['sender_home_number'],
                            'numerLokalu' => $fields['sender_local_number'],
                            'miejscowosc' => $fields['sender_place'],
                            'kodPocztowy' => $fields['sender_postal_code'],
                            'kraj' => $fields['sender_country'],
                            'mobile' => $fields['sender_mobile_phone'],
                            'email' => $fields['sender_email'],
                        )
                )
        );
        if ($courier->hasErrors()) {
            $this->errors = $courier->getErrors();
            return false;
        }
        return true;
    }

}
