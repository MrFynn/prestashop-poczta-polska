<?php

/**
 * Klasa odpowiadajaca za zarzadzanie jednostkami ograzniacyjnymi
 */
class JednostkaOrganizacyjna extends Resource {

    /**
     * Metoda pozwala pobrać informacje o jednostce organizacyjnej
     * @return array
     */
    public function get() {
        $result = $this->_callWebservice ('getJednostkaOrganizacyjna');

        return $result;
    }

}
