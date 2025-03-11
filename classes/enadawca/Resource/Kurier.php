<?php

/**
 * Klasa odpowiadająca za zamawianie kuriera
 */
class Kurier extends Resource {

    /**
     * Metoda umożliwiająca zamówienie kuriera po odbiór przesyłek od klienta
     * @param type $oczekiwanaDataOdbioru
     * @param type $oczekiwanaGodzinaOdbioru
     * @param type $szacowanaIloscPrzeslek
     * @param type $szacowanaLacznaMasaPrzesylek
     * @param type $PotwierdzenieZamowieniaEmail
     * @param type $miejsceOdbioru
     * @param type $nadawca
     * @return type
     */
    public function zamow($oczekiwanaDataOdbioru, $oczekiwanaGodzinaOdbioru, $szacowanaIloscPrzeslek, $szacowanaLacznaMasaPrzesylek, $PotwierdzenieZamowieniaEmail, $miejsceOdbioru = array(), $nadawca = array()) {
        $params = array(
            'oczekiwanaDataOdbioru' => $oczekiwanaDataOdbioru,
            'oczekiwanaGodzinaOdbioru' => $oczekiwanaGodzinaOdbioru,
            'szacowanaIloscPrzeslek' => $szacowanaIloscPrzeslek,
            'szacowanaLacznaMasaPrzesylek' => $szacowanaLacznaMasaPrzesylek,
            'PotwierdzenieZamowieniaEmail' => $PotwierdzenieZamowieniaEmail
        );
        if (!empty($miejsceOdbioru)) {
            $params['miejsceOdbioru'] = $miejsceOdbioru;
        }
        if (!empty($nadawca)) {
            $params['nadawca'] = $nadawca;
        }
        $result = $this->_callWebservice('zamowKuriera', $params);
        return $result;
    }

}
