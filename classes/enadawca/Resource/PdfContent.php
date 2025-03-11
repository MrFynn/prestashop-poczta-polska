<?php

/**
 * Klasa odpowiadająca za generowanie wydruków w formacie PDF
 */
class PdfContent extends Resource {

    var $_options = array('cache_wsdl' => WSDL_CACHE_NONE);

    /**
     * Metoda umożliwia pobranie samego blankietu pobrania dla przesyłek z pobraniem dla zbiorów jeszcze nie wysłanych
     * @param type $guid
     * @param type $idBufor
     */
    public function getBlankietPobraniaByGuids($guid, $idBufor = '') {
        $params = array('guid' => $guid);
        if (!empty($idBufor)) {
            $params['idBufor'] = $idBufor;
        }
        $result = $this->_callWebservice('getBlankietPobraniaByGuids', $params);
        if (!$this->hasErrors()) {
            if (isset($result['content']['pdfContent'])) {
                return $result['content']['pdfContent'];
            } else {
                if (is_array($result['content'])) {
                    $content = '';
                    foreach ($result['content'] as $c) {
                        $content .= $c['pdfContent'];
                    }
                    return $content;
                }
            }
        }
        return false;
    }

    /**
     * Metoda po zwalająca pobrać wydruk Książki Nadawczej. Wydruk prezentowany jest w formacie PDF
     * @param type $idEnvelope - zwracane przez send z obiektu Envelope
     * @param boolean $includeNierejestrowane
     */
    public function getOutboxBook($idEnvelope, $includeNierejestrowane = true) {
        $result = $this->_callWebservice('getOutboxBook', array('idEnvelope' => $idEnvelope, 'includeNierejestrowane' => $includeNierejestrowane));
        if (isset($result['pdfContent'])) {
            return $result['pdfContent'];
        }
        return false;
    }

    /**
     * Metoda pozwalająca pobrać wydruk zestawiania dla Firmowej Poczty. Wydruk jest w  formacie  PDF
     * @param type $idEnvelope - zwracane przez send z obiektu Envelope
     */
    public function getFirmowaPocztaBook($idEnvelope) {
        $result = $this->_callWebservice('getFirmowaPocztaBook', array('idEnvelope' => $idEnvelope));
        if (isset($result['pdfContent'])) {
            return $result['pdfContent'];
        }
        return false;
    }

    /**
     * Metoda pozwalająca pobrać nalepki adresowe. Wydruk jest w formacie PDF.
     * @param type $idEnvelope - zwracane przez send z obiektu Envelope
     */
    public function getAddresLabel($idEnvelope,$guid='') {
        $result = $this->_callWebservice('getAddressLabel', array('idEnvelope' => $idEnvelope));
        if (isset($result['content']['pdfContent'])) {
            return $result['content']['pdfContent'];
        }
        if(!empty($guid)&&isset($result['content'])&&is_array($result['content'])){
           foreach($result['content'] as $content){
               if($content['guid'] == $guid){
                   return $content['pdfContent'];
               }
           }
        }
        return false;
    }

    /**
     * Metoda umożliwia pobranie kompletu nalepek adresowych w jednym pliku w formacie pdf. 
     * Pobranie nalepek jest możliwe po wywołaniu metody send z obiektu Envelope
     * @param type $idEnvelope - zwracane przez send z obiektu Envelope
     */
    public function getAddresLabelCompact($idEnvelope) {
        $result = $this->_callWebservice('getAddresLabelCompact', array('idEnvelope' => $idEnvelope));
        if (isset($result['pdfContent'])) {
            return $result['pdfContent'];
        }
        return false;
    }

    /**
     * Metoda umożliwia pobranie nalepek adresowych w jednym pliku w formacie pdf dla przekazanego zakresu guidów przesyłek
     * @param type $guid
     * @param type $idBufor
     */
    public function getAddresLabelByGuid($guid, $idBufor = '') {
        $params = array('guid' => $guid);
        if (!empty($idBufor)) {
            $params['idBufor'] = $idBufor;
        }
        $result = $this->_callWebservice('getAddresLabelByGuid', $params);
        if (isset($result['content']['pdfContent'])) {
            return $result['content']['pdfContent'];
        }
        return false;
    }

    /**
     * Metoda umożliwia pobranie nalepek adresowych w jednym pliku w formacie pdf dla przekazanego zakresu guidów przesyłek
     * @param type $guid
     * @param type $idBufor
     */
    public function getAddresLabelByGuidCompact($guid, $idBufor = '') {
        $params = array('guid' => $guid);
        if (!empty($idBufor)) {
            $params['idBufor'] = $idBufor;
        }
        $result = $this->_callWebservice('getAddresLabelByGuidCompact', $params);
        if (isset($result['pdfContent'])) {
            return $result['pdfContent'];
        }
        return false;
    }

    /**
     * Metoda umożliwia pobranie nalepek adresowych w jednym pliku w formacie pdf dla przekazanego zakresu guidów przesyłek
     * @param type $guid
     */
    public function getPrintForParcel($guid) {
        $params = array('guid' => $guid);
        //$type = new PrintType();
        $params['type'] = array('kind'=>'ADDRESS_LABEL','method'=>'ALL_PARCELS_IN_ONE_FILE');

        $result = $this->_callWebservice('getPrintForParcel', $params);

        if (isset($result['printResult']['print'])) {
            return $result['printResult']['print'];
        }
        return false;
    }

}
