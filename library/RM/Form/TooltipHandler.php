<?php

namespace RM\Form;

$path = '../data/tooltips/FormTooltips.php';
include_once($path);

/**
 * TooltipHandler will add each element its proper tooltip
 *
 * @author Csabi
 */
class TooltipHandler {
    
    public function getFieldTooltip($formName, $fieldId) {
        global $tooltips;
        return $tooltips[$formName][$fieldId];
    }

}