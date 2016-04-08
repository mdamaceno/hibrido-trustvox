<?php

class Trustvox_Sales_Helper_Data extends Mage_Core_Helper_Abstract
{
    public function mostrarEstrelas($id){
        $mostrar = Mage::getStoreConfig('trustvox_options/configuracoes/mostrar_estrelas');

        $html = '';
        if($mostrar == 'sim'){
            $html .= '<style type="text/css">';
                $html .= '.trustvox-widget-rating .ts-shelf-container,';
                $html .= '.trustvox-widget-rating .trustvox-shelf-container{';
                $html .= 'display: inline-block;';
            $html .= '}';
            $html .= '.trustvox-widget-rating span.rating-click-here{';
                $html .= 'top: -3px;';
                $html .= 'display: inline-block;';
                $html .= 'position: relative;';
                $html .= 'color: #DAA81D;';
            $html .= '}';
            $html .= '.trustvox-widget-rating:hover span.rating-click-here{';
                $html .= 'text-decoration: underline;';
            $html .= '}';
            $html .= '</style>';

            $html .= '<a class="trustvox-fluid-jump trustvox-widget-rating" href="#trustvox-reviews" title="Pergunte e veja opiniões de quem já comprou">';
                $html .= '<div class="trustvox-shelf-container" data-trustvox-product-code="'. $id .'" data-trustvox-should-skip-filter="true" data-trustvox-display-rate-schema="true"></div>';
            $html .= '</a>';
        }

        return $html;
    }
}
