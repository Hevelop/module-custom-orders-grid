<?php

namespace Hevelop\CustomOrdersGrid\Helper;

use Magento\Framework\App\Helper\AbstractHelper;

/**
 * Class Data
 *
 * @package   Hevelop\CustomOrdersGrid\Helper
 * @author    Yuriy Boyko <yuriy@hevelop.com>
 * @license   https://opensource.org/licenses/osl-3.0.php Open Software License
 */
class Data extends AbstractHelper
{


    public function __construct(
        \Magento\Framework\App\Helper\Context $context
    ) {

        parent::__construct($context);
    }


}
