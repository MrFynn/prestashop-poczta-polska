<?php

/**
 * Klasa odpowiadająca za zarządzanie danymi w buforze
 */
class EnvelopeBuffor extends Resource {

    /**
     * Metoda  pozwala  pobrać  informacje  o  przesyłkach  znajdujących  się  w  buforze
     * @param type $idBufor
     * @return array
     */
    public function get($idBufor = '') {
        $params = array();
        if (!empty($idBufor)) {
            $params = array('idBufor' => $idBufor);
        }
        $result = $this->_callWebservice('getEnvelopeBufor', $params);
        return $result;
    }

    /**
     * Metoda pozwalająca pobrać listę buforów zdefiniowanych poprzez web api
     * @return array
     */
    public function getList() {
        $result = $this->_callWebservice('getEnvelopeBuforList');
        if (!$this->hasErrors()) {
            if (isset($result['bufor']['idBufor'])) {
                $result = array($result['bufor']);
            } else {
                $result = array_shift($result);
            }
        }
        return $result;
    }

    /**
     * Metoda umożliwiająca zmianę danych bufora, w tym daty nadania czy urzędu nadania
     * @param type $idBufor
     * @param type $dataNadania
     * @param type $urzadNadania
     * @param type $active
     * @param type $opis
     * @return array
     */
    public function update($idBufor, $dataNadania, $urzadNadania, $opis) {
        $params = array(
            'idBufor' => $idBufor,
            'dataNadania' => $dataNadania,
            'urzadNadania' => $urzadNadania,
            'opis' => $opis,
        );
        $result = $this->_callWebservice('updateEnvelopeBufor', array('bufor' => $params));
        return $result;
    }

    /**
     * Metoda umożliwiająca stworzenie nowego bufora. Możliwe jest stworzenie w jednym wywołaniu kilku buforów.
     * @param type $dataNadania
     * @param type $urzadNadania
     * @param type $active
     * @param type $opis
     * @return type
     */
    public function create($dataNadania, $urzadNadania, $opis) {
        $params = array(
            'dataNadania' => $dataNadania,
            'urzadNadania' => $urzadNadania,
            'active' => true,
            'opis' => $opis,
        );
        $result = $this->_callWebservice('createEnvelopeBufor', array('bufor' => $params));
        return $result;
    }

    public function clear($idBuffor) {
        $result = $this->_callWebservice('clearEnvelope', array('idBufor' => $idBuffor));
        return $result;
    }

}
