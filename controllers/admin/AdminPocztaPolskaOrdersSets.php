<?php

require_once(__DIR__ . '/AdminPocztaPolskaController.php');

/**
 * Klasa odpowiadajaca za obsulge zbiorow
 */
class AdminPocztaPolskaOrdersSetsController extends AdminPocztaPolskaController {

    public $toolbar_title;
    protected $statuses_array = array();
    protected $actions = array('view','edit', 'delete', 'sendoffice', 'downloadlabel', 'outboxbook', 'transfershipments', 'firmpocztabook', 'setactive');
    protected $actions_available = array('view','edit', 'delete', 'sendoffice', 'downloadlabel', 'outboxbook', 'firmpocztabook', 'transfershipments');
    public $offices_array;

    public function __construct() {
        parent::__construct();

        $this->module = Module::getInstanceByName('pocztapolskaen');
        $this->bootstrap = true;
        $this->table = 'pocztapolskaen_order_set';
        $this->className = 'PPOrderSet';
        $this->lang = false;
        $this->explicitSelect = true;
        $this->allow_export = false;
        $this->context = Context::getContext();
        $this->identifier = 'id_order_set';
        $offices = PPPostOffice::getCollection();
        foreach ($offices as $office) {
            $this->offices_array[$office->id_post_office] = $office->name;
        }
        $this->_prepareListQuery();
        $this->_prepareFieldsForm();
        $this->_prepareListFields();

    }
    public function postProcess() {
        if ($this->action == 'view') {
            $href = Context::getContext()->link->getAdminLink('AdminPocztaPolskaOrdersSetsView', true);
            $href .= '&' . $this->identifier . '=' . Tools::getValue($this->identifier);
            Tools::redirectAdmin($href);
            return;
        }
        return parent::postProcess();
    }
    /**
     * Metoda odpowiedzialna za knstrukcje zapytania sql listy
     */
    protected function _prepareListQuery() {
        $this->_select = 'a.`name`,a.`id_envelope`,if(a.active = 1 && a.id_envelope is null,"highlighted","") as class, a.post_date,a.`envelope_status`,po.`name` as post_office,count(*) as shipment_count';
        $this->_join = 'LEFT JOIN `' . _DB_PREFIX_ .'pocztapolskaen_order` o ON o.`id_buffor` = a.`id_en`
                        LEFT JOIN `' . _DB_PREFIX_ . 'pocztapolskaen_post_office` po ON (po.`id_post_office` = a.`id_post_office`)';
        $this->_orderBy = 'a.post_date';
        $this->_group = 'GROUP BY a.id_en';
        $this->_orderWay = 'DESC';
        $this->_use_found_rows = true;
    }

    /**
     * Metoda odpowiedzialna za przygotowanie kolumn listy
     */
    protected function _prepareListFields() {
        $statuses = ENadawca::Envelope()->getStatuses();
        $this->fields_list = array(
            'id_order_set' => array(
                'title' => $this->l('ID'),
                'align' => 'text-center',
                'class' => 'fixed-width-xs'
            ),
            'name' => array(
                'title' => $this->l('Nazwa'),
                'havingFilter' => true,
            ),
            'shipment_count' => array(
                'title' => $this->l('Ilość przesyłek'),
                'havingFilter' => true,
            ),
            'envelope_status' => array(
                'title' => $this->l('Status'),
                'type' => 'select',
                'filter_key' => 'a!envelope_status',
                'list' => is_array($statuses)?$statuses:array()
            ),
            'post_office' => array(
                'title' => $this->l('Urząd nadania'),
                'type' => 'select',
                'filter_key' => 'po!id_post_office',
                'list' => is_array($this->offices_array)?$this->offices_array:array(),
            ),
            'post_date' => array(
                'title' => $this->l('Data nadania'),
                'filter_key' => 'a!post_date',
                'type' => 'date',
            ),
        );
    }

    /**
     * Metoda odpowiedzialna za przygotowanie pol formularza
     */
    protected function _prepareFieldsForm() {
        $this->fields_form = array(
            'legend' => array(
                'title' => $this->l('Zbiór'),
            ),
            'input' => array(
                array(
                    'type' => 'text',
                    'label' => $this->l('Nazwa zbioru'),
                    'name' => 'name',
                    'required' => true,
                    'col' => '8',
                ),
                array(
                    'type' => 'date',
                    'label' => $this->l('Planowana data nadania'),
                    'name' => 'post_date',
                    'maxlength' => 10,
                    'required' => true,
                ),
                array(
                    'type' => 'select',
                    'label' => $this->l('Urząd nadania'),
                    'name' => 'id_post_office',
                    'required' => true,
                    'col' => '8',
                    'options' => array(
                        'query' => PPPostOffice::getCollection(true),
                        'id' => 'id',
                        'name' => 'name'
                    ),
                ),
                array(
                    'type' => 'hidden',
                    'name' => 'set_date',
                ),
                array(
                    'type' => 'hidden',
                    'name' => 'change_parcels',
                ),
            ),
            'submit' => array(
                'title' => $this->l('Zapisz'),
                'id' =>'OrderSetSave'
            )
        );
    }

    /**
     * Metoda odpowiedzialana za generowanie listy jaka ma sie wyswietlic
     */
    public function renderList() {
        if (!($this->fields_list && is_array($this->fields_list))) {
            return false;
        }
        if (!isset($this->context->cookie->pocztapolska_en_reload_data_ts) || time() >= $this->context->cookie->pocztapolska_en_reload_data_ts) {
            $expiredSets = PPOrderSet::getExpired('name');
            PPPostOffice::reloadData();
            PPOrderSet::reloadData(true);
            PPProfileAddress::reloadData();
            $this->context->cookie->pocztapolska_en_reload_data_ts = time() + PocztaPolskaEn::RELOAD_DATA_INTERVAL;
            if (!empty($expiredSets)) {
                $this->displayWarning(sprintf($this->l('Następujące zbiory zostały usunięte, ponieważ ich data nadania była starsza niż %s dni: %s'), PocztaPolskaEn::SET_EXPIRED_DAYS, implode(', ', $expiredSets)));
            }
        }

        $this->getList($this->context->language->id);

        // If list has 'active' field, we automatically create bulk action
        if (isset($this->fields_list) && is_array($this->fields_list) && array_key_exists('active', $this->fields_list) && !empty($this->fields_list['active'])) {
            if (!is_array($this->bulk_actions)) {
                $this->bulk_actions = array();
            }

            $this->bulk_actions = array_merge(array(
                'enableSelection' => array(
                    'text' => $this->l('Enable selection'),
                    'icon' => 'icon-power-off text-success'
                ),
                'disableSelection' => array(
                    'text' => $this->l('Disable selection'),
                    'icon' => 'icon-power-off text-danger'
                ),
                'divider' => array(
                    'text' => 'divider'
                )
                    ), $this->bulk_actions);
        }
        $helper = new HelperList();
        $helper->module = $this->module;
        // Empty list is ok
        if (!is_array($this->_list)) {
            $this->displayWarning($this->l('Bad SQL query', 'Helper') . '<br />' . htmlspecialchars($this->_list_error));
            return false;
        }

        $this->setHelperDisplay($helper);
        $helper->_default_pagination = $this->_default_pagination;
        $helper->_pagination = $this->_pagination;
        $helper->tpl_vars = $this->getTemplateListVars();
        $helper->tpl_delete_link_vars = $this->tpl_delete_link_vars;

        // For compatibility reasons, we have to check standard actions in class attributes
        foreach ($this->actions_available as $action) {
            if (!in_array($action, $this->actions) && isset($this->$action) && $this->$action) {
                $this->actions[] = $action;
            }
        }

        $helper->is_cms = $this->is_cms;
        $helper->sql = false;
        $list = $helper->generateList($this->_list, $this->fields_list);

        return $list;
    }

    /**
     * Metoda odpowiedzialna za wysyłanie przesyłek
     */
    public function processSendoffice() {
        if (Validate::isLoadedObject($object = $this->loadObject())) {
            $postOffice = $object->getPostOffice();
            $envelope = ENadawca::Envelope();
            if(PPSetting::dateDiff('now',$object->post_date) >=0){
                if (!empty($postOffice)) {
                    $result = $envelope->send($postOffice->id_en, $object->id_en);
                    if ($envelope->hasErrors()) {
                        $this->errors = $envelope->getErrors();
                    } else {
                        $object->id_envelope = $result['idEnvelope'];
                        $object->envelope_status = strtolower($result['envelopeStatus']);
                        $object->save();
                        $ppOrders = $object->getOrdersByBuffor($object->id_en);
                        foreach ($ppOrders as $ppOrder) {
                            $ppOrder->setOrderStatus(PPSetting::PP_STATUS_OFFICE_SEND);
                            $ppOrder->post_date = $object->post_date;
                            $ppOrder->save();
                        }
                        PPOrderSet::reloadData();
                        $this->redirect_after = self::$currentIndex . '&conf=33&id_buffor='.$object->id.'&token=' . $this->token;
                    }
                }
            } else {
                $this->errors[] = $this->l('Data nadania do urzędu nie może być wsteczna. Przejdź od edycji obiektu i zmień datę nadania');
            }

        } else {
            $this->errors[] = Tools::displayError($this->l('An error occurred while updating an object.')) .
                    ' <b>' . $this->table . '</b> ' . Tools::displayError($this->l('(cannot load object)'));
        }
    }

    /**
     * Metoda odpowiadajaca za pobranie pojedynczej etykiety
     */
    public function processDownloadLabel() {
        if (Validate::isLoadedObject($object = $this->loadObject())) {
            $pdf = ENadawca::PdfContent();
            $guids = $object->getOrdersGuidsByBuffor($object->id_en);
            $content = $pdf->getPrintForParcel($guids);
            //$content = $pdf->getAddresLabelCompact($object->id_envelope);
            if ($pdf->hasErrors()) {
                $this->errors = $pdf->getErrors();
            } else {
                $ppOrders = $object->getOrdersByBuffor($object->id_en);
                foreach ($ppOrders as $ppOrder) {
                    $ppOrder->setOrderStatus(PPSetting::PP_STATUS_PRINT_LABEL);
                }
                header('Content-type: application/pdf');
                header('Content-Disposition: attachment; filename="Nalepka_adresowa.pdf"');
                echo $content;
                exit;
            }
        }
    }

    /**
     * Metoda odpowiadajaca za pobranie pojedynczej poczty firmowej
     */
    public function processFirmpocztabook() {
        if (Validate::isLoadedObject($object = $this->loadObject())) {
            $pdf = ENadawca::PdfContent();
            $content = $pdf->getFirmowaPocztaBook($object->id_envelope);
            if ($pdf->hasErrors()) {
                $this->errors = $pdf->getErrors();
            } else {
                header('Content-type: application/pdf');
                header('Content-Disposition: attachment; filename="Poczta_firmowa.pdf"');
                echo $content;
                exit;
            }
        }
    }

    /**
     * Metoda odpowiadajaca za konstrukcje linku do pobrania poczty firmowej
     */
    public function displayFirmpocztabookLink($token = null, $id) {
        if (!array_key_exists('firmpocztabook', self::$cache_lang)) {
            self::$cache_lang['firmpocztabook'] = $this->l('Poczta firmowa');
        }
        if (!isset($this->_envelopes[$id])) {
            return '';
        }
        $this->context->smarty->assign(array(
            'href' => self::$currentIndex .
            '&' . $this->identifier . '=' . $id .
            '&action=firmpocztabook&token=' . ($token != null ? $token : $this->token),
            'action' => self::$cache_lang['firmpocztabook'],
        ));

        return $this->context->smarty->fetch('helpers/list/list_action_default.tpl');
    }

    public function displaySetactiveLink($token = null, $id) {
        if (!array_key_exists('setactive', self::$cache_lang)) {
            self::$cache_lang['setactive'] = $this->l('Ustaw jako domyślny');
        }
        if (!isset($this->_envelopes[$id])) {
            $this->context->smarty->assign(array(
                'href' => self::$currentIndex .
                    '&' . $this->identifier . '=' . $id .
                    '&action=setactive&token=' . ($token != null ? $token : $this->token),
                'action' => self::$cache_lang['setactive'],
            ));
        } else {
            return '';
        }


        return $this->context->smarty->fetch('helpers/list/list_action_default.tpl');
    }

    /**
     * metoda odpowiedzialna za ustawienia wybranego zbioru jako aktywnego
     */
    public function processSetactive(){
        if (Validate::isLoadedObject($object = $this->loadObject())) {
            $active = $object::getActiveCollection();
            $buffor = $active->getFirst();

            if(is_object($buffor)){
                $buffor->active = 0;
                $buffor->update();
            }
            $object->active = 1;
            $object->update();
        }
    }

    /**
     * Metoda odpowiadajaca za pobranie ksiazki nadawczej
     */
    public function processOutboxBook() {
        if (Validate::isLoadedObject($object = $this->loadObject())) {
            $pdf = ENadawca::PdfContent();
            $content = $pdf->getOutboxBook($object->id_envelope);
            if ($pdf->hasErrors()) {
                $this->errors = $pdf->getErrors();
            } else {
                header('Content-type: application/pdf');
                header('Content-Disposition: attachment; filename="Ksiazka_nadawcza.pdf"');
                echo $content;
                exit;
            }
        }
    }

    /**
     * Metoda odpowiadajaca za konstrukcje linku do pobrania ksiazki nadawczej
     */
    public function displayOutboxbookLink($token = null, $id) {
        if (!array_key_exists('outboxbook', self::$cache_lang)) {
            self::$cache_lang['outboxbook'] = $this->l('Książka nadawcza');
        }
        if (!isset($this->_envelopes[$id])) {
            return '';
        }
        $this->context->smarty->assign(array(
            'href' => self::$currentIndex .
            '&' . $this->identifier . '=' . $id .
            '&action=outboxbook&token=' . ($token != null ? $token : $this->token),
            'action' => self::$cache_lang['outboxbook'],
        ));

        return $this->context->smarty->fetch('helpers/list/list_action_default.tpl');
    }

    /**
     * Metoda odpowiadajaca za konstrukcje linku do przenoszenia przesyłek
     */
    public function displayTransfershipmentsLink($token = null, $id) {
        if (!array_key_exists('transfershipments', self::$cache_lang)) {
            self::$cache_lang['transfershipments'] = $this->l('Przenieś przesyłki');
        }
        if (isset($this->_envelopes[$id])) {
            return '';
        }
        $href = Context::getContext()->link->getAdminLink('AdminPocztaPolskaTransferSets', true);
        $this->context->smarty->assign(array(
            'href' => $href .
            '&' . $this->identifier . '=' . $id,
            'action' => self::$cache_lang['transfershipments'],
        ));

        return $this->context->smarty->fetch('helpers/list/list_action_default.tpl');
    }

    /**
     * Metoda odpowiadajaca za konstrukcje linku do wysylki przesyłek do urzendu
     */
    public function displaySendofficeLink($token = null, $id) {
        if (!array_key_exists('sendoffice', self::$cache_lang)) {
            self::$cache_lang['sendoffice'] = $this->l('Wyślij do urzędu');
        }
        if (isset($this->_envelopes[$id])) {
            return '';
        }
        if ($this->_shipments[$id]['shipment_count'] <= 0) {
            return '';
        }
        $this->context->smarty->assign(array(
            'href' => self::$currentIndex .
            '&' . $this->identifier . '=' . $id .
            '&action=sendoffice&token=' . ($token != null ? $token : $this->token),
            'action' => self::$cache_lang['sendoffice'],
        ));

        return $this->context->smarty->fetch('helpers/list/list_action_default.tpl');
    }

    /**
     * Metoda odpowiadajaca za konstrukcje linku do pobieranie etykiety
     */
    public function displayDownloadlabelLink($token = null, $id) {
        if (!array_key_exists('downloadlabel', self::$cache_lang)) {
            self::$cache_lang['downloadlabel'] = $this->l('Pobierz etykiete');
        }
        if (!isset($this->_envelopes[$id])) {
            return '';
        }
        $this->context->smarty->assign(array(
            'href' => self::$currentIndex .
            '&' . $this->identifier . '=' . $id .
            '&action=downloadlabel&token=' . ($token != null ? $token : $this->token),
            'action' => self::$cache_lang['downloadlabel'],
        ));

        return $this->context->smarty->fetch('helpers/list/list_action_default.tpl');
    }

    /**
     * Metoda odpowiadajaca za dodanie nowego zbioru
     */
    public function processAdd() {

        if (!isset($this->className) || empty($this->className)) {
            return false;
        }

        $this->validateRules();
        if (count($this->errors) <= 0) {
            $this->object = new $this->className();

            $this->copyFromPost($this->object, $this->table);
            $this->beforeAdd($this->object);
            if (!$this->object->addEnvelopeBuffor()) {
                $this->errors = $this->object->_errors;
                $this->display = 'edit';
                return false;
            }
            if (method_exists($this->object, 'add') && !$this->object->add()) {
                $this->errors[] = Tools::displayError($this->l('An error occurred while creating an object.')) .
                        ' <b>' . $this->table . ' (' . Db::getInstance()->getMsgError() . ')</b>';
            } elseif (($_POST[$this->identifier] = $this->object->id /* voluntary do affectation here */) && $this->postImage($this->object->id) && !count($this->errors) && $this->_redirect) {
                PrestaShopLogger::addLog(sprintf($this->l('%s addition', 'AdminTab', false, false), $this->className), 1, null, $this->className, (int) $this->object->id, true, (int) $this->context->employee->id);
                $parent_id = (int) Tools::getValue('id_parent', 1);
                $this->afterAdd($this->object);
                $this->updateAssoShop($this->object->id);
                // Save and stay on same form
                if (empty($this->redirect_after) && $this->redirect_after !== false && Tools::isSubmit('submitAdd' . $this->table . 'AndStay')) {
                    $this->redirect_after = self::$currentIndex . '&' . $this->identifier . '=' . $this->object->id . '&conf=43&update' . $this->table . '&token=' . $this->token;
                }
                // Save and back to parent
                if (empty($this->redirect_after) && $this->redirect_after !== false && Tools::isSubmit('submitAdd' . $this->table . 'AndBackToParent')) {
                    $this->redirect_after = self::$currentIndex . '&' . $this->identifier . '=' . $parent_id . '&conf=43&token=' . $this->token;
                }
                // Default behavior (save and back)
                if (empty($this->redirect_after) && $this->redirect_after !== false) {
                    $this->redirect_after = self::$currentIndex. '&' . $this->identifier . '=' . $this->object->id . '&conf=43&token=' . $this->token.'&id_en='.$this->object->id_en;
                }
            }
        }

        $this->errors = array_unique($this->errors);
        if (!empty($this->errors)) {
            // if we have errors, we stay on the form instead of going back to the list
            $this->display = 'edit';
            return false;
        }

        return $this->object;
    }

    /**
     * Metoda odpowiadajaca za aktyalizacje zbioru
     */
    public function processUpdate() {
        /* Checking fields validity */
        $this->validateRules();
        if (empty($this->errors)) {
            $id = (int) Tools::getValue($this->identifier);

            /* Object update */
            if (isset($id) && !empty($id)) {
                /** @var ObjectModel $object */
                $object = new $this->className($id);
                if (Validate::isLoadedObject($object)) {
                    $this->copyFromPost($object, $this->table);
                    if (!$object->updateEnvelopeBuffor()) {
                        $this->errors = $object->_errors;
                        $this->display = 'edit';
                        return false;
                    }
                    /* Specific to objects which must not be deleted */
                    if ($this->deleted && $this->beforeDelete($object)) {
                        // Create new one with old objet values
                        /** @var ObjectModel $object_new */
                        $object_new = $object->duplicateObject();
                        if (Validate::isLoadedObject($object_new)) {
                            // Update old object to deleted
                            $object->deleted = 1;
                            $object->update();

                            // Update new object with post values
                            $this->copyFromPost($object_new, $this->table);
                            $result = $object_new->update();
                            if (Validate::isLoadedObject($object_new)) {
                                $this->afterDelete($object_new, $object->id);
                            }
                        }
                    } else {
                        $this->copyFromPost($object, $this->table);
                        $result = $object->update();
                        $this->afterUpdate($object);
                    }

                    if ($object->id) {
                        $this->updateAssoShop($object->id);
                    }

                    if (!$result) {
                        $this->errors[] = Tools::displayError($this->l('An error occurred while updating an object.')) .
                                ' <b>' . $this->table . '</b> (' . Db::getInstance()->getMsgError() . ')';
                    } elseif ($this->postImage($object->id) && !count($this->errors) && $this->_redirect) {
                        $parent_id = (int) Tools::getValue('id_parent', 1);
                        // Specific back redirect
                        if ($back = Tools::getValue('back')) {
                            $this->redirect_after = urldecode($back) . '&conf=44';
                        }
                        // Specific scene feature
                        // @todo change stay_here submit name (not clear for redirect to scene ... )
                        if (Tools::getValue('stay_here') == 'on' || Tools::getValue('stay_here') == 'true' || Tools::getValue('stay_here') == '1') {
                            $this->redirect_after = self::$currentIndex . '&' . $this->identifier . '=' . $object->id . '&conf=44&updatescene&token=' . $this->token;
                        }
                        // Save and stay on same form
                        // @todo on the to following if, we may prefer to avoid override redirect_after previous value
                        if (Tools::isSubmit('submitAdd' . $this->table . 'AndStay')) {
                            $this->redirect_after = self::$currentIndex . '&' . $this->identifier . '=' . $object->id . '&conf=44&update' . $this->table . '&token=' . $this->token;
                        }
                        // Save and back to parent
                        if (Tools::isSubmit('submitAdd' . $this->table . 'AndBackToParent')) {
                            $this->redirect_after = self::$currentIndex . '&' . $this->identifier . '=' . $parent_id . '&conf=4&token=' . $this->token;
                        }

                        // Default behavior (save and back)
                        if (empty($this->redirect_after) && $this->redirect_after !== false) {
                            $this->redirect_after = self::$currentIndex . ($parent_id ? '&' . $this->identifier . '=' . $object->id : '') . '&conf=44&token=' . $this->token;
                        }
                    }
                    PrestaShopLogger::addLog(sprintf($this->l('%s modification', 'AdminTab', false, false), $this->className), 1, null, $this->className, (int) $object->id, true, (int) $this->context->employee->id);
                } else {
                    $this->errors[] = Tools::displayError($this->l('An error occurred while updating an object.')) .
                            ' <b>' . $this->table . '</b> ' . Tools::displayError($this->l('(cannot load object)'));
                }
            }
        }
        $this->errors = array_unique($this->errors);
        if (!empty($this->errors)) {
            // if we have errors, we stay on the form instead of going back to the list
            $this->display = 'edit';
            return false;
        }

        if (isset($object)) {
            return $object;
        }
        return;
    }

    /**
     * Metoda odpowiadajaca za usuwanie zbioru
     */
    public function processDelete() {
        if (Validate::isLoadedObject($object = $this->loadObject())) {
            $res = true;
            // check if request at least one object with noZeroObject
            if (isset($object->noZeroObject) && count(call_user_func(array($this->className, $object->noZeroObject))) <= 1) {
                $this->errors[] = Tools::displayError($this->l('You need at least one object.')) .
                        ' <b>' . $this->table . '</b><br />' .
                        Tools::displayError($this->l('You cannot delete all of the items.'));
            } elseif (array_key_exists('delete', $this->list_skip_actions) && in_array($object->id, $this->list_skip_actions['delete'])) { //check if some ids are in list_skip_actions and forbid deletion
                $this->errors[] = Tools::displayError($this->l('You cannot delete this item.'));
            } else {
                if (!$object->deleteEnvelopeBuffor()) {
                    $this->errors = $object->_errors;
                    return false;
                }
                if ($this->deleted) {
                    if (!empty($this->fieldImageSettings)) {
                        $res = $object->deleteImage();
                    }

                    if (!$res) {
                        $this->errors[] = Tools::displayError($this->l('Unable to delete associated images.'));
                    }

                    $object->deleted = 1;
                    if ($res = $object->update()) {
                        $this->redirect_after = self::$currentIndex . '&conf=41&token=' . $this->token;
                    }
                } elseif ($res = $object->delete()) {
                    PPOrderSet::reloadData();
                    $this->redirect_after = self::$currentIndex . '&conf=41&token=' . $this->token;
                }
                $this->errors[] = Tools::displayError($this->l('An error occurred during deletion.'));
                if ($res) {
                    PrestaShopLogger::addLog(sprintf($this->l('%s deletion', 'AdminTab', false, false), $this->className), 1, null, $this->className, (int) $this->object->id, true, (int) $this->context->employee->id);
                }
            }
        } else {
            $this->errors[] = Tools::displayError($this->l('An error occurred while deleting the object.')) .
                    ' <b>' . $this->table . '</b> ' .
                    Tools::displayError($this->l('(cannot load object)'));
        }
        return $object;
    }

    /**
     * Metoda odpowiadajaca za pobranie danych do wwygenrownia listy
     */
    public function getList($id_lang, $order_by = null, $order_way = null, $start = 0, $limit = null, $id_lang_shop = false) {
        parent::getList($id_lang, $order_by, $order_way, $start, $limit, $id_lang_shop);
        $statuses = ENadawca::Envelope()->getStatuses();
        foreach ($this->_list as &$item) {
            if (!empty($item['id_envelope'])) {
                $this->_envelopes[$item['id_order_set']] = array(
                    'id_envelope' => $item['id_envelope']
                );
            }
            $this->_shipments[$item['id_order_set']] = array(
                'shipment_count' => $item['shipment_count']
            );
            $item['envelope_status'] = isset($statuses[$item['envelope_status']]) ? $statuses[$item['envelope_status']] : $item['envelope_status'];
        }
    }

     /**
     * Metoda odpowiedzialna za konstrukcje url do podglądu zbioru
     */
    public function displayViewLink($token = null, $id) {
        $href = Context::getContext()->link->getAdminLink('AdminPocztaPolskaOrdersSetsView', true);
        $href .= '&' . $this->identifier . '=' . $id;
        if (!array_key_exists('view', self::$cache_lang)) {
            self::$cache_lang['view'] = $this->l('Zobacz');
        }
        $this->context->smarty->assign(array(
            'href' =>  $href,
            'action' => self::$cache_lang['view'],
        ));

        return $this->context->smarty->fetch('helpers/list/list_action_view.tpl');
    }

    /**
     * Metoda odpowiadajaca za konstrukcje liku do edycji zbioru
     */
    public function displayEditLink($token = null, $id, $name = null) {
        if (!array_key_exists('Edit', self::$cache_lang)) {
            self::$cache_lang['Edit'] = $this->l('Edit', 'Helper');
        }
        if (isset($this->_envelopes[$id])) {
            return '';
        }
        $this->context->smarty->assign(array(
            'href' => self::$currentIndex . '&' . $this->identifier . '=' . $id . '&update' . $this->table .'&token=' . ($token != null ? $token : $this->token),
            'action' => self::$cache_lang['Edit'],
            'id' => $id
        ));

        return $this->context->smarty->fetch(_PS_MODULE_DIR_ . $this->module->name . DIRECTORY_SEPARATOR . 'views/templates/admin/list_action_edit.tpl');
    }

    /**
     * Metoda odpowiadajaca za konstrukcje liku do usuwania zbioru
     */
    public function displayDeleteLink($token = null, $id, $name = null) {
        if (!array_key_exists('Delete', self::$cache_lang)) {
            self::$cache_lang['Delete'] = $this->l('Delete', 'Helper');
        }

        if (!array_key_exists('DeleteItem', self::$cache_lang)) {
            self::$cache_lang['DeleteItem'] = $this->l('Delete selected item?', 'Helper', true, false);
        }

        if (!array_key_exists('Name', self::$cache_lang)) {
            self::$cache_lang['Name'] = $this->l('Name:', 'Helper', true, false);
        }
        if (isset($this->_envelopes[$id])) {
            return '';
        }
        if (!is_null($name)) {
            $name = addcslashes('\n\n' . self::$cache_lang['Name'] . ' ' . $name, '\'');
        }

        $data = array(
            $this->identifier => $id,
            'href' => self::$currentIndex . '&' . $this->identifier . '=' . $id . '&delete' . $this->table . '&token=' . ($token != null ? $token : $this->token),
            'action' => self::$cache_lang['Delete'],
        );

        if ($this->specificConfirmDelete !== false) {
            $data['confirm'] = !is_null($this->specificConfirmDelete) ? '\r' . $this->specificConfirmDelete : Tools::safeOutput(self::$cache_lang['DeleteItem'] . $name);
        }

        $this->context->smarty->assign(array_merge($this->tpl_delete_link_vars, $data));

        return $this->context->smarty->fetch(_PS_MODULE_DIR_ . $this->module->name . DIRECTORY_SEPARATOR . 'views/templates/admin/list_action_delete.tpl');
    }

    /**
     * metoda inicjujaca toolbar w adminie dla danego controllera
     *
     * @return mixed
     */
    public function initToolbar() {
        parent::initToolbar();
        $this->toolbar_btn['reload'] = array(
            'href' => self::$currentIndex . '&action=reload&' . $this->table . '&token=' . $this->token,
            'desc' => $this->l('Odśwież'),
            'imgclass' => 'refresh'
        );
        return $this->toolbar_btn;
    }

    /**
     * Metoda odpowiada za powtorne zaladowanie danych z EN - zbiory i urzendy nadania
     */
    public function processReload() {
        $this->context->cookie->pocztapolska_en_reload_data_ts = 0;
        Tools::redirectAdmin(self::$currentIndex . '&token=' . $this->token);
    }

    public function setMedia($isNewTheme = false) {
        parent::setMedia();
        $this->addJS(__PS_BASE_URI__ . 'modules/' . $this->module->name . '/views/templates/admin/js/sets.js');
    }
    public function getFieldsValue($obj) {
        parent::getFieldsValue($obj);

        $this->fields_value['set_date'] = $obj->post_date;

        if(empty($this->fields_value['change_parcels'])) {
            $this->fields_value['change_parcels'] = 0;
        }

        return $this->fields_value ;
    }
}
