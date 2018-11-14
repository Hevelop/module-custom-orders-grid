<?php
namespace Hevelop\CustomOrdersGrid\Controller\Adminhtml\Orders;

/**
 * Class UpdateFlag
 *
 * @package   Hevelop\CustomOrdersGrid\Controller\Adminhtml\Orders
 * @author    Yuriy Boyko <yuriy@hevelop.com>
 * @license   https://opensource.org/licenses/osl-3.0.php Open Software License
 */
class UpdateFlag extends \Magento\Backend\App\Action
{
    /**
     * @var \Magento\Sales\Model\OrderFactory
     */
    private $orderFactory;

    /** @var \Magento\Framework\Controller\Result\JsonFactory */
    protected $jsonResultFactory;

    /**
     * https://www.website.com/admin/customordersgrid/orders/updateFlag
     *
     *
     */
    public function execute()
    {
        /** @var \Magento\Framework\Controller\Result\Json $result */
        $result = $this->jsonResultFactory->create();
        $orderId = $this->getRequest()->getParam('order_id');
        if ($orderId) {
            /** @var \Magento\Sales\Model\Order $order */
            $order = $this->getOrder($orderId);
            if ($order->getId()) {
                if ($order->getFlagOrder()) {
                    $order->setFlagOrder(0);
                    $order->save();
                    $result->setData(['message' => '<span>' . __('Flag') . '</span>']);

                } else {
                    $order->setFlagOrder(1);
                    $order->save();
                    $result->setData(['message' => '<span>' . __('Un-Flag') . '</span>']);
                }
                $result->setHttpResponseCode(\Magento\Framework\Webapi\Rest\Response::HTTP_OK);
                return $result;
            } else {
                $result->setHttpResponseCode(\Magento\Framework\Webapi\Exception::HTTP_BAD_REQUEST);
                $result->setData(['message' => __('Error: Order id does not exist')]);
                return $result;
            }
        }


        $result->setHttpResponseCode(\Magento\Framework\Webapi\Exception::HTTP_BAD_REQUEST);
        $result->setData(['message' => __('Error: Wrong params')]);
        return $result;

    }


    public function __construct(
        \Magento\Backend\App\Action\Context $context,
        \Magento\Sales\Model\OrderFactory $orderFactory,
        \Magento\Framework\Controller\Result\JsonFactory $jsonResultFactory
    ) {
        $this->orderFactory = $orderFactory;
        $this->jsonResultFactory = $jsonResultFactory;
        parent::__construct($context);
    }


    public function getOrder($id)
    {

        $model = $this->orderFactory->create();
        return $model->load($id);

    }
}