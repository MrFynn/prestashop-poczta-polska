<?php

require_once __DIR__ . '/../Exception/ClientException.php';

/**
 * Klasa odpowiedzialna za łacznie się z web api PP
 */
class Client extends SoapClient {

    /**
     * Mapa klas typów przesyłek
     * @var type 
     */
    public static $classmap = array(
        'przesylkaType' => 'przesylkaType',
        'paczkaPocztowaType' => 'paczkaPocztowaType',
        'przesylkaBiznesowaType' => 'przesylkaBiznesowaType',
        'uslugaKurierskaType' => 'uslugaKurierskaType',
        'globalExpresType' => 'globalExpresType',
        'przesylkaPoleconaZagranicznaType' => 'przesylkaPoleconaZagranicznaType',
        'przesylkaFirmowaPoleconaType' => 'przesylkaFirmowaPoleconaType',
        'paczkaZagranicznaType' => 'paczkaZagranicznaType',
        'EMSType' => 'EMSType',
        'paczkaPocztowaPLUSType' => 'paczkaPocztowaPLUSType',
        'przesylkaPobraniowaType' => 'przesylkaPobraniowaType',
        'przesylkaNaWarunkachSzczegolnychType' => 'przesylkaNaWarunkachSzczegolnychType',
        'przesylkaPoleconaKrajowaType' => 'przesylkaPoleconaKrajowaType',
        'przesylkaHandlowaType' => 'przesylkaHandlowaType',
        'przesylkaListowaZadeklarowanaWartoscType' => 'przesylkaListowaZadeklarowanaWartoscType',
        'przesylkaFullType' => 'przesylkaFullType',
        'przesylkaRejestrowanaType' => 'przesylkaRejestrowanaType',
        'subUslugaKurierskaType' => 'subUslugaKurierskaType',
        'subPrzesylkaBiznesowaType' =>'subPrzesylkaBiznesowaType',

        'kartaType' => 'kartaType',
        'rodzajListType' => 'rodzajListType',
        'pocztex2021KurierType' => 'pocztex2021KurierType',
        'subPocztex2021KurierType' => 'subPocztex2021KurierType',
        'pocztex2021NaDzisType' => 'pocztex2021NaDzisType',
        'subPocztex2021NaDzisType' => 'subPocztex2021NaDzisType',
        'potwierdzenieEDoreczeniaType' => 'potwierdzenieEDoreczeniaType',
        'placowkaPocztowaType' => 'placowkaPocztowaType',
    );

    /**
     * Obiekt loggera 
     * @var type 
     */
    private $_logger = null;

    /**
     * Konstruktor
     * @param type $url
     * @param type $login
     * @param type $password
     * @param type $debug
     * @param type $options
     */
    public function __construct($url, $login, $password, $location, $debug = false, $options = array()) {
        $this->url = $url;
        $this->debug = $debug;
        $options['login'] = $login;
        $options['password'] = $password;
        $options['uri'] = $url;
        $options['location'] = $location;
        $options['cache_wsdl'] = WSDL_CACHE_NONE;
        $this->_logger = new ENadawcaLogger();
        foreach (self::$classmap as $key => $value) {
            if (!isset($options['classmap'][$key])) {
                $options['classmap'][$key] = $value;
            }
        }
        parent::__construct($url, $options);
    }

    private function _normalizeResponse($data) {
        if (is_object($data)) {
            $data = get_object_vars($data);
        }
        if (is_array($data)) {
            foreach ($data as &$v) {
                $v = $this->_normalizeResponse($v);
            }
            return $data;
        } else {
            return $data;
        }
    }

    private function _checkErrors($data) {
        if (isset($data['error'])&&is_array($data['error'])) {
            if (!isset($data['error']['errorNumber'])) {
                $errors = array();
                foreach ($data['error'] as $v) {
                    $errors[] = $v['errorDesc'];
                }
                return implode("\n", $errors);
            } else {
                return $data['error']['errorDesc'];
            }
        } else {
            if (is_array($data)) {
                $errors = array();
                foreach ($data as $d) {
                    if (isset($d['numerNadania'])) {
                        break;
                    }
                    $error = $this->_checkErrors($d);
                    if (!empty($error)) {
                        $errors[] = $error;
                    }
                }
                return implode("\n", $errors);
            }
        }
        return '';
    }

    /**
     * Metodą odpowiedzialna za wywołanie funkcji z api
     * @param type $function_name
     * @param type $parameters
     * @param array $options
     * @return type
     */
    public function call($function_name, $parameters = array(), array $options = null) {
        $response = false;
        try {
            $options['uri'] = $this->url;
            if($this->debug){
                $this->_logger->log("Call webserwice function " . $function_name, array('parameters' => $parameters, 'options' => $options));
            }

            $response = $this->_normalizeResponse($this->__soapCall($function_name, array($parameters), $options));
            $errors = $this->_checkErrors($response);
            if (!empty($errors)) {
                throw new ENadawcaException($errors);
            }
            if($this->debug){
                $this->_logger->log("Result webserwice function " . $function_name, $response);
            }

        } catch (SoapFault $e) {
            throw new ClientException($e);
        }
        return $response;
    }

}
