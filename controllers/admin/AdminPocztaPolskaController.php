<?php

class AdminPocztaPolskaController extends AdminController {

    public function __construct() {
        parent::__construct();
        $this->module = Module::getInstanceByName('pocztapolskaen');
        $this->bootstrap = true;
        $this->context = Context::getContext();
        $this->_conf[33] = $this->l('Operacja Wyślij do Urzędu została wykonana pomyślnie');
        $this->_conf[34] = $this->l('Operacja Przeniesienia przesyłek została wykonana pomyślnie');
        $this->_conf[35] = sprintf($this->l('Zostało wysłane zamówienie po Kuriera data: %s godzina: %s. Kurier skontaktuje się z Państwem w celu ustalenia sczegółow przybycia.'), date('d-m-Y'), date('H:i:s'));
        $this->_conf[36] = $this->l('Przesyłki zostały usunięte');
        $this->_conf[41] = $this->l('Zbiór został usunięty');
        $this->_conf[43] = $this->l('Zbiór został utworzony');
        $this->_conf[44] = $this->l('Zbiór został zaktualizowany');
    }

    /**
     * Metoda odpowiedzialna za inicjalizacje procesów
     */
    public function initProcess() {
        parent::initProcess();
        $action = Tools::getValue('action', '');
        if (!empty($action)) {
            $this->action = $action;
        }
    }
}
