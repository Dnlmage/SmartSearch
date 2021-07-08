<?php
namespace DanilLozenko\SmartSearch\Controller\Ajax;

use \Magento\Framework\App\Action\HttpGetActionInterface as HttpGetActionInterface;
use \Magento\Framework\App\Action\Action;
use \Magento\Framework\App\Action\Context;
use \Magento\Framework\Controller\ResultFactory;
use \Magento\Catalog\Api\ProductRepositoryInterface;
use \Magento\Directory\Model\Currency;
use \DanilLozenko\SmartSearch\Model\SmartSearchRepository;


/**
 * Class Suggest
 * @package DanilLozenko\SmartSearch\Controller\Ajax
 */
class Suggest extends Action implements HttpGetActionInterface
{

    /**
     * @var ProductRepositoryInterface
     */
    protected $productRepository;

    /**
     * @var Currency
     */
    protected $currency;

    /**
     * @var SmartSearchRepository
     */
    protected $smartSearchRepository;

    /**
     * @param \Magento\Framework\App\Action\Context $context
     * @param \Magento\Catalog\Api\ProductRepositoryInterface $productRepository
     * @param \Magento\Directory\Model\Currency $currency
     * @param \DanilLozenko\SmartSearch\Model\SmartSearchRepository $smartSearchRepository
     */
    public function __construct(
        Context $context,
        ProductRepositoryInterface $productRepository,
        Currency $currency,
        SmartSearchRepository $smartSearchRepository
    ) {
        $this->productRepository = $productRepository;
        $this->currency = $currency;
        $this->smartSearchRepository = $smartSearchRepository;
        parent::__construct($context);
    }

    /**
     * @return \Magento\Framework\App\ResponseInterface|\Magento\Framework\Controller\Result\Json|\Magento\Framework\Controller\ResultInterface
     * @throws \Magento\Framework\Exception\NoSuchEntityException
     */
    public function execute()
    {
        $requestData = explode(';', $this->getRequest()->getParam('q', false));
        $serachText = $requestData[0];
        $serachCategory = $requestData[1];
        $serchResult = [];

        $searchResult = $this->smartSearchRepository->getDataForSearch($serachText, $serachCategory);

        foreach ($searchResult as $product) {
            $loadedProduct = $this->productRepository->get($product['sku']);
            $specialPrice = ($loadedProduct->getPriceInfo()->getPrice('special_price')->getAmount()->getValue());
            $serchResult[] = ['title' => $product['name'],
                'image' => $product['image'],
                'price' => $loadedProduct->getPriceInfo()->getPrice('final_price')->getAmount()->getValue(),
                'special_price' => ($specialPrice) ? $specialPrice : 0,
                'currency_symbol' => $this->currency->getCurrencySymbol()
            ];
        }

        $resultJson = $this->resultFactory->create(ResultFactory::TYPE_JSON);
        $resultJson->setData($serchResult);

        return $resultJson;
    }
}
