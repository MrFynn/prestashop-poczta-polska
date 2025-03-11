<?php

/**
 * Klasa odpowiadajaca za zarzadzanie profilami nadawcy
 */
class Profil extends Resource {

    /**
     * Metoda umożliwia pobranie listy dostępnych profili nadawcy 
     * @return array
     */
    public function getList() {
        $result = $this->_callWebservice ('getProfilList');
        return $result;
    }

    /**
     * metoda zwracajaca list profili dla zwrotu dokumentow
     * @return array
     */
    public function getReturnDocumentsProfileList() {
        $result = $this->_callWebservice ('getReturnDocumentsProfileList');
        return $result;
    }

    /**
     * Metoda umożliwia pobranie profilu nadawcy 
     * @return array
     */
    public function get($idProfil = '') {
        $result = $this->_callWebservice ('getProfilList');
        if (!empty($result) && isset($result['profil'])) {
            return array_shift($result['profil']);
        }
        if(!empty($idProfil)&&!empty($result) && isset($result['profil'])){
             foreach($result['profil'] as $v){
                 if(isset($v['idProfil']) && $v['idProfil'] === $idProfil){
                     return $v;
                 }
             }
        }
        return $result;
    }

    /**
     * Metoda umożliwia utworzenie nowego profilu nadawcy 
     * @param type $nazwa
     * @param type $ulica
     * @param type $numerDomu
     * @param type $numerLokalu
     * @param type $miejscowosc
     * @param type $kodPocztowy
     * @param type $kraj
     * @param type $nazwSkrocona
     * @return array
     */
    public function create($nazwa, $ulica, $numerDomu, $numerLokalu, $miejscowosc, $kodPocztowy, $kraj, $nazwSkrocona) {
        $params = array(
            'nazwa' => $nazwa,
            'ulica' => $ulica,
            'numerDomu' => $numerDomu,
            'numerLokalu' => $numerLokalu,
            'miejscowosc' => $miejscowosc,
            'kodPocztowy' => $kodPocztowy,
            'kraj' => $kraj,
            'nazwaSkrocona' => $nazwSkrocona
        );
        $result = $this->_callWebservice ('createProfil', array('profil' => $params));
        return $result;
    }

    /**
     * Metoda umożliwia zmianę profilu nadawcy
     * @param type $idProfil
     * @param type $nazwa
     * @param type $ulica
     * @param type $numerDomu
     * @param type $numerLokalu
     * @param type $miejscowosc
     * @param type $kodPocztowy
     * @param type $kraj
     * @param type $nazwSkrocona
     * @return array
     */
    public function update($idProfil, $nazwa, $ulica, $numerDomu, $numerLokalu, $miejscowosc, $kodPocztowy, $kraj, $nazwSkrocona) {
        $params = array(
            'nazwa' => $nazwa,
            'ulica' => $ulica,
            'numerDomu' => $numerDomu,
            'numerLokalu' => $numerLokalu,
            'miejscowosc' => $miejscowosc,
            'kodPocztowy' => $kodPocztowy,
            'kraj' => $kraj,
            'idProfil' => $idProfil,
            'nazwaSkrocona' => $nazwSkrocona
        );
        $result = $this->_callWebservice ('updatePrrofil', array('profil' => $params));
        return $result;
    }

}
