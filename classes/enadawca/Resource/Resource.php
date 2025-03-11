<?php

require_once __DIR__ .'/../Soap/Client.php';

/**
 * 
 */
abstract class Resource {

    /**
     *
     * @var type 
     */
    private static $_webService = null;

    private static $api_url = "https://e-nadawca.poczta-polska.pl/websrv/labs.wsdl";

    private static $api_url_endpoint = "https://e-nadawca.poczta-polska.pl/websrv/labs.php";

    public static $test_api_url = "https://en-testwebapi.poczta-polska.pl/websrv/labs.wsdl";

    public static $test_api_url_endpoint = "https://en-testwebapi.poczta-polska.pl/websrv/labs.php";

    /**
     *
     * @var type 
     */
    private $_url = '';

    /**
     *
     * @var type 
     */
    private $_username = '';

    /**
     *
     * @var type 
     */
    private $_password = '';

    /**
     *
     * @var type
     */
    private $_location = '';

    /**
     *
     * @var type 
     */
    private $_debug = false;

    protected  $_options = array();

    /**
     *
     * @var type 
     */
    protected $_errorHandler = null;
    private $_logger = null;
    private $_errors = array();

    /**
     * 
     * @param type $class
     * @return type
     */
    public static function autoload($class) {
        $path = dirname(__FILE__) . '/' . str_replace('_', '/', $class) . '.php';
        if (!file_exists($path)) {
            return;
        }
        require_once $path;
    }

    /**
     * 
     * @return type
     */
    protected function _getWebservice() {
        if (is_null(self::$_webService)) {
            self::$_webService = new Client($this->_url, $this->_username, $this->_password, $this->_location, $this->_debug, $this->_options);
        }
        return self::$_webService;
    }

    /**
     * 
     */
    public function init() {
        $this->_setConnectionParams();
        $this->_logger = new ENadawcaErrorLogger();
    }

    public function resetWebservice(){
        self::$_webService = null;
    }

    /**
     * 
     */
    private function _setConnectionParams() {
        $this->_url = Configuration::get(PPSetting::PP_TEST_URL)?self::$test_api_url:self::$api_url;
        $this->_location = Configuration::get(PPSetting::PP_TEST_URL)?self::$test_api_url_endpoint:self::$api_url_endpoint;
        $this->_username = Configuration::get(PPSetting::PP_USER);
        $this->_password = Configuration::get(PPSetting::PP_PASSWORD);
    }

    protected function _callWebService($function_name, $parameters = array(), array $options = null) {
        try {
            $this->_errors = array();
            return $this->_getWebservice()->call($function_name, $parameters, $options);
        } catch (ClientException $e) {
            $this->_errors[] = Translate::getAdminTranslation('Wystąpił błąd komunikacji z Elektronicznym Nadawcą');
            $this->_logger->logException($e);
        } catch (ENadawcaException $e) {
            $this->_errors[] = Translate::getAdminTranslation($e->getMessage());
            $this->_logger->logException($e);
        }
        return false;
    }

    public function getErrors() {
        $errors = $this->_errors;
        return $errors;
    }

    public function hasErrors() {
        return !empty($this->_errors);
    }

    /**
     * 
     * @return type
     */
    public function createGuid() {
        mt_srand((double) microtime() * 10000);
        $charid = strtoupper(md5(uniqid(rand(), true)));
        $retval = substr($charid, 0, 32);
        return $retval;
    }

}

/**
 * 
 */
abstract class ShipmentCategory {

    const EKONOMICZNA = 'EKONOMICZNA';
    const PRIORYTETOWA = 'PRIORYTETOWA';

}

/**
 * 
 */
abstract class Gabaryt {

    const A = 'GABARYT_A';
    const B = 'GABARYT_B';

}

/**
 * 
 */
class paczkaPocztowaPLUSType {

    public $posteRestante; // boolean
    public $iloscPotwierdzenOdbioru; // iloscPotwierdzenOdbioruType
    public $kategoria; // kategoriaType
    public $gabaryt; // gabarytType
    public $wartosc; // wartoscType
    public $masa; // masaType
    public $zwrotDoslanie; // boolean

}

/**
 * 
 */
class przesylkaPobraniowaType {

    public $pobranie; // pobranieType
    public $posteRestante; // boolean
    public $iloscPotwierdzenOdbioru; // iloscPotwierdzenOdbioruType
    public $kategoria; // kategoriaType
    public $gabaryt; // gabarytType
    public $ostroznie; // boolean
    public $wartosc; // wartoscType
    public $masa; // masaType

}

/**
 * 
 */
class przesylkaNaWarunkachSzczegolnychType {

    public $posteRestante; // boolean
    public $iloscPotwierdzenOdbioru; // iloscPotwierdzenOdbioruType
    public $kategoria; // kategoriaType
    public $wartosc; // wartoscType
    public $masa; // masaType

}

/**
 * 
 */
class przesylkaPoleconaKrajowaType {

    public $epo; // EPOType
    public $zasadySpecjalne; // zasadySpecjalneEnum
    public $posteRestante; // boolean
    public $iloscPotwierdzenOdbioru; // iloscPotwierdzenOdbioruType
    public $kategoria; // kategoriaType
    public $gabaryt; // gabarytType
    public $format;
    public $masa; // masaType
    public $egzemplarzBiblioteczny; // boolean
    public $dlaOciemnialych; // boolean
    public $obszarMiasto; // boolean
    public $miejscowa; // boolean
    public $opis;

}

/**
 * 
 */
class przesylkaHandlowaType {

    public $posteRestante; // boolean
    public $masa; // masaType

}

/**
 * 
 */
class przesylkaListowaZadeklarowanaWartoscType {

    public $posteRestante; // boolean
    public $wartosc; // wartoscType
    public $iloscPotwierdzenOdbioru; // iloscPotwierdzenOdbioruType
    public $kategoria; // kategoriaType
    public $gabaryt; // gabarytType
    public $masa; // masaType

}

/**
 * 
 */
class przesylkaFullType {

    public $przesylkaShort; // przesylkaShortType
    public $przesylkaFull; // przesylkaType

}

/**
 * 
 */
class przesylkaZagranicznaType {

    public $posteRestante; // boolean
    public $kategoria; // kategoriaType
    public $masa; // masaType
    public $ekspres; // boolean
    public $kraj; // string

}

/**
 * 
 */
class przesylkaRejestrowanaType {

    public $adres; // adresType
    public $nadawca; // adresType
    public $relatedToAllegro; // relatedToAllegroType
    public $numerNadania; // numerNadaniaType
    public $sygnatura; // sygnaturaType
    public $terminSprawy; // terminType
    public $rodzaj; // rodzajType
    public $weryfikacjaPlatnosci; // boolean

}

/**
 * 
 */
class przesylkaNieRejestrowanaType {

    public $ilosc; // anonymous97

}

/**
 * 
 */
class paczkaPocztowaType {

    public $epo; // EPOType
    public $zasadySpecjalne; // zasadySpecjalneEnum
    public $posteRestante; // boolean
    public $iloscPotwierdzenOdbioru; // iloscPotwierdzenOdbioruType
    public $kategoria; // kategoriaType
    public $gabaryt; // gabarytType
    public $masa; // masaType
    public $wartosc; // wartoscType
    public $zwrotDoslanie; // boolean
    public $egzemplarzBiblioteczny; // boolean
    public $dlaOciemnialych; // boolean
    public $opis;//string

}

/**
 * 
 */
class Adres {

    public $nazwa;
    public $nazwa2;
    public $ulica;
    public $numerDomu;
    public $numerLokalu;
    public $miejscowosc;
    public $kodPocztowy;
    public $kraj;
    public $telefon;
    public $email;
    public $mobile;
    public $osobaKontaktowa;
    public $nip;

    public static function get($params = array()) {
        $self = new self;
        foreach ($params as $k => $v) {
            $self->$k = $v;
        }
        return (array) $self;
    }

}

class Pobranie {

    public $sposobPobrania;
    public $kwotaPobrania;
    public $nrb;
    public $tytulem;
    public $sprawdzenieZawartosciPrzesylkiPrzezOdbiorce;

    const SPOSOB_POBRANIA_PRZEKAZ = 'PRZEKAZ';
    const SPOSOB_POBRANIA_RACHUNEK_BANKOWY = 'RACHUNEK_BANKOWY';

}

class Ubezpieczenie {

    public $rodzaj;
    public $kwota;

    const RODZAJ_STANDARD = 'STANDARD';
    const RODZAJ_PRECJOZA = 'PRECJOZA';

}

class globalExpresType {

    public $ubezpieczenie; // ubezpieczenieType
    public $potwierdzenieDoreczenia; // potwierdzenieDoreczeniaType
    public $masa; // masaType
    public $posteRestante; // boolean
    public $zawartosc; // string
    public $kategoria; // kategoriaType
    public $numerPrzesylkiKlienta; // string

}

class przesylkaFirmowaPoleconaType {

    public $epo; // EPOType
    public $zasadySpecjalne; // zasadySpecjalneEnum
    public $posteRestante; // boolean
    public $iloscPotwierdzenOdbioru; // iloscPotwierdzenOdbioruType
    public $masa; // masaType
    public $miejscowa; // boolean
    public $obszarMiasto; // boolean
    public $kategoria; // kategoriaType
    public $gabaryt; // gabarytType
    public $opis;

}

class EMSType {

    public $ubezpieczenie; // ubezpieczenieType
    public $deklaracjaCelna; // deklaracjaCelnaType
    public $potwierdzenieDoreczenia; //potwierdzenieDoreczeniaType
    public $typOpakowania; // EMSTypOpakowaniaType
    public $masa; // masaType
    public $zalaczoneDokumenty; // boolean
    public $opis;

}

class paczkaZagranicznaType {

    public $zwrot; // zwrotType
    public $deklaracjaCelna; // deklaracjaCelnaType
    public $posteRestante; // boolean
    public $masa; // masaType
    public $wartosc; // wartoscType
    public $kategoria; // kategoriaType
    public $iloscPotwierdzenOdbioru; // iloscPotwierdzenOdbioruType
    public $utrudnionaManipulacja; // boolean
    public $ekspres; // boolean
    public $numerReferencyjnyCelny; // string
    public $opis;

}

class przesylkaPoleconaZagranicznaType {

    public $posteRestante;
    public $kategoria;
    public $masa;
    public $iloscPotwierdzenOdbioru;
    public $ekspres;
    public $opis;

}

class PotwierdzenieDoreczenia {

    public $sposob; // sposobDoreczeniaPotwierdzeniaType
    public $kontakt; // string

}

class przesylkaBiznesowaType {

    public $pobranie; // pobranieType
    public $urzadWydaniaEPrzesylki; // urzadWydaniaEPrzesylkiType
    public $subPrzesylka; // subPrzesylkaBiznesowaType
    public $ubezpieczenie; // ubezpieczenieType
    public $epo; // EPOType
    public $adresDlaZwrotu; //adresDlaZwrotuType
    public $zasadySpecjalne; // zasadySpecjalneEnum
    public $masa; // masaType
    public $gabaryt; // gabarytBiznesowaType
    public $wartosc; // wartoscType
    public $ostroznie; // boolean
    public $numerTransakcjiOdbioru; // numerTransakcjiOdbioruType
    public $opis;
    public $guid;
    public $niestandardowa;
    public $potwierdzenieOdbioru;
    public $doreczenie;
    public $zwrotDokumentow;
    public $sprawdzenieZawartosciPrzesylkiPrzezOdbiorce; // boolean

}
class pocztexKrajowyType {
  public $pobranie; // pobranieType
  public $odbiorPrzesylkiOdNadawcy; // odbiorPrzesylkiOdNadawcyType
  public $doreczenie; // doreczenieType
  public $zwrotDokumentow; // zwrotDokumentowType
  public $potwierdzenieOdbioru; // potwierdzenieOdbioruType
  public $potwierdzenieDoreczenia; // potwierdzenieDoreczeniaType
  public $ubezpieczenie; // ubezpieczenieType
  public $posteRestante; // boolean
  public $terminRodzaj; // terminRodzajType
  public $kopertaFirmowa; // boolean
  public $masa; // masaType
  public $wartosc; // wartoscType
  public $ostroznie; // boolean
  public $ponadgabaryt; // boolean
  public $uiszczaOplate; // uiszczaOplateType
  public $odleglosc; // int
  public $zawartosc; // string
  public $sprawdzenieZawartosciPrzesylkiPrzezOdbiorce; // boolean
}

class uslugaKurierskaType {

    public $pobranie; // pobranieType
    public $odbiorPrzesylkiOdNadawcy; // odbiorPrzesylkiOdNadawcyType
    public $potwierdzenieDoreczenia; // potwierdzenieDoreczeniaType
    public $urzadWydaniaEPrzesylki; // urzadWydaniaEPrzesylkiType
    public $subPrzesylka; // subUslugaKurierskaType
    public $potwierdzenieOdbioru; // potwierdzenieOdbioruKurierskaType
    public $ubezpieczenie; // ubezpieczenieType
    public $zwrotDokumentow; // zwrotDokumentowKurierskaType
    public $idDokumentyZwrotneAdresy;
    public $doreczenie; // doreczenieUslugaKurierskaType
    public $epo; // EPOType
    public $adresDlaZwrotu;
    public $zasadySpecjalne; // zasadySpecjalneEnum
    public $masa; // masaType
    public $wartosc; // wartoscType
    public $ponadgabaryt; // boolean
    public $odleglosc; // int
    public $zawartosc; // string
    public $sprawdzenieZawartosciPrzesylkiPrzezOdbiorce; // boolean
    public $ostroznie; // boolean
    public $uiszczaOplate; // uiszczaOplateType
    public $termin; // terminKurierskaType
    public $opakowanie; // opakowanieKurierskaType
    public $numerPrzesylkiKlienta; // string
    public $numerTransakcjiOdbioru; // numerTransakcjiOdbioruType
    public $opis;

}

class PlacowkaPocztowa {
    public $lokalizacjaGeograficzna; // lokalizacjaGeograficznaType
    public $id; // int
    public $prefixNazwy; // string
    public $nazwa; // string
    public $wojewodztwo; // string
    public $powiat; // string
    public $miejsce; // string
    public $kodPocztowy; // anonymous127
    public $miejscowosc; // anonymous128
    public $ulica; // string
    public $numerDomu; // string
    public $numerLokalu; // string
    public $nazwaWydruk; // string
    public $punktWydaniaEPrzesylki; // boolean
    public $powiadomienieSMS; // boolean
    public $punktWydaniaPrzesylkiBiznesowejPlus; // boolean
    public $punktWydaniaPrzesylkiBiznesowej; // boolean
    public $siecPlacowek; // siecPlacowekEnum
    public $idZPO; // string

}


class TerminRodzaj {
  const MIEJSKI_DO_3H_DO_5KM = 'MIEJSKI_DO_3H_DO_5KM';
  const MIEJSKI_DO_3H_DO_10KM = 'MIEJSKI_DO_3H_DO_10KM';
  const MIEJSKI_DO_3H_DO_15KM = 'MIEJSKI_DO_3H_DO_15KM';
  const MIEJSKI_DO_3H_POWYZEJ_15KM = 'MIEJSKI_DO_3H_POWYZEJ_15KM';
  const MIEJSKI_DO_4H_DO_10KM = 'MIEJSKI_DO_4H_DO_10KM';
  const MIEJSKI_DO_4H_DO_15KM = 'MIEJSKI_DO_4H_DO_15KM';
  const MIEJSKI_DO_4H_DO_20KM = 'MIEJSKI_DO_4H_DO_20KM';
  const MIEJSKI_DO_4H_DO_30KM = 'MIEJSKI_DO_4H_DO_30KM';
  const MIEJSKI_DO_4H_DO_40KM = 'MIEJSKI_DO_4H_DO_40KM';
  const KRAJOWY = 'KRAJOWY';
  const BEZPOSREDNI_DO_20KG = 'BEZPOSREDNI_DO_20KG';
  const BEZPOSREDNI_DO_30KG = 'BEZPOSREDNI_DO_30KG';
  const BEZPOSREDNI_OD_30KG_DO_100KG = 'BEZPOSREDNI_OD_30KG_DO_100KG';
  const EKSPRES24 = 'EKSPRES24';
}

class UiszczaOplate{
  const NADAWCA = 'NADAWCA';
  const ADRESAT = 'ADRESAT';
}

class DoreczenieUslugaKurierska {
  public $oczekiwanyTerminDoreczenia; // date
  public $oczekiwanaGodzinaDoreczenia; // oczekiwanaGodzinaDoreczeniaUslugiType
  public $wSobote; // boolean
  public $w90Minut; // boolean
  public $wNiedzieleLubSwieto; // boolean
  public $doRakWlasnych; // boolean
  public $wGodzinachOd20Do7; // boolean
  public $po17; // boolean
}


class PotwierdzenieOdbioru {
  public $ilosc;
  public $sposob;
}


class OdbiorPrzesylkiOdNadawcy{
  public $wSobote; // boolean
  public $wNiedzieleLubSwieto; // boolean
  public $wGodzinachOd20Do7; // boolean
}

class ZwrotDokumentowKurierska {
  public $rodzajPocztex; // terminZwrotDokumentowKurierskaType
  public $rodzajPaczka; // terminZwrotDokumentowPaczkowaType
  public $rodzajList; // rodzajListType
}

class rodzajListType {
    public $polecony; // boolean
    public $kategoria; // kategoriaType
}

class Zwrot {
  public $zwrotPoLiczbieDni; // int
  public $traktowacJakPorzucona; // boolean
  public $sposobZwrotu; // sposobZwrotuType
}

class subPrzesylkaBiznesowaType {
  public $ubezpieczenie; // ubezpieczenieType
  public $numerNadania; // numerNadaniaType
  public $masa; // masaType
  public $gabaryt; // gabarytBiznesowaType
  public $wartosc; // wartoscType
  public $ostroznie; // boolean
  public $guid; // guid paczki
}

class subUslugaKurierskaType {
  public $pobranie; // pobranieType
  public $ubezpieczenie; // ubezpieczenieType
  public $numerNadania; // numerNadaniaType
  public $masa; // masaType
  public $wartosc; // wartoscType
  public $ostroznie; // boolean
  public $opakowanie; // opakowanieKurierskaType
  public $ponadgabaryt; // boolean
  public $numerPrzesylkiKlienta; // string
}

class kartaType {
  public $idKarta; // int
  public $opis; // string
  public $aktywna; // boolean
}
class doreczenieBiznesowaType {
    public $doRakWlasnych;
}
class zwrotDokumentowBiznesowaType {
    public $rodzaj;
    public $idDokumentyZwrotneAdresy;
}

class pocztex2021KurierType
{
    public $subPrzesylka;
    public $punktOdbioru;
    public $punktNadania;
    public $kopertaPocztex;
    public $godzinaDoreczenia;
    public $doreczenieWeWskazanymDniu;
}

class subPocztex2021KurierType
{
    public $pobranie;
    public $ubezpieczenie;
    public $numerNadania;
    public $masa;
    public $wartosc;
    public $ostroznie;
    public $ponadgabaryt;
    public $format;
    public $numerPrzesylkiKlienta;
}

class pocztex2021NaDzisType
{
    public $subPrzesylka;
    public $odleglosc;
    public $obszar;
}

class subPocztex2021NaDzisType
{
    public $pobranie;
    public $ubezpieczenie;
    public $numerNadania;
    public $masa;
    public $wartosc;
    public $ostroznie;
    public $ponadgabaryt;
    public $format;
    public $numerPrzesylkiKlienta;
}

class zawartoscPocztex2021Type {
    public $zawartoscSpecjalna;
    public $zawartoscInna;
}

class potwierdzenieEDoreczeniaType {
 public $sposob;
 public $kontakt;
}

class placowkaPocztowaType {
    public $id; // int
    public $prefixNazwy; // string
    public $nazwa; // string
    public $siecPlacowek;
    public $wojewodztwo; // string
    public $powiat; // string
    public $miejsce; // string
    public $kodPocztowy; // anonymous127
    public $miejscowosc; // anonymous128
    public $ulica; // string
    public $numerDomu; // string
    public $numerLokalu; // string
    public $nazwaWydruk; // string
    public $punktWydaniaEPrzesylki; // boolean
    public $powiadomienieSMS; // boolean
    public $punktWydaniaPrzesylkiBiznesowejPlus; // boolean
    public $lokalizacjaGeograficzna;
    public $punktWydaniaPrzesylkiBiznesowej; // boolean
    public $deliveryPath;

}