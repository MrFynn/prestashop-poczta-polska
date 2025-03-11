<?php

class Account extends Resource{
    /**
     * metoda pobierajaca dane o profilach uzytkownika API
     * @return array
     */
    public function get(){
        $result = $this->_callWebservice ('getAccountList');
        return $result;
    }

    /**
     * metoda odpowiedzialna za pobranie z  API informacji o profilu
     * @return array
     */
    public function getMyAccount(){
        $result = $this->_callWebService('getAccountList');

        if(isset($result['account'])){
            if(isset($result['account']['domyslnyProfil'])){
                return $result['account'];
            }
            foreach($result['account'] as $key=>$account){
                if($account['userName'] == Configuration::get(PPSetting::PP_USER) ){
                    return $account;
                }
            }
        }


        return $result;
    }

    /**
     * metoda sprawdzajaca czy dany uzytkownika API prawidlowo jest zalogowany
     * @return bool
     */
    public function hello(){
        $params['in'] = 'hello';
        $result = $this->_callWebService('hello',$params);
        return $result;
    }
}