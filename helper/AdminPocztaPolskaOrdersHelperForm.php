<?php

/**
 * Klasa odpowiedzialna za generowanie formularza pakowania przesyłki
 */
class AdminPocztaPolskaOrdersHelperForm extends HelperForm {

    public function __construct() {
        parent::__construct();
        $this->show_toolbar = false;
        $this->module = Module::getInstanceByName('pocztapolskaen');
        $this->default_form_language = Context::getContext()->language->id;
        $this->tpl_vars = array(
            'fields_value' => PPSetting::getDefaultValues(),
            'active_tab'   => '',
        );
    }

    /**
     * Metoda odpowiedzialna za wygenerowanie formularza
     */
    public function generateForm($fields_form = array()) {
        if (empty($fields_form)) {
            $this->fields_form = $this->getFormFields();
        }
        return $this->generate();
    }

    /**
     * Metoda odpowiedzialna za przygotowanie pol formularza
     */
    public function getFormFields() {
            $fields_form[]['form'] = array(
                'panelClass' => 'col-lg-12',
                'input' => array(
                    array(
                        'type' => 'select',
                        'label' => $this->l('Wybierz usługę'),
                        'name' => 'pp_packages',
                        'options' => array(
                            'query' => PocztaPolskaEn::getPPPackages(),
                            'id' => 'id',
                            'name' => 'name',
                            'default' => array(
                                'label' => $this->l('Wybierz przesyłkę'),
                                'value' => '',
                            ),
                        ),
                        'onchange' => 'change(this.value);',
                        'form_group_class' => 'services_packages'
                    ),
                )
            );
            $fields_form[]['form'] = array(
                'legend' => array(
                    'title' => '<b>' . $this->l('ATRYBUTY') . '</b><hr>',
                ),
                'panelClass' => 'toggle_panel pp_pocztex_48 col-lg-6',
                'input' => array(
                    array(
                        'type' => 'select',
                        'label' => $this->l('Gabaryt'),
                        'name' => PPPackage::PP_POCZTEX_48_GABARYT,
                        'options' => array(
                            'query' => PocztaPolskaEn::getSizes(),
                            'id' => 'id',
                            'name' => 'name',
                        ),
                        'form_group_class' => 'pp_pocztex_48',
                    ),
                    array(
                        'type' => 'textarea',
                        'name' => PPPackage::PP_POCZTEX_48_OPIS_PRZESYLKI,
                        'label' => $this->l('Opis przesyłki'),
                        'form_group_class' => 'pp_pocztex_48',
                        'class' => 'fixed-width-xxl',
                        'maxlength' => 500
                    ),
                )
            );
            $fields_form[]['form'] = array(
                'legend' => array(
                    'title' => '<b>' . $this->l('OPCJE USŁUGI') . '</b><hr>',
                ),
                'panelClass' => 'toggle_panel pp_pocztex_48 col-lg-6',
                'input' => array(
                    /*array(
                        'type' => 'switch',
                        'label' => $this->l('Odbiór w punkcie'),
                        'name' => PPPackage::PP_POCZTEX_48_ODBIOR_W_PUNKCIE,
                        'values' => array(
                            array(
                                'id' => PPPackage::PP_POCZTEX_48_ODBIOR_W_PUNKCIE . '_on',
                                'value' => 1
                            ),
                            array(
                                'id' => PPPackage::PP_POCZTEX_48_ODBIOR_W_PUNKCIE . '_off',
                                'value' => 0
                            )
                        ),
                        'form_group_class' => 'pp_pocztex_48 toggle_rows',
                    ),*/
                    array(
                        'type' => 'select',
                        'label' => $this->l('Odbiór'),
                        'name' => PPPackage::PP_POCZTEX_48_ODBIOR_W_PUNKCIE,
                        'options' => array(
                            'query' => PocztaPolskaEn::getOdbiorType(),
                            'id' => 'id',
                            'name' => 'name',
                        ),
                        'form_group_class' => 'pp_pocztex_48 toggle_combo',
                    ),
                    array(
                        'type' => 'text',
                        'name' => PPPackage::PP_POCZTEX_48_POKAZ_MAPE,
                        'readonly' => true,
                        'class' => 'fixed-width-xxl',
                        'label' => '<button type="button" onclick="PPWidgetApp.toggleMap(ppPack.selectPickup,$(\'#'.PPPackage::PP_POCZTEX_48_POBRANIE.'_on\').is(\':checked\'),ppPack.currentOrder.address, ppPack.types[$(\'#'.PPPackage::PP_POCZTEX_48_ODBIOR_W_PUNKCIE.'\').val()]);return false;" class="btn btn-default">' . $this->l('Pokaż mape') . '</button>',
                        'form_group_class' => 'pp_pocztex_48 toggle_combo ' . PPPackage::PP_POCZTEX_48_ODBIOR_W_PUNKCIE . ' 1 2',
                    ),
                    array(
                        'type' => 'hidden',
                        'name' => PPPackage::PP_POCZTEX_48_PNI,
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Wielopaczkowość'),
                        'name' => PPPackage::PP_POCZTEX_48_WIELOPACZKOWOSC,
                        //'disabled'=>(version_compare(PHP_VERSION, '7.0.0', '<')?false:true),
                        'values' => array(
                            array(
                                'id' => PPPackage::PP_POCZTEX_48_WIELOPACZKOWOSC . '_on',
                                'value' => 1
                            ),
                            array(
                                'id' => PPPackage::PP_POCZTEX_48_WIELOPACZKOWOSC . '_off',
                                'value' => 0
                            )
                        ),
                        'form_group_class' => 'pp_pocztex_48 toggle_rows '.PPPackage::PP_POCZTEX_48_ODBIOR_W_PUNKCIE . ' 0 1',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Ilość'),
                        'class' => 'fixed-width-xxl',
                        'name' => PPPackage::PP_POCZTEX_48_WIELOPACZKOWOSC_ILOSC,
                        'form_group_class' => 'pp_pocztex_48 ' . PPPackage::PP_POCZTEX_48_WIELOPACZKOWOSC . ' 1',
                        'suffix' => $this->l('szt.'),
                    )
                )
            );
            $fields_form[]['form'] = array(
                'legend' => array(
                    'title' => '<b>' . $this->l('Usługi dodatkowe / Niestandardowe') . '</b><hr>',
                ),
                'panelClass' => 'toggle_panel pp_pocztex_48 col-lg-7',
                'input' => array(
                    array(
                        'type' => 'checkbox',
                        'col'=>12,
                        'hide_label'=>true,
                        'name' => PPPackage::PP_POCZTEX_48_OSTROZNIE,
                        'values' => array(
                            'query' => array(
                                array('id' => PPPackage::PP_POCZTEX_48_OSTROZNIE, 'name' => $this->l('Ostrożnie'), 'val' => '1'),
                                //array('id' => PPPackage::PP_POCZTEX_48_DORECZENIE_DO_RAK_WLASNYCH, 'name' => $this->l('Doręczenie do rąk własnych'), 'val' => '1'),
                            ),
                            'id' => 'id',
                            'name' => 'name'
                        ),
                        'form_group_class' => 'pp_pocztex_48 '. PPPackage::PP_POCZTEX_48_ODBIOR_W_PUNKCIE . ' 0 1',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Przesyłka niestandardowa'),
                        'name' => PPPackage::PP_POCZTEX_48_PRZESYLKA_NIESTANDARDOWA,
                        'values' => array(
                            array(
                                'id' => PPPackage::PP_POCZTEX_48_PRZESYLKA_NIESTANDARDOWA . '_on',
                                'value' => 1
                            ),
                            array(
                                'id' => PPPackage::PP_POCZTEX_48_PRZESYLKA_NIESTANDARDOWA . '_off',
                                'value' => 0
                            )
                        ),
                        'form_group_class' => 'pp_pocztex_48 '. PPPackage::PP_POCZTEX_48_ODBIOR_W_PUNKCIE . ' 0 1',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Deklaracja wartości'),
                        'name' => PPPackage::PP_POCZTEX_48_DEKLARACJA_WARTOSCI,
                        'values' => array(
                            array(
                                'id' => PPPackage::PP_POCZTEX_48_DEKLARACJA_WARTOSCI . '_on',
                                'value' => 1
                            ),
                            array(
                                'id' => PPPackage::PP_POCZTEX_48_DEKLARACJA_WARTOSCI . '_off',
                                'value' => 0
                            )
                        ),
                        'form_group_class' => 'pp_pocztex_48 toggle_rows',
                    ),
                    array(
                        'type' => 'text',
                        'name' => PPPackage::PP_POCZTEX_48_WARTOSC_ZL,
                        'class' => 'fixed-width-xxl',
                        'label' => $this->l('Wartość'),
                        'form_group_class' => 'pp_pocztex_48 ' . PPPackage::PP_POCZTEX_48_DEKLARACJA_WARTOSCI . ' 1',
                        'tab' => 'services',
                        'suffix' => 'zł',
                    ),
                    array(
                        'type' => 'text',
                        'name' => 'pp_pocztex_48_wartosc_kg',
                        'class' => 'fixed-width-xxl',
                        'form_group_class' => 'pp_pocztex_48 ' . PPPackage::PP_POCZTEX_48_DEKLARACJA_WARTOSCI . ' 1',
                        'suffix' => 'kg',
                        //'desc' => $this->l('W przypadku wartości pustej wartość zostanie pobrana z zamówienia')
                    ),
                    /*array(
                        'type' => 'switch',
                        'label' => $this->l('Ostrożnie'),
                        'name' => PPPackage::PP_POCZTEX_48_OSTROZNIE,
                        'values' => array(
                            array(
                                'id' => PPPackage::PP_POCZTEX_48_OSTROZNIE . '_on',
                                'value' => 1
                            ),
                            array(
                                'id' => PPPackage::PP_POCZTEX_48_OSTROZNIE . '_off',
                                'value' => 0
                            )
                        ),
                        'form_group_class' => 'pp_pocztex_48',
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Do rąk własnych'),
                        'name' => PPPackage::PP_POCZTEX_48_DORECZENIE_DO_RAK_WLASNYCH,
                        'values' => array(
                            array(
                                'id' => PPPackage::PP_POCZTEX_48_DORECZENIE_DO_RAK_WLASNYCH . '_on',
                                'value' => 1
                            ),
                            array(
                                'id' => PPPackage::PP_POCZTEX_48_DORECZENIE_DO_RAK_WLASNYCH . '_off',
                                'value' => 0
                            )
                        ),
                        'form_group_class' => 'pp_pocztex_48',
                    ),*/
                    /*array(
                        'type' => 'switch',
                        'label' => $this->l('Potwierdź odbiór'),
                        'name' => PPPackage::PP_POCZTEX_48_POTWIERDZENIE_ODBIORU,
                        'values' => array(
                            array(
                                'id' => PPPackage::PP_POCZTEX_48_POTWIERDZENIE_ODBIORU . '_on',
                                'value' => 1
                            ),
                            array(
                                'id' => PPPackage::PP_POCZTEX_48_POTWIERDZENIE_ODBIORU . '_off',
                                'value' => 0
                            )
                        ),
                        'form_group_class' => 'pp_pocztex_48 toggle_rows',
                    ),
                    array(
                        'type' => 'select',
                        'name' => PPPackage::PP_POCZTEX_48_RODZAJ_POTWIERDZENIA,
                        'options' => array(
                            'query' => PocztaPolskaEn::getRodzajPotwierdzeniaBiznes(),
                            'id' => 'id',
                            'name' => 'name',
                        ),
                        'form_group_class' => 'pp_pocztex_48 ' . PPPackage::PP_POCZTEX_48_POTWIERDZENIE_ODBIORU . ' 1',
                    ),
                    array(
                        'type' => 'text',
                        'name' => PPPackage::PP_POCZTEX_48_POTWIERDZENIE_ILE,
                        'class' => 'fixed-width-xxl',
                        'form_group_class' => 'pp_pocztex_48 ' . PPPackage::PP_POCZTEX_48_POTWIERDZENIE_ODBIORU . ' 1',
                        'suffix' => $this->l('szt.'),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Dokumenty zwrotne'),
                        'name' => PPPackage::PP_POCZTEX_48_DOKUMENTY_ZWROTNE,
                        'values' => array(
                            array(
                                'id' => PPPackage::PP_POCZTEX_48_DOKUMENTY_ZWROTNE . '_on',
                                'value' => 1
                            ),
                            array(
                                'id' => PPPackage::PP_POCZTEX_48_DOKUMENTY_ZWROTNE . '_off',
                                'value' => 0
                            )
                        ),
                        'form_group_class' => 'pp_pocztex_48 toggle_rows',
                    ),
                    array(
                        'type' => 'select',
                        'name' => PPPackage::PP_POCZTEX_48_DOKUMENTY_RODZAJ_POTWIERDZENIA,
                        'options' => array(
                            'query' => PocztaPolskaEn::getDokumentyRodzajPotwierdzeniaBiznes(),
                            'id' => 'id',
                            'name' => 'name',
                        ),
                        'form_group_class' => 'pp_pocztex_48 ' . PPPackage::PP_POCZTEX_48_DOKUMENTY_ZWROTNE . ' 1',
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Wysłane do'),
                        'name' => PPPackage::PP_POCZTEX_48_WYSLANE_DO,
                        'options' => array(
                            'query' => PocztaPolskaEn::getWyslaneDoBiznes(),
                            'id' => 'id',
                            'name' => 'name',
                        ),
                        'form_group_class' => 'pp_pocztex_48 ' . PPPackage::PP_POCZTEX_48_DOKUMENTY_ZWROTNE . ' 1',
                    ),*/
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Ubezpieczenie'),
                        'name' => PPPackage::PP_POCZTEX_48_UBEZPIECZENIE,
                        'values' => array(
                            array(
                                'id' => PPPackage::PP_POCZTEX_48_UBEZPIECZENIE . '_on',
                                'value' => 1
                            ),
                            array(
                                'id' => PPPackage::PP_POCZTEX_48_UBEZPIECZENIE . '_off',
                                'value' => 0
                            )
                        ),
                        'form_group_class' => 'pp_pocztex_48 toggle_rows',
                    ),

                    array(
                        'type' => 'select',
                        'label' => $this->l('Wartość ubezpieczenia'),
                        'name' => PPPackage::PP_POCZTEX_48_WARTOSC_UBEZPIECZENIA,
                        'options' => array(
                            'query' => PocztaPolskaEn::getWartoscUbezpieczenia(),
                            'id' => 'id',
                            'name' => 'name',
                        ),
                        'form_group_class' => 'pp_pocztex_48 toggle_combo ' . PPPackage::PP_POCZTEX_48_UBEZPIECZENIE . ' 1',
                    ),
                    array(
                        'type' => 'text',
                        'name' => PPPackage::PP_POCZTEX_48_OKRESLONA_WARTOSC,
                        'class' => 'fixed-width-xxl',
                        'label' => $this->l('określona wartość'),
                        'form_group_class' => 'pp_pocztex_48 ' .  PPPackage::PP_POCZTEX_48_UBEZPIECZENIE . ' 1 ' . PPPackage::PP_POCZTEX_48_WARTOSC_UBEZPIECZENIA . ' okreslona_wartosc',
                        'suffix' => 'zł'
                    ),
                )
            );
            $fields_form[]['form'] = array(
                'legend' => array(
                    'title' => '<b>' . $this->l('RODZAJ') . '</b><hr>',
                ),
                'panelClass' => 'toggle_panel pp_pocztex_48 col-lg-5',
                'input' => array(
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Pobranie'),
                        'name' => PPPackage::PP_POCZTEX_48_POBRANIE,
                        'values' => array(
                            array(
                                'id' => PPPackage::PP_POCZTEX_48_POBRANIE . '_on',
                                'value' => 1
                            ),
                            array(
                                'id' => PPPackage::PP_POCZTEX_48_POBRANIE . '_off',
                                'value' => 0
                            )
                        ),
                        'form_group_class' => 'pp_pocztex_48 toggle_rows',
                    ),
                    array(
                        'type' => 'text',
                        'name' => PPPackage::PP_POCZTEX_48_KWOTA_POBRANIA,
                        'label' => $this->l('Kwota pobrania'),
                        'form_group_class' => 'pp_pocztex_48 '.PPPackage::PP_POCZTEX_48_POBRANIE.' 1',
                        'class' => 'fixed-width-xl',
                        'suffix' => 'zł',
                    ),
                    array(
                        'type' => 'text',
                        'name' => PPPackage::PP_POCZTEX_48_NUMER_RACHUNKU,
                        'label' => $this->l('Numer rachunku pobrania'),
                        'form_group_class' => 'pp_pocztex_48 '.PPPackage::PP_POCZTEX_48_POBRANIE.' 1',
                        'class' => 'fixed-width-xl',
                        'desc' => $this->l('Numer rachunku pobrania bez spacji')
                    ),
                    array(
                        'type' => 'text',
                        'name' => PPPackage::PP_POCZTEX_48_TYTUL_POBRANIA,
                        'label' => $this->l('Tytuł pobrania'),
                        'class' => 'fixed-width-xl',
                        'form_group_class' => 'pp_pocztex_48 '.PPPackage::PP_POCZTEX_48_POBRANIE.' 1',
                        //'desc' => $this->l('W tytule można użyć zmiennych <br>- {id_order} - numer zamóweniaw bazie  danych (np 1,2,3...)<br>- {id_order_number} - zamaskowany numer zamówienia (np:ABCBVWEZ)'),
                    ),
                    array(
                        'type' => 'switch',
                        'label' => $this->l('Sprawdzenie zawartości przez odbiorcę'),
                        'name' => PPPackage::PP_POCZTEX_48_ODBIORCA,
                        'values' => array(
                            array(
                                'id' => PPPackage::PP_POCZTEX_48_ODBIORCA . '_on',
                                'value' => 1
                            ),
                            array(
                                'id' => PPPackage::PP_POCZTEX_48_ODBIORCA . '_off',
                                'value' => 0
                            )
                        ),
                        'form_group_class' => 'pp_pocztex_48 '.PPPackage::PP_POCZTEX_48_POBRANIE.' 1 '.PPPackage::PP_POCZTEX_48_ODBIOR_W_PUNKCIE . ' 0',
                    ),
                )
            );

        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('ATRYBUTY') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_pocztex col-lg-6',
            'input' => array(
                array(
                    'type' => 'select',
                    'label' => $this->l('Serwis'),
                    'name' => PPPackage::PP_POCZTEX_SERWIS,
                    'options' => array(
                        'query' => PocztaPolskaEn::getSerwis(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_pocztex toggle_combo',
                ),
                array(
                    'type' => 'textarea',
                    'name' => PPPackage::PP_POCZTEX_OPIS_PRZESYLKI,
                    'label' => $this->l('Opis przesyłki'),
                    'form_group_class' => 'pp_pocztex',
                    'class' => 'fixed-width-xxl',
                    'maxlength' => 500
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Zawartość przesyłki'),
                    'name' => PPPackage::PP_POCZTEX_ZAWARTOSC,
                    'options' => array(
                        'query' => PocztaPolskaEn::getZawartoscPrzesylki(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_pocztex',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_MASA,
                    'class' => 'fixed-width-xl',
                    'label' => $this->l('Masa'),
                    'form_group_class' => 'pp_pocztex',
                    'suffix' => 'kg',
                ),
                /*array(
                    'type' => 'switch',
                    'label' => $this->l('Odbiór w punkcie'),
                    'name' => PPPackage::PP_POCZTEX_ODBIOR_W_PUNKCIE,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_ODBIOR_W_PUNKCIE . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_ODBIOR_W_PUNKCIE . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex toggle_rows',
                ),*/
                array(
                    'type' => 'select',
                    'label' => $this->l('Odbiór'),
                    'name' => PPPackage::PP_POCZTEX_ODBIOR_W_PUNKCIE,
                    'options' => array(
                        'query' => PocztaPolskaEn::getOdbiorType(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_pocztex toggle_combo',
                ),

                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_POKAZ_MAPE,
                    'class' => 'fixed-width-xxl',
                    'label' => '<button type="button" onclick="PPWidgetApp.toggleMap(ppPack.selectPickup,$(\'#'.PPPackage::PP_POCZTEX_POBRANIE.'_on\').is(\':checked\'),ppPack.currentOrder.address, ppPack.types[$(\'#'.PPPackage::PP_POCZTEX_ODBIOR_W_PUNKCIE.'\').val()]);return false;" class="btn btn-default">' . $this->l('Pokaż mape') . '</button>',
                    'form_group_class' => 'pp_pocztex toggle_combo ' . PPPackage::PP_POCZTEX_ODBIOR_W_PUNKCIE . ' 1 2',
                ),
                array(
                    'type' => 'hidden',
                    'name' => PPPackage::PP_POCZTEX_PNI,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Przesyłka niestandardowa'),
                    'name' => PPPackage::PP_POCZTEX_PRZESYLKA_NIESTANDARDOWA,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_PRZESYLKA_NIESTANDARDOWA . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_PRZESYLKA_NIESTANDARDOWA . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex '.PPPackage::PP_POCZTEX_SERWIS.' EKSPRES24 MIEJSKI_DO_3H_DO_5KM
                                    MIEJSKI_DO_3H_DO_10KM MIEJSKI_DO_3H_DO_15KM
                                    MIEJSKI_DO_3H_POWYZEJ_15KM
                                    MIEJSKI_DO_4H_DO_10KM
                                    MIEJSKI_DO_4H_DO_15KM
                                    MIEJSKI_DO_4H_DO_20KM
                                    MIEJSKI_DO_4H_DO_30KM MIEJSKI_DO_4H_DO_40KM '. PPPackage::PP_POCZTEX_ODBIOR_W_PUNKCIE . ' 0 1',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Wielopaczkowość'),
                    'name' => PPPackage::PP_POCZTEX_WIELOPACZKOWOSC,
                    //'disabled'=>(version_compare(PHP_VERSION, '7.0.0', '<')?false:true),
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_WIELOPACZKOWOSC . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_WIELOPACZKOWOSC . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex toggle_rows '.PPPackage::PP_POCZTEX_ODBIOR_W_PUNKCIE . ' 0 1',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Ilość'),
                    'name' => PPPackage::PP_POCZTEX_WIELOPACZKOWOSC_ILOSC,
                    'class' => 'fixed-width-xxl',
                    'form_group_class' => 'pp_pocztex ' . PPPackage::PP_POCZTEX_WIELOPACZKOWOSC . ' 1',
                    'suffix' => $this->l('szt.'),
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Uiszcza opłatę'),
                    'name' => PPPackage::PP_POCZTEX_OPLATA,
                    'options' => array(
                        'query' => PocztaPolskaEn::getUiszczaOplate(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_pocztex',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Godzina doręczenia'),
                    'name' => PPPackage::PP_POCZTEX_GODZINA_DORECZENIA,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_GODZINA_DORECZENIA . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_GODZINA_DORECZENIA . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex toggle_combo '.PPPackage::PP_POCZTEX_SERWIS.' EKSPRES24 '.PPPackage::PP_POCZTEX_ODBIOR_W_PUNKCIE . ' 0',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Godzina'),
                    'name' => PPPackage::PP_POCZTEX_GODZINA,
                    'options' => array(
                        'query' => PocztaPolskaEn::getGodzina(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_pocztex ' . PPPackage::PP_POCZTEX_GODZINA_DORECZENIA . ' 1 '.PPPackage::PP_POCZTEX_SERWIS.'',
                ),
            )
        );
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('POBRANIE') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_pocztex col-lg-6',
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Pobranie'),
                    'name' => PPPackage::PP_POCZTEX_POBRANIE,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_POBRANIE . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_POBRANIE . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex toggle_rows',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Sposób pobrania'),
                    'name' => PPPackage::PP_POCZTEX_SPOSOB_POBRANIA,
                    'options' => array(
                        'query' => PocztaPolskaEn::getSposobPobrania(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_pocztex ' . PPPackage::PP_POCZTEX_POBRANIE . ' 1',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_KWOTA_POBRANIA,
                    'label' => $this->l('Kwota pobrania'),
                    'form_group_class' => 'pp_pocztex ' . PPPackage::PP_POCZTEX_POBRANIE . ' 1',
                    'class' => 'fixed-width-xxl',
                    'suffix' => 'zł',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_NUMER_RACHUNKU,
                    'label' => $this->l('Numer rachunku pobrania'),
                    'form_group_class' => 'pp_pocztex pp_pocztex_pobranie 1',
                    'class' => 'fixed-width-xxl',
                    'desc' => $this->l('Numer rachunku pobrania bez spacji')
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_TYTUL_POBRANIA,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Tytuł pobrania'),
                    'form_group_class' => 'pp_pocztex pp_pocztex_pobranie 1',
                    //'desc' => $this->l('W tytule można użyć zmiennych <br>- {id_order} - numer zamóweniaw bazie  danych (np 1,2,3...)<br>- {id_order_number} - zamaskowany numer zamówienia (np:ABCBVWEZ)'),
                ),
            )
        );
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('USŁUGI DODATKOWE/ NIESTANDARDOWE') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_pocztex col-lg-6',
            'input' => array(
                array(
                    'type' => 'checkbox',
                    'col'=>12,
                    'hide_label'=>true,
                    'name' => PPPackage::PP_POCZTEX_OSTROZNIE,
                    'values' => array(
                        'query' => array(
                            array('id' => PPPackage::PP_POCZTEX_OSTROZNIE, 'name' => $this->l('Ostrożnie'), 'val' => '1', 'class' => 'form group pp_pocztex '.PPPackage::PP_POCZTEX_ODBIOR_W_PUNKCIE . ' 0 1'),
                            array('id' => PPPackage::PP_POCZTEX_SPRAWDZENIE_ZAWARTOSCI, 'name' => $this->l('Sprawdzenie zawartości'), 'val' => '1', 'class' => 'form group pp_pocztex '.PPPackage::PP_POCZTEX_ODBIOR_W_PUNKCIE . ' 0'),
                            array('id' => PPPackage::PP_POCZTEX_DORECZENIE_DO_RAK_WLASNYCH, 'name' => $this->l('Doręczenie do rąk własnych'), 'val' => '1'),
                            array('id' => PPPackage::PP_POCZTEX_DORECZENIE_W_SOBOTE, 'name' => $this->l('Doręczenie w sobotę'), 'val' => '1'),
                            array('id' => PPPackage::PP_POCZTEX_ODBIOR_PRZESYLKI_W_SOBOTE, 'name' => $this->l('Odbiór w sobotę'), 'val' => '1', 'class' => 'form group pp_pocztex '.PPPackage::PP_POCZTEX_ODBIOR_W_PUNKCIE . ' 0'),
                            array('id'=>PPPackage::PP_POCZTEX_DORECZENIE_W_90_MINUT,'name'=>$this->l('Doręczenie w 90 minut'),'class'=>'form_group pp_pocztex '.PPPackage::PP_POCZTEX_SERWIS.' MIEJSKI_DO_3H_DO_5KM MIEJSKI_DO_3H_DO_10KM MIEJSKI_DO_3H_DO_15KM MIEJSKI_DO_3H_POWYZEJ_15KM'),
                            array('id'=>PPPackage::PP_POCZTEX_DORECZENIE_W_NIEDZIELE_SWIETO,'name'=>$this->l('Doręczenie w niedzielę/święto'),'class'=>'form_group pp_pocztex '.PPPackage::PP_POCZTEX_SERWIS.' BEZPOSREDNI_DO_20KG BEZPOSREDNI_OD_20KG_DO_30KG BEZPOSREDNI_OD_30KG_DO_100KG'),
                            array('id'=>PPPackage::PP_POCZTEX_DORECZENIE_W_20_7,'name'=>$this->l('Doręczenie 20:00-7:00'),'class'=>'form_group pp_pocztex '.PPPackage::PP_POCZTEX_SERWIS.' BEZPOSREDNI_DO_20KG BEZPOSREDNI_OD_20KG_DO_30KG BEZPOSREDNI_OD_30KG_DO_100KG'),
                            array('id'=>PPPackage::PP_POCZTEX_ODBIOR_W_NIEDZIELE_SWIETO,'name'=>$this->l('Odbiór w niedzielę/święto'),'class'=>'form_group pp_pocztex '.PPPackage::PP_POCZTEX_SERWIS.' BEZPOSREDNI_DO_20KG BEZPOSREDNI_OD_20KG_DO_30KG BEZPOSREDNI_OD_30KG_DO_100KG'),
                            array('id'=>PPPackage::PP_POCZTEX_ODBIOR_W_20_7,'name'=>$this->l('Odbiór 20:00-7:00'),'class'=>'form_group pp_pocztex '.PPPackage::PP_POCZTEX_SERWIS.' BEZPOSREDNI_DO_20KG BEZPOSREDNI_OD_20KG_DO_30KG BEZPOSREDNI_OD_30KG_DO_100KG'),
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    ),
                    'form_group_class' => 'pp_pocztex',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Deklaracja wartości'),
                    'name' => PPPackage::PP_POCZTEX_DEKLARACJA_WARTOSCI,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_DEKLARACJA_WARTOSCI . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_DEKLARACJA_WARTOSCI . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex toggle_rows',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_WARTOSC_ZL,
                    'label' => $this->l('Wartość'),
                    'class' => 'fixed-width-xxl',
                    'form_group_class' => 'pp_pocztex ' . PPPackage::PP_POCZTEX_DEKLARACJA_WARTOSCI . ' 1',
                    'suffix' => 'zł',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Potwierdź odbiór'),
                    'name' => PPPackage::PP_POCZTEX_POTWIERDZENIE_ODBIORU,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_POTWIERDZENIE_ODBIORU . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_POTWIERDZENIE_ODBIORU . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex toggle_rows',
                ),
                array(
                    'type' => 'select',
                    'name' => PPPackage::PP_POCZTEX_RODZAJ_POTWIERDZENIA,
                    'options' => array(
                        'query' => PocztaPolskaEn::getRodzajPotwierdzenia(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_pocztex ' . PPPackage::PP_POCZTEX_POTWIERDZENIE_ODBIORU . ' 1',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_POTWIERDZENIE_ILE,
                    'class' => 'fixed-width-xxl',
                    'form_group_class' => 'pp_pocztex ' . PPPackage::PP_POCZTEX_POTWIERDZENIE_ODBIORU . ' 1',
                    'suffix' => $this->l('szt.'),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Potwierdź doręczenie'),
                    'name' => PPPackage::PP_POCZTEX_POTWIERDZENIE_DORECZENIA,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_POTWIERDZENIE_DORECZENIA . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_POTWIERDZENIE_DORECZENIA . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex toggle_rows',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Typ potwierdzenia doręczenia'),
                    'name' => PPPackage::PP_POCZTEX_TYP_POTWIERDZENIA,
                    'options' => array(
                        'query' => PocztaPolskaEn::getTypPotwierdzenia(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_pocztex ' . PPPackage::PP_POCZTEX_POTWIERDZENIE_DORECZENIA . ' 1',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_NR_TEL_POTWIERDZENIA,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Nr. telefonu do potwierdzenia doręczenia'),
                    'form_group_class' => 'pp_pocztex ' . PPPackage::PP_POCZTEX_POTWIERDZENIE_DORECZENIA . ' 1',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_EMAIL_POTWIERDZENIA,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Email do potwierdzenia doręczenia'),
                    'form_group_class' => 'pp_pocztex ' . PPPackage::PP_POCZTEX_POTWIERDZENIE_DORECZENIA . ' 1',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Doręczenie w dniu'),
                    'name' => PPPackage::PP_POCZTEX_DORECZENIE_WE_WSKAZANYM_DNIU,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_DORECZENIE_WE_WSKAZANYM_DNIU . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_DORECZENIE_WE_WSKAZANYM_DNIU . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex toggle_combo '.PPPackage::PP_POCZTEX_SERWIS.' EKSPRES24',
                ),
                array(
                    'type' => 'date',
                    'name' => PPPackage::PP_POCZTEX_DATA_DORECZENIA,
                    'label' => $this->l('Data'),
                    'class' => 'fixed-width-xl datepicker_modal',
                    'form_group_class' => 'pp_pocztex ' . PPPackage::PP_POCZTEX_DORECZENIE_WE_WSKAZANYM_DNIU . ' 1  '.PPPackage::PP_POCZTEX_SERWIS,
                ),

                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_ODLEGLOSC,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Odległość'),
                    'form_group_class' => 'pp_pocztex '.PPPackage::PP_POCZTEX_SERWIS.' BEZPOSREDNI_DO_20KG BEZPOSREDNI_OD_20KG_DO_30KG BEZPOSREDNI_OD_30KG_DO_100KG',
                    'suffix' => 'km',
                ),


                array(
                    'type' => 'switch',
                    'label' => $this->l('Ubezpieczenie'),
                    'name' => PPPackage::PP_POCZTEX_UBEZPIECZENIE,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_UBEZPIECZENIE . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_UBEZPIECZENIE . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex toggle_rows',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Wartość ubezpieczenia'),
                    'name' => PPPackage::PP_POCZTEX_WARTOSC_UBEZPIECZENIA,
                    'options' => array(
                        'query' => PocztaPolskaEn::getWartoscPocztexUbezpieczenia(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_pocztex toggle_combo ' . PPPackage::PP_POCZTEX_UBEZPIECZENIE . ' 1',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_OKRESLONA_WARTOSC,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('określona wartość'),
                    'form_group_class' => 'pp_pocztex ' . PPPackage::PP_POCZTEX_UBEZPIECZENIE . ' 1 ' . PPPackage::PP_POCZTEX_WARTOSC_UBEZPIECZENIA . ' okreslona_wartosc',
                    'suffix' => 'zł'
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Dokumenty zwrotne'),
                    'name' => PPPackage::PP_POCZTEX_DOKUMENTY_ZWROTNE,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_DOKUMENTY_ZWROTNE . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_DOKUMENTY_ZWROTNE . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex toggle_rows',
                ),
                array(
                    'type' => 'select',
                    'name' => PPPackage::PP_POCZTEX_DOKUMENTY_RODZAJ_POTWIERDZENIA,
                    'options' => array(
                        'query' => PocztaPolskaEn::getDokumentyRodzajPotwierdzenia(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_pocztex ' . PPPackage::PP_POCZTEX_DOKUMENTY_ZWROTNE . ' 1',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Wysłane do'),
                    'name' => PPPackage::PP_POCZTEX_WYSLANE_DO,
                    'options' => array(
                        'query' => PocztaPolskaEn::getWyslaneDo(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_pocztex ' . PPPackage::PP_POCZTEX_DOKUMENTY_ZWROTNE . ' 1',
                ),
            )
        );
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('ATRYBUTY') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_paczka_pocztowa col-lg-6',
            'input' => array(
                array(
                    'type' => 'select',
                    'label' => $this->l('Kategoria'),
                    'name' => PPPackage::PP_PACZKA_POCZTOWA_KATEGORIA,
                    'options' => array(
                        'query' => PocztaPolskaEn::getPaczka(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_paczka_pocztowa',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Gabaryt'),
                    'name' => PPPackage::PP_PACZKA_POCZTOWA_GABARYT,
                    'options' => array(
                        'query' => PocztaPolskaEn::getGabaryt(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_paczka_pocztowa',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_PACZKA_POCZTOWA_MASA,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Masa'),
                    'form_group_class' => 'pp_paczka_pocztowa',
                    'suffix' => 'kg',
                ),
                array(
                    'type' => 'textarea',
                    'name' => PPPackage::PP_PACZKA_POCZTOWA_OPIS_PRZESYLKI,
                    'label' => $this->l('Opis przesyłki'),
                    'form_group_class' => 'pp_paczka_pocztowa',
                    'class' => 'fixed-width-xxl',
                    'maxlength' => 500
                ),
            )
        );
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('USŁUGI DODATKOWE') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_paczka_pocztowa col-lg-6',
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Deklaracja wartości'),
                    'name' => PPPackage::PP_PACZKA_POCZTOWA_DEKLARACJA_WARTOSCI,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_PACZKA_POCZTOWA_DEKLARACJA_WARTOSCI . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_PACZKA_POCZTOWA_DEKLARACJA_WARTOSCI . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_paczka_pocztowa toggle_rows',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_PACZKA_POCZTOWA_DEKLARACJA_WARTOSCI_ZL,
                    'label' => $this->l('Wartość'),
                    'class' => 'fixed-width-xxl',
                    'form_group_class' => 'pp_paczka_pocztowa ' . PPPackage::PP_PACZKA_POCZTOWA_DEKLARACJA_WARTOSCI . ' 1',
                    //'desc' => $this->l('W przypadku wartości pustej wartość zostanie pobrana z zamówienia'),
                    'suffix' => 'zł',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_PACZKA_POCZTOWA_POTWIERDZENIE_ILE,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Ilość potwierdzeń'),
                    'form_group_class' => 'pp_paczka_pocztowa',
                    'suffix' => $this->l('szt.'),
                ),
            )
        );
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('SPECJALNE USŁUGI DODATKOWE') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_paczka_pocztowa col-lg-12',
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Egzemplarz biblioteczny'),
                    'name' => PPPackage::PP_PACZKA_POCZTOWA_EGZEMPLARZ_BIBLIOTECZNY,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_PACZKA_POCZTOWA_EGZEMPLARZ_BIBLIOTECZNY . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_PACZKA_POCZTOWA_EGZEMPLARZ_BIBLIOTECZNY . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_paczka_pocztowa',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Dla ociemniałych'),
                    'name' => PPPackage::PP_PACZKA_POCZTOWA_DLA_OCIEMNIALYCH,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_PACZKA_POCZTOWA_DLA_OCIEMNIALYCH . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_PACZKA_POCZTOWA_DLA_OCIEMNIALYCH . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_paczka_pocztowa',
                ),
            )
        );
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('ATRYBUTY') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_global_express col-lg-6',
            'input' => array(
                array(
                    'type' => 'select',
                    'label' => $this->l('Zawartość przesyłki'),
                    'name' => PPPackage::PP_GLOBAL_EXPRESS_ZAWARTOSC,
                    'options' => array(
                        'query' => PocztaPolskaEn::getZawartoscGlobalPrzesylki(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_global_express',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_GLOBAL_EXPRESS_MASA,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Masa'),
                    'form_group_class' => 'pp_global_express',
                    'suffix' => 'kg',
                ),
                array(
                    'type' => 'textarea',
                    'name' => PPPackage::PP_GLOBAL_EXPRESS_OPIS_PRZESYLKI,
                    'label' => $this->l('Opis przesyłki'),
                    'form_group_class' => 'pp_global_express',
                    'class' => 'fixed-width-xxl',
                    'maxlength' => 500
                ),
            )
        );
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('USŁUGI DODATKOWE') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_global_express col-lg-6',
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Potwierdzenie doręczenia'),
                    'name' => PPPackage::PP_GLOBAL_EXPRESS_POTWIERDZENIE_DORECZENIA,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_GLOBAL_EXPRESS_POTWIERDZENIE_DORECZENIA . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_GLOBAL_EXPRESS_POTWIERDZENIE_DORECZENIA . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_global_express toggle_rows',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Typ potwierdzenia doręczenia'),
                    'name' => PPPackage::PP_GLOBAL_EXPRESS_TYP_POTWIERDZENIA,
                    'options' => array(
                        'query' => PocztaPolskaEn::getTypPotwierdzenia(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_global_express ' . PPPackage::PP_GLOBAL_EXPRESS_POTWIERDZENIE_DORECZENIA . ' 1',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_GLOBAL_EXPRESS_NR_TEL_POTWIERDZENIA,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Nr. telefonu do potwierdzenia doręczenia'),
                    'form_group_class' => 'pp_global_express ' . PPPackage::PP_GLOBAL_EXPRESS_POTWIERDZENIE_DORECZENIA . ' 1',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_GLOBAL_EXPRESS_EMAIL_POTWIERDZENIA,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Email do potwierdzenia doręczenia'),
                    'form_group_class' => 'pp_global_express ' . PPPackage::PP_GLOBAL_EXPRESS_POTWIERDZENIE_DORECZENIA . ' 1',
                ),
            )
        );
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('ATRYBUTY') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_przesylka_polecona col-lg-6',
            'input' => array(
                array(
                    'type' => 'select',
                    'label' => $this->l('Kategoria'),
                    'name' => PPPackage::PP_PRZESYLKA_POLECONA_KATEGORIA,
                    'options' => array(
                        'query' => PocztaPolskaEn::getPaczka(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_przesylka_polecona',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Format'),
                    'name' => PPPackage::PP_PRZESYLKA_POLECONA_FORMAT,
                    'options' => array(
                        'query' => PocztaPolskaEn::getFormat(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_przesylka_polecona',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_PRZESYLKA_POLECONA_MASA,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Masa'),
                    'form_group_class' => 'pp_przesylka_polecona',
                    'suffix' => 'kg',
                ),
                array(
                    'type' => 'textarea',
                    'name' => PPPackage::PP_PRZESYLKA_POLECONA_OPIS_PRZESYLKI,
                    'label' => $this->l('Opis przesyłki'),
                    'form_group_class' => 'pp_przesylka_polecona',
                    'class' => 'fixed-width-xxl',
                    'maxlength' => 500
                ),
            )
        );
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('SPECJALNE USŁUGI DODATKOWE') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_przesylka_polecona col-lg-6',
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Egzemplarz biblioteczny'),
                    'name' => PPPackage::PP_PRZESYLKA_POLECONA_EGZEMPLARZ_BIBLIOTECZNY,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_PRZESYLKA_POLECONA_EGZEMPLARZ_BIBLIOTECZNY . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_PRZESYLKA_POLECONA_EGZEMPLARZ_BIBLIOTECZNY . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_przesylka_polecona',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Dla ociemniałych'),
                    'name' => PPPackage::PP_PRZESYLKA_POLECONA_DLA_OCIEMNIALYCH,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_PRZESYLKA_POLECONA_DLA_OCIEMNIALYCH . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_PRZESYLKA_POLECONA_DLA_OCIEMNIALYCH . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_przesylka_polecona',
                ),
            )
        );
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('USŁUGI DODATKOWE') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_przesylka_polecona col-lg-6',
            'input' => array(
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_PRZESYLKA_POLECONA_ILOSC,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Ilość potwierdzeń'),
                    'form_group_class' => 'pp_przesylka_polecona',
                    'suffix' => $this->l('szt.'),
                ),
            )
        );
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('ATRYBUTY') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_przesylka_firmowa col-lg-6',
            'input' => array(
                array(
                    'type' => 'select',
                    'label' => $this->l('Gabaryt'),
                    'name' => PPPackage::PP_PRZESYLKA_FIRMOWA_GABARYT,
                    'options' => array(
                        'query' => PocztaPolskaEn::getGabaryt(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'disabled' => true,
                    'form_group_class' => 'pp_przesylka_firmowa',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Kategoria'),
                    'name' => PPPackage::PP_PRZESYLKA_FIRMOWA_KATEGORIA,
                    'options' => array(
                        'query' => PocztaPolskaEn::getPaczka(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_przesylka_firmowa',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_PRZESYLKA_FIRMOWA_MASA,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Masa'),
                    'form_group_class' => 'pp_przesylka_firmowa',
                    'suffix' => 'kg',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Miejscowa/Zamiejscowa'),
                    'name' => PPPackage::PP_PRZESYLKA_FIRMOWA_MIEJSCOWA_ZAMIEJSCOWA,
                    'options' => array(
                        'query' => PocztaPolskaEn::getMiejscowaZamiejscowa(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_przesylka_firmowa',
                ),
                array(
                    'type' => 'textarea',
                    'name' => PPPackage::PP_PRZESYLKA_FIRMOWA_OPIS_PRZESYLKI,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Opis przesyłki'),
                    'form_group_class' => 'pp_przesylka_firmowa',
                    'class' => 'fixed-width-xxl',
                    'maxlength' => 500
                ),
            )
        );
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('USŁUGI DODATKOWE') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_przesylka_firmowa col-lg-6',
            'input' => array(
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_PRZESYLKA_FIRMOWA_ILOSC,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Ilość potwierdzeń'),
                    'form_group_class' => 'pp_przesylka_firmowa',
                    'suffix' => $this->l('szt.'),
                ),
            )
        );
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('ATRYBUTY') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_paczka_ue col-lg-6',
            'input' => array(
                array(
                    'type' => 'select',
                    'label' => $this->l('Kategoria'),
                    'name' => PPPackage::PP_PACZKA_UE_KATEGORIA,
                    'options' => array(
                        'query' => PocztaPolskaEn::getPaczka(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_paczka_ue',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_PACZKA_UE_MASA,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Masa'),
                    'form_group_class' => 'pp_paczka_ue',
                    'suffix' => 'kg',
                ),
                array(
                    'type' => 'textarea',
                    'name' => PPPackage::PP_PACZKA_UE_OPIS_PRZESYLKI,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Opis przesyłki'),
                    'form_group_class' => 'pp_paczka_ue',
                    'class' => 'fixed-width-xxl',
                    'maxlength' => 500
                ),
            )
        );
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('USŁUGI DODATKOWE') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_paczka_ue col-lg-6',
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Deklaracja wartości'),
                    'name' => PPPackage::PP_PACZKA_UE_DEKLARACJA_WARTOSCI,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_PACZKA_UE_DEKLARACJA_WARTOSCI . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_PACZKA_UE_DEKLARACJA_WARTOSCI . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_paczka_ue toggle_rows',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_PACZKA_UE_DEKLARACJA_WARTOSCI_ZL,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Wartość'),
                    'form_group_class' => 'pp_paczka_ue ' . PPPackage::PP_PACZKA_UE_DEKLARACJA_WARTOSCI . ' 1',
                    'suffix' => 'zł',
                    //'desc' => $this->l('W przypadku wartości pustej wartość zostanie pobrana z zamówienia'),
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_PACZKA_UE_ILOSC,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Ilość potwierdzeń'),
                    'form_group_class' => 'pp_paczka_ue',
                    'suffix' => $this->l('szt.'),
                ),
            )
        );
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('SPECJALNE USŁUGI DODATKOWE') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_paczka_ue col-lg-6',
            'input' => array(
                array(
                    'type' => 'select',
                    'label' => $this->l('Zwrot'),
                    'name' => PPPackage::PP_PACZKA_UE_ZWROT,
                    'options' => array(
                        'query' => PocztaPolskaEn::getZwrot(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_paczka_ue toggle_combo',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Sposób zwrotu'),
                    'name' => PPPackage::PP_PACZKA_UE_SPOSOB_ZWROTU,
                    'options' => array(
                        'query' => PocztaPolskaEn::getSposobZwrot(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_paczka_ue ' . PPPackage::PP_PACZKA_UE_ZWROT . ' zwrot_po_liczbie_dni zwrot_natychmiast',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_PACZKA_UE_ILOSC_DNI,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Liczba dni'),
                    'form_group_class' => 'pp_paczka_ue ' . PPPackage::PP_PACZKA_UE_ZWROT . ' zwrot_po_liczbie_dni',
                ),
            )
        );
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('ATRYBUTY') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_zagraniczna_przesylka col-lg-6',
            'input' => array(
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_ZAGRANICZNA_PRZESYLKA_MASA,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Masa'),
                    'form_group_class' => 'pp_zagraniczna_przesylka',
                    'suffix' => 'kg',
                ),
                array(
                    'type' => 'textarea',
                    'name' => PPPackage::PP_ZAGRANICZNA_PRZESYLKA_OPIS_PRZESYLKI,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Opis przesyłki'),
                    'form_group_class' => 'pp_zagraniczna_przesylka',
                    'class' => 'fixed-width-xxl',
                    'maxlength' => 500
                ),
            )
        );
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('USŁUGI DODATKOWE') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_zagraniczna_przesylka col-lg-6',
            'input' => array(
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_ZAGRANICZNA_PRZESYLKA_ILOSC,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Ilość potwierdzeń'),
                    'form_group_class' => 'pp_zagraniczna_przesylka',
                    'suffix' => $this->l('szt.'),
                ),
            )
        );
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('ATRYBUTY') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_ems_ue col-lg-6',
            'input' => array(
                array(
                    'type' => 'select',
                    'label' => $this->l('Typ opakowania'),
                    'name' => PPPackage::PP_EMS_UE_TYP_OPAKOWANIA,
                    'options' => array(
                        'query' => PocztaPolskaEn::getTypOpakowania(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_ems_ue',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_EMS_UE_MASA,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Masa'),
                    'form_group_class' => 'pp_ems_ue',
                    'suffix' => 'kg',
                ),
                array(
                    'type' => 'textarea',
                    'name' => PPPackage::PP_EMS_UE_OPIS_PRZESYLKI,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Opis przesyłki'),
                    'form_group_class' => 'pp_ems_ue',
                    'class' => 'fixed-width-xxl',
                    'maxlength' => 500
                ),
            )
        );
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('USŁUGI DODATKOWE') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_ems_ue col-lg-6',
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Potwierdzenie doręczenia'),
                    'name' => PPPackage::PP_EMS_UE_POTWIERDZENIE_DORECZENIA,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_EMS_UE_POTWIERDZENIE_DORECZENIA . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_EMS_UE_POTWIERDZENIE_DORECZENIA . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_ems_ue toggle_rows',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Typ potwierdzenia doręczenia'),
                    'name' => PPPackage::PP_EMS_UE_TYP_POTWIERDZENIA,
                    'options' => array(
                        'query' => PocztaPolskaEn::getTypPotwierdzenia(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_ems_ue ' . PPPackage::PP_EMS_UE_POTWIERDZENIE_DORECZENIA . ' 1',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_EMS_UE_NR_TEL_POTWIERDZENIA,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Nr. telefonu do potwierdzenia doręczenia'),
                    'form_group_class' => 'pp_ems_ue ' . PPPackage::PP_EMS_UE_POTWIERDZENIE_DORECZENIA . ' 1',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_EMS_UE_EMAIL_POTWIERDZENIA,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Email do potwierdzenia doręczenia'),
                    'form_group_class' => 'pp_ems_ue ' . PPPackage::PP_EMS_UE_POTWIERDZENIE_DORECZENIA . ' 1',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Ubezpieczenie'),
                    'name' => PPPackage::PP_EMS_UE_UBEZPIECZENIE,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_EMS_UE_UBEZPIECZENIE . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_EMS_UE_UBEZPIECZENIE . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_ems_ue toggle_rows',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Wartość ubezpieczenia'),
                    'name' => PPPackage::PP_EMS_UE_WARTOSC_UBEZPIECZENIA,
                    'options' => array(
                        'query' => PocztaPolskaEn::getWartoscEmsUbezpieczenia(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_ems_ue toggle_combo ' . PPPackage::PP_EMS_UE_UBEZPIECZENIE . ' 1',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_EMS_UE_OKRESLONA_WARTOSC,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('określona wartość'),
                    'form_group_class' => 'pp_ems_ue '. PPPackage::PP_EMS_UE_UBEZPIECZENIE . ' 1 '  . PPPackage::PP_EMS_UE_WARTOSC_UBEZPIECZENIA . ' okreslona_wartosc',
                    'suffix' => 'zł'
                ),
            ),
        );

        #POCZTEX 2021 KURIER
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('ATRYBUTY') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_pocztex_2021_kurier col-lg-6',
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Nadanie przesyłki u kuriera'),
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_NADANIE_U_KURIERA,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_KURIER_NADANIE_U_KURIERA . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_KURIER_NADANIE_U_KURIERA . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex_2021_kurier toggle_rows',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Format'),
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_FORMAT,
                    'options' => array(
                        'query' => PocztaPolskaEn::getFormats(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_pocztex_2021_kurier',
                ),
                array(
                    'type' => 'textarea',
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_PRZESYLKI,
                    'label' => $this->l('Opis przesyłki'),
                    'form_group_class' => 'pp_pocztex_2021_kurier',
                    'class' => 'fixed-width-xxl',
                    'maxlength' => 500
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Zawartość przesyłki'),
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_TYP_ZAWARTOSCI,
                    'options' => array(
                        'query' => PocztaPolskaEn::getTypZawartosci(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_pocztex_2021_kurier toggle_combo',
                    'tab' => 'services'
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_TYP_ZAWARTOSCI_INNE,
                    'label' => $this->l('Zawartość szczegóły'),
                    'form_group_class' => 'pp_pocztex_2021_kurier '.PPPackage::PP_POCZTEX_2021_KURIER_TYP_ZAWARTOSCI . ' INNE',
                    'tab' => 'services',
                    'class' => 'fixed-width-xxl',
                ),
            )
        );
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('OPCJE USŁUGI') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_pocztex_2021_kurier col-lg-6',
            'input' => array(
                /*array(
                    'type' => 'switch',
                    'label' => $this->l('Odbiór w punkcie'),
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_ODBIOR_W_PUNKCIE,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_KURIER_ODBIOR_W_PUNKCIE . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_KURIER_ODBIOR_W_PUNKCIE . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex_2021_kurier toggle_rows',
                ),*/
                array(
                    'type' => 'select',
                    'label' => $this->l('Odbiór'),
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_ODBIOR_W_PUNKCIE,
                    'options' => array(
                        'query' => PocztaPolskaEn::getOdbiorType(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_pocztex_2021_kurier toggle_combo',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_POKAZ_MAPE,
                    'readonly' => true,
                    'class' => 'fixed-width-xxl',
                    'label' => '<button type="button" onclick="PPWidgetApp.toggleMap(ppPack.selectPickup,$(\'#'.PPPackage::PP_POCZTEX_2021_KURIER_POBRANIE.'_on\').is(\':checked\'),ppPack.currentOrder.address, ppPack.types[$(\'#'.PPPackage::PP_POCZTEX_2021_KURIER_ODBIOR_W_PUNKCIE.'\').val()]);return false;" class="btn btn-default">' . $this->l('Pokaż mape') . '</button>',
                    'form_group_class' => 'pp_pocztex_2021_kurier toggle_combo ' . PPPackage::PP_POCZTEX_2021_KURIER_ODBIOR_W_PUNKCIE . ' 1 2',
                ),
                array(
                    'type' => 'hidden',
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_PNI,
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Wielopaczkowość'),
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_WIELOPACZKOWOSC,
                    //'disabled'=>(version_compare(PHP_VERSION, '7.0.0', '<')?false:true),
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_KURIER_WIELOPACZKOWOSC . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_KURIER_WIELOPACZKOWOSC . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex_2021_kurier toggle_rows '.PPPackage::PP_POCZTEX_2021_KURIER_ODBIOR_W_PUNKCIE . ' 0 1',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Ilość'),
                    'class' => 'fixed-width-xxl',
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_WIELOPACZKOWOSC_ILOSC,
                    'form_group_class' => 'pp_pocztex_2021_kurier ' . PPPackage::PP_POCZTEX_2021_KURIER_WIELOPACZKOWOSC . ' 1',
                    'suffix' => $this->l('szt.'),
                )
            )
        );
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('Usługi dodatkowe / Niestandardowe') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_pocztex_2021_kurier col-lg-7',
            'input' => array(
                array(
                    'type' => 'checkbox',
                    'col'=>12,
                    'hide_label'=>true,
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_OSTROZNIE,
                    'values' => array(
                        'query' => array(
                            array('id' => PPPackage::PP_POCZTEX_2021_KURIER_OSTROZNIE, 'name' => $this->l('Ostrożnie'), 'val' => '1', 'class' => 'form group pp_pocztex_2021_kurier '. PPPackage::PP_POCZTEX_2021_KURIER_ODBIOR_W_PUNKCIE . ' 0 1'),
                            array('id' => PPPackage::PP_POCZTEX_2021_KURIER_KOPERTA_POCZTEX, 'name' => $this->l('Koperta Pocztex'), 'val' => '1'),
                            array('id' => PPPackage::PP_POCZTEX_2021_KURIER_ODBIOR_SOBOTA, 'name' => $this->l('Odbiór w sobotę'), 'val' => '1', 'class' => 'form group pp_pocztex_2021_kurier '.PPPackage::PP_POCZTEX_2021_KURIER_ODBIOR_W_PUNKCIE . ' 0'),
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    ),
                    'form_group_class' => 'pp_pocztex_2021_kurier',
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Godzina doręczenia'),
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_GODZINA_DORECZENIA,
                    'options' => array(
                        'query' => PocztaPolskaEn::getGodzinaDoreczenia(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_pocztex_2021_kurier '.PPPackage::PP_POCZTEX_2021_KURIER_ODBIOR_W_PUNKCIE . ' 0',
                    'tab' => 'services'
                ),
                array(
                    'type' => 'date',
                    'label' => $this->l('Dzień doręczenia'),
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_DZIEN,
                    'form_group_class' => 'pp_pocztex_2021_kurier',
                    'tab' => 'services',
                    'class' => 'fixed-width-xl datepicker_modal',
                ),

                array(
                    'type' => 'switch',
                    'label' => $this->l('Przesyłka niestandardowa'),
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_PONADGABARYT,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_KURIER_PONADGABARYT . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_KURIER_PONADGABARYT . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex_2021_kurier '.PPPackage::PP_POCZTEX_2021_KURIER_ODBIOR_W_PUNKCIE . ' 0 1',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Deklaracja wartości'),
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_DEKLARACJA_WARTOSCI,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_KURIER_DEKLARACJA_WARTOSCI . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_KURIER_DEKLARACJA_WARTOSCI . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex_2021_kurier toggle_rows',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_WARTOSC_ZL,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Wartość'),
                    'form_group_class' => 'pp_pocztex_2021_kurier ' . PPPackage::PP_POCZTEX_2021_KURIER_DEKLARACJA_WARTOSCI . ' 1',
                    'tab' => 'services',
                    'suffix' => 'zł',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_MASA,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Waga'),
                    'form_group_class' => 'pp_pocztex_2021_kurier',
                    'suffix' => 'kg',
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Ubezpieczenie'),
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_UBEZPIECZENIE,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_KURIER_UBEZPIECZENIE . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_KURIER_UBEZPIECZENIE . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex_2021_kurier toggle_rows',
                ),

                array(
                    'type' => 'select',
                    'label' => $this->l('Wartość ubezpieczenia'),
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_WARTOSC_UBEZPIECZENIA,
                    'options' => array(
                        'query' => PocztaPolskaEn::getWartoscUbezpieczenia(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_pocztex_2021_kurier toggle_combo ' . PPPackage::PP_POCZTEX_2021_KURIER_UBEZPIECZENIE . ' 1',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_OKRESLONA_WARTOSC,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('określona wartość'),
                    'form_group_class' => 'pp_pocztex_2021_kurier ' .  PPPackage::PP_POCZTEX_2021_KURIER_UBEZPIECZENIE . ' 1 ' . PPPackage::PP_POCZTEX_2021_KURIER_WARTOSC_UBEZPIECZENIA . ' okreslona_wartosc',
                    'suffix' => 'zł'
                ),
                array(
                    'type' => 'switch',
                    'tab' => 'services',
                    'label' => $this->l('Potwierdzenie doręczenia'),
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_POTWIERDZENIE_DORECZENIA,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_KURIER_POTWIERDZENIE_DORECZENIA . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_KURIER_POTWIERDZENIE_DORECZENIA . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex_2021_kurier toggle_rows',
                ),
                array(
                    'type' => 'select',
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_POTWIERDZENIE_DORECZENIA_TYPE,
                    'label' => $this->l('Typ potwierdzenia doręczenia'),
                    'options' => array(
                        'query' => PocztaPolskaEn::getTypPotwierdzenia(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_pocztex_2021_kurier '.PPPackage::PP_POCZTEX_2021_KURIER_POTWIERDZENIE_DORECZENIA.' 1',
                    'tab' => 'services',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_POTWIERDZENIE_DORECZENIA_KONTAKT,
                    'label' => $this->l('Dane do potwierdzenia doręczenia'),
                    'form_group_class' => 'pp_pocztex_2021_kurier '.PPPackage::PP_POCZTEX_2021_KURIER_POTWIERDZENIE_DORECZENIA.' 1',
                    'tab' => 'services',
                    'class' => 'fixed-width-xxl',
                    'maxlength' => 50,
                    'desc' => $this->l('Określenie dodatkowych informacji związanych ze sposobem przekazania potwierdzenia doręczenia, np. numer telefonu, na który zostanie wysłany SMS, lub adres email'),
                ),
            )
        );
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('RODZAJ') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_pocztex_2021_kurier col-lg-5',
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Pobranie'),
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_POBRANIE,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_KURIER_POBRANIE . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_KURIER_POBRANIE . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex_2021_kurier toggle_rows',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_KWOTA_POBRANIA,
                    'label' => $this->l('Kwota pobrania'),
                    'form_group_class' => 'pp_pocztex_2021_kurier '.PPPackage::PP_POCZTEX_2021_KURIER_POBRANIE.' 1',
                    'class' => 'fixed-width-xl',
                    'suffix' => 'zł',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_NUMER_RACHUNKU,
                    'label' => $this->l('Numer rachunku pobrania'),
                    'form_group_class' => 'pp_pocztex_2021_kurier '.PPPackage::PP_POCZTEX_2021_KURIER_POBRANIE.' 1',
                    'class' => 'fixed-width-xl',
                    'desc' => $this->l('Numer rachunku pobrania bez spacji')
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_TYTUL_POBRANIA,
                    'label' => $this->l('Tytuł pobrania'),
                    'class' => 'fixed-width-xl',
                    'form_group_class' => 'pp_pocztex_2021_kurier '.PPPackage::PP_POCZTEX_2021_KURIER_POBRANIE.' 1',
                    //'desc' => $this->l('W tytule można użyć zmiennych <br>- {id_order} - numer zamóweniaw bazie  danych (np 1,2,3...)<br>- {id_order_number} - zamaskowany numer zamówienia (np:ABCBVWEZ)'),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Sprawdzenie zawartości przez odbiorcę'),
                    'name' => PPPackage::PP_POCZTEX_2021_KURIER_ODBIORCA,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_KURIER_ODBIORCA . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_KURIER_ODBIORCA . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex_2021_kurier '.PPPackage::PP_POCZTEX_2021_KURIER_ODBIOR_W_PUNKCIE . ' 0',
                ),
            )
        );


#POCZTEX 2021 DZIŚ
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('ATRYBUTY') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_pocztex_2021_dzis col-lg-6',
            'input' => array(
                array(
                    'type' => 'select',
                    'label' => $this->l('Format'),
                    'name' => PPPackage::PP_POCZTEX_2021_DZIS_FORMAT,
                    'options' => array(
                        'query' => PocztaPolskaEn::getFormats(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_pocztex_2021_dzis '.PPPackage::PP_POCZTEX_2021_DZIS_OBSZAR.' MIASTO',
                ),
                array(
                    'type' => 'textarea',
                    'name' => PPPackage::PP_POCZTEX_2021_DZIS_OPIS_PRZESYLKI,
                    'label' => $this->l('Opis przesyłki'),
                    'form_group_class' => 'pp_pocztex_2021_dzis',
                    'class' => 'fixed-width-xxl',
                    'maxlength' => 500
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Obszar doręczenia'),
                    'name' => PPPackage::PP_POCZTEX_2021_DZIS_OBSZAR,
                    'options' => array(
                        'query' => PocztaPolskaEn::getTypObszaru(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_pocztex_2021_dzis toggle_combo',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Odległość doręczenia'),
                    'name' => PPPackage::PP_POCZTEX_2021_DZIS_ODLEGLOSC,
                    'form_group_class' => 'pp_pocztex_2021_dzis '.PPPackage::PP_POCZTEX_2021_DZIS_OBSZAR.' MIASTO',
                    'suffix' => $this->l('km'),
                ),

                array(
                    'type' => 'select',
                    'label' => $this->l('Zawartość przesyłki'),
                    'name' => PPPackage::PP_POCZTEX_2021_DZIS_TYP_ZAWARTOSCI,
                    'options' => array(
                        'query' => PocztaPolskaEn::getTypZawartosci(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_pocztex_2021_dzis toggle_combo',
                    'tab' => 'services'
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_2021_DZIS_TYP_ZAWARTOSCI_INNE,
                    'label' => $this->l('Zawartość szczegóły'),
                    'form_group_class' => 'pp_pocztex_2021_dzis ' . PPPackage::PP_POCZTEX_2021_DZIS_TYP_ZAWARTOSCI . ' INNE',
                    'tab' => 'services',
                    'class' => 'fixed-width-xxl',
                ),
            )
        );
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('OPCJE USŁUGI') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_pocztex_2021_dzis col-lg-6',
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Wielopaczkowość'),
                    'name' => PPPackage::PP_POCZTEX_2021_DZIS_WIELOPACZKOWOSC,
                    //'disabled' => (version_compare(PHP_VERSION, '7.0.0', '<') ? false : true),
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_DZIS_WIELOPACZKOWOSC . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_DZIS_WIELOPACZKOWOSC . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex_2021_dzis toggle_rows  '.PPPackage::PP_POCZTEX_2021_DZIS_OBSZAR.' KRAJ',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Ilość'),
                    'class' => 'fixed-width-xxl',
                    'name' => PPPackage::PP_POCZTEX_2021_DZIS_WIELOPACZKOWOSC_ILOSC,
                    'form_group_class' => 'pp_pocztex_2021_dzis ' . PPPackage::PP_POCZTEX_2021_DZIS_WIELOPACZKOWOSC . ' 1',
                    'suffix' => $this->l('szt.'),
                )
            )
        );
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('Usługi dodatkowe / Niestandardowe') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_pocztex_2021_dzis col-lg-7',
            'input' => array(
                array(
                    'type' => 'checkbox',
                    'col' => 12,
                    'hide_label' => true,
                    'name' => PPPackage::PP_POCZTEX_2021_DZIS_OSTROZNIE,
                    'values' => array(
                        'query' => array(
                            array('id' => PPPackage::PP_POCZTEX_2021_DZIS_OSTROZNIE, 'name' => $this->l('Ostrożnie'), 'val' => '1'),
                            array('id' => PPPackage::PP_POCZTEX_2021_DZIS_ODBIOR_SOBOTA, 'name' => $this->l('Odbiór w sobotę'), 'val' => '1'),
                        ),
                        'id' => 'id',
                        'name' => 'name'
                    ),
                    'form_group_class' => 'pp_pocztex_2021_dzis',
                ),

                array(
                    'type' => 'switch',
                    'label' => $this->l('Deklaracja wartości'),
                    'name' => PPPackage::PP_POCZTEX_2021_DZIS_DEKLARACJA_WARTOSCI,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_DZIS_DEKLARACJA_WARTOSCI . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_DZIS_DEKLARACJA_WARTOSCI . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex_2021_dzis toggle_rows',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_2021_DZIS_WARTOSC_ZL,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('Wartość'),
                    'form_group_class' => 'pp_pocztex_2021_dzis ' . PPPackage::PP_POCZTEX_2021_DZIS_DEKLARACJA_WARTOSCI . ' 1',
                    'tab' => 'services',
                    'suffix' => 'zł',
                ),
                array(
                    'type' => 'text',
                    'label' => $this->l('Waga'),
                    'name' => PPPackage::PP_POCZTEX_2021_DZIS_MASA,
                    'class' => 'fixed-width-xxl',
                    'form_group_class' => 'pp_pocztex_2021_dzis',
                    'suffix' => 'kg',
                    //'desc' => $this->l('W przypadku wartości pustej wartość zostanie pobrana z zamówienia')
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Ubezpieczenie'),
                    'name' => PPPackage::PP_POCZTEX_2021_DZIS_UBEZPIECZENIE,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_DZIS_UBEZPIECZENIE . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_DZIS_UBEZPIECZENIE . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex_2021_dzis toggle_rows',
                ),

                array(
                    'type' => 'select',
                    'label' => $this->l('Wartość ubezpieczenia'),
                    'name' => PPPackage::PP_POCZTEX_2021_DZIS_WARTOSC_UBEZPIECZENIA,
                    'options' => array(
                        'query' => PocztaPolskaEn::getWartoscUbezpieczenia(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_pocztex_2021_dzis toggle_combo ' . PPPackage::PP_POCZTEX_2021_DZIS_UBEZPIECZENIE . ' 1',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_2021_DZIS_OKRESLONA_WARTOSC,
                    'class' => 'fixed-width-xxl',
                    'label' => $this->l('określona wartość'),
                    'form_group_class' => 'pp_pocztex_2021_dzis ' . PPPackage::PP_POCZTEX_2021_DZIS_UBEZPIECZENIE . ' 1 ' . PPPackage::PP_POCZTEX_2021_DZIS_WARTOSC_UBEZPIECZENIA . ' okreslona_wartosc',
                    'suffix' => 'zł'
                ),
                array(
                    'type' => 'switch',
                    'tab' => 'services',
                    'label' => $this->l('Potwierdzenie doręczenia'),
                    'name' => PPPackage::PP_POCZTEX_2021_DZIS_POTWIERDZENIE_DORECZENIA,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_DZIS_POTWIERDZENIE_DORECZENIA . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_DZIS_POTWIERDZENIE_DORECZENIA . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex_2021_dzis toggle_rows',
                ),
                array(
                    'type' => 'select',
                    'name' => PPPackage::PP_POCZTEX_2021_DZIS_POTWIERDZENIE_DORECZENIA_TYPE,
                    'label' => $this->l('Typ potwierdzenia doręczenia'),
                    'options' => array(
                        'query' => PocztaPolskaEn::getTypPotwierdzenia(),
                        'id' => 'id',
                        'name' => 'name',
                    ),
                    'form_group_class' => 'pp_pocztex_2021_dzis ' . PPPackage::PP_POCZTEX_2021_DZIS_POTWIERDZENIE_DORECZENIA . ' 1',
                    'tab' => 'services',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_2021_DZIS_POTWIERDZENIE_DORECZENIA_KONTAKT,
                    'label' => $this->l('Dane do potwierdzenia doręczenia'),
                    'form_group_class' => 'pp_pocztex_2021_dzis ' . PPPackage::PP_POCZTEX_2021_DZIS_POTWIERDZENIE_DORECZENIA . ' 1',
                    'tab' => 'services',
                    'class' => 'fixed-width-xxl',
                    'maxlength' => 50,
                    'desc' => $this->l('Określenie dodatkowych informacji związanych ze sposobem przekazania potwierdzenia doręczenia, np. numer telefonu, na który zostanie wysłany SMS, lub adres email'),
                ),
            )
        );
        $fields_form[]['form'] = array(
            'legend' => array(
                'title' => '<b>' . $this->l('RODZAJ') . '</b><hr>',
            ),
            'panelClass' => 'toggle_panel pp_pocztex_2021_dzis col-lg-5',
            'input' => array(
                array(
                    'type' => 'switch',
                    'label' => $this->l('Pobranie'),
                    'name' => PPPackage::PP_POCZTEX_2021_DZIS_POBRANIE,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_DZIS_POBRANIE . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_DZIS_POBRANIE . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex_2021_dzis toggle_rows',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_2021_DZIS_KWOTA_POBRANIA,
                    'label' => $this->l('Kwota pobrania'),
                    'form_group_class' => 'pp_pocztex_2021_dzis ' . PPPackage::PP_POCZTEX_2021_DZIS_POBRANIE . ' 1',
                    'class' => 'fixed-width-xl',
                    'suffix' => 'zł',
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_2021_DZIS_NUMER_RACHUNKU,
                    'label' => $this->l('Numer rachunku pobrania'),
                    'form_group_class' => 'pp_pocztex_2021_dzis ' . PPPackage::PP_POCZTEX_2021_DZIS_POBRANIE . ' 1',
                    'class' => 'fixed-width-xl',
                    'desc' => $this->l('Numer rachunku pobrania bez spacji')
                ),
                array(
                    'type' => 'text',
                    'name' => PPPackage::PP_POCZTEX_2021_DZIS_TYTUL_POBRANIA,
                    'label' => $this->l('Tytuł pobrania'),
                    'class' => 'fixed-width-xl',
                    'form_group_class' => 'pp_pocztex_2021_dzis ' . PPPackage::PP_POCZTEX_2021_DZIS_POBRANIE . ' 1',
                    //'desc' => $this->l('W tytule można użyć zmiennych <br>- {id_order} - numer zamóweniaw bazie  danych (np 1,2,3...)<br>- {id_order_number} - zamaskowany numer zamówienia (np:ABCBVWEZ)'),
                ),
                array(
                    'type' => 'switch',
                    'label' => $this->l('Sprawdzenie zawartości przez odbiorcę'),
                    'name' => PPPackage::PP_POCZTEX_2021_DZIS_ODBIORCA,
                    'values' => array(
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_DZIS_ODBIORCA . '_on',
                            'value' => 1
                        ),
                        array(
                            'id' => PPPackage::PP_POCZTEX_2021_DZIS_ODBIORCA . '_off',
                            'value' => 0
                        )
                    ),
                    'form_group_class' => 'pp_pocztex_2021_dzis',
                ),
            )
        );


        return $fields_form;
    }

    /**
     * metoda umozliwiaja tlumaczenie labeli
     *
     * @param $string - nazwa labela do tlumaczenia
     * @param string $class
     * @param bool $addslashes
     * @param bool $htmlentities
     * @return mixed
     */
    protected function l($string, $class = null, $addslashes = false, $htmlentities = true) {
        return Translate::getAdminTranslation($string, 'PPPackage', $addslashes, $htmlentities);
    }

}
