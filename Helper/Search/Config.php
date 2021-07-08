<?php
namespace DanilLozenko\SmartSearch\Helper\Search;

use Magento\Framework\App\Helper\AbstractHelper;
use Magento\Framework\App\Helper\Context;
use Magento\Framework\App\Config as CoreConfig;

/**
 * Class Config
 * @package DanilLozenko\SmartSearch\Helper\Search
 */
class Config extends AbstractHelper
{

    /**
     * @var CoreConfig
     */
    public $coreConfig;

    /**
     * Construct
     *
     * @param Context $context
     * @param CoreConfig $coreConfig
     */
    public function __construct(
        Context $context,
        CoreConfig $coreConfig
    ) {
        $this->coreConfig = $coreConfig;
        parent::__construct($context);
    }

    /**
     * @return int
     */
    public function getLimit() : int
    {
        return (int)$this->coreConfig->getValue('DanilLozenko_smartsearch/general/limit');
    }

    /**
     * @return boolean
     */
    public function isEnabled() : bool
    {
        return (bool)$this->coreConfig->getValue('DanilLozenko_smartsearch/general/enabled');
    }

    /**
     * @return boolean
     */
    public function isShowPrice() : bool
    {
        return (bool)$this->coreConfig->getValue('DanilLozenko_smartsearch/general/show_price');
    }

}
