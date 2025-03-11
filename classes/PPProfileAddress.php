<?php

class PPProfileAddress extends ObjectModel {

    public $id_profile_address;
    public $name;
    public $friendly_name;
    public $id_en;
    public $street;
    public $house_number;
    public $premises_number;
    public $city;
    public $postal_code;
    public $date_add;
    public $date_upd;
    public static $definition = array(
        'table' => 'pocztapolskaen_profile_address',
        'primary' => 'id_profile_address',
        'fields' => array(
            'name' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
            'friendly_name' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName'),
            'street' => array('type' => self::TYPE_STRING),
            'house_number' => array('type' => self::TYPE_STRING),
            'premises_number' => array('type' => self::TYPE_STRING),
            'city' => array('type' => self::TYPE_STRING),
            'postal_code' => array('type' => self::TYPE_STRING),
            'id_en' => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
            'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'date_upd' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
        ),
    );
    private static $_data = null;
    /**
     * Metoda synchronizuje profile adresow dla zwroconych dokuumentow
     */
    public static function reloadData() {
        $profiles = ENadawca::Profil()->getReturnDocumentsProfileList();
        if(empty($profiles)) {
            return false;
        }
        if (!isset($profiles['profile'][0])) {
            $profiles = array($profiles['profile']);
        } else {
            $profiles = $profiles['profile'];
        }
       if(!is_array($profiles)){
           return false;
       }
        $idProfiles = array();
        foreach ($profiles as $o) {
            $idProfiles[$o['idProfile']] = new PPProfileAddress();
        }
        $objects = self::getCollection();
        foreach ($objects as $object) {
            if (!isset($idProfiles[$object->id_en]) && !empty($object->id_profile_address)) {
                $object->delete();
            } else{ 
                $idProfiles[$object->id_en] = $object;
            }
        }
        foreach ($profiles as $o) {
            if(is_array($o)) {
                $obj = $idProfiles[$o['idProfile']];
                $obj->id_en = (int) $o['idProfile'];
                $obj->name = $o['name'];
                $obj->friendly_name = $o['friendlyName'];
                $obj->street = $o['street'];
                $obj->house_number = $o['houseNumber'];
                $obj->premises_number = isset($o['premisesNumber'])?$o['premisesNumber']:'';
                $obj->city = $o['city'];
                $obj->postal_code = $o['postalCode'];
                $obj->save();
            }

        }

        return true;
    }

    /**
     * Metoda pobiera wszytskie profile adresow
     */
    public static function getCollection($query = false) {
        $arr = array();
        if(is_null(self::$_data)){
            self::$_data = new PrestaShopCollection('PPProfileAddress');
        }
        $collection = self::$_data;
        foreach ($collection as $c) {
            if(!$query){
                $arr[$c->id_en] = $c;
            }
            else{
                $arr[] = array('id' => $c->id_profile_address,'id_en'=> $c->id_en, 'name' => $c->name,
                               'friendly_name' => $c->friendly_name, 'street' => $c->street,
                               'house_number' => $c->house_number, 'premisses_number' => $c->premises_number,
                               'city' => $c->city, 'postal_code' => $c->postal_code,
                );
            }
        }
        return $arr;
    }

    public static function clearCollection(){
        self::$_data = null;
    }

}
