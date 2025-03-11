<?php

/**
 * Klasa odpowiadajaca za pobieranie urzędów nadania
 */
class UrzedyNadania extends Resource {

    /**
     * Metoda pozwala pobrać wszystkie urzędy nadania, dla których nadający ma podpisaną umowę z PP
     * @param type $param
     * @return array
     */
    public function get($param = '') {
        $result = $this->_callWebservice('getUrzedyNadania');
        if (isset($result['urzedyNadania']['urzadNadania'])) {
            $result['urzedyNadania'] = array($result['urzedyNadania']);
        }
        if (!empty($param) && isset($result[$param])) {
            foreach ($result as $v) {
                if (isset($v['urzadNadania']) && $v['urzadNadania'] === $param) {
                    return $v;
                }
            }
        }
        return $result['urzedyNadania'];
    }

}
