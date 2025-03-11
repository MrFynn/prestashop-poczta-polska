<?php

require_once(__DIR__ . '/AdminPocztaPolskaController.php');
/**
 * Klasa odpowiadajaca za obsluge zamawiania kuriera
 */
class AdminPocztaPolskaCouriersController extends AdminPocztaPolskaController {

    public function __construct() {
        parent::__construct();
        $this->module = Module::getInstanceByName('pocztapolskaen');
        $this->bootstrap = true;
        $this->context = Context::getContext();
        $this->table = 'pp_courier';
        $this->list_id = 'pp_courier';
        $this->identifier = 'id_pp_courier';
        $this->className = 'PPCourier';
        $this->lang = true;
        $this->_defaultOrderBy = '';
        $this->display = 'add';
        $this->multiple_fieldsets = true;
        $this->page_header_toolbar_title = $this->l('Dodaj nowe zamówienie');
        $this->_prepareFormFields();
    }

    /**
     * Metoda odpowiedzialna za przygotowanie pol formularza
     */
    protected function _prepareFormFields() {
        $this->fields_form[0] = array(
            'form' => array(
                'panelClass' => 'col-lg-12',
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Szacowana masa przesyłek'),
                        'name' => 'shipment_mass',
                        'required' => true,
                        'class' => 'fixed-width-xxl',
                        'col' => '9',
                        'suffix' => 'kg',
                    ),
                    array(
                        'type' => 'date',
                        'label' => $this->l('Data odbioru'),
                        'name' => 'receipt_date',
                        'maxlength' => 10,
                        'required' => true,
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Szacowana ilość przesyłek'),
                        'name' => 'shipment_quantity',
                        'class' => 'fixed-width-xxl',
                        'required' => true,
                        'col' => '9',
                    ),
                    array(
                        'type' => 'select',
                        'label' => $this->l('Oczekiwana godzina odbioru'),
                        'name' => 'receipt_hour',
                        'required' => true,
                        'col' => '9',
                        'default_value' => 0,
                        'options' => array(
                            'query' => PocztaPolskaEn::getReceptionTime(),
                            'id' => 'id',
                            'name' => 'name'
                        ),
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Adres email do potwierdzenia kuriera'),
                        'name' => 'confirm_email',
                        'class' => 'fixed-width-xxl',
                        'col' => '9',
                        'required' => true,
                    ),
                ),
            ),
        );
        $this->fields_form[1] = array(
            'form' => array(
                'panelClass' => 'col-lg-6',
                'legend' => array(
                    'title' => $this->l('Nadawca'),
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Nazwa'),
                        'name' => 'sender_name',
                        'required' => true,
                        'col' => '9',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Ulica'),
                        'name' => 'sender_street',
                        'required' => true,
                        'col' => '9',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Numer domu'),
                        'name' => 'sender_home_number',
                        'col' => '9',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Numer mieszkania'),
                        'name' => 'sender_local_number',
                        'col' => '9',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Kod pocztowy'),
                        'name' => 'sender_postal_code',
                        'required' => true,
                        'col' => '9',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Miejscowość'),
                        'name' => 'sender_place',
                        'required' => true,
                        'col' => '9',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Kraj'),
                        'name' => 'sender_country',
                        'required' => true,
                        'col' => '9',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Email'),
                        'name' => 'sender_email',
                        'col' => '9',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Telefon kom'),
                        'name' => 'sender_mobile_phone',
                        'col' => '9',
                    ),
                )
            ),
        );
        $this->fields_form[2] = array(
            'form' => array(
                'panelClass' => 'col-lg-6',
                'legend' => array(
                    'title' => $this->l('Miejsce odbioru'),
                ),
                'input' => array(
                    array(
                        'type' => 'text',
                        'label' => $this->l('Nazwa'),
                        'name' => 'customer_name',
                        'required' => true,
                        'col' => '9',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Ulica'),
                        'name' => 'customer_street',
                        'required' => true,
                        'col' => '9',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Numer domu'),
                        'name' => 'customer_home_number',
                        'col' => '9',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Numer mieszkania'),
                        'name' => 'customer_local_number',
                        'col' => '9',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Kod pocztowy'),
                        'name' => 'customer_postal_code',
                        'required' => true,
                        'col' => '9',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Miejscowość'),
                        'name' => 'customer_place',
                        'required' => true,
                        'col' => '9',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Kraj'),
                        'name' => 'customer_country',
                        'required' => true,
                        'col' => '9',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Email'),
                        'name' => 'customer_email',
                        'col' => '9',
                    ),
                    array(
                        'type' => 'text',
                        'label' => $this->l('Telefon kom'),
                        'name' => 'customer_mobile_phone',
                        'col' => '9',
                    ),
                ),
            ),
        );
        $this->fields_form[3] = array(
            'form' => array(
                'panelClass' => 'col-lg-12',
                'submit' => array(
                    'title' => $this->l('Wyślij'),
                )
            ),
        );
        $this->fields_value = array(
            'receipt_date' => date('Y-m-d'),
        );
        $this->base_tpl_form = 'views/templates/admin/controllers/couriers/form.tpl';
    }

    /**
     * Metoda odpowiedzialna za renderowanie formularza
     */
    public function renderForm() {
        if (!$this->default_form_language) {
            $this->getLanguages();
        }

        if (Tools::getValue('submitFormAjax')) {
            $this->content .= $this->context->smarty->fetch('form_submit_ajax.tpl');
        }

        if ($this->fields_form && is_array($this->fields_form)) {
            if (!$this->multiple_fieldsets) {
                $this->fields_form = array(array('form' => $this->fields_form));
            }

            // For add a fields via an override of $fields_form, use $fields_form_override
            if (is_array($this->fields_form_override) && !empty($this->fields_form_override)) {
                $this->fields_form[0]['form']['input'] = array_merge($this->fields_form[0]['form']['input'], $this->fields_form_override);
            }

            $fields_value = $this->getFieldsValue($this->object);

            Hook::exec('action' . $this->controller_name . 'FormModifier', array(
                'fields' => &$this->fields_form,
                'fields_value' => &$fields_value,
                'form_vars' => &$this->tpl_form_vars,
            ));

            $helper = new HelperForm($this);
            $helper->base_folder = _PS_MODULE_DIR_ . $this->module->name . DIRECTORY_SEPARATOR;
            $this->setHelperDisplay($helper);
            $helper->fields_value = $fields_value;
            $helper->submit_action = $this->submit_action;
            $helper->tpl_vars = $this->getTemplateFormVars();
            $helper->show_cancel_button = (isset($this->show_form_cancel_button)) ? $this->show_form_cancel_button : ($this->display == 'add' || $this->display == 'edit');

            $back = Tools::safeOutput(Tools::getValue('back', ''));
            if (empty($back)) {
                $back = self::$currentIndex . '&token=' . $this->token;
            }
            if (!Validate::isCleanHtml($back)) {
                die(Tools::displayError());
            }

            $helper->back_url = $back;
            !is_null($this->base_tpl_form) ? $helper->base_tpl = $this->base_tpl_form : '';
            if ($this->tabAccess['view']) {
                if (Tools::getValue('back')) {
                    $helper->tpl_vars['back'] = Tools::safeOutput(Tools::getValue('back'));
                } else {
                    $helper->tpl_vars['back'] = Tools::safeOutput(Tools::getValue(self::$currentIndex . '&token=' . $this->token));
                }
            }
            $form = $helper->generateForm($this->fields_form);

            return $form;
        }
    }

    public function setMedia($isNewTheme = false) {
        parent::setMedia();
        $this->addCSS(__PS_BASE_URI__ . 'modules/' . $this->module->name . '/views/templates/admin/css/couriers.css');
    }

    /**
     * Metoda odpowiedzialna za zapis kuriera
     */
    public function processSave() {
        if (!isset($this->className) || empty($this->className)) {
            return false;
        }
        $this->validateRules();
        if (count($this->errors) <= 0) {
            $this->object = new $this->className();

            $this->copyFromPost($this->object, $this->table);
            $this->beforeAdd($this->object);
            if (!$this->object->add()) {
                $this->errors = $this->object->errors;
            }
        }
        $this->display = 'add';
        $this->errors = array_unique($this->errors);
        if (!empty($this->errors)) {

            $temp = $this->errors;
            $this->errors = array();

            foreach ($temp as $error) {
                $this->errors[] = $error;
            }

            return $this->errors;
        }
        $this->redirect_after = self::$currentIndex . '&conf=35&token=' . $this->token;
        return $this->object;
    }

}
