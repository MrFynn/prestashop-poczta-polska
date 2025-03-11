<?php

/**
 * Klasa odpowiadajaca za dodawanie przesyłek
 */
class Shipment extends Resource {

    /**
     * tablica przesyłek do dodania
     * @var array
     */
    private $_przesylki = array();

    /**
     * Metoda umozliwiająca dodanie paczkki Pocztowej
     * @param $adres
     * @param type $kategoria
     * @param type $gabaryt
     * @param type $masa
     * @param type $wartosc
     * @param type $zwrotDoslanie
     * @param type $posteRestante
     * @param type $iloscPotwierdzenOdbioru
     * @param type $egzemplarzBiblioteczny
     * @param type $dlaOciemnialych
     * @return boolean
     */
    public function addPaczkaPocztowa($adres, $kategoria, $gabaryt, $masa, $wartosc, $zwrotDoslanie, $posteRestante = false, $iloscPotwierdzenOdbioru = 0, $egzemplarzBiblioteczny = false, $dlaOciemnialych = false, $opis = '') {
        $paczka = new paczkaPocztowaType();
        $paczka->adres = $adres;
        $paczka->epo = false;
        $paczka->posteRestante = $posteRestante;
        $paczka->iloscPotwierdzenOdbioru = $iloscPotwierdzenOdbioru;
        $paczka->kategoria = $kategoria;
        $paczka->gabaryt = $gabaryt;
        $paczka->wartosc = $wartosc;
        $paczka->masa = $masa;
        $paczka->zwrotDoslanie = $zwrotDoslanie;
        $paczka->guid = $this->createGuid();
        $paczka->egzemplarzBiblioteczny = $egzemplarzBiblioteczny;
        $paczka->dlaOciemnialych = $dlaOciemnialych;
        $paczka->opis = $opis;
        $this->_przesylki[] = $paczka;
        return true;
    }

    /**
     * Metoda umozliwiająca dodanie przesyłki listownej
     * @param $adres
     * @param type $kategoria
     * @param type $gabaryt
     * @param type $masa
     * @param type $wartosc
     * @param type $posteRestante
     * @param type $iloscPotwierdzenOdbioru
     * @return boolean
     */
    public function addPrzesylkaListowa($adres, $kategoria, $gabaryt, $masa, $wartosc, $posteRestante = false, $iloscPotwierdzenOdbioru = 0) {
        $paczka = new przesylkaListowaZadeklarowanaWartoscType();
        $paczka->adres = $adres;
        $paczka->posteRestante = $posteRestante;
        $paczka->iloscPotwierdzenOdbioru = $iloscPotwierdzenOdbioru;
        $paczka->kategoria = $kategoria;
        $paczka->gabaryt = $gabaryt;
        $paczka->wartosc = $wartosc;
        $paczka->masa = $masa;
        $paczka->guid = $this->createGuid();
        $this->_przesylki[] = $paczka;
        return true;
    }

    /**
     * Metoda umozliwia dodanie przesylki biznesowej
     * @param $adres
     * @param $gabaryt
     * @param $opis
     * @param $pobranie
     * @param $ubezpieczenie
     * @param $urzadWydaniaEPrzesylki
     * @param $masa
     * @param $wartosc
     * @param $ostroznie
     * @param int $wielopaczkowosc_ilosc
     * @param $niestandardowa
     * @param $potwierdzenieOdbioru
     * @param $doreczenie
     * @param $zwrotDokumentow
     * @param $odbiorca
     * @return bool
     */
    public function addPrzesylkaBiznesowa($adres, $gabaryt, $opis, $pobranie, $ubezpieczenie, $urzadWydaniaEPrzesylki, $masa, $wartosc, $ostroznie, $wielopaczkowosc_ilosc = 0, $niestandardowa, $potwierdzenieOdbioru, $doreczenie, $zwrotDokumentow, $odbiorca) {
        $package = new przesylkaBiznesowaType();
        $package->pobranie = $pobranie;
        $package->adres = $adres;
        $package->gabaryt = $gabaryt;
        if($masa){
          $package->masa = $masa;
        }
        $package->wartosc = $wartosc;
        $package->sprawdzenieZawartosciPrzesylkiPrzezOdbiorce = $odbiorca;
        $package->opis = $opis;
        $package->ostroznie = $ostroznie;
        $package->guid = $this->createGuid();
        $package->urzadWydaniaEPrzesylki = $urzadWydaniaEPrzesylki;
        $package->ubezpieczenie = $ubezpieczenie;
        $package->niestandardowa = $niestandardowa;
        $package->doreczenie = $doreczenie;
        $package->potwierdzenieOdbioru = $potwierdzenieOdbioru;
        $package->zwrotDokumentow = $zwrotDokumentow;
        if($wielopaczkowosc_ilosc>0){
            unset($package->urzadWydaniaEPrzesylki);
            $this->addSubPrzesylkaBiznesowa($wielopaczkowosc_ilosc,$package);
        }
        $this->_przesylki[] = $package;
        return true;
    }

    /**
     * Metoda umozliwa dodanie podprzesyłki do przesylki biznesowej
     * @param $losc
     * @param $parentPackage
     */
    public function addSubPrzesylkaBiznesowa($losc, $parentPackage){
        $packages = array();
        for($i=0;$i<$losc-1;$i++){
            $package = new subPrzesylkaBiznesowaType();
            $package->guid = $this->createGuid();
            $package->ubezpieczenie = $parentPackage->ubezpieczenie;
            if($parentPackage->masa){
              $package->masa = $parentPackage->masa;
            }
            $package->gabaryt = $parentPackage->gabaryt;
            $package->wartosc = $parentPackage->wartosc;
            $package->ostroznie = $parentPackage->ostroznie;
            $packages[] = $package;
        }
        if(!empty($packages)){
            $parentPackage->subPrzesylka = $packages;
        }
    }


    public function addSubPocztex2021($ilosc, $parentPackage){
        $packages = array();
        for($i=0;$i<$ilosc-1;$i++){
            $package = new subPocztex2021KurierType();
            $package->guid = $this->createGuid();
            $package->ubezpieczenie = $parentPackage->ubezpieczenie;
            $package->masa = $parentPackage->masa;
            $package->gabaryt = $parentPackage->gabaryt;
            $package->wartosc = $parentPackage->wartosc;
            $package->ostroznie = $parentPackage->ostroznie;
            $package->ponadgabaryt = $parentPackage->ponadgabaryt;
            $package->format = $parentPackage->format;
            $packages[] = $package;
        }
        if(!empty($packages)){
            $parentPackage->subPrzesylka = $packages;
        }
    }

    public function addSubPocztex2021Dzis($ilosc, $parentPackage){
        $packages = array();
        for($i=0;$i<$ilosc-1;$i++){
            $package = new subPocztex2021NaDzisType();
            $package->guid = $this->createGuid();
            $package->ubezpieczenie = $parentPackage->ubezpieczenie;
            $package->masa = $parentPackage->masa;
            $package->gabaryt = $parentPackage->gabaryt;
            $package->wartosc = $parentPackage->wartosc;
            $package->ostroznie = $parentPackage->ostroznie;
            $package->ponadgabaryt = $parentPackage->ponadgabaryt;
            $package->format = $parentPackage->format;
            $packages[] = $package;
        }
        if(!empty($packages)){
            $parentPackage->subPrzesylka = $packages;
        }
    }

    public function addPocztex2021Kurier($adres, $format, $pobranie, $masa, $wartosc, $odbiorca, $opis, $ostroznie, $koperta, $sobota, $godzinaDoreczenia, $ponadgabaryt, $zawartosc, $punktOdbioru, $ubezpieczenie, $wielopaczkowosc_ilosc, $dzien, $potwierdzenieDoreczenia, $punktNadania){
        $package = new pocztex2021KurierType();
        $package->pobranie = $pobranie;
        $package->adres = $adres;
        $package->format = $format;

        $package->masa = $masa;
        $package->wartosc = $wartosc;
        $package->sprawdzenieZawartosciPrzesylkiPrzezOdbiorce = $odbiorca;
        $package->opis = $opis;
        $package->ostroznie = $ostroznie;
        $package->guid = $this->createGuid();
        $package->kopertaPocztex = $koperta;
        $package->godzinaDoreczenia = $godzinaDoreczenia;
        $package->ponadgabaryt = $ponadgabaryt;
        $package->odbiorWSobote = $sobota;
        $package->zawartosc = $zawartosc;
        $package->punktOdbioru = $punktOdbioru;
        $package->ubezpieczenie = $ubezpieczenie;
        $package->doreczenieWeWskazanymDniu = $dzien;
        $package->potwierdzenieDoreczenia = $potwierdzenieDoreczenia;
        $package->punktNadania = $punktNadania;

        if($wielopaczkowosc_ilosc>0){
            $this->addSubPocztex2021($wielopaczkowosc_ilosc,$package);
        }

        $this->_przesylki[] = $package;
        return true;
    }

    public function addPocztex2021Dzis($adres, $format, $pobranie, $masa, $wartosc, $odbiorca, $opis, $ostroznie, $sobota, $zawartosc, $ubezpieczenie, $wielopaczkowosc_ilosc, $odleglosc, $obszar, $potwierdzenieDoreczenia){
        $package = new pocztex2021NaDzisType();
        $package->pobranie = $pobranie;
        $package->adres = $adres;
        $package->masa = $masa;
        $package->wartosc = $wartosc;
        $package->sprawdzenieZawartosciPrzesylkiPrzezOdbiorce = $odbiorca;
        $package->opis = $opis;
        $package->ostroznie = $ostroznie;
        $package->guid = $this->createGuid();
        $package->odbiorWSobote = $sobota;
        $package->zawartosc = $zawartosc;
        $package->ubezpieczenie = $ubezpieczenie;

        $package->obszar = $obszar;
        if($obszar == 'MIASTO'){
            $package->odleglosc = $odleglosc;
            $package->format = $format;
        }

        $package->potwierdzenieDoreczenia = $potwierdzenieDoreczenia;

        if($wielopaczkowosc_ilosc>0 && $obszar == 'KRAJ'){
            unset($package->urzadWydaniaEPrzesylki);
            $this->addSubPocztex2021Dzis($wielopaczkowosc_ilosc,$package);
        }

        $this->_przesylki[] = $package;
        return true;
    }

    /**
     * Metoda umożliwia dodanie usługi kurierskiej
     * @param $adres
     * @param $termin
     * @param $opis
     * @param $zawartosc
     * @param $masa
     * @param $ostroznie
     * @param $niestandardowa
     * @param $sprawdzenie
     * @param $urzadWydaniaEPrzesylki
     * @param $uiszczaOplate
     * @param $doreczenie
     * @param $pobranie
     * @param $wartosc
     * @param $ubezpieczenie
     * @param $potwierdzenieOdbioru
     * @param $potwierdzenieDoreczenia
     * @param $odbiorPrzesylkiOdNadawcy
     * @param $zasadySpecjalne
     * @param int $wielopaczkowosc_ilosc
     * @param $zwrotDokumentow
     * @param $odleglosc
     * @return bool
     */
    public function addUslugaKurierska($adres, $termin, $opis, $zawartosc, $masa, $ostroznie, $niestandardowa, $sprawdzenie, $urzadWydaniaEPrzesylki, $uiszczaOplate, $doreczenie, $pobranie, $wartosc, $ubezpieczenie, $potwierdzenieOdbioru, $potwierdzenieDoreczenia, $odbiorPrzesylkiOdNadawcy, $zasadySpecjalne, $wielopaczkowosc_ilosc = 0, $zwrotDokumentow,$odleglosc) {
        $package = new uslugaKurierskaType();
        $package->pobranie = $pobranie;
        $package->adres = $adres;
        $package->termin = $termin;
        $package->masa = $masa;
        $package->wartosc = $wartosc;
        $package->opis = $opis;
        $package->ostroznie = $ostroznie;
        $package->zawartosc = $zawartosc;
        $package->uiszczaOplate = $uiszczaOplate;
        $package->guid = $this->createGuid();
        $package->urzadWydaniaEPrzesylki = $urzadWydaniaEPrzesylki;
        if($wielopaczkowosc_ilosc>0){
            unset($package->urzadWydaniaEPrzesylki);
            $this->addSubUslugaKurierska($wielopaczkowosc_ilosc,$package);
        }
        $package->ponadgabaryt = $niestandardowa;
        $package->sprawdzenieZawartosciPrzesylkiPrzezOdbiorce = $sprawdzenie;
        $package->ubezpieczenie = $ubezpieczenie;
        $package->doreczenie = $doreczenie;
        $package->ubezpieczenie = $ubezpieczenie;
        $package->wartosc = $wartosc;
        $package->pobranie = $pobranie;
        $package->potwierdzenieOdbioru = $potwierdzenieOdbioru;
        $package->potwierdzenieDoreczenia = $potwierdzenieDoreczenia;
        $package->odbiorPrzesylkiOdNadawcy = $odbiorPrzesylkiOdNadawcy;
        $package->zasadySpecjalne = $zasadySpecjalne;
        $package->zwrotDokumentow = $zwrotDokumentow;
        $package->odleglosc = $odleglosc;
        $this->_przesylki[] = $package;
        return true;
    }

    /**
     * metoda umożliwia ustawienie pod przesylki dla uslugi kurierskiej
     * @param $losc
     * @param $parentPackage
     */
    public function addSubUslugaKurierska($losc, $parentPackage){
        $packages = array();
        for($i=0;$i<$losc-1;$i++){
            $package = new subUslugaKurierskaType();
            $package->guid = $this->createGuid();
            $package->ubezpieczenie = $parentPackage->ubezpieczenie;
            $package->masa = $parentPackage->masa;
            $package->gabaryt = $parentPackage->gabaryt;
            $package->wartosc = $parentPackage->wartosc;
            $package->ostroznie = $parentPackage->ostroznie;
            $package->ponadgabaryt = $parentPackage->ponadgabaryt;
            $packages[] = $package;
        }
        if(!empty($packages)){
            $parentPackage->subPrzesylka = $packages;
        }
    }

    /**
     * metoda umożliwia ustawienie przesylki Global Express
     * @param $adres
     * @param $masa
     * @param $zawartosc
     * @param string $numer
     * @param null $potwierdzenie
     * @param string $opis
     * @return bool
     */
    public function addGlobalExpres($adres, $masa, $zawartosc, $numer = '', $potwierdzenie = null, $opis = '') {
        $package = new globalExpresType();
        $package->adres = $adres;
        $package->guid = $this->createGuid();
        $package->potwierdzenieDoreczenia = $potwierdzenie;
        $package->masa = $masa;
        $package->zawartosc = $zawartosc;
        $package->numerPrzesylkiKlienta = $numer;
        $package->opis = $opis;
        $this->_przesylki[] = $package;
        return true;
    }

    /**
     * Metoda umozliwa dodanie przesylki poleconej krajowej
     * @param $adres
     * @param $kategoria
     * @param $format
     * @param $masa
     * @param bool $obszarMiasto
     * @param bool $miejscowa
     * @param int $iloscPotwierdzenOdbioru
     * @param string $numer
     * @param bool $dlaOciemnialych
     * @param bool $egzemplarzBiblioteczny
     * @param string $opis
     * @param bool $posteRestante
     * @return bool
     */
    public function addPrzesylkaPoleconaKrajowa($adres, $kategoria, $format, $masa, $obszarMiasto = true, $miejscowa = true, $iloscPotwierdzenOdbioru = 0, $numer = '', $dlaOciemnialych = false, $egzemplarzBiblioteczny = false, $opis = '', $posteRestante = false) {
        $package = new przesylkaPoleconaKrajowaType();
        $package->adres = $adres;
        $package->posteRestante = $posteRestante;
        $package->dlaOciemnialych = $dlaOciemnialych;
        $package->egzemplarzBiblioteczny = $egzemplarzBiblioteczny;
        $package->iloscPotwierdzenOdbioru = $iloscPotwierdzenOdbioru;
        $package->masa = $masa;
        //$package->miejscowa = $miejscowa;
        //$package->obszarMiasto = $obszarMiasto;
        $package->kategoria = $kategoria;
        $package->format = $format;
        $package->guid = $this->createGuid();
        $package->opis = $opis;
        $this->_przesylki[] = $package;
        return true;
    }

    /**
     * Metoda umozliwa dodanie przesylki poleconej firmowej
     * @param $adres
     * @param $opis
     * @param $kategoria
     * @param $gabaryt
     * @param $masa
     * @param bool $miejscowa
     * @param int $iloscPotwierdzenOdbioru
     * @param string $zasadySpecjalne
     * @param bool $posteRestante
     * @return bool
     */
    public function addPrzesylkaPoleconaFirmowa($adres, $opis, $kategoria, $gabaryt,$masa, $miejscowa = true, $iloscPotwierdzenOdbioru = 0, $zasadySpecjalne = '', $posteRestante = false) {
        $package = new przesylkaFirmowaPoleconaType();
        $package->adres = $adres;
        $package->zasadySpecjalne = $zasadySpecjalne;
        $package->posteRestante = $posteRestante;
        $package->iloscPotwierdzenOdbioru = $iloscPotwierdzenOdbioru;
        $package->masa = $masa;
        $package->opis = $opis;
        $package->miejscowa = $miejscowa;
        $package->kategoria = $kategoria;
        $package->gabaryt = $gabaryt;
        $package->guid = $this->createGuid();
        $this->_przesylki[] = $package;
        return true;
    }

    /**
     * Metoda umozliwiajaca dodanie przesylki poleconej zagranicznej
     * @param $adres
     * @param $opis
     * @param $masa
     * @param int $iloscPotwierdzenOdbioru
     * @param bool $posteRestante
     * @return bool
     */
    public function addPrzesylkaPoleconaZagraniczna($adres, $opis, $masa, $iloscPotwierdzenOdbioru = 0, $posteRestante = false) {
        $package = new przesylkaPoleconaZagranicznaType();
        $package->adres = $adres;
        $package->posteRestante = $posteRestante;
        $package->masa = $masa;
        $package->opis = $opis;
        $package->iloscPotwierdzenOdbioru = $iloscPotwierdzenOdbioru;
        $package->guid = $this->createGuid();
        $this->_przesylki[] = $package;
        return true;
    }

    /**
     * Metoda uzmowliwajaca dodanie paczki zagaranicznej
     * @param $adres
     * @param $masa
     * @param $opis
     * @param $kategoria
     * @param $wartosc
     * @param int $iloscPotwierdzenOdbioru
     * @param $zwrot
     * @return bool
     */
    public function addPaczkaZagraniczna($adres, $masa, $opis, $kategoria, $wartosc, $iloscPotwierdzenOdbioru = 0, $zwrot) {
        $package = new paczkaZagranicznaType();
        $package->adres = $adres;
        $package->masa = $masa;
        $package->opis = $opis;
        $package->wartosc = $wartosc;
        $package->kategoria = $kategoria;
//        $package->numerReferencyjnyCelny = $numer;
        $package->iloscPotwierdzenOdbioru = $iloscPotwierdzenOdbioru;
        $package->zwrot = $zwrot;
        $package->guid = $this->createGuid();
        $this->_przesylki[] = $package;
        return true;
    }

    /**
     * Metoda umozliwajaca dodanie paczki EMS
     * @param $adres
     * @param $masa
     * @param $opis
     * @param $typ
     * @param $ubezpieczenie
     * @param $potwierdzenieDoreczenia
     * @return bool
     */
    public function addEMS($adres, $masa, $opis, $typ, $ubezpieczenie, $potwierdzenieDoreczenia) {
        $package = new EMSType();
        $package->adres = $adres;
        $package->typOpakowania = $typ;
        $package->masa = $masa;
        $package->ubezpieczenie = $ubezpieczenie;
        $package->opis = $opis;
        $package->guid = $this->createGuid();
        $package->potwierdzenieDoreczenia = $potwierdzenieDoreczenia;
        $this->_przesylki[] = $package;
        return true;
    }

    /**
     * Metoda umożliwiająca przesuwanie przesyłek pomiędzy buforami
     * @param integer $idBuforFrom
     * @param iteger $idBuforTo
     * @param array $guids
     * @return array
     */
    public function move($idBuforFrom, $idBuforTo, array $guids) {
        $result = false;
        if ($idBuforFrom != $idBuforTo) {
            if (!$this->isFull($idBuforTo)) {
                $size = $this->getRemained($idBuforTo);
                if ($size > count($guids)) {
                    $result = $this->_callWebservice('moveShipments', array('idBuforFrom' => $idBuforFrom, 'idBuforTo' => $idBuforTo, 'guid' => $guids));
                } else {
                    $this->errors[] = Translate::getAdminTranslation(sprintf('Do bufora docelowego można przesunąć %s przesyłki', $size));
                }
            } else {
                $this->errors[] = Translate::getAdminTranslation('Bufor docelowy jest pełny');
            }
        }
        return $result;
    }

    /**
     * Metoda pozwalająca dodać przesyłki
     * @return array
     */
    public function add($idBufor = '') {
        if (empty($idBufor) || $idBufor == 0 || $idBufor == '') {
            $idBufor = $this->getNextBufor();
        }
        $params = array('przesylki' => $this->_przesylki,'idBufor'=>$idBufor);
        if ($this->isFull($idBufor)) {
            $idBufor = $params['idBufor'] = $this->getNextBufor();
        }
        $result = $this->_callWebservice('addShipment', $params);
        if (isset($result['retval'])) {
            if (empty($idBufor)) {
                PPOrderSet::reloadData();
                $idBufor = $this->getNextBufor();
            }
            $result['retval']['id_buffor'] = $idBufor;
            return $result['retval'];
        }
        return false;
    }

    /**
     * Metoda sprawdzajaca czy bufor jest przepelniony > 500
     * @param string $idBufor
     * @return bool
     */
    public function isFull($idBufor = '') {
        $packages = ENadawca::EnvelopeBuffor()->get($idBufor);
        return is_bool($packages) || count($packages) > 500;
    }

    /**
     * metoda zwracajaca iloc przesylek w buforze
     * @param string $idBufor
     * @return int
     */
    public function getSize($idBufor = '') {
        $packages = ENadawca::EnvelopeBuffor()->get($idBufor);
        return count($packages);
    }

    /**
     * Metoda zwraca ile jeszcze moze sie zmiescie w buforze
     * @param string $idBufor
     * @return int
     */
    public function getRemained($idBufor = '') {
        $packages = ENadawca::EnvelopeBuffor()->get($idBufor);
        $number = 500 - count($packages);
        if ($number <= 0) {
            $number = 0;
        }
        return $number;
    }

    /**
     * metoda zwracajaca wolny bufor
     * @return string
     */
    public function getNextBufor() {
        $list = ENadawca::EnvelopeBuffor()->getList();
        $officesList = ENadawca::UrzedyNadania()->get();
        $offices = array();
        foreach ($officesList as $office) {
            $offices[$office['urzadNadania']] = $office['urzadNadania'];
        }
        foreach ($list as $buffor) {
            if (isset($offices[$buffor['urzadNadania']]) && !$this->isFull($buffor['idBufor'])) {
                return $buffor['idBufor'];
            }
        }
        return '';
    }

}
