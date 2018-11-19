<?php

namespace Hevelop\CustomOrdersGrid\Ui\Component\Listing\Column;

use \Magento\Sales\Api\OrderRepositoryInterface;
use \Magento\Framework\View\Element\UiComponent\ContextInterface;
use \Magento\Framework\View\Element\UiComponentFactory;
use \Magento\Ui\Component\Listing\Columns\Column;
use \Magento\Framework\Api\SearchCriteriaBuilder;
use \Magento\Framework\UrlInterface;

/**
 * Class FlagOrder
 *
 * @package   Hevelop\CustomOrdersGrid\Ui\Component\Listing\Column
 * @author    Yuriy Boyko <yuriy@hevelop.com>
 * @license   https://opensource.org/licenses/osl-3.0.php Open Software License
 */
class FlagOrder extends Column
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
                $flag = $order->getData("flag_order");
                $onclick = "window.ajaxOrderFlag(this);";
                if ($flag) {
                    $export_status = "<a class='flagged' onclick='" . $onclick . "' data-ajax='" . $this->getFlagUrl($order, $flag) . "' href='javascript:void(0)' ><span>" . __('Un-Flag') . "</span></a>";
                } else {

                    $export_status = "<a onclick='" . $onclick . "' data-ajax='" . $this->getFlagUrl($order, $flag) . "' href='javascript:void(0)' ><span>" . __('Flag') . "</span></a>";
                }


                $item[$this->getData('name')] = $export_status;
            }
        }

        return $dataSource;
    }

    public function getFlagUrl($order, $flag)
    {
        if ($flag) {
            return $this->getUrl('customordersgrid/orders/updateFlag', ['order_id' => $order->getId()]);
        }
        return $this->getUrl('customordersgrid/orders/updateFlag', ['order_id' => $order->getId()]);

//        https://www.website.loc/admin/customordersgrid/orders/updateFlag
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