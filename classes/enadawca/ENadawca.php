<?php

require_once 'Exception/MissingResourceException.php';
require_once 'Log/ENadawcaLogger.php';
require_once 'Common/ErrorHandler.php';
/**
 * 
 */
class ENadawca {

    /**
     *
     * @var type 
     */
    private static $_instance = null;

    /**
     *
     * @var type 
     */
    private $_resources = array(
        'UrzedyNadania', 'Envelope', 'EnvelopeBuffor', 'Profil', 'Password', 'Kurier', 'Document', 'Shipment', 'PdfContent','Karta','JednostkaOrganizacyjna','Account'
    );

    /**
     * 
     */
    private function __construct() {
        $this->_registerAutoLoad();
        //$this->_registerErrorHandler();
    }

    /**
     * 
     * @return type
     */
    public static function getInstance() {
        if (is_null(self::$_instance)) {
            self::$_instance = new ENadawca();
        }
        return self::$_instance;
    }

    /**
     * 
     * @param type $className
     * @return \className
     */
    public function get($className) {
        $instance = self::getInstance();
        $instance->_checkResource($className);
        if (class_exists($className)) {
            $object = new $className();
            $object->init();
            return $object;
        }
        return null;
    }

    /**
     * 
     * @param type $className
     * @throws MissingResourceException
     */
    protected function _checkResource($className) {
        if (!in_array($className, $this->_resources)) {
            throw new MissingResourceException('Resource `' . $className . '` nor exists. Available resources:' . implode(',', $this->_resources));
        }
    }

    /**
     * 
     * @param type $name
     * @param type $arguments
     * @return type
     */
    public static function __callStatic($name, $arguments) {
        return self::getInstance()->get($name);
    }

    /**
     * 
     * @param type $className
     * @return type
     */
    protected function _autoload($className) {
        $path = $this->_getPath($className);
        if (!file_exists($path)) {
            return;
        }
        require_once $path;
    }

    /**
     * 
     * @param type $className
     * @return string
     */
    protected function _getPath($className) {
        $path = dirname(__FILE__) . '/Resource/' . str_replace('_', '/', $className) . '.php';
        return $path;
    }

    /**
     * 
     */
    protected function _registerAutoload() {
        spl_autoload_register(array($this, '_autoload'));
    }

    /**
     * 
     */
    protected function _registerErrorHandler() {
        $this->_errorHandler = new ErrorHandler();
        $this->_errorHandler->register();
    }

}
