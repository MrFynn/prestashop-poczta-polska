<?php

/**
 * Klasa odpowiadajaca za zarzadzanie kartami umowy
 */
class Karta extends Resource {

    /**
     * Metoda pozwala pobrać wszystkie karty umowy
     * @return array
     */
    public function getList() {
        $result = $this->_callWebservice ('getKarty');

        return $result;
    }

    /**
     * metoda umozliwa pobranie informacji na temat wybranej karty
     * @param string $idKarty
     * @return array
     */
    public function get($idKarty = ''){
        $result = $this->_callWebservice ('getKarty');
        if(isset($result['karta']['idKarta'])){
            $result['karta'] = array($result['karta']);
        }
        foreach($result['karta'] as $karta){
            if($karta['idKarta'] == $idKarty){
                return $karta;
            }
        }
        return $result['karta'];
    }

    /**
     * metoda pozwalajaca umozliwienie domyslane karty dla uztykownika api
     * @param $idKarty
     * @return bool
     */
    public function setDefault($idKarty){
        $result = false;
        if(!empty($idKarty)){
            $result = $this->_callWebservice('setAktywnaKarta',array('idKarta'=>$idKarty));
        }
        return $result;
    }

}
