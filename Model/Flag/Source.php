<?php

namespace Hevelop\CustomOrdersGrid\Model\Flag;

use Magento\Framework\Data\OptionSourceInterface;

/**
 * Class Source
 *
 * @package   Hevelop\CustomOrdersGrid\Model\Flag
 * @author    Yuriy Boyko <yuriy@hevelop.com>
 * @license   https://opensource.org/licenses/osl-3.0.php Open Software License
 */
class Source implements OptionSourceInterface
{

    /**
     * Get options
     *
     * @return array
     */
    public function toOptionArray()
    {
        $availableOptions = ['1' => 'Flagged', '0' => 'Not flagged'];
        $options = [];
        foreach ($availableOptions as $key => $value) {
            $options[] = [
                'label' => $value,
                'value' => $key,
            ];
        }
        return $options;
    }
}
