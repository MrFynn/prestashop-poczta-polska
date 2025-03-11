<?php

/**
 * 
 */
class ENadawcaLogger {

    /**
     * Nanzwa pliku
     * @var type 
     */
    protected $_logfile = 'debug';

    /**
     * Rozszerzenie pliku
     * @var type 
     */
    protected $_ext = '.log';

    /**
     * Maksymalna wielkość pliku
     * @var type 
     */
    protected $_logSize = '10MB';

    /**
     * Uchwyt do pliku
     * @var type 
     */
    protected $_fileHandle = false;

    /**
     * Konstruktor klasy
     * @param type $logfile
     */
    public function __construct() {
        $this->init();
    }

    /**
     * Metoda odpowiedzilna zatworzenie,usuwanie pliku log
     */
    public function init() {
        $this->full_log_file = __DIR__ . '/../logs/' . $this->_logfile . $this->_ext;
        if (!file_exists($this->full_log_file)) {
            @touch($this->full_log_file);
        }
        $this->_removeLogFile();
    }

    /**
     * Metoda odpowiedzialna za zapis komunikatu do pliku
     * @param type $message
     * @return type
     */
    public function log($message, $extras = array()) {
        if (!file_exists($this->full_log_file)) {
            return;
        }
        if (!$this->_fileHandle) {
            $this->_fileHandle = fopen($this->full_log_file, 'a');
        }
        if (is_array($message) && count($message) == 1) {
            $message = array_shift($message);
        }
        if (is_array($message)) {
            $message = print_r($message, true);
        }
        if (!empty($extras)) {
            $message .= ' ' . print_r($extras, true);
        }
        fwrite($this->_fileHandle, strftime('%c') . ' [' . getmypid() . '] ' . $message . "\n");
    }

    /**
     * Metoda odpowiedzialna za logowanie wyjątków
     * @param type $exception
     */
    public function logException($exception) {
        $this->log($exception);
    }

    /**
     * Metoda odpowiedzialna za usuwanie pliku jesli przekroczony dopuszczalny rozmiar pliku
     * @return type
     */
    protected function _removeLogFile() {
        if (!file_exists($this->full_log_file) || empty($this->_logSize)) {
            return false;
        }
        $megs = substr($this->_logSize, 0, strlen($this->_logSize) - 2);
        $rollAt = (int) $megs * 1024 * 1024;
        if (filesize($this->full_log_file) >= $rollAt) {
            if (file_exists($this->full_log_file)) {
                unlink($this->full_log_file);
            }
        }
        return true;
    }

    /**
     * metoda wywolywana podczas usuwania obiektu
     */
    public function __destruct() {
        if ($this->_fileHandle) {
            fclose($this->_fileHandle);
        }
    }

}
