<?php

/**
 * Klasa odpowiadajaca za zarzadzanie hasłem
 */
class Password extends Resource {

    /**
     * Metoda pozwalająca na zmianę hasła dostępu do systemu EN.
     * @param type $newPassword
     * @return array
     */
    public function change($newPassword) {
        $result = $this->_callWebservice ('changePassword', array('newPassword' => $newPassword));
        return $result;
    }

    /**
     * Metoda pozwalająca pobrać czas ważności hasła
     * @return array
     */
    public function getExpiredDate() {
        $result = $this->_callWebservice ('getPasswordExpiredDate');
        return $result;
    }

}
