<?php

class PPPostOffice extends ObjectModel {

    public $name;
    public $description;
    public $id_en;
    public $id_post_office;
    public $date_add;
    public $date_upd;
    public static $definition = array(
        'table' => 'pocztapolskaen_post_office',
        'primary' => 'id_post_office',
        'fields' => array(
            'name' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
            'description' => array('type' => self::TYPE_STRING, 'validate' => 'isCleanHtml'),
            'id_en' => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
            'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'date_upd' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
        ),
    );
    private static $_data = null;
    /**
     * Metoda synchronizuje urzendy nadania z urzendami nadania ENadawcy
     */
    public static function reloadData() {
        $offices = ENadawca::UrzedyNadania()->get();
        if (isset($offices['urzadNadania'])) {
            $offices = array($offices);
        }
       if(!is_array($offices)){
           $offices = array();
           return false;
       }
        $idOffices = array();
        foreach ($offices as $o) {
            $idOffices[$o['urzadNadania']] = new PPPostOffice();
        }
        $objects = self::getCollection();
        foreach ($objects as $object) {
            if (!isset($idOffices[$object->id_en]) && !empty($object->id_post_office)) {
                $object->delete();
            } else{ 
                $idOffices[$object->id_en] = $object;
            }
        }
        foreach ($offices as $o) {
            $obj = $idOffices[$o['urzadNadania']];
            $obj->id_en = (int) $o['urzadNadania'];
            $obj->name = $o['nazwaWydruk'];
            $obj->description = $o['opis'];
            $obj->save();
        }

        return true;
    }

    /**
     * Metoda pobiera wszytskie urzedny nadania grupujac po id ENadawcy
     */
    public static function getCollection($query = false) {
        $arr = array();
        if(is_null(self::$_data)){
            self::$_data = new PrestaShopCollection('PPPostOffice');
        }
        $collection = self::$_data;
        foreach ($collection as $c) {
            if(!$query){
                $arr[$c->id_en] = $c;
            }
            else{
                $arr[] = array('id' => $c->id_post_office,'id_en'=> $c->id_en, 'name' => $c->name);
            }
        }
        return $arr;
    }

    public static function clearCollection(){
        self::$_data = null;
    }

    public static function getDefaultOffice(){
        $default = new PPPostOffice(PPSetting::getSettingsValue(PPSetting::PP_DEFAULT_URZAD_ID));
        return $default;
    }
}
