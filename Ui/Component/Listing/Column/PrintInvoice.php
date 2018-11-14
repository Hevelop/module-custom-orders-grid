<?php

namespace Hevelop\CustomOrdersGrid\Ui\Component\Listing\Column;

use \Magento\Sales\Api\OrderRepositoryInterface;
use \Magento\Framework\View\Element\UiComponent\ContextInterface;
use \Magento\Framework\View\Element\UiComponentFactory;
use \Magento\Ui\Component\Listing\Columns\Column;
use \Magento\Framework\Api\SearchCriteriaBuilder;
use \Magento\Framework\UrlInterface;

/**
 * Class PrintInvoice
 *
 * @package   Hevelop\CustomOrdersGrid\Ui\Component\Listing\Column
 * @author    Yuriy Boyko <yuriy@hevelop.com>
 * @license   https://opensource.org/licenses/osl-3.0.php Open Software License
 */
class PrintInvoice extends Column
{
    protected $_orderRepository;
    protected $_searchCriteria;
    /**
     * Url Builder
     *
     * @var \Magento\Framework\UrlInterface
     */
    protected $_urlBuilder;

    public function __construct(
        ContextInterface $context,
        UiComponentFactory $uiComponentFactory,
        OrderRepositoryInterface $orderRepository,
        SearchCriteriaBuilder $criteria,
        UrlInterface $urlBuilder,
        array $components = [],
        array $data = []
    ) {
        $this->_orderRepository = $orderRepository;
        $this->_searchCriteria = $criteria;
        $this->_urlBuilder = $urlBuilder;
        parent::__construct(
            $context,
            $uiComponentFactory,
            $components,
            $data
        );
    }

    public function prepareDataSource(array $dataSource)
    {
        if (isset($dataSource['data']['items'])) {
            foreach ($dataSource['data']['items'] as & $item) {

                $order = $this->_orderRepository->get($item["entity_id"]);
                $url = $this->getPrintUrl($order);

                if ($url) {
                    $export_status = "<a href='" . $url . "' target='_blank'>" . __('Print') . "</a>";
                } else {
                    $export_status = "<p>" . __('No invoices') . "</p>";
                }


                $item[$this->getData('name')] = $export_status;
            }
        }

        return $dataSource;
    }

    public function getPrintUrl($order)
    {
        $invoices = $order->getInvoiceCollection();
        if (count($invoices)) {
            $id = $invoices->getFirstItem()->getId();
            return $this->getUrl('sales/order_invoice/print', ['invoice_id' => $id]);
        }


        //url https://www.website.com/admin/sales/order_invoice/print/invoice_id/1234/

        return false;

    }

    /**
     * Generate url by route and parameters
     *
     * @param   string $route
     * @param   array  $params
     *
     * @return  string
     */
    public function getUrl($route = '', $params = [])
    {
        return $this->_urlBuilder->getUrl($route, $params);
    }
}