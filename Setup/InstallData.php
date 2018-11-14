<?php

namespace Hevelop\CustomOrdersGrid\Setup;

use Magento\Framework\Setup\InstallDataInterface;
use Magento\Framework\Setup\ModuleContextInterface;
use Magento\Framework\Setup\ModuleDataSetupInterface;
use Magento\Sales\Model\Order;

/**
 * Class InstallData
 *
 * @package   Hevelop\CustomOrdersGrid\Setup
 * @author    Yuriy Boyko <yuriy@hevelop.com>
 * @license   https://opensource.org/licenses/osl-3.0.php Open Software License
 */
class InstallData implements InstallDataInterface
{
    /**
     * @var \Magento\Sales\Setup\SalesSetupFactory
     */
    protected $salesSetupFactory;

    /**
     * @param \Magento\Sales\Setup\SalesSetupFactory $salesSetupFactory
     */
    public function __construct(
        \Magento\Sales\Setup\SalesSetupFactory $salesSetupFactory
    ) {
        $this->salesSetupFactory = $salesSetupFactory;
    }

    /**
     * {@inheritDoc}
     */
    public function install(ModuleDataSetupInterface $setup, ModuleContextInterface $context)
    {
        $installer = $setup;

        $installer->startSetup();


        $salesSetup = $this->salesSetupFactory->create(['resourceName' => 'sales_setup', 'setup' => $installer]);

        $salesSetup->addAttribute(Order::ENTITY, 'flag_order', [
            'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
            'visible' => false,
            'nullable' => false,
            'default' => 0,
        ]);

        $installer->getConnection()->addColumn(
            $installer->getTable('sales_order_grid'),
            'flag_order',
            [
                'type' => \Magento\Framework\DB\Ddl\Table::TYPE_SMALLINT,
                'comment' => 'Order Flag',
                'nullable' => false,
                'default' => 0,
            ]
        );


        $installer->endSetup();
    }
}