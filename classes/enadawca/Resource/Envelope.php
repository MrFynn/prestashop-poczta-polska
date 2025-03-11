<?php

/**
 * Klasa odpowidająca zarządzanie wysyłką przesyłek
 */
class Envelope extends Resource {

    /**
     * Metoda czyszcząca pakiet z przesyłek. Usuwa bufor wraz ze wszystkimi informacjami o przesyłkach, które zostały dodane
     * @return array
     */
    public function clear($idBuffor = '') {
        $params = array();
        if (!empty($idBuffor)) {
            $params['idBufor'] = $idBuffor;
        }
        $result = $this->_callWebservice('clearEnvelope', $params);
        return $result;
    }

    /**
     * Metoda pozwala na wybiórcze usunięcie przesyłek z bufora. Parametrem wejściowym jest tablica guidów przesyłek do usunięcia
     * @param array $guid
     * @return array
     */
    public function clearByGuids($guid,$idBuffor = '') {
        $params = array('guid' => $guid);
        if (!empty($idBuffor)) {
            $params['idBufor'] = $idBuffor;
        }
        $result = $this->_callWebservice('clearEnvelopeByGuids', $params);
        return $result;
    }

    /**
     * Metoda pozwalająca wysłać wszystkie przesyłki
     * @param type $urzadNadania
     * @param type $idBuffor
     * @return type
     */
    public function send($urzadNadania, $idBuffor = '') {
        $params = array(
            'urzadNadania' => $urzadNadania,
        );
        if (!empty($idBuffor)) {
            $params['idBufor'] = $idBuffor;
        }
        $result = $this->_callWebservice('sendEnvelope', $params);
        return $result;
    }

    /**
     * Metoda pozwala pobrać status przekazanego pakietu przesyłek
     * @param integer $idEnvelope
     * @return array
     */
    public function getStatus($idEnvelope) {
        $result = $this->_callWebservice('getEnvelopeStatus', array('idEnvelope' => $idEnvelope));
        return $result;
    }

    /**
     * Metoda pozwalająca pobrać informacje zwrotne o nadanych przesyłkach w wersji skróconej.
     * @param type $idEnvelope
     * @return type
     */
    public function getContentShort($idEnvelope) {
        $result = $this->_callWebservice('getEnvelopeContentShort', array('idEnvelope' => $idEnvelope));
        return $result;
    }

    /**
     * Metoda pozwalająca pobrać informacje zwrotne o nadanych przesyłkach w wersji pełnej.
     * @param type $idEnvelope
     * @return type
     */
    public function getContentFull($idEnvelope) {
        $result = $this->_callWebservice('getEnvelopeContentFull', array('idEnvelope' => $idEnvelope));
        return $result;
    }

    /**
     * Metoda pozwalająca pobrać listę pakietów, które są dostępne do pobrania wraz ze statusami
     * @param type $startDate
     * @param type $endDate
     * @return type
     */
    public function get($startDate, $endDate) {
        $result = $this->_callWebservice('getEnvelopeList', array('startDate' => $startDate, 'endDate' => $endDate));
        return $result;
    }

    public function getStatuses() {
        $arr = array(
            'wyslany' => 'Wysłany',
            'niewyslany'=>'Niewysłany'
        );
        return $arr;
    }

}
