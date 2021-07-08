<?php
namespace DanilLozenko\SmartSearch\Block;
use \Magento\Framework\View\Element\Template\Context;
use \DanilLozenko\SmartSearch\Helper\Search\Config as Configuration;

/**
 * Class Config
 * @package DanilLozenko\SmartSearch\Block
 */
class Config extends \Magento\Framework\View\Element\Template
{

    /**
     * @var Configuration
     */
    private $configuration;

    /**
     * @param Context $context
     * @param Configuration $configuration
     * @param array $data
     */
    public function __construct(
        Context $context,
        Configuration $configuration,
        array $data = []
    )
    {
        $this->configuration = $configuration;
        parent::__construct($context, $data);
    }

    /**
     * @return int
     */
    public function getIsEnable() : int
    {
        return (int)$this->configuration->isEnabled();
    }

    /**
     * @return int
     */
    public function getIsShowPrice() : int
    {
        return (int)$this->configuration->isShowPrice();
    }

}
