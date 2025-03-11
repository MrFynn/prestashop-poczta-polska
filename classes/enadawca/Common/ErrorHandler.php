<?php

require_once __DIR__ .'/../Log/ENadawcaErrorLogger.php';

/**
 * Klasa odpowiedzialna za przechwytywanie,obsługę błędów i wyjątków
 */
class ErrorHandler {

    /**
     * Obiekt wyjątku
     * @var type 
     */
    public $exception;

    /**
     * Obiekt do logowania błedów
     * @var type 
     */
    private $_logger = null;

    /**
     * Konstruktor klasy, w którym tworzony jest obiekt do logowania błedów
     */
    public function __construct() {
        $this->_logger = new ENadawcaErrorLogger();
    }

    /**
     * Metodą odpowiedzialna za rejsterowanie funkcji wyłapujących błedy
     */
    public function register() {
       // ini_set('display_errors', false);
        set_exception_handler(array($this, 'handleException'));
        set_error_handler(array($this, 'handleError'));
        register_shutdown_function(array($this, 'handleFatalError'));
    }

    /**
     * Metoda odpowiedziala na wyrejestrowanie fukcji wyłapujacych błedy
     */
    public function unregister() {
        restore_error_handler();
        restore_exception_handler();
    }
    
    /**
     * Metoda odpowiedzialna za logowanie błedów PHP
     * @param type $code
     * @param type $message
     * @param type $file
     * @param type $line
     * @return boolean
     * @throws Exception
     */
    public function handleError($code, $message, $file, $line) {
        if ($code) {
            throw new Exception($message, $code);
        }
        return false;
    }
    
    /**
     * Metoda odpowiedzialna za logowanie wyjątków
     * @param type $exception
     */
    public function handleException($exception) {
        $this->exception = $exception;
        $this->unregister();
        $this->_logger->logException($exception);
    }

    /**
     * Metoda odpowiedzialna za logowanie błedów krytycznych PHP
     * @param type $exception
     */
    public function handleFatalError() {
        $error = error_get_last();
        if(isset($error['message'])){
            $exception = new Exception($error['message']);
            $this->exception = $exception;
            $this->_logger->logException($exception);
        }
    }
}
