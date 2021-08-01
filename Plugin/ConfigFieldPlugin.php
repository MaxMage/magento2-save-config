<?php
/**
 * Copyright © 2021 Max Mage. All rights reserved.
 * See LICENSE.txt for license details.
 */

declare(strict_types=1);

namespace MaxMage\SaveConfig\Plugin;

use Magento\Config\Model\Config\Structure\Element\Field as Subject;

/**
 * Class ConfigFieldPlugin
 * @package MaxMage\SaveConfig\Plugin
 */
class ConfigFieldPlugin
{

    /**
     * @param Subject $subject
     * @param $result
     * @param string $currentValue
     * @return string
     */
    public function afterGetComment(Subject $subject, $result, $currentValue = '')
    {
        if (!in_array($subject->getType(), ['select', 'text', 'textarea'])){
            return $result;
        }
        if (strlen(trim($result))) {
            $result .= '<br />';
        }
        $result .= '<button type="button" data-path="' . $this->getPath($subject) . '" class="mm-save-config-button" title="Save config to the env.php" onclick="saveAjax()">Save Config</button>';
        return $result;
    }

    /**
     * @param Subject $subject
     * @return string
     */
    private function getPath(Subject $subject)
    {
        return $subject->getConfigPath() ?: $subject->getPath();
    }
}
