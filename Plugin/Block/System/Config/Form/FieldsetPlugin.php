<?php
/**
 * Copyright © 2021 Max Mage. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MaxMage\SaveConfig\Plugin\Block\System\Config\Form;

use Magento\Config\Block\System\Config\Form\Fieldset;

/**
 * Class FieldsetPlugin
 * @package MaxMage\SaveConfig\Plugin\Block\System\Config\Form
 */
class FieldsetPlugin extends Fieldset
{

    /**
     * @param \Magento\Framework\Data\Form\Element\AbstractElement $element
     * @return string
     */
    protected function _getHeaderTitleHtml($element)
    {
        $result = parent::_getHeaderTitleHtml($element);
        $result .= "<button class='mm-save-section-config-button'>Save Config</button>";
        return $result;
    }

}