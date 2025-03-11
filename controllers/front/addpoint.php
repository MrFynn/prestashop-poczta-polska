<?php

class PocztapolskaenAddpointModuleFrontController extends ModuleFrontController
{
    /**
     * metoda umożliwiajaca wyswietlenie widoku dla controllera
     */
    public function initContent() {
    {
    public function initContent() {
    }

    /**
     * metoda umowliwiajaca  wyswietlenie zadania ajax dla controllera,
     * zapisuje wybrany przez klienta punkt odbioru przez klienta
     */
    public function displayAjax()
    {

        $id_cart = Context::getContext()->cart->id;
        $ppOrder = PPOrder::findByCart($id_cart);
        $ppOrder->pni = Tools::getValue('pni');
        $ppOrder->point = Tools::getValue('point');
        $ppOrder->cod = Tools::getValue('cod');
        $ppOrder->id_carrier = Context::getContext()->cart->id_carrier;
        $ppOrder->save();

    }
}