<?php

class PPOrderSet extends ObjectModel {

    public $name;
    public $sender_home_number;
    public $envelope_status;
    public $id_post_office;
    public $post_office;
    public $post_date;
    public $id_en;
    public $id_envelope;
    public $date_add;
    public $date_upd;
    public $active;
    public $_errors;
    private static $expiredSets = null;
    public static $definition = array(
        'table' => 'pocztapolskaen_order_set',
        'primary' => 'id_order_set',
        'fields' => array(
            'name' => array('type' => self::TYPE_STRING, 'validate' => 'isGenericName', 'required' => true),
            'active' => array('type' => self::TYPE_BOOL),
            'id_post_office' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'post_date' => array('type' => self::TYPE_DATE, 'validate' => 'isDate', 'required' => true),
            'id_en' => array('type' => self::TYPE_INT, 'validate' => 'isInt','allow_null'=>true),
            'id_envelope' => array('type' => self::TYPE_INT, 'validate' => 'isInt','allow_null'=>true),
            'envelope_status' => array('type' => self::TYPE_STRING, 'validate' => 'isString','allow_null'=>true),
            'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'date_upd' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
        )
    );

    /**
     * Metoda sprawdza czy istnieje zbiór domyślny i jeśli nie tworzy nowy
     */
    public static function createDefault($defoffice) {
        $now = date('Y-m-d');
        if(!is_object($defoffice)||!isset($defoffice->id_en)||empty($defoffice->id_en)){
            $defoffice = new PrestaShopCollection('PPPostOffice');
            if(isset($defoffice[0])){
                $defoffice = $defoffice[0];
            }
        }
        $sets = PPOrderSet::getActiveByOffice($defoffice);
        if ($sets->count() <= 0 && isset($defoffice->id_en)&& !empty($defoffice->id_en)) {
            $buffor = ENadawca::EnvelopeBuffor();
            $object = new PPOrderSet();

            $result = $buffor->create($now, $defoffice->id_en, self::getDefaultName());
            if (!$buffor->hasErrors()) {
                $object->name = self::getDefaultName();
                PPSetting::setNumberOrderSet(PPSetting::getNextNumberForOrderSet());
                $object->id_en = $result['createdBufor']['idBufor'];
                $object->active = 1;
                $object->post_date = $now;
                $object->id_post_office = $defoffice->id;
                $object->envelope_status = 'niewyslany';
                $object->save();
                return $object;
            }
        }

        return null;
    }

    public static function getDefaultName(){
        return date('Y-m-d').'/'.PPSetting::getNextNumberForOrderSet();
    }

    /**
     * Metoda synchronizuje zbiory ze zbiorami ENadawcy
     */
    public static function reloadData($deleteExpired = false) {
        $buffors = ENadawca::EnvelopeBuffor()->getList();
        if(!is_array($buffors)){
            $buffors = array();
            //return false;
        }

        $offices = PPPostOffice::getCollection();
        $objects = self::getCollection();

        $idBufor = array();
        $bufforsToDelete = array();
        $bufforsENId = array();
        foreach ($buffors as $b) {
            if (isset($objects[$b['idBufor']])) {
                $idBufor[$b['idBufor']] = $objects[$b['idBufor']];
            }
            $bufforsENId[$b['idBufor']] = $b['idBufor'];
        }
        foreach ($objects as $id=>$obj) {
            if(!in_array($id,$bufforsENId)&&empty($obj->id_envelope) && !$obj->isSendByOffice()){
                $bufforsToDelete[] = $obj;
            }
        }


        if($deleteExpired){
            $expired = self::getExpired();
            foreach ($expired as $object) {
                $object->delete(false);
                $object->deleteEnvelopeBuffor();
            }
        }
        foreach ($buffors as $buffor) {
            $obj = (isset($idBufor[$buffor['idBufor']]) && is_object($idBufor[$buffor['idBufor']])) ? $idBufor[$buffor['idBufor']] : new PPOrderSet();
            if (!isset($buffor['urzadNadania']) ||  !isset($offices[$buffor['urzadNadania']])) {
                continue;
            }
            $obj->force_id = false;
            $obj->id_en = (int) $buffor['idBufor'];
            $obj->name = empty($buffor['opis']) ? ' - ' : $buffor['opis'];
            $obj->active = $buffor['active'];
            $obj->id_post_office = $offices[$buffor['urzadNadania']]->id;
            $obj->post_date = $buffor['dataNadania'];
            $obj->envelope_status = 'niewyslany';
            $obj->save();
        }
        //synchronizacja usunietych z EN
        foreach ($bufforsToDelete as $obj) {
            $obj->delete();
        }

        return true;

    }
    /**
     * Metoda pobiera zbiory przeterminowane
     */
    public static function getExpired($col = '') {
        if(is_null(self::$expiredSets)){
            $setsCollection = new PrestaShopCollection('PPOrderSet');
            $setsCollection->where('post_date', '<=', date('Y-m-d', strtotime('-'.PocztaPolskaEn::SET_EXPIRED_DAYS.' days')));
            $setsCollection->where('id_en', '>', '0');
            self::$expiredSets = $setsCollection;
        }
        if(!empty($col)){
            $arr = array();
            foreach($setsCollection as $set){
                $arr[] = $set->{$col};
            }
            return $arr;
        }
        return self::$expiredSets;
    }

    /**
     * Metoda  zwraca wszystkie zbiory
     */
    public static function getCollection() {
        $arr = array();
        $collection = new PrestaShopCollection('PPOrderSet');
        foreach ($collection as $c) {
            $arr[$c->id_en] = $c;
        }
        return $arr;
    }

    /**
     * Metoda zwraca nie wysłane zbiory
     */
    public static function getActiveCollection() {
        $setsCollection = new PrestaShopCollection('PPOrderSet');
        $setsCollection->sqlWhere('(a0.id_envelope is null OR a0.id_envelope=0) and a0.active = 1');
        return $setsCollection;
    }
    
    /**
     * Metoda zwraca zbiory aktualne po urzedzie nadania
     */
    public static function getActiveByOffice($office) {
        $setsCollection = new PrestaShopCollection('PPOrderSet');
        $setsCollection->sqlWhere('(a0.id_envelope is null OR a0.id_envelope=0) AND a0.active = 1');
        if(is_object($office)&&isset($office->id)&&!empty($office->id)){
            $setsCollection->where('id_post_office','=',$office->id);
        }
        return $setsCollection;
    }

    /**
     * Metoda tworzy zbior w ENadawcy z lokalengo zbioru
     */
    public function addEnvelopeBuffor() {
        $buffor = ENadawca::EnvelopeBuffor();
        $fields = $this->getFields();
        $office = new PPPostOffice($fields['id_post_office']);
        $result = $buffor->create($fields['post_date'], $office->id_en, $fields['name']);
        if ($buffor->hasErrors()) {
            $this->_errors = $buffor->getErrors();
            return false;
        }
        $this->id_en = $result['createdBufor']['idBufor'];
        $this->envelope_status = 'niewyslany';
        return true;
    }
    /**
     * Metoda aktualizuje zbior w ENadawcy z lokalengo zbioru
     */
    public function updateEnvelopeBuffor() {
        $buffor = ENadawca::EnvelopeBuffor();
        $fields = $this->getFields();
        $office = new PPPostOffice($fields['id_post_office']);
        $buffor->update($fields['id_en'], $fields['post_date'], $office->id_en, $fields['name']);
        if ($buffor->hasErrors()) {
            $this->_errors = $buffor->getErrors();
            return false;
        }
        $this->id_en = $fields['id_en'];
        return true;
    }
    /**
     * Metoda usuwa zbior w ENadawcy powiazany z lokalenym zbiorem
     */
    public function deleteEnvelopeBuffor() {
        $buffor = ENadawca::EnvelopeBuffor();
        $buffor->clear($this->id_en);
        if ($buffor->hasErrors()) {
            $this->_errors = $buffor->getErrors();
            return false;
        }
        return true;
    }

    /**
     * Metoda pobiera urzad nadania
     */
    public function getPostOffice() {
        if (!empty($this->id_post_office)) {
            $object = new PPPostOffice($this->id_post_office);
            if (!empty($object->id)) {
                return $object;
            }
        }
        return null;
    }

    /**
     * Metoda zwraca wszystkie przesyłki wzgledem id zbioru przekazanego w parametrze
     */
    public function getOrdersByBuffor($idBuffor) {
        $ppOrders = new PrestaShopCollection('PPOrder');
        $ppOrders->where('id_buffor', '=', $idBuffor);
        return $ppOrders;
    }
    /**
     * Metoda zwraca zbior wzgledem id zbioru przekazanego w parametrze
     */
    public static function getByBuffor($idBuffor) {
        $ppOrderSet = new PrestaShopCollection('PPOrderSet');
        $ppOrderSet->where('id_en', '=', $idBuffor);
        if(isset($ppOrderSet[0])){
            return $ppOrderSet[0];
        }
        return new self;
    }
    /**
     * Metoda pobiera identyfikatory przesylek wzgledem id zbioru przekazanego w parametrze
     */
    public function getOrdersGuidsByBuffor($idBuffor) {
        $ppOrders = $this->getOrdersByBuffor($idBuffor);
        $guids = array();
        foreach ($ppOrders as $order) {
            $guids[] = $order->id_shipment;
        }
        return $guids;
    }

    /**
     * Metoda usuwa przesylki powiazane z buforem
     */
    public function delete($removeShippment = true) {
        if($removeShippment){
            $orders = $this->getOrdersByBuffor($this->id_en);
            foreach ($orders as $order) {
                $order->clearShipment();
            }
        }

        $result = parent::delete();
        return $result;
    }

    public function isSendByOffice(){
        $packages = PPOrder::findByBuffor($this->id_en);

        if(!empty($packages)){
            $first_package = (is_object($packages)?$packages:$packages[0]);
            $send_buffors = ENadawca::Envelope()->get(date('Y-m-d',strtotime('-1 week')),date('Y-m-d'));

            if(isset($send_buffors['envelopes']['idEnvelope'])){
                $send_buffors['envelopes'] = array($send_buffors['envelopes']);
            }
            if(isset($send_buffors['envelopes'])) {
                foreach($send_buffors['envelopes'] as $envelop){
                    $shipments = ENadawca::Envelope()->getContentShort($envelop['idEnvelope']);
                    if(isset($shipments['przesylka']['guid'])){
                        $shipments['przesylka'] = array($shipments['przesylka']);
                    }
                    if(array_search($first_package->id_shipment, array_column($shipments['przesylka'], 'guid')) !== false){
                        $this->id_envelope = $envelop['idEnvelope'];
                        $this->envelope_status = 'wyslany';
                        $this->update();
                        return true;
                    }
                }
            }

        }

        return false;
    }
}
