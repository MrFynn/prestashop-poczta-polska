<?php

require_once(__DIR__ . '/AdminPocztaPolskaController.php');
require_once(__DIR__ . '/AdminPocztaPolskaTransferSets.php');

class AdminPocztaPolskaOrdersSetsViewController extends AdminPocztaPolskaTransferSetsController {

    /**
     * metoda odpowiedzialna za renderowanie listy w widoku dla controllera
     *
     * @return string
     */
    public function renderList() {
        if (!($this->fields_list && is_array($this->fields_list))) {
            return false;
        }

        $id_order_set = Tools::getValue('id_order_set', '');
        if (empty($id_order_set)) {
            Tools::redirectAdmin(Context::getContext()->link->getAdminLink('AdminPocztaPolskaOrdersSets'));
        }
        $orderSet = new PPOrderSet(Tools::getValue('id_order_set'));
        $this->_where = ' AND o.`id_buffor`=' . $orderSet->id_en;

        $this->page_header_toolbar_title = $this->l('Podgląd przesyłek zbioru').' '.$orderSet->name;

        $this->getList($this->context->language->id);

        // If list has 'active' field, we automatically create bulk action
        if (isset($this->fields_list) && is_array($this->fields_list) && array_key_exists('active', $this->fields_list) && !empty($this->fields_list['active'])) {
            if (!is_array($this->bulk_actions)) {
                $this->bulk_actions = array();
            }

            $this->bulk_actions = array();
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
        $helper->actions = [];
        $helper->bulk_actions = [];
        $helper->is_cms = $this->is_cms;
        $helper->sql = $this->_listsql;
        $helper->simple_header = true;
        $list = $helper->generateList($this->_list, $this->fields_list);

        return $list;
    }

}
