<?php

class PPOrder extends ObjectModel {

    public $id_order;
    public $id_shipment;
    public $shipment_number;
    public $order_date;
    public $send_date;
    public $post_date;
    public $shipment_type;
    public $id_buffor;
    public $date_add;
    public $date_upd;
    public $pni;
    public $id_cart;
    public $id_carrier;
    public $point;
    public $cod;

    public $attributes;
    public static $definition = array(
        'table' => 'pocztapolskaen_order',
        'primary' => 'id_pp_order',
        'fields' => array(
            'id_order' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId', 'required' => true),
            'id_cart' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'id_carrier' => array('type' => self::TYPE_INT, 'validate' => 'isUnsignedId'),
            'id_shipment' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => true),
            'shipment_number' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'allow_null' => true),
            'shipment_type' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'allow_null' => true),
            'send_date' => array('type' => self::TYPE_DATE, 'allow_null' => true),
            'post_date' => array('type' => self::TYPE_DATE, 'allow_null' => true),
            'id_buffor' => array('type' => self::TYPE_INT, 'validate' => 'isInt'),
            'date_add' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'date_upd' => array('type' => self::TYPE_DATE, 'validate' => 'isDate'),
            'point' => array('type' => self::TYPE_STRING, 'validate' => 'isString', 'allow_null' => true),
            'pni' => array('type' => self::TYPE_INT, 'validate' => 'isInt', 'allow_null' => true),
            'cod' => array('type' => self::TYPE_BOOL, 'validate' => 'isBool'),
            'attributes' => array('type' => self::TYPE_STRING, 'allow_null' => true)
        ),
        'associations' => array(
            'buffor' => array('type' => self::HAS_ONE, 'field' => 'id_buffor', 'foreign_field' => 'id_en', 'object' => 'PPOrderSet'),
        ),
    );

    /**
     * Metoda pobiera wszystkie przesyłki pogrupowane wzgledem id zbioru
     */
    public static function getCollection() {
        $arr = array();
        $collection = new PrestaShopCollection('PPOrder');
        foreach ($collection as $c) {
            $arr[$c->id_en] = $c;
        }
        return $arr;
    }

    /**
     * Metoda pobiera przesylke po identyfikatorze zamowienia
     */
    public static function findByOrder($idOrder) {
        $orders = new PrestaShopCollection('PPOrder');
        $orders->where('id_order', '=', $idOrder);
        if ($orders->count() > 0) {
            return $orders[0];
        }
        $object = new self;
        $object->id_order = $idOrder;
        return $object;
    }

    public static function findByBuffor($idBuffor) {
        $orders = new PrestaShopCollection('PPOrder');
        $orders->where('id_buffor', '=', $idBuffor);
        if ($orders->count() > 0) {
            return $orders[0];
        }
        return array();
    }

    /**
     * Metoda pobiera przesylki o podanych w parametrze identyfikatorach
     */
    public static function getOrders($ordersIds, $isSent = true, $isShipment = false) {
        $orders = new PrestaShopCollection('PPOrder');
        //$orders->join('buffor');
        $orders->where('id_order', 'in', $ordersIds);
        /*if ($isSent) {
            $orders->where('buffor.id_envelope', '>', '0');
        }*/
        if ($isShipment) {
            $orders->where('id_shipment', '>', '0');
        }
        return $orders;
    }

    /**
     * Metoda ustawia status zamowienia w zależnosci od zdefiniowanych ustawien
     */
    public function setOrderStatus($name) {
        $order = new Order($this->id_order);
        $order_status = PPSetting::getStatusValue($name);
        if (!empty($order_status)) {
            $order->setCurrentState($order_status);
            $order->save();
        }
    }

    public function setOrderShipment(){
        $order = new Order($this->id_order);
        $orderCarrier = new OrderCarrier($order->getIdOrderCarrier());
        $orderCarrier->tracking_number = $this->shipment_number;
        $orderCarrier->save();
    }

    /**
     * Metoda zwraca adres dostawy zamowienia
     */
    public function getOrderAddress() {
        $order = new Order($this->id_order);
        $address = new Address($order->id_address_delivery);
        return $address;
    }

    public function getOrderCustomer() {
        $order = new Order($this->id_order);
        return $order->getCustomer();
    }

    /**
     * Metoda zwraca przesylki pogrupowane wzgledem id zbioru
     */
    public static function getGroupedByBuffer($ordersIds = array()) {
        $orders = new PrestaShopCollection('PPOrder');
        $orders->where('id_order', 'in', $ordersIds);
        $arr = array();
        if (!empty($orders)) {
            foreach ($orders as $order) {
                $arr[$order->id_buffor]['orders'][] = $order;
                $arr[$order->id_buffor]['guids'][] = $order->id_shipment;
            }
        }
        return $arr;
    }

    /**
     * Metoda zwraca przesylke wzgledem id koszyka
     */
    public static function findByCart($idCart, $return_object = true) {

        $row = Db::getInstance()->getRow('
			SELECT `id_pp_order` as id
			FROM `' . _DB_PREFIX_ . 'pocztapolskaen_order` pp
			WHERE pp.`id_cart` = ' . (int) $idCart, false
        );

        if (isset($row['id'])) {
            return new self($row['id']);
        } else {
            if ($return_object) {
                $ppOrder = new PPOrder();
                $ppOrder->id_cart = $idCart;
                $ppOrder->id_order = 0;
                $ppOrder->id_shipment = 0;
                $ppOrder->shipment_number = '';
                $ppOrder->save();
                return $ppOrder;
            } else {
                return null;
            }
        }
    }

    /**
     * Metoda zwraca zbior powiazany z przesylka
     */
    public function getOrderSet() {
        $ppOrders = new PrestaShopCollection('PPOrderSet');
        $ppOrders->where('id_en', '=', $this->id_buffor);
        return $ppOrders[0];
    }

    /**
     * Metoda resetuje pola zwiazane z przesylka
     */
    public function clearShipment() {
        $this->clearOrderShipment();
        if(!empty($this->pni)){
            $this->id_shipment = 0;
            $this->id_buffor = 0;
            $this->shipment_type = '';
            $this->send_date = null;
            $this->shipment_number = '';
            $this->save();
        } else {
            $this->delete();
        }
    }

    public function clearOrderShipment(){
        $order = new Order($this->id_order);
        $orderCarrier = new OrderCarrier($order->getIdOrderCarrier());
        if($orderCarrier->tracking_number == $this->shipment_number){
            $orderCarrier->tracking_number = '';
            $orderCarrier->save();
        }
    }
}
