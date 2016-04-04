<?php

class Hibrido_Trustvox_OrdersController extends Mage_Core_Controller_Front_Action {

    private function helper()
    {
        return Mage::helper('hibridotrustvox');
    }

    public function indexAction()
    {
        $this->getResponse()->clearHeaders()->setHeader('Content-type', 'application/json', true);

        if ($this->getRequest()->getHeader('trustvox-token') == $this->helper()->getToken()) {
            $counter = 0;
            $sent = 0;
            $clientArray = array();
            $productArray = array();

            $period = $this->helper()->getPeriod();

            $orders = $this->helper()->getOrdersByLastDays($period);

            $json = array();

            $i = -1;
            foreach ($orders as $order) {
                ++$i;
                $clientArray = $this->helper()->mountClientInfoToSend($order->getCustomerFirstname(), $order->getCustomerLastname(), $order->getCustomerEmail());

                $enabled = $this->helper()->checkStoreIdEnabled();
                $productArray = array();


                foreach ($order->getAllItems() as $item) {
                    /*
                 * Pula o loop se produto não for visível
                 * Isso serve para os casos de produtos configuráveis.
                 * Ao invés de trazer o produto simples junto, essa condicional o ignora.
                 * Assim, não gera manda pra Trustvox um produto que não é visível no site e,
                 * consequentemente, não possui URL.
                 */
                // if (!$item->getProduct()->isVisibleInSiteVisibility() && $item->product_type == 'simple') {
                //     continue;
                // }

                // $productArray = $this->helper()->getProductParamsToSend($item, $enabled);
                    array_push($productArray, $this->helper()->getProductParamsToSend($item, $enabled));
                }

            // Remove uma dimensão do array
            $productArray = array_map(function ($a) {
                return array_pop($a);
            }, $productArray);

            array_push($json, $this->helper()->forJSON($order->getId(), $order->getCreatedAt(), $clientArray, $productArray));
            }

            return $this->getResponse()->setBody(json_encode($json));
        } else {
            $this->getResponse()->setBody(json_encode([
                'error' => true,
                'message' => 'not authorized',
            ]));
        }
    }
}
