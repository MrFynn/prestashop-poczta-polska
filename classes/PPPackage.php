<?php

class PPPackage {

    public $package;
    public $address;
    public $customer;
    public $errors = array();
    public $przesylkiZagraniczne = array(
        self::PP_ZAGRANICZNA_PRZESYLKA,
        self::PP_EMS_UE,
        self::PP_PACZKA_UE
    );

    const TYPE_INT = 1;
    const TYPE_BOOL = 2;
    const TYPE_STRING = 3;
    const TYPE_FLOAT = 4;
    const TYPE_DATE = 5;
    const TYPE_HTML = 6;
    const TYPE_NOTHING = 7;
    const TYPE_SQL = 8;
    //general
    const PP_POCZTEX_48 = 'pp_pocztex_48';
    const PP_POCZTEX = 'pp_pocztex';

    const PP_POCZTEX_2021_KURIER = 'pp_pocztex_2021_kurier';
    const PP_POCZTEX_2021_DZIS = 'pp_pocztex_2021_dzis';

    const PP_PACZKA_POCZTOWA = 'pp_paczka_pocztowa';
    const PP_GLOBAL_EXPRESS = 'pp_global_express';
    const PP_PRZESYLKA_POLECONA = 'pp_przesylka_polecona';
    const PP_PRZESYLKA_FIRMOWA = 'pp_przesylka_firmowa';
    const PP_PACZKA_UE = 'pp_paczka_ue';
    const PP_ZAGRANICZNA_PRZESYLKA = 'pp_zagraniczna_przesylka';
    const PP_EMS_UE = 'pp_ems_ue';
    const PP_POCZTEX_48_DELIVERY = 'pp_pocztex_48_delivery';
    const PP_POCZTEX_48_DELIVERY_COD = 'pp_pocztex_48_delivery_cod';

    const PP_POCZTEX_2021_KURIER_DELIVERY = 'pp_pocztex_2021_kurier_delivery';
    const PP_POCZTEX_2021_KURIER_DELIVERY_COD = 'pp_pocztex_2021_kurier_delivery_cod';

    const PP_POCZTEX_2021_DZIS_DELIVERY = 'pp_pocztex_2021_dzis_delivery';
    const PP_POCZTEX_2021_DZIS_DELIVERY_COD = 'pp_pocztex_2021_dzis_delivery_cod';

    const PP_POCZTEX_DELIVERY = 'pp_pocztex_delivery';
    const PP_POCZTEX_DELIVERY_COD = 'pp_pocztex_delivery_cod';
    const PP_POCZTEX_WARTOSC_ZL = 'pp_pocztex_wartosc_zl';
    const PP_PACZKA_POCZTOWA_DELIVERY = 'pp_paczka_pocztowa_delivery';
    const PP_GLOBAL_EXPRESS_DELIVERY = 'pp_global_express_delivery';
    const PP_PRZESYLKA_POLECONA_DELIVERY = 'pp_przesylka_polecona_delivery';
    const PP_PRZESYLKA_FIRMOWA_DELIVERY = 'pp_przesylka_firmowa_delivery';
    const PP_PACZKA_UE_DELIVERY = 'pp_paczka_ue_delivery';
    const PP_ZAGRANICZNA_PRZESYLKA_DELIVERY = 'pp_zagraniczna_przesylka_delivery';
    const PP_EMS_UE_DELIVERY = 'pp_ems_ue_delivery';
    const PP_PACKAGES = 'pp_packages';
    const PP_PACKAGES_CON = 'pp_packages_con';
    //package settings
    const PP_POCZTEX_48_PICKUP_AT_POINT_STANDARD = 'pp_pocztex_48_pickup_at_point_standard_delivery';
    const PP_POCZTEX_48_PICKUP_AT_POINT_COD = 'pp_pocztex_48_pickup_at_point_cod_delivery';

    const PP_POCZTEX_2021_KURIER_PICKUP_AT_POINT_STANDARD = 'pp_pocztex_2021_kurier_pickup_at_point_standard_delivery';
    const PP_POCZTEX_2021_KURIER_PICKUP_AT_POINT_COD = 'pp_pocztex_2021_kurier_pickup_at_point_cod_delivery';

    const PP_POCZTEX_PICKUP_AT_POINT_STANDARD = 'pp_pocztex_pickup_at_point_standard_delivery';
    const PP_POCZTEX_PICKUP_AT_POINT_COD = 'pp_pocztex_pickup_at_point_cod_delivery';
    const PP_POCZTEX_48_IS_PICKUP_AT_POINT = 'pp_pocztex_48_is_pickup_at_point';

    const PP_POCZTEX_48_IS_PICKUP_AT_AUTOMAT = 'pp_pocztex_48_is_pickup_at_automat';
    const PP_POCZTEX_48_PICKUP_AT_AUTOMAT_STANDARD = 'pp_pocztex_48_pickup_at_automat_standard_delivery';
    const PP_POCZTEX_48_PICKUP_AT_AUTOMAT_COD = 'pp_pocztex_48_pickup_at_automat_cod_delivery';

    const PP_POCZTEX_IS_PICKUP_AT_AUTOMAT = 'pp_pocztex_is_pickup_at_automat';
    const PP_POCZTEX_PICKUP_AT_AUTOMAT_STANDARD = 'pp_pocztex_pickup_at_automat_standard_delivery';
    const PP_POCZTEX_PICKUP_AT_AUTOMAT_COD = 'pp_pocztex_pickup_at_automat_cod_delivery';

    const PP_POCZTEX_2021_KURIER_IS_PICKUP_AT_AUTOMAT = 'pp_pocztex_2021_kurier_is_pickup_at_automat';
    const PP_POCZTEX_2021_KURIER_PICKUP_AT_AUTOMAT_STANDARD = 'pp_pocztex_2021_kurier_pickup_at_automat_standard_delivery';
    const PP_POCZTEX_2021_KURIER_PICKUP_AT_AUTOMAT_COD = 'pp_pocztex_2021_kurier_pickup_at_automat_cod_delivery';

    const PP_POCZTEX_2021_KURIER_IS_PICKUP_AT_POINT = 'pp_pocztex_2021_kurier_is_pickup_at_point';

    const PP_POCZTEX_IS_PICKUP_AT_POINT = 'pp_pocztex_is_pickup_at_point';
    //pocztex 48
    const PP_POCZTEX_48_GABARYT = 'pp_pocztex_48_gabaryt';
    const PP_POCZTEX_48_OPIS_PRZESYLKI = 'pp_pocztex_48_opis_przesylki';
    const PP_POCZTEX_48_POBRANIE = 'pp_pocztex_48_pobranie';
    const PP_POCZTEX_48_NUMER_RACHUNKU = 'pp_pocztex_48_numer_rachunku';
    const PP_POCZTEX_48_TYTUL_POBRANIA = 'pp_pocztex_48_tytul_pobrania';
    const PP_POCZTEX_48_KWOTA_POBRANIA = 'pp_pocztex_48_kwota_pobrania_zl';
    const PP_POCZTEX_48_PRZESYLKA_NIESTANDARDOWA = 'pp_pocztex_48_niestandardowa';
    const PP_POCZTEX_48_DEKLARACJA_WARTOSCI = 'pp_pocztex_48_deklaracja_wartosci';
    const PP_POCZTEX_48_WARTOSC_ZL = 'pp_pocztex_48_wartosc_zl';
    const PP_POCZTEX_48_WARTOSC_KG = 'pp_pocztex_48_wartosc_kg';
    const PP_POCZTEX_48_OSTROZNIE = 'pp_pocztex_48_ostroznie';
    const PP_POCZTEX_48_ODBIORCA = 'pp_pocztex_48_odbiorca';
    const PP_POCZTEX_48_UBEZPIECZENIE = 'pp_pocztex_48_ubezpieczenie';
    const PP_POCZTEX_48_WARTOSC_UBEZPIECZENIA = 'pp_pocztex_48_wartosc_ubezpieczenia';
    const PP_POCZTEX_48_OKRESLONA_WARTOSC = 'pp_pocztex_48_okreslona_wartosc';
    const PP_POCZTEX_48_NALEPKA_ZWROTNA_POCZTEX = 'pp_pocztex_48_nalepka_zwrotna';
    const PP_POCZTEX_48_NUMER_WEWNETRZNY = 'pp_pocztex_48_numer_wewnetrzny';
    const PP_POCZTEX_48_NUMER_WEWNETRZNY_TEXT = 'pp_pocztex_48_numer_wewnetrzny_text';
    const PP_POCZTEX_48_ODBIOR_W_PUNKCIE = "pp_pocztex_48_odbior_w_punkcie";
    const PP_POCZTEX_48_POKAZ_MAPE = "pp_pocztex_48_pokaz_mape";
    const PP_POCZTEX_48_PNI = "pp_pocztex_48_pni";
    const PP_POCZTEX_48_WIELOPACZKOWOSC = "pp_pocztex_48_wielopaczkowosc";
    const PP_POCZTEX_48_WIELOPACZKOWOSC_ILOSC = "pp_pocztex_48_wielopaczkowosc_ilosc";
    const PP_POCZTEX_48_DORECZENIE_DO_RAK_WLASNYCH = 'pp_pocztex_48_doreczenie_do_rak';
    const PP_POCZTEX_48_RODZAJ_POTWIERDZENIA = 'pp_pocztex_48_rodzaj_potwierdzenia';
    const PP_POCZTEX_48_POTWIERDZENIE_ILE = 'pp_pocztex_48_potwierdzenie_ile';
    const PP_POCZTEX_48_POTWIERDZENIE_ODBIORU = 'pp_pocztex_48_potwierdzenie_odbioru';
    const PP_POCZTEX_48_DOKUMENTY_ZWROTNE = 'pp_pocztex_48_dokumenty_zwrotne';
    const PP_POCZTEX_48_DOKUMENTY_RODZAJ_POTWIERDZENIA = 'pp_pocztex_48_dokumenty_rodzaj_potwierdzenia';
    const PP_POCZTEX_48_WYSLANE_DO = 'pp_pocztex_48_wyslane_do';

    //pocztex 2021 kurier
    const PP_POCZTEX_2021_KURIER_NADANIE_U_KURIERA = 'pp_pocztex_2021_kurier_nadanie_u_kuriera';
    const PP_POCZTEX_2021_KURIER_FORMAT = 'pp_pocztex_2021_kurier_format';
    const PP_POCZTEX_2021_KURIER_OPIS_PRZESYLKI = 'pp_pocztex_2021_kurier_opis_przesylki';
    const PP_POCZTEX_2021_KURIER_POBRANIE = 'pp_pocztex_2021_kurier_pobranie';
    const PP_POCZTEX_2021_KURIER_NUMER_RACHUNKU = 'pp_pocztex_2021_kurier_numer_rachunku';
    const PP_POCZTEX_2021_KURIER_TYTUL_POBRANIA = 'pp_pocztex_2021_kurier_tytul_pobrania';
    const PP_POCZTEX_2021_KURIER_PONADGABARYT = 'pp_pocztex_2021_kurier_ponadgabaryt';
    const PP_POCZTEX_2021_KURIER_KOPERTA_POCZTEX = 'pp_pocztex_2021_kurier_koperta_pocztex';
    const PP_POCZTEX_2021_KURIER_GODZINA_DORECZENIA = 'pp_pocztex_2021_kurier_godzina_doreczenia';
    const PP_POCZTEX_2021_KURIER_ODBIOR_SOBOTA = 'pp_pocztex_2021_kurier_odbior_sobota';
    const PP_POCZTEX_2021_KURIER_POTWIERDZENIE_DORECZENIA = 'pp_pocztex_2021_kurier_potwierdzenie_doreczenia';
    const PP_POCZTEX_2021_KURIER_POTWIERDZENIE_DORECZENIA_TYPE = 'pp_pocztex_2021_kurier_potwierdzenie_doreczenia_type';
    const PP_POCZTEX_2021_KURIER_POTWIERDZENIE_DORECZENIA_KONTAKT = 'pp_pocztex_2021_kurier_potwierdzenie_doreczenia_kontakt';
    const PP_POCZTEX_2021_KURIER_TYP_ZAWARTOSCI = 'pp_pocztex_2021_kurier_typ_zawartosci';
    const PP_POCZTEX_2021_KURIER_TYP_ZAWARTOSCI_INNE = 'pp_pocztex_2021_kurier_typ_zawartosci_inne';
    const PP_POCZTEX_2021_KURIER_DEKLARACJA_WARTOSCI = 'pp_pocztex_2021_kurier_deklaracja_wartosci';
    const PP_POCZTEX_2021_KURIER_WARTOSC_ZL = 'pp_pocztex_2021_kurier_wartosc_zl';
    const PP_POCZTEX_2021_KURIER_MASA = 'pp_pocztex_2021_kurier_masa';
    const PP_POCZTEX_2021_KURIER_UBEZPIECZENIE = 'pp_pocztex_2021_kurier_ubezpieczenie';
    const PP_POCZTEX_2021_KURIER_WARTOSC_UBEZPIECZENIA = 'pp_pocztex_2021_kurier_wartosc_ubezpieczenia';
    const PP_POCZTEX_2021_KURIER_OKRESLONA_WARTOSC = 'pp_pocztex_2021_kurier_okreslona_wartosc';
    const PP_POCZTEX_2021_KURIER_OSTROZNIE = 'pp_pocztex_2021_kurier_ostroznie';
    const PP_POCZTEX_2021_KURIER_ODBIORCA = 'pp_pocztex_2021_kurier_odbiorca';
    const PP_POCZTEX_2021_KURIER_PRZESYLKI = 'pp_pocztex_2021_kurier_opis_przesylki';
    const PP_POCZTEX_2021_KURIER_ODBIOR_W_PUNKCIE = "pp_pocztex_2021_kurier_odbior_w_punkcie";
    const PP_POCZTEX_2021_KURIER_POKAZ_MAPE = "pp_pocztex_2021_kurier_pokaz_mape";
    const PP_POCZTEX_2021_KURIER_PNI = "pp_pocztex_2021_kurier_pni";
    const PP_POCZTEX_2021_KURIER_WIELOPACZKOWOSC = "pp_pocztex_2021_kurier_wielopaczkowosc";
    const PP_POCZTEX_2021_KURIER_WIELOPACZKOWOSC_ILOSC = "pp_pocztex_2021_kurier_wielopaczkowosc_ilosc";
    const PP_POCZTEX_2021_KURIER_KWOTA_POBRANIA = 'pp_pocztex_2021_kurier_kwota_pobrania_zl';
    const PP_POCZTEX_2021_KURIER_DZIEN = 'pp_pocztex_2021_kurier_dzien';


    const PP_POCZTEX_2021_KURIER_NALEPKA_ZWROTNA_POCZTEX = 'pp_pocztex_2021_kurier_nalepka_zwrotna';
    const PP_POCZTEX_2021_KURIER_NUMER_WEWNETRZNY = 'pp_pocztex_2021_kurier_numer_wewnetrzny';
    const PP_POCZTEX_2021_KURIER_NUMER_WEWNETRZNY_TEXT = 'pp_pocztex_2021_kurier_numer_wewnetrzny_text';




    const PP_POCZTEX_2021_KURIER_DORECZENIE_DO_RAK_WLASNYCH = 'pp_pocztex_2021_kurier_doreczenie_do_rak';
    const PP_POCZTEX_2021_KURIER_RODZAJ_POTWIERDZENIA = 'pp_pocztex_2021_kurier_rodzaj_potwierdzenia';
    const PP_POCZTEX_2021_KURIER_POTWIERDZENIE_ILE = 'pp_pocztex_2021_kurier_potwierdzenie_ile';
    const PP_POCZTEX_2021_KURIER_POTWIERDZENIE_ODBIORU = 'pp_pocztex_2021_kurier_potwierdzenie_odbioru';
    const PP_POCZTEX_2021_KURIER_DOKUMENTY_ZWROTNE = 'pp_pocztex_2021_kurier_dokumenty_zwrotne';
    const PP_POCZTEX_2021_KURIER_DOKUMENTY_RODZAJ_POTWIERDZENIA = 'pp_pocztex_2021_kurier_dokumenty_rodzaj_potwierdzenia';
    const PP_POCZTEX_2021_KURIER_WYSLANE_DO = 'pp_pocztex_2021_kurier_wyslane_do';



    //pocztex 2021 na dziś
    const PP_POCZTEX_2021_DZIS_FORMAT = 'pp_pocztex_2021_dzis_format';
    const PP_POCZTEX_2021_DZIS_OPIS_PRZESYLKI = 'pp_pocztex_2021_dzis_opis_przesylki';
    const PP_POCZTEX_2021_DZIS_POBRANIE = 'pp_pocztex_2021_dzis_pobranie';
    const PP_POCZTEX_2021_DZIS_NUMER_RACHUNKU = 'pp_pocztex_2021_dzis_numer_rachunku';
    const PP_POCZTEX_2021_DZIS_TYTUL_POBRANIA = 'pp_pocztex_2021_dzis_tytul_pobrania';
    const PP_POCZTEX_2021_DZIS_PONADGABARYT = 'pp_pocztex_2021_dzis_ponadgabaryt';
    const PP_POCZTEX_2021_DZIS_ODBIOR_SOBOTA = 'pp_pocztex_2021_dzis_odbior_sobota';
    const PP_POCZTEX_2021_DZIS_POTWIERDZENIE_DORECZENIA = 'pp_pocztex_2021_dzis_potwierdzenie_doreczenia';
    const PP_POCZTEX_2021_DZIS_POTWIERDZENIE_DORECZENIA_TYPE = 'pp_pocztex_2021_dzis_potwierdzenie_doreczenia_type';
    const PP_POCZTEX_2021_DZIS_POTWIERDZENIE_DORECZENIA_KONTAKT = 'pp_pocztex_2021_dzis_potwierdzenie_doreczenia_kontakt';
    const PP_POCZTEX_2021_DZIS_TYP_ZAWARTOSCI = 'pp_pocztex_2021_dzis_typ_zawartosci';
    const PP_POCZTEX_2021_DZIS_TYP_ZAWARTOSCI_INNE = 'pp_pocztex_2021_dzis_typ_zawartosci_inne';
    const PP_POCZTEX_2021_DZIS_DEKLARACJA_WARTOSCI = 'pp_pocztex_2021_dzis_deklaracja_wartosci';
    const PP_POCZTEX_2021_DZIS_WARTOSC_ZL = 'pp_pocztex_2021_dzis_wartosc_zl';
    const PP_POCZTEX_2021_DZIS_MASA = 'pp_pocztex_2021_dzis_masa';
    const PP_POCZTEX_2021_DZIS_UBEZPIECZENIE = 'pp_pocztex_2021_dzis_ubezpieczenie';
    const PP_POCZTEX_2021_DZIS_WARTOSC_UBEZPIECZENIA = 'pp_pocztex_2021_dzis_wartosc_ubezpieczenia';
    const PP_POCZTEX_2021_DZIS_OKRESLONA_WARTOSC = 'pp_pocztex_2021_dzis_okreslona_wartosc';
    const PP_POCZTEX_2021_DZIS_OSTROZNIE = 'pp_pocztex_2021_dzis_ostroznie';
    const PP_POCZTEX_2021_DZIS_ODBIORCA = 'pp_pocztex_2021_dzis_odbiorca';
    const PP_POCZTEX_2021_DZIS_OBSZAR = 'pp_pocztex_2021_dzis_obszar';
    const PP_POCZTEX_2021_DZIS_WIELOPACZKOWOSC = "pp_pocztex_2021_dzis_wielopaczkowosc";
    const PP_POCZTEX_2021_DZIS_WIELOPACZKOWOSC_ILOSC = "pp_pocztex_2021_dzis_wielopaczkowosc_ilosc";
    const PP_POCZTEX_2021_DZIS_KWOTA_POBRANIA = 'pp_pocztex_2021_dzis_kwota_pobrania_zl';
    const PP_POCZTEX_2021_DZIS_ODLEGLOSC = 'pp_pocztex_2021_dzis_odleglosc';

    //pocztex
    const PP_POCZTEX_SERWIS = 'pp_pocztex_serwis';
    const PP_POCZTEX_OPIS_PRZESYLKI = 'pp_pocztex_opis_przesylki';
    const PP_POCZTEX_ZAWARTOSC = 'pp_pocztex_zawartosc';
    const PP_POCZTEX_MASA = 'pp_pocztex_masa';
    const PP_POCZTEX_ODBIOR_W_PUNKCIE = "pp_pocztex_odbior_w_punkcie";
    const PP_POCZTEX_POKAZ_MAPE = "pp_pocztex_pokaz_mape";
    const PP_POCZTEX_PNI = "pp_pocztex_pni";
    const PP_POCZTEX_DORECZENIE_WE_WSKAZANYM_DNIU = "pp_pocztex_doreczenie_we_wskazanym_dniu";
    const PP_POCZTEX_DATA_DORECZENIA = 'pp_pocztex_data_doreczenia';
    const PP_POCZTEX_WIELOPACZKOWOSC = "pp_pocztex_wielopaczkowosc";
    const PP_POCZTEX_WIELOPACZKOWOSC_ILOSC = "pp_pocztex_wielopaczkowosc_ilosc";
    const PP_POCZTEX_OPLATA = "pp_pocztex_oplata";
    const PP_POCZTEX_KOPERTA = 'pp_pocztex_koperta';
    const PP_POCZTEX_UISZCZA_OPLATE = 'pp_uiszcza_oplate';
    const PP_POCZTEX_GODZINA_DORECZENIA = 'pp_pocztex_godzina_doreczenia';
    const PP_POCZTEX_GODZINA = 'pp_pocztex_godzina';
    const PP_POCZTEX_POBRANIE = 'pp_pocztex_pobranie';
    const PP_POCZTEX_KWOTA_POBRANIA = 'pp_pocztex_kwota_pobrania_zl';
    const PP_POCZTEX_SPOSOB_POBRANIA = 'pp_pocztex_sposob_pobrania';
    const PP_POCZTEX_NUMER_RACHUNKU = 'pp_pocztex_numer_rachunku';
    const PP_POCZTEX_TYTUL_POBRANIA = 'pp_pocztex_tytul_pobrania';
    const PP_POCZTEX_WARTOSC_ZAMOWIENIA = 'pp_pocztex_wartosc_zamowienia';
    const PP_POCZTEX_DEKLARACJA_WARTOSCI = 'pp_pocztex_deklaracja_wartosci';
    const PP_POCZTEX_POTWIERDZENIE_ODBIORU = 'pp_pocztex_potwierdzenie_odbioru';
    const PP_POCZTEX_RODZAJ_POTWIERDZENIA = 'pp_pocztex_rodzaj_potwierdzenia';
    const PP_POCZTEX_POTWIERDZENIE_ILE = 'pp_pocztex_potwierdzenie_ile';
    const PP_POCZTEX_POTWIERDZENIE_DORECZENIA = 'pp_pocztex_potwierdzenie_doreczenia';
    const PP_POCZTEX_TYP_POTWIERDZENIA = 'pp_pocztex_typ_potwierdzenia';
    const PP_POCZTEX_NR_TEL_POTWIERDZENIA = 'pp_pocztex_nr_tel_potwierdzenia';
    const PP_POCZTEX_EMAIL_POTWIERDZENIA = 'pp_pocztex_email_potwierdzenia';
    const PP_POCZTEX_OSTROZNIE = 'pp_pocztex_ostroznie';
    const PP_POCZTEX_PRZESYLKA_NIESTANDARDOWA = 'pp_pocztex_niestandardowa';
    const PP_POCZTEX_SPRAWDZENIE_ZAWARTOSCI = 'pp_pocztex_sprawdzenie_zawartosci';
    const PP_POCZTEX_DORECZENIE_DO_RAK_WLASNYCH = 'pp_pocztex_doreczenie_do_rak';
    const PP_POCZTEX_DORECZENIE_W_SOBOTE = 'pp_pocztex_doreczenie_przesylki_sobota';
    const PP_POCZTEX_ODBIOR_PRZESYLKI_W_SOBOTE = 'pp_pocztex_odbior_przesyki_sobota';
    const PP_POCZTEX_DORECZENIE_W_90_MINUT = 'pp_pocztex_doreczenie_w_90_minut';
    const PP_POCZTEX_DORECZENIE_W_NIEDZIELE_SWIETO = 'pp_pocztex_doreczenie_w_niedziele_swieto';
    const PP_POCZTEX_DORECZENIE_W_20_7 = 'pp_pocztex_doreczenie_w_20_7';
    const PP_POCZTEX_ODBIOR_W_NIEDZIELE_SWIETO = 'pp_pocztex_odbior_w_niedziele_swieto';
    const PP_POCZTEX_ODBIOR_W_20_7 = 'pp_pocztex_odbior_w_20_7';
    const PP_POCZTEX_ODLEGLOSC = 'pp_pocztex_odleglosc';


    const PP_POCZTEX_UBEZPIECZENIE = 'pp_pocztex_ubezpieczenie';
    const PP_POCZTEX_WARTOSC_UBEZPIECZENIA = 'pp_pocztex_wartosc_ubezpieczenia';
    const PP_POCZTEX_OKRESLONA_WARTOSC = 'pp_pocztex_okreslona_wartosc';
    const PP_POCZTEX_DOKUMENTY_ZWROTNE = 'pp_pocztex_dokumenty_zwrotne';
    const PP_POCZTEX_DOKUMENTY_RODZAJ_POTWIERDZENIA = 'pp_pocztex_dokumenty_rodzaj_potwierdzenia';
    const PP_POCZTEX_WYSLANE_DO = 'pp_pocztex_wyslane_do';
    const PP_POCZTEX_NUMER_WEWNETRZNY = 'pp_pocztex_numer_wewnetrzny';
    const PP_POCZTEX_NUMER_WEWNETRZNY_TEXT = 'pp_pocztex_numer_wewnetrzny_text';
    const PP_POCZTEX_NA_SPECJALNYCH_ZASADACH = 'pp_pocztex_na_specjalnych_zasadach';
    const PP_POCZTEX_NA_SPECJALNYCH_ZASADACH_WARTOSCI = 'pp_pocztex_na_specjalnych_zasadach_wartosci';
    //paczka pocztowa
    const PP_PACZKA_POCZTOWA_KATEGORIA = 'pp_paczka_pocztowa_kategoria';
    const PP_PACZKA_POCZTOWA_GABARYT = 'pp_paczka_pocztowa_gabaryt';
    const PP_PACZKA_POCZTOWA_MASA = 'pp_paczka_pocztowa_masa';
    const PP_PACZKA_POCZTOWA_OPIS_PRZESYLKI = 'pp_paczka_pocztowa_opis_przesylki';
    const PP_PACZKA_POCZTOWA_DEKLARACJA_WARTOSCI = 'pp_paczka_pocztowa_deklaracja_wartosci';
    const PP_PACZKA_POCZTOWA_DEKLARACJA_WARTOSCI_ZL = 'pp_paczka_pocztowa_wartosc_zl';
    const PP_PACZKA_POCZTOWA_POTWIERDZENIE_ILE = 'pp_paczka_pocztowa_potwierdzenie_ile';
    const PP_PACZKA_POCZTOWA_NUMER_WEWNETRZNY = 'pp_paczka_pocztowa_numer_wewnetrzny';
    const PP_PACZKA_POCZTOWA_NUMER_WEWNETRZNY_TEXT = 'pp_paczka_pocztowa_numer_wewentrzny_text';
    const PP_PACZKA_POCZTOWA_EGZEMPLARZ_BIBLIOTECZNY = 'pp_paczka_pocztowa_egzemplarz_biblioteczny';
    const PP_PACZKA_POCZTOWA_DLA_OCIEMNIALYCH = 'pp_paczka_pocztowa_dla_ociemnialych';
    //global express
    const PP_GLOBAL_EXPRESS_POTWIERDZENIE_DORECZENIA = 'pp_global_express_potwierdzenie_doreczenia';
    const PP_GLOBAL_EXPRESS_TYP_POTWIERDZENIA = 'pp_global_express_typ_potwierdzenia';
    const PP_GLOBAL_EXPRESS_NR_TEL_POTWIERDZENIA = 'pp_global_express_nr_tel_potwierdzenia';
    const PP_GLOBAL_EXPRESS_EMAIL_POTWIERDZENIA = 'pp_global_express_email_potwierdzenia';
    const PP_GLOBAL_EXPRESS_NUMER_WEWNETRZNY = 'pp_global_express_numer_wewnetrzny';
    const PP_GLOBAL_EXPRESS_NUMER_WEWNETRZNY_TEXT = 'pp_global_express_numer_wewnetrzny_text';
    const PP_GLOBAL_EXPRESS_ZAWARTOSC = 'pp_global_express_zawartosc';
    const PP_GLOBAL_EXPRESS_MASA = 'pp_global_express_masa';
    const PP_GLOBAL_EXPRESS_OPIS_PRZESYLKI = 'pp_global_express_opis_przesylki';
    //przesylka polecona
    const PP_PRZESYLKA_POLECONA_KATEGORIA = 'pp_przesylka_polecona_kategoria';
    const PP_PRZESYLKA_POLECONA_GABARYT = 'pp_przesylka_polecona_gabaryt';
    const PP_PRZESYLKA_POLECONA_FORMAT = 'pp_przesylka_polecona_format';
    const PP_PRZESYLKA_POLECONA_MASA = 'pp_przesylka_polecona_masa';
    const PP_PRZESYLKA_POLECONA_OPIS_PRZESYLKI = 'pp_przesylka_polecona_opis_przesylki';
    const PP_PRZESYLKA_POLECONA_ILOSC = 'pp_przesylka_polecona_ilosc';
    const PP_PRZESYLKA_POLECONA_NUMER_WEWNETRZNY = 'pp_przesylka_polecona_numer_wewnetrzny';
    const PP_PRZESYLKA_POLECONA_NUMER_WEWNETRZNY_TEXT = 'pp_przesylka_polecona_numer_wewnetrzny_text';
    const PP_PRZESYLKA_POLECONA_EGZEMPLARZ_BIBLIOTECZNY = 'pp_przesylka_polecona_egzemplarz_biblioteczny';
    const PP_PRZESYLKA_POLECONA_DLA_OCIEMNIALYCH = 'pp_przesylka_polecona_dla_ociemnialych';
    //przesylka firmowa
    const PP_PRZESYLKA_FIRMOWA_KATEGORIA = 'pp_przesylka_firmowa_kategoria';
    const PP_PRZESYLKA_FIRMOWA_GABARYT = 'pp_przesylka_firmowa_gabaryt';
    const PP_PRZESYLKA_FIRMOWA_MASA = 'pp_przesylka_firmowa_masa';
    const PP_PRZESYLKA_FIRMOWA_MIEJSCOWA_ZAMIEJSCOWA = 'pp_przesylka_firmowa_miejscowa_zamiejscowa';
    const PP_PRZESYLKA_FIRMOWA_MIASTO_WIES = 'pp_przesylka_firmowa_miasto_wies';
    const PP_PRZESYLKA_FIRMOWA_OPIS_PRZESYLKI = 'pp_przesylka_firmowa_opis_przesylki';
    const PP_PRZESYLKA_FIRMOWA_ILOSC = 'pp_przesylka_firmowa_ilosc';
    const PP_PRZESYLKA_FIRMOWA_NUMER_WEWNETRZNY = 'pp_przesylka_firmowa_numer_wewnetrzny';
    const PP_PRZESYLKA_FIRMOWA_NUMER_WEWNETRZNY_TEXT = 'pp_przesylka_numer_wewnetrzny_text';
    //paczka do ue
    const PP_PACZKA_UE_KATEGORIA = 'pp_paczka_ue_kategoria';
    const PP_PACZKA_UE_MASA = 'pp_paczka_ue_masa';
    const PP_PACZKA_UE_OPIS_PRZESYLKI = 'pp_paczka_ue_opis_przesylki';
    const PP_PACZKA_UE_DEKLARACJA_WARTOSCI = 'pp_paczka_ue_deklaracja_wartosci';
    const PP_PACZKA_UE_DEKLARACJA_WARTOSCI_ZL = 'pp_paczka_ue_wartosc_zl';
    const PP_PACZKA_UE_ILOSC = 'pp_paczka_ue_ilosc';
    const PP_PACZKA_UE_NUMER_WEWNETRZNY = 'pp_paczka_ue_numer_wewnetrzny';
    const PP_PACZKA_UE_NUMER_WEWNETRZNY_TEXT = 'pp_paczka_ue_numer_wewnetrzny_text';
    const PP_PACZKA_UE_ZWROT = 'pp_paczka_ue_zwrot';
    const PP_PACZKA_UE_SPOSOB_ZWROTU = 'pp_paczka_ue_sposob_zwrotu';
    const PP_PACZKA_UE_ILOSC_DNI = 'pp_paczka_ue_ilosc_dni';
    //zagraniczna przesylka
    const PP_ZAGRANICZNA_PRZESYLKA_OPIS_PRZESYLKI = 'pp_zagraniczna_przesylka_opis_przesylki';
    const PP_ZAGRANICZNA_PRZESYLKA_ILOSC = 'pp_zagraniczna_przesylka_ilosc';
    const PP_ZAGRANICZNA_PRZESYLKA_MASA = 'pp_zagraniczna_przesylka_masa';
    const PP_ZAGRANICZNA_PRZESYLKA_NUMER_WEWNETRZNY = 'pp_zagraniczna_przesylka_numer_wewnetrzny';
    const PP_ZAGRANICZNA_PRZESYLKA_NUMER_WEWNETRZNY_TEXT = 'pp_zagraniczna_przesylka_numer_wewnetrzny_text';
    //ems do ue
    const PP_EMS_UE_TYP_OPAKOWANIA = 'pp_ems_ue_typ_opakowania';
    const PP_EMS_UE_OPIS_PRZESYLKI = 'pp_ems_ue_opis_przesylki';
    const PP_EMS_UE_MASA = 'pp_ems_ue_masa';
    const PP_EMS_UE_POTWIERDZENIE_DORECZENIA = 'pp_ems_ue_potwierdzenie_doreczenia';
    const PP_EMS_UE_TYP_POTWIERDZENIA = 'pp_ems_ue_typ_potwierdzenia';
    const PP_EMS_UE_NR_TEL_POTWIERDZENIA = 'pp_ems_ue_nr_tel_potwierdzenia';
    const PP_EMS_UE_EMAIL_POTWIERDZENIA = 'pp_ems_ue_email_potwierdzenia';
    const PP_EMS_UE_NUMER_WEWNETRZNY = 'pp_ems_ue_numer_wewnetrzny';
    const PP_EMS_UE_NUMER_WEWNETRZNY_TEXT = 'pp_ems_ue_numer_wewnetrzny_text';
    const PP_EMS_UE_UBEZPIECZENIE = 'pp_ems_ue_ubezpieczenie';
    const PP_EMS_UE_WARTOSC_UBEZPIECZENIA = 'pp_ems_ue_wartosc_ubezpieczenia';
    const PP_EMS_UE_OKRESLONA_WARTOSC = 'pp_ems_ue_okreslona_wartosc';

    public $def = array();
    public $ppOrder = null;

    public function setValidationRules() {
        $arr = array();
        $arr['package'] = array('type' => self::TYPE_STRING, 'validate' => 'validatePackage', 'required' => true);
        $arr[$this->field('wartosc_zl')] = array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => 'isDeklaracjaWartosci');
        $arr[$this->field('wartosc_kg')] = array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => 'isDeklaracjaWartosci');
//        $arr[$this->field('numer_wewnetrzny_text')] = array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => 'isNumerWewnetrzny');
        $arr[$this->field('nr_tel_potwierdzenia')] = array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => 'isPotwirdzenieDoreczeniaSMS');
        $arr[$this->field('email_potwierdzenia')] = array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => 'isPotwirdzenieDoreczeniaEMAIL');
        $arr[$this->field('pokaz_mape')] = array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => 'isOdbiorWPunkcie');
        $arr[$this->field('kwota_pobrania_zl')] = array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => 'isPobranie');
        $arr[$this->field('numer_rachunku')] = array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => 'isPobranie');
        //$arr[$this->field('tytul_pobrania')] = array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => 'isPobranie');
        $arr[$this->field('wielopaczkowosc_ilosc')] = array('type' => self::TYPE_STRING, 'validate' => 'validateWielopaczkowosc', 'required' => 'isWielopaczkowosc');
        $arr[$this->field('ilosc')] = array('type' => self::TYPE_INT, 'validate' => 'isInt', 'size' => 1);
        $arr[$this->field('okreslona_wartosc')] = array('type' => self::TYPE_STRING, 'validate' => 'isString', 'required' => 'isOkreslonaWartosc');
        $arr[$this->field('masa')] = array('type' => self::TYPE_FLOAT, 'validate' => 'validateMasa', 'required' => 'isPaczkaPocztowa');
        $arr[$this->field('dla_ociemnialych')] = array('type' => self::TYPE_BOOL, 'validate' => 'validateDlaOciemnialych');
        $arr[$this->field('data_doreczenia')] = array('type' => self::TYPE_DATE, 'validate' => 'isString', 'required' => 'isDoreczenieWskazymDniu');
        $arr[$this->field('odleglosc')] = array('type' => self::TYPE_DATE, 'validate' => 'validateOdleglosc', 'required' => 'isDoreczenieWskazymDniu');
        unset($arr['']);
        $this->def['fields'] = $arr;
    }

    /**
     * Metoda zwraca nazwe pola wzgledem paczki
     */
    public function field($name) {
        try {
            $name = strtoupper($name);
            $package = strtoupper($this->package);
            $fieldConstant = constant('self::' . $package . '_' . $name);
            $fieldConstant = str_replace(strtolower($this->package) . '_', '', $fieldConstant);
            return $fieldConstant;
        }
        catch(Error $e) {
            return '';
        }

    }

    public function __construct($package, $ppOrder) {
        $this->package = $package;
        $this->ppOrder = $ppOrder;
        $this->address = $ppOrder->getOrderAddress();
        $this->customer = $ppOrder->getOrderCustomer();
        $this->shipment = ENadawca::Shipment();
        $this->setValidationRules();
    }

    /**
     * Metoda zwraca pola paczki razem z wrtościami
     */
    public static function getValues($package, $values) {
        $arr = array();
        foreach ($values as $k => $v) {
            if (strpos($k, $package) !== false) {
                $arr[str_replace($package . "_", "", $k)] = $v;
            }
        }
        return $arr;
    }

    /**
     * Metoda ładuj wartosci pol paczki
     */
    public function loadFromArray($values) {
        foreach ($values as $k => $v) {
            $this->$k = $v;
            $methodName = 'get' . ucfirst(Tools::toCamelCase($k));
            if (method_exists($this, $methodName)) {
                $this->$k = $this->$methodName();
            }
        }
    }

    /**
     * Metoda zwraca adres do przesylki
     */
    public function getAddress() {
        $adress = new Adres();
        $adress->nazwa = $this->address->firstname.' '.$this->address->lastname;
        $adress->nazwa2 = $this->address->company;
        $adress->ulica = $this->address->address1;
        $adress->numerDomu = $this->address->address2;
        $adress->miejscowosc = $this->address->city;
        $adress->kodPocztowy = $this->address->postcode;
        $adress->kraj = PPSetting::safeString($this->address->country);
        $adress->telefon = PPSetting::onlyNumbers($this->address->phone);
        $adress->mobile = (!empty($this->address->phone_mobile)?$this->address->phone_mobile:PPSetting::onlyNumbers($this->address->phone));
        $adress->nip = $this->address->vat_number;
        $adress->email = $this->customer->email;
        return $adress;
    }

    /**
     * Zwraca potwierdzenie doreczenia
     */
    public function getPotwierdzenieDoreczenia() {
        $result = null;
        if ($this->isPotwirdzenieDoreczenia()) {
            $result = new PotwierdzenieDoreczenia();
            $result->sposob = $this->typ_potwierdzenia;
            if ($this->isPotwirdzenieDoreczenia()) {
                $result->kontakt = $this->getPotwirdzenieDoreczenia();
            }
        }
        return $result;
    }

    /**
     * Metoda zwraca informacje czy paczka posiada wypelnione pole ilosc potwierdzen
     */
    public function isIloscPotwierdzen() {
        return !empty($this->ilosc);
    }

    /**
     * Metoda zwraca wartosc pola ilosc
     */
    public function getIlosc() {
        if ($this->ilosc == '') {
            return 0;
        }
        return $this->ilosc;
    }

    /**
     * Metoda zwraca wartosc pola masa
     */
    public function getMasa($g = false) {
        if ($this->masa == '') {
            return 0;
        }
        $this->masa = str_replace(',','.',$this->masa);
        if ($g) {
            return $this->masa * 1000;
        }
        return $this->masa;
    }

    /**
     * Metoda zwraca informacje czy paczka t paczka pocztowa
     */
    public function isPaczkaPocztowa() {
        return $this->package == 'pp_paczka_pocztowa';
    }

    /**
     * Metoda walidująca czy dla przesyłek zagranicznych jest okreslonony prawidlowy kraj
     */
    public function validatePackage() {
        if (in_array($this->package, $this->przesylkiZagraniczne) && PPSetting::safeString($this->address->country) == 'Polska') {
            return Translate::getAdminTranslation('Krajem dla przesyłki zagranicznej nie może być Polska ');
        }
        return true;
    }

    /**
     * Metoda walidujaca pole masa
     */
    public function validateMasa($field, $value) {
        if ($this->isPaczkaPocztowa()) {
            if ((float) $value < 0.001) {
                return sprintf(Translate::getAdminTranslation('%s nie może być mniejsza od 0.001 kg'), $this->displayFieldName($field, get_class($this)));
            }
        } else {
            if (!empty($value)) {
                if (!ValidateCore::isFloat($value)) {
                    return sprintf(Translate::getAdminTranslation('The %s field is invalid.'), $this->displayFieldName($field, get_class($this)));
                }
            }
        }
        return true;
    }

    /**
     * Metoda walidujaca czy w formularzy dodawania paczki wybrano
     * oznaczenie egzemplarza bibliotecznego i dla ociemniałych jednocześnie
     */
    public function validateDlaOciemnialych() {
        if ($this->egzemplarz_biblioteczny && $this->dla_ociemnialych) {
            return Translate::getAdminTranslation('Oznaczenie egzemplarza bibliotecznego i dla ociemniałych jednocześnie nie jest możliwe');
        }
        return true;
    }

    /**
     * Metoda walidujaca czy w formularzy dodawania paczki wybrano
     * odbiór w punkcie i wielopaczkowoscs jednocześnie
     */
    public function validateWielopaczkowosc() {
        if ($this->isWielopaczkowosc() && $this->isOdbiorWPunkcie() && $this->package != 'pp_pocztex_2021_kurier') {
            return Translate::getAdminTranslation('Odbiór w punkcie i Wielopaczkowość jednocześnie nie jest możliwe');
        }
        return true;
    }

    public function validateOdleglosc(){
        if($this->obszar == 'MIASTO' && ((int)$this->odleglosc <= 0 || (int)$this->odleglosc > 50)){
            return Translate::getAdminTranslation('Odległość odległość powinna mieć wartość od 1km do 50km');
        }
        return true;
    }

    /**
     * Metoda dodawania paczki do ENadawcy
     */
    public function save() {
        $method_name = 'save' . Tools::toCamelCase($this->package);
        if (method_exists($this, $method_name)) {
            $this->{'save' . Tools::toCamelCase($this->package)}();
            $office = PPPostOffice::getDefaultOffice();
            $buffors = PPOrderSet::getActiveCollection();
            $buffor = $buffors->getFirst();
            if (!is_object($buffor)) {
                $buffor = PPOrderSet::createDefault($office);
            }
            if (is_object($buffor)) {
                $result = $this->shipment->add($buffor->id_en);
                if ($this->shipment->hasErrors()) {
                    $this->errors = $this->shipment->getErrors();
                    return false;
                }
                return $result;
            } else {
                $this->errors[] = Translate::getAdminTranslation('Bufor nie istnieje');
                return false;
            }
        } else {
            return false;
        }
    }

    /**
     * Metoda odpowiadająca za waliadowanie pól
     */
    public function validateFields() {
        $errors = array();
        foreach ($this->def['fields'] as $field => $data) {
            $message = $this->validateField($field, $this->$field);
            if ($message !== true) {
                if (is_array($message)) {
                    foreach ($message as $m) {
                        $errors[] = $m;
                    }
                } else {
                    $errors[] = $message;
                }
            }
        }
        return $errors;
    }

    /**
     * Metoda zwraca obiekt z iformacjami o odbiorze przesylki
     */
    public function getOdbiorPrzesylkiOdNadawcy() {
        $odbior = null;
        $odbior = new OdbiorPrzesylkiOdNadawcy();
        if ($this->odbior_przesyki_sobota) {
            $odbior->wSobote = $this->odbior_przesyki_sobota;
        }
        $odbior->wNiedzieleLubSwieto = $this->odbior_w_niedziele_swieto;
        $odbior->wGodzinachOd20Do7 = $this->odbior_w_20_7;
        return $odbior;
    }

    public function getZwrotDokumentowBiznes() {
        $dokumenty = null;
        if ($this->dokumenty_zwrotne) {
            $dokumenty = new zwrotDokumentowBiznesowaType();
            $dokumenty->rodzaj = $this->dokumenty_rodzaj_potwierdzenia;
            $dokumenty->idDokumentyZwrotneAdresy = $this->wyslane_do ;
        }
        return $dokumenty;
    }

    public function getZwrotDokumentowKurierska() {
        $dokumenty = null;
        if ($this->dokumenty_zwrotne) {
            $dokumenty = new ZwrotDokumentowKurierska();
            if(stripos($this->dokumenty_rodzaj_potwierdzenia,'list') !==false){
                $list = new rodzajListType();
                $list->polecony = (stripos($this->dokumenty_rodzaj_potwierdzenia,'polecony') !== false?1:0);
                $list->kategoria = (stripos($this->dokumenty_rodzaj_potwierdzenia,'ekonomiczny') !== false?'EKONOMICZNA':'PRIORYTETOWA');
                $dokumenty->rodzajList = $list;
                unset($dokumenty->rodzajPocztex);
                unset($dokumenty->rodzajPaczka);
            }else if(stripos($this->dokumenty_rodzaj_potwierdzenia,'paczka') !== false){
                $dokumenty->rodzajPaczka = $this->dokumenty_rodzaj_potwierdzenia;
                unset($dokumenty->rodzajPocztex);
                unset($dokumenty->rodzajList);
            } else  {
                $dokumenty->rodzajPocztex = $this->dokumenty_rodzaj_potwierdzenia;
                unset($dokumenty->rodzajPaczka);
                unset($dokumenty->rodzajList);
            }
            return $dokumenty;
        }


        return $dokumenty;
    }

    /**
     * Metoda zwraca obiekt doreczenia
     */
    public function getDoreczenie() {
        $doreczenie = new DoreczenieUslugaKurierska();
        if ($this->godzina_doreczenia) {
            $doreczenie->oczekiwanaGodzinaDoreczenia = $this->godzina;

        }
        if ($this->doreczenie_we_wskazanym_dniu) {
            $doreczenie->oczekiwanyTerminDoreczenia = $this->data_doreczenia;
        }
        $doreczenie->doRakWlasnych = $this->doreczenie_do_rak;
        $doreczenie->wSobote = $this->doreczenie_przesylki_sobota;
        $doreczenie->wGodzinachOd20Do7 = $this->doreczenie_w_20_7;
        $doreczenie->wNiedzieleLubSwieto = $this->doreczenie_w_niedziele_swieto;
        $doreczenie->w90Minut = $this->doreczenie_w_90_minut;
        return $doreczenie;
    }

    /**
     * Metoda zwraca obiekt doreczenia
     */
    public function getDoreczenieBiznes() {
        $doreczenie = null;
        if(!empty($this->doreczenie_do_rak)) {
            $doreczenie = new doreczenieBiznesowaType();
            $doreczenie->doRakWlasnych = $this->doreczenie_do_rak;
        }


        return $doreczenie;
    }

    /**
     * Metoda zwraca czy paczka jest na zasadach specjalnych
     */
    public function getZasadySpecjalne() {
        $result = '';
        if ($this->na_specjalnych_zasadach) {
            $result = $this->na_specjalnych_zasadach_wartosci;
        }
        return $result;
    }

    /**
     * Metoda walidujaca pojedyncze pole paczki
     */
    public function validateField($field, $value, $id_lang = null, $skip = array(), $human_errors = true) {
        static $ps_lang_default = null;
        static $ps_allow_html_iframe = null;

        if ($ps_lang_default === null) {
            $ps_lang_default = Configuration::get('PS_LANG_DEFAULT');
        }

        if ($ps_allow_html_iframe === null) {
            $ps_allow_html_iframe = (int) Configuration::get('PS_ALLOW_HTML_IFRAME');
        }


        //$this->cacheFieldsRequiredDatabase();
        $data = $this->def['fields'][$field];

        // Check if field is required
        if (!$id_lang || $id_lang == $ps_lang_default) {
            if (!in_array('required', $skip) && (!empty($data['required']))) {
                if (Tools::isEmpty($value)) {
                    if (!is_bool($data['required']) && method_exists($this, $data['required'])) {
                        if (call_user_func(array($this, $data['required']), $field, $value)) {
                            return sprintf(Translate::getAdminTranslation('The %s field is required.'), $this->displayFieldName($field, get_class($this)));
                        }
                    } else {
                        if ($human_errors) {
                            return sprintf(Translate::getAdminTranslation('The %s field is required.'), $this->displayFieldName($field, get_class($this)));
                        } else {
                            return 'Property ' . get_class($this) . '->' . $field . ' is empty';
                        }
                    }
                }
            }
        }

        // Default value
        if (!$value && !empty($data['default'])) {
            $value = $data['default'];
            $this->$field = $value;
        }

        // Check field values
        if (!in_array('values', $skip) && !empty($data['values']) && is_array($data['values']) && !in_array($value, $data['values'])) {
            return 'Property ' . get_class($this) . '->' . $field . ' has bad value (allowed values are: ' . implode(', ', $data['values']) . ')';
        }

        // Check field size
        if (!in_array('size', $skip) && !empty($data['size'])) {
            $size = $data['size'];
            if (!is_array($data['size'])) {
                $size = array('min' => 0, 'max' => $data['size']);
            }

            $length = Tools::strlen($value);
            if ($length < $size['min'] || $length > $size['max']) {
                if ($human_errors) {
                    if (isset($data['lang']) && $data['lang']) {
                        $language = new Language((int) $id_lang);
                        return sprintf(Translate::getAdminTranslation('The field %1$s (%2$s) is too long (%3$d chars max, html chars including).'), $this->displayFieldName($field, get_class($this)), $language->name, $size['max']);
                    } else {
                        return sprintf(Translate::getAdminTranslation('The %1$s field is too long (%2$d chars max).'), $this->displayFieldName($field, get_class($this)), $size['max']);
                    }
                } else {
                    return 'Property ' . get_class($this) . '->' . $field . ' length (' . $length . ') must be between ' . $size['min'] . ' and ' . $size['max'];
                }
            }
        }

        // Check field validator
        if (!in_array('validate', $skip) && !empty($data['validate'])) {

            if (!method_exists('Validate', $data['validate']) && !method_exists($this, $data['validate'])) {
                throw new PrestaShopException('Validation function not found. ' . $data['validate']);
            }

            if (!empty($value) || $value == 0) {
                $res = true;
                if (Tools::strtolower($data['validate']) == 'iscleanhtml') {
                    if (!call_user_func(array('Validate', $data['validate']), $value, $ps_allow_html_iframe)) {
                        $res = false;
                    }
                } else {
                    if (method_exists($this, $data['validate'])) {

                        return call_user_func(array($this, $data['validate']), $field, $value);
                    } else if (!call_user_func(array('Validate', $data['validate']), $value)) {
                        $res = false;
                    }
                }
                if (!$res) {
                    if ($human_errors) {
                        return sprintf(Translate::getAdminTranslation('The %s field is invalid.'), $this->displayFieldName($field, get_class($this)));
                    } else {
                        return 'Property ' . get_class($this) . '->' . $field . ' is not valid';
                    }
                }
            }
        }

        return true;
    }

    public function getNumerWewnetrzny() {
        if ($this->isNumerWewnetrzny()) {
            return $this->numer_wewnetrzny_text;
        }
        return '';
    }

    /**
     * Metoda zwraca obiekt zawierajacy informacja o zasadach zwrotu paczki
     */
    public function getZwrotDni() {
        $zwrot = new Zwrot();
        if (!empty($this->zwrot)) {
            //$zwrot->zwrotPoLiczbieDni = 15;
            if ($this->zwrot == 'zwrot_po_liczbie_dni') {
                $zwrot->zwrotPoLiczbieDni = $this->ilosc_dni;
                $zwrot->sposobZwrotu = $this->sposob_zwrotu;
            } else if ($this->zwrot == 'traktowac_jak_porzucona') {
                $zwrot->traktowacJakPorzucona = true;
            } else {
                $zwrot->zwrotPoLiczbieDni = 0;
                $zwrot->sposobZwrotu = $this->sposob_zwrotu;
            }
        }
        return $zwrot;
    }

    /**
     * Metoda zwraca obiekt zawierajacy informacja o warunkach pobrania
     */
    public function getPobranie() {
        $pobranie = null;
        if ($this->isPobranie()) {
            $order = new Order($this->ppOrder->id_order);
            $patterns = array('/\{id_order\}/', '/\{reference\}/');
            $replacements = array($order->id, $order->reference);
            $tytul_pobrania = preg_replace($patterns, $replacements, $this->tytul_pobrania);
            $pobranie = new Pobranie();
            $pobranie->sposobPobrania = Pobranie::SPOSOB_POBRANIA_RACHUNEK_BANKOWY;
            $pobranie->kwotaPobrania = round((float)$this->kwota_pobrania_zl*100);
            $pobranie->nrb = $this->numer_rachunku;
            $pobranie->tytulem = $tytul_pobrania;
            $pobranie->sprawdzenieZawartosciPrzesylkiPrzezOdbiorce = $this->odbiorca;
        }
        return $pobranie;
    }

    public function isNumerWewnetrzny() {
        return $this->numer_wewnetrzny;
    }

    /**
     * Metoda zwraca inforamcje czy jest wybrany odbior w punkcie
     */
    public function isOdbiorWPunkcie() {
        return $this->odbior_w_punkcie;
    }

    /**
     * Metoda zwraca punkt odbioru
     */
    public function getOdbiorWPunkcie() {
        $result = null;
        if ($this->isOdbiorWPunkcie()) {
            $placowka = new PlacowkaPocztowa();
            $placowka->id = $this->pni;
            $result = $placowka;
        }
        return $result;
    }


    public function getPocztex2021punktNadania(){
        if($this->nadanie_u_kuriera){
            return null;
        }

        $office = PPPostOffice::getDefaultOffice();
        $buffors = PPOrderSet::getActiveCollection();
        $buffor = $buffors->getFirst();
        if (!is_object($buffor)) {
            $buffor = PPOrderSet::createDefault($office);
        }

        if (is_object($buffor)) {
            $packages = ENadawca::EnvelopeBuffor()->getList();
            if(count($packages)){
                foreach($packages as $pack){
                    if($pack['idBufor'] == $buffor->id_en){
                        $punktNadania = new placowkaPocztowaType();
                        $punktNadania->id = $pack['urzadNadania'];
                        return $punktNadania;
                    }
                }
            }
        }
        return null;
    }

    /**
     * Metoda zwraca wartosc przy wybraniu opcji deklaracja wartosci
     */
    public function getDeklaracjaWartosciWartosc() {
        $result = '';
        if ($this->isDeklaracjaWartosci()) {
            $result = $this->wartosc_zl*100;
        }
        return $result;
    }

    public function getIloscForWielopaczkowosc(){
        $result = 0;
        if($this->isWielopaczkowosc()){
            $result = $this->wielopaczkowosc_ilosc;
        }
        return $result;
    }

    /**
     * Metoda zwraca mase przy wybraniu opcji deklaracja wartosci
     */
    public function getDeklaracjaWartosciMasa() {
        $result = '';
        if ($this->isDeklaracjaWartosci()) {
            $result = $this->wartosc_kg * 1000;
        }
        return $result;
    }

    /**
     * Czy jest deklaracja wartosc
     */
    public function isDeklaracjaWartosci() {
        return $this->deklaracja_wartosci;
    }

    /**
     * Czy jest wielopaczkowosc
     */
    public function isWielopaczkowosc() {
        return $this->wielopaczkowosc;
    }

    /**
     * Czy jest ubezpieczenie
     */
    public function isUbezpieczenie() {
        return $this->ubezpieczenie;
    }

    /**
     * Metoda zwaraca wrotosc ubezpieczenia
     */
    public function getUbezpieczenie() {
        $ubezpiecznie = null;
        if ($this->isUbezpieczenie()) {
            $ubezpiecznie = new Ubezpieczenie();
            $ubezpiecznie->rodzaj = Ubezpieczenie::RODZAJ_STANDARD;
            if ($this->isOkreslonaWartosc()) {
                $ubezpiecznie->kwota = $this->okreslona_wartosc*100;
            } else {
                $ubezpiecznie->kwota = (int)$this->wartosc_ubezpieczenia*100;
            }
        }
        return $ubezpiecznie;
    }

    /**
     * Metoda zwraca informacja czy w ubezpieczeniu jest wybrana ocja okreslona wartosc
     */
    public function isOkreslonaWartosc() {
        return $this->wartosc_ubezpieczenia == 'okreslona_wartosc';
    }

    /**
     * Metoda zwraca informacja czy jest pobranie
     */
    public function isPobranie() {
        return $this->rodzaj == 'pobranie' || $this->pobranie == true;
    }

    /**
     * Metoda zwraca obiekt potwierdzenia odbioru
     */
    public function getPotwirdzenieOdbioru() {
        $potwierdzenie = null;
        if ($this->isPotwierdzenieOdbioru()) {
            $potwierdzenie = new PotwierdzenieOdbioru();
            $potwierdzenie->sposob = $this->rodzaj_potwierdzenia;
            $potwierdzenie->ilosc = $this->potwierdzenie_ile;
        }
        return $potwierdzenie;
    }

    public function getZawartoscPrzesylki(){
        $zawartosc = null;
        if($this->typ_zawartosci){
            $zawartosc = new zawartoscPocztex2021Type;

            if($this->typ_zawartosci == 'INNE' && $this->typ_zawartosci_inne){
                $zawartosc->zawartoscInna = $this->typ_zawartosci_inne;
            }
            elseif($this->typ_zawartosci == 'INNE'){
                $zawartosc = null;
            }
            else{
                $zawartosc->zawartoscSpecjalna = $this->typ_zawartosci;
            }
        }

        return $zawartosc;
    }

    /**
     * Metoda sprawdza czy jest potwierdzenie odbioru
     */
    public function isPotwierdzenieOdbioru() {
        return $this->potwierdzenie_odbioru;
    }

    /**
     * Metoda sprawdza czy jest potwierdzenie doreczenia
     */
    public function isPotwirdzenieDoreczenia($type = '') {
        if (empty($type)) {
            return $this->potwierdzenie_doreczenia;
        } else {

            if ($type == 'SMS' && $this->typ_potwierdzenia == 'SMS') {
                return empty($this->nr_tel_potwierdzenia);
            }
            if ($type =='EMAIL' && $this->typ_potwierdzenia == 'EMAIL'){
                return empty($this->email_potwierdzenia);
            }
            return false;
        }
    }

    /**
     * Metoda sprawdza czy jest doreczenie we wskazanym dniu
     */
    public function isDoreczenieWskazymDniu() {
        return $this->doreczenie_we_wskazanym_dniu;
    }

    /**
     * Metoda sprawdza czy jest potwierdzenie doreczenia sms
     */
    public function isPotwirdzenieDoreczeniaSMS() {
        return $this->isPotwirdzenieDoreczenia() && $this->isPotwirdzenieDoreczenia('SMS');
    }

    /**
     * Metoda sprawdza czy jest potwierdzenie doreczenia email
     */
    public function isPotwirdzenieDoreczeniaEMAIL() {
        return $this->isPotwirdzenieDoreczenia() && $this->isPotwirdzenieDoreczenia('EMAIL');
    }

    /**
     * Metoda zwraca potwierdzenie doreczenia
     */
    public function getPotwirdzenieDoreczenia() {
        $type = $this->typ_potwierdzenia;
        if (empty($type)) {
            return '';
        } else {
            if ($type == 'SMS') {
                return $this->nr_tel_potwierdzenia;
            } else {
                return $this->email_potwierdzenia;
            }
        }
    }

    public function getPocztexPotwierdzenieDoreczenia(){
        $potwierdzenie = null;
        if($this->potwierdzenie_doreczenia && $this->potwierdzenie_doreczenia_type){
            $potwierdzenie = new potwierdzenieEDoreczeniaType;
            $potwierdzenie->sposob = $this->potwierdzenie_doreczenia_type;
            $potwierdzenie->kontakt = $this->potwierdzenie_doreczenia_kontakt;
        }
        return $potwierdzenie;
    }

    /**
     * Metoda wyswietla nazwe pola w komunikacie walidacyjnym
     */
    public function displayFieldName($field, $class = __CLASS__, $htmlentities = true, Context $context = null) {
        global $_FIELDS;

        if (!isset($context)) {
            $context = Context::getContext();
        }

        if ($_FIELDS === null && file_exists(_PS_TRANSLATIONS_DIR_ . $context->language->iso_code . '/fields.php')) {
            include_once(_PS_TRANSLATIONS_DIR_ . $context->language->iso_code . '/fields.php');
        }
        if ($field == 'package') {
            $key = $class . '_' . md5($field);
        } else {
            $key = $class . '_' . md5($this->package . "_" . $field);
        }
        return ((is_array($_FIELDS) && array_key_exists($key, $_FIELDS)) ? ($htmlentities ? htmlentities($_FIELDS[$key], ENT_QUOTES, 'utf-8') : $_FIELDS[$key]) : $key);
    }

    /**
     * Metoda dodaje paczke pocztowa do EN
     */
    public function saveppPaczkaPocztowa() {
        $this->shipment->addPaczkaPocztowa(
            $this->getAddress(), $this->kategoria, $this->gabaryt, $this->getMasa(true), $this->getDeklaracjaWartosciWartosc(), false, false, $this->potwierdzenie_ile, $this->egzemplarz_biblioteczny, $this->dla_ociemnialych, $this->opis_przesylki
        );
    }

    /**
     * Metoda dodaje przesyłke biznesowa do EN
     */
    public function saveppPocztex_48() {
        $this->shipment->addPrzesylkaBiznesowa(
            $this->getAddress(),
            $this->gabaryt,
            $this->opis_przesylki,
            $this->getPobranie(),
            $this->getUbezpieczenie(),
            $this->getOdbiorWPunkcie(),
            $this->getDeklaracjaWartosciMasa(),
            $this->getDeklaracjaWartosciWartosc(),
            $this->ostroznie,
            $this->getIloscForWielopaczkowosc(),
            $this->niestandardowa,
            $this->getPotwirdzenieOdbioru(),
            $this->getDoreczenieBiznes(),
            $this->getZwrotDokumentowBiznes(),
            $this->odbiorca
        );
    }

    /**
     * Metoda dodaje przesyłke biznesowa do EN - PrestaShop 1.7
     */
    public function saveppPocztex48() {
        $this->shipment->addPrzesylkaBiznesowa(
            $this->getAddress(),
            $this->gabaryt,
            $this->opis_przesylki,
            $this->getPobranie(),
            $this->getUbezpieczenie(),
            $this->getOdbiorWPunkcie(),
            $this->getDeklaracjaWartosciMasa(),
            $this->getDeklaracjaWartosciWartosc(),
            $this->ostroznie,
            $this->getIloscForWielopaczkowosc(),
            $this->niestandardowa,
            $this->getPotwirdzenieOdbioru(),
            $this->getDoreczenieBiznes(),
            $this->getZwrotDokumentowBiznes(),
            $this->odbiorca
        );
    }

    public function saveppPocztex_2021Kurier(){
        $this->saveppPocztex2021Kurier();
    }

    public function saveppPocztex2021Kurier(){

        $this->shipment->addPocztex2021Kurier(
            $this->getAddress(),
            $this->format,
            $this->getPobranie(),
            ($this->masa * 1000),
            $this->getDeklaracjaWartosciWartosc(),
            $this->odbiorca,
            $this->opis_przesylki,
            $this->ostroznie,
            $this->koperta_pocztex,
            $this->odbior_sobota,
            $this->godzina_doreczenia,
            $this->ponadgabaryt,
            $this->getZawartoscPrzesylki(),
            $this->getOdbiorWPunkcie(),
            $this->getUbezpieczenie(),
            $this->getIloscForWielopaczkowosc(),
            $this->dzien,
            $this->getPocztexPotwierdzenieDoreczenia(),
            $this->getPocztex2021punktNadania()
        );
    }

    public function saveppPocztex_2021Dzis(){
        $this->saveppPocztex2021Dzis();
    }

    public function saveppPocztex2021Dzis(){
        $this->shipment->addPocztex2021Dzis(
            $this->getAddress(),
            $this->format,
            $this->getPobranie(),
            ($this->masa * 1000),
            $this->getDeklaracjaWartosciWartosc(),
            $this->odbiorca,
            $this->opis_przesylki,
            $this->ostroznie,
            $this->odbior_sobota,
            $this->getZawartoscPrzesylki(),
            $this->getUbezpieczenie(),
            $this->getIloscForWielopaczkowosc(),
            $this->odleglosc,
            $this->obszar,
            $this->getPocztexPotwierdzenieDoreczenia()
        );
    }

    /**
     * Metoda dodaje przesyłke kurierska do EN
     */
    public function saveppPocztex() {
        $this->shipment->addUslugaKurierska(
            $this->getAddress(), $this->serwis, $this->opis_przesylki, $this->zawartosc, $this->getMasa(true), $this->ostroznie, $this->niestandardowa, $this->sprawdzenie_zawartosci, $this->getOdbiorWPunkcie(), $this->oplata, $this->getDoreczenie(), $this->getPobranie(), $this->getDeklaracjaWartosciWartosc(), $this->getUbezpieczenie(), $this->getPotwirdzenieOdbioru(), $this->getPotwierdzenieDoreczenia(), $this->getOdbiorPrzesylkiOdNadawcy(), $this->getZasadySpecjalne(), $this->getIloscForWielopaczkowosc(),$this->getZwrotDokumentowKurierska(),$this->odleglosc
        );
    }

    /**
     * Metoda dodaje przesyłke global express do EN
     */
    public function saveppGlobalExpress() {
        $this->shipment->addGlobalExpres(
            $this->getAddress(), $this->getMasa(true), $this->zawartosc, $this->getNumerWewnetrzny(), $this->getPotwierdzenieDoreczenia(), $this->opis_przesylki
        );
    }

    /**
     * Metoda dodaje przesyłke polecona do EN
     */
    public function saveppPrzesylkaPolecona() {
        $this->shipment->addPrzesylkaPoleconaKrajowa(
            $this->getAddress(), $this->kategoria, $this->format, $this->getMasa(true), $this->miasto_wies, $this->miejscowa_zamiejscowa, $this->ilosc, $this->getNumerWewnetrzny(), $this->dla_ociemnialych, $this->egzemplarz_biblioteczny,$this->opis_przesylki
        );
    }

    /**
     * Metoda dodaje przesyłke firmowa do EN
     */
    public function saveppPrzesylkaFirmowa() {
        $this->shipment->addPrzesylkaPoleconaFirmowa(
            $this->getAddress(), $this->opis_przesylki,$this->kategoria, $this->gabaryt,$this->getMasa(true), $this->miejscowa_zamiejscowa, $this->ilosc, $this->getNumerWewnetrzny()
        );
    }

    /**
     * Metoda dodaje przesyłke zagraniczną do EN
     */
    public function saveppPaczkaUe() {
        $this->shipment->addPaczkaZagraniczna(
            $this->getAddress(), $this->getMasa(true), $this->opis_przesylki, $this->kategoria, $this->getDeklaracjaWartosciWartosc(), $this->ilosc, $this->getZwrotDni()
        );
    }

    /**
     * Metoda dodaje przesyłke polecona zagraniczną do EN
     */
    public function saveppZagranicznaPrzesylka() {
        $this->shipment->addPrzesylkaPoleconaZagraniczna(
            $this->getAddress(), $this->opis_przesylki, $this->getMasa(true), $this->ilosc
        );
    }

    /**
     * Metoda dodaje przesyłke EMS do EN
     */
    public function saveppEmsUe() {
        $this->shipment->addEMS(
            $this->getAddress(), $this->getMasa(true), $this->opis_przesylki, $this->typ_opakowania, $this->getUbezpieczenie(), $this->getPotwierdzenieDoreczenia()
        );
    }

    public function __get($name) {
        $methodName = 'get' . ucfirst(Tools::toCamelCase($name));
        if (method_exists($this, $methodName)) {
            return $this->$methodName();
        }
        if (!isset($this->$name)) {
            return '';
        }
        return $this->$name;
    }

}
